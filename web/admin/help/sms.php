<?
$mode = $_REQUEST['mode'];

if($mode=='w')	{
	
	$cp = $_REQUEST['cp'];
	$renum = $_REQUEST['renum'];
	$message = $_REQUEST['message'];
	$lms = $_REQUEST['lms'];


	if($lms=='Y')	{
		gotosms($cp,$renum,$message,false,true);	
	}
	else	{
		gotosms($cp,$renum,$message);	
	}

	echo "<Script>alert('발송하였습니다'); window.close(); </script>";
	exit;
}
$index_no = $_REQUEST['index_no'];
$ar_member = sel_query_all("shop_member"," WHERE index_no='$index_no'");
$cp = $ar_member['cp'];
?>
<Script>
function gotosms()	{
	
	if($("#cp").val()=='')	{
		alert('수신번로를 입력하세요');
		return;
	}

	answer = confirm('문자발송 하시겠습니까?');
	if(answer==true)	{
		$("#sendform").submit();
	}
}
</script>
<div class="row">	
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i>문자메세지발송</h3>
			</div>
			<div class="panel-content">

				<form method="post" name="sendform" id="sendform" action="<?=$PHP_SELF;?>?code=<?=$code;?>">
				<input type='hidden' name='mode' value='w'>
				<div style="background-color:#ededed;width:200px;padding:5px;">
					<p style="padding-top:5px;font-weight:bold;text-align:center;">보내는번호 : <input type="text" name="renum" value="0215661165" size="14"> <input type="checkbox" name="lms" value="Y"> LSM</p>
					<p style="padding-top:5px;font-weight:bold;text-align:center;">받는번호 : <input type="text" name="cp" id="cp" value="<?=$cp;?>" size="14"></p>

					
			
					<textarea name="message" id="message" style="width:178px;height:258px;border:1px solid #e0e0e0;margin:0 auto;" onkeyup="textCounter(sendform.message,1);"></textarea>		
					<p style="padding-top:5px;font-weight:bold;text-align:center;" id="bs1">00Byte</p>
				</div>
				<p style="text-align:center;margin-top:10px;">
					<span class="btn_white_xs"><a href="javascript:gotosms('gosms');">문자발송</a></span>
				</p>
				</form>
					
			</div>
		</div>
	</div>
</div>