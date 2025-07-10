<?php
$mode = $_REQUEST['mode'];
$index_no = $_REQUEST['index_no'];
$key = $_REQUEST['key'];
$keyword = $_REQUEST['keyword'];
$page = $_REQUEST['page'];
$sb = $_REQUEST['sb'];
$isanswer = $_REQUEST['isanswer'];
$sre = $_REQUEST['sre'];
$ar_data = sel_query_all("shop_qna"," where index_no='$index_no'");
$ar_qna_c = sel_query_all("shop_qna_config"," where fid='$ar_data[fid]'");
$rmode = $_REQUEST['rmode'];
$fid = $_REQUEST['fid'];
if($mode=='d')
{
	$q = "select * from shop_qna where index_no=$index_no";
	$st = $pdo->prepare($q);
	$st -> execute();
	$ar_data = $st->fetch();

	$q = "update shop_qna set isdel='Y',delname='$memname' where index_no='$index_no'";
	$st = $pdo->prepare($q);
	$st -> execute();


	echo "<script>alert('삭제하였습니다.'); location.replace('$PHP_SELF?code=help_qna&page=$page&key=$key&keyword=$keyword&sb=$sb&isanswer=$isanswer&sre=$sre&fid=$fid'); </script>";
	exit;

}

if($mode=='w')
{
	$value[resultwriter] = $_POST['resultwriter'];
	$value[result] = "Y";
	$value[resultmemo] = $_POST['resultmemo'];
	$value[resultdate] = date("Y-m-d H:i:s",time());

	$r = update("shop_qna",$value," where index_no='$index_no'");
	unset($value);

	$value[resultwriter] = $_POST['resultwriter'];
	$value[result] = "Y";
	$value[resultmemo] = "답변완료";
	$value[resultdate] = date("Y-m-d H:i:s",time());
	$r = update("shop_qna",$value," where fid='$ar_data[fid]' and isjak='Y' and result!='Y'");
	unset($value);

	$mun = $_REQUEST['mun'];

	if($mun=='1')
	{
		$ar_kinit = sel_query_all("shop_config"," where fid='$ar_data[fid]' order by index_no asc limit 0,1");
		$msg = $ar_data[mem_name]."님 질문에 대한 답변이 달렸습니다. $ar_qna_c[qna_url]/center/?i=$index_no";	
		$cp = $ar_data[cp];
		$return = $ar_kinit[site_phone];

		//gotosms($cp,$return,$msg);
	}

	if($mun=='2')
	{
		if($ar_qna_c[qna_uselms]=='1')
		{
			$ar_kinit = sel_query_all("shop_config"," where fid='$ar_data[fid]' order by index_no asc limit 0,1");
			$msg = $ar_data[mem_name]."님 질문에 대한 답변이 달렸습니다. $ar_qna_c[qna_url]/center/?i=$index_no";	
			$cp = $ar_data[cp];
			$return = $ar_kinit[site_phone];

			//gotosms($cp,$return,$msg,"",true);
		}
		if($ar_qna_c[qna_uselms]=='2')
		{
			$ar_kinit = sel_query_all("shop_config"," where fid='$ar_data[fid]' order by index_no asc limit 0,1");
			$msg = $ar_data[mem_name]."님 질문에 대한 답변이 달렸습니다. \n\r ".$_POST['resultmemo'];	
			$cp = $ar_data[cp];
			$return = $ar_kinit[site_phone];

			//gotosms($cp,$return,$msg,"",true);
		}
	}
	
	show_message("답변완료","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;


}
?>
<?php

?>
		<!-- 장바구니 -->
	<br>
	<script language="javascript">
function delok(url)
{
	answer = confirm('삭제하시겠습니까?');
	if(answer==true)
	{	location.href=url;	}
}
</script>
<script language="javascript">
function foch()
{
	if(!document.wform.resultmemo.value)
	{
		alert('답변내용을 작성 하세요');
		document.wform.resultmemo.focus();
		return false;
	}
	return true;
}
function set_emo()
{
	//alert($('#temp option:selected').val());
	if($('#temp option:selected').val()!='')
	{
		var param = "temp="+$('#temp option:selected').val()+"&name=<?=$ar_data[mem_name];?>";
		$.ajax({
		type:"GET",
		url:"./ajaxmo/get_qna_templete.php",
		dataType: "html",   
		data:param,
		success:function(msg){
			//alert(msg);
			$("#resultmemo").val(msg);
		}
		});
	}
}
</script>
<Script language="javascript">
function imgview(img)
{
	 window.open("imgviewer.php?img="+img,"img",'width=150,height=150,status=no,top=0,left=0,scrollbars=yes');
}
</script>

<?php
if($ar_data[mem_idx]!=0)
{
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> <?=$ar_data[mem_name];?>고객 주문내역</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
			<thead>
			<Tr>
			<th class=kor8>No</th>
			<th class=kor8>주문번호</th>
			<th class=kor8>주문일</th>
			
			<th class=kor8>결제금액</th>
			<th class=kor8>단계</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$qss = "select * from shop_newmarketdb where dan!='' and mem_idx='$ar_data[mem_idx]' order by index_no desc limit 0,10";	
			$stss = $pdo->prepare($qss);
			$stss -> execute();
			while($ar_datass = $stss->fetch())
			{
				
			?>
			<tr onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
			<td class="first"><?=$ar_datass[index_no];?></td>
			<td><a href="javascript:MM_openBrWindow('popup.php?code=order_nview&index_no=<?=$ar_datass[index_no];?>','order<?=$ar_datass[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=date("Ymd",$ar_datass[orderno]);?>-<?=$ar_datass[index_no];?></a></td>
			<td><?=$ar_datass[sdate];?></td>
			<td><?=number_format($ar_datass[use_account]/100);?></td>
			<td>
				<?php
					switch ($ar_datass[dan]){
						case 1 : echo "  <span class='btn_white_xs btn_white'><a>주문접수</a></span>  "; break;
						case 2 : echo "  <span class='btn_white_xs btn_red'><a>결제확인</a></span>  "; break;
						case 3 : echo "  <span class='btn_white_xs btn_yellow'><a>상품준비중</a></span>  "; break;
						case 4 : echo "  <span class='btn_white_xs btn_navy'><a>부분배송</a></span>  "; break;
						case 5 : echo "  <span class='btn_white_xs btn_blue'><a>배송중</a></span>  "; break;
						case 6 : echo "  <span class='btn_white_xs btn_emerald'><a>거래완료</a></span>  "; break;
						case 7 : echo "  <span class='btn_white_xs btn_orange'><a><반품완료</a></span>  "; break;
						case 8 : echo "  <span class='btn_white_xs btn_pink'><a>주문취소</a></span>  "; break;
					}

				?>
				</td>
			</tr>
			<?php
			}
			?>
			</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
<?php
}	else	{
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> <?=$ar_data[mem_name];?>고객 비회원 주문내역 추천</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
			<thead>
			<tr>
			<th class=kor8>No</th>
			<th class=kor8>주문번호</th>
			<th class=kor8>주문일</th>
			<th class=kor8>결제금액</th>
			<th class=kor8>단계</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$qss = "select index_no,orderno,name,jumin2,sdate,use_account,buymethod,dan from shop_newmarketdb where dan!='' and name='$ar_data[mem_name]' and fid='$ar_data[fid]' order by index_no desc limit 0,10";	
			$stss = $pdo->prepare($qss);
			$stss -> execute();
			while($ar_datass = $stss->fetch())
			{
				$co = "";
				if(!($cou%2)) $co = "gray";
			?>
			<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
			<td class="first"><?=$ar_datass[index_no];?></td>
			<td><a href="javascript:MM_openBrWindow('popup.php?code=order_nview&index_no=<?=$ar_datass[index_no];?>','order<?=$ar_datass[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=date("Ymd",$ar_datass[orderno]);?>-<?=$ar_datass[index_no];?></a></td>
			<td><?=$ar_datass[sdate];?></td>
			<td><?=number_format($ar_datass[use_account]);?></td>
			<td>
				<?php
					switch ($ar_datass[dan]){
						case 1 : echo "  <span class='btn_white_xs btn_white'><a>주문접수</a></span>  "; break;
						case 2 : echo "  <span class='btn_white_xs btn_red'><a>결제확인</a></span>  "; break;
						case 3 : echo "  <span class='btn_white_xs btn_yellow'><a>상품준비중</a></span>  "; break;
						case 4 : echo "  <span class='btn_white_xs btn_navy'><a>부분배송</a></span>  "; break;
						case 5 : echo "  <span class='btn_white_xs btn_blue'><a>배송중</a></span>  "; break;
						case 6 : echo "  <span class='btn_white_xs btn_emerald'><a>거래완료</a></span>  "; break;
						case 7 : echo "  <span class='btn_white_xs btn_orange'><a><반품완료</a></span>  "; break;
						case 8 : echo "  <span class='btn_white_xs btn_pink'><a>주문취소</a></span>  "; break;
					}

				?>
			</td>
			</tr>
			<?php
				$cou++;
			}
			?>
			</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
<?}?>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> <?=$ar_data[mem_name];?>고객 질문내용</h3>
			</div>
			<div class="panel-content">
	
<?php
if($ar_data[mem_idx]==0)
{	$pop = "<a href=\"javascript:alert('비회원');\">";	}
else
{	$pop = "<a href=\"javascript:MM_openBrWindow('popup.php?code=help_view&index_no=$ar_data[mem_idx]','member${ar_data[mem_idx]}','scrollbars=yes,width=1150,height=900,top=0,left=0');\">";	}

if($ar_data[orderno]!='')
{	$ar_or = sel_query("shop_marketdb"," where orderno='$ar_data[orderno]'");	}
?>
<table class="table table-bordered">	
<tr>
<th>질문처 </th>
<td><?=$ar_sites[$ar_data[pid]];?></td>
</tr>
<tr>
<th>작성자 </th>
<td><?=$pop;?><?=$ar_data[mem_name];?></a> <? if($ar_data[mem_idx]==0) { echo "[비회원]";	}?></td>
</tr>
<tr>
<th>제 목</th>
<td><?=$ar_data[subject];?></td>
</tr>
<tr>
<th>관련주문</th>
<td><a href="order.php?code=view&index_no=<?=$ar_or[index_no];?>" target="_BLANK"><?=$ar_data[orderno];?></a></td>
</tr>
<tr>
<th>작성일</th>
<td><?=$ar_data[wdate];?></td>
</tr>
<tr>
<th>연락처</th>
<td><?=$ar_data[cp];?></td>
</tr>
<?php
if($ar_data[goods_idx]!='0')
{
?>
<tr>
<th>문의상품</th>
<td><?

			$ar_goods = sel_query("shop_goods","gname"," WHERE index_no='$ar_data[goods_idx]'");
			echo "<a href='/shop/view.php?index_no=$ar_data[goods_idx]' target='_blank'>$ar_goods[gname]</a>";
			?></td>
</tr>
<?php
}
?>



<tr>
<th>내용</th>
<td style="padding:5px;">
<?=nl2br($ar_data[memo]);?>
</td>
</tr>

<tr>
<th>첨부파일1</th>
<td>
<a href="<?=$_imgserver;?>/files/qna/<?=$index_no;?>/<?=$ar_data[file1];?>" target="_BLANK"><?=$ar_data[file1];?></a>
</td>
</tr>

<tr>
<th>첨부파일2</th>
<td>
<a href="<?=$_imgserver;?>/files/qna/<?=$index_no;?>/<?=$ar_data[file2];?>" target="_BLANK"><?=$ar_data[file2];?></a>
</td>
</tr>

</table>
<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" onclick="location.href='<?=$PHP_SELF;?>?code=help_<? if($rmode){?>myqna<?}else{?>qna<?}?>&key=<?=$key;?>&keyword=<?=$keyword;?>&page=<?=$page;?>&sb=<?=$sb;?>&isanswer=<?=$isanswer;?>&sre=<?=$sre;?>';">목록으로</button>
					
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&index_no=<?=$index_no;?>&page=<?=$page;?>&key=<?=$key;?>&keyword=<?=$keyword;?>&mode=d&sb=<?=$sb;?>&isanswer=<?=$isanswer;?>','삭제?');">삭제</button>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

<?php
if($ar_data[btype]=='2')
{
?>


<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록된 답변내용입니다.</h3>
			</div>
			<div class="panel-content">

<form id="wform" name="wform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return foch();">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='index_no' value='<?=$index_no;?>'>
<input type='hidden' name='page' value='<?=$page;?>'>
<input type='hidden' name='key' value='<?=$key;?>'>
<input type='hidden' name='keyword' value='<?=$keyword;?>'>		
<input type='hidden' name='sb' value='<?=$sb;?>'>	
<input type='hidden' name='isanswer' value='<?=$isanswer;?>'>	
<input type='hidden' name='sre' value='<?=$sre;?>'>	
<input type='hidden' name='rmode' value='<?=$rmode;?>'>
<input type='hidden' name='fid' value='<?=$fid;?>'>

<table class="table table-bordered">
<tr>
<th>답변자</th>
<td>
<input type='text' name='resultwriter' class="form-control" value="<? if($ar_data[result]=='Y') { echo $ar_data[resultwriter]; } else { echo $g_memname; } ?>" <? if($ar_data[result]=='Y' && $row[resultwriter]!='') { echo "readonly"; }?>>
<? if($ar_data[result]=='D') { ?><p>현재 답변중인 질문입니다. 중복으로 처리하는 사항을 주의 하기 바랍니다</p><?}?>
</td>
</tr>
<tr>
<th>답변일</th>
<td><? if($ar_data[result]=='Y') { echo $ar_data[resultdate];	}?>
</td>
</tr>
<tr>
<th>템플릿선택</th>
<td><select class="uch" name='tem' id='temp' onchange="set_emo();">
<option value=''>템플릿선택</option>
<?php
$q = "select * from shop_qna_templete where fid='$ar_data[fid]' and mem_idx IN ('0','$memindex')";
$q = $q ." order by subject asc";
$st = $pdo->prepare($q);
$st -> execute();

while($row = $st->fetch())
	{
		if($row[mem_idx]==0)
		{	echo "<option value='$row[index_no]'>[공통] $row[subject]</option>";	}
		else
		{	echo "<option value='$row[index_no]'>[개인] $row[subject]</option>";	}
	}
?>
</select>
</td>
</tr>
<?
if($ar_data[result]!='Y')
{
?>
<tr>
<th>문자전송</th>
<td><? if($ar_qna_c[qna_usesms]=='Y') {?><input type='radio' name='mun' value='1'>SMS로 전송<?}?><? if($ar_qna_c[qna_uselms]!='') {?><input type='radio' name='mun' value='2'>LMS로 전송<?}?>
</td>
</tr>
<?
}
?>
<tr>
<th>답변내용</th>
<td><textarea class="form-control" name=resultmemo id="resultmemo" cols='90' rows='18' style="ime-mode:active"/><?=$ar_data[resultmemo];?></textarea>
</td>
</tr>
</table>
<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#wform">답변등록</button>
						
				</div>
			</div>


</form>
			</div>
		</div>
	</div>
</div>


<?}?>
<?php
if($ar_data[mem_idx]!=0)
{
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> <?=$ar_data[mem_name];?> 고객 다른 질문과답</h3>
			</div>
			<div class="panel-content">



			</div>
		</div>
	</div>
</div>
<?}?>
