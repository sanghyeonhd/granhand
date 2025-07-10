<?php
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$rcou = $_REQUEST['rcou'];
	$usecom = $_REQUEST['usecom'];
	if($usecom=='2')	{
		$value['name'] = $_REQUEST['shopname'];
		$value['phone'] = $_REQUEST['shopphone'];

		insert("shop_goods_shops",$value);
		$in_idx = $pdo->lastInsertId();
		unset($value);
	}
	else	{
		$in_idx = $_REQUEST['in_idx'];
	}
	
	move_link("$PHP_SEFL?code=".$code."w&rcou=$rcou&in_idx=$in_idx");
	exit;
}
?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		
		if($("#usecomdata").val()=='1')	{
			if($("#in_idx option:selected").val()=='')	{
				alert('거래처를 선택하세요');
				return false;
			
			}
		}

		if($("#usecomdata").val()=='2')	{
			if($("#shopname").val()=='')	{
				alert('거래처정보를 입력하세요');
				return false;
			
			}
		}


		return true;
		
	}
	else	{
		return false;
	}
}
function set_fi(m)	{

	$("#selcoms1").hide();
	$("#selcoms2").hide();

	$("#selcoms"+m).show();

	$("#usecomdata").val(m);

	
}
</script>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품일괄등록</h3>
			</div>
			<div class="panel-content">
				<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' id="usecomdata" valch="yes" msg="거래처 등록형태를 선택하세요" value=''>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>상품등록갯수</th>
					<td colspan='3'>
						<input type='text' name='rcou' class="form-control" valch="yes" msg="등록할 상품갯수를 입력하세요">
					</td>
				</tr>
				<tr>
					<th>거래처</th>
					<td colspan='3'>
						<label><input type='radio' name='usecom' value='1' onclick="set_fi(1);">기존거래처선택</label>
						<label><input type='radio' name='usecom' value='2' onclick="set_fi(2);">거래처신규등록</label>
					</td>
				</tr>
				<tr id="selcoms1" style="display:none;">
					<th>거래처선택</th>
					<td colspan='3'>
						<select name='in_idx' id="in_idx">
						<option value=''>거래처선택</option>
						<?php
						$q = "SELECT * FROM shop_goods_shops ORDER BY name ASC";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							echo "<option value='$row[index_no]'>$row[name]</option>";
						}
						?>
						</select>
					</td>
				</tr>
				<tr id="selcoms2" style="display:none;">
					<th>거래처입력</th>
					<td colspan='3'>
						<div class="form-inline">
						거래처명 : <input type='text' name='shopname' id='shopname' class="form-control">
						연락처 : <input type='text' name="shopphone" class="form-control">
						</div>
					</td>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">상품등록시작하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>