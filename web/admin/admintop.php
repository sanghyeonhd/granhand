</head>
  <!-- LAYOUT: Apply "submenu-hover" class to body element to have sidebar submenu show on mouse hover -->
  <!-- LAYOUT: Apply "sidebar-collapsed" class to body element to have collapsed sidebar -->
  <!-- LAYOUT: Apply "sidebar-top" class to body element to have sidebar on top of the page -->
  <!-- LAYOUT: Apply "sidebar-hover" class to body element to show sidebar only when your mouse is on left / right corner -->
  <!-- LAYOUT: Apply "submenu-hover" class to body element to show sidebar submenu on mouse hover -->
  <!-- LAYOUT: Apply "fixed-sidebar" class to body to have fixed sidebar -->
  <!-- LAYOUT: Apply "fixed-topbar" class to body to have fixed topbar -->
  <!-- LAYOUT: Apply "rtl" class to body to put the sidebar on the right side -->
  <!-- LAYOUT: Apply "boxed" class to body to have your page with 1200px max width -->

  <!-- THEME STYLE: Apply "theme-sdtl" for Sidebar Dark / Topbar Light -->
  <!-- THEME STYLE: Apply  "theme sdtd" for Sidebar Dark / Topbar Dark -->
  <!-- THEME STYLE: Apply "theme sltd" for Sidebar Light / Topbar Dark -->
  <!-- THEME STYLE: Apply "theme sltl" for Sidebar Light / Topbar Light -->
  
  <!-- THEME COLOR: Apply "color-default" for dark color: #2B2E33 -->
  <!-- THEME COLOR: Apply "color-primary" for primary color: #319DB5 -->
  <!-- THEME COLOR: Apply "color-red" for red color: #C9625F -->
  <!-- THEME COLOR: Apply "color-green" for green color: #18A689 -->
  <!-- THEME COLOR: Apply "color-orange" for orange color: #B66D39 -->
  <!-- THEME COLOR: Apply "color-purple" for purple color: #6E62B5 -->
  <!-- THEME COLOR: Apply "color-blue" for blue color: #4A89DC -->
  <!-- BEGIN BODY -->
<body class="fixed-topbar fixed-sidebar theme-sdtl color-default bg-light-dark">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<section>
	<!-- BEGIN SIDEBAR -->
    <div class="sidebar" style="border-right:1px solid rgb(230, 230, 230);padding:16px;">
		
        <div class="sidebar-inner">
			<div  style="padding:20px;margin-top:32px;">
				<div class="text-[#6f6963] text-sm space-y-2" style="color:#6f6963;font-size:14px;">
					<div class="flex items-center gap-1">
					</div>
					<a href="http://granhand.kro.kr/" target="_BLANK" class="flex items-center gap-2 cursor-pointer hover:underline text-[#5E5955]" style="display:flex;align-items:center;gap:10px;">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
						<span>사이트 바로가기</span>
					</a>
				</div>
			</div>
			<div style="margin-top:32px;padding:16px;margin-bottom:24px;">
				<div class="px-4 py-2 bg-gray-100 rounded">
					<a href="/main.php">
						<div class="flex items-center gap-2 text-[#5E5955] font-bold text-sm" style="display:flex;align-items:center;gap:10px;color:#5E5955;font-size:14px;">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-grid w-4 h-4" aria-hidden="true"><rect width="7" height="7" x="3" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="3" rx="1"></rect><rect width="7" height="7" x="14" y="14" rx="1"></rect><rect width="7" height="7" x="3" y="14" rx="1"></rect>
							</svg>
							<span>HOME</span>
						</div>
					</a>
				</div>
			</div>
			<div class="sidebar-top" style="display:none;">
				
				<div class="userlogged clearfix">
					<i class="icon-user"></i>
					<div class="user-details">
						<h4><?php echo $g_ar_init_member['name'];?></h4>
						<div class="dropdown user-login">
							<button class="btn btn-xs dropdown-toggle btn-rounded" type="button" onclick="location.href='/exec/proc.php?act=member&han=adminlogout';">
							<i class="online"></i><span>LOGOUT</span><i class="fa "></i>
							</button>
							
						</div>
					</div>
				</div>
			</div>
			<!--<div class="menu-title">
				Navigation 
				<div class="pull-right menu-settings">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" data-delay="300"> 
					<i class="icon-settings"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#" id="reorder-menu" class="reorder-menu">Reorder menu</a></li>
						<!--<li><a href="#" id="remove-menu" class="remove-menu">Remove elements</a></li>-->
					<!--	<li><a href="#" id="hide-top-sidebar" class="hide-top-sidebar">Hide user &amp; search</a></li>
					</ul>
				</div>
			</div>-->
			
			<ul class="nav nav-sidebar">
					
					<?php
					$code = "";
					if(isset($_REQUEST['code']))	{
						$code = $_REQUEST['code'];
					}
					parse_str($_SERVER['QUERY_STRING'], $menuout);

				    foreach ($_sidemenu as $key => $val) {
				        $isActive = isset($_menukey[$key]) && $_menukey[$key] === ($g_ar_mcode[0] ?? '') && !empty($g_ar_mcode[0]);
				        if ($isActive) {
				            $g_menu = $key;
				        }
					?>
					<li class="nav-parent <?= $isActive ? 'active' : '' ?>">
						<a href="#"></i>
							<span><?= htmlspecialchars($key) ?></span> <span class="fa arrow"></span>
						</a>
						<ul class="children collapse">
							<?php
							foreach ($val as $submenu) {
								$submenuac = '';
								if (isset($submenu['code']) &&	($submenu['code'] === ($code ?? '') || (isset($submenu['group']) && is_array($submenu['group']) && in_array($code, $submenu['group'])))) {
			                        $g_submenu = $submenu['name'];
									$submenuac = "class='active'";
								}
								if (isset($mckadmin[$submenu['code']]) && $mckadmin[$submenu['code']]) {?>
					                <li <?= $submenuac ?>>
										<a href="subpage.php?code=<?= urlencode($submenu['code']) ?>">
											<?= htmlspecialchars($submenu['name']) ?>
										</a>
									</li>
								<?php
									}
								}
								?>
							</ul>
					</li>
					<?php } ?>
				</ul>
				<!-- SIDEBAR WIDGET FOLDERS -->
				
				<div class="sidebar-widgets">
					
					<ul class="folders" style="display:none;">
						<li>
							<a href="/doc.php?code=doc_main"><i class="icon-doc c-primary"></i>매뉴얼</a> 
						</li>
						
					</ul>
				</div>
			</div>
		</div>
		<!-- END SIDEBAR -->
		<div class="main-content">
			<!-- BEGIN TOPBAR -->
			<div class="topbar" style="display:none;">
				<div class="header-left">
					<div class="topnav">
						<a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
						<ul class="nav nav-icons">
							<li><a href="#" class="toggle-sidebar-top"><span class="icon-user-following"></span></a></li>

						</ul>
					</div>
				</div>
				<div class="header-right">
					<ul class="header-menu nav navbar-nav">
					
						<li><a href="javascript:MM_openBrWindow('popup.php?code=help_sms','sms','scrollbars=yes,width=600,height=600,top=0,left=0');"><i class="icon-envelope-letter" style="margin-top: 18px; margin-right: 8px;"></i>SMS발송</a></li>
						<li><a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top" data-original-title="Fullscreen"><i class="icon-size-fullscreen" style="margin-top: 18px; margin-right: 8px;"></i><span>Fullscreen</span></a></li>
						<li style="margin-right:50px;"><a href="/exec/proc.php?act=member&han=adminlogout"><i class="icon-logout" style="margin-top: 18px; margin-right: 8px;"></i><span>Logout</span></a></li>
					</ul>
				</div>
				<!-- header-right -->
			</div>
			<!-- END TOPBAR -->
			<!-- BEGIN PAGE CONTENT -->
			<div class="page-content">
				