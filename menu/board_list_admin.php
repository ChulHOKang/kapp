<?php
	include_once('../tkher_start_necessary.php');
	error_reporting(E_ALL&~E_WARNING);
	//error_reporting(E_ERROR | E_WARNING | E_PARSE);
	//error_reporting(E_ALL^E_WARNING); 
	//$data = 1/0;

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	connect_count($host_script, $H_ID, 0, $referer);	// log count
	/* ------------------------------------------------------------------------
		board_list_admin.php : Board List
	------------------------------------------------------------------------ */
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;

	//$skin_type = $_REQUEST['skin_type'];
	if( !$H_ID || $H_LEV < 8 ) {
		m_("Admin Page!  :$H_LEV");
			$url = KAPP_URL_T_;	//$PHP_SELF;
			echo("<meta http-equiv='refresh' content='0; URL=$url'>");
			exit;
	}

?>
<html>
<head>

	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
	<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
	<meta name="robots" content="ALL">
	<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/project_.png">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>

<script src="//code.jquery.com/jquery.min.js"></script>
<script>

	$(function () {
	  $('table.floating-thead').each(function() {
		if( $(this).css('border-collapse') == 'collapse') {
		  $(this).css('border-collapse','separate').css('border-spacing',0);
		}
		$(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
	  });

	  $(window).scroll(function() {
		var scrollTop = $(window).scrollTop(),
		  scrollLeft = $(window).scrollLeft();
		$('table.floating-thead').each(function(i) {
		  var thead = $(this).find('thead:last'),
			clone = $(this).find('thead:first'),
			top = $(this).offset().top,
			bottom = top + $(this).height() - thead.height();

		  if( scrollTop < top || scrollTop > bottom ) {
			clone.hide();
			return true;
		  }
		  if( clone.is('visible') ) return true;
		  clone.find('th').each(function(i) {
			$(this).width( thead.find('th').eq(i).width() );
		  });
		  clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
		});
	  });
	});

</script>


<script>
	function openpage(url, infor){
			document.board_list_admin.infor.value=infor;
			document.board_list_admin.action=url;
			document.board_list_admin.target='_blank';
			document.board_list_admin.submit();
	}
	//----------- add 2021-06-09 ---
	function board_table(no){
		//if( confirm( "Are you sure  " + list_no ) == true )
		//{
			document.board_list_admin.mode.value='management_table';
			document.board_list_admin.no.value=no;
			document.board_list_admin.infor.value=no;
			//document.board_list_admin.list_no.value='';
			document.board_list_admin.action='update.php';
			document.board_list_admin.target='_blank';
			document.board_list_admin.submit();
		//} else {
		//	alert(' cancle ------ ');
		//}
	}
	function del_table(no,name,table_name, cnt){
		document.board_list_admin.mode='del_table';
		if( confirm( "Are you sure you want to delete the " + table_name +":" + name ) == true )
		{
			document.board_list_admin.mode.value='del_table';
			document.board_list_admin.no.value=no;
			document.board_list_admin.infor.value=no;
			document.board_list_admin.table_name.value=table_name;
			document.board_list_admin.action='query_ok.php';
			document.board_list_admin.submit();
		} else {
			alert(' cancle ------ ');
		}
	}
	function skin_func(v, infor, cnt){
		document.board_list_admin.infor.value=infor;
		document.board_list_admin.target='_blank';
		document.board_list_admin.action=v;
		document.board_list_admin.submit();
	}

</script>

<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/board.css" type="text/css">

</head>

<body>
<center>

<?php
$cur='B';
include "../menu_run.php";
$doc=$H_ID . time();
?>


  <table border="0" width="100%" height="393" bgcolor="#FFFFFF" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0">
	<H3 style='background-color:#006699;color:cyan;height:20px;padding:9px;'>&nbsp; Tkher Board List</H3>

	<!-- <input type='button' style='background-color:#006699;color:cyan;height:35px; ' value='Board Create' onclick="javascript:window.open('../adm/board_create_pop.php','_blank','');"> -->
	<input type='button' style='background-color:#006699;color:cyan;height:35px; ' value='Board Create' onclick="javascript:window.open('./board_list3.php','_blank','');">
    <tr>
      <td width="100%" height="57">
      <div align="left">
      <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="68%" id="AutoNumber2" height="15" bgcolor="#FFFFFF">

    <form name='board_list_admin' method="POST" action="">
            <input type='hidden' name='table_name'	value='aboard_infor'>
            <input type='hidden' name='mode'		value=''>
            <input type='hidden' name='infor'		value=''>
            <input type='hidden' name='skin_type'	value=''>
            <input type='hidden' name='no'			value=''>
            <input type='hidden' name='table_name'	value=''>
            <input type='hidden' name='url'			value='1'>
            <input type='hidden' name='skin_type'	value=''>
 <?php
	$query="select url from {$tkher['aboard_admin_table']}";
	$mq=sql_query($query);
	$rs=sql_fetch_array($mq );
	$url=$rs['url'];
?>
        <tr>
          <td width="1%" height="1" bgcolor="#006699">
          <p align="center" title='run file path. table:<?=$tkher['aboard_admin_table']?> '><font color="#FFFFFF">board path</font></td>
          <td width="100%" height="1" bgcolor="#F6F6F6">
          <input type="text" name="board_url" size="44" value='<?=KAPP_URL_T_?>/<?=$url?>/' readonly>
          </td>
        </tr>
	</form>
        <tr>
          <td width="24%" height="1"></td>
          <td width="76%" height="1">　</td>
        </tr>
        </table>
      </div>
      </td>
    </tr>

	<?php
		$where_ =" where make_id='". $cranim_id . "' ";
		$where_a =" ";
		if ( $cranim_lev > 2 ) {
			$query	= "SELECT * from {$tkher['aboard_infor_table']} " . $where_a . " order by no desc";
		} else if ( $cranim_lev == 2 || $cranim_lev == 4 ) {
			$query	= "SELECT * from {$tkher['aboard_infor_table']} " . $where_ . " order by no desc";
		} else if ( $cranim_lev == 6 ) {
			$query	= "SELECT * from {$tkher['aboard_infor_table']} " . $where_ . " order by no desc";
		} else {
			$query	= "SELECT * from {$tkher['aboard_infor_table']} " . $where_a . " order by no desc";
		}
		$mq		= sql_query($query);
		$tot		= sql_num_rows($mq);
	m_("cranim_lev: " . $cranim_lev . ", tot: " . $tot);
	?>
    <tr>
      <td width="100%" height="55" bgcolor="#FFFFFF">
	  <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="42">
<table class='floating-thead' width=100%>
<thead  width=100%>

		<tr>
            <TH align="center" bgcolor="#F6F6F6" height="21">User</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">NO</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">Read</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">Write</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21" title='file size'>file</TH>
            <!--<TH align="center" bgcolor="#F6F6F6" height="21">List-G</TH>-->
            <TH align="center" bgcolor="#F6F6F6" height="21">Table</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">Board Name</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">Board URL</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">SKIN</TH>
			<TH align="center" bgcolor="#F6F6F6" height="21">cnt</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">Date</TH>
            <TH align="center" bgcolor="#F6F6F6" height="21">Manager</TH>
          </tr>
<?php
		$cnt=0; $i=0;
		while( $mf = sql_fetch_array($mq)){
			m_("table_name: " . $mf['table_name']);
			$tab_nm = "aboard_". $mf['table_name'];
			$i++;
			if(!$cnt){$cnt=1;}
			$board_url		 = "index_bbs.php?infor=" . $mf['no'];
			//$board_url_adminI = $url . "index_bbs.php";
			$board_url_adminI = "index_bbs.php";
			$tab = $mf['table_name'];
			$query	= "SELECT * from aboard_" . $mf['table_name'] . " ";
			$mq1	= sql_query($query);
			$mn1	= sql_num_rows($mq1);
			if( $mf['grant_view'] == '1' ) $vx="Guest";
			else if ($mf['grant_view'] == '2' ) $vx="Member";
			else if ($mf['grant_view'] == '3' ) $vx="Only Me";
			else if ($mf['grant_view'] == '8' ) $vx="System";
			else $vx="Guest";
			if( $mf['grant_write'] == '1' ) $vW="Guest";
			else if ($mf['grant_write'] == '2' ) $vW="Member";
			else if ($mf['grant_write'] == '3' ) $vW="Only Me";
			else if ($mf['grant_write'] == '8' ) $vW="System";
			else $vW="Guest";

			$day = $mf['in_date'];
			$day = date( "Y-m-d", $mf['in_date']);
			$mf_no = $mf['no'];
?>
</thead>

<tbody width='100%'>

          <tr>
            <td width="1%" align="center" height="12"><?=$mf['make_id']?></td>
            <td width="2%" align="center" height="12">
				<a href="javascript:openpage('<?=$board_url_adminI?>', '<?=$mf_no?>')">
				<font color='#006699'><?=$mf_no?></font></a></td>
            <td width="3%" align="center" height="12"><?=$vx?></td>
            <td width="3%" align="center" height="12"><?=$vW?></td>
            <td width="3%" align="center" height="12"><?=$mf['fileup']?></td>

            <td width="7%" align="center" height="12"><a href="javascript:openpage('<?=$board_url_adminI?>', '<?=$mf_no?>');"><?=$tab_nm?></a></td>
            <td width="15%" align="center" height="12"><a href="javascript:openpage('<?=$board_url_adminI?>', '<?=$mf_no?>');"><?=$mf['name']?></a></td>
            <td width="20%" align="center" height="12"><a href="javascript:openpage('<?=$board_url_adminI?>', '<?=$mf_no?>');"><?=$board_url?></a></td>
            <td width="10%" align="center" height="12">
	<select id="sel_skin" name="sel_skin_<?=$cnt?>" onchange="skin_func(this.value, '<?=$mf_no?>', '<?=$cnt?>')" style='height:22px;background-color:black;color:yellow; border:1 solid black' title='board type' >
 <?php
 /*if( $mf['movie']=='1' ) $skin_tit='General type';
 else*/ 
 if( $mf['movie']=='5' ) $skin_tit='Standard type';
 else if( $mf['movie']=='3' ) $skin_tit='Memo type';
 else if( $mf['movie']=='4' ) $skin_tit='Image type';
 //else if( $mf['movie']=='5' ) $skin_tit='Daum Type';
 else $skin_tit='Error type';
 ?>
		<!-- <option value="index_bbs.php?infor=<?=$mf_no?>" selected > Select Skin</option> -->
		<option value="index_bbs.php?infor=<?=$mf_no?>" selected > <?=$skin_tit?> </option>
		<!-- <option value="board_data_list.php?infor=<?=$mf_no?>" >General type</option> -->
		<option value="index_bbs.php?infor=<?=$mf_no?>" >Standard type</option>
		<option value="index_bbs.php?infor=<?=$mf_no?>" >Memo type</option>
		<option value="index_bbs.php?infor=<?=$mf_no?>" >Image type</option>
	</select>
				</td>
			<td width="3%"  align=right><?=number_format( $mn1 )?></td>

			<td align="center"><?=$day?></td>

            <td width="10%" align="center" height="12">
				<!-- <a href='update.php?no=<?=$mf_no?>' target='_blank'>[Change]</a> -->
				<a href="javascript:board_table('<?=$mf_no?>')" title='board managememt' >[Change]</a>
				<a href="javascript:del_table('<?=$mf_no?>','<?=$mf['name']?>','<?=$mf['table_name']?>', '<?=$cnt?>')" title='Delete all data. Recovery is not possible. Please note!'><font color=red><b>[Del]</b></font></a>
			</td>
          </tr>
<?php
		$cnt++;
} // while
?>
          <tr>
            <td width="100%" align="center" colspan="10" bgcolor="#C0C0C0" height="1"></td>
          </tr>
		  </table>
		  </td>
    </tr>
    <tr>
      <td width="100%" height="12" bgcolor="#FFFFFF">
        <p align="left">　</td>
    </tr>
    <tr>
      <td width="100%" height="6" bgcolor="#FFFFFF">
        <p align="center">　</td>
    </tr>
    <tr>
      <td width="100%" height="68">
		<p align="center"></td>
    </tr>
</tbody>
</table>
</body>
</html>
