<?php
	include '../tkher_start_necessary.php';
	/*
	  DB_curl_get_ailinkapp.php : KAPP setup 시에 실행한다. 
	  - DB : kapp_DB_curl
	  - call : kapp_dbcon_create.php 의  DB_curl_send() 함수를 실행.
	  - DB_curl_send( $ip, $server_name_set, $upday, $memo, $pw_md5 ) 에서 사용. - add function
	  : $url_ = $A . '/_Curl/Curl_Server_get.php';
	*/
	//------------------------------------------------------------------------------------------------------------------
    $responseData = $_POST['tabData'];  

	$iv = $_POST['iv'];
    $tabData =  decryptA($responseData, $kapp_key, $iv);
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
    if( isset($tabData) ) $message = '_api DB data OK';
    else $message = '_api DB data Fail';
	$connect_db->begin_transaction();
	$K='';
    try {
		//$i = 0;
		global $K, $kapp_mainnet; //$kapp_mainnet : my_func
		$server_name = $tabData['data'][0]['server_name'];
		$query = "SELECT kapp_memo from kapp_DB_curl where server_name='" .$server_name. "' ";
		$row = sql_fetch( $query );
		if( $row > 0 ){ // 설치를 2번이상 설치한 경우
			$upday = date("Y-m-d H:i:s");
			$memo = $upday. ":Setup Update : " . $row['kapp_memo'];
			$sql = " UPDATE kapp_DB_curl SET 
				kapp_dbhost   = '".$tabData['data'][0]['kapp_dbhost']."'  , 
				kapp_dbname   = '".$tabData['data'][0]['kapp_dbname']."'  , 
				kapp_dbuser   = '".$tabData['data'][0]['kapp_dbuser']."'  , 
				admin_email   = '".$tabData['data'][0]['admin_email']."'  , 
				admin_pw      = '".$tabData['data'][0]['pw_md5']."'  , 
				kapp_ip       = '".$tabData['data'][0]['kapp_ip']."'  , 
				server_name   = '".$tabData['data'][0]['server_name']."'  , 
				curl_server   = '".$kapp_mainnet."'  , 
				kapp_memo     = '".$memo."'  
				where server_name='" .$server_name. "' 
			"; 
			$resultA = $connect_db->query( $sql );
			if( !$resultA) {
				throw new Exception("Update kapp_DB_curl failed");
			}
			//else echo "<br>DB_curl_get_ailinkapp --- Update OK server_name: $server_name";
		} else {
			$sql = " INSERT kapp_DB_curl SET 
				kapp_dbhost   = '".$tabData['data'][0]['kapp_dbhost']."'  , 
				kapp_dbname   = '".$tabData['data'][0]['kapp_dbname']."'  , 
				kapp_dbuser   = '".$tabData['data'][0]['kapp_dbuser']."'  , 
				admin_email   = '".$tabData['data'][0]['admin_email']."'  , 
				admin_pw      = '".$tabData['data'][0]['pw_md5']."'  , 
				kapp_ip       = '".$tabData['data'][0]['kapp_ip']."'  , 
				server_name   = '".$tabData['data'][0]['server_name']."'  , 
				curl_server   = '".$kapp_mainnet."'  , 
				kapp_memo          = '".$tabData['data'][0]['memo']."'  , 
				upday         = '".$tabData['data'][0]['upday']."' 
			"; 
			$resultA = $connect_db->query( $sql );
			if( !$resultA) {
				throw new Exception("Insert kapp_DB_curl failed");
			} else{
				//echo "<br>DB_curl_get_ailinkapp --- Insert OK tabData server_name: " . $tabData['data'][0]['server_name'];
				$K=''; $A=''; $B=''; $C=''; $D='';		//$sql = " select * from kapp_DB_curl group by server_name"; 
				$sql = " select * from kapp_DB_curl order by seqno desc ";
				$ret = $connect_db->query( $sql );
				if( !$ret) {
					throw new Exception("kapp_DB_curl data query failed");
				} else {
					$i=0;
					$A='';$B='';$C=''; $firstA ='';$lastB ='';
					while( $rs = sql_fetch_array($ret) ){
						$R = $rs['server_name']; 
						if( $i == 0 ) {
							$A = KAPP_URL_T_;
							$B = $R; 
							$K = $A . "^".  $R  . "^" . $C;			$firstA = $R;
							Curl_Server_Send( KAPP_URL_T_, $R, '' );	//echo "<br>i=0 start - " .$K;
							curl_set_DBsave( KAPP_URL_T_, $R, ''  ); // main net 설정.
						} else {
							$A = $B;
							$B = $R;
							if( $i == 1) $lastB =$R;
							if( $R == KAPP_URL_T_) { // last end
								//echo "<br> continue B == KAPP_URL_T_  , $B == " . KAPP_URL_T_;
								$B='';
							}
							$K = $A . "^".  $B . "^" . $C;		
							Curl_Server_Send( $A, $B, $C );	//echo "<br>$i - " .$K;
							curl_set_DBsave( $A, $B, $C  );
						}
						$i++;
					}//while
					$K = $firstA . "^".  $lastB   . "^" . $C;		
					Curl_Server_Send( $firstA, $lastB, $C );	//echo "<br>last - " .$K;
					curl_set_DBsave( $firstA, $lastB, $C  );
					echo $K;
				}
				//--------------------
			}
		}
        $connect_db->commit();
    } catch (Exception $e) {
        $connect_db->rollback();
        echo "Error: " . $e->getMessage();
    }
    $connect_db->close();
	return $K;

	function Curl_Server_Send( $A, $B, $C ){
	/*
	  - 서버 각각의 config['kapp_theme'] 를 설정.
	  - 데이터가 생성되면 전달을 릴레이식으로 처리한다.
	  - pg_curl_get_ailinkapp.php
	  - table_curl_get_ailinkapp.php
	*/
	echo "<br>$A --- Curl_Server_Send, A:" . $A . ", B:" . $B.", C:". $C;
		global $kapp_iv, $kapp_key; 
		$upday = date("Y-m-d H:i:s");
		if( $A == '' ) return;
		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['curl_server1'] = $B;
		$tabData['data'][$cnt]['curl_server2'] = $C;
		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);

		$url_ = $A . '/_Curl/Curl_Server_get.php';
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			$_ms = "send curl error : " . curl_error($curl);
			echo 'curl error : ' . curl_error($curl);
		} else {
			$_ms = 'send curl response : ' . $response;
		}
		m_("Curl_Server_Send ms: ". $_ms);
		curl_close($curl);
		return $response;
	}
	function curl_set_DBsave( $A, $B, $C ){
		$upday = date("Y-m-d H:i:s");
		if( $A == '' ) return;
		$query = "SELECT kapp_memo from kapp_DB_curl where server_name='" .$A. "' ";
		$row = sql_fetch( $query );
		if( $row > 0 ){ 
				$memo = $upday. ": curl server Update : " . $row['kapp_memo'];
				$sql = " UPDATE kapp_DB_curl SET 
					curl_server   = '".$B."'  , 
					curl_server2 = '".$C."'  , 
					kapp_memo = '".$memo."' , 
					upday         = '".$upday."' 
					where server_name='" .$A. "' 
				"; 
				$resultA = sql_query( $sql );
				if( !$resultA) {
					throw new Exception("Update kapp_DB_curl failed");
				} else {
					return true;
				}
		} else {
			m_( "Server name Error, " . $A . ", " . $B.", ". $C );
			echo "<br>Server name Error, A:" . $A . ", B:" . $B.", C:". $C;
			return false;
		}
	}

	/*


--- Reset table list : ---

kapp_config, already exists. , --- delete success : kapp_config
kapp_tkher_main_img, already exists. , --- delete success : kapp_tkher_main_img
kapp_tkher_my_control, already exists. , --- delete success : kapp_tkher_my_control
kapp_sajin_group, already exists. , --- delete success : kapp_sajin_group
kapp_sajin_jpg, already exists. , --- delete success : kapp_sajin_jpg
kapp_log_info, already exists. , --- delete success : kapp_log_info
kapp_visit, already exists. , --- delete success : kapp_visit
kapp_visit_sum, already exists. , --- delete success : kapp_visit_sum
kapp_point, already exists. , --- delete success : kapp_point
kapp_aboard_admin, already exists. , --- delete success : kapp_aboard_admin
kapp_aboard_infor, already exists. , --- delete success : kapp_aboard_infor
aboard_kapp_notice, already exists. , --- delete success : aboard_kapp_notice
aboard_kapp_news, already exists. , --- delete success : aboard_kapp_news
aboard_kapp_qna, already exists. , --- delete success : aboard_kapp_qna
aboard_kapp_free, already exists. , --- delete success : aboard_kapp_free
kapp_aboard_memo, already exists. , --- delete success : kapp_aboard_memo
kapp_admin_bbs, already exists. , --- delete success : kapp_admin_bbs
kapp_ap_bbs, already exists. , --- delete success : kapp_ap_bbs
kapp_menuskin, already exists. , --- delete success : kapp_menuskin
kapp_webeditor, already exists. , --- delete success : kapp_webeditor
kapp_webeditor_comment, already exists. , --- delete success : kapp_webeditor_comment
kapp_table10, already exists. , --- delete success : kapp_table10
kapp_table10_pg, already exists. , --- delete success : kapp_table10_pg
kapp_job_link_table, already exists. , --- delete success : kapp_job_link_table
kapp_sys_menu_bom, already exists. , --- delete success : kapp_sys_menu_bom
kapp_table10_curl, already exists. , --- delete success : kapp_table10_curl
kapp_table10_pg_curl, already exists. , --- delete success : kapp_table10_pg_curl
kapp_job_link_table_curl, already exists. , --- delete success : kapp_job_link_table_curl
kapp_sys_menu_bom_curl, already exists. , --- delete success : kapp_sys_menu_bom_curl
kapp_table10_group, already exists. , --- delete success : kapp_table10_group
kapp_coin_view, already exists. , --- delete success : kapp_coin_view
kapp_url_group, already exists. , --- delete success : kapp_url_group
kapp_bbs_history, already exists. , --- delete success : kapp_bbs_history
kapp_e_list, already exists. , --- delete success : kapp_e_list
kapp_pri_contect, already exists. , --- delete success : kapp_pri_contect
kapp_project, already exists. , --- delete success : kapp_project
kapp_pri_maintenance, already exists. , --- delete success : kapp_pri_maintenance
kapp_tkher_content, already exists. , --- delete success : kapp_tkher_content
kapp_ip_info, already exists. , --- delete success : kapp_ip_info
kapp_login, ---

--- Table : End ---

kapp_DB, already exists. , --- delete success : kapp_DB, --- kapp_DB table create

kapp_DB_record_create --- start
kapp_DB_record_create - DB_curl_send --- start
DB_curl_send --- start curl OK : Insert OK
https://fation.net/kapp --- Curl_Server_Send, A:https://fation.net/kapp, B:https://modumodu.net/biog7/kapp, C:
- https://fation.net/kapp^https://modumodu.net/biog7/kapp^
https://modumodu.net/biog7/kapp --- Curl_Server_Send, A:https://modumodu.net/biog7/kapp, B:https://biogplus.iwinv.net/kapp, C:
- https://modumodu.net/biog7/kapp^https://biogplus.iwinv.net/kapp^
https://biogplus.iwinv.net/kapp --- Curl_Server_Send, A:https://biogplus.iwinv.net/kapp, B:https://moado.net/kapp, C:
- https://biogplus.iwinv.net/kapp^https://moado.net/kapp^
https://moado.net/kapp --- Curl_Server_Send, A:https://moado.net/kapp, B:https://modumodu.net/kapp, C:
- https://moado.net/kapp^https://modumodu.net/kapp^
https://modumodu.net/kapp --- Curl_Server_Send, A:https://modumodu.net/kapp, B:https://modumodu.net/biogplus/kapp, C:
- https://modumodu.net/kapp^https://modumodu.net/biogplus/kapp^
https://modumodu.net/biogplus/kapp --- Curl_Server_Send, A:https://modumodu.net/biogplus/kapp, B:https://24c.kr/kapp, C:
- https://modumodu.net/biogplus/kapp^https://24c.kr/kapp^
continue B == KAPP_URL_T_ , https://fation.net/kapp == https://fation.net/kapp
https://24c.kr/kapp --- Curl_Server_Send, A:https://24c.kr/kapp, B:, C:
- https://24c.kr/kapp^^
- Create Success and Record Create Success : kapp_DB

kapp_DB_record_create --- end
kapp_member, already exists. , --- delete success : kapp_member
Create Success : kapp_member


--- Setup Create table list : ---

kapp_config, --- - Create Success and Record Create Success : kapp_config, admin email:solpakan@naver.com
kapp_tkher_main_img, --- - Create Success and Record Create Success : kapp_tkher_main_img
kapp_tkher_my_control, --- - Create Success and Record Create Success : kapp_tkher_my_control
kapp_sajin_group, --- - Create Success : kapp_sajin_group
kapp_sajin_jpg, --- - Create Success : kapp_sajin_jpg
kapp_log_info, --- - Create Success : kapp_log_info
kapp_visit, --- - Create Success : kapp_visit
kapp_visit_sum, --- - Create Success : kapp_visit_sum
kapp_point, --- - Create Success : kapp_point
kapp_aboard_admin, --- Create Success and Record Create Success : kapp_aboard_admin
kapp_aboard_infor, --- Create Success and Record Create Success : kapp_aboard_infor - Create Success : kapp_aboard_infor
aboard_kapp_notice, --- - Create Success : aboard_kapp_notice
aboard_kapp_news, --- - Create Success : aboard_kapp_news
aboard_kapp_qna, --- - Create Success : aboard_kapp_qna
aboard_kapp_free, --- - Create Success : aboard_kapp_free
kapp_aboard_memo, --- - Create Success : kapp_aboard_memo
kapp_admin_bbs, --- - Create Success : kapp_admin_bbs
kapp_ap_bbs, --- - Create Success : kapp_ap_bbs
kapp_menuskin, --- - Create Success : kapp_menuskin
kapp_webeditor, --- - Create Success : kapp_webeditor
kapp_webeditor_comment, --- - Create Success : kapp_webeditor_comment
kapp_table10, --- - Create Success : kapp_table10
kapp_table10_pg, --- - Create Success : kapp_table10_pg
kapp_job_link_table, --- - Create Success : kapp_job_link_table
kapp_sys_menu_bom, --- - Create Success : kapp_sys_menu_bom
kapp_table10_curl, --- - Create Success : kapp_table10_curl
kapp_table10_pg_curl, --- - Create Success : kapp_table10_pg_curl
kapp_job_link_table_curl, --- - Create Success : kapp_job_link_table_curl
kapp_sys_menu_bom_curl, --- - Create Success : kapp_sys_menu_bom_curl
kapp_table10_group, --- - Create Success : kapp_table10_group
kapp_coin_view, --- - Create Success : kapp_coin_view
kapp_url_group, --- - Create Success : kapp_url_group
kapp_bbs_history, --- - Create Success : kapp_bbs_history
kapp_e_list, --- - Create Success : kapp_e_list
kapp_pri_contect, --- - Create Success and Record Create Success : kapp_pri_contect
kapp_project, --- - Create Success : kapp_project
kapp_pri_maintenance, --- - Create Success : kapp_pri_maintenance
kapp_tkher_content, --- - Create Success : kapp_tkher_content
kapp_ip_info, --- - Create Success : kapp_ip_info
kapp_login, ---

--- Table Create : End ---
K-APP Home [ Home - click ]
Click Here Table List
	*/
?>