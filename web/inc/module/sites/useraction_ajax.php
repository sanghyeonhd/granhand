<?php
if($han=='set_buy')	{
	
	$goods_idx = $_REQUEST['goods_idx'];
	$op1 = $_REQUEST['op1'];
	$op2 = $_REQUEST['op2'];
	$op3 = $_REQUEST['op3'];
	$ea = $_REQUEST['ea'];
	if(!$ea || !is_numeric($ea))	{
		$ea = "1";	
	}
	
	if(isset($_SESSION['member_index']))	{
		$value['mem_idx'] = $G_MEMIDX;	
		
	}
	else	{
		if(!isset($_COOKIE['cmem']))	{	
			$cookie_member = session_id();
			setcookie("cmem",$cookie_member,0,"/");	
		}
		else	{
			$cookie_member = $_COOKIE['cmem'];	
		}
		$value['nomem'] = $cookie_member;
	}
	$value['sfid'] = $g_ar_init['fid'];
	$value['spid'] = $g_ar_init['idx'];
	
	$value['goods_idx'] = $goods_idx;
	$value['op1'] = $op1;
	$value['op2'] = $op2;
	$value['op3'] = $op3;
	$value['ea'] = $ea;
	$value['sdate'] = date("Y-m-d H:i:s",time());
	if(isset($enterc))	{
		$value['enterc'] = $enterc;
	}
	if(isset($enterk))	{
		$value['enterk'] = $enterk;
	}
	if(isset($ent))	{
		$value['ent'] = $ent;
	}
	
	$value['gtype'] = "1";
	insert("shop_newbasket_tmp",$value);
	$basket_idx = $pdo->lastInsertId();
	unset($value);

	$redata['basket_idxs'] = $basket_idx."-";
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_cart')	{
	
	$goods_idx = $_REQUEST['goods_idx'];
	$op1 = $_REQUEST['op1'];
	$op2 = $_REQUEST['op2'];
	$op3 = $_REQUEST['op3'];
	$ea = $_REQUEST['ea'];
	if(!$ea || !is_numeric($ea))	{
		$ea = "1";	
	}

	$q = "select * from shop_newbasket_tmp where goods_idx='$goods_idx' and op1='$op1' and op2='$op2' and op3='$op3'";
	if(isset($_SESSION['member_index']))	{
		$q = $q . " AND mem_idx='".$G_MEMIDX."'";
	}
	else	{
		if(!isset($_COOKIE['cmem']))	{	
			$cookie_member = session_id();
			setcookie("cmem",$cookie_member,0,"/");	
		}
		else	{
			$cookie_member = $_COOKIE['cmem'];	
		}

		$q = $q . " AND nomem='$cookie_member'";
	}
	
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowcount();
	
	if($isit==0)	{
		
		if(isset($_SESSION['member_index']))	{
			$value['mem_idx'] = $G_MEMIDX;	
		
		}
		else	{
			if(!isset($_COOKIE['cmem']))	{	
				$cookie_member = session_id();
				setcookie("cmem",$cookie_member,0,"/");	
			}
			else	{
				$cookie_member = $_COOKIE['cmem'];	
			}
			$value['nomem'] = $cookie_member;
		}
		$value['sfid'] = $g_ar_init['fid'];
		$value['spid'] = $g_ar_init['idx'];
	
		$value['goods_idx'] = $goods_idx;
		$value['op1'] = $op1;
		$value['op2'] = $op2;
		$value['op3'] = $op3;
		$value['ea'] = $ea;
		$value['sdate'] = date("Y-m-d H:i:s",time());
		if(isset($enterc))	{
			$value['enterc'] = $enterc;
		}
		if(isset($enterk))	{
			$value['enterk'] = $enterk;
		}
		$value['ent'] = $ent;
		$value['gtype'] = "1";
		insert("shop_newbasket_tmp",$value);
		unset($value);
	}

	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}

if($han=='set_cart_multi')	{
	
	$goods_idx = $_REQUEST['goods_idx'];
	$ar_op1 = explode("|R|",$_REQUEST['op1']);
	$ar_op2 = explode("|R|",$_REQUEST['op2']);
	$ar_op3 = explode("|R|",$_REQUEST['op3']);
	$ar_ea = explode("|R|",$_REQUEST['ea']);
	$selcou = $_REQUEST['selcou'];
	$selcou = $selcou + 1;

	
	for($i=0;$i<$selcou;$i++)	{
		
		if($ar_ea[$i]!='')	{
			
			$q = "select * from shop_newbasket_tmp where goods_idx='$goods_idx' and op1='".$ar_op1[$i]."' and op2='".$ar_op2[$i]."' and op3='".$ar_op3[$i]."' and isdirect='N'";
			if(isset($_SESSION['member_index']))	{
				$q = $q . " AND mem_idx='".$G_MEMIDX."'";
			}
			else	{
				if(!isset($_COOKIE['cmem']))	{	
					$cookie_member = session_id();
					setcookie("cmem",$cookie_member,0,"/");	
				}
				else	{
					$cookie_member = $_COOKIE['cmem'];	
				}

				$q = $q . " AND nomem='$cookie_member'";
			}
	
			$st = $pdo->prepare($q);
			$st->execute();
			$isit = $st->rowcount();

			if($isit==0)	{
				if(isset($_SESSION['member_index']))	{
					$value['mem_idx'] = $G_MEMIDX;	
				
				}
				else	{
					if(!isset($_COOKIE['cmem']))	{	
						$cookie_member = session_id();
						setcookie("cmem",$cookie_member,0,"/");	
					}
					else	{
						$cookie_member = $_COOKIE['cmem'];	
					}
					$value['nomem'] = $cookie_member;
				}
				$value['sfid'] = $g_ar_init['fid'];
				$value['spid'] = $g_ar_init['idx'];
	
				$value['goods_idx'] = $goods_idx;
				$value['op1'] = $ar_op1[$i];
				$value['op2'] = $ar_op2[$i];
				$value['op3'] = $ar_op3[$i];
				$value['ea'] = $ar_ea[$i];
				$value['sdate'] = date("Y-m-d H:i:s",time());
				if(isset($enterc))	{
					$value['enterc'] = $enterc;
				}
				if(isset($enterk))	{
					$value['enterk'] = $enterk;
				}
				$value['ent'] = $ent;
				$ar_goods = sel_query_all("shop_goods"," WHERE idx='".$goods_idx."'");

				$value['gtype'] = $ar_goods['gtype'];
				insert("shop_newbasket_tmp",$value);
				unset($value);
			}
			else	{
				$row = $st->fetch();

				$value['ea'] = $row['ea'] +  $ar_ea[$i];
				update("shop_newbasket_tmp",$value," WHERE idx='$row[idx]'");
				unset($value);
			}
			
		}

	}


	
	
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_buy_multi' || $han=='set_gift_multi')	{
	
	$goods_idx = $_REQUEST['goods_idx'];
	$ar_op1 = explode("|R|",$_REQUEST['op1']);
	$ar_op2 = explode("|R|",$_REQUEST['op2']);
	$ar_op3 = explode("|R|",$_REQUEST['op3']);
	$ar_ea = explode("|R|",$_REQUEST['ea']);
	$selcou = $_REQUEST['selcou'];
	$selcou = $selcou + 1;

	
	for($i=0;$i<$selcou;$i++)	{
		
		if($ar_ea[$i]!='')	{
			
			
			
			if(isset($_SESSION['member_index']))	{
				$value['mem_idx'] = $G_MEMIDX;	
			
			}
			else	{
				if(!isset($_COOKIE['cmem']))	{	
					$cookie_member = session_id();
					setcookie("cmem",$cookie_member,0,"/");	
				}
				else	{
					$cookie_member = $_COOKIE['cmem'];	
				}
				$value['nomem'] = $cookie_member;
			}
			$value['sfid'] = $g_ar_init['fid'];
			$value['spid'] = $g_ar_init['idx'];
	
			$value['goods_idx'] = $goods_idx;
			$value['op1'] = $ar_op1[$i];
			$value['op2'] = $ar_op2[$i];
			$value['op3'] = $ar_op3[$i];
			$value['ea'] = $ar_ea[$i];
			$value['sdate'] = date("Y-m-d H:i:s",time());
			if(isset($enterc))	{
				$value['enterc'] = $enterc;
			}
			if(isset($enterk))	{
				$value['enterk'] = $enterk;
			}
			$value['ent'] = $ent;

			$ar_goods = sel_query_all("shop_goods"," WHERE idx='".$goods_idx."'");

			$value['gtype'] = $ar_goods['gtype'];
			$value['isdirect'] = "Y";
			insert("shop_newbasket_tmp",$value);
			$basket_idx = $basket_idx . $pdo->lastInsertId() . "-";
			unset($value);

		}
	}


	
	$redata['basket_idxs'] = $basket_idx;
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}

if($han=='del_todayall')	{

	mysql_query("DELETE FROM shop_view_today WHERE view_idx='$G_STIDX'");


	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='del_today')	{

	$str_idx = explode("|R|",$_REQUEST['str_idx']);

	for($i=0;$i<sizeof($str_idx);$i++)	{
		
		if($str_idx[$i]!='')	{
			mysql_query("DELETE FROM shop_view_today WHERE idx='".$str_idx[$i]."'");
		}

	}

	


	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_addwish')	{

	if(!$_SESSION['member_index'])	{
		$redata['res'] = 'error';
		$redata['resmsg'] = "로그인하셔야합니다";
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;	
	}

	$idx = $_REQUEST['idx'];
	$stypes = $_REQUEST['stypes'];

	$q = "select * from shop_wish where stypes='$stypes' and mem_idx='$G_MEMIDX' and goods_idx='$idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	if($st->rowCount()!=0){
		
		$pdo->prepare("DELETE from shop_wish where stypes='$stypes' and mem_idx='$G_MEMIDX' and goods_idx='$idx'")->execute();

		$q = "select * from shop_wish where stypes='$stypes' and goods_idx='$idx'";
		$st = $pdo->prepare($q);
		$st->execute();
		$redata['cous'] = $st->rowCount();
		
		$redata['res'] = 'ok2';
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;	
	}
	else	{

		$value['mem_idx'] = $G_MEMIDX;
		$value['goods_idx'] = $idx;
		$value['stypes'] = $stypes;
		$value['sdate'] = date("Y-m-d H:i:s");
		insert("shop_wish",$value);

		$q = "select * from shop_wish where stypes='$stypes' and goods_idx='$idx'";
		$st = $pdo->prepare($q);
		$st->execute();

		$redata['res'] = 'ok1';
		$redata['cous'] = $st->rowCount();
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;	
	}
}
if($han=='set_ea')	{
	
	$idx = $_REQUEST['idx'];
	$value['ea'] = $_REQUEST['ea'];
	update("shop_newbasket_tmp",$value," WHERE idx='$idx'");

	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;	
}
if($han=='set_contact')	{

	$value['name'] = $_REQUEST['name'];
	$value['email'] = $_REQUEST['email'];
	$value['cp'] = $_REQUEST['cp'];
	$value['subject'] = $_REQUEST['subject'];
	$value['memo'] = $_REQUEST['memo'];
	$value['wdate'] = date("Y-m-d H:i:s");
	insert("shop_contact",$value);

	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;	
}
?>