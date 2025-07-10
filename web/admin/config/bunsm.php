<?php
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_goods_bun"," WHERE index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='listmod')	{
	
	$idx = $_REQUEST['idx'];
	$itemname = $_REQUEST['itemname'];
	$bases = $_REQUEST['bases'];

	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value['itemname'] = $itemname[$i];
		$value['bases'] = $bases[$i];
		update("shop_config_goodsadd",$value," WHERE index_no='".$idx[$i]."'");
		unset($value);
	}
	
	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
if($mode=='w')	{
	
	$value['bun_idx'] = $index_no;
	$value['itemname'] = $_REQUEST['itemname'];
	$value['bases'] = $_REQUEST['bases'];
	insert("shop_config_goodsadd",$value);
	unset($value);

	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
if($mode=='d')	{
	
	$idx = $_REQUEST['idx'];
	mysqli_query($connect,"DELETE FROM shop_config_goodsadd WHERE index_no='$idx'");


	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
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
				<h3><i class="fa fa-table"></i> 아이템 기본정보</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="20%">
					<col width="80%">
				</colgroup>
				<tr>
					<th>분류명칭</th>
					<td><?=$ar_data['catename'];?></td>
				</tr>
				
				</table>
					
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 기초고시항목등록</h3>
			</div>
			<div class="panel-content">
				<form name="writeform" id="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this)">
				<input type="hidden" name="index_no" value="<?=$index_no;?>">
				<input type="hidden" name="mode" value="w">
				<table class="table table-bordered">
				<colgroup>
					<col width="20%">
					<col width="80%">
				</colgroup>
				<tr>
					<th>분류명칭</th>
					<td><input type='text' name="itemname" class="form-control" valch="yes" msg="분류명칭을 입력하세요"></td>
				</tr>
				<tr>
					<th>내용</th>
					<td><input type='text' name="bases" class="form-control" ></td>
				</tr>
				
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<a href="#none" class="btn btn-primary btn_submits" data-form="#writeform">등록하기</a>
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
				<h3><i class="fa fa-table"></i> 설정된고시정보</h3>
			</div>
			<div class="panel-content">
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<input type='hidden' name='mode' value='listmod'>
				<table class="table table-bordered">

				<thead>
				<tr>
					<th>고시명칭</th>
					<th>내용</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?
				$q = "SELECT * FROM shop_config_goodsadd WHERE bun_idx='$index_no' ORDER BY index_no ASC";
				$st = $pdo->prepare($q);
				$st->execute();
				while($row = $st->fetch())	{
				?>
				<tr>
					<td><input type='hidden' name='idx[]' value='<?=$row['index_no'];?>'><input type='text' class="form-control" name="itemname[]" value="<?=$row['itemname'];?>"></td>
					<td><input type='text' class="form-control" name="bases[]" value="<?=$row['bases'];?>"></td>
					<td>
						<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&idx=<?=$row[index_no];?>&index_no=<?=$index_no;?>&mode=d','삭제?');" class="btn btn-xs btn-primary">삭제</a>
					</td>
				</tr>
				<?}?>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<a href="#none" class="btn btn-primary btn_submits" data-form="#listform">저장하기</a>
					</div>
				</div>

				</form>
			</div>
		</div>
	</div>
</div>
