<?php
function goaltalk($m,$arr)	{
	
	$q = "SELECT * FROM shop_config_msg WHERE msgtype='1' AND msgcode='$m'";
	$r = mysql_query($q);
	$row = mysql_fetch_array($r);

	if($row['index_no'])	{
		
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
		
		$row['msg'] = str_replace("#{상품명}",$arr['product'],$row['msg']);
		$row['msg'] = str_replace("#{주문번호}",$arr['orderno'],$row['msg']);
	
		$value['TRAN_ID'] = "METRO";
		$value['TRAN_SENDER_KEY'] = "349221f4dc92326a6e80ac539f522b25694b68a6";
		$value['TRAN_TMPL_CD'] = $row['msgtemplete'];
		$value['TRAN_CALLBACK'] = "0215661165";
		$value['TRAN_PHONE'] = $arr['cp'];
		$value['TRAN_MSG'] = $row['msg'];
		$value['TRAN_DATE'] = date("Y-m-d H:i:s");
		$value['TRAN_TYPE'] = "5";
		$value['TRAN_STATUS'] = "1";
		$value['TRAN_REPLACE_TYPE'] = "N";
		if($row['msgbutton']!='')	{
			$value['TRAN_BUTTON'] = $row['msgbutton'];
		}
		insert("MTS_ATALK_MSG",$value);
		unset($value);

	}
}


function trs($str)	{

	global $g_global;
	global $pdo;

	$lang = $g_global['lang'];
	
	$words = str_replace(" ","",$str);

	$q = "SELECT * FROM shop_trans_key WHERE wordkeys='$words'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isits = $st->rowCount();
	
	if($isits==0)	{
		$value['wordkeys'] = $words;
		insert("shop_trans_key",$value);
		unset($value);
	}
	else	{
		$row = $st->fetch();


		if($row['notrans']=='Y')	{
			return $str;
		}
	}

	$q = "SELECT * FROM shop_trans WHERE wordkeys='$words' AND lang='$lang'";
	$st = $pdo->prepare($q);
	$st->execute();
	
	$isits = $st->rowCount();

	if($isits==0)	{
		$value['wordkeys'] = $words;
		$value['lang'] = $lang;
		insert("shop_trans",$value);
		unset($value);
		return $str;
	}
	else	{

		$row = $st->fetch();


		if($row['chwords']!='')	{
			return $row['chwords'];
		}
		else	{
			return $str;
		}
	}
}
function trscode($code)	{

	global $g_global;
	global $pdo;

	$lang = $g_global['lang'];

	$q = "SELECT * FROM shop_transsc WHERE lang='$lang' AND wordkeys='$code'";
	$st = $pdo->prepare($q);
	$st->execute();
	$row = $st->fetch();

	return $row['chwords'];

}

function get_newaccount($ar_goods, $adds = "0")	{
	
	global $g_ar_curr;
	global $g_ar_init;
	global $G_MEMIDX;
	global $pdo;
	
	$sale_idx = 0;
	//전체 할인이 있는지 부터 확인
	$q = "SELECT * FROM shop_goods_sale WHERE fid='$g_ar_init[fid]' AND stype='2' AND sale_t='2' AND sdate<='" . date("Y-m-d H:i:s") . "' AND edate>='" . date("Y-m-d H:i:s") . "'";
	$st = $pdo->prepare($q);
	$st->execute();
	$row = $st->fetch();
	
	if($row['index_no'])	{
		$sale_idx = $row['index_no'];
	}
	//전체할인 검사끝..

	//특정기획전부분
	if($sale_idx==0)	{
		$q = "SELECT * FROM shop_goods_sale WHERE fid='$g_ar_init[fid]' AND stype='2' AND sale_t='4' AND sdate<='" . date("Y-m-d H:i:s") . "' AND edate>='" . date("Y-m-d H:i:s") . "'";
		$st = $pdo->prepare($q);
		$st->execute();
		while($row = $st->fetch())	{
			
			$qs = "select * from shop_event_goods where event_idx='$row[sale_t_arr]' and goods_idx='$ar_goods[index_no]'";
			$sts = $pdo->prepare($qs);
			$sts->execute();
			$rows = $sts->fetch();


			if($rows['index_no'])	{
				$sale_idx = $row['index_no'];
				break;
			}

		}
	}
	//특정기획전부분

	//특정카테고리부분
	if($sale_idx==0)	{
		$q = "SELECT * FROM shop_goods_sale WHERE fid='$g_ar_init[fid]' AND stype='2' AND sale_t='3' AND sdate<='" . date("Y-m-d H:i:s") . "' AND edate>='" . date("Y-m-d H:i:s") . "'";
		$st = $pdo->prepare($q);
		$st->execute();
		while($row = $st->fetch())	{
			
			$qs = "select * from shop_goods_cate where catecode='$row[sale_t_arr]' and goods_idx='$ar_goods[index_no]'";
			$sts = $pdo->prepare($qs);
			$sts->execute();
			$rows = $sts->fetch();

			if($rows['index_no'])	{
				$sale_idx = $row['index_no'];
				break;
			}

		}
	}

	//특정카테고리부분

	

	//개별상품부분
	if($sale_idx==0)	{
		$q = "SELECT * FROM shop_goods_sale WHERE fid='$g_ar_init[fid]' AND stype='2' AND sale_t='1' AND sdate<='" . date("Y-m-d H:i:s") . "' AND edate>='" . date("Y-m-d H:i:s") . "'";
		$st = $pdo->prepare($q);
		$st->execute();
		while($row = $st->fetch())	{
			
			$qs = "select * from goods_sale_ele where sale_idx='$row[index_no]' and goods_idx='$ar_goods[index_no]'";
			$sts = $pdo->prepare($qs);
			$sts->execute();
			$rows = $sts->fetch();

			if($rows['index_no'])	{
				$sale_idx = $row['index_no'];
				break;
			}

		}
	}
	//개별상품부분
	
	if($g_ar_init['curr']=='KRW')	{
		
		$ar_redata['account'] = $ar_goods[$g_ar_init['site_stdaccount']];
		$ar_redata['saccount'] = $ar_goods["s".$g_ar_init['site_stdaccount']];

	}
	else	{

		$q = "SELECT * FROM shop_goods_account WHERE goods_idx='$ar_goods[index_no]' AND stype='".$g_ar_init['curr']."'";
		$st = $pdo->prepare($q);
		$st->execute();
		$row = $st->fetch();
	
		if($row['index_no'])	{
			$ar_redata['account'] = $row['account'];
			$ar_redata['saccount'] = 0;


		}
		else	{
			$ar_redata['account'] = $ar_goods[$g_ar_init['site_stdaccount']];
			$ar_redata['saccount'] = $ar_goods["s".$g_ar_init['site_stdaccount']];

			$ar_redata['account'] = $ar_redata['account']*$g_ar_curr['ups'] / $g_ar_curr['currrate'];
			$ar_redata['saccount'] = $ar_redata['saccount']*$g_ar_curr['ups'] / $g_ar_curr['currrate'];
		}
	}

	$salego = "N";

	if($sale_idx != '0')	{
		$ar_sale = sel_query_all("shop_goods_sale", " where index_no='$sale_idx'");
        if($ar_sale['pid'] == '0')	{
			$salego = "Y";
		}
		else	{
			if($ar_sale['pid'] == $g_ar_init['index_no'])	{
				$salego = "Y";
			}
		}
	}

	if($salego == 'Y')	{
		if($ar_sale['saleop1'] == '2')	{
			//회원할인처리
			if(!$G_MEMIDX)	{
				$salego = "N";//세일적용 안됨
			}
		}
	}

	if($salego == 'Y')	{
		
		$ar_redata['sale_tpye'] = $ar_sale['stype'];
        $ar_redata['sale_idx'] = $sale_idx;
	
		if($ar_sale[saleops] == '1')	 {
			$ar_redata['account'] = $ar_redata['account'] + $adds;
		}
		if($ar_sale[saletype] == '1')	{
			//할인률이 %라면
			
			$sale = $ar_redata['account'] * $ar_sale['saleper'] / 100;

			if($ar_sale[saleper_std1] != '0')	{
				
				$sale = $sale / $ar_sale['saleper_std1'];

				if($ar_sale['saleper_std2'] == '1')	{
                            $sale = ceil($sale);
				}
				else if($ar_sale[saleper_std2] == '2'){
					$sale = round($sale);
				}
                else if($ar_sale[saleper_std2] == '3')	{
					$sale = floor($sale);
				}
				$sale = $sale * $ar_sale['saleper_std1'];
				$ac = $ar_redata['account'] - $sale;
			}
			else	{
				$ac = $ar_redata['account'] - $sale;
			}
		}
		else	{
			//할인률이 원 이라면
			$ac = $ar_redata['account'] - $ar_sale['saleper'];
		}
		
		if($ar_sale['saleops'] != '1')	{
			//옵션가는 할인 안한다면
			$ac = $ac + $adds;
		}
		if($ar_redata['saccount'] == 0)	{
			$ar_redata['saccount'] = $ar_redata['account'];
		}
		$ar_redata['account'] = $ac;
		
		$ar_redata['account'] = $ar_redata['account'] / 100;
		$ar_redata['saccount'] = $ar_redata['saccount'] / 100;

		return $ar_redata;
	}
	else	{

		$ar_redata['sale_tpye'] = "";
		$ar_redata['sale_idx'] = "";
		$ar_redata['account'] = $ar_redata['account'] / 100;
		$ar_redata['saccount'] = $ar_redata['saccount'] / 100;
		return $ar_redata;
	}
}


function _d($var, $logfile = null, $suffix = null){
	//$p = $_SERVER['DOCUMENT_ROOT'];
	$msg  = $_SERVER['PHP_SELF']."-------------------------------------".date("Y-m-d H:i:s.u\n");
	$msg .= print_r($var, true);
	$msg .= "\n";
	
	//$file = $p."/debug.log";
	if ( $logfile ) {
		$file = $logfile;
	} else {
		if ( $suffix ) {
			$suffix = $suffix . ".";
		}
		$file = "/tmp/debug.".$_SERVER['REMOTE_ADDR'].$suffix."log";
	}
	file_put_contents($file, $msg, FILE_APPEND);
}

function make_coupen($ar_coupen, $mem_idx, $log_idx = "")
{


    $fids = unserialize($ar_coupen[fids]);

    for($i = 0; $i < sizeof($fids); $i++)
    {
        if($fids[$i] != '')
        {

            $value[mem_idx] = $mem_idx;
            $value[coupen_idx] = $ar_coupen[index_no];
            $value[coupen_name] = $ar_coupen[coupenname];
            $value[mdate] = date("Y-m-d", time());

            if($ar_coupen[used] == '1')
            {
                $value[sdate] = $ar_coupen[startdates];
                $value[edate] = $ar_coupen[enddates];

            }
            else
            {
                if($ar_coupen[usedays] == 0)
                {
                    $ar_coupen[usedays] = 1000;
                }

                $value[sdate] = date("Y-m-d H:i:s", time());
                $value[edate] = date("Y-m-d", (time() + (86400 * $ar_coupen[usedays]))) . " 23:59:59";
            }
            $value[actype] = $ar_coupen[actype];
            $value[usetype] = $ar_coupen[usetype];
            $value[account] = $ar_coupen[account];
            $value[mtype] = "M";
            $value[mname] = $memname;
            $value[memo] = $_POST['memo'];
            $value[canuseac] = $ar_coupen[canuseac];
            $value[usesale] = $ar_coupen[usesale];
            $value[usegsale] = $ar_coupen[usegsale];
            $value[fids] = $fids[$i];
            $value[log_idx] = $log_idx;
            insert("shop_coupen_mem", $value);
            unset($value);
        }
    }
}
function get_fastdels($addr)	{

	global $pdo;

	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,"https://naveropenapi.apigw.ntruss.com/map-geocode/v2/geocode?query=".urlencode($addr));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'X-NCP-APIGW-API-KEY-ID: 1r7ktbtjhg',
		'X-NCP-APIGW-API-KEY: dQBMafIcSbghlUuD0cpGxYTuR4wqPHi9s8BV8M89'
	));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$output=curl_exec($ch);
	curl_close($ch);
	
	$res = json_decode($output);

	
	$points[] = $res->addresses[0]->y." ".$res->addresses[0]->x;
		
	$longitude_x = $res->addresses[0]->y;
	$latitude_y = $res->addresses[0]->x;
	
	$q = "select * from  shop_intro_store where deliver='Y'";
	$st = $pdo->prepare($q);
	$st->execute();
	$return = "";
	while($row = $st->fetch() )	{
		
		unset($vertices_x);
		unset($vertices_y);

		$qs = "select * from shop_intro_store_geometry where store_idx='$row[index_no]'";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		while($rows = $sts->fetch() )	{
			$vertices_x[] = $rows['loca2'];
			$vertices_y[] = $rows['loca1'];
			
		}
		$points_polygon = count($vertices_x) - 1;


		if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)){
			//echo "Is in polygon!";
			$return = array($row);
		}
	}

	return $return;
}
function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
{
  $i = $j = $c = 0;
  for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
    if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
     ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
       $c = !$c;
  }
  return $c;
}

class pointLocation {
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?

    function pointLocation() {
    }

    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;

        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }

        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);

        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }

    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }

    }

    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }

}
?>
