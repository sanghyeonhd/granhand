<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicw/index.htm 000004552 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<div >
<?php $this->print_("nav",$TPL_SCP,1);?>

	<main class="container mx-auto pt-8">
		<section class="py-4">
			<h2 class="text-sm text-[#6F6963] font-bold text-left mb-8 border-b border-b-[#6f6963] pb-4">BRAND SHOP</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
	
<?php if(is_array($TPL_R1=get_set_data( 1))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<a class="group" href="<?php echo $TPL_V1["links"]?>">
					<div class="space-y-2">
						<h3 class="text-sm text-[#6F6963] font-bold"><?php echo $TPL_V1["text"]?></h3>
						<div class=" overflow-hidden mb-4">
							<img alt="<?php echo $TPL_V1["text"]?>" loading="lazy" decoding="async" data-nimg="1" class="w-[359px] h-[178px] object-cover transition-transform duration-700 group-hover:scale-105" style="color:transparent" srcset="<?php echo $TPL_V1["imgurl"]?>" src="<?php echo $TPL_V1["imgurl"]?>">
						</div>
						<p class="text-sm font-medium text-[#5E5955] leading-relaxed"><?php echo $TPL_V1["text2"]?></p>
					</div>
				</a>
<?php }}?>
			</div>
		</section>
		<div class="mt-20">
<?php if(is_array($TPL_R1=get_set_data( 2))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<a href="<?php echo $TPL_V1["links"]?>">
			<div>
				<div class="text-2xl font-bold text-[#322A24]"><?php echo $TPL_V1["text"]?></div>
				<div class="text-sm font-bold text-[#C0BCB6] mt-1 mb-6"><?php echo $TPL_V1["text2"]?></div>
			</div>
			<div class="cursor-pointer">
				<div class="w-full bg-[#D9D9D9] rounded-lg overflow-hidden mb-6">
					<img alt="GRANHAND Gwanghwamun" loading="lazy" decoding="async" data-nimg="1" class="w-[1120px] h-[572px] object-cover" style="aspect-ratio: 16 / 9; min-height: 400px;" srcset="<?php echo $TPL_V1["imgurl"]?>" src="<?php echo $TPL_V1["imgurl"]?>">
				</div>
			</div>
			<div class="max-w-4xl text-sm">
				<div class="font-bold text-[#322A24] mb-2"><?php echo $TPL_V1["text3"]?></div>
				<div class="text-[#322A24] mb-10"><?php echo $TPL_V1["text4"]?></div>
			</div>
			</a>
<?php }}?>
		</div>
		<h2 class="text-sm font-bold text-[#6F6963] text-left mt-20 border-b pb-4">JOURNAL</h2>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-12">
<?php if(is_array($TPL_R1=get_journal( 0, 6))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<a class="group cursor-pointer" href="/cont/?act=journalv&idx=<?php echo $TPL_V1["idx"]?>">
				<div class="aspect-[3/4] overflow-hidden relative rounded-lg"> 
					<img alt="<?php echo $TPL_V1["subject"]?>" loading="lazy" width="400" height="800" decoding="async" data-nimg="1" class="!w-[357px] !h-[460px] object-cover transition-transform duration-700 group-hover:scale-105" src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/journal/<?php echo $TPL_V1["img"]?>" style="color: transparent;">
					<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
					<div class="absolute bottom-2 left-0 p-4 pb-6 text-[#FDFBF5]"> 
						<p class="text-xs font-bold mb-1">#<?php echo $TPL_V1["catename"]?></p>
						<h3 class="text-base font-bold mb-1 leading-tight"><?php echo $TPL_V1["subject"]?></h3>
						<p class="text-xs font-medium text-[#E9E6E0]"><?php echo substr($TPL_V1["wdate"], 0, 10)?> 조회 <?php echo $TPL_V1["readcount"]?></p>
					</div>
				</div>
			</a>
<?php }}?>
		</div>
		<div class="mt-20 pt-12 pb-16 space-y-6"> 
			<p class="text-sm font-bold text-[#6F6963] uppercase">STORE</p> 
			<a class="block" href="/cont/?act=store">
				<div class="flex items-center gap-4 text-[#322A24] hover:cursor-pointer"> 
					<h2 class="text-2xl font-bold leading-none">오프라인 스토어 안내</h2>
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
				</div>
			</a>
			<div class="max-w-2xl"> 
				<p class="text-sm text-[#322A24] leading-relaxed"> <!-- -->오프라인 스토어는 그랑핸드가 보여주고 싶은 모든 것이 담겨있는 공간입니다.<br>바쁜 일상 속 잠시 숨을 돌리는 시간과 경험이 됩니다.</p>
			</div>
		</div>
	</main>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>