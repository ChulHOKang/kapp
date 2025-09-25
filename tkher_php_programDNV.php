<?php
	include_once('./tkher_start_necessary.php');
	/* ----------------------------------------------------------------------
		tkher_php_programDNV.php : write and write_r source create and download.
		- call : tkher_program_data_listDN.php : data list program.
				: tkher_program_data_view.php - call standard.
				: view and update source create and down.
	---------------------------------------------------------------------- */
	$H_ID		= get_session("ss_mb_id"); 
	$H_LEV=$member['mb_level']; 
	if( !$H_ID or $H_LEV < 2 ) {
		my_msg("You need to login. ");exit;
		//echo "<script>window.open('/', '_top', '');</script>";exit;
	}

	/////////////////////////< tree file create >////////////////////////////
	$mid = $H_ID;
	//$path = KAPP_PATH_ . "/cratree/";	 //KAPP_PATH_CRATREE_;		// . "../../cratree/";
	$path = KAPP_PATH_T_ . "/file/"; 

	$pg_code 	= $_REQUEST['pg_code'];
	$mode 		= $_POST['mode'];
	if( $mode=='view') {
		if( $H_ID != 'dao' ) coin_minus_func($H_ID, 1000);
		$seqno		= $_POST['seqno'];
		$tab_enm	= $_POST['tab_enm'];
		$item_cnt	= $_POST['item_cnt'];
		if( isset($_POST['item_array']) ) $item_array = $_POST['item_array'];
		else $item_array = '';

//		if( isset($_SESSION['if_typePG']) ) $if_type 	= $_SESSION['if_typePG'];
//		if( isset($_SESSION['if_dataPG']) ) $if_data 	= $_SESSION['if_dataPG'];
//		if( isset($_SESSION['relation_dataPG']) ) $relation_data 	= $_SESSION['relation_dataPG'];

		if( isset($_SESSION['if_typePG']) ) $if_typePG 	= $_SESSION['if_typePG'];
		else $if_typePG 	='';
		if( isset($_SESSION['if_dataPG']) ) $if_dataPG 	= $_SESSION['if_dataPG'];
		else $if_dataPG 	='';
		if( isset($_SESSION['pop_dataPG']) ) $pop_dataPG 	= $_SESSION['pop_dataPG'];
		else $pop_dataPG 	='';
		if( isset($_SESSION['relation_dataPG']) ) $relation_dataPG= $_SESSION['relation_dataPG'];
		else $relation_dataPG 	='';

	} else{
		m_("write_r : Error, "); exit();
	}
	//-------------------------------------- list end ----------------------

	//--------------- view start -------------------------------------------
	$runF3		= $path . $H_ID . "/" . $pg_code . "_view.php";
	$fsi			= fopen("$runF3","w+");		//write file

	fwrite($fsi,"<?php \r\n");
/*
fwrite($fsi,"	$"."searchNameAA = $"."_SERVER['HTTP_HOST'];  \r\n");
fwrite($fsi,"	$"."searchNameBB = $"."_SERVER['DOCUMENT_ROOT'];  \r\n");
fwrite($fsi,"	$"."searchNameA = 'appgenerator.net';  \r\n");
fwrite($fsi,"	$"."searchNameB = 'appgenerator.net';  \r\n");
fwrite($fsi,"	if( $"."_SERVER['HTTP_HOST'] == $"."searchNameA ) {   \r\n");
fwrite($fsi,"       include '../../tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsi,"		include '../../tkher_dbconX.php';		  \r\n");
fwrite($fsi,"	} else if( $"."_SERVER['HTTP_HOST'] == $"."searchNameB ) {   \r\n");
fwrite($fsi,"       include '../../tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsi,"		include '../../tkher_dbconX.php';		  \r\n");
fwrite($fsi,"	} else {  \r\n");
fwrite($fsi,"       include './tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsi,"		include './tkher_dbcon_Table.php';  \r\n");// tkher_dbcon.php
fwrite($fsi,"		// DB 정보를  사용자 서버에서 설치할떄  \r\n");
fwrite($fsi,"		// tkher_dbcon_create.php에서 generator.  \r\n");
fwrite($fsi,"	}  \r\n");
*/
fwrite($fsi,"	$"."searchNameA = '".KAPP_URL_T_."';  \r\n");
fwrite($fsi,"	if( strpos( $"."searchNameA, $"."_SERVER['HTTP_HOST']) == true) {    \r\n");
fwrite($fsi,"			include '" . KAPP_PATH_T_ . "/tkher_start_necessary.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsi,"	} else {    \r\n");
fwrite($fsi,"			include './tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsi,"			include './tkher_dbcon_Table.php';  \r\n");// tkher_dbcon.php
fwrite($fsi,"		// DB 정보를  사용자 서버에서 설치할떄  \r\n");
fwrite($fsi,"		// tkher_dbcon_create.php에서 generator.  \r\n");
fwrite($fsi,"	}  \r\n");

//fwrite($fsi," include './table_paging.php';	\r\n"); // 2023-07-06 tkher_db_lib.php 에 pagingA()로 생성 사용
fwrite($fsi,"?> \r\n");

fwrite($fsi,"<html> \r\n");
fwrite($fsi,"<head> \r\n");
fwrite($fsi,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
fwrite($fsi,"<TITLE>AppGenerator is generator program. Made in ChulHo Kang : solpakan89@gmail.com</TITLE>  \r\n");
fwrite($fsi,"<link rel='shortcut icon' href='/logo/logo25a.jpg'> \r\n");
fwrite($fsi,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
fwrite($fsi,"<meta name='keywords' content='app generator, app maker, appgenerator, app, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
fwrite($fsi,"<meta name='description' content='app generator, app maker, appgenerator, app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
fwrite($fsi,"<meta name='robots' content='ALL'> \r\n");
	fwrite($fsi,"</head> \r\n");
	//----------------------------- head -------------------------------------
	fwrite($fsi,"<?php                                 \r\n");
	
//	fwrite($fsi,"	$"."menu1TWPer=15;  \r\n");
	
	fwrite($fsi,"	$"."is_mobile = false;  \r\n");
	fwrite($fsi,"	$"."is_mobile = preg_match('/'.KAPP_MOBILE_AGENT.'/i', $"."_SERVER['HTTP_USER_AGENT']);   \r\n");
//	fwrite($fsi,"	if( $"."is_mobile ) $"."menu1TWPer=36;    \r\n");
	fwrite($fsi,"	$"."menu1TWPer=15;  \r\n");
	fwrite($fsi,"	if( $"."is_mobile ) $"."menu1TWPer=36;    \r\n");

	fwrite($fsi,"	$"."menu1AWPer=100 - $"."menu1TWPer;  \r\n");
	fwrite($fsi,"	$"."menu2TWPer=10;  \r\n");
	fwrite($fsi,"	$"."menu2AWPer=50 - $"."menu2TWPer;  \r\n");
	fwrite($fsi,"	$"."menu3TWPer=10;  \r\n");
	fwrite($fsi,"	$"."menu3AWPer=33.3 - $"."menu3TWPer;  \r\n");
	fwrite($fsi,"	$"."menu4TWPer=10;  \r\n");
	fwrite($fsi,"	$"."menu4AWPer=25 - $"."menu4TWPer;  \r\n");
	fwrite($fsi,"	$"."Xwidth='100%';  \r\n");
	fwrite($fsi,"	$"."Xheight='100%';  \r\n");
	fwrite($fsi,"?>                                 \r\n");
	//----------------- style --------------------------------------------
	fwrite($fsi,"<style>  \r\n");
	fwrite($fsi,"* {  box-sizing: border-box;}  \r\n");
	fwrite($fsi,".header2A {width:100%;  height:50px;  float: left;  border: 0px solid red;  padding: 0px;}  \r\n");
//	fwrite($fsi,".menu1Area{width:100%;  height:60px;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
	fwrite($fsi,".menu1Area{width:100%;  height:auto;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
	fwrite($fsi,".menu2T{padding-top:3px; width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FAFAFA;}  \r\n");
	fwrite($fsi,".menu2A {width:25%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE; background-color:#FAFAFA;} \r\n");
	fwrite($fsi,".data2A {width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,".input1A { padding:0px;}  \r\n");
	fwrite($fsi,".mainA {width:100%;  float: left; padding:15px; border:1px solid red;}  \r\n");
	fwrite($fsi,".menu1T {padding-top:0px; width:<?=$"."menu1TWPer?>%; height:30px; float:left; padding:6px; border:1px solid #DEDEDE;background-color:#FAFAFA;}  \r\n");
	fwrite($fsi,".menu1A {width:<?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 0px;}  \r\n");
	fwrite($fsi,".data1A {width:<?=$"."menu1AWPer?>%; height:30px; float:left;padding:6px;border:1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,"radio1A {width:<?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 6px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,".ListBox1A {width: <?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");

	fwrite($fsi,".File1A {  width: <?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,".menu4T {padding-top:3px; width:10%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE;background-color:#FAFAFA;}  \r\n");
	fwrite($fsi,".input4A {width:15%;  height:30px;  float:left;  padding:0px; border:1px solid #DEDEDE;  background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,".menu4B {width: 15%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
	fwrite($fsi,".data4A {width:15%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,".main4A {width:100%;  float: left;  padding: 15px;  border: 1px solid #DEDEDE;}  \r\n");
	fwrite($fsi,".blankA {border-top:0px;	width: 100%;    float: left;	height: 1px;	padding: 0px;	border: 1px solid #FFFFFF;background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,".blankB {width:100%;  height: 1px;  padding: 1px;  float: left;  border: 1px solid #FFFFFF;  background-color:#FFFFFF;}  \r\n");
	fwrite($fsi,".viewSubjX{margin-top:1px;	width:100%;height:35px;	line-height:32px;border-top:3px solid #d01c27;	text-align:center;background:#fafafa;border-bottom:1px solid #dedede;overflow:hidden;font-size:18px;color:#69604f;}  \r\n");
	fwrite($fsi,".viewSubjX span{font-size:22px;color:#171512; vertical-align:baseline; }  \r\n");
	fwrite($fsi,".HeadTitle02AX{display:inline-block;	margin:0 1px;	height:35px;	line-height:35px;	padding:0 20px;	font-size:25px;	background:#d01c27;	color:#ffffff;	border-radius:5px;}  \r\n");
	fwrite($fsi,".HeadTitle01AX{display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;font-size:22px;background:#d01c27;color:#fff;border-radius:5px;}  \r\n");
	fwrite($fsi,".HeadTitle01AX a.on{background:#d01c27;color:#fff;}  \r\n");
	fwrite($fsi,".HeadTitle01A{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  \r\n");
	fwrite($fsi,".HeadTitle02A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  \r\n");
	fwrite($fsi,".HeadTitle01A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;	font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  \r\n");
	fwrite($fsi,".HeadTitle01A a.on{background:#d01c27;color:#fff;}  \r\n");
	fwrite($fsi,".Btn_List01A{width:64px;height:33px;display:inline-block;line-height:33px;	text-align:center;color:#fff;font-size:14px;background:#d01d27;	margin-right: 10px;	}  \r\n");
	fwrite($fsi,".Btn_List02A{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  \r\n");

	fwrite($fsi,".Btn_List03A{width:104px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  \r\n");

	fwrite($fsi,".viewHeader{width:100%;height:auto;overflow:hidden;position:relative;text-align:right;}  \r\n");
	fwrite($fsi,".viewHeader span{position:absolute;left:0;top:12px;font-size:14px;color:#686868;}  \r\n");
	fwrite($fsi,".boardView{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
	fwrite($fsi,".boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
	fwrite($fsi,"</style>  \r\n");

	//--------------------------------------------------------  script -----------------
	fwrite($fsi,"<script language='JavaScript'>   \r\n"); 
	fwrite($fsi,"	function table_data_list($"."pg_code) {   \r\n");
	fwrite($fsi,"		document.form_view.action='".$pg_code."_run.php?pg_code=' + $"."pg_code;   \r\n");
	fwrite($fsi,"		document.form_view.target='_self';   \r\n");
	fwrite($fsi,"		document.form_view.submit();   \r\n");
	fwrite($fsi,"	}   \r\n");

	fwrite($fsi,"	function popimage(imagesrc,winwidth,winheight){   \r\n");
	fwrite($fsi,"		var look='width=800,height=600,';   \r\n");
	fwrite($fsi,"		popwin=window.open('','',look);   \r\n");
	fwrite($fsi,"		popwin.document.open();   \r\n");
	fwrite($fsi,"		popwin.document.write(\"<title>appgenerator.net</title><body bgcolor='white' topmargin=0 leftmargin=0 marginheight=0    marginwidth=0><a href='javascript:window.close()'><img src='\"+imagesrc+\"' border=0></a></body>\")   \r\n");
	fwrite($fsi,"		popwin.document.close()   \r\n");
	fwrite($fsi,"	}   \r\n");
	fwrite($fsi,"	function data_delete($"."pg_code, seqno){   \r\n");
	fwrite($fsi,"		if( confirm(\"Are you sure you want to delete? \") ) {   \r\n");
	fwrite($fsi,"			document.form_view.mode.value='data_delete';   \r\n");
	fwrite($fsi,"			document.form_view.seqno.value=seqno;   \r\n");
	fwrite($fsi,"			document.form_view.action='".$pg_code."_view.php?pg_code=' + $"."pg_code;   \r\n");
	fwrite($fsi,"			document.form_view.submit();   \r\n");
	fwrite($fsi,"		}   \r\n");
	fwrite($fsi,"	}   \r\n");
	fwrite($fsi,"	function record_update($"."pg_code, seqno){   \r\n");
	fwrite($fsi,"		document.form_view.mode.value		= 'record_view';   \r\n");
	fwrite($fsi,"		document.form_view.seqno.value	= seqno;   \r\n");
	fwrite($fsi,"		document.form_view.action			= '".$pg_code."_update.php?pg_code=' + $"."pg_code;   \r\n");
	fwrite($fsi,"		document.form_view.submit();   \r\n");
	fwrite($fsi,"	}   \r\n");

	fwrite($fsi,"	function home_func($"."pg_code){   \r\n");
	fwrite($fsi,"		form_view.mode='home_func';   \r\n");
	fwrite($fsi,"		form_view.action='".$pg_code."_run.php?pg_code=' + $"."pg_code ;   \r\n");
	fwrite($fsi,"		form_view.submit();   \r\n");
	fwrite($fsi,"	}   \r\n");
	fwrite($fsi," </script>                                \r\n");

	fwrite($fsi,"  <body width=100%>                            \r\n");
	fwrite($fsi,"  <center>                                           \r\n");

	fwrite($fsi,"<?php                                           \r\n");
	fwrite($fsi," $"."seqno = $"."_REQUEST[\"seqno\"];                                           \r\n");
	fwrite($fsi," $"."SQLX = \" select * from ".$tab_enm." where seqno=$"."seqno \";      \r\n");
	fwrite($fsi," if ( ($"."result = sql_query( $"."SQLX ) )==false )      \r\n");
	fwrite($fsi," {      \r\n");
	fwrite($fsi," 		echo \"<script>alert( 'Error seqno:$"."seqno' );</script> \";     \r\n");
	fwrite($fsi," 		printf(\"SQLX Invalid query: %s\n\", $"."SQLX);      \r\n");
	fwrite($fsi," 		exit();      \r\n");
	fwrite($fsi," }       \r\n");
	fwrite($fsi," 		$"."row	= sql_fetch_array($"."result);      \r\n");
	fwrite($fsi,"?>                                           \r\n");

	fwrite($fsi,"                                 \r\n");
	fwrite($fsi,"<div class='HeadTitle01AX'>   \r\n");
	fwrite($fsi,"	<P href='#' class='on' title='table code:".$tab_enm." , program name:".$pg_name."'>".$pg_name."</P>   \r\n");
	fwrite($fsi,"</div>   \r\n");

	fwrite($fsi,"			<form name='form_view' action='' method='post' enctype='multipart/form-data' >						\r\n");
	fwrite($fsi,"				<input type=hidden name='mode'			value='' />															\r\n");
	fwrite($fsi,"				<input type=hidden name='tab_enm'	value='<?=$"."tab_enm?>' />									\r\n");
	fwrite($fsi,"				<input type=hidden name='tab_hnm'	value='<?=$"."tab_hnm?>' />									\r\n");
	fwrite($fsi,"				<input type=hidden name='seqno'		value='<?=$"."seqno?>' />										\r\n");
	fwrite($fsi,"				<input type=hidden name='page'			value='<?=$"."page?>' />										\r\n");
	fwrite($fsi,"				<input type=hidden name='grant_write' value='<?=$"."grant_write?>' />								\r\n");
	fwrite($fsi,"				<input type=hidden name='pg_name'	value='".$pg_name."' />									\r\n");
	fwrite($fsi,"				<input type=hidden name='pg_code'	value='".$pg_code."' />									\r\n");
	fwrite($fsi,"				<input type=hidden name='line_cnt'		value='<?=$"."line_cnt?>' />									\r\n");
	fwrite($fsi,"				<input type=hidden name='search_fld'		value='<?=$"."_REQUEST[\"search_fld\"]?>' />			\r\n");
	fwrite($fsi,"				<input type=hidden name='search_choice'	value='<?=$"."_REQUEST[\"search_choice\"]?>' />		\r\n");
	fwrite($fsi,"				<input type=hidden name='search_text'	value='<?=$"."_REQUEST[\"search_text\"]?>' />			\r\n");
	fwrite($fsi,"			</form>    \r\n");

	fwrite($fsi,"	<div class='boardViewX'>   \r\n");
	fwrite($fsi,"		<div class='viewHeader'>   \r\n");
	fwrite($fsi,"			<span title='tkher_program_data_viewDN'>appgenerator.net:".$pg_code."(".$pg_name.") &nbsp;&nbsp;&nbsp; Date:<?=date(\"Y-m-d H:i:s\" ); ?></span>   \r\n");
//	fwrite($fsi,"			<input type='button' value='List' onclick=\"javascript:table_data_list('".$pg_code."');\" class='Btn_List01A'>   \r\n");
	fwrite($fsi,"		</div>   \r\n");
	fwrite($fsi,"		<div class='viewSubjX'><span title='(appgenerator.net:".$pg_code.":".$tab_hnm.")'>".$pg_name."</span> </div>   \r\n");
	fwrite($fsi,"		<div class='blankA'> </div>   \r\n");
	fwrite($fsi,"<?php   \r\n");

	fwrite($fsi,"			if( isset($"."_POST['mode']) ) $"."mode=$"."_POST['mode']; \r\n");
	fwrite($fsi,"			else $"."mode='';  \r\n");
	fwrite($fsi,"		if( $"."mode=='data_delete' ) {   \r\n");

//				$SQL = " delete from ksd39673976_1687747338 where seqno=". $_REQUEST['seqno'];   
	fwrite($fsi,"			$"."SQL = \" delete from $tab_enm where seqno=\".$" . "_REQUEST['seqno'];   \r\n");
	fwrite($fsi,"			if ( ($"."result = sql_query( $"."SQL ) )==false )   \r\n");
	fwrite($fsi,"			{   \r\n");
	fwrite($fsi,"				printf(\"delete  Invalid query: %s\n\", $"."SQL);   \r\n");
	fwrite($fsi,"				exit();   \r\n");
	fwrite($fsi,"			} else {   \r\n");
	fwrite($fsi,"				echo \"<script>alert('Delete OK!'); </script>\";  \r\n");

	fwrite($fsi,"				$"."rungo = '".$pg_code."_run.php';   \r\n");
	fwrite($fsi,"				echo \"<script>table_data_list('$"."rungo'); </script>\";   \r\n");
	fwrite($fsi,"			}   \r\n");
	fwrite($fsi,"		}   \r\n");
	fwrite($fsi,"?>   \r\n");

				$sqlPG = "select * from {$tkher['table10_pg_table']} where pg_code='".$pg_code."' ";
				$resultPG = sql_query($sqlPG);
				if ( $resultPG == false ) { my_msg(" tkher_php_programDNV pg_name:$pg_name select ERROR "); exit; }
				$table10_pg= sql_num_rows($resultPG);
				$rsPG			= sql_fetch_array($resultPG);
				$list			= array();
				$ddd			= "";
				$qqq			= "";
				$mid			= $rsPG['userid'];
				$item_array= $rsPG['item_array'];
				$list			= explode("@", $item_array);
				$iftypeX		= $rsPG['if_type'];
				$iftype		= explode("|", $iftypeX);
				$ifdataX		= $rsPG['if_data'];
				$ifdata		= explode("|", $ifdataX);
			for ( $i=0,$j=1; isset($list[$i]) && $list[$i] != ""; $i++, $j++ ){
					$ddd		= $list[$i];
					$typeX	= $iftype[$j];
					$if_fld	= explode(":", $ifdata[$j]); 
					$fld		= explode("|", $ddd); 
					$fldenm	= $fld[1];
					$fldhnm	= $fld[2];
				if ( $fld[3] == "TEXT" ) {
					fwrite($fsi,"    \r\n");
					fwrite($fsi," <p>".$fldhnm."</p>   \r\n");
					fwrite($fsi," <div class='viewWriteBox' ><textarea name='".$fldenm."' ><?=$"."row['".$fldenm."']?></textarea></div>   \r\n");
				} else if ( $typeX == '9' ) {	// 첨부화일
					
	fwrite($fsi,"<?php       \r\n");
	fwrite($fsi,"	if( !$"."row['". $fldenm."'] ) { ?>       \r\n");
	fwrite($fsi,"		  <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>Attachment-File</span></div>           \r\n");
	fwrite($fsi,"		  <div class='data1A'><a href='#'><img src='./default.gif' border=0>&nbsp;</a></div>           \r\n");
	fwrite($fsi,"		  <div class='blankA'> </div>           \r\n");
	fwrite($fsi,"<?php       \r\n");
	fwrite($fsi,"	} else {       \r\n");
					
					
	fwrite($fsi," $"."ifile = explode( \".\", $"."row['".$fldenm."'] );    \r\n");
	fwrite($fsi," if( strtolower($"."ifile[1]) == 'jpg' or strtolower($"."ifile[1]) == 'png' or strtolower($"."ifile[1]) == 'gif' ) {    \r\n");

	fwrite($fsi," $"."path = './';   \r\n");

//	fwrite($fsi," $"."image_size = GetImageSize(\""."./"."$"."row['".$fldenm."']\");   \r\n");
	fwrite($fsi," $"."image_size = GetImageSize("."$"."row['".$fldenm."']);   \r\n"); //
	fwrite($fsi," $"."im = $"."path . $"."row['".$fldenm."'];   \r\n");
	fwrite($fsi,"?>        \r\n");
	fwrite($fsi,"  <div class='menu1T' align=center><span style='width:$"."Xwidth;height:$"."Xheight;'>".$fldhnm."</span></div>    \r\n");
	fwrite($fsi,"  <div class='data1A'><?=$"."row['".$fldenm."']?></div>    \r\n");
	fwrite($fsi,"  <div class='blankA'> </div>    \r\n");
	fwrite($fsi," <div class='viewWriteBox' ><a href='#' onClick=\"popimage('<?=$"."im?>',<?=$"."image_size[0]?>,<?=$"."image_size[1]?>); return false\" onfocus='this.blur()'><img src='<?=$"."im?>'  width='<?=$"."img_size[0]?>' height='100' border=0></a> </div>   \r\n");
	fwrite($fsi,"<?php        \r\n");
	fwrite($fsi," } else {    \r\n");
	fwrite($fsi,"?>        \r\n");
	fwrite($fsi,"  <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>Attachment-File</span></div>    \r\n");
	fwrite($fsi,"  <div class='data1A'><a href='<?=$"."path?><?=$"."row['".$fldenm."']?>'><img src='./default.gif' border=0>&nbsp;<?=$"."row['".$fldenm."']?> </a></div>    \r\n");
	fwrite($fsi,"  <div class='blankA'> </div>    \r\n");
	fwrite($fsi,"<?php        \r\n");
	fwrite($fsi," }	// 첨부화일    \r\n");
	fwrite($fsi,"	}        \r\n");
	fwrite($fsi,"?>        \r\n");

				} else {	// 9
					fwrite($fsi,"  <div class='menu1T' align=center><span style='width:$"."Xwidth;height:$"."Xheight;'>".$fldhnm."</span></div>    \r\n");
					fwrite($fsi,"  <div class='data1A'><?=$"."row['".$fldenm."']?></div>    \r\n");
					fwrite($fsi,"  <div class='blankA'> </div>    \r\n");
				}	//if
			} // while // for

	fwrite($fsi,"                                 \r\n");
	fwrite($fsi," <div>      \r\n");
	fwrite($fsi," <input type=button value='Modify' onclick=\"javascript:record_update('".$pg_code."','<?=$"."seqno?>');\" class='Btn_List02A'>      \r\n");
	fwrite($fsi," <input type=button value='Delete' onclick=\"javascript:data_delete('".$pg_code."', '<?=$"."seqno?>');\" class='Btn_List02A'>      \r\n");
	fwrite($fsi," <input type=button value='List' onclick=\"javascript:table_data_list('".$pg_code."');\" class='Btn_List02A' title='data list'>       \r\n");
	fwrite($fsi," </div>      \r\n");
	fwrite($fsi,"			</div>      \r\n");
	fwrite($fsi,"		</div>     \r\n");
	fwrite($fsi," </div>     \r\n");
	fwrite($fsi," </div>     \r\n");

	fwrite($fsi," </body>     \r\n");
	fwrite($fsi," </html>     \r\n");
	fclose($fsi);

	//------------------------ view end -------------------------------

	$updfile = $path . $H_ID . "/" . $pg_code . "_update.php";

	$fsw = fopen("$updfile","w+");		//write file

	fwrite($fsw,"<?php \r\n");
/*
	fwrite($fsw,"	$"."searchNameAA = $"."_SERVER['HTTP_HOST'];  \r\n");
	fwrite($fsw,"	$"."searchNameBB = $"."_SERVER['DOCUMENT_ROOT'];  \r\n");
	fwrite($fsw,"	$"."searchNameA = 'appgenerator.net';  \r\n");
	fwrite($fsw,"	$"."searchNameB = 'appgenerator.net';  \r\n");
	fwrite($fsw,"	if( $"."_SERVER['HTTP_HOST'] == $"."searchNameA ) {   \r\n");
	fwrite($fsw,"       include '../../tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
	fwrite($fsw,"		include '../../tkher_dbconX.php';		  \r\n");
	fwrite($fsw,"	} else if( $"."_SERVER['HTTP_HOST'] == $"."searchNameB ) {   \r\n");
	fwrite($fsw,"       include '../../tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
	fwrite($fsw,"		include '../../tkher_dbconX.php';		  \r\n");
	fwrite($fsw,"	} else {  \r\n");
	fwrite($fsw,"       include './tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
	fwrite($fsw,"		include './tkher_dbcon_Table.php';  \r\n");// tkher_dbcon.php
	fwrite($fsw,"		// DB 정보를  사용자 서버에서 설치할떄  \r\n");
	fwrite($fsw,"		// tkher_dbcon_create.php에서 generator.  \r\n");
	fwrite($fsw,"	}  \r\n");
*/
fwrite($fsw,"	$"."searchNameA = '".KAPP_URL_T_."';  \r\n");
fwrite($fsw,"	if( strpos( $"."searchNameA, $"."_SERVER['HTTP_HOST']) == true) {    \r\n");
fwrite($fsw,"			include '" . KAPP_PATH_T_ . "/tkher_start_necessary.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsw,"	} else {    \r\n");
fwrite($fsw,"			include './tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsw,"			include './tkher_dbcon_Table.php';  \r\n");// tkher_dbcon.php
fwrite($fsw,"		// DB 정보를  사용자 서버에서 설치할떄  \r\n");
fwrite($fsw,"		// tkher_dbcon_create.php에서 generator.  \r\n");
fwrite($fsw,"	}  \r\n");

	fwrite($fsw,"                                \r\n");
	fwrite($fsw,"	$"."upfile	 = '';  \r\n");
	fwrite($fsw,"	$"."upfileX	= '';  \r\n");

//	fwrite($fsw,"	$"."mode = $"."_POST[\"mode\"];  \r\n");
fwrite($fsw,"			if( isset($"."_POST['mode']) ) $"."mode=$"."_POST['mode']; \r\n");
fwrite($fsw,"			else $"."mode='';  \r\n");
//	fwrite($fsw,"	$"."seqno = $"."_REQUEST[\"seqno\"];  \r\n");
fwrite($fsw,"			if( isset($"."_POST['seqno']) ) $"."seqno=$"."_POST['seqno']; \r\n");
fwrite($fsw,"			else if( isset($"."_REQUEST['seqno']) ) $"."seqno=$"."_REQUEST['seqno']; \r\n");
fwrite($fsw,"			else $"."seqno='';  \r\n");

	fwrite($fsw,"	if( $"."mode == 'record_update' ) {  \r\n");

	fwrite($fsw," 			$"."query			= \" UPDATE ". $tab_enm." SET  \"; \r\n");
		$list				= array();
		$ddd				= "";
		$list				= explode("@", $item_array);
		
//	fwrite($fsw,"			$"."f_path	= './';                       \r\n");
	fwrite($fsw,"			$"."ff_nm = time() . '_';  \r\n"); // add : 2023-0905
	fwrite($fsw,"			$"."f_path = './' . $"."ff_nm;   // $"."f_path='./file/';  // dir add     \r\n"); // add : 2023-0905

		for ( $i=0, $j=1; isset($list[$i]) && $list[$i] != ""; $i++,$j++ ){
					$ddd		= $list[$i];
					$typeX	= $iftype[$j];
					$fld		= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
					$nm		= $fld[1];					// column name
					//IF( $i==($item_cnt-1) ) {		//마지막 컬럼 확인.
					IF( $i==0 ) {					//첫컬럼 확인.
							if( $typeX=='3' ) {	// 3:체크박스 배열 처리
								fwrite($fsw," 			$"."aa		= @implode(\",\", $"."_POST['". $fld[1]. "']); ");
								fwrite($fsw," 			$"."query	= $"."query . \"".$fld[1]."= '\" . $"."aa . \"' \"; \r\n");

							} else if( $typeX=='9' ) {	// 9:

									//fwrite($fsw,"			$"."upfile = $"."_POST['upfile'];  \r\n");
									fwrite($fsw,"			if( isset($"."_POST['upfile']) ) $"."upfile=$"."_POST['upfile']; \r\n");
									fwrite($fsw,"			else $"."upfile='';  \r\n");

									fwrite($fsw," 			$"."upfileX	  = $"."_FILES[\"".$nm."\"][\"name\"];  \r\n");
									fwrite($fsw," 			$"."fld_enm = $"."_FILES[\"".$nm."\"][\"name\"];   \r\n");
									fwrite($fsw," 			if ( $"."_FILES[\"".$nm."\"][\"error\"] > 0){								// 에러가 있는지 검사하는 구문  \r\n");
									fwrite($fsw,"      			echo \" Return Code: \" . $"."_FILES[\"".$nm."\"][\"error\"] . \"<br>\";   \r\n");
									fwrite($fsw," 			} else {  \r\n");
									fwrite($fsw,"          			if ( file_exists( $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"]))       \r\n");
									fwrite($fsw,"          			{																       \r\n");
									fwrite($fsw," 	               			move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );      \r\n");
									fwrite($fsw,"           			} else {														  \r\n");
									fwrite($fsw," 	                			move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );      \r\n");
									fwrite($fsw," 	                			//echo \" Stored in:\" . $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"];	  \r\n");
									fwrite($fsw,"           			}              \r\n");
									fwrite($fsw," 			}                  \r\n");
					fwrite($fsw," 			if( $"."upfileX ) $"."query = $"."query . \"".$fld[1]."= '\" . $"."_FILES[\"".$nm."\"][\"name\"] . \"' \";   \r\n");

							} ELSE IF( $fld[3] == "CHAR" || $fld[3] == "VARCHAR" || $fld[3] == "TEXT") {
									fwrite($fsw," 			$"."query = $"."query . \"".$fld[1]."= '\" . $"."_POST['".$fld[1]."'] . \"' \";   \r\n");
							} ELSE {
									fwrite($fsw," 			$"."query = $"."query . \"".$fld[1]."= '\" . $"."_POST['".$fld[1]."'] . \"' \";   \r\n");
							}
					} ELSE { // 컷항목이 아니면...
							//fwrite($fsw," 			$"."query	= $"."query . ','; ");
							if( $typeX=='3' ) {
								fwrite($fsw," 			$"."aa = @implode(\",\" , $"."_POST['".$fld[1]."'] );	// 3:체크박스 배열처리.   \r\n");
								//fwrite($fsw," 			$"."query = $"."query . \"".$fld[1]."= '\" . $"."aa . \"', \"; \r\n");
								fwrite($fsw," 			$"."query = $"."query . \",".$fld[1]."= '\" . $"."aa . \"' \"; \r\n");
							} else if( $typeX=='9' ) {	// 9:add file
/**/
								//fwrite($fsw,"			$"."upfile = $"."_POST['upfile'];  \r\n");
									fwrite($fsw,"			if( isset($"."_POST['upfile']) ) $"."upfile=$"."_POST['upfile']; \r\n");
									fwrite($fsw,"			else $"."upfile='';  \r\n");
								fwrite($fsw," 			$"."fld_enm = $"."_FILES[\"".$nm."\"][\"name\"];    \r\n");
								fwrite($fsw," 			$"."upfileX = $"."_FILES[\"".$nm."\"][\"name\"];    \r\n");
								fwrite($fsw," 			if ( $"."_FILES[\"".$nm."\"][\"error\"] > 0){    \r\n");
								fwrite($fsw,"        			echo \" Return Code: \" . $"."_FILES[\"".$nm."\"][\"error\"] . \"<br>\";   \r\n");
								fwrite($fsw," 			} else {				   \r\n");
								fwrite($fsw,"      			if ( file_exists( $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"]))    \r\n");
								fwrite($fsw,"      			{	   \r\n");
								fwrite($fsw,"            			move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );   \r\n");
								fwrite($fsw,"      			} else {	   \r\n");
								fwrite($fsw,"            			move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );   \r\n");
								fwrite($fsw,"           			//echo \"Stored in: \" . $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"];	   \r\n");
								fwrite($fsw,"      			}   \r\n");
								fwrite($fsw," 			}   \r\n");
								//fwrite($fsw," 			if( $"."upfileX ) $"."query = $"."query . \"".$fld[1]."= '\" . $"."_FILES[\"".$nm."\"][\"name\"] . \"', \";   \r\n");
								fwrite($fsw," 			if( $"."upfileX ) $"."query = $"."query . \",".$fld[1]."= '\" . $"."_FILES[\"".$nm."\"][\"name\"] . \"' \";   \r\n");
/**/
							} ELSE IF( $fld[3] == "CHAR" || $fld[3] == "VARCHAR" || $fld[3] == "TEXT") {
								//fwrite($fsw," 			$"."query = $"."query . \"".$fld[1] . "= '\" . $"."_POST[".$fld[1]."] . \"', \";   \r\n");
								fwrite($fsw," 			$"."query = $"."query . \",".$fld[1] . "= '\" . $"."_POST['".$fld[1]."'] . \"' \";   \r\n");
							} ELSE {
								//fwrite($fsw," 			$"."query = $"."query . \"".$fld[1] . "= '\" . $"."_POST[".$fld[1]."] . \"', \";   \r\n");
								fwrite($fsw," 			$"."query = $"."query . \",".$fld[1] . "= '\" . $"."_POST['".$fld[1]."'] . \"' \";   \r\n");
							}
					}	// $i
		}	// for

	fwrite($fsw,"			$"."query = $"."query . \" where seqno=$"."seqno \";   \r\n"); 
//	fwrite($fsw,"			$"."query = $"."query . \" where seqno=$"."_POST[seqno] \";   \r\n");

	fwrite($fsw," 			$"."ret = sql_query( $"."query );   \r\n");
	fwrite($fsw," 			if( $"."ret ) {   \r\n");
	fwrite($fsw," 				m_(\" Change completed!  \");   \r\n");
	fwrite($fsw," 				if ($"."upfileX && $"."upfile) exec (\"rm $"."upfile\");	// upfileX: If there is a file, the existing file is preserved if the existing file is not deleted.\r\n");// 첨부화일이 있으면 기존화일을 삭제 없으면 기존화일을 보존.   
	fwrite($fsw," 			} else {   \r\n");
	fwrite($fsw," 				printf(\"sql:%s\", $"."query);   \r\n");
	fwrite($fsw," 				m_(\" Change Error!  seqno:$"."seqno \");   \r\n");
//	fwrite($fsw," 				exit;   \r\n");
	fwrite($fsw," 			}   \r\n");

	fwrite($fsw,"			echo \"<script>window.open( './".$pg_code."_run.php' , '_self', ''); </script>\";      \r\n");
	fwrite($fsw,"	}           \r\n");// write end

	fwrite($fsw,"	$"."menu1TWPer=15;  \r\n");
	fwrite($fsw,"	$"."menu1AWPer=100 - $"."menu1TWPer;  \r\n");
	fwrite($fsw,"	$"."menu2TWPer=10;  \r\n");
	fwrite($fsw,"	$"."menu2AWPer=50 - $"."menu2TWPer;  \r\n");
	fwrite($fsw,"	$"."menu3TWPer=10;  \r\n");
	fwrite($fsw,"	$"."menu3AWPer=33.3 - $"."menu3TWPer;  \r\n");
	fwrite($fsw,"	$"."menu4TWPer=10;  \r\n");
	fwrite($fsw,"	$"."menu4AWPer=25 - $"."menu4TWPer;  \r\n");
	fwrite($fsw,"	$"."Xwidth='100%';  \r\n");
	fwrite($fsw,"	$"."Xheight='100%';  \r\n");
	fwrite($fsw,"	$"."Text_height='60px';  \r\n");

	fwrite($fsw,"?> \r\n");
//---------- style ---------------------------------------------------------------------------------
fwrite($fsw,"<style>  \r\n");
fwrite($fsw,"* {  box-sizing: border-box;}  \r\n");
fwrite($fsw,".header2A {width:100%;  height:50px;  float: left;  border: 0px solid red;  padding: 0px;}  \r\n");
//fwrite($fsw,".menu1Area{width:100%;  height:60px;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
fwrite($fsw,".menu1Area{width:100%;  height:auto;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
fwrite($fsw,".menu2T{padding-top:3px; width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FAFAFA;}  \r\n");
fwrite($fsw,".menu2A {width:25%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE; background-color:#FAFAFA;} \r\n");
fwrite($fsw,".data2A {width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");
fwrite($fsw,".input1A { padding:0px;}  \r\n");
fwrite($fsw,".mainA {width:100%;  float: left; padding:15px; border:1px solid red;}  \r\n");
fwrite($fsw,".menu1T {padding-top:0px; width:<?=$"."menu1TWPer?>%; height:30px; float:left; padding:6px; border:1px solid #DEDEDE;background-color:#FAFAFA;}  \r\n");
fwrite($fsw,".menu1A {width:<?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 0px;}  \r\n");
fwrite($fsw,".data1A {width:<?=$"."menu1AWPer?>%; height:30px; float:left;padding:6px;border:1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");
fwrite($fsw,"radio1A {width:<?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 6px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}  \r\n");
fwrite($fsw,".ListBox1A {width: <?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");

fwrite($fsw,".File1A {  width: <?=$"."menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}  \r\n");
fwrite($fsw,".menu4T {padding-top:3px; width:10%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE;background-color:#FAFAFA;}  \r\n");
fwrite($fsw,".input4A {width:15%;  height:30px;  float:left;  padding:0px; border:1px solid #DEDEDE;  background-color:#FFFFFF;}  \r\n");
fwrite($fsw,".menu4B {width: 15%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
fwrite($fsw,".data4A {width:15%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}  \r\n");
fwrite($fsw,".main4A {width:100%;  float: left;  padding: 15px;  border: 1px solid #DEDEDE;}  \r\n");
fwrite($fsw,".blankA {border-top:0px;	width: 100%;    float: left;	height: 1px;	padding: 0px;	border: 1px solid #FFFFFF;background-color:#FFFFFF;}  \r\n");
fwrite($fsw,".blankB {width:100%;  height: 1px;  padding: 1px;  float: left;  border: 1px solid #FFFFFF;  background-color:#FFFFFF;}  \r\n");
fwrite($fsw,".viewSubjX{margin-top:1px;	width:100%;height:35px;	line-height:32px;border-top:3px solid #d01c27;	text-align:center;background:#fafafa;border-bottom:1px solid #dedede;overflow:hidden;font-size:18px;color:#69604f;}  \r\n");
fwrite($fsw,".viewSubjX span{font-size:22px;color:#171512; vertical-align:baseline; }  \r\n");
fwrite($fsw,".HeadTitle02AX{display:inline-block;	margin:0 1px;	height:35px;	line-height:35px;	padding:0 20px;	font-size:25px;	background:#d01c27;	color:#ffffff;	border-radius:5px;}  \r\n");
fwrite($fsw,".HeadTitle01AX{display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;font-size:22px;background:#d01c27;color:#fff;border-radius:5px;}  \r\n");
fwrite($fsw,".HeadTitle01AX a.on{background:#d01c27;color:#fff;}  \r\n");
fwrite($fsw,".HeadTitle01A{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  \r\n");
fwrite($fsw,".HeadTitle02A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  \r\n");
fwrite($fsw,".HeadTitle01A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;	font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  \r\n");
fwrite($fsw,".HeadTitle01A a.on{background:#d01c27;color:#fff;}  \r\n");
fwrite($fsw,".Btn_List01A{width:64px;height:33px;display:inline-block;line-height:33px;	text-align:center;color:#fff;font-size:14px;background:#d01d27;	margin-right: 10px;	}  \r\n");
fwrite($fsw,".Btn_List02A{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  \r\n");
fwrite($fsw,".viewHeader{width:100%;height:auto;overflow:hidden;position:relative;text-align:left;}  \r\n"); // 2024-0105
fwrite($fsw,".viewHeader span{left:0;top:12px;font-size:14px;color:#686868;}  \r\n"); // position:absolute; 
fwrite($fsw,".boardView{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
fwrite($fsw,".boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
fwrite($fsw,"</style>  \r\n");
//---------- end style
fwrite($fsw,"   <script type=\"text/javascript\">  \r\n");
	
/*
fwrite($fsw,"	function popup_callDN(if_dataPG, pop_dataPG, if_typePG ) {   \r\n");
fwrite($fsw,"	    Trun='./popup_callDN.php'; \r\n");
fwrite($fsw,"		window.open( Trun,'', 'alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes');   \r\n");
fwrite($fsw,"		return true;     \r\n");
fwrite($fsw,"	}   \r\n");
*/

fwrite($fsw,"	function popup_callDN(if_dataPG, pop_dataPG, if_typePG , host_url, i) {   \r\n");
//fwrite($fsw,"	substring = 'appgenerator.net'; \r\n"); // $_SERVER['HTTP_HOST']
fwrite($fsw,"	substring = '".$_SERVER['HTTP_HOST']."'; \r\n"); // $_SERVER['HTTP_HOST']
fwrite($fsw,"	if( host_url.includes(substring) ) Trun='../../popup_call.php?fld_session='+i; \r\n"); 
fwrite($fsw,"	else Trun='./popup_callDN.php?fld_session='+i; \r\n");
fwrite($fsw,"		window.open( Trun,'', 'alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes');   \r\n");
fwrite($fsw,"		return true;     \r\n");
fwrite($fsw,"	}   \r\n");

fwrite($fsw,"  	function table_data_list($"."pg_code) {  \r\n");
fwrite($fsw,"  		document.tkher_form.action=\"".$pg_code."_run.php?pg_code=\" + $"."pg_code;  \r\n");
fwrite($fsw,"  		document.tkher_form.target='_self';  \r\n");
fwrite($fsw,"  		document.tkher_form.submit();  \r\n");
fwrite($fsw,"  	}  \r\n");

fwrite($fsw,"  	function popimage(imagesrc,winwidth,winheight){  \r\n");
fwrite($fsw,"  		var look='width='+winwidth+',height='+winheight+','  \r\n");
fwrite($fsw,"  		popwin=window.open(\"\",\"\",look)  \r\n");
fwrite($fsw,"  		popwin.document.open()  \r\n");
fwrite($fsw,"  		popwin.document.write('<title>appgenerator.net</title><body bgcolor=\"white\" topmargin=0 leftmargin=0 marginheight=0 marginwidth=0><a href=\"javascript:window.close()\"><img src=\"'+imagesrc+'\" border=0></a></body>')  \r\n");
fwrite($fsw,"  		popwin.document.close()  \r\n");
fwrite($fsw,"  	}  \r\n");

fwrite($fsw,"  	function record_modify( $"."pg_code, seqno ){  \r\n");
fwrite($fsw,"  		if( confirm(\"Do you want to change it?\") ) {  \r\n");
fwrite($fsw,"  			document.makeform.mode.value	=\"record_update\";  \r\n");
fwrite($fsw,"  			document.makeform.seqno.value	= seqno;  \r\n");
fwrite($fsw,"  			document.makeform.action			= '".$pg_code."_update.php?pg_code=' + $"."pg_code;  \r\n");
fwrite($fsw,"  			document.makeform.submit();  \r\n");
fwrite($fsw,"  		}  \r\n");

fwrite($fsw,"  	}  \r\n");

fwrite($fsw,"  	function tab_pg_list($"."pg_code) {  \r\n");
fwrite($fsw,"  		document.tkher_form.action='".$pg_code."_run.php?pg_code=' + $"."pg_code;  \r\n");
fwrite($fsw,"  		document.tkher_form.submit();  \r\n");
fwrite($fsw,"  	}  \r\n");

fwrite($fsw,"   </script>                                          \r\n");
fwrite($fsw,"  </head>                                            \r\n");
fwrite($fsw,"  <body width=100%>                            \r\n");
fwrite($fsw,"  <center>                                           \r\n");
fwrite($fsw,"                                 \r\n");
fwrite($fsw,"<?php   \r\n");
fwrite($fsw,"	$"."SQLX = \" select * from ".$tab_enm." where seqno=$"."seqno \";   \r\n");
fwrite($fsw,"	if ( ($"."result = sql_query( $"."SQLX ) )==false )   \r\n");
fwrite($fsw,"	{   \r\n");
fwrite($fsw,"	  printf(\"SQLX Invalid query: %s\n\", $"."SQLX);   \r\n");
fwrite($fsw,"	  exit();   \r\n");
fwrite($fsw,"	} else {   \r\n");
fwrite($fsw,"				$"."row	= sql_fetch_array($"."result);   \r\n");
fwrite($fsw,"?>   \r\n");
//---------------------------- form ----------------------
fwrite($fsw,"<div class=\"HeadTitle01AX\">   \r\n");
fwrite($fsw,"	<P href='#' class='on' title='table code:".$tab_enm." , program name:".$pg_name."' >".$pg_name."</P>   \r\n");
fwrite($fsw,"</div>   \r\n");
//fwrite($fsw,"			<form name='tkher_form' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>   \r\n");
fwrite($fsw,"			<form name='tkher_form' method='post' enctype='multipart/form-data' >   \r\n");
fwrite($fsw,"				<input type=hidden name='mode'			value='' />   \r\n");
fwrite($fsw,"				<input type=hidden name='seqno'		value='' />   \r\n");
fwrite($fsw,"				<input type=hidden name='pg_name'	value='".$pg_name."' />   \r\n");
fwrite($fsw,"				<input type=hidden name='pg_code'	value='".$pg_code."' />   \r\n");
fwrite($fsw,"				<input type=hidden name='page'			value='<?=$"."page?>' />   \r\n");
fwrite($fsw,"				<input type=hidden name='grant_write'	value='<?=$"."grant_write?>' />   \r\n");
fwrite($fsw,"			</form>   \r\n");
fwrite($fsw,"	<div class='boardViewX'>   \r\n");
fwrite($fsw,"		<div class='viewHeader'>   \r\n");
fwrite($fsw,"			<span title='tab_update_pg70'>Date:<?=date(\"Y-m-d H:i:s\" ); ?></span>   \r\n");
fwrite($fsw,"			<input type=button value='List' onclick=\"javascript:table_data_list('<?=$"."_REQUEST['pg_code']?>');\" class='Btn_List01A'>   \r\n");
fwrite($fsw,"		</div>   \r\n");
				
fwrite($fsw,"		<div class='viewSubjX'><span>".$pg_name."</span> </div>   \r\n");
fwrite($fsw,"		<div class='blankA'> </div>   \r\n");

fwrite($fsw,"				<form name='makeform' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>   \r\n");
fwrite($fsw,"					<input type=hidden name='mode'				value='' />   \r\n");
fwrite($fsw,"					<input type=hidden name='seqno'			value='' />   \r\n");
fwrite($fsw,"					<input type=hidden name='page'				value='<?=$"."page?>' />   \r\n");


				$sqlPG		= "select * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$pg_code' ";
				$resultPG	= sql_query($sqlPG);
				if ( $resultPG == false ) { m_(" tkher_php_programDNV pg_name:$pg_name select ERROR "); exit; }
				$table10_pg= sql_num_rows($resultPG);
				$rsPG			= sql_fetch_array($resultPG);
				$list			= array();
				$ddd			= "";
				$qqq			= "";
				$item_array= $rsPG['item_array'];
				$item_cnt	= $rsPG['item_cnt'];
				$list			= explode("@", $item_array);	// 게시판단위별구분 분류 '구분자=||',    52|GCOM01!:0!:4!,4!,4!,7!,7!,0!,X!,|사항|0||
				$iftypeX		= $rsPG['if_type'];
				$iftype		= explode("|", $iftypeX);
				$ifdataX		= $rsPG['if_data'];
				$ifdata		= explode("|", $ifdataX);

			for ( $i=0,$j=1; isset($list[$i]) && $list[$i] != ""; $i++, $j++ ){
					$ddd		= $list[$i];
					$typeX	= $iftype[$j];

					$if_fldT	= explode(":", $ifdata[$j]); 
					$nT = 'array(';
				for( $n=0;$n < count($if_fldT)-1; $n++ ){
					$nT = $nT . ' "' . $if_fldT[$n] . '", ';
				}
//					$nT = $nT . ' "" )';
					$nT = $nT . ' "' . $if_fldT[$n] . '" ) ';
					$if_fld_data	= $ifdata[$j]; 

					$fld = explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
					$fldenm= $fld[1];
					$fldhnm= $fld[2];
				if ( $fld[3] == "TEXT" ) {
					fwrite($fsw,"<p>".$fldhnm."</p>   \r\n");
					fwrite($fsw," <div class='menu1Area' ><textarea name='".$fld[1]."' placeholder='Please enter your ".$fld[2]."!'    style='width:<?=$"."Xwidth?>;height:<?=$"."Text_height?>;'><?=$"."row['".$fldenm."']?></textarea></div>   \r\n");
					fwrite($fsw," <div class='blankA'> </div>    \r\n");
// add 2021-02-04 --------------------------------------- 
				} else if ( $typeX == '13' ) {	// 팝업창.
					fwrite($fsw,"<?php                                 \r\n");
					fwrite($fsw,"  $"."fld_session = ".$i.";	// 팝압창의 테이블정보가있는 위치.   \r\n");
					fwrite($fsw,"?>                                 \r\n");
					fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
					
					fwrite($fsw," <div class='menu1A'><input type=text name='".$fldenm."' value='<?=$"."row['".$fldenm."']?>' onclick=\"javascript:popup_callDN('".$if_dataPG."', '".$pop_dataPG."', '".$if_typePG."', '<?=$"."tkher_iurl?>', '".$i."')\" style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='PopUp Window. Please enter a ".$fld[2]."'></div>  \r\n");
					
					fwrite($fsw," <div class='blankA'> </div>  \r\n");
//--------------------------------------------------------
				} else if ( $typeX == '9' ) {	// 첨부화일

fwrite($fsw,"<?php        \r\n");
fwrite($fsw,"	if( !$"."row['". $fldenm."'] ) { ?>       \r\n");
fwrite($fsw,"		  <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>Attachment-File</span></div>           \r\n");
fwrite($fsw,"		  <div class='data1A'><a href='#'><img src='./default.gif' border=0>&nbsp;</a></div>           \r\n");
fwrite($fsw,"		  <div class='blankA'> </div>           \r\n");
fwrite($fsw,"<?php       \r\n");
fwrite($fsw,"	} else {       \r\n");

fwrite($fsw," $"."ifile = explode( \".\", $"."row['".$fldenm."'] );    \r\n");
fwrite($fsw," if( strtolower($"."ifile[1]) == 'jpg' or strtolower($"."ifile[1]) == 'png' or strtolower($"."ifile[1]) == 'gif' ) {    \r\n");

fwrite($fsw,"			$"."path = './';   \r\n");

//fwrite($fsw,"			$"."image_size = GetImageSize(\"".$path."$"."row[".$fldenm."]\");   \r\n");
//fwrite($fsw,"			$"."image_size = GetImageSize(\""."./"."$"."row['".$fldenm."']\");   \r\n"); // 2023-08-24 update
fwrite($fsw,"			$"."image_size = GetImageSize("."$"."row['".$fldenm."']);   \r\n");
fwrite($fsw,"			$"."im = $"."path . $"."row['".$fldenm."'];   \r\n");
fwrite($fsw,"?>        \r\n");
fwrite($fsw,"			<p>".$fldhnm.":<?=$"."row['".$fldenm."']?></p>   \r\n");
fwrite($fsw,"			<div class='viewWriteBox' ><a href='#' onClick=\"popimage('<?=$"."im?>',<?=$"."image_size[0]?>,<?=$"."image_size[1]?>); return false\" onfocus='this.blur()'><img src='<?=$"."im?>'  width='<?=$"."img_size[0]?>' height='100' border=0></a> </div>   \r\n");

fwrite($fsw,"<?php        \r\n");
fwrite($fsw," } else {    \r\n");
fwrite($fsw,"?>        \r\n");
fwrite($fsw,"  <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>Attachment-File</span></div>    \r\n");
fwrite($fsw,"  <div class='data1A'><a href='<?=$"."path?><?=$"."row['".$fldenm."']?>'><img src='./default.gif' border=0>&nbsp;<?=$"."row['".$fldenm."']?> </a></div>    \r\n");
fwrite($fsw,"  <div class='blankA'> </div>    \r\n");
fwrite($fsw,"<?php        \r\n");
fwrite($fsw," }	// 첨부화일    \r\n");
fwrite($fsw,"	}                \r\n");
fwrite($fsw,"?>        \r\n");

fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fldhnm."</span></div>    \r\n");
fwrite($fsw," <div class='File1A'>   \r\n");
fwrite($fsw," <input type='FILE' name='".$fldenm."' value='<?=$"."row['".$fldenm."']?>' placeholder='Please enter a ".$fld[2].".' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>    \r\n");
fwrite($fsw," </div>    \r\n");
fwrite($fsw," <div class='blankA'> </div>    \r\n");

				} else if ( $typeX == '7' ) {	// password

					fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>$fld[2]</span></div>    \r\n");
					fwrite($fsw," <div class='menu1A'><input type=PASSWORD name='".$fld[1]."' value='<?=$"."row['".$fldenm."']?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2].".'></div>    \r\n");
					fwrite($fsw," <div class='blankA'> </div>    \r\n");
				
				} else if ( $typeX == '5' ) {	// list box

					fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>    \r\n");
					fwrite($fsw," <div class='ListBox1A'>   \r\n");
					fwrite($fsw,"<SELECT NAME='".$fld[1]."' SIZE='1' style='border-style:;height:25;'>   \r\n");
					fwrite($fsw,"<?php 	   \r\n");
					fwrite($fsw,"		$"."if_fld = " . $nT . "; 	   \r\n");
					fwrite($fsw,"		for ( $"."k=0; isset($"."if_fld[$"."k]) && $"."if_fld[$"."k] != \"\"; $"."k++ ){   \r\n");
					fwrite($fsw,"			if( $"."if_fld[$"."k] == $"."row['".$fldenm."'] ) $"."sel = 'selected';  \r\n");
					fwrite($fsw,"			else	  $"."sel ='';    \r\n");
					fwrite($fsw,"			echo \"<OPTION $"."sel >$"."if_fld[$"."k]</OPTION> \";  \r\n");
					fwrite($fsw,"		}		\r\n");
					fwrite($fsw,"?> 			\r\n");

					fwrite($fsw,"</SELECT>   \r\n");
					fwrite($fsw," </div>    \r\n");
					fwrite($fsw," <div class='blankA'> </div>    \r\n");

				} else if ( $typeX == '3' ) {	// check box

					fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>    \r\n");
					fwrite($fsw," <div class='ListBox1A'><span>   \r\n");

					fwrite($fsw,"<?php 	   \r\n");
					fwrite($fsw," $"."ck = explode(\",\", $"."row['".$fldenm."'] ); 	   \r\n");
					fwrite($fsw," $"."kk = count($"."ck); 	   \r\n");

					fwrite($fsw,"		$"."if_fld = " . $nT . "; 	   \r\n");
					fwrite($fsw," for ( $"."k=0; isset($"."if_fld[$"."k]) && $"."if_fld[$"."k] != \"\"; $"."k++ ){   \r\n");
					fwrite($fsw," 	$"."mm = \" \"; 	   \r\n");
					fwrite($fsw," 	for($"."ii=0;$"."ii<$"."kk;$"."ii++) { 	   \r\n");
					fwrite($fsw," 		if( $"."if_fld[$"."k] == $"."ck[$"."ii] ) $"."mm=\" checked \"; 	   \r\n");
					fwrite($fsw," 	} 	   \r\n");
					fwrite($fsw,"  echo \"<input type='Checkbox' name='" . $fld[1] . "[]' value='\".$"."if_fld[$"."k].\"' \".$"."mm.\" >\".$"."if_fld[$"."k] . \" &nbsp;  \";          \r\n");
					fwrite($fsw," } 	   \r\n");
					fwrite($fsw,"?> 	   \r\n");
					fwrite($fsw," </span></div>    \r\n");
					fwrite($fsw," <div class='blankA'> </div>    \r\n");

				} else if ( $typeX == '1' ) {	// radio 버턴.

					fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>    \r\n");
					fwrite($fsw," <div class='ListBox1A'><span>   \r\n");

					fwrite($fsw,"<?php 	   \r\n");
					fwrite($fsw,"		$"."if_fld = " . $nT . "; 	   \r\n");
					fwrite($fsw," for ( $"."k=0; isset($"."if_fld[$"."k]) && $"."if_fld[$"."k] != \"\"; $"."k++ ){   \r\n");
					fwrite($fsw," 	if( $"."if_fld[$"."k] == $"."row['".$fldenm."'] )  \r\n");
					fwrite($fsw,"           echo \"<input type = 'radio' name='" . $fld[1] . "' value='$"."if_fld[$"."k]' checked >$"."if_fld[$"."k] &nbsp; \";  \r\n");
					fwrite($fsw," 	else	echo \"<input type = 'radio' name='" . $fld[1] . "' value='$"."if_fld[$"."k]' >$"."if_fld[$"."k] &nbsp; \";  \r\n");
					fwrite($fsw," } 	   \r\n");
					fwrite($fsw,"?> 	   \r\n");
					fwrite($fsw," </span></div>    \r\n");
					fwrite($fsw," <div class='blankA'> </div>    \r\n");
				} else if ( $typeX == '0' ) {	//
					fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fldhnm."</span></div>    \r\n");
					fwrite($fsw," <div class='menu1A'><input type='".$fld[3]."' name='".$fldenm."' value='<?=$"."row['".$fldenm."']?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fldenm.".'></div>    \r\n");
					fwrite($fsw," <div class='blankA'> </div>    \r\n");
				} else {	// typeX
					fwrite($fsw," <div class='menu1T' align=center><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fldhnm."</span></div>    \r\n");
					fwrite($fsw," <div class='menu1A'><input type='".$fld[3]."' name='".$fldenm."' value='<?=$"."row['".$fldenm."']?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fldenm.".'></div>    \r\n");
					fwrite($fsw," <div class='blankA'> </div>    \r\n");
				}	//if
			} // while  // for




fwrite($fsw,"					<input type='hidden' name='upfile'		value='<?=$"."upfile?>' />   \r\n");
fwrite($fsw,"				<div class='viewHeader'>   \r\n");
fwrite($fsw,"					<input type=button value='Save' onclick=\"javascript:record_modify('".$pg_code."','<?=$"."seqno?>');\" class='Btn_List02A'>   \r\n");
fwrite($fsw,"					<input type=button value='List' onclick=\"javascript:tab_pg_list('".$pg_code."');\" class='Btn_List02A'>   \r\n");
fwrite($fsw,"				</div>   \r\n");
fwrite($fsw,"				</form>   \r\n");
fwrite($fsw,"			</div>   \r\n");

fwrite($fsw,"<?php   \r\n");
fwrite($fsw,"	}  //query false   \r\n");
fwrite($fsw,"?>   \r\n");
fwrite($fsw,"</body>   \r\n");
fwrite($fsw,"</html>   \r\n");

	fclose($fsw);

	include('./include/lib/pclzip.lib.php');
	 $zf = $pg_code . '_view_update.zip';
	 $zff = "./file/".$H_ID."/" . $zf;
	 
	$zipfile = new PclZip($zff);				//압축파일.zip

	//-- 파일명,디렉토리 또는 배열로 지정가능
	$view_run		= $pg_code . "_view.php";
	$update_run	= $pg_code . "_update.php";

	$data				= array();
	$file_php 		= "./file/" . $H_ID. "/" . $view_run; 
	$updatefile 		= "./file/" . $H_ID. "/" . $update_run; 

//	$Zdir				= "../t/file/" . $H_ID;	// directory all zip
//	$default_file	= "/t/include/default.gif";		//첨부화일 default file.
	
	$data				= array( $file_php, $updatefile );	//"압축할파일","압축할 디렉토리"
	$create			= $zipfile -> create($data, PCLZIP_OPT_REMOVE_ALL_PATH);
	echo "<pre>";
	//var_dump($create);
?> 

<h3>  Created OK! pg_code:<?php echo $view_run; ?> , <?php echo $update_run; ?>
		<br><br>Zip File:<?=$zf?></h3>

<h3><a href='<?=$zff?>' target='_blank'>[ Down RUN:<?=$zf?> ]</a></h3> 

<?php
if( $H_LEV > 7 ){
?>
		<h3><a href='./file/<?=$H_ID?>/<?=$view_run?>?seqno=<?=$seqno?>' target='_blank'>[ Data_View RUN:<?=$view_run?> ]</a>
		<br><a href='./file/<?=$H_ID?>/<?=$update_run?>?seqno=<?=$seqno?>' target='_blank'>[ Data_Update RUN:<?=$updfile?> ]</a></h3>  
<?php } ?>
<p>To run the downloaded program, </p>
<p>Download the database table and upload it to the server you want to use.</p>
<p>To download a table, click Search Table and click the table name on the right screen, and there is a source download button at the bottom.</p>
 
</body>
</html>
