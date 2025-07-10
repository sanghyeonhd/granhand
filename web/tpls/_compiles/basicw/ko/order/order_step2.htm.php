<?php /* Template_ 2.2.7 2025/07/08 17:45:30 /home/grandhand/BUILDS/tpls/basicw/order/order_step2.htm 000032602 */ 
$TPL_goodslist_1=empty($TPL_VAR["goodslist"])||!is_array($TPL_VAR["goodslist"])?0:count($TPL_VAR["goodslist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<script src="https://js.tosspayments.com/v2/standard"></script>
<Script>
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
					orderId: "gran_"+datas.idx.toString(),
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
<?php $this->print_("top",$TPL_SCP,1);?>

<main class="container mx-auto pt-8 relative">
	<h2 class="text-lg font-medium text-left mb-8 pb-4 text-[#6F6963]">결제하기</h2>
	<?php echo $TPL_VAR["basket"]["formstart"]?>

	<div class="grid md:grid-cols-[739px_357px] gap-8 mt-10">
		
		<div>
			<section class="space-y-2 mb-10">
				<div class="flex justify-between">
					<h2 class="text-sm font-bold text-[#322A24]">배송 정보</h2>
					<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 h-10 px-4 py-2 border rounded-none text-[10px] text-center font-bold text-[#6F6963] border-[#E9E6E0]" onclick="opendels()">배송지 목록</button>
				</div>
				<div id="show_sel_type2" <?php if($TPL_VAR["basket"]["havedels"]== 0){?>class="hidden"<?php }?> >
					<div class="h-[137px] border !border-[#E9E6E0] p-6 rounded-md space-y-2 text-sm text-[#322A24]">
						<div class="flex items-center gap-2">
							<button type="button" role="checkbox" aria-checked="true" data-state="checked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 !w-[16px] !h-[16px] data-[state=checked]:bg-gray-600 data-[state=checked]:text-white" id="address"><span data-state="checked" class="flex items-center justify-center text-current" style="pointer-events:none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check h-4 w-4" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg></span></button>
						
							<span class="text-sm font-bold text-[#322A24]" id="d_name"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["name"]?><?php }?></span>
							<span class="text-[10px] font-bold text-[#6F6963] ml-2" id="d_basic"><?php if($TPL_VAR["basket"]["havedels"]!= 0&&$TPL_VAR["basket"]["delinfo"]["isbasic"]=="Y"){?>기본배송지<?php }?></span>
						</div>
						<div class="pl-6 space-y-1 text-[#322A24] text-xs font-medium">
							<p id="d_delname"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["delname"]?><?php }?></p>
							<p id="d_delcp"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["delcp"]?><?php }?></p>
							<p id="d_deladdr"><?php if($TPL_VAR["basket"]["havedels"]!= 0){?><?php echo $TPL_VAR["basket"]["delinfo"]["deladdr1"]?> <?php echo $TPL_VAR["basket"]["delinfo"]["deladdr2"]?><?php }?>부산광역시 부전동 서전로 8번길 현대카드</p>
						</div>
					</div>
				</div>
				<div id="show_sel_type1" <?php if($TPL_VAR["basket"]["havedels"]!= 0){?>class="hidden"<?php }?>>
					<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary hover:bg-primary/90 px-4 py-2 border rounded-none text-sm font-bold text-center w-full h-[46px] text-[#322A24] !border-[#C0BCB6] cursor-pointer">새 배송지 추가</button>
				</div>			
				<div class="text-xs text-[#6F6963] bg-[#322A2408] p-[16px] px-[32px] h-[68px]">
					<ul class="list-disc space-y-1.5">
						<li>정확한 배송을 위해 도로명 주소만 사용합니다.</li>
						<li>배송지 불분명으로 반송되지 않도록 한 번 더 확인해 주세요.</li>
					</ul>
				</div>
			</section>
			<section class="space-y-2 mb-10">
				<h2 class="text-sm font-bold text-[#322A24]">배송 요청사항</h2>
				<button type="button" role="combobox" aria-controls="radix-«R4j3rlrl7»" aria-expanded="false" aria-autocomplete="none" dir="ltr" data-state="closed" data-placeholder="" class="flex items-center justify-between bg-background ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 [&amp;&gt;span]:line-clamp-1 w-full h-[46px] border border-[#C0BCB6] rounded px-[18px] py-[12px] text-sm data-[placeholder]:text-[#C0BCB6]"><span style="pointer-events:none">배송 시 요청사항을 선택해 주세요.</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down h-4 w-4 opacity-50" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg></button>
			</section>
			<section class="space-y-4 mb-10">
				<h2 class="text-sm font-bold text-[#322A24]">주문 상품 정보</h2>
				<div class="border shadow-md rounded-md p-6 space-y-4">
<?php if($TPL_goodslist_1){foreach($TPL_VAR["goodslist"] as $TPL_V1){?>
					<div class="flex gap-4 items-start">
						<img alt="product" loading="lazy" width="72" height="72" decoding="async" data-nimg="1" class="w-[72px]" style="color:transparent" src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>">
						<div class="flex-1 space-y-3 text-xs">
							<div class="font-bold text-[#C0BCB6]">GRANHAND</div>
							<div class="space-y-1">
								<div class="font-medium text-[#322A24] mt-1"><?php echo $TPL_V1["gname"]?></div>
								<div class="text-sm text-[#322A24] font-bold mt-1"><?php echo $TPL_V1["account"]?></div>
							</div>
						</div>
					</div>
					<hr class="my-4 border-dashed">
					<div class="space-y-1 text-xs text-[#6F6963]">
						<div class="flex hidden">
							<span class="text-[#C0BCB6] w-24 leading-[20px]">옵션</span>
							<span>롤랑 멀티퍼퓸 100ml / 1개</span>
						</div>
						<div class="flex">
							<span class="text-[#C0BCB6] w-24">쇼핑백</span><span>구매안함</span>
						</div>
					</div>
					<hr class="my-4 border-dashed">
					<div>
						<div class="flex justify-between items-center mb-2">
							<h3 class="font-medium text-sm text-[#322A24]">스탬핑 문구</h3>
							<button type="button" role="switch" aria-checked="false" data-state="unchecked" value="on" class="peer inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input bg-[#FDFBF5] border"><span data-state="unchecked" class="pointer-events-none block h-5 w-5 rounded-full shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0 border bg-white"></span></button>
						</div>
						<div class="flex items-center gap-2 relative">
							<input type="text" class="flex w-full bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm h-[46px] flex-1 border !border-[#C0BCB6] rounded px-3 py-3 text-sm text-[#322A24] placeholder:text-[#C0BCB6]" placeholder="원하는 문구를 입력해 주세요." disabled="" value="">
							<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 py-2 w-[72px] h-[46px] text-sm bg-[#322A2408] text-[#6F6963]">특수기호</button>
						</div>
						<p class="text-[10px] text-[#6F6963] mt-2">
							<span class="leading-[18px]">10자 이하 영문 대문자, 숫자, 특수기호(. , ! % &amp; ? ❤️)만 가능합니다.</span>
							<br>스탬핑 작업시 교환 및 환불이 불가능합니다.
						</p>
					</div>
					<hr class="my-4 border">
<?php }}?>
				</div>
			</section>
			<section class="space-y-2 mb-10">
				<div class="flex items-center gap-2 relative">
					<h2 class="text-sm font-bold text-[#322A24]">사용 가능 쿠폰</h2>
					<div class="relative group">
						<div class="w-[24px] h-[24px] border border-gray-200 rounded-full text-xs text-[#C0BCB6] text-[8px] font-bold flex items-center justify-center">?</div>
						<div class="absolute left-full top-1/2 -translate-y-1/2 ml-2 bg-[#E34234] text-white text-xs px-3 py-1 rounded shadow-md w-[137px] h-[24.49px] text-[10px] font-bold whitespace-nowrap   before:content-[''] before:absolute before:left-[-6px] before:top-1/2 before:-translate-y-1/2   before:border-y-8 before:border-y-transparent before:border-r-8 before:border-r-[#E34234]">최대 할인이 적용되었어요!</div>
					</div>
				</div>
				<button type="button" dir="ltr" class="flex items-center justify-between border-input bg-background ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 [&amp;&gt;span]:line-clamp-1 w-full border !border-[#C0BCB6] rounded px-4 py-2 h-[46px] text-[#6F6963] data-[placeholder]:text-[#C0BCB6] text-[10px] font-bold">
					<span style="pointer-events:none">쿠폰을 적용하세요.</span>
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down h-4 w-4 opacity-50" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
				</button>
			</section>
			<section class="space-y-2 mb-10">
				<div class="text-sm font-bold flex items-center gap-2 text-[#322A24]">포인트
					<div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 text-gray-400 text-xs">?</div>
				</div>
				<div class="flex gap-2">
					<input type="text" class="flex w-full bg-background text-[#322A24] ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm flex-1 border rounded px-3 py-2 text-sm h-[46px] !border-[#C0BCB6] placeholder:text-[#C0BCB6]" placeholder="사용하실 포인트를 입력해 주세요.">
					
					<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 border px-4 py-2 text-sm font-bold rounded text-white bg-[#322A24] w-[88px] h-[46px]">전체 사용</button>
				</div>
				<div class="bg-[#FDFBF5] shadow-sm border rounded px-4 py-3 text-xs flex justify-between font-bold items-center text-[#6F6963] h-[52px]">
					<span>사용 가능한 포인트</span>
					<span><?php echo $TPL_VAR["gmem"]["mempoints"]?></span>
				</div>
			</section>
			<section class="space-y-2">
				<h2 class="text-sm font-bold text-[#322A24]">결제수단</h2>
				<div class="space-y-2">
					<div role="radiogroup" aria-required="false" dir="ltr" class="grid gap-2" tabindex="0" style="outline:none">
						<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-start gap-3 cursor-pointer space-y-4">
							<button type="button" role="radio" aria-checked="true" data-state="checked" value="simple" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 !w-[14px] !h-[14px]" tabindex="-1" data-radix-collection-item=""></button>
							<span class="text-xs font-medium text-[#6F6963]">간편 결제</span>
						</label>
						<div class="relative !w-[739px]">
							<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 text-primary-foreground hover:bg-primary/90 h-10 absolute top-1/2 -translate-y-1/2 left-0 z-10 bg-transparent rounded-full p-1 border-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left text-[#5E5955]" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg></button>
							<div id="card-scroll-container" class="flex gap-4 overflow-x-auto pb-2 scroll-smooth mx-8 w-[654px]">
								<div class="w-[240px] h-[140px] !min-w-[240px] !max-w-[240px] p-6 rounded bg-black text-white text-sm flex flex-col justify-between">
									<div class="flex justify-between items-start w-full">
										<div class="flex items-center gap-2">
											<div class="text-[15px] font-bold leading-none">현대카드</div>
										</div>
										<button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer h-4 w-4 shrink-0 rounded-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground border-2 border-white" id="현대카드"></button>
									</div>
									<div class="text-xs font-normal ml-auto">네이버 현대카드(1232)</div>
								</div>
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
						<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-start gap-3 cursor-pointer space-y-4">
							<button type="button" role="radio" aria-checked="false" data-state="unchecked" value="normal" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 !w-[14px] !h-[14px]" tabindex="-1" data-radix-collection-item=""></button>
							<span class="text-xs font-medium text-[#6F6963]">일반 결제</span>
						</label>
						<div dir="ltr" class="grid grid-cols-2 gap-4 text-sm w-[739px]" tabindex="0" style="outline: none;">
							<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[46px] border rounded py-[12px] px-[24px] text-center text-[#322A24] cursor-pointer text-sm w-[357px] [h-46px] font-normal !border-[#E9E6E0]">
								<button type="button" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" onclick="$('#buymethod_type').val('C');"></button>신용/체크카드
							</label>
							<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[46px] border rounded py-[12px] px-[24px] text-center text-[#322A24] cursor-pointer text-sm w-[357px] [h-46px] font-normal !border-[#E9E6E0]">
								<button type="button" role="radio" aria-checked="false" data-state="unchecked" value="toss" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""></button>토스 퀵 계좌이체
							</label>
							<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[46px] border rounded py-[12px] px-[24px] text-center text-[#322A24] cursor-pointer text-sm w-[357px] [h-46px] font-normal !border-[#E9E6E0]">
								<button type="button" role="radio" aria-checked="false" data-state="unchecked" value="naver" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""></button>네이버페이
							</label>
							<label class="peer-disabled:cursor-not-allowed peer-disabled:opacity-70 h-[46px] border rounded py-[12px] px-[24px] text-center text-[#322A24] cursor-pointer text-sm w-[357px] [h-46px] font-normal !border-[#E9E6E0]">
								<button type="button" role="radio" aria-checked="false" data-state="unchecked" value="bank" class="aspect-square h-4 w-4 rounded-full border border-primary text-primary ring-offset-background focus:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 hidden" tabindex="-1" data-radix-collection-item=""></button>무통장 입금
							</label>
						</div>
					</div>
				</div>
				<div class="space-y-2 text-xs text-gray-700 h-[68px]">
					<div class="space-y-2 w-full bg-[#322A2408]">
						<div class="text-xs text-[#6F6963] p-4 px-5">
							<ul class="list-disc space-y-1.5 px-4 font-medium text-[10px] undefined">
								<li>무통장 입금은 영업일 기준 24시간 이내 확인됩니다.</li>
								<li>주문 후 72시간 이내에 미입금 시 자동 취소됩니다.</li>
							</ul>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="hidden md:block">
			<div class="sticky top-15">
				<aside class="space-y-6">
					<div class="bg-[#FDFBF5] rounded-md text-sm text-gray-600 space-y-2">
						<h2 class="font-bold text-[#322A24] text-sm">최종 결제 금액</h2>
						<div class="w-[357px] h-[224px] border rounded-md p-6 space-y-3 shadow-md text-[#6F6963] text-xs">
							<div class="flex justify-between">
								<span class="text-[#C0BCB6]">상품금액</span>
								<span><?php echo $TPL_VAR["basket"]["totalgaccount"]?>원</span>
							</div>
							<div class="flex justify-between">
								<span class="text-[#C0BCB6]">배송비</span>
								<span><?php echo $TPL_VAR["basket"]["delaccount"]?>원</span>
							</div>
							<div class="flex justify-between">
								<span class="text-[#C0BCB6]">쿠폰 할인</span>
								<span>0원</span>
							</div>
							<div class="flex justify-between">
								<span class="text-[#C0BCB6]">포인트 사용</span><span>0원</span>
							</div>
							<hr class="my-2 border-dashed">
							<div class="flex justify-between font-semibold text-[#322A24]">
								<span>결제 금액</span>
								<span class="text-base"><?php echo $TPL_VAR["basket"]["totalaccount"]?>원</span>
							</div>
							<div class="hidden flex justify-between ml-2">
								<span class="text-[#C0BCB6]">└ <!-- -->신용카드<!-- --> (현대카드)</span>
								<span>45,000원</span>
							</div>
						</div>
					</div>
					<div class="flex justify-between text-sm font-bold text-[#111111]">
						<span class="text-[#322A24]">적립 예정 포인트</span>
						<span>+0</span>
					</div>
					<div class="bg-[#322A2408] p-[16px] text-xs text-[#6F6963] h-[56px] rounded flex items-center">
						<div class="flex items-center gap-3">
							<div class="w-[16px] h-[16px] flex items-center justify-center rounded-full border !border-[#322A241A] text-[#C0BCB6] text-[10px] bg-[#FDFBF5]">!</div>
							<span class="text-[#6F6963] text-[10px] font-medium">구매 확정 시 회원 등급별 혜택에 따라 포인트가 지급됩니다.</span>
						</div>
					</div>
					<div class="flex justify-end font-bold text-[#322A24] items-center">
						<span class="text-xs mr-3">합계</span>
						<span class="text-lg"><?php echo $TPL_VAR["basket"]["totalaccount"]?>원</span>
					</div>
					<div class="space-y-4 text-xs border-t pt-4 mb-20 text-[#6F6963]">
						<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-center gap-4">
							<button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-4 h-4 data-[state=checked]:bg-gray-600 data-[state=checked]:text-white"></button>
							<span class="font-bold text-xs">주문 내용을 확인했으며, 아래 내용에 모두 동의합니다.</span>
						</label>
						<hr class="border-dashed">
						<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-center gap-4">
							<div class="flex items-center gap-4">
								<button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-4 h-4 data-[state=checked]:bg-gray-600 data-[state=checked]:text-white"></button>
								<span class="text-xs">(필수)<!-- --> <strong class="text-xs">개인정보 수집 • 이용 동의</strong></span>
							</div>
							<a target="_blank" rel="noopener noreferrer" href="/terms">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4 text-gray-500" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
							</a>
						</label>
						<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-center gap-4">
							<div class="flex items-center gap-4">
								<button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-4 h-4 data-[state=checked]:bg-gray-600 data-[state=checked]:text-white"></button>
								
								<span class="text-xs">(필수)<!-- --> <strong class="text-xs">개인정보 제3자 정보 제공 동의</strong></span>
							</div>
							<a target="_blank" rel="noopener noreferrer" href="/terms/privacy">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4 text-gray-500" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
							</a>
						</label>
						<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 flex items-center gap-4">
							<div class="flex items-center gap-4">
								<button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" class="peer shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-4 h-4 data-[state=checked]:bg-gray-600 data-[state=checked]:text-white"></button>
								<span class="text-xs">(필수)<!-- --> <strong class="text-xs">결제대행 서비스 이용약관 동의</strong></span>
							</div>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4 text-gray-500" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
						</label>
					</div>
					<button type="button"  onclick="ordergo(this);" data-msg="<?php echo trscode('ORDER11')?>" id="f_buy"  class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-primary/90 px-4 w-full h-[46px] bg-[#322A24] text-white py-3 rounded-none text-sm font-bold">결제하기</button>
				</aside>
			</div>
		</div>
		
	</div>
	<?php echo $TPL_VAR["basket"]["formend"]?>

</main>
<?php $this->print_("down",$TPL_SCP,1);?>