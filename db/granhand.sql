-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- 생성 시간: 25-07-10 20:08
-- 서버 버전: 5.7.40-0ubuntu0.18.04.1-log
-- PHP 버전: 7.2.24-0ubuntu0.18.04.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `granhand`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `sessions`
--

CREATE TABLE `sessions` (
  `sesskey` varchar(40) NOT NULL DEFAULT '',
  `expiry` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_action_reason`
--

CREATE TABLE `shop_action_reason` (
  `idx` int(10) UNSIGNED NOT NULL,
  `rtype` char(1) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `isuse` char(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_admin_config`
--

CREATE TABLE `shop_admin_config` (
  `idx` int(10) UNSIGNED NOT NULL,
  `stat_add_dong` char(1) NOT NULL COMMENT '관리자에서 매출통계 노출시 동봉내역 노출여부',
  `use_oversea` char(1) NOT NULL COMMENT '해외사이트 운영여부',
  `use_overdoae` char(1) NOT NULL COMMENT '도매사이트운영여부',
  `use_goods_templete` char(1) NOT NULL COMMENT '상품정보고시템플릿사용여부',
  `usescm` char(1) NOT NULL COMMENT 'SCM 입점형 기능 사용여부',
  `deldate` char(10) NOT NULL COMMENT '배송마감일',
  `useetcpage` char(1) NOT NULL COMMENT '디자인관리에서 기타페이지 사용여부',
  `usedelayops` char(1) NOT NULL COMMENT '배송지연옵션별설정여부',
  `uselistcate` char(1) NOT NULL,
  `uselistop` char(1) NOT NULL,
  `iscan` char(1) NOT NULL COMMENT '관리자 로그인 가능여부N접속불가',
  `csout` varchar(30) NOT NULL COMMENT '카페24CS 센터 이용할경우 카페24 접속 API',
  `catelen` char(1) NOT NULL,
  `process_last` char(1) NOT NULL COMMENT '주문처리시과거주문처리여부 N 처리안함 ',
  `barcode_pt` char(1) NOT NULL COMMENT '바코드 출력시 거래처 단위로 출력 여부',
  `isviewnew` char(1) NOT NULL COMMENT '관리자 주문서 화면 새버젼 사용여부',
  `nogive_print` char(1) NOT NULL COMMENT '송장생성시 할당해서 출력 여부',
  `lasttype` varchar(10) NOT NULL COMMENT '마지막주문종류',
  `newsale` char(1) NOT NULL COMMENT '세일관리새버젼여부',
  `lstedit` char(1) NOT NULL COMMENT '고시,검색데이터상품목록에서편집',
  `usesagpoint` char(1) NOT NULL COMMENT '상품사은품포인트사용여부',
  `fastdels` char(1) NOT NULL DEFAULT 'Y' COMMENT '급배송등록리셋여부'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_admin_grade`
--

CREATE TABLE `shop_admin_grade` (
  `idx` int(10) UNSIGNED NOT NULL,
  `grade_id` int(11) NOT NULL COMMENT '관리자 등급 아이디',
  `grade_name` varchar(30) NOT NULL COMMENT '관리자 등급 이름'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_admin_grade`
--

INSERT INTO `shop_admin_grade` (`idx`, `grade_id`, `grade_name`) VALUES
(1, 1, '최고관리자');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_admin_priv`
--

CREATE TABLE `shop_admin_priv` (
  `idx` int(10) UNSIGNED NOT NULL,
  `grade_id` int(10) UNSIGNED NOT NULL COMMENT '관리자 등급 아이디',
  `menu_name` varchar(100) NOT NULL COMMENT '접근가능 메뉴명',
  `dir` varchar(50) NOT NULL COMMENT '접근가능 메뉴의 라우팅경로',
  `code` varchar(50) NOT NULL COMMENT '관리자 메뉴 코드',
  `tp` char(1) NOT NULL COMMENT '업데이트를 위한 임시코드'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_admin_priv`
--

INSERT INTO `shop_admin_priv` (`idx`, `grade_id`, `menu_name`, `dir`, `code`, `tp`) VALUES
(1, 1, '관리자메인', 'index', 'main1', ''),
(914, 1, '주문금액변경', 'index', 'chbasket', ''),
(915, 1, '회원목록', '', 'help_list', ''),
(916, 1, '회원등급변동내역', '', 'help_chlog', ''),
(917, 1, '적립금적립내역', '', 'help_pointlist', ''),
(918, 1, '쿠폰관리', '', 'help_coupen', ''),
(919, 1, '쿠폰배포', '', 'help_coupengive', ''),
(920, 1, '푸쉬발송', '', 'help_smsall', ''),
(921, 1, '운영사이트설정', '', 'config_sites', ''),
(922, 1, '회원관련설정', '', 'config_member', ''),
(923, 1, '통화설정', '', 'config_lc', ''),
(924, 1, '상품관련설정', '', 'config_goods', ''),
(925, 1, '상품분류설정', '', 'config_buns', ''),
(926, 1, '질문과답변분류설정', '', 'config_qnacate', ''),
(927, 1, '카테고리관리', '', 'goods_cate', ''),
(928, 1, '상품목록', '', 'goods_list', ''),
(929, 1, '상품등록', '', 'goods_regi', ''),
(930, 1, '상품일괄등록', '', 'goods_allregi', ''),
(931, 1, '엑셀일괄관리', '', 'goods_excel', ''),
(932, 1, '상품정보변경내역', '', 'goods_change', ''),
(933, 1, '상품공통정보관리', '', 'goods_gens', ''),
(934, 1, '할인관리', '', 'goods_sale', ''),
(935, 1, '거래처관리', '', 'goods_inshops', ''),
(936, 1, '브랜드관리', '', 'goods_bma', ''),
(937, 1, '제조사관리', '', 'goods_maker', ''),
(938, 1, '주문목록', '', 'order_list', ''),
(939, 1, '수거중목록', '', 'order_returning', ''),
(940, 1, '수기배송처리', '', 'order_gotoman', ''),
(941, 1, '일괄배송처리', '', 'order_goprocess', ''),
(942, 1, '취소/반품요청', '', 'order_returnlist', ''),
(943, 1, '주문환불내역[현금]', '', 'order_bousts1', ''),
(944, 1, '주문환불내역[기타]', '', 'order_bousts2', ''),
(945, 1, '상품현황', '', 'stock_status', ''),
(946, 1, '현재고현황', '', 'stock_stock', ''),
(947, 1, '상품/배너 배치관리', '', 'sho_main', ''),
(948, 1, '저널관리', '', 'sho_journal', ''),
(949, 1, '이벤트관리', '', 'sho_event', ''),
(950, 1, '스토어관리', '', 'sho_store', ''),
(951, 1, '지주묻는질문관리', '', 'sho_faq', ''),
(952, 1, '향가이드관리', '', 'sho_guide', ''),
(953, 1, '팝업관리', '', 'design_popup', ''),
(954, 1, '번역관리[단어]', '', 'design_trans', ''),
(955, 1, '번역관리[문장]', '', 'design_transsc', ''),
(956, 1, '통계요약', '', 'stat_sum', ''),
(957, 1, '주문통계', '', 'stat_order', ''),
(958, 1, '매출통계', '', 'stat_acc', ''),
(959, 1, '상품조회통계', '', 'stat_goodsread', ''),
(960, 1, '상품판매통계', '', 'stat_goodssell', ''),
(961, 1, '장바구니현황', '', 'stat_cart1', ''),
(962, 1, '장바구니통계', '', 'stat_cart2', ''),
(963, 1, '위시리스트현황', '', 'stat_wish1', ''),
(964, 1, '위시리스트통계', '', 'stat_wish2', ''),
(965, 1, '회원가입통계', '', 'stat_member', ''),
(966, 1, '검색어통계', '', 'stat_search', ''),
(967, 1, '방문자통계', '', 'stat_visit', ''),
(968, 1, '관리자권한관리', '', 'group_adminpriv', ''),
(969, 1, '관리자관리', '', 'group_admin', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_ads`
--

CREATE TABLE `shop_ads` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(11) NOT NULL,
  `newcont_idx` int(11) NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memo` longtext CHARACTER SET utf8mb4 NOT NULL,
  `wdate` datetime NOT NULL,
  `img1` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img2` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `homepage` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_ads_read`
--

CREATE TABLE `shop_ads_read` (
  `idx` int(10) UNSIGNED NOT NULL,
  `ads_idx` int(11) NOT NULL,
  `rdate` date NOT NULL,
  `rtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_ads_show`
--

CREATE TABLE `shop_ads_show` (
  `idx` int(10) UNSIGNED NOT NULL,
  `ads_idx` int(11) NOT NULL,
  `sdate` date NOT NULL,
  `stime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after`
--

CREATE TABLE `shop_after` (
  `idx` int(10) UNSIGNED NOT NULL,
  `btype` char(1) NOT NULL,
  `reviewcate` tinyint(3) UNSIGNED NOT NULL,
  `wmode` char(1) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `lan` varchar(10) NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `mem_name` varchar(30) NOT NULL,
  `mem_id` varchar(30) NOT NULL,
  `mem_nick` varchar(30) NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `subject` varchar(250) NOT NULL,
  `hfile` char(1) NOT NULL,
  `memo` longtext NOT NULL,
  `wdate` datetime NOT NULL,
  `revdate` datetime NOT NULL,
  `score` int(10) UNSIGNED NOT NULL,
  `firstgive` char(1) NOT NULL,
  `firstgivet` char(1) NOT NULL,
  `firstgiveac` int(11) NOT NULL,
  `readcount` int(10) UNSIGNED NOT NULL,
  `tailcount` int(10) UNSIGNED NOT NULL,
  `wip` varchar(30) NOT NULL,
  `addgive` char(1) NOT NULL,
  `addgivet` char(1) NOT NULL,
  `addgiveac` int(10) UNSIGNED NOT NULL,
  `passwds` int(11) NOT NULL,
  `file1` varchar(100) NOT NULL,
  `file2` varchar(100) NOT NULL,
  `file3` varchar(100) NOT NULL,
  `file4` varchar(100) NOT NULL,
  `file5` varchar(100) NOT NULL,
  `isshow` char(1) NOT NULL DEFAULT 'Y',
  `isdel` char(1) NOT NULL DEFAULT 'N',
  `market_idx` int(10) UNSIGNED NOT NULL COMMENT '관련주문서',
  `basket_idx` int(10) UNSIGNED NOT NULL,
  `wrlink` char(1) NOT NULL COMMENT '링크클릭작성여부',
  `last_idx` int(10) UNSIGNED NOT NULL,
  `last_idx1` int(10) UNSIGNED NOT NULL,
  `last_idx2` int(10) UNSIGNED NOT NULL,
  `wmd` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after_base`
--

CREATE TABLE `shop_after_base` (
  `idx` int(10) UNSIGNED NOT NULL,
  `cate_idx` int(10) UNSIGNED NOT NULL,
  `basename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `basetype` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `basedata` text CHARACTER SET utf8mb4 NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `isuse` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after_cate`
--

CREATE TABLE `shop_after_cate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `strlen` int(10) UNSIGNED NOT NULL,
  `strmsg` text CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after_config`
--

CREATE TABLE `shop_after_config` (
  `idx` int(10) UNSIGNED NOT NULL,
  `usecates` text NOT NULL COMMENT '운영카테고리',
  `fid` int(10) UNSIGNED NOT NULL,
  `lan` varchar(10) NOT NULL,
  `gwrite` char(1) NOT NULL COMMENT '상품상세페이지에서 글작성허용',
  `buywrite` char(1) NOT NULL COMMENT '구매상품만 후기작성가능',
  `writepriv` char(1) NOT NULL,
  `loginwrite` char(1) NOT NULL COMMENT '로그인시 후기 작성페이지로 이동여부',
  `listnum` int(10) UNSIGNED NOT NULL,
  `newicon_day` tinyint(3) UNSIGNED NOT NULL,
  `file1` varchar(50) NOT NULL,
  `file2` varchar(50) NOT NULL,
  `file3` varchar(50) NOT NULL,
  `tailpriv` char(1) NOT NULL,
  `tailprivs` varchar(250) NOT NULL,
  `usesms` char(1) NOT NULL,
  `uselms` char(1) NOT NULL COMMENT 'LMS사용여부',
  `usesmstimek` char(1) NOT NULL COMMENT '문자바발송시간1:항시 2:지정',
  `usesmstimev` tinyint(3) UNSIGNED NOT NULL COMMENT '문자발송 시간지정시 지정시간',
  `usesmemo` text NOT NULL,
  `smsdays` int(10) UNSIGNED NOT NULL,
  `remind_usesms` char(1) NOT NULL COMMENT '장바구니리마인드 문자발송여부',
  `remind_uselms` char(1) NOT NULL COMMENT '리마인드LSM사용여부',
  `remind_days` tinyint(3) UNSIGNED NOT NULL COMMENT '리마인드발송타임',
  `remind_time` tinyint(3) UNSIGNED NOT NULL COMMENT '리마인드발송시간',
  `remind_short` varchar(50) NOT NULL,
  `sms_return` varchar(30) NOT NULL,
  `usermemo` text NOT NULL COMMENT '문자내용',
  `usesub` char(1) NOT NULL,
  `after_give` varchar(200) NOT NULL COMMENT '리뷰혜택내용',
  `submemo` text NOT NULL,
  `search_num` int(10) UNSIGNED NOT NULL,
  `userev` char(1) NOT NULL,
  `usescore` char(1) NOT NULL COMMENT '평점사용여부',
  `usewriter` varchar(20) NOT NULL COMMENT '사용작성자',
  `usewriter_cou` int(10) UNSIGNED NOT NULL COMMENT '작성자노출'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after_img`
--

CREATE TABLE `shop_after_img` (
  `idx` int(10) UNSIGNED NOT NULL,
  `after_idx` int(10) UNSIGNED NOT NULL,
  `imgname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after_like`
--

CREATE TABLE `shop_after_like` (
  `idx` int(10) UNSIGNED NOT NULL,
  `memtocken` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `after_idx` int(11) NOT NULL,
  `checks` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after_tags`
--

CREATE TABLE `shop_after_tags` (
  `idx` int(10) UNSIGNED NOT NULL,
  `after_idx` int(10) UNSIGNED NOT NULL,
  `tags_idx` int(10) UNSIGNED NOT NULL,
  `datas` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_after_tail`
--

CREATE TABLE `shop_after_tail` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` mediumint(8) UNSIGNED NOT NULL,
  `after_idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `mem_wname` varchar(50) NOT NULL,
  `mem_name` varchar(50) NOT NULL,
  `mem_id` varchar(30) NOT NULL,
  `mem_nick` varchar(30) NOT NULL,
  `nolinks` char(1) NOT NULL,
  `memo` text CHARACTER SET utf8mb4 NOT NULL,
  `sucount` int(10) UNSIGNED NOT NULL,
  `wdate` datetime NOT NULL,
  `nip` varchar(25) NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N',
  `thread` varchar(10) NOT NULL,
  `inpoint` int(10) UNSIGNED NOT NULL,
  `isjack` char(1) NOT NULL DEFAULT 'N',
  `jackpoint` int(10) UNSIGNED NOT NULL,
  `last_idx` int(10) UNSIGNED NOT NULL,
  `c_last_idx` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_areview`
--

CREATE TABLE `shop_areview` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `cate` int(10) UNSIGNED NOT NULL,
  `writer` int(10) UNSIGNED NOT NULL,
  `memo` text CHARACTER SET utf8mb4 NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_areview_cate`
--

CREATE TABLE `shop_areview_cate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_areview_writer`
--

CREATE TABLE `shop_areview_writer` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isdel` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_bankcode`
--

CREATE TABLE `shop_bankcode` (
  `idx` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `isuse` char(1) NOT NULL,
  `orders` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_board`
--

CREATE TABLE `shop_board` (
  `idx` int(10) UNSIGNED NOT NULL,
  `boardid` varchar(20) NOT NULL,
  `lan` varchar(10) NOT NULL,
  `btype` char(1) NOT NULL,
  `wtype` char(1) NOT NULL,
  `issecret` char(1) NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `mem_name` varchar(80) NOT NULL,
  `mem_id` varchar(50) NOT NULL,
  `cates` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `subject_part` varchar(200) NOT NULL,
  `prememo` text NOT NULL,
  `memo` longtext NOT NULL,
  `file1` varchar(100) NOT NULL,
  `file2` varchar(100) NOT NULL,
  `file3` varchar(250) NOT NULL,
  `file4` varchar(250) NOT NULL,
  `file5` varchar(250) NOT NULL,
  `wdate` datetime NOT NULL,
  `readcount` int(10) UNSIGNED NOT NULL,
  `tailcount` int(10) UNSIGNED NOT NULL,
  `tailupdate` char(10) NOT NULL,
  `sucount` int(10) UNSIGNED NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `loca` varchar(200) NOT NULL,
  `mdate` char(10) NOT NULL,
  `isview` char(1) NOT NULL,
  `inpoint` int(10) UNSIGNED NOT NULL,
  `isjack` char(1) NOT NULL,
  `jackpoint` int(10) UNSIGNED NOT NULL,
  `nip` varchar(20) NOT NULL,
  `islock` char(1) NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N',
  `event_idx` int(10) UNSIGNED NOT NULL,
  `market_idx` int(10) UNSIGNED NOT NULL,
  `score` tinyint(3) UNSIGNED NOT NULL,
  `hfile` char(1) NOT NULL,
  `wmode` char(1) NOT NULL DEFAULT '1',
  `passwds` varchar(20) NOT NULL,
  `revdate` datetime NOT NULL,
  `langu` varchar(10) NOT NULL,
  `last_idx` int(10) UNSIGNED NOT NULL,
  `last_idx1` int(10) UNSIGNED NOT NULL,
  `last_idx2` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_board_cate`
--

CREATE TABLE `shop_board_cate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `board_idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(50) NOT NULL,
  `catetitle` varchar(50) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_board_conf`
--

CREATE TABLE `shop_board_conf` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `uselang` char(1) NOT NULL,
  `board_id` varchar(30) NOT NULL,
  `board_name` varchar(100) NOT NULL,
  `skin` varchar(100) NOT NULL DEFAULT 'default',
  `listnum` tinyint(3) UNSIGNED NOT NULL DEFAULT '20',
  `listcols` tinyint(4) NOT NULL,
  `listcut` tinyint(40) NOT NULL,
  `width` int(10) UNSIGNED NOT NULL DEFAULT '95',
  `width2` int(10) UNSIGNED NOT NULL,
  `includet` varchar(200) NOT NULL DEFAULT '../include/boardt.php',
  `included` varchar(200) NOT NULL DEFAULT '../include/boardd.php',
  `align` varchar(10) NOT NULL DEFAULT 'left',
  `paddingpx` tinyint(3) UNSIGNED NOT NULL DEFAULT '10',
  `list_priv` tinyint(3) UNSIGNED NOT NULL DEFAULT '99',
  `list_priv_sub` varchar(200) NOT NULL,
  `write_priv` tinyint(3) UNSIGNED NOT NULL DEFAULT '20',
  `write_priv_sub` varchar(200) NOT NULL,
  `read_priv` tinyint(10) UNSIGNED NOT NULL DEFAULT '99',
  `read_priv_sub` varchar(200) NOT NULL,
  `tail_priv` tinyint(3) UNSIGNED NOT NULL,
  `tail_priv_sub` varchar(200) NOT NULL,
  `tailcount` int(10) UNSIGNED NOT NULL,
  `usenotice` char(1) NOT NULL,
  `usesecret` char(1) NOT NULL,
  `mustsecret` char(1) NOT NULL,
  `usesec` char(1) NOT NULL,
  `mustsec` char(1) NOT NULL,
  `usesu` char(1) NOT NULL,
  `newshow` tinyint(4) NOT NULL,
  `newshowimg` varchar(30) NOT NULL,
  `fileimg` varchar(30) NOT NULL,
  `useeditor` char(1) NOT NULL,
  `tailsecret` char(1) NOT NULL,
  `tailshow` tinyint(3) UNSIGNED NOT NULL,
  `tailshow_color` varchar(10) NOT NULL DEFAULT 'red',
  `readusefile` char(1) NOT NULL,
  `usecate` char(1) NOT NULL,
  `usecate_color` varchar(10) NOT NULL,
  `usecate_memo` text NOT NULL,
  `usescore` char(1) NOT NULL,
  `usefile` char(1) NOT NULL,
  `useprememo` char(1) NOT NULL,
  `useevent` char(1) NOT NULL,
  `usemempoint` char(1) NOT NULL,
  `usegoods` char(1) NOT NULL,
  `w1point` int(10) UNSIGNED NOT NULL,
  `w2point` int(10) UNSIGNED NOT NULL,
  `w3point` int(10) UNSIGNED NOT NULL,
  `wmax` int(10) UNSIGNED NOT NULL,
  `tlimit` int(10) UNSIGNED NOT NULL,
  `usejackpot` char(1) NOT NULL DEFAULT 'Y',
  `menu_main` int(10) UNSIGNED NOT NULL,
  `menu_sub` tinyint(3) UNSIGNED NOT NULL,
  `write_return` varchar(200) NOT NULL,
  `basememo` longtext NOT NULL,
  `thwidth` smallint(5) UNSIGNED NOT NULL,
  `thheight` smallint(5) UNSIGNED NOT NULL,
  `list_img` varchar(100) NOT NULL,
  `list_map` text NOT NULL,
  `list_lan` char(1) NOT NULL,
  `write_img` varchar(100) NOT NULL,
  `read_img` varchar(100) NOT NULL,
  `read_map` text NOT NULL,
  `tops` text NOT NULL,
  `topuse` char(1) NOT NULL,
  `snum` int(11) NOT NULL,
  `spam` text NOT NULL,
  `btitlecss` text NOT NULL,
  `userev` char(1) NOT NULL,
  `tailwpoint` int(10) UNSIGNED NOT NULL,
  `tailpointt` char(1) NOT NULL,
  `writetailo` char(1) NOT NULL,
  `block1` tinyint(4) NOT NULL,
  `block2` tinyint(4) NOT NULL,
  `useddate` char(1) NOT NULL DEFAULT 'N',
  `orby` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_board_goods`
--

CREATE TABLE `shop_board_goods` (
  `idx` int(10) UNSIGNED NOT NULL,
  `board_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_brand`
--

CREATE TABLE `shop_brand` (
  `idx` int(11) NOT NULL,
  `brandname` varchar(100) NOT NULL,
  `havestore` char(1) NOT NULL DEFAULT '',
  `orders` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_brand`
--

INSERT INTO `shop_brand` (`idx`, `brandname`, `havestore`, `orders`) VALUES
(1, '그랑핸드', 'Y', 1),
(2, '콤포타블', 'Y', 2);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_cate`
--

CREATE TABLE `shop_cate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(50) NOT NULL,
  `catecode` varchar(8) NOT NULL,
  `cateimg` varchar(200) NOT NULL,
  `upcate` varchar(8) NOT NULL,
  `catetype` char(1) NOT NULL,
  `isnew` char(1) NOT NULL,
  `newdays` int(10) UNSIGNED NOT NULL,
  `best1` int(10) UNSIGNED NOT NULL,
  `best2` int(10) UNSIGNED NOT NULL,
  `memo` longtext NOT NULL,
  `bestcou` int(10) UNSIGNED NOT NULL,
  `isauto` char(1) NOT NULL,
  `tmp_idx` int(10) UNSIGNED NOT NULL,
  `ctype` char(1) NOT NULL,
  `catetitle` varchar(100) NOT NULL,
  `fid` tinyint(3) UNSIGNED NOT NULL,
  `salestart` varchar(19) NOT NULL,
  `saleend` varchar(19) NOT NULL,
  `saveper` int(10) UNSIGNED NOT NULL,
  `numper` int(10) UNSIGNED NOT NULL,
  `isshow` char(1) NOT NULL,
  `isbestcate` char(1) NOT NULL,
  `htmls` text NOT NULL,
  `icons` text NOT NULL,
  `listskins` int(10) UNSIGNED NOT NULL,
  `rorders` int(10) UNSIGNED NOT NULL,
  `noper` char(1) NOT NULL,
  `search_idx` int(10) UNSIGNED NOT NULL COMMENT '검색연결',
  `showbrand` text NOT NULL,
  `last_idx` varchar(50) NOT NULL,
  `toptype` char(1) NOT NULL,
  `topimg` varchar(100) NOT NULL,
  `topmemo` text NOT NULL,
  `showsites` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_cate`
--

INSERT INTO `shop_cate` (`idx`, `catename`, `catecode`, `cateimg`, `upcate`, `catetype`, `isnew`, `newdays`, `best1`, `best2`, `memo`, `bestcou`, `isauto`, `tmp_idx`, `ctype`, `catetitle`, `fid`, `salestart`, `saleend`, `saveper`, `numper`, `isshow`, `isbestcate`, `htmls`, `icons`, `listskins`, `rorders`, `noper`, `search_idx`, `showbrand`, `last_idx`, `toptype`, `topimg`, `topmemo`, `showsites`) VALUES
(1, '그랑핸드', '01', '', '', '', '', 0, 0, 0, '', 0, '', 0, '', '', 0, '', '', 0, 0, 'Y', '', '', '', 0, 0, '', 0, '', '', '', '', '', 'a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}'),
(2, '기프트 세트', '0101', '', '01', '', '', 0, 0, 0, '', 0, '', 0, '', '', 0, '', '', 0, 0, 'Y', '', '', '', 0, 0, '', 0, '', '', '', '', '', 'a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}'),
(3, '퍼퓸', '0102', '', '01', '', '', 0, 0, 0, '', 0, '', 0, '', '', 0, '', '', 0, 0, 'Y', '', '', '', 0, 0, '', 0, '', '', '', '', '', 'a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}'),
(4, '공간', '0103', '', '01', '', '', 0, 0, 0, '', 0, '', 0, '', '', 0, '', '', 0, 0, 'Y', '', '', '', 0, 0, '', 0, '', '', '', '', '', 'a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}'),
(5, '바디', '0104', '', '01', '', '', 0, 0, 0, '', 0, '', 0, '', '', 0, '', '', 0, 0, 'Y', '', '', '', 0, 0, '', 0, '', '', '', '', '', 'a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}'),
(6, '시그니처', '010201', '', '0102', '', '', 0, 0, 0, '', 0, '', 0, '', '', 0, '', '', 0, 0, 'Y', '', '', '', 0, 0, '', 0, '', '', '', '', '', 'a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}'),
(7, '퍼퓸', '010202', '', '0102', '', '', 0, 0, 0, '', 0, '', 0, '', '', 0, '', '', 0, 0, 'Y', '', '', '', 0, 0, '', 0, '', '', '', '', '', 'a:3:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";}');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config`
--

CREATE TABLE `shop_config` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL COMMENT '그룹아이디',
  `site_country` varchar(10) NOT NULL,
  `language` varchar(10) NOT NULL COMMENT '기본언어',
  `language_use` char(1) NOT NULL DEFAULT '2',
  `curr` varchar(10) NOT NULL COMMENT '사용통화',
  `site_name` varchar(100) NOT NULL,
  `site_code` varchar(10) NOT NULL COMMENT '사이트코드저장',
  `site_title` varchar(100) NOT NULL,
  `site_favor` varchar(200) NOT NULL,
  `site_url` varchar(100) NOT NULL DEFAULT 'www.poptou.com',
  `site_phone` varchar(100) NOT NULL,
  `site_mobile` char(1) NOT NULL,
  `site_mobile_link` varchar(50) NOT NULL,
  `site_width` varchar(50) NOT NULL,
  `site_icon` varchar(50) NOT NULL,
  `site_micon` varchar(30) NOT NULL,
  `site_stdaccount` varchar(20) NOT NULL,
  `site_stdaccountm` char(1) NOT NULL,
  `site_del1` char(1) NOT NULL,
  `site_del2` char(1) NOT NULL COMMENT '해외배송시제한여부',
  `Meta_Subject` text NOT NULL,
  `Meta_Description` text NOT NULL,
  `Meta_keywords` text NOT NULL,
  `Meta_etc` text NOT NULL,
  `site_member_group` int(10) UNSIGNED NOT NULL,
  `usedelac_member` char(1) NOT NULL,
  `usedelac_nomember` char(1) NOT NULL,
  `delaccount_member_std` int(10) UNSIGNED NOT NULL,
  `delaccount_nomember_std` int(10) UNSIGNED NOT NULL,
  `delaccount_member` int(10) UNSIGNED NOT NULL,
  `delaccount_nomember` int(10) UNSIGNED NOT NULL,
  `list_numper` tinyint(4) NOT NULL DEFAULT '24',
  `design_width` int(10) UNSIGNED NOT NULL DEFAULT '730',
  `design_list_count` tinyint(4) NOT NULL DEFAULT '5',
  `design_list_accolor` varchar(6) NOT NULL,
  `design_list_bold_gname` char(1) NOT NULL,
  `design_list_color_gname` char(6) NOT NULL,
  `design_list_size_gname_pre` tinyint(3) UNSIGNED NOT NULL DEFAULT '8',
  `design_list_color_gname_pre` char(6) NOT NULL,
  `design_list_bold_brandname` char(1) NOT NULL,
  `design_list_color_brandname` varchar(7) NOT NULL,
  `design_list_size_brandname` tinyint(4) NOT NULL,
  `design_list_bold_eventname` char(1) NOT NULL,
  `design_list_color_eventname` varchar(7) NOT NULL,
  `design_list_size_eventname` tinyint(3) UNSIGNED NOT NULL,
  `design_view_accolor` char(6) NOT NULL,
  `design_mainimg_width` mediumint(8) UNSIGNED NOT NULL,
  `design_mainimg_height` mediumint(8) UNSIGNED NOT NULL,
  `design_listimg_width` mediumint(9) NOT NULL DEFAULT '120',
  `design_listimg_height` mediumint(9) NOT NULL DEFAULT '120',
  `design_view_margin` int(10) UNSIGNED NOT NULL,
  `design_viewimg_width` int(10) UNSIGNED NOT NULL,
  `design_viewimg_height` int(10) UNSIGNED NOT NULL,
  `design_manban` text NOT NULL,
  `member_joinpoint` int(10) UNSIGNED NOT NULL,
  `member_joinpoint_msg` varchar(200) NOT NULL,
  `member_joincoupen` varchar(100) NOT NULL,
  `member_joingrade` tinyint(3) UNSIGNED NOT NULL,
  `member_joinsms` char(1) NOT NULL,
  `memosimg_1` varchar(100) NOT NULL,
  `memosimg_2` varchar(20) NOT NULL,
  `memosimg_3` varchar(20) NOT NULL,
  `memosimg_model` varchar(100) NOT NULL,
  `memosimg_cs` varchar(100) NOT NULL,
  `memosimg_memo1` varchar(100) NOT NULL,
  `memosimg_memo2` varchar(100) NOT NULL,
  `memosimg_blog` varchar(50) NOT NULL,
  `order_min_point` int(10) UNSIGNED NOT NULL DEFAULT '1000',
  `order_point_std` int(11) NOT NULL,
  `goods_close` tinyint(3) UNSIGNED NOT NULL,
  `view_info_card` varchar(200) NOT NULL,
  `view_inf0_delivery` varchar(200) NOT NULL,
  `img_cards` varchar(100) NOT NULL,
  `mart_new` tinyint(3) UNSIGNED NOT NULL,
  `msg_chadan` text NOT NULL,
  `use_trans` varchar(10) NOT NULL,
  `img_check` varchar(100) NOT NULL,
  `img_check_link` varchar(200) NOT NULL,
  `sale_new` tinyint(3) UNSIGNED NOT NULL,
  `sale_per` tinyint(3) UNSIGNED NOT NULL,
  `sale_hour` int(10) UNSIGNED NOT NULL,
  `favor_point` int(10) UNSIGNED NOT NULL DEFAULT '500',
  `know_point` int(10) UNSIGNED NOT NULL DEFAULT '10',
  `give_point` int(10) UNSIGNED NOT NULL,
  `open_sa_idx` int(10) UNSIGNED NOT NULL,
  `up_config` int(10) UNSIGNED NOT NULL,
  `orderlist_fid` char(1) NOT NULL DEFAULT 'Y',
  `login_check1` char(1) NOT NULL DEFAULT 'N' COMMENT '인트로로그인',
  `login_check2` char(1) NOT NULL DEFAULT '1' COMMENT '로그인컨트롤',
  `login_msg` varchar(200) NOT NULL,
  `order_cancel` tinyint(4) NOT NULL,
  `pid` tinyint(3) UNSIGNED NOT NULL,
  `deldate` char(10) NOT NULL,
  `param1` varchar(50) NOT NULL COMMENT '제휴마켓 ID',
  `param2` varchar(50) NOT NULL COMMENT '제휴마켓 PW',
  `site_con` varchar(255) NOT NULL COMMENT '파비콘imgfile',
  `site_conm` varchar(255) NOT NULL COMMENT 'appletouchiconimgfile',
  `viewtype` varchar(1) NOT NULL,
  `usecheck` char(1) NOT NULL,
  `logid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_config`
--

INSERT INTO `shop_config` (`idx`, `fid`, `site_country`, `language`, `language_use`, `curr`, `site_name`, `site_code`, `site_title`, `site_favor`, `site_url`, `site_phone`, `site_mobile`, `site_mobile_link`, `site_width`, `site_icon`, `site_micon`, `site_stdaccount`, `site_stdaccountm`, `site_del1`, `site_del2`, `Meta_Subject`, `Meta_Description`, `Meta_keywords`, `Meta_etc`, `site_member_group`, `usedelac_member`, `usedelac_nomember`, `delaccount_member_std`, `delaccount_nomember_std`, `delaccount_member`, `delaccount_nomember`, `list_numper`, `design_width`, `design_list_count`, `design_list_accolor`, `design_list_bold_gname`, `design_list_color_gname`, `design_list_size_gname_pre`, `design_list_color_gname_pre`, `design_list_bold_brandname`, `design_list_color_brandname`, `design_list_size_brandname`, `design_list_bold_eventname`, `design_list_color_eventname`, `design_list_size_eventname`, `design_view_accolor`, `design_mainimg_width`, `design_mainimg_height`, `design_listimg_width`, `design_listimg_height`, `design_view_margin`, `design_viewimg_width`, `design_viewimg_height`, `design_manban`, `member_joinpoint`, `member_joinpoint_msg`, `member_joincoupen`, `member_joingrade`, `member_joinsms`, `memosimg_1`, `memosimg_2`, `memosimg_3`, `memosimg_model`, `memosimg_cs`, `memosimg_memo1`, `memosimg_memo2`, `memosimg_blog`, `order_min_point`, `order_point_std`, `goods_close`, `view_info_card`, `view_inf0_delivery`, `img_cards`, `mart_new`, `msg_chadan`, `use_trans`, `img_check`, `img_check_link`, `sale_new`, `sale_per`, `sale_hour`, `favor_point`, `know_point`, `give_point`, `open_sa_idx`, `up_config`, `orderlist_fid`, `login_check1`, `login_check2`, `login_msg`, `order_cancel`, `pid`, `deldate`, `param1`, `param2`, `site_con`, `site_conm`, `viewtype`, `usecheck`, `logid`) VALUES
(1, 1, '', 'ko', '2', 'KRW', '그랑핸즈(웹)', '', '', '', '', '', '1', '', '', '', '', 'account', '2', 'Y', 'Y', '', '', '', '', 1, 'N', 'N', 0, 0, 0, 0, 24, 730, 5, '', '', '', 8, '', '', '', 0, '', '', 0, '', 0, 0, 120, 120, 0, 0, 0, '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', 1000, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, 0, 500, 10, 0, 0, 0, 'Y', 'N', '1', '', 0, 0, '', '', '', '', '', '', '', 0),
(2, 1, '', 'ko', '2', 'KRW', '그랑핸즈(모바일웹)', '', '', '', '', '', '2', '', '', '', '', 'account', '2', 'Y', 'Y', '', '', '', '', 1, '', '', 0, 0, 0, 0, 24, 730, 5, '', '', '', 8, '', '', '', 0, '', '', 0, '', 0, 0, 120, 120, 0, 0, 0, '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', 1000, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, 0, 500, 10, 0, 0, 0, 'Y', 'N', '1', '', 0, 0, '', '', '', '', '', '', '', 0),
(3, 1, '', 'ko', '2', 'KRW', '그랑핸즈(앱)', '', '', '', '', '', '2', '', '', '', '', 'account', '', 'Y', 'Y', '', '', '', '', 1, '', '', 0, 0, 0, 0, 24, 730, 5, '', '', '', 8, '', '', '', 0, '', '', 0, '', 0, 0, 120, 120, 0, 0, 0, '', 0, '', '', 0, '', '', '', '', '', '', '', '', '', 1000, 0, 0, '', '', '', 0, '', '', '', '', 0, 0, 0, 500, 10, 0, 0, 0, 'Y', 'N', '1', '', 0, 0, '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_apis`
--

CREATE TABLE `shop_config_apis` (
  `idx` int(10) UNSIGNED NOT NULL,
  `siteurl` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stype` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_bm`
--

CREATE TABLE `shop_config_bm` (
  `idx` int(10) UNSIGNED NOT NULL,
  `tcate` char(1) NOT NULL COMMENT '1:브랜드/2:제조사',
  `bmname` varchar(50) NOT NULL,
  `etcdata1` varchar(50) NOT NULL,
  `isuse` char(1) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='브랜드/제조사설정';

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_color`
--

CREATE TABLE `shop_config_color` (
  `idx` int(10) UNSIGNED NOT NULL,
  `cgroup` varchar(50) NOT NULL,
  `cname` varchar(10) NOT NULL,
  `ccode1` varchar(10) NOT NULL,
  `ccode2` varchar(10) NOT NULL,
  `ccimg` varchar(50) NOT NULL,
  `setc` varchar(10) NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_curr`
--

CREATE TABLE `shop_config_curr` (
  `idx` int(10) UNSIGNED NOT NULL,
  `isbasic` char(1) NOT NULL,
  `name` varchar(10) NOT NULL,
  `ups` float UNSIGNED NOT NULL,
  `currrate` float NOT NULL,
  `showstd` tinyint(3) UNSIGNED NOT NULL,
  `showdan1` varchar(10) NOT NULL,
  `showdan2` varchar(10) NOT NULL,
  `caltype` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_config_curr`
--

INSERT INTO `shop_config_curr` (`idx`, `isbasic`, `name`, `ups`, `currrate`, `showstd`, `showdan1`, `showdan2`, `caltype`) VALUES
(1, 'Y', 'KRW', 0, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_delivery`
--

CREATE TABLE `shop_config_delivery` (
  `idx` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `deltype` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_domain`
--

CREATE TABLE `shop_config_domain` (
  `idx` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `ismain` char(1) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `domain_no` int(10) NOT NULL COMMENT 'shop_domain테이블 index_no',
  `skin_idx` int(10) UNSIGNED NOT NULL COMMENT '스킨idx',
  `ismobi` char(1) NOT NULL,
  `targeturl` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_config_domain`
--

INSERT INTO `shop_config_domain` (`idx`, `pid`, `ismain`, `domain`, `domain_no`, `skin_idx`, `ismobi`, `targeturl`) VALUES
(1, 1, '', 'granhand.kro.kr', 0, 1, 'N', ''),
(2, 2, '', 'granhand.kro.kr', 0, 2, 'Y', ''),
(3, 2, '', 'mgranhand.kro.kr', 0, 2, 'A', ''),
(4, 2, '', 'm.granhand.kro.kr', 0, 2, 'A', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_goodsadd`
--

CREATE TABLE `shop_config_goodsadd` (
  `idx` int(10) UNSIGNED NOT NULL,
  `bun_idx` int(10) UNSIGNED NOT NULL COMMENT '아이템분류',
  `itemname` varchar(50) NOT NULL,
  `finame` varchar(50) NOT NULL,
  `itemtype` varchar(30) NOT NULL,
  `bases` text NOT NULL,
  `custom_add` text NOT NULL,
  `sources` varchar(30) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `ficou` int(11) NOT NULL,
  `changefi` char(1) NOT NULL DEFAULT 'N',
  `changety` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_icon`
--

CREATE TABLE `shop_config_icon` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `fname` varchar(100) NOT NULL,
  `isuse` char(1) NOT NULL DEFAULT 'Y',
  `wuse` char(1) NOT NULL,
  `wusedate` int(10) UNSIGNED NOT NULL,
  `isup` char(1) NOT NULL,
  `iconcss` text NOT NULL,
  `s1` tinyint(3) UNSIGNED NOT NULL,
  `s2` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_lang`
--

CREATE TABLE `shop_config_lang` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `namecode` varchar(10) NOT NULL,
  `curr` varchar(10) NOT NULL,
  `changecurr` char(1) NOT NULL,
  `isuse` char(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_config_lang`
--

INSERT INTO `shop_config_lang` (`idx`, `name`, `namecode`, `curr`, `changecurr`, `isuse`) VALUES
(1, '한국어', 'ko', '', '', 'Y'),
(2, 'English', 'en', '', '', 'Y');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_maker`
--

CREATE TABLE `shop_config_maker` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `daename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isuse` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_memo`
--

CREATE TABLE `shop_config_memo` (
  `idx` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `lang` varchar(10) NOT NULL,
  `mtype` char(1) NOT NULL,
  `memo` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_msg`
--

CREATE TABLE `shop_config_msg` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `msgtype` int(1) NOT NULL,
  `msgcode` varchar(100) NOT NULL,
  `msgtemplete` varchar(100) NOT NULL,
  `msg` text NOT NULL,
  `msgbutton` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_omemo`
--

CREATE TABLE `shop_config_omemo` (
  `idx` int(10) UNSIGNED NOT NULL,
  `up_idx` int(11) NOT NULL COMMENT '상위구분index_no',
  `catename` varchar(50) NOT NULL COMMENT '구분명',
  `isuse` char(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='관리자메모구분설정테이블';

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_pay`
--

CREATE TABLE `shop_config_pay` (
  `idx` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `buymethod` char(1) NOT NULL,
  `pgcom` varchar(30) NOT NULL,
  `pgid` varchar(100) NOT NULL,
  `pgdata1` text NOT NULL,
  `pgdata2` text NOT NULL,
  `showadmin` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_config_tags`
--

CREATE TABLE `shop_config_tags` (
  `idx` int(10) UNSIGNED NOT NULL,
  `tags` varchar(50) NOT NULL,
  `isshow` char(1) NOT NULL,
  `isdel` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_cont`
--

CREATE TABLE `shop_cont` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `subject` varchar(200) NOT NULL,
  `prememo` text NOT NULL,
  `murlsource` varchar(30) NOT NULL,
  `murl` text NOT NULL,
  `img` varchar(100) NOT NULL,
  `playtime` varchar(50) NOT NULL,
  `wdate` datetime NOT NULL,
  `isshow` char(1) NOT NULL,
  `isdel` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_contact`
--

CREATE TABLE `shop_contact` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memo` text CHARACTER SET utf8mb4 NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_cont_tail`
--

CREATE TABLE `shop_cont_tail` (
  `idx` int(10) UNSIGNED NOT NULL,
  `cont_idx` int(11) NOT NULL,
  `mem_idx` int(11) NOT NULL,
  `memo` text CHARACTER SET utf8mb4 NOT NULL,
  `wdate` datetime NOT NULL,
  `up_idx` int(10) UNSIGNED NOT NULL,
  `likecount` int(10) UNSIGNED NOT NULL,
  `isdel` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_cont_tail_like`
--

CREATE TABLE `shop_cont_tail_like` (
  `idx` int(10) UNSIGNED NOT NULL,
  `tail_idx` int(11) NOT NULL,
  `mem_idx` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_country`
--

CREATE TABLE `shop_country` (
  `idx` int(10) UNSIGNED NOT NULL,
  `country` varchar(250) NOT NULL,
  `nums` varchar(10) NOT NULL,
  `res` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_coupen`
--

CREATE TABLE `shop_coupen` (
  `idx` int(10) UNSIGNED NOT NULL,
  `img` varchar(100) NOT NULL,
  `coupenname` varchar(50) NOT NULL,
  `sellac` int(10) UNSIGNED NOT NULL,
  `actype` char(1) NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `maxaccount` int(10) UNSIGNED NOT NULL,
  `saleper_std1` int(10) UNSIGNED NOT NULL COMMENT '% 할인시 절삭부분',
  `saleper_std2` char(1) NOT NULL COMMENT '% 할인시 절삭부분',
  `usetype` char(1) NOT NULL,
  `islogin` char(1) NOT NULL,
  `downs` varchar(19) NOT NULL,
  `downe` varchar(19) NOT NULL,
  `onlyone` char(1) NOT NULL,
  `canuseac` int(10) UNSIGNED NOT NULL,
  `used` char(1) NOT NULL,
  `usedays` int(10) UNSIGNED NOT NULL,
  `ending` char(1) NOT NULL,
  `startdates` datetime NOT NULL,
  `enddates` datetime NOT NULL,
  `isuse` char(1) NOT NULL,
  `isview` char(1) NOT NULL DEFAULT 'Y',
  `memo` text NOT NULL,
  `usesale` char(1) NOT NULL,
  `usegsale` char(1) NOT NULL,
  `logingive` char(1) NOT NULL,
  `isserial` char(1) NOT NULL DEFAULT 'N',
  `serialnum` varchar(50) NOT NULL,
  `fids` varchar(200) NOT NULL,
  `usesites` varchar(200) NOT NULL,
  `prod1` char(1) NOT NULL,
  `prod2` char(1) NOT NULL,
  `usecate` varchar(250) NOT NULL,
  `nousecate` varchar(250) NOT NULL,
  `usegoods` varchar(250) NOT NULL,
  `nousegoods` varchar(250) NOT NULL,
  `givesave1` char(1) NOT NULL COMMENT '기본적립금지급여부Y지급N지급안함',
  `givesave2` char(1) NOT NULL COMMENT '추가적립금지급여부Y지급N지급안함',
  `give_goods_infos` text NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_coupen`
--

INSERT INTO `shop_coupen` (`idx`, `img`, `coupenname`, `sellac`, `actype`, `account`, `maxaccount`, `saleper_std1`, `saleper_std2`, `usetype`, `islogin`, `downs`, `downe`, `onlyone`, `canuseac`, `used`, `usedays`, `ending`, `startdates`, `enddates`, `isuse`, `isview`, `memo`, `usesale`, `usegsale`, `logingive`, `isserial`, `serialnum`, `fids`, `usesites`, `prod1`, `prod2`, `usecate`, `nousecate`, `usegoods`, `nousegoods`, `givesave1`, `givesave2`, `give_goods_infos`, `isdel`) VALUES
(1, '', 'test', 0, '2', 10, 0, 0, '', '1', 'Y', '2025-07-10', '2025-07-31', 'Y', 100000, '1', 100, '', '2025-07-10 00:00:00', '2025-07-31 00:59:59', 'Y', 'Y', 'test', '3', '', '', 'N', '', 'a:1:{i:0;s:1:\"1\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', '1', '1', '', '', '', '', '', '', '', 'N'),
(2, '', 'test', 0, '1', 1000, 0, 0, '', '1', '', '', '', 'Y', 0, '2', 100, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Y', '', '', '1', '', '', 'N', '', 'a:1:{i:0;s:1:\"1\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', '1', '1', '', '', '', '', '', '', '', 'N'),
(3, '', 'test', 0, '1', 10, 0, 0, '', '1', 'Y', '2025-07-30', '2025-07-31', 'Y', 100000, '1', 100, '', '2025-07-11 00:00:00', '2025-07-31 00:59:59', 'Y', 'Y', '', '2', '', '', 'N', '', 'a:1:{i:0;s:1:\"1\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', '1', '1', '', '', '', '', '', '', '', 'N');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_coupen_log`
--

CREATE TABLE `shop_coupen_log` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `mem_name` varchar(30) NOT NULL,
  `coupen_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(11) NOT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `memo` text NOT NULL,
  `amemo` text NOT NULL,
  `wdate` datetime NOT NULL,
  `mcou` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_coupen_mem`
--

CREATE TABLE `shop_coupen_mem` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `coupen_idx` int(10) UNSIGNED NOT NULL,
  `coupen_name` varchar(50) NOT NULL,
  `mdate` char(10) NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `usedate` char(10) NOT NULL,
  `usehour` char(8) NOT NULL,
  `actype` char(1) NOT NULL,
  `usetype` char(1) NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `market_idx` int(10) UNSIGNED NOT NULL,
  `mtype` char(1) NOT NULL DEFAULT 'A',
  `mname` varchar(30) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `canuseac` int(10) UNSIGNED NOT NULL,
  `log_idx` int(10) UNSIGNED NOT NULL,
  `isout` int(10) UNSIGNED NOT NULL,
  `usesale` char(1) NOT NULL DEFAULT 'N',
  `usegsale` char(1) NOT NULL DEFAULT 'N',
  `fids` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_coupen_serial`
--

CREATE TABLE `shop_coupen_serial` (
  `idx` int(10) UNSIGNED NOT NULL,
  `coupen_idx` int(10) UNSIGNED NOT NULL,
  `nums` varchar(30) NOT NULL,
  `wdate` datetime NOT NULL,
  `udate` datetime NOT NULL,
  `isuse` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_crm_goodsread`
--

CREATE TABLE `shop_crm_goodsread` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `wdate` char(10) NOT NULL,
  `readcount` int(10) UNSIGNED NOT NULL,
  `mreadcount1` int(10) UNSIGNED NOT NULL,
  `mreadcount2` int(10) UNSIGNED NOT NULL,
  `enterc` varchar(50) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_crm_selling`
--

CREATE TABLE `shop_crm_selling` (
  `idx` int(10) UNSIGNED NOT NULL,
  `market_idx` int(11) NOT NULL,
  `basket_idx` int(10) UNSIGNED NOT NULL,
  `gcate` varchar(10) NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `in_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(50) NOT NULL,
  `op2` varchar(50) NOT NULL,
  `op3` varchar(50) NOT NULL,
  `odate` datetime NOT NULL,
  `odate_s` char(10) NOT NULL,
  `indate` char(10) NOT NULL,
  `md` varchar(10) NOT NULL,
  `ea` int(10) UNSIGNED NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `mtype` char(1) NOT NULL,
  `byear` char(2) NOT NULL,
  `enterc` varchar(50) NOT NULL,
  `enterk` varchar(50) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `isnew` char(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_customdb`
--

CREATE TABLE `shop_customdb` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_customdb_data`
--

CREATE TABLE `shop_customdb_data` (
  `idx` int(10) UNSIGNED NOT NULL,
  `customdb_idx` int(10) UNSIGNED NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_customdb_data_ele`
--

CREATE TABLE `shop_customdb_data_ele` (
  `idx` int(10) UNSIGNED NOT NULL,
  `data_idx` int(10) UNSIGNED NOT NULL,
  `fi_idx` int(10) UNSIGNED NOT NULL,
  `datas` text CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_customdb_sch`
--

CREATE TABLE `shop_customdb_sch` (
  `idx` int(10) UNSIGNED NOT NULL,
  `customdb_idx` int(10) UNSIGNED NOT NULL,
  `finame` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fitype` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fiele` text CHARACTER SET utf8mb4 NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_delaccount_add`
--

CREATE TABLE `shop_delaccount_add` (
  `idx` int(10) UNSIGNED NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `location` text CHARACTER SET utf8mb4 NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_delivery_dcompany`
--

CREATE TABLE `shop_delivery_dcompany` (
  `idx` int(10) UNSIGNED NOT NULL,
  `comname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_delivery_fee_jp`
--

CREATE TABLE `shop_delivery_fee_jp` (
  `idx` int(10) UNSIGNED NOT NULL,
  `location` varchar(50) NOT NULL,
  `delaccount` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_design_layout`
--

CREATE TABLE `shop_design_layout` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `moddate` datetime NOT NULL,
  `pdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_design_layout`
--

INSERT INTO `shop_design_layout` (`idx`, `name`, `sname`, `pid`, `moddate`, `pdate`) VALUES
(1, 'basicw', 'basicw', 1, '2025-07-08 20:44:13', '2025-07-08 20:44:13'),
(2, 'basicm', 'basicm', 2, '2025-07-08 20:44:13', '2025-07-08 20:44:13');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_design_layout_addon`
--

CREATE TABLE `shop_design_layout_addon` (
  `idx` int(10) UNSIGNED NOT NULL,
  `layout_idx` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_design_layout_addon`
--

INSERT INTO `shop_design_layout_addon` (`idx`, `layout_idx`, `fname`, `name`) VALUES
(1, 1, 'nav', 'nav ');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_design_mainconfig`
--

CREATE TABLE `shop_design_mainconfig` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `showimg` varchar(30) NOT NULL,
  `admincssm` text NOT NULL,
  `admincss` text NOT NULL,
  `admincssimg` text NOT NULL,
  `mainname` varchar(50) NOT NULL,
  `sizeinfo` varchar(200) NOT NULL,
  `showtype` char(1) NOT NULL,
  `newcss` longtext NOT NULL,
  `newhtmls` longtext NOT NULL,
  `tem_idx` int(10) UNSIGNED NOT NULL,
  `mod_idx` int(10) UNSIGNED NOT NULL,
  `ban_type` char(1) NOT NULL,
  `ban_cou` char(1) NOT NULL,
  `ban_order` varchar(30) NOT NULL,
  `limits` int(10) UNSIGNED NOT NULL,
  `up_idx` int(10) UNSIGNED NOT NULL,
  `usecate` varchar(6) NOT NULL,
  `usemore` char(1) NOT NULL,
  `usebantext` char(1) NOT NULL,
  `useout` char(1) NOT NULL,
  `sector_id` varchar(50) NOT NULL COMMENT '해당 영역 HTML id',
  `sector_url` varchar(200) NOT NULL COMMENT '해당 영역 URL',
  `sector_img` varchar(100) NOT NULL COMMENT '미리보기 이미지',
  `adminorder` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_design_mainconfig`
--

INSERT INTO `shop_design_mainconfig` (`idx`, `fid`, `pid`, `showimg`, `admincssm`, `admincss`, `admincssimg`, `mainname`, `sizeinfo`, `showtype`, `newcss`, `newhtmls`, `tem_idx`, `mod_idx`, `ban_type`, `ban_cou`, `ban_order`, `limits`, `up_idx`, `usecate`, `usemore`, `usebantext`, `useout`, `sector_id`, `sector_url`, `sector_img`, `adminorder`) VALUES
(1, 1, 1, '', '', '', '', '', '', '', '', '', 0, 0, '', '', 'orders', 0, 0, '', '', '', '', '', '', '', 0),
(2, 1, 1, '', '', '', '', '', '', '', '', '', 0, 0, '', '', 'orders', 0, 0, '', '', '', '', '', '', '', 0),
(3, 1, 1, '', '', '', '', '', '', '', '', '', 0, 0, '', '', 'orders', 0, 0, '', '', '', '', '', '', '', 0),
(4, 1, 1, '', '', '', '', '', '', '2', '', '', 0, 0, '', '', 'orders', 0, 0, '', '', '', '', '', '', '', 0),
(5, 1, 1, '', '', '', '', '', '', '2', '', '', 0, 0, '', '', 'orders', 0, 0, '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_design_maindata`
--

CREATE TABLE `shop_design_maindata` (
  `idx` int(10) UNSIGNED NOT NULL,
  `main_idx` int(10) UNSIGNED NOT NULL,
  `cate_idx` int(10) UNSIGNED NOT NULL,
  `subject` varchar(200) NOT NULL,
  `cont_type` char(1) NOT NULL DEFAULT '1',
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `imgs` varchar(50) NOT NULL,
  `imgs_sub` varchar(50) NOT NULL,
  `links` varchar(100) NOT NULL,
  `maps` text NOT NULL,
  `text` varchar(200) NOT NULL,
  `text2` varchar(200) NOT NULL,
  `text3` varchar(200) NOT NULL,
  `text4` varchar(200) NOT NULL,
  `bgcolor1` varchar(7) NOT NULL,
  `bgcolor2` varchar(7) NOT NULL,
  `mkind` varchar(200) NOT NULL,
  `murl` varchar(200) NOT NULL,
  `htmls` longtext NOT NULL,
  `target` varchar(30) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `isuse` char(1) NOT NULL DEFAULT 'Y',
  `showsites` text NOT NULL,
  `imageurl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_design_maindata`
--

INSERT INTO `shop_design_maindata` (`idx`, `main_idx`, `cate_idx`, `subject`, `cont_type`, `goods_idx`, `imgs`, `imgs_sub`, `links`, `maps`, `text`, `text2`, `text3`, `text4`, `bgcolor1`, `bgcolor2`, `mkind`, `murl`, `htmls`, `target`, `orders`, `isuse`, `showsites`, `imageurl`) VALUES
(1, 4, 0, '', '1', 0, '202528/1751988725_0.png', '', '#', '', '2025 ', 'Calender', '1월 뉴스레터에서 신청하세요', '', '', '', '', '', '', '_self', 1, 'Y', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', ''),
(2, 4, 0, '', '1', 0, '202528/1751988718_0.png', '', '#', '', '2025 ', 'Calender', '1월 뉴스레터에서 신청하세요', '', '', '', '', '', '', '_self', 0, 'Y', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', ''),
(3, 5, 0, '', '1', 0, '202528/1751988787_0.png', '', '#', '', '', '', '', '', '', '', '', '', '', '_self', 0, 'Y', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', ''),
(4, 5, 0, '', '1', 0, '202528/1751988797_0.png', '', '#', '', '', '', '', '', '', '', '', '', '', '_self', 0, 'Y', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}', ''),
(5, 1, 0, '', '1', 0, 'asd1.png', '', '/shop/?act=list&cate=01', '', 'GRANHAND.', '‘향의 일상화’를 모토로 일상을 더 아름답게 만들어 줄 향과 제품들을 제안합니다.', '', '', '', '', '', '', '', '', 0, 'Y', '', ''),
(6, 1, 0, '', '1', 0, 'asd2.png', '', '#', '', 'heiion', '헤이온은 하루의 시작과 끝에 꼭 함께하는 존재인 ‘수건’의 중요성에 대해 고민하는 브랜드입니다.', '', '', '', '', '', '', '', '', 0, 'Y', '', ''),
(7, 1, 0, '', '1', 0, 'asd3.png', '', '#', '', 'Komfortabel COFFE', '마시는 향을 선사하는 콤포타블 커피는 훌륭한 커피와 편안한 공간, 그리고 합리적인 가격을 가장 중요하게 생각합니다.', '', '', '', '', '', '', '', '', 0, 'Y', '', ''),
(8, 2, 0, '', '1', 0, 'asd5.png', '', '/cont/?act=store', '', 'GRANHAND. Gwanghwamun', '7th Store Open!', '그랑핸드의 7번째 매장 광화문점을 소개합니다.', '도심의 오피스 중심가에서 잠깐의 여유와 즐거움을 향으로 느낄 수 있는 그랑핸드 광화문점에 방문해 보세요.', '', '', '', '', '', '', 0, 'Y', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_design_maindata_ele`
--

CREATE TABLE `shop_design_maindata_ele` (
  `idx` int(10) UNSIGNED NOT NULL,
  `data_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_design_module`
--

CREATE TABLE `shop_design_module` (
  `idx` int(10) UNSIGNED NOT NULL,
  `skins` int(10) UNSIGNED NOT NULL,
  `stype` char(1) NOT NULL,
  `mname` varchar(30) NOT NULL,
  `mdate` datetime NOT NULL,
  `pdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_domain`
--

CREATE TABLE `shop_domain` (
  `idx` int(11) UNSIGNED NOT NULL,
  `domain_name` varchar(50) NOT NULL COMMENT '서브도메인명',
  `another_name` varchar(50) NOT NULL COMMENT '별칭',
  `isuse` varchar(1) DEFAULT NULL COMMENT '사용유무'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_ep_naver`
--

CREATE TABLE `shop_ep_naver` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_event`
--

CREATE TABLE `shop_event` (
  `idx` int(10) UNSIGNED NOT NULL,
  `lang` char(2) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `memo` text NOT NULL,
  `img` varchar(100) NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `wdate` datetime NOT NULL,
  `isdel` char(1) NOT NULL,
  `isshow` char(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_event`
--

INSERT INTO `shop_event` (`idx`, `lang`, `subject`, `memo`, `img`, `sdate`, `edate`, `wdate`, `isdel`, `isshow`) VALUES
(1, 'ko', '2024 Calender ㅣ 10월 뉴스레터에서 신청하세요', '<div class=\"margin-top-xxl _comment_body_m202201189c42f7f1da444\"><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/4d5840087ad1d.jpg\"></p><p><br></p><p><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/8b9ddb0666e31.jpg\"></p><p><br></p><p style=\"text-align: center;\"><span style=\"color: rgb(153, 153, 153); font-size: 13px;\">(구)그랑핸드 남산점</span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">서울의 다섯 곳의 장소에 위치한 콤포타블 커피 중, 가장 높은 곳에 있는 남산점은 원래는 그랑핸드가 있던 곳이었습니다. 지어진 지 1년도 채 되지 않은 그랑핸드 남산점을 철거한 가장 큰 이유는 ‘이 풍경을 더 많은 사람들에게 보여주고 싶다’는 마음 때문이었습니다.</span></span></p><p><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/135e8c273e778.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/3cd222400e687.jpg\"></p><p><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">많은 정성과 시간, 비용을 담은 공간을 다시 저희 손으로 없앤다는 것이 아깝고 두렵기도 했지만 훨씬 더 많은 사람들이 이 멋진 공간을 향유하기를 바라며 오직 콤포타블 커피만을 위한 장소로 탈바꿈했습니다. 3면으로 펼쳐진 서울의 정취를 충분히 느끼실 수 있도록 창을 최대한 살리고, 좀 더 드라마틱한 무드를 위해 중앙에 레벨이 낮은 직사각형 영역을 형성해 공간을 가볍게 분리했습니다. 또한 중앙 공간 천장에는 곡선 형태의 캐노피를 만들어 창밖으로 보이는 풍경과 빛이 자연스럽게 반사될 수 있게 했습니다.&nbsp;</span></span></p><p><br></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/e0991d3cf2c33.jpg\"></p><p style=\"text-align: left;\"><br></p><p><br></p><p><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/addb4edb95ad9.jpg\"></p><p><br></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/979ba8e80b15a.jpg\"></p><p><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">처음 이 장소에 들어섰을 때 파노라마로 펼쳐진 서울의 정취가 가장 먼저 눈에 들어오길 바랬습니다. 커피 한 모금을 마시고 창가를 바라보았을 때, 시야가 확장되면서 생각도 여유로워지고, 쌓여 있던 고민이나 걱정이 조금은 가벼워지는 공간이 되기를 바랬습니다.&nbsp;</span></span></p><p><br></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/9990372516261.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/e5690772f5014.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/c6502081e172d.jpg\"></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><img src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/3af39b357d9c6.png\" class=\"fr-fic fr-dii\" data-files=\"[object Object]\"></span></span></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/2b31043e3b759.jpg\"></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">콤포타블 커피 남산점은 ‘서울’이라는 도시와 ‘자연’이라는 키워드의 조화로 탄생한 공간입니다. 서울의 중심이자 대표적인 랜드마크 중 하나인 남산의 초입에 위치하여, 도심 속에서도 자연과 함께하는 여유로운 경험을 선사할 수 있도록 설계되었습니다. 루프탑에서는 서울과 남산의 사계절을 그대로 느낄 수 있어 언제 와도 가슴이 탁 트이는 경험을 할 수 있습니다.</span></span></p><p><br></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/155ab853ed909.jpg\"></p><p style=\"text-align: left;\"><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><img src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/dcac037ffce2c.png\" class=\"fr-fic fr-dii\" data-files=\"[object Object]\"></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">특히 콤포타블 커피 남산점의 시그니처가 된 소등식은 우연한 계기로 생겨났는데요, 일부러 3면 창에 모두 고급 전동 블라인드를 달았는데 자주 사용할 일이 없어 아쉬워하던 차에 효과적으로 블라인드를 사용할 만한 일이 무엇이 있을까 고민하다 나온 아이디어였습니다. 특정한 시간에 서울의 뷰가 한 번에 펼쳐진다면 훨씬 드라마틱한 경험이 될 것 같았고, 풍경을 주인공으로 만들기 위해선 매장의 모든 조명을 최소화해야 했기 때문에 자연스럽게 소등식 이벤트로 이어졌습니다. 처음에는 이걸 과연 고객님들이 좋아하실까, 음료 주문도 안되고 어두운데 불편해하시는 건 아닐까 걱정이 많았는데 다행히도 너무 많은 분들이 좋아해 주셔서 감사할 따름입니다.</span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p style=\"text-align: left;\"><br><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/30d95187619c3.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/41dfe096fb5b6.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/1b95e70fb8d80.jpg\"></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"color: rgb(68, 68, 68); font-size: 14px;\">서울의 정취를 품은 콤포타블 커피 남산점은 잊히지 않는 추억을 만들어주고 싶은 모든 분들에게 훌륭한 선택이 됩니다. 친구와 연인, 가족과 함께 와도 항상 편안하면서도 특별한 순간이 되어주는 남산점에 언제든지 편하게 방문해 주세요.</span></p><p><br></p><p><br></p></div>', '6e2415450caab.png', '2025-07-09 12:30:03', '2025-07-09 12:30:03', '2025-07-09 12:30:03', 'N', 'Y');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_event_goods`
--

CREATE TABLE `shop_event_goods` (
  `idx` int(10) UNSIGNED NOT NULL,
  `event_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_faq`
--

CREATE TABLE `shop_faq` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `lang` varchar(10) NOT NULL,
  `cate_idx` tinyint(3) UNSIGNED NOT NULL,
  `cate` varchar(50) NOT NULL DEFAULT '',
  `isbest` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `memo` text NOT NULL,
  `memo_mode` char(1) NOT NULL,
  `wdate` datetime NOT NULL,
  `score` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_faqcate`
--

CREATE TABLE `shop_faqcate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `catename` varchar(50) NOT NULL,
  `isuse` char(1) NOT NULL,
  `orders` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_faqcate`
--

INSERT INTO `shop_faqcate` (`idx`, `fid`, `catename`, `isuse`, `orders`) VALUES
(1, 1, '제품 문의', 'Y', 1),
(2, 1, '매장 문의', 'Y', 2);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_genmemo`
--

CREATE TABLE `shop_genmemo` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `stype` char(1) NOT NULL,
  `scates` text NOT NULL,
  `sgoods` text NOT NULL,
  `sele` varchar(250) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `viewtype` char(1) NOT NULL DEFAULT '1',
  `memo` text NOT NULL,
  `files` varchar(100) NOT NULL,
  `links` varchar(200) NOT NULL,
  `loca` char(1) NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='상품공통정보저장테이블';

--
-- 테이블의 덤프 데이터 `shop_genmemo`
--

INSERT INTO `shop_genmemo` (`idx`, `fid`, `pid`, `stype`, `scates`, `sgoods`, `sele`, `subject`, `sdate`, `edate`, `viewtype`, `memo`, `files`, `links`, `loca`, `wdate`) VALUES
(1, 1, 0, '3', '', '', '', 'test', '2025-07-10 00:00:00', '2025-07-31 00:00:00', '1', '', '', '', '2', '2025-07-10 18:35:20');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods`
--

CREATE TABLE `shop_goods` (
  `idx` int(10) UNSIGNED NOT NULL,
  `gtype` char(1) NOT NULL DEFAULT '1' COMMENT '상품종류',
  `master_idx` int(10) UNSIGNED NOT NULL,
  `master_rel` char(1) NOT NULL,
  `master_cal` char(1) NOT NULL,
  `sdata` char(1) NOT NULL,
  `in_idx` int(11) NOT NULL,
  `gcate` varchar(6) NOT NULL,
  `gcode` varchar(50) NOT NULL COMMENT '상품코드',
  `gname` varchar(100) NOT NULL COMMENT '대표상품명',
  `gname_head` varchar(100) NOT NULL COMMENT '상품머릿말',
  `gname_foot` varchar(100) NOT NULL COMMENT '상품꼬릿말',
  `gsname` varchar(50) NOT NULL,
  `gname_pre` text NOT NULL COMMENT '요약설명[목록]',
  `gdname` varchar(100) NOT NULL COMMENT '매입상품명(도매명)',
  `summsg` varchar(50) NOT NULL,
  `itemcate` varchar(10) NOT NULL,
  `itemcates` varchar(10) NOT NULL,
  `brandname` varchar(20) NOT NULL,
  `eventname` varchar(50) NOT NULL,
  `brandcate` varchar(6) NOT NULL,
  `eventlinks` varchar(100) NOT NULL,
  `goodssex` char(1) NOT NULL,
  `seller_idx` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `md_idx` int(10) UNSIGNED NOT NULL COMMENT '담당자MD',
  `web_idx` int(10) UNSIGNED NOT NULL,
  `photo_idx` int(10) UNSIGNED NOT NULL,
  `model_idx` int(10) UNSIGNED NOT NULL,
  `brand_idx` int(10) UNSIGNED NOT NULL,
  `maker_idx` int(10) UNSIGNED NOT NULL,
  `account` int(10) UNSIGNED NOT NULL COMMENT '판매가',
  `saccount` int(10) UNSIGNED NOT NULL COMMENT '참고가격',
  `account_over` int(10) UNSIGNED NOT NULL COMMENT '해외판매가',
  `saccount_over` int(10) UNSIGNED NOT NULL COMMENT '해외판매참고가격',
  `account_b2b` int(10) UNSIGNED NOT NULL COMMENT '도매기준가',
  `account_off` int(10) UNSIGNED NOT NULL COMMENT '매장판매가',
  `daccount` int(10) UNSIGNED NOT NULL COMMENT '매입가격',
  `odaccount` int(10) UNSIGNED NOT NULL,
  `oaccount` int(10) UNSIGNED NOT NULL,
  `pointper` char(1) NOT NULL DEFAULT '1' COMMENT '적립금지급형태',
  `point` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '지급적립액',
  `pointmemo` text NOT NULL,
  `givesapoint` int(11) NOT NULL COMMENT '사은품포인트',
  `givestm` int(10) UNSIGNED NOT NULL,
  `buytype` char(1) NOT NULL DEFAULT 'A' COMMENT '구매범위',
  `buylimits` int(10) UNSIGNED NOT NULL,
  `sell_lefts` char(1) NOT NULL,
  `sell_today` char(1) NOT NULL,
  `istoday` char(1) NOT NULL COMMENT '당일배송여부',
  `deltype` char(1) NOT NULL DEFAULT '1' COMMENT '배송방법 1: 택배,2.화물',
  `delno` char(1) NOT NULL COMMENT '배송비무료상품',
  `selldan` varchar(20) NOT NULL,
  `minbuy` int(10) UNSIGNED NOT NULL,
  `smemo_type` char(1) NOT NULL,
  `memo` text NOT NULL,
  `mmemo` text NOT NULL COMMENT '모바일 상세',
  `memo_loca` char(1) NOT NULL DEFAULT '1',
  `memo_loca1` int(11) NOT NULL,
  `memo_loca2` int(11) NOT NULL,
  `txtmemo` text NOT NULL,
  `regi_date` datetime NOT NULL,
  `weight` int(10) UNSIGNED NOT NULL COMMENT '상품무게(g)',
  `useop1` char(1) NOT NULL,
  `useop2` char(1) NOT NULL,
  `useop3` char(1) NOT NULL,
  `opname1` varchar(50) NOT NULL,
  `opname2` varchar(50) NOT NULL,
  `opname3` varchar(50) NOT NULL,
  `view_margin` int(10) UNSIGNED NOT NULL,
  `simg1` varchar(250) NOT NULL,
  `simg2` varchar(250) NOT NULL,
  `simg3` varchar(250) NOT NULL,
  `simg4` varchar(250) NOT NULL,
  `simg5` varchar(250) NOT NULL,
  `simg6` varchar(250) NOT NULL,
  `simg7` varchar(250) NOT NULL,
  `simg8` varchar(250) NOT NULL,
  `simg9` varchar(250) NOT NULL,
  `simg10` varchar(250) NOT NULL,
  `simg11` varchar(250) NOT NULL,
  `simg12` varchar(250) NOT NULL,
  `simg13` varchar(250) NOT NULL,
  `moviesite` varchar(50) NOT NULL,
  `movie` varchar(200) NOT NULL,
  `usesimg11` char(1) NOT NULL,
  `sizeinput` varchar(100) NOT NULL,
  `sizestd` int(10) UNSIGNED NOT NULL,
  `sizestd_img` varchar(100) NOT NULL,
  `addinfo_idx` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `isopen` char(1) NOT NULL DEFAULT '',
  `isshow` char(1) NOT NULL,
  `ispids` char(1) NOT NULL,
  `icons` text NOT NULL,
  `cicons` text NOT NULL,
  `opendate` datetime NOT NULL,
  `pmemo1` varchar(100) NOT NULL,
  `pmemo2` varchar(100) NOT NULL,
  `pmemo3` varchar(100) NOT NULL,
  `pmemo4` varchar(100) NOT NULL,
  `pmemo5` varchar(100) NOT NULL,
  `pmemo6` varchar(100) NOT NULL,
  `sizememo` text NOT NULL,
  `admin_memo` text NOT NULL COMMENT '관리자메모',
  `search_keyword` text NOT NULL,
  `admin_requ` varchar(2) NOT NULL,
  `custom_memo` text NOT NULL COMMENT '요약설명[상세]',
  `listimgcolor` varchar(250) NOT NULL,
  `locations` varchar(50) NOT NULL,
  `mordert` char(1) NOT NULL DEFAULT '1',
  `sellc` int(10) UNSIGNED NOT NULL,
  `cnt_review` int(10) UNSIGNED NOT NULL,
  `cnt_qna` int(10) UNSIGNED NOT NULL,
  `cvcou` int(10) UNSIGNED NOT NULL,
  `usecv` char(1) NOT NULL DEFAULT 'Y',
  `usecrv` char(1) NOT NULL DEFAULT 'Y',
  `ismake` char(1) NOT NULL COMMENT '매입구분Y:완사입,A:공정이용',
  `m_country` varchar(50) NOT NULL DEFAULT '한국',
  `m_maker` varchar(50) NOT NULL,
  `pids` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `detailshow` char(1) NOT NULL DEFAULT '1',
  `detailshow_height` int(10) UNSIGNED NOT NULL,
  `top1` text NOT NULL,
  `top2` text NOT NULL,
  `top3` text NOT NULL,
  `in_name` varchar(100) NOT NULL,
  `in_phone` varchar(50) NOT NULL,
  `count_read` int(10) UNSIGNED NOT NULL,
  `count_order` int(10) UNSIGNED NOT NULL,
  `count_cart` int(10) UNSIGNED NOT NULL,
  `count_wish` int(10) UNSIGNED NOT NULL,
  `count_qna` int(10) UNSIGNED NOT NULL,
  `count_review` int(10) UNSIGNED NOT NULL,
  `moddate` datetime NOT NULL,
  `memo_idx` int(10) UNSIGNED NOT NULL,
  `fid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `sale_idx` int(10) UNSIGNED NOT NULL,
  `tmpaccount` int(10) UNSIGNED NOT NULL,
  `tmpsaccount` int(10) UNSIGNED NOT NULL,
  `osale_idx` int(10) UNSIGNED NOT NULL,
  `tmposaccount` int(10) UNSIGNED NOT NULL,
  `tmpossaccount` int(10) UNSIGNED NOT NULL,
  `resms` char(1) NOT NULL,
  `use_tem` char(1) NOT NULL DEFAULT 'N',
  `can_op` char(1) NOT NULL DEFAULT 'N' COMMENT '청약철회사용',
  `prodan` char(1) NOT NULL DEFAULT '1',
  `isdel` char(1) NOT NULL DEFAULT 'N',
  `last_idx` int(10) UNSIGNED NOT NULL,
  `shurl1` varchar(100) NOT NULL,
  `shurl2` varchar(100) NOT NULL,
  `sbj_idx` int(10) UNSIGNED NOT NULL,
  `sbj_per` int(10) UNSIGNED NOT NULL,
  `isok` char(1) NOT NULL,
  `openstr` varchar(100) NOT NULL,
  `mall_idx` int(10) UNSIGNED NOT NULL,
  `cafe_idx` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_goods`
--

INSERT INTO `shop_goods` (`idx`, `gtype`, `master_idx`, `master_rel`, `master_cal`, `sdata`, `in_idx`, `gcate`, `gcode`, `gname`, `gname_head`, `gname_foot`, `gsname`, `gname_pre`, `gdname`, `summsg`, `itemcate`, `itemcates`, `brandname`, `eventname`, `brandcate`, `eventlinks`, `goodssex`, `seller_idx`, `md_idx`, `web_idx`, `photo_idx`, `model_idx`, `brand_idx`, `maker_idx`, `account`, `saccount`, `account_over`, `saccount_over`, `account_b2b`, `account_off`, `daccount`, `odaccount`, `oaccount`, `pointper`, `point`, `pointmemo`, `givesapoint`, `givestm`, `buytype`, `buylimits`, `sell_lefts`, `sell_today`, `istoday`, `deltype`, `delno`, `selldan`, `minbuy`, `smemo_type`, `memo`, `mmemo`, `memo_loca`, `memo_loca1`, `memo_loca2`, `txtmemo`, `regi_date`, `weight`, `useop1`, `useop2`, `useop3`, `opname1`, `opname2`, `opname3`, `view_margin`, `simg1`, `simg2`, `simg3`, `simg4`, `simg5`, `simg6`, `simg7`, `simg8`, `simg9`, `simg10`, `simg11`, `simg12`, `simg13`, `moviesite`, `movie`, `usesimg11`, `sizeinput`, `sizestd`, `sizestd_img`, `addinfo_idx`, `isopen`, `isshow`, `ispids`, `icons`, `cicons`, `opendate`, `pmemo1`, `pmemo2`, `pmemo3`, `pmemo4`, `pmemo5`, `pmemo6`, `sizememo`, `admin_memo`, `search_keyword`, `admin_requ`, `custom_memo`, `listimgcolor`, `locations`, `mordert`, `sellc`, `cnt_review`, `cnt_qna`, `cvcou`, `usecv`, `usecrv`, `ismake`, `m_country`, `m_maker`, `pids`, `detailshow`, `detailshow_height`, `top1`, `top2`, `top3`, `in_name`, `in_phone`, `count_read`, `count_order`, `count_cart`, `count_wish`, `count_qna`, `count_review`, `moddate`, `memo_idx`, `fid`, `sale_idx`, `tmpaccount`, `tmpsaccount`, `osale_idx`, `tmposaccount`, `tmpossaccount`, `resms`, `use_tem`, `can_op`, `prodan`, `isdel`, `last_idx`, `shurl1`, `shurl2`, `sbj_idx`, `sbj_per`, `isok`, `openstr`, `mall_idx`, `cafe_idx`) VALUES
(1, '1', 0, '', '', '', 0, '', '', 'Roland Multi Perfume', '', '', '', '롤랑 멀티퍼퓸 100ml / 200ml', '', '', '', '', '', '', '', '', '', 1, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, '1', 0, '', 0, 0, 'A', 0, '', '', '', '1', '', '', 0, '1', '<div class=\"_prod_detail_detail_lazy_load clearfix shop_view_body  fr-view product_detail\" id=\"prod_detail_body\"><style>@keyframes lazyload {0% {opacity: 0;} 50% {opacity: 0.1;} 100% {opacity: 0;}}</style><p><style>img[data-_upload__202101157dd079a44b118_cb0b3b06bbf2e_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_cb0b3b06bbf2e_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1920\" data-_upload__202101157dd079a44b118_cb0b3b06bbf2e_png=\"\" width=\"1000\" height=\"294\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><hr><p><br></p><p><br></p><p><br></p><div class=\"col-sm-6\"><style>img[data-_upload__202101157dd079a44b118_1ca5ae508ec0e_jpg] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_1ca5ae508ec0e_jpg].loaded {opacity:1;}</style><img class=\"fr-fic fr-dii loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1920\" data-_upload__202101157dd079a44b118_1ca5ae508ec0e_jpg=\"\" width=\"1000\" height=\"1334\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></div><div class=\"col-sm-6\"><style>img[data-_upload__202101157dd079a44b118_619414bcd5f5d_jpg] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_619414bcd5f5d_jpg].loaded {opacity:1;}</style><img class=\"fr-fic fr-dii loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1920\" data-_upload__202101157dd079a44b118_619414bcd5f5d_jpg=\"\" width=\"1000\" height=\"1334\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"><br></div><div class=\"col-sm-6\"><br></div><p><style>img[data-_upload__202101157dd079a44b118_c4ff7843107ac_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_c4ff7843107ac_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1920\" data-_upload__202101157dd079a44b118_c4ff7843107ac_png=\"\" width=\"1000\" height=\"176\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_2ea64aee820ed_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_2ea64aee820ed_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1920\" data-_upload__202101157dd079a44b118_2ea64aee820ed_png=\"\" width=\"1000\" height=\"977\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_efbe78d494d67_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_efbe78d494d67_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1920\" data-_upload__202101157dd079a44b118_efbe78d494d67_png=\"\" width=\"1000\" height=\"1027\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_acb6aa6d6d544_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_acb6aa6d6d544_png].loaded {opacity:1;}</style><img class=\"fr-dib\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1920\" data-_upload__202101157dd079a44b118_acb6aa6d6d544_png=\"\" width=\"1000\" height=\"1027\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_af5e31b743a26_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_af5e31b743a26_png].loaded {opacity:1;}</style><img class=\"fr-dib\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1920\" data-_upload__202101157dd079a44b118_af5e31b743a26_png=\"\" width=\"1000\" height=\"1077\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_b8a6858b6f64c_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_b8a6858b6f64c_png].loaded {opacity:1;}</style><img class=\"fr-dib\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1920\" data-_upload__202101157dd079a44b118_b8a6858b6f64c_png=\"\" width=\"1000\" height=\"1077\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><span style=\"color: rgb(68, 68, 68);\"><br></span></p><hr><p><span style=\"color: rgb(68, 68, 68);\"><br></span></p><p><span style=\"color: rgb(68, 68, 68);\"><style>img[data-_upload__202101157dd079a44b118_a0091ce3db3a5_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_a0091ce3db3a5_png].loaded {opacity:1;}</style><img src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1920\" class=\"fr-fic fr-dii\" data-_upload__202101157dd079a44b118_a0091ce3db3a5_png=\"\" width=\"1920\" height=\"3407\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></span></p><div class=\"product-notify-wrap \"><div class=\"product-notify-title\"> 상품정보 제공고시</div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">내용물의 용량 또는 중량</div><div class=\"product-notify-value table-cell\">450ml / Φ75x165</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">제품 주요 사양 (피부타입, 색상(호, 번) 등)</div><div class=\"product-notify-value table-cell\">모든 피부 타입 *상처가 있는 부위, 습진 및 피부염 등의 이상이 있는 부위에는 사용을 자제해 주시길 바랍니다. <br>\r\n</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">사용기한 또는 개봉 후 사용기간</div><div class=\"product-notify-value table-cell\">2024년 11월 25일 이후 제조 상품, 개봉 후 12개월 이내 사용</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">사용방법</div><div class=\"product-notify-value table-cell\">• 적당량을 손에 덜고 거품을 내어 깨끗이 씻은 후 흐르는 물로 헹구어 냅니다.</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">화장품제조업자, 화장품책임판매업자 및 맞춤형화장품판매업자</div><div class=\"product-notify-value table-cell\">SA코스메틱, (유)그랑핸드</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">제조국</div><div class=\"product-notify-value table-cell\">대한민국</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">관계 법령에 따라 기재,표시하여야 하는 모든 성분</div><div class=\"product-notify-value table-cell\">• 수지 살몬 (SUSIE SALMON): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 리모넨, 부틸페닐메틸프로피오날, 시트랄, 알파-아이소메틸아이오논, 하이드록시시트로넬알, 헥실신남알<br>\r\n• 마린 오키드 (MARINE ORCHID): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 리날룰, 리모넨, 벤질벤조에이트, 벤질살리실레이트, 알파-아이소메틸아이오논, 아이소유제놀<br>\r\n• 루시엔 카 (LUCIEN CARR): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 리날룰, 리모넨<br>\r\n• 롤랑 (ROLAND): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 시트랄, 리모넨, 리날룰<br>\r\n• 트와 베르 (TOIT VERT): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 알파-아이소메틸아이오논, 벤질벤조에이트, 부틸페닐메틸프로피오날, 하이드록시시트로넬알, 리모넨, 리날룰</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">“관계 법령에 따라 기능성 화장품 심사(또는 보고)를 필함”의 문구</div><div class=\"product-notify-value table-cell\">해당 없음</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">사용할 때의 주의사항</div><div class=\"product-notify-value table-cell\">• 화장품 사용 시 또는 사용 후 직사광선에 의하여 사용부위가 붉은 반점, 부어오름 또는 가려움증 등의 이상 증상이나 부작용이 있는 경우 전문의 등과 상담할 것<br>\r\n• 상처가 있는 부위 등에는 사용을 자제할 것<br>\r\n• 보관 및 취급 시의 주의사항 가) 어린이의 손이 닿지 않는 곳에 보관할 것 나) 직사광선을 피해서 보관할 것</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">품질보증기준</div><div class=\"product-notify-value table-cell\">• 본 제품은 외용 전용 화장품으로서, 이상이 있을 경우 품목별 소비자 분쟁 해결 기준에 의거 교환 또는 보상받을 수 있습니다.</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">소비자상담 관련 전화번호</div><div class=\"product-notify-value table-cell\">02-333-6525</div></div></div></div>', '', '1', 0, 0, '', '2025-07-08 19:29:10', 0, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, '2', 'Y', '', '', '', '2025-07-08 19:29:10', '', '', '', '', '', '', '', '', '', '', '롤랑 멀티퍼퓸 100ml / 200ml', '', '', '1', 0, 0, 0, 0, 'Y', 'Y', '', '한국', '', 1, '1', 0, '', '', '', '', '', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 1, 0, 0, 0, 0, 0, 0, '', 'N', '', '1', 'N', 0, '', '', 0, 0, 'Y', '', 0, 0),
(2, '1', 0, '', '', '', 0, '', '', 'Roland Multi Perfume', '', '', '', '롤랑 멀티퍼퓸 100ml / 200ml', '', '', '', '', '', '', '', '', '', 1, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, '1', 0, '', 0, 0, 'A', 0, '', '', '', '1', '', '', 0, '1', '<div class=\"_prod_detail_detail_lazy_load clearfix shop_view_body  fr-view product_detail\" id=\"prod_detail_body\"><style>@keyframes lazyload {0% {opacity: 0;} 50% {opacity: 0.1;} 100% {opacity: 0;}}</style><p><style>img[data-_upload__202101157dd079a44b118_cb0b3b06bbf2e_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_cb0b3b06bbf2e_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1920\" data-_upload__202101157dd079a44b118_cb0b3b06bbf2e_png=\"\" width=\"1000\" height=\"294\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/cb0b3b06bbf2e.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><hr><p><br></p><p><br></p><p><br></p><div class=\"col-sm-6\"><style>img[data-_upload__202101157dd079a44b118_1ca5ae508ec0e_jpg] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_1ca5ae508ec0e_jpg].loaded {opacity:1;}</style><img class=\"fr-fic fr-dii loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1920\" data-_upload__202101157dd079a44b118_1ca5ae508ec0e_jpg=\"\" width=\"1000\" height=\"1334\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/1ca5ae508ec0e.jpg?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></div><div class=\"col-sm-6\"><style>img[data-_upload__202101157dd079a44b118_619414bcd5f5d_jpg] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_619414bcd5f5d_jpg].loaded {opacity:1;}</style><img class=\"fr-fic fr-dii loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1920\" data-_upload__202101157dd079a44b118_619414bcd5f5d_jpg=\"\" width=\"1000\" height=\"1334\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/619414bcd5f5d.jpg?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"><br></div><div class=\"col-sm-6\"><br></div><p><style>img[data-_upload__202101157dd079a44b118_c4ff7843107ac_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_c4ff7843107ac_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1920\" data-_upload__202101157dd079a44b118_c4ff7843107ac_png=\"\" width=\"1000\" height=\"176\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/c4ff7843107ac.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_2ea64aee820ed_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_2ea64aee820ed_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1920\" data-_upload__202101157dd079a44b118_2ea64aee820ed_png=\"\" width=\"1000\" height=\"977\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/2ea64aee820ed.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_efbe78d494d67_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_efbe78d494d67_png].loaded {opacity:1;}</style><img class=\"fr-dib loaded\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1920\" data-_upload__202101157dd079a44b118_efbe78d494d67_png=\"\" width=\"1000\" height=\"1027\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/efbe78d494d67.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_acb6aa6d6d544_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_acb6aa6d6d544_png].loaded {opacity:1;}</style><img class=\"fr-dib\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1920\" data-_upload__202101157dd079a44b118_acb6aa6d6d544_png=\"\" width=\"1000\" height=\"1027\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/acb6aa6d6d544.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_af5e31b743a26_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_af5e31b743a26_png].loaded {opacity:1;}</style><img class=\"fr-dib\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1920\" data-_upload__202101157dd079a44b118_af5e31b743a26_png=\"\" width=\"1000\" height=\"1077\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/af5e31b743a26.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><style>img[data-_upload__202101157dd079a44b118_b8a6858b6f64c_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_b8a6858b6f64c_png].loaded {opacity:1;}</style><img class=\"fr-dib\" src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1920\" data-_upload__202101157dd079a44b118_b8a6858b6f64c_png=\"\" width=\"1000\" height=\"1077\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/b8a6858b6f64c.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></p><p><span style=\"color: rgb(68, 68, 68);\"><br></span></p><hr><p><span style=\"color: rgb(68, 68, 68);\"><br></span></p><p><span style=\"color: rgb(68, 68, 68);\"><style>img[data-_upload__202101157dd079a44b118_a0091ce3db3a5_png] {opacity:0;transition:opacity 60ms ease-out;} img[data-_upload__202101157dd079a44b118_a0091ce3db3a5_png].loaded {opacity:1;}</style><img src=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1920\" class=\"fr-fic fr-dii\" data-_upload__202101157dd079a44b118_a0091ce3db3a5_png=\"\" width=\"1920\" height=\"3407\" sizes=\"100vw\" srcset=\"https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1536 1536w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1280 1280w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=1080 1080w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=828 828w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=768 768w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=640 640w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=576 576w, https://cdn-optimized.imweb.me/upload/S202101157dd079a44b118/a0091ce3db3a5.png?w=368 368w\" loading=\"lazy\" style=\"object-fit: cover; max-width: 100%; height: auto;\"></span></p><div class=\"product-notify-wrap \"><div class=\"product-notify-title\"> 상품정보 제공고시</div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">내용물의 용량 또는 중량</div><div class=\"product-notify-value table-cell\">450ml / Φ75x165</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">제품 주요 사양 (피부타입, 색상(호, 번) 등)</div><div class=\"product-notify-value table-cell\">모든 피부 타입 *상처가 있는 부위, 습진 및 피부염 등의 이상이 있는 부위에는 사용을 자제해 주시길 바랍니다. <br>\r\n</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">사용기한 또는 개봉 후 사용기간</div><div class=\"product-notify-value table-cell\">2024년 11월 25일 이후 제조 상품, 개봉 후 12개월 이내 사용</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">사용방법</div><div class=\"product-notify-value table-cell\">• 적당량을 손에 덜고 거품을 내어 깨끗이 씻은 후 흐르는 물로 헹구어 냅니다.</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">화장품제조업자, 화장품책임판매업자 및 맞춤형화장품판매업자</div><div class=\"product-notify-value table-cell\">SA코스메틱, (유)그랑핸드</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">제조국</div><div class=\"product-notify-value table-cell\">대한민국</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">관계 법령에 따라 기재,표시하여야 하는 모든 성분</div><div class=\"product-notify-value table-cell\">• 수지 살몬 (SUSIE SALMON): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 리모넨, 부틸페닐메틸프로피오날, 시트랄, 알파-아이소메틸아이오논, 하이드록시시트로넬알, 헥실신남알<br>\r\n• 마린 오키드 (MARINE ORCHID): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 리날룰, 리모넨, 벤질벤조에이트, 벤질살리실레이트, 알파-아이소메틸아이오논, 아이소유제놀<br>\r\n• 루시엔 카 (LUCIEN CARR): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 리날룰, 리모넨<br>\r\n• 롤랑 (ROLAND): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 시트랄, 리모넨, 리날룰<br>\r\n• 트와 베르 (TOIT VERT): 주요물질: 정제수, 소듐C14-16올레핀설포네이트, 코코-베타인, 다이소듐라우레스설포석시네이트, 향료, 1,2-헥산다이올, 에틸헥실글리세린, 인동덩굴꽃추출물, 작약추출물, 고삼추출물, 황금추출물, 붉나무추출물, 녹차추출물, 복사나무잎추출물, 은행나무잎추출물, 다이소듐이디티에이, 테트라데센, 헥사데센, 소듐설페이트, 알파-아이소메틸아이오논, 벤질벤조에이트, 부틸페닐메틸프로피오날, 하이드록시시트로넬알, 리모넨, 리날룰</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">“관계 법령에 따라 기능성 화장품 심사(또는 보고)를 필함”의 문구</div><div class=\"product-notify-value table-cell\">해당 없음</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">사용할 때의 주의사항</div><div class=\"product-notify-value table-cell\">• 화장품 사용 시 또는 사용 후 직사광선에 의하여 사용부위가 붉은 반점, 부어오름 또는 가려움증 등의 이상 증상이나 부작용이 있는 경우 전문의 등과 상담할 것<br>\r\n• 상처가 있는 부위 등에는 사용을 자제할 것<br>\r\n• 보관 및 취급 시의 주의사항 가) 어린이의 손이 닿지 않는 곳에 보관할 것 나) 직사광선을 피해서 보관할 것</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">품질보증기준</div><div class=\"product-notify-value table-cell\">• 본 제품은 외용 전용 화장품으로서, 이상이 있을 경우 품목별 소비자 분쟁 해결 기준에 의거 교환 또는 보상받을 수 있습니다.</div></div><div class=\"product-notify-group tabled full-width\"><div class=\"product-notify-label table-cell\">소비자상담 관련 전화번호</div><div class=\"product-notify-value table-cell\">02-333-6525</div></div></div></div>', '', '1', 0, 0, '', '2025-07-08 19:32:47', 0, '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, '2', 'Y', '', '', '', '2025-07-08 19:32:47', '', '', '', '', '', '', '', '', '', '', '롤랑 멀티퍼퓸 100ml / 200ml', '', '', '1', 0, 0, 0, 0, 'Y', 'Y', '', '한국', '', 1, '1', 0, '', '', '', '', '', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 1, 0, 0, 0, 0, 0, 0, '', 'N', '', '1', 'N', 0, '', '', 0, 0, 'Y', '', 0, 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goodslist`
--

CREATE TABLE `shop_goodslist` (
  `index_no` int(11) NOT NULL,
  `gcate` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `simg1` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saccount` int(11) NOT NULL,
  `account` int(11) NOT NULL,
  `idx` int(10) UNSIGNED NOT NULL,
  `tables` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_account`
--

CREATE TABLE `shop_goods_account` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `stype` varchar(10) CHARACTER SET ucs2 NOT NULL,
  `account` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_addinfo`
--

CREATE TABLE `shop_goods_addinfo` (
  `index_no` int(11) NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) CHARACTER SET ucs2 NOT NULL,
  `data` text CHARACTER SET ucs2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_barcode`
--

CREATE TABLE `shop_goods_barcode` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(50) NOT NULL,
  `op2` varchar(50) NOT NULL,
  `op3` varchar(50) NOT NULL,
  `barcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_bun`
--

CREATE TABLE `shop_goods_bun` (
  `idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(50) NOT NULL,
  `buncode` varchar(10) NOT NULL,
  `catecode` varchar(6) NOT NULL,
  `upcate` varchar(6) NOT NULL,
  `last_idx` int(10) UNSIGNED NOT NULL,
  `isimg` char(1) NOT NULL,
  `isgoods` char(1) NOT NULL,
  `smain` tinyint(3) UNSIGNED NOT NULL,
  `brandname` varchar(30) NOT NULL,
  `orders` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_goods_bun`
--

INSERT INTO `shop_goods_bun` (`idx`, `catename`, `buncode`, `catecode`, `upcate`, `last_idx`, `isimg`, `isgoods`, `smain`, `brandname`, `orders`) VALUES
(1, 'test', 'test1', '01', '', 0, '', '', 0, '', 99);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_cate`
--

CREATE TABLE `shop_goods_cate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `catecode` varchar(10) NOT NULL,
  `lcatecode` varchar(100) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `tp` char(1) NOT NULL,
  `lcate` varchar(50) NOT NULL,
  `lcate2` varchar(10) NOT NULL,
  `last_idx` varchar(50) NOT NULL,
  `isfix` char(1) NOT NULL,
  `istmp` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_goods_cate`
--

INSERT INTO `shop_goods_cate` (`idx`, `goods_idx`, `catecode`, `lcatecode`, `orders`, `tp`, `lcate`, `lcate2`, `last_idx`, `isfix`, `istmp`) VALUES
(1, 1, '01', '', 2, '', '', '', '', '', 'N'),
(2, 1, '0102', '', 2, '', '', '', '', '', 'N'),
(3, 1, '010201', '', 1, '', '', '', '', '', 'N'),
(4, 2, '01', '', 1, '', '', '', '', '', 'N'),
(5, 2, '0102', '', 1, '', '', '', '', '', 'N'),
(6, 2, '010202', '', 1, '', '', '', '', '', 'N');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_cgroup`
--

CREATE TABLE `shop_goods_cgroup` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `cgroup` int(10) UNSIGNED NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `md_idx` int(10) UNSIGNED NOT NULL,
  `web_idx` int(10) UNSIGNED NOT NULL,
  `photo_idx` int(10) UNSIGNED NOT NULL,
  `model_idx` int(10) UNSIGNED NOT NULL,
  `simg1` varchar(50) NOT NULL,
  `simg2` varchar(50) NOT NULL,
  `simg3` varchar(50) NOT NULL,
  `simg4` varchar(50) NOT NULL,
  `isb` char(1) NOT NULL,
  `ccode` char(7) NOT NULL,
  `op_idx` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_change_account`
--

CREATE TABLE `shop_goods_change_account` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `actype` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `baccount` int(11) NOT NULL,
  `aaccount` int(10) UNSIGNED NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_color`
--

CREATE TABLE `shop_goods_color` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(11) NOT NULL,
  `color_idx` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_imgs`
--

CREATE TABLE `shop_goods_imgs` (
  `idx` int(11) NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_goods_imgs`
--

INSERT INTO `shop_goods_imgs` (`idx`, `goods_idx`, `filename`) VALUES
(1, 1, '202528/1751970390_0.png'),
(2, 1, '202528/1751970473_0.png'),
(3, 2, '202528/1751970493_0.png'),
(4, 2, '202528/1751970678_0.png');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_inout`
--

CREATE TABLE `shop_goods_inout` (
  `idx` int(10) UNSIGNED NOT NULL,
  `paper_idx` int(10) UNSIGNED NOT NULL,
  `in_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(10) NOT NULL,
  `op2` varchar(10) NOT NULL,
  `op3` varchar(10) NOT NULL,
  `ea` int(10) UNSIGNED NOT NULL,
  `wdate_s` char(10) NOT NULL,
  `whour_s` char(8) NOT NULL,
  `tbtype` tinyint(1) UNSIGNED NOT NULL,
  `useh` char(1) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `amemo` text NOT NULL,
  `reins` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_inout_cate`
--

CREATE TABLE `shop_goods_inout_cate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(30) NOT NULL,
  `catetype` char(1) NOT NULL,
  `dt` char(1) NOT NULL,
  `isshopr` char(1) NOT NULL,
  `useh` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_inout_paper`
--

CREATE TABLE `shop_goods_inout_paper` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `wdate` datetime NOT NULL,
  `tbtype` int(10) UNSIGNED NOT NULL,
  `wname` varchar(50) NOT NULL,
  `useh` char(1) NOT NULL,
  `istmp` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_inout_pre`
--

CREATE TABLE `shop_goods_inout_pre` (
  `idx` int(10) UNSIGNED NOT NULL,
  `codes` varchar(50) NOT NULL,
  `ea` int(10) UNSIGNED NOT NULL,
  `noea` int(10) UNSIGNED NOT NULL COMMENT '입고시미송상품등록',
  `tbtype` int(10) UNSIGNED NOT NULL,
  `useh` char(1) NOT NULL,
  `memo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_last`
--

CREATE TABLE `shop_goods_last` (
  `idx` int(10) UNSIGNED NOT NULL,
  `gtype` char(1) NOT NULL DEFAULT '1' COMMENT '상품종류',
  `master_idx` int(10) UNSIGNED NOT NULL,
  `master_rel` char(1) NOT NULL,
  `master_cal` char(1) NOT NULL,
  `sdata` char(1) NOT NULL,
  `in_idx` int(11) NOT NULL,
  `gcate` varchar(6) NOT NULL,
  `gcode` varchar(50) NOT NULL COMMENT '상품코드',
  `gname` varchar(100) NOT NULL COMMENT '대표상품명',
  `gname_head` varchar(100) NOT NULL COMMENT '상품머릿말',
  `gname_foot` varchar(100) NOT NULL COMMENT '상품꼬릿말',
  `gsname` varchar(50) NOT NULL,
  `gname_pre` text NOT NULL COMMENT '요약설명[목록]',
  `gdname` varchar(100) NOT NULL COMMENT '매입상품명(도매명)',
  `summsg` varchar(50) NOT NULL,
  `itemcate` varchar(10) NOT NULL,
  `itemcates` varchar(10) NOT NULL,
  `brandname` varchar(20) NOT NULL,
  `eventname` varchar(50) NOT NULL,
  `brandcate` varchar(6) NOT NULL,
  `eventlinks` varchar(100) NOT NULL,
  `goodssex` char(1) NOT NULL,
  `seller_idx` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `md_idx` int(10) UNSIGNED NOT NULL COMMENT '담당자MD',
  `web_idx` int(10) UNSIGNED NOT NULL,
  `photo_idx` int(10) UNSIGNED NOT NULL,
  `model_idx` int(10) UNSIGNED NOT NULL,
  `account` int(10) UNSIGNED NOT NULL COMMENT '판매가',
  `saccount` int(10) UNSIGNED NOT NULL COMMENT '참고가격',
  `account_over` int(10) UNSIGNED NOT NULL COMMENT '해외판매가',
  `saccount_over` int(10) UNSIGNED NOT NULL COMMENT '해외판매참고가격',
  `account_b2b` int(10) UNSIGNED NOT NULL COMMENT '도매기준가',
  `account_off` int(10) UNSIGNED NOT NULL COMMENT '매장판매가',
  `daccount` int(10) UNSIGNED NOT NULL COMMENT '매입가격',
  `odaccount` int(10) UNSIGNED NOT NULL,
  `oaccount` int(10) UNSIGNED NOT NULL,
  `pointper` char(1) NOT NULL DEFAULT '1' COMMENT '적립금지급형태',
  `point` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '지급적립액',
  `givesapoint` int(11) NOT NULL COMMENT '사은품포인트',
  `givestm` int(10) UNSIGNED NOT NULL,
  `buytype` char(1) NOT NULL DEFAULT 'A' COMMENT '구매범위',
  `sell_lefts` char(1) NOT NULL,
  `sell_today` char(1) NOT NULL,
  `istoday` char(1) NOT NULL COMMENT '당일배송여부',
  `deltype` char(1) NOT NULL DEFAULT '1' COMMENT '배송방법 1: 택배,2.화물',
  `delno` char(1) NOT NULL COMMENT '배송비무료상품',
  `smemo_type` char(1) NOT NULL,
  `memo` text NOT NULL,
  `mmemo` text NOT NULL COMMENT '모바일 상세',
  `memo_loca` char(1) NOT NULL DEFAULT '1',
  `memo_loca1` int(11) NOT NULL,
  `memo_loca2` int(11) NOT NULL,
  `txtmemo` text NOT NULL,
  `regi_date` datetime NOT NULL,
  `weight` int(10) UNSIGNED NOT NULL COMMENT '상품무게(g)',
  `useop1` char(1) NOT NULL,
  `useop2` char(1) NOT NULL,
  `useop3` char(1) NOT NULL,
  `opname1` varchar(50) NOT NULL,
  `opname2` varchar(50) NOT NULL,
  `opname3` varchar(50) NOT NULL,
  `view_margin` int(10) UNSIGNED NOT NULL,
  `simg1` varchar(250) NOT NULL,
  `simg2` varchar(250) NOT NULL,
  `simg3` varchar(250) NOT NULL,
  `simg4` varchar(250) NOT NULL,
  `simg5` varchar(250) NOT NULL,
  `simg6` varchar(250) NOT NULL,
  `simg7` varchar(250) NOT NULL,
  `simg8` varchar(250) NOT NULL,
  `simg9` varchar(250) NOT NULL,
  `simg10` varchar(250) NOT NULL,
  `simg11` varchar(250) NOT NULL,
  `simg12` varchar(250) NOT NULL,
  `simg13` varchar(250) NOT NULL,
  `movie` varchar(200) NOT NULL,
  `usesimg11` char(1) NOT NULL,
  `sizeinput` varchar(100) NOT NULL,
  `sizestd` int(10) UNSIGNED NOT NULL,
  `sizestd_img` varchar(100) NOT NULL,
  `addinfo_idx` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `isopen` char(1) NOT NULL DEFAULT '',
  `isshow` char(1) NOT NULL,
  `ispids` char(1) NOT NULL,
  `icons` text NOT NULL,
  `cicons` text NOT NULL,
  `opendate` datetime NOT NULL,
  `pmemo1` varchar(100) NOT NULL,
  `pmemo2` varchar(100) NOT NULL,
  `pmemo3` varchar(100) NOT NULL,
  `pmemo4` varchar(100) NOT NULL,
  `pmemo5` varchar(100) NOT NULL,
  `pmemo6` varchar(100) NOT NULL,
  `sizememo` text NOT NULL,
  `admin_memo` text NOT NULL COMMENT '관리자메모',
  `search_keyword` text NOT NULL,
  `admin_requ` varchar(2) NOT NULL,
  `custom_memo` text NOT NULL COMMENT '요약설명[상세]',
  `listimgcolor` varchar(250) NOT NULL,
  `locations` varchar(50) NOT NULL,
  `mordert` char(1) NOT NULL DEFAULT '1',
  `sellc` int(10) UNSIGNED NOT NULL,
  `cnt_review` int(10) UNSIGNED NOT NULL,
  `cnt_qna` int(10) UNSIGNED NOT NULL,
  `cvcou` int(10) UNSIGNED NOT NULL,
  `usecv` char(1) NOT NULL DEFAULT 'Y',
  `usecrv` char(1) NOT NULL DEFAULT 'Y',
  `ismake` char(1) NOT NULL COMMENT '매입구분Y:완사입,A:공정이용',
  `m_country` varchar(50) NOT NULL DEFAULT '한국',
  `m_maker` varchar(50) NOT NULL,
  `pids` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `detailshow` char(1) NOT NULL DEFAULT '1',
  `detailshow_height` int(10) UNSIGNED NOT NULL,
  `top1` text NOT NULL,
  `top2` text NOT NULL,
  `top3` text NOT NULL,
  `in_name` varchar(100) NOT NULL,
  `in_phone` varchar(50) NOT NULL,
  `count_read` int(10) UNSIGNED NOT NULL,
  `count_order` int(10) UNSIGNED NOT NULL,
  `count_cart` int(10) UNSIGNED NOT NULL,
  `count_wish` int(10) UNSIGNED NOT NULL,
  `count_qna` int(10) UNSIGNED NOT NULL,
  `count_review` int(10) UNSIGNED NOT NULL,
  `moddate` datetime NOT NULL,
  `memo_idx` int(10) UNSIGNED NOT NULL,
  `fid` tinyint(3) UNSIGNED NOT NULL,
  `sale_idx` int(10) UNSIGNED NOT NULL,
  `tmpaccount` int(10) UNSIGNED NOT NULL,
  `tmpsaccount` int(10) UNSIGNED NOT NULL,
  `osale_idx` int(10) UNSIGNED NOT NULL,
  `tmposaccount` int(10) UNSIGNED NOT NULL,
  `tmpossaccount` int(10) UNSIGNED NOT NULL,
  `resms` char(1) NOT NULL,
  `use_tem` char(1) NOT NULL DEFAULT 'N',
  `can_op` char(1) NOT NULL DEFAULT 'N' COMMENT '청약철회사용',
  `prodan` char(1) NOT NULL DEFAULT '1',
  `isdel` char(1) NOT NULL DEFAULT 'N',
  `last_idx` int(10) UNSIGNED NOT NULL,
  `shurl1` varchar(100) NOT NULL,
  `shurl2` varchar(100) NOT NULL,
  `sbj_idx` int(10) UNSIGNED NOT NULL,
  `sbj_per` int(10) UNSIGNED NOT NULL,
  `isok` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_lefts`
--

CREATE TABLE `shop_goods_lefts` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(50) NOT NULL,
  `op2` varchar(50) NOT NULL,
  `op3` varchar(50) NOT NULL,
  `lefts_f` int(10) NOT NULL,
  `lefts_l` int(10) NOT NULL,
  `lastsell` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_log`
--

CREATE TABLE `shop_goods_log` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `memo` longtext NOT NULL,
  `wdate` datetime NOT NULL,
  `mem_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_match`
--

CREATE TABLE `shop_goods_match` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(11) NOT NULL,
  `store_idx` int(11) NOT NULL DEFAULT '1',
  `match_idx` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isopen` tinyint(3) UNSIGNED NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_nimg`
--

CREATE TABLE `shop_goods_nimg` (
  `idx` int(10) UNSIGNED NOT NULL,
  `cgroup` tinyint(3) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `imgname` varchar(100) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `imgmap` text NOT NULL,
  `tmpidx` int(10) UNSIGNED NOT NULL,
  `memos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_op1`
--

CREATE TABLE `shop_goods_op1` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `rel_goods_idx` int(10) UNSIGNED NOT NULL,
  `opname` varchar(30) NOT NULL,
  `msgs` varchar(50) NOT NULL,
  `opname_CN1` varchar(100) NOT NULL,
  `opname_CN2` varchar(100) NOT NULL,
  `opname_EN` varchar(100) NOT NULL,
  `opname_JP` varchar(100) NOT NULL,
  `opname_add` varchar(30) NOT NULL,
  `opname_add2` varchar(30) NOT NULL,
  `cods` varchar(10) NOT NULL,
  `isuse` char(1) NOT NULL DEFAULT 'Y',
  `addac` int(10) NOT NULL,
  `adddac` int(10) UNSIGNED NOT NULL,
  `mop` char(1) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `last_idx` varchar(10) NOT NULL,
  `isdel` char(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_op2`
--

CREATE TABLE `shop_goods_op2` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `rel_goods_idx` int(10) UNSIGNED NOT NULL,
  `opname` varchar(30) NOT NULL,
  `msgs` varchar(50) NOT NULL,
  `opname_CN1` varchar(100) NOT NULL,
  `opname_CN2` varchar(100) NOT NULL,
  `opname_EN` varchar(100) NOT NULL,
  `opname_JP` varchar(100) NOT NULL,
  `opname_add` varchar(30) NOT NULL,
  `opname_add2` varchar(30) NOT NULL,
  `isuse` char(1) NOT NULL DEFAULT 'Y',
  `addac` int(10) NOT NULL,
  `adddac` int(10) UNSIGNED NOT NULL,
  `mop` char(1) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_op3`
--

CREATE TABLE `shop_goods_op3` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `rel_goods_idx` int(10) UNSIGNED NOT NULL,
  `opname` varchar(30) NOT NULL,
  `msgs` varchar(50) NOT NULL,
  `opname_CN1` varchar(100) NOT NULL,
  `opname_CN2` varchar(100) NOT NULL,
  `opname_EN` varchar(100) NOT NULL,
  `opname_JP` varchar(100) NOT NULL,
  `opname_add` varchar(30) NOT NULL,
  `opname_add2` varchar(30) NOT NULL,
  `cods` varchar(10) NOT NULL,
  `isuse` char(1) NOT NULL DEFAULT 'Y',
  `addac` int(10) UNSIGNED NOT NULL,
  `adddac` int(10) UNSIGNED NOT NULL,
  `mop` char(1) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_sale`
--

CREATE TABLE `shop_goods_sale` (
  `idx` int(10) UNSIGNED NOT NULL,
  `isdataout` char(1) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `pid` tinyint(3) UNSIGNED NOT NULL,
  `stype` char(1) NOT NULL,
  `saledays` int(10) UNSIGNED NOT NULL COMMENT '신상할인시할인시간',
  `subject` varchar(200) NOT NULL,
  `subject_cus` varchar(200) NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `salet` char(1) NOT NULL DEFAULT '1',
  `sale_t` char(1) NOT NULL,
  `sale_t_arr` text NOT NULL,
  `saleper` int(10) UNSIGNED NOT NULL,
  `saletype` int(11) NOT NULL,
  `saleper_std1` int(10) UNSIGNED NOT NULL,
  `saleper_std2` char(1) NOT NULL,
  `ar_icon` text NOT NULL,
  `reicon` char(1) NOT NULL,
  `saleops` char(1) NOT NULL,
  `saleop1` char(1) NOT NULL,
  `saleop2` char(1) NOT NULL,
  `saleop3` char(1) NOT NULL,
  `noreturn` char(1) NOT NULL,
  `nodels` char(1) NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_goods_sale`
--

INSERT INTO `shop_goods_sale` (`idx`, `isdataout`, `fid`, `pid`, `stype`, `saledays`, `subject`, `subject_cus`, `sdate`, `edate`, `salet`, `sale_t`, `sale_t_arr`, `saleper`, `saletype`, `saleper_std1`, `saleper_std2`, `ar_icon`, `reicon`, `saleops`, `saleop1`, `saleop2`, `saleop3`, `noreturn`, `nodels`, `wdate`) VALUES
(1, '', 1, 0, '1', 12, 'test', 'test', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '1', '', 2, 1, 0, '1', 'N;', 'Y', '', '1', '1', '1', 'Y', 'N', '2025-07-10 18:37:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_sale_ele`
--

CREATE TABLE `shop_goods_sale_ele` (
  `idx` int(10) UNSIGNED NOT NULL,
  `sale_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `img` varchar(100) NOT NULL,
  `memo` text NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_season`
--

CREATE TABLE `shop_goods_season` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL COMMENT '상품고유번호',
  `season_info` varchar(50) NOT NULL COMMENT '시즌정보'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_sets`
--

CREATE TABLE `shop_goods_sets` (
  `idx` int(10) UNSIGNED NOT NULL,
  `sets_idx` int(10) UNSIGNED NOT NULL,
  `sets_op` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `op2` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `op3` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ea` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_shops`
--

CREATE TABLE `shop_goods_shops` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `group_idx` int(10) UNSIGNED NOT NULL,
  `intype` char(1) NOT NULL DEFAULT '1',
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `usescm` char(1) NOT NULL DEFAULT 'N',
  `useid` varchar(100) NOT NULL COMMENT 'scm이용시아이디',
  `usepasswd` varchar(100) NOT NULL COMMENT 'scm이용시패스워드',
  `name` varchar(100) NOT NULL COMMENT '업체명',
  `businessnum` varchar(20) NOT NULL COMMENT '사업자등록번호',
  `businesspaper` varchar(200) NOT NULL,
  `cates1` varchar(20) NOT NULL COMMENT '업종',
  `cates2` varchar(20) NOT NULL COMMENT '업태',
  `daename` varchar(50) NOT NULL COMMENT '대표자',
  `daephone` varchar(50) NOT NULL COMMENT '대표자전화',
  `daeemail` varchar(50) NOT NULL COMMENT '대표자연락처',
  `damname` varchar(50) NOT NULL,
  `damgrade` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `cp` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `homepage` varchar(100) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `bankaccount` varchar(100) NOT NULL,
  `bankname` varchar(20) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `addr1` varchar(200) NOT NULL,
  `addr2` varchar(200) NOT NULL,
  `sellmethod` char(1) NOT NULL COMMENT '공급형태 수수료방식:1,공급가액 :2',
  `sellper` int(11) NOT NULL,
  `memo` text NOT NULL,
  `wdate` datetime NOT NULL,
  `useware` int(10) UNSIGNED NOT NULL,
  `lcode1` varchar(50) NOT NULL,
  `lcode2` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_shops_config`
--

CREATE TABLE `shop_goods_shops_config` (
  `idx` int(10) UNSIGNED NOT NULL,
  `in_idx` int(10) UNSIGNED NOT NULL,
  `delstype` char(1) NOT NULL,
  `delaccount` int(11) NOT NULL,
  `delaccount_std` int(11) NOT NULL,
  `szipcode` varchar(6) NOT NULL,
  `saddr1` varchar(200) NOT NULL,
  `saddr2` varchar(200) NOT NULL,
  `rzipcode` varchar(6) NOT NULL,
  `raddr1` varchar(200) NOT NULL,
  `raddr2` varchar(200) NOT NULL,
  `memo1` text NOT NULL,
  `memo2` text NOT NULL,
  `memo3` text NOT NULL,
  `usedels` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_shops_group`
--

CREATE TABLE `shop_goods_shops_group` (
  `idx` int(10) UNSIGNED NOT NULL,
  `gname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_goods_shops_group`
--

INSERT INTO `shop_goods_shops_group` (`idx`, `gname`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_shops_imgs`
--

CREATE TABLE `shop_goods_shops_imgs` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `imgname` varchar(100) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_showlang`
--

CREATE TABLE `shop_goods_showlang` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `lang` char(2) CHARACTER SET ucs2 NOT NULL,
  `tmp` char(1) CHARACTER SET ucs2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_showsite`
--

CREATE TABLE `shop_goods_showsite` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `tmp` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_goods_showsite`
--

INSERT INTO `shop_goods_showsite` (`idx`, `goods_idx`, `pid`, `tmp`) VALUES
(1, 1, 1, ''),
(2, 1, 2, ''),
(3, 1, 3, ''),
(4, 2, 1, ''),
(5, 2, 2, ''),
(6, 2, 3, '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_soldout`
--

CREATE TABLE `shop_goods_soldout` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(10) NOT NULL,
  `op2` varchar(10) NOT NULL,
  `op3` varchar(10) NOT NULL,
  `otype` char(1) NOT NULL,
  `ch_name` varchar(50) NOT NULL,
  `wdate_s` char(10) NOT NULL,
  `whour_s` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_goods_subcate`
--

CREATE TABLE `shop_goods_subcate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `catecode` varchar(10) NOT NULL,
  `lcatecode` varchar(100) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `tp` char(1) NOT NULL,
  `lcate` varchar(50) NOT NULL,
  `lcate2` varchar(10) NOT NULL,
  `last_idx` varchar(50) NOT NULL,
  `isfix` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_guide_config`
--

CREATE TABLE `shop_guide_config` (
  `idx` int(11) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `items` text NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_guide_config`
--

INSERT INTO `shop_guide_config` (`idx`, `subject`, `items`, `orders`) VALUES
(1, '1.어떤 용도로 사용하시나요?', '선물할 거예요,제가 쓸 거에요', 1),
(2, '2.어떤 계절에 맞는 향을 찾으세요?', '봄&여름,가을&겨울,계절 상관없어요', 2),
(3, '3.원하시는 계열을 선택해 주세요.', '플로럴,프루티,시트러스,우디,그린,워터리', 3),
(4, '4.원하시는 분위기를 선택해 주세요.', '#청순함,#봄비,#바캉스,#코튼,#홍차,#우아함', 4);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_intro_store`
--

CREATE TABLE `shop_intro_store` (
  `idx` int(10) UNSIGNED NOT NULL,
  `loca_idx` int(10) UNSIGNED NOT NULL,
  `lang` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `isnew` char(1) NOT NULL,
  `img` varchar(100) NOT NULL,
  `addr` varchar(250) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `lcode1` varchar(100) NOT NULL,
  `lcode2` varchar(100) NOT NULL,
  `imgs` varchar(100) NOT NULL,
  `isshow` char(1) NOT NULL,
  `wdate` datetime NOT NULL,
  `mdate` datetime NOT NULL,
  `up_idx` int(10) UNSIGNED NOT NULL,
  `etc_info` varchar(100) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_intro_store_loca`
--

CREATE TABLE `shop_intro_store_loca` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET ucs2 NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_journal`
--

CREATE TABLE `shop_journal` (
  `idx` int(11) NOT NULL,
  `cate` int(10) UNSIGNED NOT NULL,
  `lang` varchar(2) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `memo` text NOT NULL,
  `img` varchar(200) NOT NULL,
  `wdate` datetime NOT NULL,
  `isshow` char(1) NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_journal`
--

INSERT INTO `shop_journal` (`idx`, `cate`, `lang`, `subject`, `memo`, `img`, `wdate`, `isshow`, `isdel`) VALUES
(1, 4, 'ko', '산 중턱에서 내려다보는 서울의 정취: 콤포타블 커피 남산', '<div class=\"margin-top-xxl _comment_body_m202201189c42f7f1da444\"><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/4d5840087ad1d.jpg\"></p><p><br></p><p><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/8b9ddb0666e31.jpg\"></p><p><br></p><p style=\"text-align: center;\"><span style=\"color: rgb(153, 153, 153); font-size: 13px;\">(구)그랑핸드 남산점</span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">서울의 다섯 곳의 장소에 위치한 콤포타블 커피 중, 가장 높은 곳에 있는 남산점은 원래는 그랑핸드가 있던 곳이었습니다. 지어진 지 1년도 채 되지 않은 그랑핸드 남산점을 철거한 가장 큰 이유는 ‘이 풍경을 더 많은 사람들에게 보여주고 싶다’는 마음 때문이었습니다.</span></span></p><p><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/135e8c273e778.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/3cd222400e687.jpg\"></p><p><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">많은 정성과 시간, 비용을 담은 공간을 다시 저희 손으로 없앤다는 것이 아깝고 두렵기도 했지만 훨씬 더 많은 사람들이 이 멋진 공간을 향유하기를 바라며 오직 콤포타블 커피만을 위한 장소로 탈바꿈했습니다. 3면으로 펼쳐진 서울의 정취를 충분히 느끼실 수 있도록 창을 최대한 살리고, 좀 더 드라마틱한 무드를 위해 중앙에 레벨이 낮은 직사각형 영역을 형성해 공간을 가볍게 분리했습니다. 또한 중앙 공간 천장에는 곡선 형태의 캐노피를 만들어 창밖으로 보이는 풍경과 빛이 자연스럽게 반사될 수 있게 했습니다.&nbsp;</span></span></p><p><br></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/e0991d3cf2c33.jpg\"></p><p style=\"text-align: left;\"><br></p><p><br></p><p><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/addb4edb95ad9.jpg\"></p><p><br></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/979ba8e80b15a.jpg\"></p><p><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">처음 이 장소에 들어섰을 때 파노라마로 펼쳐진 서울의 정취가 가장 먼저 눈에 들어오길 바랬습니다. 커피 한 모금을 마시고 창가를 바라보았을 때, 시야가 확장되면서 생각도 여유로워지고, 쌓여 있던 고민이나 걱정이 조금은 가벼워지는 공간이 되기를 바랬습니다.&nbsp;</span></span></p><p><br></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/9990372516261.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/e5690772f5014.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/c6502081e172d.jpg\"></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><img src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/3af39b357d9c6.png\" class=\"fr-fic fr-dii\" data-files=\"[object Object]\"></span></span></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/2b31043e3b759.jpg\"></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">콤포타블 커피 남산점은 ‘서울’이라는 도시와 ‘자연’이라는 키워드의 조화로 탄생한 공간입니다. 서울의 중심이자 대표적인 랜드마크 중 하나인 남산의 초입에 위치하여, 도심 속에서도 자연과 함께하는 여유로운 경험을 선사할 수 있도록 설계되었습니다. 루프탑에서는 서울과 남산의 사계절을 그대로 느낄 수 있어 언제 와도 가슴이 탁 트이는 경험을 할 수 있습니다.</span></span></p><p><br></p><p><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/155ab853ed909.jpg\"></p><p style=\"text-align: left;\"><br></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><img src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/dcac037ffce2c.png\" class=\"fr-fic fr-dii\" data-files=\"[object Object]\"></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\">특히 콤포타블 커피 남산점의 시그니처가 된 소등식은 우연한 계기로 생겨났는데요, 일부러 3면 창에 모두 고급 전동 블라인드를 달았는데 자주 사용할 일이 없어 아쉬워하던 차에 효과적으로 블라인드를 사용할 만한 일이 무엇이 있을까 고민하다 나온 아이디어였습니다. 특정한 시간에 서울의 뷰가 한 번에 펼쳐진다면 훨씬 드라마틱한 경험이 될 것 같았고, 풍경을 주인공으로 만들기 위해선 매장의 모든 조명을 최소화해야 했기 때문에 자연스럽게 소등식 이벤트로 이어졌습니다. 처음에는 이걸 과연 고객님들이 좋아하실까, 음료 주문도 안되고 어두운데 불편해하시는 건 아닐까 걱정이 많았는데 다행히도 너무 많은 분들이 좋아해 주셔서 감사할 따름입니다.</span></span></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p style=\"text-align: left;\"><br><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/30d95187619c3.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/41dfe096fb5b6.jpg\"></p><p style=\"text-align: left;\"><br></p><p style=\"text-align: left;\"><img class=\"fr-dii\" src=\"https://cdn.imweb.me/upload/S202101157dd079a44b118/1b95e70fb8d80.jpg\"></p><p><span style=\"font-size: 14px;\"><span style=\"color: rgb(68, 68, 68);\"><br></span></span></p><p><span style=\"color: rgb(68, 68, 68); font-size: 14px;\">서울의 정취를 품은 콤포타블 커피 남산점은 잊히지 않는 추억을 만들어주고 싶은 모든 분들에게 훌륭한 선택이 됩니다. 친구와 연인, 가족과 함께 와도 항상 편안하면서도 특별한 순간이 되어주는 남산점에 언제든지 편하게 방문해 주세요.</span></p><p><br></p><p><br></p></div>', 'e5690772f5014.jpg', '2025-07-09 11:17:47', 'Y', 'N');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_journal_cate`
--

CREATE TABLE `shop_journal_cate` (
  `idx` int(11) NOT NULL,
  `catename` varchar(50) NOT NULL,
  `orders` int(11) NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_journal_cate`
--

INSERT INTO `shop_journal_cate` (`idx`, `catename`, `orders`, `isdel`) VALUES
(1, 'News', 1, 'N'),
(2, 'Culture', 2, 'N'),
(3, 'Life', 3, 'N'),
(4, 'Team', 4, 'N'),
(5, 'Essay', 5, 'N'),
(6, 'Film', 6, 'N');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_keyword_set`
--

CREATE TABLE `shop_keyword_set` (
  `idx` int(10) UNSIGNED NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isuse` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_list_best`
--

CREATE TABLE `shop_list_best` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mcode` varchar(10) NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `img` varchar(100) NOT NULL,
  `links` varchar(250) NOT NULL,
  `target` varchar(30) NOT NULL DEFAULT '_self',
  `text1` text NOT NULL,
  `text2` text NOT NULL,
  `text3` text NOT NULL,
  `text4` text NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_lookbook`
--

CREATE TABLE `shop_lookbook` (
  `idx` int(10) UNSIGNED NOT NULL,
  `subject` varchar(200) CHARACTER SET ucs2 NOT NULL,
  `memo` text NOT NULL,
  `wdate` datetime NOT NULL,
  `isshow` char(1) CHARACTER SET ucs2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_lookbook_goods`
--

CREATE TABLE `shop_lookbook_goods` (
  `idx` int(10) UNSIGNED NOT NULL,
  `lookbook_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_lookbook_photo`
--

CREATE TABLE `shop_lookbook_photo` (
  `idx` int(10) UNSIGNED NOT NULL,
  `lookbook_idx` int(10) UNSIGNED NOT NULL,
  `img1` varchar(100) CHARACTER SET ucs2 NOT NULL,
  `img2` varchar(100) CHARACTER SET ucs2 NOT NULL,
  `orders` int(11) NOT NULL,
  `isdel` char(1) CHARACTER SET ucs2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member`
--

CREATE TABLE `shop_member` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '이름',
  `id` varchar(50) NOT NULL DEFAULT '' COMMENT '아이디',
  `passwd` varchar(80) NOT NULL,
  `birthday` varchar(8) NOT NULL DEFAULT '' COMMENT '생일 일',
  `sex` char(1) NOT NULL DEFAULT 'M' COMMENT '성별',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '이메일',
  `phone` varchar(20) NOT NULL COMMENT '전화번호',
  `cp` varchar(20) NOT NULL COMMENT '핸드폰',
  `zip1` char(3) NOT NULL DEFAULT '' COMMENT '우편번호 앞자리',
  `zip2` char(3) NOT NULL DEFAULT '' COMMENT '우편번호 뒷자리',
  `zipcode` varchar(10) NOT NULL COMMENT '우편번호(신)',
  `addr1` varchar(200) NOT NULL DEFAULT '' COMMENT '주소1',
  `addr2` varchar(200) NOT NULL DEFAULT '' COMMENT '주소2',
  `mailser` char(1) NOT NULL DEFAULT '' COMMENT '메일 수신여부',
  `smsser` char(1) NOT NULL DEFAULT '' COMMENT '문주 수신여부',
  `signdate` datetime NOT NULL COMMENT '회원가입일',
  `lastlogin` datetime NOT NULL,
  `lastorder` char(10) NOT NULL,
  `lastip` varchar(30) NOT NULL,
  `mempoints` int(10) UNSIGNED NOT NULL COMMENT '적립금',
  `memcoins` int(10) UNSIGNED NOT NULL,
  `memaccounts` int(10) UNSIGNED NOT NULL COMMENT '예치금',
  `memgrade` tinyint(3) UNSIGNED NOT NULL,
  `amemgrade` tinyint(4) NOT NULL,
  `mempriv` varchar(30) NOT NULL,
  `buyac` int(10) UNSIGNED NOT NULL,
  `buyc` int(10) UNSIGNED NOT NULL,
  `canconnect` char(1) NOT NULL,
  `enterc` varchar(20) NOT NULL,
  `enterk` varchar(50) NOT NULL,
  `fid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `pid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `memgroup` char(1) NOT NULL DEFAULT '1',
  `ci` text NOT NULL,
  `di` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_member`
--

INSERT INTO `shop_member` (`idx`, `name`, `id`, `passwd`, `birthday`, `sex`, `email`, `phone`, `cp`, `zip1`, `zip2`, `zipcode`, `addr1`, `addr2`, `mailser`, `smsser`, `signdate`, `lastlogin`, `lastorder`, `lastip`, `mempoints`, `memcoins`, `memaccounts`, `memgrade`, `amemgrade`, `mempriv`, `buyac`, `buyc`, `canconnect`, `enterc`, `enterk`, `fid`, `pid`, `memgroup`, `ci`, `di`) VALUES
(1, '최고관리자', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 'M', '', '', '', '', '', '', '', '', '', '', '2025-07-08 19:06:34', '2025-07-10 18:03:03', '', '39.115.134.78', 0, 0, 0, 100, 1, '', 0, 0, 'Y', '', '', 1, 1, '1', '', ''),
(2, '최만종', 'gwontaegom@gmail.com', '1c83f5d240224fd2e473cd2e3c5d5594', '19800630', '1', '', '', '01037920814', '', '', '', '', '', 'Y', 'Y', '2025-07-09 00:08:18', '0000-00-00 00:00:00', '', '', 10000000, 0, 0, 100, 0, '', 0, 0, 'Y', '', '', 1, 1, '1', 'CWl0JQt5RNKDlP8iJxMCYkNjQAnkVC0/6B3lX4tSWwM7VhlQBvDiafifBInkBDtpaVBd8OtyuBw48VPvrLVq8Q==', ''),
(3, '오태호', 'taehooh97@gmail.com', 'b3ad32f2083b5d9912b80b79883cd2e0', '19970911', '1', '', '', '01022489784', '', '', '', '', '', 'Y', 'Y', '2025-07-09 00:27:06', '0000-00-00 00:00:00', '', '', 0, 0, 0, 100, 0, '', 0, 0, 'Y', '', '', 1, 1, '1', '0+nAPPgnWc/c8Rc8bxtNMiiq5UaFkpJcC5kErvcXQt9n1IFeTm7ZCJ7slXQ7ML6rWITRrqvIGKQ26F3wCBB43w==', 'MC0GCCqGSIb3DQIJAyEAlYmGxVUCEaN1apRBN9kDdzhVdfEvVbUUSHYYMsoW46M='),
(4, '오태호', 'dhxogh125@gmail.com', 'b3ad32f2083b5d9912b80b79883cd2e0', '19970911', '1', '', '', '01022489784', '', '', '', '', '', 'Y', 'Y', '2025-07-09 13:09:40', '0000-00-00 00:00:00', '', '', 0, 0, 0, 100, 0, '', 0, 0, 'Y', '', '', 1, 1, '1', '0+nAPPgnWc/c8Rc8bxtNMiiq5UaFkpJcC5kErvcXQt9n1IFeTm7ZCJ7slXQ7ML6rWITRrqvIGKQ26F3wCBB43w==', 'MC0GCCqGSIb3DQIJAyEAlYmGxVUCEaN1apRBN9kDdzhVdfEvVbUUSHYYMsoW46M='),
(5, '최만종', 'igwontae@naver.com', 'b131b838f2c025dfd424e25b2c229b62', '19800630', '1', '', '', '01037920814', '', '', '', '', '', 'Y', 'Y', '2025-07-10 08:19:33', '0000-00-00 00:00:00', '', '', 0, 0, 0, 100, 0, '', 0, 0, 'Y', '', '', 1, 1, '1', 'CWl0JQt5RNKDlP8iJxMCYkNjQAnkVC0/6B3lX4tSWwM7VhlQBvDiafifBInkBDtpaVBd8OtyuBw48VPvrLVq8Q==', ''),
(7, '최만종', 'admin@admin.com', 'b131b838f2c025dfd424e25b2c229b62', '19800630', '1', '', '', '01037920814', '', '', '', '', '', 'Y', 'Y', '2025-07-10 13:19:56', '0000-00-00 00:00:00', '', '', 0, 0, 0, 100, 0, '', 0, 0, 'Y', '', '', 1, 1, '1', 'CWl0JQt5RNKDlP8iJxMCYkNjQAnkVC0/6B3lX4tSWwM7VhlQBvDiafifBInkBDtpaVBd8OtyuBw48VPvrLVq8Q==', 'MC0GCCqGSIb3DQIJAyEA/xK2oo/HSzmtHGiplQbFpHeC4cOTxW3jAWgaG9q9OE8='),
(8, '오태호', 'dhxogh123123@naver.com', 'b3ad32f2083b5d9912b80b79883cd2e0', '19970911', '1', '', '', '01022489784', '', '', '', '', '', 'Y', 'Y', '2025-07-10 18:21:13', '0000-00-00 00:00:00', '', '', 0, 0, 0, 100, 0, '', 0, 0, 'Y', '', '', 1, 1, '1', '0+nAPPgnWc/c8Rc8bxtNMiiq5UaFkpJcC5kErvcXQt9n1IFeTm7ZCJ7slXQ7ML6rWITRrqvIGKQ26F3wCBB43w==', 'MC0GCCqGSIb3DQIJAyEAlYmGxVUCEaN1apRBN9kDdzhVdfEvVbUUSHYYMsoW46M=');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_addrs`
--

CREATE TABLE `shop_member_addrs` (
  `idx` int(11) NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `isbasic` char(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `delname` varchar(50) NOT NULL,
  `delcp` varchar(50) NOT NULL,
  `delzip` varchar(10) NOT NULL,
  `deladdr1` varchar(250) NOT NULL,
  `deladdr2` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_member_addrs`
--

INSERT INTO `shop_member_addrs` (`idx`, `mem_idx`, `isbasic`, `name`, `delname`, `delcp`, `delzip`, `deladdr1`, `deladdr2`) VALUES
(1, 2, 'N', 'text', '0', '01037920814', '06112', '서울 강남구 논현로123길 4-1', '1221321'),
(2, 2, 'Y', 'house', '1232132', '21321321312', '01012', '서울 강북구 4.19로12길 5', '12321321'),
(3, 3, 'N', 'Home', '오태호', '01022489784', '08591', '서울 금천구 가산디지털1로 2', '1234'),
(4, 3, 'N', 'test', 'Test', '01012341234', '08591', '서울 금천구 가산디지털1로 42', '1234');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_chlog`
--

CREATE TABLE `shop_member_chlog` (
  `idx` int(10) UNSIGNED NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_chlog_ele`
--

CREATE TABLE `shop_member_chlog_ele` (
  `idx` int(10) UNSIGNED NOT NULL,
  `chlog_idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `lmemgrade` int(10) UNSIGNED NOT NULL,
  `memgrade` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_grades`
--

CREATE TABLE `shop_member_grades` (
  `idx` int(10) UNSIGNED NOT NULL,
  `sfid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `pid` int(10) UNSIGNED NOT NULL,
  `group_idx` int(10) UNSIGNED NOT NULL,
  `grade_id` tinyint(3) UNSIGNED NOT NULL,
  `grade_name` varchar(50) NOT NULL,
  `grade_saveper` int(10) UNSIGNED NOT NULL,
  `grade_sv1` tinyint(4) NOT NULL,
  `grade_sv2` char(1) NOT NULL,
  `grade_savecau` varchar(10) NOT NULL,
  `grade_stand` int(10) UNSIGNED NOT NULL,
  `grade_discount` int(11) NOT NULL,
  `grade_canup` char(1) NOT NULL,
  `grade_up` int(10) UNSIGNED NOT NULL,
  `grade_nodels` char(1) NOT NULL,
  `grade_birth` int(10) UNSIGNED NOT NULL,
  `seller_per` int(10) UNSIGNED NOT NULL,
  `seller_out` varchar(10) NOT NULL,
  `enterb` char(1) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `iconl` varchar(50) NOT NULL,
  `noshowac` char(1) NOT NULL DEFAULT 'Y',
  `up_idx` int(10) UNSIGNED NOT NULL,
  `up_stand` int(10) UNSIGNED NOT NULL,
  `procode` varchar(30) NOT NULL,
  `memo1` text NOT NULL,
  `memo2` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_member_grades`
--

INSERT INTO `shop_member_grades` (`idx`, `sfid`, `pid`, `group_idx`, `grade_id`, `grade_name`, `grade_saveper`, `grade_sv1`, `grade_sv2`, `grade_savecau`, `grade_stand`, `grade_discount`, `grade_canup`, `grade_up`, `grade_nodels`, `grade_birth`, `seller_per`, `seller_out`, `enterb`, `icon`, `iconl`, `noshowac`, `up_idx`, `up_stand`, `procode`, `memo1`, `memo2`) VALUES
(1, 1, 0, 1, 100, 'Baisc', 0, 0, '', '', 0, 0, 'Y', 0, '', 0, 0, '', '', '', '', 'Y', 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_group`
--

CREATE TABLE `shop_member_group` (
  `idx` int(10) UNSIGNED NOT NULL,
  `groupname` varchar(30) NOT NULL,
  `member_joinpoint` int(10) UNSIGNED NOT NULL,
  `member_joinpoint_msg` varchar(100) NOT NULL,
  `member_joingrade` int(10) UNSIGNED NOT NULL,
  `member_joincoupen` varchar(50) NOT NULL,
  `member_birthday` tinyint(3) UNSIGNED NOT NULL,
  `member_birthcoupen` int(10) UNSIGNED NOT NULL COMMENT '회원생일쿠폰 고유번호',
  `member_joinsms` char(1) NOT NULL,
  `order_point_std` int(10) UNSIGNED NOT NULL,
  `order_point_cnt` tinyint(3) UNSIGNED NOT NULL,
  `order_min_point` int(10) UNSIGNED NOT NULL,
  `order_max_point1` int(10) UNSIGNED NOT NULL COMMENT '적립금사용최대치',
  `order_max_point2` char(1) NOT NULL COMMENT '적립금사용최대치1:원/2:%',
  `autogradeup` char(1) NOT NULL,
  `gradeupstd` char(1) NOT NULL COMMENT '자동등업주기',
  `gradeupstddays` tinyint(3) UNSIGNED NOT NULL COMMENT '등업사용데이터(개월)',
  `joincheck1` char(1) NOT NULL,
  `joincheck2` char(1) NOT NULL,
  `joincheck3` char(1) NOT NULL,
  `userevsp` char(1) NOT NULL,
  `modnick` char(1) NOT NULL,
  `modbirth` char(1) NOT NULL,
  `lastgradeup` char(10) NOT NULL,
  `usecheck` char(1) NOT NULL DEFAULT 'N',
  `checkreward` char(1) NOT NULL,
  `checkrewardg` int(10) UNSIGNED NOT NULL,
  `checkstd` char(1) NOT NULL,
  `checkstddays` int(10) UNSIGNED NOT NULL,
  `saveaddp` char(1) NOT NULL,
  `use_snslogin` char(1) NOT NULL COMMENT '간편로그인사용여부',
  `use_point` char(1) NOT NULL COMMENT '적립금사용여부',
  `kakao_key` varchar(250) NOT NULL,
  `fb_id` varchar(250) NOT NULL,
  `fb_secret` varchar(250) NOT NULL,
  `naver_id` varchar(250) NOT NULL,
  `naver_secret` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_member_group`
--

INSERT INTO `shop_member_group` (`idx`, `groupname`, `member_joinpoint`, `member_joinpoint_msg`, `member_joingrade`, `member_joincoupen`, `member_birthday`, `member_birthcoupen`, `member_joinsms`, `order_point_std`, `order_point_cnt`, `order_min_point`, `order_max_point1`, `order_max_point2`, `autogradeup`, `gradeupstd`, `gradeupstddays`, `joincheck1`, `joincheck2`, `joincheck3`, `userevsp`, `modnick`, `modbirth`, `lastgradeup`, `usecheck`, `checkreward`, `checkrewardg`, `checkstd`, `checkstddays`, `saveaddp`, `use_snslogin`, `use_point`, `kakao_key`, `fb_id`, `fb_secret`, `naver_id`, `naver_secret`) VALUES
(1, '기본회원그룹', 0, '', 100, '', 0, 0, '', 0, 0, 0, 0, '', 'Y', '', 0, '', '', '', '', '', '', '', 'N', '1', 0, '', 0, '', 'Y', 'Y', '', '', '', '', ''),
(2, 'test', 1000, '1000', 0, '', 7, 1, 'Y', 10000, 10, 100000, 10, '2', 'Y', '', 1, 'Y', 'Y', 'Y', '', '', '', '', 'Y', '1', 10000, '1', 0, '', 'Y', 'Y', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_out`
--

CREATE TABLE `shop_member_out` (
  `idx` int(10) UNSIGNED NOT NULL,
  `reason` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `memo` text NOT NULL,
  `wdate` datetime NOT NULL,
  `isover` datetime NOT NULL,
  `id` varchar(50) NOT NULL,
  `jumin1` char(6) NOT NULL,
  `jumin2` char(7) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_points`
--

CREATE TABLE `shop_member_points` (
  `idx` int(10) UNSIGNED NOT NULL,
  `market_idx` int(10) UNSIGNED NOT NULL,
  `board_idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `income` int(10) UNSIGNED NOT NULL,
  `outcome` int(10) UNSIGNED NOT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `oincome` float UNSIGNED NOT NULL,
  `ooutcome` float UNSIGNED NOT NULL,
  `ototal` float UNSIGNED NOT NULL,
  `memo` text NOT NULL,
  `wdate_s` varchar(10) NOT NULL,
  `hour_s` varchar(8) NOT NULL,
  `isauto` char(1) NOT NULL,
  `ch_name` varchar(20) NOT NULL,
  `codes` char(1) NOT NULL,
  `giveper` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_member_points`
--

INSERT INTO `shop_member_points` (`idx`, `market_idx`, `board_idx`, `mem_idx`, `income`, `outcome`, `total`, `oincome`, `ooutcome`, `ototal`, `memo`, `wdate_s`, `hour_s`, `isauto`, `ch_name`, `codes`, `giveper`) VALUES
(1, 0, 0, 2, 10000000, 0, 10000000, 0, 0, 0, 'test', '2025-07-10', '11:16:21', '', '', '', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_member_pre`
--

CREATE TABLE `shop_member_pre` (
  `idx` int(11) NOT NULL,
  `id` varchar(100) NOT NULL,
  `passwds` varchar(100) NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_member_pre`
--

INSERT INTO `shop_member_pre` (`idx`, `id`, `passwds`, `wdate`) VALUES
(4, 'asddfc@zdf.asdf', 'asdf1234!', '2025-07-09 20:31:27'),
(5, 'igwontae@naver.coms', 'jade0408!!!', '2025-07-10 08:49:15');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_movie`
--

CREATE TABLE `shop_movie` (
  `idx` int(10) UNSIGNED NOT NULL,
  `img` varchar(200) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `moviesite` varchar(200) NOT NULL,
  `movie` text NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `sbj_idx` int(10) UNSIGNED NOT NULL,
  `giveper` int(10) UNSIGNED NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N',
  `wdate` datetime NOT NULL,
  `mdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='shop_movie';

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_movie_schedule`
--

CREATE TABLE `shop_movie_schedule` (
  `idx` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `stime` time NOT NULL,
  `etime` time NOT NULL,
  `movie_idx` int(10) UNSIGNED NOT NULL,
  `wdate` datetime NOT NULL,
  `mdate` datetime NOT NULL,
  `memo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newbasket`
--

CREATE TABLE `shop_newbasket` (
  `idx` int(10) UNSIGNED NOT NULL,
  `market_idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `set_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `bgoods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(50) NOT NULL,
  `op2` varchar(50) NOT NULL,
  `op3` varchar(50) NOT NULL,
  `addoptions` varchar(200) NOT NULL,
  `gstrs` varchar(100) NOT NULL COMMENT '외부몰매칭전상품명',
  `opsstr` varchar(100) NOT NULL,
  `oraccount` int(10) UNSIGNED NOT NULL,
  `saccount` int(10) UNSIGNED NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `daccount` int(10) UNSIGNED NOT NULL,
  `gp1` int(10) UNSIGNED NOT NULL COMMENT '기본적립금',
  `gp2` int(10) UNSIGNED NOT NULL COMMENT '등급적립금',
  `use_sale_idx` int(10) UNSIGNED NOT NULL,
  `isnewsale` char(1) NOT NULL,
  `isgradesale` char(1) NOT NULL,
  `cancoup` char(1) NOT NULL,
  `coupac` int(10) UNSIGNED NOT NULL,
  `ea` int(10) UNSIGNED NOT NULL,
  `sdate` datetime NOT NULL,
  `haveo` varchar(10) NOT NULL,
  `enterc` varchar(50) NOT NULL,
  `ent` text NOT NULL,
  `gtype` char(1) NOT NULL DEFAULT '1',
  `gocom` varchar(30) NOT NULL,
  `gonumber` varchar(20) NOT NULL,
  `godate` datetime NOT NULL,
  `preason` tinyint(3) UNSIGNED NOT NULL,
  `pdan` char(1) NOT NULL,
  `pdate` datetime NOT NULL,
  `rdate1` datetime NOT NULL,
  `rdate2` datetime NOT NULL,
  `rdate3` datetime NOT NULL,
  `reea` int(10) UNSIGNED NOT NULL,
  `lfea` int(10) UNSIGNED NOT NULL,
  `up_idx` int(10) UNSIGNED NOT NULL,
  `iswr` char(1) NOT NULL,
  `issa` char(1) NOT NULL,
  `smain_idx` int(10) UNSIGNED NOT NULL,
  `sa_idx` int(10) UNSIGNED NOT NULL,
  `orderno1` varchar(50) NOT NULL,
  `orderno2` varchar(50) NOT NULL,
  `etcdata` varchar(50) NOT NULL,
  `out_idx` int(10) UNSIGNED NOT NULL,
  `isins` char(1) NOT NULL,
  `isouts` char(1) NOT NULL,
  `last1` varchar(100) NOT NULL,
  `opss` varchar(100) NOT NULL,
  `orno` varchar(50) NOT NULL,
  `etcdata1` varchar(50) NOT NULL,
  `etcdata2` varchar(50) NOT NULL,
  `is_in` char(1) NOT NULL COMMENT '입금확인여부',
  `is_in_time` datetime NOT NULL COMMENT '입금확인시간',
  `is_out` char(1) NOT NULL COMMENT '환불여부',
  `is_out_time` datetime NOT NULL COMMENT '환불완료시간',
  `isbuyok` int(10) UNSIGNED NOT NULL,
  `issellgive` char(1) NOT NULL,
  `issellgive_per` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_newbasket`
--

INSERT INTO `shop_newbasket` (`idx`, `market_idx`, `mem_idx`, `set_idx`, `goods_idx`, `bgoods_idx`, `op1`, `op2`, `op3`, `addoptions`, `gstrs`, `opsstr`, `oraccount`, `saccount`, `account`, `daccount`, `gp1`, `gp2`, `use_sale_idx`, `isnewsale`, `isgradesale`, `cancoup`, `coupac`, `ea`, `sdate`, `haveo`, `enterc`, `ent`, `gtype`, `gocom`, `gonumber`, `godate`, `preason`, `pdan`, `pdate`, `rdate1`, `rdate2`, `rdate3`, `reea`, `lfea`, `up_idx`, `iswr`, `issa`, `smain_idx`, `sa_idx`, `orderno1`, `orderno2`, `etcdata`, `out_idx`, `isins`, `isouts`, `last1`, `opss`, `orno`, `etcdata1`, `etcdata2`, `is_in`, `is_in_time`, `is_out`, `is_out_time`, `isbuyok`, `issellgive`, `issellgive_per`) VALUES
(1, 1, 2, 0, 1, 0, '', '', '', '', '', '', 0, 0, 35000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-09 22:46:57', '', '', '', '1', '', '', '2025-07-09 22:46:57', 0, '', '2025-07-09 22:46:57', '2025-07-09 22:46:57', '2025-07-09 22:46:57', '2025-07-09 22:46:57', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '2025-07-09 22:46:57', '', '2025-07-09 22:46:57', 0, '', 0),
(2, 2, 2, 0, 1, 0, '', '', '', '', '', '', 0, 0, 35000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:20:40', '', '', '', '1', '', '', '2025-07-10 07:20:40', 0, '', '2025-07-10 07:20:40', '2025-07-10 07:20:40', '2025-07-10 07:20:40', '2025-07-10 07:20:40', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '2025-07-10 07:20:40', '', '2025-07-10 07:20:40', 0, '', 0),
(3, 3, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:51:40', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(4, 4, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:52:22', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(5, 5, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:52:33', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(6, 6, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:52:40', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(7, 7, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:53:18', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(8, 8, 2, 0, 1, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:54:07', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(9, 8, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 2, '2025-07-10 07:54:07', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(10, 9, 2, 0, 1, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 07:54:54', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(11, 9, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 2, '2025-07-10 07:54:54', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(12, 10, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 10:58:43', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0),
(13, 11, 2, 0, 2, 0, '', '', '', '', '', '', 0, 3500000, 3500000, 0, 0, 0, 0, '', '', '', 0, 1, '2025-07-10 11:31:51', '', '', '', '1', '', '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', '', 0, 0, '', '', '', 0, '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newbasket_tmp`
--

CREATE TABLE `shop_newbasket_tmp` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `nomem` varchar(50) NOT NULL,
  `set_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `bgoods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(50) NOT NULL,
  `op2` varchar(50) NOT NULL,
  `op3` varchar(50) NOT NULL,
  `addoptions` varchar(200) NOT NULL,
  `ea` int(10) UNSIGNED NOT NULL,
  `ac` int(10) UNSIGNED NOT NULL,
  `sdate` datetime NOT NULL,
  `enterc` varchar(50) NOT NULL,
  `enterk` varchar(50) NOT NULL,
  `ent` text NOT NULL,
  `gtype` char(1) NOT NULL DEFAULT '1',
  `market_idx` int(10) UNSIGNED NOT NULL,
  `sfid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `spid` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `issa` char(1) NOT NULL COMMENT '사은품여부',
  `isdirect` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_newbasket_tmp`
--

INSERT INTO `shop_newbasket_tmp` (`idx`, `mem_idx`, `nomem`, `set_idx`, `goods_idx`, `bgoods_idx`, `op1`, `op2`, `op3`, `addoptions`, `ea`, `ac`, `sdate`, `enterc`, `enterk`, `ent`, `gtype`, `market_idx`, `sfid`, `spid`, `issa`, `isdirect`) VALUES
(19, 2, '', 0, 1, 0, '', '', '', '', 8, 0, '2025-07-10 14:22:53', '', '', '', '1', 0, 1, 1, '', 'N'),
(21, 3, '', 0, 1, 0, '', '', '', '', 14, 0, '2025-07-10 16:51:26', '', '', '', '1', 0, 1, 1, '', 'N'),
(22, 3, '', 0, 2, 0, '', '', '', '', 1, 0, '2025-07-10 16:58:09', '', '', '', '1', 0, 1, 1, '', 'N'),
(23, 0, 'vnrsndro726qurv08cj6skq4g6', 0, 1, 0, '', '', '', '', 1, 0, '2025-07-10 17:37:55', '', '', '', '1', 0, 1, 1, '', 'N'),
(24, 0, 'fb0c09qrtgku764lo2i2jbjgua', 0, 1, 0, '', '', '', '', 1, 0, '2025-07-10 18:51:32', '', '', '', '1', 0, 1, 1, '', 'N');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newcont`
--

CREATE TABLE `shop_newcont` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `cate` int(10) UNSIGNED NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memo` text CHARACTER SET utf8mb4 NOT NULL,
  `wdate` datetime NOT NULL,
  `isdel` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newcont_files`
--

CREATE TABLE `shop_newcont_files` (
  `idx` int(10) UNSIGNED NOT NULL,
  `newcont_idx` int(10) UNSIGNED NOT NULL,
  `filename` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filetype` char(1) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newcont_read`
--

CREATE TABLE `shop_newcont_read` (
  `idx` int(10) UNSIGNED NOT NULL,
  `newcont_idx` int(11) NOT NULL,
  `rdate` date NOT NULL,
  `rtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newcont_show`
--

CREATE TABLE `shop_newcont_show` (
  `idx` int(10) UNSIGNED NOT NULL,
  `newcont_idx` int(11) NOT NULL,
  `sdate` date NOT NULL,
  `stime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newmarketdb`
--

CREATE TABLE `shop_newmarketdb` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `from_idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `isgift` char(1) NOT NULL,
  `tocp` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwds` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `cp` varchar(30) NOT NULL,
  `del_name` varchar(50) NOT NULL,
  `del_name_etc` varchar(100) NOT NULL,
  `del_loc` char(1) NOT NULL DEFAULT '1',
  `del_zipcode` varchar(10) NOT NULL COMMENT '우편번호(신)',
  `del_addr1` varchar(100) NOT NULL,
  `del_addr2` varchar(100) NOT NULL,
  `del_phone` varchar(30) NOT NULL,
  `del_cp` varchar(30) NOT NULL,
  `memo` text NOT NULL,
  `sdate` datetime NOT NULL,
  `odate` datetime NOT NULL,
  `incdate` datetime NOT NULL,
  `dan` char(1) NOT NULL,
  `buymethod` char(1) NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `use_account` int(10) UNSIGNED NOT NULL,
  `use_mempoint` int(10) UNSIGNED NOT NULL,
  `use_memaccount` int(10) UNSIGNED NOT NULL,
  `use_memmoney` int(10) UNSIGNED NOT NULL,
  `use_coupen1` int(10) UNSIGNED NOT NULL,
  `use_coupen2` int(10) UNSIGNED NOT NULL,
  `disaccount` int(10) UNSIGNED NOT NULL,
  `delaccount` int(10) UNSIGNED NOT NULL,
  `adddelaccount` int(10) UNSIGNED NOT NULL,
  `del_ac_std` int(10) UNSIGNED NOT NULL,
  `trans1` float UNSIGNED NOT NULL,
  `trans2` float UNSIGNED NOT NULL,
  `trs` varchar(10) NOT NULL,
  `orderno` varchar(50) NOT NULL,
  `outorderno` varchar(50) NOT NULL,
  `intype` char(1) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `isstop` char(1) NOT NULL,
  `enterc` varchar(20) NOT NULL,
  `enterk` varchar(50) NOT NULL,
  `ent` text NOT NULL,
  `memg` int(10) UNSIGNED NOT NULL,
  `fid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `pid` tinyint(3) UNSIGNED NOT NULL,
  `isprint` char(1) NOT NULL,
  `isrev` int(10) UNSIGNED NOT NULL,
  `isfast` char(1) NOT NULL,
  `ishold` char(1) NOT NULL,
  `language` varchar(10) NOT NULL DEFAULT 'KO',
  `overdate` datetime NOT NULL,
  `useenv` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_newmarketdb`
--

INSERT INTO `shop_newmarketdb` (`idx`, `mem_idx`, `from_idx`, `name`, `isgift`, `tocp`, `email`, `passwds`, `phone`, `cp`, `del_name`, `del_name_etc`, `del_loc`, `del_zipcode`, `del_addr1`, `del_addr2`, `del_phone`, `del_cp`, `memo`, `sdate`, `odate`, `incdate`, `dan`, `buymethod`, `account`, `use_account`, `use_mempoint`, `use_memaccount`, `use_memmoney`, `use_coupen1`, `use_coupen2`, `disaccount`, `delaccount`, `adddelaccount`, `del_ac_std`, `trans1`, `trans2`, `trs`, `orderno`, `outorderno`, `intype`, `nip`, `isstop`, `enterc`, `enterk`, `ent`, `memg`, `fid`, `pid`, `isprint`, `isrev`, `isfast`, `ishold`, `language`, `overdate`, `useenv`) VALUES
(1, 2, 0, '최만종', '', '', '', '', '', '01037920814', '', '', '1', '04578', '서울시 금천구 가산디지털1로 16', '321호', '', '01037920814', '빠른 배송 요망', '2025-07-09 22:45:34', '2025-07-09 22:45:34', '2025-07-09 22:45:34', '2', 'C', 35000, 35000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', 0, 1, 3, '', 0, '', '', 'KO', '2025-07-09 22:45:34', ''),
(2, 0, 0, '최만종', 'Y', '01022489784', '', '', '', '01037920814', '', '', '1', '', '', '', '', '', '', '2025-07-10 07:19:15', '2025-07-10 07:19:15', '2025-07-10 07:19:15', '2', 'C', 35000, 35000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', 0, 1, 1, '', 0, '', '', 'KO', '2025-07-10 07:19:15', ''),
(3, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 07:51:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'C', 3500000, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752101500', '', '', '39.115.134.78', '', '', '', '', 100, 1, 2, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'M'),
(4, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 07:52:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'C', 3500000, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752101542', '', '', '39.115.134.78', '', '', '', '', 100, 1, 2, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'M'),
(5, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 07:52:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'C', 3500000, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752101553', '', '', '39.115.134.78', '', '', '', '', 100, 1, 2, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'M'),
(6, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 07:52:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'C', 3500000, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752101560', '', '', '39.115.134.78', '', '', '', '', 100, 1, 2, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'M'),
(7, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 07:53:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'C', 3500000, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752101598', '', '', '39.115.134.78', '', '', '', '', 100, 1, 2, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'M'),
(8, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 07:54:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'C', 10500000, 10500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752101647', '', '', '39.115.134.78', '', '', '', '', 100, 1, 1, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'PC'),
(9, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 07:54:54', '2025-07-10 07:55:47', '2025-07-10 07:55:47', '2', 'C', 10500000, 10500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752101694', '', '', '39.115.134.78', '', '', '', '', 100, 1, 1, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'PC'),
(10, 0, 2, '', 'Y', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 10:58:43', '2025-07-10 10:59:33', '2025-07-10 10:59:33', '2', 'C', 3500000, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752112723', '', '', '39.115.134.78', '', '', '', '', 100, 1, 1, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'PC'),
(11, 2, 0, '', '', '', '', '', '--', '', '', '', '1', '', '', '', '--', '', '', '2025-07-10 11:31:51', '2025-07-10 11:32:36', '2025-07-10 11:32:36', '2', 'C', 3500000, 3500000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'KRW', '1752114711', '', '', '211.234.197.227', '', '', '', '', 100, 1, 2, '', 0, '', '', 'ko', '0000-00-00 00:00:00', 'M');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newmarketdb_accounts`
--

CREATE TABLE `shop_newmarketdb_accounts` (
  `idx` int(10) UNSIGNED NOT NULL,
  `tbtype` char(1) NOT NULL,
  `market_idx` int(10) UNSIGNED NOT NULL,
  `buymethod` char(1) NOT NULL,
  `pgs` varchar(30) NOT NULL,
  `account` int(10) UNSIGNED NOT NULL,
  `oaccount` float UNSIGNED NOT NULL,
  `indate` char(10) NOT NULL,
  `inname` varchar(30) NOT NULL,
  `tno` varchar(50) NOT NULL,
  `acnum` varchar(50) NOT NULL,
  `banknum` varchar(30) NOT NULL,
  `incdaten` datetime NOT NULL,
  `incdate` char(10) NOT NULL,
  `inctime` char(8) NOT NULL,
  `isout` int(10) UNSIGNED NOT NULL,
  `incname` varchar(30) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `up_idx` int(10) UNSIGNED NOT NULL,
  `checkd` char(10) NOT NULL,
  `ukeys` varchar(100) NOT NULL,
  `cancelid` varchar(200) NOT NULL,
  `escw` varchar(100) NOT NULL,
  `isisp` varchar(10) NOT NULL,
  `actime` varchar(50) NOT NULL,
  `requdate` datetime NOT NULL,
  `usepg` varchar(50) NOT NULL,
  `usepgid` varchar(50) NOT NULL,
  `usepgid_etc` varchar(20) NOT NULL,
  `baskets` text NOT NULL,
  `rawdata` text NOT NULL COMMENT '거래요청 및 거래응답 데이터 시리얼라이즈'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_newmarketdb_accounts`
--

INSERT INTO `shop_newmarketdb_accounts` (`idx`, `tbtype`, `market_idx`, `buymethod`, `pgs`, `account`, `oaccount`, `indate`, `inname`, `tno`, `acnum`, `banknum`, `incdaten`, `incdate`, `inctime`, `isout`, `incname`, `memo`, `up_idx`, `checkd`, `ukeys`, `cancelid`, `escw`, `isisp`, `actime`, `requdate`, `usepg`, `usepgid`, `usepgid_etc`, `baskets`, `rawdata`) VALUES
(1, 'I', 1, 'C', '', 35000, 0, '', '', '', '', '', '2025-07-09 22:47:39', '', '', 0, '', '', 0, '', '', '', '', '', '', '2025-07-09 22:47:39', '', '', '', '', ''),
(2, 'I', 1, '', '', 35000, 0, '', '', '', '', '', '2025-07-10 07:21:21', '', '', 0, '', '', 0, '', '', '', '', '', '', '2025-07-10 07:21:21', '', '', '', '', ''),
(3, 'I', 9, 'C', '', 10500000, 0, '', '', '', '', '', '2025-07-10 07:55:47', '2025-07-10', '07:55:47', 0, '', '', 0, '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '', '', '{\"mId\":\"tvivarepublica\",\"lastTransactionKey\":\"txrd_a01jzrpdydan1fsdzg0wzwjqjf5\",\"paymentKey\":\"tviva202507100754559mmT7\",\"orderId\":\"gran_9\",\"orderName\":\"주문번호 : 9\",\"taxExemptionAmount\":0,\"status\":\"DONE\",\"requestedAt\":\"2025-07-10T07:54:55+09:00\",\"approvedAt\":\"2025-07-10T07:55:46+09:00\",\"useEscrow\":false,\"cultureExpense\":false,\"card\":{\"issuerCode\":\"41\",\"acquirerCode\":\"41\",\"number\":\"37798308****17*\",\"installmentPlanMonths\":0,\"isInterestFree\":false,\"interestPayer\":null,\"approveNo\":\"00000000\",\"useCardPoint\":false,\"cardType\":\"신용\",\"ownerType\":\"개인\",\"acquireStatus\":\"READY\",\"amount\":105000},\"virtualAccount\":null,\"transfer\":null,\"mobilePhone\":null,\"giftCertificate\":null,\"cashReceipt\":null,\"cashReceipts\":null,\"discount\":null,\"cancels\":null,\"secret\":\"ps_kYG57Eba3G6Zo6nb1nyz8pWDOxmA\",\"type\":\"NORMAL\",\"easyPay\":null,\"country\":\"KR\",\"failure\":null,\"isPartialCancelable\":true,\"receipt\":{\"url\":\"https://dashboard.tosspayments.com/receipt/redirection?transactionId=tviva202507100754559mmT7&ref=PX\"},\"checkout\":{\"url\":\"https://api.tosspayments.com/v1/payments/tviva202507100754559mmT7/checkout\"},\"currency\":\"KRW\",\"totalAmount\":105000,\"balanceAmount\":105000,\"suppliedAmount\":95455,\"vat\":9545,\"taxFreeAmount\":0,\"method\":\"카드\",\"version\":\"2022-11-16\",\"metadata\":null}'),
(4, 'I', 10, 'C', '', 3500000, 0, '', '', '', '', '', '2025-07-10 10:59:33', '2025-07-10', '10:59:33', 0, '', '', 0, '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '', '', '{\"mId\":\"tvivarepublica\",\"lastTransactionKey\":\"txrd_a01jzs0ydvb0wn2xcknhn4jxqqb\",\"paymentKey\":\"tviva202507101058448pLi2\",\"orderId\":\"gran_10\",\"orderName\":\"주문번호 : 10\",\"taxExemptionAmount\":0,\"status\":\"DONE\",\"requestedAt\":\"2025-07-10T10:58:44+09:00\",\"approvedAt\":\"2025-07-10T10:59:32+09:00\",\"useEscrow\":false,\"cultureExpense\":false,\"card\":{\"issuerCode\":\"41\",\"acquirerCode\":\"41\",\"number\":\"37798308****17*\",\"installmentPlanMonths\":0,\"isInterestFree\":false,\"interestPayer\":null,\"approveNo\":\"00000000\",\"useCardPoint\":false,\"cardType\":\"신용\",\"ownerType\":\"개인\",\"acquireStatus\":\"READY\",\"amount\":35000},\"virtualAccount\":null,\"transfer\":null,\"mobilePhone\":null,\"giftCertificate\":null,\"cashReceipt\":null,\"cashReceipts\":null,\"discount\":null,\"cancels\":null,\"secret\":\"ps_LkKEypNArWDNOzLB542L8lmeaxYG\",\"type\":\"NORMAL\",\"easyPay\":null,\"country\":\"KR\",\"failure\":null,\"isPartialCancelable\":true,\"receipt\":{\"url\":\"https://dashboard.tosspayments.com/receipt/redirection?transactionId=tviva202507101058448pLi2&ref=PX\"},\"checkout\":{\"url\":\"https://api.tosspayments.com/v1/payments/tviva202507101058448pLi2/checkout\"},\"currency\":\"KRW\",\"totalAmount\":35000,\"balanceAmount\":35000,\"suppliedAmount\":31818,\"vat\":3182,\"taxFreeAmount\":0,\"method\":\"카드\",\"version\":\"2022-11-16\",\"metadata\":null}'),
(5, 'I', 11, 'C', '', 3500000, 0, '', '', '', '', '', '2025-07-10 11:32:36', '2025-07-10', '11:32:36', 0, '', '', 0, '', '', '', '', '', '', '0000-00-00 00:00:00', '', '', '', '', '{\"mId\":\"tvivarepublica\",\"lastTransactionKey\":\"txrd_a01jzs2tz1k9fmfx763mq37ex3t\",\"paymentKey\":\"tviva20250710113152acE64\",\"orderId\":\"granh_11\",\"orderName\":\"주문번호 : 11\",\"taxExemptionAmount\":0,\"status\":\"DONE\",\"requestedAt\":\"2025-07-10T11:31:52+09:00\",\"approvedAt\":\"2025-07-10T11:32:36+09:00\",\"useEscrow\":false,\"cultureExpense\":false,\"card\":{\"issuerCode\":\"41\",\"acquirerCode\":\"41\",\"number\":\"37798308****17*\",\"installmentPlanMonths\":0,\"isInterestFree\":false,\"interestPayer\":null,\"approveNo\":\"00000000\",\"useCardPoint\":false,\"cardType\":\"신용\",\"ownerType\":\"개인\",\"acquireStatus\":\"READY\",\"amount\":35000},\"virtualAccount\":null,\"transfer\":null,\"mobilePhone\":null,\"giftCertificate\":null,\"cashReceipt\":null,\"cashReceipts\":null,\"discount\":null,\"cancels\":null,\"secret\":\"ps_0RnYX2w532woWnKEGONgVNeyqApQ\",\"type\":\"NORMAL\",\"easyPay\":null,\"country\":\"KR\",\"failure\":null,\"isPartialCancelable\":true,\"receipt\":{\"url\":\"https://dashboard.tosspayments.com/receipt/redirection?transactionId=tviva20250710113152acE64&ref=PX\"},\"checkout\":{\"url\":\"https://api.tosspayments.com/v1/payments/tviva20250710113152acE64/checkout\"},\"currency\":\"KRW\",\"totalAmount\":35000,\"balanceAmount\":35000,\"suppliedAmount\":31818,\"vat\":3182,\"taxFreeAmount\":0,\"method\":\"카드\",\"version\":\"2022-11-16\",\"metadata\":null}');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newmarketdb_memo`
--

CREATE TABLE `shop_newmarketdb_memo` (
  `idx` int(10) UNSIGNED NOT NULL,
  `cate1` int(10) UNSIGNED NOT NULL,
  `cate2` int(10) UNSIGNED NOT NULL,
  `cate3` int(10) UNSIGNED NOT NULL,
  `mtype` char(1) NOT NULL DEFAULT '4',
  `iscl` char(1) NOT NULL DEFAULT '2',
  `isouts` char(1) NOT NULL,
  `isins` char(1) NOT NULL,
  `isscore` char(1) NOT NULL DEFAULT '1' COMMENT '중요도 1기본',
  `market_idx` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `wtype` varchar(30) NOT NULL DEFAULT '기타',
  `memo` text NOT NULL,
  `wdate` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `writer_idx` int(10) UNSIGNED NOT NULL,
  `writer_s` varchar(100) NOT NULL DEFAULT '',
  `isauto` char(1) NOT NULL,
  `ischeck` char(1) NOT NULL,
  `ischeck2` char(1) NOT NULL,
  `isstop` char(1) NOT NULL,
  `up_idx` int(10) UNSIGNED NOT NULL,
  `resultdate` datetime NOT NULL,
  `resultname` varchar(50) NOT NULL,
  `resultmemo` text NOT NULL,
  `isdelay` char(1) NOT NULL COMMENT '지연안내메모여부',
  `delaydate` date NOT NULL COMMENT '지연안내일',
  `to_idx1` int(10) UNSIGNED NOT NULL,
  `to_idx2` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_newmarketdb_sms`
--

CREATE TABLE `shop_newmarketdb_sms` (
  `idx` int(10) UNSIGNED NOT NULL,
  `market_idx` int(10) UNSIGNED NOT NULL,
  `basket_idx` int(10) UNSIGNED NOT NULL,
  `sms_idx` int(11) NOT NULL,
  `memo` text NOT NULL,
  `cp` varchar(20) NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `mem_name` varchar(30) NOT NULL,
  `wdate` int(10) UNSIGNED NOT NULL,
  `islms` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_nows`
--

CREATE TABLE `shop_nows` (
  `keys_v` varchar(40) NOT NULL DEFAULT '',
  `member_idx` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `end_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_popup`
--

CREATE TABLE `shop_popup` (
  `idx` int(10) UNSIGNED NOT NULL,
  `width` int(10) UNSIGNED NOT NULL,
  `height` int(10) UNSIGNED NOT NULL,
  `lefts` int(10) UNSIGNED NOT NULL,
  `top` int(10) UNSIGNED NOT NULL,
  `links` varchar(200) NOT NULL,
  `imgmap` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `file` varchar(100) NOT NULL,
  `ismove` char(1) NOT NULL,
  `isclose` char(1) NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `wdate` datetime NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `bgcolor` varchar(7) NOT NULL,
  `fontcolor` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_qna`
--

CREATE TABLE `shop_qna` (
  `idx` int(10) UNSIGNED NOT NULL,
  `btype` tinyint(4) NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `market_idx` int(10) NOT NULL,
  `cate` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `issec` char(1) NOT NULL DEFAULT 'Y',
  `mem_idx` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `mem_name` varchar(30) NOT NULL,
  `mem_id` varchar(50) NOT NULL,
  `cp` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL COMMENT 'QNA 이메일',
  `subject` varchar(200) NOT NULL DEFAULT '',
  `memo` text NOT NULL,
  `file1` varchar(100) NOT NULL,
  `file2` varchar(100) NOT NULL,
  `wdate` datetime NOT NULL,
  `nip` varchar(20) NOT NULL DEFAULT '',
  `result` char(1) NOT NULL DEFAULT 'N',
  `resultwriter` varchar(20) NOT NULL,
  `resultmemo` text NOT NULL,
  `resultdate` datetime NOT NULL,
  `isdel` char(1) NOT NULL DEFAULT 'N',
  `passwds` varchar(250) NOT NULL,
  `isjak` char(1) NOT NULL,
  `delname` varchar(30) NOT NULL,
  `last_idx` int(10) UNSIGNED NOT NULL,
  `last_idx1` int(10) UNSIGNED NOT NULL,
  `last_idx2` varchar(20) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `language` varchar(3) NOT NULL DEFAULT 'KO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_qna_attach`
--

CREATE TABLE `shop_qna_attach` (
  `idx` int(10) UNSIGNED NOT NULL,
  `qna_idx` int(10) UNSIGNED NOT NULL,
  `fname` varchar(200) NOT NULL,
  `orfname` varchar(200) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL,
  `ftype` char(1) NOT NULL,
  `tp` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_qna_cate`
--

CREATE TABLE `shop_qna_cate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(30) NOT NULL DEFAULT '',
  `isuse` char(1) NOT NULL DEFAULT 'Y',
  `ismember` char(1) NOT NULL,
  `basememo` longtext NOT NULL,
  `basemmemo` text NOT NULL,
  `isgoods` char(1) NOT NULL,
  `iswork` char(1) NOT NULL,
  `fid` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_qna_cate`
--

INSERT INTO `shop_qna_cate` (`idx`, `catename`, `isuse`, `ismember`, `basememo`, `basemmemo`, `isgoods`, `iswork`, `fid`) VALUES
(1, 'test', 'Y', '', '', '', 'Y', '', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_qna_config`
--

CREATE TABLE `shop_qna_config` (
  `idx` int(10) UNSIGNED NOT NULL,
  `qnawg` char(1) NOT NULL,
  `issecret` char(1) NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `newicon_file` varchar(30) NOT NULL,
  `newicon_day` tinyint(3) UNSIGNED NOT NULL,
  `secfile` varchar(100) NOT NULL,
  `listnum` tinyint(3) UNSIGNED NOT NULL,
  `qna_usesms` char(1) NOT NULL,
  `qna_uselms` char(1) NOT NULL,
  `qna_url` varchar(50) NOT NULL,
  `qnaicon1` varchar(150) NOT NULL,
  `qnaicon2` varchar(150) NOT NULL,
  `qnaicon3` varchar(250) NOT NULL,
  `mqnaicon1` varchar(250) NOT NULL,
  `mqnaicon2` varchar(250) NOT NULL,
  `mqnaicon3` varchar(250) NOT NULL,
  `usewriter` varchar(30) NOT NULL,
  `usewriter_cou` int(10) UNSIGNED NOT NULL,
  `usefile` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_qna_templete`
--

CREATE TABLE `shop_qna_templete` (
  `idx` int(10) UNSIGNED NOT NULL,
  `subject` varchar(200) NOT NULL,
  `memo` text NOT NULL,
  `fid` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `mem_idx` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_sa`
--

CREATE TABLE `shop_sa` (
  `idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `cuname` varchar(200) NOT NULL,
  `gt` varchar(10) NOT NULL,
  `sdate` char(10) NOT NULL,
  `edate` char(10) NOT NULL,
  `wdate` datetime NOT NULL,
  `rtype` char(1) NOT NULL,
  `rtype_sub` varchar(10) NOT NULL,
  `rtype_data` varchar(30) NOT NULL,
  `account1` int(10) UNSIGNED NOT NULL,
  `account2` int(10) UNSIGNED NOT NULL,
  `img` varchar(100) NOT NULL,
  `give_goods_idx` int(10) UNSIGNED NOT NULL,
  `give_goods_name` varchar(100) NOT NULL,
  `saveper` int(10) UNSIGNED NOT NULL,
  `links` varchar(200) NOT NULL,
  `fid` tinyint(4) NOT NULL DEFAULT '1',
  `showsite` char(1) NOT NULL,
  `islogin` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_sa_dae`
--

CREATE TABLE `shop_sa_dae` (
  `idx` int(10) UNSIGNED NOT NULL,
  `sa_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_sa_ele`
--

CREATE TABLE `shop_sa_ele` (
  `idx` int(10) UNSIGNED NOT NULL,
  `sa_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(30) NOT NULL,
  `op2` varchar(30) NOT NULL,
  `op3` varchar(30) NOT NULL,
  `ea` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `isrand` char(1) NOT NULL,
  `isuse` char(1) NOT NULL,
  `usepoint` int(10) UNSIGNED NOT NULL,
  `sapoint` int(10) UNSIGNED NOT NULL,
  `saorder` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_search_keyword`
--

CREATE TABLE `shop_search_keyword` (
  `idx` int(10) UNSIGNED NOT NULL,
  `keyword` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_show_tags`
--

CREATE TABLE `shop_show_tags` (
  `idx` int(10) UNSIGNED NOT NULL,
  `stypes` char(1) NOT NULL,
  `l_idx` int(10) UNSIGNED NOT NULL,
  `tags` int(10) UNSIGNED NOT NULL,
  `tp` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_sites`
--

CREATE TABLE `shop_sites` (
  `idx` int(10) UNSIGNED NOT NULL,
  `sitename` varchar(50) NOT NULL,
  `isout` char(1) NOT NULL,
  `site_url` varchar(100) NOT NULL,
  `dbhost` varchar(30) NOT NULL,
  `dbname` varchar(50) NOT NULL,
  `dbuser` varchar(50) NOT NULL,
  `dbpw` varchar(50) NOT NULL,
  `dbparam` varchar(50) NOT NULL,
  `pgcom` varchar(10) NOT NULL,
  `pgid` varchar(30) NOT NULL,
  `pgkey1` text NOT NULL,
  `mobil_id1` varchar(30) NOT NULL,
  `mobil_id2` varchar(30) NOT NULL,
  `mdom` varchar(50) NOT NULL,
  `useltype` char(1) NOT NULL,
  `givelefts` char(1) NOT NULL,
  `givechange` char(1) NOT NULL COMMENT '교환할당처리',
  `delcom` varchar(30) NOT NULL COMMENT '배송업체',
  `delcode` varchar(20) NOT NULL COMMENT '배송업체 계약코드',
  `naverepimg` varchar(6) NOT NULL,
  `navereppre` varchar(50) NOT NULL,
  `usesitetem` char(1) NOT NULL,
  `usecheck` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_sites`
--

INSERT INTO `shop_sites` (`idx`, `sitename`, `isout`, `site_url`, `dbhost`, `dbname`, `dbuser`, `dbpw`, `dbparam`, `pgcom`, `pgid`, `pgkey1`, `mobil_id1`, `mobil_id2`, `mdom`, `useltype`, `givelefts`, `givechange`, `delcom`, `delcode`, `naverepimg`, `navereppre`, `usesitetem`, `usecheck`) VALUES
(1, '그랑핸즈', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_situation_msg`
--

CREATE TABLE `shop_situation_msg` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) NOT NULL COMMENT '사용처',
  `mode` varchar(255) NOT NULL COMMENT 'key',
  `data` varchar(255) NOT NULL COMMENT 'value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='상황별문자' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_stores`
--

CREATE TABLE `shop_stores` (
  `idx` int(11) NOT NULL,
  `brand_idx` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `addr` varchar(200) NOT NULL,
  `isshow` char(1) NOT NULL,
  `orders` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_stores`
--

INSERT INTO `shop_stores` (`idx`, `brand_idx`, `name`, `addr`, `isshow`, `orders`) VALUES
(1, 1, '광화문', '강남구 언주로164길 17 3층', 'Y', 1),
(2, 1, '도산', '', 'Y', 2),
(3, 1, '남산', '', 'Y', 3);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_stores_imgs`
--

CREATE TABLE `shop_stores_imgs` (
  `idx` int(11) NOT NULL,
  `store_idx` int(11) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `orders` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_stores_imgs`
--

INSERT INTO `shop_stores_imgs` (`idx`, `store_idx`, `filename`, `orders`) VALUES
(1, 1, '1.png', 1),
(2, 1, '2.png', 2);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_store_connect`
--

CREATE TABLE `shop_store_connect` (
  `idx` int(10) UNSIGNED NOT NULL,
  `store_idx` int(11) NOT NULL,
  `mallid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accesskey` text CHARACTER SET utf8mb4 NOT NULL,
  `refreshkey` text CHARACTER SET utf8mb4 NOT NULL,
  `expires` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_subcate`
--

CREATE TABLE `shop_subcate` (
  `idx` int(10) UNSIGNED NOT NULL,
  `catename` varchar(50) NOT NULL,
  `catecode` varchar(6) NOT NULL,
  `upcate` varchar(6) NOT NULL,
  `catetype` char(1) NOT NULL,
  `isnew` char(1) NOT NULL,
  `newdays` int(10) UNSIGNED NOT NULL,
  `best1` int(10) UNSIGNED NOT NULL,
  `best2` int(10) UNSIGNED NOT NULL,
  `memo` longtext NOT NULL,
  `bestcou` int(10) UNSIGNED NOT NULL,
  `isauto` char(1) NOT NULL,
  `tmp_idx` int(10) UNSIGNED NOT NULL,
  `ctype` char(1) NOT NULL,
  `catetitle` varchar(100) NOT NULL,
  `fid` tinyint(3) UNSIGNED NOT NULL,
  `salestart` varchar(19) NOT NULL,
  `saleend` varchar(19) NOT NULL,
  `saveper` int(10) UNSIGNED NOT NULL,
  `numper` int(10) UNSIGNED NOT NULL,
  `isshow` char(1) NOT NULL,
  `isbestcate` char(1) NOT NULL,
  `htmls` text NOT NULL,
  `icons` text NOT NULL,
  `listskins` int(10) UNSIGNED NOT NULL,
  `rorders` int(10) UNSIGNED NOT NULL,
  `noper` char(1) NOT NULL,
  `search_idx` int(10) UNSIGNED NOT NULL COMMENT '검색연결',
  `showbrand` text NOT NULL,
  `last_idx` varchar(50) NOT NULL,
  `toptype` char(1) NOT NULL,
  `topimg` varchar(100) NOT NULL,
  `topmemo` text NOT NULL,
  `showsites` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_timesale`
--

CREATE TABLE `shop_timesale` (
  `idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `isshow` char(1) NOT NULL,
  `nolimit` char(1) NOT NULL DEFAULT 'N',
  `totalcount` int(10) UNSIGNED NOT NULL,
  `sorders` int(10) UNSIGNED NOT NULL,
  `img` varchar(200) NOT NULL,
  `givesset` varchar(200) NOT NULL,
  `gives1` text NOT NULL,
  `gives2` text NOT NULL,
  `gives3` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_timesale_sellcou`
--

CREATE TABLE `shop_timesale_sellcou` (
  `idx` int(10) UNSIGNED NOT NULL,
  `deal_idx` int(10) UNSIGNED NOT NULL,
  `op1` varchar(50) NOT NULL,
  `op2` varchar(50) NOT NULL,
  `op3` varchar(50) NOT NULL,
  `sellcous` int(10) UNSIGNED NOT NULL,
  `mcous` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_trans`
--

CREATE TABLE `shop_trans` (
  `idx` int(10) UNSIGNED NOT NULL,
  `lang` char(2) NOT NULL,
  `wordkeys` varchar(100) NOT NULL,
  `chwords` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_trans`
--

INSERT INTO `shop_trans` (`idx`, `lang`, `wordkeys`, `chwords`) VALUES
(1, 'ko', '신용카드', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_transsc`
--

CREATE TABLE `shop_transsc` (
  `idx` int(10) UNSIGNED NOT NULL,
  `lang` char(2) NOT NULL,
  `wordkeys` varchar(100) NOT NULL,
  `chwords` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `shop_transsc`
--

INSERT INTO `shop_transsc` (`idx`, `lang`, `wordkeys`, `chwords`) VALUES
(1, 'ko', 'CART1', '장바구니가 비었습니다.'),
(2, 'ko', 'CART2', '주문하실 상품에 체크해주세요.'),
(3, 'ko', 'CART3', '주문하시겠습니까?'),
(4, 'ko', 'CART4', '삭제할 상품에 체크하세요.'),
(5, 'ko', 'CART5', '장바구니에서 상품을 삭제하시겠습니까?'),
(6, 'ko', 'CART6', '장바구니에서 상품을 삭제하였습니다.'),
(7, 'ko', 'COMMON1', '잘못된 접근입니다'),
(8, 'ko', 'JOIN1', '이용약관에 동의하셔야 가입이 가능합니다.'),
(9, 'ko', 'JOIN10', '휴대폰번호를 입력하세요.'),
(10, 'ko', 'JOIN11', '아이디를 입력하신후에 중복확인 버튼을 눌러 주세요!'),
(11, 'ko', 'JOIN12', '아이디는 영문자(소문자) 또는 영문자(소문자)/숫자 조합으로 입력해주세요(숫자만 아이디생성 불가)'),
(12, 'ko', 'JOIN13', '입력하신 아이디는 사용이 가능합니다'),
(13, 'ko', 'JOIN14', '입력하신 아이디는 사용이 불가능합니다'),
(14, 'ko', 'JOIN15', '회원가입 하시겠습니까?'),
(15, 'ko', 'JOIN16', '아이디 중복확인후 회원가입이 가능합니다'),
(16, 'ko', 'JOIN17', '회원가입에 실패하였습니다.'),
(17, 'ko', 'JOIN18', '회원가입이 완료되었습니다.'),
(18, 'ko', 'JOIN2', '개인정보 취급방침에 동의하셔야 가입이 가능합니다.'),
(19, 'ko', 'JOIN3', '아이디를 입력하세요.'),
(20, 'ko', 'JOIN4', '비밀번호를 입력하세요.'),
(21, 'ko', 'JOIN5', '이름을 입력하세요.'),
(22, 'ko', 'JOIN6', '이름을 입력하세요.'),
(23, 'ko', 'JOIN7', '성을 입력하세요.'),
(24, 'ko', 'JOIN8', '이메일을 입력하세요.'),
(25, 'ko', 'JOIN9', '전화번호를 입력하세요.'),
(26, 'ko', 'LOGIN1', '이미 로그인 되어 있습니다.'),
(27, 'ko', 'LOGIN2', '아이디를 입력하세요.'),
(28, 'ko', 'LOGIN3', '비밀번호를 입력하세요.'),
(29, 'ko', 'LOGIN4', '로그인하실 수 없습니다.'),
(30, 'ko', 'LOGIN5', '아이디 혹은 비밀번호가 잘못되었습니다.'),
(31, 'ko', 'PAGE1', '페이지의 처음입니다..'),
(32, 'ko', 'PAGE2', '페이지의 마지막입니다.'),
(33, 'ko', 'SEARCH1', '검색어를 입력하세요.'),
(34, 'ko', 'VIEW1', '옵션을 선택하세요.'),
(35, 'ko', 'VIEW2', '장바구니에 저장하였습니다. 장바구니로 이동 하시겠습니까?'),
(36, 'ko', 'VIEW3', '수량은 1개 이상이어야 합니다.'),
(37, 'en', 'CART1', 'Your cart is empty.'),
(38, 'en', 'CART2', 'Check the item(s) you wish to order.'),
(39, 'en', 'CART3', 'Would you like to order?'),
(40, 'en', 'CART4', 'Check the item(s) you wish to delete.'),
(41, 'en', 'CART5', 'Would you like to delete the item(s)?'),
(42, 'en', 'CART6', 'Items have been deleted.'),
(43, 'en', 'COMMON1', 'Wrong access.'),
(44, 'en', 'JOIN1', 'You must agree to the Terms and Conditions to register.'),
(45, 'en', 'JOIN10', 'Please enter a mobile phone number.'),
(46, 'en', 'JOIN12', 'Enter a combination of lower case letters/numbers for your ID.  (IDs cannot be created with only numbers.)'),
(47, 'en', 'JOIN13', 'This ID is available.'),
(48, 'en', 'JOIN14', 'This ID is not available.'),
(49, 'en', 'JOIN15', 'Would you like to join?'),
(50, 'en', 'JOIN16', 'You can join after checking the availability of your ID.'),
(51, 'en', 'JOIN17', 'You have failed to join.'),
(52, 'en', 'JOIN18', 'You have successfully joined.'),
(53, 'en', 'JOIN2', 'You can join after agreeing to Privacy Policy.'),
(54, 'en', 'JOIN3', 'Enter ID.'),
(55, 'en', 'JOIN4', 'Enter password.'),
(56, 'en', 'JOIN5', 'Enter name.'),
(57, 'en', 'JOIN6', 'Enter name.'),
(58, 'en', 'JOIN7', 'Enter surname.'),
(59, 'en', 'JOIN8', 'Enter email.'),
(60, 'en', 'JOIN9', 'Enter phone number.'),
(61, 'en', 'LOGIN1', 'You are already logged in. '),
(62, 'en', 'LOGIN2', 'Enter ID.'),
(63, 'en', 'LOGIN3', 'Enter password.'),
(64, 'en', 'LOGIN4', 'You cannot log in.'),
(65, 'en', 'LOGIN5', 'The ID or password you entered is incorrect.'),
(66, 'en', 'PAGE1', 'This is the first page. '),
(67, 'en', 'PAGE2', 'This is the last page.'),
(68, 'en', 'SEARCH1', 'Enter a search term.'),
(69, 'en', 'VIEW1', 'Please select an option'),
(70, 'en', 'VIEW2', 'The item has been placed in your cart. Would you like to go to your cart?'),
(71, 'en', 'VIEW3', 'The quantity must exceed 1.'),
(72, 'it', 'CART1', 'Il carrello è vuoto'),
(73, 'it', 'CART2', 'Seleziona i prodotti da ordinare.'),
(74, 'it', 'CART4', 'Seleziona ed elimina i prodotti non desiderati.'),
(75, 'it', 'CART5', 'Vuoi eliminare gli articoli nel tuo carrello?'),
(76, 'it', 'CART6', 'Abbiamo eliminato il prodotto dal carrello.'),
(77, 'it', 'COMMON1', 'Accesso non valido.'),
(78, 'it', 'JOIN1', 'È necessario accettare i termini e le condizioni prima di registrarsi.'),
(79, 'it', 'JOIN10', 'Inserisci il tuo numero di cellulare.'),
(80, 'it', 'JOIN11', 'Dopo aver inserito un nome utente, premere il pulsante \"verifica nome utente\"'),
(81, 'it', 'JOIN12', 'Si prega di inserire un nome utente contenente una combinazione di lettere (minuscole e maiuscole) e numeri'),
(82, 'it', 'JOIN13', 'Il nome utente inserito è disponibile'),
(83, 'it', 'JOIN14', 'Il nome utente inserito non è disponibile'),
(84, 'it', 'JOIN15', 'Vuoi registrarti?'),
(85, 'it', 'JOIN16', 'È possibile registrarsi dopo aver verificato la disponibilità del nome utente.'),
(86, 'it', 'JOIN17', 'La registrazione non è andata a buon fine.'),
(87, 'it', 'JOIN18', 'Registrazione completa.'),
(88, 'it', 'JOIN3', 'Inserisci un nome utente.'),
(89, 'it', 'JOIN4', 'Inserisci la password.'),
(90, 'it', 'JOIN5', 'Inserisci il nome.'),
(91, 'it', 'JOIN6', 'Inserisci il nome.'),
(92, 'it', 'JOIN7', 'Inserisci il cognome.'),
(93, 'it', 'JOIN8', 'Enter email.'),
(94, 'it', 'JOIN9', 'Inserisci il numero di telefono.'),
(95, 'it', 'LOGIN1', 'Login già effettuato.'),
(96, 'it', 'LOGIN2', 'Inserisci il nome utente.'),
(97, 'it', 'LOGIN3', 'Inserisci la password.'),
(98, 'it', 'LOGIN4', 'Non è possibile effettuare il login.'),
(99, 'it', 'LOGIN5', 'Nome utente o password errato.'),
(100, 'it', 'PAGE1', 'Questa è la prima pagina.'),
(101, 'it', 'SEARCH1', 'Inserisci la parola per la ricerca.'),
(102, 'it', 'VIEW1', 'This item does not exist'),
(103, 'it', 'VIEW2', 'Il prodotto è stato aggiunto nel carrello. Vuoi andare al carrello?'),
(104, 'it', 'VIEW3', 'La quantità deve essere almeno pari a uno.'),
(105, 'ko', 'ORDER1', '주문자명을 입력하세요.'),
(106, 'ko', 'ORDER10', '구매진행에 동의하셔야 주문 진행이 가능합니다.'),
(107, 'ko', 'ORDER11', '입력하신 주문정보로 결제하시겠습니까?'),
(108, 'ko', 'ORDER2', 'E-Mail 주소를 입력하세요'),
(109, 'ko', 'ORDER3', '주문자 휴대폰을 입력하세요.'),
(110, 'ko', 'ORDER4', '수취인 이름을 입력하세요.'),
(111, 'ko', 'ORDER5', '수취인 휴대폰 번호를 입력하세요.'),
(112, 'ko', 'ORDER6', '수취인 전화번호를 입력하세요.'),
(113, 'ko', 'ORDER7', '우편번호를 입력하세요.'),
(114, 'ko', 'ORDER8', '수취인 주소를 입력하세요.'),
(115, 'ko', 'ORDER9', '결제방법을 선택하세요.'),
(116, 'ko', 'ORDER12', '주문서 작성에 실패하였습니다.'),
(117, 'ja', 'CART1', 'カートに商品がありません。'),
(118, 'ja', 'CART2', '注文する商品をチェックしてください。'),
(119, 'ja', 'CART3', '注文しますか？'),
(120, 'ja', 'CART4', '削除する商品にチェックしてください。'),
(121, 'ja', 'CART5', 'カートから商品を削除しますか？'),
(122, 'ja', 'COMMON1', '間違ったアクセスです。'),
(123, 'ja', 'CART6', 'カートから商品を削除しました。'),
(124, 'ja', 'JOIN1', '利用規約に同意してください。'),
(125, 'ja', 'JOIN10', '携帯電話番号を入力してください。'),
(126, 'ja', 'JOIN11', 'IDを入力した後、IDチェックボタンを押してください。'),
(127, 'ja', 'JOIN12', 'IDは英文字(小文字)、または英文字(小文字)/数字を組み合わせて入力してください。(数字のみでの登録は不可)'),
(128, 'ja', 'JOIN13', '入力したIDは使用可能です。'),
(129, 'ja', 'JOIN14', '入力したIDは使用できません。'),
(130, 'ja', 'JOIN15', '会員登録しますか？'),
(131, 'ja', 'JOIN16', 'IDチェックをしてから会員登録してください。'),
(132, 'ja', 'JOIN17', '会員登録に失敗しました。'),
(133, 'ja', 'JOIN18', '会員登録が完了しました。'),
(134, 'ja', 'JOIN2', '個人情報取扱方針に同意してください。'),
(135, 'ja', 'JOIN3', 'IDを入力してください。'),
(136, 'ja', 'JOIN4', 'パスワードを入力してください。'),
(137, 'ja', 'JOIN5', '名前を入力してください。'),
(138, 'ja', 'JOIN6', '名前を入力してください。'),
(139, 'ja', 'JOIN7', '苗字（姓）を入力してください。'),
(140, 'ja', 'JOIN8', 'メールアドレスを入力してください。'),
(141, 'ja', 'JOIN9', '電話番号を入力してください。'),
(142, 'ja', 'LOGIN1', '既にログイン済みです。'),
(143, 'ja', 'LOGIN2', 'IDを入力してください。'),
(144, 'ja', 'LOGIN3', 'パスワードを入力してください。'),
(145, 'ja', 'LOGIN4', 'ログインできません。'),
(146, 'ja', 'LOGIN5', 'ID、またはパスワードが正しくありません。'),
(147, 'ja', 'PAGE1', '最初のページです。'),
(148, 'ja', 'PAGE2', '最後のページです。'),
(149, 'ja', 'SEARCH1', '検索ワードを入力してください。'),
(150, 'ja', 'VIEW1', 'アイテムが見つかりません。'),
(151, 'ja', 'VIEW2', 'カートに入れました。カートに移動しますか？'),
(152, 'ja', 'VIEW3', '数量は１個以上でお願いします。'),
(153, 'it', 'PAGE2', 'è la fine della pagina.'),
(154, 'en', 'JOIN11', 'After entering a user name, press the button'),
(155, 'en', 'ORDER1', 'Please enter your order name'),
(156, 'ja', 'ORDER1', '注文者名を入力してください'),
(157, 'ja', 'ORDER10', '購入進行に同意する必要があり注文進行が可能です。'),
(158, 'en', 'ORDER10', 'You must accept the purchase order before you can proceed with the order.'),
(159, 'en', 'ORDER11', 'Would you like to pay by the order information you entered?'),
(160, 'ja', 'ORDER11', '入力された内容で次へ。'),
(161, 'en', 'ORDER12', 'Order creation failed'),
(162, 'ja', 'ORDER12', '注文書の作成に失敗しました'),
(163, 'en', 'ORDER13', 'The amount of the reserve must be a number.'),
(164, 'ko', 'ORDER13', '적립금 사용액은 숫자이어야 합니다.'),
(165, 'ja', 'ORDER13', '積立金の使用額は数が必要です。'),
(166, 'it', 'ORDER2', 'Inserisci il tuo indirizzo e-mail'),
(167, 'ja', 'ORDER2', 'E-Mailアドレスを入力してください'),
(168, 'en', 'ORDER2', 'Enter your e-mail address'),
(169, 'en', 'ORDER3', 'Please enter your mobile phone'),
(170, 'it', 'ORDER3', 'Per favore inserisci il tuo cellulare'),
(171, 'ja', 'ORDER3', '注文者の携帯電話を入力してください'),
(172, 'ja', 'ORDER4', '受取人の名前を入力してください'),
(173, 'en', 'ORDER4', 'Please enter your payee name'),
(174, 'it', 'ORDER4', 'Si prega di inserire il nome del beneficiario'),
(175, 'it', 'ORDER5', 'Inserisci il numero di cellulare del tuo beneficiario'),
(176, 'ja', 'ORDER5', '受取人の携帯電話番号を入力してください'),
(177, 'ja', 'ORDER6', '受取人の電話番号を入力してください'),
(178, 'en', 'ORDER6', 'Enter your payee phone number'),
(179, 'it', 'ORDER6', 'Inserisci il tuo numero di telefono del beneficiario'),
(180, 'it', 'ORDER7', 'Per favore inserisci il tuo codice postale'),
(181, 'en', 'ORDER7', 'Please enter your zip code'),
(182, 'ja', 'ORDER7', '郵便番号を入力してください'),
(183, 'en', 'ORDER8', 'Please enter your payment address'),
(184, 'it', 'ORDER8', 'Per favore inserisci il tuo indirizzo di pagamento'),
(185, 'ja', 'ORDER8', '受取人のアドレスを入力してください'),
(186, 'en', 'ORDER9', 'Please select a payment method'),
(187, 'it', 'ORDER9', 'Si prega di selezionare un metodo di pagamento'),
(188, 'ja', 'ORDER9', 'お支払い方法を選択してください'),
(189, 'it', 'JOIN19', 'Per favore inserisci la tua data di nascita'),
(190, 'ja', 'JOIN19', '生年月日を入力してください'),
(191, 'en', 'JOIN19', 'Please enter your date of birth'),
(192, 'ko', 'JOIN19', '생년월일을 입력하세요.'),
(193, 'it', 'ORDER1', 'Si prega di inserire il nome dell ordine'),
(194, 'it', 'ORDER11', 'Vorresti pagare con le informazioni dell ordine che hai inserito?'),
(195, 'it', 'ORDER12', 'Creazione dell ordine fallita'),
(196, 'en', 'ORDER5', ' 17/5000 suchwiin hyudaepon beonholeul iblyeoghaseyo Enter your payees mobile number'),
(197, 'ko', 'MEMOUT2', '탈퇴처리에 실패하였습니다.	'),
(198, 'ko', 'MEMOUT3', '이미 탈퇴신청이 되어 있습니다.'),
(199, 'ko', 'MEMOUT4', '비밀번호가 맞지 않습니다.'),
(200, 'ko', 'MYINFO1', '회원정보수정 하시겠습니까?'),
(201, 'ko', 'MEMOUT1', '탈퇴 신청이 완료 되었습니다. 그동안 이용해주셔서 감사합니다'),
(202, 'ko', 'MYINFO2', '회원탈퇴하시겠습니까?'),
(203, 'ko', 'ORDER14', '쿠폰적용이 가능한 상품이 없습니다.'),
(204, 'ko', 'MYINFO3', '현재 사용 중인 비밀번호를 입력하세요.'),
(205, 'ko', 'MYINFO4', '회원정보를 수정하였습니다'),
(206, 'en', 'MEMOUT1', 'Your opt-out request is complete. Thank you for your time'),
(207, 'it', 'MEMOUT1', 'La tua richiesta di rinuncia è completa. Grazie per il tuo tempo'),
(208, 'ja', 'MEMOUT1', '退会申請が完了しました。これまでご利用いただきありがとうございます'),
(209, 'ja', 'MEMOUT2', '退会処理に失敗しました。'),
(210, 'en', 'MEMOUT2', 'The withdrawal processing failed.'),
(211, 'it', 'MEMOUT2', 'L\'elaborazione del ritiro non è riuscita.'),
(212, 'ja', 'MEMOUT3', '逃げる申請はこちら。'),
(213, 'en', 'MEMOUT3', 'I am already unsubscribed.'),
(214, 'it', 'MEMOUT3', 'Sono già stato cancellato.'),
(215, 'en', 'MEMOUT4', 'The password is incorrect.'),
(216, 'it', 'MEMOUT4', 'La password è errata'),
(217, 'ja', 'MEMOUT4', 'パスワードが一致しません。'),
(218, 'ko', 'MYINFO5', '회원정보 수정에 실패하였습니다'),
(219, 'ja', 'MYINFO1', '会員情報の変更しますか？'),
(220, 'it', 'MYINFO1', 'Vuoi modificare le informazioni sulla tua iscrizione?'),
(221, 'en', 'MYINFO1', 'Do you want to edit your membership information?'),
(222, 'en', 'MYINFO2', 'Are you sure you want to leave?'),
(223, 'ja', 'MYINFO2', '会員脱退しますか？'),
(224, 'it', 'MYINFO2', 'Sei sicuro di voler andare via?'),
(225, 'en', 'MYINFO3', 'Enter your current password'),
(226, 'it', 'MYINFO3', 'Inserisci la tua password attuale'),
(227, 'ja', 'MYINFO3', '現在使用中のパスワードを入力してください'),
(228, 'ja', 'MYINFO4', '会員情報を修正しました'),
(229, 'it', 'MYINFO4', 'Ho modificato le mie informazioni sull\'iscrizione'),
(230, 'en', 'MYINFO4', 'I have modified my membership information'),
(231, 'it', 'MYINFO5', 'Impossibile modificare le informazioni sui membri'),
(232, 'ja', 'MYINFO5', '会員情報の変更に失敗しました'),
(233, 'en', 'MYINFO5', 'Failed to edit member information'),
(234, 'it', 'ORDER10', 'È necessario accettare l\'ordine di acquisto prima di poter procedere con l\'ordine.'),
(235, 'ja', 'ORDER14', 'クーポン適用が可能な商品はありません。'),
(236, 'en', 'ORDER14', 'No coupons available'),
(237, 'it', 'ORDER14', 'Nessun coupon disponibile'),
(238, 'it', 'ORDER13', 'L\'ammontare della riserva deve essere un numero.'),
(239, 'it', 'CART3', 'Vuoi effettuare un ordine?'),
(240, 'ko', 'ORDER15', '비회원 주문확인 비밀번호를 입력하세요.'),
(241, 'ko', 'ORDER16', '배송국가를 선택하세요.'),
(242, 'ko', 'ORDER18', '주/시도를 입력하세요.'),
(243, 'ko', 'ORDER17', ' 도시를 입력하세요 .'),
(244, 'en', 'ORDER15', 'Enter your non-member order password'),
(245, 'it', 'ORDER15', 'Enter your non-member order password'),
(246, 'en', 'ORDER16', 'Select a shipping country'),
(247, 'it', 'ORDER16', 'Select a shipping country'),
(248, 'en', 'ORDER17', 'Enter a city'),
(249, 'en', 'ORDER18', 'Enter a State/City/Province'),
(250, 'it', 'ORDER18', 'Enter a State/City/Province'),
(251, 'it', 'ORDER17', 'Enter a city'),
(252, 'ko', 'JOIN20', '우편번호를 입력하세요.'),
(253, 'en', 'JOIN20', 'Enter zip code.'),
(254, 'it', 'JOIN20', 'Enter zip code.'),
(255, 'it', 'JOIN2', 'You can join after agreeing to Privacy Policy.'),
(256, 'ko', 'NOLOGIN1', '입력하신 정보와 일치하는 주문내역이 존재하지 않습니다.'),
(257, 'ja', 'JOIN20', '郵便番号を入力してください。'),
(258, 'ja', 'ORDER15', '非会員注文確認パスワードを入力してください。'),
(259, 'ko', 'POPUP1', '오늘 열지 않기'),
(260, 'zh', 'CART1', '购物车里没有商品'),
(261, 'zh', 'CART1', ''),
(262, 'zh', 'CART1', '1'),
(263, 'zh', 'CART1', '1'),
(264, 'zh', 'CART2', '请确认需要订购的商品。'),
(265, 'zh', 'CART3', '是否确定订购？'),
(266, 'zh', 'CART4', '请确认需要删除的商品。'),
(267, 'zh', 'CART5', '是否确定删除购物车里的商品？'),
(268, 'zh', 'CART6', '已删除购物车里的商品。'),
(269, 'zh', 'COMMON1', '错误的访问'),
(270, 'zh', 'JOIN1', '需要同意使用条款才可以进行注册。'),
(271, 'zh', 'JOIN10', '请输入手机号码。'),
(272, 'zh', 'JOIN11', '输入账号名之后请点击重复确认按钮！'),
(273, 'zh', 'JOIN12', '账号名请输入英文字母(小写)或者英文字母/数字组合(只用数字无法创建)'),
(274, 'zh', 'JOIN13', '您输入的账号名可以使用'),
(275, 'zh', 'JOIN14', '您输入的账号名无法使用'),
(276, 'zh', 'JOIN15', '是否确认注册？'),
(277, 'zh', 'JOIN16', '请先确认账号名是否重复后才可以注册会员'),
(278, 'zh', 'JOIN17', '注册失败'),
(279, 'zh', 'JOIN18', '注册完成'),
(280, 'zh', 'JOIN19', '请输入出生日期'),
(281, 'zh', 'JOIN2', '同意收集个人信息条款后才可以注册。'),
(282, 'zh', 'JOIN20', '请输入邮编'),
(283, 'zh', 'JOIN22', '请输入推荐人用户名。'),
(284, 'zh', 'JOIN3', '请输入账号名'),
(285, 'zh', 'JOIN4', '请输入密码'),
(286, 'zh', 'JOIN5', '请输入名称'),
(287, 'zh', 'JOIN6', '请输入名称'),
(288, 'zh', 'JOIN7', '请输入姓氏'),
(289, 'zh', 'JOIN8', '请输入邮箱'),
(290, 'zh', 'JOIN9', '请输入电话号码'),
(291, 'zh', 'LOGIN1', '该账号已登录。'),
(292, 'zh', 'LOGIN2', '请输入账号名'),
(293, 'zh', 'LOGIN3', '请输入密码'),
(294, 'zh', 'LOGIN4', '无法登陆。'),
(295, 'zh', 'LOGIN5', '账号名或密码错误。'),
(296, 'zh', 'MEMOUT1', '已完成注销申请。感谢使用'),
(297, 'zh', 'MEMOUT2', '注销失败。'),
(298, 'zh', 'MEMOUT3', '已申请注销。'),
(299, 'zh', 'MEMOUT4', '密码错误。'),
(300, 'zh', 'MYINFO1', '确定修改会员信息吗？'),
(301, 'zh', 'MYINFO2', '确定注销会员吗？'),
(302, 'zh', 'MYINFO3', '请输入当前使用的密码。'),
(303, 'zh', 'MYINFO4', '会员信息修改完成'),
(304, 'zh', 'MYINFO5', '会员信息修改失败'),
(305, 'zh', 'NOLOGIN1', '该输入信息无法查询相关订购内容。'),
(306, 'zh', 'ORDER1', '请输入订购人姓名。'),
(307, 'zh', 'ORDER10', '同意购买之后可以进行订购。'),
(308, 'zh', 'ORDER11', '使用输入的订购信息付款吗？'),
(309, 'zh', 'ORDER12', '订购失败'),
(310, 'zh', 'ORDER13', '积攒金额需填写数字'),
(311, 'zh', 'ORDER14', '没有可以使用礼券的商品。'),
(312, 'zh', 'ORDER15', '请输入非会员订购确认密码。'),
(313, 'zh', 'ORDER16', '请选择配送国家'),
(314, 'zh', 'ORDER17', '请输入城市。'),
(315, 'zh', 'ORDER18', '请输入省/城市。'),
(316, 'zh', 'ORDER19', '请选择地区'),
(317, 'zh', 'ORDER2', '请输入邮箱地址'),
(318, 'zh', 'ORDER3', '请输入订购人手机号码'),
(319, 'zh', 'ORDER4', '请输入收件人姓名。'),
(320, 'zh', 'ORDER5', '请输入收件人手机号码。'),
(321, 'zh', 'ORDER6', '请输入订购人电话号码。'),
(322, 'zh', 'ORDER7', '请输入邮编'),
(323, 'zh', 'ORDER8', '请输入收件人地址。'),
(324, 'zh', 'ORDER9', '请选择付款方式。'),
(325, 'zh', 'PAGE1', '页面的开始。'),
(326, 'zh', 'PAGE2', '页面的结束。'),
(327, 'zh', 'POPUP1', '今天不再显示'),
(328, 'zh', 'SEARCH1', '请输入查询内容。'),
(329, 'zh', 'VIEW1', '请选择选项。'),
(330, 'zh', 'VIEW2', '已添加到购物车。是否前往购物车？'),
(331, 'zh', 'VIEW3', '数量至少为1个。'),
(332, 'zh', 'VIEW4', '以保存到愿望清单。是否前往愿望清单？'),
(333, 'zh', 'WISH1', '需要登录才可以保存到愿望清单'),
(334, 'zh', 'WISH2', '愿望清单里已保存该商品'),
(335, 'ja', 'POPUP1', '今日はもう開かない'),
(336, 'ja', 'ORDER16', '配送国を選択してください'),
(337, 'ja', 'NOLOGIN1', '入力した情報と一致する注文が見つかりませんでした。'),
(338, 'ja', 'JOIN21', 'ご住所を入力してください。'),
(339, 'ja', 'ORDER18', '都道府県を入力してください'),
(340, 'ja', 'ORDER17', '市/区を入力してください'),
(341, 'ko', 'QNA01', '작성자만 조회 가능합니다'),
(342, 'ko', 'QNA02', '비회원으로 작성한 글입니다. 비밀번호 입력후 조회가 가능합니다.'),
(343, 'ko', 'QNA03', '비밀번호가 맞지 않습니다'),
(344, 'ko', 'QNA04', '답변이 완료된 게시물은 수정이 불가능합니다.'),
(345, 'ko', 'QNA05', '작성자만 수정이 가능합니다'),
(346, 'ja', 'QNA01', '作成者の方のみ照会可能です'),
(347, 'ja', 'QNA02', '非会員で作成したお問い合わせです。パスワードを入力後、照会可能です。'),
(348, 'ja', 'QNA03', 'パスワードが合わないです。'),
(349, 'ja', 'QNA04', '回答完了のお問い合わせは、修正できません。'),
(350, 'ja', 'QNA05', '作成者の方のみ修正可能です。'),
(351, 'ko', 'JOIN22', '이미 가입된 휴대폰 번호 입니다.'),
(352, 'ko', 'JOIN21', '주소를 입력하세요');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_trans_key`
--

CREATE TABLE `shop_trans_key` (
  `idx` int(10) UNSIGNED NOT NULL,
  `wordkeys` varchar(100) NOT NULL,
  `notrans` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_trans_key`
--

INSERT INTO `shop_trans_key` (`idx`, `wordkeys`, `notrans`) VALUES
(1, '신용카드', 'N');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_trans_keysc`
--

CREATE TABLE `shop_trans_keysc` (
  `idx` int(10) UNSIGNED NOT NULL,
  `scode` varchar(30) NOT NULL,
  `memo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_view_today`
--

CREATE TABLE `shop_view_today` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `wdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `shop_view_today`
--

INSERT INTO `shop_view_today` (`idx`, `mem_idx`, `goods_idx`, `wdate`) VALUES
(1, 2, 2, '2025-07-10 13:25:54'),
(2, 2, 1, '2025-07-10 16:10:00'),
(3, 3, 2, '2025-07-10 16:58:06'),
(4, 3, 1, '2025-07-10 17:00:10'),
(5, 0, 1, '2025-07-10 16:47:32'),
(6, 4, 1, '2025-07-10 11:33:28'),
(7, 4, 2, '2025-07-10 11:33:59'),
(8, 0, 2, '2025-07-10 16:46:53');

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_warehouse`
--

CREATE TABLE `shop_warehouse` (
  `idx` int(10) UNSIGNED NOT NULL,
  `config_idx` int(10) UNSIGNED NOT NULL,
  `isbasic` char(1) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_warehouse_config`
--

CREATE TABLE `shop_warehouse_config` (
  `idx` int(10) UNSIGNED NOT NULL,
  `fid` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `isuse` char(1) NOT NULL,
  `makebasic` char(1) NOT NULL,
  `arpids` text NOT NULL COMMENT '판매처들'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_wish`
--

CREATE TABLE `shop_wish` (
  `idx` int(10) UNSIGNED NOT NULL,
  `mem_idx` int(10) UNSIGNED NOT NULL,
  `stypes` char(1) NOT NULL,
  `goods_idx` int(10) UNSIGNED NOT NULL,
  `sdate` datetime NOT NULL,
  `sfid` tinyint(4) NOT NULL DEFAULT '1',
  `spid` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `shop_wish`
--

INSERT INTO `shop_wish` (`idx`, `mem_idx`, `stypes`, `goods_idx`, `sdate`, `sfid`, `spid`) VALUES
(13, 2, '', 1, '2025-07-09 13:40:21', 1, 1),
(20, 3, '', 2, '2025-07-10 16:48:21', 1, 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `shop_zipcode_jp`
--

CREATE TABLE `shop_zipcode_jp` (
  `idx` int(10) UNSIGNED NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `data1` varchar(100) NOT NULL,
  `data2` varchar(100) NOT NULL,
  `data3` varchar(100) NOT NULL,
  `data4` varchar(100) NOT NULL,
  `data5` varchar(100) NOT NULL,
  `data6` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sesskey`),
  ADD KEY `expiry` (`expiry`);

--
-- 테이블의 인덱스 `shop_action_reason`
--
ALTER TABLE `shop_action_reason`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `rtype` (`rtype`),
  ADD KEY `reason` (`reason`);

--
-- 테이블의 인덱스 `shop_admin_config`
--
ALTER TABLE `shop_admin_config`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_admin_grade`
--
ALTER TABLE `shop_admin_grade`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_admin_priv`
--
ALTER TABLE `shop_admin_priv`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `grade_id` (`grade_id`);

--
-- 테이블의 인덱스 `shop_ads`
--
ALTER TABLE `shop_ads`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_ads_read`
--
ALTER TABLE `shop_ads_read`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `newcont_idx` (`ads_idx`);

--
-- 테이블의 인덱스 `shop_ads_show`
--
ALTER TABLE `shop_ads_show`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `newcont_idx` (`ads_idx`);

--
-- 테이블의 인덱스 `shop_after`
--
ALTER TABLE `shop_after`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `pid` (`pid`),
  ADD KEY `btype` (`btype`),
  ADD KEY `isdel` (`isdel`),
  ADD KEY `wrlink` (`wrlink`),
  ADD KEY `basket_idx` (`basket_idx`);

--
-- 테이블의 인덱스 `shop_after_base`
--
ALTER TABLE `shop_after_base`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `cate_idx` (`cate_idx`);

--
-- 테이블의 인덱스 `shop_after_cate`
--
ALTER TABLE `shop_after_cate`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_after_config`
--
ALTER TABLE `shop_after_config`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `fid` (`fid`),
  ADD KEY `lan` (`lan`);

--
-- 테이블의 인덱스 `shop_after_img`
--
ALTER TABLE `shop_after_img`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `after_idx` (`after_idx`);

--
-- 테이블의 인덱스 `shop_after_like`
--
ALTER TABLE `shop_after_like`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `after_idx` (`after_idx`),
  ADD KEY `memtocken` (`memtocken`);

--
-- 테이블의 인덱스 `shop_after_tags`
--
ALTER TABLE `shop_after_tags`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_after_tail`
--
ALTER TABLE `shop_after_tail`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `board_idx` (`after_idx`),
  ADD KEY `mem_idx` (`mem_idx`),
  ADD KEY `thread` (`thread`),
  ADD KEY `isdel` (`isdel`),
  ADD KEY `fid` (`fid`),
  ADD KEY `last_idx` (`last_idx`),
  ADD KEY `mem_id` (`mem_id`);

--
-- 테이블의 인덱스 `shop_areview`
--
ALTER TABLE `shop_areview`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_areview_cate`
--
ALTER TABLE `shop_areview_cate`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_areview_writer`
--
ALTER TABLE `shop_areview_writer`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isdel` (`isdel`);

--
-- 테이블의 인덱스 `shop_bankcode`
--
ALTER TABLE `shop_bankcode`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isuse` (`isuse`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_board`
--
ALTER TABLE `shop_board`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `boardid` (`boardid`),
  ADD KEY `btype` (`btype`),
  ADD KEY `wdate` (`wdate`),
  ADD KEY `mem_idx` (`mem_idx`),
  ADD KEY `isdel` (`isdel`),
  ADD KEY `isjack` (`isjack`),
  ADD KEY `hfile` (`hfile`),
  ADD KEY `last_idx` (`last_idx1`);
ALTER TABLE `shop_board` ADD FULLTEXT KEY `cates` (`cates`);

--
-- 테이블의 인덱스 `shop_board_cate`
--
ALTER TABLE `shop_board_cate`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_board_conf`
--
ALTER TABLE `shop_board_conf`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_board_goods`
--
ALTER TABLE `shop_board_goods`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `board_idx` (`board_idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_brand`
--
ALTER TABLE `shop_brand`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_cate`
--
ALTER TABLE `shop_cate`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `upcate` (`upcate`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_config`
--
ALTER TABLE `shop_config`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `pid` (`pid`);

--
-- 테이블의 인덱스 `shop_config_apis`
--
ALTER TABLE `shop_config_apis`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_config_bm`
--
ALTER TABLE `shop_config_bm`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isuse` (`isuse`);

--
-- 테이블의 인덱스 `shop_config_color`
--
ALTER TABLE `shop_config_color`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_config_curr`
--
ALTER TABLE `shop_config_curr`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_config_delivery`
--
ALTER TABLE `shop_config_delivery`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_config_domain`
--
ALTER TABLE `shop_config_domain`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `pid` (`pid`),
  ADD KEY `domain` (`domain`),
  ADD KEY `ismobi` (`ismobi`);

--
-- 테이블의 인덱스 `shop_config_goodsadd`
--
ALTER TABLE `shop_config_goodsadd`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `fid` (`fid`),
  ADD KEY `addstd_idx` (`bun_idx`);

--
-- 테이블의 인덱스 `shop_config_icon`
--
ALTER TABLE `shop_config_icon`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `fname` (`fname`),
  ADD KEY `isuse` (`isuse`),
  ADD KEY `wuse` (`wuse`);

--
-- 테이블의 인덱스 `shop_config_lang`
--
ALTER TABLE `shop_config_lang`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isuse` (`isuse`);

--
-- 테이블의 인덱스 `shop_config_maker`
--
ALTER TABLE `shop_config_maker`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_config_memo`
--
ALTER TABLE `shop_config_memo`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_config_msg`
--
ALTER TABLE `shop_config_msg`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_config_omemo`
--
ALTER TABLE `shop_config_omemo`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `up_idx` (`up_idx`),
  ADD KEY `isuse` (`isuse`);

--
-- 테이블의 인덱스 `shop_config_pay`
--
ALTER TABLE `shop_config_pay`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `pid` (`pid`);

--
-- 테이블의 인덱스 `shop_config_tags`
--
ALTER TABLE `shop_config_tags`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isdel` (`isdel`,`isshow`);

--
-- 테이블의 인덱스 `shop_cont`
--
ALTER TABLE `shop_cont`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_contact`
--
ALTER TABLE `shop_contact`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `index_no` (`idx`);

--
-- 테이블의 인덱스 `shop_cont_tail`
--
ALTER TABLE `shop_cont_tail`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `cont_idx` (`cont_idx`),
  ADD KEY `up_idx` (`up_idx`);

--
-- 테이블의 인덱스 `shop_cont_tail_like`
--
ALTER TABLE `shop_cont_tail_like`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `tail_idx` (`tail_idx`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_country`
--
ALTER TABLE `shop_country`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `res` (`res`);

--
-- 테이블의 인덱스 `shop_coupen`
--
ALTER TABLE `shop_coupen`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `usetype` (`usetype`),
  ADD KEY `actype` (`actype`);

--
-- 테이블의 인덱스 `shop_coupen_log`
--
ALTER TABLE `shop_coupen_log`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_coupen_mem`
--
ALTER TABLE `shop_coupen_mem`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`),
  ADD KEY `coupen_idx` (`coupen_idx`),
  ADD KEY `actype` (`actype`),
  ADD KEY `usetype` (`usetype`),
  ADD KEY `edate` (`edate`),
  ADD KEY `market_idx` (`market_idx`),
  ADD KEY `canuseac` (`canuseac`),
  ADD KEY `log_idx` (`log_idx`);

--
-- 테이블의 인덱스 `shop_coupen_serial`
--
ALTER TABLE `shop_coupen_serial`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `coupen_idx` (`coupen_idx`),
  ADD KEY `isuse` (`isuse`);

--
-- 테이블의 인덱스 `shop_crm_goodsread`
--
ALTER TABLE `shop_crm_goodsread`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `wdate` (`wdate`),
  ADD KEY `enterc` (`enterc`),
  ADD KEY `pid` (`pid`);

--
-- 테이블의 인덱스 `shop_crm_selling`
--
ALTER TABLE `shop_crm_selling`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_customdb`
--
ALTER TABLE `shop_customdb`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_customdb_data`
--
ALTER TABLE `shop_customdb_data`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `customdb_idx` (`customdb_idx`),
  ADD KEY `wdate` (`wdate`);

--
-- 테이블의 인덱스 `shop_customdb_data_ele`
--
ALTER TABLE `shop_customdb_data_ele`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `data_idx` (`data_idx`),
  ADD KEY `fi_idx` (`fi_idx`);

--
-- 테이블의 인덱스 `shop_customdb_sch`
--
ALTER TABLE `shop_customdb_sch`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `customdb_idx` (`customdb_idx`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_delaccount_add`
--
ALTER TABLE `shop_delaccount_add`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_delivery_dcompany`
--
ALTER TABLE `shop_delivery_dcompany`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_delivery_fee_jp`
--
ALTER TABLE `shop_delivery_fee_jp`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `location` (`location`);

--
-- 테이블의 인덱스 `shop_design_layout`
--
ALTER TABLE `shop_design_layout`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `pid` (`pid`);

--
-- 테이블의 인덱스 `shop_design_layout_addon`
--
ALTER TABLE `shop_design_layout_addon`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `layout_idx` (`layout_idx`);

--
-- 테이블의 인덱스 `shop_design_mainconfig`
--
ALTER TABLE `shop_design_mainconfig`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `pid` (`pid`);

--
-- 테이블의 인덱스 `shop_design_maindata`
--
ALTER TABLE `shop_design_maindata`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `main_idx` (`main_idx`,`orders`);

--
-- 테이블의 인덱스 `shop_design_maindata_ele`
--
ALTER TABLE `shop_design_maindata_ele`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_design_module`
--
ALTER TABLE `shop_design_module`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_domain`
--
ALTER TABLE `shop_domain`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `index_no_2` (`idx`),
  ADD KEY `index_no` (`idx`);

--
-- 테이블의 인덱스 `shop_ep_naver`
--
ALTER TABLE `shop_ep_naver`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_event`
--
ALTER TABLE `shop_event`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `lang` (`lang`);

--
-- 테이블의 인덱스 `shop_event_goods`
--
ALTER TABLE `shop_event_goods`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `event_idx` (`event_idx`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_faq`
--
ALTER TABLE `shop_faq`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `cate` (`cate`),
  ADD KEY `score` (`score`),
  ADD KEY `isbest` (`isbest`);

--
-- 테이블의 인덱스 `shop_faqcate`
--
ALTER TABLE `shop_faqcate`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `fid` (`fid`,`isuse`,`orders`);

--
-- 테이블의 인덱스 `shop_genmemo`
--
ALTER TABLE `shop_genmemo`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_goods`
--
ALTER TABLE `shop_goods`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isopen` (`isopen`),
  ADD KEY `istoday` (`istoday`),
  ADD KEY `count_read` (`count_read`),
  ADD KEY `count_order` (`count_order`),
  ADD KEY `count_cart` (`count_cart`),
  ADD KEY `count_wish` (`count_wish`),
  ADD KEY `count_qna` (`count_qna`),
  ADD KEY `isshow` (`isshow`),
  ADD KEY `fid` (`fid`),
  ADD KEY `last_idx` (`last_idx`),
  ADD KEY `in_idx` (`in_idx`),
  ADD KEY `sellc` (`sellc`),
  ADD KEY `seller_idx` (`seller_idx`),
  ADD KEY `isdel` (`isdel`),
  ADD KEY `master_idx` (`master_idx`),
  ADD KEY `gcode` (`gcode`),
  ADD KEY `mall_idx` (`mall_idx`);
ALTER TABLE `shop_goods` ADD FULLTEXT KEY `gname` (`gname`);

--
-- 테이블의 인덱스 `shop_goodslist`
--
ALTER TABLE `shop_goodslist`
  ADD PRIMARY KEY (`index_no`),
  ADD KEY `gcate` (`gcate`);

--
-- 테이블의 인덱스 `shop_goods_account`
--
ALTER TABLE `shop_goods_account`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `lang` (`stype`);

--
-- 테이블의 인덱스 `shop_goods_addinfo`
--
ALTER TABLE `shop_goods_addinfo`
  ADD PRIMARY KEY (`index_no`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_goods_barcode`
--
ALTER TABLE `shop_goods_barcode`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`,`op1`,`op2`,`op3`),
  ADD KEY `barcode` (`barcode`);

--
-- 테이블의 인덱스 `shop_goods_bun`
--
ALTER TABLE `shop_goods_bun`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `upcate` (`upcate`),
  ADD KEY `smain` (`smain`),
  ADD KEY `last_idx` (`last_idx`);

--
-- 테이블의 인덱스 `shop_goods_cate`
--
ALTER TABLE `shop_goods_cate`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `un` (`goods_idx`,`catecode`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `catecode` (`catecode`),
  ADD KEY `lcatecode` (`lcatecode`),
  ADD KEY `isfix` (`isfix`);

--
-- 테이블의 인덱스 `shop_goods_cgroup`
--
ALTER TABLE `shop_goods_cgroup`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`,`orders`),
  ADD KEY `cgroup` (`cgroup`),
  ADD KEY `isb` (`isb`);

--
-- 테이블의 인덱스 `shop_goods_change_account`
--
ALTER TABLE `shop_goods_change_account`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_goods_color`
--
ALTER TABLE `shop_goods_color`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `goods_idx_2` (`goods_idx`,`color_idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `color_idx` (`color_idx`);

--
-- 테이블의 인덱스 `shop_goods_imgs`
--
ALTER TABLE `shop_goods_imgs`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_goods_inout`
--
ALTER TABLE `shop_goods_inout`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `wdate_s` (`wdate_s`),
  ADD KEY `tbtype` (`tbtype`),
  ADD KEY `op1` (`op1`),
  ADD KEY `op2` (`op2`),
  ADD KEY `op3` (`op3`),
  ADD KEY `aname` (`aname`),
  ADD KEY `in_idx` (`in_idx`),
  ADD KEY `useh` (`useh`),
  ADD KEY `paper_idx` (`paper_idx`);

--
-- 테이블의 인덱스 `shop_goods_inout_cate`
--
ALTER TABLE `shop_goods_inout_cate`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `catename` (`catename`),
  ADD KEY `catetype` (`catetype`);

--
-- 테이블의 인덱스 `shop_goods_inout_paper`
--
ALTER TABLE `shop_goods_inout_paper`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `wdate` (`wdate`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_goods_inout_pre`
--
ALTER TABLE `shop_goods_inout_pre`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `codes` (`codes`);

--
-- 테이블의 인덱스 `shop_goods_last`
--
ALTER TABLE `shop_goods_last`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isopen` (`isopen`),
  ADD KEY `istoday` (`istoday`),
  ADD KEY `count_read` (`count_read`),
  ADD KEY `count_order` (`count_order`),
  ADD KEY `count_cart` (`count_cart`),
  ADD KEY `count_wish` (`count_wish`),
  ADD KEY `count_qna` (`count_qna`),
  ADD KEY `isshow` (`isshow`),
  ADD KEY `fid` (`fid`),
  ADD KEY `last_idx` (`last_idx`),
  ADD KEY `in_idx` (`in_idx`),
  ADD KEY `sellc` (`sellc`),
  ADD KEY `seller_idx` (`seller_idx`),
  ADD KEY `isdel` (`isdel`),
  ADD KEY `master_idx` (`master_idx`),
  ADD KEY `gcode` (`gcode`);
ALTER TABLE `shop_goods_last` ADD FULLTEXT KEY `gname` (`gname`);

--
-- 테이블의 인덱스 `shop_goods_lefts`
--
ALTER TABLE `shop_goods_lefts`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `op1` (`op1`),
  ADD KEY `op2` (`op2`),
  ADD KEY `op3` (`op3`);

--
-- 테이블의 인덱스 `shop_goods_log`
--
ALTER TABLE `shop_goods_log`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_goods_match`
--
ALTER TABLE `shop_goods_match`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_goods_nimg`
--
ALTER TABLE `shop_goods_nimg`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `orders` (`orders`),
  ADD KEY `cgroup` (`cgroup`);

--
-- 테이블의 인덱스 `shop_goods_op1`
--
ALTER TABLE `shop_goods_op1`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `isuse` (`isuse`),
  ADD KEY `orders` (`orders`),
  ADD KEY `isdel` (`isdel`);

--
-- 테이블의 인덱스 `shop_goods_op2`
--
ALTER TABLE `shop_goods_op2`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `isuse` (`isuse`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_goods_op3`
--
ALTER TABLE `shop_goods_op3`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `isuse` (`isuse`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_goods_sale`
--
ALTER TABLE `shop_goods_sale`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_goods_sale_ele`
--
ALTER TABLE `shop_goods_sale_ele`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `sale_idx` (`sale_idx`,`goods_idx`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_goods_season`
--
ALTER TABLE `shop_goods_season`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `goods_idx_2` (`goods_idx`,`season_info`),
  ADD KEY `season_info` (`season_info`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_goods_sets`
--
ALTER TABLE `shop_goods_sets`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `sets_idx` (`sets_idx`),
  ADD KEY `sets_op` (`sets_op`);

--
-- 테이블의 인덱스 `shop_goods_shops`
--
ALTER TABLE `shop_goods_shops`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_goods_shops_config`
--
ALTER TABLE `shop_goods_shops_config`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `in_idx` (`in_idx`);

--
-- 테이블의 인덱스 `shop_goods_shops_group`
--
ALTER TABLE `shop_goods_shops_group`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_goods_shops_imgs`
--
ALTER TABLE `shop_goods_shops_imgs`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_goods_showlang`
--
ALTER TABLE `shop_goods_showlang`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `lang` (`lang`);

--
-- 테이블의 인덱스 `shop_goods_showsite`
--
ALTER TABLE `shop_goods_showsite`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `goods_idx` (`goods_idx`,`pid`) USING BTREE;

--
-- 테이블의 인덱스 `shop_goods_soldout`
--
ALTER TABLE `shop_goods_soldout`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `op1` (`op1`),
  ADD KEY `op2` (`op2`),
  ADD KEY `otype` (`otype`),
  ADD KEY `wdate_s` (`wdate_s`),
  ADD KEY `op3` (`op3`);

--
-- 테이블의 인덱스 `shop_goods_subcate`
--
ALTER TABLE `shop_goods_subcate`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `un` (`goods_idx`,`catecode`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `catecode` (`catecode`),
  ADD KEY `lcatecode` (`lcatecode`),
  ADD KEY `isfix` (`isfix`);

--
-- 테이블의 인덱스 `shop_guide_config`
--
ALTER TABLE `shop_guide_config`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_intro_store`
--
ALTER TABLE `shop_intro_store`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `loca_idx` (`loca_idx`),
  ADD KEY `up_idx` (`up_idx`);

--
-- 테이블의 인덱스 `shop_intro_store_loca`
--
ALTER TABLE `shop_intro_store_loca`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_journal`
--
ALTER TABLE `shop_journal`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_journal_cate`
--
ALTER TABLE `shop_journal_cate`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_keyword_set`
--
ALTER TABLE `shop_keyword_set`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_list_best`
--
ALTER TABLE `shop_list_best`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mcode` (`mcode`,`orders`);

--
-- 테이블의 인덱스 `shop_lookbook`
--
ALTER TABLE `shop_lookbook`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_lookbook_goods`
--
ALTER TABLE `shop_lookbook_goods`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `lookbook_idx` (`lookbook_idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `orders` (`orders`);

--
-- 테이블의 인덱스 `shop_lookbook_photo`
--
ALTER TABLE `shop_lookbook_photo`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `lookbook_idx` (`lookbook_idx`);

--
-- 테이블의 인덱스 `shop_member`
--
ALTER TABLE `shop_member`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `memgrade` (`memgrade`),
  ADD KEY `enterc` (`enterc`),
  ADD KEY `id` (`id`),
  ADD KEY `mem_type` (`memgroup`);

--
-- 테이블의 인덱스 `shop_member_addrs`
--
ALTER TABLE `shop_member_addrs`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_member_chlog`
--
ALTER TABLE `shop_member_chlog`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_member_chlog_ele`
--
ALTER TABLE `shop_member_chlog_ele`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `chlog_idx` (`chlog_idx`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_member_grades`
--
ALTER TABLE `shop_member_grades`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `grade_id` (`grade_id`),
  ADD KEY `enterb` (`enterb`),
  ADD KEY `pid` (`pid`),
  ADD KEY `sfid` (`sfid`);

--
-- 테이블의 인덱스 `shop_member_group`
--
ALTER TABLE `shop_member_group`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_member_out`
--
ALTER TABLE `shop_member_out`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_member_points`
--
ALTER TABLE `shop_member_points`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `market_idx` (`market_idx`),
  ADD KEY `codes` (`codes`),
  ADD KEY `wdate_s` (`wdate_s`);

--
-- 테이블의 인덱스 `shop_member_pre`
--
ALTER TABLE `shop_member_pre`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_movie`
--
ALTER TABLE `shop_movie`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isdel` (`isdel`);

--
-- 테이블의 인덱스 `shop_movie_schedule`
--
ALTER TABLE `shop_movie_schedule`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `date` (`date`);

--
-- 테이블의 인덱스 `shop_newbasket`
--
ALTER TABLE `shop_newbasket`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `op1` (`op1`),
  ADD KEY `op2` (`op2`),
  ADD KEY `set_idx` (`set_idx`),
  ADD KEY `sdate` (`sdate`),
  ADD KEY `market_idx` (`market_idx`),
  ADD KEY `up_idx` (`up_idx`),
  ADD KEY `smain_idx` (`smain_idx`),
  ADD KEY `sa_idx` (`sa_idx`),
  ADD KEY `last1` (`last1`);

--
-- 테이블의 인덱스 `shop_newbasket_tmp`
--
ALTER TABLE `shop_newbasket_tmp`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `op1` (`op1`),
  ADD KEY `op2` (`op2`),
  ADD KEY `nomem` (`nomem`),
  ADD KEY `market_idx` (`market_idx`),
  ADD KEY `set_idx` (`set_idx`),
  ADD KEY `sdate` (`sdate`),
  ADD KEY `op3` (`op3`),
  ADD KEY `sfid` (`sfid`);

--
-- 테이블의 인덱스 `shop_newcont`
--
ALTER TABLE `shop_newcont`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_newcont_files`
--
ALTER TABLE `shop_newcont_files`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `newcont_idx` (`newcont_idx`);

--
-- 테이블의 인덱스 `shop_newcont_read`
--
ALTER TABLE `shop_newcont_read`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `newcont_idx` (`newcont_idx`);

--
-- 테이블의 인덱스 `shop_newcont_show`
--
ALTER TABLE `shop_newcont_show`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `newcont_idx` (`newcont_idx`);

--
-- 테이블의 인덱스 `shop_newmarketdb`
--
ALTER TABLE `shop_newmarketdb`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `dan` (`dan`),
  ADD KEY `mem_idx` (`mem_idx`),
  ADD KEY `name` (`name`),
  ADD KEY `del_name` (`del_name`),
  ADD KEY `cp` (`cp`),
  ADD KEY `enterc` (`enterc`),
  ADD KEY `isstop` (`isstop`),
  ADD KEY `del_loc` (`del_loc`),
  ADD KEY `enterk` (`enterk`),
  ADD KEY `fid` (`fid`),
  ADD KEY `orderno` (`orderno`),
  ADD KEY `odate` (`odate`),
  ADD KEY `incdate` (`incdate`);

--
-- 테이블의 인덱스 `shop_newmarketdb_accounts`
--
ALTER TABLE `shop_newmarketdb_accounts`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `market_idx` (`market_idx`),
  ADD KEY `account` (`account`),
  ADD KEY `incdate` (`incdate`),
  ADD KEY `pgs` (`pgs`),
  ADD KEY `inname` (`inname`),
  ADD KEY `tbtype` (`tbtype`),
  ADD KEY `buymethod` (`buymethod`),
  ADD KEY `checkd` (`checkd`),
  ADD KEY `incdaten` (`incdaten`);
ALTER TABLE `shop_newmarketdb_accounts` ADD FULLTEXT KEY `inname_2` (`inname`);

--
-- 테이블의 인덱스 `shop_newmarketdb_memo`
--
ALTER TABLE `shop_newmarketdb_memo`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `wdate` (`wdate`),
  ADD KEY `market_index` (`market_idx`),
  ADD KEY `isauto` (`isauto`),
  ADD KEY `ischeck` (`ischeck`),
  ADD KEY `writer_idx` (`writer_idx`),
  ADD KEY `isscore` (`isscore`),
  ADD KEY `isdelay` (`isdelay`),
  ADD KEY `delaydate` (`delaydate`);

--
-- 테이블의 인덱스 `shop_newmarketdb_sms`
--
ALTER TABLE `shop_newmarketdb_sms`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `market_idx` (`market_idx`),
  ADD KEY `basket_idx` (`basket_idx`),
  ADD KEY `sms_idx` (`sms_idx`);

--
-- 테이블의 인덱스 `shop_nows`
--
ALTER TABLE `shop_nows`
  ADD PRIMARY KEY (`keys_v`),
  ADD KEY `member_idx` (`member_idx`),
  ADD KEY `end_time` (`end_time`);

--
-- 테이블의 인덱스 `shop_popup`
--
ALTER TABLE `shop_popup`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `edndate` (`edate`);

--
-- 테이블의 인덱스 `shop_qna`
--
ALTER TABLE `shop_qna`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `btype` (`btype`),
  ADD KEY `isdel` (`isdel`),
  ADD KEY `cate` (`cate`),
  ADD KEY `goods_idx` (`goods_idx`),
  ADD KEY `fid` (`fid`),
  ADD KEY `wdate` (`wdate`),
  ADD KEY `isjak` (`isjak`),
  ADD KEY `mem_name` (`mem_name`),
  ADD KEY `subject` (`subject`),
  ADD KEY `pid` (`pid`),
  ADD KEY `language` (`language`),
  ADD KEY `result` (`result`),
  ADD KEY `mem_idx` (`mem_idx`);

--
-- 테이블의 인덱스 `shop_qna_attach`
--
ALTER TABLE `shop_qna_attach`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `board_idx` (`qna_idx`),
  ADD KEY `ftype` (`ftype`),
  ADD KEY `fname` (`fname`),
  ADD KEY `orfname` (`orfname`),
  ADD KEY `tp` (`tp`);

--
-- 테이블의 인덱스 `shop_qna_cate`
--
ALTER TABLE `shop_qna_cate`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `catename` (`catename`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_qna_config`
--
ALTER TABLE `shop_qna_config`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_qna_templete`
--
ALTER TABLE `shop_qna_templete`
  ADD PRIMARY KEY (`idx`),
  ADD UNIQUE KEY `index_no` (`idx`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_sa`
--
ALTER TABLE `shop_sa`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `account1` (`account1`),
  ADD KEY `rtype` (`rtype`),
  ADD KEY `account2` (`account2`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_sa_dae`
--
ALTER TABLE `shop_sa_dae`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_sa_ele`
--
ALTER TABLE `shop_sa_ele`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_search_keyword`
--
ALTER TABLE `shop_search_keyword`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_show_tags`
--
ALTER TABLE `shop_show_tags`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `l_idx` (`l_idx`);

--
-- 테이블의 인덱스 `shop_sites`
--
ALTER TABLE `shop_sites`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_situation_msg`
--
ALTER TABLE `shop_situation_msg`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_stores`
--
ALTER TABLE `shop_stores`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_stores_imgs`
--
ALTER TABLE `shop_stores_imgs`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_store_connect`
--
ALTER TABLE `shop_store_connect`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_subcate`
--
ALTER TABLE `shop_subcate`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `upcate` (`upcate`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_timesale`
--
ALTER TABLE `shop_timesale`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_timesale_sellcou`
--
ALTER TABLE `shop_timesale_sellcou`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `deal_idx` (`deal_idx`);

--
-- 테이블의 인덱스 `shop_trans`
--
ALTER TABLE `shop_trans`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `lang` (`lang`,`wordkeys`);

--
-- 테이블의 인덱스 `shop_transsc`
--
ALTER TABLE `shop_transsc`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `lang` (`lang`,`wordkeys`);

--
-- 테이블의 인덱스 `shop_trans_key`
--
ALTER TABLE `shop_trans_key`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `keys` (`wordkeys`),
  ADD KEY `notrans` (`notrans`);

--
-- 테이블의 인덱스 `shop_trans_keysc`
--
ALTER TABLE `shop_trans_keysc`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `shop_view_today`
--
ALTER TABLE `shop_view_today`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `view_idx` (`mem_idx`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_warehouse`
--
ALTER TABLE `shop_warehouse`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `config_idx` (`config_idx`),
  ADD KEY `isbasic` (`isbasic`);

--
-- 테이블의 인덱스 `shop_warehouse_config`
--
ALTER TABLE `shop_warehouse_config`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `isuse` (`isuse`),
  ADD KEY `fid` (`fid`);

--
-- 테이블의 인덱스 `shop_wish`
--
ALTER TABLE `shop_wish`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `mem_idx` (`mem_idx`),
  ADD KEY `sdate` (`sdate`),
  ADD KEY `sifd` (`sfid`,`spid`),
  ADD KEY `goods_idx` (`goods_idx`);

--
-- 테이블의 인덱스 `shop_zipcode_jp`
--
ALTER TABLE `shop_zipcode_jp`
  ADD PRIMARY KEY (`idx`),
  ADD KEY `zipcode` (`zipcode`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `shop_action_reason`
--
ALTER TABLE `shop_action_reason`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_admin_config`
--
ALTER TABLE `shop_admin_config`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_admin_grade`
--
ALTER TABLE `shop_admin_grade`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_admin_priv`
--
ALTER TABLE `shop_admin_priv`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=970;

--
-- 테이블의 AUTO_INCREMENT `shop_ads`
--
ALTER TABLE `shop_ads`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_ads_read`
--
ALTER TABLE `shop_ads_read`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_ads_show`
--
ALTER TABLE `shop_ads_show`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after`
--
ALTER TABLE `shop_after`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after_base`
--
ALTER TABLE `shop_after_base`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after_cate`
--
ALTER TABLE `shop_after_cate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after_config`
--
ALTER TABLE `shop_after_config`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after_img`
--
ALTER TABLE `shop_after_img`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after_like`
--
ALTER TABLE `shop_after_like`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after_tags`
--
ALTER TABLE `shop_after_tags`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_after_tail`
--
ALTER TABLE `shop_after_tail`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_areview`
--
ALTER TABLE `shop_areview`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_areview_cate`
--
ALTER TABLE `shop_areview_cate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_areview_writer`
--
ALTER TABLE `shop_areview_writer`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_bankcode`
--
ALTER TABLE `shop_bankcode`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_board`
--
ALTER TABLE `shop_board`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_board_cate`
--
ALTER TABLE `shop_board_cate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_board_conf`
--
ALTER TABLE `shop_board_conf`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_board_goods`
--
ALTER TABLE `shop_board_goods`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_brand`
--
ALTER TABLE `shop_brand`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `shop_cate`
--
ALTER TABLE `shop_cate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `shop_config`
--
ALTER TABLE `shop_config`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `shop_config_apis`
--
ALTER TABLE `shop_config_apis`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_bm`
--
ALTER TABLE `shop_config_bm`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_color`
--
ALTER TABLE `shop_config_color`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_curr`
--
ALTER TABLE `shop_config_curr`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_config_domain`
--
ALTER TABLE `shop_config_domain`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `shop_config_goodsadd`
--
ALTER TABLE `shop_config_goodsadd`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_icon`
--
ALTER TABLE `shop_config_icon`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_lang`
--
ALTER TABLE `shop_config_lang`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `shop_config_maker`
--
ALTER TABLE `shop_config_maker`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_memo`
--
ALTER TABLE `shop_config_memo`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_msg`
--
ALTER TABLE `shop_config_msg`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_omemo`
--
ALTER TABLE `shop_config_omemo`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_pay`
--
ALTER TABLE `shop_config_pay`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_config_tags`
--
ALTER TABLE `shop_config_tags`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_cont`
--
ALTER TABLE `shop_cont`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_contact`
--
ALTER TABLE `shop_contact`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_cont_tail`
--
ALTER TABLE `shop_cont_tail`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_cont_tail_like`
--
ALTER TABLE `shop_cont_tail_like`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_country`
--
ALTER TABLE `shop_country`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_coupen`
--
ALTER TABLE `shop_coupen`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `shop_coupen_log`
--
ALTER TABLE `shop_coupen_log`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_coupen_mem`
--
ALTER TABLE `shop_coupen_mem`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_coupen_serial`
--
ALTER TABLE `shop_coupen_serial`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_crm_goodsread`
--
ALTER TABLE `shop_crm_goodsread`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_crm_selling`
--
ALTER TABLE `shop_crm_selling`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_customdb`
--
ALTER TABLE `shop_customdb`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_customdb_data`
--
ALTER TABLE `shop_customdb_data`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_customdb_data_ele`
--
ALTER TABLE `shop_customdb_data_ele`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_customdb_sch`
--
ALTER TABLE `shop_customdb_sch`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_delaccount_add`
--
ALTER TABLE `shop_delaccount_add`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_delivery_dcompany`
--
ALTER TABLE `shop_delivery_dcompany`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_delivery_fee_jp`
--
ALTER TABLE `shop_delivery_fee_jp`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_design_layout`
--
ALTER TABLE `shop_design_layout`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `shop_design_layout_addon`
--
ALTER TABLE `shop_design_layout_addon`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_design_mainconfig`
--
ALTER TABLE `shop_design_mainconfig`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `shop_design_maindata`
--
ALTER TABLE `shop_design_maindata`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `shop_design_maindata_ele`
--
ALTER TABLE `shop_design_maindata_ele`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_design_module`
--
ALTER TABLE `shop_design_module`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_domain`
--
ALTER TABLE `shop_domain`
  MODIFY `idx` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_ep_naver`
--
ALTER TABLE `shop_ep_naver`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_event`
--
ALTER TABLE `shop_event`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_event_goods`
--
ALTER TABLE `shop_event_goods`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_faq`
--
ALTER TABLE `shop_faq`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_faqcate`
--
ALTER TABLE `shop_faqcate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `shop_genmemo`
--
ALTER TABLE `shop_genmemo`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_goods`
--
ALTER TABLE `shop_goods`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `shop_goodslist`
--
ALTER TABLE `shop_goodslist`
  MODIFY `index_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_account`
--
ALTER TABLE `shop_goods_account`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_addinfo`
--
ALTER TABLE `shop_goods_addinfo`
  MODIFY `index_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_barcode`
--
ALTER TABLE `shop_goods_barcode`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_bun`
--
ALTER TABLE `shop_goods_bun`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_cate`
--
ALTER TABLE `shop_goods_cate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_cgroup`
--
ALTER TABLE `shop_goods_cgroup`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_change_account`
--
ALTER TABLE `shop_goods_change_account`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_color`
--
ALTER TABLE `shop_goods_color`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_imgs`
--
ALTER TABLE `shop_goods_imgs`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_inout`
--
ALTER TABLE `shop_goods_inout`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_inout_cate`
--
ALTER TABLE `shop_goods_inout_cate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_inout_paper`
--
ALTER TABLE `shop_goods_inout_paper`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_inout_pre`
--
ALTER TABLE `shop_goods_inout_pre`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_last`
--
ALTER TABLE `shop_goods_last`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_lefts`
--
ALTER TABLE `shop_goods_lefts`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_log`
--
ALTER TABLE `shop_goods_log`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_match`
--
ALTER TABLE `shop_goods_match`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_nimg`
--
ALTER TABLE `shop_goods_nimg`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_op1`
--
ALTER TABLE `shop_goods_op1`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_op2`
--
ALTER TABLE `shop_goods_op2`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_op3`
--
ALTER TABLE `shop_goods_op3`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_sale`
--
ALTER TABLE `shop_goods_sale`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_sale_ele`
--
ALTER TABLE `shop_goods_sale_ele`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_season`
--
ALTER TABLE `shop_goods_season`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_sets`
--
ALTER TABLE `shop_goods_sets`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_shops`
--
ALTER TABLE `shop_goods_shops`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_shops_config`
--
ALTER TABLE `shop_goods_shops_config`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_shops_group`
--
ALTER TABLE `shop_goods_shops_group`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_shops_imgs`
--
ALTER TABLE `shop_goods_shops_imgs`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_showlang`
--
ALTER TABLE `shop_goods_showlang`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_showsite`
--
ALTER TABLE `shop_goods_showsite`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_soldout`
--
ALTER TABLE `shop_goods_soldout`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_goods_subcate`
--
ALTER TABLE `shop_goods_subcate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_guide_config`
--
ALTER TABLE `shop_guide_config`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `shop_intro_store`
--
ALTER TABLE `shop_intro_store`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_intro_store_loca`
--
ALTER TABLE `shop_intro_store_loca`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_journal`
--
ALTER TABLE `shop_journal`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_journal_cate`
--
ALTER TABLE `shop_journal_cate`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `shop_keyword_set`
--
ALTER TABLE `shop_keyword_set`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_list_best`
--
ALTER TABLE `shop_list_best`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_lookbook`
--
ALTER TABLE `shop_lookbook`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_lookbook_goods`
--
ALTER TABLE `shop_lookbook_goods`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_lookbook_photo`
--
ALTER TABLE `shop_lookbook_photo`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_member`
--
ALTER TABLE `shop_member`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `shop_member_addrs`
--
ALTER TABLE `shop_member_addrs`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `shop_member_chlog`
--
ALTER TABLE `shop_member_chlog`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_member_chlog_ele`
--
ALTER TABLE `shop_member_chlog_ele`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_member_grades`
--
ALTER TABLE `shop_member_grades`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_member_group`
--
ALTER TABLE `shop_member_group`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `shop_member_out`
--
ALTER TABLE `shop_member_out`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_member_points`
--
ALTER TABLE `shop_member_points`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_member_pre`
--
ALTER TABLE `shop_member_pre`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 테이블의 AUTO_INCREMENT `shop_movie`
--
ALTER TABLE `shop_movie`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_movie_schedule`
--
ALTER TABLE `shop_movie_schedule`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_newbasket`
--
ALTER TABLE `shop_newbasket`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 테이블의 AUTO_INCREMENT `shop_newbasket_tmp`
--
ALTER TABLE `shop_newbasket_tmp`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 테이블의 AUTO_INCREMENT `shop_newcont`
--
ALTER TABLE `shop_newcont`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_newcont_files`
--
ALTER TABLE `shop_newcont_files`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_newcont_read`
--
ALTER TABLE `shop_newcont_read`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_newcont_show`
--
ALTER TABLE `shop_newcont_show`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_newmarketdb`
--
ALTER TABLE `shop_newmarketdb`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 테이블의 AUTO_INCREMENT `shop_newmarketdb_accounts`
--
ALTER TABLE `shop_newmarketdb_accounts`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `shop_newmarketdb_memo`
--
ALTER TABLE `shop_newmarketdb_memo`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_newmarketdb_sms`
--
ALTER TABLE `shop_newmarketdb_sms`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_popup`
--
ALTER TABLE `shop_popup`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_qna`
--
ALTER TABLE `shop_qna`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_qna_attach`
--
ALTER TABLE `shop_qna_attach`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_qna_cate`
--
ALTER TABLE `shop_qna_cate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_qna_config`
--
ALTER TABLE `shop_qna_config`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_qna_templete`
--
ALTER TABLE `shop_qna_templete`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_sa`
--
ALTER TABLE `shop_sa`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_sa_dae`
--
ALTER TABLE `shop_sa_dae`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_sa_ele`
--
ALTER TABLE `shop_sa_ele`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_search_keyword`
--
ALTER TABLE `shop_search_keyword`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_show_tags`
--
ALTER TABLE `shop_show_tags`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_sites`
--
ALTER TABLE `shop_sites`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_situation_msg`
--
ALTER TABLE `shop_situation_msg`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_stores`
--
ALTER TABLE `shop_stores`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `shop_stores_imgs`
--
ALTER TABLE `shop_stores_imgs`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `shop_store_connect`
--
ALTER TABLE `shop_store_connect`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_subcate`
--
ALTER TABLE `shop_subcate`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_timesale`
--
ALTER TABLE `shop_timesale`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_timesale_sellcou`
--
ALTER TABLE `shop_timesale_sellcou`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_trans`
--
ALTER TABLE `shop_trans`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_transsc`
--
ALTER TABLE `shop_transsc`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- 테이블의 AUTO_INCREMENT `shop_trans_key`
--
ALTER TABLE `shop_trans_key`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `shop_trans_keysc`
--
ALTER TABLE `shop_trans_keysc`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_view_today`
--
ALTER TABLE `shop_view_today`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 테이블의 AUTO_INCREMENT `shop_warehouse`
--
ALTER TABLE `shop_warehouse`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_warehouse_config`
--
ALTER TABLE `shop_warehouse_config`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `shop_wish`
--
ALTER TABLE `shop_wish`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 테이블의 AUTO_INCREMENT `shop_zipcode_jp`
--
ALTER TABLE `shop_zipcode_jp`
  MODIFY `idx` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
