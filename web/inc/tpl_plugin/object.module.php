<?php

/* BIZHOST 솔루션 공통모듈관련 */

class tpl_object_module {
	
	public $skin_idx = '';
	
	public $skin_name = '';
	
	public $skin_dir = '';
	public $compile_dir = '';
	
	public $module_dir = '/_common';
	
	public $doc_root_dir = '';
	
	public $precompile_dir = '';
	
	//$dpath_or or $basedirs
	function tpl_object_module() {
		global $g_ar_layout, $compile_dir, $template_dir;
;
		
		$this->skin_idx = $ar_layout['index_no'];
		$this->skin_name = $ar_layout['sname'];
		$this->skin_dir = $template_dir;
		$this->compile_dir = $compile_dir;
		$this->doc_root_dir = $_SERVER['DOCUMENT_ROOT'];
	}
	
	function hello()
	{
		//_d($this->skin_dir.$this->module_dir);
		return 'Hello! '.$this->user;
	}
	
	function commonlink($file) {
		$this->module_dir = "/_common";
		return $this->init($file);
	}
	
	function link($file, $type) {
		$base_file = ltrim(trim("{$file}.{$type}"), "/");
		$this->module_dir = "";
		
		return $this->init($base_file);
	}
	
	function init($file) {
		$pinfo = pathinfo($file);
		
		$ar_allowlink = array('css', 'js');
		$type = $pinfo['extension'];
		if (!in_array($type, $ar_allowlink)) {
			return "";
		}
		
		$base_path = $this->module_dir."/".$file;
		
		$absfile = $this->skin_dir.$base_path;
		if (!is_file($absfile)||!filesize($absfile)) {
			return "";
		}
		
		//스킨명 + 프리컴파일할 파일
		$file_hash = sha1($this->skin_name."_".$base_path);
		
		//프리컴파일
		$this->precompile_dir = $this->doc_root_dir."/".$type."/pre/";
		if (!is_dir($this->precompile_dir)) {
			mkdir($this->precompile_dir, 0777, true);
		}
		
		$preurl = "/{$type}/pre/{$file_hash}.{$type}";
		$prefile = $this->precompile_dir.$file_hash.".".$type;
		
		/* 관리자 수정시 즉각 반영 로직 (캐싱 구현 할 수 있음) */
		$is_precompile = false;
		if (!is_file($prefile)) {
			//잔소리말고 생성
			$is_precompile = true;
		} else {
			//시간비교 후 생성
			$preinfo = stat($prefile);
			$baseinfo = stat($absfile);
			if ($preinfo['mtime'] != $baseinfo['mtime']) {
				$is_precompile = true;
			}
		}
		
		if ($is_precompile) {
			if(false === $this->precompile($base_path, $prefile))
            {
                die("precompile failed");
            }
			$precompile_time = time();
			@touch($prefile, $precompile_time);
			@touch($absfile, $precompile_time);
		}
		
		//수정시 브라우져 캐쉬 방지
		if ($precompile_time) {
			$preurl .= "?{$precompile_time}";
		} else {
			$preurl .= "?{$preinfo[mtime]}";
		}
		
		if ('js' == $type) {
			return "<script src=\"{$preurl}\" charset=\"utf-8\"></script>";
		} else {
			return "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$preurl}\">";
		}
	}
	
	function precompile($base_path, $prefile) {
		global $tem_global;

		$tpl = new Template_;

		$vars['precompile'] = $base_path;

		//프리 컴파일 정보 셋팅!
		$tpl->define($vars, '', $this->compile_dir, $this->skin_dir);

		$tpl->assign('global', $tem_global);

		$prebody = $tpl->fetch('precompile');
		unset($tpl);

		_d($base_path." precompiled!!");
		if (file_put_contents($prefile, $prebody)) {
			return true;
		} else {
			return false;
		}
	}

}
