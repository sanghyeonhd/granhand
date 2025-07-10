<?php
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	

	
	$removef = $_REQUEST['removef'];
	$savedir = $_uppath."csvs/";

	
	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);
	
	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}
	
	$filename = $fs[0];

	echo "<Script>alert('파일 업로드가 완료되었습니다. 확인후 처리 바랍니다.'); location.replace('$PHP_SELF?code=goods_excelnext&removef=$removef&fname=$filename'); </script>";
	exit;
}

?>
<script language="javascript">
function goch()
{
	
	if(!document.form1.file.value)
	{
		alert('파일을 입력하세요.');
		document.form1.file.focus();
		return false;
	}
	
	answer = confirm('상품정보를 변경하시겠습니까?');
	if(answer==true)
	{	return true;	}
	else
	{	return false;	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 엑셀로일괄수정</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">

				<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" enctype="multipart/form-data" onsubmit="return goch();">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<tr>
					<th>파일</th>
					<td colspan='3'>
					<input type='file' name='file'> <br />하단에 엑셀 샘플양식을 참고하세요
					</td>
				</tr>
				<tr>
					<th>비고</th>
				<td colspan='3'>
					<input type='checkbox' name='removef' value='Y'>첫줄제외
				</td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#form1">등록하기</button>
					</div>
				</div>
				</form><!-- // form[name="form1"] -->

			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 엑셀파일샘플</h3>
			</div>
			<div class="panel-content">
				
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
				<tr>
					<td>고유상품번호</td>
					<td></td>
					<td></td>
					<td>숫자만</td>
					<td>숫자만</td>
					<td>숫자만</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>