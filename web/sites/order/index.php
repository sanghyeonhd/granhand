<?php
//ini_set("display_errors", 1);
require_once ("../../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_sitet.php";

if($_REQUEST['act']=='order_step1')	{

	if(isset($_REQUEST['basket_idxs']))	{
		$basket_idxs = $_REQUEST['basket_idxs'];
	}
	
	$mode = "";
	if(isset($_REQUEST['mode']))	{
		$mode = $_REQUEST['mode'];
	}
	
	$buymode = "";
	if(isset($_REQUEST['buymode']))	{
		$buymode = $_REQUEST['buymode'];
	}

	if(isset($_SESSION['member_index']))	{	
		if(isset($_COOKIE['cmem']))	{
			$cmem = $_COOKIE['cmem'];
			$q = "update shop_newbasket_tmp set mem_idx='".$G_MEMIDX."',nomem='' where nomem='$cmem'";
			$st = $pdo->prepare($q);
			$st->execute();
		}
		if($buymode == 'gift')	{
			echo "<script>location.replace('/order/?act=order_step2g&basketindex=$basket_idxs'); </script>";
		}	else	{
			echo "<script>location.replace('/order/?act=order_step2&basketindex=$basket_idxs'); </script>";	
		}
		
	}	else	{
		
		$url = urlencode($G_NOWURL) ."&buymode=$buymode";
		echo "<script>location.replace('/member/?act=login&geturl=$url');</script>";
	}
}
if($_REQUEST['act']=='cart')	{
	
	$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : "";
	if($mode=='del'){
		$str = $_REQUEST['str'];
		$str = explode("|R|",$str);

		for($i=0;$i<sizeof($str);$i++)	{
			if($str[$i]!='')	{
				$q = "delete from shop_newbasket_tmp where idx='$str[$i]'";
				$st = $pdo->prepare($q);
				$st->execute();
				
			}
		}
		echo "<script>location.replace('/order/?act=cart'); </script>";
		exit;
	}
	
	if(isset($_SESSION['member_index']))	{
		if($_COOKIE['cmem'])	{
			$cmem = $_COOKIE['cmem'];
			$q = "update shop_newbasket_tmp set mem_idx='".$G_MEMIDX."',nomem='' where nomem='$cmem'";
			$st = $pdo->prepare($q);
			$st->execute();

		}	
		$q = "select * from shop_newbasket_tmp where mem_idx='".$G_MEMIDX."' and set_idx='0' and sfid='".$g_ar_init['fid']."' and isdirect='N' order by		idx asc";
	}
	else	{	
		if(isset($_COOKIE['cmem']))	{
			$cmem = $_COOKIE['cmem'];
			$q = "select * from shop_newbasket_tmp where nomem='$cmem' and set_idx='0' and sfid='".$g_ar_init['fid']."' and isdirect='N' order by idx	asc";	
		}
	}

	$st = $pdo->prepare($q);
	$st->execute();
	$basket_count = $st->rowCount();

	$cart['totalcou'] = 0;
	$cart['totalaccount'] = 0;
	$cartlist = [];
	while($row = $st->fetch())	{

		$ar_goods = sel_query_all("shop_goods"," WHERE idx='".$row['goods_idx']."'");
		
		if($ar_goods['isopen']!='2')	{
			continue;
		}

		
		$row['gname'] = $ar_goods['gname'];

		$row['gcode'] = $ar_goods['gcode'];
		$row['mainimg'] = $ar_goods['simg1'];
		$row['links'] = "/shop/?act=view&idx=".$row['goods_idx'];

		$ar_maccount = get_newaccount($ar_goods);

		
	
		$op_str = "";
		if($row['op1']!='')	{
			$ar_op1 = sel_query_all("shop_goods_op1"," WHERE idx='$row[op1]'");

			$row['op1_str'] = $ar_op1['opname'];
		
			if($ar_op1['addac']!=0)	{
				$ar_maccount['account'] = $ar_maccount['account'] + $ar_op1['addac']/100;
				$ar_maccount['saccount'] = $ar_maccount['saccount'] + $ar_op1['addac']/100;
			}

			$op_str .= $ar_op1['opname'];
		}

		if($row['op2']!='')	{
			$ar_op2 = sel_query_all("shop_goods_op2"," WHERE idx='$row[op2]'");

			$row['op2_str'] = $ar_op1['opname'];

			if($ar_op2['addac']!=0)	{
				$ar_maccount['account'] = $ar_maccount['account'] + $ar_op2['addac']/100;
				$ar_maccount['saccount'] = $ar_maccount['saccount'] + $ar_op2['addac']/100;	
			}

			$op_str .= "/".$ar_op2['opname'];
		}
		if($row['op3']!='')	{
			$ar_op3 = sel_query_all("shop_goods_op3"," WHERE idx='$row[op3]'");

			$row['op3_str'] = $ar_op3['opname'];

			if($ar_op3['addac']!=0)	{
				$ar_maccount['account'] = $ar_maccount['account'] + $ar_op3['addac']/100;
				$ar_maccount['saccount'] = $ar_maccount['saccount'] + $ar_op3['addac']/100;
			}

			$op_str .= "/".$ar_op3['opname'];
		}

	
	
		if($row['account']!=0)	{
			$row['account'] = number_format($row['account']/100,$g_ar_curr['showstd']);
			$row['account_pure'] = $row['account']/100;
	
			$row['saccount'] = number_format(0,$g_ar_curr['showstd']);
			$row['saccount_pure'] = 0;
		}
		else	{
	
			$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
			$row['account_pure'] = $ar_maccount['account'];
	
			$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
			$row['saccount_pure'] = $ar_maccount['saccount'];
		}
		$row['op_str'] = $op_str;
		$row['taccount_pure'] = $row['account_pure']*$row['ea'];
		$row['taccount'] = number_format($row['taccount_pure'],$g_ar_curr['showstd']);
		
		$qs = "select * from shop_goods_imgs where goods_idx='$row[goods_idx]' order by idx asc";
		
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		
		while($rows = $sts->fetch())	{
			$row['simg'.$c] = $rows['filename'];	
			$c++;
		}

		$cartlist[] = $row;
	
		$cart['totalcou']++;
		$cart['totalaccount']  = $cart['totalaccount'] + ($row['account_pure']*$row['ea']);
	}
	
	$cart['totalaccount_pure'] = $cart['totalaccount'];
	$cart['totalaccount'] = number_format($cart['totalaccount'],$g_ar_curr['showstd']);

	$cart['delaccount_pure'] = 0;	
	if(isset($_SESSION['member_index']))	{
		if($g_ar_init['usedelac_member']=='Y')	{
			$std = $g_ar_init['delaccount_member_std'];
		
			if($g_ar_init['delaccount_member_std']>$cart['totalaccount_pure'])	{ 
			
				$cart['delaccount_pure'] = $g_ar_init['delaccount_member'];		
			} 
		} 
	}
	else
	{
		if($g_ar_init['usedelac_nomember']=='Y')	{
			$std = $g_ar_init['delaccount_nomember_std'];
			
			if($g_ar_init['delaccount_nomember_std']>$cart['totalaccount_pure'])	{ 
				
				$cart['delaccount_pure'] = $g_ar_init['delaccount_member'];		
			} 
		} 
	}
	$cart['delaccount'] = number_format($cart['delaccount_pure'],$g_ar_curr['showstd']);

	$cart['totaltaccount_pure'] = $cart['totalaccount_pure'] + $cart['delaccount_pure'];
	$cart['totaltaccount'] = number_format($cart['totaltaccount_pure'],$g_ar_curr['showstd']);
	
	$tpls->assign('cart', $cart);
	
	$tpls->assign('cartlist', $cartlist);
}

if($_REQUEST['act']=='order_step2' || $_REQUEST['act']=='order_step2g')	{
	
	
	if(!isset($_SESSION['member_index']))	{
		echo "<script>location.replace('/member/?act=login'); </script>";
		exit;
	}
	
	$basketindex = isset($_REQUEST['basketindex']) ? $_REQUEST['basketindex'] : "";
	if($basketindex == "")	{
		echo "<script>alert('".trscode('COMMON1')."'); location.replace('/'); </script>";
		exit;
	}
	$ar_basket_idxs = explode("-",$basketindex);
	
	$basket['totalaccount'] = 0;
	$cpstr = "";
	$totalrow = 0;
	for($i=0;$i<sizeof($ar_basket_idxs);$i++)	{
		if($ar_basket_idxs[$i]!='')	{
			$ar_basket = sel_query_all("shop_newbasket_tmp"," WHERE idx='".$ar_basket_idxs[$i]."'");
			$ar_goods = sel_query_all("shop_goods"," WHERE idx='$ar_basket[goods_idx]'");
			
			$ar_maccount = get_newaccount($ar_goods);
			$ar_basket['gname'] = $ar_goods['gname'];
			
			$qs = "select * from shop_goods_imgs where goods_idx='$ar_basket[goods_idx]' order by idx asc";
			$sts = $pdo->prepare($qs);
			$sts->execute();
			$c = 1;
			while($rows = $sts->fetch())	{
				$ar_basket['simg'.$c] = $rows['filename'];	
				$c++;
			}
			
			$ar_basket['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
			$ar_basket['account_pure'] = $ar_maccount['account'];

			$ar_basket['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
			$ar_basket['saccount_pure'] = $ar_maccount['saccount'];

			$ar_basket['taccount'] = number_format($ar_maccount['account']*$ar_basket['ea'],$g_ar_curr['showstd']);
			$ar_basket['taccount_pure'] = $ar_maccount['account']*$ar_basket['ea'];

			$basket['totalaccount'] = $basket['totalaccount'] + $ar_maccount['account']*$ar_basket['ea'];
			$goodslist[] = $ar_basket;
			$totalrow++;
		}
	}

	
	$basket['totalrow'] = $totalrow;
	$basket['totalgaccount_pure'] = $basket['totalaccount'];
	$basket['totalgaccount'] = number_format($basket['totalaccount'],$g_ar_curr['showstd']);

	$basket['order_point_std'] = $g_ar_member_config['order_point_std'];
	$basket['order_min_point'] = $g_ar_member_config['order_min_point'];
	$basket['order_max_point1'] = $g_ar_member_config['order_max_point1'];
	$basket['canusepoint'] = "N";
	if($basket['totalgaccount_pure']>=$basket['order_point_std'])	{
		$basket['canusepoint'] = "Y";
	}
	
	$basket['delaccount_pure'] = 0;
	if(isset($_SESSION['member_index']))	{
		if($g_ar_init['usedelac_member']=='Y')	{
			$std = $g_ar_init['delaccount_member_std'];
		
			if($g_ar_init['delaccount_member_std']>$basket['totalgaccount_pure'])	{ 
			
				$basket['delaccount_pure'] = $g_ar_init['delaccount_member'];		
			} 
		} 
	}
	else
	{
		if($g_ar_init['usedelac_nomember']=='Y')	{
			$std = $g_ar_init['delaccount_nomember_std'];
		
			if($g_ar_init['delaccount_nomember_std']>$basket['totalgaccount_pure'])	{ 
			
				$basket['delaccount_pure'] = $g_ar_init['delaccount_member'];		
			} 
		} 
	}

	$basket['delaccount'] = number_format($basket['delaccount_pure'],$g_ar_curr['showstd']);
	$basket['totalaccount_pure'] = $basket['totalgaccount_pure'] + $basket['delaccount_pure'];


	$q = "SELECT * FROM shop_config_pay WHERE pid='$g_ar_init[idx]'";
	if($g_ar_init_member['amemgrade']==0)	{
		$q = $q . " and showadmin=''";
	}
	$q = $q . " order by idx asc";
	$st = $pdo->prepare($q);
	$st->execute();

	$ar_include = array();
	$ar_chk = array();
	$cou = 0;
	$ar_pay = [];
	while($row = $st->fetch())	{
	
		$row['buymethod_str'] = $g_ar_buymethod[$row['buymethod']];
		if(!in_array($row['pgcom'],$ar_chk))	{
			$ar_include[] = $row;
			$ar_chk[] = $row['pgcom'];
			$cou++;
		}
		$ar_pay[] = $row;

	}	

	$basket['adddelaccount_pure'] = 0;
	
	$basket['adddelaccount'] = number_format($basket['adddelaccount_pure'],$g_ar_curr['showstd']);
	$basket['totalaccount_pure'] = $basket['totalaccount_pure'] + $basket['adddelaccount_pure'];
	$basket['totalaccount'] = number_format($basket['totalaccount_pure'],$g_ar_curr['showstd']);
	
	$q = "select * from shop_member_addrs where mem_idx='$G_MEMIDX' order by isbasic desc, name asc limit 0,1";
	$st = $pdo->prepare($q);
	$st->execute();
	$basket['havedels'] = $st->rowCount();
	$basket['delinfo'] = $st->fetch();
	

	$basket['formstart'] = "<form name='orderform' id='orderform'>";
	$basket['formstart'] .= "<input type='hidden' id='buymethod_type' name='buymethod' value='C' valch='yes' msg='".trscode('ORDER9')."'>";
	$basket['formstart'] .= "<input type='hidden' name='basketindex' value='$basketindex'>";
	$basket['formstart'] .= "<input type='hidden' name='gaccount' id='gaccount' value='".$basket['totalgaccount_pure']."'>";
	$basket['formstart'] .= "<input type='hidden' name='account' id='account' value='".$basket['totalaccount_pure']."'>";
	$basket['formstart'] .= "<input type='hidden' name='use_account' id='use_account' value='".$basket['totalaccount_pure']."'>";
	$basket['formstart'] .= "<input type='hidden' name='delaccount' id='delaccount' value='".$basket['delaccount_pure']."'>";
	$basket['formstart'] .= "<input type='hidden' name='adddelaccount' id='adddelaccount' value='".$basket['adddelaccount_pure']."'>";
	$basket['formstart'] .= "<input type='hidden' id='cpstr' value='".$cpstr."'>";
	$basket['formstart'] .= "<input type='hidden' id='order_min_point' value='".$g_ar_member_config['order_min_point']."'>";
	$basket['formstart'] .= "<input type='hidden' id='order_max_point1' value='".$g_ar_member_config['order_max_point1']."'>";
	$basket['formstart'] .= "<input type='hidden' id='delidx' value='".$basket['delinfo']['idx']."' valch='yes' msg='배송지를 선택하세요'>";




	if($g_ar_member_config['use_point']=='Y')	{
		if($_SESSION['member_index'])	{
			$basket['formstart'] .= "<input type='hidden' id='std_use_point' value='Y'>";
			$basket['formstart'] .= "<input type='hidden' id='std_mempoint' value='".$g_ar_init_member['mempoints']."'>";
		}
		else	{
			$basket['formstart'] .= "<input type='hidden' id='std_use_point' value='N'>";
		}
	}
	else	{
		$basket['formstart'] .= "<input type='hidden' id='std_use_point' value='N'>";
	}


	$basket['formend'] = "</form>";
	
	
	
	

	$tpls->assign('paylist', $ar_pay);
	$tpls->assign('basket', $basket);
	$tpls->assign('goodslist', $goodslist);
	
}

if($_REQUEST['act']=='order_over')	{

	
	if(!isset($_REQUEST['idx']))	{
		echo "<script>alert('".trscode('COMMON1')."'); location.replace('/'); </script>";
		exit;
	}	else	{
		$idx = $_REQUEST['idx'];	
	}

	$ar_data = sel_query_all("shop_newmarketdb"," WHERE idx='$idx'");
	$ar_data['account'] = $ar_data['account']/100;
	$ar_data['use_account'] = $ar_data['use_account']/100;
	$ar_data['delaccount'] = $ar_data['delaccount']/100;

	$q = "SELECT * FROM shop_newbasket where market_idx='$idx' AND gtype NOT IN ('5') AND set_idx=0 order by idx asc";
	$st = $pdo-> prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");
		$row['gname'] = $ar_goods['gname'];
		

		$qs = "select * from shop_goods_imgs where goods_idx='$row[goods_idx]' order by idx asc";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$row['simg'.$c] = $rows['filename'];	
			$c++;
		}

		
		$row['account_pure'] = $row['account']/100;
		$row['saccount_pure'] = $row['saccount']/100;
		
		$row['account'] = number_format($row['account']/100,$g_ar_curr['showstd']);
		$row['saccount'] = number_format($row['saccount'],$g_ar_curr['showstd']);
		
		$row['taccount'] = number_format($row['account_pure']*$row['ea'],$g_ar_curr['showstd']);
		$row['taccount_pure'] = $row['account_pure']*$row['ea'];

		$goodslist[] = $row;
	}
	$ar_data['orderno'] = date("Ymd",$ar_data['orderno'])."-".$idx;

	$ar_data['buym'] = $g_ar_buymethod[$ar_data['buymethod']];
	
	$tpls->assign('order', $ar_data);
	$tpls->assign('goodslist', $goodslist);
}

require_once "$_basedir/inc/config_sitef.php";

?>
