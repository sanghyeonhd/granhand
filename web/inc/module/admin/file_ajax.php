<?php
if($han=='set_goodsimg')	{
	
	for($i=0;$i<sizeof($_FILES['file']['name']);$i++)	{
		$userfile[] = $_FILES['file']['name'][$i];
		$tmpfile[] = $_FILES['file']['tmp_name'][$i];
	}

	$savedir = $_uppath."goods/";
	
	
	if(!is_dir($savedir))	{	
		mkdir($savedir, 0777);	chmod($savedir,0707);  
	}

	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	
	}

	for($i=0;$i<sizeof($fs);$i++)	{
		
		$row['file'] = $_imgserver."/goods/".$fs[$i];
		$row['fileor'] = $fs[$i];
		
		$value['tmp_idx'] = $_REQUEST['tmp_idx'];
		$value['filename'] = $fs[$i];
		insert("shop_goods_imgs",$value);
		$datas[] = $row;
	}

	$redata['datas'] = $datas;
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_afterimg')	{
	
	for($i=0;$i<sizeof($_FILES['file']['name']);$i++)	{
		$userfile[] = $_FILES['file']['name'][$i];
		$tmpfile[] = $_FILES['file']['tmp_name'][$i];
	}

	$savedir = $_uppath."after/";
	
	
	if(!is_dir($savedir))	{	
		mkdir($savedir, 0777);	chmod($savedir,0707);  
	}

	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	
	}

	for($i=0;$i<sizeof($fs);$i++)	{
		
		$row['file'] = $_imgserver."/after/".$fs[$i];
		$row['fileor'] = $fs[$i];

		$datas[] = $row;
	}

	$redata['datas'] = $datas;
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_goodsimgmod')	{

	$index_no = $_REQUEST['index_no'];
	$ar_data = sel_query_all("shop_goods"," where index_no='$index_no'");
	
	for($i=0;$i<sizeof($_FILES['file']['name']);$i++)	{
		$userfile[] = $_FILES['file']['name'][$i];
		$tmpfile[] = $_FILES['file']['tmp_name'][$i];
	}

	$savedir = $_uppath."goods/";
	
	
	if(!is_dir($savedir))	{	
		mkdir($savedir, 0777);	chmod($savedir,0707);  
	}

	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$index_no.$i,$savedir);	
	}

	for($i=0;$i<sizeof($fs);$i++)	{
		
		$row['file'] = $_imgserver."/goods/".$fs[$i];
		$row['fileor'] = $fs[$i];
		
		for($j=1;$j<13;$j++)	{
			
			if($ar_data['simg'.$j]=='')	{
				$value['simg'.$j] = $fs[$i];
				update("shop_goods",$value," where index_no='$index_no'");
				unset($value);
				break;
			}

		}		

		$datas[] = $row;
	}

	$redata['datas'] = $datas;
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}

if($han=='set_delgoodsimg')	{
	
	$file = $_REQUEST['file'];
	$goods_idx = $_REQUEST['goods_idx'];
	
	
	$savedir = $_uppath.$file;
	$filename = str_replace("goods/","",$file);
	if($goods_idx)	{
		$ar_data = sel_query_all("shop_goods"," where index_no='$goods_idx'");
		for($i=1;$i<=10;$i++)	{
			if($ar_data['simg'.$i]==$filename)	{
				$value['simg'.$i] = "";
			}
		}
		update("shop_goods",$value," where index_no='$goods_idx'");
	}
	//@unlink($savedir);

	$redata['res'] = "ok";
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_delgoodsimg')	{
	
	$file = $_REQUEST['file'];

	$savedir = $_uppath.$file;
	$filename = str_replace("after/","",$file);
	
	//@unlink($savedir);

	$redata['res'] = "ok";
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
?>