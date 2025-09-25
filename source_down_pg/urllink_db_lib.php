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
//	$tkher_config_file = TKHER_PATH_T_ . "/tkher_config_link.php";       

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
define('TKHER_VERSION__', 'TKHER_V1');      
define('_TKHER_', true);
define('TKHER_MYSQLI_USE', true);
define('TKHER_DISPLAY_SQL_ERROR', FALSE);

	function index_url_path()       
	{       
		$result['path']	= str_replace('\\', '/', dirname(__FILE__));       
		$tilde_rm		= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);       
		$doc_root		= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);       
		$pattern			= '/' . preg_quote($doc_root, '/') . '/i';       
		$root				= preg_replace($pattern, '', $result['path']);  
		$result['root']	= preg_replace($pattern, '', $result['path']);  
		
		$port				= ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];       
		$http				= 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';       
		$user				= str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);       
		$host				= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];       
		if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))       
			$host	= preg_replace('/:[0-9]+$/', '', $host);       
		$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);       
		$tkher_iurl	= $http.$host.$port.$user.$root;       
		$tkher_ipath	= $result['path'];       
		$tkher_u		= substr($tkher_iurl, 0, -2);		//0부터 뒤의 -1까지. , 마지막부분 '/' 없이 전달한다. 예:https://tkher.com       
		$tkher_p		= substr($tkher_ipath, 0, -2);       
		define('TKHER_URL_',		$tkher_u );       
		define('TKHER_PATH_',		$tkher_p );       
		define('TKHER_URL_T_',		$tkher_iurl );       
		define('TKHER_PATH_T_',		$tkher_ipath );       
		define('TKHER_LOGO_URL_',	$tkher_u . '/logo' );       
//		define('TKHER_PATH_CRATREE_', $tkher_p.'/cratree' );       
		return $result;       
//		return $root;       
	}       
	function m_($message) {       
		echo "<script language='javascript'>alert('$message');</script>";       
	}       
//		$tkher_path = index_url_path();      
//		$tkher_config_file = TKHER_PATH_T_ . "/tkher_config_link.php";       
		//m_("root:$tkher_path[root], $tkher_path[path], tkher_config_file:$tkher_config_file");
		//root:/cratree/dao, /var/www/html/cratree/dao, tkher_config_file:/var/www/html/cratree/dao/tkher_config_link.php
		//tkher_path:/var/www/html/cratree/dao, tkher_config_file:/var/www/html/cratree/dao/tkher_config_link.php
		//tkher_path:/cratree/dao, tkher_config_file:/var/www/html/cratree/dao/tkher_config_link.php
		//tkher_path:Array, tkher_config_file:/var/www/html/cratree/dao/tkher_config_link.php
//		$tkher_config_file = "./tkher_config_link.php";       
//		include_once( $tkher_config_file );   // 설정 파일      

if (!defined('TKHER_SET_TIME_LIMIT')) define('TKHER_SET_TIME_LIMIT', 0);      
@set_time_limit(TKHER_SET_TIME_LIMIT);      
//==============================================================================
// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용
//------------------------------------------------------------------------------
// magic_quotes_gpc 에 의한 backslashes 제거
if (get_magic_quotes_gpc()) {
    $_POST		= array_map_deep('stripslashes',  $_POST);
    $_GET		= array_map_deep('stripslashes',  $_GET);
    $_COOKIE	= array_map_deep('stripslashes',  $_COOKIE);
    $_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
}

	@extract($_GET);      
	@extract($_POST);      
	@extract($_SERVER);      
	/*
		$dbconfig_file = TKHER_PATH_T_ . "./tkher_dbconfig.php";     // setup에서 생성해야한다. 
	if ( file_exists($dbconfig_file) ) {       

		$_fileLIB = TKHER_LIB_PATH . "/tkher_db_lib_common.php";
		// /home1/solpakanurl/public_html/t/include/lib/tkher_db_lib_common.php
		include_once( $dbconfig_file );       
		include_once( $_fileLIB );    // 공통 라이브러리       
		$connect_db = sql_connect(TKHER_MYSQL_HOST, TKHER_MYSQL_USER, TKHER_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');       
		$select_db  = sql_select_db(TKHER_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');       
		$tkher['connect_db'] = $connect_db;       
		sql_set_charset('utf8', $connect_db);       
		if(defined('TKHER_MYSQL_SET_MODE') && TKHER_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = '' ");       
		if (defined(TKHER_TIMEZONE)) sql_query(" set time_zone = '".TKHER_TIMEZONE."'");       
	} else { 
		   //m_(" dbconfig_file:/var/www/html/t/data/tkher_dbconfig.php no found.  ");      
			//echo "<script language='javascript'>window.open('/t/tkher_dbcon_create.php?mid=dao','','');</script>";       
	} 
	*/      

//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함.

//session_save_path(TKHER_SESSION_PATH);

if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

//ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
//ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
//ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
//ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

//session_set_cookie_params(0, '/');
//ini_set("session.cookie_domain", TKHER_COOKIE_DOMAIN);

@session_start();
//==============================================================================

?>      
