<?php
if($han=='set_cart')	{
	
	$goods_idx = $_REQUEST['idx'];
	$mem_idx = $_REQUEST['mem_idx'];
	$ea = $_REQUEST['ea'];	
	
	$q = "Select * from shop_newbasket_tmp where goods_idx='$goods_idx' and mem_idx='$mem_idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowcount();
	
	if($isit==0)	{ 
		$value['sfid'] = 1;
		$value['spid'] = 1;
	
		$value['goods_idx'] = $goods_idx;
		$value['mem_idx'] = $mem_idx;
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
		
		$idx = $pdo->lastInsertId();
		
	}	else	{
		$row = $st->fetch();

		$value['ea'] = $row['ea'] +  $ar_ea[$i];
		update("shop_newbasket_tmp",$value," WHERE idx='$row[idx]'");
		unset($value);
		
		$idx = $row['idx'];
	}
	
	$redata['res'] = "ok";
	$redata['idx'] = $idx;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
if($han=='get_cart')	{
	
	$mem_idx = $_REQUEST['mem_idx'];
	
	
	$cart['totalcou'] = 0;
	$cart['totalaccount'] = 0;
	$cartlist = [];
	$q = "Select * from shop_newbasket_tmp where mem_idx='$mem_idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{

		$ar_goods = sel_query_all("shop_goods"," WHERE idx='".$row['goods_idx']."'");
		
		if($ar_goods['isopen']!='2')	{
			continue;
		}

		
		$row['gname'] = $ar_goods['gname'];
		$row['gcode'] = $ar_goods['gcode'];
	
		$ar_maccount = get_newaccount($ar_goods);

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
		$row['issel'] = "Y";
		
		$qs = "select * from shop_goods_imgs where goods_idx='$row[goods_idx]' order by idx asc";
		
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		
		while($rows = $sts->fetch())	{
			$row['simg'.$c] = $_imgserver."/goods/".$rows['filename'];	
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
	
	$redata['res'] = "ok";
	$redata['datalist'] = $cartlist;
	$redata['cart'] = $cart;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='delcart')	{
	
	$mem_idx = $_REQUEST['mem_idx'];
	$input = file_get_contents("php://input");
	$data = json_decode($input, true); // true 옵션으로 연관배열로 변환

	if (isset($data['selected'])) {
		$selected = $data['selected']; // 예: [101, 105, 109]
    
	    // 예시: 하나씩 출력
		foreach ($selected as $idx) {
			$pdo->prepare("delete from shop_newbasket_tmp where mem_idx='$mem_idx' and idx='$idx'")->execute();
	    }

	} 
	$redata['res'] = "ok";
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_orderinfo')	{
	
	$mem_idx = $_REQUEST['mem_idx'];
	$input = file_get_contents("php://input");
	$data = json_decode($input, true); // true 옵션으로 연관배열로 변환
	
	$cart['totalcou'] = 0;
	$cart['totalaccount'] = 0;
	
	if (isset($data['selected'])) {
		$selected = $data['selected']; // 예: [101, 105, 109]
    
	    // 예시: 하나씩 출력
		foreach ($selected as $idx) {

			$row = sel_query_all("shop_newbasket_tmp"," where idx='$idx'");
			$ar_goods = sel_query_all("shop_goods"," WHERE idx='".$row['goods_idx']."'");
		
			if($ar_goods['isopen']!='2')	{
				continue;
			}

		
			$row['gname'] = $ar_goods['gname'];
			$row['gcode'] = $ar_goods['gcode'];
	
			$ar_maccount = get_newaccount($ar_goods);

			if($row['account']!=0)	{
				$row['account'] = number_format($row['account']/100,$g_ar_curr['showstd']);
				$row['account_pure'] = $row['account']/100;
	
				$row['saccount'] = number_format(0,$g_ar_curr['showstd']);
				$row['saccount_pure'] = 0;
			}	else	{
	
				$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
				$row['account_pure'] = $ar_maccount['account'];
	
				$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
				$row['saccount_pure'] = $ar_maccount['saccount'];
			}
			$row['op_str'] = $op_str;
			$row['taccount_pure'] = $row['account_pure']*$row['ea'];
			$row['taccount'] = number_format($row['taccount_pure'],$g_ar_curr['showstd']);
			$row['issel'] = "Y";
		
			$qs = "select * from shop_goods_imgs where goods_idx='$row[goods_idx]' order by idx asc";
		
			$sts = $pdo->prepare($qs);
			$sts->execute();
			$c = 1;
		
			while($rows = $sts->fetch())	{
				$row['simg'.$c] = $_imgserver."/goods/".$rows['filename'];	
				$c++;
			}

			$cartlist[] = $row;
		
			$cart['totalcou']++;
			$cart['totalaccount']  = $cart['totalaccount'] + ($row['account_pure']*$row['ea']);
	    }

	} 
	
	$q = "Select * from shop_member_addrs where mem_idx='$mem_idx' order by isbasic desc";
	$st = $pdo->prepare($q);
	$st->execute();
	$addrlist = [];
	while($row = $st->fetch())	{
		$row['issel'] = "N";
		if($row['isbasic'] == "Y" || $st->rowCount() == 1)	{
			$row['issel'] = "Y";	
		}
		$addrlist[] = $row;
	}
	
	$redata['res'] = "ok";
	$redata['datalist'] = $cartlist;
	$redata['addrlist'] = $addrlist;	
	$redata['data'] = $cart;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_addr')	{
	$mem_idx = $_REQUEST['mem_idx'];
	$input = file_get_contents("php://input");
	$data = json_decode($input, true); // true = 연관 배열로 반환

	// 2. 원하는 데이터 접근
	$selected = $data['selected'] ?? null;
	
	$value['mem_idx'] = $mem_idx;
	$value['isbasic'] = $selected['isbasic'];
	$value['name'] = $selected['name'];
	$value['delname'] = $selected['delname'];
	$value['delcp'] = $selected['delcp'];
	$value['delzip'] = $selected['delzip'];
	$value['deladdr1'] = $selected['deladdr1'];
	$value['deladdr2'] = $selected['deladdr2'];	
	insert("shop_member_addrs",$value);
	
	$q = "Select * from shop_member_addrs where mem_idx='$mem_idx' order by isbasic desc";
	$st = $pdo->prepare($q);
	$st->execute();
	$addrlist = [];
	while($row = $st->fetch())	{
		$row['issel'] = "N";
		if($row['isbasic'] == "Y" || $st->rowCount() == 1)	{
			$row['issel'] = "Y";	
		}
		$addrlist[] = $row;
	}
	
	$redata['res'] = "ok";
	$redata['addrlist'] = $addrlist;	
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_orders')	{
	
	$mem_idx = $_REQUEST['mem_idx'];
	$limit = $_REQUEST['limit'];
	
	if($limit == '1')	{
		$odate = date('Y-m-d H:i:s', strtotime('-1 year'));
		$str = " and odate >= '$odate'";
	}
	if($limit == '2')	{
		$odate = date('Y-m-d H:i:s', strtotime('-1 week'));
		$str = " and odate >= '$odate'";
	}
	if($limit == '3')	{
		$odate = date('Y-m-d H:i:s', strtotime('-1 month'));
		$str = " and odate >= '$odate'";
	}
	if($limit == '4')	{
		$odate = date('Y-m-d H:i:s', strtotime('-3 months'));
		$str = " and odate >= '$odate'";
	}
	
	$maindata['d1'] = 0;
	$maindata['d2'] = 0;
	$maindata['d3'] = 0;
	$maindata['d4'] = 0;
	$maindata['d5'] = 0;	
	
	$q = "select * from shop_newmarketdb where mem_idx='$mem_idx' and dan!=''".$str." order by odate desc";
	$st = $pdo->prepare($q);
	$st->execute();
	$datalist = [];
	while($row = $st->fetch() )	{
		
		if($row['dan'] == 1 || $row['dan'] == 2)	{
			$maindata['d1'] = $maindata['d1'] + 1;
		}
		
		if($row['dan'] == 3)	{
			$maindata['d2'] = $maindata['d2'] + 1;
		}
		if($row['dan'] == 4 || $row['dan'] == 5)	{
			$maindata['d3'] = $maindata['d3'] + 1;
		}
		
		if($row['dan'] == 6)	{
			$maindata['d4'] = $maindata['d4'] + 1;
		}
		
		$qs = "select * from shop_newbasket where market_idx='$row[idx]'";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$row['goodslist'] = [];
		while($rows = $sts->fetch())	{
			$ar_goods = sel_query_all("shop_goods"," where idx='$rows[goods_idx]'");
			$qs2 = "select * from shop_goods_imgs where goods_idx='$rows[goods_idx]' order by idx asc";
		
			$sts2 = $pdo->prepare($qs2);
			$sts2->execute();
			$c = 1;
		
			while($rows2 = $sts2->fetch())	{
				$ar_goods['simg'.$c] = $_imgserver."/goods/".$rows2['filename'];	
				$c++;
			}
			
			$row['goodslist'][] = $ar_goods;
		}
		
		$datalist[] = $row;	
	}
	$redata['res'] = "ok";
	$redata['datalist'] = $datalist;	
	$redata['data'] = $maindata;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_ordersview')	{
	
	$mem_idx = $_REQUEST['mem_idx'];
	$idx = $_REQUEST['idx'];
	

		$qs = "select * from shop_newbasket where market_idx='$idx'";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$datalist = [];
		while($rows = $sts->fetch())	{
			$ar_goods = sel_query_all("shop_goods"," where idx='$rows[goods_idx]'");
			$qs2 = "select * from shop_goods_imgs where goods_idx='$rows[goods_idx]' order by idx asc";
		
			$sts2 = $pdo->prepare($qs2);
			$sts2->execute();
			$c = 1;
		
			while($rows2 = $sts2->fetch())	{
				$ar_goods['simg'.$c] = $_imgserver."/goods/".$rows2['filename'];	
				$c++;
			}
			
			$datalist[] = $ar_goods;
		}
		

	
	$maindata = sel_query_all("shop_newmarketdb"," where idx='$idx'");
	$maindata['orderno'] = date("Ymd")."-".$idx;
	
	$redata['res'] = "ok";
	$redata['datalist'] = $datalist;	
	$redata['data'] = $maindata;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}