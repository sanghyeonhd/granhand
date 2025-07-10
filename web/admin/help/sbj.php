<?php
if($_REQUEST['mode']=='ok')	{
	
	$index_no = $_REQUEST['index_no'];

	$value['canconnect'] = "Y";
	update("shop_member",$value," WHERE index_no='$index_no'");

	show_message("승인되었습니다","");
	move_link("$PHP_SELF?code=$code");
	exit;
}

$numper = 20;
$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "index_no";

if ( !$sortby )
$sortby = "DESC";
/* //정렬 기본 */

if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}

//HTTP QUERY STRING

$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['sortcol'] = $sortcol;
$qArr['sortby'] = $sortby;

$keyword = trim($keyword);



$q = "SELECT [FIELD] FROM shop_member WHERE id!='outmember' and rtype='3' and canconnect='D'";


//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(index_no)", $q);
$st = $pdo->prepare($sql);
$st->execute();
$total_record = $st->fetchColumn();

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
$st = $pdo->prepare($sql);
$st->execute();
while($row = $st->fetch() ){
	$ar_mg = sel_query("shop_member_grades","grade_name"," WHERE grade_id = '{$row[memgrade]}' and group_idx='$row[mem_type]'");
	$row['grade_name'] = $ar_mg['grade_name'];
	
	if($row[sex]=='M') $row[sex] = '남';
	else $row[sex] = '여';
	
	$row[age] = date("Y",time())-$row[birth_year]+1;
	
	$data[] = $row;
}

//엑셀쿼리
$sql_excel = $_sql.$sql_order;
$_SESSION['sql_excel'] = $sql_excel;


?>

<script language="javascript" type="text/javascript">


function set_group()
{
	var id_group_idx = $('#id_group_idx option:selected').val();
	
		var param = "group_idx="+id_group_idx;
		$.ajax({
		type:"GET",
		url:"./ajaxmo/get_memg.php",
		dataType: "html",
		data:param,
		success:function(msg){
			$('#id_mg').html(msg);
		}
		});
}
function set_pids()
	{
		var fid = $('#fid option:selected').val();
	
		var param = "fid="+fid;
		$.ajax({
		type:"GET",
		url:"./ajaxmo/get_pid.php",
		dataType: "html",
		data:param,
		success:function(msg){
			$('#pid').html(msg);
		}
		});
	}
function set_ok(idx)	{
	answer = confirm('해당 SBJ를 승인하시겠습니까?');
	if(answer==true)	{
		location.href='<?=$PHP_SELF;?>?code=<?=$code;?>&mode=ok&index_no='+idx;
	}
}
</script>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 승인대기 총 <?=number_format($total_record);?>명 입니다.</h3>
			</div>
			<div class="panel-content">


<table class="table table-bordered">
<colgroup>
	<col width="40" />
	
</colgroup>
<thead>
<tr>
<th class=kor8>회원번호</th>
<th class=kor8>프로필이미지</th>
<th class=kor8>성명</th>
<th class=kor8>닉네임</th>
<th class=kor8>아이디</th>

<th class=kor8>나이</th>
<th class=kor8 style="display:none">성별</th>
<th class=kor8>전화번호</th>
<th class=kor8>핸드폰</th>
<th class=kor8>이메일</th>
<th class=kor8>가입일</th>
<th class=kor8>마지막구매</th>
<th class=kor8>회원등급</th>
<th class=kor8>가입처</th>
<th></th>
</tr>
</thead>
<?php
for($i=0;$i<count($data);$i++)
{
	$row = $data[$i];
	
	$co = "";
	if(!($i%2)) $co = "gray";
?>
	<tbody>
		<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
			<td class="first"><?=$row[index_no];?></td>
			<td><img src="<?=$_imgserver;?>/files/member/<?=$row['proimg'];?>" style="width:60px;"></td>
			<td>
				<a href="javascript:MM_openBrWindow('popup.php?code=help_view&index_no=<?=$row[index_no];?>','member<?=$row[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$row[name];?></a>
			</td>
			<td><?=$row[nickname];?></td>
			<td><?=$row[id];?></td>

			<td><?=$row[birth_year];?>(<?=$row['age'];?>)</td>
			<td style="display:none"><?=$row[sex];?></td>
			<td><?=$row[phone];?></td>
			<td><?=$row[cp];?></td>
			<Td><?=$row[email];?></td>
			<td><?=$row[signdate];?></td>
			<td><?=$row[lastorder];?></td>
			<td><?=$row[grade_name];?></td>
			<td><?=$g_ar_sitename[$row[pid]];?></td>
			<td>
				<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" onclick="set_ok(<?=$row['index_no'];?>);">승인하기</button>
			</td>
		</tr>
	</tbody>
<?php
}
?>
</table>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div><!-- // .list_wrap -->
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#sdates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#sdates1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#lastorder1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#lastorder2').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>