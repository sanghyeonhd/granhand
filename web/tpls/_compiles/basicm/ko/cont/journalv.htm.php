<?php /* Template_ 2.2.7 2025/07/08 17:45:27 /home/grandhand/BUILDS/tpls/basicm/cont/journalv.htm 000002349 */ ?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script>
$(document).ready(function()	{
	$('#shareBtn').on('click', function () {
		if (navigator.share) {
			navigator.share({
				title: '<?php echo $TPL_VAR["datas"]["subject"]?>',
				text: '',
				url: window.location.href
			}).then(() => {
				console.log('공유 성공');
			}).catch((error) => {
				console.error('공유 실패', error);
			});
		} else {
			alert('이 브라우저는 공유 기능을 지원하지 않습니다.');
		}
	});
	function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.bottom > 0 &&
            rect.top < (window.innerHeight || document.documentElement.clientHeight)
        );
    }

    function checkSwiperVisibility() {
        const mainimg = $('.mainimg')[0]; // 첫 번째 swiper1 요소
        if (!mainimg) return;

        if (!isElementInViewport(mainimg)) {
            $('.topbar').addClass('bg-[#FDFBF5]');
			$("#shareimg").attr("src","/img/m/icon_SHARE_dark.png");
        } else {
            $('.topbar').removeClass('bg-[#FDFBF5]');
			$("#shareimg").attr("src","/img/m/icon_SHARE_beige.png");			
        }
    }

    // 초기 확인
    checkSwiperVisibility();

    // 스크롤 시 확인
    $(window).on('scroll', function () {
        checkSwiperVisibility();
    });

});

</script>
</head>
<body>
<div id="root">
	<div class="min-h-screen">
		<div class="topbar h-[58px] flex px-6 items-center fixed top-0 right-0 left-0 justify-between">
			<div class="flex items-center">
				<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
				<div class="text-lg font-bold text-[#5E5955]">JURNAL</div>
			</div>
			<div><A href="#none" id="shareBtn"><img id="shareimg" src="/img/m/icon_SHARE_beige.png"></a></div>
		</div>
		<div>
			<div class="mainimg"><img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/journal/<?php echo $TPL_VAR["datas"]["img"]?>" style="width:100%;"></div>
			<div class="bg-[#FDFBF4] px-6 py-6">
				<?php echo $TPL_VAR["datas"]["memo"]?>

			</div>
		</div>
	</div>
</div>
</body>
</html>