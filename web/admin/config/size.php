<div class="header">
	<h2><strong>Blank</strong> Page</h2>
	<div class="breadcrumb-wrapper">
		<ol class="breadcrumb">
			<li><a href="main.php">Make</a></li>
			<li><a href="#">Pages</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header panel-controls">
				<h3><i class="fa fa-table"></i> 규격설정등록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<tbody>
				<tr>
					<th>규격명칭</th>
					<td><input type='text' name='name' class="form-control" size='20'></td>
				</tr>
				<Tr>
					<th>규격이미지</th>
					<td><input type='file' name='file' class="form-control"></td>
				</tr>
				<Tr>
					<th>측정항목</th>
					<td>
						<div class="form-inline">
						<?php
						for($i=0;$i<10;$i++)	{
						?>
						<input type='text' name='ele' size='10' class="form-control" style="width:8%;">
						<?php
						}
						?>
						</div>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
