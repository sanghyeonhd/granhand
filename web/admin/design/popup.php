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
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tr>
					<th>판매처</th>
					<td  colspan='3'>
						<select class="uch" name='fid'>
						<option value=''>전체보기</option>
						<?php
						$q = "select * from shop_sites";
						$q = $q ." order by idx asc";
						$st = $pdo->prepare($q);
						$st -> execute();
						while($row = $st->fetch()){
							if(in_array($row['idx'],$ar_mempriv))	{
								if($row['idx']==$fid){	
									echo "<option value='$row[idx]' selected>$row[sitename]</option>";	
								}	else{	
									echo "<option value='$row[idx]'>$row[sitename]</option>";	
								}
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
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>팝업등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 팝업목록</h3>
			</div>
			<div class="panel-content">

<table class="table table-bordered">
<colgroup>
	<col width="50px" />

</colgroup>
<thead>
<tr>
<th>NO</th>
<th>해당사이트</th>
<th>제목</th>
<th>팝업크기</th>
<Th>좌표</th>
<Th>등록일</th>
<Th>노출시작</th>
<Th>노출종료</th>
<th></th>
</tr>
</thead>
<tbody>
<?php
$q = "select shop_popup.* from shop_popup,shop_config where shop_config.idx=shop_popup.pid order by idx desc";
$st = $pdo->prepare($q);
$st -> execute();
$cou = 1;
while($row = $st->fetch())
{
	$co = "";
	if($row[sdate]<date("Y-m-d H:i:s",time()) && $row[edate]>=date("Y-m-d H:i:s",time()))
	{	$co = "gray";	}
?>

<tr class='<?=$co;?>'>
<td class="first"><?=$cou;?></td>
<Td><? $ar_con = sel_query("shop_config","site_name"," where idx='$row[pid]'");		echo $ar_con['site_name'];	?></td>
<Td style='text-align:left;padding-left:10px;'><?=$row['title'];?></td>
<Td><?=$row['width'];?> X <?=$row['height'];?></td>
<td>상단 : <?=$row['top'];?> | 좌측 : <?=$row['lefts'];?></td>
<Td><?=$row['wdate'];?></td>
<TD><?=$row['sdate'];?></td>
<TD><?=$row['edate'];?></td>
<Td><span class="btn_white_xs"><a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row['idx'];?>">수정</a></span></td>
</tr>
<?php
	$cou++;
}
?>
</tbody> 
</table>
</div><!-- // .list_wrap -->
			</div>
		</div>
	</div>
</div>