<?php /* Template_ 2.2.7 2025/07/10 11:03:21 /home/grandhand/BUILDS/tpls/basicw/mypage/myorder.htm 000016358 */ 
$TPL_datalist_1=empty($TPL_VAR["datalist"])||!is_array($TPL_VAR["datalist"])?0:count($TPL_VAR["datalist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<div class="container mx-auto pt-8">
	<div class="w-full py-10 mx-auto text-[#6F6963]">
		<div class="flex justify-between">
			<h1 class="text-lg font-medium mb-8">주문내역</h1>
		</div>
	</div>
	<div class="flex w-full  text-gray-900">
		<aside class="w-1/3 max-w-64 min-w-50 px-6 py-10 space-y-10 mr-[2%]">
			<div class="flex items-center gap-4">
				<div class="flex flex-col items-center gap-2 w-full">
					<div class="pt-1">
						<div class="w-[42px] h-[42px] rounded-full text-2xl flex items-center justify-center font-bold text-white" style="background-color: rgb(233, 230, 224);">B</div>
					</div>
					<span class="font-bold text-center text-2xl mt-3 text-[#322A24]"><?php echo $TPL_VAR["gmem"]["name"]?> 님</span>
				</div>
			</div>
			<div class="space-y-6 mt-8">
				<div>
					<div class="flex justify-between items-center cursor-pointer text-sm font-bold text-[#5E5955] mypagemenu">마이페이지
						<svg class="open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-[24px] h-[24px]" aria-hidden="true"><path d="m18 15-6-6-6 6"></path></svg>
						
						<svg class="off hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-[24px] h-[24px]" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
					</div>
					<ul class="mt-2 space-y-1 text-sm font-medium">
						<a href="/mypage/?act=main">
							<li class="px-6 py-2  text-[#6F6963]">마이페이지</li>
						</a>
						<a href="/mypage/?act=myorder">
							<li class="px-6 py-2 text-[#C0BCB6] bg-[#322A2408] rounded">주문 내역</li>
						</a>
						<a href="/mypage/?act=cancel">
							<li class="px-6 py-2 text-[#C0BCB6]">취소/교환/반품 내역</li>
						</a>
						
						<a href="/mypage/?act=point">
							<li class="px-6 py-2 text-[#C0BCB6]">포인트</li>
						</a>
						<a href="/mypage/?act=check">
							<li class="px-6 py-2 text-[#C0BCB6]">출석 체크</li>
						</a>
						<a href="/mypage/?act=lucky">
							<li class="px-6 py-2 text-[#C0BCB6]">행운 뽑기</li>
						</a>
					</ul>
				</div>
				<div>
					<div class="flex justify-between items-center cursor-pointer text-sm font-bold text-[#5E5955] mypagemenu">나의 쿠폰함
						<svg class="open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-[24px] h-[24px]" aria-hidden="true"><path d="m18 15-6-6-6 6"></path></svg>
						
						<svg class="off hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-[24px] h-[24px]" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
					</div>
					<ul class="mt-2 space-y-1 text-sm font-medium">
						<a href="/mypage/?act=mycoupon">
							<li class="px-6 py-2 text-[#C0BCB6]">보유 쿠폰</li>
						</a>
						<a href="/mypage/?act=mycouponregi">
							<li class="px-6 py-2 text-[#C0BCB6]">쿠폰 등록</li>
						</a>
					</ul>
				</div>
				<div>
				<div class="flex justify-between items-center cursor-pointer text-sm font-bold text-[#5E5955] mypagemenu">회원 정보
					<svg class="open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-[24px] h-[24px]" aria-hidden="true"><path d="m18 15-6-6-6 6"></path></svg>
						
						<svg class="off hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-[24px] h-[24px]" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
				</div>
				<ul class="mt-2 space-y-1 text-sm font-medium">
					<a href="/mypage/?act=myinfo">
						<li class="px-6 py-2 text-[#C0BCB6]">회원 정보 수정</li>
					</a>
				</ul>
			</div>
		</div>
	</aside>
	<main class="w-[739px] mx-auto ml-10">
		<section class="min-w-80">
			<div class="flex justify-between items-center text-sm text-gray-500">
				<div class="space-x-4">
					<span class="text-sm font-bold text-[#322A24]">전체</span>
					<span class="text-[#6F6963] text-[10px] font-bold">최근 1년</span>
				</div>
				<div class="relative">
					<button type="button" onclick="$(this).parent().find('.absolute').removeClass('hidden');" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 px-4 py-2 text-xs text-[#C0BCB6] font-bold" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-«r1c»" data-state="closed">기간설정</button>
					
					<div class="hidden absolute left-1/2  -translate-x-1/2 -translate-y-1/2 z-50 px-4 py-2 rounded shadow w-auto inline-block whitespace-nowrap bg-[#FDFBF5] px-6 py-10" style="top:200px;width:390px;">
						<div class="flex justify-between">
							<div class="font-bold mb-2 mt-6 text-[#6F6963]">기간설정</div>
							<a href="#none" onclick="event.preventDefault(); $(this).parent().parent().addClass('hidden');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x text-[#5E5955] mt-4" aria-hidden="true" type="button"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></a>
						</div>
						<div role="radiogroup" aria-required="false" dir="ltr" class="grid grid-cols-4 gap-4 text-sm mt-3" tabindex="0" style="outline: none;">
							<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[34px] w-[72px] border !border-[#DBD7D0] rounded py-6 px-3 text-center cursor-pointer flex justify-center items-center text-[#322A24]"><button type="button" role="radio" aria-checked="false" data-state="unchecked" value="year" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""></button>최근 1년</label>
							
							<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[34px] w-[72px] border !border-[#DBD7D0] rounded py-6 px-3 text-center cursor-pointer flex justify-center items-center text-[#322A24]"><button type="button" role="radio" aria-checked="false" data-state="unchecked" value="week" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""></button>1주일</label>
							
							<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[34px] w-[72px] border !border-[#DBD7D0] rounded py-6 px-3 text-center cursor-pointer flex justify-center items-center text-[#322A24]"><button type="button" role="radio" aria-checked="false" data-state="unchecked" value="month" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""></button>1개월</label>
							
							<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[34px] w-[72px] border !border-[#DBD7D0] rounded py-6 px-3 text-center cursor-pointer flex justify-center items-center text-[#322A24]"><button type="button" role="radio" aria-checked="false" data-state="unchecked" value="months" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""></button>3개월</label>
						</div>
						<div class="flex justify-around gap-2 items-center mt-5 mb-10">
							<input class="flex border rounded-md bg-background px-[16px] py-[12px] text-base text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm !border-[#C0BCB6] w-[155px] h-[46px]" placeholder="2022.10.18" type="text"><span>~</span>
							<input class="flex border rounded-md bg-background px-[16px] py-[12px] text-base text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm !border-[#C0BCB6] w-[155px] h-[46px]" placeholder="2023.10.18" type="text">
						</div>
						<div class="flex justify-center">
							<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 py-2 w-[342px] h-[46px] bg-[#322A24] text-white rounded-none font-bold">조회하기</button>
						</div>
					</div>
		
				</div>
				
			</div>
			<div class="w-full h-[88px] mt-4 grid grid-cols-5 text-center border rounded-lg px-[2%] py-5 text-sm font-medium text-[#6F6963] min-w-[580px]">
				<div>
					<div class="<?php if($TPL_VAR["data"]["d1"]== 0){?>text-[#E9E6E0]<?php }else{?>text-[#322A24]<?php }?> font-bold"><?php echo $TPL_VAR["data"]["d1"]?></div>
					<div class="mt-3 text-xs font-medium"><span>입금/결제</span></div>
				</div>
				<div>
					<div class="<?php if($TPL_VAR["data"]["d2"]== 0){?>text-[#E9E6E0]<?php }else{?>text-[#322A24]<?php }?> font-bold"><?php echo $TPL_VAR["data"]["d2"]?></div>
					<div class="mt-3 text-xs font-medium"><span>배송 준비</span></div>
				</div>
				<div>
					<div class="<?php if($TPL_VAR["data"]["d3"]== 0){?>text-[#E9E6E0]<?php }else{?>text-[#322A24]<?php }?> font-bold"><?php echo $TPL_VAR["data"]["d3"]?></div>
					<div class="mt-3 text-xs font-medium"><span>배송중</span></div>
				</div>
				<div>
					<div class="<?php if($TPL_VAR["data"]["d4"]== 0){?>text-[#E9E6E0]<?php }else{?>text-[#322A24]<?php }?> ont-bold"><?php echo $TPL_VAR["data"]["d4"]?></div>
					<div class="mt-3 text-xs font-medium"><span>배송 완료</span></div>
				</div>
				<div>
					<div class="<?php if($TPL_VAR["data"]["d5"]== 0){?>text-[#E9E6E0]<?php }else{?>text-[#322A24]<?php }?> font-bold"><?php echo $TPL_VAR["data"]["d5"]?></div>
					<div class="mt-3 text-xs font-medium"><span>구매 확정</span></div>
				</div>
			</div>
		</section>
		<div class="mb-5"></div>

<?php if(sizeof($TPL_VAR["datalist"])== 0){?>
		<div class="w-[739px]">
			<div class="flex w-full h-[136px] items-center justify-center text-xs text-[#C0BCB6] bg-[#322A2408]">
				주문한 상품 내역이 없어요.
			</div>
		</div>
<?php }else{?>
		<div class="w-[739px]">
<?php if($TPL_datalist_1){foreach($TPL_VAR["datalist"] as $TPL_V1){?>
			<section class="space-y-4 mt-10 w-[739px]">
				<div class="flex justify-between">
					<div class="flex items-center gap-2">
						<h2 class="text-sm font-bold text-[#322A24]"><?php echo substr($TPL_V1["odate"], 0, 10)?></h2>
<?php if($TPL_V1["isgift"]=='Y'){?>
						<div class="w-8 h-8 rounded-full flex items-center justify-center">
							<img alt="gift item" loading="lazy" width="24" height="24" decoding="async" data-nimg="1" class="w-[24px] h-[24px]" src="/img/for-gift-icon.svg" style="color: transparent;">
						</div>
<?php }?>
					</div>
					
					<a href="/mypage/?act=orderview&idx=<?php echo $TPL_V1["idx"]?>">
						<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 text-sm text-[#322A24] p-0 h-fit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right text-[#322A24]" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg></button>
					</a>
				</div>
<?php if(is_array($TPL_R2=$TPL_V1["goodslist"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<div class="border rounded-lg p-4 pt-2">
					<div class="flex justify-between items-center mb-4 text-sm">
						<span class="font-bold text-xs text-[#6F6963]">결제 완료</span>
						<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 px-4 py-2 text-[#C0BCB6] font-bold text-xs">문의하기</button>
					</div>
					<div class="flex gap-4">
						<img alt="product" loading="lazy" width="72" height="72" decoding="async" data-nimg="1" class="w-[72px] h-[72px] object-cover rounded" src="<?php echo $TPL_V2["simg1"]?>" style="color: transparent;">
						
						<div class="flex flex-col justify-between gap-0.5 text-[#322A24] text-xs">
							<div>
								<div class="font-medium leading-relaxed"><?php echo $TPL_V2["gname"]?></div>
								<div class="text-[#6F6963] leading-relaxed"><?php echo $TPL_V2["gname_pre"]?></div>
							</div>
							<div class="text-sm font-bold mt-1"><?php echo number_format($TPL_V2["account"]/ 100)?>원</div>
						</div>
					</div>
					<div class="mt-5"></div>
					<div class="flex justify-center"></div>
					<div class="flex justify-center">
						<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 px-4 w-[659px] h-[34px] border rounded py-2 text-xs font-bold bg-[#FDFBF5] text-[#6F6963] !border-[#DBD7D0] hover:bg-[#f5f3ef]">주문 취소</button>
					</div>
				</div>
<?php }}?>
			</section>
<?php }}?>
		</div>
<?php }?>
	</main>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>