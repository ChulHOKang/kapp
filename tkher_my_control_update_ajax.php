<?php
include_once('./tkher_start_necessary.php');

if($_POST['mode'] === 'tkher_my_control_update'){
    //print_r($_POST);
    /* $column = json_decode($_POST['column'], true);
    $data = json_decode($_POST['data'], true); */
    $column = json_decode(getJsonText($_POST['column']), true);
    $data = json_decode(getJsonText($_POST['data']), true);
    Record_Update($column, $data);
}

function Record_Update($_column, $_data) {
    global $tkher;
        
    $query = " UPDATE {$tkher['tkher_my_control_table']} SET  "; 
    $query = $query . $_column."= '" . $_data . "' ";   
    //$query = $query . " where kapp_title = 'K-App' ";   // kapp_title 키로 사용

    //echo json_encode($query);

    $ret = sql_query( $query );
    if(!$ret) {
        echo json_encode("{$tkher['tkher_my_control_table']} 업데이트에 문제가 발생했습니다. ---".$query);
        exit;
    } else {
        echo json_encode("저장 완료");
        exit;
    }
    
}

function getJsonText($jsontext) { // jsonText '\' 값 제거 
    return str_replace("\\\"", "\"", $jsontext);
    }
?>