<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$H_EMAIL   = $member['mb_email'];

	if (!$H_ID) {
		my_msg("login please! ");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	/* --------------------------------------------------------
		treebom_insw_book_menu.php - tree menu record insert
		sys_file->sys_board_num 로 Table 변경 2023-11-28
		CURL 작업 추가 : 2023-08-09 - /t/tree_menu_guest.php ->treebom_insert2_book_menu.php->treebom_insw_book_menu.php
		call : treebom_insert2_book_menu.php -> /t/tree_menu_guest.php 에서 도 사용함. 중요.
		run : treebom_insw_book_menu.php -> tree_create_menu.php: Record 다중 등록.
		- main call pg : tree_menu_updateM2.php 추가: 2021-05-30
		                             - make_type: booktreeupdateM
    treebom_insw_book_menu : Bulletin board table creation failed.  1, solpakan@naver.com1713422425 
	--------------------------------------------------------- */
	$data  = $_POST['data'];
	$data1 = $_POST['data1'];
	$target_my  = $_POST['target_my'];
	$mid		= $_POST['mid'];
	$mode		= $_POST['mode'];
	$sys_cnt	= $_POST['sys_cnt'];
	$make_type	= $_POST['make_type'];
	$gtit		= $_POST['gtit'];
	$view_lev	= $_POST['view_lev'];
	$sys_pg_root= $_POST['sys_pg_root'];
	$xroot_level= $_POST['xroot_level']; // 2021-12-09 root의 top line에 등록을 하는지 체크용.
	$sql="select * from {$tkher['sys_menu_bom_table']} where sys_pg ='$sys_pg_root' and sys_submenu = '$sys_pg_root' and sys_level='mroot'";
	$result = sql_query( $sql);
	$rs  = sql_fetch_array($result);
	$mid = $rs['sys_userid'];
	$sys_rcnt    = $rs['sys_rcnt'];
	$sys_submenuR = $rs['sys_submenu'];
	$up_day = date("Y-m-d H:i:s");

	if ( $H_ID !== $mid ) {
		my_msg("You do not have permission to work.");// 작업권한이 없습니다.  : no maker  member!
		$rungo = "./" . $rs['sys_userid'] . "/". $sys_pg_root . "_runf.html";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
		$j=0;
		$isys_subtit = 'sys_subtit_'.$j;
		$sys_subtit = $_POST['$isys_subtit'];
	for ( $intloop = 0; $sys_subtit !== ""; $intloop++ ){
		$isys_subtit = "sys_subtit_" . $intloop;
		$sys_subtit	= $_POST[$isys_subtit];
		$len = strlen($sys_subtit);
	}
	$xroot_cnt = $intloop;
 if( $xroot_cnt > 0 ) {
	$xsys_pg = $sys_pg_root;
	if( $mode == 'mroot')
		 $ret_root_chk = 1;
	else $ret_root_chk = 0;
?>
		<table border='1' >
		<tr>
			<th> Title </th>
			<th> UrlLink </th>
		</tr>
<?php
	$from_session_url = $_SERVER['HTTP_HOST'];
	$ins_data=0;

	$board_num = 0; // infor: aboard_table_make_menu( $board_title, $mroot, $board_type, $max_num ) 여기에서 infor을 생성한다.

	for ( $intloop = 0; $intloop <= 13; $intloop++ ){
		$isys_subtit = "sys_subtit_" . $intloop;
		$sys_subtit	= $_POST[$isys_subtit];
		if ( strlen($sys_subtit) > 0 ) {
			$isys_menu	 = "sys_menu_" . $intloop;
			$isys_submenu= "sys_submenu_" . $intloop;
			$isys_subtit = "sys_subtit_" . $intloop;
			$isys_link	 = "sys_link_" . $intloop;
			$isys_memo	 = "sys_memo_" . $intloop;
			$imax_num	 = "max_num_" . $intloop;
			$sys_disno	 = $sys_rcnt + $intloop;
			$isys_jong	 = "jong_" . $intloop;
			$sys_menu		= $_POST[$isys_menu];
			$sys_submenu	= $_POST[$isys_submenu];
			$sys_subtit		= $_POST[$isys_subtit];
			$sys_jong		= $_POST[$isys_jong];
			$sys_link		= $_POST[$isys_link];
			$sys_memo		= $_POST[$isys_memo];
			$max_num		= $_POST[$imax_num]; // $max_num = $H_ID . (time() + $j);	//$max_num - 중요 : 게시판 테이블명으로 사용됨.
			$root_cnt = 0;
			if( $mode == 'mroot' ) {
				$root_chk = "sroot";
			} else {
				$root_chk = "client";
			}
			echo "<tr><td>".$sys_subtit."</td>";
			echo "<td>".$sys_link."</td></tr>";
			$url_ = iconv_substr( $sys_link, 0, 46, "utf-8");
			if( $sys_jong == "link"){
				$gubun = 'T';
			} else if( $sys_jong == "note"){
				$sys_link = KAPP_URL_T_ . "/menu/" . $sys_link; // 2024-01-19
				$gubun = 'N'; // B-> N : Note - 2024-01-19
				$sqlX= "INSERT INTO {$tkher['webeditor_table']} SET num='$max_num', h_lev='$view_lev', user='$H_ID', id='book', title='$sys_subtit', diff='1', book_name='$sys_pg_root', content='$sys_subtit'";
				$ret = sql_query(  $sqlX );
				if( !$ret ){
					echo "treebom_insw_book_menu : ERROR sys_jong: ". $sys_jong. ", sqlX: " . $sqlX; exit;
				}
			} else if( $sys_jong == "board"){
				$gubun = 'A';
				$board_title = $sys_subtit;
				$board_type='5'; // '5':Daum type, '2' :standard
				$link_ret = aboard_table_make_menu( $board_title, $sys_pg_root, $board_type, $max_num );//$max_num-중요:게시판 테이블명으로 사용됨.
				$sys_link = KAPP_URL_T_ . "/menu/" . $link_ret; // 2024-04-26
			} else if( $sys_jong == "photo"){ // 사진 앨범.
				$gubun = 'A';
				$board_title = $sys_subtit;
				$board_type='4'; // '4':photo type, '2' :standard
				$link_ret = aboard_table_make_menu( $board_title, $sys_pg_root, $board_type, $max_num );
				$sys_link = KAPP_URL_T_ . "/menu/" . $link_ret; // 2024-04-26
			} else {
					$gubun = 'T';
					echo "treebom_insw_book_menu : ERROR : link type - sys_jong: ". $sys_jong;
					exit;
			}
			//m_("board_num: " . $board_num); // board_num: 259 , sys_file->sys_board_num 로 Table 변경 2023-11-28
			$sqlB = "INSERT INTO {$tkher['sys_menu_bom_table']} SET sys_comp='$from_session_url', sys_userid='$H_ID', sys_pg='$sys_pg_root', sys_menu='$sys_menu', sys_submenu='$sys_submenu', sys_subtit='$sys_subtit', sys_link='$sys_link', sys_menutit='$sys_menu', sys_board_num=$board_num, sys_memo='$sys_memo', sys_level='$root_chk', sys_rcnt=0, sys_cnt=0, view_cnt=0, tit_gubun='$gubun', sys_disno=$sys_disno, view_lev='$view_lev', book_num='$max_num', ip='$ip', up_day='$up_day' ";
			$ret = sql_query(  $sqlB );
			if( !$ret ){
				echo "treebom_insw_book_menu - ERROR sys_menu_bom : sys_jong: ". $sys_jong. ", sqlB: " . $sqlB;
				exit;
			} else {
				$ins_data = $ins_data + 1; 	//m_("ins_data: " . $ins_data);
			}
			/*
			$sql_job = "select * from {$tkher['job_link_table']} where user_id='$H_ID' and user_name='$sys_subtit' and job_addr='$sys_link' ";
			$result = sql_query( $sql_job );
			if($result) $tot = sql_num_rows($result);
			else $tot=0;
			if( !$tot ) {
				$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', email='$H_EMAIL', job_name='$gtit', user_name='$sys_subtit', num='$sys_pg_root', aboard_no='$max_num', job_addr='$sys_link', jong='$gubun', job_group='$sys_jong', job_group_code='KTree', club_url='$from_session_url', job_level='$view_lev', view_cnt=0, ip='$ip', up_day='$up_day', memo='$from_session_url' ";
				$ret = sql_query(  $sqlA );
				if( !$ret ){
					echo "treebom_insw_book_menu - ERROR sys_jong: ". $sys_jong. ", sqlA: " . $sqlA; exit;
				}
				//insert_point_app( $member['mb_id'], $config['kapp_write_point'], $sys_link, 'linktree@treebom_insw_book_menu' , $H_ID, $sys_subtit );
			}*/
			job_link_table_add( $sys_pg_root, $sys_subtit, $sys_link, $sys_pg_root, $sys_jong, $sys_subtit, $gubun );
			//job_link_table_add( $board_num, $name, $link_name, $table_name, $job_group, $name, $jong );
			insert_point_app( $H_ID, $config['kapp_write_point'], $sys_link, 'linktree@treebom_insw_book_menu' , $sys_subtit, $sys_pg_root );
		}
	}//next
	$upday  = date("Y-m-d H:i:s",time());
	if ( $ret_root_chk == 1 ) {
			$xsys_rcnt =  $sys_rcnt + $ins_data;
			$sql = " update {$tkher['sys_menu_bom_table']} set sys_rcnt='$xsys_rcnt' where sys_pg='$sys_pg_root' and sys_menu ='$sys_pg_root' and sys_level ='mroot' ";
			sql_query( $sql);
	} else {
			$xsys_cnt =  $sys_cnt + $ins_data;
			$sql = " update {$tkher['sys_menu_bom_table']} set sys_cnt=$xsys_cnt, sys_menutit='root' where sys_pg='$sys_pg_root' and sys_submenu ='$data1' ";
			sql_query( $sql);
	}
?>
		</table>
<?php
		//======================================
		sys_menu_bom_insert_curl( $sys_pg_root );
		//======================================

				$run_mode = 'treebom_insw_book';
                $sys_pg   = $xsys_pg;
				include "./tree_create_menu.php";
				$rungo = './' . $mid . '/'.$xsys_pg.'_r1.htm';
				exit;
 } else {
?>
			<p><p><center> Insert Error !!!. </center>
<?php
}
	$hostnameA = getenv('HTTP_HOST'); // 2023-08-03 add

	function sys_menu_bom_insert_curl( $sys_pg ){
		global $H_ID, $H_EMAIL, $hostnameA;

		$tabData['data'][][] = array();   // 2023-08-03 add

		$bgcolor	= "#cccccc";		/////배경색
		$fontcolor	= "black";		/////글자색
		$fontface	= "Arial";			/////글꼴 : 돋움체
		$fontsize	= "15";			/////글자크기
		$imgtype1	= "folder.gif";	/////이미지1(닫힘)
		$imgtype2	= "folder1.gif";	/////이미지2(열림)
		$imgtype3	= "folder2.gif";	/////이미지3(하위)

		//m_(" sys_menu_bom_update_curl sys_pg:" . $sys_pg ); //sys_menu_bom_update_curl sys_pg:dao1691097151

		$sql = " SELECT * from {$tkher['sys_menu_bom_table']} where sys_pg='" . $sys_pg."' ";
		$rt = sql_query( $sql);
		$i = 0;
		while ( $rs = sql_fetch_array($rt) ) {
			$sys_subtit = $rs['sys_subtit'];
			$tabData['data'][$i]['sys_userid']	= $rs['sys_userid'];
			$tabData['data'][$i]['sys_pg']		= $rs['sys_pg'];
			$tabData['data'][$i]['sys_menu']	= $rs['sys_menu'];
			$tabData['data'][$i]['sys_submenu']	= $rs['sys_submenu'];
			$tabData['data'][$i]['sys_subtit']	= $rs['sys_subtit'];
			$tabData['data'][$i]['sys_link']	= $rs['sys_link'];
			$tabData['data'][$i]['sys_level']	= $rs['sys_level'];
			$tabData['data'][$i]['sys_menutit']	= $rs['sys_menutit'];
			$tabData['data'][$i]['sys_rcnt']	= $rs['sys_rcnt'];
			$tabData['data'][$i]['sys_cnt']		= $rs['sys_cnt'];
			$tabData['data'][$i]['sys_disno']	= $rs['sys_disno'];
			$tabData['data'][$i]['sys_file']	= $rs['sys_file'];
			$tabData['data'][$i]['sys_memo']	= $rs['sys_memo'];
			$tabData['data'][$i]['host']        = $rs['sys_comp']; //getenv('HTTP_HOST'); //$hostnameA;
			$tabData['data'][$i]['email']       = $H_EMAIL;

			$tabData['data'][$i]['book_num']	= $rs['book_num'];
			$tabData['data'][$i]['tit_gubun']	= $rs['tit_gubun'];
			$tabData['data'][$i]['view_lev']	= $rs['view_lev'];
			$tabData['data'][$i]['view_cnt']	= $rs['view_cnt'];

			$tabData['data'][$i]['bgcolor']   = $bgcolor;
			$tabData['data'][$i]['fontcolor'] = $fontcolor;
			$tabData['data'][$i]['fontface']  = $fontface;
			$tabData['data'][$i]['fontsize']  = $fontsize;
			$tabData['data'][$i]['imgtype1']  = $imgtype1;
			$tabData['data'][$i]['imgtype2']  = $imgtype2;
			$tabData['data'][$i]['imgtype3']  = $imgtype3;

			$i++;
		}
		$key = 'appgenerator';
		$iv = "~`!@#$%^&*()-_=+";

		$sendData = encryptA( $tabData , $key, $iv);

//		$url_ = 'https://ailinkapp.com/onlyshop/coupon/treebom_insw_curl_ailinkapp.php'; // insert, update 공통 URL
		$url_ = 'https://ailinkapp.com/kapp/_Curl/treebom_insw_curl_ailinkapp.php'; // insert, update 공통 URL

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
			//$_ms = "treebom_insw_curl_ailinkapp curl 전송 실패 : " . curl_error($curl);
			//echo 'curl 전송 실패 : ' . curl_error($curl);
			//m_(" ------------ : " . $_ms);
		} else {
			//$_ms = 'treebom_insw_curl_ailinkapp curl 응답 : ' . $response;
			//echo 'curl 응답 : ' . $response;
			//m_(" ============ :" . $_ms);
		}
		// ============ :table30m curl 응답 : --- count:10Error: Update failed{"message":"_api table data 전달 완료"}
		curl_close($curl);
		//m_("curl end--------------- ms: email: " . $H_EMAIL); //exit();
	}
	//--------------------------------------------- 2022-05-09 보완 /t/include/lib 이동으로 my_func.php
	function aboard_table_make_menu( $board_title, $mroot, $board_type, $max_num ){

		global $H_ID, $up_day, $sys_pg_root, $code_name, $board_num;
		global $tkher;

		$ip = $_SERVER['REMOTE_ADDR'];
		$in_date=time();

		$result = sql_query("select max(no) as no from {$tkher['aboard_infor_table']} ");
		$rs = sql_fetch_array( $result );
		$board_ = $rs['no'];
		if( !$board_ ) $board_num = 1;
		else $board_num = $board_ +1;

		$table_name = $max_num; // treebom_insert2_book_menu.php에서 email일경우 @분리 처리 $max_num=$H_ID.(time()+$j);//$max_num - 중요 :게시판 테이블명으로 사용됨.//$board_num=$max_num;
		$code_name	= $table_name;	// job_link_table - aboard_no.
		$xsys_pg 	= $table_name;	//$_POST[xsys_pg];	// tree_code
		$sys_subtit = $board_title;	//$_POST[sys_subtit];
		$sys_pg		= $xsys_pg;

		$query="create table aboard_".$table_name." (
		no int(11) NOT NULL auto_increment,
		infor int(11),
		id varchar(30),
		name varchar(30),
		email varchar(100),
		home varchar(200),
		ip varchar(15),
		in_date int(11),
		subject varchar(100),
		context text,
		html int(11),
		password varchar(10),
		file_name varchar(250),
		file_wonbon varchar(250),
		file_size int,
		file_type char(4),
		file_path varchar(200),
		cnt int(11),
		target int(11),
		step int(11),
		re int(11),
		security varchar(10),
		primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";	//MyISAM->InnoDB 로변경 - 2023-11-28 printf("sql:%s", $query);
		$mq1 = sql_query( $query );
		if( !$mq1 ) {
			echo("<script>alert('treebom_insw_book_menu : Bulletin board table creation failed.  $board_num, $table_name ');</script>");
			//treebom_insw_book_menu : Bulletin board table creation failed.  1, solpakan@naver.com1713422425 
			//echo("<script>history.back();</script>");
			//게시판 테이블 생성에 실패 했습니다. 112, tkher112
			exit;
		}
		$link_name = "";
		if( $mq1 ){

//			$link_name		= KAPP_URL_T_ . '/bbs/index5.php?infor='.$board_num;
			// 중요 2023-12-29 index5.php -> index_bbs.php
			$link_name		= 'index_bbs.php?infor='.$board_num; // 2023-11-18 /bbs/index5.php를 index_bbs.php로 변경함.
			$movie			= $board_type;// '4':photo image gallery , '5':Daum type, 1:general, 2:standard, 3:memo, 4:image gallery photo
			if($movie == '5') $home_url = "GCOM05";	// GCOM05 : Daum Type, GCOM02!:standard
			else $home_url = "GCOM04";
			$fileup 		= 1;
			$grant_view	    = 0;	//0:all, 1:member, 2:운영자 3:system manager
			$grant_write	= 1;	//0:all, 1:member, 2:운영자 3:system manager
			$xlev			= "2";	// no use.
			$memo			= "";
			$job_link_type = 'A';	// /t/bbs/index5.php 에서 구분하여 처리한다.
			$table_width	= "500";
			$list_size		= 20;
			$memo_gubun	    = 1;
			$ip_gubun		= 0;
			$html_gubun	    = 0;
			$imember		= $H_ID;
			$list_table_set			= "align=center border=0 cellpadding=1 cellspacing=0";
			$list_title_bgcolor		= "#ffffff";
			$list_title_font			= "#000000";
			$list_text_bgcolor		= "#FFFFFF";
			$list_text_font			= "#000000";
			$detail_table_set		= "align=center border=0 cellpadding=1 cellspacing=0";
			$detail_title_bgcolor	= "#FFFFFF";
			$detail_title_font		= "#c0c0c0";
			$detail_text_bgcolor	= "#ffffff";
			$detail_text_font		= "#000000";
			$detail_memo_bgcolor	= "#ffffff";
			$detail_memo_font		= "#000000";
			$input_table_set		= "align=center border=0 cellpadding=1 cellspacing=0";
			$input_title_bgcolor	= "#FFFFFF";
			$input_title_font		= "#000000";

			$icon_home			= "home.gif";     //KAPP_URL_ . "/contents/icon/home.gif";
			$icon_prev			= "e_prev.gif";   //KAPP_URL_ . "/contents/icon/e_prev.gif";
			$icon_next			= "e_next.gif";   //KAPP_URL_ . "/contents/icon/e_next.gif";
			$icon_insert		= "e_insert.gif"; //KAPP_URL_ . "/contents/icon/e_insert.gif";
			$icon_update		= "e_update.gif"; //KAPP_URL_ . "/contents/icon/e_update.gif";
			$icon_delete		= "e_delete.gif"; //KAPP_URL_ . "/contents/icon/e_delete.gif";
			$icon_reply			= "e_reply.gif";  //KAPP_URL_ . "/contents/icon/e_reply.gif";
			$icon_list			= "e_list.gif";       //KAPP_URL_ . "/contents/icon/e_list.gif";
			$icon_search_list	= "search_list.gif"; //KAPP_URL_ . "/contents/icon/search_list.gif";
			$icon_search		= "search.gif";      //KAPP_URL_ . "/contents/icon/search.gif";
			$icon_submit		= "e_submit.gif";     //KAPP_URL_ . "/contents/icon/e_submit.gif";
			$icon_new			= "new.gif";          //KAPP_URL_ . "/contents/icon/new.gif";
			$icon_list_reply	= "list_reply.gif";   //KAPP_URL_ . "/contents/icon/list_reply.gif";
			$icon_memo			= "memo.gif";         //KAPP_URL_ . "/contents/icon/memo.gif";
			$icon_admin			= "e_admin.gif";      //KAPP_URL_ . "/contents/icon/e_admin.gif";

			$list_gubun			= 1;			// detail page - reply print
			$connection_gubun	= 1;						// reply display necessary:1
			$top_html			= "";
			$bottom_html		= "";
			$title_color		= "#FFFFFF";		// #81C131
			$title_text_color	= "#000000";		// #FFFFFF  new change kang.ho.
			$security			= "0";	// 비밀글 사용:1, 비밀글 사용안함:0
			$session_club_url = KAPP_URL_;
			$sys_pg_root		= $mroot;	//_POST[sys_pg_root];	// 게시판 공개레벨을 최상위 의 공개를 따름.

			$query = "insert into {$tkher['aboard_infor_table']} set
			name      ='$board_title',
			table_name='$table_name',
			fileup    = $fileup,
			in_date   = $in_date,
			memo_gubun= $memo_gubun,
			ip_gubun  = $ip_gubun,
			html_gubun= $html_gubun,
			imember   ='$imember',
			home_url  ='$home_url',
			table_width='$table_width',
			list_table_set    ='$list_table_set',
			list_title_bgcolor='$list_title_bgcolor',
			list_title_font   ='$list_title_font',
			list_text_bgcolor ='$list_text_bgcolor',
			list_text_font    ='$list_text_font',
			list_size         = $list_size,
			detail_table_set  ='$detail_table_set',
			detail_title_bgcolor='$detail_title_bgcolor',
			detail_title_font   ='$detail_title_font',
			detail_text_bgcolor ='$detail_text_bgcolor',
			detail_text_font    ='$detail_text_font',
			detail_memo_bgcolor ='$detail_memo_bgcolor',
			detail_memo_font    ='$detail_memo_font',
			input_table_set     ='$input_table_set',
			input_title_bgcolor ='$input_title_bgcolor',
			input_title_font    ='$input_title_font',
			icon_home  ='$icon_home',
			icon_prev  ='$icon_prev',
			icon_next  ='$icon_next',
			icon_insert='$icon_insert',
			icon_update='$icon_update',
			icon_delete='$icon_delete',
			icon_reply ='$icon_reply',
			icon_list  ='$icon_list',
			icon_search_list='$icon_search_list',
			icon_search ='$icon_search',
			icon_submit ='$icon_submit',
			icon_new    ='$icon_new',
			icon_list_reply='$icon_list_reply',
			icon_memo   ='$icon_memo',
			icon_admin  ='$icon_admin',
			list_gubun  = $list_gubun,
			connection_gubun = $connection_gubun,
			top_html    ='$top_html',
			bottom_html ='$bottom_html',
			grant_view  = $grant_view,
			grant_write = $grant_write,
			movie       ='$movie',
			title_color='$title_color',
			title_text_color='$title_text_color',
			security ='$security',
			lev      ='$xlev',
			make_id  ='$H_ID',
			make_club='$session_club_url',
			sunbun   = 0,
			memo     ='$memo' ";

			$mq2 = sql_query($query);
			if( $mq2 ){ // 게시판 첨부화일 저장 디렉토리 생성. : 2022-02-04 add
					$f_path1	= KAPP_PATH_T_ . "/file/" . $H_ID;
					$f_path2	= $f_path1 . "/aboard_".$table_name;
					if ( !is_dir($f_path1) ) {
						if ( !@mkdir( $f_path1, 0755 ) ) {
							echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. my_func -> aboard_table_make_menu()";
							m_(" Error: f_path1 : " . $f_path1 . " Failed to create directory. my_func -> aboard_table_make_menu()");
						}
					}
					if ( !is_dir($f_path2) ) {
						$oldumask = umask(0);
						mkdir($f_path2, 0775, true);
						umask($oldumask);
					}
			} else {
				echo "treebom_insw_book_menu : aboard_table_make_menu - sql: " . $query; exit;
			}
			return $link_name;
		} else return;
	}// function create_aboard_table end.

?>
</html>
