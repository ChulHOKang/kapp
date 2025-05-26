<?php
	include_once('./tkher_start_necessary.php');

	/*
	  login_checkT.php - menu_run.php <div class="loginBox">
	  - $member = get_urllink_memberA($mb_id); // my_func : 
	  - set_session('urllink_login_type', "appgeneratorsystem");

	*/

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
    else if (isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
	else $mode = '';

    if( isset($_POST['runpage']) ) $runpage = trim($_POST['runpage']);
	else $runpage= '';

    if( isset($_POST['returnURL']) ) $returnURL = trim($_POST['returnURL']);
    else $returnURL = 'index.php';

	//m_("login_checkT - P mode: " . $mode . ", _POST mode: " . $_POST['mode']); 
	// login_checkT - P mode: A_login, _POST mode: A_login, login_checkT - P mode: , REQUEST mode: N_login

if( $mode == 'A_login') { // 
	
    $mb_email    = trim($_POST['mb_id']); // mb_id=email : id를 email로 변경 2025-05-18

    $mb_password = trim($_POST['mb_password']);
    if( !$mb_email || !$mb_password) {
        m_('Member email or password must not be blank. ');  //회원아이디나 비밀번호가 공백이면 안됩니다.
        echo("<meta http-equiv='refresh' content='0; URL=$returnURL'>");
        exit;
    }
    //$member = get_urllink_memberA($mb_id);// ID로 로그인 체크.
    $member = get_urllink_memberE($mb_email);  // Email로 로그인. 2025-05-18
    if( !$member['mb_id'] || !check_passwordA( $mb_password, $member['mb_password'])) {
        m_("It is not a registered member Email or password. is:" );
        //echo("<meta http-equiv='refresh' content='0; URL=$returnURL'>");
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    } else {
		$mb_id = $member['mb_id'];    //m_("connect");
        connect_count('K-App login : appgeneratorsystem', $mb_email, 1, $referer);	// 1: log_info 생성, country code return 요청.
    }

    // 대리점 아이디이며, 승인이 됬는가?
    if( $member['mb_level'] == 5 && !isset($member['mb_certify'])) {
        m_('승인 대기중인 아이디입니다.');
        //echo("<meta http-equiv='refresh' content='0; URL=$returnURL'>");
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    } 

    // 차단된 아이디인가?
    if( $member['mb_intercept_date'] && $member['mb_intercept_date'] <= date("Ymd", KAPP_SERVER_TIME)) {
        $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $member['mb_intercept_date']);
        //alert('Your ID is prohibited from access. 회원님의 아이디는 접근이 금지되어 있습니다. \n 처리일 : '.$date);
        m_('Your ID is prohibited from access. date: '.$date);
        //echo("<meta http-equiv='refresh' content='0; URL=$returnURL'>");
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    }
    // 탈퇴한 아이디인가?
    if( $member['mb_leave_date'] && $member['mb_leave_date'] <= date("Ymd", KAPP_SERVER_TIME)) {
        $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $member['mb_leave_date']);
        //탈퇴한 아이디이므로 접근하실 수 없습니다. 탈퇴일 : '.$date);
        m_('You can not access it because it is an ID you left. Date of withdrawal: '.$date);
        //echo("<meta http-equiv='refresh' content='0; URL=$returnURL'>");
        echo("<script>window.open('$returnURL', '_top')</script>");
        exit;
    }
    if( $config['kapp_use_email_certify'] && !preg_match("/[1-9]/", $member['mb_email_certify'])) {
        $ckey = md5($member['mb_ip'].$member['mb_datetime']); //로그인하려면 이메일 인증을 받아야 합니다. 다른 이메일 주소로 변경하고 확인하려면 취소를 클릭하세요.
       confirm("{$member['mb_email']} You must be authenticated by e-mail to log in.  Please click Cancel to change to another email address and verify. ", KAPP_URL_T_, './tkher_register_email.php?mb_id='.$member['mb_id'].'&ckey='.$ckey); // confirm 코드 중지됨
    } 
    Create_Session('appgeneratorsystem', $member, $remote_addr, $user_agent);

} else if( $mode == 'Google_Login_K') { // 구글 로그인

    //$g_id = trim($_POST['g_id']);
	$g_email = trim($_POST['g_email']);
	$g_fullname = trim($_POST['g_fullname']);
	$g_image = trim($_POST['g_image']);
	$level = '2'; // default
    $set_point = $config['kapp_register_point']; //kapp_register_point
    $g_email_check = Record_check($g_email); // GOOGLE 첫 로그인 체크
    if( !$g_email_check) { // 첫 구글 로그인        //m_("first");
        Record_create_member($g_email, $g_fullname, $g_image, $level, $set_point);
		
		//$id = str_replace( "@", "_", $g_email);
		$emailA = explode(".", $g_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0); // 2025-05-18 add
		
		Record_create_point_info($userid, $set_point);
        $member = get_urllink_memberE($g_email);
        connect_count('K-App login : Create Google_account', $g_email, 1, $referer);	// 1: log_info 생성, country code return 요청.
        Create_Session('Google_Login_K', $member, $remote_addr, $user_agent); // 로그인 SESSION 생성 - add kan Google_Login_K 2024-04-24

	} else { // 구글 로그인
        if($kakao_email_check == 'Kakao' || $kakao_email_check == 'Naver') { // 이메일 중복 발생
            m_("이미 등록된 계정입니다.---Google");
        } else {
            Record_update_google($g_email, $g_fullname, $g_image);
            $member = get_urllink_memberE($g_email);
            connect_count('K-App login : Login Google', $g_email, 1, $referer);	// 1: log_info 생성, country code return 요청.
        }
        Create_Session('Google_Login_K', $member, $remote_addr, $user_agent); // 로그인 SESSION 생성
	}

} else if ( $mode == 'Kakao_Login_K') { // 카카오 로그인

    $userObj_json = getJsonText($_POST['userObject']);
    $userObj = json_decode($userObj_json, true);   /* print_r($userObj['kakao_account']);    exit; */

    $k_email = trim($userObj['kakao_account']['email']);
    $k_nickname = trim($userObj['properties']['nickname']);
    //$k_birthday = trim($userObj['kakao_account']['birthday']);
    //$k_gender = trim($userObj['kakao_account']['gender']);
    $k_image = trim($userObj['properties']['thumbnail_image']);

	$level = '2'; // default
    $set_point = $config['kapp_register_point'];
    $kakao_email_check = Record_check($k_email); // KAKAO 첫 로그인 체크

    if( !$kakao_email_check) { // 첫 카카오 로그인     //m_("first");
        Record_create_member_kakao($k_email, $k_nickname, $k_image, $level, $set_point);
		
		//$id = str_replace( "@", "_", $k_email);
		$emailA = explode(".", $k_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0); // 2025-05-18 add
        
		Record_create_point_info($userid, $set_point);
        $member = get_urllink_memberE($k_email);  //$member = get_urllink_memberA($k_email);
        connect_count('K-App login : Create Kakao_account', $k_email, 1, $referer);	// 1: log_info 생성, country code return 요청.
        Create_Session('Kakao_Login_K', $member, $remote_addr, $user_agent); // 로그인 SESSION 생성 add kan Kakao_Login_K 2024-04-24

	} else { // 카카오 로그인
        if($kakao_email_check == 'Google' || $kakao_email_check == 'Naver') { // 이메일 중복 발생
            m_("이미 등록된 email 계정입니다.---Kakao");
        } else {
            Record_update_kakao($k_email, $k_nickname, $k_image);
			$member = get_urllink_memberE($k_email);  //$member = get_urllink_memberA($k_email);
            connect_count('K-App login : Login Kakao', $k_email, 1, $referer);	// 1: log_info 생성, country code return 요청.
        }
        Create_Session('Kakao_Login_K', $member, $remote_addr, $user_agent); // 로그인 SESSION 생성
	}

} else if( $mode == 'N_login'){ // 네이버 로그인

    // 네이버 로그인 콜백 PHP
	$client_id = "ltvDNxZZFNtePZjBWrZC";//"O8g4b8tFHZem4UBvlfCP"; $config['kapp_naver_client_id'], $config['kapp_naver_client_secret']
	$client_secret = "QiV0KUF42w";//"kwgQiX5H8k"; $config['kapp_naver_client_secret']
	$code = $_GET["code"];
	$state = $_GET["state"];
    $returnURL = $state;
    //m_("url:".$_REQUEST["returnURLX"]);
	$redirectURI = urlencode("http://biogplus.com/kapp/login_checkT.php"); //urlencode("http://moado.net/modu_shop/loginX");
	$n_url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state."&returnURLX=".$_REQUEST["returnURLX"];
	$is_post = false;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $n_url);
	curl_setopt($ch, CURLOPT_POST, $is_post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$headers = array();
	$response = curl_exec ($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);	//echo "status_code:".$status_code."";
	curl_close ($ch);
	if( $status_code == 200) {
		$responseData = json_decode($response, true);	//print_r($responseData);	//프로필 조회
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
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);	//echo "status_code:".$status_code."<br>";
		curl_close ($ch);
		if( $status_code == 200) {
			$responseData2 = json_decode($response2, true);	//print_r($responseData2);

			$n_id = $responseData2['response']['id'];
			$n_email = $responseData2['response']['email'];
			$n_name = $responseData2['response']['name'];
			$n_mobile = $responseData2['response']['mobile'];
			$n_profile_image = $responseData2['response']['profile_image'];
			$n_nickname = $responseData2['response']['nickname'];
			$n_gender = $responseData2['response']['gender'];
			$n_age = $responseData2['response']['age'];
			$n_birthday = $responseData2['response']['birthday'];
			$n_birthyear = $responseData2['response']['birthyear'];

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
    $naver_email_check = Record_check($n_email); // NAVER 첫 로그인 체크

    if( !$naver_email_check) { // 첫 네이버 로그인      //m_("first");
        Record_create_member_naver($n_email, $n_name, $n_nickname, $n_profile_image, $level, $n_gender, $n_birth, $n_hp, $set_point);
		
		//$id = str_replace( "@", "_", $n_email);
		$emailA = explode(".", $n_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0); // 2025-05-18 add
        
		Record_create_point_info($userid, $set_point);
        $member = get_urllink_memberE($n_email);  //$member = get_urllink_memberA($n_email);
        connect_count('K-App login : Create Naver_account', $n_email, 1, $referer);	// 1: log_info 생성, country code return 요청.
        Create_Session('Naver_Login_K', $member, $remote_addr, $user_agent);
		// $remote_addr,$user_agent:tkher_start, 로그인 SESSION 생성 - add kan Naver_Login_K

	} else { // 로그인
        if( $kakao_email_check == 'Google' || $kakao_email_check == 'Kakao') { // 이메일 중복 발생
            m_("이미 등록된 계정입니다.---Naver");
        } else {
            Record_update_naver( $n_email, $n_name, $n_nickname, $n_profile_image, $n_hp);
            $member = get_urllink_memberE($n_email); //$member = get_urllink_memberA($n_email);
            connect_count('K-App login : Login Naver ', $n_email, 1, $referer);	// 1: log_info 생성, country code return 요청.
        }
        Create_Session('Naver_Login_K', $member, $remote_addr, $user_agent); // 로그인 SESSION 생성
	}
   
} else {
	m_("---- Error login checkT"); 
	//echo("<meta http-equiv='refresh' content='0; URL=index.php'>");
	exit;
}

if( $config['kapp_use_point']) {
    $sum_point = get_point_sum($member['mb_id']);
    $sql= " update {$tkher['tkher_member_table']} set mb_point = '$sum_point' where mb_id = '{$member['mb_id']}' ";
    sql_query($sql);
}

if( $url) { // url 체크
    check_url_host($url);
    $link = urldecode($url);    // (다른 변수들을 넘겨주기 위함)
    if( preg_match("/\?/", $link)) $split= "&amp;";
    else     $split= "?";

    // $_POST 배열변수에서 아래의 이름을 가지지 않은 것만 넘김
    foreach( $_POST as $key=>$value) {
        if( $key != 'mb_id' && $key != 'mb_password' && $key != 'x' && $key != 'y' && $key != 'url') {
            $link .= "$split$key=$value";
            $split = "&amp;";
        }
        /* echo "Key : ".$key."<br/>";
        echo "Value : ".$value."<br/><br/>"; */
    }
    //exit;
    if( $_POST['runpage']) $link = $_POST['runpage'];
    else $link = KAPP_URL_T_;
} else  {
    /* foreach( $_POST as $key=>$value) {
        if( $key != 'mb_id' && $key != 'mb_password' && $key != 'x' && $key != 'y' && $key != 'url') {
            $link .= "$split$key=$value";
            $split = "&amp;";
        }
        echo "Key : ".$key."<br/>";
        echo "Value : ".$value."<br/><br/>";
    }
    exit; */
	
	if( isset($_POST['runpage']) ) $link = $_POST['runpage']; //$runpage = $_POST['runpage'];
    else $link = "./";
}

$url = $returnURL;
echo "<script>window.open( '$url' , '_top', ''); </script>";
exit;


function Create_Session($_type, $_member, $_remote_addr, $_user_agent){    // 회원아이디 세션 생성
    set_session('urllink_login_type', $_type);
    set_session('ss_mb_id', $_member['mb_id']);
    set_session('ss_mb_level', $_member['mb_level']);
    set_session('ss_mb_key', md5($_member['mb_datetime'] . $_remote_addr . $_user_agent));// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 
	/*
	$jtree_dir = KAPP_PATH_T_ . "/file/".$_member['mb_id']; //m_("- jtree_dir:" . $jtree_dir); //- jtree_dir:
	if ( !is_dir($jtree_dir) ) {
		if ( !@mkdir( $jtree_dir, 0777 ) ) {
			echo " Error: $jtree_dir : " . $email_id . " Failed to create directory., 디렉토리를 생성하지 못했습니다. ";
			m_("ERROR email id:" . $email_id . ", dir create OK : " . $jtree_dir);	//exit;
		} else {
			//echo " $jtree_dir : " . $email_id . " Created directory., 디렉토리를 생성 OK";
			///var/www/html/t/file/kim19260716@gmail.com : kim19260716@gmail.com Created directory., 디렉토리를 생성 OK
			m_("email id:" . $email_id . ", dir create OK : " . $jtree_dir);
			//email id:, dir create OK : /home1/ledsignart/public_html/kapp/file/solpakan_naver.com
			//email id:kim19260716, dir create OK : /home1/solpakanurl/public_html/t/file/kim19260716
		}
	}*/
}
function Record_check($_email) {
    global $tkher;
    
    //$SQL = " select mb_id, mb_sn from {$tkher['tkher_member_table']} where mb_id = '".$_email."' ";
    $SQL = " select mb_id, mb_sn from {$tkher['tkher_member_table']} where mb_email = '".$_email."' ";
	$result = sql_query($SQL);
    $row = sql_fetch_array($result);

    if($row) return $row['mb_sn'];
    else return false;
}

function Record_create_member($_g_email, $_g_fullname, $_g_image, $_level, $_set_point) { // 구글 정보로 생성
    global $tkher;
	//$userid == str_replace( "@", "_", $_g_email);
		$emailA = explode(".", $_g_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0); // 2025-05-18 add

    $query = " INSERT {$tkher['tkher_member_table']} SET mb_id = '".$userid."' , mb_sn = 'Google'  , mb_name = '".$_g_fullname."'  , mb_nick = '".$_g_fullname."' , mb_nick_date = '".date('Y-m-d')."' , mb_email = '".$_g_email."', mb_certify='".date('Y-m-d H:i:s')."', mb_email_certify='".date('Y-m-d H:i:s')."' , mb_photo = '".$_g_image."' , mb_level = '".$_level."' , mb_point = '".$_set_point."'  , mb_today_login = '".date('Y-m-d H:i:s')."'  , mb_login_ip = '".$_SERVER['REMOTE_ADDR']."'  , mb_datetime = '".date('Y-m-d H:i:s')."' , mb_ip = '".$_SERVER['REMOTE_ADDR']."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("Google 회원 정보 생성에 문제가 발생했습니다. ---");
    }
}

function Record_create_member_kakao($_k_email, $_k_nickname, $_k_image, $_level, $_set_point) { // 카카오 정보로 생성
    global $tkher;
	//$userid == str_replace( "@", "_", $_k_email);
		$emailA = explode(".", $_k_email);
		$email0 = $emailA[0];
		$userid = str_replace( "@", "_", $email0); // 2025-05-18 add

    $query = " INSERT {$tkher['tkher_member_table']} SET mb_id = '".$userid."' , mb_sn = 'Kakao'  , mb_name = '".$_k_nickname."'  , mb_nick = '".$_k_nickname."' , mb_nick_date = '".date('Y-m-d')."' , mb_email = '".$_k_email."', mb_certify='".date('Y-m-d H:i:s')."', mb_email_certify='".date('Y-m-d H:i:s')."'  , mb_photo = '".$_k_image."' , mb_level = '".$_level."' , mb_point = '".$_set_point."'  , mb_today_login = '".date('Y-m-d H:i:s')."'  , mb_login_ip = '".$_SERVER['REMOTE_ADDR']."'  , mb_datetime = '".date('Y-m-d H:i:s')."' , mb_ip = '".$_SERVER['REMOTE_ADDR']."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("KAKAO 회원 정보 생성에 문제가 발생했습니다. ---" );
    }
}

function Record_create_member_naver($_n_email, $_n_name, $_n_nickname, $_n_image, $_level, $_gender, $_birth, $_hp, $_set_point) { // 카카오 정보로 생성
    global $tkher;
	//$userid == str_replace( "@", "_", $_n_email);
	$emailA = explode(".", $_n_email);
	$email0 = $emailA[0];
	$userid = str_replace( "@", "_", $email0); // 2025-05-18 add

    $query = " INSERT {$tkher['tkher_member_table']} SET mb_id = '".$userid."' , mb_sn = 'Naver'  , mb_name = '".$_n_name."'  , mb_nick = '".$_n_nickname."' , mb_nick_date = '".date('Y-m-d')."' , mb_email = '".$_n_email."', mb_certify='".date('Y-m-d H:i:s')."', mb_email_certify='".date('Y-m-d H:i:s')."'  , mb_photo = '".$_n_image."' , mb_level = '".$_level."' , mb_sex = '".$_gender."' , mb_birth = '".$_birth."' , mb_hp = '".$_hp."' , mb_point = '".$_set_point."'  , mb_today_login = '".date('Y-m-d H:i:s')."'  , mb_login_ip = '".$_SERVER['REMOTE_ADDR']."'  , mb_datetime = '".date('Y-m-d H:i:s')."' , mb_ip = '".$_SERVER['REMOTE_ADDR']."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("Naver 회원 정보 생성에 문제가 발생했습니다. ---" );
    }
}

function Record_create_point_info($_mb_id, $_set_point) {
    global $tkher;
    $timestamp = strtotime("+3 years"); // 3년 뒤 시간

    $query = " INSERT {$tkher['point_table']} SET mb_id = '".$_mb_id."' , po_datetime = '".date('Y-m-d H:i:s')."' , po_title = '".date('Y-m-d')."' , po_content = '".date('Y-m-d')." create_member' , po_point = '".$_set_point."' , po_expire_date = '".date('Y-m-d H:i:s', $timestamp)."' , po_mb_point = '".$_set_point."' , po_rel_table = '@login' , po_rel_id = '".$_mb_id."' , po_rel_action = '".date('Y-m-d')."' ";
    $ret=sql_query($query);
    if(!$ret) {
        m_("포인트 지급에 문제가 발생했습니다. ---".$query);
    }
}

function Record_update_google($_g_email, $_g_fullname, $_g_image) {
    global $tkher;
    global $config;
        
        // 계정 정보 업데이트
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
            m_("회원 정보 업데이트에 문제가 발생했습니다. ---".$query);
        }
}

function Record_update_kakao($_k_email, $_k_nickname, $_k_image) {
    global $tkher;
    global $config;
        
        // 계정 정보 업데이트
        $query = " UPDATE {$tkher['tkher_member_table']} SET  "; 

        if(Change_nick_check($_k_email, $_k_nickname)) { // 닉네임이 변경 체크
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
            m_("회원 정보 업데이트에 문제가 발생했습니다. ---".$query);
        }
}

function Record_update_naver($_n_email, $_n_name, $_n_nickname, $_n_image, $_hp) {
    global $tkher;
    global $config;
        
        // 계정 정보 업데이트
        $query = " UPDATE {$tkher['tkher_member_table']} SET  "; 

        if(Change_nick_check($_n_email, $_n_nickname)) { // 닉네임이 변경 체크
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
            m_("회원 정보 업데이트에 문제가 발생했습니다. ---".$query);
        }
}

function Change_nick_check($_mb_email, $_nick){ // 닉네임 변경 체크
    global $tkher;
    $SQL = " select mb_nick from {$tkher['tkher_member_table']} where mb_email = '".$_mb_email."' ";
	$result = sql_query($SQL);
    $row = sql_fetch_array($result);

    if($row['mb_nick'] == $_nick) return false;
    else return true;
}

/* function Check_today_login($_mb_id) { // 당일 첫 로그인 체크 // tkher_start_necessary.php 중복
    global $tkher;
    $SQL = " select mb_today_login from {$tkher['tkher_member_table']} where mb_id = '".$_mb_id."' ";  
	$result = sql_query($SQL);
	$row = sql_fetch_array($result);

	if(substr($row['mb_today_login'], 0, 10) != date("Y-m-d")) return true;
    else return false;
} */

/* function Record_create_log_info($_mb_id){
    global $tkher;
    $kapp_host = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']; // modumodu.net
    $H_ID_IPADDR = $kapp_host . "_" . $_mb_id . "_" . $_SERVER['REMOTE_ADDR']; // modumodu.net_ksd39673976@gmail.com_172.31.9.255
    $referer = $kapp_host . " : " . $H_ID_IPADDR; // modumodu.net : modumodu.net_ksd39673976@gmail.com_172.31.9.255

    //m_($referer);

    if( isset($_SERVER['HTTP_REFERER'])) $referer = escape_trim(clean_xss_tags($_SERVER['HTTP_REFERER'])). " : " . $H_ID_IPADDR; // https://modumodu.net/kapp/index.php?go_url=./index.php : modumodu.net_ksd39673976@gmail.com_172.31.9.255
    $user_agent  = escape_trim(clean_xss_tags($_SERVER['HTTP_USER_AGENT'])); // $_SERVER['HTTP_USER_AGENT']; // user_agent : Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36
    $vi_browser = '';
    $vi_os = '';
    $vi_device = $H_ID_IPADDR;
    $sql = " INSERT {$tkher['visit_table']} ( vi_ip, vi_date, vi_time, vi_referer, vi_agent, vi_browser, vi_os, vi_device ) values ('{$remote_addr}', '".KAPP_TIME_YMD."', '".KAPP_TIME_HIS."', '{$referer}', '{$user_agent}', '{$vi_browser}', '{$vi_os}', '{$vi_device}' ) ";

    $result = sql_query( $sql );

    //m_("sql : ".$sql);
} */

/* function getJsonText($jsontext) { // jsonText '\' 값 제거 
    return str_replace("\\\"", "\"", $jsontext);
    } */

function get_Number_K($_number){
    return str_replace("-", "", $_number);
}

?>