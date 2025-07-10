<?

function gmenu_info($valid = false){
	global $admin_menu, $basictb, $connect, $bizhost_custom_menu;
	
	if ( is_array($admin_menu) ) {
		if ( $valid ) {
			
				
				$side_menu_file = "./side_menu.php";
				if( is_file($side_menu_file) ) {
					unset($_sidemenu);
					include $side_menu_file;
					
					foreach ( $_sidemenu as $kk => $vv ) {
						foreach ( $vv as $kkk => $vvv ) {
							$q = "code=".$vvv['code'];
							parse_str($q, $out);
							unset($varstr);
							foreach ( $out as $kkkk => $vvvv ) {
								$varstr .= "$kkkk$vvvv";
							}
							
							$gmenu[$dir][$varstr]['name'] = $vvv['name'];
							$gmenu[$dir][$varstr]['code'] = $vvv['code'];
							
							if ( is_array($vvv['group']) ) {
								foreach ( $vvv['group'] as $vvvv ) {
									$gmenu[$dir]["code".$vvvv]['name'] = $vvv['name'];
									$gmenu[$dir]["code".$vvvv]['code'] = $vvv['code'];
								}
							}
						}
					}
				}
			
			return $gmenu;
		} else {
			
				
				$side_menu_file = "./side_menu.php";
				if( is_file($side_menu_file) ) {
					unset($_sidemenu);
					include $side_menu_file;
					
					//커스텀 메뉴 추가
					if ( $bizhost_custom_menu[$k] ) {
						$_sidemenu = array_merge($_sidemenu, $bizhost_custom_menu[$k]);
					}

					$gmenu[$v] = $_sidemenu;
					$gmenudir[$v] = $dir;
				}
			

			return array($gmenu, $gmenudir);
		}
	} else {
		return false;
	}
}

$grade_id = $_REQUEST['grade_id'];
$ar_grade = sel_query_all("shop_admin_grade"," where grade_id='$grade_id'");
list($gmenu, $gmenudir) = gmenu_info();
$mode = $_REQUEST['mode'];
if($mode=='w')
{

	$q = "update shop_admin_priv set tp='Y' where grade_id='$grade_id'";
	$st = $pdo->prepare($q);
	$st->execute();
	
	
	if ( is_array($_POST['mymenu']) ) {
		foreach ( $_POST['mymenu'] as $row ) {
			$data = explode("|", $row);

			$q = "select * from shop_admin_priv where grade_id='$grade_id' and dir='$data[1]' and code='$data[2]'";
			$st = $pdo->prepare($q);
			$st->execute();
			$isit = $st->rowCount();

			if($isit==0)
			{
				$value['grade_id'] = $grade_id;
				$value['menu_name'] = $data[0];
				$value['dir'] = $data[1];
				$value['code'] = $data[2];
				insert("shop_admin_priv", $value);			
				unset($value);
			}
			else
			{
				$row = $st->fetch();

				$value['tp'] = "";
				update("shop_admin_priv", $value," where idx='$row[idx]'");		
				unset($value);
			}


			$q = "delete from shop_admin_priv where tp='Y' and grade_id='$grade_id'";
			$st = $pdo->prepare($q);
			$st->execute();
		}
	}
	echo "<Script>alert('권한설정이 완료되었습니다.'); location.replace('$G_PHP_SELF?code=$code&grade_id=$grade_id'); </script>";
	exit;
}

$q = "select * from shop_admin_priv where grade_id='$grade_id'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch()){
	$mcklist[$row['dir']][$row['code']] = true;
}
?>
<style>
label	{	margin-right:20px;margin-left:5px;	}

</style>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> <?=$ar_grade['grade_name'];?> 권한설정</h3>
			</div>
			<div class="panel-content">


	<form name="regiform" id="regiform"  action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
	<input type='hidden' name='mode' value='w'>
	<input type='hidden' name='grade_id' value='<?=$grade_id;?>'>
		<table class="table table-bordered">
	<?
	$str_checked = "";
	if ( $mcklist['index']['main1'] ) $str_checked = ' checked="checked"';
	?>
	<tr>
		<th style="width:190px;">관리자메인</th>
		<td><input<?=$str_checked ?> name="mymenu[]" type="checkbox" id="gmemu_index_main" value="관리자메인|index|main1" /> <label>매출내역</label></td>
	</tr>
	<tr>
		<th style="width:190px;">주문금액변경</th>
		<td>
		<?
	$str_checked = "";
	if ( $mcklist['index']['chbasket'] ) $str_checked = ' checked="checked"';
	?>
		<input<?=$str_checked ?> name="mymenu[]" type="checkbox" id="gmemu_index_chbasket" value="주문금액변경|index|chbasket" /> <label>주문서상품가격변경</label>
		</td>
	</tr>
	
	
<?php
foreach ( $gmenu as $k => $v ) {
	$dir = $gmenudir[$k];
	$str_checked = "";
	$maincode = 'upmainmenu';
	if ( $mcklist[$dir][$maincode] ) $str_checked = ' checked="checked"';
?>
	<!-- <tr>
		<th style="width:190px;"><?=$k?></th>
		<td><input<?=$str_checked ?> name="mymenu[]" type="checkbox" id="gmemu_<?=$dir?>_<?=$maincode?>" value="<?=$k?>|<?=$dir?>|<?=$maincode?>" /> 상단메뉴노출</td>
	</tr> -->
<?
	foreach ( $v as $kk => $vv ) {
?>
			<tr>
				<th style="width:190px;"><?=$kk?></th>
				<td>
<?php
		foreach ( $vv as $kkk => $vvv ) {
			$str_checked = "";
			if ( $mcklist[$dir][$vvv['code']] ) $str_checked = ' checked="checked"';
?>
					<div style="display:block;float:left;"><input<?=$str_checked ?> name="mymenu[]" type="checkbox" id="gmemu_<?=$dir?>_<?=$vvv['code']?>" value="<?=$vvv['name']?>|<?=$dir?>|<?=$vvv['code']?>" /> <label for="gmemu_<?=$dir?>_<?=$vvv['code']?>"><?=$vvv['name']?></label></div>
<?php
		}
?>
				</td>
			</tr>
<?php
	} //.foreach
}
?>
		</table>
		<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">설정하기</button>
						
					</div>
				</div>

	</form><!-- // .form[name="frm"] -->
			</div>
		</div>
	</div>
</div>
