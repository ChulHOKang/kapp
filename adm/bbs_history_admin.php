<?php
	include_once('../tkher_start_necessary.php');

	$H_ID				= get_session("ss_mb_id"); $ip= $_SERVER['REMOTE_ADDR'];

	if( isset($member["mb_level"])) $H_LEV = $member["mb_level"];
	else $H_LEV = 0;

/*
    bbs_history_admin.php :
	 - bbs_history.pgp
*/
	if( $H_LEV < 8) {
		m_("admin page"); 
		echo("<meta http-equiv='refresh' content='0; URL=index.php'>");
		exit;
	}
?>
<html>
<head>
	<title>K-App 관리 Ver 0.1</title>
<link rel='StyleSheet' HREF='../include/css/style_history.css' type='text/css' >

<script language='javascript'>
<!--
	function set_func( mode, name ) {

		//alert(' name=' + name);
		//location.href="insert_group.php?mode=insert_group&g_name="+g_name;
		document.board_set.mode.value = mode;
		document.board_set.bname.value = name;
		document.board_set.submit();
		//location.href="admin_bbs_func.php?mode=config&name="+name;

	}
	function set_clear( mode, name ) {

		//alert(' name=' + name);
		//location.href="insert_group.php?mode=insert_group&g_name="+g_name;
		//location.href="admin_bbs_func.php?mode=config&name="+name;
		document.board_set.mode.value = mode;
		document.board_set.bname.value = name;
		document.board_set.submit();
	}
	function set_del( mode, name, no ) {

		//alert(' name=' + name);
		//location.href="insert_group.php?mode=insert_group&g_name="+g_name;
		//location.href="admin_bbs_func.php?mode=config&name="+name;
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
<body bgcolor='white'>

<p><b>K-App 관리 Ver 0.1 [user:<?=$H_ID?>, user_level:<?=$H_LEV?>] <p>

<?php
	include "bbs_history.php";
?>
</body>
</html>