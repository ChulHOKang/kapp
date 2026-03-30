<?php      
	session_start();
	$lifetime=600;
	//session_set_cookie_params($lifetime);
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );      
	header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');      
	$config		= array();      
	$tkher		= array();      
	$member		= array();

	$tkher_path = index_url_path();      
//	$tkher_config_file = KAPP_PATH_T_ . "/tkher_config_link.php";       

	$tkher_config_file = "./tkher_config_link.php";       
	include_once( $tkher_config_file );   // 설정 파일      

//==========================================================================================      
// extract($_GET);명령으로 page.php?_POST[var1]=data1&_POST[var2]=data2와 같은 코드가_POST변수로사용되는 것을 막음      
//------------------------------------------------------------------------------------------ 
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',      
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',      
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');      
$ext_cnt = count($ext_arr);      
for ($i=0; $i<$ext_cnt; $i++) {      
    // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴      
    if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);      
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);      
}      
define('KAPP_VERSION__', 'KAPP_V1');      
define('_KAPP_', true);
define('KAPP_MYSQLI_USE', true);
define('KAPP_DISPLAY_SQL_ERROR', FALSE);

	function index_url_path() {
		$result['path']	= str_replace('\\', '/', dirname(__FILE__));       
		$tilde_rm= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);       
		$doc_root= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);       
		$pattern= '/' . preg_quote($doc_root, '/') . '/i';       
		$root= preg_replace( $pattern, '', $result['path']);  
		$result['root']	= preg_replace($pattern, '', $result['path']);  
		
		$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];       
		//$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';       
		if( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') $http = "https://";
		else if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ) $http = "https://";
		else if( isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') $http = "https://";
		else  $http = "http://";

		$user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);       
		$host = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];       
		if( isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))       
			$host	= preg_replace('/:[0-9]+$/', '', $host);       
		$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);       
		if( isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
			$host	= preg_replace('/:[0-9]+$/', '', $host);
		$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
		$words = explode( '/', $_SERVER['SCRIPT_FILENAME'] );
		$tkher_iurl		= $http.$host.$port.$user.$root;       
		$tkher_ipath	= $result['path'];       
		$tkher_u = $http . $host;
		$tkher_p = "/" . $words[1] . "/" . $words[2] . "/" . $words[3];

		define('KAPP_URL_',		$tkher_u );       
		define('KAPP_URL',		$tkher_u );    // tkher_u:     https://fation.net
		define('KAPP_PATH_',		$tkher_p );       
		define('KAPP_URL_T_',		$tkher_iurl );       
		define('KAPP_PATH_T_',		$tkher_ipath );       
		define('KAPP_LOGO_URL_',	$tkher_u . '/logo' );       
		return $result;       
	}       

	function m_($message) {       
		echo "<script language='javascript'>alert('$message');</script>";       
	}       

if (!defined('KAPP_SET_TIME_LIMIT')) define('KAPP_SET_TIME_LIMIT', 0);      
@set_time_limit(KAPP_SET_TIME_LIMIT);      
//==============================================================================
// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용
//------------------------------------------------------------------------------
	@extract($_GET);      
	@extract($_POST);      
	@extract($_SERVER);      

//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함.

//session_save_path(KAPP_SESSION_PATH);

if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

//ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
//ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
//ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
//ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

//session_set_cookie_params(0, '/');
//ini_set("session.cookie_domain", KAPP_COOKIE_DOMAIN);

@session_start();
//==============================================================================

?>      
