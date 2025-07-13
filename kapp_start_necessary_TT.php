<?php
session_start();
/*
  kapp_start_necessary_TT.php 
  - call : index.php, index_kapp.php
   index.php - include : kapp_start_necessary_TT.php
             - iframe  : indexTT.php?go_url=' . $_url;
   index_kapp.php - include : kapp_start_necessary_TT.php
                  - iframe  : indexTT_kapp.php?go_url=' . $_url;
*/
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

if (!defined('KAPP_SET_TIME_LIMIT')) define('KAPP_SET_TIME_LIMIT', 0);
@set_time_limit(KAPP_SET_TIME_LIMIT);

//=========================================================================================================
// extract($_GET); 명령으로 인해 index.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
//---------------------------------------------------------------------------------------
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) { // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
}

define('TKHER_VERSION__', 'TKHER_V1');
define('_TKHER_', true);
define('KAPP_VERSION__', 'TKHER_V1');
define('_KAPP_', true);

	function m_($message) {
		echo "<script language='javascript'>alert('$message');</script>";
	}

	$tkher_path = array();
	$resultT = array();
	$tkher_iurl ="";
	$tkher_ipath="";
	function index_url_path(){
		global $tkher_ipath, $tkher_iurl;
		global $resultT;
		$resultT['path']	= str_replace('\\', '/', dirname(__FILE__));
		$tkher_ipath	= $resultT['path'];

		$tilde_rm= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
		$doc_root= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);
		$pattern = '/' . preg_quote($doc_root, '/') . '/i';
		$root    = preg_replace( $pattern, '', $resultT['path']);
		//m_("result_path: " . $resultT['path'] . ", doc_root: " . $doc_root . ", pattern: " . $pattern . ", root: " . $root);
		//result_path: /var/www/html/t, doc_root: /var/www/html, pattern: //var/www/html/i, root: /t

		$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
		//Old $http = 'http' . (( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
		//New $http = $_SERVER['REQUEST_SCHEME'] . "://";		//m_("http : " . $http ); // https
		if( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') $http = "https://";
		else if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ) $http = "https://";
		else if( isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') $http = "https://";
		else  $http = "http://";

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
		define('KAPP_URL',		$tkher_u );    // tkher_u:     https://ailinkapp.com
		define('KAPP_PATH',		$tkher_p );    // tkher_p:     /home/onlyshop/public_html
		define('KAPP_URL_',		$tkher_u );    // tkher_u:     https://ailinkapp.com
		define('KAPP_PATH_',		$tkher_p );    // tkher_p:     /home/onlyshop/public_html
		define('KAPP_URL_T_',		$tkher_iurl ); // tkher_iurl:  https://ailinkapp.com/t
		define('KAPP_PATH_T_',		$tkher_ipath );// tkher_ipath: /home/onlyshop/public_html/t
		define('KAPP_LOGO_URL_',	$tkher_u . '/logo' );
		define('KAPP_HOST_',		$host );// tkher_ipath: /home/onlyshop/public_html/t
		return $resultT;
	}
	$tkher_path = index_url_path();
	$tkher_config_file = KAPP_PATH_T_ . "/kapp_config.php";  //	$tkher_config_file = KAPP_PATH_T_ . "/tkher_config.php"; 
	include_once( $tkher_config_file );   // 설정 파일 	m_("KAPP_VERSION_: ".KAPP_VERSION_ . ", KAPP_PATH: " . KAPP_PATH);

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
$member		= array(); //m_("KAPP_LIB_PATH: ".KAPP_LIB_PATH); //KAPP_LIB_PATH: /home1/ledsignart/public_html/include/lib
	$dbconfig_file = KAPP_PATH_T_ . "/data/kapp_dbcon.php"; //$dbconfig_file = KAPP_PATH_T_ . "/data/tkher_dbconfig.php"; 
	$_myLIB        = KAPP_LIB_PATH . "/my_func.php";	// 2022-05-09 이동.

if( file_exists( $dbconfig_file) ) {
    include_once( $dbconfig_file);
	include_once( $_myLIB );      // 2021-04-04 add 공통 라이브러리

    $connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
    $select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');
    $tkher['connect_db'] = $connect_db;

    sql_set_charset('utf8', $connect_db);
    if( defined('KAPP_MYSQL_SET_MODE') && KAPP_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = ''");
} else {
		exit;
}
//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
//==============================================================================
@session_start();
//==============================================================================
//==============================================================================
/*
	//======== Kakao Login add ====================		
	$login_count_today = 0;
	$login_count_total = 0;
*/
?>
