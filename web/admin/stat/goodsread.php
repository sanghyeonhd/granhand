<?php
$cate = isset($_REQUEST['cate']) ? $_REQUEST['cate'] : "";
$sdate = isset($_REQUEST['sdate']) ? $_REQUEST['sdate'] : "";
$edate = isset($_REQUEST['edate']) ? $_REQUEST['edate'] : "";


if(!$sdate)	{
	$sdate = date("Y-m-d",(time()-86400));	
}

if(!$edate){
	$edate = date("Y-m-d");	
}

$q = "select * from shop_config";
$st = $pdo->prepare($q);
$st->execute();
$lcou = 0;
while($row = $st->fetch())	{
	$ar_site[$row['idx']] = $row['site_name'];
}

$page = $_REQUEST['page'];
if(!$page)
{	$page = "1";	}

$numper = $_REQUEST['numper'];
if(!$numper)
{	$numper = 30;	}
?>
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
					<th>카테고리</th>
					<td><select class="form-control" name='cate'>
					<option value=''>전체보기</option>
					<?php
					$q = "select * from shop_cate order by catecode";
					$st = $pdo->prepare($q);
					$st->execute();
					while($row = $st->fetch()){
						if($row['catecode']==$cate)
						{	$se = "selected";	}
						else
						{	$se = "";	}
						$catecode_len = strlen($row['catecode']);
						if($catecode_len==2)
						{
							$first=$row['catename'];
							echo "<option value='$row[catecode]' $se>$row[catename]</option>";
						}
						else if($catecode_len==4)
						{
							$second=$row['catename'];
							echo "<option value='$row[catecode]' $se>$first > $row[catename]</option>";
						}
						else if($catecode_len==6)
						{	echo "<option value='$row[catecode]' $se>$first > $second > $row[catename]</option>";	}
					}
					?>
					</select>
					</td>
		
					<th>노출갯수</th>
					<td><input type='text' class="form-control" name='numper' value='<?=$numper;?>'></td>
				</tr>
		
				<tr>
					<th>날짜</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='sdate' id='sdate' value='<?=$sdate;?>'> ~ <input type='text' class="form-control" name='edate' id='edate' value='<?=$edate;?>'>
						</div>

			
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
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색데이터</h3>
			</div>
			<div class="panel-content">


				<table class="table table-bordered">
				<thead>
				<tr>
					<th>체크</th>
					<th>번호</th>
					<th>IMG</th>
					<th>상품명</th>
					<th>상품코드</th>
					<th>판매가</th>
					<th>등록일</th>
					<th>조회상세</th>
					<th>조회수</th>
					<th>메인조회수</th>
					<th>구매량</th>
					<th>입금량</th>
					<th>구매율</th>
					<th>입금율</th>
				</tr>
				</thead>
				<tbody>
				<?php

$lit = ($page-1)*$numper;

$q = "select sum(readcount) as readcount2,goods_idx from shop_crm_goodsread where wdate>='$sdate' and wdate<='$edate' group by goods_idx order by readcount2 desc limit $lit , $numper";
$st = $pdo->prepare($q);
$st->execute();
$cou = 1;
while($row = $st->fetch())
{
	$is = 1;
	if($cate)
	{
		$q2 = "Select * from shop_goods_cate where catecode='$cate' and goods_idx='$row[goods_idx]'";
		$st2 = $pdo->prepare($q2);
		$st2->execute();
		$is = $st->rowCount();
	}
	if($is==0)	{
		continue;	
	}

	$ar_goods = sel_query_all("shop_goods"," where idx='$row[goods_idx]'");
	//$img = showimg($ar_goods,60,60);

	$co = "";
	if(!($cou%2)) $co = "gray";

?>
	<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
	<td class="first"><input type='checkbox' name='index' value='<?=$row['goods_idx'];?>'></td>
	<td><?=$cou;?></td>
	<td><img src="<?=$img;?>" style="width:60px;"></td>
	<td><a href="/shop?act=view&idx=<?=$ar_goods['idx'];?>" target="_blank"><?=$ar_goods['gname'];?></a></td>
	<td><?=$ar_goods[gcode];?></tD>
	<td style="text-align:right;padding-right:5px"><?=number_format($ar_goods[account]/100);?><br><bR><? if($ar_goods['daccount']!=0){ echo number_format($ar_goods['account']/$ar_goods['daccount'],2);	}?></td>
	<td><?=substr($ar_goods['regi_date'],0,10);?><br><br><? if($ar_goods['isopen']!='1') { echo substr($ar_goods['opendate'],0,10);	}?></td>
	
	<td>
		<div class="form_wrap">
		<table class="form" border="0" cellpadding="0" cellspacing="0">
		<colgroup>
			<col width="40px">
			<col width="20px">
		</colgroup>
		<?php 
		$qss = "select distinct(enterc) from shop_crm_goodsread where goods_idx='$row[goods_idx]' and wdate>='$sdate' and wdate<='$edate'";
		$stss = $pdo->prepare($qss);
		$stss->execute();
		while($rowss = $stss->fetch())
		{	
		?>
		<tr style="height:24px">
		<Th style="padding-top:0;padding-bottom:0"><?=$rowss[0];?></th>
		<Td style="text-align:right">
			<?php
			$qss2 = "select * from shop_crm_goodsread where goods_idx='$row[goods_idx]' and enterc='$rowss[0]' and wdate>='$sdate' and wdate<='$edate'";
			$st2 = $pdo->prepare($qss2);
			$st2->execute();
			$rowss2 = $st2->fetch();
			echo number_format($rowss2['readcount']);
		?>
		</td>
		</tr>
		<?php
		}
		?>
		</table>
		</div><!-- // .form_wrap -->
	</td>
	<td>
		<?=number_format($row['readcount2']);?>
	</td>
	<td style='text-align:left;padding-left:5px;'>
	<?
	$qs = "select mainname,pid,main_idx from shop_newmain_data,shop_newmain_config where goods_idx='$row[goods_idx]' and shop_newmain_data.main_idx=shop_newmain_config.idx order by pid, shop_newmain_config.orders ";
	$sts = $pdo->prepare($qs);
	$sts->execute();
	while($rows = $sts->fetch())
	{
		$rc1 = get_mread_data($row['goods_idx'],$rows['main_idx'],$sdate,$edate);
		echo "<p>[".$ar_site[$rows['pid']]."]$rows[mainname] - ".number_format($rc1)."</p>";
		
	}
	?>
	</td>
	<td>
	<?php
	$q2 = "select sum(ea) from shop_crm_selling where odate_s>='$sdate' and odate_s<='$edate' and goods_idx='$row[goods_idx]'";
	$st2 = $pdo->prepare($q2);
	$st2->execute();
	$row2 = $st2->fetch();
	
	if($row2[0])
	{	echo number_format($row2[0]);	}
	?>
	</td>
	
	<td>
	<?php
	$q3 = "select sum(ea) from shop_crm_selling where indate>='$sdate' and indate<='$edate' and goods_idx='$row[goods_idx]'";
	$st3 = $pdo->prepare($q3);
	$st3->execute();
	$row3 = $st3->fetch();

	if($row3[0])
	{	echo number_format($row3[0]);	}
	?>
	</td>
	<td>
	<?php
	if($row2[0])
	{	echo number_format($row2[0]/$row['readcount2']*100,2)."%";	}
	?>
	</td>
	<td>
	<?php
	if($row3[0])
	{	echo number_format($row3[0]/$row['readcount2']*100,2)."%";	}
	?>
	</td>
	
	</tR>
<?php
	unset($ar_cate_conf);
	unset($ar_main_conf);
	$cou++;
}
?>
</tbody>
</table>
			</div>
		</div>
	</div>
</div>
