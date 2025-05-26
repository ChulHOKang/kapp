  <?php
	include_once('../tkher_start_necessary.php'); // kapp_start_necessary_TT.php, tkher_start_necessary.php
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if($H_LEV < 8) {
		m_("admin page");
		echo("<meta http-equiv='refresh' content='0; URL=/'>"); exit;
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
		//echo "<script>run_r1_func('r1.php');</script>"; 
		//echo "<script>window.open( 'r1.php' , '_top', ''); </script>";
		//$run_ = "tree_menu_guest.php?sys_pg=" . $_POST['sys_pg'] . "&open_mode=on". "&mid=".$mid;
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
/*
function submit_run( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_){ 

	runtype = document.click_run.runtype.value;
		document.click_run.sys_menu.value    =sys_menu;   
		document.click_run.sys_submenu.value =sys_submenu;   
		document.click_run.num.value         =num;   
		document.click_run.pg.value          =pg;   
		document.click_run.jong.value        =jong;  
		document.click_run.title_.value      =title_;   
		document.click_run.link_.value       =link_;
	document.click_run.mid.value         =mid; 
	document.click_run.sys_pg.value      =sys_pg; 
	document.click_run.sys_pg_root.value =sys_pg; 
	document.click_run.mode.value        ='rowlevel'; ///////////////////////////////////////// 
	document.click_run.make_type.value   ='booktreeupdateM2'; // newcratree
	document.click_run.m_type.value   ='booktreeupdateM2'; // newcratree
	document.click_run.data.value   =sys_menu; 
	document.click_run.data1.value  =sys_submenu; 
	document.click_run.target = 'run_menu'; 
	if( runtype=='update'){
		document.click_run.action = './menu/tree_menu_update.php'; // root 하단 목록.
		document.click_run.submit();     
	} else if(runtype=='insert'){
		document.click_run.action = './menu/treebom_insert2_book_menu.php'; // root 하단 목록.
		document.click_run.submit();     
	} else if(runtype=='' || runtype=='run'){
		if (pg.indexOf( 'contents_view_menu.php')>=0 ) { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if (pg.indexOf( 'contents/index.php?infor')>=0 )  { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if (pg.indexOf( 'https://')>=0 )  { 
			document.click_run.target='_blank';  
			document.click_run.target_.value='_top'; //'_blank';  
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		}else if (pg.indexOf( 'http://')>=0 )  { 
			document.click_run.target='_blank'; 
			document.click_run.target_.value= '_top';//target_;//'_top'; 
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		} else { 
			document.click_run.target='run_menu'; 
			document.click_run.target_.value='_self'; 
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		}
		document.getElementById("mySidenav").style.width = "0px";
	} else {
		if (link_.indexOf( 'contents_view_menu.php')>=0 ) { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if (link_.indexOf( 'contents/index.php?infor')>=0 )  { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if (pg.indexOf( 'https://')>=0 )  { 
			//alert('-- https');
			document.click_run.target='_blank';  
			document.click_run.target_.value='_top'; //'_blank';  
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		} else { // 일반 http://사이트
			//document.click_run.target='run_menu'; 
			document.click_run.target='_blank'; 
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= './menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		}
		//document.getElementById("mySidenav").style.width = "250px";
		document.getElementById("mySidenav").style.width = "0px";
	}

}   
	function arunA( runtype ){ //menu_change
		document.click_run.make_type.value   ='booktreeupdateM2'; // newcratree
		document.click_run.m_type.value   ='booktreeupdateM2'; // newcratree
		if( runtype=='insert' ){
			document.click_run.mode.value    ='mroot'; ////////////// add 2021-09-19 - test OK
			document.click_run.runtype.value = 'insert';
			document.click_run.target='run_menu';  
			document.click_run.action = './menu/treebom_insert2_book_menu.php'; // root 하단 목록.
			document.click_run.submit();     
		} else if( runtype=='update' ){
			document.click_run.mode.value    ='mroot'; ////////////// add 2021-09-19 - test OK
			document.click_run.runtype.value = 'update';
			document.click_run.target='run_menu';  
			document.click_run.action = './menu/tree_menu_update.php'; // root 하단 목록.
			document.click_run.submit();     
		} else if( runtype=='run' ){
			document.click_run.runtype.value = 'run';
		} else if( runtype=='list' ){
			document.click_run.target='run_menu';
			document.click_run.action = './menu/cratree_my_list_menu.php';
			document.click_run.submit();
			click_run.menu_change[0].value   = 'list';
			click_run.menu_change[0].text    = 'Tree list';
			document.getElementById('click_run'+0).value = 'list';
			document.getElementById('click_run'+0).innerHTML = 'Tree list'; // 출력.
			document.getElementById("mySidenav").style.width = "0";
		} else if( runtype=='design' ){
			document.click_run.runtype.value = 'design'; 
			document.click_run.make_type.value = 'booktreeupdateM2'; 
			document.click_run.target='run_menu';
			document.click_run.action = './menu/tree_remake_book_menu.php';
			document.click_run.submit();
			click_run.menu_change[0].value   = 'design';
			click_run.menu_change[0].text    = 'Tree design';
			document.getElementById('click_run'+0).value = 'design';
			document.getElementById('click_run'+0).innerHTML = 'Tree design'; // 출력.
			document.getElementById("mySidenav").style.width = "0";
		} else {
			document.click_run.runtype.value = 'run'; 
		}
	}
	function arunG( r, sys_pg, tit ){
		f = document.click_run;
		f.sys_pgS.value = sys_pg;
		f.sys_subtitS.value = tit;
		f.target = '_blank';
		f.action = r; 
		f.submit();
	}
	function sys_pg_change( sys_pg ) {  
		pg = sys_pg.split(":");
		document.click_run.sys_pgS.value = pg[0];
		document.click_run.sys_subtitS.value = pg[1];
		document.click_run.sys_pg.value = pg[0];
		document.click_run.treetype.value = 'B';
		document.click_run.mode.value='SearchPG';
		document.click_run.target='_self';
		document.click_run.action='./tree_menu_guest.php';
		document.click_run.submit();
	    document.getElementById("mySidenav").style.width = "250px";
	}
*/
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
		$rs	= sql_fetch_array($rt);
		if( isset($rs['tit_gubun']) ) $gubun  = $rs['tit_gubun'];
		else $gubun  = '';
		if( isset($rs['sys_pg']) ) $sys_pg = $rs['sys_pg'];
		else $sys_pg = '';
		if( isset($rs['sys_subtit']) ) $sys_subtitS = $rs['sys_subtit'];
	} 
	$kapp = "K-App Admin";
?>
<form name='click_run' action='' method='post' enctype='multipart/form-data' target='run_menu'> 
	<div class="header"><!-- start : header -->

		<!-- <div class="visualSlide"><?php echo $slide_msg; ?></div>  -->

		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><!-- X 버턴 -->
		<center>
		<a href='<?=$_url?>' target='_top'><img src="<?=KAPP_URL_T_?>/icon/logo.png" title='K-App - home'></a>
	<?php
		$run_target='run_menu'; // $run_target='url_link_tree_solpa_user_r';
		$img_v="<img src='".KAPP_URL_T_."/icon/pizza.png' width='15' height='15'>";
	?>
	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<div style="color:cyan; background-color:black; height:33px; border:none"><a href="index_adm.php" target='_BLANK' title="Admin Control Setup Page">K-App Admin<br>[ <?=$H_ID?> ]</a></div>
	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='kapp_history.php' target='run_menu' title='table design'>1.<img src='<?=KAPP_URL_T_?>/icon/pizza.png' width='15' height='15'>Job History</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='kapp_member.php' target='run_menu' title='table design'>2.<img src='<?=KAPP_URL_T_?>/icon/berry.png' width='15' height='15'>Kapp Member</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='point_list_adm.php' target='run_menu' title='table design'>3.<img src='<?=KAPP_URL_T_?>/icon/ship.png' width='15' height='15'>Point history</a></li>
	
	<!-- <li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='board_list_adm.php' target='run_menu' title='table design'>4.<img src='<?=KAPP_URL_T_?>/icon/seedX.png' width='15' height='15'>Board List</a></li> -->
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='<?=KAPP_URL_T_?>/menu/board_list3.php' target='run_menu' title='table design'>4.<img src='<?=KAPP_URL_T_?>/icon/seedX.png' width='15' height='15'>Board List</a></li>

	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='program_list_adm.php' target='run_menu' title='table design'>5.<img src='<?=KAPP_URL_T_?>/icon/appmaker.jpg' width='15' height='15'>Program List</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='table10i_adm.php' target='run_menu'>6.<img src='<?=KAPP_URL_T_?>/icon/Uleaf.png' width='15' height='15'>Table List</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table30m_A.php' target='run_menu'>7.<img src='<?=KAPP_URL_T_?>/icon/Uleaf.png' width='15' height='15'>Table Design</a></li><!-- '../table30m_amy.php' - 2024-03-13 -->
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='program_pglist_adm.php' target='run_menu'>8.<img src='<?=KAPP_URL_T_?>/icon/seed.png' width='15' height='15'>Program List B</a></li>
	<li style='font-size:18;color:cyan;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/menu/index.php' target='run_menu'>9.<img src='<?=KAPP_URL_T_?>/icon/leaf.png' width='15' height='15'>K-Tree</a></li><!-- old: ktree_list_adm.php -->
	<li style='font-size:18;color:cyan;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='ulist_admin.php' target='run_menu'>9.<img src='<?=KAPP_URL_T_?>/icon/leaf.png' width='15' height='15'>U-List</a></li>
	<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' ><a onclick="run_on();" href='../logoutT.php' target='run_menu' title='table design'>A.<img src='<?=KAPP_URL_T_?>/icon/seed.png' width='15' height='15'>LogOut</a></li>

	<li style='font-size:18;color:cyan;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='../setup/DB_Table_CreateA.php' target='run_menu'>a.<img src='<?=KAPP_URL_T_?>/icon/leaf.png' width='15' height='15'>Setup Table</a></li>

	<li style='font-size:18;color:cyan;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='./index.php' target='_TOP'>A.<img src='<?=KAPP_URL_T_?>/icon/leaf.png' width='15' height='15'>SUPER</a></li>

	<li style='font-size:18;color:cyan;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='../admB/index_adm.php' target='_BLANK'>A.<img src='<?=KAPP_URL_T_?>/icon/leaf.png' width='15' height='15'>ADM-B</a></li>

	<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
	<li style='font-size:11;color:#fff;height:9px;line-height:1'><?=$config['kapp_visit']?><br>
	We call it mining to register in the tree menu.<br><!-- 우리는 트리 메뉴에 등록하는것을 채굴이라 한다 -->
	Points will be paid in coins in the future.<br><!-- 포인트는 향후에 코인으로 지급될것이다. -->
	If it does not work, <br>please unblock the pop-up window.<!-- 작동하지 않으면 팝업 창을 차단 해제하십시오. -->
	</li>
</div>
</div><!-- head -->
</form>

<div style="background-color:black;">
<span style="font-size:24px;cursor:pointer;color:cyan;background-color:black;" onclick="openNav()" title='tree menu list'>&#9776; <?=$kapp?><img src="<?=KAPP_URL_T_?>/icon/logo120-120.png" align='center' style="margin:0px auto;height:24px;" title='K-App'></span><!-- Tree List -->
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