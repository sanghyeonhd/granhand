<?
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">


				<table class="table table-bordered">
				<colgroup>
					<col width="15%" />
					<col width="35%" />
					<col width="15%" />
					<col width="35%" />
				</colgroup>
				<tbody>
				<tr>
					<th>판매처그룹</th>
					<td colspan='3'>
						<select class="uch" name="fid" style="width:240px">
<option value=''>적용사이트선택</option>
<?php
$q = "select * from shop_sites";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())
{
	if(in_array($row['idx'],$ar_mempriv))
	{
		if($row['idx']==$fid)
		{	echo "<option value='$row[idx]' selected >$row[sitename]</option>";	}
		else
		{	echo "<option value='$row[idx]'>$row[sitename]</option>";	}
	}
}
?>
</select>
					</td>
				</tr>
				
				</tbody>
				</table>
				
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>


<?
if($fid)
{
?>
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>분류등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 설정구분목록</h3>
			</div>
			<div class="panel-content">


				<table class="table table-bordered">

			<thead>
				<tr>
					<th scope="col">NO</th>
					<th scope="col">질답구분</th>
					<th scope="col">상품관련질문여부</th>
					<th scope="col">사용여부</th>
					<th scope="col">수정</th>
				</tr>
			</thead>
			<tbody>
			<?
			$q = "select * from shop_qna_cate where fid='$fid' order by idx asc";

			$st = $pdo->prepare($q);
			$st->execute();
			while($row = $st->fetch())
			{
				$co = "";
				if(!($cou%2)) $co = "gray";
			?>
				<tr  class='<?=$co;?>'>
					<td class="first"><?=($cou+1);?></td>
					<td><?=$row[catename];?></td>
					<td><?=$row[isgoods];?></td>
					<td><?=$row[isuse];?></td>
					<Td>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">수정</a>
					</tD>
				</tr>
			<?
				$cou++;
			}
			?>
			</tbody>
		</table>
	</div>
<?
}
?>

</div>