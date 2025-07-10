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
if($mode=='ch')
{
	$index_no = $_REQUEST['index_no'];
	$ar_data = sel_query_all("shop_config_icon"," where index_no='$index_no'");

	if($ar_data[isuse]=='Y')
	{	$value[isuse] = "N";	}
	else
	{	$value[isuse] = "Y";	}


	update("shop_config_icon",$value," where index_no='$index_no'");

	echo "<script>alert('변경완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($mode=='w')
{
	$userfile = array($_FILES['fname']['name']);
	$tmpfile = array($_FILES['fname']['tmp_name']);

	$savedir = $_uppath."/icon/";

	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}

	$value[fid] = $fid;
	$value[fname] = $fs[0];
	$value[isuse] = $_POST['isuse'];
	$value[wuse] = $_POST['wuse'];
	$value[wusedate] = $_POST['wusedate'];

	if( $value[wuse] == "1" || $value[wuse] == "2" )
	{
		$org_data = sel_query_all("shop_config_icon"," where wuse='" . $value[wuse] . "'");

		if( $org_data != "" )
		{
			echo "<script>alert('이미 신상/품절아이콘이 등록되어 있습니다.\\n등록되어있는 아이콘을 수정하여 주십시요.');history.back();</script>";
			exit;
		}
	}

	insert("shop_config_icon",$value);
	
	echo "<script>alert('등록완료 $org_data'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
}
if($mode=='d')
{
	$index_no = $_REQUEST['index_no'];
	$ar_data = sel_query_all("shop_config_icon"," where index_no='$index_no'");

	@unlink($_uppath."/icon/".$ar_data[fname]);

	$q = "select * from shop_goods where icons like '%$row[fname]%'";
	$r = mysqli_query($connect,$q);
	while($row = mysqli_fetch_array($r))
	{
		$value[icons] = str_replace($ar_data[fname]."|R|","",$row[icons]);
		update("shop_goods",$value," where index_no='$row[index_no]'");
	}	

	
	mysqli_query($connect,"delete from shop_config_icon where index_no='$index_no'");

	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
}
?>

<script language="javascript">
function chk_view(kind)
{
	if( kind == "y")
		 $("#new_fld1").css("display", "block");
	else
		 $("#new_fld1").css("display", "none");
}
</script>

<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 설정목록</h3>
			</div>
			<div class="panel-content">


	<table class="table table-bordered">
	<colgroup>
		<col width="45px" />
		<col width="" />
		<col width="70px" />
	</colgroup>
	<thead>
		<tr>
		<th>번호</th>
		<th>IMG</th>
		<th>사용여부</th>
		<th>종류</th>
		<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$q = "select * from shop_config_icon where 1 order by index_no asc";
	$r = mysqli_query($connect,$q);
	$cou = 1;
	while($row = mysqli_fetch_array($r))
	{
		$co = "";
		if(!($cou%2)) $co = "gray";
	
	?>
	<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
	<td class="first"><?=$cou;?></td>
	<td><img src="<?=$_imgserver;?>/files/icon/<?=$row[fname];?>"></td>
	<td><a href="<?=$PHP_SELF;?>?code=<?=$code;?>&mode=ch&index_no=<?=$row[index_no];?>"><?=$row[isuse];?></td>
	<td><? if($row[wuse]=='1') { echo "신상 $row[wusedate] 시간까지";	} else if($row[wuse]=='2') { echo "품절";	}?></td>
	<td>
		<a href="javascript:MM_openBrWindow('popup?code=design_changeicon&index_no=<?=$row[index_no];?>','icons','width=500,height=400,scrollbars=no');" class="btn btn-xs btn-primary">수정</a>
		<a href="javascript:delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=d&index_no=<?=$row[index_no];?>&fid=<?=$fid;?>','삭제하시겠습니까?');" class="btn btn-xs btn-primary">삭제</a>
		</td>
	</tR>
	<?php
		$cou++;
	}
	?>
	</tbody>
	</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록하기</h3>
			</div>
			<div class="panel-content">

	<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
	<input type='hidden' name='mode' value='w'>
	<table class="table table-bordered">
		<tr>	
		<th>
		아이콘파일
		</th>
		<td colspan='3'>
		<input type='file' name='fname'>
		</td>
		</tr>
		<tr>
		<th>
		사용여부
		</th>
		<td colspan='3'>
		<select class="uch" name='isuse'>
		<option value='Y'>사용</option>
		<option value='N'>사용안함</option>
		</select>
		</td>
		</tr>
		<tr>
		<th>
		아이콘종류</th>
		<td colspan='3'>
			<input type='radio' name='wuse' value='' onClick="chk_view('n');" checked>일반아이콘
			<input type='radio' name='wuse' value='1' onClick="chk_view('y');">신상아이콘
			<input type='radio' name='wuse' value='2' onClick="chk_view('n');">품절아이콘
		</td>
		</tr>
		<tr>
		<th>
		신상아이콘
		</th>
		<td colspan='3'><div id="new_fld1" style="display:none;">신상아아콘은 판매시작후 <input type='text' name='wusedate' size='4'>시간까지</div></td>
		</tr>
		</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
							
					</div>
				</div>
	</form>
			</div>
		</div>
	</div>
</div>
