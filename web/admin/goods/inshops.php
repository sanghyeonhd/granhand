<?php
$se_numper = $_REQUEST['se_numper'] ? $_REQUEST['se_numper'] : 40;

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


//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['se_numper'] = $se_numper;
$qArr['page'] = $page;
$qArr['code'] = $code;


$q = "SELECT [FIELD] FROM shop_goods_shops WHERE 1";

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
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
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
				<tr>
					<th> 거래처그룹 </th>
					<td>
						<select class="uch" name='up_idx'>
						<option value=''>소속</option>
						<?php
						$q = "select * from shop_goods_shops_group order by gname asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() )	{
							if($up_idx==$row['idx'])	{
								echo "<option value='$row[idx]' selected>$row[gname]</option>";	
							}
							else	{
								echo "<option value='$row[idx]'>$row[gname]</option>";	
							}
						}
						?>
						</select>
					</td>
					<th> 검색조건 </th>
					<td>
						<div class="form-inline">
						<select class="uch" name='key'>
						<option value='shopname' <? if($key=='shopname') { echo "selected"; } ?>>거래처명</option>
						<option value='shopphone' <? if($key=='shopphone') { echo "selected"; } ?>>거래처전화</option>
						</select>
						<input type='text' name='keyword' class="form-control" value="<?=$keyword;?>">
						</div>
					</td>
				</tr>
				
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
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>거래처등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 거래처목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>번호</th>
					<th>소속</th>
					<th>거래처명</th>
					<th>대표자명</th>
					<th>담당자명</th>
					<th>거래처전화</th>
					<th>거래처핸드폰</th>
					<th>거래처팩스</th>
					<th>계좌정보</th>
					<th>등록상품수</th>
					<th>관련메모</th>
					<th>등록일</th>
					<th>승인여부</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?
$cou = 0;
for($is=0;$is<count($data);$is++){
	$row = $data[$is];
	$ar_group = sel_query_all("shop_goods_shops_group"," WHERE idx='$row[group_idx]'");
	$ar_mem = sel_query_all("shop_member"," WHERE idx='$row[mem_idx]'");
?>
				<tr>
					<td><?=$row['idx'];?></td>
					<td><?=$ar_group['gname'];?></td>
					<td><?=$row['name'];?></td>
					<Td><?=$row['daename'];?></td>
					<tD><?=$row['damname'];?></td>
					<td><?=$row['phone'];?></td>
					<td><?=$row['cp'];?></td>
					<td><?=$row['fax'];?></td>
					<td><?=$row['bank'];?> / <?=$row['bankaccount'];?> / <?=$row['bankname'];?></td>
					<td>
						<?
						$qs = "SELECT idx from shop_goods where in_idx='$row[idx]'";
						$sts = $pdo->prepare($qs);
						$sts->execute();
						
						$isits = $st->rowCount();

						echo number_format($isits);
						?>
					</td>
					<td>0</td>
					<td><?=$row['wdate'];?></td>
					<td>
						<?php
						if($ar_mem['canconnect']=='D')	{
							echo "승인대기";
						}
						if($ar_mem['canconnect']=='Y')	{
							echo "승인완료";
						}
						?>

					</td>
					<td>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">수정</a>

						
					</td>
				</tr>
<?
}
?>
				</tbody>
				</table>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $se_numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>