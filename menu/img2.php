<?php
	include_once('../tkher_start_necessary.php');
	/*
	tree type image upload  
	{$tkher['menuskin_table']}
	//$main_img=sql_fetch("SELECT * from main_img");    // kapp_tkher_main_img - slide image?
	*/
?>
<html>
<head>
	<title>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style type="text/css">
<!--
BODY, TD {
	font-size : 10pt;
}
//-->
</style>
<body>
<center>
<form method="POST" ENCTYPE="multipart/form-data" action="multiple_post2.php" target=main>  
<table border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<table width="600" height="111" border="1" align="center" cellpadding="1" cellspacing="1">
          <tr bordercolor="#FFFFFF" bgcolor="#006600"> 
            <td width="79" height="31"><div align="center"><font size="2"><strong><font color="#FFFFFF">1</font></strong></font></div></td>
            <td width="191" height="31"><div align="center"><font size="2"><strong><font color="#FFFFFF">IMAGE</font></strong></font></div></td>
			<td width="79" height="31"><div align="center"><font size="2"><strong><font color="#FFFFFF">2</font></strong></font></div></td>
            <td width="191" height="31"><div align="center"><font size="2"><strong><font color="#FFFFFF">IMAGE</font></strong></font></div></td>
			<td width="79" height="31"><div align="center"><font size="2"><strong><font color="#FFFFFF">3</font></strong></font></div></td>
            <td width="191" height="31"><div align="center"><font size="2"><strong><font color="#FFFFFF">IMAGE</font></strong></font></div></td>
          </tr>
<?php
for( $i=1;$i<=10;$i++ ) {
	//$upfile_name_1 = "img". sprintf("%d" ,$i) ."_r";
	//$upfile_name_2 = "img". sprintf("%d" ,$i) ."_l";
	//$upfile_name_3 = "img". sprintf("%d" ,$i) ;
	$upfile_name_1 = "img". $i ."_r.gif";
	$upfile_name_2 = "img". $i ."_l.gif";
	$upfile_name_3 = "img". $i .".gif";


	$imgtype	= KAPP_URL_T_ . "/icon";
	$imgtype1	= KAPP_URL_T_ . "/icon/folder.gif";
	$imgtype2	= KAPP_URL_T_ . "/icon/folder1.gif";
	$imgtype3	= KAPP_URL_T_ . "/icon/folder2.gif";
?>
	<tr bordercolor="#FFFFFF" bgcolor="#CC9966"> 
		<!-- <td><div align="center"><strong><img src=<?=$imgtype?>/<?=$main_img['tree_img']?>/<?=$upfile_name_1?> ></strong></div></td> -->
		<td><div align="center"><strong><img src='<?=$imgtype?>/<?=$upfile_name_1?>' ></strong></div></td>
		<td><div align="center"><input type="file" name="<?=$upfile_name_1?>" size="15"></div></td>
		<td><div align="center"><strong><img src='<?=$imgtype?>/<?=$upfile_name_2?>' ></strong></div></td>
		<td> <div align="center"><input type="file" name="<?=$upfile_name_2?>" size="15"></div></td>
		<td><div align="center"><strong><img src='<?=$imgtype?>/<?=$upfile_name_3?>' ></strong></div></td>
		<td> <div align="center"><input type="file" name="<?=$upfile_name_3?>" size="15"></div></td>
	</tr>
<?php
}
?>
        </table>
	</td>
</tr>
<tr>
	<td>
		<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr bordercolor="#FFFFFF" bgcolor="#ffffff"> 
			  <td height="49" colspan="3"><div align="center"> <font color="#000000"> 
			  <input type="submit" value="Submit">
			  <input type="reset" value="Cancel">
			  </font></div></td>
		  </tr>
		</table>
	</td>
</tr>
</table>
</form>

</center>
</body>
</html>
