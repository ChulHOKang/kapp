<?php
	include_once('./tkher_start_necessary.php');
	include_once('./include/lib/tkher_register.lib.php');
	//include_once('./include/lib/PHPMailer/PHPMailerAutoload.php');

	referer_check_url(); // my_func

	if( !($w == '' || $w == 'u')) {
		m_('w error');//값이 제대로 넘어오지 않았습니다.
	}
	if( $w == 'u')
		$mb_id = isset($_SESSION['ss_mb_id']) ? trim($_SESSION['ss_mb_id']) : '';
	else if( $w == '' )
		$mb_id = trim($_POST['mb_id']);
	else {
		m_('The wrong approach.'); exit; //, 잘못된 접근입니다' 
	}
	if( !$mb_id) {
		m_('There is no member ID value. Please use it in the correct way.'); //, 회원아이디 값이 없습니다. 올바른 방법으로 이용해 주십시오.
		exit;
	}

$mb_password    = isset($_POST['mb_password']) ? trim($_POST['mb_password']) : "";
$mb_password_re = isset($_POST['mb_password_re']) ? trim($_POST['mb_password_re']) : "";
$mb_name    = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : "";
$mb_nick    = isset($_POST['mb_nick']) ? trim($_POST['mb_nick']) : "";
$mb_email   = isset($_POST['mb_email']) ? trim($_POST['mb_email']) : "";

$mb_mailling= isset($_POST['mb_mailling'])      ? trim($_POST['mb_mailling'])    : "";
$mb_sms     = isset($_POST['mb_sms'])           ? trim($_POST['mb_sms'])         : "";

if(!isset($mb_sms) || $mb_sms == '') $mb_sms = 0; // 비어있을 때 0 저장
$mb_recommend   = isset($_POST['mb_recommend'])     ? trim($_POST['mb_recommend'])   : "";


$mb_name        = clean_xss_tags($mb_name);
$mb_email       = get_email_address($mb_email);


$mb_sex         = isset($_POST['mb_sex'])           ? trim($_POST['mb_sex'])         : "";
$mb_birth       = isset($_POST['mb_birth'])         ? trim($_POST['mb_birth'])       : "";
$mb_homepage    = isset($_POST['mb_homepage'])      ? trim($_POST['mb_homepage'])    : "";
$mb_tel         = isset($_POST['mb_tel'])           ? trim($_POST['mb_tel'])         : "";
$mb_hp          = isset($_POST['mb_hp'])            ? trim($_POST['mb_hp'])          : "";
$mb_zip1        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 0, 3) : "";
$mb_zip2        = isset($_POST['mb_zip'])           ? substr(trim($_POST['mb_zip']), 3)    : "";
$mb_addr1       = isset($_POST['mb_addr1'])         ? trim($_POST['mb_addr1'])       : "";
$mb_addr2       = isset($_POST['mb_addr2'])         ? trim($_POST['mb_addr2'])       : "";
$mb_addr3       = isset($_POST['mb_addr3'])         ? trim($_POST['mb_addr3'])       : "";
$mb_addr_jibeon = isset($_POST['mb_addr_jibeon'])   ? trim($_POST['mb_addr_jibeon']) : "";
$mb_signature   = isset($_POST['mb_signature'])     ? trim($_POST['mb_signature'])   : "";
$mb_profile     = isset($_POST['mb_profile'])       ? trim($_POST['mb_profile'])     : "";
if(!isset($mb_open) || $mb_open == '') $mb_open = 0; // 비어있을 때 0 저장

/*
$mb_homepage    = clean_xss_tags($mb_homepage);
$mb_tel         = clean_xss_tags($mb_tel);
$mb_zip1        = preg_replace('/[^0-9]/', '', $mb_zip1);
$mb_zip2        = preg_replace('/[^0-9]/', '', $mb_zip2);
$mb_addr1       = clean_xss_tags($mb_addr1);
$mb_addr2       = clean_xss_tags($mb_addr2);
$mb_addr3       = clean_xss_tags($mb_addr3);
$mb_addr_jibeon = preg_match("/^(N|R)$/", $mb_addr_jibeon) ? $mb_addr_jibeon : '';
*/
if( $w == '' || $w == 'u') {
    if( $msg = empty_mb_id($mb_id)) { m_($msg ); exit; }   // m_($msg, $url, $error, $post);
    if( $msg = valid_mb_id($mb_id)) { m_($msg ); exit; }
    if( $msg = count_mb_id($mb_id)) { m_($msg ); exit; }
    // 이름, 닉네임에 utf-8 이외의 문자가 포함됐다면 오류
    // 서버환경에 따라 정상적으로 체크되지 않을 수 있음.
    $tmp_mb_name = iconv('UTF-8', 'UTF-8//IGNORE', $mb_name);
    if( $tmp_mb_name != $mb_name) {
        m_('Please enter the correct name.');// , 이름을 올바르게 입력해 주십시오.
		 exit;
    }
    $tmp_mb_nick = iconv('UTF-8', 'UTF-8//IGNORE', $mb_nick);
    if( $tmp_mb_nick != $mb_nick) {
        m_('Please enter your nickname correctly.'); //, 닉네임을 올바르게 입력해 주십시오.
		 exit;
    }

    if( $w == '' && !$mb_password) {
        m_('The password has not been exceeded.'); //, 비밀번호가 넘어오지 않았습니다.
		exit;
	}
    if( $w == '' && $mb_password != $mb_password_re) {
        m_('Passwords do not match.'); //, 비밀번호가 일치하지 않습니다.
		exit;
	}
    if( $msg = empty_mb_name($mb_name))     { m_($msg ); exit; }
    if( $msg = empty_mb_nick($mb_nick))     { m_($msg ); exit; }
    if( $msg = empty_mb_email($mb_email))   { m_($msg ); exit; }
    if( $msg = reserve_mb_id($mb_id))       { m_($msg ); exit; }
    if( $msg = reserve_mb_nick($mb_nick))   { m_($msg ); exit; }
    //if( $msg = valid_mb_name($mb_name))   { m_($msg ); exit; } // 이름에 한글명 체크를 하지 않는다.
    if( $msg = valid_mb_nick($mb_nick))     { m_($msg ); exit; }
    if( $msg = valid_mb_email($mb_email))   { m_($msg ); exit; }
    if( $msg = prohibit_mb_email($mb_email)) { m_($msg ); exit; }
    if(( $config['kapp_use_hp'] || $config['kapp_cert_hp']) && $config['kapp_req_hp']) {  // 휴대폰 필수입력일 경우 휴대폰번호 유효성 체크
        if ($msg = valid_mb_hp($mb_hp)) { m_($msg ); exit; }
    }
    if( $w=='u') { //- 2024-5-02 change
        if( $msg = exist_mb_id($mb_id)) { m_($msg ); exit; }
		$ss_mb_id		= $_SESSION['ss_mb_id'];
		$ss_mb_nick	= $_SESSION['ss_mb_nick'];
		$ss_mb_email	= $_SESSION['ss_mb_email'];

		if( $ss_mb_id != $mb_id || $ss_mb_nick != $mb_nick || $ss_mb_email != $mb_email) {
			m_("mb_id:$mb_id, ss_mb_id:$ss_mb_id ,  mb_nick:$mb_nick, ss_mb_nick:$ss_mb_nick , mb_email:$mb_email, ss_mb_email:$ss_mb_email ");
			//mb_id:solpakan89, ss_mb_id: ,  mb_nick:태양새, ss_mb_nick: , mb_email:solpakan89@gmail.com, ss_mb_email: 
			$_SESSION['ss_mb_id']		='';
			$_SESSION['ss_mb_nick']	='';
			$_SESSION['ss_mb_email']	='';
            m_('Please use it in the right way.'); //, 올바른 방법으로 이용해 주십시오!!!
			exit;
        }
        if( $config['kapp_use_recommend'] && $mb_recommend) {
            if( !exist_mb_id($mb_recommend)) {
                m_("No referrer exists."); //, 추천인이 존재하지 않습니다.
				exit;
			}
        }
        if( strtolower($mb_id) == strtolower($mb_recommend)) {
            m_('I can not recommend you.'); //, 본인을 추천할 수 없습니다.
        }
    }
	/*else { // 자바스크립트로 정보변경이 가능한 버그 수정 // 닉네임수정일이 지나지 않았다면
        if( $member['mb_nick_date'] > date("Y-m-d", KAPP_SERVER_TIME - ($config['kapp_nick_modify'] * 86400)))
            $mb_nick = $member['mb_nick'];
        $old_email = $member['mb_email']; // 회원정보의 메일을 이전 메일로 옮기고 아래에서 비교함
    }*/
    /* if( $msg = exist_mb_nick($mb_nick, $mb_id))   { m_($msg ); exit; }
    if( $msg = exist_mb_email($mb_email, $mb_id)) { m_($msg ); exit; } */
}

/*
//===============================================================
//  본인확인
//---------------------------------------------------------------
$mb_hp = hyphen_hp_number($mb_hp);
if( $config['kapp_cert_use'] && $_SESSION['ss_cert_type'] && $_SESSION['ss_cert_dupinfo']) {
    // 중복체크
    $sql = " select mb_id from {$tkher['tkher_member_table']} where mb_id <> '{$member['mb_id']}' and mb_dupinfo = '{$_SESSION['ss_cert_dupinfo']}' ";
    $row = sql_fetch($sql);
    if( $row['mb_id']) {
        m_("There is a subscription with the identification information you have entered. id:".$row['mb_id']);
		//, 입력하신 본인확인 정보로 가입된 내역이 존재합니다.\\n회원아이디 : 
    }
}
$sql_certify = '';
$md5_cert_no = $_SESSION['ss_cert_no'];
$cert_type = $_SESSION['ss_cert_type'];
if( $config['kapp_cert_use'] && $cert_type && $md5_cert_no) { // 해시값이 같은 경우에만 본인확인 값을 저장한다.
    if( $_SESSION['ss_cert_hash'] == md5($mb_name.$cert_type.$_SESSION['ss_cert_birth'].$md5_cert_no)) {
        $sql_certify .= " , mb_hp = '{$mb_hp}' ";
        $sql_certify .= " , mb_certify  = '{$cert_type}' ";
        $sql_certify .= " , mb_adult = '{$_SESSION['ss_cert_adult']}' ";
        $sql_certify .= " , mb_birth = '{$_SESSION['ss_cert_birth']}' ";
        $sql_certify .= " , mb_sex = '{$_SESSION['ss_cert_sex']}' ";
        $sql_certify .= " , mb_dupinfo = '{$_SESSION['ss_cert_dupinfo']}' ";
        if( $w == 'u' )
            $sql_certify .= " , mb_name = '{$mb_name}' ";
    } else {
        $sql_certify .= " , mb_hp = '{$mb_hp}' ";
        $sql_certify .= " , mb_certify  = '' ";
        $sql_certify .= " , mb_adult = 0 ";
        $sql_certify .= " , mb_birth = '' ";
        $sql_certify .= " , mb_sex = '' ";
    }
} else {
    if( get_session("ss_reg_mb_name") != $mb_name || get_session("ss_reg_mb_hp") != $mb_hp) {
        $sql_certify .= " , mb_hp = '{$mb_hp}' ";
        $sql_certify .= " , mb_certify = '' ";
        $sql_certify .= " , mb_adult = 0 ";
        $sql_certify .= " , mb_birth = '' ";
        $sql_certify .= " , mb_sex = '' ";
    }
}*/
if( $w == '') {

		//$sql = " insert into {$tkher['tkher_member_table']} set mb_id = '{$mb_id}', mb_password = '".get_encrypt_stringA($mb_password)."', mb_name = '{$mb_name}', mb_nick = '{$mb_nick}', mb_nick_date = '".KAPP_TIME_YMD."', mb_email = '{$mb_email}', mb_homepage = '{$mb_homepage}', mb_tel = '{$mb_tel}', mb_zip1 = '{$mb_zip1}', mb_zip2 = '{$mb_zip2}', mb_addr1 = '{$mb_addr1}', mb_addr2 = '{$mb_addr2}', mb_addr3 = '{$mb_addr3}', mb_addr_jibeon = '{$mb_addr_jibeon}', mb_signature = '{$mb_signature}', mb_profile = '{$mb_profile}', mb_today_login = '".KAPP_TIME_YMDHIS."', mb_datetime = '".KAPP_TIME_YMDHIS."', mb_ip = '{$_SERVER['REMOTE_ADDR']}', mb_level = '{$config['kapp_register_level']}', mb_recommend = '{$mb_recommend}', mb_login_ip = '{$_SERVER['REMOTE_ADDR']}', mb_mailling = '{$mb_mailling}', mb_sms = '{$mb_sms}', mb_open = '{$mb_open}', mb_open_date = '".KAPP_TIME_YMD."' {$sql_certify} ";
		
		$sql = " insert into {$tkher['tkher_member_table']} set mb_id = '{$mb_id}', mb_password = '".get_encrypt_stringA($mb_password)."', mb_name = '{$mb_name}', mb_nick = '{$mb_nick}', mb_nick_date = '".KAPP_TIME_YMD."', mb_email_certify = '".KAPP_TIME_YMDHIS."', mb_email = '{$mb_email}', mb_today_login = '".KAPP_TIME_YMDHIS."', mb_datetime = '".KAPP_TIME_YMDHIS."', mb_ip = '{$_SERVER['REMOTE_ADDR']}', mb_level = '$_POST[mb_level]', mb_sn = 'SignUp', mb_recommend = '{$mb_recommend}', mb_login_ip = '{$_SERVER['REMOTE_ADDR']}', mb_mailling = '{$mb_mailling}', mb_sms = '{$mb_sms}' {$sql_certify} ";

		$jtree_dir = KAPP_PATH_T_ . "/file/". $mb_id;   //print_r($sql);  //m_("sql : ".$sql);     //exit;
		if( !is_dir($jtree_dir) ) {
			if( !@mkdir( $jtree_dir, 0755 ) ) {
				echo " Error: $jtree_dir : " . $mb_id . " Failed to create directory."; //, 디렉토리를 생성하지 못했습니다. 
			}
			/*else{
					$xxfile = KAPP_URL_T_ . "/" . $mb_id ."/index.php";
					$ft = fopen("$xxfile","w+");
					fwrite($ft,"<html> \r\n");
					fwrite($ft,"<head> \r\n");
					fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
					fwrite($ft,"<TITLE>Tkher system for special her. Tkher system is generator program.   Made in ChulHo Kang</TITLE>  \r\n");
					fwrite($ft,"<link rel='shortcut icon' href='./logo/logo25a.jpg'> \r\n");
					fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
					fwrite($ft,"<meta name='keywords' content='kapp,k-app, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
					fwrite($ft,"<meta name='description' content='kapp, k-app,web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
					fwrite($ft,"<meta name='robots' content='ALL'> \r\n");
					fwrite($ft,"</head> \r\n");
					fwrite($ft,"	<frameset rows=1*> \r\n");
					fwrite($ft,"	<frame name=TKHER src='./my/?mid=".$mb_id."' > \r\n");
					fwrite($ft,"	</frameset> \r\n");
					fwrite($ft,"</html>\r\n");
					fwrite($ft,"\r\n");
					fclose($ft);
			}*/
		} else {
			m_("dir:$jtree_dir");
		}
		$r =sql_query($sql);
		if(!$r){
            //m_("KAPP_TIME_YMDHIS : ".KAPP_TIME_YMDHIS);
            echo "<script language='javascript'>alert('FAILED : You have not registered normally.'); </script>"; //정상적으로 등록 하지 않았습니다.
            m_("sql : ".$r); exit;
        }else{
            echo "<script language='javascript'>alert('SUCCES : Registration has been processed normally.');</script>";//정상적으로 등록 처리 되었습니다.
			//set_session('ss_mb_id', $mb_id);
			//set_session('ss_mb_nick', $mb_nick);
			//set_session('ss_mb_email', $mb_email);
			//set_session('ss_mb_reg', $mb_id);
        }

    //exit; // Test

    // 회원가입 포인트 부여
    insert_point_app( $mb_id, $config['kapp_register_point'], 'Sign up congratulations', '@member', $mb_id, 'Sign Up');//회원가입 축하, 회원가입
    // 추천인에게 포인트 부여
    if( $config['kapp_use_recommend'] && $mb_recommend){
        insert_point_app($mb_recommend, $config['kapp_recommend_point'], $mb_id.'of recommender', '@member', $mb_recommend, $mb_id.' suggestion');// 추천인,추천
	}
	/*
	// 회원님께 메일 발송
    if( $config['kapp_email_mb_member']) {
        $subject = '['.$config['kapp_title'].'] Congratulations on your membership. ';//회원가입을 축하드립니다.
        // 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용
        if ($config['kapp_use_email_certify']) {
            $mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand()));
            sql_query(" update {$tkher['tkher_member_table']} set mb_email_certify2 = '$mb_md5' where mb_id = '$mb_id' ");
            $certify_href = KAPP_URL_T_ . '/tkher_email_certify.php?mb_id='.$mb_id.'&amp;mb_md5='.$mb_md5;
        }
        
		ob_start();
        include_once ('./tkher_register_form_update_mail1.php');
        $content = ob_get_contents();
        ob_end_clean();
		//ob_end_flush();
        //mailer($config['kapp_admin_email_name'], $config['kapp_admin_email'], $mb_email, $subject, $content, 1);
		$anm	=$config['kapp_admin_email_name'];
		$aemail	=$config['kapp_admin_email'];
        gmail($anm, $aemail, $mb_name, $mb_email, $subject, $content, 1);	 // my_func에설정.
		// tkher_gmail($anm, $aemail, $mb_name, $mb_email, $subject, $content, 1);	 // my_func에설정.
        // 메일인증을 사용하는 경우 가입메일에 인증 url이 있으므로 인증메일을 다시 발송되지 않도록 함
        if( $config['kapp_use_email_certify']) $old_email = $mb_email;
		
    }
    // 최고관리자님께 메일 발송
    if( $config['kapp_email_mb_super_admin']) {
        $subject = '['.$config['kapp_title'].'] '.$mb_nick .' You have registered as a member.'; //회원으로 가입하셨습니다.
        ob_start();
        include_once ('./tkher_register_form_update_mail2.php');
        $content = ob_get_contents();
        ob_end_clean();
		//ob_end_flush();
        //mailer($mb_nick, $mb_email, $config['kapp_admin_email'], $subject, $content, 1);
		$anm=$config['kapp_admin_email_name']; //"TkHer";//
		$aemail=$config['kapp_admin_email'];	//"solpakan89@gmail.com";//$config['kapp_admin_email'];
		// tkher_gmail($anm, $aemail, $anm, $aemail, $subject, $content, 1);	// my_func에설정.
        gmail($anm, $aemail, $anm, $aemail, $subject, $content, 1);	// my_func에설정.
    }*/
    // 메일인증 사용하지 않는 경우에만 로그인 //if( !$config['kapp_use_email_certify']) set_session('ss_mb_id', $mb_id);
}
/*
else if ($w == 'u') {
    if (!trim($_SESSION['ss_mb_id']))
        m_('You are not logged in.'); //, 로그인 되어 있지 않습니다.
    if (trim($_POST['mb_id']) != $mb_id)
        m_("The information you are trying to edit and the information you want to edit are not correct and can not be edited. ");
		//로그인된 정보와 수정하려는 정보가 틀리므로 수정할 수 없습니다.\\n만약 올바르지 않은 방법을 사용하신다면 바로 중지하여 주십시오.
    $sql_password = "";
    if ($mb_password)
        $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";
    $sql_nick_date = "";
    if ($mb_nick_default != $mb_nick)
        $sql_nick_date =  " , mb_nick_date = '".KAPP_TIME_YMD."' ";
    $sql_open_date = "";
    if ($mb_open_default != $mb_open)
        $sql_open_date =  " , mb_open_date = '".KAPP_TIME_YMD."' ";
    // 이전 메일주소와 수정한 메일주소가 틀리다면 인증을 다시 해야하므로 값을 삭제
    $sql_email_certify = '';
    if ($old_email != $mb_email && $config['kapp_use_email_certify'])
        $sql_email_certify = " , mb_email_certify = '' ";
    $sql = " update {$tkher['tkher_member_table']}
                set mb_nick = '{$mb_nick}',
                    mb_mailling = '{$mb_mailling}',
                    mb_sms = '{$mb_sms}',
                    mb_open = '{$mb_open}',
                    mb_email = '{$mb_email}',
                    mb_homepage = '{$mb_homepage}',
                    mb_tel = '{$mb_tel}',
                    mb_zip1 = '{$mb_zip1}',
                    mb_zip2 = '{$mb_zip2}',
                    mb_addr1 = '{$mb_addr1}',
                    mb_addr2 = '{$mb_addr2}',
                    mb_addr3 = '{$mb_addr3}',
                    mb_addr_jibeon = '{$mb_addr_jibeon}',
                    mb_signature = '{$mb_signature}',
                    mb_profile = '{$mb_profile}',
                    mb_1 = '{$mb_1}',
                    mb_2 = '{$mb_2}',
                    mb_3 = '{$mb_3}',
                    mb_4 = '{$mb_4}',
                    mb_5 = '{$mb_5}',
                    mb_6 = '{$mb_6}',
                    mb_7 = '{$mb_7}',
                    mb_8 = '{$mb_8}',
                    mb_9 = '{$mb_9}',
                    mb_10 = '{$mb_10}'
                    {$sql_password}
                    {$sql_nick_date}
                    {$sql_open_date}
                    {$sql_email_certify}
                    {$sql_certify}
              where mb_id = '$mb_id' ";
    sql_query($sql);
}
// 인증메일 발송  메일이 변경후 다를때...
if( $config['kapp_use_email_certify'] && $old_email != $mb_email) {
    $subject = '['.$config['kapp_title'].'] LinkCoin! Verification email.'; // 인증확인 메일입니다.
    // 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용
    $mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand()));
    sql_query(" update {$tkher['tkher_member_table']} set mb_email_certify2 = '$mb_md5' where mb_id = '$mb_id' ");
    $certify_href = KAPP_URL_T_ . '/tkher_email_certify.php?mb_id='.$mb_id.'&amp;mb_md5='.$mb_md5;
    ob_start();
    include_once ('./tkher_register_form_update_mail3.php');
    $content = ob_get_contents();
    ob_end_clean();
	gmail($config['kapp_admin_email_name'], $config['kapp_admin_email'], $mb_name, $mb_email, $subject, $content, 1);
}
*/
if( $w == '') {
    //m_("result");
	set_session('ss_mb_reg', $mb_id);
	echo("<meta http-equiv='refresh' content='0; URL=tkher_register_result_.php'>");
	exit;
}
/*
else if ($w == 'u') {
    $row  = sql_fetch(" select mb_password from {$tkher['tkher_member_table']} where mb_id = '{$member['mb_id']}' ");
    $tmp_password = $row['mb_password'];
    if ($old_email != $mb_email && $config['kapp_use_email_certify']) {
        set_session('ss_mb_id', '');
        m_('Member information has been modified.\n\nE-mail address has been changed, so you must re-authenticate.');
		// 회원 정보가 수정 되었습니다.\n\nE-mail 주소가 변경되었으므로 다시 인증하셔야 합니다.
    } else {
        echo '
        <!doctype html>
        <head>
        <meta charset="utf-8">
        <title>Edit membership information</title>
        <body>
        <form name="fregisterupdate" method="post" action="./register_form_.php">
        <input type="hidden" name="w" value="u">
        <input type="hidden" name="mb_id" value="'.$mb_id.'">
        <input type="hidden" name="mb_password" value="'.$tmp_password.'">
        <input type="hidden" name="is_update" value="1">
        </form>
        <script>
        alert("Membership information has been modified.");
        document.fregisterupdate.submit();
        </script>
        </body>
        </html>';
    }
}*/
?>