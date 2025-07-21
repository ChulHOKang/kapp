<?php
	include_once('../tkher_start_necessary.php');
	/*
	  sys_menu_bom_curl_get_ailinkapp.php : /t/menu/treebom_updw_new_menu.php - update 시에 실행.
	   - Table: kapp_sys_menu_bom_curl
	  작업 결과 : 성공, 2023-07-27
	*/
	//$key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
    $responseData = $_POST['tabData'];  //json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $kapp_key, $iv);
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);

	if( isset($tabData) ){
        $message = KAPP_URL_T_ . '_api OK';
    } else {
        $message = KAPP_URL_T_ . '_api fail';
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
		//if( isset($tabData['data'][$i]['sys_rcnt']) == '' || $tabData['data'][$i]['sys_rcnt'] == NULL) $tabData['data'][$i]['sys_rcnt'] = 0;
		$sql = " INSERT {$tkher['sys_menu_bom_curl_table']} SET 
			sys_pg      = '".$tabData['data'][$i]['sys_pg']."'  , 
			sys_menu    = '".$tabData['data'][$i]['sys_menu']."'  , 
			sys_submenu = '".$tabData['data'][$i]['sys_submenu']."'  , 
			sys_subtit  = '".$tabData['data'][$i]['sys_subtit']."'  , 
			sys_link    = '".$tabData['data'][$i]['sys_link']."'  , 
			sys_menutit = '".$tabData['data'][$i]['sys_menutit']."'  , 
			sys_level   = '".$tabData['data'][$i]['sys_level']."'  , 
			sys_memo    = '".$tabData['data'][$i]['sys_memo']."'  , 
			sys_rcnt   = ".$tabData['data'][$i]['sys_rcnt']."  , 
			sys_cnt    = ".$tabData['data'][$i]['sys_cnt']."  , 
			sys_disno  = ".$tabData['data'][$i]['sys_disno']."  , 
			sys_userid = '".$tabData['data'][$i]['sys_userid']."'  , 

			host       = '".$tabData['data'][$i]['host']."'  , 
			email      = '".$tabData['data'][$i]['email']."'  , 
			view_cnt   = ".$tabData['data'][$i]['view_cnt']."  , 
			view_lev   = '".$tabData['data'][$i]['view_lev']."'  , 
			tit_gubun  = '".$tabData['data'][$i]['tit_gubun']."'  , 
			book_num   = '".$tabData['data'][$i]['book_num']."'  , 

			bgcolor    = '".$tabData['data'][$i]['bgcolor']."'  , 
			fontcolor  = '".$tabData['data'][$i]['fontcolor']."'  , 
			fontface   = '".$tabData['data'][$i]['fontface']."'  , 
			fontsize   = '".$tabData['data'][$i]['fontsize']."'  , 
			imgtype1   = '".$tabData['data'][$i]['imgtype1']."'  , 
			imgtype2   = '".$tabData['data'][$i]['imgtype2']."'  , 
			imgtype3   = '".$tabData['data'][$i]['imgtype3']."'
		 ";  
		$resultA = $connect_db->query( $sql );
        if ( !$resultA) {
            throw new Exception( KAPP_URL_T_ . ", Tree Menu Create Failed");
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
		if( Sys_Menu_bom_curl_send_tabData( $kapp_theme0, $tabData ) ) {
			if( isset( $kapp_theme1) && $kapp_theme1 !=='' )	 Sys_Menu_bom_curl_send_tabData( $kapp_theme1, $tabData );
		}
	}
	return $response;

?>