<?php
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_coupen"," where index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='w1')
{
	
	if ( 2 == $_POST['isserial'] ) {
		if ( 1 > strlen($_POST['serialnum']) ) {
			echo "<script>alert('지정시리얼번호 입력해주세요.');window.history.back()</script>";
			exit;
		}
		
		$ar_cnt = sel_query("shop_coupen", "COUNT(*) AS cnt" ," WHERE serialnum = '{$_POST['serialnum']}' and index_no!='$index_no'");
		if ( $ar_cnt[cnt] ) {
			echo "<script>alert('지정시리얼번호가 중복시리얼번호 입니다. 변경해주세요.');window.history.back()</script>";
			exit;
		}
	}
	
	$savedir = $_uppath."/coupen/";

	$userfile = array($_FILES['img']['name']);
	$tmpfile = array($_FILES['img']['tmp_name']);
	$ar_last = array($ar_data[img]);
	$ar_del = array($_POST['del_file']);

	for($i=0;$i<1;$i++)
	{	$fileurl[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);	}

	$value[img] = $fileurl[0];
	$value[coupenname] = $_POST['coupenname'];
	$value[actype] = $_POST['actype'];
	$value[account] = $_POST['account'];
	$value[maxaccount] = $_POST['maxaccount'];	
	$value[downs] = $_POST['downs'];
	$value[downe] = $_POST['downe'];
	$value[onlyone] = $_POST['onlyone'];
	$value[canuseac] = $_POST['canuseac'];
	$value[used] = $_POST['used'];
	$value[usedays] = $_POST['usedays'];
	$value[startdates] = $_POST['startdates']." ".$_POST['starthour'].":00:00";
	$value[enddates] = $_POST['enddates']." ".$_POST['endhour'].":59:59";
	$value[isuse] = $_POST['isuse'];
	$value[memo] = $_POST['memo'];
	$value[usesale] = $_POST['usesale'];
	$value[isserial] = $_POST['isserial'];
	$value[serialnum] = trim($_POST['serialnum']);
	$value[islogin] = $_REQUEST['islogin'];
	$value['isview'] = $_REQUEST['isview'];
	
	$fids = $_POST['fid'];
	$fids = serialize($fids);
	$value[fids] = $fids;

	$usesites = $_POST['usesite'];
	$usesites = serialize($usesites);
	$value[usesites] = $usesites;

	$value[prod1] = $_POST['prod1'];
	$value[prod2] = $_POST['prod2'];
	if($value[prod1]!='1')
	{	$value[prod2] = "";	}
	
	$value[usecate] = $_POST['usecate'];
	$value[nousecate] = $_POST['nousecate'];
	$value[usegoods] = "";
	if($value[prod1]=='3')	{
		
		$goodslistsin_gidx = $_REQUEST['goodslistsin_gidx'];
		for($i=0;$i<sizeof($goodslistsin_gidx);$i++)	{
			if($value[usegoods]=='')	{
				$value[usegoods] = $goodslistsin_gidx[$i];
			}
			else	{
				$value['usegoods'] = $value['usegoods']."-".$goodslistsin_gidx[$i];
			}
			
		}
	}
	$value[nousegoods] = $_POST['nousegoods'];

	update("shop_coupen",$value," where index_no='$index_no'");

	echo "<script>alert('수정완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
if($mode=='w2')
{
	
	if ( 2 == $_POST['isserial'] ) {
		if ( 1 > strlen($_POST['serialnum']) ) {
			echo "<script>alert('지정시리얼번호 입력해주세요.');window.history.back()</script>";
			exit;
		}
		
		$ar_cnt = sel_query("shop_coupen", "COUNT(*) AS cnt" ," WHERE serialnum = '{$_POST['serialnum']}' and index_no!='$index_no'");
		if ( $ar_cnt[cnt] ) {
			echo "<script>alert('지정시리얼번호가 중복시리얼번호 입니다. 변경해주세요.');window.history.back()</script>";
			exit;
		}
	}
	
	$savedir = $_uppath."/coupen/";

	$userfile = array($_FILES['img']['name']);
	$tmpfile = array($_FILES['img']['tmp_name']);
	$ar_last = array($ar_data[img]);
	$ar_del = array($_POST['del_file']);

	for($i=0;$i<1;$i++)
	{	$fileurl[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);	}

	$value[img] = $fileurl[0];
	$value[coupenname] = $_POST['coupenname'];
	$value[actype] = $_POST['actype'];
	$value[account] = $_POST['account'];
	$value[maxaccount] = $_POST['maxaccount'];	
	$value[downs] = $_POST['downs'];
	$value[downe] = $_POST['downe'];
	$value[onlyone] = $_POST['onlyone'];
	$value[canuseac] = $_POST['canuseac'];
	$value[used] = $_POST['used'];
	$value[usedays] = $_POST['usedays'];
	$value[startdates] = $_POST['startdates']." ".$_POST['starthour'].":00:00";
	$value[enddates] = $_POST['enddates']." ".$_POST['endhour'].":59:59";
	$value[isuse] = $_POST['isuse'];
	$value[memo] = $_POST['memo'];
	$value[usesale] = $_POST['usesale'];
	$value[isserial] = $_POST['isserial'];
	$value[serialnum] = trim($_POST['serialnum']);
	$value[islogin] = $_REQUEST['islogin'];
	$value['isview'] = $_REQUEST['isview'];
	
	$fids = $_POST['fid'];
	$fids = serialize($fids);
	$value[fids] = $fids;

	$usesites = $_POST['usesite'];
	$usesites = serialize($usesites);
	$value[usesites] = $usesites;

	$value[prod1] = $_POST['prod1'];
	$value[prod2] = $_POST['prod2'];
	if($value[prod1]!='1')
	{	$value[prod2] = "";	}
	
	$value[usecate] = $_POST['usecate'];
	$value[nousecate] = $_POST['nousecate'];
	$value[usegoods] = "";
	if($value[prod1]=='3')	{
		
		$goodslistsin_gidx = $_REQUEST['goodslistsin_gidx'];
		for($i=0;$i<sizeof($goodslistsin_gidx);$i++)	{
			if($value[usegoods]=='')	{
				$value[usegoods] = $goodslistsin_gidx[$i];
			}
			else	{
				$value['usegoods'] = $value['usegoods']."-".$goodslistsin_gidx[$i];
			}
			
		}
	}
	$value[nousegoods] = $_POST['nousegoods'];

	$value['give_goods_infos'] = "";
	
	$gidx = $_REQUEST['gidx'];
	$gea = $_REQUEST['gea'];
		

	for($i=0;$i<sizeof($gidx);$i++)	{
		$value['give_goods_infos'] = $value['give_goods_infos'] . $gidx[$i]."|-|".$gea[$i]."|R|";
	}
	

	update("shop_coupen",$value," where index_no='$index_no'");

	echo "<script>alert('수정완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}

?>

<script language="javascript">
function set_ss(mod)
{
	if(mod=='1')
	{	
		$("#serialnum").hide();
		$('#wonlyone2').show();
	}
	else
	{	
		$("#serialnum").show();
		$('#onlyone').prop("checked", true);
		$('#wonlyone2').hide();
	}
}

function regichss()
{
	if($("#id_coupenname").val()=='')
	{
		alert('쿠폰이름을 입력하세요');
		return false;
	}
	if(!$('input[id=id_actype]:checked').val())
	{
		alert('쿠폰할인종류를 선택하세요');
		return false;
	}
	if($("#id_account").val()=='' && $('input[id=id_actype]:checked').val()!='3')
	{
		alert('쿠폰할인금액을 입력하세요');
		return false;
	}
	if(!$('input[id=id_isserial]:checked').val())
	{
		alert('쿠폰종류를 선택하세요');
		return false;
	}

	if($('input[id=id_isserial]:checked').val()=='2')
	{
		if($("#id_serialnum").val()=='')
		{
			alert('지정시리얼번호를 입력하세요');
			return false;
		}
	}

	if($("#id_isserial:checked").val()!='N')
	{
		if($("#sdates").val()=='' || $("#edates").val()=='')
		{
			alert('쿠폰배포기간을 입력하세요');
			return false;
		}
	}
	if(!$('input[id=id_used]:checked').val())
	{
		alert('쿠폰사용기간을 입력하세요');
		return false;
	}

	if($("#id_used:checked").val()=='1')
	{
		if($("#startdates").val()=='' || $("#enddates").val()=='')
		{
			alert('쿠폰사용기간을 입력하세요');
			return false;
		}
	}
	if($("#id_used:checked").val()=='2')
	{
		if($("#id_usedays").val()=='')
		{
			alert('쿠폰사용기간을 입력하세요');
			return false;
		}
	}
	if(!$('input[id=id_usesale]:checked').val())
	{
		alert('할인적용시 적용범위를 선택하세요 ');
		return false;
	}
	if(!$('input[id=id_prod1]:checked').val())
	{
		alert('쿠폰적용범위를선택하세요');
		return false;
	}
	if($('input[id=id_prod1]:checked').val()=='1')
	{
		if($('input[id=id_prod2]:checked').val()=='2')
		{
			var str ='';
			$("#ar_nocate option").each(function()
			{
				str = str + $(this).val() + '-';
			});
			document.regiform.nousecate.value = str;
		
			var str ='';
			$("#ar_nogoods option").each(function()
			{
				str = str + $(this).val() + '-';
			});
			document.regiform.nousegoods.value = str;
		}
	}

	

	answer = confirm('쿠폰을 수정 하시겠습니까?');
	if(answer==true)
	{	return true;	}
	else
	{	return false;	}
}

function regichss2()
{
	


	answer = confirm('쿠폰을 수정 하시겠습니까?');
	if(answer==true)
	{	return true;	}
	else
	{	return false;	}
}
function set_no(ids)
{
	if(ids=='1')
	{
		$("#tr_no").show();
		$("#tr_cate").hide();
		$("#tr_goods").hide();
	}
	if(ids=='2')
	{
		$("#tr_no").hide();
		$("#tr_cate").show();
		$("#tr_goods").hide();
	}
	if(ids=='3')
	{
		$("#tr_no").hide();
		$("#tr_cate").hide();
		$("#tr_goods").show();
	}
}
function set_no2(ids)
{
	if(ids=='1')
	{
		$("#tr_no1").hide();
		$("#tr_no2").hide();
		
	}
	if(ids=='2')
	{
		$("#tr_no1").show();
		$("#tr_no2").show();
		
	}
}
function set_no_fidch()
{
	var param = "fid="+$('#no_fid option:selected').val();
	$.ajax({
	type:"GET",
	url:"/ajaxmo/act_cate_list.php",
	dataType: "html",   
	data:param,
	success:function(msg){
		$("#no_cates").html(msg);
	}
	});
}
function set_fidch()
{
	var param = "fid="+$('#id_usefid option:selected').val();
	$.ajax({
	type:"GET",
	url:"/ajaxmo/act_cate_list.php",
	dataType: "html",   
	data:param,
	success:function(msg){
		$("#cates").html(msg);
	}
	});
}
function addcate()
{
	var isok = "yes";
	if($("#no_cates option:selected").val()!='')
	{	
		var cates = $("#no_fid").val()+'|R|'+$("#no_cates option:selected").val();	
		var texts = $("#no_cates option:selected").text();	
	
	
		$("#ar_nocate option").each(function()
		{
			if($(this).val()==cates)
			{
				alert('이미 추가한 분류입니다');
				isok = "no";
			}
		});
		
		if(isok=='yes')
		{	$('#ar_nocate').append('<option value="'+cates+'">'+texts+'</option>');	}
	}
}
function delcate()
{
	if($("#ar_nocate option:selected").val()!='')
	{
		$('#ar_nocate').children("[value='"+$("#ar_nocate option:selected").val()+"']").remove();
	}
	else
	{
		alert('삭제할분류선택');
	}
}
function delgoods()
{
	if($("#ar_nogoods option:selected").val()!='')
	{
		$('#ar_nogoods').children("[value='"+$("#ar_nogoods option:selected").val()+"']").remove();
	}
	else
	{
		alert('삭제할분류선택');
	}
}
function delgoods2()
{
	if($("#ar_goods option:selected").val()!='')
	{
		$('#ar_goods')	.children("[value='"+$("#ar_goods option:selected").val()+"']").remove();
	}
	else
	{
		alert('삭제할분류선택');
	}
}
function search_goods(idx)
{
	MM_openBrWindow('./popups/find_goods_cp.php?idx='+idx,'fmg','width=700,height=600,scrollbars=yes,top=0,left=0');
	  
}


function addcate2()
{
	var isok = "yes";
	if($("#cates option:selected").val()!='')
	{	
		var cates = $("#id_usefid").val()+'|R|'+$("#cates option:selected").val();
		var texts = $("#cates option:selected").text();	
	
	
		$("#ar_cate option").each(function()
		{
			if($(this).val()==cates)
			{
				alert('이미 추가한 분류입니다');
				isok = "no";
			}
		});
		
		if(isok=='yes')
		{	$('#ar_cate').append('<option value="'+cates+'">'+texts+'</option>');	}
	}
}
function delcate2()
{
	if($("#ar_cate option:selected").val()!='')
	{
		$('#ar_cate').children("[value='"+$("#ar_cate option:selected").val()+"']").remove();
	}
	else
	{
		alert('삭제할분류선택');
	}
}
function removes(obj)	{
	$(obj).parent().parent().remove();
}
</script>
<style>
#goodslistsin li	{	list-style:none;	}
#goodslistsin li span	{	display:inline-block;margin-right:20px;vertical-align:middle;	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 쿠폰정보수정</h3>
			</div>
			<div class="panel-content">
<?php
if($ar_data['usetype']=='1') {
?>
				<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regichss();" >
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<input type='hidden' name='mode' value='w1'>
				<input type='hidden' name='usecate' value=''>
				<input type='hidden' name='nousecate' value=''>
				<input type='hidden' name='usegoods' value=''>
				<input type='hidden' name='nousegoods' value=''>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tr>
					<th>쿠폰형태</th>
					<td >일반쿠폰</td>
				</tr>
				<Tr>
					<th >쿠폰종류</th>
					<td colspan='3'>
						<label><input type='radio' name='isserial' id="id_isserial" value='N' onclick="set_ss('1')" <? if($ar_data[isserial]=='N') { echo "checked";}?>>일반쿠폰</label> 
						<label><input type='radio' name='isserial' id="id_isserial" value='1' onclick="set_ss('1')" <? if($ar_data[isserial]=='1') { echo "checked";}?>>랜덤시리얼</label>
						<label><input type='radio' name='isserial' value='2' id="id_isserial" onclick="set_ss('2')" <? if($ar_data[isserial]=='2') { echo "checked";}?>>시리얼번호지정</label>
					</td>
				</tr>
				<Tr style='display:none;' id='serialnum'>
					<th >지정시리얼번호</th>
					<td ><input type='text' class="form-control" name='serialnum' id="id_serialnum" size='20' value="<?=$ar_data[serialnum];?>"></td>
				</tr>
				<tr>
					<th>쿠폰이름</th>
					<td ><input type='text' class="form-control" name='coupenname' id="id_coupenname" size='30' value="<?=$ar_data[coupenname];?>"></td>
					<th>쿠폰이미지</th>
					<td ><input type='file' name='img'></td>
				</tr>
				<Tr>
					<th>배포여부</th>
					<td>
						<label><input type='radio' name='isuse' value='Y' <? if($ar_data[isuse]=='Y') { echo "checked";	} ?>> 배포</label>
						<label><input type='radio' name='isuse' value='N' <? if($ar_data[isuse]=='N') { echo "checked";	} ?>> 배포안함</label>
					</td>
					<th >배포방법</th>
					<td ><input type='checkbox' name='islogin' value='Y' <? if($ar_data[islogin]=='Y') { echo "checked";	}?>>로그인시지급</td>
				</tr>
				<Tr>
					<th>배포기간</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' class="form-control" name='downs' id='sdates' size='10' readonly value="<?=$ar_data[downs];?>"> ~ <input type='text' class="form-control" id='edates' name='downe' size='10' readonly		value="<?=$ar_data[downe];?>">
						</div>
						<Br />배포기간이란? 다운로드 혹은 시리얼 쿠폰의 경우 고객이 받을수 있는 기간을 의미합니다
					</td>
				</tr>
				<Tr>
					<th>보유갯수</th>
					<td colspan='3'>
						<label for="onlyone"><input type='radio' id="onlyone" name='onlyone' value='Y'  <? if($ar_data[onlyone]=='Y') { echo "checked";	} ?>>한개만보유가능</label> <span id="wonlyone2"><label for="onlyone2"><input type='radio' id="onlyone2" name='onlyone' value='N' <? if($ar_data[onlyone]=='N') { echo "checked";	} ?>>다수소유가능</label></span>
					</td>
				</tr>
				<tr>
					<th rowspan='2'>사용기간</th>
					<td colspan='3'>
						<div class="form-inline">
						<?php
						if($ar_data[used]=='1')	{
							$sdate = substr($ar_data[startdates],0,10);
							$shour = substr($ar_data[startdates],11,2);
							$edate = substr($ar_data[enddates],0,10);
							$ehour = substr($ar_data[enddates],11,2);
						}
						?>
						<label><input type='radio' name='used' id="id_used" value='1' <? if($ar_data[used]=='1') { echo "checked";	}?>>고정기간 </label>
						<br />
						<input type='text' class="form-control" name='startdates' id='startdates' value='<?=$sdate;?>' readonly> <select name='starthour'>
						<?php
						for($i=0;$i<23;$i++)	{
							if(strlen($i)==1)	{
								$j = "0".$i;	
							}
							else	{
								$j = $i;	
							}
							$sel = "";
							if($shour==$j)	{
								$sel = "selected";	
							}
							echo "<option value='$j' $sel >$j</option>";
						}
						?>
						</select>시 부터
						<input type='text' class="form-control" name='enddates' id='enddates' value='<?=$edate;?>' readonly> <select name='endhour'>
						<?
						for($i=0;$i<24;$i++)	{
							if(strlen($i)==1)	{
								$j = "0".$i;	
							}
							else	{
								$j = $i;	
							}

							$sel = "";
							if($ehour==$j)	{
								$sel = "selected";	
							}
							echo "<option value='$j' $sel>$j</option>";
						}
						?>
						</select>시 까지 사용
						</div>
					</td>
				</tr>
				<tr>
					<Td colspan='3'>
						<label><input type='radio' name='used' value='2' id="id_used" <? if($ar_data[used]=='2') { echo "checked";	}?>>발행후</label>
						<br />
						<label><input type='text' class="form-control" name='usedays' id="id_usedays" size='10' <? if($ar_data[used]=='2') { echo "value='$ar_data[usedays]'";	}?>>일안에 사용 [0으로 입력시 1000일동안 유지]</label>
					</td>
				</tr>
				<Tr>
					<th>사용처</th>
					<td colspan='3'>
					<?php

$ar_fids = unserialize($ar_data[fids]);
$ar_usesite = unserialize($ar_data[usesites]);

$q = "select * from shop_sites";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{
	//if(in_array($row[index_no],$ar_mempriv))
	//{
		$ch = "";
		if(in_array($row[index_no],$ar_fids))
		{	$ch = "checked";	}
		echo "<input type='checkbox' name='fid[]' value='$row[index_no]' $ch>$row[sitename] ( ";
		$q2 = "select * from shop_config where fid='$row[index_no]' and site_mobile!='O'";
		$st2 = $pdo->prepare($q2);
		$st2->execute();
		while($row2 = $st2->fetch() )
		{
			$ch2 = "";
			if(in_array($row2[index_no],$ar_usesite))
			{	$ch2 = "checked";	}
?>
<input type='checkbox' name='usesite[]' value='<?=$row2[index_no];?>' <?=$ch2;?>><?=$row2[site_name];?> 
<?
		}
		echo ") <Br /><Br />";
	//}
}
?>
					</td>
				</tr>
				<Tr>
					<th>쿠폰할인종류</th>
					<td colspan='3'>
						<label><input type='radio' name='actype' id="id_actype" value='1' <? if($ar_data[actype]=='1') { echo "checked";	}?>>금액할인</label>
						<label><input type='radio' name='actype' id="id_actype" value='2' <? if($ar_data[actype]=='2') { echo "checked";	}?>>%할인</label> 
						<label><input type='radio' name='actype' id="id_actype" value='3' <? if($ar_data[actype]=='3') { echo "checked";	}?>>배송비면제</label>
					</td>
				</tr>
				<Tr>
					<th>쿠폰할인금액</th>
					<td><input type='text' class="form-control" name='account' id="id_account" size='15' value="<?=$ar_data[account];?>"> </td>
					<th>할인최대치</th>
					<td ><input type='text' class="form-control" name='maxaccount' id="id_maxaccount" size='15' value="<?=$ar_data[maxaccount];?>"></td>
				</tr>
				<Tr>
					<th>상품페이지노출</th>
					<td colspan='3'>
						<label><input type='radio' name='isview' value='Y' <? if($ar_data[isview]=='Y') { echo "checked";	} ?>> 노출</label>
						<label><input type='radio' name='isview' value='N' <? if($ar_data[isview]=='N') { echo "checked";	} ?>> 노출안함</label>
					</td>
				</tr>
				<Tr>
					<th>사용조건</th>
					<td colspan='3'>
						<div class="form-inline">
							주문시 <input type='text' class="form-control" name='canuseac' value='<?=$ar_data[canuseac];?>'>원 이상시에만 사용가능 [주문쿠폰에만 해당, 0으로 설정시 조건없이 사용가능]
						</div>
					</td>
				</tr>
				<Tr>
					<th>할인조건</th>
					<td colspan='3'>
						신상할인/등급할인상품  - <input type='radio' name='usesale' id="id_usesale" value='1' <? if($ar_data[usesale]=='1') { echo "checked";	}?>>할인안함  <input type='radio' name='usesale' id="id_usesale" value='2' <? if($ar_data[usesale]=='2') { echo "checked";	}?>>할인된금액에서 추가할인  <input type='radio' name='usesale' id="id_usesale" value='3' <? if($ar_data[usesale]=='3') { echo "checked";	}?>>쿠폰할인범위내추가할인
					</td>
				</tr>
				<Tr>
					<th>쿠폰사용범위</th>
					<td colspan='3'>
					
						<label><input type='radio' name='prod1' id="id_prod1" value='1' onclick="set_no('1');"  <? if($ar_data[prod1]=='1') { echo "checked";	}?>>전체상품사용</label>   
						<label><input type='radio' name='prod1' id="id_prod1" value='2' onclick="set_no('2');" <? if($ar_data[prod1]=='2') { echo "checked";	}?>>상품카테고리</label>   
						<label><input type='radio' name='prod1'  id="id_prod1" value='3' onclick="set_no('3');" <? if($ar_data[prod1]=='3') { echo "checked";	}?>>개별상품 [특정카테고리나 상품을 제외하고 싶을시엔 전체상품사용체크후 제외가능함]</label></td>
				</tr>
				<Tr id="tr_no" <? if($ar_data[prod1]!='1') { ?>style='display:none;'<?}?>>
					<th>쿠폰적용제외</th>
					<td colspan='3'>
						<input type='radio' name='prod2' id="id_prod2" value='1' onclick="set_no2('1');" <? if($ar_data[prod2]=='1') { echo "checked";	}?>>제외상품없음   <input type='radio' name='prod2' value='2' id="id_prod2" onclick="set_no2('2');" <? if($ar_data[prod2]=='2') { echo "checked";	}?>>상품카테고리 + 개별상품 
	
						<div <? if($ar_data[prod2]!='2'){?>style='display:none;'<?}?> id="tr_no1">
						<p>
							<select class="uch" id="no_fid" onchange="set_no_fidch();">
							<option value=''>판매처</option>
							<?php
							$q = "select * from shop_sites";
							$st = $pdo->prepare($q);
							$st->execute();
							while($row = $st->fetch())	{
								if(in_array($row[index_no],$ar_mempriv))	{
									echo "<option value='$row[index_no]'>$row[sitename]</option>";	
								}
							}
							?>
							</select>
							<select name='no_cates' class="uch" id='no_cates'>
							<option value="0">카테고리</option>
							</select> <span class="btn_white_s"><a a href="javascript:addcate();">추가하기</a></span>
						</p>
						<p style='padding-top:5px;'>
							<select name='ar_nocate' id='ar_nocate' multiple style='width:400px;height:100px;'>
							<?
							if($ar_data[prod2]=='2')	{
								$ar_dt = explode("-",$ar_data[nousecate]);
								for($i=0;$i<sizeof($ar_dt);$i++)	{
									if($ar_dt[$i]!='')	{
										$catev = $ar_dt[$i];
										$ar_catev = explode("|R|",$ar_dt[$i]);
										$catet = "";
										for($j=0;$j<=strlen($ar_catev[1]);$j=$j+2)	{
												if($j!=0)	{
												$ar_ca = sel_query_all("shop_cate"," where catecode='".substr($ar_catev[1],0,$j)."' and fid='$ar_catev[0]'");
												if($catet!='')	{
													$catet = $catet . " > ";	
												}
													$catet = $catet . $ar_ca[catename];
											}
										}
	
										echo "<option value='$catev'>$catet</option>";
									}
								}
							}
							?>
							</select>
							<span class="btn_white_s"><a a href="javascript:delcate();">삭제</a></span>
						</p>
						</div>
	
						<div  <? if($ar_data[prod2]!='2'){?>style='display:none;'<?}?> id="tr_no2">
						<p style='padding-top:5px;'>
						<p>
							<span class="btn_white_s"><a a href="javascript:delgoods();">삭제</a></span>
							<span class="btn_white_s"><a a href="javascript:search_goods('ar_nogoods');">상품찾기</a></span>
						</p>
						<select name='ar_nogoods' id="ar_nogoods" multiple style='width:400px;height:100px;'>
						<?
						if($ar_data[prod2]=='2')	{
							$ar_g = explode("-",$ar_data[nousegoods]);
							for($i=0;$i<sizeof($ar_g);$i++)	{
								if($ar_g[$i]!='')	{
									$ar_goods = sel_query("shop_goods","gname"," where index_no='$ar_g[$i]'");
									echo "<option value='$ar_g[$i]'>$ar_goods[gname]</option>";
								}
							}
						}
						?>
						</select>
			
						</p>
						</div>
					</td>
				</tr>
				<Tr <? if($ar_data[prod1]!='2'){?>style='display:none;'<?}?> id="tr_cate">
					<th>사용가능카테고리</th>
					<td colspan='3'>

					
					</td>
				</tr>
				<Tr <? if($ar_data[prod1]!='3'){?>style='display:none;'<?}?> id="tr_goods">
					<th>사용가능상품</th>
					<td colspan='3'>
						<div class="form-inline">
							<a href="#none" class="btn btn-sm btn-inverse" onclick="MM_openBrWindow('popup?code=goods_search&hanmode=justselect_multi&namefi=goodslistsin','goods_main','width=1100,height=800,top=0,left=0,scrollbars=yes');"><i class="fa fa-plus m-r-5"></i>상품추가</a>
						</div>
						<ul id="goodslistsin">
						<?php
						$ar_tmps = explode("-",$ar_data['usegoods']);
						for($i=0;$i<sizeof($ar_tmps);$i++)	{
							if($ar_tmps[$i]!='')	{
								$ar_goods = sel_query_all("shop_goods"," where index_no='".$ar_tmps[$i]."'");
						?>
							<li>	
								<span><a href="#none" class="btn btn-xs btn-primary" onclick="removes(this);">삭제</a></span>
								<?=$ar_goods['gname'];?>	<input type="hidden" name="goodslistsin_gidx[]" value="<?=$ar_tmps[$i];?>">
							</li>
						<?php
							}
						}
						?>
							
						</ul>
					</td>
				</tr>
				<Tr>
					<th>설명</th>
					<td colspan='3'><textarea name='memo' class="form-control"></textarea></td>
				</tr>
				</table>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group row">
							<div class="col-sm-8 col-sm-offset-4">
								<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">저장하기</button>
								
							</div>
							</div>
					</div>
				</div>
				</form>
<?}?>
<?php
if($ar_data['usetype']=='2') {
?>
				<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regichss2();" >
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<input type='hidden' name='mode' value='w2'>
				<input type='hidden' name='usecate' value=''>
				<input type='hidden' name='nousecate' value=''>
				<input type='hidden' name='usegoods' value=''>
				<input type='hidden' name='nousegoods' value=''>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tr>
					<th>쿠폰형태</th>
					<td >리워드쿠폰</td>
				</tr>
				<Tr>
					<th >쿠폰종류</th>
					<td colspan='3'>
						<label><input type='radio' name='isserial' id="id_isserial" value='N' onclick="set_ss('1')" <? if($ar_data[isserial]=='N') { echo "checked";}?>>일반쿠폰</label> 
						<label><input type='radio' name='isserial' id="id_isserial" value='1' onclick="set_ss('1')" <? if($ar_data[isserial]=='1') { echo "checked";}?>>랜덤시리얼</label>
						<label><input type='radio' name='isserial' value='2' id="id_isserial" onclick="set_ss('2')" <? if($ar_data[isserial]=='2') { echo "checked";}?>>시리얼번호지정</label>
					</td>
				</tr>
				<Tr style='display:none;' id='serialnum'>
					<th >지정시리얼번호</th>
					<td ><input type='text' class="form-control" name='serialnum' id="id_serialnum" size='20' value="<?=$ar_data[serialnum];?>"></td>
				</tr>
				<tr>
					<th>쿠폰이름</th>
					<td ><input type='text' class="form-control" name='coupenname' id="id_coupenname" size='30' value="<?=$ar_data[coupenname];?>"></td>
					<th>쿠폰이미지</th>
					<td ><input type='file' name='img'></td>
				</tr>
				<Tr>
					<th>배포여부</th>
					<td>
						<label><input type='radio' name='isuse' value='Y' <? if($ar_data[isuse]=='Y') { echo "checked";	} ?>> 배포</label>
						<label><input type='radio' name='isuse' value='N' <? if($ar_data[isuse]=='N') { echo "checked";	} ?>> 배포안함</label>
					</td>
					<th >배포방법</th>
					<td ><input type='checkbox' name='islogin' value='Y' <? if($ar_data[islogin]=='Y') { echo "checked";	}?>>로그인시지급</td>
				</tr>
				<Tr>
					<th>배포기간</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' class="form-control" name='downs' id='sdates' size='10' readonly value="<?=$ar_data[downs];?>"> ~ <input type='text' class="form-control" id='edates' name='downe' size='10' readonly		value="<?=$ar_data[downe];?>">
						</div>
						<Br />배포기간이란? 다운로드 혹은 시리얼 쿠폰의 경우 고객이 받을수 있는 기간을 의미합니다
					</td>
				</tr>
				<Tr>
					<th>보유개수</th>
					<td colspan='3'>
						<label for="onlyone"><input type='radio' id="onlyone" name='onlyone' value='Y'  <? if($ar_data[onlyone]=='Y') { echo "checked";	} ?>>한개만보유가능</label> 
						<label for="onlyone2"><input type='radio' id="onlyone2" name='onlyone' value='N' <? if($ar_data[onlyone]=='N') { echo "checked";	} ?>>다수소유가능</label>

					</td>
				</tr>
				<tr>
					<th rowspan='2'>사용기간</th>
					<td colspan='3'>
						<div class="form-inline">
						<?php
						if($ar_data[used]=='1')	{
							$sdate = substr($ar_data[startdates],0,10);
							$shour = substr($ar_data[startdates],11,2);
							$edate = substr($ar_data[enddates],0,10);
							$ehour = substr($ar_data[enddates],11,2);
						}
						?>
						<label><input type='radio' name='used' id="id_used" value='1' <? if($ar_data[used]=='1') { echo "checked";	}?>>고정기간 </label>
						<br />
						<input type='text' class="form-control" name='startdates' id='startdates' value='<?=$sdate;?>' readonly> <select name='starthour'>
						<?php
						for($i=0;$i<23;$i++)	{
							if(strlen($i)==1)	{
								$j = "0".$i;	
							}
							else	{
								$j = $i;	
							}
							$sel = "";
							if($shour==$j)	{
								$sel = "selected";	
							}
							echo "<option value='$j' $sel >$j</option>";
						}
						?>
						</select>시 부터
						<input type='text' class="form-control" name='enddates' id='enddates' value='<?=$edate;?>' readonly> <select name='endhour'>
						<?
						for($i=0;$i<24;$i++)	{
							if(strlen($i)==1)	{
								$j = "0".$i;	
							}
							else	{
								$j = $i;	
							}

							$sel = "";
							if($ehour==$j)	{
								$sel = "selected";	
							}
							echo "<option value='$j' $sel>$j</option>";
						}
						?>
						</select>시 까지 사용
						</div>
					</td>
				</tr>
				<tr>
					<Td colspan='3'>
						<label><input type='radio' name='used' value='2' id="id_used" <? if($ar_data[used]=='2') { echo "checked";	}?>>발행후</label>
						<br />
						<label><input type='text' class="form-control" name='usedays' id="id_usedays" size='10' <? if($ar_data[used]=='2') { echo "value='$ar_data[usedays]'";	}?>>일안에 사용 [0으로 입력시 1000일동안 유지]</label>
					</td>
				</tr>
				<Tr>
					<th>사용처</th>
					<td colspan='3'>
					<?php

$ar_fids = unserialize($ar_data[fids]);
$ar_usesite = unserialize($ar_data[usesites]);

$q = "select * from shop_sites";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{
	//if(in_array($row[index_no],$ar_mempriv))
	//{
		$ch = "";
		if(in_array($row[index_no],$ar_fids))
		{	$ch = "checked";	}
		echo "<input type='checkbox' name='fid[]' value='$row[index_no]' $ch>$row[sitename] ( ";
		$q2 = "select * from shop_config where fid='$row[index_no]' and site_mobile!='O'";
		$st2 = $pdo->prepare($q2);
		$st2->execute();
		while($row2 = $st2->fetch() )
		{
			$ch2 = "";
			if(in_array($row2[index_no],$ar_usesite))
			{	$ch2 = "checked";	}
?>
<input type='checkbox' name='usesite[]' value='<?=$row2[index_no];?>' <?=$ch2;?>><?=$row2[site_name];?> 
<?
		}
		echo ") <Br /><Br />";
	//}
}
?>
					</td>
				</tr>
				
				</table>
				<div style="text-align:right">
					<button class="btn btn-primary waves-effect waves-light" type="button" onclick="MM_openBrWindow('popup?code=goods_search&hanmode=justselect_multi&namefi=glists','goods_main','width=1100,height=800,top=0,left=0,scrollbars=yes');">찾아보기</button>
				</div>
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>상품명</th>
					<th>지급수량</th>
					<th></th>
				</tr>
				</thead>
				<tbody id="glists">
				<?php
				$ar_tps = explode("|R|",$ar_data['give_goods_infos']);
				for($i=0;$i<sizeof($ar_tps);$i++)	{
					if($ar_tps[$i]!='')	{
						$at = explode("|-|",$ar_tps[$i]);

						$ar_goods = sel_query_all("shop_goods"," WHERE index_no='".$at[0]."'");
				?>
				<tr>	
					<td><?=$ar_goods['gname'];?></td>	
					<td><input type="hidden" name="gidx[]" value="<?=$at[0];?>"><input type="text" name="gea[]" value="<?=$at[1];?>" class="form-control"></td>	
					<td><a href="#none" class="btn btn-xs btn-primary m-r-10 m-b-10" onclick="removes(this);">삭제</a></td></tr>
				<?php
					}
				}
				?>
				</tbody>
				</table>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group row">
							<div class="col-sm-8 col-sm-offset-4">
								<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">저장하기</button>
								
							</div>
						</div>
					</div>
				</div>
				</form>
<?}?>
			</div>
		</div>
	</div>
</div>

<Script>
$(document).ready(function()	{
	$('#sdates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#startdates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#enddates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	
});

</script>