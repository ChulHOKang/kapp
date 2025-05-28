<?php
	include_once('../tkher_start_necessary.php');
	/*
	  작업 결과 : 성공, 2023-07-27
	*/
    $key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
    $responseData = $_POST['tabData']; //json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $key, $iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = '_api program data 전달 완료';
    } else {
        $message = '_api program data 전달 실패';
    }
    $connect_db->begin_transaction();
    try {
		$i = 0;
		$sql1 = "SELECT * from {$tkher['table10_pg_curl_table']} WHERE 
			email      = '".$tabData['data'][$i]['email']."' and
			pg_code    = '".$tabData['data'][$i]['pg_code']."' 
		";
		$result = $connect_db->query( $sql1 ); // $result = sql_query( $sql1 );
		$row = sql_num_rows($result);          // echo "count_:" . $row;
		if( $row > 0 ) {
			$day = date("Y-m-d H:i:s", time());
			if( isset($tabData['data'][$i]['item_cnt']) == '' || $tabData['data'][$i]['item_cnt'] == NULL) $tabData['data'][$i]['item_cnt'] = 0;
			$sql = " UPDATE {$tkher['table10_pg_curl_table']} SET 
				item_cnt   = '".$tabData['data'][$i]['item_cnt']."'  , 
				if_type    = '".$tabData['data'][$i]['if_type']."'  , 
				if_data    = '".$tabData['data'][$i]['if_data']."'  , 
				relation_data    = '".$tabData['data'][$i]['popdata_db']."'  , 
				item_array       = '".$tabData['data'][$i]['item_array']."' ,
				upday       = '".$day."' 
				WHERE
						email      = '".$tabData['data'][$i]['email']."' and
						pg_code    = '".$tabData['data'][$i]['pg_code']."' 
			";
		} else {
			if( isset($tabData['data'][$i]['item_cnt']) == '' || $tabData['data'][$i]['item_cnt'] == NULL) $tabData['data'][$i]['item_cnt'] = 0;
			$sql = " INSERT {$tkher['table10_pg_curl_table']} SET 
				pg_code   = '".$tabData['data'][$i]['pg_code']."'  , 
				pg_name   = '".$tabData['data'][$i]['pg_name']."'  , 
				tab_enm    = '".$tabData['data'][$i]['tab_enm']."'  , 
				tab_hnm    = '".$tabData['data'][$i]['tab_hnm']."'  , 
				group_code = '".$tabData['data'][$i]['group_code']."'  , 
				group_name = '".$tabData['data'][$i]['group_name']."'  , 
				userid     = '".$tabData['data'][$i]['userid']."'  , 
				host       = '".$tabData['data'][$i]['host']."'  , 
				email      = '".$tabData['data'][$i]['email']."'  , 
				item_cnt   = ".$tabData['data'][$i]['item_cnt']."  , 
				if_type    = '".$tabData['data'][$i]['if_type']."'  , 
				if_data    = '".$tabData['data'][$i]['if_data']."'  , 
				pop_data = '".$tabData['data'][$i]['popdata_db']."'  , 
				sys_link   = '".$tabData['data'][$i]['sys_link']."'  , 
				relation_data   = '".$tabData['data'][$i]['relation_data']."'  , 
				relation_type   = '".$tabData['data'][$i]['relation_type']."'  , 
				item_array = '".$tabData['data'][$i]['item_array']."' 
			"; 
			//sys_link ="https://" . $hostnameA . "/t/tkher_program_data_list.php?pg_code=" . $pg_code;
		}
		//echo "sql:".$sql;
		$resultA = $connect_db->query( $sql );
        // 롤백
        if (!$resultA) {
            throw new Exception("Program data failed");
        }
        $connect_db->commit();
    } catch (Exception $e) {
        $connect_db->rollback();
        echo "Error: " . $e->getMessage();
    }
    $connect_db->close();

    // program create 응답
    $response = array(
        'message' => $message
    );
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>