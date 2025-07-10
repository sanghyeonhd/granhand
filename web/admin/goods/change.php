<?
$se_sdate = $_REQUEST['se_sdate'];
$se_edate = $_REQUEST['se_edate'];

$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "idx";

if ( !$sortby )
$sortby = "desc";

//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['sdate'] = $sdate;
$qArr['edate'] = $edate;
$qArr['key'] = $key;
$qArr['keyword'] = $keyword;
$qArr['cate'] = $cate;

$q = "SELECT [FIELD] FROM shop_goods_log INNER JOIN shop_goods ON shop_goods.idx=shop_goods_log.goods_idx WHERE 1";
if($sdate)	{
	$q = $q . " AND wdate>='".$sdate." 00:00:00'";
}
if($edate)	{
	$q = $q . " AND wdate<='".$edate." 23:59:59'";
}
if($keyword)	{
	$q = $q . " AND gname like '%$keyword%'";
}
if($cate)	{
	$q = $q . " AND shop_goods.idx IN (select distinct(goods_idx) from shop_goods_cate where catecode='$cate')";
}
//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(shop_goods_log.idx)", $q);
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
$_sql = str_replace("[FIELD]", "shop_goods_log.*,gname", $q);

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
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form id="searchform" name="searchform" action="<?=$G_PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th> 변경일 </th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' class="form-control" name='sdate' size='10' value='<?=$sdate;?>' id='se_sdate' readonly> ~ 	<input type='text' class="form-control" name='edate' size='10' value='<?=$edate;?>' id='se_edate' readonly>
						
						</div>
					</td>
				</tr>
				<tr>
					<th>카테고리</th>
					<td>
						<select class="uch" name='cate'>
						<option value=''>소속메뉴</option>
<?php
$q = "SELECT * FROM shop_cate order by catecode";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
	
	$se = "";
	if($row['catecode']==$cate)	{
		$se = "selected";	
	}
	$catecode_len = strlen($row['catecode']);
	if($catecode_len==2)	{
		$first=$row['catename'];
		echo "<option value='$row[catecode]' $se>$row[catename]</option>";
	}
	else if($catecode_len==4){
		$second=$row['catename'];
		echo "<option value='$row[catecode]' $se>$first > $row[catename]</option>";
	}
	else if($catecode_len==6)	{
		echo "<option value='$row[catecode]' $se>$first > $second > $row[catename]</option>";	
	}
}
?>
						</select>
					</td>

					<th>기타조건</th>
					<td>
						<div class="form-inline">
						<select class="uch" name='key'>
						<option value='gname' <? if($key=='gname') { echo "selected"; } ?>>상품명</option>
						</select>
						<input type='text' class="form-control" name='keyword' value="<?=$keyword;?>" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }">
						</div>
					</tD>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>번호</th>
					<th>IMG</th>
					<th>상품명</th>
					<th>관리자</th>
					<th>변경내역</th>
					<th>변경일</th>
				</tr>
				</thead>
				<tbody>
<?
$cou = 0;
for($is=0;$is<count($data);$is++){
	$row = $data[$is];
?>
				<tr>
					<td class="first"><?=$row['idx'];?></td>
					<td><? if($row['simg1']!=''){?><a href="/shop/view.php?idx=<?=$row['goods_idx'];?>" target="_blank"><img src="<?=$_imgserver;?>/files/goods/<?=$row['simg1'];?>" width='50' border="0"></a><?}?></td>
					<td><?=$row['gname'];?></td>
					<td style="padding:5px"><?=$row['mem_name'];?></td>		
					<td style="padding:5px"><?=$row['memo'];?></td>
					<td><?=$row['wdate']?></td>
				</tr>
<?
}
?>
				</tbody>
				</table>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div><!-- // .list_wrap -->
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#se_sdate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#se_edate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>