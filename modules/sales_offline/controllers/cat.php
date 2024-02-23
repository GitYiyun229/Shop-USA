<?php
/*
 * 
 */
	// controller
	
	class Sales_offlineControllersCat extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			$cat  = $model->getCategory();
//var_dump($cat);
            if (!$cat){
                $link = URL_ROOT.'404.html';
                setRedirect($link);
            }
            $cats = $model -> get_cat();
			global $tags_group;
//            $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body($cat->id);
			$news_list = $model->getNewsList($query_body);			
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
            $banner = $model->get_records('published = 1 AND category_id = 46 ', 'fs_banners', 'id, name, link, image');
//            var_dump($banner);die;
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			$breadcrumbs[] = array(0=>$cat->name, 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo

			$page = FSInput::get('page');

			$tmpl -> set_data_seo($cat,$page);
			$pa = $page?'-page'.$page:'';
			$link_canonical = FSRoute::_("index.php?module=news&view=cat&ccode=".$cat->alias."&Itemid=3").$pa;
            $tmpl -> assign ( 'canonical',$link_canonical);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
        function nextphone(){
            // call models
            $model = $this -> model;
            $pagecurrent = FSInput::get('pagecurrent');
            $limit = FSInput::get('limit');
            $id = FSInput::get('id');
            $cid = FSInput::get('cid');
//            $start = FSInput::get('start');
//            $end = FSInput::get('end');
//            $col = FSInput::get('col');
//            $col2 = FSInput::get('col2');
            $dclass = FSInput::get('dclass');
            $total_old = $pagecurrent*$limit;

            $gt =  $total_old.','.$limit;

            // $item = $this->model->getInfo($id);
//            $sticky = $model->get_records( 'published = 1','fs_sticky','*' );
            $cat_detail = $model -> get_record('published = 1 AND id='.$id,'fs_sales_offline_categories', '*');
            $cat_parent = $model -> get_record('published = 1 AND id='.$cid,'fs_sales_offline_categories', '*');
//            var_dump($cat_parent);
//            $list = $model->get_records('published = 1 AND is_hotdeal = 1 AND sale_id = '.$id.' ORDER BY sale_odering ASC Limit '.$gt.'','fs_products','id, name,sale_id,list_sale_id,image,price,h_price,discount,category_alias, category_id,alias,color_code,keyword,h_price_old,alt_images');
            $phone = $model->get_records('published = 1 AND is_sale_special != 1  AND sale_off_id = ' . $id . ' ORDER BY sale_odering ASC limit '.$gt, 'fs_products', 'id, name,sale_off_id,list_sale_off_id,image,price,h_price,h_price_old,discount, category_id,category_alias,alias,color_code,keyword,alt_images,price_off, 
                price_special, quant_off, quan_special, stdate, fndate, is_sale_special,condition_sale');

            if ($dclass == 'products' && $phone) {
                $pagecurrent = $pagecurrent - 1;
//                $banner = $model->get_records('published = 1 AND category_id = 42 order by ordering ASC Limit '.$pagecurrent.',1','fs_banners','id, name, link, image');
            }

            include 'modules/'.$this->module.'/views/'.$this->view.'/products.php';


        }
	}
	
?>