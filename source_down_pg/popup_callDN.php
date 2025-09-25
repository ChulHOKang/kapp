<?php
	include_once('./tkher_db_lib.php'); 
	/*
		소스를 생성후 실행할때 필요함. : 2021-04-13 수정보완.
		$tkher_iurl : tkher_db_lib.php 에서 선언됨.
	*/
	/*
	$searchNameA = 'http://appgenerator.net';
	$searchNameB = 'https://appgenerator.net';
	if( strpos($tkher_iurl, $searchNameA) !== false ) { 
		include './tkher_dbconX.php';		
	} else if( strpos($tkher_iurl, $searchNameB) !== false ) { 
		include './tkher_dbconX.php';		//<<<<-----------
	} else {
		//include './tkher_dbcon.php';// DB 정보 설치할떄
		include './tkher_dbcon_Table.php';// DB 정보를 공백으로 선함. 사용자 서버에서 설치할떄
		                            // tkher_dbcon_create.php에서 생성함. 중요.
	}*/
		include './tkher_dbcon_Table.php';// DB 정보를 공백으로 선함. 사용자 서버에서 설치할떄


	/* ------------------------------------------------------------------------------------------
	*   popup_callDN.php : 컬럼타입 : 13 : 팝업창 
	*	table_item_run.php, table_pg_write.php , table_item_run70.php에서 리턴.:중요!2018-10-24
	---------------------------------------------------------------------------- */
    /*
	$iftype_db		= $_REQUEST[if_typePG];
	$ifdata_db		= $_REQUEST[if_dataPG];
	$if_dataPG		= $_REQUEST[if_dataPG];
	$pop_dataPG	= $_REQUEST[pop_dataPG];
	if( !$iftype_db ) {
		$iftype_db		= $_SESSION[iftype_db];
		$ifdata_db		= $_SESSION[ifdata_db];
		$if_dataPG		= $_SESSION[if_dataPG];	//iftype_db X
		$pop_dataPG	= $_SESSION[pop_dataPG];
	}*/
	//----------------------------------------------
	$relation_dataPG	= $_SESSION['relation_dataPG'];  // add 2020-11
	$pop_dataPG	= $_SESSION['pop_dataPG']; 
	$if_dataPG	= $_SESSION['if_dataPG']; 
	$ifdata_db	= $_SESSION['if_dataPG']; 
	$if_typePG	= $_SESSION['if_typePG']; 
	$iftype_db	= $_SESSION['if_typePG']; 
    //-------------------------------------------

	//$fld_session	= $_SESSION['fld_session']; 
	$fld_session	= $_REQUEST['fld_session']; 
	//m_("fld_session: " . $fld_session);

	$idata = explode("|", $ifdata_db);
	$itype = explode("|", $iftype_db);
	$it = (int)$fld_session+1;

	$pop_if = $itype[$it];
	$pop_db = $idata[$it];
	//m_("pop_db: ".$pop_db);

	$tdata = explode(":", $pop_db);

	$tab_enmP = $tdata[0];
	$tab_hnmP = $tdata[1];
	$pdataA = explode("^", $pop_dataPG);
	//$pdata = explode("@", $pdataA[0]);
	//$pdata = explode("@", $pop_dataPG);
	$pdata		= explode("@", $pdataA[$it]);  // 2022-02-19 

	$mpxcol = array();
	$mwxcol = array();

	$movecol = explode("$", $pdata[0]);

	for( $i=0, $j=1; $movecol[$j] != ""; $i++ , $j++) {
			$mmcol	= explode("|", $movecol[$j]);	 // j=1부터 데이터가있다. 중요.
			$mp0		= $mmcol[0];
			$mpcol	= explode(":", $mp0 );	 // 0:// pop 컬럼, 
			array_push( $mpxcol, $mpcol );	
			$mp1		= $mmcol[1];
			$mwcol	= explode(":", $mp1 );	 // 0:// pop 컬럼, 
			array_push( $mwxcol, $mwcol );	// win 컬럼.
	}
	$pxcol = array();
	for( $i=0, $j=1; $pdata[$j] != ""; $i++, $j++ ) {
			$pcol = explode(":", $pdata[$j]);	 // j=1부터 팝업에 사용될 컬럼 정보. 중요.
			array_push($pxcol, $pcol);	 	
	}
	for( $i=0; $pxcol[$i][0] != ""; $i++ ) {	// 팝업창 컬럼 출력 샘플....
			$fe=$pxcol[$i][0];	
			$fh=$pxcol[$i][1]; // m_("fe: ". $fe . ", fh: " . $fh);
	}
?>
<script	language="JavaScript">
<!--
	function call_pg_select( pp, pw, pd) {
		//alert('pp : ' + pp + ' pw : ' + pw + ' pd : ' + pd); 
		//pp : fld_1:상가코드|fld_2:상가명|fld_3:대표자|fld_4:이메일|fld_5:연락처|fld_6:우편번호|fld_7:주소|fld_8:상세주소|fld_9:등록일자|fld_10:상가좌표X|fld_11:상가좌표Y|fld_12:상가좌표Z|fld_13:평일|fld_14:토일요일|fld_15:휴무일|fld_18:테마| 
		//pw : fld_1:상가코드|fld_2:상가명|fld_3:대표자|fld_4:이메일|fld_5:연락처|fld_6:우편번호|fld_7:주소|fld_8:상세주소|fld_9:등록일자|fld_10:상가좌표X|fld_11:상가좌표Y|fld_12:상가좌표Z|fld_13:평일|fld_14:토일요일|fld_15:휴무일|fld_18:테마| 
		//pd : shop001:슈퍼맨 과일야채:권예준:kyj123@kyj123.com:010-5110-5614:49356:부산 사하구 사하로198번길 2:104호:2023-08-24 14:35:00:22.0738:0.7779:2.7341:11:00~18:00:11:00~18:00:매주 일요일/공휴일:t001:
		p1 = pp.split("|");
		p2 = pw.split("|");
		p3 = pd.split("|");
//		p3 = pd.split(":");
		for( i=0; p1[i] != "";  i++){
			pk		= p1[i].split(":");
			$p0	= pk[0];
			$p1	= pk[1];
			pg		= p2[i].split(":");
			$pg0	= pg[0];
			$pg1	= pg[1];
			$dd0	= p3[i];
			//alert('i:' + i + ' ,  pg0:' + $pg0 +  ' , dd0:'+$dd0); //i:8 ,  pg0:fld_9 , dd0:2023-08-24 14
			//2023-08-24 14:35:00
			//i:0 ,  p0:fld_1 ,  p1:상품명
			//i:1 ,  p0:fld_4 ,  p1:판매가
			eval ( "parent.window.opener.document.makeform."+$pg0+".value = $dd0" );
		}
		window.close();
		return false;
	}

	function doSubmit()
	{
		if ( document.popupform.sel_g_name.value == "") {
			alert(" You did not select a search column.");// \n 검색 컬럼을 선택 않았습니다. 
			document.popupform.search_data.focus();
			return false;
		}
		if (document.popupform.search_data.value == "") {
			alert(" You have not entered any search terms.");// \n 검색어를 입력 않았습니다. 
			document.popupform.search_data.focus();
			return false;
		}
			document.popupform.submit();
	}

	function change_g_name_func(g_name) {
		//if(g_name) location.href="pg_list_select.php?g_name="+g_name;
		//else location.href="pg_list_select.php";
		//document.popupform.sel_g_name.value = g_name;
		//document.popupform.submit();
	}
-->
</script>

<html>
<head>
<title>검색하기</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0' bgcolor='black'>
<table width="710" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><font color='yellow'>Table : <?=$tab_hnmP?></tr>
<tr>
  <td width="600" colspan='3'>
	<form method="post" action="popup_call.php" name="popupform">	
		<input type="hidden" name="if_dataPG"	value='<?=$if_dataPG?>' >
		<input type="hidden" name="pop_dataPG" value='<?=$pop_dataPG?>' >
		<input type='hidden'  name='g_name'>
		<table width="750" border="0" cellspacing="0" cellpadding="0" height="25">
			<tr>
					<td  rowspan="1" width="330" align="right" height="25" valign='center'><font color='yellow'>&nbsp; Column :
						<select name='sel_g_name' onchange="change_g_name_func(this.value);" style="HEIGHT: 20px">
<?php

/* 이동식에 사용된 컬럼만 검색 컬럼으로 적용할때...
							for( $i=0; $mpxcol[$i] != ""; $i++ ) {
									$fp0=$mpxcol[$i];
									$fw0=$mwxcol[$i];
									$fpe=$fp0[0];	// 팝업창 컬럼.
									$fph=$fp0[1];
									$fwe=$fw0[0]; // 프로그램 컬럼.
									$fwh=$fw0[1];
									//my_msg("$i:move column mpxcol : $fpe:$fph , $fwe:$fwh ");	 //0:move column mpxcol : fld_1:상품명 , fld_1:상품 
*/

							for( $i=0; $pxcol[$i][0] != ""; $i++ ) {
									$fpe=$pxcol[$i][0];	
									$fph=$pxcol[$i][1];
?>
										<option value='<?=$fpe?>' <?php if( $fpe ==$_POST['sel_g_name']) echo "selected"; ?> ><?=$fph?></option>
<?php
							}
?>
						</select>
					</td>

					<td rowspan="2"  align="left" height="30">
						<font color='yellow'>&nbsp;<input type="text" name="search_data" size="20" maxlength="50" value='<?=$search_data?>'>
						<input type='button' value='Confirm' onclick='doSubmit()'>
						</td>
			</tr>
		</table>
	</form>
  </td>
</tr>
</table>
<table width="650" border="1" cellspacing="0" cellpadding="0">
	<tr align='center'>
<?php
			for ( $i=0; $pxcol[$i][1]!=""; $i++) {
				$t = $pxcol[$i][1];	// 팝업창 컬럼 타이틀 부분......
?>
				<td><font color='yellow' size=3><?=$t?></td> 
<?php
			}
?>
				<td><font color='yellow'>Select</td>
	</tr>
<?php
	if ( $_POST['sel_g_name'] != "" && $_POST['search_data'] != "") {
		$sf	= $_POST['sel_g_name'];
		$sd	= $_POST['search_data'];
		$w		= " WHERE ( ".$_POST['sel_g_name']." like '%".$_POST['search_data']."%' ) ";
		$ls		= " SELECT * FROM ". $tab_enmP . $w;
	}
	else $ls	= "SELECT * FROM ". $tab_enmP . " ";
	$result	= sql_query(  $ls );
	while ( $rs = sql_fetch_array( $result ) ) {
?>
			<tr valign="middle" align='center'>
<?php
				$pw		= "";
				$datap	= "";
				$fieldp	= "";
				$fieldw	= "";
				$kkk		= 1;
			for ( $i=0; $pxcol[$i][0] != ""; $i++) {
				$pf = $pxcol[$i][0];
				$pd = $rs[$pf];		// data
				for( $k=0; $mpxcol[$k] != ""; $k++ ) {	// 데이터 출력 컬럼 
						$fp0=$mpxcol[$k];	// 이동식 팝업창 컬럼
						$fw0		= $mwxcol[$k];	// 이동식 프로그램 화면 컬럼.
						$ppc		= $fp0[0];
						$rdata	= $rs[$ppc];
						if( $pf == $fp0[0] && $kkk==1) {	 // 한번만 체크하면된다.
								$pp		= $fp0[0] . ":" .$fp0[1];
								$pw		= $fw0[0] . ":" .$fw0[1];
//								$datap	= $datap . $rdata . ":";
								$datap	= $datap . $rdata . "|";
								$fieldp	= $fieldp . $pp . "|";
								$fieldw	= $fieldw . $pw . "|";
						}
				}
?>
			  <td height='15'><font color='yellow' size='2'><?=$pd?><br></td>
<?php
		  }//for
				if($kkk==1) {	// 첫번째 라인 출력시  컬럼 전체를 체크하므로 한번만 체크하면된다.
					//my_msg("$i: pf:$pf, w:$fieldw, p:$fieldp, d:$datap");
					//6: pf:fld_6, w:fld_1:상품|fld_3:단가|, p:fld_1:상품명|fld_4:판매가|fld_1:상품명|fld_4:판매가|fld_1:상품명|fld_4:판매가|, d:패드:900000:
					$kkk=0;
				}
?>
			  <td height=15>
						<input type='button' value='Select' onclick="javascript:call_pg_select('<?=$fieldp?>','<?=$fieldw?>','<?=$datap?>' )">
			  </td>
	</tr>
<?php
	}	//Loop while
?>
  </td>
</tr>
<tr align="center">
  <td height="30" width="550" colspan='<?=$i+1?>'><a href="javascript:self.close()"><font color='cyan' size='3'>[ * CLOSE! * ]</a></td>
</tr>
</table>
</body>
</html>
