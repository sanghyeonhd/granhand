<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicw/cont/faq.htm 000003129 */ 
$TPL_catelist_1=empty($TPL_VAR["catelist"])||!is_array($TPL_VAR["catelist"])?0:count($TPL_VAR["catelist"]);
$TPL_faqlist_1=empty($TPL_VAR["faqlist"])||!is_array($TPL_VAR["faqlist"])?0:count($TPL_VAR["faqlist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<div >
<?php $this->print_("nav",$TPL_SCP,1);?>

	<main class="container mx-auto py-8">
		<div class="flex justify-between items-end mb-10">
			<h2 class="text-lg font-medium text-[#6F6963]">자주 묻는 질문</h2>
			<div role="radiogroup" aria-required="false" dir="ltr" class="flex rounded overflow-hidden gap-[24px]" tabindex="0" style="outline: none;">
<?php if($TPL_catelist_1){foreach($TPL_VAR["catelist"] as $TPL_V1){?>
				<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-sm font-bold transition-colors min-w-[52px] hover:text-[#322A24] <?php if($TPL_V1["issel"]=='Y'){?>text-[#322A24]<?php }else{?>text-[#322A244D]<?php }?>">
					<button type="button" onclick="location.href='/cont/?act=faq&cate_idx=<?php echo $TPL_V1["idx"]?>'" role="radio" aria-checked="true" data-state="checked" value="제품 문의" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""><span data-state="checked" class="flex items-center justify-center">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle h-2.5 w-2.5 fill-current text-current" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle></svg></span>
					</button><?php echo $TPL_V1["catename"]?>

				</label>
			
				
<?php }}?>
			</div>
		</div>
		<div class="max-w-4xl w-[739px]">
<?php if($TPL_faqlist_1){foreach($TPL_VAR["faqlist"] as $TPL_V1){?>
			<div>
				<button class="gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 px-4 w-full flex justify-between items-center py-4 text-left h-16 text-base"><span class="text-sm font-medium text-[#322A24]"><?php echo $TPL_V1["subject"]?></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-[#C0BCB6]" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg></button>
			</div>
<?php }}?>
		</div>
	</main>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>