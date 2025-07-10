<?
$idx = $_REQUEST['idx'];
$ar_data = sel_query_all("shop_goods"," WHERE idx='$idx'");

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


$q = "SELECT [FIELD] FROM shop_goods_log INNER JOIN shop_goods ON shop_goods.idx=shop_goods_log.goods_idx WHERE goods_idx='$idx'";

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(shop_goods_log.idx)", $q);
$st=$pdo->prepare($sql);
$st->execute();
$total_record = $st->rowCount();


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

$st=$pdo->prepare($sql);
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
		<div class="m-t-10 m-b-10 no-print"> 
			<a href="<?=$PHP_SELF;?>?code=goods_mod1&idx=<?=$idx;?>" class="btn btn-primary m-r-10 m-b-10">상품정보수정</a>
			<!-- <a href="<?=$PHP_SELF;?>?code=goods_mod2&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상세이미지관리</a> -->
			<? if($ar_data['gtype']=='1') {	?>
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod3&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">옵션관리</a> -->
			<!-- <a href="<?=$PHP_SELF;?>?code=goods_mod7&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관리자리뷰관리</a>  -->
			<?}?>
			<? if($ar_data['gtype']=='2') {	?>
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_modsets&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">세트상품관리</a> -->
			<?}?>
            
			<a href="<?=$PHP_SELF;?>?code=goods_mod4&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관련상품관리</a>                
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod5&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관련후기상품관리</a> -->
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod6&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상품사이즈정보관리</a> -->
            <a href="<?=$PHP_SELF;?>?code=goods_mod8&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상품수정로그</a>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 수정내역</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>번호</th>

					
					<th>변경내역</th>
					<th>관리자</th>
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
					<td class="first"><?=$row[idx];?></td>
					
							
					<td style="padding:5px"><?=$row[memo];?></td>
					<td style="padding:5px"><?=$row[mem_name];?></td>
					<td><?=$row[wdate]?></td>
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