<?
if($mode=='ch2')	{


	$orders = 1;
	for($i=0;$i<sizeof($index_no);$i++)	{
	
		$value[orders] = $orders;
		update("shop_intro_store",$value," where index_no='{$index_no[$i]}'");
		unset($value);

		$value[orders] = $orders;
		update("shop_intro_store",$value," where up_idx='{$index_no[$i]}'");
		unset($value);
		$orders = $orders + 1;
	}
	
	echo "<Script>alert('설정완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
?>
<script>
$(document).ready(function()	{
	
	$(".btn_allchange").on("click",function()	{
		answer = confirm('순서변경 하시겠습니까?');
		if(answer==true)	{
			$("#form1").submit();
		}
	});

});
</script>
<script language="javascript" src="/assets/global/js/multiCheckUpDown.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="#none" class="btn btn-sm btn-inverse btn_allchange"><i class="fa fa-plus m-r-5"></i>순서변경</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-content">

				<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='ch2'>
				<div class="row">
					<div class="col-md-11">

				<div class="list_wrap order_list" id='scont' style="overflow:auto; width:96%; height:700px;">
					<table class="table table-bordered" id="sorttable">
						<colgroup>
							<col width="50px">

						</colgroup>
						<thead>
							<tr>
								<th>선택</th>
								<th>순서</th>
								<th>지역</th>
								<th>매장명</th>
								
							</tr>
						</thead>
						<tbody>
							<?
							$q = "select *  from shop_intro_store where lang='ko' order by orders asc";
							$r = mysql_query($q);
							$cnt = 1;
							$ks = 1;
							while($row = mysql_fetch_array($r)) {
								
								if($ks!=$row[orders] && $row[isfix]=='') {
									mysql_query("update shop_intro_store set orders='$ks' where index_no='$row[index_no]'");	
									$row[orders] = $ks;	
								}

								$ar_loca = sel_query_all("shop_intro_store_loca"," WHERE index_no='$row[loca_idx]'");
							?>
							<tr class="">
								<td class="first">

									<input type='hidden' name='index_no[]' value="<?=$row[index_no];?>">
									<input type='hidden' name='dels_idxs' value="<?=$cnt;?>">
									<input type='checkbox' name='del_idx' value='<?=$row[index_no];?>'>
								</td>
								<td>
									<?=$cnt;?><span class="ornums"></span>
								</td>
								<td><?=$ar_loca['name'];?></td>
								<td><?=$row['name'];?></td>
							</tr>
							<?
								$cnt++;
								$ks++;
							}
							?>
						</tbody>
					</table>
					</div>
				</div>
				<div class="col-md-1">
					<div class="multicheck">
						<span class="btn_white_s first"><a href="#"><i class="fa fa-angle-double-up fa-2x" aria-hidden="true"></i></a></span><br/>
						<span class="btn_white_s up"><a href="#"><i class="fa fa-angle-up fa-2x" aria-hidden="true"></i></a></span><br/><br/>
						<span class="btn_white_s down"><a href="#"><i class="fa fa-angle-down fa-2x" aria-hidden="true"></i></a></span><br/>
						<span class="btn_white_s end"><a href="#"><i class="fa fa-angle-double-down fa-2x" aria-hidden="true"></i></a></span>
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
			<a href="#none" class="btn btn-sm btn-inverse btn_allchange"><i class="fa fa-plus m-r-5"></i>순서변경</a>
		</div>
	</div>
</div>
