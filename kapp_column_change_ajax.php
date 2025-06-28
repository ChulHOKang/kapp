<?php 
	include_once('./tkher_start_necessary.php');
	/*
		kapp_column_change_ajax.php : app_pg50RU.php 에서 콜 사용.
		- image data name column length change - image name length:255
	*/
	$H_ID	= get_session("ss_mb_id"); 
	if( !isset($H_ID) || $H_ID =='' ){
		echo "Login Please!"; return false;
	}

	$mode= $_POST['mode'];
	$day = date("Y-m-d H:i:s");

	if( $mode === 'column_change'){
		$pg_enm = $_POST['pg_enm'];
		$tab_enm= $_POST['tab_enm'];
		$fld_enm= $_POST['fld_enm'];
		$fld_type= $_POST['fld_type'];
		$fld_len = 255;

		$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type . "(". $fld_len .") DEFAULT NULL";
		$mq1=sql_query($query);
		if( $mq1 ) {
			$sql = "update {$tkher['table10_table']} set fld_len=255 where tab_enm='$tab_enm' and fld_enm='$fld_enm' ";
			$ret = sql_query($sql);
			if( $ret ) echo " column length update OK!";
		}else{
			echo " column modify error ! ";
		}
	}
	else if( $mode === 'grant_view_change'){
		$pg_code = $_POST['pg_code'];
		$grant_view= $_POST['grant_view'];

			$sql = "update {$tkher['table10_pg_table']} set grant_view=$grant_view where pg_code='$pg_code' ";
			$ret = sql_query($sql);
			if( $ret ) echo " grant view update OK!";
			else echo " grant view update error!";
	}
	else if( $mode === 'grant_write_change'){
		$pg_code = $_POST['pg_code'];
		$grant_write= $_POST['grant_write'];

			$sql = "update {$tkher['table10_pg_table']} set grant_write=$grant_write where pg_code='$pg_code' ";
			$ret = sql_query($sql);
			if( $ret ) echo " grant write update OK!";
			else echo " grant write update error!";
	}
?>