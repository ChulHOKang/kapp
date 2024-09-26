<?php
	include_once('./tkher_start_necessary.php');

	/* ----------------------------------------------------------------------
	    tkher_php_tableDN     : 데이터베이스관련및 최에 필요한 모든 소스 다운로드.
		tkher_php_tableDN.php : table create source and download.
		- call : table10i.php : column list program.

		setup.php을 앞축화일에 추가함.: 21-07-22
			
			$default_file	= "./include/default.gif";								//첨부화일 default file.
			$tkher_logo		= "../logo/logo25a.jpg";
			$table_lib		= "./tkher_db_lib.php";
			$tkher_dbcon	= "./tkher_dbcon_create.php";
			$tkher_dblnk	= "./tkher_config_link.php";
			$table_paging	= "./table_paging.php";			// program list 에서사용 : 공통.
			$popup_win		= "./popup_callDN.php";			// program write 에서사용 : 공통.
			$urllink_index	= "./urllink_index.php";		// db user login page - 2021-03-04 add
			$tkher_pg_lib_common= "./tkher_pg_lib_common.php";
			$setup          = "./setup.php";                // appgenerator setup 용.

			$memo = "include/default.gif\n"; //첨부화일 default file.
			$memo =$memo. "logo25a.jpg\n";
			$memo =$memo. "tkher_db_lib.php\n";
			$memo =$memo. "tkher_dbcon_create.php\n";
			$memo =$memo. "tkher_config_link.php\n";
			$memo =$memo. "table_paging.php\n"; 
			$memo =$memo. "popup_callDN.php\n"; 

			$memo =$memo. "excel_upload_user.php\n";   // add 2021-09-30
			$memo =$memo. "excel_download_user.php\n"; // add 2021-09-30

			$memo =$memo. "urllink_index.php\n"; 
			$memo =$memo. "tkher_pg_lib_common.php\n";
			$memo =$memo. "setup.php\n"; // appgenerator setup 용.

			$memo =$memo. $pg_code + "_table_index.php\n"; // add 2021-09-30

		//--- table data process source ----------------
		$table_list_php   = $Zdir."/$tab_enm"."_run.php";
		$table_write_php  = $Zdir."/$tab_enm"."_write.php";
		$table_writer_php = $Zdir."/$tab_enm"."_write_r.php";
		$table_view_php   = $Zdir."/$tab_enm"."_view.php";
		$table_update_php = $Zdir."/$tab_enm"."_update.php";
		../t/file + H_ID 를 ./file + H_ID 로 변경 - 2023-07-19
	---------------------------------------------------------------------- */
	$H_ID		= get_session("ss_mb_id"); 
	$H_LEV = $member['mb_level']; 
	$H_POINT = $member['mb_point']; 
	if( !$H_ID or $H_LEV < 2 ) {
		my_msg("You need to login. ");exit;
		//echo "<script>window.open('/', '_top', '');</script>";exit;
	}

	/////////////////////////< tree file create >////////////////////////////
	$mid = $H_ID;
	//$path = KAPP_PATH_ . "/cratree/";	 //KAPP_PATH_CRATREE_;		// . "../../cratree/";
	$path = KAPP_PATH_T_ . "/file/"; // 2023-06-27 위치를 변경함. 소스생성 위치를 t/file 폴드 사용

	$mode 		= $_POST['mode'];
	//echo "mode:". $mode . ", path:".$path; //mode:sqltable, path:/home1/solpakanurl/public_html/cratree/
	//m_("mode:". $mode);
	$pg_code 	= $_POST['pg_code'];

	if( $mode=='DN_sqltable' || $mode=='sqltable_only') {
		coin_minus_func($H_ID, $config['kapp_download_point']); //$config[cf_download_point] , ($H_ID, 1000)
		$sqltable	= $_POST['sql_list'];
		$tab_enm	= $_POST['tab_enm'];
		$item_cnt	= $_POST['item_cnt'];
	} else{
		m_("write_r : Error, "); exit;
	}
	//------------ source create start --------------------------------------
	$create_table		= $path . $H_ID . "/" . $tab_enm . "_table_index.php";
	$fsi			= fopen("$create_table","w+");		//write file

	fwrite($fsi,"<?php \r\n");
	fwrite($fsi," include \"tkher_db_lib.php\";  \r\n");
	
	fwrite($fsi," $"."mode		= $"."_POST['mode'];        \r\n");
	fwrite($fsi," $"."tab_enm	= $"."_POST['tab_enm'];     \r\n");
	fwrite($fsi," $"."tab_hnm	= $"."_POST['tab_hnm'];     \r\n");
	fwrite($fsi," $"."pg_code	= $"."_POST['pg_code'];     \r\n");
	fwrite($fsi," $"."sqltable	= $"."_POST['sqltable'];    \r\n");

	fwrite($fsi,"?> \r\n");

	fwrite($fsi,"<html> \r\n");
	fwrite($fsi,"<head> \r\n");
	fwrite($fsi,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
	fwrite($fsi,"<TITLE>AppGenerator.net AppGenerator is generator program. Made in Kang ChulHo</TITLE>  \r\n");
	fwrite($fsi,"<link rel='shortcut icon' href='./logo25a.jpg'> \r\n");
	fwrite($fsi,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
	fwrite($fsi,"<meta name='keywords' content='app generator, app maker, appgenerator, app, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> \r\n");
	fwrite($fsi,"<meta name='description' content='app generator, app maker, appgenerator, app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> \r\n");
	fwrite($fsi,"<meta name='robots' content='ALL'> \r\n");
	fwrite($fsi,"</head> \r\n");
	//----------------------------- head -------------------------------------
	fwrite($fsi,"<?php                                 \r\n");
	fwrite($fsi,"	$"."menu1TWPer=15;  \r\n");
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
	fwrite($fsi,".menu1Area{width:100%;  height:60px;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  \r\n");
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

	fwrite($fsi,".Btn_List04A{width:114px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  \r\n");

	fwrite($fsi,".viewHeader{width:100%;height:auto;overflow:hidden;position:relative;text-align:right;}  \r\n");
	fwrite($fsi,".viewHeader span{position:absolute;left:0;top:12px;font-size:14px;color:#686868;}  \r\n");
	fwrite($fsi,".boardView{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
	fwrite($fsi,".boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}  \r\n");
	fwrite($fsi,"</style>  \r\n");

	//--------------------------------------------------------  script -----------------
	fwrite($fsi,"<script language='JavaScript'>   \r\n"); 
	
	//fwrite($fsi,"	function program_data_list($"."pg_code) {   \r\n");
	//fwrite($fsi,"		document.form_view.action='".$pg_code."_run.php';   \r\n");
	//fwrite($fsi,"		document.form_view.target='_self';   \r\n");
	//fwrite($fsi,"		document.form_view.submit();   \r\n");
	//fwrite($fsi,"	}   \r\n");
	
	fwrite($fsi,"	function table_data_list($"."pg_code) {   \r\n");
	//fwrite($fsi,"		document.form_view.action='".$pg_code."_run.php';   \r\n");//2021-03-04 변경.
	fwrite($fsi,"		document.form_view.action=$"."pg_code;   \r\n");
	fwrite($fsi,"		document.form_view.target='_self';   \r\n");
	fwrite($fsi,"		document.form_view.submit();   \r\n");
	fwrite($fsi,"	}   \r\n");

	fwrite($fsi,"	function table_data_delete($"."tab_enm){   \r\n");
	fwrite($fsi,"		if( confirm(\"Are you sure you want to delete table:".$tab_enm."? \") ) {   \r\n");
	fwrite($fsi,"			document.form_view.mode.value='table_data_delete';   \r\n");
	//fwrite($fsi,"			document.form_view.action='".$pg_code."_table_index.php';   \r\n");
	fwrite($fsi,"			document.form_view.action='".$tab_enm."_table_index.php';   \r\n");
	fwrite($fsi,"			document.form_view.submit();   \r\n");
	fwrite($fsi,"		}   \r\n");
	fwrite($fsi,"	}   \r\n");

	fwrite($fsi,"	function table_create($"."pg_code ){   \r\n");
	fwrite($fsi,"		document.form_view.mode.value	= 'table_create';   \r\n");
//	fwrite($fsi,"		document.form_view.action		= '".$pg_code."_table_index.php';   \r\n");
	fwrite($fsi,"		document.form_view.action		= '".$tab_enm."_table_index.php';   \r\n");
	fwrite($fsi,"		document.form_view.submit();   \r\n");
	fwrite($fsi,"	}   \r\n");

	//fwrite($fsi,"	function db_create($"."pg_code ){   \r\n");
	//fwrite($fsi,"		document.form_view.mode.value	= 'db_create';   \r\n");
	//fwrite($fsi,"		document.form_view.action		= 'tkher_dbcon_create.php';   \r\n");
	//fwrite($fsi,"		document.form_view.submit();   \r\n");
	//fwrite($fsi,"	}   \r\n");

	fwrite($fsi,"	function db_create($"."pg_code ){   \r\n");
	//---------- 추가 2021-01-24 입력확인용 추가 ----------------
	fwrite($fsi,"		if( !document.form_view.db_name.value || !document.form_view.db_id.value || !document.form_view.db_password.value ){   \r\n");
	fwrite($fsi,"			alert('db name or db user id or password Confirm your input please');   \r\n");
	fwrite($fsi,"			if( !document.form_view.db_name.value ) document.form_view.db_name.focus();   \r\n");
	fwrite($fsi,"			else if( !document.form_view.db_id.value ) document.form_view.db_id.focus();   \r\n");
	fwrite($fsi,"			else if( !document.form_view.db_password.value ) document.form_view.db_password.focus();   \r\n");
	fwrite($fsi,"			return false;   \r\n");
	fwrite($fsi,"		}   \r\n");
	//---------------------------------------------------- end -----------------------
	fwrite($fsi,"		document.form_view.mode.value	= 'db_create';   \r\n");
//	fwrite($fsi,"		document.form_view.action		= 'tkher_dbcon_create.php';   \r\n"); // 2021-09-29 
	fwrite($fsi,"		document.form_view.action		= 'tkher_dbcon_create.php?table_create_pg=".$tab_enm."_table_index.php';   \r\n");
	fwrite($fsi,"		document.form_view.submit();   \r\n");
	fwrite($fsi,"	}   \r\n");


	//---------- 추가 2021-01-24 DB 재생성 부분 추가 2021-03-03:urllink_index.php add -------
	fwrite($fsi,"	function db_recreate($"."pg_code ){      \r\n");
	//fwrite($fsi,"			document.form_view.mode.value = 'db_recreate';      \r\n");
	fwrite($fsi,"			document.form_view.mode.value = 'db_login';      \r\n");
	fwrite($fsi,"			document.form_view.target = '_blank';      \r\n");
	fwrite($fsi,"			document.form_view.action = 'urllink_index.php';      \r\n");
	fwrite($fsi,"			document.form_view.submit();      \r\n");
	fwrite($fsi,"		}      \r\n");

	fwrite($fsi,"	function db_recreate_action($"."pg_code ){      \r\n");
	fwrite($fsi,"			if( !document.form_view.db_name.value || !document.form_view.db_id.value || !document.form_view.db_password.value ){   \r\n");
	fwrite($fsi,"				alert('db name or db user id or password Confirm your input please');   \r\n");
	fwrite($fsi,"				if( !document.form_view.db_name.value ) document.form_view.db_name.focus();   \r\n");
	fwrite($fsi,"				else if( !document.form_view.db_id.value ) document.form_view.db_id.focus();   \r\n");
	fwrite($fsi,"				else if( !document.form_view.db_password.value ) document.form_view.db_password.focus();   \r\n");
	fwrite($fsi,"				return false;   \r\n");
	fwrite($fsi,"			}   \r\n");
	fwrite($fsi,"			document.form_view.mode.value	= 'db_recreate_action';      \r\n");
	fwrite($fsi,"			document.form_view.action		= 'tkher_dbcon_create.php';      \r\n");
	fwrite($fsi,"			document.form_view.submit();      \r\n");
	fwrite($fsi,"	}      \r\n");
	//---------------------------------------------------- end -----------------------


	fwrite($fsi,"	function home_func($"."pg_code){   \r\n");
	fwrite($fsi,"		form_view.mode='home_func';   \r\n");
	fwrite($fsi,"		form_view.action='".$tab_enm."_table_index.php' ;   \r\n");
	fwrite($fsi,"		form_view.submit();   \r\n");
	fwrite($fsi,"	}   \r\n");
	fwrite($fsi," </script>                                \r\n");

	fwrite($fsi,"  <body width=100%>                            \r\n");
	fwrite($fsi,"  <center>                                           \r\n");
	
	fwrite($fsi,"                                 \r\n");
	fwrite($fsi,"<div class='HeadTitle01AX'>   \r\n");
//	fwrite($fsi,"	<P href='#' class='on' title='Table Create, table code:".$tab_enm." , Table name:".$tab_hnm."'>Table Create : ".$tab_enm."</P>   \r\n");
	fwrite($fsi,"	<P class='on' title='Table Create, table code:".$tab_enm." , Table name:".$tab_hnm."'><a href=\"javascript:home_func('".$tab_enm."');\" style='color:cyan'>Table Create : ".$tab_enm."</a></P>   \r\n");
	fwrite($fsi,"</div>   \r\n");

	fwrite($fsi,"			<form name='form_view' action='' method='post' enctype='multipart/form-data' >						\r\n");
	fwrite($fsi,"				<input type=hidden name='mode'			value='' />															\r\n");
	fwrite($fsi,"				<input type=hidden name='tab_enm'	value='".$tab_enm."' />					\r\n");
	fwrite($fsi,"				<input type=hidden name='tab_hnm'	value='".$tab_hnm."' />					\r\n");
	fwrite($fsi,"				<input type=hidden name='pg_code'	value='".$tab_enm."' />					\r\n");
	fwrite($fsi,"				<input type=hidden name='sqltable'		value='".$sqltable."' />										\r\n");

	fwrite($fsi,"	<div class='boardViewX'>   \r\n");
	fwrite($fsi,"		<div class='viewHeader'>   \r\n");
	fwrite($fsi,"			<span title='tkher_table_create down : tkher_php_table_DN'>tkher_table:".$tab_enm."(".$tab_hnm.") &nbsp;&nbsp;&nbsp; Date:<?=date(\"Y-m-d H:i:s\" ); ?></span>   \r\n");
	// 2021-03-04 : change
	//fwrite($fsi,"			<input type='button' value='List' onclick=\"javascript:table_data_list('".$pg_code."');\" class='Btn_List01A' title='Data List'>   \r\n");
	//fwrite($fsi,"			<input type='button' value='List' onclick=\"javascript:table_data_list('".$pg_code."_run.php');\" class='Btn_List01A' title='Data List'>   \r\n");
	fwrite($fsi,"			<input type='button' value='List' onclick=\"javascript:table_data_list('".$tab_enm."_run.php');\" class='Btn_List01A' title='Data List'>   \r\n");
	fwrite($fsi,"		</div>   \r\n");
	fwrite($fsi,"		<div class='viewSubjX'><span title='(tkher_code:".$tab_enm.":".$tab_hnm.")'>".$tab_hnm."</span> </div>   \r\n");
	fwrite($fsi,"		<div class='blankA'> </div>   \r\n");

	fwrite($fsi,"<?php   \r\n");
	fwrite($fsi,"		if( $"."mode=='table_data_delete' ) {   \r\n");
	fwrite($fsi,"			include \"./tkher_dbcon_Table.php\";    \r\n");
	fwrite($fsi,"			$"."SQL = \" drop table ".$tab_enm." \";   \r\n");
	fwrite($fsi,"				$"."rungo = '".$tab_enm."_table_index.php';   \r\n");
	fwrite($fsi,"			if ( ($"."result = sql_query( $"."SQL ) )==false )   \r\n");
	fwrite($fsi,"			{   \r\n");
	//fwrite($fsi,"				printf(\"delete Invalid query: %s\n\", $"."SQL);   \r\n");
	fwrite($fsi,"				printf(\"delete Invalid query: %s\", $"."SQL);   \r\n");
	fwrite($fsi,"				echo \"<script>table_data_list('$"."rungo'); </script>\";   \r\n");
	fwrite($fsi,"			} else {   \r\n");
	fwrite($fsi,"				echo \"<script>alert('Table Drop - ".$tab_enm." - Delete OK!'); </script>\";  \r\n");
	fwrite($fsi,"				echo \"<script>table_data_list('$"."rungo'); </script>\";   \r\n");
	fwrite($fsi,"			}   \r\n");
	fwrite($fsi,"		}   \r\n");

	fwrite($fsi,"		if( $"."mode=='table_create' ) {   \r\n");

	fwrite($fsi,"			include \"./tkher_dbcon_Table.php\";    \r\n");

	fwrite($fsi,"			$"."SQL = \" ".$sqltable." \";   \r\n");
	fwrite($fsi,"			if ( ($"."result = sql_query( $"."SQL ) )==false )   \r\n");
	fwrite($fsi,"			{   \r\n");
	fwrite($fsi,"				printf(\"Create  Invalid query: %s\n\", $"."SQL);   \r\n");
	fwrite($fsi,"				exit();   \r\n");
	fwrite($fsi,"			} else {   \r\n");
	fwrite($fsi,"				echo \"<script>alert('Create Table $tab_enm OK!'); </script>\";  \r\n");

	fwrite($fsi,"				$"."rungo = '".$tab_enm."_table_index.php';   \r\n");
	fwrite($fsi,"				echo \"<script>table_data_list('$"."rungo'); </script>\";   \r\n");
	fwrite($fsi,"			}   \r\n");
	fwrite($fsi,"		}   \r\n");

	fwrite($fsi,"?>   \r\n");
	fwrite($fsi,"	<P> table name:".$tab_enm."<br>SQL:<br>".$sqltable."</P>   \r\n");

	fwrite($fsi,"<?php   \r\n");
	fwrite($fsi,"		$"."connect_dbcheck = '';            \r\n");
	fwrite($fsi,"		$"."dbconfig_file = \"./tkher_dbcon_Table.php\";            \r\n");
	fwrite($fsi,"		if ( file_exists($"."dbconfig_file) ) {           \r\n");
	fwrite($fsi,"			include_once( $"."dbconfig_file );    \r\n");
	
	fwrite($fsi,"			$"."sql = \"SHOW TABLES LIKE '".$tab_enm."' \";		\r\n");
	fwrite($fsi,"			$"."ret = sql_query($"."sql);						        \r\n");
	fwrite($fsi,"			$"."row = sql_fetch_array($"."ret);		                \r\n");

	fwrite($fsi,"				if( $"."row == true) {		\r\n");
	fwrite($fsi,"?>								\r\n");
	fwrite($fsi,"					<input type='button' value='Table Delete' onclick=\"javascript:table_data_delete('".$tab_enm."');\" class='Btn_List03A' title='The table exists. You can delete the table and create it again.'>      \r\n");//테이블이 존재합니다. 테이블을 삭제후 다시 생성할수있습니다.
    //------------ add 2021-03-04 : DB reset page add - urllink_index.php -------
	fwrite($fsi,"				<br><br><input type='button' value='DB Reset' onclick=\"javascript:db_recreate('".$tab_enm."');\" class='Btn_List03A'  title='Run only when resetting the DB user ID and password.' >  \r\n");//DB 사용자 아이디와 비밀번호를 재설정할때에만 실행하세요.
	
	fwrite($fsi,"					<p>Table created. You can delete the table and regenerate it. </p>      \r\n");
	//----------------------------------------------------------------------
	fwrite($fsi,"<?php		} else if( $"."connect_dbcheck != 'dberror' ) { ?>			\r\n");
	// ------------ add start ---
				//-------------------------------------- start
	fwrite($fsi,"<?php			if( $"."_POST['mode'] != 'db_recreate' ) {  \r\n");
	fwrite($fsi,"					$"."hostnm = KAPP_MYSQL_HOST;          \r\n");
	fwrite($fsi,"					$"."dbnm = KAPP_MYSQL_DB;              \r\n");
	fwrite($fsi,"					$"."usernm = KAPP_MYSQL_USER;          \r\n");
	fwrite($fsi,"					$"."passwordnm = KAPP_MYSQL_PASSWORD;  \r\n");
	fwrite($fsi,"?>			                                                \r\n");
	fwrite($fsi,"					<input type='button' value='DB Reset' onclick=\"javascript:db_recreate('".$tab_enm."');\" class='Btn_List03A'  title='Run only when resetting the DB user ID and password.' >  \r\n");//DB 사용자 아이디와 비밀번호를 재설정할때에만 실행하세요.
	fwrite($fsi,"					<p>DB Reset</p>      <br>  \r\n");
	fwrite($fsi,"          <?php }  ?>  \r\n");

	fwrite($fsi,"					<input type='button' value='Table Create' onclick=\"javascript:table_create('".$tab_enm."');\" class='Btn_List03A'  title='Create a table : $tab_enm' ><br>   \r\n");
	fwrite($fsi,"<?php		}  \r\n");
	fwrite($fsi,"		    if ( $"."_POST['mode'] == \"db_recreate\" ) {  \r\n"); 
	fwrite($fsi,"				$"."hostnm = KAPP_MYSQL_HOST;  \r\n");
	fwrite($fsi,"				$"."dbnm = KAPP_MYSQL_DB;  \r\n");
	fwrite($fsi,"				$"."usernm = KAPP_MYSQL_USER;  \r\n");
	fwrite($fsi,"				$"."passwordnm = KAPP_MYSQL_PASSWORD;  \r\n");
				//-------------------------------------- end
	fwrite($fsi,"?>     \r\n");

	// ------------ add end   ---
    /* 제거부분 --------
	fwrite($fsi,"					<input type='button' value='Table Create' onclick=\"javascript:table_create('".$tab_enm."');\" class='Btn_List03A'  title='Create a table. ' ><br>    \r\n");

	fwrite($fsi,"					<p>Create a table!</p>      \r\n");
	fwrite($fsi,"<?php		}			    \r\n");
	fwrite($fsi,"			if ( $"."connect_dbcheck == 'dberror' ) { ?>   \r\n");
    */

	fwrite($fsi," <div>      \r\n");

    //------------------------------ add start
	fwrite($fsi," 				<p>DB ReCreate : tkher_db_lib.php </p> \r\n");
	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>*Host Name</span></div> \r\n");
	fwrite($fsi," <div class='menu1A'><input type='text' name='host_name' value='localhost' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a Host Name'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div> \r\n");
	//------------------------------ add end

	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>*DB Name</span></div>  \r\n");
	fwrite($fsi," <div class='menu1A'><input type='text' name='db_name' value='<?=$"."dbnm?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a DB Name'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div>  \r\n");

	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>DB Uaer ID</span></div>  \r\n");
	fwrite($fsi," <div class='menu1A'><input type='text' name='db_id' value='<?=$"."usernm?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a DB User ID'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div>  \r\n");

	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>DB User Password</span></div>  \r\n");
	fwrite($fsi," <div class='menu1A'><input type=password name='db_password' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a DB User Password'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div>  \r\n");

	fwrite($fsi," <input type='button' value='DB_ReSet Save' onclick=\"javascript:db_recreate_action('".$tab_enm."');\" class='Btn_List04A' title='After setting db, you can create a table.'>      \r\n");

	//fwrite($fsi," <input type='button' value='DB_Set' onclick=\"javascript:db_create('".$pg_code."');\" class='Btn_List03A' title='After setting db, you can create a table.'>      \r\n");//db를 설정한후에 table을 생성할수있습니다.

	fwrite($fsi,"<?php											\r\n");
	fwrite($fsi,"					echo \"<p>You can ReSet DB.  : connect_dbcheck:<?=$"."connect_dbcheck?> </p>\";      \r\n");
	fwrite($fsi,"			}	// dbconnection error		\r\n");

	fwrite($fsi,"} else {				\r\n");
	fwrite($fsi,"	?>							\r\n");

	fwrite($fsi," <div>      \r\n");
	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>*Host Name</span></div>  \r\n");
	fwrite($fsi," <div class='menu1A'><input type='text' name='host_name' value='localhost' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a Host Name'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div>  \r\n");

	fwrite($fsi," <div>      \r\n");
	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>DB Name</span></div>  \r\n");
	fwrite($fsi," <div class='menu1A'><input type='text' name='db_name' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a DB Name'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div>  \r\n");

	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>DB Uaer ID</span></div>  \r\n");
	fwrite($fsi," <div class='menu1A'><input type='text' name='db_id' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a DB User ID'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div>  \r\n");

	fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>DB User Password</span></div>  \r\n");
	fwrite($fsi," <div class='menu1A'><input type=password name='db_password' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a DB User Password'></div>  \r\n");
	fwrite($fsi," <div class='blankA'> </div>  \r\n");

	fwrite($fsi," <input type='button' value='DB Login' onclick=\"javascript:db_create('".$tab_enm."');\" class='Btn_List03A' title='After setting and login db, you can create a table.'>      \r\n");//db를 설정and login 한후에 table을 생성할수있습니다. 2021-09-29

	fwrite($fsi," <p>After setting db, you can create a table.</p>      \r\n");
	fwrite($fsi,"<?php	}	?>										\r\n");

	fwrite($fsi," <p>Files that need to be uploaded only once.</p>      \r\n");// 처음한번만 업로드하면되는화일들.

	fwrite($fsi," <p> ".$tab_enm."_table_index.php      : DB Table Create</p>      \r\n");
	fwrite($fsi," <p> urllink_index.php       : DB Set - db name, db user, db password</p>      \r\n");
	fwrite($fsi," <p> tkher_dbcon_create.php  : tkher_dbcon.php create </p>      \r\n");		// DB Setup 용.
	fwrite($fsi," <p> tkher_dbcon_create.php  : tkher_dbcon_Table.php create </p>      \r\n"); // table create 용.
	fwrite($fsi," <p> tkher_pg_lib_common.php : DB lib  </p>      \r\n");
	
	fwrite($fsi," <p> tkher_config_link.php</p>      \r\n");
	fwrite($fsi," <p> tkher_db_lib.php</p>      \r\n");
	fwrite($fsi," <p> table_paging.php</p>      \r\n");
	fwrite($fsi," <p> default.gif</p>      \r\n");
	fwrite($fsi," <p> logo25a.jpg</p>      \r\n");

	//fwrite($fsi," <input type='button' value='List' onclick=\"javascript:program_data_list('".$pg_code."');\" class='Btn_List02A' title='data list'>       \r\n");
	fwrite($fsi," </div>      \r\n");
	fwrite($fsi,"			</form>    \r\n");
	fwrite($fsi,"			</body>    \r\n");
	fwrite($fsi,"			</html>    \r\n");

fclose($fsi);

	include('./include/lib/pclzip.lib.php');
	 $zf = $tab_enm . '_table.zip';
	 $zff = "./file/".$H_ID."/" . $zf;	 //$zff="../t/file/".$H_ID."/".$zf;	//echo "<br>zff:" . $zff;// zff:../cratree/dao/dao_1632726444_table.zip
	$zipfile = new PclZip($zff);				//압축파일.zip

	//-- 파일명,디렉토리 또는 배열로 지정가능 
	$table_run		= $tab_enm . "_table_index.php";    // DB , Table create 
	$data				= array();
	$Zdir				= "./file/" . $H_ID;			// $Zdir= "../t/file/" . $H_ID; // 소스 생성된 디렉토리. 2023-07-19 change
	$file_php 		= "./file/" . $H_ID . "/" . $table_run;	 //$file_php= "../t/file/" . $H_ID . "/" . $table_run;	 
	$default_file	= "./include/img/default.gif";								//첨부화일 default file.
	$tkher_logo		= "./logo/logo25a.jpg";
	$table_lib		= "./source_down_pg/tkher_db_lib.php";
	$table_lib2		= "./source_down_pg/urllink_db_lib.php";
	$tkher_dbcon	= "./source_down_pg/tkher_dbcon_create.php";	// 
	$tkher_dblnk	= "./source_down_pg/tkher_config_link.php";
	$table_paging	= "./source_down_pg/table_paging.php";
	$popup_win		= "./source_down_pg/popup_callDN.php";
	
	$urllink_index	= "./source_down_pg/urllink_index.php";		// db user login page - 2021-03-04 add
	$tkher_pg_lib_common = "./source_down_pg/tkher_pg_lib_common.php";
	$excel_upload_user   = "./source_down_pg/excel_upload_user.php";  
	$excel_download_user = "./source_down_pg/excel_download_user.php";  // 13
	
	//$setup          = "./setup.php"; // <- 여기에서 tkher_dbconfig.php의 소스를 생성한다. appgenerator setup 용.
	//--- table data process source ----------------
    $table_list_php   = $Zdir."/".$tab_enm."_run.php";
    $table_write_php  = $Zdir."/".$tab_enm."_write.php";
    $table_writer_php = $Zdir."/".$tab_enm."_write_r.php";
    $table_view_php   = $Zdir."/".$tab_enm."_view.php";
    $table_update_php = $Zdir."/".$tab_enm."_update.php";
	// table 관련 데이터 등록 프로그램을 생성 하지 않은 상태 일때와 구분 하여 소스를 생성 해야 한다.
	// 압축 데이터가 이상할때 브라우즈 설정 클리어 후 다시실행하면 정상....?
	if( $mode == "DN_sqltable") { // DB and Table ALL or mode:sqltable_only
		$memo = "\n * <b>All Download</b> : \n";
				$memo =$memo. $default_file . "\n";
				$memo =$memo. $tkher_logo . "\n";
				$memo =$memo. $table_lib . "\n";
				$memo =$memo. $table_lib2 . "\n";
				$memo =$memo. $tkher_dbcon . "\n";
				$memo =$memo. $tkher_dblnk . "\n";
				$memo =$memo. $table_paging . "\n";
				$memo =$memo. $popup_win . "\n";
				$memo =$memo. $urllink_index . "\n";
				$memo =$memo. $tkher_pg_lib_common . "\n";
				$memo =$memo. $excel_upload_user . "\n";
				$memo =$memo. $excel_download_user . "\n";

				$memo =$memo. $file_php . "\n";

		if( file_exists( $table_list_php ) ){
			$data = array( $table_list_php, $file_php, $table_lib, $table_lib2, $tkher_dbcon, $tkher_dblnk, $tkher_logo, $default_file, $table_paging, $popup_win, $urllink_index, $tkher_pg_lib_common, $excel_upload_user, $excel_download_user );
			$memo =$memo. $table_list_php . "\n";
			if( file_exists( $table_write_php ) ) {
				$data = array( $table_write_php, $table_writer_php, $table_list_php, $file_php, $table_lib, $table_lib2, $tkher_dbcon, $tkher_dblnk, $tkher_logo, $default_file, $table_paging, $popup_win, $urllink_index, $tkher_pg_lib_common, $excel_upload_user, $excel_download_user );

				$memo =$memo. $table_write_php . "\n";
				$memo =$memo. $table_writer_php . "\n";
			}
			if( file_exists( $table_view_php ) ) {
				$data = array( $table_view_php, $table_update_php, $table_write_php, $table_writer_php, $table_list_php, $file_php, $table_lib, $table_lib2, $tkher_dbcon, $tkher_dblnk, $tkher_logo, $default_file, $table_paging, $popup_win, $urllink_index, $tkher_pg_lib_common, $excel_upload_user, $excel_download_user );
				$memo =$memo. $table_view_php . "\n";
				$memo =$memo. $table_update_php . "\n";
			}
			//echo ("<br>파일이 존재합니다. " . $Zdir."/$tab_enm"."_run.php");
			else { // add 후 검토하진않음. 
				$data = array( $table_lib, $table_lib2, $tkher_dbcon, $tkher_dblnk, $tkher_logo, $default_file, $table_paging, $popup_win, $urllink_index, $tkher_pg_lib_common, $file_php, $excel_upload_user, $excel_download_user );
			}
		}else{
			$data = array( $file_php, $table_lib, $table_lib2, $tkher_dbcon, $tkher_dblnk, $tkher_logo, $default_file, $table_paging, $popup_win, $urllink_index, $tkher_pg_lib_common, $excel_upload_user, $excel_download_user );

			//--- title print memo ----------------
			$memo = "include/default.gif\n"; //첨부화일 default file.
			$memo =$memo. "logo25a.jpg\n";
			$memo =$memo. "tkher_db_lib.php\n";
			$memo =$memo. "urllink_db_lib.php\n";
			$memo =$memo. "tkher_dbcon_create.php\n";
			$memo =$memo. "tkher_config_link.php\n";
			$memo =$memo. "table_paging.php\n"; 
			$memo =$memo. "popup_callDN.php\n"; 
			$memo =$memo. "excel_upload_user.php\n";    // add:2021-09-30
			$memo =$memo. "excel_download_user.php\n";  // add:2021-09-30

			$memo =$memo. "<b>urllink_index.php <- DB setup file</b> \n"; 
			$memo =$memo. "tkher_pg_lib_common.php\n";

			//$memo =$memo. "tkher_dbconfig_create.php \n"; 
			//$memo =$memo. "urllink_db_lib.php \n"; 
			//$memo =$memo. "setup.php <- installation executable file \n";
			//echo "data_msg: " . $data_msg;
		}
		
	} else { // $mode="sqltable_only" Table 관련 소스만 압축 생성		//m_("222". $mode);
		$memo = "\n * <b>sqltable_only</b> : \n";
		if( file_exists( $table_list_php ) )
		{
			$data = array( $table_list_php, $file_php );
			
			$memo = $memo. $table_list_php . "\n";
			$memo = $memo. $file_php . "\n";

			if( file_exists( $table_write_php ) )
			{
				$data = array( $table_write_php, $table_writer_php, $table_list_php, $file_php);
				$memo =$memo. $table_write_php . "\n";
				$memo =$memo. $table_writer_php . "\n";
			}
			if( file_exists( $table_view_php ) )
			{
				$data = array( $table_view_php, $table_update_php, $table_write_php, $table_writer_php, $table_list_php, $file_php);
				$memo =$memo. $table_view_php . "\n";
				$memo =$memo. $table_update_php . "\n";
			}
			//echo ("<br>데이터 등록 조회 변경 소스 파일이 존재합니다. " . $Zdir."/$tab_enm"."_run.php");
		}else{
				$data = array( $file_php );// 테이블 생성 소스만 생성. 데이터 등록 조회 변경 소스 파일이 존재 안 합니다
				//--- title print memo ----------------
				$memo = $memo. $file_php . "\n"; //첨부화일 default file.
		}
		
	}
	//echo "<pre>";	var_dump($data);

	$create	= $zipfile -> create($data, PCLZIP_OPT_REMOVE_ALL_PATH);	
	
	//PCLZIP_OPT_REMOVE_ALL_PATH : 디렉토리무시하고 압축.

	//PCLZIP_OPT_REMOVE_ALL_PATH :옵션의 경우에는 file_array 에 속한 파일들이 특정 타 폴더에 있더라도,압축파일에서는 경로를 빼고 파일만 압축을 한다는 뜻
	/* 압축해제:
							$list = $archive->extract(PCLZIP_OPT_PATH, "folder" , PCLZIP_OPT_REMOVE_ALL_PATH);
						   $list  =  $archive->extract(PCLZIP_OPT_PATH, "folder",
                               PCLZIP_OPT_REMOVE_PATH, "data",
                               PCLZIP_CB_PRE_EXTRACT, "callback_pre_extract",
                               PCLZIP_CB_POST_EXTRACT, "callback_post_extract");
							   */

	//echo "create: <pre>";	var_dump($create);
?> 

<b>Created OK!  <br>Zip File:<?=$zf?><br>Table Creation File:<?=$table_run?></b>
<?php
echo "<br><b>Source list:</b><br>" . $memo;
?>
<br><b>  SQL code:<?=$sqltable?></b>
<p><a href='<?=$zff?>' target='_blank' title="memo:<?=$memo?>"><b>[ Down RUN:<?=$zf?> ]</b></a></p>
<br> Uncompress and upload the files to the server.
<br><b> You can run the file : '<?=$tab_enm?>_table_index.php' 
<br> DB setup! run only once at first : 'urllink_index.php' </b>
<br>
<?php 
if( $H_LEV > 7 ) { // 테이블부분만 7 그대로 두고 머지 소스다운 프로그램은 7-> 0 으로 변경. 2020-11-19
?>
	<a href='./file/<?=$H_ID?>/<?=$table_run?>?tab_enm=<?=$tab_enm?>' target='_blank'>[ level > 7 , Table Create RUN:<?=$table_run?> ]</a> 
<?php } ?>
</body>
</html>
