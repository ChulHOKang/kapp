<?php
	include_once('../tkher_start_necessary.php');

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;
/*
  list1_detail_update.php : board_data_update.php를 copy
  image type board - list1.php - list1_detail.php - data update를 위해 사용.
*/

$infor   = $_POST['infor'];
$list_no = $_POST['list_no'];
$page         =$_POST['page']; 
$search_text  =$_POST['search_text']; 
$search_choice=$_POST['search_choice']; 
$update_pass  =$_POST['update_pass']; 
$update_pass  =$_POST['update_pass'];// =list1

$no = $_POST['infor'];

include "./infor.php";

//m_("list_detail_update.php infor:$infor, no:$no, list_no:$list_no");

$query="SELECT * from aboard_" . $mf_infor[2] . " where no=$list_no";
$mq = sql_query($query );
//$mf = mysqli_fetch_row($mq);
$mf = sql_fetch_row($mq);



//m_("update_pass:$update_pass");

?>

<?=$mf_infor[44]?><!-- top -->

<link rel="stylesheet" href="./include/css/board.css" type="text/css">

<style type="text/css">

<!--


BODY{scrollbar-face-color: #ffffff;scrollbar-highlight-color: #bbbbbb;scrollbar-shadow-color: #bbbbbb;scrollbar-3dlight-color: #ffffff;scrollbar-arrow-color: #bbbbbb;scrollbar-track-color: #ffffff;scrollbar-darkshadow-color: #ffffff ; font-family:굴림;}

-->

</style>

<script>
function check(x,y){

	if(x.name.value==''){
	alert('Please enter your name');//이름을 입력하세요
	x.name.focus();
	return false;
	}
	if(x.subject.value==''){
	alert('Please enter a title');//제목을 입력하세요
	x.subject.focus();
	return false;
	}
	if(x.context.value==''){
	alert('Please enter your content');//내용을 입력하세요
	x.context.focus();
	return false;
	}
	if(y=="0"){
	if(x.password.value==''){
	alert('Please enter a password');//비밀번호를 입력하세요
	x.password.focus();
	return false;
	}
	}
	else{return true;}
	
}
function textarea_size(value) {
	if (value == 0) {
	  document.form.context.cols  = 60;
	  document.form.context.rows  = 10;
	}
	if (value == 1) document.form.context.cols += 5;
	if (value == 2) document.form.context.rows += 5;
}

function update_func(id){
	if( !id ){
		var p1 = document.update_form.password.value;
		if( !p1 ) { alert('Enter Password! ' ); return false; }
		var p2 = document.update_form.passwordG.value;
		if( p1 == p2 )	document.update_form.submit();
		else {
			alert('Password is incorrect! p:' + p1);
			return false;
		}
	} else document.update_form.submit();
}
function back_func(infor){
	update_form.action='list1.php?infor='+infor;
	document.update_form.submit();
}
function goBack() {
	update_form.action='list1_detail.php';
	document.update_form.submit();
}
</script>

<SCRIPT src="./include/js/contents_resize.js" type=text/javascript></SCRIPT>

<!-- <body bgProperties=fixed leftmargin="0" topmargin="0" onLoad="frame_init()"> 
<body bgProperties=fixed leftmargin="0" topmargin="0" align=center>-->
<body>
<center>
<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>

<FORM name='update_form' action='query_ok_new.php' method='post' >
	
	<input type='hidden' name='infor'	value='<?=$infor?>' >
	<input type='hidden' name='list_no'	value='<?=$list_no?>' >
	<input type='hidden' name='page'	value='<?=$page?>' >
	<input type='hidden' name='search_choice'	value='<?=$search_choice?>' >
	<input type='hidden' name='search_text'		value='<?=$search_text?>' >
	<input type='hidden' name='update_pass'		value='<?=$update_pass?>' ><!-- list1 -->

	<input type='hidden' name='mode'			value='list1_detail_update'> <!-- update_func -->

<table width="<?=$mf_infor[10]?>" border="1" cellspacing="1" cellpadding="1" align="center">
  <!--<tr>
     <td><img src="./images/cbox_top_000.gif"></td>
  </tr>-->
  <tr>
    <td>
<table width="<?=$mf_infor[10]?>" border="0" cellspacing="1" cellpadding="1" align=center>
    <tr>
      <td align="center"> 


  <table width="565" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
    <tr>
      <td align="center" bgcolor="#FFFFFF" align=center> 
        <br>
        <table width="565" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td valign="top" align="left" height="400">
 
 <table border=0 cellspacing=0 cellpadding=5 width=565 bgcolor=Silver>
    <tr> 
      <td height=22><font color="#FFFFFF"><?=$mf_infor[1]?></font></td>
    </tr>
 </table>
<table width=<?=$mf_infor[10]?> align=center>
    <tr><td>
   <br>
  <table width=560 <?=$mf_infor[24]?>  bgcolor="WhiteSmoke">

<!-- <FORM name='update_form' action='query_ok_new.php' method='post' onsubmit='return check(this,"<?=$mf_infor[8]?>")'> -->

<tr><td colspan=2 width="100%" height="1" bgcolor="#ffffff" background="./img/dot.gif"></td></tr>
 
    <tr>
      <td width="15%" height="14" bgcolor="<?=$mf_infor[25]?>" align="center">
      <font color="<?=$mf_infor[26]?>">Author</td>
      <td width="75%" height="14">
      <input type="text" name="name" size="18" maxlength=30 value='<?=$mf[3]?>' style='border:1 black solid;'></td>
    </tr>


<!--
    <tr>
      <td width="15%" height="18" bgcolor="<?=$mf_infor[25]?>" align="center">
        <font color="<?=$mf_infor[26]?>">E-Mail</td>
      <td width="75%" height="18" >
        <input type="text" name="email" size="32" value='<?=$mf[4]?>' style='border:1 black solid;'></td>
    </tr>
    <tr>
      <td width="15%" height="18" bgcolor="<?=$mf_infor[25]?>" align="center">
        <font color="<?=$mf_infor[26]?>">HomePage</td>
      <td width="75%" height="18" >
        <input type="text" name="home" size="39" maxlength=50 value='<?=$mf[5]?>' style='border:1 black solid;'></td>
    </tr>
-->

    <tr>
      <td width="15%" height="18" bgcolor="<?=$mf_infor[25]?>" align="center">
        <font color="<?=$mf_infor[26]?>">Subject</td>
      <td width="75%" height="18" >
        <input type="text" name="subject" size="61" maxlength=50 value='<?=$mf[8]?>' style='border:1 black solid;'></td>
    </tr>
    <tr>
<?php if(!$H_ID){?>
    <tr>
      <td width="236" height="7" bgcolor="<?=$mf_infor[25]?>">
       <p align="center"><font color="<?=$mf_infor[26]?>">Password</td>
      <td width="235" height="7">
      <input type="password" name="password" size="18" maxlength=10 value="" style='border:1 black solid;'></td>
    </tr>
<?php } ?>
<?php if($mf_infor[7]){
if($mf[10]=='1'){$html_1="checked";}
if($mf[10]=='2'){$html_2="checked";}
if($mf[10]=='3'){$html_3="checked";}?>
 
      <td width="15%" height="12" bgcolor="<?=$mf_infor[25]?>" align="center">
        <font color="<?=$mf_infor[26]?>">Type</td>
      <td width="75%" height="12" >
        <input type="radio" value="1" name="html" <?=$html_1?>> HTML
        <input type="radio" value="2" name="html" <?=$html_2?>> HTML소스
        <input type="radio" value="3" name="html" <?=$html_3?>> TEXT</td>
    </tr>
<?php $html_1="";$html_2="";$html_3="";}?>
    <tr>
      <td width="15%" height="9" bgcolor="<?=$mf_infor[25]?>" align="center">
        <a href="javascript:textarea_size(2)"><font color="<?=$mf_infor[26]?>">▼</a>
        <a href="javascript:textarea_size(0)"><font color="<?=$mf_infor[26]?>">▣</a>
        <a href="javascript:textarea_size(1)"><font color="<?=$mf_infor[26]?>">▶</a></td>
      <td width="75%" height="9" >
        Re-Size
        </td>
    </tr>
    <tr>
      <td colspan=2 width="15%" height="9" align="center">
        <table board=0 width="100%" cellpadding=0 cellspacing=0>
        	<tr>
      	<td width="15%" height="9"  align="center"><font color="<?=$mf_infor[26]?>"></td>
       	 <td width="75%" height="9" >
        <textarea rows="10" wrap="hard" name="context" cols="60" ><?=$mf[9]?></textarea>
        </td>
    </tr>
        </table>
        </td>
    </tr>
<tr><td colspan=2 width="100%" height="1" bgcolor="#ffffff" background="./img/dot.gif"></td></tr>
 
    <tr>
      <td width="15%" height="12" align="center"></td>
<td width="75%" height="9" >

<!--<a href="javascript:history.back()"><img src="<?=$mf_infor[28]?>" border=0></a>
 <input type=image src="<?=$mf_infor[37]?>"> -->
<!-- <input type='button' value='Back' onclick='javascript:history.back(-1)'> -->

<!-- <input type='button' value='Back' onclick="javascript:history.back(-1)"> -->
<!-- <a href="#" onclick="history.go(-1);return false;" style="text-decoration:underline;">Back</a> -->

<input type='button' value='Back' onclick="goBack()">&nbsp;&nbsp;&nbsp;
<input type='button' value='Confirm' onclick="update_func('<?=$H_ID?>')">
</td>
    </tr>
  </table>
  </td></tr>
</table>

	  <input type="hidden" name="passwordG" value="<?=$mf[11]?>" >

  </form>
            <!-- End of Paging Table --> 
    </td>
  </tr>  
</table>
</td>
  </tr>
<!--<tr>
    <td><img src="./images/cbox_bot_000.gif"></td>
  </tr>-->
</table>
<?=$mf_infor[45]?><!-- bottom -->
