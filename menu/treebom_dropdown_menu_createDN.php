<?php
	include_once('../tkher_start_necessary.php');

	/* ---------------------------------------------------------------------- 
	   treebom_dropdown_menu_createDN.php
	//	    eBook Note Tree Create : 트리메뉴만 생성, 
	//      treebom_dropdown_menu_createDN.php 
	//      tree_create_menu.php 는 tree menu source code 생성. 
	//          - tree_remake_menu.php : tree_remakew_book_menu.php 에서도사용.
	//      tree_create_new_menu.php : 트리메뉴를 생성.
	//		트리메뉴 제작 시작 페이지 : 24c.kr : 2018-03-05  : Update : 2003. 03. 18()
	//		mid  add : 2018-04-01 : 생성자. H_ID를 mid로 변경.
	//		2018-06-25 : 
	//      function submit_run() : add : https 걸러내고 카운트 add : cratree_coinadd.php
	---------------------------------------------------------------------- */
	$H_ID    = get_session("ss_mb_id"); 
	$H_POINT = $member['mb_point']; $H_LEV=$member['mb_level']; 
	if( !$H_ID or $H_LEV < 2 ) {
		m_("You need to login. ");exit;
	}
	$dn_minus_point = $config['kapp_download_point'];
	$dn_add_point = -$config['kapp_download_point'];
	if( $H_POINT < abs($dn_minus_point) ) {
		m_("There are not enough points. point:$H_POINT");exit;
		//echo "<script>window.open('/', '_top', '');</script>";exit;
	}
	if( isset($_POST['mid']) ) $mid = $_POST['mid'];
	else $mid = '';
	if( isset($_POST['run_mode']) ) $run_mode = $_POST['run_mode'];
	else $run_mode = '';
	if( $run_mode == 'dropdown_menu_createDN') {
		if( $H_ID != 'dao' ) coin_minus_func($H_ID, $dn_minus_point);
		if( $H_ID != $mid ) coin_add_func($mid, $dn_add_point);
	} else exit();

	$linkurl = KAPP_URL_T_ . "/menu";
	$linkwww = KAPP_URL_T_;
	$first_linkurl = KAPP_URL_T_ . "/menu/index.php?mid=".$mid;
	$first_linkurl_all = $first_linkurl; 
	if( isset($_POST['sys_pg']) ) $sys_pg = $_POST['sys_pg']; 
	else $sys_pg = '';
	$rssys_treetit='';
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_level = 'mroot' and sys_pg = '$sys_pg' ";
	$result = sql_query( $sql);
	$rs22   = sql_fetch_array($result);
	$rssys_treetit   = $rs22['sys_subtit'];
	$from_session_id = $rs22['sys_userid'];

	$runfile = KAPP_PATH_T_ . "/file/" . $mid . "/" . $sys_pg . "_menu.html";
	$fsr = fopen("$runfile","w+");	//실행파일

	$skin_sql = "SELECT * from menuskin where sys_pg = '$sys_pg' ";
	$result = sql_query( $skin_sql );
	$skinrs = sql_fetch_array($result);
	if( $skinrs == "" ) {
		$bgcolor	= "#cccccc";		/////배경색
		$fontcolor	= "black";			/////글자색
		$fontface	= "Arial";			//"돋움체";			/////글꼴
		$fontsize	= "12";				/////글자크기
		$imgtype1	= "folder.gif";		/////이미지1(닫힘)
		$imgtype2	= "folder1.gif";	/////이미지2(열림)
		$imgtype3	= "folder2.gif";	/////이미지3(하위)
	} else {
		$bgcolor	= $skinrs['bgcolor'];		/////배경색
		$fontcolor	= $skinrs['fontcolor'];	/////글자색
		$fontface	= $skinrs['fontface'];	/////글꼴
		$fontsize	= $skinrs['fontsize'];	/////글자크기
		$imgtype1	= $skinrs['imgtype1'];	/////이미지1(닫힘)
		$imgtype2	= $skinrs['imgtype2'];	/////이미지2(열림)
		$imgtype3	= $skinrs['imgtype3'];	/////이미지3(하위)
	}

$pathM = KAPP_URL_T_ . "/icon/";
fwrite($fsr,"<html> \r\n");
fwrite($fsr,"<head> \r\n");
fwrite($fsr,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
fwrite($fsr,"<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> \r\n");
fwrite($fsr,"<link rel='shortcut icon' href='". KAPP_URL_T_ ."/logo/logo25a.jpg'> \r\n");
fwrite($fsr,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
fwrite($fsr,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
fwrite($fsr,"<meta name='description' content='web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
fwrite($fsr,"<meta name='robots' content='ALL'> \r\n");
fwrite($fsr,"<link rel='stylesheet' href='". KAPP_URL_T_ ."/include/css/kancss.css' type='text/css'> \r\n");
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
fwrite($fsr,"			srcElement.src = \"".$pathM.$imgtype2."\";  \r\n");
fwrite($fsr,"		} else {  \r\n");
fwrite($fsr,"			targetElement.style.display = \"none\";  \r\n");
fwrite($fsr,"			srcElement.src = \"".$pathM.$imgtype1."\";  \r\n");
fwrite($fsr,"		}  \r\n");
fwrite($fsr,"	}  \r\n");
fwrite($fsr,"} \r\n");
fwrite($fsr,"document.onclick = clickHandler;  \r\n");
fwrite($fsr,"	function submit_run( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_, level) {  \r\n");
fwrite($fsr,"			document.click_run.mid.value=mid; \r\n");
fwrite($fsr,"	   		document.click_run.sys_pg.value=sys_pg; \r\n");
fwrite($fsr,"			document.click_run.sys_menu.value=sys_menu;   \r\n");
fwrite($fsr,"			document.click_run.sys_submenu.value=sys_submenu;   \r\n");
fwrite($fsr,"			document.click_run.num.value=num;   \r\n");
fwrite($fsr,"			document.click_run.pg.value=pg;   \r\n");
fwrite($fsr,"	 		document.click_run.jong.value=jong;  \r\n");
fwrite($fsr,"			document.click_run.title_.value=title_;   \r\n");
fwrite($fsr,"			document.click_run.link_.value=link_;   \r\n");
fwrite($fsr,"			if (pg.indexOf( 'contents_view_menuD.php')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"					document.click_run.target='frame';   // add  \r\n");
fwrite($fsr,"					document.click_run.target_.value='frame';     \r\n");
fwrite($fsr,"					document.click_run.action= pg; \r\n");    
fwrite($fsr,"					document.click_run.submit();     \r\n");
fwrite($fsr,"			} else if (link_.indexOf( 'www.youtube.com')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"				document.click_run.target='_blank';  \r\n");
fwrite($fsr,"				document.click_run.target_.value='_top'; \r\n");
fwrite($fsr,"					document.click_run.action= pg; \r\n");    
fwrite($fsr,"				document.click_run.submit();     \r\n");
fwrite($fsr,"			} else if (pg.indexOf( 'https://')>=0 ) \r\n");
fwrite($fsr,"			{ \r\n");
fwrite($fsr,"					document.click_run.target='_blank';  \r\n");
fwrite($fsr,"					document.click_run.target_.value='_top'; \r\n");
fwrite($fsr,"					document.click_run.action= pg; \r\n");    
fwrite($fsr,"					document.click_run.submit();     \r\n");
fwrite($fsr,"			} else { \r\n");
fwrite($fsr,"					document.click_run.target='frame';   // add  \r\n");
fwrite($fsr,"					document.click_run.target_.value='frame';     \r\n");
fwrite($fsr,"					document.click_run.action= pg; \r\n");    
fwrite($fsr,"					document.click_run.submit();     \r\n");
fwrite($fsr,"			} \r\n");
fwrite($fsr,"	}   \r\n");
fwrite($fsr,"//--> \r\n");
fwrite($fsr,"</script> \r\n");
fwrite($fsr,"</head> \r\n");
fwrite($fsr,"<body topmargin='0'> \r\n");
fwrite($fsr,"	<form name='click_run' action='' method='POST' enctype='multipart/form-data' target='url_link_tree_solpa_user_r'> \r\n");
fwrite($fsr,"	<input type='hidden' name='click_p' value='' >      \r\n");
fwrite($fsr,"	<input type='hidden' name='mid' value='$mid' >      \r\n");
fwrite($fsr,"	<input type='hidden' name='num' >      \r\n"); 
fwrite($fsr,"	<input type='hidden' name='sys_pg' >   \r\n");
fwrite($fsr,"	<input type='hidden' name='sys_menu' > \r\n");
fwrite($fsr,"	<input type='hidden' name='sys_submenu' > \r\n");
fwrite($fsr,"	<input type='hidden' name='pg' >     \r\n");
fwrite($fsr,"	<input type='hidden' name='jong' >   \r\n");
fwrite($fsr,"	<input type='hidden' name='title_' > \r\n");
fwrite($fsr,"	<input type='hidden' name='link_' >   \r\n");
fwrite($fsr,"	<input type='hidden' name='target_' > \r\n");
fwrite($fsr,"	</form>  \r\n");
fwrite($fsr,"	\r\n");
fwrite($fsr,"<center> \r\n");
fwrite($fsr,"<div class='header'> \r\n");
fwrite($fsr,"<ul id='nav'>  \r\n");
fwrite($fsr,"    \r\n");
fwrite($fsr,"    \r\n");
fwrite($fsr,"  <li class='current' align='center'>\r\n");
fwrite($fsr,"    		<a href='".$first_linkurl."' target='frame'><img src='". KAPP_URL_T_ ."/logo/logo60.png' style='border-style:;height:20px;' title='".$rssys_treetit."'></a> \r\n");

fwrite($fsr,"   <ul>\r\n");
fwrite($fsr,"    	<li>\r\n");
fwrite($fsr,"    		<a href='" .KAPP_URL_T_ ."/file/" . $mid."/". $sys_pg . "_menu.html"."' target='_top'>$rssys_treetit</a> \r\n");
fwrite($fsr,"    	</li>\r\n");
fwrite($fsr,"   </ul>\r\n");
fwrite($fsr,"  </li>\r\n");
$root_on = 0;
$level_root = '';

function funcrs($rsr_submenu, $level) {
	global $from_session_id, $rssys_treetit, $mid, $root_on;
	global $i, $sys_pg, $intloop; 
	global $fsr, $fsi, $fsu;
	global $imgtype1,$imgtype2,$imgtype3, $fontcolor, $fontsize, $bgcolor, $fontface;
	global $make_type, $run_mode, $book_num, $tkher;
    $cnt =0;
	$cnt_root=0;
	$i = $i + 1;
	$sql = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_userid='$mid' and sys_pg='$sys_pg' and sys_menu='$rsr_submenu' order by sys_disno, sys_submenu ";
	$result = sql_query( $sql);
	$row_num = sql_num_rows( $result );
	while( $rs2 = sql_fetch_array($result)) {
		$cnt++;
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
		$mid	= $rs2['sys_userid'];
		$num	= $rs2['sys_pg'];
		$pg		= $rs2['sys_link'];
		$jong	= $rs2['tit_gubun'];
		$title_	= $rs2['sys_subtit'];
		$link_	= $rs2['sys_link'];
		$target_= 'solpa_user_r';
        $link_url_run = '';
		$blk="";
		if ( $rssys_level == "mroot" ) $blk=" ";
		else if ( $rssys_level == "sroot" ) $blk="    ";
		else if ( $rssys_level == "client" ) $blk="         ";
		$link_url_run  = $blk."<li><a onclick=\"javascript:submit_run( '$mid', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$xbook_num', '$pg', '$jong', '$title_', '$link_', '$target_','$rssys_level');\" target='frame' title='$pg, $rssys_memo'><font color='black'>".$rssys_subtit."</font></a>";
		if (( $i != 0 ) and ( $rssys_level == "client" )) { 
			for ( $fornum = 1; $fornum <= $i; $fornum++ ){
				fwrite( $fsr, "&nbsp;" );
			}
		} else if ( $rssys_level == "sroot" || $rssys_level == "mroot") {
			$i = 1;
		}
		if( $cnt == 1){
			fwrite( $fsr, $link_url_run ."  \r\n");
			if( $rs2['sys_cnt'] > 0 ) {
				   fwrite( $fsr, " \r\n" .  $blk. " <ul> \r\n"); 
			} else fwrite( $fsr, $blk. "</li>  \r\n"); 
		} else {
			fwrite( $fsr, $link_url_run ."  \r\n");
			if( $rs2['sys_cnt'] > 0 ) {
				   fwrite( $fsr, " \r\n" .  $blk. " <ul> \r\n"); 
			} else fwrite( $fsr, $blk. "</li>  \r\n"); 
		}
		if (( $rssys_menutit == "root" ) and ( $rssys_level != "mroot" )) {
			$rsr_submenu = $rssys_submenu;
				$level_root ='root';
				$row_num_root = $row_num;
				$root_on = 1;
			funcrs($rssys_submenu, 'root');
		}
	} // while
 	$i = $i - 1;
	if( $row_num > 0 and $cnt == $row_num ) {
		 if($rssys_level=='mroot' and $row_num > 1) fwrite( $fsr, $blk. " </ul> \r\n"); 
		 else if($rssys_level !=='mroot' ) fwrite( $fsr, $blk. " </ul> \r\n"); 
	}
	else if( $root_on and $row_num_root > 1 and $cnt == $row_num_root ) {
		 fwrite( $fsr, $blk. " ----- </ul> \r\n"); 
		 $level_root = '';
		 $row_num_root = 0;
		 $root_on = 0;
	}
}//end function
$sql_root = "SELECT * from {$tkher['sys_menu_bom_table']} where sys_pg = '$sys_pg' and sys_level <> 'client' order by sys_disno, sys_menu ";
$result = sql_query( $sql_root );
$row    = sql_num_rows($result);
	$intloop = 0;
	$i = 1;
while (( $rsr = sql_fetch_array($result) ) and ( $intloop < 2 )) {
	$rsrsys_menu    = $rsr['sys_menu'];
	$rsrsys_level	= $rsr['sys_level'];
	$rsrsys_cnt	    = $rsr['sys_cnt'];
	if ( $rsrsys_level == "mroot" ) {
		funcrs($rsrsys_menu, 'mroot');
	} else if ( $rsrsys_level == "sroot" ) {
		funcrs($rsrsys_menu, 'sroot');
	}
	$intloop = $intloop + 1;
}//loop 

fwrite($fsr,"     </ul> \r\n");
fwrite($fsr,"      \r\n");
fwrite($fsr,"      \r\n");
fwrite($fsr,"      \r\n");
fwrite($fsr,"</ul> \r\n");
fwrite($fsr,"</div> \r\n");
fwrite($fsr,"<iframe src='".KAPP_URL_T_."/menu/index.php?mid=$mid' title='url data' name='frame' width='100%' height='100%'></iframe>  \r\n");
fwrite($fsr,"  \r\n");
fwrite($fsr,"</body> \r\n");
fwrite($fsr,"</html> \r\n");

	include('../include/lib/pclzip.lib.php');
	$zf		= $sys_pg . '_menu.zip';
	$zf_url	= KAPP_URL_T_ . "/file/" . $mid . "/" . $zf;
	$zff	= KAPP_PATH_T_ . "/file/" . $mid . "/" . $zf;
	$zipfile = new PclZip($zff);
	$data	 = array();
	$list_run= $sys_pg . "_menu.html";
	$file_php= KAPP_PATH_T_ . "/file/" . $mid. "/" . $list_run;
	$file_url= KAPP_URL_T_ . "/file/" . $mid. "/" . $list_run;
	$data		= array( $file_php );
	$create	= $zipfile -> create($data, PCLZIP_OPT_REMOVE_ALL_PATH); 
	echo "<pre>";
	//var_dump($create);
?> 
	<h3> Created OK! menu_code:<?php echo $zff; ?> , Zip File:<?=$zf?></h3>
	<h3> <a href='<?=$zf_url?>' target=_blank>[ Download Action:<?=$zf?> ]</a></h3> 
<?php
	if ( $H_LEV > 1 ){
?>
			<h3><a href='<?=$file_url?>' target='_blank'>[ PopupMenu RUN:<?=$list_run?> ]</a> 
			</h3>
<?php } ?>
<p>The pointer has been decremented. Download the source code!</p>
</body>
</html>
