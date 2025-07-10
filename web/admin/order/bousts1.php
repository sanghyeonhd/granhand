<?php
//2015.08.13 전체체크 기능 추가

$dans = $_REQUEST['dans'];
if(!$dans)
{	$dans = '1';	}
$page = $_GET['page'];
if(!$page)
{	$page = 1;	}
$mode = $_REQUEST['mode'];
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}
$key = $_REQUEST['key'];
$sdate = $_REQUEST['sdate'];
$edate = $_REQUEST['edate'];
if($mode=='w')
{
	$ar_index = $_REQUEST['ar_index'];
	$ar_index = explode("|R|",$ar_index);
	for($i=0;$i<sizeof($ar_index);$i++)
	{
		if($ar_index[$i]!='')
		{
			$value['checkd'] = date("Y-m-d",time());
			update("shop_newmarketdb_accounts",$value," where idx='$ar_index[$i]'");
			unset($value);
		}
	}
	echo "<Script>alert('승인완료'); location.replace('$PHP_SELF?code=$code&dans=$dans&page=$page&fid=$fid'); </script>";
	exit;
}

if($mode=='wback')
{
	$ar_index = $_REQUEST['ar_index'];
	$ar_index = explode("|R|",$ar_index);
	for($i=0;$i<sizeof($ar_index);$i++)
	{
		if($ar_index[$i]!='')
		{
			$value[checkd] = "";
			update("shop_newmarketdb_accounts",$value," where idx='$ar_index[$i]'");
			unset($value);
		}
	}
	echo "<Script>alert('승인완료'); location.replace('$PHP_SELF?code=$code&dans=$dans&page=$page&fid=$fid'); </script>";
	exit;
}

if($mode=='w2')
{
	$ar_index = $_REQUEST['ar_index'];
	$ar_index = explode("|R|",$ar_index);
	for($i=0;$i<sizeof($ar_index);$i++)
	{
		if($ar_index[$i]!='')
		{
			$ar_in = sel_query_all("shop_newmarketdb_accounts"," where idx='$ar_index[$i]'");

			if($ar_in['inctime']!='')
			{
				echo "<Script>alert('$ar_in[inname] 고객은 이미 환불되어서 처리 안함'): history.back(); </script>";
			}
			else
			{

				$value['incdate'] = date("Y-m-d",time());
				$value['inctime'] = date("H:i:s",time());
				update("shop_newmarketdb_accounts",$value," where idx='$ar_index[$i]'");
				unset($value);

				$value['isout'] = $ar_in['account'];
				update("shop_newmarketdb_accounts",$value," where idx='$ar_in[up_idx]'");
				unset($value);

				$value['market_idx'] = $ar_in[market_idx];
				$value['wtype'] = "취소";
				$value['memo'] = "환불처리 완료 : ".number_format($ar_in['account'])."원";
				$value['wdate'] = $nowdate;
				$value['writer_idx'] = $memindex;
				$value['writer_s'] = $memname;
				$value['isauto'] = "Y";
				insert("shop_newmarketdb_memo",$value);
				unset($value);

				$ar_ma = sel_query_all("shop_newmarketdb"," where idx='$ar_in[market_idx]'");
				$ar_kinit = sel_query_all("shop_config"," where idx='$ar_ma[pid]'");

				$msg = $ar_ma['name']."님 $ar_in[account] 원이 계좌로 환불 되었습니다. -$ar_kinit[site_name]-";
				$cp = $ar_ma['cp'];
				$return = $ar_kinit['site_phone'];
				
				$arrs = array("NAME" => $ar_ma['name'], "ONUM" => $ar_in['market_idx'], "ACCOUNT" => $ar_in['account']);
				//make_smsmsg('4', $arrs, $cp, $return, $ar_ma[fid]);
			}
		}
	}
	echo "<Script>alert('승인완료'); location.replace('$PHP_SELF?code=$code&dans=$dans&page=$page&fid=$fid'); </script>";
	exit;
}
?>
<script language="javascript">
function show_memo(ids,mk,cou)
{
	if(document.getElementById("list"+ids).style.display=='none')
	{	
		document.getElementById("list"+ids).style.display='block';	
		
		if(document.listform.index.length)
		{	document.listform.index[cou].checked=true;	}
		else
		{	document.listform.index.checked=true;	}

		var fos1 = eval("fr1"+ids);
		var fos2 = eval("fr2"+ids);
		fos1.location.href='./frame_data/o_memos2.php?frs=fr1'+ids+'&idx='+mk;
		fos2.location.href='./frame_data/o_account2.php?frs=fr2'+ids+'&idx='+mk;
	}
	else
	{	
		document.getElementById("list"+ids).style.display='none';	
		var fos1 = eval("fr1"+ids);
		var fos2 = eval("fr2"+ids);
		fos1.location.href='';
		fos2.location.href='';
	}

}
function set_next2()
{
	var str = '';
	var k = 0;
	if(document.listform.index.length)
	{
		for(var i=0;i<document.listform.index.length;i++)
		{
			if(document.listform.index[i].checked==true)
			{	str = str + document.listform.index[i].value + '|R|';	k = k + 1;	}
		}
	}
	else
	{
		if(document.listform.index.checked==true)
		{	str = str + document.listform.index.value + '|R|';	k = k + 1;	}
	}
	if(k==0)
	{
		alert('승인할 항목 선택');
		return;
	}
	answer = confirm('승인하시겠습니까?');
	if(answer==true)
	{	document.listform.mode.value = 'w'; document.listform.ar_index.value = str;	document.listform.submit();	}
	else
	{	return;	}
}
function set_next3()
{
	var str = '';
	var k = 0;
	if(document.listform.index.length)
	{
		for(var i=0;i<document.listform.index.length;i++)
		{
			if(document.listform.index[i].checked==true)
			{	str = str + document.listform.index[i].value + '|R|';	k = k + 1;	}
		}
	}
	else
	{
		if(document.listform.index.checked==true)
		{	str = str + document.listform.index.value + '|R|';	k = k + 1;	}
	}
	if(k==0)
	{
		alert('환불완료처리 항목 선택');
		return;
	}
	answer = confirm('환불완료처리 하시겠습니까?');
	if(answer==true)
	{	document.listform.mode.value = 'w2'; document.listform.ar_index.value = str;	document.listform.submit();	}
	else
	{	return;	}
}
function set_next_back()
{
	var str = '';
	var k = 0;
	if(document.listform.index.length)
	{
		for(var i=0;i<document.listform.index.length;i++)
		{
			if(document.listform.index[i].checked==true)
			{	str = str + document.listform.index[i].value + '|R|';	k = k + 1;	}
		}
	}
	else
	{
		if(document.listform.index.checked==true)
		{	str = str + document.listform.index.value + '|R|';	k = k + 1;	}
	}
	if(k==0)
	{
		alert('승인대기 항목으로 이전할건 선택');
		return;
	}
	answer = confirm('환불대기상태로 변경 하시겠습니까?');
	if(answer==true)
	{	document.listform.mode.value = 'wback'; document.listform.ar_index.value = str;	document.listform.submit();	}
	else
	{	return;	}
}
function set_chk()
{
	if(document.listform.index.length)
	{
		for(var i=0;i<document.listform.index.length;i++)
		{
			if(document.listform.index[i].checked==true)
			{	document.listform.index[i].checked=false;		}
			else
			{	document.listform.index[i].checked=true;	}
		}
	}
	else
	{
		if(document.listform.index.checked==true)
		{	document.listform.index.checked=false;	}
		else
		{	document.listform.index.checked=true;	}
	}
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
					<td><select name='dans'>
		<option value=''>단계를선택하세요</option>
		<?
		$ar_dan = array("1"=>"승인대기","2"=>"승인완료","3"=>"환불완료");
		for($i=1;$i<=sizeof($ar_dan);$i++)
		{
			if($dans==$i)
			{	echo "<option value='$i' selected>$ar_dan[$i]</option>";	}
			else
			{	echo "<option value='$i'>$ar_dan[$i]</option>";	}
		}
		?>
		</select>	</td>
				</tr>
				</tbody>
				</table>

				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						<?	if($dans=='1')	{?>
						<a href="javascript:set_next2();" class="btn btn-primary waves-effect waves-light">체크항목승인하기</a>
			
			<?}?>

			<?	if($dans=='2')	{?>
				<a href="javascript:set_next3();"  class="btn btn-primary waves-effect waves-light">체크항목환불완료</a>
				<a href="javascript:set_next_back();"  class="btn btn-primary waves-effect waves-light">체크항목승인대기로</a>
				
			<?}?>
			
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?
if($dans=='2')
{
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 요약</h3>
			</div>
			<div class="panel-content">

<table class="table table-bordered">
<thead>
<Tr>
<th class=kor8>건수</th>
<th class=kor8>총금액</th>
</tr>
</thead>
<tbody>
<?
$q= "select count(shop_newmarketdb_accounts.idx),sum(shop_newmarketdb_accounts.account) from shop_newmarketdb_accounts,shop_newmarketdb where tbtype='O' and shop_newmarketdb_accounts.buymethod='B' and shop_newmarketdb_accounts.market_idx=shop_newmarketdb.idx";
if($dans=='1')
{	$q = $q . " and incdate='' and checkd=''";	}
if($dans=='2')
{	$q = $q . " and incdate='' and checkd!=''";	}
if($dans=='3')
{	$q = $q . " and incdate!=''";	}
if($fid)
{	$q = $q . " and fid='$fid'";	}
if($sdate)
{		$q = $q . " and LEFT($key,10)>='$sdate'";		}
if($edate)
{		$q = $q . " and LEFT($key,10)<='$edate'";		}
$st = $pdo->prepare($q);
$st->execute();
?>
<tR>
<Td><?=number_format($row[0]);?>건</tD>
<Td><?=number_format($row[1]);?>원</tD>
</tR>
</tbody>
</table>
			</div>
		</div>
	</div>
</div>

<?
}
?>


<form name="listform" method="post" action="<?=$PHP_SELF;?>?code=<?=$code;?>">
<input type='hidden' name='mode' value=''>
<input type='hidden' name='ar_index' value=''>
<input type='hidden' name='page' value='<?=$page;?>'>
<input type='hidden' name='dans' value='<?=$dans;?>'>
<input type='hidden' name='fid' value='<?=$fid;?>'>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 목록</h3>
			</div>
			<div class="panel-content">

<table class="table table-bordered">
<thead>
<Tr>
<th class=kor8><input type='checkbox' name='all' onclick='set_chk();'></th>
<th class=kor8>번호</th>
<th class=kor8>주문처</th>
<th class=kor8>주문번호</th>

<th class=kor8>고객명</th>
<th class=kor8>환불금액</th>
<th class=kor8>은행</th>
<th class=kor8>계좌번호</th>
<th class=kor8>예금주</th>
<th class=kor8>요청일</th>
<? if($dans=='3'){?><th class=kor8>완료일</th><?}?>
<th class=kor8></th>
</tr>
</thead>
<tbody>
<?php


$num_per_page = 50;
$page_per_block = 10;

$len_cate = strlen($cate);

$q= "select count(shop_newmarketdb_accounts.idx) from shop_newmarketdb_accounts,shop_newmarketdb where tbtype='O' and shop_newmarketdb_accounts.buymethod='B' and shop_newmarketdb_accounts.market_idx=shop_newmarketdb.idx";

if($fid)
{	$q = $q . " and fid='$fid'";	}
if($sdate)
{		$q = $q . " and LEFT($key,10)>='$sdate'";		}
if($edate)
{		$q = $q . " and LEFT($key,10)<='$edate'";		}

$st = $pdo->prepare($q);
$st -> execute();
$total_record = $st->fetchColumn();

$total_page = ceil($total_record/$num_per_page);

if($total_record == 0)
{ $first = 0; $last = 0; }
else
{ $first = $num_per_page*($page-1); $last = $num_per_page*$page; }

$q = "select shop_newmarketdb_accounts.*,shop_newmarketdb.pid,shop_newmarketdb.fid from shop_newmarketdb_accounts,shop_newmarketdb where tbtype='O' and shop_newmarketdb_accounts.buymethod='B' and shop_newmarketdb_accounts.market_idx=shop_newmarketdb.idx";

if($fid)
{	$q = $q . " and fid='$fid'";	}
if($sdate)
{		$q = $q . " and LEFT($key,10)>='$sdate'";		}
if($edate)
{		$q = $q . " and LEFT($key,10)<='$edate'";		}

$_SESSION['sql_excel'] = $q."  order by requdate desc";

$q = $q . " order by requdate desc limit $first, $num_per_page";
$st = $pdo->prepare($q);
$st -> execute();
$article_num = $total_record - (($page-1)*$num_per_page);
$cou = 0;



while($row = $st->fetch())
{
	$ar_m = sel_query("shop_newmarketdb","idx,name,orderno"," where idx='$row[market_idx]'");
	$co = "";
	if(!($cou%2)) $co = "gray";
	
?>

<tr  class='<?=$co;?>'>
<td class="first"><input type='checkbox' name='index' value='<?=$row['idx'];?>'>
<td><?=$article_num;?></td>
<td>

</td>
<td><a href="javascript:MM_openBrWindow('popup.php?code=order_nview&idx=<?=$ar_m['idx'];?>','order<?=$ar_m['idx'];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=date("Ymd",$ar_m['orderno']);?>-<?=$ar_m['idx'];?></a></td>
<td><?=$ar_m['name'];?></td>
<td><?=number_format($row['account']);?>원</td>
<td><?=$row['pgs'];?></td>
<tD><?=$row['banknum'];?></td>
<tD><?=$row['inname'];?></td>
<td><?=$row['requdate'];?></td>
<? if($dans=='3'){?><td><?=$row['incdate'];?> <?=$row['inctime'];?></td><?}?>
<td><!-- <? if($dan!='1'){?>  <span class="btn_white_xs"><a href="javascript:MM_openBrWindow('./module/change_bank.php?idx=<?=$row[idx];?>','cb','scrollbars=yes,width=500,height=200,top=0,left=0');">수정</a></span><?}?> --></td>
</tr>
<?php
	$article_num--;
	$cou++;
}
?>
</tbody>
</table>
			</div>
		</div>
	</div>
</div>
</form><!-- // .form[name="listform"] -->

