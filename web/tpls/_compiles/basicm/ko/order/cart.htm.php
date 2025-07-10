<?php /* Template_ 2.2.7 2025/07/08 17:45:28 /home/grandhand/BUILDS/tpls/basicm/order/cart.htm 000009668 */ 
$TPL_cartlist_1=empty($TPL_VAR["cartlist"])||!is_array($TPL_VAR["cartlist"])?0:count($TPL_VAR["cartlist"]);?>
<?php $this->print_("header",$TPL_SCP,1);?>

<Script>
$(document).ready(function()	{
	$("#allCheck1").on("click",function()	{
		if($(this).is(":checked"))	{
			$("input[type=checkbox]").prop('checked', true).val('y');
			$label = $("input[type=checkbox]").siblings('label');
			$label.addClass('on');
			makeaccount();
		}
		else	{
			$("input[type=checkbox]").prop('checked', false).val('n');
			$label = $("input[type=checkbox]").siblings('label');
			$label.removeClass('on');
			makeaccount();
		}
		
	});
	
	$(".cartindex").on("click",function()	{
		makeaccount();	
	});
	
});
function makeaccount()	{
	
	var totalac = 0;
	var totalc = 0;
	$(".glists").each(function()	{
		if($(this).find(".cartindex").is(":checked"))	{
			totalac = parseInt(totalac) + ( parseInt($(this).data("account")) * parseInt( $(this).find("input[name=ea]").val() ) );
			totalc = totalc + 1;
		}
		
		var nowac = parseInt($(this).data("account") )* parseInt( $(this).find("input[name=ea]").val() ) ;
		console.log(nowac);
		
	});
	console.log(totalac);
	
<?php if($TPL_VAR["global"]["memislogin"]=='Y'){?>
	if(totalac<<?php echo $TPL_VAR["global"]["delaccount_member_std"]?> && totalac>0)	{
		totalac = totalac + <?php echo $TPL_VAR["global"]["delaccount_member"]?>;
		$("#id_tdac").html(setComma(<?php echo $TPL_VAR["global"]["delaccount_member"]?>));
	}
	else	{
		$("#id_tdac").html(setComma(0));
	}
<?php }else{?>
	if(totalac<<?php echo $TPL_VAR["global"]["delaccount_nomember_std"]?> && totalac>0)	{
		totalac = totalac + <?php echo $TPL_VAR["global"]["delaccount_nomember"]?>;
		$("#id_tdac").html(setComma(<?php echo $TPL_VAR["global"]["delaccount_nomember"]?>));
	}
	else	{
		$("#id_tdac").html(setComma(0));
	}
<?php }?>
	$("#f_totalc").html(totalc);
	$("#id_tac").html(setComma(totalac)+"원");
	
	if(totalc==0)	{
		$("#f_buy").prop('disabled', true);
	}	else	{
		$("#f_buy").prop('disabled', false);
	}
}
function set_ea(m,idx)	{

	var ea = $("#ea"+idx).val();
	if(m=='1')	{
		if(parseInt(ea)-1<=0)	{
			alert('수량은 0이 될수 없습니다');
			return;
		}
		$("#ea"+idx).val( parseInt($("#ea"+idx).val() ) - 1 );
		$("#eastr"+idx).html( parseInt($("#ea"+idx).val() ) );
	}
	else	{
		$("#ea"+idx).val( parseInt($("#ea"+idx).val() ) +1 );
		$("#eastr"+idx).html( parseInt($("#ea"+idx).val() )  );	}

	var param = "ea="+$("#ea"+idx).val()+"&idx="+idx;
	console.log('/exec/proajax.php?act=useraction&han=set_ea&' + param);
	$.getJSON('/exec/proajax.php?act=useraction&han=set_ea&' + param, function(result)	{
		if(result.res=='ok')	{
			makeaccount();	
		}
	});

}
function setComma(n)	{
    var reg = /(^[+-]?\d+)(\d{3})/;   // 정규식
    n += '';                          // 숫자를 문자열로 변환
    while(reg.test(n))
    {
        n = n.replace(reg, '$1' + ',' + '$2');
    }
    return n;
}
function cart_chbuy(obj)	{
    var checkObj = $(".cartindex");
    if(checkObj.length == 0)	{
        alert($(obj).data("msg_empty"));
        return;
    }
    var k = 0;
    var str = '';
    for(var i = 0; i < checkObj.length; i++)	{
        if(checkObj.eq(i).is(":checked"))	{
            k = k + 1;
            str = str + checkObj.eq(i).data("index") + '-';
        }
    }

    if(k == 0)	{
        alert($(obj).data("msg_nocheck"));
        return;
    }

	var answer = confirm($(obj).data("msg_question"));
	if(answer == true)	{
		location.href = '/order/?act=order_step1&basket_idxs=' + str;
	}
	else	{
		return;
	}
}
function delall()	{
	var cou = 0;
	var str = '';
	$(".cartindex").each(function()	{
		if($(this).is(":checked"))	{
			cou++;
			str = str + $(this).data("index") + '|R|';
		}
	});
	
	if(cou==0)	{
		alert('삭제하고자 하는 상품을 체크하세요');
		return;
	}

	answer = confirm('삭제하시겠습니까?');
	if(answer==true)	{
		location.href='/order/?act=cart&mode=del&str='+str;
	}
}
</script>

</head>
<body>
<div id="root">
	<div class="min-h-screen bg-[#FDFBF4]">
		<div class="h-[58px] flex px-6 items-center">
			<a href="#none" onclick="event.preventDefault(); history.back();" class="pr-6"><img src="/img/m/icon_ARROWLEFT_dark.png" /></a>
			<div class="text-[#322A24] text-lg font-bold">장바구니</div>
		</div>
		<div class="h-[54px] flex px-6 items-center justify-between">
			<div class="flex">
				<div class="pr-6">
					<input type="checkbox" id="allCheck1" class="chk-hidden agree-item" checked>
					<label for="allCheck1" class="chk-img"></label>
				</div>
				<div class="text-[#322A24] text-lg font-bold">전체 선택(<span id="f_totalc"><?php echo $TPL_VAR["cart"]["totalcou"]?></span>/<?php echo $TPL_VAR["cart"]["totalcou"]?>)</div>
				
			</div>
			
			<div>
				<a href="#none" onclick="event.preventDefault(); delall();" class="text-[#C0BCB6] text-sm font-bold">상품 삭제</a>
			</div>
		</div>
		<div class=" px-6">
<?php if($TPL_VAR["cart"]["totalcou"]== 0){?>
			<div class="py-20 text-center text-[#C0BCB6] text-sm">
				장바구니에 담긴 상품이 없어요.
			</div>
<?php }else{?>
<?php if($TPL_cartlist_1){$TPL_I1=-1;foreach($TPL_VAR["cartlist"] as $TPL_V1){$TPL_I1++;?>	
				<div class="flex pb-8 items-start glists" data-account="<?php echo $TPL_V1["account_pure"]?>">
					<div class="pr-6">
						<input type="checkbox" id="check<?php echo $TPL_I1?>" data-index="<?php echo $TPL_V1["idx"]?>" class="cartindex chk-hidden agree-item" checked value='<?php echo $TPL_V1["idx"]?>' data-goods_idx="<?php echo $TPL_V1["goods_idx"]?>">
						<label for="check<?php echo $TPL_I1?>" class="chk-img"></label>
					</div>
					<div style="flex:1">
						<div class="flex">
							<div class="pr-4"><a href="/shop/?act=view&idx=<?php echo $TPL_V1["goods_idx"]?>"><img src="<?php echo $TPL_VAR["global"]["imgdomain"]?>/goods/<?php echo $TPL_V1["simg1"]?>" style="width:72px;"></a></div>
							<div class="flex flex-col justify-between" style="flex:1"> 
								<div>
									<a href="/shop/?act=view&idx=<?php echo $TPL_V1["goods_idx"]?>" class="text-[#000000] text-xs font-medium"><?php echo $TPL_V1["gname"]?></a>
									<div class="text-[#322A24] text-sm font-bold"><?php echo $TPL_VAR["curr"]["showdan1"]?><?php echo $TPL_V1["account"]?><?php echo $TPL_VAR["curr"]["showdan2"]?></div>
								</div>
								<div class="flex items-center justify-between">
									<div style="min-width:10px;"></div>
									<div class="flex items-center gap-3">
										<button class="gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-background hover:bg-accent hover:text-accent-foreground h-5 !w-[16px] !h-[16px] flex items-center justify-center border border-[#CFC9BC] rounded-full text-[#C2BDB6] p-0" onclick="set_ea('1',<?php echo $TPL_V1["idx"]?>);">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus !w-[7px] !h-[7px] text-[#5E5955]" aria-hidden="true"><path d="M5 12h14"></path></svg>
										</button>
										<input type='hidden' name='ea' value='<?php echo $TPL_V1["ea"]?>' id="ea<?php echo $TPL_V1["idx"]?>">
										<span class="w-6 text-xs text-center text-[#322A24] font-bold" id="eastr<?php echo $TPL_V1["idx"]?>"><?php echo $TPL_V1["ea"]?></span>
										<button class="gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-background hover:bg-accent hover:text-accent-foreground h-5 !w-[16px] !h-[16px] flex items-center justify-center border border-[#CFC9BC] rounded-full text-[#C2BDB6] p-0" onclick="set_ea('2',<?php echo $TPL_V1["idx"]?>);">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus !w-[7px] !h-[7px] text-[#5E5955]" aria-hidden="true"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
<?php }}?>
<?php }?>
		</div>
		
	</div>
</div>
<div class="fixed px-6" style="bottom:24px;left:0;right:0;border-top:1px solid #E9E6E0">
	<div class="pt-4 pb-6">
		<div class="flex justify-end items-center">
			<div class="text-[#322A24] text-sm font-bold pr-2">합계</div>
			<div class="text-[#322A24] text-lg font-bold" id="id_tac"><?php echo $TPL_VAR["cart"]["totaltaccount"]?>원</div>
		</div>
	</div>
	<button type="button" id="f_buy" class="w-full block h-[46px] text-sm text-[#FFFFFF] font-bold disabled:opacity-15 bg-[#322A24]" onclick="cart_chbuy(this);" data-msg_empty="<?php echo trscode('CART1')?>" data-msg_nocheck="<?php echo trscode('CART2')?>" data-msg_question="<?php echo trscode('CART3')?>">구매하기</button>
</div>
</body>
</html>