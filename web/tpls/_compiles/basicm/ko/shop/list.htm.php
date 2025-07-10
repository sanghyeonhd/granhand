<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicm/shop/list.htm 000008755 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<link rel="stylesheet" href="/assets/plugin/downupPopup/downupPopup.css" />
<script src="/assets/plugin/downupPopup/downupPopup.js"></script>
<script>
$(document).ready(function()	{
	$("#f_catelist").downupPopup({
		distance:70,
		radiusLeft:"0",
		radiusRight:"0",

	});
	
});
function showcate()	{
	$('#f_catelist').downupPopup('open');

	
}
function showshare()	{
	console.log($("#sharebg").css("display"));
	if($("#sharebg").css("display") == "none")	{
		$("#sharebg").removeClass("hidden");	
		$("#sharecnt").removeClass("hidden");
		
		$("body").addClass("overflow-hidden");
	}	else	{
		$("#sharebg").addClass("hidden");	
		$("#sharecnt").addClass("hidden");
		$("body").removeClass("overflow-hidden");		
	}
}
function set_wish(obj,idx)	{
	var param = "idx="+idx;
	param = param + "&stypes=1";
	
	console.log('/exec/proajax.php?act=useraction&han=set_addwish&' + param);
	
	$.getJSON('/exec/proajax.php?act=useraction&han=set_addwish&' + param, function(result)	{
		console.log(result);
		if(result.res=='ok1')	{
			$(obj).find("img").attr("src","/img/m/icon_wish_on.svg");
			return;
		}
		else if(result.res=='ok2')	{
			$(obj).find("img").attr("src","/img/m/icon_wish_off.svg");	
			return;			
		}
		else if(result.res=='login')	{
			answer = confirm('로그인이 필요합니다. 로그인 하시겠습니까?');
			if(answer==true)	{
				location.href='/member/?act=login&geturl=<?php echo $TPL_VAR["global"]["nowurl_en"]?>';
			}
		}
		else	{
			alert(result.resmsg);
			
		}
	});
}
</script>
<style>
.downupPopup-header	{
	background-color:#FDFBF4 !important;
}
.downupPopup	{
	background-color:#FDFBF4 !important;
}
</style>
</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="h-[58px] fixed flex items-center justify-between top-0 left-0 right-0 bg-[#FDFBF4] z-10 px-6">
			<div class="flex items-center">
				<img src="/img/m/main_<?php echo substr($_REQUEST["cate"], 0, 2)?>.png" style="height:14px;margin-right:8px;">
				<A href="#none" onclick="event.preventDefault(); showcate()"><img src="/img/m/icon_left.png" /></a>
			</div>
			<div class="flex items-center">
				<a href="/cont/?act=search" class="pr-6"><img src="/img/m/icon_SEARCH_dark.png"></a>
				<a href="/order/?act=cart"><img src="/img/m/icon_CART_dark.png"></a>				
			</div>
		</div>
		<div style="padding-top:58px;">
			<div><img src="/img/Group 1000002528.png" style="width:100%"></div>
			<div class="px-6">
				<div class="flex h-[54px] items-center">
					<A class="<?php if(substr($_REQUEST["cate"], 0, 2)==$_REQUEST["cate"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-bold" href="/shop/?act=list&cate=<?php echo substr($_REQUEST["cate"], 0, 2)?>">전체</a>
<?php if(is_array($TPL_R1=get_cate(substr($_REQUEST["cate"], 0, 2)))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<A class="<?php if(substr($_REQUEST["cate"], 0, 4)==$TPL_V1["catecode"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-bold pl-5" href="/shop/?act=list&cate=<?php echo $TPL_V1["catecode"]?>"><?php echo $TPL_V1["catename"]?></a>
<?php }}?>
				</div>
<?php if(strlen($_REQUEST["cate"])>= 4){?>
				<div class="flex h-[20px] items-center">
					<A class="text-[#6F6963] text-xs font-bold" href="/shop/?act=list&cate=<?php echo $_REQUEST["cate"]?>">전체</a>	
<?php if(is_array($TPL_R1=get_cate(substr($_REQUEST["cate"], 0, 4)))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<A class="<?php if(substr($_REQUEST["cate"], 0, 6)==$TPL_V1["catecode"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-bold pl-5" href="/shop/?act=list&cate=<?php echo $TPL_V1["catecode"]?>"><?php echo $TPL_V1["catename"]?></a>
<?php }}?>
				</div>
<?php }?>
				<div class="flex h-[38px] items-center justify-end mb-2">
					<div class="text-[#6F6963] text-sm font-bold"  onclick="showshare();"><?php echo $TPL_VAR["l_arr"]["orderbyname"]?></div>
					<img src="/img/icon_DROPDOWN_dark.png">
				</div>
			</div>
			<div class="flex px-6 justify-between" style="flex-wrap: wrap;">
				
<?php if(is_array($TPL_R1=get_listdata('list',$TPL_VAR["l_arr"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>	
				<div class="" style="width:48%;">
					<div  class="mb-2 relative">
						<A href="/shop/?act=view&idx=<?php echo $TPL_V1["idx"]?>">
							<img alt="<?php echo $TPL_V1["gname"]?>" loading="lazy" width="205" height="200" class="object-cover transition-transform duration-700 group-hover:scale-105"  src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="color: transparent;width:100%">
						</a>
						<a href="#none" class="z-1" style="position:absolute;top:8px;right:8px;" onclick="event.preventDefault(); set_wish(this,<?php echo $TPL_V1["idx"]?>)"><img src="/img/m/icon_wish_off.svg"></a>
					</div>
					<div>
						<a href="/shop/?act=view&idx=<?php echo $TPL_V1["idx"]?>">
							<div class="pb-1 text-sm text-[#111111] font-bold"><?php echo $TPL_V1["gname"]?></div>
							<div class="pb-1 text-xs text-[#C0BCB6] font-normal"><?php echo $TPL_V1["gname_pre"]?> <?php echo $TPL_V1["weight"]?></div>
							<div class="text-xs text-[#322A24] font-normal"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_V1["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></div>
						</a>
					</div>
				</div>
<?php }}?>
			</div>
		</div>
	</div>
</div>
<div id="f_catelist" class="bg-[#FDFBF4]">
	<div class="px-6">
		<div class="text-[#6F6963] text-lg font-bold">다양한 BRAND를 만나보세요.</div>
		<div class="flex items-center justify-between pt-12">
			<a class="flex-1 flex items-end justify-center" href="/shop/?act=list&cate=01">
				<img src="/img/m/main1.png" alt="GRANHAND." class="h-3 w-auto">
			</a>
			<div class="shrink-0 w-[1px] h-6 bg-gray-300"></div>
			<a class="flex-1 flex items-center justify-center" href="/shop/?act=list&cate=02">
				<img src="/img/m/main2.png" alt="heiion" class="h-6 w-auto">
			</a>
			<div class="shrink-0 w-[1px] h-6 bg-gray-300"></div>
			<a class="flex-1 flex items-center justify-center" href="/shop/?act=list&cate=03">
				<img src="/img/m/main3.png" alt="Komfortabel coffee" class="h-6 w-auto">
			</a>
		</div>
	</div>
</div>
<div id="sharebg" class="fixed z-20 h-[100vh] top-0 bottom-0 left-0 right-0 hidden" style="background-color:rgba(0,0,0,0.4);" onclick="showshare()">

</div>
<div id="sharecnt" class="fixed z-50  bg-[#FDFBF5] bottom-0 left-0 right-0 popup-layer hidden px-6 py-6">
	<div class=" h-[46px] flex justify-end items-center">
		<a href="#none" onclick="event.preventDefault(); showshare();">
			<svg class="downupPopup-kapat" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000"	stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
		</a>
	</div>
	<div>
		<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=1" class="flex items-center h-[40px] <?php if($TPL_VAR["l_arr"]["ob"]=='1'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-medium" >추천순</a>
		<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=2" class="flex items-center h-[40px] <?php if($TPL_VAR["l_arr"]["ob"]=='2'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-medium" >인기순</a>
		<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=3" class="flex items-center h-[40px] <?php if($TPL_VAR["l_arr"]["ob"]=='3'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-medium" >낮은 가격순</a>
		<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=4" class="flex items-center h-[40px] <?php if($TPL_VAR["l_arr"]["ob"]=='4'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-medium" >높은 가격순</a>
		<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=5" class="flex items-center h-[40px] <?php if($TPL_VAR["l_arr"]["ob"]=='5'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-medium" >상품평 적은순</a>
		<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=6" class="flex items-center h-[40px] <?php if($TPL_VAR["l_arr"]["ob"]=='6'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm font-medium" >상품평 많은순</a>		
	</div>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>