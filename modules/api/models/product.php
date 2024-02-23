<?php

class ApiModelsProduct extends FSModels
{
    function __construct()
    {
        $limit = 6;
        $page = FSInput::get('page');
        $this->limit = $limit;
        $this->page = $page;

    }

    function get_sale_product($id){
        global $db;
        $now = date('Y-m-d H:i:s');
        // $query = " SELECT discount, discount_unit, total, ordered 
		// 				 FROM fs_flash_sale_detail
		// 				 WHERE published = 1 AND product_id = $id AND date_end > '".$now."'
		// 				 ";
		$query = " 	SELECT discount, discount_unit, total, ordered 
					FROM fs_flash_sale_detail
					WHERE published = 1 AND product_id = $id AND date_end > '" . $now . "'
		";
        //$sql = $db->query($query);
        $result = $db->getObject($query);
        return $result;
    }

    function get_record_no_cache($where = '', $table_name = '', $select = '*') {
		if (! $where)
			return;
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE " . $where;
		global $db;
		//$db->query ( $query );
		$result = $db->getObject($query);
		return $result;
	}

    function get_records_no_cache($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '') {
		$sql_where = " ";
		if ($where) {
			$sql_where .= ' WHERE ' . $where;
		}
		if (! $table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . $sql_where;
		
		if ($ordering)
			$query .= ' ORDER BY ' . $ordering;
		if ($limit)
			$query .= ' LIMIT ' . $limit;
		
		global $db;
		$sql = $db->query ( $query );
		if (! $field_key)
			$result = $db->getObjectList();
		else
			$result = $db->getObjectListByKey ($field_key);
		return $result;
	}
}

?>