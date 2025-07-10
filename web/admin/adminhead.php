<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="description" content="admin-themes-lab">
<meta name="author" content="themes-lab">
<link rel="shortcut icon" href="<?=$G_FAIMG;?>" type="image/png">
<title><?=$G_ADMINCPNAME;?> ADMIN</title>
<link rel="stylesheet" href="https://unpkg.com/pretendard@latest/dist/web/static/pretendard.css" />
<link href="/assets/global/css/style.css" rel="stylesheet">
<link href="/assets/global/css/theme.css" rel="stylesheet">
<link href="/assets/global/css/ui.css" rel="stylesheet">
<link href="/assets/admin/layout1/css/layout.css" rel="stylesheet">
<link href="/assets/global/css/widget.css" rel="stylesheet">
<script src="/assets/global/plugins/jquery/jquery-1.11.1.min.js"></script>
<script src="/assets/global/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<style>
.mlists th	{
	text-align:center;
	background-color:#F6F4EE !important;
	font-size:12px;
	color:#6F6963;
	font-weight:500;
	border-width: 1px 0px 1px 0px !important;
	border-style: solid !important;
	border-color: #DBD7D0 !important;
}
.mlists td	{
	border-width: 0px 0px 1px 0px !important;
	border-style: solid !important;
	border-color: #DBD7D0 !important;
}
</style>
<script>
$(document).ready(function(){

	$(".btn_submits").on('click', function(e){
		
		e.preventDefault();
		$($(this).data('form')).submit();
	});
});
function delok(url,msg){
	answer = confirm(msg);
	if(answer==true)
	{	location.href=url;	}
}
function MM_openBrWindow(theURL,winName,features){ //v2.0
  window.open(theURL,winName,features);
}

function check_form(f)	{
	var form = $(f);
	console.log(form);
	var isok = true;
	form.find('input[type=text],input[type=file],input[type=checkbox],select,input[type=password],input[type=hidden],textarea').each(function(key){
		var obj = $(this);
		if(obj.attr('valch')=='yes'){

			if(obj.attr('tagName')=='SELECT')
			{
				if(obj.find(':selected').val()=='')	{
					alert(obj.attr('msg'));
					obj.focus();
					isok = false;
					return false;
				}
			}
			else if(obj.attr('type')=='checkbox')	{
				if(!obj.is(':checked'))	{
					alert(obj.attr('msg'));
					obj.focus();
					isok = false;
					return false;
				}
				
			}
			else if(obj.attr('type')=='hidden')	{
				if(obj.val()=='')	{
					alert(obj.attr('msg'));
					isok = false;
					return false;
				}
				
			}
			else if(obj.attr('type')=='textarea')	{
				if(obj.val()=='')	{
					alert(obj.attr('msg'));
					obj.focus();
					isok = false;
					return false;
				}
			}
			else {
				if(obj.val()=='')	{
					alert(obj.attr('msg'));
					obj.focus();
					isok = false;
					return false;
				}
			}
		}
	});
	return isok;
}
function SearchDtdShtnonew(tno, gocom){
	switch(gocom){
		case '로젠택배' :
		case '로젠' :
			url="http://www.ilogen.com/d2d/delivery/invoice_search_popup.jsp?viewType=type1&invoiceNum="+tno;
			break;
		case 'epost' :
		case '우체국' :
		case '우체국택배' :
			url="http://service.epost.go.kr/trace.RetrieveRegiPrclDeliv.postal?sid1="+tno;
			break;
		case '경동' :
		case '경동택배' :
			url="https://www.kdexp.com/rerere.asp?stype=11&p_item="+tno;
			break;
		case 'KG' :
		case 'KG로지스' :
		case 'KG택배' :
			url="http://www.kglogis.co.kr/delivery/delivery_result.jsp";
			var param = { 'item_no' : tno };
			OpenWindowWithPost(url, "width=1100,height=700,status=0,scrollbars=1", "Dtd_KG", param);
			return;
		case '롯데택배' :
			url="https://www.lotteglogis.com/home/personal/inquiry/track";
			var param = { 'InvNo' : tno ,"action" : 'processInvoiceSubmit'};
			OpenWindowWithPost(url, "width=1100,height=700,status=0,scrollbars=1", "lotte", param);
			return;
		case '한진택배' :
			url="https://www.hanjin.co.kr/delivery_html/inquiry/result_waybill.jsp?wbl_num="+tno;
			break;
		default :
			url="https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no="+tno;
	}
	
	window1 = window.open(url,'','width=800,height=600,status=0,scrollbars=1');
}
function OpenWindowWithPost(url, windowoption, name, params) {
 var form = document.createElement("form");
 form.setAttribute("method", "post");
 form.setAttribute("action", url);
 form.setAttribute("target", name);
 for (var i in params)
 {
   if (params.hasOwnProperty(i))
   {
     var input = document.createElement('input');
     input.type = 'hidden';
     input.name = i;
     input.value = params[i];
     form.appendChild(input);
   }
 }
 document.body.appendChild(form);
 //note I am using a post.htm page since I did not want to make double request to the page
 //it might have some Page_Load call which might screw things up.
 window.open("about:blank", name, windowoption);
 form.submit();
 document.body.removeChild(form);
}
function show_member(idx)	{

	if(idx==0)	{
		alert('비회원입니다');
	}
	else	{
		MM_openBrWindow('popup.php?code=help_view&index_no='+idx,'member'+idx,'scrollbars=yes,width=1150,height=900,top=0,left=0');
	}														 
}
</script>
