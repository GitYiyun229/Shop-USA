<?php
// alert error
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
//error_reporting (E_ALL);

header("Content-Type: application/xml;  charset=utf-8");
// inlcude libraries
require_once("libraries/fsinput.php");
require_once("libraries/fsrouter.php");

include("includes/config.php");
include("includes/functions.php");
include("includes/defines.php");
 
include("libraries/database/mysql.php");

$db = new Mysql_DB();
	
include("libraries/rss/rss.php");
$rss = new RSS();
echo $rss->GetFeed();
?>