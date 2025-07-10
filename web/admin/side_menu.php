<?php
$_menukey['회원관리'] = "help";
$_menukey['쇼핑몰설정'] = "config";
$_menukey['상품관리'] = "goods";
$_menukey['컨텐츠관리'] = "sellcfg";
$_menukey['주문/배송관리'] = "order";
$_menukey['재고관리'] = "stock";
$_menukey['디자인관리'] = "design";
$_menukey['통계관리'] = "stat";
$_menukey['관리자관리'] = "group";
$_menukey['컨텐츠관리'] = "sho";

$_menuicon['쇼핑몰설정'] = "icon-settings";
$_menuicon['상품관리'] = "icon-handbag";
$_menuicon['컨텐츠관리'] = "icon-picture";
$_menuicon['주문/배송관리'] = "icon-basket";
$_menuicon['재고관리'] = "icon-grid";
$_menuicon['회원관리'] = "icon-earphones-alt";
$_menuicon['디자인관리'] = "icon-vector";
$_menuicon['통계관리'] = "icon-graph";
$_menuicon['관리자관리'] = "icon-cup";
$_menuicon['컨텐츠관리'] = "icon-calendar";


$admin_menu['help'] = '회원관리';
$admin_menu['config'] = '쇼핑몰설정';
$admin_menu['goods'] = '상품관리';
$admin_menu['sellcfg'] = '컨텐츠관리';
$admin_menu['order'] = '주문/배송관리';
$admin_menu['stock'] = '재고관리';
$admin_menu['design'] = '디자인관리';
$admin_menu['stat'] = '통계관리';
$admin_menu['group'] = '관리자관리';
$admin_menu['sho'] = '컨텐츠관리';


//$_sidemenu['회원관리'][] = array('name'=>'SBJ목록', 'code'=>'help_sbjlist');
$_sidemenu['회원관리'][] = array('name'=>'회원목록', 'code'=>'help_list');
$_sidemenu['회원관리'][] = array('name'=>'회원등급변동내역', 'code'=>'help_chlog','group'=>array('help_chlogv'));
$_sidemenu['회원관리'][] = array('name'=>'적립금적립내역', 'code'=>'help_pointlist');
$_sidemenu['회원관리'][] = array('name'=>'쿠폰관리', 'code'=>'help_coupen','group'=>array('help_coupenw','help_coupenm'));
$_sidemenu['회원관리'][] = array('name'=>'쿠폰배포', 'code'=>'help_coupengive','group'=>array('help_coupengivew','help_coupengivev'));

$_sidemenu['회원관리'][] = array('name'=>'푸쉬발송', 'code'=>'help_smsall','group'=>array('help_smsallw','help_smsallm'));
//_sidemenu['회원관리'][] = array('name'=>'문의내역', 'code'=>'help_contact');
//$_sidemenu['회원관리'][] = array('name'=>'예수금환불내역', 'code'=>'help_bousts3');



$_sidemenu['쇼핑몰설정'][] = array('name'=>'운영사이트설정','name'=>'운영사이트설정', 'code'=>'config_sites','group'=>array('config_sitesm'));
$_sidemenu['쇼핑몰설정'][] = array('name'=>'회원관련설정', 'code'=>'config_member','group'=>array('config_memberw','config_memberm'));
$_sidemenu['쇼핑몰설정'][] = array('name'=>'통화설정', 'code'=>'config_lc');
$_sidemenu['쇼핑몰설정'][] = array('name'=>'상품관련설정', 'code'=>'config_goods');
$_sidemenu['쇼핑몰설정'][] = array('name'=>'상품분류설정', 'code'=>'config_buns','group'=>array('config_bunsm'));

//$_sidemenu['쇼핑몰설정'][] = array('name'=>'결제수단설정', 'code'=>'config_pay');
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'배송관련설정', 'code'=>'config_dels');
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'IP접속제한설정', 'code'=>'config_ips');
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'문자메크로설정', 'code'=>'config_smsm');
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'상황별문자설정', 'code'=>'config_msmcfg');
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'질문과답변설정', 'code'=>'config_qna');
$_sidemenu['쇼핑몰설정'][] = array('name'=>'질문과답변분류설정', 'code'=>'config_qnacate','group'=>array('config_qnacatew','config_qnacatem'));
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'입출고구분설정', 'code'=>'config_inout');
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'교환/반품구분설정', 'code'=>'config_rc');
//$_sidemenu['쇼핑몰설정'][] = array('name'=>'주문메모구분설정', 'code'=>'config_cs');


$_sidemenu['상품관리'][] = array('name'=>'카테고리관리', 'code'=>'goods_cate','group'=>array('goods_catew'));
$_sidemenu['상품관리'][] = array('name'=>'상품목록', 'code'=>'goods_list','group'=>array('goods_mod1','goods_mod2','goods_mod3','goods_mod4','goods_mod5','goods_mod6','goods_mod7','goods_mod8','goods_modsets'));
$_sidemenu['상품관리'][] = array('name'=>'상품등록', 'code'=>'goods_regi');
$_sidemenu['상품관리'][] = array('name'=>'상품일괄등록', 'code'=>'goods_allregi','group'=>array('goods_allregiw'));
//$_sidemenu['상품관리'][] = array('name'=>'일괄상품관리', 'code'=>'goods_listall');
$_sidemenu['상품관리'][] = array('name'=>'엑셀일괄관리', 'code'=>'goods_excel','group'=>array('goods_excelnext'));
//$_sidemenu['상품관리'][] = array('name'=>'태그관리', 'code'=>'goods_tags');



//$_sidemenu['상품관리'][] = array('name'=>'상품품절현황', 'code'=>'goods_soldout');
$_sidemenu['상품관리'][] = array('name'=>'상품정보변경내역', 'code'=>'goods_change');

//*$_sidemenu['상품관리'][] = array('name'=>'거래처메모', 'code'=>'goods_inshopsm');
//*$_sidemenu['상품관리'][] = array('name'=>'브랜드/제조사관리', 'code'=>'goods_brma');

//$_sidemenu['상품관리'][] = array('name'=>'상품/배너컨텐츠관리', 'code'=>'goods_main','group'=>array('goods_mainbanner','goods_maingoods','goods_mainhtml','goods_maincont'));
//$_sidemenu['상품관리'][] = array('name'=>'카테고리컨텐츠관리', 'code'=>'goods_cateorder');
$_sidemenu['상품관리'][] = array('name'=>'상품공통정보관리', 'code'=>'goods_gens','group'=>array('goods_gensw','goods_gensm'));
//$_sidemenu['상품관리'][] = array('name'=>'판매혜택설정', 'code'=>'goods_gives','group'=>array('goods_givesw','goods_givesm'));
$_sidemenu['상품관리'][] = array('name'=>'할인관리', 'code'=>'goods_sale','group'=>array('goods_salew','goods_salem','goods_saleg'));
$_sidemenu['상품관리'][] = array('name'=>'거래처관리', 'code'=>'goods_inshops','group'=>array('goods_inshopsm','goods_inshopsw'));
$_sidemenu['상품관리'][] = array('name'=>'브랜드관리', 'code'=>'goods_bma');
$_sidemenu['상품관리'][] = array('name'=>'제조사관리', 'code'=>'goods_maker');


//$_sidemenu['컨텐츠관리'][] = array('name'=>'이벤트관리', 'code'=>'sellcfg_event','group'=>array('sellcfg_eventw','sellcfg_eventm','sellcfg_eventg','sellcfg_eventt'));
//$_sidemenu['컨텐츠관리'][] = array('name'=>'기획전관리', 'code'=>'sellcfg_plan','group'=>array('sellcfg_planw','sellcfg_planm','sellcfg_plang','sellcfg_plant'));

//$_sidemenu['컨텐츠관리'][] = array('name'=>'MDPICK관리', 'code'=>'sellcfg_mdpick','group'=>array('sellcfg_mdpickw','sellcfg_mdpickm'));
//$_sidemenu['컨텐츠관리'][] = array('name'=>'카테고리베스트관리', 'code'=>'sellcfg_cateorder');


$_sidemenu['주문/배송관리'][] = array('name'=>'주문목록', 'code'=>'order_list');
$_sidemenu['주문/배송관리'][] = array('name'=>'수거중목록', 'code'=>'order_returning');
$_sidemenu['주문/배송관리'][] = array('name'=>'수기배송처리', 'code'=>'order_gotoman','group'=>array('order_gotomanex'));
$_sidemenu['주문/배송관리'][] = array('name'=>'일괄배송처리', 'code'=>'order_goprocess','group'=>array('order_goprocessnext'));
$_sidemenu['주문/배송관리'][] = array('name'=>'취소/반품요청', 'code'=>'order_returnlist');
$_sidemenu['주문/배송관리'][] = array('name'=>'주문환불내역[현금]', 'code'=>'order_bousts1');
$_sidemenu['주문/배송관리'][] = array('name'=>'주문환불내역[기타]', 'code'=>'order_bousts2');
//$_sidemenu['주문/배송관리'][] = array('name'=>'입금확인', 'code'=>'order_incheck');
//$_sidemenu['주문/배송관리'][] = array('name'=>'주문서생성', 'code'=>'order_make');
//$_sidemenu['주문/배송관리'][] = array('name'=>'송장생성', 'code'=>'order_makepaper');
//$_sidemenu['주문/배송관리'][] = array('name'=>'송장출력', 'code'=>'order_printpaper');
//$_sidemenu['주문/배송관리'][] = array('name'=>'배송처리', 'code'=>'order_progo');
//$$_sidemenu['주문/배송관리'][] = array('name'=>'스캔내역확인', 'code'=>'order_scans');
//$_sidemenu['주문/배송관리'][] = array('name'=>'수기배송처리', 'code'=>'order_gomanual');
//$_sidemenu['주문/배송관리'][] = array('name'=>'배송내역확인', 'code'=>'order_golist');
//$_sidemenu['주문/배송관리'][] = array('name'=>'반품처리', 'code'=>'order_return');
//$_sidemenu['주문/배송관리'][] = array('name'=>'반품신청목록', 'code'=>'order_returnlist');

$_sidemenu['재고관리'][] = array('name'=>'상품현황', 'code'=>'stock_status');
$_sidemenu['재고관리'][] = array('name'=>'현재고현황', 'code'=>'stock_stock');
//$_sidemenu['재고관리'][] = array('name'=>'창고지관리', 'code'=>'stock_warehouse');
//$_sidemenu['재고관리'][] = array('name'=>'재고조사', 'code'=>'stock_subvey');
//$_sidemenu['재고관리'][] = array('name'=>'입출고처리', 'code'=>'stock_inout','group'=>array('stock_inoutnext'));
//$_sidemenu['재고관리'][] = array('name'=>'입출고현황', 'code'=>'stock_inoutstatus','group'=>array('stock_inoutde'));



//$_sidemenu['컨텐츠관리'][] = array('name'=>'추천검색어관리', 'code'=>'sho_keywotds');
$_sidemenu['컨텐츠관리'][] = array('name'=>'상품/배너 배치관리', 'code'=>'sho_main','group'=>array('sho_mainbanner','sho_maingoods','sho_mainhtml','sho_maincont','sho_maincontw','sho_maincontm'));
$_sidemenu['컨텐츠관리'][] = array('name'=>'저널관리', 'code'=>'sho_journal','group'=>array('sho_journalw','sho_journalm'));
$_sidemenu['컨텐츠관리'][] = array('name'=>'이벤트관리', 'code'=>'sho_event','group'=>array('sho_eventw','sho_eventm'));
$_sidemenu['컨텐츠관리'][] = array('name'=>'스토어관리', 'code'=>'sho_store','group'=>array('sho_storew','sho_storem'));
$_sidemenu['컨텐츠관리'][] = array('name'=>'지주묻는질문관리', 'code'=>'sho_faq','group'=>array('sho_faqw','sho_faqm'));
$_sidemenu['컨텐츠관리'][] = array('name'=>'향가이드관리', 'code'=>'sho_guide','group'=>array('sho_guidew','sho_guidem'));
//$_sidemenu['컨텐츠관리'][] = array('name'=>'게시판관리', 'code'=>'sho_board','group'=>array('sho_boardw','sho_boardm'));


//$_sidemenu['컨텐츠관리'][] = array('name'=>'게시판관리', 'code'=>'sho_board','group'=>array('sho_boardw','sho_boardm'));
//$_sidemenu['컨텐츠관리'][] = array('name'=>'게시판글관리', 'code'=>'sho_bbslist','group'=>array('sho_bbslistw','sho_bbslistm'));





//$_sidemenu['디자인관리'][] = array('name'=>'도메인설정', 'code'=>'design_domain');
//$_sidemenu['디자인관리'][] = array('name'=>'스킨/레이아웃관리', 'code'=>'design_layout');
//$_sidemenu['디자인관리'][] = array('name'=>'아이콘설정', 'code'=>'design_icon');
$_sidemenu['디자인관리'][] = array('name'=>'팝업관리', 'code'=>'design_popup','group'=>array('design_popupw','design_popupm'));
$_sidemenu['디자인관리'][] = array('name'=>'번역관리[단어]', 'code'=>'design_trans');
$_sidemenu['디자인관리'][] = array('name'=>'번역관리[문장]', 'code'=>'design_transsc');

$_sidemenu['통계관리'][] = array('name'=>'통계요약', 'code'=>'stat_sum');
$_sidemenu['통계관리'][] = array('name'=>'주문통계', 'code'=>'stat_order');
$_sidemenu['통계관리'][] = array('name'=>'매출통계', 'code'=>'stat_acc');
$_sidemenu['통계관리'][] = array('name'=>'상품조회통계', 'code'=>'stat_goodsread');
$_sidemenu['통계관리'][] = array('name'=>'상품판매통계', 'code'=>'stat_goodssell');
$_sidemenu['통계관리'][] = array('name'=>'장바구니현황', 'code'=>'stat_cart1');
$_sidemenu['통계관리'][] = array('name'=>'장바구니통계', 'code'=>'stat_cart2');
$_sidemenu['통계관리'][] = array('name'=>'위시리스트현황', 'code'=>'stat_wish1');
$_sidemenu['통계관리'][] = array('name'=>'위시리스트통계', 'code'=>'stat_wish2');
$_sidemenu['통계관리'][] = array('name'=>'회원가입통계', 'code'=>'stat_member');
$_sidemenu['통계관리'][] = array('name'=>'검색어통계', 'code'=>'stat_search');
$_sidemenu['통계관리'][] = array('name'=>'방문자통계', 'code'=>'stat_visit');


$_sidemenu['관리자관리'][] = array('name'=>'관리자권한관리', 'code'=>'group_adminpriv','group'=>array('group_adminprivv'));
$_sidemenu['관리자관리'][] = array('name'=>'관리자관리', 'code'=>'group_admin','group'=>array('group_adminw'));
?>

