<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicm/cont/store.htm 000002167 */ 
$TPL_brlist_1=empty($TPL_VAR["brlist"])||!is_array($TPL_VAR["brlist"])?0:count($TPL_VAR["brlist"]);
$TPL_storelist_1=empty($TPL_VAR["storelist"])||!is_array($TPL_VAR["storelist"])?0:count($TPL_VAR["storelist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="fixed top-0 left-0 right-0 z-20 bg-[#FDFBF4]">
			<div class="h-[58px] flex px-6 items-center ">
				<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
				<div class="text-lg font-bold">STORE</div>
			</div>
			<div class="h-[54px] flex px-6 items-center ">
<?php if($TPL_brlist_1){foreach($TPL_VAR["brlist"] as $TPL_V1){?>
				<a href="/cont/?act=store&brand_idx=<?php echo $TPL_V1["idx"]?>" class="pr-4 font-bold <?php if($TPL_V1["issel"]=='Y'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-sm"><?php echo $TPL_V1["brandname"]?></a>
<?php }}?>
			</div>
			<div class="h-[54px] flex px-6 items-center">
<?php if($TPL_storelist_1){foreach($TPL_VAR["storelist"] as $TPL_V1){?>
				<a href="/cont/?act=store&brand_idx=<?php echo $TPL_V1["brand_idx"]?>&store_idx=<?php echo $TPL_V1["idx"]?>" class="pr-4 font-bold <?php if($TPL_V1["issel"]=='Y'){?>text-[#322A24]<?php }else{?>text-[#C0BCB6]<?php }?> text-xs"><?php echo $TPL_V1["name"]?></a>
<?php }}?>
			</div>
		</div>
		<div class="px-6" style="padding-top:174px">
			<div class="flex items-center pb-3">
				<div class="text-[#322A24] text-xs font-medium pr-2"><?php echo $TPL_VAR["store"]["fullname"]?></div>
				<div class="text-[#C0BCB6] text-xs font-normal pr-2"><?php echo $TPL_VAR["store"]["addr"]?></div>
			</div>
<?php if(is_array($TPL_R1=$TPL_VAR["store"]["imgs"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<div class="pb-4">
				<img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/store/<?php echo $TPL_V1["filename"]?>" style="width:100%;">
			</div>
<?php }}?>
		</div>
		
	</div>
</div>
</body>
</html>