<?php
	if (!$H_ID) {
		echo "<script> alert('Login is required!');</script>";
		$url='/';	//$PHP_SELF;
		echo "<script>window.open('$url', '_top', '');</script>";
		exit;
	}
	if( $H_ID !== $mid && $H_LEV < 8 ) {
		my_msg(" You do not have permission! ");
		$url='/';	//$PHP_SELF;
		echo "<script>window.open('$url', '_top', '');</script>";
		exit;
	}
	/* ---------------------------------------------------------------------------------
	//	    eBook Note Tree Create : 트리메뉴만 생성, 
	//      tree_create_menu.php 는 크라트리 note을 생성. : treebom_insw_book_menu.php에서 콜.
	//          - tree_remake_menu.php : tree_remakew_book_menu.php 에서도사용.
	//      tree_create_new_menu.php : 트리메뉴를 생성.
	//		트리메뉴 제작 시작 페이지 : 24c.kr : 2018-03-05  : Update : 2003. 03. 18()
	//		mid  add : 2018-04-01 : 생성자. H_ID를 mid로 변경.
	//		2018-06-25 : function submit_run() : add : https 걸러내고 카운트 add : cratree_coinadd.php
	call : my_editor2_book_menu.php, 
	------------------------------------------------------------------------------------- */
	$result_path = str_replace('\\', '/', dirname(__FILE__));
	$tilde_rm		= preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
	$doc_root		= str_replace($tilde_rm, '', $_SERVER['SCRIPT_FILENAME']);
	$pattern = '/' . preg_quote($doc_root, '/') . '/i';
	$SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
	$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];
	$root = preg_replace($pattern, '', $result_path );
	$port = ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) ? '' : ':'.$_SERVER['SERVER_PORT'];
	$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
	$user = str_replace(preg_replace($pattern, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
	if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
		$host	= preg_replace('/:[0-9]+$/', '', $host);
	$host		= preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
	$linkurl = $http.$host.$port.$user.$root;
	$linkwww = $http.$host.$port;
//	$first_linkurl = $linkurl . "/cratree_my_list_menu.php?mid=".$mid; 
	$first_linkurl = $linkurl . "/index_list.php?mid=".$mid; // 2023-11-17
	$first_linkurl_all = $first_linkurl; 

	$make_type = $_POST['make_type'];
	//m_("tree_create_menu , treebom_insert2_book_menu , make_type: " . $make_type); // tree_create_menu , treebom_insert2_book_menu , make_type: booktreeupdateM2

	$rssys_treetit='';
	$sql = "select * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_level = 'mroot' and sys_pg = '$sys_pg' ";
	$result = sql_query( $sql);
	$rs22 = sql_fetch_array($result);
	$rssys_treetit   = $rs22['sys_subtit'];
	
	$path = KAPP_PATH_T_ . "/menu/";
	$runfile = KAPP_PATH_T_ . "/menu/" . $mid . "/" . $sys_pg . "_run.html";
	$insfile = KAPP_PATH_T_ . "/menu/" . $mid . "/" . $sys_pg . "_ins.html";
	$updfile = KAPP_PATH_T_ . "/menu/" . $mid . "/" . $sys_pg . "_upd.html";

	$fsr = fopen("$runfile","w+");	//실행파일
	$fsi = fopen("$insfile","w+");	//등록파일 
	$fsu = fopen("$updfile","w+");	//변경파일

function funcrs($rsr_submenu) {
	global $from_session_id, $rssys_treetit, $mid;
	global $i, $sys_pg, $intloop, $div_id; 
	global $fsr, $fsi, $fsu;
	global $imgtype1,$imgtype2,$imgtype3, $fontcolor, $fontsize, $bgcolor, $fontface;
	global $make_type, $run_mode, $book_num;
	$i = $i + 1;
	$sql = "select * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$rsr_submenu' order by sys_disno, sys_submenu ";
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
			fwrite( $fsr, $link_url_run." \r\n");		/////항목명 출력
			fwrite( $fsu, $link_url_run." \r\n");		/////항목명 출력
			fwrite( $fsi, $link_url_run." \r\n");		/////항목명 출력
		} else {
			$mid		= $rs2['sys_userid'];
			$num		= $rs2['sys_pg'];
			$pg		= $rs2['sys_link'];
			$jong		= $rs2['tit_gubun'];
			$title_	= $rs2['sys_subtit'];
			$link_		= $rs2['sys_link'];
			$target_= 'solpa_user_r';
			if ( $rssys_cnt == 0 ) {
				$div_open = "";
				$img_type = "<img src='".$imgtype3."' align='absmiddle'>";
				$lk = $rssys_link; 
				$link_url_run  = "<a onclick=\"javascript:submit_run( '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '$target_');\" target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize;' title='$pg, $rssys_memo'>".$rssys_subtit."</a><br>";
			} else {
				$div_id = $rssys_submenu;
				$div_open = "<div id='".$div_id."d' style='display:none'>";
				$img_type = "<img src='".$imgtype1."' id='".$div_id."' class='solpa_tree' style='cursor: hand' align='absmiddle' >";
				// 2019-09-08
				$link_url_run  = "<a onclick=\"javascript:submit_run( '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '$target_');\" target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize;' title='$pg, $rssys_memo'>".$rssys_subtit."</a><br>";
			}
			//$link_url_ins  = "<a href='../treebom_insert2_book_menu.php?make_type=".$make_type."&mode=rowlevel&data=".$rssys_menu."&data1=".$rssys_submenu."&sys_pg_root=".$sys_pg."' target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize' title='If it does not work, please check popup window.'>".$rssys_subtit."</a><br>"; 
			$link_url_ins  = "<a href='". KAPP_URL_T_ ."/menu/treebom_insert2_book_menu.php?make_type=".$make_type."&mode=rowlevel&data=".$rssys_menu."&data1=".$rssys_submenu."&sys_pg_root=".$sys_pg."' target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize' title='If it does not work, please check popup window.'>".$rssys_subtit."</a><br>"; 
			//$link_url_upd  = "<a href='../treebom_update2_new_menu.php?mode=mroot&m_type=booktreeupdate&make_type=".$make_type."&mode=rowlevel&data=".$rssys_menu."&data1=".$rssys_submenu."&sys_pg_root=".$sys_pg."'	target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize' title='If it does not work, please check popup window.'>".$rssys_subtit."</a><br>";
			$link_url_upd  = "<a href='". KAPP_URL_T_ ."/menu/treebom_update2_new_menu.php?mode=mroot&m_type=booktreeupdate&make_type=".$make_type."&mode=rowlevel&data=".$rssys_menu."&data1=".$rssys_submenu."&sys_pg_root=".$sys_pg."'	target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize' title='If it does not work, please check popup window.'>".$rssys_subtit."</a><br>";
			//////////////////< write 되는 순서 중요 >//////////////////////////////////////////////
			if (( $i != 0 ) and ( $rssys_level == "client" )) { 
				for ( $fornum = 1; $fornum <= $i; $fornum++ ){
					fwrite($fsr,"&nbsp;");
					fwrite($fsu,"&nbsp;");
					fwrite($fsi,"&nbsp;");
 		     	}
			} else if ( $rssys_level == "sroot" ) {
				$i = 1;
			}
			fwrite( $fsr, $img_type." \r\n");		/////이미지 출력
			fwrite( $fsr, $link_url_run." \r\n");	/////항목명 출력
			fwrite( $fsr, $div_open." \r\n");		/////div 열기 태그 출력
			fwrite( $fsu, $img_type." \r\n");		/////이미지 출력
			fwrite( $fsu, $link_url_upd." \r\n");	/////항목명 출력
			fwrite( $fsu, $div_open." \r\n");		/////div 열기 태그 출력
			fwrite( $fsi, $img_type." \r\n");		/////이미지 출력
			fwrite( $fsi, $link_url_ins." \r\n");	/////항목명 출력
			fwrite( $fsi, $div_open." \r\n");		/////div 열기 태그 출력
 		}
		if (( $rssys_menutit == "root" ) and ( $rssys_level != "mroot" )) {
			$rsr_submenu = $rssys_submenu;
			funcrs($rssys_submenu);	/////함수 호출( 처음으로...)
		}
		$sys_menutit ="";
	} 
	fwrite($fsr,"</div>" ); 
	fwrite($fsu,"</div>" );
	fwrite($fsi,"</div>" );
 	$i = $i - 1;
}//end function

$skin_sql = "select * from {$tkher['menuskin_table']} where sys_pg = '$sys_pg' ";
$result = sql_query( $skin_sql );
$skinrs = sql_fetch_array($result);
if ( $skinrs == "" ) {
	$bgcolor	= "#cccccc";		/////배경색
	$fontcolor	= "black";			/////글자색
	$fontface	= "Arial";			//"돋움체";			/////글꼴
	$fontsize	= "12";				/////글자크기
	$imgtype1	= KAPP_URL_T_ ."/icon/"."folder.gif";		/////이미지1(닫힘)
	$imgtype2	= KAPP_URL_T_ ."/icon/"."folder1.gif";	/////이미지2(열림)
	$imgtype3	= KAPP_URL_T_ ."/icon/"."folder2.gif";	/////이미지3(하위)
} else {
	$bgcolor	= $skinrs['bgcolor'];		/////배경색
	$fontcolor	= $skinrs['fontcolor'];	/////글자색
	$fontface	= $skinrs['fontface'];	/////글꼴
	$fontsize	= $skinrs['fontsize'];	/////글자크기
	$imgtype1	= KAPP_URL_T_ ."/icon/".$skinrs['imgtype1'];	/////이미지1(닫힘)
	$imgtype2	= KAPP_URL_T_ ."/icon/".$skinrs['imgtype2'];	/////이미지2(열림)
	$imgtype3	= KAPP_URL_T_ ."/icon/".$skinrs['imgtype3'];	/////이미지3(하위)	//$imgtype3	= "/cratree/skins_treeicon/as00/".$skinrs['imgtype3'];	/////이미지3(하위)
}
fwrite($fsr,"<html> \r\n");
fwrite($fsr,"<head> \r\n");
fwrite($fsr,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
fwrite($fsr,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
fwrite($fsr,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
fwrite($fsr,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
fwrite($fsr,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
fwrite($fsr,"<meta name='description' content='web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
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
fwrite($fsr,"					document.click_run.target=target_;   // add  \r\n");
fwrite($fsr,"					document.click_run.target_.value=target_;     \r\n");
fwrite($fsr,"					document.click_run.action= '../cratree_coinadd_menu.php'; \r\n");    
fwrite($fsr,"					document.click_run.submit();     \r\n");
fwrite($fsr,"			} else if (pg.indexOf( 'https://naver')>=0 || pg.indexOf('https://google')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"					document.click_run.target='_blank';  \r\n");
fwrite($fsr,"					document.click_run.target_.value='_blank'; \r\n");
fwrite($fsr,"					document.click_run.action= '../cratree_coinadd_menu.php';     \r\n");
fwrite($fsr,"					document.click_run.submit();     \r\n");
fwrite($fsr,"			} else if (pg.indexOf( 'https://')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"					document.click_run.target='_blank';  \r\n");
fwrite($fsr,"					document.click_run.target_.value='_top'; \r\n");
fwrite($fsr,"					document.click_run.action= '../cratree_coinadd_menu.php';     \r\n");
fwrite($fsr,"					document.click_run.submit();     \r\n");
fwrite($fsr,"			} else { \r\n");
fwrite($fsr,"					document.click_run.target=target_;   // add  \r\n");
fwrite($fsr,"					document.click_run.target_.value=target_;     \r\n");
fwrite($fsr,"					document.click_run.action= '../cratree_coinadd_menu.php'; \r\n");    
fwrite($fsr,"					document.click_run.submit();     \r\n");
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
fwrite($fsr,"	<input type='hidden' name='mid' value='<?=$mid?>'> \r\n");
fwrite($fsr,"	<input type='hidden' name='num' > \r\n"); 
fwrite($fsr,"	<input type='hidden' name='sys_pg' value='<?=$sys_pg?>' > \r\n");
fwrite($fsr,"	<input type='hidden' name='sys_menu' > \r\n");
fwrite($fsr,"	<input type='hidden' name='sys_submenu' > \r\n");
fwrite($fsr,"	<input type='hidden' name='pg' > \r\n");
fwrite($fsr,"	<input type='hidden' name='jong' > \r\n");
fwrite($fsr,"	<input type='hidden' name='title_' > \r\n");
fwrite($fsr,"	<input type='hidden' name='link_' > \r\n");
fwrite($fsr,"	<input type='hidden' name='target_' > \r\n");
fwrite($fsr,"	\r\n");
fwrite($fsr,"	\r\n");
fwrite($fsr,"<table border='0' > \r\n");
fwrite($fsr,"   <a href='". $_SERVER['HTTP_HOST']. "' id='$sys_pg' class='solpa_tree_main' target='_blank'><img src='".KAPP_URL_T_."/icon/logo.png' id=". $sys_pg." class='solpa_tree_main' style='cursor: hand' align='absmiddle' ></a> <br> \r\n");
fwrite($fsr,"<tr> \r\n");
fwrite($fsr,"<td> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"             <td style='color:$fontcolor;font-size:12px;text-align:left;'><a href='".$first_linkurl."' target='solpa_user_r' style='font-size:".$fontsize."px;'><img src='".KAPP_URL_T_."/icon/pizza.png' width='20' height='15'>".$rssys_treetit."</a></td>\r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"</td> \r\n");
fwrite($fsr," \r\n");
fwrite($fsr," \r\n");
fwrite($fsr," \r\n");
fwrite($fsr,"	<td style='background-color:".$bgcolor."'>   \r\n");
////////////////////////////////  _ins.html ///////////////////////////////////////
fwrite($fsi,"<html> \r\n");
fwrite($fsi,"<head> \r\n");
fwrite($fsi,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
fwrite($fsi,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
fwrite($fsi,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
fwrite($fsi,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
fwrite($fsi,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
fwrite($fsi,"<meta name='description' content='web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
fwrite($fsi,"<meta name='robots' content='ALL'> \r\n");
fwrite($fsi,"<head> \r\n");
fwrite($fsi,"<script language=\"javascript\"> \r\n");
fwrite($fsi,"<!-- \r\n");
fwrite($fsi,"function clickHandler() {  \r\n");
fwrite($fsi,"	var  targetId, srcElement,  targetElement;  \r\n");
fwrite($fsi,"	srcElement = window.event.srcElement;  \r\n");
fwrite($fsi,"	if (srcElement.className == \"solpa_tree\") {  \r\n");
fwrite($fsi,"		targetId = srcElement.id + \"d\";  \r\n");
fwrite($fsi,"		targetElement = document.all( targetId);  \r\n");
fwrite($fsi,"		if ( targetElement.style.display == \"none\") {  \r\n");
fwrite($fsi,"			targetElement.style.display = \"\";  \r\n");
fwrite($fsi,"			srcElement.src = \"".$imgtype2."\";  \r\n");
fwrite($fsi,"		} else {  \r\n");
fwrite($fsi,"			targetElement.style.display = \"none\";  \r\n");
fwrite($fsi,"			srcElement.src = \"".$imgtype1."\";  \r\n");
fwrite($fsi,"		}  \r\n");
fwrite($fsi,"	}  \r\n");
fwrite($fsi,"} \r\n");
fwrite($fsi,"document.onclick = clickHandler;  \r\n");
fwrite($fsi,"//--> \r\n");
fwrite($fsi,"</script> \r\n");
fwrite($fsi,"<style type=\"text/css\"> \r\n");
fwrite($fsi,"	body, td, div, a {font-size:".$fontsize."pt;font-family:".$fontface.";} \r\n");
fwrite($fsi,"	a:link {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsi,"	a:visited {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsi,"	a:active {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsi,"	a:hover {color:#01ff01; text-decoration:none} \r\n");
fwrite($fsi,"	body, td { \r\n");
fwrite($fsi,"		scrollbar-face-color: #3399ff;  \r\n");
fwrite($fsi,"		scrollbar-shadow-color: #99ccff;  \r\n");
fwrite($fsi,"		scrollbar-highlight-color: #99ccff;  \r\n");
fwrite($fsi,"		scrollbar-3dlight-color: #99ccff;  \r\n");
fwrite($fsi,"		scrollbar-darkshadow-color: #99ccff;  \r\n");
fwrite($fsi,"		scrollbar-track-color: #99ccff;  \r\n");
fwrite($fsi,"		scrollbar-arrow-color: #99ccff; \r\n");
fwrite($fsi,"	} \r\n");
fwrite($fsi,"</style> \r\n");
fwrite($fsi,"</head> \r\n");
fwrite($fsi,"<body bgcolor='".$bgcolor."' oncontextmenu='return false' ondragstart='return false' onselectstart='return false' onkeydown='' onLoad='' onResize='' topmargin='0'> \r\n");
fwrite($fsi,"<table border='0' > \r\n");
fwrite($fsi,"   <a href='https://appgenerator.net' id='$sys_pg' class='solpa_tree_main' target='_blank'><img src='".KAPP_URL_T_."/icon/logo.png' id=". $sys_pg." class='solpa_tree_main' style='cursor: hand' align='absmiddle' ></a> <br> \r\n");
fwrite($fsi,"<tr> \r\n");
fwrite($fsi,"<td> \r\n");
fwrite($fsi,"          <tr> \r\n");
fwrite($fsi,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsi,"          </tr> \r\n");
fwrite($fsi,"          <tr> \r\n");
fwrite($fsi,"             <td height='15' align='left' style='color:$fontcolor;font-size:$fontsize'><a href='".$first_linkurl."' target='solpa_user_r' ><img src='".KAPP_URL_T_."/icon/pizza.png' width='20' height='15'> My List</a></td>\r\n");
fwrite($fsi,"          </tr> \r\n");
fwrite($fsi,"          <tr> \r\n");
fwrite($fsi,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsi,"          </tr> \r\n");
fwrite($fsi,"</td> \r\n");
fwrite($fsi," \r\n");
fwrite($fsi," \r\n");
fwrite($fsi,"<td> \r\n");
///////////////////////  _upd_html ////////////////////////
fwrite($fsu,"<html> \r\n");
fwrite($fsu,"<head> \r\n");
fwrite($fsu,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
fwrite($fsu,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
fwrite($fsu,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
fwrite($fsu,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
fwrite($fsu,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
fwrite($fsu,"<meta name='description' content='web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
fwrite($fsu,"<meta name='robots' content='ALL'> \r\n");
fwrite($fsu,"<head> \r\n");
fwrite($fsu,"<script language=\"javascript\"> \r\n");
fwrite($fsu,"<!-- \r\n");
fwrite($fsu,"function clickHandler() {  \r\n");
fwrite($fsu,"	var  targetId, srcElement,  targetElement;  \r\n");
fwrite($fsu,"	srcElement = window.event.srcElement;  \r\n");
fwrite($fsu,"	if (srcElement.className == \"solpa_tree\") {  \r\n");
fwrite($fsu,"		targetId = srcElement.id + \"d\";  \r\n");
fwrite($fsu,"		targetElement = document.all( targetId);  \r\n");
fwrite($fsu,"		if ( targetElement.style.display == \"none\") {  \r\n");
fwrite($fsu,"			targetElement.style.display = \"\";  \r\n");
fwrite($fsu,"			srcElement.src = \"".$imgtype2."\";  \r\n");
fwrite($fsu,"		} else {  \r\n");
fwrite($fsu,"			targetElement.style.display = \"none\";  \r\n");
fwrite($fsu,"			srcElement.src = \"".$imgtype1."\";  \r\n");
fwrite($fsu,"		}  \r\n");
fwrite($fsu,"	}  \r\n");
fwrite($fsu,"} \r\n");
fwrite($fsu,"document.onclick = clickHandler;  \r\n");
fwrite($fsu,"//--> \r\n");
fwrite($fsu,"</script> \r\n");
fwrite($fsu,"<style type=\"text/css\"> \r\n");
fwrite($fsu,"	body, td, div, a {font-size:".$fontsize."pt;font-family:".$fontface.";} \r\n");
fwrite($fsu,"	a:link {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsu,"	a:visited {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsu,"	a:active {color:".$fontcolor."; text-decoration:none} \r\n");
fwrite($fsu,"	a:hover {color:#01ff01; text-decoration:none} \r\n");
fwrite($fsu,"	body, td { \r\n");
fwrite($fsu,"		scrollbar-face-color: #3399ff;  \r\n");
fwrite($fsu,"		scrollbar-shadow-color: #99ccff;  \r\n");
fwrite($fsu,"		scrollbar-highlight-color: #99ccff;  \r\n");
fwrite($fsu,"		scrollbar-3dlight-color: #99ccff;  \r\n");
fwrite($fsu,"		scrollbar-darkshadow-color: #99ccff;  \r\n");
fwrite($fsu,"		scrollbar-track-color: #99ccff;  \r\n");
fwrite($fsu,"		scrollbar-arrow-color: #99ccff; \r\n");
fwrite($fsu,"	} \r\n");
fwrite($fsu,"</style> \r\n");
fwrite($fsu,"</head> \r\n");
fwrite($fsu,"<body bgcolor='".$bgcolor."' oncontextmenu='return false' ondragstart='return false' onselectstart='return false' onkeydown='' onLoad='' onResize='' topmargin='0'> \r\n");
fwrite($fsu,"<table border='0' > \r\n");
fwrite($fsu,"   <a href='https://appgenerator.net' id='$sys_pg' class='solpa_tree_main' target='_blank'><img src='".KAPP_URL_T_."/icon/logo.png' id=". $sys_pg." class='solpa_tree_main' style='cursor: hand' align='absmiddle' ></a> <br> \r\n");
fwrite($fsu,"<tr> \r\n");
fwrite($fsu,"<td> \r\n");
fwrite($fsu,"          <tr> \r\n");
fwrite($fsu,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsu,"          </tr> \r\n");
fwrite($fsu,"          <tr> \r\n");
fwrite($fsu,"             <td style='color:$fontcolor;font-size:15px;text-align:left;'><a href='".$first_linkurl."' target='solpa_user_r' style='font-size:15px;'><img src='".KAPP_URL_T_."/icon/pizza.png' width='20' height='15'> My List</a></td>\r\n");
fwrite($fsu,"          </tr> \r\n");
fwrite($fsu,"          <tr> \r\n");
fwrite($fsu,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsu,"          </tr> \r\n");
fwrite($fsu,"</td> \r\n");
fwrite($fsu," \r\n");
fwrite($fsu," \r\n");
fwrite($fsu,"<td> \r\n");

////트리 메뉴 최상위 항목 가져옴
$sql_root = "select * from {$tkher['sys_menu_bom_table']} where sys_pg = '$sys_pg' and sys_level <> 'client' order by sys_disno, sys_menu ";
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
	}	/////sys_menutit = root 레벨 레코드 select
	$intloop = $intloop + 1;
}//loop 
fwrite($fsr,"</td> \r\n");
fwrite($fsr,"<td> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td style='color:$fontcolor;font-size:$fontsize;text-align:left;'><a href='./".$sys_pg."_menu.html' target='solpa_user_r' title='Launch the drop-down menu.' style='font-size:15px;'>[".$rssys_treetit."]</a></td> \r\n");
fwrite($fsr,"            <td height='12' align='center' style='color:$fontcolor; font-size:12px; font-weight:bold;' title='Add note item'><a href='../my_editor2_book_insert_menu.php?book_num=$sys_pg' id='$sys_pg' style='font-size:15px;' target='solpa_user_r'><img src='".KAPP_URL_T_."/icon/pizza.png' width='20' height='15'>Add</a></td> \r\n");

fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsr,"          </tr> \r\n");

fwrite($fsr,"          <tr> \r\n");
fwrite($fsr,"          <td colspan='1' style='font-size:9px;color:gray;'>If the registered information is not displayed, delete the browsing history and try again!</td>\r\n");
fwrite($fsr,"          </tr> \r\n");
fwrite($fsr,"</td> \r\n");
fwrite($fsr,"</tr> \r\n");
fwrite($fsr,"</table> \r\n");
fwrite($fsr,"</body> \r\n");
fwrite($fsr,"</html> \r\n");
///////////////////////////////////////////////////////////////////////////////////////
fwrite($fsi,"</td> \r\n");
fwrite($fsi,"<td> \r\n");
fwrite($fsi,"          <tr> \r\n");
fwrite($fsi,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsi,"          </tr> \r\n");
fwrite($fsi,"          <tr> \r\n");
fwrite($fsi,"            <td height='15' align='center' style='color:$fontcolor;font-size:$fontsize;font-weight:bold;'><a href='../my_editor2_book_insert_menu.php?book_num=$sys_pg' id='$sys_pg' class='solpa_tree_main' target='solpa_user_r' ><img src='".KAPP_URL_T_."/icon/pizza.png' width='20' height='15'>Add</a></td> \r\n");
fwrite($fsi,"          </tr> \r\n");
fwrite($fsi,"          <tr> \r\n");
fwrite($fsi,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsi,"          </tr> \r\n");
fwrite($fsi,"</td> \r\n");
fwrite($fsi,"</tr> \r\n");
fwrite($fsi,"</table> \r\n");
fwrite($fsi,"</body> \r\n");
fwrite($fsi,"</html> \r\n");
/////////////////////////////////////////////////////////////////////////////////////
fwrite($fsu,"</td> \r\n");
fwrite($fsu,"<td> \r\n");
fwrite($fsu,"          <tr> \r\n");
fwrite($fsu,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsu,"          </tr> \r\n");
fwrite($fsu,"          <tr> \r\n");
fwrite($fsu,"            <td height='15' align='center' style='color:$fontcolor;font-size:$fontsize;font-weight:bold;'><a href='../my_editor2_book_insert_menu.php?book_num=$sys_pg' id='$sys_pg' class='solpa_tree_main' target='solpa_user_r' ><img src='".KAPP_URL_T_."/icon/pizza.png' width='20' height='15'>Add</a></td> \r\n");
fwrite($fsu,"          </tr> \r\n");
fwrite($fsu,"          <tr> \r\n");
fwrite($fsu,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
fwrite($fsu,"          </tr> \r\n");
fwrite($fsu,"</td> \r\n");
fwrite($fsu,"</tr> \r\n");
fwrite($fsu,"</table> \r\n");
fwrite($fsu,"</body> \r\n");
fwrite($fsu,"</html> \r\n");   
fclose($fsu);
fclose($fsi);
fclose($fsr); 
//////////////////////////////////////////////////////////////////////////////////////////
	if ( $run_mode != 'cratree_update' && $run_mode != 'cratree_insert' && $run_mode != 'cratree_delete' && $run_mode!='treebom_insw_book' && $run_mode != 'cratree_update_book' && $run_mode != 'cratree_delete_book' || $run_mode=='cratree_booktreeupdate' || $run_mode=='cratree_booktreeupdateM') {
		$xxfile = $path . $mid ."/". $sys_pg . "_runf.html"; 
		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
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
		$xxfile = $path . $mid ."/". $sys_pg . "_insf.html";
		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");
		fwrite($ft,"</head> \r\n");
		fwrite($ft,"<frameset cols='18%,82%' border='0'>\r\n");
		fwrite($ft,"<frame src=\"".$sys_pg."_ins.html\" name='main' scrolling='auto' frameborder='0' >\r\n");
		fwrite($ft,"<frame src='../treebom_insert2_book_menu.php?mode=mroot&make_type=newcratree_book&data=".$sys_pg."&data1=".$sys_pg."&sys_pg_root=".$sys_pg."' name='solpa_user_r' frameborder='no'>\r\n");
		fwrite($ft,"</frameset> \r\n"); 
		fwrite($ft,"</html> \r\n");
		fclose($ft); 
		$xxfile = $path . $mid ."/". $sys_pg . "_updf.html";
		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");
		fwrite($ft,"</head> \r\n"); 
		fwrite($ft,"<frameset cols='18%,82%' border='0'>\r\n");
		fwrite($ft,"<frame src=\"".$sys_pg."_upd.html\" name='main' scrolling='auto' frameborder='0' >\r\n");
		fwrite($ft,"<frame src='../treebom_update2_new_menu.php?mode=mroot&m_type=booktreeupdate&make_type=newcratree_book&data=".$sys_pg."&data1=".$sys_pg."&sys_pg_root=".$sys_pg."' name='solpa_user_r' frameborder=no>\r\n");
		fwrite($ft,"</frameset> \r\n");
		fwrite($ft,"</html> \r\n");
		fclose($ft);

		$xxfile = $path . $mid ."/". $sys_pg . "_r2.htm";
		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");
		fwrite($ft,"<link href='../css/style1.css' rel='stylesheet' type='text/css'>\r\n");
		fwrite($ft,"<style type=\"text/css\">\r\n");
		fwrite($ft,".bord {\r\n");
		fwrite($ft,"border-top: 1 solid white;\r\n");
		fwrite($ft,"border-left: 1 solid white;\r\n");
		fwrite($ft,"border-bottom: 1 solid #006699;\r\n");
		fwrite($ft,"border-right: 1 solid #006699;\r\n");
		fwrite($ft,"padding: 1 1 1 1;\r\n");
		fwrite($ft,"color: cyan;\r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,".bordout {\r\n");
		fwrite($ft,"border-top: 1 solid #006699;\r\n");
		fwrite($ft,"border-left: 1 solid #006699;\r\n");
		fwrite($ft,"border-bottom: 1 solid white;\r\n");
		fwrite($ft,"border-right: 1 solid white;\r\n");
		fwrite($ft,"padding: 1 1 1 1;\r\n");
		fwrite($ft,"color: cyan;\r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"def {\r\n");
		fwrite($ft,"border: #0099cc;\r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"body, td, div, a {font-size:12pt;font-family:휴먼옛체;}\r\n"); 
		fwrite($ft,"a:link {color:yellow; text-decoration:none}\r\n"); 
		fwrite($ft,"a:visited {color:#00ffff; text-decoration:none}\r\n");
		fwrite($ft,"a:active {color:yellow; text-decoration:none}\r\n");
		fwrite($ft,"a:hover {color:green; text-decoration:none}\r\n");
		fwrite($ft,"</style>\r\n");
		fwrite($ft,"</head> \r\n");
		fwrite($ft,"<body leftmargin='0' marginwidth='0' topmargin='0' marginheight='0' bgcolor='#000000'> \r\n");
		fwrite($ft,"<table border='1' width='800' height='20' cellspacing='0' bordercolor='green' bordercolordark='green' bordercolorlight='#0099cc'> \r\n");
		fwrite($ft,"<td class='def' width='100' height='20' onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor=green bgcolor=#000000 align=center width=79><a href='./".$sys_pg."_insf.html' target='solpa_user_r_bottom'>Note Add</a></td>\r\n");
		fwrite($ft,"<td class='def' width='100' height='20' onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor='green' bgcolor='#000000' align='center' width=79><a href=\"".$sys_pg."_updf.html\" target='solpa_user_r_bottom'>UPDATE</a></td>\r\n");
		fwrite($ft,"<td class='def' width='100' height='20' onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor='green' bgcolor='#000000' align='center' width='79'><a href=\"".$sys_pg."_runf.html\" target='solpa_user_r_bottom'>RUN</a></td>\r\n"); 
		fwrite($ft,"<td class=def width=120 height=20 onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor='green' bgcolor='#000000' align='center' width='79'><a href='../tree_remake_book_menu.php?mid=$mid&make_type=newcratree_book&sys_pg=".$sys_pg."&book_num=".$sys_pg."' target='solpa_user_r'>DESIGN</a></td>\r\n");
		fwrite($ft,"</body>\r\n");
		fwrite($ft,"</html>\r\n"); 
		fclose($ft);
		
		$xxfile = $path . $mid ."/". $sys_pg . "_r1.htm";
		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE> \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='".KAPP_URL_T_."/icon/logo25a.jpg'> \r\n");
		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");
		fwrite($ft,"</head> \r\n");
		fwrite($ft,"<frameset rows='5%, 95%' cols='1*' border='0'> \r\n");
		$r2='../pg_r2_menu.php?mid=' . $mid . '&pg=' . $sys_pg. '&type=M'; // B->M :2021-02-22
		fwrite($ft,"	<frame src='" . $r2 . "' name='selhead'  scrolling='no' > \r\n");
		fwrite($ft,"    <frame src='".$sys_pg."_runf.html' name='solpa_user_r_bottom' > \r\n");
		fwrite($ft,"</frameset> \r\n");
		fwrite($ft,"</html>\r\n");
		fwrite($ft,"\r\n");
		fclose($ft);

		//m_("tree_create_menu m_type:$m_type, make_type:$make_type"); //tree_create_menu m_type:booktreeupdateM2, make_type:booktreeupdateM2

		//tree_create_menu , treebom_insert2_book_menu - treebom_insw_book_menu , make_type: booktreeupdateM2
		if ( $make_type=='newcratree' ) {
			//$rungo = './' . $mid . '/' . $sys_pg.'_runf.html';
			$rungo = KAPP_URL_T_ .  '/menu/' . $mid . '/' . $sys_pg.'_runf.html';
			echo "<script>window.open('$rungo', 'solpa_user_r_bottom', ''); </script>";

		} else if( $make_type =='booktreeupdateM2' ) { // booktreeupdateM2 : treebom_insert2_book_menu , treebom_insw_book_menu

 			$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit . "&num=" . $max_num . "&sys_jong=" . $sys_jong . "&board_num=" . $board_num . "&sys_link=" . $sys_link; // 2023-11-21 : index_menu.php<-tree_run.php 2023-11-02 add treebom_insw_book :book_num
			echo "<script>window.open('$rungo', '_top', ''); </script>";
			//<iframe src='https://modumodu.net/kapp/menu/https://modumodu.net/kapp/menu/contents_view_menuD.php?num=solpakan1713419549' 

		} else if ( $run_mode=='note_treebom_remake_all' ) { // treebom_remake_all_menu.php에서 온다.
			$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg='.$sys_pg ."&mid=" . $mid . '&open_mode=on'; //2023-11-21 : index_menu.php<-tree_run.php
			echo "<script>window.open('$rungo', '_top', ''); </script>";
		} else if ( $run_mode=='booktreeupdateM' ) { // cratree_booktreeupdateM 2021-05-28
			$rungo = './r1.php?sys_pg='.$sys_pg;
			echo "<script>window.open('$rungo', '_top', ''); </script>";
		} else if ( $run_mode=='booktreeupdateM2' ) { // cratree_booktreeupdateM2 2021-05-30
 				$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit;
			echo "<script>window.open('$rungo', '_top', ''); </script>"; exit;
		} else if ( $run_mode=='treebom_insw_book' || $run_mode == 'tree_remakew_book' || $run_mode == 'cratree_update_book' || $run_mode == 'cratree_delete_book'  || $run_mode=='cratree_booktreeupdate' || $run_mode=='cratree_booktreeupdateM' ) {
			//$rungo = './' . $mid . '/' . $sys_pg.'_r1.htm';
			$rungo = KAPP_URL_T_ . '/menu/' . $mid . '/' . $sys_pg.'_r1.htm';
			echo "<script>window.open('$rungo', '_top', ''); </script>";
		} else if ( $run_mode == 'cratreebook_update' ) {
			//$rungo = './' . $mid . '/' . $sys_pg.'_r1.htm';
			$rungo = KAPP_URL_T_ . '/menu/' . $mid . '/' . $sys_pg.'_r1.htm';
			echo "<script>window.open('$rungo', '_top', ''); </script>";
		} else if ( $run_mode == 'cratree_delete' ) {
			//$rungo = './' . $mid . '/' . $sys_pg.'_r1.htm';
			$rungo = KAPP_URL_T_ . '/menu/' . $mid . '/' . $sys_pg.'_r1.htm';
			echo "<script>window.open('$rungo', '_top', ''); </script>";

		} else if ( $run_mode == 'cratree_update_book_my' ) {
		} else {
			$rungo = './' . $mid . '/' . $sys_pg.'_r1.htm';
			echo "<script>window.open('$rungo', '_top', ''); </script>";
		}
?>
