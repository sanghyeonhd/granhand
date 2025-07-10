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
				<h3><i class="fa fa-table"></i> 정보고시항목추가</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<tbody>
				<tr>
					<th>항목명</th>
					<td><input type='text' name='itemname' id="itemname"></td>
				</tr>

				<tr>
					<th>입력형식</th>
					<td><select name='itemtype' id="itemtype">
					<option value=''>선택하세요</option>
					<option value='text'>텍스트입력</option>
					<option value='radio'>단일선택</option>
					<option value='checkbox'>중복선택</option>
					</select></td>
				</tr>
				<tr>
					<th>기초정보</th>
					<td><input type='text' name='bases' id="bases" style='width:400px;'> [기초 정보는 |R|로 구분하여 입력하세요]</td>
				</tr>
				<tr>
					<th>기타노출값</th>
					<td><input type='text' name='custom_add' style='width:400px;'> </td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
