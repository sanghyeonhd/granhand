<?
$mode = $_REQUEST['mode'];
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_goods_sale"," where index_no='$index_no'");
if($mode=='w')
{
	$value[fid] = $_REQUEST['fid'];
	$value[pid] = $_REQUEST['pid'];
	$value[saledays] = $_REQUEST['saledays'];
	$value[sdate] = $_REQUEST[sdate].":00";
	$value[edate] = $_REQUEST[edate].":00";
	$value[subject] = $_POST['subject'];
	$value[subject_cus] = $_POST['subject_cus'];
	$value[sale_t] = $_POST['sale_t'];
	$value[saleper_std1] = $_POST['saleper_std1'];
	$value[saleper_std2] = $_POST['saleper_std2'];
	$value[ar_icon] = serialize($_POST['icon']);
	$value[reicon] = $_POST['reicon'];
	$value[saleops] = $_POST['saleops'];
	$value[saleop1] = $_POST['saleop1'];
	$value[saleop2] = $_POST['saleop2'];
	$value[saleop3] = $_POST['saleop3'];
	$value[noreturn] = $_POST['noreturn'];
	$value[nodels] = $_POST['nodels'];
	update("shop_goods_sale",$value," where index_no='$index_no'");

	$fid = $_REQUEST['fid'];

	echo "<script>alert('수정완료'); location.replace('$PHP_SELF?code=salenm&index_no=$index_no'); </script>";
	exit;
}
?>
<link rel="stylesheet" href="./css/jquery.datetimepicker.css">
<script src="./js/jquery.datetimepicker.full.js"></script>
<script language="javascript">
function regich()
{
	if($("#fid option:selected").val()=='')
	{
		alert('판매처를 선택하세요');
		return false;
	}
	if(!document.regiform.subject.value)
	{
		alert('메뉴명을 입력하세요.');
		document.regiform.subject.focus();
		return false;
	}
	answer = confirm('등록 하시겠습니까?');
	if(answer==true)
	{	return true;	}
	else
	{	return false;	}
}
</script>
<Script>
function set_pids()
	{
		var fid = $('#fid option:selected').val();
	
		var param = "fid="+fid+"&site_mobile=in";
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
</script>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header panel-controls">
				<h3><i class="fa fa-table"></i> 할인등록</h3>
			</div>
			<div class="panel-content">


<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich();">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='ar_icon' value=''>
<input type='hidden' name='index_no' value='<?=$index_no;?>'>
<table class="table table-bordered">
<tr>
	<th>사용처</th>
	<td>
	<select class="uch" name='fid' id='fid' onchange="set_pids();">
<?php
$q = "select * from shop_sites";
$r = mysql_query($q);
while($row = mysql_fetch_array($r))
{
	if(in_array($row[index_no],$ar_mempriv))
	{	
		if($row[index_no]==$ar_data[fid])
		{	echo "<option value='$row[index_no]' selected>$row[sitename]</option>";		}
	}
}
?>
</select>
<select class="uch" name='pid' id="pid">
						<option value=''>전체</option>	
						<?
						if($ar_data[fid])
						{
							$q = "Select * from shop_config where fid='$ar_data[fid]' and site_mobile IN ('','Y') order by index_no asc";
							$r = mysql_query($q);
							while($row = mysql_fetch_array($r))
							{	
								if($ar_data[pid]==$row[index_no])
								{	echo "<option value='$row[index_no]' selected>$row[site_name]</option>";		}
								else
								{	echo "<option value='$row[index_no]'>$row[site_name]</option>";		}
							}
						}
						?>
						</select>
	
	</td>
</tr>
<tr>
	<th>할인정책명</th>
	<td><input type='text' class="form-control" name='subject' class='basic_input' value='<?=$ar_data[subject];?>' style='width:200px;'></td>
</tr>
<tr>
	<th>고객노출명</th>
	<td><input type='text' class="form-control" name='subject_cus' class='basic_input' value='<?=$ar_data[subject_cus];?>' style='width:200px;'></td>
</tr>
<tr>
	<th>구분</th>
	<td><? if($ar_data[stype]=='1') { echo "신상할인";	} else if($ar_data[stype]=='2') {	echo "일반할인";	} else if($ar_data[stype]=='3') {	echo "일반할인[개별설정]";	} else if($ar_data[stype]=='4') {	echo "도매타임";	}?></td>
</tr>
<?
if($ar_data[stype]=='1')
{
?>
<tr id="stype1_1">
	<th>할인시간</th>
	<td>상품등록일로 부터 <input type='text' class="form-control" name='saledays' value='<?=$ar_data[saledays];?>' size='4'>시간 까지</td>
</tr>
<tr>
	<th>할인률</th>
	<td><?=$ar_data[saleper];?> <? if($ar_data[saletype]=='1') { echo "%";	}?> <? if($ar_data[saletype]=='2') { echo "원";	}?>

	<input type='text' class="form-control" name='saleper_std1' value='<?=$ar_data[saleper_std1];?>' size='2'> 단위 <select name='saleper_std2'>
	<option value='1' <? if($ar_data[saleper_std2]=='1') { echo "selected";	}?>>올림</option>
	<option value='2' <? if($ar_data[saleper_std2]=='2') { echo "selected";	}?>>반올림</option>
	<option value='3' <? if($ar_data[saleper_std2]=='3') { echo "selected";	}?>>내림</option>
	</select>
	</td>
</tr>
<tr>
	<th>옵션가할인</th>
	<td><input type='radio' name='saleops' value='1'  <? if($ar_data[saleops]=='1') { echo "checked";	}?>>옵션가까지할인 <input type='radio' name='saleops' value='2' <? if($ar_data[saleops]=='2') { echo "checked";	}?>>할인안함</td>
</tr>
<?}?>
<?
if($ar_data[stype]=='2')
{
?>
<tr id="stype2_1">
	<th>할인기간</th>
	<td>
		<div class="form-inline">
	<input type='text' class="form-control" name='sdate' id="sdate" value='<?=substr($ar_data[sdate],0,16);?>' size='20' readonly> ~ <input type='text' class="form-control" name='edate' id="edate" value='<?=substr($ar_data[edate],0,16);?>' size='20' readonly></div></td>
</tr>

<tr id="stype2_2">
	<th>할인대상상품</th>
	<td>
		<select name='sale_t'>
		<option value='1' <? if($ar_data[sale_t]=='1'){ echo "selected";	}?>>상품개별지정</option>
		<option value='2' <? if($ar_data[sale_t]=='2'){ echo "selected";	}?>>전체상품</option>
		<option value='3' <? if($ar_data[sale_t]=='3'){ echo "selected";	}?>>특정카테고리</option>
		<option value='4' <? if($ar_data[sale_t]=='4'){ echo "selected";	}?>>기획전상품</option>
		</select>
	</td>
</tr>
<tr>
	<th>할인률</th>
	<td>
	<div class="form-inline">	
	<?=$ar_data[saleper];?> <? if($ar_data[saletype]=='1') { echo "%";	}?> <? if($ar_data[saletype]=='2') { echo "원";	}?>

	<input type='text' class="form-control" name='saleper_std1' value='<?=$ar_data[saleper_std1];?>' size='2'> 단위 <select name='saleper_std2'>
	<option value='1' <? if($ar_data[saleper_std2]=='1') { echo "selected";	}?>>올림</option>
	<option value='2' <? if($ar_data[saleper_std2]=='2') { echo "selected";	}?>>반올림</option>
	<option value='3' <? if($ar_data[saleper_std2]=='3') { echo "selected";	}?>>내림</option>
	</select>
	</div>
	</td>
</tr>
<tr>
	<th>옵션가할인</th>
	<td>
		<div class="form-inline">
		<input type='radio' name='saleops' value='1'  <? if($ar_data[saleops]=='1') { echo "checked";	}?>>옵션가까지할인 <input type='radio' name='saleops' value='2' <? if($ar_data[saleops]=='2') { echo "checked";	}?>>할인안
		</div>
	</td>
</tr>
<?}?>
<?
if($ar_data[stype]=='3' || $ar_data[stype]=='4')
{
?>
<tr id="stype2_1">
	<th>할인기간</th>
	<td>
		goods_
		<input type='text' class="form-control" name='sdate' id="sdate" value='<?=substr($ar_data[sdate],0,16);?>' size='20' readonly> ~ <input type='text' class="form-control" name='edate' id="edate" value='<?=substr($ar_data[edate],0,16);?>' size='20' readonly>
		</div>
	</td>
</tr>
<?}?>

<tr>
	<th>쳥약철회</th>
	<td><select name='noreturn'>
	<option value='Y' <? if($ar_data[noreturn]=='Y') { echo "selected";	}?>>사용</option>
	<option value='N' <? if($ar_data[noreturn]=='N') { echo "selected";	}?>>미사용</option>
	</select></td>
</tr>

<tr>
	<th>배송비처리</th>
	<td>배송비 산정시 계산에 <select name='nodels'>
	<option value='N' <? if($ar_data[nodels]=='N') { echo "selected";	}?>>포함합니다</option>
	<option value='Y' <? if($ar_data[nodels]=='Y') { echo "selected";	}?>>제외합니다</option>
	</select></td>
</tr>



<tr>
	<th>할인옵션</th>
	<td><select name='saleop1'>
	<option value='1' <? if($ar_data[saleop1]=='1') { echo "selected";	}?>>회원/비회원할인</option>
	<option value='2' <? if($ar_data[saleop1]=='2') { echo "selected";	}?>>회원만할인</option>
	</select></td>
</tr>


<tr>
	<th>적립금적용</th>
	<td><select name='saleop2'>
	<option value='1' <? if($ar_data[saleop2]=='1') { echo "selected";	}?>>적립금지급</option>
	<option value='2' <? if($ar_data[saleop2]=='2') { echo "selected";	}?>>적립금지급안함</option>
	</select></td>
</tr>

<tr>
	<th>쿠폰적용</th>
	<td><select name='saleop3'>
	<option value='1' <? if($ar_data[saleop3]=='1') { echo "selected";	}?>>쿠폰적용</option>
	<option value='2' <? if($ar_data[saleop3]=='2') { echo "selected";	}?>>쿠폰적용안함</option>
	</select></td>
</tr>
<tr>
	<th>아이콘대처여부</th>
	<td><select name='reicon'>
	<option value='Y' <? if($ar_data[reicon]=='Y') { echo "selected";	}?>>기존아이콘추가</option>
	<option value='N' <? if($ar_data[reicon]=='N') { echo "selected";	}?>>기존아이콘대체</option>
	</select></td>
</tr>
<tr>
	<th>추가아이콘</th>
	<td>
				<table cellpadding="0" cellspacing="0"><?php
				$ar_icon = unserialize($ar_data[ar_icon]);
				$q = "select * from shop_config_icon where isuse='Y'";
				$r = mysql_query($q);
				$cou = 0;
				while($row = mysql_fetch_array($r))
				{	
					if($row[wuse]=='')
					{
						if($cou%6==0)
						{	echo "<tr>";	}
						
						if(is_array($ar_icon))
						{
							if(in_array($row[fname],$ar_icon))
							{	echo "<Td><input type='checkbox' name='icon[]' value='$row[fname]' checked><img src='$_imgserver/files/icon/$row[fname]'></th>";		}
							else
							{	echo "<Td><input type='checkbox' name='icon[]' value='$row[fname]'><img src='$_imgserver/files/icon/$row[fname]'></th>";		}
						}
						else
						{	echo "<Td><input type='checkbox' name='icon[]' value='$row[fname]'><img src='$_imgserver/files/icon/$row[fname]'></th>";		}
				
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
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">수정하기</button>
						
					</div>
				</div>

</form><!-- // form[name="regiform"] -->
</div><!-- // .form_wrap -->
</div><!-- // .content -->
</div><!-- // .content -->
</div><!-- // .content -->