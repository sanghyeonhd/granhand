<?php
//ini_set("display_errors", 1);
require_once ("../../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_sitet.php";

if($_REQUEST['act']=='login')	{
	
	$geturl = "";
	if(isset($_REQUEST['geturl']))	{
		$geturl = $_REQUEST['geturl'];
	}

	if(isset($_SESSION['member_index'])){

		show_message(trscode('LOGIN1'),true);
		exit;
	}

	$login['form_start'] = "<form name='f_loginform' id='f_loginform' action='/exec/proc.php?act=member&han=login' method='post'><input type='hidden' name='geturl' value='$geturl'>";
	$login['form_end'] = "</form>";
	$login['no_form_start'] = "<form name='nloginform' id='nloginform' action='/exec/proc.php?act=member&han=nologin' method='POST'><input name='geturl' value='/mypage/orders.php' type='hidden' />";
	$login['no_form_end'] = "</form>";

	$tpls->assign('login', $login);	
}

if($_REQUEST['act']=='findidresult')	{
	
	$userphone = $_REQUEST['userphone'];
	$ar_data = sel_query_all("shop_member"," where cp='$userphone'");
	

	$tpls->assign('data', $ar_data);		
}

require_once "$_basedir/inc/config_sitef.php";

?>
