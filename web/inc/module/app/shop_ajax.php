<?
if($han=='get_cate')	{
	
	$cate = $_REQUEST['cate'];
	
	$q = "select * from shop_cate where upcate='$cate' order by rorders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$catelist = [];
	while($row = $st->fetch())	{
		$catelist[] = $row;
	}
	$redata['res'] = 'ok';
	$redata['datas'] = $catelist;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
if($han=='get_list')	{
	
	$cate = $_REQUEST['cate'];
	$mem_idx = $_REQUEST['mem_idx'];
	
	$datas = [];
	
	$q = "SELECT shop_goods.* from shop_goods INNER JOIN shop_goods_cate ON shop_goods.idx=shop_goods_cate.goods_idx WHERE isopen IN ('2','3','4') and isshow='Y' and	fid='1' AND isdel='N'";	
	$q = $q . " and catecode='".$cate."'";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_maccount = get_newaccount($row);


		if($row['isopen']!='2')	{
			$row['gname'] = "[품절]".$row['gname'];
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