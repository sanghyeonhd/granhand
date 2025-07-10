<?php
if(!$idx)
{	$idx = $_REQUEST['idx'];	}
$mode = $_REQUEST['mode'];

if ( !$idx ) {
	echo "<script>alert('잘못된 접근입니다.'); window.close(); </script>";
	exit;	
}

$ar_mem = sel_query_all("shop_member"," where idx='$idx'");
$ar_member_group = sel_query_all("shop_member_group"," where idx='$ar_mem[mem_type]'");
if(!$ar_member_group)
{	$ar_member_group[grouptype] = $ar_mem[mem_type];	}

if($ar_mem[usecur]!='')
{	$ar_member_group[grouptype] = $ar_mem[mem_type];	}
$ar_mem_grade = sel_query("shop_member_grades","grade_name"," where grade_id='$ar_mem[memgrade]' and group_idx='$ar_member_group[idx]'");

$html_title = "{$ar_mem[name]}[{$ar_mem_grade[grade_name]}] ($ar_mem[id]) - {$ar_mem[idx]}";


$mode = $_REQUEST['mode'];
if($mode=='w')
{
	$kind = $_POST['ch_mode'];
	$account = $_POST['account']*100;
	$memo = $_POST['memo'];

	$savedpoint = $ar_mem[mempoints];

	if($kind=='1')
	{
		$uppoint = $account + $savedpoint;
		$value[mem_idx] = $idx;
		$value[income] = $account;
		$value[outcome] = 0;
		$value[total] = $uppoint;
		$value[memo] = $_POST['memo'];
		$value[wdate_s] = date("Y-m-d",time());
		$value[hour_s] = date("H:i:s",time());
		$value[ch_name] = $memname;
		$r = insert("shop_member_points",$value);
	}
	else if($kind=='2')
	{
		if(($savedpoint-$account)<0)
		{
			echo "<script>alert('적립금이 음의 값이 되므로 변경할 수 없습니다.'); history.back(); </script>";
			exit;
		}

		$uppoint = $savedpoint - $account;

		$value[mem_idx] = $idx;
		$value[income] = 0;
		$value[outcome] = $account;
		$value[total] = $uppoint;
		$value[memo] = $_POST['memo'];
		$value[wdate_s] = date("Y-m-d",time());
		$value[hour_s] = date("H:i:s",time());
		$value[ch_name] = $memname;
		$r = insert("shop_member_points",$value);
	}
	if(!$r)
	{
		echo "<script>alert('처리에 실패하였습니다'); history.back(); </script>";
		exit;
	}
	$pdo->prepare("update shop_member set mempoints='$uppoint' where idx='$idx'")->execute();

	echo "<script>alert('처리하였습니다.'); location.replace('$PHP_SELF?code=$code&idx=$idx');</script>";
	exit;

}

if($mode=='ws')
{
	$coupen = $_REQUEST['coupen'];
	$ar_coupen = sel_query_all("shop_coupen"," where idx='$coupen'");
	
	make_coupen($ar_coupen,$idx);


	echo "<script>alert('처리하였습니다.'); location.replace('$PHP_SELF?code=$code&idx=$idx');</script>";
	exit;
}
if($mode=='ds')
{
	$c_idx = $_REQUEST['c_idx'];

	$st->$pdo->prepare("delete from shop_coupen_mem where idx='$c_idx'")->execute();

	echo "<script>alert('처리하였습니다.'); location.replace('$PHP_SELF?code=$code&idx=$idx');</script>";
	exit;
}
function make_coupen($ar_coupen,$mem_idx,$log_idx="")
{
	global $basictb;

	$fids = unserialize($ar_coupen[fids]);
	
	for($i=0;$i<sizeof($fids);$i++)
	{
		if($fids[$i]!='')
		{
	
	$value[mem_idx] = $mem_idx;
	$value[coupen_idx] = $ar_coupen[idx];
	$value[coupen_name] = $ar_coupen[coupenname];
	$value[mdate] = date("Y-m-d",time());
	
	if($ar_coupen[used]=='1')
	{
		$value[sdate] = $ar_coupen[startdates];
		$value[edate] = $ar_coupen[enddates];
		
	}
	else
	{
		if($ar_coupen[usedays]==0)
		{	$ar_coupen[usedays] = 1000;	}
	
		$value[sdate] = date("Y-m-d H:i:s",time());
		$value[edate] = date("Y-m-d",(time()+(86400*$ar_coupen[usedays])))." 23:59:59";
	}	
	$value[actype] = $ar_coupen[actype];
	$value[usetype] = $ar_coupen[usetype];
	$value[account] = $ar_coupen[account];
	$value[mtype] = "M";
	$value[mname] = $_SESSION['member_name'];
	$value[memo] = $_POST['memo'];
	$value[canuseac] = $ar_coupen[canuseac];
	$value[usesale] = $ar_coupen[usesale];
	$value[usegsale] = $ar_coupen[usegsale];
	$value[fids] = $fids[$i];
	$value[log_idx] = $log_idx;
	insert("shop_coupen_mem",$value);
	unset($value);
		}
	}
}


if($mode=='chmem')
{
	$ch_memgrade = $_REQUEST['ch_memgrade'];
	if($ch_memgrade==$ar_mem[memgrade])
	{
		echo "<script>alert('변경할 사항이 없음'); history.back(); </script>";
		exit;
	}


	$value[memgrade] = $ch_memgrade;
	update("shop_member",$value," where idx='$idx'");
	unset($value);

	$ar_nmem_grade = sel_query("shop_member_grades","grade_name"," where idx='$ch_memgrade'");

	$value[mem_idx] = $idx;
	$value[memo] = "회원등급 변경 : $ar_mem_grade[grade_name] => $ar_nmem_grade[grade_name]";
	if($saveper)
	{	$value[memo] = $value[memo] . " (할인율 : $saveper %)";	}
	$value[wdate] = $nowdate;
	$value[ch_name] = $memname;
	insert("shop_member_change",$value);
	unset($value);

	echo "<script>alert('정보변경 완료'); history.back(); </script>";
	exit;
}
if($mode=='chcon')
{
	$canconnect = $_REQUEST['canconnect'];
	if($canconnect==$ar_mem[canconnect])
	{
		echo "<script>alert('변경할 사항이 없음'); history.back(); </script>";
		exit;
	}

	$value[canconnect] = $canconnect;
	update("shop_member",$value," where idx='$idx'");
	unset($value);

	$value[mem_idx] = $idx;
	$value[memo] = "접속상태변경 : $ar_mem[canconnect] => $canconnect";
	$value[wdate] = $nowdate;
	$value[ch_name] = $memname;
	insert("shop_member_change",$value);
	unset($value);

	echo "<script>alert('정보변경 완료'); history.back(); </script>";
	exit;
}

if($mode=='chpasswd')
{
	$passwd = $_REQUEST['passwd'];
	if(!$passwd)
	{
		echo "<script>alert('비밀번호 입력'); history.back(); </script>";
		exit;
	}

	$value[passwd] = $passwd;
	update("shop_member",$value," where idx='$idx'");
	unset($value);

	$value[mem_idx] = $idx;
	$value[memo] = "비밀번호 변경";
	$value[wdate] = $nowdate;
	$value[ch_name] = $memname;
	insert("shop_member_change",$value);
	unset($value);

	echo "<script>alert('정보변경 완료'); history.back(); </script>";
	exit;
}
if($mode=='www')
{

	$phone = trim($_POST['phone']);
	$cp = trim($_POST['cp']);
	$email = trim($_POST['email']);
	$zip1 = trim($_POST['zip1']);
	$zip2 = trim($_POST['zip2']);
	$addr1 = trim($_POST['addr1']);
	$addr2 = trim($_POST['addr2']);
	$passwd = trim($_POST['passwd']);
	$ch_memgrade = $_POST['ch_memgrade'];
	$canconnect = $_POST['canconnect'];

	$value[name] = $_POST['name'];
	$value[nickname] = $_POST['nickname'];
	$value[phone] = $phone;
	$value[cp] = $cp;
	$value[email] = $email;
	$value[zip1] = $zip1;
	$value[zip2] = $zip2;
	$value[zipcode] = trim($_POST['zipcode']);	// 신 우편번호 추가 2016-04-27 dongs.
	$value[addr1] = $addr1;
	$value[addr2] = $addr2;
	if($passwd!='')
	{	$value[passwd] = $passwd;	}

	$value[oaddr] = $_POST['oaddr'];
	$value[ozip] = $_POST['ozip'];
	
	$value[memgrade] = $ch_memgrade;
	
	$value[birth_year] = $_POST['birth_year'];
	$value[birth_month] = $_POST['birth_month'];
	$value[birth_day] = $_POST['birth_day'];
	$value[birthtype] = $_POST['birthtype'];

	$value[canconnect] = $canconnect;
	$value[smsser] = $_POST['smsser'];
	$value[mailser] = $_POST['mailser'];
	$value[usecur] = $_POST['usecur'];

	update("shop_member",$value," where idx='$idx'");

	echo "<script>alert('변경완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;

}
if($mode=='changepa')
{
	$passwd = substr(time(),2,6);
	$value[passwd] = $passwd;
	update("shop_member",$value," where idx='$idx'");

	echo "<script>alert('변경완료'); location.replace('$PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;
}
?>


<script>
function foch()
{
	if(document.form1.ch_mode[0].checked==false && document.form1.ch_mode[1].checked==false)
	{
		alert('변경 구분을 선택');
		return false;
	}
	if(!document.form1.account.value)
	{
		alert('금액입력');
		document.form1.account.focus();
		return false;
	}
	if(!document.form1.memo.value)
	{
		alert('사유입력');
		document.form1.memo.focus();
		return false;
	}
	return true;
}
function fochs()
{
	if(document.form2.coupen.options.value=='')
	{
		alert('발급 쿠폰을 선택하시요.');
		document.form2.coupen.focus();
		return false;
	}
	if(!document.form2.memo.value)
	{
		alert('사유를 입력');
		document.form2.memo.focus();
		return false;
	}
	return true;
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원기본정보</h3>
			</div>
			<div class="panel-content">

<table class="table table-bordered">
<tr>
<th>성명</th>
<td><?=$ar_mem[name];?> (<? if($ar_mem[sex]=='M') { echo "남"; } else { echo "여";	} ?>)</td>
<th>닉네임</th>
<td><?=$ar_mem[nickname];?></td>
<th>아이디</th>
<td><?=$ar_mem[id];?></td>
<th>회원등급</th>
<td><?=$ar_mem_grade[grade_name];?>
[<?=$ar_mem[rtype];?>]
</td>
</tr>


<tr>
<th>전화번호</th>
<td><?=$ar_mem[phone];?></td>
<th>핸드폰</th>
<td><?=$ar_mem[cp];?> <a class="btn btn-xs btn-primary" href="javascript:MM_openBrWindow('popup.php?code=help_sms&idx=<?=$idx;?>','sms','scrollbars=yes,width=600,height=600,top=0,left=0');">문자발송</a></td>
<th>E-Mail</th>
<td colspan='3'><?=$ar_mem[email];?></td>

</tr>

<tr>
<th>주소</th>
<td colspan='3'><? if($ar_mem[mem_type]=='1'){?>[구 : <?=$ar_mem[zip1];?>-<?=$ar_mem[zip2];?> 신 : <?=$ar_mem[zipcode];?>] <?=$ar_mem[addr1];?> <?=$ar_mem[addr2];?><?}else{?>[<?=$ar_mem[ozip];?>] <?=$ar_mem[oaddr];?><?}?></td>
</td>
<th>가입경로</th>
<td colspan='3'><?=$ar_mem[enterc];?></td>
</tr>

<tr>
<th>메일링</th>
<td><?=$ar_mem[mailser];?></td>
<th>SMS</th>
<td><?=$ar_mem[smsser];?></td>
<th>생년월일</th>
<td><?=$ar_mem[birth_year];?>년 <?=$ar_mem[birth_month];?>월 <?=$ar_mem[birth_day];?>일 (<? if($ar_mem[birthtype]=='S') { echo  "양"; }else { echo "음";	}?>)</td>
<th>가입처</th>
<td><?=$ar_sites[$ar_mem[pid]];?></td>
</tr>

<tr>
<th>가입일</th>
<td><?=$ar_mem[signdate];?></td>
<th>마지막접속</th>
<td><?=$ar_mem[lastlogin];?></td>
<th>로그인횟수</th>
<td><?=number_format($ar_mem[logincount]);?></td>
<th>마지막IP</th>
<td><?=$ar_mem[lastip];?></td>
</tr>

<tr>
<th>보유적립금</th>
<td><?=number_format($ar_mem[mempoints]/100);?></td>
<th>보유스타일머니</th>
<td><?=number_format($ar_mem[memstymoney]);?></td>
<th>보유예치금</th>
<td><? if($ar_member_group[grouptype]=='1') { echo number_format($ar_mem[memaccounts]);	} else { echo number_format($ar_mem[omemaccounts],2); }?></td>
<th>접속허용</th>
<td><? if($ar_mem[canconnect]=='Y') { echo "접속허용";	} else { echo "접속차단";	}?></td>
</tr>

<tr>
<th>구매금액</th>
<td><?=number_format($ar_mem[buyac]);?>원</td>
<th>구매횟수</th>
<td colspan='5'><?=number_format($ar_mem[buyc]);?></td>
</tr>


</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 기타정보</h3>
			</div>
			<div class="panel-content">
				<div class="nav-tabs3">
					<ul id="myTab6" class="nav nav-tabs">
						<li class="active"><a href="#tab6_1" data-toggle="tab">회원정보</a></li>
						<li><a href="#tab6_2" data-toggle="tab">주문내역</a></li>
						<li><a href="#tab6_3" data-toggle="tab">적립금</a></li>
						<li><a href="#tab6_4" data-toggle="tab">쿠폰</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="tab6_1">


	<form id="modform" name="modform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
	<input type='hidden' name='mode' value='www'>
	<input type='hidden' name='idx' value='<?=$idx;?>'>

	<table class="table table-bordered">
	<tr>

	<th>성명</th>
	<td><input type='text' class="form-control" name='name' size='20' value='<?=$ar_mem[name];?>'></td>
	</tr>
	<th>닉네임</th>
	<td><input type='text' class="form-control" name='nickname' size='20' value='<?=$ar_mem[nickname];?>'></td>
	</tr>
	<tr>
	
	<th>전화번호</th>
	<td>
		<input type='text' class="form-control" name='phone' value='<?=$ar_mem[phone];?>'>
	</td>
	</tr>
	
	<tr>
	<th>핸드폰</th>
	<td>
		<input type='text' class="form-control" name='cp' value='<?=$ar_mem[cp];?>'>
		
	</td>
	</tr>
	<tr>
	<th>생년월일</th>
	<td>
		<div class="form-inline">
			<input type='text' class="form-control" name='birth_year' value='<?=$ar_mem[birth_year];?>'> 년
			<input type='text' class="form-control" name='birth_month' value='<?=$ar_mem[birth_month];?>'>월
			<input type='text' class="form-control" name='birth_day' value='<?=$ar_mem[birth_day];?>'>일

			<select name='birthtype'>
				<option value='S' <? if($ar_mem[birthtype]=='S') { echo "selected";	}?>>양력</option>
				<option value='L' <? if($ar_mem[birthtype]=='L') { echo "selected";	}?>>음력</option>
			</select>
		</div>
	</td>
	</tr>
	<tr>
	<th>E-Mail</th>
	<td><input type='text' class="form-control" name='email' value='<?=$ar_mem[email];?>'></td>
	</tr>

	<tr>
	<th>SMS수신</th>
	<td>
		<label><input type='radio' name='smsser' value='Y' <? if($ar_mem[smsser]=='Y') { echo "checked";	}?>> 수신</label>
		<label><input type='radio' name='smsser' value='N' <? if($ar_mem[smsser]=='N') { echo "checked";	}?>> 수신안함</label>
	</td>
	</tr>

	<tr>
	<th>메일수신</th>
	<td>
		<label><input type='radio' name='mailser' value='Y' <? if($ar_mem[mailser]=='Y') { echo "checked";	}?>> 수신</label>
		<label><input type='radio' name='mailser' value='N' <? if($ar_mem[mailser]=='N') { echo "checked";	}?>> 수신안함</label>
	</td>
	</tr>
	
	<tr>
	<th rowspan='3'>주소</th>
	<td>
		<input type="text" name="zipcode" id="zipcode" value="<?=$ar_mem['zipcode'];?>" readonly="readonly" onclick="openDaumPostcode()"/>
	</td>
	</tr>
	<tr>
	<td><input type='text' class="form-control" name='addr1' id='addr1' size='40' value='<?=$ar_mem[addr1];?>' readonly="readonly" onclick="openDaumPostcode()"></td>
	</tr>
	<tr>
	<td><input type='text' class="form-control" name='addr2' id='addr2' size='40' value='<?=$ar_mem[addr2];?>'></td>
	</tr>
	

	<tr>
	<th>비밀번호변경</th>
	<td><input type='text' class="form-control" name='passwd' size='10' class='boxes'> [변경시에만 입력] <input type='checkbox' name='usesms' value='Y'>변경비번 SMS 전송 <span class="btn_white_xs btn_navy btn_top"><a href="javascript:change_rand();">비밀번호랜덤변경</a></span></td>
	</tr>
	
	<tr>
	<th>접속여부</th>
	<td><select class="uch" name='canconnect'>
	<option value='Y' <? if($ar_mem[canconnect]=='Y') { echo "selected";	}?>>접속허용</option>
	<option value='N' <? if($ar_mem[canconnect]=='N') { echo "selected";	}?>>접속차단</option>
	</select>
	</td>
	</tr>

	<tr>
	<th>등급변경</th>
	<td><select class="uch" name='ch_memgrade'>
	<?php
	
	
	$q = "Select * from shop_member_grades where group_idx='$ar_mem[mem_type]' order by grade_id asc";
	
	$r = mysqli_query($connect,$q);
	while($row = $st->fetch())
	{	
		if($row[grade_id]==$ar_mem[memgrade])
		{	echo "<option value='$row[grade_id]' selected>$row[grade_name]</option>";	}
		else
		{	echo "<option value='$row[grade_id]'>$row[grade_name]</option>";	}
	}
	?>
	</select>
	</td>
	</tr>
	<?
	if($ar_mem[mem_type]=='3')
	{
	?>
	<tr>
	<th>사용통화</th>
	<td><select name='usecur'>
			<option value=''>거래통화선택</option>
			<option value='USD' <? if($ar_mem[usecur]=='USD'){ echo "selected";	}?>>USD</option>
			<option value='CNY' <? if($ar_mem[usecur]=='CNY'){ echo "selected";	}?>>CNY</option>
			<option value='JPY' <? if($ar_mem[usecur]=='JPY'){ echo "selected";	}?>>JPY</option>
			<option value='KWON' <? if($ar_mem[usecur]=='KWON'){ echo "selected";	}?>>KWON</option>
			</select>
	</td>
	</tr>
	<?
	}
	?>


	</table>
	<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#modform">변경하기</button>
						
				</div>
			</div>

	</form><!-- // form[name="form1"] -->
	
	

	<div class="h3_wrap">
		<h3>* 회원정보 변경 로그</h3>
	</div>
	<table class="table table-bordered">
	<thead>
	<Tr>
	<th class=kor8>No</th>
	<th class=kor8>변경내역</th>
	<th class=kor8>처리자</th>
	<th class=kor8>날짜</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = "select * from shop_member_change where mem_idx='$idx' order by wdate asc";
	$r = mysqli_query($connect,$q);
	$cou = 1;
	while($row = $st->fetch())
	{
		$co = "";
		if(!($cou%2)) $co = "gray";
	?>
	<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
	<td><?=$cou;?></td>
	<td><?=$row[memo];?></td>
	<Td><?=$row[ch_name];?></td>
	<Td><?=date("Y-m-d H:i",$row[wdate]);?></td>
	
	</tr>
	<?php
		$cou++;
	}
	?>
	</tbody>
	</table>
						
							
						</div>
						<div class="tab-pane fade" id="tab6_2">
							 <table class="table table-bordered">
							<thead>
							<Tr>
								<th>주문번호</th>
								<th>주문일</th>
								<th>주문금액</th>
								<th>결제금액</th>
								<th>상태</th>
								<th>주문처</th>
							</tr>
							</thead>
							<tbody>
<?
$q = "SELECT * FROM shop_newmarketdb WHERE mem_idx='$idx' and dan!=''";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
?>
							<tr>	
								<td><a href="javascript:MM_openBrWindow('popup.php?code=order_nview&idx=<?=$row[idx];?>','order<?=$row[idx];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><? echo date("Ymd",$row['orderno'])."-".$row['idx']; ?></a></td>
								<td><?=$row['odate'];?></td>
								<td><?=number_format($row['account']/100);?></td>
								<td><?=number_format($row['use_account']/100);?></td>	
								<td>
									<?php
					switch ($row[dan]){
						case 1 : echo "  <span class='btn_white_xs btn_white'><a>주문접수</a></span>  "; break;
						case 2 : echo "  <span class='btn_white_xs btn_red'><a>결제확인</a></span>  "; break;
						case 3 : echo "  <span class='btn_white_xs btn_yellow'><a>상품준비중</a></span>  "; break;
						case 4 : echo "  <span class='btn_white_xs btn_navy'><a>부분배송</a></span>  "; break;
						case 5 : echo "  <span class='btn_white_xs btn_blue'><a>배송중</a></span>  "; break;
						case 6 : echo "  <span class='btn_white_xs btn_emerald'><a>거래완료</a></span>  "; break;
						case 7 : echo "  <span class='btn_white_xs btn_orange'><a>반품완료</a></span>  "; break;
						case 8 : echo "  <span class='btn_white_xs btn_pink'><a>주문취소</a></span>  "; break;
					}

				?>
							
								</td>
								<td><?=$g_ar_sitename[$row['pid']];?></td>
							</tr>
<?
}
?>
							</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="tab6_3">
							
							<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return foch();">
	<input type='hidden' name='mode' value='w'>
	<input type='hidden' name='idx' value='<?=$idx;?>'>

	<table class="table table-bordered">
	<tr>
	<th>현재적립금</th>
	<td><?=number_format($ar_mem[mempoints]/100);?></td>
	</tr>
	<tr>
	<th>적립금변경</th>
	<td>
		<input type='radio' name='ch_mode' value='1'> 적립
		<input type='radio' name='ch_mode' value='2'> 차감
	</td>
	</tr>
	<tr>
	<th>금액</th>
	<td><input type='text' class="form-control" name='account' size='10' class='boxes'></td>
	</tr>
	<tr>
	<th>변경사유</th>
	<td><textarea name='memo' cols='60' rows='5'></textarea></td>
	</tr>
	</table>
	<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#form1">변경하기</button>
						
				</div>
			</div>
	</form>


                            <table class="table table-bordered">
							<thead>
							<Tr>
								<th>No</th>
								<th>변경사유</th>
								<th>적립액</th>
								<th>사용액</th>
								<th>잔액</th>
								<th>변경일자</th>
								<th>처리</th>
							</tr>
							</thead>
							<tbody>
<?php
$q = "select * from shop_member_points where mem_idx='$idx'";
$q = $q . " order by idx desc";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{

?>
							<tr>
								<tD><?=$row['idx'];?></td>
								<td style="padding:3px;"><? if($row[memo]=='') { if($row['income']!=0) { echo "주문번호 : $row[market_idx] 적립"; } else { echo "주문번호 : $row[market_idx] 사용"; }	} else { echo nl2br($row[memo]);	}?></td>
								<Td><?=number_format($row[income]/100);?></tD>
								<Td><?=number_format($row[outcome]/100);?></tD>
								<Td><?=number_format($row[total]/100);?></tD>
								<td><?=$row[wdate_s];?> <?=$row[hour_s];?></td>
								<tD><?=$row[ch_name];?></td>
							</tr>
<?php
}
?>
							</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="tab6_4">
                            <form id="form2" name="form2" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return fochs();">
	<input type='hidden' name='mode' value='ws'>
	<input type='hidden' name='idx' value='<?=$idx;?>'>

	<table class="table table-bordered">
	<tr>
	<th>지급쿠폰</th>
	<td><select class="uch" name='coupen'>
	<option value=''>선택</option>
	<?php
	$q = "select * from shop_coupen";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())
	{	echo "<option value='$row[idx]'>$row[coupenname]</option>";	}
	?>
	</select>
	사유 : <input type='text' class="form-control" name='memo' size='30'>
	</td>
	</tr>
	</table>
	<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#form2">지급하기</button>
						
				</div>
			</div>
	</form>

<table class="table table-bordered">
	<thead>
	<tr> 
	<th>NO</th>
	<th>쿠폰명</th>
	<th>발행일</th>
	<th>유효기간</th>
	<th>할인</th>
	<th>사용여부</th>
	<th>발급자</th>
	<th>사유</th>
	<th></th>
	</tr>   
	</thead>
	<tbody>
<?php
$q = "select * from shop_coupen_mem where mem_idx='$idx'";
$st = $pdo->prepare($q);
$st->execute();
$cou = 1;
while($row = $st->fetch())
{
	$co = "";
	if(!($cou%2)) $co = "gray";

	$ar_coupen = sel_query_all("shop_coupen"," where idx='$row[coupen_idx]'");
?>
	<tr class='<?=$co;?>'> 
	<td><?=$cou;?></td>
	<td><?=$ar_coupen[coupenname];?></td>
	<Td><?=$row[mdate];?></td>
	<Td><?=$row[edate];?>까지</td>
	<td>
	<?php
	if($ar_coupen[actype]=='3')
	{	echo "배송비면제";	}
	else
	{
		echo number_format($ar_coupen[account]);
		if($ar_coupen[actype]=='1') { echo "원";	} else { echo "%";	}

	}
	?>
	</td>
	<td><? if($row[usedate]!='') { echo $row[usedate]."사용";	}?></td>
	<Td><?=$row[mname];?></td>
	<td><?=$row[memo];?></tD>
	<td>
	<?php
	if($row[usedate]=='')
	{
	?>
	<span class="btn_white_xs"><a href="javascript:delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=ds&c_idx=<?=$row[idx];?>&idx=<?=$idx;?>','삭제?');">삭제</a></span>
	<?php
	}
	?>
	</tr>
<?php
	$cou++;
}
?>
</tbody>
</table>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>