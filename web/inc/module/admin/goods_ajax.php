<?
if($han=='get_allcate')	{
	
	$q = "SELECT * FROM shop_cate WHERE upcate='' ORDER BY catecode ASC";
	$st = $pdo->prepare($q);
	$st->execute();
	
	$cou = 0;
	$lcate = [];
	while($row = $st->Fetch())	{
		
		$cates['id'] = $row['idx'];
		$cates['text'] = $row['catename'];
		$cates['icon'] = "fa fa-folder-o c-purple";
		$cates['state']['selected'] = false;
		
		
		$lcate[] = $cates;
		$cou++;
	}
	
	$redata['catedata'] = $lcate;
	$redata['catecou'] = $cou;
	$redata['res'] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='get_buns')	{
	
	$idx = $_REQUEST['bun_idx'];

	$ar_buns = sel_query_all("shop_goods_bun"," WHERE catecode='$idx'");

	$q = "SELECT * FROM shop_config_goodsadd WHERE bun_idx='$ar_buns[index_no]' ORDER BY index_no ASC";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->Fetch())	{
		
		$datas[] = $row;

	}

	$redata[res] = 'ok';
	$redata['datas'] = $datas;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_regigoods')	{
	
	if(!isset($_SESSION['member_index']))	{
		$redata[res] = 'error';
		$redata['resmsg'] = "로그인후 진행하세요";
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}

	$value['fid'] = $_REQUEST['fid'];
	$value['gtype'] = $_REQUEST['gtype'];
	$value['gname'] = addslashes($_REQUEST['gname']);
	$value['gname_header'] = addslashes($_REQUEST['gname_header']);
	$value['gname_footer'] = addslashes($_REQUEST['gname_footer']);
	$value['account'] = $_REQUEST['account'];
	$value['oaccount'] = $_REQUEST['oaccount'];
	$value['disaccount'] = $_REQUEST['disaccount'];
	$value['disaccount_type'] = $_REQUEST['disaccount_type'];
	$value['taxtype'] = $_REQUEST['taxtype'];
	$value['useop'] = $_REQUEST['useop'];
	$value['opcou'] = $_REQUEST['opcou'];
	$value['opname'] = $opname;
	$value['useopin'] = $_REQUEST['useopin'];
	$value['opincou'] = $_REQUEST['opincoupcopincouu'];
	$value['opinname'] = $opinname;
	$value['brandidx'] = $_REQUEST['brandidx'];
	$value['memo'] = addslashes($_REQUEST['memo']);

	$value['data_model'] = addslashes($_REQUEST['data_model']);
	$value['data_maker'] = addslashes($_REQUEST['data_maker']);
	$value['data_origin'] = addslashes($_REQUEST['data_origin']);
	$value['data_weight'] = $_REQUEST['data_weight'];
	$value['data_ismake'] = addslashes($_REQUEST['data_ismake']);
	$value['data_isaduly'] = addslashes($_REQUEST['data_isaduly']);
	$value['data_havekc'] = addslashes($_REQUEST['data_havekc']);
	$value['data_itembun'] = addslashes($_REQUEST['data_itembun']);

	$value['bu_type'] = addslashes($_REQUEST['bu_type']);
	$value['bu_gname'] = addslashes($_REQUEST['bu_gname']);

	$value['point'] = addslashes($_REQUEST['point']);
	$value['pointtype'] = addslashes($_REQUEST['pointtype']);
	$value['buytarget'] = addslashes($_REQUEST['buytarget']);

	$value['isopen'] = "1";
	$value['isshow '] = "N";
	$value['isdel'] = "N";
	$value['regidate'] = date("Y-m-d H:i:s");
	$value['md_idx'] = $_REQUEST['md_idx'];

	$value['buytype'] = $_REQUEST['buytype'];
	$value['buylimits'] = $_REQUEST['buylimits'];
	insert("shop_goods",$value);
	unset($value);
	$idx  = $pdo->lastInsertId();

	$redata[res] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;

}
if($han=='set_goodsall')	{

	$idx = $_REQUEST['idx'];
	$daccount = $_REQUEST['daccount'];
	$saccount = $_REQUEST['saccount'];
	$account = $_REQUEST['account'];
	$gname = $_REQUEST['gname'];
	
	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value['gname'] = $_REQUEST['gname'][$i];
		$value['daccount'] = $_REQUEST['daccount'][$i]*100;
		$value['saccount'] = $_REQUEST['saccount'][$i]*100;
		$value['account'] = $_REQUEST['account'][$i]*100;
		update("shop_goods",$value," where index_no='".$idx[$i]."'");
		unset($value);
	}
	$redata[res] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_delgen')	{

	$index_no = $_REQUEST['index_no'];

	$pdo->prepare("delete from shop_genmemo where index_no='$index_no'")->execute();

	$redata[res] = 'ok';
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
?>
