<?php
	include_once('../tkher_start_necessary.php');
	/*
	  작업 결과 : 성공, 2023-07-27
	*/
    $key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
    $responseData = $_POST['tabData']; // json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $key, $iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = '_api table data 전달 완료';
    } else {
        $message = '_api table data 전달 실패';
    }
    $connect_db->begin_transaction();
    try {
        for($i = 0; $i < count($tabData['data']); $i++){
			$sql1 = "SELECT * from {$tkher['table10_curl_table']} WHERE 
				host       = '".$tabData['data'][$i]['host']."' and
				email      = '".$tabData['data'][$i]['email']."' and
				group_code = '".$tabData['data'][$i]['group_code']."' and
				group_name = '".$tabData['data'][$i]['group_name']."' and
				tab_enm    = '".$tabData['data'][$i]['tab_enm']."' and
				tab_hnm    = '".$tabData['data'][$i]['tab_hnm']."' and
				fld_enm    = '".$tabData['data'][$i]['fld_enm']."' and
				fld_hnm    = '".$tabData['data'][$i]['fld_hnm']."' 
			";
			$result = $connect_db->query( $sql1 ); // $result = sql_query( $sql1 );
			$row = sql_num_rows($result);          // echo "count_:" . $row;
			if( $row > 0 ) {
				$sql = " UPDATE {$tkher['table10_curl_table']} SET 
					fld_type   = '".$tabData['data'][$i]['fld_type']."'  , 
					fld_len    = '".$tabData['data'][$i]['fld_len']."'  , 
					disno      = '".$tabData['data'][$i]['disno']."'  , 
					if_line    = '".$tabData['data'][$i]['if_line']."'  , 
					if_type    = '".$tabData['data'][$i]['if_type']."'  , 
					if_data    = '".$tabData['data'][$i]['if_data']."'  , 
					relation_data    = '".$tabData['data'][$i]['relation_data']."'  , 
					sqltable   = '".$tabData['data'][$i]['sqltable']."'  , 
					memo       = '".$tabData['data'][$i]['memo']."' 
					WHERE
							host       = '".$tabData['data'][$i]['host']."' and
							email      = '".$tabData['data'][$i]['email']."' and
							group_code = '".$tabData['data'][$i]['group_code']."' and
							group_name = '".$tabData['data'][$i]['group_name']."' and
							tab_enm    = '".$tabData['data'][$i]['tab_enm']."' and
							tab_hnm    = '".$tabData['data'][$i]['tab_hnm']."' and
							fld_enm    = '".$tabData['data'][$i]['fld_enm']."' and
							fld_hnm    = '".$tabData['data'][$i]['fld_hnm']."' 
				";
			} else {
				if( isset($tabData['data'][$i]['if_line']) == '' || $tabData['data'][$i]['if_line'] == NULL) $tabData['data'][$i]['if_line'] = 0;
				$sql = " INSERT {$tkher['table10_curl_table']} SET 
					tab_enm    = '".$tabData['data'][$i]['tab_enm']."'  , 
					tab_hnm    = '".$tabData['data'][$i]['tab_hnm']."'  , 
					fld_enm    = '".$tabData['data'][$i]['fld_enm']."'  , 
					fld_hnm    = '".$tabData['data'][$i]['fld_hnm']."'  , 
					fld_type   = '".$tabData['data'][$i]['fld_type']."'  , 
					fld_len    = '".$tabData['data'][$i]['fld_len']."'  , 
					disno      = '".$tabData['data'][$i]['disno']."'  , 
					userid     = '".$tabData['data'][$i]['userid']."'  , 
					group_code = '".$tabData['data'][$i]['group_code']."'  , 
					group_name = '".$tabData['data'][$i]['group_name']."'  , 
					host       = '".$tabData['data'][$i]['host']."'  , 
					email      = '".$tabData['data'][$i]['email']."'  , 
					if_line    = '".$tabData['data'][$i]['if_line']."'  , 
					if_type    = '".$tabData['data'][$i]['if_type']."'  , 
					if_data    = '".$tabData['data'][$i]['if_data']."'  , 
					relation_data = '".$tabData['data'][$i]['relation_data']."'  , 
					sqltable      = '".$tabData['data'][$i]['sqltable']."'  , 
					memo          = '".$tabData['data'][$i]['memo']."' 
				";
			}
			echo "sql:".$sql;
			$resultA = $connect_db->query( $sql );
		}
        // 롤백
        if (!$resultA) {
            throw new Exception("Update failed");
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

?>