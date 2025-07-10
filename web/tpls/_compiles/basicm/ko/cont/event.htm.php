<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicm/cont/event.htm 000001348 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="fixed top-0 left-0 right-0 z-20 bg-[#FDFBF4]">
			<div class="h-[58px] flex px-6 items-center ">
				<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
				<div class="text-lg font-bold">EVENT</div>
			</div>
		</div>
		<div class="px-6" style="padding-top:60px">
<?php if(is_array($TPL_R1=get_event($TPL_VAR["l_arr"]["npage"]- 1,$TPL_VAR["l_arr"]["numper"],""))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<a class="block" href="/cont/?act=eventv&idx=<?php echo $TPL_V1["idx"]?>">
				<div class=" mb-4">
					<div class="pb-2">
						<img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/event/<?php echo $TPL_V1["img"]?>" alt="NOLL Store" class="w-full h-full object-cover rounded-sm">
					</div>
					<div class="pb-1 text-[#322A24] text-sm font-medium">
						<?php echo $TPL_V1["subject"]?>

					</div>
					<div class="text-[#C0BCB6] text-xs font-normal"><?php echo substr($TPL_V1["wdate"], 0, 10)?></div>
				</div>
			</a>
<?php }}?>
		</div>
		
	</div>
</div>
</body>
</html>