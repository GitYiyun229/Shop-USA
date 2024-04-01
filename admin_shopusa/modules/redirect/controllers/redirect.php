<?php
class RedirectControllersRedirect extends Controllers
{

    function __construct()
    {
        $this->view = 'redirect';
        parent::__construct();
    }

    function display()
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        // $categories = $model->get_categories_tree();
        // $categories = $model->get_news_categories_tree_by_permission();
        $str_cat_id = '';
        // foreach ($categories as $item) {
        //     $str_cat_id .= ',' . $item->id;
        // }
        // $str_cat_id .= ',';

        $list = $model->get_data($str_cat_id);

        $list_key = array();
        $pagination = $model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $model = $this->model;
        // $categories = $model->get_categories_tree();
        $list_key = array();
        // data from fs_news_categories
        // $categories_home = $model->get_categories_tree();
        $maxOrdering = $model->getMaxOrdering();
        // $tag = $model->get_tags();
        $uploadConfig = base64_encode('add|' . session_id());
        // $list_key = $model->get_records(' new_id = "' . $uploadConfig . '"', 'fs_news_keyword');

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        // $categories = $model->get_news_categories_tree_by_permission();
        //			$tags_categories = $model->get_tags_categories();
        $data = $model->get_record_by_id($id);
        // $news_related = $model->get_news_related($data->news_related);
        // $tag = $model->get_tags();
        // data from fs_news_categories
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
}
