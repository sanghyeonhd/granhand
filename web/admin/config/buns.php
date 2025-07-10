<?php
$mode = $_REQUEST["mode"];
if($mode=='w')
{
	$catename = $_POST['catename'];
	$upcate_set = "";
	$categoryDepth = 1;
	
	$q = "SELECT max(catecode) FROM shop_goods_bun WHERE upcate=''";
	$st = $pdo->prepare($q);
	$st->execute();
	$maxcode=$st->fetchColumn();
	

	if(substr($maxcode,0,1)=='0')
	{	$maxcode = substr($maxcode,1,1);	}
	$codes = $maxcode + 1;
	if(strlen($codes)==1)
	{	$codes = "0".$codes;	}

	$codes=$upcate_set.$codes;

	$value[catename] = $catename;
	$value['catecode'] = $codes;
	$value[upcate] = $upcate_set;
	$value[buncode] = $_POST['buncode'];
	insert("shop_goods_bun",$value);

	echo "<script>alert('saved'); location.replace('$PHP_SELF?code=$code&upcate=$value[upcate]'); </script>";
	exit;
}
if($mode=='chall')	{
	
	$idx = $_REQUEST['idx'];
	
	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value['catename'] = $_REQUEST['catename'][$i];
		$value['buncode'] = $_REQUEST['buncode'][$i];
		update("shop_goods_bun",$value," WHERE index_no='".$idx[$i]."'");
		unset($value);
	}

	echo "<script>alert('저장완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
?>
<script>
function gotoch()	{

	var isok = check_form('regiform');
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
				<h3><i class="fa fa-table"></i> 상품분류등록</h3>
			</div>
			<div class="panel-content">
				<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return gotoch();">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<colgroup>
					<col width="20%">
					<col width="80%">
				</colgroup>
				<tr>
					<th>분류명칭</th>
					<td><input type='text' name='catename' class='form-control' valch="yes" msg="Please Input Name Of Item" ></td>
				</tr>
				<tr>
					<th>분류코드</th>
					<td><input type='text' name='buncode' class='form-control' valch="yes" msg="Please Input ItemCode" ></td>
				</tr>
				
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<a href="#none" class="btn btn-primary" onclick="$('#regiform').submit()">저장하기</a>
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
				<h3><i class="fa fa-table"></i> 분류목록</h3>
			</div>
			<div class="panel-content">
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='chall'>
				<table class="table table-bordered">			
				<thead>
				<tr>
					<th>분류명칭</th>
					<th>분류코드</th>
					
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "SELECT * FROM shop_goods_bun ORDER BY catecode ASC";
				$st = $pdo->prepare($q);
				$st->execute();
				while ($row = $st->fetch()) {
				?>
				<tr>
					<td><input type='hidden' name='idx[]' value='<?=$row['index_no'];?>'><input type='text' class="form-control" name='catename[]' value='<?=$row['catename'];?>'></td>
					<td><input type='text' class="form-control" name='buncode[]' value='<?=$row[buncode];?>'></td>
					
					<td>
					<? if(strlen($row[catecode])=='2') { 	
					?>
					<a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&index_no=<?=$row['index_no'];?>" class="btn btn-sm btn-primary">상품정보고시설정</a>
					<?
					} ?>
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
						<a href="#none" class="btn btn-primary btn_submits" data-form="#listform">수정하기</a>
					</div>
				</div>
				</form>

			</div>
		</div>
	</div>
</div>