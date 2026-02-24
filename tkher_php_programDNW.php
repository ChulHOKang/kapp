<?php
	include_once('./tkher_start_necessary.php');
	/* ---------------------------------------------------------------------- 
	    KAPP : Create Apps with No Code
		data insert 데이터 등록 소스코드 다운로드.
		tkher_php_programDNW.php : write and write_r source create and download.
		  tkher_program_run.php에서 콜.
		- call : tkher_program_data_writeDN.php : data insert program.
	---------------------------------------------------------------------- */
	$H_ID= get_session("ss_mb_id"); 
	if( $H_ID=='' ) {
		m_("You need to login. ");exit;
	}
	$H_LEV		=$member['mb_level']; 
	$email_id	=$member['mb_email']; 
	$pg_code	= $_POST['pg_code'];
	$mode 		= $_POST['mode'];
	if( $mode == 'write_r' && $pg_code ) {
		if( $H_ID != 'dao' ) coin_minus_func($H_ID, 1000);
	} else exit();
	$mid = $H_ID;
	$path = KAPP_PATH_T_ . "/file/"; 
	$runF1	= $pg_code . "_run.php";
	$runF2	= $pg_code . "_write.php";
	$runF2r	= $pg_code . "_write_r.php";
	$insfile	= $path . $H_ID . "/" . $pg_code . "_write.php";
	$fsi		= fopen("$insfile","w+");
	$fld_enm	= array();
	$fld_hnm	= array();
	$fld_type	= array();
	$fld_len	= array();
	$list		= array();
	$item		= array(); 
	$ddd		= "";
	$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$resultPG = sql_query($sqlPG);
	$table10_pg = sql_num_rows($resultPG);
	if( !$table10_pg  ) {
			m_(" Abnormal approach. program no found! : $pg_code"); exit();
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
	$relation_typePG =$rsPG['relation_type'];
	if( $mode !='write_r') {
		m_("tkher_php_programDNW write_r : Error, "); exit;
	}
	$list		= explode("@", $item_array);
	$search_fld = '';
	for ( $i=0; $list[$i] != ""; $i++ ){
		$ddd			= $list[$i];
		$item			= explode("|", $ddd);
		$fld_enm[$i]	= $item[1];
		$fld_hnm[$i]	= $item[2];
		$fld_type[$i]	= $item[3];
		$fld_len[$i]	= $item[4];
		if( $i==0 && !$search_fld) $search_fld = $item[1];
	}

fwrite($fsi,"<?php \r\n");
fwrite($fsi,"	$"."searchNameA = '".KAPP_URL_T_."';  \r\n");
fwrite($fsi,"	if( strpos( $"."searchNameA, $"."_SERVER['HTTP_HOST']) == true) {    \r\n");
fwrite($fsi,"       include '" . KAPP_PATH_T_ . "/tkher_start_necessary.php';		\r\n");
fwrite($fsi,"	} else {    \r\n");
fwrite($fsi,"       include './tkher_db_lib.php';		\r\n");
fwrite($fsi,"		include './tkher_dbcon_Table.php';  \r\n");
fwrite($fsi,"	}  \r\n");
fwrite($fsi,"?> \r\n");
fwrite($fsi,"<html> \r\n");
fwrite($fsi,"<head> \r\n");
fwrite($fsi,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
fwrite($fsi,"<TITLE>KAPP - Create Apps with No Code . Made in ChulHo Kang : solpakan89@gmail.com</TITLE>  \r\n");
fwrite($fsi,"<link rel='shortcut icon' href='/logo/logo25a.jpg'> \r\n");
fwrite($fsi,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
fwrite($fsi,"<meta name='keywords' content='no code webapp generator, No code app creation, no code webapp create, web generator'> \r\n");
fwrite($fsi,"<meta name='description' content='no code webapp generator, No code app creation, no code webapp create, web generator,'> \r\n");
fwrite($fsi,"<meta name='robots' content='ALL'> \r\n");
fwrite($fsi,"</head> \r\n");
fwrite($fsi,"<?php                                 \r\n");
fwrite($fsi,"	$"."is_mobile = false;  \r\n");
fwrite($fsi,"	$"."is_mobile = preg_match('/'.KAPP_MOBILE_AGENT.'/i', $"."_SERVER['HTTP_USER_AGENT']);   \r\n");
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

fwrite($fsi,"  <link rel='stylesheet' href='kapp_basic.css' type='text/css' />  \r\n");
//fwrite($fsi,"  <link rel=\"stylesheet\" href=\"".KAPP_URL_T_."/include/css/kapp_basic.css\" type=\"text/css\" />  \r\n");

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
fwrite($fsi,"	$"."if_typePG  = '" . $if_typePG . "'; \r\n");
fwrite($fsi,"	$"."if_dataPG  = '" . $if_dataPG . "'; \r\n");
fwrite($fsi,"	$"."pop_dataPG = '" . $pop_dataPG . "'; \r\n");
fwrite($fsi,"	$"."item_array		= '" . $item_array . "';    \r\n");
fwrite($fsi,"	$"."_SESSION['if_typePG'] = $"."if_typePG;\r\n");
fwrite($fsi,"	$"."_SESSION['if_dataPG'] = $"."if_dataPG; \r\n");
fwrite($fsi,"	$"."_SESSION['pop_dataPG']= $"."pop_dataPG; \r\n");
fwrite($fsi,"	$"."_SESSION['relation_dataPG']= $"."relation_dataPG; \r\n");
fwrite($fsi,"	$"."_SESSION['relation_typePG']= $"."relation_typePG; \r\n");
fwrite($fsi,"	$"."in_day = date('Y-m-d H:i:s');   \r\n");
fwrite($fsi,"	    \r\n");
fwrite($fsi,"	if( isset($"."_POST['page']) ) $"."page = $"."_POST['page'];	    \r\n");
fwrite($fsi,"	else if( isset($"."_REQUEST['page']) ) $"."page = $"."_REQUEST['page'];	    \r\n");
fwrite($fsi,"	else $"."page=1;	    \r\n");
fwrite($fsi,"	if( isset($"."_POST['line_cnt']) ) $"."line_cnt = $"."_POST['line_cnt'];	    \r\n");
fwrite($fsi,"	else if( isset($"."_REQUEST['line_cnt']) ) $"."line_cnt = $"."_REQUEST['line_cnt'];	    \r\n");
fwrite($fsi,"	else $"."line_cnt = 10;	    \r\n");

fwrite($fsi,"?>                                 \r\n");

fwrite($fsi,"          <span title='pg:".$pg_code."'>K-App:".$pg_code."&nbsp;&nbsp;&nbsp;<?=$"."in_day?></span> \r\n");
fwrite($fsi,"		</div>   \r\n");
fwrite($fsi,"		<div class='viewSubjX'><span title='(".$pg_code.":".$tab_hnm.")'>".$pg_name."</span> </div>   \r\n");
fwrite($fsi,"		<div class='blankA'> </div>   \r\n");
fwrite($fsi,"		<form name='makeform' method='post' enctype='multipart/form-data'>   \r\n");
fwrite($fsi,"				<input type='hidden' name='page'		value='<?=$"."_REQUEST[\"page\"]?>' />   \r\n");
fwrite($fsi,"				<input type='hidden' name='line_cnt'	value='<?=$"."_REQUEST[\"line_cnt\"]?>' />   \r\n");

		$kkk="off";
		$ddd = "";
		$iftypeX = "";
		$ifdataX = "";
		$kkk0 = array();
		$kkk1 = array();
		$kkk2 = array();
		$kkk3 = array();
		$kkk5 = 1;
		$iftype		= explode("|", $if_typePG);
		$ifdata		= explode("|", $if_dataPG);
		for( $i=0,$j=1; isset($list[$i]) && $list[$i] != ""; $i++, $j++ ){
				$ddd		= $list[$i];
				if( isset($iftype[$j]) && $iftype[$j]!='' ) $typeX	= $iftype[$j];
				else $typeX	= '';
				if( isset($ifdata[$j]) && $ifdata[$j]!='' ) $dataX	= $ifdata[$j];
				else $dataX	= '';
				if( isset($dataX) && $dataX!='' ) $if_fld = explode(":", $dataX);
				else $if_fld = '';
				if( isset($ddd) ) $fld = explode("|", $ddd);
				else $fld="";
			if( isset($fld[1]) && $fld[1] != "seqno") {
				$fld_enmX	= $fld[1];
				if( $fld[3] == "TEXT" ) {
					fwrite($fsi," <p>" . $fld[2] . "</p>  \r\n");
					fwrite($fsi," <div class='menu1Area' ><textarea name='".$fld[1]."' placeholder='Please enter your $fld[2]!' style='width:<?=$"."Xwidth?>;height:<?=$"."Text_height?>;'></textarea></div>  \r\n");
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				} else if( $fld[3] == "DATE" ) { 
					fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
					fwrite($fsi," <div class='menu1A'><input type='".$fld[3]."' name='".$fld[1]."' value='<?=$"."day?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></div>  \r\n");
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				} else if( $fld[3] == "DATETIME" || $fld[3] == "TIMESTAMP" ) { 
					fwrite($fsi,"<?php $"."day=date('Y-m-d H:i:s'); ?> \r\n");
					fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
					fwrite($fsi," <div class='menu1A'><input type='".$fld[3]."' name='".$fld[1]."' value='<?=$"."day?>' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></div>  \r\n");
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				} else if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "BIGINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ) { 
					fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
					if( $typeX == "11" ) { // calc
							$kkk=$fld[1];
							$idata=explode(":", $dataX);
							$datax = $idata[1];
							$datay = $idata[0];
							$ff = explode(" ", $datay);
							$f0 = $ff[0];
							$f1 = $ff[1];
							$f2 = $ff[2];
							$f3 = $ff[3];
							$f4 = $ff[4];

							$kkk0[$kkk5] = "document.makeform." . $f0 . ".value";
							$kkk1[$kkk5] = "document.makeform." . $f2 . ".value";
							if( is_numeric($f4) ) $kkk2[$kkk5] = $f4;
							else $kkk2[$kkk5] = "document.makeform." . $f4 . ".value";
							$kkk3[$kkk5] = $f3;

							fwrite($fsi," <div class='menu1A'><span><input type='number' name='".$fld[1]."' onClick='FUNC_".$kkk5."()' title='FUNC_".$kkk5."()' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."'></span></div>  \r\n");

							$kkk5++;
					} else {
							fwrite($fsi," <div class='menu1A'><input type='number' name='".$fld[1]."' value='' style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;' placeholder='Please enter a ".$fld[2]."' class=autom_subj></div>  \r\n");
					}
					fwrite($fsi," <div class='blankA'> </div>  \r\n");
				} else {
					if( $typeX == "1" ) { // radio button
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='ListBox1A'><span> \r\n");
						for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
							fwrite($fsi," <input type='radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' class='input1A'>" . $if_fld[$k] . " &nbsp;  \r\n");
						}
							fwrite($fsi," </span></div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else if( $typeX == "3" ) { //check box
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='ListBox1A'><span> \r\n");
							for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
								fwrite($fsi," <input type='Checkbox' name='" . $fld[1] .  "[]'  value='" . $if_fld[$k] . "' >" . $if_fld[$k] . " &nbsp; \r\n");
							}
							fwrite($fsi," </span></div>  \r\n");
							fwrite($fsi," <div class='blankA'> </div>  \r\n");
					} else if( $typeX == "5" ) { // list box
							fwrite($fsi," <div class='menu1T' align='center'><span style='width:<?=$"."Xwidth?>;height:<?=$"."Xheight?>;'>".$fld[2]."</span></div>  \r\n");
							fwrite($fsi," <div class='ListBox1A'> \r\n");
							fwrite($fsi," <SELECT NAME='".$fld[1]."' SIZE='1' style='border-style:;height:25;'>  \r\n");
						for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
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
					} else if( $typeX == "13" ) { // popupwindow
							//m_("typeX:$typeX, i:$i");
							fwrite($fsi,"<?php                                 \r\n");
							fwrite($fsi,"  $"."fld_session = ".$i.";	// popup table info.   \r\n");
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
					m_("seqno ========== ");
			}
		}//for
		
fwrite($fsi,"<?php                                 \r\n");
fwrite($fsi,"			if( isset($"."fld_session) ) $"."_SESSION['fld_session']=$"."fld_session; \r\n");
fwrite($fsi,"			else $"."_SESSION['fld_session']='';  \r\n");
fwrite($fsi,"?>                                 \r\n");
fwrite($fsi,"		<input type='hidden' name='mode'			value=''>   \r\n");
fwrite($fsi,"		<input type='hidden' name='tab_hnm'			value=''>   \r\n");
fwrite($fsi,"		<input type='hidden' name='tab_enm'			value=''>   \r\n");
fwrite($fsi,"		<input type='hidden' name='return_pg_code'	value=''>   \r\n");
fwrite($fsi,"				<input type='hidden' name='item_array'	value='<?=$"."item_array?>'>   \r\n");

//fwrite($fsi,"		<input type='button' value='submit' onclick=\"program_run_pg('".$i."','".$if_type."')\" class='Btn_List01A'>   \r\n");
fwrite($fsi,"		<input type='button' value='submit' onclick=\"program_run_pg('".$i."','".$if_typePG."')\" class='kapp_btn_bo02'>   \r\n");
fwrite($fsi,"		<input type='reset' value='reset' class='kapp_btn_bo02'>   \r\n");
fwrite($fsi,"		<input type='button' value='Excel_Upload' onclick=\"excel_upload_func('".$tab_enm."','".$tab_hnm."')\" class='kapp_btn_bo02' title='Batch upload of data to excel file'>     \r\n");

fwrite($fsi,"       <input type='button' value='List' onclick=\"javascript:table_data_list();\" class='kapp_btn_bo02'> \r\n");
fwrite($fsi,"      </form>                    \r\n");
fwrite($fsi,"                                 \r\n");

fwrite($fsi,"<script language='JavaScript'>   \r\n"); 
fwrite($fsi,"<!--   \r\n");
fwrite($fsi,"	function popup_callDN(if_dataPG, pop_dataPG, if_typePG , host_url, i) {   \r\n");
fwrite($fsi,"	substring = '".$_SERVER['HTTP_HOST']."'; \r\n");
fwrite($fsi,"	if( host_url.includes(substring) ) Trun='../../popup_call.php?fld_session='+i; \r\n"); 
fwrite($fsi,"	else Trun='./popup_callDN.php?fld_session='+i; \r\n");

fwrite($fsi,"		window.open( Trun,'', 'alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes');   \r\n");
fwrite($fsi,"		return true;     \r\n");
fwrite($fsi,"	}   \r\n");

fwrite($fsi,"	function input_check(item_cnt,iftype) {   \r\n");

fwrite($fsi,"		itype=iftype.split('|');   \r\n");
fwrite($fsi,"		for(i=1;i<item_cnt;i++) {   \r\n");
fwrite($fsi,"			if( !itype[i] || itype[i] =='0'  ) {   \r\n");
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
fwrite($fsi,"		document.makeform.action='./" . $runF2r . "';   \r\n");	// write_r php
fwrite($fsi,"		document.makeform.target='_self';   \r\n");
fwrite($fsi,"		document.makeform.submit();   \r\n");
fwrite($fsi,"	}   \r\n");
fwrite($fsi,"	function table_data_list() {   \r\n");

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
fwrite($fsi," //-->                                \r\n");
fwrite($fsi," </script>                                \r\n");

	if( $kkk !="off") {
		for( $fi=1, $fj=1; $fi<$kkk5; $fi++, $fj++){
			$k0=$kkk0[$fj];
			$k1=$kkk1[$fj];
			$k2=$kkk2[$fj];
			$k3=$kkk3[$fj];

			fwrite($fsi, "<script>                                \r\n");
			fwrite($fsi, "function FUNC_".$fj."() {   \r\n");
			fwrite($fsi, "	v1 = ( ".$k1." * 1 ) ".$k3." ( ".$k2 ." * 1 ); \r\n");
			fwrite($fsi, "  " . $k0 . " = v1;  \r\n");
			fwrite($fsi, "}  \r\n");
			fwrite($fsi, " </script>      \r\n");
		}
	}

fclose($fsi);

$insfile_r = $path . $H_ID . "/" . $pg_code . "_write_r.php";
$fsw = fopen("$insfile_r","w+");

fwrite($fsw,"<?php \r\n");

fwrite($fsw,"	$"."searchNameA = '".KAPP_URL_T_."';  \r\n");
fwrite($fsw,"	if( strpos( $"."searchNameA, $"."_SERVER['HTTP_HOST']) == true) {    \r\n");
fwrite($fsw,"       include '" . KAPP_PATH_T_ . "/tkher_start_necessary.php';		\r\n");
fwrite($fsw,"	} else {    \r\n");
fwrite($fsw,"       include './tkher_db_lib.php';		\r\n");
fwrite($fsw,"		include './tkher_dbcon_Table.php';  \r\n");
fwrite($fsw,"		// tkher_dbcon_create.php - generator.  \r\n");
fwrite($fsw,"	}  \r\n");
fwrite($fsw,"			if( isset($"."_POST['page']) ) $"."page=$"."_POST['page'];  \r\n");
fwrite($fsw,"			else $"."page=1;   \r\n");
fwrite($fsw,"			if( isset($"."_POST['mode']) ) $"."mode=$"."_POST['mode']; \r\n");
fwrite($fsw,"			else $"."mode='';  \r\n");
fwrite($fsw,"			if( isset($"."_SESSION['kapp_userid']) ) $"."H_ID=$"."_SESSION['kapp_userid'];  \r\n");
fwrite($fsw,"			else $"."H_ID='';   \r\n");
fwrite($fsw,"	if( $"."mode != 'Tkher_write' ) {  \r\n");
fwrite($fsw,"		m_(\"Abnormal approach. \");  \r\n");
fwrite($fsw,"		$"."rungo = '".$runF1."';  \r\n");
fwrite($fsw,"		echo \"<script>window.open( '$"."rungo' , '_self', ''); </script>\";  \r\n");
fwrite($fsw,"	} else {  \r\n");
fwrite($fsw,"		$"."ff_nm = time() . '_';  \r\n");
fwrite($fsw,"		$"."f_path = './' . $"."ff_nm;   // dir add     \r\n"); 

	$ddd = "";
	$SQL = " INSERT " . $tab_enm . " SET ";
	$SQL = $SQL . "kapp_userid= '" . $H_ID . "' , ";
	$SQL = $SQL . "kapp_pg_code= '" . $pg_code . "', ";

	for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
				$typeX = $iftype[$j]; 
				$ddd = $list[$i];
				$fld = explode("|", $ddd); 
			if( $fld[1] != "seqno") {
					$nm = $fld[1]; 
					if( $typeX=='3' ) {	// 3:checkbox
						fwrite($fsw,"    $"."aa = @implode(\",\",$"."_POST[" .$fld[1]. "]);   \r\n");
						if( $i==0 )	$SQL = $SQL . $nm . " = '$"."aa' ";
						else	$SQL = $SQL . " , " .  $nm . " = '$"."aa' ";
					} else if( $typeX=='9' ) {	// 9:addfile

fwrite($fsw,"		                $". $nm . " = '';  \r\n");
fwrite($fsw,"						if ( $"."_FILES[\"".$nm."\"][\"error\"] > 0){   \r\n");
fwrite($fsw,"							echo \"Return Code: \" . $"."_FILES[\"".$nm."\"][\"error\"] . \"<br>\";   \r\n");
fwrite($fsw,"						} else {   \r\n");
fwrite($fsw,"		                    $". $nm . " = $" . "ff_nm . $"."_FILES[\"".$nm."\"][\"name\"];   \r\n");
fwrite($fsw,"							if ( file_exists( $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"]))   \r\n");
fwrite($fsw,"							{   \r\n");
fwrite($fsw,"								move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );  \r\n");
fwrite($fsw,"							} else {   \r\n");
fwrite($fsw,"								move_uploaded_file($"."_FILES[\"".$nm."\"][\"tmp_name\"], $"."f_path . $"."_FILES[\"".$nm."\"][\"name\"] );  \r\n");
fwrite($fsw,"								echo \"Stored in: \" . $"."f_path . $"."_FILES[\"" .$nm. "\"][\"name\"];   \r\n");
fwrite($fsw,"							}  \r\n");
fwrite($fsw,"						}  \r\n");

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
	fwrite($fsw,"			$"."relation_data = $"."_SESSION['relation_dataPG'];   \r\n");
	fwrite($fsw,"			$"."relation_type = $"."_SESSION['relation_typePG'];   \r\n");
	fwrite($fsw,"			if( $"."relation_data !='' ) {   \r\n");
	fwrite($fsw,"				$"."rdata = explode(\"^\", $"."relation_data);    \r\n");
	fwrite($fsw,"				$"."rtype = explode(\"^\", $"."relation_type);    \r\n");
	fwrite($fsw,"				$"."rt = explode(\"@\",    $"."rtype[0]);         \r\n");
	fwrite($fsw,"				for( $"."i=0; $"."i < count( $"."rdata); $"."i++ ){   \r\n");
	fwrite($fsw,"					if( isset( $"."rdata[$"."i]) && $"."rdata[$"."i] !='' && $"."rdata[$"."i] != 'undefined' ) {   \r\n");
	fwrite($fsw,"						relation_func( $"."rdata[$"."i], '".$pg_code."', $"."rt[$"."i] );   \r\n");
	fwrite($fsw,"					}   \r\n");
	fwrite($fsw,"				}   \r\n");
	fwrite($fsw,"			}		\r\n");
	fwrite($fsw,"			echo \"<script>window.open( '" . $runF1 . "' , '_self', ''); </script>\";   \r\n");
	fwrite($fsw,"		} else {   \r\n");
	fwrite($fsw,"			m_(\" insert ERROR  \" );	exit;    \r\n");
	fwrite($fsw,"		}//if   \r\n");
	fwrite($fsw,"	}   \r\n");// write end
	fwrite($fsw,"?> \r\n");
	fclose($fsw);

	include('./include/lib/pclzip.lib.php');
	$zf		= $pg_code . '_write.zip';
	$zff		= "./file/" . $H_ID."/" . $zf;
	$zipfile	= new PclZip($zff);
	$data			= array();
	$file_php 	= "./file/". $H_ID . "/" . $runF2;
	$fileR_php 	= "./file/". $H_ID. "/" . $runF2r;
	$Zdir			= "./file/" . $H_ID;
	$data = array( $file_php, $fileR_php );
	$create		= $zipfile -> create($data, PCLZIP_OPT_REMOVE_ALL_PATH);
	echo "<pre>";
	$write_run		= $pg_code . "_write.php";
?> 
<h3> Created OK! pg_code:<?php echo $runF2; ?> , Zip File:<?=$zf?> </h3>
<h3> <a href='<?=$zff?>' target=_blank>[ Down RUN:<?=$zf?> ]</a> </h3> 

<?php
if( $H_LEV > 1 ){
?>
	<h3> <a href='./file/<?=$H_ID?>/<?=$write_run?>' target='_blank'>
	[ Data_Write RUN:<?=$write_run?> ]</a> </h3>
<?php } ?>

<p>  Created OK! pg_code</p>
<p>To run the downloaded program, </p>
<p>Download the database table and upload it to the server you want to use.</p>
<p>To download a table, click Search Table and click the table name on the right screen, and there is a source download button at the bottom.</p>
</body>
</html>
