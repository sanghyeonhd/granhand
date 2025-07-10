<?php
$index_no = $_REQUEST['index_no'];
$ar_data = sel_query_all("shop_goods"," WHERE index_no='$index_no'");
?>
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
			<a href="<?=$PHP_SELF;?>?code=goods_mod7&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">관리자리뷰관리</a> 
            <a href="<?=$PHP_SELF;?>?code=goods_mod4&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">관련상품관리</a>                
            <a href="<?=$PHP_SELF;?>?code=goods_mod5&index_no=<?=$index_no;?>" class="btn btn-primary m-r-10 m-b-10">관련후기상품관리</a>
            <!-- <a href="<?=$PHP_SELF;?>?code=goods_mod6&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">상품사이즈정보관리</a> -->
            <a href="<?=$PHP_SELF;?>?code=goods_mod8&index_no=<?=$index_no;?>" class="btn btn-white m-r-10 m-b-10">상품수정로그</a>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 관련후기상품목록</h3>
			</div>
			<div class="panel-content">


				<table class="table table-bordered">
				<thead>
				<tr>
					<th><input type='checkbox' onclick="set_chk(this);"></th>
					<th> 번호 </th>
					<th> IMG </th>
					<th> 상품명 </th>

					
					<th> 판매가격 </th>
					<th> 판매여부 </th>
					<th> 등록일 </th>

					
					<th></th>
				</tr>
				</thead>
				<tbody>
				
				</tbody>
				</table>
				
			</div>
		</div>
	</div>
</div>
