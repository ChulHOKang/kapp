<?php
	session_start();
	function m_($message) {
		echo "<script language='javascript'>alert('$message');</script>";
	}
/*
    tkher_start_necessary.php : call : indexTT.php

	/t/index.php - include : kapp_start_necessary_TT.php - old: tkher_start_necessary.php
				 - iframe  : indexTT.php - include : tkher_start_necessary.php

	 index_kapp.php - include : kapp_start_necessary_TT.php
					- iframe  : indexTT_kapp.php?go_url=' . $_url;
						- include : kapp_start_necessary.php

	 모든 Program    - include : tkher_start_necessary.php
*/
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
	// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
	header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
	if( !defined('KAPP_SET_TIME_LIMIT')) define('KAPP_SET_TIME_LIMIT', 0);
	@set_time_limit(KAPP_SET_TIME_LIMIT);
	//=========================================================================================================
	// extract($_GET); 명령으로 인해 index.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
	//---------------------------------------------------------------------------------------
	$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
					  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
					  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
	$ext_cnt = count($ext_arr);
	for( $i=0; $i<$ext_cnt; $i++) { // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
		if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
		if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
	}

	define('KAPP_VERSION__', 'KAPP V1');
	define('_KAPP_', true);
	define('KAPP_DISPLAY_SQL_ERROR', FALSE); // kapp_dblib_common 에서 사용.

	$tkher_path = array();
	$resultT = array();
	$tkher_iurl ="";
	$tkher_ipath=""; //$host = "";

	function index_url_path(){
		global $tkher_ipath, $tkher_iurl;
		global $resultT;

		$resultT['path']	= str_replace('\\', '/', dirname(__FILE__));
		$tkher_ipath	= $resultT['path'];

		$tilde_rm= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
		$doc_root= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);
		$pattern = '/' . preg_quote($doc_root, '/') . '/i';
		$root    = preg_replace( $pattern, '', $resultT['path']);

		$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
		$http = $_SERVER['REQUEST_SCHEME'] . "://";		//m_("http : " . $http ); // https

		$user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
		$host = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		if( isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
			$host	= preg_replace('/:[0-9]+$/', '', $host);
		$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
		$words = explode( '/', $_SERVER['SCRIPT_FILENAME'] );
		$tkher_iurl		= $http.$host.$port.$user.$root;
		$tkher_u = $http . $host;
		$tkher_p = "/" . $words[1] . "/" . $words[2] . "/" . $words[3];

		define('KAPP_DIR_',		$root );       // root:        /t
		define('KAPP_URL',		$tkher_u );    // tkher_u:     https://fation.net
		define('KAPP_PATH',		$tkher_p );    // tkher_p:     /home/onlyshop/public_html
		define('KAPP_URL_',		$tkher_u );    // tkher_u:     https://fation.net
		define('KAPP_PATH_',	$tkher_p );    // tkher_p:     /home/onlyshop/public_html
		define('KAPP_URL_T_',	$tkher_iurl ); // tkher_iurl:  https://fation.net/t
		define('KAPP_PATH_T_',	$tkher_ipath );// tkher_ipath: /home/onlyshop/public_html/t
		define('KAPP_LOGO_URL_',$tkher_u . '/logo' );
		define('KAPP_HOST_',	$host );		// tkher_ipath: /home/onlyshop/public_html/t
		return $resultT;
	}
	$tkher_path = index_url_path();
	$tkher_config_file = KAPP_PATH_T_ . "/kapp_config.php";
	include_once( $tkher_config_file );   // 설정 파일

//==============================================================================
// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용
//------------------------------------------------------------------------------

// PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우
@extract($_GET);
@extract($_POST);
@extract($_SERVER);

$config		= array();
$board		= array();
$group		= array();
$tkher		= array();
$member		= array();

$dbconfig_file = KAPP_PATH_T_ . "/data/kapp_dbcon.php";
$_myLIB        = KAPP_LIB_PATH . "/my_func.php";
if( file_exists( $dbconfig_file) ) {
    include_once( $dbconfig_file);
	include_once( $_myLIB );
    $connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
    $select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');
    $tkher['connect_db'] = $connect_db;
    sql_set_charset('utf8', $connect_db);
} else {
	$setup = KAPP_URL_T_ . "/setup/index.php";
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>Error! <?php echo KAPP_VERSION_ ?> K-App Setup</title>
    <link rel="stylesheet" href="./install_/install.css">
</head>

<body>

    <div id="ins_bar">
        <span id="bar_img">K-App : program source code generator</span>
        <span id="bar_txt">dbconfig_file: <?=$dbconfig_file?></span>
    </div>
    <h1>Please install K-App. </h1>
    <div class="ins_inner">
        <p>File not found</p><!-- 다음 파일을 찾을 수 없습니다. -->
        <ul>
            <li><strong><?=$dbconfig_file ?> or <?=$_fileLIB?></strong></li>
        </ul>
        <!-- (Web DB Generator 설치 후 다시 실행하시기 바랍니다.) -->
        <p>Run K-App again after installation.</p>
        <div class="inner_btn">
            <!-- <a href="<?php echo KAPP_URL; ?>/install/">AppGeneratorSystem Setup</a> -->
            <a href="<?=$setup?>">K-App Setup</a>
        </div>
    </div>
    <div>
        <strong>K-App : program source code generator</strong>
    </div>

</body>

</html>

<?php
		exit;
}

$time_micro = microtime();
$begin_time = get_microtime();
//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags","");
if( isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

//==============================================================================
// 공용 변수
//------------------------------------------------------------------------------
// 기본환경설정// 기본적으로 사용하는 필드만 얻은 후 상황에 따라 필드를 추가로 얻음

	$config = sql_fetch(" SELECT * from {$tkher['config_table']} ");


	// URL ENCODING
	if( isset($_REQUEST['url'])) {
		$url = strip_tags(trim($_REQUEST['url']));
		$urlencode = urlencode($url);
	} else {
		$url = '';
		$urlencode = urlencode($_SERVER['REQUEST_URI']);
		if( KAPP_DOMAIN) {
			$p = @parse_url(KAPP_DOMAIN);
			$urlencode = KAPP_DOMAIN.urldecode(preg_replace("/^".urlencode($p['path'])."/", "", $urlencode));
		}
	}
	if( isset($_REQUEST['page'])) { // 리스트 페이지
		$page = (int)$_REQUEST['page'];
		if ($page)
			$qstr .= '&amp;page=' . urlencode($page);
	} else {
		$page = '';
	}
	//==============================================================================

	$host_script = $tkher_iurl . $_SERVER['SCRIPT_NAME'];

    $user_agent  = is_mobileX(); //escape_trim(clean_xss_tags($_SERVER['HTTP_USER_AGENT']));
	$remote_addr = escape_trim($_SERVER['REMOTE_ADDR']);
	$kapp_host   = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
	if( isset($member['mb_id']) ) $H_ID_IPADDR = $kapp_host . "_" . $member['mb_id']. "_" . $remote_addr;
	else $H_ID_IPADDR = $kapp_host . "_" . $remote_addr;

    $referer = "";
    if( isset($_SERVER['HTTP_REFERER']))
        $referer = escape_trim(clean_xss_tags($_SERVER['HTTP_REFERER'])). " : " . $H_ID_IPADDR;

	$H_ID = "";
	if( isset($_SESSION['ss_mb_id']) ) $ss_mb_id = $_SESSION['ss_mb_id'];
	else $ss_mb_id = "";			
	
	if( isset($_SESSION['ss_mb_id']) ) { // 로그인중이라면
		$member = get_urllink_memberA( $ss_mb_id );
		// 차단된 회원이면 ss_mb_id 초기화
		if( isset($member['mb_intercept_date']) && $member['mb_intercept_date'] <= date("Ymd", KAPP_SERVER_TIME)) {
			set_session('ss_mb_id', '');
			$member = array();
			m_("start --- 차단된 회원이면 ss_mb_id 초기화 --- ss_mb_id NULL set ");
		} else { // 오늘 처음 로그인 이라면
			if( isset( $member['mb_today_login']) && substr( $member['mb_today_login'], 0, 10) != KAPP_TIME_YMD) { // 첫 로그인 포인트 지급
				insert_point_app($member['mb_id'], $config['kapp_login_point'], KAPP_TIME_YMD.' first_login', '@login', $member['mb_id'], $member['mb_id'], KAPP_TIME_YMD);

				// 오늘의 로그인이 될 수도 있으며 마지막 로그인일 수도 있음  해당 회원의 접근일시와 IP 를 저장
				$sql = " update {$tkher['tkher_member_table']} set mb_today_login = '".KAPP_TIME_YMDHIS."', mb_login_ip = '{$remote_addr}' where mb_id = '{$member['mb_id']}' ";
				sql_query($sql);
			}
		}
	} else {
			if( !strpos( $_SERVER['SCRIPT_NAME'], "indexTT.php")  ) {
				connect_count($host_script, "Guest", 1, $referer);	// 방문 실행시 항상 count -  1: log_info 생성, 관리자ip log 생성, 0:미생성.
			}
		// 자동로그인 ---------------------------------------
		// 회원아이디가 쿠키에 저장되어 있다면 (3.27)

		if( $tmp_mb_id = get_cookie('kapp_mb_id')) {

			$tmp_mb_id = substr( preg_replace("/[^a-zA-Z0-9_]* /", "", $tmp_mb_id), 0, 20);
			// 최고관리자는 자동로그인 금지
			if( strtolower($tmp_mb_id) != strtolower( $config['kapp_admin'])) {
				$sql = " select mb_password, mb_intercept_date, mb_leave_date, mb_email_certify from {$tkher['tkher_member_table']} where mb_id = '{$tmp_mb_id}' ";
				$row = sql_fetch($sql);
				$key = md5($_SERVER['SERVER_ADDR'] . $remote_addr . $user_agent . $row['mb_password']);
				// 쿠키에 저장된 키와 같다면
				$tmp_key = get_cookie('ck_auto');

				if( $tmp_key === $key && $tmp_key) {
					// 차단, 탈퇴가 아니고 메일인증이 사용이면서 인증을 받았다면
					if( $row['mb_intercept_date'] == '' && $row['mb_leave_date'] == '' && (!$config['kapp_use_email_certify'] || preg_match('/[1-9]/', $row['mb_email_certify'])) ) {
						// 세션에 회원아이디를 저장하여 로그인으로 간주
						set_session('ss_mb_id', $tmp_mb_id);
						set_session('urllink_login_type', 'appgeneratorsystem');
						$member = get_urllink_memberA( $_SESSION['ss_mb_id']);
						echo "<script type='text/javascript'> window.location.reload(); </script>";
						exit;
					}
				}
				// $row 배열변수 해제
				unset($row);
			}
		}
		// 자동로그인 end ---------------------------------------
	}
//=========================================================================================
// 회원, 비회원 구분
if( isset($member['mb_level']) ){
	if( $member['mb_level'] >= $config['kapp_admin_level'] ) $is_admin = 'super'; // 7 -> $config['admin_level'] - 2024-02-19
}
else {
	$is_admin = '';
}

if( isset($member['mb_id']) ) {
	$is_guest = false;
    $is_member = true;
    $is_admin = is_admin( $member['mb_id']);
} else {
	$is_member = false;
    $is_guest = true;
    $member['mb_id'] = '';
    $member['mb_level'] = 1; // 비회원의 경우 회원레벨을 가장 낮게 설정
}
if( $is_admin != 'super') {
    // 접근가능 IP
    $kapp_possible_ip = trim($config['kapp_possible_ip']);
    if( $kapp_possible_ip) {
        $is_possible_ip = false;
        $pattern = explode("\n", $kapp_possible_ip);
        for( $i=0; $i<count($pattern); $i++) {
            $pattern[$i] = trim($pattern[$i]);
            if( empty($pattern[$i])) continue;
            $pattern[$i] = str_replace(".", "\.", $pattern[$i]);
            $pattern[$i] = str_replace("+", "[0-9\.]+", $pattern[$i]);
            $pat = "/^{$pattern[$i]}$/";
            $is_possible_ip = preg_match($pat, $remote_addr);
            if( $is_possible_ip) break;
        }
        if( !$is_possible_ip) die ("<meta charset=utf-8>접근이 가능하지 않습니다.");
    }

    // 접근차단 IP
    $is_intercept_ip = false;
    $pattern = explode("\n", trim($config['kapp_intercept_ip']));
    for( $i=0; $i<count($pattern); $i++) {
        $pattern[$i] = trim($pattern[$i]);
        if( empty($pattern[$i])) continue;
        $pattern[$i] = str_replace(".", "\.", $pattern[$i]);
        $pattern[$i] = str_replace("+", "[0-9\.]+", $pattern[$i]);
        $pat = "/^{$pattern[$i]}$/";
        $is_intercept_ip = preg_match($pat, $remote_addr);
        if( $is_intercept_ip) die ("<meta charset=utf-8>접근 불가합니다.");
    }
}

/* =====================================================================================
 사용기기 설정
 config.php KAPP_SET_DEVICE 설정에 따라 사용자 화면 제한됨
 pc 설정 시 모바일 기기에서도 PC화면 보여짐
 mobile 설정 시 PC에서도 모바일화면 보여짐
 both 설정 시 접속 기기에 따른 화면 보여짐
------------------------------------------------------------------------------------- */
$is_mobile = false;
$set_device = true;
$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

if(defined('KAPP_SET_DEVICE') && $set_device) {
    switch(KAPP_SET_DEVICE) {
        case 'pc':
            $is_mobile  = false;
            $set_device = false;
            break;
        case 'mobile':
            $is_mobile  = true;
            $set_device = false;
            break;
        default:
            break;
    }
}
//==============================================================================

//==============================================================================
// Mobile 모바일 설정
// 쿠키에 저장된 값이 모바일이라면 브라우저 상관없이 모바일로 실행
// 그렇지 않다면 브라우저의 HTTP_USER_AGENT 에 따라 모바일 결정
// KAPP_MOBILE_AGENT : config.php 에서 선언
//------------------------------------------------------------------------------
if( KAPP_USE_MOBILE && $set_device) {
    if( isset($_REQUEST['device']) ){
		if( $_REQUEST['device']=='pc') $is_mobile = false;
		else if( $_REQUEST['device']=='mobile')	$is_mobile = true;
		else if( isset($_SESSION['ss_is_mobile'])) $is_mobile = $_SESSION['ss_is_mobile'];
		else if( is_mobile()) $is_mobile = true;
	} else $is_mobile = false;
} else {
    $set_device = false;
}

$_SESSION['ss_is_mobile'] = $is_mobile;
define('KAPP_IS_MOBILE', $is_mobile);
define('KAPP_DEVICE_BUTTON_DISPLAY', $set_device);
// 방문자수의 접속을 남김 : // get_cookie - ck_visit_ip: , _SERVER-REMOTE_ADDR: 172.31.34.132
if( get_cookie('kapp_ck_visit_ip') != $H_ID_IPADDR ) {
	include_once( KAPP_PATH_T_ .'/kapp_visit_insert.php'); // include_once('./visit/visit_insert.inc.php'); // 로그인 log 사용
}

$html_process = new html_process();

// multi-dimensional array에 사용자지정 함수적용 ========= add 2024-02-20
function array_map_deep($fn, $array)
{
    if(is_array($array)) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = array_map_deep($fn, $value);
            } else {
                $array[$key] = call_user_func($fn, $value);
            }
        }
    } else {
        $array = call_user_func($fn, $array);
    }
    return $array;
}
// SQL Injection 대응 문자열 필터링
function sql_escape_string($str)
{
    if( defined('KAPP_ESCAPE_PATTERN') && defined('KAPP_ESCAPE_REPLACE')) {
        $pattern = KAPP_ESCAPE_PATTERN;
        $replace = KAPP_ESCAPE_REPLACE;
        if( $pattern)
            $str = preg_replace($pattern, $replace, $str);
    }
    $str = call_user_func('addslashes', $str);
    return $str;
}
//=========================================================
// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용
//---------------------------------------------------------
// sql_escape_string 적용
$_POST    = array_map_deep(KAPP_ESCAPE_FUNCTION,  $_POST);
$_GET     = array_map_deep(KAPP_ESCAPE_FUNCTION,  $_GET);
$_COOKIE  = array_map_deep(KAPP_ESCAPE_FUNCTION,  $_COOKIE);
$_REQUEST = array_map_deep(KAPP_ESCAPE_FUNCTION,  $_REQUEST);
//========================================================================= end

$KAPP_URL=KAPP_URL;
$KAPP_PATH=KAPP_PATH;
$KAPP_LIB_PATH=KAPP_LIB_PATH;
$KAPP_URL_T_=KAPP_URL_T_;

function is_mobileX() { // 2025-04-29 add kan
    if (isset($_SERVER['HTTP_SEC_CH_UA_MOBILE'])) {
		// HTTP_SEC_CH_UA_MOBILE 헤더가 존재하고, 값이 '?1'인 경우 모바일로 판단합니다.
		// 참조: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Sec-CH-UA-Mobile
        return ( '?1' === $_SERVER['HTTP_SEC_CH_UA_MOBILE'] ); //
    } elseif (!empty($_SERVER['HTTP_USER_AGENT'])) {
		// HTTP_USER_AGENT를 분석하여 모바일 특징을 찾습니다.
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        return str_contains($user_agent, 'Mobile')
            || str_contains($user_agent, 'Android')
            || str_contains($user_agent, 'Silk/')
            || str_contains($user_agent, 'Kindle')
            || str_contains($user_agent, 'BlackBerry')
            || str_contains($user_agent, 'Opera Mini')
            || str_contains($user_agent, 'Opera Mobi');
    } else {
		// HTTP_SEC_CH_UA_MOBILE 헤더도 없고, HTTP_USER_AGENT도 없으면 모바일이 아닌 것으로 간주합니다.
        return false;
    }
}
?>