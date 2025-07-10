<?php
$dir = "../../";
include "$dir/inc/connect.php";
include "$dir/inc/session.php";
include "$dir/inc/config.php";
include "../admin_head.php";

$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_config_icon"," where index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='w')
{
	$userfile = array($_FILES['fname']['name']);
	$tmpfile = array($_FILES['fname']['tmp_name']);


	$savedir = $_uppath."/icon/";

	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_data[fname],"N");	}

	if($ar_data[fname]==$fs[0])
	{	$value[fname] = $fs[0];	}
	else
	{
		@copy($savedir.$fs[0],$savedir.$ar_data[fname]);
		@unlink($savedir.$fs[0]);
		$value[fname] = $ar_data[fname];
	}

	
	$value[isuse] = $_POST['isuse'];
	$value[wuse] = $_POST['wuse'];
	$value[wusedate] = $_POST['wusedate'];

	if( $value[wuse] == "1" || $value[wuse] == "2" )
	{
		$org_data = sel_query_all("shop_config_icon"," where wuse='" . $value[wuse] . "' and index_no <> '$index_no' ");

		if( $org_data != "" )
		{
			echo "<script>alert('이미 신상/품절아이콘이 등록되어 있습니다.\\n등록되어있는 아이콘을 수정하여 주십시요.');history.back();</script>";
			exit;
		}
	}

	update("shop_config_icon",$value," where index_no='$index_no'");
	
	echo "<script>alert('수정완료'); opener.location.reload(); window.close(); </script>";
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
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 아이콘수정</h3>
			</div>
			<div class="panel-content">
	<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>" method="post" ENCTYPE="multipart/form-data">
	<input type="HIDDEN" name="code" value="design_changeicon">
	<input type='hidden' name='mode' value='w'>
	<input type='hidden' name='index_no' value='<?=$index_no;?>'>
	
	<table class="table table-bordered">
	<tr>
	<th>
	아이콘파일
	</th>
	<td colspan='3'>
	<input type='file' name='fname' style="width:80%">
	</td>
	</tr>
	<Tr>
	<th>
	사용여부
	</th>
	<td colspan='3'>
	<select class="uch" name='isuse'>
	<option value='Y' <? if($ar_data[isuse]=='Y') { echo "selected";	}?>>사용</option>
	<option value='N' <? if($ar_data[isuse]=='N') { echo "selected";	}?>>사용안함</option>
	</select>
	</td>
	</tr>
	<Tr>
	<th>
	아이콘종류
	</th>
	<td colspan='3'>
		<input type='radio' name='wuse' value='' onClick="chk_view('n');" <? if($ar_data[wuse]=='') {?>checked<?}?>>일반아이콘
		<input type='radio' name='wuse' value='1' onClick="chk_view('y');" <? if($ar_data[wuse]=='1') {?>checked<?}?>>신상아이콘
		<input type='radio' name='wuse' value='2' onClick="chk_view('n');" <? if($ar_data[wuse]=='2') {?>checked<?}?>>품절아이콘
	</td>
	</tr>
	<Tr>
	<th>
	신상아이콘
	</th>
	<td colspan='3'><div id="new_fld1" style="<? if($ar_data[wuse]!='1') {?>display:none;<?}?>">신상아아콘은 판매시작후 <input type='text' name='wusedate' size='4' value='<?=$ar_data[wusedate];?>'>시간 까지</div></td>
	</tr>
	</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">수정하기</button>
							
					</div>
				</div>

	
	</div><!-- // .form_wrap -->
	</form><!-- // .form[name="regiform"] -->
</div>
</div>
</div>
