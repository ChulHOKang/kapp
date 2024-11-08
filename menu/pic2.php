<?php
	include_once('../tkher_start_necessary.php');
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Tkher system for special her. Tkher system is generator program. -Tkher는 특별한 그녀를 위한 프로그램 제작툴입니다.   Made in ChulHo Kang</TITLE> 
<link rel="shortcut icon" href="../logo/logo25a.jpg">

<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="특허, 홈페이지제작 업체, 쇼핑몰제작, 사회적기업, 웹에이전시, 반응형홈페이지 전문, 소프트웨어 개발, 개발툴, 인공지능,딥러닝,투자,소호, web, homepage, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="특허, 홈페이지제작 업체, 쇼핑몰제작, 사회적기업, 웹에이전시, 반응형홈페이지 전문, 소프트웨어 개발, 개발툴, 인공지능,딥러닝,투자,소호, web, homepage, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<body topmargin='0'  leftmargin='0' marginwidth='0' marginheight='0'>
<?php
//echo "path: " . $_REQUEST['file_path'] . " <br>";

$mid = $_REQUEST['mid'];
$bnm = $_REQUEST['bnm'];
$fnm = $_REQUEST['fnm'];
$ff = KAPP_URL_T_ . "/file/" . $mid . "/" . $bnm . "/" . $fnm; //echo "ff path: " . $ff . " <br>";
?>
<A href='#' onclick="window.close()"><img src="<?=$ff?>" border="0"></a><!-- ./file/] -->
</body>
</head>
</html>

