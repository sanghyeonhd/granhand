<?php	include "./common/goods_list_q.php";	?>
<?php	include "./common/goods_search.php";	?>
<?php
$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "";
if($mode=='start')	{
	
	$value['isopen'] = "2";
	$value['isshow'] = "Y";
	$value['opendate'] = date("Y-m-d H:i:s");
	update("shop_goods",$value," WHERE 'idx'='$'idx''");

	show_message("설정완료","");
	move_link("$PHP_SELF?code=$code");
	exit;
}
?>
<script>

function set_chk(obj)	{
	
	if($(obj).is(":checked"))	{
		$(".index").prop("checked",true);
	}
	else	{
		$(".index").prop("checked",false);
	}

}
function f_set_ss()	{
	
	MM_openBrWindow('','changess','width=600,height=600,scrollbars=no');
	document.listform.action = 'popup.php?code=goods_setss';
	document.listform.target = 'changess';
	document.listform.submit();
}
function f_set_del()	{
	
	MM_openBrWindow('','dels','width=600,height=600,scrollbars=no');
	document.listform.action = 'popup.php?code=goods_dels';
	document.listform.target = 'dels';
	document.listform.submit();
	
}
function f_set_cate()	{
	
	MM_openBrWindow('','modcate','width=1000,height=600,scrollbars=no');
	document.listform.action = 'popup.php?code=goods_catemod';
	document.listform.target = 'modcate';
	document.listform.submit();
	
}
function edit_cates(idx)	{
	
	MM_openBrWindow('popup.php?code=goods_catemods&'idx'='+idx,'dels','width=1100,height=800,scrollbars=no');
	return;
	var gourl = 'get_goods_cate';
	var params = "'idx'="+idx;
	var title = '상품카테고리수정';
	

	$.ajax({
		type:'POST',
		url:'/ajaxmo/goods.php?act='+gourl,
		data:params,
		datatype:'html',
		success:function(resultdata){

			layer_open('pop',title,true,true);
			$("#pop_cont").html(resultdata);
		},
		error:function(e){
			alert(e.responseText);
		}
	});
}
function set_cates(idx,cate_idx,mode)	{
	
	if(mode=='d')	{

		var answer = confirm('삭제하시겠습니까?');
		if(answer==true)	{
			$.getJSON('/ajaxmo/goods.php?act=set_goods_cate&'idx'='+idx+'&cate_idx='+cate_idx+'&mode='+mode, function(result){ 
			
				if(result.res=='ok')	{
					alert('삭제하였습니다.');
					edit_cates(idx);
				}
				else	{
					alert(result.resmsg);
				}

			});
		}
	}
	if(mode=='w')	{
			var param = $("#regiforms").serialize();
			$.getJSON('/ajaxmo/goods.php?act=set_goods_cate&mode='+mode+'&'+param, function(result){ 
			
				if(result.res=='ok')	{
					alert('등록하였습니다.');
					edit_cates(idx);
				}
				else	{
					alert(result.resmsg);
				}

			});
	}
}
function layer_open(el, title, btn_clsoe, bg_close){
	if ( 'undefined' == typeof(title)) title = "POPUP";
	if ( 'undefined' == typeof(btn_clsoe)) btn_clsoe = true;
	if ( 'undefined' == typeof(bg_close)) bg_close = true;

	var temp = $('#' + el);		//레이어의 id를 temp변수에 저장
	var bg = temp.prev().hasClass('pop_bg');	//dimmed 레이어를 감지하기 위한 boolean 변수

	//팝업 제목 설정
	temp.find('.pop_title h1').html(title);

	if(bg){
		$('.pop_wrap').fadeIn(0);
	}else{
		temp.fadeIn();	//bg 클래스가 없으면 일반레이어로 실행한다.
	}
	

	// 화면의 중앙에 레이어를 띄운다.
	if (temp.outerHeight() < $(document).height() ) temp.css('margin-top', '-'+temp.outerHeight()/2+'px');
	else temp.css('top', '0px');
	if (temp.outerWidth() < $(document).width() ) temp.css('margin-left', '-'+temp.outerWidth()/2+'px');
	else temp.css('left', '0px');

	if ( btn_clsoe ) {
		temp.find('a.btn_close').click(function(e){
			if(bg){
				$('.pop_wrap').fadeOut(0);
			}else{
				temp.fadeOut(0);		//'닫기'버튼을 클릭하면 레이어가 사라진다.
			}
			e.preventDefault();
		});
	} else {
		temp.find('a.btn_close').hide();
	}

	if ( bg_close ) {
		$('.pop_wrap .pop_bg').click(function(e){
			$('.pop_wrap').fadeOut(0);
			e.preventDefault();
		});
	}
}
</script>
<style>
/* layer popup */
.pop_wrap {display:none;position:fixed;left:0;top:0;width:100%;height:100%;z-index:100}
.pop_bg {position:absolute;left:0;top:0;width:100%;height:100%;background-color:rgba(0, 0, 0,0.4); 	}
.pop_window {display:block;position:absolute;left:50%;top:50%;width:500px;/* margin-left:-250px; */background-color:#f8f8f8}
.pop_title {position:relative;height:36px;padding-left:12px;background-color:#333;color:#fff;font-size:20px;font-weight:bold;line-height:36px}
.pop_title h1 {float:left;height:36px;line-height:36px;font-size:12px;font-weight:bold;letter-spacing:0}
.pop_title .btn_close {position:absolute;right:10px;top:8px;width:20px;height:20px;background:url('../images/btn_pop_close.png') no-repeat 0 0;font-size:0;line-height:0}
.pop_content {padding:15px}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품목록 - 총 : <?=number_format($total_record);?>개 검색</h3>
			</div>
			<div class="panel-content">
				<div class="m-t-10 m-b-10 no-print"> 
					<a href="#none" onclick="f_set_ss();" class="btn btn-xs btn-primary m-r-10 m-b-10">상품진열상태수정</a>
					<a href="#none" onclick="f_set_del();" class="btn btn-xs btn-primary m-r-10 m-b-10">선택상품삭제</a>
					<a href="#none" onclick="f_set_cate();" class="btn btn-xs btn-primary m-r-10 m-b-10">선택상품카테고리관리</a>

					<a href="#none" onclick="" class="btn btn-xs btn-primary m-r-10 m-b-10">일괄타사연동</a>

					<a href="#none" onclick="" class="btn btn-xs btn-primary m-r-10 m-b-10">체크하목연동</a>
				</div>
				<form name="listform" id="listform" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="50px;">
				</colgroup>
				<thead>
				<tr>
					<th><input type='checkbox' onclick="set_chk(this);"></th>
					<th> 번호 </th>
					<th> IMG </th>
					<th> 상품명 </th>
					
					<th> 노출분류 </th>
					
					<th> 판매가격 </th>
					<th> 판매여부 </th>
					<th> 등록일 </th>
					<th> 거래처 </th>
					<th>조회</th>
					<th>주문</th>
					<th>담기</th>
					<th>관심</th>
					<th>문의</th>
					<th>리뷰</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?
				$cou = 0;
				for($is=0;$is<count($data);$is++){
					$row = $data[$is];
					
					$qs = "select * from shop_goods_imgs where goods_idx='$row[idx]' order by idx asc";
					$sts = $pdo->prepare($qs);
					$sts->execute();
					
					

				?>
				<tr class='<?=$co;?>'>
					<td class="first"><input type='checkbox' name='index[]' class="index" value='<?=$row['idx'];?>'></td>
					<td><?=$row['idx'];?></td>
					<td>
						<?
						if($sts->rowCount() != 0)	{
							$rows = $sts->fetch();
						?>
							<img src="<?=$_imgserver;?>/goods/<?=$rows['filename'];?>" style="width:60px;">
						<?}?>
					</td>
					<Td>
						<?php if($row['gtype']=='1') { echo "[일반상품]";	} ?>
						<?php if($row['gtype']=='2') { echo "[세트상품]";	} ?><br />
						<a href="http://www.granhand.kro.kr/shop/?act=view&idx=<?=$row['idx'];?>" target="_BLANMK"><?=$row['gname'];?></a>
					</td>
					
					
					<td  style='text-align:left;font-size:11px;padding-left:10px;'>
						<p><a href="javascript:edit_cates('<?=$row['idx'];?>');"  class="btn btn-xs btn-primary">수정</a></p>
						<?php
						$qs = "Select distinct(catecode) as catecode from shop_goods_cate WHERE goods_idx='$row[idx]' order by catecode asc";
						$sts = $pdo->prepare($qs);
						$sts->execute();
						while($rows = $sts->fetch())	{
							for($i=0;$i<strlen($rows['catecode']);$i=$i+2)	{
								$ar_cate = sel_query_all("shop_cate"," WHERE catecode='".substr($rows['catecode'],0,($i+2))."'");
								if($i!=0)	{
									echo " > ";	
								}
								echo $ar_cate['catename'];
							}
							echo "</p>";	
						}
						?>

					</td>
					<td style='text-align:right;'>
						<? if($row['saccount']!=0){?><strike><?=number_format($row['saccount']/100);?></strike><Br><?}?>
						<?=number_format($row['account']/100);?>원
					</td>
					<td style="font-size:13px;">
						<span style="color:red">
						<? if($row['isopen']=='2') { echo "<font color='blue'>";	} ?><?=$g_ar_isdan[$row['isopen']];?><? if($row['isopen']=='2') { echo "</font>";	}?><br /><br />
						</span>
						<span  style="color:red">
						<? if($row['isshow']=='Y') { echo "<font color='blue'>";	} ?><?=$g_ar_isshow[$row['isshow']];?><? if($row['isopen']=='Y') { echo "</font>";	}?>	
						</span>
					</td>
					<td><?=substr($row['regi_date'],0,10);?><br><br><? if($row['isopen']!='1') { echo substr($row['opendate'],0,10);	}?></td>
					<td>
						<?
						if($row['in_idx']!=0)	{
							$ar_shops = sel_query_all("shop_goods_shops"," WHERE 'idx'='$row[in_idx]'");
							echo $ar_shops['name'];
						}	
						?>
					</tD>
					<Td>0</td>
					<Td>0</tD>
					<TD>0</td>
					<td>0</td>
					<td>0</td>
					<td>
						<?php
						$qs = "Select 'idx' from shop_after where goods_idx='$row[idx]'";
						$sts = $pdo->prepare($qs);
						$sts->execute();
						echo number_format($sts->rowCount());
						?>
					</td>
					<td>
						<a target="blank" href="<?=$PHP_SELF;?>?code=goods_mod1&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary" style="margin-bottom:10px;">수정</a><br />
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=goods_copy&'idx'=<?=$row['idx'];?>','copy','width=600,height=600,scrollbars=no');" class="btn btn-xs btn-primary">복사</a>
						
					</td>
				</tr>
				
				<?
				}
				?>
				</tbody>
				</table>
				</form>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $se_numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="pop_wrap" style="display: none;">
	<div class="pop_bg"></div>
	<div class="pop_window_wide" id="pop" style='display: block;position: absolute;left: 50%;top: 50%;width: 1024px;height: 800px;background-color: #f8f8f8;overflow-y:scroll'>
		<div class="pop_title">
			<h1><!-- 팝업타이틀 --></h1>
			<a href="#" class="btn_close">닫기</a>
		</div>
		<div id="pop_cont" style='margin:10px;'>
			
		</div>
	</div>
</div>