
<?php
$md = isset($_REQUEST['md']) ? $_REQUEST['md'] : "";
$cate = isset($_REQUEST['cate']) ? $_REQUEST['cate'] : "";
$gr = isset($_REQUEST['gr']) ? $_REQUEST['gr'] : "";
$in_idx = isset($_REQUEST['in_idx']) ? $_REQUEST['in_idx'] : "";

$sdate = $_POST['sdate'];
$sdate1 = $_POST['sdate1'];
if(!$sdate)
{	$sdate = date("Y-m-d",time()-86400);	}

$edate = $_POST['edate'];
$edate1 = $_POST['edate1'];
if(!$edate)
{	$edate = date("Y-m-d");	}

$sgname = $_REQUEST['sgname'];
$senterc = $_REQUEST['senterc'];

$s_year = date("Y");

$std = $_REQUEST['std'];
if(!$std)
{	$std = "odate";	}
$mode = $_REQUEST['mode'];


$pid = $_REQUEST['pid'];
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}

$ob = $_REQUEST['ob'];
if(!$ob)
{	$ob = "1";	}

$sgcode = $_REQUEST['sgcode'];
?>
<Script>
$(document).ready(function()	{
	$('#se_sdate1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#se_edate1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#se_sdate2').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#se_edate2').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>
<script language="javascript" type="text/javascript">

function set_gs()
{
	if($('#gr option:selected').val()!='')
	{

		var gr = $('#gr option:selected').val();

		var param = "gr="+gr;
		$.ajax({
		type:"GET",
		url:"./ajaxmo/get_shops.php",
		dataType: "html",
		data:param,
		success:function(msg){
			$('#in_idx').html(msg);
		}
		});
	}
}

function set_pids()
{
	var fid = $('#fid option:selected').val();

	var param = "fid="+fid+'&lan=N';
	$.ajax({
	type:"GET",
	url:"./ajaxmo/get_pid.php",
	dataType: "html",
	data:param,
	success:function(msg){
		$('#pid').html(msg);
	}
	});
}

function set_fidch()
{
	var param = "fid="+$('#fid option:selected').val();
	$.ajax({
	type:"GET",
	url:"./ajaxmo/act_cate_list.php",
	dataType: "html",   
	data:param,
	success:function(msg){
		$("#id_cates").html(msg);
	}
	});
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				
				<form id="search" name="search" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='sear'>

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tr>
					<Th>매출처</th>
					<td>
					<select name='fid' id="fid" class="form-control" onchange="set_pids(); set_fidch();">
					<option value=''>전체</option>
					<?
					$q = "select * from shop_sites";
					$q = $q ." order by idx asc";
					$st = $pdo->prepare($q);
					$st->execute();
					while($row = $st->fetch())	{
						if(in_array($row['idx'],$ar_mempriv))	{
							if($row['idx']==$fid)	{
								echo "<option value='$row[idx]' selected>$row[sitename]</option>";	
							}
							else	{
								echo "<option value='$row[idx]'>$row[sitename]</option>";	
							}
						}
					}
					?>
					</select>

					<select class="uch" name='pid' id="pid">
					<option value=''>전체</option>	
					<?
					if($fid)	{
						$q = "Select * from shop_config where fid='$fid' and language='' order by idx asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{	
							if($pid==$row[idx])	{
								echo "<option value='$row[idx]' selected>$row[site_name]</option>";		
							}
							else	{
								echo "<option value='$row[idx]'>$row[site_name]</option>";		
							}
						}
					}
					?>
					</select>
					</td>
				
					<Th>거래처</th>
					<td>
						<select class="uch" name='in_idx' id="in_idx">
						<option value=''>거래처</option>
						<?
							$q = "select * from shop_goods_shops where isdel='N' order by name";
							$st = $pdo->prepare($q);
							$st->execute();
							while($row = $st->fetch())	{
								if($row['idx']==$in_idx)	{
									echo "<option value='$row[idx]' selected>$row[name]</option>";	
								}
								else	{
									echo "<option value='$row[idx]'>$row[name]</option>";	
								}	
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<Th>광고코드</th>
					<td><select class="uch" name='senterc'>
					<option value=''>광고코드선택</option>
					<?php
					$q = "Select distinct(enterc) as ks from shop_crm_selling order by ks asc";
					$st = $pdo->prepare($q);
					$st->execute();
					while($row = $st->fetch())	{	
						if(trim($row[ks])!='')	{
							if($row[ks]==$senterc)	{
								echo "<option value='$row[ks]' selected>$row[ks]</option>";	
							}
							else	{
								echo "<option value='$row[ks]'>$row[ks]</option>";	
							}
						}
					}
					?>
					</select>
					</td>

					<Th>날짜기준</th>
					<td>
						<select class="uch" name='std'>
						<option value='indate' <? if($std=='indate') { echo "selected"; }?>>입금확인기준</option>
						<option value='odate_s' <? if($std=='odate_s') { echo "selected"; }?>>주문일기준</option>
						</select>
					</td>
				</tr>
				<tr>
					<Th>카테고리</th>
					<td colspan='3'>
						<select class="uch" name='cate' id='id_cates'>
				
						<option value=''>소속메뉴</option>
						<?php
						$q = "select * from shop_cate";
						$q = $q . " order by catecode";	
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							if($row['catecode']==$cate)	{
								$se = "selected";	
							}
							else	{
								$se = "";	
							}
							$catecode_len = strlen($row['catecode']);
							if($catecode_len==2)	{
								$first=$row['catename'];
								echo "<option value='$row[catecode]' $se>$row[catename]</option>";
							}
							else if($catecode_len==4)	{
								$second=$row['catename'];
								echo "<option value='$row[catecode]' $se>$first > $row[catename]</option>";
							}
							else if($catecode_len==6)	{
								echo "<option value='$row[catecode]' $se>$first > $second > $row[catename]</option>";	
							}
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>주문일자</th>
					<td>
						<div class="form-inline">
							<input type='text' name='sdate' id='se_sdate1' value='<?=$sdate;?>' class="form-control"> ~ <input type='text' name='edate' id='se_edate1' value='<?=$edate;?>' class="form-control">
						</div>
					</td>

					<th>판매시작일</th>
					<td>
						<div class="form-inline">
							<input type='text' name='sdate1' id='se_sdate2' class="form-control" value='<?=$sdate1;?>'> ~ <input type='text' name='edate1' id='se_edate2' class="form-control" value='<?=$edate1;?>'>
						</div>
					</td>
				</tr>
				<tr>
					<th>상품명</th>
					<td><input type='text' name='sgname' size='60' class="form-control" value="<?=$sgname;?>" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }"></td>

					<th>상품코드</th>
					<td><input type='text' name='sgcode' size='60' class="form-control" value="<?=$sgcode;?>" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }"></td>
				</tr>
				<tr>
					<th>정렬</th>
					<td colspan='3'><select name='ob'>
					<option value='1' <? if($ob=='1') { echo "selected";	}?>>판매수량</option>
					<option value='2' <? if($ob=='2') { echo "selected";	}?>>판매금액</option>
					</select>
				</td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#search">검색</button>
						
					</div>
				</div>
		
				</form>
			</div>
		</div>
	</div>
</div>

<?php
if($mode=='sear')	{
?>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 통계데이터</h3>
			</div>
			<div class="panel-content">

			<table class="table table-bordered">
	
	<thead>
	<Tr>
		<th class="f_w_b">순위</th>
		<th class="f_w_b">이미지<br>제품명</th>
		<th class="f_w_b">상품코드</th>
		<th class="f_w_b">판매여부</th>
		<th class="f_w_b">판매시작</th>
		<th class="f_w_b">판매량</th>
		<th class="f_w_b">판매가격</th>
  </tr>
  </thead>
  <tbody>
<?php
$total_sellss = 0;
if($cate)
{
	$q = "select sum(ea) as ks,sum(ea*account) as ks2,shop_crm_selling.goods_idx from shop_crm_selling inner join shop_goods_cate where $std>='$sdate' and $std<='$edate' and shop_crm_selling.goods_idx=shop_goods_cate.goods_idx and catecode='$cate'";
	if($md)
	{	$q = $q . " and md='$md'";	}
	if($senterc)
	{	$q = $q . " and enterc='$senterc'";	}
	if($fid)
	{	$q = $q . " and fid='$fid'";	}
	if($pid)
	{	$q = $q . " and pid='$pid'";	}
	if($gr)
	{
		if($in_idx)
		{	$q = $q . " and in_idx='$in_idx'";		}
		else
		{	$q = $q . " and in_idx IN (select idx from shop_goods_shops where upcate='$gr')";	}
	}
	
	
}
else
{
	$q = "select sum(ea) as ks,sum(account) as ks2,goods_idx from shop_crm_selling where $std>='$sdate' and $std<='$edate'";
	if($md)
	{	$q = $q . " and md='$md'";	}
	if($senterc)
	{	$q = $q . " and enterc='$senterc'";	}
	if($fid)
	{	$q = $q . " and fid='$fid'";	}
	if($pid)
	{	$q = $q . " and pid='$pid'";	}
	if($gr)
	{
		if($in_idx)
		{	$q = $q . " and in_idx='$in_idx'";		}
		else
		{	$q = $q . " and in_idx IN (select idx from shop_goods_shops where upcate='$gr')";	}
	}
	
}
if($ob=='1')
{	$q = $q . " group by goods_idx order by ks desc";	}
else
{	$q = $q . " group by goods_idx order by ks2 desc";	}


//엑셀쿼리
$sql_excel = $q;
$_SESSION['sql_excel'] = $sql_excel;

//엑셀쿼리 검색조건변수
$_SESSION['sql_reqeust'] = $_REQUEST;

$st = $pdo->prepare($q);
$st->execute();
$rcou = 1;
$total = 0;
while($row = $st->fetch())
{
	$co = "";
	if(!($rcou%2)) $co = "gray";

	$ar_g = sel_query_all("shop_goods"," where idx='$row[goods_idx]'");
	$ar_shop = sel_query_all("shop_goods_shops"," where idx='$ar_g[in_idx]'");

	if($sgname)
	{
		$sg = str_replace(" ","",$ar_g['gname']);
		$sg2 = str_replace(" ","",$sgname);
		$rcou++;
		if(!strstr($sg,$sg2))
		{
			
			continue;
		}
	}

	if($sdate1)
	{
		$sdate_n1 = $sdate1." 00:00:01";
		if($ar_g['opendate']<=$sdate_n1)
		{	continue;	}
	}

	if($edate1)
	{
		$edate_n1 = $edate1." 23:59:59";
		if($ar_g['opendate']>=$edate_n1)
		{	continue;	}
	}

	if($sgcode)
	{
		if($sgcode!=$ar_g['gcode'])
		{	continue;	}
	}
	
	
	$q3 = "select sum(readcount) as readcount from shop_crm_goodsread where wdate>='$sdate' and wdate<='$edate' and goods_idx='$row[goods_idx]'";
	if($pid)
	{	$q3 = $q3 . " and pid='$pid'";	}
	$st3 = $pdo->prepare($q3);
	$st3->execute();
	$row3 = $st3->fetch();

	$total_sellss = $total_sellss + ($row['ks']*$ar_g['account']/100);
?>
	 <tr class='<?=$co;?>'>
     <td class="first" ><?=$rcou?></td>
	 <td><a href="https://www.omealdang.com/shop?act=view&idx=<?=$row[goods_idx];?>" target='_blank'><img src="<?=$img;?>" style="width:60px;"></a><br><?=$ar_g[gname];?>
	 <!-- <br><a href="javascript:MM_openBrWindow('./popups/show_grp.php?idx=<?=$row[goods_idx];?>','checkIDWin','width=820,height=700,status=no,scrollbars=yes,top=0,left=0');">예측</a><br>
	 <a href="goods.php?code=g1_2_4&idx=<?=$row[goods_idx];?>" target='_blank'>수정</a> --></td>
		</td>
	<td><?=$ar_g[gcode];?></tD>
	 <td>
		<span style="color:red">
						<? if($ar_g[isopen]=='2') { echo "<font color='blue'>";	} ?><?=$g_ar_isdan[$ar_g['isopen']];?><? if($ar_g['isopen']=='2') { echo "</font>";	}?><br /><br />
						</span>
						<span  style="color:red">
						<? if($ar_g[isshow]=='Y') { echo "<font color='blue'>";	} ?><?=$g_ar_isshow[$ar_g['isshow']];?><? if($ar_g['isopen']=='Y') { echo "</font>";	}?>	
						</span>
	 </td>

	 <Td><?=substr($ar_g['regi_date'],0,10);?><br><Br><?=substr($ar_g['opendate'],0,10);?></tD>
	 <TD><?=number_format($row['ks']);?>/<?=number_format($row3['readcount']);?>=<font color='blue'><? if($row3['readcount']) { echo number_format($row['ks']/$row3['readcount']*100); } ?>%</td>
	 <Td><?=number_format($ar_g['account']/100);?>원<br><br><?=number_format($row['ks2']/100);?>원<br><br><? if($ar_g['daccount']!=0){ echo number_format($ar_g['account']/100/$ar_g['daccount'],2);	}?>
	 <br><br><?=$ar_shop['shopname'];?>
	 </tD>
	 
	 </tr>
<?php
	$total = $total + $row['ks'];
	$rcou++;
	$data[] = $row;
}
?>
	 <tr>
     <td colspan='5'>합계</td>

	 
	 <td><?=number_format($total);?> EA</td>
	 <td><?=number_format($total_sellss);?>원</tD>
	 
	 </tr>
	 </tbody>
	</table>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
