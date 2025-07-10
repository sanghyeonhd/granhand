<?php /* Template_ 2.2.7 2025/07/08 17:45:30 /home/grandhand/BUILDS/tpls/basicw/shop/list.htm 000008814 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
function showflay()	{
	if($("#showflay").hasClass("hidden"))	{
		$("#showflay").removeClass("hidden");
	}	else	{
		$("#showflay").addClass("hidden");
	}
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
							<a href="/cont/?act=guide&cate=01" class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#6F6963] text-[#C0BCB6]">
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
		<main class="container mx-auto">
			<button onclick="showflay();" type="button" class="relative text-xs flex items-center gap-1 text-[#6F6963] font-bold min-w-fit"><?php echo $TPL_VAR["l_arr"]["orderbyname"]?> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
				<div id="showflay" class="hidden absolute left-1/2 width-[] -translate-x-1/2 -translate-y-1/2 z-50 px-4 py-2 rounded shadow w-auto inline-block whitespace-nowrap bg-[#FDFBF5]" style="top:125px;width:120px;">
					<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=1" class="block mb-4 font-normal <?php if($TPL_VAR["l_arr"]["ob"]=='1'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs">추천순</a>
					<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=2" class="block mb-4 font-normal <?php if($TPL_VAR["l_arr"]["ob"]=='2'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs">인기순</a>			
					<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=3" class="block mb-4 font-normal <?php if($TPL_VAR["l_arr"]["ob"]=='3'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs">낮은 가격순</a>		
					<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=4" class="block mb-4 font-normal <?php if($TPL_VAR["l_arr"]["ob"]=='4'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs">높은 가격순</a>
					<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=5" class="block mb-4 font-normal <?php if($TPL_VAR["l_arr"]["ob"]=='5'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs">상품평 적은순</a>		
					<a href="/shop/?act=list&cate=<?php echo $TPL_VAR["l_arr"]["cate"]?>&ob=6" class="block mb-4 font-normal <?php if($TPL_VAR["l_arr"]["ob"]=='6'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs">상품평 많은순</a>	
				</div>
			</button>
				
			
			<div class="grid grid-cols-1 md:grid-cols-5 gap-x-8 gap-y-12 mt-10">
<?php if(is_array($TPL_R1=get_listdata('list',$TPL_VAR["l_arr"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>	
			
			
				<a class="group cursor-pointer" href="/shop/?act=view&idx=<?php echo $TPL_V1["idx"]?>">
					<div class="overflow-hidden mb-4">
						<img alt="<?php echo $TPL_V1["gname"]?>" loading="lazy" width="205" height="200" class="w-[205px] h-[200px] object-cover transition-transform duration-700 group-hover:scale-105"  src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="color: transparent;">
					</div>
					<div class="space-y-2">
						<h3 class="text-sm text-[#111111] font-bold group-hover:text-granhand-text transition-colors"><?php echo $TPL_V1["gname"]?></h3>
						<div class="flex items-center space-x-2 text-xs text-[#C0BCB6]"><span><?php echo $TPL_V1["gname_pre"]?> <?php echo $TPL_V1["weight"]?></span></div>
						<div class="flex items-center space-x-2 text-xs text-[#322A24]"><span><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_V1["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></span></div>
					</div>
				</a>
			
<?php }}?>
			</div>
			<div class="mb-20"></div>
			<div class="flex justify-center items-center gap-2 py-8 flex-wrap"></div>
			<div class="mb-14"></div>
			<form action="/shop/?act=list&cate=<?php echo $_REQUEST["cate"]?>" method="post">
				<div class="max-w-[740px] max-w-2/3 mx-auto px-4">
					<div class="relative max-w-[740px]">
						<input class="flex border w-full rounded-md bg-background px-[16px] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm max-w-[740px] h-[35px] text-[#322A24] text-lg font-medium !border-0 !border-b-1 !border-[#5E5955] !rounded-none !focus:outline-none !focus:border-0 !focus:border-b-1 !focus:border-b-black placeholder-[#322A244D] py-2 pr-10" placeholder="검색어를 입력하세요." type="text" value="" name="keyword">
						<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 absolute right-0 top-1/2 -translate-y-1/2" type="submit">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-[24px] h-[24px] text-[#5E5955]" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
						</button>
					</div>
				</div>
			</form>
		</main>
	</section>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>