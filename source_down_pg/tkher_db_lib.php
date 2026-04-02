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
include "tkher_config_link.php";   // 설정 파일      
//==========================================================================================      
// extract($_GET);명령으로 page.php?_POST[var1]=data1&_POST[var2]=data2와 같은 코드가_POST변수로사용되는 것을 막음      
//------------------------------------------------------------------------------------------ 
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',      
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',      
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');      
$ext_cnt = count($ext_arr);      
for( $i=0; $i<$ext_cnt; $i++) {      // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴      
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
@extract($_GET);      
@extract($_POST);      
@extract($_SERVER);      

function sql_connect($host, $user, $pass, $db=KAPP_MYSQL_DB){      
	global $tkher;
	if(function_exists('mysqli_connect') && KAPP_MYSQLI_USE) {      
		$link = mysqli_connect( $host, $user, $pass, $db);      
		if( mysqli_connect_errno()) {      
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
function sql_select_db($db, $connect){
	global $tkher;      
	if(function_exists('mysqli_select_db') && KAPP_MYSQLI_USE)      
		return @mysqli_select_db($connect, $db);      
	else      
		return @mysql_select_db($db, $connect);      
}      
function sql_set_charset($charset, $link=null){
	global $tkher;      
	if(!$link) $link = $tkher['connect_db'];      
	if(function_exists('mysqli_set_charset') && KAPP_MYSQLI_USE)      
		mysqli_set_charset($link, $charset);      
	else      
		mysql_query(" set names { $charset } ", $link);      
}      
function sql_query($sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null){
    global $tkher;
    if(!$link) $link = $tkher['connect_db'];
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

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null){
    global $tkher;
    if(!$link)  $link = $tkher['connect_db'];
    $result = sql_query($sql, $error, $link);
    $row = sql_fetch_array($result);
    return $row;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result){
    if(function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}
function sql_num_rows($result){
    if(function_exists('mysqli_num_rows') && KAPP_MYSQLI_USE)
        return mysqli_num_rows($result);
    else
        return mysql_num_rows($result);
}
function sql_free_result($result){
    if(function_exists('mysqli_free_result') && KAPP_MYSQLI_USE)
        return mysqli_free_result($result);
    else
        return mysql_free_result($result);
}
//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags","");        // 링크에 PHPSESSID가 따라다니는것을 무력화함.
if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

@session_start();
function pagingA($link, $total, $page, $size){ // paging() pagingA()로 적용함.
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);
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
	/* -------------------------------------------------------------------------
	main table record - delete : relationship main table record delete processor 
	relation type : 'Insert'
	relation table record delete - relation type: 'Insert'
	---------------------------------------------------------------------------*/
	function relation_record_delete( $rdata, $pg_code, $rtype ){
		$ip = $_SERVER['REMOTE_ADDR'];
		$day = date("Y-m-d H-i-s", time());
		global $H_ID;
		$r_data = explode("$", $rdata); 
		$r_tab = $r_data[0]; // table + data of table, $r_data[1] = relation data
		$tab_r = explode(":", $r_tab);
		$r_table = $tab_r[0];               // $tab_r[0]:tab_enm, [1]:tab_hnm, [2]:table item_array
		$Rtabhnm = $tab_r[1];
		$dataT   = $tab_r[2]; // main table column
		$r_tA = explode("|", $rtype);     //@Update:fld_1:날짜:DATE|:fld_5:product:VARCHAR|
		$key_count = count($r_tA);
		$r_t = explode(":", $r_tA[0]); 
		$r_type = $r_t[0];
		$SQLA = "DELETE FROM " . $r_table;
		$WR = '';
		$sw='';
		for( $i=0; $i<$key_count && $r_tA[$i]!=''; $i++){
			$r_t = explode(":", $r_tA[$i]); //@Update:fld_1:날짜:DATE|:fld_5:product:VARCHAR|
			$key_fld  = $r_t[1];
			$key_type = $r_t[3];
			$f_num = data_number_check( $key_type );
			for( $j=1; isset($r_data[$j]) && $r_data[$j] !=""; $j++) {
				$r_fld		= $r_data[$j];              // $fld_1:fld1|=|fld_1:상품:VARCHAR
				$fld_r		= explode("|", $r_fld);		// fld_1:name|=|fld_1:name
				$fld_r1	= $fld_r[0];
				$fld_sik= $fld_r[1];  // =, -, +
				$fld_r2	= $fld_r[2];
				$fld1	= explode(":", $fld_r1);		// program table -> fld_1:name|=|fld_1:name
				$f_enm	= $fld1[0];
				$fld2	= explode(":", $fld_r2);		// rellation table -> fld_1:name|=|fld_1:name
				$r_enm	= $fld2[0];
				$r_tp	= $fld2[2];
				$r_len	= $fld2[3];
				if( $key_fld == $r_enm ){
					if( isset( $_POST[$f_enm]) && $_POST[$f_enm] !='' ) $post_enm = $_POST[$f_enm];
					else $post_enm = "";
					$f_num = data_number_check( $r_tp );
					if( $i == 0 ) {
						if( $f_num ) $WR = " where " . $key_fld . " = " .$post_enm. " ";	
						else {
							//$WR = " where " . $key_fld . " = '" .$post_enm. "' ";
							if( $r_tp =='DATE' || $r_tp =='MONTH') {
								$post_enm =substr( $post_enm, 0, $r_len);
								$WR = " where " . $key_fld . " = '" .$post_enm. "' ";
							} else $WR = " where " . $key_fld . " = '" .$post_enm. "' ";
						}
					} else if( $i > 0 ){
						if( $f_num ) $WR = $WR . " and " . $key_fld . " = " .$post_enm. " ";	
						else {
							//$WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";
							if( $r_tp =='DATE' || $r_tp =='MONTH') { // MONTH len=7, DATE len=10
								$post_enm =substr( $post_enm, 0, $r_len);
								$WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";
							} else $WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";
						}
					}
				}
			}
		}
		$SQLA = $SQLA . $WR;	//	echo "SQLA: " . $SQLA; exit;
		$retA = sql_query( $SQLA );
		if( $retA ) {
			m_("relation table: $Rtabhnm, record Delete OK");
		} else{
			echo "DELETE ERROR, relation table: $r_table, Delete error - SQLR: " . $SQLR; exit;
		}
	}
	function relation_record_update( $rdata, $pg_code, $rtype ){
		/*
		main table record - delete : relationship main table record delete processor 
		relation type : 'Insert'
		relation table update - number colomn '-' , '+'
		*/
		$ip = $_SERVER['REMOTE_ADDR'];
		$day = date("Y-m-d H-i-s", time());
		global $H_ID;
		/*
		rdata: dao_1766735120:ABCYY:|fld_1|날짜|DATE|15
		@|fld_2|yyyy|CHAR|15
		@|fld_3|mm|CHAR|15@|fld_4|dd|CHAR|15@|fld_5|product|VARCHAR|15@|fld_6|total_count|INT|12@|fld_7|tottal_price|BIGINT|15@
		$fld_1:fld1|=|fld_1:상품:VARCHAR:15
		$fld_2:fld2|=|fld_2:원산지:VARCHAR:15
		rtA: Update:fld_1:날짜:DATE|:fld_5:product:VARCHAR|
		*/
		$r_data = explode("$", $rdata); 
		$r_tab = $r_data[0];                // table + data of table, $r_data[1] = relation data
		$tab_r = explode(":", $r_tab);
		$r_table = $tab_r[0];               // $tab_r[0]:tab_enm, [1]:tab_hnm, [2]:table item_array
		$Rtabhnm = $tab_r[1];
		$dataT   = $tab_r[2];               // main table column

		$r_tA = explode("|", $rtype);       // $rtype=@Update:fld_1:날짜:DATE:10|:fld_5:product:VARCHAR:15|
		$key_count = count($r_tA);
		$r_t = explode(":", $r_tA[0]);      // $r_tA[0]=Update:fld_1:날짜:DATE:10
		$r_type = $r_t[0];                  // $r_t[0]=Update
		
		$SQLA = "select seqno, kapp_memo from `" . $r_table . "` ";
		$WR = '';
		$sw='';
		for( $i=0; $i<$key_count && $r_tA[$i]!=''; $i++){
			$r_t = explode(":", $r_tA[$i]);
			$key_fld  = $r_t[1];
			$key_type = $r_t[3];
			for( $j=1; isset($r_data[$j]) && $r_data[$j] !=""; $j++) {
				$r_fld		= $r_data[$j];              // $fld_1:fld1|=|fld_1:상품:VARCHAR:15
				$fld_r		= explode("|", $r_fld);		// fld_1:name|=|fld_1:name
				$fld_r1	= $fld_r[0];
				$fld_sik= $fld_r[1];  // =, -, +
				$fld_r2	= $fld_r[2];
				
				$fld1	= explode(":", $fld_r1);		// program table -> fld_1:name|=|fld_1:name
				$f_enm	= $fld1[0];
				
				$fld2	= explode(":", $fld_r2);		// rellation table -> fld_1:name|=|fld_1:name
				$r_enm	= $fld2[0];
				$r_tp	= $fld2[2];
				$r_len	= $fld2[3];

				if( $key_fld == $r_enm ){
					if( isset($_POST[$f_enm]) && $_POST[$f_enm] !='' ) $post_enm = $_POST[$f_enm];
					else {
						m_("ERROR-delete-update, r_table:$r_table, key data - key_fld: $key_fld, r_enm: $r_enm, f_enm: $f_enm");
						echo "where WR: " . $WR . ", " . "ERROR r_table:$r_table, key data - key_fld: $key_fld, r_enm: $r_enm, f_enm: $f_enm"; exit;
					}
					$f_num = data_number_check( $r_tp ); // $key_type
					if( $sw == '' ) {
						/*if( $f_num ) $WR = " where " . $key_fld . " = " .$post_enm. " ";	
						else $WR = " where " . $key_fld . " = '" .$post_enm. "' ";
						$sw ='on';*/
						if( $f_num ) $WR = " where " . $key_fld . " = " .$post_enm. " ";	
						else {
							if( $r_tp =='DATE' || $r_tp =='MONTH') {
								$post_enm =substr( $post_enm, 0, $r_len);
								$WR = " where " . $key_fld . " = '" .$post_enm. "' ";
							} else $WR = " where " . $key_fld . " = '" .$post_enm. "' ";
						}
						$sw ='on';
					} else if( $sw == 'on' ){
						/*if( $f_num ) $WR = $WR . " and " . $key_fld . " = " .$post_enm. " ";	
						else $WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";*/
						if( $f_num ) $WR = $WR . " and " . $key_fld . " = " .$post_enm. " ";	
						else {
							if( $r_tp =='DATE' || $r_tp =='MONTH') {
								$post_enm =substr( $post_enm, 0, $r_len);
								$WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";
							} else $WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";
						}
					}
					break;
				}
			}
		}
		$SQLA = $SQLA . $WR; //SQLA: select seqno, kapp_memo from `dao_1766735120` where fld_5 = '무우'
		$retA = sql_fetch( $SQLA );
		if( $retA ) {
			$kapp_memo = $retA['kapp_memo'] . "\n|DELETE-TYPE-UPDATE, ". $pg_code.":".$day.":".$H_ID. ":" . $ip;
			$SQLR = "UPDATE " . $r_table . " SET ";
			$SQLR = $SQLR . " kapp_memo = '" . $kapp_memo . "' ";
			for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
				$r_fld		= $r_data[$i];
				$fld_r		= explode("|", $r_fld);		// fld_1:name|=|fld_1:name
				$fld_r1	= $fld_r[0];
				$fld_sik= $fld_r[1];                    // =, -, +
				$fld_r2	= $fld_r[2];
				$fld1	= explode(":", $fld_r1);		// program table -> fld_1:name|=|fld_1:name
				$f_enm	= $fld1[0];
				$fld2	= explode(":", $fld_r2);		// rellation table -> fld_1:name|=|fld_1:name
				$r_enm	= $fld2[0];
				$r_tp	= $fld2[2];
				$r_len	= $fld2[3];
				
				if( isset($f_enm) && isset($_POST[$f_enm]) && $_POST[$f_enm]!='' )  $post_enm = $_POST[$f_enm];
				else $post_enm = "";
				if( $fld_sik == '=' ) {
					if( data_number_check( $r_tp ) ) $SQLR = $SQLR . " , "  . $r_enm . " = " . $post_enm . " ";
					else {
						//$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
						if( $r_tp =='DATE' || $r_tp =='MONTH') {
							if( $post_enm !='') $post_enm =substr( $post_enm, 0, $r_len); // MONTH len=7, DATE len=10
							$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
						} else $SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
					}
					/* When the main record is deleted, the record processing in the relation table changes '+' to '-'.
					,main record를 delete하면 relation table의 record 처리는 '+' 는 '-' 처리한다. */
				} else if( $fld_sik == '+' ) { 
					$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
				} else if( $fld_sik == '-' ) { // '-' 는 '+' 처리.
					$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
				}
			}//for
			$SQLR = $SQLR . $WR;	//	echo "SQLA: " . $SQLA; exit;
			$ret  = sql_query($SQLR);
			if( $ret ) {
				m_("relation table: $Rtabhnm, Update OK");
			}else{
				echo "ERROR, relation table: $Rtabhnm, Update error - SQLR: " . $SQLR; exit;
			}
		} else {
			m_("Relation table: $Rtabhnm, UPDATE ERROR - record no found");
			echo "Update record not found, SQLA: " . $SQLA; exit;
		}
	}

	function relation_func( $rdata, $pg_code, $rtype ){
		/*
		main table record - 'Write'
		relation type : 'Update'
		dao_1766822184:ABC_AAA:|fld_1|상품|VARCHAR|15@|fld_2|원산지|VARCHAR|15@|fld_3|단위|VARCHAR|15@|fld_4|수량|INT|12@|fld_5|단가|INT|12@|fld_6|금액|INT|12@|fld_7|날짜|DATE|15@
		$fld_1:fld1|=|fld_1:상품:VARCHAR:15
		$fld_2:fld2|=|fld_2:원산지:VARCHAR:15
		$fld_3:fld3|=|fld_3:단위:VARCHAR:15$fld_4:수량|=|fld_4:수량:INT:12$fld_5:단가|=|fld_5:단가:INT:12$fld_6:금액|=|fld_6:금액:INT:12$fld_7:날짜|=|fld_7:날짜:DATE:15^dao_1766735120:ABCYY:|fld_1|날짜|DATETIME|20@|fld_2|yyyy|CHAR|15@|fld_3|mm|CHAR|15@|fld_4|dd|CHAR|15@|fld_5|product|VARCHAR|15@|fld_6|total_count|INT|12@|fld_7|tottal_price|BIGINT|15@$fld_1:fld1|=|fld_5:product:VARCHAR:15$fld_7:날짜|=|fld_1:날짜:DATETIME:20$fld_4:수량|+|fld_6:total_count:INT:12$fld_6:금액|+|fld_7:tottal_price:BIGINT:15^dao_1773304478:ABC_년도별_판매실적:|fld_1|년도|YEAR|4@|fld_2|상품|VARCHAR|15@|fld_3|수량|INT|12@|fld_4|금액|INT|12@|fld_5|메모|TEXT|255@$fld_7:날짜|=|fld_1:년도:YEAR:4$fld_1:fld1|=|fld_2:상품:VARCHAR:15$fld_4:수량|+|fld_3:수량:INT:12$fld_6:금액|+|fld_4:금액:INT:12^^^^^^^		- relation type key -
		Update:fld_1:일자:DATE:10|:fld_2:상품:VARCHAR:15|@@^
		*/
		$ip = $_SERVER['REMOTE_ADDR'];
		$day = date("Y-m-d H-i-s", time());
		global $H_ID;
		$r_data = explode("$", $rdata); 
		$r_tab = $r_data[0];                // table + data of table, $r_data[1] = relation data
		$tab_r = explode(":", $r_tab);
		$r_table = $tab_r[0];               // $tab_r[0]:tab_enm, [1]:tab_hnm, [2]:table item_array
		$Rtabhnm = $tab_r[1];
		$dataT   = $tab_r[2];               // main table column
		$r_tA = explode("|", $rtype);       // Update:fld_1:일자:DATE:10|:fld_2:상품:VARCHAR:15|
		$key_count = count($r_tA);
		$r_t = explode(":", $r_tA[0]); 
		$r_type = $r_t[0];
		
		if( $r_type == 'Update'){
			$SQLA = "select seqno, kapp_memo from `" . $r_table . "` ";
			$WR = '';
			$sw='';
			for( $i=0; $i<$key_count && $r_tA[$i]!=''; $i++){
				$r_t = explode(":", $r_tA[$i]);             //Update:fld_1:일자:DATE:10|:fld_2:상품:VARCHAR:15|
				$key_fld  = $r_t[1];
				$key_type = $r_t[3];                        // data type
				$f_num = data_number_check( $key_type );
				for( $j=1; isset($r_data[$j]) && $r_data[$j] !=""; $j++) {
					$r_fld		= $r_data[$j];
					$fld_r		= explode("|", $r_fld);		// $fld_1:일자|=|fld_1:일자:DATE:10
					$fld_r1	= $fld_r[0];
					$fld_sik= $fld_r[1];                    // =, -, +
					$fld_r2	= $fld_r[2];                    // fld_1:일자:DATE:10
					
					$fld1	= explode(":", $fld_r1);        // program column -> fld_1:name|=|fld_1:name
					$f_enm	= $fld1[0];
					
					$fld2	= explode(":", $fld_r2);        //fld_1:일자:DATE:10
					$r_enm	= $fld2[0];
					$r_tp	= $fld2[2];                     // data type
					$r_len	= $fld2[3];                     // data length

					if( $key_fld == $r_enm ){
						if( isset( $_POST[$f_enm]) && $_POST[$f_enm] !='' ) $post_enm = $_POST[$f_enm];
						else $post_enm = "";
						$f_num = data_number_check( $r_tp );
						if( $sw =='' ) {
							if( $f_num ) $WR = " where " . $key_fld . " = " .$post_enm. " ";	
							else {
								if( $r_tp =='DATE' || $r_tp =='MONTH') {
									$post_enm =substr( $post_enm, 0, $r_len);
									$WR = " where " . $key_fld . " = '" .$post_enm. "' ";
								} else $WR = " where " . $key_fld . " = '" .$post_enm. "' ";
							}
							$sw ='on';
						} else if( $sw =='on'){
							if( $f_num ) $WR = $WR . " and " . $key_fld . " = " .$post_enm. " ";	
							else {
								if( $r_tp =='DATE' || $r_tp =='MONTH') {
									$post_enm =substr( $post_enm, 0, $r_len);                    // MONTH len=7, DATE len=10
									$WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";
								} else $WR = $WR . " and " . $key_fld . " = '" .$post_enm. "' ";
							}
						}
					}
				}
			}
			$SQLA = $SQLA . $WR;		//echo "SQLA: " . $SQLA; exit;
			$retA = sql_fetch( $SQLA );
			if( $retA ) {
				$kapp_memo = $retA['kapp_memo'] . "\n|UPDATE-TYPE-UPDATE, ". $pg_code.":".$day.":".$H_ID. ":" . $ip;
				$SQLR = "UPDATE " . $r_table . " SET ";
				$SQLR = $SQLR . " kapp_memo = '$kapp_memo' ";

				for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
					$r_fld		= $r_data[$i];              // $fld_1:fld1|=|fld_1:상품:VARCHAR
					$fld_r		= explode("|", $r_fld);		// fld_1:name|=|fld_1:name
					$fld_r1	= $fld_r[0];
					$fld_sik= $fld_r[1];                    // =, -, +
					$fld_r2	= $fld_r[2];
					
					$fld1	= explode(":", $fld_r1);		// program table -> fld_1:name|=|fld_1:name
					$f_enm	= $fld1[0];
					
					$fld2	= explode(":", $fld_r2);		// rellation table -> fld_1:name|=|fld_1:name
					$r_enm	= $fld2[0];
					$r_tp	= $fld2[2];
					$r_len	= $fld2[3];

					if( isset($f_enm) && isset($_POST[$f_enm]) && $_POST[$f_enm]!='' )  $post_enm = $_POST[$f_enm];
					else $post_enm = "";

					if( $fld_sik == '=' ) {
						if( data_number_check( $r_tp ) ) $SQLR = $SQLR . " , "  . $r_enm . " = " . $post_enm . " ";
						else {
							//$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
							if( $r_tp =='DATE' || $r_tp =='MONTH') {
								if( $post_enm !='') $post_enm =substr( $post_enm, 0, $r_len); // MONTH len=7, DATE len=10
								$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
							} else $SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
						}
					} else if( $fld_sik == '+' ) {
						$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
					} else if( $fld_sik == '-' ) {
						$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
					}
				}
				$SQLR = $SQLR . $WR; //echo "SQLR: " . $SQLR; exit;
				//SQLR: UPDATE dao_1773892202 SET kapp_memo = 'UPDATE-TYPE-INSERT, dao_1768181179:2026-03-19 13-07-03:dao:58.29.102.214 |UPDATE-TYPE-UPDATE, dao_1768181179:2026-03-19 14-06-16:dao:58.29.102.214' , fld_1 = '2026-03-19 14:03:22' , fld_2 = 'GPU' , fld_3=fld_3 + 10 , fld_4=fld_4 + 23000000 , fld_5 = 'tet 10' where fld_1 = '2026-03-19' and fld_2 = 'GPU'
				$ret  = sql_query($SQLR);
				if( $ret ) {
					m_("relation table: $Rtabhnm Update");
				} else {
					echo "ERROR relation table error - SQLR: " . $SQLR; exit;
				}
			} else { // record no found - insert
				$kapp_memo = "UPDATE-TYPE-INSERT, ". $pg_code.":".$day.":".$H_ID. ":" . $ip;

				$SQLAR = "INSERT INTO " . $r_table . " SET ";
				$SQLAR = $SQLAR . "kapp_userid= '" . $H_ID . "' , ";
				$SQLAR = $SQLAR . "kapp_memo= '" . $kapp_memo . "' , ";
				$SQLAR = $SQLAR . "kapp_pg_code= '" . $pg_code . "' ";
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
					$r_tp	= $fld2[2];
					$r_len	= $fld2[3];

					if( isset($f_enm) && isset($_POST[$f_enm]) && $_POST[$f_enm]!='' )  $post_enm = $_POST[$f_enm];
					else $post_enm = '';
					if( $fld_sik == '=' ) {
						if( data_number_check( $r_tp ) ) $SQLAR = $SQLAR . " , "  . $r_enm . " = " . $post_enm . " ";
						else {
							//$SQLAR = $SQLAR . " , "  . $r_enm . " = '" . $post_enm . "' ";
							if( $r_tp =='DATE' || $r_tp =='MONTH') {
								if( $post_enm !='') $post_enm =substr( $post_enm, 0, $r_len); // MONTH len=7, DATE len=10
								$SQLAR = $SQLAR . " , "  . $r_enm . " = '" . $post_enm . "' ";
							} else $SQLAR = $SQLAR . " , "  . $r_enm . " = '" . $post_enm . "' ";
						}
					/* When inserting, all calculation expressions are processed as '='. , insert일때 계산식은 모두 '=' 처리한다.  */
					} else if( $fld_sik == '+' ) { // If there is no record when the relation type is 'Update': relation type이 'Update' 일때 record가 없으면
						$SQLAR = $SQLAR . " , " . $r_enm . "=" . $post_enm . " ";
					} else if( $fld_sik == '-' ) {
						$SQLAR = $SQLAR . " , " . $r_enm . "=" . $post_enm . " ";
					}
				}
				$ret =sql_query($SQLAR);
				if( $ret ) { 
					m_("relation table: $Rtabhnm, Insert OK! - WR: ");
				}else{
					echo "relation table error - SQLAR: " . $SQLAR; exit;
					m_("Error --- relation table: $Rtabhnm Insert error");
					//printf('Relation data insert ERROR sqlr:%s', $SQLR); 
				}
			}
		} else { // Write - relation type : 'Insert'  
			$kapp_memo = "INSERT-TYPE-INSERT, " . $pg_code.":".$day.":".$H_ID. ":" . $ip;

			$SQLR = "INSERT INTO " . $r_table . " SET ";
			$SQLR = $SQLR . "kapp_userid= '" . $H_ID . "' , ";
			$SQLR = $SQLR . "kapp_memo= '" . $kapp_memo . "' , ";
			$SQLR = $SQLR . "kapp_pg_code= '" . $pg_code . "' ";
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
				$r_tp	= $fld2[2];
				$r_len	= $fld2[3];
				if( isset($f_enm) && isset($_POST[$f_enm]) && $_POST[$f_enm]!='' )  $post_enm = $_POST[$f_enm];
				else $post_enm = '';
				if( $fld_sik == '=' ) { 
					if( data_number_check( $r_tp ) ) $SQLR = $SQLR . " , "  . $r_enm . " = " . $post_enm . " ";
					else {
						//$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
						if( $r_tp =='DATE' || $r_tp =='MONTH') {                        // MONTH len=7, DATE len=10
							if( $post_enm !='') $post_enm =substr( $post_enm, 0, $r_len);
							$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
						} else $SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
					}
				}
				/* When inserting, all calculation expressions are processed as '='. , insert일때 계산식은 모두 '=' 처리한다.  */
				else if( $fld_sik == '+' ) $SQLR = $SQLR . " , " . $r_enm . "=" . $post_enm . " ";
				else if( $fld_sik == '-' ) $SQLR = $SQLR . " , " . $r_enm . "=" . $post_enm . " ";
				
			}
			$SQLR = $SQLR . " ";
			$ret =sql_query($SQLR);
			if( $ret ) { 
				m_("relation table: $Rtabhnm, Insert OK!");
			}else{
				echo "relation table='$Rtabhnm' insert error - r_type: " . $r_type. ", i SQLR: " . $SQLR; exit;
				m_("relation table:$Rtabhnm, insert error - r_type: " . $r_type);
				//printf('Relation data insert ERROR sqlr:%s', $SQLR); 
			}
		}// if
	}
	function data_number_check( $kapp_col ){
		if( $kapp_col == "INT" || $kapp_col == "TINYINT" || $kapp_col == "BIGINT" || $kapp_col == "SMALLINT" || $kapp_col == "MEDIUMINT" || $kapp_col == "DECIMAL" || $kapp_col == "FLOAT" || $kapp_col == "DOUBLE") {
			return true;	
		} else return false;
	}

	function Kcolumn_check($fld_enm){
		if( $fld_enm =='' || $fld_enm =='seqno' || $fld_enm =='kapp_userid' || $fld_enm =='kapp_pg_code' || $fld_enm =='kapp_memo') {
			m_(" The column names seqno, kapp_userid, kapp_pg_code, and kapp_memo are K-APP system columns. They must not be used.");
			return false;
		}
		return true;
	}
	function item_array_func( $item , $iftype, $ifdata, $popdata, $relationdata) {
		// use - program_list)ai.php, kapp_program_list_adm_ai.php
		global $formula_, $poptable_, $column_all, $pop_fld, $pop_mvfld, $rel_mvfld, $relation_db, $gita;
				$list	= explode("@", $item);
				$iftype = explode("|", $iftype);
				$ifdata = explode("|", $ifdata);
				$column_all		="";
				$formula_		="";
				$poptable_		="";
				$gita				="";
		for ( $i=0,$j=1; isset($list[$i]) && $list[$i] != ""; $i++, $j++ ){
				if(isset($iftype[$j]) ) $typeX	= $iftype[$j];
				else $typeX = "";
				if(isset($ifdata[$j]) ) $dataX	= $ifdata[$j];
				else $dataX = "";
				$ddd		= $list[$i];
				$fld		= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
				$column_all = $column_all . $fld[2] . "(" . $fld[3] . ") , ";
						if( !$typeX ) { // 0 or ''
						} else if( $typeX == "11" ) { // calc
							$formula = explode(":", $dataX);
							if( isset($formula[1]) ) $formula_ = $formula[1];
						} else if( $typeX == "13" ) { // 팝업창
							$poptable = explode(":", $dataX);
							if( isset($poptable[1]) ) $poptable_ = $poptable[1];
						} else {
							$gita = $gita . $fld[2] . "-" . $dataX . "<br>";
						}
		}
		$popdata = explode("@", $popdata); // pop_data, 첫번째 분류.
		$pop_fld ="";
		for ( $i=0,$j=1; isset($popdata[$i]) && $popdata[$i] != ""; $i++, $j++ ){
			if( isset($popdata[$j]) ){
				$popfld = $popdata[$j];
				$popfld = explode(":", $popfld);
				if( isset($popfld[1]) ) $pop_fld = $pop_fld . $popfld[1] . ",";
				else  $pop_fld = $pop_fld . ",";
			} else {
				$pop_fld = $pop_fld . ",";
			}
		}
		$mpop = $popdata[0];
		$mpop = explode("$", $mpop); // pop_data, 두번째 분류.
		$pop_mvfld = "";
		for ( $i=0,$j=1; isset($mpop[$j]) && $mpop[$j] != ""; $i++, $j++ ){
			$mv = explode("|", $mpop[$j]); // pop_data, 세번째 분류.
			$fld1 = $mv[0];
			$fld2 = $mv[1];
			$mvfld1 = explode(":", $fld1);
			$mvfld2 = explode(":", $fld2);
			$pop_mvfld = $pop_mvfld . $mvfld1[1] . "=" . $mvfld2[1] . ", ";
		}
			$relationdata = explode("$", $relationdata);
			$rel_db = $relationdata[0];
			$reldb = explode(":", $rel_db);
			if( isset($reldb[1]) ) $relation_db = $reldb[1];
			else  $relation_db = "";
			$rel_mvfld = "";
		for ( $i=0,$j=1; isset($relationdata[$j]) && $relationdata[$j] != ""; $i++, $j++ ){
			$reldata = $relationdata[$j];
			$rel = explode("|", $reldata );
			$fld1 = $rel[0];
			$sik = $rel[1];
			$fld2 = $rel[2];
			$rmvfld1 = explode(":", $fld1);
			$rmvfld2 = explode(":", $fld2);
			$rel_mvfld = $rel_mvfld . $rmvfld1[1] . $sik . $rmvfld2[1] . " , ";
		}
	}

?>      
