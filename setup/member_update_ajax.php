<?php
include_once('../tkher_start_necessary.php');

if($_POST['mode'] === 'member_update'){
    //print_r($_POST);
    /* $column = json_decode($_POST['column'], true);
    $data = json_decode($_POST['data'], true); */
    $column = json_decode(getJsonText($_POST['column']), true);
    $data = json_decode(getJsonText($_POST['data']), true);
    $mb_id = json_decode(getJsonText($_POST['mb_id']), true);

    $enc_check = Enc_check($column); // 암호화 체크

    if($enc_check) $data = get_encrypt_stringA($data);

    //echo json_encode($data);

    Record_Update($column, $data, $mb_id);
}

function Record_Update($_column, $_data, $_mb_id) {
    global $tkher;
        
    $query = " UPDATE {$tkher['tkher_member_table']} SET  "; 
    $query = $query . $_column."= '" . $_data . "' ";   
    $query = $query . " where mb_id = '".$_mb_id."' ";

    //echo json_encode($query);

    $ret = sql_query( $query );
    if(!$ret) {
        echo json_encode("{$tkher['tkher_member_table']} 업데이트에 문제가 발생했습니다. ---".$query);
        exit;
    } else {
        echo json_encode("저장 완료");
        exit;
    }
    
}

function getJsonText($jsontext) { // jsonText '\' 값 제거 
    return str_replace("\\\"", "\"", $jsontext);
    }

function Enc_check($_column){
    if($_column == 'mb_password') return true;
    else return false;
}
?>