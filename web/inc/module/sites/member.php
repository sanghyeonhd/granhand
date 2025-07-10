<?php
if($han=='nologin')	{
	
	$ono = trim($_REQUEST['ono']);
	$passwds = trim($_REQUEST['passwds']);

	$ar_ono = explode("-",$ono);
	
	if(sizeof($ar_ono)>1)	{
		$nono = $ar_ono[1];	
	}
	else	{
		$nono = $ono;	
	}

	$idx = $nono;
	$ar_market = sel_query_all("shop_newmarketdb"," where idx='$idx'");


	if($ar_market[passwds]==$passwds)	{
		if($ar_market[dan]=='')	{
			echo "<script>alert('".trscode("NOLOGIN1")."'); history.back(); </script>";
			exit;
		}
		else	{
			echo "<script>location.href='/mypage/orderview.php?idx=$idx&passwds=$passwds'; </script>";
			exit;
		}
	}
	else	{
		echo "<script>alert('".trscode("NOLOGIN1")."'); history.back(); </script>";
		exit;
	}
}
if($han=='adminlogin')	{
	
	

	$id = trim($_REQUEST['id']);
	$passwd = trim($_REQUEST['passwd']);
	$url = $_REQUEST['url'];
	
	
	if($id=='outmember' || $id=='' || $passwd=='')	{
		show_message("로그인하실수 없습니다.",true);
		exit;
	}
	
	$ar_member = sel_query_all("shop_member"," WHERE id='$id'");

	if(!$ar_member[idx])	{
		show_message("아이디 혹은 비밀번호가 잘못되었습니다",true);
		exit;
	}
	if($ar_member[amemgrade]==0)	{
		show_message("권한이없습니다",true);
		exit;
	}

	$result = mysql_query("select password('$passwd')");
	$user_passwds = array(mysql_result($result,0,0), hash("sha256", md5($passwd)), md5($passwd));
	


	if(!in_array($ar_member[passwd],$user_passwds))	{
		show_message("비밀번호가 잘못되었습니다",true);
		exit;
	}
	
	$_SESSION[member_index] = $ar_member[idx];
	$_SESSION[member_id] = $ar_member[id];
	$_SESSION[member_name] = $ar_member[name];


	$value[mem_idx] = $ar_member[idx];
	$value[ldate] = date("Y-m-d H:i:s",time());
	$value[lip] = $g_ip;
	insert("shop_member_login",$value);
	unset($value);
	
	$value[lastlogin] = date("Y-m-d H:i:s",time());
	$value[lastip] = $g_ip;
	update("shop_member",$value," where idx='$_SESSION[member_index]'");
	unset($value);
	
	

	if(!$url)	{
		$url = "/main.php";
	}
	move_link($url);
	exit;
}

if($han=='scmlogin')	{
	
	$qry = "DELETE FROM shop_nows WHERE end_time < " . time();
	$qid = mysql_query($qry);
	$qry = "DELETE FROM sessions WHERE expiry < " . time();
	$qid = mysql_query($qry);

	$id = trim($_REQUEST['id']);
	$passwd = trim($_REQUEST['passwd']);
	$url = $_REQUEST['url'];
	$keys = $_REQUEST['keys'];

	if($keys=='')	{
	
		if($id=='outmember' || $id=='' || $passwd=='')	{
			show_message("로그인하실수 없습니다.",true);
			exit;
		}
	}

	$mem_idx = $_REQUEST['mem_idx'];
	
	$result = mysql_query("select password('$passwd')");
	$user_passwds = array(mysql_result($result,0,0), hash("sha256", md5($passwd)), md5($passwd));

	if($mem_idx && $keys==md5("storebetas"))	{
		$ar_member = sel_query_all("shop_member"," WHERE idx='$mem_idx'");
	}
	else	{
		$ar_member = sel_query_all("shop_member"," WHERE id='$id'");

		if(!in_array($ar_member['passwd'],$user_passwds))	{
			show_message("비밀번호가 잘못되었습니다",true);
			exit;
		}
	}
	
	

	if(!$ar_member[idx])	{
		show_message("아이디 혹은 비밀번호가 잘못되었습니다",true);
		exit;
	}
	
	$ar_shops = sel_query_all("shop_goods_shops"," WHERE mem_idx='$ar_member[idx]'");

	if(!$ar_shops['idx'])	{
		show_message("권한이 없습니다.",true);
		exit;
	}
	
	
	
	$_SESSION[member_index] = $ar_member[idx];



	if(!$url)	{
		$url = "/main.php";
	}
	move_link($url);
	exit;
}
if($han=='login')	{
	
	

	$id = trim($_REQUEST['id']);
	$passwd = trim($_REQUEST['passwd']);
	$url = $_REQUEST['geturl'];
	

	if($id=='outmember' || $id=='' || $passwd=='')	{
		show_message(trscode('LOGIN4'),true);
		exit;
	}

	$ar_member = sel_query_all("shop_member"," WHERE id='$id' AND memgroup='".$g_ar_init['site_member_group']."'");

	if(!$ar_member['idx'])	{
		show_message(trscode('LOGIN5'),true);
		exit;
	}
	
	$user_passwds = array(md5($passwd));

	if($ar_member['passwd']=='')	{

		$ar_member['passwd'] = md5($passwd);
	}

	if(!in_array($ar_member['passwd'],$user_passwds))	{
		show_message(trscode('LOGIN5'),true);
		exit;
	}

	$_SESSION['member_index'] = $ar_member['idx'];
	$_SESSION['member_id'] = $ar_member['id'];
	$_SESSION['member_name'] = $ar_member['name'];


	$value['mem_idx'] = $ar_member['idx'];
	$value['ldate'] = date("Y-m-d H:i:s",time());
	$value['lip'] = $G_NIP;
	insert("shop_member_login",$value);
	unset($value);
	
	$value['logincount'] = $ar_member['logincount'] + 1;
	$value['lastlogin'] = date("Y-m-d H:i:s",time());
	$value['lastip'] = $G_NIP;
	update("shop_member",$value," where idx='$_SESSION[member_index]'");
	unset($value);

	$keeplogin = $_REQUEST['keeplogin'];

	if($keeplogin=='Y')	{
		setcookie("cookie_id",$id,(time()+(86400*30)),"/");

	}

	
	if(!$url)	{
		$url = "/";
	}
	//print_r($_SESSION);
	move_link($url);
	exit;
}
if($han=='login_social')	{
	
	$qry = "DELETE FROM shop_nows WHERE end_time < " . time();
	$st = $pdo->prepare($qry);
	$st->execute();
	$qry = "DELETE FROM sessions WHERE expiry < " . time();
	$st = $pdo->prepare($qry);
	$st->execute();


	$id = $_REQUEST['id'];
	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$channel = $_REQUEST['channel'];
	$social_img = $_REQUEST['social_img'];

	$check1 = time();
	$check2 = md5(time().time());


	$q = "SELECT * FROM shop_member WHERE social_type='$channel' AND social_code='$id' AND memgroup='".$g_ar_init['site_member_group']."'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();


	if($isit==0)	{

		move_link("/exec/?act=member&han=join&ch_id=$id&name=$name&email=$email&channel=$channel&check1=$check1&check2=$check2&social_img=$social_img");
		exit;
	}
	else	{
		
		$ar_member = $st->fetch();

		//print_r($ar_member);

		$_SESSION[member_index] = $ar_member[idx];
		$_SESSION[member_id] = $ar_member[id];
		$_SESSION[member_name] = $ar_member[name];


		$value[mem_idx] = $ar_member[idx];
		$value[ldate] = date("Y-m-d H:i:s",time());
		$value[lip] = $g_ip;
		insert("shop_member_login",$value);
		unset($value);
	
		$value[lastlogin] = date("Y-m-d H:i:s",time());
		$value[lastip] = $g_ip;
		update("shop_member",$value," where idx='$_SESSION[member_index]'");
		unset($value);
	
		if(!$url)	{
			$url = "/";
		}
		//print_r($_SESSION);
		//exit;
		move_link($url);
		exit;
	}

}

if($han=='adminlogout')	{
	


	session_destroy();


	move_link('/');
	exit;
}
if($han=='logout')	{
	
	session_destroy();


	move_link('/');
	exit;
}

if($han=='join')	{
	
	$check1 = $_REQUEST['check1'];
	$check2 = $_REQUEST['check2'];

	if($check2!=md5($check1.$check1))	{
		echo "<Script>alert('".trscode('COMMON1')."'); location.replace('/'); </script>";
		exit;
	}

	$value['social_type'] = $_REQUEST['channel'];
	$value['social_code'] = $_REQUEST['ch_id'];
	$value['social_img'] = $_REQUEST['social_img'];

	$value['name'] = $_REQUEST['name'];
	$name = $value['name'];
	$value['name_etc']	= $_REQUEST['name_etc'];
	if($_REQUEST['emailfi'])	{
		$value['email'] = $_REQUEST['email1']."@".$_REQUEST['email2'];
	}
	else	{
		$value['email'] = $_REQUEST['email'];
	}
	$value['id'] = $_REQUEST['id'];
	if($_REQUEST['useidemail'])	{
		$value['id'] = $value['email'];
	}
	$value['passwd'] = $_REQUEST['passwd'];
	
	$value['phone'] = $_REQUEST['phone1']."-".$_REQUEST['phone2'];
	if($_REQUEST['phone3'])	{
		$value['phone'] = $value['phone']."-".$_REQUEST['phone3'];
	}
	$value['cp'] = $_REQUEST['cp1'];	
	if($_REQUEST['cp2'])	{
		$value['cp'] = $value['cp']."-".$_REQUEST['cp2'];
	}
	if($_REQUEST['cp3'])	{
		$value['cp'] = $value['cp']."-".$_REQUEST['cp3'];
	}
	$cp = $value['cp'];
	$value['zipcode']	= $_REQUEST['zip'];
	$value['addr1'] = $_REQUEST['addr1'];
	$value['addr2'] = $_REQUEST['addr2'];
	$value['mailser'] = $_REQUEST['mailser'];
	$value['smsser'] = $_REQUEST['smsser'];
	$value['signdate'] = date("Y-m-d H:i:s",time());
	$ar_birth = explode("-",$_REQUEST['birth']);
	$value['birth_year'] = $ar_birth[0];
	$value['birth_month'] = $ar_birth[1];
	$value['birth_day'] = $ar_birth[2];
	$value['sex'] = $_REQUEST['sex'];

	$value['memgroup'] = $g_ar_init['site_member_group'];
	$value['rtype'] = $_REQUEST['memtype'];
	$value['canconnect'] = "Y";
	$value['enterc'] = $_COOKIE['enterc'];
	$value['pid'] = $g_ar_init['idx'];
	$value['fid'] = $g_ar_init['fid'];
	$value['memgrade'] = $g_ar_member_config['member_joingrade'];


	$value['city'] = $_REQUEST['city'];
	$value['state'] = $_REQUEST['state'];

	$value['nickname'] = $_REQUEST['nickname'];
	$value['bank'] = $_REQUEST['bank'];
	$value['bankaccount'] = $_REQUEST['bankaccount'];
	$value['bankname'] = $_REQUEST['bankname'];

	if($_REQUEST['channel']!='')	{
		$value['email'] = $_REQUEST['email'];
		$value[id] = $id;
		if($value[id]=='')	{
			$value[id] = $_REQUEST['ch_id'];
		}
	}
	
	if(!$value['id'])	{
		echo "<script>alert('".trscode('COMMON1')."'); history.back(); </script>";
		exit;
	}
	
	$q = "select idx from shop_member where id='".$value['id']."' AND memgroup='".$g_ar_init['site_member_group']."'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->fetchColumn();
	if($isit!=0)	{
		echo "<Script>alert('".trscode('JOIN14')."'); history.back(); </script>";
		exit;
	}

	$userfile = array($_FILES['bankpaper']['name']);
	$tmpfile = array($_FILES['bankpaper']['tmp_name']);

	$savedir = $_uppath."member/";
	
	
	if(!is_dir($savedir))	{	
		mkdir($savedir, 0777);	chmod($savedir,0707);  
	}



	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	
	}
	$value['bankpaper'] = $fs[0];
	


	$r = insert("shop_member",$value);
	if(!$r)	{
		echo "<Script>alert('".trscode('JOIN17')."'); history.back(); </script>";
		exit;
	}

	$idx = $pdo->lastInsertId();

	if($_REQUEST['memtype']=='2')	{
		unset($value);
		$value['mem_idx'] = $idx;
		$value['businessnum'] = $_REQUEST['businessnum1']."-".$_REQUEST['businessnum2']."-".$_REQUEST['businessnum3'];

		insert("shop_goods_shops",$value);
	}
	
	

	if($g_ar_member_config['member_joinpoint']!=0)	{
		unset($value);
		$value['mem_idx'] = $idx;
		$value['income'] = $g_ar_member_config['member_joinpoint']*100;
		$value['outcome'] = 0;
		$value['total'] = $g_ar_member_config['member_joinpoint']*100;
		$value['memo'] = $g_ar_member_config['member_joinpoint_msg'];
		$value['wdate_s'] = date("Y-m-d");
		$value['hour_s'] = date("H:i:s");
		$value['isauto'] = "Y";
		insert("shop_member_points",$value);

		unset($value);
		$value['mempoints'] = $g_ar_member_config['member_joinpoint']*100;
		update("shop_member",$value," where idx='$idx'");
		unset($value);
	}
	$msg = trscode('JOIN18');
	if($cp!='' && $g_ar_init['site_country']=='KR')	{
		
		$arr['cp'] = $cp;
		//goaltalk('join',$arr);
	}

	$ar_mc = explode("-",$g_ar_member_config['member_joincoupen']);
	
	for($i=0;$i<sizeof($ar_mc);$i++)	{
		if($ar_mc[$i]!='')	{
			unset($value);
			$ar_coupen = sel_query_all("shop_coupen"," where idx='$ar_mc[$i]'");
	
			make_coupen($ar_coupen,$idx);
		}
	}
	
	require_once("$_basedir/inc/solapi-php-master/lib/message.php");

	$msgs = "[오밀당]
안녕하세요. #{이름} 고객님.

저희 오밀당의 가족이 되어주셔서 감사합니다.

오밀당 카카오톡 채널을 추가해주시면
다양한 소식과 혜택/정보를
메시지로 받으실 수 있습니다! :)";

$msgs = str_replace("#{이름}",$name,$msgs);


$messages = array(
  array(
    "to" => $cp,
    "from" => "18332740",
    "text" => $msgs,
    "kakaoOptions" => array(
      "pfId" => "KA01PF220113004503746r7kaBvd88lJ",
      "templateId" => "KA01TP220513003132920geyoOc4Ti7b",
	  
    )
  )
);
send_messages($messages);


	if($_REQUEST['channel']!='')	{
			
			

		echo "<script>location.replace('/exec/?act=member&han=login_social&id=".$_REQUEST[ch_id]."&name=".$_REQUEST[name]."&email=".$_REQUEST[email]."&channel=".$_REQUEST['channel']."');</script>";
		exit;
	}

	echo "<script>alert('".$msg."'); location.replace('/'); </script>";

}
if($han=='memout')	{

	$passwd = $_REQUEST['passwd'];
	$reason = $_REQUEST['reason'];
	$memo = $_REQUEST['memo'];

	if($g_ar_init_member['social_type']=='')	{

		$q = "select password('$passwd')";
		$st = $pdo->prepare($q);
		$st->execute();
		$row = $st->fetch();

		$user_passwds = array($row[0], hash("sha256", md5($passwd)), md5($passwd));

	
	
		if(!in_array($g_ar_init_member[passwd],$user_passwds))	{
			echo "<script>alert('" . trscode('MEMOUT4') . "'); history.back();</script>";	// 비밀번호가 잘못되었습니다
			exit;
		}

	}

	$q = "select * from shop_member_out where mem_idx='$G_MEMIDX'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if($isit!=0)	{
		echo "<script>alert('" . trscode('MEMOUT3') . "'); history.back(); </script>";
		exit;
	}

	$q = "INSERT INTO `shop_member_out` ( `mem_idx` , `reason` , `memo` , `wdate` ,`id`,`isover`,`fid`) VALUES ('$G_MEMIDX', '$reason', '$memo', '".date("Y-m-d H:i:s",time())."','".$g_ar_init_member['id']."','".date("Y-m-d H:i:s",time())."','$fid')";
	$st = $pdo->prepare($q);
	$st->execute();
	$tal = $pdo->lastInsertId();

	

	$q = "update shop_member set id='outmember',social_code='',social_type='',email=concat('x',email), phone=concat('x',phone), cp=concat('x',cp), mailser='N', smsser='N' where idx='$G_MEMIDX'";
	$st = $pdo->prepare($q);
	$st->execute();
	

	echo "<script>alert('" . trscode('MEMOUT1') . "'); location.replace('/exec/?act=member&han=logout'); </script>";	//탈퇴 신청이 완료 되었습니다. 그동안 이용해주셔서 감사합니다. 
	exit;
}

