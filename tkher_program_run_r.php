<?php	
	include_once('./tkher_start_necessary.php');
	/*
		tkher_program_run_r.php : tkher_program_run.php from call - table_item_run50_app_pg50RU.php
		$f_path = KAPP_PATH_T_ . "/file/" .  $tab_mid . "/" . $tab_enm;;  $H_ID->tab_mid, $pg_code->tab_enm,  to
		Abnormal approach. pg_code:solpakan89_gmail_1750469450, tab_enm:solpakan89_gmail_1750469450, tab_mid:
	*/
	$H_ID = get_session("ss_mb_id"); //echo "h_id: ".$H_ID . "<br>";
	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";
	if( isset($_POST['pg_code']) ) $pg_code = $_POST['pg_code'];
	else $pg_code = "";
	if( isset($_POST['tab_enm']) ) $tab_enm = $_POST['tab_enm'];
	else $tab_enm = "";
	if( isset($_POST['pg_mid']) ) $pg_mid = $_POST['pg_mid'];
	else $pg_mid = "";
	if( isset($_POST['tab_mid']) ) $tab_mid = $_POST['tab_mid'];
	else $tab_mid = "";
	if( $pg_code =='' || $tab_enm =='' || $tab_mid =='') {
		m_("Abnormal approach. pg_code:$pg_code, tab_enm:$tab_enm, tab_mid:$tab_mid");
		$rungo = "./";
		exit;
	}
	if( $H_ID != '' ) {
		$H_LEV = $member['mb_level'];  
	} else {
		m_("You need to login.");
		echo "<meta http-equiv='refresh' content=0;url='tkher_program_data_list.php?pg_code=".$pg_code."'>";
		exit;
	}
	if( isset($_POST['pg_name']) ) $pg_name = $_POST['pg_name'];
	else $pg_name = "";
	set_session('pg_name',  $pg_name);
	set_session('pg_code',  $pg_code); 
	if( isset($_POST['item_array']) ) $item = $_POST['item_array'];
	else $item = "";
	if( isset($_POST['item_cnt']) ) $item_cnt = $_POST['item_cnt'];
	else $item_cnt = "";
	if( isset($_POST['iftype']) ) $iftype = $_POST['iftype'];
	else $iftype = "";
	$iftype = explode("|", $iftype);
 	$list = array();
	$ddd = "";
	$list = explode("@", $item);	

	$SQL = " INSERT " . $tab_enm . " SET ";
	$SQL = $SQL . "kapp_userid= '" . $H_ID . "' , ";
	$SQL = $SQL . "kapp_pg_code= '" . $pg_code . "', ";
	
	for( $i=0,$j=1; isset($list[$i]) && $list[$i] != ""; $i++, $j++ ){
			if( isset($iftype[$j]) ) $typeX = $iftype[$j]; 
			else $typeX = "";
			$ddd = $list[$i];
			$fld = explode("|", $ddd); 
		if( isset($fld[1]) && $fld[1] != "seqno") {
				$nm = $fld[1]; 
				if( isset($_POST[$nm]) ) $fld_enm = $_POST[$nm]; 
				else $fld_enm = "";
				if( isset($fld[1]) && isset($_POST[$fld[1]]) ) $post_fld = $_POST[$fld[1]];
				else $post_fld = "";
				if( $typeX=='3' ) {	// 3:chechbox
					if( isset($fld[1]) && isset($_POST[$fld[1]]) ) {
						$post_fld = $_POST[$fld[1]];
						$aa = @implode(",",$_POST[$fld[1]]);
					} else {
						$post_fld = "";
						$aa = " ";
					}
					if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "BIGINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ){
						if( $i==0 )	$SQL = $SQL . $nm . " = " . $aa . " ";
						else	    $SQL = $SQL . " , " .  $nm . " = " . $aa . " ";
					} else {
						if( $i==0 )	$SQL = $SQL . $nm . " = '" . $aa . "' ";
						else	    $SQL = $SQL . " , " .  $nm . " = '" . $aa . "' ";
					}
				} else if( $typeX=='9' ) {
					$f_path= '';
					$f_path = KAPP_PATH_T_ . "/file/" .  $tab_mid . "/" . $tab_enm;
					$f_path1= KAPP_PATH_T_ . "/file/" .  $tab_mid;
					if( !is_dir($f_path1) ) {
						if( !@mkdir( $f_path1, 0755 ) ) {
							m_("tkher_program_run_r - Error: f_path : " . $f_path1 . " Failed to create directory.");
							echo " Error: f_path : " . $f_path1 . " Failed to create directory. ";
							echo "<script>history.go(-1); </script>";exit;
						}
					}
					if( !is_dir($f_path) ) {
						if( !@mkdir( $f_path, 0755 ) ) {
							m_("tkher_program_run_r - Error: f_path : " . $f_path . " Failed to create directory.");
							echo " Error: f_path : " . $f_path . " Failed to create directory. ";
							echo "<script>history.go(-1); </script>";exit;
						}
					}
					$f_path= $f_path . "/";
					$upfile_name = $_FILES["$nm"]["name"];
					$upfile_name = str_replace(" ", "", $upfile_name);
					$upfile_name = $H_ID . "_" . time() ."_" . $upfile_name;
					if( $_FILES["$nm"]["error"] > 0){
						echo "Error Return Code: " . $_FILES["$nm"]["error"] . "<br>";
					} else {
						if( file_exists( $f_path . $upfile_name)) {
							move_uploaded_file($_FILES["$nm"]["tmp_name"], $f_path . $upfile_name );
						} else {
							move_uploaded_file($_FILES["$nm"]["tmp_name"], $f_path . $upfile_name );	//echo "Stored in: " . $f_path . $upfile_name . "<br>";
						}
					}
					if( $i==0 )	$SQL = $SQL . $nm ." = '" . $upfile_name . "' ";
					else	$SQL = $SQL . " , " . $nm ." = '" . $upfile_name . "' ";
				} else {
					if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "BIGINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ){
						if( !$post_fld || $post_fld == '') $post_fld = 0;
						if( $i==0 )	$SQL = $SQL . $nm . " = " . $post_fld . " ";
						else	    $SQL = $SQL . " , " .  $nm . " = " . $post_fld . " ";
					} else {
						if( $i==0 )	$SQL = $SQL . $nm . " = '" . $post_fld . "' ";
						else	    $SQL = $SQL . " , " .  $nm . " = '" . $post_fld . "' ";
					}
				}
		}
	}
	$rtype = '';
	$rdata = '';
	$mq2 = sql_query($SQL);
	if( $mq2 ) { 
		$relation_data =get_session("relation_dataPG");
		$relation_type =get_session("relation_typePG"); 
		if( $relation_data !='' ) {
			$rdata = explode("^", $relation_data);
			$rtype = explode("^", $relation_type);
			$rt = explode("@", $rtype[0]);
			for( $i=0; $i < count( $rdata); $i++ ){
				if( isset( $rdata[$i]) && $rdata[$i] !="" && $rdata[$i] !="undefined"){
					relation_func( $rdata[$i], $pg_code, $rt[$i] );
				}
			}
		}
		$rungo = "./tkher_program_data_list.php?pg_code=" . $pg_code;
		echo "<script>window.open( '$rungo' , '_self', ''); </script>";
	} else {
		m_(" insert ERROR --- mode:$mode, table: " . $tab_enm . ", pg_code: " . $pg_code);	exit;
	}
	function relation_func( $rdata, $pg_code, $rtype ){
		global $H_ID, $pg_code;
		$r_data = explode("$", $rdata);
		$r_tab = $r_data[0];
		$tab_r = explode(":", $r_tab);
		$r_table = $tab_r[0];
		$r_t = explode(":", $rtype);
		if( isset($r_t[0]) ) $r_type = $r_t[0];
		else $r_type = "";	
		if( isset($r_t[1]) ) $up_key = $r_t[1];
		else $up_key = "";
		if( isset($r_t[2]) ) $dd_key = $r_t[2];
		else $dd_key = "";
		if( isset($r_t[3]) ) $ty_key = $r_t[3];
		$ty_key = "";

		if( isset($_POST[$up_key]) && $_POST[$up_key] !='' ) $update_key_data = $_POST[$up_key];
		else $update_key_data = "";
		$SQLA = "select seqno from `" . $r_table . "` ";
		if( $ty_key == "CHAR" ) $SQLA = $SQLA . " where " . $dd_key . " = '" .$update_key_data. "' ";	
		else if( $ty_key == "INT" ) $SQLA = $SQLA . " where " . $dd_key . " = " .$update_key_data. " ";	
		else $SQLA = $SQLA . " where " . $dd_key . " = '" .$update_key_data. "' ";	// default
		$retA = sql_fetch( $SQLA ); // data check Update or Insert
		if( $r_type == 'Update'){
			$SQLR = "UPDATE " . $r_table . " SET ";
			for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
				$r_fld		= $r_data[$i];
				$fld_r		= explode("|", $r_fld);		// fld_1:name|=|fld_1:name
				$fld_r1	= $fld_r[0];
				$fld_sik= $fld_r[1];  // =, -, +
				$fld_r2	= $fld_r[2];
				$fld1	= explode(":", $fld_r1);		// program table -> fld_1:name|=|fld_1:name
				$f_enm	= $fld1[0];
				$fld2	= explode(":", $fld_r2);		// rellation table -> fld_1:name|=|fld_1:name
				$r_enm	= $fld2[0];
				if( isset($_POST[$f_enm]) )  $post_enm = $_POST[$f_enm];
				else $post_enm = "";
				if( $fld_sik == '=' ) {
					if( $i==1 )	$SQLR = $SQLR . $r_enm . " = '" . $post_enm . "'  ";
					else		$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
				} else if( $fld_sik == '+' ) {	 // updte
					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
					else		$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
				} else if( $fld_sik == '-' ) {	   // updte
					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
					else		$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
				}
			}
			if( $ty_key == "CHAR" ) $SQLR = $SQLR . " where " . $dd_key . " = '" .$update_key_data. "' ";	
			else if( $ty_key == "INT" ) $SQLR = $SQLR . " where " . $dd_key . " = " .$update_key_data. " ";	
			else $SQLR = $SQLR . " where " . $dd_key . " = '" .$update_key_data. "' ";	// default.

			if( $retA ) {
				$ret  = sql_query($SQLR);
				if( $ret ) {
				}else{
					echo "SQLR: " . $SQLR; exit;
				}
			} else {
				$SQLAR = "INSERT INTO " . $r_table . " SET ";
				$SQLAR = $SQLAR . "kapp_userid= '" . $H_ID . "' , ";
				$SQLAR = $SQLAR . "kapp_pg_code= '" . $pg_code . "' , ";
				for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
					$r_fld		= $r_data[$i];
					$fld_r		= explode("|", $r_fld);
					$fld_r1	= $fld_r[0];
					$fld_sik	= $fld_r[1];
					$fld_r2	= $fld_r[2];
					$fld1		= explode(":", $fld_r1);
					$f_enm	= $fld1[0];
					$fld2		= explode(":", $fld_r2);
					$r_enm	= $fld2[0];

					if( isset($f_enm) && isset($_POST[$f_enm]) )  $post_enm = $_POST[$f_enm];
					else $post_enm = "";
					if( $fld_sik == '=' ) {
						if( $i==1 )	$SQLAR = $SQLAR . $r_enm . " = '" . $post_enm . "'  ";
						else		$SQLAR = $SQLAR . " , "  . $r_enm . " = '" . $post_enm . "' ";
					} else if( $fld_sik == '+' ) {
						if( $i==1 )	$SQLAR = $SQLAR . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
						else		$SQLAR = $SQLAR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
					} else if( $fld_sik == '-' ) {
						if( $i==1 )	$SQLAR = $SQLAR . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
						else		$SQLAR = $SQLAR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
					}
				}
				$SQLAR = $SQLAR . " "; 
				$ret =sql_query($SQLAR);
				if( $ret ) { 
				}else{
					echo "SQLAR: " . $SQLAR; exit;
				}
			}
		} else { // insert - relation
			$SQLR = "INSERT INTO " . $r_table . " SET ";
			$SQLR = $SQLR . "kapp_userid= '" . $H_ID . "' , ";
			$SQLR = $SQLR . "kapp_pg_code= '" . $pg_code . "' , ";
			for( $i=1; isset($r_data[$i]) && $r_data[$i] !=""; $i++) {
				$r_fld		= $r_data[$i];
				$fld_r		= explode("|", $r_fld);
				$fld_r1	= $fld_r[0];
				$fld_sik	= $fld_r[1];
				$fld_r2	= $fld_r[2];
				$fld1		= explode(":", $fld_r1);
				$f_enm	= $fld1[0];
				$fld2		= explode(":", $fld_r2);
				$r_enm	= $fld2[0];
				if( isset($f_enm) && isset($_POST[$f_enm]) )  $post_enm = $_POST[$f_enm];
				else $post_enm = "";
				if( $fld_sik == '=' ) {
					if( $i==1 )	$SQLR = $SQLR . $r_enm . " = '" . $post_enm . "'  ";
					else			$SQLR = $SQLR . " , "  . $r_enm . " = '" . $post_enm . "' ";
				} else if( $fld_sik == '+' ) {
					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
					else			$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $post_enm . " ";
				} else if( $fld_sik == '-' ) {
					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
					else			$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $post_enm . " ";
				}
			}
			$SQLR = $SQLR . " ";
			$ret =sql_query($SQLR);
			if( $ret ) { 
			}else{
				echo "r_type: " . $r_type. ", i SQLR: " . $SQLR; exit;
			}
		}// if
	}
?>
