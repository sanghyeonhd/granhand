<?php	include "./common/order_list_q.php";	?>
<?php	include "./common/order_search.php";	?>
<script>
function set_chk(obj)	{
	
	if($(obj).is(":checked"))	{
		$(".index").prop("checked",true);
	}
	else	{
		$(".index").prop("checked",false);
	}

}
function down_chk()	{
	
	var idxs = '';
	$(".index").each(function()	{
		
		if($(this).is(":checked"))	{
			idxs = idxs + $(this).val() + '|R|';
		}
		
	});

	location.href='./excel/excel_down.php?act=gofile2&idxs='+idxs
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="#none" onclick="down_chk();" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>체크항목다운</a>
			<a href="./excel/excel_down.php?act=gofile" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>미배송내역다운</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 주문목록 - 검색건수 총 : <?=number_format($total_record);?> 건</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">
				<thead>
				<tr>
					<th><input type='checkbox' onclick="set_chk(this);"></th>
					<th> 주문일(결제일) </th>
					<th> 주문번호 </th>
					<th> 주문자 </th>
					<th> 공급사 </th>
					<th colspan='2'> 상품명/옵션 </th>
					<th> 수량 </th>
					<th> 상품금액 </th>
					<th> 배송정보/기타 </th>
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

	if($se_in_idx)	{
		$qs = "SELECT shop_newbasket.* FROM shop_newbasket INNER JOIN shop_goods ON shop_newbasket.goods_idx=shop_goods.idx WHERE market_idx='$row[idx]' AND in_idx='".$se_in_idx."' ORDER BY shop_newbasket.idx ASC";
	}
	else	{
		$qs = "SELECT * FROM shop_newbasket WHERE market_idx='$row[idx]' ORDER BY idx ASC";
	}
	
	$sts = $pdo->prepare($qs);
	$sts -> execute();
	$isits = $sts->rowCount();
	$cou = 0;
	while($rows = $sts->fetch())	{

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
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'><input type='checkbox' name='index' class="index" value='<?=$row['idx'];?>'></td><?}?>
					<? if($cou==0) { ?>
					<td rowspan='<?=($isits+2);?>'>
						<?=$row['sdate'];?> <?=$row['shour'];?>
						<? if(substr($row['incdate'],0,10)!='0000-00-00') { echo "<br />(".$row['incdate'].")";	}?>
					</td>
					<?}?>
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'>
						<a href="javascript:MM_openBrWindow('popup.php?code=order_nview&idx=<?=$row[idx];?>','order<?=$row[idx];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><? echo date("Ymd",$row['orderno'])."-".$row['idx']; ?></a>
					</td><?}?>
					<? if($cou==0) { ?>
					<td rowspan='<?=($isits+2);?>'>
						<a href="#none" onclick="show_member(<?=$row['mem_idx'];?>);">
						<?=$row['name'];?>
						<? 
						if($row['mem_idx']=='0') { echo "[비회원]";	} 
						else	{	
							$ar_member = sel_query("shop_member","memgrade,id,mem_type"," WHERE idx='$row[mem_idx]'");

							echo "[".$g_ar_memgrade[$ar_member['mem_type']][$ar_member['memgrade']]."]<br />";	
							echo $ar_member['id'];
						}	
						?>
						</a>
					</td><?}?>
					<td>
						<?php
						if($ar_goods['in_idx']!=0)	{
							$ar_shops = sel_query_all("shop_goods_shops"," WHERE idx='$ar_goods[in_idx]'");
							echo $ar_shops['name'];
						}
						?>
					</td>
					<td><? if($img!=''){?><img src="<?=$img;?>"><?}?></td>
					<td>
						<?=$ar_goods['gname'];?>
						<?php
						$ops = "";
						if($rows['op1']!='')	{
							$ar_ops = sel_query_all("shop_goods_op1"," WHERE idx='$rows[op1]'");
							$ops = $ar_ops['opname'];
						}
						if($rows['op2']!='')	{
							$ar_ops = sel_query_all("shop_goods_op1"," WHERE idx='$rows[op2]'");

							if($ops!='')	{
								$ops = $ops . "," .$ar_ops['opname'];
							}
							
						}
						if($rows['op3']!='')	{
							$ar_ops = sel_query_all("shop_goods_op1"," WHERE idx='$rows[op3]'");
							$ops = $ar_ops['opname'];
							if($ops!='')	{
								$ops = $ops . "," .$ar_ops['opname'];
							}
						}
						if($ops!='')	{
							echo "<p>옵션 : ".$ops."</p>";
						}
						?>
					</td>
					<td><?=$rows['ea'];?>EA</td>
					
					<td style="text-align:right;"><?=number_format($rows['account']/100);?></td>
					<td>
						<?
						if($rows['gonumber']!='')	{?>
						<a href="javascript:SearchDtdShtnonew('<?=$rows['gonumber'];?>', '<?=$rows['gocom'];?>');"><?=$rows['gocom'];?><br /><?=$rows['gonumber'];?></a><br><?=substr($rows['godate'],0,10);?><br />
						<?}?>
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
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>' style="text-align:right;">
						<?
						if($row['use_mempoint']!=0)	{
							echo "<font color='red'>"."적 : ".number_format($row['use_mempoint']/100)."<br/>"."</font>";
						}
						if($row['use_coupen1']!=0)	{
							echo "<font color='green'>"."배쿠 : ".number_format($row['use_coupen1']/100)."<br/>"."</font>";
						}
						if($row['use_coupen2']!=0)	{
							echo "<font color='blue'>"."상쿠 : ".number_format($row['use_coupen2']/100)."<br/>"."</font>";
						}
						?>
						<font color='black'>실결제 : <?=number_format($row['use_account']/100);?></font><br />
						총주문 : <?=number_format($row['account']/100);?>
						
					</td><?}?>
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'>
						<? 
							if($row['buymethod']=='C') { echo "신용카드";	}
							if($row['buymethod']=='R') { echo "계좌이체";	}
							if($row['buymethod']=='I') { echo "가상계좌";	}
						?>
					</td><?}?>
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'>
						
					</td><?}?>
					<? if($cou==0) { ?>
					<td rowspan='<?=($isits+2);?>' style="text-align:center;">
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
					<? if($cou==0) { ?><td rowspan='<?=($isits+2);?>'>
						<?=$g_ar_sitename[$row['pid']];?>
						<br />
						<?=$row['useenv'];?>
					</td><?}?>
				</tr>
<?
		$cou++;
	}
?>
				<tr>
					<td style='font-size:11px;padding:5px;text-align:left;' colspan='6'>
						<p style="line-height:1.2;margin-bottom:4px;">수령자 : <?=$row['del_name'];?></p>
						<p style="line-height:1.2;margin-bottom:4px;">일반전화 : <?=$row['del_phone'];?></p>
						<p style="line-height:1.2;margin-bottom:4px;">휴대전화 : <?=$row['del_cp'];?></p>
						<p style="line-height:1.2;margin-bottom:4px;">주소 : [<?=$row['del_zipcode'];?>] <?=$row['del_addr1'];?> <?=$row['del_addr2'];?></p>
					</td>
				</tr>
				<tr>
					<td style="font-size:11px;padding:5px;text-align:left;" colspan="6">
						<p style="line-height:1.2;margin-bottom:4px;">메모 : <?=$row['memo']?></p>
					</td>
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
