<?php
	include_once('../tkher_start_necessary.php');
	$ss_mb_id		= get_session("ss_mb_id");   //"ss_mb_id";
	$ss_mb_level	= $member['mb_level'];    //get_session("ss_mb_level");   //"ss_mb_id";
	$H_ID				= get_session("ss_mb_id");
	$H_LEV			= $member['mb_level'];  
	$ip					= $_SERVER['REMOTE_ADDR'];
/*
bbs_history_admin.php
*/
//m_("KAPP_URL_T_:" . KAPP_URL_T_);
?>
<html>
<head>
	<title>K-APP Management</title>
<link rel='StyleSheet' HREF='../include/css/style_history.css' type='text/css' >

<script language='javascript'>
<!--

	function set_del( mode, name, no ) {
		document.board_set.mode.value = mode;
		document.board_set.bname.value = name;
		document.board_set.no.value		= no;
		document.board_set.submit();
	}

//-->
</script>

<link rel="stylesheet" type="text/css" href="../include/css/dddropdownpanel.css" />
<script type="text/javascript" src="../include/js/dddropdownpanel.js">
/***********************************************
* DD Drop Down Panel- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Please keep this notice intact
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/
</script>

</head>
<body bgcolor='white' onLoad="initA()">

<p><b>K-App 관리 Ver 0.1 [user:<?=$H_ID?>, user_level:<?=$H_LEV?>] <p>
<?php
	include "bbs_history_my.php";
?>
</body>
</html>