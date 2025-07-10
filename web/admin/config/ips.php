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
				<h3><i class="fa fa-table"></i> 사이트 IP차단설정</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
		
				<thead>
				<tr>
			<th>차단할IP</th>
			<td>
			<form name="form1">
				<p style='padding-bottom:10px;'>
					<input type='text' name='ip1' size='4' class='basic_input'>.<input type='text' name='ip2' size='4' class='basic_input'>.<input type='text' name='ip3' size='4' class='basic_input'>.<input type='text' name='ip4' size='4' class='basic_input'> <span class="btn_white_xs"><a href="javascript:set_add();">추가</a></span>
				</p>
				<p>
					<select name='ips' multiple style='width:160px;height:100px;'>
					<?php
					$q = "select * from ${basictb}_site_ip where otype='1'";
					$r = mysql_query($q);
					while($row = mysql_fetch_array($r))
					{
						echo "<option value='$row[ips]'>$row[ips]</option>";
					}
					?>
					</select>
					<span class="btn_white_xs"><a href="javascript:delcate();">삭제</a></span>
				</p>
			</form><!-- // .form[name="form1"] -->
			</td>
		</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>