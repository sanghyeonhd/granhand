<?php
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_goods"," WHERE index_no='$index_no'");
$mode = $_REQUEST['mode'];
if($mode=='w')	{
	
	$value['goods_idx'] = $index_no;
	$value['cate'] = $_REQUEST['cate'];
	$value['writer'] = $_REQUEST['writer'];
	$value['memo'] = addslashes($_REQUEST['memo']);
	$value['wdate'] = date("Y-m-d H:i:s");
	insert("shop_areview",$value);

	show_message('등록완료','');
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
}
if($mode=='d')	{
	
	$idx = $_REQUEST['idx'];

	$pdo->prepare("delete from shop_areview where index_no='$idx'")->execute();

	show_message('삭제완료','');
	move_link("$PHP_SELF?code=$code&index_no=$index_no");
}
?>
<script>
function regich(f)	{
	var isok = check_form(f);
	if(isok)	{
		answer = confirm('등록 하시겠습니까?');
		if(answer==true)	{
			return true;
		}
		else	{
			return false;
		}
	}
	else	{
		return false;
	}
}
</script>
<div class="row">
	<div class="col-md-12">
		<div class="m-t-10 m-b-10 no-print"> 
			<a href="<?=$PHP_SELF;?>?code=goods_mod1&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">상품정보수정</a>
			<!-- <a href="<?=$PHP_SELF;?>?code=goods_mod2&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">상세이미지관리</a> -->
			
			<? if($ar_data['gtype']=='1') {	?>
            <a href="<?=$PHP_SELF;?>?code=goods_mod3&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">옵션관리</a>
			
			<?}?>
			<? if($ar_data['gtype']=='2') {	?>
            <a href="<?=$PHP_SELF;?>?code=goods_modsets&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">세트상품관리</a>
			<?}?>
			<a href="<?=$PHP_SELF;?>?code=goods_mod7&index_no=<?=$index_no;?>" class="btn btn-primary m-r-10 m-b-10">관리자리뷰관리</a> 
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
				<h3><i class="fa fa-table"></i> 리뷰등록</h3>
			</div>
			<div class="panel-content">
				<form name="regiform" id="regiform" action="<?=$PHP_SELF;?>?code=<?=$code;?>" method="post" onsubmit="return regich(this);" >
				<input type='hidden' name='mode' value='w'>
				<input type='hidden' name='index_no' value='<?=$index_no;?>'>
				<table class="table table-bordered">
				<colgroup>
					<col width="15%">
					<col width="35%">
					<col width="15%">
					<col width="35%">
				</colgroup>
				<tbody>
				<tr>
					<th>상품명</th>
					<td colspan='3'>
						<?=$ar_data['gname'];?>
					</td>
				</tr>
				<tr>
					<th>구분</th>
					<td colspan='3'>
						<div class="form-inline">
						<select name='cate'>
						<option value=''>선택하세요</option>
						<?php
						$q = "select * from shop_areview_cate";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							echo "<option value='$row[index_no]'>$row[catename]</option>";
						}
						?>
						</select>
						
						<button class="btn btn-primary waves-effect waves-light " type="button" onclick="MM_openBrWindow('popup?code=goods_aewviewc','arevc','width=800,height=800');">분류관리</button>
						</div>
					</td>
				</tr>
				<tr>
					<th>노출작성자</th>
					<td colspan='3'>
						<div class="form-inline">
						<select name='writer'>
						<option value=''>선택하세요</option>
						<?php
						$q = "select * from shop_areview_writer where isdel='N' order by name asc";
						$st = $pdo->prepare($q);
						$st->execute();
						while($row = $st->fetch())	{
							echo "<option value='$row[index_no]'>$row[name]</option>";
						}
						?>
						</select>
						
						<button class="btn btn-primary waves-effect waves-light " type="button" onclick="MM_openBrWindow('popup?code=goods_aewvieww','arevc','width=800,height=800');">작성자관리</button>
						</div>
					</td>
				</tr>
				<tr>
					<th>내용</th>
					<td colspan='3'>
						<textarea name="memo" class="form-control"></textarea>
					</td>
				</tr>
				</tbody>
				</table>
				<div class="form-group row">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-primary waves-effect waves-light btn_submits" type="button" data-form="#regiform">등록하기</button>
						
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
				<h3><i class="fa fa-table"></i> 리뷰목록</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="50px;">
				</colgroup>
				<thead>
				<tr>
					<th>NO</th>
					<th>구분</th>
					<th colspan='2'>작성자</th>
					<th>내용</th>
					<th>등록일</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = "Select * from shop_areview where goods_idx='$index_no' order by wdate asc";
				$st = $pdo->prepare($q);
				$st->execute();
				$cou = 1;
				while($row = $st->fetch())	{
					$ar_c = sel_query_all("shop_areview_cate"," WHERE index_no='$row[cate]'");
					$ar_w = sel_query_all("shop_areview_writer"," WHERE index_no='$row[writer]'");
				?>
				<tr>
					<td><?=$cou;?></tD>
					<td><?=$ar_c['catename'];?></td>
					<td><img src="<?=$_imgserver;?>/files/areview/<?=$ar_w['img'];?>" style="max-width:100px;"></td>
					<td><?=$ar_w['name'];?></td>
					<td><?=nl2br($row['memo']);?></td>
					<td><?=$row['wdate'];?></td>
					<td>
						<a href="#none" onclick="event.preventDefault(); delok('<?=$PHP_SLEF;?>?code=<?=$code;?>&index_no=<?=$index_no;?>&idx=<?=$row['index_no'];?>&mode=d','삭제하시겠습니까?');" class="btn btn-xs btn-primary">삭제</a>
					</td>
				</tr>
				<?
					$cou++;
				}
				?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>