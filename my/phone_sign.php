<?php
/* include './coupon/tkher_db_lib.php';		
include './coupon/tkher_dbcon_Table.php'; */
include_once('../tkher_start_necessary.php');

if($_POST['mode'] != 'phone_sign'){
    m_("잘못된 접근입니다.");
    echo "<script>window.history.back();</script>";
	exit;
}

//$phone = json_decode($_POST['phone'], true);
$mb_id = json_decode(getJsonText($_POST['mb_id']), true);
$phone = json_decode(getJsonText($_POST['phone']), true);

$code = json_decode(getJsonText($_POST['code']), true);

/* echo $email;
echo "<br>"; */

//일련번호관리
$SQL = " select sign_code from ksd39673976_1703122436 where phone = '".$phone."' order by seqno desc ";
$result = sql_query($SQL);
$row = sql_fetch_array($result);

//echo $row['created_at'];

//echo $code;

if (!$row)  {
    $response = array(
        'message' => 'null_phone'
    );
} else if ($row['sign_code'] != $code)  {
    $response = array(
        'message' => 'null_code'
    );
} else if ($row['sign_code'] == $code) {
    $query = " UPDATE ksd39673976_1703122436 SET  ";    
    $query = $query . "status= 'T' ";   
    $query = $query . ",sign_date= '".date("Y-m-d h:m:s")."' ";   
    $query = $query . " where sign_code='".$code."' ";   
    $ret = sql_query( $query );   
    if( $ret ) {   
        $response = array(
            'message' => 'sign'
        );

        Update_mb_certify($mb_id, $phone); // 연락처 인증 업데이트
    } else {
        $response = array(
            'message' => 'sql_error'
        );
    }
            
} else {
    $response = array(
        'message' => 'error'
    );  
}

/* $response = array(
    'serialNo' => $serialNo,
    'code' => $code
); */

echo json_encode($response);

function Update_mb_certify($_mb_id, $_phone) {
    global $tkher, $member;
    $query = " UPDATE {$tkher['tkher_member_table']} SET  ";  
    $query = $query . "mb_certify= '" . date("Y-m-d H:i:s") . "' ";
    $query = $query . " where mb_id = '".$_mb_id."' and mb_hp = '".$_phone."' ";  
    
    $ret = sql_query( $query );
    if(!$ret) {
        $response = array(
            'message' => $query
        );
        echo json_encode($response);
        exit;
    }
}

function getJsonText($jsontext) { // jsonText '\' 값 제거 
    return str_replace("\\\"", "\"", $jsontext);
    }
?>