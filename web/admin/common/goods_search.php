<Script>
$(document).ready(function()	{
	
	$("#id_cate1").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate2");
		}
	});
	$("#id_cate2").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate3");
		}
	});
	$("#id_cate3").on("change",function()	{
		if($(this).val()!='')	{
			get_cate($(this).val(),"id_cate4");
		}
	});

});

function search_seasonall()	{	
	
	if($("#se_seasonall").is(":checked"))	{
		$(".se_season").prop("checked",false);	
	}

}
function search_cate()	{

	var text = '';
	var cate = '';
	var thishtml = '';
	var isok = "Y";

	for(var i=1;i<5;i++)	{
		if($("#id_cate"+i+" option:selected").val()!='')	{
			isgo = "Y";
			if(text!='')	{
				text = text + " > ";
			}
			text = text + $("#id_cate"+i+" option:selected").text();
			cate = $("#id_cate"+i+" option:selected").val();
		}
	}
	
	if(isgo=='Y')	{
		$("#search_menu > span").each(function()	{

			if($(this).attr("dataattr")==cate)	{
				isok = "N";
			}
		});

		if(isok=='Y')	{
			
			thishtml = "<span dataattr='"+cate+"' style='margin:2px 0;padding:5px;font-size:14px;display:block;' >"+text+" <a href='#none' style='color:red' onclick='set_objdel(this)'>X</a></span>";
			$("#search_menu").append(thishtml);
		}
		else	{
			alert('이미 추가한 카테고리 입니다.');
			return;
		}
	}

}
function set_objdel(obj)	{
	$(obj).parent().remove();
}
function goods_search()	{
	var catestr = '';
	$("#search_menu > span").each(function()	{
		
		catestr = catestr + $(this).attr("dataattr") + '|R|';
		
	});
	$("#se_catestr").val(catestr);
}
function get_cate(upcate,target)	{
	console.log("/exec/proajax.php?act=cate&han=get_cate&upcate="+upcate)
	$.getJSON("/exec/proajax.php?act=cate&han=get_cate&upcate="+upcate,function(results)	{
		if(results.res=='ok')	{
			var str = "<option value=''>선택하세요</option>";
			$(results.datas).each(function(index,item)	{
				str = str + "<option value='"+item.catecode+"'>"+item.catename+"</option>";
			});
			$("#"+target).html(str);
			
		}
	});
}
</script>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품검색 </h3>
			</div>
			<div class="panel-content">
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return goods_search();">
				<input type='hidden' name='se_catestr' id="se_catestr" value="<?=$se_catestr;?>">
				<input type='hidden' name='hanmode' value='<?=$hanmode;?>'>
				<input type='hidden' name='namefi' value='<?=$namefi;?>'>
				<input type='hidden' name='idxfi' value='<?=$idxfi;?>'>
				<input type='hidden' name='main_idx' value="<?=$main_idx;?>">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>상품코드</th>
					<td colspan='3'>
						<textarea name='se_gcode' class="form-control"><? echo $se_gcode;?></textarea>
					</td>
				</tr>
				<tr>
					<th rowspan='2'>소속카테고리</th>
					<td colspan='3'>
						<select class="uch" name='cate1' id='id_cate1'>
						<option value=''>선택하세요</option>
						<?php
						$q = "select * from shop_cate where upcate='' order by catecode";	
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							echo "<option value='$row[catecode]'>$row[catename]</option>";	
						}
						?>
						</select>
						<select class="uch" name='cate2' id='id_cate2'>
						<option value=''>선택하세요</option>
						</select>
						<select class="uch" name='cate3' id='id_cate3'>
						<option value=''>선택하세요</option>
						</select>
						<select class="uch" name='cate4' id='id_cate4'>
						<option value=''>선택하세요</option>
						</select>
						<a href="#none" onclick="event.preventDefault(); search_cate();" class="btn btn-primary">검색조건추가</a>
					</td>
				</tr>
				<Tr>
					<td colspan='3' id="search_menu">
						<?
						if(isset($ar_catestr))	{
							for($i=0;$i<sizeof($ar_catestr);$i++)	{
								if($ar_catestr[$i]!='')	{
									$ar_cate = sel_query_all("shop_cate"," where catecode='$ar_catestr[$i]'");
						
						?>
						<span dataattr='<?=$ar_catestr[$i];?>' style='margin:2px 0;padding:5px;font-size:14px;display:block;' ><?=$ar_cate['catename'];?> <a href='#none' style='color:red' onclick='set_objdel(this)'>X</a></span>
						<?
								}
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<th>판매여부</th>
					<td>
						<label><input type='radio' name='se_isopen' value='' <? if(!$se_isopen) { echo "checked";	}?>> 전체</label>
<?php
foreach($g_ar_isdan AS $key => $val)	{
?>
						<label><input type='radio' name='se_isopen' value='<?php echo $key;?>' <?php if($se_isopen==$key) { echo "checked";	}?>> <?php echo $val;?></label>
<?php
}
?>
					</td>
					<th>진열여부</th>
					<td>
						<label><input type='radio' name='se_isshow' value='' <? if(!$se_isshow) { echo "checked";	}?>> 전체</label>
<?php
foreach($g_ar_isshow AS $key => $val)	{
?>
						<label><input type='radio' name='se_isshow' value='<?php echo $key;?>' <?php if($se_isshow==$key) { echo "checked";	}?>> <?php echo $val;?></label>
<?php
}
?>
					</td>
				</tr>
				<tr>
					<th>판매가격</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='se_account1' value='<?=$se_account1;?>'> ~ <input type='text' class="form-control" name='se_account2' value='<?=$se_account2;?>'>
						</div>
					</td>
				</tr>
				
				<tr>
					<th rowspan='2'>상품분류</th>
					<td colspan='3'>
						<select class="uch" name='se_itemcate' id='se_itemcate' onchange="search_itemcate();">
						<option value=''>소속메뉴</option>
						
						</select>
					</td>
				</tr>
				<tr>
					<td id="search_buns" colspan='3'>
					
					</td >
				</tR>
				<tr>
					<th>
						<select name='se_datekey'>
						<option value='opendate' <? if($se_datekey=='opendate') { echo "selected";	}?>>판매시작일</option>
						<option value='regi_date' <? if($se_datekey=='regi_date') { echo "selected";	}?>>상품등록일</option>
						</select>
					</th>
					<td  colspan='3'>
						<div class="form-inline">
							<input type='text' class="form-control" name='se_sdate' id='se_sdate' value='<?=$se_sdate;?>'> ~ <input type='text' class="form-control" name='se_edate' id='se_edate' value='<?=$se_edate;?>'>
						</div>
					</td>
				</tr>
				<tr>
					<th>기타</th>
					<td>
						<div class="form-inline">
						<select  class="form-control" name='se_md_idx'>
						<option value=''>MD</option>
						<?php
						$q = "SELECT distinct(md_idx) AS md_idx FROM shop_goods";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							
						}
						?>
						</select> 
						<select class="form-control" name='se_key'>
						<option value='gname' <? if($se_key=='gname') { echo "selected"; } ?>>상품명</option>
						<option value='gcode' <? if($se_key=='gcode') { echo "selected"; } ?>>상품코드(모델명)</option>
						<option value='gdname' <? if($se_key=='gdname') { echo "selected"; } ?>>사입명</option>
						<option value='barcode' <? if($se_key=='barcode') { echo "selected"; } ?>>바코드</option>
						<option value='admin_memo' <? if($se_key=='admin_memo') { echo "selected"; } ?>>관리자메모</option>
						<option value='search_keyword' <? if($se_key=='search_keyword') { echo "selected"; } ?>>검색키워드</option>
						</select>
						<input type='text' class="form-control" name='se_keyword' size='20' value="<?=$se_keyword;?>" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }">
						</div>
					</td>
					<th>거래처</th>
					<td>
						<select  class="form-control" name='se_in_idx'>
						<option value=''>거래처전체</option>
						<?php
						$q = "SELECT * FROM shop_goods_shops";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{

							if($row['index_no']==$se_in_idx)	{
								echo "<option value='$row[index_no]' selected>$row[name]</option>";	
							}
							else	{
								echo "<option value='$row[index_no]'>$row[name]</option>";	
							}
						}
						?>
						</select> 
						
					</td>
				</tr>
				
				<tr>
					<th>노출갯수</th>
					<td><select class="form-control" name='se_numper'>
					<?php
					for($i=20;$i<=100;$i=$i+10)	{
					?>
					<option value='<?=$i;?>' <? if($se_numper==$i) { echo "selected";	}?>><?=$i;?></option>
					<?php
					}
					?>
					</select>
					</td>
					<th>정렬순서</th>
						<td>
						<div class="form-inline">
						<select class="form-control" name='sortcol'>
						<option value='index_no' <? if($sortcol=='index_no') { echo "selected";	}?>>상품등록일</option>
						<option value='moddate' <? if($sortcol=='moddate') { echo "selected";		}?>>상품수정일</option>
						<option value='opendate' <? if($sortcol=='opendate') { echo "selected";	}?>>판매시작일</option>
						<option value='account' <? if($sortcol=='account') { echo "selected";	}?>>판매가</option>
						<option value='count_read' <? if($sortcol=='count_read') { echo "selected";	}?>>조회수</option>
						<option value='count_order' <? if($sortcol=='count_order') { echo "selected";	}?>>주문수</option>
						<option value='count_cart' <? if($sortcol=='count_cart') { echo "selected";	}?>>담기수</option>
						<option value='count_wish' <? if($sortcol=='count_wish') { echo "selected";	}?>>관심수</option>
						<option value='count_qna' <? if($sortcol=='count_qna') { echo "selected";	}?>>문의수</option>
						</select> 
						<select class="form-control" name='sortby'>
						<option value='asc' <? if($sortby=='asc') { echo "selected";	}?>>오름차순</option>
						<option value='desc' <? if($sortby=='desc') { echo "selected";	}?>>내림차순</option>
						</select>
						</div>
					</td>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						<button class="btn btn-primary waves-effect waves-light" type="button" onclick="location.href='./excel/excel_down.php?act=goods';">엑셀다운로드</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#se_sdate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#se_edate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>