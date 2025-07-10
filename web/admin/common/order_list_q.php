<?php
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "idx";

if ( !$sortby )
$sortby = "desc";

/* //정렬 기본 */

if(!$fid)	{
	if($ar_memprivc==1)		{
		$fid = $ar_mempriv[0];	
	}
	else	{
		$fid = $selectfid;	
	}
}

if (!isset($_REQUEST['danall']) && !isset($_REQUEST['showdan'])) {
	$danall = "Y";
}

if ($_REQUEST['showdan']) {
	foreach ($_REQUEST['showdan'] as $value) {
		if (trim($value)) {
			$ar_dan[] = $value;
		}
	}
	$danstr = "'".implode("', '", $ar_dan)."'";
}


//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['skey'] = $skey;
$qArr['skeyword'] = $skeyword;
$qArr['danall'] = $danall;
$qArr['showdan'] = $showdan;
$qArr['sbuym'] = $sbuym;
$qArr['ismem'] = $ismem;
$qArr['datekey'] = $datekey;
$qArr['sdate'] = $sdate;
$qArr['edate'] = $edate;
$qArr['spid'] = $spid;
$qArr['se_in_idx'] = $se_in_idx;

$q = "SELECT [FIELD] FROM shop_newmarketdb WHERE dan!=''";
if($skeyword)	{
	
	
	if($skey=='mem_id')	{
		$q = $q . " AND mem_idx IN (SELECT idx from shop_member where id='$skeyword')";
	}
	else	{
		
		if($skey=='idx')	{
			$ar_kes = explode("-",$skeyword);

			if(sizeof($ar_kes)>1)	{
				$skeyword = $ar_kes[1];
			}
		}
		$q = $q . " AND $skey like '%$skeyword%'";
	}
}

if ($danall != 'Y') {
	if ($showdan) {
		$q = $q . " AND dan IN ({$danstr})";
	}
} else {
	$q = $q . " AND dan!=''";
}
if($sbuym)	{
	$q = $q . " AND buymethod='$sbuym'";
}
if($ismem=='Y')	{
	$q = $q ." AND mem_idx NOT IN ('0')";
}
if($ismem=='N')	{
	$q = $q ." AND mem_idx IN ('0')";
}
if($sdate)	{
	$q = $q ." AND $datekey>='$sdate 00:00:00'";
}
if($edate)	{
	$q = $q ." AND $datekey<='$edate 23:59:59'";
}
if($spid)	{
	$q = $q . " AND pid='$spid'";
}
if($se_in_idx)	{
	$q = $q . " AND idx IN (SELECT distinct(market_idx) FROM shop_newbasket INNER JOIN shop_goods ON shop_newbasket.goods_idx=shop_goods.idx WHERE in_idx='".$se_in_idx."')";
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
	$first = $numper*($page-1);
	$last = $numper*$page; 
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
$sql_limit = " LIMIT $first, $numper";
$sql = $_sql.$sql_order.$sql_limit;
$st = $pdo->prepare($sql);
$st->execute();
$data = [];
while($row = $st->fetch()){
	$data[] = $row;
}

//엑셀쿼리
$sql_excel = $_sql.$sql_order;
$_SESSION['sql_excel'] = $sql_excel;
?>