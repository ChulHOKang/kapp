<?php
	include_once('./kapp_start_necessary_TT.php');
   /* ----------------------------------------------------------------------
		index.php - kapp_start_necessary_TT.php
		indexTT.php - tkher_start_necessary.php
		--- 이것을 알아야 하는 이유, 이것을 사용해야 하는 이유 ---
		1. 이것은 나의 미래를 결정한다.
		2. 이것은 나의 경쟁력이다.
		3. 이것은 1시간이면 알수있고, 1주일이면 나도 전문가다
		4. 이것은 나의 상상력을 펼치기 위한 필수 조건이다.
		5. 이것을 아는것은 힘이요, 원동력이다.
		------------------------------------------
   -------------------------------------------------------- */
	
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
<link rel='stylesheet' href='<?=KAPP_URL_T_?>/include/css/kancss.css' type='text/css'>

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
</style>

<style>
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
		document.click_run.make_type.value   ='booktreeupdateM2';
		document.click_run.m_type.value   ='booktreeupdateM2';
		document.click_run.data.value   =sys_menu;
		document.click_run.data1.value  =sys_submenu;
		document.click_run.target = 'run_menu';
		if( runtype=='update'){
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php'; // root 하단 목록.
			document.click_run.submit();
		} else if( runtype=='insert'){
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php'; // root 하단 목록.
			document.click_run.submit();
		} else if( runtype=='' || runtype=='run'){
			if( pg.indexOf( 'contents_view_menu.php')>=0 ) {
				document.click_run.target='run_menu';
				document.click_run.target_.value='run_menu';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}else if( pg.indexOf( 'contents/index.php?infor')>=0 )  {
				document.click_run.target='run_menu';
				document.click_run.target_.value='run_menu';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}else if( pg.indexOf( 'https://')>=0 )  {

				document.click_run.target='_blank';
				document.click_run.target_.value='_top'; //'_blank';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}else if( pg.indexOf( 'http://')>=0 )  {

				document.click_run.target='_blank';
				document.click_run.target_.value= '_top';//target_;//'_top';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			} else {
				document.click_run.target='run_menu';
				document.click_run.target_.value='_self';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}
			document.getElementById("mySidenav").style.width = "250px";
		} else {
			if (link_.indexOf( 'contents_view_menu.php')>=0 ) {
				document.click_run.target='run_menu';
				document.click_run.target_.value='run_menu';
				document.click_run.action= './menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}else if (link_.indexOf( 'contents/index.php?infor')>=0 )  {
				document.click_run.target='run_menu';
				document.click_run.target_.value='run_menu';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}else if (pg.indexOf( 'https://')>=0 )  {
				document.click_run.target='_blank';
				document.click_run.target_.value='_top'; //'_blank';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			} else {
				document.click_run.target='_blank';
				document.click_run.target_.value='run_menu';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}
			document.getElementById("mySidenav").style.width = "250px";
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
	function arunC(){
		f = document.click_run;
		f.target = 'run_menu';
		f.action = './chatS/';
		f.submit();
		document.getElementById("mySidenav").style.width = "0";
	}

	function arunA( runtype ){
		document.click_run.make_type.value   ='booktreeupdateM2';
		document.click_run.m_type.value   ='booktreeupdateM2';
		if( runtype=='insert' ){
			document.click_run.mode.value    ='mroot';
			document.click_run.runtype.value = 'insert';
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php';
			document.click_run.submit();
		} else if( runtype=='update' ){
			document.click_run.mode.value    ='mroot';
			document.click_run.runtype.value = 'update';
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php';
			document.click_run.submit();
		} else if( runtype=='run' ){
			document.click_run.runtype.value = 'run';
		} else if( runtype=='list' ){
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/index.php';
			document.click_run.submit();
			click_run.menu_change[0].value   = 'list';
			click_run.menu_change[0].text    = 'Tree list';
			document.getElementById('click_run'+0).value = 'list';
			document.getElementById('click_run'+0).innerHTML = 'Tree list';
			document.getElementById("mySidenav").style.width = "0";
		} else if( runtype=='design' ){
			document.click_run.runtype.value = 'design';
			document.click_run.make_type.value = 'booktreeupdateM2';
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_remake_book_menu.php';
			document.click_run.submit();
			click_run.menu_change[0].value   = 'design';
			click_run.menu_change[0].text    = 'Tree design';
			document.getElementById('click_run'+0).value = 'design';
			document.getElementById('click_run'+0).innerHTML = 'Tree design';
			document.getElementById("mySidenav").style.width = "0";
		} else {
			document.click_run.runtype.value = 'run';
		}
	}
	*/
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
		<?php //include "./menu_run.php"; ?>
		<div class="visualSlide">
			<?php //echo $slide_msg; ?>
		</div>
		<div id="mySidenav" class="sidenav">
			  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
				<center>
				<a href='<?=KAPP_URL_T_?>' target='_top'><img src="<?=KAPP_URL_T_?>/logo/logo.png" title='K-APP Home'></a>
		<?php
				$run_target='run_menu';
				$img_v="<img src='".KAPP_URL_T_ . "/logo/pizza.png' width='22' height='22'>";
			?>
			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
<?php if( $H_ID ) { ?>
			<li align="center" style="color:cyan; background-color:black; height:21px; border:none"><?=$H_ID?></li>
<?php } else { ?>
			<li align="center" style="color:cyan; background-color:black; height:21px; border:none;list-style-type:none">K-APP</li>
<?php } ?>
			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
			<li style='font-size:18;color:cyan;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_project.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/icon/project_.png' width='22' height='22'>Project Management</a></li>
			
			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;' title='table design for high level' ><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table30m_A.php' target='run_menu' title='table design for High Level'><img src='<?=KAPP_URL_T_?>/logo/pizza.png' width='22' height='22'>Table Design</a></li>

			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;' title='table design for high level' ><a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_table_index_Create.php' target='run_menu' title='table design for High Level'><img src='<?=KAPP_URL_T_?>/logo/pizza.png' width='22' height='22'>Create index of Table</a></li>

			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;' title='table design for high level' ><a onclick="run_on();" href='<?=KAPP_URL_T_?>/tableK_sql.php' target='run_menu' title='table design for High Level'><img src='<?=KAPP_URL_T_?>/logo/pizza.png' width='22' height='22'>SQL to Table</a></li>
			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table10i.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/Uleaf.png' width='22' height='22'>Table List</a></li>

			<!-- <li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/app_pg50RC.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/appmaker.jpg' width='22' height='22'>Program Create</a></li> -->

			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_pg_Create.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/appmaker.jpg' width='22' height='22'>Program Create</a></li>
			
			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/kapp_pg_Upgrade.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/_board_.jpg' width='22' height='22'>Program Upgrade</a></li>

			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/app_permission.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/land25.png' width='22' height='22'>App Permissions setting</a></li>

			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table_relationA.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/seed.png' width='22' height='22'>Table Relationship</a></li>
			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/program_list3.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/seedX.png' width='22' height='22'>Program List A</a></li>
			<li style='font-size:18;color:#666666;height:28px;line-height:1; text-align:left;list-style-type:none;'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/program_pglist.php' target='run_menu'><img src='<?=KAPP_URL_T_?>/logo/berry.png' width='22' height='22'>Program List B</a></li>

			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />

			<li style='font-size:9;color:#666666;height:9px;line-height:1'>
			K-APP
			</li>
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
