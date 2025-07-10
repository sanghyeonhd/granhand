/*
 * 
 * 체크박스 선택 상품 위 아래 위치이동
 * 
 * .list_wrap > table > tbody > tr.selected > td {
    	background: yellow;
	}
 * 
 */
$(function($) {
	// 체크박스 라인 색칠하기
	$('input').on('change', function () {
	    if ($(this).is(':checked')) {
	        $(this).parent().parent().addClass('selected');
	    } else {
	        $(this).parent().parent().removeClass('selected');
	    }
	});
	
	// 체크박스 업
	$('.multicheck > .up').on('click', function () {
	    target = ''
		$('tr.selected').each(function () {
	        if ($(this).prev() && $(this).prevAll(':not(.selected)').length) {
	            $(this).insertBefore($(this).prev());  
	        }
	    })
		scrollToCenter();
	});
	
	// 체크박스 다운
	$('.multicheck > .down').on('click', function () {
		$($('tr.selected').get().reverse()).each(function () {
	        if ($(this).next() && $(this).nextAll(':not(.selected)').length) {
	            $(this).insertAfter($(this).next());  
	        }
	    });
		scrollToCenter();
	});
	
	// 첫번째
	$('.multicheck > .first').on('click', function () {
		$($('tr.selected').get().reverse()).each(function () {
	       if ($(this).prev() && $(this).prevAll(':not(.selected)').length) {
	    	   $(this).insertBefore($("#sorttable tr:eq(1)").first());
	       }
	    });
		scrollToCenter();
	});
	
	// 끝
	$('.multicheck > .end').on('click', function () {
	    $($('tr.selected').get().reverse()).each(function () {

	        if ($(this).next() && $(this).nextAll(':not(.selected)').length) {
	            $(this).insertAfter($("#sorttable tr:eq(-1)").last());  
	        }
			
	    });
		scrollToCenter();
	});

	$(".movebtn").on('click', function () {
		if($("#goorders").val()=='')	{
			alert('이동할 위치입력');
			return;
		}

		$($('tr.selected').get().reverse()).each(function () {
	       if ($(this).prev() || $(this).nextAll(':not(.selected)').length) {
	    	   $(this).insertAfter($("#sorttable tr:eq("+$("#goorders").val()+")"));
	       }
	    });
		$("#goorders").val('');
		scrollToCenter();
	});
	
});

function scrollToCenter() {
	
	var nums = 0;
	var target = '';
	$('tr').each(function () {
		if(target=='' && $(this).attr('class')=='selected')	{
			target = $(this);
		}
		$(this).find(".ornums").html("["+nums+"]");
		nums = nums + 1;
	})
	
	var container = $('#scont'),
	scrollTo = target;

	container.animate({
		scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()

	});	
}