<?php
//ini_set("display_errors", 1);
require_once "../inc/config_default.php";
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config.php";
include "adminaccess.php";
include "adminhead.php"; 
include "side_menu.php";
include "admintop.php";
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<?
$g_ar_wdate= array('<font color=red>일</font>','월','화','수','목','금','<font color=blue>토</font>');
?>
<style>
.flex	{	display:flex;	}
.items-center	{align-items:center;	}
.justify-between	{	justify-content:space-between;	}
.mb-4	{	margin-bottom:26px;	}
.space-x-2	{	margin-right:40px;	}
.text-sm	{	font-size:12px;color:#5E5955;font-weight:500	}
.text-red-600	{	color:#FF3E24 !important;	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-content">
				<div class="flex justify-between items-center mb-4">
					<h2 class="font-semibold" style="font-size:14px;color:#5E5955;font-weight:bold;">오늘의 할일</h2>
					<div class="text-gray-500 text-sm" style="font-size:12px;color:#C0BCB6;font-weight:500">2025. 06. 27. (금)</div>
				</div>
				<section class="flex justify-between items-center  rounded-lg p-4 pl-0">
					<div class="flex items-center space-x-6">
						<div class="flex items-center space-x-2">
							<span class="text-gray-700 text-sm">신규 주문</span>
							<span class="text-red-600 text-sm">0</span>
						</div>
						<div class="flex items-center space-x-2">
							<span class="text-gray-700 text-sm">취소 관리</span>
							<span class="text-red-600 text-sm">0</span>
						</div>
						<div class="flex items-center space-x-2">
							<span class="text-gray-700 text-sm">반품 관리</span>
							<span class="text-red-600 text-sm">0</span>
						</div>
						<div class="flex items-center space-x-2">
							<span class="text-gray-700 text-sm">교환 관리</span>
							<span class="text-red-600 text-sm">0</span>
						</div>
						<div class="flex items-center space-x-2">
							<span class="text-gray-700 text-sm">답변대기 문의</span>
							<span class="text-red-600 text-sm">0</span>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
<div class="row" style="display:none;">
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-green">
			<div class="stats-icon"><i class="fa fa-desktop"></i></div>
			<div class="stats-info">
				<h4>금일가입회원</h4>
				<p>
				<?php 
				$q = "Select idx from shop_member where LEFT(signdate,10)='".date("Y-m-d")."'";
				$st = $pdo->prepare($q);
				$st->execute();
				echo $st->rowCount();
				?>
				</p>	
			</div>
			<div class="stats-link">
				<a href="subpage?code=help_list&sdate=<?=date("Y-m-d");?>">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-blue">
			<div class="stats-icon"><i class="fa fa-desktop"></i></div>
			<div class="stats-info">
				<h4>미답변질문</h4>
				<p>
				<?php 
				$q = "Select idx from shop_qna where result='N' and isdel='N'";
				$st = $pdo->prepare($q);
				$st->execute();
				echo $st->rowCount();
				?>
				</p>
			</div>
			<div class="stats-link">
				<a href="subpage?code=help_qna&isanswer=N">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-purple">
			<div class="stats-icon"><i class="fa fa-desktop"></i></div>
			<div class="stats-info">
				<h4>금일등록후기</h4>
				<p>
				<?php 
				$q = "Select idx from shop_after where isdel='N' and LEFT(wdate,10)='".date("Y-m-d")."'";
				$st = $pdo->prepare($q);
				$st->execute();
				echo $st->rowCount();
				?>	
				</p>
			</div>
			<div class="stats-link">
				<a href="subpage?code=sho_after">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-md-3 col-sm-6">
		<div class="widget widget-stats bg-red">
			<div class="stats-icon"><i class="fa fa-desktop"></i></div>
			<div class="stats-info">
				<h4>전체회원수</h4>
				<p>
				<?php 
				$q = "Select idx from shop_member where id!='outmember'";
				$st = $pdo->prepare($q);
				$st->execute();
				echo $st->rowCount();
				?>
				</p>
			</div>
			<div class="stats-link">
				<a href="subpage?code=help_list">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 매출현황</h3>
			</div>
			<div class="panel-content">
				<ul class="nav nav-tabs nav-primary">
					<?php
					for($i=0;$i<sizeof($g_curr);$i++)	{
					?>
					<li <?php if($i==0)	{?>class="active"<?}?>><a href="#tab1_<?=($i+1);?>" data-toggle="tab" aria-expanded="true"><?=$g_curr[$i]['name'];?></a></li>
					<?}?>
				</ul>
				
				<div class="tab-content">
					<?php
					for($ik=0;$ik<sizeof($g_curr);$ik++)	{
					?>
					<div class="tab-pane fade <?php if($ik==0)	{?>active in<?}?>" id="tab1_<?=($ik+1);?>">
						<div class="row">

							<div class="col-md-6">
								<div id="chartdiv1_<?=($ik+1);?>" style="width:100%;min-height:350px;"></div>
							</div>
							<div class="col-md-6">
								<table class="table table-bordered">
								<thead>
								<tr >
									<th>일자</th>
									<th>주문건수</th>
									<th>매출</th>
									<th>환불</th>
									<th>순매출</th>
								</tr>
								<tbody>
								<?
								
								for($i=7;$i>=0;$i--)	{
									if($i!=0)	{
										$date = date('Y-m-d', strtotime('-'.$i.' days'));
									}
									else	{
										$date = date("Y-m-d");
									}
							
							

									$q = "select shop_newmarketdb_accounts.* from shop_newmarketdb_accounts INNER JOIN shop_newmarketdb ON shop_newmarketdb.idx=shop_newmarketdb_accounts.market_idx where shop_newmarketdb_accounts.incdate='$date' and trs='".$g_curr[$ik]['name']."'";
									$st = $pdo->prepare($q);
									$st->execute();
									$account = 0;
									$oaccount = 0;
									while($row = $st->fetch())	{
										if($row['tbtype']=='I')	{
											$account = $account + $row['account']/100;	
										}		
										if($row['tbtype']=='O')	{
											$oaccount = $oaccount + $row['account']/100;	
										}
									}

									$q = "select * from shop_newmarketdb where dan!='' and LEFT(odate,10)='$date' AND trs='".$g_curr[$ik]['name']."'";
									$st = $pdo->prepare($q);
									$st->execute();
									$give_totala = $st->rowCount();
							
									if($i==7)	{
										$gr_x1[$ik] = "'".substr($date,5,5)."'";
										$m_data1[$ik] = $give_totala;
										$m_data2[$ik] = $account;
										$m_data3[$ik] = $oaccount;
										$m_data4[$ik] = ($account-$oaccount);
									}
									else	{
										$gr_x1[$ik] = $gr_x1[$ik].",'".substr($date,5,5)."'";
										$m_data1[$ik] = $m_data1[$ik].",".$give_totala;
										$m_data2[$ik] = $m_data2[$ik].",".$account;
										$m_data3[$ik] = $m_data3[$ik].",".$oaccount;
										$m_data4[$ik] = $m_data4[$ik].",".($account-$oaccount);
									}
								?>
								<tr>
									<td><?=$date?>(<?=$g_ar_wdate[date('w',strtotime($date))]?>)</td>
									<td><?=number_format($give_totala)?>건</td>
									<td><?=$g_curr[$ik]['showdan1'];?><?=number_format($account);?><?=$g_curr[$ik]['showdan2'];?></td>
									<td><?=$g_curr[$ik]['showdan1'];?><?=number_format($oaccount);?><?=$g_curr[$ik]['showdan2'];?></td>
									<td <? if( ($account-$oaccount) >0 ) { echo "style='color:red;'"; } else { echo "style='color:blue;'"; }?>><?=$g_curr[$ik]['showdan1'];?><?=number_format($account-$oaccount);?><?=$g_curr[$ik]['showdan2'];?></td>
								</tr>
								<?}?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 방문자현황</h3>
			</div>
			<div class="panel-content">
				<ul class="nav nav-tabs nav-primary">
					<?php
					$q = "Select idx,site_name from shop_config ORDER BY idx ASC";
					$st = $pdo->prepare($q);
					$st->execute();
					$cou = 0;
					while($row = $st->fetch())	{
						$ar_stat[$cou] = $row['idx'];
					?>
					<li <?php if($cou==0)	{?>class="active"<?}?>><a href="#tab2_<?=($cou+1);?>" data-toggle="tab" aria-expanded="true"><?=$row['site_name'];?></a></li>
					<?
						$cou++;
					}
					$logstr = 1;
					?>
				</ul>
				<div class="tab-content">
					<?php
					for($ik=0;$ik<sizeof($ar_stat);$ik++)	{
					?>
					<div class="tab-pane fade <?php if($ik==0)	{?>active in<?}?>" id="tab2_<?=($ik+1);?>">
				
				
						<div class="row">
							<div class="col-md-12">
								<div id="chartdiv2_<?=$ik+1;?>" style="width:100%;min-height:350px;"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered">
								<thead>
								<tr >
									<th>일자</th>
									<th>총방문자</th>
									<th>유니크방문자</th>
									<th>총페이지뷰</th>
									<th>평균페이지뷰</th>
									<th>반송율</th>
									<th>체류시간평균</th>
								</tr>
								<tbody>


								
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 배송현황</h3>
			</div>
			<div class="panel-content">
				<div class="row">
					<div class="col-md-12">
						<div id="chartdels" style="width:100%;min-height:350px;"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered">
						<thead>
						<tr >
							<th>일자</th>
							<th>발송상품수</th>
							<th>처리송장수</th>
						</tr>
						<tbody>
						<?php
						$date = date('Y-m-d', strtotime('-9 days')).",".date("Y-m-d");
						for($i=9;$i>=0;$i--)	{

							$cout1 = 0;
							$cout2 = 0;

							if($i!=0)	{
								$date = date('Y-m-d', strtotime('-'.$i.' days'));
							}
							else	{
								$date = date("Y-m-d");
							}

							$q = "select distinct(gonumber) from shop_newbasket where LEFT(godate,10)='$date' AND gonumber!=''";
							$st = $pdo->prepare($q);
							$st->execute();
							$cout2 = $st->rowCount();

							$q = "select sum(ea) from shop_newbasket where LEFT(godate,10)='$date' AND gonumber!=''";
							$st = $pdo->prepare($q);
							$st->execute();
							$row = $st->fetch();

							
							if($row[0])	{
								$cout1 = $row[0];
							}


							if($i==9)	{
								$gr_x3 = "'".substr($date,5,5)."'";
								$gr3_data1 = $cout1;
								$gr3_data2 = $cout2;
								
							}
							else	{
								$gr_x3 = $gr_x3.",'".substr($date,5,5)."'";
								$gr3_data1 = $gr3_data1.",".$cout1;
								$gr3_data2 = $gr3_data2.",".$cout2;
								
							}
						?>
						<tr>
							<td><?=$date;?></td>
							<td><?=number_format($cout1);?></td>
							<td><?=number_format($cout2);?></td>
						</tr>
						<?
						}
						?>
						</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<Script>
<?php
for($ik=0;$ik<sizeof($g_curr);$ik++)	{
?>
Highcharts.chart('chartdiv1_<?=($ik+1);?>', {
    chart: {
        zoomType: 'xy',
		backgroundColor: 'transparent'
    },
    title: {
        text: '최근 매출 추이'
    },
	colors: [  "#52c1df", "#c75757","#18a689","#ff9900"],
    xAxis: [{
        categories: [<?=$gr_x1[$ik];?>],
        crosshair: true
    }],
    yAxis: [{ 
        labels: {
            format: "<?=$g_curr[$ik]['showdan1'];?>{value}<?=$g_curr[$ik]['showdan2'];?>"
        },
        title: {
            text: ''
        },
        opposite: true

    }, { 
        gridLineWidth: 0,
        title: {
            text: ''
        },
        labels: {
            format: '{value} 건'
        }

    }],
    tooltip: {
        shared: true
    },
    
    series: [{
        name: '총주문건',
        type: 'column',
        yAxis: 1,
        data: [<?=$m_data1[$ik];?>],
        tooltip: {
            valueSuffix: ' 건'
        }

    }, {
        name: '총매출',
        type: 'spline',
        data: [<?=$m_data2[$ik];?>],
        marker: {
            enabled: false
        },
        dashStyle: 'shortdot',
        tooltip: {
            valueSuffix: ''
        }

    }, {
        name: '총환불',
        type: 'spline',
        data: [<?=$m_data3[$ik];?>],
        tooltip: {
            valueSuffix: ''
		}
	}, {
        name: '순매출',
        type: 'spline',
        data: [<?=$m_data4[$ik];?>],
        tooltip: {
            valueSuffix: ''
		}
	}]
});
<?}?>
</script>
<script>
<?php
for($ik=0;$ik<sizeof($ar_stat);$ik++)	{
?>
Highcharts.chart('chartdiv2_<?=($ik+1);?>', {
	chart: {
		backgroundColor: 'transparent'
	},
    title: {
        text: '최근방문자현황'
    },
    xAxis: {
        categories: [<?=$strstd[$ik];?>]
    },
	colors: [  "#52c1df","#18a689", "#c75757","#ff9900"],
    yAxis: [{ 
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[3]
            }
        },
        title: {
            text: '',
            style: {
                color: Highcharts.getOptions().colors[3]
            }
        },
        opposite: true

    }, { 
        gridLineWidth: 0,
        title: {
            text: '',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value}',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        }

    }],
    series: [{
		yAxis: 1,
        type: 'column',
        name: '총방문자',
        data: [<?=$str1[$ik];?>]
    }, {
		yAxis: 1,
        type: 'column',
        name: '유니크방문자',
        data: [<?=$str2[$ik];?>]
    }, {
        type: 'spline',
        name: '평균페이지뷰',
        data: [<?=$str3[$ik];?>],
		style: {
               color: Highcharts.getOptions().colors[3]
        }
    }]
});
<?}?>
</script>
<Script>
Highcharts.chart('chartdels', {
    chart: {
        zoomType: 'xy',
		backgroundColor: 'transparent'
    },
    title: {
        text: ''
    },
	colors: [  "#52c1df", "#c75757","#18a689","#ff9900"],
    xAxis: [{
        categories: [<?=$gr_x3;?>],
        crosshair: true
    }],
    yAxis: [{ 
        labels: {
            format: "{value}"
        },
        title: {
            text: ''
        },
        opposite: true

    }],
    tooltip: {
        shared: true
    },
    
    series: [{
       name: '배송상품수',
        type: 'spline',
        data: [<?=$gr3_data1;?>],
        marker: {
            enabled: false
        }

    }, {
        name: '처리송장수',
        type: 'spline',
        data: [<?=$gr3_data2;?>],
        marker: {
            enabled: false
        }

    }]
});
</script>

<?php
include "adminfoot.php";
?>