<?php      
	/*
		kapp_start_dblib.php <- tkher_db_lib.php
	*/
	$lifetime=600;
	session_set_cookie_params($lifetime);
	session_start();
	error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );      
	header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');      
	$config		= array();      
	$tkher		= array();      
	$member		= array();

    $tkher_iurl = '';
	$tkher_path = index_url_path();      

	include "tkher_config_link.php";   // 설정 파일      

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
	//define('TKHER_VERSION__', 'TKHER_V1');      
	//define('_KAPP_', true);
	//define('TKHER_MYSQLI_USE', true);
	//define('TKHER_DISPLAY_SQL_ERROR', FALSE);

	function index_url_path()       
	{       
		global $tkher_iurl;
		$result['path']	= str_replace('\\', '/', dirname(__FILE__));       
		$tilde_rm		= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);       
		$doc_root		= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);       
		$pattern			= '/' . preg_quote($doc_root, '/') . '/i';       
		$root				= preg_replace($pattern, '', $result['path']);  
		$result['root']	= preg_replace($pattern, '', $result['path']);  
		
		$port				= ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];       
		$http = 'http' . (( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
		$user				= str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);       
		$host				= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];       
		if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))       
			$host	= preg_replace('/:[0-9]+$/', '', $host);       
		$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);       
		$tkher_iurl	= $http.$host.$port.$user.$root;       
		$tkher_ipath	= $result['path'];       
		$tkher_u		= substr($tkher_iurl, 0, -2);		//0부터 뒤의 -1까지. , 마지막부분 '/' 없이 전달한다. 예:https://tkher.com       
		$tkher_p		= substr($tkher_ipath, 0, -2);       
		define('TKHER_URL_',				$tkher_u );       
		define('TKHER_PATH_',			$tkher_p );       
		define('TKHER_URL_T_',			$tkher_iurl );       
		define('TKHER_PATH_T_',		$tkher_ipath );       
		define('TKHER_LOGO_URL_',	$tkher_u . '/logo' );       
		return $result;       
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
		$dbconfig_file = TKHER_PATH_T_ . "./tkher_dbcon.php";        
	if ( file_exists($dbconfig_file) ) {       
		$a = TKHER_LIB_PATH;       
		include_once($dbconfig_file);       
		include_once( $_fileLIB );    // 공통 라이브러리       
		$connect_db = sql_connect(TKHER_MYSQL_HOST, TKHER_MYSQL_USER, TKHER_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');       
		$select_db  = sql_select_db(TKHER_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');       
		$tkher['connect_db'] = $connect_db;       
		sql_set_charset('utf8', $connect_db);       
		if(defined('TKHER_MYSQL_SET_MODE') && TKHER_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = '' ");       
		if (defined(TKHER_TIMEZONE)) sql_query(" set time_zone = '".TKHER_TIMEZONE."'");       
	} else {       
		   m_(" dbconfig_file:/var/www/html/t/data/tkher_dbconfig.php no found.  ");      
			echo "<script language='javascript'>window.open('/t/tkher_dbcon_create.php?mid=dao','','');</script>";       
	} */      


	// DB 연결      
	function sql_connect($host, $user, $pass, $db=TKHER_MYSQL_DB)      
	{      
		global $tkher;      
		if(function_exists('mysqli_connect') && TKHER_MYSQLI_USE) {      
			$link = mysqli_connect($host, $user, $pass, $db);      
			// 연결 오류 발생 시 스크립트 종료      
			if (mysqli_connect_errno()) {      
				$link = "dberror";
				return $link;
				die('Connect Error: '.mysqli_connect_error());      
			}      
		} else {      
			$link = mysql_connect($host, $user, $pass);      
		}      
		return $link;      
	}      
	// DB 선택      
	function sql_select_db($db, $connect)      
	{      
		global $tkher;      
		if(function_exists('mysqli_select_db') && TKHER_MYSQLI_USE)      
			return @mysqli_select_db($connect, $db);      
		else      
			return @mysql_select_db($db, $connect);      
	}      
	function sql_set_charset($charset, $link=null)      
	{      
		global $tkher;      
		if(!$link) $link = $tkher['connect_db'];      
		if(function_exists('mysqli_set_charset') && TKHER_MYSQLI_USE)      
			mysqli_set_charset($link, $charset);      
		else      
			mysql_query(" set names { $charset } ", $link);      
	}      
function sql_query($sql, $error=TKHER_DISPLAY_SQL_ERROR, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && TKHER_MYSQLI_USE) {
        if ($error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if ($error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }

    return $result;
}


// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=TKHER_DISPLAY_SQL_ERROR, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    $result = sql_query($sql, $error, $link);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
    $row = sql_fetch_array($result);
    return $row;
}


// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result)
{
    if(function_exists('mysqli_fetch_assoc') && TKHER_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}

function sql_num_rows($result)
{
    if(function_exists('mysqli_num_rows') && TKHER_MYSQLI_USE)
        return mysqli_num_rows($result);
    else
        return mysql_num_rows($result);
}

// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
function sql_free_result($result)
{
    if(function_exists('mysqli_free_result') && TKHER_MYSQLI_USE)
        return mysqli_free_result($result);
    else
        return mysql_free_result($result);
}
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
// 2023-07-06 : table_paging.php에 있는 페이지 함수를 여기에 설정함.
// 그리고 table_paging.php를 사용하지않아도 됨.....중요.. tkher_php_programDN.php 부분도 수정함.
function pagingA($link, $total, $page, $size){ // paging() pagingA()로 적용함.
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);
	/*
	$temp		= $page%$size;
	if($temp=="0"){
		$a=$size-1;
		$b=$temp;
	}else{
		$a=$temp-1;
		$b=$size-$temp;
	}
	$start	= $page-$a;
	$end		= 10;//$page+$b;
	*/
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;

	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>[First]</a><span>.</span>");
	} else {
		echo("<span>[Start].</span>");
		//echo("<img src=./include/img/btn/b_first_silver.gif border=0 height=30 title='First'>");
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		//echo("<a href='javascript:page_move($back_page)' ><img src=./include/img/btn/btn_prev.png width=30 title='previous'></a>");
		echo("<a href='javascript:page_move($back_page)' >[Prev]</a><span>.</span>");
	} else {
		//echo("<img src=./include/img/btn/btn_prev.png width=30 title='Previous'>");
		//echo("<span>[Prev].</span>");
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("<a href='javascript:void(0)' class=on>$i</a><span>.</span>"); }
		else         { echo("<a href='javascript:page_move($i)'>$i</a><span>.</span>"); }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'>[Next]</a><span>.</span>");
		//echo("<a href='javascript:page_move($next_page)'><img src=./include/img/btn/btn_next.png width=30 title='B Next Page'></a>");
	}else { 
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo("<span>[Next].</span>");
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
		//echo("<img src=./include/img/btn/b_last_silver.gif border=0 height=30 title='Last'>");
	}
	echo "</div>";
}

?>      
