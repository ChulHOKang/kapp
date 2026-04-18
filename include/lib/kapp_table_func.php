<?php
	function KAPP_Table_Create_Func(){
		global $H_ID, $H_EMAIL, $table_yn, $mode, $line_set;
		global $config;
		global $tkher;
		global $project_code, $project_name, $new_tab_enm; 
		$new_tab_hnm	= $_POST["new_tab_hnm"];
		$item_list = " create table ". $new_tab_enm . " ( ";
		$item_list = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),';
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
		$item_list = $item_list . ' `kapp_memo` BLOB,';
		$cnt = 1;
		$item_array = "";
		$if_type = "";
		$if_data = "";
		$item_cnt   = 0;
		For( $ARR=1; isset($_POST["fld_hnm"][$ARR]) && $_POST["fld_hnm"][$ARR] !='' ; $ARR++ ) {
			if( isset($_POST['fld_enm'][$ARR]) && $_POST['fld_enm'][$ARR]!='' ) $fld_enm = $_POST['fld_enm'][$ARR];
			else continue;
			if( !Kcolumn_check($fld_enm) ) continue;
			$fld_hnm = $_POST['fld_hnm'][$ARR];
			if( $fld_hnm !== '' ) {
				$seqno		=	$_POST["seqno"][$ARR];
				$fld_type	=	$_POST["fld_type"][$ARR];
				if( isset($_POST["fld_len"][$ARR]) && $_POST["fld_len"][$ARR] !='' ) $fld_len	=	$_POST["fld_len"][$ARR];
				else $fld_len	=	15;
				$memo		=	$_POST["memo"][$ARR];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )				$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='BLOB' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='YEAR' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='MONTH' )      $item_list = $item_list . $fld_enm . ' ' .  ' VARCHAR (' . $fld_len . '),';
				$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$memo' ";
				$ret = sql_query( $sql );
				if( !$ret ) {
					m_("error --- insert table10_table - $new_tab_enm");
					echo "sql: " . $sql; exit;
				}
				$Asqltable=''; $if_lineA=0; $if_typeA=''; $if_dataA=''; $relation_dataA='';
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$line_set  = $cnt - 1;
		$ret = sql_query( "INSERT INTO {$tkher['table10_table']} set  tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$item_array', sqltable='$item_list' " );

		if( $ret ){
			$mq1 = sql_query( $item_list );
			if( !$mq1 ) {
				m_("error --- insert table10_table - $new_tab_enm");
				exit;
			} else {
				m_("--- Successful creation of the $new_tab_hnm table - $new_tab_enm.");
				$table_yn = 'y';
				$link_ = KAPP_URL_T_ . "kapp_table30m_A.php";
				insert_point_app( $H_ID, $config['kapp_write_point'], $link_, 'table10@table30m' );
			}
		} else {
			m_("INSERT table10_table ERROR create_func - tab seqno in "); exit;
		}

		$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$new_tab_enm',tab_hnm='$new_tab_hnm', pg_code='$new_tab_enm', pg_name='$new_tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set, userid='$H_ID', tab_mid='$H_ID' ";
		
		$rets = sql_query($query);
		if( $rets ){
			$Tret = TAB_curl_sendA( $new_tab_enm, $new_tab_hnm, 0, $item_list, 0, '', '', '', $item_array );
			if( $Tret ) {
				$sys_link = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $new_tab_enm; 
				$Pret = PG_curl_sendA( $line_set , $item_array, $if_type, $if_data, '', $sys_link, '' , '' );
			} else  m_("TAB_curl_sendA -- Error");
		} else {
			m_("Error INSERT table10_pg_table , $new_tab_enm , $new_tab_hnm ");
		}
		echo "<script>create_after_run( '$new_tab_enm' , '$new_tab_hnm' , '$mode' );</script>";
		exit;
	}
	function KAPP_Table_Create_Reaction_Func(){ // line reset
		global $H_ID, $tab_enm, $mode, $project_code, $project_name;
		global $config;
		global $tkher;
		$new_tab_hnm		= $_POST["new_tab_hnm"];
		$query	= " DELETE from {$tkher['table10_table']} where tab_enm='".$tab_enm."' and userid='".$H_ID."' ";
		$mq1	= sql_query($query);
		$query	= "drop table " . $tab_enm;
		$mq2	= sql_query($query);
		$cnt=0;
		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),';
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
		$item_list = $item_list . ' `kapp_memo` BLOB,';
		$item_array = "";
		$if_type = "";
		$if_data = "";
		For( $ARR=1; isset($_POST["fld_hnm"][$ARR]) && $_POST["fld_hnm"][$ARR] !='' ; $ARR++ ) {
			if( isset($_POST['fld_enm'][$ARR]) && $_POST['fld_enm'][$ARR]!='' ) $fld_enm = $_POST['fld_enm'][$ARR];
			else continue;
			if( !Kcolumn_check($fld_enm) ) continue;
			$fld_hnm	=	$_POST["fld_hnm"][$ARR];
			if( $fld_hnm !='' ) {
				$seqno		=	$_POST["seqno"][$ARR];
				$fld_enm		=	$_POST["fld_enm"][$ARR];
				$fld_type	=	$_POST["fld_type"][$ARR];
				if( $fld_type == 'CHAR' || $fld_type == 'VARCHAR' && $fld_len=='') $fld_len=15;
				else $fld_len	=	$_POST["fld_len"][$ARR];
				$memo		=	$_POST["memo"][$ARR];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )				$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='BLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='YEAR' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . '(' . $fld_len . '),';
				else if( $fld_type =='MONTH' )      $item_list = $item_list . $fld_enm . ' ' .  ' VARCHAR (' . $fld_len . '),';
				
				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', memo='$memo' " );
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set  group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=$cnt, userid='$H_ID', table_yn='y', memo='$item_array', sqltable='$item_list' " );
		$line_set = $cnt;
		$mq3 = sql_query( $item_list );
		if( !$mq3 ) {
			m_("k1 $tab_enm table creation failed.");
			printf("sql:%s", $item_list);
			exit;
		} else m_("  Successful creation of the $new_tab_hnm table.");
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
		$resultPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$query="UPDATE {$tkher['table10_pg_table']} SET item_cnt=$cnt, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$new_tab_hnm', pg_code='$tab_enm', pg_name='$new_tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$cnt, userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
			$link_ = KAPP_URL_T_ . "/kapp_table30m_A.php";
		}
		echo "<script>create_after_run( '$tab_enm' , '$new_tab_hnm' ,  '$mode' );</script>";
	}
	function Copy_Table_Func(){
		global $H_ID, $mode, $project_code, $project_name, $tab_enm;
		global $config;
		global $tkher;
		$new_tab_enm= $H_ID . "_" . time();
		$new_tab_hnm= $_POST["new_tab_hnm"];

		$item_list  = " create table ". $new_tab_enm . " ( ";
		$item_list  = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),'; 
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
		$item_list = $item_list . ' `kapp_memo` BLOB,';
		$cnt = 1;
		$item_array = "";
			$if_type = "";
			$if_data = "";
		$item_cnt   = 0;
		For( $ARR=1; isset($_POST["fld_hnm"][$ARR]) && $_POST["fld_hnm"][$ARR] !='' ; $ARR++ ) {
			if( isset($_POST['fld_enm'][$ARR]) && $_POST['fld_enm'][$ARR]!='' ) $fld_enm = $_POST['fld_enm'][$ARR];
			else continue;
			if( !Kcolumn_check($fld_enm) ) continue;
			$fld_hnm	=	$_POST["fld_hnm"][$ARR];
			if( $fld_hnm !='' ) {
				$seqno		=$_POST["seqno"][$ARR];
				$fld_enm	=$_POST["fld_enm"][$ARR];
				$fld_type	=$_POST["fld_type"][$ARR];
				if( $fld_type == 'CHAR' || $fld_type == 'VARCHAR' && $fld_len=='') $fld_len=15;
				else $fld_len	=	$_POST["fld_len"][$ARR];
				$memo		=$_POST["memo"][$ARR];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )					$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='BLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='YEAR' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . '(' . $fld_len . '),';
				else if( $fld_type =='MONTH' )      $item_list = $item_list . $fld_enm . ' ' .  ' VARCHAR (' . $fld_len . '),';

				sql_query( "INSERT INTO {$tkher['table10_table']} set tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$memo' " );
				$cnt++;
			}
		}
		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=$cnt, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$item_array', sqltable='$item_list' " );
		$line_set = $cnt;
		$fld_enm  = "fld_" . $ARR;
		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			m_( $new_tab_hnm . ", table creation failed.");
		} else {
			m_("  Successful creation of the ".$new_tab_hnm." table.");
			$link_ = KAPP_URL_T_ . "kapp_table30m_A.php";
			insert_point_app( $H_ID, $config['kapp_comment_point'], $link_, 'copy table10@kapp_table30m_A' );//re make copy
			TAB_curl_sendA( $new_tab_enm, $new_tab_hnm, 0, $item_list, 0, '', '', '', $item_array ); 
		}
		$old_tab_enm= $_POST['old_tab_enm'];
		$sqlPG		= "SELECT * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$old_tab_enm."' ";
		$resultPG	= sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$rsPG = sql_fetch_array($resultPG);
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$new_tab_enm', tab_hnm='$new_tab_hnm', pg_code='$new_tab_enm', pg_name='$new_tab_hnm', item_array='".$rsPG['item_array']."', if_type='".$rsPG['if_type']."', if_data='".$rsPG['if_data']."', pop_data='".$rsPG['pop_data']."', relation_data='', relation_type='', item_cnt=".$rsPG['item_cnt'].", userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
		} else {
			m_(" Copy ERROR : mode:".$mode.", old pg tab_enm: $tab_enm pg_code:".$new_tab_enm );
		}
		echo "<script>create_after_run( '$new_tab_enm' , '$new_tab_hnm' , '$mode' );</script>";
	}
	function KAPP_Table_Update_Remake_Func( $tab_enm ){
		global $H_ID, $mode, $project_code, $project_name;
		global $config;
		global $tkher;
		$query	="delete from {$tkher['table10_table']} where tab_enm='$tab_enm' and userid='$H_ID' ";
		$mq1	=sql_query($query);
		$query	="drop table $tab_enm";
		$mq2	=sql_query($query);
		$new_tab_hnm	= $_POST["new_tab_hnm"];	
		$cnt = 1;
		$item_list = " create table ". $tab_enm . " ( ";
		$item_list = $item_list . " `seqno` int(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),'; // add 20251118
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
		$item_list = $item_list . ' `kapp_memo` BLOB,';

		$item_array = '';
		$if_type = '';
		$if_data = '';
		For( $ARR=1; isset($_POST["fld_hnm"][$ARR]) && $_POST["fld_hnm"][$ARR] !='' ; $ARR++ ) {
			if( isset($_POST['fld_enm'][$ARR]) && $_POST['fld_enm'][$ARR]!='' ) $fld_enm = $_POST['fld_enm'][$ARR];
			else continue;
			if( !Kcolumn_check($fld_enm) ) continue;
			$fld_enmO	=	$_POST["Afld_enm"][$ARR];
			$fld_hnmO	=	$_POST["Afld_hnm"][$ARR];
			$fld_typeO	=	$_POST["Afld_type"][$ARR];
			$fld_lenO	=	$_POST["Afld_len"][$ARR];
			$fld_O      = "|". $fld_enmO ."|". $fld_hnmO  ."|". $fld_typeO ."|". $fld_lenO . "@";
			$fld_hnm	=	$_POST["fld_hnm"][$ARR];
			if( $fld_hnm !='' ) {
				$seqno		=	$_POST["seqno"][$ARR];
				$fld_enm	=	$_POST["fld_enm"][$ARR];
				$fld_type	=	$_POST["fld_type"][$ARR];
				$fld_len	=	$_POST["fld_len"][$ARR];
				if( $fld_type == 'CHAR' || $fld_type == 'VARCHAR' && $fld_len=='') $fld_len=15;
				$memo		=	$_POST["memo"][$ARR];
				$if_lineA	=	$_POST["Aif_line"][$ARR];
				$if_typeA	=	$_POST["Aif_type"][$ARR];
				$if_dataA	=	$_POST["Aif_data"][$ARR];
				$relation_dataA	=	$_POST["Arelation_data"][$ARR];
				$Asqltable = '';
				$i_data = "|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$item_array = $item_array . "|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				if( $fld_enm != $fld_enmO ) update_pg_func($fld_enm, $fld_enmO, $i_data, $fld_O);
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				if( $fld_type =='INT' )					$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='BIGINT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='TINYINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='SMALLINT' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='MEDIUMINT' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='FLOAT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DOUBLE' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='DECIMAL' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' default 0, ';
				else if( $fld_type =='CHAR' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='VARCHAR' )		$item_list = $item_list . $fld_enm . ' ' .  $fld_type. '(' . $fld_len . '),';
				else if( $fld_type =='TEXT' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='LONGBLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='BLOB' )   $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATE' )			$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='DATETIME' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIME' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='TIMESTAMP' )	$item_list = $item_list . $fld_enm . ' ' .  $fld_type . ' , ';
				else if( $fld_type =='YEAR' )       $item_list = $item_list . $fld_enm . ' ' .  $fld_type . '(' . $fld_len . '),';
				else if( $fld_type =='MONTH' )      $item_list = $item_list . $fld_enm . ' ' .  ' VARCHAR (' . $fld_len . '),';

				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', memo='$memo' " );
				$cnt++;
			}
		} // for

		$item_list = $item_list . " primary key(seqno) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$new_tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='10', disno=0, userid='$H_ID', table_yn='y', memo='$item_array', sqltable='$item_list' " );

		$line_set = $cnt-1;
		TAB_curl_sendA( $tab_enm, $new_tab_hnm,0 , $item_list, $_POST["Aif_line"][0], $_POST["Aif_type"][0], $_POST["Aif_data"][0], $_POST["Arelation_data"][0], $item_array );

		$mq1 = sql_query( $item_list );
		if( !$mq1 ) {
			echo "sql:" . $item_list; exit;
		} else m_( $tab_enm . ", Successful creation of the " . $new_tab_hnm . " table.");

		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='".$H_ID."' and pg_code='".$tab_enm."' ";
		$resultPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($resultPG);
		if( $table10_pg ) {
			$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', pg_name='$new_tab_hnm', tab_hnm='$new_tab_hnm', item_cnt=$line_set, item_array='$item_array', tab_mid='$H_ID' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
			sql_query($query);
		} else {
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$new_tab_hnm', pg_code='$tab_enm', pg_name='$new_tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$line_set, userid='$H_ID', tab_mid='$H_ID' ";
			sql_query($query);
				$link_ = KAPP_URL_T_ . "/kapp_table30m_A.php";
		}
		//echo "<script>location.replace(location.href)</script>";
	}
	function update_pg_func($fld_enm, $fld_enmO, $i_data, $fld_O){
		global $H_ID, $tab_enm, $mode, $view_set;
		global $config;
		global $tkher;
		$chg=0;
		$pgS ='';
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where tab_enm='".$tab_enm."' ";
		$retPG = sql_query($sqlPG);
		$table10_pg = sql_num_rows($retPG);
		if( $table10_pg ) {
			while( $rs = sql_fetch_array( $retPG)) {
				$pgS = $pgS . $rs['pg_code'] . ":" . $rs['pg_name'] . "|";
				$item_array = $rs['item_array'];
				$retA = str_replace($fld_O , $i_data, $item_array); 
				$query = "UPDATE {$tkher['table10_pg_table']} SET item_array='$retA' WHERE seqno=" . $rs['seqno'];
				sql_query($query);
				$chg=1;
			}
		}
		if( $chg == 1 && $view_set){
			m_( "ProgramS: " . $pgS . ", If you have settings for calculation formulas, pop-up windows, and relational expressions, you may need to check them. " . $item_array);
			$view_set = 0;
		}
	}
?>