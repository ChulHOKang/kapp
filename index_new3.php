<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");   //"ss_mb_id";
	$ipcd = connect_count($host_script, $H_ID, 0, $referer);	// 1: country code return 요청.
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>AppGeneratorSystem. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>


<?php
	if($is_mobile){
		m_("mobile index_new3");
?>
		<frame src="pg_menu3.php" name='table_menu' frameborder='0' scrolling='no' ></frame>
<?php
	} else {
?>
	<frameset cols="30%, *" frameborder='0'>
		<frame src="pg_menu3.php" name='table_menu' frameborder='0' scrolling='auto' >
		<frame src="index_my.php"	 name='table_main' frameborder='0' scrolling='auto' >
	</frameset>
<?php
	}
?>

</html>
