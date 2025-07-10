<?
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

$se_key		= $_REQUEST["se_key"];
$se_keyword	= $_REQUEST["se_keyword"];
$se_boardid	= $_REQUEST["se_boardid"];
$se_isview	= $_REQUEST["se_isview"];

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "idx";

if ( !$sortby )
$sortby = "desc";

/* //정렬 기본 */



//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['se_key']= $se_key;
$qArr['se_keyword'] = $se_keyword;
$qArr["se_boardid"]	= $se_boardid;
$qArr["se_isview"]	= $se_isview;

$q = "SELECT [FIELD] FROM shop_event WHERE isdel='N'";

$where	= "";
if( $se_boardid != "" )	$where	.= " and boardid = '$se_boardid' ";
if( $se_isview == "N" )	$where	.= " and isview = '$se_isview' ";
if( $se_keyword != "" )	$where	.= " and $se_key like '%$se_keyword%' ";

$q	= $q . $where;


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
$data = [];
while($row = $st->fetch() ){
	$data[] = $row;
}

//엑셀쿼리
$sql_excel = $_sql.$sql_order;
$_SESSION['sql_excel'] = $sql_excel;
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form id="searchform" name="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tR>
					<th>노출</th>
					<td colspan="3">
						<select name="se_isview">
							<option value="" <?if($se_isview == "" || $se_isview == "Y") echo "selected";?>>노출</option>
							<option value="N" <?if($se_isview == "N") echo "selected";?>>비노출</option>
						</select>
					</td>
				</tR>
				<tr>
					<Th>검색조건</th>
					<td colspan="3">
						<div class="form-inline">
						<select class="uch" name='se_key'>
						<option value='subject' <? if($se_key=='subject') { echo "selected"; } ?>>제목</option>
						</select>
						<input type='text' name='se_keyword' value="<?=$se_keyword;?>" class="form-control" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }" >
						</div>
					</td>
				</tr>
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
		<div class="text-right">
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>게시글등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 이벤트목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>번호</th>
					<th>게시판소속</th>
					<th>분류</th>
					<th>노출언어</th>
					<th align="center">노출</th>
					<th>제목</th>
					<th>작성자</th>
					<th>작성일</th>
					<th>조회</th>
					<th></th>
				</tr>
				</thead>
<?php
for($is=0;$is<sizeof($data);$is++)	{
	$row = $data[$is];

	
?>

				<tr>
					<td class="first"><?=$row['idx'];?></td>
					<tD><?=$ar_board_conf['board_name'];?></td>
					<td><? if($row['cates']!='') { echo $ar_cates['catename'];	}?></td>
					<td><?=$row['lan'];?></td>
					<td align="center"><?=$row['isview'];?></td>
					<Td style="Text-align:left;"><?=$row['subject'];?></td>
					<TD><?=$row['mem_name'];?></td>
					<tD><?=$row['wdate'];?></td>
					<tD><?=$row['readcount'];?></td>
					<td>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">수정</a>
						<a href="#none" onclick="event.preventDefault(); delchk(this,<?=$row['idx'];?>,'board','del_board')" class="btn btn-sm btn-primary">삭제</a>
					</td>
				</tr>
<?php
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