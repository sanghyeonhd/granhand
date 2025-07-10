<?
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}

$mode = $_REQUEST["mode"];
if($mode=='w')
{
	$value['catename'] = $_POST['catename'];
	$value['basememo'] = addslashes($tx_content);
	$value['isgoods'] = $_POST['isgoods'];
	$value['isuse'] = "Y";
	$value['fid'] = "1";
	$r = insert("shop_qna_cate",$value);

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
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
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 분류등록</h3>
			</div>
			<div class="panel-content">
<form name="writeform" id="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regich(this);">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='fid' value='<?=$fid;?>'>


				<table class="table table-bordered">
				<tbody>
				<tr>
	<th>분류명</th>
	<td><input type='text' name='catename' class='form-control' style='width:300px;' valch="yes" msg="분류명칭을 입력하세요"></td>
</tr>
<tr>
	<th>상품문의</th>
	<td><input type='checkbox' name='isgoods' value='Y'>상품문의용 분류로 사용합니다.</td>
</tr>
<tr>
	<th>사용여부</th>
	<td><input type='radio' name='isuse' value='Y' checked>사용 <input type='radio' name='isuse' value='N'>사용안함</td>
</tr>
				
				</tbody>
				</table>
				
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#writeform">등록하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>


