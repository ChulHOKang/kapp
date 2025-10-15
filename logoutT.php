<?php
	include_once('./tkher_start_necessary.php');

	if( get_session("urllink_login_type") == "Google") { //$_SESSION['urllink_login_type']
		session_unset(); // 모든 세션변수를 언레지스터 시켜줌
		session_destroy(); // 세션해제함

		// 자동로그인 해제 --------------------------------
		set_cookie('ck_mb_id', '', 0);
		set_cookie('ck_auto', '', 0);

		echo "<script>top.location.href=' https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=".KAPP_URL_."'</script>";
		//echo "<script>location.href='/t/chatS/'</script>";
	} else {

		session_unset(); // 모든 세션변수를 언레지스터 시켜줌
		session_destroy(); // 세션해제함

		// 자동로그인 해제 --------------------------------
		set_cookie('ck_mb_id', '', 0);
		set_cookie('ck_auto', '', 0);
		// 자동로그인 해제 end --------------------------------

		if( isset($_REQUEST['run_pg']) ) $link = $_REQUEST['run_pg'];
		else $link = KAPP_URL_;// "./";
		//goto_url($link);
		//$url="/";
		echo "<script>window.open( '$link' , '_top', ''); </script>";
		exit;
	}
?>
