<?php
include_once('../tkher_start_necessary.php');
// add_admin_infor_r.php
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( $mode === 'add_admin_info'){	//print_r($_POST);
		Config_Record_Update();
	}else{
		m_(" error confirm approche "); 
	}

function Config_Record_Update() {
    global $tkher;
    global $member;

    $password = get_encrypt_stringA($_POST['mb_password']);
    $query = " UPDATE {$tkher['tkher_member_table']} SET  "; 
    $query = $query . "mb_password= '" . $password . "' ";   
    $query = $query . ",mb_name= '" . $_POST['mb_name'] . "' ";   
    $query = $query . ",mb_sex= '" . $_POST['mb_sex'] . "' ";   
    $query = $query . ",mb_birth= '" . $_POST['mb_birth_number'] . "' ";   
    $query = $query . ",mb_hp= '" . $_POST['mb_hp_number'] . "' ";   
    $query = $query . ",mb_email_certify= '" . date("Y-m-d H:i:s") . "' ";  // mb_email_certify 추가
    $query = $query . " where mb_id = '".$member['mb_id']."' ";   

    $ret = sql_query( $query );
    if(!$ret) {
        m_("Error -confirm. ---".$query);
        echo "<script>window.open('', '_self').close();</script>";
        exit;
    } else {
        m_("OK -");
        echo "<script>window.open('', '_self').close();</script>";
        exit;
    }
    
}
?>