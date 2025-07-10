<?php
ini_set("max_input_vars",10000);

$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$idx = $_REQUEST['idx'];
	$gcode = $_REQUEST['gcode'];
	$gname = $_REQUEST['gname'];
	$daccount = $_REQUEST['daccount'];
	$account = $_REQUEST['account'];
	$saccount = $_REQUEST['saccount'];

	for($i=0;$i<sizeof($idx);$i++)	{
		
		if($gname[$i]!='')	{
			$value['gname'] = $gname[$i];
		}
		if($gcode[$i]!='')	{
			$value['gcode'] = $gcode[$i];
		}
		if($daccount[$i]!='' && $daccount[$i]!='0')	{
			$value['daccount'] = $daccount[$i]*100;
		}
		if($account[$i]!='' && $account[$i]!='0')	{
			$value['account'] = $account[$i]*100;
		}
		if($saccount[$i]!='' && $saccount[$i]!='0')	{
			$value['saccount'] = $saccount[$i]*100;
		}

		if(is_array($value))	{
			update("shop_goods",$value," WHERE index_no='".$idx[$i]."'");
			unset($value);
		}
	}
	echo "<script>alert('처리완료'); location.replace('$PHP_SELF?code=goods_excel');  </script>";
	exit;
}
$removef = $_REQUEST['removef'];
$fname = $_REQUEST['fname'];


?>
<script>
function set_goodsin()	{
	answer = confirm('정보변경하시겠습니까?');
	if(answer==true)	{
		$("#listform").submit();
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="#none" onclick="set_goodsin();" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>정보변경</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 입력데이터</h3>
			</div>
			<div class="panel-content">
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>상품번호</th>
					<th>상품코드</th>
					<th>상품명</th>
					<th>공급가격(원가)</th>
					<th>판매가</th>
					<th>참고가격</th>
					
				</tr>
				</thead>
				<tbody>
<?php
require $_basedir."/inc/PHPExcel/PHPExcel.php";
$filename = $_uppath."csvs/$fname";
$objPHPExcel = PHPExcel_IOFactory::load($filename);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

foreach ( $sheetData as $rownum => $row )	{
		if($removef=='Y'){
			if($rownum=='1')	{	
				continue;	
			}
		}
		foreach ( $row as $C => $val )	{
			
			if($C=="A")	{
				$goods_idx = $val;
			}
			if($C=="B")	{
				$gcode = $val;
			}
			if($C=="C")	{
				$gname = $val;
			}
			if($C=="D")	{
				$daccount = $val;
			}
			if($C=="E")	{
				$account = intval($val);
			}
			if($C=="F")	{
				$saccount = $val;
			}
		}
?>
				<tr>
					<td>
						<input type='hidden' name='idx[]' value='<?=$goods_idx;?>'>
						<input type='hidden' name='gcode[]' value='<?=$gcode;?>'>
						<input type='hidden' name='gname[]' value='<?=$gname;?>'>
						<input type='hidden' name='daccount[]' value='<?=$daccount;?>'>
						<input type='hidden' name='account[]' value='<?=$account;?>'>
						<input type='hidden' name='saccount[]' value='<?=$saccount;?>'>
						<?=$goods_idx;?>
					</td>
					<td><?=$gcode;?></td>
					<td><?=$gname;?></td>
					<td><?=$daccount;?></td>
					<td><?=$account;?></td>
					<td><?=$saccount;?></td>
				</tr>
<?
	}
?>
				
				</tbody>
				</table>
				</form>
			</div>
		</div>
	</div>
</div>