<?php /* Template_ 2.2.7 2025/07/08 17:45:29 /home/grandhand/BUILDS/tpls/basicw/member/joinstep2.htm 000007158 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
$(document).ready(function () {
	
	const $id     = $('#f_id');
	const $pwd    = $('#f_passwd');
	const $repwd    = $('#f_repasswd');
	const $submit = $('#f_next');
	const $idMsg   = $('#f_idmsg');
	const $pwdMsg  = $('#f_passwdmsg');
	const $repwdMsg  = $('#f_repasswdmsg');

	const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	const passReg  = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/;

	function validate() {
		const idVal  = $id.val().trim();
		const pwdVal = $pwd.val();
		const repwdVal = $repwd.val();
		
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
		
		/* --- 비밀번호 검증 --- */
		let repwdOk = false;
		if (repwdVal === '') {
			$repwdMsg.text('비밀번호 확인을 입력하세요.').removeClass('hidden');
			$repwd.addClass('bg-[#FF3E24]');
		} else {
			if (pwdVal != repwdVal) {
				$repwdMsg.text('비밀번호가 맞지 않습니다.').removeClass('hidden');
				$repwd.addClass('bg-[#FF3E24]');
			}
			else{
				
				repwdOk = true;
				$repwdMsg.addClass('hidden');
				$repwd.removeClass('bg-[#FF3E24]');
			}
		}

		console.log(idOk);
		console.log(pwdOk);
		$submit.prop('disabled', !(idOk && pwdOk && repwdOk));
	}

	// 포커스가 빠져나올 때 검사
	$id.on('blur', validate);
	$pwd.on('blur', validate);
	$repwd.on('blur', validate);
});
function checkmember()	{
	const idVal  = $('#f_id').val().trim();
	const pwdVal = $('#f_passwd').val();
	
	if(idVal != '' && pwdVal != '')	{
		$.get('/exec/proajax.php?act=member&han=prejoin&id='+idVal+'&passwd='+pwdVal, function(response) {
			if(response.res=='ok')	{
				location.href='/member/?act=joinstep3&pre_idx='+response.pre_idx;	
			}	else	{
				location.href='/member/?act=exists';	
			}
	
		});
	}
}
</script>
<?php $this->print_("top",$TPL_SCP,1);?>

<div class="container mx-auto px-6 pt-8 ">
	<h2 class="text-lg text-[#6F6963] font-medium text-left mb-4 border-b border-b-[#6f6963] pb-4 leading-[26px]">회원가입</h2>
	<div class="flex items-center mb-8">
		<button type="button" onclick="history.back();" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2 w-4 h-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left w-4 h-4 text-[#6F6963] mr-3" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg></button>
		<div class="text-sm font-medium items-center text-[#6F6963] leading-[22px]">이전 단계</div>
	</div>
	<div class="w-full max-w-2xl flex flex-col items-center mx-auto">
		<div class="w-[358px] mt-8">
			<div class="w-[358px] h-[4px] mb-10">
				<div class="h-1 bg-[#ECE9E2] rounded">
					<div class="h-1 bg-[#6F6963] rounded" style="width:50%;"></div>
				</div>
			</div>
			<div class="mb-8">
				<h1 class="text-base font-medium text-[#322A24] mb-10 leading-[24px]">로그인에 사용할 아이디/비밀번호를 입력해 주세요.</h1>
				<div class="mb-2 text-sm font-medium text-[#322A24] leading-[22px]">아이디</div>
				<div class="mb-6">
					<input class="flex bg-background px-[16px] py-[12px] text-base text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[358px] h-[46px] border !border-[#C0BCB6] rounded !text-sm placeholder-[#C0BCB6] leading-[2px] undefined" placeholder="이메일을 입력해 주세요." name="id" id="f_id" >
					<div class="hidden text-[#FF3E24] text-[10px]" id="f_idmsg"></div>
				</div>
				<div class="mb-2 text-sm font-medium text-[#322A24] leading-[22px]">비밀번호</div>
				<div class="mb-2">
					<input type="password" name="passwd" id="f_passwd" placeholder="비밀번호 입력(영문, 숫자, 특수문자 포함 8~20 이내)" class="flex bg-background px-[16px] py-[12px] text-base text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[358px] h-[46px] border !border-[#C0BCB6] rounded !text-sm placeholder-[#C0BCB6] leading-[2px] undefined">
					<div class="hidden text-[#FF3E24] text-[10px]" id="f_passwdmsg"></div>
				</div>
				<div class="mb-24">
					<input type="password" name="repasswd" id="f_repasswd" placeholder="비밀번호 확인"  class="flex bg-background px-[16px] py-[12px] text-base text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[358px] h-[46px] border !border-[#C0BCB6] rounded !text-sm placeholder-[#C0BCB6] leading-[2px] undefined">
					<div class="hidden text-[#FF3E24] text-[10px]" id="f_repasswdmsg"></div>
				</div>
				<button type="button" onclick="checkmember()" id="f_next" class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 w-[358px] h-[46px] py-5 bg-[#302c26] text-[#FDFBF5] text-sm font-bold rounded cursor-pointer disabled:bg-[#DBD7D0]" disabled>다음</button>
			</div>
		</div>
	</div>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>