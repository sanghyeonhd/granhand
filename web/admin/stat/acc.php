<?php
if(!$se_sdate)	{
	$se_sdate = date("Y-m-d",time()-86400*2);	
}
if(!$se_edate)	{
	$se_edate = date("Y-m-d");	
}

?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div class="row">
	<div class="col-md-12 portlets ui-sortable">
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
					<th>
						매출일
					</th>
					<td  colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='se_sdate' id='se_sdate' value='<?=$se_sdate;?>'> ~ <input type='text' class="form-control" name='se_edate' id='se_edate' value='<?=$se_edate;?>'>
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
<?


	$q = "SELECT distinct(shop_newmarketdb_accounts.buymethod) FROM shop_newmarketdb_accounts INNER JOIN shop_newmarketdb ON shop_newmarketdb.idx=shop_newmarketdb_accounts.market_idx WHERE 1";
	$st = $pdo->prepare($q);
	$st->execute();
	$cou = 0;
	$ar_bm = [];
	while($row = $st->fetch())	{
		if(!in_array($row['buymethod'],$ar_bm) && $row['buymethod']!='')	{
			$ar_bm[$cou] = $row['buymethod'];
			$cou++;
		}
	}

	$q = "SELECT shop_newmarketdb_accounts.* FROM shop_newmarketdb_accounts INNER JOIN shop_newmarketdb ON shop_newmarketdb.idx=shop_newmarketdb_accounts.market_idx WHERE shop_newmarketdb_accounts.incdate>='$se_sdate' AND shop_newmarketdb_accounts.incdate<='$se_edate'";
	if($fid)	{
		$q = $q . " AND fid='$fid'";
	}
	if($pid)	{
		$q = $q . " AND pid='$pid'";
	}

	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$h = $row['incdate'];
		$m = $row['buymethod'];

		if($row['tbtype']=='I')	{
			
			$ar_inac[$m][$h] = $ar_inac[$m][$h] + $row['account']/100;
		}

		if($row['tbtype']=='O')	{
			
			$ar_outac[$m][$h] = $ar_outac[$m][$h] + $row['account']/100;

		}

	}
?>

<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 매출액</h3>
			</div>
			<div class="panel-content">
				<div id="chart1" style="width:100%;height:300px;"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 매출액/환불액</h3>
			</div>
			<div class="panel-content">
				<div id="chart2" style="width:100%;height:260px;margin-left:5px;"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 종합적 매출 확인</h3>
			</div>
			<div class="panel-content">
				<div id="chart3" style='height:290px;'></div>

			</div>
		</div>
	</div>
	<div class="col-md-4 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 매출/환불/순매출 기간평균</h3>
			</div>
			<div class="panel-content">
				<div id="chart4" style='height:290px;'></div>

			</div>
		</div>
	</div>
	<div class="col-md-4 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 결제수단별비율</h3>
			</div>
			<div class="panel-content">
				<div id="chart5" style='height:290px;'></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 통계데이터</h3>
			</div>
			<div class="panel-content">


		<table class="table table-bordered">
		<colgroup>
	
		</colgroup>
		<thead>
		<tr>
			<th rowspan='2'>날짜</th>
			<th style="border-bottom:1px solid #e1e1e1!important;" colspan='<?=(sizeof($ar_bm)+1);?>'>매출</th>
			<th style="border-bottom:1px solid #e1e1e1!important;" colspan='<?=(sizeof($ar_bm)+1);?>'>환불</th>
			<th rowspan='2'>순매출</th>
		</tr>
		<tr>
			<?
			for($i=0;$i<sizeof($ar_bm);$i++)	{
			?>
			<th <? if($i==0){?>style="border-left:1px solid #e1e1e1!important;"<?}?>><?=$g_ar_method[$ar_bm[$i]];?></th>
			<?
			}
			?>
			<th>매출합</th>
			<?
			for($i=0;$i<sizeof($ar_bm);$i++)	{
			?>
			<th><?=$g_ar_method[$ar_bm[$i]];?></th>
			<?
			}
			?>
			<th>환불합</th>
		</tr>
		</thead>
		<tbody>
		<?
		$categories = "";
		$data1_1 = "";
		$data1_2 = "";
		$data2_1 = "";
		$data2_2 = "";
		$cou = 0;

		$ar_sdate = explode("-",$se_sdate);
		$ar_edate = explode("-",$se_edate);
		$se_sdate_t = mktime(0,0,1,$ar_sdate[1],$ar_sdate[2],$ar_sdate[0]);
		$se_edate_t = mktime(0,0,1,$ar_edate[1],$ar_edate[2],$ar_edate[0]);

		$nums = ($se_edate_t - $se_sdate_t)/86400;


		for($i=0;$i<=$nums;$i++)	{
			
			$show_date = date("Y-m-d",($se_sdate_t+86400*$i));
			
			
			$co = "";
			if(!($cou%2)) $co = "gray";

		?>
		<tr class="<?=$co;?>">
			<td class="first"><?=$show_date;?></td>
			<?
			for($j=0;$j<sizeof($ar_bm);$j++)	{
				$m = $ar_bm[$j];

				$ar_insum[$show_date] = $ar_insum[$show_date] + $ar_inac[$m][$show_date];
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format($ar_inac[$m][$show_date]);?></td>
			<?
			}

			if(!$ar_insum[$show_date])	{
				$ar_insum[$show_date] = 0;
			}
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format($ar_insum[$show_date]);?></td>
			<?
			for($j=0;$j<sizeof($ar_bm);$j++)	{
				$m = $ar_bm[$j];

				$ar_outsum[$show_date] = $ar_outsum[$show_date] + $ar_outac[$m][$show_date];
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format($ar_outac[$m][$show_date]);?></td>
			<?
			}

			if(!$ar_outsum[$show_date])	{
				$ar_outsum[$show_date] = 0;
			}
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format($ar_outsum[$show_date]);?></td>
			<td style='text-align:right;padding-right:5px;'><?=number_format($ar_insum[$show_date]-$ar_outsum[$show_date]);?></td>
		</tr>

		<?
			//그래프데이터가공영역
			if($i!=0)	{
				$categories = $categories . ",";
				$data1_1 = $data1_1 . ",";
				$data1_2 = $data1_2 . ",";
				$data2_1 = $data2_1 . ",";
				
			}
			$categories = $categories . "'".$show_date."'";
			$data1_1 = $data1_1 . $ar_insum[$show_date];
			$data1_2 = $data1_2 . $ar_outsum[$show_date];
			$data2_1 = $data2_1 . ($ar_insum[$show_date]-$ar_outsum[$show_date]);
			//그래프데이터가공영역

			$cou++;
		}
		?>
		<tr>
			<td class="first">합계</td>
			<?
			$data4 = "";
			for($j=0;$j<sizeof($ar_bm);$j++)	{
				$m = $ar_bm[$j];
				if($j!=0)	{
					$data4 = $data4.",";
				}
				$data4 = $data4."{	name: '".$g_ar_method[$ar_bm[$j]]."',y: ".number_format( array_sum($ar_inac[$m]) / array_sum($ar_insum) * 100,2)."}";
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format(array_sum($ar_inac[$m]));?></td>
			<?
			}
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format(array_sum($ar_insum));?></td>
			<?
			for($j=0;$j<sizeof($ar_bm);$j++)	{
				$m = $ar_bm[$j];
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format(array_sum($ar_outac[$m]));?></td>
			<?
			}
			?>
			<td style='text-align:right;padding-right:5px;'><?=number_format(array_sum($ar_outsum));?></td>
			<td style='text-align:right;padding-right:5px;'><?=number_format(array_sum($ar_insum)-array_sum($ar_outsum));?></td>
		</tr>
		<?
		//그래프가공
		$g = $nums+1;
		$avg = intval((array_sum($ar_insum)-array_sum($ar_outsum))/$g);

		for($i=0;$i<=$nums;$i++)	{
			if($i!=0)	{
				$data2_2 = $data2_2 . ",";
			}
			$data2_2 = $data2_2 . $avg;
		}
		?>
		</tbody>
		</table>
			</div>
		</div>
	</div>
</div>
<script>
$(function () {
    $('#chart1').highcharts({
        title: {
            text: ''
        },
        xAxis: {
            categories: [<?=$categories;?>]
        },
        yAxis: {
            title: {
                text: '금액'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '원'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '매출액',
            data: [<?=$data1_1;?>]
        }, {
            name: '환불액',
            data: [<?=$data1_2;?>]
        }]
    });
});

$(function () {
    $('#chart2').highcharts({
        title: {
            text: ''
        },
        xAxis: {
            categories: [<?=$categories;?>]
        },
        yAxis: {
            title: {
                text: '금액'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '원'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '순매출액',
            data: [<?=$data2_1;?>]
        }, {
            name: '평균매출액',
            data: [<?=$data2_2;?>]
        }]
    });
});
$(function () {

    $('#chart3').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '금액'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                }
            }
        },

        tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}원</b><br/>'
        },

        series: [{
            colorByPoint: true,
            data: [{
                name: '매출합',
                y: <?=array_sum($ar_insum);?>
            }, {
                name: '환불합',
                y: <?=array_sum($ar_outsum);?>
            }, {
                name: '순매출',
                y: <?=(array_sum($ar_insum)-array_sum($ar_outsum));?>
            }]
        }]
    });
});

$(function () {

    $('#chart4').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: '금액'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                }
            }
        },

        tooltip: {
            headerFormat: '',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}원</b><br/>'
        },

        series: [{
            colorByPoint: true,
            data: [{
                name: '매출평균',
                y: <?=intval(array_sum($ar_insum)/$g);?>
            }, {
                name: '환불평균',
                y: <?=intval(array_sum($ar_outsum)/$g);?>
            }, {
                name: '순매출평균',
                y: <?=intval((array_sum($ar_insum)-array_sum($ar_outsum))/$g);?>
            }]
        }]
    });
});

$(function () {
   $('#chart5').highcharts({
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
                    showInLegend: true
			}
		},
        series: [{
			name: '결제수단',
			colorByPoint: true,
			data: [<?=$data4;?>]
		}]
    });
});
</script>