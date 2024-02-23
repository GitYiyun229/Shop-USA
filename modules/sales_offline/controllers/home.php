<?php
/*
 * 
 */
	// controller
	
	class Sales_offlineControllersHome extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			

			global $tags_group;
//            $tags_group = $cat -> tags_group;
            $list_sale_parent = $model->get_records('published = 1 AND level = 0 ORDER BY ordering DESC, created_time DESC', 'fs_sales_offline_categories');

            $query_body = $model->set_query_body();
			$news_list = $model->getNewsList($query_body);
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Sales offline', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

			$page = FSInput::get('page');

			$tmpl -> set_seo_special($page);
			$pa = $page?'-page'.$page:'';
			$link_canonical = FSRoute::_("index.php?module=news&view=home&Itemid=4").$pa;
            $tmpl -> assign ('canonical',$link_canonical);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	}
	
?>