<?php
$tpldir = $_basedir."/tpls/";
$template_dir = $tpldir.$g_ar_layout['sname'];

$compile_dir  = $tpldir."/_compiles/".$g_ar_layout['sname']."/";

if (!is_dir($compile_dir)) {
	mkdir($compile_dir, 0777, 1);
}

$defskinfile = substr($_SERVER['PHP_SELF'], 0, -4);

$tpls = new Template_;

if(!isset($_REQUEST['act']))	{
	if (!isset($G_NPAGE['loca'])) {
		$G_NPAGE['loca'] = $defskinfile;
		$G_NPAGE['skins'] = $g_ar_layout['sname'];
	}
}
else	{
	
	$ar_urls = explode("/",$G_PHP_SELF);
	$sz = sizeof($ar_urls)-2;
	

	$G_NPAGE['loca'] = $ar_urls[$sz]."/".$_REQUEST['act'];
}


$tpls_TPL = array(
	"mains" => $G_NPAGE['loca'].".htm",
	"header" => "./_common/header.htm",
	"top" => "./_common/top.htm",
	"down" => "./_common/down.htm"
);

$q = "SELECT * FROM shop_design_layout_addon where layout_idx='".$g_ar_layout['idx']."'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
	$tpls_TPL[$row['fname']] = "./_common/".$row['fname'].".htm";
}

$compile_dir = "{$compile_dir}/".$G_LANG."/";

if (!is_dir($compile_dir)) {
	mkdir($compile_dir, 0755, true);
}

$tpls->define($tpls_TPL, '', $compile_dir, $template_dir);



$g_global['siteurl'] = $G_HTTP_HOST;
$g_global['geturl'] = "";
if(isset($_REQUEST['geturl']))	{
	$g_global['geturl'] = $_REQUEST['geturl'];
}
$g_global['ismobile'] = "N";
if($G_MOBIENV->isMobile())	{
	$g_global['ismobile'] = "Y";
}
$g_global['nowurl_en'] = urlencode($G_NOWURL);
$g_global['nowurl'] = $G_HTTP_HOST;
$g_global['nowurl_nen'] = $G_NOWURL;
$g_global['nowurl_phpself'] = $G_PHP_SELF;
$g_global['nowurl_query'] = $G_QUERY_STRING;
$g_global['imgdomain'] = $_imgserver;
$g_global['site_title'] = $g_ar_init['site_title'];
$g_global['Meta_Subject'] = $g_ar_init['Meta_Subject'];
$g_global['Meta_Description'] = $g_ar_init['Meta_Description'];
$g_global['Meta_keywords'] = $g_ar_init['Meta_keywords'];
$g_global['Meta_etc'] = $g_ar_init['Meta_etc'];
$g_global['site_con'] = $g_ar_init['site_con'];
$g_global['site_conm'] = $g_ar_init['site_conm'];
$g_global['pid'] = $g_ar_init['idx'];
$g_global['fid'] = $g_ar_init['fid'];

$g_global['isapp'] = "N";
if(isset($_REQUEST['isapp']))	{
	$g_global['isapp'] = "Y";
	$_SESSION['isapp'] = "Y";
}
if($_SESSION['isapp'] == "Y")	{
	$g_global['isapp'] = "Y";
}

$g_global['usedelac_member'] = $g_ar_init['usedelac_member'];
$g_global['usedelac_nomember'] = $g_ar_init['usedelac_nomember'];
$g_global['delaccount_member_std'] = $g_ar_init['delaccount_member_std'];
$g_global['delaccount_nomember_std'] = $g_ar_init['delaccount_nomember_std'];
$g_global['delaccount_member'] = $g_ar_init['delaccount_member'];
$g_global['delaccount_nomember'] = $g_ar_init['delaccount_nomember'];
$g_global['skindir'] = $_imgserver."/skins/".$g_ar_layout['sname']."/";


if(isset($_SESSION['member_index']))	{
	
	$g_global['memislogin'] = "Y";
	
	$g_gmem = $g_ar_init_member;
	$ar_meg = sel_query_all("shop_member_grades"," where group_idx='".$g_ar_init_member['mem_type']."' and grade_id='".$g_ar_init_member['memgrade']."'");
	
	$g_gmem['memgrade'] = $ar_meg['grade_name'];
	$g_gmem['memicon'] = $_imgserver."/files/icon/".$ar_meg['icon'];
	$g_gmem['memiconl'] = $_imgserver."/files/icon/".$ar_meg['iconl'];
	$g_gmem['grade_saveper'] = $ar_meg['grade_saveper'];
	$g_gmem['grade_stand'] = $ar_meg['grade_stand'];
	$g_gmem['grade_discount'] = $ar_meg['grade_discount'];
	$g_gmem['grade_nodels'] = $ar_meg['grade_nodels'];
}
else	{
	$g_gmem = "";
	$g_global['memislogin'] = "N";

}

if(isset($_COOKIE['cookie_id']))	{
	$g_global['cookie_id'] = $_COOKIE['cookie_id'];
}


$q = "SELECT site_name,idx,site_url FROM shop_config WHERE fid='".$g_ar_init['fid']."'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{

	if(isset($row['site_mobile'])=='O' && $row['site_mobile']=='O')	{
		continue;
	}
	$tmplist[] = $row;
}
$tpls->assign('fidsites', $tmplist);
$tpls->assign('avlangs', $g_ar_lang);
$tpls->assign('curr', $g_ar_curr);
$tpls->assign('sinit', $g_ar_init);



$tpls->assign('npage', $G_NPAGE);
$tpls->assign('global', $g_global);
$tpls->assign('gmem', $g_gmem);
?>