<html>
<head>
<title>이미지 선택</title>
<style>
body, td, tr { font-size:10pt;font-family:돋움체;}
img {cursor:hand;}
td {text-align:center;}
a:link, a:visited, a:active {text-decoration:none; font-size:10pt; color:black;}
a:hover { font-size:10pt; color:red}
</style>

<script language="JavaScript">
<!--

function sel() {
	opener.document.sys_bom.imgtype1.value = document.image1.src;
	opener.document.img1.src = document.image1.src;
	opener.document.sys_bom.imgtype2.value = document.image2.src;
	opener.document.img2.src = document.image2.src;
	opener.document.sys_bom.imgtype3.value = document.image3.src;
	opener.document.img3.src = document.image3.src;
	window.close();
}

 function clickHandler() { 
	var  targetId, srcElement,  targetElement; 
	srcElement = window.event.srcElement; 
	targetId = srcElement.id + "d"; 
	targetElement = document.all( targetId ); 

	if ( targetElement ) {
		if ( targetElement.style.display == "none") { 
			 document.all.layer1d.style.display = "none";
			 document.all.layer2d.style.display = "none";
			 document.all.layer3d.style.display = "none";
			 
			 targetElement.style.display = ""; 
		} else { 
			 targetElement.style.display = "none";
		
			if (srcElement.className == "image1") { 
				selectedImg = document.image1;
			}
			else if(srcElement.className == "image2") {
				selectedImg = document.image2;
			}
			else {
				selectedImg = document.image3;
			}
			selectedImg.src = srcElement.src;
		}
	}	
}
	document.onclick = clickHandler; 

//-->
</script>

</head>
<body bgcolor="white" text="black">
<form name="frm">
<div id="layer1d" style="display:None;background-color:silver; width:60px; height:60px; position:absolute; left:230px; top:70px; z-index:1;silver ;">
	<table width="60" height="60">
	<?
		for ( $j = 0 ; $j <= 14 ; $j++ ){
	?>
		<tr>
		<?
			$skin_dir = "../skins_treeicon/as00/";
			for ( $i = 0 ; $i <=2 ; $i++ ){
				$imgfile_name = "img". sprintf("%d" ,$i+$j) ;
		?>
				<td bgcolor="white" width="20" height="20">
				<img src="<? echo $skin_dir . $imgfile_name . "_r.gif" ?>" id="layer1" class="image1" >
				</td>
		<?
			}
			$j = $j + $i;
			$j--;			
		?>
		</tr>
	<?
		}
	?>
	</table>
</div>
<div id="layer2d" style="display:None;background-color:silver; width:60px; height:60px; position:absolute; left:296px; top:70px; z-index:1;silver ;">
	<table width="60" height="60">
	<?
		for ( $j = 0 ; $j <= 14 ; $j++ ){
	?>
		<tr>
		<?
			$skin_dir = "../skins_treeicon/as00/";
			for ( $i = 0 ; $i <=2 ; $i++ ){
				$imgfile_name = "img". sprintf("%d" ,$i+$j) ;
		?>
				<td bgcolor="white" width="20" height="20">
				<img src="<? echo $skin_dir . $imgfile_name . "_l.gif" ?>" id="layer2" class="image2" >
				</td>
		<?
			}
			$j = $j + $i;
			$j--;			
		?>
		</tr>
	<?
		}
	?>
	</table>
</div>
<div id="layer3d" style="display:None;background-color:silver; width:60px; height:60px; position:absolute; left:360px; top:70px; z-index:1; ;">
	<table width="60px" height="50">
	<?
		for ( $j = 0 ; $j <= 14 ; $j++ ){
	?>
		<tr>
		<?
			$skin_dir = "../skins_treeicon/as00/";
			for ( $i = 0 ; $i <=2 ; $i++ ){
				$imgfile_name = "img". sprintf("%d" ,$i+$j) ;
		?>
				<td bgcolor="white" width="20" height="20">
				<img src="<? echo $skin_dir . $imgfile_name . ".gif" ?>" id="layer3" class="image3" >
				</td>
		<?
			}
			$j = $j + $i;
			$j--;			
		?>
		</tr>
	<?
		}
	?>
	</table>
</div>
<p align="center"><font face="돋움">이미지 선택</font></p>
<table align="center" border="1" cellspacing="0" width="404" bordercolordark="white" bordercolorlight="silver" bordercolor="silver">
    <tr>
        <td width="144" height="44" bordercolor="silver" bgcolor="silver" style="border-color:silver; border-style:none;">
            <p align="center"><font face="돋움체"><b>기본 이미지</b></font></p>
        </td>
        <td width="57" height="44">
            <p align="center"><img src="../skins_treeicon/as00/img1_r.gif" name="image1" width="16" height="22" border="0" id="layer1" class="image1" style="cursor:hand"></p>
        </td>
        <td width="56" height="44">
            <p align="center"><img src="../skins_treeicon/as00/img1_l.gif" id="layer2" name="image2" class="image2" width="16" height="22" border="0"></p>
        </td>
        <td width="65" height="44">
            <p align="center"><img src="../skins_treeicon/as00/img1.gif" id="layer3" name="image3" class="image3" width="16" height="22" border="0"></p>
        </td>
        <td width="60" height="44" bordercolor="silver" bgcolor="silver" style="border-color:silver; border-style:none;">
        <p align="center">
            <font size="2" color="#3333FF"><a href="javascript:sel();">＊선택</a></font></p>
        </td>
    </tr>
</table>
</form>
</body>

</html>
