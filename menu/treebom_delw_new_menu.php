<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	if (!$from_session_id) {
		my_msg("login please! ");
		$rungo = "/";	//"cratree_my_list_menu.php";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	/* --------------------------------------------------------
		treebom_delw_new_menu.php -
		call : treebom_update2_new_menu.php
	--------------------------------------------------------- */
	$data  = $_POST['data'];
	$data1 = $_POST['data1'];

	 $rec_i = 0; $mode='';
     if( isset($_POST['mode']) && $_POST['mode']!='' ) $mode= $_POST['mode'];
	 if( $mode == "delete"){
		$xbook_num = $_POST['book_num'];
		$xtype     = $_POST['m_type'];
		$xsys_pg   = $_POST['sys_pg'];
		$xsys_menu = $_POST['sys_menu'];
		$xsys_submenu = $_POST['sys_submenu'];
		$sql = " delete from sys_menu_bom where sys_userid = '$from_session_id' and sys_pg = '$xsys_pg' and sys_submenu like '%$xsys_submenu%' ";
		$err = sql_query( $sql );
		if( !$err ) { 
			m_(" Delete Error, xsys_pg:$xsys_pg , xsys_menu:$xsys_menu, xsys_submenu:$xsys_submenu ");// exit; 
			m_(" Delete Error ");// exit; 
		}
		$sql_upd = " update sys_menu_bom set sys_cnt= sys_cnt - 1 where sys_userid ='$from_session_id' and sys_pg='$xsys_pg' and sys_submenu = '$xsys_menu' ";
		$err = sql_query( $sql_upd );
		if( !$err ) { 
			m_(" Count minus Error ");// exit; 
		}
		$sql = " update webeditor set del='1' where user = '$from_session_id' and num = '$xbook_num' ";
		$err = sql_query( $sql );
		if( !$err ) { 
			m_(" webeditor num:$xbook_num Delete Mark Error ");
		}
		$sql = " update webeditor_comment set del='1' where user = '$from_session_id' and num = '$xbook_num' ";
		$err = sql_query( $sql );
		if( !$err ) { 
			m_(" webeditor_comment num:$xbook_num Delete Mark Error ");
		}
	 } else {
		m_(" Delete mode Error ");
		$rungo = './' . $mid . '/' . $xsys_pg.'_r1.htm';
		echo "<script>window.open('$rungo', '_blank', ''); </script>";
	 }
	$run_mode = 'cratree_delete';
	include "./tree_create_menu.php";
?>      
	<!-- <script>top.location.href('/index4.html');</script> -->
