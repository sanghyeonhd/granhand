<?
$idx = $_REQUEST['idx'];
$ar_data = sel_query_all("shop_qna_cate"," WHERE idx='$idx'");

$mode = $_REQUEST["mode"];
if($mode=='w')
{
	$value['catename'] = $_POST['catename'];
	$value['basememo'] = addslashes($tx_content);
	$value['isgoods'] = $_POST['isgoods'];
	$value['isuse'] = $_REQUEST['isuse'];
	$r = update("shop_qna_cate",$value," WHERE idx='$idx'");

	echo "<script>alert('수정완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;
}
?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('수정 하시겠습니까?');
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
				<h3><i class="fa fa-table"></i> 분류수정</h3>
			</div>
			<div class="panel-content">
<form name="writeform" id="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regich(this);">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='idx' value='<?=$idx;?>'>


				<table class="table table-bordered">
				<tbody>
				<tr>
	<th>분류명</th>
	<td><input type='text' name='catename' class='form-control' style='width:300px;' value="<?=$ar_data['catename'];?>" valch="yes" msg="분류명칭을 입력하세요"></td>
</tr>
<tr>
	<th>상품문의</th>
	<td><input type='checkbox' name='isgoods' value='Y' <? if($ar_data['isgoods']=='Y') { echo "checked";	}?>>상품문의용 분류로 사용합니다.</td>
</tr>
<tr>
	<th>사용여부</th>
	<td><input type='radio' name='isuse' value='Y'  <? if($ar_data['isuse']=='Y') { echo "checked";	}?>>사용 <input type='radio' name='isuse' value='N' <? if($ar_data['isuse']=='N') { echo "checked";	}?>>사용안함</td>
</tr>
				
				</tbody>
				</table>
				
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#writeform">수정하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>


