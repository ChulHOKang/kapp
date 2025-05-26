<?php
	include '../tkher_start_necessary.php';
	/*
	  작업 결과 : 성공, 2023-07-27
	*/
	//------------------------------------------------------------------------------------------------------------------
	$key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
    $responseData = json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $key, $iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = '_api DB data OK';
    } else {
        $message = '_api DB data Fail';
    }

	//$count = count( $tabData->data );   // json_encode, json_decode 실행 전에 사용방법.
	//$count = count( $tabData['data'] ); // echo "--- count:" . $count;
	$message = $message . ', count: ';  // . $count;
/*
    $connect_db->begin_transaction();
    try {
		$i = 0;
		$sql = " select * from kapp_DB_curl group by server_name"; 
		//echo "CURL - sql:".$sql;
		$resultA = $connect_db->query( $sql );
        if( !$resultA) {
            throw new Exception("kapp_DB data failed");
        }
        $connect_db->commit();
    } catch (Exception $e) {
        $connect_db->rollback();
        echo "Error: " . $e->getMessage();
    }
    $connect_db->close();
	*/
	$snm = "";
	$sql = " select * from kapp_DB_curl group by server_name"; 		//echo "CURL - sql:".$sql;
	$ret = $connect_db->query( $sql );
	if( !$ret ) {
		throw new Exception("kapp_DB data failed");
	} else {
		while( $rs = sql_fetch_array($ret) ){
			$snm = $rs['server_name'] . "|" . $snm;
		}
	}

	echo $snm;
	//$message = $message . ", sql: " . $sql;
    $response = array(     // DB create 응답
        'message' => $snm
    );
    header('Content-Type: application/json');
    //  echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>