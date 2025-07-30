<?php
	include_once('../tkher_start_necessary.php');
	/*
		Ap_bbs_curl_get_ailinkapp.php
		-insertD_check.php
	*/
    $responseData = $_POST['tabData']; 
    $kapp_iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $kapp_key, $kapp_iv);
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);

    if( isset($tabData) ){
        $message = KAPP_URL_T_ . ', api OK, ';
    } else {
        $message = KAPP_URL_T_ . ' api Fail, ';
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
		$sql = " INSERT into {$tkher['ap_bbs_curl_table']} SET 
			infor  = ".$tabData['data'][$i]['infor']."  , 
			email    = '".$tabData['data'][$i]['email']."'  , 
			subject   = '".$tabData['data'][$i]['subject']."'  , 
			content       = '".$tabData['data'][$i]['content']."'  , 
			reg_date     = ".$tabData['data'][$i]['reg_date']."  , 
			aboard_tab_enm        = '".$tabData['data'][$i]['aboard_tab_enm']."'  , 
			aboard_tab_hnm        = '".$tabData['data'][$i]['aboard_tab_hnm']."'  ,
			host = '".$tabData['data'][$i]['host']."'  ,
			kapp_server = '".$tabData['data'][$i]['kapp_server']."'  
		"; 
		$resultA = $connect_db->query( $sql );
        if( !$resultA) {
            throw new Exception( KAPP_URL_T_ . ", Ap_bbs_curl_get_ailinkapp.php : throw new Exception - ap_bbs_curl Failed");
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
			if( Ap_bbs_curl_send_tabData( $kapp_theme0, $tabData ) ) {
				if( isset( $kapp_theme1) && $kapp_theme1 !=='' )	Ap_bbs_curl_send_tabData( $kapp_theme1, $tabData );
			}
		}
	return $response;
?>