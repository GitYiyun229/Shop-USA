<?php

class PromotionControllersGift extends Controllers
{
    function __construct()
    {
        $this->view = 'gift';
        parent::__construct();
    }

    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        $list = $model->get_data('');

        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $ids = FSInput::get('id', array(), 'array');
        //        $id = $ids[0];
        $model = $this->model;
        $products = $model->get_all_products();
        $categories = $model->get_categories_tree();
        $maxOrdering = $model->getMaxOrdering();

        //			$tags_categories = $model->get_tags_categories();
        //			$data = $model->get_record_by_id($id);
        // data from fs_news_categories

        //			$promotion_products = $model -> get_promotion_products($data -> id);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_categories_tree();
        //			$tags_categories = $model->get_tags_categories();
        $data = $model->get_record_by_id($id);
        $products = $model->get_all_products();
        $flash_sale = $model->get_flash($id, 'fs_flash_sale');
        if (@$flash_sale->promotion_products) {
            $flash_products = $model->get_promotion_products($flash_sale->promotion_products);
        }
        //        $hot_sale = $model ->get_flash($id,'fs_hot_sale');
        //        if(@$hot_sale->promotion_products){
        //            $hot_products = $model -> get_promotion_products($hot_sale -> promotion_products);
        //        }

        // data from fs_news_categories

        //			$promotion_products = $model -> get_promotion_products($data -> promotion_products);
        //        $promotion_products = $model->get_list_promotion_products($data->promotion_products);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    } 
}
