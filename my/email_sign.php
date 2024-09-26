<?php
/* include './coupon/tkher_db_lib.php';		
include './coupon/tkher_dbcon_Table.php'; */
include_once('../tkher_start_necessary.php');

if($_POST['mode'] != 'email_sign'){
    m_("잘못된 접근입니다.");
    echo "<script>window.history.back();</script>";
	exit;
}

$mb_id = json_decode(getJsonText($_POST['mb_id']), true);
$email = json_decode(getJsonText($_POST['email']), true);
$code = json_decode(getJsonText($_POST['code']), true);

/* echo $email;
echo "<br>"; */

/* $response = array(
    'email' => $email,
    'code' => $code
);
echo json_encode($response);
exit; */

//일련번호관리
$SQL = " select sign_code from ksd39673976_1703122436 where email = '".$email."' order by seqno desc ";
$result = sql_query($SQL);
$row = sql_fetch_array($result);

//echo $row['created_at'];

//echo $code;

if (!$row)  {
    $response = array(
        'message' => 'null_email'
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

        Update_email_certify($mb_id, $email); // 이메일 인증 업데이트
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

function Update_email_certify($_mb_id, $_email) {
    global $tkher;
    $query = " UPDATE {$tkher['tkher_member_table']} SET  ";  
    $query = $query . "mb_email_certify= '" . date("Y-m-d H:i:s") . "' ";
    $query = $query . " where mb_id = '".$_mb_id."' and mb_email = '".$_email."' ";  
    
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