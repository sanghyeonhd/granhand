<?php
$rcou = $_REQUEST['rcou'];
$in_idx = $_REQUEST['in_idx'];
$ar_shops = sel_query_all("shop_goods_shops"," WHERE index_no='$in_idx'");
$mode = $_REQUEST['mode'];
if($mode=='w')	{

	$gcode = $_REQUEST['gcode'];
	$gname = $_REQUEST['gname'];
	$cate = $_REQUEST['cate'];
	$daccount = $_REQUEST['daccount'];
	$account = $_REQUEST['account'];
	$opname1 = $_REQUEST['opname1'];
	$op1str = $_REQUEST['op1str'];
	$opname2 = $_REQUEST['opname2'];
	$op2str = $_REQUEST['op2str'];
	$opname3 = $_REQUEST['opname3'];
	$op3str = $_REQUEST['op3str'];
	$gdname = $_REQUEST['gdname'];
	

	for($i=0;$i<sizeof($gname);$i++)	{
		
		if($gname[$i]!='')	{
			
			$value['gcode'] = $gcode[$i];
			$value['gname'] = $gname[$i];
			$value['md_idx'] = $g_memidx;
			$value['buytype'] = "A";
			$value['account'] = $account[$i]*100;
			$value['daccount'] = $daccount[$i]*100;

			$value['pointper'] = "1";
			$value['point'] = "1";
			$value['deltype'] = "1";

			$value['gdname'] = $gdname[$i];

			$value['fid'] = "1";
	
			$userfile = array($_FILES['file1_'.($i+1)]['name'],$_FILES['file2_'.($i+1)]['name']);
			$tmpfile = array($_FILES['file1_'.($i+1)]['tmp_name'],$_FILES['file2_'.($i+1)]['tmp_name']);

			$savedir = $_uppath."goods/";
	
			if(!is_dir($savedir))	{	
				mkdir($savedir, 0777);	chmod($savedir,0707);  
			}
			
			for($is=0;$is<sizeof($userfile);$is++)	{
				$fs[$is] = uploadfile($userfile[$is],$tmpfile[$is],$is,$savedir);	
			}
	
			$value['simg1'] = $fs[0];
			$value['simg2'] = $fs[1];
			$value['isopen'] = "1";
			$value['isshow'] = "N";
			$value['regi_date'] = date("Y-m-d H:i:s");
			$value['in_idx'] = $in_idx;
			$value['opname1'] = $opname1[$i];
			if($value['opname1']!='')	{
				$value['useop1'] = "Y";
			}

			$value['opname2'] = $opname2[$i];
			if($value['opname2']!='')	{
				$value['useop2'] = "Y";
			}

			$value['opname3'] = $opname3[$i];
			if($value['opname3']!='')	{
				$value['useop3'] = "Y";
			}
			
		 	$value['smemo_type'] = "2";
			insert("shop_goods",$value);
			unset($value);
			$index_no = $pdo->lastInsertId();
			

			//옵션처리
			if($op1str[$i]!='')	{
			
				$tmp_ops = explode(",",$op1str[$i]);

				for($j=0;$j<sizeof($tmp_ops);$j++)	{
				
					if($tmp_ops[$j]!='')	{
					
						$value['goods_idx'] = $index_no;
						$value['opname'] = trim($tmp_ops[$j]);
						$value['isuse'] = "Y";
						insert("shop_goods_op1",$value);
						unset($value);
					}	
				}
			}

			if($op2str[$i]!='')	{
			
				$tmp_ops = explode(",",$op2str[$i]);

				for($j=0;$j<sizeof($tmp_ops);$j++)	{
				
					if($tmp_ops[$j]!='')	{
					
						$value['goods_idx'] = $index_no;
						$value['opname'] = trim($tmp_ops[$j]);
						$value['isuse'] = "Y";
						insert("shop_goods_op2",$value);
						unset($value);
					}	
				}
			}
			if($op3str[$i]!='')	{
			
				$tmp_ops = explode(",",$op3str[$i]);

				for($j=0;$j<sizeof($tmp_ops);$j++)	{
				
					if($tmp_ops[$j]!='')	{
					
						$value['goods_idx'] = $index_no;
						$value['opname'] = trim($tmp_ops[$j]);
						$value['isuse'] = "Y";
						insert("shop_goods_op3",$value);
						unset($value);
					}	
				}
			}

			//옵션처리끝
			$cates = $cate[$i];
			$q = "select * from shop_goods_cate where goods_idx='$index_no' and catecode='$cates'";
			$st = $pdo->execute();
			$st->execute();
			$isit = $st->rowCount();

			if($isit==0)	{
				$q = "update shop_goods_cate set orders=(orders+1) where catecode='$cates'";
				$st = $pdo->prepare($q);
				$st->execute();

				$value[catecode] = $cates;
				$value[goods_idx] = $index_no;
				$value[orders] = 1;
				insert("shop_goods_cate",$value);
				unset($value);
			}

		}

	}

	echo "<script>alert('상품등록 완료'); location.replace('$PHP_SELF?code=goods_list'); </script>";
	exit;
}
?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('상품등록 하시겠습니까?');
		if(answer==true)	{
			return true;
		}
		else	{
			return false;
		}
	}
	else	{
		return false;
	}
}
</script>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록기초정보</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>상품등록갯수</th>
					<td><?=$rcou;?></td>
					<th>거래처</th>
					<td><?=$ar_shops['name'];?></td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품등록정보</h3>
			</div>
			<div class="panel-content">
				<form name="listform" id="listform" method="post" ENCTYPE="multipart/form-data" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='in_idx' value='<?=$in_idx;?>'>
				<p>상품명이 들어가지 않으면 상품등록이 되지 않습니다. 원가,판매가격은 숫자만 입력하세요. 옵션명칭은 색상,사이즈 / 옵션항목은 콤마로 구분하여 입력 (예 : S,M,L)</p> 
				<table class="table table-bordered">
				<colgroup>
					<col width="50px;">
				</colgroup>
				<thead>
				<tr>
					<th>NO</th>
					<th>상품코드</th>
					<th>상품명</th>
					<th>도매명</th>
					<th>카테고리</th>
					<th>원가</th>
					<th>판매가격</th>
					<th>옵션1명칭</th>
					<th>옵션1항목</th>
					<th>옵션2명칭</th>
					<th>옵션2항목</th>
					<th>옵션3명칭</th>
					<th>옵션3항목</th>
					<th>목록이미지</th>
					<th>상세이미지</th>
				</tr>
				</thead>
				<tbody>
				<?php
				for($i=0;$i<$rcou;$i++)	{
				?>
				<tr>
					<td><?=($i+1);?></td>
					<td><input type='text' name='gcode[]' class="form-control"></td>
					<td><input type='text' name='gname[]' class="form-control"></td>
					<td><input type='text' name='gdname[]' class="form-control"></td>
					<td>
						<select name='cate[]'>
						<option value=''>선택</option>
						<?php
						$q = "select * from shop_cate order by catecode";	
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$catecode_len = strlen($row[catecode]);
							if($catecode_len==2)	{
								$first=$row[catename];
								echo "<option value='$row[catecode]' $se>$row[catename]</option>";
								$ar_searchcate[$row[catecode]] = $row[catename];
							}
							else if($catecode_len==4)	{
								$second=$row[catename];
								echo "<option value='$row[catecode]' $se>$first > $row[catename]</option>";
								$ar_searchcate[$row[catecode]] = "$first > $row[catename]";
							}
							else if($catecode_len==6)	{
								echo "<option value='$row[catecode]' $se>$first > $second > $row[catename]</option>";	
								$ar_searchcate[$row[catecode]] = "$first > $second > $row[catename]";
							}
						}
						?>
						</select>
					</td>
					<td><input type='text' name='daccount[]' class="form-control"></td>
					<td><input type='text' name='account[]' class="form-control"></td>
					<td><input type='text' name='opname1[]' class="form-control"></td>
					<td><input type='text' name='op1str[]' class="form-control"></td>
					<td><input type='text' name='opname2[]' class="form-control"></td>
					<td><input type='text' name='op2str[]' class="form-control"></td>
					<td><input type='text' name='opname3[]' class="form-control"></td>
					<td><input type='text' name='op3str[]' class="form-control"></td>

					<td><input type='file' name='file1_<?=($i+1);?>' class="form-control"></td>
					<td><input type='file' name='file2_<?=($i+1);?>' class="form-control"></td>
				</tr>
				<?}?>
				</tbody>
				</table>
				
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#listform">상품등록</button>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>