<?php
if(!$fid)	{
	if($ar_memprivc==1)	{	
		$fid = $ar_mempriv[0];	
	}
	else	{	
		$fid = $selectfid;	
	}
}
//날짜관련 초기화
if(!$sdate)	{
	$sdate = date("Y-m-d",time()-86400*2);
}

if(!$edate)	{	
	$edate = date("Y-m-d");	
}
if(!$sing_date)	{
	$sing_date = date("Y-m-d");	
}
if(!$year1)	{
	$year1 = date("Y",$nowdate-(86400*90));	
}
if(!$month1)	{
	$month1 = date("m",$nowdate-(86400*90));	
}

if(!$year2)	{
	$year2 = date("Y",$nowdate);	
}
if(!$month2){
	$month2 = date("m",$nowdate);	
}
$sdate_m = $year1."-".$month1;
$edate_m = $year2."-".$month2;

//날짜관련 초기화 끝

if (!$showall && !$_REQUEST['pids']) {
	$showall = "Y";
}

if ($_REQUEST['pids']) {
	foreach ($_REQUEST['pids'] as $value) {
		if (trim($value)) {
			$ar_pids[] = $value;
		}
	}
	$pidsstr = "'".implode("', '", $ar_pids)."'";
}
if(!$show_type)	{
	$show_type = "2";
}
$s_year = date("Y");


?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
function set_all()
{

	var checkObj = $(".pids");

	for(var i=0;i<checkObj.length;i++)	{
		if(checkObj.eq(i).prop("checked")==true)	{
			checkObj.eq(i).prop("checked",false);	
		}
	}
}
function set_alls()
{
	var k = 0;
	var checkObj = $(".pids");

	for(var i=0;i<checkObj.length;i++){
		if(checkObj.eq(i).prop("checked")==true)	{
			k = k + 1;	
		}
	}
	if(k!='0')	{
		$("#showall").prop("checked",false);	
	}
	else	{
		$("#showall").prop("checked",true);	
	}
}
function set_showtype(m)	{
	for(var i=1;i<4;i++)	{
		$("#st"+i).hide();
	}
	$("#st"+m).show();
}
</script>
<script>
function set_pids()	{
	var fid = $('#fid option:selected').val();
	
	if(fid=='')	{
		return;
	}

	var html = '';
	var param = "fid="+fid+'&del_loc=1&smode=json';
	$.getJSON('./ajaxmo/get_pid.php?'+param, function(result){ 
			html = '<label><input type="radio" name="showall" id="showall" value="Y" onclick="set_all()" checked>전체</label>';
			$(result.data).each(function(index,item){
				html = html + '<label><input type="checkbox" name="pids[]" class="pids" onclick="set_alls();" value='+item.k+'>'+item.v+'</label>';	
					
			});
			$("#pid").html(html);
	});
}
</script>

<Script>
$(document).ready(function()	{
	$('#sdate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#sing_edate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>


<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				
				<form id="search" name="search" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='sear'>

		<table class="table table-bordered">
		<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
		<tr>
			<th>주문처</th>
			<td><select name='fid' id="fid" onchange="set_pids();">
				<option value=''>전체</option>
				<?
				$q = "select * from shop_sites order by idx asc";
				$st = $pdo->prepare($q);
				$st->execute();
				while($row = $st->fetch())	{
					if(in_array($row['idx'],$ar_mempriv))	{
						if($row['idx']==$fid)	{	
							echo "<option value='$row[idx]' selected>$row[sitename]</option>";	
						}
						else	{	
							echo "<option value='$row[idx]'>$row[sitename]</option>";	
						}
					}
				}
				?>
				</select>
			</td>
		
			<th>소속판매처</th>
			<td id="pid">
				<?
				if($fid)	{

				?>
				<label><input type="radio" name="showall" id="showall" value="Y" onclick="set_all()" <? if($showall=='Y') { echo "checked";	}?>>전체</label>
				<?
					$q = "SELECT distinct(pid) AS pid FROM shop_newmarketdb WHERE fid='$fid'";
					$st = $pdo->prepare($q);
					$st->execute();
					while($row = $st->fetch())	{
						$se = "";
						if(is_array($pids)){
							if(in_array($row['pid'],$pids)) { 
								$se = "checked";	
							}
						}
						echo '<label><input type="checkbox" name="pids[]" class="pids" onclick="set_alls();" value="'.$row['pid'].'" '.$se.'>'.$g_ar_sitename[$row['pid']].'</label>';
					}
				}
				?>
			</td>
		</tr>
		<tr>
			<th>통계형식</th>
			<td colspan='3'><label><input type='radio' name='show_type' value='1' <? if($show_type=='1') { echo "checked";	}?> onclick="set_showtype('1');">시간별</label><label><input type='radio' name='show_type' value='2' <? if($show_type=='2') { echo "checked";	}?> onclick="set_showtype('2');">일자별</label><label><input type='radio' name='show_type' value='3' <? if($show_type=='3') { echo "checked";	}?> onclick="set_showtype('3');">월별</label></td>
		</tr>
		<tr id="st1" <? if($show_type!='1') { echo "style='display:none;'";	}?>>
			<th>날짜</th>
			<td colspan='3'>
				<div class="form-inline">
							<input type='text' class="form-control" name='sing_date' id='sing_date' value='<?=$sing_date;?>'>
				</div>
			</td>
		</tr>
		<tr id="st2" <? if($show_type!='2') { echo "style='display:none;'";	}?>>
			<th>날짜</th>
			<td colspan='3'>
				<div class="form-inline">
							<input type='text' class="form-control" name='sdate' id='sdate' value='<?=$sdate;?>'> ~ <input type='text' class="form-control" name='edate' id='edate' value='<?=$edate;?>'>
				</div>

			
			</td>
		</tr>
		<tr id="st3" <? if($show_type!='3') { echo "style='display:none;'";	}?>>
			<th>월별</th>
			<td colspan='3'>
					<select class="uch" name='year1'>
					<?php
					for($i=2005;$i<($s_year+1);$i++)	{	
						$se = "";
						if($i==$year1)	{
							$se = "selected";
						}
						echo "<option value='$i' $se>${i}년</option>";	
					}
					?>
					</select>
					<select class="uch" name='month1'>
					<?php
					for($i=1;$i<13;$i++)	{	
						$j = $i;
						$se = "";
						if(strlen($i)==1)	{
							$j = "0".$i;	
						}
						
						if($j==$month1)	{
							$se = "selected";
						}
						
						echo "<option value='$j' $se>${j}월</option>";	
					}
					?>
					</select>
					 부터 <select class="uch" name='year2'>
					<?php
					for($i=2005;$i<($s_year+1);$i++)	{	
						$se = "";
						if($i==$year2)	{
							$se = "selected";
						}
						echo "<option value='$i' $se>${i}년</option>";	
					}
					?>
					</select>
					<select class="uch" name='month2'>
					<?php
					for($i=1;$i<13;$i++){	
						$j = $i;
						$se = "";
						if(strlen($i)==1)	{
							$j = "0".$i;	
						}
						
						if($j==$month2)	{
							$se = "selected";
						}
						
						echo "<option value='$j' $se>${j}월</option>";	
					}
					?>
					</select>
					 까지
			</td>
		</tr>
		</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#search">검색</button>
						
					</div>
				</div>
		
				</form>
			</div>
		</div>
	</div>
</div>
<?	
if($mode=='sear')	{	
	
	$total = 0;
	if($show_type=='1')	{
		$q = "SELECT * FROM shop_member WHERE LEFT(signdate,10)='$sing_date'";
	}
	else if($show_type=='2')	 {
		$q = "SELECT * FROM shop_member WHERE signdate BETWEEN '$sdate 00:00:00' AND '$edate 23:59:59'";
	}
	else if($show_type=='3')	 {
		$q = "SELECT * FROM shop_member WHERE LEFT(signdate,7)>='".$sdate_m."-01' AND LEFT(signdate,7)<='".$edate_m."-".date('t',mktime(0,0,0,$month2,1,$year2))."'";
	}
	if($fid)	{
		$q = $q . " AND fid='$fid'";
	}
	if($pidsstr)	{
		$q = $q . " AND pid IN ({$pidsstr})";
	}
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		if($show_type=='1')	{         
			$h = substr($row['signdate'],11,2); 
		}
		else if($show_type=='2')	{
			$h = substr($row['signdate'],0,10);
		}
		else if($show_type=='3')	{
			$h = substr($row['signdate'],0,7);
		}


		$ar_showdata['joins'][$h] = $ar_showdata['joins'][$h] + 1;
		$total = $total + 1;	
	}
	
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원가입수</h3>
			</div>
			<div class="panel-content">
				<div id="gr1" style="width:100%;height: 350px; margin: 0 auto"></div>
			</div>
		</div>
	</div>
	
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 현황</h3>
			</div>
			<div class="panel-content">


		<table class="table table-bordered">
		<thead>
		<tr>
			<th>시간</th>
			<th>회원가입수</th>	
		</tr>
		</thead>
		<tbody>
		<?
		$cou = 0;
		$categories = "";
		$data_c1_1 = "";
		$data_c1_2 = "";
		$data_c1_3 = "";
		$data_c2_1 = "";
		$data_c2_2 = "";
		$data_c2_3 = "";
		
		if($show_type=='1')	{
			$nums = 23;
		}


		if($show_type=='2')	{

			$ar_sdate = explode("-",$sdate);
			$ar_edate = explode("-",$edate);
			$sdate_t = mktime(0,0,1,$ar_sdate[1],$ar_sdate[2],$ar_sdate[0]);
			$edate_t = mktime(0,0,1,$ar_edate[1],$ar_edate[2],$ar_edate[0]);

			$nums = ($edate_t - $sdate_t)/86400;
		}
		if($show_type=='3')	{
			
			$ar_sdate = explode("-",$sdate_m);
			$ar_edate = explode("-",$edate_m);
			$sdate_t = mktime(0,0,1,$ar_sdate[1],1,$ar_sdate[0]);
			$edate_t = mktime(0,0,1,$ar_edate[1],31,$ar_edate[0]);
	
			$nums = ($edate_t - $sdate_t)/(86400*31);
		}

		$cou = 0;
		for($i=0;$i<=$nums;$i++)	{
			
			if($show_type=='1')	{
				$show_date = $i;
				if(strlen($i)==1)	{
					$show_date = "0".$i;
				}

			}
			
			if($show_type=='2')	{
				$show_date = date("Y-m-d",($sdate_t+86400*$i));
			}

			if($show_type=='3')	{
				$show_date = date("Y-m",($sdate_t+86400*31*$i));
			}
			
			//그래프데이터가공영역
			if($i!=0)	{
				$categories = $categories . ",";
				$data_c1_1 = $data_c1_1 . ",";
				$data_c1_2 = $data_c1_2 . ",";

				$data_c2_1 = $data_c2_1 . ",";
				$data_c2_2 = $data_c2_2 . ",";
				$data_c2_3 = $data_c2_3 . ",";
			}
			$categories = $categories . "'".$show_date."'";

			if(!$ar_showdata['joins'][$show_date])	{
				$ar_showdata['joins'][$show_date] = 0;
			}
			
			$data_c1_1 = $data_c1_1 .$ar_showdata['joins'][$show_date];

			//그래프데이터가공영역

			$co = "";
			if(!($cou%2)) $co = "gray";
		?>
		<tr class='<?=$co;?>'>
			<td class="first"><?=$show_date;?></td>
			<td style='text-align:right;'><?=number_format($ar_showdata['joins'][$show_date]);?></td>

		</tr>
		<?
			$cou++;
		}
		//평균주문금액구하기
		for($i=0;$i<=$nums;$i++)	{
			if($i!=0)	{
				$data_c1_3 = $data_c1_3 . ",";
			}
			if($total!=0)	{
				$data_c1_3 = $data_c1_3 . intval(array_sum($ar_showdata['joins'])/$nums);
			}
			else	{
				$data_c1_3 = $data_c1_3 . "0";
			}
		}
		?>
		<tr>
			<td>합계</td>
			<td style='text-align:right;'><?=number_format(array_sum($ar_showdata['joins']));?></td>
		</tr>
		</tbody>
		</table>
			</div>
		</div>
	</div>
</div>
<?}?>

<script>
$(function () {
    $('#gr1').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: ''
        },
        xAxis: [{
            categories: [<?=$categories;?>],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}명',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: '금액'
            }
        }],
        tooltip: {
            shared: true
        },
        legend: {
            shadow: false
        },
        series: [{
            name: '회원가입수',
            type: 'column',
            data: [<?=$data_c1_1;?>],
            tooltip: {
                valueSuffix: ' 명'
            }

        }, {
            name: '평균가입수',
            type: 'spline',
            data: [<?=$data_c1_3;?>],
            tooltip: {
                valueSuffix: '명'
            }
        }]
    });
});

</script>