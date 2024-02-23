<?php
/*
 * Huy write
 */
	// controller
	
	class ContentsControllersContent extends FSControllers
	{
		var $module;
		var $view;
	
		function display()
		{
            $data = $this->model->get_data_content();
			$cat  = $this->model->getCategory();
 
            $list = $this->model->getList($data->category_id);

			// echo '<pre>';
			// print_r($list);
 

            global $tmpl; 
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

	}
	
?>