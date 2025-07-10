<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicm/_common/down.htm 000008081 */ ?>
<nav class="fixed bottom-0 left-0 right-0 bg-[#FDFBF4] border-t z-10">
	<div class="flex justify-around items-center h-[60px] px-4">
		<button class="flex flex-col items-center justify-center gap-1 w-16" onclick="location.href='/';">
			<img src="/img/m/bottom1.png" alt="홈" class="w-5 h-5">
			<span class="text-xs font-bold text-black">홈</span>
		</button>
		<button class="flex flex-col items-center justify-center gap-1 w-16" onclick="location.href='/cont/?act=guide';">
			<img src="/img/m/bottom2.png" alt="향 가이드" class="w-5 h-5">
			<span class="text-xs text-gray-400">향 가이드</span>
		</button>
		<button class="flex flex-col items-center justify-center gap-1 w-16" <?php if($TPL_VAR["global"]["memislogin"]=='Y'){?>onclick="qrshowops()" <?php }else{?>onclick="location.href='/member/?act=login';"<?php }?>>
			<img  src="/img/m/bottom3.png" alt="스캔" class="w-5 h-5">
			<span class="text-xs text-gray-400">스캔</span>
		</button>
		<button class="flex flex-col items-center justify-center gap-1 w-16" onclick="location.href='/mypage/?act=wish';">
			<img src="/img/m/bottom4.png" alt="관심상품" class="w-5 h-5">
			<span class="text-xs text-gray-400">관심상품</span>
		</button>
		<button class="flex flex-col items-center justify-center gap-1 w-16" onclick="location.href='/mypage/?act=main';">
			<img src="/img/m/bottom5.png" alt="MY" class="w-5 h-5">
			<span  class="text-xs text-gray-400">MY</span>
		</button>
	</div>
</nav>
<div id="qrsbg" class="fixed hidden z-20" style="background-color:rgba(0,0,0,0.8);top:50%;left:50%; transform: translate(-50%, -50%);width: 100%;height: 100%;">
	<div id="qrs" class="relative py-6 px-4" style="top: 50%;left: 50%;transform: translate(-50%, -50%);width:90%;background-color:#FDFBF5">
		<div id="qrs1">
			<div style="position:absolute;top:-40px;right:0">
				<a href="#none" onclick="event.preventDefault();qrshowops() "><img src="/img/m/icon_CLOSE_beige.svg"></a>
			</div>
		
			<div class="pb-1 text-[#FF6B62] text-xs text-center">10:00</div>
			<div class="text-[#000000] text-base font-bold text-center pb-8">나의 QR 코드</div>
			<div class="text-center flex items-center justify-center pb-6"><img src="/img/m/qrs.png"></div>
			<div class="flex items-center px-4 pb-4">
				<div style="flex:1;py-5" onclick="$('#qrs1').addClass('hidden');$('#qrs2').removeClass('hidden');">
					<div class="text-center flex justify-center pb-2">
						<img src="/img/m/icon_STAMP_dark.svg">
					</div>
					<div class="text-center text-[#322A24] text-sm font-medium">
						콤포타블 커피<br />스탬프
					</div>
				</div>
				<div style="border-right:1px dashed #C0BCB6;height:60px;"></div>
				<div style="flex:1;py-5" onclick="$('#qrs1').addClass('hidden');$('#qrs3').removeClass('hidden');">
					<div class="text-center flex justify-center pb-2">
						<img src="/img/m/icon_NOTE_dark.svg">
					</div>
					<div class="text-center text-[#322A24] text-sm font-medium">그랑핸드<br />패스포트</div>
				</div>
			</div>
			<div class="text-center">
				<a href="#none" class="text-xs text-[#C0BCB6] font-bold" onclick="event.preventDefault(); $('#cguide').removeClass('hidden');">스탬프 및 QR 이용안내</a>
			</div>
			
		</div>
		<div id="qrs2" class="hidden">
			<div style="position:absolute;top:-40px;right:0">
				<a href="#none" onclick="event.preventDefault();qrshowops() "><img src="/img/m/icon_CLOSE_beige.svg"></a>
			</div>
			<div class="pt-6 pb-6 text-[#00000] font-bold text-base text-center">콤포타블 스탬프</div>
			<div class="text-[#6F6963] text-sm text-medium text-center pb-12">
			콤포타블 커피에서 스탬프를 모아보세요!<br /> 5/10/15/20개를 모으면 쿠폰으로 사용할 수 있어요.
			</div>
			<div class="flex items-center justify-between pb-2">
				<a class="flex items-center" href="#none" onclick="event.preventDefault();$('#qrs2').addClass('hidden');$('#qrs1').removeClass('hidden');">
					<img src="/img/m/icon_ARROWLEFT_dark.png">
					<div class="text-[#5E5955] text-xs font-medium">뒤로가기</div>
				</a>
				<div class="text-[#5E5955] text-xs font-medium">
					0 / 20
				</div>
			</div>
			<div style="background: rgba(50, 42, 36, 0.03);max-height:300px;min-height:300px;overflow-y:scroll;flex-wrap: wrap;" class="flex justify-between px-2 py-5">
<?php if(is_array($TPL_R1=get_count( 20))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				<div class="<?php if($TPL_I1> 4){?>pt-6<?php }?>">
<?php if($TPL_I1% 5== 4){?>
					<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
						<circle cx="25" cy="25" r="24.5" fill="#FDFBF5" stroke="#DBD7D0"/>
					</svg>
<?php }else{?>
					<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
						<circle cx="25" cy="25" r="24.5" fill="#FDFBF5" stroke="#DBD7D0"/>
					</svg>
<?php }?>
				</div>
<?php }}?>
			</div>
		</div>
		<div id="qrs3" class="hidden">
			<div style="position:absolute;top:-40px;right:0">
				<a href="#none" onclick="event.preventDefault();qrshowops() "><img src="/img/m/icon_CLOSE_beige.svg"></a>
			</div>
			<div class="pt-6 pb-3 text-[#00000] font-bold text-base text-center">그랑핸드 패스포트</div>
			<div class="text-[#6F6963] text-sm text-medium text-center pb-12">
				그랑핸드 전 매장에서 스탬프를 모아보세요!<br />전 지점 스탬프를 모으시면<br />패스포트 챌린지 달성 쿠폰을 선물해 드려요.
			</div>
			<div class="flex items-center justify-between pb-2">
				<a class="flex items-center" href="#none" onclick="event.preventDefault();$('#qrs3').addClass('hidden');$('#qrs1').removeClass('hidden');">
					<img src="/img/m/icon_ARROWLEFT_dark.png">
					<div class="text-[#5E5955] text-xs font-medium">뒤로가기</div>
				</a>
				<div class="text-[#5E5955] text-xs font-medium">
					0 / 8
				</div>
			</div>
			<div style="background: rgba(50, 42, 36, 0.03);flex-wrap: wrap;" class="px-4 py-4" >
				<div class="flex justify-between">
<?php if(is_array($TPL_R1=get_count( 4))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<div>
					<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
						<circle cx="25" cy="25" r="24.5" fill="#FDFBF5" stroke="#E9E6E0"/>
					</svg>
				</div>
				
<?php }}?>
				</div>
				<div class="flex justify-between">
<?php if(is_array($TPL_R1=get_count( 4))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				
				<div class="pt-6">
					<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
						<circle cx="25" cy="25" r="24.5" fill="#FDFBF5" stroke="#E9E6E0"/>
					</svg>
				</div>
<?php }}?>
				</div>
				
			</div>
			<div class="pt-4">
					<button type="submit" id="f_submit" class="w-full block h-[46px] mb-4 text-sm text-[#FFFFFF] font-bold disabled:opacity-15 bg-[#322A24]" disabled>쿠폰저장</button>
			</div>
			<div style="bottom:-46px;left: 50%;transform: translate(-50%, -50%);" class="absolute">
				<a class="flex items-center" href="#none" onclick="event.preventDefault(); qrscan();">
					<div>
						<img src="/img/m/icon_SCAN_dark.svg">
					</div>
					<div class="pl-2.5 text-[#FDFBF5] text-xs font-medium">QR 스캔으로 스탬프 찍기</div>
				</a>
			</div>
		</div>
	</div>
</div>
<div id="cguide" class="fixed hidden z-50 bg-[#FDFBF5]" style="top:0;left:0;width: 100%;height: 100%;">
	<div class="h-[58px] px-6 flex justify-end items-center">
		<a href="#none" onclick="event.preventDefault(); $('#cguide').addClass('hidden');"><img src="/img/m/icon_CLOSE_dark.svg"></a>
	</div>
	<div class="px-6">
		<div class="text-[#000000] text-lg font-bold">스탬프 및 QR 이용안내</div>
	</div>
</div>
</body>
</html>