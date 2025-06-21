<?php
	include_once('../tkher_start_necessary.php');

	/* ---------------------------------------------------------------------- 
	    Tree Menu 소스코드 다운로드.
		treebom_tree_menu_createDN.php : 
		- call : /menu/cratree_my_list_menu.php : Tree menu List
	---------------------------------------------------------------------- */
	$H_ID    = get_session("ss_mb_id"); 
	$H_POINT = $member['mb_point']; $H_LEV=$member['mb_level']; 
	if( !$H_ID or $H_LEV < 2 ) {
		m_("You need to login. ");exit;
	}
	$dn_minus_point = $config['kapp_download_point'];
	$dn_add_point = -$config['kapp_download_point'];
	if( $H_POINT < abs($dn_minus_point) ) { //$dn_minus_point = 1000:my_func
		m_("There are not enough points. point:$H_POINT");exit;
	}
	if( isset($_POST['mid']) ) $mid = $_POST['mid'];
	else  $mid = '';
	if( isset($_POST['run_mode']) ) $run_mode = $_POST['run_mode'];
	else $run_mode = '';
	if( isset($_POST['sys_pg']) ) $sys_pg = $_POST['sys_pg'];
	else $sys_pg = '';
	if( $run_mode == 'tree_menu_createDN') {
		if( $H_ID != 'dao' ) coin_minus_func($H_ID, $dn_minus_point);
		if( $H_ID != $mid ) coin_add_func($mid, $dn_add_point);
	} else exit();
?>
<html> 
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<?php
	$linkurl = KAPP_URL_T_ . "/menu";
	$linkwww = KAPP_URL_T_;
	$first_linkurl = KAPP_URL_T_ . "/menu/cratree_my_list_menu.php?mid=".$mid; 
	$first_linkurl_all = $first_linkurl; 
	$rssys_treetit='';
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_level = 'mroot' and sys_pg = '$sys_pg' ";
	$result = sql_query( $sql);
	$rs22 = sql_fetch_array($result);
	$rssys_treetit   = $rs22['sys_subtit'];
	$from_session_id = $rs22['sys_userid'];

	if( isset($mid) && $mid !=='' ){
		$jtree_dir = KAPP_PATH_T_ . "/file/".$mid;
		if ( !is_dir($jtree_dir) ) {
			if ( !@mkdir( $jtree_dir, 0777 ) ) {
				echo " Error: $jtree_dir : " . $mid . " Failed to create directory.";
				m_("ERROR mid:" . $mid . ", dir create OK : " . $jtree_dir);	//exit;
			} else {
				m_("mid:" . $mid . ", dir create OK : " . $jtree_dir);
			}
		}
	} else {
		echo "Error mid none";
		exit;
	}
	$path = KAPP_PATH_T_ . "/file/" . $mid . "/";
	$runfile = $path . $sys_pg . "_run.html";
	$fsr = fopen("$runfile","w+");

function funcrs($rsr_submenu) {
	global $from_session_id, $rssys_treetit, $mid;
	global $i, $sys_pg, $intloop, $div_id; 
	global $fsr;
	global $imgtype1,$imgtype2,$imgtype3, $fontcolor, $fontsize, $bgcolor, $fontface;
	global $make_type, $run_mode, $book_num;
	global $linkurl, $linkwww, $tkher;
	$i = $i + 1;
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$rsr_submenu' order by sys_disno, sys_submenu ";
	$result = sql_query( $sql);
	$div_id = $sys_pg . $intloop;
	while( $rs2 = sql_fetch_array($result)) {
		$rssys_menu     = $rs2['sys_menu'];
		$rssys_menutit  = $rs2['sys_menutit'];
		$rssys_submenu	= $rs2['sys_submenu'];
		$rssys_cnt      = $rs2['sys_cnt'];
		$rssys_level    = $rs2['sys_level'];
		$rssys_link		= $rs2['sys_link'];
		$rssys_subtit	= $rs2['sys_subtit'];
		$xtit_gubun		= $rs2['tit_gubun'];
		$xbook_num		= $rs2['book_num'];
		$rssys_memo     = $rs2['sys_memo'];

		if ( $xtit_gubun == 'X') {	
			$link_url_run = "<font color=".$fontcolor.">____________________
			<br><font color=".$fontcolor.">ㅁ <b>".$rssys_subtit."</b>
			<br><font color=".$fontcolor.">--------------------<br>";
			fwrite( $fsr, $link_url_run." \r\n");

		} else {
			$mid		= $rs2['sys_userid'];
			$num		= $rs2['sys_pg'];
			$pg		= $rs2['sys_link'];
			$jong		= $rs2['tit_gubun'];
			$title_	= $rs2['sys_subtit'];
			$link_		= $rs2['sys_link'];
			$target_= 'solpa_user_r';

			if( strpos( $link_, 'contents_view_menu') !== false) {  
				$url = $linkurl . '/contents_view_menuD.php?num=' . $num;  
				$tg = "solpa_user_r";  
			} else if( strpos($link_, 'contents_view_menu') !== false) {  
				$url = $linkurl . '/' . $link_;  
				$tg = "solpa_user_r";  
			} else if( strpos($link_, '_r1.htm') !== false) {  
				$url = $linkwww . $link_;  
				$tg = "solpa_user_r";  
			} else if( strpos( $link_, 'index5.php') !== false) {  
				$url = $linkwww . $link_;  
				$tg = "solpa_user_r";  
			} else if( strpos($link_, 'tkher_program_data_list.php') !== false) {  
				$url = $linkwww . $link_;  
				$tg = "solpa_user_r";  
			} else if( strpos($link_, 'youtube.com/watch') !== false) {  
				$url = $link_;  
				$tg = "_blank";  
			} else if( strpos($link_, 'https://naver.com') !== false) {  
				$url = $link_;  
				$tg = "_blank";  
			} else if( strpos($link_, 'https://google.com') !== false) {  
				$url = $link_;  
				$tg = "_blank";  
			} else if( strpos($link_, 'https://youtube.com') !== false) {  
				$url = $link_;  
				$tg = "_blank";  
			} else if( strpos($link_, 'https://') !== false) {  
				$url = $link_;  
				$tg = "_blank";  
			} else if( strpos($link_, 'http://') !== false) {  
				$url = $link_;  
				$tg = "solpa_user_r";  
			} else {  
				$url = $linkwww . $link_;  
				$tg = "solpa_user_r";  
			}  
			if ( $rssys_cnt == 0 ) {
				$div_open = "";
				$img_type = "<img src='".$imgtype3."' align='absmiddle'>";
				$lk = $rssys_link; 
				$link_url_run  = "<a href='".$url."' target='".$tg."' style='color:$fontcolor;font-size:$fontsize;' title='$url, $rssys_memo'>".$rssys_subtit."</a><br>";
			} else {
				$div_id = $rssys_submenu;
				$div_open = "<div id='".$div_id."d' style='display:none'>";
				$img_type = "<img src='".$imgtype1."' id='".$div_id."' class='solpa_tree' style='cursor: hand' align='absmiddle' >";
				$link_url_run  = "<a href='".$url."' target='".$tg."' style='color:$fontcolor;font-size:$fontsize;' title='$url, $rssys_memo'>".$rssys_subtit."</a><br>";
			}
			if (( $i != 0 ) and ( $rssys_level == "client" )) { 
				for ( $fornum = 1; $fornum <= $i; $fornum++ ){
					fwrite($fsr,"&nbsp;");
 		     	}
				
			} else if ( $rssys_level == "sroot" ) {
				$i = 1;
			}
			fwrite( $fsr, $img_type." \r\n");
			fwrite( $fsr, $link_url_run." \r\n");
			fwrite( $fsr, $div_open." \r\n");
 		}
		if (( $rssys_menutit == "root" ) and ( $rssys_level != "mroot" )) {
			$rsr_submenu = $rssys_submenu;
			funcrs($rssys_submenu);
		}
		$sys_menutit ="";
	} 
	fwrite($fsr,"</div>" ); 
 	$i = $i - 1;
}//end function

$skin_sql = "SELECT * from {$tkher['menuskin_table']} where sys_pg = '$sys_pg' ";
$result = sql_query( $skin_sql );
$skinrs = sql_fetch_array($result);

if ( $skinrs == "" ) {
	$bgcolor	= "#cccccc";
	$fontcolor	= "black";
	$fontface	= "Arial";
	$fontsize	= "12";
	$imgtype1	= $linkwww . "/logo/folder.gif";
	$imgtype2	= $linkwww . "/logo/folder1.gif";
	$imgtype3	= $linkwww . "/logo/folder2.gif";
} else {
	$bgcolor	= $skinrs['bgcolor'];
	$fontcolor	= $skinrs['fontcolor'];
	$fontface	= $skinrs['fontface'];
	$fontsize	= $skinrs['fontsize'];
	$imgtype1	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype1'];	/////(close)
	$imgtype2	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype2'];	/////(open)
	$imgtype3	= KAPP_URL_T_ . "/icon/".$skinrs['imgtype3'];	/////(low)
}
fwrite($fsr,"<html> \r\n");
fwrite($fsr,"<head> \r\n");
fwrite($fsr,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
fwrite($fsr,"<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> \r\n");
fwrite($fsr,"<link rel='shortcut icon' href='".$linkwww."/logo/logo25a.jpg'> \r\n");
fwrite($fsr,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
fwrite($fsr,"<meta name='keywords' content='appgenerator, appmaker, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
fwrite($fsr,"<meta name='description' content='appgenerator, appmaker, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
fwrite($fsr,"<meta name='robots' content='ALL'> \r\n");
fwrite($fsr,"<script language=\"javascript\"> \r\n");
fwrite($fsr,"<!-- \r\n");
fwrite($fsr,"function clickHandler() {  \r\n");
fwrite($fsr,"	var  targetId, srcElement,  targetElement;  \r\n");
fwrite($fsr,"	srcElement = window.event.srcElement;  \r\n");
fwrite($fsr,"	if (srcElement.className == \"solpa_tree\") {  \r\n");
fwrite($fsr,"		targetId = srcElement.id + \"d\";  \r\n");
fwrite($fsr,"		targetElement = document.all( targetId);  \r\n");
fwrite($fsr,"		if ( targetElement.style.display == \"none\") {  \r\n");
fwrite($fsr,"			targetElement.style.display = \"\";  \r\n");
fwrite($fsr,"			srcElement.src = \"".$imgtype2."\";  \r\n");
fwrite($fsr,"		} else {  \r\n");
fwrite($fsr,"			targetElement.style.display = \"none\";  \r\n");
fwrite($fsr,"			srcElement.src = \"".$imgtype1."\";  \r\n");
fwrite($fsr,"		}  \r\n");
fwrite($fsr,"	}  \r\n");
fwrite($fsr,"} \r\n");
fwrite($fsr,"document.onclick = clickHandler;  \r\n");
fwrite($fsr,"	function submit_run( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_) {  \r\n");
fwrite($fsr,"			document.click_run.mid.value=mid; \r\n");
fwrite($fsr,"	   		document.click_run.sys_pg.value=sys_pg; \r\n");
fwrite($fsr,"			document.click_run.sys_menu.value=sys_menu;   \r\n");
fwrite($fsr,"			document.click_run.sys_submenu.value=sys_submenu;   \r\n");
fwrite($fsr,"			document.click_run.num.value=num;   \r\n");
fwrite($fsr,"			document.click_run.pg.value=pg;   \r\n");
fwrite($fsr,"	 		document.click_run.jong.value=jong;  \r\n");
fwrite($fsr,"			document.click_run.title_.value=title_;   \r\n");
fwrite($fsr,"			document.click_run.link_.value=link_;   \r\n");
fwrite($fsr,"			if (pg.indexOf( 'contents_view_menu.php')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"				document.click_run.target=target_;   // add  \r\n");
fwrite($fsr,"				document.click_run.target_.value=target_;     \r\n");
fwrite($fsr,"				document.click_run.action= './cratree_run_member.php'; \r\n");    
fwrite($fsr,"				document.click_run.submit();     \r\n");
fwrite($fsr,"			} else if (pg.indexOf( 'https://naver')>=0 || pg.indexOf('https://google')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"				document.click_run.target='_blank';  \r\n");
fwrite($fsr,"				document.click_run.target_.value='_blank'; \r\n");
fwrite($fsr,"				document.click_run.action= './cratree_run_member.php'; \r\n");    
fwrite($fsr,"				document.click_run.submit();     \r\n");
fwrite($fsr,"			} else if (pg.indexOf( 'https://')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"				document.click_run.target='_blank';  \r\n");
fwrite($fsr,"				document.click_run.target_.value='_top'; \r\n");
fwrite($fsr,"				document.click_run.action= './cratree_run_member.php'; \r\n");    
fwrite($fsr,"				document.click_run.submit();     \r\n");
fwrite($fsr,"			} else { \r\n");
fwrite($fsr,"				document.click_run.target=target_;   // add  \r\n");
fwrite($fsr,"				document.click_run.target_.value=target_;     \r\n");
fwrite($fsr,"				document.click_run.action= './cratree_run_member.php'; \r\n");    
fwrite($fsr,"				document.click_run.submit();     \r\n");
fwrite($fsr,"			} \r\n");
fwrite($fsr,"	}   \r\n");
fwrite($fsr,"//--> \r\n");
fwrite($fsr,"</script> \r\n");
fwrite($fsr,"<style type=\"text/css\"> \r\n");
fwrite($fsr,"	body, td, div, a {font-size:".$fontsize."pt;font-family:".$fontface.";} \r\n");
fwrite($fsr,"	a:link {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsr,"	a:visited {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsr,"	a:active {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsr,"	a:hover {color:#01ff01; text-decoration:none} \r\n");
fwrite($fsr,"	body, td { \r\n");
fwrite($fsr,"		scrollbar-face-color: #3399ff;  \r\n");
fwrite($fsr,"		scrollbar-shadow-color: #99ccff;  \r\n");
fwrite($fsr,"		scrollbar-highlight-color: #99ccff;  \r\n");
fwrite($fsr,"		scrollbar-3dlight-color: #99ccff;  \r\n");
fwrite($fsr,"		scrollbar-darkshadow-color: #99ccff;  \r\n");
fwrite($fsr,		"scrollbar-track-color: #99ccff;  \r\n");
fwrite($fsr,"		scrollbar-arrow-color: #99ccff; \r\n");
fwrite($fsr,"	} \r\n");
fwrite($fsr,"</style> \r\n");
fwrite($fsr,"</head> \r\n");
fwrite($fsr,"<body bgcolor='black' oncontextmenu='return false' ondragstart='return false' onselectstart='return false' topmargin='0'> \r\n");
fwrite($fsr,"	<form name='click_run' action='' method='POST' enctype='multipart/form-data' target='url_link_tree_solpa_user_r'> \r\n");
fwrite($fsr,"	<input type='hidden' name='mid' value='$mid'> \r\n");
fwrite($fsr,"	<input type='hidden' name='num' > \r\n"); 
fwrite($fsr,"	<input type='hidden' name='sys_pg' value='$sys_pg' > \r\n");
fwrite($fsr,"	<input type='hidden' name='sys_menu' > \r\n");
fwrite($fsr,"	<input type='hidden' name='sys_submenu' > \r\n");
fwrite($fsr,"	<input type='hidden' name='pg' > \r\n");
fwrite($fsr,"	<input type='hidden' name='jong' > \r\n");
fwrite($fsr,"	<input type='hidden' name='title_' > \r\n");
fwrite($fsr,"	<input type='hidden' name='link_' > \r\n");
fwrite($fsr,"	<input type='hidden' name='target_' > \r\n");
fwrite($fsr,"	\r\n");
fwrite($fsr,"<table border='0' > \r\n");
fwrite($fsr,"   <a href='".KAPP_URL_T_."' id='$sys_pg' class='solpa_tree_main' target='_blank'><img src='".$linkwww."/logo/logo.png' id=". $sys_pg." class='solpa_tree_main' style='cursor: hand' align='absmiddle' ></a> <br> \r\n");
fwrite($fsr,"<tr> \r\n");
fwrite($fsr,"<td> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"             <td height='12' align='left' style='color:$fontcolor;font-size:$fontsize'><a href='".$first_linkurl."' target='solpa_user_r' ><img src='".$linkwww."/logo/pizza.png' width='20' height='12'>My-List</a></td>\r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"</td> \r\n");
fwrite($fsr," \r\n");
fwrite($fsr,"<td style='background-color:".$bgcolor."'> \r\n");
$sql_root = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_pg = '$sys_pg' and sys_level <> 'client' order by sys_disno, sys_menu ";
$result = sql_query( $sql_root );
$row = sql_num_rows($result);
	$intloop = 0;
	$i = 1;
	while (( $rsr = sql_fetch_array($result) ) and ( $intloop < 2 )) {
		$rsrsys_menu    = $rsr['sys_menu'];
		$rsrsys_menutit = $rsr['sys_menutit'];
		$rsrsys_subtit  = $rsr['sys_subtit'];
		$rsrsys_submenu	= $rsr['sys_submenu'];
		$rsrsys_level	= $rsr['sys_level'];
		$rsrdiv_open	= "<div id=".$sys_pg.$intloop.">";
		if ( $rsrsys_level == "mroot" ) {
			funcrs($rsrsys_submenu);
	
		} else if ( $rsrsys_level == "sroot" ) {
			funcrs($rsrsys_menu);
	
		}
		$intloop = $intloop + 1;
	}//loop 
fwrite($fsr,"</td> \r\n");
fwrite($fsr,"<td> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td height='12' align='left' style='color:$fontcolor;font-size:$fontsize;'><a href='".KAPP_URL_T_."/menu/index.php' target='solpa_user_r' title='Launch the drop-down menu.'>[".$rssys_treetit."]</a></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"          <td colspan='1' style='color:gray;font-size:9px;'>If the registered information is not displayed, delete the browsing history and try again!</td>\r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"</td> \r\n");
fwrite($fsr,"</tr> \r\n");
fwrite($fsr,"</table> \r\n");
fwrite($fsr,"</body> \r\n");
fwrite($fsr,"</html> \r\n");
fclose($fsr); 
		
if ( $run_mode != 'cratree_update' && $run_mode != 'cratree_insert' && $run_mode != 'cratree_delete' && $run_mode!='treebom_insw_book' && $run_mode != 'cratree_update_book' && $run_mode != 'cratree_delete_book' || $run_mode=='cratree_booktreeupdate') {
	$xxfile = $path . $sys_pg . "_runf.html"; 
	$ft = fopen("$xxfile","w+");
	fwrite($ft,"<html> \r\n");
	fwrite($ft,"<head> \r\n");
	fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
	fwrite($ft,"<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> \r\n");
	fwrite($ft,"<link rel='shortcut icon' href='".$linkwww."/logo/logo25a.jpg'> \r\n");
	fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
	fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
	fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
	fwrite($ft,"<meta name='robots' content='ALL'> \r\n");
	fwrite($ft,"</head> \r\n");
	fwrite($ft,"<frameset cols='18%,*' border='0'>\r\n");
	fwrite($ft,"<frame src='".$sys_pg."_run.html' name='main' scrolling='auto' frameborder='0' >\r\n");
	fwrite($ft,"<frame src='" . $first_linkurl_all . "' name='solpa_user_r' frameborder='no'>\r\n");
	fwrite($ft,"</frameset> \r\n"); 
	fwrite($ft,"</html> \r\n");
	fclose($ft);
}

include('../include/lib/pclzip.lib.php');
$zf		= $sys_pg . '_tree_menu.zip';
$zf_url	= KAPP_URL_T_ . "/file/" . $mid . "/" . $zf;
$zff	= KAPP_PATH_T_ . "/file/" . $mid . "/" . $zf;
$zipfile = new PclZip($zff);//압축파일.zip
$data	 = array();
$file_php1 = KAPP_URL_T_ . "/file/" . $mid. "/" . $sys_pg . "_runf.html";
$file_php2 = KAPP_URL_T_ . "/file/" . $mid. "/" . $sys_pg . "_run.html";
$file_phpP1 = KAPP_PATH_T_ . "/file/" . $mid. "/" . $sys_pg . "_runf.html";
$file_phpP2 = KAPP_PATH_T_ . "/file/" . $mid. "/" . $sys_pg . "_run.html";
$data = array( $file_phpP1, $file_phpP2 );	
$create	= $zipfile -> create($data, PCLZIP_OPT_REMOVE_ALL_PATH); 
echo "<pre>";
//var_dump($create);

?> 
	<h3> Created OK! tree menu_code:<?php echo $file_php1; ?> , Zip File:<?=$zf?></h3>
	<h3> <a href='<?=$zf_url?>' target=_blank>[ Download Action:<?=$zf?> ]</a></h3> 
<?php
	if ( $H_LEV > 1 ){
?>
	<h3><a href='<?=$file_php1?>' target='_blank'>[ tree RUN:<?=$file_php1?> ]</a> 
			</h3>
	<h3>file 1:<?=$file_php1?> </h3>
	<h3>file 2:<?=$file_php2?> </h3>

<?php } ?>
<p>The pointer has been decremented. Download the source code!</p>
</body>
</html>

