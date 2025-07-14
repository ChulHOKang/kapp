<?php 
  include_once('./tkher_start_necessary.php');

	$mode_update=$_POST['mode_update'];
	if( $mode_update === 'server_update'){
		$server_name =$_POST['server_name'];  // server_name
		$server_url  =$_POST['server_url'];   // curl server
		$admin_id    =$_POST['admin_id']; 
		$admin_level =$_POST['admin_level']; 
		$admin_password=$_POST['admin_password']; 
		if( $admin_level < 8 ) {
			echo "level ERROR";
			exit;
		}
//		echo "<br>curl_server_ajax - mode_update: ".$mode_update . ", server_url:" . $server_url . ", admin_id: " . $admin_id . ". admin_password:" . $admin_password;

		$up_day = date("Y-m-d H:i:s");
		$query = "select server_name from kapp_DB where admin_email='$admin_id' and admin_pw='".md5($admin_password)."' ";
		$row =	sql_fetch( $query ); 
		if( isset($row) && $row > 0 ) {
			$sql = "select kapp_theme from {$tkher['config_table']} where kapp_admin_email='$admin_id' ";
			$ret = sql_fetch($sql);
			$kapp_theme = explode('^', $ret['kapp_theme']);
			$server_url = $server_url . '^' . $kapp_theme[1];
			$sql = "update {$tkher['config_table']} set kapp_theme='$server_url' where kapp_admin_email='$admin_id' ";
			$ret = 	sql_query( $sql ); 
			if( !$ret) {
				echo " ERROR! update config";
				return false;
				exit;
			} else {
				//printf("<br>sql:%s", $sql );
				Servr_Update_curl_send( $server_name, $server_url, $admin_id, $admin_password );
				echo "--- save OK!";
				return true;
			}
		} else {
			echo "--- error! check the admin email and password during installation!";
			return false;
			exit;
		}

	} else {
		echo "ERROR - mode_update";
	}

	function Servr_Update_curl_send( $server_name, $server_url, $admin_id, $admin_password ){

		$up_day = date("Y-m-d H:i:s");
		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['server_name'] = $server_name;  // server 
		$tabData['data'][$cnt]['server_url']  = $server_url;   // curl server
		$tabData['data'][$cnt]['admin_id']    = $admin_id;
		$tabData['data'][$cnt]['admin_pw']    = $admin_password;
		$tabData['data'][$cnt]['up_day']      = $up_day;

		$key = 'appgenerator';
		$iv = "~`!@#$%^&*()-_=+";

		$sendData = encryptA( $tabData , $key, $iv);

		$url_ = 'https://fation.net/kapp/_Curl/Server_curl_get_ailinkapp.php'; 
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);

		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		//echo curl_error($curl);

		if( $res == false) {
			$_ms = "new curl_server_ajax fail : " . curl_error($curl);
			echo 'curl : ' . $_ms;	//m_(" ------------ : " . $_ms);
		} else {
			$_ms = 'new curl_server_ajax OK : ' . $res;
		}
		curl_close($curl);
	}
?>