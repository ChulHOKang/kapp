<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
    <link rel="shortcut icon" href="./logo/logo25a.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">
    <?php
	include_once('./tkher_start_necessary.php');

	connect_count($host_script, 'member', 0, $referer); 


/*
   https://moado.net/kapp/tkher_register_.php 
   call : $register_action_url = './tkher_register_form_.php';
   call : $register_action_url = './tkher_register_form_update_.php';
*/
//$U=G5_BBS_URL;//$G5_SESSION_PATH=G5_SESSION_PATH; //G5_SESSION_PATH:/var/www/html/g5/data/session
if( $is_member ) {
    goto_url('/');
}

// 세션을 지웁니다.
set_session("ss_mb_reg", "");

$tkher['title'] = 'Terms of Membership!';// [회원가입약관!]

$register_action_url = './tkher_register_form_.php';	//G5_BBS_URL.'/register_form.php';
?>
    <link rel="stylesheet" href="./include/css/style_mb.css">
    <!-- <link rel="stylesheet" href="./include/css/tkher_mobile.css"> -->

    <div id="logo" align=center style='height:100px;background-color:black;color:white;border:1 solid black'>
        <a href="./index.php" target='_TOP'><img src="./logo/logo512-512.png" width=100 title="KAPP"></a>
    </div>

    <!-- <form name="foutlogin" method="post" autocomplete="off">
    <fieldset>
        <div id="ol_svc">
            <p align=center><a href="./tkher_password_lost.php" id="ol_password_lost">
				<b>Find ID / PASSWORD (ID/PASSWORD Find!)</a></p>
        </div>
    </fieldset>
    </form> -->
    <br>
    <div class="mbskin">

        <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>"
            onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

            <p>You must be signed in to the membership agreement before you can join.</p>

            <section id="fregister_term">
                <h2>[ Terms of Membership ]</h2>
                <textarea readonly width='100%'><?php echo get_text($config['kapp_stipulation']) ?></textarea>
                <fieldset class="fregister_agree" align=center>
                    Confirm : <input type="checkbox" name="agree" value="1" id="agree11">
                    <label for="agree11">I agree to the terms of the Membership Agreement.</label>
                </fieldset>
            </section>
            <br>
            <p>In order to register, you must agree to the terms and conditions of membership and privacy policy.
                <!-- <br>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.! -->
            </p>


            <section id="fregister_private">
                <h2>Privacy Policy</h2>
                <div class="tbl_head01 tbl_wrap">
                    <table>
                        <caption>Privacy Policy</caption><!--  (개인정보처리방침안내) -->
                        <thead>
                            <tr>
                                <th>purpose</th>
                                <th>Item</th>
                                <th>Retention period</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Identify and verify your identity
                                    <!-- <br>(이용자 식별 및 본인여부 확인) -->
                                </td>
                                <td>ID, Name, Password
                                    <!-- <br>(아이디, 이름, 비밀번호) -->
                                </td>
                                <td>Until membership is canceled
                                    <!-- <br>(회원 탈퇴 시까지) -->
                                </td>
                            </tr>
                            <tr>
                                <td>Notice of Customer Service Use
                                    <!-- <br>(고객서비스 이용에 관한 통지) -->,<br>User identification for CS response
                                    <!-- <br>(CS대응을 위한 이용자 식별) -->
                                </td>
                                <td>Contact, E-Mail, Phone
                                    <!--  <br>( 연락처, 이메일, 휴대전화번호 ) -->
                                </td>
                                <td>Until membership is canceled
                                    <!-- <br>(회원 탈퇴 시까지) -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <fieldset class="fregister_agree" align=center>
                    Confirm : <input type="checkbox" name="agree2" value="1" id="agree21">
                    <label for="agree21">I agree to the contents of the Privacy Policy Guide.
                        <!--  <br>(개인정보처리방침안내의 내용에 동의합니다.) -->
                    </label>
                </fieldset>
            </section>

            <div class="btn_confirm">
                <input type="submit" class="btn_submit" value="SignUp" title='kapp_register_'>
            </div>

        </form>

        <script>

        function fregister_submit(f) {
            if (!f.agree.checked) {
                alert("You must be signed in to the membership agreement before you can join.");
                // \\n 회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.!!!
                f.agree.focus();
                return false;
            }

            if (!f.agree2.checked) {
                alert("You must be signed in to the Privacy Policy Guide before you can register.");
                // \\n 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.
                f.agree2.focus();
                return false;
            }

            return true;
        }
        </script>

    </div>

    <?php
//include_once('./tkher_tail.php');
?>