<?php
$mode = $_REQUEST['mode'];
if($mode=='w')
{
	$value[catename] = $_POST['catename'];
	$value[catetype] = $_POST['catetype'];
	insert("shop_goods_inout_cate",$value);

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($mode=='d')
{
	$index_no = $_REQUEST['index_no'];
	$q = "select * from shop_goods_inout where tbtype='$index_no'";
	$st = $pdo->prepare($q);
	$st->execute();
	$isit = $st->rowCount();

	if ($isit==0) {
		mysqli_query($connect,"delete from shop_goods_inout_cate where index_no='$index_no'");
	} else {
		echo "<Script>alert('입/출고에 사용된 항목이므로 삭제 불가'); history.back(); </script>";
		exit;
	}

	echo "<script>alert('처리완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
?>
<script>
function foch()
{
	if(!document.writeform.catename.value)
	{
		alert('항목명입력');
		document.writeform.catename.focus();
		return false;
	}
	if(document.writeform.catetype.options.value=='')
	{
		alert('분류선택');
		document.writeform.catetype.focus();
		return false;
	}
	return true;
}
function set_click(bh,idx,fi)
{

	var obj = $(bh);
	var vals = obj.val();
	if(!obj.is(':checked'))
	{	vals = "";	}

	var param = "mode=inoutcate&tb=goods_inout_cate&fi="+fi+"&idx="+idx+"&val="+vals;
		$.ajax({
		type:"GET",
		url:"/ajaxmo/set_gen.php",
		dataType: "html",
		data:param,
		success:function(msg){
			console.log(msg);
			if(msg=='ok')
			{	alert('변경완료');	}
		}
		});
}
</script>
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 설정목록</h3>
			</div>
			<div class="panel-content">


		<table class="table table-bordered">
		<colgroup>
			<col width="50px" />
			<col width="" />
			<col width="100px" />
		</colgroup>
		<thead>
		<tr>
		<th>NO</th>
		<th>항목명</th>
		<th>구분</th>
		<th>회계반영</th>
		<th></th>
		<th></th>
		</tr>
		</thead>
		<?php
		$q = "select * from shop_goods_inout_cate";
		$st = $pdo->prepare($q);
		$st->execute();
		$cou = 1;
		while($row = $st->fetch())
		{

		?>
		<tbody>
		<tr>
		<td class="first"><?=$cou;?></td>
		<td><?=$row[catename];?></td>
		<Td><? if($row[catetype]=='I') { echo "입고";	} else { echo "출고";	}?></td>
		<td><input type='checkbox' name='useh' value='Y' <? if($row[useh]=='Y') { echo "checked";	}?> onclick="set_click(this,'<?=$row[index_no];?>','useh');">회계반영</td>
		<td>
		<?if($row[catetype]=='I'){?><input type='checkbox' name='isshopr' value='C' <? if($row[isshopr]=='C') { echo "checked";	}?> onclick="set_click(this,'<?=$row[index_no];?>','isshopr');">고객반품입고용<?}?>
		<?if($row[catetype]=='O'){?><input type='checkbox' name='isshopr' value='Y' <? if($row[useh]=='Y') { echo "checked";	}?> onclick="set_click(this,'<?=$row[index_no];?>','isshopr');">거래처반품용<?}?>
		</td>
		<Td>
			<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=d&index_no=<?=$row[index_no];?>','삭제?');" class="btn btn-xs btn-primary">삭제</a>

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
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록하기</h3>
			</div>
			<div class="panel-content">
	
		<form id="regiform2" name="regiform2" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
		<input type='hidden' name='mode' value='w'>
		<table class="table table-bordered">
		<tr>
		<th>입출고항목명</th>
		<td colspan='3'><input type='text' name='catename' size='30' class='form-control'></td>
		</tr>
		<Tr>
		<th>구분</th>
		<td colspan='3'><select class="uch" name='catetype'><option value=''>선택</option><option value='I'>입고</option><option value='O'>출고</option></select>
		</tr>
		</table>

		<div class="form-group row">
			<div class="col-sm-8 col-sm-offset-4">
				<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform2">등록하기</button>
						
			</div>
		</div>
		
		</form><!-- // .form[name="regiform2"] -->
			</div>
		</div>
	</div>
</div>