  <?php
	include_once('../tkher_start_necessary.php');
   /*
   tree_run.php <- /t/menu/index_menu.php <- /t/tree_menu_guest.php
		: my_list_menu.php: call
		tree_run_menu.php -> runf_my_create.php -> tree_run_generator.php -> r1_my.php
		tree_run_menu.php?mid=dao&num=dao1612683061&jong=B&target_=my_solpa_user_r
   */
	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';
	connect_count($host_script, $H_ID, 0,$referer);	// log count
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
function clickHandler() {  
	var  targetId, srcElement,  targetElement;  
	srcElement = window.event.srcElement;  
	if (srcElement.className == "solpa_tree_main") {
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
	else if (srcElement.className == "tree_main_title") { 
		targetId_old = document.click_run.targetId_old.value;
		if( targetId_old !== '' ) {
			targetElement_old = document.all( targetId_old );  
			targetElement_old.style.background="black"; 
		}
		targetId = srcElement.id;  
		targetElement = document.all( targetId);  
		targetElement.style.background="blue";  
		document.click_run.targetId_old.value = targetId;
	} 
	else if (srcElement.className == "tree_title") { 
		targetId_old = document.click_run.targetId_old.value;
		if( targetId_old !== '' ) {
			targetElement_old = document.all( targetId_old );  
			targetElement_old.style.background="black"; 
		}
		targetId = srcElement.id;
		targetElement = document.all( targetId );  
		targetElement.style.background="blue"; 
		document.click_run.targetId_old.value = targetId;
	} 
} 
document.onclick = clickHandler;  
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

<script>
	function open_List() {
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
function submit_run( seqno, mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_, sys_board_num){ 

	runtype = document.click_run.runtype.value;
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
	document.click_run.mode.value        = 'rowlevel';
	document.click_run.make_type.value   = 'booktreeupdateM2';
	document.click_run.m_type.value      = 'booktreeupdateM2';
	document.click_run.data.value   = sys_menu; 
	document.click_run.data1.value  = sys_submenu; 
	document.click_run.target       = 'run_menu'; 

	if( runtype =='update'){
		document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php'; 
		document.click_run.submit();     
	} else if( runtype =='insert'){
		document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php';
		document.click_run.submit();     
	} else if( runtype =='' || runtype=='run'){
		if( pg == 'http://' || pg == 'https://' )  { 
			alert("pg: "+pg + ", title_: " + title_);
			return;
		} else if( pg.indexOf( target_ )>=0 )  { 
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= pg; 
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
		}else if( pg.indexOf( 'index_bbs.php?infor')>=0 )  {
			document.click_run.target='run_menu';  
			document.click_run.target_.value='run_menu'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();  
		}else if( pg.indexOf( 'https://')>=0 )  { 
			document.click_run.target ='_blank';  
			document.click_run.target_.value='_top'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		}else if( pg.indexOf( 'http://')>=0 )  { 
			document.click_run.target ='_blank'; 
			document.click_run.target_.value= '_top';
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		} else { 
			document.click_run.target ='run_menu'; 
			document.click_run.target_.value='_self'; 
			document.click_run.action= '<?=KAPP_URL_T_?>/menu/cratree_coinadd_menu.php'; 
			document.click_run.submit();     
		}
		document.getElementById("mySidenav").style.width = "0px";
	} else {
		alert("--- ERROR");
		return false;
	}
}   

	function arunA( $id, $mid, $URL_T, runtype ){
		document.click_run.make_type.value   ='booktreeupdateM2'; 
		document.click_run.m_type.value   ='booktreeupdateM2'; 
		if( runtype=='insert' ){
			if( $id !== $mid) { alert("make not user"); return false;}
			document.click_run.mode.value    ='mroot'; 
			document.click_run.runtype.value = 'insert';
			document.click_run.target ='run_menu';  
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/treebom_insert2_book_menu.php';
			document.click_run.submit();     
		} else if( runtype=='update' ){
			if( $id !== $mid) { alert("make not user"); return false;}
			document.click_run.mode.value    ='mroot'; 
			document.click_run.runtype.value = 'update';
			document.click_run.target ='run_menu';  
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/tree_menu_update.php'; 
			document.click_run.submit();     
		} else if( runtype=='run' ){
			document.click_run.runtype.value = 'run';
		} else if( runtype=='list' ){
			document.click_run.target ='run_menu';
			document.click_run.action = '<?=KAPP_URL_T_?>/menu/index.php';
			document.click_run.submit();
			click_run.menu_change[0].value   = 'list';
			click_run.menu_change[0].text    = 'Tree list';
			document.getElementById('click_run'+0).value = 'list';
			document.getElementById('click_run'+0).innerHTML = 'Tree list'; 
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
			document.getElementById('click_run'+0).innerHTML = 'Tree design';
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
	if( isset($sys_pg) && isset($mid) ) { 
		$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$sys_pg' and sys_submenu='$sys_pg' ";
		$rt = sql_query( $sql);
		$rs	= sql_fetch_array($rt);
		$sys_subtitS = $rs['sys_subtit'];
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
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<center>
	<a href='<?=KAPP_URL_T_?>' target="_blank"><img src="<?=KAPP_URL_T_?>/logo/logo.png" title='<?=KAPP_URL_?> - home'></a>
	<div id="t1" class="c1">
		<div class='container-fluid'>
		<div id='FirstDiv'></div>
		<div id='SecondDiv'>
	<form name='click_run' action='' method='post' enctype='multipart/form-data' target='run_menu'> 
		<input type='hidden' name='seqno' value=''>
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
		<input type='hidden' name='make_type' value='booktreeupdateM2'>
		<input type='hidden' name='m_type' > 
		<input type='hidden' name='sys_pg_root' value='<?=$sys_pg?>'> 
		<input type='hidden' name='treetype' > 
		<input type='hidden' name='runtype' > 
		<input type='hidden' name='targetId_old' > 
		<input type='hidden' name='sys_board_num' >
<?php
	$run_target='run_menu'; 
	$skin_sql 	= "SELECT * from {$tkher['menuskin_table']} where sys_pg = '$sys_pg' ";
	$result 	= sql_query( $skin_sql);
	$tot 		= sql_num_rows($result);
	$skinrs 	= sql_fetch_array($result);
	if ( $tot == 0 ) {
		$make_id	= $mid; 
		$bgcolor	= "#cccccc";
		$fontcolor	= "black";
		$fontface	= "Arial";	
		$fontsize	= "15";
		$imgtype1	= KAPP_URL_T_ . "/icon/folder.gif";
		$imgtype2	= KAPP_URL_T_ . "/icon/folder1.gif";
		$imgtype3	= KAPP_URL_T_ . "/icon/folder2.gif";
	} else {
		$make_id	= $skinrs['user_id']; 
		$bgcolor	= $skinrs['bgcolor'];
		$fontcolor	= $skinrs['fontcolor'];
		$fontface	= $skinrs['fontface'];	
		$fontsize	= $skinrs['fontsize'];
		$imgtype1	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype1'];
		$imgtype2	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype2'];
		$imgtype3	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype3'];
	}
	$img_v="<img src='". KAPP_URL_T_ ."/logo/pizza.png' width='15' height='15'>";
	echo " maker:" . $mid . "<br>";
	echo " <table border='0' >";
?>
	<tr> 
	<td> 
          <tr> 
            <td colspan='2' bgcolor='#33FF33' height='1'></td> 
          </tr> 
          <tr>
             <td height='15' align='left' title='Ktree List'>
			 <a href='<?=KAPP_URL_T_?>/menu/index.php?mid=<?=$mid?>' id='<?=$sys_pg?>' target='run_menu' style='color:#33FF33;font-size:15'><?php echo $img_v; ?><strong> Tree-List </strong></a>
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
			continue;
		}
		$mid = $rsS['sys_userid'];
		$tree_color = "<font color='grace'>";
		$jong		= 'T'; 
		$bb		    = 'grace';
		$run_mode   = 'cratree_remake';
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
	} 
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
</td>
</tr>
</table>
		</div>
		</div>
	</div>
</div>

<?php
	if( isset($_REQUEST['sys_jong'])) $sys_jong = $_REQUEST['sys_jong']; 
	else if( isset($_POST['sys_jong'])) $sys_jong = $_POST['sys_jong']; 
	else $sys_jong = '';
	if( isset($_REQUEST['num']) && $sys_jong=="note" ){ 
		$src = KAPP_URL_T_ . '/menu/contents_view_menuD.php?num=' . $_REQUEST['num']; 
	} else if( $sys_jong == "noteB" ){
		$src = $_REQUEST['job_addr'];
	} else if( $sys_jong == "board" ){
		$src = KAPP_URL_T_ . '/menu/index_bbs.php?infor=' . $_REQUEST['board_num'];
	} else if( $sys_jong == "link" ){
		$result  = strpos($rsrsys_link, "tkher_program_data_list");
		if( $result ) $src = KAPP_URL_T_ . '/' . $_REQUEST['sys_link'];
		else {
			$result  = strpos($rsrsys_link, KAPP_HOST_);
			if( $result){
				$src = $rsrsys_link;
			} else {
				$src = $_REQUEST['job_addr'];
				echo "<script>submit_run('" . $_REQUEST['sys_pg'] . "', '_blank', '" . $sys_jong. "', '". $sys_pg. "', '". KAPP_URL_T_ . "', '" . KAPP_URL_ . "' , '".$_REQUEST['job_addr']."' );</script>";
			}
		}

	} else if( isset($_REQUEST['job_addr']) ){
		if( strpos($_REQUEST['job_addr'], "./menu") !== false) {  
			$src = $_REQUEST['job_addr']; 
		} else {  
			$src = KAPP_URL_T_ . "/menu/".$_REQUEST['job_addr']; 
		} 
	} else {
		$src = $first_link; 
	}
?>
<div style="background-color:black;">
<span style="font-size:24px;cursor:pointer;color:cyan;background-color:black;" onclick="openNav()" title='tree menu list'>&#9776; <?=$sys_subtitS?>[view:<?=$view_cnt?>, Maker:<?=$mid?>]</span>
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
			$link_	= $rs2['sys_link']; 
			$pg		= $rs2['sys_link'];
			$seqno_	= $rs2['seqno']; 
			$sys_board_num	= $rs2['sys_board_num'];
			$view_cnt = $view_cnt + $rs2['view_cnt'];
			$target_= "run_menu";
			if( $rssys_cnt == 0 ) {
				$div_id = $rssys_submenu . $cnt++;
				$div_open = "";
				$img_type = "<img src='".$imgtype3."' align='absmiddle'>";
				$link_url_run = "<a onclick=\"javascript:submit_run( $seqno_, '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '". KAPP_URL_ ."', ".$sys_board_num.");\" id='".$div_id."' class='tree_main_title' target='$target_' style='background-color:$bgcolor;color:$fontcolor;font-size:$fontsize' title='$seqno_, mid:$mid, $sys_board_num, $link_, $sys_pg, $rssys_menu, $rssys_submenu'>".$rssys_subtit."</a><br>";
			} else {
				$div_id = $rssys_submenu;
				$div_open = "<div id='".$div_id."d' style='display:none'>"; 
				$img_type = "<img src=".$imgtype1." id='".$div_id."' class='solpa_tree_main' style='cursor: hand' align=absmiddle >";
				$link_url_run  = "<a onclick=\"javascript:submit_run( $seqno_, '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '". KAPP_URL_ ."', ".$sys_board_num.");\" id='".$div_id."A' class='tree_title' target='$target_' style='background-color:$bgcolor;color:$fontcolor;font-size:$fontsize' title='$seqno_, mid:$mid, $sys_board_num, tree_run:$link_, $sys_pg, $rssys_menu, $rssys_submenu'>".$rssys_subtit."</a><br>";
			}
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