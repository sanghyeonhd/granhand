<?
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$value['fid'] = $_REQUEST['fid'];
	$value['name'] = $_REQUEST['name'];
	$value['arpids'] = implode(",",$_REQUEST['pids']);
	$value['isuse'] = "Y";
	insert("shop_warehouse_config",$value);

	show_message("등록완료되었습니다.","");
	move_link("$PHP_SELF?code=$code");
	exit;

}
if($mode=='listmod')	{

	$idx = $_REQUEST['idx'];

	for($i=0;$i<sizeof($idx);$i++)	{


		$value['name'] = $_POST['name'][$i];
		$value['isuse'] = $_POST['isuse'][$i];
		update("shop_warehouse_config",$value," WHERE idx='".$idx[$i]."'");

	}
	show_message("수정완료되었습니다.","");
	move_link("$PHP_SELF?code=$code");
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
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 창고목록</h3>
			</div>
			<div class="panel-content">
				
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='listmod'>

				<table class="table table-bordered">
				<thead>
				<tr>
					<th>NO</th>
					<th>사용처그룹</th>
					<th>장고지명</th>
					<th>출고사용처</th>
					<th>사용여부</th>
					<!-- <th>소속창고</th>
					<th></th> -->
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "select * from shop_warehouse_config order by name ASC";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch())	{
				?>
		
				<tr>
					<td class="first"><?=$cou;?></td>
					<td>
						<?
						for($i=0;$i<sizeof($g_ar_fid);$i++)	{
							if($g_ar_fid[$i]['idx']==$row['fid'])	{
								echo $g_ar_fid[$i]['sitename'];
							}
						}
						?>
					</tD>
					<td><input type='hidden' name='idx[]' value="<?=$row['idx'];?>"><input type='text' name='name[]' class="form-control" value="<?=$row['name'];?>"></td>
					<Td>
						<?
						$ar_tmp = explode(",",$row['arpids']);
						for($i=0;$i<sizeof($ar_tmp);$i++)	{
							if($i!=0)	{
								echo ",";
							}
							echo $g_ar_sitename[$ar_tmp[$i]];
						}
						?>
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
	
				<form id="regiform2" name="regiform2" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<tr>
					<th>사용처그룹</th>
					<td colspan='3'><select name="fid" class="form-control" valch="yes" msg="사용처를 선택하세요">
					<option value=''>사용처를 선택하세요</option>
					<?
					for($i=0;$i<sizeof($g_ar_fid);$i++)	{
						echo "<option value='".$g_ar_fid[$i]['idx']."'>".$g_ar_fid[$i]['sitename']."</option>";
					}
					?>
					</select></td>
				</tr>
				<tr>
					<th>출고판매처</th>
					<td colspan='3' id="arpids">
						<?php
						for($i=0;$i<sizeof($g_ar_pid);$i++)	{
						?>
						<label><input type='checkbox' name='pids[]' value='<?=$g_ar_pid[$i]['idx'];?>'><?=$g_ar_pid[$i]['site_name'];?></label>
						<?
						}
						?>
					</td>
				</tr>
				<tr>
					<th>창고지명</th>
					<td colspan='3'><input type='text' name='name' class='form-control' valch="yes" msg="창고지명을 입력하세요"></td>
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