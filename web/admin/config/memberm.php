<?php
$mode = $_REQUEST['mode'];
$group_idx = $_REQUEST['group_idx'];
$ar_config = sel_query_all("shop_member_group"," where idx='$group_idx'");
if($mode=='w'){
	$value['order_max_point1'] = $_POST['order_max_point1'];
	$value['order_max_point2'] = $_POST['order_max_point2'];
	$value['member_joinpoint'] = $_POST['member_joinpoint'];
	$value['member_joinpoint_msg'] = $_POST['member_joinpoint_msg'];
	$value['member_joingrade'] = $_POST['member_joingrade']; 
	
	$value['member_joincoupen'] = "";
	$joinc = $_REQUEST['joinc'];
	$tmp_c = array();
	
	if(isset($joinc))	{
		for($i=0;$i<sizeof($joinc);$i++)	{

			if(!in_array($joinc[$i],$tmp_c))	{
				$value['member_joincoupen'] = $value['member_joincoupen'] . $joinc[$i]."-";
			
				$tmp_c[] = $joinc[$i];
		
			}

		}	
	}
	
	

	$value['groupname'] = $_POST['groupname'];

	$value['member_joinsms'] = $_POST['member_joinsms'];
	$value['order_point_cnt'] = $_POST['order_point_cnt'];
	$value['order_point_std'] = $_POST['order_point_std'];
	$value['member_birthcoupen'] = $_POST['member_birthcoupen'];
	$value['member_birthday'] = $_POST['member_birthday'];
	$value['order_min_point'] = $_POST['order_min_point'];
	$value['member_joinpoint_msg'] = $_POST['member_joinpoint_msg'];
	$value['autogradeup'] = $_POST['autogradeup'];
	$value['gradeupstd'] =  $_POST['gradeupstd'];
	$value['gradeupstddays'] =  $_POST['gradeupstddays'];
	$value['joincheck1'] = $_POST['joincheck1'];
	$value['joincheck2'] = $_POST['joincheck2'];
	$value['joincheck3'] = $_POST['joincheck3'];
	$value['usecheck'] = $_POST['usecheck'];
	$value['checkreward'] = $_POST['checkreward'];
	$value['checkrewardg'] = $_POST['checkrewardg'];
	$value['checkstd'] = $_POST['checkstd'];
	$value['checkstddays'] = $_POST['checkstddays'];
	$value['saveaddp'] = $_POST['saveaddp'];

	$value['use_snslogin'] = $_REQUEST['use_snslogin'];
	$value['use_point'] = $_REQUEST['use_point'];
	

	update("shop_member_group",$value," where idx='$group_idx'");

	
	echo "<Script>alert('설정이 완료되었습니다.'); location.replace('$G_PHP_SELF?code=$code&group_idx=$group_idx'); </script>";
	exit;
}
if($mode=='w2')
{
	$userfile = array($_FILES['img']['name'],$_FILES['imgl']['name']);
	$tmpfile = array($_FILES['img']['tmp_name'],$_FILES['imgl']['tmp_name']);

	$savedir = $_uppath."/icon/";



	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}


	$value['group_idx'] = $_POST['group_idx'];
	$value['grade_id'] = $_POST['grade_id'];
	$value['grade_name'] = $_POST['grade_name'];
	$value['grade_saveper'] = $_POST['grade_saveper']*100;
	$value['grade_discount'] = $_POST['grade_discount'];
	$value['grade_stand'] = $_POST['grade_stand'];
	$value['grade_up'] = $_POST['grade_up'];
	$value['grade_canup'] = $_POST['grade_canup'];
	$value['procode'] = $_POST['procode'];
	$value['icon'] = $fs[0];
	$value['iconl'] = $fs[1];
	$value['grade_nodels'] = $grade_nodels;
	$value['grade_birth'] = $grade_birth;
	$value['seller_per'] = $_REQUEST['seller_per'];
	$value['seller_out'] = $_REQUEST['seller_out'];

	$q = "select * from shop_member_grades where grade_id='$value[grade_id]' and group_idx='$group_idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit!=0)
	{
		echo "<Script>alert('중복된 레벨입니다.'); history.back(); </script>";
		exit;
	}

	insert("shop_member_grades",$value);

	echo "<Script>alert('등급이 추가되었습니다.'); location.replace('$G_PHP_SELF?code=$code&group_idx=$group_idx'); </script>";
	exit;
}
if($mode=='wmemo')
{
	$q = "select * from shop_config_memos where group_idx='$group_idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit==0)
	{
		$value['group_idx'] = $group_idx;
		$value['yak'] = $_POST['yak'];
		$value['per'] = $_POST['per'];
		insert("shop_config_memos",$value);
	}
	else
	{
		$value['yak'] = $_POST['yak'];
		$value['per'] = $_POST['per'];
		update("shop_config_memos",$value," where group_idx='$group_idx'");
	}
	
	echo "<Script>alert('수정이 완료되었습니다.'); location.replace('$G_PHP_SELF?code=$code&group_idx=$group_idx'); </script>";
	exit;
}
?>
<script>
function addcate()	{
	
	if($("#coupen option:selected").val()!='')	{
		
		var val = $("#coupen option:selected").val();
		var text = $("#coupen option:selected").text();

		str = "<p data-idx='"+val+"'><input type='hidden' name='joinc[]' value='"+val+"'>"+text+" <a href='#none' onclick='removeobj(this);' style='color:red'>X</a></p>";
		
		$("#joincoupens").append(str);
	}
}
function removeobj(obj)	{
	$(obj).parent().remove();
}

</script>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('등록 하시겠습니까?');
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
<form name="wform" id="wform" action="<?=$G_PHP_SELF;?>?code=<?=$code;?>" method="post">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='group_idx' value='<?=$group_idx;?>'>
<input type='hidden' name='ar_member_joincoupen' value='''>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 기초정보</h3>
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
					<th>회원그룹명</th>
					<td colspan='3'><input type='text' class="form-control" name='groupname' value="<?=$ar_config['groupname'];?>"></td>
				</tr>
				<tr>
					<th> 회원가입등급</th>
					<td> 
						<div class="form-inline">
						회원가입시 
						<select class="uch" name='member_joingrade'>	
						<?php
						$q = "select * from shop_member_grades where group_idx='$group_idx' order by grade_id asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() )	{
							if($ar_config['member_joingrade']==$row['grade_id'])	{
								echo "<option value='$row[grade_id]' selected>$row[grade_name]</option>";	
							}		
							else	{
								echo "<option value='$row[grade_id]'>$row[grade_name]</option>";	
							}
						}
						?>
						</select> 로 합니다.
						</div>
					</td>
					<th>회원가입시</th>
					<td>
						<div class="form-inline">
							<input type='checkbox' name='joincheck1' value='Y' <? if($ar_config['joincheck1']=='Y') { echo "checked";	}?>>닉네임중복확인
							<input type='checkbox' name='joincheck2' value='Y' <? if($ar_config['joincheck2']=='Y') { echo "checked";	}?>>휴대폰중복확인
							<input type='checkbox' name='joincheck3' value='Y' <? if($ar_config['joincheck3']=='Y') { echo "checked";	}?>>이메일중복확인
						</div>
					</td>
				</tr>
				<tr>
					<th> 가입시문자 </th>
					<td colspan='3'> 
						<div class="form-inline">
							<input type='checkbox' name='member_joinsms' value='Y' <? if($ar_config['member_joinsms']=='Y') { echo "checked";	}?>> 문자발송 
						</div>
					</td>
				</tr>
				<tr>
					<th>자동등업</th>
					<td> 
						<div class="form-inline">
							<input type='radio' name='autogradeup' value='Y' <? if($ar_config['autogradeup']=='Y') { echo "checked";	}?>>자동등업 <input type='radio' name='autogradeup' value='N' <? if($ar_config['autogradeup']=='N') { echo "checked";	}?>>자동등업사용안함
						</div>
					</td>

					<th>자동등업주기</th>
					<td> 
						<select name='gradeupstd'>
						<option value=''>매일 05시 변경</option>
						<option value='1' <? if($ar_config['gradeupstd']=='1') { echo "selected";	}?>>1개월 [매월1일 05시 변경]</option>
						<option value='3' <? if($ar_config['gradeupstd']=='3') { echo "selected";	}?>>3개월 [3/6/9/12월말 익일 05시 변경]</option>
						<option value='6' <? if($ar_config['gradeupstd']=='6') { echo "selected";	}?>>6개월 [6/12월말 익일 05시 변경]</option>
						<option value='12' <? if($ar_config['gradeupstd']=='12') { echo "selected";	}?>>12개월 [1월1일 05시 변경]</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>등업사용데이터</th>
					<td colspan='3'> 
						<div class="form-inline">
							등업시 <input type='text' class="form-control" name='gradeupstddays' value='<?=$ar_config['gradeupstddays'];?>' style='width:50px;'>개월 데이터를 기준으로 등업에 사용합니다.
						</div>
					</td>
				</tr>

				<tr>
					<th>출석체크</th>
					<td>
						<div class="form-inline">
						<input type='radio' name='usecheck' value='Y' <? if($ar_config['usecheck']=='Y') { echo "checked";	} ?>>출석체크적용
						<input type='radio' name='usecheck' value='N' <? if($ar_config['usecheck']=='N') { echo "checked";	} ?>>출석체크적용안함
						</div>
					</td>

					<th>출석체크혜택</th>
					<td>
						<div class="form-inline">
						<select name='checkreward'>
						<option value='1'  <? if($ar_config['checkreward']=='1') { echo "selected";	} ?>>적립금</option>
						<option value='2'  <? if($ar_config['checkreward']=='2') { echo "selected";	} ?>>포인트</option>
						</select>
						<input type='text' class="form-control" name='checkrewardg' value='<?=$ar_config['checkrewardg'];?>' size='6'> 지급
						</div>
					</td>
				</tr>
				<tr>
					<th>출석체크혜택기준</th>
					<td colspan='3'>
						<div class="form-inline">
							<div class="form-inline">
								<input type='radio' name='checkstd' value='1'  <? if($ar_config['checkstd']=='1') { echo "checked";	} ?>>매일출석시지급  <input type='radio' name='checkstd' value='2'  <? if($ar_config['checkstd']=='2') { echo "checked";	} ?>> <input type='text' class="form-control" name='checkstddays' value='<?=$ar_config['checkstddays'];?>' size='4'>일 연속 출석시지급
							</div>
					</td>
				</tr>
				</table>
			</div>
		</div>
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 간련로그인</h3>
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
					<th>간편로그인사용</th>
					<td colspan='3'>
						<label><input type='radio' name='use_snslogin' value='Y' <? if($ar_config['use_snslogin']=='Y') { echo "checked";	}?>>사용</label>
						<label><input type='radio' name='use_snslogin' value='N' <? if($ar_config['use_snslogin']=='N') { echo "checked";	}?>>사용안함</label>
					</td>
				</tr>
				
				</table>
			</div>
		</div>
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원그룹적립금설정</h3>
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
					<th>적립금기능사용여부</th>
					<td colspan='3'>
						<label><input type='radio' name='use_point' value='Y' <? if($ar_config['use_point']=='Y') { echo "checked";	}?>>사용</label>
						<label><input type='radio' name='use_point' value='N' <? if($ar_config['use_point']=='N') { echo "checked";	}?>>사용안함</label>
					</td>
				</tr>

				<tr>
					<th>회원가입적립금</th>
					<td>
						<div class="form-inline">
						회원가입시 적립금 <input type='text' class="form-control" name='member_joinpoint' size='10' value="<?=$ar_config['member_joinpoint'];?>"> 포인트 지급
						</div>
					</td>
					<th>가입적립금내역</th>
					<td colspan='3'>
						<div class="form-inline">
						회원가입시 적립금 내역을 <input type='text' class="form-control" name='member_joinpoint_msg' value='<?=$ar_config['member_joinpoint_msg'];?>'>로 합니다.
						</div>
					</td>
				</tr>
				<tr>
					<th> 주문횟수 적립금 사용</th>
					<td colspan='3'> 
						<div class="form-inline">
						주문 횟수가 <input type='text' class="form-control" name='order_point_cnt' size='10' value="<?=$ar_config['order_point_cnt'];?>"> 회 이상시에만 적립금 사용 
						</div>
					</td>
				</tr>
				<tr>
					<th>주문시적립금</th>
					<td colspan='3'> 
						<div class="form-inline">
						주문시적립금은 주문금액이 <input type='text' class="form-control" name='order_point_std' size='10' value="<?=$ar_config['order_point_std'];?>"> 이상시에만 사용 
						</div>
					</td>
				</tr>
				<tr>
					<th>주문시적립금</th>
					<td colspan='3'> 
						<div class="form-inline">
						주문시적립금은  <input type='text' class="form-control" name='order_min_point' size='10' value="<?=$ar_config['order_min_point'];?>"> 이상부터 사용 
						</div>
					</td>
				</tr>
				<tr>
					<th>주문시적립금</th>
					<td colspan='3'> 
						<div class="form-inline">
						주문시적립금은 주문금액의 <input type='text' class="form-control" name='order_max_point1' size='10' value="<?=$ar_config['order_max_point1'];?>"> <input type='radio' name='order_max_point2' value='1' <? if($ar_config['order_max_point2']=='1'){ echo "checked";}?>>원 / <input type='radio' name='order_max_point2' value='2' <? if($ar_config['order_max_point2']=='2'){ echo "checked";}?>>% 까지 사용가능 ('0' 일떄는 설정값무시) 
						</div>
					</td>
				</tr>
				
				</tbody>
				</table>
			</div>
		</div>

		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원쿠폰설정</h3>
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
					<th> 회원가입쿠폰 </th>
					<td style="padding:10px;" colspan='3'>
						<div class="form-inline">
							<select name='coupen' class="select-chosen" id='coupen'>
							<option value=''>쿠폰선택</option>
							<?php
							$q = "select * from shop_coupen where isuse='Y'";
							$st = $pdo->prepare($q);
							$st->execute();
							while($row = $st->fetch() )	{
								echo "<option value='$row[idx]'>$row[coupenname]</option>";
							}
							?>
							</select>
							<button class="btn btn-xs btn-primary waves-effect waves-light" onclick="addcate();" type="button">추가하기</button>
						</div>
						<div id="joincoupens">
							
							<?
							$ar_coupen = explode("-",$ar_config['member_joincoupen']);
							for($i=0;$i<sizeof($ar_coupen);$i++)	{
								if($ar_coupen[$i]!='')	{
									$ar_c = sel_query("shop_coupen","coupenname"," where idx='$ar_coupen[$i]'");
							?>
								<p data-idx="<?=$ar_coupen[$i];?>"><input type='hidden' name='joinc[]' value='<?=$ar_coupen[$i];?>'><?=$ar_c['coupenname'];?> <a href="#none" onclick="removeobj(this);" style="color:red">X</a></p>
							<?
								}
							}
							?>

						</div>
					</td>

				</tr>
				<tr>
					<th>생일쿠폰지급일시</th>
					<td colspan='3'>
						<div class="form-inline">
						생일 <input type='text' class="form-control" name='member_birthday' value='<?=$ar_config['member_birthday'];?>'>일전 쿠폰지급
						</div>
					</td>
				</tr>
				<tr>
					<th> 생일쿠폰 </th>
					<td colspan='3'>
						<div class="form-inline">
						<select name='member_birthcoupen'>
						<option value=''>생일쿠폰선택</option>
						<?
						$q = "select * from shop_coupen where isuse='Y'";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() )	{
							if($ar_config['member_birthcoupen']==$row['idx'])	{
								echo "<option value='$row[idx]' selected>$row[coupenname]</option>";	
							}
							else	{
								echo "<option value='$row[idx]'>$row[coupenname]</option>";	
							}
						}
						?>
						</select>
						지급
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
		<div class="form-group row">
			<div class="col-sm-8 col-sm-offset-4">
				<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#wform">수정하기</button>
						
			</div>
		</div>
	</div>
</div>
</form>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원등급등록</h3>
			</div>
			<div class="panel-content">
		<form id="regiform2" name="regiform2" action="<?=$G_PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regich(this);">
		<input type='hidden' name='mode' value='w2'>
		<input type='hidden' name='group_idx' value='<?=$group_idx;?>'>		
		
		<table class="table table-bordered">
		<colgroup>
			<col width="15%">
			<col width="35%">
			<col width="15%">
			<col width="35%">
		</colgroup>
		<tbody>
		<tr>

		<th>레벨</th>
		<td colspan='3'>
		<select class="uch" name='grade_id'>
		<option value=''>선택</option>
		<?php
		for($i=1;$i<=100;$i++)
		{	echo "<option value='$i'>$i</option>";	}
		?>
		</select>
		</td>
		</tr>
		<tr>
		<th>등급명</th>
		<td colspan='3'><input type="text" class="form-control" name='grade_name' valch="yes" msg="등급명을입력하세요"></td>
		</tr>
		<tr>
		<th>적립금</th>
		<td colspan='3'>
			<div class="form-inline">
			<input type="text" class="form-control" name='grade_saveper' size='4'> %
			</div>
		</td>
		</tr>
		<tr>
		<th>할인률</th>
		<td colspan='3'>
			<div class="form-inline">
			<input type="text" class="form-control" name='grade_stand' size='4'> 원 이상구매시 <input type="text" class="form-control" name='grade_discount' size='4'> %
			</div>
		</td>
		</tr>
		<tr>
		<th>아이콘</th>
		<td colspan='3'><input type='file' name='img'></td>
		</tr>
		<tr>
		<th>추가아이콘</th>
		<td colspan='3'><input type='file' name='imgl'></td>
		</tr>
		<tr>
		<th>프로모션코드</th>
		<td colspan='3'><input type="text" class="form-control" name='procode'></td>
		</tr>
		<tr>
		<th>무료배송여부</th>
		<td colspan='3'><label><input type='checkbox' name='grade_nodels' value='Y'>무료배송</label></td>
		</tr>
		<tr>
		<th>등급별생일쿠폰</th>
		<td colspan='3'>
			<div class="form-inline">
			<select name='grade_birth'>
			<option value=''>생일쿠폰선택</option>
			<?
			$q = "select * from shop_coupen where isuse='Y'";
			$st = $pdo->prepare($q);
			$st->execute();
			while($row = $st->fetch() )	{
				echo "<option value='$row[idx]'>$row[coupenname]</option>";	
			}
			?>
			</select>
			지급
			</div>
			</td>
		</tr>
		<tr>
		<th>등업가능여부</th>
		<td colspan='3'>
			<div class="form-inline">
			이등급은 자동등급조절을 <select name='grade_canup'>
			<option value='Y'>사용</option>
			<option value='N'>사용안함</option>
			</select>
			</div>
		</td>
		</tr>
		<tr>
		<th>등업기준</th>
		<td colspan='3'>
			<div class="form-inline">
			<input type="text" class="form-control" name='grade_up'> 이상 구매시 등급 적용  
			</div>
		</td>
		</tr>
		<tr>
		<th>추가적립금기준</th>
		<td colspan='3'>
			<div class="form-inline">
			<label><input type='radio' name='saveaddp' value='1' <? if($ar_config['saveaddp']=='1') { echo "checked";	} ?>>상품 기본 적립금이 없으면 등급추가적립안함</label>

			<label><input type='radio' name='saveaddp' value='2' <? if($ar_config['saveaddp']=='2') { echo "checked";	} ?>>상품 기본 적립금이 없어도 실결제기준으로 추가적립</label>
			</div>
		</td>
		</tr>
		</tbody>
		</table>
		<div class="form-group row">
			<div class="col-sm-8 col-sm-offset-4">
				<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform2">등록하기</button>
						
			</div>
		</div>

		</form><!-- // .form[name="regiform2"]  -->
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원등급목록</h3>
			</div>
			<div class="panel-content">
<table class="table table-bordered">
			<colgroup>
				<col width="30px" />
				
			</colgroup>
			<thead>
				<tr>
				<th >레벨</th>
				<th >등급명</th>
				<th >추가아이콘</th>
				<th >적립금</th>
				<th >할인율</th>
				<th >등업</th>
				<th >코드</th>
				<th >무료배송</th>
				<th >생일쿠폰</th>
				
				<th ></th>
				</tr>
			</thead>
				<?php
				$q = "select * from shop_member_grades where group_idx='$group_idx' order by grade_id asc";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch()) {

				?>
			<tbody>
				<tr class='<?=$co;?>'>
					<td class="first"><?=$row['grade_id'];?></td>
					<td><? if($row['icon']!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$row['icon'];?>"><?}?><?=$row['grade_name'];?>
					</td>
					<td><? if($row['iconl']!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$row['iconl'];?>"><?}?></td>
					<td><?=($row['grade_saveper']/100);?>%</td>
					<td><?=number_format($row['grade_stand']);?>이상 구매시<?=$row['grade_discount'];?>%
					</td>
					<td>
						<?
						if($row['grade_canup']=='Y')
						{	echo number_format($row['grade_up']) . " 이상 구매시 등급적용";	}
						else
						{	echo "등업변동 없음";	}
						?>
					</td>
					<td><?=$row['procode'];?></tD>
					<td><?=$row['grade_nodels'];?></td>
					<td>
					<?
					if($row['grade_birth']!='0')	{
						$ar_c = sel_query_all("shop_coupen"," WHERE idx='$row[grade_birth]'");
						echo $ar_c['coupenname'];
					}
					?>
					</td>
					
					<td><a class="btn btn-xs btn-primary waves-effect waves-light" href="javascript:MM_openBrWindow('popup.php?code=config_gradem&idx=<?=$row['idx'];?>','mg','scrollbars=yes,width=1000,height=600,top=0,left=0');">수정</a></td>
				</tr>
			</tbody>
			<?php
			$cou++;
			}
			?>
		</table>
			</div>
		</div>
	</div>
</div>