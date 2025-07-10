<?php
$g_ar_wdate= array('<font color=red>일</font>','월','화','수','목','금','<font color=blue>토</font>');

?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 전체방문자수</h3>
			</div>
			<div class="panel-content">
				<ul class="nav nav-tabs nav-primary">
					<?php
					for($ik=0;$ik<sizeof($g_ar_pid);$ik++)	{
					?>
					<li <?php if($ik==0)	{?>class="active"<?}?>><a href="#tab2_<?=($ik+1);?>" data-toggle="tab" aria-expanded="true"><?=$g_ar_pid[$ik]['site_name'];?></a></li>
					<?
					}
					?>
				</ul>
				<div class="tab-content">
					<?php
					for($ik=0;$ik<sizeof($g_ar_pid);$ik++)	{
					?>
					<div class="tab-pane fade <?php if($ik==0)	{?>active in<?}?>" id="tab2_<?=($ik+1);?>">
				
				
						<div class="row">
							<div class="col-md-6">
								<div id="chartdiv2_<?=$ik+1;?>" style="width:100%;min-height:350px;"></div>
							</div>
							<div class="col-md-6">
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


								<?
								$date = date('Y-m-d', strtotime('-7 days')).",".date("Y-m-d");



								$ch = curl_init();  
								curl_setopt($ch,CURLOPT_URL,$_logtarget."?module=API&method=VisitsSummary.get&idSite=".$g_ar_pid[$ik]['idx']."&date=".$date."&period=day&format=json&token_auth=".$_logtoken);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
								curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
								curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
								$output=curl_exec($ch);
								curl_close($ch);
							
								$json = json_decode($output);
								
								$i = 7;
								foreach($json AS $k => $v)	{
									if($i!=7)	{
										$strstd[$ik] = $strstd[$ik].",";
										$str1[$ik] = $str1[$ik].",";
										$str2[$ik] = $str2[$ik].",";
										$str3[$ik] = $str3[$ik].",";
									}
										
									$strstd[$ik] .= "'".$k."'";
									if($v->nb_visits)	{
										$str1[$ik] .= $v->nb_visits;
									}
									else	{
										$str1[$ik] .= 0;
									}
									if($v->nb_uniq_visitors)	{
										$str2[$ik] .= $v->nb_uniq_visitors;
									}
									else	{
										$str2[$ik] .= 0;
									}

									if($v->nb_actions_per_visit)	{
										$str3[$ik] .= $v->nb_actions_per_visit;
									}
									else	{
										$str3[$ik] .= 0;
									}
									
									
									
									$i--;
								?>
								<tr>
									<td><?=$k?>(<?=$g_ar_wdate[date('w',strtotime($k))]?>)</td>
									<td><?=number_format($v->nb_visits);?></td>
									<td><?=number_format($v->nb_uniq_visitors);?></td>
									<td><?=number_format($v->nb_actions);?></td>
									<td><?=number_format($v->nb_actions_per_visit,1);?></td>
									<td><?=number_format($v->bounce_rate);?></td>
									<td><?=number_format($v->avg_time_on_site);?>초</td>
								</tr>
								<?
								}
								
								?>
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
<script>
<?php
for($ik=0;$ik<sizeof($g_ar_pid);$ik++)	{
?>
Highcharts.chart('chartdiv2_<?=($ik+1);?>', {
    title: {
        text: ''
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

<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 주문통계</h3>
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
						
						for($i=6;$i>=0;$i--)	{
							if($i!=0)	{
								$date = date('Y-m-d', strtotime('-'.$i.' days'));
							}
							else	{
										$date = date("Y-m-d");
							}

							$q = "select idx,account from shop_newmarketdb where LEFT(odate,10)='$date' and trs='".$g_curr[$ik]['name']."' and dan!=''";
							$st = $pdo->prepare($q);
							$st->execute();
							$account = 0;
							$ocou = 0;
							while($row = $st->fetch())	{
								$account = $account + $row['account']/100;
								$ocou++;
							}
							if($i==6)	{
								$gr_x1[$ik] = "'".$date."'";
								$m_data1[$ik] = $account;
								$m_data2[$ik] = $ocou;
							}
							else	{
								$gr_x1[$ik] = $gr_x1[$ik].",'".$date."'";
								$m_data1[$ik] = $m_data1[$ik].",".$account;
								$m_data2[$ik] = $m_data2[$ik].",".$ocou;
							}
						}
					?>
					<div class="tab-pane fade <?php if($ik==0)	{?>active in<?}?>" id="tab1_<?=($ik+1);?>">
						<div id="chart3_<?=($ik+1);?>" style="width:100%;height:345px;"></div>
<Script>
Highcharts.chart('chart3_<?=($ik+1);?>', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: ''
    },
	colors: ["#52c1df","#ff9900"],
    xAxis: [{
        categories: [<?=$gr_x1[$ik];?>],
        crosshair: true
    }],
    yAxis: [{ 
        labels: {
            format: "<?=$g_curr[$ik]['showdan1'];?>{value:,.1f}<?=$g_curr[$ik]['showdan2'];?>"
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
            format: '{value:,.1f}'
        }

    }],
    tooltip: {
        shared: true
    },
    
    series: [{
        name: '총주문금액',
        type: 'column',
        data: [<?=$m_data1[$ik];?>],
        marker: {
            enabled: false
        },
        dashStyle: 'shortdot',
        tooltip: {
            valueSuffix: ''
        }

    },{
        name: '총주문건',
        type: 'spline',
        yAxis: 1,
        data: [<?=$m_data2[$ik];?>],
        tooltip: {
            valueSuffix: ' 건'
        }

    }]
});

</script>						
					</div>

					<?}?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품별 주문수량 분석(최근3일)</h3>
			</div>
			<div class="panel-content">
				<ul class="nav nav-tabs nav-primary">
					<?php
					for($ik=0;$ik<sizeof($g_ar_pid);$ik++)	{
					?>
					<li <?php if($ik==0)	{?>class="active"<?}?>><a href="#tab3_<?=($ik+1);?>" data-toggle="tab" aria-expanded="true"><?=$g_ar_pid[$ik]['site_name'];?></a></li>
					<?
					}
					?>
				</ul>
				<div class="tab-content">
					<?php
					for($ik=0;$ik<sizeof($g_ar_pid);$ik++)	{

					?>
					<div class="tab-pane fade <?php if($ik==0)	{?>active in<?}?>" id="tab3_<?=($ik+1);?>">
						<div class="row">
							<div id="chart4_<?=($ik+1);?>" class='col-md-6' style='height:345px;'></div>
<?php
$q = "select sum(ea) from shop_crm_selling where pid='".$g_ar_pid[$ik]['idx']."' AND odate BETWEEN '".date("Y-m-d",time()-86400*3)." 00:00:00' AND '".date("Y-m-d H:i:s")."'";
$st = $pdo->prepare($q);
$st->execute();
$row = $st->fetch();
$alltotal = $row[0];
$total = $row[0];

$q = "select sum(ea) as ks,goods_idx from shop_crm_selling where pid='".$g_ar_pid[$ik]['idx']."' AND odate BETWEEN '".date("Y-m-d",time()-86400*3)." 00:00:00' AND '".date("Y-m-d H:i:s")."'";
$q = $q . " group by goods_idx order by ks desc limit 0,10";
$st = $pdo->prepare($q);
$st->execute();
$cou = 0;
$pertotal = 0;
unset($ar_gname);
unset($ar_gidx);
unset($ar_cts);
$ar_gname = [];
$ar_gidx = [];
$ar_cts = [];
while($row = $st->fetch())	{
	$ar_goods = sel_query("shop_goods","gname"," where idx='$row[goods_idx]'");
	$ar_gname[$cou] = strip_tags($ar_goods['gname']);
	$ar_gidx[$cou] = $row['goods_idx'];
	$ar_cts[$cou] = $row['ks'];
	$total = $total - $row['ks'];

	$pertotal = $pertotal + $row['ks'];
	
	if($cou==0)	{
		$datas = "{name: '".strip_tags($ar_goods['gname'])."',y: ".round($row[ks]/$alltotal*100,2)."}";
	}
	else	{
		$datas = $datas . ","."{name: '".strip_tags($ar_goods['gname'])."',y: ".round($row[ks]/$alltotal*100,2)."}";
	}
	
	$cou++;
}
if($cou==0)	{
	if($alltotal == 0)	{
		$alltotal = 1;	
	}
	$datas = "{name: '판매없음',y: ".round(100 - ($pertotal/$alltotal*100),2)."}";
}
else	{
	$datas = $datas . ","."{name: '기타상품',y: ".round(100 - ($pertotal/$alltotal*100),2)."}";
}
?>
<script>
Highcharts.chart('chart4_<?=($ik+1);?>', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
	colors: ["#ff225a", "#6713e8",  "#22a6ff", "#13e864", "#d9ff24", "#a70bd9", "#e8e021", "#ff5452", "#bf1c83", "#2b1ab5", "#1aadb5"],
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
         pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: false
        }
    },
    series: [{
        name: '상품비중',
        colorByPoint: true,
        data: [<?=$datas;?>]
    }]
});
</script>
							<div class='col-md-6'>
								<ul style='padding-top:10px;'>
									<?
									for($i=0;$i<sizeof($ar_gname);$i++)	{
									?>
									<li style='padding:3px 0 3px 0;'><?=$i+1;?>위. [<?if($alltotal!=0) { echo round($ar_cts[$i]/$alltotal*100,2);	}	?>%] <a href="javascript:MM_openBrWindow('./frame_data/stat_goods.php?goods_idx=<?=$ar_gidx[$i];?>','stat','width=1000,height=700,scrollbars=yes');"><?=$ar_gname[$i];?></a></li>
									<?}?>
									<li>상위 10위의 총 비중 <? if($alltotal!=0) { echo round(($alltotal-$total)/$alltotal*100,2);	}	?>%</li>
								</ul>
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
				<h3><i class="fa fa-table"></i> 회원가입현황</h3>
			</div>
			<div class="panel-content">
				
				<div id="chart5" style="width:100%;height:260px;margin-left:5px;"></div>

			<?
			for($i=6;$i>=0;$i--)	{
				$ar_cous[$i] = 0;
				$std_date = date("Y-m-d",time()-86400*$i);

				$q = "select count(idx) from  shop_member where signdate BETWEEN '$std_date 00:00:00' AND '$std_date 23:59:59'";
				$st = $pdo->prepare($q);
				$st->execute();
				$row = $st->fetch();
				
				if($row[0])	{
					$ar_cous[$i] = $row[0];
				}
			}
			$str1 = "";
			$str2 = "";
			$max = 0;
			for($i=6;$i>=0;$i--)	{
				$std_date = date("Y-m-d",time()-86400*$i);
				if($i!=6)	{
					$str1 = $str1 .",";	
					$str2 = $str2 .",";		
				}
				
				if($max<$ar_cous[$i])	{
					$max = $ar_cous[$i];	
				}
				$str1 = $str1 . $ar_cous[$i];
				$str2 = $str2 . "'$std_date'";
				
			}
			?>
			</div>
		</div>
	</div>
<script>
Highcharts.chart('chart5', {

    title: {
        text: ''
    },
	xAxis: {
        categories: [<?=$str2;?>]
    },
    
    yAxis: {
        title: {
            text: '가입자수'
        }
    },
    series: [{
        name: '가입자수',
        data: [<?=$str1;?>]
    }]
});
</script>
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 주문상품수량통계</h3>
			</div>
			<div class="panel-content">

			<?
			for($i=6;$i>=0;$i--)	{
				$ar_cous[$i] = 0;
				$std_date = date("Y-m-d",time()-86400*$i);
				
				$q = "select sum(ea) from shop_newbasket,shop_newmarketdb where shop_newmarketdb.odate BETWEEN '$std_date 00:00:00' and '$std_date 23:59:59' and dan NOT IN ('') and shop_newbasket.market_idx=shop_newmarketdb.idx";
				$st = $pdo->prepare($q);
				$st->execute();
				$row = $st->fetch();

				$ar_cous[$i] = $row[0];
			}
			$str1 = "";
			$str2 = "";
			for($i=6;$i>=0;$i--)	{
				$std_date = date("Y-m-d",time()-86400*$i);
				if($i!=6)	{
					$str1 = $str1 .",";	
					$str2 = $str2 .",";		
				}
				
				
				if($ar_cous[$i])	{
					$str1 = $str1 . $ar_cous[$i];	
				}
				else	{
					$str1 = $str1 . "0";	
				}
				$str2 = $str2 . "'$std_date'";
				
			}
			?>
			
				<div id="chart6" style="width:100%;height:260px;margin-left:5px;"></div>
				
			</div>		
		</div>
	</div>
</div>
<script>
Highcharts.chart('chart6', {

    title: {
        text: ''
    },
	xAxis: {
        categories: [<?=$str2;?>]
    },
    
    yAxis: {
        title: {
            text: '주문상품갯수'
        }
    },
    series: [{
        name: '주문상품갯수',
        data: [<?=$str1;?>]
    }]
});
</script>
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 입금율</h3>
			</div>
			<div class="panel-content">

			<?
			for($i=6;$i>=0;$i--)	{
				$std_date = date("Y-m-d",time()-86400*$i);
				$ar_cous1[$i] = 0;
				
				$q = "select count(idx) from shop_newmarketdb where odate BETWEEN '$std_date 00:00:00' AND '$std_date 23:59:59' and dan NOT IN ('')";
				$st = $pdo->prepare($q);
				$st->execute();
				$row = $st->fetch();

				$ar_cous1[$i] = round($row[0]);
				
				$q = "select count(idx) from shop_newmarketdb where LEFT(odate,10)='$std_date' and incdate!='0000-00-00 00:00:00'";
				$st = $pdo->prepare($q);
				$st->execute();
				$row = $st->fetch();

				$ar_cous2[$i] = round($row[0]);
			}
			
			?>
			<div style='background-color:#FFFFFF;'  class="row">
				<div id="chart7" style="height:290px;" class='col-md-9'></div>
				<div class='col-md-3'>
					<ul style='padding-top:10px;'>
			<?
			$str1 = "";
			$str2 = "";
			$str3 = "";
			for($i=6;$i>=0;$i--)	{
				$std_date = date("m-d",time()-86400*$i);
				if($i!=6)	{
					$str1 = $str1 .",";	
					$str2 = $str2 .",";		
					$str3 = $str3 .",";		
				}
				
				$str1 = $str1 . $ar_cous1[$i];
				$str2 = $str2 . $ar_cous2[$i];
				$str3 = $str3 . "'$std_date'";
			?>
			<li style='padding:3px 0 3px 0;'>[<?=$std_date;?>] <? if($ar_cous1[$i]){ echo round($ar_cous2[$i]/$ar_cous1[$i]*100,2);	} else { echo "0";	}	?>%</li>
			<?
			}
			?>
					</ul>
				</div>
				
			</div>

			</div>
		</div>
	</div>
<Script>
Highcharts.chart('chart7', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [<?=$str3;?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: '{value}건'
        }
    },

    series: [{
        name: '주문건',
        data: [<?=$str1;?>]

    }, {
        name: '입금확인건',
        data: [<?=$str2;?>]

    }]
});
</script>
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원 주문비중 (최근3일)</h3>
			</div>
			<div class="panel-content">

			<?
			$std_date = date("Y-m-d H:i:s",time()-86400*3);

			$q = "select count(idx) from shop_newmarketdb where odate BETWEEN '$std_date' AND '".date("Y-m-d H:i:s")."' and dan NOT in ('')";
			$st = $pdo->prepare($q);
			$st->execute();
			$row = $st->fetch();
			$alltotal = $row[0];
			if($alltotal == 0)	{
				$alltotal = 1;
			}

			$q = "select count(idx) from shop_newmarketdb where odate BETWEEN '$std_date' AND '".date("Y-m-d H:i:s")."' and mem_idx='0' and dan NOT in ('')";
			$st = $pdo->prepare($q);
			$st->execute();
			$row = $st->fetch();
			
			$nomember = $row[0];
			$member = $alltotal - $nomember;

			$datas = "{name: '회원주문비중',y: ".round($member/$alltotal*100,2)."},{name: '소셜회원주문비중',y: ".round($nomember/$alltotal*100,2)."}";
			?>
			<div style='background-color:#FFFFFF;'  class="row">
				<div id="chart8" class='col-md-6' style='height:290px;'></div>
				<div class='col-md-6'>
					<ul style='padding-top:10px;'>
						<li>총주문건 : <?=$alltotal;?>건</li>
						<li>회원주문 : <?=$member;?>건 (<? if($alltotal!=0) { echo round($member/$alltotal*100,2);	}	?>%)</li>
						<li>비회원주문 : <?=$nomember;?>건 (<? if($alltotal!=0) { echo round($nomember/$alltotal*100,2);	}	?>%)</li>
					</ul>
					
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<script>
Highcharts.chart('chart8', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
         pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: false
        }
    },
    series: [{
        name: '회원비중',
        colorByPoint: true,
        data: [<?=$datas;?>]
    }]
});
</script>