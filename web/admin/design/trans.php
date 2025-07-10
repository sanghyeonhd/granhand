<?php
$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "";
if($mode=='fw')	{
	
	
	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);

	$savedir = $_uppath."uploads/";
	
	
	if(!is_dir($savedir))	{	
		mkdir($savedir, 0777);	chmod($savedir,0707);  
	}
	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	
	}
	$f = $fs[0];

	show_message("파일이 업로드 되었습니다. 확인페이지도 이동합니다.","");
	move_link("$PHP_SELF?code=".$code."_f&f=$f");
	exit;

}
$viewall = isset($_REQUEST['viewall']) ? $_REQUEST['viewall'] : "";
$showlang = isset($_REQUEST['showlang']) ? $_REQUEST['showlang'] : [];
if(!$showlang && !$viewall)	{
	$viewall = "Y";
}


?>
<script>
$(document).ready(function() {
	$(".chk_showlang").on("click",function()	{
		var chk = 0;

		$(".chk_showlang").each(function()	{
			if($(this).is(":checked"))	{
				chk++;
			}
		});

		if(chk==0)	{
			$("#viewall").prop("checked",true);	
		}
		else	{
			$("#viewall").prop("checked",false);	
		}

	});


	$("#viewall").on("click",function()	{

		if($(this).is(":checked"))	{
			$(".chk_showlang").prop("checked",false);	
		}
	});
	
	$('.chwords').on('change', function() {
		
		var idx = $(this).attr("data-key");
		var wd = $(this).val();
		var lang = $(this).attr("data-lang");
		
		if(idx!='mainkey')	{

			var param = "wd="+encodeURIComponent(wd)+"&lang="+lang+"&idx="+encodeURIComponent(idx);
			
			console.log('/exec/proajax.php?modtype=design_ajax&han=set_trans&'+param);

			$.getJSON('/exec/proajax.php?act=design&han=set_trans&'+param, function(result){});
		}

	});
});	
function fregich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('엑셀파일로 번역 진행 하시겠습니까?');
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
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색 </h3>
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
					<th>언어선택</th>
					<td colspan='3'>
						<label><input type='radio' name='viewall' id="viewall" value='Y' <? if($viewall=='Y') { echo "checked";	}?>>전체</label>
						<?php
						$q = "SELECT * FROM shop_config_lang where isuse='Y'";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$l_ar_lang[] = $row;
						?>
						<label><input type='checkbox' class="chk_showlang" name='showlang[]' value='<?=$row['namecode'];?>' <? if(in_array($row['namecode'],$showlang)) { echo "checked";	}?>><?=$row['name'];?></label>
						<?
						}
						?>
					</td>
				</tr>

				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						<button class="btn btn-primary waves-effect waves-light" type="button" onclick="location.href='/excel/excel_down?act=trans';">엑셀다운로드</button>
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
				<h3><i class="fa fa-table"></i> 엑셀로입력 </h3>
			</div>
			<div class="panel-content">
				<form name="inputf" id="inputf" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return fregich(this);">
				<input type='hidden' name='mode' value='fw'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>언어선택</th>
					<td>
						<select name='lang' ENCTYPE="multipart/form-data" valch="yes" msg="언어를 선택하세세요">
						<option value=''>언어선택</option>
						<?php
						for($i=0;$i<sizeof($l_ar_lang);$i++)	{
							
							if($l_ar_lang[$i]['namecode']=='ko')	{
								continue;
							}
							
						?>
						<option value='<?=$l_ar_lang[$i]['namecode'];?>'><?=$l_ar_lang[$i]['name'];?></option>
						<?
						}
						?>
						</select>
					</td>
					<th>엑셀파일</th>
					<td>
						<input type='file' name='file'>
					</td>
				</tr>

				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#inputf">다음단계</button>
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
				<h3><i class="fa fa-table"></i> 번역관리</h3>
			</div>
			<div class="panel-content">

	
				<table class="table table-bordered" style="margin-top:20px;">
				<thead>
				<tr>
					<th>대표키값</th>
					<?
					for($i=0;$i<sizeof($l_ar_lang);$i++)	{
						if(in_array($l_ar_lang[$i]['namecode'],$showlang) || $viewall=='Y')	{
					?>
					<th><?=$l_ar_lang[$i]['name'];?>(<?=$l_ar_lang[$i]['namecode'];?>)</th>
					<?
						}
					}
					?>
				</tr>
				</thead>
				<tbody>
				
<?php

$q = "SELECT * FROM shop_trans_key order by wordkeys asc";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{

?>
				<tr class="<?=$co?>">
					<td><?=$row[wordkeys]?><input type="hidden" class="idx_<?=$cou?> form-control" name="basic" data-lang="mainkey" data-key="<?=$row['idx']?>" value="<?=$row[wordkeys]?>" /></td>
					<?
					for($i=0;$i<sizeof($l_ar_lang);$i++)	{
						
						if(in_array($l_ar_lang[$i]['namecode'],$showlang) || $viewall=='Y')	{
							
							$ar_word = sel_query_all("shop_trans"," WHERE wordkeys='$row[wordkeys]' and lang='".$l_ar_lang[$i]['namecode']."'");

							

							
					?>

					<td><input class="chwords idx_<?=$row[idx]?> form-control" name="wd_<?=$row[idx]?>_<?=$l_ar_lang[$i]['namecode'];?>" data-lang="<?=$l_ar_lang[$i]['namecode'];?>" data-key="<?=$row[wordkeys]?>" value="<?=$ar_word['chwords']?>"/></td>
					<?
						}
					}
					?>
				</tr>
<?php 
}
?>		
				</tbody>
				</table>



			</div>
		</div>
	</div>
</div>
