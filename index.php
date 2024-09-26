<?php
	include_once('./kapp_start_necessary_TT.php');	//include_once('./tkher_start_necessary.php');, kapp_start_necessary_TT.php
	
	$H_ID = get_session("ss_mb_id");
	if( isset($member['mb_level']) ) $H_LEV= $member['mb_level'];
	else $H_LEV =0;
	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set("Asia/Seoul");
	$day		= date("Y-m-d H:i:s");
   /* ------------------------------------------ 최종 사용 프로그램 임다. 중요.
	index.php
	- include : kapp_start_necessary_TT.php , old: tkher_start_necessary.php
	- iframe  : indexTT.php
	            - include : tkher_start_necessary.php

	--- 이것을 알아야 하는 이유, 이것을 사용해야 하는 이유 ---
	1. 이것은 나의 미래를 결정한다.
	2. 이것은 나의 경쟁력이다.
	3. 이것은 1시간이면 알수있고, 1주일이면 나도 전문가다
	4. 이것은 나의 상상력을 펼치기 위한 필수 조건이다.
	5. 이것을 아는것은 힘이요, 원동력이다.

	email id:solpakan, dir create OK : /var/www/html/t/file/solpakan

	--------------------------------------------------
	tkher_my_control, tkher_main_img
	$sql = " SELECT * from {$tkher['tkher_my_control_table']} where userid='tkher' ";
	$sql = " SELECT * from {$tkher['tkher_main_img_table']} where userid='tkher' and group_name='main' order by view_no ";


	/t/menu/tree_run.php <- /t/tree_menu_guest.php : Guest View Mobile <- /t/menu/tree_menu_updateM2.php 을 copy
						  : /t/menu/tree_menu_updateM2.php 사용 하지 않음.
						  /t/my_list_menu.php에서도 call.중요.

	http://urllinkcoin.com/t/tree_run_menuM_guest.php?num=dao_1612581000&mid=dao 사용자 통합실행용. 중요.

		tree_run_menu.php -> runf_my_create.php -> tree_run_generator.php -> r1_my.php
					 최초 r1_my.php : my page에서 실행한다.

	http://urllinkcoin.com/cratree/tree_run_menu.php?mid=dao&num=dao1612683061&jong=B&target_=my_solpa_user_r
   -------------------------------------------------------- */
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";
	if( $mode == 'Google_Login') {
	set_session("urllink_login_type", $_POST['modeG']);
	}

	$r = explode("/", $_SERVER['SCRIPT_FILENAME'] );
	$cnt = count($r);  //m_("count:" . $cnt . ", r:" . $r[$cnt-1]); // count:6, r:indexApp.php
	$_url = "./" . $r[$cnt-1];

	if( isset($_REQUEST['mid']) ) $mid = $_REQUEST['mid'];
	else $mid = "";

	if( $mode == 'SearchPG'){
		$_SESSION['sys_pg'] = $_POST['sys_pg'];	//echo "<script>run_r1_func('r1.php');</script>";
		$run_ = KAPP_URL_T_ . "/menu/tree_run.php?sys_pg=" . $_POST['sys_pg'] . "&open_mode=on". "&mid=".$mid;
		echo "<script>window.open( '".$run_."' , '_top', ''); </script>";
		exit;
	}

	//m_( "PHP_VERSION: " . PHP_VERSION . ", index - userObject:" . $_POST['userObject'] . ", authObject:" . $_POST['authObject']);
	//PHP_VERSION: 8.2.4, index - userObject:, authObject:

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

<script language="javascript">
<!--
function run_r1_func( run_program ){ // SearchPG 사용하지 않음,
	//alert('----- run_program:'+run_program);
	document.click_run.target='_top';
	document.click_run.action='r1.php';
	document.click_run.submit();
}

function submit_runX( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_){

	document.click_run.mid.value=mid;
	document.click_run.sys_pg.value=sys_pg;
	document.click_run.sys_menu.value=sys_menu;
	document.click_run.sys_submenu.value=sys_submenu;
	document.click_run.num.value=num;
	document.click_run.pg.value=pg;
	document.click_run.jong.value=jong;
	document.click_run.title_.value=title_;
	document.click_run.link_.value=link_;
	if (pg.indexOf( 'https://')>=0 || pg.indexOf( 'https://naver')>=0 || pg.indexOf('https://google')>=0 )
	{
		document.click_run.target='_blank';
		document.click_run.target_.value='_top'; //'_blank';
		document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
		//'/cratree/cratree_coinadd.php';
		document.click_run.submit();
	}else if (link_.indexOf( 'contents_view_menu.php')>=0 ) {
		document.click_run.target='run_menu';
		document.click_run.target_.value='run_menu';
		document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
		document.click_run.submit();
	} else {
		document.click_run.target='run_menu';   // target_
		document.click_run.target_.value='_self'; //target_
		document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
		// '/cratree/cratree_coinadd.php';
		document.click_run.submit();
	}
	//document.getElementById("mySidenav").style.width = "250px";
	document.getElementById("mySidenav").style.width = "0px";
}

/*
function clickHandler() {
	var  targetId, srcElement,  targetElement;
	srcElement = window.event.srcElement;
	if (srcElement.className == "solpa_tree_main") {
		targetId = srcElement.id + "d";
		targetElement = document.all( targetId);
		if ( targetElement.style.display == "none") {
			targetElement.style.display = "";
			srcElement.src = "/cratree/skins_treeicon/as00/img11_l.gif";
		} else {
			targetElement.style.display = "none";
			srcElement.src = "/cratree/skins_treeicon/as00/img12_r.gif";
		}
	}
} */
//document.onclick = clickHandler;

//-->
</script>

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
	  alert('------ no:'+no);
	}
	//--------- runtype - Insert, Update, RUN --------------------
	function submit_run( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_){

		runtype = document.click_run.runtype.value;
		//alert( 'tree_menu_guest - submit_run - sys_pg:' + sys_pg +','+runtype);
		//tree_menu_guest - submit_run - sys_pg:dao_1612585805, runtype:, link_:http://urllinkcoin.com/t/t_sel.php

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
		//alert('runtype:'+runtype);
		if( runtype=='update'){
			//document.click_run.mode.value        ='mroot'; /////////////////////////////////////////
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php'; // root 하단 목록.
			document.click_run.submit();
			//document.getElementById("mySidenav").style.width = "250px";
			//document.getElementById("mySidenav").style.width = "0px";

		} else if( runtype=='insert'){
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php'; // root 하단 목록.
			document.click_run.submit();

		} else if( runtype=='' || runtype=='run'){
				//alert('tree_menu_guest --- runtype:'+runtype);
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
				//alert('tree_menu_guest --- ');
				document.click_run.target='run_menu';
				document.click_run.target_.value='_self';
				//document.click_run.target='_blank';
				//document.click_run.target_.value='run_menu';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}
			//document.getElementById("mySidenav").style.width = "250px";
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
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}else if (pg.indexOf( 'https://')>=0 )  {
				//alert('-- https');
				document.click_run.target='_blank';
				document.click_run.target_.value='_top'; //'_blank';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			} else { // 일반 http://사이트
				//document.click_run.target='run_menu';
				document.click_run.target='_blank';
				document.click_run.target_.value='run_menu';
				document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php';
				document.click_run.submit();
			}
			//document.getElementById("mySidenav").style.width = "250px";
			document.getElementById("mySidenav").style.width = "0px";
		}
	}

	function arunG( r, sys_pg, tit ){
		//alert('tit:'+tit);
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

	function arunA( runtype ){ //menu_change
		document.click_run.make_type.value   ='booktreeupdateM2'; // newcratree
		document.click_run.m_type.value   ='booktreeupdateM2'; // newcratree
		if( runtype=='insert' ){
			document.click_run.mode.value    ='mroot'; ////////////// add 2021-09-19 - test OK
			document.click_run.runtype.value = 'insert';
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php'; // root 하단 목록.
			document.click_run.submit();
		} else if( runtype=='update' ){
			document.click_run.mode.value    ='mroot'; ////////////// add 2021-09-19 - test OK
			document.click_run.runtype.value = 'update';
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php'; // root 하단 목록.
			document.click_run.submit();
		} else if( runtype=='run' ){
			document.click_run.runtype.value = 'run';
		} else if( runtype=='list' ){
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/index.php'; //cratree_my_list_menu.php
			document.click_run.submit();
			click_run.menu_change[0].value   = 'list';
			click_run.menu_change[0].text    = 'Tree list';
			document.getElementById('click_run'+0).value = 'list';
			document.getElementById('click_run'+0).innerHTML = 'Tree list'; // 출력.
			document.getElementById("mySidenav").style.width = "0";
		} else if( runtype=='design' ){
			document.click_run.runtype.value = 'design';
			document.click_run.make_type.value = 'booktreeupdateM2'; //alert('sys_pg:'+document.click_run.sys_pg.value);
			document.click_run.target='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_remake_book_menu.php';
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
	function run_on(){
		document.getElementById("mySidenav").style.width = "0";
	}
	function init() {
	    document.getElementById("mySidenav").style.width = "0px";
	}
</script>

</head>

    <!-- <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
	<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/commonO.js"></script> -->


<!-- <body onLoad="init()" oncontextmenu='return false' ondragstart='return false' onselectstart='return false' topmargin='0' style='background-color:white; overflow:hidden; margin-bottom: 30px;'>  -->
<body onLoad="init()" oncontextmenu='return false' ondragstart='return false' onselectstart='return false' topmargin='0' style='background-color:white;'>

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

		<!-- ------------------------- -->
		<!-- <h1 style="background-color:black;">
			<a href="#" onclick="openNav()" style="font-size:24px;cursor:pointer;color:cyan;background-color:black;">
				&#9776; <?=$kapp?><img src="/t/logo/logo120-120.png" height='24' title='AppGenerator.net'>
			</a>
		</h1> -->
		<!-- ------------------------- -->
		<!-- </div> --> <!-- end : header -->

		<div class="visualSlide">
			<?php //echo $slide_msg; ?>
		</div>

		<!-- ------------------------------------ -->

		<div id="mySidenav" class="sidenav">
			  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><!-- X 버턴 -->
				<center>
				<a href='<?=$_url?>' target='_top'><img src="<?=KAPP_URL_T_?>/logo/logo.png" title='K-APP - home'></a>

			<?php
				$run_target='run_menu'; // $run_target='url_link_tree_solpa_user_r';

				//--  시작부분  <table border=0 > ------------------
				$img_v="<img src='".KAPP_URL_T_ . "/logo/pizza.png' width='15' height='15'>";
			?>
			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />
<?php if( $H_ID ) { ?>
			<li align="center" style="color:cyan; background-color:black; height:21px; border:none"><?=$H_ID?></li>
<?php } else { ?>
			<li align="center" style="color:cyan; background-color:black; height:21px; border:none">K-APP</li>
<?php } ?>

			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />

			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left' title='table design for high level' ><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table30m_A.php' target='run_menu' title='table design for High Level'>1.<img src='<?=KAPP_URL_T_?>/logo/pizza.png' width='15' height='15'>Table Design</a></li>
			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table10i.php' target='run_menu'>2.<img src='<?=KAPP_URL_T_?>/logo/Uleaf.png' width='15' height='15'>Table List</a></li>
			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table10u1_PC.php' target='run_menu'>3.<img src='<?=KAPP_URL_T_?>/logo/land25.png' width='15' height='15'>Table Permissions</a></li>
			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/app_pg50RC.php' target='run_menu'>4.<img src='<?=KAPP_URL_T_?>/logo/appmaker.jpg' width='15' height='15'>Program Create</a></li>
			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/app_pg50RU.php' target='run_menu'>5.<img src='<?=KAPP_URL_T_?>/logo/ship.png' width='15' height='15'>Program Upgrade</a></li>

			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/table_relationA.php' target='run_menu'>6.<img src='<?=KAPP_URL_T_?>/logo/seed.png' width='15' height='15'>Table Relationship</a></li>
			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/program_list3.php' target='run_menu'>7.<img src='<?=KAPP_URL_T_?>/logo/seedX.png' width='15' height='15'>Program List A</a></li>
			<li style='font-size:18;color:#666666;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/program_pglist.php' target='run_menu'>8.<img src='<?=KAPP_URL_T_?>/logo/berry.png' width='15' height='15'>Program List B</a></li>
			<li style='font-size:18;color:cyan;height:21px;line-height:1; text-align:left'><a onclick="run_on();" href='<?=KAPP_URL_T_?>/menu/index.php' target='run_menu'>p.<img src='<?=KAPP_URL_T_?>/logo/leaf.png' width='15' height='15'>K-Tree</a></li>

			<HR width="100%" align="center" style="color:yellow; background-color:yellow; height:2px; border:none" />

			<li style='font-size:9;color:#666666;height:9px;line-height:1'>
			K-App
			<!-- We call it mining to register in the tree menu.<br>
			Points will be paid in coins in the future.<br>
			If it does not work, <br>please unblock the pop-up window. -->
			</li>
			<!--
				우리는 트리 메뉴에 등록하는것을 채굴이라 한다
				포인트는 향후에 코인으로 지급될것이다.
				작동하지 않으면 팝업 창을 차단 해제하십시오.
			-->
		</div>
	</div><!-- head -->
</form>

<div style="background-color:black;">
	<span style="font-size:24px;cursor:pointer;color:cyan;background-color:black;" onclick="openNav()" title='tree menu list'>&#9776; K-APP<img src="<?=KAPP_URL_T_?>/logo/logo120-120.png" align='center' style="margin:0px auto;height:24px;" title='K-APP'></span><!-- 트리출력버턴 Url link system -->
</div>

<center>

<?php
	//$src = KAPP_URL_T_ . '/indexTT.php?go_url=' . $_url;
	$src = KAPP_URL_T_ . '/indexTT.php';
	//m_("src: " . $src);
	//src: https://biogplus.iwinv.net/kapp/indexTT.php?go_url=./index.php
?>

<iframe src='<?=$src?>' title='url data' name='run_menu' width='100%' height='100%'></iframe>


			<!-- <a href="javascript:common.openProj01()" class="btn_req">
				<span>PROJECT REQUEST</span>
				<img src="./include/img/ico/ico_arr01.png" />
			</a> -->

</body>
</html>


<?php
	if( $_REQUEST['open_mode'] == 'on' ) {
	  echo "<script>document.getElementById('mySidenav').style.width = '250px';</script>";
	}
/*
function funcrs($rsr_submenu, $run_target) {

	global $mid;
	global $i, $sys_pg, $intloop, $div_id;
	global $fsr;
	global $imgtype1,$imgtype2,$imgtype3, $fontcolor, $fontsize,$fontface, $bgcolor;
	$i = $i + 1;
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg = '$sys_pg' and sys_menu = '$rsr_submenu' order by sys_disno, sys_submenu ";
	$result = sql_query( $sql);
	$div_id = $sys_pg . $intloop;
	while( $rs2 = sql_fetch_array($result)) {
		$rssys_menu     = $rs2['sys_menu'];
		$rssys_menutit  = $rs2['sys_menutit'];
		$rssys_submenu	= $rs2['sys_submenu'];
		$rssys_cnt      = $rs2['sys_cnt'];
		$rssys_level    = $rs2['sys_level'];
		$rssys_subtit	= $rs2['sys_subtit'];
		$rssys_memo     = $rs2['sys_memo'];
		$tit_gubun		= $rs2['tit_gubun'];
		$rssys_link		= $rs2['sys_link'];
		if ( $rssys_link == "http://"  or  $rssys_link == "" ) {
			$rssys_link = "about:blank";
		}
		$mid	= $rs2['sys_userid'];
		$num	= $rs2['sys_pg'];
		$pg		= $rs2['sys_link'];
		$jong	= $rs2['tit_gubun'];
		$title_	= $rs2['sys_subtit'];
		$link_	= $rs2['sys_link'];

		$target_= $run_target; // background-color:$bgcolor; 추가: 2021-10-09
		if ( $rssys_cnt == 0 ) {
			$div_open = "";
			$img_type = "<img src='".$imgtype3."' align='absmiddle'>";
			$link_url_run = "<a onclick=\"javascript:submit_run( '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '$target_');\" target='$target_' style='background-color:$bgcolor;color:$fontcolor;font-size:$fontsize' title='mid:$mid, $link_, $sys_pg, $rssys_menu, $rssys_submenu'>".$rssys_subtit."</a><br>";

		} else {
			$div_id = $rssys_submenu;
			$div_open = "<div id='".$div_id."d' style='display:none'>";
			$img_type = "<img src=".$imgtype1." id='".$div_id."' class='solpa_tree_main' style='cursor: hand' align=absmiddle >";
			$link_url_run  = "<a onclick=\"javascript:submit_run( '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '$target_');\" id='".$div_id."' class='solpa_tree_main' target='$target_' style='background-color:$bgcolor;color:$fontcolor;font-size:$fontsize' title='mid:$mid, tree_menu_guest:$link_, $sys_pg, $rssys_menu, $rssys_submenu'>".$rssys_subtit."</a><br>";
		}
		//////////////////< write 되는 순서 중요 >//////////////////////////////////////////////
		if (( $i != 0 ) and ( $rssys_level == "client" )) {
			for ( $fornum = 1; $fornum <= $i; $fornum++ ){
				echo "&nbsp;";
			}
		} else if ( $rssys_level == "sroot" ) {
			$i = 1;
		}
		echo $img_type;
		echo $link_url_run;
		echo $div_open;
		/////////////////////////////////////////////////////////////////////////////////////////////

		if (( $rssys_menutit == "root" ) and ( $rssys_level != "mroot" )) {
			$rsr_submenu = $rssys_submenu;
			funcrs($rssys_submenu, $run_target);
		}
		$sys_menutit ="";
	}//loop	/////rs2객체loop
	//fwrite($fsr,"</div>" );
	echo "</div>";
	$i = $i - 1;
} //end function
*/
?>
