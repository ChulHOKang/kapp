<?php
include_once('./tkher_start_necessary.php');

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( $mode === 'add_info'){	//print_r($_POST);
		Record_Update();
	}

function Record_Update() {
    global $tkher;
    global $member;

    $password = get_encrypt_stringA($_POST['mb_password']);
    /* $password = get_encrypt_stringA('modumoa');
    m_("pass : ".$password); */
        
    // 계정 정보 업데이트
    $query = " UPDATE {$tkher['tkher_member_table']} SET  "; 
    $query = $query . "mb_password= '" . $password . "' ";   
    $query = $query . ",mb_name= '" . $_POST['mb_name'] . "' ";   
    $query = $query . ",mb_sex= '" . $_POST['mb_sex'] . "' ";   
    $query = $query . ",mb_birth= '" . $_POST['mb_birth_number'] . "' ";   
    $query = $query . ",mb_hp= '" . $_POST['mb_hp_number'] . "' ";   
    $query = $query . ",mb_zip1= '" . $_POST['mb_zip1'] . "' ";   
    $query = $query . ",mb_addr1= '" . $_POST['mb_addr1'] . "' ";   
    $query = $query . ",mb_addr2= '" . $_POST['mb_addr2'] . "' ";   
    $query = $query . ",mb_email_certify= '" . date("Y-m-d H:i:s") . "' ";  // mb_email_certify 추가
    $query = $query . " where mb_id = '".$member['mb_id']."' ";   

    //echo $query;

    $ret = sql_query( $query );
    if(!$ret) {
        m_("회원 정보 업데이트에 문제가 발생했습니다. ---".$query);
        echo "<script>window.open('', '_self').close();</script>";
        exit;
    } else {
        m_("저장 완료");
        echo "<script>window.open('', '_self').close();</script>";
        exit;
    }
    
}
?>