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
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;





$q = "SELECT [FIELD] FROM shop_newmarketdb INNER JOIN shop_newbasket ON shop_newmarketdb.index_no=shop_newbasket.market_idx WHERE pdan='5'";

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(shop_newmarketdb.index_no)", $q);
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
$_sql = str_replace("[FIELD]", "shop_newmarketdb.*,goods_idx,ea", $q);

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
while($row = mysqli_fetch_array($r)){
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
				<h3><i class="fa fa-table"></i> 취소/반품요청 내역</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">
				<thead>
				<tr>
					<th><input type='checkbox' id="check_all"></th>
					<th> 주문일(결제일) </th>
					<th> 주문번호 </th>
					<th> 주문자 </th>
					<th> 공급사 </th>
					<th colspan='2'> 상품명/옵션 </th>
					<th> 수량 </th>
					<th> 상품금액 </th>
					<th> 비고 </th>
					<th> 실결제금액 </th>
					<th> 결제수단 </th>
					<th>메모</th>
					<th>단계</th>
					<th>주문처</th>
				</tr>
				</thead>
				<tbody>
<?
for($is=0;$is<count($data);$is++){
	$row = $data[$is];

	$ar_goods = sel_query("shop_goods","gname,simg1"," WHERE index_no='$row[goods_idx]'");
?>
				<tr>
					<td ><input type='checkbox' name='index' value='<?=$row['index_no'];?>'></td>
					<td >
						<?=$row['sdate'];?> <?=$row['shour'];?>
						<? if($row['indate']!='') { echo "<br />(".$row['indate']." ".$row['intime'].")";	}?>
					</td>
					<td >
						<a href="javascript:MM_openBrWindow('popup.php?code=order_nview&index_no=<?=$row[index_no];?>','order<?=$row[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><? echo date("Ym",$row['orderno'])."-".$row['index_no']; ?></a>
					</td>
					<td ><?=$row['name'];?></td>
					<td></td>
					<td><img src="<?=$_imgserver;?>/files/goods/<?=$ar_goods['simg1'];?>" style="width:60px;"></td>
					<td><?=$ar_goods['gname'];?></td>
					<td><?=$row['ea'];?>EA</td>
					
					<td style="text-align:right;"><?=number_format($rows['account']);?></td>
					<td></td>
					<td  style="text-align:right;"><?=number_format($row['use_account']);?></td>
					<td ></td>
					<td ></td>
					<td >
						<?php
					switch ($row[dan]){
						case 1 : echo "  <span class='btn_white_xs btn_white'><a>주문접수</a></span>  "; break;
						case 2 : echo "  <span class='btn_white_xs btn_red'><a>결제확인</a></span>  "; break;
						case 3 : echo "  <span class='btn_white_xs btn_yellow'><a>상품준비중</a></span>  "; break;
						case 4 : echo "  <span class='btn_white_xs btn_navy'><a>부분배송</a></span>  "; break;
						case 5 : echo "  <span class='btn_white_xs btn_blue'><a>배송중</a></span>  "; break;
						case 6 : echo "  <span class='btn_white_xs btn_emerald'><a>거래완료</a></span>  "; break;
						case 7 : echo "  <span class='btn_white_xs btn_orange'><a>반품완료</a></span>  "; break;
						case 8 : echo "  <span class='btn_white_xs btn_pink'><a>주문취소</a></span>  "; break;
					}
					if($row['gonumber']=='')	{
						echo "<br />취소요청";
					}
					else	{
						echo "<br />반품요청";
					}
				?>
					
					</td>
					<td ></td>
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
			</div>
		</div>
	</div>
</div>