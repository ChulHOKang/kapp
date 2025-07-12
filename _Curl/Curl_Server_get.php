<?php
	include_once('../tkher_start_necessary.php');
	/*
		Curl_Server_get.php : UPDATE {$tkher['config_table']}
		: kapp_dbcon_create.php - DB_curl_get_ailinkapp.php - Curl_Server_get.php
		: $curl_server = $curl_server1 . "^" . $curl_server2;
		  $sql = " UPDATE {$tkher['config_table']} SET kapp_theme= '".$curl_server."' WHERE kapp_title= 'K-App'	";

		: test : Curl_Server_send.php - test pg
	*/
    $responseData = $_POST['tabData']; //json_decode($_POST['tabData'], true);
    $kapp_iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $kapp_key, $kapp_iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = 'Curl_Server_get - api tabData get OK!';
    } else {
        $message = 'Curl_Server_get - api tabData get ERROR!';
    }
    $connect_db->begin_transaction();
    try {
		$i = 0;
		$day = date("Y-m-d H:i:s", time());
		$curl_server1 = $tabData['data'][$i]['curl_server1'];
		$curl_server2 = $tabData['data'][$i]['curl_server2'];
		$curl_server = $curl_server1 . "^" . $curl_server2;
		$sql = " UPDATE {$tkher['config_table']} SET kapp_theme= '".$curl_server."' WHERE kapp_title= 'K-App'	";
		$resultA = $connect_db->query( $sql );
		if( !$resultA ) {
			throw new Exception("pg_curl_get_ailinkapp.php : throw new Exception - Program data failed");
		}
		$connect_db->commit();
    } catch (Exception $e) {
        $connect_db->rollback();
        echo "Error: " . $e->getMessage();
    }
    $connect_db->close();
    $response = array(
        'message' => $message
    );
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
	return $response;
?>