<?php /* Template_ 2.2.7 2025/07/08 17:45:30 /home/grandhand/BUILDS/tpls/basicw/shop/guide.htm 000003347 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

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
							<a href="/cont/?act=guide&cate=02" class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-5 hover:text-[#6F6963] text-[#6F6963]">
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
		
	</section>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>