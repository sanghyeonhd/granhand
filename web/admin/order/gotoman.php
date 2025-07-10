<?php
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$gonumber = $_REQUEST['gonumber'];
	$basket_idx = $_REQUEST['basket_idx'];
	$gocom = $_REQUEST['gocom'];
	
	$ar_mas = array();

	$lcou = 0;
	for($i=0;$i<sizeof($basket_idx);$i++)	{
		
		if($gonumber[$i]!=''){
			$value['gocom'] = $gocom[$i];
			$value['gonumber'] = str_replace("-","",$gonumber[$i]);
			$value['godate'] = date("Y-m-d H:i:s");
			update("shop_newbasket",$value," WHERE idx='".$basket_idx[$i]."'");
			unset($value);

			$ar_basket = sel_query_all("shop_newbasket"," WHERE idx='".$basket_idx[$i]."'");
		
			$tcou = 0;
			$acou = 0;
			$q = "select * from shop_newbasket where market_idx='$ar_basket[market_idx]' and gtype='1'";
			$st = $pdo->prepare($q);
			$st->execute();
			while($row= $st->fetch())	{
		
				if($row[gonumber]!='' || $row[pdan]=='1')	{
					$acou++;	
				}
				$tcou++;
			}	
	
			if($tcou==$acou)	{	
				$value[dan] = '5';	
			}
			else	{	
				$value[dan] = '4';	
			}		
			update("shop_newmarketdb",$value," where idx='$ar_basket[market_idx]'");
			unset($value);
			
			if(!in_array($ar_mas,$ar_basket[market_idx]))	{
				
				$ar_mas[$lcou] = $ar_basket[market_idx];

				$lcou++;
			}

		}
	}

	for($i=0;$i<sizeof($ar_mas);$i++)	{
		
		$ar_market = sel_query_all("shop_newmarketdb"," WHERE idx='".$ar_mas[$i]."'");
		
		$gonumber = "";
		$gocom = "";
		$proname = "";
		$ea = 0;

		$q = "Select * from shop_newbasket where market_idx='".$ar_mas[$i]."' and gtype='1' order by idx asc";
		$st = $pdo->prepare($q);
		$st->execute();
		
		while($row = $st->fetch())	{
			
			if($gonumber=='')	{
				$gonumber = $row['gonumber'];
				$gocom = $row['gocom'];
				
				
				
			}
			$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");
			$ea = $ea + $row['ea'];
			
			if($proname=='')	{
				$proname = $ar_goods['gname'];
			}
			else	{
				$proname = $proname . ",".$ar_goods['gname'];
			}
		}
		
		$url = 'http://api.apistore.co.kr/kko/1/msg/tridge'; //접속할 url 입력
		
		

		$post_data["PHONE"] = str_replace("-","",$ar_market['cp']);
		$post_data["CALLBACK"] = "0266745014";
		$post_data["REQDATE"] = date("YmdHis");
		$post_data["MSG"] = "[유픽] 배송 출발\n\r안녕하세요 $ar_market[name]님.\n\r주문하신 상품이 배송출발합니다.\n\r\n\r▷날짜 : ".date("Y-m-d")."\n\r▷주문번호 : ".date("Ymd",$ar_market['orderno'])."-".$ar_market['idx']."\n\r▷상품명 : ".$proname." \n\r▷송장정보 : ".$gocom." ".$gonumber."\n\r\n\r빠르고 안전하게 배송되는 중입니다. 조금만 기다려주세요!";

		$post_data["template_code"] = "DEL01";



		$header_data = [];
		$header_data[] = 'x-waple-authorization:OTk3OC0xNTQ0Nzc2ODM1NjIyLThiODMxOTllLWJkNWMtNDIwYy04MzE5LTllYmQ1YzEyMGMzNQ==';


		$ch = curl_init(); 
	
		curl_setopt($ch, CURLOPT_URL, $url); //URL 지정하기
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt ($ch, CURLOPT_POSTFIELDSIZE, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		$res = curl_exec ($ch);


	}

	show_message("등록완료","");
	move_link("$PHP_SELF?code=$code");
	exit;
}

$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "shop_newmarketdb.idx";

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

if (!$_REQUEST['danall'] && !$_REQUEST['showdan']) {
	$danall = "Y";
}

if (isset($_REQUEST['showdan'])) {
	foreach ($_REQUEST['showdan'] as $value) {
		if (trim($value)) {
			$ar_dan[] = $value;
		}
	}
	$danstr = "'".implode("', '", $ar_dan)."'";
}


//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;

$q = "SELECT [FIELD] FROM shop_newmarketdb WHERE dan!='' AND idx IN (SELECT distinct(market_idx) FROM shop_newbasket INNER JOIN shop_goods ON shop_newbasket.goods_idx=shop_goods.idx WHERE gonumber='' and pdan='') AND LEFT(incdate,10)!='0000-00-00' AND ORDERNO!=''";

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(shop_newmarketdb.idx)", $q);
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
$_sql = str_replace("[FIELD]", "shop_newmarketdb.*", $q);

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
<script>
function set_gonumber()	{
	answer = confirm('배송내역을 저장하시겠습니까?');
	if(answer==true)	{
		$("#listform").submit();
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 미배송내역 - 검색건수 총 : <?=number_format($total_record);?> 건</h3>
			</div>
			<div class="panel-content">

				<div class="m-t-10 m-b-10 no-print" style="text-align:right;"> 
					<!-- <a href="#none" class="btn btn-xs btn-primary m-r-10 m-b-10">엑셀파일다운</a> -->
					<a href="#none" onclick="set_gonumber();" class="btn btn-xs btn-primary m-r-10 m-b-10">송장번호업데이트</a>
				</div>
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<thead>
				<tr>
					
					<th> 주문일(결제일) </th>
					<th> 주문번호 </th>
					<th> 주문자 </th>
					
					<th colspan='2'> 상품명/옵션 </th>
					<th> 수량 </th>
					<th> 상품금액 </th>
					<th> 비고 </th>
					<th>택배사</th>
					<th>송장입력</th>
					<th>메모</th>
					<th>단계</th>
					<th>주문처</th>
				</tr>
				</thead>
				<tbody>
<?
for($is=0;$is<count($data);$is++){
	$row = $data[$is];

	$qs = "SELECT shop_newbasket.* FROM shop_newbasket INNER JOIN shop_goods ON shop_newbasket.goods_idx=shop_goods.idx WHERE market_idx='$row[idx]' ORDER BY shop_newbasket.idx ASC";
	$st = $pdo->prepare($qs);
	$st->execute();	
	$isits = $st->rowCount();
	$cou = 0;
	while($rows = $st->fetch())	{
		$ar_goods = sel_query("shop_goods","gname,simg1"," WHERE idx='$rows[goods_idx]'");

		if($rows['gtype']!='5')	{
			$ar_goods = sel_query("shop_goods","gname,simg1,in_idx"," WHERE idx='$rows[goods_idx]'");

			$img = showimg($ar_goods,60,60);
		}
		else	{
			$img = "";
			$ar_goods['gname'] = "배송비";
		}

?>				
				<tr>
					
					<? if($cou==0) { ?>
					<td rowspan='<?=($isits+2);?>'>
						<?=$row['sdate'];?> <?=$row['shour'];?>
						<? if(substr($row['incdate'],10)!='0000-00-00') { echo "<br />(".$row['incdate'].")";	}?>
					</td>
					<?}?>
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'>
						<a href="javascript:MM_openBrWindow('popup.php?code=order_nview&idx=<?=$row[idx];?>','order<?=$row[idx];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><? echo date("Ymd",$row['orderno'])."-".$row['idx']; ?></a>
					</td><?}?>
					<? if($cou==0) { ?>
					<td rowspan='<?=($isits+2);?>'>
						<?=$row['name'];?>
						
					</td><?}?>
					
					<td><? if($img!=''){?><img src="<?=$img;?>"><?}?></td>
					<td><?=$ar_goods['gname'];?></td>
					<td><?=$rows['ea'];?>EA</td>
					
					<td style="text-align:right;"><?=number_format($rows['account']/100);?></td>
					<td>
						
						<?
						if($rows['pdan']=='1')	{
							echo "취소";
						}
						if($rows['pdan']=='3')	{
							echo "수거중";
						}
						if($rows['pdan']=='4')	{
							echo "수거완료";
						}
						?>
					</td>
					<td>

						<input type='hidden' name='basket_idx[]' value='<?=$rows['idx'];?>'>
						
						<select name='gocom[]' class="form-control">
						<option value=''>택배사선택</option>
						<?
						for($i=0;$i<sizeof($g_ar_deliver);$i++)	{
							echo "<option value='".$g_ar_deliver[$i]['comname']."'>".$g_ar_deliver[$i]['comname']."</option>";
						}
						?>
						</select>
						

					</td>
					<td>

						<input type='text' name='gonumber[]' value='' class="form-control">

					</td>
					
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'>
						
					</td><?}?>
					<? if($cou==0) { ?>
					<td rowspan='<?=($isits+2);?>'>
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

				?>
					
					</td>
					<?}?>
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'><?=$g_ar_sitename[$row['pid']];?></td><?}?>
				</tr>
<?
		$cou++;
	}
?>
				<tr>
					<td style='font-size:11px;padding:5px;text-align:left;' colspan='7'>
						<p style="line-height:1.2;margin-bottom:4px;">수령자 : <?=$row['del_name'];?></p>
						<p style="line-height:1.2;margin-bottom:4px;">일반전화 : <?=$row['del_phone'];?></p>
						<p style="line-height:1.2;margin-bottom:4px;">휴대전화 : <?=$row['del_cp'];?></p>
						<p style="line-height:1.2;margin-bottom:4px;">주소 : [<?=$row['del_zipcode'];?>] <?=$row['del_addr1'];?> <?=$row['del_addr2'];?></p>
					</td>
				</tr>
				<tr>
					<td style="font-size:11px;padding:5px;text-align:left;" colspan="7">
						<p style="line-height:1.2;margin-bottom:4px;">메모 : <?=$row['memo']?></p>
					</td>
				</tr>
<?
}
?>
				</tbody>
				</table>
				</form>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
