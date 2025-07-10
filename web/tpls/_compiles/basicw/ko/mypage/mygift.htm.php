<?php /* Template_ 2.2.7 2025/07/10 11:13:46 /home/grandhand/BUILDS/tpls/basicw/mypage/mygift.htm 000009108 */ 
$TPL_datalist_1=empty($TPL_VAR["datalist"])||!is_array($TPL_VAR["datalist"])?0:count($TPL_VAR["datalist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


<?php $this->print_("top",$TPL_SCP,1);?>

<div class="container mx-auto pt-8">
	<div class="w-full py-10 mx-auto text-[#6F6963]">
		<div class="flex justify-between">
			<h1 class="text-lg font-medium mb-8">행운 뽑기</h1>
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
					<div class="flex justify-between items-center cursor-pointer text-sm font-bold text-[#5E5955]">마이페이지
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-[24px] h-[24px]" aria-hidden="true"><path d="m18 15-6-6-6 6"></path></svg>
					</div>
					<ul class="mt-2 space-y-1 text-sm font-medium">
						<a href="/mypage/?act=main">
							<li class="px-6 py-2  text-[#6F6963]">마이페이지</li>
						</a>
						<a href="/mypage/?act=myorder">
							<li class="px-6 py-2 text-[#C0BCB6]">주문 내역</li>
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
					<div class="flex justify-between items-center cursor-pointer text-sm font-bold text-[#5E5955]">나의 쿠폰함
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-[24px] h-[24px]" aria-hidden="true"><path d="m18 15-6-6-6 6"></path></svg>
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
				<div class="flex justify-between items-center cursor-pointer text-sm font-bold text-[#5E5955]">회원 정보
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-[24px] h-[24px]" aria-hidden="true"><path d="m18 15-6-6-6 6"></path></svg>
				</div>
				<ul class="mt-2 space-y-1 text-sm font-medium">
					<a href="/mypage/?act=myinfo">
						<li class="px-6 py-2 text-[#C0BCB6] ">회원 정보 수정</li>
					</a>
				</ul>
			</div>
		</div>
	</aside>
	<main class="w-[738px] mx-auto ml-10">
		<section class="space-y-6 mt-16">
			<div class="flex gap-4 text-sm text-gray-400 items-center">
				<button type="button" onclick="location.href='/mypage/?act=mygift&menu=1'" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 text-sm font-bold false <?php if($TPL_VAR["data"]["menu"]== 1){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> semibold hover:text-black transition-colors min-w-[5%] p-0">받은 선물</button>
				<button type="button" onclick="location.href='/mypage/?act=mygift&menu=2'" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 text-sm font-bold <?php if($TPL_VAR["data"]["menu"]== 2){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> hover:text-black transition-colors min-w-[5%] p-0">보낸 선물</button>
			</div>
		</section>
<?php if(sizeof($TPL_VAR["datalist"])== 0){?>
		<div class="w-[739px]">
			<div class="flex w-full h-[136px] items-center justify-center text-xs text-[#C0BCB6] bg-[#322A2408]">
				내역이 없어요.
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