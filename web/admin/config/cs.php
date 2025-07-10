<?php
$mode = $_REQUEST['mode'];
if($mode=='w')
{
	$value[up_idx] = $_POST['up_idx'];
	$value[catename] = trim($_POST['catename']);
	insert("shop_config_omemo",$value);

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($mode=='ch'){
    
	$index_no = $_REQUEST['index_no'];
	$ar_data = sel_query_all("shop_config_omemo"," WHERE index_no='$index_no'");

	if($ar_data['isuse']=='Y'){
         $value['isuse'] = "N";
	}
	else {
         $value['isuse'] = "Y";
	}

	update("shop_config_omemo",$value," where index_no='$index_no'");

	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code'); </script>";
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
	return true;
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
			<col width="" />
			<col width="80px" />
		</colgroup>
		<thead>
		<Tr>
		<th>번호</th>
		<th>구분</th>
		<th>사용여부</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$cou = 1;
		$q = "select * from shop_config_omemo where up_idx='0' order by catename asc";
		$st = $pdo->prepare($q);
		$st->execute();
		$cou = 1;
		while($row = $st->fetch())
		{
			$co = "";
			if(!($cou%2)) $co = "gray";
		?>
		
		<tr class='<?=$co;?>'>
		<td class="first"><?=$cou;?></td>
		<td style='text-align:left;padding-left:5px;'><?=$row[catename];?></td>
		<td><a href="<?=$PHP_SELF;?>?code=<?=$code;?>&mode=ch&index_no=<?=$row[index_no];?>"><?=$row[isuse];?></a></td>
		
		</tr>
		<?
			$cou++;
			$q2 = "select * from shop_config_omemo where up_idx='$row[index_no]' order by catename asc";
			$st2 = $pdo->prepare($q2);
			$st2->execute();
			while($row2 = $st2->fetch())
			{
				$co = "";
				if(!($cou%2)) $co = "gray";
		?>
		<tr class='<?=$co;?>'>
		<td class="first"><?=$cou;?></td>
		<td style='text-align:left;padding-left:5px;'><?=$row[catename];?> > <?=$row2[catename];?> </td>
		<td><a href="<?=$PHP_SELF;?>?code=<?=$code;?>&mode=ch&index_no=<?=$row2[index_no];?>"><?=$row2[isuse];?></a></td>
		
		</tr>
		<?
				$cou++;
				$q3 = "select * from shop_config_omemo where up_idx='$row2[index_no]' order by catename asc";
				$st3 = $pdo->prepare($q3);
				$st3->execute();
				while($row3 = $st3->fetch())
				{
					$co = "";
					if(!($cou%2)) $co = "gray";
		?>
		<tr class='<?=$co;?>'>
		<td class="first"><?=$cou;?></td>
		<td style='text-align:left;padding-left:5px;'><?=$row[catename];?> > <?=$row2[catename];?> > <?=$row3[catename];?> </td>
		<td><a href="<?=$PHP_SELF;?>?code=<?=$code;?>&mode=ch&index_no=<?=$row3[index_no];?>"><?=$row3[isuse];?></a></td>
		
		</tr>
		<?			
					$cou++;
				}
			}
			
		?>
		<?php
			$cou++;
		}
		?>
		</tbody>
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
		<th>상위구분</th>
		<td colspan='3'><select name='up_idx'>
		<option value=''>최상위로등록</option>
		<?
		$q = "select * from shop_config_omemo where up_idx='0' order by catename asc";
		$r = mysqli_query($connect,$q);
		while($row = $st->fetch())
		{
			echo "<option value='$row[index_no]'>$row[catename]</option>";
			$qs = "select * from shop_config_omemo where up_idx='$row[index_no]' order by catename asc";
			$rs = mysqli_query($connect,$qs);
			while($rows = mysqli_fetch_array($rs))
			{	echo "<option value='$rows[index_no]'>$row[catename] > $rows[catename]</option>";	}
		}
		?>
		</select></td>
		</tr>
		<tr>
		<th>구분명</th>
		<td colspan='3'><input type='text' name='catename' size='30' class='form-control'></td>
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