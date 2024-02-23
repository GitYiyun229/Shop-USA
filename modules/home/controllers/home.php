<?php

class HomeControllersHome extends FSControllers
{
    var $module;
    var $view;

    function display()
    {
        $model = $this->model;
        global $tmpl, $config, $user;

        $categories = $model->getProductCategories();
        foreach ($categories as $item) {
            $item->products = $this->model->get_records("category_id_wrapper LIKE '%,$item->id,%' AND published = 1", "fs_products", "id, alias, name, image, category_id_wrapper, quantity, price, price_old, sold_out, is_gift, freeship, promotion_end_time, promotion_start_time", "ordering ASC", 30);
            $item->products = $this->nomalizeProducts($item->products);
        }

        $query = $model->setQuery();
        $products = $model->getProducts($query);
        $products = $this->nomalizeProducts($products);
        $total = $model->getTotal($query);
        $total = $total > 60 ? 60 : $total;

        $flashsaleProductsOriginal = $model->getFlashProducts();
        $flashsaleProducts = [];
        if (!empty($flashsaleProductsOriginal)) {
            foreach ($flashsaleProductsOriginal as $item) {
                $flashsaleProducts[$item->id] = $item;
            }

            $flashsaleProducts = array_values($flashsaleProducts);
            
            foreach ($flashsaleProducts as $item) {
                if ($item->discount_price && $item->discount_price > 0) {
                    $item->price_public = $item->discount_price;
                } else {
                    $item->price_public = round($item->price - $item->percent * $item->price / 100, -3);
                }
                $total_discount = $item->discount_quantity ?: $item->quantity;
                $item->percent_sale = $total_discount ? round($item->discount_sold / $total_discount * 100) : 0;
                $item->text_sale = FSText::_('Vừa mở bán');
                if ($item->percent_sale) {
                    $item->text_sale = "Đã bán $item->discount_sold";
                }
            }
        }

        $tmpl->assign('canonical', URL_ROOT);

        $userImage = 'images/user-icon.svg';
        $orderNew = 0;
        $orderShipping = 0;
        $orderSuccess = 0;

        if ($user->userID) {
            $userImage = $user->userInfo->image ?: 'images/user-customer-icon.svg';
            $userLevel = [
                'Đồng', 'Bạc', 'Vàng', 'Bạch kim'
            ];

            $order = $this->model->get_records("user_id = $user->userID", "fs_order", 'id, status');

            foreach ($order as $item) {
                switch ($item->status) {
                    case 0:
                        $orderNew ++;
                        break;
                    case 1:
                        $orderShipping ++;
                        break;
                    case 2:
                        $orderSuccess ++;
                        break;
                }
            }
        }

        $list_tiktok = $model->get_tiktok();

        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    public function loadMore()
    {
        $model = $this->model;
        $query = $model->setQuery();
        $products = $model->getProducts($query);
        $products = $this->nomalizeProducts($products);

        foreach ($products as $item) {
            echo $this->layoutProductItem($item);
        }
    }

    function display404()
    {
        $url = URL_ROOT;
        // $smg = "Trang này không tồn tại";
        setRedirect($url);
        global $tmpl;
        $tmpl->set_seo_special();
        include 'modules/' . $this->module . '/views/' . $this->view . '/404.php';
    }
}
