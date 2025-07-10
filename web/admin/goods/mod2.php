<?php
require_once('./NFUpload/nfupload_conf.inc.php');
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_goods"," WHERE index_no='$index_no'");
if($mode=='d')
{
	$iindex_no = $_REQUEST['idx'];
	$cgroup = $_REQUEST['cgroup'];

	

	$sts = $pdo->prepare("delete from shop_goods_nimg where index_no='$iindex_no'");
	$sts->execute();

	echo "<script>alert('삭제완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
if($mode=='grouporder')	{
	
	$cgroup = $_REQUEST['cgroup'];
	$orders = $_REQUEST['orders'];

	for($i=0;$i<sizeof($cgroup);$i++)	{
		$value['orders'] = $orders[$i];
		update("shop_goods_cgroup",$value," WHERE goods_idx='$index_no' and cgroup='".$cgroup[$i]."'");

	}
	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
if($mode=='adel')
{	
	$cgroup = $_REQUEST['cgroup'];

	$q = "select * from shop_goods_nimg where goods_idx='$index_no' and cgroup='$cgroup'";
	$r = mysqli_query($connect,$q);
	while($row = mysqli_fetch_array($r))
	{
		$savedir = $_uppath."goodsm/".$index_no."/";
		@unlink($savedir.$row[imgname]);
	}
	$sts = $pdo->prepare("delete from shop_goods_nimg where goods_idx='$index_no' and cgroup='$cgroup'");
	$sts->execute();

	$sts = $pdo->prepare("delete from shop_goods_cgroup where goods_idx='$index_no' and cgroup='$cgroup'");
	$sts->execute();

	

	unset($value);
	$q = "select * from shop_goods_cgroup where goods_idx='$index_no' order by orders asc";
	$st = $pdo->prepare($q);
	$st->execute();
	$cou = 1;
	while($row = $st->fetch())
	{
		$value[orders] = $cou;
		update("shop_goods_cgroup",$value," where index_no='$row[index_no]'");
		$cou++;
	}

	//mysqli_query($connect,"INSERT INTO `shop_goods_log` (`index_no`, `goods_idx`, `memo`, `wdate`, `mem_name`) VALUES (NULL, '$index_no', '상세이미지 코디 : $cgroup 삭제', '".date("Y-m-d H:i:s",time())."', '$memname');");

	echo "<script>alert('완료'); location.replace('$PHP_SELF?code=$code&index_no=$index_no'); </script>";
	exit;
}
?>
<script language="JavaScript" type="text/javascript" src="./NFUpload/nfupload.js?d=20081028"></script>
<script language="JavaScript">
<!--
	// -----------------------------------------------------------------------------
	// NFUpload User's Config
	// -----------------------------------------------------------------------------
		// 업로드 설정
			var _NF_UploadUrl = "http://<?= $_SERVER['HTTP_HOST'] ?>/nfupload_proc.php?index_no=<?=$index_no;?>";					   // 업로드 소스파일 경로 (반드시 전체주소를 입력해야함)
			var _NF_FileFilter = "";								// 파일 필터링 값 ("이미지(*.jpg)|:|*.jpg;*.gif;*.png;*.bmp"); // 기본값 모든파일
			//var _NF_FileFilter = "이미지 파일|:|*.jpg;*.jpeg;*.gif;*.png;*.bmp";								// 파일 필터링 값 ("이미지(*.jpg)|:|*.jpg;*.gif;*.png;*.bmp"); // 기본값 모든파일
			var _NF_DataFieldName = "upfile";				// 업로드 폼에 사용되는 값 (기본값(UploadData))
			var _NF_Flash_Url = "./NFUpload/nfupload.swf?d=20081028";			// 업로드 컴포넌트 플래쉬 파일명

		// 화면 구성
			var _NF_Width = 600;									// 업로드 컴포넌트 넓이 (기본값 480)
			var _NF_Height = 200;								   // 업로드 컴포넌트 폭 (기본값 150)
			var _NF_ColumnHeader1 = "파일명";					   // 컴포넌트에 출력되는 파일명 제목 (기본값: File Name)
			var _NF_ColumnHeader2 = "용량";						 // 컴포넌트에 출력되는 용량 제목 (기본값: File Size)
			var _NF_FontFamily = "굴림";							// 컴포넌트에서 사용되는 폰트 (기본값: Times New Roman)
			var _NF_FontSize = "11";								// 컴포넌트에서 사용되는 폰트 크기 (기본값: 11)

		// 업로드 제한
			var _NF_MaxFileSize = <?= $__NFUpload['max_size_total'] ?>;							// 업로드 제한 용량 (기본값: 10,240 Kb) (단위는 Kb)
			var _NF_MaxFileCount = <?= $__NFUpload['max_count'] ?>;							  // 업로드 파일 제한 갯수 (기본값: 10)
			var _NF_File_Overwrite = <? if ($__NFUpload['file_overwrite']) echo 'true'; else echo 'false'; ?>;						 // 업로드시 파일명 처리방법(true : 원본파일명 유지, 덮어씌우기 모드 / false : 유니크파일명으로 변환, 중복방지)
			var _NF_Limit_Ext = "<?= $__NFUpload['limit_ext'] ?>";	 // 파일 제한 확장자

		// [2008-10-28] Flash 10 support
		var _NF_Img_FileBrowse = "images/btn_file_browse.gif";  // 파일찾기 이미지
		var _NF_Img_FileBrowse_Width = "59";                    // 파일찾기 이미지 넓이 (기본값 59)
		var _NF_Img_FileBrowse_Height = "22";                   // 파일찾기 이미지 폭 (기본값 22)
		var _NF_Img_FileDelete = "images/btn_file_delete.gif";  // 파일삭제 이미지
		var _NF_Img_FileDelete_Width = "59";                    // 파일삭제 이미지 넓이 (기본값 59)
		var _NF_Img_FileDelete_Height = "22";                   // 파일삭제 이미지 폭 (기본값 22)
		var _NF_TotalSize_Text = "첨부용량 ";                   // 파일용량 텍스트
		var _NF_TotalSize_FontFamily = "굴림";                  // 파일용량 텍스트 폰트
		var _NF_TotalSize_FontSize = "12";                      // 파일용량 텍스트 폰트 크기

	// -----------------------------------------------------------------------------
	// NFUpload Function
	// -----------------------------------------------------------------------------
		// 폼입력 완료
		function NFU_Complete(value) {
			var files = document.FrmUpload.hidFileName.value;
			var fileCount = 0;
			var i = 0;

			// 이 부분을 수정해서 파일이 선택되지 않았을 때에도 submit을 하게 수정할 수 있습니다.
			if (value == null)
			{
				alert("업로드할 파일을 선택해 주세요.");
				return;
			}

			fileCount = value.length;

			for (i = 0; i < fileCount; i++)
			{
				var fileName = value[i].name;
				var realName = value[i].realName;
				var fileSize = value[i].size;

				// 분리자(|:|)는 다른 문자로 변경할 수 있다.
				files += fileName + "/" + realName + "|:|";
			}

			if (files.substring(files.length - 3, files.length) == "|:|")
				files = files.substring(0, files.length - 3);

			document.FrmUpload.hidFileName.value = files;
			document.FrmUpload.submit();
		}

		// 폼입력 취소
		function NF_Cancel()
		{
			// 초기화 할때는 첨부파일 리스트도 같이 초기화 시켜 준다.
			NfUpload.AllFileDelete();
			FrmUpload.reset();
		}

		// 선택된 파일들의 총용량을 화면에 갱신시킴.
		function NF_ShowUploadSize(value) {
			// value값에 실제 업로드된 용량이 넘어온다.
			sUploadSize.innerHTML = value;
		}

		// 업로드 실패시 경고문구
		function NFUpload_Debug(value)
		{
			Debug("업로드가 실패하였습니다.\r\n\r\n관리자일 경우 디버깅모드를 활성화시켜 디버깅로그를 확인해보시면 됩니다.\r\n\r\n" + value);
		}

		window.onload=function(){
			document.FrmUpload.hidFileName.value = "";
			// [2008-10-28] Flash 10 support
			//sMaxSize.innerHTML = SizeCalc(_NF_MaxFileSize);
		}
// -->
</script>
<script>
function goup()
{
	if($("#cgroup option:selected").val()!='')	{
		NfUpload.FileUpload();	
	}
	else	{
		alert('소속선택');
		return;
	}
}
function view_cordi(cgroup)	{
	$(".groups").hide();
	$("#cgroup"+cgroup).show();
}
</script>


<div class="row">
	<div class="col-md-12">
		<div class="m-t-10 m-b-10 no-print"> 
			<a href="<?=$PHP_SELF;?>?code=goods_mod1&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">상품정보수정</a>
			<a href="<?=$PHP_SELF;?>?code=goods_mod2&index_no=<?=$index_no;?>" class="btn btn-primary m-r-10 m-b-10">상세이미지관리</a>
            <? if($ar_data['gtype']=='1') {	?>
            <a href="<?=$PHP_SELF;?>?code=goods_mod3&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">옵션관리</a>
			 
			<?}?>
			<? if($ar_data['gtype']=='2') {	?>
            <a href="<?=$PHP_SELF;?>?code=goods_modsets&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">세트상품관리</a>
			<?}?>
			<a href="<?=$PHP_SELF;?>?code=goods_mod7&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">관리자리뷰관리</a>
			<a href="<?=$PHP_SELF;?>?code=goods_mod4&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">관련상품관리</a>                
            <a href="<?=$PHP_SELF;?>?code=goods_mod5&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">관련후기상품관리</a>
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod6&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">상품사이즈정보관리</a> -->
            <a href="<?=$PHP_SELF;?>?code=goods_mod8&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">상품수정로그</a>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상세이미지등록</h3>
			</div>
			<div class="panel-content">
				<form name="FrmUpload" method="post" action="form_ok.php?index_no=<?=$index_no;?>" style="margin:0px">
				<input type="hidden" name="hidFileName"/>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="85%">
				</colgroup>
				<tbody>
				<tr>
					<th>상품명</th>
					<td>
						<?=$ar_data['gname'];?>
					</td>
				</tr>
				<tr>
					<th>업로드그룹</th>
					<td>
						<select class="uch" name='cgroup' id="cgroup">
						<option value=''>선택</option>
						<?php
						for($j=1;$j<21;$j++)	{
							echo "<option value='$j'>$j</option>";	
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>이미지</th>
					<td>
				
										<script language="javascript">
										<!--
											// NFUpload 객체 생성
											//NfUpload = new NFUpload({ nf_upload_id : _NF_Uploader_Id, nf_width : _NF_Width, nf_height : _NF_Height, nf_field_name1 : _NF_ColumnHeader1, nf_field_name2 : _NF_ColumnHeader2, nf_max_file_size : _NF_MaxFileSize, nf_max_file_count : _NF_MaxFileCount, nf_upload_url : _NF_UploadUrl, nf_file_filter : _NF_FileFilter, nf_data_field_name : _NF_DataFieldName, nf_font_family : _NF_FontFamily, nf_font_size : _NF_FontSize, nf_flash_url : _NF_Flash_Url, nf_file_overwrite : _NF_File_Overwrite, nf_limit_ext : _NF_Limit_Ext});
											// [2008-10-28] Flash 10 support
							                NfUpload = new NFUpload({
							                        nf_upload_id : _NF_Uploader_Id,
							                        nf_width : _NF_Width,
							                        nf_height : _NF_Height,
							                        nf_field_name1 : _NF_ColumnHeader1,
							                        nf_field_name2 : _NF_ColumnHeader2,
							                        nf_max_file_size : _NF_MaxFileSize,
							                        nf_max_file_count : _NF_MaxFileCount,
							                        nf_upload_url : _NF_UploadUrl,
							                        nf_file_filter : _NF_FileFilter,
							                        nf_data_field_name : _NF_DataFieldName,
							                        nf_font_family : _NF_FontFamily,
							                        nf_font_size : _NF_FontSize,
							                        nf_flash_url : _NF_Flash_Url,
							                        nf_file_overwrite : _NF_File_Overwrite,
							                        nf_limit_ext : _NF_Limit_Ext,
							                        nf_img_file_browse : _NF_Img_FileBrowse,
							                        nf_img_file_browse_width : _NF_Img_FileBrowse_Width,
							                        nf_img_file_browse_height : _NF_Img_FileBrowse_Height,
							                        nf_img_file_delete : _NF_Img_FileDelete,
							                        nf_img_file_delete_width : _NF_Img_FileDelete_Width,
							                        nf_img_file_delete_height : _NF_Img_FileDelete_Height,
							                        nf_total_size_text : _NF_TotalSize_Text,
							                        nf_total_size_font_family : _NF_TotalSize_FontFamily,
							                        nf_total_size_font_size : _NF_TotalSize_FontSize
							                });
										//-->
										</script>
									
					</td>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
				<div class="col-sm-8 col-sm-offset-4">
					<button class="btn btn-primary waves-effect waves-light" type="button" onclick="goup();">등록하기</button>
						
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
				<h3><i class="fa fa-table"></i> 상세그룹관리</h3>
			</div>
			<div class="panel-content">
				<form name="listform" id="listform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post">
				<input type='hidden' name='mode' value='grouporder'>
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<table class="table table-bordered">
				<thead>
				<tr>
					<th >그룹명</th>
					<th >정렬</th>
					<th >보기</th>
					<th >삭제</th>
				</tr>
				</thead>
				<tbody>
<?php
				$cgroup = $_REQUEST['cgroup'];
				$q = "Select * from shop_goods_cgroup where goods_idx='$index_no' order by orders asc";
				$st = $pdo->prepare($q);
				$st->execute();
				while($row = $st->fetch() )	{
					
					if($cgroup==$row['cgroup'])		{
						$lay = $i;	
					}
?>
				<tr>
					<td class="first"style="padding-left:3px;padding-right:3px;">그룹<?=$row['cgroup'];?></td>
					<Td style="padding-left:3px;padding-right:3px;"><input type='text' class="form-control" name='orders[]' size='4' value='<?=$row['orders'];?>'><input type='hidden' name='cgroup[]' value='<?=$row['cgroup'];?>'></td>
					<td style="padding-left:3px;padding-right:3px;"><a  class="btn btn-xs btn-primary" href="javascript:view_cordi('<?=$row['cgroup'];?>');">조회</a></td>
					<td style="padding-left:3px;padding-right:3px;"><a   class="btn btn-xs btn-primary" href="javascript:delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=adel&index_no=<?=$index_no;?>&cgroup=<?=$row['cgroup'];?>','소속이미지를 전체 삭제하시겠습니까?');">삭제</a></td>
				</tr>
<?php
	$cou++;
}
?>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#listform">정렬변경</button>
						
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
				<h3><i class="fa fa-table"></i> 상세이미지조회</h3>
			</div>
			<div class="panel-content">
				
<?php
$q = "SELECT * FROM shop_goods_cgroup WHERE goods_idx='$index_no' order by orders ASC";
$st = $pdo->prepare($q);
$st->execute();
$cou = 0;
while($row = $st->fetch())	{
	
	if($cgroup)	{
		if($cgroup==$row['cgroup'])	{
			$mt = "style='display:block;'";	
		}
		else	{
			$mt = "style='display:none;'";	
		}
	}
	else	{	
		if($cou==0)	{
			$mt = "style='display:block;'";	
		}
		else	{
			$mt = "style='display:none;'";	
		}
	}
?>				<div class="groups" id="cgroup<?=$row['cgroup'];?>" <?=$mt;?>>
				<div> * 그룹 <?=$row['cgroup'];?></div>
				<table class="table table-bordered">
				<colgroup>
					<col width="*">
					<col width="50px;">
				</colgroup>
<?
	$qs = "SELECT * FROM shop_goods_nimg WHERE goods_idx='$index_no' AND cgroup='$row[cgroup]' ORDER BY orders asc";
	$sts = $pdo->prepare($qs);
	$sts->execute();
	while($rows = $sts->fetch() )	{
?>
				<tr>
					<td><img src="<?=$_imgserver;?>/files/goodsm/<?=$index_no;?>/<?=$rows[imgname];?>" style="max-width:100%;"></td>
					<td>
						<a href="#none" onclick="delok('<?=$PHP_SELF;?>?code=<?=$code;?>&mode=d&idx=<?=$rows['index_no'];?>&index_no=<?=$index_no;?>','삭제?');" class="btn btn-xs btn-primary">삭제</a>
					</td>
				</tr>
<?
	}
	

?>
				</table>
				</div>
<?
	$cou++;
}
?>
				
			</div>
		</div>
	</div>
</div>