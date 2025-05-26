<?php
	include '../tkher_start_necessary.php';
	/*
	  작업 결과 : 성공, 2023-07-27
	  DB_curl_get_ailinkapp.php
	*/
	//------------------------------------------------------------------------------------------------------------------
	$key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
    $responseData = $_POST['tabData']; //   $responseData = json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];

    $tabData =  decryptA($responseData, $key, $iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ) $message = '_api DB data OK';
    else $message = '_api DB data Fail';

	$connect_db->begin_transaction();
    try {
		$i = 0;
		$server_name = $tabData['data'][$i]['server_name'];
		$query = "SELECT kapp_memo from kapp_DB_curl where server_name='" .$server_name. "' ";
		$row = sql_fetch( $query );
		if( $row > 0 ){
			$upday = date("Y-m-d H:i:s");
			$memo = $upday. ":Setup Update : " . $row['kapp_memo'];
			$sql = " UPDATE kapp_DB_curl SET 
				kapp_dbhost   = '".$tabData['data'][$i]['kapp_dbhost']."'  , 
				kapp_dbname   = '".$tabData['data'][$i]['kapp_dbname']."'  , 
				kapp_dbuser   = '".$tabData['data'][$i]['kapp_dbuser']."'  , 
				admin_email   = '".$tabData['data'][$i]['admin_email']."'  , 
				admin_pw      = '".$tabData['data'][$i]['pw_md5']."'  , 
				kapp_ip       = '".$tabData['data'][$i]['kapp_ip']."'  , 
				server_name   = '".$tabData['data'][$i]['server_name']."'  , 
				curl_server   = 'https://fation.net/kapp'  , 
				kapp_memo     = '".$memo."'  
				where server_name='" .$server_name. "' 
			"; 
			$resultA = $connect_db->query( $sql );
			if( !$resultA) {
				throw new Exception("Update kapp_DB_curl failed");
			} else echo "--- Update OK";
		} else {
			$sql = " INSERT kapp_DB_curl SET 
				kapp_dbhost   = '".$tabData['data'][$i]['kapp_dbhost']."'  , 
				kapp_dbname   = '".$tabData['data'][$i]['kapp_dbname']."'  , 
				kapp_dbuser   = '".$tabData['data'][$i]['kapp_dbuser']."'  , 
				admin_email   = '".$tabData['data'][$i]['admin_email']."'  , 
				admin_pw      = '".$tabData['data'][$i]['pw_md5']."'  , 
				kapp_ip       = '".$tabData['data'][$i]['kapp_ip']."'  , 
				server_name   = '".$tabData['data'][$i]['server_name']."'  , 
				curl_server   = 'https://fation.net/kapp'  , 
				kapp_memo          = '".$tabData['data'][$i]['memo']."'  , 
				upday         = '".$tabData['data'][$i]['upday']."' 
			"; 
			$resultA = $connect_db->query( $sql );
			if( !$resultA) {
				throw new Exception("Insert kapp_DB_curl failed");
			} else echo "Insert OK";
		}
        $connect_db->commit();
    } catch (Exception $e) {
        $connect_db->rollback();
        echo "Error: " . $e->getMessage();
    }
    $connect_db->close();
	
    //$response = array(     // DB create 응답
    //    'message' => $message
    //);
    //header('Content-Type: application/json');
    //echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>