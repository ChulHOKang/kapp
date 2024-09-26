<?php 
	include_once('../tkher_start_necessary.php');
	if($_SESSION['mb_level'] < 8) {
		m_("approach error. ---mb_level:".$member['mb_level']);
		echo "<script>window.open( './index.php' , '_self');</script>";
	}
                                
	$mode = $_POST['mode'];  
	if( $mode != 'Tkher_write' ) {  
		m_("Abnormal approach. ");  
		$rungo = 'ksd39673976_1711684888_table_add.php';  
		echo "<script>window.open( '$rungo' , '_self', ''); </script>";  
	} else {  
		$ff_nm = time() . '_';  
		$f_path = './' . $ff_nm;   // $f_path='./file/';  // dir add     
		$mq2=sql_query(" INSERT ksd39673976_1711684888 SET k_table_name = '$_POST[k_table_name]'  , k_table_link = '$_POST[k_table_link]'  , k_date = '".date("Y-m-d H:i:s")."'  , memo = '$_POST[memo]' ");   
		if( $mq2 ) {    
			$rdata = explode("@", $_SESSION['relation_dataPG']);   
			$rtype = explode("@", $_SESSION['relation_typePG']);   
			for( $i=0; $i < count( $rdata); $i++ ){   
				if( strlen( $rdata[$i] ) > 0 ) relation_func( $rdata[$i], $pg_code, $rtype[$i] ); 
			}   
			$rungo = 'ksd39673976_1711684888_table_add.php';   
			m_("Table_Insert OK!!!");
			echo "<script>window.open( '$rungo' , '_self', ''); </script>";   
		}//if   
	}   
?>