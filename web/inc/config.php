<?php
include_once $_basedir.'/inc/function_common.php';
include_once $_basedir.'/inc/function_admin.php';

extract($_REQUEST, EXTR_OVERWRITE);


$G_NIP = $_SERVER['REMOTE_ADDR'];

$G_QUERY_STRING = $_SERVER["QUERY_STRING"];
$G_PHP_SELF = $_SERVER["PHP_SELF"];
$G_SERVER_NAME = $_SERVER["SERVER_NAME"];

if($G_QUERY_STRING)	{
	$G_NOWURL = $G_PHP_SELF . "?" . $G_QUERY_STRING; 
}
else	{
	$G_NOWURL = $G_PHP_SELF; 
}


$g_ar_isdan = array("1"=>"등록대기","2"=>"판매중","3"=>"일시품절","4"=>"품절");
$g_ar_isshow = array("Y"=>"노출","N"=>"노출안함");
$g_ar_method = array("B"=>"무통장입금","C"=>"신용카드","I"=>"가상계좌","R"=>"실시간계좌이체","Z"=>"휴대폰결제","P"=>"적립금","X"=>"예치금");

if(isset($_SESSION['member_index']))	{
	$G_MEMIDX = $_SESSION['member_index'];
	
	$g_ar_init_member = sel_query_all("shop_member"," where idx='".$G_MEMIDX."'");

	$q = "select * from shop_admin_priv where grade_id='".$g_ar_init_member['amemgrade']."'";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch() )	{
		$mckadmin[$row['code']] = true;
	}
}


$q = "SELECT * FROM shop_member_grades";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{
	$g_ar_memgrade[$row['group_idx']][$row['grade_id']] = $row['grade_name'];
}


$q = "SELECT * FROM shop_delivery_dcompany";
$st = $pdo->prepare($q);
$st->execute();
$g_ar_deliver = [];
while($row = $st->fetch() )	{
	$g_ar_deliver[] = $row;
}


$q = "SELECT * FROM shop_config";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{
	$g_ar_pid[] = $row;
	$g_ar_sitename[$row['idx']] = $row['site_name'];
}

$q = "SELECT * FROM shop_sites";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{
	$g_ar_fid[] = $row;
}

$ar_memprivc = 1;
$ar_mempriv[0] = "1";

$q = "SELECT * FROM shop_config_curr";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{
	$g_curr[] = $row;
}
?>
