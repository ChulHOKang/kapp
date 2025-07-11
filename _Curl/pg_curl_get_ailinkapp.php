<?php
	include_once('../tkher_start_necessary.php');
	/*
		pg_curl_get_ailinkapp.php : 
		- table30m_A.php
		: PG_curl_sendA( $item_cnt , $item_array, $if_type, $if_data, $pop_data, $pg_sys_link, $rel_data, $rel_type );
		- app_pg50RC.php , table30m_A.php
		: PG_curl_send( $kapp_theme0, $item_cnt , $item_array, $if_type, $if_data, $pop_data, $pg_sys_link, $rel_data, $rel_type );
		- app_pg50RU.php - app_pg50RU_update.php
		: PG_curl_send( $kapp_theme0, $item_cnt , $item_array, $if_type, $if_data, $pop_data, $pg_sys_link, $rel_data, $rel_type );
	*/
    //$key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
	$responseData = $_POST['tabData']; //json_decode($_POST['tabData'], true);
    //$tabData = $_POST['tabData']; //json_decode($_POST['tabData'], true);
    $kapp_iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $kapp_key, $kapp_iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = '_api pg_curl_get_ailinkapp data 전달 완료';
    } else {
        $message = '_api pg_curl_get_ailinkapp data 전달 실패';
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
		$sql1 = "SELECT * from {$tkher['table10_pg_curl_table']} WHERE email= '".$tabData['data'][0]['email']."' and 	pg_code= '".$tabData['data'][0]['pg_code']."' ";
		$result = $connect_db->query( $sql1 ); // $result = sql_query( $sql1 );
		$row = sql_num_rows($result);          // echo "count_:" . $row;
		if( $row > 0 ) {
			$day = date("Y-m-d H:i:s", time());
			//if( isset($tabData['data'][$i]['item_cnt']) == '' || $tabData['data'][$i]['item_cnt'] == NULL) $tabData['data'][$i]['item_cnt'] = 0;
			$sql = " UPDATE {$tkher['table10_pg_curl_table']} SET 
				item_cnt= '".$tabData['data'][0]['item_cnt']."'  , 
				if_type= '".$tabData['data'][0]['if_type']."'  , 
				if_data= '".$tabData['data'][0]['if_data']."'  , 
				relation_data= '".$tabData['data'][0]['relation_data']."'  , 
				popdata_db= '".$tabData['data'][0]['popdata_db']."'  , 
				item_array= '".$tabData['data'][0]['item_array']."' ,
				upday= '".$day."' 
				WHERE
						email= '".$tabData['data'][0]['email']."' and
						pg_code= '".$tabData['data'][0]['pg_code']."' 
			";
		} else {
			//if( isset($tabData['data'][$i]['item_cnt']) == '' || $tabData['data'][$i]['item_cnt'] == NULL) $tabData['data'][$i]['item_cnt'] = 0;
			$sql = " INSERT {$tkher['table10_pg_curl_table']} SET 
				pg_code   = '".$tabData['data'][0]['pg_code']."'  , 
				pg_name   = '".$tabData['data'][0]['pg_name']."'  , 
				tab_enm    = '".$tabData['data'][0]['tab_enm']."'  , 
				tab_hnm    = '".$tabData['data'][0]['tab_hnm']."'  , 
				group_code = '".$tabData['data'][0]['group_code']."'  , 
				group_name = '".$tabData['data'][0]['group_name']."'  , 
				userid     = '".$tabData['data'][0]['userid']."'  , 
				host       = '".$tabData['data'][0]['host']."'  , 
				email      = '".$tabData['data'][0]['email']."'  , 
				item_cnt   = ".$tabData['data'][0]['item_cnt']."  , 
				if_type    = '".$tabData['data'][0]['if_type']."'  , 
				if_data    = '".$tabData['data'][0]['if_data']."'  , 
				pop_data = '".$tabData['data'][0]['popdata_db']."'  , 
				sys_link   = '".$tabData['data'][0]['sys_link']."'  , 
				relation_data   = '".$tabData['data'][0]['relation_data']."'  , 
				relation_type   = '".$tabData['data'][0]['relation_type']."'  , 
				item_array = '".$tabData['data'][0]['item_array']."' 
			"; 
		}
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

		if( isset( $kapp_theme0) && $kapp_theme0 !=='' )	{
			$tabData['data'][0]['host']       =KAPP_URL_T_;
			if( PG_curl_send_tabData( $kapp_theme0, $tabData ) ) {
				if( isset( $kapp_theme1) && $kapp_theme1 !=='' )	PG_curl_send_tabData( $kapp_theme1, $tabData );
			}
		}
	return $response;

?>