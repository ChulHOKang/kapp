<?php
	include_once('./tkher_start_necessary.php');
	/*$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	if (!$from_session_id) {
		my_msg("Login please! ");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}*/
	/* ------------------------------------------------------------------------------------------
	*      컬럼타입 : 13 : 팝업창 
	*		table_item_run.php, table_pg_write.php , table_item_run70.php에서 리턴. : 중요! --- 2018-10-24
	------------------------------------------------------------------------------------------ */
	// 컬럼 순서를 조정해도 이상없이 작동한다.  table_pg_write.php , table_item_run70.php에서 리턴. : 중요! --- 2018-10-24
	if( isset($_POST['sel_g_name']) ) $sel_g_name = $_POST['sel_g_name'];
	else	$sel_g_name	= "";
	if( isset($_POST['search_data']) ) $search_data	= $_POST['search_data'];
	else	$search_data	= "";

	if( isset($_REQUEST['if_typePG']) ) $iftype_db = $_REQUEST['if_typePG'];
	else $iftype_db = "";

	if( isset($_REQUEST['if_dataPG']) ) $ifdata_db = $_REQUEST['if_dataPG'];
	else $ifdata_db = "";

	if( isset($_POST['if_dataPG']) ) $if_dataPG = $_POST['if_dataPG'];
	else $if_dataPG = "";

	if( isset($_REQUEST['_POST']) ) $pop_dataPG = $_POST['pop_dataPG'];
	else $pop_dataPG = "";

//	if( !$iftype_db ) {
	if( !$iftype_db || $iftype_db == '') {
		$iftype_db		= $_SESSION["iftype_db"];
		$ifdata_db		= $_SESSION["ifdata_db"];
		$if_dataPG		= $_SESSION["if_dataPG"];	//iftype_db X
		$pop_dataPG		= $_SESSION["pop_dataPG"];  //$_SESSION['pop_dataPG']= $pop_dataPG;
		//m_("iftype_db : $iftype_db, pop_dataPG:$pop_dataPG");
		//iftype_db : |13|1|5|||, pop_dataPG:^$fld_1:fld1|fld_1:fld1$fld_4:fld4|fld_4:fld4$fld_5:fld5|fld_5:fld5@fld_1:fld1@fld_2:fld2@fld_3:fld3@fld_4:fld4@fld_5:fld5@^^^^^
	}
	if( isset($_POST['fld_session']) ){
		$fld_session = $_POST['fld_session'];
	} else if( isset($_REQUEST['fld_session']) ){
		$fld_session= $_REQUEST["fld_session"];	
	} else $fld_session= "";

	$idata		= explode("|", $ifdata_db);
	$itype		= explode("|", $iftype_db);
	$pdataA		= explode("^", $pop_dataPG);
	$it = (int)$fld_session+1;
	$pop_if		= $itype[$it];
	$pop_db		= $idata[$it];
	$tdata		= explode(":", $pop_db);
	$tab_enm	= $tdata[0];
	$tab_hnm	= $tdata[1];

	$pdata		= explode("@", $pdataA[$it]);
	$mpxcol		= array();
	$mwxcol		= array();
	$movecol	= explode("$", $pdata[0]);
	for( $i=0, $j=1; isset($movecol[$j]) && $movecol[$j] != ""; $i++ , $j++) {
		$mmcol	= explode("|", $movecol[$j]);	 // j=1부터 데이터가있다. 중요.
		$mp0		= $mmcol[0];
		$mpcol	= explode(":", $mp0 );
		array_push( $mpxcol, $mpcol );	
		$mp1		= $mmcol[1];
		$mwcol	= explode(":", $mp1 );
		array_push( $mwxcol, $mwcol );	
	}
	$pxcol = array();
	for( $i=0, $j=1; $pdata[$j] != ""; $i++, $j++ ) {
			$pcol = explode(":", $pdata[$j]);	 // j=1부터 팝업에 사용될 컬럼 정보. 중요.
			array_push($pxcol, $pcol);	 	
	}
	for( $i=0; $pxcol[$i][0] != ""; $i++ ) {	// 팝업창 컬럼 출력 샘플....
			$fe=$pxcol[$i][0];	
			$fh=$pxcol[$i][1];
	}
?>
<script	language="JavaScript">
<!--
	function call_pg_select( pp, pw, pd) {
		p1 = pp.split("|");
		p2 = pw.split("|");
		p3 = pd.split(":");
		for( i=0; p1[i] !== "";  i++){
			pk		= p1[i].split(":");
			$p0	= pk[0];
			$p1	= pk[1];
			pg		= p2[i].split(":");
			$pg0	= pg[0];
			$pg1	= pg[1];
			$dd0	= p3[i];
			eval ( "parent.window.opener.document.makeform."+$pg0+".value = $dd0" );
		}
		window.close(); // 팝업창이 닫히지않는것은 컬럼속성이 checkbox로 설정되어 있었기때문이다. 컬럼 이동식이에는 속성을 정의 하지 마라.
		return;
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
<title>popup window run popup_call</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0' bgcolor='black'>
<table width="710" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><font color='yellow'>Table : <?=$tab_hnm?></tr>
<tr>
  <td width="600" colspan='3'>
	<form method="post" action="popup_call.php" name="popupform">	
		<input type="hidden" name="if_dataPG"	value='<?=$if_dataPG?>' >
		<input type="hidden" name="pop_dataPG" value='<?=$pop_dataPG?>' >
		<input type='hidden'  name='g_name'>
		<input type='hidden' name='fld_session' value='<?=$fld_session?>'>
		<table width="750" border="0" cellspacing="0" cellpadding="0" height="25">
		<tr>
			<td rowspan="1" width="330" align="right" height="25" valign='center'><font color='yellow'>
				&nbsp; Column :
						<select name='sel_g_name' onchange="change_g_name_func(this.value);" style="HEIGHT: 20px" title='change name '>
<?php
			for( $i=0; isset($pxcol[$i][0]) && $pxcol[$i][0] != ""; $i++ ) {
						$fpe=$pxcol[$i][0];	
						$fph=$pxcol[$i][1];
?>						<option value='<?=$fpe?>' <?php if( $fpe ==$sel_g_name) echo "selected"; ?> ><?=$fph?></option>
<?php
			}
?>
						</select>
					</td>
					<td rowspan="2" align="left" height="30"><font color='yellow'>
						<input type="text" name="search_data" size="20" maxlength="50" value='<?=$search_data?>'>
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
			for ( $i=0; isset($pxcol[$i][1]) && $pxcol[$i][1]!=""; $i++) {
				$t = $pxcol[$i][1];	// 팝업창 컬럼 타이틀 부분......
?>
				<td><font color='yellow' size='3'><?=$t?></td> 
<?php
			}
?>
				<td><font color='yellow'>Select</td>
	</tr>
<?php
	if ( $sel_g_name != "" && $search_data != "") {
		//$sel_g_name	= $_POST['sel_g_name'];
		//$search_data	= $_POST['search_data'];
		$w		= " WHERE ( ".$sel_g_name." like '%".$search_data."%' ) ";
		$ls		= "SELECT * FROM ". $tab_enm . $w;
	}
	else $ls	= "SELECT * FROM ". $tab_enm . " ";
	echo "sql:".$ls;//sql:SELECT * FROM dao_1656036131, SELECT * FROM WHERE ( fld_4 like '%정보%' )
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
			for ( $i=0; isset($pxcol[$i][0]) && $pxcol[$i][0] != ""; $i++) {
				$pf = $pxcol[$i][0];
				$pd = $rs[$pf];		// data
				for( $k=0; isset($mpxcol[$k]) && $mpxcol[$k] != ""; $k++ ) {	// 데이터 출력 컬럼 
						$fp0=$mpxcol[$k];				// 이동식 팝업창 컬럼
						$fw0		= $mwxcol[$k];		// 이동식 프로그램 화면 컬럼.
						$ppc		= $fp0[0];
						$rdata	= $rs[$ppc];
						if( $pf == $fp0[0] && $kkk==1) {	 // 한번만 체크하면된다.
								$pp		= $fp0[0] . ":" .$fp0[1];
								$pw		= $fw0[0] . ":" .$fw0[1];
								$datap	= $datap . $rdata . ":";
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
			  <td height='15'>
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
