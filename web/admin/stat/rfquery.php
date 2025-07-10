<?
$hcode = "1";
?>
<div class="row">
	<Div class="col-md-12">

	<div class="email-btn-row hidden-xs">
		<a href="subpage?code=stat_visit&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">전체방문현황</a>
		<a href="subpage?code=stat_hour&hcode=<?=$hcode;?>&type=vs" class="btn btn-primary btn-xs m-r-5">시간대별방문현황</a>
		<a href="subpage?code=stat_week&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">요일별방문현황</a> 
		<a href="subpage?code=stat_domain&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">유입방법 </a> 
		<a href="subpage?code=stat_rfquery&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">유입키워드</a> 
		<a href="subpage?code=stat_blog&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">블로그/커뮤니티</a> 
		<a href="subpage?code=stat_pstart&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">시작페이지</a> 
		<a href="subpage?code=stat_br&hcode=<?=$hcode;?>"  class="btn btn-primary btn-xs m-r-5" >브라우저</a> 
		<a href="subpage?code=stat_os&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">운영체제</a> 
		<a href="subpage?code=stat_display&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">해상도</a> 
		<a href="subpage?code=stat_lang&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">사용언어</a> 
		<a href="subpage?code=stat_cpu&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">CPU</a>
	</div>
	
	</div>
</div>
<?php

mysql_query("SET NAMES utf8");
 
$sdate = $_GET['sdate'];
$edate = $_GET['edate'];

if ($sdate == "" or $edate == "") {
	$sdate = date('Y-m-d');
	$edate = date('Y-m-d');
}
	
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>기간</th>
					<td  colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='date' id='se_sdate' value='<?=$sdate;?>'> ~ <input type='text' class="form-control" name='edate' id='se_edate' value='<?=$edate;?>'>
						</div>
					</td>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 유입키워드</h3>
			</div>
			<div class="panel-content">
				 <?php
          	$qry = "SELECT @rownum := @rownum +1 AS rownum, a. * 
											FROM (
											SELECT rf_sub, rf_domain, query, COUNT( id ) AS count
											FROM tb_data
											WHERE reg_date >=  '".$sdate."'
											AND reg_date <  DATE_FORMAT('".$edate."' +INTERVAL 1 DAY,'%Y-%m-%d')
											AND rf_domain !=  '".$domain_name."'
											AND rf_domain !=  ''
											AND query !=  ''
											GROUP BY rf_sub, rf_domain, query
											ORDER BY count DESC
											) AS a, (SELECT @rownum :=0)r
											LIMIT 1000";

						$result = mysql_query($qry) or die(mysql_error());
						
          ?>

	<table class="table table-bordered">
		<colgroup>
			<col width="10%" />
			<col width="24%" />
			<col width="26%" />
			<col width="20%" />
			<col width="20%" />
		</colgroup>
		<thead>
		<tr>
			<th>NO</th>
			<th>유입키워드</th>
			<th>유입상세</th>
			<th>유입수</th>
			<th>유입비중</th>
		</tr>
		</thead>
		<?php
		
		$row = mysql_num_rows($result);
		
		$rf_full = "";
		
		$total_cnt = 0;
		
		$num_count = 1;
		
		if ($row != 0 )
		{
			while( $data = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$num				= $data["rownum"];
				$rf_sub 		= $data["rf_sub"];
				$rf_domain	= $data["rf_domain"];
				$count			= $data["count"];
				$rf_qry			= $data["query"];
				
				if ($rf_sub != "") {
					$rf_full = $rf_sub.".".$rf_domain;
				}
				else {
					$rf_full = $rf_domain;
				}
			          	
		  	echo "<tr>";
		  	echo "	<td class='first'>".$num."</td>";
		  	echo "	<td style='background-color:#EEB4E9;'>".$rf_qry."</td>";
		  	echo "	<td>".$rf_full."</td>";
		  	echo "	<td id='rf_cnt_".$num_count."'>".number_format($count)."</td>";
		  	echo "	<td id='rf_avg_".$num_count."'>NaN</td>";
		  	echo "</tr>";
		  	echo "<input id='sub_".$num."' type='hidden' value='".$rf_sub."' />";
		  	echo "<input id='domain_".$num."' type='hidden' value='".$rf_domain."' />";
		  	
		  	$total_cnt = $total_cnt + $count;
		  	$num_count = $num_count + 1;
			}
		}
		else {
		?>					
		<tbody>
		<tr>
			<td class="first" colspan="5"><p style="color:red;">데이터 없음</p></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>

			</div>
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#se_sdate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#se_edate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>