<?php
	include_once('../tkher_start_necessary.php');
	/*
	  treebom_insw_curl_ailinkapp.php : /t/menu/treebom_insw_new_menu.php - update 시에 실행. 중요.
	  작업 결과 : 성공, 2023-07-27
	*/

	$key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
    $responseData = $_POST['tabData'];  //json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];

    $tabData =  decryptA($responseData, $key, $iv);
	//------------------- 배열 재 구성 --------------------------
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
	//--------------------------------------------------------
    if( isset($tabData) ){
        $message = '_api treebom_insw_curl_ailinkapp data 전달 완료';
    } else {
        $message = '_api treebom_insw_curl_ailinkapp data 전달 실패';
    }
    $connect_db->begin_transaction();
try {
		for($i = 0; $i < count($tabData['data']); $i++){
			$sql1 = "SELECT * from {$tkher['sys_menu_bom_curl_table']} WHERE 
				sys_pg     = '".$tabData['data'][$i]['sys_pg']."' and
				sys_menu   = '".$tabData['data'][$i]['sys_menu']."' and
				sys_submenu= '".$tabData['data'][$i]['sys_submenu']."'
			";
			$result = $connect_db->query( $sql1 ); // $result = sql_query( $sql1 );
			$row = sql_num_rows($result);          // echo "count_:" . $row;
			if( $row > 0 ) {
				if( $tabData['data'][$i]['sys_rcnt'] == '' || $tabData['data'][$i]['sys_rcnt'] == NULL) $tabData['data'][$i]['sys_rcnt'] = 0;
				if( $tabData['data'][$i]['sys_cnt'] == '' || $tabData['data'][$i]['sys_cnt'] == NULL) $tabData['data'][$i]['sys_cnt'] = 0;
				if( $tabData['data'][$i]['sys_disno'] == '' || $tabData['data'][$i]['sys_disno']==NULL) $tabData['data'][$i]['sys_disno'] = 0;
				if( $tabData['data'][$i]['view_cnt'] == '' || $tabData['data'][$i]['view_cnt']==NULL) $tabData['data'][$i]['view_cnt'] = 0;
				$sql = " UPDATE {$tkher['sys_menu_bom_curl_table']} SET 
					sys_level   = '".$tabData['data'][$i]['sys_level']."'  ,
					sys_subtit  = '".$tabData['data'][$i]['sys_subtit']."'  , 
					sys_link    = '".$tabData['data'][$i]['sys_link']."'  , 
					sys_menutit = '".$tabData['data'][$i]['sys_menutit']."'  , 
					view_lev    = '".$tabData['data'][$i]['view_lev']."'  , 
					view_cnt    = ".$tabData['data'][$i]['view_cnt']."  , 
					sys_rcnt    = ".$tabData['data'][$i]['sys_rcnt']."  , 
					sys_cnt     = ".$tabData['data'][$i]['sys_cnt']."  , 
					sys_disno   = ".$tabData['data'][$i]['sys_disno']."  , 
					tit_gubun   = '".$tabData['data'][$i]['tit_gubun']."'  , 
					book_num    = '".$tabData['data'][$i]['book_num']."'  , 
					host        = '".$tabData['data'][$i]['host']."'  , 
					email       = '".$tabData['data'][$i]['email']."'  , 
					sys_memo    = '".$tabData['data'][$i]['sys_memo']."'   

					WHERE
							sys_pg      = '".$tabData['data'][$i]['sys_pg']."' and
							sys_menu    = '".$tabData['data'][$i]['sys_menu']."' and
							sys_submenu = '".$tabData['data'][$i]['sys_submenu']."' 
				";
			} else {
				if( $tabData['data'][$i]['sys_rcnt'] == '' || $tabData['data'][$i]['sys_rcnt'] == NULL) $tabData['data'][$i]['sys_rcnt'] = 0;
				if( $tabData['data'][$i]['sys_cnt'] == '' || $tabData['data'][$i]['sys_cnt'] == NULL) $tabData['data'][$i]['sys_cnt'] = 0;
				if( $tabData['data'][$i]['sys_disno'] == '' || $tabData['data'][$i]['sys_disno']==NULL) $tabData['data'][$i]['sys_disno'] = 0;
				if( $tabData['data'][$i]['view_cnt'] == '' || $tabData['data'][$i]['view_cnt']==NULL) $tabData['data'][$i]['view_cnt'] = 0;
				$sql = " INSERT {$tkher['sys_menu_bom_curl_table']} SET 
					sys_pg      = '".$tabData['data'][$i]['sys_pg']."'  , 
					sys_menu    = '".$tabData['data'][$i]['sys_menu']."'  , 
					sys_submenu = '".$tabData['data'][$i]['sys_submenu']."'  , 
					sys_subtit  = '".$tabData['data'][$i]['sys_subtit']."'  , 
					sys_link    = '".$tabData['data'][$i]['sys_link']."'  , 
					sys_menutit = '".$tabData['data'][$i]['sys_menutit']."'  , 
					sys_level   = '".$tabData['data'][$i]['sys_level']."'  , 
					sys_memo    = '".$tabData['data'][$i]['sys_memo']."'  , 
					
					sys_rcnt    = ".$tabData['data'][$i]['sys_rcnt']."  , 
					sys_cnt     = ".$tabData['data'][$i]['sys_cnt']."  , 
					sys_disno   = ".$tabData['data'][$i]['sys_disno']."  , 

					sys_userid  = '".$tabData['data'][$i]['sys_userid']."'  , 
					host        = '".$tabData['data'][$i]['host']."'  , 
					email       = '".$tabData['data'][$i]['email']."'  , 

					view_cnt    = ".$tabData['data'][$i]['view_cnt']."  , 
					view_lev    = '".$tabData['data'][$i]['view_lev']."'  , 
					tit_gubun   = '".$tabData['data'][$i]['tit_gubun']."'  , 
					book_num    = '".$tabData['data'][$i]['book_num']."'  , 

					bgcolor     = '".$tabData['data'][$i]['bgcolor']."'  , 
					fontcolor   = '".$tabData['data'][$i]['fontcolor']."'  , 
					fontface    = '".$tabData['data'][$i]['fontface']."'  , 
					fontsize    = '".$tabData['data'][$i]['fontsize']."'  , 
					imgtype1    = '".$tabData['data'][$i]['imgtype1']."'  , 
					imgtype2    = '".$tabData['data'][$i]['imgtype2']."'  , 
					imgtype3    = '".$tabData['data'][$i]['imgtype3']."'
				 "; 
				//sys_link ="https://" . $hostnameA . "/t/tkher_program_data_list.php?pg_code=" . $pg_code;
			}
			//echo "sql:".$sql . "<br>";
			$resultA = $connect_db->query( $sql );
		}//for
        if (!$resultA) { // 롤백
            throw new Exception("SQL Insert or Update failed");
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
    echo json_encode( $response, JSON_UNESCAPED_UNICODE);

?>