<?php
$dir = "../../";
include "$dir/inc/connect.php";
include "$dir/inc/session.php";
include "$dir/inc/config.php";
include "../admin_access.php";
include "../admin_head.php";

$index_no = $_REQUEST['index_no'];
$ar_ma = sel_query_all("shop_member_grades"," where index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='w')
{
	$userfile = array($_FILES['img']['name'],$_FILES['imgl']['name']);
	$tmpfile = array($_FILES['img']['tmp_name'],$_FILES['imgl']['tmp_name']);

	$savedir = $_uppath."/icon/";

	$ar_last = array($ar_ma['icon'],$ar_ma['icon1']);
	$ar_del = array($_REQUEST['del_icon'],$_REQUEST['del_icon1']);

	for($i=0;$i<sizeof($userfile);$i++)
	{	$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);	}



	$value[grade_name] = $_POST['grade_name'];
	
	$value['grade_id'] = $_POST['grade_id'];
	$value[grade_saveper] = $_POST['grade_saveper']*100;
	$value[grade_discount] = $_POST['grade_discount'];
	$value[grade_stand] = $_POST['grade_stand'];
	$value[grade_stand] = $_POST['grade_stand'];
	$value[grade_up] = $_POST['grade_up'];
	$value[grade_canup] = $_POST['grade_canup'];
	$value[grade_sv1] = $_POST['grade_sv1'];
	$value[grade_sv2] = $_POST['grade_sv2'];
	$value[icon] = $fs[0];
	$value[iconl] = $fs[1];
	$value[grade_nodels] = $grade_nodels;
	$value[grade_birth] = $grade_birth;
	$value[seller_per] = $_REQUEST['seller_per'];
	$value[seller_out] = $_REQUEST['seller_out'];
	update("shop_member_grades",$value," where index_no='$index_no'");

	echo "<Script>alert('수정완료'); opener.location.reload(); window.close(); </script>";
	exit;
}
?>
<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원등급수정</h3>
			</div>
			<div class="panel-content">


		<form id="regiform2" name="regiform2" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
		<input type='hidden' name='mode' value='w'>
		<input type='hidden' name='index_no' value='<?=$index_no;?>'>

		<table class="table table-bordered">
		<tbody>
		<colgroup>
			<col width="15%">
			<col width="35%">
			<col width="15%">
			<col width="35%">
		</colgroup>
		<tr>
		<th>레벨</th>
		<td colspan='3'>
			<select class="uch" name='grade_id'>
			<option value=''>선택</option>
			<?php
			for($i=1;$i<=100;$i++)	{	

				$sel = "";
				if($ar_ma['grade_id']==$i)	{
					$sel = "selected";
				}

				echo "<option value='$i' $sel>$i</option>";	
			}
			?>
		</select>
		</td>
		</tr>
		<Tr>
		<th>등급명</th>
		<td colspan='3'><input type="text" class="form-control" name='grade_name' size='30' value="<?=$ar_ma[grade_name];?>"></td>
		</tr>

		<Tr>
		<th>적립율</th>
		<td colspan='3'>
			<div class="form-inline">
			<input type="text" class="form-control" name='grade_saveper' size='4' value="<?=($ar_ma[grade_saveper]/100);?>"> %
			</div>
		</td>

		</tr>
		<Tr>
		<th>할인률</th>
		<td colspan='3'>
			<div class="form-inline">		
			<input type="text" class="form-control" name='grade_stand' size='8' value='<?=$ar_ma[grade_stand];?>'> 원 이상구매시  <input type="text" class="form-control" name='grade_discount' size='4' value="<?=$ar_ma[grade_discount];?>"> %
			</div>
		</td>
		</tr>
		<Tr>
		<th>사용아이콘</th>
		<td colspan='3'><input type='file' name='img'> <? if($ar_ma[icon]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_ma[icon];?>"><label><input type='checkbox' name='del_icon' value='Y'>삭제</label><?}?></td>
		</tr>
		<Tr>
		<th>추가아이콘</th>
		<td colspan='3'><input type='file' name='imgl'> <? if($ar_ma[iconl]!=''){?><img src="<?=$_imgserver;?>/files/icon/<?=$ar_ma[iconl];?>"><label><input type='checkbox' name='del_iconl' value='Y'>삭제</label><?}?></td>
		</tr>
		<tr>
		<th>프로모션코드</th>
		<td colspan='3'><input type="text" class="form-control" name='procode' value='<?=$ar_ma[procode];?>'></td>
		</tr>
		<tr>
		<th>등업가능여부</th>
		<td colspan='3'>
			<div class="form-inline">
			이등급은 자동등급조절을 <select name='grade_canup'>
			<option value='Y' <? if($ar_ma[grade_canup]=='Y') { echo "selected";	}?>>사용</option>
			<option value='N' <? if($ar_ma[grade_canup]=='N') { echo "selected";	}?>>사용안함</option>
			</select>
			</div>
		</td>
		</tr>
		<tr>
		<th>등업기준</th>
		<td colspan='3'>
			<div class="form-inline">
			<input type="text" class="form-control" name='grade_up' size='10' value="<?=$ar_ma[grade_up];?>"> 이상 구매시 등급 적용  
			</div>
		</td>
		</tr>
		<tr>
		<th>할인시절삭</th>
		<td colspan='3'>
			<div class="form-inline">
			<input type="text" class="form-control" name='grade_sv1' size='4' value="<?=$ar_ma[grade_sv1];?>"> 단위에서 <select name='grade_sv2'>
			<option value='1' <? if($ar_ma[grade_sv2]=='1') { echo "selected";	}?>>올림</option>
			<option value='2' <? if($ar_ma[grade_sv2]=='2') { echo "selected";	}?>>반올림</option>
			<option value='3' <? if($ar_ma[grade_sv2]=='3') { echo "selected";	}?>>내림</option>
			</select>
			</div>
		</td>
		</tr>
		<tr>
		<th>무료배송여부</th>
		<td colspan='3'>
			<div class="form-inline">
			<label><input type='checkbox' name='grade_nodels' value='Y' <? if($ar_ma[grade_nodels]=='Y') { echo "checked";	}?>>무료배송</label>
			</div>
		</td>
		</tr>
		<tr>
		<th>등급별생일쿠폰</th>
		<td colspan='3'>
			<div class="form-inline">
			<select name='grade_birth'>
			<option value=''>생일쿠폰선택</option>
			<?
			$q = "select * from shop_coupen where isuse='Y'";
			$st = $pdo->prepare($q);
			$st->execute();
			while($row = $st->fetch())
			{
				if($ar_ma[grade_birth]==$row[index_no])
				{	echo "<option value='$row[index_no]' selected>$row[coupenname]</option>";	}
				else
				{	echo "<option value='$row[index_no]'>$row[coupenname]</option>";	}
			}
			?>
			</select>
			지급
			</div>
			</td>
		</tr>

		</tbody>
		</table>
		<div class="form-group row">
			<div class="col-sm-8 col-sm-offset-4">
				<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform2">수정하기</button>
						
			</div>
		</div>

		</form><!-- // form[name="regiform2"]  -->
			</div>
		</div>
	</div>
</div>