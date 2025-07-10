<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicm/cont/search.htm 000002090 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
function searchgo()	{
	if($("#keyword").val()=='')	{
		alert('검색어를 입력하세요');
		return;
	}
	$("#searchfi").removeClass("hidden");
}
function showcont(obj,m)	{
	
		$(obj).parent().find("a").removeClass("text-[#6F6963]");
		$(obj).addClass("text-[#6F6963]");
}
</script>
</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="h-[58px] flex px-6 items-center">
			<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
		</div>
		<div class="px-6 pt-12">
			<div class="h-[35px]" style="border-bottom:1px solid #5E5955">
				<div class="pb-2 flex items-center">
					<div style="flex:1">
						<input type='text' id="keyword" name="keyword" class="block bg-[#FDFBF4] w-full font-medium" style="border:0;width:100%;" placeholder="검색어를 입력해 주세요.">
					</div>
					<div><A href="#none" onclick="searchgo();"><img src="/img/m/icon_SEARCH_dark.png"></a></div>
				</div>
			</div>
			<div  class="hidden text-[#C0BCB6]" id="searchfi">
				<div class="pt-8 flex items-center ">
					<a href="#none" class="text-[#6F6963] font-bold text-sm" onclick="event.preventDefault(); showcont(this,1)">통합검색</a>
					<span style="width:1px;height:10px;background-color:#C0BCB6" class="mx-2"></span>
					<a href="#none" class=" font-bold text-sm" onclick="event.preventDefault(); showcont(this,1)">쇼핑</a>			
					<span style="width:1px;height:10px;background-color:#C0BCB6" class="mx-2"></span>			
					<a href="#none" class=" font-bold text-sm" onclick="event.preventDefault(); showcont(this,1)">콘텐츠</a>						
				</div>
				<div class="pt-8 text-center text-[#C0BCB6] font-medium text-sm">
					검색 결과가 없어요.<br />다른 키워드로 검색해 보세요.
				</div>
			</div>
		</div>
		
	</div>
	
</div>
</body>
</html>