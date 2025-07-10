<?php
//ini_set("display_errors", 1);
require_once ("../../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_sitet.php";


$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : "";
if($act == 'journal')	{
	
	$cate = "";
	if(isset($_REQUEST['cate']))	{
		$cate = $_REQUEST['cate'];
		
	}
	$keyword = "";
	if(isset($_REQUEST['keyword']))	{
		$keyword = $_REQUEST['keyword'];
		
	}
	
	$page = "1";
	if(isset($_REQUEST['page']))	{
		$page = $_REQUEST['page'];
	}
	
	
	$arr['cate'] = $cate;
	$arr['keyword'] = $keyword;
	$arr['npage'] = $page;
	$arr['numper'] = "6";
	$arr['page_per_block'] = 10;
	

	$listcount = get_journalcount($page,$arr);

	$ar_loop_paging = $listcount['loop_paging'];
	$ar_paging = $listcount['paging'];
	
	$q = "select * from shop_journal_cate where isdel='N' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$catelist = [];
	while($row = $st->fetch())	{
		$catelist[] = $row;
	}



	$tpls->assign('l_cate', $ar_cate);
	$tpls->assign('l_loop_paging', $ar_loop_paging);
	$tpls->assign('l_paging', $ar_paging);
	$tpls->assign('l_arr', $arr);
	$tpls->assign('pagedata', $pagedata);
	$tpls->assign('catelist', $catelist);
	
}

if($act == 'journalv')	{
	
	$idx = "";
	if(isset($_REQUEST['idx']))	{
		$idx = $_REQUEST['idx'];
		
	}	else	{
		echo "<script>location.replace('/'); </script>";
		exit;
	}
	
	$ar_data = sel_query_all("shop_journal"," where idx='$idx'");
	$ar_cate = sel_query_all("shop_journal_cate"," where idx='$ar_data[cate]'");
	$ar_data['catename'] = $ar_cate['catename'];
	$value['readcount'] = $ar_data['readcount'] + 1;
	update("shop_journal",$value," where idx='$idx'");
	unset($value);
	
	$tpls->assign('datas', $ar_data);
	
	
}


if($act == 'event')	{
	

	$page = "1";
	if(isset($_REQUEST['page']))	{
		$page = $_REQUEST['page'];
	}
	$keyword = "";
	if(isset($_REQUEST['keyword']))	{
		$keyword = $_REQUEST['keyword'];
		
	}
	
	$arr['keyword'] = $keyword;
	$arr['npage'] = $page;
	$arr['numper'] = "6";
	$arr['page_per_block'] = 10;
	

	$listcount = get_eventcount($page,$arr);

	$ar_loop_paging = $listcount['loop_paging'];
	$ar_paging = $listcount['paging'];
	

	$tpls->assign('l_loop_paging', $ar_loop_paging);
	$tpls->assign('l_paging', $ar_paging);
	$tpls->assign('l_arr', $arr);
	$tpls->assign('pagedata', $pagedata);
	
}

if($act == 'eventv')	{
	
	$idx = "";
	if(isset($_REQUEST['idx']))	{
		$idx = $_REQUEST['idx'];
		
	}	else	{
		echo "<script>location.replace('/'); </script>";
		exit;
	}
	
	$ar_data = sel_query_all("shop_event"," where idx='$idx'");
	
	$value['readcount'] = $ar_data['readcount'] + 1;
	update("shop_event",$value," where idx='$idx'");
	unset($value);

	$tpls->assign('datas', $ar_data);
	
	
}

if($act == 'store')	{
	
	$brand_idx = "1";
	if(isset($_REQUEST['brand_idx']))	{
		$brand_idx = $_REQUEST['brand_idx'];	
	}
	$store_idx = 0;
	if(isset($_REQUEST['store_idx']))	{
		$store_idx = $_REQUEST['store_idx'];	
	}
	
	$brname = "";
	$q = "Select * from shop_brand where havestore='Y' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$brlist = [];
	while($row = $st->fetch())	{
		$row['issel'] = "N";
		if($brand_idx==$row['idx'])	{
			$row['issel'] = "Y";
			$brname = $row['brandname'];
			$brand = $row;
		}
		$brlist[] = $row;	
	}
	
	$q = "select * from shop_stores where brand_idx='$brand_idx' and isshow='Y' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$storelist = [];
	while($row = $st->fetch())	{
		$row['issel'] = "N";
		$row['fullname'] = $brname." " .$row['name'];
		
		if($store_idx==0)	{
			$row['issel'] = "Y";	
			$store_idx = $row['idx'];
			$store = $row;
		}	else	{
			if($store_idx==$row['idx'])	{
				$row['issel'] = "Y";	
				$store_idx = $row['idx'];
				$store = $row;
			}
		}
		
		$storelist[] = $row;	
	}
	
	$q = "Select * from shop_stores_imgs where store_idx='$store_idx' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$store['imgs'] = [];
	while($row = $st->fetch())	{
		$store['imgs'][] = $row;
	}
	
	$tpls->assign('brand', $brand);
	$tpls->assign('store', $store);
	$tpls->assign('brlist', $brlist);
	
	$tpls->assign('storelist', $storelist);
}

if($act == 'faq')	{
	
	$cate_idx = "1";
	if(isset($_REQUEST['cate_idx']))	{
		$cate_idx = $_REQUEST['cate_idx'];	
	}
	
	$q = "Select * from shop_faqcate where isuse='Y' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$catelist = [];
	while($row = $st->fetch())	{
		$row['issel'] = "N";
		if($cate_idx==$row['idx'])	{
			$row['issel'] = "Y";
			$brand = $row;
		}
		$catelist[] = $row;	
	}
	
	$q = "select * from shop_faq where cate_idx='$cate_idx' ";
	$st = $pdo->prepare($q);
	$st->execute();
	$faqlist = [];
	while($row = $st->fetch())	{
		
		$faqlist[] = $row;	
	}
	
	$tpls->assign('catelist', $catelist);
	$tpls->assign('faqlist', $faqlist);
	
}

require_once "$_basedir/inc/config_sitef.php";

?>
