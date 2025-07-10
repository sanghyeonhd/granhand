<?php
$mode = $_REQUEST['mode'];
$fid = 1;

// 상황별문자 셋팅
if($fid) {
	
	$ar_cnt = sel_query("shop_situation_msg","count(index_no) as cnt ", " WHERE fid='$fid'");
	
	/*
	 * 해당 값음 필수 값입니다.
	 * 1. 회원가입
	 * 2. 무통장주문
	 * 3. 결제완료
	 * 4. 환불완료
	 * 5. 상품발송
	 * 6. QNA
	 * 7. 비밀번호찾기
	 * 8. 미입금독촉문자
	 */
	
	$ar_title = array(
			'회원가입',
			'무통장주문',
			'결제완료',
			'환불완료',
			'상품발송',
			'QNA',
			'비밀번호찾기',
			'미입금독촉문자',
	);
	
	$ar_memo = array(
			
			'[NAME]님 회원 가입을 진심으로 축하드립니다.',
			'[NAME]님, 주문번호 [ONUM]/[ACCOUNT]원을[BANK]입금부탁드려요~^^',
			'[DATE]에 주문번호: [ONUM]가 결제완료 되었습니다.',
			'[NAME]님께서 구매하신 상품 [ONUM]의 환불 처리가 완료되었습니다.',
			'[NAME]님~ 주문하신 상품이[GOCOM] [GONUMBER]로 발송되었습니다^^',
			'',
			'',			
			'',
	);
	
	if($ar_cnt[cnt] == 0) {
		// 상황별 문자 인서트
		$index_no = 1;	// 인덱스 만들기
		
		for($i=0; $i<count($ar_title); $i++) {
			set_smscfg_data($index_no,$fid,'title',$ar_title[$i]);
			set_smscfg_data($index_no,$fid,'memo',$ar_memo[$i]);
			$index_no++;
		}
	} 
}

if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}
if($mode=='w') {
	// for 문을 위한 등록된 갯수 파악
	$cou = $_POST["cou"];
	
	for ($i = 1 ; $i <= $cou ; $i++) {
		if($_POST['index_no'.$i] == $i) {
			set_smscfg_data($_POST['index_no'.$i],$fid,'use',$_POST['use'.$i]);
			set_smscfg_data($_POST['index_no'.$i],$fid,'usesms',$_POST['usesms'.$i]);
			set_smscfg_data($_POST['index_no'.$i],$fid,'uselms',$_POST['uselms'.$i]);
			set_smscfg_data($_POST['index_no'.$i],$fid,'useapp',$_POST['useapp'.$i]);
			set_smscfg_data($_POST['index_no'.$i],$fid,'usealim',$_POST['usealim'.$i]);
			set_smscfg_data($_POST['index_no'.$i],$fid,'memo',$_POST['memo'.$i]);
		}
	}
	
	echo "<script>alert('설정완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
} else if ($mode=="regist") {
	// 상황별 문자 추가
	$ar_cnt = sel_query("shop_situation_msg","count(index_no) as cnt"," where fid='$fid' and mode='title'");
	
	$value[index_no] = ($ar_cnt[cnt] > 0 ) ? $ar_cnt[cnt]+1 : 1;
	$value[fid] = $fid;
	$value[mode] = "title";					// 타이틀
	$value[data] = $_POST["title"];			// data

	insert("shop_situation_msg",$value);
	unset($value);

	echo "<script>alert('등록완료'); location.replace('$PHP_SELF?code=$code&fid=$fid'); </script>";
	exit;
}
function set_smscfg_data($index_no,$fid,$mode,$data) {
	global $basictb;

	$value[data] = $data;				// 벨류값

	// 현재 db에 값이 있는지 확인
	$ar_cnt = sel_query("shop_situation_msg","count(index_no) as cnt ", " WHERE fid='$fid' AND index_no='$index_no' AND mode='$mode'");
	// 값이 이미 있다면 update로가도록 수정
	if($ar_cnt[cnt] > 0) {
		update("shop_situation_msg",$value," WHERE fid='$fid' AND mode='$mode' AND index_no='$index_no'");
	} else {
		$value[index_no] = $index_no;		// 인덱스번호
		$value[mode] = $mode;				// 키값
		$value[fid] = $fid;					// fid
		insert("shop_situation_msg",$value);
	}
	
	unset($value);
}
?>
<script>
$(document).ready(function(){

	var aa = $("#cou").val();

	// byte표시 나열된 문자 갯수대로 수정
	for (var i=1 ; i <= aa ; i++) {
		textCounter($("#memo"+i).val(),i);
	}
	
});
</script>
<script language="javascript">

function textCounter(theField,aa)
{
	var strCharCounter = 0;

	var intLength = theField.length;

	for (var i = 0; i < intLength; i++)
	{
		var charCode = theField.charCodeAt(i);

		if (charCode > 128)	{	
			strCharCounter += 2;
		} else {
			strCharCounter++;	
		}
	}

	$("#bs"+aa).html(strCharCounter+'Byte');
}

//상황별 문자 등록
$( document ).ready(function() {
	$("#regist_btn").click(function() {
		
		$("#registform").submit();
	});
});

// 삭제
function del(index_no,fid) {

	answer = confirm('삭제 하시겠습니까?');
	if(answer==true) {
		location.href='<?=$PHP_SELF;?>?code=<?=$code;?>&mode=del&fid='+fid+'&index_no='+index_no;
	}
	
}

</script>


<form id="writeform" name="writeform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" enctype="multipart/form-data">
<input type='hidden' name='fid' value='1'>
<input type='hidden' name='mode' value='w'>


<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 치환자설명 </h3>
			</div>
			<div class="panel-content">
<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>

<tr>
<Th>치환자설명</th>
<td colspan='3'>[NAME] (주문자),  [BANK] (입금계좌번호),  [ACCOUNT] (주문금액),  [SITE_NAME] (사이트명),  [GOCOM] (배송정보),  [GONUMBER] (송장번호),  [DATE] (날짜),  [ONUM] (주문번호) </td>
</tr>
</tbody>
</table>

			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12 portlets ui-sortable">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상황별문자설정 </h3>
			</div>
			<div class="panel-content">
		<div class="row">
	<?
		$q = "SELECT index_no, group_concat(mode separator '|*|') as mode, group_concat(data separator '|*|') as data FROM shop_situation_msg WHERE fid='$fid' GROUP BY index_no ORDER BY index_no";
		$r = mysqli_query($connect,$q);
		$cou = 1;
		while ($row = mysqli_fetch_array($r)) {  
			
			// 배열가공
			$ar_index[$cou] = $row['index_no']; 
			$ar_key[$cou] = explode("|*|",$row['mode']);
			$ar_value[$cou] = explode("|*|",$row['data']);
			for($i=0 ; $i < count($ar_key[$cou]) ; $i++) {
				$ar_data[$cou][$ar_key[$cou][$i]] = $ar_value[$cou][$i];
			?>
			<?
			}
			$cou++;
		}
	?>
	
	<? 
		for($i=1 ; $i <= count($ar_index) ; $i++) {
	?>
	<div class="col-md-3" style="padding-bottom:20px;">
		<div style='background-color:#ededed;width:100%;padding:5px;'>
			<p style='padding-top:5px; text-align:center; margin:0 0 10px'>
			<input type="hidden" id="index_no<?=$ar_index[$i]?>" name="index_no<?=$ar_index[$i]?>" value="<?=$ar_index[$i]?>">
				<font size="3"><?=$ar_data[$i]['title']?></font><br> <input type='checkbox' name='use<?=$ar_index[$i]?>' value='Y' <? if($ar_data[$i]['use']=='Y') { echo "checked";	}?>>사용 
			</p>
			<p style='padding-top:5px;font-weight:bold;text-align:center;'>
				<input type='checkbox' name='usesms<?=$ar_index[$i]?>' value='Y' <? if($ar_data[$i]['usesms']=='Y') { echo "checked";	}?>>SMS
				<input type='checkbox' name='uselms<?=$ar_index[$i]?>' value='Y' <? if($ar_data[$i]['uselms']=='Y') { echo "checked";	}?>>LMS
				<input type='checkbox' name='useapp<?=$ar_index[$i]?>' value='Y' <? if($ar_data[$i]['useapp']=='Y') { echo "checked";	}?>>앱
				<input type='checkbox' name='usealim<?=$ar_index[$i]?>' value='Y' <? if($ar_data[$i]['usealim']=='Y') { echo "checked";	}?>>알림톡</p>
				<textarea id='memo<?=$ar_index[$i]?>' name='memo<?=$ar_index[$i]?>' style='width:100%;height:258px;border:1px solid #e0e0e0;margin:0 auto;' onKeyUp="textCounter($('#memo<?=$ar_index[$i]?>').val(),<?=$ar_index[$i]?>);" STYLE="ime-mode:active"><?=$ar_data[$i]['memo'];?></textarea>		
			<p style='padding-top:5px;font-weight:bold;text-align:center;' id="bs<?=$ar_index[$i]?>"><?=bas($ar_data[$i]['memo']);?>Byte</p>
		</div>
	</div>
	<?
		}
	?>
	<input type="hidden" id="cou" name="cou" value="<?=count($ar_data)?>" />
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
			<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#writeform">변경하기</button>
					
				</div>
			</div>
	</div>
</div>

</form><!-- // form[name="writeform"] -->

<?


function bas($str)
{
	for($i=0,$maxi=mb_strlen($str,"UTF-8"); $i<$maxi; $i++) 
	{
		if (ord($str[$i])< 128) 
		{	$buf = $buf + 2;	}
		else
		{	$buf = $buf + 1;	}
	}
	return $buf;
}
?>
