<?php
	include_once('../tkher_start_necessary.php');
	$ss_mb_id		= get_session("ss_mb_id");   //"ss_mb_id";
	$ss_mb_level	= $member['mb_level'];    //get_session("ss_mb_level");   //"ss_mb_id";
	$H_ID				= get_session("ss_mb_id");
	$H_LEV			= $member['mb_level'];  
	$ip					= $_SERVER['REMOTE_ADDR'];
	if( $H_LEV < 8) {
		m_(" no admin "); 
		echo("<meta http-equiv='refresh' content='0; URL=index.php'>");
		exit;
	}
	/*
		kapp_history.php  : = bbs_history_myjob.php
		kapp_history_.php : = bbs_history_admin.php
	*/
?>
<html>
<head>
	<title>K-APP Management</title>
<link rel='StyleSheet' HREF='../include/css/style_history.css' type='text/css' >
<script src="//code.jquery.com/jquery.min.js"></script>

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

<p><b>K-APP Management Ver 1.1 [user:<?=$H_ID?>, user_level:<?=$H_LEV?>] <p>
<?php
	include "kapp_history_.php";
?>
</body>
</html>