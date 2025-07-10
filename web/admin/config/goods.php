<?
$ar_data = sel_query_all("shop_config_goods"," WHERE 1");

if($mode=='w')	{
	
	$value['basic_point'] = $_REQUEST['basic_point'];
	$value['basic_curr'] = $_REQUEST['basic_cur'];
	$value['sale_oversea'] = $_REQUEST['sale_oversea'];
	$value['sale_oversea_acc'] = $_REQUEST['sale_oversea_acc'];
	$value['sale_oversea_accstd'] = $_REQUEST['sale_oversea_accstd'];

	update("shop_config_goods",$value," WHERE fid='1'");


	show_message("수정완료","");
	move_link("$PHP_SELF?code=$code");
	exit;
}
?>
<form name="wform" id="wform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
<input type='hidden' name='mode' value='w'>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품관련설정</h3>
			</div>
			<div class="panel-content">
				

				<table class="table table-bordered">
				<colgroup>
					<col class="col-md-2">
					<col class="col-md-4">
					<col class="col-md-2">
					<col class="col-md-4">
				</colgroup>
				<tbody>

				<tr>
					<th>기본적립금</th>
					<td>
						<div class="form-inline">
							<input type='text' class="form-control" name='basic_point' value="<?=$ar_data['basic_point'];?>">%
						</div>
					</td>

					<th>기본판매통화</th>
					<td>
						<select name='basic_curr'>
						<option value='KRW'>KRW</option>
						</select>
					</td>
					
				</tr>
				<tr>
					<th>해외판매여부</th>
					<td colspan='3'>
						<select name='sale_oversea'>
						<option value='Y' <? if($ar_data['sale_oversea']=='Y') { echo "Selected";	}?>>판매함</option>
						<option value='N' <? if($ar_data['sale_oversea']=='N') { echo "Selected";	}?>>판매안함</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>해외판매시기준가격</th>
					<td>
						<select name='sale_oversea_acc'>
						<option value='account' <? if($ar_data['sale_oversea_acc']=='account') { echo "Selected";	}?>>기준판매가</option>
						<option value='oaccount' <? if($ar_data['sale_oversea_acc']=='oaccount') { echo "Selected";	}?>>해외판매기준별도사용</option>
						</select>
					</td>
					<th>해외판매시가격결정</th>
					<td>
						<select name='sale_oversea_accstd'>
						<option value='1' <? if($ar_data['sale_oversea_accstd']=='1') { echo "Selected";	}?>>환율연동</option>
						<option value='2' <? if($ar_data['sale_oversea_accstd']=='2') { echo "Selected";	}?>>통화별고정가격</option>
						</select>
					</td>
				</tr>
				
				</table>
			</div>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#wform">저장하기</button>
						
				</div>
			</div>
	</div>
</div>
</form>