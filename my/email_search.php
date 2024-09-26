<?php                                 
	/* include './coupon/tkher_db_lib.php';		
    include './coupon/tkher_dbcon_Table.php';  */
	include_once('../tkher_start_necessary.php');

	if($_POST['mode'] === 'email'){
		$name = json_decode(getJsonText($_POST["name"]), true); 
		$email = getJsonText(json_decode($_POST["email"]), true); 
		$SQL = " SELECT * from {$tkher['tkher_member_table']} where mb_name = '".$name."' and mb_email = '".$email."' ";  
		$result = sql_query($SQL);
		$rec = sql_num_rows($result);
	}

	//echo json_encode(count($result));
	//echo json_encode($rec);
	echo json_encode($SQL);

	function getJsonText($jsontext) { // jsonText '\' 값 제거 
		return str_replace("\\\"", "\"", $jsontext);
		}
?>