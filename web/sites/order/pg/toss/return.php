<?php
//ini_set("display_errors", 1);
require_once ("../../../../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_site.php";



$orderId = $_REQUEST['orderId'];
$paymentKey = $_REQUEST['paymentKey'];
$amount = $_REQUEST['amount'];

$widgetSecretKey = "test_gsk_docs_OaPz8L5KdmQXkzRz3y47BMw6";
$apiSecretKey = "test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R";

$encryptedWidgetSecretKey = "Basic " . base64_encode($widgetSecretKey . ":");
$encryptedApiSecretKey = "Basic " . base64_encode($apiSecretKey . ":");

$billingKeyMap = [];

$postData = json_encode([
	'orderId' => $orderId,
    'amount' => $amount,
    'paymentKey' => $paymentKey
]);

$response = sendRequest("https://api.tosspayments.com/v1/payments/confirm", $encryptedWidgetSecretKey, $postData);


// 응답 데이터를 JSON 형식으로 파싱
$responseData = json_decode($response, true);

if(isset($responseData["code"]))	{
	
	echo "<script>alert('".$responseData["message"]."'); location.replace('/order/?act=cart'); </script>";
	exit;
}	else	{
	
	$ar_pg = sel_query_all("shop_config_pay"," WHERE pid='$g_ar_init[idx]' AND buymethod='C'");
	$ar_or = explode("_",$orderId);
	
	$idx = $ar_or[1];
	$nowdate = time();
	$indate = date("Y-m-d",time());
	$intime = date("H:i:s",time());

	$ar_market = sel_query_all("shop_newmarketdb"," where idx='$idx'");
	if($ar_market['buymethod']=='I')	{
		$value['dan'] = "1";
		$value['odate'] = $indate." ".$intime;
		update("shop_newmarketdb",$value," WHERE idx='$idx'");
		unset($value);
	}	else	{
		$value['dan'] = "2";
		$value['odate'] = $indate." ".$intime;
		$value['incdate'] = $indate." ".$intime;
		update("shop_newmarketdb",$value," WHERE idx='$idx'");
		unset($value);
	}
	if($ar_market['buymethod']=='C')	{
		$value['tbtype'] = "I";
		$value['market_idx'] = $idx;
		$value['buymethod'] = $ar_market['buymethod'];
		$value['account'] = intval($amount)*100;
		$value['incdate'] = $indate;
		$value['inctime'] =  $intime;
		$value['incdaten'] = date("Y-m-d H:i:s");
		$value['usepg'] = $ar_pg['pgcom'];
		$value['usepgid'] = $ar_pg['pgid'];
		$value['rawdata'] = $response;
		insert("shop_newmarketdb_accounts",$value);
		unset($value);		
	}	
	
	$pdo->prepare("delete from shop_newbasket_tmp where market_idx='$idx'")->execute();
			
	echo "<script>location.replace('/order/?act=order_over&idx=$idx'); </script>";
	exit;		
}

// 주요 파라미터 추출
$orderId = $responseData['orderId'] ?? null;
$status = $responseData['status'] ?? null;
$receiptUrl = $responseData['receipt']['url'] ?? null;


function sendRequest($url, $authKey, $postData) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $authKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>