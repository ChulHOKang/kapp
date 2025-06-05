<?php
	include_once('../tkher_start_necessary.php');
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="../logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="web, homepage, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="web, homepage, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<body topmargin='0'  leftmargin='0' marginwidth='0' marginheight='0'>
<?php
	$mid = $_REQUEST['mid'];
	$bnm = $_REQUEST['bnm'];
	$fnm = $_REQUEST['fnm'];
	$ff = KAPP_URL_T_ . "/file/" . $mid . "/" . $bnm . "/" . $fnm; //echo "ff path: " . $ff . " <br>";
?>
<A href='#' onclick="window.close()"><img src="<?=$ff?>" border="0"></a><!-- ./file/] -->
</body>
</head>
</html>

