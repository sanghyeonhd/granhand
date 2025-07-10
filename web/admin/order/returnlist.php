<?php
$mode = $_REQUEST['mode'];
if($mode=='in2')
{
	$savedir = "./csvs/";

	$userfile = array($_FILES['upfile']['name']);
	$tmpfile = array($_FILES['upfile']['tmp_name']);


	for($i=0;$i<sizeof($userfile);$i++)
	{	$fileurl[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}

	echo "<script>alert('입력완료'); location.replace('$PHP_SELF?code=return_reqn2&fname=$fileurl[0]'); </script>";
	exit;
}
$year = $_REQUEST['year'];
if(!$year)
{	$year = $s_year;	}
$month = $_REQUEST['month'];
if(!$month)
{	$month = $s_month;	}
$day = $_REQUEST['day'];
if(!$day)
{	$day = $s_day;	}
$rdate = $year."-".$month."-".$day;
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}
?>
<script language="javascript">
function goch()
{
	if(!document.lform.upfile.value)
	{
		alert('업로드할 파일을 입력하세요.');
		document.lform.upfile.focus();
		return false;
	}
	return true;
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i>반품신청록록</h3>
			</div>
			<div class="panel-content">

<table class="table table-bordered">
<colgroup>
	<col width="5%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="*" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
<th>NO</th>
<th>주문번호</th>
<th>고객명</th>
<th>수거연락처</th>
<th>수거주소</th>
<th>수거접수일</th>
</tr>
</thead>
<tbody>
<?php
if($fid)
{	$q = "select shop_newmarketdb_returns.* from shop_newmarketdb_returns,shop_newmarketdb where wdate_s='$rdate' and shop_newmarketdb.index_no=shop_newmarketdb_returns.market_idx and fid='$fid'";	}
else
{	$q = "select * from shop_newmarketdb_returns where wdate_s='$rdate'";	}
$st = $pdo->prepare($q);
$st -> execute();
$cou = 1;
while($row = $st -> fetch())
{
	$ar_market_idx = explode("-",$row['market_idx']);
	$ar_ms[0] = "";
	$str = "";
	$kcou = 0;
	for($i=0;$i<sizeof($ar_market_idx);$i++)
	{
		if(!in_array($ar_market_idx[$i],$ar_ms))
		{	
			if($ar_market_idx[$i]!='')
			{
				$ar_ms[$kcou] = $ar_market_idx[$i];
				$str = $str . $ar_market_idx[$i] ."-";
				$kcou++;
			}
		}
	}

	$ar_basket_idx = explode("-",$row['basket_idx']);
	$ar_bs[0] = "";
	$str2 = "";
	$kcou = 0;
	for($i=0;$i<sizeof($ar_basket_idx);$i++)
	{
		if(!in_array($ar_basket_idx[$i],$ar_bs))
		{	
			if($ar_basket_idx[$i]!='')
			{
				$ar_bs[$kcou] = $ar_basket_idx[$i];
				$str2 = $str2 . $ar_basket_idx[$i] ."-";
				$kcou++;
			}
		}
	}
	
	$value['market_idx'] = $str;
	$value['basket_idx'] = $str2;
	update("shop_newmarketdb_returns",$value," where index_no='$row[index_no]'");
	unset($value);


	$co = "";
	if(!($cou%2)) $co = "gray";
?>
	<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
	<td class="first"><?=$cou;?></td>
	<td>
		<?php
		for($i=0;$i<sizeof($ar_ms);$i++)
		{
		?>
		<a href="javascript:MM_openBrWindow('order.php?code=nview&index_no=<?=$ar_ms[$i];?>','order<?=$ar_ms[$i];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$ar_ms[$i];?></a>
		<?}?>
	</td>
	<td><?=$row['name'];?></td>	
	<td><?=$row['cp'];?></td>	
	<Td align='left'>[<?=$row['zip'];?>] <?=$row['addr1'];?> <?=$row['addr2'];?></tD>
	<Td><?=$row['wdate_s'];?></tD>
	</tr>
<?php
	$cou++;
}
?>
</tbody>
</table>	
			</div>
		</div>
	</div>
</div>