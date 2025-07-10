<?php /* Template_ 2.2.7 2025/07/10 09:01:58 /home/grandhand/BUILDS/tpls/basicw/member/findidresult.htm 000003286 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<main class="space-y-6 container mx-auto px-6 pt-8">
	<h2 class="text-lg font-[500] text-left mb-4 border-b !border-b-[#E9E6E0] pb-4 text-[#6F6963]">아이디 찾기</h2>
	<div class="flex items-center mb-8">
		<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2 w-4 h-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left w-4 h-4 text-[#6F6963] mr-3" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg></button>
		<div class="text-sm items-center text-[#6F6963] font-[500]">이전 단계</div>
	</div>
	<div class="max-w-xl w-[358px] mx-auto text-left ">
		<h1 class="text-lg font-bold text-[#322A24]">계정을 찾았습니다.</h1>
		<div class="bg-[#322A2408] w-[358px] mt-10 p-4 h-[78px] flex flex-col justify-center items-center space-y-1">
			<div class="text-sm font-bold text-[#6F6963]"><?php echo $TPL_VAR["data"]["id"]?></div>
			<div class="text-xs text-[#6F6963]"><?php echo substr($TPL_VAR["data"]["signdate"], 0, 10)?> 가입</div>
		</div>
		<a href="/member/?act=findpasswd">
		<div class="flex items-center justify-between text-sm font-medium text-[#6F6963] cursor-pointer pb-1 w-fit mt-5 mb-16 leading-[22px]">비밀번호 재설정		
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4 ml-1" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
		</div>
		</a>
		<a href="/member/?act=login"><button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 w-[358px] bg-[#322A24] text-[#FDFBF5] font-bold text-sm h-[46px] cursor-pointer px-[24px] py-[12px]">로그인</button></a>
		<div class="space-y-2 mt-10">
			<div class="space-y-2 w-full bg-[#322A2408]">
				<div class="text-xs text-[#6F6963] p-4 px-5">
					<ul class="list-disc space-y-1.5 px-4 font-medium text-[10px] undefined">
						<li>SNS 계정으로 가입하신 회원님은 비밀번호를 재설정할 수 없습니다.</li>
						<li>로그인 화면에서 '간편 로그인' 하신 후 이용해 주세요.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</main>
<?php $this->print_("down",$TPL_SCP,1);?>