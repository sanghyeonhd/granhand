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
<?
$sdate = $_GET['sdate'];
$edate = $_GET['edate'];
$thirddate = $_GET['thirddate'];
$vs_type = $_GET['type'];

if ($sdate == "" or $edate == "" or $thirddate == "") {
	$syear = date('Y');
	$smonth = date('m');
	$sday = date('d');
	$baseSec = mktime(0,0,0,$smonth, $sday, $syear);
	$addSec1 = 7 * 86400;
	$addSec2 = 14 * 86400;
	$firstSec = $baseSec - $addSec2;
	$secondSec = $baseSec - $addSec1;
	$sdate = date("Y-m-d", $firstSec);
	$edate = date("Y-m-d", $secondSec);
	$thirddate = date('Y-m-d');
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
				<h3><i class="fa fa-table"></i> 시간대별방문현황</h3>
			</div>
			<div class="panel-content">
				 <?php
          if ($vs_type == 'vs')
          {
          	$qry = "select 	ifnull(c.hour,0) as hour , 
														ifnull(c.new,0) as new1, 
														ifnull(d.new,0) as new2, 
														ifnull(e.new,0) as new3, 
														ifnull(c.re,0) as re1, 
														ifnull(d.re,0) as re2, 
														ifnull(e.re,0) as re3, 
														ifnull(c.view,0) as view1, 
														ifnull(d.view,0) as view2, 
														ifnull(e.view,0) as view3
												from
												(
													select a.hour, b.new, b.re, b.view
													  from 
												    (
												        SELECT hour from tb_hour
												    ) as a 
												    left outer join 
													(
														SELECT 	DATE_FORMAT(DATE, '%H') AS HOUR, SUM(NEW_CNT) AS NEW, SUM(RE_CNT) AS RE, SUM(VIEW_CNT) AS VIEW 
														  FROM tb_visit
													WHERE DATE >= '".$sdate."' 
												      AND DATE < DATE_FORMAT('".$sdate."' +INTERVAL 1 DAY,'%Y-%m-%d')
												      GROUP BY DATE_FORMAT(DATE, '%H') 
												    ) as b
												    on a.hour = b.hour
												) as c
												left outer join
												(
													select i.hour, j.new, j.re, j.view
													  from 
												    (
														SELECT hour from tb_hour
													) as i 
													left outer join 
													(
														SELECT 	DATE_FORMAT(DATE, '%H') AS HOUR, SUM(NEW_CNT) AS NEW, SUM(RE_CNT) AS RE, SUM(VIEW_CNT) AS VIEW 
														  FROM tb_visit
													WHERE DATE >= '".$edate."' 
													  AND DATE < DATE_FORMAT('".$edate."' +INTERVAL 1 DAY,'%Y-%m-%d')
												      GROUP BY DATE_FORMAT(DATE, '%H') 
													) as j
													on i.hour = j.hour
												) as d
												on c.hour = d.hour
												left outer join
												(
													select x.hour, y.new, y.re, y.view
													  from 
												    (
														SELECT hour from tb_hour
													) as x 
													left outer join 
													(
														SELECT 	DATE_FORMAT(DATE, '%H') AS HOUR, SUM(NEW_CNT) AS NEW, SUM(RE_CNT) AS RE, SUM(VIEW_CNT) AS VIEW 
														  FROM tb_visit
													WHERE DATE >= '".$thirddate."' 
													  AND DATE < DATE_FORMAT('".$thirddate."' +INTERVAL 1 DAY,'%Y-%m-%d')
												      GROUP BY DATE_FORMAT(DATE, '%H') 
													) as y
													on x.hour = y.hour
												) as e
												on d.hour = e.hour
												order by c.hour asc;";			  
          }
          else
          {
						$qry = "SELECT 	DATE_FORMAT(DATE, '%H') AS HOUR, 
														SUM(NEW_CNT) AS NEW, 
														SUM(RE_CNT) AS RE, 
														SUM(VIEW_CNT) AS VIEW 
										  FROM tb_visit
										 WHERE DATE >= '".$sdate."' 
										   AND DATE < DATE_FORMAT('".$edate."' +INTERVAL 1 DAY,'%Y-%m-%d')
									  GROUP BY DATE_FORMAT(DATE, '%H') 
									  ORDER BY HOUR";
						
						
					}	
					$result = mysql_query($qry) or die(mysql_error());			  
          ?>


<?php if ($vs_type == 'vs') { ?>

          <table class="table table-bordered">
          	<colgroup>
          		<col width="7%" />
          		<col width="7%" />
          		<col width="7%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="7%" />
          		<col width="7%" />
          		<col width="7%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="7%" />
          	</colgroup>
          	<thead>
          	<tr>
          		<th style="width:5%;" rowspan="2">시간대</th>
          		<th style="width:17%;" colspan="3">방문수</th>
          		<th style="width:17%;" colspan="3">신규방문수</th>
          		<th style="width:17%;" colspan="3">재방문수</th>
          		<th style="width:18%;" colspan="3">페이지뷰</th>
          		<th style="width:17%;" colspan="3">방문당페이지뷰</th>
          	</tr>
          	<tr>
          		<th><?php echo $sdate." (".date( 'D' , mktime(00,00,00,substr($sdate,5,2),substr($sdate,8,2),substr($sdate,0,4))).")"; ?></th>
          		<th><?php echo $edate." (".date( 'D' , mktime(00,00,00,substr($edate,5,2),substr($edate,8,2),substr($edate,0,4))).")"; ?></th>
          		<th><?php echo $thirddate." (".date( 'D' , mktime(00,00,00,substr($thirddate,5,2),substr($thirddate,8,2),substr($thirddate,0,4))).")"; ?></th>
          		<th><?php echo $sdate ?></th>
          		<th><?php echo $edate ?></th>
          		<th><?php echo $thirddate ?></th>
          		<th><?php echo $sdate ?></th>
          		<th><?php echo $edate ?></th>
          		<th><?php echo $thirddate ?></th>
          		<th><?php echo $sdate ?></th>
          		<th><?php echo $edate ?></th>
          		<th><?php echo $thirddate ?></th>
          		<th><?php echo $sdate ?></th>
          		<th><?php echo $edate ?></th>
          		<th><?php echo $thirddate ?></th>
          	</tr>
          	</head>
          	<tbody>
          <?php } else { ?>
 
          <table class="table table-bordered">
          	<colgroup>
          		<col width="7%" />
          		<col width="7%" />
          		<col width="7%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="7%" />
          		<col width="7%" />
          		<col width="7%" />
          		<col width="6%" />
          		<col width="6%" />
          		<col width="7%" />
          	</colgroup>
          	<thead>
          	<tr>
          		<th style="width:19%;">시간대</th>
          		<th style="width:16%;">방문수</th>
          		<th style="width:16%;">신규방문수</th>
          		<th style="width:16%;">재방문수</th>
          		<th style="width:17%;">페이지뷰</th>
          		<th style="width:16%;">방문당페이지뷰</th>
          	</tr>
          	
<?php
}
$row = mysql_num_rows($result);

$t_view1 = 0;
$t_new1 = 0;
$t_re1 = 0;
$t_sum1 = 0;
$a_per_view1 = 0;
$t_num1 = 0;

$t_view2 = 0;
$t_new2 = 0;
$t_re2 = 0;
$t_sum2 = 0;
$a_per_view2 = 0;
$t_num2 = 0;

$t_view3 = 0;
$t_new3 = 0;
$t_re3 = 0;
$t_sum3 = 0;
$a_per_view3 = 0;
$t_num3 = 0;


while( $data = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$hour 			= $data["hour"];
	
	$new_cnt1 	= $data["new1"];
	$re_cnt1 		= $data["re1"];
	$view_cnt1  = $data["view1"];
	
	$new_cnt2 	= $data["new2"];
	$re_cnt2 		= $data["re2"];
	$view_cnt2  = $data["view2"];
	
	$new_cnt3 	= $data["new3"];
	$re_cnt3 		= $data["re3"];
	$view_cnt3  = $data["view3"];
	
	$total_cnt1  = $new_cnt1 + $re_cnt1;
	$total_cnt2  = $new_cnt2 + $re_cnt2;
	$total_cnt3  = $new_cnt3 + $re_cnt3;
	
	if ($total_cnt1 != 0) {
		$view_rate1  = $view_cnt1 / $total_cnt1;
	}
	else {
		$view_rate1  = "0.00";
	}
	
	if ($total_cnt2 != 0) {
		$view_rate2  = $view_cnt2 / $total_cnt2;
	}
	else {
		$view_rate2  = "0.00";
	}
	
	if ($total_cnt3 != 0) {
		$view_rate3  = $view_cnt3 / $total_cnt3;
	}
	else {
		$view_rate3  = "0.00";
	}
          	
	echo "<tr>";
	echo "	<td class='first'>".$hour."시</td>";
	echo "	<td style='background-color:#EEB4E9'>".number_format($total_cnt1)."</td>";
	echo "	<td style='background-color:#EEB4E9'>".number_format($total_cnt2)."</td>";
	echo "	<td style='background-color:#EEB4E9'>".number_format($total_cnt3)."</td>";
	echo "	<td>".number_format($new_cnt1)."</td>";
	echo "	<td>".number_format($new_cnt2)."</td>";
	echo "	<td>".number_format($new_cnt3)."</td>";
	echo "	<td>".number_format($re_cnt1)."</td>";
	echo "	<td>".number_format($re_cnt2)."</td>";
	echo "	<td>".number_format($re_cnt3)."</td>";
	echo "	<td>".number_format($view_cnt1)."</td>";
	echo "	<td>".number_format($view_cnt2)."</td>";
	echo "	<td>".number_format($view_cnt3)."</td>";
	echo "	<td>".number_format($view_rate1,"2",".",",")."</td>";
	echo "	<td>".number_format($view_rate2,"2",".",",")."</td>";
	echo "	<td>".number_format($view_rate3,"3",".",",")."</td>";
	echo "</tr>";
	
	$t_sum1 = $t_sum1 + $total_cnt1;
	$t_new1 = $t_new1 + $new_cnt1;
	$t_re1 = $t_re1 + $re_cnt1;
	$t_view1 = $t_view1 + $view_cnt1;
		
	$a_per_view1 = $a_per_view1 + $view_rate1;
	$t_num1 = $t_num1 + 1;
		
	$t_view2 = $t_view2 + $view_cnt2;
	$t_new2 = $t_new2 + $new_cnt2;
	$t_re2 = $t_re2 + $re_cnt2;
	$t_sum2 = $t_sum2 + $total_cnt2;
	
	$a_per_view2 = $a_per_view2 + $view_rate2;
	$t_num2 = $t_num2 + 1;
	
	$t_view3 = $t_view3 + $view_cnt3;
	$t_new3 = $t_new3 + $new_cnt3;
	$t_re3 = $t_re3 + $re_cnt3;
	$t_sum3 = $t_sum3 + $total_cnt3;
	
	$a_per_view3 = $a_per_view3 + $view_rate3;
	$t_num3 = $t_num3 + 1;
}
 
if($t_num1 == 0 )	{
	$t_num1 = 1;
}

if($t_num2 == 0 )	{
	$t_num2 = 1;
}

if($t_num3 == 0 )	{
	$t_num3 = 1;
}

?>
		</thead>
		<tbody>
			<tr class="total_yellow">
				<td class="first">합계</td>
	        		<td><?php echo number_format($t_sum1); ?></td>
	        		<td><?php echo number_format($t_sum2); ?></td>
	        		<td><?php echo number_format($t_sum3); ?></td>
	        		<td><?php echo number_format($t_new1); ?></td>
	        		<td><?php echo number_format($t_new2); ?></td>
	        		<td><?php echo number_format($t_new3); ?></td>
	        		<td><?php echo number_format($t_re1); ?></td>
	        		<td><?php echo number_format($t_re2); ?></td>
	        		<td><?php echo number_format($t_re3); ?></td>
	        		<td><?php echo number_format($t_view1); ?></td>
	        		<td><?php echo number_format($t_view2); ?></td>
	        		<td><?php echo number_format($t_view3); ?></td>
	        		<td><?php echo number_format($a_per_view1/$t_num1,"2",".",","); ?></td>
	        		<td><?php echo number_format($a_per_view2/$t_num2,"2",".",","); ?></td>
	        		<td><?php echo number_format($a_per_view3/$t_num3,"2",".",","); ?></td>
	        	</tr>
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