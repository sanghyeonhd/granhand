<?php
$QUERY_STRING = $_SERVER["QUERY_STRING"];
$PHP_SELF = $_SERVER["PHP_SELF"];
if($QUERY_STRING)
	{ $url = $PHP_SELF . "?" . $QUERY_STRING; }
else
	{ $url = $PHP_SELF; }

$url = urlencode($url);

if(!$_SESSION['member_index'])
{
	echo "<script>location.replace('/index.php?url=$url');</script>";
	exit;

}
if($g_ar_init_member['amemgrade']=='0')
{
	echo "<script>alert('권한이 없습니다'); history.back(); </script>";
	exit;
}