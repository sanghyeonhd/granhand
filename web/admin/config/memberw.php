<?php
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$value['groupname'] = $_REQUEST['groupname'];
	insert("shop_member_group",$value);
	$idx = $pdo->lastInsertId();

	show_message("등록완료","");
	move_link("$PHP_SELF?code=config_memberm&group_idx=$idx");
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
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 기초정보</h3>
			</div>
			<div class="panel-content">
				
				<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<colgroup>
					<col class="col-md-2">
					<col class="col-md-4">
					<col class="col-md-2">
					<col class="col-md-4">
				</colgroup>
				<tbody>
				<tr>
					<th>회원그룹명</th>
					<td colspan='3'><input type='text' class="form-control" name='groupname' valch="yes" msg="회원그룹명을 입력하세요"></td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">저장하기</button>				
					</div>
				</div>
				</form>
			</div>
		</div>
		
	</div>
</div>
