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