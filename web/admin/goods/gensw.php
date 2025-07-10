<?
$mode = $_REQUEST['mode'];
if($mode=='w')
{


	$savedir = "$_uppath/useinfo/";

	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);

	$savedir = $_uppath."useinfo/";
	
	
	if(!is_dir($savedir))	{	
		mkdir($savedir, 0777);	chmod($savedir,0707);  
	}



	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}

	
	$value['fid'] = $_POST['fid'];
	$value['stype'] = $_POST['stype'];
	$value['subject'] = $_POST['subject'];
	$value['sdate'] = $_POST['sdate'];
	$value['edate'] = $_POST['edate'];
	$value['loca'] = $_REQUEST['loca'];
	$value['viewtype'] = $_REQUEST['viewtype'];
	$value['wdate'] = date("Y-m-d H:i:s",time());
	$value['files'] = $fs[0];
	$value['links'] = $_REQUEST['links'];
	$value['memo'] = $_REQUEST['memo'];
	
	$value['scates'] = $_REQUEST['scates'];
	$value['sgoods'] = $_REQUEST['sgoods'];


	insert("shop_genmemo",$value);
	unset($value);

	

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('등록 하시겠습니까?');
		if(answer==true)	{
			
			if($("#stype option:selected").val()=='2')	{

				var catestr = '';
				$("#showcates > span").each(function()	{
			
					catestr = catestr + $(this).attr("dataattr") + '|R|';
		
				});
				$("#scates").val(catestr);
			}

			if($("#stype option:selected").val()=='3')	{

				var catestr = '';
				$("#showgoods > span").each(function()	{
			
					catestr = catestr + $(this).attr("dataattr") + '|R|';
		
				});
				$("#sgoods").val(catestr);
			}

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
function set_sif()	{
	if($("#stype option:selected").val()=='1')	{
		$("#str2").hide();
		$("#str3").hide();
	}
	if($("#stype option:selected").val()=='2')	{
		$("#str2").show();
		$("#str3").hide();
	}
	if($("#stype option:selected").val()=='3')	{
		$("#str3").show();
		$("#str2").hide();
	}
}

function search_cate()	{
	var text = '';
	var val = '';
	var thishtml = '';
	var isok = "Y";

	if($("#se_cates option:selected").val()!='')	{
		
		val = $("#se_cates option:selected").val();
		text = $("#se_cates option:selected").text();
		
		
		$("#search_menu > span").each(function()	{

			if($(this).attr("dataattr")==val)	{
				isok = "N";
			}
		});
		
		if(isok=='Y')	{
			
			thishtml = "<span dataattr='"+val+"' style='margin:0 10px 5px 0;background-color:#DFDFDF;padding:5px;display:inline-block;' onclick='set_objdel(this)'>"+text+" <a href='#none' style='color:red'>X</a></span>";
			$("#showcates").append(thishtml);
		}
	}
}
function set_objdel(obj)	{
	$(obj).remove();
}
function set_viewtype()	{
	if($("#viewtype option:selected").val()=='1')	{
		$("#viewtype_1").show();
		$("#viewtype_2").hide();
	}
	if($("#viewtype option:selected").val()=='2')	{
		$("#viewtype_2").show();
		$("#viewtype_1").hide();
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 공통정보목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
<form name="writeform" id="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regich(this);">
<input type='hidden' name='mode' value='w'>
<input type='hidden' name='scates' id='scates' value=''>
<input type='hidden' name='sgoods' id='sgoods' value=''>
<tr>
	<th>사용처</th>
	<td colspan='3'>
	<select class="uch" name='fid' id='fid' valch="yes" msg="판매처 선택">
	<option value=''>판매처선택</option>
<?php
$q = "select * from shop_sites";
$st = $pdo->prepare($q);
$st->execute();	
while($row = $st->fetch())
{
	if(in_array($row['idx'],$ar_mempriv))
	{	
		if($fid==$row['idx'])
		{	echo "<option value='$row[idx]' selected>$row[sitename]</option>";		}
		else
		{	echo "<option value='$row[idx]'>$row[sitename]</option>";		}
	}
}
?>
</select>

	
	</td>
</tr>
<tr>
	<th>노출방식 </th>
	<td colspan='3'><select name='stype' id="stype" onchange="set_sif();">
	<option value='1'>전체상품노출</option>
	<option value='2'>카테고리</option>
	<option value='3'>특정상품</option>
	</select></td>
</tr>
<tr id='str2' style="display:none;">
	<th>노출카테고리</th>
	<td colspan='3'>
		<p>
			<select class="uch" id='se_cates' onchange="search_cate();">
			<option value=''>카테고리전체</option>
						<?php
						$q = "select * from shop_cate order by catecode";	
						$st = $pdo->prepare($q);
						$st->execute();	
						while($row = $st->fetch())	{
							$catecode_len = strlen($row['catecode']);
							if($catecode_len==2)	{
								$first=$row['catename'];
								echo "<option value='$row[catecode]' $se>$row[catename]</option>";
								$ar_searchcate[$row['catecode']] = $row['catename'];
							}
							else if($catecode_len==4)	{
								$second=$row['catename'];
								echo "<option value='$row[catecode]' $se>$first > $row[catename]</option>";
								$ar_searchcate[$row['catecode']] = "$first > $row[catename]";
							}
							else if($catecode_len==6)	{
								echo "<option value='$row[catecode]' $se>$first > $second > $row[catename]</option>";	
								$ar_searchcate[$row['catecode']] = "$first > $second > $row[catename]";
							}
						}
						?>
			</select>
		</p>
		<div id="showcates">

		</div>
	</td>
</tr>
<tr id='str3' style="display:none;">
	<th>노출상품</th>
	<td colspan='3'>
		<a href="#none" class="btn btn-sm btn-inverse" onclick="MM_openBrWindow('popup?code=goods_search&main_idx=&hanmode=gengoods','goods_main','width=1100,height=800,top=0,left=0,scrollbars=yes');"><i class="fa fa-plus m-r-5"></i>상품추가</a>
		<div id="showgoods">

		</div>
	</td>
</tr>
<tr>
	<th>노출위치</th>
	<td colspan='3'><select name='loca'>
	<option value='1'>상세상단</option>
	<option value='2'>상세하단</option>
	</select></td>
</tr>

<tr>
	<th>노출기간</th>
	<td colspan='3'>
		<div class="form-inline">
		<input type='text' name='sdate' id="sdate" class="form-control" readonly valch="yes" msg="노출 기간"> ~ <input type='text' name='edate' id="edate" class="form-control" readonly valch="yes" msg="노출 기간">
		</div>
	</td>
</tr>
<tr>
	<th>노출정보제목</th>
	<td colspan='3'><input type='text' name='subject' class="form-control" valch="yes" msg="노출 제목"></td>
</tr>
<tr>
	<th>작성형태</th>
	<td colspan='3'><select name='viewtype' id="viewtype" onchange="set_viewtype();">
	<option value='1'>이미지로노출</option>
	<option value='2'>에티터로편집</option>
	</select></td>
</tr>

<tr id="viewtype_1">
	<th>노출이미지</th>
	<td><input type='file' name='file'></td>
	<th>이미지링크</th>
	<td><input type='text' name='links' class="form-control"></td>
</tr>
<tr id="viewtype_2" style="display:none;">
	<th>내용</th>
	<td colspan='3'>
		<textarea cols="80" rows="10" name="memo" class="cke-editor"></textarea>
	</td>
</tr>
</table>

				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#writeform">등록하기</button>
						
					</div>
				</div>
</form><!-- // form[name="regiform"] -->	
			</div>
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#sdate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edate').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>
<script src="/assets/global/plugins/cke-editor/ckeditor.js"></script> <!-- Advanced HTML Editor -->
<script src="/assets/global/plugins/cke-editor/adapters/adapters.min.js"></script>