<?php
$q = "SELECT * FROM shop_design_layout ORDER BY index_no ASC";
$st = $pdo->prepare($q);
$st->execute();
while ($row = $st->fetch()) {
	$ar_c = sel_query("shop_config", "site_name", " WHERE index_no = '$row[pid]'");
	$row[site_name] = $ar_c[site_name];
	
	$q2 = "SELECT * FROM shop_config_domain WHERE skin_idx = '{$row[index_no]}'";
	$st2 = $pdo->prepare($q2);
	$st2->execute();
	while ($row2 = $st2->fetch()) {
		if ($row[sname].".".$skin_domain == $row2[domain]) {
			$_ext = " (기본도메인)";
		} else {
			$_ext = "";
		}
		
		if ($row[pid]) {
			$domain[] = "<a href=\"http://{$row2[domain]}\" target=\"_blank\">http://{$row2[domain]}</a>{$_ext}";
		} else {
			$domain[] = "<a href=\"javascript:alert('사용처를 선택해주세요.')\">http://{$row2[domain]}</a>{$_ext}";
		}
	}
	
	$row[domain] = implode("<br/>", $domain);
	unset($domain);
	
	$ar_data[] = $row;
}
?>
<script language="javascript">
function set_main(index) {
	MM_openBrWindow('./popups/layout_pub.php?index_no='+index,'layout','width=500,height=300,top=0,left=0');
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>스킨추가</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 스킨목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">

	<colgroup>
		<col width="50px" />
		<col width="" />
		<col width="" />
		<col width="" />
		<col width="" />
		<col width="130px" />
		<col width="90px" />
		<col width="90px" />
		<col width="90px" />
	</colgroup>
	<thead>
	<tr>
		<th>NO</th>
		<th>스킨명</th>
		<th>스킨ID</th>
		<th>사용처</th>
		<th>연결도메인</th>
		<th>마지막수정일</th>
		
		<th>디자인관리</th>
	</tr>
	</thead>
	<tbody>
<?php
for ($i = 0;$i < count($ar_data); $i++) {
	$row = $ar_data[$i];
?>
	<tr>
		<td><?=$row[index_no];?></td>
		<td><?=$row[name];?></td>
		<td><?=$row[sname];?></td>
		<td><?=$row[site_name];?></td>
		<td><?=$row[domain];?></td>
		<td><?=$row[moddate];?></td>
		
		<td><span class="btn_white_xs"><a href="newdesign.php?code=newdesign_pages&skin_idx=<?=$row[index_no];?>" target="_blank">관리하기</a></span></td>
	</tr>
<?php
}
?>
	</tbody>
	</table>
</div>

</div><!-- // .content -->
</div>
</div>