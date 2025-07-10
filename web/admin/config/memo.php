<?php
$pid = $_REQUEST['pid'];
$lang = $_REQUEST['lang'];
$mtype = $_REQUEST['mtype'];
$ar_data = sel_query_all("shop_config_memo"," WHERE pid='$pid' and lang='$lang' and mtype='$mtype'");


$mode = $_REQUEST['mode'];
if($mode=='w')	{
	foreach($_REQUEST AS $key => $val)	{
		
		if(!is_array($_REQUEST[$key]))	{

			$_REQUEST[$key] = addslashes(trim($val));
		}
	}
	
	$value['memo'] = $_REQUEST['memo'];
	if($ar_data['index_no'])	{
		
		update("shop_config_memo",$value," WHERE index_no='$ar_data[index_no]'");
	}
	else	{
		$value['pid'] = $pid;
		$value['lang'] = $lang;
		$value['mtype'] = $mtype;

		insert("shop_config_memo",$value);
		
	}

	show_message("수정완료","");
	echo "<script>window.close(); </script>";
	exit;

}
?>
<form name="wform" id="wform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='pid' value='<?=$pid;?>'>
<input type='hidden' name='lang' value='<?=$lang;?>'>
<input type='hidden' name='mtype' value='<?=$mtype;?>'>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> <? if($mtype=='1') { echo "이용약관수정";	} ?><? if($mtype=='2') { echo "개인정보취급방첨";	} ?><? if($mtype=='3') { echo "사업자정보";	} ?><? if($mtype=='4') { echo "CS안내";	} ?></h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				
				<tbody>
				<tr>
					<td><textarea name="memo" id="memo"><?=$ar_data['memo'];?></textarea></td>
					
				</tr>

				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
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
<script src="/js/ckeditor4/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'memo', {
			extraPlugins: 'image2,uploadimage',
			allowedContent:true,


			
			filebrowserUploadUrl: '/ckeditor_upload.php',
			
			// Reduce the list of block elements listed in the Format drop-down to the most commonly used.
			// Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
			removeDialogTabs: 'image:advanced;link:advanced',
			width:'100%',
			height:600
		} );
</script>