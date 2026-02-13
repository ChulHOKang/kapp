<?php
	include_once('./tkher_start_necessary.php');
	if( get_session("urllink_login_type") == "Google") {
		session_unset();
		session_destroy();
		set_cookie('ck_mb_id', '', 0);
		set_cookie('ck_auto', '', 0);
		echo "<script>top.location.href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=".KAPP_URL_T_."'</script>";
	} else {
		session_unset();
		session_destroy();
		set_cookie('ck_mb_id', '', 0);
		set_cookie('ck_auto', '', 0);
		if( isset($_REQUEST['run_pg']) ) $link = $_REQUEST['run_pg'];
		else $link = KAPP_URL_T_;
		echo "<script>window.open( '$link' , '_top', ''); </script>";
		exit;
	}
?>
