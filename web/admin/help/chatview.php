<?php
$smem_idx = $_REQUEST['smem_idx'];
$ar_mem = sel_query_all("shop_member"," WHERE index_no='$smem_idx'");
?>
<Script>
var nowchatid = '';
$(document).ready(function()	{
	
	get_chatmsg();
});
function gochat_msg()	{
	
	if($("#chat_msg").val()=='')	{
		alert('내용을 입력하세요');
		return;
	}
	var param = $("#chatform").serialize();

	//console.log('/exec/proajax.php?act=chat&han=go_msg&' + param);
	$.getJSON('/exec/proajax.php?act=chat&han=go_msg&' + param, function(result)	{
		//console.log(result);
		if(result.res=='ok')	{
			$("#chat_msg").val('');
		}
		else	{
			alert(result.resmsg);
		}
	});
}
function get_chatmsg()	{
	
	setTimeout(get_chatmsg, 1000);

	$.getJSON('/exec/proajax.php?act=chat&han=rev_msg&smem_idx=<?=$smem_idx;?>&index_no='+nowchatid, function(result)	{
		//console.log(result);
		if(result.res=='ok')	{
			
			var str = "";
			$(result.datas).each(function(index,item)	{
				
				if(item.sides=='3')	{
					str = "<li class='msg"+item.sides+"'><span class='time'>"+item.wtime+"</span><div class='mmsg'>"+item.memo+"</div></li>";
				}
				if(item.sides=='1')	{
					str = "<li class='msg"+item.sides+"'><div class='mmsg'>"+item.memo+"</div><span class='time'>"+item.wtime+"</span></li>";
				}
				nowchatid = item.index_no;
				$("#chat_list").append(str);
				$("#chat_list_wrap").scrollTop($("#chat_list_wrap")[0].scrollHeight);
			});
			


			
		}
		else	{
			alert(result.resmsg);
		}
	});

}
</script>
<Style>
/*chat*/
.chat_btns	{	margin-top:40px;text-align:center;	}
.chat_btns:after {content:'';display:block;clear:both;height:0;	} 
.chat_btns input	{	float:left;display:inline-block;width:70%;height:46px;line-height:44px;border:1px solid #484848;padding-left:20px;color:#cbcbcb;font-size:1.333rem;letter-spacing:-0.02rem;	}
.chat_btns button	{	float:right;display:inline-block;background-color:#f3df00;width:25%;height:46px;border:0;color:#494848;font-weight:500;letter-spacing:-0.02rem;text-align:center;font-weight:500;	}
.msg3	{	text-align:right;padding:0 30px 20px 0;	}
.msg3 .mmsg	{	display:inline-block;font-size:1.333rem;color:#282828;font-weight:500;padding:13px 15px;background-color:#fce72e;line-height:1.6;border-radius:5px;margin-left:10px;max-width:70%;word-break:break-all;	}

.msg1	{	text-align:left;padding:0 0 20px 30px;	}
.msg1 .mmsg	{	display:inline-block;font-size:1.333rem;color:#000000;font-weight:500;padding:13px 15px;background-color:#FFFFFF;line-height:1.6;border-radius:5px;margin-right:10px;max-width:70%;word-break:break-all;	}

#chat_list span.time	{	font-size:1.083rem;color:#282828;letter-spacing:-0.02rem;    vertical-align: bottom;	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 채팅회원</h3>
			</div>
			<div class="panel-content">
				<table class="table table-bordered">
				<colgroup>
					<col width="150px;">
					<col width="*">

				</colgroup>
				<tbody>
				<tr>
					<th>이름</th>
					<Td>
						<?=$ar_mem['name'];?>
					</td>
				</tr>
				</tbody>
				</table>
				
					
			</div>
		</div>
		<!-- end panel -->
	</div>
	<!-- end col-12 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-header">
				<h3><i class="fa fa-table"></i> 채팅내용</h3>
			</div>
			<div class="panel-content">
				<form id="chatform">
				<input type='hidden' name='smem_idx' value='<?=$smem_idx;?>'>
				<div id="chat_list_wrap" style="width:100%;height:420px;background-color:#ececec;width:100%;overflow-y:scroll;overflow-x:hidden;padding-top:20px;">
					<ul	id="chat_list">
		
					</ul>
				</div>
				<div class="chat_btns">
					<input type='text' id='chat_msg' name="memo" placeholder="내용을 입력하세요">
					<button type="button" onclick="gochat_msg();" >전송</button>
				</div>
				</form>
				
					
			</div>
		</div>
		<!-- end panel -->
	</div>
	<!-- end col-12 -->
</div>
