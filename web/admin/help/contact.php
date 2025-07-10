<?
$mode = $_REQUEST['mode'];
if($mode=='d')	{
	
	$index_no = $_REQUEST['index_no'];

	
	$st = $pdo->prepare("DELETE FROM shop_contact WHERE index_no='$index_no'");
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
$sortcol = "index_no";

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

$q = "SELECT [FIELD] FROM shop_contact WHERE 1";

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(index_no)", $q);
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
				<h3><i class="fa fa-table"></i>목록</h3>
			</div>
			<div class="panel-content">


				
	<table class="table table-bordered">
	<colgroup>
		<col width="45px" />
	</colgroup>
	<thead>
	<tr>
		<th>No</th>
		<th>제목/내용</th>
		<th>작성자</th>
		<th>E-Mail</th>
		<th>휴대폰</th>
		<th>등록일</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
<?
$cou = 0;
for($i=0;$i<count($data);$i++){
	$row = $data[$i];

	$ar_faqcate = sel_query_all("shop_contactcate"," WHERE index_no='$row[cate_idx]'");
?>
	<tr>
		<td class="first"><?=$row[index_no];?></td>
		<td><?=$row['subject'];?><br /><br/><?=nl2br($row['memo']);?></td>
		<td><?=$row['name'];?></td>
		<td><?=$row['email'];?></td>
		<td><?=$row['cp'];?></td>
		<td><?=$row['wdate'];?></td>
		<td>
			<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&index_no=<?=$row['index_no'];?>&mode=d','삭제하시겠습니까?');" class="btn btn-xs btn-primary">삭제</a>	
		</tD>
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
