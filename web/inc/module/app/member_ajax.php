<?php
if($han=='login')	{
	
	

	$id = trim($_REQUEST['id']);
	$passwd = trim($_REQUEST['passwd']);
	$url = $_REQUEST['geturl'];
	

	if($id=='outmember' || $id=='' || $passwd=='')	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('LOGIN4');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}

	$ar_member = sel_query_all("shop_member"," WHERE id='$id' AND memgroup='".$g_ar_init['site_member_group']."'");

	if(!$ar_member['idx'])	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('LOGIN5');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
		
	}
	
	$user_passwds = array(md5($passwd));

	if(!in_array($ar_member['passwd'],$user_passwds))	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('LOGIN5');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
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

	$redata['res'] = 'ok';
	$redata['datas'] = $ar_member;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='chpasswd')	{
	$id = trim($_REQUEST['id']);
	$passwd = trim($_REQUEST['passwd']);
	$newpasswd = trim($_REQUEST['newpasswd']);

	$ar_member = sel_query_all("shop_member"," WHERE id='$id'");

	if(!$ar_member['idx'])	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('LOGIN5');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
		
	}
	
	$user_passwds = array(md5($passwd));

	if(!in_array($ar_member['passwd'],$user_passwds))	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('LOGIN5');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}
	
	$value['passwd'] = $newpasswd;
	update("shop_member",$value," where id='$ar_member[id]'");
	unset($value);
	
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
if($han=='chpasswd2')	{
	$id = trim($_REQUEST['id']);

	$newpasswd = trim($_REQUEST['newpasswd']);

	$ar_member = sel_query_all("shop_member"," WHERE id='$id'");

	if(!$ar_member['idx'])	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('LOGIN5');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
		
	}

	
	$value['passwd'] = $newpasswd;
	update("shop_member",$value," where id='$ar_member[id]'");
	unset($value);
	
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
if($han=='prejoin')	{
	
	$id = $_REQUEST['id'];
	$passwd = $_REQUEST['passwd'];
	
	$q = "select * from shop_member where id='$id'";
	$st = $pdo->prepare($q);
	$st->execute();
	
	if($st->rowCount() == 0)	{
		
		$q = "select * from shop_member_pre where id='$id'";
		$st = $pdo->prepare($q);
		$st->execute();
		if($st->rowCount() == 0)	{
			$value['id'] = $id;
			$value['passwds'] = $passwd;
			$value['wdate'] = date("Y-m-d H:i:s");
			insert("shop_member_pre",$value);
			$idx = $pdo->lastInsertId();
		}
		else	{
			$ar_data = sel_query_all("shop_member_pre"," where id='$id'");
			
			$value['id'] = $id;
			$value['passwds'] = $passwd;
			$value['wdate'] = date("Y-m-d H:i:s");
			update("shop_member_pre",$value," where idx='$ar_data[idx]'");
			$idx = $ar_data['idx'];
		}
		$redata['res'] = 'ok';
		$redata['preidx'] = $idx;
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;	
	}	else	{
		
		$redata['res'] = 'error';
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;	
	}
		
}
if($han=='appjoin')	{
	
	$pre_idx = $_REQUEST['pre_idx'];
	$ar_data = sel_query_all("shop_member_pre"," where idx='$pre_idx'");
	
	$ci = $_REQUEST['ci'];
	$di = $_REQUEST['di'];
		
	$value['name'] = $_REQUEST['name'];
	$value['id'] = $ar_data['id'];
	$value['passwd'] = $ar_data['passwds'];
	$value['sex'] = $_REQUEST['sex'];
	$value['birthday'] = $_REQUEST['birth'];
	$value['cp'] = $_REQUEST['cp'];
	$value['ci'] = $ci;
	$value['di'] = $di;
	$value['memgroup'] = 1;
	$value['canconnect'] = "Y";
	$value['pid'] = 1;
	$value['fid'] = 1;
	$value['memgrade'] = 100;
	$value['mailser'] = "Y";
	$value['smsser'] = "Y";
	$value['signdate'] = date("Y-m-d H:i:s",time());
	insert("shop_member",$value);
	unset($value);
		
	$stmt = $pdo->prepare("DELETE FROM shop_member_pre WHERE idx = :idx");
	$stmt->execute([':idx' => $pre_idx]);	
	
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;	
}
if($han=='checkmember')	{
	
	$cp = $_REQUEST['cp'];
	$ar_member = sel_query_all("shop_member"," WHERE cp='$cp'");
	if($ar_member['idx'])	{
		$redata['res'] = 'ok';
		$redata['datas'] = $ar_member;
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}	else	{
		$redata['res'] = 'error';
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}
	
}
?>