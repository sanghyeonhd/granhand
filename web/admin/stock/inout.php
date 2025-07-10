<?php
$mode = $_REQUEST['mode'];
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}
if($mode=='w')
{
	$value[name] = $_POST['memo'];
	$value[fid] = $_POST['fid'];
	if(!$value[name])
	{
		$ar_is = sel_query_all("shop_goods_inout_cate"," where index_no='".$_POST['tbtype']."'");
		$value[name] = date("Y-m-d H:i:s",time())." ".$ar_is[catename]." 전표";	
	}

	$value[istmp] = $_POST['istmp'];
	$value[tbtype] = $_POST['tbtype'];
	$value[useh] = $_POST['useh'];
	insert("shop_goods_inout_paper",$value);
	$paper_idx = mysqli_insert_id();	
	unset($value);


	$bf1 = $_REQUEST['bf1'];
	$bf2 = $_REQUEST['bf2'];
	$bf3 = $_REQUEST['bf3'];
	$bf4 = $_REQUEST['bf4'];
	$removef = $_REQUEST['removef'];
	$savedir = $_uppath."csvs/";

	$bf1 = chr($bf1+65);
	$bf2 = chr($bf2+65);
	if($bf3)	{
		$bf3 = chr($bf3+65);
	}
	if($bf4)	{
		$bf4 = chr($bf4+65);
	}

	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);
	
	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}
	
	$filename = $fs[0];
	
	require $_basedir."/inc/PHPExcel/PHPExcel.php";

	$filename = $_uppath."csvs/$filename";


	$objPHPExcel = PHPExcel_IOFactory::load($filename);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	
	mysqli_query($connect,"TRUNCATE TABLE `shop_goods_inout_pre`");
	
	foreach ( $sheetData as $rownum => $row ) 
	{
		if($removef=='Y')
		{
			if($rownum=='1')
			{	continue;	}
		}
		foreach ( $row as $C => $val ) 
		{
			
			
			if($C==$bf1)
			{	$barcode = $val;	}
			if($C==$bf2)
			{	$ea = $val;	}

			if($C==$bf3 && $bf3)
			{	$memoadd = $val;	}

			if($C==$bf4 && $bf4)
			{	$noea = $val;	}


		}
		if($ea!='' && $ea!='0' && $barcode!='')
		{
			$value[codes] = $barcode;
			$value[ea] = $ea;
			if($iocate=='I')	{
				$value[noea] = $noea;
			}
			$value[tbtype] = $_POST['tbtype'];
			$value[useh] = $_POST['useh'];
			$value[memo] = addslashes($memoadd);
			insert("shop_goods_inout_pre",$value);
			echo mysqli_error();
		}

	}
	echo "<Script>alert('파일 업로드가 완료되었습니다. 확인후 처리 바랍니다.'); location.replace('$PHP_SELF?code=stock_inoutnext&paper_idx=$paper_idx'); </script>";
	exit;
}
if($mode=='w2')
{
	$bf1 = $_REQUEST['bf1'];
	$bf2 = $_REQUEST['bf2'];
	$removef = $_REQUEST['removef'];
	$tbtype1 = $_REQUEST['tbtype1'];
	$tbtype2 = $_REQUEST['tbtype2'];
	$savedir = "./csvs/";

	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);
	
	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}
	
	$filename = $fs[0];
	


	echo "<Script>alert('업로드 완료 확인후 실처리를 진행해주세요.'); location.replace('$PHP_SELF?code=inout_write_lnext&bf1=$bf1&bf2=$bf2&removef=$removef&tbtype1=$tbtype1&tbtype2=$tbtype2&filename=$filename'); </script>";
	exit;
}

?>
<script language="javascript">
function goch()
{
	if($("#id_fid option:selected").val()=='')
	{
		alert('적용사이트를 선택하세요.');
		document.form1.fid.focus();
		return false;
	}
	if($("#tbtype option:selected").val()=='')
	{
		alert('처리구분을 선택하세요.');
		document.form1.tbtype.focus();
		return false;
	}
	if(!document.form1.file.value)
	{
		alert('파일을 입력하세요.');
		document.form1.file.focus();
		return false;
	}
	if($("#id_bf1 option:selected").val()=='')
	{
		alert('입고코드열을 선택하세요.');
		document.form1.bf1.focus();
		return false;
	}
	if($("#id_bf2 option:selected").val()=='')
	{
		alert('실입고 필드를 선택하세요.');
		document.form1.bf2.focus();
		return false;
	}
	

	answer = confirm('입/출고처리를 시작 하겠습니까?');
	if(answer==true)
	{	return true;	}
	else
	{	return false;	}
}
function set_tbtype()
{

		var param = "iocate="+$('#iocate option:selected').val();
		$.ajax({
		type:"GET",
		url:"/ajaxmo/act_iocate_list.php",
		dataType: "html",   
		data:param,
		success:function(msg){
			$("#tbtype").html(msg);
		}
		});

	
}
function goch2()
{
	if(!document.form2.file.value)
	{
		alert('파일을 입력하세요.');
		document.form2.file.focus();
		return false;
	}
	if(!document.form2.file.value)
	{
		alert('파일을 입력하세요.');
		document.form2.file.focus();
		return false;
	}
	if($("#id_nf1 option:selected").val()=='')
	{
		alert('입고코드열을 선택하세요.');
		document.form2.bf1.focus();
		return false;
	}
	
	if($("#id_nf2 option:selected").val()=='')
	{
		alert('실입고 필드를 선택하세요.');
		document.form2.bf2.focus();
		return false;
	}


	if($("#tbtype1 option:selected").val()=='')
	{
		alert('입고처리 구분을 선택하세요.');
		document.form2.tbtype1.focus();
		return false;
	}
	if($("#tbtype2 option:selected").val()=='')
	{
		alert('출고처리 구분을 선택하세요.');
		document.form2.tbtype2.focus();
		return false;
	}


	return true;
}
</script>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품 입/출고</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">


<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" enctype="multipart/form-data" onsubmit="return goch();">
<input type='hidden' name='mode' value='w'>
<table class="table table-bordered">
<tr>
<th>
적용사이트
</th>
<td colspan='3'>
<select class="uch" name='fid' id='id_fid'>
		<option value=''>전체보기</option>
		<?php
		$q = "select * from shop_sites";
		$q = $q ." order by index_no asc";
		$r = mysqli_query($connect,$q);
		while($row = mysqli_fetch_array($r))
		{
			if(in_array($row[index_no],$ar_mempriv))
			{
				if($row[index_no]==$fid)
				{	echo "<option value='$row[index_no]' selected>$row[sitename]</option>";	}
				else
				{	echo "<option value='$row[index_no]'>$row[sitename]</option>";	}
			}
		}
		?>
	</select>
</td>
</tr>
<tr>
<th>
처리일
</th>
<td colspan='3'>
<?=date("Y-m-d");?>
</td>
</tr>
<tr>
<th>
처리구분
</th>
<td colspan='3'>
<select name='iocate' id='iocate' onchange="set_tbtype();">
			<option value=''>입/출고 구분선택</option>
			<option value='I' <? if($iocate=='I') { echo "selected";	}?>>입고</option>
			<option value='O' <? if($iocate=='O') { echo "selected";	}?>>출고</option>
			</select>
<select class="uch" name='tbtype' id='tbtype'>
<option value=''>처리구분선택</option>

</select>
<input type='checkbox' name='useh' value='Y'> 회계에반영
</td>
</tr>
<tr>
<th>
전표이름
</th>
<td colspan='3'>
<input type='text' class="form-control" name='memo' size='60'> [빈칸시 날짜+입고종류로생성]
</td>
</tr>
<tr>
<th>
파일
</th>
<td colspan='3'>
<input type='file' name='file'>[엑셀파일로 업로드] 
</td>
</tr>
<tr>
<th>
입고옵션
</th>
<td colspan='3'>
<input type='checkbox' name='removef' value='Y'>첫줄제외 | 입고코드열 : <Select class="uch" name="bf1" id="id_bf1">
<option value=''>선택하세요</option>
<?php
for($i=65;$i<91;$i++)
{
	$va = chr($i);
	echo "<option value='".($i-65)."'>$va</option>";
}
?>
</select> 실입고열 : <Select class="uch" name="bf2" id="id_bf2">
<option value=''>선택하세요</option>
<?php
for($i=65;$i<91;$i++)
{
	$va = chr($i);
	echo "<option value='".($i-65)."'>$va</option>";
}
?>
</select>

메모열 : <Select class="uch" name="bf3" id="id_bf3">
<option value=''>선택하세요</option>
<?php
for($i=65;$i<91;$i++)
{
	$va = chr($i);
	echo "<option value='".($i-65)."'>$va</option>";
}
?>
</select> 미송수량열(입고시에만적용) : <Select class="uch" name="bf4" id="id_bf4">
<option value=''>선택하세요</option>
<?php
for($i=65;$i<91;$i++)
{
	$va = chr($i);
	echo "<option value='".($i-65)."'>$va</option>";
}
?>
</select>
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
				<h3><i class="fa fa-table"></i> 재고파일조정</h3>
			</div>
			<div class="panel-content">

				


<form id="form2" name="form2" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" enctype="multipart/form-data" onsubmit="return goch2();">
<input type='hidden' name='mode' value='w2'>
<table class="table table-bordered">
<tr>
<th>
처리일
</th>
<td colspan='3'>
<?=date("Y-m-d");?>
</td>
</tr>
<tr>
<th>
파일
</th>
<td colspan='3'>
<input type='file' name='file'>[엑셀파일로 업로드] <input type='checkbox' name='removef' value='Y'>첫줄제외 | 입고코드열 : <Select class="uch" name="bf1" id="id_nf1">
<option value=''>선택하세요</option>
<?php
for($i=65;$i<91;$i++)
{
	$va = chr($i);
	echo "<option value='".($i-65)."'>$va</option>";
}
?>
</select> 재고수량 : <Select class="uch" name="bf2" id="id_nf2">
<option value=''>선택하세요</option>
<?php
for($i=65;$i<91;$i++)
{
	$va = chr($i);
	echo "<option value='".($i-65)."'>$va</option>";
}
?>
</select>
</td>
</tr>
<tr>
<th>입/출고시구분</th>
<td colspan='3'>
<select name='tbtype1' id='tbtype1'>
                        <option value=''>입고처리구분선택</option>
			<?
			$q = "select * from shop_goods_inout_cate where catetype='I' order by catename asc";
			$r = mysqli_query($connect,$q);
			while($row = mysqli_fetch_array($r))
			{	echo "<option value='$row[index_no]'>$row[catename]</option>";	}
			?>
                        </select>
			<select name='tbtype2' id='tbtype2'>
                        <option value=''>출고처리구분선택</option>
                        <?
                        $q = "select * from shop_goods_inout_cate where catetype='O' order by catename asc";
                        $r = mysqli_query($connect,$q);
                        while($row = mysqli_fetch_array($r))
                        {       echo "<option value='$row[index_no]'>$row[catename]</option>";  }
                        ?>
                        </select>
</td>
</tr>
</table>
<div class="form-group row">
	<div class="col-sm-8 col-sm-offset-4">
		<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#form2">처리하기</button>
	</div>
</div>

</form><!-- // form[name="form2"] -->
			</div>
		</div>
	</div>
</div>