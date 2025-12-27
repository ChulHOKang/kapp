<?php
	include_once('./kapp_start_necessary_TT.php');
   /*
		index.php - kapp_start_necessary_TT.php
		indexTT.php - tkher_start_necessary.php
   */
	
	$H_ID = get_session("ss_mb_id");
	if( isset($member['mb_level']) ) $H_LEV= $member['mb_level'];
	else $H_LEV =0;
	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Seoul");
	$day		= date("Y-m-d H:i:s");
	if( isset($_REQUEST['open_mode']) ) $open_mode = $_REQUEST['open_mode'];
	else $open_mode = "";

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";
	if( $mode == 'Google_Login') {
		set_session("urllink_login_type", $_POST['modeG']);
	}
	if( isset($_REQUEST['mid']) ) $mid = $_REQUEST['mid'];
	else $mid = "";
	if( $mode == 'SearchPG'){
		$_SESSION['sys_pg'] = $_POST['sys_pg'];
		$run_ = KAPP_URL_T_ . "/menu/tree_run.php?sys_pg=" . $_POST['sys_pg'] . "&open_mode=on". "&mid=".$mid;
		echo "<script>window.open( '".$run_."' , '_top', ''); </script>";
		exit;
	}
?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. no coding system. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="./icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="web app generator, web app, web, no coding, CRUD, php, DB, php source code, web tool ">
	<meta name="description" content="web app generator, web app, web, no coding, CRUD, php, DB, php source code, web tool ">
<meta name="robots" content="ALL">
</head>

<style>
body {
  font-family: "Arial", sans-serif;
}

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
	body, td, div, a {font-size:12pt;font-family:Arial;}
	a:link {color:#CCCCFF; text-decoration:none}
	a:visited {color:#CCCCFF; text-decoration:none}
	a:hover {color:#01ff01; text-decoration:none}
	a:active {color:white; text-decoration:none}
	body, td {
		scrollbar-face-color: #3399ff;
		scrollbar-shadow-color: #99ccff;
		scrollbar-highlight-color: #99ccff;
		scrollbar-3dlight-color: #99ccff;
		scrollbar-darkshadow-color: #99ccff;
		scrollbar-track-color: #99ccff;
		scrollbar-arrow-color: #99ccff;
	}
}

.sidenav a:active {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

 @media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<link rel='stylesheet' href='<?=KAPP_URL_T_?>/include/css/kancss.css' type='text/css'>

<style type="text/css">
	body, td, div, a {font-size:15pt;font-family:Arial;}
	a:link {color:#33FF33; text-decoration:none;}
	a:visited {color:#33FF33; text-decoration:none;}
	a:hover {color:#01ff01; text-decoration:solid underline purple 4px;}
	a:active {color:white; text-decoration:none;}
	body, td {
		scrollbar-face-color: #3399ff;
		scrollbar-shadow-color: #99ccff;
		scrollbar-highlight-color: #99ccff;
		scrollbar-3dlight-color: #99ccff;
		scrollbar-darkshadow-color: #99ccff;
		scrollbar-track-color: #99ccff;
		scrollbar-arrow-color: #99ccff;
	}
</style>

<script>
	function openNav() {
	  document.getElementById("mySidenav").style.width = "250px";
	}
	function closeNav() {
	  document.getElementById("mySidenav").style.width = "0";
	}
	function About(no) {
	  document.getElementById("mySidenav").style.width = "0";
	}
	function run_on(){
		document.getElementById("mySidenav").style.width = "0";
	}
	function init(open_mode) {
		if( open_mode == 'on') document.getElementById("mySidenav").style.width = "250px";
	    else document.getElementById("mySidenav").style.width = "0px";
	}
</script>
</head>

<body onLoad="init('<?=$open_mode?>')" oncontextmenu='return false' ondragstart='return false' onselectstart='return false' topmargin='0' style='background-color:white;'>
<?php
	$sys_subtitS = 'K-App Generator';
	if( isset( $_REQUEST['sys_pg'] ) ) {
		$sys_pg	= $_REQUEST['sys_pg'];
		if( isset($_REQUEST['sys_subtitS']) ) $sys_subtitS = $_REQUEST['sys_subtitS'];
		else $sys_subtitS = "";
	} else if( isset($_POST['sys_pg']) ) {
		$sys_pg	= $_POST['sys_pg'];
	} else if( isset($_SESSION['sys_pg']) ) {
		$sys_pg = $_SESSION['sys_pg'];
		if( isset($_SESSION['sys_subtitS']) ) $sys_subtitS = $_SESSION['sys_subtitS'];
		else $sys_subtitS = "";
	} else if( isset($_POST['sys_pgS']) ) {
		$sys_pg = $_POST['sys_pgS'];
		if( isset($_POST['sys_subtitS']) ) $sys_subtitS = $_POST['sys_subtitS'];
		else $sys_subtitS = "";
	} else {
		$sys_pg	= get_session("sys_pg");
	}
	if( isset($sys_pg) && isset($mid) ) {
		$sqlupdate = "update {$tkher['sys_menu_bom_table']} set view_cnt=view_cnt+1 where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg'";
		$rtup = sql_query( $sqlupdate);
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg' ";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		if( isset($rs['sys_subtit']) ) $sys_subtitS = $rs['sys_subtit'];
		else $sys_subtitS = "";
	} else if( isset($sys_pg) ) {
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg' ";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		if( isset($rs['sys_subtit']) ) $sys_subtitS = $rs['sys_subtit'];
		else $sys_subtitS = "";
	} else if( !isset($sys_pg) ) {
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and tit_gubun !='' and sys_level = 'mroot' order by up_day desc";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		if( isset($rs['sys_pg']) ) {
			$gubun  = $rs['tit_gubun'];
			$sys_pg = $rs['sys_pg'];
			$sys_subtitS = $rs['sys_subtit'];
		} else {
			$gubun  = "";
			$sys_pg = "";
			$sys_subtitS = "";
		}
	}
	$kapp = "K-App";
?>

<form name='click_run' action='' method='post' enctype='multipart/form-data' target='run_menu'>

	<div class="header"><!-- start : header -->
		<div id="mySidenav" class="sidenav">
			  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
				<center>
				<a href='<?=KAPP_URL_T_?>' target='_top'><img src="<?=KAPP_URL_T_?>/logo/logo.png" title='K-APP Home'></a>
			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
<?php if( $H_ID ) { ?>
			<li align="center" style="color:cyan; background-color:black; height:21px; border:none"><?=$H_ID?></li>
<?php } else { ?>
			<li align="center" style="color:cyan; background-color:black; height:21px; border:none;list-style-type:none">K-APP</li>
<?php } ?>
			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
			
			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_project.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/icon/project_.png' style='width:24px;height:22px;'>.Project Management</a></li>
			
			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_table30m_A.php' target='run_menu' title='table design for High Level'>
			<img src='<?=KAPP_URL_T_?>/logo/pizza.png' style='width:24px;height:22px;'>.Table Design</a></li>

			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_table_index_Create.php' target='run_menu' title='table design for High Level'>
			<img src='<?=KAPP_URL_T_?>/logo/pizza.png' style='width:24px;height:22px;'>.Create index of Table</a></li>

			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;' title='table design for high level'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/tableK_sql.php' target='run_menu' >
			<img src='<?=KAPP_URL_T_?>/logo/pizza.png' style='width:24px;height:22px;'>.SQL to Table</a></li>
			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;' title='table design for high level'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_table_relationA.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/seed.png' style='width:24px;height:22px;'>.Table Relationship</a></li>

			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/table10i.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/pizza.png' style='width:24px;height:22px;'>.Table List</a></li>

			<!-- <li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/app_pg50RC.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/appmaker.jpg' style='width:24px;height:22px;'>Program Create</a></li> -->

			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_pg_Create.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/appmaker.jpg' style='width:24px;height:22px;'>.Program Create</a></li>
			
			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_pg_Upgrade.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/_board_.jpg' style='width:24px;height:22px;'>.Program Upgrade</a></li>

			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/app_permission.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/land25.png' style='width:24px;height:22px;'>.App Permissions</a></li>

			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/program_list3.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/seedX.png' style='width:24px;height:22px;'>.Program List A</a></li>
			<li style='font-size:18;color:#666666;height:18px;line-height:1; text-align:left;'>
			<a onclick="run_on();" href='<?=KAPP_URL_T_?>/program_pglist.php' target='run_menu'>
			<img src='<?=KAPP_URL_T_?>/logo/berry.png' style='width:24px;height:22px;'>.Program List B</a></li>

			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
			<li style='font-size:9;color:#666666;height:9px;line-height:1'>K-APP</li>
		</div>
	</div><!-- head -->
</form>

<div style="background-color:black;">
	<span style="font-size:26px;cursor:pointer;color:cyan;background-color:black;" onclick="openNav()" title='KAPP:<?=KAPP_URL_T_?>: tree menu list'>&#9776; K-APP</span>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href='<?=KAPP_URL_T_?>' style="margin:3px auto 0px;"><img src="<?=KAPP_URL_T_?>/logo/logo120-120.png" style="margin:3px auto 0px;height:26px;" title='K-APP Home'></a>
</div>

<center>
<?php
	$src = KAPP_URL_T_ . '/indexTT.php';
?>
<iframe src='<?=$src?>' title='url data' name='run_menu' width='100%' height='100%'></iframe>
			<!-- <a href="javascript:common.openProj01()" class="btn_req">
				<span>PROJECT REQUEST</span>
				<img src="./include/img/ico/ico_arr01.png" />
			</a> -->
</body>
</html>
<?php
	if( $open_mode == 'on' ) {
	  echo "<script>document.getElementById('mySidenav').style.width = '250px';</script>";
	}
?>
