<?php
$mode = $_REQUEST['mode'];
$fid = $_REQUEST['fid'];
if($mode=='w')	{
	$value[width] = $_POST['width'];
	$value[height] = $_POST['height'];
	$value[lefts] = $_POST['lefts'];
	$value[top] = $_POST['top'];
	$value[links] = $_POST['links'];
	$value[imgmap] = $_POST['imgmap'];
	$value[title] = $_POST['title'];
	$value[pid] = $_POST['pid'];
	$value['videourl'] = $_POST['videourl'];
	$value[wdate] = date("Y-m-d H:i:s",time());
	$value[sdate] = $_POST['sdate']." ".$_POST['shour'];
	$value[edate] = $_POST['edate']." ".$_POST['ehour'];
	$value[ismove] = $_POST['ismove'];

	$userfile = array($_FILES['img']['name']);
	$tmpfile = array($_FILES['img']['tmp_name']);

	$savedir = $_uppath."popup/";
	
	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	}


	$value[file] = $fs[0];

	insert("shop_popup",$value);

	echo "<Script>alert('설정완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
}
if($mode=='d')	{
	$index_no = $_REQUEST['index_no'];
	$ar_pop = sel_query_all("shop_popup"," where index_no='$index_no'");
	$savedir = $_uppath."popup/";
	@unlink($savedir.$ar_pop[img]);

	mysqli_query($connect,"delete from shop_popup where index_no='$index_no'");

	echo "<Script>alert('삭제완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
?>
<script>
function gotoch()	{
	if($("#id_pid option:selected").val()=='')	{
		alert('해당하는 사이트를 선택하세요');
		return false;
	}
	answer = confirm('팝업을 등록하시겠습니까?');
	if(answer==true)	{
		return true;	
	}
	else	{
		return false;	
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 검색</h3>
			</div>
			<div class="panel-content">

				<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" enctype="multipart/form-data" onsubmit="return gotoch();">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='fid' value='<?=$fid;?>'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tr>
					<th>해당사이트</th>
					<td colspan='3'>
						<select class="uch" name='pid' id="id_pid">
						<option value=''>사이트선택</option>
						<?php
						$q = "select * from shop_config where site_mobile!='O'";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
						?>
						<option value='<?=$row[index_no];?>'><?=$row[site_name];?></option>
						<?php
						}
						?>
						</selecT>
					</td>
				</tr>
				<tr>
					<th>팝업드래그</th>
					<td colspan='3'><input type='checkbox' name='ismove' value='Y'> 드래그 가능</td>
				</tr>
				<tr>
					<th>시작날짜</th>
					<td><input type='text' class="form-control" name='sdate' size='10' id='sdates' value="<?=$ar_sdate[0];?>" readonly></td>
					<th>시작시간</th>
					<td><input type='text' class="form-control" name='shour' size='10' id='shour' value="<?=$ar_sdate[1];?>" readonly></td>
				</tr>
				<tr>
					<th>종료날짜</th>
					<td><input type='text' class="form-control" name='edate' size='10' id='edates' value="<?=$ar_edate[0];?>" readonly></td>
					<th>종료시간</th>
					<td><input type='text' class="form-control" name='ehour' size='10' id='ehour' value="<?=$ar_edate[1];?>" readonly></td>
				</tr>
				<tr>
					<th>팝업이미지</th>
					<td colspan='3'><input type='file' name='img'></td>
				</tr>
				<tr>
					<th>영상URL</th>
					<td colspan='3'><input type='text' class="form-control" size='40' name='videourl'></td>
				</tr>
				<tr>
					<th>팝업타이틀</th>
					<td colspan='3'><input type='text' class="form-control" size='40' name='title'></td>
				</tr>
				<tr>
					<th>팝업가로</th>
					<td><input type='text' class="form-control" size='10' name='width'></td>
					<th>팝업세로</th>
					<td><input type='text' class="form-control" size='10' name='height'></td>
				</tr>
				<tr>
					<th>상단좌표</th>
					<td><input type='text' class="form-control" size='10' name='top'></td>
					<th>왼쪽좌표</th>
					<td><input type='text' class="form-control" size='10' name='lefts'></td>
				</tr>
				<tr>
					<th>링크</th>
					<td colspan='3'><input type='text' class="form-control" size='60' name='links'><br>(팝업창에 링크 사용 할때만 입력)</td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#sdates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});

	$('#shour').timepicker({
		timeFormat : 'HH:mm:ss'
	});
	$('#ehour').timepicker({
		timeFormat : 'HH:mm:ss'
	});
});

</script>