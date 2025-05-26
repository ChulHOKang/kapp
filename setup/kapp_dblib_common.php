<?php
	// kapp_dblib_common.php DB 연결   - kapp_dbcon_create.php 에서 사용 - 중요.
	function sql_connect($host, $user, $pass, $db=KAPP_MYSQL_DB)      
	{      
		global $tkher;      
		if( function_exists('mysqli_connect') && KAPP_MYSQLI_USE) {      
			$link = mysqli_connect($host, $user, $pass, $db);      
			// 연결 오류 발생 시 스크립트 종료      
			if (mysqli_connect_errno()) {
				$link = "dberror";
				return $link;
				die('Connect Error: '.mysqli_connect_error());      
			}      
		} else {      
			$link = mysql_connect($host, $user, $pass);      
		}      
		return $link;      
	}      
	// DB 선택      
	function sql_select_db($db, $connect)      
	{      
		global $tkher;      
		if( function_exists('mysqli_select_db') && KAPP_MYSQLI_USE)      
			return @mysqli_select_db($connect, $db);      
		else      
			return @mysql_select_db($db, $connect);      
	}      
	function sql_set_charset($charset, $link=null)      
	{      
		global $tkher;      
		if( !$link) $link = $tkher['connect_db'];      
		if( function_exists('mysqli_set_charset') && KAPP_MYSQLI_USE)      
			mysqli_set_charset($link, $charset);      
		else      
			mysql_query(" set names { $charset } ", $link);      
	}      
	function sql_query($sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null)
	{
		global $tkher;

		if(!$link)
			$link = $tkher['connect_db'];

		// Blind SQL Injection 취약점 해결
		$sql = trim($sql);
		
		$sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql); // union의 사용을 허락하지 않습니다.
		
		$sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql); // `information_schema` DB로의 접근을 허락하지 않습니다.

		if( function_exists('mysqli_query') && KAPP_MYSQLI_USE) {
			if ($error) {
				//echo "mysqli --- ERROR <br>";
				$result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
			} else {
				//echo "mysqli --- OK <br>";
				$result = @mysqli_query($link, $sql);
			}
		} else {
			if ($error) {
				$result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
			} else {
				$result = @mysql_query($sql, $link);
			}
		}

		return $result;
	}


	// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
	function sql_fetch( $sql, $error=KAPP_DISPLAY_SQL_ERROR, $link=null)
	{
		global $tkher;

		if(!$link)
			$link = $tkher['connect_db'];

		$result = sql_query($sql, $error, $link);
		//$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
		$row = sql_fetch_array($result);
		return $row;
	}


	// 결과값에서 한행 연관배열(이름으로)로 얻는다.
	function sql_fetch_array($result)
	{
		if( function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE)
			$row = @mysqli_fetch_assoc($result);
		else
			$row = @mysql_fetch_assoc($result);

		return $row;
	}

	function sql_num_rows($result)
	{
		if( function_exists('mysqli_num_rows') && KAPP_MYSQLI_USE)
			return mysqli_num_rows($result);
		else
			return mysql_num_rows($result);
	}

	// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
	// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
	// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
	function sql_free_result($result)
	{
		if( function_exists('mysqli_free_result') && KAPP_MYSQLI_USE)
			return mysqli_free_result($result);
		else
			return mysql_free_result($result);
	}
	//========  add 2024-04-01
	function check_passwordA($pass, $hash)
	{
		$password = get_encrypt_stringA($pass);

		return ($password === $hash);
	}
	function get_encrypt_stringA($str)
	{  // TKHER_STRING_ENCRYPT_FUNCTION, KAPP_STRING_ENCRYPT_FUNCTION
		if(defined('KAPP_STRING_ENCRYPT_FUNCTION') && KAPP_STRING_ENCRYPT_FUNCTION) {
			$encrypt = call_user_func(KAPP_STRING_ENCRYPT_FUNCTION, $str);
		} else {
			$encrypt = sql_passwordA($str);
		}

		return $encrypt;
	}
	function sql_passwordA($value)
	{
		// mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
		// mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
		$row = sql_fetch(" select password('$value') as pass ");

		return $row['pass'];
	}
?>