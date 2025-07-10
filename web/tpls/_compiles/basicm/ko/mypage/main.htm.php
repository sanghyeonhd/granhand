<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicm/mypage/main.htm 000004299 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="h-[58px] flex px-6 items-center justify-between">
			<div class="text-lg font-bold">마이페이지</div>
			<div class="flex items-center">
				<a href="/mypage/?act=alarm" class="pr-6"><img src="/img/m/icon_ALARM_dark.png"></a>
				<a href="/order/?act=cart"><img src="/img/m/icon_CART_dark.png"></a>				
			</div>
		</div>
		<div class="pt-6 px-6">
			<div class="flex items-center justify-between pb-10">
				<div class="flex items-center">
					<img src="/img/m/Group 1000001529.png">
					<div class="pl-6 text-xl text-[#322A24] font-bold">
						<?php echo $TPL_VAR["gmem"]["name"]?>님
					</div>
				</div>
				<div>
					<a href="/mypage/?act=gradeinfo" class="text-[#6F6963] text-xs font-bold" style="background-color:#322A240A;padding:7px 14px">등급 안내</a>
				</div>
			</div>
			<div class="text-sm font-medium text-[#C0BCB6] pb-4"><span class="text-[#322A24]">100,000원</span> 추가 구매 시 Bronze 달성<br />다음달 예상 등급 Basic</div>
			<div>
				<div style="height:3px;background-color:#322A240A" class="mb-2">
				
				</div>
				<div class="flex items-center justify-between mb-6">
					<div class="text-[#322A24] text-[10px] font-medium" >0원</div>
					<div class="text-[#C0BCB6] text-[10px] font-medium" >100,000원</div>
				</div>
			</div>
			<div class=" mb-4"><img src="/img/m/Group 1000001672.png" style="width:100%;"></div>
			<A href="/mypage/?act=mycoupon" class="flex items-center justify-center text-[#322A24] text-sm font-bold h-[46px] border-[#C0BCB6] border mb-6 w-full">나의 쿠폰함</a>
			<div class="flex items-center justify-around mb-6">
				<a href="/mypage/?act=point" class="flex flex-col items-center">
					<img src="/img/m/icon_POINT_dark.png" class="mb-2">
					<div class=" text-[#C0BCB6] text-sm font-medium text-center">
						포인트
					</div>
				</a>
				<a href="/mypage/?act=check"  class="flex flex-col items-center">
					<img src="/img/m/icon_CALENDAR_dark.png" class="mb-2">
					<div class="text-[#C0BCB6] text-sm font-medium text-center">
						출석체크
					</div>
				</a>
				<a href="/mypage/?act=mygift" class="flex flex-col items-center">
					<img src="/img/m/icon_GIFT_dark.png" class="mb-2">
					<div class="text-[#C0BCB6] text-sm font-medium text-center">
						선물함
					</div>
				</a>
				<a href="/mypage/?act=myorder" class="flex flex-col items-center">
					<img src="/img/m/icon_LIST_dark.png" class="mb-2">
					<div class="text-[#C0BCB6] text-sm font-medium text-center">
						주문내역
					</div>
					
				</a>
			</div>
			<a href="/mypage/?act=recent" class="flex items-center justify-between h-[62px]">
				<div class="text-base text-[#322A24] font-medium">최근 본 상품</div>
				<img src="/img/m/icon_ARROWRIGHT_dark.png">
			</a>
			<a href="/mypage/?act=challenge" class="flex items-center justify-between h-[62px]">
				<div class="text-base text-[#322A24] font-medium">챌린지</div>
				<img src="/img/m/icon_ARROWRIGHT_dark.png">
			</a>
			<a href="/mypage/?act=cancel" class="flex items-center justify-between h-[62px]">
				<div class="text-base text-[#322A24] font-medium">취소/교환/반품 내역</div>
				<img src="/img/m/icon_ARROWRIGHT_dark.png">
			</a>
			<a href="/mypage/?act=myinfo" class="flex items-center justify-between h-[62px]">
				<div class="text-base text-[#322A24] font-medium">회원정보</div>
				<img src="/img/m/icon_ARROWRIGHT_dark.png">
			</a>
			<a href="/mypage/?act=center" class="flex items-center justify-between h-[62px]">
				<div class="text-base text-[#322A24] font-medium">고객센터</div>
				<img src="/img/m/icon_ARROWRIGHT_dark.png">
			</a>
			<a href="/mypage/?act=config" class="flex items-center justify-between h-[62px]">
				<div class="text-base text-[#322A24] font-medium">설정</div>
				<img src="/img/m/icon_ARROWRIGHT_dark.png">
			</a>
			
			<div style="padding-bottom:70px;"></div>
		</div>
	</div>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>