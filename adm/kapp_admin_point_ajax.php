<?php 
  include_once('../tkher_start_necessary.php');
  /*
	ulink_ajax.php : ulink_list.php 에서 콜 사용.
	$mode_insert === 'Encryption_data'
	$mode_insert === 'Decryption_data'
	$mode_insert === 'Group_insert'
	$mode_insert === 'Group_update'

  */
	 $H_ID	= get_session("ss_mb_id"); 
	if( isset( $H_ID) && $H_ID !=='') {
		$H_LEV	= $member["mb_level"];   //"ss_mb_id";	//connect_count('ulist', $H_ID, 0);	// log count
		if( $H_LEV < 8 ) {
			m_("You do not have permission to do this"); return false;
		}
	} else {
		$H_ID="";
		echo "Login Please!"; return false;
	}
	$mode_insert =$_POST['mode_insert'];  //echo " mode_insert:" . $mode_insert . "<br>";

	$day = date("Y-m-d H:i:s");

	if( $mode_insert === 'Point_Admin_Pay'){

		$mb_id =$_POST['mb_id']; 
		$po_point =$_POST['po_point']; 
		$link_ = KAPP_URL_T_ . "/adm/point_list_adm.php";
		$po_content =$_POST['po_content'] . ", ".$link_ ;
		$pay_tit = $H_ID. ', admin@point_list_adm';
		insert_point_app( $mb_id, $po_point,  $po_content, $pay_tit);
		echo " Payment completed";

	} else {
		m_("This is the wrong approach."); return false;
	}

?>