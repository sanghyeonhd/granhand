<?
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_faq"," WHERE index_no='$index_no'");
if($_REQUEST['mode']=='w')	{
	
	$value["fid"]	= $g_ar_pid[0]["fid"];
	$value['cate_idx'] = $_REQUEST['cate_idx'];
	if($value['cate_idx']=='A')	{
		
		$values['catename'] = $_REQUEST['catename'];
		insert("shop_faqcate",$values);
		$cate_idx = $pdo->lastInsertId();

		$value['cate_idx'] = $cate_idx;

	}
	$value[subject] = $_REQUEST['subject'];
	$value[memo] = addslashes($_REQUEST['memo']);
	$value['lang'] = $_REQUEST['lang'];
	$value[wdate] = date("Y-m-d H:i:s");
	insert("shop_faq",$value);
	unset($value);

	show_message("등록완료",'');
	move_link("$PHP_SELF?code=$code");
	exit;
}
if($_REQUEST['mode']=='m')	{

	$value["fid"]	= $g_ar_pid[0]["fid"];
	$value['cate_idx'] = $_REQUEST['cate_idx'];
	if($value['cate_idx']=='A')	{
		
		$values['catename'] = $_REQUEST['catename'];
		insert("shop_faqcate",$values);
		$cate_idx = $pdo->lastInsertId();

		$value['cate_idx'] = $cate_idx;

	}
	$value[subject] = $_REQUEST['subject'];
	$value[memo] = $_REQUEST['memo'];
	$value['lang'] = $_REQUEST['lang'];
	update("shop_faq",$value," WHERE index_no='$index_no'");
	unset($value);

	show_message("수정완료",'');
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;
}
?>
<script>
function gotoch(f)	{

	var isok = check_form(f);

	


	if(isok)	{
		


		answer = confirm('저장하시겠습니까?');
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
function set_catein()	{
	
	if($("#cate_idx option:selected").val()=='A')	{

		$("#catein").show();
	}
	else	{
		$("#catein").hide();
	}

}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> FAQ</h3>
			</div>
			<div class="panel-content">
				
				<form name="wform" id='wform' action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return gotoch(this);">
				
				<input type='hidden' name='mode' value='<? if($index_no) { echo "m";	} else { echo "w";	}?>'>
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>

				<table class="table table-bordered">
				<colgroup>
					<col width="150px;">
					<col width="*">

				</colgroup>
				<tbody>
				<tr>
					<th>언어</th>
					<Td>
						<Select name="lang" valch="yes" msg="언어를 선택하세요">
						<option value=''>선택</option>
						<?
						$q = "SELECT * FROM shop_config_lang ORDER BY index_no ASC";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$se = "";
							if($row['namecode']==$ar_data['lang'])	{
								$se = "selected";
							}
							echo "<option value='$row[namecode]' $se>$row[name]</option>";
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>FAQ 분류</th>
					<Td>
						<div class="form-inline">
						<Select name="cate_idx" id="cate_idx" valch="yes" msg="FAQ 분류를 선택하세요" onchange="set_catein();">
						<option value=''>select</option>
						<option value='A'>Input Directly</option>
						<?
						$q = "SELECT * FROM shop_faqcate";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							$se = "";
							if($ar_data['cate_idx']==$row['index_no'])	{
								$se = "selected";
							}
							echo "<option value='$row[index_no]' $se>$row[catename]</option>";
						}
						?>
						</select>
						<div style="display:none;" id="catein">		
						분류직접입력 : <input type='text' name='catename' class="form-control">
						</div>
						</div>
					</td>
				</tr>
				<tr>	
					<th>제목</th>
					<Td><input type='text' name='subject' class="form-control" valch="yes" msg="제목을 입력하세요" <? if($ar_data[index_no]) { echo "value='$ar_data[subject]'";	}?>></td>
				</tr>
				<tr>
					<th>내용</th>
					<Td><textarea name="memo" class="cke-editor"><?=$ar_data['memo'];?></textarea></td>
				</tr>
				
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#wform"><? if($index_no) { echo "수정하기";} else { echo "등록하기"; }?></button>
					</div>
				</div>
				</form>	

			</div>
		</div>
		<!-- end panel -->
	</div>
	<!-- end col-12 -->
</div>
<script src="/assets/global/plugins/cke-editor/ckeditor.js"></script> <!-- Advanced HTML Editor -->
<script src="/assets/global/plugins/cke-editor/adapters/adapters.min.js"></script>