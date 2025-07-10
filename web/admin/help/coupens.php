<?
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_coupen"," WHERE index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='w')
{
	$cous = $_REQUEST['cous'];

	for($i=0;$i<$cous;$i++)
	{
		if ( $ar_data['isserial'] == 2 ) {
			$value[nums] = $ar_data['serialnum'];
		} else {
			$q = "SHOW TABLE STATUS WHERE name = 'shop_coupen_serial'";
			$st = $pdo->prepare($q);
			$st->Execute();
			$row = $st->Fetch();
			$folder = $row["Auto_increment"];

			$nums = "RD".$folder.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
			$value[nums] = $nums;
		}

		$value[wdate] = date("Y-m-d H:i:s", time());
		$value[coupen_idx] = $index_no;
		insert("shop_coupen_serial", $value);
		unset($value);
	}

	echo "<Script>alert('생성완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no');</script>";
	exit;
}


$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "index_no";

if ( !$sortby )
$sortby = "asc";

/* //정렬 기본 */



//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['index_no']= $index_no;


$q = "SELECT [FIELD] FROM shop_coupen_serial WHERE coupen_idx='$index_no'";


//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(index_no)", $q);
$st = $pdo->prepare($q);
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
while($row = $st->Fetch()){
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
				<h3><i class="fa fa-table"></i>시리얼생성</h3>
			</div>
			<div class="panel-content">
<form name="makeform" id="makeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
<input type='hidden' name='index_no' value='<?=$index_no;?>'>
<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tR>
					<Th>쿠폰이름</th>
					<td colspan='3'><?=$ar_data[coupenname];?></td>
				</tR>
				<tR>
					<Th>쿠폰번호생성</th>
					<td colspan='3'>
						<div class="form-inline">
						<? if($ar_data[isserial]=='1'){?>시리얼 갯수 : <input type='text' name='cous' class="form-control">개<?}?>
						<? if($ar_data[isserial]=='2'){?>시리얼 갯수 : <input type='text' name='cous' class="form-control">개 | 쿠폰번호 : <input readonly type='text' name='coupens' size='20' value="<?=$ar_data['serialnum']?>" class="form-control"><?}?>
						</div>
					</td>
				</tR>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#makeform">생성하기</button>
						<button class="btn btn-primary waves-effect waves-light" type="button" onclick="location.href='./excel/excel_down?act=serials&index_no=<?=$index_no;?>'">엑셀다운로드</button>
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
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>등록된시리얼</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 쿠폰목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>번호</th>
					<th>시리얼번호</th>
					<th>생성일</th>
					<th>사용여부</th>
				</tr>
				</thead>
<?php
for($is=0;$is<sizeof($data);$is++)	{
	$row = $data[$is];

?>

				<tr>
					<td class="first"><?=$row[index_no];?></td>
					<td><?=$row[nums];?></td>
					<Td><?=$row[wdate];?></td>
					<Td><? if($row['isuse']=='Y') { echo $row[udate];	} ?></td>
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