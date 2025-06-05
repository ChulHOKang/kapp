<?php
	include_once('../tkher_start_necessary.php');
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board AppGeneratorSystem. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
	$ss_mb_id	= get_session("ss_mb_id");
	if( !isset( $ss_mb_id ) || $ss_mb_id == '' ) {
		m_(" Error NULL - ss_mb_id: " .$ss_mb_id );
		echo "<script>history.back(-1);</script>"; exit;
	}
	$H_ID	= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$H_NAME = $member['mb_name'];
	$H_NICK = $member['mb_nick'];
	$H_EMAIL= $member['mb_email'];
	/*
		query_ok_new.php : 
		call : board_list3.php, insertTT.php, replyTT.php, detailTT.php, 
		Table data insert : 2019-01-26
		table create : board_create_pop.php - board_create_pop_ok.php
		? infor:126, mode:memo_insert
	*/

	include "./infor.php";

	if( isset($_POST['search_choice'])) $search_choice=$_POST["search_choice"]; 
	else $search_choice ='';
	if( isset($_POST['update_pass'])) $update_pass  =$_POST['update_pass']; 
	else $update_pass ='';
	
	$in_date			= time();

	if( isset($_POST['infor'])) $infor   = $_POST['infor'];
	else $infor ='';
	
	if( isset($_POST['mode'])) $mode= $_POST['mode'];
	else $mode ='';
	if( isset($_POST['page'])) $page =$_POST['page']; 
	else $page ='';
	if( isset($_POST['insert'])) $insert= $_POST['insert'];
	else $insert ='';
	if( isset($_POST['update'])) $update= $_POST['update'];
	else $update ='';
	if( isset($_POST['subject'])) $subject= $_POST['subject'];
	else $subject ='';
	if( isset($_POST['content'])) $content= $_POST['content'];
	else $content ='';
	if( isset($_POST['nameA'])) $name= $_POST['nameA'];
	else $name ='';
	if( isset($_POST['context'])) $context= $_POST['context'];
	else $context ='';

	if( isset($_POST['target'])) $target= $_POST['target'];
	else $target ='';
	if( isset($_POST['step'])) $step= $_POST['step'];
	else $step ='';
	if( isset($_POST['re'])) $re= $_POST['re'];
	else $re ='';
	if( isset($_POST['no'])) $no= $_POST['no'];
	else $no ='';

$table_name = $mf_infor[2];
//m_("table_name -2: $table_name - : " . $mf_infor[2]);
//table_name -2: solpakan_naver1748648933 - : solpakan_naver1748648933
	/*
	switch( $mf_infor[47] ){ // 47:grant_write
		case '0': break;
		case '1': 	
			if( !$H_ID || $H_LEV < 2 ) { 
				m_("You do not have permission to write. id:" . $H_ID .", lev:". $H_LEV); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
		case '2': 
			if( $H_ID != $mf_infor[53] ) { 
				m_("You do not have permission to write."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
		case '3': 
			if( $H_LEV < 8 ) { 
				m_("You do not have permission to write."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
	}*/

	if( $_POST['mode'] == "ADD_create_board_list3" || $_POST['mode'] == "ADD_create_board_list_my" || $_POST['mode'] == "ADD_create_board_list_adm" || $_POST['mode'] == "board_list3m"){

		$result = sql_query("SELECT * from {$tkher['aboard_admin_table']} ");
		$rs = sql_fetch_array( $result );
		$bbsname = $rs['bbsname'];	// tkher
		$in_date=time();

		$result = sql_query("select max(no) as no from {$tkher['aboard_infor_table']} ");
		$rs = sql_fetch_array( $result );
		$board_num = $rs['no'];
		if( !$board_num ) $board_num = 1;
		else $board_num = $board_num +1;
		$table_name = $H_ID . time();
		$xlev = $H_LEV;
		$xid  = $H_ID;
		$sellist_index = $_POST['sellist_index'];
		$movie	= $_POST['sellist_index'];

		if( $sellist_index == "3" || $sellist_index == "4" || $sellist_index == "5" ){
			$movie	=  $_POST['sellist_index']; // 3:memo, 4:image, 5: standard=daum - value=>일반컨텐츠,1>동영상컨텐츠,2>홈페이지링크,3>전자앨범
			$fileup = 1;
		} else {
			m_("Error query_ok_new - Board type : " . $_POST['sellist_index'] );
			echo "<script>history.back(-1);</script>"; exit;
		}

		$query = "create table aboard_" .$table_name. " (
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
		primary key(no) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$mq1 = sql_query( $query );
		if( $mq1 ) {
			$day = date("Y-m-d H:i:s");

			$link_name= KAPP_URL_T_ . '/menu/index_bbs.php?infor='.$board_num;
			$home_url = KAPP_URL_T_; //"GCOM05!"; // 의미가 없다.
			$name     = $_POST['aboard_name'];	// 게시판 명 

			$fileup 		= 1;
			$grant_view	    = 1;	//0:all, 1:member, 2:운영자 3:system manager
			$grant_write	= 2;	//0:all, 1:member, 2:운영자 3:system manager
			$xlev			= $H_LEV; // "2";	// no use.
			$memo			= "insert1 - query_ok_new $day ";
			$job_link_type = 'A';	// A=aboard index_bbs.php 에서 구분하여 처리한다.
			$table_width	= "800";
			$list_size		= 20;
			$memo_gubun	    = 1;
			$ip_gubun		= 0;
			$html_gubun	    = 0;
			$imember		= $H_ID;

			$list_table_set			= "align=center border=0 cellpadding=1 cellspacing=0";
			$list_title_bgcolor		= "#ffffff";
			$list_title_font		= "#000000";
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
			$icon_home			= "home.gif";
			$icon_prev			= "e_prev.gif";
			$icon_next			= "e_next.gif";
			$icon_insert		= "e_insert.gif";
			$icon_update		= "e_update.gif";
			$icon_delete		= "e_delete.gif";
			$icon_reply			= "e_reply.gif";
			$icon_list			= "e_list.gif";
			$icon_search_list	= "search_list.gif";
			$icon_search		= "search.gif";
			$icon_submit		= "e_submit.gif";
			$icon_new			= "new.gif";
			$icon_list_reply	= "list_reply.gif";
			$icon_memo			= "memo.gif";
			$icon_admin			= "e_admin.gif";
			$list_gubun			= 1;
			$connection_gubun	= 1;
			$top_html			= "";
			$bottom_html		= "";
			$title_color		= "#FFFFFF";
			$title_text_color	= "#000000";
			$security			= "0";	// 비밀글 사용:1, 비밀글 사용안함:0
			$total_record       = 0;
			$session_club_url   = KAPP_URL_;

			$query = "insert into {$tkher['aboard_infor_table']} set 
			name        ='$name',
			table_name  ='$table_name', fileup= $fileup, in_date = $in_date, memo_gubun= $memo_gubun, ip_gubun= $ip_gubun, html_gubun= $html_gubun,
			imember     ='$imember',    home_url='$home_url', table_width ='$table_width',
			list_table_set    ='$list_table_set', list_title_bgcolor='$list_title_bgcolor',	list_title_font='$list_title_font', list_text_bgcolor ='$list_text_bgcolor',
			list_text_font    ='$list_text_font', list_size= $list_size, detail_table_set='$detail_table_set', detail_title_bgcolor='$detail_title_bgcolor',
			detail_title_font ='$detail_title_font', detail_text_bgcolor ='$detail_text_bgcolor', detail_text_font    ='$detail_text_font', detail_memo_bgcolor ='$detail_memo_bgcolor',
			detail_memo_font  ='$detail_memo_font', input_table_set='$input_table_set', input_title_bgcolor ='$input_title_bgcolor', input_title_font='$input_title_font',
			icon_home         ='$icon_home', icon_prev='$icon_prev', icon_next='$icon_next', icon_insert='$icon_insert', icon_update='$icon_update', icon_delete='$icon_delete',
			icon_reply        ='$icon_reply',icon_list ='$icon_list',icon_search_list='$icon_search_list', icon_search ='$icon_search', icon_submit ='$icon_submit', icon_new='$icon_new',
			icon_list_reply   ='$icon_list_reply',	icon_memo='$icon_memo', icon_admin='$icon_admin',
			list_gubun  = $list_gubun, connection_gubun = $connection_gubun, top_html='$top_html', bottom_html='$bottom_html',
			grant_view  = $grant_view,
			grant_write = $grant_write,
			movie       ='$movie', title_color='$title_color', title_text_color='$title_text_color', security ='$security', lev='$xlev', make_id='$H_ID', make_club='$session_club_url',
			sunbun   = 0,
			memo     ='$memo' ";

			$mq2 = sql_query( $query );  
			if( $mq2 ){ // 게시판 첨부화일 저장 디렉토리 생성.
					//$f_path1	= "../file/" . $H_ID;
					$f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53];
					//$f_path2	= $f_path1 . "/aboard_".$table_name;
					$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];
					if ( !is_dir($f_path1) ) {
						if ( !@mkdir( $f_path1, 0755 ) ) {
							echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
							m_("query_ok_new.php Error: f_path1 : " . $f_path1 );
							echo "<meta http-equiv='refresh' content=0;url='board_list3.php?page=$page'>";
						}
					}
					if ( !is_dir($f_path2) ) {
						if ( !@mkdir( $f_path2, 0755 ) ) {
							echo " Error: f_path2 : " . $f_path2;
							m_("query_ok_new.php Error: f_path2 : " . $f_path2);
							echo "<meta http-equiv='refresh' content=0;url='board_list3.php?page=$page'>";
						}
					}
			} else {
				//echo "A sql: " . $query;
				exit;
			}
			$up_day  = date("Y-m-d-H:i:s",time());
			/////////////    job_link_table    ///////////////////////////////////////////////////
			$job_group = 'aboard';
			$jong      = 'A';
			if( $mq1 and $mq2 ){
				job_link_table_add( $board_num, $name, $link_name, $table_name, $job_group, $name, $jong );
				insert_point_app( $H_ID, $config['kapp_write_point'], $link_name, 'aboard@query_ok_new', $name, $table_name, $table_name);
				echo "<script>alert( 'name:" . $name . " : " . $table_name . ", infor: " .$board_num ."- The bulletin board has been created.');</script>";
			}
			//exit;
			echo "<script>history.back(-1);</script>"; exit;
		} else {
			m_(" Table Create ERROR --------");
			echo "create sql: " . $query; exit;
		}
	} else if( $mode=='memo_insert'){ //call:list1_detail.php : comment 등록시에 처리한다. reply.php 와 구분한다. 중요!.
		$context    = $_POST['context'];
		//$board_name = $_POST['board_name'];
		if( isset($_POST['list_no'])) $list_no = $_POST['list_no'];
		else $list_no ='';
		$name       = $_POST['name'];
		$password   = $_POST['password'];
		$query = "insert into {$tkher['aboard_memo_table']} set board_name='$board_name', list_no=$list_no, name='$H_NICK', memo='$context', in_date='$in_date', password='$password', id='$H_ID' ";
		$mq = sql_query($query);
		if(!$mq){
			echo("<script>alert('Insert Error')</script>");
		} else {
			//echo("<script>alert('Memo OK! ')</script>");
		}
		if( isset($_POST['search_choice'])) $search_choice=$_POST["search_choice"]; 
		else $search_choice ='';
		$gourl = "list1_detail.php";
		echo "<meta http-equiv='refresh' content=0;url='".$gourl."?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";

	} else if( $mode == 'del_funcA' ) {
		$target_no = $_POST['target_no'];
		if( $H_LEV > 7 ) $chkpass = " ";
		else if( $H_ID == $mf_infor[53] ) $chkpass = " ";
		else $chkpass = " and id='$H_ID' ";
		if( isset($_POST['list_no'])) $list_no = $_POST['list_no'];
		else $list_no ='';
		$query	= "SELECT * from aboard_".$mf_infor[2]." where target='$target_no' $chkpass ";
		$mq		= sql_query($query);
		$mn		= sql_num_rows($mq);
		if( $mn){
			while( $rs =sql_fetch_array($mq) ){
				if( $rs['file_name'] != ""){
					$del_file = "../file/" . $mf_infor[53] . "/aboard_" . $mf_infor[2] . "/" . $rs['file_name'];
					exec ("rm $del_file");
				}
			}
		}
		$sql = "delete from " . "aboard_". $mf_infor[2] . " where target=$target_no and id='$H_ID' ";
		sql_query( $sql );
		echo "<meta http-equiv='refresh' content=0;url='board_list_memo.php?infor=$infor'>";
		exit;
	} else if( $mode=='memo_reply_func'){ //call:board_list_memo.php : comment 등록시에 처리한다. reply.php 와 구분한다. 중요!.
		
		if( strlen( $_POST['file']) > 0 ){
			$upfile_name= $_FILES["file"]["name"];
			$upfile_size= $_FILES["file"]["size"];
		} else {
			$upfile_name= '';
			$upfile_size= 0;
		}
		$upfile2	= "";
		$file_ext	= "";
		$f_path2	= "";
		$cnt        = 0;
		if( strlen( $upfile_name) > 0 ){
			$file_ext		= $_POST['file_ext'];
			if ( $upfile_size >  $upload_file_size_limit ) {		// my_func. 3*1000000
				m_( $upload_file_size_limit . "Mb low, Only uploaded below"); // 이하만 업로드 가능합니다 
				echo "<script>history.go(-1);</script>";
				exit;
			}
			$upfile_name	= $_FILES["file"]["name"];
			$upfile_name	= str_replace(" ", "", $upfile_name);
			//$f_path1	= "../file/" . $mf_infor[53];
			$f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53];
			$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];
			if ( !is_dir($f_path1) ) {
				if ( !@mkdir( $f_path1, 0755 ) ) {
					echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
					echo "<script>history.go(-1); </script>";exit;
				}
			}
			if ( !is_dir($f_path2) ) {
				if ( !@mkdir( $f_path2, 0755 ) ) {
					echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
					echo "<script>history.go(-1); </script>";exit;
				}
			}
			$upfile2 = $H_ID . "_" . time() . $file_ext; //$ext_name;
			move_uploaded_file( $_FILES["file"]["tmp_name"], $f_path2 . "/" . $upfile2 );
		}

		$target = $_POST['target_'];//target 셋팅(원본글의 target값을 저장)	
		$step   = $_POST['step'];
		$re     = $_POST['re'];

		$subject= $_POST['subject'];
		$context= $_POST['context'];

		$re   = $re+1;			//re 셋팅 
		$step = $step+1;	    //step 셋팅(원본글의 step에서 +1을 하고 같은 값이 있을시 모두 +1증가) 
		
		$query = "select no from aboard_". $mf_infor[2] ." where target=$target and step=$step";
		$mq = sql_query($query);
		if( $mq ){
			$query = " update aboard_". $mf_infor[2]. " set step=step+1 where target=$target and step >=$step";
			$mq    = sql_query($query);
		}
		$queryA = " insert into aboard_". $mf_infor[2] ." set
		infor = $infor,
		id = '$H_ID',
		name = '$H_NICK',
		email = '$email',
		home = '$home',
		ip = '$ip',
		in_date = '$in_date',
		subject = '$subject',
		context = '$context',
		password = '".$_POST['password']."',
		file_name = '$upfile2',
		file_wonbon = '$upfile_name',
		file_size = $upfile_size,
		file_type = '$file_ext',
		file_path = '$f_path2',
		cnt = $cnt,
		target = $target,
		step = $step,
		re = $re,
		security = '".$_POST['security']."' ";
		
		$mqA = sql_query( $queryA);
		if( $mqA ){
			//m_(" OK! insert board: aboard_" . $mf_infor[2] );
		} else {
			echo "sql: " . $queryA; exit;
		}
		echo("<meta http-equiv='refresh' content=0;url='board_list_memo.php?infor=$infor&no=$no&page=$page&search_choice=$search_choice&search_text=$search_text'>");
		
	} else if( $mode == "del_func_") { 

		$del_no = $_POST['xmf_no'];
		$sql    = "delete from " . "aboard_". $mf_infor[2] . " where no=$del_no and infor= $infor and id='$H_ID' ";
		sql_query( $sql );
		echo "<meta http-equiv='refresh' content=0;url='board_list_memo.php?infor=$infor'>";
		exit;
	} else if( $mode == "Update_nm_change" ){ // board_list3.php Change : board name 적용버턴. - 게시판 이름 변경.
		$chgname  = $_POST['chgname'];
		$board_no = $_POST['board_no']; // table no - infor
		$board_nm = $_POST['board_nm']; // table_name

		if( isset($_POST['page'])) $page=$_POST['page']; 
		else $page ='';
		$link_ = "index_bbs.php?infor=" . $board_no;

				$query = "update {$tkher['aboard_infor_table']} set name = '$chgname' where make_id='$H_ID' and no=".$board_no;
				$mq=sql_query($query);
		
				$sql = "update {$tkher['job_link_table']} set user_name='$chgname', job_name='$chgname' , job_addr='$link_', jong='A' where user_id='$H_ID' and aboard_no='$board_nm' ";
				sql_query( $sql );
				//echo("<meta http-equiv='refresh' content='0; URL=./board_create_pop.php'>");
				echo "<meta http-equiv='refresh' content='0; URL=board_list3.php?page=".$page."'>";
				exit;
	} else if( $_POST['mode'] == "Update_func_run" ){ // board_list3.php
		$grant_read  = $_POST['xread'];
		$grant_write = $_POST['xwrite'];
		$grant_memo  = $_POST['xmemo'];
		$skin        = $_POST['xskin'];
		$xno = $_POST['no'];
		$page = $_POST['pageno'];
		$xfile_size = $_POST['xfile_size'];
			$query = "update {$tkher['aboard_infor_table']} set fileup = '$xfile_size', movie = '$skin', grant_view=$grant_read, grant_write=$grant_write, memo='$grant_memo' where no=$xno";
			$mq = sql_query($query);
			if( $mq ) { echo("<script>alert('Board property has been changed. ')</script>");}
			else {
				echo "sql: " . $query; exit;
			}
			echo "<meta http-equiv='refresh' content='0; URL=./board_list3.php?page=".$page."'>";
			exit;

	} else if( $mode == "insert_form_image") {

		if( strlen( $_FILES["file"]["name"] ) > 0 ){
			$upfile_name= $_FILES["file"]["name"];
			$upfile_size= $_FILES["file"]["size"];
		} else {
			$upfile_name= '';
			$upfile_size= 0;
		}
		$upfile2	= "";
		$file_ext	= "";
		$f_path2	= "";
		if ( $upfile_name && strlen($_POST['file_ext']) > 3) {

			$file_ext		= $_POST['file_ext'];
			if ( $upfile_size >  $upload_file_size_limit ) {		// my_func. 3*1000000
				m_("  Only $upload_file_size_limit Mb or less can be uploaded ");
				echo "<script>history.go(-1);</script>";
				exit;
			}
			$upfile_name	= str_replace(" ", "", $upfile_name);
			$f_url	= KAPP_URL_T_ . "/file/" . $mf_infor[53];
			$f_path_url	= $f_url . "/aboard_".$mf_infor[2];
			$f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53];
			$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];
			if ( !is_dir($f_path1) ) {
				if ( !@mkdir( $f_path1, 0755 ) ) {
					echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
					echo "<script>history.go(-1); </script>";exit;
				}
			}
			if ( !is_dir($f_path2) ) {
				if ( !@mkdir( $f_path2, 0755 ) ) {
					echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
					echo "<script>history.go(-1); </script>";exit;
				}
			}
			$upfile2 = $H_ID . "_" . time() . $file_ext; //$ext_name;
			move_uploaded_file( $_FILES["file"]["tmp_name"], $f_path2 . "/" . $upfile2 );
			//exec ("chmod 777 bbs_image/$upfile2");
		}
		$cnt=0;		$step=0;		$re=0;
		$query  ="select max(no) as no from aboard_".$mf_infor[2]; //$infor;
		$mq     =sql_query($query);
		$target =sql_num_rows( $mq );
		if( !$target ) $target=1;
		else {
			$rs     = sql_fetch_array( $mq );
			$target = $rs['no']+1;
		}
		
		//$table_name - $mf_infor[2], $query="insert into aboard_".$infor." set
		//table_name -2: solpakan_naver1748648933 - : solpakan_naver1748648933
		$query="insert into aboard_". $mf_infor[2]. " set
		infor = $infor,
		id = '$H_ID',
		name = '$H_NICK',
		email = '',
		home = '',
		ip = '$ip',
		in_date = '$in_date',
		subject = '$subject',
		context = '$context',
		html = 0,
		password = '',
		file_name = '$upfile2',
		file_wonbon = '$upfile_name',
		file_size = '$upfile_size',
		file_type = '$file_ext',
		file_path = '$f_path2',
		cnt = 0,
		target = $target,
		step = 0,
		re = 0,
		security = '' ";

		$mqA = sql_query( $query );
		if( $mqA ){
			//m_(" OK! insert board: aboard_" . $mf_infor[2] );
		} else {
			echo "Error sql: " . $queryA; exit;
		}
		echo "<meta http-equiv='refresh' content=0;url='list1.php?infor=$infor'>";
		//echo "<meta http-equiv='refresh' content=0;url='index_bbs.php?infor=$infor'>";
		exit;
	} else if( $mode == "memo_insert_form_") {	// board_list_memo.php : call. 중요!. 

		if( strlen( $_FILES["file"]["name"] ) > 0 ){
			$upfile_name= $_FILES["file"]["name"];
			$upfile_size= $_FILES["file"]["size"];
		} else {
			$upfile_name= '';
			$upfile_size= 0;
		}

		$upfile2	= "";
		$file_ext	= "";
		$f_path2	= "";
		if ( $upfile_name && strlen($_POST['file_ext']) > 3) {

			$file_ext		= $_POST['file_ext'];
			if ( $upfile_size >  $upload_file_size_limit ) {		// my_func. 3*1000000
				m_("  Only $upload_file_size_limit Mb or less can be uploaded ");
				echo "<script>history.go(-1);</script>";
				exit;
			}
			$upfile_name	= str_replace(" ", "", $upfile_name);
			$f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53];
			$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];
				//m_( "query_ok_new - file: ".$upfile_name .", ext_len:" . strlen($_POST['file_ext']) . ", path: " . $f_path2); // file: 새해인사.jpg, ext_len:4, path: ../file/dao/aboard_tkher112
			if ( !is_dir($f_path1) ) {
				if ( !@mkdir( $f_path1, 0755 ) ) {
					echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
					echo "<script>history.go(-1); </script>";exit;
				}
			}
			if ( !is_dir($f_path2) ) {
				if ( !@mkdir( $f_path2, 0755 ) ) {
					echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
					echo "<script>history.go(-1); </script>";exit;
				}
			}
			$upfile2 = $H_ID . "_" . time() . $file_ext; //$ext_name;
			move_uploaded_file( $_FILES["file"]["tmp_name"], $f_path2 . "/" . $upfile2 );
			//exec ("chmod 777 bbs_image/$upfile2");
		}
		//-------------------------------------------------------------------- file upload end
		//조회수,step값,re값 초기화
		$cnt=0;		$step=0;		$re=0;
		// 다음글 번호 구하기
		$query  ="select max(no) as no from aboard_". $mf_infor[2]; //$infor;
		$mq     =sql_query($query);
		$target =sql_num_rows( $mq );
		if( !$target ) $target=1;
		else {
			$rs     = sql_fetch_array( $mq );
			$target = $rs['no']+1;
		}
		//$subject = get_textR( $subject, 0);		//데이타 입력
		$query="insert into aboard_". $mf_infor[2] ." set
		infor = $infor,
		id = '$H_ID',
		name = '$H_NICK',
		email = '',
		home = '',
		ip = '$ip',
		in_date = '$in_date',
		subject = '$subject',
		context = '$content',
		html = 0,
		password = '',
		file_name = '$upfile2',
		file_wonbon = '$upfile_name',
		file_size = '$upfile_size',
		file_type = '$file_ext',
		file_path = '$f_path2',
		cnt = 0,
		target = $target,
		step = 0,
		re = 0,
		security = '' ";

		$mqA = sql_query( $query );
		if( $mqA ){
			//m_(" OK! insert board: aboard_" . $mf_infor[2] );
		} else {
			echo "Error sql: " . $queryA; exit;
		}
		echo "<meta http-equiv='refresh' content=0;url='index_bbs.php?infor=$infor'>";
		exit;
	} else {
		m_("? infor:$infor, mode:$mode");
		echo("<meta http-equiv='refresh' content=0;url='index_bbs.php?infor=$infor'>"); 
	}

?>