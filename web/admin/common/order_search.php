<script>
function set_all()	{

	var checkObj = $(".showdan");

	for(var i=0;i<checkObj.length;i++)	{
		if(checkObj.eq(i).prop("checked")==true)	{
			checkObj.eq(i).prop("checked",false);	
		}
	}
}
function set_alls()	{
	var k = 0;
	var checkObj = $(".showdan");

	for(var i=0;i<checkObj.length;i++)	{
		if(checkObj.eq(i).prop("checked")==true)	{
			k = k + 1;	
		}
	}
	if(k!='0')	{
		$("#danall").prop("checked",false);	
	}
	else	{
		$("#danall").prop("checked",true);	
	}
}
</script>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 주문검색</h3>
			</div>
			<div class="panel-content">
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>

				<tr>
					<th>주문처</th>
					<td>
						<select name='fid' id="fid" onchange="set_pids();">
						<option value=''>전체보기</option>
						<?php
						$q = "select * from shop_sites";
						$q = $q ." order by idx asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							if(in_array($row['idx'],$ar_mempriv))	{
								if($row['idx']==$fid)	{	
									echo "<option value='$row[idx]' selected>$row[sitename]</option>";	
								}
								else	{
									echo "<option value='$row[idx]'>$row[sitename]</option>";	
								}
							}
						}
						?>
						</select>

						<select class="uch" name='spid' id="pid">
						<option value=''>전체</option>	
						<?
						if($fid)
						{
							$q = "Select * from shop_config where fid='$fid' order by idx asc";
							$st = $pdo->prepare($q);
						$st->execute();
							while($row = $st->fetch())
							{	
								if($spid==$row['idx'])
								{	echo "<option value='$row[idx]' selected>$row[site_name]</option>";		}
								else
								{	echo "<option value='$row[idx]'>$row[site_name]</option>";		}
							}
						}
						?>
						</select>
					</td>
					<th>거래처</th>
					<td>
						<select  class="uch" name='se_in_idx'>
						<option value=''>거래처전체</option>
						<?php
						$q = "SELECT * FROM shop_goods_shops";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{

							if($row['idx']==$se_in_idx)	{
								echo "<option value='$row[idx]' selected>$row[name]</option>";	
							}
							else	{
								echo "<option value='$row[idx]'>$row[name]</option>";	
							}
						}
						?>
						</select> 
						
					</td>
				</tr>
				<tr>
					<th>진행단계</th>
					<td colspan='3'>
						<label><input type='radio' name='danall' id='danall' value='Y' <? if($danall=='Y') { echo "checked";	}?> onclick="set_all();">전체</label>

						<label><input type='checkbox' name='showdan[]' class="showdan" value='1' onclick="set_alls();" <? if(is_array($showdan)){if(in_array('1',$showdan)) { echo "checked";	}}?>>주문접수</label>
						<label><input type='checkbox' name='showdan[]' class="showdan" value='2' onclick="set_alls();" <? if(is_array($showdan)){if(in_array('2',$showdan)) { echo "checked";	}}?>>결제확인</label>
						<label><input type='checkbox' name='showdan[]' class="showdan" value='3' onclick="set_alls();" <? if(is_array($showdan)){if(in_array('3',$showdan)) { echo "checked";	}}?>>상품준비중</label>
						<label><input type='checkbox' name='showdan[]' class="showdan" value='4' onclick="set_alls();" <? if(is_array($showdan)){if(in_array('4',$showdan)) { echo "checked";	}}?>>부분배송</label>
						<label><input type='checkbox' name='showdan[]' class="showdan" value='5' onclick="set_alls();" <? if(is_array($showdan)){if(in_array('5',$showdan)) { echo "checked";	}}?>>배송중</label>
						<label><input type='checkbox' name='showdan[]' class="showdan" value='6' onclick="set_alls();" <? if(is_array($showdan)){if(in_array('6',$showdan)) { echo "checked";	}}?>>거래완료</label>
						<label><input type='checkbox' name='showdan[]' class="showdan" value='8' onclick="set_alls();" <? if(is_array($showdan)){if(in_array('8',$showdan)) { echo "checked";	}}?>>주문취소</label>
					</td>
				</tr>
				<tr>
					<th>검색조건</th>
					<td>
						<div class="form-inline">
						<select class="uch" name='skey'>
		<option value='name' <? if($skey=='name') { echo "selected"; } ?>>주문자명</option>
		<option value='mem_id' <? if($skey=='mem_id') { echo "selected"; } ?>>주문자아이디</option>
		<option value='idx' <? if($skey=='idx') { echo "selected"; } ?>>주문번호</option>
		<option value='outorderno' <? if($skey=='outorderno') { echo "selected"; } ?>>외부몰주문번호</option>
		<option value='last_orders' <? if($skey=='last_orders') { echo "selected"; } ?>>구주문번호</option>
		<option value='del_name' <? if($skey=='del_name') { echo "selected"; } ?>>수취인</option>
		<option value='cp' <? if($skey=='cp') { echo "selected"; } ?>>주문자핸드폰</option>
		<option value='del_cp' <? if($skey=='del_cp') { echo "selected"; } ?>>수취인핸드폰</option>
		<option value='inname' <? if($skey=='inname') { echo "selected"; } ?>>입금자명</option>
		<option value='gname' <? if($skey=='gname') { echo "selected"; } ?>>주문상품</option>
		<option value='goods_idx' <? if($skey=='goods_idx') { echo "selected"; } ?>>상품번호</option>
		<option value='gcode' <? if($skey=='gcode') { echo "selected"; } ?>>상품코드</option>
	</select>
	<input type='text' name='skeyword' value="<?=$skeyword;?>" class="form-control" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }" >
						</div>
					</td>
					<th>배송메모</th>
					<td>
						<label><input type='checkbox' name='havememo' value='Y' <? if($havememo=='Y') { echo "checked";	}?>>배송메세지 존재건 검색</label>
					</td>
				</tr>
				<tr>
					<th>결제수단</th>
					<td>	
						<select name='sbuym'>
<option value=''>전체</option>
<?
$q = "select * from shop_config_pay where 1";
$st = $pdo->prepare($q);
						$st->execute();
while($row = $st->fetch())
{
	if($row['buymethod']==$sbuym)
	{	echo "<option value='$row[buymethod]' selected>".$g_ar_method[$row['buymethod']]."</option>";	}
	else
	{	echo "<option value='$row[buymethod]'>".$g_ar_method[$row['buymethod']]."</option>";	}
}
?>
</select>
					</td>
					<th>회원여부</th>
					<td>	
						<select name='ismem'>
<option value=''>선택하세요</option>
<option value='Y' <? if($ismem=='Y') { echo "selected";	}?>>회원</option>
<option value='N' <? if($ismem=='N') { echo "selected";	}?>>비회원</option>
</select>
					</td>
				</tr>
				<tr>
					<th><select class="uch" name='datekey'>
		<option value='odate' <? if($datekey=='odate') { echo "selected";	}?>>주문일</option>
		<option value='incdate' <? if($datekey=='incdate') { echo "selected";	}?>>입금확인일</option>
		</select></th>
					<td>	
						<div class="form-inline">
						<input type='text' name='sdate' value='<?=$sdate;?>' readonly id='se_sdate' class="form-control"> ~ <input type='text' name='edate' value='<?=$edate;?>' id='se_edate' readonly class="form-control">
						</div>
					</td>
					<th>노출갯수</th>
					<td>	
						<select class="uch" name='se_numper'>
					<?php
					for($i=20;$i<=100;$i=$i+10)	{
					?>
					<option value='<?=$i;?>' <? if($numper==$i){ echo "selected";	}?>><?=$i;?></option>
					<?php
					}
					?>
					</select>
					</td>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						<?
						if($code=='order_list')	{?>
						<button class="btn btn-primary waves-effect waves-light" type="button" onclick="location.href='./excel/excel_down.php?act=order';">엑셀다운로드</button>
						<?}?>
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