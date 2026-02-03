<center>
 <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/common.js"></script>

	<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

    <link rel='stylesheet' href='<?=KAPP_URL_T_?>/include/css/kancss.css' type='text/css'><!-- 중요! -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script type='text/javascript'>
    <!--
    /*
	function Kakao_Login_func($kapp_kakao_js_apikey) {
		alert(" Kakao_Login_func --- " + $kapp_kakao_js_apikey);
        //kakao_login("<?=Decrypt('$kapp_kakao_js_apikey', 'modumoa', '~!@#$%^&*()_+')?>");
    }*/

    function Kout_func() {
        //document.kakao_form.modeA.value = '';
        //document.kakao_form.modeG.value = '';
        document.kakao_form.Login_Mode.value = 'chat_logout';
        document.kakao_form.userObject.value = '';
        document.kakao_form.authObject.value = '';
        document.kakao_form.gemail.value = ''; // google
        document.kakao_form.gname.value = '';
        document.kakao_form.action = 'index.php';
        document.kakao_form.submit();
    }

    function Gout_func() {
        //document.kakao_form.modeA.value = '';
        //document.kakao_form.modeG.value = '';
        document.kakao_form.Login_Mode.value = 'chat_logout';
        document.kakao_form.userObject.value = '';
        document.kakao_form.authObject.value = '';
        document.kakao_form.gemail.value = ''; // google
        document.kakao_form.gname.value = '';
        document.location.href =" https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=";
//        document.location.href =" https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=" + <?=KAPP_URL_T_?>;
    }
    function kakao_loginX($Kakao_APP_KEY) { // 중요 - Login Button XXX
        alert("kakao_login 64");
        Kakao.init($Kakao_APP_KEY);
        Kakao.Auth.loginForm({
            success: function(authObj) {
                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        document.kakao_form.Login_Mode.value = "Kakao_Login";
                        document.kakao_form.userObject.value = JSON.stringify(res);
                        document.kakao_form.authObject.value = JSON.stringify(authObj);
                        document.kakao_form.submit();
                    },
                    fail: function(err) {
                        alert("11 ailinkapp login fail");
                        document.kakao_form.Login_Mode.value = 'NO';
                    }
                });
            },
            fail: function(err) {
                alert(JSON.stringify(err))
                alert("12 ailinkapp login fail:" + JSON.stringify(err));
            },
        })
    }
    -->
    </script>

<?php
	$login_count_today = 0;
	$login_count_total = 0;
	$visit_all_today   = 0;

	$day = date("Y-m-d H:i", time());
	$Kday = date("Y-m-d H:i", time()) . ' member SignUp';

	if( isset($_POST['Login_Mode']) ) $Login_Mode = $_POST['Login_Mode'];
	else $Login_Mode = "";

	$gsajin = "";
	if( $Login_Mode == 'Google_Login') { 
		$gid    = $_POST['gid'];
		$gemail = $_POST['gemail'];
		$gname  = $_POST['gname'];
		$gsajin = $_POST['gsajin'];
		$G_SAJIN= $_POST['gsajin'];
		$nickname = $_POST['gname'];
		$email = $_POST['gemail'];

		set_session('nickname', $_POST["gname"]);
		set_session('email',    $_POST["gemail"]);
		set_session('urllink_login_type', "Google");
		connect_count('Google login', $gemail, 1, $referer);
		$member = get_memberT( $gemail, $tkher['tkher_member_table'] );
		if( $member['mb_id']=="" ){
			$config = sql_fetch(" SELECT * from {$tkher['config_table']} ");
			urllink_member_setA( $gemail, $gname, $gsajin, 'Google', $tkher['tkher_member_table'], $config['kapp_register_point']);
			$member = get_memberT( $gemail, $tkher['tkher_member_table'] );
			insert_point_app( $member['mb_id'], $config['kapp_register_point'], $Kday, 'Google_Login@SignUp', $member['mb_id'], $day);
		}
		set_session('ss_mb_id',    $member['mb_id']);
		set_session('ss_mb_level', $member['mb_level']);
		set_session('ss_mb_key', md5($member['mb_datetime'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
	} else if( $Login_Mode == 'Kakao_Login' ) {

		$userObject	= $_POST['userObject'];
		$arr_user	= json_decode( $userObject, true);
		$kname	    = $arr_user['properties']['name'];
		$nickname	= $arr_user['properties']['nickname'];
		$kemail		= $arr_user['kakao_account']['email'];
		set_session('nickname', $nickname);
		set_session('email',    $kemail);
		set_session('urllink_login_type', "Kakao");

		connect_count('Kakao login', $kemail, 1, $referer);
		$gsajin = "";
		$member = get_memberT( $kemail, $tkher['tkher_member_table'] );

		if( $member['mb_id']=="" ){
			$config = sql_fetch(" SELECT * from {$tkher['config_table']} ");
			urllink_member_setA( $kemail, $nickname, $gsajin, 'Kakao', $tkher['tkher_member_table'], $config['kapp_register_point']);
			$member = get_memberT( $kemail, $tkher['tkher_member_table'] );
			if( $member['mb_id']=="" ){ }
			insert_point_app($member['mb_id'], $config['kapp_register_point'], $Kday, 'Kakao_Login@SignUp', $member['mb_id'], $day);
		}
		set_session('ss_mb_id',    $member['mb_id']);
		set_session('ss_mb_level', $member['mb_level']);
		set_session('ss_mb_key', md5($member['mb_datetime'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));
	} else if( $Login_Mode == 'appgeneratorsystem' ) {
	} else if( get_session("urllink_login_type") == "Naver_Login_K") {
	}
	if( $member['mb_id']) {
		$is_guest = false;
		$is_member = true;
		$is_admin = is_admin($member['mb_id']);
		$member['mb_dir'] = substr($member['mb_id'],0,2);
	} else {
		$is_member = false;
		$is_guest = true;
		$member['mb_id'] = 'Guest';
		$member['mb_level'] = 1;
	}
	if( $is_admin != 'super') {
		$kapp_possible_ip = trim($config['kapp_possible_ip']); // 접근가능 IP
		if( $kapp_possible_ip) {
			$is_possible_ip = false;
			$pattern = explode("\n", $kapp_possible_ip);
			for( $i=0; $i<count($pattern); $i++) {
				$pattern[$i] = trim($pattern[$i]);
				if( empty($pattern[$i])) continue;
				$pattern[$i] = str_replace(".", "\.", $pattern[$i]);
				$pattern[$i] = str_replace("+", "[0-9\.]+", $pattern[$i]);
				$pat = "/^{$pattern[$i]}$/";
				$is_possible_ip = preg_match($pat, $_SERVER['REMOTE_ADDR']);
				if( $is_possible_ip) break;
			}
			if( !$is_possible_ip) die ("<meta charset=utf-8> Access is not possible."); // 접근이 가능하지 않습니다.
		}
		// 접근차단 IP
		$is_intercept_ip = false;
		$pattern = explode("\n", trim($config['kapp_intercept_ip']));
		for ($i=0; $i<count($pattern); $i++) {
			$pattern[$i] = trim($pattern[$i]);
			if( empty($pattern[$i])) continue;

			$pattern[$i] = str_replace(".", "\.", $pattern[$i]);
			$pattern[$i] = str_replace("+", "[0-9\.]+", $pattern[$i]);
			$pat = "/^{$pattern[$i]}$/";
			$is_intercept_ip = preg_match($pat, $_SERVER['REMOTE_ADDR']);
			if ($is_intercept_ip)
				die ("<meta charset=utf-8> Access is not possible.");
		}
	}

    function Admin_info_check() {
        global $member;
        global $tkher, $config;
        /*if( $config['kapp_googl_shorturl_apikey'] == '' || $config['kapp_kakao_js_apikey'] == '' || $config['kapp_naver_client_id'] == ''|| $config['kapp_naver_client_secret'] == '') {
            Add_Admin_Info();
        }*/
            Add_Admin_Info();
    }
    function Member_info_check() {
        global $member;
        global $tkher;
        if(!Isset($member['mb_password']) || !Isset($member['mb_name']) || !Isset($member['mb_sex']) || !Isset($member['mb_birth']) || !Isset($member['mb_tel']) || !Isset($member['mb_zip1']) || !Isset($member['mb_addr1'])) { // 비밀번호, 이름, 성별, 생년월일, 연락처, 우편번호, 주소
            Add_Info();
        } else if ($member['mb_password'] == '' || $member['mb_name'] == '' || $member['mb_sex'] == '' || $member['mb_birth'] == '' || $member['mb_tel'] == '' || $member['mb_zip1'] == '' || $member['mb_addr1'] == '') {
            Add_Info();
        }
    }

    function Add_Admin_Info() { // 고객 추가정보(생년월일, 성별, 연락처, 주소) 입력 팝업 호출

        echo "<script>
        const f_popup_w = '900';
        const f_popup_h = '900';

        const f_popup_left = Math.ceil((window.screen.width - f_popup_w) / 2);
        const f_popup_top = Math.ceil((window.screen.height - f_popup_h) / 2);

        var win = window.open('".KAPP_URL_T_."/setup/ksd39673976_1711436495_kapp_config.php', '_blank',
            'toolbar=yes,scrollbars=yes,resizable=yes,top=' + f_popup_top + ',left=' + f_popup_left +
            ',width=' + f_popup_w +
            ',height=' + f_popup_h);
        </script>";
    }
    function Add_Info() { // 고객 추가정보(생년월일, 성별, 연락처, 주소) 입력 팝업 호출

        echo "<script>
        const f_popup_w = '700';
        const f_popup_h = '700';
        const f_popup_left = Math.ceil((window.screen.width - f_popup_w) / 2);
        const f_popup_top = Math.ceil((window.screen.height - f_popup_h) / 2);
        var win = window.open('".KAPP_URL_T_."/add_info.php', '_blank',
            'toolbar=yes,scrollbars=yes,resizable=yes,top=' + f_popup_top + ',left=' + f_popup_left +
            ',width=' + f_popup_w +
            ',height=' + f_popup_h);
        </script>";
    }
	//$H_ID = $member['mb_id'];
	//$H_LEV= $member['mb_level'];
	//$ip   = $_SERVER['REMOTE_ADDR'];
	$cur="";
    if( $H_ID && $H_LEV > 7 && get_cookie('add_admin_info') != 'next') Admin_info_check();
    if( $H_ID && $H_LEV > 1 && get_cookie('add_info') != 'next') Member_info_check();
?>

    <!-- end -->
    <form name='kakao_form' method='post' enctype='multipart/form-data'>
        <!-- <input type='hidden' name='modeG' value='' />
        <input type='hidden' name='modeA' value='' /> -->
        <input type='hidden' name='Login_Mode' value='' />
        <input type='hidden' name='gid' value='' />
        <input type='hidden' name='gsite' value='' />
        <input type='hidden' name='gsajin' value='' />
        <input type='hidden' name='gemail' value='' />
        <input type='hidden' name='gname' value='' />
        <input type='hidden' name='g_email' value=''>
        <input type='hidden' name='g_fullname' value=''>
        <input type='hidden' name='g_image' value=''>
        <input name="userObject" id="userObject" type="hidden" value='<?=$_POST['userObject']?>' />
        <input name="authObject" id="authObject" type="hidden" value='<?=$_POST['authObject']?>' />
    </form>
    <!-- <form name='form_menu' method='post' enctype="multipart/form-data">
        <input type='hidden' name='mode' value=''>
        <input type='hidden' name='board'>
    </form> -->
    <ul id='nav'>
        <li <?php if( $cur=='A') echo "class='current'"; ?>>
            <a href="<?=KAPP_URL_?>" target='_blank' title='HOME'><img src='<?=KAPP_URL_T_?>/icon/logo60.png' style='border-style:;height:20px;'></a>
            <ul>
                <li align='left'>
                    <a href="<?=KAPP_URL_?>" target='_blank' title='KAPP HOME'>0. Home</a>
                </li>
                <li align='left'>
                    <a href="<?=KAPP_URL_T_?>/privacy_policy_en.html" target='_blank'>1. Privacy Policy</a>
                </li>
                <li align='left'>
                    <a href="<?=KAPP_URL_T_?>/terms_service_en.html" target='_blank'>2. Service Terms</a>
                </li>
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=1" target='_self'>31. Notice</a></li>
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=2" target='_self'>32. News</a></li>
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=3" target='_self'>33. Q&A</a></li>
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=4" target='_self'>34. Free Board</a></li>
                <?php
	if( $H_ID && $H_LEV > 7) { // 관리자용. 메인 메뉴 설정.
?>
                <li align='left'> <a href='<?=KAPP_URL_T_?>/adm/' target='_blank'
                        <?php echo " title='Admin Page. ' "; ?>> ### Admin ###</a></li>
                <li align='left'> <a href='<?=KAPP_URL_T_?>/menu/main_img.php' target='_self'
                        <?php echo " title='Admin Register the main image. ' "; ?>>B3. Main-Image Insert</a></li>
                <li align='left'> <a href='<?=KAPP_URL_T_?>/menu/main_image_list.php' target='_self'
                        <?php echo " title='Admin Main image list. ' "; ?>>B4. Main-Image-List</a></li>
                <li align='left'><a href="<?=KAPP_URL_T_?>/setup/DB_Table_CreateA.php" target='_self'>B5. Kapp Table List</a> </li>
                <li align='left'><a href="<?=KAPP_URL_T_?>/curl_server.php" target='_self'>B6. Shared-Server Reset</a> </li>
<?php } ?>
            </ul>
        </li>
<?php
	if( $H_ID && $H_LEV > 1) $my_tit='Mypage';
	else $my_tit='Login';
?>
        <li <?php if($cur=='B') echo "class='current'"; ?>>
            <div class="lnbFooterKANMy">
                <a href="#"><img src='<?=KAPP_URL_T_?>/icon/land.png' style='border-style:;height:20px;'><?=$my_tit?></a>
            </div>
            <ul>
<?php
		if( !$H_ID || $H_LEV < 2 ) {
?>
                <li align='left'>
                    <div class="lnbFooterKAN">
                        <a href="javascript:void(0)" class="lnbIcon01KAN" title="menu Login">Login</a>
                    </div>
                </li>
                <li align='left'>
                    <div class="SIGN_S">
                        <a href="javascript:Ologin();" title='- SIGN UP - '>SIGN UP</a>
                    </div>
                </li>
                <li align='left'>
                    <div class="SSS">
                        <a href="<?=KAPP_URL_T_?>/manual/user_manual.php" target='_blank'
                            title='Homepage User Guide'>User's Manual</a>
                    </div>
                </li>
                <?php } else { ?>
                <li align='left'>
                    <div class="SS">
                        <a href='<?=KAPP_URL_T_?>/my/' target='_top'>My_Page(<?=$H_ID?>)</a>
                    </div>
                </li>
                <li align='left'>
                    <div class="SS">
                        <a href="<?=KAPP_URL_T_?>/manual/user_manual.php" target='_blank'
                            title='Homepage User Guide'>User's Manual</a>
                    </div>
                </li>
                <li align='left'>
                    <div class="C">
                        <a href="javascript:logout_func();">LOGOUT:<?=$H_ID?>:<?=$H_LEV?></a>
                    </div>
                </li>
                <li align='left'> <a href='#' target='_self'
                        <?php echo " title='Manage user schedule. ' "; ?>>B2.Schedule</a>
                    <ul>
                        <li align='left'> <a href="<?=KAPP_URL_T_?>/calendar/" target='_self'
                                <?php echo " title='Manage user schedule.' "; ?>>1.Daily schedule</a></li>
                        <li align='left'> <a href="<?=KAPP_URL_T_?>/calendar/index_year.php" target='_self'
                                <?php echo " title=' Manage annual schedules.' "; ?>>2.Year Schedule</a></li>
                    </ul>

                </li>
                <li align='left'><a href='<?=KAPP_URL_T_?>/accountbook/' target='_self'
                        <?php echo " title='Manage user accountbook.' "; ?>>B3.Account book</a></li>
                <!-- <li align='left'>
                    <div class="SSS">
                        <a href="<?=KAPP_URL_T_?>/chatS" target='_blank' title='Chat consulting '>Chat consulting</a>
                    </div>
                </li> -->
                <?php
		} // if H_ID
?>
            </ul>
        </li>
        <li class='current'>
            <a href='#' target='run_menu' ><img src='<?=KAPP_URL_T_?>/icon/pcman1.png' style='border-style:;height:20px;'>App Make</a>
            <ul>
                <li align='left'><a href='<?=KAPP_URL_T_?>/index.php?open_mode=on' target='_top'>C0.Program-Make</a></li>
                <li align='left'><a href="<?=KAPP_URL_T_?>/kapp_program_list_all.php" target='_self'>C1.Program List</a></li>
                <li align='left'><a href='<?=KAPP_URL_T_?>/menu/index.php' target='_self' title='Tree list.'>C2. Tree Menu List</a></li>
                <li align='left'><a href="<?=KAPP_URL_T_?>/menu/board_list3.php" target='_self'>C3.Board List </a></li>
                <li align='left'><a href="<?=KAPP_URL_T_?>/menu/ulink_list.php" target='_self'>C4.Link List</a>
                </li>
            </ul>
        </li>
    </ul>
<!-- 
    <FORM name="menu_table_list" Method='post'>
        <input type='hidden' name='pg_name'>
        <input type='hidden' name='pg_code'>
        <input type='hidden' name='mode'>
    </FORM> -->

<?php
if( !$H_ID && $H_ID !=='Guest' ) {
?>
    <div class="loginBox">
        <div class="rela">
            <FORM name='loginA' action='<?=KAPP_URL_T_?>/login_checkT.php' method='post' enctype="multipart/form-data">
                <input type='hidden' name='Login_Mode' value=''>
                <a href="javascript:void(0);" class="loginClose" title="-bg_closeBtn-"><img src="<?=KAPP_URL_T_?>/include/img/bg_closeBtn.png" /></a>
                <div class="pic"><img src="<?=KAPP_URL_T_?>/include/img/etc_login.png" /></div>
                <div class="form">
                    <div class="row">
                        <label for="loginid">E-mail</label>
                        <input type="text" id="loginid" name="mb_id" />
                    </div>
                    <div class="row">
                        <label for="loginid">Password</label>
                        <input type="password" id="loginid" name="mb_password" />
                        <input type="hidden" name="mb_password_enc" value='' />
                    </div>
                    <div class="A_Login">
                        <a href="javascript:Ologin(0);" title='Login A'>LOGIN</a>
                    </div>
                </div>
                <div class="formA">
                    <div class="Sign_up">
                        <a href="javascript:Ologin();" title='LoginBox SIGN UP' >SIGN UP</a>
                    </div>
                </div><br>
                
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="loginBox">
        <div class="rela">
            <FORM name='loginO' action='<?=KAPP_URL_T_?>/logoutT.php' method='post' enctype="multipart/form-data">
                <!-- <input type='hidden' name='Login_Mode' value=''> -->
            </form>
        </div>
    </div>
<?php }
	if( isset($_POST['sdata']) ) $sdata = $_POST['sdata'];
	else $sdata = "";
?>
    <div>
        <table board='0'>
            <FORM name="fsearchbox" method="post" action="<?=KAPP_URL_T_?>/menu/ulink_list.php">
            <input type='hidden' name='Search_Mode' value='PG' />
                <td><a href="<?=KAPP_URL_T_?>" target='_top' title='KAPP HOME'><img src="<?=KAPP_URL_T_?>/icon/logo.png" height='30'></a></td>
                <td><input type="text" name="sdata" value="<?=$sdata?>" maxlength="250" style='height:30;'></td>
                <td><input type="button" id="sch_submitA" value=" Search " onclick='search_run("<?=KAPP_URL_T_?>")' style='height:30;' ></td>
                <td><input type="button" id="sch_submitB" value=" Tree-Search " onclick='search_Tree("<?=KAPP_URL_T_?>")' style='height:30;'></td>
            </form>
        </table>
    </div>
<?php
	$log_i = "";
	if( isset($H_ID) && $H_LEV > 1 ) {
		if( get_session("urllink_login_type") == "Google_Login_K") {
			$log_i = "Google";
		} else $log_i = "Guest";
?>
		<div title='Login-Google'>
			<?=get_session("urllink_login_type")?>:
			<?=$H_ID?>:<?=$member['mb_email']?>:<?=$member['mb_name']?>:<?=$member['mb_level']?>,
			Point:<?=number_format($member['mb_point'])?>
			<br><?=date("Y-m-d H:i:s")?>, <?=$_SERVER['REMOTE_ADDR']?> - <?=$config['kapp_visit']?>
		</div>
<?php } else { ?>
		<div title='<?=$log_i?> visit'><?=$log_i?> - <?=$config['kapp_visit']?>
			<br><?=date("Y-m-d H:i:s")?>, <?=$_SERVER['REMOTE_ADDR']?>
		</div>
<?php } ?>
    <script language="JavaScript">
    <!--
    function init() {
        fsearchbox.sdata.focus();
    }

    function search_Tree(Search_Mode) {
        sdata = document.fsearchbox.sdata.value;
        if (!sdata) {
            alert(" Search data All!:");
        }
        //document.fsearchbox.Search_Mode.value = "cratree_my_list_menu";
        document.fsearchbox.action = Search_Mode + "/menu/index.php";
        document.fsearchbox.submit();
    }

    function search_run(Search_Mode) {
        sdata = document.fsearchbox.sdata.value;
        if (!sdata) {
            alert(" Search data Insert Please!:" + sdata);
            return false;
        }
        if (fsearchbox.sdata.value.length < 2) {
            alert("Please enter at least two character. ");
            fsearchbox.sdata.select();
            fsearchbox.sdata.focus();
            return false;
        }
        //document.fsearchbox.Search_Mode.value = "";
        document.fsearchbox.action = Search_Mode + "/menu/ulink_list.php";
        document.fsearchbox.submit();
    }
	/*
    function run_func(url) {
        document.form_menu.mode.value = 'run';
        document.form_menu.action = url;
        document.form_menu.submit();
    }*/

    function logout_func() {
        //document.loginO.Login_Mode.value = "logout";
        document.loginO.target = "_top";
        document.loginO.action = '<?=KAPP_URL_T_?>/logoutT.php';
        document.loginO.submit();
    }

    function My_Page() {
        gemail = document.form_view.email.value;
        document.form_view.target = '_top';
        document.form_view.action = '<?=KAPP_URL_T_?>/my/';
        document.form_view.submit();
    }
    -->
    </script>

    <script>
    $(function() {
        $('.A_Login').on('click', function() {
            var id = document.loginA.mb_id.value;
            var pw = document.loginA.mb_password.value;
            if( id == '') {
                alert('Please enter your ID !!! ');
                document.loginA.mb_id.focus();
                return false;
            }
            if( pw == '') {
                alert('Please enter a password.');
                document.loginA.mb_password.focus();
                return false;
            }
            document.loginA.Login_Mode.value = "A_login";
            document.loginA.submit();
        });
        $('.Sign_up').on('click', function() {
            document.loginA.Login_Mode.value = "signup";
            var Upg1_ = "<?=KAPP_URL_T_?>/tkher_register_.php";
            document.loginA.action = Upg1_;
            document.loginA.submit();
        });
        $('.SIGN_S').on('click', function() {
            document.loginA.Login_Mode.value = "signup";
            var Upg1_ = "<?=KAPP_URL_T_?>/tkher_register_.php";
            document.loginA.action = Upg1_;
            document.loginA.submit();
        });

        /*$('.login_close').on('click', function(no) {
            //location.href="w.php?no="+no;
        });*/
    });
    </script>

    <script type="text/javascript">
    var $grid;
    $(function() {

        $("body").on("click", ".C", function() {
            document.loginO.Login_Mode.value = "logout";
            document.loginO.submit();
        });
        $("body").on("click", ".loginClose", function() {
            $(".loginBox").stop().animate({
                "right": "-1000px"
            }, 200, 'linear');
        });

        $("body").on("click", ".lnbFooterKAN a.lnbIcon03KAN", function() {
            $(".project_area").stop().animate({
                "right": "-20px"
            }, 200, 'linear');
            $(".loginBox").stop().animate({
                "right": "-1000px"
            }, 200, 'linear');
        });
        $("body").on("click", ".lnbFooterKAN a.lnbIcon01KAN", function() {
            //alert("menu login_click");
            $(".loginBox").stop().animate({
                "right": "0"
            }, 200, 'linear');
            $(".project_area").stop().animate({
                "right": "-1000px"
            }, 200, 'linear');
        });
        $("body").on("click", ".lnbFooterKANMy a.lnbIcon01KANMy", function() {
            document.form_view.target = '_top';
            document.form_view.action = '<?=KAPP_URL_T_?>/my/';
            document.form_view.submit();
        });
    });
    function kakao_login($Kakao_APP_KEY) {
        Kakao.init($Kakao_APP_KEY);
        Kakao.Auth.loginForm({
            success: function(authObj) {
                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        document.kakao_form.Login_Mode.value = "Kakao_Login_K";
                        document.kakao_form.userObject.value = JSON.stringify(res);
                        document.kakao_form.authObject.value = JSON.stringify(authObj);
                        document.kakao_form.action = '<?=KAPP_URL_T_?>/login_checkT.php';
                        document.kakao_form.submit();
                    },
                    fail: function(err) {
                        alert("1 --- login fail");
                        document.kakao_form.Login_Mode.value = 'NO';
                    }
                });
            },
            fail: function(err) {
                alert(JSON.stringify(err))
                alert("2 --- login fail:" + JSON.stringify(err));
            },
        })
    }
    </script>
