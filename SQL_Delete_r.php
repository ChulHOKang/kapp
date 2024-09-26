<?php
include "./SQL_Create_json.php";
/* include '../modu_shop/coupon/tkher_db_lib.php';		
include '../modu_shop/coupon/tkher_dbcon_Table.php';  */

if($_POST['mode'] === 't_delete'){
    $table_name = json_decode($_POST['table_name'], true);
    $prefix = json_decode($_POST['prefix'], true);

    Delete_table($prefix, $table_name);
}

function Delete_table($_prefix, $tab) {
    $kapp_tab = $_prefix.$tab;
    $SQL = " drop table ".$kapp_tab." ";
    $result = sql_query( $SQL );
    if( !$result ){
        echo json_encode("$tab Table Create Invalid query: " . $SQL);
        echo json_encode("Please check if the $tab table already exists.");
    } else {
        echo json_encode("Delete Success : $tab");
    }
}
?>