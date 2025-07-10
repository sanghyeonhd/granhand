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

$sdate = $_GET['sdate'];
$edate = $_GET['edate'];

if ($sdate == "" or $edate == "") {
	$syear = date('Y');
	$smonth = date('m');
	$sday = date('d');
	$baseSec = mktime(0,0,0,$smonth, $sday, $syear);
	$addSec = 6 * 86400;
	$targetSec = $baseSec - $addSec;
	$sdate = date("Y-m-d", $targetSec);
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
				<h3><i class="fa fa-table"></i> 요일별방문현황</h3>
			</div>
			<div class="panel-content">
				 <?php
						$qry = "SELECT 	DATE_FORMAT(DATE, '%w') AS WEEK, 
														SUM(NEW_CNT) AS NEW, 
														SUM(RE_CNT) AS RE, 
														SUM(VIEW_CNT) AS VIEW 
										  FROM  tb_visit
										 WHERE DATE >= '".$sdate."' 
										   AND DATE < DATE_FORMAT('".$edate."' +INTERVAL 1 DAY,'%Y-%m-%d')
									  GROUP BY DATE_FORMAT(DATE, '%w')";

						$result = mysql_query($qry) or die(mysql_error());
						
          ?>
         <table class="table table-bordered">
          	<colgroup>
          		<col width="19%" />
          		<col width="16%" />
          		<col width="16%" />
          		<col width="16%" />
          		<col width="17%" />
          		<col width="16%" />
          	</colgroup>
          	<thead>
          	<tr>
          		<th>요일</th>
          		<th>방문수</th>
          		<th>신규방문수</th>
          		<th>재방문수</th>
          		<th>페이지뷰</th>
          		<th>방문당페이지뷰</th>
          	</tr>
          	</thead>
          	<tbody>
<?php

$row = mysql_num_rows($result);

$t_view = 0;
$t_new = 0;
$t_re = 0;
$t_sum = 0;
$a_per_view = 0;
$t_num = 0;

if ($row != 0 )
{
	while( $data = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$week 			= $data["WEEK"];
		$new_cnt 			= $data["NEW"];
		$re_cnt 		= $data["RE"];
		$view_cnt     = $data["VIEW"];
		
		switch ($week) {
			case 0 : $week = '일';	break;
			case 1 : $week = '월';	break;
			case 2 : $week = '화';	break;
			case 3 : $week = '수';	break;
			case 4 : $week = '목';	break;
			case 5 : $week = '금';	break;
			case 6 : $week = '토';	break;
			default: $week = '?';		break;
		}
		
		$total_cnt  = $new_cnt + $re_cnt;
	  
	  if ($total_cnt != 0) {
			$view_rate  = $view_cnt / $total_cnt;
		}
	          	
  	echo "<tr>";
  	echo "	<td class='first'>".$week."요일</td>";
  	echo "	<td style='background-color:#EEB4E9;'>".number_format($total_cnt)."</td>";
  	echo "	<td>".number_format($new_cnt)."</td>";
  	echo "	<td>".number_format($re_cnt)."</td>";
  	echo "	<td>".number_format($view_cnt)."</td>";
  	echo "	<td>".number_format($view_rate,"2",".",",")."</td>";
  	echo "</tr>";
  	
  	$t_view = $t_view + $view_cnt;
		$t_new = $t_new + $new_cnt;
		$t_re = $t_re + $re_cnt;
		$t_sum = $t_sum + $total_cnt;
		
		$a_per_view = $a_per_view + $view_rate;
		$t_num = $t_num + 1;
	}
}
else {
?>					
						<tr>
							<td class="first" colspan="6"><p style="color:red;">데이터 없음</p></td>
						</tr>
<?php 
}

if($t_num == 0 )	{
	$t_num = 1;
}
 ?>
		<!-- <tr>
				<td style="background-color:#D1FFC9; color:red">합계</td>
	        		<td style="background-color:#D1FFC9;color:red"><?php echo number_format($t_view); ?></td>
	        		<td style="background-color:#D1FFC9;color:red"><?php echo number_format($t_sum); ?></td>
	        		<td style="background-color:#D1FFC9;color:red"><?php echo number_format($t_new); ?></td>
	        		<td style="background-color:#D1FFC9;color:red"><?php echo number_format($t_re); ?></td>
	        		<td style="background-color:#D1FFC9;color:red"><?php echo number_format($a_per_view/$t_num,"2",".",","); ?></td>
	        	</tr> -->
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