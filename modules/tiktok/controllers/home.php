<?php

class TiktokControllersHome extends FSControllers
{
	function display()
	{
		global $tmpl;
		$model = $this->model;

		$query_body = $model->set_query_body();
		$list = $model->getList($query_body);

		$total = $model->getTotal($query_body);
		$pagination = $model->getPagination($total);

		$breadcrumbs = array();
		$breadcrumbs[] = array(0 => 'Lỗ Vũ trên Tiktok', 1 => '');
	
		$tmpl->assign('breadcrumbs', $breadcrumbs);
		// $tmpl->set_seo_special('Lỗ Vũ trên Tiktok');
		$tmpl->assign('canonical', FSRoute::_('index.php?module=tiktok&view=home'));
		$tmpl->addTitle("Lỗ Vũ trên Tiktok");
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
}
