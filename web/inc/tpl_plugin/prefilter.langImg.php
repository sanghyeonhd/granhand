<?php
function langImg($source, $tpl, $lang='ko', $indicator = '')
{
	$default_indicator = 'gif,jpg,jpeg,png';
	$path_filter = array();

	if ('ko' != $lang) {
		$path_filter = array('/^({global.imglang}.*)\.(jpg|jpeg|png|gif)$/'=>"$1_{$lang}.$2");		
	}

	#$document_root = $_SERVER['DOCUMENT_ROOT']; 

	if (!$indicator || $indicator==='default') $indicator=$default_indicator;
	if (!$indicator=str_replace(',', '|', preg_replace('/^,\s*|\s*,$/', '', $indicator))) return $source;

	$Dot='(?<=url\()\\\\*\./(?:(?:[^)/]+/)*[^)/]+)?(?=\))'.
		'|(?<=")\\\\*\./(?:(?:[^"/]+/)*[^"/]+)?(?=")'.
		"|(?<=')\\\\*\./(?:(?:[^'/]+/)*[^'/]+)?(?=')".
		'|(?<=\\\\")\\\\*\./(?:(?:[^"/]+/)*[^"/]+)?(?=\\\\")'.
		"|(?<=\\\\')\\\\*\./(?:(?:[^'/]+/)*[^'/]+)?(?=\\\\')";
	$Ext= $indicator[0]==='.' ? substr($indicator,2) : $indicator;
	$Ext='(?<=url\()(?:[^"\')/]+/)*[^"\')/]+\.(?:'.$Ext.')(?=\))'.
		'|(?<=")(?:[^"/]+/)*[^"/]+\.(?:'.$Ext.')(?=")'.
		"|(?<=')(?:[^'/]+/)*[^'/]+\.(?:".$Ext.")(?=')".
		'|(?<=\\\\")(?:[^"/]+/)*[^"/]+\.(?:'.$Ext.')(?=\\\\")'.
		"|(?<=\\\\')(?:[^'/]+/)*[^'/]+\.(?:".$Ext.")(?=\\\\')";
	if ($indicator==='.') $pattern=$Dot;
	else $pattern= $indicator[0]==='.' ? $Ext.'|'.$Dot : $Ext;
	$pattern='@('.$pattern.')@ixU';
	$split=preg_split($pattern, $source, -1, PREG_SPLIT_DELIM_CAPTURE);

	$path_search =array_keys($path_filter);
	$path_replace=array_values($path_filter);

	for ($i=1,$s=count($split); $i<$s; $i+=2) {
		if (substr($split[$i], 0, 1)==='\\') {
			$split[$i]=substr($split[$i],1);
			continue;
		}

		if ($path_search) $split[$i]=preg_replace($path_search, $path_replace, $split[$i]);
	}
	return implode('', $split);
}
?>