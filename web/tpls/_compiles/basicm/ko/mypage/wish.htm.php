<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicm/mypage/wish.htm 000003209 */ 
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
</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="h-[58px] flex flex items-center justify-between px-6 items-center">
			<div class="flex items-center">
				<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
				<div class="text-lg font-bold">관심상품</div>
			</div>
			<div class="flex items-center">
				<a href="/cont/?act=search" class="pr-6"><img src="/img/m/icon_SEARCH_dark.png"></a>
				<a href="/order/?act=cart"><img src="/img/m/icon_CART_dark.png"></a>				
			</div>
		</div>
		<div class=" px-6">

<?php if(sizeof($TPL_VAR["datalist"])== 0){?>
			<div class="py-12 text-center text-[#C0BCB6] text-sm">
				관심상품이 없어요.
			</div>
<?php }else{?>
			<div class="flex justify-between" style="flex-wrap: wrap;">
				
<?php if($TPL_datalist_1){foreach($TPL_VAR["datalist"] as $TPL_V1){?>	
				<div class="" style="width:48%;">
					<div  class="mb-2 relative">
						<A href="/shop/?act=view&idx=<?php echo $TPL_V1["idx"]?>">
							<img alt="<?php echo $TPL_V1["gname"]?>" loading="lazy" width="205" height="200" class="object-cover transition-transform duration-700 group-hover:scale-105"  src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="color: transparent;width:100%">
						</a>
						<a href="#none" onclick="event.preventDefault(); set_wish(<?php echo $TPL_V1["idx"]?>)" class="z-1" style="position:absolute;top:8px;right:8px;"><img src="/img/m/icon_wish_on.svg"></a>
					</div>
					<div>
						<a href="/shop/?act=view&idx=<?php echo $TPL_V1["idx"]?>">
							<div class="pb-1 text-sm text-[#111111] font-bold"><?php echo $TPL_V1["gname"]?></div>
							<div class="pb-1 text-xs text-[#C0BCB6] font-normal"><?php echo $TPL_V1["gname_pre"]?> <?php echo $TPL_V1["weight"]?></div>
							<div class="text-xs text-[#322A24] font-normal"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_V1["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></div>
						</a>
					</div>
				</div>
<?php }}?>
			</div>
<?php }?>
		</div>
	</div>
</div>
<?php $this->print_("down",$TPL_SCP,1);?>