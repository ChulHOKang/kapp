<?php 
	include_once('../tkher_start_necessary.php');
	$H_ID = get_session("ss_mb_id");
	$url = KAPP_URL_T_;
	if( $H_ID=='' ){
		m_("approach error. --- login please");
		echo "<script>window.open( '$url' , '_top');</script>";
	}
	if( isset($member['mb_level']) and ($member['mb_level'] < 8) ) {
		m_("approach error. ---mb_level:".$member['mb_level']);
		echo "<script>window.open( '$url' , '_top');</script>";
	}

	$menu1TWPer=25;  
	$menu2AWPer=100 - $menu1TWPer;  
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
<link rel="stylesheet" href="../include/css/kapp_basic.css" type="text/css">

<script type="text/javascript">
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
            <input type='hidden' name='mode' value='' />
            <input type='hidden' name='seqno' value='' />
            <input type='hidden' name='pg_name' value='kapp_config_v1' />
            <input type='hidden' name='pg_code' value='ksd39673976_1711436495' />
            <input type='hidden' name='page' value='<?=$page?>' />
            <input type='hidden' name='grant_write' value='<?=$grant_write?>' />
        </form>
        <div class='boardViewX'>
            <div class='viewHeader'>
                <span title='tab_update_pg70'>Date:<?=date("Y-m-d H:i:s" ); ?></span>
                <input type=button value='Back' onclick="javascript:Back();" class='Btn_List01A'>
            </div>
            <div class='viewSubjX'><span>kapp_config_v1</span> </div>
            <div class='blankA'> </div>
            <form name='makeform' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>
                <input type='hidden' name='mode' value='' />
                <input type='hidden' name='seqno' value='' />
                <input type='hidden' name='page' value='<?=$page?>' />
                <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_title
                    </span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_title ' value="<?=$row['kapp_title']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_title .'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Shared Server (ex:fation.net)</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_theme' value="<?=$row['kapp_theme']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_theme.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_admin</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_admin' value="<?=$row['kapp_admin']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_admin.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_admin_email</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_admin_email' value="<?=$row['kapp_admin_email']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_admin_email.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_admin_email_name</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_admin_email_name'
                        value="<?=$row['kapp_admin_email_name']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_admin_email_name.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_use_point</span></div>
                <div class='menu2A'><input type='TINYINT' name='kapp_use_point' value="<?=$row['kapp_use_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_use_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_point_term</span></div>
                <div class='menu2A'><input type='INT' name='kapp_point_term' value="<?=$row['kapp_point_term']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_point_term.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_login_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_login_point' value="<?=$row['kapp_login_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_login_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_read_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_read_point' value="<?=$row['kapp_read_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_read_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_write_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_write_point' value="<?=$row['kapp_write_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;' placeholder='Please enter a kapp_write_point.'>
                </div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_comment_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_comment_point' value="<?=$row['kapp_comment_point']?>"
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_comment_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_download_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_download_point'
                        value="<?=$row['kapp_download_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_download_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_register_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_register_point'
                        value="<?=$row['kapp_register_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_register_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_recommend_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_recommend_point'
                        value="<?=$row['kapp_recommend_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_recommend_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_memo_send_point</span></div>
                <div class='menu2A'><input type='INT' name='kapp_memo_send_point'
                        value="<?=$row['kapp_memo_send_point']?>" style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_memo_send_point.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_googl_shorturl_apikey</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_googl_shorturl_apikey'
                        value='<?=$row['kapp_googl_shorturl_apikey']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_googl_shorturl_apikey.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_kakao_js_apikey</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_kakao_js_apikey'
                        value='<?=$row['kapp_kakao_js_apikey']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_kakao_js_apikey.'></div>

				
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_naver_client_id</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_naver_client_id'
                        value='<?=$row['kapp_naver_client_id']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_naver_client_id.'></div>
                <div class='blankA'> </div>
                <div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_naver_client_secret</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_naver_client_secret'
                        value='<?=$row['kapp_naver_client_secret']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_naver_client_secret.'></div>
				<div class='blankA'> </div>

				<div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_facebook_appid</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_facebook_appid'
                        value='<?=$row['kapp_facebook_appid']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_facebook_appid.'></div>
				<div class='blankA'> </div>
				
				<div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_facebook_secret</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_facebook_secret'
                        value='<?=$row['kapp_facebook_secret']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_facebook_secret.'></div>
				<div class='blankA'> </div>

				<div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_twitter_key</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_twitter_key'
                        value='<?=$row['kapp_twitter_key']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_twitter_key.'></div>
				<div class='blankA'> </div>

				<div class='menu1T' align='center'><span
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_twitter_secret</span></div>
                <div class='menu2A'><input type='VARCHAR' name='kapp_twitter_secret'
                        value='<?=$row['kapp_twitter_secret']?>'
                        style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'
                        placeholder='Please enter a kapp_twitter_secret.'></div>

            </form>
        </div>
                        <input type=button value='Enter next' onclick="Next_input()"  class="Btn_List02A">
<?php   
	}  //query false   
?>
</body>
<script>
Add_Btn('.menu2A');

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
            alert("ERROR.-- config_update_ajax.php errorThrown: " +errorThrown);
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            return;
        }
    });
}
</script>

</html>