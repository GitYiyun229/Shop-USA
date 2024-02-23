<?php
/*
 * 
 */
	// controller

	class NewsControllersAmp_news extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;

			$data = $model->getNews();

			if(!$data)
				setRedirect(URL_ROOT,'Không tồn tại bài viết này','Error');
			$ccode = FSInput::get('ccode');

			$category_id = $data -> category_id;
			$relate_news_list = $model->getRelateNewsList($category_id);

			$category = $model -> get_category_by_id($category_id);
			if(!$category)
				setRedirect(URL_ROOT,'Không tồn tại danh mục này','Error');
			global $tmpl,$module_config;
			$tmpl -> set_data_seo($data);
            

			// call views
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

	}

?>
