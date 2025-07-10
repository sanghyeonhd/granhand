<?php
$ar_data = sel_query_all("shop_design_mainconfig"," where idx='$idx'");

if ( $mode == 'imgu' ) {
	$data_image = data_preview($ar_data);
	$savedir = $_uppath."new_main/";
	$savefile = $ar_data[sector_id]."_".time().".png";
	rename($data_image, $savedir.$savefile);
	$value['sector_img'] = $savefile;
	update("shop_design_mainconfig", $value, " WHERE idx = '{$ar_data[idx]}'");
	unset($value);

	echo "<script>alert('노출이미지 업데이트완료!'); location.replace('$G_PHP_SELF?idx=$idx');</script>";
	exit;
}
if( $mode == 'w' ) {
	$value['main_idx'] = $idx;
	$value['goods_idx'] = $_POST['goods_idx'];
	$value['links'] = $_POST['links'];
	$value['target'] = $_POST['target'];
	$value['orders'] = $_POST['orders'];
	$value['text'] = addslashes($_POST['text']);
	$value['text2'] = addslashes($_POST['text2']);
	$value['maps'] = addslashes($_POST['maps']);
	$value['isuse'] = $_POST['isuse'];
	$value["showsites"]	= serialize($_REQUEST['showsite']);

	$userfile = array($_FILES['file']['name'],$_FILES['file2']['name']);
	$tmpfile = array($_FILES['file']['tmp_name'],$_FILES['file2']['tmp_name']);
	
	

	$savedir = $_uppath."new_main/";

	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}

	$value['imgs'] = $fs[0]; 
	$value['imgs_sub'] = $fs[1]; 
	insert("shop_design_maindata",$value);
	
	echo "<Script>alert('등록완료'); location.replace('$G_PHP_SELF?code=$code&idx=$idx');</script>";
	exit;
}
if( $mode == 'w2' ) {	
	$savedir = $_uppath."new_main/";
	$cous = $_REQUEST['cous'];
	echo $cous;
	for($i=1;$i<$cous;$i++)
	{
		$data_idx = $_REQUEST['data_idx'.$i];
		echo $data_idx."<br>";
		$aR_m = sel_query_all("shop_design_maindata"," where idx='$data_idx'");
		$value['links'] = $_POST['links'.$i];
		$value['orders'] = $_POST['orders'.$i];
		$value['text'] = addslashes($_POST['text_'.$i]);
		$value['text2'] = addslashes($_POST['text_'.$i.'_2']);
		$value['maps'] = addslashes($_POST['maps'.$i]);
		$value['isuse'] = $_POST['isuse'.$i];
		$value['showsites'] = serialize($_POST['showsites'.$i]);

		
		$userfile = array($_FILES['file'.$i]['name'],$_FILES['files'.$i]['name']);
		$tmpfile = array($_FILES['file'.$i]['tmp_name'],$_FILES['files'.$i]['tmp_name']);
		$ar_del = array("N","N");
		$ar_last = array($aR_m['imgs'],$aR_m['imgs_sub']);
		for($j=0;$j<sizeof($userfile);$j++)
		{	$fs[$j] = uploadfile_mod($userfile[$j],$tmpfile[$j],$j,$savedir,$ar_last[$j],$ar_del[$j]);	}

		$value['imgs'] = $fs[0];
		$value['imgs_sub'] = $fs[1];
		update("shop_design_maindata",$value," where idx='$data_idx'");
		echo $_POST['text'.$i.'2'];
		echo mysqli_error();
		print_r($value);
		
	}

	echo "<Script>alert('수정완료'); location.replace('$G_PHP_SELF?code=$code&idx=$idx');</script>";
	exit;
}
if($mode=='d')
{
	$bidx = $_REQUEST['bidx'];
	$aR_m = sel_query_all("shop_design_maindata"," where idx='$bidx'");
	if($aR_m['imgs']!='')
	{	@unlink($_uppath."new_main/".$aR_m['imgs']);	}
	$pdo->prepare("delete from shop_design_maindata where idx='$bidx'")->execute();

	echo "<Script>alert('삭제완료'); location.replace('$G_PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;
}
if($mode=='orm')
{
	$ar_index = $_REQUEST['ar_index'];
	$ar_orders = $_REQUEST['ar_orders'];


	$ar_index = explode("|R|",$ar_index);
	$ar_orders = explode("|R|",$ar_orders);

	for($i=0;$i<sizeof($ar_index);$i++)
	{
		if($ar_orders[$i]!='')
		{
			$value['orders'] = $ar_orders[$i];
			update("shop_design_maindata",$value," where idx='$ar_index[$i]'");
		}
	}

	echo "<Script>alert('완료'); location.replace('$G_PHP_SELF?code=$code&idx=$idx'); </script>";
	exit;
}
?>

<style>
	.lang_ko {  background-color:#FFFFFF; }
	.lang_en {  background-color:#EBF6FF; }
	.lang_zh {  background-color:#FFEDED; }
</style>


<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header panel-controls">
				<h3><i class="fa fa-table"></i> <?=$ar_data['mainname'];?></h3>
			</div>
			<div class="panel-content">

				<form id="search" name="regiform" action="<?=$G_PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='idx' value='<?=$idx;?>'>
				<table class="table table-bordered">
				<tr>
					<th>노출사이트</th>
					<td>
						<?
						$q = "SELECT * FROM shop_config WHERE fid='$ar_data[fid]'";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$page_ar_sites[] = $row;
						?>
						<label><input type='checkbox' name='showsite[]' value='<?=$row['idx'];?>' checked><?=$row['site_name'];?></label>
						<?
						}
						?>
					</td>
				</tr>
				<tr>
					<th>파일</th>
					<td><input type='file' class="form-control" name='file'></td>
				</tr>
				<tr>
					<th>보조파일</th>
					<td><input type='file' class="form-control"  name='file2'></td>
				</tr>
				<tr>
					<th>링크주소</th>
					<td>
						<div class="form-inline">
						<input type='text' class="form-control"  class="form-control"  name='links' size='60'> [ 도메인은 제외 하고 입력 ]
						</div>
					</td>
				</tr>
				<tr>
					<th>HTML</th>
					<td>
						
						<textarea name='maps' class="form-control"  style='width:200px;height:100px;'></textarea>
					</td>
				</tr>
				<tr>
					<th>연결방법</th>
					<td>
						<select  class="form-control"  name='target'>
						<option value='_self'>현재창</option>
						<option value='_blank'>새창</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>노출텍스트</th>
					<td><input type='text' class="form-control"  name='text'></td>
				</tr>
				<tr>
					<th>노출텍스트2</th>
					<td><input type='text' class="form-control"  name='text2'></td>
				</tr>
				<tr>
					<th>정렬순서</th>
					<td><input type='text' class="form-control"  name='orders'></td>
				</tr>
				<tr>
					<th>노출여부</th>
					<td>
						<select name='isuse' class="form-control" >
						<option value='Y'>노출함</option>
						<option value='N'>노출안함</option>
						</select>
					</td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
							<a href="#none" class="btn btn-primary btn_submits" data-form="#search">저장하기</a>
					</div>
				</div>
				</form>



			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header panel-controls">
				<h3><i class="fa fa-table"></i> 등록된 데이터</h3>
			</div>
			<div class="panel-content">


<form id="regiform" name="regiform" action="<?=$G_PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
<input type='hidden' name='mode' value='w2'>
<input type='hidden' name='idx' value='<?=$idx;?>'>


	<table class="table table-bordered">
		
		<thead>
		<tr>
			<th>
				번호
			</th>
			<th>종류</th>
			<th>
				링크
			</th>
			<th>
				노출텍스트
			</th>
			<th colspan='2'>
				이미지
			</th>
			<th>
				정렬순서
			</th>
			<th>
				사용여부
			</th>
			<th>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$q = "SELECT * FROM shop_design_maindata WHERE main_idx='$idx' order by orders ASC";
		$st = $pdo->prepare($q);
		$st->execute();
		$cou = 1;
		while($row = $st->fetch())
		{
			$co = "";
			if(!($cou%2)) $co = "gray";

			$tmp_showsites = unserialize($row['showsites']);
		?>
		<tr  class='<?=$co;?>'>
			<td ><?=$cou;?></td>
			<td >
				<?
				for($i=0;$i<sizeof($page_ar_sites);$i++)	{
				?>
				<p><label><input type='checkbox' name='showsites<?=$cou;?>[]' value='<?=$page_ar_sites[$i]['idx'];?>' <? if(in_array($page_ar_sites[$i]['idx'],$tmp_showsites)) {?>checked<?}?>><?=$page_ar_sites[$i]['site_name'];?></label></p>
				<?}?>
			</td>
			<td align='left' >
				<p>링크</p>
				<p>
					<input type='hidden' name='data_idx<?=$cou;?>' value='<?=$row['idx'];?>'>
					<input type='text' class="form-control" name='links<?=$cou;?>' value='<? if($row['goods_idx']!=0){?>/shop/view.php?idx=<?=$row['goods_idx'];?>&mainview=Y<?}else{?><?=$row['links'];?><?}?>'></p>
				<p>HTML</p>
				<p><textarea name='maps<?=$cou;?>' class="form-control"><?=$row['maps'];?></textarea></p>
			</td>
			<td align='left' style="padding:5px;" >
				<p>노출텍스트</p>
				<p><input type='text' class="form-control" name='text_<?=$cou;?>' value='<? if($row['text']!=''){ echo $row['text']; }?>' size='30'></p>
				<p>노출텍스트2</p>
				<p><input type='text' class="form-control" name='text_<?=$cou;?>_2' value='<? if($row['text2']!=''){ echo $row['text2']; }?>' size='30'></p>
			</td>
			<td style="min-width:300px;" >
				<img style='max-width:300px;' src="<?=$_imgserver;?>/new_main/<?=$row['imgs'];?>">
				<br><br><input type='file' name='file<?=$cou;?>' style="display:inline;">
			</td>
			<td >
				<? if ( $row['imgs_sub'] ) { ?><img style='max-width:300px;' src="<?=$_imgserver;?>/new_main/<?=$row['imgs_sub'];?>"><? } ?>
				<br><br><input type='file' name='files<?=$cou;?>' style="display:inline;">
			</td>
			<td ><input type='text' class="form-control" name='orders<?=$cou;?>' value='<?=$row['orders'];?>' size='4'></td>
			<td >
				<select name='isuse<?=$cou;?>' class="form-control">
				<option value='Y' <? if($row['isuse']=='Y') { echo "selected";	}?>>노출함</option>
				<option value='N' <? if($row['isuse']=='N') { echo "selected";	}?>>노출안함</option>
				</select>
			</td>
			<td >
				<a href="javascript:delok('<?=$G_PHP_SELF;?>?code=<?=$code;?>&bidx=<?=$row['idx'];?>&idx=<?=$idx;?>&mode=d&pid=<?=$pid;?>','삭제?');" class="btn btn-xs btn-primary">삭제</a>

			</td>
		</tr>
		<?php
			$cou++;
		}
		?>
		</tbody>
	</table>
	<input type='hidden' name='cous' value='<?=$cou;?>'>
		<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
							<a href="#none" class="btn btn-primary btn_submits" data-form="#regiform">수정하기</a>
					</div>
				</div>

			</form>

			</div>
		</div>
	</div>
</div>
