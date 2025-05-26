<?php
	include_once('../tkher_start_necessary.php');
	/*
	  Link_Table_curl_get_ailinkapp.php
	  작업 결과 : 성공, 2023-07-27
	*/
	//------------------------------------------------------------------------------------------------
	//$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');  
	//if( $connect_db=='dberror' ) { $connect_dbcheck='dberror'; return; } 
	//$select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');  
	//$tkher['connect_db'] = $connect_db; 	sql_set_charset('utf8', $connect_db);
	//------------------------------------
	$key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
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
		$sql = " INSERT into {$tkher['job_link_table_curl']} SET 
			link_title  = '".$tabData['data'][$i]['link_title']."'  , 
			link_url    = '".$tabData['data'][$i]['link_url']."'  , 
			link_type   = '".$tabData['data'][$i]['link_type']."'  , 
			email       = '".$tabData['data'][$i]['email']."'  , 
			kapp_server = '".$tabData['data'][$i]['kapp_server']."'  , 
			user_ip     = '".$tabData['data'][$i]['user_ip']."'  , 
			memo        = '".$tabData['data'][$i]['memo']."'  , 
			up_day      = '".$tabData['data'][$i]['up_day']."' 
		"; 
		//echo "CURL - sql:".$sql;
		$resultA = $connect_db->query( $sql );
        if( !$resultA) {
            throw new Exception("link_table data failed");
        }
        $connect_db->commit();
    } catch (Exception $e) {
        $connect_db->rollback();
        echo "Error: " . $e->getMessage();
    }
    $connect_db->close();


	$message = $message . ", sql: " . $sql;
    $response = array(     // DB create 응답
        'message' => $message
    );
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>