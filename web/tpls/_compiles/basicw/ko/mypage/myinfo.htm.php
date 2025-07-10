<?php /* Template_ 2.2.7 2025/07/10 09:42:41 /home/grandhand/BUILDS/tpls/basicw/mypage/myinfo.htm 000007838 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
$(document).ready(function () {
	

	const $pwd    = $('#f_passwd');
	const $submit = $('#f_submit');
	const $pwdMsg  = $('#f_passwdmsg');

	const passReg  = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/;

	function validate() {
		
		const pwdVal = $pwd.val();
		
		/* --- 비밀번호 검증 --- */
		let pwdOk = false;
		if (pwdVal === '') {
			$pwdMsg.text('비밀번호를 입력하세요.').removeClass('hidden');
			$pwd.addClass('bg-[#FF3E24]');
		} else if (!passReg.test(pwdVal)) {
			$pwdMsg.text('비밀번호는 영문, 숫자, 특수문자 포함 8자리 이상입니다.').removeClass('hidden');
			$pwd.addClass('bg-[#FF3E24]');
		} else {
			pwdOk = true;
			$pwdMsg.addClass('hidden');
			$pwd.removeClass('bg-[#FF3E24]');
		}


		$submit.prop('disabled', !pwdOk);
	}

	// 포커스가 빠져나올 때 검사
	
	$pwd.on('blur', validate);

	
});
function checkpasswd()	{
	const $pwd    = $('#f_passwd');
	const pwdVal = $pwd.val();
	
	 $.getJSON("/exec/proajax.php?act=member&han=set_chkpass&passwd="+pwdVal, function(data) {
		
		if(data.res=='ok')	{
			location.href='/mypage/?act=mymod';	
		}	else	{
			alert(data.resmsg);	
		}
			 
	});
		
}
</script>
<?php $this->print_("top",$TPL_SCP,1);?>

<div class="container mx-auto pt-8">
	<div class="w-full py-10 mx-auto text-[#6F6963]">
		<div class="flex justify-between">
			<h1 class="text-lg font-medium mb-8">회원 정보 수정</h1>
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
						<li class="px-6 py-2 text-[#C0BCB6] bg-[#322A2408] rounded">회원 정보 수정</li>
					</a>
				</ul>
			</div>
		</div>
	</aside>
	<div class="container px-6 ml-16 max-w-md w-[358px]">
		<h2 class="text-lg font-bold mb-2 text-[#322A24]">비밀번호 재확인</h2>
		<p class="text-sm text-[#6F6963] font-medium mb-8">회원님의 정보를 안전하게 보호하기 위해 비밀번호를 다시 한 번 확인해 주세요.</p>
		<div class="mb-6">
			<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block text-sm font-medium mb-1 text-[#322A24]">아이디</label>
			<div class="w-[358px] h-[46px] px-4 flex items-center border !border-[#C0BCB6] bg-[#E9E6E0] rounded text-sm text-[#6F6963]"><?php echo $TPL_VAR["gmem"]["id"]?></div>
		</div>
		<div class="mb-6">
			<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 block text-sm font-semibold mb-1 text-[#322A24]">비밀번호</label>
			<input class="flex rounded-md bg-background px-[16px] py-[12px] text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[358px] h-[46px] text-sm border !border-[#C0BCB6] placeholder:text-[#C0BCB6]" placeholder="현재 비밀번호를 입력해 주세요." type="password" name="passwd" id="f_passwd">
		</div>
		<button type="button" onclick="checkpasswd();" id="f_submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 py-2 w-[358px] h-[46px] text-sm font-bold text-white bg-[#322A24] disabled:bg-[#DBD7D0]" disabled>확인</button>
	</div>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>