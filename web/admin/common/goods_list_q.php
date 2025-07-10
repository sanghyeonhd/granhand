<?php
$se_numper = isset($_REQUEST['se_numper']) ? $_REQUEST['se_numper'] : 40;

$page_per_block = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

/* 정렬 기본 */
$sortcol = isset($_REQUEST['sortcol']) ? $_REQUEST['sortcol'] : "idx";


$sortby = isset($_REQUEST['sortby']) ? $_REQUEST['sortby'] : "desc";

/* //정렬 기본 */

if(isset($_REQUEST['fid']))	{
	if($ar_memprivc==1)		{
		$fid = $ar_mempriv[0];	
	}
	else	{
		$fid = $selectfid;	
	}
}
$lcou = 0;
$se_gcode = "";
if(isset($_REQUEST['se_gcode']))	{
	$se_gcode = $_REQUEST['se_gcode'];
	$rin_search  = strip_tags(str_replace(array("\n","\r","\n\r"),"-",$_REQUEST['se_gcode']));
	$ar_r_search = explode("-",$rin_search);	
	$in_cau = "(";
	
	for($i=0;$i<sizeof($ar_r_search);$i++)	{
		if($ar_r_search[$i]!='')	{
			if($lcou>0)
			{	$in_cau = $in_cau .",";	}
			$in_cau = $in_cau . "'".trim($ar_r_search[$i])."'";
			$lcou++;
		}	
	}
	$in_cau = $in_cau.")";
}

$scate = "";
if(isset($_REQUEST['se_catestr']))	{
	
	$ar_catestr = explode("|R|",$_REQUEST['se_catestr']);
	
	if(is_array($ar_catestr))	{
		for($i=0;$i<sizeof($ar_catestr);$i++)	{
			if($ar_catestr[$i]!='')	{
				if($scate!='')	{
					$scate = $scate . ",";	
				}
				$scate = $scate . "'".$ar_catestr[$i]."'";			
			}
		}
	}
}


$se_isopen	= isset($_REQUEST["se_isopen"]) ? $_REQUEST["se_isopen"] : "";
$se_isshow	= isset($_REQUEST["se_isshow"]) ? $_REQUEST["se_isshow"] : "";


//HTTP QUERY STRING
$keyword = isset($_REQUEST["keyword"]) ? trim($_REQUEST["keyword"]) : "";
$se_in_idx = $qArr['se_in_idx'] = isset($_REQUEST["se_in_idx"]) ? trim($_REQUEST["se_in_idx"]) : "";
$qArr['se_numper'] = isset($_REQUEST["se_numper"]) ? trim($_REQUEST["se_numper"]) : "";
$qArr['page'] = isset($_REQUEST["page"]) ? trim($_REQUEST["page"]) : "";
$qArr['code'] = isset($_REQUEST["code"]) ? trim($_REQUEST["code"]) : "";
$qArr['se_gcode'] = isset($_REQUEST["se_gcode"]) ? trim($_REQUEST["se_gcode"]) : "";
$se_account1 = $qArr['se_account1'] = isset($_REQUEST["se_account1"]) ? trim($_REQUEST["se_account1"]) : "";
$se_account2 = $qArr['se_account2'] = isset($_REQUEST["se_account2"]) ? trim($_REQUEST["se_account2"]) : "";

$qArr['se_catestr'] = isset($_REQUEST["se_catestr"]) ? trim($_REQUEST["se_catestr"]) : "";
$se_md_idx  = $qArr['se_md_idx']= isset($_REQUEST["se_md_idx"]) ? trim($_REQUEST["se_md_idx"]) : "";
$se_key = $qArr['se_key']= isset($_REQUEST["se_key"]) ? trim($_REQUEST["se_key"]) : "";
$se_keyword = $qArr['se_keyword'] = isset($_REQUEST["se_keyword"]) ? trim($_REQUEST["se_keyword"]) : "";
$qArr["se_isopen"]	= $se_isopen;
$qArr["se_isshow"]	= $se_isshow;
$qArr["hanmode"] = isset($_REQUEST["hanmode"]) ? trim($_REQUEST["hanmode"]) : "";
$qArr["namefi"] = isset($_REQUEST["namefi"]) ? trim($_REQUEST["namefi"]) : "";
$qArr["idxfi"] = isset($_REQUEST["idxfi"]) ? trim($_REQUEST["idxfi"]) : "";
$se_datekey = $qArr["se_datekey"] = isset($_REQUEST["se_datekey"]) ? trim($_REQUEST["se_datekey"]) : "";
$se_sdate = $qArr["se_sdate"] = isset($_REQUEST["se_sdate"]) ? trim($_REQUEST["se_sdate"]) : "";
$se_edate = $qArr["se_edate"] = isset($_REQUEST["se_edate"]) ? trim($_REQUEST["se_edate"]) : "";


$q = "SELECT [FIELD] FROM shop_goods WHERE isdel='N'";
if($lcou!=0)	{
	$q .= " AND gcode IN $in_cau";
}
if($se_isopen)	{
	$q .= " AND isopen='$se_isopen'";
}
if($se_isshow)	{
	$q .= " AND isshow='$se_isshow'";
}
if($se_account1)	{
	$q .= " AND account>='".($se_account1*100)."'";
}
if($se_account2)	{
	$q .= " AND account<='".($se_account2*100)."'";
}

if($scate!='')	{
	$q .= " AND idx IN (SELECT distinct(goods_idx) FROM shop_goods_cate WHERE catecode IN ($scate))";
}
if($se_key && $se_keyword)	{
	$q .= " AND $se_key like '%$se_keyword%'";
}
if($se_in_idx)	{
	$q .= " AND in_idx='$se_in_idx'";
}
if(isset($_REQUEST["se_sdate"]))	{
	$q = $q . " and LEFT($se_datekey,10)>='".isset($_REQUEST["se_sdate"])."'";
}
if(isset($_REQUEST["se_edate"]))	{
	$q = $q . " and LEFT($se_datekey,10)<='".isset($_REQUEST["se_edate"])."'";
}

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(idx)", $q);
$st = $pdo->prepare($sql);
$st->execute();
$total_record = $st->fetchColumn();


if($total_record == 0) { 
	$first = 0;
	$last = 0;
} else { 
	$first = $se_numper*($page-1);
	$last = $se_numper*$page; 
}

//데이터쿼리
$_sql = str_replace("[FIELD]", "*", $q);

$_tArr = explode(",", $sortcol);
if ( is_array($_tArr) && count($_tArr) ) {
	foreach ( $_tArr as $v ) {
		$orderbyArr[] = "{$v} {$sortby}";
	}
	$orderby = implode(", ", $orderbyArr);
}

$sql_order = " ORDER BY {$orderby}";
$sql_limit = " LIMIT $first, $se_numper";
$sql = $_sql.$sql_order.$sql_limit;
$st = $pdo->prepare($sql);
$st->execute();
$data = [];
while($row = $st->fetch() ){
	$data[] = $row;
}

//엑셀쿼리
$sql_excel = $_sql.$sql_order;
$_SESSION['sql_excel'] = $sql_excel;
?>