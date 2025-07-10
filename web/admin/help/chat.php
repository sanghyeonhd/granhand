<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 채팅목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>NO</th>
					<th>회원명</th>
					<th>아이디</th>
					<th>마지막시간</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?
$q = "SELECT distinct(smem_idx) as smem_idx FROM shop_chat WHERE wdate BETWEEN '".date("Y-m-d 00:00:00")."' AND '".date("Y-m-d 23:59:59")."' order by wdate desc";
$st = $pdo->prepare($q);
$st->execute();
$cou = 1;
while($row = $st->fetch())	{

	if($row['smem_idx']==0)	{
		continue;
	}
	
	$qs = "select wdate from shop_chat where smem_idx='$row[smem_idx]' order by wdate desc limit 0,1";
	$sts = $pdo->prepare($qs);
	$sts->execute();
	$rows = $sts->fetch();

	$ar_mem = sel_query_all("shop_member"," WHERE index_no='$row[smem_idx]'");
?>
				<tr>
					<td class="first"><?=$cou;?></td>
					<td>
						<a href="javascript:MM_openBrWindow('popup.php?code=help_view&index_no=<?=$ar_mem[index_no];?>','member<?=$ar_mem[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$ar_mem[name];?></a>
					</td>
					<td><?=$ar_mem[id];?></td>
					<td><?=$rows['wdate'];?></td>
					<td>
						
						<a href="javascript:MM_openBrWindow('popup.php?code=help_chatview&smem_idx=<?=$ar_mem[index_no];?>','chat<?=$ar_mem[index_no];?>','scrollbars=yes,width=800,height=800,top=0,left=0');" class="btn btn-primary btn-xs m-r-5">조회</a>
					</td>
				</tR>
<?
	$cou++;
}
?>
				</tbody>
				</table>
					
			</div>
		</div>
		<!-- end panel -->
	</div>
	<!-- end col-12 -->
</div>
