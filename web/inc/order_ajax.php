<?php
if($han=='set_order')	{
	


	if($_SESSION['member_index'])	{
		$value['mem_idx'] = $G_MEMIDX;
		$value['memg'] = $g_ar_init_member['memgrade'];
	}
	$value['name'] = addslashes(trim($_POST['name']));
	$value['name_etc'] = addslashes(trim($_POST['name_etc']));
	$value['email'] = addslashes(trim($_POST['email']));
	$value['passwds'] = addslashes(trim($_POST['passwds']));
	$value['phone'] = $_POST['phone1']."-".$_POST['phone2']."-".$_POST['phone3'];
	$value['cp'] = $_POST['cp1'];
	if($_POST['cp2'])	{
		$value['cp'] = $value['cp'] ."-".$_POST['cp2'];
	}
	if($_POST['cp3'])	{
		$value['cp'] = $value['cp'] ."-".$_POST['cp3'];
	}
	$value['del_name'] = addslashes(trim($_POST['del_name']));
	$value['del_name_etc'] = addslashes(trim($_POST['del_name_etc']));
	
	if($g_ar_init['site_del1']=='Y')	{
		$value['del_loc'] = "1";
	}
	else	{
		$value['del_loc'] = "2";
	}
	$value['del_zipcode'] = addslashes(trim($_POST['del_zip']));
	$value['del_addr1'] = addslashes(trim($_POST['del_addr1']));
	$value['del_addr2'] = addslashes(trim($_POST['del_addr2']));

	$value['del_phone'] = $_POST['del_phone1']."-".$_POST['del_phone2']."-".$_POST['del_phone3'];
	$value['del_cp'] = $_POST['del_cp1'];
	if($_POST['del_cp2'])	{
		$value['del_cp'] = $value['del_cp'] ."-".$_POST['del_cp2'];
	}
	if($_POST['del_cp3'])	{
		$value['del_cp'] = $value['del_cp'] ."-".$_POST['del_cp3'];
	}

	$value['memo'] = addslashes(trim($_POST['memo']));
	$value['buymethod'] = addslashes(trim($_POST['buymethod']));

	$value['account'] = addslashes(trim($_POST['account']))*100;
	$value['use_account'] = addslashes(trim($_POST['use_account']))*100;
	$value['use_mempoint'] = addslashes(trim($_POST['use_mempoint']));
	if(!$value['use_mempoint'])	{
		$value['use_mempoint'] = 0;
	}
	else	{
		$value['use_mempoint'] = $value['use_mempoint'] * 100;
	}
	$value['use_memaccount'] = addslashes(trim($_POST['use_memaccount']));
	if(!$value['use_memaccount'])	{
		$value['use_memaccount'] = 0;
	}
	else	{
		$value['use_memaccount'] = 0*100;
	}
	$value['delaccount'] = $_POST['delaccount']*100;
	$value['adddelaccount'] = $_POST['adddelaccount']*100;
	$delaccount = $value['delaccount'] + $value['adddelaccount'];
	$value['orderno'] = time();
	$value['nip'] = $G_NIP;
	$value['fid'] = $g_ar_init['fid'];
	$value['pid'] = $g_ar_init['index_no'];
	$value['language'] = $g_global['lang'];
	$value['trs'] = $g_ar_init['curr'];
	$value['sdate'] = date("Y-m-d H:i:s");

	$value['country'] = $_POST['country'];
	$value['city'] = $_POST['city'];
	$value['state'] = $_POST['state'];
	
	$coup2 = $_REQUEST['coup2'];
	if($coup2!='')	{
		$value['use_coupen2'] = $_POST[use_coupen2]*100;	
	}
	else	{
		$value['use_coupen2'] = 0;	
	}
	if( $G_MOBIENV->isMobile() )	{
		$value['useenv'] = "M";
	}
	else	{
		$value['useenv'] = "PC";
	}

	$r = insert("shop_newmarketdb",$value);
	if(!$r)	{
		$redata['res'] = "error";
		$redata['resmsg'] = trscode('ORDER12')."[".mysql_error()."]";
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}
	$market_idx = $pdo->lastInsertId();
	unset($value);

	if($_SESSION['member_index'])	{
		
		$value['zipcode'] = addslashes(trim($_POST['del_zip']));
		$value['email'] = addslashes(trim($_POST['email']));
		$value['addr1'] = addslashes(trim($_POST['del_addr1']));
		$value['addr2'] = addslashes(trim($_POST['del_addr2']));
		update("shop_member",$value," WHERE index_no='$G_MEMIDX'");
		unset($value);
	}
	

	$ar_basket = explode("-",$_POST['basketindex']);
	for($i=0;$i<sizeof($ar_basket);$i++)	{

		if($ar_basket[$i]!='')	{
			
			$ar_tb = sel_query_all("shop_newbasket_tmp"," WHERE index_no='".$ar_basket[$i]."'");

			$value['market_idx'] = $market_idx;
			if($_SESSION['member_index'])	{
				$value['mem_idx'] = $G_MEMIDX;
			}
			$value['goods_idx'] = $ar_tb['goods_idx'];
			$value['op1'] = $ar_tb['op1'];
			$value['op2'] = $ar_tb['op2'];
			$value['op3'] = $ar_tb['op3'];
			
			$ar_goods = sel_query_all("shop_goods"," WHERE index_no='$ar_tb[goods_idx]'");
			$ar_maccount = get_newaccount($ar_goods);
			
			if($ar_tb['op1']!='')	{
				$ar_op1 = sel_query_all("shop_goods_op1"," WHERE index_no='$ar_tb[op1]'");

				if($ar_op1['addac']!=0)	{
					$ar_maccount['account'] = $ar_maccount['account'] + $ar_op1['addac']/100;
					if($ar_maccount['saccount']!=0)	{
						$ar_maccount['saccount'] = $ar_maccount['saccount'] + $ar_op1['addac']/100;
					}
				}
			}
			if($ar_tb['op2']!='')	{
				$ar_op2 = sel_query_all("shop_goods_op2"," WHERE index_no='$ar_tb[op2]'");

				if($ar_op2['addac']!=0)	{
					$ar_maccount['account'] = $ar_maccount['account'] + $ar_op2['addac']/100;
					if($ar_maccount['saccount']!=0)	{
						$ar_maccount['saccount'] = $ar_maccount['saccount'] + $ar_op2['addac']/100;
					}
				}
			}

			$value['oraccount'] = $ar_maccount['saccount']*100;
			$value['saccount'] = $ar_maccount['account']*100;
			$value['account'] = $ar_maccount['account']*100;
			$value['ea'] = $ar_tb['ea'];
			$value['sdate'] = date("Y-m-d H:i:s");
			$value['gtype'] = $ar_goods['gtype'];
			if($coup2!='')	{
				$value['coupac'] = calcp($coup2,$ar_basket[$i]."-".($ar_maccount['saccount']*100)."-".($ar_maccount['account']*100));
			}

			insert("shop_newbasket",$value);
			unset($value);
			
			if($ar_tb['gtype']=='2')	{

				$set_idx = $pdo->lastInsertId();
				
				$qs = "Select * from shop_goods_sets where sets_idx='".$ar_tb['goods_idx']."'";
				if($ar_tb['op1']!='')	{
					$qs = $qs . " AND sets_op='".$ar_tb['op1']."'";
				}
				$sts = $pdo->prepare($qs);
				$sts->execute();
				while($rows = $sts->fetch() )	{
					
					if($_SESSION['member_index'])	{
						$value['mem_idx'] = $G_MEMIDX;
					}
					$value['market_idx'] = $market_idx;
					$value['goods_idx'] = $rows['goods_idx'];
					$value['op1'] = $rows['op1'];
					$value['op2'] = $rows['op2'];
					$value['op3'] = $rows['op3'];
					$value['ea'] = $rows['ea'];
					$value['set_idx'] = $set_idx;
					$value['sdate'] = date("Y-m-d H:i:s");
					$value['gtype'] = "1";
					insert("shop_newbasket",$value);
					unset($value);

				}

			}


			$value['market_idx'] = $market_idx;
			update("shop_newbasket_tmp",$value," WHERE index_no='".$ar_basket[$i]."'");
			unset($value);
		}

	}
	
	if($coup2!='')	{
		$value['market_idx'] = $market_idx;
		update("shop_coupen_mem",$value," where index_no='$coup2'");
		unset($value);
	}

	$rewardc = $_REQUEST['rewardc'];
	for($i=0;$i<sizeof($rewardc);$i++)	{
		
		$c_idx = $rewardc[$i];
		$value['market_idx'] = $market_idx;
		update("shop_coupen_mem",$value," where index_no='$c_idx'");
		unset($value);

		$ar_coupen_mem = sel_query_all("shop_coupen_mem"," where index_no='$c_idx'");
		$ar_coupen = sel_query_all("shop_coupen"," where index_no='$ar_coupen_mem[coupen_idx]'");

		$ar_tps = explode("|R|",$ar_coupen['give_goods_infos']);

		for($j=0;$j<sizeof($ar_tps);$j++)	{
			
			if($ar_tps[$j]=='')	{
				continue;
			}

			$ar_tp2 = explode("|-|",$ar_tps[$j]);

			$value['market_idx'] = $market_idx;
			if($_SESSION['member_index'])	{
				$value['mem_idx'] = $G_MEMIDX;
			}
			$value['goods_idx'] = $ar_tp2[0];
			$value['oraccount'] = 0;
			$value['saccount'] = 0;
			$value['account'] = 0;
			$value['ea'] = $ar_tp2[1];
			$value['sdate'] = date("Y-m-d H:i:s");
			$value['gtype'] = 6;
			insert("shop_newbasket",$value);
			unset($value);
		}
	}

	if($delaccount!=0)	{
		$value['market_idx'] = $market_idx;
		if($_SESSION['member_index'])	{
			$value['mem_idx'] = $G_MEMIDX;
		}

		$value['oraccount'] = $delaccount;
		$value['saccount'] = $delaccount;
		$value['account'] = $delaccount;
		$value['ea'] = 1;
		$value['sdate'] = date("Y-m-d H:i:s");
		$value['gtype'] = 5;
		insert("shop_newbasket",$value);
		unset($value);
	}

	$redata['res'] = "ok";
	$ar_market = sel_query_all("shop_newmarketdb"," WHERE index_no='$market_idx'");
	$ar_market['goaccount'] = $ar_market['use_account'] * 100;
	$redata['datas'] = $ar_market;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
if($han=='set_pg')	{
	
	$index_no = $_REQUEST['index_no'];
	$ar_data = sel_query_all("shop_newmarketdb"," WHERE index_no='$index_no'");

	if( $G_MOBIENV->isMobile() )	{
		
		$ar_pg = sel_query_all("shop_config_pay"," WHERE pid='$g_ar_init[index_no]' AND buymethod='$ar_data[buymethod]'");
		
		if($ar_pg['pgcom']=='WELCOME')	{
			
			require_once($_basedir.'/sites/order/pgs/INICIS/libs2/StdPayUtil.php');
			$SignatureUtil = new INIStdPayUtil();

			//$mid = "wpomeal200";	
			//$signKey = "V25RUHhXN2VHYUtiM1AzRlRlK0V5Zz09";	// 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)

			$mid = "welcometst";  // 가맹점 ID(가맹점 수정후 고정)					
			$signKey = "QjZXWDZDRmxYUXJPYnMvelEvSjJ5QT09"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
			$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

			$oid = $index_no; // 가맹점 주문번호(가맹점에서 직접 설정)
			$price = $ar_data['use_account']/100;        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

			$cardNoInterestQuota = ""; // 카드 분담 무이자 여부 설정(별도 카드사와 계약한 가맹점에서 직접 설정 예시: 11-2:3,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4)
			$cardQuotaBase = "2:3:4";  // 가맹점에서 사용할 할부 개월수 설정

			//###################################
			// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
			//###################################
			$mKey = $SignatureUtil->makeHash($signKey, "sha256");

			$params = array(
				"mkey" => $mKey,
			    "P_AMT" => $price,
			    "P_OID" => $oid,
			    "P_TIMESTAMP" => $timestamp
			);

			$sign = $SignatureUtil->makeSignature($params, "sha256");
			
			$redata['res'] = "ok";
			$ar_data['timestamp'] = $timestamp;
			$ar_data['sign'] = $sign;
			$ar_data['mKey'] = $mKey;
			$ar_data['raccount'] = $price;

			if($ar_data['buymethod']=='C')	{
				$ar_data['gopaymethod'] = "Card";
			}
			if($ar_data['buymethod']=='R')	{
				$ar_data['gopaymethod'] = "DirectBank";
			}
			if($ar_data['buymethod']=='I')	{
				$ar_data['gopaymethod'] = "Vbank";
			}
		
			$ar_data['pgcom'] = $ar_pg['pgcom'];
			$ar_data['ismobile'] = $G_MOBIENV->isMobile();

			$q = "select * from shop_newbasket where market_idx='$index_no' and gtype='1'";
			$st = $pdo->prepare($q);
			$st->execute();
			$gname = "";
			while($row = $st->fetch() )	{
				if($ganme!='')	{
					$gname = $gname ." , ";
				}
				$ar_goods = sel_query_all("shop_goods"," where index_no='$row[goods_idx]'");
				$gname = $gname . $ar_goods['gname'];
			}
			$ar_data['gname'] = $gname;

			$redata['datas'] = $ar_data;
			$result = json_encode ($redata);
			header ( 'Content-Type:application/json; charset=utf-8' );
			echo $result;
			exit;

		}

	}
	else	{
		
		$ar_pg = sel_query_all("shop_config_pay"," WHERE pid='$g_ar_init[index_no]' AND buymethod='$ar_data[buymethod]'");
		
		if($ar_pg['pgcom']=='WELCOME')	{
			
			require_once($_basedir.'/sites/order/pgs/INICIS/libs/INIStdPayUtil.php');
			$SignatureUtil = new INIStdPayUtil();

			$mid = "wpomeal200";	
			$signKey = "V25RUHhXN2VHYUtiM1AzRlRlK0V5Zz09";	// 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
			$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성
			$price = $ar_data['use_account']/100;        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

			$cardNoInterestQuota = "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
			$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
			//###################################
			// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
			//###################################
			$mKey = $SignatureUtil->makeHash($signKey, "sha256");

			$params = array(
				"mKey" => $mKey,
			    "oid" => $ar_data['index_no'],
			    "price" => $price,
			    "timestamp" => $timestamp
			);
			$sign = $SignatureUtil->makeSignature($params);
			
			$redata['res'] = "ok";
			$ar_data['timestamp'] = $timestamp;
			$ar_data['sign'] = $sign;
			$ar_data['mKey'] = $mKey;
			$ar_data['raccount'] = $price;

			if($ar_data['buymethod']=='C')	{
				$ar_data['gopaymethod'] = "Card";
			}
			if($ar_data['buymethod']=='R')	{
				$ar_data['gopaymethod'] = "DirectBank";
			}
			if($ar_data['buymethod']=='I')	{
				$ar_data['gopaymethod'] = "Vbank";
			}
		
			$ar_data['pgcom'] = $ar_pg['pgcom'];
			$ar_data['ismobile'] = $G_MOBIENV->isMobile();

			$q = "select * from shop_newbasket where market_idx='$index_no' and gtype='1'";
			$st = $pdo->prepare($q);
			$st->execute();
			$gname = "";
			while($row = $st->fetch() )	{
				if($ganme!='')	{
					$gname = $gname ." , ";
				}
				$ar_goods = sel_query_all("shop_goods"," where index_no='$row[goods_idx]'");
				$gname = $gname . $ar_goods['gname'];
			}
			$ar_data['gname'] = $gname;
			$redata['datas'] = $ar_data;
			$result = json_encode ($redata);
			header ( 'Content-Type:application/json; charset=utf-8' );
			echo $result;
			exit;

		}
	}

}
if($han=='set_coupen')	{
	
	$cpstr = $_REQUEST['cpstr'];
	$coupen_idx = $_REQUEST['coupen_idx'];

	$ar_mem_coupen = sel_query_all("shop_coupen_mem"," where index_no='$coupen_idx'");
	$ar_coupen = sel_query_all("shop_coupen"," where index_no='$ar_mem_coupen[coupen_idx]'");

	if($ar_coupen[saleper_std1])	{	
		$ar_coupen[saleper_std1] = $ar_coupen[saleper_std1]*10;	
	}
	else	{	
		$ar_coupen[saleper_std1] = 100;	
	}


	if($ar_coupen[nousecate]!='')
	{	$ar_nousecate = explode("-",$ar_coupen[nousecate]);	}
	if($ar_coupen[nousegoods]!='')
	{	$ar_nousegoods = explode("-",$ar_coupen[nousegoods]);	}
	if($ar_coupen[usegoods]!='')
	{	$ar_usegoods  = explode("-",$ar_coupen[usegoods]);	}
	if($ar_coupen[usecate]!='')
	{	$ar_usecate = explode("-",$ar_coupen[usecate]);	}

	$ar_cpstr = explode("|R|",$cpstr);

	$total1 = 0;
	$total2 = 0;
	$total3 = 0;
	for($i=0;$i<sizeof($ar_cpstr);$i++)
	{
	
		if($ar_cpstr[$i]!='')
		{

			$ar_rdata = explode("-",$ar_cpstr[$i]);
			$ar_basket = sel_query_all("shop_newbasket_tmp"," where index_no='$ar_rdata[0]'");
			$goods_idx = $ar_basket[goods_idx];
			$ea = $ar_basket[ea];
			$account = $ar_rdata[2];
			$dis = 0;
			$cancp = $ar_rdata[1];
		

			if($cancp=='Y')
			{
				$qs = "select fid,shop_goods_cate.catecode from shop_goods_cate,shop_cate where goods_idx='$goods_idx' and shop_cate.catecode=shop_goods_cate.catecode";
				$sts = $pdo->prepare($qs);
				$sts->execute();
				unset($ar_goods_cate);
				$ar_goods_cate[0] = "";
				$cou = 0;
				while($rows = $sts->fetch())
				{
					$ar_goods_cate[$cou] = $rows[fid]."|R|".$rows[catecode];
	
					$cou++;
				}
			
				if($ar_coupen[prod1]=='1')
				{
					$rt = "Y";
					if($ar_coupen[prod2]=='2')
					{
						for($k=0;$k<sizeof($ar_nousecate);$k++)
						{	

							if(in_array($ar_nousecate[$k],$ar_goods_cate)  && $ar_nousecate[$k]!='')
							{	
							
								$rt = "N";	break;	
							}
						}
						if($rt=='Y')
						{
							if(is_array($ar_nousegoods))
							{
								if(in_array($goods_idx,$ar_nousegoods))
								{	$rt = "N";		}
							}
						}
					}
				}
			
				if($ar_coupen[prod1]=='2')
				{
					$rt = "N";
					for($k=0;$k<sizeof($ar_usecate);$k++)
					{
						if(in_array($ar_usecate[$k],$ar_goods_cate))
						{	$rt = "Y";	break;	}
					}
	
				}

				if($ar_coupen[prod1]=='3')
				{
					$rt = "N";
					if(in_array($goods_idx,$ar_usegoods))
					{	$rt = "Y";	}
	
				}

			
			
				if($rt=='Y')
				{
					$makeac = 0;
					if($ar_coupen[actype]=='2')
					{
						if($ar_coupen[usesale]=='1')
						{
							if($dis==0)
							{
								$makeac = $account * $ar_coupen[account]/100;
	

							
							

							
								//if($ar_coupen[saleper_std2]=='3')
								//{	$makeac = floor($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}
									
								//else if($ar_coupen[saleper_std2]=='2')
								//{	$makeac = round($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}

								//else if($ar_coupen[saleper_std2]=='1')
								//{	$makeac = ceil($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}

								//else
								//{	$makeac = floor($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}
							
								$makeac = $makeac / $ar_coupen[saleper_std1] * $ar_coupen[saleper_std1];
							
								$total3 = $total3 + $makeac*$ea;
								$total1 = $total1 + $account*$ea;
								$total2 = $total2 + $dis*$ea;
							}
						}
						else
						{
							$total1 = $total1 + $account*$ea;
							$total2 = $total2 + $dis*$ea;
						}
						
						if($ar_coupen[usesale]=='2')
						{
							$makeac = ($account-$dis) * $ar_coupen[account]/100;
							$makeac = floor($makeac / 100) * 100;
							$total3 = $total3 + $makeac*$ea;
						}
						if($ar_coupen[usesale]=='3')
						{
							$makeac = ($account) * $ar_coupen[account]/100;
							$makeac = floor($makeac / 100) * 100;
							$makeac = $makeac - $dis;
							$total3 = $total3 + $makeac*$ea;
						}	
	
					}
					else
					{
						$total1 = $total1 + $account*$ea;
					}
				}
			}
		}
	}
	$ac = 0;
	if($ar_coupen[actype]=='1')
	{
		if($total1=='0')
		{
			$ac = 0;
		}
		else
		{
			if($total1>$ar_coupen[account])
			{	$ac = $ar_coupen[account];	}
			else
			{	$ac =  ($ar_coupen[account]-$total1);	}
		}
	}
	else
	{
		$ac = $total3;
	}

	if($ac==0)	{
		$redata['res'] = "error";
		$redata['resmsg'] = trscode('ORDER14');
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}
	else	{
		$redata['res'] = "ok";
		$redata['ac'] = $ac;
		$result = json_encode ($redata);
		header ( 'Content-Type:application/json; charset=utf-8' );
		echo $result;
		exit;
	}
}

//$makestr = $basket_idx."-".$sac."-".$ac."-".$isnewsale."-"
function calcp($coupen_idx,$makestr)
{
	

	$ar_str = explode("-",$makestr);
	
	$basket_idx = $ar_str[0];
	$sac = $ar_str[1];
	$ac = $ar_str[2];
	$isnewsale = "N";
	$isgradesale = "N";
	$cansale = "Y";
	$dis = 0;

	if($cansale=='N')
	{	return 0;	}
	

	$ar_basket = sel_query_all("shop_newbasket_tmp"," where index_no='$basket_idx'");
	$ar_mem_coupen = sel_query_all("shop_coupen_mem"," where index_no='$coupen_idx'");
	$ar_coupen = sel_query_all("shop_coupen"," where index_no='$ar_mem_coupen[coupen_idx]'");

	if($ar_coupen[actype]=='1')
	{	return 0;	}

	if($ar_coupen[nousecate]!='')
	{	$ar_nousecate = explode("-",$ar_coupen[nousecate]);	}
	if($ar_coupen[nousegoods]!='')
	{	$ar_nousegoods = explode("-",$ar_coupen[nousegoods]);	}
	if($ar_coupen[usegoods]!='')
	{	$ar_usegoods  = explode("-",$ar_coupen[usegoods]);	}
	if($ar_coupen[usecate]!='')
	{	$ar_usecate = explode("-",$ar_coupen[usecate]);	}

	$goods_idx = $ar_basket[goods_idx];

	$qs = "select fid,shop_goods_cate.catecode from shop_goods_cate,shop_cate where goods_idx='$goods_idx' and shop_cate.catecode=shop_goods_cate.catecode";
	$sts = $pdo->prepare($qs);
	$sts->execute();
	unset($ar_goods_cate);
	$ar_goods_cate[0] = "";
	$cou = 0;
	while($rows = $sts->fetch())
	{
		$ar_goods_cate[$cou] = $rows[fid]."|R|".$rows[catecode];
		$cou++;
	}

	if($ar_coupen[prod1]=='1')
	{
		$rt = "Y";
		if($ar_coupen[prod2]=='2')
		{
			for($k=0;$k<sizeof($ar_nousecate);$k++)
			{
				if(in_array($ar_nousecate[$k],$ar_goods_cate)  && $ar_nousecate[$k]!='')
				{	$rt = "N";	}
			}
					
			if($rt=='Y')
			{
				if(in_array($goods_idx,$ar_nousegoods))
				{	$rt = "N";		}
			}
		}
	}

	if($ar_coupen[prod1]=='2')
	{
		$rt = "N";
		for($k=0;$k<sizeof($ar_usecate);$k++)
		{
			if(in_array($ar_usecate[$k],$ar_goods_cate))
			{	$rt = "Y";}
		}

	}

	if($ar_coupen[prod1]=='3')
	{
		$rt = "N";
		if(in_array($goods_idx,$ar_usegoods))
		{	$rt = "Y";	}

	}
	
	if($rt=='Y')
	{
		$makeac = 0;
		if($ar_coupen[actype]=='2')
		{
			if($ar_coupen[usesale]=='1')
			{
				if($dis==0)
				{
					$makeac = $ac * $ar_coupen[account]/100;
					$makeac = floor($makeac / 100) * 100;

					if($ar_coupen[saleper_std1])
					{	$ar_coupen[saleper_std1] = $ar_coupen[saleper_std1]*10;	}
					else
					{	$ar_coupen[saleper_std1] = 100;	}

					if($ar_coupen[saleper_std2]=='3')
					{	$makeac = floor($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}
							
					else if($ar_coupen[saleper_std2]=='2')
					{	$makeac = round($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}

					else if($ar_coupen[saleper_std2]=='1')
					{	$makeac = ceil($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}

					else
					{	$makeac = floor($makeac / $ar_coupen[saleper_std1]) * $ar_coupen[saleper_std1];	}
				
				}
			}
					
			if($ar_coupen[usesale]=='2')
			{
				$makeac = $ac * $ar_coupen[account]/100;
				$makeac = floor($makeac / 100) * 100;
			}
			if($ar_coupen[usesale]=='3')
			{
				if($isnewsale=='Y')
				{	$makeac = ($sac) * $ar_coupen[account]/100;	}
				else
				{	$makeac = ($sac) * $ar_coupen[account]/100;	}
				$makeac = floor($makeac / 100) * 100;
				$makeac = $makeac - $dis;
			}	

		}
		return $makeac;
	}
	else
	{	return 0;	}
}
if($han=='get_adddelac')	{
	
	$addr = $_REQUEST['addr'];

	$chk_addr = str_replace(" ","",$addr);
	$adddelac = 0;
	$adddel = 0;

	$q = "Select * from shop_delaccount_add order by account desc";
	$st = $pdo->prepare($q);
	$st->execute();
	
	while($row = $st->fetch())	{
		
		if($adddelac!=0)	{
			continue;
		}

		$ar_tmps = explode(",",$row['location']);

		for($i=0;$i<sizeof($ar_tmps);$i++)	{
			
			if(strpos($chk_addr, $ar_tmps[$i]) !== false) { 
				$adddelac = $row['account'];
				$adddel = number_format($row['account']);
			}
		}
	}
	
	$redata['res'] = "ok";
	$redata['adddelac'] = $adddelac;
	$redata['adddel'] = $adddel;
	$result = json_encode ($redata);
	header ( 'Content-Type:application/json; charset=utf-8' );
	echo $result;
	exit;
}
?>
