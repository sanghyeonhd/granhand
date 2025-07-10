<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicm/cont/journal.htm 000002249 */ 
$TPL_catelist_1=empty($TPL_VAR["catelist"])||!is_array($TPL_VAR["catelist"])?0:count($TPL_VAR["catelist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

</head>
<body>
<div id="root" class="bg-[#FDFBF4]">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="fixed top-0 left-0 right-0 z-20 bg-[#FDFBF4]">
			<div class="h-[58px] flex px-6 items-center ">
				<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
				<div class="text-lg font-bold">JURNAL</div>
			</div>
			<div class="h-[54px] px-6 flex items-center justify-between">
				<a href="/cont/?act=journal" class="font-bold text-sm <?php if($_REQUEST["cate"]==''){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?>">All</a>
<?php if($TPL_catelist_1){foreach($TPL_VAR["catelist"] as $TPL_V1){?>
				<a href="/cont/?act=journal&cate=<?php echo $TPL_V1["idx"]?>" class="font-bold text-sm <?php if($_REQUEST["cate"]==$TPL_V1["idx"]){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?>"><?php echo $TPL_V1["catename"]?></a>
<?php }}?>
			</div>
		</div>
		<div class="px-6" style="padding-top:112px">
<?php if(is_array($TPL_R1=get_journal($TPL_VAR["l_arr"]["npage"]- 1,$TPL_VAR["l_arr"]["numper"],$TPL_VAR["l_arr"]["cate"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<a class="block" href="/cont/?act=journalv&idx=<?php echo $TPL_V1["idx"]?>">
				<div class="relative mb-4">
					<img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/journal/<?php echo $TPL_V1["img"]?>" alt="NOLL Store" class="w-full h-full object-cover rounded-sm">
					<div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/70 to-transparent text-white">
						<span class="text-xs cursor-pointer hover:underline">#<?php echo $TPL_V1["catename"]?></span>
						<h3 class="text-base font-medium mt-1"><?php echo $TPL_V1["subject"]?></h3>
						<p class="text-xs mt-1 text-gray-200"><?php echo substr($TPL_V1["wdate"], 0, 10)?> 조회 <?php echo $TPL_V1["readcount"]?></p>
					</div>
				</div>
			</a>
<?php }}?>
		</div>
		
	</div>
</div>
</body>
</html>