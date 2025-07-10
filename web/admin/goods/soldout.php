<?
////////////////////////
// 데이터 인크루드 시작
$basictb	= "shop";	// 디폴트 테이블
$nowdate_s	= "";		//	date("Y-m-d");

$sdate	= $_REQUEST['sdate'];
if( !$sdate )	$sdate	= $nowdate_s;

$edate	= $_REQUEST['edate'];
if( !$edate )	$edate	= $nowdate_s;

$showall	= $_REQUEST['showall'];
$key		= $_REQUEST['key'];
$keyword	= $_REQUEST['keyword'];
$mode		= $_REQUEST['mode'];
$fid		= $_REQUEST['fid'];

if( !$fid )
{
	if( $ar_memprivc == 1 )	$fid = $ar_mempriv[0];
	else					$fid = $selectfid;
}

$cate	= $_REQUEST['cate'];
$page	= $_GET['page'];

if( !$page )	$page = 1;

$num_per_page	= 20;
$page_per_block	= 10;

//HTTP QUERY STRING
$qArr["num_per_page"]	= $num_per_page;
$qArr["page"]			= $page;
$qArr["code"]			= $code;
$qArr["sdate"]			= $sdate;
$qArr["edate"]			= $edate;
$qArr["showall"]		= $showall;
$qArr["cate"]			= $cate;
$qArr["key"]			= $key;
$qArr["keyword"]		= $keyword;

// 일반 검색일때
if( $mode == "" )
{
	if( $cate )
	{	$q	= "select [FIELD] from shop_goods_soldout,shop_goods,shop_goods_cate where shop_goods.index_no=shop_goods_soldout.goods_idx and shop_goods_cate.goods_idx=shop_goods_soldout.goods_idx and catecode='$cate'";	}
	else
	{	$q	= "select [FIELD] from shop_goods_soldout,shop_goods where shop_goods.index_no=shop_goods_soldout.goods_idx";	}

	if( $showall != 'Y' )
	{	
		$q	= $q . " and wdate_s>='$sdate'";	
		$q	= $q . " and wdate_s<='$edate'";
	}

	if( $keyword )
	{	$q	= $q . " and $key like '%$keyword%'";	}

	if( $fid )
	{	$q	= $q . " and fid='$fid'";		}

	//카운터쿼리
	$sql	= str_replace("[FIELD]", "count(shop_goods_soldout.index_no)", $q);
	$st = $pdo->prepare($sql);
	$st->execute();
	$total_record	= $st->rowCount();


	if( $total_record == 0 )
	{ 
		$first	= 0; 
		$last	= 0; 
	}
	else
	{ 
		$first	= $num_per_page * ( $page - 1 );  
		$last	= $num_per_page * $page; 
	}

	//데이터쿼리
	$q		= $q . " order by shop_goods_soldout.index_no desc limit $first, $num_per_page";
	$sql	= str_replace("[FIELD]", "shop_goods_soldout.*,gname,simg1,account", $q);

	$st = $pdo->prepare($sql);
	$st->execute();
	$article_num	= $total_record - (($page-1)*$num_per_page);
	while( $row = $st->fetch() )
	{	
		if( $row[op1] != '' )	$ar_ops1 = sel_query("shop_goods_op1","opname"," where index_no='$row[op1]'");
		if( $row[op2] != '' )	$ar_ops2 = sel_query("shop_goods_op2","opname"," where index_no='$row[op2]'");
		if( $row[op3] != '' )	$ar_ops3 = sel_query("shop_goods_op3","opname"," where index_no='$row[op3]'");

		$row["article_num"]	= $article_num;
		$row["ar_ops1"]		= $ar_ops1;
		$row["ar_ops2"]		= $ar_ops2;
		$row["ar_ops3"]		= $ar_ops3;
			
		$data[]	= $row;

		$article_num--;
	}
}
// 데이터 인크루드 종료
////////////////////////

if( $mode == 'd' )
{
	$index_no	= $_REQUEST['index_no'];
	$ar_goods	= sel_query_all("shop_goods_soldout"," where index_no='$index_no'");

	if( $ar_goods[otype] == '1' )
	{
		$q = "delete from shop_goods_soldout where goods_idx='$ar_goods[goods_idx]'";

		$st = $pdo->prepare($q);
		$st->execute();

		$value[isopen] = 2;
		update("shop_goods",$value," where index_no='$ar_goods[goods_idx]'");
		unset($value);


		$value[goods_idx]	= $ar_goods[goods_idx];
		$value[subject]		= "상품 재오픈";
		$value[memo]		= "상품 재오픈";
		$value[tocustom]	= "N";
		$value[wdate]		= $nowdate;
		$value[to_date]		= date("Y-m-d",$nowdate+(86400));
		$value[mem_idx]		= $memindex;
		$value[mem_name]	= $memname;
		insert("shop_goods_notice",$value);
		unset($value);
	}
	else
	{	
		$ar_ops1	= sel_query("shop_goods_op1","opname"," where index_no='$ar_goods[op1]'");
		$ar_ops2	= sel_query("shop_goods_op2","opname"," where index_no='$ar_goods[op2]'");
		$ar_ops3	= sel_query("shop_goods_op3","opname"," where index_no='$ar_goods[op3]'");


		$q = "delete from shop_goods_soldout where goods_idx='$ar_goods[goods_idx]' and op1='$ar_goods[op1]' and op2='$ar_goods[op2]' and op3='$ar_goods[op3]'";
		
		$st = $pdo->prepare($q);
		$st->execute();

		$value[goods_idx]	= $ar_goods[goods_idx];
		$value[memo]		= "상품 옵션 재오픈 $ar_ops1[opname] / $ar_ops2[opname] / $ar_ops3[opname]";
		$value[wdate]		= date("Y-m-d H:i:s",time());
		$value[mem_name]	= $memname;
		insert("shop_goods_log",$value);
		unset($value);
	}

	echo "<script>alert('삭제완료'); location.replace('$PHP_SELF?code=$code&cate=$cate&key=$key&keyword=$keyword&showall=$showall&sdate=$sdate&fid=$fid'); </script>";
	exit;
}
?>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
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
				<tr>
					<th> 품절일 </th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' class="form-control" name='sdate' size='10' value='<?=$sdate;?>' id='se_sdate' readonly> ~ 	<input type='text' class="form-control" name='edate' size='10' value='<?=$edate;?>' id='se_edate' readonly>
						<label><input type='checkbox' name='showall' value='Y' <? if($showall=='Y') { echo "checked";	}?>> 전체목록보기</label>
						</div>
					</td>
				</tr>
				<tr>
					<th>카테고리</th>
					<td>
						<select class="uch" name='cate'>
						<option value=''>소속메뉴</option>
<?php
$q = "SELECT * FROM shop_cate order by catecode";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	
{
	$se	= "";
	if( $row[catecode]==$cate )	
	{
		$se = "selected";	
	}

	$catecode_len	= strlen($row[catecode]);
	if( $catecode_len == 2 )	
	{
		$first	= $row[catename];
		echo "<option value='$row[catecode]' $se>$row[catename]</option>";
	}
	else if( $catecode_len == 4 )
	{
		$second	= $row[catename];
		echo "<option value='$row[catecode]' $se>$first > $row[catename]</option>";
	}
	else if( $catecode_len == 6 )	
	{
		echo "<option value='$row[catecode]' $se>$first > $second > $row[catename]</option>";	
	}
}
?>
						</select>
					</td>

					<th>기타조건</th>
					<td>
						<div class="form-inline">
						<select class="uch" name='key'>
							<option value='gname' <? if($key=='gname') { echo "selected"; } ?>>상품명</option>
						</select>
						<input type='text' class="form-control" name='keyword' value="<?=$keyword;?>" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }">
						</div>
					</tD>
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
				<h3><i class="fa fa-table"></i> 품절상품목록 (자동품절목록)</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>번호</th>
					<th>IMG</th>
					<th>상품명</th>
					<th>판매가격</th>
					<th>형태</th>
					<th>옵션</th>
					<th>품절등록일</th>
					<th></th>
					<th></th>
					<th>품절건수</th>
				</tr>
				</thead>
				<tbody>
<?php
$cou = 0;
for( $is = 0; $is < count($data); $is++ )
{
	$row	= $data[$is];

	$co		= "";
	if( !($cou % 2) ) $co	= "gray";
?>
				<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
					<td class="first"><?=$row["article_num"];?></td>
					<td><? if($row[simg1]!=''){?><a href="<?=$_defaultsite;?>/shop/view.php?index_no=<?=$row[goods_idx];?>" target="_blank"><img src="<?=$_imgserver;?>/files/goods/<?=$row[simg1];?>" width='50' border="0"></a><?}?></td>
					<td><a href="<?=$_defaultsite;?>/shop/view.php?index_no=<?=$row[goods_idx];?>" target="_blank"><?=$row[gname];?></a></td>
					<td><?=number_format($row[account]);?></td>		
					<tD><? if($row[otype]=='1') { echo "전체품절";	} else { echo "부분품절";	}?></td>
					<tD><? if($row[otype]=='2') { ?><? if($row[op1]!='') { echo $row["ar_ops1"][opname];	} ?><? if($row[op2]!='') { echo " / ".$row["ar_ops2"][opname];	} ?><? if($row[op3]!='') { echo " / ".$row["ar_ops3"][opname];	} ?><?}?></td>
					<td><?=$row[wdate_s];?></td>
					<Td><?=$row[ch_name];?></td>
					<td>
						<span class="btn_white_xs">
						<!--<? if($row[otype]=='1') { ?><a href="order.php?code=gsearchv&key=index_no&keyword=<?=$row[goods_idx];?>" target="_blank"><?	} else { ?><a href="order.php?code=gsearchv&goods_idx=<?=$row[goods_idx];?>&op1=<?=$row[op1];?>&op2=<?=$row[op2];?>&op3=<?=$row[op3];?>" target="_blank"><?	}?>주문확인</a>//-->
						<!--2018-01-04 김용남 : 어떤 링크인지 몰라 일단 주문리스트로 연결 해 놓음//-->
						<? if($row[otype]=='1') { ?><a href="<?=$PHP_SELF;?>?code=order_list&key=goods_idx&keyword=<?=$row[goods_idx];?>" target="_blank"><?	} else { ?><a href="<?=$PHP_SELF;?>?code=order_list&key=goods_idx&keyword=<?=$row[goods_idx];?>" target="_blank"><?	}?>주문확인</a>
						</span>
						<br>
						<span class="btn_white_xs"> 
						<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=d&index_no=<?=$row[index_no];?>&sdate=<?=$sdate;?>&edate=<?=$edate;?>&showall=<?=$showall;?>&fid=<?=$fid;?>&key=<?=$key;?>&keyword=<?=$keyword;?>','삭제?');">삭제</a>
						</span>
					</td>
					<td>
					<?php
						$q2		= "select shop_newmarketdb.* from shop_newmarketdb,shop_newbasket where shop_newmarketdb.index_no=shop_newbasket.market_idx and goods_idx='$row[goods_idx]' and op1='$row[op1]' and op2='$row[op2]' and op3='$row[op3]' and dan>='2' and dan<='4' and gonumber='' and pdan=''";
						$st2 = $pdo->prepare($q2);
						$st2->execute();
						$isit2	= $st2->rowCount();

						echo $isit2;
					?>
					</td>
				</tr>
<?php
	$cou++;
}
?>
				</tbody>
				</table>

				
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $num_per_page, $page_per_block, $qArr);?>
					</ul>
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