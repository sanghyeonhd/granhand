<?
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_goods_shops"," WHERE index_no='$index_no'");
$ar_m = sel_query_all("shop_member"," WHERE index_no='$ar_data[mem_idx]'");
$mode = $_REQUEST['mode'];
if($mode=='w')	{

    $value['group_idx'] = $_REQUEST['group_idx'];
	
	if($value['group_idx']=='A')	{
		$values['gname'] = $_REQUEST['gname'];		
		insert("shop_goods_shops_group",$values);
		$value['group_idx'] = mysqli_insert_id();
		unset($values);
	}
	if($_REQUEST['usepasswd'])	{
		$values['passwd'] = $_REQUEST['usepasswd'];
		update("shop_member",$values," WHERE index_no='$ar_data[mem_idx]'");
		unset($values);
	}
    
	if($ar_data['usescm']=='Y')	{
	   
	    $value['sellmethod'] = $_REQUEST['sellmethod'];
		if($value['sellmethod']=='1')	{
		    $value['sellper'] = $_REQUEST['sellper'];
		}
	}

    $value['cates1'] = $_REQUEST['cates1'];
    $value['cates2'] = $_REQUEST['cates2'];
    $value['daename'] = $_REQUEST['daename'];
    $value['daephone'] = $_REQUEST['daephone'];
    $value['daeemail'] = $_REQUEST['daeemail'];
    $value['damname'] = $_REQUEST['damname'];
    $value['damgrade'] = $_REQUEST['damgrade'];
    $value['phone'] = $_REQUEST['phone'];
    $value['cp'] = $_REQUEST['cp'];
    $value['fax'] = $_REQUEST['fax'];
    $value['email'] = $_REQUEST['email'];
    $value['homepage'] = $_REQUEST['homepage'];
    $value['bank'] = $_REQUEST['bank'];
    $value['bankaccount'] = $_REQUEST['bankaccount'];
    $value['bankname'] = $_REQUEST['bankname'];
    $value['zipcode'] = $_REQUEST['zipcode'];
    $value['addr1'] = $_REQUEST['addr1'];
    $value['addr2'] = $_REQUEST['addr2'];
	$value['memo'] = $_REQUEST['memo'];
	update("shop_goods_shops",$value," WHERE index_no='$index_no'");
	unset($value);


	$value['canconnect'] = $_REQUEST['canconnect'];
	update("shop_member",$value," WHERE index_no='$ar_data[mem_idx]'");
	unset($value);


	show_message("수정완료","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;
}
?>
<script>
function set_useid(obj)	{
	
	if($(obj).children("option:selected").val()=='N')	{
		$("#idinfo").hide();
		$("#sellmethod").hide();
	}
	else	{
		$("#idinfo").show();
		$("#sellmethod").show();
	}
}
function openDaumPostcode()
{
    new daum.Postcode({
        oncomplete: function(data)
        {
            document.getElementById('zipcode').value = data.zonecode;

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


            document.getElementById('addr1').value = fullAddr;
            document.getElementById('addr2').focus();
        }
    }).open();
}
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		
		if($("#group_idx option:selected").val()=='')	{
			alert('거래처 그룹을 지정하세요');
			return false;
		}
		if($("#group_idx option:selected").val()=='A')	{
			if($("#gname").val()=='')	{
				alert('거래처 그룹명을 입력하세요');
				return false;
			}
		}


		answer = confirm('거래처를 수정 하시겠습니까?');
		if(answer==true)	{
			
			return true;
		}
		else	{
			return false;
		}
	}
	else	{
		return false;
	}
}
</script>
<script src='http://dmaps.daum.net/map_js_init/postcode.v2.js'></script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 거래처수정</h3>
			</div>
			<div class="panel-content">
				<form id="wform" name="wform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>승인여부</th>
					<td colspan='3'>
						<select name='canconnect' class="form-control">
						<option value='D' <? if($ar_m['canconnect']=='D') { echo "selected";	}?>>승인대기</option>
						<option value='Y' <? if($ar_m['canconnect']=='Y') { echo "selected";	}?>>승인완료</option>
						</select>
					</td>
					
				</tr>
				<tr>
					<th>거래처그룹</th>
					<td>
						<div class="form-inline">
						<select class="uch" name='group_idx' id='group_idx'>
						<option value=''>그룹선택</option>					
						<option value='A'>직접입력</option>
						<?
						$q = "SELECT * FROM shop_goods_shops_group ORDER BY gname asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() ){
							$se = "";
							if($row['index_no']==$ar_data['group_idx'])	{
								$se = "Selected";
							}
								
							echo "<option value='$row[index_no]' $se>$row[gname]</option>";
						}
						?>
						</select>
						직접입력 : <input type='text' name='gname' id='gname' class="form-control">
						</div>
					</td>
					

					<th>SCM이용여부</th>
					<td>
						<? if($ar_data['usescm']=='Y') { echo "사용";	} else { echo "사용안함";	}?>
					</td>
					
				</tr>
				<? if($ar_data['usescm']=='Y') {?>
				<tr>
					<th>아이디</th>
					<td colspan='3'>
						<?php
						$ar_ms = sel_query_all("shop_member"," WHERE index_no='$ar_data[mem_idx]'");
						echo $ar_ms['id'];
						?>
					</td>
					
				</tr>
				<tr>
					<th>정산방식</th>
					<td colspan='3'>
						<div class="form-inline">
						<select name='sellmethod' id='sellmethod'>
						<option value=''>정산방식선택</option>
						<option value='1' <? if($ar_data['sellmethod']=='1') { echo "selected";	}?>>판매금액의수수료</option>
						<option value='2' <? if($ar_data['sellmethod']=='1') { echo "selected";	}?>>공급가액으로지급</option>
						</select> 판매수수료 : <input type='text' name='sellper' id='sellper' class="form-control" value="<?=$ar_data['sellper'];?>">%
						</div>
					</td>
				</tr>
				<?}?>
				<tr>
					<th>업체명</th>
					<td>
						<?=$ar_data['name'];?>
					</td>
					

					<th>사업자등록번호</th>
					<td>
						<input type='text' name='businessnum' class="form-control" value='<?=$ar_data['businessnum'];?>'>
					</td>
				</tr>
				<tr>
					<th>업종</th>
					<td>
						<input type='text' name='cates1' class="form-control" value='<?=$ar_data['cates1'];?>'>
					</td>
					

					<th>업태</th>
					<td>
						<input type='text' name='cates2' class="form-control" value='<?=$ar_data['cates2'];?>'>
					</td>
				</tr>
				<tr>
					<th>대표자명</th>
					<td colspan='3'>
						<input type='text' name='daename' class="form-control" value='<?=$ar_data['daename'];?>'>
					</td>

				</tr>
				<tr>
					<th>대표자연락처</th>
					<td>
						<input type='text' name='daephone' class="form-control" value='<?=$ar_data['daephone'];?>'>
					</td>
					

					<th>대표자E-MAIL</th>
					<td>
						<input type='text' name='daeemail' class="form-control" value='<?=$ar_data['daeemail'];?>'>
					</td>
				</tr>
				<tr>
					<th>담당자명</th>
					<td>
						<input type='text' name='damname' class="form-control" value='<?=$ar_data['damname'];?>'>
					</td>
					

					<th>담당자직위</th>
					<td>
						<input type='text' name='damgrade' class="form-control" value='<?=$ar_data['damgrade'];?>'>
					</td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td>
						<input type='text' name='phone' class="form-control" value='<?=$ar_data['phone'];?>'>
					</td>
					

					<th>핸드폰</th>
					<td>
						<input type='text' name='cp' class="form-control" value='<?=$ar_data['cp'];?>'>
					</td>
				</tr>
				<tr>
					<th>FAX</th>
					<td>
						<input type='text' name='fax' class="form-control" value='<?=$ar_data['fax'];?>'>
					</td>
					

					<th>E-MAIL</th>
					<td>
						<input type='text' name='email' class="form-control" value='<?=$ar_data['email'];?>'>
					</td>
				</tr>
				<tr>
					<th>HOMEPAGE</th>
					<td colspan='3'>
						<input type='text' name='homepage' class="form-control" value='<?=$ar_data['homepage'];?>'>
					</td>

				</tr>

				<tr>
					<th>계좌정보</th>
					<td colspan='3'>
						<div class="form-inline">
						은행 : <input type='text' name='bank' class="form-control" value='<?=$ar_data['bank'];?>'> / 계좌번호 : <input type='text' name='bankaccount' class="form-control" value='<?=$ar_data['bankaccount'];?>'> / 예금주 : <input type='text' name='bankname' class="form-control" value='<?=$ar_data['bankname'];?>'>
						</div>
					</td>
				</tr>
				
				<tr>
					<th>우편번호</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' name='zipcode' id="zipcode" class="form-control" readonly onclick="openDaumPostcode()" value='<?=$ar_data['zipcode'];?>'>
						</div>
					</td>
				</tr>
				<tr>
					<th>주소</th>
					<td>
						<input type='text' name='addr1' id="addr1" class="form-control" value='<?=$ar_data['addr1'];?>'>
					</td>
					

					<th>상세주소</th>
					<td>
						<input type='text' name='addr2' id="addr2" class="form-control" value='<?=$ar_data['addr2'];?>'>
					</td>
				</tr>
				<tr>
					<th>거래처메모</th>
					<td colspan='3'>
						<textarea name='memo' class="form-control"><?=$ar_data['memo'];?></textarea>
					</td>
					
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#wform">수정하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
