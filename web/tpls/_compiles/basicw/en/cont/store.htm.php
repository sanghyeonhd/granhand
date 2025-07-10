<?php /* Template_ 2.2.7 2025/07/08 17:45:29 /home/grandhand/BUILDS/tpls/basicw/cont/store.htm 000003886 */ 
$TPL_brlist_1=empty($TPL_VAR["brlist"])||!is_array($TPL_VAR["brlist"])?0:count($TPL_VAR["brlist"]);
$TPL_storelist_1=empty($TPL_VAR["storelist"])||!is_array($TPL_VAR["storelist"])?0:count($TPL_VAR["storelist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
function showlays()	{
	if($("#showlay").hasClass("hidden"))	{
		$("#showlay").removeClass("hidden");
	}	else	{
		$("#showlay").addClass("hidden");		
	}
}
</script>
<?php $this->print_("top",$TPL_SCP,1);?>

<div>
<?php $this->print_("nav",$TPL_SCP,1);?>

	<section class="container mx-auto pt-8">
		<nav class="w-full flex items-center justify-between border-t pt-4">
			<div class="flex items-center gap-4 h-10">
				<h2 class="text-lg font-medium text-[#6F6963] m-0 p-0 leading-none">STORE</h2>
				<div class="relative inline-block">
					<button onclick="showlays();" type="button" id="radix-«r1v»" aria-haspopup="menu" aria-expanded="false" data-state="closed" class="text-xs font-bold flex items-center gap-1 text-[#6F6963]"><?php echo $TPL_VAR["brand"]["brandname"]?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
					</button>
					
					<div id="showlay" class="hidden absolute left-1/2  -translate-x-1/2 -translate-y-1/2 z-50 px-4 py-2 rounded shadow w-auto inline-block whitespace-nowrap bg-[#FDFBF5]" style="top:60px;">
<?php if($TPL_brlist_1){foreach($TPL_VAR["brlist"] as $TPL_V1){?>
						<a href="/cont/?act=store&brand_idx=<?php echo $TPL_V1["idx"]?>" class="block mb-4 font-normal <?php if($TPL_V1["issel"]=='Y'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs"><?php echo $TPL_V1["brandname"]?></a>
<?php }}?>
					</div>
				</div>
			</div>
			<div class="flex items-center text-sm text-gray-400">
				<div role="radiogroup" aria-required="false" dir="ltr" class="flex rounded overflow-hidden gap-[24px]" tabindex="0" style="outline: none;">
<?php if($TPL_storelist_1){foreach($TPL_VAR["storelist"] as $TPL_V1){?>
					<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#322A24] <?php if($TPL_V1["issel"]=='Y'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?>">
						<button type="button" onclick="location.href='/cont/?act=store&brand_idx=<?php echo $TPL_V1["brand_idx"]?>&store_idx=<?php echo $TPL_V1["idx"]?>'" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""><span data-state="checked" class="flex items-center justify-center"></span></button><?php echo $TPL_V1["name"]?>

					</label>
<?php }}?>
					
				</div>
			</div>
		</nav>
		<div class="mt-10">
			<div class="flex items-center gap-2 text-[10px]">
				<span class="font-medium text-[#322A24]"><?php echo $TPL_VAR["store"]["fullname"]?></span>
				<span class="text-[#C0BCB6]"><?php echo $TPL_VAR["store"]["addr"]?></span>
			</div>
			<div class="mt-4 space-y-4">
				<div class="grid grid-cols-[739px_357px] grid-rows-2 gap-4">
<?php if(is_array($TPL_R1=$TPL_VAR["store"]["imgs"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<div class="pb-4">
				<img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/store/<?php echo $TPL_V1["filename"]?>" style="width:100%;">
			</div>
<?php }}?>
				</div>
			</div>
		</div>
	</section>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>