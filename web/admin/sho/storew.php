<?php
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	foreach($_REQUEST AS $key => $val)	{
		
		if(!is_array($_REQUEST[$key]))	{

			$_REQUEST[$key] = addslashes(trim($val));
		}
	}
	$lcode1 = $_REQUEST['lcode1'];
	$lcode2 = $_REQUEST['lcode2'];
	
	$value['loca_idx1'] = $_REQUEST['loca_idx1'];
	$value['loca_idx2'] = $_REQUEST['loca_idx2'];
	$value['name'] = $_REQUEST['name'];
	$value['zipcode'] = $_REQUEST['zipcode'];
	$value['addr1'] = $_REQUEST['addr1'];
	$value['addr2'] = $_REQUEST['addr2'];
	$value['phone'] = $_REQUEST['phone'];
	$value['fax'] = $_REQUEST['fax'];
	$value['email'] = $_REQUEST['email'];
	$value['etc_info'] = $_REQUEST['etc_info'];
	$value['mdate'] = date("Y-m-d H:i:s");
	$value['isshow'] = $_REQUEST['isshow'];
	$value['wdate'] = date("Y-m-d H:i:s");
	$value['lcode1'] = $lcode1;
	$value['lcode2'] = $lcode2;
	$value['isnew'] = $_REQUEST['isnew'];
	$value['up_idx'] = 0;
	$value['deliver'] = $_REQUEST['deliver'];
	if($value['deliver']=='Y')	{
		$value['delivermae'] = "Y";
	}	else	{
		$value['delivermae'] = "N";
	}
	$value['deliverac'] = $_REQUEST['deliverac']*100;

	$value['companyname'] = $_REQUEST['companyname'];
	$value['businessnum'] = $_REQUEST['businessnum'];
	$value['job1'] = $_REQUEST['job1'];
	$value['job2'] = $_REQUEST['job2'];
	$value['daename'] = $_REQUEST['daename'];
	$value['bphone'] = $_REQUEST['bphone'];
	$value['bemail'] = $_REQUEST['bemail'];


	$value['lcode1'] = $_REQUEST['lcode1'];
	$value['lcode2'] = $_REQUEST['lcode2'];

	$value['giveper'] = $_REQUEST['giveper'];
	
	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);

	$savedir = $_uppath."store/";
		
	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);
	}
	$value['img'] = $fs[0];
	insert("shop_intro_store",$value);
	unset($value);
	

	show_message("저정되었습니다.","");
	move_link("$PHP_SELF?code=sho_store");
	exit;
}
?>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=mg73rj4ce7&submodules=drawing,geocoder"></script>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('저장하시겠습니까?');
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
$(document).ready(function()	{
	
	$("#loca_idx1").on("change",function()	{
		if($(this).val()!='')	{
			$.getJSON("/exec/proajax?act=config&han=get_loca&up_idx="+$(this).val(),function(results)	{
				if(results.res=='ok')	{
					var str = "<option value=''>지역선택</option>";
					$(results.datas).each(function(index,item)	{
						str = str + "<option value='"+item.index_no+"'>"+item.name+"</option>";
					});
					$("#loca_idx2").html(str);
			
				}
			});
		}
		else	{
			$("#loca_idx2").html("<option value=''>지역선택</option>");
		}
	});

});
</script>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<script>
function openDaumPostcode(f1,f2)	{
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
           
        }
    }).open();
}
function set_loca()	{
	
	var Addr_val = $("#addr1").val();
	if(Addr_val=='')	{
		alert('주소를 입력하세요');
		return;
	}

	naver.maps.Service.geocode({
        query: Addr_val
    }, function(status, response) {
        if (status === naver.maps.Service.Status.ERROR) {
            return alert('Something Wrong!');
        }

        if (response.v2.meta.totalCount === 0) {
            return alert('totalCount' + response.v2.meta.totalCount);
        }

         item = response.v2.addresses[0],
         $("#lcode2").val(item.x);
         $("#lcode1").val(item.y);
           
        
    });
}
</script>
<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" ENCTYPE="multipart/form-data"  method="post" onsubmit="return regich(this);">
<input type='hidden' name='mode' value='w'>
<input type='HIDDEN' name='email' value='<?=$ar_data['email'];?>'>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상점정보(기초정보)</h3>
			</div>
			<div class="panel-content">
				

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">

				</colgroup>
				<tbody>
				<tr>
					
					<th>지역</th>
					<td>
						<select name='loca_idx1' id="loca_idx1" valch="yes" msg="지역을 선택하세요" >
						<option value=''>지역선택</option>
						<?
						$q = "SELECT * FROM shop_intro_store_loca ORDER BY index_no ASC";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$se = "";
							if($row['index_no']==$se_loca_idx)	{
								$se = "selected";
							}
							echo "<option value='$row[index_no]' $se>$row[name]</option>";
						}
						?>
						</select>
						<select name='loca_idx2' id="loca_idx2" valch="yes" msg="지역을 선택하세요">
						<option value=''>지역선택</option>
						
						</select>
					</td>
					<th>노출</th>
					<td><select name='isshow'>
					<option value='Y'>노출</option>
					<option value='N'>비노출</option>
					</select></td>
				</tr>
				<tr>
					<th>매장명</th>
					<td colspan='3'><input type='text' name='name' class="form-control" value='<?=$ar_data['name'];?>' valch="yes" msg="매장명을 입력하세요"></td>
				</tr>
				<tr>
					<th>우편번호</th>
					<td colspan='3'>
						<div class="form-inline">
							<input type='text' name='zipcode' id="zipcode" class="form-control" valch="yes" msg="우편번호를 입력하세요">
							<button class="btn btn-primary" type="button" onclick="openDaumPostcode('zipcode','addr1');" >우편번호찾기</button>
							<button class="btn btn-primary" type="button" onclick="set_loca();" >좌표읽어오기</button>
						</div>
					</td>
				</tr>
				<tr>
					<th>주소</th>
					<td>
						<input type='text' name='addr1' id="addr1" class="form-control" valch="yes" msg="주소를 입력하세요">
					</td>
					<th>상세주소</th>
					<td>
						<input type='text' name='addr2' class="form-control">
					</td>
				</tr>
				<tr>
					<th>좌표(위도)</th>
					<td><input type='text' name='lcode1' id='lcode1' class="form-control" value='<?=$ar_data['lcode1'];?>'  <? if($ar_data['lang']!='ko') { echo "readonly";	}?>></td>
					<th>좌표(경도)</th>
					<td><input type='text' name='lcode2' id='lcode2' class="form-control" value='<?=$ar_data['lcode2'];?>' <? if($ar_data['lang']!='ko') { echo "readonly";	}?>></td>
				</tr>
				<tr>
					<th>전화</th>
					<td><input type='text' name='phone' class="form-control" value='<?=$ar_data['phone'];?>'></td>
					<th>팩스</th>
					<td><input type='text' name='fax' class="form-control" value='<?=$ar_data['fax'];?>'></td>
				</tr>
				<tr>
					<th>부가정보</th>
					<td colspan='3'><input type='text' name='etc_info' class="form-control" value='<?=$ar_data['etc_info'];?>'></td>
				</tr>
				<tr>
					<th>매장이미지</th>
					<td colspan='3'><input type='file' name='file' class="form-control"></td>
				</tr>
				<tr>
					<th>신규매장으로설정</th>
					<td colspan='3'>
						<label><input type='checkbox' name='isnew' value='Y' <? if($ar_data['isnew']=='Y') { echo "checked";	}?>>신규매장으로 설정</label>
					</td>
				</tr>

				</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i>밀착배송 / 배송관련 정보</h3>
			</div>
			<div class="panel-content">
				

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">

				</colgroup>
				<tbody>
				<tr>
					<th>판매수수료</th>
					<td colspan='3'>
						<div class="form-inline">
						
						<input type='text' name='giveper' class='form-control'  value="<?=number_format($ar_data[giveper]/100);?>"  onkeyup="numberWithCommas(this)">%
					</td>
				</tr>
				<tr>
					<th>밀착배송</th>
					<td colspan='3'><select name='deliver'>
					<option value='Y'>운영</option>
					<option value='N'>운영안함</option>
					</select></td>
				</tr>
				<tr>
					<th>배송비</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' name='deliverac' class="form-control" value=''>원
						</div>
					</td>
				</tr>
				
				</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 사업자정보</h3>
			</div>
			<div class="panel-content">
				

				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">

				</colgroup>
				<tbody>
				<tr>
					<th>대표자명</th>
					<td colspan='3'><input type='text' name='daename' class='form-control'></td>
					
				</tr>
				<tr>
					<th>상호명</th>
					<td><input type='text' name='companyname' class='form-control'></td>
					<th>사업자등록번호</th>
					<td><input type='text' name='businessnum' class='form-control'></td>
				</tr>
				<tr>
					<th>업종</th>
					<td><input type='text' name='job1' class='form-control'></td>
					<th>업태</th>
					<td><input type='text' name='job2' class='form-control'></td>
				</tr>
				<tr>
					<th>계산서발행연락처</th>
					<td><input type='text' name='bphone' class='form-control'></td>
					<th>계산서발행메일</th>
					<td><input type='text' name='bemail' class='form-control'></td>
				</tr>
				
				
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
						
				</div>
			</div>
	</div>
</div>
</form>