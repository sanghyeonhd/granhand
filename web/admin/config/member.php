<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$G_PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>회원그룹추가</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원그룹목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>NO</th>
					<th>그룹아이디</th>
					<th>회원그룹이름</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "select * from shop_member_group order by idx asc";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch() )	{
				?>					
				<tr>
					<td><?=$cou;?></td>
					<td><?=$row['idx'];?>
					<td><?=$row['groupname'];?></td>
					<td><a href="<?=$G_PHP_SELF;?>?code=<?=$code;?>m&group_idx=<?=$row['idx'];?>" class="btn btn-sm btn-primary">수정</a></td>
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
