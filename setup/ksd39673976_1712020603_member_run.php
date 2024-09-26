<?php
		include_once('../tkher_start_necessary.php');
		if($member['mb_level'] < 8) {
		m_("approach error. ---mb_level:".$member['mb_level']);
			echo "<script>window.open( './index.php' , '_self');</script>";
		}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <TITLE>AppGenerator.net AppGenerator is generator program. Made in Kang ChulHo</TITLE>
    <link rel='shortcut icon' href='./logo25a.jpg'>
    <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
    <meta name='keywords'
        content='app generator, app maker, appgenerator, app, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '>
    <meta name='description'
        content='app generator, app maker, appgenerator, app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '>
    <meta name='robots' content='ALL'>
</head>
<script src="//code.jquery.com/jquery.min.js"></script>
<script>
$(function() {
    $('table.listTableT').each(function() {
        if ($(this).css('border-collapse') == 'collapse') {
            $(this).css('border-collapse', 'separate').css('border-spacing', 0);
        }
        $(this).prepend($(this).find('thead:first').clone().hide().css('top', 0).css('position',
            'fixed'));
    });
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop(),
            scrollLeft = $(window).scrollLeft();
        $('table.listTableT').each(function(i) {
            var thead = $(this).find('thead:last'),
                clone = $(this).find('thead:first'),
                top = $(this).offset().top,
                bottom = top + $(this).height() - thead.height();
            if (scrollTop < top || scrollTop > bottom) {
                clone.hide();
                return true;
            }
            if (clone.is('visible')) return true;
            clone.find('th').each(function(i) {
                $(this).width(thead.find('th').eq(i).width());
            });
            clone.css("margin-left", -scrollLeft).width(thead.width()).show();
        });
    });
});
</script>
<style>
* {
    font-family: 'Noto Sans KR', 'Malgun Gothic', sans-serif;
    font-size: 14px;
    color: #666;
    -webkit-overflow-scrolling: touch;
    letter-spacing: -1px;
    -webkit-transition: color .5s, background .5s;
    transition: color .5s, background .5s;
}

html,
body,
p,
input,
select,
form,
label,
mark,
ul,
ul li,
ol,
ol li,
dl,
dl dt,
dl dd,
img,
a,
table,
h1,
h2,
h3,
h4,
h5 {
    margin: 0;
    padding: 0;
}

img {
    border: 0;
}

ul,
ol {
    list-style: none;
}

a {
    color: #555;
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

table {
    border: 0;
    border-collapse: collapse;
    table-layout: fixed;
}

.HeadTitle03AX {
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

.btn_bo02T {
    width: 64px;
    height: 33px;
    display: inline-block;
    line-height: 33px;
    text-align: center;
    color: #fff;
    font-size: 14px;
    background: #d01d27;
    margin-right: 10px;
    text-decoration: none;
}

.btn_bo03T {
    width: 84px;
    height: 33px;
    display: inline-block;
    line-height: 33px;
    text-align: center;
    color: #fff;
    font-size: 14px;
    background: #d01d27;
    margin-right: 10px;
    text-decoration: none;
}

.viewHeaderT {
    width: 100%;
    height: auto;
    overflow: hidden;
    position: relative;
    text-align: left;
}

.viewHeaderT span {
    left: 0;
    top: 12px;
    font-size: 14px;
    color: #686868;
}

.boardViewT {
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

.listTableT {
    width: 100%px;
    text-decoration: none;
}

.listTableT th {
    word-break: break-all;
    height: 42px;
    border-top: 3px solid #d01c27;
    font-size: 14px;
    color: #69604f;
    font-weight: normal;
    background: #fafafa;
    border-bottom: 1px solid #dedede;
}

.listTableT td {
    word-break: break-all;
    height: 30px;
    border-bottom: 1px solid #dedede;
    font-size: 14px;
    color: #69604f;
    font-weight: normal;
}

.listTableT td a span {
    font-size: 14px;
    color: #69604f;
}

.listTableT td a .t01 {
    font-size: 14px;
    color: #d01c27;
}

.listTableT span {
    font-size: 18px;
    color: #171512;
    vertical-align: baseline;
}

.listTableT .cell01 {
    width: 60px;
    text-align: center;
    text-decoration: none;
}

.listTableT .cell03 {
    font-size: 18px;
    text-align: center;
    text-decoration: none;
    font-weight: bold;
}

.listTableT .cell03X {}

.listTableT .cell05 {
    width: 70px;
    text-align: center;
}

.listTableT .cell02 {
    width: 80px;
    text-align: center;
}

.listTableT .cell04 {
    width: 200px;
    text-align: center;
}

.listTableT .cell06 {
    width: 50px;
    text-align: center;
}

.paging {
    margin: 20px auto 0 auto;
    width: 100%;
    height: auto;
    overflow: hidden;
    text-align: center;
}

.paging a,
.paging span,
.paging img {
    display: inline-block;
    vertical-align: middle;
}

.paging a {
    color: #979288;
    font-size: 18px;
    font-weight: bold;
}

.paging span {
    color: #979288;
    font-size: 18px;
    font-weight: bold;
}

.paging a:hover {
    opacity: 1;
    color: #d01c27;
}

.paging a.on {
    font-weight: bold;
    color: #d01c27;
}

.paging a.prev {
    margin-right: 20px;
}

.paging a.next {
    margin-left: 20px;
}
</style>
<script type='text/javascript'>
function home_func($pg_code) {
    document.view_form.page.value = 1;
    document.view_form.mode = 'home_func';
    document.view_form.action = './ksd39673976_1712020603_member_run.php';
    document.view_form.submit();
}

function Change_Csel3(c_sel) {
    document.view_form.search_choice.value = c_sel;
    document.view_form.c_sel3.value = c_sel;
}

function Change_Csel2(c_sel) {
    var obj = document.getElementById("c_sel3");
    var c = c_sel.split("|");
    document.view_form.search_fld.value = c[0];
    document.view_form.mode.value = 'search';
}

function pg_record_view(seqno) {
    document.view_form.seqno.value = seqno;
    document.view_form.action = 'ksd39673976_1712020603_view.php?seqno=' + seqno;
    document.view_form.submit();
}

function table_record_write(mode) {
    document.view_form.mode.value = mode;
    document.view_form.action = './ksd39673976_1712020603_write.php';
    document.view_form.submit();
}

function excel_down() {
    document.view_form.mode.value = 'excel_create';
    document.view_form.action = 'excel_download_user.php';
    document.view_form.submit();
}

function page_move($page) {
    document.view_form.page.value = $page;
    document.view_form.action = './ksd39673976_1712020603_member_run.php';
    document.view_form.submit();
}

function Change_line_cnt($line) {
    document.view_form.page.value = 1;
    document.view_form.line_cnt.value = $line;
    document.view_form.action = './ksd39673976_1712020603_member_run.php';
    document.view_form.submit();
}

function search_data() {
    var c_sel = document.getElementById("c_sel");
    i = c_sel.selectedIndex;
    c_sel = c_sel.options[i].value;
    var c_sel3 = document.getElementById("c_sel3");
    i = c_sel3.selectedIndex;
    c_sel3 = c_sel3.options[i].value;
    document.view_form.mode.value = 'SR';
    document.view_form.search_fld.value = c_sel;
    document.view_form.search_choice.value = c_sel3;
    document.view_form.page.value = 1;
    document.view_form.action = './ksd39673976_1712020603_member_run.php'
    document.view_form.submit();
}

function Edit_member(_mb_id) {
    document.view_form.mb_id.value = _mb_id;
    document.view_form.action = 'ksd39673976_1712020603_member_update.php';
    document.view_form.submit();
}

function Back($pg_code) {
    document.view_form.action = 'DB_Table_CreateA.php';
    document.view_form.submit();
}
</script>
<?php
	$c_sel		= $_POST['c_sel'];
	$c_sel3		= $_POST['c_sel3'];
	$search_fld	= $_POST['search_fld'];
	$search_text	= $_POST['search_text'];
	$search_choice = $_POST['search_choice'];
	$tab_enm	    = "kapp_member";
	$tab_hnm	    = "kapp_member_update";
	$table_item_array	= "|mb_id|mb_id|VARCHAR|30@|mb_sn|mb_sn|VARCHAR|255@|mb_password|mb_password|VARCHAR|255@|mb_name|mb_name|VARCHAR|255@|mb_nick|mb_nick|VARCHAR|255@|mb_nick_date|mb_nick_date|DATE|15@|mb_email|mb_email|VARCHAR|255@|mb_photo|mb_photo|VARCHAR|255@|mb_homepage|mb_homepage|VARCHAR|255@|mb_level|mb_level|TINYINT|4@|mb_sex|mb_sex|CHAR|1@|mb_birth|mb_birth|VARCHAR|255@|mb_tel|mb_tel|VARCHAR|255@|mb_hp|mb_hp|VARCHAR|255@|mb_certify|mb_certify|VARCHAR|20@|mb_adult|mb_adult|TINYINT|4@|mb_dupinfo|mb_dupinfo|VARCHAR|255@|mb_zip1|mb_zip1|CHAR|10@|mb_zip2|mb_zip2|CHAR|3@|mb_addr1|mb_addr1|VARCHAR|255@|mb_addr2|mb_addr2|VARCHAR|255@|mb_addr3|mb_addr3|VARCHAR|255@|mb_addr_jibeon|mb_addr_jibeon|VARCHAR|255@|mb_signature|mb_signature|TEXT|255@|mb_recommend|mb_recommend|VARCHAR|255@|mb_point|mb_point|INT|11@|mb_today_login |mb_today_login |DATETIME|20@|mb_login_ip|mb_login_ip|VARCHAR|255@|mb_datetime|mb_datetime|DATETIME|20@|mb_ip|mb_ip|VARCHAR|255@|mb_leave_date|mb_leave_date|VARCHAR|8@|mb_intercept_date|mb_intercept_date|VARCHAR|8@|mb_email_certify|mb_email_certify|DATETIME|20@|mb_email_certify2|mb_email_certify2|VARCHAR|255@|mb_memo|mb_memo|TEXT|255@|mb_lost_certify|mb_lost_certify|VARCHAR|255@|mb_mailling|mb_mailling|TINYINT|4@|mb_sms|mb_sms|TINYINT|4@|mb_open|mb_open|TINYINT|4@|mb_open_date|mb_open_date|DATE|15@|mb_profile|mb_profile|TEXT|255@|mb_memo_call|mb_memo_call|VARCHAR|255@";
			$line_cnt	= $_POST['line_cnt'];
			if( !$line_cnt  ) $line_cnt	= 10;
			$page_num = 10;			// #[1] [2] [3] 갯수  - 10:고정.
 ?>

<body width=100%>
    <center>
        <br>
        <div style='text-align:center;'>
            <P class='HeadTitle03AX'>kapp_member_update</P>
        </div>
        <?php
			$tab_enm = 'kapp_member';
			$SQL1 = "SELECT * from {$tkher['tkher_member_table']} ";
			if( $mode=='SR' ){
				if( $search_choice == 'like')		$SQL1 = $SQL1 . " where $search_fld $search_choice '%$search_text%' ";
				else									$SQL1 = $SQL1 . " where $search_fld $search_choice '$search_text' ";
			}
			if ( ($result = sql_query( $SQL1 ) )==false )
			{
				printf("Invalid query: %s", $SQL1);
				my_msg(" ERROR : Select kapp_member  ");
				$total_count = 0;
			} else {
				$total_count = sql_num_rows($result);
				if( $total_count ) $total_page  = ceil($total_count / $line_cnt);
				else $total_page  =1;
				if ($page < 2) {
					$page = 1;
					$start = 0;
				} else {
					$start = ($page - 1) * $line_cnt;
				}
				$last = $line_cnt;
				if( $total_count < $last) $last = $total_count;
			}
?>
        <div style='width:99%;'>
            <div class='viewHeaderT'>
                <span>appgenerator.net: kapp_member &nbsp;&nbsp;&nbsp;&nbsp;Total: <strong><?=$total_count?>
                        &nbsp;&nbsp;&nbsp;&nbsp; Page:<?=$page?></strong>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <select id='line_cntS' name='line_cntS'
                        onChange='Change_line_cnt(this.options[this.selectedIndex].value)' style='height:20;'>
                        <option value='5' <?php if($line_cnt=='5' )  echo " selected " ?>>5</option>
                        <option value='10' <?php if($line_cnt=='10' )  echo " selected " ?>>10</option>
                        <option value='20' <?php if($line_cnt=='20' )  echo " selected " ?>>20</option>
                        <option value='30' <?php if($line_cnt=='30' )  echo " selected " ?>>30</option>
                        <option value='50' <?php if($line_cnt=='50')   echo " selected " ?>>50</option>
                        <option value='100' <?php if($line_cnt=='100') echo " selected " ?>>100</option>
                    </select>
                </span>
            </div>
        </div>
        <form name='view_form' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='mode' value='<?=$mode?>' />
            <input type='hidden' name='seqno' value='' />
            <input type='hidden' name='mb_id' value='' />
            <input type='hidden' name='page' value='<?=$page?>' />
            <input type='hidden' name='tab_enm' value='<?=$tab_enm?>' />
            <input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>' />
            <input type='hidden' name='item_array' value='<?=$item_array?>'>
            <input type='hidden' name='table_item_array'
                value='|mb_id|mb_id|VARCHAR|30@|mb_sn|mb_sn|VARCHAR|255@|mb_password|mb_password|VARCHAR|255@|mb_name|mb_name|VARCHAR|255@|mb_nick|mb_nick|VARCHAR|255@|mb_nick_date|mb_nick_date|DATE|15@|mb_email|mb_email|VARCHAR|255@|mb_photo|mb_photo|VARCHAR|255@|mb_homepage|mb_homepage|VARCHAR|255@|mb_level|mb_level|TINYINT|4@|mb_sex|mb_sex|CHAR|1@|mb_birth|mb_birth|VARCHAR|255@|mb_tel|mb_tel|VARCHAR|255@|mb_hp|mb_hp|VARCHAR|255@|mb_certify|mb_certify|VARCHAR|20@|mb_adult|mb_adult|TINYINT|4@|mb_dupinfo|mb_dupinfo|VARCHAR|255@|mb_zip1|mb_zip1|CHAR|10@|mb_zip2|mb_zip2|CHAR|3@|mb_addr1|mb_addr1|VARCHAR|255@|mb_addr2|mb_addr2|VARCHAR|255@|mb_addr3|mb_addr3|VARCHAR|255@|mb_addr_jibeon|mb_addr_jibeon|VARCHAR|255@|mb_signature|mb_signature|TEXT|255@|mb_recommend|mb_recommend|VARCHAR|255@|mb_point|mb_point|INT|11@|mb_today_login |mb_today_login |DATETIME|20@|mb_login_ip|mb_login_ip|VARCHAR|255@|mb_datetime|mb_datetime|DATETIME|20@|mb_ip|mb_ip|VARCHAR|255@|mb_leave_date|mb_leave_date|VARCHAR|8@|mb_intercept_date|mb_intercept_date|VARCHAR|8@|mb_email_certify|mb_email_certify|DATETIME|20@|mb_email_certify2|mb_email_certify2|VARCHAR|255@|mb_memo|mb_memo|TEXT|255@|mb_lost_certify|mb_lost_certify|VARCHAR|255@|mb_mailling|mb_mailling|TINYINT|4@|mb_sms|mb_sms|TINYINT|4@|mb_open|mb_open|TINYINT|4@|mb_open_date|mb_open_date|DATE|15@|mb_profile|mb_profile|TEXT|255@|mb_memo_call|mb_memo_call|VARCHAR|255@'>
            <input type='hidden' name='item_cnt' value='<?=$item_cnt?>'>
            <input type='hidden' name='list_no' value='' />
            <input type='hidden' name='c_sel' value='<?=$c_sel?>' />
            <input type='hidden' name='c_sel3' value='<?=$c_sel3?>' />
            <input type='hidden' name='pg_code' value='<?=$pg_code?>' />
            <input type='hidden' name='search_fld' value='<?=$search_fld?>' />
            <input type='hidden' name='search_choice' value='<?=$search_choice?>' />
            <input type='hidden' name='line_cnt' value='<?=$line_cnt?>' />
            <table class='listTableT' width=99%>
                <thead>
                    <tr>
                        <th style='width:30px; height:100%px;text-align:center;font-weight:bold'>No</th>
                        <th class='cell03'>mb_id</th>
                        <!-- <th class='cell03'>mb_sn</th>
                        <th class='cell03'>mb_password</th> -->
                        <th class='cell03'>mb_name</th>
                        <!-- <th class='cell03'>mb_nick</th>
                        <th class='cell03'>mb_nick_date</th>
                        <th class='cell03'>mb_email</th>
                        <th class='cell03'>mb_photo</th>
                        <th class='cell03'>mb_homepage</th>
                        <th class='cell03'>mb_level</th>
                        <th class='cell03'>mb_sex</th>
                        <th class='cell03'>mb_birth</th>
                        <th class='cell03'>mb_tel</th>
                        <th class='cell03'>mb_hp</th>
                        <th class='cell03'>mb_certify</th>
                        <th class='cell03'>mb_adult</th>
                        <th class='cell03'>mb_dupinfo</th>
                        <th class='cell03'>mb_zip1</th>
                        <th class='cell03'>mb_zip2</th>
                        <th class='cell03'>mb_addr1</th>
                        <th class='cell03'>mb_addr2</th>
                        <th class='cell03'>mb_addr3</th>
                        <th class='cell03'>mb_addr_jibeon</th>
                        <th class='cell03'>mb_signature</th>
                        <th class='cell03'>mb_recommend</th>
                        <th class='cell03'>mb_point</th>
                        <th class='cell03'>mb_today_login </th>
                        <th class='cell03'>mb_login_ip</th>
                        <th class='cell03'>mb_datetime</th>
                        <th class='cell03'>mb_ip</th>
                        <th class='cell03'>mb_leave_date</th>
                        <th class='cell03'>mb_intercept_date</th>
                        <th class='cell03'>mb_email_certify</th>
                        <th class='cell03'>mb_email_certify2</th>
                        <th class='cell03'>mb_memo</th>
                        <th class='cell03'>mb_lost_certify</th>
                        <th class='cell03'>mb_mailling</th>
                        <th class='cell03'>mb_sms</th>
                        <th class='cell03'>mb_open</th>
                        <th class='cell03'>mb_open_date</th>
                        <th class='cell03'>mb_profile</th>
                        <th class='cell03'>mb_memo_call</th> -->
                        <th class='cell03'>Edit</th>
                    </tr>
                </thead>
                <tbody width=100%>
                    <?php
			$SQL		= "SELECT * from {$tkher['tkher_member_table']} ";
 			$SQL_limit	= "  limit $start , $last; ";
			$OrderBy	= " order by mb_no desc ";
			if( $mode == "SR" ){
				if( $search_choice == 'like' )	$SQL = $SQL . " where $search_fld $search_choice '%$search_text%' ";
				else							$SQL = $SQL . " where $search_fld $search_choice '$search_text' ";
			}
			$SQL = $SQL . $OrderBy . $SQL_limit;
			if ( ($result = sql_query( $SQL ) )==false )
			{
				printf("Record 0 : query: %s
", $SQL);
			} else {
				if( $page > 1 ) $no=($page -1) * $line_cnt;
				else $no=0;
				while( $row = sql_fetch_array($result)  ) {
					$no++;
?>
                    <tr>
                        <td style='width:30px; height:100%px;text-align:center'>
                            <a><?=$no?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_id']?></a></td>
                        <!-- <td class=cell03><a><?=$row['mb_sn']?></a></td>
                        <td class=cell03><a><?=$row['mb_password']?></a>
                        </td> -->
                        <td class=cell03><a><?=$row['mb_name']?></a></td>
                        <!-- <td class=cell03><a><?=$row['mb_nick']?></a></td>
                        <td class=cell03><a><?=$row['mb_nick_date']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_email']?></a></td>
                        <td class=cell03><a><?=$row['mb_photo']?></a></td>
                        <td class=cell03><a><?=$row['mb_homepage']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_level']?></a></td>
                        <td class=cell03><a><?=$row['mb_sex']?></a></td>
                        <td class=cell03><a><?=$row['mb_birth']?></a></td>
                        <td class=cell03><a><?=$row['mb_tel']?></a></td>
                        <td class=cell03><a><?=$row['mb_hp']?></a></td>
                        <td class=cell03><a><?=$row['mb_certify']?></a></td>
                        <td class=cell03><a><?=$row['mb_adult']?></a></td>
                        <td class=cell03><a><?=$row['mb_dupinfo']?></a></td>
                        <td class=cell03><a><?=$row['mb_zip1']?></a></td>
                        <td class=cell03><a><?=$row['mb_zip2']?></a></td>
                        <td class=cell03><a><?=$row['mb_addr1']?></a></td>
                        <td class=cell03><a><?=$row['mb_addr2']?></a></td>
                        <td class=cell03><a><?=$row['mb_addr3']?></a></td>
                        <td class=cell03><a><?=$row['mb_addr_jibeon']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_signature']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_recommend']?></a>
                        </td>
                        <?php $num = number_format( $row['mb_point'] );  ?>
                        <td class=cell03><a><?=$num?></a></td>
                        <td class=cell03><a><?=$row['mb_today_login ']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_login_ip']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_datetime']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_ip']?></a></td>
                        <td class=cell03><a><?=$row['mb_leave_date']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_intercept_date']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_email_certify']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_email_certify2']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_memo']?></a></td>
                        <td class=cell03><a><?=$row['mb_lost_certify']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_mailling']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_sms']?></a></td>
                        <td class=cell03><a><?=$row['mb_open']?></a></td>
                        <td class=cell03><a><?=$row['mb_open_date']?></a>
                        </td>
                        <td class=cell03><a><?=$row['mb_profile']?></a></td>
                        <td class=cell03><a><?=$row['mb_memo_call']?></a>
                        </td> -->
                        <td class=cell03><a><input type="button" style="font-weight: bold;"
                                    onclick="Edit_member('<?=$row['mb_id']?>')" value="Edit"></a>
                        </td>
                    </tr>
                    <?php
				}	//while
			}
?>
                </tbody>
            </table>
            <div class="fl">
                <table>
                    <tr>
                        <td>
                            <select id='c_sel' name='c_sel'
                                onChange='Change_Csel2(this.options[this.selectedIndex].value)' style='height:30;'>
                                <option value='mb_id' <?php if($search_fld == 'mb_id') echo " selected ";?>>mb_id
                                </option>";
                                <!-- <option value='mb_sn' <?php if($search_fld == 'mb_sn') echo " selected ";?>>mb_sn
                                </option>";
                                <option value='mb_password' <?php if($search_fld == 'mb_password') echo " selected ";?>>
                                    mb_password</option>"; -->
                                <option value='mb_name' <?php if($search_fld == 'mb_name') echo " selected ";?>>mb_name
                                </option>";
                                <!-- <option value='mb_nick' <?php if($search_fld == 'mb_nick') echo " selected ";?>>mb_nick
                                </option>";
                                <option value='mb_nick_date'
                                    <?php if($search_fld == 'mb_nick_date') echo " selected ";?>>mb_nick_date</option>";
                                <option value='mb_email' <?php if($search_fld == 'mb_email') echo " selected ";?>>
                                    mb_email</option>";
                                <option value='mb_photo' <?php if($search_fld == 'mb_photo') echo " selected ";?>>
                                    mb_photo</option>";
                                <option value='mb_homepage' <?php if($search_fld == 'mb_homepage') echo " selected ";?>>
                                    mb_homepage</option>";
                                <option value='mb_level' <?php if($search_fld == 'mb_level') echo " selected ";?>>
                                    mb_level</option>";
                                <option value='mb_sex' <?php if($search_fld == 'mb_sex') echo " selected ";?>>mb_sex
                                </option>";
                                <option value='mb_birth' <?php if($search_fld == 'mb_birth') echo " selected ";?>>
                                    mb_birth</option>";
                                <option value='mb_tel' <?php if($search_fld == 'mb_tel') echo " selected ";?>>mb_tel
                                </option>";
                                <option value='mb_hp' <?php if($search_fld == 'mb_hp') echo " selected ";?>>mb_hp
                                </option>";
                                <option value='mb_certify' <?php if($search_fld == 'mb_certify') echo " selected ";?>>
                                    mb_certify</option>";
                                <option value='mb_adult' <?php if($search_fld == 'mb_adult') echo " selected ";?>>
                                    mb_adult</option>";
                                <option value='mb_dupinfo' <?php if($search_fld == 'mb_dupinfo') echo " selected ";?>>
                                    mb_dupinfo</option>";
                                <option value='mb_zip1' <?php if($search_fld == 'mb_zip1') echo " selected ";?>>mb_zip1
                                </option>";
                                <option value='mb_zip2' <?php if($search_fld == 'mb_zip2') echo " selected ";?>>mb_zip2
                                </option>";
                                <option value='mb_addr1' <?php if($search_fld == 'mb_addr1') echo " selected ";?>>
                                    mb_addr1</option>";
                                <option value='mb_addr2' <?php if($search_fld == 'mb_addr2') echo " selected ";?>>
                                    mb_addr2</option>";
                                <option value='mb_addr3' <?php if($search_fld == 'mb_addr3') echo " selected ";?>>
                                    mb_addr3</option>";
                                <option value='mb_addr_jibeon'
                                    <?php if($search_fld == 'mb_addr_jibeon') echo " selected ";?>>mb_addr_jibeon
                                </option>";
                                <option value='mb_signature'
                                    <?php if($search_fld == 'mb_signature') echo " selected ";?>>mb_signature</option>";
                                <option value='mb_recommend'
                                    <?php if($search_fld == 'mb_recommend') echo " selected ";?>>mb_recommend</option>";
                                <option value='mb_point' <?php if($search_fld == 'mb_point') echo " selected ";?>>
                                    mb_point</option>";
                                <option value='mb_today_login '
                                    <?php if($search_fld == 'mb_today_login ') echo " selected ";?>>mb_today_login
                                </option>";
                                <option value='mb_login_ip' <?php if($search_fld == 'mb_login_ip') echo " selected ";?>>
                                    mb_login_ip</option>";
                                <option value='mb_datetime' <?php if($search_fld == 'mb_datetime') echo " selected ";?>>
                                    mb_datetime</option>";
                                <option value='mb_ip' <?php if($search_fld == 'mb_ip') echo " selected ";?>>mb_ip
                                </option>";
                                <option value='mb_leave_date'
                                    <?php if($search_fld == 'mb_leave_date') echo " selected ";?>>mb_leave_date</option>
                                ";
                                <option value='mb_intercept_date'
                                    <?php if($search_fld == 'mb_intercept_date') echo " selected ";?>>mb_intercept_date
                                </option>";
                                <option value='mb_email_certify'
                                    <?php if($search_fld == 'mb_email_certify') echo " selected ";?>>mb_email_certify
                                </option>";
                                <option value='mb_email_certify2'
                                    <?php if($search_fld == 'mb_email_certify2') echo " selected ";?>>mb_email_certify2
                                </option>";
                                <option value='mb_memo' <?php if($search_fld == 'mb_memo') echo " selected ";?>>mb_memo
                                </option>";
                                <option value='mb_lost_certify'
                                    <?php if($search_fld == 'mb_lost_certify') echo " selected ";?>>mb_lost_certify
                                </option>";
                                <option value='mb_mailling' <?php if($search_fld == 'mb_mailling') echo " selected ";?>>
                                    mb_mailling</option>";
                                <option value='mb_sms' <?php if($search_fld == 'mb_sms') echo " selected ";?>>mb_sms
                                </option>";
                                <option value='mb_open' <?php if($search_fld == 'mb_open') echo " selected ";?>>mb_open
                                </option>";
                                <option value='mb_open_date'
                                    <?php if($search_fld == 'mb_open_date') echo " selected ";?>>mb_open_date</option>";
                                <option value='mb_profile' <?php if($search_fld == 'mb_profile') echo " selected ";?>>
                                    mb_profile</option>";
                                <option value='mb_memo_call'
                                    <?php if($search_fld == 'mb_memo_call') echo " selected ";?>>mb_memo_call</option>"; -->
                            </select>
                        </td>
                        <td>
                            <select id='c_sel3' name='c_sel3'
                                onChange='Change_Csel3(this.options[this.selectedIndex].value)' style='height:30;'>
                                <option value='like' <?php if($search_choice=='like' ) echo " selected " ?>>like
                                </option>
                                <option value='=' <?php if($search_choice=='=' ) echo " selected " ?>>=</option>
                                <option value='>' <?php if($search_choice=='>') echo " selected" ?>>></option>
                                <option value='<' <?php if($search_choice=='<') echo " selected" ?>>
                                    << /option>
                            </select>
                        </td>
                        <td><input type='text' name='search_text' id='search_text' value='<?=$search_text?>'
                                style='height:30;' /></td>
                        <td><input type='button' value='Search' onclick="javascript:search_data();" class='btn_bo02T'>
                        </td>
                        <!-- <td title='tkher_program_data_listDN'>
                            <input type='button' value='Write'
                                onclick="javascript:table_record_write('table_pg70_write');" class='btn_bo02T'>
                        </td>
                        <td title='Create and download the data as an Excel file.'>
                            <input type='button' value='Excel Down' onclick="javascript:excel_down();"
                                class='btn_bo03T'>
                        </td> -->
                        <td>
                            <input type='button' value='Back' onclick="javascript:Back();" class='btn_bo02T'>
                        </td>
                    </tr>
                </table>
        </form>
        </div>
        <?php
			pagingA("ksd39673976_1712020603_member_run.php",$total_count,$page,$line_cnt );

function pagingA($link, $total, $page, $size){ // paging() pagingA()로 적용함.
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);
	/*
	$temp		= $page%$size;
	if($temp=="0"){
		$a=$size-1;
		$b=$temp;
	}else{
		$a=$temp-1;
		$b=$size-$temp;
	}
	$start	= $page-$a;
	$end		= 10;//$page+$b;
	*/
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;

	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>[First]</a><span>.</span>");
	} else {
		echo("<span>[Start].</span>");
		//echo("<img src=./include/img/btn/b_first_silver.gif border=0 height=30 title='First'>");
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		//echo("<a href='javascript:page_move($back_page)' ><img src=./include/img/btn/btn_prev.png width=30 title='previous'></a>");
		echo("<a href='javascript:page_move($back_page)' >[Prev]</a><span>.</span>");
	} else {
		//echo("<img src=./include/img/btn/btn_prev.png width=30 title='Previous'>");
		//echo("<span>[Prev].</span>");
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("<a href='javascript:void(0)' class=on>$i</a><span>.</span>"); }
		else         { echo("<a href='javascript:page_move($i)'>$i</a><span>.</span>"); }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'>[Next]</a><span>.</span>");
		//echo("<a href='javascript:page_move($next_page)'><img src=./include/img/btn/btn_next.png width=30 title='B Next Page'></a>");
	}else { 
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo("<span>[Next].</span>");
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
		//echo("<img src=./include/img/btn/b_last_silver.gif border=0 height=30 title='Last'>");
	}
	echo "</div>";
}

?>
</body>

</html>
