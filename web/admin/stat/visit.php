
<div class="row">
	<Div class="col-md-12">

	<div class="email-btn-row hidden-xs">
		<a href="subpage?code=stat_visit&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">전체방문현황</a>
		<!-- <a href="subpage?code=stat_hour&hcode=<?=$hcode;?>&type=vs" class="btn btn-primary btn-xs m-r-5">시간대별방문현황</a>
		<a href="subpage?code=stat_week&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">요일별방문현황</a> 
		<a href="subpage?code=stat_domain&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">유입방법 </a> 
		<a href="subpage?code=stat_rfquery&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">유입키워드</a> 
		<a href="subpage?code=stat_blog&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">블로그/커뮤니티</a> 
		<a href="subpage?code=stat_pstart&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">시작페이지</a> 
		<a href="subpage?code=stat_br&hcode=<?=$hcode;?>"  class="btn btn-primary btn-xs m-r-5" >브라우저</a> 
		<a href="subpage?code=stat_os&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">운영체제</a> 
		<a href="subpage?code=stat_display&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">해상도</a> 
		<a href="subpage?code=stat_lang&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">사용언어</a> 
		<a href="subpage?code=stat_cpu&hcode=<?=$hcode;?>" class="btn btn-primary btn-xs m-r-5">CPU</a> -->
	</div>
	
	</div>
</div>
<?
$g_ar_wdate= array('<font color=red>일</font>','월','화','수','목','금','<font color=blue>토</font>');
$sdate = $_REQUEST['sdate'];
$edate = $_REQUEST['edate'];
if(!$sdate)	{
	$sdate = date("Y-m-d",time()-86400*3);
}
if(!$edate)	{
	$edate = date("Y-m-d");
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
							<input type='text' class="form-control" name='sdate' id='se_sdate' value='<?=$sdate;?>'> ~ <input type='text' class="form-control" name='edate' id='se_edate' value='<?=$edate;?>'>
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
				<h3><i class="fa fa-table"></i> 전체방문현황</h3>
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
						<table class="table table-bordered">
						<thead>
						<tr>
							<th>일자</th>
							<th>총방문자</th>
							<th>유니크방문자</th>
							<th>총페이지뷰</th>
							<th>평균페이지뷰</th>
							<th>반송율</th>
							<th>체류시간평균</th>
						</tr>
						</thead>
						<tbody>
						<?
						$date = $sdate.",".$edate;


						$ch = curl_init();  
						curl_setopt($ch,CURLOPT_URL,$_logtarget."?module=API&method=VisitsSummary.get&idSite=".$g_ar_pid[$ik]['index_no']."&date=".$date."&period=day&format=json&token_auth=".$_logtoken);
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
					<?}?>
				</div>
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