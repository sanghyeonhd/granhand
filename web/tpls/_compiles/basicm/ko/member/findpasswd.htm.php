<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicm/member/findpasswd.htm 000002827 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
$(document).ready(function () {
	
	
	const $id     = $('#f_id');
	const $submit = $('#f_submit');
	const $idMsg   = $('#f_idmsg');


	const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


	function validate() {
		const idVal  = $id.val().trim();

		
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

		console.log(idOk);
		$submit.prop('disabled', !idOk);
	}

	// 포커스가 빠져나올 때 검사
	$id.on('blur', validate);
});
</script>
</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="fixed top-0 left-0 right-0 z-20 bg-[#FDFBF4]">
			<div class="h-[58px] flex px-6 items-center ">
				<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
				
			</div>
		</div>
		<div class="px-6" style="padding-top:104px">
			<div class="pb-6">
				<Div class="text-[#322A24] text-lg font-bold pb-4">비밀번호 찾기</div>
				<div class="text-[#6F6963] text-sm font-medium">가입한 아이디(이메일)를 입력해 주세요.<br />휴대폰 본인인증을 통해 아이디(이메일)를 확인합니다.</div>
			</div>
			<div class="text-sm text-[#322A24] font-medium pb-2">아이디</div>
			<div class="mb-4">
				<div class="h-[46px] border-[#C0BCB6] border mb-1">
					<input type="text" name="id" id="f_id" placeholder="이메일을 입력해 주세요." class="block px-4 bg-[#FDFBF4] w-full h-[44px] font-medium" />
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="f_idmsg"></div>
			</div>
		</div>
		
	</div>
</div>
<div class="fixed px-6" style="bottom:24px;left:0;right:0;">
	<div  class="mb-8 px-4 py-4" style="background-color:#322A2408;">
		<div class="text-sms text-[#6F6963] font-medium">SNS 계정으로 가입하신 회원님은 비밀번호를 재설정할 수 없습니다.</div>
		<div class="text-sms text-[#6F6963] font-medium">로그인 화면에서 ‘간편 로그인' 하신 후 이용해 주세요.</div>
	</div>
	<button id="f_submit" type="button" onclick="location.replace('/');" class="w-full block h-[46px] text-sm text-[#FFFFFF] font-bold disabled:opacity-15 bg-[#322A24]" disabled>본인인증 하기</button>
</div>
</body>
</html>