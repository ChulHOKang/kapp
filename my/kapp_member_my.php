<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");
	connect_count($host_script, $H_ID, 0,$referer);
	/*  2021-04-08
		kapp_member_my.php : Manager
	*/
	$day = date("Y-m-d H:i:s");

	if( isset($_POST['mode']) ) $mode = $_POST['mode']; //m_("mode: " . $mode);
	else $mode ='';
	
	if( $member['mb_level'] < 2) {
		m_("login please");
		echo("<meta http-equiv='refresh' content='0; URL=../indexTT.php'>"); exit;
	} else {
		if( $mode == "Change"){
			$sql = "update {$tkher['tkher_member_table']} set mb_memo='".$_POST['memo']."', mb_nick='".$_POST['nickname']."', mb_name = '".$_POST['name']."' , mb_hp='".$_POST['phone']."' , mb_zip1 = '".$_POST['zipcode']."' , mb_addr1 = '".$_POST['addr1']."' , mb_addr2 = '".$_POST['addr2']."' where mb_no=" . $_POST['mb_no'];
			$result = sql_query( $sql );
			if( $result ) m_("OK");
			else {
				m_("Error");
				echo "error update"; exit;
			}
		}
		else if( $mode == "PasswordChange"){
			$password1 = trim($_POST['password1']);
			$day = date("Y-m-d H:i:s"); // login할때 확인한다.
			//$sql = "update {$tkher['tkher_member_table']} set mb_email_certify='".$day ."', mb_password='".get_encrypt_stringA($password1) ."' where mb_no=" . $_POST['mb_no'] . " and mb_id= '" . $H_ID . "' "; // mb_email_certify 업데이트
			$sql = "update {$tkher['tkher_member_table']} set mb_password='".get_encrypt_stringA($password1) ."' where mb_no=" . $_POST['mb_no'] . " and mb_id= '" . $H_ID . "' "; // mb_email_certify 업데이트 안함
			$result = sql_query( $sql );
			if( $result ) m_("OK");
			else {
				m_("id or password error update");
				echo "sql: " . $sql;
				echo " id or password error update"; exit;
			}
		}
	}
?>
<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>Link - App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
    <link rel="shortcut icon" href="/logo/land25.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">

    <style>
    table {
        border-collapse: collapse;
    }

    th {
        background: #666fff;
        color: white;
        height: 32px;
    }

    th,
    td {
        border: 1px solid silver;
        padding: 5px;
    }

    .container {
        background-color: skyblue;
        display: flex;
        /* flex, inline-flex */
        justify-content: space-between;
        /* flex-start, flex-end, center, space-between, space-around */
        align-content: center;
        /* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
        align-items: center;
        /* flex-start, flex-end, center, baseline, stretch */
        height: 25px;
    }

    .item {
        background-color: gold;
        boarder: 1px solid gray;
    }
    </style>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
    $(function() {
        $('table.floating-thead').each(function() {
            if ($(this).css('border-collapse') == 'collapse') {
                $(this).css('border-collapse', 'separate').css('border-spacing', 0);
            }
            $(this).prepend($(this).find('thead:first').clone().hide().css('top', 0).css('position',
                'fixed'));
        });

        $(window).scroll(function() {
            var scrollTop = $(window).scrollTop(),
                scrollLeft = $(window).scrollLeft();
            $('table.floating-thead').each(function(i) {
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

    <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
    <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/common.js"></script>
</head>

<?php
	if( isset($_POST["sdata"]) ) $sdata = $_POST["sdata"]; //m_("mode: " . $mode);
	else $sdata ='';

	if( isset($_POST["page"]) ) $page = $_POST["page"]; //m_("mode: " . $mode);
	else $page = 1;

?>
<script language='javascript'>
<!--
function check_enter() {
    if (event.keyCode == 13) {
        search_func();
    }
}

function search_func() {
    form = document.member_form;
    if (!form.mb_name.value) {
        alert('Enter the name to search and press the search button worm! '); //검색할 명을 입력하시고 검색버턴울 눌러주세요!
        form.mb_name.focus();
        return;
    }
    form.mode.value = "search_rtn";
    form.submit();
}

//-------------
function member_set(i, n, id, name, email, ph, nick, zip, addr1, addr2) {
    //alert( "p: " + p);
    msg = eval("document.member_form.msg_" + i + ".value");
    document.member_form.mb_id.value = id;
    document.member_form.mb_no.value = n;
    document.member_form.mid.value = id;
    document.member_form.name.value = name;
    document.member_form.nickname.value = nick;
    document.member_form.email.value = email;
    //document.member_form.email.value = e;
    document.member_form.phone.value = ph;
    document.member_form.zipcode.value = zip;
    document.member_form.addr1.value = addr1;
    document.member_form.addr2.value = addr2;
    document.member_form.memo.value = msg;
}

function update_save() {
    mb_id = document.member_form.mb_id.value;
    if (!mb_id) {
        alert(" Click the ReSet button, enter the information and click the Save button!");
        //ReSet 버턴을 클릭하고 내용을 입력후 Save 버턴을 클릭하세요!
        return false;
    } else {
        document.member_form.mode.value = "Change";
        document.member_form.action = "kapp_member_my.php";
        document.member_form.submit();
    }
}

function password_save() {
    no = document.member_form.mb_no.value;
    p1 = document.member_form.password1.value;
    p2 = document.member_form.password2.value;
    if (p1 == '' || p2 == '') {
        alert('Passwords no found.');
        return false;
    }
    if (p1 == p2) {
        document.member_form.mode.value = "PasswordChange";
        document.member_form.action = "kapp_member_my.php";
        document.member_form.submit();
    } else {
        alert('Passwords do not match.');
        return false;
    }
}

//
-->
</script>

<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/include/css/dddropdownpanel.css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/dddropdownpanel.js"></script>

<body>

    <?php
		$cur='B';
		//include_once "../menu_run.php";
		$email_btn = '';
		$phone_btn = '';
		if(isset($member['mb_email_certify']) && $member['mb_email_certify'] != '0000-00-00 00:00:00') $email_btn = 'style="display: none;"';
		if(isset($member['mb_certify']) && $member['mb_certify'] != '0000-00-00 00:00:00') $phone_btn = 'style="display: none;"';
?>

    <form name="member_form" method="post">
        <!-- /contents/board_create_pop_ok.php  -->
        <input type="hidden" name="mb_id" value="">
        <input type="hidden" name="mode" value="">



        <?php //if( $H_ID ) { // 로그인 일때만 그룹관리와 Url link 등록이 가능하도록한다. ?>

        <!-- --------------------------------------------------------------------- -->
        <div id="mypanel" class="ddpanel">
            <div id="mypanelcontent" class="ddpanelcontent">
                <!-- --------------------------------------------------------------------- -->
                <!-- <div>
	<div><span style="color:cyan;">&nbsp;user id &nbsp;&nbsp; :</span> <span><input type='text' name='mid' value='' readonly style="background-color:green;color:white;"></span></div>
	<div><span style="color:cyan;">&nbsp;nick name:</span> <span><input type='text' name='nickname' value='' style="background-color:blue;color:yellow;"></span></div>
	<div><span style="color:cyan;">&nbsp;phone no :</span> <span><input type='text' name='phone' value='' style="background-color:blue;color:yellow;"></span></div>
	<div style="color:cyan">About Me:<br>
	   <textarea id='memo' name='memo' rows='3' cols='60' class='form' style="background-color:blue;color:yellow;"></textarea></div>
	<div><input type='button' value=" Save " onClick="update_save()" style="cursor:hand;background-color:yellow;color:black;" title='Change my infomation.'></div>
</div> -->
                <section id="point_adm">
                    <div>
                        <table>
                            <tr>
                                <th scope="row"><label for="mid" style='color:white;'>user id</label></th>
                                <td><input type="text" name="mid" value="<?=$H_ID?>" id="mid"
                                        style="background-color:green;color:white;" readonly></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="name" style='color:white;'>name</label></th>
                                <td><input type="text" name="name" id="name"
                                        style="background-color:blue;color:yellow;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="nickname" style='color:white;'>nickname</label></th>
                                <td><input type="text" name="nickname" id="nickname"
                                        style="background-color:blue;color:yellow;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="email" style='color:white;'>email</label></th>
                                <td><input type="text" name="email" id="email"
                                        style="background-color:blue;color:yellow;" readonly><input type="button"
                                        onclick="select_email()" value="본인인증" <?=$email_btn?>></td>
                            </tr>
                            <tr class='sign_content' style="display:none;">
                                <th scope="row"><label for="email_code" style='color:white;'>인증번호 확인</label></th>
                                <td><input type='text' name='email_code' value=''
                                        style='width:70%;height:<?=$Xheight?>;' placeholder='인증번호를 입력해주세요.'><input
                                        type="button" onclick="email_sign()" value="확인"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="phone" style='color:white;'>phone</label></th>
                                <td><input type="text" name="phone" id="phone"
                                        style="background-color:blue;color:yellow;" readonly><input type="button"
                                        onclick="select_phone()" value="본인인증" <?=$phone_btn?>></td>
                            </tr>
                            <tr class='sign_content2' style="display:none;">
                                <th scope="row"><label for="phone_code" style='color:white;'>인증번호 확인</label></th>
                                <td><input type='text' name='phone_code' value=''
                                        style='width:70%;height:<?=$Xheight?>;' placeholder='인증번호를 입력해주세요.'><input
                                        type="button" onclick="phone_sign()" value="확인"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="zipcode" style='color:white;'>zipcode</label></th>
                                <td><input type="text" name="zipcode" id="zipcode"
                                        style="background-color:blue;color:yellow;" readonly onclick="findAddr()"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="addr1" style='color:white;'>addr1</label></th>
                                <td><input type="text" name="addr1" id="addr1"
                                        style="background-color:blue;color:yellow;" readonly onclick="findAddr()"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="addr2" style='color:white;'>addr2</label></th>
                                <td><input type="text" name="addr2" id="addr2"
                                        style="background-color:blue;color:yellow;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="memo" style='color:white;'>About Me</label></th>
                                <td><textarea id='memo' name='memo' rows='3' cols='60' class='form'
                                        style="background-color:blue;color:yellow;"></textarea></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="SaveMyInfo" style='color:white;'></label></th>
                                <td><input type='button' value=" Save MyInfo " onClick="update_save()"
                                        style="cursor:hand;background-color:yellow;color:black;"
                                        title='Change my infomation.'></td>

                            </tr>

                            <tr>
                                <th scope="row"><label for="password1" style='color:white;'>Password</label></th>
                                <td><input type="Password" name="password1" id="password1"
                                        style="background-color:green;color:white;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="password2" style='color:white;'>Confirm password</label>
                                </th>
                                <td><input type="Password" name="password2" id="password2"
                                        style="background-color:blue;color:yellow;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="SavePassword" style='color:white;'></label></th>
                                <td><input type='button' value=" Save Password " onClick="password_save()"
                                        style="cursor:hand;background-color:yellow;color:black;"
                                        title='Change my infomation.'></td>
                            </tr>

                        </table>
                    </div>

                    <!-- <div>
        <input type='button' value=" Save " onClick="update_save()" style="cursor:hand;background-color:yellow;color:black;" title='Change my infomation.'>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='button' value=" Password ReSet " onClick="password_save()" style="cursor:hand;background-color:yellow;color:black;" title='Change my infomation.' >
    </div> -->

                </section>

            </div>
            <div id="mypaneltab" class="ddpaneltab">
                <a href="#"><span style="border-style:;background-color:;color:yellow;">ReSet Member Info</span> </a>
            </div>
        </div>
        <link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/kancss.css" type="text/css">
        <!-- popup end ------------------------------------------------- -->
        <?php

		$ls = " SELECT * from {$tkher['tkher_member_table']} WHERE mb_id='$H_ID'";
		$result = sql_query( $ls );


		if( $H_ID ) $g_nameX = " level:" . $member['mb_level'] . "," .$member['mb_email'];
?>

        <tr>
            <td bgcolor='#f4f4f4' align='center' colspan=7>
                <font color='black'>&nbsp;<?=$g_nameX?>
                    <!--  [count:<?=$total?>] -->
            </td>
        </tr>
        <!-- , *User name: <input type='text' name='mb_name' id='mb_name' > <input type='button' value='Search' id='Search' > -->
        <table class='floating-thead' width='100%'>
            <thead width='100%'>
                <tr style='color:black;' align='center'>
                    <TH style='color:white;'>no</TH>
                    <TH style='color:white;'>user id</TH>
                    <TH style='color:white;'>sns</TH>
                    <TH style='color:white;'>name</TH>
                    <TH style='color:white;'>nick name</TH>
                    <TH style='color:white;'>email</TH>
                    <TH style='color:white;'>phone</TH>
                    <TH style='color:white;'>zipcode</TH>
                    <TH style='color:white;'>addr1</TH>
                    <TH style='color:white;'>addr2</TH>
                    <TH style='color:white;'>login date</TH>
                    <TH style='color:white;'>confirm datetime</TH>
                    <TH style='color:white;'>point</TH>
                    <TH style='color:white;'>memo</TH>
                    <TH>management</TH>
                </tr>

            </thead>
            <tbody width='100%'>

                <?php
	$ls = " SELECT * from {$tkher['tkher_member_table']} WHERE mb_id='$H_ID' ";
	$result = sql_query(  $ls );
	$aaa = 0;
	$line = 0;
	$i=1;
	$limite = 15; 
	while ( $rs = sql_fetch_array( $result ) ) {
		$line = $limite*$page + $i - $limite;
		//$line++;
			//no, user id, mb_sn, name, nick name, email, phone, login date, datetime, point
			// style='background-color:#FFFFFF' align='center'
?>
                <input type="hidden" name="mb_no" value="<?=$rs['mb_no']?>">
                <tr>
                    <td><?=$line?></td>
                    <td><?=$rs['mb_id']?></td>
                    <td><?=$rs['mb_sn']?></td>
                    <td><?=$rs['mb_name']?></td>
                    <td><?=$rs['mb_nick']?></td>
                    <td><?=$rs['mb_email']?></td>
                    <td><?=$rs['mb_hp']?></td>
                    <td><?=$rs['mb_zip1']?></td>
                    <td><?=$rs['mb_addr1']?></td>
                    <td><?=$rs['mb_addr2']?></td>
                    <td><?=$rs['mb_today_login']?></td>
                    <!-- <td><?=$rs['mb_datetime']?></td> -->
                    <td><?=$rs['mb_email_certify']?></td>
                    <td><?=number_format($rs['mb_point'])?></td>
                    <td><textarea name="memoA" cols="30" rows="2" readonly><?=$rs['mb_memo']?></textarea></td>
                    <?php
	$mid=$rs['mb_id'];$no=$rs['mb_no']; $point=$rs['mb_point'];
	$nickname=$rs['mb_nick'];$phone=$rs['mb_hp'];$email=$rs['mb_email'];
	$name = $rs['mb_name'];
    $zip = $rs['mb_zip1'];
    $addr1 = $rs['mb_addr1'];
    $addr2 = $rs['mb_addr2'];
?>
                    <td>
                        <input type='button' style="cursor:hand;" value="ReSet"
                            onClick="member_set('<?=$aaa?>','<?=$no?>','<?=$mid?>','<?=$name?>','<?=$email?>','<?=$phone?>','<?=$nickname?>', '<?=$zip?>', '<?=$addr1?>', '<?=$addr2?>')"
                            title='set:<?=$point?>:<?=$no?>:<?=$rs['mb_id']?> '>
                    </td>
                </tr>
                <input type='hidden' name='msg_<?=$aaa?>' value="<?=$rs['mb_memo']?>">


                <?php
			$aaa = $aaa +1;
			$i++;
		}	//Loop
		?>


                </td>
                </tr>

                <tr align="center"></tr>
            </tbody>
        </table>
        <div style="font-size:18;text-align:center;"></div>

    </form>

</body>
<script>
// 이메일 조회
function select_email() {
    if (!document.member_form.email.value) {
        alert("이메일을 입력해주세요.");
        document.member_form.email.focus();
        return;
    } else {
        var emailVal = document.member_form.email.value;

        var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;

        if (emailVal.match(regExp) != null) { // 이메일 유효성 확인 정규식
            $.ajax({ // 이메일 체크
                type: "post",
                dataType: "json",
                data: {
                    "mode": "email",
                    "name": JSON.stringify(document.member_form.name.value),
                    "email": JSON.stringify(document.member_form.email.value)
                },
                url: "./email_search.php",
                success: function(data) {
                    if (data) {
                        $.ajax({
                            type: "post",
                            dataType: "json",
                            data: {
                                "mode": "email_sign",
                                "email": JSON.stringify(document.member_form.email.value)
                            },
                            url: "<?=KAPP_URL_?>/modu_shop/code_create_email.php",
                            success: function(data) {

                                alert("본인 확인을 위해 이메일로 인증번호를 보냈습니다.");
                                $('.sign_content').show();
                                return;
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('이메일 발송에 실패했습니다.');
                                console.log(jqXHR);
                                console.log(textStatus);
                                console.log(errorThrown);
                                return;
                            }
                        });

                    } else {
                        //document.member_form.user_email.value = '';
                        alert("이메일 정보가 일치하지 않습니다.");
                        return;
                    }
                },
                error: function() {
                    //console.log('통신실패!!');
                    alert('서버와의 통신에 실패했습니다.');
                    return;
                }
            });

        } else {
            alert('이메일의 형태가 올바르지 않습니다.');
            document.member_form.email.focus();
            return;
        }
    }
}

// 연락처 조회
function select_phone() {
    if (!document.member_form.name.value) {
        alert("이름을 입력해주세요.");
        document.member_form.name.focus();
        return;
    }

    if (!document.member_form.phone.value) {
        alert("연락처를 입력해주세요.");
        document.member_form.phone.focus();
        return;
    } else {

        //var regExp = /01[016789]-[^0][0-9]{2,3}-[0-9]{3,4}/;

        $.ajax({ // 연락처 체크
            type: "post",
            dataType: "json",
            data: {
                "mode": "phone",
                "name": JSON.stringify(document.member_form.name.value),
                "phone": JSON.stringify(document.member_form.phone.value)
            },
            url: "./phone_search.php",
            success: function(data) {
                if (data) {
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        data: {
                            "mode": "phone_sign",
                            "phone": JSON.stringify(document.member_form.phone.value)
                        },
                        url: "<?=KAPP_URL_?>/modu_shop/code_create_phone.php",
                        success: function(data) {

                            alert("본인 확인을 위해 연락처로 인증번호를 보냈습니다.");
                            $('.sign_content2').show();
                            return;
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('문자 메세지 전송에 실패했습니다.');
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                            return;
                        }
                    });

                } else {
                    //document.member_form.user_phone.value = '';
                    alert("연락처 정보가 일치하지 않습니다.");
                    return;
                }
            },
            error: function() {
                //console.log('통신실패!!');
                alert('서버와의 통신에 실패했습니다.');
                return;
            }
        });

    }
}

// 이메일 인증
function email_sign() {
    if (!document.member_form.email_code.value) {
        alert("인증 번호를 입력해주세요.");
        document.member_form.email_code.focus();
        return;
    }

    $.ajax({
        type: "post",
        dataType: "json",
        data: {
            "mode": "email_sign",
            "mb_id": JSON.stringify(document.member_form.mb_id.value),
            "email": JSON.stringify(document.member_form.email.value),
            "code": JSON.stringify(document.member_form.email_code.value)
        },
        url: "./email_sign.php",
        success: function(data) {
            //var data2 = JSON.parse(data.response);
            /* console.log(data);
            sign_id = data.serialNo;
            sign_code = data.code; */
            //console.log(data);
            if (data.message == 'sign') {
                alert("인증되었습니다.");
                return;
            } else if (data.message == 'null_email') {
                alert("이메일이 일치하지 않습니다.");
                return;
            } else if (data.message == 'null_code') {
                alert("코드가 일치하지 않습니다.");
                return;
            } else if (data.message == 'sql_error') {
                alert("DB 저장에 문제가 발생했습니다.");
                return;
            } else if (data.message == 'error') {
                alert("예상치 못한 문제가 발생했습니다.");
                return;
            }
        },
        error: function() {
            alert('서버와의 통신에 실패했습니다.');
            return;
        }
    });

}

// 휴대폰 인증
function phone_sign() {
    if (!document.member_form.phone_code.value) {
        alert("인증 번호를 입력해주세요.");
        document.member_form.phone_code.focus();
        return;
    }

    $.ajax({
        type: "post",
        dataType: "json",
        data: {
            "mode": "phone_sign",
            "mb_id": JSON.stringify(document.member_form.mb_id.value),
            "phone": JSON.stringify(document.member_form.phone.value),
            "code": JSON.stringify(document.member_form.phone_code.value)
        },
        url: "./phone_sign.php",
        success: function(data) {
            //var data2 = JSON.parse(data.response);
            /* console.log(data);
            sign_id = data.serialNo;
            sign_code = data.code; */
            if (data.message == 'sign') {
                alert("인증되었습니다.");
                return;
            } else if (data.message == 'null_phone') {
                alert("연락처가 일치하지 않습니다.");
                return;
            } else if (data.message == 'null_code') {
                alert("코드가 일치하지 않습니다.");
                return;
            } else if (data.message == 'sql_error') {
                alert("DB 저장에 문제가 발생했습니다.");
                return;
            } else if (data.message == 'error') {
                alert("예상치 못한 문제가 발생했습니다.");
                return;
            }
        },
        error: function() {
            alert('서버와의 통신에 실패했습니다.');
            return;
        }
    });

}

function findAddr() { // 다음 주소 API
    new daum.Postcode({
        oncomplete: function(data) {

            var roadAddr = data.roadAddress; // 도로명 주소 변수
            var jibunAddr = data.jibunAddress; // 지번 주소 변수

            document.getElementById('zipcode').value = data.zonecode;
            if (roadAddr !== '') {
                document.getElementById("addr1").value = roadAddr;
                document.getElementById("addr2").value = '';
            } else if (jibunAddr !== '') {
                document.getElementById("addr1").value = jibunAddr;
                document.getElementById("addr2").value = '';
            }

        }
    }).open();
}

/* function reset_email() {
    document.member_form.user_email.value = '';
}

function reset_phone() {
    document.member_form.user_phone.value = '';
} */
</script>

</html>