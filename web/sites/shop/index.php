<?php
//ini_set("display_errors", 1);
require_once ("../../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_sitet.php";


if($_REQUEST['act']=='list')	{
	if(isset($_REQUEST['cate']))	{
		$cate = $_REQUEST['cate'];
		$orby = "shop_goods_cate.orders asc";
	}	else	{
		$orby = "shop_goods.idx desc";	
	}
	
	$page = "1";
	if(isset($_REQUEST['page']))	{
		$page = $_REQUEST['page'];
	}
	$ob = "1";
	if(isset($_REQUEST['ob']))	{
		$ob = $_REQUEST['ob'];
	}
	
	
	

	
	$arr['cate'] = $cate;
	$arr['numper'] = "20";
	$arr['page_per_block'] = 10;
	switch ($ob){
		case 1 : $arr['orderby'] =  " order by isopen asc , $orby "; break;
		case 2 : $arr['orderby'] =  " order by isopen asc , $orby "; break;
		case 3 : $arr['orderby'] =  " order by isopen asc , shop_goods.account asc"; break;	
		case 4 : $arr['orderby'] =  " order by isopen asc , shop_goods.account desc"; break;	
	}
	
	$arr['ob'] = $ob;
	switch($ob)	{
		case "1" : $arr['orderbyname'] = "추천순";	break;	
		case "2" : $arr['orderbyname'] = "인기순";break;	
		case "3" : $arr['orderbyname'] = "낮은 가격순";break;	
		case "4" : $arr['orderbyname'] = "높은 가격순";break;	
		case "5" : $arr['orderbyname'] = "상품평 적은순";break;	
		case "6" : $arr['orderbyname'] = "상품평 많은순";	break;		
	}

	$ar_icon = sel_query_all("shop_config_icon"," where wuse='2' and isuse='Y' and fid='".$g_ar_init['fid']."'");
	$ar_icon_new = sel_query_all("shop_config_icon"," where wuse='1' and isuse='Y' and fid='".$g_ar_init['fid']."'");

	$listcount = get_listcount("list",$page,$arr);

	$ar_loop_paging = $listcount['loop_paging'];
	$ar_paging = $listcount['paging'];

	$arr['first'] = $ar_paging['first'];


	$pagedata['ob'] = $ob;

	$tpls->assign('l_cate', $ar_cate);
	$tpls->assign('l_loop_paging', $ar_loop_paging);
	$tpls->assign('l_paging', $ar_paging);
	$tpls->assign('l_arr', $arr);
	$tpls->assign('pagedata', $pagedata);
	
	
}

if($_REQUEST['act']=='view')	{
	
	$idx = $_REQUEST['idx'];
	if(!is_numeric($idx))	{
	
		echo "<script>alert('".trscode('COMMON1')."'); location.replace('/'); </script>";
		exit;
	}
	$ar_data = sel_query_all("shop_goods", " where idx='$idx'");
	if(!$ar_data){
		echo "<script>alert('".trscode('VIEW1')."'); location.replace('/'); </script>";
		exit;
	}
	if($ar_data['isdel']=='Y')	{
		echo "<script>alert('".trscode('VIEW1')."'); location.replace('/'); </script>";
		exit;
	}
	
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
		$imglist[] = $rows;
	}
	
	$ar_data['noop'] = "Y";
	$ar_data['global'] = "<input type='hidden' id='idx' value='$idx'><input type='hidden' id='gtype' value='$ar_data[gtype]'><input type='hidden' id='isopen' value='$ar_data[isopen]'><input type='hidden' id='id_can_op' value='$ar_data[can_op]'><input type='hidden' id='account' value='$ar_data[account_pure]'>";
	
	$ar_data['havewish'] = "N";
	
	if(isset($_SESSION['member_index']))	{
		$q = "SELECT * FROM shop_wish where goods_idx='$idx' and stypes='1' AND mem_idx='$G_MEMIDX'";
		$st = $pdo->prepare($q);
		$st->execute();
		if($st->rowCount()!=0)	{
			$ar_data['havewish'] = "Y";
		}	
	}
	
	if(isset($_SESSION['member_index']))	{
		$q = "select idx from shop_view_today where goods_idx='$idx' and mem_idx='$G_MEMIDX'";
		$st = $pdo->prepare($q);
		$st->execute();
		$isit = $st->rowCount();
		if($isit == 0)	{
			unset($value);
			$value['mem_idx'] = $G_MEMIDX;
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
	
	
		
	$tpls->assign('catelist', $catelist);
	$tpls->assign('cate', $ar_cate);
	$tpls->assign('goods', $ar_data);
	$tpls->assign('imglist', $imglist);	
	
}

require_once "$_basedir/inc/config_sitef.php";

?>
