<?php
	include_once('./tkher_start_necessary.php');
?>
<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>KAPP is App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
    <link rel="shortcut icon" href="./logo/logo25a.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">

    <link rel="stylesheet" href="./include/css/common.css" type="text/css" />
    <script type="text/javascript" src="./include/js/ui.js"></script>
    <script type="text/javascript" src="./include/js/common.js"></script>

    <?php
    
	//if($config['kapp_add_meta'])    echo $config['kapp_add_meta'].PHP_EOL;

    $shuffled_str   =str_shuffle($strT); // $strT - my_func - 자동등록 방지.
	$auto_char_func =substr($shuffled_str, 0, 6);

include_once('./include/lib/tkher_register.lib.php');

$token = md5(uniqid(rand(), true)); // 불법접근을 막도록 토큰생성
set_session("ss_token", $token);
set_session("ss_cert_no",   "");
set_session("ss_cert_hash", "");
set_session("ss_cert_type", "");

if( isset($_POST['w']) ) $w = $_POST['w'];
else $w ='';
if( $w == "") {

    referer_check();	//m_(" token:$token");	// token:974933f5a49b6bb620fc167f471e4ce4

	if( isset($_POST['agree']))   $agree = $_POST['agree'];
	else $agree = '';
	if( isset($_POST['agree2']))  $agree2 = $_POST['agree2'];
	else $agree2 = '';

    $url = KAPP_URL;
    if( !$agree ) {
        echo "alert('You must be signed in to the membership agreement before you can join.', KAPP_URL_T_ . '/tkher_register_.php');";
		echo "<script>window.open( '$url/tkher_register_.php' , '_self', ''); </script>"; // 회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.!
    }

    if( !$agree2 ) {
        alert('You must be signed in to the Privacy Policy Guide before you can register.', KAPP_URL_T_ . '/tkher_register_.php');//, \n\n 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.!
		echo "<script>window.open( '$url/tkher_register_.php' , '_self', ''); </script>";
    }

    $agree  = preg_replace('#[^0-9]#', '', $agree);
    $agree2 = preg_replace('#[^0-9]#', '', $agree2);

    $member['mb_birth'] = '';
    $member['mb_sex']   = '';
    $member['mb_name']  = '';

	if( isset($_POST['birth']))    $member['mb_birth'] = $_POST['birth'];
    if( isset($_POST['sex']))      $member['mb_sex']   = $_POST['sex'];
    if( isset($_POST['mb_name']))  $member['mb_name']  = $_POST['mb_name'];
    if( isset($_POST['mb_email'])) $member['mb_email'] =  $_POST['mb_email'];
    
    $tkher['title'] = 'Sign Up';// (회원 가입)

} else if( $w == 'u') {

    if( $is_admin)
        alert('Please edit the members information on the administrator screen.', '/');
		//, 관리자의 회원정보는 관리자 화면에서 수정해 주십시오.

    if( !$is_member)
        alert('Please login and use.', '/');

    if( $member['mb_id'] != $_POST['mb_id'])
        alert('The logged in member has different information.');// 로그인된 회원과 넘어온 정보가 서로 다릅니다.
    /*
    if (!($member[mb_password] == sql_password($_POST[mb_password]) && $_POST[mb_password]))
        alert("비밀번호가 틀립니다.");

    // 수정 후 다시 이 폼으로 돌아오기 위해 임시로 저장해 놓음
    set_session("ss_tmp_password", $_POST[mb_password]);
    */

    if( isset($_POST['mb_password']) ) {
        // 수정된 정보를 업데이트후 되돌아 온것이라면 비밀번호가 암호화 된채로 넘어온것임
        if( $_POST['is_update'])
            $tmp_password = $_POST['mb_password'];
        else
            $tmp_password = get_encrypt_string( $_POST['mb_password']);

        if( $member['mb_password'] != $tmp_password)
            alert('The password is incorrect.');
    }

    $tkher['title'] = 'Edit membership information';//: 회원 정보 수정

    set_session("ss_reg_mb_name", $member['mb_name']);
    set_session("ss_reg_mb_hp", $member['mb_hp']);

    $member['mb_email']       = get_text($member['mb_email']);
    $member['mb_homepage']    = get_text($member['mb_homepage']);
    $member['mb_birth']       = get_text($member['mb_birth']);
    $member['mb_tel']         = get_text($member['mb_tel']);
    $member['mb_hp']          = get_text($member['mb_hp']);
    $member['mb_addr1']       = get_text($member['mb_addr1']);
    $member['mb_addr2']       = get_text($member['mb_addr2']);
    $member['mb_signature']   = get_text($member['mb_signature']);
    $member['mb_recommend']   = get_text($member['mb_recommend']);
    $member['mb_profile']     = get_text($member['mb_profile']);
} else {
    m_('w no return');//값이 제대로 넘어오지 않았습니다. // alert -> m_
}

$req_nick = !isset($member['mb_nick_date']) || (isset($member['mb_nick_date']) && $member['mb_nick_date'] <= date("Y-m-d", time() - ($config['kapp_nick_modify'] * 86400)));

$required = ($w=='') ? 'required' : '';
$readonly = ($w=='u') ? 'readonly' : '';
 
$agree  = preg_replace('#[^0-9]#', '', $agree);
$agree2 = preg_replace('#[^0-9]#', '', $agree2);

//----------------------------------------------------------------------------------------
/*
mb_id:laserga0, ss_check_mb_id: ,  mb_nick:laser, ss_check_mb_nick: , mb_email:laserga0@naver.com, ss_check_mb_email: 
*/
// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//-----------------------------------------------------------------------------------------
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
$register_action_url="./tkher_register_form_update_.php";

?>
    <link rel="stylesheet" href="./include/css/style_mb.css">
    <!-- <link rel="stylesheet" href="./include/css/tkher_mobile.css"> -->

    <script>
    // 자바스크립트에서 사용하는 전역변수 선언
    var tkher_url = "<?php echo KAPP_URL ?>";
    var tkher_url_t_ = "<?php echo KAPP_URL_T_ ?>";
    var tkher_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
    var tkher_is_admin = "<?php echo isset($is_admin)?$is_admin:''; ?>";
    var tkher_is_mobile = "<?php echo KAPP_IS_MOBILE ?>";
    var tkher_bo_table = "<?php echo isset($bo_table)?$bo_table:''; ?>";
    var tkher_sca = "<?php echo isset($sca)?$sca:''; ?>";
    var tkher_editor =
        "<?php echo ($config['kapp_editor'] /* && $board['bo_use_dhtml_editor'] */)?$config['kapp_editor']:''; ?>";
    var tkher_cookie_domain = "<?php echo KAPP_COOKIE_DOMAIN ?>";
    <?php if( defined('KAPP_IS_ADMIN')) { ?>
    var tkher_admin_url = "<?php echo KAPP_ADMIN_URL; ?>";
    <?php } ?>
    </script>

    <!-- <script src="./include/js/jquery-1.8.3.min.js"></script>
    <script src="./include/js/jquery.menu.js"></script>
    <script src="./include/js/common.js"></script>
    <script src="./include/js/wrest.js"></script> -->

    <?php
//	m_(" URL : "); // https://modumodu.net/kapp/include/js
	echo '<script src="./include/js/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
//	m_("JS_URL : "); // https://modumodu.net/kapp/include/js

	if( isset($member['mb_certify']) ) $mb_certify = $member['mb_certify'];
	else $mb_certify ='';
?>

    <!-- <script src="<?php echo KAPP_JS_URL ?>/jquery.register_form.js"></script>  -->
    <script src="./include/js/jquery.register_form.js"></script>

    <?php if( $config['kapp_cert_use'] && ($config['kapp_cert_ipin'] || $config['kapp_cert_hp'])) { ?>
    <script src="./include/js/certify.js?v=JS_Ver"></script>
    <?php } ?>

    <div id="logo" align=center style='height:100px;background-color:black;color:white;border:1 solid black'>
        <a href="./"><img src="<?=KAPP_URL_T_?>/logo/logo512-512.png" width=100 title="KAPP"></a>
    </div>

    <div class="mbskin">
        <form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url ?>"
            onsubmit="return fregisterform_submit(this,'<?=$register_action_url?>');" method="post"
            enctype="multipart/form-data" autocomplete="off">
            <!-- w:<?php echo $w ?> -->
            <input type="hidden" name="w" value="<?php echo $w ?>">
            <input type="hidden" name="url" value="<?php echo $urlencode ?>">
            <input type="hidden" name="agree" value="<?php echo $agree ?>">
            <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
            <input type="hidden" name="cert_type" value="<?php echo $mb_certify; ?>">
            <input type="hidden" name="cert_no" value="">
            <input type="hidden" name="mb_level" value="">
            <input type="hidden" name="du_check" value="">
            <?php if (isset($member['mb_sex'])) { ?>
            <input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>">
            <?php } ?>
            <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", KAPP_SERVER_TIME - ($config['kapp_nick_modify'] * 86400))) { 
		// If your nickname has not been modified 닉네임수정일이 지나지 않았다면 ?>
            <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
            <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
            <?php } ?>
            <center>
                <div>
                    <table>
                        <caption><b>사이트 이용정보</b></caption><!-- (사이트 이용정보 입력!) -->
                        <tr>
                            <th scope="row"><label for="reg_mb_id">ID</label></th><!-- 필수 -->
                            <td>
                                <span class="frm_info">More than 8 characters</span><br><!-- (8자이상 입력하세요!)  -->
                                <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id"
                                    class="frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3"
                                    maxlength="30" <?php echo $required ?> <?php echo $readonly ?> onchange="duplicate_input_change()">
                                <span id="msg_mb_id"></span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="reg_mb_email">E-mail</label></th><!-- 필수 -->
                            <td>
                                <?php if ($config['kapp_use_email_certify']) {  ?>
                                <span class="frm_info">
                                    <!-- (발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.!!) -->
                                    <?php if ($w=='') { echo "Members must complete the registration after confirming the contents sent.<br>"; }  ?>
                                    <?php if ($w=='u') { echo "If you change your e-mail address, you need to re-authenticate."; }  ?>
                                    <!-- , E-mail 주소를 변경하시면 다시 인증하셔야 합니다.!! -->
                                </span>
                                <?php }  ?>
                                <input type="hidden" name="old_email"
                                    value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>">
                                <input type="email" name="mb_email"
                                    value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>"
                                    id="reg_mb_email" required class="frm_input email required" size="50"
                                    maxlength="100" onchange="duplicate_input_change()">
                            </td>
                        </tr>
                        <tr>
                            <!-- <strong class="sound_only">필수</strong> -->
                            <th scope="row"><label>Password</label></th>
                            <td><input type="password" name="mb_password" id="reg_mb_password"
                                    class="frm_input <?php echo $required ?>" minlength="3" maxlength="20"
                                    <?php echo $required ?>></td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Password confirm</label></th>
                            <td><input type="password" name="mb_password_re" id="reg_mb_password_re"
                                    class="frm_input <?php echo $required ?>" minlength="3" maxlength="20"
                                    <?php echo $required ?>></td>
                        </tr>

                        <tr>
                            <th scope="row"><label>name</label></th>
                            <td>
                                <input type="text" id="reg_mb_name" name="mb_name"
                                    value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?>
                                    <?php echo $readonly; ?>
                                    class="frm_input <?php echo $required ?> <?php echo $readonly ?>">
                            </td>
                        </tr>

                        <?php if( $req_nick) { ?>
                        <tr>
                            <th scope="row"><label>Nickname</label></th>
                            <td>
                                <span class="frm_info">Hangul 2, English 4 or more<br>
                                    <!-- <br><?php echo (int)$config['kapp_nick_modify'] ?>일 이내에는 변경 할 수 없습니다. -->
                                </span>
                                <input type="hidden" name="mb_nick_default"
                                    value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                                <input type="text" name="mb_nick"
                                    value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>"
                                    id="reg_mb_nick" required class="frm_input required nospace" maxlength="20" onchange="duplicate_input_change()">
                                <span id="msg_mb_nick"></span>
                                <button type="button" onclick="duplicate()">중복확인</button>
                            </td>
                        </tr>
                        <?php } ?>



                        <tr>
                            <th scope="row"><label>Mailing Service</label></th>
                            <td><input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling"
                                    <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?>> I would like to
                                receive mail.
                            </td><!--  (정보 메일을 받겠습니다.) -->
                        </tr>

                        <?php if ($config['kapp_use_hp']) { ?>
                        <tr>
                            <!-- SMS 수신여부 -->
                            <th scope="row"><label for="reg_mb_sms">Receive SMS</label></th>
                            <td>
                                <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms"
                                    <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?>>
                                I will receive a text message on my cell phone.
                            </td><!-- , 휴대폰 문자메세지를 받겠습니다. -->
                        </tr>
                        <?php } ?>

                        <?php if ($w == "" && $config['kapp_use_recommend']) { ?>
                        <tr>
                            <!-- (추천인아이디) -->
                            <th scope="row"><label>Recommend ID <br></label></th>
                            <td><input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input"></td>
                        </tr>
                        <?php } 
						
						//m_("auto_char: ". $auto_char. ", $auto_char_func: " .$auto_char_func);
						?>

                        <input type="hidden" name='auto_char' value='<?=$auto_char_func?>' /><!-- my_func -->
                        <tr>
                            <th scope="row" oncontextmenu='return false' ondragstart='return false'
                                onselectstart='return false'>Prevent autoenrollment</th>
                            <td oncontextmenu='return false' ondragstart='return false' onselectstart='return false'>
                                <br>
                                <?php echo captcha_html_func($auto_char_func); ?>
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="btn_confirm">
                    <input type="submit" value="<?php echo $w==''?'SignUp':'Change'; ?>" id="btn_submit"
                        class="btn_submit" accesskey="s">

                    <!-- <input type="button" onclick="javascript:fregisterform_submit(this,'<?=$register_action_url?>');"
                        value="<?php /* echo $w==''?'Sign-Up':'Change'; */ ?>" id="btn_submit" class="btn_submit"
                        accesskey="s"> -->

                    <a value='Cancle' target='_TOP' href="<?php echo KAPP_URL_T_; ?>/">Cancle</a>
                </div>
        </form>

        <script>
        if (get_cookie('mb_level')) document.fregisterform.mb_level.value = get_cookie('mb_level');
        else document.fregisterform.mb_level.value = 2;

        $(function() {
            $("#reg_zip_find").css("display", "inline-block");

            <?php if($config['kapp_cert_use'] && $config['kapp_cert_ipin']) { ?>
            // 아이핀인증
            $("#win_ipin_cert").click(function() {
                if (!cert_confirm())
                    return false;

                var url = "<?php echo KAPP_OKNAME_URL; ?>/ipin1.php";
                certify_win_open('kcb-ipin', url);
                return;
            });

            <?php } ?>
            <?php if($config['kapp_cert_use'] && $config['kapp_cert_hp']) { ?>
            // 휴대폰인증
            $("#win_hp_cert").click(function() {
                if (!cert_confirm())
                    return false;

                <?php
            switch($config['kapp_cert_hp']) {
                case 'kcb':
                    $cert_url = KAPP_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = KAPP_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = KAPP_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("Please make sure to set your phone identity in the basic environment settings.");';
									//기본환경설정에서 휴대폰 본인확인 설정을 해주십시오
                    echo 'return false;';
                    break;
            }
            ?>

                certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
                return;
            });
            <?php } ?>
        });

        // 인증체크
        function cert_confirm() {
            var val = document.fregisterform.cert_type.value;
            var type;

            switch (val) {
                case "ipin":
                    type = "ipin";
                    break;
                case "hp":
                    type = "phone";
                    break;
                default:
                    return true;
            }

            if (confirm(
                    "You have completed your identity verification. Are you sure you want to revoke verification and re-authenticate?"
                )) return true;
            //본인확인을 완료하셨습니다. 인증을 취소하고 다시 인증하시겠습니까?
            else
                return false;
        }

        // submit 최종 폼체크
        function fregisterform_submit(f, act) {
            if (f.du_check.value != '1') {
                alert("중복 확인을 하지 않았습니다.");
                return false;
            }
            //------------------------------------------ 
            var auto_char = f.auto_char.value;
            var captcha_keyB = f.captcha_keyB
                .value; //alert(' 자동문자 OK auto_char:' + auto_char + ' captcha_keyB: ' + captcha_keyB);
            if (captcha_keyB == auto_char) {
                //alert(' 자동문자 OK auto_char:' + auto_char);//자동문자 OK auto_char:xFAQLr
                //return false;
            } else {
                //alert(' 자동문자 error act:'+act);// 자동문자 OK act:./tkher_register_form_update_.php
                alert(' The automatic characters do not match.  '); //\n 자동문자가 일치하지않습니다. 확인바랍니다.
                return false;
            }
            //------------------------------------------
            if (f.w.value == "") {

                /* console.log("1:" + f.du_check.value);
                if (f.du_check.value != '1') {
                    alert("중복 확인을 하지 않았습니다.");
                    return false;
                } */

                var msg = reg_mb_id_check();
                if (msg.length > 1) { //
                    alert("---- error ---- reg_mb_id_check msg:" + msg + '-------');
                    alert(msg);
                    f.mb_id.select();
                    return false;
                }
                //----------------------------------------------------------------------------------------
                if (f.mb_id.value.length < 8) {
                    alert('Please enter at least eight characters.'); //, ID 를 8글자 이상 입력하십시오.
                    f.mb_id.focus();
                    return false;
                }
                //--------------------------------------------------- add 
                if (f.mb_id.value == 'allatpay' || f.mb_id.value == 'accountbook' || f.mb_id.value == 'calendar' || f
                    .mb_id.value == 'contents' || f.mb_id.value == 'makesajin' || f.mb_id.value == 'schedule' || f.mb_id
                    .value == 'slidemenu') {
                    alert(' You used a ID that is not allowed. Please re-enter.');
                    f.mb_id.focus(); // \n 허용이 안 되는 ID를 사용하셨습니다. 다시 입력하시기 바랍니다.
                    return false;
                }
                var chgStr = f.mb_id.value;

                if (chgStr.indexOf('"') >= 0 || chgStr.indexOf("'") >= 0 || chgStr.indexOf("_") >= 0 || chgStr.indexOf(
                        "-") >= 0 || chgStr.indexOf(":") >= 0 || chgStr.indexOf("|") >= 0 || chgStr.indexOf("[") >= 0 ||
                    chgStr.indexOf("]") >= 0 || chgStr.indexOf("<") >= 0 || chgStr.indexOf(">") >= 0 || chgStr.indexOf(
                        "!") >= 0 || chgStr.indexOf("@") >= 0 || chgStr.indexOf("#") >= 0 || chgStr.indexOf("$") >= 0 ||
                    chgStr.indexOf("%") >= 0 || chgStr.indexOf("&") >= 0 || chgStr.indexOf("*") >= 0 || chgStr.indexOf(
                        ")") >= 0 || chgStr.indexOf("(") >= 0 || chgStr.indexOf(";") >= 0 || chgStr.indexOf("`") >= 0 ||
                    chgStr.indexOf("{") >= 0 || chgStr.indexOf("}") >= 0) {
                    alert(' You used a special character that is not allowed. Please re-enter.');
                    f.mb_id.focus(); // \n 허용이 안 되는 특수문자를 사용하셨습니다. 다시 입력하시기 바랍니다.
                    return false;
                }
                //alert('chgStr :' +chgStr);
                //-------------------------------------------------------- add end
            } else {
                alert("---- fregisterform_submit ----  else");
            }

            // E-mail 검사  //alert("---- f.mb_email.value : " + f.mb_email.value );
            if (f.mb_email.value == "") {
                alert("----  Please email " + f.mb_email.value);
                f.mb_email.focus();
                return false;
            }
            if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
                var msg = reg_mb_email_check();
                if (msg.length > 1) { //
                    alert(msg);
                    f.reg_mb_email.select();
                    return false;
                }
            }
            if (f.w.value == '') {
                if (f.mb_password.value.length < 8) {
                    alert('Please enter at least eight characters.'); //, 비밀번호를 8글자 이상 입력하십시오.
                    f.mb_password.focus();
                    return false;
                }
            }
            if (f.mb_password.value != f.mb_password_re.value) {
                alert('The passwords are not the same.'); //, 비밀번호가 같지 않습니다.
                f.mb_password_re.focus();
                return false;
            }
            if (f.w.value == '') {
                if (f.mb_name.value.length < 1) {
                    alert('Please enter a name.'); //, 이름을 입력하십시오.
                    f.mb_name.focus();
                    return false;
                }
            }

            <?php if( $w == '' && $config['kapp_cert_use'] && $config['kapp_cert_req']) { ?>
            if (f.cert_no.value == "") {
                alert("To be a member, you need to verify your identity.");
                return false;
            }
            <?php } ?>

            if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
                var msg = reg_mb_nick_check();
                //if (msg) {
                if (msg.length > 1) { //
                    alert('msg:' + $msg + ':nick - null len: ' + $msg.length); //nick --------- null len: 1
                    alert(msg);
                    f.reg_mb_nick.select();
                    return false;
                }
            }


            <?php if( ($config['kapp_use_hp'] || $config['kapp_cert_hp']) && $config['kapp_req_hp']) {  ?>
            var msg = reg_mb_hp_check();
            if (msg.length > 1) { //
                alert(msg);
                f.reg_mb_hp.select();
                return false;
            }
            <?php } ?>

            if (typeof f.mb_icon != 'undefined') {
                if (f.mb_icon.value) {
                    if (!f.mb_icon.value.toLowerCase().match(/.(gif)$/i)) {
                        alert('Member icon is not a gif file.'); //회원아이콘이 gif 파일이 아닙니다.
                        f.mb_icon.focus();
                        return false;
                    }
                }
            }
            if (typeof(f.mb_recommend) != 'undefined' && f.mb_recommend.value) {
                if (f.mb_id.value == f.mb_recommend.value) {
                    alert('I can not recommend you.'); //, 본인을 추천할 수 없습니다.
                    f.mb_recommend.focus();
                    return false;
                }

                var msg = reg_mb_recommend_check(); //추천인.
                if (msg.length > 1) { //
                    alert('---- msg:' + msg);
                    f.mb_recommend.select();
                    return false;
                }
            }

            /* if (document.fregisterform.du_check.value != '1') {
                alert("중복 확인을 하지 않았습니다.");
                return false;
            } */

            document.getElementById("btn_submit").disabled = "disabled";
            return true;
        }

        function duplicate() {
            let suc_data = '';
            if (!document.fregisterform.mb_id.value) {
                alert("아이디를 입력해 주세요.");
                document.fregisterform.mb_id.select();
                return;
            }

            if (!document.fregisterform.mb_email.value) {
                alert("이메일을 입력해 주세요.");
                document.fregisterform.mb_email.select();
                return;
            }

            if (!document.fregisterform.mb_nick.value) {
                alert("닉네임을 입력해 주세요.");
                document.fregisterform.mb_nick.select();
                return;
            }

            $.ajax({
                type: "post",
                dataType: "json",
                async: true,
                data: {
                    "mode": 'check',
                    "mb_id": JSON.stringify(document.fregisterform.mb_id.value),
                    "mb_email": JSON.stringify(document.fregisterform.mb_email.value),
                    "mb_nick": JSON.stringify(document.fregisterform.mb_nick.value),
                },
                url: "duplicate_ajax.php",
                success: function(data) {
                    if (data) {
                        alert(data);
                        return false;
                    } else {
                        alert("중복이 아닙니다. 계속 등록 바랍니다.");
                        document.fregisterform.du_check.value = '1';
                        return true;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //alert("The data type or URL is incorrect.-- SQL_Delete_r.phpe");
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    return;
                }
            });

            /* $.ajax({
                type: "post",
                dataType: "json",
                data: {
                    "mode": 'email',
                    "mb_email": JSON.stringify(document.fregisterform.mb_email.value),
                    "mb_id": JSON.stringify(document.fregisterform.mb_id.value)
                },
                url: "duplicate_ajax.php",
                success: function(data) {
                    if (data) {
                        alert(data);
                        return false;
                    }
                    suc_data = 'ok';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //alert("The data type or URL is incorrect.-- SQL_Delete_r.phpe");
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    return;
                }
            });

            $.ajax({
                type: "post",
                dataType: "json",
                data: {
                    "mode": 'nick',
                    "mb_nick": JSON.stringify(document.fregisterform.mb_nick.value),
                    "mb_id": JSON.stringify(document.fregisterform.mb_id.value)
                },
                url: "duplicate_ajax.php",
                success: function(data) {
                    if (data) {
                        alert(data);
                        return false;
                    }
                    suc_data = 'ok';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //alert("The data type or URL is incorrect.-- SQL_Delete_r.phpe");
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    return;
                }
            }); */

            /* if (suc_data == 'ok') {
                alert("중복이 아닙니다. 계속 등록 바랍니다.");
                document.fregisterform.du_check.value = '1';
                return true;
            } else {
                alert("ERROR");
                return false;
            } */
        }

        function duplicate_input_change(){
            document.fregisterform.du_check.value = '0';
        }
        </script>
    </div>

    <?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>