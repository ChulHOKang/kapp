<?php      
	session_start();
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );      
	header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');      
	$config		= array();      
	$tkher		= array();      
	$member		= array();
	$tkher_path = index_url_path();      
	$tkher_config_file = "./tkher_config_link.php";       
	include_once( $tkher_config_file );

	$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',      
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',      
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');      
	$ext_cnt = count($ext_arr);      
	for( $i=0; $i<$ext_cnt; $i++) {
		if( isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);      
		if( isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);      
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
		define('KAPP_URL',		$tkher_u );
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

if( get_magic_quotes_gpc()) {
    $_POST		= array_map_deep('stripslashes',  $_POST);
    $_GET		= array_map_deep('stripslashes',  $_GET);
    $_COOKIE	= array_map_deep('stripslashes',  $_COOKIE);
    $_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
}
@extract($_GET);      
@extract($_POST);      
@extract($_SERVER);      
@ini_set("session.use_trans_sid", 0);
@ini_set("url_rewriter.tags",""); 
if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");
@session_start();
?>      
