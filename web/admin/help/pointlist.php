<?php
$numper = 20;
$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "idx";

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
$qArr['group_idx'] = $group_idx;
$qArr['page'] = $page;
$qArr['code'] = $code;

$qArr['sdate'] = $sdate;
$qArr['edate'] = $edate;
$qArr['sortcol'] = $sortcol;
$qArr['sortby'] = $sortby;

$keyword = trim($keyword);



$q = "SELECT [FIELD] FROM shop_member_points WHERE 1";

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
					<th>날짜</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' name='sdate' id='sdates'  value='<?=$sdate;?>' readonly  class="form-control"> ~ <input type='text' name='edate' id='edates'  value='<?=$edate;?>' readonly  class="form-control">
						</div>
		
					</td>
					
				</tR>
				
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
				<h3><i class="fa fa-table"></i> 내역은 총 <?=number_format($total_record);?>건 입니다.</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="40" />
				</colgroup>
				<thead>
				<tr>
					<th class=kor8>NO</th>
					<th class=kor8>회원명</th>
					<th class=kor8>내역</th>
					<th class=kor8>적립액</th>
					<th class=kor8>사용액</th>
					<th class=kor8>잔액</th>
					<th class=kor8>날짜</th>
					<th class=kor8>적립율</th>
					<th class=kor8>처리자</th>
				</tr>
				</thead>
				<tbody>
<?php
for($i=0;$i<count($data);$i++)	{
	$row = $data[$i];
	
	$ar_mem = sel_query("shop_member","name,id,idx"," WHERE idx='$row[mem_idx]'");


?>
	
				<tr>
					<td class="first"><?=$row[idx];?></td>
					<td>
						<a href="javascript:MM_openBrWindow('popup.php?code=help_view&idx=<?=$ar_mem['idx'];?>','member<?=$ar_mem['idx'];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$ar_mem[name];?></a>
					</td>
					<td><?php 
						if($row['memo']=='')	{ 
							if($row['income']!=0) { 
								echo "주문번호 : $row[market_idx] 적립";	
							} else { 
								echo "주문번호 : $row[market_idx] 사용";	
							} 
						} else { 
							echo $row['memo']; 
						} 
						?>
					</td>
					<td><?=number_format($row['income']/100);?></td>
					<td><?=number_format($row['outcome']/100);?></td>
					<td><?=number_format($row['total']/100);?></td>
					<td><?=$row['wdate_s'];?> <?=$row['hour_s'];?></td>
					<td><?php if($row['giveper']!=0) { echo ($row['giveper']/100)."%";	}?></td>
					<td><?php if($row['isauto']=='Y') { echo "시스템";		}  else { echo $row['ch_name'];	}?></td>
					
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
	
});

</script>