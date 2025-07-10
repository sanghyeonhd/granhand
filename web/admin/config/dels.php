<?php
if($mode == 'w')//추가배송비 설정
{
    $value[account] = $_POST['account'];
    $value[location] = $_POST['location'];
    $value[pid] = "1";
    insert("shop_delaccount_add", $value);

    echo "<Script>alert('등록완료'); location.replace('$PHP_SELF?code=$code'); </script>";
    exit;
}
if($mode=='d')	{
	
	$index_no = $_REQUEST['index_no'];

	$q = "DELETE FROM shop_delaccount_add WHERE index_no='$index_no'";
	$st = $pdo->prepare($q);
	$st->execute();					

	 echo "<Script>alert('완료'); location.replace('$PHP_SELF?code=$code'); </script>";
    exit;
}
?>
<script>
function gotoch(f)	{

	var isok = check_form(f);
	if(isok)	{
		answer = confirm('저장하시겠습니까?');
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
				<h3><i class="fa fa-table"></i> 추가배송비설정</h3>
			</div>
			<div class="panel-content">
				<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return gotoch(this);">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<tbody>
				<tr>
					<th>추가택배비</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' name='account' size='10' class='form-control' valch="yes" msg="추가택배비를 입력하세요"> 원
						</div>
					</td>
				</tr>
				<Tr>
					<th>지역명</th>
					<td colspan='3'><textarea cols='60' rows='4' name='location' class='form-control' valch="yes" msg="지역명을 입력하세요. 다수의 지역의 경우 콤마(,)로 구분해서 입력하세요"></textarea></td>
				</tr>
				</tbody>
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
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록된 추가 배송내역</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
		
				<thead>
				<Tr>
					<th>추가택배비</th>
					<th>포함주소</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "select * from shop_delaccount_add where 1 order by account asc";
				$st = $pdo->prepare($q);
				$st->execute();		
				$cou = 1;
				while($row = $st->fetch()){
				?>
				<tr>
					<td class="first"><?=$row[account];?> 원</td>
					<td><?=$row[location];?></td>
					<td>
						<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=d&index_no=<?=$row['index_no'];?>','삭제?');" class="btn btn-xs btn-primary">삭제</a>
					</td>
				</tR>
				<?php
				}
				?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>