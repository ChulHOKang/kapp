<?php
// 사용한다.
if( !$infor ) {
	if( isset($_REQUEST['infor']) )      $infor = $_REQUEST['infor'];
	else if( isset($_POST['infor']) )    $infor = $_POST['infor'];
	else if( isset($_SESSION['infor']) ) $infor = $_SESSION['infor'];
} 
if( empty($infor) ) {
	m_("infor.php error infor: " . $infor); //infor.php error infor: 
	return;
}

//m_("infor.php infor: " . $infor);
$query		= "SELECT * from {$tkher['aboard_infor_table']} where no=".$infor . " or table_name='".$infor."' ";
$infor_mq	= sql_query( $query );
$tot		= sql_num_rows( $infor_mq );
/*
if( !$tot ){
	//m_("infor.php error2 infor: " . $infor);
	$query		= "SELECT * from {$tkher['aboard_infor_table']} where table_name='$infor'";
	$infor_mq	= sql_query( $query );
	$tot		= sql_num_rows( $infor_mq );
}*/

//$mf_array	= sql_fetch_array( $infor_mq );
$mf_infor	= sql_fetch_row( $infor_mq );

	$infor_0 = $mf_infor[0];
	$infor_1 = $mf_infor[1];
	$infor_2 = $mf_infor[2];
	$infor_4 = $mf_infor[4];
	$infor_5 = $mf_infor[5];
	$infor_16 = $mf_infor[16];
	$infor_38 = $mf_infor[38];
	$infor_45 = $mf_infor[45];
	$infor_46 = $mf_infor[46];
	$tab = "aboard_" . $mf_infor[2];
$infor_ar	= sql_query( $query );
$mf_array	= sql_fetch_array( $infor_ar );

?>