<?php
$mode = $_REQUEST['mode'];
$fid = $_REQUEST['fid'];
if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}
if($mode=='w')
{
	$ar_qna_c = sel_query_all("shop_qna_config"," where fid='$fid'");

	if($ar_qna_c[usefile]=='Y')
	{

		$userfile = array($_FILES['file1']['name'],$_FILES['file2']['name'],$_FILES['file3']['name'],$_FILES['file4']['name'],$_FILES['file5']['name'],$_FILES['file6']['name'],$_FILES['file7']['name'],$_FILES['file8']['name']);
		$tmpfile = array($_FILES['file1']['tmp_name'],$_FILES['file2']['tmp_name'],$_FILES['file3']['tmp_name'],$_FILES['file4']['tmp_name'],$_FILES['file5']['tmp_name'],$_FILES['file6']['tmp_name'],$_FILES['file7']['tmp_name'],$_FILES['file8']['tmp_name']);

		$savedir = $_uppath."icon/";

		if(!is_dir($savedir))
		{	@mkdir($savedir, 0777);	chmod($savedir,0707);   }

		$ar_del = array("N","N",$_POST['del3'],$_POST['del4'],$_POST['del5'],$_POST['del6'],$_POST['del7'],$_POST['del8']);
		$ar_last = array($ar_qna_c[newicon_file],$ar_qna_c[secfile],$ar_qna_c[qnaicon3],$ar_qna_c[qnaicon2],$ar_qna_c[qnaicon1],$ar_qna_c[mqnaicon3],$ar_qna_c[mqnaicon2],$ar_qna_c[mqnaicon1]);


		for($i=0;$i<sizeof($userfile);$i++)
		{	$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);	}
		
		$value[qnaicon3] = $fs[2];
		$value[qnaicon2] = $fs[3];
		$value[qnaicon1] = $fs[4];
		$value[mqnaicon3] = $fs[5];
		$value[mqnaicon2] = $fs[6];
		$value[mqnaicon1] = $fs[7];
	}
	else
	{
		$userfile = array($_FILES['file1']['name'],$_FILES['file2']['name']);
		$tmpfile = array($_FILES['file1']['tmp_name'],$_FILES['file2']['tmp_name']);

		$savedir = $_uppath."icon/";

		if(!is_dir($savedir))
		{	@mkdir($savedir, 0777);	chmod($savedir,0707);   }

		$ar_del = array("N","N");
		$ar_last = array($ar_qna_c[file1],$ar_qna_c[file2]);


		for($i=0;$i<sizeof($userfile);$i++)
		{	$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);	}

		$value[qnaicon1] = $_POST['qnaicon1'];
		$value[qnaicon2] = $_POST['qnaicon2'];
		$value[qnaicon3] = $_POST['qnaicon3'];
		$value[mqnaicon1] = $_POST['mqnaicon1'];
		$value[mqnaicon2] = $_POST['mqnaicon2'];
		$value[mqnaicon3] = $_POST['mqnaicon3'];
	}

	$value[fid] = $fid;
	$value[qnawg] = $_POST['qnawg'];
	$value[issecret] = $_POST['issecret'];
	$value[newicon_file] = $fs[0];
	$value[secfile] = $fs[1];
	$value[newicon_day] = $_POST['newicon_day'];
	$value[listnum] = $_POST['listnum'];
	$value[qna_uselms] = $_POST['qna_uselms'];
	$value[qna_usesms] = $_POST['qna_usesms'];
	$value[qna_url] = $_POST['qna_url'];
	
	$value[usewriter] = $_POST['usewriter'];
	$value[usewriter_cou] = $_POST['usewriter_cou'];
	if($ar_qna_c)
	{	update("shop_qna_config",$value," where fid='$fid'");	}
	else
	{	insert("shop_qna_config",$value);	}

	echo "<script>alert('변경완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
	
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">
				<form name="searchform" id="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">


				<table class="table table-bordered">
				<colgroup>
					<col width="15%" />
					<col width="35%" />
					<col width="15%" />
					<col width="35%" />
				</colgroup>
				<tbody>
				<tr>
					<th>판매처그룹</th>
					<td colspan='3'>
						<select class="uch" name="fid" style="width:240px">
							<option value=''>적용사이트선택</option>
							<?php
							$q = "select * from shop_sites";
							$st = $pdo->prepare($q);
							$st->execute();
							while($row = $st->fetch())
							{
								if(in_array($row[index_no],$ar_mempriv))
								{
									if($row[index_no]==$fid)
									{	echo "<option value='$row[index_no]' selected >$row[sitename]</option>";	}
									else
									{	echo "<option value='$row[index_no]'>$row[sitename]</option>";	}
								}
							}
							?>
						</select>
					</td>
				</tr>
				
				</tbody>
				</table>
				
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>



<?php
if($fid)
{
	$ar_qna_c = sel_query_all("shop_qna_config"," where fid='$fid'");
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 설정</h3>
			</div>
			<div class="panel-content">

				<form id="writeform" name="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
				<input type='hidden' name='fid' value='<?=$fid;?>'>
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%" />
					<col width="35%" />
					<col width="15%" />
					<col width="35%" />
				</colgroup>
					<tr>
						<Th>작성자범위</th>
						<td colspan='3'>
							<select name='qnawg'>
								<option value='1' <? if($ar_qna_c[qnawg]=='1') { echo "selected";	}?>>회원/비회원모두작성가능</option>
								<option value='2' <? if($ar_qna_c[qnawg]=='2') { echo "selected";	}?>>회원만작성가능</option>
							</select>
						</td>
					</tr>
					<tr>
						<Th>비밀글여부</th>
						<td colspan='3'><input type='checkbox' name='issecret' value='Y' <? if($ar_qna_c[issecret]=='Y') { echo "checked";	}?>> 무조건 비밀글로 작성</td>
					</tr>
					<tr>
						<Th>목록글수</th>
						<td colspan='3'><input type='text' name='listnum' value='<?=$ar_qna_c[listnum];?>' class='form-control'></td>
					</tr>
					<tr>
						<Th>NEW아이콘노출</th>
						<td colspan='3'>
							<div class="form-inline">
							작성후 <input type='text' name='newicon_day' value='<?=$ar_qna_c[newicon_day];?>' class='form-control'> 일 노출
							</div>
						</td>
					</tr>
					<tr>
						<Th>NEW아이콘파일</th>
						<td colspan='3'><input type='file' name='file1'>
						<? if($ar_qna_c[newicon_file]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[newicon_file];?>"><?}?>
						</td>
					</tr>

					<tr>
						<Th>작성자</th>
						<td colspan='3'>
							<div class="form-inline">
								<select name='usewriter'>
									<option value='mem_id' <? if($ar_qna_c[usewriter]=='mem_id') { echo "selected";	}?>>아이디</option>
									<option value='mem_name' <? if($ar_qna_c[usewriter]=='mem_name') { echo "selected";	}?>>성명</option>
									<option value='mem_nick' <? if($ar_qna_c[usewriter]=='mem_nick') { echo "selected";	}?>>닉네임</option>
								</select> 
								<input type='text' name='usewriter_cou' size='4' value='<?=$ar_qna_c[usewriter_cou];?>' class="form-control">바이트 까지만 노출
							</div>
						</td>
					</tr>

					<tr>
						<Th>비밀글아이콘파일</th>
						<td colspan='3'><input type='file' name='file2'><? if($ar_qna_c[secfile]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[secfile];?>"><?}?></td>
					</tr>

					<tr>
						<Th>답변시SMS사용</th>
						<td colspan='3'><input type='checkbox' name='qna_usesms' value='Y' <? if($ar_qna_c[qna_usesms]=='Y') { echo "checked";	} ?>>사용</td>
					</tr>
					<tr>
						<Th>답변시LSM사용</th>
						<td colspan='3'><input type='radio' name='qna_uselms' value='1' <? if($ar_qna_c[qna_uselms]=='1') { echo "checked";	} ?>>주소전송  <input type='radio' name='qna_uselms' value='2' <? if($ar_qna_c[qna_uselms]=='1') { echo "checked";	} ?>>답변내용전송  <input type='radio' name='qna_uselms' value='' <? if($ar_qna_c[qna_uselms]=='') { echo "checked";	} ?>>사용안함</td>
					</tr>
					<tr>
						<Th>답변시SMS사용URL</th>
						<td colspan='3'><input type='text' name='qna_url' value='<?=$ar_qna_c[qna_url];?>' class='form-control' style='width:600px;'></td>
					</tr>


				<?
				if($ar_qna_c[usefile]=='Y')
				{
				?>
					<tr>
						<Th>답변대기결과노출[PC]</th>
						<td colspan='3'><input type='file' name='file3'> <? if($ar_qna_c[qnaicon3]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[qnaicon3];?>"> <label><input type='checkbox' name='del3' value='Y'>삭제</label><?}?></td>
					</tr>
					<tr>
						<Th>답변중결과노출[PC]</th>
						<td colspan='3'><input type='file' name='file4'> <? if($ar_qna_c[qnaicon2]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[qnaicon2];?>"> <label><input type='checkbox' name='del4' value='Y'>삭제</label><?}?></td>
					</tr>
					<tr>
						<Th>답변완료결과노출[PC]</th>
						<td colspan='3'><input type='file' name='file5'> <? if($ar_qna_c[qnaicon1]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[qnaicon1];?>" align="absmiddle"> <label><input type='checkbox' name='del5' value='Y'>삭제</label><?}?></td>
					</tr>

					<tr>
						<Th>답변대기결과노출[MO]</th>
						<td colspan='3'><input type='file' name='file6'> <? if($ar_qna_c[mqnaicon3]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[mqnaicon3];?>"> <label><input type='checkbox' name='del6' value='Y'>삭제</label><?}?></td>
					</tr>
					<tr>
						<Th>답변중결과노출[MO]</th>
						<td colspan='3'><input type='file' name='file7'> <? if($ar_qna_c[mqnaicon2]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[mqnaicon2];?>"> <label><input type='checkbox' name='del7' value='Y'>삭제</label><?}?></td>
					</tr>
					<tr>
						<Th>답변완료결과노출[MO]</th>
						<td colspan='3'><input type='file' name='file8'> <? if($ar_qna_c[mqnaicon1]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_qna_c[mqnaicon1];?>">  <label><input type='checkbox' name='del8' value='Y'>삭제</label><?}?></td>
					</tr>
				<?}else{?>
					<tr>
						<Th>답변대기결과노출[PC]</th>
						<td colspan='3'><input type='text' name='qnaicon3' value="<?=$ar_qna_c[qnaicon3];?>" class='form-control' style='width:600px;'></td>
					</tr>
					<tr>
						<Th>답변중결과노출[PC]</th>
						<td colspan='3'><input type='text' name='qnaicon2' value="<?=$ar_qna_c[qnaicon2];?>" class='form-control' style='width:600px;'></td>
					</tr>
					<tr>
						<Th>답변완료결과노출[PC]</th>
						<td colspan='3'><input type='text' name='qnaicon1' value="<?=$ar_qna_c[qnaicon1];?>" class='form-control' style='width:600px;'></td>
					</tr>

					<tr>
						<Th>답변대기결과노출[MO]</th>
						<td colspan='3'><input type='text' name='mqnaicon3' value="<?=$ar_qna_c[mqnaicon3];?>" class='form-control' style='width:600px;'></td>
					</tr>
					<tr>
						<Th>답변중결과노출[MO]</th>
						<td colspan='3'><input type='text' name='mqnaicon2' value="<?=$ar_qna_c[mqnaicon2];?>" class='form-control' style='width:600px;'></td>
					</tr>
					<tr>
						<Th>답변완료결과노출[MO]</th>
						<td colspan='3'><input type='text' name='mqnaicon1' value="<?=$ar_qna_c[mqnaicon1];?>" class='form-control' style='width:600px;'></td>
					</tr>
				<?}?>

				</table>


				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#writeform">저장하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
