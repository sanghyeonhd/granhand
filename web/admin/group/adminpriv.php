<?
$mode = $_REQUEST['mode'];
if($mode=='w2')
{
	$value['grade_id'] = $_POST['grade_id'];
	$value['grade_name'] = $_POST['grade_name'];

	$q = "select * from shop_admin_grade where grade_id='$value[grade_id]'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit!=0)
	{
		echo "<Script>alert('중복된 레벨입니다.'); history.back(); </script>";
		exit;
	}

	$q = "select * from shop_admin_grade where grade_name='$value[grade_name]'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit!=0)
	{
		echo "<Script>alert('중복된 등급명입니다.'); history.back(); </script>";
		exit;
	}

	insert("shop_admin_grade",$value);

	show_message("등록완료되었습니다.","");
	move_link("$PHP_SELF?code=$code&idx=$idx");
	exit;
}
if($mode=='d')
{
	$idx = $_REQUEST['idx'];
	$q = "select * from shop_member where amemgrade='$idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit!=0)
	{
		echo "<script>alert('권한이 부여된 관리자가 있습니다 삭제후 처리 바랍니다'); history.back(); </scrpt>";
		exit;
	}		
	$pdo->prepare("delete from shop_admin_grade where idx='$idx'")->execute();

	echo "<Script>alert('삭제완료되었습니다.'); location.replace('$PHP_SELF?code=$code&pid=$pid'); </script>";
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
				<h3><i class="fa fa-table"></i> 관리자등급</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="60px" />
				</colgroup>
				<thead>
				<tr>
					<th scope="col">레벨</th>
					<th scope="col">등급명</th>
					<th scope="col"></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "select * from shop_admin_grade order by grade_id asc";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch() )	{
				
				?>
				
				<tr>
					<td><?=$row['grade_id'];?></td>
					<td><?=$row['grade_name'];?></td>
					</td>
					<td>
						<span class="btn_white_xs"><a href="<?=$G_PHP_SELF;?>?code=<?=$code;?>v&grade_id=<?=$row['grade_id'];?>">권한설정</a></span>
						<span class="btn_white_xs"><a href="javascript:delok('<?=$G_PHP_SELF;?>?code=<?=$code;?>&idx=<?=$row['idx'];?>&mode=d','삭제하시겠습니까?');">삭제</a></span>
					</td>
				</tr>
				
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
				<h3><i class="fa fa-table"></i> 관리자등급등록</h3>
			</div>
			<div class="panel-content">
				<form id="writeform" name="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w2'>
				<table class="table table-bordered">
				<tr>
					<th>레벨</th>
					<td colspan='3'>
						<select class="uch" name='grade_id' class="form-control" valch="yes" msg="레벨선택하세요">
						<option value=''>선택</option>
						<?php
						for($i=1;$i<=100;$i++)	{
							echo "<option value='$i'>$i</option>";	
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>등급명</th>
					<td colspan='3'><input type='text' name='grade_name' class="form-control" valch="yes" msg="등급명을 입력하세요"></td>
				</tr>
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