<?php	include "./common/goods_list_q.php";	?>
<?php	include "./common/goods_search.php";	?>
<script language="javascript">
    function show_cnt(index) {
        var h2 = document.body.scrollHeight;
        var h3 = document.documentElement.scrollTop;
        var h5 = document.documentElement.clientHeight;


        $('#blanklay').css('height', h2 + 'px');
        $('#blanklay').css('display', 'block');
        $('#blanklay').css('padding-top:50px');


        var h4 = (80 + h3);

        var htmls = "<div class='pop_window_wide' id='pop' style='width:1024px;height:600px;height:30px;background-color:#FFFFFF;text-align:right;height:20px;margin:" + h4 + "px auto 0  auto;'><div class='pop_title'><a href='javascript:cl_blank();' class='btn_close'>닫기</a></div>";
        htmls = htmls + "<iframe src='/act_lefts?goods_idx=" + index + "' width='1024' height='550' scrolling='yes' style='border:0px;margin:0 auto;'></iframe>";
        $('#blanklay').html(htmls);
    }
    function cl_blank() {
        $('#blanklay').html('');
        $('#blanklay').css('display', 'none');
    }
function set_sell_lefts(goods_idx, op1, op2, op3) {
        hidf.location.href = './set_lt?goods_idx=' + goods_idx + '&op1=' + op1 + '&op2=' + op2 + '&op3=' + op3;
    }
</script>
<style>
/* layer popup */
.pop_wrap {display:none;position:fixed;left:0;top:0;width:100%;height:100%;z-index:100}
.pop_bg {position:absolute;left:0;top:0;width:100%;height:100%;background-color:rgba(0, 0, 0,0.4);      }
.pop_window {display:block;position:absolute;left:50%;top:50%;width:500px;/* margin-left:-250px; */background-color:#f8f8f8}
.pop_title {position:relative;height:36px;padding-left:12px;background-color:#333;color:#fff;font-size:20px;font-weight:bold;line-height:36px}
.pop_title h1 {float:left;height:36px;line-height:36px;font-size:12px;font-weight:bold;letter-spacing:0}
.pop_title .btn_close {position:absolute;right:10px;top:8px;width:20px;height:20px;background:url('../images/btn_pop_close.png') no-repeat 0 0;font-size:0;line-height:0}
.pop_content {padding:15px}
</style>
<iframe name="hidf" style="display:none;"></iframe>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 상품목록</h3>
			</div>
			<div class="panel-content">

				<table class="table table-bordered">
				<thead>
				<tr>
					<th></th>
					<th>번호</th>
					<th>IMG</th>
					<th>상품명</th>
					<th>가격</th>
					<th>상태</th>
					<th>총판매</th>
					<th>옵션1</th>
					<th>옵션2</th>
					<th>옵션3</th>

					<th>주문</th>
					<th>미입금</th>
					<th>판매</th>
					<th>취소</th>
					<th>입고</th>
					<th>발송</th>
					<th>미배송</th>
					<th>재고</th>
					<th>부족</th>
					<th>수거</th>
					<th>위치</th>
					<th>바코드</th>
					<th>소진</th>
					<th>제한</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
<?
$cou = 0;
for($is=0;$is<count($data);$is++){
	$row = $data[$is];
	
	unset($ar_op1);
	unset($ar_opname1);
	unset($ar_op2);
	unset($ar_opname2);
	unset($ar_op3);
	unset($ar_opname3);

	$ar_op1[0] = "";
	$ar_op2[0] = "";
	$ar_op3[0] = "";

	

	 for ($i = 0; $i < sizeof($ar_op1); $i++)	{
		for ($j = 0; $j < sizeof($ar_op2); $j++)	{
			for ($k = 0; $k < sizeof($ar_op3); $k++)	{
?>				
				<tr>
					<? if($i==0 && $j==0 && $k==0) { ?><td rowspan="<?=sizeof($ar_op1)*sizeof($ar_op2)*sizeof($ar_op3);?>"></tD><?}?>
					<? if($i==0 && $j==0 && $k==0) { ?><td rowspan="<?=sizeof($ar_op1)*sizeof($ar_op2)*sizeof($ar_op3);?>"><?=$row['idx'];?></td><?}?>
					<? if($i==0 && $j==0 && $k==0) { ?><td rowspan="<?=sizeof($ar_op1)*sizeof($ar_op2)*sizeof($ar_op3);?>"><img src="<?=$_imgserver;?>/files/goods/<?=$row['simg1'];?>" style="width:60px;"></td><?}?>
					<? if($i==0 && $j==0 && $k==0) { ?><Td rowspan="<?=sizeof($ar_op1)*sizeof($ar_op2)*sizeof($ar_op3);?>"><?=$row['gname'];?></td><?}?>

					<? if($i==0 && $j==0 && $k==0) { ?>
					<td style='text-align:right;' rowspan="<?=sizeof($ar_op1)*sizeof($ar_op2)*sizeof($ar_op3);?>">
						<? if($row['saccount']!=0){?><strike><?=number_format($row['saccount']/100);?></strike><Br><?}?>
						<?=number_format($row['account']/100);?>
					</td>
					<?}?>
					<? if($i==0 && $j==0 && $k==0) { ?>
					<td rowspan="<?=sizeof($ar_op1)*sizeof($ar_op2)*sizeof($ar_op3);?>">
						<span style="color:red">
						<? if($row['isopen']=='2') { echo "<font color='blue'>";	} ?><?=$g_ar_isdan[$row['isopen']];?><? if($row['isopen']=='2') { echo "</font>";	}?><br /><br />
						</span>
						<span  style="color:red">
						<? if($row['isshow']=='Y') { echo "<font color='blue'>";	} ?><?=$g_ar_isshow[$row['isshow']];?><? if($row['isopen']=='Y') { echo "</font>";	}?>	
						</span>
					</td>
					<?}?>
					<td>0</td>
					<td>
						<?
						
						if(is_array($ar_opname1))	{
							echo $ar_opname1[$ar_op1[$i]]['opname'];
						}
						?>
					</td>
					<td>
						<?
						if(is_array($ar_opname1))	{
							echo $ar_opname2[$ar_op2[$j]]['opname'];
						}
						?>
					</td>
					<td>
						<?
						if(is_array($ar_opname3))	{
							echo $ar_opname3[$ar_op3[$k]]['opname'];
						}
						?>
					</td>
					
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>
					<?
					$qs = "SELECT * FROM shop_goods_lefts WHERE goods_idx='$row[idx]' and op1='".$ar_op1[$i]."' and op2='".$ar_op2[$j]."' and op3='".$ar_op3[$k]."'";
					$sts = $pdo->prepare($qs);
					$sts -> execute();
					$rows = $sts->fetch();

					echo number_format($rows['lefts_l']);
					?>
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
					
					</td>
					<td></td>

					<? if($i==0 && $j==0 && $k==0) { ?>

					<td rowspan="<?=sizeof($ar_op1)*sizeof($ar_op2)*sizeof($ar_op3);?>">
						<a href="#none" class="btn btn-xs btn-primary" onclick="show_cnt('<?=$row['idx'];; ?>');">재고조정</a>
					</td>
					<?}?>
				</tr>
<?
			}
		}
	 }
}
?>
				</tbody>
				</table>
				<div style="text-align:center;">
					<ul class="pagination">

					<?=admin_paging($page, $total_record, $se_numper, $page_per_block, $qArr);?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="blanklay">

</div>


<style>
* { margin:0;padding:0;	}
#blanklay { position:absolute;width:100%;height:100%; background-color:rgba(0,0,0,0.4);display:none;z-index:5000;top:0;left:0px;text-align:center;	}
</style>