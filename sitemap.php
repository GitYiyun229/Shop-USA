<?php
// alert error
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

date_default_timezone_set('Asia/Ho_Chi_Minh');

header("Content-Type: application/xml;  charset=utf-8");
// inlcude libraries
require_once("libraries/fsrouter.php");

include("includes/config.php");
include("includes/functions.php");
include("includes/defines.php");
include('libraries/fsfactory.php'); 
include("libraries/database/pdo.php");
$db = new FS_PDO();
	
include("libraries/sitemap/sitemap.php");

global $config;

$sitemap = new SITEMAP();
$header = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset  xmlns="http://www.google.com/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

$xml = '';

$global_class = FSFactory::getClass('FsGlobal');
$config = $global_class -> get_all_config();
if($config['sitemap']){
	$result =explode (',',$config['sitemap']);
	for($i = 0; $i < count($result); $i ++ ){
		$xml = '
	             <url>
		             <loc>'. $result[$i].'</loc>
		             <changefreq>daily</changefreq>
		             <lastmod>2018-08-13</lastmod>
		             <priority>0.9</priority>
		           </url>  
	           ';
	}
}

echo $header;
echo $xml;
echo $sitemap->GetFeed();
?>
</urlset>