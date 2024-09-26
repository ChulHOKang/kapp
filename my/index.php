  <?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if($H_LEV < 2) {
		m_("my page login please");
		echo("<meta http-equiv='refresh' content='0; URL=../index.php'>"); exit;
	}

	date_default_timezone_set("Asia/Seoul");
	$day		= date("Y-m-d H:i:s");
   /* ------------------------------------------ 최종 사용 프로그램 임다. 중요.
	  --- 이것을 알아야 하는 이유, 이것을 사용해야 하는 이유 ---
	  1. 이것은 나의 미래를 결정한다.
	  2. 이것은 나의 경쟁력이다.
	  3. 이것은 1시간이면 알수있고, 1주일이면 나도 전문가다
	  4. 이것은 나의 상상력을 펼치기 위한 필수 조건이다.
	  5. 이것을 아는것은 힘이요, 원동력이다.
	  --------------------------------------------------
		tkher_my_control, tkher_main_img
		$sql = " SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
		$sql = " SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher' and group_name='main' order by view_no ";
		/t/tree_menu_guest.php : Guest View Mobile <- /t/menu/tree_menu_updateM2.php 을 copy
						  : /t/menu/tree_menu_updateM2.php 사용 하지 않음.
						  /t/my_list_menu.php에서도 call.중요.
		http://urllinkcoin.com/t/tree_run_menuM_guest.php?num=dao_1612581000&mid=dao 사용자 통합실행용. 중요.
		tree_run_menu.php -> runf_my_create.php -> tree_run_generator.php -> r1_my.php
					 최초 r1_my.php : my page에서 실행한다.
		http://urllinkcoin.com/cratree/tree_run_menu.php?mid=dao&num=dao1612683061&jong=B&target_=my_solpa_user_r
   -------------------------------------------------------- */
   $r = explode("/", $_SERVER['SCRIPT_FILENAME'] ); //SCRIPT_FILENAME: /home1/solpakanurl/public_html/t/index2.php
   $cnt = count($r);
   $_url = "./" . $r[$cnt-1];
   if( isset($_REQUEST['mid']) ) $mid = $_REQUEST['mid'];
   else $mid = '';
   if( isset($_POST['mode']) ) $mode = $_POST['mode'];
   else $mode = '';
   if( $mode == 'SearchPG'){
		$_SESSION['sys_pg'] = $_POST['sys_pg'];
		//$run_ = "../tree_menu_guest.php?sys_pg=" . $_POST['sys_pg'] . "&open_mode=on". "&mid=".$mid;
		$run_ = "../menu/tree_run.php?sys_pg=" . $_POST['sys_pg'] . "&open_mode=on". "&mid=".$mid;
		echo "<script>window.open( '".$run_."' , '_top', ''); </script>";
		exit;
   }
?>
<html> 
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
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
<!-- <link rel='stylesheet' href='./include/css/kancss.css' type='text/css'>  -->

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
	function arunG( r, sys_pg, tit ){
		f = document.click_run;
		f.sys_pgS.value = sys_pg;
		f.sys_subtitS.value = tit;
		f.target = '_blank';
		f.action = r; 
		f.submit();
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
	$sys_subtitS = 'Admin App Generator';
	if( isset( $_REQUEST['sys_pg'] ) ) { 
		$sys_pg	     = $_REQUEST['sys_pg']; 
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
	if( $sys_pg && $mid ) {
		$sqlupdate = "update {$tkher['sys_menu_bom_table']} set view_cnt=view_cnt+1 where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg'";
		$rtup = sql_query( $sqlupdate);
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg' ";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		$sys_subtitS = $rs['sys_subtit'];
	} else if( $sys_pg ) {
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg' ";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		$sys_subtitS = $rs['sys_subtit'];
	} else if( !$sys_pg ) {
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and tit_gubun !='' and sys_level = 'mroot' order by up_day desc";
		$rt = sql_query( $sql);
		if( !$rt ) {
			$rs	= sql_fetch_array($rt);
			$gubun  = $rs['tit_gubun'];
			$sys_pg = $rs['sys_pg'];
			$sys_subtitS = $rs['sys_subtit'];
		} else {
			$gubun  = '';
			$sys_pg = '';
			$sys_subtitS = 'Admin App Generator';
		}
	} 
	$kapp = "K-App My Page : " . $H_ID;
?>
<form name='click_run' action='' method='post' enctype='multipart/form-data' target='run_menu'> 
	<div class="header"><!-- start : header -->
		<?php //include "./menu_run.php"; ?>
	<div class="visualSlide">
	<?php // echo $slide_msg; ?>
	</div> 
<div id="mySidenav" class="sidenav">
	  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><!-- X 버턴 -->
		<center>
		<a href='<?=KAPP_URL_T_?>' target='_top' title='go home:<?=KAPP_URL_T_?>'><img src="<?=KAPP_URL_T_?>/icon/logo.png" title='<?=KAPP_HOST_?>:<?=KAPP_URL_T_?> - home'></a>
	<?php
		$run_target='run_menu'; // $run_target='url_link_tree_solpa_user_r';
		$img_v="<img src='".KAPP_URL_T_."/icon/pizza.png' width='15' height='15'>";
	?>
	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<div style="color:cyan; background-color:black; height:33px; border:none">K-App My Page<br>[ <?=$H_ID?> ]</div>
	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='bbs_history_myjob.php' target='run_menu' title='table design'>1.<img src='<?=KAPP_URL_T_?>/icon/pizza.png' width='15' height='15'>Job History</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='./point_list_my.php' target='run_menu' title='table design'>2.<img src='<?=KAPP_URL_T_?>/icon/ship.png' width='15' height='15'>Point history</a></li>

	<!-- <li style='font-size:18;color:#666666; height:21px; line-height:1; text-align:left' ><a onclick="run_on();" href='./board_list_my.php' target='run_menu' title='table design'>3.<img src='<?=KAPP_URL_T_?>/icon/seedX.png' width='15' height='15'>Board List</a></li> -->
	<li style='font-size:18;color:#666666; height:21px; line-height:1; text-align:left' ><a onclick="run_on();" href='<?=KAPP_URL_T_?>/menu/board_list3.php' target='run_menu' title='table design'>3.<img src='<?=KAPP_URL_T_?>/icon/seedX.png' width='15' height='15'>Board List</a></li>

	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='./program_list_my.php' target='run_menu' title='table design'>4.<img src='<?=KAPP_URL_T_?>/icon/appmaker.jpg' width='15' height='15'>Program List</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='./table10i_my.php' target='run_menu'>5.<img src='<?=KAPP_URL_T_?>/icon/Uleaf.png' width='15' height='15'>Table List</a></li>
	<!-- <li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='../table30m_amy.php' target='run_menu'>6.<img src='<?=KAPP_URL_T_?>/icon/Uleaf.png' width='15' height='15'>Table Design</a></li> -->
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='program_pglist_my.php' target='run_menu'>7.<img src='<?=KAPP_URL_T_?>/icon/seed.png' width='15' height='15'>Program List B</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/menu/index.php' target='run_menu'>8.<img src='<?=KAPP_URL_T_?>/icon/leaf.png' width='15' height='15'>K-Tree</a></li><!-- old:ktree_list_my.php -->
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='treelist2_my.php' target='run_menu'>9.<img src='<?=KAPP_URL_T_?>/icon/berry.png' width='15' height='15'>Link List</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='kapp_member_my.php' target='run_menu' title='table design'>A.<img src='<?=KAPP_URL_T_?>/icon/pizza.png' width='15' height='15'>My Info</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='album_slide_my.php' target='run_menu' title='Album Slide'>B.<img src='<?=KAPP_URL_T_?>/icon/pizza.png' width='15' height='15'>Album Slide</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='album_view_db_my.php' target='run_menu' title='Album List'>C.<img src='<?=KAPP_URL_T_?>/icon/pizza.png' width='15' height='15'>Album List</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='album_insert_my.php' target='run_menu' title='Album Insert'>D.<img src='<?=KAPP_URL_T_?>/icon/pizza.png' width='15' height='15'>Album Insert</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='<?=KAPP_URL_T_?>/logoutT.php' target='run_menu' title='table design'>Z.<img src='<?=KAPP_URL_T_?>/icon/seed.png' width='15' height='15'>LogOut</a></li>
	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<li style='font-size:9;color:#666666;height:9px;line-height:1'>
	We call it mining to register in the tree menu.<br><!-- 우리는 트리 메뉴에 등록하는것을 채굴이라 한다 -->
	Points will be paid in coins in the future.<br><!-- 포인트는 향후에 코인으로 지급될것이다. -->
	If it does not work, <br>please unblock the pop-up window.<!-- 작동하지 않으면 팝업 창을 차단 해제하십시오. -->
	</li>
</div>
</div><!-- head -->
</form>
<div style="background-color:black;">
<span style="font-size:24px;cursor:pointer;color:cyan;background-color:black;" onclick="openNav()" title='tree menu list'>&#9776; <?=$kapp?><img src="<?=KAPP_URL_T_?>/icon/logo120-120.png" align='center' style="margin:0px auto;height:24px;" title='<?=KAPP_HOST_?>'></span>
</div>
<center>
<?php
//	$src = KAPP_URL_T_ . '/index.php';
	$src = KAPP_URL_T_ . '/my/album_slide_my.php';
?>
</form>
<iframe src='<?=$src?>' title='url data' name='run_menu' width='100%' height='100%'></iframe>  
</body>
</html>
<?php
	if( $_REQUEST['open_mode'] == 'on' ) {
	  echo "<script>document.getElementById('mySidenav').style.width = '250px';</script>";
	}
?>