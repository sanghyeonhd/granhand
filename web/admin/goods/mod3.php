<?php

$idx = $_REQUEST['idx'];
$ar_data = sel_query_all("shop_goods"," WHERE idx='$idx'");
if($mode=='w')	{

	$canmodop = "Y";
	$q = "select * from shop_goods_lefts where goods_idx='$idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();
	if($isit>0)	{
		$canmodop = "N";
	}

	$q = "Select * from shop_newbasket where goods_idx='$idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit>0) {
		$canmodop = "N";
	}
	$logs = "";
	if($canmodop=='Y')	{
		$pdo->prepare("delete from shop_newbasket_tmp where goods_idx='$idx'")->execute();
	
		$value['useop1'] = $_POST['useop1'];
		$value['useop2'] = $_POST['useop2'];
		$value['useop3'] = $_POST['useop3'];

		if($ar_data['useop1']!=$_POST['useop1'])	{
			$logs = $logs .  "옵션1 사용여부 : ".$ar_data['useop1']." => ".$_POST['useop1']."\n\r";
		}
		if($ar_data['useop2']!=$_POST['useop2'])	{
			$logs = $logs .  "옵션2 사용여부 : ".$ar_data['useop2']." => ".$_POST['useop2']."\n\r";
		}
		if($ar_data['useop3']!=$_POST['useop3'])	{
			$logs = $logs .  "옵션3 사용여부 : ".$ar_data['useop3']." => ".$_POST['useop3']."\n\r";
		}
	}
	$value['opname1'] = $_POST['opname1'];
	if($ar_data['opname1']!=$_POST['opname1'])	{
		$logs = $logs .  "옵션1명칭 : ".$ar_data['opname1']." => ".$_POST['opname1']."\n\r";
	}


	$value['opname2'] = $_POST['opname2'];
	if($ar_data['opname2']!=$_POST['opname2'])	{
		$logs = $logs .  "옵션2명칭 : ".$ar_data['opname2']." => ".$_POST['opname2']."\n\r";
	}

	$value['opname3'] = $_POST['opname3'];
	if($ar_data['opname3']!=$_POST['opname3'])	{
		$logs = $logs .  "옵션3명칭 : ".$ar_data['opname3']." => ".$_POST['opname3']."\n\r";
	}

	update("shop_goods",$value," where idx='$idx'");
	unset($value);
	
	if($logs!='')	{
		$value['goods_idx'] = $idx;
		$value['memo'] = $logs;
		$value['wdate'] = date("Y-m-d H:i:s",time());
		$value['mem_name'] = $g_memname;
		insert("shop_goods_log",$value);
		unset($value);
	}

	echo "<script>alert('설정완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;
}
if($mode=='nch')	{

	for($i=0;$i<sizeof($opidx);$i++)	{
		
		$value[opname] = $opname[$i];
		$value[msgs] = $msgs[$i];
		$value[opname_add] = $opname_add[$i];
		$value[opname_add2] = $opname_add2[$i];
		$value[addac] = $addac[$i]*100;
		$value[adddac] = $adddac[$i]*100;
		$value[isuse] = $isuse[$i];
		$value[mop] = $mop[$i];
		update($tb,$value," WHERE idx='{$opidx[$i]}'");

		unset($value);

	}
	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;
}
if($mode=='wopadd')
{
	$rel_goods_idx_add = $_REQUEST['rel_goods_idx_add'];
	if(!$addac)
	{
		$ar_rg = sel_query("shop_goods","account"," where idx='$rel_goods_idx_add'");
		$addac = $ar_rg[account];

	}
	

	$value[mbuy] = $mbuy;
	$value[goods_idx] = $idx;
	$value[rel_goods] = $rel_goods_idx_add;
	$value[opname] = $opname;
	$value[usename] = $usename;
	$value[addac] = $addac;
	insert("shop_goods_opadd",$value);

	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;

}
if($mode=='w2')
{
	$tb = $_REQUEST['tb'];
	$ops = $_REQUEST['ops'];
	$addcolor = $_REQUEST['addcolor'];

	if($ops)
	{
		$ar_color = sel_query_all("shop_config_color"," where idx='$ops'");

		$value[opname] = $ar_color[cname];
		$value[opname_add] = $ar_color[ccode1];
		$value[opname_add2] = $ar_color[ccode2];
	}
	else
	{
	
		$opname = $_REQUEST['opname'];


		$sel = $_REQUEST['sel'];
		$value[opname] = trim($opname);
		$value[opname_add] = trim($_POST['opname_add']);
		$value[opname_add2] = trim($_POST['opname_add2']);

		if($addcolor=='Y')
		{
			$q = "select * from shop_config_color where cname='$value[opname]' and ccode='$value[opname_add]'";
			$r = mysqli_query($connect,$q);
			$isit = mysqli_num_rows($r);

			if($isit==0)
			{
				$value2[cname] = $value[opname];
				$value2[ccode] = $value[opname_add];
				insert("shop_config_color",$value2);
				unset($value2);
			}
		}
	}
	
	$value[goods_idx] = $idx;

	$value[isuse] = "Y";
	$value[addac] = $_POST['addac']*100;
	$value[adddac] = $_POST['adddac']*100;
	insert("${tb}",$value);
	unset($value);


	$value['goods_idx'] = $idx;
	$value['memo'] = str_replace("shop_goods_","",$tb)." - ".$opname." 추가";
	$value['wdate'] = date("Y-m-d H:i:s",time());
	$value['mem_name'] = $g_memname;
	insert("shop_goods_log",$value);
	unset($value);
	

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;

}
if($mode=='d')
{
	$tb = $_REQUEST['tb'];
	$op_idx = $_REQUEST['op_idx'];
	$fi = $_REQUEST['fi'];

	$ar_ops = sel_query_all("${tb}"," where idx='$op_idx'");


	$q = "select idx from shop_newbasket_tmp where goods_idx='$idx' and $fi='$ar_ops[idx]'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();
	if($isit!=0)
	{
		echo "<Script>alert('고객이 주문한 상품옵션은 삭제할수 없습니다'); history.back(); </script>";
		exit;	
	}


	$q = "select idx from shop_newbasket where goods_idx='$idx' and $fi='$ar_ops[idx]'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit!=0)
	{
		echo "<Script>alert('고객이 주문한 상품옵션은 삭제할수 없습니다'); history.back(); </script>";
		exit;
	}


	$q = "select idx from shop_goods_lefts where goods_idx='$idx' and $fi='$ar_ops[idx]'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit!=0)
	{
		echo "<Script>alert('입고되어 재고가 존재하는 옵션은 삭제 불가합니다.'); history.back(); </script>";
		exit;
	}

	$pdo->prepare("DELETE FROM $tb WHERE idx='$op_idx'")->execute();


	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;
}
if($mode=='barmod')	{
	
	$op1 = $_REQUEST['op1'];
	$op2 = $_REQUEST['op2'];
	$op3 = $_REQUEST['op3'];
	$barcode = $_REQUEST['barcode'];
	
	for($i=0;$i<sizeof($op1);$i++)	{
		
		$ar_barcode = sel_query_all("shop_goods_barcode"," WHERE goods_idx='$idx' and op1='".$op1[$i]."' and op2='".$op2[$i]."' and op3='".$op3[$i]."'");

		$value['barcode'] = $barcode[$i];
		if($ar_barcode['idx'])	{

			update("shop_goods_barcode",$value," WHERE idx='".$ar_barcode['idx']."'");
			unset($value);
		}
		else	{
			$value['goods_idx'] = $idx;
			$value['op1'] = $op1[$i];
			$value['op2'] = $op2[$i];
			$value['op3'] = $op3[$i];
			insert("shop_goods_barcode",$value);
		}

	}
	
	show_message("수정완료","");
	move_link("$PHP_SELF?code=$code&idx=$idx");
	exit;
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="m-t-10 m-b-10 no-print"> 
			<a href="<?=$PHP_SELF;?>?code=goods_mod1&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상품정보수정</a>
			<!-- <a href="<?=$PHP_SELF;?>?code=goods_mod2&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상세이미지관리</a> -->
			<? if($ar_data['gtype']=='1') {	?>
            <a href="<?=$PHP_SELF;?>?code=goods_mod3&idx=<?=$idx;?>" class="btn btn-primary m-r-10 m-b-10">옵션관리</a>
			
			<?}?>
			<? if($ar_data['gtype']=='2') {	?>
            <a href="<?=$PHP_SELF;?>?code=goods_modsets&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">세트상품관리</a>
			<?}?>
			<a href="<?=$PHP_SELF;?>?code=goods_mod7&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관리자리뷰관리</a> 
           
			<a href="<?=$PHP_SELF;?>?code=goods_mod4&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관련상품관리</a>                
            <a href="<?=$PHP_SELF;?>?code=goods_mod5&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관련후기상품관리</a>
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod6&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상품사이즈정보관리</a> -->
            <a href="<?=$PHP_SELF;?>?code=goods_mod8&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상품수정로그</a>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 옵션사용설정</h3>
			</div>
			<div class="panel-content">
				<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='idx' value='<?=$idx;?>'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>상품명</th>
					<td colspan='3'>
						<?=$ar_data['gname'];?>
					</td>
				</tr>
				<?php
				for($i=1;$i<4;$i++)	{
				?>
				<tr>
					<th>옵션<?php echo $i;?></th>
					<td>
						<select name='useop<?=$i;?>'>
						<option value='Y' <? if($ar_data['useop'.$i]=='Y') { echo "Selected";	}?>>사용</option>
						<option value='N' <? if($ar_data['useop'.$i]!='Y') { echo "Selected";	}?>>사용안함</option>
						</select>
					</td>
					<th>옵션<?php echo $i;?>명칭</th>
					<td>
						<input type='text' name="opname<?php echo $i;?>" class="form-control" value="<?=$ar_data['opname'.$i];?>">
					</td>
				</tr>
				<?php
				}
				?>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">수정하기</button>
						
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
				<h3><i class="fa fa-table"></i> 옵션별코드관리</h3>
			</div>
			<div class="panel-content">
				<form name="barform" id="barform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='barmod'>
				<input type='hidden' name='idx' value='<?=$idx;?>'>
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>옵션1</th>
					<th>옵션2</th>
					<th>옵션3</th>
					<th>바코드</th>
				</thead>
				<tbody>
	<?php
	unset($ar_op1);
	unset($ar_opname1);
	unset($ar_op2);
	unset($ar_opname2);
	unset($ar_op3);
	unset($ar_opname3);

	$ar_op1[0] = "";
	$ar_op2[0] = "";
	$ar_op3[0] = "";

	$q1 = "SELECT * FROM shop_goods_op1 WHERE goods_idx='$idx' order by orders ASC";
	$st1 = $pdo->prepare($q1);
	$st1 -> execute();
	$lcou = 0;
	while($row1 = $st1->fetch())	{
		$ar_op1[$lcou] = $row1['idx'];
		$ar_opname1[$row1['idx']] = $row1;
		$lcou++;
	}

	$q1 = "SELECT * FROM shop_goods_op2 WHERE goods_idx='$idx' order by orders ASC";
	$st1 = $pdo->prepare($q1);
	$st1 -> execute();
	$lcou = 0;
	while($row1 = $st1->fetch())	{
		$ar_op2[$lcou] = $row1['idx'];
		$ar_opname2[$row1['idx']] = $row1;
		$lcou++;
	}

	$q1 = "SELECT * FROM shop_goods_op3 WHERE goods_idx='$idx' order by orders ASC";
	$st1 = $pdo->prepare($q1);
	$st1 -> execute();
	$lcou = 0;
	while($row1 = $st1->fetch())	{
		$ar_op3[$lcou] = $row1['idx'];
		$ar_opname3[$row1['idx']] = $row1;
		$lcou++;
	}
	
	for ($i = 0; $i < sizeof($ar_op1); $i++)	{
		for ($j = 0; $j < sizeof($ar_op2); $j++)	{
			for ($k = 0; $k < sizeof($ar_op3); $k++)	{

				$ar_barcode = sel_query_all("shop_goods_barcode"," WHERE goods_idx='$idx' and op1='".$ar_op1[$i]."' and op2='".$ar_op2[$j]."' and op3='".$ar_op3[$k]."'");

?>				
				<tr>
					<td>
						<?
						
						if(is_array($ar_opname1))	{
							echo $ar_opname1[$ar_op1[$i]]['opname'];
						}
						?>
					</td>
					<td>
						<?
						if(is_array($ar_opname1))	{
							echo $ar_opname2[$ar_op2[$j]]['opname'];
						}
						?>
					</td>
					<td>
						<?
						if(is_array($ar_opname3))	{
							echo $ar_opname3[$ar_op3[$k]]['opname'];
						}
						?>
					</td>
					<TD>
						<input type='hidden' name='op1[]' value='<?=$ar_op1[$i];?>'>
						<input type='hidden' name='op2[]' value='<?=$ar_op2[$j];?>'>
						<input type='hidden' name='op3[]' value='<?=$ar_op3[$k];?>'>
						<input type='text' name='barcode[]' value='<?=$ar_barcode['barcode'];?>' class="form-control">
					</td>
				</tr>
<?
			}
		}
	}
?>


				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#barform">수정하기</button>
						
					</div>
				</div>
				</form>


			</div>
		</div>
	</div>
</div>
<?php
for($i=1;$i<4;$i++)	{

	if($ar_data['useop'.$i]=='Y')	{
		$tb = "shop_goods_op".$i;
?>	
<div class="row">
	<div class="col-md-8">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i>옵션<?=$i;?>관리</h3>
			</div>
			<div class="panel-content">
				<form id="formop<?=$tb;?>" name="formop<?=$tb;?>" method="post">
				<input type='hidden' name='tb' value='<?=$tb;?>'>
				<input type='hidden' name='mode' value='nch'>
				<input type='hidden' name='idx' value='<?=$idx;?>'>
				
				<table class="table table-bordered">

				<thead>
				<tr>
					<th>번호</th>
					<th>옵션항목</th>
					<th>추가금액</th>
					<th>추가원가</th>
					<th>사용여부</th>
					<th>불량옵션</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "Select * from shop_goods_op".$i." where goods_idx='$idx' order by orders asc,idx asc";
				$st = $pdo->prepare($q);
                $st->execute();
				while($row = $st->fetch())	{
				?>
			
				<tr>
					<td><?=$cou;?> - <?=$row[idx];?></td>
					<td><input type='hidden' name='opidx[]' value='<?=$row[idx];?>'><input type='text' class="form-control" name='opname[]' value='<?=$row[opname];?>'></td>
					<td>
						<div class="form-inline">
							<input type='text' class="form-control" name='addac[]' value='<?=$row[addac]/100;?>'>원
						</div>
					</td>
					<Td>
						<div class="form-inline">
							<input type='text' class="form-control" name='adddac[]' value='<?=$row[adddac]/100;?>'>원
						</div>
					</td>
					<td>
						<Select class="uch" name='isuse[]'><option value='Y' <? if($row[isuse]=='Y') { echo "selected";	}?>>사용함</option><option value='N' <? if($row[isuse]=='N') { echo "selected";	}?>>사용안함</option></select>
					</td>
					<td><input type='checkbox' name='mop[]' <? if($row[mop]=='Y') { echo "checked";	}?> value='Y'></td>
					<td>
						<a class="btn btn-xs btn-primary" href="javascript:delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=d&idx=<?=$idx;?>&op_idx=<?=$row[idx];?>&tb=<?=$tb;?>&fi=<?="op".$i;?>','삭제?');">삭제</a>
					</td>
				</tr>

				<?php
					$cou++;
				}
				?>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#formop<?=$tb;?>">수정하기</button>
						
					</div>
				</div>

				
				</form>

			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i>옵션<?=$i;?>등록</h3>
			</div>
			<div class="panel-content">
				<form id="form2<?=$i;?>" name="form2<?=$i;?>" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='w2'>
				<input type='hidden' name='tb' value='<?=$tb;?>'>
				<input type='hidden' name='sel' value='<?=$i;?>'>
				<input type='hidden' name='idx' value='<?=$idx;?>'>
				<table class="table table-bordered">
				<tr>
					<th>옵션항목</th>
					<td><input type='text' name='opname' class="form-control"></td>
				</tr>
				<tr>
					<th>추가금액</th>
					<td>
						<div class="form-inline">
							<input type='text' name='addac' class="form-control" value='0'>원
						</div>
					</td>
				</tr>
				<tr>
					<th>추가원가</th>
					<td>
						<div class="form-inline">
							<input type='text' name='adddac' class="form-control" value='0'>원
						</div>
					</td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#form2<?=$i;?>">등록하기</button>
						
					</div>
				</div>

				</form>
			</div>
		</div>
	</div>
</div>
<?
	}
}
?>