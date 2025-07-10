<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicw/cont/guide.htm 000022923 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
function ck(obj,m)	{
	if(m=='1')	{
		$("#pfi2").removeClass("hidden");
		$(".svg1_1 > svg").removeClass("text-[#DBD7D0]");
		$(".svg1_1 > svg").addClass("text-[#6F6963]");
		$(".svg1_2 > svg").removeClass("text-[#DBD7D0]");
		$(".svg1_2 > svg").addClass("text-[#6F6963]");
	}
	if(m=='2')	{
		$("#pfi3").removeClass("hidden");
		$(".svg2_1 > svg").removeClass("text-[#DBD7D0]");
		$(".svg2_1 > svg").addClass("text-[#6F6963]");
		$(".svg2_2 > svg").removeClass("text-[#DBD7D0]");
		$(".svg2_2 > svg").addClass("text-[#6F6963]");
	}
	if(m=='3')	{
		$("#pfi4").removeClass("hidden");	
		$(".svg3_1 > svg").removeClass("text-[#DBD7D0]");
		$(".svg3_1 > svg").addClass("text-[#6F6963]");
		$(".svg3_2 > svg").removeClass("text-[#DBD7D0]");
		$(".svg3_2 > svg").addClass("text-[#6F6963]");
		
	}
	if(m=='4')	{
		$("#pbtn").prop("disabled",false);
		$(".svg4_1 > svg").removeClass("text-[#DBD7D0]");
		$(".svg4_1 > svg").addClass("text-[#6F6963]");
	}
	
	$(obj).parent().find("button").removeClass('bg-[#322A24] text-white hover:bg-[#33312e6f]');
	$(obj).parent().find("button").addClass('bg-primary text-primary-foreground hover:bg-[#f5f3ef] border-[#231815B2]');
	$(obj).removeClass('bg-primary text-primary-foreground hover:bg-[#f5f3ef] border-[#231815B2]');
	$(obj).addClass('bg-[#322A24] text-white hover:bg-[#33312e6f]');

}
</script>
<?php $this->print_("top",$TPL_SCP,1);?>

<div>
<?php $this->print_("nav",$TPL_SCP,1);?>

	<section class="container mx-auto pt-8">
		<nav class="w-full flex flex-col pt-4">
			<div class="w-full flex items-start justify-between">
				<div class="flex items-center gap-4 h-10">
					<h2 class="text-lg font-medium text-[#6F6963] m-0 p-0 leading-none">SHOP</h2>
					<div class="flex items-center text-sm text-gray-400">
						<div role="radiogroup" aria-required="false" dir="ltr" class="flex items-center rounded overflow-hidden gap-4" tabindex="0" style="outline: none;">
<?php if(is_array($TPL_R1=get_cate(''))&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
							<a href="/shop/?act=list&cate=<?php echo $TPL_V1["catecode"]?>">
<?php if($TPL_I1!= 0){?><span class="w-[1px] mr-4 text-[#C0BCB6] select-none">|</span><?php }?>
								<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-[5%] hover:text-[#6F6963] <?php if(substr($_REQUEST["cate"], 0, 2)==$TPL_V1["catecode"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?>">
									<?php echo $TPL_V1["catename"]?>

								</label>
							</a>
<?php }}?>
							
						</div>
					</div>
				</div>
				<div class="flex flex-col items-start">
					<div class="flex items-center text-sm text-gray-400 h-10">
<?php if(strlen($_REQUEST["cate"])>= 2){?>
						<div role="radiogroup" aria-required="false" dir="ltr" class="flex items-center rounded overflow-hidden gap-[20px]" tabindex="0" style="outline: none;">
							
							<a href="/shop/?act=list&cate=<?php echo substr($_REQUEST["cate"], 0, 2)?>" class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#6F6963] <?php if(substr($_REQUEST["cate"], 0, 2)==$_REQUEST["cate"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?>">
								전체
							</a>
<?php if(is_array($TPL_R1=get_cate(substr($_REQUEST["cate"], 0, 2)))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<a href="/shop/?act=list&cate=<?php echo $TPL_V1["catecode"]?>" class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#6F6963] <?php if(substr($_REQUEST["cate"], 0, 4)==$TPL_V1["catecode"]){?>text-[#6F6963]<?php }else{?>text-[#C0BCB6]<?php }?>">
								<?php echo $TPL_V1["catename"]?>

							</a>
<?php }}?>
<?php if(substr($_REQUEST["cate"], 0, 2)=='01'){?>
							<a href="/cont/?act=guide&cate=01" class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#6F6963] text-[#6F6963]">
								가이드
							</a>
<?php }?>
						</div>
<?php }?>
					</div>
					<div class="flex items-center mt-2 text-sm" style="min-height: 40px; height: 40px; visibility: hidden;">
						<div role="radiogroup" aria-required="false" dir="ltr" class="flex items-center rounded overflow-hidden gap-6" tabindex="-1" style="outline: none;">
							
						</div>
					</div>
				</div>
			</div>
		</nav>
		<div class="mx-auto">
			<header>
				<h2 class="text-lg text-[#6F6963] font-medium mb-4">GUIDE</h2>
				<div class="h-[60px] bg-[#322A2408] text-center text-[#6F6963] py-4 mb-10 text-sm">✨원하시는 향을 추천해 드립니다. 아래 항목을 모두 선택해 주세요.</div>
			</header>
			<main class="relative pl-8">
				<div class="relative flex min-h-[130px] mb-8 ">
					<div class="flex flex-col items-center mr-4 svg1_1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4 text-[#DBD7D0]" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg>
						
				
						<div class="flex-1 flex flex-col justify-center svg1_2">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical w-4 h-4 text-[#DBD7D0]" aria-hidden="true"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
							
						</div>
					</div>
					<div class="flex-1 flex flex-col justify-between ml-10">
						<div>
							<p class="font-bold text-[#6F6963] text-xs mb-4">1. 어떤 용도로 사용하시나요?</p>
							<div class="flex flex-wrap gap-4 text-sm mb-4 text-[#231815B2]">
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef] bg-primary text-primary-foreground" onclick="ck(this,1);">선물할 거예요</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0  h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef] bg-primary text-primary-foreground" onclick="ck(this,1);">제가 쓸 거예요</button>
							</div>
							<div class="border-b border-gray-200"></div>
						</div>
					</div>
					
					
				</div>
				<div class="relative flex min-h-[130px] mb-8">
					<div class="flex flex-col items-center mr-4 svg2_1" >
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4 text-[#DBD7D0]" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg>
						
				
						<div class="flex-1 flex flex-col justify-center svg2_2">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical w-4 h-4 text-[#DBD7D0]" aria-hidden="true"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
							
						</div>
					</div>
					<div class="flex-1 flex flex-col justify-between ml-10">
						<div>
							<p class="font-bold text-[#6F6963] text-xs mb-4">2. 어떤 계절에 맞는 향을 찾으세요?</p>
							<div class="flex flex-wrap gap-4 text-sm mb-4 text-[#231815B2] hidden" id="pfi2">
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,2);">봄&amp;여름</button>
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,2);">가을&amp;겨울</button>
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,2);">계절 상관없어요</button>
							</div>
							<div class="border-b border-gray-200"></div>
						</div>
					</div>
				</div>
				<div class="relative flex min-h-[130px] mb-8">
					<div class="flex flex-col items-center mr-4 svg3_1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4 text-[#DBD7D0]" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg>
						
				
						<div class="flex-1 flex flex-col justify-center svg3_2">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical w-4 h-4 text-[#DBD7D0]" aria-hidden="true"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
							
						</div>
					</div>
					<div class="flex-1 flex flex-col justify-between ml-10">
						<div>
							<p class="font-bold text-[#6F6963] text-xs mb-4">3. 원하시는 계열을 선택해 주세요.</p>
							<div class="flex flex-wrap gap-4 text-sm mb-4 text-[#231815B2] hidden" id="pfi3">
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">플로럴</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">프루티</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">시트러스</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">우디</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">그린</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">워터리</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">머스크</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,3);">바닐라</button>
							</div>
							<div class="border-b border-gray-200"></div>
						</div>
					</div>
				</div>
				<div class="relative flex min-h-[130px] mb-8">
					<div class="flex flex-col items-center mr-4 svg4_1">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4 text-[#DBD7D0]" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg>
					</div>
					<div class="flex-1 flex flex-col justify-between ml-10">
						<div>
							<p class="font-bold text-[#6F6963] text-xs mb-4">4. 원하시는 분위기를 선택해 주세요.</p>
							<div class="flex flex-wrap gap-4 text-sm mb-4 text-[#231815B2] hidden" id="pfi4">
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">청순한</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">청초한</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">포근한</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">트로피칼</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">꽃내음</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">홍차</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">성숙한</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">달콤한</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">은은한</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">지적인</button>
								
								<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground h-[36px] px-[8px] py-[4px] rounded transition text-xs border-[#231815B2] hover:bg-[#f5f3ef]" onclick="ck(this,4);">우아한</button>
							</div>
							<div class="border-b border-gray-200"></div>
						</div>
					</div>
				</div>
			</main>
			<div class="mt-12 text-right">
				<button  onclick="location.href='/cont/?act=guideresult'" class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 w-[358px] h-[46px] px-6 py-3 text-white text-sm font-bold rounded disabled:opacity-50 min-w-1/3 cursor-pointer bg-[#322A24]" disabled id="pbtn">결과 확인</button>
			</div>
		</div>
	</section>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>