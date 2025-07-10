<?php
require_once "../inc/config_default.php";
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config.php";

$userfile = array($_FILES['upload']['name']);
$tmpfile = array($_FILES['upload']['tmp_name']);

$savedir = $_uppath."ckeditor/";
	
for($i=0;$i<sizeof($userfile);$i++){	
	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);
}

$f = explode("/",$fs[$i]);

$CKEditorFuncNum = $_REQUEST['CKEditorFuncNum'];

$redata['uploaded'] = 1;
$redata['fileName'] = $f[0];
$redata['url'] = $_imgserver."/ckeditor/".$fs[0];
$result = json_encode ($redata);
header ( 'Content-Type:application/json; charset=utf-8' );
echo $result;
exit;
?>
