<?php
//ini_set("display_errors", 1);
require_once ("../../inc/config_default.php");
require_once "$_basedir/inc/connect.php";
require_once "$_basedir/inc/session.php";
require_once "$_basedir/inc/config_site.php";
	
	if(!isset($_REQUEST['pre_idx'])){
		die('1000|잘못된 접근입니다.');
	}
	
	$ar_data = sel_query_all("shop_member_pre"," where idx='".$_REQUEST['pre_idx']."'");
	if(!$ar_data['idx'])	{
		die('1000|잘못된 접근입니다.');		
	}

    // 각 버전 별 맞는 mobileOKManager-php를 사용
    $mobileOK_path = "./mobileOK_manager_phpseclib_v3.0_v1.0.2.php";

    if(!file_exists($mobileOK_path)) {
        die('1000|mobileOK_Key_Manager파일이 존재하지 않습니다.');
    } else {
        require_once $mobileOK_path;
    }
?>
<?php
    header("Content-Type:text/html;charset=utf-8");

    /* 1. 본인확인 서비스 API 설정 */
    $mobileOK = new mobileOK_Key_Manager();
    /* [변경필요] 키파일 및 키파일 패스워드는 드림시큐리티에서 제공한 mok_keyinfo.dat 경로 및 패스워드를 지정 */
    /* 키파일은 반드시 서버의 안전한 로컬경로에 별도 저장. 웹URL 경로에 파일이 있을경우 키파일이 외부에 노출될 수 있음 주의 */
    /* 키파일은 개발용과 운영용으로 구분 ➔ 개발 및 테스트 시 개발용 키파일을 이용 / 운영 환경에 적용 시 운영용 키파일로 변경 적용 필요 */
    $key_path = "./mok_keyInfo.dat";
    $password = "gran1004";
    $mobileOK->key_init($key_path, $password);

    // 이용기관 거래ID생성시 이용기관별 유일성 보장을 위해 설정
    $clientPrefix = "granhand";     // [변경필요] 드림시큐리티에서 배포한 웹관리도구 회원사ID 설정

    /* [변경필요] 결과 수신 후 전달 URL 설정 */
    /* 결과 전달 URL 내에 개인정보 포함을 절대 금지합니다.*/
	
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
	$host = $_SERVER['HTTP_HOST'];

    $result_return_url = $protocol.$host."/dream/mok_std_result.php";

    /* 2. 거래 정보 호출 */
    echo mobileOK_std_request($mobileOK, $result_return_url,$clientPrefix);
?>
<?php
    /* 본인확인 표준창 인증 요청 예제 함수 */
    function mobileOK_std_request($mobileOK, $result_return_url, $clientPrefix) {
        // local시간 설정이 다르게 될  수 있음으로 기본 시간 설정을 서울로 해놓는다.
        date_default_timezone_set('Asia/Seoul');

        /* 3. 본인확인-표준창 거래요청정보 생성  */

        /* 3.1 이용기관 거래ID 생성, 20자 이상 40자 이내 이용기관 고유 트랜잭션ID (예시) 이용기관식별자+UUID, ...  */
        // - 본인확인-표준창 거래ID 는 유일한 값이어야 하며 기 사용한 거래ID가 있는 경우 오류 발생 
        // - 이용기관이 고유식별 ID로 유일성을 보장할 경우 고객이 이용하는 ID사용 가능 
        $client_tx_id = $clientPrefix.uuid();

        /* 3.2 인증 결과 검증을 위한 거래 ID 세션 저장 */
        // 동일한 세션내 요청과 결과가 동일한지 확인 및 인증결과 재사용 방지처리, 응답결과 처리 시 필수 구현
        // 세션 내 거래ID를 저장하여 검증하는 방법은 권고 사항이며, 이용기관 저장매체(DB 등)에 저장하여 검증 가능
		
        $_SESSION['sessionClientTxId'] = $client_tx_id;
		$_SESSION['pre_idx'] = $_REQUEST['pre_idx'];

        /* 3.3 거래 ID, 인증 시간을 통한 본인확인 거래 요청 정보 생성  */
        $date_time = date("YmdHis");
        $req_client_info = $client_tx_id."|".$date_time;

        /* 3.4 생성된 거래정보 암호화 */
        $encrypt_req_client_info = $mobileOK->rsa_encrypt($req_client_info);

        /* 3.5 거래 요청 정보 JSON 생성 */
        $send_data = array(
            /* 본인확인 서비스 용도 */
            /* 01001 : 회원가입, 01002 : 정보변경, 01003 : ID찾기, 01004 : 비밀번호찾기, 01005 : 본인확인용, 01007 : 상품구매/결제, 01999 : 기타 */
            'usageCode'=> '01001'
            /* 본인확인 서비스 ID */
            , 'serviceId'=>$mobileOK->get_service_id()
            /* 암호화된 본인확인 거래 요청 정보 */
            , 'encryptReqClientInfo'=>$encrypt_req_client_info
            /* 이용상품 코드 */
            /* 이용상품 코드, telcoAuth : 휴대폰본인확인 (SMS인증시 인증번호 발송 방식 "SMS")*/
            /* 이용상품 코드, telcoAuth-LMS : 휴대폰본인확인 (SMS인증시 인증번호 발송 방식 "LMS")*/
            , 'serviceType'=>'telcoAuth'
            /* 본인확인 결과 타입 */
            /* 본인확인 결과 타입, "MOKToken"  : 개인정보 응답결과를 이용기관 서버에서 본인확인 서버에 요청하여 수신 후 처리 */            
            , 'retTransferType'=>'MOKToken'             
            /* 본인확인 결과 수신 URL - "https://" 포함한 URL 입력 */
            , 'returnUrl'=>$result_return_url
        );

        /* 3.6 거래 요청 정보 JSON 반환 */
        // JSON Encoding시 '/'입력시 '\\/'로 입력되는 현상을 방지하기 위해서 아래의 옵션을 사용
        return json_encode($send_data, JSON_UNESCAPED_SLASHES);
    }

    /* 거래 ID(uuid) 생성 예제 함수 */
    function uuid() {
        return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
?>
