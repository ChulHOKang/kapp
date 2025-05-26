<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];
	$H_EMAIL   = $member['mb_email'];
	$ip = $_SERVER['REMOTE_ADDR'];

	/* 
		treebom_updw_new_menu.php : call - tree_menu_guest.php -> tree_menu_update.php에서 call.
		: tree 메뉴 내용 변경 작업,
		call : treebom_update2_new.php
		run : tree_create.php : Note Tree Source Create.
		sys_menu_bom_update_curl() : curl 실행 추가: 2023-08-07
	*/
	if (!$H_ID) {
		echo "<script> alert('Login is required.');</script>";
		$url='/';	//$PHP_SELF;
		echo "<script>window.open('$url', '_top', '');</script>";
		exit;
	}
	if( $H_ID !== $mid and $H_LEV < 8 ) {
		my_msg(" You do not have permission. ");
		$url='/';	//$PHP_SELF;
		echo "<script>window.open('$url', '_top', '');</script>";
		exit;
	}
	$root_tit= $_POST['gtit'];
	$data	= $_POST['data'];
	$data1	= $_POST['data1'];
	$sys_pg	= $_POST['sys_pg'];
	$sys_pg_root= $_POST['sys_pg_root'];

	$mode	= $_POST['mode'];
	$m_type = $_POST['m_type'];
	$make_type = $_POST['make_type'];
    //m_("sys_pg:".$sys_pg . ", sys_pg_root:". $sys_pg_root . ", data:" . $data . ", data1:" . $data1); 
	//sys_pg:dao1690977209, sys_pg_root:dao1690977209, data:dao1690977209, data1:dao1690977209
	//sys_pg:dao1691097151, sys_pg_root:dao1691097151, data:dao1691097151, data1:dao1691097151

	$gtit = $_POST['gtit'];
	$mt   = $_POST['mt']; 
	$my_page_run = $_POST['my_page_run']; 

	/*
	switch( $mt ){
		case 'T' : $type_nm='cratree'; break;
		case 'B' : $type_nm='BOOK';    break;
		case 'M' : $type_nm='popup';   break;
		case 'G' : $type_nm='BBSTREE'; break;
		case 'U' : $type_nm='LINK';    break;
		default  : $type_nm='gita';    break;
	}
	if($mt=='G') $ggroup='BBSTREE';
	else if($mt=='B') $ggroup='BOOK';
	else if($mt=='M') $ggroup='popup'; // add popup menu
	else if($mt=='T') $ggroup='cratree';
	else if($mt=='U') $ggroup='LINK';
	else $ggroup='gita'; */

	$sql="select * from {$tkher['sys_menu_bom_table']} where sys_pg ='$sys_pg_root' and sys_submenu = '$sys_pg_root' and sys_level='mroot'";
	$result = sql_query( $sql);	
	$rs     = sql_fetch_array($result);
	$mid    = $rs['sys_userid'];
	if( $H_ID !== $mid ) {
		my_msg(" You do not have permission to work. ");
		if($mt=='M') $rungo = KAPP_URL_T_ . "/menu/" . $rs['sys_userid'] . "/". $sys_pg_root . "_runf.html";
		else $rungo = KAPP_URL_T_ . "/menu/" . $rs['sys_userid'] . "/". $sys_pg_root . "_runf.html";   // 2023-08-07 change
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}

	$sys_subtit_ = "sys_subtit_0";
	$sys_subtit	= $_REQUEST[$sys_subtit_]; //m_("sys_subtit:$sys_subtit_"); //sys_subtit:AI-반도체-NPU , sys_subtit:초전도체-LK99
	if( isset($sys_subtit) ) {
  ?>
		<table border=1 >
			<tr>
				<th> title </th>
				<th> URL </th>
			</tr>
<?php 
		for( $intloop = 0; $sys_subtit; $intloop++ ) {
			$sys_subtit_ = "sys_subtit_" . $intloop;
			if( isset($_POST[$sys_subtit_]) ) $sys_subtit = $_POST[$sys_subtit_];
			else $sys_subtit = "";
			if ( $sys_subtit !== "") { 
				$sys_disno	= "sys_disno_" . $intloop;		// 변수 설정
				$seqno	    = "seqno_" . $intloop;		// 변수 설정
				$sys_subtit = "sys_subtit_" . $intloop;
				$sys_pg_job = "sys_pg_job_" . $intloop;
				$book_num   = "book_num_" . $intloop;
				$sys_link	= "sys_link_" . $intloop;
				$sys_memo	= "sys_memo_" . $intloop;
				$typex	    = "type_" . $intloop;
				$sys_subtit_old = "sys_subtit_old_" . $intloop;

				$sys_disno	= $_POST[$sys_disno];	// 데이터 리턴.
				$seqno	    = $_POST[$seqno];	// 데이터 리턴.
				$sys_subtit	= $_POST[$sys_subtit];
				if( $intloop == 0 ) $sys_subtit_group = $sys_subtit;
				$sys_pg_job	= $_POST[$sys_pg_job]; 
				$book_num	= $_POST[$book_num];
				$sys_link	= $_POST[$sys_link];
				$sys_memo	= $_POST[$sys_memo];
				$typex	    = $_POST[$typex];
				$sys_subtit_old	= $_POST[$sys_subtit_old];

                if ( $sys_link == "" ) {
                     $sys_link = "http://";
                }
				echo "<tr><td>".$sys_subtit."</td>";
				echo "<td>".$sys_link."</td></tr>";

                $sql = " update {$tkher['sys_menu_bom_table']} set sys_subtit='$sys_subtit', sys_link='$sys_link', sys_disno='$sys_disno', tit_gubun='$typex', sys_memo='$sys_memo' where seqno='$seqno' "; 
				sql_query( $sql);

				switch( $typex ){
					case 'T' : $type_nm='cratree'; break;
					case 'B' : $type_nm='BOOK';    break;
					case 'M' : $type_nm='menu';    break;  // tree root
					case 'N' : $type_nm='Note';    break;  // tree sroot
					case 'G' : $type_nm='BBSTREE'; break;
					case 'U' : $type_nm='LINK';    break;
					default  : $type_nm='gita';    break;
				}

				$sqla = "update {$tkher['job_link_table']} set user_name='$sys_subtit', job_name='$root_tit', job_addr='$sys_link', jong='$typex', job_group='$type_nm', memo='$sys_memo' where user_id='$H_ID' and num='$sys_pg' and aboard_no='$book_num' "; 
				sql_query( $sqla );  

				if( $typex == 'G' ) {
					$sqlb = "update {$tkher['admin_tkher_bbs_table']} set comment='$sys_subtit', top3='$sys_subtit', memo='$sys_memo' where make_userid='$H_ID' and name='$book_num' ";  
					sql_query( $sqlb );  
				}
           } //if
		} //for
		sys_menu_bom_update_curl( $sys_pg ); 
?>	
		</table>
<?php
				///////////< tree file create >//////////////  
				$sys_userid_0 = "sys_userid_0";
				$mid	= $_POST[$sys_userid_0];	//m_("m_type:$m_type, make_type:$make_type");

				/*
				if( $m_type == 'bbstreeupdate'  ) {// 미처리 ...

					$run_mode = 'cratree_bbstreeupdate';
					include "./tree_create_new_bbstree.php";
					$rungo = './' . $mid. '/' . $sys_pg. '_r1.htm';
					my_msg("treebom_updw_new Board Tree Completed.");
					if( $make_type=='newcratree' ) { 
						echo "<script>window.open('$rungo', '_top', ''); </script>";
					} else if( $target_my=='' ) echo "<script>window.open('$rungo', 'my_solpa_user_r', ''); </script>";
					else if( $target_=='url_link_bbstree_solpa_user_r_bottom' ) echo "<script>window.open('$rungo', '_top', ''); </script>";
					else echo "<script>window.open('$rungo', '$target_', ''); </script>";

				} else if( $m_type == 'booktreeupdateM'  ) { // tree_menu_update.php
					$run_mode = 'booktreeupdateM'; //2021-05-28
					include "./tree_create_menu.php";

				} else if( $m_type == 'booktreeupdateM2'  ) { // tree_menu_update.php
					$run_mode = 'booktreeupdateM2'; //2021-05-30
					include "./tree_create_menu.php";

				} else if( $m_type == 'booktreeupdate'  ) { 

					$run_mode = 'cratree_booktreeupdate'; 
					include "./tree_create_menu.php";
                    
					//$rungo = './' . $H_ID . '/'.$sys_pg.'_r1.htm';
					//my_msg("treebom_updw_new Note Tree Completed! make_type:$make_type");
					//if( $make_type=='newcratree_book' ) { 
					//	echo "<script>window.open('$rungo', '_top', ''); </script>";
					//} else if( $target_my=='' ) echo "<script>window.open('$rungo', 'my_solpa_user_r', ''); </script>";
					//else if( $target_=='solpa_user_r_bottom' ) echo "<script>window.open('$rungo', '_top', ''); </script>"; 
					//else echo "<script>window.open('$rungo', '$target_', ''); </script>";
				} else { 
					$run_mode = 'cratree_update';
					include "./tree_create_new_menu.php";
					$rungo = './' . $mid. '/' . $sys_pg. '_r1.htm';
					my_msg("treebom_updw_new TKHER Tree Completed \\n make_type:$make_type");
					if( $make_type=='newcratree' ) { 
						echo "<script>window.open('$rungo', '_top', ''); </script>";
					} else if( $target_my=='' ) 
						echo "<script>window.open('$rungo', 'my_solpa_user_r', ''); </script>";
					else if( $target_=='url_link_tree_solpa_user_r_bottom' ) 
						echo "<script>window.open('$rungo', '_top', ''); </script>";
					else echo "<script>window.open('$rungo', '$target_', ''); </script>";
				}
				*/
 			$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit . "&num=" . $max_num . "&sys_jong=" . $sys_jong . "&board_num=" . $board_num . "&sys_link=" . $sys_link;
			// 2023-11-21 : index_menu.php<-tree_run.php 2023-11-02 add treebom_insw_book :book_num
			echo "<script>window.open('$rungo', '_top', ''); </script>";
				//m_("run_mode:". $run_mode);
	} else {
?> 
		<p><center> update error. </center> 
			<input type='button' value='return' onclick='history.back()'>
<?php
    } // if( isset($sys_subtit) )


	$hostnameA = getenv('HTTP_HOST'); // 2023-08-03 add

function sys_menu_bom_update_curl( $sys_pg ){
	//global $sys_menu, $sys_submenu, $sys_subtit, $sys_link, $sys_menutit, $sys_level, $sys_memo;
	//global $sys_rcnt, $sys_cnt, $sys_disno, $view_lev, $tit_gubun, $book_num ;
	global $H_ID, $H_EMAIL, $hostnameA, $tkher, $config;      

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
		$tabData['data'][$i]['host']        = KAPP_URL_T_; //$rs['sys_comp']; //getenv('HTTP_HOST'); //$hostnameA; 
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

		//m_("i:" . $i . ", sys_pg:" . $sys_pg . ", sys_subtit:" . $sys_subtit); // i:0, sys_pg:dao1691097151

		$i++;
	}
	//m_("i:" . $i . ", sys_pg:" . $sys_pg . ", sys_subtit:" . $sys_subtit); // i:0, sys_pg:dao1691097151
	//i:0, sys_pg:dao1690977209, sys_subtit:
	//i:0, sys_pg:dao1691097151, sys_subtit:

	$key = 'appgenerator';
    $iv = "~`!@#$%^&*()-_=+";

    $sendData = encryptA( $tabData , $key, $iv);

    $url_ = $config['kapp_theme'] . '/_Curl/treebom_updw_curl_ailinkapp.php'; // 전송할 대상 URL

	$curl = curl_init();  //$curl = curl_init( $url_ );
	curl_setopt( $curl, CURLOPT_URL, $url_);
    curl_setopt( $curl, CURLOPT_POST, true);
    curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
        'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
        'iv' => $iv
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	curl_setopt($curl, CURLOPT_FAILONERROR, true);
	
	//echo curl_error($curl); 	//echo "curl --- response: " . $response;
	if( $response == false) {
        $_ms = "treebom_updw_new_menu curl 전송 실패 : " . curl_error($curl);
		echo 'curl 전송 실패 : ' . curl_error($curl);
		//m_(" ------------ : " . $_ms);
    } else {
        //$_ms = 'treebom_updw_new_menu curl 응답 : ' . $response;
		//echo 'curl 응답 : ' . $response;
		//m_(" ============ :" . $_ms);
    }
	// ============ :table30m curl 응답 : --- count:10Error: Update failed{"message":"_api table data 전달 완료"}
    curl_close($curl);

	//m_("curl end--------------- ms: email: " . $H_EMAIL); //exit();
	/*
		$tabData['data'][$i]['sys_pg']      = $sys_pg; 
		$tabData['data'][$i]['sys_menu']    = $sys_menu; 
		$tabData['data'][$i]['sys_submenu'] = $sys_submenu; 
		$tabData['data'][$i]['sys_subtit']  = $sys_subtit; 
		$tabData['data'][$i]['sys_link']    = $sys_link; 
		$tabData['data'][$i]['sys_menutit'] = $sys_menutit; 
		$tabData['data'][$i]['sys_level']   = $sys_level; 
		$tabData['data'][$i]['sys_memo']    = $sys_memo; 
		$tabData['data'][$i]['sys_rcnt']    = $sys_rcnt;
		$tabData['data'][$i]['sys_cnt']     = $sys_cnt;
		$tabData['data'][$i]['sys_disno']   = $sys_disno;
		$tabData['data'][$i]['sys_userid']  = $sys_userid; 
		$tabData['data'][$i]['view_lev']    = $view_lev; 
		$tabData['data'][$i]['tit_gubun']   = $tit_gubun;
		$tabData['data'][$i]['book_num']    = $book_num;
		*/
}

?> 

<html>
</html>