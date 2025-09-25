<?php
	include_once('./tkher_start_necessary.php');

	/* ---------------------------------------------------------------------- 
	    데이터 등록 소스코드 다운로드.
		tkher_php_programDNW.php : write and write_r source create and download.
		  tkher_program_run.php에서 콜.
		- call : tkher_program_data_writeDN.php : data insert program.
	---------------------------------------------------------------------- */
	$H_ID		= get_session("ss_mb_id"); 
	$H_LEV =$member['mb_level']; 
	$email_id =$member['mb_email']; 

	if( !$H_ID or $H_LEV < 2 ) {
		my_msg("You need to login. ");exit;
		//echo "<script>window.open('/', '_top', '');</script>";exit;
	}

	$pg_code 	= $_POST['pg_code']; //m_("pg_code:" . $pg_code); 
	// ksd39673976_1687746209, pg_code:ksd39673976_1687746209, Abnormal approach. program no found! : ksd39673976_1687746209
	$mode 	= $_POST['mode'];
	if( $mode == 'write_r' and $pg_code ) {
		if( $H_ID != 'dao' ) coin_minus_func($H_ID, 1000);
	} else exit();

	/////////////////////////< tree file create >////////////////////////////
	$mid = $H_ID;
	//$path = KAPP_PATH_ . "/cratree/";	 //KAPP_PATH_CRATREE_;		// . "../../cratree/";
	$path = KAPP_PATH_T_ . "/file/"; 

	$runF1	= $pg_code . "_run.php";
	$runF2	= $pg_code . "_write.php";
	$runF2r	= $pg_code . "_write_r.php";
	
	$insfile	= $path . $H_ID . "/" . $pg_code . "_write.php"; //m_("path:" . $path . ", " . $insfile);//path:/home1/solpakanurl/public_html/t/file/, /home1/solpakanurl/public_html/t/file/dao/ksd39673976_1687747338_write.php
	//$insfile	= $path . "/" . $pg_code . "_write.php"; //m_("path:" . $path); //path:/home1/solpakanurl/public_html/t/file/dao path:/home1/solpakanurl/public_html/t/file/solpakan59@gmail.com

	$fsi		= fopen("$insfile","w+");		//write file

	$fld_enm	= array();
	$fld_hnm	= array();
	$fld_type	= array();
	$fld_len	= array();
	$list		= array();
	$item		= array(); 
	$ddd		= "";

	
	//$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$pg_code' ";
	$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$resultPG = sql_query($sqlPG);

	$table10_pg = sql_num_rows($resultPG);
	if( !$table10_pg  ) {
			my_msg(" Abnormal approach. program no found! : $pg_code"); exit();
	}
	
	$rsPG		= sql_fetch_array($resultPG);
	$pg_name	= $rsPG['pg_name'];
	$tab_enm	= $rsPG['tab_enm'];
	$tab_hnm	= $rsPG['tab_hnm'];
	$group_code	= $rsPG['group_code'];
	$group_name	= $rsPG['group_name'];
	$item_cnt	= $rsPG['item_cnt'];

	$item_array = $rsPG['item_array'];
	$if_typePG	= $rsPG['if_type'];
	$if_dataPG	= $rsPG['if_data']; 
	$pop_dataPG	= $rsPG['pop_data'];

	$relation_dataPG =$rsPG['relation_data'];
	$relation_typePG =$rsPG['relation_type']; // add : 2022-02-10
	
	if($mode=='write_r') {
		/*
		$item_array = $_POST['item_array'];
		$tab_enm	= $_POST['tab_enm'];
		$tab_hnm	= $_POST['tab_hnm'];
		$item_cnt	= $_POST['item_cnt'];
		$pg_name	= $_POST['pg_name']; 
		//$pg_code 	= $_POST['pg_code'];

		//$if_type 	= $_SESSION['if_typePG'];
		$if_typePG 	= $_SESSION['if_typePG'];
		//$if_data 	= $_SESSION['if_dataPG'];
		$if_dataPG 	= $_SESSION['if_dataPG'];
		$pop_dataPG 	= $_SESSION['pop_dataPG'];
		$relation_dataPG= $_SESSION['relation_dataPG'];
		//$relation_data 	= $_SESSION['relation_dataPG'];
		*/

		//m_("relation_data:$relation_data");//relation_data:dao_1555290800:release$fld_1:product|=|fld_1:product$fld_2:quantity|=|fld_2:quantity$fld_3:unit_price|=|fld_3:unit_price$fld_4:price|=|fld_4:price$fld_7:date|=|fld_6:date
	} else{
		m_("tkher_php_programDNW write_r : Error, "); exit;
	}

	$list		= explode("@", $item_array);
	
	for ( $i=0; $list[$i] != ""; $i++ ){
		$ddd			= $list[$i];
		$item			= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
		$fld_enm[$i]	= $item[1];
		$fld_hnm[$i]	= $item[2];
		$fld_type[$i]	= $item[3];
		$fld_len[$i]	= $item[4];
		if( $i==0 && !$search_fld) $search_fld = $item[1];	 // 검색용 첫필드 디폴트 설정.
	}
//----------------- insert start -----------------------------------------------
fwrite($fsi,"<?php \r\n");
//fwrite($fsi," include_once('./tkher_db_lib.php'); \r\n");
//fwrite($fsi," include './tkher_dbcon_Table.php';		\r\n");// tkher_dbcon.php
//fwrite($fsi," include './table_paging.php';	\r\n");
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
fwrite($fsi,"       include '" . KAPP_PATH_T_ . "/tkher_start_necessary.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsi,"	    // 포함  \r\n");
fwrite($fsi,"	} else {    \r\n");
fwrite($fsi,"       include './tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsi,"		include './tkher_dbcon_Table.php';  \r\n");// tkher_dbcon.php
fwrite($fsi,"		// DB 정보를  사용자 서버에서 설치할떄  \r\n");
fwrite($fsi,"		// tkher_dbcon_create.php에서 generator.  \r\n");
fwrite($fsi,"	}  \r\n");



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
fwrite($fsi,"<?php                                 \r\n");

//fwrite($fsi,"	$"."menu1TWPer=15;  \r\n");
//	fwrite($fsi,"	define('KAPP_MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|android|sony');	  \r\n");
	
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
fwrite($fsi,"	$"."Text_height='60px';  \r\n");
fwrite($fsi,"?>                                 \r\n");
fwrite($fsi,"<style>  \r\n");
fwrite($fsi,"* {  box-sizing: border-box;}  \r\n");
fwrite($fsi,".header2A {width:100%;  height:50px;  float: left;  border: 0px solid red;  padding: 0px;}  \r\n");
//fwrite($fsi,".menu1Area{width:100%;  height:60px;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
fwrite($fsi,".menu1Area{width:100%; height:auto; float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
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
fwrite($fsi,".Btn_List02A{width:99px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  \r\n");
fwrite($fsi,".viewHeader{width:100%;height:auto;overflow:hidden;position:relative;text-align:left;}  \r\n"); // 2024-0105
fwrite($fsi,".viewHeader span{left:0;top:12px;font-size:14px;color:#686868;}  \r\n"); // position:absolute; - 2024-0105
fwrite($fsi,".boardView{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
fwrite($fsi,".boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
fwrite($fsi,"</style>  \r\n");
//----------- ok ------

fwrite($fsi,"  <body width=100%>                            \r\n");
fwrite($fsi,"  <center>                                           \r\n");
fwrite($fsi,"                                 \r\n");
fwrite($fsi,"<div class='HeadTitle01AX'>   \r\n");
fwrite($fsi,"	<P href='#' class='on' title='table code:".$tab_enm." , program name:".$pg_name."'>".$pg_name."</P>   \r\n");
fwrite($fsi,"</div>   \r\n");
fwrite($fsi,"	<div class='boardViewX'>   \r\n");
fwrite($fsi,"		<div class='viewHeader'>   \r\n");
fwrite($fsi,"<?php                                 \r\n");
fwrite($fsi,"	// table: " . $tab_enm . " , table name:" . $tab_hnm . " \r\n");
fwrite($fsi,"	$"."host_url = $"."tkher_iurl; \r\n");

fwrite($fsi,"	$"."relation_dataPG = '" . $relation_dataPG . "'; \r\n");
fwrite($fsi,"	$"."relation_typePG = '" . $relation_typePG . "'; \r\n");
fwrite($fsi,"	$"."if_typePG  = '" . $if_typePG . "'; \r\n"); // popup_callDN.php 에서 use.
fwrite($fsi,"	$"."if_dataPG  = '" . $if_dataPG . "'; \r\n");
fwrite($fsi,"	$"."pop_dataPG = '" . $pop_dataPG . "'; \r\n");
fwrite($fsi,"	$"."item_array		= '" . $item_array . "';    \r\n");

fwrite($fsi,"	$"."_SESSION['if_typePG'] = $"."if_typePG;\r\n");//popup_callDN.php 에서 use.
fwrite($fsi,"	$"."_SESSION['if_dataPG'] = $"."if_dataPG; \r\n");
fwrite($fsi,"	$"."_SESSION['pop_dataPG']= $"."pop_dataPG; \r\n");
fwrite($fsi,"	$"."_SESSION['relation_dataPG']= $"."relation_dataPG; \r\n");
fwrite($fsi,"	$"."_SESSION['relation_typePG']= $"."relation_typePG; \r\n");

fwrite($fsi,"	$"."in_day = date('Y-m-d H:i:s');   \r\n");
fwrite($fsi,"?>                                 \r\n");

fwrite($fsi,"          <span title='pg:".$pg_code."'>K-App:".$pg_code."&nbsp;&nbsp;&nbsp;<?=$"."in_day?></span> \r\n");
//2024-01-05 fwrite($fsi,"          <input type='button' value='List' onclick=\"javascript:table_data_list();\" class='Btn_List01A'> \r\n");
fwrite($fsi,"		</div>   \r\n");
fwrite($fsi,"		<div class='viewSubjX'><span title='(".$pg_code.":".$tab_hnm.")'>".$pg_name."</span> </div>   \r\n");
fwrite($fsi,"		<div class='blankA'> </div>   \r\n");
fwrite($fsi,"		<form name='makeform' method='post' enctype='multipart/form-data'>   \r\n");
fwrite($fsi,"				<input type='hidden' name='page'		value='<?=$"."_REQUEST[\"page\"]?>' />   \r\n");
fwrite($fsi,"				<input type='hidden' name='line_cnt'	value='<?=$"."_REQUEST[\"line_cnt\"]?>' />   \r\n");


		$kkk="off";
		$ddd = "";
		$qqq = "";
		$iftypeX = "";
		$ifdataX = "";
		$kkk0 = "document.makeform.fld_1.value";
		$kkk1 = "document.makeform.fld_1.value";
		$kkk2 = "document.makeform.fld_2.value";
		$kkk3 = "+";	// 계산식 연산자.
		$kkk5 = 1;		//func seq number
		
		//$list		= explode("@", $item_array);
		//$iftype		= explode("|", $if_type);
		//$ifdata		= explode("|", $if_data);
		
		$iftype		= explode("|", $if_typePG);
		$ifdata		= explode("|", $if_dataPG);

		for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
				$ddd		= $list[$i];
				$typeX	= $iftype[$j];
	            //echo "iftype typeX:" . $typeX . ", i:". $i . "<br>";

				$dataX	= $ifdata[$j];
				$if_fld	= explode(":", $dataX);	//$ifdata[$i];
				$fld		= explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
			if( $fld[1] != "seqno") {
				$fld_enmX	= $fld[1];
				if( $fld[3] == "TEXT" ) {
					fwrite($fsi," <p>" . $fld[2] . "</p>  \r\n");
					fwrite($fsi," <div class='menu1Area' ><textarea name='".$fld[1]."' placeholder='Please enter your $fld[2]!' style='width:<?=$"."Xwidth?>;height:<?=$"."Text_height?>;'></textarea></div>  \r\n");
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				} else if( $fld[3] == "DATE" ) { 
					//fwrite($fsi," $"."day=date('Y-m-d'); \r\n");
					fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
					fwrite($fsi," <div class='menu1A'><input type='".$fld[3]."' name='".$fld[1]."' value='<?=$"."day?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></div>  \r\n");
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				//} else if( $fld[3] == "DATETIME" ) { 
				} else if( $fld[3] == "DATETIME" || $fld[3] == "TIMESTAMP" ) { 
					fwrite($fsi,"<?php $"."day=date('Y-m-d H:i:s'); ?> \r\n");
					fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
					fwrite($fsi," <div class='menu1A'><input type='".$fld[3]."' name='".$fld[1]."' value='<?=$"."day?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></div>  \r\n");
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				} else if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "BIGINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ) { 
					fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
					if( $typeX == "11" ) { // calc
							$kkk=$fld[1];
							$func_cnt++;
							$idata=explode(":", $dataX);
							$datax = $idata[1];	// 1:한글필드계산식.
							$datay = $idata[0];	// 0:영문필드계산식.
							//                                                             0    1   2    3   4
							$ff = explode(" ", $datay);	 //datay:fld_4 = fld_2 * fld_3, ff:fld_4 = fld_2 * fld_3 
							$f0 = $ff[0];
							$f1 = $ff[1];
							$f2 = $ff[2];
							$f3 = $ff[3];
							$f4 = $ff[4];
							$kkk0 = "document.makeform." . $f0 . ".value";
							$kkk1 = "document.makeform." . $f2 . ".value";
							$kkk2 = "document.makeform." . $f4 . ".value";
							$kkk3 = $f3;
							$kkk5 = $func_cnt;
							fwrite($fsi," <div class='menu1A'><span><input type='number' name='".$fld[1]."' onClick='".$fld[1]."FUNC".$kkk5."()' title='".$fld[1]."XY()' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></span></div>  \r\n");
					} else {
							fwrite($fsi," <div class='menu1A'><input type='number' name='".$fld[1]."' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."' class=autom_subj></div>  \r\n");
					}
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				} else {
					if( $typeX == "1" ) { // radio button
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='ListBox1A'><span> \r\n");
						for ( $k=0; $if_fld[$k] != ""; $k++ ){
							fwrite($fsi," <input type='radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' class='input1A'>" . $if_fld[$k] . " &nbsp;  \r\n");
						}
							fwrite($fsi," </span></div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else if( $typeX == "3" ) { //check box
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='ListBox1A'><span> \r\n");
							for ( $k=0; $if_fld[$k] != ""; $k++ ){
								fwrite($fsi," <input type='Checkbox' name='" . $fld[1] .  "[]'  value='" . $if_fld[$k] . "' >" . $if_fld[$k] . " &nbsp; \r\n");
							}
							fwrite($fsi," </span></div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else if( $typeX == "5" ) { // list box
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='ListBox1A'> \r\n");
							fwrite($fsi," <SELECT NAME='".$fld[1]."' SIZE='1' style='border-style:;height:25;'>  \r\n");
						for ( $k=0; $if_fld[$k] != ""; $k++ ){
							fwrite($fsi,"<OPTION SELECTED>".$if_fld[$k]."</OPTION> \r\n");
						}
							fwrite($fsi,"</SELECT> \r\n");
							fwrite($fsi," </div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else if( $typeX == "7" ) { //password
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='menu1A'><input type='PASSWORD' name='".$fld[1]."' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else if( $typeX == "9" ) { //첨부화일
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='File1A'> \r\n");
							fwrite($fsi," <input type='FILE' name='".$fld[1]."' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'>  \r\n");
							fwrite($fsi," </div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else if( $typeX == "13" ) { // 팝업창
							//m_("typeX:$typeX, i:$i");
							fwrite($fsi,"<?php                                 \r\n");
							fwrite($fsi,"  $"."fld_session = ".$i.";	// 팝압창의 테이블정보가있는 위치.   \r\n");
							fwrite($fsi,"?>                                 \r\n");
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='menu1A'><input type='text' name='".$fld_enmX."' onclick=\"javascript:popup_callDN('".$if_dataPG."', '".$pop_dataPG."', '".$if_typePG."', '<?=$"."tkher_iurl?>', '$i')\" style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='PopUp Window. Please enter a ".$fld[2]."'></div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else {
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='menu1A'><input type='text' name='".$fld[1]."' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					}
				}
			} else {	//if seqno
					my_msg("seqno ========== ");
			}
		}//for
		
fwrite($fsi,"<?php                                 \r\n");
	//	fwrite($fsi," $"."_SESSION['fld_session'] = $"."fld_session;	// 팝업창 테이블 위치 : if_dataPG     \r\n");
	fwrite($fsi,"			if( isset($"."fld_session) ) $"."_SESSION['fld_session']=$"."fld_session; \r\n");
	fwrite($fsi,"			else $"."_SESSION['fld_session']='';  \r\n");

fwrite($fsi,"?>                                 \r\n");

fwrite($fsi,"		<input type='hidden' name='mode'			value=''>   \r\n");
fwrite($fsi,"		<input type='hidden' name='tab_hnm'			value=''>   \r\n");
fwrite($fsi,"		<input type='hidden' name='tab_enm'			value=''>   \r\n");

fwrite($fsi,"		<input type='hidden' name='return_pg_code'	value=''>   \r\n");
fwrite($fsi,"				<input type='hidden' name='item_array'	value='<?=$"."item_array?>'>   \r\n");

//fwrite($fsi,"		<input type='button' value='submit' onclick=\"program_run_pg('".$i."','".$if_type."')\" class='Btn_List01A'>   \r\n");
fwrite($fsi,"		<input type='button' value='submit' onclick=\"program_run_pg('".$i."','".$if_typePG."')\" class='Btn_List01A'>   \r\n");
fwrite($fsi,"		<input type='reset' value='reset' class='Btn_List01A'>   \r\n");
fwrite($fsi,"		<input type='button' value='Excel_Upload' onclick=\"excel_upload_func('".$tab_enm."','".$tab_hnm."')\" class='Btn_List02A' title='Batch upload of data to excel file'>     \r\n");

fwrite($fsi,"       <input type='button' value='List' onclick=\"javascript:table_data_list();\" class='Btn_List01A'> \r\n"); // 2024-01-05 add

fwrite($fsi,"      </form>                    \r\n");

fwrite($fsi,"                                 \r\n");
//--------------------------------------------------------  script ----------------
fwrite($fsi,"<script language='JavaScript'>   \r\n"); 
fwrite($fsi,"<!--   \r\n");
fwrite($fsi,"	function popup_callDN(if_dataPG, pop_dataPG, if_typePG , host_url, i) {   \r\n");
fwrite($fsi,"	substring = 'appgenerator.net'; \r\n"); // $_SERVER['HTTP_HOST']

//fwrite($fsi,"	if( host_url.includes(substring) ) Trun='../../t/popup_callDN.php?fld_session='+i; \r\n"); 
fwrite($fsi,"	if( host_url.includes(substring) ) Trun='../../popup_callDN.php?fld_session='+i; \r\n"); 
fwrite($fsi,"	else Trun='./popup_callDN.php?fld_session='+i; \r\n");

fwrite($fsi,"		window.open( Trun,'', 'alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes');   \r\n");
fwrite($fsi,"		return true;     \r\n");
fwrite($fsi,"	}   \r\n");

fwrite($fsi,"	function input_check(item_cnt,iftype) {   \r\n");
//fwrite($fsi,"		alert('item_cnt:' + item_cnt);   \r\n");
fwrite($fsi,"		itype=iftype.split('|');   \r\n");
fwrite($fsi,"		for(i=1;i<item_cnt;i++) {   \r\n");
//fwrite($fsi,"			if( !itype[i]  ) {   \r\n");
fwrite($fsi,"			if( !itype[i] || itype[i] =='0'  ) {   \r\n");
//fwrite($fsi,"		        alert('i:' + i + ', itype[i]:' + itype[i] );   \r\n");
fwrite($fsi,"				var column_data = eval('document.makeform.fld_' + i + '.value');   \r\n");
fwrite($fsi,"				if( !column_data ) {   \r\n");
fwrite($fsi,"					var column_fld = 'document.makeform.fld_' + i + '.focus()';   \r\n");
fwrite($fsi,"					alert('column_data:'+column_data);   \r\n");
fwrite($fsi,"					eval( column_fld );   \r\n");
fwrite($fsi,"					return false;   \r\n");
fwrite($fsi,"				}   \r\n");
fwrite($fsi,"			} else {   \r\n");

fwrite($fsi,"			}   \r\n");
fwrite($fsi,"		}   \r\n");
fwrite($fsi,"		return true;   \r\n");
fwrite($fsi,"	}   \r\n");
fwrite($fsi,"	function program_run_pg(item_cnt,iftype) {   \r\n");
fwrite($fsi,"		document.makeform.mode.value='Tkher_write';   \r\n");
//fwrite($fsi,"		document.makeform.action='/cratree/" . $H_ID . "/" . $runF2r . "';   \r\n");	// write_r php
fwrite($fsi,"		document.makeform.action='./" . $runF2r . "';   \r\n");	// write_r php
fwrite($fsi,"		document.makeform.target='_self';   \r\n");
fwrite($fsi,"		document.makeform.submit();   \r\n");
fwrite($fsi,"	}   \r\n");
fwrite($fsi,"	function table_data_list() {   \r\n");
//fwrite($fsi,"		document.makeform.action='/cratree/".$H_ID."/".$runF1."';   \r\n");	// list php
fwrite($fsi,"		document.makeform.action='./".$runF1."';   \r\n");	// list php
fwrite($fsi,"		document.makeform.submit();   \r\n");
fwrite($fsi,"	}   \r\n");

fwrite($fsi,"	function excel_upload_func(tab_enm, tab_hnm) {   \r\n");
fwrite($fsi,"		document.makeform.mode.value='Upload_mode';   \r\n");
fwrite($fsi,"				document.makeform.tab_enm.value	=tab_enm;   \r\n");
fwrite($fsi,"				document.makeform.tab_hnm.value	=tab_hnm;   \r\n");
fwrite($fsi,"				document.makeform.return_pg_code.value	='" . $runF1. "';   \r\n"); // $runF1 =$pg_code + '_run.php' 

fwrite($fsi,"				document.makeform.action		=\"excel_upload_user.php\";   \r\n");
fwrite($fsi,"		document.makeform.target='_self';   \r\n");
fwrite($fsi,"		document.makeform.submit();   \r\n");
fwrite($fsi,"	}   \r\n");


	if($kkk !="off") {

fwrite($fsi,"	function ".$kkk."FUNC".$kkk5."() {  \r\n");
fwrite($fsi,"		v1 = " . $kkk1 . "  " . $kkk3 . "  " . $kkk2 . ";  \r\n");
fwrite($fsi,"		" . $kkk0 . " = v1;  \r\n");
fwrite($fsi,"	}  \r\n");
	
	}

fwrite($fsi," //-->                                \r\n");
fwrite($fsi," </script>                                \r\n");
fclose($fsi);
//-------------------------------------------------------------

$insfile_r = $path . $H_ID . "/" . $pg_code . "_write_r.php";
//$insfile_r = $path . "/" . $pg_code . "_write_r.php";
$fsw = fopen("$insfile_r","w+");		//write file

fwrite($fsw,"<?php \r\n");

fwrite($fsw,"	$"."searchNameA = '".KAPP_URL_T_."';  \r\n");
fwrite($fsw,"	if( strpos( $"."searchNameA, $"."_SERVER['HTTP_HOST']) == true) {    \r\n");
fwrite($fsw,"       include '" . KAPP_PATH_T_ . "/tkher_start_necessary.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsw,"	} else {    \r\n");
fwrite($fsw,"       include './tkher_db_lib.php';		\r\n");	//	call:tkher_config_link.php 
fwrite($fsw,"		include './tkher_dbcon_Table.php';  \r\n");// tkher_dbcon.php
fwrite($fsw,"		// DB 정보를  사용자 서버에서 설치할떄  \r\n");
fwrite($fsw,"		// tkher_dbcon_create.php에서 generator.  \r\n");
fwrite($fsw,"	}  \r\n");

/*
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
//fwrite($fsw," include 'tkher_dbcon.php';		\r\n");

fwrite($fsw,"                                \r\n");

fwrite($fsw,"			if( isset($"."_POST['page']) ) $"."page=$"."_POST['page'];  \r\n");
fwrite($fsw,"			else $"."page=1;   \r\n");
fwrite($fsw,"			if( isset($"."_POST['mode']) ) $"."mode=$"."_POST['mode']; \r\n");
fwrite($fsw,"			else $"."mode='';  \r\n");
//fwrite($fsw,"	$"."mode = $"."_POST['mode'];  \r\n");

fwrite($fsw,"	if( $"."mode != 'Tkher_write' ) {  \r\n");
fwrite($fsw,"		m_(\"Abnormal approach. \");  \r\n");
fwrite($fsw,"		$"."rungo = '".$runF1."';  \r\n");
fwrite($fsw,"		echo \"<script>window.open( '$"."rungo' , '_self', ''); </script>\";  \r\n");
fwrite($fsw,"	} else {  \r\n");

fwrite($fsw,"		$"."ff_nm = time() . '_';  \r\n"); // add : 2023-0905
fwrite($fsw,"		$"."f_path = './' . $"."ff_nm;   // $"."f_path='./file/';  // dir add     \r\n"); // add : 2023-0905

	$ddd = "";

	$SQL = " INSERT " . $tab_enm . " SET ";
/**/
	for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
				$typeX = $iftype[$j]; 
				$ddd = $list[$i];
				$fld = explode("|", $ddd); 
				//m_("-- fld[1]:$fld[1]");
			if( $fld[1] != "seqno") {
					$nm = $fld[1]; 

					if( $typeX=='3' ) {	// 3:체크박스 배열 처리

						fwrite($fsw,"    $"."aa = @implode(\",\",$"."_POST[" .$fld[1]. "]);   \r\n");
						if( $i==0 )	$SQL = $SQL . $nm . " = '$"."aa' ";
						else	$SQL = $SQL . " , " .  $nm . " = '$"."aa' ";

					} else if( $typeX=='9' ) {	// 9:첨부화일 처리

fwrite($fsw,"		                $". $nm . " = '';  \r\n");// add : 2023-0905

fwrite($fsw,"						if ( $"."_FILES[\"".$nm."\"][\"error\"] > 0){   \r\n");
fwrite($fsw,"							echo \"Return Code: \" . $"."_FILES[\"".$nm."\"][\"error\"] . \"<br>\";   \r\n");
fwrite($fsw,"						} else {   \r\n");

fwrite($fsw,"		                    $". $nm . " = $" . "ff_nm . $"."_FILES[\"".$nm."\"][\"name\"];   \r\n"); // upgrade : 2023-0905

fwrite($fsw,"							if ( file_exists( $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"]))   \r\n");
fwrite($fsw,"							{   \r\n");
fwrite($fsw,"								move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );  \r\n");
fwrite($fsw,"							} else {   \r\n");
fwrite($fsw,"								move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );  \r\n");
fwrite($fsw,"								echo \"Stored in: \" . $"."f_path . $"."_FILES[\"" .$nm. "\"][\"name\"];   \r\n");
fwrite($fsw,"							}  \r\n");
fwrite($fsw,"						}  \r\n");
//fwrite($fsw,"						$".$nm ."= $"."_FILES[\"" .$nm. "\"][\"name\"];			   \r\n"); // 2023-0905 막음. kan

//						if( $i==0 )	$SQL = $SQL . $nm ." = '$"."fnm' ";
//						else	$SQL = $SQL . " , " . $nm ." = '$"."fnm' ";
//						if( $i==0 )	$SQL = $SQL . $nm ." = '$nm' ";
//						else	$SQL = $SQL . " , " . $nm ." = '$nm' ";
						if( $i==0 )	$SQL = $SQL . $nm ." = '$".$nm."' ";
						else	$SQL = $SQL . " , " . $nm ." = '$".$nm."' ";
					} else {
						if( $i==0 )	$SQL = $SQL . $nm . " = '$" . "_POST[" . $fld[1]. "]' ";
						else	$SQL = $SQL . " , " . $nm ." = '$"."_POST[" .$fld[1]. "]' ";
					}
			}
	}

fwrite($fsw,"		$"."mq2=sql_query(\"".$SQL."\");   \r\n");
fwrite($fsw,"		if( $"."mq2 ) {    \r\n");

		//$relation_data =get_session("relation_dataPG");
		//$relation_type =get_session("relation_typePG"); // add : 2022-02-11
/*
if( $relation_dataPG ) { 
	fwrite($fsw,"				relation_func('".$relation_dataPG."', '".$pg_code."', '".$relation_typePG."' ); \r\n");
	fwrite($fsw,"		}   \r\n");
} else { 
	fwrite($fsw,"				$"."rungo = '" . $runF1 . "';   \r\n");
	fwrite($fsw,"				echo \"<script>window.open( '$"."rungo' , '_self', ''); </script>\";   \r\n");
	fwrite($fsw,"		}   \r\n");
} */

		/*$rdata = explode("@", $relation_dataPG);
		$rtype = explode("@", $relation_typePG);
		for( $i=0; $i < count( $rdata); $i++ ){
			if( strlen( $rdata[$i] ) > 0 ) {
				fwrite($fsw,"	relation_func('".$rdata[$i]."', '".$pg_code."', '".$rtype[$i]."' ); \r\n");
			}
		}*/

	fwrite($fsw,"			$"."rdata = explode(\"@\", $"."_SESSION['relation_dataPG']);   \r\n");
	fwrite($fsw,"			$"."rtype = explode(\"@\", $"."_SESSION['relation_typePG']);   \r\n");
	fwrite($fsw,"			for( $"."i=0; $"."i < count( $"."rdata); $"."i++ ){   \r\n");
	fwrite($fsw,"				if( strlen( $"."rdata[$"."i] ) > 0 ) relation_func( $"."rdata[$"."i], $"."pg_code, $"."rtype[$"."i] ); \r\n");
	fwrite($fsw,"			}   \r\n");
	fwrite($fsw,"			$"."rungo = '" . $runF1 . "';   \r\n"); 
	fwrite($fsw,"			echo \"<script>window.open( '$"."rungo' , '_self', ''); </script>\";   \r\n");
	fwrite($fsw,"		}//if   \r\n");
	
	fwrite($fsw,"	}   \r\n");// write end

if( $relation_dataPG ) { 

	//fwrite($fsw,"	function relation_func( $"."relation_dataPG, $"."pg_code, $"."r_type ){  \r\n");
	fwrite($fsw,"function relation_func( $"."rdata, $"."pg_code, $"."rtype ){  \r\n");
	fwrite($fsw,"		$"."r_data = explode(\"$\", $"."rdata);  \r\n");
	fwrite($fsw,"		$"."r_tab = $"."r_data[0];  \r\n");
	fwrite($fsw,"		$"."tab_r = explode(\":\", $"."r_tab);  \r\n");
	fwrite($fsw,"		$"."r_table = $"."tab_r[0];  \r\n");

	fwrite($fsw,"		$"."r_t = explode(\":\", $"."rtype);  \r\n");
	fwrite($fsw,"		$"."r_type = $"."r_t[0];  \r\n");
	fwrite($fsw,"		$"."up_key = $"."r_t[1];  \r\n");
	fwrite($fsw,"		$"."dd_key = $"."r_t[2];  \r\n");                    // dd_key : relation table key field
	fwrite($fsw,"		$"."ty_key = $"."r_t[3];  \r\n");
	//fwrite($fsw,"		$"."update_key_data = $"."_POST[$"."dd_key];  \r\n");
	fwrite($fsw,"		$"."update_key_data = $"."_POST[$"."up_key];  \r\n"); // up_key : program screen data

	fwrite($fsw,"		if( $"."r_type == 'Update'){  \r\n");
	fwrite($fsw,"			$"."SQLR = \"UPDATE \" . $"."r_table . \" SET \";  \r\n");
	fwrite($fsw,"			for( $"."i=1;$"."r_data[$"."i] !=\"\"; $"."i++) {  \r\n");
	fwrite($fsw,"				$"."r_fld	= $"."r_data[$"."i];  \r\n");
	fwrite($fsw,"				$"."fld_r	= explode(\"|\", $"."r_fld);  \r\n");
	fwrite($fsw,"				$"."fld_r1	= $"."fld_r[0];  \r\n");
	fwrite($fsw,"				$"."fld_sik = $"."fld_r[1];  \r\n");
	fwrite($fsw,"				$"."fld_r2	= $"."fld_r[2];  \r\n");
	fwrite($fsw,"				$"."fld1	= explode(\":\", $"."fld_r1);  \r\n");
	fwrite($fsw,"				$"."f_enm	= $"."fld1[0];  \r\n");
	fwrite($fsw,"				$"."fld2	= explode(\":\", $"."fld_r2);  \r\n");
	fwrite($fsw,"				$"."r_enm	= $"."fld2[0];  \r\n");

	fwrite($fsw,"				if( $"."fld_sik == '=' ) {  \r\n");
	fwrite($fsw,"					if( $"."i==1 )	$"."SQLR = $"."SQLR . $"."r_enm . \" = '\" . $"."_POST[$"."f_enm] . \"'  \";  \r\n");
	fwrite($fsw,"					else $"."SQLR = $"."SQLR . \" , \"  . $"."r_enm . \" = '\" . $"."_POST[$"."f_enm] . \"' \";  \r\n");
	fwrite($fsw,"				} else if( $"."fld_sik == '+' ) {  \r\n");
	fwrite($fsw,"					if( $"."i==1 )	$"."SQLR = $"."SQLR . $"."r_enm . \"=\" . $"."r_enm . \" + \" . $"."_POST[$"."f_enm];  \r\n");
	fwrite($fsw,"					else $"."SQLR = $"."SQLR . \" , \" . $"."r_enm . \"=\" . $"."r_enm . \" + \" . $"."_POST[$"."f_enm];  \r\n");
	fwrite($fsw,"				} else if( $"."fld_sik == '-' ) {  \r\n");
	fwrite($fsw,"					if( $"."i==1 )	$"."SQLR = $"."SQLR . $"."r_enm . \"=\" . $"."r_enm . \" - \" . $"."_POST[$"."f_enm];  \r\n");
	fwrite($fsw,"					else $"."SQLR = $"."SQLR . \" , \" . $"."r_enm . \"=\" . $"."r_enm . \" - \" . $"."_POST[$"."f_enm]; \r\n");
	fwrite($fsw,"				}  \r\n");
	fwrite($fsw,"			}  \r\n");

	fwrite($fsw,"			if( $"."ty_key == \"CHAR\" ) $"."SQLR = $"."SQLR . \" where \" . $"."dd_key . \" = '\" .$"."update_key_data. \"' \"; \r\n");
	fwrite($fsw,"			else if( $"."ty_key == \"INT\" ) $"."SQLR = $"."SQLR . \" where \" . $"."dd_key . \" = \" .$"."update_key_data; \r\n");
	fwrite($fsw,"			else $"."SQLR = $"."SQLR . \" where \" . $"."dd_key . \" = '\" .$"."update_key_data. \"' \";  \r\n");

	fwrite($fsw,"			$"."mq3 = sql_query($"."SQLR);  \r\n");
	fwrite($fsw,"			if( $"."mq3 ) {   \r\n");
	fwrite($fsw,"				m_(\"relation-Table is , Update OK \" . $"."r_table );   \r\n");

	fwrite($fsw,"				//$"."rungo = '$runF1';  \r\n");
	fwrite($fsw,"				//echo \"<script>window.open( '$"."rungo' , '_self', ''); </script>\";  \r\n");
	fwrite($fsw,"			}else{  \r\n");
	fwrite($fsw,"				echo \"Update ERROR, sql: \" .  $"."SQLR; exit;   \r\n");
	fwrite($fsw,"			}  \r\n");

	fwrite($fsw,"		} else {  \r\n");

	fwrite($fsw,"			$"."SQLR = \"INSERT INTO \" . $"."r_table . \" SET \";  \r\n");
	fwrite($fsw,"			for( $"."i=1;$"."r_data[$"."i] !=\"\"; $"."i++) {  \r\n");
	fwrite($fsw,"				$"."r_fld	= $"."r_data[$"."i];  \r\n");
	fwrite($fsw,"				$"."fld_r	= explode(\"|\", $"."r_fld);  \r\n");
	fwrite($fsw,"				$"."fld_r1	= $"."fld_r[0];  \r\n");
	fwrite($fsw,"				$"."fld_sik	= $"."fld_r[1];  \r\n");
	fwrite($fsw,"				$"."fld_r2	= $"."fld_r[2];  \r\n");
	fwrite($fsw,"				$"."fld1	= explode(\":\", $"."fld_r1);  \r\n");
	fwrite($fsw,"				$"."f_enm	= $"."fld1[0];  \r\n");
	fwrite($fsw,"				$"."fld2	= explode(\":\", $"."fld_r2);  \r\n");
	fwrite($fsw,"				$"."r_enm	= $"."fld2[0];  \r\n");

	fwrite($fsw,"				if( $"."fld_sik == '=' ) {  \r\n");
	fwrite($fsw,"					if( $"."i==1 )	$"."SQLR = $"."SQLR . $"."r_enm . \" = '\" . $"."_POST[$"."f_enm] . \"'  \";  \r\n");
	fwrite($fsw,"					else			$"."SQLR = $"."SQLR . \" , \"  . $"."r_enm . \" = '\" . $"."_POST[$"."f_enm] . \"' \";  \r\n");
	fwrite($fsw,"				} else if( $"."fld_sik == '+' ) {  \r\n");

	fwrite($fsw,"					if( $"."i==1 )	$"."SQLR = $"."SQLR . $"."r_enm . \"=\" . $"."r_enm . \" + \" . $"."_POST[$"."f_enm];  \r\n");
	fwrite($fsw,"					else			$"."SQLR = $"."SQLR . \" , \" . $"."r_enm . \"=\" . $"."r_enm . \" + \" . $"."_POST[$"."f_enm];  \r\n");
	fwrite($fsw,"				} else if( $"."fld_sik == '-' ) {  \r\n");
	fwrite($fsw,"					if( $"."i==1 )	$"."SQLR = $"."SQLR . $"."r_enm . \"=\" . $"."r_enm . \" - \" . $"."_POST[$"."f_enm];  \r\n");
	fwrite($fsw,"					else			$"."SQLR = $"."SQLR . \" , \" . $"."r_enm . \"=\" . $"."r_enm . \" - \" . $"."_POST[$"."f_enm];  \r\n");
	fwrite($fsw,"				}  \r\n");
	fwrite($fsw,"			}//for  \r\n");

	fwrite($fsw,"			$"."mq3=sql_query($"."SQLR);  \r\n");
	fwrite($fsw,"			if( $"."mq3 ) {   \r\n");
	fwrite($fsw,"				m_(\"relation-Table is, Insert OK\" .  $"."r_table );   \r\n");
	fwrite($fsw,"			}else{  \r\n");
	fwrite($fsw,"				echo \"relation-Table is Insert ERROR SQLR: \" . $"."SQLR;   \r\n");
	fwrite($fsw,"			}  \r\n");
	fwrite($fsw,"		}//if  \r\n");
	fwrite($fsw,"}// func   \r\n");

} 

	fwrite($fsw,"?> \r\n");
	fclose($fsw);

include('./include/lib/pclzip.lib.php');
$zf		= $pg_code . '_write.zip';
//$zff		= "../cratree/$H_ID/" . $zf;
$zff		= "./file/" . $H_ID."/" . $zf; //m_("zff:" . $zff); //zff:../t/file/dao/ksd39673976_1687747338_write.zip
$zipfile	= new PclZip($zff);							//압축파일.zip

$data			= array();
//$file_php 	= "../cratree/".$H_ID. "/" . $runF2;	//"../cratree/$H_ID/" . $runF2;
$file_php 	= "./file/". $H_ID . "/" . $runF2;	//"../cratree/$H_ID/" . $runF2;

//$fileR_php 	= "../cratree/".$H_ID. "/" . $runF2r;	//"../cratree/$H_ID/" . $runF2r;
//$Zdir			= "../cratree/" . $H_ID;					// . "/";
$fileR_php 	= "./file/". $H_ID. "/" . $runF2r;	//"../cratree/$H_ID/" . $runF2r;
$Zdir			= "./file/" . $H_ID;					// . "/";

$data = array( $file_php, $fileR_php );		
        //"압축할파일","압축할 디렉토리" //$data = array( $file_php,$fileR_php, $Zdir );
$create		= $zipfile -> create($data, PCLZIP_OPT_REMOVE_ALL_PATH);
echo "<pre>";
//var_dump($create);

	$write_run		= $pg_code . "_write.php";

?> 
<h3> Created OK! pg_code:<?php echo $runF2; ?> , Zip File:<?=$zf?> </h3>
<h3> <a href='<?=$zff?>' target=_blank>[ Down RUN:<?=$zf?> ]</a> </h3> 

<?php
if( $H_LEV > 0 ){ // 7-> 0 으로 변경. 2020-11-19
?>
<h3> <a href='./file/<?=$H_ID?>/<?=$write_run?>' target=_blank>
[ Data_Write RUN:<?=$write_run?> ]</a> </h3>  <!-- data write -->
<?php } ?>
<p>  Created OK! pg_code</p>
<p>To run the downloaded program, </p>
<p>Download the database table and upload it to the server you want to use.</p>
<p>To download a table, click Search Table and click the table name on the right screen, and there is a source download button at the bottom.</p>
</body>
</html>
