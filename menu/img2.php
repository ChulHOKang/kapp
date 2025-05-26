<?
/////////////////////////// 이미지 업로드 /////////////////////////////////////////////////////

//include "../inc/dbcon_inc.php";    
		require_once("./inc/config.php");		
		include "./inc/dbcon.php";
		require_once ("./func/my_func.php");

$result1=mysqli_query($mc, "SELECT * from main_img");    
$main_img=mysqli_fetch_array($result1);    

?>
<html>
<head>
	<title>이미지 업로드</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
	<!--
	BODY, TD {
		font-size : 10pt;
	}
	//-->
	</style>
</head>
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
          <?
	#### 입력폼을 리스트한다.
	for ( $i = 1 ; $i <=10 ; $i++ ) {
		$upfile_name_1 = "img". sprintf("%d" ,$i) ."_r";
		$upfile_name_2 = "img". sprintf("%d" ,$i) ."_l";
		$upfile_name_3 = "img". sprintf("%d" ,$i) ;

?>
          <tr bordercolor="#FFFFFF" bgcolor="#CC9966"> 
            <td><div align="center"><strong><img src=../skins_treeicon/<?=$main_img[tree_img]?>/<?echo($upfile_name_1 . ".gif") ?> ></strong></div></td>
            <td> <div align="center"> 
                <input type="file" name="<?echo( "$upfile_name_1" )?>" size="15">
              </div></td>
			<td><div align="center"><strong><img src=../skins_treeicon/<?=$main_img[tree_img]?>/<?echo($upfile_name_2 . ".gif") ?> ></strong></div></td>
            <td> <div align="center"> 
                <input type="file" name="<?echo( "$upfile_name_2" )?>" size="15">
              </div></td>
			<td><div align="center"><strong><img src=../skins_treeicon/<?=$main_img[tree_img]?>/<?echo($upfile_name_3 . ".gif") ?> ></strong></div></td>
            <td> <div align="center"> 
                <input type="file" name="<?echo( "$upfile_name_3" )?>" size="15">
              </div></td>
          </tr>
<?
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
			  <input type="submit" value="이미지 업로드">
			  <input type="reset" value="취소">
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
<!--//////////////////////////////////////////////////////////////////////////-->
