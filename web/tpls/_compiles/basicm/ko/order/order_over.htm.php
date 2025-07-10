<?php /* Template_ 2.2.7 2025/07/10 11:47:00 /home/grandhand/BUILDS/tpls/basicm/order/order_over.htm 000005594 */ 
$TPL_goodslist_1=empty($TPL_VAR["goodslist"])||!is_array($TPL_VAR["goodslist"])?0:count($TPL_VAR["goodslist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>


</head>
<body class="bg-[#FDFBF5]">
<div id="root" class="bg-[#FDFBF5]">
	<div class="bg-[#FDFBF5]">
		<div class="fixed top-0 left-0 right-0 h-[58px] flex px-6 items-center  bg-[#FDFBF4]">
			<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
			<div class="text-lg font-bold">구매완료</div>
		</div>
		<div class="px-6" style="padding-top:90px;">
			<div class="pb-8">
				<div class="text-[#322A24] text-base font-bold pb-1 text-center">구매가 완료되었습니다.</div>
				<div class="text-[#6F6963] text-sm font-medium pb-1 text-center">고객님의 소중한 상품, 곧 보내드릴게요.</div>
			</div>
			<div class="border rounded-md p-6 space-y-6 mb-4">
<?php if($TPL_goodslist_1){foreach($TPL_VAR["goodslist"] as $TPL_V1){?>
			<div class="space-y-4">
				<div class="flex gap-4">
					<img alt="product" loading="lazy" width="1440" height="1080" decoding="async" data-nimg="1" class="w-24 object-cover rounded" src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="color: transparent;">
					<div class="flex-1 space-y-3">
						<div class="text-sm font-bold text-[#C0BCB6]"><?php echo $TPL_V1["gname"]?></div>
						<div class="space-y-1">
							<div class="text-sm font-semibold text-[#322A24] mt-1">Roland Multi Perfume</div>
							<div class="text-base text-[#322A24] font-bold mt-1"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_V1["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></div>
						</div>
					</div>
				</div>
				<div class="text-sm border-t border-dashed pt-4 space-y-1 text-[#6F6963]">
					<div class="flex hidden">
						<span class="text-[#C0BCB6] w-24">옵션</span>
						<span class="ml-4">롤랑 멀티퍼퓸 200ml / 1개</span>
					</div>
					<div class="flex">
						<span class="text-[#C0BCB6] w-24">쇼핑백</span><span class="ml-4">구매 안함</span>
					</div>
					<div class="flex">
						<span class="text-[#C0BCB6] w-24">스탬핑 여부</span>
						<span class="ml-4">N</span>
					</div>
				</div>
			</div>
<?php }}?>
			</div>
			<div class="border rounded-md p-6 space-y-3 shadow-md text-xs text-[#6F6963]">
			<div class="flex justify-between">
				<span class="text-[#C0BCB6]">총주문금액</span><span><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo number_format($TPL_VAR["order"]["account"])?><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
			</div>
			<div class="flex justify-between">
				<span class="text-[#C0BCB6]">배송비</span><span><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo number_format($TPL_VAR["order"]["delaccount"]/ 100)?><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
			</div>
			<div class="flex justify-between">
				<span class="text-[#C0BCB6]">쿠폰 할인</span><span>-<?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo number_format($TPL_VAR["order"]["use_coupen2"]/ 100)?><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
			</div>
			<div class="flex justify-between">
				<span class="text-[#C0BCB6]">포인트 사용</span><span>-<?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo number_format($TPL_VAR["order"]["use_mempoint"]/ 100)?><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
			</div>
			<hr class="my-2 border-dashed">
			<div class="flex justify-between font-semibold text-[#322A24]">
				<span>결제 금액</span><span class="text-base font-bold"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo number_format($TPL_VAR["order"]["use_account"])?><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
			</div>
			<div class="flex justify-between ml-2">
				<span class="text-[#C0BCB6]">└ <?php echo trs($TPL_VAR["order"]["buym"])?> 결제</span><span><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo number_format($TPL_VAR["order"]["use_account"])?><?php echo $TPL_VAR["curr"]["showdan2"]?></span>
			</div>
			</div>
			<div class="flex justify-center gap-4 pt-6">
				<a href="/mypage/?act=orderview&idx=<?php echo $_REQUEST["idx"]?>" style="flex:1">
					<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-4 py-2 text-[#322A24] text-sm w-[163px] h-[46px] rounded-none font-bold !border-[#C0BCB6] cursor-pointer" style="width:100%;">주문 상세</button>
				</a>
				<a href="/shop/?act=list" style="flex:1">
					<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 py-2 w-[163px] h-[46px] bg-[#322A24] text-sm text-white rounded-none font-bold cursor-pointer" style="width:100%;">쇼핑 계속하기</button>
				</a>
		</div>
		</div>
	</div>
</div>
</body>
</html>