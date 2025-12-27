<?php
	include_once('./tkher_start_necessary.php');
	/*
	  login_checkT.php - menu_run.php <div class="loginBox">
	  - $member = get_urllink_memberA($mb_id);
	  - set_session('urllink_login_type', "appgeneratorsystem");
	*/

	if( isset($_POST['Login_Mode']) ) $Login_Mode = $_POST['Login_Mode'];
    else if (isset($_REQUEST['Login_Mode']) ) $Login_Mode = $_REQUEST['Login_Mode'];
	else $Login_Mode = '';

    if( isset($_POST['runpage']) ) $runpage = trim($_POST['runpage']);
	else $runpage= '';

    if( isset($_POST['returnURL']) ) $returnURL = trim($_POST['returnURL']);
    else $returnURL = 'index.php';
if( $Login_Mode == 'A_login') { 
    $mb_email    = trim($_POST['mb_id']);
    $mb_password = trim($_POST['mb_password']);
    if( !$mb_email || !$mb_password) {
        m_('Member email or password must not be blank. ');
        echo("<meta http-equiv='refresh' content='0; URL=$returnURL'>");
        exit;
    }
    $member = get_urllink_memberE($mb_email); 
    if( !$member['mb_id'] || !check_passwordA( $mb_password, $member['mb_password'])) {
        m_("It is not a registered member Email or password. is:" );
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    } else {
		$mb_id = $member['mb_id'];
        connect_count('K-App login : appgeneratorsystem', $mb_email, 1, $referer);
    }
    if( $member['mb_level'] == 5 && !isset($member['mb_certify'])) {
        m_('승인 대기중인 아이디입니다.');
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    } 
    // 차단된 아이디인가?
    if( $member['mb_intercept_date'] && $member['mb_intercept_date'] <= date("Ymd", KAPP_SERVER_TIME)) {
        $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1year \\2month \\3day", $member['mb_intercept_date']);
        m_('Your ID is prohibited from access. date: '.$date);
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    }
    // 탈퇴한 아이디인가?
    if( $member['mb_leave_date'] && $member['mb_leave_date'] <= date("Ymd", KAPP_SERVER_TIME)) {
        $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $member['mb_leave_date']);
        //탈퇴한 아이디이므로 접근하실 수 없습니다. 탈퇴일 : '.$date);
        m_('You can not access it because it is an ID you left. Date of withdrawal: '.$date);
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    }
    if( $config['kapp_use_email_certify'] && !preg_match("/[1-9]/", $member['mb_email_certify'])) {
        $ckey = md5($member['mb_ip'].$member['mb_datetime']); //로그인하려면 이메일 인증을 받아야 합니다. 다른 이메일 주소로 변경하고 확인하려면 취소를 클릭하세요.
       confirm("{$member['mb_email']} You must be authenticated by e-mail to log in.  Please click Cancel to change to another email address and verify. ", KAPP_URL_T_, './tkher_register_email.php?mb_id='.$member['mb_id'].'&ckey='.$ckey);
    } 
    Create_Session('appgeneratorsystem', $member, $remote_addr, $user_agent);

} else if( $Login_Mode == 'Google_Login_K') {

	$g_email = trim($_POST['g_email']);
	$g_fullname = trim($_POST['g_fullname']);
	$g_image = trim($_POST['g_image']);
	$level = '2'; // default
    $set_point = $config['kapp_register_point'];
    $g_email_check = Record_check($g_email);
    if( !$g_email_check) {
		$emailA = explode(".", $g_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0);
        Record_create_member_google( $userid, $g_email, $g_fullname, $g_image, $level, $set_point);
        Record_create_point_info( $userid, $set_point);
        $member = get_urllink_memberE($g_email);
        connect_count('K-App login : Create Google_account', $g_email, 1, $referer);
        Create_Session('Google_Login_K', $member, $remote_addr, $user_agent);

	} else {
        if($g_email_check == 'Kakao' || $g_email_check == 'Naver') {
            m_(" dup ---Google");
        } else {
            Record_update_google( $g_email, $g_fullname, $g_image);
            $member = get_urllink_memberE($g_email);
            connect_count('K-App login : Login Google', $g_email, 1, $referer);
        }
        Create_Session('Google_Login_K', $member, $remote_addr, $user_agent);
	}

} else if( $Login_Mode == 'Kakao_Login_K') {

    $userObj_json = getJsonText($_POST['userObject']);
    $userObj = json_decode($userObj_json, true);
    $k_email = trim($userObj['kakao_account']['email']);
    $k_nickname = trim($userObj['properties']['nickname']);
    $k_image = trim($userObj['properties']['thumbnail_image']);
	$level = '2'; // default
    $set_point = $config['kapp_register_point'];
    $kakao_email_check = Record_check($k_email);

    if( !$kakao_email_check) {
		$emailA = explode(".", $k_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0); 
        Record_create_member_kakao( $userid, $k_email, $k_nickname, $k_image, $level, $set_point);
        Record_create_point_info( $userid, $set_point);
        $member = get_urllink_memberE($k_email);
        connect_count('K-App login : Create Kakao_account', $k_email, 1, $referer);
        Create_Session('Kakao_Login_K', $member, $remote_addr, $user_agent);

	} else {
        if( $kakao_email_check == 'Google' || $kakao_email_check == 'Naver') {
            m_(" email dup.---Kakao");
        } else {
            Record_update_kakao($k_email, $k_nickname, $k_image);
			$member = get_urllink_memberE($k_email);
            connect_count('K-App login : Login Kakao', $k_email, 1, $referer);
        }
        Create_Session('Kakao_Login_K', $member, $remote_addr, $user_agent);
	}

} else if( $Login_Mode == 'N_login'){

	$client_id = $config['kapp_naver_client_id'];
	$client_secret = $config['kapp_naver_client_secret'];
	$code = $_GET["code"];
	$state = $_GET["state"];
    $returnURL = $state;
	$redirectURI = urlencode( KAPP_URL_T_ . "/login_checkT.php");
	$n_url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
	$is_post = false;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $n_url);
	curl_setopt($ch, CURLOPT_POST, $is_post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$headers = array();
	$response = curl_exec ($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
	if( $status_code == 200) {
		$responseData = json_decode($response, true);
	  	$token = $responseData['access_token'];
		$header = "Bearer ".$token; // Bearer 다음에 공백 추가
		$n_url = "https://openapi.naver.com/v1/nid/me";
		$is_post = false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $n_url);
		curl_setopt($ch, CURLOPT_POST, $is_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array();
		$headers[] = "Authorization: ".$header;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response2 = curl_exec ($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);
		if( $status_code == 200) {
			$responseData2 = json_decode($response2, true);
			$n_id = $responseData2['response']['id'];
			$n_email = $responseData2['response']['email'];
			$n_name = $responseData2['response']['name'];
			if( isset($responseData2['response']['mobile']) ) $n_mobile = $responseData2['response']['mobile'];
			else $n_mobile = "";
			$n_profile_image = $responseData2['response']['profile_image'];
			$n_nickname = $responseData2['response']['nickname'];
			$n_gender = $responseData2['response']['gender'];
			if( isset($responseData2['response']['age']) ) $n_age = $responseData2['response']['age'];
			else $n_age = "";
			$n_birthday = $responseData2['response']['birthday'];
			if( isset($responseData2['response']['birthyear']) ) $n_birthyear = $responseData2['response']['birthyear'];
			else $n_birthyear = "";

		} else {
			echo "Error:".$response2;
			exit;
		}
	} else {
	  echo "Error:".$response2;
	  exit;
	}
    $level = '2'; // default
    $set_point = $config['kapp_register_point'];
    $n_birth = $n_birthyear.get_Number_K($n_birthday);
    $n_hp = get_Number_K($n_mobile);
    $naver_email_check = Record_check($n_email); // check NAVER first login

    if( !$naver_email_check) { // first
		$emailA = explode(".", $n_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0); 
        Record_create_member_naver($userid, $n_email, $n_name, $n_nickname, $n_profile_image, $level, $n_gender, $n_birth, $n_hp, $set_point);
		//$id = str_replace( "@", "_", $n_email);
        Record_create_point_info($userid, $set_point);
        $member = get_urllink_memberE($n_email);
        connect_count('K-App login : Create Naver_account', $n_email, 1, $referer);
        Create_Session('Naver_Login_K', $member, $remote_addr, $user_agent);

	} else { // 로그인
        if( $naver_email_check == 'Google' || $naver_email_check == 'Kakao') { // email duplicate
            m_("이미 등록된 계정입니다.---Naver");
        } else {
            Record_update_naver( $n_email, $n_name, $n_nickname, $n_profile_image, $n_hp);
            $member = get_urllink_memberE($n_email);
            connect_count('K-App login : Login Naver ', $n_email, 1, $referer);
        }
        Create_Session('Naver_Login_K', $member, $remote_addr, $user_agent); // SESSION login create
	}
   
} else {
	m_("---- Error login checkT"); 
	exit;
}

if( $config['kapp_use_point']) {
    $sum_point = get_point_sum($member['mb_id']);
    $sql= " update {$tkher['tkher_member_table']} set mb_point = '$sum_point' where mb_id = '{$member['mb_id']}' ";
    sql_query($sql);
}
/*
if( $url) { // url 체크
    check_url_host($url);
    $link = urldecode($url);   // (다른 변수들을 넘겨주기 위함)
    if( preg_match("/\?/", $link)) $split= "&amp;";
    else     $split= "?";

    foreach( $_POST as $key=>$value) {
        if( $key != 'mb_id' && $key != 'mb_password' && $key != 'x' && $key != 'y' && $key != 'url') {
            $link .= "$split$key=$value";
            $split = "&amp;";
        }
    }
    if( $_POST['runpage']) $link = $_POST['runpage'];
    else $link = KAPP_URL_T_;
} else  {

	if( isset($_POST['runpage']) ) $link = $_POST['runpage'];
    else $link = "./";
}
*/

$url = "./"; //$returnURL;
echo "<script>window.open( '$url' , '_top', ''); </script>";
exit;

function Create_Session($_type, $_member, $_remote_addr, $_user_agent){
    set_session('urllink_login_type', $_type);
    set_session('ss_mb_id', $_member['mb_id']);
    set_session('ss_mb_level', $_member['mb_level']);
    set_session('ss_mb_key', md5($_member['mb_datetime'] . $_remote_addr . $_user_agent));
}
function Record_check($_email) {
    global $tkher;
    $SQL = " select mb_id, mb_sn from {$tkher['tkher_member_table']} where mb_email = '".$_email."' ";
	$result = sql_query($SQL);
    $row = sql_fetch_array($result);
    if($row) return $row['mb_sn'];
    else return false;
}

function Record_create_member_google( $userid, $_g_email, $_g_fullname, $_g_image, $_level, $_set_point) { // google info
    global $tkher;

    $query = " INSERT {$tkher['tkher_member_table']} SET mb_id = '".$userid."' , mb_sn = 'Google'  , mb_name = '".$_g_fullname."'  , mb_nick = '".$_g_fullname."' , mb_nick_date = '".date('Y-m-d')."' , mb_email = '".$_g_email."', mb_certify='".date('Y-m-d H:i:s')."', mb_email_certify='".date('Y-m-d H:i:s')."' , mb_photo = '".$_g_image."' , mb_level = '".$_level."' , mb_point = '".$_set_point."'  , mb_today_login = '".date('Y-m-d H:i:s')."'  , mb_login_ip = '".$_SERVER['REMOTE_ADDR']."'  , mb_datetime = '".date('Y-m-d H:i:s')."' , mb_ip = '".$_SERVER['REMOTE_ADDR']."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("Google member error. ---");
    }
}

function Record_create_member_kakao($userid, $_k_email, $_k_nickname, $_k_image, $_level, $_set_point) { // kakao
    global $tkher;

    $query = " INSERT {$tkher['tkher_member_table']} SET mb_id = '".$userid."' , mb_sn = 'Kakao'  , mb_name = '".$_k_nickname."'  , mb_nick = '".$_k_nickname."' , mb_nick_date = '".date('Y-m-d')."' , mb_email = '".$_k_email."', mb_certify='".date('Y-m-d H:i:s')."', mb_email_certify='".date('Y-m-d H:i:s')."'  , mb_photo = '".$_k_image."' , mb_level = '".$_level."' , mb_point = '".$_set_point."'  , mb_today_login = '".date('Y-m-d H:i:s')."'  , mb_login_ip = '".$_SERVER['REMOTE_ADDR']."'  , mb_datetime = '".date('Y-m-d H:i:s')."' , mb_ip = '".$_SERVER['REMOTE_ADDR']."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("KAKAO member crate error. ---" );
    }
}

function Record_create_member_naver($userid, $_n_email, $_n_name, $_n_nickname, $_n_image, $_level, $_gender, $_birth, $_hp, $_set_point) {
    global $tkher;

    $query = " INSERT {$tkher['tkher_member_table']} SET mb_id = '".$userid."' , mb_sn = 'Naver'  , mb_name = '".$_n_name."'  , mb_nick = '".$_n_nickname."' , mb_nick_date = '".date('Y-m-d')."' , mb_email = '".$_n_email."', mb_certify='".date('Y-m-d H:i:s')."', mb_email_certify='".date('Y-m-d H:i:s')."'  , mb_photo = '".$_n_image."' , mb_level = '".$_level."' , mb_sex = '".$_gender."' , mb_birth = '".$_birth."' , mb_hp = '".$_hp."' , mb_point = '".$_set_point."'  , mb_today_login = '".date('Y-m-d H:i:s')."'  , mb_login_ip = '".$_SERVER['REMOTE_ADDR']."'  , mb_datetime = '".date('Y-m-d H:i:s')."' , mb_ip = '".$_SERVER['REMOTE_ADDR']."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("Naver member create error. ---" );
    }
}

function Record_create_point_info($_mb_id, $_set_point) {
    global $tkher;
    $timestamp = strtotime("+3 years");

    $query = " INSERT {$tkher['point_table']} SET mb_id = '".$_mb_id."' , po_datetime = '".date('Y-m-d H:i:s')."' , po_title = '".date('Y-m-d')."' , po_content = '".date('Y-m-d')." create_member' , po_point = '".$_set_point."' , po_expire_date = '".date('Y-m-d H:i:s', $timestamp)."' , po_mb_point = '".$_set_point."' , po_rel_table = '@login' , po_rel_id = '".$_mb_id."' , po_rel_action = '".date('Y-m-d')."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("point pay error. ---");
    }
}

function Record_update_google($_g_email, $_g_fullname, $_g_image) {
    global $tkher;
    global $config;
        
	$query = " UPDATE {$tkher['tkher_member_table']} SET  "; 
	if(Change_nick_check($_g_email, $_g_fullname)) { // 닉네임이 변경 체크
		$query = $query . "mb_nick= '" . $_g_fullname . "' ";  
		$query = $query . ",mb_nick_date= '" . date('Y-m-d'). "' "; 
		$query = $query . ",mb_photo= '" . $_g_image . "' ";   
	} else {
		$query = $query . "mb_photo= '" . $_g_image . "' ";   
	}

	$query = $query . ",mb_datetime= '" . date('Y-m-d H:i:s') . "' ";   
	$query = $query . " where mb_email = '".$_g_email."' ";   

	$ret = sql_query( $query );
	if(!$ret) {
		m_("member update error. ---");
	}
}

function Record_update_kakao($_k_email, $_k_nickname, $_k_image) {
    global $tkher;
    global $config;
        
	$query = " UPDATE {$tkher['tkher_member_table']} SET  "; 
	if( Change_nick_check($_k_email, $_k_nickname)) {
		$query = $query . "mb_nick= '" . $_k_nickname . "' ";  
		$query = $query . ",mb_nick_date= '" . date('Y-m-d'). "' "; 
		$query = $query . ",mb_photo= '" . $_k_image . "' ";   
	} else {
		$query = $query . "mb_photo= '" . $_k_image . "' ";   
	}
	$query = $query . ",mb_datetime= '" . date('Y-m-d H:i:s') . "' ";   
	$query = $query . " where mb_email = '".$_k_email."' ";   
	$ret = sql_query( $query );
	if(!$ret) {
		m_("member update error. ---");
	}
}

function Record_update_naver($_n_email, $_n_name, $_n_nickname, $_n_image, $_hp) {
    global $tkher;
    global $config;
        
	$query = " UPDATE {$tkher['tkher_member_table']} SET  "; 
	if( Change_nick_check($_n_email, $_n_nickname)) {
		$query = $query . "mb_name= '" . $_n_name . "' ";   
		$query = $query . ",mb_nick= '" . $_n_nickname . "' ";  
		$query = $query . ",mb_nick_date= '" . date('Y-m-d'). "' "; 
		$query = $query . ",mb_photo= '" . $_n_image . "' ";   
		$query = $query . ",mb_hp= '" . $_hp . "' ";   
	} else {
		$query = $query . "mb_name= '" . $_n_name . "' ";   
		$query = $query . ",mb_photo= '" . $_n_image . "' ";   
		$query = $query . ",mb_hp= '" . $_hp . "' ";   
	}

	$query = $query . ",mb_datetime= '" . date('Y-m-d H:i:s') . "' ";   
	$query = $query . " where mb_email = '".$_n_email."' ";   

	$ret = sql_query( $query );
	if(!$ret) {
		m_("naver member update error. ---");
	}
}

function Change_nick_check($_mb_email, $_nick){
    global $tkher;
    $SQL = " select mb_nick from {$tkher['tkher_member_table']} where mb_email = '".$_mb_email."' ";
	$result = sql_query($SQL);
    $row = sql_fetch_array($result);

    if($row['mb_nick'] == $_nick) return false;
    else return true;
}

function get_Number_K($_number){
    return str_replace("-", "", $_number);
}

?>