<?php
if($han=='get_cate')	{

	$upcate = $_REQUEST['upcate'];
	$q = "select * from shop_cate where upcate='$upcate' order by catecode asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch() )	{
		$datas[] = $row;
	}

	$redata['datas'] = $datas;
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}