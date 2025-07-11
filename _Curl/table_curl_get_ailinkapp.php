<?php
	include_once('../tkher_start_necessary.php');
	/*
		table_curl_get_ailinkapp.php
	*/
	$responseData = $_POST['tabData'];  
	//$responseData = json_decode($_POST['tabData'], true);
	//$tabData = json_decode($_POST['tabData'], JSON_UNESCAPED_UNICODE);
    $kapp_iv = $_POST['iv'];
	//$tabData = $_POST['tabData'];  
    $tabData =  decryptA($responseData, $kapp_key, $kapp_iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset( $tabData) ){
        $message = '_api table data 전달 완료';
    } else {
        $message = '_api table data 전달 실패';
    }
	echo "<br>message: " . $message;
	echo "table_curl_get_ailinkapp tab_enm: " . $tabData['data'][0]['tab_enm'];
			$kapp_theme0 = '';
			$kapp_theme1 = '';
			$kapp_theme = $config['kapp_theme'];
			$kapp_theme = explode('^', $kapp_theme );	//$n = sizeof($server_);
			$kapp_theme0 = $kapp_theme[0];
			$kapp_theme1 = $kapp_theme[1];

	$connect_db->begin_transaction();
    try {
		$i=0;
        //for($i = 0; $i < count($tabData['data']); $i++){
			$sql1 = "SELECT * from {$tkher['table10_curl_table']} WHERE tab_enm= '".$tabData['data'][0]['tab_enm']."' and fld_enm= 'seqno' ";
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
							tab_enm    = '".$tabData['data'][$i]['tab_enm']."' and fld_enm= 'seqno'
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
			$resultA = $connect_db->query( $sql );
		//}
        if (!$resultA) {
            throw new Exception("table_curl_get_ailinkapp.php : throw new Exception - Update failed");
        } else{
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
			
			if( isset( $kapp_theme0) && $kapp_theme0 !=='' ) {
				$tabData['data'][0]['host']       = KAPP_URL_T_;
				if( TAB_curl_send_tabData( $kapp_theme0, $tabData ) ){
					if( isset( $kapp_theme1) && $kapp_theme1 !=='' ) TAB_curl_send_tabData( $kapp_theme1, $tabData );
				}
			}
			//fation https://biogplus.iwinv.net/kapp^https://moado.net/kapp
			//biog   https://modumodu.net/kapp^https://modumodu.net/biogplus/kapp
	return $response;
?>