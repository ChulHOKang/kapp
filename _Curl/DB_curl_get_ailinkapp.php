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
    $responseData = $_POST['tabData']; //   $responseData = json_decode($_POST['tabData'], true);
    $iv = $_POST['iv'];
	$kapp_key = 'appgenerator';    //$iv = "~`!@#$%^&*()-_=+";
    $tabData =  decryptA($responseData, $kapp_key, $iv);
	$tabData = json_encode($tabData, JSON_UNESCAPED_UNICODE);
	$tabData = json_decode($tabData, true);
    if( isset($tabData) ) $message = '_api DB data OK';
    else $message = '_api DB data Fail';
	$connect_db->begin_transaction();
    try {
		$i = 0;
		$server_name = $tabData['data'][$i]['server_name'];
		$query = "SELECT kapp_memo from kapp_DB_curl where server_name='" .$server_name. "' ";
		$row = sql_fetch( $query );
		if( $row > 0 ){ // 설치를 2번이상 설치한 경우
			$upday = date("Y-m-d H:i:s");
			$memo = $upday. ":Setup Update : " . $row['kapp_memo'];
			$sql = " UPDATE kapp_DB_curl SET 
				kapp_dbhost   = '".$tabData['data'][$i]['kapp_dbhost']."'  , 
				kapp_dbname   = '".$tabData['data'][$i]['kapp_dbname']."'  , 
				kapp_dbuser   = '".$tabData['data'][$i]['kapp_dbuser']."'  , 
				admin_email   = '".$tabData['data'][$i]['admin_email']."'  , 
				admin_pw      = '".$tabData['data'][$i]['pw_md5']."'  , 
				kapp_ip       = '".$tabData['data'][$i]['kapp_ip']."'  , 
				server_name   = '".$tabData['data'][$i]['server_name']."'  , 
				curl_server   = 'https://fation.net/kapp'  , 
				kapp_memo     = '".$memo."'  
				where server_name='" .$server_name. "' 
			"; 
			$resultA = $connect_db->query( $sql );
			if( !$resultA) {
				throw new Exception("Update kapp_DB_curl failed");
			} else echo "--- Update OK";
		} else {
			$sql = " INSERT kapp_DB_curl SET 
				kapp_dbhost   = '".$tabData['data'][$i]['kapp_dbhost']."'  , 
				kapp_dbname   = '".$tabData['data'][$i]['kapp_dbname']."'  , 
				kapp_dbuser   = '".$tabData['data'][$i]['kapp_dbuser']."'  , 
				admin_email   = '".$tabData['data'][$i]['admin_email']."'  , 
				admin_pw      = '".$tabData['data'][$i]['pw_md5']."'  , 
				kapp_ip       = '".$tabData['data'][$i]['kapp_ip']."'  , 
				server_name   = '".$tabData['data'][$i]['server_name']."'  , 
				curl_server   = 'https://fation.net/kapp'  , 
				kapp_memo          = '".$tabData['data'][$i]['memo']."'  , 
				upday         = '".$tabData['data'][$i]['upday']."' 
			"; 
			$resultA = $connect_db->query( $sql );
			if( !$resultA) {
				throw new Exception("Insert kapp_DB_curl failed");
			} else{
				echo "Insert OK";
				//------------- add 2025-07-12 ---------------
				$K=''; $A=''; $B=''; $C=''; $D='';		//$sql = " select * from kapp_DB_curl group by server_name"; 
				$sql = " select * from kapp_DB_curl order by seqno desc ";
				$ret = $connect_db->query( $sql );
				if( !$ret) {
					throw new Exception("kapp_DB_curl data query failed");
				} else {
					$i=0;
					$A='';$B='';$C=''; //$K='';
					while( $rs = sql_fetch_array($ret) ){
						$R = $rs['server_name']; $first_chk = $rs['server_name'];
						if( $i == 0 ) {
							$A = KAPP_URL_T_;
							$B = $R;
							//$K = $A . "^".  $B  . "^" . $C;			//curl_set_DBsave( KAPP_URL_T_, $R, ''  ); // main net 설정.
							Curl_Server_Send( KAPP_URL_T_, $R, '' );	//echo "<br> - " .$K;
						} else {
							$A = $B;
							$B = $R;
							if( $B == KAPP_URL_T_) {
								//echo "<br> continue B == KAPP_URL_T_  , $B == " . KAPP_URL_T_;
								$B='';
							}
							//$K = $A . "^".  $B  . "^" . $C;		//curl_set_DBsave( $A, $B, $C  );
							Curl_Server_Send( $A, $B, $C );	//echo "<br> - " .$K;
						}
						$i++;
					}//while
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

	function Curl_Server_Send( $A, $B, $C ){
	/*
	  - 서버 각각의 config['kapp_theme'] 를 설정.
	  - 데이터가 생성되면 전달을 릴레이식으로 처리한다.
	  - pg_curl_get_ailinkapp.php
	  - table_curl_get_ailinkapp.php
	*/
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
				}
		} else {
			m_( "Server name Error, " . $A . ", " . $B.", ". $C );
		}
	}
?>