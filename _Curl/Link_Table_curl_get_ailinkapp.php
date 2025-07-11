<?php
	include_once('../tkher_start_necessary.php');
	/*
		Link_Table_curl_get_ailinkapp.php
	*/
	//------------------------------------------------------------------------------------------------
	//$connect_db = sql_connect(KAPP_MYSQL_HOST, KAPP_MYSQL_USER, KAPP_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');  
	//if( $connect_db=='dberror' ) { $connect_dbcheck='dberror'; return; } 
	//$select_db  = sql_select_db(KAPP_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');  
	//$tkher['connect_db'] = $connect_db; 	sql_set_charset('utf8', $connect_db);
	//------------------------------------
    $responseData = $_POST['tabData'];  //json_decode($_POST['tabData'], true);
    $kapp_iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $kapp_key, $kapp_iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = '_api DB data OK, ';
    } else {
        $message = '_api DB data Fail, ';
    }
			$kapp_theme0 = '';
			$kapp_theme1 = '';
			$kapp_theme = $config['kapp_theme'];
			$kapp_theme = explode('^', $kapp_theme );	//$n = sizeof($server_);
			$kapp_theme0 = $kapp_theme[0];
			$kapp_theme1 = $kapp_theme[1];

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
            throw new Exception("Link_Table_curl_get_ailinkapp.php : throw new Exception - link_table data failed");
        }
		if( isset( $kapp_theme0) && $kapp_theme0 !=='' ) Link_Table_curl_send_tabData( $kapp_theme0, $tabData );
		if( isset( $kapp_theme1) && $kapp_theme1 !=='' ) Link_Table_curl_send_tabData( $kapp_theme1, $tabData );

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