<?
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_newmarketdb_accounts"," where index_no='$index_no'");	
$ar_up = sel_query_all("shop_newmarketdb_accounts"," where index_no='$ar_data[up_idx]'");	

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 가상계좌환불</h3>
			</div>
			<div class="panel-content">
				
				<form name=ini id="ini" method=post action=INIrefundvacct.php> 
				<input type="hidden" name=mid size=40 value="<?=$ar_up['usepgid'];?>">
				<input type="hidden" name=tid size=40 value="<?=$ar_up['tno'];?>">
				<input type="hidden" name=index_no size=40 value="<?=$index_no;?>">

				<table class="table table-bordered">
				<colgroup>
					<col width="150px;">
					<col width="*">

				</colgroup>
				<tbody>
				<tr>
					<th>취소사유</th>
					<Td>
						<input type=text class="form-control" name=msg size=40 value="">
					</td>
				</tr>
				<tr>
					<th>환불계좌번호(숫자만입력)</th>
					<Td>
						<input type=text class="form-control" name=refundacctnum size=20 value="">
					</td>
				</tr>
				<tr>	
					<th>환불계좌은행코드</th>
					<Td><select name=refundbankcode  class="form-control">
			<option value="">[선택]
			<option value="02">산업
			<option value="03">기업
			<option value="04">국민
			<option value="05">외환
			<option value="06">국민(주택)
			<option value="07">수협
			<option value="11">농협
			<option value="12">농협
			<option value="16">농협(축협)
			<option value="20">우리
			<option value="21">조흥
			<option value="23">제일
			<option value="25">서울
			<option value="26">신한
			<option value="27">한미
			<option value="31">대구
			<option value="32">부산
			<option value="34">광주
			<option value="35">제주
			<option value="37">전북
			<option value="38">강원
			<option value="39">경남
			<option value="41">비씨
			<option value="45">새마을
			<option value="48">신협
			<option value="50">상호저축은행
			<option value="53">씨티
			<option value="54">홍콩상하이은행
			<option value="55">도이치
			<option value="56">ABN암로
			<option value="70">신안상호
			<option value="71">우체국
			<option value="81">하나
			<option value="87">신세계
			<option value="88">신한
			</select></td>
				</tr>
				<tr>
					<th>환불계좌주명</th>
					<Td><input type=text class="form-control" name=refundacctname size=30 value=""></td>
				</tr>
				<tr>
					<th>펌뱅킹 사용여부</th>
					<Td><select name="refundflgremit" class="form-control"><option value="1">예</option><option value="" selected>아니요</option></select></td>
				</tr>
				
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#ini">처리하기</button>
					</div>
				</div>
				</form>	
			</div>
		</div>
	</div>
</div>