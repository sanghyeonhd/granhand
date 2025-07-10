<?php
if($han=='get_faq')	{
	
	$datas = [];
	

	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_faqcate')	{
	
	$q = "select * from shop_faqcate where isuse='Y' order by orders asc";
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
?>