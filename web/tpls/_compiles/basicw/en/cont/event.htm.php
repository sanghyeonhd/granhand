<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicw/cont/event.htm 000005805 */ 
$TPL_l_loop_paging_1=empty($TPL_VAR["l_loop_paging"])||!is_array($TPL_VAR["l_loop_paging"])?0:count($TPL_VAR["l_loop_paging"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<div>
<?php $this->print_("nav",$TPL_SCP,1);?>

	<section class="container mx-auto pt-8">
		<nav class="w-full flex items-center justify-between border-t pt-4">
			<div class="flex items-center gap-4 h-10">
				<h2 class="text-lg font-medium text-[#6F6963] m-0 p-0 leading-none">EVENT</h2>
			</div>
		</nav>
		<main class="container mx-auto mt-10">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12">
<?php if(is_array($TPL_R1=get_event($TPL_VAR["l_arr"]["npage"]- 1,$TPL_VAR["l_arr"]["numper"],$TPL_VAR["l_arr"]["keyword"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<a class="group cursor-pointer" href="/cont/?act=eventv&idx=<?php echo $TPL_V1["idx"]?>">
					<div class="overflow-hidden mb-4">
						<img alt="<?php echo $TPL_V1["subject"]?>" loading="lazy" width="357" height="200" decoding="async" data-nimg="1" class="w-[357px] h-[200px] object-cover transition-transform duration-700 group-hover:scale-105"  src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/event/<?php echo $TPL_V1["img"]?>" style="color: transparent;">
					</div>
					<div class="space-y-2">
						<h3 class="text-base text-black font-medium group-hover:text-granhand-text transition-colors"><?php echo $TPL_V1["subject"]?></h3>
						<div class="flex items-center space-x-2 text-xs text-[#C0BCB6] font-medium">
							<span><?php echo substr($TPL_V1["wdate"], 0, 10)?></span>
						</div>
					</div>
				</a>
<?php }}?>
			</div>
			<div class="mb-20"></div>
				<div class="flex justify-center items-center gap-2 py-8 flex-wrap">
<?php if($TPL_VAR["l_paging"]["block"]> 1){?>
					<button style="display:none" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 px-4 py-2 text-base text-[#C0BCB6] hover:text-[#6F6963] disabled:text-gray-300 min-w-[3%]" onclick="location.href='<?php echo $TPL_VAR["l_paging"]["superfirstl"]?>'">≫</button>
<?php }?>
<?php if($TPL_VAR["l_paging"]["total_record"]!= 0){?> 
					
<?php }?>
<?php if($TPL_l_loop_paging_1){foreach($TPL_VAR["l_loop_paging"] as $TPL_V1){?>
<?php if($TPL_V1["page"]==$TPL_VAR["l_paging"]["nowpage"]){?>
						<button class="text-base font-bold text-[#6F6963] hover:text-black transition-colors min-w-[3%]" onclick="location.href='<?php echo $TPL_V1["links"]?>'"><?php echo $TPL_V1["page"]?></button>
<?php }else{?>
						<button class="text-base font-bold text-[#6F6963] hover:text-black transition-colors min-w-[3%]" onclick="location.href='<?php echo $TPL_V1["links"]?>'"><?php echo $TPL_V1["page"]?></button>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["l_paging"]["total_record"]!= 0){?>
					
<?php }?>
<?php if($TPL_VAR["l_paging"]["block"]<$TPL_VAR["l_paging"]["totalblock"]){?> 
					<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 px-4 py-2 text-base text-[#C0BCB6] hover:text-[#6F6963] disabled:text-gray-300 min-w-[3%]">≫</button>
<?php }?>				
				
				
					
					
			</div>
			<div class="mb-14"></div>
			<form action="/cont/?act=event" method="post">
				<div class="max-w-[740px] max-w-2/3 mx-auto px-4">
					<div class="relative max-w-[740px]">
						<input class="flex border w-full rounded-md bg-background px-[16px] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm max-w-[740px] h-[35px] text-[#322A24] text-lg font-medium !border-0 !border-b-1 !border-[#5E5955] !rounded-none !focus:outline-none !focus:border-0 !focus:border-b-1 !focus:border-b-black placeholder-[#322A244D] py-2 pr-10" placeholder="검색어를 입력하세요." type="text" value="<?php echo $_REQUEST["keyword"]?>" name="keyword">
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