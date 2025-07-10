<?php
if($han=='get_journal')	{
	
	if(isset($_REQUEST['cateidx']))	{
		$datas = get_journal(0,6,$_REQUEST['cateidx']);	
	}	else	{
		$datas = get_journal(0,6);	
	}
	
	
	

	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_journalv')	{
	
	$idx = "";
	if(isset($_REQUEST['idx']))	{
		$idx = $_REQUEST['idx'];
		
	}

	$ar_data = sel_query_all("shop_journal"," where idx='$idx'");
	$ar_cate = sel_query_all("shop_journal_cate"," where idx='$ar_data[cate]'");
	$ar_data['catename'] = $ar_cate['catename'];
	$value['readcount'] = $ar_data['readcount'] + 1;
	update("shop_journal",$value," where idx='$idx'");
	unset($value);
	
	$ar_data['imgurl'] = $_imgserver."/journal/".$ar_data['img'];

	$redata['res'] = 'ok';
	$redata['datas'] = $ar_data;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
if($han=='get_journalcate')	{
	
	$q = "select * from shop_journal_cate where isdel='N' order by orders asc";
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
if($han=='get_event')	{
	
	$datas = get_event(0,6,"");
	

	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han == 'get_store')	{
	
	if(isset($_REQUEST['brandidx']))	{
		$brandidx = $_REQUEST['brandidx'];	
		if($brandidx=="")	{
			$brandidx = 1;	
		}
	}	else{
		$brandidx = 1;
	}


	if(isset($_REQUEST['storeidx']))	{
		$storeidx = $_REQUEST['storeidx'];	
		if($storeidx=="")	{
			$storeidx = 0;	
		}
	}	else	{
		$storeidx = 0;
	}
	
	$brname = "";
	$q = "Select * from shop_brand where havestore='Y' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$brlist = [];
	while($row = $st->fetch())	{
		$row['issel'] = "N";
		if($brandidx==$row['idx'])	{
			$row['issel'] = "Y";
			$brname = $row['brandname'];
			$brand = $row;
		}
		$brlist[] = $row;	
	}
	
	$q = "select * from shop_stores where brand_idx='$brandidx' and isshow='Y' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$storelist = [];
	while($row = $st->fetch())	{
		$row['issel'] = "N";
		$row['fullname'] = $brname." " .$row['name'];
		
		if($storeidx==0)	{
			$row['issel'] = "Y";	
			$storeidx = $row['idx'];
			$store = $row;
		}	else	{
			if($storeidx==$row['idx'])	{
				$row['issel'] = "Y";	
				$storeidx = $row['idx'];
				$store = $row;
			}
		}
		
		$storelist[] = $row;	
	}
	
	if($storeidx != 0)	{
		$store['imgs'] = [];
		$q = "Select * from shop_stores_imgs where store_idx='$storeidx' order by orders asc";
		$st = $pdo->prepare($q);
		$st->execute();
		
		while($row = $st->fetch())	{
			$row['imgurl'] = $_imgserver."/store/".$row['filename'];
			$store['imgs'][] = $row;
		}	
	}
	
	
	$datas['brandidx'] = $brandidx;
	$datas['storeidx'] = $storeidx;	
	$datas['brand'] = $brand;
	$datas['store'] = $store;
	$datas['brlist'] = $brlist;
	$datas['storelist'] = $storelist;

	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_eventv')	{
	
	$idx = "";
	if(isset($_REQUEST['idx']))	{
		$idx = $_REQUEST['idx'];
		
	}

	$ar_data = sel_query_all("shop_event"," where idx='$idx'");
	
	$value['readcount'] = $ar_data['readcount'] + 1;
	update("shop_event",$value," where idx='$idx'");
	unset($value);
	
	$ar_data['imgurl'] = $_imgserver."/event/".$ar_data['img'];

	$redata['res'] = 'ok';
	$redata['datas'] = $ar_data;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
if($han=='get_guideconfig')	{
	
	$q = "Select * from shop_guide_config order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$datas = [];	
	while($row = $st->fetch())	{
		
		$row['itemlist'] = explode(",",$row['items']);
		$datas[] = $row;
	}
	
	
	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}