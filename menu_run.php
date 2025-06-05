<center>
    <!-- <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/default.css" type="text/css" /> -->
 <link rel="stylesheet" href="../include/css/common.css" type="text/css" />
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/common.js"></script>
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

    <link rel='stylesheet' href='<?=KAPP_URL_T_?>/include/css/kancss.css' type='text/css'><!-- 중요! -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

	<!-- javascript 암호화 -->

    <script type='text/javascript'>
    //alert("---sign---");
    <!--
    //-------------------------------------- google
    function onSignIn(googleUser) { // no use old type ???

        return;

        /*
		if (!document.kakao_form.gemail.value) {
            var profile = googleUser.getBasicProfile();
            email = profile.getEmail();
            em = email.split("@");
            e1 = em[0];
            e2 = em[1];
            document.kakao_form.mode.value = "Google_Login";
            document.kakao_form.modeG.value = "Google";
            document.kakao_form.modeA.value = "member_set";
            document.kakao_form.gid.value = e1; //solpakan89
            document.kakao_form.gsite.value = e2; //gmail.com
            document.kakao_form.gemail.value = profile.getEmail();
            document.kakao_form.gname.value = profile.getName();
            document.kakao_form.gsajin.value = profile.getImageUrl();
            //alert("gmail : " + document.kakao_form.gemail.value);
            document.kakao_form.target = "_top";
            document.kakao_form.action = "index.php";
            document.kakao_form.submit();
        } else {
            //alert("No Google email :" + document.kakao_form.gemail.value); // OK
        }*/
    }
    //---------------------------------------------------------- kakao
    function Kakao_Login_func() {
        kakao_login('<?=Decrypt($config['kapp_kakao_js_apikey'], 'modumoa', '~!@#$%^&*()_+')?>');
    }

    function Kout_func() {
        document.kakao_form.modeA.value = '';
        document.kakao_form.modeG.value = '';
        document.kakao_form.mode.value = 'chat_logout';
        document.kakao_form.userObject.value = '';
        document.kakao_form.authObject.value = '';
        document.kakao_form.gemail.value = ''; // google
        document.kakao_form.gname.value = '';
        document.kakao_form.action = 'index.php';
        document.kakao_form.submit();
    }

    function Gout_func() {
        document.kakao_form.modeA.value = '';
        document.kakao_form.modeG.value = '';
        document.kakao_form.mode.value = 'chat_logout';
        document.kakao_form.userObject.value = '';
        document.kakao_form.authObject.value = '';
        document.kakao_form.gemail.value = ''; // google
        document.kakao_form.gname.value = '';
        document.location.href =
            " https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=https://fation.net/"; // logout이된다. 그런데 원사이트로 이동하지않는다.
    }

    //----------------------------------------------------------------------
    function kakao_loginX($Kakao_APP_KEY) { // 중요 - Login Button XXX
        alert("kakao_login 64");
        Kakao.init($Kakao_APP_KEY);
        Kakao.Auth.loginForm({
            success: function(authObj) {
                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        document.kakao_form.mode.value = "Kakao_Login";
                        document.kakao_form.userObject.value = JSON.stringify(res);
                        document.kakao_form.authObject.value = JSON.stringify(authObj);
                        document.kakao_form.submit();
                    },
                    fail: function(err) {
                        alert("11 ailinkapp login fail");
                        document.kakao_form.mode.value = 'NO';
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

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";

	$gsajin = "";
	if( $mode == 'Google_Login') { 
		m_("--- 확인용 menu_run mode: " .$mode);
		$gid    = $_POST['gid'];
		$gemail = $_POST['gemail'];
		$gname  = $_POST['gname'];
		$gsajin = $_POST['gsajin'];
		$G_SAJIN= $_POST['gsajin'];
		$nickname = $_POST['gname'];
		$email = $_POST['gemail'];

		set_session('nickname', $_POST["gname"]); //
		set_session('email',    $_POST["gemail"]); //
		set_session('urllink_login_type', "Google"); //

		connect_count('Google login', $gemail, 1, $referer);	// 1: log_info 생성, country code return 요청.
		//login_count( $kemail, "kakao" );

		$member = get_memberT( $gemail, $tkher['tkher_member_table'] );// my_func, email을 index구성한고 검색키로 사용한다.
		if( $member['mb_id']=="" ){ // 회원 등록 - id 가 없으면
			$config = sql_fetch(" SELECT * from {$tkher['config_table']} ");
			urllink_member_setA( $gemail, $gname, $gsajin, 'Google', $tkher['tkher_member_table'], $config['kapp_register_point']); // my_func
			$member = get_memberT( $gemail, $tkher['tkher_member_table'] ); // email을 index구성한고 검색키로 사용한다.
			insert_point_app( $member['mb_id'], $config['kapp_register_point'], $Kday, 'Google_Login@SignUp', $member['mb_id'], $day);
		}
		//------------------------------------------
		set_session('ss_mb_id',    $member['mb_id']);
		set_session('ss_mb_level', $member['mb_level']);
		set_session('ss_mb_key', md5($member['mb_datetime'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));

		//echo("<meta http-equiv='refresh' content='0; URL=indexTT.php'>");

	} else if( $mode == 'Kakao_Login' ) {

		$userObject	= $_POST['userObject'];
		$arr_user	= json_decode( $userObject, true);
		$kname	    = $arr_user['properties']['name'];
		$nickname	= $arr_user['properties']['nickname'];
		$kemail		= $arr_user['kakao_account']['email'];
		set_session('nickname', $nickname);
		set_session('email',    $kemail);
		set_session('urllink_login_type', "Kakao");

		connect_count('Kakao login', $kemail, 1, $referer);	// 1: log_info 생성, 관리자ip log 생성, 0:미생성.
		//login_count( $kemail, "kakao" );
		//$emailA = explode('@', $kemail); //urllink_member_setA 에서 분리한다.
		//$kemail_id = $emailA[0];

		$gsajin = "";
		$member = get_memberT( $kemail, $tkher['tkher_member_table'] );  // email을 index구성한고 검색키로 사용한다.

		if( $member['mb_id']=="" ){	// id는 email을 id로 사용한다. 예: solpakan@kakao.com -> id: solpakan@kakao.com를 id로 생성한다 중요! 2024-01-25 name은 nickname을 사용한다.
			$config = sql_fetch(" SELECT * from {$tkher['config_table']} ");
			urllink_member_setA( $kemail, $nickname, $gsajin, 'Kakao', $tkher['tkher_member_table'], $config['kapp_register_point']);
			//urllink_member_setA( $kemail, $nickname, $gsajin, 'Kakao', $tkher['tkher_member_table'], 3000);
			$member = get_memberT( $kemail, $tkher['tkher_member_table'] );// email을 index구성한고 검색키로 사용한다.
			if( $member['mb_id']=="" ){ }
			insert_point_app($member['mb_id'], $config['kapp_register_point'], $Kday, 'Kakao_Login@SignUp', $member['mb_id'], $day);
		}
		set_session('ss_mb_id',    $member['mb_id']);
		set_session('ss_mb_level', $member['mb_level']);
		set_session('ss_mb_key', md5($member['mb_datetime'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));

		//echo( "<meta http-equiv='refresh' content='0; URL=indexTT.php'>");

	} else if( $mode == 'appgeneratorsystem' ) {
	} else if( get_session("urllink_login_type") == "Naver_Login_K") {
	}
	//---------------------------------------------------------------------------
	function kapp_visit_count(){ // X - no use
		global $login_count_today, $login_count_total, $visit_all_today;
		$day = date("Y-m-d",time());
			$sql = "SELECT sum(vs_count) as total_cnt FROM {$tkher['visit_sum_table']}  ";
			$ret = sql_query( $sql );	//	$cnt = sql_num_rows( $ret );
			$res = sql_fetch_array( $ret);
			$login_count_total = $res['total_cnt'];

			$sql = "SELECT * from {$tkher['visit_sum_table']} WHERE vs_date = '$day' ";
			$ret = sql_query( $sql );
			$cnt = $ret->num_rows;
			if( $ret->num_rows > 0 ) {
				$res = sql_fetch_array( $ret);
				$login_count_today = $res['vs_count'] +1;
				$visit_all_today = $res['visit_all'] +1;
				$sql = " update {$tkher['visit_sum_table']} set visit_all=visit_all+1 where vs_date = '".date("Y-m-d",time())."' ";
				$ret = sql_query( $sql );
				if( $ret ) {
					//m_("ok update visit_all_today: " . $visit_all_today);
				} else {
					m_(" kapp_visit_sum visit_all add error update ");
				}

			} else {	//m_(" select error cnt: " . $cnt);
				$login_count_today = 1;
				$visit_all_today = 1;
				$sql = " insert into `kapp_visit_sum` set vs_count=1, visit_all=1, vs_date = '".date("Y-m-d",time())."' ";
				$ret = sql_query( $sql );
				if( !$ret ) {
					m_(" `kapp_visit_sum` insert error ");	//echo "sql: " . $sql; exit;
				}
			}
	}
	//---------------------------------------------------------------------
	//kapp_visit_count();
	/* tkher_start_necessary에서 처리.
	$kapp_host = isset( $_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
	$H_ID_IPADDR = $kapp_host . "_" . $member['mb_id']. "_" . $_SERVER['REMOTE_ADDR'];
	if( get_cookie('kapp_ck_visit_ip') != $H_ID_IPADDR ) {
		include_once('./kapp_visit_insert.php');
	}*/
	//--------------------------------------------- 회원, 비회원 구분
	if( $member['mb_id']) {
		$is_guest = false;
		$is_member = true;
		$is_admin = is_admin($member['mb_id']);
		$member['mb_dir'] = substr($member['mb_id'],0,2);
	} else {
		$is_member = false;
		$is_guest = true;
		$member['mb_id'] = '';
		$member['mb_level'] = 1; // 비회원의 경우 회원레벨을 가장 낮게 설정
	}
	if( $is_admin != 'super') {
		// 접근가능 IP
		$kapp_possible_ip = trim($config['kapp_possible_ip']);
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

    function Member_info_check() {
        global $member;
        global $tkher;
        if(!Isset($member['mb_password']) || !Isset($member['mb_name']) || !Isset($member['mb_sex']) || !Isset($member['mb_birth']) || !Isset($member['mb_tel']) || !Isset($member['mb_zip1']) || !Isset($member['mb_addr1'])) { // 비밀번호, 이름, 성별, 생년월일, 연락처, 우편번호, 주소
            Add_Info();
        } else if ($member['mb_password'] == '' || $member['mb_name'] == '' || $member['mb_sex'] == '' || $member['mb_birth'] == '' || $member['mb_tel'] == '' || $member['mb_zip1'] == '' || $member['mb_addr1'] == '') {
            Add_Info();
        }
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
	$H_ID = $member['mb_id'];
	$H_LEV= $member['mb_level'];
	$ip   = $_SERVER['REMOTE_ADDR'];
	$cur="";
    if( $H_ID && $H_LEV > 1 && get_cookie('add_info') != 'next') Member_info_check(); // 비어있는 회원정보 체크
?>

    <!-- end -->
    <form name='kakao_form' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='modeG' value='' />
        <input type='hidden' name='modeA' value='' />
        <input type='hidden' name='mode' value='' />
        <input type='hidden' name='gid' value='' />
        <input type='hidden' name='gsite' value='' />
        <input type='hidden' name='gsajin' value='' />
        <input type='hidden' name='gemail' value='' />
        <input type='hidden' name='gname' value='' />
        <input type='hidden' name='g_email' value=''>
        <input type='hidden' name='g_fullname' value=''>
        <input type='hidden' name='g_image' value=''>
        <input name="userObject" id="userObject" type="hidden" value='<?=$_POST['userObject']?>' /><!-- kakao -->
        <input name="authObject" id="authObject" type="hidden" value='<?=$_POST['authObject']?>' /><!-- kakao -->
    </form>
    <form name='form_menu' method='post' enctype="multipart/form-data">
        <input type='hidden' name='mode' value=''>
        <input type='hidden' name='board'>
    </form>
    <ul id='nav'>
        <li <?php if( $cur=='A') echo "class='current'"; ?>>
            <a href="#" title='HOME'><img src='<?=KAPP_URL_T_?>/icon/logo60.png'
                    style='border-style:;height:20px;'></a>
            <ul>
                <li align='left'>
                    <a href="/kapp" target='_top'>0. Home</a>
                </li>
                <li align='left'>
                    <a href="<?=KAPP_URL_T_?>/privacy_policy_en.html" target='_blank'>1. Privacy Policy</a>
                </li>
                <li align='left'>
                    <a href="<?=KAPP_URL_T_?>/terms_service_en.html" target='_blank'>2. Service Terms</a>
                </li>
                <!-- <li align='left'><a href="3" target='_blank'>3. Notice</a>
                    <ul> -->
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=1" target='_top'>31. Notice</a></li>
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=2" target='_top'>32. News</a></li>
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=3" target='_top'>33. Q&A</a></li>
                        <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=4" target='_top'>34. Free Board</a></li>
                    <!-- </ul>
                </li> -->
                <?php
	if( $H_ID && $H_LEV > 7) { // 관리자용. 메인 메뉴 설정.
?>
                <li align='left'> <a href='<?=KAPP_URL_T_?>/adm/' target='_blank'
                        <?php echo " title='Admin Page. ' "; ?>>--- Admin ---</a></li>
                <li align='left'> <a href='<?=KAPP_URL_T_?>/menu/main_img.php' target='_top'
                        <?php echo " title='Admin Register the main image. ' "; ?>>B3. Main-Image Insert</a></li>
                <li align='left'> <a href='<?=KAPP_URL_T_?>/menu/main_image_list.php' target='_top'
                        <?php echo " title='Admin Main image list. ' "; ?>>B4. Main-Image-List</a></li>
                <!-- <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=161" target='_blank'>B6. Data Room</a> </li>
                <li align='left'><a href="<?=KAPP_URL_T_?>/menu/index_bbs.php?infor=188" target='_blank'>B7. YouTube</a> </li> -->
                <!-- <li align='left'><a href="<?=KAPP_URL_T_?>/adm/board_list_adm.php" target='_blank' >B8. Board Adm</a> </li> -->
                <!-- <li align='left'><a href="<?=KAPP_URL_T_?>/menu/board_list3.php" target='_blank'>B8. Board Adm</a></li> -->
                <!-- <li align='left'><a href="<?=KAPP_URL_T_?>/menu/board_list_admin.php" target='_blank'>B8. Board Admin</a> </li> -->
                <li align='left'><a href="<?=KAPP_URL_T_?>/setup/DB_Table_CreateA.php" target='_blank'>B5. Kapp Table List</a> </li>
                <li align='left'><a href="<?=KAPP_URL_T_?>/curl_server.php" target='_blank'>B6. Shared-Server Reset</a> </li>
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
                        <!-- sign up 을 막기위해... SS를 SSS로 변경. -->
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
                <!-- <li align='left'> <a href='#' target='_self' <?php echo " title='Manage user albums. ' "; ?>>B1.My-Album</a>
						<ul>
							<li align='left'> <a href="<?=KAPP_URL_T_?>/my/album_view_db_my.php" target='_top' <?php echo " title='A list of my images. ' "; ?> >1.Album-List</a></li>
							<li align='left'> <a href="<?=KAPP_URL_T_?>/album_insert.php" target='_top' <?php echo " title='Register images in DB.' "; ?> >2.Album registration</a></li>
							<li align='left'> <a href="<?=KAPP_URL_T_?>/album_view_dir.php" target='_top' <?php echo " title='Registers all the images in the user's directory in the DB.' "; ?> >3.Album-directory</a></li>
							<li align='left'> <a href="<?=KAPP_URL_T_?>/album_slide_my.php" target='_top' <?php echo " title='Registers all the images in the user's directory in the DB.' "; ?> >4.Album-Slide</a></li>
						</ul>
					</li>  -->
                <li align='left'> <a href='#' target='_self'
                        <?php echo " title='Manage user schedule. ' "; ?>>B2.Schedule</a>
                    <ul>
                        <li align='left'> <a href="<?=KAPP_URL_?>/calendar/" target='_top'
                                <?php echo " title='Manage user schedule.' "; ?>>1.Daily schedule</a></li>
                        <li align='left'> <a href="<?=KAPP_URL_?>/calendar/index_year.php" target='_top'
                                <?php echo " title=' Manage annual schedules.' "; ?>>2.Year Schedule</a></li>
                    </ul>

                </li>
                <li align='left'><a href='<?=KAPP_URL_?>/accountbook/' target='_self'
                        <?php echo " title='Manage user accountbook.' "; ?>>B3.Account book</a></li>
                <!-- <li align='left'><a href='<?=KAPP_URL_T_?>/my/board_list_my.php' target='_top' <?php echo " title='Board List.' "; ?>>B4. My board list</a></li>
					<li align='left'><a href='<?=KAPP_URL_T_?>/my_note_list.php' target='_top' <?php echo " title='My note list.' "; ?>>B5. My note list</a></li> -->
                <!-- <?php if($H_LEV > 7 ) { ?>
					<li align='left'><a href='<?=KAPP_URL_T_?>/tree_menu_sysbom.php?mid=dao' target='_top' <?php echo " title='Dao old tree list.' "; ?>>B6. Old tree list</a></li>
			<?php } ?> -->

                <li align='left'>
                    <div class="SSS">
                        <!-- sign up 을 막기위해... SS를 SSS로 변경. -->
                        <a href="<?=KAPP_URL_T_?>/chatS" target='_blank' title='Chat consulting '>Chat consulting</a>
                    </div>
                </li>
                <?php
		} // if H_ID
?>
            </ul>
        </li>
        <?php
		$pg_run='./index.php';
	//if( $is_mobile ) $pg_run='/pg_menu3.php';
	//else  $pg_run='/index.php';
?>

        <li <?php echo "class='current'"; ?>>
            <a href='#' target='run_menu' <?php echo " title='K-App Create a program.' "; ?>><img
                    src='<?=KAPP_URL_T_?>/icon/pcman1.png' style='border-style:;height:20px;'>App Make</a>
            <ul>
                <li align='left'> <a href='<?=KAPP_URL_T_?>/index.php?open_mode=on' target='_top'
                        <?php echo " title='Create a program.' "; ?>>C0.Program-Make</a></li>
                <li align='left'>
                    <a href="<?=KAPP_URL_T_?>/program_list3u.php" title='Program List by User' target='_top'>C1.Program
                        List</a>
                </li>

                <!-- 않됨. <li align='left'> <a href='./menu/cratree_my_list_menu.php' target='_self' <?php echo " title='Popup menu list.' "; ?>>CL. Popup Menu List</a></li> -->
                <!-- <li align='left'> <a href='<?=KAPP_URL_T_?>/menu/cratree_my_list_menu.php' target='_self' <?php echo " title='Tree and Popup menu list.' "; ?>>C2. Tree Menu List</a></li>  -->
                <li align='left'> <a href='<?=KAPP_URL_T_?>/menu/index.php' target='_self' title='Tree list.'>C2. Tree
                        Menu List</a></li>
                <?php
	//if( $is_mobile ) $board_run = KAPP_URL_T_ . '/menu/board_list3m.php';
	//else  $board_run = KAPP_URL_T_ . '/menu/board_list3.php';
	$board_run = KAPP_URL_T_ . '/menu/board_list3.php';
	// <- board_list.php, /contents/board_create_pop.php, /contents/board_list_admin.php
	?>
                <li align='left'><a href="<?=$board_run?>" title='Board list' target='_top'>C3.Board List </a></li>
                <li align='left'>
                    <!-- <a href="<?=KAPP_URL_T_?>/link_list_all.php" title='List by group' target='_top'>C4.Link List</a> -->
					<a href="<?=KAPP_URL_T_?>/menu/ulink_list.php" title='List by group' target='_top'>C4.Link List</a><!-- 2025-03-29  -->
                </li>
            </ul>
        </li>
    </ul>
    <FORM name="menu_table_list" Method='post'>
        <input type='hidden' name='pg_name'>
        <input type='hidden' name='pg_code'>
        <input type='hidden' name='mode'>
    </FORM>

    <?php
if( !$H_ID  ) {
?>
    <div class="loginBox">
        <div class="rela">
            <FORM name='loginA' action='<?=KAPP_URL_T_?>/login_checkT.php' method='post' enctype="multipart/form-data">
                <input type='hidden' name='mode' value=''>
                <a href="javascript:void(0);" class="loginClose" title="-bg_closeBtn-"><img src="<?=KAPP_URL_T_?>/include/img/bg_closeBtn.png" /></a>
                <div class="pic"><img src="<?=KAPP_URL_T_?>/include/img/etc_login.png" /></div>
                <div class="form">
                    <div class="row">
                        <label for="loginid">E-mail</label><!-- ID를 Email로 Title만 변경 2025-05-18 -->
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
                <div>
                    <table>
                        <tr>
                            <td>
                                <!-- <img height='36' src='<?=KAPP_URL_T_?>/icon/kakao.jpg'
                                    onclick='javascript:Kakao_Login_func()'
                                    title='Kakao_Login_func:menu_run' />&nbsp;&nbsp;&nbsp; -->
                            </td> <!-- 카카오 로그인 버튼 -->
                            <td>
                                <!-- <div class='g-signin2' data-onsuccess='onSignIn' data-theme='dark'
                                    title='Google Login menu_run'></div> -->
                                <!-- <div id='buttonDiv' style='text-align: -webkit-center;' title='Google Login A'></div> -->
                                <!-- 구글 로그인 버튼 -->
                            </td>
                        <tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <?php } else { ?>
    <div class="loginBox">
        <div class="rela">
            <FORM name='loginO' action='<?=KAPP_URL_T_?>/logoutT.php' method='post' enctype="multipart/form-data">
                <input type='hidden' name='mode' value=''>
            </form>
        </div>
    </div>
    <?php }
		/*if( $Search_Mode == "cratree_my_list_menu") {
			$Search_run = KAPP_URL_T_ . "/menu/index.php"; // cratree_my_list_menu.php
		} else {
			$Search_Mode = "PG";
			$Search_run = KAPP_URL_T_ . "/menu/ulist.php";
		}*/
			$Search_Mode = "PG";
			//$Search_run = KAPP_URL_T_ . "/menu/ulist.php";
			$Search_run = KAPP_URL_T_ . "/menu/ulink_list.php";

		if( isset($_POST['sdata']) ) $sdata = $_POST['sdata'];
		else $sdata = "";
?>
    <div>
        <table board='0'>
            <FORM name="fsearchbox" method="post" action="<?=$Search_run?>">             <!-- onsubmit="return search_run(this);" -->
                <input type='hidden' name='Search_Mode' value='<?=$Search_Mode?>' />          <!-- Search_Mode :cratree_my_list_menu  2023-10-27 -->
                <td><a href="/kapp" target='_top'><img src="<?=KAPP_URL_T_?>/icon/logo.png" height='30'
                            title='appgenerator home'></a></td>
                <td><input type="text" name="sdata" value="<?=$sdata?>" maxlength="250" style='height:30;'>
                </td>
                <td><input type="button" id="sch_submit" value=" Search " onclick='search_run("<?=KAPP_URL_T_?>")'
                        style='height:30;' title='ulist mode:<?=$Search_Mode?>'></td>
                <td><input type="button" id="sch_submit" value=" Tree-Search "
                        onclick='search_Tree("<?=KAPP_URL_T_?>")' style='height:30;'
                        title='Tree mode:<?=$Search_Mode?>'></td>
            </form>
        </table>
    </div>
<?php
$log_i = "";
if( isset($H_ID) && $H_LEV > 1 ) { //get_session("urllink_login_type") , $_SESSION['urllink_login_type']
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

<?php }

	function menu_call($sys_submenu, $cnt){
		global $H_ID;
			$sqla = " SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$H_ID' and sys_pg='$H_ID' and sys_menu='$sys_submenu' order by sys_disno";
			$reta = sql_query($sqla);
			while( $rsa = sql_fetch_array($reta)) {
				$pg_lnk		= $rsa['sys_link'];
				$link_gubun = $rsa['tit_gubun'];
				if( $link_gubun == 'u' )	{	// u: url 작접 연결.
					echo " <li align=center> <a href='".$pg_lnk."' target='_blank' title='$rsa[sys_link]' >" . $rsa['sys_subtit'] . "</a></li> ";
				} else {
					$lnkR = explode(":", $pg_lnk);
					echo " <li align=center> <a href=\"javascript:program_run_func1( '".$lnkR[1]."', '$lnkR[0]' );\" target=_self title='".$rsa['sys_link']."' >" . $rsa['sys_subtit'] . "</a></li> ";
				}
			}
	}
?>
    <script language="JavaScript">
    <!--
    function init() {
        fsearchbox.sdata.focus();
    }

    function search_Tree(Search_Mode) {
        sdata = document.fsearchbox.sdata.value;
        if (!sdata) {
            alert(" Search data All!:"); //alert(" Search data Insert Please!:" + sdata);
            //alert(" Search data Insert Please!:" + sdata);
            //return false;
        }
        /*if (fsearchbox.sdata.value.length < 2) { //alert("Please enter at least one character. 검색어는 1자 이상 입력하십시오.");
        	alert("Please enter at least two character. ");
        	fsearchbox.sdata.select();
        	fsearchbox.sdata.focus();
        	return false;
        }*/
        //alert("KAPP_URL_T_: ");
        document.fsearchbox.Search_Mode.value = "cratree_my_list_menu";
        document.fsearchbox.action = Search_Mode + "/menu/index.php"; // cratree_my_list_menu.php
        document.fsearchbox.submit();
    }

    function search_run(Search_Mode) {
        sdata = document.fsearchbox.sdata.value;
        if (!sdata) {
            alert(" Search data Insert Please!:" + sdata);
            return false;
        }
        if (fsearchbox.sdata.value.length < 2) { //alert("Please enter at least one character. 검색어는 1자 이상 입력하십시오.");
            alert("Please enter at least two character. ");
            fsearchbox.sdata.select();
            fsearchbox.sdata.focus();
            return false;
        }
        //	alert("sr: " + $sr);
        document.fsearchbox.Search_Mode.value = "";
        document.fsearchbox.action = Search_Mode + "/menu/ulink_list.php"; // ulist.php
        document.fsearchbox.submit();
    }

    function program_run_func1(pg_name, pg_code) {
        if (!pg_name || !pg_code) {
            alert('There is no connection information.'); // \n 연결정보가 없습니다.
            return false;
        }
        document.menu_table_list.mode.value = "run_mode";
        document.menu_table_list.pg_name.value = pg_name;
        document.menu_table_list.pg_code.value = pg_code;
        document.menu_table_list.target = '_blank';
        document.menu_table_list.action = "./tab_list_pg70.php";
        document.menu_table_list.submit();
    }

    function program_run_func2(url_) {
        document.form_menu.action = url_;
        document.form_menu.submit();
    }

    function run_board_func(url, board) {
        document.form_menu.mode.value = 'bbs_listTT';
        document.form_menu.board.value = board;
        document.form_menu.action = url;
        document.form_menu.submit();
    }

    function run_func(url) {
        document.form_menu.mode.value = 'run';
        document.form_menu.action = url;
        document.form_menu.submit();
    }

    function logout_func() {
        document.loginO.mode.value = "logout";
        document.loginO.target = "_top";
        document.loginO.action = './logoutT.php';
        document.loginO.submit();
    }

    function My_Page() {
        gemail = document.form_view.email.value;
        document.form_view.target = '_top';
        document.form_view.action = './my/';
        document.form_view.submit();
    }
    -->
    </script>

    <script>
    $(function() {
        $('.A_Login').on('click', function() { // login - call.
            var id = document.loginA.mb_id.value;
            var pw = document.loginA.mb_password.value;
            if (id == '') {
                alert('Please enter your ID !!! ');
                document.loginA.mb_id.focus();
                return false;
            }
            if (pw == '') {
                alert('Please enter a password.');
                document.loginA.mb_password.focus();
                return false;
            }

            document.loginA.mode.value = "A_login";
            document.loginA.submit();
        });

        $('.Sign_up').on('click', function() {

            document.loginA.mode.value = "signup";
            var Upg1_ = "./tkher_register_.php";
            document.loginA.action = Upg1_;
            document.loginA.submit();
        });
        $('.SIGN_S').on('click', function() {
            document.loginA.mode.value = "signup";
            var Upg1_ = "./tkher_register_.php";
            document.loginA.action = Upg1_;
            document.loginA.submit();
        });

        $('.login_close').on('click', function(no) {
            //location.href="w.php?no="+no;
        });
    });
    </script>

    <script type="text/javascript">
    var $grid;
    $(function() {

        $("body").on("click", ".C", function() {
            document.loginO.mode.value = "logout";
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
            document.form_view.action = './my/'; //'/cratree/r1_my.php';
            document.form_view.submit();
        });
    });
    //----------------------------------------------------------------------
    function kakao_login($Kakao_APP_KEY) { // 중요 - Login Button
        //alert("kakao_login 486");
        Kakao.init($Kakao_APP_KEY);

        Kakao.Auth.loginForm({
            success: function(authObj) {
                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        document.kakao_form.mode.value = "Kakao_Login_K"; // 2024-04-01 수정
                        document.kakao_form.userObject.value = JSON.stringify(res);
                        document.kakao_form.authObject.value = JSON.stringify(authObj);
                        document.kakao_form.action = 'login_checkT.php'; // 2024-04-01 추가
                        document.kakao_form.submit();
                    },
                    fail: function(err) {
                        alert("1 --- login fail");
                        document.kakao_form.mode.value = 'NO';
                    }
                });
            },
            fail: function(err) {
                alert(JSON.stringify(err))
                alert("2 --- login fail:" + JSON.stringify(err));
            },
        })
    }

    /* function LoginBox_Open() {
        alert("login_click");
        $(".loginBox").stop().animate({
            "right": "0"
        }, 200, 'linear');
    } */
    </script>
