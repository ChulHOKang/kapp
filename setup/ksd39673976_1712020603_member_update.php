<?php 
	include_once('../tkher_start_necessary.php');
	if($member['mb_level'] < 8) {
		m_("approach error. ---mb_level:".$member['mb_level']);
		echo "<script>window.open( './index.php' , '_self');</script>";
	}
							
	/* $upfile	 = '';  
	$upfileX	= '';  
	$mode = $_POST["mode"];  
	$seqno = $_REQUEST["seqno"];  
	if( $mode == 'record_update' ) {  
 			$query			= " UPDATE ksd39673976_1712020603 SET  "; 
			$ff_nm = time() . '_';  
			$f_path = './' . $ff_nm;   // $f_path='./file/';  // dir add     
 			$query = $query . "mb_id= '" . $_POST['mb_id'] . "' ";   
 			$query = $query . ",mb_sn= '" . $_POST['mb_sn'] . "' ";   
 			$query = $query . ",mb_password= '" . $_POST['mb_password'] . "' ";   
 			$query = $query . ",mb_name= '" . $_POST['mb_name'] . "' ";   
 			$query = $query . ",mb_nick= '" . $_POST['mb_nick'] . "' ";   
 			$query = $query . ",mb_nick_date= '" . $_POST['mb_nick_date'] . "' ";   
 			$query = $query . ",mb_email= '" . $_POST['mb_email'] . "' ";   
 			$query = $query . ",mb_photo= '" . $_POST['mb_photo'] . "' ";   
 			$query = $query . ",mb_homepage= '" . $_POST['mb_homepage'] . "' ";   
 			$query = $query . ",mb_level= '" . $_POST['mb_level'] . "' ";   
 			$query = $query . ",mb_sex= '" . $_POST['mb_sex'] . "' ";   
 			$query = $query . ",mb_birth= '" . $_POST['mb_birth'] . "' ";   
 			$query = $query . ",mb_tel= '" . $_POST['mb_tel'] . "' ";   
 			$query = $query . ",mb_hp= '" . $_POST['mb_hp'] . "' ";   
 			$query = $query . ",mb_certify= '" . $_POST['mb_certify'] . "' ";   
 			$query = $query . ",mb_adult= '" . $_POST['mb_adult'] . "' ";   
 			$query = $query . ",mb_dupinfo= '" . $_POST['mb_dupinfo'] . "' ";   
 			$query = $query . ",mb_zip1= '" . $_POST['mb_zip1'] . "' ";   
 			$query = $query . ",mb_zip2= '" . $_POST['mb_zip2'] . "' ";   
 			$query = $query . ",mb_addr1= '" . $_POST['mb_addr1'] . "' ";   
 			$query = $query . ",mb_addr2= '" . $_POST['mb_addr2'] . "' ";   
 			$query = $query . ",mb_addr3= '" . $_POST['mb_addr3'] . "' ";   
 			$query = $query . ",mb_addr_jibeon= '" . $_POST['mb_addr_jibeon'] . "' ";   
 			$query = $query . ",mb_signature= '" . $_POST['mb_signature'] . "' ";   
 			$query = $query . ",mb_recommend= '" . $_POST['mb_recommend'] . "' ";   
 			$query = $query . ",mb_point= '" . $_POST['mb_point'] . "' ";   
 			$query = $query . ",mb_today_login = '" . $_POST['mb_today_login '] . "' ";   
 			$query = $query . ",mb_login_ip= '" . $_POST['mb_login_ip'] . "' ";   
 			$query = $query . ",mb_datetime= '" . $_POST['mb_datetime'] . "' ";   
 			$query = $query . ",mb_ip= '" . $_POST['mb_ip'] . "' ";   
 			$query = $query . ",mb_leave_date= '" . $_POST['mb_leave_date'] . "' ";   
 			$query = $query . ",mb_intercept_date= '" . $_POST['mb_intercept_date'] . "' ";   
 			$query = $query . ",mb_email_certify= '" . $_POST['mb_email_certify'] . "' ";   
 			$query = $query . ",mb_email_certify2= '" . $_POST['mb_email_certify2'] . "' ";   
 			$query = $query . ",mb_memo= '" . $_POST['mb_memo'] . "' ";   
 			$query = $query . ",mb_lost_certify= '" . $_POST['mb_lost_certify'] . "' ";   
 			$query = $query . ",mb_mailling= '" . $_POST['mb_mailling'] . "' ";   
 			$query = $query . ",mb_sms= '" . $_POST['mb_sms'] . "' ";   
 			$query = $query . ",mb_open= '" . $_POST['mb_open'] . "' ";   
 			$query = $query . ",mb_open_date= '" . $_POST['mb_open_date'] . "' ";   
 			$query = $query . ",mb_profile= '" . $_POST['mb_profile'] . "' ";   
 			$query = $query . ",mb_memo_call= '" . $_POST['mb_memo_call'] . "' ";   
			$query = $query . " where seqno=$seqno ";   
 			$ret = sql_query( $query );   
 			if( $ret ) {   
 				m_(" Change completed!  ");   
 				if ($upfileX && $upfile) exec ("rm $upfile");	// upfileX: If there is a file, the existing file is preserved if the existing file is not deleted.
 			} else {   
 				printf("sql:%s", $query);   
 				m_(" Change Error!  seqno:$seqno ");   
 			}   
			echo "<script>window.open( './ksd39673976_1712020603_run.php' , '_self', ''); </script>";      
	}    */        
	$menu1TWPer=15;  
	$menu1AWPer=100 - $menu1TWPer;  
	$menu2TWPer=10;  
	$menu2AWPer=50 - $menu2TWPer;  
	$menu3TWPer=10;  
	$menu3AWPer=33.3 - $menu3TWPer;  
	$menu4TWPer=10;  
	$menu4AWPer=25 - $menu4TWPer;  
	$Xwidth='90%';  
	$Xheight='100%';  
	$Text_height='60px';  
?>
<style>
* {
    box-sizing: border-box;
}

.header2A {
    width: 100%;
    height: 50px;
    float: left;
    border: 0px solid red;
    padding: 0px;
}

.menu1Area {
    width: 100%;
    height: auto;
    float: left;
    padding: 0px;
    border: 0px solid #DEDEDE;
    background-color: #FAFAFA;
}

.menu2T {
    padding-top: 3px;
    width: 25%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FAFAFA;
}

.menu2A {
    width: 25%;
    height: 30px;
    float: left;
    padding: 0px;
    border: 0px solid #DEDEDE;
    background-color: #FAFAFA;
}

.data2A {
    width: 25%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.input1A {
    padding: 0px;
}

.mainA {
    width: 100%;
    float: left;
    padding: 15px;
    border: 1px solid red;
}

.menu1T {
    padding-top: 0px;
    width: <?=$menu1TWPer?>%;
    height: 30px;
    float: left;
    padding: 6px;
    border: 1px solid #DEDEDE;
    background-color: #FAFAFA;
}

.menu1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 0px;
    text-align: left;
}

.data1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 6px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

radio1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 6px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.ListBox1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 2px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.File1A {
    width: <?=$menu1AWPer?>%;
    height: 30px;
    float: left;
    padding: 2px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.menu4T {
    padding-top: 3px;
    width: 10%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FAFAFA;
}

.input4A {
    width: 15%;
    height: 30px;
    float: left;
    padding: 0px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.menu4B {
    width: 15%;
    height: 30px;
    float: left;
    padding: 0px;
    border: 0px solid #DEDEDE;
    background-color: #FAFAFA;
}

.data4A {
    width: 15%;
    height: 30px;
    float: left;
    padding: 4px;
    border: 1px solid #DEDEDE;
    background-color: #FFFFFF;
}

.main4A {
    width: 100%;
    float: left;
    padding: 15px;
    border: 1px solid #DEDEDE;
}

.blankA {
    border-top: 0px;
    width: 100%;
    float: left;
    height: 1px;
    padding: 0px;
    border: 1px solid #FFFFFF;
    background-color: #FFFFFF;
}

.blankB {
    width: 100%;
    height: 1px;
    padding: 1px;
    float: left;
    border: 1px solid #FFFFFF;
    background-color: #FFFFFF;
}

.viewSubjX {
    margin-top: 1px;
    width: 100%;
    height: 35px;
    line-height: 32px;
    border-top: 3px solid #d01c27;
    text-align: center;
    background: #fafafa;
    border-bottom: 1px solid #dedede;
    overflow: hidden;
    font-size: 18px;
    color: #69604f;
}

.viewSubjX span {
    font-size: 22px;
    color: #171512;
    vertical-align: baseline;
}

.HeadTitle02AX {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 25px;
    background: #d01c27;
    color: #ffffff;
    border-radius: 5px;
}

.HeadTitle01AX {
    display: inline-block;
    margin: 0 1px;
    height: 40px;
    line-height: 0px;
    padding: 0 20px;
    font-size: 22px;
    background: #d01c27;
    color: #fff;
    border-radius: 5px;
}

.HeadTitle01AX a.on {
    background: #d01c27;
    color: #fff;
}

.HeadTitle01A {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 22px;
    background: #dedcdf;
    color: #000;
    border-radius: 5px;
}

.HeadTitle02A a {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 22px;
    background: #dedcdf;
    color: #000;
    border-radius: 5px;
}

.HeadTitle01A a {
    display: inline-block;
    margin: 0 1px;
    height: 35px;
    line-height: 35px;
    padding: 0 20px;
    font-size: 22px;
    background: #dedcdf;
    color: #000;
    border-radius: 5px;
}

.HeadTitle01A a.on {
    background: #d01c27;
    color: #fff;
}

.Btn_List01A {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 64px;
    height: 33px;
    display: inline-block;
    line-height: 33px;
    text-align: center;
    color: #fff;
    font-size: 14px;
    background: #d01d27;
    margin-right: 10px;
}

.Btn_List02A {
    width: 64px;
    height: 33px;
    display: inline-block;
    line-height: 33px;
    text-align: center;
    color: #fff;
    font-size: 14px;
    background: #d01d27;
    margin-right: 10px;
}

.viewHeader {
    width: 100%;
    height: auto;
    overflow: hidden;
    position: relative;
    text-align: left;
}

.viewHeader span {
    left: 0;
    top: 12px;
    font-size: 14px;
    color: #686868;
}

.boardView {
    width: 1168px;
    height: auto;
    overflow: hidden;
    margin: 0 auto 50px auto;
}

.boardViewX {
    width: 99%;
    height: auto;
    overflow: hidden;
    margin: 0 auto 50px auto;
}

.a_btn {
    position: absolute;
    width: 9%;
    height: 3%;
}

.aa_btn {
    position: absolute;
    width: 5.6%;
    height: 6.3%;
}
</style>
<script type="text/javascript">
function popup_callDN(if_dataPG, pop_dataPG, if_typePG, host_url, i) {
    substring = 'appgenerator.net';
    if (host_url.includes(substring)) Trun = '../../popup_callDN.php?fld_session=' + i;
    else Trun = './popup_callDN.php?fld_session=' + i;
    window.open(Trun, '', 'alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes');
    return true;
}

function table_data_list($pg_code) {
    document.tkher_form.action = "ksd39673976_1712020603_run.php?pg_code=" + $pg_code;
    document.tkher_form.target = '_self';
    document.tkher_form.submit();
}

function popimage(imagesrc, winwidth, winheight) {
    var look = 'width=' + winwidth + ',height=' + winheight + ','
    popwin = window.open("", "", look)
    popwin.document.open()
    popwin.document.write(
        '<title>appgenerator.net</title><body bgcolor="white" topmargin=0 leftmargin=0 marginheight=0 marginwidth=0><a href="javascript:window.close()"><img src="' +
        imagesrc + '" border=0></a></body>')
    popwin.document.close()
}

function record_modify($pg_code, seqno) {
    if (confirm("Do you want to change it?")) {
        document.makeform.mode.value = "record_update";
        document.makeform.seqno.value = seqno;
        document.makeform.action = 'ksd39673976_1712020603_update.php?pg_code=' + $pg_code;
        document.makeform.submit();
    }
}

function tab_pg_list($pg_code) {
    document.tkher_form.action = 'ksd39673976_1712020603_run.php?pg_code=' + $pg_code;
    document.tkher_form.submit();
}

function Back($pg_code) {
    document.tkher_form.action = 'ksd39673976_1712020603_member_run.php';
    document.tkher_form.submit();
}
</script>
<script src="//code.jquery.com/jquery.min.js"></script>
</head>

<body width=100%>
    <center>

        <?php   

	$mb_id = $_POST['mb_id'];
	$SQLX = " SELECT * from {$tkher['tkher_member_table']} where mb_id='".$mb_id."' ";   
	if ( ($result = sql_query( $SQLX ) )==false )   
	{   
	  printf("SQLX Invalid query: %s
", $SQLX);   
	  exit();   
	} else {   
				$row	= sql_fetch_array($result);   
?>
        <div class="HeadTitle01AX">
            <P href='#' class='on' title='table code:ksd39673976_1712020603 , program name:kapp_member_update'>
                kapp_member_update</P>
        </div>
        <form name='tkher_form' method='post' enctype='multipart/form-data'>
            <input type=hidden name='mode' value='' />
            <input type=hidden name='seqno' value='' />
            <input type=hidden name='pg_name' value='kapp_member_update' />
            <input type=hidden name='pg_code' value='ksd39673976_1712020603' />
            <input type=hidden name='page' value='<?=$page?>' />
            <input type=hidden name='grant_write' value='<?=$grant_write?>' />
        </form>
        <div class='boardViewX'>
            <div class='viewHeader'>
                <span title='tab_update_pg70'>Date:<?=date("Y-m-d H:i:s" ); ?></span>
                <input type=button value='Back' onclick="javascript:Back();" class='Btn_List01A'>
            </div>
            <div class='viewSubjX'><span>kapp_member_update</span> </div>
            <div class='blankA'> </div>
            <form name='makeform' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>
                <input type=hidden name='mode' value='' />
                <input type=hidden name='seqno' value='' />
                <input type=hidden name='page' value='<?=$page?>' />
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_id</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_id' value='<?=$row['mb_id']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_id.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_sn</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_sn' value='<?=$row['mb_sn']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_sn.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_password</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_password' value='<?=$row['mb_password']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_password.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_name</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_name' value='<?=$row['mb_name']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_name.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_nick</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_nick' value='<?=$row['mb_nick']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_nick.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_nick_date</span></div>
                <div class='menu1A'><input type='DATE' name='mb_nick_date' value='<?=$row['mb_nick_date']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_nick_date.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_email</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_email' value='<?=$row['mb_email']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_email.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_photo</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_photo' value='<?=$row['mb_photo']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_photo.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_homepage</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_homepage' value='<?=$row['mb_homepage']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_homepage.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_level</span>
                </div>
                <div class='menu1A'><input type='TINYINT' name='mb_level' value='<?=$row['mb_level']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_level.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_sex</span>
                </div>
                <div class='menu1A'><input type='CHAR' name='mb_sex' value='<?=$row['mb_sex']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_sex.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_birth</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_birth' value='<?=$row['mb_birth']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_birth.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_tel</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_tel' value='<?=$row['mb_tel']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_tel.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_hp</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_hp' value='<?=$row['mb_hp']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_hp.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_certify</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_certify' value='<?=$row['mb_certify']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_certify.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_adult</span>
                </div>
                <div class='menu1A'><input type='TINYINT' name='mb_adult' value='<?=$row['mb_adult']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_adult.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_dupinfo</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_dupinfo' value='<?=$row['mb_dupinfo']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_dupinfo.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_zip1</span>
                </div>
                <div class='menu1A'><input type='CHAR' name='mb_zip1' value='<?=$row['mb_zip1']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_zip1.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_zip2</span>
                </div>
                <div class='menu1A'><input type='CHAR' name='mb_zip2' value='<?=$row['mb_zip2']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_zip2.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_addr1</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_addr1' value='<?=$row['mb_addr1']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_addr1.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_addr2</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_addr2' value='<?=$row['mb_addr2']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_addr2.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_addr3</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_addr3' value='<?=$row['mb_addr3']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_addr3.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_addr_jibeon</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_addr_jibeon' value='<?=$row['mb_addr_jibeon']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_addr_jibeon.'>
                </div>
                <div class='blankA'> </div>
                <p>mb_signature</p>
                <div class='menu1Area'><textarea name='mb_signature' placeholder='Please enter your mb_signature!'
                        style='width:<?=$Xwidth?>;height:<?=$Text_height?>;'><?=$row['mb_signature']?></textarea></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_recommend</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_recommend' value='<?=$row['mb_recommend']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_recommend.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_point</span>
                </div>
                <div class='menu1A'><input type='INT' name='mb_point' value='<?=$row['mb_point']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_today_login
                    </span></div>
                <div class='menu1A'><input type='DATETIME' name='mb_today_login ' value='<?=$row['mb_today_login ']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_today_login .'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_login_ip</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_login_ip' value='<?=$row['mb_login_ip']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_login_ip.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_datetime</span></div>
                <div class='menu1A'><input type='DATETIME' name='mb_datetime' value='<?=$row['mb_datetime']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_datetime.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_ip</span>
                </div>
                <div class='menu1A'><input type='VARCHAR' name='mb_ip' value='<?=$row['mb_ip']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_ip.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_leave_date</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_leave_date' value='<?=$row['mb_leave_date']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_leave_date.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_intercept_date</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_intercept_date'
                        value='<?=$row['mb_intercept_date']?>' style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a mb_intercept_date.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_email_certify</span></div>
                <div class='menu1A'><input type='DATETIME' name='mb_email_certify' value='<?=$row['mb_email_certify']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_email_certify.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_email_certify2</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_email_certify2'
                        value='<?=$row['mb_email_certify2']?>' style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a mb_email_certify2.'></div>
                <div class='blankA'> </div>
                <p>mb_memo</p>
                <div class='menu1Area'><textarea name='mb_memo' placeholder='Please enter your mb_memo!'
                        style='width:<?=$Xwidth?>;height:<?=$Text_height?>;'><?=$row['mb_memo']?></textarea></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_lost_certify</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_lost_certify' value='<?=$row['mb_lost_certify']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_lost_certify.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_mailling</span></div>
                <div class='menu1A'><input type='TINYINT' name='mb_mailling' value='<?=$row['mb_mailling']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_mailling.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_sms</span>
                </div>
                <div class='menu1A'><input type='TINYINT' name='mb_sms' value='<?=$row['mb_sms']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_sms.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_open</span>
                </div>
                <div class='menu1A'><input type='TINYINT' name='mb_open' value='<?=$row['mb_open']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_open.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_open_date</span></div>
                <div class='menu1A'><input type='DATE' name='mb_open_date' value='<?=$row['mb_open_date']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_open_date.'>
                </div>
                <div class='blankA'> </div>
                <p>mb_profile</p>
                <div class='menu1Area'><textarea name='mb_profile' placeholder='Please enter your mb_profile!'
                        style='width:<?=$Xwidth?>;height:<?=$Text_height?>;'><?=$row['mb_profile']?></textarea></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>mb_memo_call</span></div>
                <div class='menu1A'><input type='VARCHAR' name='mb_memo_call' value='<?=$row['mb_memo_call']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a mb_memo_call.'>
                </div>
                <div class='blankA'> </div>
                <input type='hidden' name='upfile' value='<?=$upfile?>' />
                <div class='viewHeader'>
                    <!-- <input type=button value='Save'
                        onclick="javascript:record_modify('ksd39673976_1712020603','<?=$seqno?>');" class='Btn_List02A'>
                    <input type=button value='List' onclick="javascript:tab_pg_list('ksd39673976_1712020603');"
                        class='Btn_List02A'> -->
                </div>
            </form>
        </div>
        <?php   
	}  //query false   
?>
</body>
<script>
Add_Btn('.menu1A');
Add_Btn('.menu1Area');

function Add_Btn(_class) {

    let btn_class = "a_btn";
    if (_class == '.menu1Area') btn_class = "aa_btn";

    let itemList = document.querySelectorAll(_class);
    //console.log(itemList.length);

    itemList.forEach(function(item) {
        let add_input = document.createElement("input");
        add_input.setAttribute("class", btn_class);
        add_input.type = 'button';
        add_input.value = "update";
        add_input.setAttribute("onclick", "update_ajax(this)");
        item.append(add_input);
    });


}

function update_ajax(_this) {
    $.ajax({
        type: "post",
        dataType: "json",
        data: {
            "mode": 'member_update',
            "column": JSON.stringify(_this.previousElementSibling.name),
            "data": JSON.stringify(_this.previousElementSibling.value),
            "mb_id": JSON.stringify('<?=$mb_id?>')
        },
        url: "./member_update_ajax.php",
        success: function(data) {
            //console.log(data);
            alert(data);
            if (_this.previousElementSibling.name == 'mb_password') {
                location.reload(); // POST 데이터 유지
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- member_update_ajax.php");
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            return;
        }
    });
}
</script>

</html>