<?php
$mode = "";
if(isset($_REQUEST['mode']))	{
	$mode = $_REQUEST['mode'];	
}
if($mode=='c')
{
	$idx = $_REQUEST['idx'];

	$sites = $_REQUEST['sites'];
	$sites = serialize($sites);

	$value[mempriv] = $sites;
	$value[amemgrade] = $_REQUEST['amemgrade'];
	update("shop_member",$value," where idx='$idx'");

	echo "<script>alert('처리완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($mode=='d')
{
	$idx = $_GET['idx'];
	$value[mempriv] = '';
	$value[amemgrade] = 0;
	update("shop_member",$value," where idx='$idx'");

	echo "<script>alert('삭제하였습니다.'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($mode=='passwd')	{

	
	$idx = $_GET['idx'];
	$value[passwd] = $_REQUEST['passwd'];
	update("shop_member",$value," where idx='$idx'");

	echo "<script>alert('변경완료.'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}

$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "idx";

if ( !$sortby )
$sortby = "desc";



//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['se_key']= $se_key;
$qArr['se_keyword'] = $se_keyword;

$q = "SELECT [FIELD] FROM shop_member WHERE id!='outmember' AND amemgrade!='0'";

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(idx)", $q);
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

while($row = $st->fetch()){
	$data[] = $row;
}

//엑셀쿼리
$sql_excel = $_sql.$sql_order;
$_SESSION['sql_excel'] = $sql_excel;
?>
<script language="javascript">
function regi()
{
	if(!document.search2.id.value)
	{
		alert('관리자로 등록하고자 하는 아이디를 입력하세요.');
		document.search2.id.focus();
		return false;
	}
	return true;
}
</script>
<script language="javascript">
function delok(url)
{
	answer = confirm('삭제하시겠습니까?');
	if(answer==true)
	{	location.href=url;	}
}
function set_change(id)	{
	
	if($("#passwd"+id).val()=='')	{
		alert('변경할 비밀번호 입력');
		return;
	}
	answer = confirm('변경하시겠습니까?');
	if(answer==true)	{
		location.href='<?=$PHP_SELF;?>?code=<?=$code;?>&mode=passwd&passwd='+$("#passwd"+id).val()+'&idx='+id;	
	}
}
</script>

<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>관리자등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 관리자목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>No</th>
	<th>회원명</th>
	<th>ID</th>
	<th>성별</th>
	<th>연락처</th>
	<th>마지막로그인</th>
	<th>가입일</th>
	<th>등급</th>
	<th>비밀번호변경</th>
	<th></th>
				</tr>
				</thead>
				<tbody>
<?php
$cou = 0;
for($is=0;$is<count($data);$is++){
	$row = $data[$is];
?>
<tr>
		<td><?=$row['idx'];?></td>
		<td>
			<a href="javascript:MM_openBrWindow('popup?code=help_view&idx=<?=$row['idx'];?>','member<?=$row['idx'];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$row['name'];?></a>
		</td>
		<td><?=$row['id'];?></td>
		<td><?=$row['sex'];?></td>
		<td><?=$row['phone'];?></td>
		<td><?=$row['lastlogin'];?></td>
		<td><?=$row['signdate'];?></td>
		<td>
			
		</td>
		<td>
			
		</td>
		<td><span class="btn_white_xs"><a href="javascript:delok('<?=$G_PHP_SELF;?>?code=<?=$code;?>&mode=d&idx=<?=$row['idx'];?>&page=<?=$page;?>');">삭제</a></span></td>
	</tr>
<?php }?>
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
