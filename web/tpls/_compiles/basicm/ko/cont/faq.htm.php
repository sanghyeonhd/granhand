<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicm/cont/faq.htm 000001132 */ 
$TPL_catelist_1=empty($TPL_VAR["catelist"])||!is_array($TPL_VAR["catelist"])?0:count($TPL_VAR["catelist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="fixed top-0 left-0 right-0 z-20 bg-[#FDFBF4]">
			<div class="h-[58px] flex px-6 items-center ">
				<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
				<div class="text-lg font-bold">자주 묻는 질문</div>
			</div>
		</div>
		<div class="h-[54px] px-6" style="padding-top:58px;">
			<div class="flex items-center">
<?php if($TPL_catelist_1){foreach($TPL_VAR["catelist"] as $TPL_V1){?>
				<a href="/cont/?act=faq&cate_idx=<?php echo $TPL_V1["idx"]?>" class=" <?php if($TPL_V1["issel"]=='Y'){?>text-[#322A24]<?php }else{?>text-[#322A244D]<?php }?> text-sm font-medium pr-4"><?php echo $TPL_V1["catename"]?></a>
<?php }}?>
			</div>
		</div>
		
	</div>
</div>
</body>
</html>