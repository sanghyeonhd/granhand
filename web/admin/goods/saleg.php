<?
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_goods_sale"," where index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='d')
{
	$ele_idx = $_REQUEST['ele_idx'];
	$ar_ele = sel_query_all("shop_goods_sale_ele"," where index_no='$ele_idx'");
	$ar_goods = sel_query_all("shop_goods"," where index_no='$ar_ele[goods_idx]'");

	if($ar_goods[sale_idx]===$index_no)
	{
		$value[sale_idx] = 0;
		update("shop_goods",$value," where index_no='$ar_ele[goods_idx]'");
		unset($value);
	}

	mysql_query("delete from shop_goods_sale_ele where index_no='$ele_idx'");



	echo "<script>alert('삭제 완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
if($mode=='chac')	{
	
	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value[saleaccount] = $saleaccount[$i];
		update("shop_goods_sale_ele",$value," WHERE index_no='{$idx[$i]}'");
		unset($value);


	}
	echo "<script>alert('변경 완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
if($mode=='chor')	{
	
	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value[orders] = $orders[$i];
		update("shop_goods_sale_ele",$value," WHERE index_no='{$idx[$i]}'");
		unset($value);


	}
	echo "<script>alert('변경 완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
?>
<script language="javascript">
function set_onaccount(index)
{
	MM_openBrWindow('./popups/goods_ac.php?index_no='+index,'','scrollbars=no,width=420,height=300,top=0,left=0')
}
function set_account()	{
	answer = confirm('가격을 수정하시겠습니까?');
	$("#fmode").val('chac');
	if(answer==true)	{
		$("#listform").submit();
	}
}
function set_orders()	{
	answer = confirm('정렬을 수정하시겠습니까?');
	$("#fmode").val('chor');
	if(answer==true)	{
		$("#listform").submit();
	}
}
</script>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header panel-controls">
				<h3><i class="fa fa-table"></i> 할인정책기본정보</h3>
			</div>
			<div class="panel-content">


<table class="table table-bordered">
<tr>
	<th>할인정책명</th>
	<td><?=$ar_data[subject];?></td>
</tr>
<tr>
	<th>할인률</th>
	<td><? if($ar_data[stype]=='3') { echo "개별로설정";	} else if($ar_data[stype]=='4') { echo "상품정보의 도매제공가로 판매";	} else {  echo $ar_data[saleper]."%";	}?></td>
</tr>
<tr>
	<th>할인시작</th>
	<td><?=$ar_data[sdate];?> ~ <?=$ar_data[edate];?></td>
</tr>
</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header panel-controls">
				<h3><i class="fa fa-table"></i> 등록상품</h3>
				<div class="btn_wrap btn_right">
					<span class="btn_white_xs btn_navy btn_top"><a href="javascript:MM_openBrWindow('popup?code=goods_search&main_idx=<?=$index_no;?>&hanmode=sale','goods_main','width=1000,height=800,top=0,left=0,scrollbars=yes');">상품찾기</a></span>
				</div>
			</div>
			<div class="panel-content">



<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
<input type='hidden' name='mode' id="fmode" value='chac'>
<input type='hidden' name='index_no' value='<?=$index_no;?>'>
<table class="table table-bordered">
<colgroup>
	<col width="50px" />
	<col width="60px" />
	<col width="60px" />
	<col width="" />
	<col width="" />
	<col width="" />
	<col width="" />
	<col width="80px" />
	<col width="80px" />
</colgroup>
<thead>
<tr>
<th>번호</th>
<th>상품번호</th>
<th>이미지</th>
<th>상품명</th>
<th>품절여부</th>
<th>원가격</th>
<th>할인적용가</th>
<th></th>
<?
if($ar_data[stype]=='4')	{
?>
<th>정렬</th>
<?}?>
</tr>
</thead>
<tbody>
<?
if($ar_data[stype]=='4')	{
	$q = "SELECT *, A.index_no AS idx_no FROM shop_goods_sale_ele A LEFT JOIN shop_goods B ON A.goods_idx = B.index_no WHERE A.sale_idx ='$index_no' ORDER BY A.orders ASC";
}
else	{
	$q = "SELECT *, A.index_no AS idx_no FROM shop_goods_sale_ele A LEFT JOIN shop_goods B ON A.goods_idx = B.index_no WHERE A.sale_idx ='$index_no' ORDER BY B.gname ASC";
}
$r = mysql_query($q);
$cou = 1;
while($row = mysql_fetch_array($r))
{
?>
<tr>
<Td class='first'><?=$cou;?></td>
<Td><?=$row[goods_idx];?></td>
<td><? if($row[simg1]!=''){?><a href="<?=$_defaultsite;?>/shop/view.php?index_no=<?=$row[index_no];?>" target="_blank"><img src="<?=$_imgserver;?>/files/goods/<?=$row[simg1];?>" width='50' border="0"></a><?}?></td>

		<td style='text-align:left;padding-left:5px;'>
		<?=$row[gcode];?><br />
		<a href="<?=$_defaultsite;?>/shop/view.php?index_no=<?=$row[index_no];?>" target="_blank"><?=$row[gname];?></a>
		</td>
<Td style="font-size:13px;">
			<span style="color:red">
			<? if($row[isopen]=='2') { echo "<font color='blue'>";	} ?><?=$ar_isdan[$row[isopen]];?><? if($row[isopen]=='2') { echo "</font>";	}?><br /><br />
			</span>
			<span  style="color:red">
			<? if($row[isshow]=='Y') { echo "<font color='blue'>";	} ?><?=$ar_isshow[$row[isshow]];?><? if($row[isopen]=='Y') { echo "</font>";	}?>	
			</span>
</td>
<td><?=number_format($row[account]);?>원</td>
<td>
<?
if($ar_data[stype]=='3')	{
?>
<input type='hidden' name='idx[]' value='<?=$row[idx_no];?>'><input type='text' name='saleaccount[]' size='12' value='<?=$row[saleaccount];?>'>
<?
	
}
else	if($ar_data[stype]=='4')	{
	echo number_format($row[doaccount])."원";
}
else	{

	if($ar_data[saletype]=='1')	{	
		$ac = $row[account] - ($row[account]*$ar_data[saleper]/100);	
			
		if($ar_data[saleper_std1]!='0')	{
			$ac = $ac/$ar_data[saleper_std1];
				
			if($ar_data[saleper_std2]=='1')	{	
				$ac = ceil($ac);	
			}
			else if($ar_data[saleper_std2]=='2')	{	
				$ac = round($ac);	
			}
			else if($ar_data[saleper_std2]=='3')	{	
				$ac = floor($ac);	
			}

			$ac = $ac*$ar_data[saleper_std1];
		}

	}
	else	{	
		$ac = $ar_goods[account] - $ar_sale[saleper];	
	}
	echo number_format($ac)."원";
}
?></td>
<td>
	<span class="btn_white_xs"><a href="javascript:delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=d&index_no=<?=$index_no;?>&ele_idx=<?=$row[idx_no];?>','삭제?');">삭제</a></span>
</td>

<?
if($ar_data[stype]=='4')	{
?>
<td>
	<input type='hidden' name='idx[]' value='<?=$row[idx_no];?>'>
	<input type='text' name='orders[]' value='<?=$row[orders];?>' size='4'>
</td>
<?}?>

</tr>
<?
	$cou++;
}
?>
</tbody>
</table>

</form>
</div><!-- // .content -->
</div>
</div>
</div>