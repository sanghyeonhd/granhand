<?
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 40;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

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

$q = "SELECT [FIELD] FROM shop_coupen WHERE isdel='N'";
if($se_keyword)	{
	$q = $q . " AND $se_key like '%$se_keyword%'";
}


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
				<h3><i class="fa fa-table"></i> 쿠폰검색 : 총 <?=$total_record;?>건</h3>
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
					<Th>검색조건</th>
					<td colspan='3'>
						<div class="form-inline">
						<select class="uch" name='se_key'>
						<option value='coupenname' <? if($se_key=='coupenname') { echo "selected"; } ?>>쿠폰이름</option>
						</select>
						<input type='text' name='se_keyword' value="<?=$se_keyword;?>" class="form-control" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }" >
						</form>
					</td>
				</tR>
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
			<a href="<?=$PHP_SELF;?>?code=<?=$code;?>w" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>쿠폰등록</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 쿠폰목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>번호</th>
					<th>쿠폰종류</th>
					<th>IMG</th>
					<th>쿠폰명</th>
					<th>할인율/금액/지급내용</th>
					
					<th>배포기간</th>
					<th>배포여부</th>
					<th>유효기간</th>
					<th>발급쿠폰</th>
					<th>사용쿠폰</th>
					<th>종류</th>
					<th></th>
					<th></th>
				</tr>
				</thead>
<?php
for($is=0;$is<sizeof($data);$is++)	{
	$row = $data[$is];
?>

				<tr>
					<td class="first"><?=$row['idx'];?></td>
					<td><? if($row['usetype']=='1') { echo "일반쿠폰";	} else if($row['usetype']=='2') {  echo "리워드쿠폰";	}?></td>
					<td><? if($row['img']!=''){?><img src="<?=$_imgserver;?>/coupen/<?=$row['img'];?>"><?}?></td>
					<td><?=$row['coupenname'];?></td>
					<td>
	
						<?php
						if($row['usetype']=='1')	{
							if($row['actype']=='3')	{
							echo "배송비면제";	
						}
						else	{
							echo number_format($row['account']);
								if($row['actype']=='1') { 
									echo "원";	
								} 
								else { 
									echo "%";	
								}
							}
						}
						else	{
							
							$ar_give_goods_infos = explode("|R|",$row['give_goods_infos']);
							for($i=0;$i<sizeof($ar_give_goods_infos);$i++)	{
								if($ar_give_goods_infos[$i]!='')	{
									$ar_tps = explode("|-|",$ar_give_goods_infos[$i]);
									$ar_goods = sel_query("shop_goods","gname"," where idx='".$ar_tps[0]."'");

									echo "<p>".$ar_goods['gname']."(".$ar_tps[1]."개) 지급</p>";
								}
							}

						}

						
						?>
			
					</td>
					
					<td><?=$row['downs'];?> ~ <?=$row['downe'];?></td>
					<tD><? if($row['isuse']=='Y') { echo "배포"; } else { echo "배포안함";	}?></td>
					<td>
					<? 
					if($row['used']=='1')	{
						echo $row['startdates'] ." ~ ". $row['enddates'];
					}
					else	{
						if($row['usedays']==0) { echo "무제한";	} else { echo $row['usedays']."일";	}
					}
					?>
					</td>
					<tD>
					<?
					$q2 = "select count(idx) from shop_coupen_mem where coupen_idx='$row[idx]'";	
					$st2 = $pdo->prepare($q2);
					$st2->execute();
					$row2 = $st2->fetch();

					$u1 = $row2[0];
	
					echo number_format($u1);
					?>
					</td>
					<tD>
					<?
					$q2 = "select count(idx) from shop_coupen_mem where coupen_idx='$row[idx]'";
					$q2 = $q2 ." and usedate!=''";	
					$st2 = $pdo->prepare($q2);
					$st2->execute();
					$row2 = $st2->fetch();

					$u2 = $row2[0];

					echo number_format($u2);
					?>
					</td>
					<td><? if($row['isserial']=='N') { echo "일반쿠폰";	} if($row['isserial']=='1') { echo "랜덤시리얼쿠폰";	} if($row['isserial']=='2') { echo "동일시리얼쿠폰<br/>[".$row['serialnum']."]";	}?></td>
					<td>
						
					</td>
					<td>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>m&idx=<?=$row[idx];?>" class="btn btn-xs btn-primary">수정</a>

						<a href="#none" onclick="delchk(this,<?=$row['idx'];?>,'sho','set_del')" class="btn btn-xs btn-primary">삭제</a>

						<? if($row['isserial']=='1') {?><a href="<?=$PHP_SELF;?>?code=<?=$code;?>s&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">시리얼관리</a><?}?>
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