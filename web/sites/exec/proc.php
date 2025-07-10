<?
//ini_set("display_errors", 1);
require_once "../../inc/config_default.php";
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_site.php";

if(!isset($_REQUEST['act']))	{
	show_message(trscode('COMMON1'),true);
	exit;
}
if(!isset($_REQUEST['han']))	{
	show_message(trscode('COMMON1'),true);
	exit;
}

$act = $_REQUEST['act'];
$han = $_REQUEST['han'];

include "$_basedir/inc/module/sites/{$act}.php";
?>