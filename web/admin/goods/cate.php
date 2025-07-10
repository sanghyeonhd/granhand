<?php
$idx = $_REQUEST['idx'] ?? '';
if($idx)	{
	$ar_data = sel_query_all("shop_cate"," WHERE idx='$idx'");
}
$mode = $_REQUEST['mode'] ?? '';

if($mode=='w')	{
	
	$value['catename'] = $_REQUEST['catename'];
	$value['isshow'] = $_REQUEST['isshow'];
	
	$userfile = array($_FILES['file']['name']);
	$tmpfile = array($_FILES['file']['tmp_name']);

	$savedir = $_uppath."cate/";


	$ar_del = array($_POST['isdel']);
	$ar_last = array($ar_data['topimg']);


	for($i=0;$i<sizeof($userfile);$i++)	{
		$fs[$i] = uploadfile_mod($userfile[$i],$tmpfile[$i],$i,$savedir,$ar_last[$i],$ar_del[$i]);	
	}

	$showsite = $_REQUEST['showsite'];
	
	$value['showsites'] = serialize($showsite);
	$value['catetitle'] = trim($_REQUEST['catetitle']);
	$value['topimg'] = $fs[0];
	$value['toptype'] = $_REQUEST['toptype'];
	$value['topmemo'] = addslashes($_REQUEST['topmemo']);

	update("shop_cate",$value," WHERE idx='$idx'");

	show_message("수정완료","");
	move_link("$PHP_SELF?code=$code&idx=$idx");
	exit;
}
?>
<script>
function set_fi(m)	{
	$("#mtop1").hide();
	$("#mtop2").hide();
	$("#mtop"+m).show();
}
</script>
<link href="/assets/global/plugins/jstree/src/themes/default/style.min.css" rel="stylesheet">
<div class="row">
	<div class="col-md-12">
		<div class="text-right">
			<a href="#none" onclick="MM_openBrWindow('popup.php?code=goods_cateo&upcate=','cateorder','width=600,height=600,scrollbars=yes')" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>1차카테고리정렬변경</a>
			<a href="subpage.php?code=goods_catew" class="btn btn-sm btn-inverse"><i class="fa fa-plus m-r-5"></i>카테고리추가</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 등록된카테고리</h3>
			</div>
			<div class="panel-content">
				
				<div id="catetree">
					<ul>
					<?php
					$q = "Select * from shop_cate where upcate='' ORDER BY rorders ASC";
					$st = $pdo->prepare($q);
					$st->execute();
					while ($row = $st->fetch()) {
					?>
						<li id="<?=$row['idx'];?>" <? if($idx==$row['idx']) { ?> class="jstree-clicked"<?}else{?><? if(isset($ar_data['catecode']) && substr($ar_data['catecode'],0,2)==$row['catecode']) { ?> class="jstree-open"<?}?><?}?>><?=$row['catename'];?> <? if($row['isshow']!='Y') { echo "[미노출]";	}?>
							<ul>
							<?php
							$qs = "SELECT * FROM shop_cate where upcate='$row[catecode]' order by rorders ASC";
							$sts = $pdo->prepare($qs);
							$sts->execute();
							while ($rows = $sts->fetch()) {
							?>
								<li id="<?=$rows['idx'];?>" <? if($idx==$rows['idx']) { ?> class="jstree-clicked"<?}?>><?=$rows['catename'];?> <? if($rows['isshow']!='Y') { echo "[미노출]";	}?>
									<ul>
									<?php
									$qs2 = "SELECT * FROM shop_cate WHERE upcate='$rows[catecode]' order by rorders ASC";
									$sts2 = $pdo->prepare($qs2);
									$sts2->execute();
									while ($rows2 = $sts2->fetch()) {
									?>
									<li id="<?=$rows2['idx'];?>" <? if($idx==$rows2['idx']) { ?> class="jstree-clicked"<?}?>><?=$rows2['catename'];?> <? if($rows2['isshow']!='Y') { echo "[미노출]";	}?></li>
									<?
									}
									?>
									</ul>
								</li>
							<?
							}
							?>
							</ul>
						</li>
					<?
					}
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="panel" id="cate_wrap">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 카테고리정보</h3>
			</div>
			<div class="panel-content" id="cate_html">
				<?php
				if($idx)	{
					
				?>
				<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" ENCTYPE="multipart/form-data">
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='idx' value='<?=$idx;?>'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
				</colgroup>
				<tbody>
				<tr>
					<th>카테고리코드</th>
					<td><?=$ar_data['catecode'];?></td>
				</tr>
				<tr>
					<th>카테고리명</th>
					<td><input type='text' name='catename' class='form-control' valch="yes" msg="카테고리명을 입력하세요" value="<?=$ar_data['catename'];?>"></td>
				</tr>
				<tr>
					<th>노출사이트</th>
					<td>
<?php
foreach($g_ar_pid AS $key => $val)	{
	
	$ar_showsites = unserialize($ar_data['showsites']);
?>
						<label><input type='checkbox' name='showsite[]' value='<?=$val['idx'];?>' <? if(in_array($val['idx'],$ar_showsites)) { echo "checked";	}?>> <?=$val['site_name'];?></label>
<?
}
?>	
					</td>
				</tr>
				<tr>
					<th>임시코드</th>
					<td><input type='text' name='catetitle' class='form-control' valch="yes" msg="카테고리명을 입력하세요" value="<?=$ar_data['catetitle'];?>"></td>
				</tr>
				
				<tr>
					<th>노출여부</th>
					<td>
						<select name='isshow'>
						<option value='Y' <?php if($ar_data['isshow']=='Y') { echo "selected";	}?>>노출</option>
						<option value='N' <?php if($ar_data['isshow']=='N') { echo "selected";	}?>>노출안함</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>상단구성</th>
					<td>
						<label><input type='radio' name='toptype' value='1' <?php if($ar_data['toptype']=='1') { echo "checked";	}?> onclick="set_fi(1);">이미지로등록</label>
						<label><input type='radio' name='toptype' value='2' <?php if($ar_data['toptype']=='2') { echo "checked";	}?> onclick="set_fi(2);">에디터로등록</label>
					</td>
				</tr>
				<tr id="mtop1" <? if($ar_data['toptype']!='1') { echo "style='display:none;'";	}?>>
					<th>상단이미지</th>
					<td><input type='file' name='file'><? if($ar_data['topimg']!='') { echo $ar_data['topimg']."등록";	?><label><input type='checkbox' name='isdel' value='Y'>삭제</label><?}?></td>
				</tr>
				<tr id="mtop2" <? if($ar_data['toptype']!='2') { echo "style='display:none;'";	}?>>
					<th>상단메모</th>
					<td>
						<textarea cols="80" rows="10" name="topmemo" class="cke-editor"><?=$ar_data['topmemo'];?></textarea>
					</td>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
					
						
						<button class="btn btn-primary waves-effect waves-light" type="button" onclick="MM_openBrWindow('popup.php?code=goods_cateo&upcate=<?=$ar_data['catecode'];?>','cateorder','width=600,height=600,scrollbars=yes')">하위카테고리정렬변경</button>

						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">수정하기</button>
						
					</div>
				</div>
				</form>
				<?
				}
				else	{
					echo "조회 하고자하는 카테고리를 선택하세요.";
				}
				?>
			</div>
		</div>
	</div>
</div>
<script src="/assets/global/plugins/jstree/jstree.min.js"></script>
<Script>
$(document).ready(function()	{

	//get_catetree();

	$('#catetree').on('changed.jstree', function (e, data) {
    var i, j, r = [];
    for(i = 0, j = data.selected.length; i < j; i++) {
      r.push(data.instance.get_node(data.selected[i]).id);
    }
    get_cates(r.join(', '));
  }).jstree();

});


function get_catetree()	{
	
	$.getJSON('/exec/proajax.php?act=goods&han=get_allcate',function(result)	{
		
		if(result.res=='ok')	{
			
			console.log(result.catedata);

			if(result.catecou==0)	{
				$("#catetree").html('등록된 카테고리가 없습니다.');
			}
			else	{
				$('#catetree').on('changed.jstree', function (e, data) {
					var i, j, r = [];
					for(i = 0, j = data.selected.length; i < j; i++) {
				      r.push(data.instance.get_node(data.selected[i]).id);
				    }
				    get_cates(r.join(', '));
				}).jstree({
					'core': {
						'data': result.catedata
					}
			    });
			}
		}

	});
}
function get_cates(idx)	{
	location.href='<?=$PHP_SELF;?>?code=<?=$code;?>&idx='+idx;
}
</script>
<script src="/assets/global/plugins/cke-editor/ckeditor.js"></script> <!-- Advanced HTML Editor -->
<script src="/assets/global/plugins/cke-editor/adapters/adapters.min.js"></script>
