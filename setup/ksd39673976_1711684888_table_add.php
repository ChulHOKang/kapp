<?php 
	include_once('../tkher_start_necessary.php');
	if($_SESSION['mb_level'] < 8) {
		m_("approach error. ---mb_level:".$member['mb_level']);
		echo "<script>window.open( './index.php' , '_self');</script>";
	}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <TITLE>AppGenerator is generator program. Made in ChulHo Kang : solpakan89@gmail.com</TITLE>
    <link rel='shortcut icon' href='/logo/logo25a.jpg'>
    <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
    <meta name='keywords'
        content='app generator, app maker, appgenerator, app, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '>
    <meta name='description'
        content='app generator, app maker, appgenerator, app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '>
    <meta name='robots' content='ALL'>
</head>
<?php                                 
	define('TKHER_MOBILE_AGENT',   'phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|android|sony');	  
	$is_mobile = false;  
	$is_mobile = preg_match('/'.TKHER_MOBILE_AGENT.'/i', $_SERVER['HTTP_USER_AGENT']);   
	$menu1TWPer=15;  
	if( $is_mobile ) $menu1TWPer=36;    
	$menu1AWPer=100 - $menu1TWPer;  
	$menu2TWPer=10;  
	$menu2AWPer=50 - $menu2TWPer;  
	$menu3TWPer=10;  
	$menu3AWPer=33.3 - $menu3TWPer;  
	$menu4TWPer=10;  
	$menu4AWPer=25 - $menu4TWPer;  
	$Xwidth='100%';  
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
    width: 99px;
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
</style>

<body width=100%>
    <center>

        <div class='HeadTitle01AX'>
            <P href='#' class='on' title='table code:ksd39673976_1711684888 , program name:kapp_table_list'>
                kapp_table_list</P>
        </div>
        <div class='boardViewX'>
            <div class='viewHeader'>
                <?php                                 
	// table: ksd39673976_1711684888 , table name:kapp_table_list 
	$host_url = $tkher_iurl; 
	$relation_dataPG = ''; 
	$relation_typePG = ''; 
	$if_typePG  = ''; 
	$if_dataPG  = ''; 
	$pop_dataPG = ''; 
	$item_array		= '|k_table_name|k_table_name|CHAR|30@|k_table_link|k_table_link|CHAR|100@|k_date|k_date|DATETIME|20@|memo|memo|TEXT|255@';    
	$_SESSION['if_typePG'] = $if_typePG;
	$_SESSION['if_dataPG'] = $if_dataPG; 
	$_SESSION['pop_dataPG']= $pop_dataPG; 
	$_SESSION['relation_dataPG']= $relation_dataPG; 
	$_SESSION['relation_typePG']= $relation_typePG; 
	$in_day = date('Y-m-d H:i:s');   
?>
                <span
                    title='pg:ksd39673976_1711684888'>K-App:ksd39673976_1711684888&nbsp;&nbsp;&nbsp;<?=$in_day?></span>
            </div>
            <div class='viewSubjX'><span title='(ksd39673976_1711684888:kapp_table_list)'>kapp_table_list</span> </div>
            <div class='blankA'> </div>
            <form name='makeform' method='post' enctype='multipart/form-data'>
                <input type='hidden' name='page' value='<?=$_REQUEST["page"]?>' />
                <input type='hidden' name='line_cnt' value='<?=$_REQUEST["line_cnt"]?>' />
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>k_table_name</span></div>
                <div class='menu1A'><input type='text' name='k_table_name' value=''
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a k_table_name'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>k_table_link</span></div>
                <div class='menu1A'><input type='text' name='k_table_link' value=''
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a k_table_link'>
                </div>
                <div class='blankA'> </div>

                <!-- <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>k_date</span>
                </div>
                <div class='menu1A'><input type='DATETIME' name='k_date' value='<?=$day?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a k_date'></div>
                <div class='blankA'> </div> -->
                <p>memo</p>
                <div class='menu1Area'><textarea name='memo' placeholder='Please enter your memo!'
                        style='width:<?=$Xwidth?>;height:<?=$Text_height?>;'></textarea></div>
                <div class='blankA'> </div>
                <?php                                 
 $_SESSION['fld_session'] = $fld_session;	// 팝업창 테이블 위치 : if_dataPG     
?>
                <input type='hidden' name='mode' value=''>
                <input type='hidden' name='tab_hnm' value=''>
                <input type='hidden' name='tab_enm' value=''>
                <input type='hidden' name='return_pg_code' value=''>
                <input type='hidden' name='item_array' value='<?=$item_array?>'>
                <input type='button' value='submit' onclick="program_run_pg('4','')" class='Btn_List01A'>
                <!-- <input type='reset' value='reset' class='Btn_List01A'> -->
                <!-- <input type='button' value='Excel_Upload'
                    onclick="excel_upload_func('ksd39673976_1711684888','kapp_table_list')" class='Btn_List02A'
                    title='Batch upload of data to excel file'> -->
                <input type='button' value='Back' onclick="javascript:Back();" class='Btn_List01A'>
            </form>

            <script language='JavaScript'>
            <!--   
            function popup_callDN(if_dataPG, pop_dataPG, if_typePG, host_url, i) {
                substring = 'appgenerator.net';
                if (host_url.includes(substring)) Trun = '../../popup_callDN.php?fld_session=' + i;
                else Trun = './popup_callDN.php?fld_session=' + i;
                window.open(Trun, '',
                    'alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes');
                return true;
            }

            function input_check(item_cnt, iftype) {
                itype = iftype.split('|');
                for (i = 1; i < item_cnt; i++) {
                    if (!itype[i] || itype[i] == '0') {
                        var column_data = eval('document.makeform.fld_' + i + '.value');
                        if (!column_data) {
                            var column_fld = 'document.makeform.fld_' + i + '.focus()';
                            alert('column_data:' + column_data);
                            eval(column_fld);
                            return false;
                        }
                    } else {}
                }
                return true;
            }

            function program_run_pg(item_cnt, iftype) {
                document.makeform.mode.value = 'Tkher_write';
                document.makeform.action = './ksd39673976_1711684888_table_add_r.php';
                document.makeform.target = '_self';
                document.makeform.submit();
            }

            function table_data_list() {
                document.makeform.action = './ksd39673976_1711684888_table_add.php';
                document.makeform.submit();
            }

            function Back() {
                document.makeform.action = './DB_Table_CreateA.php';
                document.makeform.submit();
            }

            function excel_upload_func(tab_enm, tab_hnm) {
                document.makeform.mode.value = 'Upload_mode';
                document.makeform.tab_enm.value = tab_enm;
                document.makeform.tab_hnm.value = tab_hnm;
                document.makeform.return_pg_code.value = 'ksd39673976_1711684888_table_add.php';
                document.makeform.action = "excel_upload_user.php";
                document.makeform.target = '_self';
                document.makeform.submit();
            }
            //
            -->
            </script>