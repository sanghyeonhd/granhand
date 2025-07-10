<?
$mode = $_REQUEST['mode'];
if($mode=='d')	{
	
	$idx = $_REQUEST['idx'];

	
	$st = $pdo->prepare("DELETE FROM shop_faq WHERE idx='$idx'");
	$st -> execute();

	show_message("삭제완료","");
	move_link("$PHP_SELF?code=$code");
	exit;


}
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 20;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "idx";

if ( !$sortby )
$sortby = "desc";


/* //정렬 기본 */

$keyword = trim($keyword);
//HTTP QUERY STRING
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['lang'] = $lang;
$qArr['cate_idx'] = $cate_idx;
$qArr['sortcol'] = $sortcol;
$qArr['sortby'] = $sortby;

$q = "SELECT [FIELD] FROM shop_faq WHERE 1";
if($lang)	{
	$q = $q . " AND lang='$lang'";
}
if($cate_idx)	{
	$q = $q . " AND cate_idx='$cate_idx'";
}

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(idx)", $q);
$st = $pdo->prepare($sql);
$st -> execute();
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
$st -> execute();
$data = [];
while($row = $st->fetch()){
	$data[] = $row;
}

//엑셀쿼리
$sql_excel = $_sql.$sql_order;
$_SESSION['sql_excel'] = $sql_excel;
?>
<div class="row"	>
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
				<Tr>
					<Th>카테고리</th>
					<td>
						<select class="uch" name='cate_idx' >
						<option value=''>전체보기</option>
						<?php
						$q = "Select * from shop_faqcate order by idx asc";
						$st = $pdo->prepare($q);
						$st -> execute();
						while($row = $st->fetch())	{
							if($cate_idx==$row['idx'])	{
								echo "<option value='$row[idx]' selected>$row[catename]</option>";	
							}
							else	{
								echo "<option value='$row[idx]'>$row[catename]</option>";	
							}
						}
						?>
						</select>
					</td>

					<th>언어</th>
					<td>
						<select class="uch" name='lang' style="z-index: 4;">
						<option value=''>전체보기</option>
						<?
						$q = "SELECT * FROM shop_config_lang ORDER BY idx ASC";
						$st = $pdo->prepare($q);
						$st -> execute();
						while($row = $st->fetch())	{
							$se = "";
							if($row['namecode']==$se_lang)	{
								$se = "selected";
							}
							echo "<option value='$row[namecode]' $se>$row[name]</option>";
						}
						?>
						</select>
					</td>
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
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>FAQ등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> FAQ 목록</h3>
			</div>
			<div class="panel-content">


				
	<table class="table table-bordered">
	<colgroup>
		<col width="45px" />
	</colgroup>
	<thead>
	<tr>
		<th>No</th>
		<th>언어</th>
		<th>분류</th>
		<th>제목</th>
		<th>등록일</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
<?
$cou = 0;
for($i=0;$i<count($data);$i++){
	$row = $data[$i];

	$ar_faqcate = sel_query_all("shop_faqcate"," WHERE idx='$row[cate_idx]'");
?>
	<tr>
		<td class="first"><?=$row[idx];?></td>
		<td><?=$row['lang'];?></td>
		<td><?=$ar_faqcate['catename'];?></td>
		<td><?=$row[subject];?></td>
		<td><?=$row['wdate'];?></td>
		<td>
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w&idx=<?=$row[idx];?>" class="btn btn-primary btn-xs m-r-5">수정</a>
			<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&idx=<?=$row['idx'];?>&mode=d','삭제하시겠습니까?');" class="btn btn-xs btn-primary">삭제</a>		
		</td>
	</tR>
<?
	$cou++;
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
		<!-- end panel -->
	</div>
	<!-- end col-12 -->
</div>
