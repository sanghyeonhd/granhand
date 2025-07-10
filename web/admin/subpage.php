<?php
//ini_set("display_errors", 1);
require_once "../inc/config_default.php";
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config.php";
include "adminaccess.php";
include "adminhead.php";
$code = $_REQUEST['code'];
$g_ar_mcode = explode("_",$code);


include "side_menu.php";
include "admintop.php";
include "adminlocation.php";

if(isset($_REQUEST['mode']))	{
	$mode = $_REQUEST['mode'];	
}

include "./$g_ar_mcode[0]/{$g_ar_mcode[1]}.php";
include "adminfoot.php";
?>