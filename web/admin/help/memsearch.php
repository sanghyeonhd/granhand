<?php
$numper = 20;
$page_per_block = 10;
$page = $_GET['page'] ? $_GET['page'] : 1;

/* 정렬 기본 */
if ( !$sortcol )
$sortcol = "index_no";

if ( !$sortby )
$sortby = "DESC";
/* //정렬 기본 */

if(!$fid)
{
	if($ar_memprivc==1)
	{	$fid = $ar_mempriv[0];	}
	else
	{	$fid = $selectfid;	}
}

//HTTP QUERY STRING
$qArr['group_idx'] = $group_idx;
$qArr['page'] = $page;
$qArr['code'] = $code;
$qArr['se_key'] = $se_key;
$qArr['keyword'] = $keyword;
$qArr['spid'] = $spid;
$qArr['mg'] = $mg;
$qArr['ssex'] = $ssex;
$qArr['smailser'] = $smailser;
$qArr['ssmsser'] = $ssmsser;
$qArr['sage'] = $sage;
$qArr['eage'] = $eage;
$qArr['spoint'] = $spoint;
$qArr['epoint'] = $epoint;
$qArr['saccount'] = $saccount;
$qArr['eaccount'] = $eaccount;
$qArr['sdate'] = $sdate;
$qArr['edate'] = $edate;
$qArr['sdate1'] = $sdate1;
$qArr['edate1'] = $edate1;
$qArr['szip'] = $szip;
$qArr['fid'] = $fid;
$qArr['bc1'] = $bc1;
$qArr['bc2'] = $bc2;
$qArr['ba1'] = $ba1;
$qArr['ba2'] = $ba2;
$qArr['lastorder1'] = $lastorder1;
$qArr['lastorder2'] = $lastorder2;
$qArr['sortcol'] = $sortcol;
$qArr['sortby'] = $sortby;

$keyword = trim($keyword);



$q = "SELECT [FIELD] FROM shop_member WHERE id!='outmember' and rtype='3'";
if($group_idx)
{	$q = $q . " and mem_type='$group_idx'";	}
if($sage)
{	$sbirth = date("Y",time()) - $sage + 1;	}
if($eage)
{	$ebirth = date("Y",time()) - $eage + 1;	}
if($fid)
{	$q = $q . " and fid='$fid'";	}
if($keyword)
{	$q = $q . " and $se_key like '%$keyword%'";	}
if($spid)
{	$q = $q . " and pid='$spid'";	}
if($mg)
{	$q = $q . " and memgrade='$mg'";	}
if($ssex)
{	$q = $q . " and sex='$ssex'";	}
if($smailser)
{	$q = $q . " and mailser='$smailser'";	}
if($ssmsser)
{	$q = $q . " and smsser='$ssmsser'";	}
if($sbirth)
{	$q = $q . " and birth_year<='$sbirth'";	}
if($ebirth)
{	$q = $q . " and birth_year>='$ebirth'";	}
if($spoint)
{	$q = $q . " and mempoints>='$spoint'";	}
if($epoint)
{	$q = $q . " and mempoints<='$epoint'";	}
if($saccount)
{	$q = $q . " and memaccounts>='$saccount'";	}
if($eaccount)
{	$q = $q . " and memaccounts<='$eaccount'";	}
if($sdate)
{	$q = $q . " and signdate>='$sdate 00:00:01'";	}
if($edate)
{	$q = $q . " and signdate<='$edate 23:59:59'";	}
if($sdate1)
{	$q = $q . " and lastlogin>='$sdate1 00:00:01'";	}
if($edate1)
{	$q = $q . " and lastlogin<='$edate1 23:59:59'";	}
if($ba1)
{	$q = $q . " and buyac>='$ba1'";	}
if($ba2)
{	$q = $q . " and buyac<='$ba2'";	}
if($bc1)
{	$q = $q . " and buyc>='$bc1'";	}
if($bc2)
{	$q = $q . " and buyc<='$bc2'";	}
if($lastorder1)
{	$q = $q ." and lastorder>='$lastorder1'";	}
if($lastorder2)
{	$q = $q ." and lastorder<='$lastorder2'";	}
if($szip)
{	$q = $q ." and addr1 like '$szip%'";	}

//카운터쿼리
$sql = str_replace("[FIELD]", "COUNT(index_no)", $q);
$st = $pdo->prepare($sql);
$st->execute();
$total_record = $st->fetchColumn();

if($total_record == 0) { 
	$first = 0;
	$last = 0;
} else { 
	$first = $numper*($page-1);
	$last = $numper*$page; 
}

//데이터쿼리
$_sql = str_replace("[FIELD]", "*", $q);

$_tArr = explode(",", $sortcol);
if ( is_array($_tArr) && count($_tArr) ) {
	foreach ( $_tArr as $v ) {
		$orderbyArr[] = "{$v} {$sortby}";
	}
	$orderby = implode(", ", $orderbyArr);
}

$sql_order = " ORDER BY {$orderby}";
$sql_limit = " LIMIT $first, $numper";
$sql = $_sql.$sql_order.$sql_limit;
$st = $pdo->prepare($sql);
$st->execute();

while($row = $st->fetch()){
	$ar_mg = sel_query("shop_member_grades","grade_name"," WHERE grade_id = '{$row[memgrade]}' and group_idx='$row[mem_type]'");
	$row['grade_name'] = $ar_mg['grade_name'];
	
	if($row[sex]=='M') $row[sex] = '남';
	else $row[sex] = '여';
	
	$row[age] = date("Y",time())-$row[birth_year]+1;
	
	$data[] = $row;
}

//엑셀쿼리
$sql_excel = $_sql.$sql_order;
$_SESSION['sql_excel'] = $sql_excel;


?>

<script language="javascript" type="text/javascript">


function set_group()
{
	var id_group_idx = $('#id_group_idx option:selected').val();
	
		var param = "group_idx="+id_group_idx;
		$.ajax({
		type:"GET",
		url:"./ajaxmo/get_memg.php",
		dataType: "html",
		data:param,
		success:function(msg){
			$('#id_mg').html(msg);
		}
		});
}
function set_pids()
	{
		var fid = $('#fid option:selected').val();
	
		var param = "fid="+fid;
		$.ajax({
		type:"GET",
		url:"./ajaxmo/get_pid.php",
		dataType: "html",
		data:param,
		success:function(msg){
			$('#pid').html(msg);
		}
		});
	}
function select_this(f1,f2,idx,gname)	{
	
	$("#"+f1,opener.document).val(idx);
	$("#"+f2,opener.document).val(gname);
	window.close();
}
</script>
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 회원검색</h3>
			</div>
			<div class="panel-content">
				<form id="searchform" name="searchform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>회원등급</th>
					<td>
						<div class="form-inline">
							<select name='group_idx' id="id_group_idx" onchange="set_group();">
							<option value=''>회원그룹선택</option>
							<?
							$q = "select * from shop_member_group where grouptype='1'";
							$r = mysqli_query($connect,$q);
							while($row = mysqli_fetch_array($r))	{
								if($row[index_no]==$group_idx)	{
									echo "<option value='$row[index_no]' selected>$row[groupname]</option>";	
								}
								else	{
									echo "<option value='$row[index_no]'>$row[groupname]</option>";	
								}
							}
							?>
							</select>
							<select class="uch" name='mg' id='id_mg' style="z-index:9;">
							<option value=''>전체</option>
							<?
							if($group_idx)	{
								$q = "Select * from shop_member_grades where group_idx='$group_idx' order by grade_id asc";
								$r = mysqli_query($connect,$q);
								while($row = mysqli_fetch_array($r))	{	
									if($row[grade_id]==$mg)	{
										echo "<option value='$row[grade_id]' selected>$row[grade_name]</option>";		
									}
									else	{
										echo "<option value='$row[grade_id]'>$row[grade_name]</option>";		
									}
								}
							}
							?>
							</select> [회원그룹을 선택해야 회원검색이 가능]
						</div>
					</td>

					<Th>가입처</th>
					<td>
						<div class="form-inline">
						<select class="uch" name='fid' id="fid" style="z-index:8" onchange="set_pids();">
						<option value=''>전체보기</option>
						<?php
						$q = "select * from shop_sites";
						$q = $q ." order by index_no asc";
						$r = mysqli_query($connect,$q);
						while($row = mysqli_fetch_array($r))	{
							if(in_array($row[index_no],$ar_mempriv))	{
								if($row[index_no]==$fid)	{
									echo "<option value='$row[index_no]' selected>$row[sitename]</option>";	
								}
								else	{
									echo "<option value='$row[index_no]'>$row[sitename]</option>";	
								}
							}
						}
						?>
						</select>
						<select class="uch" name="spid" id="pid" style="z-index:7;">
						<option value=''>가입처</option>
						<?php
						if($fid)	{
							$q = "select * from shop_config";
							if($fid)	{	
								$q = $q . " where fid='$fid'";	
							}
							$q = $q . " order by index_no asc";
							$r = mysqli_query($connect,$q);
							while($row = mysqli_fetch_array($r))	{
								if($row[index_no]==$spid)	{
									echo "<option value='$row[index_no]' selected >$row[site_name]</option>";	
								}
								else	{
									echo "<option value='$row[index_no]'>$row[site_name]</option>";	
								}
							}
						}
						?>
						</select>
						</div>
					</td>
				</tr>
				<tr>
					<th>성별</th>
					<td><select class="uch" name='ssex' style="z-index:6;">
					<option value=''>전체</option>
					<option value='M' <? if($ssex=='M') { echo "selected";	}?>>남자</option>
					<option value='F' <? if($ssex=='F') { echo "selected";	}?>>여자</option>
					</select>
					</td>

					<th>연령</th>
					<td>
						<div class="form-inline">
						<input type='text' name='sage' class='form-control' value='<?=$sage;?>' size='4'> ~ <input type='text' name='eage' class='form-control' value='<?=$eage;?>' size='4'>
						</div>
					</td>
				</tR>
		
				<tr>
					<th>적립금</th>
					<td>
						<div class="form-inline">
						<input type='text' name='spoint' class='form-control' value='<?=$spoint;?>' > ~ <input type='text' name='epoint' class='form-control' value='<?=$epoint;?>' >
						</div>
					</td>
					<th>예치금</th>
					<td>
						<div class="form-inline">
						<input type='text' name='saccount' class='form-control' value='<?=$saccount;?>' > ~ <input type='text' name='eaccount' class='form-control' value='<?=$eaccount;?>' >
						</div>
					</td>
				</tR>
				<tr>
					<th>구매건수</th>
					<td>
						<div class="form-inline">
						<input type='text' name='bc1' class='form-control' value='<?=$bc1;?>' > ~ <input type='text' name='bc2' class='form-control' value='<?=$bc2;?>' >
						</div>
					</td>
					<th>구매금액</th>
					<td>
						<div class="form-inline">
						<input type='text' name='ba1' class='form-control' value='<?=$ba1;?>' > ~ <input type='text' name='ba2' class='form-control' value='<?=$ba2;?>' >
						</div>
					</td>
				</tr>
				<tR>
					<th>기타</th>
					<td>
						<div class="form-inline">
						<select class="uch" name='se_key'>
						<option value='name' <? if($se_key=='name') { echo "selected"; } ?>>성명</option>
						<option value='id' <? if($se_key=='id') { echo "selected"; } ?>>아이디</option>
						<option value='cp' <? if($se_key=='cp') { echo "selected"; } ?>>휴대폰</option>
						<option value='nickname' <? if($se_key=='nickname') { echo "selected"; } ?>>닉네임</option>
						</select>
						<input type='text' name='keyword' size='20' value="<?=$keyword;?>" class="form-control" onKeyPress="javascript:if(event.keyCode == 13) { form.submit() }">
						</div>
					</td>
				</tr>
				<tr>
					<th>메일수신</th>
					<td>
						<select class="uch" name='smailser'>
						<option value=''>전체</option>
						<option value='Y' <? if($smailser=='Y') { echo "selected";	}?>>동의</option>
						<option value='N' <? if($smailser=='N') { echo "selected";	}?>>동의안함</option>
						</select>
					</td>
					<th>SMS수신</th>
					<td>
						<select class="uch" name='ssmsser'>
						<option value=''>전체</option>
						<option value='Y' <? if($ssmsser=='Y') { echo "selected";	}?>>동의</option>
						<option value='N' <? if($ssmsser=='N') { echo "selected";	}?>>동의안함</option>
						</select>
					</td>
				</tR>
				<tr>
					<th>가입일</th>
					<td>
						<div class="form-inline">
						<input type='text' name='sdate' id='sdates'  value='<?=$sdate;?>' readonly  class="form-control"> ~ <input type='text' name='edate' id='edates'  value='<?=$edate;?>' readonly  class="form-control">
						</div>
		
					</td>
					<th>최종로그인</th>
					<td>
						<div class="form-inline">
							<input type='text' name='sdate1' id='sdates1'  value='<?=$sdate1;?>' readonly  class="form-control"> ~ <input type='text' name='edate1' id='edates1'  value='<?=$edate1;?>' readonly  class="form-control">
						</div>
					</td>
				</tR>
				<tr>
					<th>마지막구매</th>
					<td colspan="3">
						<div class="form-inline">
							<input type='text' name='lastorder1' id='lastorder1'  value='<?=$lastorder1;?>' readonly  class="form-control"> ~ <input type='text' name='lastorder2' id='lastorder2'  value='<?=$lastorder2;?>' readonly  class="form-control">
						</div>
					</td>
				</tR>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						<button class="btn btn-primary waves-effect waves-light" type="button" onclick="location.href='./excel/excel_down.php?act=member';">엑셀다운로드</button>
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
				<h3><i class="fa fa-table"></i> 회원은 총 <?=number_format($total_record);?>명 입니다.</h3>
			</div>
			<div class="panel-content">


<table class="table table-bordered">
<colgroup>
	<col width="40" />
	<col width="50" />
	<col width="90" />

	<col width="90" />
	<col width="30" style="display:none"/>
	<col width="120" />
	<col width="120" />
	<col width="150" />
	<col width="120" />
	<col width="120" />
	<col width="60" />
	<col width="60" />
</colgroup>
<thead>
<tr>
<th class=kor8>회원번호</th>
<th class=kor8>성명</th>
<th class=kor8>아이디</th>

<th class=kor8>나이</th>
<th class=kor8 style="display:none">성별</th>
<th class=kor8>전화번호</th>
<th class=kor8>핸드폰</th>
<th class=kor8>이메일</th>
<th class=kor8>가입일</th>
<th class=kor8>마지막구매</th>
<th class=kor8>회원등급</th>
<th class=kor8>가입처</th>
<th></th>
</tr>
</thead>
<?php
for($i=0;$i<count($data);$i++)
{
	$row = $data[$i];
	
	$co = "";
	if(!($i%2)) $co = "gray";
?>
	<tbody>
		<tr class='<?=$co;?>' onmouseover="this.style.backgroundColor='#F6F6F6'" onmouseout="this.style.backgroundColor=''">
			<td class="first"><?=$row[index_no];?></td>
			<td>
				<a href="javascript:MM_openBrWindow('popup.php?code=help_view&index_no=<?=$row[index_no];?>','member<?=$row[index_no];?>','scrollbars=yes,width=1150,height=900,top=0,left=0');"><?=$row[name];?> (<?=$row['nickname'];?>)</a>
			</td>
			<td><?=$row[id];?></td>

			<td><?=$row[birth_year];?>(<?=$row['age'];?>)</td>
			<td style="display:none"><?=$row[sex];?></td>
			<td><?=$row[phone];?></td>
			<td><?=$row[cp];?></td>
			<Td><?=$row[email];?></td>
			<td><?=$row[signdate];?></td>
			<td><?=$row[lastorder];?></td>
			<td><?=$row[grade_name];?></td>
			<td><?=$g_ar_sitename[$row[pid]];?></td>
			<td>
						
						<?php
						if($_REQUEST['hanmode']=='justselect')	{
						?>
						<a href="#none" onclick="select_this('<?=$_REQUEST['idxfi'];?>','<?=$_REQUEST['namefi'];?>','<?=$row['index_no'];?>','<?=$row['name'];?>');" class="btn btn-xs btn-primary">선택</a>
						<?}?>
			</td>
		</tr>
	</tbody>
<?php
}
?>
</table>
				<div style="text-align:center;">
					<ul class="pagination">
					<?=admin_paging($page, $total_record, $numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div><!-- // .list_wrap -->
		</div>
	</div>
</div>
<Script>
$(document).ready(function()	{
	$('#sdates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#sdates1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#edates1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#lastorder1').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
	$('#lastorder2').datepicker({
		todayHighlight: true,
		dateFormat: 'yy-mm-dd'
	});
});

</script>