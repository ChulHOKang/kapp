<?php
	include_once('../tkher_start_necessary.php');

	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';

	if( strlen($H_ID) < 3 || $H_LEV < 2 ){
		m_("You need to login.");
		$url= KAPP_URL_T_;
		//echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	m_( $host_script . ", referer: ". $referer);	//dao, H_EMAIL: solpakan59@gmail.com
	connect_count($host_script, $H_ID, 0,$referer);	// log count

	$from_session_url = $_SERVER['HTTP_HOST'];

	//m_( $H_ID . ", H_EMAIL: ". $H_EMAIL);	//dao, H_EMAIL: solpakan59@gmail.com

	/*
		cratreebook_make_create_menu.php :
		call : index_create.php - call: index.php , index_create.php
		$first_linkurl = "../treelist_cranim_book.php";
		run.html My-List에 연결 2018-03-21   iframe
		$first_linkurl = "../cratree_my_list_menu.php?mid=$H_ID"; // only tree list.
		Source Code of Tree 를 생성하지 않는다. 
	*/
	$first_linkurl = KAPP_URL_T_ . "/menu/index.php?mid=$H_ID"; // only tree list.
	$first_linkurl_all = KAPP_URL_T_ . "/menu/index.php";

	$sys_pg     = $_POST['sys_pg'];
	$sys_subtit = $_POST['sys_subtit'];
	$sys_memo   = $_POST['sys_memo'];	// add 2018-03-26

	$gong_num   = '0';
	$target_run = $_POST['target_'];

	if( isset($_POST['bgcolor'])) $bgcolor   = $_POST['bgcolor'];
	else $bgcolor   = 'black';
	if( isset($_POST['fontcolor'])) $fontcolor = $_POST['fontcolor'];
	else $fontcolor = 'yellow';
	if( isset($_POST['fontface'])) $fontface  = $_POST['fontface'];
	else $fontface  = '';
	if( isset($_POST['fontsize'])) $fontsize  = $_POST['fontsize'];
	else $fontsize  = '15';

	$imgtype1	= 'folder.gif';  // $imgtype1	= 'img12_r.gif'; //$imgtype1 = $_POST['imgtype1'];
	$imgtype2	= 'folder1.gif'; // $imgtype2	= 'img11_l.gif'; //$imgtype2 = $_POST['imgtype2'];
	$imgtype3	= 'folder2.gif'; // $imgtype3	= 'img12.gif';   //$imgtype3 = $_POST['imgtype3'];

	$up_day = date("Y-m-d H:i:s",time());

	//$xclub_name = $sys_subtit;
	//m_("tit: ". $sys_subtit);	//tit: 초전도체FFG
	//================================================= add 2023-08-04
	$hostnameA = getenv('HTTP_HOST'); // 2023-08-03 add
	$tabData['data'][][] = array();   // 2023-08-03 add

if( isset($sys_pg) ) {	 //m_("sys_pg: $sys_pg");
	$syssql = "select sys_submenu from {$tkher['sys_menu_bom_table']} where sys_submenu = '$sys_pg' ";
	$rs = sql_query( $syssql);
	if( sql_num_rows($rs) > 0 ) {
		$rows = sql_fetch_array($rs);
		$submenu = $rows['sys_submenu'];
?>
			<script language=javascript>
				alert("This book code already exists.\n\nPlease write with a different book code name.");//이미 존재하는 book코드입니다.\n\n다른 book코드명으로 작성해 주십시오
				history.go(-1);
			</script>
<?php
	} else {
		$sys_userid		= $H_ID;	//$sys_pg;
		$sys_menu		= $sys_pg;
		$sys_submenu	= $sys_pg;
		$sys_rcnt		= 0;
		$sys_cnt		= 0;
		$sys_disno		= 0;
		$sys_level		= "mroot";
		$sys_menutit	= "mroot";
		$book_numR      = $sys_pg; //$H_ID . '_' . time(); //my_msg(" book_numR : $book_numR");
		$sys_link       = KAPP_URL_T_ . '/menu/contents_view_menuD.php?num=' . $book_numR;	// $rs['book_num'];//667
		$view_cnt  = 0;
		$view_lev  = '0';

		$sql = "insert into {$tkher['sys_menu_bom_table']} ( sys_comp, sys_userid, sys_pg, sys_menu, sys_submenu, sys_subtit,sys_link, sys_menutit, sys_memo, sys_level, sys_rcnt, sys_cnt, sys_disno, view_cnt, view_lev, tit_gubun, book_num, up_day ) values('$from_session_url', '$H_ID', '$sys_pg', '$sys_menu','$sys_submenu','$sys_subtit','$sys_link','$sys_menutit','$sys_memo','$sys_level',$sys_rcnt,$sys_cnt,$sys_disno,$view_cnt, '$view_lev', 'M', '$book_numR', '$up_day'  )";	//B->M
		$ret = sql_query( $sql );
		if( $ret ) {
			m_("sys_menu_bom OK sys_pg:" . $sys_pg . ", tit:" . $sys_subtit); //sys_menu_bom OK sys_pg:dao1710131650, tit:초전도체FFG
			//=======================
			sys_menu_bom_curl_send( $sys_pg );
			//=======================
			$diff		= '1';
			$align		= ''; //$content= $xclub_name;
			$BODYBGC	= '';
			$BODYBG		= '';
			$sql = "INSERT INTO {$tkher['webeditor_table']} SET num='$book_numR', user='$H_ID', id='book', h_lev='$view_lev', title='$sys_subtit' , diff='$diff', book_name='$sys_pg', content='$sys_subtit', date='$up_day' ";
			$returnValue = sql_query( $sql );
			if( !$returnValue ) {
				m_("Webeditor! insert error");
				//echo "<script>window.alert('DB ERROR.  Webeditor!!!');</script>";
				echo "sql: " . $sql; exit;
				//sql: INSERT INTO kapp_webeditor SET num='solpakan1715908554', user='solpakan@naver.com', id='book', h_lev='0', title='chatGPT4o' , diff='1', book_name='solpakan1715908554', content='chatGPT4o', date='2024-05-17 10:16:11'
				//sql: INSERT INTO webeditor SET num='dao1698741662', user='dao', id='book', h_lev='0', title='초전도체-LK99-D' , diff='1', book_name='dao1698741662', content='초전도체-LK99-D', date='2023-10-31 17:41:10'
			} else {
				//$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$H_ID;
				//insert_point_app( $H_ID, $config['kapp_write_point'], $rungo, 'sys_menu_bom', $H_ID, $sys_link);
			}

			$sql = "insert into {$tkher['menuskin_table']} set user_id='$H_ID', sys_pg='$sys_pg', sys_subtit='$sys_subtit', sys_link='$sys_link', bgcolor='$bgcolor', fontcolor='$fontcolor', fontface='$fontface', fontsize='$fontsize', imgtype1='$imgtype1', imgtype2='$imgtype2', imgtype3='$imgtype3', club_url='$from_session_url', up_day='$up_day'";
			$ret = sql_query( $sql );
			if( !$ret ) {
				echo "sql: " . $sql;
				m_(" ERROR menuskin insert - " );
				exit;
			}
			//source_html();
			$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$H_ID . '&num=' . $sys_pg. '&sys_jong=note';
			
		//	job_link( $rungo );  m_("job_link after menu tit: ".$sys_subtit. ", sys_pg:". $sys_pg);
		$job_group = 'menu'; 
		$jong='M';
		$chk = job_link_table_add( $sys_pg, $sys_subtit, $rungo, $sys_pg, $job_group, $sys_subtit, $jong );
		if( !$chk ) {
			m_("Curl job link table error");
			exit;
		}

			insert_point_app( $H_ID, $config['kapp_write_point'], $rungo, 'sys_menu_bom@cratree_book_make_menu', $sys_pg, $sys_subtit, $sys_pg);
			echo "<script> window.open('$rungo', '_top', ''); </script>";
		} else {
			echo "sql: " . $sql;
			m_("sys_menu_bom ERROR sys_pg:" . $sys_pg . ", tit:" . $sys_subtit); //sys_menu_bom ERROR sys_pg:dao1698737334, tit:초전도체-LK99
			//sys_menu_bom ERROR sys_pg:dao1698739745, tit:초전도체-LK99-A
			exit;
		}


	} // ( sql_num_rows($rs) > 0 )
} else {	/////메뉴코드가 입력되지 않았을 경우
?>
	<p><p><center>insert error( K-Tree admin_treebom_new )!!!. </center>
<?php
}
?>
</body>
</html>

<?php

function job_link( $url_ ){
	global $H_ID, $H_EMAIL, $sys_pg, $sys_subtit, $sys_link, $view_lev, $from_session_url, $up_day, $ip;
	global $tkher;
		/*$ret = sql_query( "insert into {$tkher['job_link_table']} set user_id='$H_ID', email='$H_EMAIL', job_name='$sys_subtit', user_name='$sys_subtit', job_addr='$sys_link', up_day='$up_day', jong='M', job_group='menu', num='$sys_pg', aboard_no='$sys_pg', club_url='$from_session_url', job_level='$view_lev', ip='$ip' " );
		if( !$ret ) {
			m_(" job_link_table insert error");
		} else {
			m_(" job_link_table insert ok");
		}*/
		$job_group = 'menu'; 
		$jong='M';
		$chk = job_link_table_add( $sys_pg, $sys_subtit, $url_, $sys_pg, $job_group, $sys_subtit, $jong );
		if( !$chk ) {
			m_("Curl job link table error");
			exit;
		}

}

/*
	source_html()
	$sys_pg + _r1.htm, _r2.htm, _insf.html, _updf.html, _runf.html, _ins.html, _upd.html, _run.html
*/

function source_html(){
	global $H_ID, $sys_pg, $book_numR, $first_linkurl_all, $sys_subtit, $sys_link;
	global $bgcolor, $fontcolor, $fontface, $fontsize;

	$target_= 'solpa_user_r';

		$jtree_dir = "./".$H_ID;
		if( !is_dir($jtree_dir) ) {
			if( !@mkdir( $jtree_dir, 0777 ) ) {
				echo " Error : ".$H_ID." Failed to create directory.";//디렉토리를 생성하지 못했습니다.
				exit;
			}
		}
		$xxfile = "./" . $H_ID ."/". $sys_pg . "_r1.htm";
		$ft = fopen("$xxfile","w+");

		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE>  \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ ."/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		 fwrite($ft,"</head> \r\n");

		 fwrite($ft,"<frameset rows=\"5%, 95%\" cols=\"1*\" border='0'> \r\n");
		 //fwrite($ft,"	 <frame src='".$sys_pg."_r2.htm' name=selhead scrolling=no > \r\n");
		 $app_r2 = KAPP_URL_T_ . '/menu/pg_r2_menu.php?mid=' . $H_ID . '&pg=' . $sys_pg. '&type=B';
		 fwrite($ft,"	 <frame src='" . $app_r2 . "' name='selhead'  scrolling='no' > \r\n");
		 fwrite($ft,"    <frame src='". $sys_pg ."_runf.html' name='solpa_user_r_bottom' > \r\n");
		 fwrite($ft,"</frameset> \r\n");

		 fwrite($ft,"</frameset> \r\n");
		 fwrite($ft,"</html>\r\n");
		 fwrite($ft,"\r\n");
		 fclose($ft);
		////////////////////////////////////< top frame end >////

		////////////////////////////////////< top menu >//////

		$xxfile = "./" . $H_ID ."/". $sys_pg . "_r2.htm";
		$ft = fopen("$xxfile","w+");

		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE>  \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ ."/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		fwrite($ft,"<link href='". KAPP_URL_T_ ."/include/css/style1.css' rel='stylesheet' type='text/css'>\r\n");
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
		 fwrite($ft,"<td class='def' width='100' height='20' onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor='green' bgcolor='#000000' align='center' width='79'><a href='./".$sys_pg."_insf.html' target='solpa_user_r_bottom'> Note Add </a></td>\r\n");
		 fwrite($ft,"<td class=def width='100' height='20' onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor=green bgcolor=#000000 align=center width=79><a href=\"".$sys_pg."_updf.html\" target='solpa_user_r_bottom'> UPDATE </a></td>\r\n");
		 fwrite($ft,"<td class=def width='100' height='20' onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor=green bgcolor=#000000 align=center width=79><a href='".$sys_pg."_runf.html' target='solpa_user_r_bottom'> RUN </a></td>\r\n");

		 fwrite($ft,"<td class='def' width='120' height='20' onmouseover=\"this.className='bord'\" onmouseout=\"this.className='def'\" onmousedown=\"this.className='bordout'\" onmouseup=\"this.className='def'\" bordercolor='green' bgcolor='#000000' align='center' width='79'><a href='". KAPP_URL_T_ ."/menu/tree_remake_book_menu.php?mid=$H_ID&make_type=newcratree_book&sys_pg=".$sys_pg."&book_num=".$book_numR."' target='solpa_user_r'>Design change</a></td>\r\n");

		 fwrite($ft,"</body>\r\n");
		 fwrite($ft,"</html>\r\n");
		 fclose($ft);
		////////////////////////////////////< top menu end >//////////

		////////////////////////////////////< 하위 프레임 파일(등록) >////////
		$xxfile = "./" . $H_ID ."/". $sys_pg . "_insf.html";
		$ft = fopen("$xxfile","w+");

		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE>  \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ ."/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		fwrite($ft,"</head> \r\n");
		fwrite($ft,"<frameset cols='18%,82%' border='0'>\r\n");
		fwrite($ft,"<frame src='".$sys_pg."_ins.html' name='main' scrolling='auto' frameborder='0' >\r\n");
		// 변경만 같이 사용한다. treebom_udate2_new 등록은 링크 정보가 다르기 때문이다......
		// 다중등록은 : 링크 트리 와 링크 트리 북 2개만 같이 사용 treebom_insert2_new.php를 사용.:2018-04-07 : job_link_table처리시 확인.
		fwrite($ft,"<frame src='". KAPP_URL_T_ ."/menu/treebom_insert2_book_menu.php?mode=mroot&make_type=newcratree_book&sys_pg_root=".$sys_pg."&data=".$sys_pg."&data1=".$sys_pg."' name=\"solpa_user_r\" frameborder='no'>\r\n");

		fwrite($ft,"</frameset> \r\n");
		fwrite($ft,"</html> \r\n");
		fclose($ft);
		////////////////////////////////////< 하위 프레임 파일(등록) 끝 >////////

		////////////////////////////////////< 하위 프레임 파일(변경) >///////
		$xxfile = "./" . $H_ID ."/". $sys_pg . "_updf.html";

		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE>  \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ ."/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		fwrite($ft,"</head> \r\n");
		fwrite($ft,"<frameset cols='18%,82%' border='0'>\r\n");
		fwrite($ft,"<frame src=\"".$sys_pg."_upd.html\" name=main scrolling='auto' frameborder='0' >\r\n");

		// 변경만 링크트리, 링크북,링크게시판 모두 같이 사용한다. treebom_udate2_new 등록은 링크 정보가 다르기 때문이다......
		fwrite($ft,"<frame src='" . KAPP_URL_T_ . "/menu/treebom_update2_new_menu.php?mode=mroot&m_type=booktreeupdate&make_type=newcratree_book&sys_pg_root=".$sys_pg."&data=".$sys_pg."&data1=".$sys_pg."' name=\"solpa_user_r\" frameborder='no'>\r\n");

		fwrite($ft,"</frameset> \r\n");
		fwrite($ft,"</html> \r\n");
		fclose($ft);
		////////////////////////////////////< 하위 프레임 파일(변경) 끝 >//////

		////////////////////////////////////< 하위 프레임 파일(실행) >///////
		$xxfile = "./" . $H_ID ."/". $sys_pg . "_runf.html";

		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>Tkher system for special her. Tkher system is generator program. Made in ChulHo Kang</TITLE>\r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ ."/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		fwrite($ft,"</head> \r\n");
		fwrite($ft,"<frameset cols='25%,75%' border='0'>\r\n");
		fwrite($ft,"<frame src='".$sys_pg."_run.html' name='main' scrolling='auto' frameborder='0' >  \r\n");
		fwrite($ft,"<frame src='" . $first_linkurl_all . "' name='solpa_user_r' frameborder='no'>  \r\n");

		fwrite($ft,"</frameset> \r\n");
		fwrite($ft,"</html>     \r\n");
		fclose($ft);

		//////////////
		//////< 하위 프레임 파일(실행) 끝 >//////////////

		/////////< insert file >////////////////////////
		$xxfile = "./" . $H_ID ."/". $sys_pg . "_ins.html";

		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE>  \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ . "/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		fwrite($ft,"<script language=\"javascript\">\r\n");
		fwrite($ft,"<!--\r\n");
		fwrite($ft,"function clickHandler() { \r\n");
		fwrite($ft,"	var  targetId, srcElement,  targetElement; \r\n");
		fwrite($ft,"	srcElement = window.event.srcElement; \r\n");
		fwrite($ft,"	if (srcElement.className == \"solpa_tree\") { \r\n");
		fwrite($ft,"		targetId = srcElement.id + \"d\"; \r\n");
		fwrite($ft,"		targetElement = document.all( targetId); \r\n");
		fwrite($ft,"		if ( targetElement.style.display == \"none\") { \r\n");
		fwrite($ft,"			targetElement.style.display = \"\"; \r\n");
		fwrite($ft,"			srcElement.src = \"folder2.gif\"; \r\n");
		fwrite($ft,"		} else { \r\n");
		fwrite($ft,"			targetElement.style.display = \"none\"; \r\n");
		fwrite($ft,"			srcElement.src = \"folder1.gif\"; \r\n");
		fwrite($ft,"		} \r\n");
		fwrite($ft,"	} \r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"document.onclick = clickHandler; \r\n");
		fwrite($ft,"//-->\r\n");
		fwrite($ft,"</script>\r\n");
		fwrite($ft,"<link href='". KAPP_URL_T_ . "/include/css/style1.css' rel='stylesheet' type='text/css'>\r\n");
		fwrite($ft,"<style type=\"text/css\">\r\n");
		fwrite($ft,"body, td, div, a {font-size:".$fontsize."pt;font-faily:".$fontface.";}\r\n");
		fwrite($ft,"a:link {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:visited {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:active {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:hover {color:#01ff01; text-decoration:none}\r\n");
		fwrite($ft,"body, td {\r\n");
		fwrite($ft,"scrollbar-face-color: #3399ff; \r\n");
		fwrite($ft,"scrollbar-shadow-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-highlight-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-3dlight-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-darkshadow-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-track-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-arrow-color: #99ccff;\r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"</style>\r\n");
		fwrite($ft,"</head>\r\n");
		fwrite($ft,"<body bgcolor=".$bgcolor.">\r\n");
		fwrite($ft,"<table border='0' width=\"300\">\r\n");
		fwrite($ft,"<tr>\r\n");
		fwrite($ft,"<td>\r\n");

		fwrite($ft,"<img src='" . KAPP_URL_T_ ."/icon/".$imgtype3."'>\r\n");
		fwrite($ft,"<a href='". KAPP_URL_T_ ."/menu/treebom_insert2_book_menu.php?mode=mroot&make_type=newcratree_book&sys_pg_root=".$sys_pg."&data=".$sys_pg."&data1=".$sys_pg."'  target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize'>".$sys_subtit."</a>\r\n");
		fwrite($ft,"</div>   \r\n");
		fwrite($ft,"</td>    \r\n");
		fwrite($ft,"</tr>    \r\n");
		fwrite($ft,"</table> \r\n");
		fwrite($ft,"</body>   \r\n");
		fwrite($ft,"</html>   \r\n");
		fclose($ft);
		  ////////////////////////< insert file end >////

		  ///////////////////////< update file >///////
		$xxfile = "./" . $H_ID ."/". $sys_pg . "_upd.html";

		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE>  \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ . "/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		fwrite($ft,"<script language=\"javascript\">\r\n");
		fwrite($ft,"<!--\r\n");
		fwrite($ft,"function clickHandler() { \r\n");
		fwrite($ft,"	var  targetId, srcElement,  targetElement; \r\n");
		fwrite($ft,"	srcElement = window.event.srcElement; \r\n");
		fwrite($ft,"	if (srcElement.className == \"solpa_tree\") { \r\n");
		fwrite($ft,"		targetId = srcElement.id + \"d\"; \r\n");
		fwrite($ft,"		targetElement = document.all( targetId); \r\n");
		fwrite($ft,"		if ( targetElement.style.display == \"none\") { \r\n");
		fwrite($ft,"			targetElement.style.display = \"\"; \r\n");
		fwrite($ft,"			srcElement.src = \"folder2.gif\"; \r\n");
		fwrite($ft,"		} else { \r\n");
		fwrite($ft,"			targetElement.style.display = \"none\"; \r\n");
		fwrite($ft,"			srcElement.src = \"folder1.gif\"; \r\n");
		fwrite($ft,"		} \r\n");
		fwrite($ft,"	} \r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"document.onclick = clickHandler; \r\n");
		fwrite($ft,"//-->\r\n");
		fwrite($ft,"</script>\r\n");
		fwrite($ft,"<link href='" . KAPP_URL_T_ . "/include/css/style1.css' rel='stylesheet' type='text/css'>\r\n");
		fwrite($ft,"<style type=\"text/css\">\r\n");
		fwrite($ft,"body, td, div, a {font-size:".$fontsize."pt;font-faily:".$fontface.";}\r\n");
		fwrite($ft,"a:link {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:visited {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:active {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:hover {color:#01ff01; text-decoration:none}\r\n");
		fwrite($ft,"body, td {\r\n");
		fwrite($ft,"scrollbar-face-color: #3399ff; \r\n");
		fwrite($ft,"scrollbar-shadow-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-highlight-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-3dlight-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-darkshadow-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-track-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-arrow-color: #99ccff;\r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"</style>\r\n");
		fwrite($ft,"</head>\r\n");

		fwrite($ft,"<body bgcolor='".$bgcolor."'>     \r\n");
		fwrite($ft,"  <table border='0' width='300'>  \r\n");
		fwrite($ft,"	<tr>\r\n");
		fwrite($ft,"	  <td>\r\n");
		fwrite($ft,"		<img src='" . KAPP_URL_T_ . "/icon/".$imgtype3."'>  \r\n");
		fwrite($ft,"		<a href='" . KAPP_URL_T_ . "/menu/treebom_update2_book_menu.php?make_type=newcratree_book&m_type=booktreeupdate&sys_pg_root=".$sys_pg."&data=".$sys_pg."&data1=".$sys_pg."'  target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize'>".$sys_subtit."</a><br>\r\n");
		fwrite($ft,"</div>\r\n");
		fwrite($ft,"	  </td>\r\n");
		fwrite($ft,"	</tr>\r\n");
		fwrite($ft,"  </table>\r\n");
		fwrite($ft,"</body>\r\n");
		fwrite($ft,"</html>\r\n");
		fclose($ft);
		  ///////////////////////< update file end >//////

		///////////////////////< run file >//////////
		$xxfile = "./" . $H_ID ."/". $sys_pg . "_run.html";

		$ft = fopen("$xxfile","w+");
		fwrite($ft,"<html> \r\n");
		fwrite($ft,"<head> \r\n");
		fwrite($ft,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
		fwrite($ft,"<TITLE>solpakan89@gmail.com - Made in ChulHo Kang</TITLE>  \r\n");
		fwrite($ft,"<link rel='shortcut icon' href='". KAPP_URL_T_ . "/logo/logo25a.jpg'> \r\n");

		fwrite($ft,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
		fwrite($ft,"<meta name='keywords' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
		fwrite($ft,"<meta name='description' content='web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
		fwrite($ft,"<meta name='robots' content='ALL'> \r\n");

		fwrite($ft,"<script language=\"javascript\">\r\n");
		fwrite($ft,"<!--\r\n");
		fwrite($ft,"function clickHandler() { \r\n");
		fwrite($ft,"	var  targetId, srcElement,  targetElement; \r\n");
		fwrite($ft,"	srcElement = window.event.srcElement; \r\n");
		fwrite($ft,"	if (srcElement.className == \"solpa_tree\") { \r\n");
		fwrite($ft,"		targetId = srcElement.id + \"d\"; \r\n");
		fwrite($ft,"		targetElement = document.all( targetId); \r\n");
		fwrite($ft,"		if ( targetElement.style.display == \"none\") { \r\n");
		fwrite($ft,"			targetElement.style.display = \"\"; \r\n");
		fwrite($ft,"			srcElement.src = \"folder2.gif\"; \r\n");
		fwrite($ft,"		} else { \r\n");
		fwrite($ft,"			targetElement.style.display = \"none\"; \r\n");
		fwrite($ft,"			srcElement.src = \"folder1.gif\"; \r\n");
		fwrite($ft,"		} \r\n");
		fwrite($ft,"	} \r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"document.onclick = clickHandler; \r\n");

		//------ add 2018-06-23 1:submit_run ----------------------------
		fwrite($ft,"	function submit_run( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_) {  \r\n");
		fwrite($ft,"			document.click_run.mid.value=mid; \r\n");
		fwrite($ft,"	   		document.click_run.sys_pg.value=sys_pg; \r\n");
		fwrite($ft,"			document.click_run.sys_menu.value=sys_menu;   \r\n");
		fwrite($ft,"			document.click_run.sys_submenu.value=sys_submenu;   \r\n");
		fwrite($ft,"			document.click_run.num.value=num;   \r\n");
		fwrite($ft,"			document.click_run.pg.value=pg;   \r\n");
		fwrite($ft,"	 		document.click_run.jong.value=jong;  \r\n");
		fwrite($ft,"			document.click_run.title_.value=title_;   \r\n");
		fwrite($ft,"			document.click_run.link_.value=link_;   \r\n");

		fwrite($ft,"			if (pg.indexOf( 'https:')>=0 ) \r\n");
		fwrite($ft,"			{ \r\n");
		fwrite($ft,"					document.click_run.target='_blank';  \r\n");
		fwrite($ft,"					document.click_run.target_.value='_top'; \r\n");
		fwrite($ft,"					document.click_run.action= '" . KAPP_URL_T_ ."/menu/cratree_coinadd_menu.php';     \r\n");
		fwrite($ft,"					document.click_run.submit();     \r\n");
		fwrite($ft,"			} else { \r\n");
		fwrite($ft,"					document.click_run.target=target_;   // add  \r\n");
		fwrite($ft,"					document.click_run.target_.value=target_;     \r\n");
		fwrite($ft,"					document.click_run.action= '" . KAPP_URL_T_ . "/menu/cratree_coinadd_menu.php';     \r\n");
		fwrite($ft,"					document.click_run.submit();     \r\n");
		fwrite($ft,"			} \r\n");
		fwrite($ft,"	}   \r\n");

		fwrite($ft,"//-->\r\n");
		fwrite($ft,"</script>\r\n");
		fwrite($ft,"<link href='". KAPP_URL_T_ . "/include/css/style1.css' rel='stylesheet' type='text/css'>  \r\n");
		fwrite($ft,"<style type=\"text/css\"> \r\n");
		fwrite($ft,"body, td, div, a {font-size:".$fontsize."pt;font-faily:".$fontface.";}\r\n");
		fwrite($ft,"a:link {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:visited {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:active {color:".$fontcolor."; text-decoration:none}\r\n");
		fwrite($ft,"a:hover {color:#01ff01; text-decoration:none}\r\n");
		fwrite($ft,"body, td {\r\n");
		fwrite($ft,"scrollbar-face-color: #3399ff; \r\n");
		fwrite($ft,"scrollbar-shadow-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-highlight-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-3dlight-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-darkshadow-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-track-color: #99ccff; \r\n");
		fwrite($ft,"scrollbar-arrow-color: #99ccff;\r\n");
		fwrite($ft,"}\r\n");
		fwrite($ft,"</style>\r\n");
		fwrite($ft,"</head>\r\n");

		fwrite($ft,"<body bgcolor=".$bgcolor.">  \r\n");
		//------ add 2018-06-23 https submit_run cratree_coinadd.php ----------------------
		fwrite($ft,"	<form name='click_run' action='' method='' enctype='multipart/form-data' target='url_link_tree_solpa_user_r'> \r\n");
		fwrite($ft,"	<input type=hidden name='mid' > \r\n");
		fwrite($ft,"	<input type=hidden name='num' > \r\n");
		fwrite($ft,"	<input type=hidden name='sys_pg' > \r\n");
		fwrite($ft,"	<input type=hidden name='sys_menu' > \r\n");
		fwrite($ft,"	<input type=hidden name='sys_submenu' > \r\n");
		fwrite($ft,"	<input type=hidden name='pg' > \r\n");
		fwrite($ft,"	<input type=hidden name='jong' > \r\n");
		fwrite($ft,"	<input type=hidden name='title_' > \r\n");
		fwrite($ft,"	<input type=hidden name='link_' > \r\n");
		fwrite($ft,"	<input type=hidden name='target_' > \r\n");
		fwrite($ft,"	\r\n");
		fwrite($ft,"	\r\n");
		//------------------------------------- end

		fwrite($ft,"<table border='0' >\r\n");
		//cratreebook_make_menu.php -> cratreebook_make_create_menu.php 2023-12-28
		fwrite($ft,"   <a href='". KAPP_URL_T_. "/menu/cratreebook_make_create_menu.php' id='".$sys_pg."' class='solpa_tree_main' target='solpa_user_r'><img src='". KAPP_URL_T_ ."/logo/crasin_tm.jpg' id=". $sys_pg." class='solpa_tree_main' style='cursor: hand' align='absmiddle' ></a><br> \r\n");
		fwrite($ft,"<tr> \r\n");
		fwrite($ft,"<td> \r\n");
		fwrite($ft,"          <tr> \r\n");
		fwrite($ft,"            <td colspan=2 bgcolor='".$fontcolor."' height='1'></td> \r\n");
		fwrite($ft,"          </tr> \r\n");
		fwrite($ft,"          <tr> \r\n");
		fwrite($ft,"             <td height=15 align=left><font color=".$fontcolor."><a href='" . $first_linkurl . "' target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize'><img src='". KAPP_URL_T_ ."/logo/pizza.png' width='20' height='15'> My-List </a></td>\r\n");

		fwrite($ft,"          </tr> \r\n");
		fwrite($ft,"          <tr> \r\n");
		fwrite($ft,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
		fwrite($ft,"          </tr> \r\n");
		fwrite($ft,"</td> \r\n");
		fwrite($ft,"</tr> \r\n");
		//---- add 2018-06-25 https 처리 submit_run cratree_coinadd.php -
		$mid	= $H_ID;			//$rs2['sys_userid'];
		$num	= $sys_pg;			//$rs2['sys_pg'];
		$pg		= $sys_link;		//$rs2['sys_link'];
		$jong	= 'B';				//$rs2['tit_gubun'];
		$title_	= $sys_subtit;		//$rs2['sys_subtit'];
		$link_	= $sys_link;		//$rs2['sys_link'];

		fwrite($ft,"<tr>\r\n");
		fwrite($ft,"<td>\r\n");
//		fwrite($ft,"<img src='/cratree/skins_treeicon/as00/".$imgtype3."'>\r\n");
		fwrite($ft,"<img src='" . KAPP_URL_T_ . "/include/icon/" . $imgtype3."'>\r\n"); //<" ."?=KAPP_URL_T_?".">

		fwrite($ft,"<a href='" . KAPP_URL_T_ . "/menu/contents_view_menuD.php?num=" . $book_numR . "' onclick=\"javascript:submit_run( '$H_ID', '$sys_pg', '$rssys_menu', '$rssys_submenu', '$num', '$pg', '$jong', '$title_', '$link_', '$target_');\" target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize'>".$sys_subtit."</a><br>\r\n");
		fwrite($ft,"</div>\r\n");
		fwrite($ft,"</td>\r\n");
		fwrite($ft,"</tr>\r\n");

		fwrite($ft,"<td> \r\n");
		fwrite($ft,"          <tr> \r\n");
		fwrite($ft,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
		fwrite($ft,"          </tr> \r\n");
		fwrite($ft,"          <tr> \r\n");
		fwrite($ft,"            <td height='15' align='center'><font color=".$fontcolor."><a href='". KAPP_URL_T_ ."/menu/my_editor2_book_insert_menu.php?book_num=$sys_pg' id='$sys_pg' class='solpa_tree_main' target='solpa_user_r' style='color:$fontcolor;font-size:$fontsize'><font color=cyan><strong><img src='".KAPP_URL_T_."/logo/pizza.png' width='20' height='15'> Add </strong></a></td> \r\n");
		fwrite($ft,"          </tr> \r\n");
		fwrite($ft,"          <tr> \r\n");
		fwrite($ft,"            <td colspan='2' bgcolor='".$fontcolor."' height='1'></td> \r\n");
		fwrite($ft,"          </tr> \r\n");
		fwrite($ft,"</td> \r\n");

		fwrite($ft,"</table>\r\n");
		fwrite($ft,"</body>\r\n");
		fwrite($ft,"</html>\r\n");
		fclose($ft);

		m_("html create ok!");
}

function sys_menu_bom_curl_send( $sys_pg ){

	global $tabData, $H_ID, $H_EMAIL, $hostnameA;
	global $sys_subtit, $sys_memo;
	global $imgtype1, $imgtype2, $imgtype3, $bgcolor, $fontcolor, $fontface, $fontsize, $hostnameA;

		$sys_userid		= $H_ID;	//$sys_pg;
		$sys_menu		= $sys_pg;
		$sys_submenu	= $sys_pg;
		$sys_rcnt		= 0;
		$sys_cnt		= 0;
		$sys_disno		= 0;
		$sys_level		= "mroot";
		$sys_menutit	= "mroot"; // $sys_link       = 'contents_view_menuD.php?num=' . $book_numR;	//$rs['book_num'];//667
		$sys_link       = KAPP_URL_T_ . '/menu/contents_view_menuD.php?num=' . $book_numR;	// $rs['book_num'];//667
		$view_lev  = '0';

	$cnt = 0;
	$tabData['data'][$cnt]['sys_pg']      = $sys_pg;
	$tabData['data'][$cnt]['sys_subtit']  = $sys_subtit;
	$tabData['data'][$cnt]['sys_memo']    = $sys_memo;
	$tabData['data'][$cnt]['sys_menu']    = $sys_pg;
	$tabData['data'][$cnt]['sys_submenu'] = $sys_pg;
	$tabData['data'][$cnt]['sys_link']    = $sys_link;
	$tabData['data'][$cnt]['sys_level']   = "mroot";
	$tabData['data'][$cnt]['sys_menutit'] = "mroot";

	$tabData['data'][$cnt]['sys_rcnt']    = 0;
	$tabData['data'][$cnt]['sys_cnt']     = 0;
	$tabData['data'][$cnt]['sys_disno']   = 0;

	$tabData['data'][$cnt]['view_cnt']	  = 0;
	$tabData['data'][$cnt]['view_lev']    = '0';
	$tabData['data'][$cnt]['tit_gubun']   = 'M';
	$tabData['data'][$cnt]['book_num']    = $sys_pg;

	$tabData['data'][$cnt]['bgcolor']     = $bgcolor;
	$tabData['data'][$cnt]['fontcolor']   = $fontcolor;
	$tabData['data'][$cnt]['fontface']    = $fontface;
	$tabData['data'][$cnt]['fontsize']    = $fontsize;

	$tabData['data'][$cnt]['imgtype1']    = $imgtype1;
	$tabData['data'][$cnt]['imgtype2']    = $imgtype2;
	$tabData['data'][$cnt]['imgtype3']    = $imgtype3;

	$tabData['data'][$cnt]['host']       = $hostnameA;
	$tabData['data'][$cnt]['sys_userid'] = $H_ID;
	$tabData['data'][$cnt]['email']      = $H_EMAIL;

	//$count = count($tabData['data']);	//m_( "--- count:" . $count ); // 10

	$key = 'appgenerator';
    $iv = "~`!@#$%^&*()-_=+";

    $sendData = encryptA( $tabData , $key, $iv);

    //$url_ = 'https://ailinkapp.com/onlyshop/coupon/sys_menu_bom_curl_get_ailinkapp.php'; // 전송할 대상 URL
    $url_ = 'https://ailinkapp.com/kapp/_Curl/sys_menu_bom_curl_get_ailinkapp.php'; // 전송할 대상 URL

    //$curl = curl_init( $url_ );
	$curl = curl_init();
	curl_setopt( $curl, CURLOPT_URL, $url_);
    curl_setopt( $curl, CURLOPT_POST, true);

    curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
        'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
        'iv' => $iv
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	echo curl_error($curl);	//echo "curl --- response: " . $response;

	if( $response == false) {
        $_ms = "cratreebook_make_create_menu curl 전송 실패 : " . curl_error($curl);
		echo 'curl 전송 실패 : ' . curl_error($curl);
		//m_(" ------------ : " . $_ms);
    } else {
        $_ms = 'cratreebook_make_create_menu curl 응답 : ' . $response;
		//echo 'curl 응답 : ' . $response;
		m_(" ============ :" . $_ms);
    }
	// ============ :table30m curl 응답 : --- count:10Error: Update failed{"message":"_api table data 전달 완료"}
    curl_close($curl);	
	//m_( $sys_pg .", curl end----------- ms: email: " . $H_EMAIL); //exit();
	//dao1710131650, curl end----------- ms: email: solpakan59@gmail.com
}

?>