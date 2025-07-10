<?php

function get_config_memo($pid,$lang,$t,$in_idx="")	{
	
	$ar_memo = sel_query_all("shop_config_memo"," WHERE pid='$pid' and lang='$lang' and mtype='$t'");


	if($in_idx)	{
		$ar_m = sel_query_all("shop_goods_shops"," where idx='$in_idx'");
		$ar_ins = sel_query_all("shop_goods_shops_config"," WHERE in_idx='$ar_m[mem_idx]'");
		if($ar_ins['idx'])	{
			
			$t = $t - 4;
			if($ar_ins['memo'.$t])	{
				echo $ar_ins['memo'.$t];
			}
			else	{
				echo $ar_memo['memo'];
			}
					
		}
		else	{
			

			if($ar_memo['idx'])	{
				echo $ar_memo['memo'];
			}
		}
	}
	else	{
	
		

		if($ar_memo['idx'])	{
			echo $ar_memo['memo'];
		}
	}
}
function get_country()	{
	$q = "select * FROM shop_country order by country asc";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		$list[] = $row;
	}
	return $list;
}
function get_set_data($idx,$cou=0)	{

	global $_imgserver;
	global $g_ar_init;
	global $pdo;
	global $_uppath;

	$ar_newmain = sel_query_all("shop_design_mainconfig"," where idx='$idx'");

	if($ar_newmain['up_idx']!='0')	{
		$qmain = "Select * from shop_design_maindata where main_idx='$ar_newmain[up_idx]' and isuse='Y'" ;	
	}
	else	{
		$qmain = "Select * from shop_design_maindata where main_idx='$ar_newmain[idx]' and isuse='Y'";	
	}

	if($ar_newmain['ban_cou']=='1')	{
		$qmain = $qmain ." order by $ar_newmain[ban_order] limit 0,1";	
	}
	else	{
		if($cou==0)	{
			$qmain = $qmain ." order by $ar_newmain[ban_order]";	
		}
		else	{
			$qmain = $qmain ." order by $ar_newmain[ban_order] limit 0,$cou";	
		}
		
	}

	$st = $pdo->prepare($qmain);
	$st->execute();
	$loop = [];
	while($rowmain = $st->fetch() )	{

		$sites = unserialize($rowmain['showsites']);
		
	

		$rowmain['imgurl'] = $_imgserver."/new_main/".$rowmain['imgs'];
		$rowmain['imgs_sub'] = $_imgserver."/new_main/".$rowmain['imgs_sub'];
		
		$qs = "Select * from shop_design_maindata_ele where data_idx='$rowmain[idx]'";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		while($rows = $sts->fetch() )	{
			
			$ar_goods = sel_query_all("shop_goods"," where idx='$rows[goods_idx]'");
			if($ar_goods['isdel']=='Y' || $ar_goods['isshow']=='N')	{
				continue;
			}

			$ar_maccount = get_newaccount($ar_goods);

			if($ar_goods['isopen']!='2')	{
				$ar_goods['gname'] = "[품절]".$ar_goods['gname'];
			}
	
			$ar_goods['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
			$ar_goods['account_pure'] = $ar_maccount['account'];
	
			$ar_goods['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
			$ar_goods['saccount_pure'] = $ar_maccount['saccount'];
			$ar_goods['per'] = "";
			if($ar_maccount['saccount']!=0)	{
				$ar_goods['per'] = intval(($ar_maccount['saccount'] - $ar_maccount['account'])/$ar_maccount['saccount']*100);
			}

			
		
			$ar_goods['links'] = "/shop/view.php?idx=$row[idx]";

			$rowmain['goods'][] = $ar_goods;
			
		}
		$loop[] = $rowmain;
	}

	return $loop;
}
function get_main_htmls($idx)	{
	$q = "SELECT * FROM shop_design_maindata WHERE main_idx='$idx'";
	$r = mysql_query($q);
	$row = mysql_fetch_array($r);

	echo $row['htmls'];
}
function get_regi_goods($idx,$start="",$coun="",$or="")	{
	
	
	global $_imgserver;
	global $g_ar_init;
	global $g_ar_curr;
	global $G_LANG;
	global $pdo;
	
	$ar_newmain = sel_query_all("shop_design_mainconfig"," where idx='$idx'");
	$ar_icon = sel_query_all("shop_config_icon"," where wuse='2' and isuse='Y' and fid='$fid'");
	$ar_icon_new = sel_query_all("shop_config_icon"," where wuse='1' and isuse='Y' and fid='$fid'");
	

	
	$q = "SELECT * from shop_design_maindata WHERE main_idx='$idx'";

	if($or=='')	{
		$q = $q . " order by orders asc";
	}
	else	{
		$q = $q . " order by rand() asc";
	}
	
	if($coun!='')	{
		$q = $q . " limit $start,$coun";
	}

	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch() )	{
		
		if($row['cont_type']=='1')	{
			
			$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");
			if($ar_goods['isshow']=='N' || $ar_goods['isdel']=='Y')	{
				continue;
			}

			$ar_maccount = get_newaccount($ar_goods);

			if($ar_goods['isopen']!='2')	{
				$ar_goods['gname'] = "[품절]".$ar_goods['gname'];
			}

			$ar_goods['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
			$ar_goods['account_pure'] = $ar_maccount['account'];

			$ar_goods['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
			$ar_goods['saccount_pure'] = $ar_maccount['saccount'];
			$ar_goods['per'] = "";
			if($ar_maccount['saccount']!=0)	{
				$ar_goods['per'] = intval(($ar_maccount['saccount'] - $ar_maccount['account'])/$ar_maccount['saccount']*100);
			}
			$ar_goods['links'] = "/shop/view.php?idx=$ar_goods[idx]&main_idx=".$idx;
		}

		if($row['cont_type']=='2')	{
			$ar_goods = sel_query_all("shop_cont"," WHERE idx='$row[goods_idx]'");


		}

		

		$loop[] = $ar_goods;
		
	} 

	return $loop;
}

function get_listcount($mode,$page,$arr)	{

	global $g_ar_init;
	global $pdo;

	$PHP_SELF = $_SERVER["PHP_SELF"];

	$page_per_block = $arr['page_per_block'];
	
	if($mode=='list')	{

		$q = "select shop_goods.idx from shop_goods INNER JOIN shop_goods_cate ON shop_goods.idx=shop_goods_cate.goods_idx where catecode='".$arr['cate']."' and isopen IN ('2','3','4') and isshow='Y' and fid='".$g_ar_init['fid']."' AND isdel='N'";
		if($arr['colors'])	{
			
			$q = $q . " AND shop_goods.idx IN (SELECT distinct(goods_idx) from shop_goods_color WHERE color_idx IN ($arr[colors]))";
		
		}
		if($arr['account1'])	{
			$q = $q . " AND account>='".($arr['account1']*100)."'";
		}
		if($arr['account2'])	{
			$q = $q . " AND account<='".($arr['account2']*100)."'";
		}
	}
	if($mode=='search')	{

		$q = "select count(shop_goods.idx) from shop_goods where isopen IN ('2','3','4') and isshow='Y' and fid='".$g_ar_init['fid']."' AND isdel='N' AND ( (replace(gname,' ','') like '%".str_replace(" ","",$arr['keyword'])."%' or gcode like '%".str_replace(" ","",$arr['keyword'])."%' or replace(gname_head,' ','') like '%".str_replace(" ","",$arr['keyword'])."%') )";	

	}

	//$q = $q . " AND shop_goods.idx IN (SELECT goods_idx from shop_goods_showsite WHERE pid='".$g_ar_init['idx']."')";

	$st = $pdo->prepare($q);
	$st->execute();

	$total_record = $st->rowCount();


	$total_page = ceil($total_record/$arr['numper']);

	if($total_record == 0)	{
		$first = 0; $last = 0; 
	}
	else	{
		$first = $arr['numper']*($page-1);  $last = $arr['numper'] * $page; 
	}
	
	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);

	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;

	if($total_block <= $block)	{
		$last_page = $total_page;	
	}

	$paging['first'] = $first;
	$paging['total_record'] = $total_record;
	$paging['nowpage'] = $page;
	$paging['total_page'] = $total_page;
	$paging['block'] = $block;
	$paging['totalblock'] = $total_block;

	if($mode=='list')	{
		$basiclink = $PHP_SELF."?act=list&cate=".$arr['cate']."&ob=".$arr['ob']."&colors=".$arr['colors']."&account1=".$arr['account1']."&account2=".$arr['account2'];
	}
	if($mode=='search')	{
		$basiclink = $PHP_SELF."?act=list&keyword=".$arr['keyword']."&ob=".$arr['ob']."&colors=".$arr['colors']."&account1=".$arr['account1']."&account2=".$arr['account2'];
	}
	
	if($block>1)	{	
		$before_page = $first_page;
		$paging['superfirstl'] = $basiclink."&page=$before_page&colors=".$arr['colors']."&account1=".$arr['account1']."&account2=".$arr['account2'];
	}
	
	if($total_record!=0)	{
		if(($page-1)<1)	{
			$paging['firstl'] = "javascript:alert('" . trscode('PAGE1') . "');";	
		}
		else	{
			$k = ($page-1);
			$paging['firstl'] = $basiclink."&page=$k&colors=".$arr['colors']."&account1=".$arr['account1']."&account2=".$arr['account2'];
		}
	}

	for($direct_page = $first_page+1; $direct_page <= $last_page;$direct_page++)		{
		$loop_paging[] = array('links'=>$basiclink."&page=$direct_page", 'page' =>$direct_page);  
	}

	if($total_record!=0)	{
		if(($page+1)>$total_page)	{
			$paging['lastl'] = "javascript:alert('" . trscode('PAGE2') . "');";	
		}
		else	{
			$k = ($page+1);
			$paging['lastl'] = $basiclink."&page=$k&colors=".$arr['colors']."&account1=".$arr['account1']."&account2=".$arr['account2'];
		}
	}

	if($block<$total_block)	{	
		$daum_page = $last_page+1;
		$paging['superlastl'] = $basiclink."&page=$daum_page&colors=".$arr['colors']."&account1=".$arr['account1']."&account2=".$arr['account2'];
	}

	$ar_redata['paging'] = $paging;
	$ar_redata['loop_paging'] = $loop_paging;

	return $ar_redata;
}

function get_listdata($mode,$arr)	{
	
	global $g_ar_init;
	global $g_ar_curr;
	global $G_LANG;
	global $pdo;

	if($mode=='list')	{

		if($arr['tbs']=='')	{
		
			if($arr['cate']!='')	{
				$q = "SELECT shop_goods.* from shop_goods INNER JOIN shop_goods_cate ON shop_goods.idx=shop_goods_cate.goods_idx WHERE isopen IN ('2','3','4') and isshow='Y' and	fid='".$g_ar_init['fid']."' AND isdel='N'";	
				$q = $q . " and catecode='".$arr['cate']."'";
			}	else{
				$q = "SELECT shop_goods.* from shop_goods WHERE isopen IN ('2','3','4') and isshow='Y' and	fid='".$g_ar_init['fid']."' AND isdel='N'";	
			}

			$q = $q . $arr['orderby']." limit ".$arr['first'].", ".$arr['numper'];
		}
		else	{

			$q = "SELECT shop_goods.* from shop_goods INNER JOIN shop_goods_subcate ON shop_goods.idx=shop_goods_subcate.goods_idx WHERE catecode='".$arr['cate']."' and isopen IN ('2','3','4') and isshow='Y' and	fid='".$g_ar_init['fid']."' AND isdel='N'";	
			if($arr['colors'])	{
			
				$q = $q . " AND shop_goods.idx IN (SELECT distinct(goods_idx) from shop_goods_color WHERE color_idx IN ($arr[colors]))";

			}
			if($arr['account1'])	{
				$q = $q . " AND account>='".($arr['account1']*100)."'";
			}
			if($arr['account2'])	{
				$q = $q . " AND account<='".($arr['account2']*100)."'";
			}
			$q = $q . $arr['orderby']." limit ".$arr['first'].", ".$arr['numper'];
		}
		

	}
	if($mode=='search')	{

		$q = "select * from shop_goods where isdel='N' isopen IN ('2','3','4') and isshow='Y' and fid='".$g_ar_init['fid']."' AND isdel='N' AND ( (replace(gname,' ','') like '%".str_replace(" ","",$arr['keyword'])."%' or gcode like '%".str_replace(" ","",$arr['keyword'])."%' or replace(gname_head,' ','') like '%".str_replace(" ","",$arr['keyword'])."%') )";
		$q = $q . " AND shop_goods.idx IN (SELECT goods_idx from shop_goods_showsite WHERE pid='".$g_ar_init['idx']."')";
		$q = $q . $arr['orderby']." limit ".$arr['first'].", ".$arr['numper'];
	}
	
	$st = $pdo->prepare($q);
	$st->execute();
	$list = [];
	while($row = $st->fetch())	{
		
		$ar_maccount = get_newaccount($row);


		if($row['isopen']!='2')	{
			$row['gname'] = "[품절]".$row['gname'];
		}

		$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$row['account_pure'] = $ar_maccount['account'];

		$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$row['saccount_pure'] = $ar_maccount['saccount'];
		$row['per'] = "";
		if($ar_maccount['saccount']!=0)	{
			$row['per'] = intval(($ar_maccount['saccount'] - $ar_maccount['account'])/$ar_maccount['saccount']*100);
		}
		
		$qs = "select * from shop_goods_imgs where goods_idx='$row[idx]' order by idx asc";
		
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$row['simg'.$c] = $rows['filename'];	
			$c++;
		}
		

		$list[] = $row;
	}

	return $list;
	
}
function get_newlist($cou)	{
	
	global $g_ar_init;
	global $g_ar_curr;
	global $G_LANG;
	global $pdo;

	$q = "select * from shop_goods where isshow='Y' and isdel='N' and isopen IN ('2','3') order by opendate desc limit 0,$cou";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_maccount = get_newaccount($row);

		if($G_LANG!='ko')	{
			$row['gname'] = $row['gcode'];
		}

		$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$row['account_pure'] = $ar_maccount['account'];

		$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$row['saccount_pure'] = $ar_maccount['saccount'];

		$list[] = $row;
	}
	return $list;
}
function get_goods_color($listimgcolor)	{
	
	$ar_tmp = explode(",",$listimgcolor);
	for($i=0;$i<sizeof($ar_tmp);$i++)	{
		$ar_color = sel_query_all("shop_config_color"," WHERE ccode1='$ar_tmp[$i]'");

		$list[] = $ar_color;
	}
	return $list;
}
function get_color()	{
	
	$q = "SELECT * FROM shop_config_color where isdel='N' order by idx asc";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		$list[] = $row;
	}
	return $list;
}
function get_cate_list($cate)	{

	global $g_ar_init;

	for($i=2;$i<=strlen($cate);$i=$i+2)	{

		$chcate = substr($cate,0,$i);

		$ar_cate = sel_query_all("shop_cate"," WHERE catecode='".$chcate."'");
		$ar_tmp = unserialize($ar_cate['showsites']);

		if(in_array($g_ar_init['idx'],$ar_tmp))	{

			$list[] = $ar_cate;
		}

	}
	return $list;
}
function get_cate_delth($goods_idx)	{
	
	global $pdo;

	$q = "SELECT * FROM shop_goods_cate WHERE goods_idx='$goods_idx' ORDER BY LENGTH(catecode) DESC,catecode ASC limit 0,1";
	$st = $pdo->prepare($q);
	$st->execute();

	$row = $st->Fetch();

	for($i=2;$i<=strlen($row[catecode]);$i=$i+2)	{
		
		$ar_cate = sel_query_all("shop_cate"," WHERE catecode='".substr($row[catecode],0,$i)."'");

		$list[] = $ar_cate;

	}
	return $list;

}
function get_goods_noti($idx,$datas="")	{
	
	if($datas!='')	{
		$ar_tmp = explode(",",$datas);
	}



	$q = "SELECT * FROM shop_goods_addinfo WHERE goods_idx='$idx' order by idx ASC";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		
		if($datas!='')	{
			if(in_array($row[name],$ar_tmp))	{
				continue;
			}
		}

		$listdata[] = $row;
	}

	return $listdata;
}
function get_genmemo($m)
{
	global $g_ar_init;
	global $idx;

	$q = "select * from shop_genmemo where loca='$m' AND sdate<='".date("Y-m-d H:i:s")."' and edate>='".date("Y-m-d H:i:s")."'";


	$r = mysql_query($q);
	$loop = array();
	while($row = mysql_fetch_array($r))
	{
		if($row['stype']=='2')	{
			
			$ar_scates = $row['scates'];
			$str = "";
			for($i=0;$i<sizeof($ar_scates);$i++)	{
				if($ar_cates[$i]!='')	{
					$str = $str . "'".$ar_cates[$i]."'";
				}
			}

			$qs = "SELECT * FROM shop_goods_cate WHERE catecode in ($str) AND goods_idx='$idx'";
			$rs = mysql_query($qs);
			$isits = mysql_num_rows($rs);
			if($isits==0)	{
				continue;
			}	

		}
		if($row['stype']=='3')	{
			
			$ar_sgoods = explode("|R|",$row['sgoods']);
			$str = "N";
			for($i=0;$i<sizeof($ar_sgoods);$i++)	{

				if($ar_sgoods[$i]!='')	{
					if($ar_sgoods[$i]==$idx)	{
						$str = "Y";
					}
				}
			}
			if($str=='N')	{
				continue;	
			}

		}

		$loop[] = $row;
	}
	return $loop;
}


//아래는 손봐야 할 사항들
function get_todayview($page,$count)
{

	global $G_STIDX;
	global $pdo;

	$start = ($page-1)*$count;

	$loop = array(); 
	$sdate = date("Y-m-d",time()-86400);
	$q = "select shop_goods.*,shop_view_today.idx as view_idx  from shop_goods,shop_view_today where shop_view_today.goods_idx=shop_goods.idx and view_idx='$G_STIDX' and wdate_s='".date("Y-m-d",time())."'";	
	$q = $q . " order by wdate desc";
	if($count)	{
		$q = $q . "  limit $start,$count";
	}
	$st = $pdo->prepare($q);
	$st->execute();
	$cou = 0;
	while($row = $st->fetch())
	{   
		$ar_maccount = get_newaccount($row);

		$row['havetime'] = "N";
		$qs = "select idx,sdate,edate FROm shop_timesale where goods_idx='$row[idx]' and isshow='Y' and sdate<='".date("Y-m-d H:i:s")."' and edate>='".date("Y-m-d H:i:s")."'";
		$sts = $pdo -> prepare($qs);
		$sts->execute();
		$isits = $sts->rowCount();
		if($isits!=0)	{
			$row['havetime'] = "Y";

			$rows = $sts->fetch();

			$sdate = $rows['sdate'];
			$edate = $rows['edate'];
		

			$qs = "select sum(sellcous) as sellcous,sum(mcous) as mcous from shop_timesale_sellcou where deal_idx='$rows[idx]'";
			$sts = $pdo->prepare($qs);
			$sts->execute();

			$rows = $sts->fetch();

			$mcous = 0;
			if($rows['mcous'])	{
				$mcous = $rows['mcous'];
			}
			
			$sellcouso = $rows['sellcous'];
			$sellcous = $rows['sellcous'] - $mcous;
			$row['limits'] = $sellcous;
			$row['ea'] = 0;

			$qs = "Select sum(ea) as ea from shop_newbasket INNER JOIN shop_newmarketdb ON shop_newbasket.market_idx=shop_newmarketdb.idx where goods_idx='$row[idx]' and dan!='' and pdan='' and shop_newmarketdb.sdate>='$sdate'	and shop_newmarketdb.sdate<='$edate' ";

			$sts = $pdo->prepare($qs);
			$sts->execute();
			$rows = $sts->fetch();
		
			if($rows['ea'])	{
				$row['ea'] = $rows['ea'];
			}

			$row['sellcous'] = $row['limits'] - $row['ea'];
			$row['per'] = round(($row['ea']+$mcous)/$sellcouso*100);

		}



		$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$row['account_pure'] = $ar_maccount['account'];

		$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$row['saccount_pure'] = $ar_maccount['saccount'];

		$loop[] = $row;     
	} 
	return $loop;
}
function get_detail_memo()
{
	global $ar_data;
	global $ar_data_master;
	global $pdo;

	global $_imgserver;
	
	$fileserver = $_imgserver;

    if($ar_data['master_idx']!=0)
    {
        $goods_data = $ar_data_master;
    }
    else
    {
        $goods_data = $ar_data;
    }


	$ccode = "";
	if($goods_data['memo_loca']=='1')
	{
		echo "<div>";
		if($goods_data['custom_memo']!='' && $goods_data['last_idx']==0)	{
			$memo = nl2br($goods_data['custom_memo']);
			
		}
		else	{
			$memo = $goods_data['memo'];

			$memo = str_replace("../../..","",$memo);
			$memo = str_replace("/uploaded/","http://www.styleseller.co.kr/uploaded/",$memo);
		}
		echo $memo;
		echo "</div>";
	}

	global $ar_init;


	
	if($goods_data['master_idx']!=0)	{
		for($i=1;$i<11;$i++)	{
			
			if($goods_data["simg".$i]!='')	{
				echo "<div style='margin-bottom:".$goods_data['view_margin']."px;'>";
				echo "<img src='$fileserver/files/goods/$goods_data[idx]/".$goods_data["simg".$i]."' >";
				echo "</div>";
			}
		}
	}
			
	//상세이미지 세로배치
	//if($goods_data[detailshow]=='1')
	//{
		$q = "select * from shop_goods_cgroup where goods_idx='$goods_data[idx]' order by orders asc";
		$st = $pdo->prepare($q);
		$st->execute();
		while($row = $st->fetch())	{
			if($row['op_idx'])
			{	$ccode = "Y";	}
			$q2 = "select * from shop_goods_nimg where goods_idx='$goods_data[idx]' and cgroup='$row[cgroup]' order by orders asc";
			$st2 = $pdo->prepare($q2);
			$st2->execute();
			$couks = 0;
			while($row2 = $st2->fetch())	{
				
				if($goods_data['view_margin']!='0' && trim($row2['memos'])=='')
				{	echo "<div style='margin-bottom:".$goods_data['view_margin']."px;'>";	}
				else
				{	echo "<div>";	}


				
				echo "<img src='$fileserver/files/goodsm/$goods_data[idx]/$row2[imgname]'  ";
					
				if(trim($row2['imgmap'])!='')
				{
					echo "usemap='#${row2[imgname]}'";
				}
				echo ">";
	
				if(trim($row2['imgmap'])!='')
				{
					echo "<map name='$row2[imgname]'>";
					echo $row2['imgmap'];
					echo "</map>";
				}

				if(trim($row2['memos'])!='')
				{
					if($goods_data['view_margin']!='0')
					{	echo "<div style='margin-bottom:".$goods_data['view_margin']."px;'>";	}
					else
					{	echo "<div>";	}
					$memo = $row2['memos'];
					echo $memo;
					echo "</div>";
				}
			
				echo "</div>";
				$couks++;

				if($goods_data['memo_loca']=='3' && $goods_data['memo_loca1']==$row['cgroup'] && $goods_data['memo_loca2']==$couks)
				{
					if($goods_data['view_margin']!='0')
					{	echo "<div style='margin-top:-".$goods_data['view_margin']."px'>";	}
					else
					{	echo "<div>";	}
					$memo = $goods_data['memo'];
					echo $memo;
					echo "</div>";
				}
			}
		}	
	//}
	//상세이미지 세로배치


	
	if($goods_data['memo_loca']=='2')
	{
		echo "<div>";
		$memo = $goods_data['memo'];
		echo $memo;
		echo "</div>";
	}
	echo "<input type='hidden' id='haveccode' value='$ccode'>";
}
function get_cate($up,$ups="0",$isbest="")	{
	
	global $g_ar_init;
	global $pdo;

	if($ups!=0)	{
		if($ups=='A')	{
			$up = "";
		}
		else	{
			$up = substr($up,0,$ups);
		}
		
	}

	$q = "SELECT * FROM shop_cate WHERE isshow='Y'";
	$q = $q . "  AND  upcate='$up'	";
	if($isbest=='Y')	{
		$q = $q ." AND isbestcate='Y'";
	}
	$q = $q . " ORDER BY rorders ASC";

	$st = $pdo->prepare($q);
	$st->execute();
	$indata = [];
	while($row = $st->fetch())	{

		$ar_tmp = unserialize($row['showsites']);

		//if(in_array($g_ar_init['idx'],$ar_tmp))	{
			
			$row['havesub'] = "N";
			$qs = "Select * from shop_cate where upcate='$row[catecode]' and isshow='Y'";
			$sts = $pdo->prepare($qs);
			$sts->execute();
			if($sts->rowCount()!=0)	{
				$row['havesub'] = "Y";
			}

			$indata[] = $row;
		//}
		
		
		
	}
	return $indata;


}
function get_best($cate,$cou)	{
	
	global $g_ar_curr;
	global $pdo;

	$q = "
		SELECT a.* 
		FROM shop_list_best a 
		inner join shop_goods b on a.goods_idx = b.idx and b.isdel = 'N'
		where 
			a.mcode='$cate' 
		ORDER BY rand() 
		limit 0,$cou
	";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");

		$ar_maccount = get_newaccount($ar_goods);

		$ar_goods['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$ar_goods['account_pure'] = $ar_maccount['account'];

		$ar_goods['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$ar_goods['saccount_pure'] = $ar_maccount['saccount'];


		$list[] = $ar_goods;
	}
	return $list;
}
function get_new($cate,$cou)	{

	global $G_LANG;
	$lang = $G_LANG;

	$q = "SELECT shop_goods.* FROM shop_goods INNER JOIN shop_goods_cate ON shop_goods.idx=shop_goods_cate.goods_idx where catecode='$cate' AND isopen='2' AND isshow='Y' and isdel = 'N' ORDER BY opendate desc limit 0,$cou";
	$r = mysql_query($q);
	while($row = mysql_Fetch_array($r))	{
		
		if($G_LANG!='ko')	{
			$row['gname'] = $row['gcode'];
		}

		$ar_maccount = get_newaccount($row);

		$row['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$row['account_pure'] = $ar_maccount['account'];

		$row['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$row['saccount_pure'] = $ar_maccount['saccount'];
		

		$list[] = $row;
	}
	return $list;

}
function get_pboard_data($boardid,$count,$orderby="",$btype="")
{
	global $basictb;
	global $imgdomain;
	global $G_LANG;
	global $pdo;

	$lang = $G_LANG;

	if(!$orderby)
	{	$orderby = " wdate desc";}

	$q = "select * from shop_board where boardid='$boardid' and isdel='N' and isview <> 'N' ";

	$ar_conf = sel_query_all("shop_board_conf"," WHERE board_id='$boardid'");

	if($ar_conf['uselang']=='Y')	{
		$q = $q . " AND lan='$lang'";
	}
	if($btype)
	{	$q = $q . " and btype='$btype'";	}
	$q = $q . "  order by $orderby";
	
	if($count!=0)
	{	$q = $q . " limit 0,$count";	}
	$st = $pdo->prepare($q);
	$st->execute();
	$cou = 0;
	$loop = array();
	while($row = $st->fetch())
	{
		if($row['cates']!='')	{
			$ar_cates = sel_query_all("shop_board_cate"," WHERE idx='$row[cates]'");
			$row['cates'] = $ar_cates['catename'];
		}
		$loop[$cou] = $row;
		$loop[$cou][imgurl] = $img;
		$loop[$cou][fullurl] = "/bbs/read.php?boardid=$row[boardid]&idx=$row[idx]";	
		$cou++;
	}
	return $loop;

}
function dataorderlist($count)
{

	global $G_MEMIDX,$pdo;
	
	$cou = 0;
	$q = "select * from shop_newmarketdb where mem_idx='$G_MEMIDX' and dan!='' order by idx desc limit 0,$count";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())
	{	
		$row['orderno'] = date("Ymd",$row['orderno'])."-".$row['idx'];
		$row['account_pure'] = $row['account']/100;

		$row['account'] = number_format($row['account_pure'],$g_ar_curr['showstd']);
		
		$maindan = "";
		if($row[dan]=='1')
		{	$maindan = '주문접수';	}
		else if($row[dan]=='2')
		{	$maindan = '결제확인';	}
		else if($row[dan]=='3')
		{	$maindan = '상품준비중';	}
		else if($row[dan]=='4')
		{	$maindan = '부분배송';	}
		else if($row[dan]=='5')
		{	$maindan = '배송중';	}
		else if($row[dan]=='6')
		{	$maindan = '거래완료';	}
		else if($row[dan]=='8')
		{	$maindan = '주문취소';	}

		$row['maindan'] = $maindan;

		
		
		
		$qs = "Select * from shop_newbasket where market_idx='$row[idx]' AND set_idx=0 AND gtype IN (1,2)";
		$st2 = $pdo->prepare($qs);
		$st2->execute();
		$cous = 1;
		$row['ea'] = 0;
		while($rows = $st2->fetch()){
			if($cous==1)	{
				$ar_g = sel_query_all("shop_goods"," WHERE idx='$rows[goods_idx]'");
				$row['gname'] = $ar_g['gname'];
				$row['simg1'] = $ar_g['simg1'];
				$row['simg2'] = $ar_g['simg2'];
			}
			$row['ea'] = $row['ea'] + $rows['ea'];
			
			$cous++;
		}

		$loop[] = $row;
		$cou++;
	}
	return $loop;
}
function get_store_loca()	{
	
	$q = "SELECT * FROM shop_intro_store_loca order by idx asc";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		$indata[] = $row;
	}
	return $indata;
}
function get_store_city($idx)	{

	$row[city] = "전체";
	$listdata[] = $row;

	$q = "SELECT distinct(city) AS city FROM shop_intro_store WHERE loca_idx='$idx' AND city!=''";
	$r = mysql_query($q);
	$cou = 0;
	while($row = mysql_Fetch_Array($r))	{
		
		$listdata[] = $row;

		$cou++;
	}

	return $listdata;
}
function get_board_prev($idx,$boardid)
{
	global $pdo;
	global $G_LANG;	
	$lang = $G_LANG;

	$ar_boardconf = sel_query_all("shop_board_conf"," where board_id='$boardid'");

	$q = "select * from shop_board where boardid='$boardid' and isdel='N' and idx>$idx";

	$q = $q . "  order by idx asc limit 0,1";

	$st = $pdo->prepare($q);
	$st->execute();
	$lp = array();
	while($row = $st->fetch())
	{
		$lp[] = $row;
	}
	return $lp;
}
function get_board_next($idx,$boardid)
{	
	global $pdo;
	 global $G_LANG;
        $lang = $G_LANG;

        $ar_boardconf = sel_query_all("shop_board_conf"," where board_id='$boardid'");

	$q = "select * from shop_board where boardid='$boardid' and isdel='N' and idx<$idx";

	$q = $q ."  order by idx desc limit 0,1";
	$st = $pdo->prepare($q);
	$st->execute();
	$lp = array();
	while($row = $st->fetch())
	{
		$lp[] = $row;
	}
	return $lp;
}
function get_event_goods($idx)	{
	global $g_ar_init;
	global $g_ar_curr;
	
	$q = "select * from shop_event_goods where event_idx='$idx' order by orders asc";

	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");

		if($ar_goods['isshow']=='N')	{
			continue;
		}

		if($g_ar_init['site_country']!='KR')	{
			$ar_goods['gname'] = $ar_goods['gcode'];
		}

		
		$datas = $ar_goods;
		$datas[goods_idx] = $ar_goods[idx];

		$ar_maccount = get_newaccount($ar_goods);

		$datas['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$datas['account_pure'] = $ar_maccount['account'];

		$datas['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$datas['saccount_pure'] = $ar_maccount['saccount'];
		

		
		// 글로벌 판매가격 추출 종료

		$indata[] = $datas;

	}
	return $indata;

}

function get_samegoods($gcode)	{
	

	if($gcode=='')	{
		return;
	}

	$gcode = str_replace("-","",$gcode);
	$gcode = substr($gcode,0,8);

	$q = "SELECT * FROM shop_goods WHERE LEFT(Replace(gcode,'-',''),8)='$gcode' AND isshow='Y' and isopen='2' and isshow='Y' and isdel='N'";
	$r = mysql_query($q);
	while($row = mysql_Fetch_array($r))	{

		$ar_tmp = explode(",",$row[listimgcolor]);
		for($i=0;$i<sizeof($ar_tmp);$i++)	{
			$list[idx] = $row[idx];
			
			$qs = "SELECT * FROM shop_config_color WHERE ccode1='".trim($ar_tmp[$i])."'";

			$rs = mysql_query($qs);
			$rows = mysql_fetch_array($rs);

			$list['colorimg'] = $rows[ccimg];
			$list[ccode1] = "#".str_replace("#","",$rows[ccode1]);
			$listdata[] = $list;
		}
	}

	return $listdata;

}
function get_faq_cate()
{
	global $g_ar_init;

	$loop = array();
	$q = "select * from shop_faqcate where fid='$g_ar_init[fid]' and isuse='Y' order by orders asc";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))
	{
		$loop[] = $row;
		
	}

	return $loop;
}
function get_faq($count,$isbest="N")
{
	global $fid;
	global $basictb;
	global $G_LANG;

	$lang = $G_LANG;

	$loop = array();
	$q = "select * from shop_faq where fid='$fid'";
	if($isbest=='Y')	{
		$q = $q . " AND isbest=1";
	}
	$q = $q . " AND lang='$lang'";
	$q = $q . " order by score desc limit 0,$count";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))
	{
		$ar_cate = sel_query_all("shop_faqcate"," WHERE idx='$row[cate_idx]'");

		$row[catename] = $ar_cate[catename];
		$row[cateidx] = $ar_cate[idx];
		$loop[] = $row;
		
	}

	return $loop;

}
function get_bestfaq($cou)	{

	global $g_ar_init,$G_LANG;

	$lang = $G_LANG;

	$loop = array();
	$q = "select * from shop_faq where fid='$g_ar_init[fid]'";
	if($isbest=='Y')	{
		$q = $q . " AND isbest=1";
	}
	$q = $q . " AND lang='$lang'";
	$q = $q . " order by score desc limit 0,$cou";

	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))
	{
		$ar_cate = sel_query_all("shop_faqcate"," WHERE idx='$row[cate_idx]'");

		$row[catename] = $ar_cate[catename];
		$row[cateidx] = $ar_cate[idx];
		$loop[] = $row;
		
	}

	return $loop;
}
function get_new_store($lang)	{
	
	$q = "SELECT * FROM shop_intro_store where isnew='Y' AND lang='$lang' order by wdate desc";
	$r = mysql_query($q);
	while($row = mysql_fetch_array($r))	{
		$list[] = $row;
	}
	return $list;
}
function get_qna_cate($mode,$sels='')
{

	global $fid;
	global $pdo;

	$q = "select * from shop_qna_cate where fid='1' AND isuse='Y' order by idx asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		if($mode=='select')
		{	
			if($sels==$row[idx])
			{	echo "<option value='$row[idx]' selected>" . trs($row[catename]) . "</option>";		}
			else
			{	echo "<option value='$row[idx]'>" . trs($row[catename]) . "</option>";		}
		}
	}
}
function get_year()	{
	
	$st = date("Y")-100;

	for($i=$st;$i<=date("Y");$i++)	{
		
		$row['year'] = $i;
		$data[] = $row;
	}
	return $data;
}
function get_month()	{
	

	for($i=1;$i<=12;$i++)	{
		
		if(strlen($i)==1)	{
			$j = "0".$i;
		}
		else	{
			$j = $i;
		}

		$row['month'] = $j;
		$data[] = $row;
	}
	return $data;
}
function get_day()	{
	
	for($i=1;$i<=31;$i++)	{
		
		if(strlen($i)==1)	{
			$j = "0".$i;
		}
		else	{
			$j = $i;
		}

		$row['day'] = $j;
		$data[] = $row;
	}
	return $data;
}
function get_banks()	{
	
	global $pdo;

	$q = "select * from shop_bankcode where isuse='Y' order by name asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		$data[] = $row;
	}
	return $data;
}
function get_timesale($or="")	{
	
	global $pdo;

	$q = "SELECT shop_goods.*,sdate,edate,shop_timesale.idx as idx,sorders from shop_goods INNER JOIN shop_timesale on shop_timesale.goods_idx=shop_goods.idx WHERE shop_timesale.isshow='Y' AND isdel='N' and sdate<='".date("Y-m-d")."' and edate>='".date("Y-m-d")."' AND shop_goods.idx IN (SELECT goods_idx from shop_goods_showsite)";
	if($or=='rand')	{
		$q = $q . " order by rand()";
	} 
	else if($or=='ovdate')	{
		$q = $q . " order by edate asc";
	}
	else	{
		$q = $q . " order by rand()";
	}
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$days = strtotime($row['edate'])-time();
		$days = round($days/86400);

		$sdate = $row['sdate'];
		$edate = $row['edate'];
		
		$row['days'] = $days;

		$qs = "select sum(sellcous) as sellcous,sum(mcous) as mcous from shop_timesale_sellcou where deal_idx='$row[idx]'";
		$sts = $pdo->prepare($qs);
		$sts->execute();

		$rows = $sts->fetch();

		$mcous = 0;
		if($rows['mcous'])	{
			$mcous = $rows['mcous'];
		}
		$sellcouso = $rows['sellcous'];
		$sellcous = $rows['sellcous'] - $mcous;
		$row['limits'] = $sellcous;
		$row['ea'] = 0;

		$qs = "Select sum(ea) as ea from shop_newbasket INNER JOIN shop_newmarketdb ON shop_newbasket.market_idx=shop_newmarketdb.idx where goods_idx='$row[idx]' and dan!='' and pdan='' and shop_newmarketdb.sdate>='$sdate' and shop_newmarketdb.sdate<='$edate' ";

		$sts = $pdo->prepare($qs);
		$sts->execute();
		$rows = $sts->fetch();
		
		if($rows['ea'])	{
			$row['ea'] = $rows['ea'];
		}
		
		$row['gocous'] = $row['ea'] + $mcous;
		$row['sellcous'] = $row['limits'] - $row['ea'];
		$row['per'] = round($row['gocous']/$sellcouso*100);

		$datas[] = $row;

	}
	
	return $datas;

}
function get_tags()	{

	global $pdo;

	$q = "select * from shop_config_tags where isdel='N' and isshow='Y'";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		$datas[] = $row;
	}
	return $datas;
}
function get_areview($goods_idx,$cate)	{
	
	global $pdo;

	$q = "select * from shop_areview where goods_idx='$goods_idx' and cate='$cate' order by idx asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch() )	{
		
		$ar_w = sel_query_all("shop_areview_writer"," WHERE idx='$row[writer]'");
		$row['name'] = $ar_w['name'];
		$row['img'] = $ar_w['img'];

		$data[] = $row;

	}
	
	return $data;
}
function get_membergrades()	{
	
	global $g_ar_init;
	global $pdo;

	$q = "SELECT * FROM shop_member_grades where group_idx='".$g_ar_init['site_member_group']."' order by grade_id asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		$datas[] = $row;
	}
	return $datas;
}
function get_afterbase($cate)	{
	
	global $pdo;

	$q = "select * from shop_after_base where cate_idx='$cate' and isuse='Y' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_tags = explode(",",$row['basedata']);
		for($i=0;$i<sizeof($ar_tags);$i++)	{
			if($ar_tags[$i]!='')	{
				$row['tags'][]['datas'] = $ar_tags[$i];
			}
		}

		$datas[] = $row;
	}

	return $datas;
}
function get_keywords($c)	{
	
	global $pdo;

	if($c==1)	{
		$q = "Select * from shop_keyword_set where isuse='Y' order by rand() limit 0,1";
		$st = $pdo->prepare($q);
		$st->execute();
		$row = $st->fetch();

		return $row['keyword'];
	}
	else	{
		$q = "Select * from shop_keyword_set where isuse='Y' order by rand()";
		$st = $pdo->prepare($q);
		$st->execute();
		while($row = $st->fetch())	{
			$lists[] = $row;
		}
		return $lists;
	}
}
function get_reason($c)	{
	
	global $pdo;

	$q = "select * from shop_action_reason where rtype='$c' order by idx asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->Fetch())	{
		
		$lists[] = $row;
	}
	return $lists;
}
function get_customdb($idx,$du="0")	{
	
	global $pdo;
	global $_imgserver;
	
	$q = "select * from shop_customdb_sch where customdb_idx='$idx' order by orders asc";
	
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
	
		$ar_datas[] = $row;

	}

	$q = "Select * from shop_customdb_data where customdb_idx='$idx' order by wdate desc";

	$st = $pdo->prepare($q);
	$st->execute();
	$cou = 0;
	while($row = $st->fetch())	{
		
		for($i=0;$i<sizeof($ar_datas);$i++)	{
			$da = sel_query_all("shop_customdb_data_ele"," WHERE data_idx='$row[idx]' and fi_idx='".$ar_datas[$i]['idx']."'");
			
			if($ar_datas[$i]['fitype']=='img')	{
				$row['d'.($i+1)] = $_imgserver."files/customdb/".$da['datas'];
			}
			else	{
				$row['d'.($i+1)] = $da['datas'];
			}
		}

		$datas[] = $row;
		$cou++;
	}
	if($du!=0)	{
		for($i=0;$i<($du-$cou);$i++)	{
			
			$datas[] = array();
		}
	}

	return $datas;
}
function get_setinfo($idx,$op="")	{
	
	global $pdo;

	$q = "select * from shop_goods_sets where sets_idx='$idx'";
	if($op!='')	{
		$q = $q . " AND sets_op='$op'";
	}
	$q = $q . " order by idx asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");
					
		
					
		$opstr = "";
		if($row['op1']!='')	{
			$ar_op = sel_query_all("shop_goods_op1"," WHERE idx='$row[op1]'");
			if($opstr!='')	{
				$opstr = $opstr . " / ";
			}
			$opstr = $ar_op['opname'];
		}
		if($row['op2']!='')	{
			$ar_op = sel_query_all("shop_goods_op2"," WHERE idx='$row[op2]'");
			if($opstr!='')	{
				$opstr = $opstr . " / ";
			}
			$opstr = $ar_op['opname'];
		}
		if($row['op3']!='')	{
			$ar_op = sel_query_all("shop_goods_op3"," WHERE idx='$row[op3]'");
			if($opstr!='')	{
				$opstr = $opstr . " / ";
			}
			$opstr = $ar_op['opname'];
		}

		$rows['goods_idx'] = $row['goods_idx'];
		$rows['gname'] = $ar_goods['gname'];
		$rows['opstr'] = $opstr;
		$rows['ea'] = $row['ea'];

		$datas[] = $rows;
	}
	return $datas;
}
function get_setinfo_basket($idx)	{
	
	global $pdo;



	$q = "select * from shop_newbasket where set_idx='$idx' order by idx asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," WHERE idx='$row[goods_idx]'");
					
		
		$opstr = "";
		if($row['op1']!='')	{
			$ar_op = sel_query_all("shop_goods_op1"," WHERE idx='$row[op1]'");
			if($opstr!='')	{
				$opstr = $opstr . " / ";
			}
			$opstr = $ar_op['opname'];
		}
		if($row['op2']!='')	{
			$ar_op = sel_query_all("shop_goods_op2"," WHERE idx='$row[op2]'");
			if($opstr!='')	{
				$opstr = $opstr . " / ";
			}
			$opstr = $ar_op['opname'];
		}
		if($row['op3']!='')	{
			$ar_op = sel_query_all("shop_goods_op3"," WHERE idx='$row[op3]'");
			if($opstr!='')	{
				$opstr = $opstr . " / ";
			}
			$opstr = $ar_op['opname'];
		}

		$rows['goods_idx'] = $row['goods_idx'];
		$rows['gname'] = $ar_goods['gname'];
		$rows['opstr'] = $opstr;
		$rows['ea'] = $row['ea'];

		$datas[] = $rows;
	}
	return $datas;
}
function get_live()	{
	global $pdo;

	$q = "select * from shop_movie_schedule where date>='".date("Y-m-d")."' order by stime asc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch() )	{
		
		$ar_movie = sel_query_all("shop_movie"," WHERE idx='$row[movie_idx]'");

		$lists[] = $ar_movie;
	}
	return $lists;
}
function get_opengoods()	{
	global $pdo;

	$q = "select * from shop_goods where isdel='N' and isopen='1' and openstr!='' order by idx desc";
	$st = $pdo->prepare($q);
	$st->execute();
	while($row = $st->fetch() )	{
		
		

		$lists[] = $row;
	}
	return $lists;
}
function get_cate_path($cate)	{
	
	global $pdo;
	
	$data = array();

	for($i=2;$i<=strlen($cate);$i=$i+2)	{
		
		$ar_cate = sel_query_all("shop_cate"," where catecode='".substr($cate,0,$i)."'");

		$data[] = $ar_cate;
	}
	return $data;
}
function get_coupen2()	{

	
	global $G_MEMIDX;
	global $g_ar_init;
	global $basket;
	global $pdo;

	$total = $basket['totalgaccount_pure'];

	$qc = "select idx,coupen_idx,edate,usedate  from shop_coupen_mem where mem_idx='$G_MEMIDX' and fids='$g_ar_init[fid]' and usetype='1' and actype<'3' and edate>='".date("Y-m-d H:i:s",time())."'";
	$st = $pdo->prepare($qc);
	$st -> execute();
	while($rowc = $st -> fetch() )	{	
		$ar_coupen = sel_query_all("shop_coupen"," where idx='$rowc[coupen_idx]'");

		$usesites = unserialize($ar_coupen['usesites']);

		if(!in_array($g_ar_init['idx'],$usesites))	{
			continue;	
		}
		

		if($ar_coupen[canuseac]!=0)
		{
			if($total>=$ar_coupen[canuseac])
			{	
				if($ar_coupen['actype']=='1') { $tp = "원";	} else { $tp = "%";	}
				if($rowc['usedate']=='')
				{	echo "<option value='$rowc[idx]'>$ar_coupen[coupenname] ($rowc[edate] 까지 - ".number_format($ar_coupen['account']).$tp.$a.")</option>";		}
			}
		}
		else
		{
			if($ar_coupen[actype]=='1') { $tp = "원";	} else { $tp = "%";	}
			if($rowc['usedate']=='')
			{	echo "<option value='$rowc[idx]'>$ar_coupen[coupenname] ($rowc[edate] 까지 - ".number_format($ar_coupen['account']).$tp.$a.")</option>";		}
		}
	}
}


function get_journal($page=0,$limit=6,$cate="",$keyword=""){
	global $pdo;
	global $_imgserver;
	
	
	$q = "select * from shop_journal where isshow='Y' and isdel='N'";
	if($cate!='')	{
		$q = $q . " and cate='$cate'";	
	}
	if($keyword!='')	{

		$q = $q ." and (subject like '%$keyword%' or memo like '%$keyword')";
	}
	$q = $q . " order by wdate desc limit $page, $limit";
	
	$st = $pdo->prepare($q);
	$st -> execute();
	$datas = [];
	while($row = $st->fetch())	{
		
		$ar_cate = sel_query_all("shop_journal_cate"," where idx='$row[cate]'");
		$row['catename'] = $ar_cate['catename'];
		$row['imgurl'] = $_imgserver."/journal/".$row['img'];
		
		$datas[] = $row;
	}
	
	return $datas;
}
function get_journalcount($page,$arr)	{

	global $g_ar_init;
	global $pdo;

	$PHP_SELF = $_SERVER["PHP_SELF"];

	$page_per_block = $arr['page_per_block'];
	
	$q = "select idx from shop_journal where isshow='Y' and isdel='N'";
	if($arr['cate'] != "")	{
		$q = $q ." and cate='".$arr['cate']."'";	
	}
	if($arr['keyword']!='')	{
		$keyword = $arr['keyword'];
		$q = $q ." and (subject like '%$keyword%' or memo like '%$keyword')";
	}
	$st = $pdo->prepare($q);
	$st->execute();

	$total_record = $st->rowCount();


	$total_page = ceil($total_record/$arr['numper']);

	if($total_record == 0)	{
		$first = 0; $last = 0; 
	}
	else	{
		$first = $arr['numper']*($page-1);  $last = $arr['numper'] * $page; 
	}
	
	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);

	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;

	if($total_block <= $block)	{
		$last_page = $total_page;	
	}

	$paging['first'] = $first;
	$paging['total_record'] = $total_record;
	$paging['nowpage'] = $page;
	$paging['total_page'] = $total_page;
	$paging['block'] = $block;
	$paging['totalblock'] = $total_block;

	$basiclink = $PHP_SELF."?act=journal&cate=".$arr['cate']."&keyword=".$arr['keyword'];
	
	if($block>1)	{	
		$before_page = $first_page;
		$paging['superfirstl'] = $basiclink."&page=$before_page";
	}
	
	if($total_record!=0)	{
		if(($page-1)<1)	{
			$paging['firstl'] = "javascript:alert('" . trscode('PAGE1') . "');";	
		}
		else	{
			$k = ($page-1);
			$paging['firstl'] = $basiclink."&page=$k";
		}
	}

	for($direct_page = $first_page+1; $direct_page <= $last_page;$direct_page++)		{
		$loop_paging[] = array('links'=>$basiclink."&page=$direct_page", 'page' =>$direct_page);  
	}

	if($total_record!=0)	{
		if(($page+1)>$total_page)	{
			$paging['lastl'] = "javascript:alert('" . trscode('PAGE2') . "');";	
		}
		else	{
			$k = ($page+1);
			$paging['lastl'] = $basiclink."&page=$k";
		}
	}

	if($block<$total_block)	{	
		$daum_page = $last_page+1;
		$paging['superlastl'] = $basiclink."&page=$daum_page";
	}

	$ar_redata['paging'] = $paging;
	$ar_redata['loop_paging'] = $loop_paging;

	return $ar_redata;
}

function get_event($page=0,$limit=6,$keyword){
	global $pdo;
	global $_imgserver;
	
	$q = "select * from shop_event where isshow='Y' and isdel='N'";
	if($keyword!='')	{
		$q = $q ." and (subject like '%$keyword%' or memo like '%$keyword')";
	}
	$q = $q . " order by wdate desc limit $page, $limit";
	
	$st = $pdo->prepare($q);
	$st -> execute();
	$datas = [];

	while($row = $st->fetch())	{
		
		$row['imgurl'] = $_imgserver."/event/".$row['img'];
		
		$datas[] = $row;
	}
	
	return $datas;
}
function get_eventcount($page,$arr)	{

	global $g_ar_init;
	global $pdo;

	$PHP_SELF = $_SERVER["PHP_SELF"];

	$page_per_block = $arr['page_per_block'];
	
	$q = "select idx from shop_event where isshow='Y' and isdel='N'";
	if($arr['keyword']!='')	{
		$keyword = $arr['keyword'];
		$q = $q ." and (subject like '%$keyword%' or memo like '%$keyword')";
	}
	$st = $pdo->prepare($q);
	$st->execute();

	$total_record = $st->rowCount();


	$total_page = ceil($total_record/$arr['numper']);

	if($total_record == 0)	{
		$first = 0; $last = 0; 
	}
	else	{
		$first = $arr['numper']*($page-1);  $last = $arr['numper'] * $page; 
	}
	
	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);

	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;

	if($total_block <= $block)	{
		$last_page = $total_page;	
	}

	$paging['first'] = $first;
	$paging['total_record'] = $total_record;
	$paging['nowpage'] = $page;
	$paging['total_page'] = $total_page;
	$paging['block'] = $block;
	$paging['totalblock'] = $total_block;

	$basiclink = $PHP_SELF."?act=event&keyword=".$arr['keyword'];
	
	if($block>1)	{	
		$before_page = $first_page;
		$paging['superfirstl'] = $basiclink."&page=$before_page";
	}
	
	if($total_record!=0)	{
		if(($page-1)<1)	{
			$paging['firstl'] = "javascript:alert('" . trscode('PAGE1') . "');";	
		}
		else	{
			$k = ($page-1);
			$paging['firstl'] = $basiclink."&page=$k";
		}
	}

	for($direct_page = $first_page+1; $direct_page <= $last_page;$direct_page++)		{
		$loop_paging[] = array('links'=>$basiclink."&page=$direct_page", 'page' =>$direct_page);  
	}

	if($total_record!=0)	{
		if(($page+1)>$total_page)	{
			$paging['lastl'] = "javascript:alert('" . trscode('PAGE2') . "');";	
		}
		else	{
			$k = ($page+1);
			$paging['lastl'] = $basiclink."&page=$k";
		}
	}

	if($block<$total_block)	{	
		$daum_page = $last_page+1;
		$paging['superlastl'] = $basiclink."&page=$daum_page";
	}

	$ar_redata['paging'] = $paging;
	$ar_redata['loop_paging'] = $loop_paging;

	return $ar_redata;
}
function get_brandnew($havesore){
	global $pdo;
	
	
	$q = "select * from shop_brand where 1";
	if($havestore=='Y')	{
		$q = " and havesore='Y'";	
	}
	$q = $q . " order by orders asc ";
	
	$st = $pdo->prepare($q);
	$st -> execute();
	$datas = [];

	while($row = $st->fetch())	{
		

		
		$datas[] = $row;
	}
	
	return $datas;
}
function get_wish($cou)	{
	global $pdo;
	global $G_MEMIDX;
	
	$q = "select * from shop_wish where mem_idx='$G_MEMIDX' order by idx desc limit 0,$cou";
	
	$st = $pdo->prepare($q);
	$st->execute();
	$datalist = [];
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," where idx='$row[goods_idx]'");
		
		$qs = "select * from shop_goods_imgs where goods_idx='$ar_goods[idx]' order by idx asc";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$ar_goods['simg'.$c] = $rows['filename'];	
			$c++;
		}
		
		$ar_maccount = get_newaccount($ar_goods);
		$ar_goods['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$ar_goods['account_pure'] = $ar_maccount['account'];

		$ar_goods['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$ar_goods['saccount_pure'] = $ar_maccount['saccount'];

		$ar_goods['saveper'] = 0;
		if($ar_goods['saccount_pure']!=0)	{
			//echo ($ar_data['saccount_pure']-$ar_data['account_pure'] );
			$ar_goods['saveper'] = ($ar_goods['saccount_pure']-$ar_goods['account_pure'] )/$ar_goods['saccount_pure']*100;
	
			$ar_goods['saveper'] = round($ar_goods['saveper']);
		}
		
		$datalist[] = $ar_goods;
	}
	return $datalist;
}
function get_today($cou)	{
	global $pdo;
	global $G_MEMIDX;
	
	$q = "select * from shop_view_today where mem_idx='$G_MEMIDX' order by wdate desc limit 0,$cou";
	
	$st = $pdo->prepare($q);
	$st->execute();
	$datalist = [];
	while($row = $st->fetch())	{
		
		$ar_goods = sel_query_all("shop_goods"," where idx='$row[goods_idx]'");
		
		$qs = "select * from shop_goods_imgs where goods_idx='$ar_goods[idx]' order by idx asc";
		$sts = $pdo->prepare($qs);
		$sts->execute();
		$c = 1;
		while($rows = $sts->fetch())	{
			$ar_goods['simg'.$c] = $rows['filename'];	
			$c++;
		}
		
		$ar_maccount = get_newaccount($ar_goods);
		$ar_goods['account'] = number_format($ar_maccount['account'],$g_ar_curr['showstd']);
		$ar_goods['account_pure'] = $ar_maccount['account'];

		$ar_goods['saccount'] = number_format($ar_maccount['saccount'],$g_ar_curr['showstd']);
		$ar_goods['saccount_pure'] = $ar_maccount['saccount'];

		$ar_goods['saveper'] = 0;
		if($ar_goods['saccount_pure']!=0)	{
			//echo ($ar_data['saccount_pure']-$ar_data['account_pure'] );
			$ar_goods['saveper'] = ($ar_goods['saccount_pure']-$ar_goods['account_pure'] )/$ar_goods['saccount_pure']*100;
	
			$ar_goods['saveper'] = round($ar_goods['saveper']);
		}
		
		$datalist[] = $ar_goods;
	}
	return $datalist;
}
function get_count($c)	{
	
	$datas = [];
	for($i=0;$i<$c;$i++)	{
		$row['c'] = $i;
		$datas[] = $row;
	}
	return $datas;
}
?>
