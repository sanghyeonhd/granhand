<?php
//ini_set("display_errors", 1);
require_once "../../inc/config_default.php";
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config.php";


$act = $_REQUEST['act'];
$han = $_REQUEST['han'];

include "$_basedir/inc/module/admin/{$act}.php";
?>
