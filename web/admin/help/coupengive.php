<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>쿠폰배포</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 배포내역</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>번호</th>
					<th>지급쿠폰종류</th>
					<th>쿠폰명</th>
					<th>지급대상</th>
					<th>지급수량</th>
				</tr>
				</thead>
				<tbody>
<?php
$q = "Select * from shop_coupen_log order by wdate desc";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->Fetch())	{

	$ar_coupen = sel_query_all("shop_coupen"," WHERE idx='$row[coupen_idx]'");
?>
				<tr>
					<td><?=$row['idx'];?></td>
					<td><? if($ar_coupen[usetype]=='1') { echo "일반쿠폰";	} else if($ar_coupen[usetype]=='2') {  echo "리워드쿠폰";	}?></td>
					<td><?=$ar_coupen['coupenname'];?></td>
					<td>
					<?
					$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");
					echo $ar_goods['gname']."제품 $row[sdate] ~ $row[edate] 배송완료";
					?>
					</td>
					<td>
					<?php
					$q2 = "Select idx from shop_coupen_mem where log_idx='$row[idx]'";
					$st2 = $pdo->prepare($q2);
					$st2->execute();
					echo $st2->rowCount();
					?>
					</tD>
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