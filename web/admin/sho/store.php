<?php
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "index_no";

if ( !$sortby )
$sortby = "desc";

/* //정렬 기본 */


//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['se_name'] = $se_name;
$qArr['se_loca_idx'] = $se_loca_idx;
$qArr['se_lang'] = $se_lang;


$q = "SELECT [FIELD] FROM shop_intro_store WHERE 1";
if($se_name)	{
	$q .= " AND name like '%$se_name%'";
}
if($se_loca_idx)	{
	$q .= " AND loca_idx='$se_loca_idx'";
}
if($se_lang)	{
	$q .= " AND lang='$se_lang'";
}

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(index_no)", $q);
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
while($row = $st->fetch() ){
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
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>지역</th>
					<td>
						<select name='se_loca_idx'>
						<option value=''>전체</option>
						<?
						$q = "SELECT * FROM shop_intro_store_loca ORDER BY index_no ASC";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$se = "";
							if($row['index_no']==$se_loca_idx)	{
								$se = "selected";
							}
							echo "<option value='$row[index_no]' $se>$row[name]</option>";
						}
						?>
						</select>
					</td>
					<th>스토어명</th>
					<td><input type='text' class="form-control" name='se_name' value='<?=$se_name;?>'></td>
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
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>o" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>스토어정렬</a>
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>스토어등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 목록 - 총 : <?=number_format($total_record);?>건</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th> NO </th>
					<th> 지역 </th>
					<th> 매장명 </th>
					<th> 주소 </th>
					<th> 좌표 </th>
					<th> 연락처 </th>
					<th> 등록일 </th>
					<th> 최종수정 </th>
					<th> COOK배송 </th>
					<th> COOK매장운영 </th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?php
for($is=0;$is<sizeof($data);$is++)	{
	$row = $data[$is];

	$ar_loca1 = sel_query_all("shop_intro_store_loca"," WHERE index_no='$row[loca_idx1]'");
	$ar_loca2 = sel_query_all("shop_intro_store_loca"," WHERE index_no='$row[loca_idx2]'");
?>
				<Tr>
					<td><?=$row['index_no'];?></td>
					<td><?=$ar_loca1['name'];?> <?=$ar_loca2['name'];?></td>
					<td><?=$row['name'];?></td>
					<td style="text-align:left;"><?=$row['addr1'];?> <?=$row['addr2'];?></td>
					<td><?=$row['lcode1'];?> / <?=$row['lcode2'];?></td>
					<td><?=$row['phone'];?></td>
					<td><?=$row['wdate'];?></tD>
					<td><?=$row['mdate'];?></td>
					<td>
						<? 
						if($row['deliver']=='Y') {
							echo "운영";
						}	else	{
							echo "운영안함";
						}
						?>
					</td>
					<td>
						<? 
						if($row['delivermae']=='Y') {
							echo "운영";
						}	else	{
							echo "운영안함";
						}
						?>
					</td>
					<td>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&index_no=<?=$row[index_no];?>" class="btn btn-xs btn-primary">수정</a>

						<a href="https://scm.omealdang.com//exec/?act=member&han=adminlogin&index_no=<?=$row['index_no'];?>&id=<?=$g_ar_init_member['id'];?>" target="_BLANK" class="btn btn-xs btn-primary">SCM접속</a>
					</td>
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