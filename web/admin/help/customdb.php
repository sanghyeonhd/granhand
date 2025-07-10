<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>커스텀DB등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>번호</th>
					<th>데이터명칭</th>
					<th>필드수</th>
					<th>등록데이터</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?php
$q = "Select * from shop_customdb order by name asc";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
?>
				<tr>
					<tD><?=$row['index_no'];?></td>
					<td><?=$row['name'];?></td>
					<Td>
						<?php
						$qs = "Select index_no from shop_customdb_sch where customdb_idx='$row[index_no]'";
						$sts = $pdo->prepare($qs);
						$sts->execute();
						echo $sts->rowCount();
						?>
					</tD>
					<td>
						<?php
						$qs = "Select index_no from shop_customdb_data where customdb_idx='$row[index_no]'";
						$sts = $pdo->prepare($qs);
						$sts->execute();
						echo $sts->rowCount();
						?>
					</td>
					<td>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>data&index_no=<?=$row[index_no];?>" class="btn btn-xs btn-primary">데이터관리</a>
					</td>
				</tr>
<?php
}
?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>