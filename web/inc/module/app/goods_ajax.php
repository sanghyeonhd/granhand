<?php
if($han=='get_view')	{
	$idx = $_REQUEST['idx'];
	$mem_idx = $_REQUEST['mem_idx'];
	$ar_data = sel_query_all("shop_goods", " where idx='$idx'");
	
	$ar_maccount = get_newaccount($ar_data);
	$ar_data['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
	$ar_data['account_pure'] = $ar_maccount['account'];

	$ar_data['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
	$ar_data['saccount_pure'] = $ar_maccount['saccount'];

	$ar_data['saveper'] = 0;
	if($ar_data['saccount_pure']!=0)	{
		//echo ($ar_data['saccount_pure']-$ar_data['account_pure'] );
		$ar_data['saveper'] = ($ar_data['saccount_pure']-$ar_data['account_pure'] )/$ar_data['saccount_pure']*100;

		$ar_data['saveper'] = round($ar_data['saveper']);
	}


	$ar_goods_cate = sel_query_all("shop_goods_cate"," where goods_idx='$idx' order by LENGTH(catecode) desc limit 0,1");
	
	
	$catelist = [];
	for($i = 2; $i <= strlen($ar_goods_cate['catecode']); $i = $i + 2)	{
		$cate = substr($ar_goods_cate['catecode'],0,$i);
		$ar_cate = sel_query_all("shop_cate"," where catecode='$cate'");
		$catelist[] = $ar_cate;
	}
	$qs = "select * from shop_goods_imgs where goods_idx='$idx' order by idx asc";
	$sts = $pdo->prepare($qs);
	$sts->execute();
	$imglist = [];
	while($rows = $sts->fetch())	{
		$rows['imgurl'] = $_imgserver."/goods/".$rows['filename'];
		$imglist[] = $rows;
	}
	
	$ar_data['noop'] = "Y";
	$ar_data['global'] = "<input type='hidden' id='idx' value='$idx'><input type='hidden' id='gtype' value='$ar_data[gtype]'><input type='hidden' id='isopen' value='$ar_data[isopen]'><input type='hidden' id='id_can_op' value='$ar_data[can_op]'><input type='hidden' id='account' value='$ar_data[account_pure]'>";
	
	$ar_data['havewish'] = "N";
	
	if(isset($_SESSION['member_index']) || $mem_idx != '')	{
		$q = "SELECT * FROM shop_wish where goods_idx='$idx' and mem_idx='$mem_idx'";
		$st = $pdo->prepare($q);
		$st->execute();
		if($st->rowCount()!=0)	{
			$ar_data['havewish'] = "Y";
		}	
	}
	
	if(isset($_SESSION['member_index']) || $mem_idx != '')	{
		$q = "select idx from shop_view_today where goods_idx='$idx' and mem_idx='$mem_idx'";
		$st = $pdo->prepare($q);
		$st->execute();
		$isit = $st->rowCount();
		if($isit == 0)	{
			unset($value);
			$value['mem_idx'] = $mem_idx;
			$value['goods_idx'] = $idx;
			$value['wdate'] = date("Y-m-d H:i:s");
			
			insert("shop_view_today", $value);
			unset($value);
		}	else	{
			$row = $st->fetch();
		    $value['wdate'] = date("Y-m-d H:i:s");
		    update("shop_view_today", $value, " where idx='$row[idx]'");

			unset($value);		
		}	
	}
	
	$datas['catelist'] = $catelist;
	$datas['cate'] = $ar_cate;
	$datas['goods'] = $ar_data;
	$datas['imglist'] = $imglist;	
	
	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_wish')	{
	
	$mem_idx = $_REQUEST['mem_idx'];
	$goods_idx = $_REQUEST['goods_idx'];
	
	$q = "select * from shop_wish where mem_idx='$mem_idx' and goods_idx='$goods_idx'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();
	if($isit == 0)	{
			unset($value);
			$value['mem_idx'] = $mem_idx;
			$value['goods_idx'] = $goods_idx;
			$value['sdate'] = date("Y-m-d H:i:s");
			
			insert("shop_wish", $value);
			unset($value);
		$redata['res'] = 'ok1';
		$redata['datas'] = $datas;
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}	else	{
		$pdo->prepare("delete from shop_wish where mem_idx='$mem_idx' and goods_idx='$goods_idx'")->execute();
		$redata['res'] = 'ok2';
		$redata['datas'] = $datas;
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}	
}
if($han=='get_recent')	{
	
	$cate = $_REQUEST['cate'];
	$mem_idx = $_REQUEST['mem_idx'];
	
	$datas = [];
	
	$q = "Select shop_goods.* from shop_view_today inner join shop_goods on shop_view_today.goods_idx=shop_goods.idx where mem_idx='$mem_idx'";

	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_maccount = get_newaccount($row);


		if($row['isopen']!='2')	{
			$row['gname'] = "[ǰ��]".$row['gname'];
		}

		$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$row['account_pure'] = $ar_maccount['account'];

		$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$row['saccount_pure'] = $ar_maccount['saccount'];
		$row['per'] = "";
		if($ar_maccount['saccount']!=0)	{
			$row['per'] = intval(($ar_maccount['saccount'] - $ar_maccount['account'])/$ar_maccount['saccount']*100);
		}
		
		$qs = "select * from shop_goods_imgs where goods_idx='$row[idx]' order by idx asc";
		
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$row['simg'.$c] = $rows['filename'];	
			$c++;
		}
		
		$row['imgurl'] = $_imgserver."/goods/".$row['simg1'];
		
		$row['havewish'] = "N";
		$qs = "select * from shop_wish where mem_idx='$mem_idx' and goods_idx='$row[idx]'";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		if($sts->rowCount())	{
			$row['havewish'] = "Y";	
		}

		$datas[] = $row;
	}
	
	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_wish')	{
	$mem_idx = $_REQUEST['mem_idx'];
	
	$datas = [];
	
	$q = "Select shop_goods.* from shop_wish inner join shop_goods on shop_wish.goods_idx=shop_goods.idx where mem_idx='$mem_idx'";

	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_maccount = get_newaccount($row);


		if($row['isopen']!='2')	{
			$row['gname'] = "[ǰ��]".$row['gname'];
		}

		$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$row['account_pure'] = $ar_maccount['account'];

		$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$row['saccount_pure'] = $ar_maccount['saccount'];
		$row['per'] = "";
		if($ar_maccount['saccount']!=0)	{
			$row['per'] = intval(($ar_maccount['saccount'] - $ar_maccount['account'])/$ar_maccount['saccount']*100);
		}
		
		$qs = "select * from shop_goods_imgs where goods_idx='$row[idx]' order by idx asc";
		
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$row['simg'.$c] = $rows['filename'];	
			$c++;
		}
		
		$row['imgurl'] = $_imgserver."/goods/".$row['simg1'];
		
		$row['havewish'] = "N";
		$qs = "select * from shop_wish where mem_idx='$mem_idx' and goods_idx='$row[idx]'";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		if($sts->rowCount())	{
			$row['havewish'] = "Y";	
		}

		$datas[] = $row;
	}
	
	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
?>