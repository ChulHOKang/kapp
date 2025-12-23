<?php
include_once('./tkher_start_necessary.php');
	/*
	 * kapp_table_index_ajax.php - call:kapp_table_index_Create.php
	 */
	$H_ID= get_session("ss_mb_id");

if( $_POST['mode'] == 'kapp_table_index_delete'){

	$tab_enm = json_decode(getJsonText($_POST['tab_enm']), true);
    $index_name = json_decode(getJsonText($_POST['index_name']), true);
    $key_array = json_decode(getJsonText($_POST['key_array']), true);
	
	$sql = "ALTER TABLE $tab_enm DROP INDEX $index_name;";
	sql_query( $sql );

	$sql = "update {$tkher['table10_table']} SET relation_data='$key_array' where userid='$H_ID' && tab_enm='$tab_enm' && fld_enm='seqno' ";
	$ret = sql_query( $sql );
    if(!$ret) {
        echo "$tab_enm ERROR Update.";
        exit;
    } else {
        echo "Drop $tab_enm ok!";
        exit;
    }

} else if( $_POST['mode'] == 'kapp_table_index_add'){

	$tab_enm = json_decode(getJsonText($_POST['tab_enm']), true);
    $index_name = json_decode(getJsonText($_POST['index_name']), true);
    $index_data = json_decode(getJsonText($_POST['index_data']), true);
    $key_array = json_decode(getJsonText($_POST['key_array']), true);
	
	$itA= explode('|', $index_data);//|em_tran_2|tran_id|tran_rslt
	$icnt = count($itA);	//index_data: idx3|tran_status|tran_date|
	//$sql = "ALTER TABLE `$tableName` ADD KEY `$indexName` (`$indexColumn1`,`$indexColumn2`);";
	$sqlA = '';
	$sqlS = "ALTER TABLE `".$tab_enm."` ADD KEY `".$index_name."` ( ";
	if( $icnt == 3 ){ // key cnt = 1 -- 키 1개
		$sqlA = "`".$itA[2]."`";
	} else if($icnt > 3){ // key cnt > 1 -- 키 2개이상
		for( $i=2; $i< $icnt; $i++){
			if( $i == $icnt-1 ) $sqlA = $sqlA . "`".$itA[$i]."`";
			else $sqlA = $sqlA . "`".$itA[$i]."`,";
		}
	}
	$sqlS = $sqlS . $sqlA . " ); ";	//echo "$icnt, $index_data, sqlS: ". $sqlS; exit;
	$ret = sql_query( $sqlS ) or die ("$tab_enm index $index_name create Error sql:" . $sqlS);

	$sql = "update {$tkher['table10_table']} SET relation_data='$key_array' where userid='$H_ID' && tab_enm='$tab_enm' && fld_enm='seqno' ";
	$ret = sql_query( $sql );
    if(!$ret) {
        echo "$tab_enm ERROR Update.";
        exit;
    } else {
        echo "$index_name Create ok!";
        exit;
    }
}

function getJsonTextX($jsontext) { // jsonText '\' 값 제거 
    return str_replace("\\", "", $jsontext);
    //return str_replace("\\\"", "\"", $jsontext);
}

function Enc_checkX($_column){
    if($_column == 'mb_password') return true;
    else return false;
}
?>