<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicw/cont/journal.htm 000007924 */ 
$TPL_catelist_1=empty($TPL_VAR["catelist"])||!is_array($TPL_VAR["catelist"])?0:count($TPL_VAR["catelist"]);
$TPL_l_loop_paging_1=empty($TPL_VAR["l_loop_paging"])||!is_array($TPL_VAR["l_loop_paging"])?0:count($TPL_VAR["l_loop_paging"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<div>
<?php $this->print_("nav",$TPL_SCP,1);?>

	<section class="container mx-auto pt-8">
		<nav class="w-full flex items-center justify-between border-t pt-4">
			<div class="flex items-center gap-4 h-10">
				<h2 class="text-lg font-medium text-[#6F6963] m-0 p-0 leading-none">JOURNAL</h2>
			</div>
			<div class="flex items-center text-sm text-gray-400">
				<div role="radiogroup" aria-required="false" dir="ltr" class="flex rounded overflow-hidden gap-10" tabindex="0" style="outline: none;">
					<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-[5%] hover:text-[#322A24] <?php if($_REQUEST["cate"]==''){?>text-[#322A24]<?php }else{?>text-[#322A244D]<?php }?>">
						<button type="button" role="radio" aria-checked="true" data-state="checked" value="All" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" onclick="location.href='/cont/?act=journal'">
						</button>All
					</label>
<?php if($TPL_catelist_1){foreach($TPL_VAR["catelist"] as $TPL_V1){?>
					<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-[5%] hover:text-[#322A24] <?php if($TPL_V1["idx"]==$_REQUEST["cate"]){?>text-[#322A24]<?php }else{?>text-[#322A244D]<?php }?>">
						<button type="button" role="radio" aria-checked="false" data-state="unchecked" value="News" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" onclick="location.href='/cont/?act=journal&cate=<?php echo $TPL_V1["idx"]?>'"></button><?php echo $TPL_V1["catename"]?>

					</label>
<?php }}?>
				</div>
			</div>
		</nav>
		<div>
			<main class="container mx-auto mt-10">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12">
<?php if(is_array($TPL_R1=get_journal($TPL_VAR["l_arr"]["npage"]- 1,$TPL_VAR["l_arr"]["numper"],$TPL_VAR["l_arr"]["cate"],$TPL_VAR["l_arr"]["keyword"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<a class="group cursor-pointer" href="/cont/?act=journalv&idx=<?php echo $TPL_V1["idx"]?>">
						<div class="aspect-[3/4] overflow-hidden relative rounded-lg"> 
							<img alt="<?php echo $TPL_V1["subject"]?>" loading="lazy" width="400" height="800" decoding="async" data-nimg="1" class="!w-[357px] !h-[460px] object-cover transition-transform duration-700 group-hover:scale-105"  src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/journal/<?php echo $TPL_V1["img"]?>" style="color: transparent;">
							<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
								
							</div>
							<div class="absolute bottom-2 left-0 p-4 pb-6 text-[#FDFBF5]"> 
								<p class="text-xs font-bold mb-1">#<?php echo $TPL_V1["catename"]?></p>
								<h3 class="text-base font-bold mb-1 leading-tight"><?php echo $TPL_V1["subject"]?></h3>
								<p class="text-xs font-medium text-[#E9E6E0]"><?php echo substr($TPL_V1["wdate"], 0, 10)?> 조회 <?php echo $TPL_V1["readcount"]?></p>
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
				<form action="/cont/?act=journal" method="post">
					<div class="max-w-[740px] max-w-2/3 mx-auto px-4">
						<div class="relative max-w-[740px]">
							<input class="flex border w-full rounded-md bg-background px-[16px] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm max-w-[740px] h-[35px] text-[#322A24] text-lg font-medium !border-0 !border-b-1 !border-[#5E5955] !rounded-none !focus:outline-none !focus:border-0 !focus:border-b-1 !focus:border-b-black placeholder-[#322A244D] py-2 pr-10" placeholder="검색어를 입력하세요." name="keyword" type="text" value="<?php echo $_REQUEST["keyword"]?>">
							<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 absolute right-0 top-1/2 -translate-y-1/2" type="submit">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-[24px] h-[24px] text-[#5E5955]" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
							</button>
						</div>
					</div>
				</form>
			</main>
		</div>
	</section>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>