<?php
	include_once('../tkher_start_necessary.php');
	/*
		Link_Table_curl_get_ailinkapp.php
		-app_pg50RC.php
	*/
	//$hash_block_job = $_POST['hash_block'];  // prev block
    $hash_block_job = $config['hash_block_job'];  // prev block
    $responseData = $_POST['tabData'];          // new data

	$ret = sql_query( "update {$tkher['config_table']} set hash_block_job = '$responseData' " ); //where kapp_title ='K-App' 
	if( !$ret) 	echo "<br> config_table hash_block_job update Error. --- Api Link_Table_curl_get";	
	else echo "<br> config_table hash_block_job update OK --- Api Link_Table_curl_get";

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
		$sql = " INSERT into {$tkher['job_link_table_curl']} SET 
			link_title  = '".$tabData['data'][$i]['link_title']."'  , 
			link_url    = '".$tabData['data'][$i]['link_url']."'  , 
			link_type   = '".$tabData['data'][$i]['link_type']."'  , 
			email       = '".$tabData['data'][$i]['email']."'  , 
			host = '".$tabData['data'][$i]['host']."'  , 
			kapp_server = '".$tabData['data'][$i]['kapp_server']."'  , 
			user_ip     = '".$tabData['data'][$i]['user_ip']."'  , 
			memo        = '".$tabData['data'][$i]['memo']."'  , 
			up_day      = '".$tabData['data'][$i]['up_day']."' , 
			hash_block_job = '$hash_block_job'   
		"; 
		$resultA = $connect_db->query( $sql );
        if( !$resultA) {
            throw new Exception( KAPP_URL_T_ . ", Link_Table_curl_get_ailinkapp.php : throw new Exception - job_link_table Failed");
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
			if( Link_Table_curl_send_tabData( $kapp_theme0, $tabData ) ) {
				if( isset( $kapp_theme1) && $kapp_theme1 !=='' )	Link_Table_curl_send_tabData( $kapp_theme1, $tabData );
			}
		}
	return $response;
?>