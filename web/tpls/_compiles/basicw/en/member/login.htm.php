<?php /* Template_ 2.2.7 2025/07/08 17:45:29 /home/grandhand/BUILDS/tpls/basicw/member/login.htm 000007327 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
$(document).ready(function () {
	
	$('#f_loginform').on('submit', function (e) {
		e.preventDefault();
		const id = $('#f_id').val().trim();
		const passwd = $('#f_passwd').val().trim();
		

		if (id === '') {
			alert('아이디를 입력해주세요.');
			$('#f_id').focus();
			return;
		}

		if (passwd === '') {
			alert('비밀번호를 입력해주세요.');
			$('#f_passwd').focus();
			return;
		}

		this.submit();
	});
	
	const $id     = $('#f_id');
	const $pwd    = $('#f_passwd');
	const $submit = $('#f_submit');
	const $idMsg   = $('#f_idmsg');
	const $pwdMsg  = $('#f_passwdmsg');

	const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	const passReg  = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/;

	function validate() {
		const idVal  = $id.val().trim();
		const pwdVal = $pwd.val();
		
		/* --- 아이디 검증 --- */
		let idOk = false;
		if (idVal === '') {
			$idMsg.text('아이디를 입력하세요.').removeClass('hidden');
			$id.addClass('bg-[#FF3E24]');
		} else if (!emailReg.test(idVal)) {
			$idMsg.text('이메일 형식이 올바르지 않습니다.').removeClass('hidden');
			$id.addClass('bg-[#FF3E24]');
		} else {
			idOk = true;
			$idMsg.addClass('hidden');
			$id.removeClass('bg-[#FF3E24]');
		}

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

		console.log(idOk);
		console.log(pwdOk);
		$submit.prop('disabled', !(idOk && pwdOk));
	}

	// 포커스가 빠져나올 때 검사
	$id.on('blur', validate);
	$pwd.on('blur', validate);
	
	$("#remember").on("click", function() {
		alert('aa');
		const isChecked = $(this).attr("aria-checked") === "true";
		$(this).attr("aria-checked", !isChecked);
		$(this).attr("data-state", !isChecked ? "checked" : "unchecked");
	});
	
});
</script>
<?php $this->print_("top",$TPL_SCP,1);?>

<div class="space-y-6 container mx-auto  pt-8">
	<h2 class="text-lg font-medium text-left mb-8 border-b border-b-[#6f6963] pb-4 text-[#6F6963] leading-[26px]">로그인</h2>
	<main class="max-w-sm mx-auto">
		<?php echo $TPL_VAR["login"]["form_start"]?>

			<section class="space-y-4 mb-24">
				<div class="space-y-2">
					<label class="text-sm leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-[#322A24] font-[500]" for="«r3»-form-item">아이디</label>
					<input class="flex bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[358px] border !border-[#C0BCB6] px-[18px] py-[12px] text-sm rounded-none h-[46px] mt-2 placeholder:text-[#C0BCB6] undefined" name="id" id="f_id" placeholder="이메일을 입력해 주세요." type="text" value="" name="id">
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="f_idmsg"></div>
				<div class="space-y-2">
					<label class="text-sm leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-[#322A24] font-[500]" for="«r4»-form-item">비밀번호</label>
					<input class="flex bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[358px] border !border-[#C0BCB6] px-[18px] py-[12px] text-sm rounded-none h-[46px] mt-2 placeholder:text-[#C0BCB6] undefined" type="password" name="passwd" id="f_passwd" placeholder="비밀번호를 입력해 주세요." >
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="f_passwdmsg"></div>
				<div class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex space-x-2 items-center">
					<div class="">
						<input type="checkbox" id="agree3" class="chk-hidden agree-item">
						<label for="agree3" class="chk-img"></label>
					</div>
					<span class="text-sm text-[#322A24] font-[500]">로그인 상태 유지</span>
				</div>
			</section>
			<button id="f_submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 py-2 w-[358px] h-[46px] bg-[#322A24] text-[#FDFBF5] font-bold mb-4 cursor-pointer disabled:bg-[#DBD7D0]" type="submit" disabled >로그인</button>
		<?php echo $TPL_VAR["login"]["form_end"]?>

		<a href="/member/?act=joinstep1">
			<button onclick="location.href='/member/?act=joinstep1';" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-4 py-2 w-[358px] h-[46px] !border-[#6F6963] text-[#322A24] font-bold mb-4 cursor-pointer">회원가입</button>
		</a>
		<div class="flex justify-center space-x-4 text-sm text-[#322A24]">
			<a class="font-[500]" href="/member/?act=findid">아이디 찾기</a>
			<span class="text-[#C0BCB6] w-[1px]">|</span>
			<a class="font-[500]" href="/member/?act=findpasswd">비밀번호 찾기</a>
		</div>
		<div class="flex items-center mt-14 mb-6">
			<div class="flex-grow border-t !border-[#E9E6E0]"></div>
			<span class="px-4 text-sm text-[#322A24] font-[500]">간편 로그인</span>
			<div class="flex-grow border-t !border-[#E9E6E0]"></div>
		</div>
		<div class="flex justify-around space-x-6 w-full">
			<button class="text-white rounded-full w-12 h-12 flex items-center justify-center">
				<img alt="Apple Login" loading="lazy" class="w-[48px] h-[48px]"  src="/img/Logo_Apple.png" style="">
			</button>
			<button class="text-white rounded-full w-12 h-12 flex items-center justify-center">
				<img alt="Naver Login" loading="lazy" src="/img/Logo_Naver.png" style="">
			</button>
			<button class="bg-yellow-300 text-black rounded-full w-12 h-12 flex items-center justify-center">
				<img alt="Kakao Login" loading="lazy" class="w-[48px] h-[48px]"  src="/img/Logo_Kakao.png" style="">
			</button>
		</div>
	</main>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>