<?php
	include_once('./tkher_start_necessary.php');

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	connect_count($host_script, $H_ID, 0, $referer);	// log count
	/* ------------------------------------------------------------------------
		board_list_admin.php : Board List
	------------------------------------------------------------------------ */
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;

	$skin_type = $_REQUEST[skin_type];
	if( !$H_ID || $H_LEV < 2 ) {
		//m_("Login Please! H_LEV:$H_LEV");
		//	$url='/t/';	//$PHP_SELF;
		//	echo("<meta http-equiv='refresh' content='0; URL=$url'>");
		//	exit;
	}

?>
<html>

<head>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board - App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="/logo/land25.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

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

<link rel="stylesheet" href="./include/css/board.css" type="text/css">

</head>

<body>
<center>

<?php
$cur='B';
include "./menu_run.php";
$doc=$H_ID . time();
?>


    <form name='board_list_admin' method="POST" action="">
            <input type='hidden' name='table_name'	value='aboard_infor'>
            <input type='hidden' name='mode'		value=''>
            <input type='hidden' name='infor'		value=''>
            <input type='hidden' name='skin_type'	value=''>
            <input type='hidden' name='no'			value=''>
            <input type='hidden' name='table_name'	value=''>
            <input type='hidden' name='url'			value='1'>
            <input type='hidden' name='skin_type'	value=''>
	</form>

  <!-- <table border="0" width="100%" height="393" bgcolor="#FFFFFF" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0"> -->

	<H3 style='background-color:#006699;color:cyan;height:20px;padding:9px;'>App Generator system Board List</H3>
<?php
	$query = "select url from aboard_admin";
	$mq  = sql_query($query);
	$rs  = sql_fetch_array($mq );
	$url = $rs[url];
//if( isset($H_ID) ){ // 안먹힌다.
if( $H_ID ){
?>
	User:<?=$H_ID?><input type='button' style='background-color:#006699;color:cyan;height:35px; ' value='Board Create' onclick="javascript:window.open('../contents/board_create_pop.php','_blank','');">ip:<?=$_SERVER['REMOTE_ADDR']?>
      <div align="left">
          <p align="center" title='run file path. table:aboard_admin ' style='background-color:F6F6F6;color:black;'>
		  board path:<input type="text" name="board_url" value='<?=$url?>' readonly></p>
      </div>
<?php } else { ?>
          <p align="center" title='run file path. table:aboard_admin ' style='background-color:F6F6F6;color:black;'>
		  ip:<?=$_SERVER['REMOTE_ADDR']?></p>
	<!-- --------------------------------------------- -->
<?php
} // if H_ID
?>

	<!-- --------------------------------------------- -->

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
	?>
    <!-- <tr>
      <td width="100%" height="55" bgcolor="#FFFFFF"> -->

<!-- <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="42"> -->

<table class='floating-thead' border="1" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse; background-color:black;color:blue;">
<!-- <table class='floating-thead' width='100%' border="1"> -->
	<thead  width='100%' bgcolor="#F6F6F6" height="27">

            <!-- <TH align="center" bgcolor="#F6F6F6" height="21">NO</TH> -->
            <TH>NO</TH>
            <TH>Board Name</TH>
            <TH>CNT</TH>
            <TH>SKIN</TH>
            <TH>User</TH>
	</thead>

<tbody width='100%'>

<?php
		$cnt=0; $i=0;
		while( $mf = sql_fetch_array($mq)){
			$i++;
			if(!$cnt){$cnt=1;}
			$board_url		 = "index.php?infor=" . $mf[no];
			$board_url_adminI = $url . "index.php";
			$tab = $mf[table_name];
			$query	= "SELECT * from aboard_" . $mf[table_name] . " ";
			$mq1	= sql_query($query);
			$mn1	= sql_num_rows($mq1);
			if( $mf[grant_view] == '0' ) $vx="Guest";
			else if ($mf[grant_view] == '1' ) $vx="Member";
			else if ($mf[grant_view] == '2' ) $vx="Only Me";
			else if ($mf[grant_view] == '3' ) $vx="System";
			else $vx="Guest";
			if( $mf[grant_write] == '0' ) $vW="Guest";
			else if ($mf[grant_write] == '1' ) $vW="Member";
			else if ($mf[grant_write] == '2' ) $vW="Only Me";
			else if ($mf[grant_write] == '3' ) $vW="System";
			else $vW="Guest";

			if( $mf[movie]=='1' ) $skin_tit='General type';
			else if( $mf[movie]=='2' ) $skin_tit='Standard type';
			else if( $mf[movie]=='3' ) $skin_tit='Memo type';
			else if( $mf[movie]=='4' ) $skin_tit='Image type';
?>

			<tr>
			  <td style='text-align:center;font-size:15px;height:24px;background-color:black;color:yellow;'><?=$i?></td>
            <td style='text-align:center;font-size:15px;height:24px;background-color:black;color:yellow;'>
				<a href="javascript:openpage('../<?=$board_url_adminI?>', '<?=$mf[no]?>')" style='text-align:center;font-size:15px;height:24px;background-color:black;color:yellow;'>
				<?=$mf[name]?></a></td>
			<td style='text-align:center;font-size:15px;height:24px;background-color:black;color:yellow;'><?=$mn1?></td>
			<td style='text-align:center;font-size:15px;height:24px;background-color:black;color:yellow;'><?=$skin_tit?></td>
            <td style='text-align:center;font-size:15px;height:24px;background-color:black;color:yellow;'>
			<?php
				if($H_LEV > 1) {
			?>
			<?=$mf[make_id]?>
			<?php } else { ?>
			-
			<?php }	?>
			</td>
          </tr>
<?php
		$cnt+=1;
} // while
?>
          <!-- <tr>
            <td width="100%" align="center" colspan="10" bgcolor="#C0C0C0" height="1"></td>
          </tr>

		  </table>
		  </td>
    </tr> -->
    <!-- <tr>
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
    </tr> -->
	</tbody>

	</table>
  <!-- </td>
 </tr> -->
<!-- </table> -->

</body>
</html>
