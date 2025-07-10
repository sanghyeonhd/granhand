<?php /* Template_ 2.2.7 2025/07/10 09:40:58 /home/grandhand/BUILDS/tpls/basicw/mypage/mycouponregi.htm 000006736 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
$(document).ready(function () {
	
	
	
	const $id     = $('#f_co');
	const $submit = $('#f_next');
	const $idMsg   = $('#f_idmsg');
	
	function validate() {
		const idVal  = $id.val().trim();
		
		/* --- 아이디 검증 --- */
		let idOk = false;
		if (idVal === '') {
			$idMsg.text('쿠폰번호를 입력하세요.').removeClass('hidden');
			$id.addClass('bg-[#FF3E24]');
		} else {
			idOk = true;
			$idMsg.addClass('hidden');
			$id.removeClass('bg-[#FF3E24]');
		}

		
		$submit.prop('disabled', !idOk);
	}

	// 포커스가 빠져나올 때 검사
	$id.on('blur', validate);

	
	
});
function set_next()	{
	alert('등록할수 없는 쿠폰입니다');	
}
</script>
<?php $this->print_("top",$TPL_SCP,1);?>

<div class="container mx-auto pt-8">
	<div class="w-full py-10 mx-auto text-[#6F6963]">
		<div class="flex justify-between">
			<h1 class="text-lg font-medium mb-8">쿠폰 등록</h1>
		</div>
	</div>
	<div class="flex w-full min-h-screen text-gray-900">
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
					<div class="flex justify-between items-center cursor-pointer text-sm font-bold text-[#5E5955] mypagemenu">나의 쿠폰함
						<svg class="open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-[24px] h-[24px]" aria-hidden="true"><path d="m18 15-6-6-6 6"></path></svg>
						
						<svg class="off hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-[24px] h-[24px]" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
					</div>
					<ul class="mt-2 space-y-1 text-sm font-medium">
						<a href="/mypage/?act=mycoupon">
							<li class="px-6 py-2 text-[#C0BCB6]">보유 쿠폰</li>
						</a>
						<a href="/mypage/?act=mycouponregi">
							<li class="px-6 py-2 text-[#C0BCB6] bg-[#322A2408] rounded">쿠폰 등록</li>
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
	<div class="container mx-auto px-6 pt-8 max-w-4xl w-[639px]">
		<h2 class="text-sm font-bold mb-4 text-[#322A24]">쿠폰번호</h2>
		<div class="flex items-center gap-2">
			<input id="f_co" class="flex border rounded-md bg-background px-[16px] py-[12px] text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm flex-1 w-[639px] h-[46px] text-sm !border-[#C0BCB6] placeholder:text-[#C0BCB6]" placeholder="쿠폰번호를 입력해 주세요." value="">
			<button id="f_next" type="button" onclick="set_next();" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 py-2 w-[88px] h-[46px] px-6 text-white text-sm font-semibold bg-[#322A24] disabled:bg-[#DBD7D0]" disabled>쿠폰 등록</button>
		</div>
		<div class="hidden text-[#FF3E24] text-[10px]" id="f_idmsg"></div>
	</div>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>