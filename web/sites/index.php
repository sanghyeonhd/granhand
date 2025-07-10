<?php
//ini_set("display_errors", 1);
require_once ("../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_sitet.php";


require_once "$_basedir/inc/config_sitef.php";

$q = "Select * from shop_popup where pid='$g_ar_init[idx]' and sdate<='".date("Y-m-d H:i:s",time())."' and edate>='".date("Y-m-d H:i:s",time())."'";
$st = $pdo->prepare($q);
$st->execute();
while($row = $st->fetch())
{
	if($G_MOBIENV->isMobile())	{
?>
<div id="pop_<?=$row['idx'];?>" style='display:none;position:absolute;width:90%;top:<?=$row['top'];?>px;left:5%;z-index:5000000;'>
	<div style="background-color:#000000">
		<? if($row['videourl']!='') {?>
		<Video src="<?=$row['videourl'];?>" controls autoplay muted width="100%"   />
		<?}else	{?>	
		<? if($row['links']!=''){?><a href="<?=$row['links'];?>"><?}?><img src="<?=$_imgserver;?>/popup/<?=$row['file'];?>" style='width:100%;' /><? if($row['links']!=''){?></a><?}?>
		<?}?>
	</div>
	<div style='width:calc(100% - 20px);background-color:#000000;color:#FFFFFF;height:20px;font-size:12px; padding:10px;  text-align: right;<? if ( $row['isclose'] == 'N' ) { echo "display:none;"; } ?>'><input style="margin:0; vertical-align: bottom;" type='checkbox' onclick="notice_closeWin('pop_<?=$row['idx'];?>')"><a href="javascript:notice_closeWin('pop_<?=$row['idx'];?>');" style='color:#FFFFFF; margin-left: 4px;'><?=trscode("POPUP1");?></a> <a href="javascript:notice_closeWin2('pop_<?=$row['idx'];?>');" style='color:#FFFFFF; margin-left: 4px;'><?=trs("닫기");?></a></div>
</div>
<Script> 
if ( notice_getCookie("pop_<?=$row[idx];?>") != "done1" )
{	
	document.getElementById('pop_<?=$row[idx];?>').style.display = 'block';

}

</script>
<?php
	}
	else	{
?>
<div id="pop_<?=$row['idx'];?>" style='display:none;position:absolute;width:<?=$row['width'];?><? if($ar_init['site_mobile']=='Y') { echo "%";	} else { echo "px";	}?>;height:<?=($row['height']+25);?>px;top:<?=$row['top'];?>px;left:<?=$row['lefts'];?>px;z-index:5000000;'>
	<div style="background-color:#000000">
		<? if($row['videourl']!='') {?>
		<Video src="<?=$row['videourl'];?>" controls autoplay muted style="width:100%;"  />
		<?}else	{?>	
		<? if($row['links']!=''){?><a href="<?=$row['links'];?>"><?}?><img src="<?=$_imgserver;?>/files/popup/<?=$row['file'];?>" style='width:100%;' /><? if($row['links']!=''){?></a><?}?>
		<?}?>
	</div>
	<div style='width:calc(100% - 20px);background-color:#000000;color:#FFFFFF;height:20px;font-size:12px;padding:10px;text-align: right;<? if ( $row['isclose'] == 'N' ) { echo "display:none;"; } ?>'><input style="margin:0; vertical-align: bottom;" type='checkbox' onclick="notice_closeWin('pop_<?=$row['idx'];?>')"><a href="javascript:notice_closeWin('pop_<?=$row['idx'];?>');" style='margin-left: 4px;  color:#FFFFFF;'><?=trscode("POPUP1");?></a> <a href="javascript:notice_closeWin2('pop_<?=$row['idx'];?>');" style='color:#FFFFFF;  margin-left: 4px;'><?=trs("닫기");?></a></div>
</div>
<Script> 
if ( notice_getCookie("pop_<?=$row[idx];?>") != "done1" )
{	
	document.getElementById('pop_<?=$row[idx];?>').style.display = 'block';

}

</script>
<?php
	}
}
?>
