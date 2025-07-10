<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicm/shop/view.htm 000019632 */ 
$TPL_imglist_1=empty($TPL_VAR["imglist"])||!is_array($TPL_VAR["imglist"])?0:count($TPL_VAR["imglist"]);
$TPL_catelist_1=empty($TPL_VAR["catelist"])||!is_array($TPL_VAR["catelist"])?0:count($TPL_VAR["catelist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
$(document).ready(function()	{
	const swiper1 = new Swiper('.swiper1', {
		loop: true,
	});
	
	function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.bottom > 0 &&
            rect.top < (window.innerHeight || document.documentElement.clientHeight)
        );
    }

    function checkSwiperVisibility() {
        const swiper = $('.swiper1')[0]; // 첫 번째 swiper1 요소
        if (!swiper) return;

        if (!isElementInViewport(swiper)) {
            $('#bar').addClass('bg-[#FDFBF5]');
        } else {
            $('#bar').removeClass('bg-[#FDFBF5]');
        }
    }

    // 초기 확인
    checkSwiperVisibility();

    // 스크롤 시 확인
    $(window).on('scroll', function () {
        checkSwiperVisibility();
    });
	makeaccount();
});

function setwish()	{
	
}
function adds(obj,mo)	{
	
	var msg1 = $(obj).data("msg1");
	var msg2 = $(obj).data("msg2");
	var goods_idx = $(obj).data("goodsidx");
	var ea = "";
	var selcou = 0;
	
	if($("#isopen").val()!='2')	{
		alert('품절이거나 구매하실수 없는상품입니다');
		return;
	}
	
	$("#glist_item>div").each(function()	{
		ea = ea + '|R|' + $(this).find("input[name=ea]").val();
		selcou++;
	});
	

	var param = "goods_idx="+goods_idx+"&ea="+ea+"&selcou="+selcou;
	
	acmo = mo;
	console.log('/exec/proajax.php?act=useraction&han=set_'+acmo+'_multi&' + param);
	$.getJSON('/exec/proajax.php?act=useraction&han=set_'+acmo+'_multi&' + param, function(result)	{
		
		if(result.res=='ok')	{
			if(mo=='buy')	{
				location.href='/order/?act=order_step1&basket_idxs='+result.basket_idxs;
			}
			if(mo=='gift')	{
				location.href='/order/?act=order_step1&buymode=gift&basket_idxs='+result.basket_idxs;
			}
			if(mo=='cart')	{
				answer = confirm(msg2);
				if(answer==true)	{
					location.href='/order?act=cart';
				}
			}
		}
	});
}
function set_ea(obj,m)	{
	var ea = $(obj).parent().parent().find("input[name=ea]").val();
	if(m==1)	{	
		ea = parseInt(ea) - 1;
	}
	else	{
		ea = parseInt(ea) + 1;
	}

	if(ea<=0)	{
		alert('수량은 0이상이어야 합니다');
		return;
	}
	$(obj).parent().parent().find("input[name=ea]").val(ea);
	$(obj).parent().parent().find("span").html(ea);
	makeaccount();

}
function makeaccount()	{
	
	var total = 0;
	$("#glist_item>div").each(function()	{
		
		console.log($(this).data("account"));
		console.log($(this).find("input[name=ea]").val());
		total = parseInt(total) + parseInt($(this).data("account")) * parseInt($(this).find("input[name=ea]").val());

	});
	
	$("#totalac").html(setComma(total));

}
function setComma(n)	{
    var reg = /(^[+-]?\d+)(\d{3})/;   // 정규식
    n += '';                          // 숫자를 문자열로 변환
    while(reg.test(n))
    {
        n = n.replace(reg, '$1' + ',' + '$2');
    }
    return n;
}
function showops(m)	{
	console.log($("#opsbg").css("display"));
	if($("#opsbg").css("display") == "none")	{
		$("#opsbg").removeClass("hidden");	
		$("#ops").removeClass("hidden");
		$("#ops").addClass("show");	
		if(m=='1')	{
			$("#btns1").removeClass("hidden");	
			
		}	else if(m=='2')	{
			$("#btns2").removeClass("hidden");	
		}
		$("body").addClass("overflow-hidden");
	}	else	{
		$("#opsbg").addClass("hidden");	
		$("#ops").addClass("hidden");
		$("#ops").removeClass("show");	
		$("#btns1").addClass("hidden");	
		$("#btns2").addClass("hidden");	
		$("body").removeClass("overflow-hidden");		
	}
}
function setwish()	{
	var param = "idx=<?php echo $TPL_VAR["goods"]["idx"]?>";
	param = param + "&stypes=1";
	
	console.log('/exec/proajax.php?act=useraction&han=set_addwish&' + param);
	
	$.getJSON('/exec/proajax.php?act=useraction&han=set_addwish&' + param, function(result)	{
		console.log(result);
		if(result.res=='ok1')	{
			$("#wishoff").addClass("hidden");			
			$("#wishon").removeClass("hidden");			
			
			return;
		}
		else if(result.res=='ok2')	{
			$("#wishon").addClass("hidden");			
			$("#wishoff").removeClass("hidden");		
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
function copyToClipboard() {
    const input = document.getElementById("shareurl");
    input.select();                   // 텍스트 선택
    input.setSelectionRange(0, 99999); // 모바일 호환을 위한 범위 지정

    document.execCommand("copy");     // 복사 실행

    alert("복사되었습니다");
}
</script>
<style>
.popup-layer {

  opacity: 0;
  transition: opacity 0.5s ease-out, transform 0.5s ease-out;
}
.popup-layer.show {
	opacity: 1;

}
</style>
</head>
<body>
<div id="root">
	<?php echo $TPL_VAR["goods"]["global"]?>

	<div class="h-[58px] fixed flex items-center justify-between top-0 left-0 right-0 z-10 px-6" id="bar">
		<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
		<div class="flex items-center">
			<a href="#none" class="mr-5" onclick="event.preventDefault(); showshare();"><img src="/img/m/icon_SHARE_dark.png" /></a>
			<a href="#none" class="mr-5" onclick="event.preventDefault(); setwish()">
				<div id="wishoff" class="<?php if($TPL_VAR["goods"]["havewish"]=='Y'){?>hidden<?php }?>">
					<img src="/img/m/icon_HEART_dark.png" />
				</div>
				<div id="wishon" class="<?php if($TPL_VAR["goods"]["havewish"]=='N'){?>hidden<?php }?>">
					<img src="/img/m/icon_HEART_darkon.png" />
				</div>
			</a>
			<a href="/order/?act=cart"><img src="/img/m/icon_CART_dark.png" /></a>
		</div>
	</div>
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="relative overflow-hidden w-full">
			<div class="swiper swiper1">
				<div class="swiper-wrapper">
<?php if($TPL_imglist_1){foreach($TPL_VAR["imglist"] as $TPL_V1){?>
					<div class="swiper-slide">
						<img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["filename"]?>">		
					</div>
<?php }}?>
				</div>
			</div>
		</div>
		<div class="px-6 py-6">
			<div class="text-sm font-normal text-[#322A24] pb-1">
<?php if($TPL_catelist_1){$TPL_I1=-1;foreach($TPL_VAR["catelist"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1!= 0){?>&gt; <?php }?><?php echo $TPL_V1["catename"]?>

<?php }}?>
			</div>
			<h1 class="text-[18px] font-bold text-[#111111] pb-1"><?php echo $TPL_VAR["goods"]["gname"]?></h1>
			<p class="text-sm font-normal text-[#C0BCB6]"><?php echo $TPL_VAR["goods"]["gname_pre"]?> <?php echo $TPL_VAR["goods"]["weight"]?></p>
			<p class="text-sm font-normal text-[#322A24]"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_VAR["goods"]["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></p>
		</div>
		
		<div class="px-6" style="padding-bottom:50px;">
			<div class="pb-6 text-[#6F6963] font-bold text-sm">Fragrance Story</div>
			<div style="background-color:#322A2408" class="px-6 py-6 text-[#6F6963] text-sm"><?php echo nl2br($TPL_VAR["goods"]["custom_memo"])?></div>
		</div>
		<div class="px-6" style="padding-bottom:100px;">
			<?php echo $TPL_VAR["goods"]["memo"]?>

		</div>
		<div class="px-6 flex items-center justify-between pb-6">
			<div class="text-[#555555] text-sm font-bold">Information</div>
			<A href="#none"><img src="/img/m/icon_DROPUP_dark.png"></a>
		</div>
		<div class="px-6" style="padding-bottom:40px;">
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">제품명</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"><?php echo $TPL_VAR["goods"]["gname"]?></div>
			</div>	
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">제품설명</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>	
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">향조노트</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>	
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">사용방법</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>	
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">용량</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"><?php echo $TPL_VAR["goods"]["weight"]?></div>
			</div>
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">사용기간</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">유통기한</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">사이즈</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">전성분</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>
			<div class="flex items-start pb-4">
				<div class="text-[#C0BCB6] text-[10px] font-medium" style="width:20%;">주의사항</div>
				<div class="text-[#6F6963] text-[10px] font-medium" style="width:80%;"></div>
			</div>
		</div>
		<div class="px-6 flex items-center justify-between pb-6">
			<div class="text-[#555555] text-sm font-bold">Recommend</div>
			
		</div>
		<div class="px-6 flex items-center justify-between pb-8">
			<div class="text-[#555555] text-sm font-bold">Recently visited</div>
			
		</div>
	</div>
</div>
<div class="fixed z-10 px-6 py-6 bottom-0 left-0 right-0"  style="background-color:#FDFBF5">
	<div class="flex justify-between">
		<button class="h-[46px] mr-2 bg-[#FFFFFF] text-[#322A24] text-sm font-bold" style="border:1px solid #C0BCB6;width:48%" onclick="showops('2');">선물하기</button>
		<button class="h-[46px] ml-2 bg-[#322A24] text-[#FDFBF5] text-sm font-bold" style="border:1px solid #322A24;width:48%" onclick="showops('1');">구매하기</button>		
	</div>
</div>
<div id="opsbg" class="fixed z-20 h-[100vh] top-0 bottom-0 left-0 right-0 hidden" style="background-color:rgba(0,0,0,0.4);" onclick="showops('')">

</div>
<div id="ops" class="fixed z-50  bg-[#FDFBF5] bottom-0 left-0 right-0 popup-layer hidden " style="height:70%;">
	<div class="relative" style="height:100%;">
	<div class="px-6 h-[46px] flex justify-end items-center">
		<a href="#none" onclick="event.preventDefault(); showops();">
			<svg class="downupPopup-kapat" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000"	stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
		</a>
	</div>
	<div class="px-6">
		<div  id="glist_item">
<?php if($TPL_VAR["goods"]["noop"]=='Y'){?>
			<div data-account='<?php echo $TPL_VAR["goods"]["account_pure"]?>' class="rounded shadow-sm p-4 flex flex-col gap-4 w-full mx-auto ">
				<div class="flex justify-between items-start w-full">
					<div class="space-y-1 w-full">
						<div class="flex justify-between items-center w-full">
							<div class="font-bold text-[#322A24] text-xs pb-1"><?php echo $TPL_VAR["goods"]["gname"]?></div>
<?php if($TPL_VAR["goods"]["noop"]=='N'){?>
							<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 px-4 py-2 !p-0 !h-fit text-[#322A244D] font-bold">삭제</button>
<?php }?>
						</div>
						<div class="text-[#322A244D] font-normal text-xs"><?php echo $TPL_VAR["goods"]["gname_pre"]?> <?php echo $TPL_VAR["goods"]["weight"]?></div>
						<div class="text-[#322A244D] font-bold" style="display:none;">쇼핑백 : 구매안함</div>
						<div class="flex justify-between items-center mt-2 w-full text-sm">
							<div class="font-bold text-[#322A24] text-sm"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_VAR["goods"]["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></div>
							<div class="flex items-center gap-3">
								<button class="gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-background hover:bg-accent hover:text-accent-foreground h-5 !w-[16px] !h-[16px] flex items-center justify-center border border-[#CFC9BC] rounded-full text-[#C2BDB6] p-0" onclick='set_ea(this,1);'>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus !w-[7px] !h-[7px] text-[#5E5955]" aria-hidden="true"><path d="M5 12h14"></path></svg>
								</button>
								<input type='hidden' name='ea' value='1'>
								<span class="w-6 text-xs text-center text-[#322A24] font-bold">1</span>
								<button class="gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-background hover:bg-accent hover:text-accent-foreground h-5 !w-[16px] !h-[16px] flex items-center justify-center border border-[#CFC9BC] rounded-full text-[#C2BDB6] p-0" onclick='set_ea(this,2);'>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus !w-[7px] !h-[7px] text-[#5E5955]" aria-hidden="true"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php }else{?>
						
<?php }?>
		</div>
	</div>
	<div class="absolute z-50 px-6  bottom-0 left-0 right-0 ">
		<div class="flex justify-end text-base font-bold text-[#322A24] text-lg items-center">
			<span class="text-sm">합계</span>
			<span class=" pl-1"><?php echo $TPL_VAR["curr"]["showdan1"]?><span id="totalac"><?php echo $TPL_VAR["goods"]["account"]?></span><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
		</div>
		<div id="btns1" class="py-5 hidden" >
			<div class="flex justify-between">
				<button class="h-[46px] mr-2 bg-[#FFFFFF] text-[#322A24] text-sm font-bold" style="border:1px solid #C0BCB6;width:48%" data-goodsidx="<?php echo $TPL_VAR["goods"]["idx"]?>" data-msg1="<?php echo trscode('VIEW1')?>" data-msg2="" onclick="adds(this,'cart');">장바구니 담기</button>
			<button class="h-[46px] ml-2 bg-[#322A24] text-[#FDFBF5] text-sm font-bold" style="border:1px solid #322A24;width:48%" data-goodsidx="<?php echo $TPL_VAR["goods"]["idx"]?>" data-msg1="<?php echo trscode('VIEW1')?>" data-msg2="" onclick="adds(this,'buy');">구매하기</button>		
			</div>
		</div>
		<div id="btns2" class="py-5 hidden" >
			<div class="flex justify-between">
				<button class="h-[46px] bg-[#322A24] text-[#FDFBF5] text-sm font-bold" style="border:1px solid #322A24;width:100%" data-goodsidx="<?php echo $TPL_VAR["goods"]["idx"]?>" data-msg1="<?php echo trscode('VIEW1')?>" data-msg2="" onclick="adds(this,'gift');">선물하기</button>		
			</div>
		</div>
	</div>
	
	</div>
</div>
<div id="sharebg" class="fixed z-20 h-[100vh] top-0 bottom-0 left-0 right-0 hidden" style="background-color:rgba(0,0,0,0.4);" onclick="showshare()">

</div>
<div id="sharecnt" class="fixed z-50  bg-[#FDFBF5] bottom-0 left-0 right-0 hidden px-6 py-6">
	<div class=" h-[46px] flex justify-end items-center">
		<a href="#none" onclick="event.preventDefault(); showshare();">
			<svg class="downupPopup-kapat" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000"	stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
		</a>
	</div>
	<div class="font-bold text-[#6F6963] text-base pb-6">공유하기</div>
	<div>
		<div class="flex items-center py-3 px-4" style="border:1px solid #C0BCB6;">
			<div style="flex:1">
				<input type='text' id="shareurl" class="text-[#C0BCB6] text-sm font-normal" value="http://www.granhand.kro.kr/shop/?act=view&idx=<?php echo $_REQUEST["idx"]?>">
			</div>
			<button type="button" onclick="copyToClipboard()" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 h-10 ml-4 p-1 text-[#5E5955] hover:text-black transition" aria-label="클립보드에 복사" type="button">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy w-8 h-8" aria-hidden="true"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>
			</button>
		</div>
	</div>
</div>
</body>
</html>