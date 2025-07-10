<?php
function gotosms($cp,$return,$msg,$split = true,$lms = false, $ar_smsinfo = array()) {
	


	##### 데이터베이스에 연결한다.
	$connect2 = mysql_connect("175.126.232.238","apimsgserv","msg!@#$");
	if(!$connect2) {
		echo mysql_error();
		exit;
	}
		
	##### 작업대상 데이터베이스를 선택한다.
	$db2 = mysql_select_db("msgserv");
	if(!$db2) {
		echo mysql_error();
		exit;
	}

	mysql_query("set names 'utf8'");

	if($lms==true)	{
		

	}
	else	{
		$value['TRAN_PHONE'] = $cp;
		$value['TRAN_CALLBACK'] = $return;
		$value['TRAN_MSG'] = $msg;
		$value['TRAN_DATE'] = date("Y-m-d H:i:s");
		insert("MTS_SMS_MSG",$value);
	}
	
}
function JsonRet($data){
	header("Content-Type: application/json");
	header("Expires: 0");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	echo json_encode($data);
	exit;
}
function load_langpack($lang_file, $lang) {
	if (is_file($lang_file)) {
		$str_lang = file_get_contents($lang_file);
		$ar_lang = json_decode($str_lang);
		$langpack = $ar_lang->$lang;
		
		return $langpack;
	}
	
	return false;
}
function makethumb($jpg1, $jpg2, $width = 150, $height = 150, $type = "")	{
    
    if(!file_exists($jpg2))	{
        $quality = 100;
        if(!$jpg1 || !$jpg2) return;
       
		$ori_size = $size = @getimagesize($jpg1);       //0:width 1:height
        
		if(!$size) return;

        if($size[1] < $height)	{
            if($size[0] < $width)	{
                return;
            }
        }

        if($size[0] > $size[1])	{
            $size[1] = intval($size[1] * $width / $size[0]);
            $size[0] = $width;
        }
        else	{
            $size[0] = intval($size[0] * $height / $size[1]);
            $size[1] = $height;
        }

        if(!$jpg1 || !$jpg2) return;

        $str = "/usr/bin/convert -scene 0 -compress JPEG -quality 95 -resize $size[0]" . "x$size[1] $draw \"$jpg1\" \"$jpg2\"";
        exec($str);
    }
}
function showimg($ar_goods,$width="",$height="")	{
	
	global $_uppath;
	global $_imgserver;

	if($ar_goods['simg1']=='')	{
		return $_imgserver."/images/main/image_not_avail.jpg";
	}

	if($ar_goods['useoutimg']=='Y')	{
		return $ar_goods['simg1'];
	}
	else	{
		
		if($width!='' && $height!='')	{

			$ar_img = explode("/",$ar_goods['simg1']);
			
			if(sizeof($ar_img)==1)	{
				$jpg1 = $_uppath."goods/".$ar_goods['simg1'];
				$jpg2 = $_uppath."goods/tadmin.".$ar_goods['simg1'];
				makethumb($jpg1, $jpg2, $width, $height);
				return $_imgserver."/files/goods/tadmin.".$ar_goods['simg1'];
			}
			else	{
				$last = sizeof($ar_img)-1;
				$jpg1 = $_uppath."goods/".$ar_goods['simg1'];
				$jpg2 = $_uppath."goods/".str_replace($ar_img[$last],"tadmin.".$ar_img[$last],$ar_goods['simg1']);
				makethumb($jpg1, $jpg2, $width, $height);
				return $_imgserver."/files/goods/".str_replace($ar_img[$last],"tadmin.".$ar_img[$last],$ar_goods['simg1']);
			}

		}
		else	{
			return $ar_goods['simg1'];
		}
	}

}
function save_backup($dir, $fname, $ext, $content, $type = null) {
	
	$t = time();
	
	if (in_array($type, array('temp', 'ftp'))) {
		$file = "{$fname}.{$t}.{$_SESSION[member_index]}.{$type}";
	} else {
		$hname = sha1($fname);
		if ($type) {
			$_ext_backup = ".{$type}";
		}
		copy("{$dir}{$fname}.{$ext}", "{$dir}/_backup/{$hname}.{$ext}.{$t}.{$_SESSION[member_index]}{$_ext_backup}");
		$file = "{$fname}.{$ext}";
	}
	
	$savefile = $dir."/".$file;
	
	if (!file_put_contents($savefile, $content)) {
		//_d("save_backup error - write error");
	}

	//JSON 파일경우 뷰리파이어!!
	//if ('json' == $ext) {
	//	$tmpfname = tempnam("/tmp", "JSON_");
	//	exec("/usr/bin/jq . {$savefile} > {$tmpfname}");
	//	_d("/usr/bin/jq . {$savefile} > {$tmpfname}");
		//rename($tmpfname, $savefile);
	//}	
}
function formatElapse($seconds) {
	$days = floor($seconds/86400); 
	$time = $seconds - ($days*86400); 
	$hours = floor($time/3600); 
	$time = $time - ($hours*3600); 
	$min = floor($time/60); 
	$sec = $time - ($min*60); 
	 
	if ($days == 0 && $hours == 0 && $min == 0)
		return $sec."초 경과";
	elseif ($days == 0 && $hours == 0)
		return $min."분 경과";
	elseif ($days == 0)
		return $hours."시간 경과";
	else
		return $days."일 경과";	
}

function sel_query_all($table,$where)	{
	
	global $connect;

	$q = "select * from $table $where";
	$r = mysql_query($q);
	$row = mysql_fetch_array($r);

	return $row;
}
function sel_query($table,$val,$where)	{
	global $connect;


	$q = "select $val from $table $where";
	$r = mysql_query($q);
	$row = mysql_fetch_array($r);

	return $row;
}
function sel_query_inqs($q)	{
	
	$r = mysql_query($q);
	$row = mysql_fetch_array($r);

	return $row;
}
function sel_query_inql($q)	{
	
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		$data[] = $row;
	}

	return $data;
}

function show_message($msg,$re)	{
	
	header("Content-Type: text/html; charset=UTF-8"); 

	echo "<script>alert('$msg');</script>";
	if($re)	{
		echo "<script>history.back(); </script>";
	}
	else	{

	}
}
function move_link($url)	{
	echo "<script>location.replace('$url'); </script>";
}
function insert($table,$values){
		
		global $connect;

		$count=count($values);
		if(!$count) return false;
		
		$i=1;
		while(list($index,$key)=each($values)){
			if($i==$count){
				$field=$field.$index;
				if($index=='passwd')
				{	$value=$value."password('".$key."')";	}
				else
				{	$value=$value."'".$key."'";	}
			}
			else{
				$field=$field.$index.",";
				if($index=='passwd')
				{	$value=$value."password('".$key."'),";	}
				else
				{	$value=$value."'".$key."',";	}	
			}
			$i++;
		}

		$query="INSERT INTO $table ($field) VALUES ($value)";	// 실제 쿼리 생성
		$r = mysql_query($query);	
		return $r;	
	} 

function update($table,$values,$where=""){
		
		global $connect;
		$count=count($values);
		if(!$count)return false;

		$i=1;
	
		while(  list($index,$key)=each($values) ){
 
			if($i==$count)
			{
				if($index=='passwd')
				{	$value=$value.$index."=password('".$key."') ";	}
				else
				{	$value=$value.$index."='".$key."' ";	}
			}
			else
			{
				if($index=='passwd')
				{	$value=$value.$index."=password('".$key."'), ";	}
				else
				{	$value=$value.$index."='".$key."', ";	}
 			}
 
			$i++;

		}

		$query="UPDATE $table SET $value ".$where;	// 실제 쿼리 생성
  		$result=mysql_query($query);	
		return $result;	 		
	
}
function paging($page, $total_record, $num_per_page, $page_per_block, $qArr, $skin = null){
	if ( !$skin ) {
		$skin['prev'] = "<span class='btn_white_xs btn_prev'><a href=\"{$_SERVER[PHP_SELF]}?[[QUERY_STRING]]\"><i class='fa fa-angle-left'></i>이전</a></span>";
		$skin['curpage'] = "<strong class='current'>[[PAGE]]</strong>";
		$skin['paging'] = "<a href=\"{$_SERVER[PHP_SELF]}?[[QUERY_STRING]]\">[[PAGE]]</a>";
		$skin['next'] = "<span class='btn_white_xs btn_next'><a href=\"{$_SERVER[PHP_SELF]}?[[QUERY_STRING]]\">다음<i class='fa fa-angle-right'></i></a></span>";
	}
	
	$total_page = ceil($total_record/$num_per_page);

	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);

	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;

	if($total_block <= $block) {
		$last_page = $total_page;	
	}
	
	if ($block > 1) {
		//이전
		$before_page = $first_page;
		$qArr['page'] = $before_page;
		$qstr = http_build_query($qArr);
		$sRet[] = str_replace("[[QUERY_STRING]]", $qstr, $skin['prev']);
	}
	for($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++){
		//페이징
		if($page==$direct_page) {	
			$sRet[] = str_replace("[[PAGE]]", $direct_page, $skin['curpage']);
		} else {
			$qArr['page'] = $direct_page;
			$qstr = http_build_query($qArr);
			$sRet[] = str_replace(array("[[PAGE]]", "[[QUERY_STRING]]"), array($direct_page, $qstr), $skin['paging']);
		}
	}
	if ($block < $total_block) {
		//다음
		$daum_page = $last_page+1;
		$qArr['page'] = $daum_page;
		$qstr = http_build_query($qArr);
		$sRet[] = str_replace("[[QUERY_STRING]]", $qstr, $skin['next']);
	}

	if(is_array($sRet))
	{	return implode("\n", $sRet);	}
	else
	{	return "";	}
}
function admin_paging($page, $total_record, $num_per_page, $page_per_block, $qArr, $skin = null){
	if ( !$skin ) {
		$skin['prev'] = "<li><a href=\"{$_SERVER[PHP_SELF]}?[[QUERY_STRING]]\">«</a></li>";
		$skin['curpage'] = "<li class='active'><A href='#'>[[PAGE]]</a></li>";
		$skin['paging'] = "<li><a href=\"{$_SERVER[PHP_SELF]}?[[QUERY_STRING]]\">[[PAGE]]</a></li>";
		$skin['next'] = "<li><a href=\"{$_SERVER[PHP_SELF]}?[[QUERY_STRING]]\">»</a></li>";
	}
	
	$total_page = ceil($total_record/$num_per_page);

	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);

	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;

	if($total_block <= $block) {
		$last_page = $total_page;	
	}
	
	if ($block > 1) {
		//이전
		$before_page = $first_page;
		$qArr['page'] = $before_page;
		$qstr = http_build_query($qArr);
		$sRet[] = str_replace("[[QUERY_STRING]]", $qstr, $skin['prev']);
	}
	for($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++){
		//페이징
		if($page==$direct_page) {	
			$sRet[] = str_replace("[[PAGE]]", $direct_page, $skin['curpage']);
		} else {
			$qArr['page'] = $direct_page;
			$qstr = http_build_query($qArr);
			$sRet[] = str_replace(array("[[PAGE]]", "[[QUERY_STRING]]"), array($direct_page, $qstr), $skin['paging']);
		}
	}
	if ($block < $total_block) {
		//다음
		$daum_page = $last_page+1;
		$qArr['page'] = $daum_page;
		$qstr = http_build_query($qArr);
		$sRet[] = str_replace("[[QUERY_STRING]]", $qstr, $skin['next']);
	}

	if(is_array($sRet))
	{	return implode("\n", $sRet);	}
	else
	{	return "";	}
}


function uploadfile($userfile,$tmpname,$i,$savedir)
{
	if($userfile=='')
	{	return "";	}
	else
	{
		$ar_rx = array("JPEG","jpeg","JPG","jpg","gif","GIF","BMP","bmp","png","PNG","xls","XLS","xlsx","XLSX","csv","CSV","hwp","HWP","pdf","PDF","txt","TXT","zip","PPT","ZIP","ppt","pptx","PPTX");
		$filename = $userfile;
		$ex_filename = explode(".",$filename);
		$extension = $ex_filename[sizeof($ex_filename)-1];
		$filename = time() . "_" . $i. ".".$extension;
		$dest = $savedir.date("YW")."/".$filename;
		if(!is_dir($savedir.date("YW")."/"))	{
			@mkdir($savedir.date("YW")."/",0777);
		}
		$cou = 1;
		
		if(!in_array($extension,$ar_rx))
		{
			return "Aaa";
		}

		while(1)
		{
			if(file_exists($dest))
			{
				$filename = time() . "_" . $i. "[$cou].".$extension;
				$dest = $savedir.$filename;
				$cou++;
			}
			else
			{	break;	}
		}
		
		if(!copy($tmpname,$dest))
		{
			echo "<script>alert('$tmpname $dest 업로드에 실패하였습니다.'); history.back(); </script>";
			exit;
		}
		if(!unlink($tmpname))
		{
			echo "<script>alert('업로드에 실패하였습니다.'); history.back(); </script>";
			exit;
		}
		return date("YW")."/".$filename;
	}
}
function uploadfile_mod($userfile,$tmpname,$i,$savedir,$last,$delfile)
{
	$ar_rx = array("JPEG","jpeg","JPG","jpg","gif","GIF","BMP","bmp","png","PNG","xls","XLS","csv","CSV","xlsx","XLSX","zip","ZIP","ico","ICO");
	if($userfile=='')
	{	
		if($delfile=='Y')
		{	@unlink($savedir.$filename);	return "";		}
		else
		{	return $last;	}
		
	}
	else
	{
		@unlink($savedir.$filename);
		$filename = $userfile;
		$ex_filename = explode(".",$filename);
		$extension = $ex_filename[sizeof($ex_filename)-1];
		$filename = time() . "_" . $i. ".".$extension;
		$dest = $savedir.date("YW")."/".$filename;
		if(!is_dir($savedir.date("YW")."/"))	{
			@mkdir($savedir.date("YW")."/",0777);
		}

		if(!in_array($extension,$ar_rx))
		{
			return;
		}

		$cou = 1;
		while(1)
		{
			if(file_exists($dest))
			{
				$filename = time() . "_" . $i. "[$cou].".$extension;
				$dest = $savedir.$filename;
				$cou++;
			}
			else
			{	break;	}
		}
		
		if(!copy($tmpname,$dest))
		{
			echo "<script>alert('업로드에 실패하였습니다.'); history.back(); </script>";
			exit;
		}
		if(!unlink($tmpname))
		{
			echo "<script>alert('업로드에 실패하였습니다.'); history.back(); </script>";
			exit;
		}


		return date("YW")."/".$filename;
	}
}
function get_lefts($goods_idx,$op1,$op2,$op3)	{
	$ar_lefts = sel_query_all("shop_goods_lefts"," where goods_idx='$goods_idx' and op1='$op1' and op2='$op2' and op3='$op3'");
	if($ar_lefts)
	{	$lefts = $ar_lefts[lefts_l];	}
	else
	{	$lefts = 0;	}
	

	return $lefts;
}
function set_lefts($goods_idx,$op1,$op2,$op3,$arr)
{
	global $basictb;
	$ar_lefts = sel_query_all("shop_goods_lefts"," where goods_idx='$goods_idx' and op1='$op1' and op2='$op2' and op3='$op3'");
	if($ar_lefts)
	{	update("shop_goods_lefts",$arr," where goods_idx='$goods_idx' and op1='$op1' and op2='$op2' and op3='$op3'");	}
	else
	{	
		$arr[goods_idx] = $goods_idx;
		$arr[op1] = $op1;
		$arr[op2] = $op2;
		$arr[op3] = $op3;
		insert("shop_goods_lefts",$arr);	
	}
	unset($value);
}
function newmarketdb_memo($msg1,$market_idx,$msg2,$memname="")
{


	$value[market_idx] = $market_idx;
	$value[wtype] = $msg1;	
	$value[memo] = $msg2;
	$value[wdate] = time();
	if($memname=='')
	{	$value[writer_s] = "시스템";	}
	else
	{	$value[writer_s] = $memname;	}
	$value[isauto] = "Y";
	insert("shop_newmarketdb_memo",$value);
}
function update_member_point($mem_idx,$account,$mode,$msg,$chname)	{


	if($mem_idx==0)	{
		return false;	
	}

	$q = "select mempoints from shop_member where index_no='$mem_idx'";
	$r = mysql_query($q);
	$row = mysql_fetch_array($r);
	
	$mempoints = $row[mempoints];
	
	if($mode=='up')	{
		$uppoint = $mempoints + $account;	
	}
	else	{
		$uppoint = $mempoints - $account;	
	}

	if($uppoint<0)	{
		return false;	
	}
	mysql_query("update shop_member set mempoints='$uppoint' where index_no='$mem_idx'");
	
	unset($value);
	$value[market_idx] = $index_no;
	$value[mem_idx] = $mem_idx;
	if($mode=='up')
	{
		$value[income] = $account;
		$value[outcome] = 0;
	}
	else
	{
		$value[income] = 0;
		$value[outcome] = $account;
	}
	$value[memo] = $msg;
	$value[total] = $uppoint;
	$value[wdate_s] = date("Y-m-d",time());
	$value[hour_s] = date("H:i:s",time());
	$value[ch_name] = $chname;
	insert("shop_member_points",$value);
	unset($value);

	return true;
}