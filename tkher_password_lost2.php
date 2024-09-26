<?php
include_once('./_common.php');
include_once('./kcaptcha/kcaptcha.lib.php');
//include_once(G5_LIB_PATH.'/mailer.lib.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../cratree/func/PHPMailer/Exception.php';
	require '../cratree/func/PHPMailer/PHPMailer.php';
	require '../cratree/func/PHPMailer/SMTP.php';
	include_once('../cratree/func/my_func.php');

if ($is_member) {
    alert('You are already signed in. \\n 이미 로그인중입니다.');
}

if (!chk_captcha()) {
    alert('Prevent auto enrollment The number is incorrect. \\n 자동등록방지 숫자가 틀렸습니다.');
}

$email = trim($_POST['mb_email']);

if (!$email)
    alert_close('Email address error. \\n 메일주소 오류입니다.');

$sql = " select count(*) as cnt from {$tkher['tkher_member_table']} where mb_email = '$email' ";
$row = sql_fetch($sql);
if ($row['cnt'] > 1)
    alert('More than one email address exists. \\n 동일한 메일주소가 2개 이상 존재합니다. ');

$sql = " select mb_no, mb_id, mb_name, mb_nick, mb_email, mb_datetime from {$tkher['tkher_member_table']} where mb_email = '$email' ";
$mb  = sql_fetch($sql);

if (!$mb['mb_id'])
    alert('This member does not exist. \\n 존재하지 않는 회원입니다.');
else if (is_admin($mb['mb_id']))
    alert('The administrator ID is inaccessible. \\n 관리자 아이디는 접근 불가합니다.');

// 임시비밀번호 발급
$change_password = rand(100000, 999999);
$mb_lost_certify = get_encrypt_string($change_password);

// 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용
$mb_nonce = md5(pack('V*', rand(), rand(), rand(), rand()));

// 임시비밀번호와 난수를 mb_lost_certify 필드에 저장
$sql = " update {$tkher['tkher_member_table']} set mb_lost_certify = '$mb_nonce $mb_lost_certify' where mb_id = '{$mb['mb_id']}' ";
sql_query($sql);

// 인증 링크 생성
$href = './tkher_password_lost_certify.php?mb_no='.$mb['mb_no'].'&amp;mb_nonce='.$mb_nonce;
$ttt = $config['kapp_title'];
$subject = "[".$config['kapp_title']."] I am looking for the information of finding the requested member information. <br> (요청하신 회원정보 찾기 안내 메일입니다.)";

$day = date("Y-m-d H:i:s");
$content = "";

$content .= '<div style="margin:30px auto;width:600px;border:10px solid #f7f7f7">';
$content .= '<div style="border:1px solid #dedede">';
$content .= '<h1 style="padding:30px 30px 0;background:#f7f7f7;color:#555;font-size:1.4em">';
$content .= 'Find Member Information (회원정보 찾기 안내)';
$content .= '</h1>';
$content .= '<span style="display:block;padding:10px 30px 30px;background:#f7f7f7;text-align:right">';
$content .= '<a href="/" target="_blank">'.$config['kapp_title'].'</a>';
$content .= '</span>';
$content .= '<p style="margin:20px 0 0;padding:30px 30px 30px;border-bottom:1px solid #eee;line-height:1.7em">';
$content .= addslashes($mb['mb_name'])." (".addslashes($mb['mb_nick']).")"." 회원님은 " . $day . " 에 회원정보 찾기 요청을 하셨습니다.<br>";
$content .= ' We are guiding you through creating a new password. <br> 새로운 비밀번호를 생성하여 안내 해드리고 있습니다.<br>';
$content .= 'After confirming the password to be changed below, <span style="color:#ff3061"><strong>Change Password(비밀번호 변경)</strong> Click the link.(링크를 클릭 하십시오.)</span><br>';
$content .= '아래에서 변경될 비밀번호를 확인하신 후, <span style="color:#ff3061"><strong>비밀번호 변경</strong> 링크를 클릭 하십시오.</span><br>';

$content .= ' Enter the changed password and log in. <br>';
$content .= '변경된 비밀번호를 입력하시고 로그인 하십시오.<br>';

$content .= 'After logging in, please change to the new password in the Edit Information menu.<br>';
$content .= '로그인 후에는 정보수정 메뉴에서 새로운 비밀번호로 변경해 주십시오.';
$content .= '</p>';
$content .= '<p style="margin:0;padding:30px 30px 30px;border-bottom:1px solid #eee;line-height:1.7em">';
$content .= '<span style="display:inline-block;width:100px">ID</span> '.$mb['mb_id'].'<br>';
$content .= '<span style="display:inline-block;width:100px">Password to be changed(변경될 비밀번호)</span> <strong style="color:#ff3061">'.$change_password.'</strong>';
$content .= '</p>';
$content .= '<a href="'.$href.'" target="_blank" style="display:block;padding:30px 0;background:#484848;color:#fff;text-decoration:none;text-align:center">Change Password(비밀번호 변경)</a>';
$content .= '</div>';
$content .= '</div>';


//		mailer($config['kapp_admin_email_name'], $config['kapp_admin_email'], $mb['mb_email'], $subject, $content, 1);

//$sql = " SELECT * from g5_config ";
//$cf  = sql_fetch($sql);

//		$anm	= $config['kapp_admin_email_name'];
		$anm="TkHer";//$config['kapp_admin_email_name'];
		$aemail	= $config['kapp_admin_email'];
//		$aemail	= $cf['cf_admin_email'];
		$mb_email = $mb['mb_email'];
		$mb_name  = $mb['mb_name'];
        gmail($anm, $aemail, $mb_name, $mb_email, $subject, $content, 1);
		//my_msg("nm:$anm, $aemail, $mb_name, $mb_email, ttt:$ttt ");
		//nm:TkHer, solpakan89@gmail.com, naverkang, solpakan@naver.com, ttt:TkHer 
		//nm:TkHer, solpakan89@gmail.com, naverkang, solpakan@naver.com, ttt:TkHer 
		//nm:TkHer, solpakan89@gmail.com, naverkang, solpakan@naver.com, ttt:TkHer 

//		$aemail=$config['kapp_admin_email'];	//"solpakan89@gmail.com";//$config['kapp_admin_email'];
		alert_close($email.' Your message has been sent. \\n Please check your e-mail. \\n 메일이 발송 되었습니다. \\n 메일을 확인하여 주십시오.');

		gmail($mb_name, $mb_email, $anm, $aemail, $subject, $content, 1);	// 관리자에게... my_func에설정. 

?>
 