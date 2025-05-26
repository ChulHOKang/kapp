<?php
include_once('../tkher_start_necessary.php');

//m_("mode: " . $_POST['mode']);

$mode = $_POST['mode'];

echo json_encode( "------SQL: mode: "  . $mode);

if( $mode === 'pri_contect_update'){

    /*
	 $column = json_decode($_POST['column'], true);
    $data = json_decode($_POST['data'], true); 
   */
//    $column = json_decode(getJsonTextX($_POST['column']), true);
//   $data = json_decode(getJsonTextX($_POST['data']), true);

    $column = json_decode(getJsonTextX($_POST['column']), true);
    $data = json_decode(getJsonTextX($_POST['data']), true);

	//$column = $_POST['column'];
    //$data = $_POST['data'];
    Record_Update($column, $data);
}

function Record_Update($_column, $_data) {
    global $tkher;
        
    $query = " UPDATE {$tkher['pri_contect_table']} SET  "; 
    $query = $query . $_column." = '" . $_data . "' where seqno=1 ";   
    //$query = $query . " where kapp_title = 'K-App' ";   // kapp_title 키로 사용

    //echo  "SQL: " . $query;

    $ret = sql_query( $query );
    if(!$ret) {
        //echo json_encode("{$tkher['pri_contect_table']} 업데이트에 문제가 발생했습니다. ---".$query);
        exit;
    } else {
        //echo "save OK!";
        exit;
    }
    
}

function getJsonTextX($jsontext) { // jsonText '\' 값 제거 
    return str_replace("\\\"", "\"", $jsontext);
    }
?>