<?php
include_once("$_basedir/inc/function_common.php");
include_once("$_basedir/inc/function_templete.php");
include_once("$_basedir/inc/function_site.php");

$G_NIP = $_SERVER['REMOTE_ADDR'];
$G_QUERY_STRING = $_SERVER["QUERY_STRING"];
$G_PHP_SELF = $_SERVER["PHP_SELF"];
$G_SERVER_NAME = $_SERVER["SERVER_NAME"];
$G_HTTP_HOST = $_SERVER['HTTP_HOST'];

$G_NPAGE = array();

if($G_QUERY_STRING)	{
	$G_NOWURL = $G_PHP_SELF . "?" . $G_QUERY_STRING; 
}
else	{
	$G_NOWURL = $G_PHP_SELF;
}

require_once("Mobile_Detect.php");
$G_MOBIENV = new Mobile_Detect();

if( $G_MOBIENV->isMobile() )	{
	$g_ar_domain = sel_query_all("shop_config_domain"," where domain='".str_replace("www.","",$G_HTTP_HOST)."' AND ismobi IN ('Y','A')"); 
}
else	{
	$g_ar_domain = sel_query_all("shop_config_domain"," where domain='".str_replace("www.","",$G_HTTP_HOST)."' AND ismobi IN ('N','A')");
}

$g_ar_buymethod = array("C"=>"신용카드","I"=>"가상계좌","R"=>"실시간계좌이체","P"=>"적립금","X"=>"예치금","Z"=>"휴대폰결제");


$g_ar_layout = sel_query_all("shop_design_layout"," where idx='".$g_ar_domain['skin_idx']."'");
$g_ar_init = sel_query_all("shop_config"," where idx='".$g_ar_domain['pid']."'");
$g_ar_member_config = sel_query_all("shop_member_group"," where idx='".$g_ar_init['site_member_group']."'");
$g_ar_curr = sel_query_all("shop_config_curr"," where name='".$g_ar_init['curr']."'");



$q = "SELECT * FROM shop_config_lang where isuse='Y'";
$st = $pdo->prepare($q);
$st->execute();
$g_ar_lang = [];
while($row = $st->fetch() )	{

	
	if($g_ar_init['language_use']=='2')	{
		if($row['namecode']!=$g_ar_init['language'])	{
			continue;
		}
	}

	$g_ar_lang[] = $row;
}

if(isset($_REQUEST['lang']))	{
	$_SESSION['lang'] = strtolower($_REQUEST['lang']);
	$g_global['lang'] = strtolower($_REQUEST['lang']);
}
else	{
	if(isset($_SESSION['lang']))	{
		
		$g_global['lang'] = $_SESSION['lang'];
	}
	else	{
		$_SESSION['lang'] = $g_ar_init['language'];
		$g_global['lang'] = $g_ar_init['language'];
	}
}
$G_LANG = $g_global['lang'];
$g_global['country'] = $g_ar_init['site_country'];

if(!isset($_COOKIE['cookie_view']))	{	
	setcookie("cookie_view",time().$G_NIP,time()+86400*90,"/");	
	$G_STIDX = time().$G_NIP;
}
else	{
	$G_STIDX = $_COOKIE['cookie_view'];	
}

if(isset($_SESSION['member_index']))	{

	$G_MEMIDX = $_SESSION['member_index'];
	
	$g_ar_init_member = sel_query_all("shop_member"," where idx='".$G_MEMIDX."'");
	$g_ar_init_member['mempoints'] = $g_ar_init_member['mempoints']/100;
}
else	{
	if(!isset($_COOKIE['cmem']))	{	
		$cookie_member = session_id();
		setcookie("cmem",$cookie_member,0,"/");	
	}
}



?>
