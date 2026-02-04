<?php 
	include_once('../tkher_start_necessary.php');
	if( isset($member['mb_level']) and ($member['mb_level'] < 8) ) {
		m_("approach error. ---mb_level:".$member['mb_level']);
		$url = KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top');</script>";
	}

	$menu1TWPer=25;  
	$menu1AWPer=100 - $menu1TWPer;  
	$menu2TWPer=10;  
	$menu2AWPer=50 - $menu2TWPer;  
	$menu3TWPer=10;  
	$menu3AWPer=33.3 - $menu3TWPer;  
	$menu4TWPer=10;  
	$menu4AWPer=25 - $menu4TWPer;  
	$Xwidth='90%';  
	/* $Bwidth=5; // 버튼 % */
	$Xheight='100%';  
	$Text_height='60px';  


	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
    if( $mode == 'next_input') {
        set_cookie('add_admin_info', 'next', 43200); // 12시간 저장
        echo "<script>window.open('', '_self').close();</script>";
        exit;
    }

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
    width: 88px;
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

/* .a_btn:hover {
    background: #a3a3a3;
} */
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
    document.tkher_form.action = "ksd39673976_1711436495_run.php?pg_code=" + $pg_code;
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
        document.makeform.action = 'ksd39673976_1711436495_update.php?pg_code=' + $pg_code;
        document.makeform.submit();
    }
}

function tab_pg_list($pg_code) {
    document.tkher_form.action = 'ksd39673976_1711436495_run.php?pg_code=' + $pg_code;
    document.tkher_form.submit();
}

function Back($pg_code) {
    document.tkher_form.action = 'DB_Table_CreateA.php';
    document.tkher_form.submit();
}
</script>
<script src="//code.jquery.com/jquery.min.js"></script>
</head>

<body width=100%>
    <center>

        <?php   
	$SQLX = " SELECT * from {$tkher['config_table']} ";   
	if ( ($result = sql_query( $SQLX ) )==false )   
	{   
	  printf("SQLX Invalid query: %s", $SQLX);   
	  exit();   
	} else {   
				$row	= sql_fetch_array($result); 
				
				$key = 'modumoa';
				$iv = '~!@#$%^&*()_+';
?>
        <div class="HeadTitle01AX">
            <P href='#' class='on' title='table code:ksd39673976_1711436495 , program name:kapp_config_v1'>
                Admin kapp_config Setting</P>
        </div>
        <form name='tkher_form' method='post' enctype='multipart/form-data'>
            <input type=hidden name='mode' value='' />
            <input type=hidden name='seqno' value='' />
            <input type=hidden name='pg_name' value='kapp_config_v1' />
            <input type=hidden name='pg_code' value='ksd39673976_1711436495' />
            <input type=hidden name='page' value='<?=$page?>' />
            <input type=hidden name='grant_write' value='<?=$grant_write?>' />
        </form>
        <div class='boardViewX'>
            <div class='viewHeader'>
                <span title='tab_update_pg70'>Date:<?=date("Y-m-d H:i:s" ); ?></span>
                <input type=button value='Back' onclick="javascript:Back();" class='Btn_List01A'>
            </div>
            <div class='viewSubjX'><span>kapp_config_v1</span> </div>
            <div class='blankA'> </div>
            <form name='makeform' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>
                <input type=hidden name='mode' value='' />
                <input type=hidden name='seqno' value='' />
                <input type=hidden name='page' value='<?=$page?>' />
                <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_title
                    </span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_title ' value="<?=$row['kapp_title']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_title .'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Shared Server (ex:fation.net)</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_theme' value="<?=$row['kapp_theme']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_theme.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_admin</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_admin' value="<?=$row['kapp_admin']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_admin.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_admin_email</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_admin_email' value="<?=$row['kapp_admin_email']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_admin_email.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_admin_email_name</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_admin_email_name'
                        value="<?=$row['kapp_admin_email_name']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_admin_email_name.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_use_point</span></div>
                <div class='menu1A'><input type='TINYINT' name='kapp_use_point' value="<?=$row['kapp_use_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_use_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_point_term</span></div>
                <div class='menu1A'><input type='INT' name='kapp_point_term' value="<?=$row['kapp_point_term']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_point_term.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_login_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_login_point' value="<?=$row['kapp_login_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_login_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_read_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_read_point' value="<?=$row['kapp_read_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_read_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_write_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_write_point' value="<?=$row['kapp_write_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_write_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_comment_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_comment_point' value="<?=$row['kapp_comment_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_comment_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_download_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_download_point'
                        value="<?=$row['kapp_download_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_download_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_register_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_register_point'
                        value="<?=$row['kapp_register_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_register_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_recommend_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_recommend_point'
                        value="<?=$row['kapp_recommend_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_recommend_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_memo_send_point</span></div>
                <div class='menu1A'><input type='INT' name='kapp_memo_send_point'
                        value="<?=$row['kapp_memo_send_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_memo_send_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_googl_shorturl_apikey</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_googl_shorturl_apikey'
                        value='<?=$row['kapp_googl_shorturl_apikey']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_googl_shorturl_apikey.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_kakao_js_apikey</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_kakao_js_apikey'
                        value='<?=$row['kapp_kakao_js_apikey']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_kakao_js_apikey.'></div>

				
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_naver_client_id</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_naver_client_id'
                        value='<?=$row['kapp_naver_client_id']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_naver_client_id.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align=center><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_naver_client_secret</span></div>
                <div class='menu1A'><input type='VARCHAR' name='kapp_naver_client_secret'
                        value='<?=$row['kapp_naver_client_secret']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_naver_client_secret.'></div>

				
				<div class='blankA'> </div>
                <input type='hidden' name='upfile' value='<?=$upfile?>' />
                <div class='viewHeader'>
                    <!-- <input type=button value='Save'
                        onclick="javascript:record_modify('ksd39673976_1711436495','<?=$seqno?>');" class='Btn_List02A'>
                    <input type=button value='List' onclick="javascript:tab_pg_list('ksd39673976_1711436495');"
                        class='Btn_List02A'> -->
                </div>
            </form>
        </div>
                        <input type=button value='Enter next' onclick="Next_input()"  class="Btn_List02A">
<?php   
	}  //query false   
?>
</body>
<script>
Add_Btn('.menu1A');

function Next_input() {
    document.makeform.mode.value = 'next_input'
    document.makeform.action = '../adm/add_admin_info.php';
    document.makeform.submit();
}
function Add_Btn(_class) {

    let itemList = document.querySelectorAll(_class);
    //console.log(itemList.length);

    itemList.forEach(function(item) {
        let add_input = document.createElement("input");
        add_input.setAttribute("class", "a_btn");
        add_input.type = 'button';
        add_input.value = "update";
        add_input.setAttribute("onclick", "update_ajax(this)");
        item.append(add_input);
    });


}

function update_ajax(_this) {
    $.ajax({
		header:{"Content-Type":"application/json"},
        method: "post",
        dataType: "json",
        data: {
            "mode": 'config_update',
            "column": JSON.stringify(_this.previousElementSibling.name),
            "data": JSON.stringify(_this.previousElementSibling.value)
        },
        url: "config_update_ajax.php",
        success: function(data) {
            //console.log(data);
            alert(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- config_update_ajax.php errorThrown: " +errorThrown);
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            return;
        }
    });
}
</script>

</html>