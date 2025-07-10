<?php
$index_no = $_REQUEST['index_no'];
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$value['main_idx'] = $index_no;
	$value['catename'] = $_REQUEST['catename'];
	$value['orders'] = $_REQUEST['orders'];
	insert("shop_design_maincate",$value);
	unset($value);

	show_message("저장완료","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;

}
if($mode=='w2')	{
	
	$idx = $_REQUEST['idx'];

	for($i=0;$i<sizeof($idx);$i++)	{
		

		$value['catename'] = $_REQUEST['catename'][$i];
		$value['orders'] = $_REQUEST['orders'][$i];
		update("shop_design_maincate",$value," where index_no='".$idx[$i]."'");
		unset($value);
	}

	

	show_message("저장완료","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;

}
if($mode=='d')	{
	
	$cateidx = $_REQUEST['cateidx'];
	$pdo->prepare("delete from shop_design_maincate where index_no='$cateidx'")->execute();
	

	show_message("삭제완료","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;
}
?>
<div class="row">
	<div class="col-md-12 ">
		<div class="panel">
			<div class="panel-header ">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form id="regi" name="regi" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tr>
					<th>분류명칭</th>
					<td><input type='text' name='catename' class="form-control"></td>
					<th>정렬순서</th>
					<td><input type='text' name='orders' class="form-control"></td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regi">등록하기</button>
							
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 ">
		<div class="panel">
			<div class="panel-header ">
				<h3><i class="fa fa-table"></i> 등록분류목록</h3>
			</div>
			<div class="panel-content">
				<form id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<input type='hidden' name='mode' value='w2'>
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>NO</th>
					<th>분류명</th>
					<th>정렬순서</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "select * from shop_design_maincate where main_idx='$index_no' order by orders asc";
				$st = $pdo->prepare($q);
				$st->execute();
				while($row = $st->fetch() )	{
				?>
				<tr>
					<td><?=$row['index_no'];?></td>
					<tD><input type='hidden' name='idx[]' value='<?=$row['index_no'];?>'><input type='text' name='catename[]' value='<?=$row['catename'];?>' class="form-control"></td>
					<tD><input type='text' name='orders[]' value='<?=$row['orders'];?>' class="form-control"></td>
					<td>
						<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&index_no=<?=$index_no;?>&mode=d&cateidx=<?=$row['index_no'];?>','삭제하시겠습니까?');" class="btn btn-xs btn-primary">삭제</a>
					</tD>
				</tr>
				<?
				}
				?>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#listform">저장하기</button>
							
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
