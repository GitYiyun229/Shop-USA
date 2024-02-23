<?php

class TiktokModelsHome extends FSModels
{
    function __construct()
    {

        parent::__construct();
        $this->limit = 12;
    }

    function set_query_body()
    {
        $where = "";
        $query = " FROM fs_tiktok WHERE published = 1 $where ORDER BY ordering DESC, id DESC ";
        return $query;
    }

    function getList($query_body)
    {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id, title, created_time, alias, tiktok";
        $query .= $query_body;
        $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;
    }

    function getTotal($query_body)
    {
        if (!$query_body)
            return;
        global $db;
        $query = "SELECT count(*)";
        $query .= $query_body;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total)
    {
        FSFactory::include_class('Pagination');
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }

    function getLoadmore($total, $pagecurrent, $detect)
    {
        FSFactory::include_class('Loadmore');
        $loadmore = new Loadmore($pagecurrent, 15, $total, $this->page);
        return $loadmore;
    }
}
