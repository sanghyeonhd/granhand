<?php
$mode = $_REQUEST['mode'];
$paper_idx = $_REQUEST['paper_idx'];
if($mode=='w')
{	
	$errcou = 0;
	$errc = "";
	$q  = "select * from shop_goods_inout_pre";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		if($row[ea]==0 && $row[codes]=='')	{
			continue;	
		}
		
		$ar_codes = explode("|R|",$row['codes']);
		
		$ar_code['goods_idx'] = $ar_codes[0];
		$ar_code['op1'] = $ar_codes[1];
		$ar_code['op2'] = $ar_codes[2];
		$ar_code['op3'] = $ar_codes[3];

		
			
			$ar_g = sel_query("shop_goods","in_idx"," where index_no='$ar_code[goods_idx]'");
			$ar_s = sel_query_all("shop_goods_inout_cate"," where index_no='$row[tbtype]'");
		
			$lefts = get_lefts($ar_code[goods_idx],$ar_code[op1],$ar_code[op2],$ar_code[op3]);


			if($ar_s[catetype]=='I')
			{	$lefts = $lefts + $row[ea];	}
			else
			{	$lefts = $lefts - $row[ea];	}

			if($lefts>=0)
			{		
				$value[lefts_l] = $lefts;
				set_lefts($ar_code[goods_idx],$ar_code[op1],$ar_code[op2],$ar_code[op3],$value);
				unset($value);
			
				$value[paper_idx] = $paper_idx;
				$value[in_idx] = $ar_g[in_idx];
				$value[goods_idx] = $ar_code[goods_idx];
				$value[op1] = $ar_code[op1];
				$value[op2] = $ar_code[op2];
				$value[op3] = $ar_code[op3];
				$value[ea] = $row[ea];
				$value[wdate_s] = date("Y-m-d");
				$value[whour_s] = date("H:i:s");
				$value[tbtype] = $row[tbtype];
				$value[useh] = $row['useh'];
				$value[aname] = $memname;
				$value[amemo] = $row[memo];
				insert("shop_goods_inout",$value);
				unset($value);
			}
		
	}

	

	unset($value);
	$value[wdate] = date("Y-m-d H:i:s",time());
	$value[wname] = $g_memname;
	$value[istmp] = "";
	update("shop_goods_inout_paper",$value," where index_no='$paper_idx'");
	unset($value);

	

	mysql_query("TRUNCATE TABLE `shop_goods_inout_pre`");
	
	if($errcou!=0)
	{
		echo "<Script>alert('에러 항목 : $errcou 개 에러 바코드 확인후 재입고'); </script>";
		echo "<script>location.replace('$PHP_SELF?code=inouterr&errc=$errc'); </script>";
	}
	else
	{
		echo "<script>alert('처리 완료'); location.replace('$PHP_SELF?code=stock_inout'); </script>";
	}
	exit;
}
?>
<script language="javascript">
function set_in()	{
	if($("#errorcou").val()!='0')	{
		alert('에러가 존재 합니다. 확인후 재처리 바랍니다');
		return;
	}
	answer = confirm('재고 조정 처리를 하시겠습니까?');
	if(answer==true)	{
		location.href='<?=$PHP_SELF;?>?code=<?=$code;?>&mode=w&paper_idx=<?=$paper_idx;?>';	
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품 입/출고</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="75%">
				</colgroup>
				<tr>
					<th>입고일</th>
					<td><?=date("Y-m-d");?></td>
				</tR>
				<tr>
					<th>에러갯수</th>
					<td id='h_errorcou'></td>
				</tR>
				<tr>
					<th>정상상품갯수</th>
					<td id='h_okcou'></td>
				</tR>
				<tr>
					<th>처리대상</th>
					<td id='h_totalcou'></td>
				</tR>


				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light" type="button" onclick="set_in();">처리하기</button>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품 입/출고</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">
				<colgroup>
		<col width="50px">
		<col width="60px">
	</colgroup>	
	<thead>
	<tr>
		<th>No</th>
		<th>IMG</th>
		<th>바코드</th>
		<th>상품명</th>
		<th>옵션</th>
		<th>매입가</th>
		<th>판매가</th>
		<th>수량</th>

		<th></th>
	</tr>
	</thead>
	<tbody>
<?php
$q = "select * from shop_goods_inout_pre";
$q = $q . " order by index_no asc";
$r = mysql_query($q);
$cou = 1;
$to = 0;
$ok_cou = 0;
$error_cou = 0;
$ok_cou_ea = 0;
$error_cou_ea = 0;
$no_ea = 0;
while($row = mysql_fetch_array($r))
{
	$co = "";
	if(!($cou%2)) $co = "gray";
	
	if($row[ea]!=0 && $row[codes]!='')	{
		
		$ar_codes = explode("|R|",$row['codes']);
		
		$ar_code['goods_idx'] = $ar_codes[0];
		$ar_code['op1'] = $ar_codes[1];
		$ar_code['op2'] = $ar_codes[2];
		$ar_code['op3'] = $ar_codes[3];


		$ar_goods = mysql_fetch_array(mysql_query("select index_no,simg1,gname,gdname,daccount,account,gcode from shop_goods where index_no='$ar_code[goods_idx]'"));
		
		

		$img = showimg($ar_goods,60,60);
		

		$co = "";
		if(!($cou%2)) $co = "gray";

		$to = $to + $row[ea];
		
		if($ar_code[op1]!='')
		{	unset($ar_ops1);	$ar_ops1 = sel_query("shop_goods_op1","opname"," where index_no='$ar_code[op1]'");	}
		if($ar_code[op2]!='')
		{	unset($ar_ops2);	$ar_ops2 = sel_query("shop_goods_op2","opname"," where index_no='$ar_code[op2]'");	}

		if($ar_code[op3]!='')
		{	unset($ar_ops3);	$ar_ops3 = sel_query("shop_goods_op3","opname"," where index_no='$ar_code[op3]'");	}

		$sty = "";
		if($ar_code[barcode] && $row[noea]=='0')		{
			$sty = "style='display:none;'";
		}
?>
		<tr class='<?=$co;?>' <?=$sty;?>>
		<td class="first"><?=$cou;?></td>
		<td><? if($img!=''){?><img src="<?=$img;?>"><?}?></td>
		<td><?=$row[codes];?></td>
		
		<td style='text-align:left;'>
			<?=$ar_goods[gcode];?><br />
			<a href="/shop/view.php?index_no=<?=$ar_goods[index_no];?>" target="_blank"><?=$ar_goods[gname];?></a>
			<br /><?=$ar_goods[gdname];?>
		</td>
		<td><?=$ar_ops1[opname];?><? if($ar_code[op2]!='') { echo ",".$ar_ops2[opname]; }?><? if($ar_code[op3]!='') { echo ",".$ar_ops3[opname]; }?></td>
		<td><?=number_format($ar_goods[daccount]/100);?>원</td>
		<td><?=number_format($ar_goods[account]/100);?>원</td>
		<td><?=number_format($row[ea]);?></td>

		<td>
		<?
		if(!$ar_code)
		{
			$error_cou++;
			$error_cou_ea = $error_cou_ea + $row[ea];
		?>
		에러
		<?}else{
			$ok_cou++;
			$ok_cou_ea = $ok_cou_ea + $row[ea];
			$no_ea = $no_ea  + $row[noea];
		}?>
		</td>
		</tr>
<?php
		$cou++;
	}
}
?>
	</tbody>
</table>
<input type='hidden' name='errorcou' id='errorcou'  value='<?=$error_cou;?>'>

			</div>
		</div>
	</div>
</div>
<script>
$("#h_errorcou").html("상품수량 : <?=$error_cou_ea;?>개 / <?=$error_cou;?>건");
$("#h_okcou").html("상품수량 : <?=$ok_cou_ea;?>개 / <?=$ok_cou;?>건");
$("#h_totalcou").html("상품수량 : <?=($ok_cou_ea+$error_cou_ea);?>개 / <?=($error_cou+$ok_cou);?>건");

</script>