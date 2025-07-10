<?php
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "sdate";

if ( !$sortby )
$sortby = "desc";

/* //정렬 기본 */



//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['se_sdate'] = $se_sdate;
$qArr['se_edate'] = $se_edate;

$q = "SELECT [FIELD] FROM shop_newbasket_tmp WHERE 1";
if($se_sdate)	{
	$q = $q . " AND LEFT(sdate,10)>='$se_sdate'";
}
if($se_edate)	{
	$q = $q . " AND LEFT(sdate,10)<='$se_edate'";
}

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(idx)", $q);
$st = $pdo->prepare($sql);
$st->execute();
$tmps = $st->fetch();
$total_record = $tmps[0];


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
				<h3><i class="fa fa-table"></i> 날짜검색</h3>
			</div>
			<div class="panel-content">
				<form id="searchform" name="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tR>
					<th>날짜</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='se_sdate' id='se_sdate' value='<?=$se_sdate;?>' readonly> ~ <input type='text' class="form-control" name='se_edate' id='se_edate' value='<?=$se_edate;?>' readonly>
						</div>
					</td>
				</tR>
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
				<h3><i class="fa fa-table"></i> 장바구니목록 - 총 : <?=number_format($total_record);?></h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>번호</th>
					<th>이미지</th>
					<th>상품명</th>
					<th>옵션</th>
					<th>수량</th>
					<th>고객</th>
					<th>판매가</th>
					<th>저장일</th>
					
				</tr>
				</thead>
<?php
for($is=0;$is<sizeof($data);$is++)	{
	$row = $data[$is];

	$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");
	$img = showimg($ar_goods,60,60);
?>

				<tr>
					<td class="first"><?=$row['idx'];?></td>
					<td><img src="<?=$img;?>" style="width:60px;"></td>
					<Td><a href="/shop?act=view&idx=<?=$ar_goods['idx'];?>" target="_BLANMK"><?=$ar_goods['gname'];?></a></td>
					<td>
						<?php
						if($row['op1']!='')	{
							$ar_ops = sel_query_all("shop_goods_op1"," WHERE idx='$row[op1]'");
							echo $ar_ops['opname'];
						}
						if($row['op2']!='')	{
							$ar_ops = sel_query_all("shop_goods_op2"," WHERE idx='$row[op2]'");
							echo " / ".$ar_ops['opname'];
						}
						if($row['op3']!='')	{
							$ar_ops = sel_query_all("shop_goods_op3"," WHERE idx='$row[op3]'");
							echo " / ".$ar_ops['opname'];
						}
						?>
					</td>
					<td><?=$row['ea'];?></td>
					<td>
						<?php
						if($row['mem_idx']!=0)	{
							$ar_m = sel_query("shop_member","idx,name,id,memgrade"," WHERE idx='$row[mem_idx]'");
							echo $ar_m['name'];
						}
						else	{
							echo "비회원";
						}
						?>
					</tD>
					<td style='text-align:right;'><?=number_format($ar_goods['account']/100);?></td>
					<td><?=$row['sdate'];?></td>
				</tr>
<?php
}
?>
				</tbody>
				</table>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div>
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