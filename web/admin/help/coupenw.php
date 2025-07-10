<?php
$mode = $_REQUEST['mode'];
if($mode=='w')
{
	
	if ( 2 == $_POST['isserial'] ) {
		if ( 1 > strlen($_POST['serialnum']) ) {
			echo "<script>alert('지정시리얼번호 입력해주세요.');window.history.back()</script>";
			exit;
		}
		
		$ar_cnt = sel_query("shop_coupen", "COUNT(*) AS cnt" ," WHERE serialnum = '{$_POST['serialnum']}'");
		if ( $ar_cnt[cnt] ) {
			echo "<script>alert('지정시리얼번호가 중복시리얼번호 입니다. 변경해주세요.');window.history.back()</script>";
			exit;
		}
	}
	
	$savedir = $_uppath."/coupen/";

	$userfile = array($_FILES['img']['name']);
	$tmpfile = array($_FILES['img']['tmp_name']);

	for($i=0;$i<1;$i++)
	{	$fileurl[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}

	$value['img'] = $fileurl[0];
	$value['coupenname'] = $_POST['coupenname'];
	$value['actype'] = $_POST['actype'];
	$value['account'] = $_POST['account'];
	$value['maxaccount'] = $_POST['maxaccount'];	
	$value['usetype'] = $_POST['usetype'];
	$value['downs'] = $_POST['downs'];
	$value['downe'] = $_POST['downe'];
	$value['onlyone'] = $_POST['onlyone'];
	$value['canuseac'] = $_POST['canuseac'];
	$value['used'] = $_POST['used'];
	$value['usedays'] = $_POST['usedays'];
	$value['startdates'] = $_POST['startdates']." ".$_POST['starthour'].":00:00";
	$value['enddates'] = $_POST['enddates']." ".$_POST['endhour'].":59:59";
	$value['isuse'] = $_POST['isuse'];
	$value['memo'] = $_POST['memo'];
	$value['usesale'] = $_POST['usesale'];
	$value['isserial'] = $_POST['isserial'];
	$value['serialnum'] = trim($_POST['serialnum']);
	$value['islogin'] = $_REQUEST['islogin'];
	$value['isview'] = $_REQUEST['isview'];

	$fids = $_POST['fid'];
	$fids = serialize($fids);
	$value['fids'] = $fids;

	$usesites = $_POST['usesite'];
	$usesites = serialize($usesites);
	$value['usesites'] = $usesites;

	$value['prod1'] = $_POST['prod1'];
	$value['prod2'] = $_POST['prod2'];
	$value['usecate'] = $_POST['usecate'];
	$value['nousecate'] = $_POST['nousecate'];
	$value['usegoods'] = "";
	if($value['prod1']=='3')	{
		
		$goodslistsin_gidx = $_REQUEST['goodslistsin_gidx'];
		for($i=0;$i<sizeof($goodslistsin_gidx);$i++)	{
			if($value['usegoods']=='')	{
				$value['usegoods'] = $goodslistsin_gidx[$i];
			}
			else	{
				$value['usegoods'] = $value['usegoods']."-".$goodslistsin_gidx[$i];
			}
			
		}
	}

	
	


	$value['nousegoods'] = $_POST['nousegoods'];
	$value['give_goods_infos'] = "";
	if($value['usetype']=='2')	{
		$gidx = $_REQUEST['gidx'];
		$gea = $_REQUEST['gea'];
		

		for($i=0;$i<sizeof($gidx);$i++)	{
			$value['give_goods_infos'] = $value['give_goods_infos'] . $gidx[$i]."|-|".$gea[$i]."|R|";
		}
	}

	



	insert("shop_coupen",$value);

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code'); </script>";
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
	
	if($("#usetype option:selected").val()=='')	{
		alert('쿠폰종류를 선택하세요');
		return false;
	}

	if($("#id_coupenname").val()=='')	{
		alert('쿠폰이름을 입력하세요');
		return false;
	}
	if($("#usetype option:selected").val()=='1')	{
		if(!$('input[id=id_actype]:checked').val())	{
			alert('쿠폰할인종류를 선택하세요');
			return false;
		}
		if($("#id_account").val()=='' && $('input[id=id_actype]:checked').val()!='3')	{
			alert('쿠폰할인금액을 입력하세요');
			return false;
		}
		if(!$('input[id=id_usesale]:checked').val())	{
			alert('할인적용시 적용범위를 선택하세요 ');
			return false;
		}
		if(!$('input[id=id_prod1]:checked').val())	{
			alert('쿠폰적용범위를선택하세요');
			return false;
		}
		if($('input[id=id_prod1]:checked').val()=='1')	{
			if($('input[id=id_prod2]:checked').val()=='2')	{
				var str ='';
				$("#ar_nocate option").each(function()	{
					str = str + $(this).val() + '-';
				});
				document.regiform.nousecate.value = str;
		
				var str ='';
				$("#ar_nogoods option").each(function()	{
					str = str + $(this).val() + '-';
				});
				document.regiform.nousegoods.value = str;
			}
		}

		
		
	}
	if(!$('input[id=id_isserial]:checked').val())	{
		alert('쿠폰종류를 선택하세요');
		return false;
	}

	if($('input[id=id_isserial]:checked').val()=='2')	{
		if($("#id_serialnum").val()=='')	{
			alert('지정시리얼번호를 입력하세요');
			return false;
		}
	}

	if($("#id_isserial:checked").val()!='N')	{
		if($("#sdates").val()=='' || $("#edates").val()=='')	{
			alert('쿠폰배포기간을 입력하세요');
			return false;
		}
	}
	if(!$('input[id=id_used]:checked').val())	{
		alert('쿠폰사용기간을 입력하세요');
		return false;
	}

	if($("#id_used:checked").val()=='1')	{
		if($("#startdates").val()=='' || $("#enddates").val()=='')	{
			alert('쿠폰사용기간을 입력하세요');
			return false;
		}
	}
	if($("#id_used:checked").val()=='2')	{
		if($("#id_usedays").val()=='')	{
			alert('쿠폰사용기간을 입력하세요');
			return false;
		}
	}
	

	answer = confirm('쿠폰을 등록 하시겠습니까?');
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
	url:"./ajaxmo/act_cate_list.php",
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
	url:"./ajaxmo/act_cate_list.php",
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
		$('#ar_goods').children("[value='"+$("#ar_goods option:selected").val()+"']").remove();
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

function set_divshow(obj)	{
	
	$("#infos1").hide();
	$("#infos2").hide();



	if($(obj).val()!='')	{
		$("#infos"+$(obj).val()).show();
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
<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regichss();" >
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='usecate' value=''>
<input type='hidden' name='nousecate' value=''>
<input type='hidden' name='usegoods' value=''>
<input type='hidden' name='nousegoods' value=''>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 쿠폰기초정보</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>쿠폰형태</th>
					<td colspan='3'>
						<select name="usetype" id="usetype" onchange="set_divshow(this);">
						<option value="">쿠폰형태선택</option>
						<option value="1">일반쿠폰</option>
						<option value="2">리워드쿠폰</option>
						</select>
					</td>
				</tr>
				<Tr>
					<th >쿠폰종류</th>
					<td colspan='3'>
						<label><input type='radio' name='isserial' id="id_isserial" value='N' onclick="set_ss('1')">일반쿠폰</label>
						<label><input type='radio' name='isserial' id="id_isserial" value='1' onclick="set_ss('1')">랜덤시리얼</label>
						<label><input type='radio' name='isserial' value='2' id="id_isserial" onclick="set_ss('2')">시리얼번호지정</label>
					</td>
				</tr>
				<Tr style='display:none;' id='serialnum'>
					<th >지정시리얼번호</th>
					<td colspan='3'><input type='text' class="form-control" name='serialnum' id='id_serialnum' size='20'></td>
				</tr>
				<tr>
					<th>쿠폰이름</th>
					<td ><input type='text' class="form-control" name='coupenname' id="id_coupenname" size='30'></td>
					<th>쿠폰이미지</th>
					<td ><input type='file' name='img'></td>
				</tr>
				<Tr>
					<th>배포여부</th>
					<td>
						<label><input type='radio' name='isuse' value='Y' checked> 배포</label>
						<label><input type='radio' name='isuse' value='N'> 배포안함</label>
					</td>
					<th >배포방법</th>
					<td><input type='checkbox' name='islogin' value='Y'>로그인시지급</td>
				</tr>
				<Tr>
					<th>배포기간</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='downs' id='sdates' size='10' readonly> ~ <input type='text' class="form-control" id='edates' name='downe' size='10' readonly>
							<Br />배포기간이란? 다운로드 혹은 시리얼 쿠폰의 경우 고객이 받을수 있는 기간을 의미합니다
						</div>
					</td>
				</tr>
				<Tr>
					<th>보유개수</th>
					<td colspan='3'>
						<label for="onlyone"><input type='radio' id="onlyone" name='onlyone' value='Y' checked>한개만보유가능</label> 
						<label for="onlyone2"><input type='radio' id="onlyone2" name='onlyone' value='N'>다수소유가능</label>
					</td>
				</tr>
				<tr>
					<th rowspan='2'>사용기간</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='radio' name='used' id="id_used" value='1'>고정기간 
							<br />
							<input type='text' class="form-control" name='startdates' id='startdates' readonly> <select name='starthour'>
							<?php
							for($i=0;$i<23;$i++)	{
								if(strlen($i)==1)
								{	$j = "0".$i;	}
								else
								{	$j = $i;	}
								echo "<option value='$j'>$j</option>";
							}
							?>
							</select>시 부터
							<input type='text' class="form-control" name='enddates' id='enddates' readonly> <select name='endhour'>
							<?
							for($i=0;$i<24;$i++)	{
								if(strlen($i)==1)
								{	$j = "0".$i;	}
								else
								{	$j = $i;	}
								echo "<option value='$j'>$j</option>";
							}
							?>
							</select>시 까지 사용
						</div>
					</td>
				</tr>
				<tr>
					<td colspan='3'>
						<div class="form-inline">
							<input type='radio' name='used' value='2' id="id_used">발행후 <input type='text' class="form-control" name='usedays' id="id_usedays" size='10'>일안에 사용 [0으로 입력시 1000일동안 유지] 
						</div>
					</td>
				</tr>
				<Tr>
					<th>사용처</th>
					<td colspan='3'>
<?php
$q = "select * from shop_sites";
$st = $pdo->prepare($q);
$st->Execute();
while($row = $st->fetch())
{
	if(in_array($row['idx'],$ar_mempriv))
	{
		echo "<input type='checkbox' name='fid[]' value='$row[idx]' checked>$row[sitename] ( ";
		$q2 = "select * from shop_config where fid='$row[idx]' and site_mobile!='O'";

		$st2 = $pdo->prepare($q2);
		$st2->execute();
		while($row2 = $st2->fetch())
		{
?>
<input type='checkbox' name='usesite[]' value='<?=$row2['idx'];?>' checked><?=$row2['site_name'];?> 
<?
		}
		echo ") <Br /><Br />";
	}
}
?>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row" id="infos1" style="display:none;">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 일반쿠폰등록정보</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<Tr>
					<th >쿠폰할인종류</th>
					<td colspan="3">
						<label><input type='radio' name='actype' id="id_actype" value='1'>금액할인</label>
						<label><input type='radio' name='actype' id="id_actype" value='2'>%할인</label>
						<label><input type='radio' name='actype' id="id_actype" value='3'>배송비면제</label>
					</td>
				</tr>
				<Tr>
					<th >쿠폰할인금액</th>
					<td ><input type='text' class="form-control" name='account' id="id_account" size='15'> </td>
					<th>할인최대치</th>
					<td ><input type='text' class="form-control" name='maxaccount' id="id_maxaccount" size='15' value='0'></td>
				</tr>
				<Tr>
					<th>상품페이지노출</th>
					<td colspan="3">
						<label><input type='radio' name='isview' value='Y'> 노출</label>
						<label><input type='radio' name='isview' value='N'> 노출안함</label>
					</td>
				</tr>
				<Tr>
					<th>사용조건</th>
					<td colspan="3">
						<div class="form-inline">
						주문시 <input type='text' class="form-control" name='canuseac' size='10' value='0'>원 이상시에만 사용가능 [주문쿠폰에만 해당, 0으로 설정시 조건없이 사용가능]
						</div>
					</td>
				</tr>
				<Tr>
					<th>할인조건</th>
					<td  colspan="3">
						<div class="form-inline">
							<label>신상할인/등급할인상품  - <input type='radio' name='usesale' id="id_usesale" value='1'>할인안함</label>  
							<label><input type='radio' name='usesale' id="id_usesale" value='2'>할인된금액에서 추가할인</label>  
							<label><input type='radio' name='usesale' id="id_usesale" value='3'>쿠폰할인범위내추가할인</label>
						</div>
					</td>
				</tr>

				<Tr>
					<th>쿠폰사용범위</th>
					<td  colspan="3">
						<div class="form-inline">
							<label><input type='radio' name='prod1' id="id_prod1" value='1' onclick="set_no('1');" checked>전체상품사용</label>
							<label><input type='radio' name='prod1' id="id_prod1" value='2' onclick="set_no('2');">상품카테고리</label>
							<label><input type='radio' name='prod1'  id="id_prod1" value='3' onclick="set_no('3');">개별상품 [특정카테고리나 상품을 제외하고 싶을시엔 전체상품사용체크후 제외가능함]</label>
						</div>
					</td>
				</tr>
				<Tr id="tr_no">
					<th>쿠폰적용제외</th>
					<td  colspan="3">
						<div class="form-inline">
							<label><input type='radio' name='prod2' id="id_prod2" value='1' checked onclick="set_no2('1');">제외상품없음</label>
							<label><input type='radio' name='prod2' value='2' id="id_prod2" onclick="set_no2('2');">상품카테고리 + 개별상품 </label>
						</div>
						<div style='display:none;' id="tr_no1">
								<p>
									<select class="uch" id="no_fid" onchange="set_no_fidch();">
									<option value=''>판매처</option>
<?php
$q = "select * from shop_sites";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->Fetch())	{
	if(in_array($row['idx'],$ar_mempriv))	{
		echo "<option value='$row[idx]'>$row[sitename]</option>";	
	}
}
?>
									</select>
									<select name='no_cates' class="uch" id='no_cates'>
									<option value="0">카테고리</option>
									</select> <span class="btn_white_s"><a a href="javascript:addcate();">추가하기</a></span>
								</p>
								<p style='padding-top:5px;'>
									<select name='ar_nocate' id='ar_nocate' multiple style='width:400px;height:100px;'></select>
									<span class="btn_white_s"><a a href="javascript:delcate();">삭제</a></span>
								</p>
						</div>
						<div style='display:none;' id="tr_no2">
							<p style='padding-top:5px;'>
								<p>
									<span class="btn_white_s"><a a href="javascript:delgoods();">삭제</a></span>
									<span class="btn_white_s"><a a href="javascript:search_goods('ar_nogoods');">상품찾기</a></span>
								</p>
								<select name='ar_nogoods' id="ar_nogoods" multiple style='width:400px;height:100px;'></select>
		
							</p>
						</div>
					</td>
				</tr>
				<Tr style='display:none;' id="tr_cate">
					<th>사용가능카테고리</th>
					<td  colspan="3">
						<div class="form-inline">
							<select id="select_cate">
							<option value=''>카테고리선택</option>
							</select>
						</div>
					</td>
				</tr>
				<Tr style='display:none;' id="tr_goods">
					<th>사용가능상품</th>
					<td  colspan="3">
						<div class="form-inline">
							<a href="#none" class="btn btn-sm btn-inverse" onclick="MM_openBrWindow('popup?code=goods_search&hanmode=justselect_multi&namefi=goodslistsin','goods_main','width=1100,height=800,top=0,left=0,scrollbars=yes');"><i class="fa fa-plus m-r-5"></i>상품추가</a>
						</div>
						<ul id="goodslistsin">
							
						</ul>
					</td>
				</tr>
				<Tr>
					<th>설명</th>
					<td  colspan="3"><textarea name='memo' cols='70' rows='5' class="form-control"></textarea></td>
				</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row" id="infos2" style="display:none;">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 리워드쿠폰정보</h3>
			</div>
			<div class="panel-content">
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
				
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
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
