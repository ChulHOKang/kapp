<?php
	include_once('../tkher_start_necessary.php');
	/* --------------------------------------------------------
		treebom_insw_book_menu.php - tree menu record insert
		sys_file->sys_board_num 로 Table 변경 2023-11-28
		CURL 작업 추가 : 2023-08-09 - /t/tree_menu_guest.php ->treebom_insert2_book_menu.php->treebom_insw_book_menu.php
		call : treebom_insert2_book_menu.php -> /t/tree_menu_guest.php 에서 도 사용함. 중요.
		run : treebom_insw_book_menu.php -> tree_create_menu.php: Record 다중 등록.
		- main call pg : tree_menu_updateM2.php 추가: 2021-05-30
		                             - make_type: booktreeupdateM
		treebom_insw_book_menu : Bulletin board table creation failed.  1, solpakan@naver.com1713422425 
		include "./tree_create_menu.php";	    // source generator : no use
	--------------------------------------------------------- */
	$H_ID	= get_session("ss_mb_id");
	$url= KAPP_URL_T_; // '/';	//$PHP_SELF;
	if( !$H_ID) {
		m_("login please! ");
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL = $member['mb_email'];
	else $H_EMAIL = '';
	if( isset($_POST['data']) ) $data = $_POST['data'];
	else $data = 0;
	if( isset($_POST['data1']) ) $data1 = $_POST['data1'];
	else $data1 = 0;
	$target_my  = '';
	$mid		= '';
	$mode		= '';
	$sys_cnt	= '';
	$make_type	= '';
	$gtit		= '';
	$view_lev	= '';
	$sys_pg_root= '';
	$xroot_level= '';
	$sys_subtit= '';
	if( isset($_POST['target_my']) ) $target_my  = $_POST['target_my'];
	if( isset($_POST['mid']) )		$mid		= $_POST['mid'];
	if( isset($_POST['mode']) )		$mode		= $_POST['mode'];
	if( isset($_POST['sys_cnt']) )	$sys_cnt	= $_POST['sys_cnt'];
	if( isset($_POST['make_type']) ) $make_type	= $_POST['make_type'];
	if( isset($_POST['gtit']) )		$gtit		= $_POST['gtit'];
	if( isset($_POST['view_lev']) ) $view_lev	= $_POST['view_lev'];
	if( isset($_POST['sys_pg_root']) ) $sys_pg_root= $_POST['sys_pg_root'];
	if( isset($_POST['xroot_level']) ) $xroot_level= $_POST['xroot_level'];
	if( isset($_POST['isys_subtit']) ) $sys_subtit = $_POST[$isys_subtit];
	$sql ="select * from {$tkher['sys_menu_bom_table']} where sys_pg ='$sys_pg_root' and sys_submenu = '$sys_pg_root' and sys_level='mroot'";
	$result = sql_query( $sql);
	$rs  = sql_fetch_array($result);
	$mid = $rs['sys_userid'];
	$sys_rcnt    = $rs['sys_rcnt'];
	$sys_submenuR = $rs['sys_submenu'];
	$up_day = date("Y-m-d H:i:s");
	if( $H_ID !== $mid && $H_LEV < 8 ) {
		m_("You do not have permission to work.");
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$j=0;
	$isys_subtit = 'sys_subtit_'.$j; 
	if( isset($_POST[$isys_subtit]) ) {
		$sys_subtit = $_POST[ $isys_subtit ];
		m_( $sys_subtit . ", j: " . $j . ", isys_subtit: " . $_POST[ $isys_subtit ] );
		//공방자료, j: 0, isys_subtit: 공방자료
	} else m_("none ---");
 if( isset($_POST[$isys_subtit]) ) {
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
	$board_num = 0; 
	for ( $intloop = 0; $intloop < 13; $intloop++ ){
		$isys_subtit = "sys_subtit_" . $intloop;
		$sys_subtit	= $_POST[$isys_subtit];
		if( strlen($sys_subtit) > 0 ) {
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
			$max_num		= $_POST[$imax_num]; // book_num, $max_num = $H_ID . (time() + $j);	
			$root_cnt = 0;
			if( $mode == 'mroot' ) {
				$root_chk = "sroot";
			} else {
				$root_chk = "client";
			}
			echo "<tr><td>".$sys_subtit."</td>";
			echo "<td>".$sys_link."</td></tr>";
			//$url_ = iconv_substr( $sys_link, 0, 46, "utf-8");
			if( $sys_jong == "link"){
				$gubun = 'T';
			} else if( $sys_jong == "note"){
				$sys_link = KAPP_URL_T_ . "/menu/" . $sys_link; 
				$gubun = 'N'; // B-> N : Note 
				$sqlX= "INSERT INTO {$tkher['webeditor_table']} SET num='$max_num', h_lev='$view_lev', user='$H_ID', id='book', title='$sys_subtit', diff='1', book_name='$sys_pg_root', content='$sys_subtit'";
				$ret = sql_query(  $sqlX );
				if( !$ret ){
					echo "treebom_insw_book_menu : ERROR sys_jong: ". $sys_jong. ", sqlX: " . $sqlX; exit;
				}
			} else if( $sys_jong == "board"){
				//공방자료, j: 0, isys_subtit: 공방자료
				$gubun = 'A';
				$board_title = $sys_subtit;
				$board_type='5'; // '5':Daum type, '2' :standard
				//$link_ret = aboard_table_make_menu( $board_title, $sys_pg_root, $board_type, $max_num );
				$sys_link = create_aboard_table_make_menu( $board_title, $sys_pg_root, $board_type, $max_num );
				//$sys_link = KAPP_URL_T_ . "/menu/" . $link_ret; 
			} else if( $sys_jong == "photo"){
				$gubun = 'A';
				$board_title = $sys_subtit;
				$board_type='4'; 
				//$link_ret = aboard_table_make_menu( $board_title, $sys_pg_root, $board_type, $max_num );
				$sys_link = create_aboard_table_make_menu( $board_title, $sys_pg_root, $board_type, $max_num );
//				$sys_link = KAPP_URL_T_ . "/menu/" . $link_ret;
			} else {
					$gubun = 'T';
					echo "treebom_insw_book_menu : ERROR : link type - sys_jong: ". $sys_jong;
					exit;
			}
			$sqlB = "INSERT INTO {$tkher['sys_menu_bom_table']} SET sys_comp='$from_session_url', sys_userid='$H_ID', sys_pg='$sys_pg_root', sys_menu='$sys_menu', sys_submenu='$sys_submenu', sys_subtit='$sys_subtit', sys_link='$sys_link', sys_menutit='$sys_menu', sys_board_num=$board_num, sys_memo='$sys_memo', sys_level='$root_chk', sys_rcnt=0, sys_cnt=0, view_cnt=0, tit_gubun='$gubun', sys_disno=$sys_disno, view_lev='$view_lev', book_num='$max_num', ip='$ip', up_day='$up_day' ";
			$ret = sql_query(  $sqlB );
			if( !$ret ){
				echo "treebom_insw_book_menu - ERROR sys_menu_bom : sys_jong: ". $sys_jong. ", sqlB: " . $sqlB;
				exit;
			} else {
				$ins_data = $ins_data + 1; 	
			}
			job_link_table_add( $sys_pg_root, $sys_subtit, $sys_link, $max_num, $sys_jong, $sys_subtit, $gubun );
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
		//sys_menu_bom_insert_curl( $sys_pg_root );
		sys_menu_bom_curl_send( $sys_pg_root );
		$run_mode = 'treebom_insw_book';
        $sys_pg   = $xsys_pg;
			/* ----------------------------------------
				include "./tree_create_menu.php";	    //소스 생성 막고 바로가기 추가.
			 ------------------------------------------ */
			$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit . "&num=" . $max_num . "&sys_jong=" . $sys_jong . "&board_num=" . $board_num . "&sys_link=" . $sys_link;
		
			echo "<script>window.open('$rungo', '_top', ''); </script>";  
			exit;
 } else {
?>
			<p><center> Insert Error !!!. </center>
<?php
}
?>
</html>
