<?php
//ini_set("display_errors", 1);
require_once ("../../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_sitet.php";

if(!isset($_SESSION['member_index']))	{
	echo "<script>location.replace('/member/?act=login'); </script>";
	exit;
}

if($_REQUEST['act']=='wish')	{
	
	$q = "select * from shop_wish where mem_idx='$G_MEMIDX' order by idx desc";
	$st = $pdo->prepare($q);
	$st->execute();
	$datalist = [];
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," where idx='$row[goods_idx]'");
		
		$qs = "select * from shop_goods_imgs where goods_idx='$ar_goods[idx]' order by idx asc";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$ar_goods['simg'.$c] = $rows['filename'];	
			$c++;
		}
		
		$ar_maccount = get_newaccount($ar_goods);
		$ar_goods['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$ar_goods['account_pure'] = $ar_maccount['account'];

		$ar_goods['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$ar_goods['saccount_pure'] = $ar_maccount['saccount'];

		$ar_goods['saveper'] = 0;
		if($ar_goods['saccount_pure']!=0)	{
			//echo ($ar_data['saccount_pure']-$ar_data['account_pure'] );
			$ar_goods['saveper'] = ($ar_goods['saccount_pure']-$ar_goods['account_pure'] )/$ar_goods['saccount_pure']*100;
	
			$ar_goods['saveper'] = round($ar_goods['saveper']);
		}
		
		$datalist[] = $ar_goods;
	}
	$tpls->assign('datalist', $datalist);
}

if($_REQUEST['act']=='recent')	{
	
	$q = "select * from shop_view_today where mem_idx='$G_MEMIDX' order by idx desc";
	$st = $pdo->prepare($q);
	$st->execute();
	$datalist = [];
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," where idx='$row[goods_idx]'");
		
		$qs = "select * from shop_goods_imgs where goods_idx='$ar_goods[idx]' order by idx asc";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$ar_goods['simg'.$c] = $rows['filename'];	
			$c++;
		}
		
		$ar_maccount = get_newaccount($ar_goods);
		$ar_goods['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$ar_goods['account_pure'] = $ar_maccount['account'];

		$ar_goods['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$ar_goods['saccount_pure'] = $ar_maccount['saccount'];

		$ar_goods['saveper'] = 0;
		if($ar_goods['saccount_pure']!=0)	{
			//echo ($ar_data['saccount_pure']-$ar_data['account_pure'] );
			$ar_goods['saveper'] = ($ar_goods['saccount_pure']-$ar_goods['account_pure'] )/$ar_goods['saccount_pure']*100;
	
			$ar_goods['saveper'] = round($ar_goods['saveper']);
		}
		
		$datalist[] = $ar_goods;
	}
	$tpls->assign('datalist', $datalist);
}

if($_REQUEST['act']=='myorder')	{
	
	$mem_idx = $G_MEMIDX;
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
	
	$tpls->assign('datalist', $datalist);
	$tpls->assign('data', $maindata);
	
	
}

if($_REQUEST['act']=='mygift')	{
	
	$mem_idx = $G_MEMIDX;
	
	if(isset($_REQUEST['menu'])){
		$maindata['menu'] = $_REQUEST['menu'];	
		
	}	else	{
		$maindata['menu'] = 1;	
	}
	
	if($maindata['menu']==1)	{
		$q = "select * from shop_newmarketdb where mem_idx='$mem_idx' and isgift='Y' and dan!=''".$str." order by odate desc";	
	}	else		{
		$q = "select * from shop_newmarketdb where from_idx='$mem_idx' and isgift='Y' and dan!=''".$str." order by odate desc";
	}
	
	$st = $pdo->prepare($q);
	$st->execute();
	$datalist = [];
	while($row = $st->fetch() )	{

		
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
	
	$tpls->assign('datalist', $datalist);
	$tpls->assign('data', $maindata);
	
	
}

if($_REQUEST['act']=='main')	{
	
	$q = "select * from shop_wish where mem_idx='$G_MEMIDX'";
	$st = $pdo->prepare($q);
	$st->execute();
	
	$maindata['wish'] = $st->rowCount();
	
	$q = "select * from shop_view_today where mem_idx='$G_MEMIDX'";
	$st = $pdo->prepare($q);
	$st->execute();
	
	$maindata['today'] = $st->rowCount();	
	

	$tpls->assign('data', $maindata);
	
	
}

require_once "$_basedir/inc/config_sitef.php";

?>
