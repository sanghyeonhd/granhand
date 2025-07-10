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
	$value[name] = trim($_REQUEST['name']);
	$value[isuse] = "Y";
	insert("shop_config_maker",$value);

	echo "<script>alert('등록하였습니다'); location.replace('$PHP_SELF?code=$code'); </script>";
	exit;
}
if($_REQUEST['mode']=='lm')	{

	$idx = $_REQUEST['idx'];

	for($i=0;$i<sizeof($idx);$i++)	{
		
		$value[name] = trim($_REQUEST['name'][$i]);
		$value[isuse] = $_REQUEST['isuse'][$i];
		update("shop_config_maker",$value," where index_no='".$idx[$i]."'");
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
	if($("#name").val()=='')
	{
		alert('명칭을 입력하세요');
		$("#name").focus();
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
				<h3><i class="fa fa-table"></i> 제조사목록</h3>
			</div>
			<div class="panel-content">
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='lm'>
				<table class="table table-bordered">
				<thead>
				<Tr>
					<th>번호</th>
					<th>제조사명</th>
					<th>사용여부</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "Select * from shop_config_maker order by name asc";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch())	{
				?>
				<Tr>
					<td><?=$cou;?></td>
					<td><input type='hidden' name='idx[]' value="<?=$row['index_no'];?>"><input type='text' name='name[]' value='<?=$row['name'];?>' class="form-control"></td>
					<Td><select name='isuse[]'>
					<option value='Y' <?php if($row['isuse']=='Y') { echo "selected";	} ?>>사용함</option>
					<option value='N' <?php if($row['isuse']=='N') { echo "selected";	} ?>>사용안함</option>
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
				<h3><i class="fa fa-table"></i> 제조사등록</h3>
			</div>
			<div class="panel-content">
				<form id="form1" name="form1" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return foch();">
				<input type='hidden' name='mode' value='w'>
			
				<table class="table table-bordered">
				<tr>
					<th>종류</th>
					<td>
						<select name='tcate' id='tcate'>
						<option value=''>종류선택</option>
						<option value='1'>제조사</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>인스타계정</th>
					<td><input type='text' name='etcdata1' id='etcdata1' class="form-control"></td>
				</tr>
				<tr>
					<th>명칭</th>
					<td><input type='text' name='name' id='name' class="form-control"></td>
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
