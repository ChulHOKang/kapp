<?php
	include_once('./tkher_start_necessary.php');
	/*
	tkher_program_run_r.php : tkher_program_run.php 에서 call - table_item_run50_app_pg50RU.php
	*/
	$mode = $_POST['mode'];
	if( $mode != 'table_pg70_write' ) {
		my_msg("Abnormal approach. ");
		$rungo = "./";
		echo "<script>window.open( '$rungo' , '_self', ''); </script>";
	}
	$H_ID	= get_session("ss_mb_id");$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if( !$H_ID ) {
		my_msg("You need to login.");
		exit;
	}
	$pg_name =$_POST['pg_name'];
	$pg_code =$_POST['pg_code'];
	set_session('pg_name',  $pg_name);
	set_session('pg_code',  $pg_code); 
	$tab_enm	= $_POST['tab_enm'];
	$item			= $_POST['item_array'];
	$item_cnt	= $_POST['item_cnt'];
	$iftype		= $_POST['iftype']; 
	$iftype = explode("|", $iftype);

 	$list = array();
	$ddd = "";

	$f_path= KAPP_PATH_T_ . "/file/" .  $H_ID . "/";
	$list = explode("@", $item);	//
	$SQL = " INSERT " . $tab_enm . " SET ";
	for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
			$typeX = $iftype[$j]; 
			$ddd = $list[$i]; echo "<br>$i: ddd=" . $ddd;
			$fld = explode("|", $ddd); 
		if( $fld[1] != "seqno") {
				$nm = $fld[1]; 
				$fld_enm = $_POST[$nm]; 
				if( $typeX=='3' ) {	// 3:체크박스 배열 처리
					$aa = @implode(",",$_POST[$fld[1]]);
					if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "BIGINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ){
						if( $i==0 )	$SQL = $SQL . $nm . " = " . $aa . " ";
						else	    $SQL = $SQL . " , " .  $nm . " = " . $aa . " ";
					} else {
						if( $i==0 )	$SQL = $SQL . $nm . " = '" . $aa . "' ";
						else	    $SQL = $SQL . " , " .  $nm . " = '" . $aa . "' ";
					}

				} else if( $typeX=='9' ) {	// 9:첨부화일 처리
					if ( $_FILES["$nm"]["error"] > 0){								// 에러가 있는지 검사하는 구문
						echo "Return Code: " . $_FILES["$nm"]["error"] . "<br>";	// 에러가 있으면 어떤 에러인지 출력함 -> 'Return Code 4'
					} else {														// 에러가 없다면
						if ( file_exists( $f_path . $_FILES["$nm"]["name"])) 
						{																// 같은 이름의 파일이 존재하는지 체크를 함
							move_uploaded_file($_FILES["$nm"]["tmp_name"], $f_path . $_FILES["$nm"]["name"] );
						} else {														// 동일한 파일이 없다면
							move_uploaded_file($_FILES["$nm"]["tmp_name"], $f_path . $_FILES["$nm"]["name"] );
							echo "Stored in: " . $f_path . $_FILES["$nm"]["name"] . "<br>";	// upload 폴더에 저장된 파일의 내용 Stored in: ./file/ksd39673967/1.jpg
						}
					}
					if( $i==0 )	$SQL = $SQL . $nm ." = '" . $_FILES["$nm"]["name"] . "' ";
					else	$SQL = $SQL . " , " . $nm ." = '" . $_FILES["$nm"]["name"] . "' ";
				} else {
					//if( $i==0 )	$SQL = $SQL . $nm ." = '" . $_POST[$fld[1]] . "' ";
					//else	$SQL = $SQL . " , " . $nm ." = '" . $_POST[$fld[1]] . "' ";
					if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "BIGINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ){
						if( $i==0 )	$SQL = $SQL . $nm . " = " . $_POST[$fld[1]] . " ";
						else	    $SQL = $SQL . " , " .  $nm . " = " . $_POST[$fld[1]] . " ";
					} else {
						if( $i==0 )	$SQL = $SQL . $nm . " = '" . $_POST[$fld[1]] . "' ";
						else	    $SQL = $SQL . " , " .  $nm . " = '" . $_POST[$fld[1]] . "' ";
					}
				}
		}
	}
	//echo "sql: " . $SQL; exit;//sql: INSERT dao_1662608720 SET fld_1 = 'LK99' , fld_2 = '2024-01-03' , fld_3 = '12:30' , fld_4 = 'aaaa' , fld_5 = '남' , fld_6 = '2000-03-12' , fld_7 = '010-1111-2222' , fld_8 = '010-3333-3333' , fld_9 = 'ㅅㄷㄴ' , gubun = '30'

	$mq2 = sql_query($SQL);
	if( $mq2 ) { 
		$relation_data =get_session("relation_dataPG");
		$relation_type =get_session("relation_typePG"); // add : 2022-02-11
		$rdata = explode("@", $relation_data);
		$rtype = explode("@", $relation_type);

		//m_("---- $relation_data, $relation_type");
		//---- dao_1644456532:거래처$fld_2:거래처|=|fld_1:거래처명$fld_6:외상매출액|+|fld_7:미수총액, Update:fld_1:
		for( $i=0; $i < count( $rdata); $i++ ){
			if( strlen( $rdata[$i] ) > 0 ) relation_func( $rdata[$i], $pg_code, $rtype[$i] ); 
		}
		$rungo = "./tkher_program_data_list.php?pg_code=" . $pg_code;
		echo "<script>window.open( '$rungo' , '_self', ''); </script>";
		/*if( $relation_data ) { //m_("relation_data: " . $relation_data);
			relation_func( $relation_data, $pg_code, $relation_type ); // $relation_type add
		} else {
			$rungo = "./tkher_program_data_list.php?pg_code=" . $pg_code;
			echo "<script>window.open( '$rungo' , '_self', ''); </script>";
		}*/
	} else {
		m_(" insert ERROR --- mode:$mode, table: " . $tab_enm . ", pg_code: " . $pg_code);	
		echo "<br>sql: " . $SQL; exit;
		//insert ERROR --- mode:table_pg70_write, table: dao_1662608720, pg_code: dao_1704247645
		//$relation_data= $_POST['relation_data'];
		//my_msg("Relation data insert ERROR --- mode:$mode, relation_data:$relation_data");	
	}
	//function relation_func( $rdata, $pg_code ){
	function relation_func( $rdata, $pg_code, $rtype ){
		$r_data = explode("$", $rdata);
		$r_tab = $r_data[0];
		$tab_r = explode(":", $r_tab);		//dao_1537844601:입고정보
		$r_table = $tab_r[0];

		$r_t = explode(":", $rtype);	// '^' -> ':' 로 Update:fld_1:fld_2:

		$r_type = $r_t[0];					// type = 'Update' or 'Insert'
		$up_key = $r_t[1];					// program field ,    //Update Key field 
		$dd_key = $r_t[2];					// Update Key field , //program field 
		$ty_key = $r_t[3];					// relation field key data type

		//$update_key_data = $_POST[$dd_key];
		$update_key_data = $_POST[$up_key];

		if( $r_type == 'Update'){
			$SQLR = "UPDATE " . $r_table . " SET ";
			for( $i=1;$r_data[$i] !=""; $i++) {
				$r_fld		= $r_data[$i];
				$fld_r		= explode("|", $r_fld);		// fld_1:상품|=|fld_1:상품
				$fld_r1	= $fld_r[0];
				$fld_sik= $fld_r[1];
				$fld_r2	= $fld_r[2];
				$fld1	= explode(":", $fld_r1);		// program table -> fld_1:상품|=|fld_1:상품
				$f_enm	= $fld1[0];
				$fld2	= explode(":", $fld_r2);		// rellation table -> fld_1:상품|=|fld_1:상품
				$r_enm	= $fld2[0];

				//if( $r_enm == $update_key ) {
				//	$update_key_data = $_POST[$f_enm];
				//}

				if( $fld_sik == '=' ) {
					if( $i==1 )	$SQLR = $SQLR . $r_enm . " = '" . $_POST[$f_enm] . "'  ";
					else		$SQLR = $SQLR . " , "  . $r_enm . " = '" . $_POST[$f_enm] . "' ";
				} else if( $fld_sik == '+' ) {	 // updte를 의미한다. 보완필요.
					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " + " . $_POST[$f_enm] . " ";
					else		$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $_POST[$f_enm] . " ";
				} else if( $fld_sik == '-' ) {	 // updte를 의미한다. 보완필요.
					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " - " . $_POST[$f_enm] . " ";
					else		$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $_POST[$f_enm] . " ";
				}
			}

			//if( $ty_key == "CHAR" ) $SQLR = $SQLR . " where " . $up_key . " = '" .$update_key_data. "' ";	
			//else if( $ty_key == "INT" ) $SQLR = $SQLR . " where " . $up_key . " = " .$update_key_data. " ";	
			//else $SQLR = $SQLR . " where " . $up_key . " = '" .$update_key_data. "' ";	// default 문자열로 처리.

			if( $ty_key == "CHAR" ) $SQLR = $SQLR . " where " . $dd_key . " = '" .$update_key_data. "' ";	
			else if( $ty_key == "INT" ) $SQLR = $SQLR . " where " . $dd_key . " = " .$update_key_data. " ";	
			else $SQLR = $SQLR . " where " . $dd_key . " = '" .$update_key_data. "' ";	// default 문자열로 처리.

			$ret  = sql_query($SQLR);
			if( $ret ) { //echo("<script>alert('Relation Save pg70_write_r: relation-Table is $r_table Created.  ');</script>");
				$rungo = "./tkher_program_data_list.php?pg_code=" . $pg_code;
				echo "<script>window.open( '$rungo' , '_self', ''); </script>";
			}else{
				echo "sql: " . $SQLR; exit;
				//sql: UPDATE dao_1644456532 SET fld_1 = '현대' , fld_7=fld_7 + 6000 where fld_1: = ''
				//printf('Relation data insert ERROR sqlr:%s', $SQLR); 
			}
		} else { // insert
			$SQLR = "INSERT INTO " . $r_table . " SET ";
			for( $i=1;$r_data[$i] !=""; $i++) {
				$r_fld		= $r_data[$i];
				$fld_r		= explode("|", $r_fld);		// fld_1:상품|=|fld_1:상품
				$fld_r1	= $fld_r[0];
				$fld_sik	= $fld_r[1];
				$fld_r2	= $fld_r[2];
				$fld1		= explode(":", $fld_r1);		// fld_1:상품|=|fld_1:상품
				$f_enm	= $fld1[0];
				$fld2		= explode(":", $fld_r2);		// fld_1:상품|=|fld_1:상품
				$r_enm	= $fld2[0];

				if( $fld_sik == '=' ) {
					if( $i==1 )	$SQLR = $SQLR . $r_enm . " = '" . $_POST[$f_enm] . "'  ";
					else			$SQLR = $SQLR . " , "  . $r_enm . " = '" . $_POST[$f_enm] . "' ";
				} else if( $fld_sik == '+' ) {	 // updte를 의미한다. 보완필요.

					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " + " . $_POST[$f_enm] . " ";
					else			$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " + " . $_POST[$f_enm] . " ";
				} else if( $fld_sik == '-' ) {	 // updte를 의미한다. 보완필요.
					if( $i==1 )	$SQLR = $SQLR . $r_enm . "=" . $r_enm . " - " . $_POST[$f_enm] . " ";
					else			$SQLR = $SQLR . " , " . $r_enm . "=" . $r_enm . " - " . $_POST[$f_enm] . " ";
				}
			}
			$SQLR = $SQLR . " ";
			$ret =sql_query($SQLR);
			if( $ret ) { 
				//echo("<script>alert('Relation Save pg70_write_r: relation-Table is $r_table Created.  ');</script>");
				$rungo = "./tkher_program_data_list.php?pg_code=" . $pg_code;
				echo "<script>window.open( '$rungo' , '_self', ''); </script>";
			}else{
				printf('Relation data insert ERROR sqlr:%s', $SQLR); 
			}
		}// if
	}
?>
