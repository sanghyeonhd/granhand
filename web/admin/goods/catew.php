<?php

function cate_num($code){
	return base_convert($code, 36, 10);
}

function cate_code($num){
	$_num = base_convert($num, 10, 36);
	$code = strtoupper(sprintf("%02s", $_num));
	return (string)$code;
}
$mode = $_REQUEST['mode'] ?? '';
if ($mode == 'w') {

	foreach($_REQUEST AS $key => $val)	{
		
		if(!is_array($_REQUEST[$key]))	{

			$_REQUEST[$key] = addslashes(trim($val));
		}
	}
	
	$showsite = $_REQUEST['showsite'];
	$catename = $_REQUEST['catename'];
	$ar_catename = explode(",",$catename);

	$upcate_set = $_REQUEST['upcate1'];
	if($_REQUEST['upcate2']!='')	{
		$upcate_set = $_REQUEST['upcate2'];
	}
	if($_REQUEST['upcate3']!='')	{
		$upcate_set = $_REQUEST['upcate3'];
	}
	
	if ($upcate_set == '') {
		$upcate_set = "";
		$categoryDepth = 1;
		$le = 2;
	} else {
		if(strlen($upcate_set) == '2') {
			$categoryDepth = 2;
			$le = 4;
		} else if (strlen($upcate_set)=='4') {
			$categoryDepth = 3;
			$le = 6;
		} else if (strlen($upcate_set)=='6') {
			$categoryDepth = 4;
			$le = 8;
		}
	}
	

	for($is=0;$is<sizeof($ar_catename);$is++)	{

		$q = "SELECT MAX(catecode) FROM shop_cate WHERE upcate = '$upcate_set' and LENGTH(catecode)='$le'";
		$st = $pdo->prepare($q);
		$st->execute();
		$row = $st->fetch();


		$maxcode = $row[0];

	
		if ($categoryDepth == 1) {
			$catenum = cate_num($maxcode) + 1;
			$codes = cate_code($catenum);
		}	else if ($categoryDepth == 2) {	
			$catenum = cate_num(substr($maxcode, 2, 2)) + 1;
			$codes = cate_code($catenum);
		} else if ($categoryDepth == 3) {
			$catenum = cate_num(substr($maxcode, 4, 2)) + 1;
			$codes = cate_code($catenum);
		} else if ($categoryDepth == 4) {
			$catenum = cate_num(substr($maxcode, 6, 2)) + 1;
			$codes = cate_code($catenum);
		}
		$codes=$upcate_set.$codes;
		

		$value['showsites'] = serialize($showsite);
		$value['fid'] = $_REQUEST['fid'];
		$value['catename'] = $ar_catename[$is];
		$value['catecode'] = $codes;
		$value['upcate'] = $upcate_set;
		$value['catetype'] = $_REQUEST['catetype'];
		$value['isshow'] = 'Y';
		insert("shop_cate", $value);
		unset($value);
	}	
	show_message("카테고리를 등록 하였습니다.","");
	move_link("$PHP_SELF?code=$code&upcate=$value[upcate]");
	exit;

}
?>
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
$(document).ready(function()	{
	$("#id_cate1").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate2");
		}
	});
	$("#id_cate2").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate3");
		}
	});
});
function get_cate(upcate,target)	{
	console.log("/exec/proajax.php?act=cate&han=get_cate&upcate="+upcate)
	$.getJSON("/exec/proajax.php?act=cate&han=get_cate&upcate="+upcate,function(results)	{
		if(results.res=='ok')	{
			var str = "<option value=''>선택하세요</option>";
			$(results.datas).each(function(index,item)	{
				str = str + "<option value='"+item.catecode+"'>"+item.catename+"</option>";
			});
			$("#"+target).html(str);
		}
	});
}
</script>
<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);">
<input type='hidden' name='mode' value='w'>
<div class="row">

	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 카테고리등록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
				</colgroup>
				<tbody>
				<tr>
					<th>노출사이트</th>
					<td>
<?php
foreach($g_ar_pid AS $key => $val)	{
	
	$ar_showsites = (isset($ar_data['showsites']) && !empty($ar_data['showsites']) && is_string($ar_data['showsites']) )
    ? unserialize($ar_data['showsites'])
    : [];
?>
						<label><input type='checkbox' name='showsite[]' value='<?=$val['index_no'];?>' checked> <?=$val['site_name'];?></label>
<?
}
?>	
					</td>
				</tr>
				<tr>
					<th>카테고리명</th>
					<td><input type='text' name='catename' class='form-control' valch="yes" msg="카테고리명을 입력하세요"><p>여러개등록시 (,)로 구분하여 등록</p></td>
				</tr>
				<tr>
					<th>상위카테고리</th>
					<td>
						<select class="uch" name='upcate1' id="id_cate1">
						<option value="">선택하세요</option>
						<?php
						$q = "SELECT * FROM shop_cate where upcate='' order by catecode";
						$st = $pdo->prepare($q);
						$st->execute();
						while ($row = $st->fetch()) {
							echo "<option value='$row[catecode]'>$row[catename]</option>";
						}
						?>
						</select>
						<select class="uch" name='upcate2' id="id_cate2">
						<option value="">선택하세요</option>
						</select>
						<select class="uch" name='upcate3' id="id_cate3">
						<option value="">선택하세요</option>
						</select>
					</td>
				</tr>
				</table>	
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
						
				</div>
			</div>
	</div>
</div>
</form>
