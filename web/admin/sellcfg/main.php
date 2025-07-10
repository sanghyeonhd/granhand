<script>
$(document).ready(function()	{
	$("#id_fid").on("change",function()	{
		get_pid($(this).children("option:selected").val());
		
	});
});

function get_pid(fid)	{
	
	$.getJSON("/exec/proajax.php?act=cate&han=get_pid&fid="+fid,function(result)	{
		var str = "<option value=''>전체보기</option>";
		$(result.datas).each(function(index,item)	{
			str = str + "<option value='"+item.idx+"'>"+item.site_name+"</option>";
		});
		$("#id_pid").html(str);
	});
}
</script>
<div class="row">
	<div class="col-md-12 ">
		<div class="panel">
			<div class="panel-header ">
				<h3><i class="fa fa-table"></i> 검색</h3>
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
				<tr>
					<th>소속그룹</th>
					<td>
						<select name='fid' id="id_fid">
						<option value=''>전체보기</option>
						<?php
						$q = "select * from shop_sites";
						$q = $q ." order by idx asc";
						$st = $pdo->prepare($q);
						$st->execute();	
						while($row = $st->fetch())	{
							if(in_array($row['idx'],$ar_mempriv))	{
								if($row['idx']==$fid)	{	
									echo "<option value='$row[idx]' selected>$row[sitename]</option>";	
								}
								else	{
									echo "<option value='$row[idx]'>$row[sitename]</option>";	
								}
							}
						}
						?>
						</select>
					</td>
					<th>판매처</th>
					<td>
						<select name='pid' id="id_pid">
						<option value=''>전체보기</option>
						<?php
						if($fid)	{
							$q = "select * from shop_config where fid='$fid'";
							$st = $pdo->prepare($q);
							$st->execute();
							while($row = $st->fetch() )	{
								$sel = "";
								if($row['idx']==$pid)	{
									$sel = "selected";
								}
								echo "<option value='$row[idx]' $sel>$row[site_name]</option>";
							}
						}
						?>
						</select>
					</td>
				</tr>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#searchform">검색</button>
						
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 ">
		<div class="panel">
			<div class="panel-header ">
				<h3><i class="fa fa-table"></i> 진열영역목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<thead>
				<tr>
					<th>NO</th>
					<th>그룹</th>
					<th>운영사이트</th>
					<th>데이터영역명</th>
					<th>노출형태</th>
					<th>데이터연결</th>
				</tr>
				</thead>
				<tbody>
<?php
$q = "select shop_design_mainconfig.*,shop_sites.sitename AS groupname,shop_config.site_name as site_name from shop_design_mainconfig INNER JOIN shop_sites ON shop_sites.idx=shop_design_mainconfig.fid INNER JOIN shop_config on shop_config.idx=shop_design_mainconfig.pid";
if($fid)	{
	$q = $q . " WHERE shop_design_mainconfig.fid='$fid'";	
}
if($pid)	{
	$q = $q . " and shop_design_mainconfig.pid='$pid'";
}
$q = $q . " order by adminorder ASC";
$st = $pdo->prepare($q);
$st->execute();	
while($row = $st->fetch())	{
?>
				<tr>
					<td><?=$row['idx'];?></td>
					<Td><?php echo $row['groupname'];?></td>
					<Td><?php echo $row['site_name'];?></td>
					<td>
						<?=$row['mainname'];?>
						<? if($row['showtype']=='2') { echo $row['sizeinfo']; }	?>
					</td>
					<td>
						<? if($row['showtype']=='1') { echo "상품노출";	}?>
						<? if($row['showtype']=='2') { echo "배너노출";	}?>
						<? if($row['showtype']=='3') { echo "HTML편집";	}?>
						<? if($row['showtype']=='4') { echo "컨텐츠노출";	}?>
						<? if($row['showtype']=='5') { echo "이벤트";	}?>
					</td>
					<td>
<?php
if($row['showtype']=='1')	{
?>				
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>goods&idx=<?=$row['idx'];?>&smode=gallery" class="btn btn-xs btn-primary">상품진열[GALLERY]</a>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>goods&idx=<?=$row['idx'];?>&smode=list" class="btn btn-xs btn-primary">상품진열[TEXT]</a>
<?
}
?>
<?php
if($row['showtype']=='2')	{
?>						
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>banner&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">배치수정</a>
<?
}
?>
<?php
if($row['showtype']=='3')	{
?>						
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>html&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">편집하기</a>
<?
}
?>
<?php
if($row['showtype']=='4')	{
?>						
						<a href="#none" onclick="MM_openBrWindow('popup.php?code=goods_maincate&idx=<?=$row['idx'];?>','cate<?=$row['idx'];?>','scrollbars=yes,width=800,height=800,top=0,left=0');" class="btn btn-xs btn-primary">분류관리</a>
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>cont&main_idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">컨텐츠관리</a>
<?
}
?>
<?php
if($row['showtype']=='5')	{
?>						
						<a href="<?=$PHP_SELF;?>?code=<?=$code;?>event&idx=<?=$row['idx'];?>" class="btn btn-xs btn-primary">편집하기</a>
<?
}
?>

					</td>
				</tr>
<?php
}
?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
