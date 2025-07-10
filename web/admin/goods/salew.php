<?
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}
$mode = $_REQUEST['mode'];
if($mode=='w')
{
	$value['fid'] = $_REQUEST['fid'];
	$value['pid'] = $_REQUEST['pid'];
	$value['stype'] = $_REQUEST['stype'];
	$value['saledays'] = $_REQUEST['saledays'];
	$value['sdate'] = $_REQUEST[sdate].":00";
	$value['edate'] = $_REQUEST[edate].":00";
	$value['subject'] = $_POST['subject'];
	$value['subject_cus'] = $_POST['subject_cus'];
	$value['sale_t'] = $_POST['sale_t'];
	$value['saleper'] = $_POST['saleper'];
	$value['saletype'] = $_POST['saletype'];
	$value['saleper_std1'] = $_POST['saleper_std1'];
	$value['saleper_std2'] = $_POST['saleper_std2'];
	$value['ar_icon'] = serialize($_POST['icon']);
	$value['reicon'] = $_POST['reicon'];
	$value['saleops'] = $_POST['saleops'];
	$value['saleop1'] = $_POST['saleop1'];
	$value['saleop2'] = $_POST['saleop2'];
	$value['saleop3'] = $_POST['saleop3'];
	$value['wdate'] = date("Y-m-d H:i:s",time());
	$value['noreturn'] = $_POST['noreturn'];
	$value['nodels'] = $_POST['nodels'];
	insert("shop_goods_sale",$value);
	$idx = $pdo->lastInsertId();
	unset($value);



	if($stype=='3')	{

		$userfile = array($_FILES['file']['name']);
		$tmpfile = array($_FILES['file']['tmp_name']);
	
		$savedir = "./csvs/";

		for($i=0;$i<sizeof($userfile);$i++)	{	
			$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	
		}

		if($fs[0]!='')	{
			require $dir."/inc/PHPExcel/PHPExcel.php";

			$filename = "./csvs/".$fs[0];
		
			$objPHPExcel = PHPExcel_IOFactory::load($filename);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

			foreach ( $sheetData as $rownum => $row )	{
				if($removef=='Y')	{
					if($rownum=='1')	{
						continue;	
					}

				}
				foreach ( $row as $C => $val )	{
			
					if($C=="A")	{
						$goods_idx = $val;	
					}
					if($C=="B")	{
						$account = $val;	
					}
				}
				if($account)	{

					$ar_goods = sel_query_all("shop_goods"," WHERE idx='$goods_idx'");

					if($ar_goods[master_idx]=='0')	{
			
						$value['sale_idx'] = $idx;
						$value['goods_idx'] = $goods_idx;
						$value['saleaccount'] = $account;
						insert("shop_goods_sale_ele",$value);
						unset($value);
					}
				}
			}
		}
	}


	$fid = $_REQUEST['fid'];

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=goods_salem&fid=$fid'); </script>";
	exit;
}
?>
<link rel="stylesheet" href="/assets/global/css/jquery.datetimepicker.css">
<script src="/assets/global/js/jquery.datetimepicker.full.js"></script>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('등록 하시겠습니까?');
		if(answer==true)	{
			return true;
		}
		else	{
			return false;
		}
	}
	else	{
		return false;
	}
}
</script>
<Script>
function set_pids()
	{
		var fid = $('#fid option:selected').val();
	
		var param = "fid="+fid+"&site_mobile=in";
		$.ajax({
		type:"GET",
		url:"/ajaxmo/get_pid.php",
		dataType: "html",
		data:param,
		success:function(msg){
			$('#pid').html(msg);
		}
		});
	}
</script>
<script>
$(function(){
  $('#sdate').datetimepicker({
	  lang:'ko',
	  format:'Y-m-d H:i'
  });

  $('#edate').datetimepicker({
	  lang:'ko',
	  format:'Y-m-d H:i'
  });
})

function set_stype(mod)
{
	if(mod=='1')
	{
		$("#stype1_1").show();
		$("#stype2_1").hide();
		$("#stype2_2").hide();
		$("#stype3_1").show();
		$("#stype3_2").show();
		$("#stype3_3").hide();
	}

	if(mod=='2')
	{
		$("#stype2_1").show();
		$("#stype2_2").show();
		$("#stype1_1").hide();
		$("#stype3_1").show();
		$("#stype3_2").show();
		$("#stype3_3").hide();
	}

	if(mod=='3')
	{
		$("#stype2_1").show();
		$("#stype2_2").hide();
		$("#stype1_1").hide();
		$("#stype3_1").hide();
		$("#stype3_2").hide();
		$("#stype3_3").show();
	}

	if(mod=='4')
	{
		$("#stype2_1").show();
		$("#stype2_2").hide();
		$("#stype1_1").hide();
		$("#stype3_1").hide();
		$("#stype3_2").hide();
		$("#stype3_3").hide();
	}

}
</script>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header panel-controls">
				<h3><i class="fa fa-table"></i> 할인등록</h3>
			</div>
			<div class="panel-content">

<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich();" ENCTYPE="multipart/form-data">
<input type='hidden' name='mode' value='w'>
<table class="table table-bordered">
<tr>
	<th>사용처</th>
	<td>
	<select class="uch" name='fid' id='fid' onchange="set_pids();">
	<option value=''>사용처선택</option>
<?php
$q = "select * from shop_sites";
$st = $pdo->prepare($q);
$st->execute();	
while($row = $st->fetch())
{
	if(in_array($row['idx'],$ar_mempriv))
	{	
		if($fid==$row['idx'])
		{	echo "<option value='$row[idx]' selected>$row[sitename]</option>";		}
		else
		{	echo "<option value='$row[idx]'>$row[sitename]</option>";		}
	}
}
?>
</select>
<select class="uch" name='pid' id="pid">
						<option value=''>전체</option>	
						<?
						if($fid)
						{
							$q = "Select * from shop_config where fid='$fid' and site_mobile IN ('','Y') order by idx asc";
							$st = $pdo->prepare($q);
							$st->execute();	
							while($row = $st->fetch())
							{	
								if($spid==$row['idx'])
								{	echo "<option value='$row[idx]' selected>$row[site_name]</option>";		}
								else
								{	echo "<option value='$row[idx]'>$row[site_name]</option>";		}
							}
						}
						?>
						</select>
	
	</td>
</tr>
<tr>
	<th>할인정책명</th>
	<td><input type='text' class="form-control" name='subject' class='basic_input' style='width:200px;'></td>
</tr>
<tr>
	<th>고객노출명</th>
	<td><input type='text' class="form-control" name='subject_cus' class='basic_input' style='width:200px;'></td>
</tr>
<tr>
	<th>할인구분</th>
	<td>
		<label><input type='radio' name='stype' value='1' onclick="set_stype('1');">신상할인 </label>
		<label><input type='radio' name='stype' value='2' onclick="set_stype('2');">일반할인 </label> 
		<label><input type='radio' name='stype' value='3' onclick="set_stype('3');">일반할인[가격개별설정] </label>
		
	</td>
</tr>


<tr id="stype1_1" style='display:none;'>
	<th>할인시간</th>
	<td>
		<div class="form-inline">
		상품등록일로 부터 <input type='text' class="form-control" name='saledays' size='4'>시간 까지
		</div>
	</td>
</tr>
<tr id="stype2_1" style='display:none;'>
	<th>할인기간</th>
	<td>
		<div class="form-inline">
		<input type='text' class="form-control" name='sdate' id="sdate" size='20' readonly> ~ <input type='text' class="form-control" name='edate' id="edate" size='20' readonly>
		</div>
	</td>
</tr>

<tr id="stype2_2" style='display:none;'>
	<th>할인대상상품</th>
	<td>
		<select name='sale_t'>
		<option value='1'>상품개별지정</option>
		<option value='2'>전체상품</option>
		<option value='3'>특정카테고리</option>
		<option value='4'>기획전상품</option>
		</select>
	</td>
</tr>

<tr id="stype3_1" style='display:none;'>
	<th>할인률</th>
	<td>
	<div class="form-inline">
	<input type='text' class="form-control" name='saleper' class='basic_input' style='width:40px;'>
	
	<select name='saletype'>
	<option value='1'>%</option>
	<option value='2'>원</option>
	</select>
	
	<input type='text' class="form-control" name='saleper_std1' value='' size='2'> 단위 <select name='saleper_std2'>
	<option value='1'>올림</option>
	<option value='2'>반올림</option>
	<option value='3'>내림</option>
	</select>
	[할인율은 등록후 변경불가]
	</div>
	</td>
</tr>

<tr id="stype3_2"  style='display:none;'>
	<th>옵션가할인</th>
	<td>
		<div class="form-inline">	
		<input type='radio' name='saleops' value='1'>옵션가까지할인 <input type='radio' name='saleops' value='2'>할인안함
		</div>
	</td>
</tr>
<tr id="stype3_3" style='display:none;'>
	<th>세일파일</th>
	<td>
		<div class="form-inline">
		<input type='file' name='file'> [파일등록 하지 않으면, 수정화면에서 개별로 설정이 가능합니다.] <label><input type='checkbox' name='removef' value='Y'>첫열제외</label> [A열 상품번호, B열판매가격]
		</div>
	</td>
</tr>
<tr>
	<th>쳥약철회</th>
	<td><select name='noreturn'>
	<option value='Y'>사용</option>
	<option value='N'>미사용</option>
	</select></td>
</tr>

<tr>
	<th>배송비처리</th>
	<td>배송비 산정시 계산에 <select name='nodels'>
	<option value='N'>포함합니다</option>
	<option value='Y'>제외합니다</option>
	</select></td>
</tr>
<tr>
	<th>할인옵션</th>
	<td><select name='saleop1'>
	<option value='1'>회원/비회원할인</option>
	<option value='2'>회원만할인</option>
	</select></td>
</tr>


<tr>
	<th>적립금적용</th>
	<td><select name='saleop2'>
	<option value='1'>적립금지급</option>
	<option value='2'>적립금지급안함</option>
	</select></td>
</tr>

<tr>
	<th>쿠폰적용</th>
	<td><select name='saleop3'>
	<option value='1'>쿠폰적용</option>
	<option value='2'>쿠폰적용안함</option>
	</select></td>
</tr>


<tr>
	<th>아이콘대처여부</th>
	<td><select name='reicon'>
	<option value='Y'>기존아이콘추가</option>
	<option value='N'>기존아이콘대체</option>
	</select></td>
</tr>
<tr>
	<th>아이콘</th>
	<td>
				<table cellpadding="0" cellspacing="0"><?php
				$q = "select * from shop_config_icon where isuse='Y'";
				$st = $pdo->prepare($q);
				$st->execute();	
				$cou = 0;
				while($row = $st->fetch())
				{	
					if($row['wuse']=='')
					{
						if($cou%6==0)
						{	echo "<tr>";	}
				
						echo "<Td><input type='checkbox' name='icon[]' value='$row[fname]'><img src='$_imgserver/files/icon/$row[fname]'></th>";		
				
						if($cou%6==5)
						{	echo "</tr>";	}
						$cou++;
					}
				}
				?>	</table>
	</td>
</tr>
</table>
<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
						
					</div>
				</div>
</form><!-- // form[name="regiform"] -->
</div><!-- // .form_wrap -->
</div><!-- // .content -->
</div>
</div>