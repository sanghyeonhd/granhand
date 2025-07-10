<?
if($han=='get_main')	{
	
	$main_idx = $_REQUEST['main_idx'];
	$datas = get_set_data($main_idx);
	
	$redata['res'] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
	
}
?>