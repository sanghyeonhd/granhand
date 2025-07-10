<?php
$numper = $_REQUEST['se_numper'] ? $_REQUEST['se_numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "lefts_l";

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

$se_gcode = $_REQUEST['se_gcode'];

$rin_search  = strip_tags(str_replace(array("\n","\r","\n\r"),"-",$se_gcode));
$ar_r_search = explode("-",$rin_search);

$in_cau = "(";
$lcou = 0;
for($i=0;$i<sizeof($ar_r_search);$i++)	{
	if($ar_r_search[$i]!='')	{
		if($lcou>0)
		{	$in_cau = $in_cau .",";	}
		$in_cau = $in_cau . "'".trim($ar_r_search[$i])."'";
		$lcou++;
	}	
}
$in_cau = $in_cau.")";

if (!$_REQUEST['se_seasonall'] && !$_REQUEST['se_season']) {
	$seasonall = "Y";
}

if ($_REQUEST['se_seasonall']) {
	foreach ($_REQUEST['se_season'] as $value) {
		if (trim($value)) {
			$ar_season[] = $value;
		}
	}
	$seasonstr = "'".implode("', '", $ar_season)."'";
}
$ar_catestr = explode("|R|",$se_catestr);
$scate = "";
if(is_array($ar_catestr))	{
	for($i=0;$i<sizeof($ar_catestr);$i++)	{
		if($ar_catestr[$i]!='')	{
			if($scate!='')	{
				$scate = $scate . ",";	
			}
			$scate = $scate . "'".$ar_catestr[$i]."'";
			
		}
	}
}


//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['se_gcode'] = $se_gcode;
$qArr['se_account1'] = $se_account1;
$qArr['se_account2'] = $se_account2;
$qArr['se_seasonall'] = $se_seasonall;
$qArr['se_season'] = $se_season;
$qArr['se_catestr'] = $se_catestr;
$qArr['se_key']= $se_key;
$qArr['se_keyword'] = $se_keyword;

$q = "SELECT [FIELD] FROM shop_goods_lefts INNER JOIN shop_goods ON shop_goods.idx=shop_goods_lefts.goods_idx WHERE isdel='N'";
if($lcou!=0)	{
	$q .= " AND gcode IN $in_cau";
}
if($se_isopen)	{
	$q .= " AND isopen='$se_isopen'";
}
if($se_isshow)	{
	$q .= " AND isshow='$se_isshow'";
}
if($se_account1)	{
	$q .= " AND account>='$se_account1'";
}
if($se_account2)	{
	$q .= " AND account<='$se_account2'";
}
if ($se_seasonall != 'Y')	{
	if ($se_season) {
		$q .= " AND shop_goods.idx IN (SELECT goods_idx FROM shop_goods_season WHERE season_info IN ({$seasonstr}))";
	}
}
if($scate!='')	{
	$q .= " AND idx IN (SELECT distinct(goods_idx) FROM shop_goods_cate WHERE catecode IN ($scate))";
}
if($se_key && $se_keyword)	{
	$q .= " AND $se_key like '%$se_keyword%'";
}

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(shop_goods_lefts.idx)", $q);
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
$_sql = str_replace("[FIELD]", "shop_goods_lefts.*,gname,account,isopen,isshow,daccount,regi_date,opendate", $q);

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
<?php	include "./common/goods_search.php";	?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품목록</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">
				<thead>
				<tr>
					<th>번호</th>
					<th>IMG</th>
					<th>상품명</th>
					<th>옵션</th>
					<th>소진</th>
					<th>판매/원가</th>
					<th>현재고</th>
					<th>합산</th>
					<th>미발</th>
					<th>현재고-미발</th>
					<th>판매시작</th>

					<th>판매여부</th>
					<th>거래처</th>
					<th>위치</th>
					<th>바코드</th>
					<th>노출메뉴</th>

			
					<th></th>
				</tr>
				</thead>
				<tbody>
<?php
$article_num = $total_record - (($page-1)*$numper);
$cou = 0;
for($i=0;$i<count($data);$i++){
	$row = $data[$i];
	$co = "";
	if(!($cou%2)) $co = "gray";
?>
				<Tr class='<?=$co;?>'>
				<Td class="first"><?=$row['idx'];?></td>
				<td><? if($row['simg1']!=''){?><a href="<?=$_defaultsite;?>/shop/view.php?idx=<?=$row['goods_idx'];?>" target="_blank"><img src="<?=$_imgserver;?>/files/goods/<?=$row['simg1'];?>" width='50' border="0"></a><?}?></td>
				<td><a href="<?=$_defaultsite;?>/shop/view.php?idx=<?=$row['goods_idx'];?>" target="_blank"><?=$row['gname'];?></a></td>
				<td>
				
				</tD>
				<Td>
				
				</td>
				<td style="text-align:right;padding-right:5px">
					<?=number_format($row['account']/100);?>원
				</td>
				<td><?=$row['lefts_l'];?></tD>
				<td style="text-align:right;padding-right:5px">
					<?=number_format($row['account']/100*$row['lefts_l']);?>원
				</td>
				<td>
				
				</td>
				<td>
					
				</tD>
				<td><?=substr($row['regi_date'],0,10);?><br><br><? if($row['isopen']!='1') { echo substr($row['opendate'],0,10);	}?></td>
				<Td>
					<span style="color:red">
					<? if($row['isopen']=='2') { echo "<font color='blue'>";	} ?><?=$ar_isdan[$row['isopen']];?><? if($row['isopen']=='2') { echo "</font>";	}?><br/>
					</span>
					<span  style="color:red">
					<? if($row['isshow']=='Y') { echo "<font color='blue'>";	} ?><?=$ar_isshow[$row['isshow']];?><? if($row['isopen']=='Y') { echo "</font>";	}?>	
					</span>
				</td>
				<td>
				<?php
				if($row['in_idx']!='0')
				{

					$ar_shop = sel_query_all("shop_goods_shops"," where idx='$row[in_idx]'");
					$ar_up = sel_query_all("shop_goods_shops_group"," where idx='$ar_shop[upcate]'");
					echo $ar_shop['shopname'];
					echo "<br />".$ar_shop['shopphone'];
				}
				?>
				</td>
				<td>
	
	</td>
	<td></td>
	<td  style='text-align:left;font-size:11px;padding-left:10px;'>
		
		
		</td>
		<td></td>
				</tR>
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
