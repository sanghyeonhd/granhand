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

$q = "SELECT [FIELD] FROM shop_goods_sale WHERE 1";

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
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return goods_search();">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="85%">

				</colgroup>
				<tbody>
				<tr>
					<th>판매처</th>
					<td>
						<select class="uch" name='fid' id='id_fid'>
						<option value=''>전체보기</option>
						<?php
						$q = "select * from shop_sites";
						$q = $q ." order by idx asc";
						$st = $pdo->prepare($q);
						$st->execute();	
						while($row = $st->fetch())	{
							if(in_array($row['idx'],$ar_mempriv))	{
								if($row['idx']=$fid)	{
									echo "<option value='$row[idx]' selected>$row[sitename]</option>";	
								}
								else	{
									echo "<option value='$row[idx]'>$row[sitename]</option>";	
								}
							}
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
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>할인정책추가</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 할인정책목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>번호</th>
					<th>적용처</th>
					<th>구분</th>
					<th>할인정책명</th>
					<th>할인률</th>
					<th>할인기간</th>
					<th>할인대상</th>
					<th>적립금</th>
					<th>쿠폰</th>
					<th>등록일</th>
					<th>등록아이콘</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?
$_css_map[1] = "blue";
$_css_map[2] = "gray";
//yell 기본 속성은 없음

$_sale_name_map[1] = "신상할인";
$_sale_name_map[2] = "일반할인";
$_sale_name_map[3] = "일반할인[지정가]";
$_sale_name_map[4] = "도매타임";
//일발할인-고정가 추가예정

//할인회원
$_sale_mem_map[1] = "회원,비회원";
$_sale_mem_map[2] = "회원만";

//적립금사용유무
$_sale_point_map[1] = "지급";
$_sale_point_map[2] = "지급안함";

//쿠폰적용유무
$_sale_coupen_map[1] = "적용";
$_sale_coupen_map[2] = "적용안함";

$cou = 0;
for($is=0;$is<count($data);$is++){
	$row = $data[$is];


?>
<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
<td class="first"><?=$row['idx'];?></td>
<td>
<?=$pid_name?>
</td>
<td>
<?=$_sale_name_map[$row['stype']];?>
</td>
<Td style='text-align:left;'>&nbsp;<?=$row['subject'];?></td>
<td>
<?
if($row['stype']=='3')	{
	echo "지정가판매";
}
else	{
	echo $row['saleper']."%";
}
?>
</td>
<Td>
<?
if($row['stype']=='2' || $row['stype']=='3')
{	echo $row['sdate']." ~<br/>".$row['edate'];	}
else
{echo "등록상품 ".$row['saledays']."시간 까지";	}
?>
</td>
<td><?=$_sale_mem_map[$row['saleop1']]?></td>
<td><?=$_sale_point_map[$row['saleop2']]?></td>
<td><?=$_sale_coupen_map[$row['saleop3']]?></td>
<td><?=$row['wdate'];?></td>
<td>
<?
$ar_icon = unserialize($row['ar_icon']);
for($i=0;$i<sizeof($ar_icon);$i++)
{
	if($ar_icon[$i]!='')
	{	echo "<img src='$_imgserver/files/icon/$ar_icon[$i]'>";	}
}
?>
</td>

<tD><a class="btn btn-xs btn-primary" href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row['idx'];?>">수정</a>
	<?
	if( ($row['stype']=='2' && $row['sale_t']=='1') || $row['stype']=='3' || $row['stype']=='4')
	{
	?>
	<a class="btn btn-xs btn-primary" href="<?=$PHP_SELF;?>?code=<?=$code;?>g&idx=<?=$row['idx'];?>">상품관리</a>
	<?}?>
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