<?php
$idx = $_REQUEST['idx'];
$ar_data = sel_query_all("shop_config"," WHERE idx='$idx'");
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	foreach($_REQUEST AS $key => $val)	{
		
		if(!is_array($_REQUEST[$key]))	{

			$_REQUEST[$key] = addslashes(trim($val));
		}
	}
	
	$value['site_url'] = $_REQUEST['site_url'];
	$value['language'] = $_REQUEST['language'];
	$value['language_use'] = $_REQUEST['language_use'];
	$value['curr'] = $_REQUEST['curr'];
	$value['site_name'] = $_REQUEST['site_name'];
	$value['site_phone'] = $_REQUEST['site_phone'];
	$value['site_member_group'] = $_REQUEST['site_member_group'];
	$value['Meta_Subject'] = $_REQUEST['Meta_Subject'];
	$value['site_title'] = $_REQUEST['site_title'];
	$value['Meta_keywords'] = $_REQUEST['Meta_keywords'];
	$value['Meta_Description'] = $_REQUEST['Meta_Description'];
	$value['site_del1'] = $_REQUEST['site_del1'];
	$value['site_del2'] = $_REQUEST['site_del2'];
	$value['site_stdaccount'] = $_REQUEST['site_stdaccount'];
	$value['site_stdaccountm'] = $_REQUEST['site_stdaccountm'];
	$value['usedelac_member'] = $_POST['usedelac_member'];
	$value['usedelac_nomember'] = $_POST['usedelac_nomember'];
	$value['delaccount_member_std'] = $_POST['delaccount_member_std'];
	$value['delaccount_nomember_std'] = $_POST['delaccount_nomember_std'];
	$value['delaccount_member'] = $_POST['delaccount_member'];
	$value['delaccount_nomember'] = $_POST['delaccount_nomember'];
	$value['Meta_etc'] = addslashes($_POST['Meta_etc']);

	$userfile = array($_FILES['site_con']['name'],$_FILES['site_conm']['name']);
	$tmpfile = array($_FILES['site_con']['tmp_name'],$_FILES['site_conm']['tmp_name']);

	$savedir = $_uppath."icon/";

	$ar_last = array($ar_data['site_con'],$ar_data['site_conm']);
	$ar_del = array("N","N");
	
	if(!is_dir($savedir))	{	
		mkdir($savedir, 0777);	chmod($savedir,0707);  
	}



	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);
	}
	$value['site_con'] = $fs[0];
	$value['site_conm'] = $fs[1];

	update("shop_config",$value," WHERE idx='$idx'");


	show_message("수정완료","");
	move_link("$G_PHP_SELF?code=$code&idx=$idx");
	exit;

}
?>
<form name="wform" id="wform" action="<?=$G_PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='idx' value='<?=$idx;?>'>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 기본정보</h3>
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
					<th>종류</th>
					<td colspan='3'>
						<?php
						if($ar_data['site_mobile']=='1')	{
							echo "PC웹사이트";	
						}
						else if($ar_data['site_mobile']=='2')	{
							echo "모바일사이트";
						}
						else if($ar_data['site_mobile']=='3')	{
							echo "반응형웹";	
						}
						else if($ar_data['site_mobile']=='O')	{
							echo "외부주문처";	
						}
						?>
					</td>
				</tr>
				<tr>
					<th>명칭</th>
					<td colspan='3'><input type='text' class='form-control' name='site_name' value="<?= $ar_data['site_name']; ?>"></td>
				</tr>
				<tr>
					<th>기본언어/사용언어</th>
					<td>
						<div class="form-inline">
						<select name='language'>
						<?
						$q = "SELECT * FROM shop_config_lang where isuse='Y'";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() )	{

							$se = "";
							if($row['namecode']==$ar_data['language'])	{
								$se = "selected";	
							}

							echo "<option value='$row[namecode]' $se>$row[name]</option>";
						}
						?>
						</select>
						<select name='language_use'>
						<option value='1' <? if($ar_data['language_use']=='1') {?>selected<?}?>>모든언어사용</option>
						<option value='2' <? if($ar_data['language_use']=='2') {?>selected<?}?>>기본언어만사용</option>
						</select>
						</div>
					</td>
					<th>사용통화</th>
					<td>
						<select name='curr' class='form-control'>
						<?
						$q = "SELECT * FROM shop_config_curr";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch() )	{
							
							$se = "";
							if($row['name']==$ar_data['curr'])	{
								$se = "selected";	
							}

							echo "<option value='$row[name]' $se>$row[name]</option>";
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>판매가격기준</th>
					<td>
						<select name='site_stdaccount' class="form-control">
						<option value='account' <? if($ar_data['site_stdaccount']=='account') { echo "selected";	}?>>판매가사용</option>
						<option value='account_over' <? if($ar_data['site_stdaccount']=='account_over') { echo "selected";	}?>>해외판가가사용</option>
						</select>
					</td>
					<th>환율계산방식</th>
					<td>
						<label><input type='radio' name='site_stdaccountm' value='1' <? if($ar_data['site_stdaccountm']=='1') { echo "checked";	}?>>세팅환율로계산</label>
						<label><input type='radio' name='site_stdaccountm' value='2' <? if($ar_data['site_stdaccountm']=='2') { echo "checked";	}?>>입력가격으로노출(미입력시 환율계산)</label>
					</td>
				</tr>
				<tr>
					<th>한국배송사용</th>
					<td colspan='3'>
						<select name='site_del1' class="form-control">
						<option value='Y' <? if($ar_data['site_del1']=='Y') { echo "selected";	}?>>사용</option>
						<option value='N' <? if($ar_data['site_del1']=='N') { echo "selected";	}?>>사용안함</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>해외배송제한</th>
					<td>
						<select name='site_del2' class="form-control">
						<option value='Y' <? if($ar_data['site_del2']=='Y') { echo "selected";	}?>>모든국가배송</option>
						<option value='N' <? if($ar_data['site_del2']=='N') { echo "selected";	}?>>지정국가만배송</option>
						</select>
					</td>
					<th>배송지정국가</th>
					<td>
						
					</td>
				</tr>
				<tr>
					<th>기본연락처</th>
					<td colspan='3'><input type='text' class='form-control' name='site_phone' value="<?= $ar_data['site_phone']; ?>"></td>
				</tr>
				<tr>
					<th>묶음배송정책(회원)</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='radio' name='usedelac_member' value='Y' <? if($ar_data['usedelac_member']=='Y') { echo "checked";	}?>> 배송비사용 <input type='radio' name='usedelac_member' value='N' <? if($ar_data['usedelac_member']=='N') { echo "checked";	}?>> 배송비사용안함 <br>
				 
						<input type='text' name='delaccount_member_std' class='form-control'  value="<?=$ar_data['delaccount_member_std'];?>">원미만 <input type='text' name='delaccount_member'  class='form-control' value="<?=$ar_data['delaccount_member'];?>">원 부과
					</td>
				</tr>
				<tr>
					<th>묶음배송정책(비회원)</th>
					<td colspan='3'>
						<div class="form-inline">
						<input type='radio' name='usedelac_nomember' value='Y' <? if($ar_data['usedelac_nomember']=='Y') { echo "checked";	}?>> 배송비사용 <input type='radio' name='usedelac_nomember' value='N' <? if($ar_data['usedelac_nomember']=='N') { echo "checked";	}?>> 배송비사용안함<br>
				 
						<input type='text' class='form-control' name='delaccount_nomember_std'  value="<?=$ar_data['delaccount_nomember_std'];?>"> 원미만 <input type='text' class='form-control' name='delaccount_nomember'  value="<?=$ar_data['delaccount_nomember'];?>"> 원 부과
						</div>
					</td>
				</tr>
				
				<?php
				if($ar_data['site_mobile']!='O')	{
				?>
				<tr>
					<th>사용회원그룹</th>
					<td colspan='3'>
						<select name='site_member_group' class='form-control'>
						<?php
                        $q = "select * from shop_member_group";
                        $st = $pdo->prepare($q);
						$st->execute();
						while ($row = $st->fetch() )	{
							$se = "";
							if ($row['idx'] == $ar_data['site_member_group'])	{
								$se = "selected";
							}
                             echo "<option value='$row[idx]' $se>$row[groupname]</option>";
						}    
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>메인로그인사용</th>
					<td colspan='3'>
						<label><input type='radio' name='login_check1' value='N' <? if ($ar_data['login_check1'] == 'N')	{	echo "checked";	}?>>사용안함</label>
						<label><input type='radio' name='login_check1' value='Y' <? if ($ar_data['login_check1'] == 'Y')	{	echo "checked";	}?>>사용함</label>
					</td>
				</tr>
				<?php }	?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
if($ar_data['site_mobile']!='O')	{
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> SEO설정</h3>
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
					<th>파비콘</th>
					<td colspan='3'><input type='file' class='form-control' name='site_con'><? if($ar_data['site_con']!='') { echo $ar_data['site_con']."등록"; }?></td>
				</tr>
				<tr>
					<th>타이틀 [tile태그]</th>
					<td colspan='3'><input type='text' class='form-control' name='site_title' value="<?=$ar_data['site_title'];?>"></td>
				</tr>
				<tr>
					<th>Meta_Subject</th>
					<td colspan='3'><input type='text' class='form-control' name='Meta_Subject' value="<?=$ar_data['Meta_Subject'];?>"></td>
				</tr>
				<tr>
					<th>Meta_keywords</th>
					<td colspan='3'><input type='text' class='form-control' name='Meta_keywords' value="<?=$ar_data['Meta_keywords'];?>"></td>
				</tr>
				<tr>
					<th>Meta_description</th>
					<td colspan='3'><input type='text' class='form-control' name='Meta_Description' value="<?=$ar_data['Meta_Description'];?>"></td>
				</tr>
				<tr>
					<th>og:image</th>
					<td colspan='3'><input type='file' class='form-control' name='site_conm'><? if($ar_data['site_conm']!='') { echo $ar_data['site_conm']."등록"; }?></td>
				</tr>
				<tr>
					<th>기타메타</th>
					<td colspan='3'><textarea class='form-control' name='Meta_etc' style="height:400px;"><?=$ar_data['Meta_etc'];?></textarea></td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 이용약관/개인정보취급방침</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					
					<th>언어</th>
					<th>이용약관</th>
					<th>개인정보취급방침</th>
					<th>사업자정보</th>
					<th>CS안내</th>
					<th>상품정보</th>
					<th>배송/교환/반품</th>
					<th>취급시주의사항</th>
				</tr>
				</thead>
				<tbody>

				<?
				$q = "SELECT * FROM shop_config_lang where isuse='Y'";
				$st = $pdo->prepare($q);
				$st->execute();
				while($row = $st->fetch() )	{
				?>
				<tr>
					<td><?=$row['name'];?> / <?=$row['namecode'];?></td>
					<td>
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=config_memo&pid=<?=$idx;?>&lang=<?=$row['namecode'];?>&mtype=1','memos','width=1000,height=800,scrollbars=yes,top=0,left=0')" class="btn btn-sm btn-primary">편집</a>
					</td>
					<td>
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=config_memo&pid=<?=$idx;?>&lang=<?=$row['namecode'];?>&mtype=2','memos','width=1000,height=800,scrollbars=yes,top=0,left=0')" class="btn btn-sm btn-primary">편집</a>
					</td>
					<td>
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=config_memo&pid=<?=$idx;?>&lang=<?=$row['namecode'];?>&mtype=3','memos','width=1000,height=800,scrollbars=yes,top=0,left=0')" class="btn btn-sm btn-primary">편집</a>
					</td>
					<td>
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=config_memo&pid=<?=$idx;?>&lang=<?=$row['namecode'];?>&mtype=4','memos','width=1000,height=800,scrollbars=yes,top=0,left=0')" class="btn btn-sm btn-primary">편집</a>
					</td>
					<td>
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=config_memo&pid=<?=$idx;?>&lang=<?=$row['namecode'];?>&mtype=5','memos','width=1000,height=800,scrollbars=yes,top=0,left=0')" class="btn btn-sm btn-primary">편집</a>
					</td>
					<td>
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=config_memo&pid=<?=$idx;?>&lang=<?=$row['namecode'];?>&mtype=6','memos','width=1000,height=800,scrollbars=yes,top=0,left=0')" class="btn btn-sm btn-primary">편집</a>
					</td>
					<td>
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=config_memo&pid=<?=$idx;?>&lang=<?=$row['namecode'];?>&mtype=7','memos','width=1000,height=800,scrollbars=yes,top=0,left=0')" class="btn btn-sm btn-primary">편집</a>
					</td>
				<?
				}
				?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
}
?>
<div class="row">
	<div class="col-md-12">
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#wform">저장하기</button>
						
				</div>
			</div>
	</div>
</div>

</form>