<?php /* Template_ 2.2.7 2025/07/08 17:45:30 /home/grandhand/BUILDS/tpls/basicw/mypage/recent.htm 000002558 */ 
$TPL_datalist_1=empty($TPL_VAR["datalist"])||!is_array($TPL_VAR["datalist"])?0:count($TPL_VAR["datalist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<div class="container mx-auto  pt-8">
	<div class="flex justify-between items-center mb-8">
		<div class="flex items-center">
			<h2 class="text-lg font-medium text-[#6F6963]">최근 본 상품</h2>
		</div>
		<div class="flex items-center text-xs text-[#6F6963] cursor-pointer">
			
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left text-[#6F6963] mr-3" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg>
			<a href="#none" onclick="event.preventDefault(); history.back();" class="text-sm font-medium">이전단계</a>
			
		</div>
	</div>
<?php if(sizeof($TPL_VAR["datalist"])== 0){?>
	<div class="text-[#1A1A1A] hover:bg-[#322A2408] relative" style="padding:100px 0;">
		<div class="text-center text-sm font-bold text-[#322A244D]">최근 본 상품이 없습니다.</td>
	</div>
<?php }?>
	<div class="grid grid-cols-[205px_205px_205px_205px_205px] gap-x-[23.75px] gap-y-12">
<?php if($TPL_datalist_1){foreach($TPL_VAR["datalist"] as $TPL_V1){?>	
		<a class="group cursor-pointer" href="/shop/?act=view&idx=<?php echo $TPL_V1["idx"]?>">
			<div class="overflow-hidden mb-4 relative">
				<img alt="Roland Multi Perfume" loading="lazy" width="205" height="200" decoding="async" data-nimg="1" class="!w-[205px] !h-[200px] object-cover transition-transform duration-700 group-hover:scale-105"  src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="color: transparent;">
				
			</div>
			<div class="space-y-2">
				<h3 class="text-sm text-[#322A24] font-bold group-hover:text-granhand-text transition-colors"><?php echo $TPL_V1["gname"]?></h3>
				<div class="flex items-center space-x-2 text-xs text-[#C0BCB6]">
					<span><?php echo $TPL_V1["gname_pre"]?> <?php echo $TPL_V1["weight"]?></span>
				</div>
				<div class="flex items-center space-x-2 text-xs text-[#322A24]"><span><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_V1["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></span></div>
			</div>
		</a>
<?php }}?>
	</div>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>