<?php
$itype = $_REQUEST['itype'];
$std_idx = $_REQUEST['std_idx'];
$mode = $_REQUEST['mode'];

if($mode=='w')	{
	
	if($rmethod=='1')	{
		

		ini_set('memory_limit', '-1');


		$q = "SELECT index_no FROM shop_member where id!='outmember' order by index_no asc";
		$r = mysql_query($q);
		while($row = mysql_fetch_array($r))	{
			
			if(update_member_point($row[index_no],$points,'up',$memomsg,$_gmemname))	{
				
				$cou = $cou + 1;
			}

		}
		
		$total = $points * $cou;
		
		unset($value);
		$value[rtable] = "_member_points";
		$value[mem_index] = $g_memidx;
		$value[tag] = "적립금일괄지급";
		$value[msg1] = $memomsg;
		$value[msg2] = "전체회원지급 - 지급금액 : $points | 총적립금 : $total | 지급인원 : $cou";
		$value[regdt] = date("Y-m-d H:i:s");
		insert("shop_global_log",$value);
		unset($value);

		show_message("등록완료","");
		move_link("$PHP_SELF?code=$code");
		exit;

	}
	else	{

		$removef = $_REQUEST['removef'];
		$bf1 = $_REQUEST['bf1'];
		$bf2 = $_REQUEST['bf2'];
		$bf3 = $_REQUEST['bf3'];
		$savedir = "./csvs/";
		$error_cou = 0;
		$errs = "";
	
		$userfile = array($_FILES['file']['name']);
		$tmpfile = array($_FILES['file']['tmp_name']);
		
		for($i=0;$i<sizeof($userfile);$i++)
		{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}
	
		$filename = $fs[0];
	
		echo "<script>alert('파일등록! 자료를 확인해주세요'); location.replace('$PHP_SELF?code=mpoint_next&fi=$filename&removef=$removef&bf1=$bf1&bf2=$bf2&bf3=$bf3&memomsg=".urlencode($memomsg)."'); </script>";
		exit;
	}
}
?>
<script>
function set_m(m)	{
	
	if(m==1)	{
		$("#m2").hide();
	}
	else	{
		$("#m2").show();
	}
		
}
</script>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('등록 하시겠습니까?');
		if(answer==true)	{
			return true;
		}
		else	{
			return false;
		}
	}
	else	{
		return false;
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 적립금일괄지급</h3>
			</div>
			<div class="panel-content">
				<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" enctype="multipart/form-data" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>지급방식</th>
					<td colspan='3'>
						<label><input type='radio' name='rmethod' value='1' onclick="set_m(1);" checked>전체회원지급</label>
						<label><input type='radio' name='rmethod' value='2' onclick="set_m(2);">엑셀업로드지급</label>
					</td>
				</tr>
				<tr style="display:none;" id="m2">
					<th>파일</th>
					<td colspan='3'>
						<div class="form-inline">
						<input style="display:inline" type='file' name='file'> <input type='checkbox' name='removef' value='Y'> 첫줄 제외
						</div>
					</td>
				</tr>
				<tr>
					<th>지급액</th>
					<td colspan='3'><input type="text" name="points" class="form-control" valch="yes" msg="적립액을 입력하세요"></td>
				</tr>
				<tr>
					<th>지급메모</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type="text" name="memomsg" class="form-control" valch="yes" msg="적립사유를 입력하세요"> [지급사유에 대한 메모를 작성하세요]
						</div>
					</td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#form1">등록하기</button>
						
					</div>
				</div>

				</form><!-- // form=[name="form1"] -->

			</div>
		</div>
	</div>
</div>


<?
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 20;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "regdt";

if ( !$sortby )
$sortby = "desc";


/* //정렬 기본 */
$keyword = trim($keyword);
//HTTP QUERY STRING
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['sortcol'] = $sortcol;
$qArr['sortby'] = $sortby;

$q = "SELECT [FIELD] FROM shop_global_log WHERE tag='적립금일괄지급'";
//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(index_no)", $q);
$r = mysql_query($sql);
$total_record = mysql_result($r,0,0);
mysql_free_result($r);

if($total_record == 0) { 
	$first = 0;
	$last = 0;
} else { 
	$first = $numper*($page-1);
	$last = $numper*$page; 
}

//데이터쿼리
$_sql = str_replace("[FIELD]", "*", $q);

$_tArr = explode(",", $sortcol);
if ( is_array($_tArr) && count($_tArr) ) {
	foreach ( $_tArr as $v ) {
		$orderbyArr[] = "{$v} {$sortby}";
	}
	$orderby = implode(", ", $orderbyArr);
}

$sql_order = " ORDER BY {$orderby}";
$sql_limit = " LIMIT $first, $numper";
$sql = $_sql.$sql_order.$sql_limit;


$r = mysql_query($sql);
while($row = mysql_fetch_array($r)){
	$data[] = $row;
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 지급내역</h3>
			</div>
			<div class="panel-content">


<table class="table table-bordered">
<colgroup>
	<col width="150px" />
</colgroup>
<thead>
<tr>
<th>처리일</th>
<th>처리자명</th>
<th>지급사유</th>
<th>처리내용</th>
</tr>
</thead>
<tbody>
<?
$cou = 0;
for($i=0;$i<count($data);$i++){
	$row = $data[$i];

	
	$co = "";
	if(!($cou%2)) $co = "gray";


?>
<tr>
	<td class="first"><?=$row[regdt];?></td>
	<Td><? $ar_mem = sel_query("${basictb}_member","name"," WHERE index_no='$row[mem_index]'"); echo $ar_mem[name];	?></td>
	<tD><?=$row[msg1];?></td>
	<td><?=$row[msg2];?></td>
</tr>

<?php
	$cou++;
}
?>
				</tbody>
				</table>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>