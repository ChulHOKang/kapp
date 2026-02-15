<?php
	include_once('./tkher_start_necessary.php');

	/* ----------------------------------------------------------------------
		tkher_php_programDN.php : 데이터 리스트 프로그램 다운로드, source create and download.
		- call	: tkher_program_data_writeDN.php : data insert program.
				: tkher_program_data_list.php : data list.
	---------------------------------------------------------------------- */
	$H_ID		= get_session("ss_mb_id"); 
	$H_LEV=$member['mb_level']; 
	if( !$H_ID or $H_LEV < 2 ) {
		m_("You need to login. ");exit;
		//echo "<script>window.open('/', '_top', '');</script>";exit;
	}
	$mode=$_POST['mode'];
	if($mode=='data_list') {
		if( $H_ID != 'dao' ) coin_minus_func($H_ID, 1000);
	}
	$table_item_array = $_POST['item_array'];
	$tab_enm    = $_POST['tab_enm'];

	$mid = $H_ID;
	$path = KAPP_PATH_T_ . "/file/"; 

	$pg_code 	= $_POST['pg_code'];
	$runF1 = "./" . $pg_code . "_run.php";
	$runF2 = "./" . $pg_code . "_write.php";
	$runF2R= "./" . $pg_code . "_write_r.php";
	$runF4 = $pg_code . "_view.php";

	$runfile = $path . $H_ID . "/" . $pg_code . "_run.php";
	$fsr = fopen("$runfile","w+");

	fwrite($fsr,"<?php \r\n");
	fwrite($fsr,"	$"."searchNameA = '".KAPP_URL_T_."';  \r\n");
	fwrite($fsr,"	if( strpos( $"."searchNameA, $"."_SERVER['HTTP_HOST']) == true) {    \r\n");
	fwrite($fsr,"       include '" . KAPP_PATH_T_ . "/tkher_start_necessary.php';		\r\n");
	fwrite($fsr,"	} else {    \r\n");
	fwrite($fsr,"       include './tkher_db_lib.php';		\r\n");
	fwrite($fsr,"		include './tkher_dbcon_Table.php';  \r\n");
	fwrite($fsr,"	}  \r\n");
	fwrite($fsr,"?> \r\n");
	fwrite($fsr,"<html> \r\n");

	fwrite($fsr,"<head> \r\n");
	fwrite($fsr,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" > \r\n");
	fwrite($fsr,"<TITLE>KAPP - no code webapp generator, No code app creation Made in ChulHo Kang : solpakan89@gmail.com</TITLE>  \r\n");
	fwrite($fsr,"<link rel='shortcut icon' href='./logo25a.jpg'> \r\n");
	fwrite($fsr,"<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> \r\n");
	fwrite($fsr,"<meta name='keywords' content='no code webapp generator, No code app creation, no code webapp create, web generator'> \r\n");
	fwrite($fsr,"<meta name='description' content='no code webapp generator, No code app creation, no code webapp create, web generator'> \r\n");
	fwrite($fsr,"<meta name='robots' content='ALL'> \r\n");
	fwrite($fsr,"</head> \r\n");

	fwrite($fsr,"<script src=\"//code.jquery.com/jquery.min.js\"></script> \r\n");
	fwrite($fsr,"<script> \r\n");
	fwrite($fsr,"$"."(function () { \r\n");

	fwrite($fsr,"	let timer; \r\n");
	fwrite($fsr,"	document.getElementById('tit_et').addEventListener('click', function(e) { \r\n");
	fwrite($fsr,"		clearTimeout(timer); \r\n");
	fwrite($fsr,"		timer = setTimeout(() => { \r\n");
	fwrite($fsr,"			Fhnm = e.target.innerText; \r\n");
	fwrite($fsr,"			Fenm = document.getElementById(Fhnm).value;         \r\n");
	fwrite($fsr,"			title_func(Fenm); \r\n");
	fwrite($fsr,"		}, 250); // Executes after waiting about 250ms - 약 250ms 대기 후 실행 \r\n");
	fwrite($fsr,"	}); \r\n");

	fwrite($fsr,"	document.getElementById('tit_et').addEventListener('dblclick', function(e) { \r\n");
	fwrite($fsr,"		clearTimeout(timer); // Remove last click timer - 마지막 클릭 타이머를 제거 \r\n");
	fwrite($fsr,"		Fhnm = e.target.innerText; \r\n");
	fwrite($fsr,"		Fenm = document.getElementById(Fhnm).value; \r\n");
	fwrite($fsr,"		title_wfunc(Fenm); \r\n");
	fwrite($fsr,"	}); \r\n");


	fwrite($fsr,"  $"."('table.listTableT').each(function() { \r\n");
	fwrite($fsr,"    if( $"."(this).css('border-collapse') == 'collapse') { \r\n");
	fwrite($fsr,"      $"."(this).css('border-collapse','separate').css('border-spacing',0); \r\n");
	fwrite($fsr,"    } \r\n");
	fwrite($fsr,"    $"."(this).prepend( $"."(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') ); \r\n");
	fwrite($fsr,"  }); \r\n");
	fwrite($fsr,"  $"."(window).scroll(function() { \r\n");
	fwrite($fsr,"    var scrollTop = $(window).scrollTop(), \r\n");
	fwrite($fsr,"      scrollLeft = $(window).scrollLeft(); \r\n");
	fwrite($fsr,"    $"."('table.listTableT').each(function(i) { \r\n");
	fwrite($fsr,"      var thead = $"."(this).find('thead:last'), \r\n");
	fwrite($fsr,"        clone = $"."(this).find('thead:first'), \r\n");
	fwrite($fsr,"        top = $"."(this).offset().top, \r\n");
	fwrite($fsr,"        bottom = top + $"."(this).height() - thead.height(); \r\n");
	fwrite($fsr,"      if( scrollTop < top || scrollTop > bottom ) { \r\n");
	fwrite($fsr,"        clone.hide(); \r\n");
	fwrite($fsr,"        return true; \r\n");
	fwrite($fsr,"      } \r\n");
	fwrite($fsr,"      if( clone.is('visible') ) return true; \r\n");
	fwrite($fsr,"      clone.find('th').each(function(i) { \r\n");
	fwrite($fsr,"        $"."(this).width( thead.find('th').eq(i).width() ); \r\n");
	fwrite($fsr,"      }); \r\n");
	fwrite($fsr,"      clone.css(\"margin-left\", -scrollLeft ).width( thead.width() ).show(); \r\n");
	fwrite($fsr,"    }); \r\n");
	fwrite($fsr,"  }); \r\n");
	fwrite($fsr,"}); \r\n");
	fwrite($fsr,"</script> \r\n");

	//fwrite($fsr,"<link rel=\"stylesheet\" href=\"".KAPP_URL_T_."/include/css/kapp_program_data_list.css\" type=\"text/css\" /> \r\n");
	fwrite($fsr,"<link rel='stylesheet' href='kapp_program_data_list.css' type='text/css' /> \r\n");


	fwrite($fsr," <script type='text/javascript' >                          \r\n");
	
	fwrite($fsr,"	function title_wfunc(fld_code){                       \r\n");
	fwrite($fsr,"		document.view_form.page.value = 1;                \r\n");
	fwrite($fsr,"		document.view_form.fld_code.value= fld_code;      \r\n");
	fwrite($fsr,"		document.view_form.fld_code_asc.value= 'desc';    \r\n");
	fwrite($fsr,"		document.view_form.mode.value='title_wfunc';      \r\n");
	fwrite($fsr,"		document.view_form.target='_self';                \r\n");
	fwrite($fsr,"		document.view_form.action='".$runF1."';           \r\n");
	fwrite($fsr,"		document.view_form.submit();                      \r\n");
	fwrite($fsr,"	} \r\n");

	fwrite($fsr,"	function title_func(fld_code){                        \r\n");
	fwrite($fsr,"		document.view_form.page.value = 1;                \r\n");
	fwrite($fsr,"		document.view_form.fld_code.value= fld_code;      \r\n");
	fwrite($fsr,"		document.view_form.fld_code_asc.value= 'asc';     \r\n");
	fwrite($fsr,"		document.view_form.mode.value='title_func';       \r\n");
	fwrite($fsr,"		document.view_form.target='_self';                \r\n");
	fwrite($fsr,"		document.view_form.action='".$runF1."';           \r\n");
	fwrite($fsr,"		document.view_form.submit();                      \r\n");
	fwrite($fsr,"	} \r\n");

	fwrite($fsr,"	function home_func($"."pg_code){                       \r\n");
	fwrite($fsr,"		document.view_form.page.value = 1;                \r\n");
	fwrite($fsr,"		document.view_form.mode.value='home_func';           \r\n");
	fwrite($fsr,"		document.view_form.action='".$runF1."';                \r\n");
	fwrite($fsr,"		document.view_form.submit();                         \r\n");
	fwrite($fsr,"	} \r\n");

	fwrite($fsr,"	function Change_Csel3(c_sel){ \r\n");
	fwrite($fsr,"		document.view_form.search_choice.value=c_sel; \r\n");
	fwrite($fsr,"		document.view_form.c_sel3.value=c_sel; \r\n");
	fwrite($fsr,"	} \r\n");

	fwrite($fsr,"	function Change_Csel2(c_sel){ \r\n");
	fwrite($fsr,"		var obj = document.getElementById(\"c_sel3\"); \r\n");
	fwrite($fsr,"		var c = c_sel.split(\"|\"); \r\n");
	fwrite($fsr,"		document.view_form.search_fld.value = c[0]; \r\n");
	fwrite($fsr,"		document.view_form.mode.value = 'search'; \r\n");
	fwrite($fsr,"	} \r\n");

	fwrite($fsr,"	function pg_record_view( seqno ){ \r\n");
	fwrite($fsr,"		document.view_form.seqno.value=seqno; \r\n");
	fwrite($fsr,"		document.view_form.action='".$runF4."?seqno=' + seqno;                \r\n");
	fwrite($fsr,"		document.view_form.submit(); \r\n");
	fwrite($fsr,"	} \r\n");

	fwrite($fsr,"	function table_record_write(mode){  \r\n");
	fwrite($fsr,"		document.view_form.mode.value = mode;  \r\n");
	fwrite($fsr,"		document.view_form.action='".$runF2."';                \r\n");
	fwrite($fsr,"		document.view_form.submit(); \r\n");
	fwrite($fsr,"	} \r\n");
	fwrite($fsr,"	function excel_down(){ \r\n");
	fwrite($fsr,"		document.view_form.mode.value = 'excel_create'; \r\n");

	fwrite($fsr,"		document.view_form.action='excel_download_user.php'; \r\n");
	fwrite($fsr,"		document.view_form.submit(); \r\n");
	fwrite($fsr,"	} \r\n");

	fwrite($fsr,"	function page_move($"."page){ \r\n");
	fwrite($fsr,"		document.view_form.page.value = $"."page; \r\n");
	fwrite($fsr,"		document.view_form.action='".$runF1."'; \r\n");
	fwrite($fsr,"		document.view_form.submit(); \r\n");
	fwrite($fsr,"	} \r\n");
	fwrite($fsr,"	function Change_line_cnt($"."line){ \r\n");
	fwrite($fsr,"		document.view_form.page.value = 1; \r\n");
	fwrite($fsr,"		document.view_form.line_cnt.value = $"."line; \r\n");
	fwrite($fsr,"		document.view_form.action='".$runF1."'; \r\n");
	fwrite($fsr,"		document.view_form.submit(); \r\n");
	fwrite($fsr,"	} \r\n");
	fwrite($fsr,"	function search_data(){  \r\n");
	fwrite($fsr,"			var c_sel = document.getElementById(\"c_sel\"); \r\n");
	fwrite($fsr,"			i = c_sel.selectedIndex; \r\n");
	fwrite($fsr,"			c_sel = c_sel.options[i].value; \r\n");
	fwrite($fsr,"			var c_sel3 = document.getElementById(\"c_sel3\"); \r\n");
	fwrite($fsr,"			i = c_sel3.selectedIndex; \r\n");
	fwrite($fsr,"			c_sel3 = c_sel3.options[i].value; \r\n");
	fwrite($fsr,"			document.view_form.mode.value = 'SR'; \r\n");
	fwrite($fsr,"			document.view_form.search_fld.value = c_sel; \r\n");
	fwrite($fsr,"			document.view_form.search_choice.value = c_sel3; \r\n");
	fwrite($fsr,"			document.view_form.page.value = 1; \r\n");
	fwrite($fsr,"			document.view_form.action = '".$runF1."' \r\n");
	fwrite($fsr,"			document.view_form.submit(); \r\n");
	fwrite($fsr,"	} \r\n");
	fwrite($fsr," </script> \r\n");

	fwrite($fsr,"<?php \r\n");

	fwrite($fsr,"			if( isset($"."_POST['page']) ) $"."page=$"."_POST['page'];  \r\n");
	fwrite($fsr,"			else $"."page=1;   \r\n");
	fwrite($fsr,"			if( isset($"."_POST['mode']) ) $"."mode=$"."_POST['mode']; \r\n");
	fwrite($fsr,"			else $"."mode='';  \r\n");
	fwrite($fsr,"			if( isset($"."_POST['fld_code']) ) $"."fld_code=$"."_POST['fld_code']; \r\n");
	fwrite($fsr,"			else $"."fld_code='';  \r\n");
	fwrite($fsr,"			if( isset($"."_POST['fld_code_asc']) ) $"."fld_code_asc=$"."_POST['fld_code_asc']; \r\n");
	fwrite($fsr,"			else $"."fld_code_asc='';  \r\n");

	fwrite($fsr,"			if( isset($"."_POST['c_sel']) ) $"."c_sel=$"."_POST['c_sel']; \r\n");
	fwrite($fsr,"			else $"."c_sel='';  \r\n");
	fwrite($fsr,"			if( isset($"."_POST['c_sel3']) ) $"."c_sel3=$"."_POST['c_sel3']; \r\n");
	fwrite($fsr,"			else $"."c_sel3='';  \r\n");
	fwrite($fsr,"			if( isset($"."_POST['search_fld']) ) $"."search_fld=$"."_POST['search_fld']; \r\n");
	fwrite($fsr,"			else $"."search_fld='';  \r\n");
	fwrite($fsr,"			if( isset($"."_POST['search_text']) ) $"."search_text=$"."_POST['search_text']; \r\n");
	fwrite($fsr,"			else $"."search_text='';  \r\n");

	fwrite($fsr,"			if( isset($"."_POST['search_choice']) ) $"."search_choice=$"."_POST['search_choice']; \r\n");
	fwrite($fsr,"			else $"."search_choice='';  \r\n");

	fwrite($fsr,"	$"."tab_enm	    = \"" .$tab_enm. "\"; \r\n");
	fwrite($fsr,"	$"."tab_hnm	    = \"" .$tab_hnm. "\"; \r\n");
	fwrite($fsr,"	$"."table_item_array	= \"" .$table_item_array. "\"; \r\n");

	$pg_code 	= $_POST['pg_code'];
	$sqlPG		= "SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$resultPG	= sql_query($sqlPG);
	$table10_pg = sql_num_rows($resultPG);
	if( $table10_pg > 0 )	 {
		$rsPG			= sql_fetch_array($resultPG);
		$item_array = $rsPG['item_array'];
		$if_data		= $rsPG['if_data'];
		$iftype		= $rsPG['if_type'];
		$tab_enm	= $rsPG['tab_enm'];
		$tab_hnm	= $rsPG['tab_hnm'];
		$item_cnt	= $rsPG['item_cnt'];
		$fld_cnt		= $rsPG['item_cnt'];
		$pg_name	= $rsPG['pg_name']; 
	} else {
			m_(" program name ERROR : table10_pg , pg_name:$pg_name , pg_code:$pg_code NO Found! ");// exit;
	}
	$fld_enm	= array();
	$fld_hnm	= array();
	$fld_type	= array();
	$fld_len	= array();
	$list		= array();
	$item		= array(); 
	$ddd		= "";
	$list		= explode("@", $item_array);
	for ( $i=0; isset($list[$i]) && $list[$i] != ""; $i++ ){ 
		$ddd			= $list[$i];
		$item			= explode("|", $ddd);
		$fld_enm[$i]	= $item[1];
		$fld_hnm[$i]	= $item[2];
		$fld_type[$i]	= $item[3];
		$fld_len[$i]	= $item[4];
		if( $i==0 && !$search_fld) $search_fld = $item[1];
	}
	$item_cnt	= $fld_cnt=$i;

fwrite($fsr,"			if( isset($"."_POST['line_cnt']) && $"."_POST['line_cnt'] !='' ) $"."line_cnt=$"."_POST['line_cnt']; \r\n");
fwrite($fsr,"			else $"."line_cnt=10;  \r\n");
fwrite($fsr,"			$"."page_num = 10;     \r\n");
fwrite($fsr," ?> \r\n");
fwrite($fsr,"  <body width=100%>                            \r\n");
fwrite($fsr,"  <center>                                           \r\n");
fwrite($fsr,"  			<br>                                       \r\n");
fwrite($fsr,"  			<div style='text-align:center;'>    \r\n");
fwrite($fsr,"  				<P onclick=\"javascript:home_func('" . $pg_code . "')\" class='HeadTitle03AX'>". $pg_name."</P>   \r\n");
fwrite($fsr,"  			</div>                   \r\n");
fwrite($fsr,"<?php       \r\n");
fwrite($fsr,"			$" . "tab_enm = '" . $tab_enm . "';   \r\n");
fwrite($fsr,"			$" ."SQL1 = \"SELECT * from " . $tab_enm . " \";   \r\n");

fwrite($fsr,"			if( $" ."mode=='SR' ){   \r\n");
fwrite($fsr,"				if( $"."search_choice == 'like') $"."SQL1 = $"."SQL1 . \" where $"."search_fld $"."search_choice '%$"."search_text%' \";   \r\n");
fwrite($fsr,"				else		$"."SQL1 = $"."SQL1 . \" where $"."search_fld $"."search_choice '$"."search_text' \";   \r\n");
fwrite($fsr,"			} else {   \r\n");
fwrite($fsr,"				if( $"."search_choice != '' && $"."search_text !='') {   \r\n");
fwrite($fsr,"					if( $"."search_choice == 'like' )	$"."SQL1 = $"."SQL1 . \" where $"."search_fld $"."search_choice '%$"."search_text%' \";    \r\n");
fwrite($fsr,"					else					$"."SQL1 = $"."SQL1 . \" where $"."search_fld $"."search_choice '$"."search_text' \";            \r\n");
fwrite($fsr,"				}      \r\n");
fwrite($fsr,"			}      \r\n");





fwrite($fsr,"			if ( ($"."result = sql_query( $"."SQL1 ) )==false ){   \r\n");
fwrite($fsr,"				m_(\" ERROR : Select $tab_enm  \");   \r\n");
fwrite($fsr,"				$"."total_count = 0;   \r\n");
fwrite($fsr,"			} else {   \r\n");
fwrite($fsr,"				$"."total_count = sql_num_rows($"."result);   \r\n");
fwrite($fsr,"				if( $"."total_count ) $"."total_page  = ceil($"."total_count / $"."line_cnt);    \r\n");
fwrite($fsr,"				else $"."total_page  =1;   \r\n");
fwrite($fsr,"				if ($"."page > 1) {   \r\n");
fwrite($fsr,"					$"."start = ($"."page - 1) * $"."line_cnt;    \r\n");
fwrite($fsr,"				} else {   \r\n");
fwrite($fsr,"					$"."page = 1;    \r\n");
fwrite($fsr,"					$"."start = 0;   \r\n");
fwrite($fsr,"				}   \r\n");
fwrite($fsr,"				$"."last = $"."line_cnt;    \r\n");
fwrite($fsr,"				if( $"."total_count < $"."last) $"."last = $"."total_count;   \r\n");
fwrite($fsr,"			}   \r\n");
fwrite($fsr,"?>               \r\n");
fwrite($fsr,"			<div style='width:99%;'>          \r\n");
fwrite($fsr,"				<div class='viewHeaderT'>          \r\n");
fwrite($fsr,"						<span>".$pg_name.": $pg_code &nbsp;&nbsp;&nbsp;&nbsp;Total: <strong><"."?=$"."total_count?> &nbsp;&nbsp;&nbsp;&nbsp; Page:<?=$"."page?></strong>          \r\n");
fwrite($fsr,"						&nbsp;&nbsp;&nbsp;&nbsp;          \r\n");
fwrite($fsr,"							<select id='line_cntS' name='line_cntS' onChange='Change_line_cnt(this.options[this.selectedIndex].value)' style='height:20;'>          \r\n");
fwrite($fsr,"								<option value='5'  <?php if($"."line_cnt=='5' )  echo \" selected \" ?> >5</option>         \r\n");
fwrite($fsr,"								<option value='10'  <?php if($"."line_cnt=='10' )  echo \" selected \" ?> >10</option>      \r\n");
fwrite($fsr,"								<option value='20'  <?php if($"."line_cnt=='20' )  echo \" selected \" ?> >20</option>      \r\n");
fwrite($fsr,"								<option value='30'  <?php if($"."line_cnt=='30' )  echo \" selected \" ?> >30</option>       \r\n");
fwrite($fsr,"								<option value='50'  <?php if($"."line_cnt=='50')   echo \" selected \" ?>  >50</option>      \r\n");
fwrite($fsr,"								<option value='100' <?php if($"."line_cnt=='100') echo \" selected \" ?>  >100</option>     \r\n");
fwrite($fsr,"							</select>          \r\n");
fwrite($fsr,"						</span>          \r\n");
//fwrite($fsr,"					<!-- <input type='button' value='Write' onclick=\"javascript:table_record_write('table_write');\" class='kapp_btn_bo02'> -->  \r\n");
fwrite($fsr,"				</div>          \r\n");
fwrite($fsr,"			</div>           \r\n");

fwrite($fsr,"					<form name='view_form' method='post' enctype='multipart/form-data' >    \r\n");
fwrite($fsr,"						<input type='hidden' name='mode'		value='<?=$"."mode?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='fld_code'	value='<?=$"."fld_code?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='fld_code_asc' value='<?=$"."fld_code_asc?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='seqno'		value='' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='page'		value='<?=$"."page?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='tab_enm'		value='<?=$"."tab_enm?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='tab_hnm'		value='<?=$"."tab_hnm?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='item_array'	value='<?=$"."item_array?>'>    \r\n");
fwrite($fsr,"						<input type='hidden' name='table_item_array'	value='".$table_item_array."'>    \r\n");
fwrite($fsr,"						<input type='hidden' name='item_cnt'	value='<?=$"."item_cnt?>'>    \r\n");
fwrite($fsr,"						<input type='hidden' name='list_no'		value='' />    \r\n");

fwrite($fsr,"						<input type='hidden' name='pg_code'		value='<?=$"."pg_code?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='search_fld'	value='<?=$"."search_fld?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='search_choice' value='<?=$"."search_choice?>' />    \r\n");
fwrite($fsr,"						<input type='hidden' name='line_cnt'	value='<?=$"."line_cnt?>' />    \r\n");

fwrite($fsr,"	<table class='listTableT' width=99%>   \r\n");
fwrite($fsr,"		<thead id='tit_et'>   \r\n");
fwrite($fsr,"			<tr>   \r\n");
fwrite($fsr,"				<th style='width:30px; height:100%px;text-align:center;font-weight:bold'>No</th>   \r\n");
 					for( $i=0; $i < $fld_cnt; $i++){ 
fwrite($fsr,"				<th title='Sort ".$fld_hnm[$i]." click or double click' >".$fld_hnm[$i]."</th>    \r\n");
fwrite($fsr,"			    <input type='hidden' id='".$fld_hnm[$i]."' name='".$fld_hnm[$i]."' value='".$fld_enm[$i]."' > \r\n");
 					} 
fwrite($fsr,"			</tr>   			\r\n");
fwrite($fsr,"		</thead>   				\r\n");
fwrite($fsr,"		<tbody width=100%>   	\r\n");
fwrite($fsr,"<?php    \r\n");

fwrite($fsr," 			$"."SQL_limit	= \"  limit $"."start , $"."last; \";  \r\n");
fwrite($fsr,"			if( $"."fld_code!='' ) $"."OrderBy = \" ORDER BY $"."fld_code $"."fld_code_asc \";         \r\n");
fwrite($fsr,"			else $"."OrderBy	= \" ORDER BY seqno desc \";     \r\n");
fwrite($fsr,"			$"."SQL1 = $"."SQL1 . $"."OrderBy;       \r\n");
fwrite($fsr,"			$"."SQL1 = $"."SQL1 . $"."SQL_limit;     \r\n");

fwrite($fsr,"			if( ($"."result = sql_query( $"."SQL1 ) )!=false )    \r\n");
fwrite($fsr,"			{    \r\n");
//fwrite($fsr,"			} else {    \r\n");
fwrite($fsr,"				if( $"."page > 1 ) $"."no=($"."page -1) * $"."line_cnt;    \r\n");
fwrite($fsr,"				else $"."no=0;    \r\n");
fwrite($fsr,"				while( $"."row = sql_fetch_array($"."result)  ) {    \r\n");
fwrite($fsr,"					$"."no++;    \r\n");
fwrite($fsr,"?>    \r\n");
fwrite($fsr,"					<tr>    \r\n");
fwrite($fsr,"						<td style='width:30px; height:100%px;text-align:center'>    \r\n");
fwrite($fsr,"						 <a href=\"javascript:pg_record_view('<?=$"."row[\"seqno\"]?>');\" ><?=$"."no?></a></td>    \r\n");

 						for( $i=0; $i < $fld_cnt; $i++){ 
 							$fff = $fld_enm[$i]; 
							if( $fld_type[$i] =='INT' ){
fwrite($fsr,"				 <?php $"."num = number_format( $"."row['".$fff."'] );  ?> \r\n"); //$num = number_format( $row[$fff] );
fwrite($fsr,"				<td class=cell03><a href=\"javascript:pg_record_view('<?=$"."row[\"seqno\"]?>');\" ><?=$"."num?></a></td>     \r\n");
							} else {
fwrite($fsr,"				<td class=cell03><a href=\"javascript:pg_record_view('<?=$"."row[\"seqno\"]?>');\" ><?=$"."row['".$fff."']?></a></td>     \r\n");
							}
 						} 
fwrite($fsr,"					</tr>    \r\n");
fwrite($fsr,"<?php    \r\n");
fwrite($fsr,"				}	//while    \r\n");
fwrite($fsr,"			}    \r\n");
fwrite($fsr,"?>    \r\n");
fwrite($fsr,"		</tbody>    \r\n");
fwrite($fsr,"	</table>				    \r\n");
fwrite($fsr,"			<div class=\"fl\">    \r\n");
fwrite($fsr,"					<table>    \r\n");
fwrite($fsr,"						<tr>    \r\n");
fwrite($fsr,"						<td>    \r\n");
fwrite($fsr,"						<select id='c_sel' name='c_sel' onChange='Change_Csel2(this.options[this.selectedIndex].value)' style='height:30;' >    \r\n");

 					for( $i=0; $i < $fld_cnt; $i++ ){ 
 						$fff		= $fld_enm[$i]; 
 						$hhh		= $fld_hnm[$i]; 
fwrite($fsr,"						  <option value='".$fff."'     \r\n");
fwrite($fsr,"						<?php if($"."search_fld == '".$fff."') echo \" selected \";?> >".$hhh."</option>\";    \r\n");
 					} // for

fwrite($fsr,"						</select></td>    \r\n");
fwrite($fsr,"						<td>    \r\n");
fwrite($fsr,"						<select id='c_sel3' name='c_sel3' onChange='Change_Csel3(this.options[this.selectedIndex].value)' style='height:30;'>    \r\n");
fwrite($fsr,"							<option value='like' <?php if($"."search_choice=='like' ) echo \" selected \" ?> >like</option>    \r\n");
fwrite($fsr,"							<option value='=' <?php if($"."search_choice=='=' ) echo \" selected \" ?> >=</option>    \r\n");
fwrite($fsr,"							<option value='>' <?php if($"."search_choice=='>') echo \" selected\" ?> >></option>    \r\n");
fwrite($fsr,"							<option value='<' <?php if($"."search_choice=='<') echo \" selected\" ?> ><</option>    \r\n");
fwrite($fsr,"						</select>    \r\n");
fwrite($fsr,"						</td>    \r\n");

fwrite($fsr,"						<td><input type='text' name='search_text' id='search_text'  value='<?=$"."search_text?>' style='height:30;' /></td>    \r\n");
fwrite($fsr,"						<td><input type='button' value='Search' onclick=\"javascript:search_data();\" class='kapp_btn_bo02'></td>    \r\n");
fwrite($fsr,"						<td title='tkher_program_data_listDN'>    \r\n");
fwrite($fsr,"							<input type='button' value='Write' onclick=\"javascript:table_record_write('table_pg70_write');\" class='kapp_btn_bo02'></td>    \r\n");
fwrite($fsr,"						<td title='Create and download the data as an Excel file.'>    \r\n");
fwrite($fsr,"							<input type='button' value='Excel Down' onclick=\"javascript:excel_down();\" class='kapp_btn_bo02'></td>    \r\n");

fwrite($fsr,"					</tr>    \r\n");
fwrite($fsr,"					</table>    \r\n");
fwrite($fsr,"			</form>    \r\n");
fwrite($fsr,"			</div>     \r\n");
fwrite($fsr,"<?php    \r\n");
fwrite($fsr,"			pagingA(\"".$pg_code."_run.php\",$"."total_count,$"."page,$"."line_cnt );      \r\n");
fwrite($fsr,"?>     \r\n");
fwrite($fsr,"</body>    \r\n");
fwrite($fsr,"</html>    \r\n");
fclose($fsr);

include('./include/lib/pclzip.lib.php');
$zf		= $pg_code . '_run.zip';
$zff		= "./file/" . $H_ID . "/" . $zf;
$zipfile	= new PclZip($zff);
$data		= array();
$list_run		= $pg_code . "_run.php";
$file_php= "./file/" . $H_ID. "/" . $list_run;
$data		= array( $file_php );
$create	= $zipfile -> create($data, PCLZIP_OPT_REMOVE_ALL_PATH); 
echo "<pre>";
?> 
			<h3> Created OK! pg_code:<?php echo $runF1; ?> , Zip File:<?=$zf?> </h3>
			<h3> <a href='<?=$zff?>' target=_blank>[ Down RUN:<?=$zf?> ]</a> </h3>  
<?php
if ( $H_LEV > 1 ){
?>
		<h3> <a href='./file/<?=$H_ID?>/<?=$list_run?>' target=_blank>[ Data_List RUN:<?=$list_run?> ]</a> </h3> 
<?php } ?>
<p>To run the downloaded program, </p>
<p>Download the database table and upload it to the server you want to use.</p>
<p>To download a table, click Search Table and click the table name on the right screen, and there is a source download button at the bottom.</p>
</body>
</html>
 