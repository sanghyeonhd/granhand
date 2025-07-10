<?php
$dan = isset($_REQUEST['dan']) ? $_REQUEST['dan'] : 'N';
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
var ispors = "N";
function Cancel(form)
{
	if(ispors=='Y')
	{
		alert('처리중이니 잠시만 기다리세요');
		return;
	}
		form = eval("document."+form);
		if(confirm("결제내역을 취소하시겠습니까?") == true)
		{ 
			ispors = "Y";
			
			form.submit();
		}
	
} 
function chk_type_cp(form)
{
	if(ispors=='Y')
	{
		alert('처리중이니 잠시만 기다리세요');
		return;
	}
	answer = confirm('취소? 처리시간이 좀 걸릴수도 있으니 누번 버튼 누르지 마세요~');
	if(answer==true)
	{	
		ispors = "Y";
		var form = eval("document."+form);
		form.submit();
	
	}
}

function chk_type(fo)
{
	if(ispors=='Y')
	{
		alert('처리중이니 잠시만 기다리세요');
		return;
	}
	var fos = eval("document."+fo);
	if(fos.LGD_CANCELAMOUNT.value=='')
	{
		answer = confirm('전체취소? 처리시간이 좀 걸릴수도 있으니 누번 버튼 누르지 마세요~');
		if(answer==true)
		{	
			ispors = "Y";
			fos.submit();
		}
		else
		{	return;	}
	}
	else
	{
		answer = confirm('부분 취소? 처리시간이 좀 걸릴수도 있으니 누번 버튼 누르지 마세요~');
		if(answer==true)
		{	
			ispors = "Y";
			fos.action="PartialCancel.php";
			fos.submit();
		}
		else
		{	return;	}
	}
}
function chk_type_ini(fo)
{
	if(ispors=='Y')
	{
		alert('처리중이니 잠시만 기다리세요');
		return;
	}
	var fos = eval("document."+fo);

	if(fos.outt.value=='P')
	{
		answer = confirm('부분 취소? 처리시간이 좀 걸릴수도 있으니 누번 버튼 누르지 마세요~');
		if(answer==true)
		{	
			ispors = "Y";
			fos.submit();
		}
		else
		{	return;	}
	}
	else
	{

		answer = confirm('전체취소? 처리시간이 좀 걸릴수도 있으니 누번 버튼 누르지 마세요~');
		if(answer==true)
		{	
			ispors = "Y";
			fos.submit();
		}
		else
		{	return;	}
	}
}
function chk_axes(fo)	{
	if(ispors=='Y')
	{
		alert('처리중이니 잠시만 기다리세요');
		return;
	}
	var fos = eval("document."+fo);

	
		answer = confirm('전체취소? 처리시간이 좀 걸릴수도 있으니 누번 버튼 누르지 마세요~');
		if(answer==true)
		{	
			ispors = "Y";
			fos.submit();
		}
		else
		{	return;	}

}
function chk_allat(fo)	{
	if(ispors=='Y')
	{
		alert('처리중이니 잠시만 기다리세요');
		return;
	}
	var fos = eval("document."+fo);

	
		answer = confirm('전체취소? 처리시간이 좀 걸릴수도 있으니 누번 버튼 누르지 마세요~');
		if(answer==true)
		{	
			ispors = "Y";
			fos.submit();
		}
		else
		{	return;	}

}


</script>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>판매처</th>
					<td>
						<select class="uch" name='fid'>
				<option value=''>전체보기</option>
				<?php
				$q = "select * from shop_sites";
				$q = $q ." order by idx asc";
				$st = $pdo->prepare($q);
				$st -> execute();
				while($row = $st->fetch())
				{
					if(in_array($row['idx'],$ar_mempriv))
					{
						if($row['idx']==$fid)
						{	echo "<option value='$row[idx]' selected>$row[sitename]</option>";	}
						else
						{	echo "<option value='$row[idx]'>$row[sitename]</option>";	}
					}
				}
		?>
		</select>
					</td>
					<th>단계</th>
					<td><select class="uch" name='dan'><option value=''>전체</option><option value='Y' <? if($dan=='Y') { echo "selected";	}?>>환불완료</option><option value='N' <? if($dan=='N') { echo "selected";	}?>>환불대기</option></select></td>
				</tr>
				</tbody>
				</table>

				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						
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
				<h3><i class="fa fa-table"></i> 목록</h3>
			</div>
			<div class="panel-content">

<table class="table table-bordered">
<thead>
<tr>
<th>번호</th>
<th>주문처</th>
<th>주문번호</th>
<th>고객명</th>
<th>환불금액</th>
<th>환불타입</th>
<th>요청일</th>
<th>완료일</th>
<th></th>
</tr>
</thead>
<tbody>
<?php
$page = $_GET['page'];
if(!$page)
{	$page = 1;	}

$num_per_page = 50;
$page_per_block = 10;

$q= "select count(shop_newmarketdb_accounts.idx) from shop_newmarketdb_accounts,shop_newmarketdb where tbtype='O' and shop_newmarketdb_accounts.buymethod!='B' and shop_newmarketdb_accounts.buymethod!='P' and shop_newmarketdb_accounts.buymethod!='X' and shop_newmarketdb_accounts.market_idx=shop_newmarketdb.idx";

if($fid)
{	$q = $q . " and fid='$fid'";	}

$st = $pdo->prepare($q);
$st -> execute();
$total_record = $st->fetchColumn();

$total_page = ceil($total_record/$num_per_page);

if($total_record == 0)
{ $first = 0; $last = 0; }
else
{ $first = $num_per_page*($page-1); $last = $num_per_page*$page; }

$q = "select shop_newmarketdb_accounts.*,shop_newmarketdb.pid from shop_newmarketdb_accounts,shop_newmarketdb where tbtype='O' and shop_newmarketdb_accounts.buymethod!='B' and shop_newmarketdb_accounts.buymethod!='P' and shop_newmarketdb_accounts.buymethod!='X' and shop_newmarketdb_accounts.market_idx=shop_newmarketdb.idx";

if($fid)
{	$q = $q . " and fid='$fid'";	}
$q = $q . " order by shop_newmarketdb_accounts.idx desc limit $first, $num_per_page";

$st = $pdo->prepare($q);
$st -> execute();
$article_num = $total_record - (($page-1)*$num_per_page);
$cou = 0;
while($row = $st->fetch())
{
	$ar_m = sel_query("shop_newmarketdb","idx,name,orderno,fid"," where idx='$row[market_idx]'");
	$ar_up = sel_query_all("shop_newmarketdb_accounts"," where idx='$row[up_idx]'");	

	$co = "";
	if(!($cou%2)) $co = "gray";
?>
<tr class='<?=$co;?>'>
<td class="first"><?=$article_num;?></td>
<td>
	<?
	$qs = "SELECT * FROM shop_config WHERE idx='$row[pid]'";
	$sts = $pdo->prepare($qs);
	$sts->execute();
	$rows = $sts->fetch();

	echo $rows['site_name'];?>
</td>
<td><a href="javascript:MM_openBrWindow('popup.php?code=order_nview&idx=<?=$ar_m['idx'];?>','order<?=$ar_m['idx'];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=date("Ymd",$ar_m['orderno']);?>-<?=$ar_m['idx'];?></a></td>
<td><?=$ar_m[name];?></td>
<td><?=number_format($row['account']/100);?>원</td>
<td><?=$ar_method[$row['buymethod']];?></td>
<td><?=$row['requdate'];?></td>
<td><?=$row['incdate'];?> <?=$row['inctime'];?></td>

<td></td>
</tr>

<?php
	$cou++;
	$article_num--;
}
?>
</tbody>
</table>
			</div>
		</div>
	</div>
</div>
</form><!-- // .form[name="listform"] -->

