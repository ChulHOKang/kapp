<?php
	include_once('../tkher_start_necessary.php');
	/*
	  Server_curl_get_ailinkapp.php
	*/
	//------------------------------------------------------------------------------------------------
	//$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');  
	//if( $connect_db=='dberror' ) { $connect_dbcheck='dberror'; return; } 
	//$select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');  
	//$tkher['connect_db'] = $connect_db; 	sql_set_charset('utf8', $connect_db);
	//------------------------------------
	$key = 'appgenerator';
    $responseData = $_POST['tabData'];  //json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $key, $iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = '_api DB data OK, ';
    } else {
        $message = '_api DB data Fail, ';
    }
    $connect_db->begin_transaction();
    try {
		$i = 0;
		$admin_id = $tabData['data'][$i]['admin_id'];
		$admin_pw = $tabData['data'][$i]['admin_pw'];
		$server_name = $tabData['data'][$i]['server_name'];

		$query = "SELECT kapp_memo from kapp_DB_curl where server_name='" .$server_name. "' and admin_email='" .$admin_id. "' and admin_pw = '". md5($admin_pw)."' ";
		$row = sql_fetch( $query );
		$upday = date("Y-m-d H:i:s");
		$memo = $upday. ":curl server Update : " . $row['kapp_memo'];
		$sql = " UPDATE kapp_DB_curl SET 
			curl_server = '".$tabData['data'][$i]['server_url']."'  , 
			kapp_memo   = '".$memo."' 
			where  server_name='" .$server_name. "' and admin_email = '".$admin_id."' and admin_pw = '". md5($admin_pw)."'
		"; 		//echo "CURL - sql:".$sql;
		$resultA = $connect_db->query( $sql );
        if( !$resultA) {
			echo "Update ERROR - server curl";
            throw new Exception("link_table data failed");
        } else echo "Update OK!";
        $connect_db->commit();
    } catch (Exception $e) {
        $connect_db->rollback();
        echo "Error: " . $e->getMessage();
    }
    $connect_db->close();


	//$message = 'OK!'; //$message . ", sql: " . $sql;
    //$response = array(     // DB create 응답
    //    'message' => $message
    //);
    header('Content-Type: application/json');
    //echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>