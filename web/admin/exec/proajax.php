<?php
//ini_set("display_errors", 1);
require_once "../../inc/config_default.php";
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config.php";

//임시로추가
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$act = $_REQUEST['act'];
$han = $_REQUEST['han'];

if(!$act || !$han)	{
	$redata[res] = 'error';
	$redata[resmsg] = '잘못된접근입니다.';
	
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}

include "$_basedir/inc/module/admin/{$act}_ajax.php";
?>