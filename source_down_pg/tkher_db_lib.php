<?php      
/*
   ==========================================================================================      
   tkher_db_lib.php : Use in Source Create
   - tkher_config_link.php : include
   lib : sql_connect($host, $user, $pass, $db=KAPP_MYSQL_DB)      
         sql_select_db($db, $connect)
   ------------------------------------------------------------------------------------------ 
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
//	$tkher_config_file = KAPP_PATH_T_ . "/tkher_config_link.php";       

	$tkher_config_file = "./tkher_config_link.php";       
	//include_once( $tkher_config_file );   // 설정 파일      
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
define('KAPP_VERSION__', 'KAPP_V1');      
define('_KAPP_', true);
define('KAPP_MYSQLI_USE', true);
define('KAPP_DISPLAY_SQL_ERROR', FALSE);

	function index_url_path() {
		global $tkher_iurl;
		$result['path']	= str_replace('\\', '/', dirname(__FILE__));       
		$tilde_rm		= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);       
		$doc_root		= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);       
		$pattern			= '/' . preg_quote($doc_root, '/') . '/i';       
		$root				= preg_replace($pattern, '', $result['path']);  
		$result['root']	= preg_replace($pattern, '', $result['path']);  
		
		$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];       
        //$http = 'http' . (( $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || $_SERVER['HTTPS']=='on') ? 's' : '') . '://';		
		if( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') $http = "https://";
		else if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ) $http = "https://";
		else if( isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') $http = "https://";
		else  $http = "http://";

		$user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);       
		$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];       
		if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))       
			$host	= preg_replace('/:[0-9]+$/', '', $host);       
		$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);       
		$words = explode( '/', $_SERVER['SCRIPT_FILENAME'] );
		$tkher_iurl	= $http.$host.$port.$user.$root;       
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
    //$sql = preg_replace("#^select.*from.*union.*#i", "select 1", $sql);
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


// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null)
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

// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
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

//ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
//ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
//ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
//ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

//session_set_cookie_params(0, '/');
//ini_set("session.cookie_domain", KAPP_COOKIE_DOMAIN);

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
//--------
function relation_func( $rdata, $pg_code, $rtype ){
	global $H_ID;
	$r_data = explode("$", $rdata);
	$r_tab = $r_data[0];
	$tab_r = explode(":", $r_tab);
	$r_table = $tab_r[0];               // $tab_r[0]:tab_enm, [1]:tab_hnm, [2]:table item_array

	$r_t = explode(":", $rtype); //Update:fld_1:fld_1:CHAR           // Update:::@@^^^

	if( isset($r_t[0]) ) $r_type = $r_t[0];					// $r_t[0] = 'Update' or 'Insert'
	else $r_type = "";	
	if( isset($r_t[1]) ) $up_key = $r_t[1];					// $r_t[1] program field ,  Update Key field 
	else $up_key = "";
	if( isset($r_t[2]) ) $dd_key = $r_t[2];					// $r_t[2] relation table,  Update Key field 
	else $dd_key = "";
	if( isset($r_t[3]) ) $ty_key = $r_t[3];					// $r_t[3] relation field key data type CHAR or INT
	$ty_key = "";

	if( isset($_POST[$up_key]) && $_POST[$up_key] !='' ) $update_key_data = $_POST[$up_key];
	else $update_key_data = "";

	$SQLA = "select seqno from `" . $r_table . "` ";
	if( $ty_key == "CHAR" ) $SQLA = $SQLA . " where " . $dd_key . " = '" .$update_key_data. "' ";	
	else if( $ty_key == "INT" ) $SQLA = $SQLA . " where " . $dd_key . " = " .$update_key_data. " ";	
	else $SQLA = $SQLA . " where " . $dd_key . " = '" .$update_key_data. "' ";	// default 문자열로 처리.
	$retA = sql_fetch( $SQLA );

	if( $r_type == 'Update'){
		$SQLR = "UPDATE " . $r_table . " SET ";
		for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
			$r_fld		= $r_data[$i];
			$fld_r		= explode("|", $r_fld);		// fld_1:name|=|fld_1:name
			$fld_r1	= $fld_r[0];
			$fld_sik= $fld_r[1];  // =, -, +
			$fld_r2	= $fld_r[2];
			$fld1	= explode(":", $fld_r1);		// program table -> fld_1:name|=|fld_1:name
			$f_enm	= $fld1[0];
			$fld2	= explode(":", $fld_r2);		// rellation table -> fld_1:name|=|fld_1:name
			$r_enm	= $fld2[0];
			if( isset($_POST[$f_enm]) )  $post_enm = $_POST[$f_enm];
			else $post_enm = "";
			if( $fld_sik == '=' ) {
				if( $i==1 )	$SQLR = $SQLR . $r_enm . " = '" . $post_enm . "'  ";
				else		$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
			} else if( $fld_sik == '+' ) {
				if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
				else		$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
			} else if( $fld_sik == '-' ) {
				if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
				else		$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
			}
		}
		if( $ty_key == "CHAR" ) $SQLR = $SQLR . " where " . $dd_key . " = '" .$update_key_data. "' ";	
		else if( $ty_key == "INT" ) $SQLR = $SQLR . " where " . $dd_key . " = " .$update_key_data. " ";	
		else $SQLR = $SQLR . " where " . $dd_key . " = '" .$update_key_data. "' ";

		if( $retA ) {
			$ret  = sql_query($SQLR);
			if( $ret ) { //echo("<script>alert('Relation Save pg70_write_r: relation-Table is $r_table Created.  ');</script>");
				//m_("r_table: $r_table Update");
			}else{
				echo "relation table error - SQLR: " . $SQLR; exit;
			}
		} else {
			$SQLAR = "INSERT INTO " . $r_table . " SET ";
			$SQLAR = $SQLAR . "kapp_userid= '" . $H_ID . "' , ";
			$SQLAR = $SQLAR . "kapp_pg_code= '" . $pg_code . "' , ";
			for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
				$r_fld		= $r_data[$i];
				$fld_r		= explode("|", $r_fld);		// fld_1:상품|=|fld_1:상품
				$fld_r1	= $fld_r[0];
				$fld_sik	= $fld_r[1];
				$fld_r2	= $fld_r[2];
				$fld1		= explode(":", $fld_r1);		// fld_1:상품|=|fld_1:상품
				$f_enm	= $fld1[0];
				$fld2		= explode(":", $fld_r2);		// fld_1:상품|=|fld_1:상품
				$r_enm	= $fld2[0];

				if( isset($f_enm) && isset($_POST[$f_enm]) )  $post_enm = $_POST[$f_enm];
				else $post_enm = "";
				if( $fld_sik == '=' ) {
					if( $i==1 )	$SQLAR = $SQLAR . $r_enm . " = '" . $post_enm . "'  ";
					else		$SQLAR = $SQLAR . " , "  . $r_enm . " = '" . $post_enm . "' ";
				} else if( $fld_sik == '+' ) {
					if( $i==1 )	$SQLAR = $SQLAR . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
					else		$SQLAR = $SQLAR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
				} else if( $fld_sik == '-' ) {
					if( $i==1 )	$SQLAR = $SQLAR . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
					else		$SQLAR = $SQLAR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
				}
			}
			$SQLAR = $SQLAR . " "; 
			$ret =sql_query($SQLAR);
			if( $ret ) { 
				//m_("--- r_table: $r_table Insert");
			}else{
				echo "relation table error - SQLAR: " . $SQLAR; exit;
				//printf('Relation data insert ERROR sqlr:%s', $SQLR); 
			}
		}
	} else { // insert - relation
		$SQLR = "INSERT INTO " . $r_table . " SET ";
		$SQLR = $SQLR . "kapp_userid= '" . $H_ID . "' , ";
		$SQLR = $SQLR . "kapp_pg_code= '" . $pg_code . "' , ";
		for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
			$r_fld		= $r_data[$i];
			$fld_r		= explode("|", $r_fld);		// fld_1:상품|=|fld_1:상품
			$fld_r1	= $fld_r[0];
			$fld_sik	= $fld_r[1];
			$fld_r2	= $fld_r[2];
			$fld1		= explode(":", $fld_r1);		// fld_1:상품|=|fld_1:상품
			$f_enm	= $fld1[0];
			$fld2		= explode(":", $fld_r2);		// fld_1:상품|=|fld_1:상품
			$r_enm	= $fld2[0];
			if( isset($f_enm) && isset($_POST[$f_enm]) )  $post_enm = $_POST[$f_enm];
			else $post_enm = "";
			if( $fld_sik == '=' ) {
				if( $i==1 )	$SQLR = $SQLR . $r_enm . " = '" . $post_enm . "'  ";
				else			$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
			} else if( $fld_sik == '+' ) {
				if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
				else			$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
			} else if( $fld_sik == '-' ) {
				if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
				else			$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
			}
		}
		$SQLR = $SQLR . " ";
		$ret =sql_query($SQLR);
		if( $ret ) { 
			//m_("r_table: $r_table Insert");
		}else{
			echo "relation table error - r_type: " . $r_type. ", i SQLR: " . $SQLR; exit;
			//printf('Relation data insert ERROR sqlr:%s', $SQLR); 
		}
	}// if
}

?>      
