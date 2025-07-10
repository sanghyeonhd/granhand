<?php
$tmp_idx = time();
$ar_goods_config = sel_query_all("shop_config_goods"," where 1");
$mode = "";
if(isset($_REQUEST['mode'])){
	$mode = $_REQUEST['mode'];	
}

if($mode=='w')	{

	foreach($_REQUEST AS $key => $val)	{
		
		if(!is_array($_REQUEST[$key]))	{

			$_REQUEST[$key] = addslashes(trim($val));
		}
	}
	
	$value['gtype'] = $_REQUEST['gtype'];
	$gtype = $value['gtype'];
	$value['in_idx'] = $_REQUEST['in_idx'];
	$value['gcode'] = $_REQUEST['gcode'];
	$value['gname'] = $_REQUEST['gname'];
	$value['gname_head'] = $_REQUEST['gname_head'];
	$value['gname_foot'] = $_REQUEST['gname_foot'];
	$value['md_idx'] = $_REQUEST['md_idx'];
	$value['gname_pre'] = $_REQUEST['gname_pre'];
	$value['custom_memo'] = $_REQUEST['custom_memo'];
	$value['buytype'] = $_REQUEST['buytype'];
	$value['can_op'] = $_REQUEST['can_op'] ?? "";
	
	$account = isset($_REQUEST['account']) ? intval($_REQUEST['account']) : 0;
	$value['account'] = $account * 100;
	
	$saccount = isset($_REQUEST['saccount']) ? intval($_REQUEST['saccount']) : 0;
	$value['saccount'] = $saccount * 100;
	
	$account_over = isset($_REQUEST['account_over']) ? intval($_REQUEST['account_over']) : 0;
	$value['account_over'] = $account_over * 100;
	
	$saccount_over = isset($_REQUEST['saccount_over']) ? intval($_REQUEST['saccount_over']) : 0;
	$value['saccount_over'] = $saccount_over * 100;

	$account_b2b = isset($_REQUEST['account_b2b']) ? intval($_REQUEST['account_b2b']) : 0;
	$value['account_b2b'] = $account_b2b * 100;
	
	$account_off = isset($_REQUEST['account_off']) ? intval($_REQUEST['account_off']) : 0;
	$value['account_off'] = $account_off * 100;
	

	$value['pointper'] = $_REQUEST['pointper'];
	if($value['pointper']=='1')	{
		$value['point'] = $_REQUEST['saveper'];
	}
	if($value['pointper']=='2')	{
		$value['point'] = $_REQUEST['points'];
	}
	$value['pointmemo'] = $_REQUEST['pointmemo'];
	$value['admin_memo'] = $_REQUEST['admin_memo'];
	$value['weight'] = $_REQUEST['weight'];
	$value['ismake'] = $_REQUEST['ismake'];
	$value['istoday'] = $_REQUEST['istoday'] ?? "";
	$value['delno'] = $_REQUEST['delno'] ?? "";
	$value['deltype'] = $_REQUEST['deltype'];
	$value['search_keyword'] = $_REQUEST['search_keyword'];
	$value['gdname'] = $_REQUEST['gdname'];
	$value['daccount'] = $_REQUEST['daccount'];
	$value['sbj_idx'] = $_REQUEST['sbj_idx'];
	$value['sbj_per'] = $_REQUEST['sbj_per'] ?? "";
	$value['brand_idx'] = $_REQUEST['brand_idx'];
	$value['maker_idx'] = $_REQUEST['maker_idx'];

	$value['memo'] = $_REQUEST['memo'];
	if(isset($_REQUEST['icons']))	{
		$value['icons'] = implode("|R|",$_REQUEST['icons']);	
	}
	
	$value['fid'] = "1";
	if(isset($_REQUEST['listimgcolor']))	{
		$value['listimgcolor'] = implode(",",$_REQUEST['listimgcolor']);
		$listimgcolor = $value['listimgcolor'];	
	}
	
	$value['itemcate'] = $_REQUEST['itemcate'];
	$value['selldan'] = $_REQUEST['selldan'];
	$value['minbuy'] = $_REQUEST['minbuy'];
	$value['buylimits'] = $_REQUEST['buylimits'];
	$value['openstr'] = $_REQUEST['openstr'];

	

	$value['moviesite'] = $_REQUEST['moviesite'] ?? "";
	$value['movie'] = $_REQUEST['movie'] ?? "";


	$value['isopen'] = $_REQUEST['isopen'];
	$value['isshow'] = $_REQUEST['isshow'];
	if($value['isopen']=='2')	{
		$value['opendate'] = date("Y-m-d H:i:s");
	}
	$value['regi_date'] = date("Y-m-d H:i:s");
	$value['isok'] = "Y";

	for($i=1;$i<4;$i++)	{
		$value['opname'.$i] = $_REQUEST['opname'.$i];
		if($value['opname'.$i]!='')	{
			$value['useop'.$i] = "Y";
		}
	}
 	$value['smemo_type'] = $_REQUEST['smemo_type'];
	$r = insert("shop_goods",$value);
	unset($value);
	if(!$r)	{
		show_message("상품등록에 실패하였습니다.");
		exit;
	}
	$idx = $pdo->lastInsertId();
	
	$tmp_idx = $_REQUEST['tmp_idx'];
	
	$value['goods_idx'] = $idx;
	update("shop_goods_imgs",$value," where tmp_idx='$tmp_idx'");
	unset($value);
	

	if($gtype=='1')	{
		if(isset($_REQUEST['listimgcolor']))	{
			$ar_color = explode(",",$listimgcolor);
			for($i=0;$i<sizeof($ar_color);$i++)	{

				if($ar_color[$i] && $ar_color[$i]!='')	{
					$value['goods_idx'] = $idx;
					$value['color_idx'] = $ar_color[$i];
					insert("shop_goods_color",$value);
					unset($value);
				}
			}	
		}
		
	
		for($i=1;$i<4;$i++)	{
		
			if(isset($_REQUEST['opstr'.$i]))	{
				$tmp_ops = explode(",",$_REQUEST['opstr'.$i]);
	
				for($j=0;$j<sizeof($tmp_ops);$j++)	{
				
					if($tmp_ops[$j]!='')	{
					
						$value['goods_idx'] = $idx;
						$value['opname'] = trim($tmp_ops[$j]);
						$value['isuse'] = "Y";
						insert("shop_goods_op".$i,$value);
						unset($value);
					}
	
				}
			}
	
		}
	}	

	if($gtype=='2')	{
		$set_goods_idx = $_REQUEST['set_goods_idx'];
		$set_op1 = $_REQUEST['set_op1'];
		$set_op2 = $_REQUEST['set_op2'];
		$set_op3 = $_REQUEST['set_op3'];
		$set_ea = $_REQUEST['set_ea'];

		for($i=0;$i<sizeof($set_goods_idx);$i++)	{
			$value['sets_idx'] = $idx;
			$value['goods_idx'] = $set_goods_idx[$i];
			$value['op1'] = $set_op1[$i];
			$value['op2'] = $set_op2[$i];
			$value['op3'] = $set_op3[$i];
			$value['ea'] = $set_ea[$i];
			//insert("shop_goods_sets",$value);
			unset($value);
		}

	}
	

	$showsite = $_REQUEST['showsite'];

	
	for($i=0;$i<sizeof($showsite);$i++)	{
	
			$value['goods_idx'] = $idx;
			$value['pid'] = $showsite[$i];
			insert("shop_goods_showsite",$value);
			unset($value);
	}
	
	
	if(isset($_REQUEST['catestr'])){
		$catestr = $_REQUEST['catestr'];
		$ar_cates = explode("|R|",$catestr);
		for($i=0;$i<sizeof($ar_cates);$i++){
			if($ar_cates[$i]!=''){
				for($j=2;$j<=strlen($ar_cates[$i]);$j=$j+2){
					$cate = substr($ar_cates[$i],0,$j);

					$q = "select * from shop_goods_cate where goods_idx='$idx' and catecode='$cate'";
					$st = $pdo->prepare($q);
					$st->execute();
					$isit = $st->rowCount();

					if($isit==0)	{
						$qs = "update shop_goods_cate set orders=(orders+1) where catecode='$cate'";

						$st = $pdo->prepare($qs);
						$st->execute();
						$value['catecode'] = $cate;
						$value['goods_idx'] = $idx;
						$value['orders'] = 1;
						insert("shop_goods_cate",$value);
						unset($value);
					}
				}
			}
		}	
	}

	
	if(isset($_REQUEST['noti_idx']) && isset($_REQUEST['noti_name']) && isset($_REQUEST['noti_data'])){
		$noti_idx = $_REQUEST['noti_idx'];
		$noti_name = $_REQUEST['noti_name'];
		$noti_data = $_REQUEST['noti_data'];

		for($i=0;$i<sizeof($noti_idx);$i++)	{
			
			$value['goods_idx'] = $idx;
			$value['idx'] = $noti_idx[$i];
			$value['name'] = $noti_name[$i];
			$value['data'] = $noti_data[$i];
			insert("shop_goods_addinfo",$value);
			unset($value);

		}	
	}

	

	$q = "select * from shop_config_curr";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{

		if($row['isbasic']=='Y')	{
			continue;
		}
		if($_REQUEST['account_'.$row['name']])	{
			$value['goods_idx'] = $idx;
			$value['stype'] = $row['name'];
			$value['account'] = $_REQUEST['account_'.$row['name']]*100;
			insert("shop_goods_account",$value);
			unset($value);
		}
	}

	if($gtype=='2')	{
		show_message("등록완료 세트구성을 완료해주세요","");
		move_link("$PHP_SELF?code=goods_modsets&idx=$idx");
		exit;
	}
	else	{
		show_message("등록완료","");
		move_link("$PHP_SELF?code=goods_list");
		exit;

	}
		
}

?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('상품등록 하시겠습니까?');
		if(answer==true)	{
			var catestr = '';
			$("#search_menu > span").each(function()	{
		
				catestr = catestr + $(this).attr("dataattr") + '|R|';
		
			});
			$("#catestr").val(catestr);
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
function search_cate()	{

	var text = '';
	var cate = '';
	var thishtml = '';
	var isok = "Y";

	for(var i=1;i<5;i++)	{
		if($("#id_cate"+i+" option:selected").val()!='')	{
			isgo = "Y";
			if(text!='')	{
				text = text + " > ";
			}
			text = text + $("#id_cate"+i+" option:selected").text();
			cate = $("#id_cate"+i+" option:selected").val();
		}
	}
	
	if(isgo=='Y')	{
		$("#search_menu > span").each(function()	{

			if($(this).attr("dataattr")==cate)	{
				isok = "N";
			}
		});

		if(isok=='Y')	{
			
			thishtml = "<span dataattr='"+cate+"' style='margin:5px 0;padding:10px;font-size:16px;display:block;' onclick='set_objdel(this)'>"+text+" <a href='#none' style='color:red'>X</a></span>";
			$("#search_menu").append(thishtml);
		}
		else	{
			alert('이미 추가한 카테고리 입니다.');
			return;
		}
	}

}
function set_objdel(obj)	{
	$(obj).remove();
}
function set_buns()	{

	if($("#itemcate option:selected").val()!='')	{
		
		var params = "bun_idx="+$("#itemcate option:selected").val();
		gourl = "get_buns";

		$.ajax({
			type:'POST',
			url:'/ajaxmo/goods.php?act='+gourl,
			data:params,
			datatype:'html',
			success:function(resultdata){


				$("#bunlist").html(resultdata);
			},
			error:function(e){
				alert(e.responseText);
			}
		});
		
	}
}	
</script>
<script>
function set_ops()	{
	
	if($("#opcou option:selected").val()=='')	{
		$("#opinput1").hide();
		$("#opinput2").hide();
		$("#opinput3").hide();
		$("#opinputs").hide();
		$("#opmakebtns").hide();
	}
	else	{
		var cous = $("#opcou option:selected").val();

		for(var i=1;i<=cous;i++)	{
			$("#opinput"+i).show();
		}
		

		$("#opinputs").show();
		$("#opmakebtns").show();
	}

}
function makeops()	{
	var cous = $("#opcou option:selected").val();

	for(var i=1;i<=cous;i++)	{
		
		if($("input[name=opname"+i+"]").val()=='')	{
			alert('옵션명칭을 입력하세요');
			return;
		}
		if($("input[name=ops"+i+"]").val()=='')	{
			alert('옵션항목을 입력하세요');
			return;
		}
	}
	
	if(cous==1)	{
		var ops1 = $("input[name=ops1]").val().split(",");
		var ops2 = new Array("");
		var ops3 = new Array("");
	}
	if(cous==2)	{
		var ops1 = $("input[name=ops1]").val().split(",");
		var ops2 = $("input[name=ops2]").val().split(",");
		var ops3 = new Array("");
	}
	if(cous==3)	{
		var ops1 = $("input[name=ops1]").val().split(",");
		var ops2 = $("input[name=ops2]").val().split(",");
		var ops3 = $("input[name=ops3]").val().split(",");
	}
	
	var str = "";
	for(var i=0;i<ops1.length;i++)	{
		for(var j=0;j<ops2.length;j++)	{
			for(var k=0;k<ops3.length;k++)	{
				
				str = str + "<tr>"; 
				str = str + "	<td><input type='text' name='opele1[]' value='"+ops1[i]+"' class='form-control'></td>";
				str = str + "	<td><input type='text' name='opele2[]' value='"+ops2[j]+"' class='form-control'></td>";
				str = str + "	<td><input type='text' name='opele3[]' value='"+ops3[k]+"' class='form-control'></td>";
				str = str + "	<td><input type='text' name='addac[]' value='0' class='form-control'></td>";
				str = str + "	<td><input type='text' name='lefts[]' value='0' class='form-control'></td>";
				str = str + "	<td><input type='text' name='barcode[]' value='' class='form-control'></td>";
				str = str + "</tr>"; 

			}
		}
	}
	
	$("#oplists").html(str);
}
$(document).ready(function()	{
	
	$("#id_gtype").on("change",function()	{
		
		if($(this).find('option:selected').val()=='1')	{
			$(".selected1").show();
			$(".selected2").hide();
		}
		else	{
			$(".selected2").show();
			$(".selected1").hide();
		}

	});

});	
$(document).ready(function()	{
	$("#id_cate1").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate2");
		}
	});
	$("#id_cate2").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate3");
		}
	});
	$("#id_cate3").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate4");
		}
	});

});
function get_cate(upcate,target)	{
	console.log("/exec/proajax.php?act=cate&han=get_cate&upcate="+upcate)
	$.getJSON("/exec/proajax.php?act=cate&han=get_cate&upcate="+upcate,function(results)	{
		if(results.res=='ok')	{
			var str = "<option value=''>선택하세요</option>";
			$(results.datas).each(function(index,item)	{
				str = str + "<option value='"+item.catecode+"'>"+item.catename+"</option>";
			});
			$("#"+target).html(str);
			
		}
	});
}
$(document).ready(function()	{
	$("#subimg").change(function(){
		readURLsub(this);
	});
});
function readURLsub(input,m) {
    if (input.files) {
		var formData = new FormData();
		for(var i=0;i<=input.files.length;i++)	{
			if(input.files[i])	{
				//console.log(input.files[i]);
				formData.append("file[]",input.files[i]);	
			}		
		}
		$.ajax({
			url: '/exec/proajax.php?act=file&han=set_goodsimg&tmp_idx=<?=$tmp_idx;?>',
			data : formData,
			type : 'post',
			contentType : false,
			processData: false,
			xhr: function() { //XMLHttpRequest 재정의 가능
				var xhr = $.ajaxSettings.xhr();
				xhr.upload.onprogress = function(e) { //progress 이벤트 리스너 추가
					var percent = Math.floor(parseFloat(e.loaded * 100 / e.total));
					
				};
				return xhr;
			},
			success : function(result) {
				//console.log(result);
				var str = '';
				$(result.datas).each(function(index,item)	{
					str = str + "<li data-dir='goods' data-file='"+item.fileor+"'><img src='"+item.file+"'><a href='#none' onclick='event.preventDefault(); delfile(this);'><i class='fa fa-times-circle fa-2x' aria-hidden='true'></i></a></li>";

				});

				
				$("#sub_selectimgs").before(str);

			}
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
<style>
.imglist	{	list-style:none;margin-bottom:20px;	}
.imglist:after {content:'';display:block;clear:both;height:0;	} 
.imglist li	{	float:left;width:140px;height:140px;border:1px dotted #CCCCCC;margin-right:10px;overflow:hidden;position:relative;	}
.imglist li img	{	width:100%;	}
.mainimglist li	{	display:none;	}
.mainimglist li:first-child	{	display:block;	}
.mainimglist li a	{	position:absolute;top:0;right:0;color:#000000;	}
.subimglist li a	{	position:absolute;top:0;right:0;color:#000000;	}
.register_img	{	width:100%;height:100%;position:relative;cursor:pointer;	}
.register_img input[type=file] {	position: absolute;width: 1px;height: 1px;padding: 0; margin: -1px;overflow: hidden;clip: rect(0,0,0,0);border: 0;}
.register_img i	{	height: 40px;padding: 0 !important;position: absolute;top: 50px;left: 55px;font-size: 40px;text-align: center;	}

.regibtns	{	position:fixed;bottom:0;    padding: 12px 25px;background-color: #ecedef;border-top: 1px solid #d9d9d9;width:100%;left:240px;right:0;z-index: 1000;text-align:center;	}
</style>
<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);" ENCTYPE="multipart/form-data">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='catestr' id="catestr" value="">
<input type='hidden' name='sbj_idx' id='sbj_idx' class="form-control">
<input type='hidden' name='tmp_idx' value="<?=$tmp_idx;?>">
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 카테고리관리</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>카테고리선택</th>
					<td colspan='3'>
						<select class="uch" name='cate1' id='id_cate1'>
						<option value=''>선택하세요</option>
						<?php
						$q = "select * from shop_cate where upcate='' order by catecode";	
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							echo "<option value='$row[catecode]'>$row[catename]</option>";	
						}
						?>
						</select>
						<select class="uch" name='cate2' id='id_cate2'>
						<option value=''>선택하세요</option>
						</select>
						<select class="uch" name='cate3' id='id_cate3'>
						<option value=''>선택하세요</option>
						</select>
						<select class="uch" name='cate4' id='id_cate4'>
						<option value=''>선택하세요</option>
						</select>
						<a href="#none" onclick="event.preventDefault(); search_cate();" class="btn btn-primary">추가하기</a>
					</td>
				</tr>
				<tr>
					<th>등록카테고리</th>
					<td colspan='3' id="search_menu">
						
					</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 이미지</h3>
			</div>
			<div class="panel-content">
				<ul class="imglist subimglist" id="p_imgs">
					<li id="sub_selectimgs">
						<label class="register_img" for="subimg">
							<i class="fa fa-plus" aria-hidden="true"></i>
							<input type='file' id="subimg" multiple>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">


		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 기초정보</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>상품형태</th>
					<td colspan='3'>
						<select class="uch" name='gtype' id="id_gtype">
						<option value=''>선택</option>
						<option value='1' selected>일반상품</option>
						<!-- <option value='3'>일반상품(상품으로옵션구성-고정가판매)</option>
						<option value='4'>일반상품(상품으로옵션구성-상품가판매)</option> -->
						<option value='2'>세트상품</option>
						</select>
					</td>
				</tr>
				<tr>
					<th class="hide_list">노출처</th>
					<td colspan='3'>
<?php
foreach($g_ar_pid AS $key => $val)	{
?>
						<label><input type='checkbox' name='showsite[]' value='<?=$val['idx'];?>' checked><?=$val['site_name'];?></label>
<?
}
?>						
					</td>
					
				</tr>
				<tr>
					<th>상품판매여부</th>
					<td>
<?php
foreach($g_ar_isdan AS $key => $val)	{
?>
						<label><input type='radio' name='isopen' value='<?php echo $key;?>' <? if($key=='1') { echo "checked";	}?>> <?php echo $val;?></label>
<?php
}
?>
					</td>
					<th>진열여부</th>
					<td>
<?php
foreach($g_ar_isshow AS $key => $val)	{
?>
						<label><input type='radio' name='isshow' value='<?php echo $key;?>' <? if($key=='N') { echo "checked";	}?>> <?php echo $val;?></label>
<?php
}
?>
					</td>
					
				</tr>
				<tr>
					<th class="hide_list">브랜드/제조사/시리즈</th>
					<td>
						<select name='brand_idx'>
						<option value=''>브랜드선택</option>
						<?php
						
						?>
						</select>
						<select name='maker_idx'>
						<option value=''>제조사선택</option>
						<?php
						
						?>
						</select>
					</td>
					<th>원산지</th>
					<td>
						<select name='brand'>
						<option value=''>선택</option>
						</select>
					</td>
				</tr>
				<tr style="display:none;">
					<th>부모상품선택</th>
					<td>
						<span class="btn_white_s"><a a href="javascript:select_goods();">검색하기</a></span>
						<input type='hidden' name='master_idx' value=''>
						<div id='mastergoods'></div>
					</td>
					<th>부모상품관련설정</th>
					<td>
						<label><input type='checkbox' name='master_rel' value='Y'>관련상품 별도로 관리</label>
						<label><input type='checkbox' name='master_ac' value='Y'>판매가격 별도로 관리</label>
					</td>
				</tr>
				<tr>
					<th>상품분류</th>
					<td colspan='3'>
						<select class="uch" name='itemcate' id="itemcate" onchange="set_buns();">
						<option value=''>상품분류선택</option>
						<?php
						$q = "SELECT * FROM shop_goods_bun order by catename asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch()){
							$catecode_len = strlen($row['catecode']);
							if($catecode_len==2){
								$first=$row['catename'];
								echo "<option value='$row[catecode]' $se>$row[catename] ($row[buncode])</option>";
							}
							else if($catecode_len==4){
								$second=$row['catename'];
							    echo "<option value='$row[catecode]' $se>$first > $row[catename] ($row[buncode])</option>";
							}
							else if($catecode_len==6){
							    echo "<option value='$row[catecode]' $se>$first > $second > $row[catename] ($row[buncode])</option>";	
							}
						}
						?>
						</select>
					</td>
				</tr>
				
				<tr>
					<th>상품코드</th>
					<td colspan='3'><input type='text' class='form-control' name='gcode'></td>
				</tr>
				<tr>
					<th>오픈예정메세지</th>
					<td colspan='3'><input type='text' class='form-control' name='openstr' value=""></td>
				</tr>
				<tr>
					<th class="hide_list">상품머릿말</th>
					<td colspan='3'><input type='text' class='form-control' name='gname_head' size='50'></td>
				</tr>
				<tr>
					<th>대표상품명</th>
					<td colspan='3'><input type='text' class='form-control' name='gname' valch="yes" msg="대표상품명"></td>
				</tr>
				<tr>
					<th class="hide_list">상품꼬릿말</th>
					<td colspan='3'><input type='text' class='form-control' name='gname_foot' size='50'></td>
				</tr>
				<tr>
					
					<th>담당MD</th>
					<td colspan='3'>
						<select class="uch" name='md_idx'>
						<option value=''>선택하세요</option>
<?php
$q = "Select shop_member.idx,name from shop_member where amemgrade!='0'";
$st = $pdo->prepare($q);
$st->execute();
while ($row = $st->fetch()) {
	$sel = "";
	if($row['idx']==$g_memidx)	{
		$sel = "selected";
	}
	echo "<option value='".$row['idx']."' $sel>".$row['name']."</option>";	
}
?>
						</select>
					</td>
				</tr>
				<tr>
					<th class="hide_list">요약설명[목록]</th>
					<td><textarea name='gname_pre' class='form-control'></textarea></td>
					<th class="hide_list">요약설명[상세]</th>
					<td><textarea name='custom_memo' class='form-control'></textarea></td>
				</tr>
				<tr>
					
					<th>구매범위/제한</th>
					<td>
						<div class="form-inline">
							<label><input type='radio' name='buytype' value='A' checked>모든사람구매가능</label> <label><input type='radio' name='buytype' value='1'>회원만구매가</label>

							<input type='text' name='buylimits'  class="form-control">개로 제한
						</div>
					</td>
					<th class="hide_list">청약철회</th>
					<td><label><input type='checkbox' name='can_op' value='Y'>청약철회제한규정에 동의합니다 노출</label></td>
				</tr>
				<tr>
					<th>판매단위/최소구매</th>
					<td>
						<div class="form-inline">
							<input type='text' class='form-control' name='selldan' style="width:50px;">개/<input type='text' class='form-control' name='minbuy' style="width:50px;">개
						</div>

					</td>
					<th>신상할인</th>
					<td>
						<select name='sale_today' id="sale_today">
						<option value=''>선택하세요</option>
						</select>
					</td>
				</tr>
				<Tr>
					<th>판매가 <span>(쉼표제외)</span></th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' id="account" name='account'> 원
						</div>
					</td>
					<th>참고가격 <span>(쉼표제외)</span></th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='saccount' onkeyup='make_asc()'>원
						</div>
					</td>
				</tr>
				<Tr>
					<th>해외판매가 <span>(쉼표제외)</span></th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='account_over'> 원
						</div>
					</td>
					<th>해외참고가격 <span>(쉼표제외)</span></th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='saccount_over'>원
						</div>
					</td>
				</tr>
				
				<tr>
					<th>적립금유형</th>
					<td>
						<p style="font-size:10px;">* 적립금이 입력 되어 있어도, 세일 쿠폰에 따라 실 적립금은 변동 됩니다</p>
						<label><input type='radio' name='pointper' id="pointper1" value='1' checked onclick="$('#point1').show(); $('#point2').hide();">%적립</label>  <label><input type='radio' name='pointper' value='2' onclick="$('#point2').show(); $('#point1').hide();">입력값으로적립</label>
					</td>
					<th>적립금</th>
					<td>
						<div id="point1" class="form-inline">
						<select class="uch" name='saveper' id="orsaveper" onchange="make_gpoint()">
<?php
for($i=0;$i<31;$i++)	{	
	if($ar_goods_config['basic_point']==$i)	{
		echo "<option value='$i' selected>$i%</option>";		
	}
	else	{
		echo "<option value='$i'>$i%</option>";		
	}
}
?>
						</select>
						예상적립금 : <input type='text' class='form-control' name='point' size='10' readonly> 포인트
						</div>
						<div id="point2" style="display:none;" class="form-inline">
							<input type='text' class='form-control' name='points' size='10'> 포인트
						</div>
					</td>
				</tr>
				<tr>
					<th>적립금메모</th>
					<td colspan='3'><textarea name='pointmemo' class='form-control'></textarea></td>
				</tr>
				<tr>
					<th>관리자메모</th>
					<td colspan='3'><textarea name='admin_memo' class='form-control'></textarea></td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 부가정보</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				
				<tr>
					<th>상품무게</th>
					<td>
						<div class="form-inline">
							<input type='text' class="form-control" name='weight'>
						</div>
					</td>
					<th>상품공급구분</th>
					<td>
						<select name='ismake'>
						<option value=''>매입상품</option>
						<option value='Y'>제작상품(완사입)</option>
						<option value='A'>제작상품(공정이용)</option>
						</select>
					</td>
					
				</tr>
				<tr>
					
					<th>기타설정</th>
					<td colspan='3'>
						<label><input type='checkbox' name='istoday' value='Y' > 당일배송상품</label>
						<label><input type='checkbox' name='delno' value='Y'>무료배송상품</label>
					</td>
				</tr>
				<tr>
					<th>배송방법</th>
					<td colspan='3'>
						<select name='deltype'>
						<option value='1'>택배배송</option>
						<option value='2'>화물배송</option>
						</select>
					</td>
					
				</td>
				</tr>
				<tr>
					<th>검색키워드</th>
					<td colspan='3'><textarea name='search_keyword' class='form-control'></textarea></td>
				</tr>
				<tr>
					<th>연관태그</th>
					<td colspan='3'>
<?php
$q = "select * from shop_config_tags where isdel='N' order by tags asc";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{


?>
						<label><input type='checkbox' name='tags[]' value='<?=$row['idx'];?>'><?=$row['tags'];?></label>
<?php
}
?>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row selected1">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 옵션정보</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>옵션갯수</th>
					<td colspan='3'>
						<select name="opcou" id="opcou" class="form-control" onchange="set_ops();">
						<option value="">사용안함</option>
						<option value="1">1개</option>
						<option value="2">2개</option>
						<option value="3">3개</option>
						</select>
					</td>
				</tr>
				
				</tbody>
				</table>


				<div class="row m-b-10" id="opinput1" style="display:none;">
					<div class="col-md-2">
						<input type="text" name="opname1" placeholder="옵션1명칭 (예:색상)" class="form-control">
					</div>
					<div class="col-md-10">
						<input type="text" name="ops1" placeholder="옵션항목을 콤마(,)로 구분하여 입력하세요 (예:레드,블루,블랙)" class="form-control">
					</div>
				</div>
				<div class="row m-b-10" id="opinput2" style="display:none;">
					<div class="col-md-2">
						<input type="text" name="opname2" placeholder="옵션2명칭 (예:색상)" class="form-control">
					</div>
					<div class="col-md-10">
						<input type="text" name="ops2" placeholder="옵션항목을 콤마(,)로 구분하여 입력하세요 (예:레드,블루,블랙)" class="form-control">
					</div>
				</div>
				<div class="row m-b-10" id="opinput3" style="display:none;">
					<div class="col-md-2">
						<input type="text" name="opname3" placeholder="옵션3명칭 (예:색상)" class="form-control">
					</div>
					<div class="col-md-10">
						<input type="text" name="ops3" placeholder="옵션항목을 콤마(,)로 구분하여 입력하세요 (예:레드,블루,블랙)" class="form-control">
					</div>
				</div>
				<div class="row m-b-10" id="opmakebtns" style="display:none;">
					<div class="col-md-12" style="text-align:center;">
						<button class="btn btn-primary waves-effect waves-light" type="button" style="width:50%;" onclick="makeops();">옵션조합하기</button>
					</div>
				</div>
				<table class="table table-bordered" id="opinputs" style="display:none;">
				<thead>
				<tr>
					<th>옵션1</th>
					<th>옵션2</th>
					<th>옵션3</th>
					<th>추가금액</th>
					<th>판매재고</th>
					<th>바코드정보</th>
				</tR>
				</thead>
				<tbody id="oplists">
				
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row selected1">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품매입정보</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>매입상품명</th>
					<td colspan='3'><input type='text' class='form-control' name='gdname'></td>
				</tr>
				<tr>
					<th>매입가격</th>
					<td>
						<div class="form-inline">
							<input type='text' class='form-control' name='daccount'> %
						</div>
					</td>
					<th>부가세포함</th>
					<td></td>
				</tr>
				<tr>
					<th>거래처</th>
					<td colspan='3'>
						<select name='in_idx'>
						<option value=''>거래처선택</option>
						<?php
						$q = "SELECT * FROM shop_goods_shops";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() )	{

							if($row['idx']==$ar_data['in_idx'])	{
								echo "<option value='$row[idx]' selected>$row[name]</option>";	
							}
							else	{
								echo "<option value='$row[idx]'>$row[name]</option>";	
							}
						}
						?>
						</select>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상세공통정보</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				
				<tr>
					<th>상세공통정보</th>
					<td colspan='3'>

					</td>
				</tr>

				
				
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row selected1">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품정보고시 <span>(상품분류 선택후 사용가능)</span></h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody id="bunlist">
				
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상세정보</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>상세구성방법</th>
					<td colspan='3'>
						<label><input type='radio' name='smemo_type' value='1' checked>에디터에 입력한 정보로 노출</label>
						<label><input type='radio' name='smemo_type' value='2'>일반이미지로 노출</label>
					</td>
				</tr>
				<tr>
					<td colspan='4'>
						<textarea cols="80" rows="10" name="memo" id="memo"></textarea>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
					<button class="btn btn-primary waves-effect waves-light" type="button" onclick="location.href='subpage.php?code=goods_list';">목록으로</button>	
				</div>
			</div>
	</div>
</div>
</form>
<script src="/js/ckeditor4/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'memo', {
			extraPlugins: 'image2,uploadimage',
			allowedContent:true,


			
			filebrowserUploadUrl: '/ckeditor_upload.php',
			filebrowserBrowseUrl : '/ckeditor_upload.php',
			
			// Reduce the list of block elements listed in the Format drop-down to the most commonly used.
			// Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
			removeDialogTabs: 'image:advanced;link:advanced',
			width:'100%',
			height:600
		} );
</script>
