  <?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");
	if( $H_ID == '' ) {
		m_("login please");
		echo("<meta http-equiv='refresh' content='0; URL=../'>"); exit;
	}
	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if( $H_LEV < 8) {
		m_("admin page");
		echo("<meta http-equiv='refresh' content='0; URL=../'>"); exit;
	}

	date_default_timezone_set("Asia/Seoul");
	$day		= date("Y-m-d H:i:s");

	$r = explode("/", $_SERVER['SCRIPT_FILENAME'] );
	$cnt = count($r);	//m_("count:" . $cnt . ", r:" . $r[$cnt-1]); // count:6, r:indexApp.php
	$_url = "./" . $r[$cnt-1];

	if( isset($_REQUEST["mid"])) $mid = $_REQUEST["mid"];
	else $mid = '';

	if( isset($_REQUEST["mode"])) $mode = $_REQUEST["mode"];
	else $mode = '';
	if( isset($_REQUEST['open_mode']) ) $open_mode = $_REQUEST['open_mode'];
	else $open_mode = "";

	if( $mode == 'SearchPG'){
		$_SESSION['sys_pg'] = $_POST['sys_pg'];
		$run_ = "../menu/tree_run.php?sys_pg=" . $_POST['sys_pg'] . "&open_mode=on". "&mid=".$mid;
		echo "<script>window.open( '".$run_."' , '_top', ''); </script>";
		exit;
	}

?>
<html> 
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="../icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>
<style>
body {
  font-family: "Lato", sans-serif;
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
	a:active {color:#CCCCFF; text-decoration:none} 
	a:hover {color:#01ff01; text-decoration:none} 
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
.sidenav a:hover {
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
<style type="text/css"> 
	body, td, div, a {font-size:15pt;font-family:Arial;} 
	a:link {color:#33FF33; text-decoration:none} 
	a:visited {color:#33FF33; text-decoration:none} 
	a:active {color:#33FF33; text-decoration:none} 
	a:hover {color:#01ff01; text-decoration:none} 
	body, td { 
		scrollbar-face-color: #3399ff;  
		scrollbar-shadow-color: #99ccff;  
		scrollbar-highlight-color: #99ccff;  
		scrollbar-3dlight-color: #99ccff;  
		scrollbar-darkshadow-color: #99ccff;  
		scrollbar-track-color: #99ccff;  
		scrollbar-arrow-color: #99ccff; 
	} 
.HeadTitle01AX{display:inline-block;margin:0 1px;height:30px;line-height:0px;padding:0 20px;font-size:21px;background:#d01c27;color:#fff;border-radius:5px;}  
.HeadTitle01AX a.on{background:#d01c27;color:#000;}  
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
	function init() {  
	    document.getElementById("mySidenav").style.width = "250px";
	}
</script>
</head> 
<body onLoad="init()" oncontextmenu='return false' ondragstart='return false' onselectstart='return false' topmargin='0' style='background-color:white'> 
<?php

$sys_subtitS = 'Admin K-App';

	if( isset( $_REQUEST['sys_pg'] ) ) { 
		$sys_pg	= $_REQUEST['sys_pg']; 
		$sys_subtitS = $_REQUEST['sys_subtitS'];
	} else if( isset($_POST['sys_pg']) ) {
		$sys_pg	= $_POST['sys_pg']; 
	} else if( isset($_SESSION['sys_pg']) ) {
		$sys_pg = $_SESSION['sys_pg'];
		$sys_subtitS = $_SESSION['sys_subtitS'];
	} else if( isset($_POST['sys_pgS']) ) {
		$sys_pg = $_POST['sys_pgS']; 
		$sys_subtitS = $_POST['sys_subtitS'];
	} else {
		$sys_pg	= get_session("sys_pg"); 
	}
	$kapp = "K-App Admin";
?>
<form name='click_run' action='' method='post' enctype='multipart/form-data' target='run_menu'> 
	<div class="header">
		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<center>
		<a href='<?=$_url?>' target='_top'><img src="<?=KAPP_URL_T_?>/icon/logo.png" title='K-App - home'></a>
	<?php
		$run_target='run_menu';
		$img_v="<img src='".KAPP_URL_T_."/icon/pizza.png' width='15' height='15'>";
	?>
	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<div style="color:cyan; background-color:black; height:33px; border:none"><a href="index_adm.php" target='_BLANK' title="Admin Control Setup Page">K-App Admin<br>[ <?=$H_ID?> ]</a></div>
	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='kapp_history.php' target='run_menu' title='Job History'>1.<img src='<?=KAPP_URL_T_?>/icon/pizza.png' width='15' height='15'>Job History</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='kapp_member.php' target='run_menu' title='Kapp Member'>2.<img src='<?=KAPP_URL_T_?>/icon/berry.png' width='15' height='15'>Kapp Member</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='point_list_adm.php' target='run_menu' title='Point history'>3.<img src='<?=KAPP_URL_T_?>/icon/ship.png' width='15' height='15'>Point history</a></li>
	
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='kapp_permission_adm.php' target='run_menu' title='Program permission'>5.<img src='<?=KAPP_URL_T_?>/icon/appmaker.jpg' width='15' height='15'>APP R/W Permission</a></li>

	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='kapp_program_list_adm_ai.php' target='run_menu' title='Program List detail'>5.<img src='<?=KAPP_URL_T_?>/icon/appmaker.jpg' width='15' height='15'>Program List AI</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='program_pglist_adm.php' target='run_menu'>8.<img src='<?=KAPP_URL_T_?>/icon/seed.png' width='15' height='15'>Program List B</a></li>

	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='kapp_table_list_adm.php' target='run_menu'>9.<img src='<?=KAPP_URL_T_?>/icon/seed.png' width='15' height='15'>Table List</a></li>

	<li style='font-size:18;color:cyan;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='../setup/DB_Table_CreateA.php' target='run_menu' title='Setup Table of KAPP System'>a.<img src='<?=KAPP_URL_T_?>/icon/leaf.png' width='15' height='15'>Setup Table</a></li>

	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<li style='font-size:11;color:#fff;height:9px;line-height:1'><?=$config['kapp_visit']?><br>
	If it does not work, <br>please unblock the pop-up window.
	</li>
</div>
</div>
</form>

<div style="background-color:black;">
<span style="font-size:24px;cursor:pointer;color:cyan;background-color:black;" onclick="openNav()" title='tree menu list'>&#9776; <?=$kapp?><img src="<?=KAPP_URL_T_?>/icon/logo120-120.png" align='center' style="margin:0px auto;height:24px;" title='K-App'></span>
</div>
<center>
<?php
	$src = '../indexTT.php';
?>
</form>
<iframe src='<?=$src?>' title='url data' name='run_menu' width='100%' height='100%'></iframe>  
</body>
</html>
<?php
	if( $open_mode == 'on' ) {
	  echo "<script>document.getElementById('mySidenav').style.width = '250px';</script>";
	}
?>