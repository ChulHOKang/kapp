<?php      
	session_start();
	$lifetime=600;	//session_set_cookie_params($lifetime);
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );      
	header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');      

	function m_($message) {       
		echo "<script language='javascript'>alert('$message');</script>";       
	}       
	$config		= array();      
	$tkher		= array();  // 반드시 필요! kan    
	$member		= array();

	$tkher_path = index_url_path();      

	$tkher_config_file = KAPP_PATH_T_ . "/setup/kapp_config.php";       // 디렉토리 define , tkher_config_link.php
	include_once( $tkher_config_file );   // 설정 파일      

	$dbconfig_file = KAPP_PATH_T_ . "/data/kapp_dbcon.php";
	if( file_exists( $dbconfig_file) ) {
		include_once( $dbconfig_file);
	}
	//==========================================================================================      
	// extract($_GET);명령으로 page.php?_POST[var1]=data1&_POST[var2]=data2와 같은 코드가_POST변수로사용되는 것을 막음      
	//------------------------------------------------------------------------------------------ 
	$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',      
					  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',      
					  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');      
	$ext_cnt = count($ext_arr);      
	for( $i=0; $i<$ext_cnt; $i++) {      // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴      
		if( isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);      
		if( isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);      
	}      
	//define('_KAPP_', true);
	//define('KAPP_MYSQLI_USE', true);         // kapp_dblib_common 에서 사용.
	//define('KAPP_DISPLAY_SQL_ERROR', FALSE); // kapp_dblib_common 에서 사용.
	//echo "HTTP_HOST: " .$_SERVER['HTTP_HOST'] . ", HTTP: " . $_SERVER['HTTP']. ", SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . ", SCRIPT_FILENAME: " .$_SERVER['SCRIPT_FILENAME'] . ", SERVER_PROTOCOL: " . $_SERVER['SERVER_PROTOCOL'] . ", REQUEST_SCHEME: " .$_SERVER['REQUEST_SCHEME'];

	function index_url_path()       
	{       
		$result['path']	= str_replace('\\', '/', dirname(__FILE__));
		$tilde_rm		= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
		$doc_root		= str_replace( $tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);
		$pattern			= '/' . preg_quote($doc_root, '/') . '/i';       
		$root				= preg_replace($pattern, '', $result['path']);
		$result['root']	= preg_replace($pattern, '', $result['path']);  
		$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];       
		//$http = 'http' . ($_SERVER['HTTPS']=='on' ? 's' : '') . '://'; 
		//$http = 'http' . (( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || $_SERVER['HTTPS']=='on') ? 's' : '') . '://'; 
		//HTTP_X_FORWARDED_PROTO이 기능은 PHP 7.4.0부터 더 이상 사용되지 않으며 PHP 8.0.0부터 제거되었습니다. 이 기능에 의존하는 것은 매우 권장되지 않습니다.
		//echo $PHP . ", http: " . $http . ", SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'];
		$http = $_SERVER['REQUEST_SCHEME'] . "://";
		$user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);       
		$host				= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];   
		if( isset( $_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))  $host =preg_replace('/:[0-9]+$/', '', $host);       
		$host	= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);       
		$result_path = $result['path'];  
		$url_words = explode( '/', $_SERVER['SCRIPT_FILENAME'] );

		if( count($url_words) > 8  || count($url_words) < 6 ){
			//web root dir +'/' + $url_words[4] + $url_words[5] + $url_words[6] dir setup 
			m_("Please create a directory in the root directory, upload K-APP Files, and do setup again! ");
			echo "Please create a directory in the root directory, upload K-APP Files, and do setup again! <br>";
			echo "Example: Create directory in html or public_html directory and upload files.<br>";
			//echo "web server root directory 에 directory 를 생성하여 K-APP Files을 upload 하고 다시 setup 을 해주세요!<br>";
			//echo "예: html  or public_html dircectory 에 directory 를 생성하고 Files 을 upload<br>";
			exit;
		}

		if( count($url_words) == 8 ){ // web root dir +'/' + $url_words[4] + $url_words[5] dir setup 

			$tkher_u = $http . $host . "/" . $url_words[4] . "/" . $url_words[5]; // https://ailinkapp.com/tes/t
			$tkher_p = "/" . $url_words[1] . "/" . $url_words[2] . "/" . $url_words[3] . "/" . $url_words[4] . "/" . $url_words[5];
			$tkher_iurl	= $http. $host. $port . "/". $url_words[4] . "/". $url_words[5];
			$tkher_ipath= "/" . $url_words[1] . "/" . $url_words[2] . "/" . $url_words[3] . "/" . $url_words[4] . "/" . $url_words[5];

			//m_("cnt:8 tkher_iurl: ".$tkher_iurl);   //cnt:8 tkher_iurl: https://modumodu.net/biogplus/kapp
			//m_("cnt:8 tkher_ipath: ".$tkher_ipath); //cnt:8 tkher_ipath: /var/www/html/biogplus/kapp

			define('KAPP_URL_T_',		$tkher_iurl );
			define('KAPP_PATH_T_',		$tkher_ipath );       

		} else if( count($url_words) == 7 ){ // web root dir +'/' + $url_words[4] dir setup 
			$tkher_u = $http . $host . "/" . $url_words[4]; //m_("cnt:7 tkher_u: " . $tkher_u); // https://ailinkapp.com/t
			$tkher_p = "/" . $url_words[1] . "/" . $url_words[2] . "/" . $url_words[3] . "/" . $url_words[4];
			$tkher_iurl	= $http. $host. $port. "/". $url_words[4];
			$tkher_ipath= "/" . $url_words[1] . "/" . $url_words[2] . "/" . $url_words[3] . "/" . $url_words[4];
			define('KAPP_URL_T_',		$tkher_iurl );
			define('KAPP_PATH_T_',		$tkher_ipath );       
		} else if( count($url_words) == 6 ){ // web server root dir에 setup 을 한다.

			$tkher_u = $http . $host; 		//m_("cnt:6 tkher_u: " . $tkher_u); //
			$tkher_p = "/" . $url_words[1] . "/" . $url_words[2] . "/" . $url_words[3];
			$tkher_iurl	= $http. $host. $port;
			$tkher_ipath= "/" . $url_words[1] . "/" . $url_words[2] . "/" . $url_words[3];
		
			define('KAPP_URL_T_',		$tkher_iurl );
			define('KAPP_PATH_T_',		$tkher_ipath );       
		}

		define('KAPP_URL',	        $tkher_u ); // https://ailinkapp.com/t
		define('KAPP_PATH',		$tkher_p ); // /var/www/html/t
		define('KAPP_URL_',	        $tkher_u ); // https://ailinkapp.com/t
		define('KAPP_PATH_',		$tkher_p ); // /var/www/html/t
		return $result; //return $root;       
	}       
	//echo "KAPP_URL_: " . KAPP_URL_ . ", KAPP_PATH_: " . KAPP_PATH_;
	//m_("KAPP_URL_: " .KAPP_URL_ . ", KAPP_PATH_: " . KAPP_PATH_. ", KAPP_URL_T_: " . KAPP_URL_T_. ", KAPP_PATH_T_: " . KAPP_PATH_T_);
	//KAPP_URL_: https://moado.net/kapp, KAPP_PATH_: /home1/ledsignart/public_html/kapp, KAPP_URL_T_: https://moado.net/kapp, KAPP_PATH_T_: /home1/ledsignart/public_html/kapp

if (!defined('KAPP_SET_TIME_LIMIT')) define('KAPP_SET_TIME_LIMIT', 0);      
@set_time_limit(KAPP_SET_TIME_LIMIT);      
//==============================================================================
// SQL Injection 등으로 부터 보호를 위해 sql_escape_string() 적용
//------------------------------------------------------------------------------
// magic_quotes_gpc 에 의한 backslashes 제거
/*
if( get_magic_quotes_gpc()) {
    $_POST		= array_map_deep('stripslashes',  $_POST);
    $_GET		= array_map_deep('stripslashes',  $_GET);
    $_COOKIE	= array_map_deep('stripslashes',  $_COOKIE);
    $_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
} */

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

@session_start();
//==============================================================================

?>      
