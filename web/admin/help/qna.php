<?php
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "wdate";

if ( !$sortby )
$sortby = "desc";

/* //정렬 기본 */


//HTTP QUERY STRING
$keyword = trim($keyword);
$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;

$qArr['sortcol'] = $sortcol;
$qArr['sortby'] = $sortby;

$q = "SELECT ['FIELD'] FROM shop_qna WHERE isdel='N'";

//카운터쿼리
$sql = str_replace("['FIELD']", "COUNT(idx)", $q);
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
$_sql = str_replace("['FIELD']", "*", $q);

$_tArr = explode(",", $sortcol);
if ( is_array($_tArr) && count($_tArr) ) {
	foreach ( $_tArr as $v ) {
		$orderbyArr[''] = "{$v} {$sortby}";
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
<div class="row"	>
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<Tr>
					<Th>문의분류</th>
					<td>
						<select class="uch" name='sb' id="id_sb" style="z-index: 2;">
						<option value=''>분류선택</option>
						<?php
						$q = "Select * from shop_qna_cate order by idx asc";
						$st = $pdo->prepare($sql);
						$st->execute();
						while($row = $st->fetch())	{
							$sel = "";
							if($sb==$row['idx'])	{
								$sel = "selected";
							}
							echo "<option value='".$row['idx']."' $sel>".$row['catename']."</option>";	
						}
						?>
						</select>
					</td>

					<th>답변상태</th>
					<td>
						<select class="uch" name='isanswer' style="z-index: 4;">
						<option value=''>전체</option>
						<option value='N' <? if($isanswer=='N') { echo "selected";	}?>>답변안됨</option>
						<option value='D' <? if($isanswer=='D') { echo "selected";	}?>>답변중</option>
						<option value='Y' <? if($isanswer=='Y') { echo "selected";	}?>>답변완료</option>
						</select>
					</td>
				</tr>
				<Tr>
					<th>기타조건</th>
					<td>
						<div class="form-inline">
							<select class="uch" name='key' style="z-index: 1;">
							<option value=''>검색조건</option>
							<option value='mem_name' <? if($key=='mem_name') { echo "selected";	}?>>작성자</option>
							<option value='subject' <? if($key=='subject') { echo "selected";	}?>>제목</option>
							<option value='memo' <? if($key=='memo') { echo "selected";	}?>>내용</option>
							<option value='gname' <? if($key=='gname') { echo "selected";	}?>>상품명</option>
							<option value='goods_idx' <? if($key=='goods_idx') { echo "selected";	}?>>상품번호</option>
							</select>
							<input type='text' class="form-control" name='keyword' value='<?=$keyword;?>' size='40' class='basic_input'>
						</div>
					</td>

					<th>답변자</th>
					<td><select class="uch" name='sre' style="z-index: 3;">
					<option value=''>전체</option>

					</select>
					</td>

					
				</tr>
				<tr>	
					<th>질문일</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='sdate' value='<?=$sdate;?>' id='sdates'> ~ <input type='text' class="form-control" name='edate' value='<?=$edate;?>' id='edates'>
						</div>
					</td>
				</tr>
				</tr>
				</tbody>
				</table>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row"	>
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 총 : <?=number_format($total_record);?> 게시물</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th class="sd1"><input type='checkbox' name='allindex' onclick='allch()'></th>
					<th class="sd1">번호</th>
					<th class="sd1">종류</th>
					<th class="sd1">제 목 </th>
					<th class="sd1">작성자</th>
					<th class="sd1">날 짜 </th>
					<th class="sd1">답변</th>
					<th class="sd1">답변자</th>
				</tr>
				</thead>
				<tbody>
<?
$cou = 0;
for($is=0;$is<count($data);$is++){
	$row = $data[$is];

	$ar_cate = sel_query_all("shop_qna_cate"," where idx='".$row['cate']."'");
?>
				<tr>
					<td class="first" class="sd2"><input type='checkbox' name='index' value='<?=$row['idx'];?>'></td>
					<td class="sd2"><?=$row['idx'];?></td>
					<td><?=$ar_cate['catename'];?></td>
					<td style='text-align:left;padding-left:10px;'><a href="subpage.php?code=help_qnar&idx=<?=$row['idx'];?>&page=<?=$page;?>&keyword=<?=$keyword;?>&sb=<?=$sb;?>&isanswer=<?=$isanswer;?>&sre=<?=$sre;?>&fid=<?=$fid;?>" ><? if($row['mem_idx']==0) { echo "['비회원']";	}?><?=$row['subject'];?><? if(trim($row['subject'])=='') { ?>문의<?}?></a>
		
					</td>
					<td class="sd3"><?=$pop;?><?=$row['mem_name'];?></a></td>
					<td class="sd2"><?=$row['wdate'];?></td>
					<td class="sd3"><?	if($row['result']=='D')	{?><font color='blue'>답변중</font><?}?><?	if($row['result']=='Y')	{?>답변완료<?}?><? if($row['last_idx1']!='0') { echo "C";	}?></td>
					<td><?=$row['resultwriter'];?></td>
				</tr>
<?
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