<?php /* Template_ 2.2.7 2025/07/10 07:53:09 /home/grandhand/BUILDS/tpls/basicm/order/order_step2.htm 000035772 */ 
$TPL_goodslist_1=empty($TPL_VAR["goodslist"])||!is_array($TPL_VAR["goodslist"])?0:count($TPL_VAR["goodslist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script src="https://js.tosspayments.com/v2/standard"></script>
<style>
.brsel	{
	border: 1px solid #6F6963;
}
.brnosel	{
	border: 1px solid  #E9E6E0;
}
</style>
<?php if($TPL_VAR["global"]["G_HTTP_SCH"]=='http'){?>
<script src='http://dmaps.daum.net/map_js_init/postcode.v2.js'></script>
<?php }else{?>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<?php }?>
<script>
var element_layer = "";
$(document).ready(function()	{
	
	$("#allCheck").on("click",function()	{
	
		if($(this).is(":checked"))	{
			$("input[type=checkbox]").prop('checked', true).val('y');
			$label = $("input[type=checkbox]").siblings('label');
			$label.addClass('on');
			
		}
		else	{
			$("input[type=checkbox]").prop('checked', false).val('n');
			$label = $("input[type=checkbox]").siblings('label');
			$label.removeClass('on');
		}
	});
	
	element_layer = document.getElementById("findlayer");
	
	const $name     = $('#a_name');
	const $delname    = $('#a_delname');
	const $delcp = $('#a_delcp');
	const $delzip   = $('#a_delzip');
	const $deladdr1  = $('#a_deladdr1');
	const $deladdr2  = $('#a_deladdr2');
	const $submit = $('#a_submit');
	
	function validate() {
		
		let nameOk = false;
		if ($name.val().trim() === '') {
			$('#a_namemsg').text('배송지명을 입력하세요').removeClass('hidden');
			$name.addClass('bg-[#FF3E24]');
		} else {
			nameOk = true;
			$('#a_namemsg').addClass('hidden');
			$name.removeClass('bg-[#FF3E24]');
		}

		let delnameOk = false;
		if ($delname.val().trim() === '') {
			$('#a_delnamemsg').text('받는분을 입력하세요').removeClass('hidden');
			$delname.addClass('bg-[#FF3E24]');
		} else {
			delnameOk = true;
			$('#a_delnamemsg').addClass('hidden');
			$delname.removeClass('bg-[#FF3E24]');
		}
		
		let delcpOk = false;
		if ($delcp.val().trim() === '') {
			$('#a_delcpmsg').text('연락처를 입력하세요').removeClass('hidden');
			$delcp.addClass('bg-[#FF3E24]');
		} else {
			delcpOk = true;
			$('#a_delcpmsg').addClass('hidden');
			$delcp.removeClass('bg-[#FF3E24]');
		}
		
		let delzipOk = false;
		if ($delzip.val().trim() === '') {
			$('#a_delzipmsg').text('우편번호를 입력하세요').removeClass('hidden');
			$delzip.addClass('bg-[#FF3E24]');
		} else {
			delzipOk = true;
			$('#a_delzipmsg').addClass('hidden');
			$delzip.removeClass('bg-[#FF3E24]');
		}
		
		let deladdr1Ok = false;
		if ($deladdr1.val().trim() === '') {
			$('#a_deladdr1msg').text('주소를 입력하세요').removeClass('hidden');
			$deladdr1.addClass('bg-[#FF3E24]');
		} else {
			deladdr1Ok = true;
			$('#a_deladdr1msg').addClass('hidden');
			$deladdr1.removeClass('bg-[#FF3E24]');
		}
		
		let deladdr2Ok = false;
		if ($deladdr2.val().trim() === '') {
			$('#a_deladdr2msg').text('주소를 입력하세요').removeClass('hidden');
			$deladdr2.addClass('bg-[#FF3E24]');
		} else {
			deladdr2Ok = true;
			$('#a_deladdr2msg').addClass('hidden');
			$deladdr2.removeClass('bg-[#FF3E24]');
		}


		$submit.prop('disabled', !(nameOk && delnameOk && delcpOk && delzipOk && deladdr1Ok && deladdr2Ok));
	}
	
	$name.on('blur', validate);
	$delname.on('blur', validate);
	$delcp.on('blur', validate);
	$delzip.on('blur', validate);
	$deladdr1.on('blur', validate);
	$deladdr2.on('blur', validate);
	
	$("#delform").on("submit", function(e) {
		e.preventDefault();
		const data = $(this).serialize();
		var answer = confirm("배송지를 입력하시겠습니까?");
		if(answer==true)	{
			$.post("/exec/proajax.php?act=member&han=set_addr", data, function(result) {
				console.log(result);
				if(result.res=='ok')	{
					resetfi('','','','','','','');	
					$("#d_step2").addClass("hidden");	
					$("#d_step1").removeClass("hidden");
					getaddrs();
				}	else if(result.res == 'nologin')	{
					location.replace("/member/?act=login");	
				}	else	{
					alert(result.resmsg);	
				}
			});	
		}
		
	});
	
	
	
});
function opendels()	{
	if($("#dellist").css("display")=="none")	{
		$("#dellist").show();	
		$("#d_step1").removeClass("hidden");
		$("body").addClass("overflow-hidden");
		getaddrs();
	}	else	{
		$("#dellist").hide();	
		$("body").removeClass("overflow-hidden");
		$("#d_step1").addClass("hidden");
		$("#d_step2").addClass("hidden");		
	}
}
function resetfi(d1,d2,d3,d4,d5,d6,d7)	{
	
	if(d1 == 'Y')	{
		$("#a_isbasic").prop("checked",true);	
	}	else	{
		$("#a_isbasic").prop("checked",false);	
	}
	
	$("#a_name").val(d2);
	$("#a_delname").val(d3);	
	$("#a_delcp").val(d4);
	$("#a_delzip").val(d5);
	$("#a_deladdr1").val(d6);
	$("#a_deladdr2").val(d7);	
}
function openDaumPostcodeorder(f1,f2)	{
	console.log(element_layer);
    new daum.Postcode({
        oncomplete: function(data)	 {
            document.getElementById(f1).value = data.zonecode;

            var fullAddr = ''; // 최종 주소 변수
            var extraAddr = ''; // 조합형 주소 변수

            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if(data.userSelectedType === 'R')
            { // 사용자가 도로명 주소를 선택했을 경우
                fullAddr = data.roadAddress;

            } else
            { // 사용자가 지번 주소를 선택했을 경우(J)
                fullAddr = data.jibunAddress;
            }

            // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
            if(data.userSelectedType === 'R')
            {
                //법정동명이 있을 경우 추가한다.
                if(data.bname !== '')
                {
                    extraAddr += data.bname;
                }
                // 건물명이 있을 경우 추가한다.
                if(data.buildingName !== '')
                {
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
			
			

            document.getElementById(f2).value = fullAddr;
            element_layer.style.display = 'none';
        },
		width : '100%',
        height : '100%',
        maxSuggestItems : 5
    }).embed(element_layer);

    // iframe을 넣은 element를 보이게 한다.
    element_layer.style.display = 'block';

    // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
    initLayerPosition();
}
function initLayerPosition(){
	var width = 300; //우편번호서비스가 들어갈 element의 width
    var height = 500; //우편번호서비스가 들어갈 element의 height
    var borderWidth = 5; //샘플에서 사용하는 border의 두께

    // 위에서 선언한 값들을 실제 element에 넣는다.
    element_layer.style.width = width + 'px';
    element_layer.style.height = height + 'px';
    element_layer.style.border = borderWidth + 'px solid';
    // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
    element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
    element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
}
function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
	element_layer.style.display = 'none';
}
function getaddrs()	{
	$.getJSON("/exec/proajax.php?act=member&han=get_addr", function(results) {
		console.log(results);
		if(results.res=='nologin')	{
			location.replace("/member/?act=login");	
		}	else if(results.res=='ok')	{
			var str = '';
			$(results.datas).each(function(index, item) {
				str = str + "<li class='mb-4 px-4 py-4 brnosel' data-delidx='"+item.idx+"' data-delsel='N'>";
				str = str + "	<div class='flex items-center justify-between mb-3'>";
				str = str + "		<div class='flex items-center'>";
				str = str + "			<div class='pr-2.5'><input type='checkbox' id='delchk"+item.idx+"' class='chk-hidden agree-item ' ><label for='delchk"+item.idx+"' data-idx='"+item.idx+"' class='chk-img listitem' onclick='selectaddr(this)'></label></div><div class='pr-2.5 text-[#322A24] text-sm font-bold'>"+item.name+"</div>";
				if(item.isbasic == "Y")	{
					str = str + "<div class='text-[#6F6963] text-xs font-bold'>기본배송지</div>";	
				}
				str = str + "		</div>";
				str = str + "		<div class='flex items-center'>";
				str = str + "			<div class=''></div><div class='mx-3' style='width:1px;background-color:#E9E6E0;height:8px;'></div><div class=''></div>";
				str = str + "		</div>";
				str = str + "	</div>";
				str = str + "	<div class='pb-1 text-[#322A24] text-xs font-medium'>"+item.delname+"</div>";
				str = str + "	<div class='pb-1 text-[#322A24] text-xs font-medium'>"+item.delcp+"</div>";
				str = str + "	<div class='pb-1 text-[#322A24] text-xs font-medium'>"+item.deladdr1+" " + item.deladdr2 + "</div>";
				str = str + "</li>";
			});
			
			if(str == '')	{
				$("#addrlist").html('<li class="py-20 text-center text-[#C0BCB6] text-sm">새 배송지를 추가해 주세요.</li>');
			}	else	{
				$("#addrlist").html(str);
			}
		}	else	{
			alert(results.resmsg);	
		}
		
	});
}
function selectaddr(obj)	{

		var idx = $(obj).data("idx");
		var mode = "N";
		
		if($(obj).parent().find("input").prop("checked") == false)	{
			mode = "Y";	
		}	else	{
			$(obj).parent().parent().parent().parent().addClass("brnosel");
			$(obj).parent().parent().parent().parent().removeClass("brsel");
			$(this).parent().parent().parent().parent().data("delsel","N");
			$("#s_delbtn1").prop("disabled",true);
		}
		
		if(mode == "Y")	{
			$("#s_delbtn1").prop("disabled",false);

			$("#addrlist > li").each(function()	{
				if(idx == $(this).data("delidx"))	{
					console.log('aa');
					$(this).removeClass("brnosel");
					$(this).addClass("brsel");
					$(this).data("delsel","Y");
				}	else	{
					$(this).addClass("brnosel");
					$(this).removeClass("brsel");
					$(this).data("delsel","N");
					$(this).find("input").prop("checked",false);
				}
			});	
		}
}
function selectaddr()	{
	opendels();
}
function ordergo(obj)	{
	var isok = check_form(document.orderform);
	if(isok==true)	{
		if($("#use_mempoint").val()!=0  &&  parseInt($("#use_mempoint").val()) < parseInt($("#order_min_point").val()))	{
			alert(' 사용액은 ' + parseInt($("#order_min_point").val()) + ' 부터 사용가능합니다.');
			$("#use_mempoint").val('0');
			set_calcul();
			return;
		}
		if($("#use_mempoint").val()!=0  && $("#order_max_point1").val()!=0 && parseInt($("#use_mempoint").val()) > parseInt($("#order_max_point1").val()))	{
			alert(' 사용액은 ' + parseInt($("#order_max_point1").val()) + '까지만 사용가능합니다.');
			$("#use_mempoint").val('0');
			set_calcul();
			return;
		}
		answer = confirm($(obj).data("msg"));
		if(answer==true)	{
			var params = $("#orderform").serialize();
			$.ajax({
				type:'POST',
				url:'/exec/proajax.php?act=order&han=set_order',
				data:params,
				datatype:'json',
				success:function(resultdata){
					console.log(resultdata);
					if(resultdata.res=='ok')	{
						makepg(resultdata.datas);
					}
					else	{
						alert(resultdata.resmsg);
						$("#orderbtn").show();
					}

				},
				error:function(e){
					console.log(e);
					alert(e.statusText);
					$("#orderbtn").show();
				}
			});

		}
		else	{
			return;
		}	
	}
	else	{
		return;
	}
}
async function makepg(datas)	{
	console.log(datas);
	const amount = {
		currency: "KRW",
        value: datas.use_account / 100,
	};
	let selectedPaymentMethod = "CARD";
	const clientKey = "test_ck_D5GePWvyJnrK0W0k6q8gLzN97Eoq";
	const customerKey = generateRandomString();
	const tossPayments = TossPayments(clientKey);
	// 회원 결제
	// @docs https://docs.tosspayments.com/sdk/v2/js#tosspaymentspayment
	const payment = tossPayments.payment({
		customerKey,
	});
	
		switch (selectedPaymentMethod) {
			case "CARD":
				await payment.requestPayment({
					method: "CARD", // 카드 및 간편결제
					amount,
					orderId: "granh_"+datas.idx.toString(),
					orderName: "주문번호 : " + datas.idx,
					successUrl: window.location.origin + "/order/pg/toss/return.php", // 결제 요청이 성공하면 리다이렉트되는 URL
					failUrl: window.location.origin + "/order/pg/toss/returnfail.php", // 결제 요청이 실패하면 리다이렉트되는 URL
					customerEmail: "customer123@gmail.com",
					customerName: "김토스",
					// 가상계좌 안내, 퀵계좌이체 휴대폰 번호 자동 완성에 사용되는 값입니다. 필요하다면 주석을 해제해 주세요.
					// customerMobilePhone: "01012341234",
					card: {
						useEscrow: false,
						flowMode: "DEFAULT",
						useCardPoint: false,
						useAppCardOnly: false,
					},
				});
          case "TRANSFER":
            await payment.requestPayment({
              method: "TRANSFER", // 계좌이체 결제
              amount,
              orderId: generateRandomString(),
              orderName: "토스 티셔츠 외 2건",
              successUrl: window.location.origin + "/order/pg/toss/public/payment/success.html",
              failUrl: window.location.origin + "/order/pg/toss/public/fail.html",
              customerEmail: "customer123@gmail.com",
              customerName: "김토스",
              // 가상계좌 안내, 퀵계좌이체 휴대폰 번호 자동 완성에 사용되는 값입니다. 필요하다면 주석을 해제해 주세요.
              // customerMobilePhone: "01012341234",
              transfer: {
                cashReceipt: {
                  type: "소득공제",
                },
                useEscrow: false,
              },
            });
          case "VIRTUAL_ACCOUNT":
            await payment.requestPayment({
              method: "VIRTUAL_ACCOUNT", // 가상계좌 결제
              amount,
              orderId: generateRandomString(),
              orderName: "토스 티셔츠 외 2건",
              successUrl: window.location.origin + "/order/pg/toss/public/payment/success.html",
              failUrl: window.location.origin + "/order/pg/toss/public/fail.html",
              customerEmail: "customer123@gmail.com",
              customerName: "김토스",
              // 가상계좌 안내, 퀵계좌이체 휴대폰 번호 자동 완성에 사용되는 값입니다. 필요하다면 주석을 해제해 주세요.
              // customerMobilePhone: "01012341234",
              virtualAccount: {
                cashReceipt: {
                  type: "소득공제",
                },
                useEscrow: false,
                validHours: 24,
              },
            });
          
          
          
        }

}
 function generateRandomString() {
	return window.btoa(Math.random()).slice(0, 20);
}
</script>
</head>
<body>
<div id="root">
	<div class="bg-[#FDFBF5]">
		<div class="fixed top-0 left-0 right-0 h-[58px] flex px-6 items-center  bg-[#FDFBF4]">
			<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
			<div class="text-lg font-bold">결제하기</div>
		</div>
		<?php echo $TPL_VAR["basket"]["formstart"]?>

		<div class="px-6" style="padding-top:58px;">
			<div class="h-[54px] flex items-center justify-between">
				<div class="text-[#322A24] text-sm font-bold">배송정보</div>
				<a href="#none" onclick="event.preventDefault(); opendels()" class="text-[#322A244D] text-xs font-bold">배송지 목록</a>
			</div>
			<div id="show_sel_type1" <?php if($TPL_VAR["basket"]["havedels"]!= 0){?>class="hidden"<?php }?>>
				<button type="button" class=" h-[46px] text-[#322A24] text-sm font-bold mb-4" style="border:1px solid #C0BCB6;width:100%" onclick="event.preventDefault(); opendels();">새 배송지 추가</button>
				<div class="px-4 py-4 mb-6" style="background-color:#322A2408">
					<div class="text-[#6F6963] text-sms">정확한 배송을 위해 도로명 주소만 사용합니다.</div>
					<div class="text-[#6F6963] text-sms">배송지 불분명으로 반송되지 않도록 한 번 더 확인해 주세요</div>
				</div>
			</div>
			<div id="show_sel_type2" <?php if($TPL_VAR["basket"]["havedels"]== 0){?>class="hidden"<?php }?>>
				<div class="mb-6 px-4 py-4" style="border: 1px solid #E9E6E0">
					<div class="flex items-center mb-3">
						<div class="text-[#322A24] text-sm font-bold pr-2.5" id="d_name"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["name"]?><?php }?></div>
						<div class="text-[#6F6963] text-sms font-bold" id="d_basic"><?php if($TPL_VAR["basket"]["havedels"]!= 0&&$TPL_VAR["basket"]["delinfo"]["isbasic"]=="Y"){?>기본배송지<?php }?></div>
					</div>
					<div class="text-[#322A24] text-xs font-medium pr-2.5 mb-1" id="d_delname"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["delname"]?><?php }?></div>
					<div class="text-[#322A24] text-xs font-medium pr-2.5 mb-1" id="d_delcp"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["delcp"]?><?php }?></div>
					<div class="text-[#322A24] text-xs font-medium pr-2.5 mb-1" id="d_deladdr"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["deladdr1"]?> <?php echo $TPL_VAR["basket"]["delinfo"]["deladdr2"]?><?php }?></div>
				</div>
			</div>
			
			<div class="h-[54px] flex items-center text-[#322A24] text-sm font-bold">
				배송 요청 사항
			</div>
			<div class="flex px-4 py-2 items-center justify-between mb-6" style="border:1px solid #C0BCB6;">
				<div style="flex:1" class="text-sm text-[#C0BCB6] font-normal">배송 시 요청사항을 선택해 주세요.</div>
				<img src="/img/m/icon_DROPDOWN_dark.png">
			</div>
			<div class="h-[54px] flex items-center text-[#322A24] text-sm font-bold">주문 상품 정보</div>
			<div class="mb-6">
<?php if($TPL_goodslist_1){foreach($TPL_VAR["goodslist"] as $TPL_V1){?>
				<div style="box-shadow: 0px 0px 10px 0px #322A2412;" class="px-4 py-4">
					<div class="flex items-start pb-4 mb-4" style="border-bottom:1px dashed #E9E6E0">
						<div class="pr-4">
							<img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="width:72px;">
						</div>
						<div>
							<div class="text-[#C0BCB6] text-xs font-bold pb-3">GRANHAND</div>
							<div class="text-[#322A24] text-xs font-medium"><?php echo $TPL_V1["gname"]?></div>
							<div class="text-[#322A24] text-sm font-bold"><?php echo $TPL_V1["account"]?></div>
						</div>
					</div>
					<div class="flex items-center justify-between">
						<div class="text-[#322A24] text-sm font-medium pb-2">스탬핑 문구</div>
					</div>
					<div class="flex items-center justify-between mb-2">
						<div class="px-2" style="border:1px solid #C0BCB6;width:65%;">
							<input type="text" placeholder="원하는 문구를 입력해 주세요." class="block bg-[#FDFBF4]  h-[44px] font-normal text-xs" />
						</div>
						<button type="button" class="h-[46px] text-[#6F6963] text-sm font-bold" style="width:72px;background-color:#322A2408">특수기호</button>
						
					</div>
					<div class="text-[#6F6963] text-sms font-medium">10자 이하 영문 대문자, 숫자, 특수기호(. , ! % & ? ❤️)만 가능합니다. 스탬핑 작업 시 교환 및 환불이 불가능합니다. </div>
				</div>
<?php }}?>
			</div>
			<div class="flex pb-4">
				<div class="text-[#322A24] text-sm font-bold">사용 가능 쿠폰</div>
				<div class="pl-2.5"><img src="/img/m/icon_HELP.png"></div>
			</div>
			<div class="flex px-4 py-2 items-center justify-between mb-6" style="border:1px solid #C0BCB6;background-color:#E9E6E0;">
				<div style="flex:1" class="text-sms text-[#C0BCB6] font-normal">사용 가능한 쿠폰이 없습니다.</div>
				<img src="/img/m/icon_DROPDOWN_dark.png">
			</div>
			<div class="flex pb-4">
				<div class="text-[#322A24] text-sm font-bold">포인트</div>
				<div class="pl-2.5"><img src="/img/m/icon_HELP.png"></div>
			</div>
			<div class="flex items-center justify-between mb-4">
				<div style="flex:1;border:1px solid #C0BCB6" class="mr-3 px-4 py-3">
					<input type='text' class="px-4 " style="background-color:transparent;width:80%;">
				</div>
				<button class="px-4 py-3 text-[#FDFBF5] text-sm font-bold" style="background-color:#322A24">
					전체 사용
				</button>
			</div>
			<div style="box-shadow: 0px 0px 10px 0px #322A2412;" class="flex items-center justify-between px-4 py-4 mb-6">
				<div class="text-[#6F6963] text-xs font-bold">사용 가능한 포인트</div>
				<div class="text-[#6F6963] text-xs font-bold"><?php echo $TPL_VAR["gmem"]["mempoints"]?></div>
			</div>
			<div class="h-[54px] flex items-center text-[#322A24] text-sm font-bold">
				결제수단
			</div>
			<div class="pt-2 pb-4 flex items-center text-[#6F6963] text-sm font-medium">
				<button type="button" class="pr-1 flex items-center text-[#6F6963] text-sm font-medium">
					<div class="pr-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
							<circle cx="7" cy="7" r="6.5" fill="#FDFBF5" stroke="#E9E6E0"/>
						</svg>
					</div>
					간편결제
				</button>
			</div>
			<div id="b1" class=" flex flex-col pb-4">
				<div class="relative !w-[739px]">
							<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground hover:bg-primary/90 h-10 absolute top-1/2 -translate-y-1/2 left-0 z-10 bg-transparent rounded-full p-1 border-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left text-[#5E5955]" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg></button>
							<div id="card-scroll-container" class="flex gap-4 overflow-x-auto pb-2 scroll-smooth mx-8 w-[654px]">
								
								<div class="w-[240px] h-[140px] !min-w-[240px] !max-w-[240px] p-6 rounded bg-[#E9E6E0] text-[gray-400] text-sm flex flex-col justify-between">
									<div class="w-full h-full flex items-center justify-center">
										<div class="w-[16px] h-[16px] border border-[#322A241A] rounded-full text-xs bg-[#FDFBF5] text-[#5E5955] text-[8px] font-bold flex items-center justify-center">
											<svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus" aria-hidden="true"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
										</div>
									</div>
								</div>
							</div>
							<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground hover:bg-primary/90 h-10 absolute top-1/2 -translate-y-1/2 right-6 z-10 bg-transparent p-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right text-[#5E5955]" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
							</button>
				</div>
			</div>
			<div class="pt-2 pb-4">
				<button type="button" class="pr-1 flex items-center text-[#6F6963] text-sm font-medium">
					<div class="pr-1">
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
							<circle cx="7" cy="7" r="6.5" fill="#FDFBF5" stroke="#E9E6E0"/>
							  <circle cx="7" cy="7" r="2" fill="#6F6963"/>
						</svg>
					</div>
					일반결제
				</button>
			</div>
			<div id="b2" class="flex flex-col">
				<button type="button" style="border: 1px solid #6F6963;width:48%" class="text-[#322A24] text-sm font-normal py-3 mb-4" onclick="$('#buymethod_type').val('C');" >신용/체크카드</button>
			</div>
			
			<div class="px-4 py-4 mb-6" style="background-color:#322A2408">
				<div class="text-[#6F6963] text-sms">무통장 입금은 영업일 기준 24시간 이내 확인됩니다.</div>
				<div class="text-[#6F6963] text-sms">주문 후 72시간 이내에 미입금 시 자동 취소됩니다.</div>
			</div>
			<div class="h-[54px] flex items-center text-[#322A24] text-sm font-bold">최종 결제 금액</div>
			<div class="mb-6">
				<div style="box-shadow: 0px 0px 10px 0px #322A2412;" class="px-4 py-4">
					<div style="border-bottom: 1px dashed #E9E6E0" class="mb-4">
						<div class="flex items-center justify-between pb-2">
							<div class="text-[#C0BCB6] text-xs font-normal">상품금액</div>
							<div class="text-[#6F6963] text-xs font-normal"><?php echo $TPL_VAR["basket"]["totalgaccount"]?>원</div>
						</div>
						<div class="flex items-center justify-between pb-2">
							<div class="text-[#C0BCB6] text-xs font-normal">배송비</div>
							<div class="text-[#6F6963] text-xs font-normal"><?php echo $TPL_VAR["basket"]["delaccount"]?>원</div>
						</div>
						<div class="flex items-center justify-between pb-2">
							<div class="text-[#C0BCB6] text-xs font-normal">쿠폰 할인</div>
							<div class="text-[#6F6963] text-xs font-normal">0원</div>
						</div>
						<div class="flex items-center justify-between pb-4">
							<div class="text-[#C0BCB6] text-xs font-normal">포인트 사용</div>
							<div class="text-[#6F6963] text-xs font-normal">0원</div>
						</div>
					</div>
					<div class="flex items-center justify-between">
						<div class="text-[#322A24] text-xs font-bold">결제 금액</div>
						<div class="text-[#322A24] text-basexs font-bold"><?php echo $TPL_VAR["basket"]["totalaccount"]?>원</div>
					</div>
				</div>
			</div>
			<div class="h-[54px] flex items-center text-[#322A24] text-sm font-bold justify-between">
				<div>적립 예정 포인트</div>
				<div>+0</div>
			</div>
			<div class="px-4 py-4 mb-6" style="background-color:#322A2408">
				<div class="text-[#6F6963] text-sms">구매 확정 시 회원 등급별 혜택에 따라 포인트가 지급됩니다. </div>
			</div>
			<div class="flex py-4 items-center mb-4" style="border-top:1px solid #E9E6E0;;border-bottom:1px dashed #E9E6E0">
				<div class="pr-4">
					<input type="checkbox" id="allCheck" class="chk-hidden agree-item">
					<label for="allCheck" class="chk-img"></label>
				</div>
				<div class="text-[#6F6963] text-xs font-bold">주문 내용을 확인했으며, 아래 내용에 모두 동의합니다.</div>
			</div>
			<div class="flex pb-2 items-center justify-between">
				<div class="flex items-center">
					<div class="pr-4">
						<input type="checkbox" id="allCheck1" class="chk-hidden agree-item"  valch="yes" msg="개인정보 수집 • 이용 동의해주세요">
						<label for="allCheck1" class="chk-img"></label>
					</div>
					<div class="text-[#6F6963] text-xs font-normal">(필수)</div>
					<div class="text-[#6F6963] text-xs font-bold">개인정보 수집 • 이용 동의</div>
				</div>
				<div><img src="/img/icon_ARROWRIGHT_dark.png"></div>
			</div>
			<div class="flex pb-2 items-center justify-between">
				<div class="flex items-center">
					<div class="pr-4">
						<input type="checkbox" id="allCheck2" class="chk-hidden agree-item" valch="yes" msg="개인정보 제3자 정보 제공 동의해주세요" >
						<label for="allCheck2" class="chk-img"></label>
					</div>
					<div class="text-[#6F6963] text-xs font-normal">(필수)</div>
					<div class="text-[#6F6963] text-xs font-bold">개인정보 제3자 정보 제공 동의</div>
				</div>
				<div><img src="/img/icon_ARROWRIGHT_dark.png"></div>
			</div>
			<div class="flex pb-2 items-center justify-between">
				<div class="flex items-center">
					<div class="pr-4">
						<input type="checkbox" id="allCheck3" class="chk-hidden agree-item"  valch="yes" msg="결제대행 서비스 이용약관 동의해주세요" >
						<label for="allCheck3" class="chk-img"></label>
					</div>
					<div class="text-[#6F6963] text-xs font-normal">(필수)</div>
					<div class="text-[#6F6963] text-xs font-bold">결제대행 서비스 이용약관 동의</div>
				</div>
				<div><img src="/img/icon_ARROWRIGHT_dark.png"></div>
			</div>
			
			<div style="width:100%;height:110px;"></div>
		</div>
		<?php echo $TPL_VAR["basket"]["formend"]?>

	</div>
</div>
<div class="fixed px-6 z-20 bg-[#FDFBF5] py-6" style="bottom:0;left:0;right:0;">
	<button type="button" onclick="ordergo(this);" data-msg="<?php echo trscode('ORDER11')?>" id="f_buy" class="w-full block h-[46px] text-sm text-[#FFFFFF] font-bold disabled:opacity-15 bg-[#322A24]" >결제하기</button>
</div>
<div id="dellist" class="z-20 top-0 bottom-0 left-0 right-0 min-h-screen bg-[#FDFBF5] hidden" style="position:absolute">
	<div id="d_step1" class="hidden">
		<div class="h-[58px] flex px-6 items-center">
			<a href="#none" onclick="event.preventDefault(); opendels();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
			<div class="text-lg font-bold">배송지 목록</div>
		</div>
		<div class="px-4 pt-[56px]">
			<button type="button" class=" h-[46px] text-[#322A24] text-sm font-bold mb-4" style="border:1px solid #C0BCB6;width:100%" onclick="$('#d_step2').removeClass('hidden'); $('#d_step1').addClass('hidden');">새 배송지 추가</button>
		</div>
		<Div class="px-4">
			<div  style="height:calc(100vh - 260px);overflow-y:scroll;">
				<ul id="addrlist">
		
				</ul>
			</div>
		</div>
		<div class="fixed px-6 z-20 bg-[#FDFBF5] py-6" style="bottom:0;left:0;right:0;">
			<button type="button" id="s_delbtn1" class="w-full block h-[46px] text-sm text-[#FFFFFF] font-bold disabled:opacity-15 bg-[#322A24]" disabled onclick="selectaddr()">선택완료</button>
		</div>
	</div>
	<div id="d_step2" class="hidden">
		<div class="h-[58px] flex px-6 items-center">
			<a href="#none" onclick="event.preventDefault(); opendels();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
			<div class="text-lg font-bold">배송지 입력</div>
		</div>
		<form id="delform">
		<div  style="height:calc(100vh - 152px);overflow-y:scroll;">
		<div class="px-6 pt-4" >
			<div class="flex items-center pb-4">
				<div class="pr-4">
					<input type="checkbox" id="a_isbasic" name="isbasic" value="Y" class="chk-hidden agree-item" >
					<label for="a_isbasic" class="chk-img"></label>
				</div>
				<div class="text-[#322A24] text-xs font-normal">기본 배송지</div>
			</div>
			<div class="text-sm text-[#322A24] font-medium pb-2">배송지명</div>
			<div class="mb-4">
				<div class="h-[46px] border-[#C0BCB6] border mb-1">
					<input type="text" id="a_name" name="name" placeholder="배송지명을 입력해 주세요." class="block px-4 bg-[#FDFBF4] w-full h-[44px] font-normal  text-sm" />
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="a_namemsg"></div>
			</div>
			<div class="text-sm text-[#322A24] font-medium pb-2">받는 분</div>
			<div class="mb-4">
				<div class="h-[46px] border-[#C0BCB6] border mb-1">
					<input type="text" id="a_delname" name="delname" placeholder="성함을 입력해 주세요." class="block px-4 bg-[#FDFBF4] w-full h-[44px] font-normal  text-sm" />
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="a_delnamemsg"></div>
			</div>
			<div class="text-sm text-[#322A24] font-medium pb-2">연락처</div>
			<div class="mb-4">
				<div class="h-[46px] border-[#C0BCB6] border mb-1">
					<input type="text" id="a_delcp" name="delcp" placeholder="연락처를 입력해 주세요." class="block px-4 bg-[#FDFBF4] w-full h-[44px] font-normal text-sm" />
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="a_delcpmsg"></div>
			</div>
			<div class="text-sm text-[#322A24] font-medium pb-2">주소</div>
			<div class="mb-4">
				<div class=" flex items-center mb-1 ">
					<div style="flex:1;" class="border-[#C0BCB6] border mr-3 ">
						<input type='text' readonly name="delzip" id="a_delzip" class="block px-4 bg-[#FDFBF4] w-full h-[44px] bg-[#FDFBF4] font-normal text-sm" placeholder="우편번호 찾기" onclick="openDaumPostcodeorder('a_delzip','a_deladdr1');">
					</div>
					<button type="button" class="px-4 py-3 text-[#FDFBF5] text-sm font-bold" style="background-color:#322A24" onclick="openDaumPostcodeorder('a_delzip','a_deladdr1');">
						검색
					</button>
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="a_delzipmsg"></div>
			</div>
			<div class="mb-4">
				<div class="h-[46px] border-[#C0BCB6] border mb-1">
					<input type="text" id="a_deladdr1" name="deladdr1" readonly onclick="openDaumPostcodeorder('a_delzip','a_deladdr1');" placeholder="주소를 입력해 주세요." class="block px-4 bg-[#FDFBF4] w-full h-[44px] font-normal text-sm" />
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="a_deladdr1msg"></div>
			</div>
			<div class="mb-4">
				<div class="h-[46px] border-[#C0BCB6] border mb-1">
					<input type="text" id="a_deladdr2" name="deladdr2" placeholder="상세주소를 입력해 주세요." class="block px-4 bg-[#FDFBF4] w-full h-[44px] text-sm font-normal" />
				</div>
				<div class="hidden text-[#FF3E24] text-[10px]" id="a_deladdr2msg"></div>
			</div>
		</div>
		
		</div>
		<div class="fixed px-6 z-20 bg-[#FDFBF5] py-6" style="bottom:0;left:0;right:0;">
			<button type="submit" id="a_submit" class="w-full block h-[46px] text-sm text-[#FFFFFF] font-bold disabled:opacity-15 bg-[#322A24]" disabled>저장</button>
		</div>
		</form>
	</div>
</div>
<div id="findlayer" style="display:none;position:fixed;overflow:hidden;z-index:1000;-webkit-overflow-scrolling:touch;">
	<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>
</body>
</html>