<?php
$numper = $_REQUEST['se_numper'] ? $_REQUEST['se_numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "idx";

if ( !$sortby )
$sortby = "desc";

/* //정렬 기본 */



//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;

$q = "SELECT [FIELD] FROM shop_goods_genmemo WHERE 1";

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
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>공통정보추가</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 공통정보목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>번호</th>
					<th>노출형태</th>
					<th>공통정보제목</th>
					<th>노출시작</th>
					<th>노출종료</th>
					<th>이미지</th>
					<th>링크</th>
					<th>등록일</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?
$cou = 0;
for($is=0;$is<count($data);$is++){
	$row = $data[$is];
?>
				<tr>
					<td><?=$row['idx'];?></td>
					<td>
						<?
						if($row['stype']=='1')	{
							echo "전체상품노출";
						}
						if($row['stype']=='2')	{
							echo "카테고리";
						}
						if($row['stype']=='3')	{
							echo "특정상품";
						}
					?>
					</td>
					<td><?=$row['subject'];?></td>
					<td><?=$row['sdate'];?></td>
					<td><?=$row['edate'];?></td>
					<td><? if($row['files']!='') {?><img src="<?=$_imgserver;?>/files/useinfo/<?=$row['files'];?>" style="max-width:200px;"><?}?></td>
					<Td><?=$row['links'];?></td>
					<Td><?=$row['wdate'];?></td>
					<td>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row[idx];?>" class="btn btn-xs btn-primary">수정</a>
					</td>
				</tr>
<?}?>
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
