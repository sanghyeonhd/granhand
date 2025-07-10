<?
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$id = trim($_REQUEST['id']);

	$q = "SELECT * FROM shop_member WHERE id='$id'";
	$r = mysqli_query($connect,$q);
	$isits = mysqli_num_rows($r);

	if($isits==0)	{
		show_message("없는아이디 입니다.",true);
		exit;
	}

	$row = mysqli_fetch_Array($r);

	$sites = $_REQUEST['sites'];
	$sites = serialize($sites);

	$value[mempriv] = $sites;
	$value[amemgrade] = $_REQUEST['amemgrade'];
	update("shop_member",$value," where idx='$row[idx]'");
	
	


	show_message("완료","");
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
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 관리자등록</h3>
			</div>
			<div class="panel-content">

<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);" >
<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<tr>
					<th>아이디</th>
					<td ><input type='text' name='id' class="form-control" valch="yes" msg="관리자로 등록할 아이디 입력"></td>
				</tr>
				<tr>
					<th>등급</th>
					<td >
						 <select class="uch" name="amemgrade" valch="yes" msg="등급을 선택하세요">
						<option value=''>권한선택</option>
			<?
			$qs = "select * from shop_admin_grade order by grade_id asc";
			$sts = $pdo->prepare($qs);
			$sts->execute();
			while($rows = $sts->fetch())
			{
				if($row['amemgrade']==$rows['grade_id'])
				{	echo "<option value='$rows[grade_id]' selected>$rows[grade_name]</option>";	}
				else
				{       echo "<option value='$rows[grade_id]'>$rows[grade_name]</option>";       }
			}
			?>
			</select>
					</td>
				</tr>
				<tr>
					<th>접근판매처</th>
					<td >
						<?
						 $qs2 = "select * from shop_sites";
						$sts2 = $pdo->prepare($qs2);
						$sts2->execute();
						while($rows2 = $sts2->fetch())			{
							echo "<input type='checkbox' name='sites[]' value='$rows2[idx]' checked>$rows2[sitename]";
						}
			?>
					</td>
				</tr>
				</table>
				<div class="row">
	<div class="col-md-12">
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
						
				</div>
			</div>
	</div>
</div>
</form>
			</div>
		</div>
	</div>
</div>
