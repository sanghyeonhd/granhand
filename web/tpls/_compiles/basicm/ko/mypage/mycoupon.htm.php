<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicm/mypage/mycoupon.htm 000001368 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="h-[58px] flex px-6 items-center">
			<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
			<div class="text-lg font-bold">나의 쿠폰함</div>
		</div>
		<div class="pt-4 px-6">
			<div class="flex pb-6">
				<a href="/mypage/?act=mycoupon" class="text-sm font-bold text-[#322A24]">보유쿠폰(0)</a>
				<a href="/mypage/?act=mycouponregi" class="pl-4 text-sm font-bold text-[#C0BCB6]">쿠폰 등록</a>				
			</div>
			<div class="flex">
				<a href="/mypage/?act=mycoupon&order=1" class="text-xs font-bold <?php if($_REQUEST["order"]== 1||!$_REQUEST["order"]){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?>">최신순</a>
				<a href="/mypage/?act=mycoupon&order=2" class="pl-4 text-xs font-bold  <?php if($_REQUEST["order"]== 2){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?>">유효기간순</a>				
			</div>
			<div class=" px-6">
				<div class="py-20 text-center text-[#C0BCB6] text-sm">
					보유 중인 쿠폰이 없어요.
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>