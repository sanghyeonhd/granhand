<?php
$numper = 20;
$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "account";

if ( !$sortby )
$sortby = "DESC";
/* //정렬 기본 */

if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}

//HTTP QUERY STRING
$qArr['page'] = $page;
$qArr['code'] = $code;;
$qArr['sortcol'] = $sortcol;
$qArr['sortby'] = $sortby;
$qArr['index_no'] = $index_no;

$keyword = trim($keyword);



$q = "SELECT [FIELD] FROM shop_member_chlog_ele WHERE chlog_idx='$index_no'";


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
				<h3><i class="fa fa-table"></i> 내역 <?=number_format($total_record);?>건 입니다.</h3>
			</div>
			<div class="panel-content">


<table class="table table-bordered">
<colgroup>
	<col width="40" />
	
</colgroup>
<thead>
<tr>
<th class=kor8>NO</th>
<th class=kor8>회원정보</th>
<th class=kor8>기준금액</th>
<th class=kor8>변경전</th>
<th class=kor8>변경후</th>

</tr>
</thead>
<tbody>
<?php
for($i=0;$i<count($data);$i++)
{
	$row = $data[$i];
	
	$ar_mem = sel_query_all("shop_member"," WHERE index_no='$row[mem_idx]'");

	$ar_lg = sel_query_all("shop_member_grades"," WHERE grade_id='$row[lmemgrade]'");
	$ar_ng = sel_query_all("shop_member_grades"," WHERE grade_id='$row[memgrade]'");
?>
	
		<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
			<td class="first"><?=$row[index_no];?></td>
			<td>
				<a href="javascript:MM_openBrWindow('popup.php?code=help_view&index_no=<?=$ar_mem[index_no];?>','member<?=$ar_mem[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$ar_mem[name];?></a>
			</td>
			<td><?=number_format($row['account']);?></td>
			<td><?=$ar_lg['grade_name'];?></td>
			<td><?=$ar_ng['grade_name'];?></td>
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
			</div><!-- // .list_wrap -->
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#sdates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#sdates1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#lastorder1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#lastorder2').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>