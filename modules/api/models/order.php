<?php

class ApiModelsOrder extends FSModels
{
    function __construct()
    {
        $limit = 6;
        $page = FSInput::get('page');
        $this->limit = $limit;
        $this->page = $page;

    }
}

?>