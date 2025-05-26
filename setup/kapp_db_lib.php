<?php      
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

	//include_once( KAPP_PATH_T_ . "/data/kapp_dbcon.php");   // 설정 파일      

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

	/*function index_url_path()       
	{       
		global $tkher_iurl;
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
		define('KAPP_URL_',				$tkher_u );       
		define('KAPP_PATH_',			$tkher_p );       
		define('KAPP_URL_T_',			$tkher_iurl );       
		define('KAPP_PATH_T_',		$tkher_ipath );       
		define('KAPP_LOGO_URL_',	$tkher_u . '/logo' );       
		return $result;       
	} */      
	function index_url_path()
	{
		global $tkher_iurl;
		$result['path']	= str_replace('\\', '/', dirname(__FILE__));
		$tilde_rm		= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
		$doc_root		= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);
		$pattern = '/' . preg_quote($doc_root, '/') . '/i';
		$root    = preg_replace($pattern, '', $result['path']);
		//m_("result_path: " . $result['path'] . ", doc_root: " . $doc_root . ", pattern: " . $pattern . ", root: " . $root);
		//result_path: /var/www/html/t, doc_root: /var/www/html, pattern: //var/www/html/i, root: /t
		//result_path: /var/www/html/t, doc_root: /var/www/html, pattern: //var/www/html/i, root: /t
		//result_path: /var/www/html/t, doc_root: /var/www/html, pattern: //var/www/html/i, root: /t

		$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
		//m_("_SERVER[HTTPS] : " . $_SERVER['HTTPS']); // _SERVER[HTTPS] :
		//m_("_SERVER[HTTP_X_FORWARDED_PROTO] : " . $_SERVER['HTTP_X_FORWARDED_PROTO'] ); // _SERVER[HTTP_X_FORWARDED_PROTO] : https
		//$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
		//$http = 'http' . (($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 's' : '') . '://';           //tkher_iurl: https://ailinkapp.com/t
		$http = 'http' . (( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || $_SERVER['HTTPS']=='on') ? 's' : '') . '://';

		$user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
		$host = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		if( isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
			$host	= preg_replace('/:[0-9]+$/', '', $host);
		$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
		$words = explode( '/', $_SERVER['SCRIPT_FILENAME'] );
		$tkher_iurl		= $http.$host.$port.$user.$root;
		$tkher_ipath	= $result['path'];  // tkher_ipath: /home/onlyshop/public_html/t
		$tkher_u = $http . $host;
		$tkher_p = "/" . $words[1] . "/" . $words[2] . "/" . $words[3];

		define('KAPP_DIR_',		$root );       // root:        /t
		define('KAPP_URL_',		$tkher_u );    // tkher_u:     https://ailinkapp.com
		define('KAPP_PATH_',		$tkher_p );    // tkher_p:     /home/onlyshop/public_html
		define('KAPP_URL_T_',		$tkher_iurl ); // tkher_iurl:  https://ailinkapp.com/t
		define('KAPP_PATH_T_',		$tkher_ipath );// tkher_ipath: /home/onlyshop/public_html/t
		define('KAPP_LOGO_URL_',	$tkher_u . '/logo' );
		define('KAPP_HOST_',		$host );// tkher_ipath: /home/onlyshop/public_html/t
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
	// magic_quotes_gpc 에 의한 backslashes 제거
	if( get_magic_quotes_gpc()) {
		$_POST		= array_map_deep('stripslashes',  $_POST);
		$_GET		= array_map_deep('stripslashes',  $_GET);
		$_COOKIE	= array_map_deep('stripslashes',  $_COOKIE);
		$_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
	}

	@extract($_GET);      
	@extract($_POST);      
	@extract($_SERVER);      

	// DB 연결      
	function sql_connect($host, $user, $pass, $db=KAPP_MYSQL_DB)      
	{      
		global $tkher;      
		if(function_exists('mysqli_connect') && KAPP_MYSQLI_USE) {      
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
		if(function_exists('mysqli_select_db') && KAPP_MYSQLI_USE)      
			return @mysqli_select_db($connect, $db);      
		else      
			return @mysql_select_db($db, $connect);      
	}      
	function sql_set_charset($charset, $link=null)      
	{      
		global $tkher;      
		if(!$link) $link = $tkher['connect_db'];      
		if(function_exists('mysqli_set_charset') && KAPP_MYSQLI_USE)      
			mysqli_set_charset($link, $charset);      
		else      
			mysql_query(" set names { $charset } ", $link);      
	}      
function sql_query($sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if(function_exists('mysqli_query') && KAPP_MYSQLI_USE) {
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

function sql_fetch($sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null)
{
    global $tkher;

    if(!$link)
        $link = $tkher['connect_db'];

    $result = sql_query($sql, $error, $link);
    $row = sql_fetch_array($result);
    return $row;
}

function sql_fetch_array($result)
{
    if(function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}

function sql_num_rows($result)
{
    if(function_exists('mysqli_num_rows') && KAPP_MYSQLI_USE)
        return mysqli_num_rows($result);
    else
        return mysql_num_rows($result);
}

function sql_free_result($result)
{
    if(function_exists('mysqli_free_result') && KAPP_MYSQLI_USE)
        return mysqli_free_result($result);
    else
        return mysql_free_result($result);
}
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
	}else { 
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo("<span>[Next].</span>");
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
	}
	echo "</div>";
}

?>      
