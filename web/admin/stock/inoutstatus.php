<?php
$currYear = $_GET['currYear'];
$currMonth = $_GET['currMonth'];
$currDay = $_GET['currDay'];

if(!$currYear) { $currYear = date("Y",time());	}
if(!$currMonth) { $currMonth = date("n",time());	}
if(!$currDay) { $currDay = date("j",time());	}


$chdate = mktime(0,1,1,$currMonth,$currDay,$currYear);

$days = array("일","월","화","수","목","금","토");
$totalDays = array(0,31,28,31,30,31,30,31,31,30,31,30,31);

if(date("L",mktime(0,0,0,$currMonth,1,$currYear)))	{
	$totalDays[2] = 29;	
}

$firstDayOfMonth = date("w",mktime(0,0,0,$currMonth,1,$currYear));
$x = 0;

if($currMonth==1)	{	
	$byear = $currYear-1;
	$amonth = $currMonth+1;
	$beforelink = "$PHP_SELF?code=$code&currYear=$byear&currMonth=12";
	$nextlink = "$PHP_SELF?code=$code&currYear=$currYear&currMonth=$amonth";
}
else if($currMonth==12)
{
	$ayear = $currYear+1;
	$bmonth = $currMonth-1;
	$beforelink = "$PHP_SELF?code=$code&currYear=$currYear&currMonth=$bmonth";	
	$nextlink = "$PHP_SELF?code=$code&currYear=$ayear&currMonth=1";
}
else
{
	$amonth = $currMonth+1;
	$bmonth = $currMonth-1;
	$beforelink = "$PHP_SELF?code=$code&currYear=$currYear&currMonth=$bmonth";	
	$nextlink = "$PHP_SELF?code=$code&currYear=$currYear&currMonth=$amonth";
}

for($i=1;$i<=$totalDays[$currMonth];$i++)	{
	$have_info[$i] = "3";	
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i>입출고현황</h3>
			</div>
			<div class="panel-content">
				<div class="paging btn_top">
					<span class='btn_white_xs btn_prev'><a href="<?=$beforelink;?>"><i class='fa fa-angle-left'></i>이전</a></span>
					<strong class='current'><?=$currYear;?>년 <?=$currMonth;?>월</strong>
					<span class='btn_white_xs btn_next'><a href="<?=$nextlink;?>">다음<i class='fa fa-angle-right'></i></a></span>
				</div>

	<table class="table table-bordered">
		<thead>
		<tr>		
<?php
for($x=0;$x<7;$x++)
{
	switch($x)
	{
		case '0' :
			echo "<th width='15%' class='menu01'>$days[$x]요일</th>";
			break;
		case '6' : 
			echo "<th width='15%' class='shik'>$days[$x]요일</th>";
			break;
		default :
			echo "<th width='15%'>$days[$x]요일</th>";
			break;
	}
}				
?>				  
		</tr>
		</thead>
		<tbody>
		<tr>  
<?php
$rowCount=0; 
for($x=0;$x<$firstDayOfMonth;$x++)
{
	$rowCount++;
	echo "<td></td>";
}

$dayCount=1;
while($dayCount <= $totalDays[$currMonth])
{
	if($rowCount % 7 == 0)
	{
		echo "</tr><tr>";
	}

	if($dayCount == date("j",time()) && $currYear == date("Y",time()) && $currMonth == date("n",time()))
	{	show_days($have_info[$dayCount],$dayCount,"");	}
	else if($rowCount % 7 ==0)
	{	show_days($have_info[$dayCount],$dayCount,"class='menu01'");	}
	else if($rowCount % 7 ==6)
	{	show_days($have_info[$dayCount],$dayCount,"class='shik'");	}
	else
	{	show_days($have_info[$dayCount],$dayCount,"");	}
	
	$dayCount++;
	$rowCount++;
}
if($rowCount%7!=0)
{
	for($i=0;$i<(7-($rowCount%7));$i++)
	{	echo "<td></td>";	}
}

?>
		</tr>
		</table>
<?php
function show_days($day,$daycount,$clas)
{
	global $currYear;
	global $currMonth;
	global $mem_idx;
	global $basictb;
	global $code;
	global $fid;

	if(strlen($currMonth)==1)
	{	$scurrMonth = "0".$currMonth;	}
	else
	{	$scurrMonth = $currMonth;	}

	if(strlen($daycount)==1)
	{	$sdaycount = "0".$daycount;	}
	else
	{	$sdaycount = $daycount;	}

	$wdate_s = $currYear."-".$scurrMonth."-".$sdaycount;
	

		echo "<td width='15%'>
			<table border='0' cellspacing='0' cellpadding='0' width='98%'>
			<tr>
			<Td style='text-align:left;padding-left:10px;border:0px;'><a href='$PHP_SELF?wdate_s=$wdate_s&code=stock_inoutde&fid=$fid'>$daycount</a></td>
			</tR><tr><td style='height:10px;border:0px;'></tD></tr>";
			
			$qs = "Select * from shop_goods_inout_cate order by index_no asc";
			$rs = mysqli_query($connect,$qs);
			while($rows = mysqli_fetch_array($rs))
			{

				$q = "select sum(ea) from shop_goods_inout,shop_goods where wdate_s='$wdate_s' and tbtype='$rows[index_no]' and shop_goods_inout.goods_idx=shop_goods.index_no";
				if($fid)
				{	$q = $q ." and fid='$fid'";	}
				$r = mysqli_query($connect,$q);
				$row = mysqli_fetch_row($r);

				if($row[0])
				{	echo "<tr><Td style='text-align:left;padding-left:10px;border:0px;'><a href='$PHP_SELF?wdate_s=$wdate_s&code=stock_inoutde&fid=$fid&cate=$rows[index_no]'>$rows[catename] : ".number_format($row[0])."EA</a></td></tr>";	}
			
			}	
			$qs = "select sum(ea) from shop_gotable_sub_ok where godate='$wdate_s'";
			$rs = mysqli_query($connect,$qs);
			$rows = mysqli_fetch_row($rs);

			if($rows[0])
			{	echo "<tr><Td style='text-align:left;padding-left:10px;border:0px;'><a href='$PHP_SELF?code=gostat&sdate=$wdate_s&edate=$wdate_s&isov=1&fid=$fid' style='color:blue'>발송출고 : ".number_format($rows[0])."EA</a></td></tr>";	}
			
			echo "
			</tbody>
			</table>
		</td>";	
}
?>
			</div>

		</div>
	</div>
</div>

