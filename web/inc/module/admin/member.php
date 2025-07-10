<?php
if($han=='adminlogin')	{


	$id = trim($_REQUEST['id']);
	$passwd = trim($_REQUEST['passwd']);
	if(isset($_REQUEST['url'])){
		$url = $_REQUEST['url'];	
	}
	
	
	
	if($id=='outmember' || $id=='' || $passwd=='')	{
		show_message("로그인하실수 없습니다.",true);
		exit;
	}
	
	$ar_member = sel_query_all("shop_member"," WHERE id='$id'");

	if(!$ar_member["idx"])	{
		show_message("아이디 혹은 비밀번호가 잘못되었습니다",true);
		exit;
	}
	if($ar_member["amemgrade"]==0)	{
		show_message("권한이없습니다",true);
		exit;
	}

	$user_passwds = array(hash("sha256", md5($passwd)), md5($passwd));
	


	if(!in_array($ar_member['passwd'],$user_passwds))	{
		show_message("비밀번호가 잘못되었습니다",true);
		exit;
	}
	
	$_SESSION['member_index'] = $ar_member['idx'];
	$_SESSION['member_id'] = $ar_member['id'];
	$_SESSION['member_name'] = $ar_member['name'];


	$value["mem_idx"] = $ar_member['idx'];
	$value["ldate"] = date("Y-m-d H:i:s",time());
	$value["lip"] = $G_NIP;
	insert("shop_member_login",$value);
	unset($value);
	
	$value["lastlogin"] = date("Y-m-d H:i:s",time());
	$value["lastip"] = $G_NIP;
	update("shop_member",$value," where idx='".$_SESSION['member_index']."'");
	unset($value);
	
	

	if(!$url)	{
		$url = "/main.php";
	}
	move_link($url);
	exit;
}
if($han=='adminlogout')	{
	


	session_destroy();


	move_link('/');
	exit;
}
?>