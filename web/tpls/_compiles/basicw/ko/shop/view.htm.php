<?php /* Template_ 2.2.7 2025/07/08 17:45:30 /home/grandhand/BUILDS/tpls/basicw/shop/view.htm 000023225 */ 
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
	makeaccount();
});

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
function showlay()	{
	if($("#sharelaysv").hasClass("hidden"))	{
		$("#sharelaysv").removeClass("hidden");
	}	else	{
		$("#sharelaysv").addClass("hidden");
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
<?php $this->print_("top",$TPL_SCP,1);?>

<div>
<?php $this->print_("nav",$TPL_SCP,1);?>

	<section class="container mx-auto pt-8 w-[1120px]">
		<nav class="w-full flex flex-col pt-4">
			<div class="w-full flex items-start justify-between">
				<div class="flex items-center gap-4 h-10">
					<h2 class="text-lg font-medium text-[#6F6963] m-0 p-0 leading-none">SHOP</h2>
					<div class="flex items-center text-sm text-gray-400">
						<div role="radiogroup" aria-required="false" dir="ltr" class="flex items-center rounded overflow-hidden gap-4" tabindex="0" style="outline: none;">
<?php if(is_array($TPL_R1=get_cate(''))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
							<a href="/shop/?act=list&cate=<?php echo $TPL_V1["catecode"]?>">
<?php if($TPL_I1!= 0){?><span class="w-[1px] mr-4 text-[#C0BCB6] select-none">|</span><?php }?>
								<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-[5%] hover:text-[#6F6963] <?php if(substr($TPL_VAR["cate"]["catecode"], 0, 2)==$TPL_V1["catecode"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?>">
									<?php echo $TPL_V1["catename"]?>

								</label>
							</a>
<?php }}?>
							
						</div>
					</div>
				</div>
				<div class="flex flex-col items-start">
					<div class="flex items-center text-sm text-gray-400 h-10">
<?php if(strlen($TPL_VAR["cate"]["catecode"])>= 2){?>
						<div role="radiogroup" aria-required="false" dir="ltr" class="flex items-center rounded overflow-hidden gap-[20px]" tabindex="0" style="outline: none;">
							
							<a href="/shop/?act=list&cate=<?php echo substr($TPL_VAR["cate"]["catecodev"], 0, 2)?>" class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#6F6963] text-[#C0BCB6]">
								전체
							</a>
<?php if(is_array($TPL_R1=get_cate(substr($TPL_VAR["cate"]["catecode"], 0, 2)))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<a href="/shop/?act=list&cate=<?php echo $TPL_V1["catecode"]?>" class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#6F6963] <?php if(substr($TPL_VAR["cate"]["catecode"], 0, 4)==$TPL_V1["catecode"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?>">
								<?php echo $TPL_V1["catename"]?>

							</a>
<?php }}?>
							
						</div>
<?php }?>
					</div>
					<div class="flex items-center mt-2 text-sm" style="min-height: 40px; height: 40px; visibility: hidden;">
						<div role="radiogroup" aria-required="false" dir="ltr" class="flex items-center rounded overflow-hidden gap-6" tabindex="-1" style="outline: none;">
							
						</div>
					</div>
				</div>
			</div>
		</nav>
		<section class="container mx-auto pb-12 space-y-16 mt-10">
			<?php echo $TPL_VAR["goods"]["global"]?>

			<div class="grid grid-cols-[592px_480px] gap-12">
				<div class="w-[592px]">
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
				</div>
				<div class="flex-1 space-y-6 border-t pt-6 relative !w-[480px]">
					<div class="absolute top-6 right-0 flex items-center gap-4 text-gray-400">
						<a href="#none" onclick="event.preventDefault(); setwish()">
							
							<svg  id="wishoff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="<?php if($TPL_VAR["goods"]["havewish"]=='Y'){?>hidden<?php }?> lucide lucide-heart w-[24px] h-[24px] cursor-pointer text-[#5E5955]" aria-hidden="true"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
							
							<svg id="wishon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#5E5955" stroke="#5E5955" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="<?php if($TPL_VAR["goods"]["havewish"]=='N'){?>hidden<?php }?> lucide lucide-heart w-[24px] h-[24px] cursor-pointer" aria-hidden="true"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
							
						</a>
						<div class="relative">
							<a href="#none" onclick="event.preventDefault(); showlay();"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 lucide-share-2 w-[24px] h-[24px] cursor-pointer text-[#5E5955]" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-«r3i»" data-state="closed"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg></a>
								<div id="sharelaysv" class="px-6 py-6 absolute hidden" style="border-radius: 1px;background:#FDFBF5;box-shadow: 0px 0px 10px 0px rgba(50, 42, 36, 0.10);right:0px;top:35px;">
									<div class="text-[#6F6963] text-base font-bold pb-6">
										공유하기
									</div>
									<div class="flex items-center py-3 px-4" style="border:1px solid #C0BCB6;">
										<input type='text' id="shareurl" class="text-[#C0BCB6] text-sm font-normal" style="width:320px" value="http://www.granhand.kro.kr/shop/?act=view&idx=<?php echo $_REQUEST["idx"]?>">
										<button type="button" onclick="copyToClipboard()" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 ml-4 p-1 text-[#5E5955] hover:text-black transition" aria-label="클립보드에 복사" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy w-8 h-8" aria-hidden="true"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg></button>
									</div>
								</div>
						</div>
					</div>
					<div class="space-y-2">
						<div class="text-sm font-bold text-[#6F6963]">
<?php if($TPL_catelist_1){$TPL_I1=-1;foreach($TPL_VAR["catelist"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1!= 0){?>&gt; <?php }?><?php echo $TPL_V1["catename"]?>

<?php }}?>
							</div>
						<h1 class="text-2xl font-bold text-[#111111]"><?php echo $TPL_VAR["goods"]["gname"]?></h1>
						<p class="text-sm font-bold text-[#C0BCB6]"><?php echo $TPL_VAR["goods"]["gname_pre"]?> <?php echo $TPL_VAR["goods"]["weight"]?></p>
						<p class="text-sm font-bold text-[#6F6963]"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_VAR["goods"]["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></p>
					</div>
					
					<div class="border-b border-gray-200 my-4"></div>
					<div class="flex gap-2 mt-12">
					
					</div>
					<div class="space-y-2">
						<div style="display:none;">
							<p class="text-sm text-[#322A24]">쇼핑백</p>
							<button class="gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 mb-5 flex justify-between items-center w-full border !border-[#C0BCB6] text-sm font-bold rounded px-4 py-3 text-left h-12 text-[#C0BCB6]" type="button" id="radix-«r3l»" aria-haspopup="menu" aria-expanded="false" data-state="closed">선택해 주세요.
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-[#5E5955]" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
							</button>
						</div>
						<div  id="glist_item">
<?php if($TPL_VAR["goods"]["noop"]=='Y'){?>
						<div data-account='<?php echo $TPL_VAR["goods"]["account_pure"]?>' class="rounded shadow-sm p-6 flex flex-col gap-4 w-full mx-auto text-xs">
							<div class="flex justify-between items-start w-full">
								<div class="space-y-1 w-full">
									<div class="flex justify-between items-center mt-2 w-full">
										<div class="font-bold text-[#322A24]"><?php echo $TPL_VAR["goods"]["gname"]?></div>
<?php if($TPL_VAR["goods"]["noop"]=='N'){?>
										<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 px-4 py-2 !p-0 !h-fit text-[#322A244D] font-bold">삭제</button>
<?php }?>
									</div>
									<div class="text-[#322A244D] font-bold"><?php echo $TPL_VAR["goods"]["gname_pre"]?> <?php echo $TPL_VAR["goods"]["weight"]?></div>
									<div class="text-[#322A244D] font-bold" style="display:none;">쇼핑백 : 구매안함</div>
									<div class="flex justify-between items-center mt-2 w-full text-sm">
										<div class="font-bold text-[#322A24]"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_VAR["goods"]["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></div>
										<div class="flex items-center gap-3">
											<button class="gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-background hover:bg-accent hover:text-accent-foreground h-10 !w-[16px] !h-[16px] flex items-center justify-center border border-[#CFC9BC] rounded-full text-[#C2BDB6] p-0" onclick='set_ea(this,1);'>
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus !w-[7px] !h-[7px] text-[#5E5955]" aria-hidden="true"><path d="M5 12h14"></path></svg>
											</button>
											<input type='hidden' name='ea' value='1'>
											<span class="w-6 text-xs text-center text-[#322A24] font-bold">1</span>
											<button class="gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-background hover:bg-accent hover:text-accent-foreground h-10 !w-[16px] !h-[16px] flex items-center justify-center border border-[#CFC9BC] rounded-full text-[#C2BDB6] p-0" onclick='set_ea(this,2);'>
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
					<div class="border-b border-gray-200 my-4"></div>
					<div class="space-y-4 pt-4">
						<div class="flex justify-between text-base font-bold text-[#322A24]">
							<span class="text-sm">총 상품금액</span><span><?php echo $TPL_VAR["curr"]["showdan1"]?><span id="totalac"><?php echo $TPL_VAR["goods"]["account"]?></span><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
						</div>
						<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 w-[480px] py-3 text-white bg-[#322A24] font-semibold rounded h-[46px] cursor-pointer" data-goodsidx="<?php echo $TPL_VAR["goods"]["idx"]?>" data-msg1="<?php echo trscode('VIEW1')?>" data-msg2="" onclick="adds(this,'cart');">구매하기</button>
						
						
						<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 px-4 w-[480px] py-3 border !border-[#C0BCB6] text-[#322A24] font-semibold rounded h-[46px] cursor-pointer" data-goodsidx="<?php echo $TPL_VAR["goods"]["idx"]?>" onclick="event.preventDefault(); adds(this,'gift');" >선물하기</button>
					</div>
				</div>
			</div>
			<section class="space-y-16">
				<div class="space-y-6">
					<h2 class="text-sm font-bold text-[#6F6963]">Fragrance Story</h2>
					<div class="min-h-[100px] text-xs bg-[#322A2408] text-[#6F6963] text-center leading-[26px] px-[24px] py-[10px] rounded-md flex items-center justify-center">
						<?php echo nl2br($TPL_VAR["goods"]["custom_memo"])?>

					</div>
				</div>
				<div class="grid grid-cols-[548px_548px] gap-[24px]">
					<?php echo $TPL_VAR["goods"]["memo"]?>

				</div>
				<div class="border-t border-gray-200 pt-12 mt-12">
					<h2 class="text-sm font-bold text-[#6F6963] mb-6">Information</h2>
					<div class="space-y-6 text-xs text-[#6F6963] leading-relaxed">
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">제품명</div>
							<div><?php echo $TPL_VAR["goods"]["gname"]?></div>
						</div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">제품 설명</div>
							<div>바디 스프레이 제품입니다. 용도에 맞게 활용하실 수 있습니다.</div>
						</div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">향노트</div>
							<div>Top: Lemon, Grapefruit, Bergamot, Mandarin, Aquatic Green<br>Middle: Sunny Passion Fruit, Orange Blossom, Yang lang, White Rose<br>Base: White Musk</div>
						</div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">사용방법</div>
							<div>피부에서 20cm 거리를 두고 분사하여 사용합니다. 피부 기준으로 5~6시간 지속됩니다.</div>
						</div>
						<div class="border-t border-gray-200 border-dashed my-6"></div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">용량</div>
							<div>100ml / 200ml</div>
						</div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">사용기간</div>
							<div>개인 사용빈도에 따라 상이</div>
						</div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">유통기한</div>
							<div>별도표기 (용기하단)</div>
						</div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">사이즈(mm)</div>
							<div>Ø40×135 / Ø55×150</div>
						</div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">전성분</div>
							<div>*주요성분 : 에탄올, 프로필렌글리콜, 향료, 정제수<br>*알레르기 성분 : 리날로올</div>
						</div>
						<div class="border-t border-[#E9E6E0] border-dashed my-6"></div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">주의사항</div>
							<div>최초 사용 시 펌프를 깊게 눌러 분사해 주세요. <br>상처가 있는 부위, 손톱 및 피부염 등의 이상이 있는 부위에는 사용을 자제해 주시길 바랍니다. <br>강제 누르다 안으로 펌프가 앞으로 올라와 고여 누수 현상이 발생할 수 있습니다. <br>향료 자재에 색이 있는 향을 밝은 옷에 분사하지 마세요.</div>
						</div>
						<div class="border-t border-[#E9E6E0] border-dashed my-6"></div>
						<div class="flex">
							<div class="w-28 text-[#C0BCB6] font-medium">스탬핑 서비스</div>
							<div>스탬핑 서비스 가능제품: 퍼퓸, 멀티퍼퓸, 디퓨저 세트, 캔들<br>스탬핑 서비스는 무료이며, 교환 및 환불이 불가합니다.<br>스탬핑 요청 시 잘못된 입력에 의한 오타는 교환 및 환불 대상에서 제외됩니다.</div>
						</div>
					</div>
				<div class="border-t border-gray-200 mt-12"></div>
			</div>
		</section>
		<div class="space-y-6">
			<h2 class="text-sm font-bold text-[#6F6963]">Recommend</h2>
			<div class="grid grid-cols-[205px_205px_205px_205px_205px] gap-x-[23.75px] gap-y-12" style="display:none;">
				<a class="group cursor-pointer" href="/shop/undefined"><div class="overflow-hidden mb-4 relative"><img alt="Roland Multi Perfume" loading="lazy" width="205" height="200" decoding="async" data-nimg="1" class="!w-[205px] !h-[200px] object-cover transition-transform duration-700 group-hover:scale-105" srcset="/_next/image?url=%2Fsusie-salmon-multi-perfume.png&amp;w=256&amp;q=75 1x, /_next/image?url=%2Fsusie-salmon-multi-perfume.png&amp;w=640&amp;q=75 2x" src="/_next/image?url=%2Fsusie-salmon-multi-perfume.png&amp;w=640&amp;q=75" style="color: transparent;"></div><div class="space-y-2"><h3 class="text-sm text-[#322A24] font-bold group-hover:text-granhand-text transition-colors">Roland Multi Perfume</h3><div class="flex items-center space-x-2 text-xs text-[#C0BCB6]"><span>롤랑 멀티퍼퓸 100ml / 200ml</span></div><div class="flex items-center space-x-2 text-xs text-[#322A24]"><span>35,000 KRW</span></div></div></a>
			</div>
		</div>
	</section>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>