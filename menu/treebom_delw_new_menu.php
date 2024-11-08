<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	//require_once ("../../cratree/func/my_func.php");
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

	 $rec_i = 0;
     $mode      = $_POST['mode'];
	 m_("mode:$mode");
	 if($mode == "delete"){
		$xbook_num = $_POST['book_num'];
		$xtype     = $_POST['m_type'];
		$xsys_pg   = $_POST['sys_pg'];
		$xsys_menu = $_POST['sys_menu'];
		$xsys_submenu = $_POST['sys_submenu'];
		//$xsys_level   = $sys_level[$rec_i];

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
		//$sql = " delete from webeditor where user = '$from_session_id' and num = '$xbook_num' ";
		$sql = " update webeditor set del='1' where user = '$from_session_id' and num = '$xbook_num' ";
		$err = sql_query( $sql );
		if( !$err ) { 
			m_(" webeditor num:$xbook_num Delete Mark Error ");// exit; 
		}
		$sql = " update webeditor_comment set del='1' where user = '$from_session_id' and num = '$xbook_num' ";
		$err = sql_query( $sql );
		if( !$err ) { 
			m_(" webeditor_comment num:$xbook_num Delete Mark Error ");// exit; 
		}
	 } else {
		m_(" Delete mode Error ");// exit; 
			$rungo = './' . $mid . '/' . $xsys_pg.'_r1.htm';// solpa_user_r
			echo "<script>window.open('$rungo', '_blank', ''); </script>";
	 }
/*	
	if ( $xsys_level == "mroot" ) {
		//$sql = " delete  from sys_menu_bom where sys_pg = '$xsys_pg' and sys_submenu = '$xsys_menu' ";
		//// �� ���� �޴� ( sys_level = mroot ) �� ���� Ʈ���� ���� �Ҽ� ���� �Ѵ�. ////
		//mysql_query($sql,$conn);
		echo "<br> <font color=red >�� �ֻ��� �޴��� ���� �ϽǼ� �����ϴ�.	</font>";
		echo "<br> <font color=red >�� ������ �޴��� ��� ���� �Ͻ� ������ �����Ͻ� �� �ֽ��ϴ�.	</font>";
    } else {
		echo "<br> <font color=red >�� data1 = $data1	</font>";
		$sql = " delete from sys_menu_bom where sys_userid = '$from_session_id' and sys_submenu like '%$data1%' ";
		
		$err = sql_query( $sql );
		if( $err ) { 
			//echo" �� ��! "; exit; 
		}

		//$sql = " delete  from sys_menu_bom where sys_userid ='$from_session_id' and sys_pg = '$xsys_pg' and sys_menu like %'$xsys_submenu'% ";
		//mysql_query($sql,$conn);

		//$sql_upd = " update sys_menu_bom set sys_cnt= sys_cnt - 1 where sys_userid ='$from_session_id' and sys_pg='$xsys_pg' and sys_submenu = '$xsys_menu' ";

		//$sql_upd = " update sys_menu_bom set sys_cnt= sys_cnt - 1 where sys_userid ='$from_session_id' and sys_pg='$xsys_pg' and sys_submenu = '$data1' ";
		
		//����� ���� 2008.11.6 $sql_upd = " update sys_menu_bom set sys_cnt= sys_cnt - 1 where sys_userid ='$from_session_id' and sys_submenu='$xsys_level' ";
		//����� ���� mysql_query($sql_upd,$conn); 
	}
*/
	$run_mode = 'cratree_delete';
	///////////< tree file create >////////////
	include "./tree_create_menu.php";
	//include "./tree_create_new_menu.php";
	///////////////////////////////////////////
	//if($from_session_id == 'guest') {
?>      
	<!-- <script>top.location.href('/index4.html'); alert('ĭƮ�� �޴��� ���� �Ǿ����ϴ�!');</script> -->
<?php
	//} else {	
?>
	<!-- <script>top.location.href('./g_source/<?=$from_session_id?>_r1.htm'); alert('ĭƮ�� ���� �Ǿ����ϴ�!');</script> -->
<?php
	//}	
?>
