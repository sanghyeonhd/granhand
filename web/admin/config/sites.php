<!-- <div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>운영사이트추가</a>
		</div>
	</div>
</div> -->
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 운영사이트목록</h3>
			</div>
			<div class="panel-content">
				<table class="table mlists">
				<thead>
				<tr>
					<th>ID</th>
					<th>채널소속</th>
					<th>구분</th>
					<th>사이트명</th>
					<th>운영전화번호</th>
					<th>사용회원그룹</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "Select shop_config.*,shop_sites.sitename as groupname from shop_config INNER JOIN shop_sites ON shop_sites.idx=shop_config.fid order by fid asc,shop_config.idx asc";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 0;
				while($row = $st->fetch())	{
				?>
				<tr>
					<td><?=$row['idx'];?></td>
					<td class="text-center"><?php echo $row['groupname'];?></td>
					<td class="text-center">
						<?php
						if($row['site_mobile']=='1')	{
							echo "모바일사이트";	
						}
						else if($row['site_mobile']=='2')	{
							echo "PC웹사이트";	
						}
						else if($row['site_mobile']=='3')	{
							echo "반응형웹";	
						}
						else if($row['site_mobile']=='O')	{
							echo "외부주문처";	
						}
					?>
					</td>
					<td class="text-center"><?php echo $row['site_name'];?></td>
					<td class="text-center"><?php echo $row['site_phone'];?></td>
					<Td class="text-center">
					<?php
					if($row['site_mobile']!='O')	{
						$ar_member_group = sel_query("shop_member_group","groupname"," where idx='$row[site_member_group]'");
						echo $ar_member_group['groupname'];
					}
					?>
					</td>
					<td class="text-center"><a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row['idx'];?>" class="btn btn-sm btn-primary">수정</a></td>
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
