<?php
function admin_paging($page, $total_record, $num_per_page, $page_per_block, $qArr, $skin = null) {
    if (!is_array($skin)) {
        $php_self = $_SERVER['PHP_SELF'];
        $skin = [
            'prev'    => "<li><a href=\"{$php_self}?[[QUERY_STRING]]\">«</a></li>",
            'curpage' => "<li class='active'><a href='#'>[[PAGE]]</a></li>",
            'paging'  => "<li><a href=\"{$php_self}?[[QUERY_STRING]]\">[[PAGE]]</a></li>",
            'next'    => "<li><a href=\"{$php_self}?[[QUERY_STRING]]\">»</a></li>"
        ];
    }

    $sRet = [];

    $total_page  = (int)ceil($total_record / $num_per_page);
    $total_block = (int)ceil($total_page / $page_per_block);
    $block       = (int)ceil($page / $page_per_block);

    $first_page = ($block - 1) * $page_per_block;
    $last_page  = $block * $page_per_block;

    if ($total_block <= $block) {
        $last_page = $total_page;
    }

    // 이전 블록
    if ($block > 1) {
        $qArr['page'] = $first_page;
        $qstr = htmlspecialchars(http_build_query($qArr));
        $sRet[] = str_replace('[[QUERY_STRING]]', $qstr, $skin['prev']);
    }

    // 페이지 목록
    for ($direct_page = $first_page + 1; $direct_page <= $last_page; $direct_page++) {
        $qArr['page'] = $direct_page;
        $qstr = htmlspecialchars(http_build_query($qArr));

        if ($page == $direct_page) {
            $sRet[] = str_replace('[[PAGE]]', $direct_page, $skin['curpage']);
        } else {
            $sRet[] = str_replace(
                ['[[PAGE]]', '[[QUERY_STRING]]'],
                [$direct_page, $qstr],
                $skin['paging']
            );
        }
    }

    // 다음 블록
    if ($block < $total_block) {
        $qArr['page'] = $last_page + 1;
        $qstr = htmlspecialchars(http_build_query($qArr));
        $sRet[] = str_replace('[[QUERY_STRING]]', $qstr, $skin['next']);
    }

    return !empty($sRet) ? implode("\n", $sRet) : '';
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
function update_member_point($mem_idx,$account,$mode,$msg,$chname)	{
	
	global $pdo;

	if($mem_idx==0)	{
		return false;	
	}

	$st =  $pdo->prepare("select mempoints from shop_member where index_no='$mem_idx'");
	$st->execute();
	$row = $st -> fetch();
	
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
	$st =  $pdo->prepare("update shop_member set mempoints='$uppoint' where index_no='$mem_idx'")->execute();
	
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
?>