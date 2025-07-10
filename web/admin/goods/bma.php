<?
$numper = $_REQUEST['numper'] ? $_REQUEST['numper'] : 20;

$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "index_no";

if ( !$sortby )
$sortby = "desc";

$qArr['numper'] = $numper;
$qArr['page'] = $page;
$qArr['code'] = $code;

if($_REQUEST['mode']=='w')
{
	$value[tcate] = $_REQUEST['tcate'];
	$value[bmname] = trim($_REQUEST['bmname']);
	$value['etcdata1'] = $_REQUEST['etcdata1'];
	$value[isuse] = "Y";
	insert("shop_config_bm",$value);

	echo "<script>alert('등록하였습니다'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($_REQUEST['mode']=='lm')	{

	$idx = $_REQUEST['idx'];

	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value[bmname] = trim($_REQUEST['bmname'][$i]);
		$value['etcdata1'] = $_REQUEST['etcdata1'][$i];
		$value[isuse] = $_REQUEST['isuse'][$i];
		update("shop_config_bm",$value," where index_no='".$idx[$i]."'");
		unset($value);

	}


	

	echo "<script>alert('변경하였습니다'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
?>
<script>
function foch()
{
	if($("#tcate option:selected").val()=='')
	{
		alert('종류를 선택하세요');
		$("#tcate").focus();
		return false;
	}
	if($("#bmname").val()=='')
	{
		alert('명칭을 입력하세요');
		$("#bmname").focus();
		return false;
	}
	answer = confirm('등록하시겠습니까?');
	if(answer==true)
	{	return true;	}
	else
	{	return false;	}
}
</script>
<div class="row">
	<div class="col-md-8">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 브랜드목록</h3>
			</div>
			<div class="panel-content">
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='lm'>
				<table class="table table-bordered">
				<thead>
				<Tr>
					<th>번호</th>
					<th>분류</th>
					<th>명칭</th>
					<th>사용여부</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "Select * from shop_brand order by orders asc";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch())	{
				?>
				<Tr>
					<td><?=$cou;?></td>
					<td><? if($row['tcate']=='1') { echo "제조사";	} else { echo "브랜드";	}?></td>
					<td><input type='hidden' name='idx[]' value="<?=$row['index_no'];?>"><input type='text' name='bmname[]' value='<?=$row['bmname'];?>' class="form-control"></td>
					<Td><select name='isuse[]'>
					<option value='Y' <?php if($row['isuse']=='Y') { echo "selected";	} ?>>사용함</option>
					<option value='N' <?php if($row['isuse']=='N') { echo "selected";	} ?>>사용안함</option>
					</select>
					</select>
					</td>
				</tr>
				<?php
					$cou++;
				}
				?>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#listform">수정하기</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4  ">
		<div class="panel">
			<div class="panel-header ">
				<h3><i class="fa fa-table"></i> 브랜드등록</h3>
			</div>
			<div class="panel-content">
				<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return foch();">
				<input type='hidden' name='mode' value='w'>
			
				<table class="table table-bordered">
				<tr>
					<th>명칭</th>
					<td><input type='text' name='bmname' id='bmname' class="form-control"></td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#form1">등록하기</button>
						
					</div>
				</div>
			
				</form><!-- // .form[name="form1"] -->
			</div>
		</div>
	</div>
</div>
