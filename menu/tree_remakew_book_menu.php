<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL = $member['mb_email'];
	else $H_EMAIL = '';

	/*
		tree_remakew_book_menu.php : Note Tree Remake 
			call : tree_remake_book_menu.php
			run : tree_create_menu.php
	*/
	if ( !$H_ID ) {
		my_msg(" Please login. ");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	$make_type		= $_POST['make_type']; 
	//m_("tree_remakew_book_menu - make_type:$make_type"); //tree_remakew_book_menu - make_type:booktreeupdateM2

	if( isset($_POST['make_type'] )){
		$mode		= $_POST['mode'];
		$mid		= $_POST['mid'];
		$sys_pg		= $_POST['sys_pg'];
		$book_num	= $_POST['book_num'];
		$sys_subtit	= $_POST['sys_subtit'];		
		$sys_link	= $_POST['sys_link'];
		$sys_memo	= $_POST['sys_memo'];
		$target_	= $_POST['target_'];
	} else {
		$mode = '';
		$mid = '';
		$sys_pg	= '';
		$sys_subtit = '';
		$sys_subtit = '';
		$sys_link = '';
		$sys_memo = '';
		$target_ = '';
	}


	if( $H_ID !== $mid && $H_LEV < 8) {
		my_msg(" It is not a constructor. ");	//생성자가 아닙니다.
		//$rungo = './' . $mid . '/' . $sys_pg . '_r1.htm';
		echo "<script>window.open( './' , '_top', ''); </script>";
		exit;
	}

	$sql_a = "update {$tkher['sys_menu_bom_table']} set sys_subtit='$sys_subtit', sys_link='$sys_link', sys_memo='$sys_memo' where sys_userid='$mid' and sys_pg='$sys_pg' and sys_level='mroot' ";
	sql_query( $sql_a );  
	$sql = "update {$tkher['job_link_table']} set user_name='$sys_subtit' where user_id='$mid' and job_name='$sys_pg'";
	sql_query( $sql ); 
	$sql = "update {$tkher['webeditor_table']} set title='$sys_subtit' where user='$mid' and num='$book_num'";
	sql_query( $sql ); 
	$fontcolor	=$_POST['fontcolor'];
	$fontface	=$_POST['fontface'];
	$fontsize	=$_POST['fontsize'];
	$bgcolor	=$_POST['bgcolor'];

	$sql2 = "update {$tkher['menuskin_table']} set sys_subtit='$sys_subtit', bgcolor='$bgcolor', fontcolor='$fontcolor', fontface='$fontface', fontsize='$fontsize' where user_id='$mid' and sys_pg='$sys_pg' ";
	sql_query( $sql2); 
	$xsys_pg = $sys_pg ;

 			///////////< Note tree file Re create >//////////////  
			$run_mode = 'tree_remakew_book';
			// 2024-06-05 작업막음, include "./tree_create_menu.php";  
			/////////////////////////////////////////////
 			$rungo = './' . $mid . '/' . $sys_pg.'_r1.htm';

			//my_msg("tree_remakew_book Note Tree Completed. make_type:$make_type, post:" . $_POST['make_type']);
			//tree_remakew_book Note Tree Completed. make_type:booktreeupdateM2, post:booktreeupdateM2

			/*if( $make_type=='newcratree_book' ) {	// treebom_insert2_new.php 에서 콜.
				 echo "<script>window.open('$rungo', '_top', ''); </script>";
			} else if( $make_type =='booktreeupdateM2' ) { //booktreeupdateM2 여기로 안옴.
 				$rungo = './index_menu.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit;
 				//$rungo = '../tree_menu_guest.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit;
				//m_("-----------" . $rungo);
			     echo "<script>window.open('$rungo', '_top', ''); </script>";
			} else if( $target_my=='' ) {
			     echo "<script>window.open('$rungo', 'my_solpa_user_r', ''); </script>";
			} else if( $target_=='solpa_user_r_bottom' ) {
			     echo "<script>window.open('$rungo', '_top', ''); </script>";
			} else echo "<script>window.open('$rungo', '$target_', ''); </script>";
			*/
?> 

