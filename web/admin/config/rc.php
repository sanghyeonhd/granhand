<?php
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	$value[reason] = $_POST['reason'];
	$value[rtype] = $_POST['rtype'];
	insert("shop_action_reason",$value);

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($mode=='listmod')	{

	$idx = $_REQUEST['idx'];

	for($i=0;$i<sizeof($idx);$i++)	{


		$value['reason'] = $_POST['reason'][$i];
		$value['rtype'] = $_POST['rtype'][$i];
		$value['isuse'] = $_POST['isuse'][$i];
		update("shop_action_reason",$value," WHERE index_no='".$idx[$i]."'");

	}
		
	

	echo "<script>alert('수정완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
?>
<script>
function foch()
{
	if(!document.writeform.reason.value)
	{
		alert('항목명입력');
		document.writeform.reason.focus();
		return false;
	}
	if(document.writeform.rtype.options.value=='')
	{
		alert('분류선택');
		document.writeform.rtype.focus();
		return false;
	}
	return true;
}
</script>
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 설정목록</h3>
			</div>
			<div class="panel-content">
				
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='listmod'>
				<table class="table table-bordered">
				<colgroup>
					<col width="50px" />
				</colgroup>
				<thead>
				<Tr>
					<th>NO</th>
					<th>사유</th>
					<th>구분</th>
					<th>사용여부</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "select * from shop_action_reason order by rtype ASC";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch())	{
				?>
		
				<tr>
					<td class="first"><?=$cou;?></td>
					<td><input type='hidden' name='idx[]' value="<?=$row['index_no'];?>"><input type='text' name='reason[]' class="form-control" value="<?=$row['reason'];?>"></td>
					<Td>
						<select name='rtype[]'>
						<option value='1' <? if($row['rtype']=='1') { echo "selected";	}?>>취소사유</option>
						<option value='2' <? if($row['rtype']=='2') { echo "selected";	}?>>교환/반품사유</option>

						</select>	
					</td>
					<td>
						<select name='isuse[]'>
						<option value='Y' <? if($row['isuse']=='Y') { echo "selected";	}?>>사용함</option>
						<option value='N' <? if($row['isuse']=='N') { echo "selected";	}?>>사용안함</option>
						</select>	
					</td>
				</tr>
			
				<?php
					$cou++;
				}
				?>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#listform">수정하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록하기</h3>
			</div>
			<div class="panel-content">
	
		<form id="regiform2" name="regiform2" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
		<input type='hidden' name='mode' value='w'>
		<table class="table table-bordered">
		<tr>
		<th>사유</th>
		<td colspan='3'><input type='text' name='reason' size='30' class='form-control'></td>
		</tr>
		<tr>
		<th>구분</th>
		<td colspan='3'><select class="uch" name='rtype'><option value=''>선택</option><option value='1'>취소사유</option><option value='2'>교환/반품사유</option></select>
		</tr>
		</table>

		<div class="form-group row">
			<div class="col-sm-8 col-sm-offset-4">
				<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform2">등록하기</button>
						
			</div>
		</div>
		
		</form><!-- // .form[name="regiform2"] -->
			</div>
		</div>
	</div>
</div>