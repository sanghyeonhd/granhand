<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicw/cont/journalv.htm 000001452 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<?php $this->print_("top",$TPL_SCP,1);?>

<div>
<?php $this->print_("nav",$TPL_SCP,1);?>

	<section class="container mx-auto pt-8 w-[1120px]">
		<header class="w-full flex items-center justify-between border-t pt-4">
			<h2 class="title">JOURNAL</h2>
		</header>
		<main class="grid grid-cols-[357px_740px] gap-12 mb-12 min-h-screen relative mt-10">
			<div class="self-start">
				<div class="flex-1 space-y-6">
					<div>
						<div class="text-base text-[#322A24] font-bold">#<?php echo $TPL_VAR["datas"]["catename"]?></div>
						<h1 class="text-[32px] font-medium text-[#322A24]"><?php echo $TPL_VAR["datas"]["subject"]?></h1>
					</div>
					<div class="text-sm font-medium text-[#C0BCB6]"><?php echo substr($TPL_VAR["datas"]["wdate"], 0, 10)?> 조회 <?php echo $TPL_VAR["datas"]["readcount"]?></div>
				</div>
			</div>
			<div class="mt-8 w-full ">
				<?php echo $TPL_VAR["datas"]["memo"]?>

				<div class="mt-12">
					<div class="flex gap-14 items-center mb-16">
						<h2 class="text-base font-bold text-black min-w-fit">관련 영상</h2>
						<div class="bg-black w-full h-[1px]"></div>
					</div>
					<div class="space-y-4">
				
					</div>
				</div>
			</div>
		</main>
	</section>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>