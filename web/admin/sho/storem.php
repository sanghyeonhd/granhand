<?php
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_intro_store"," WHERE index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	foreach($_REQUEST AS $key => $val)	{
		
		if(!is_array($_REQUEST[$key]))	{

			$_REQUEST[$key] = addslashes(trim($val));
		}
	}
	
	$value['loca_idx1'] = $_REQUEST['loca_idx1'];
	$value['loca_idx2'] = $_REQUEST['loca_idx2'];
	$value['name'] = $_REQUEST['name'];

	$value['zipcode'] = $_REQUEST['zipcode'];
	$value['addr1'] = $_REQUEST['addr1'];
	$value['addr2'] = $_REQUEST['addr2'];
	$value['phone'] = $_REQUEST['phone'];
	$value['fax'] = $_REQUEST['fax'];
	$value['email'] = $_REQUEST['email'];
	$value['mdate'] = date("Y-m-d H:i:s");
	$value['isshow'] = $_REQUEST['isshow'];
	$value['deliver'] = $_REQUEST['deliver'];
	$value['deliverac'] = $_REQUEST['deliverac'];
	$value['usedelac'] = $_REQUEST['usedelac'];
	$value['deliverac_std'] = str_replace(",","",$_REQUEST['deliverac_std'])*100;;
	$value['deliverac'] = str_replace(",","",$_REQUEST['deliverac'])*100;;

	$value['geodata'] = $_REQUEST['geodata'];
	$value['useaccount'] = $_REQUEST['useaccount']*100;
	
	$value['lcode1'] = $_REQUEST['lcode1'];
	$value['lcode2'] = $_REQUEST['lcode2'];
	$value['isnew'] = $_REQUEST['isnew'];
	$value['up_idx'] = 0;
	$ar_del = array("N");

	$ar_last = array($ar_data['img']);

		
	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);

	$savedir = $_uppath."store/";
		
	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);
	}

	$value['companyname'] = $_REQUEST['companyname'];
	$value['businessnum'] = $_REQUEST['businessnum'];
	$value['job1'] = $_REQUEST['job1'];
	$value['job2'] = $_REQUEST['job2'];
	$value['daename'] = $_REQUEST['daename'];
	$value['bphone'] = $_REQUEST['bphone'];
	$value['bemail'] = $_REQUEST['bemail'];
	$value['giveper'] = $_REQUEST['giveper']*100;

	$value['bank'] = $_REQUEST['bank'];
	$value['bankname'] = $_REQUEST['bankname'];
	$value['bankaccount'] = $_REQUEST['bankaccount'];
		
	$value['img'] = $fs[0];
	update("shop_intro_store",$value," WHERE index_no='$index_no'");
	unset($value);

	$geo1 = explode("-",$_REQUEST['geo1']);
	$geo2 = explode("-",$_REQUEST['geo2']);
	$pdo->prepare("delete from shop_intro_store_geometry where store_idx='$index_no'")->execute();
	for($i=0;$i<sizeof($geo1);$i++)	{
		if($geo1[$i]!='')	{
			$value['store_idx'] = $index_no;
			$value['loca1'] = $geo1[$i];
			$value['loca2'] = $geo2[$i];
			insert("shop_intro_store_geometry",$value);
			unset($value);
		}
	}


	show_message("수정완료 되었습니다.","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;
}
if($mode=='d')	{

	$pdo->prepare("DELETE FROM shop_intro_store WHERE index_no='$index_no'")->execute();
	$pdo->prepare("DELETE FROM shop_intro_store WHERE up_idx='$index_no'")->execute();

	show_message("완료","");
	move_link("$PHP_SELF?code=sho_store");
	exit;
}
?>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=mg73rj4ce7&submodules=drawing,geocoder"></script>
<script>
var map = '';
var drawingManager;
function regich(f)	{
	var isok = check_form(f);

	try	{
		var geojson = drawingManager.toGeoJson();
	//var data = JSON.stringify(geojson.bbox);

	console.log(geojson);
	
	if(geojson.features)	{
		var geo1 = '';
		var geo2 = '';
		for(var i=0;i<geojson.features[0].geometry.coordinates[0].length;i++)	{
			console.log(geojson.features[0].geometry.coordinates[0][i][0]);
			console.log(geojson.features[0].geometry.coordinates[0][i][1]);

			geo1 = geo1 + geojson.features[0].geometry.coordinates[0][i][0] + '-';
			geo2 = geo2 + geojson.features[0].geometry.coordinates[0][i][1] + '-';
		}
	
		$("#geo1").val(geo1);
		$("#geo2").val(geo2);
		}
	}	catch(e)	{

	}

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
	
	<?
	if($ar_data['lcode1']!=''  && $ar_data['lcode2']!='')	{
	?>
	var mapOptions = {
		center: new naver.maps.LatLng(<?=$ar_data['lcode1'];?>, <?=$ar_data['lcode2'];?>),
	    zoom: 14,
		zoomControl: true,
		zoomControlOptions: {
			style: naver.maps.ZoomControlStyle.LARGE,
			position: naver.maps.Position.TOP_RIGHT
		},
		mapTypeControl: true,
	};
	map = new naver.maps.Map('map', mapOptions);
	
	var marker = new naver.maps.Marker({
		position: new naver.maps.LatLng(<?=$ar_data['lcode1'];?>, <?=$ar_data['lcode2'];?>),
		map: map
	});
	
	<?
	$q = "select * from shop_intro_store_geometry where store_idx='$index_no'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();
	
	if($isit!=0)	{
	?>
	var polygon = new naver.maps.Polygon({
		map: map,
		paths: [
			<?
			while($row = $st->fetch())	{
			?>
		    [<?=$row['loca1'];?>, <?=$row['loca2'];?>],
			<?}?>
		],
		fillColor: '#ffc300',
		fillOpacity: 0.5,
		strokeWeight: 3,
		strokeColor:'#ffc300'
	});
	<?}?>
	
	naver.maps.Event.once(map, 'init_stylemap', function () {
		drawingManager = new naver.maps.drawing.DrawingManager({
			map: map,
			controlPointOptions: {
			    anchorPointOptions: {
			        radius: 5,
			        fillColor: '#ff0000',
			        strokeColor: '#0000ff',
			        strokeWeight: 2
			    },
			    midPointOptions: {
			        radius: 4,
			        fillColor: '#ff0000',
			        strokeColor: '#0000ff',
			        strokeWeight: 2,
			        fillOpacity: 0.5
			    }
			},
			rectangleOptions: {
				fillColor: '#ff0000',
				fillOpacity: 0.5,
				strokeWeight: 3,
				strokeColor: '#ff0000'
			},
			ellipseOptions: {
				fillColor: '#ff25dc',
				fillOpacity: 0.5,
				strokeWeight: 3,
				strokeColor: '#ff25dc'
			},
			polylineOptions: { // 화살표 아이콘 계열 옵션은 무시됩니다.
			    strokeColor: '#222',
			    strokeWeight: 3
			},
			arrowlineOptions: { // startIcon || endIcon 옵션이 없으면 endIcon을 BLOCK_OPEN으로 설정합니다.
			    endIconSize: 16,
			    strokeWeight: 3
			},
			polygonOptions: {
				fillColor: '#ffc300',
				fillOpacity: 0.5,
				strokeWeight: 3,
				strokeColor:'#ffc300'
			}
		});
		
		<?
		if($isit!=0)	{
		?>
		drawingManager.addDrawing(polygon, naver.maps.drawing.DrawingMode.POLYGON);
		<?}?>
	});
	<?}?>
});
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
</script>
<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" ENCTYPE="multipart/form-data"  method="post" onsubmit="return regich(this);">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='index_no' value='<?=$index_no;?>'>
<input type='hidden' id="geo1" name='geo1' value=''>
<input type='hidden' id="geo2" name='geo2' value=''>
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
						<select name='loca_idx1' id="loca_idx1" valch="yes" msg="지역을 선택하세요">
						<option value=''>지역선택</option>
						<?
						$q = "SELECT * FROM shop_intro_store_loca where up_idx='0' ORDER BY orders ASC";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$se = "";
							if($row['index_no']==$ar_data['loca_idx1'])	{
								$se = "selected";
							}
							echo "<option value='$row[index_no]' $se>$row[name]</option>";
						}
						?>
						</select>
						<select name='loca_idx2' id="loca_idx2" valch="yes" msg="지역을 선택하세요">
						<option value=''>지역선택</option>
						<?
						$q = "SELECT * FROM shop_intro_store_loca where up_idx='$ar_data[loca_idx1]' ORDER BY orders ASC";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$se = "";
							if($row['index_no']==$ar_data['loca_idx2'])	{
								$se = "selected";
							}
							echo "<option value='$row[index_no]' $se>$row[name]</option>";
						}
						?>
						</select>
					</td>
				
					<th>노출</th>
					<td><select name='isshow'>
					<option value='Y' <? if($ar_data['isshow']=='Y') { echo "selected";	}?>>노출</option>
					<option value='N' <? if($ar_data['isshow']=='N') { echo "selected";	}?>>비노출</option>
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
							<input type='text' name='zipcode' id="zipcode" value="<?=$ar_data['zipcode'];?>"  class="form-control" valch="yes" msg="우편번호를 입력하세요">
							<button class="btn btn-primary" type="button" onclick="openDaumPostcode('zipcode','addr1');" >우편번호찾기</button>

							<button class="btn btn-primary" type="button" onclick="set_loca();" >좌표읽어오기</button>
						</div>
					</td>
				</tr>
				<tr>
					<th>주소</th>
					<td>
						<input type='text' name='addr1' id="addr1" value="<?=$ar_data['addr1'];?>"  class="form-control" valch="yes" msg="주소를 입력하세요">
					</td>
					<th>상세주소</th>
					<td>
						<input type='text' name='addr2' class="form-control" value="<?=$ar_data['addr2'];?>">
					</td>
				</tr>
				<tr>
					<th>좌표(위도)</th>
					<td><input type='text' name='lcode1' id="lcode1" class="form-control" value='<?=$ar_data['lcode1'];?>'></td>
					<th>좌표(경도)</th>
					<td><input type='text' name='lcode2' id="lcode2" class="form-control" value='<?=$ar_data['lcode2'];?>'></td>
				</tr>
				<tr>
					<th>전화</th>
					<td><input type='text' name='phone' class="form-control" value='<?=$ar_data['phone'];?>'></td>
					<th>팩스</th>
					<td><input type='text' name='fax' class="form-control" value='<?=$ar_data['fax'];?>'></td>
				</tr>
				<tr>
					<th>E-MAIL</th>
					<td colspan='3'><input type='text' name='email' class="form-control" value='<?=$ar_data['email'];?>'></td>
				</tr>

				
				<tr>
					<th>매장이미지</th>
					<td colspan='3'><input type='file' name='file' class="form-control"> <? if($ar_data['img']!='') { echo $ar_data['img']."등록";	}?></td>
				</tr>
				<tr>
					<th>신규매장으로설정</th>
					<td colspan='3'>
						<label><input type='checkbox' name='isnew' value='Y' <? if($ar_data['isnew']=='Y') { echo "checked";	}?>>신규매장으로 설정</label>
					</td>
				</tr>
				<tr>
					<th>여신한도</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='text' name='useaccount' class="form-control" value='<?=($ar_data['useaccount']/100);?>'>원
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
				<h3><i class="fa fa-table"></i> SCM 이용아이디</h3>
			</div>
			<div class="panel-content">
				<div class="row">
					<div class="col-md-12">
						<div class="text-right">
							<a href="#none" onclick="event.preventDefault(); MM_openBrWindow('popup?code=help_search&store_idx=<?=$index_no;?>&hanmode=store','member_main','width=1100,height=800,top=0,left=0,scrollbars=yes');" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>아이디 연결하기</a>
						</div>
					</div>
				</div>
				<table class="table table-bordered">
				<thead>
				<tr>
					<th class=kor8>회원번호</th>
					<th class=kor8>성명</th>
					<th class=kor8>아이디</th>
					<th class=kor8>핸드폰</th>
					<th class=kor8>이메일</th>
					<th class=kor8>가입일</th>
					<th class=kor8>소셜</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?
$q = "Select * from shop_member where usescm='$index_no'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() )	{
?>
				<tr>
					<td class="first"><?=$row[index_no];?></td>
					<td>
						<a href="javascript:MM_openBrWindow('popup?code=help_view&index_no=<?=$row[index_no];?>','member<?=$row[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$row[name];?></a>
					</td>
					<td><?=$row[id];?></td>
					<td><?=$row[cp];?></td>
					<Td><?=$row[email];?></td>
					<td><?=$row[signdate];?></td>
					<td><?=$row[social_type];?></td>
					<Td>
						<a href="#none" onclick="event.preventDefault(); delchk(this,<?=$row['index_no'];?>,'member','set_delscm'); " class="btn btn-xs btn-primary">삭제</a>
					</td>
				</tr>
<?
}
?>
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
				<h3><i class="fa fa-table"></i> 밀착배송/배송관련 정보</h3>
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
					<option value='Y' <? if($ar_data['deliver']=='Y') { echo "selected";	}?>>운영</option>
					<option value='N' <? if($ar_data['deliver']!='Y') { echo "selected";	}?>>운영안함</option>
					</select></td>
				</tr>
				<tr>
					<th>배송비</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='radio' name='usedelac' value='Y' <? if($ar_data[usedelac]=='Y') { echo "checked";	}?>> 배송비사용 <input type='radio' name='usedelac' value='N' <? if($ar_data[usedelac]=='N') { echo "checked";	}?>> 배송비사용안함 <br>
				 
						<input type='text' name='deliverac_std' class='form-control'  value="<?=number_format($ar_data[deliverac_std]/100);?>"  onkeyup="numberWithCommas(this)">원미만 <input type='text' name='deliverac'  class='form-control' value="<?=number_format($ar_data[deliverac]/100);?>"  onkeyup="numberWithCommas(this)">원 부과
					</td>
				</tr>
				<tr>
					<th>배송지역</th>
					<td colspan='3'>
						<div id="map" style="width:100%;height:800px;"></div>
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
					<td colspan='3'><input type='text' name='daename' class='form-control' value='<?=$ar_data['daename'];?>'></td>
					
				</tr>
				<tr>
					<th>상호명</th>
					<td><input type='text' name='companyname' class='form-control' value='<?=$ar_data['companyname'];?>'></td>
					<th>사업자등록번호</th>
					<td><input type='text' name='businessnum' class='form-control' value='<?=$ar_data['businessnum'];?>'></td>
				</tr>
				<tr>
					<th>업종</th>
					<td><input type='text' name='job1' class='form-control' value='<?=$ar_data['job1'];?>'></td>
					<th>업태</th>
					<td><input type='text' name='job2' class='form-control' value='<?=$ar_data['job2'];?>'></td>
				</tr>
				<tr>
					<th>계산서발행연락처</th>
					<td><input type='text' name='bphone' class='form-control' value='<?=$ar_data['bphone'];?>'></td>
					<th>계산서발행메일</th>
					<td><input type='text' name='bemail' class='form-control' value='<?=$ar_data['bemail'];?>'></td>
				</tr>
				
				<tr>
					<th>정산은행</th>
					<td><input type='text' name='bank' class='form-control' value='<?=$ar_data['bank'];?>'></td>
					<th>은행예금주</th>
					<td><input type='text' name='bankname' class='form-control' value='<?=$ar_data['bankname'];?>'></td>
				</tr>
				<tr>
					<th>정산계좌번호</th>
					<td colspan='3'><input type='text' name='bankaccount' class='form-control' value='<?=$ar_data['bankaccount'];?>'></td>
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
				<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">저장하기</button>
				<button class="btn btn-primary waves-effect waves-light" type="button" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&index_no=<?=$index_no;?>&mode=d','삭제하시겠습니까?');">삭제하기</button>
			</div>
		</div>
	</div>
</div>
</form>