<?php /* Template_ 2.2.7 2025/07/08 17:45:30 /home/grandhand/BUILDS/tpls/basicw/mypage/wish.htm 000003793 */ 
$TPL_datalist_1=empty($TPL_VAR["datalist"])||!is_array($TPL_VAR["datalist"])?0:count($TPL_VAR["datalist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<Script>
function set_wish(idx)	{
	var param = "idx="+idx;
	param = param + "&stypes=1";
	
	console.log('/exec/proajax.php?act=useraction&han=set_addwish&' + param);
	
	$.getJSON('/exec/proajax.php?act=useraction&han=set_addwish&' + param, function(result)	{
		console.log(result);
		if(result.res=='ok1')	{
			location.reload();
		}
		else if(result.res=='ok2')	{
			location.reload();	
		}
		else if(result.res=='login')	{
			answer = confirm('로그인이 필요합니다. 로그인 하시겠습니까?');
			if(answer==true)	{
				location.href='/member/?act=login&geturl=<?php echo $TPL_VAR["global"]["nowurl_en"]?>';
			}
		}
		else	{
			alert(result.resmsg);
			
		}
	});
}
</script>
<?php $this->print_("top",$TPL_SCP,1);?>

<div class="container mx-auto  pt-8">
	<div class="flex justify-between items-center mb-8">
		<div class="flex items-center">
			<h2 class="text-lg font-medium text-[#6F6963]">관심 상품</h2>
		</div>
		<div class="flex items-center text-xs text-[#6F6963] cursor-pointer">
			
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left text-[#6F6963] mr-3" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg>
			<a href="#none" onclick="event.preventDefault(); history.back();" class="text-sm font-medium">이전단계</a>
			
		</div>
	</div>
<?php if(sizeof($TPL_VAR["datalist"])== 0){?>
	<div class="text-[#1A1A1A] hover:bg-[#322A2408] relative" style="padding:100px 0;">
		<div class="text-center text-sm font-bold text-[#322A244D]">관심상품이 없습니다.</td>
	</div>
<?php }?>
	<div class="grid grid-cols-[205px_205px_205px_205px_205px] gap-x-[23.75px] gap-y-12">
<?php if($TPL_datalist_1){foreach($TPL_VAR["datalist"] as $TPL_V1){?>	
		<a class="group cursor-pointer" href="/shop/?act=view&idx=<?php echo $TPL_V1["idx"]?>">
			<div class="overflow-hidden mb-4 relative">
				<img alt="Roland Multi Perfume" loading="lazy" width="205" height="200" decoding="async" data-nimg="1" class="!w-[205px] !h-[200px] object-cover transition-transform duration-700 group-hover:scale-105"  src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="color: transparent;">
				<div class="absolute top-2 right-2 z-10" onclick="set_wish(<?php echo $TPL_V1["idx"]?>)">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#FDFBF5" stroke="#FDFBF5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart w-[24px] h-[24px] cursor-pointer" aria-hidden="true"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
				</div>
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