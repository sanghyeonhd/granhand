<?
if($mode=='w')	{

	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);

	$savedir = "./csvs/";
	$fid = $_REQUEST['fid'];

	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	
	}

	$file = $fs[0];

	$bf1 = $_REQUEST['bf1'];
	$bf2 = $_REQUEST['bf2'];
	$bf3 = $_REQUEST['bf3'];
	$bf4 = $_REQUEST['bf4'];



	echo "<Script>alert('다음단계에서 데이터를 확인해주세요.'); location.replace('$PHP_SELF?code={$code}next&filename=$file&gocom=$gocom&bf1=$bf1&bf2=$bf2&bf3=$bf3&bf4=$bf4'); </script>";
	exit;
}
?>
<script>
function gotoch(f)	{

	var isok = check_form(f);
	if(isok)	{
		
		if($("#gocom option:selected").val()=='' && $("#bf3 option:selected").val()=='')	{
			alert('택배사 열을 선택하거나, 일괄처리하실 택배사를 선택하세요');
			return false;
		}

		answer = confirm('다음단계로 진행하시겠습니까?');
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
				<h3><i class="fa fa-table"></i> 일괄배송처리</h3>
			</div>
			<div class="panel-content">

				<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return gotoch(this);" ENCTYPE="multipart/form-data">
				<input type='hidden' name='mode' value='w'>

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
				</colgroup>
				<tbody>
				<tr>
					<th>엑셀파일</th>
					<td><input type='file' name='file' valch="yes" msg="엑셀파일을 입력하세요"></td>
				</tr>
				<tr>
					<th>일괄적용택배사</th>
					<td>
						<select name='gocom' id='gocom'>
						<option value=''>배송사선택</option>
						<?
						for($i=0;$i<sizeof($g_ar_deliver);$i++)	{
							echo "<option value='".$g_ar_deliver[$i]['comname']."'>".$g_ar_deliver[$i]['comname']."</option>";
						}
						?>
						</select> [엑셀파일에 택배사 지정없이, 일괄처리할 경우 택배사를 선택하시면 됩니다.]
					</td>
				</tr>
				<tr>
					<th>파일매칭열</th>
					<td>
						<div class="form-inline">
						주문번호 : <Select class="form-control" name="bf1" valch="yes" msg="주문번호열을 선택하세요">
						<option value=''>선택하세요</option>
						<?php
						for($i=65;$i<91;$i++)	{
							$va = chr($i);
							echo "<option value='".($i-65)."'>$va</option>";
						}
						?>
						</select> 상품주문번호 : <Select class="form-control" name="bf2" valch="yes" msg="주문번호열을 선택하세요">
						<option value=''>선택하세요</option>
						<?php
						for($i=65;$i<91;$i++)	{
							$va = chr($i);
							echo "<option value='".($i-65)."'>$va</option>";
						}
						?>
						</select>
						택배사 : <Select class="form-control" name="bf3" id="bf3">
						<option value=''>선택하세요</option>
						<?php
						for($i=65;$i<91;$i++)	{
							$va = chr($i);
							echo "<option value='".($i-65)."'>$va</option>";
						}
						?>
						</select>
						송장번호 : <Select class="form-control" name="bf4" valch="yes" msg="주문번호열을 선택하세요">
						<option value=''>선택하세요</option>
						<?php
						for($i=65;$i<91;$i++)	{
							$va = chr($i);
							echo "<option value='".($i-65)."'>$va</option>";
						}
						?>
						</select>
						</div>
					</td>
				</tr>
				
				</tbody>

				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<a href="#none" class="btn btn-primary" onclick="$('#regiform').submit()">다음단계로</a>

					</div>
				</div>
				</form>
				
				
			</div>
		</div>
	</div>
</div>