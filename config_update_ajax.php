<?php
include_once('./tkher_start_necessary.php');

if($_POST['mode'] === 'config_update'){
    //print_r($_POST);
    /*
	config_update_ajax.php
	ksd39673976_1711436495_kapp_config.php - call
	
	$column = json_decode($_POST['column'], true);
    $data = json_decode($_POST['data'], true); 
	*/
    $column = json_decode(getJsonText($_POST['column']), true);
    $data = json_decode(getJsonText($_POST['data']), true);

    $enc_check = Enc_check($column); // 암호화 체크

    $key = 'modumoa';
    $iv = '~!@#$%^&*()_+';

    if($enc_check) $data = Encrypt($data, $key, $iv);

    //echo json_encode($data);

    Record_Update($column, $data);
}

function Record_Update($_column, $_data) {
    global $tkher;
        
    $query = " UPDATE {$tkher['config_table']} SET  "; 
    $query = $query . $_column."= '" . $_data . "' ";   
    //$query = $query . " where kapp_title = 'K-App' ";   // kapp_title 키로 사용

    //echo json_encode($query);

    $ret = sql_query( $query );
    if(!$ret) {
        echo json_encode("{$tkher['config_table']} 업데이트에 문제가 발생했습니다. ---".$query);
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
    if($_column == 'kapp_googl_shorturl_apikey' || $_column == 'kapp_kakao_js_apikey') return true;
    else return false;
}
?>