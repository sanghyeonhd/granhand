<?
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$idx = $_REQUEST['idx'];

	for($i=0;$i<sizeof($idx);$i++)	{
		

		
		$value['ups'] = $_REQUEST['ups'][$i];
		$value['currrate'] = $_REQUEST['currrate'][$i];
		$value['showstd'] = $_REQUEST['showstd'][$i];
		$value['showdan1'] = $_REQUEST['showdan1'][$i];
		$value['showdan2'] = $_REQUEST['showdan2'][$i];
		$value['caltype'] = $_REQUEST['caltype'][$i];
		update("shop_config_curr",$value," where idx='$idx[$i]'");
		//echo mysqli_error();

		unset($value);
	}

	show_message("수정완료",'');
	move_link("$PHP_SELF?code=$code");
	exit;

}
?>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 운영통화관리</h3>
			</div>
			<div class="panel-content">
				
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='w'>
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>기준통화</th>
					<th>통화명</th>
					<th>판매가격배수</th>
					<th>환율</th>
					<th>표현</th>
					<th>가격처리</th>
					<th>통화표시(앞)</th>
					<th>통화표시(뒤)</th>
				</tr>
				</thead>
				<tbody>
<?php
$q = "SELECT * FROM shop_config_curr";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())	{
?>
				<tr>
					<td><input type='hidden' name='idx[]' value='<?=$row['idx'];?>'><?=$row['isbasic'];?></td>
					<td><?=$row['name'];?></tD>
					<td><?php if($row['isbasic']!='Y') { ?><input type='text' name='ups[]' value='<?=$row['ups'];?>' class="form-control"><?	} else { echo "해당없음<input type='hidden' name='ups[]' value='0'>";	} ?></td>
					<TD><?php if($row['isbasic']!='Y') { ?><input type='text' name='currrate[]' value='<?=$row['currrate'];?>' class="form-control"><?	} else { echo "해당없음<input type='hidden' name='currrate[]' value='0'>";	} ?></td>
					<TD>
						<div class="form-inline">
						소수점
						<select name='showstd[]'>
						<option value='0' <? if($row['showstd']=='0') {?>selected<?}?>>0</option>
						<option value='1' <? if($row['showstd']=='1') {?>selected<?}?>>1</option>
						<option value='2' <? if($row['showstd']=='2') {?>selected<?}?>>2</option>
						</select>
						자리 까지
					</td>
					<TD>
						<? if($row['isbasic']=='Y') {?>
						<input type='hidden' name='caltype[]' value=''>해당없음
						<?}else{?>
						<select name='caltype[]'>
						<option value='ceil' <? if($row['caltype']=='ceil') { ?>selected<?}?>>올림</option>
						<option value='round' <? if($row['caltype']=='round') { ?>selected<?}?>>반올림</option>
						<option value='floor' <? if($row['caltype']=='floor') { ?>selected<?}?>>내임</option>
						</select>
						<?}?>
					</td>

					<TD><input type='text' name='showdan1[]' value='<?=$row['showdan1'];?>' class="form-control"></td>
					<TD><input type='text' name='showdan2[]' value='<?=$row['showdan2'];?>' class="form-control"></td>
				</tr>
<?
}
?>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#listform">저장하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
		
	</div>
</div>
