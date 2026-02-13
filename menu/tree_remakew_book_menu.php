<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");
	$ip = $_SERVER['REMOTE_ADDR'];
	if( $H_ID ==''){
		m_(" Please login. ");
		$rungo = "../";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	} else {
		if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
		else $H_LEV = 0;
		if( isset($member['mb_email']) ) $H_EMAIL = $member['mb_email'];
		else $H_EMAIL = '';
	}

	/*
		tree_remakew_book_menu.php : Note Tree Remake 
			call : tree_remake_book_menu.php
			run : tree_create_menu.php
	*/
	if ( !$H_ID ) {
		m_(" Please login. ");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	if( isset($_POST['make_type']) && $_POST['make_type']!='' ) $make_type= $_POST['make_type']; 
	else $make_type= ''; //tree_remakew_book_menu - make_type:booktreeupdateM2
	$mode = '';
	$mid = '';
	$sys_pg	= '';
	$sys_subtit = '';
	$sys_subtit = '';
	$sys_link = '';
	$sys_memo = '';
	$target_ = '';
	if( isset($_POST['mode'])) $mode= $_POST['mode'];
	if( isset($_POST['mid'])) $mid= $_POST['mid'];
	if( isset($_POST['sys_pg'])) $sys_pg= $_POST['sys_pg'];
	if( isset($_POST['book_num'])) $book_num= $_POST['book_num'];
	if( isset($_POST['sys_subtit'])) $sys_subtit= $_POST['sys_subtit'];		
	if( isset($_POST['sys_link'])) $sys_link= $_POST['sys_link'];
	if( isset($_POST['sys_memo'])) $sys_memo= $_POST['sys_memo'];
	if( isset($_POST['target_'])) $target_= $_POST['target_'];
	if( $H_ID != $mid && $H_LEV < 8) {
		m_(" It is not a constructor. ");
		echo "<script>window.open( '../' , '_top', ''); </script>";
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
	$run_mode = 'tree_remakew_book';

	$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit;
	echo "<script>window.open('$rungo', '_top', ''); </script>";
?> 

