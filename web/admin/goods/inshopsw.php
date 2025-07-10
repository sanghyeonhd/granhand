<?
$mode = $_REQUEST['mode'];
if($mode=='w')	{

    $value['group_idx'] = $_REQUEST['group_idx'];
	
	if($value['group_idx']=='A')	{
		$values['gname'] = $_REQUEST['gname'];		
		insert("shop_goods_shops_group",$values);
		$value['group_idx'] = mysqli_insert_id($connect);
		unset($values);
	}
    $value['usescm'] = $_REQUEST['usescm'];
	if($value['usescm']=='Y')	{
	   $useid = trim($_REQUEST['useid']);

		$q = "SELECT * FROM shop_member where id='$useid'";
		$r = mysqli_query($connect,$q);
		$isit = mysqli_num_rows($r);
		
		if($isit==0)	{
			show_message("존재하지 않는 아이디 입니다.",true);
			exit;
		}
		else	{
			$row = mysqli_fetch_array($r);

			$value['mem_idx'] = $row['index_no'];
		}
	}
	else	{
		$value['sellmethod'] = "2";
	}
    $value['name'] = $_REQUEST['name'];
    $value['businessnum'] = $_REQUEST['businessnum'];
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
	$value['wdate'] = date("Y-m-d H:i:s");
	$value['memo'] = $_REQUEST['memo'];
	insert("shop_goods_shops",$value);
	unset($value);


	show_message("등록완료","");
	move_link("$PHP_SELF?code=$code");
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

		if($("#usescm option:selected").val()=='Y')	{
			if($("#useid").val()=='')	{
				alert('아이디를 입력하세요');
				return false;
			}
			if($("#usepasswd").val()=='')	{
				alert('비밀번호를 입력하세요');
				return false;
			}
			if($("#sellmethod option:selected").val()=='')	{
				alert('정산방식을 선택하세요');
				return false;
			}

			if($("#sellmethod option:selected").val()=='1')	{
				if($("#sellper").val()=='')	{
					alert('수수료율을 입력하세요');
					return false;
				}
			}
		}

		answer = confirm('거래처를 등록 하시겠습니까?');
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
				<h3><i class="fa fa-table"></i> 거래처등록</h3>
			</div>
			<div class="panel-content">
				<form id="wform" name="wform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>거래처그룹</th>
					<td>
						<div class="form-inline">
						<select class="uch" name='group_idx' id='group_idx'>
						<option value=''>그룹선택</option>					
						<option value='A'>직접입력</option>
						<?
						$q = "SELECT * FROM shop_goods_shops_group ORDER BY gname asc";
						$r = mysqli_query($connect,$q);
						while($row = mysqli_fetch_array($r))	{
							echo "<option value='$row[index_no]'>$row[gname]</option>";
						}
						?>
						</select>
						직접입력 : <input type='text' name='gname' id='gname' class="form-control">
						</div>
					</td>
					

					<th>SCM이용여부</th>
					<td>
						<select class="uch" name='usescm' id="usescm" onchange="set_useid(this);">
						<option value='Y'>사용</option>
						<option value='N'>사용안함</option>						
						</select>
					</td>
					
				</tr>
				<tr id="idinfo">
					<th>아이디</th>
					<td colspan='3'>
						<input type='text' name='useid' id='useid' class="form-control">
					</td>
					

					
				</tr>
				<tr id="sellmethod">
					<th>정산방식</th>
					<td colspan='3'>
						<div class="form-inline">
						<select name='sellmethod' id='sellmethod'>
						<option value=''>정산방식선택</option>
						<option value='1'>판매금액의수수료</option>
						<option value='2'>공급가액으로지급</option>
						</select> 판매수수료 : <input type='text' name='sellper' id='sellper' class="form-control" >%
						</div>
					</td>
				</tr>
				<tr>
					<th>업체명</th>
					<td>
						<input type='text' name='name' valch="yes" msg="업체명을 입력하세요" class="form-control">
					</td>
					

					<th>사업자등록번호</th>
					<td>
						<input type='text' name='businessnum' class="form-control">
					</td>
				</tr>
				<tr>
					<th>업종</th>
					<td>
						<input type='text' name='cates1' class="form-control">
					</td>
					

					<th>업태</th>
					<td>
						<input type='text' name='cates2' class="form-control">
					</td>
				</tr>
				<tr>
					<th>대표자명</th>
					<td colspan='3'>
						<input type='text' name='daename' class="form-control">
					</td>

				</tr>
				<tr>
					<th>대표자연락처</th>
					<td>
						<input type='text' name='daephone' class="form-control">
					</td>
					

					<th>대표자E-MAIL</th>
					<td>
						<input type='text' name='daeemail' class="form-control">
					</td>
				</tr>
				<tr>
					<th>담당자명</th>
					<td>
						<input type='text' name='damname' class="form-control">
					</td>
					

					<th>담당자직위</th>
					<td>
						<input type='text' name='damgrade' class="form-control">
					</td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td>
						<input type='text' name='phone' class="form-control">
					</td>
					

					<th>핸드폰</th>
					<td>
						<input type='text' name='cp' class="form-control">
					</td>
				</tr>
				<tr>
					<th>FAX</th>
					<td>
						<input type='text' name='fax' class="form-control">
					</td>
					

					<th>E-MAIL</th>
					<td>
						<input type='text' name='email' class="form-control">
					</td>
				</tr>
				<tr>
					<th>HOMEPAGE</th>
					<td colspan='3'>
						<input type='text' name='homepage' class="form-control">
					</td>

				</tr>

				<tr>
					<th>계좌정보</th>
					<td colspan='3'>
						<div class="form-inline">
						은행 : <input type='text' name='bank' class="form-control"> / 계좌번호 : <input type='text' name='bankaccount' class="form-control"> / 예금주 : <input type='text' name='bankname' class="form-control">
						</div>
					</td>
				</tr>
				
				<tr>
					<th>우편번호</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' name='zipcode' id="zipcode" class="form-control" readonly onclick="openDaumPostcode()">
						</div>
					</td>
				</tr>
				<tr>
					<th>주소</th>
					<td>
						<input type='text' name='addr1' id="addr1" class="form-control">
					</td>
					

					<th>상세주소</th>
					<td>
						<input type='text' name='addr2' id="addr2" class="form-control">
					</td>
				</tr>
				<tr>
					<th>거래처메모</th>
					<td colspan='3'>
						<textarea name='memo' class="form-control"></textarea>
					</td>
					
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#wform">등록하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
