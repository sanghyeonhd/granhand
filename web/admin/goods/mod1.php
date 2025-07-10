<?php
$idx = $_REQUEST['idx'];
$ar_data = sel_query_all("shop_goods"," where idx='$idx'");

$mode =isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "";
echo $mode;
if($mode=='w')	{

	foreach($_REQUEST AS $key => $val)	{
		
		if(!is_array($_REQUEST[$key]))	{

			$_REQUEST[$key] = addslashes(trim($val));
		}
	}
	$value['usetax'] = $_REQUEST['usetax'];
	$value['in_idx'] = $_REQUEST['in_idx'];
	$value['icons'] = implode("|R|",$_REQUEST['icons']);
	$value['gcode'] = $_REQUEST['gcode'];
	$value['gname'] = $_REQUEST['gname'];
	$value['gname_head'] = $_REQUEST['gname_head'];
	$value['gname_foot'] = $_REQUEST['gname_foot'];
	$value['md_idx'] = $_REQUEST['md_idx'];
	$value['gname_pre'] = $_REQUEST['gname_pre'];
	$value['custom_memo'] = $_REQUEST['custom_memo'];
	$value['buytype'] = $_REQUEST['buytype'];
	$value['can_op'] = $_REQUEST['can_op'];
	$value['account'] = $_REQUEST['account']*100;
	$value['saccount'] = $_REQUEST['saccount']*100;
	$value['account_over'] = $_REQUEST['account_over']*100;
	$value['saccount_over'] = $_REQUEST['saccount_over']*100;
	$value['account_b2b'] = $_REQUEST['account_b2b']*100;
	$value['account_off'] = $_REQUEST['account_off']*100;
	$value['m_country'] = $_REQUEST['m_country'];
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
	$value['istoday'] = $_REQUEST['istoday'];
	$value['delno'] = $_REQUEST['delno'];
	$value['deltype'] = $_REQUEST['deltype'];
	$value['search_keyword'] = $_REQUEST['search_keyword'];
	$value['gdname'] = $_REQUEST['gdname'];
	$value['daccount'] = $_REQUEST['daccount'];
	$value['sbj_idx'] = $_REQUEST['sbj_idx'];
	$value['sbj_per'] = $_REQUEST['sbj_per'];

	$value['listimgcolor'] = implode(",",$_REQUEST['listimgcolor']);
	$listimgcolor = $value['listimgcolor'];
	$value['itemcate'] = $_REQUEST['itemcate'];
	$value['openstr'] = $_REQUEST['openstr'];
	
	$value['smemo_type'] = $_REQUEST['smemo_type'];
	$value['memo'] = $_REQUEST['memo'];
	$value['brand_idx'] = $_REQUEST['brand_idx'];
	$value['maker_idx'] = $_REQUEST['maker_idx'];
	$value['selldan'] = $_REQUEST['selldan'];
	$value['minbuy'] = $_REQUEST['minbuy'];
	$value['buylimits'] = $_REQUEST['buylimits'];
	
	$value['isopen'] = $_REQUEST['isopen'];
	$value['isshow'] = $_REQUEST['isshow'];
	if($value['isopen']=='2' && substr($ar_data['opendate'],0,10)=='0000-00-00')	{
		$value['opendate'] = date("Y-m-d H:i:s");
	}

	/*$userfile = array($_FILES['simg1']['name'],$_FILES['simg2']['name'],$_FILES['simg3']['name'],$_FILES['simg4']['name'],$_FILES['simg5']['name'],$_FILES['simg6']['name'],$_FILES['simg7']['name'],$_FILES['simg8']['name'],$_FILES['simg9']['name'],$_FILES['simg10']['name'],$_FILES['simg11']['name'],$_FILES['simg12']['name']);
	$tmpfile = array($_FILES['simg1']['tmp_name'],$_FILES['simg2']['tmp_name'],$_FILES['simg3']['tmp_name'],$_FILES['simg4']['tmp_name'],$_FILES['simg5']['tmp_name'],$_FILES['simg6']['tmp_name'],$_FILES['simg7']['tmp_name'],$_FILES['simg8']['tmp_name'],$_FILES['simg9']['tmp_name'],$_FILES['simg10']['tmp_name'],$_FILES['simg11']['tmp_name'],$_FILES['simg12']['tmp_name']);
	

	$ar_last = array($ar_data['simg1'],$ar_data['simg2'],$ar_data['simg3'],$ar_data['simg4'],$ar_data['simg5'],$ar_data['simg6'],$ar_data['simg7'],$ar_data['simg8'],$ar_data['simg9'],$ar_data['simg10'],$ar_data['simg11'],$ar_data['simg12']);
	
	for($i=0;$i<12;$i++)	{
		
		if(!isset($_REQUEST['"delf".($i+1)']))	{
			$ar_del[$i] = "N";
		}
		else	{
			$ar_del[$i] = $_REQUEST['"delf".($i+1)'];
		}

	}

	

	$savedir = $_uppath."goods/";


	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);
	}
	
	$value['simg1'] = $fs['0'];
	$value['simg2'] = $fs['1'];
	$value['simg3'] = $fs['2'];
	$value['simg4'] = $fs['3'];
	$value['simg5'] = $fs['4'];
	$value['simg6'] = $fs['5'];
	$value['simg7'] = $fs['6'];
	$value['simg8'] = $fs['7'];
	$value['simg9'] = $fs['8'];
	$value['simg10'] = $fs['9'];
	$value['simg11'] = $fs['10'];
	$value['simg12'] = $fs['11'];*/

	$imgfile1 = $_REQUEST['imgfile1'];
	$ar_img1 = explode("|R|",$imgfile1);
	$cou = 1;
	for($i=0;$i<sizeof($ar_img1);$i++)	{
		if($ar_img1[$i]!="")	{
			
			//$value['simg'.$cou'] = $ar_img1[$i];
			$cou++;
		}
	}

	$value['moviesite'] = $_REQUEST['moviesite'];
	$value['movie'] = $_REQUEST['movie'];

	$r = update("shop_goods",$value," WHERE idx='$idx'");
	if(!$r)	{
		show_message("수정실패",true);
		exit;
	}
	unset($value);
	$q = "DELETE FROM shop_goods_color WHERE goods_idx='$idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$ar_color = explode(",",$listimgcolor);
	for($i=0;$i<sizeof($ar_color);$i++)	{

		if($ar_color[$i] && $ar_color[$i]!="")	{
			$value['goods_idx'] = $idx;
			$value['color_idx'] = $ar_color[$i];
			insert("shop_goods_color",$value);
			unset($value);
		}
	}


	

	$showsite = $_REQUEST['showsite'];

	$q = "update shop_goods_showsite set tmp='Y' where goods_idx='$idx'";
	$st = $pdo->prepare($q);
	$st->execute();

	for($i=0;$i<sizeof($showsite);$i++)	{
		
		$q = "SELECT * FROM shop_goods_showsite WHERE goods_idx='$idx' AND pid='".$showsite[$i]."'";
		$st = $pdo->prepare($q);
		$st->execute();
		$isit = $st->rowCount();

		if($isit==0)	{
			$value['goods_idx'] = $idx;
			$value['pid'] = $showsite[$i];
			insert("shop_goods_showsite",$value);
			unset($value);
		}
		else	{
			$value['tmp'] = "";
			update("shop_goods_showsite",$value," WHERE goods_idx='$idx' AND pid='".$showsite[$i]."'");
			unset($value);
		}
	}
	$q = "DELETE FROM  shop_goods_showsite where goods_idx='$idx' AND tmp='Y'";
	$st = $pdo->prepare($q);
	$st->execute();

	

	if($ar_data['gtype']=='1') {
		$noti_idx = $_REQUEST['noti_idx'];
		$noti_name = $_REQUEST['noti_name'];
		$noti_data = $_REQUEST['noti_data'];
		$ismod = $_REQUEST['ismod'];

		$q = "DELETE FROM shop_goods_addinfo WHERE goods_idx='$idx'";
		$st = $pdo->prepare($q);
		$st->execute();

		for($i=0;$i<sizeof($noti_idx);$i++)	{
		
			$value['goods_idx'] = $idx;
		
			$value['name'] = $noti_name[$i];
			$value['data'] = $noti_data[$i];
			$value['idx'] = $noti_idx[$i];
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

		$ar_acc = sel_query_all("shop_goods_account"," WHERE goods_idx='$idx' and stype='$row[name]'");
		
		if($_REQUEST['account_'.$row['name']])	{
			$value['goods_idx'] = $idx;
			$value['stype'] = $row['name'];
			$value['account'] = $_REQUEST['account_'.$row['name']]*100;
	
			

			if($ar_acc['idx'])	{
				update("shop_goods_account",$value," WHERE idx='$ar_acc[idx]'");
			}
			else	{
				insert("shop_goods_account",$value);
			}
		
			unset($value);
		}
		else	{
			if($ar_acc['idx'])	{
				$q = "DELETE FROM shop_goods_account WHERE idx='$ar_acc[idx]'";
				$st = $pdo->prepare($q);
				$st->execute();
			}
		}

	}
	
	unset($value);
	$value['istmp'] = "Y";
	update("shop_goods_cate",$value," where goods_idx='$idx'");
	unset($value);

	$catestr = $_REQUEST['catestr'];
	$ar_cates = explode("|R|",$catestr);
	for($i=0;$i<sizeof($ar_cates);$i++){
		if($ar_cates[$i]!=""){
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
				else	{
					$value['istmp'] = "N";
					update("shop_goods_cate",$value," where goods_idx='$idx' and catecode='$cate'");
					unset($value);
				}
			}
		}
	}

	$pdo->prepare("delete from shop_goods_cate where goods_idx='$idx' and istmp='Y'")->execute();

	show_message("수정완료","");
	move_link("$PHP_SELF?code=$code&idx=$idx");
	exit;
}


$q = "SELECT * FROM shop_goods_showsite where goods_idx='$idx'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
	$g_showsite[] = $row['pid'];
}
$q = "SELECT * FROM shop_goods_showlang where goods_idx='$idx'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
	$g_showlang[] = $row['lang'];
}

$q = "select * from shop_cate order by catecode";	
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
	$catecode_len = strlen($row['catecode']);
	if($catecode_len==2)	{
		$first=$row['catename'];

		$ar_searchcate[$row['catecode']] = $row['catename'];
	}
	else if($catecode_len==4)	{
		$second=$row['catename'];

		$ar_searchcate[$row['catecode']] = "$first > $row[catename]";
	}
	else if($catecode_len==6)	{
		$thirt=$row['catename'];

		$ar_searchcate[$row['catecode']] = "$first > $second > $row[catename]";
	}
	else if($catecode_len==8)	{
	
		$ar_searchcate[$row['catecode']] = "$first > $second > $thirt > $row[catename]";
	}
}
?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('수정 하시겠습니까?"");
		if(answer==true)	{
			var catestr = ';
			$("#search_menu > span").each(function()	{
		
				catestr = catestr + $(this).attr("dataattr") + '|R|';
		
			});
			$("#catestr").val(catestr);

			var file1 = "";

			for(var i=0;i<$("#p_imgs li").length;i++)	{
				if($("#p_imgs li").eq(i).data("file"))	{
					file1 = file1 + '|R|'+ $("#p_imgs li").eq(i).data("file");
				}
			}
			
			$(f).append("<input type='hidden' name='imgfile1' value='"+file1+"'>");

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
function set_buns()	{

	if($("#itemcate option:selected").val()!="")	{
		
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
function show_img(srcs)	{

	
	var title = '이미지보기';
	

	layer_open('pop',title,true,true);
	$("#pop_cont").html("<img src='"+srcs+"' style='max-width:100%;margin:0 auto;'>");
}
function layer_open(el, title, btn_clsoe, bg_close){
	if ( 'undefined' == typeof(title)) title = "POPUP";
	if ( 'undefined' == typeof(btn_clsoe)) btn_clsoe = true;
	if ( 'undefined' == typeof(bg_close)) bg_close = true;

	var temp = $('#' + el);		//레이어의 id를 temp변수에 저장
	var bg = temp.prev().hasClass('pop_bg"");	//dimmed 레이어를 감지하기 위한 boolean 변수

	//팝업 제목 설정
	temp.find('.pop_title h1"").html(title);

	if(bg){
		$('.pop_wrap"").fadeIn(0);
	}else{
		temp.fadeIn();	//bg 클래스가 없으면 일반레이어로 실행한다.
	}
	

	// 화면의 중앙에 레이어를 띄운다.
	if (temp.outerHeight() < $(document).height() ) temp.css('margin-top', '-'+temp.outerHeight()/2+'px"");
	else temp.css('top', '0px"");
	if (temp.outerWidth() < $(document).width() ) temp.css('margin-left', '-'+temp.outerWidth()/2+'px"");
	else temp.css('left', '0px"");

	if ( btn_clsoe ) {
		temp.find('a.btn_close"").click(function(e){
			if(bg){
				$('.pop_wrap"").fadeOut(0);
			}else{
				temp.fadeOut(0);		//'닫기'버튼을 클릭하면 레이어가 사라진다.
			}
			e.preventDefault();
		});
	} else {
		temp.find('a.btn_close"").hide();
	}

	if ( bg_close ) {
		$('.pop_wrap .pop_bg"").click(function(e){
			$('.pop_wrap"").fadeOut(0);
			e.preventDefault();
		});
	}
}
function set_objdel(obj)	{
	$(obj).parent().remove();
}
function search_cate()	{

	var text = ';
	var cate = ';
	var thishtml = ';
	var isok = "Y";

	for(var i=1;i<5;i++)	{
		if($("#id_cate"+i+" option:selected").val()!="")	{
			isgo = "Y";
			if(text!="")	{
				text = text + " > ";
			}
			text = text + $("#id_cate"+i+" option:selected").text();
			cate = $("#id_cate"+i+" option:selected").val();
		}
	}
	
	if(isgo=='Y"")	{
		$("#search_menu > span").each(function()	{

			if($(this).attr("dataattr")==cate)	{
				isok = "N";
			}
		});

		if(isok=='Y"")	{
			
			thishtml = "<span dataattr='"+cate+"' style='margin:5px 0;padding:10px;font-size:16px;display:block;' onclick='set_objdel(this)'>"+text+" <a href='#none' style='color:red'>X</a></span>";
			$("#search_menu").append(thishtml);
		}
		else	{
			alert('이미 추가한 카테고리 입니다."");
			return;
		}
	}

}
$(document).ready(function()	{
	$("#id_cate1").on("change",function()	{
		if($(this).val()!="")	{
			get_cate($(this).val(),"id_cate2");
		}
	});
	$("#id_cate2").on("change",function()	{
		if($(this).val()!="")	{
			get_cate($(this).val(),"id_cate3");
		}
	});
	$("#id_cate3").on("change",function()	{
		if($(this).val()!="")	{
			get_cate($(this).val(),"id_cate4");
		}
	});

});
function get_cate(upcate,target)	{
	console.log("/exec/proajax?act=cate&han=get_cate&upcate="+upcate)
	$.getJSON("/exec/proajax?act=cate&han=get_cate&upcate="+upcate,function(results)	{
		if(results.res=='ok"")	{
			var str = "<option value='>선택하세요</option>";
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
			if(input.files['i'])	{
				//console.log(input.files['i']);
				formData.append("file[']",input.files['i']);	
			}		
		}
		

		$.ajax({
			url: '/exec/proajax.php?act=file&han=set_goodsimgmod&idx=<?=$idx;?>',
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
				var str = ';
				$(result.datas).each(function(index,item)	{
					str = str + "<li data-dir='goods' data-file='"+item.fileor+"'><img src='"+item.file+"'><a href='#none' onclick='event.preventDefault(); delfile(this);'><i class='fa fa-times-circle fa-2x' aria-hidden='true'></i></a></li>";

				});

				
				$("#sub_selectimgs").before(str);

			}
		});
	}
	
}
function delfile(obj)	{
	
	answer = confirm('삭제하시겠습니까?"");
	if(answer==true)	{
		var file = $(obj).parent().data("dir")+"/"+$(obj).parent().data("file");
		console.log(file);
		var formData = new FormData();
		formData.append("file",file);
		formData.append("goods_idx",<?=$idx;?>);
		console.log(file);
		console.log(formData);

		$.ajax({
			url: '/exec/proajax.php?act=file&han=set_delgoodsimg',
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
				console.log(result);
				$(obj).parent().remove();

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
.pop_title .btn_close {position:absolute;right:10px;top:8px;width:20px;height:20px;background:url('../images/btn_pop_close.png"") no-repeat 0 0;font-size:0;line-height:0}
.pop_content {padding:15px}
</style>
<style>
.imglist	{	list-style:none;	}
.imglist:after {content:';display:block;clear:both;height:0;	} 
.imglist li	{	float:left;width:140px;height:140px;border:1px dotted #CCCCCC;margin-right:10px;overflow:hidden;position:relative;	}
.imglist li img	{	width:100%;	}
.mainimglist li	{	display:none;	}
.mainimglist li:first-child	{	display:block;	}
.mainimglist li a	{	position:absolute;top:0;right:0;color:#000000;	}
.subimglist li a	{	position:absolute;top:0;right:0;color:#000000;	}
.register_img	{	width:100%;height:100%;position:relative;cursor:pointer;	}
.register_img input['type=file'] {	position: absolute;width: 1px;height: 1px;padding: 0; margin: -1px;overflow: hidden;clip: rect(0,0,0,0);border: 0;}
.register_img i	{	height: 40px;padding: 0 !important;position: absolute;top: 50px;left: 55px;font-size: 40px;text-align: center;	}

.regibtns	{	position:fixed;bottom:0;    padding: 12px 25px;background-color: #ecedef;border-top: 1px solid #d9d9d9;width:100%;left:240px;right:0;z-index: 1000;text-align:center;	}
</style>
<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);" ENCTYPE="multipart/form-data">
<input type='hidden' name='mode' value='w'>
<input type="hidden" name="idx" value="<?=$idx;?>">
<input type='hidden' name='catestr' id="catestr" value="">
<input type='hidden' name='sbj_idx' id='sbj_idx' value="<?=$ar_data['sbj_idx'];?>" class="form-control">
<div class="row">
	<div class="col-md-12">
		<div class="m-t-10 m-b-10 no-print"> 
			<a href="<?=$PHP_SELF;?>?code=goods_mod1&idx=<?=$idx;?>" class="btn btn-primary m-r-10 m-b-10">상품정보수정</a>
			<!-- <a href="<?=$PHP_SELF;?>?code=goods_mod2&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상세이미지관리</a> -->
			<? if($ar_data['gtype']=='1') {	?>
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod3&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">옵션관리</a> -->
			<!-- <a href="<?=$PHP_SELF;?>?code=goods_mod7&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관리자리뷰관리</a>  -->
			<?}?>
			<? if($ar_data['gtype']=='2') {	?>
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_modsets&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">세트상품관리</a> -->
			<?}?>
            
			<a href="<?=$PHP_SELF;?>?code=goods_mod4&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관련상품관리</a>                
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod5&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">관련후기상품관리</a> -->
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod6&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상품사이즈정보관리</a> -->
            <a href="<?=$PHP_SELF;?>?code=goods_mod8&idx=<?=$idx;?>" class="btn btn-white m-r-10 m-b-10">상품수정로그</a>
		</div>
	</div>
</div>
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
						<?php
						$q = "select * from shop_goods_cate where goods_idx='$idx' order by catecode asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() )	{
						?>
						<span dataattr='<?=$row['catecode'];?>' style='margin:5px 0;padding:10px;font-size:16px;display:block;'><?=$ar_searchcate[$row['catecode']];?> <a href='#none' style='color:red'  onclick='set_objdel(this)'>X</a></span>
						<?
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
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 이미지</h3>
			</div>
			<div class="panel-content">
				<ul class="imglist subimglist" id="p_imgs">
					<?php
					for($i=1;$i<=10;$i++)	{
						if($ar_data['simg'.$i]!="") {
					?>
					<li data-dir='goods' data-file='<?=$ar_data['simg'.$i];?>'><img src='<?=$_imgserver;?>/files/goods/<?=$ar_data['simg'.$i];?>'><a href='#none' onclick='event.preventDefault(); delfile(this);'><i class='fa fa-times-circle fa-2x' aria-hidden='true'></i></a></li>
					<?
						}
					}
					?>		
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
						<?php if($ar_data['gtype']=='1') { echo "일반상품";	}	?>
						<?php if($ar_data['gtype']=='2') { echo "세트상품";	}	?>
						<?php if($ar_data['gtype']=='3') { echo "일반상품(상품으로옵션구성-고정가판매)";	}	?>
						<?php if($ar_data['gtype']=='4') { echo "일반상품(상품으로옵션구성-상품가판매)";	}	?>
					</td>
				</tr>
				<tr>
					<th>노출처</th>
					<td colspan='3'>
<?php
foreach($g_ar_pid AS $key => $val)	{
?>
						<label><input type='checkbox' name='showsite[]' value='<?=$val['idx'];?>' <?php if(in_array($val['idx'],$g_showsite))	{ echo "checked";	}?>><?=$val['site_name'];?></label>
<?
}
?>

					</td>

					
				</tr>
				<?php
				$ar_sbj = sel_query_all("shop_member"," WHERE idx='$ar_data[sbj_idx]'");
				?>
<tr>
					<th>상품판매여부</th>
					<td>
<?php
foreach($g_ar_isdan AS $key => $val)	{
?>
						<label><input type='radio' name='isopen' value='<?php echo $key;?>' <? if($key==$ar_data['isopen']) { echo "checked";	}?>> <?php echo $val;?></label>
<?php
}
?>
					</td>
					<th>진열여부</th>
					<td>
<?php
foreach($g_ar_isshow AS $key => $val)	{
?>
						<label><input type='radio' name='isshow' value='<?php echo $key;?>' <? if($key==$ar_data['isshow']) { echo "checked";	}?>> <?php echo $val;?></label>
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
						$q = "Select * from shop_config_bm where tcate='2' and isuse='Y' order by bmname asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$sel = "";
							if($row['idx']==$ar_data['brand_idx'])	{
								$sel = "selected";
							}
							echo "<option value='$row[idx]' $sel>$row[bmname]</option>";
						}
						?>
						</select>
						<select name='maker_idx'>
						<option value=''>제조사선택</option>
						<?php
						$q = "Select * from shop_config_maker where isuse='Y' order by name asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							
							
							$sel = "";
							if($row['idx']==$ar_data['maker_idx'])	{
								$sel = "selected";
							}
							echo "<option value='$row[idx]' $sel>$row[name]</option>";
						}
						?>
						</select>
					</td>
					<th>원산지</th>
					<td>
						<input type='text' name='m_country' value='<?=$ar_data['m_country'];?>' class="form-control">
					</td>
				</tr>
				<tr style="display:none;">
					<th>부모상품선택</th>
					<td>
						<span class="btn_white_s"><a a href="javascript:select_goods();">검색하기</a></span>
						<input type='hidden' name='master_idx' value='>
						<div id='mastergoods'></div>
					</td>
					<th>부모상품관련설정</th>
					<td>
						<label><input type='checkbox' name='master_rel' value='Y'>관련상품 별도로 관리</label>
						<label><input type='checkbox' name='master_ac' value='Y'>판매가격 별도로 관리</label>
					</td>
				</tr>
				
				<tr>
					<th>상품코드</th>
					<td colspan='3'><input type='text' class='form-control' name='gcode' value="<?=$ar_data['gcode'];?>"></td>
				</tr>
				<tr>
					<th>오픈예정메세지</th>
					<td colspan='3'><input type='text' class='form-control' name='openstr' value="<?=$ar_data['openstr'];?>"></td>
				</tr>
				<tr>
					<th>상품머릿말</th>
					<td colspan='3'><input type='text' class='form-control' name='gname_head' size='50' value="<?=$ar_data['gname_head'];?>"></td>
				</tr>
				<tr>
					<th>대표상품명</th>
					<td colspan='3'><input type='text' class='form-control' name='gname' size='50' value="<?=$ar_data['gname'];?>"></td>
				</tr>
				<tr>
					<th>상품꼬릿말</th>
					<td colspan='3'><input type='text' class='form-control' name='gname_foot' size='50' value="<?=$ar_data['gname_foot'];?>"></td>
				</tr>
				<tr>
					
					<th colspan='3'>담당MD</th>
					<td>
						<select class="uch" name='md_idx'>
						<option value=''>선택하세요</option>
<?php
$q = "Select shop_member.idx,name from shop_member where amemgrade!='0'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())		{
	if($row['idx']==$g_memidx)	{
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
				<tr>
					<th>요약설명['목록']</th>
					<td><textarea name='gname_pre' class='form-control'><?php echo $ar_data['gname_pre'];?></textarea></td>
					<th>요약설명['상세']</th>
					<td><textarea name='custom_memo' class='form-control'><?php echo $ar_data['custom_memo'];?></textarea></td>
				</tr>
				<tr>
					
					<th>구매범위/제한</th>
					<td>
						<div class="form-inline">
							<label><input type='radio' name='buytype' value='A' <?php if($ar_data['buytype']=='A') { echo "checked"; }?>>모든사람구매가능</label> <label><input type='radio' name='buytype' value='1' <?php if($ar_data['buytype']=='1') { echo "checked"; }?>>회원만구매가</label>
							<input type='text' name='buylimits' value='<?=$ar_data['buylimits'];?>' class="form-control">개로 제한
						</div>
					</td>
					<th>청약철회</th>
					<td><label><input type='checkbox' name='can_op' value='Y'  <?php if($ar_data['can_op']=='Y') { echo "checked"; }?>>청약철회제한규정에 동의합니다 노출</label></td>
				</tr>
				<tr>
					<th>판매단위/최소구매</th>
					<td>
						<div class="form-inline">
							<input type='text' class='form-control' name='selldan' value="<?=$ar_data['selldan'];?>">개/<input type='text' class='form-control' name='minbuy' value="<?=$ar_data['minbuy'];?>">개
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
					<th>과세/면세</th>
					<td>
						<select name="usetax">
						<option value='Y' <? if($ar_data['usetax']=='Y') { echo "selected";	}?>>과세</option>
						<option value='N' <? if($ar_data['usetax']=='N') { echo "selected";	}?>>면세</option>
						</select>
					</td>

				</tr>
				<Tr>
					<th>판매가</th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' id="account" name='account' value="<?=$ar_data['account']/100;?>" onkeyup='make_gpoint()'> 원
						</div>
					</td>
					<th>참고가격</th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='saccount' value="<?=$ar_data['saccount']/100;?>" >원
						</div>
					</td>
				</tr>
				<Tr>
					<th>해외판매가</th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='account_over' value="<?=$ar_data['account_over']/100;?>"> 원
						</div>
					</td>
					<th>해외참고가격</th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='saccount_over' value="<?=$ar_data['saccount_over']/100;?>">원
						</div>
					</td>
				</tr>
				<Tr>
					<th>도매기준가</th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='account_b2b' value="<?=$ar_data['account_b2b']/100;?>"> 원
						</div>
					</td>
					<th>매장판매가</th>
					<td>
						<div class="form-inline">
						<input type='text' class='form-control' name='account_off' value="<?=$ar_data['account_off']/100;?>"> 원
						</div>
					</td>
				</tr>
				<tr>
					<th>적립금유형</th>
					<td>
						<p>* 적립금이 입력 되어 있어도, 세일 쿠폰에 따라 실 적립금은 변동 됩니다</p>
						<label><input type='radio' name='pointper' id="pointper1" value='1' checked onclick="$('#point1"").show(); $('#point2"").hide();">%적립</label>  <label><input type='radio' name='pointper' value='2' onclick="$('#point2"").show(); $('#point1"").hide();">입력값으로적립</label>
					</td>
					<th>적립금</th>
					<td>
						<div id="point1" class="form-inline">
						<select class="uch" name='saveper' id="orsaveper" onchange="make_gpoint()">
<?php
for($i=0;$i<31;$i++)	{	
	if($ar_data['point']==$i)	{
		echo "<option value=$i selected>$i%</option>";		
	}
	else	{
		echo "<option value=$i>$i%</option>";		
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
					<td colspan='3'><textarea name='pointmemo' class='form-control'><?=$ar_data['pointmemo'];?></textarea></td>
				</tr>
				<tr>
					<th>관리자메모</th>
					<td colspan='3'><textarea name='admin_memo' class='form-control'><?=$ar_data['admin_memo'];?></textarea></td>
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
							<input type='text' class="form-control" name='weight' value='<?=$ar_data['weight'];?>'> g
						</div>
					</td>
					<th>상품공급구분</th>
					<td>
						<select name='ismake'>
						<option value=''>매입상품</option>
						<option value='Y' <?php if($ar_data['ismake']=='Y') { echo "selected";	}?>>제작상품(완사입)</option>
						<option value='A' <?php if($ar_data['ismake']=='A') { echo "selected";	}?>>제작상품(공정이용)</option>
						</select>
					</td>
					
				</tr>
				<tr>
					
					<th>기타설정</th>
					<td colspan='3'>
						<label><input type='checkbox' name='istoday' value='Y' <?php if($ar_data['istoday']=='Y') { echo "selected";	}?>> 당일배송상품</label>
						<label><input type='checkbox' name='delno' value='Y' <?php if($ar_data['delno']=='Y') { echo "selected";	}?>>무료배송상품</label>
					</td>
				</tr>
				<tr>
					<th>배송방법</th>
					<td>
						<select name='deltype'>
						<option value='1'>택배배송</option>
						<option value='2'>화물배송</option>
						</select>
					</td>
					<th>배송정책</th>
					<td>
						<select name='delpolicy'>
						
						</select>
					</td>
				</td>
				</tr>
				<tr>
					<th>검색키워드</th>
					<td colspan='3'><textarea name='search_keyword' class='form-control'><?php echo $ar_data['search_keyword'];?></textarea></td>
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
					<td colspan='3'><input type='text' class='form-control' name='gdname' value='<?=$ar_data['gdname'];?>'></td>
				</tr>
				<tr>
					<th>수수료</th>
					<td>
						<div class="form-inline">
							<input type='text' class='form-control' name='daccount' value='<?=$ar_data['daccount'];?>'> %
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
						$q = "SELECT * FROM shop_goods_shops where isdel='N' order by name asc";
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
				<h3><i class="fa fa-table"></i> 동영상/상품공통정보</h3>
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
					<th>영상주소</th>
					<td colspan='3'>
						<div class="form-inline">
						<select name='moviesite'>
						<option value='youtube' <?php if($ar_data['moviesite']=='youtube') { echo "selected";	}?>>YOUTUBE</option>
						<option value='vimeo' <?php if($ar_data['moviesite']=='vimeo') { echo "selected";	}?>>VIMEO</option>
						</select>
						<input type='text' name='movie' class="form-control" value="<?=$ar_data['movie'];?>">
						</div>
					</td>
				</tr>
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
<? if($ar_data['gtype']=='1') { ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품정보고시</h3>
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
					<th>상품종류</th>
					<td colspan='3'>
						<select class="uch" name='itemcate' id="itemcate" onchange="set_buns();">
						<option value=''>상품분류선택</option>
						<?php
						$q = "SELECT * FROM shop_goods_bun order by catename asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch()){

							$se = "";
							if($ar_data['itemcate']==$row['catecode'])	{
								$se = "selected";
								$bun_idx = $row['idx'];
							}
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
				</tbody>
				</table>

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody id="bunlist">

				<?
				$q = "SELECT * FROM shop_config_goodsadd WHERE bun_idx='$bun_idx' ORDER BY idx ASC";
				$st = $pdo->prepare($q);
				$st->execute();
				while($row = $st->Fetch())	{
					$ar_ginf = sel_query_all("shop_goods_addinfo"," WHERE goods_idx='$idx' and idx='$row[idx]'");
				?>
				<tr>
					<th><input type='hidden' name='noti_idx[']' class="form-control" value="<?=$row['idx'];?>"><input type='hidden' name='ismod[']' class="form-control" value="N"><input type='text' name='noti_name[']' class="form-control" value="<?=$row['itemname'];?>"></th>
					<td colspan="3"><input type='text' name='noti_data[']' class="form-control" value="<?php if($ar_ginf['data']) { echo $ar_ginf['data']; } else { echo $row['bases']; } ?>"></td>
				</tr>
				<?}?>
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
					<td colspan='4'>
						<textarea cols="80" rows="10" name="memo" id="memo"><?=$ar_data['memo'];?></textarea>
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
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">수정하기</button>
					<button class="btn btn-primary waves-effect waves-light" type="button" onclick="location.href='subpage?code=goods_list';">목록으로</button>		
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
			
			// Reduce the list of block elements listed in the Format drop-down to the most commonly used.
			// Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
			removeDialogTabs: 'image:advanced;link:advanced',
			width:'100%',
			height:600
		} );
</script>
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