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
	$value[subject] = $_POST['subject'];
	$value[memo] = $_POST['memo'];
	$value[fid] = $_POST['fid'];
	insert("shop_sms_templete",$value);

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
}
if($mode=='d')
{
	$index_no = $_REQUEST['index_no'];
	$q = "delete from shop_sms_templete where index_no='$index_no'";
	$st = $pdo->prepare($q);
	$st->execute();

	echo "<script>alert('삭제완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
}
?>
<script>
function foch()
{
	if(!document.writeform.subject.value)
	{
		alert('제목입력');
		document.writeform.subject.focus();
		return false;
	}
	if(!document.writeform.memo.value)
	{
		alert('내용입력');
		document.writeform.memo.focus();
		return false;
	}
	return true;
}
</script>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 템플릿등록</h3>
			</div>
			<div class="panel-content">

				<form id="writeform" name="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return foch();">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='fid' value='<?=$fid;?>'>

				<table class="table table-bordered">
					<tr>
						<th scope="row">제목</th>
						<Td><input type='text' name='subject' class='form-control'></td>
					</tr>
					<tr>
						<th scope="row">내용</th>
						<Td><textarea name='memo' style='width:500px;height:200px;' class='form-control'></textarea><br>[NAME] 입력시 주문자이름으로 치환됨 <br /></td>
					</tr>
				</table>

				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<a href="#none" class="btn btn-primary" onclick="$('#writeform').submit()">저장하기</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록된 템플릿</h3>
			</div>
			<div class="panel-content">


				<table class="table table-bordered">
					<colgroup>
						<col width="50px" />
						<col width="100px" />
						<col width="" />
						<col width="60px" />
					</colgroup>
					<thead>
					<tr>
						<Th>NO</th>
						<Th>적용사이트</th>
						<th>제목/내용</th>
						<th></th>
					</tr>
					<?php
					$q = "select * from shop_sms_templete";
					$q = $q . " order by index_no asc";
					$st = $pdo->prepare($q);
					$st->execute();
					$cou = 1;
					while($row = $st->fetch())
					{
					$co = "";
					if(!($cou%2)) $co = "gray";
					?>
					<tbody>
					<Tr class='<?=$co;?>'>
						<Td class="first"><?=$cou;?></td>
						<td><?=$ar_sname[$row[fid]];?></td>
						<td style='text-align:left;padding:5px;'><?=$row[subject];?><br /><?=nl2br($row[memo]);?></td>
						<td>
							<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&index_no=<?=$row[index_no];?>&mode=d&fid=<?=$fid;?>','삭제?');" class="btn btn-xs btn-primary">삭제</a>
						</td>
					</tr>
					</tbody>
					<?php
						$cou++;
					}
					?>
				</table>


			</div>
		</div>
	</div>
</div>