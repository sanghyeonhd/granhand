<?
$upcate = $_REQUEST['upcate'];
if($mode=='w')	{

	$idx = $_REQUEST['idx'];
	$rorders = $_REQUEST['rorders'];

	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value['rorders'] = $rorders[$i];
		update("shop_cate",$value," WHERE idx='$idx[$i]'");
		unset($value);

	}
	
	echo "<Script>alert('정렬순서를 변경하였습니다.'); location.replace('$PHP_SELF?code=$code&upcate=$upcate'); </script>";
	exit;
}
?>
<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='upcate' value='<?=$upcate;?>'>
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="#none" class="btn btn-sm btn-inverse btn_allchange btn_submits" data-form="#listform"><i class="fa fa-plus m-r-5"></i>정렬순서변경</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 카테고리목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th> 번호 </th>
					<th> 카테고리명 </th>
					<th> 카테고리코드 </th>
					<th> 노출여부 </th>
					<th> 정렬순서 </th>
				</tr>
				</thead>
				<tbody>
				<?
				$cou = 1;
				$q = "select * from shop_cate where upcate='$upcate' order by rorders asc";
				$st = $pdo->prepare($q);
				$st->execute();	
				while($row = $st->fetch())	{
				?>
				<tr>
					<td><?=$cou;?></td>
					<td><?=$row['catename'];?></td>
					<td><?=$row['catecode'];?></td>
					<td><?=$row['isshow'];?></td>
					<Td><input type='hidden' name='idx[]' value='<?=$row['idx'];?>'><input type='text' class="form-control" name='rorders[]' value='<?=$row['rorders'];?>'></td>
				</tr>
				<?
					$cou++;
				}
				?>
				</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="#none" class="btn btn-sm btn-inverse btn_allchange btn_submits" data-form="#listform"><i class="fa fa-plus m-r-5"></i>정보변경</a>
		</div>
	</div>
</div>
</form>