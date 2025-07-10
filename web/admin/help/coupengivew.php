<?php
$goods_idx = $_REQUEST['goods_idx'];
$sdate = $_REQUEST['sdate'];
$edate = $_REQUEST['edate'];
if(isset($goods_idx))	{
	
	$ar_goods = sel_query_all("shop_goods"," WHERE index_no='$goods_idx'");

}
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$value['mem_idx'] = $G_MEMIDX;
	$value['mem_name'] = $g_ar_init_member['name'];
	$value['coupen_idx'] = $_REQUEST['coupen_idx'];
	$coupen_idx = $_REQUEST['coupen_idx'];
	$value['goods_idx'] = $goods_idx;
	$value['sdate'] = $sdate;
	$value['edate'] = $edate;
	$value['memo'] = $_REQUEST['memo'];
	$value['amemo'] = $_REQUEST['amemo'];
	$value['wdate'] = date("Y-m-d H:i:s");
	insert("shop_coupen_log",$value);
	$index_no = $pdo->lastInsertId();
	unset($value);
	
	$coupen_idx = $_REQUEST['coupen_idx'];
	$ar_coupen = sel_query_all("shop_coupen"," where index_no='$coupen_idx'");

	$cou = 0;
	$q = "Select shop_newmarketdb.* from shop_newmarketdb INNER JOIN shop_newbasket ON shop_newmarketdb.index_no=shop_newbasket.market_idx where goods_idx='$goods_idx' and incdate BETWEEN '$sdate 00:00:00' AND '$edate 23:59:59' AND pdan='' and gonumber!='' and shop_newmarketdb.mem_idx!=0 order by shop_newmarketdb.index_no asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch() )	{
		
		make_coupen($ar_coupen,$row['mem_idx'],$index_no,$_REQUEST['amemo']);
	}

	show_message("지급완료","");
	move_link("subpage?code=sho_coupengive");
	exit;

}
function make_coupen($ar_coupen,$mem_idx,$log_idx="",$memo="")
{
	global $g_ar_init_member;

	$fids = unserialize($ar_coupen[fids]);
	
	for($i=0;$i<sizeof($fids);$i++)	{
		if($fids[$i]!='')	{
	
			$value[mem_idx] = $mem_idx;
			$value[coupen_idx] = $ar_coupen[index_no];
			$value[coupen_name] = $ar_coupen[coupenname];
			$value[mdate] = date("Y-m-d",time());
	
			if($ar_coupen[used]=='1')	{
				$value[sdate] = $ar_coupen[startdates];
				$value[edate] = $ar_coupen[enddates];
		
			}
			else	{
				if($ar_coupen[usedays]==0)	{
					$ar_coupen[usedays] = 1000;	
				}
	
				$value[sdate] = date("Y-m-d H:i:s",time());
				$value[edate] = date("Y-m-d",(time()+(86400*$ar_coupen[usedays])))." 23:59:59";
			}	
			$value[actype] = $ar_coupen[actype];
			$value[usetype] = $ar_coupen[usetype];
			$value[account] = $ar_coupen[account];
			$value[mtype] = "M";
			$value[mname] = $g_ar_init_member['name'];
			$value[memo] = $memo;
			$value[canuseac] = $ar_coupen[canuseac];
			$value[usesale] = $ar_coupen[usesale];
			$value[usegsale] = $ar_coupen[usegsale];
			$value[fids] = $fids[$i];
			$value[log_idx] = $log_idx;
			insert("shop_coupen_mem",$value);
			unset($value);
		}
	}
}
?>

<script>
function regichss()	{
	var isok = check_form(document.searchform);
	if(isok)	{
		return true;
	}

}
function gotogive()	{
	var isok = check_form(document.regiform);
	if(isok)	{
		answer = confirm('지급하시겠습니까?');
		if(answer==true)	{
			return true;
		}
		else	{
			return false;
		}
	}
}
</script>
<form id="searchform" name="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regichss();" >
<input type='hidden' name='goods_idx' id='goods_idx' valch="yes" msg="관련상품을 선택하세요" value="<?=$goods_idx;?>">
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 지급대상 검색</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>판매상품</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' id="gname" class="form-control" readonly value="<?=$ar_goods['gname'];?>">
							<button class="btn btn-primary waves-effect waves-light" type="button" onclick="MM_openBrWindow('popup.php?code=goods_search&hanmode=justselect&idxfi=goods_idx&namefi=gname','goods_main','width=1100,height=800,top=0,left=0,scrollbars=yes');">찾아보기</button>
						</div>
					</td>
				</tr>
				<Tr>
					<th >결제일</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' class="form-control" name='sdate' id='sdates' size='10' readonly value="<?=$sdate;?>" valch="yes" msg="시작일입력"> ~ <input type='text' class="form-control" id='edates' name='edate' size='10' readonly value="<?=$edate;?>" valch="yes" msg="시작일입력">
						</div>
					</td>
				</tr>
				
				</tbody>
				</table>
			</div>
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색하기</button>
						
				</div>
			</div>
		</div>
	</div>
	
</div>

</form>
<?php
if($goods_idx && $sdate && $edate)	{

	$q = "Select shop_newmarketdb.* from shop_newmarketdb INNER JOIN shop_newbasket ON shop_newmarketdb.index_no=shop_newbasket.market_idx where goods_idx='$goods_idx' and incdate BETWEEN '$sdate 00:00:00' AND '$edate 23:59:59' AND pdan='' and gonumber!='' and shop_newmarketdb.mem_idx!=0 order by shop_newmarketdb.index_no asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$isits = $st->rowCount();

?>
<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return gotogive();" >
<input type='hidden' name='goods_idx' value="<?=$goods_idx;?>">
<input type='hidden' name='edate' value="<?=$edate;?>">
<input type='hidden' name='sdate' value="<?=$sdate;?>">
<input type='hidden' name='mode' value='w'>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색결과</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>지급대상</th>
					<td colspan='3'>
						<?=$isits;?>건
					</td>
				</tr>
				<Tr>
					<th >지급쿠폰</th>
					<td colspan='3'>
						<select name="coupen_idx" class="form-control" valch="yes" msg="쿠폰을 선택하세요">
						<option value=''>선택</option>
						<?php
						$q2 = "select * from shop_coupen";
						$st2 = $pdo->prepare($q2);
						$st2->execute();
						while($row2 = $st2->fetch())	{
							echo "<option value='$row2[index_no]'>$row2[coupenname]</option>";	
						}
						?>
						</select>
					</td>
				</tr>
				<Tr>
					<th >고객안내메모</th>
					<td>
						<textarea name="memo" class="form-control"></textarea>
					</td>

					<th >관리자메모</th>
					<td>
						<textarea name="amemo" class="form-control"></textarea>
					</td>
				</tr>
				
				</tbody>
				</table>
			</div>
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">지급하기</button>
						
				</div>
			</div>
		</div>

		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 지급대상목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					
					<th> 주문일(결제일) </th>
					<th> 주문번호 </th>
					<th> 주문자 </th>
					
					<th> 주문금액 </th>
					<th> 결제수단 </th>
					
					<th>단계</th>
					<th>주문처</th>
				</tr>
				</thead>
				<tbody>
				<?php
				while($row = $st->fetch() )	{
				?>
				<tr>
					<td>
						<?=$row['sdate'];?> <?=$row['shour'];?>
						<? if($row['indate']!='') { echo "<br />(".$row['indate']." ".$row['intime'].")";	}?>
					</td>
					<td>
						<a href="javascript:MM_openBrWindow('popup?code=order_nview&index_no=<?=$row[index_no];?>','order<?=$row[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><? echo date("Ymd",$row['orderno'])."-".$row['index_no']; ?></a>
					</td>
					<td>
						<?=$row['name'];?>
						<? 
						if($row['mem_idx']=='0') { echo "[비회원]";	} 
						else	{	
							$ar_member = sel_query("shop_member","memgrade,id,mem_type"," WHERE index_no='$row[mem_idx]'");

							echo "[".$g_ar_memgrade[$ar_member['mem_type']][$ar_member['memgrade']]."]<br />";	
							echo $ar_member['id'];
						}	
					?>
					
					</td>
					<td style="text-align:right;"><?=number_format($row['account']/100);?></td>
					<td>
						<? 
							if($row['buymethod']=='C') { echo "신용카드";	}
							if($row['buymethod']=='R') { echo "계좌이체";	}
							if($row['buymethod']=='I') { echo "가상계좌";	}
						?>
					</td>
					<td style="text-align:center;">
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
					
					<td>
						<?=$g_ar_sitename[$row['pid']];?>
					</td>
				</tr>
				<?php
				}
				?>
				</tbody>
				</table>
			</div>
			
		</div>
	</div>
	
</div>

</form>
<?
}
?>
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
