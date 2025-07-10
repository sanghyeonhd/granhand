<?php
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_customdb"," WHERE index_no='$index_no'");

$q = "select * from shop_customdb_sch where customdb_idx='$index_no' order by orders asc";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
	
	$ar_datas[] = $row;

}
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	

	$value['customdb_idx'] = $index_no;
	$value['wdate'] = date("Y-m-d H:i:s");
	insert("shop_customdb_data",$value);
	$data_idx = $pdo->lastInsertId();
	unset($value);

	for($i=0;$i<sizeof($ar_datas);$i++)	{
		
		if($ar_datas[$i]['fitype']=='text')	{
			$value['data_idx'] = $data_idx;
			$value['fi_idx'] = $ar_datas[$i]['index_no'];
			$value['datas'] = $_REQUEST["data".$ar_data[$i][index_no]];
			insert("shop_customdb_data_ele",$value);
			unset($value);
		}


		if($ar_datas[$i]['fitype']=='img')	{
			$value['data_idx'] = $data_idx;
			$value['fi_idx'] = $ar_datas[$i]['index_no'];
			
			$userfile = array($_FILES["data".$ar_data[$i][index_no]]['name']);
			$tmpfile = array($_FILES["data".$ar_data[$i][index_no]]['tmp_name']);

			$savedir = $_uppath."customdb/";

			for($i=0;$i<sizeof($userfile);$i++)	{
				$fs[$i] = uploadfile($userfile[$i],$tmpfile[$i],$i,$savedir);	
			}
			
			$value['datas'] = $fs[0];
			insert("shop_customdb_data_ele",$value);
			unset($value);
		}

	}

	show_message("추가완료","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;
}
if($mode=='d')	{
	
	$data_idx = $_REQUEST['data_idx'];
	
	$pdo->prepare("delete from shop_customdb_data where customdb_idx='$index_no'")->execute();
	$pdo->prepare("delete from shop_customdb_data_ele where data_idx='$index_no'")->execute();
	
	show_message("삭제완료","");
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
	exit;
}
?>
<script>
function regichss()	{
	
	answer = confirm('등록하시겠습니까?');
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
				<h3><i class="fa fa-table"></i><?=$ar_data['name'];?> 데이터등록</h3>
			</div>
			<div class="panel-content">
				<form id="regiform" name="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data" onsubmit="return regichss();" >
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>데이터베이스명</th>
					<td colspan='3'>
						<?=$ar_data['name'];?>
					</td>
				</tr>
				<?php
				for($i=0;$i<sizeof($ar_datas);$i++)	{
					
				?>
				<tr>
					<th><?=$ar_datas[$i]['finame'];?></th>
					<td colspan='3'>
						
						<?php
						if($ar_datas[$i]['fitype']=='text')	{
						?>
						<input type='text' name='data<?=$ar_data[$i][index_no];?>' class="form-control">
						<?
						}
						?>
						<?php
						if($ar_datas[$i]['fitype']=='img')	{
						?>
						<input type='file' name='data<?=$ar_data[$i][index_no];?>' class="form-control">
						<?
						}
						?>
					</td>
				</tr>
				<?}?>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">저장하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i><?=$ar_data['name'];?> 데이터목록</h3>
			</div>
			<div class="panel-content">
				
				<table class="table table-bordered">
				<colgroup>
					<col width="45px" />
				</colgroup>
				<thead>
				<tr>
					<th>번호</th>
					<?php
					for($i=0;$i<sizeof($ar_datas);$i++)	{
					?>
					<th><?=$ar_datas[$i]['finame'];?></th>
					<?php
					}
					?>
					<th>등록일</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "select * from shop_customdb_data where customdb_idx='$index_no' order by wdate asc";
				$st = $pdo->prepare($q);
				$st->execute();
				while($row = $st->fetch())	{
				?>
				<tr>
					<td><?=$row['index_no'];?></td>
					<?php
					for($i=0;$i<sizeof($ar_datas);$i++)	{

						$da = sel_query_all("shop_customdb_data_ele"," WHERE data_idx='$row[index_no]' and fi_idx='".$ar_datas[$i]['index_no']."'");
					?>
					<td>
						<?php
						if($ar_datas[$i]['fitype']=='img')	{
							echo "<img src='".$_imgserver."files/customdb/".$da['datas']."'>";
						} 
						else	{
							echo $da['datas'];	
						}
						?>
					</td>
					<?php
					}
					?>
					<td><?=$row['wdate'];?></td>
					<td>
						<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&index_no=<?=$index_no;?>&data_idx=<?=$row['index_no'];?>&mode=d','삭제하시겠습니까?');" class="btn btn-xs btn-primary">삭제</a>
					</td>
				<?
				}
				?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>