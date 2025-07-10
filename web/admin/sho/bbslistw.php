<?
if($_REQUEST['mode']=='w')	{
	
	$req_boardid = $_REQUEST['boardid'];

	$memo = addslashes($_POST['memo']);

	
	

	
	$savedir = $_uppath."/board/";


	

	$userfile = array($_FILES['file1']['name'],$_FILES['file2']['name']);
	$tmpfile = array($_FILES['file1']['tmp_name'],$_FILES['file2']['tmp_name']);

	for($i=0;$i<2;$i++)
	{	$fileurl[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}


	$btype = $_POST['btype'];
	$cates = $_POST['cates'];
	$value[boardid] = $_POST['boardid'];
	$req_boardid = $_POST['boardid'];
	if($btype=='1')
	{	$value[btype] = "1";	}
	else if($btype=='2')
	{	$value[btype] = "2";	}
	else
	{	$value[btype] = "3";	}
	
              
	$value[subject] = $_POST['subject'];
	$value[subject_part] = $_POST['subject_part'];

	$value[memo] = addslashes($_REQUEST['memo']);

	$userev = $_REQUEST['userev'];
	if($userev=='Y')
	{
		$value[isdel] = "D";
		$st1 = $_REQUEST['st1'];
		$st2 = $_REQUEST['st2'];
	
		$value[revdate] = $_POST['swdate']." ".$st1.":".$st2.":00";
	}
	$value[wdate] = date("Y-m-d H:i:s",time());

	$value[nip] = $nip;
	$value[issecret] = $_POST['issecret'];
	$value[loca] = $_POST['loca'];
	$value[mdate] = date("Y-m-d H:i:s",time());
	$value[market_idx] = $_POST['market_idx'];
	$value[cates] = $_POST['cates'];
	$value[score] = $_POST['score'];
	$value[file1] = $fileurl[0];
	$value[file2] = $fileurl[1];
	$value[passwds] = $_POST['passwds'];
	$value['lan'] = $_REQUEST['lang'];
	$value['mem_name'] = $_REQUEST['mem_name'];
	$value["isview"]	= $_REQUEST["isview"];

	if( $value["boardid"] == "media" )	$value["cates"]	= $_POST["board_cates"];

	$r = insert("shop_board",$value);
	if(!$r)
	{

		echo "<Script>alert('게시물작성에 실패하였습니다.'); history.back(); </script>";
		exit;
	}


	

	echo "<Script>alert('게시물이작성되었습니다'); location.replace('$PHP_SELF?code=sho_bbslist'); </script>";
	exit;
}
?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('등록 하시겠습니까?');
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

function chk_board_kind()
{
	ff		= document.writeform;
	kind	= ff.boardid[ff.boardid.selectedIndex].value;

	if( kind == "media" )
	{
		$("#board_cate").css("display","block");
	}
	else
	{
		$("#board_cate").css("display","none");
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 게시글등록</h3>
			</div>
			<div class="panel-content">
<form name="writeform" id='writeform' action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
<input type='hidden' name='mode' value='w'>


				<table class="table table-bordered">
				<tbody>
<tR>
					<Th>언어</th>
					<td colspan='3'>
						<select name='lang' class="form-control" valch="yes" msg="언어를 선택하세요">
						<option value=''>언어선택</option>
<?php
$q = "SELECT * FROM shop_config_lang";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() ){
?>
						<option value='<?=$row['namecode'];?>'><?=$row['name'];?></option>
<?
}
?>
						</select>
					</td>
				</tR>
<tr>
	<th>작성게시판</th>
	<td>
		<select name='boardid' onClick="chk_board_kind();" style="float:left;">
		<option value=''>게시판선택</option>
		<?
		$q = "SELECT * FROM shop_board_conf";
		$st = $pdo->prepare($q);
		$st->execute();
		while($row = $st->fetch() ){
			echo "<option value='$row[board_id]'>$row[board_name]</option>";
		}
		?>
		</select>
		<div id="board_cate" style="padding-left:5px;float:left;display:none;">
			<select name="board_cates" style="width:120px;">
<?php
$q = "SELECT * FROM shop_board_cate order by orders";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch() ){
?>
				<option value='<?=$row['index_no'];?>'><?=$row['catename'];?></option>
<?
}
?>
			</select>
		</div>
	</td>
</tr>				
<tr>
	<th>제목</th>
	<td><input type='text' name='subject' class="form-control" valch="yes" msg="제목을 입력하세요"></td>
</tr>
<tr>
	<th>작성자</th>
	<td><input type='text' name='mem_name' class="form-control" valch="yes" msg="작성자명을 입력하세요"></td>
</tr>
<tr>

	<th>종류</th>
	<td>
	<select name="btype">
	<option value=''>종류선택</option>
	<option value='1'>공지글</option>
	<option value='2'>베스트글</option>
	<option value='3' selected>일반글</option>
	</select>
	</td>

</tr>
<tr>
	<th>노출유무</th>
	<td>
		<select name="isview">
			<option value="">노출</option>
			<option value="N">비노출</option>
		</select>
	</td>
</tr>
<tr>
					<td colspan='2'>
						<textarea cols="80" rows="10" name="memo" id="memo"></textarea>
					</td>
				</tr>

<tr>
	<th>첨부파일1</th>
	<td><input type='file' name='file1'></td>
</tr>
<tr>
	<th>첨부파일2</th>
	<td><input type='file' name='file2'></td>
</tr>
				</tbody>
				</table>
				
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#writeform">등록하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="/js/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.config.allowedContent = true;
CKEDITOR.replace( 'memo',{width:'100%',height:'500px',filebrowserImageUploadUrl: '/ckeditor_upload.php'} );
</script>