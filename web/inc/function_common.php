<?php
function sel_query_all($table, $where)	{
	
	global $pdo;

	$q = "select * from $table $where";

	$st = $pdo->prepare($q);
	$st->execute();
	$st->setFetchMode(PDO::FETCH_ASSOC);
	return $st->fetch();

}

function sel_query($table, $val, $where)	{

	global $pdo;

        $q = "select $val from $table $where";

        $st = $pdo->prepare($q);
        $st->execute();
        $st->setFetchMode(PDO::FETCH_ASSOC);
        return $st->fetch();
}
function insert($table, $values) {
    global $pdo;

    if (empty($values)) return false;

    $fields = [];
    $valList = [];

    foreach ($values as $index => $key) {
        $fields[] = $index;
        if ($index == 'passwd') {
            $valList[] = "MD5(" . $pdo->quote($key) . ")";
        } else {
            $valList[] = $pdo->quote($key);
        }
    }

    $fieldStr = implode(',', $fields);
    $valueStr = implode(',', $valList);

    $query = "INSERT INTO $table ($fieldStr) VALUES ($valueStr)";

    $st = $pdo->prepare($query);
    $r = $st->execute();

    return $r;
}

function update($table, $values, $where = "") {
    global $pdo;

    if (empty($values)) return false;

    $updateParts = [];

    foreach ($values as $index => $key) {
        if ($index === 'passwd') {
            $updateParts[] = "$index = MD5(" . $pdo->quote($key) . ")";
        } else {
            $updateParts[] = "$index = " . $pdo->quote($key);
        }
    }

    $setClause = implode(', ', $updateParts);
    $query = "UPDATE $table SET $setClause $where";

    $st = $pdo->prepare($query);
    $rs = $st->execute();

    return $rs;
}

function move_link($url)	{
	echo "<script>location.replace('$url'); </script>";
}
function show_message($msg,$re)	{
	
	//header("Content-Type: text/html; charset=UTF-8"); 

	echo "<script>alert('$msg');</script>";
	if($re)	{
		echo "<script>history.back(); </script>";
	}
	else	{

	}
}
function uploadfile($userfile,$tmpname,$i,$savedir)
{
	if($userfile=='')
	{	return "";	}
	else
	{
		$ar_rx = array("JPEG","jpeg","JPG","jpg","gif","GIF","BMP","bmp","png","PNG","xls","XLS","xlsx","XLSX","csv","CSV","hwp","HWP","pdf","PDF","txt","TXT","zip","PPT","ZIP","ppt","pptx","PPTX","mp4","MP4","mov","MOV","mov","webp","WEBP");
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
	$ar_rx = array("JPEG","jpeg","JPG","jpg","gif","GIF","BMP","bmp","png","PNG","xls","XLS","csv","CSV","xlsx","XLSX","zip","ZIP","ico","ICO","webp","WEBP");
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
/*
cutstr 함수 
*/
function cut_str_utf8($str, $len){
	preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match);
	$m = $match[0];
	$slen = strlen($str); // length of source string
	$tail = "..";
	$tlen = $tail; // length of tail string

	if ($slen <= $len) return $str;
	$ret = array();
	$count = 0;
	for ($i=0; $i < $len; $i++){
		$count += (strlen($m[$i]) > 1)?2:1;

		if ($count + $tlen > $len) break;
		$ret[] = $m[$i];
	}
	return join('', $ret).$tail;
}
?>
