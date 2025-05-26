  <?php
	include_once('../tkher_start_necessary.php');
	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';

	connect_count($host_script, $H_ID, 0,$referer);	// log count
   /* ------------------------------------------ 최종 사용 프로그램 임다. 중요.
   /t/menu/tree_run.php <- /t/menu/index_menu.php <- /t/tree_menu_guest.php
                          : Guest View Mobile <- /t/menu/tree_menu_updateM2.php 을 copy
                          : /t/menu/tree_menu_updateM2.php 사용 하지 않음.
						  /t/my_list_menu.php에서도 call.중요.

   http://urllinkcoin.com/t/tree_run_menuM_guest.php?num=dao_1612581000&mid=dao 사용자 통합실행용. 중요.

		tree_run_menu.php -> runf_my_create.php -> tree_run_generator.php -> r1_my.php
		             최초 r1_my.php : my page에서 실행한다.

	http://urllinkcoin.com/cratree/tree_run_menu.php?mid=dao&num=dao1612683061&jong=B&target_=my_solpa_user_r
   -------------------------------------------------------- */
   //m_("mid:" . $_REQUEST['mid']);
   //link, link src: https://ailinkapp.com/t/https://ailinkapp.com/t/bbs/board_list3m.php
   if( isset($_REQUEST['mid']) ) $mid = $_REQUEST['mid'];
   else $mid ='';
   if( isset($_POST['mode']) ) $mode = $_POST['mode'];
   else $mode ='';
   if( $mode == 'SearchPG'){
		$_SESSION['sys_pg'] = $_POST['sys_pg'];
		$run_ = "tree_run.php?sys_pg=" . $_POST['sys_pg'] . "&open_mode=on". "&mid=".$mid;
		echo "<script>window.open( '".$run_."' , '_top', ''); </script>";
		exit;
   }
?>
<html> 
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/_tree_.png">

<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<script language="javascript"> 
<!-- 
function run_r1_func( run_program ){ // 사용하지 않음,
		document.click_run.target='_top';
		document.click_run.action='r1.php';
		document.click_run.submit();  
}
function clickHandler() {  
	var  targetId, srcElement,  targetElement;  
	srcElement = window.event.srcElement;  

	if (srcElement.className == "solpa_tree_main") {  // 아이콘 클릭시에만 하위 트리 펼침. class=solpa_tree_main
		targetId = srcElement.id + "d";  
		targetElement = document.all( targetId);  

		if ( targetElement.style.display == "none") {  
			targetElement.style.display = "";  
			srcElement.src = "<?=KAPP_URL_T_?>/include/img/img11_l.gif";  
		} else {  
			targetElement.style.display = "none";  
			srcElement.src = "<?=KAPP_URL_T_?>/include/img/img12_r.gif";  
		}
	} 
	else if (srcElement.className == "tree_main_title") {  // 아이콘 클릭시에만 하위 트리 펼침. class=solpa_tree_main - 하위가 없을 때
		targetId_old = document.click_run.targetId_old.value;
		if( targetId_old !== '' ) {		//alert("tree_main_title - targetId_old: " + targetId_old);
			targetElement_old = document.all( targetId_old );  
			targetElement_old.style.background="black"; 
		} //else alert("tree_main_title - NULL - targetId_old ");
		targetId = srcElement.id;  
		targetElement = document.all( targetId);  
		targetElement.style.background="blue";  
		document.click_run.targetId_old.value = targetId;
	} 
	else if (srcElement.className == "tree_title") {  // 아이콘 클릭시에만 하위 트리 펼침. class=solpa_tree_main - 하위가 있을때 여기를 탄다.
		targetId_old = document.click_run.targetId_old.value;
		if( targetId_old !== '' ) {		//alert("tree_title - targetId_old: " + targetId_old);
			targetElement_old = document.all( targetId_old );  
			targetElement_old.style.background="black"; 
		} //else alert("tree_title - NULL - targetId_old ");
		targetId = srcElement.id; //targetId: dao1700525884_r02AA
		targetElement = document.all( targetId );  
		targetElement.style.background="blue"; 
		document.click_run.targetId_old.value = targetId;
	} 
} 
document.onclick = clickHandler;  
//--> 
</script> 

<!-- tree list 에 사용 -->
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

<!-- 
<style>  
.HeadTitle01AX{display:inline-block;margin:0 1px;height:30px;line-height:0px;padding:0 20px;font-size:21px;background:#d01c27;color:#fff;border-radius:5px;}  
.HeadTitle01AX a.on{background:#d01c27;color:#000;}  
</style>  
 -->
<script>

	function open_List() {
		//document.getElementById("mySidenav").style.width = "0px";
		document.click_run.target='run_menu';  
		document.click_run.action= '<?=KAPP_URL_T_?>/menu/index.php'; 
		document.click_run.submit();  
	}
	function openNav() {
	  document.getElementById("mySidenav").style.width = "250px";
	}

	function closeNav() {
	  document.getElementById("mySidenav").style.width = "0";
	}
	function About(no) {
	  document.getElementById("mySidenav").style.width = "0";
	}
//--------- runtype - Insert, Update, RUN --------------------
//function submit_run( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_, sys_board_num){ 
function submit_run( seqno, mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_, sys_board_num){ 

	runtype = document.click_run.runtype.value; //alert( runtype + ", link_:" + link_ + ", pg:" + pg);
	if( runtype == ''){ // link_list_all.php 에서 call
		//link_ = pg;	//	
		//location.href=pg; 
	}
		document.click_run.seqno.value = seqno;
		document.click_run.sys_board_num.value = sys_board_num;
		document.click_run.sys_menu.value    =sys_menu;   
		document.click_run.sys_submenu.value =sys_submenu;   
		document.click_run.num.value         =num;   
		document.click_run.pg.value          =pg;   
		document.click_run.jong.value        =jong;  
		document.click_run.title_.value      =title_;   
		document.click_run.link_.value       =link_;

	document.click_run.mid.value         = mid; 
	document.click_run.sys_pg.value      = sys_pg; 
	document.click_run.sys_pg_root.value = sys_pg; 

	document.click_run.mode.value        = 'rowlevel'; ///////////////////////////////////////// 
	document.click_run.make_type.value   = 'booktreeupdateM2';
	document.click_run.m_type.value      = 'booktreeupdateM2'; // newcratree
	document.click_run.data.value   = sys_menu; 
	document.click_run.data1.value  = sys_submenu; 
	document.click_run.target       = 'run_menu'; 

	//alert("submit_run runtype:" + runtype + mid+ ", " +sys_pg+ ", " +sys_menu+ ", " +sys_submenu+ ", " +num+ ", " +pg+ ", " +jong+ ", " +title_+ ", " +link_+ ", " +target_+ ", " +sys_board_num);
	//submit_run runtype:dao, dao1703742132, dao1703742132_r, dao1703742132_r04, dao1703742132, index_bbs.php?infor=261, A, 메타버스 게시판, index_bbs.php?infor=261, https://ailinkapp.com, 261
	if( runtype =='update'){
		document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php'; // root 하단 목록.
		document.click_run.submit();     
	} else if( runtype =='insert'){
		document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php'; // root 하단 목록.
		document.click_run.submit();     
	} else if( runtype =='' || runtype=='run'){
		if( pg.indexOf( 'contents_view_menu')>=0 ) { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		} else if( pg.indexOf( target_ )>=0 )  { 
			//alert("tree run - target_: " + target_); //target_: https://ailinkapp.com
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= pg; 
			//document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if( pg.indexOf( 'tkher_program_data_list.php')>=0 )  { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if( pg.indexOf( 'contents_view_menuD.php')>=0 )  { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if( pg.indexOf( 'index_bbs.php?infor')>=0 )  {  // new add 2023-11-28
		    //alert("submit_run pg:" + pg); //submit_run pg:index_bbs.php?infor=261
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			//document.click_run.action= pg; 
			document.click_run.submit();  
		}else if( pg.indexOf( 'ailinkapp.com')>=0 )  { 
			document.click_run.target ='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if( pg.indexOf( 'https://')>=0 )  { 
			document.click_run.target ='_blank';  
			document.click_run.target_.value='_top'; //'_blank';  
			//document.click_run.action= pg; //'<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; ////////////
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; ////////////
			document.click_run.submit();     
		}else if( pg.indexOf( 'http://')>=0 )  { 
			document.click_run.target ='_blank'; 
			document.click_run.target_.value= '_top';//target_;//'_top'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		} else { 
			document.click_run.target ='run_menu'; 
			document.click_run.target_.value='_self'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		}
		document.getElementById("mySidenav").style.width = "0px"; // 0px:클릭시 tree 화면을 닫는다. - tree 닫는 것을 막았음! 
	} else {
		alert("--- ERROR");
		return false;
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

	function arunA( $id, $mid, $URL_T, runtype ){ //menu_change
		document.click_run.make_type.value   ='booktreeupdateM2'; // newcratree
		document.click_run.m_type.value   ='booktreeupdateM2'; // newcratree
		if( runtype=='insert' ){
			if( $id !== $mid) { alert("make not user"); return false;}
			document.click_run.mode.value    ='mroot'; ////////////// add 2021-09-19 - test OK
			document.click_run.runtype.value = 'insert';
			document.click_run.target ='run_menu';  
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php'; // root 하단 목록.
			document.click_run.submit();     
		} else if( runtype=='update' ){
			if( $id !== $mid) { alert("make not user"); return false;}
			document.click_run.mode.value    ='mroot'; ////////////// add 2021-09-19 - test OK
			document.click_run.runtype.value = 'update';
			document.click_run.target ='run_menu';  
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php'; // root 하단 목록.
			document.click_run.submit();     
		} else if( runtype=='run' ){
			document.click_run.runtype.value = 'run';
		} else if( runtype=='list' ){
			document.click_run.target ='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/index.php'; //cratree_my_list_menu.php
			document.click_run.submit();
			click_run.menu_change[0].value   = 'list';
			click_run.menu_change[0].text    = 'Tree list';
			document.getElementById('click_run'+0).value = 'list';
			document.getElementById('click_run'+0).innerHTML = 'Tree list'; // 출력.
			document.getElementById("mySidenav").style.width = "0";
		} else if( runtype=='design' ){
			if( $id !== $mid) { alert("make not user"); return false;}
			document.click_run.runtype.value = 'design'; 
			document.click_run.make_type.value = 'booktreeupdateM2'; 
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

	function sys_pg_change( sys_pg ) {  
		pg = sys_pg.split(":");
		document.click_run.sys_pgS.value = pg[0];
		document.click_run.sys_subtitS.value = pg[1];
		document.click_run.sys_pg.value = pg[0];
		document.click_run.treetype.value = 'B';
		document.click_run.mode.value='SearchPG';
		document.click_run.target='_self';
		document.click_run.action='<?=KAPP_URL_T_?>/menu/tree_run.php';
		document.click_run.submit();
	    document.getElementById("mySidenav").style.width = "250px";
	}
</script>

</head> 

<body oncontextmenu='return false' ondragstart='return false' onselectstart='return false' topmargin='0' style='background-color:white; overflow:hidden; margin-bottom: 30px;'> 

<?php
if( isset($_REQUEST['sys_subtitS']) ) $sys_subtitS = $_REQUEST['sys_subtitS'];
else $sys_subtitS = 'App Generator';

	if( isset( $_REQUEST['sys_pg'] ) ) { 
		$sys_pg	= $_REQUEST['sys_pg']; 
	} else if( isset($_POST['sys_pg']) ) {
		$sys_pg	= $_POST['sys_pg']; 
	} else if( isset($_SESSION['sys_pg']) ) {
		$sys_pg = $_SESSION['sys_pg'];
	} else if( isset($_POST['sys_pgS']) ) {
		$sys_pg = $_POST['sys_pgS']; 
	} else {
		$sys_pg	= get_session("sys_pg"); 
	}

	if( isset($sys_pg) && isset($mid) ) { // update view_cnt++		//m_("sys_pg: " . $sys_pg . ", mid: " .$mid); //sys_pg: dao1710204459, mid: dao

		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg' ";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		$sys_subtitS = $rs['sys_subtit'];		//m_("mid: ". $mid . ", sys_pg=".$sys_pg); //mid: dao, sys_pg=
	} else if( isset($sys_pg) ) {
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg' ";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		$sys_subtitS = $rs['sys_subtit'];
	} else if( !isset($sys_pg) ) {
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and tit_gubun !='' and sys_level = 'mroot' order by up_day desc";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		$gubun  = $rs['tit_gubun'];
		$sys_pg = $rs['sys_pg'];
		$sys_subtitS = $rs['sys_subtit'];
	} 
?>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a><!-- X 버턴 -->
	<center>
	<!-- <a href='/t/menu/cratree_my_list_menu.php?mid=<?=$mid?>'><img src="/logo/logo.png" title='AppGenerator.net - home'></a> -->
	<!-- <a href='<?=KAPP_URL_T_?>/menu/index.php?mid=<?=$mid?>' target="_blank"><img src="/logo/logo.png" title='<?=KAPP_URL_?> - home'></a> -->
	<a href='<?=KAPP_URL_T_?>' target="_blank"><img src="<?=KAPP_URL_T_?>/logo/logo.png" title='<?=KAPP_URL_?> - home'></a>
	<div id="t1" class="c1">
		<div class='container-fluid'>
		<div id='FirstDiv'></div>
		<div id='SecondDiv'>
	<form name='click_run' action='' method='post' enctype='multipart/form-data' target='run_menu'> 
		<input type='hidden' name='seqno' value=''> <!-- 2024-01-24 view_cnt 증가 처리 용! -->
		<input type='hidden' name='num' value='<?=$num?>'> 
		<input type='hidden' name='sys_menu' value='<?=$sys_pg?>'> 
		<input type='hidden' name='sys_submenu' value='<?=$sys_pg?>'> 
		<input type='hidden' name='pg' > 
		<input type='hidden' name='jong' > 
		<input type='hidden' name='title_' > 
		<input type='hidden' name='link_' > 
		<input type='hidden' name='target_' > 
		<input type='hidden' name='sys_pgS' > 
		<input type='hidden' name='sys_subtitS' > 
		<input type='hidden' name='mode' > 
		<input type='hidden' name='mid'    value='<?=$mid?>'> 
		<input type='hidden' name='sys_pg' value='<?=$sys_pg?>'> 
		<input type='hidden' name='data'   value='<?=$sys_pg?>'> 
		<input type='hidden' name='data1'  value='<?=$sys_pg?>'> 
		<input type='hidden' name='make_type' value='booktreeupdateM2'> <!-- make_type: tree_create_menu, treebom_insert2_book_menu, treebom_insw_book_menu : 사용중 -->
		<input type='hidden' name='m_type' > 
		<input type='hidden' name='sys_pg_root' value='<?=$sys_pg?>'> 
		<input type='hidden' name='treetype' > 
		<input type='hidden' name='runtype' > 
		<input type='hidden' name='targetId_old' > 
		<input type='hidden' name='sys_board_num' > <!-- 2023-11-28 add -->
<?php
	$run_target='run_menu'; // $run_target='url_link_tree_solpa_user_r';

//////////////////////////< 스킨 select >/////////////////////////////////////////////
$skin_sql 	= "SELECT * from {$tkher['menuskin_table']} where sys_pg = '$sys_pg' ";
$result 	= sql_query( $skin_sql);
$tot 		= sql_num_rows($result);
$skinrs 	= sql_fetch_array($result);
if ( $tot == 0 ) {
	$make_id	= $mid; 
	$bgcolor	= "#cccccc";		/////배경색
	$fontcolor	= "black";		/////글자색
	$fontface	= "Arial";			/////글꼴 : 돋움체
	$fontsize	= "15";			/////글자크기
	$imgtype1	= KAPP_URL_T_ . "/icon/folder.gif";	/////이미지1(닫힘)
	$imgtype2	= KAPP_URL_T_ . "/icon/folder1.gif";	/////이미지2(열림)
	$imgtype3	= KAPP_URL_T_ . "/icon/folder2.gif";	/////이미지3(하위)
} else {
	$make_id	= $skinrs['user_id']; 
	$bgcolor	= $skinrs['bgcolor'];		/////배경색
	$fontcolor	= $skinrs['fontcolor'];	/////글자색
	$fontface	= $skinrs['fontface'];	/////글꼴
	$fontsize	= $skinrs['fontsize'];	/////글자크기
	$imgtype1	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype1'];	/////이미지1(닫힘)
	$imgtype2	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype2'];	/////이미지2(열림)
	$imgtype3	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype3'];	/////이미지3(하위)
	//$imgtype3	= "/cratree/skins_treeicon/as00/".$skinrs['imgtype3'];	/////이미지3(하위)
}
/////////////< 스킨 select end >///////////////////

//--  start  <table border=0 > ------------------
	$img_v="<img src='". KAPP_URL_T_ ."/logo/pizza.png' width='15' height='15'>";
	echo " maker:" . $mid . "<br>";
	echo " <table border='0' >";
?>
	<tr> 
	<td> 
          <tr> 
            <td colspan='2' bgcolor='#33FF33' height='1'></td> 
          </tr> 
          <tr> <!-- cratree_my_list.php -->
             <td height='15' align='left' title='Ktree List'>
			 <!-- <a href='<?=KAPP_URL_T_?>/menu/cratree_my_list_menu.php?mid=<?=$mid?>' id='<?=$sys_pg?>' target='run_menu' style='color:#33FF33;font-size:15'><?php echo $img_v; ?><strong> Tree-List </strong></a> -->
			 <a href='<?=KAPP_URL_T_?>/menu/index.php?mid=<?=$mid?>' id='<?=$sys_pg?>' target='run_menu' style='color:#33FF33;font-size:15'><?php echo $img_v; ?><strong> Tree-List </strong></a>
			<!-- ------------------------------------------------------------ -->			 
			<SELECT name='sys_pg_sel' onchange="sys_pg_change(this.value);" style="border-style:;background-color:#666666;color:yellow;width:130px; height:25px;" <?php echo" title='Upgrade the program.' "; ?> >
<?php 
		if( $mode=='SearchPG') {
			$sys_subtitS = $_POST['sys_subtitS'];
			$sys_pg = $_POST['sys_pg'];
?>
			<option value="<?=$_POST['sys_pg']?>:<?=$_POST['sys_subtitS']?>" selected><?=$_POST['sys_subtitS']?></option>
<?php
		} else if( $sys_pg ) {
?>
			<option value="<?=$sys_pg?>:<?=$sys_subtitS?>" selected><?=$sys_subtitS?></option>
<?php
		} else {
?>
			<option value=''>Select Tree</option>
<?php
		}

	$w =" where sys_level='mroot' and sys_userid='" . $mid ."' " ;
	$sqlS = "SELECT * from {$tkher['sys_menu_bom_table']} " . $w . " order by tit_gubun, up_day desc, sys_subtit ";
	$resultS = sql_query( $sqlS );
	$rowS = sql_num_rows( $resultS );

	while( $rsS = sql_fetch_array($resultS)) {
		if( $rsS['sys_level'] == 'mroot' and $rsS['sys_subtit']=='main') {
			//m_("rowS:" . $rowS);
			continue;
		}
		$mid = $rsS['sys_userid'];
		$tree_color = "<font color='grace'>";
		$jong		= 'T'; //'U'; // Tree Link Url
		$bb		    = 'grace';
		$run_mode   = 'cratree_remake';  //$run = './' . $rsS['sys_userid'] . '/' . $rsS['sys_pg'] . '_r1.htm';
		$icon		= "<img src='".KAPP_URL_T_."/logo/berry.png' width=25 height=15>";
		$target2_= 'run_menu';
?>
		<option value='<?=$rsS['sys_pg']?>:<?=$rsS['sys_subtit']?>' <?php echo" title='Program code:".$rsS['sys_pg'] . ":". $rsS['sys_level'] .":". $rsS['sys_subtit'] ."' "; ?> <?php if($sys_pg == $rsS['sys_pg']) echo " selected "; ?> ><?=$rsS['sys_subtit']?></option>
<?php
	}
?>
		</SELECT></td></tr> 

          <tr> 
            <td colspan='2' bgcolor='#33FF33' height='1'></td> 
          </tr> 

<?php if( $H_ID && $H_LEV > 1 ) { ?>
		<tr>
          <td> 
		<select id='menu_change' name='menu_change' onchange="arunA('<?=$H_ID?>','<?=$mid?>','<?=KAPP_URL_T_?>', this.value);" style="border-style:;background-color:#666fff;color:yellow;width:130px; height:25px;" <?php echo" title='tree menu management' "; ?> >
			<option id='menu_change0' value='' >Select job</option>
			<option id='menu_change1' value='insert' title='add tree item'>Insert job</option>
			<option id='menu_change2' value='update' title='change tree item'>Update job</option>
			<option id='menu_change3' value='run'    title='Execute tree item'>Execute</option>
			<option id='menu_change4' value='list'   title='tree list'>Tree list</option>
			<option id='menu_change5' value='design' <?php echo" title='Tree design change:' "; ?> >Tree design</option>
		</select>
          </td> 
		</tr>
<?php } ?>
          <tr> 
            <td colspan='2' bgcolor='#33FF33' height='1'></td> 
          </tr> 
	</td> 
	<td style='background-color:<?=$bgcolor?>'> 
<?php
	$sql_root = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$make_id' and sys_pg = '$sys_pg' and sys_level <> 'client' order by sys_disno, sys_menu ";
	$result   = sql_query( $sql_root);
	$row      = sql_num_rows($result);
	$intloop  = 0;
	$i = 1;
	$last_link = ''; $first_link = '';
	$view_cnt = 0;
	while( ( $rsr = sql_fetch_array($result) ) and ( $intloop < 2 )) {
		if( $intloop== 0) {
			$sys_menu     = $rsr['sys_menu'];
			$sys_submenu  = $rsr['sys_submenu'];
			$sys_menuT    = $rsr['sys_menu'] . ":" . $rsr['sys_submenu'];
			$sys_submenuT = $rsr['sys_subtit'];
		}
		$rsrsys_menu    = $rsr['sys_menu'];
		$rsrsys_menutit	= $rsr['sys_menutit'];
		$rsrsys_subtit  = $rsr['sys_subtit'];
		$rsrsys_link    = $rsr['sys_link'];

		$rsrsys_submenu	= $rsr['sys_submenu'];
		$rsrsys_level   = $rsr['sys_level'];
		$rsrdiv_open    = "<div id=".$sys_pg.$intloop.">";
		if( $rsrsys_level == "mroot" ) {
			funcrs($rsrsys_submenu, $run_target);
			$first_link = $rsrsys_link;
		} else if ( $rsrsys_level == "sroot" ) {
			funcrs($rsrsys_menu, $run_target);
		} 
		$intloop = $intloop + 1;
		
		//rsrsys_link: contents_view_menuD.php?num=dao1698741855
		//
	} 
	//m_("first_link: " . $first_link . ", last_link: " . $last_link . ", rsrsys_link: " . $rsrsys_link );
	//first_link: contents_view_menuD.php?num=dao1698741855, last_link: ./tkher_program_data_list.php?pg_code=dao_1691048950, rsrsys_link: contents_view_menuD.php?num=dao1698805572
	//first_link: contents_view_menuD.php?num=dao1698741855, last_link: ./tkher_program_data_list.php?pg_code=dao_1691049349, rsrsys_link: contents_view_menuD.php?num=dao1698805572

?>
	</td> 
<?php
echo "<td>";
echo "          <tr>";
echo "            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td>";
echo "          </tr>";
echo "          <tr>";
echo "          </tr>";
echo "          <tr>";
echo "            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td>";
echo "          </tr>";
?>
</td>
</tr>

<tr>
<td colspan='2' bgcolor='' height='1' style='font-size:9;color:#666666'>
We call it mining to register in the tree menu.<br><!-- 우리는 트리 메뉴에 등록하는것을 채굴이라 한다 -->
Points will be paid in coins in the future.<br><!-- 포인트는 향후에 코인으로 지급될것이다. -->
If it does not work, <br>please unblock the pop-up window.
</td><!-- 작동하지 않으면 팝업 창을 차단 해제하십시오. -->
</tr>
</table>
		</div>
		</div>
	</div>
</div>

<?php
	//m_("KAPP_HOST_: " . KAPP_HOST_); // moado.net
	if( isset($_REQUEST['sys_jong'])) $sys_jong = $_REQUEST['sys_jong']; 
	else if( isset($_POST['sys_jong'])) $sys_jong = $_POST['sys_jong']; 
	else $sys_jong = '';
	//mid: dao, tree_menu_guest num: dao1699235009, sys_jong: link, sys_link: , board_num: , job_addr: 
	//m_( "mid: ".$mid.", tree_menu_guest num: ".$_REQUEST['num'].", sys_jong: ".$sys_jong.", sys_link: ".$_REQUEST['sys_link'].", board_num: ".$_REQUEST['board_num'].", job_addr: ".$_REQUEST['job_addr']);

	if( isset($_REQUEST['num']) && $sys_jong=="note" ){ // index_create - 생성시 여기를 탄다.
		$src = KAPP_URL_T_ . '/menu/contents_view_menuD.php?num=' . $_REQUEST['num']; 
		//m_( "sys_jong: " . $sys_jong . ", 1 src: " . $src );
		//sys_jong: note, 1 src: https://modumodu.net/kapp/menu/contents_view_menuD.php?num=solpakan@naver.com1712300515
		//sys_jong: note, 1 src: https://ailinkapp.com/t/menu/contents_view_menuD.php?num=dao1710205450

	} else if( $sys_jong == "noteB" ){
		$src = $_REQUEST['job_addr'];
	} else if( $sys_jong == "board" ){
		$src = KAPP_URL_T_ . '/menu/index_bbs.php?infor=' . $_REQUEST['board_num']; //m_( $sys_jong . ", 2 src: " . $src );

	} else if( $sys_jong == "link" ){
		$result  = strpos($rsrsys_link, "tkher_program_data_list");
		if( $result ) $src = KAPP_URL_T_ . '/' . $_REQUEST['sys_link'];
		else {
			$result  = strpos($rsrsys_link, KAPP_HOST_);
			if( $result){
				$src = $rsrsys_link; //$_REQUEST['sys_link'];
			} else {
				$src = $_REQUEST['job_addr']; // link_list_all 에서 call	m_("job_addr: " . $_REQUEST['job_addr']);
				echo "<script>submit_run('" . $_REQUEST['sys_pg'] . "', '_blank', '" . $sys_jong. "', '". $sys_pg. "', '". KAPP_URL_T_ . "', '" . KAPP_URL_ . "' , '".$_REQUEST['job_addr']."' );</script>";
			}
		}

	} else if( isset($_REQUEST['job_addr']) ){
		if( strpos($_REQUEST['job_addr'], "./menu") !== false) {  
			$src = $_REQUEST['job_addr'];    //m_("src:". $src);
		} else {  
			$src = KAPP_URL_T_ . "/menu/".$_REQUEST['job_addr']; // old data, m_("src:". $src);//src:contents_view_menuD.php?num=dao1653899733
		} 
	} else {
		//$src = KAPP_URL_T_ . '/menu/cratree_my_list_menu.php?mid=' . $mid; 
		//중요. /menu/cratree_my_list_menu.php 에서 Title을 클릭 하면 /t/tree_run.php 해당 트리 와 트리 sys_level이 mroot인 목록을 출력 한다.
		//$result  = strpos($rsrsys_link, "contents_view_menu");
		//$result2 = strpos($rsrsys_link, "index5.php");
		
		/*$result  = strpos($first_link, "contents_view_menuD"); //"contents_view_menu"
		$result2 = strpos($first_link, "/bbs/index5.php"); // old data
		if( $result2 !== false ) {
			$src = KAPP_URL_T_ . "/bbs/" . $first_link; // old data , $first_link, "index5.php"; - 2023-11-13
		} else if( strpos($first_link, "index_bbs.php") !== false ) {
			
			$src = $first_link; //$src = KAPP_URL_T_ . "/menu/" . $first_link;
			//m_("src: ".$src.", first_link: " . $first_link);
		} else if( $result !== false ) {
			$src = $first_link; // $src = KAPP_URL_T_ . "/menu/" . $first_link;
			//m_("5 src: " . $src . ", first_link: " . $first_link. ", result:" . $result . ", result2:" . $result2);
			//5 src: https://modumodu.net/kapp/menu/https://modumodu.net/kapp/menu/contents_view_menuD.php?num=solpakan1713419549, first_link: https://modumodu.net/kapp/menu/contents_view_menuD.php?num=solpakan1713419549, result:31, result2:
		} else {
			$src = $first_link;	//m_("5 src: " . $src . ", result:" . $result . ", result2:" . $result2); // src: contents_view_menuD.php?num=dao1698805572
		}*/
		$src = $first_link; // 2024-04-18
	}
	//m_("src: " . $src);//src: https://ailinkapp.com/t/menu/contents_view_menuD.php?num=dao1698805572, result:0, result2:
	//src: https://modumodu.net/kapp/menu/contents_view_menuD.php?num=solpakan1713419549
	
?>

<div style="background-color:black;">
<span style="font-size:24px;cursor:pointer;color:cyan;background-color:black;" onclick="openNav()" title='tree menu list'>&#9776; <?=$sys_subtitS?>[view:<?=$view_cnt?>, Maker:<?=$mid?>]</span>
<!-- 트리출력버턴 Url link system -->
&nbsp;&nbsp;&nbsp;<span style="font-size:24px;cursor:pointer;color:yellow;" onclick="open_List()" title='tree list'>Tree-List</span>
</div>
</form>

<center>
<iframe src='<?=$src?>' title='url data' name='run_menu' width='100%' height='100%'></iframe>  
</body>
</html>
<?php
if( $_REQUEST['open_mode'] == 'on' ) {
	echo "<script>document.getElementById('mySidenav').style.width = '250px';</script>";
}

function funcrs($rsr_submenu, $run_target) {
	
	global $mid, $last_link, $view_cnt, $tkher;
	global $i, $sys_pg, $intloop, $div_id; 
	global $fsr;
	global $imgtype1,$imgtype2,$imgtype3, $fontcolor, $fontsize,$fontface, $bgcolor;

	$i = $i + 1;
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg = '$sys_pg' and sys_menu = '$rsr_submenu' order by sys_disno, sys_submenu ";
	$result = sql_query( $sql);
	$cnt = 0;
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
		$jong	= $rs2['tit_gubun'];
		$title_	= $rs2['sys_subtit'];
		/*if( $tit_gubun =='A'){
			$link_	= $rs2['sys_link'] . $rs2['sys_board_num']; // 2024-04-26
			$pg		= $rs2['sys_link'] . $rs2['sys_board_num'];
		} else {
			$link_	= $rs2['sys_link']; // 2024-04-26
			$pg		= $rs2['sys_link'];
		}*/
			$link_	= $rs2['sys_link']; // 2024-04-26
			$pg		= $rs2['sys_link'];
		
		$seqno_	= $rs2['seqno'];   // 2024-01-24 view_cnt +에 필요함.
		$sys_board_num	= $rs2['sys_board_num'];
		$view_cnt = $view_cnt + $rs2['view_cnt']; // 2024-01-24 - view count total
		$target_= "run_menu"; // target은 submit_run() 에서 결정된다.
		if( $rssys_cnt == 0 ) { // 하위가 없다.
			$div_id = $rssys_submenu . $cnt++; //<div id='".$div_id."A'>
			$div_open = "";
			$img_type = "<img src='".$imgtype3."' align='absmiddle'>";
			$link_url_run = "<a onclick=\"javascript:submit_run( $seqno_, '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '". KAPP_URL_ ."', ".$sys_board_num.");\" id='".$div_id."' class='tree_main_title' target='$target_' style='background-color:$bgcolor;color:$fontcolor;font-size:$fontsize' title='$seqno_, mid:$mid, $sys_board_num, $link_, $sys_pg, $rssys_menu, $rssys_submenu'>".$rssys_subtit."</a><br>";
		} else { // 하위가 있다.
			$div_id = $rssys_submenu; //<div id='".$div_id."A'>	//$div_idA = $rssys_submenu . $cnt++; //<div id='".$div_id."A'>
			$div_open = "<div id='".$div_id."d' style='display:none'>"; // class='solpa_tree_main' 는 타이틀 클릭시에는 하위 트리를 펼치치 않토록 a에서 제거함. img에서만 펼침.
			$img_type = "<img src=".$imgtype1." id='".$div_id."' class='solpa_tree_main' style='cursor: hand' align=absmiddle >";
			$link_url_run  = "<a onclick=\"javascript:submit_run( $seqno_, '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '". KAPP_URL_ ."', ".$sys_board_num.");\" id='".$div_id."A' class='tree_title' target='$target_' style='background-color:$bgcolor;color:$fontcolor;font-size:$fontsize' title='$seqno_, mid:$mid, $sys_board_num, tree_run:$link_, $sys_pg, $rssys_menu, $rssys_submenu'>".$rssys_subtit."</a><br>";
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
		if (( $rssys_menutit == "root" ) and ( $rssys_level != "mroot" )) {
			$rsr_submenu = $rssys_submenu;
			funcrs($rssys_submenu, $run_target);
		}
		$sys_menutit ="";
	}//loop	/////rs2객체loop
	$last_link = $link_;
	echo "</div>";
	$i = $i - 1;
} //end function
?>