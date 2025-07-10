<?
if($han=='set_chkpass')	{
	
	
	if(!$_SESSION['member_index'])	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('NEEDLOGIN');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;	
	}
	
	$ar_member = sel_query_all("shop_member"," WHERE idx='$G_MEMIDX'");
	
	$passwd = trim($_REQUEST['passwd']);
	$user_passwds = array(md5($passwd));
	if(!in_array($ar_member['passwd'],$user_passwds))	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('WRONGPASS');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;	
	}
	
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
		$redata['pre_idx'] = $idx;
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
if($han=='set_addr')	{
	
	if(!$_SESSION['member_index'])	{
		$redata['res'] = 'nologin';
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;		
	}
	
	$value['mem_idx'] = $G_MEMIDX;
	$value['isbasic'] = $_REQUEST['isbasic'];
	if($value['isbasic'] != "Y")	{
		$value['isbasic'] = "N";	
	}	else	{
		$pdo->prepare("update shop_member_addrs set isbasic='N' where mem_idx='$G_MEMIDX'")->execute();
	}
	$value['name'] = addslashes($_REQUEST['name']);
	$value['delname'] = addslashes($_REQUEST['delname']);
	$value['delcp'] = addslashes($_REQUEST['delcp']);
	$value['delzip'] = addslashes($_REQUEST['delzip']);
	$value['deladdr1'] = addslashes($_REQUEST['deladdr1']);
	$value['deladdr2'] = addslashes($_REQUEST['deladdr2']);	
	insert("shop_member_addrs",$value);
	
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_addr')	{
	if(!$_SESSION['member_index'])	{
		$redata['res'] = 'nologin';
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;		
	}
	
	$q = "select * from shop_member_addrs where mem_idx='$G_MEMIDX' order by isbasic desc, name asc";

	$st = $pdo->prepare($q);
	$st->execute();
	
	$datas = [];
	while($row = $st->fetch())	{
		$datas[] = $row;
	}
	
	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
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
if($han=='chpasswd')	{
	$id = trim($_REQUEST['id']);
	$passwd = trim($_REQUEST['passwd']);


	$ar_member = sel_query_all("shop_member"," WHERE id='$id'");

	if(!$ar_member['idx'])	{
		$redata['res'] = 'error';
		$redata['resmsg'] = trscode('LOGIN5');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
		
	}
	

	$value['passwd'] = $passwd;
	update("shop_member",$value," where id='$ar_member[id]'");
	unset($value);
	
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
?>