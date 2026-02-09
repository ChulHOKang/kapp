<?php  
    include_once('../tkher_start_necessary.php');

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
    if( $mode == 'next_input') {
        set_cookie('add_admin_info', 'next', 43200); // 12시간 저장
        //echo "<script>window.close();</script>";
        //echo "<script>window.open('', '_self').close();</script>";
        //exit;
    }

	$menu1TWPer=25;  
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
<link rel="stylesheet" href="../include/css/kapp_basic.css" type="text/css">

<!-- <link rel="stylesheet" href="../include/css/kapp_add_admin_infor.css" type="text/css"> -->

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script type="text/javascript">

let email_code = '';
let phone_code = '';

function record_modify() {
    if (!document.makeform.mb_name.value) {
        alert("이름을 입력해주세요.");
        document.makeform.mb_name.focus();
        return;
    }
    if (!document.makeform.mb_password.value || !document.makeform.mb_password2.value) {
        alert("비밀번호를 입력해주세요.");
        return;
    } else {
        if (!Validation_password()) { // 비밀번호 유효성 검사
            alert("비밀번호는 영문자+숫자+특수문자 조합으로 8~25자를 사용해야 합니다.");
            document.makeform.mb_password.focus();
            return;
        }
    }
    if (document.makeform.mb_password.value != document.makeform.mb_password2.value) {
        alert("비밀번호가 일치하지 않습니다.");
        document.makeform.mb_password2.focus();
        return;
    }
    if (!document.makeform.mb_hp.value) {
        alert("연락처를 입력해주세요.");
        document.makeform.mb_hp.focus();
        return;
    } else {
        Tel_number(); // - 문자 제거
    }
    if (!document.makeform.mb_birth.value) {
        alert("생년월일을 입력해주세요.");
        document.makeform.mb_birth.focus();
        return;
    } else {
        Birth_number(); // - 문자 제거
    }
    /*
	if (!document.makeform.mb_zip1.value) {
        alert("우편번호를 입력해주세요.");
        document.makeform.mb_zip1.focus();
        return;
    }
    if (!document.makeform.mb_addr1.value) {
        alert("주소를 입력해주세요.");
        document.makeform.mb_addr1.focus();
        return;
    }*/

    /* document.makeform.mb_password_enc.value = CryptoJS.MD5(document.makeform.mb_password.value);
    document.makeform.mb_password2_enc.value = CryptoJS.MD5(document.makeform.mb_password2.value); */

    document.makeform.mode.value = 'add_admin_info'
    document.makeform.action = 'add_admin_info_r.php';
    document.makeform.submit();
}

function Validation_password() {
    var pwdCheck = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,25}$/;

    if (!pwdCheck.test(document.makeform.mb_password.value)) {
        return false;
    } else {
        return true;
    }
}

function Tel_number() {
    document.makeform.mb_hp_number.value = document.makeform.mb_hp.value.replace(/-/g, "");
}

function Birth_number() {
    document.makeform.mb_birth_number.value = document.makeform.mb_birth.value.replace(/-/g, "");
}

function Close() {
    window.open('', '_self').close();
}

function findAddr() { // 다음 주소 API
    new daum.Postcode({
        oncomplete: function(data) {

            var roadAddr = data.roadAddress; // 도로명 주소 변수
            var jibunAddr = data.jibunAddress; // 지번 주소 변수

            document.getElementById('member_post').value = data.zonecode;
            if (roadAddr !== '') {
                document.getElementById("member_addr").value = roadAddr;
            } else if (jibunAddr !== '') {
                document.getElementById("member_addr").value = jibunAddr;
            }

        }
    }).open();
}

function Next_input() {
    document.makeform.mode.value = 'next_input'
    document.makeform.action = '../add_info.php';
    document.makeform.submit();
}

/* function tab_pg_list($pg_code) {
    document.tkher_form.action = 'ksd39673976_1704690698_run.php?pg_code=' + $pg_code;
    document.tkher_form.submit();
} */
</script>
</head>

<body width='100%'>
    <center>
        <div class="HeadTitle01AX">
            <P href='#' class='on' title='table code:ksd39673976_1694494339 , program name:adm/add_admin_info'>Admin Config Additional information</P>
        </div>
        <br>
        <div class='boardViewX'>
            <div class='viewHeader'>

            </div>
            <div class='viewSubjX'></div>
            <div class='blankA'> </div>
            <form name='makeform' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>
                <input type=hidden name='mode' value='' />
                <div class="email_sign">
                    <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Name</span></div>
                    <div class='menu1A'><input type='CHAR' name='mb_name' value='<?=$member['mb_name']?>' style='width:70%;height:<?=$Xheight?>;' placeholder='Name.'></div>
                    <div class='blankA'> </div>
                    <div class='menu1T' align=center><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Email</span></div>
                    <div class='menu1A'><input type='CHAR' name='mb_email' value='<?=$member['mb_email']?>' style='width:70%;height:<?=$Xheight?>;' placeholder='Email.'></div>
                    <div class='blankA'> </div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Password</span>
                    </div>
                    <div class='menu1A'><input type='password' name='mb_password' value='' style='width:90%;height:<?=$Xheight?>;' placeholder='Password 8~25.'>
                    </div>
                    <input type='hidden' name='mb_password_enc' value=''>
                    <div class='blankA'> </div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Password confirm</span>
                    </div>
                    <div class='menu1A'><input type='password' name='mb_password2' value='' style='width:90%;height:<?=$Xheight?>;' placeholder='Password 8~25.'>
                    </div>
                    <input type='hidden' name='mb_password2_enc' value=''>
                    <div class='blankA'> </div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Phone no</span>
                    </div>
                    <div class='menu1A'><input type='text' name='mb_hp' value='<?=$member['mb_hp']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='Phone no .'>
                    </div>
                    <input type='hidden' name='mb_hp_number' value='<?=$member['mb_hp']?>'>
                    <div class='blankA'> </div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>Sex</span>
                    </div>
                    <div class='menu1A'>
						<SELECT SIZE='1' name="mb_sex" style='border-style:;height:25; text-align: center;'>
							<option value='M' selected>Male</option>
                 <?php
                            if( $member['mb_sex'] == 'F') $selected = 'selected';
							else $selected = '';
                  ?>
                            <option value='F' <?=$selected?>>Female</option>
                        </SELECT>
                    </div>
                    <div class='blankA'></div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>birth date</span></div>
                    <div class='menu1A'><input type='text' name='mb_birth' value='<?=$member['mb_birth']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='0000-00-00'></div>
                    <input type='hidden' name='mb_birth_number' value=''>

                    <div class='blankA'></div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_googl_shorturl_apikey</span></div>
                    <div class='menu1A'><input type='text' name='kapp_googl_shorturl_apikey' value='<?=$config['kapp_googl_shorturl_apikey']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='kapp_googl_shorturl_apikey'></div>


                    <div class='blankA'></div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_kakao_js_apikey</span></div>
                    <div class='menu1A'><input type='text' name='kapp_googl_shorturl_apikey' value='<?=$config['kapp_kakao_js_apikey']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='kapp_kakao_js_apikey'></div>


                    <div class='blankA'></div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_naver_client_id</span></div>
                    <div class='menu1A'><input type='text' name='kapp_googl_shorturl_apikey' value='<?=$config['kapp_naver_client_id']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='kapp_naver_client_id'></div>

                    <div class='blankA'></div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>kapp_naver_client_secret</span></div>
                    <div class='menu1A'><input type='text' name='kapp_googl_shorturl_apikey' value='<?=$config['kapp_naver_client_secret']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='kapp_naver_client_secret'></div>

					<!-- <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>우편번호</span>
                    </div>
                    <div class='menu1A'>
					 <input id="member_post" type='number' name='mb_zip1' value='<?=$member['mb_zip1']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='우편번호를 입력해주세요.' readonly onclick="findAddr(0)"></div>
                    <div class='blankA'> </div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>주소</span>
                    </div>
                    <div class='menu1A'><input id="member_addr" type='text' name='mb_addr1' value='<?=$member['mb_addr1']?>' style='width:90%;height:<?=$Xheight?>;' placeholder='주소를 입력해주세요.' readonly onclick="findAddr(0)"></div>
                    <div class='blankA'> </div>
                    <div class='menu1T' align='center'><span style='width:<?=$Xwidth?>;height:<?=$Xheight?>;'>상세주소</span>
                    </div>
                    <div class='menu1A'><input type='text' name='mb_addr2' value='<?=$member['mb_addr2']?>'
                            style='width:90%;height:<?=$Xheight?>;' placeholder='상세주소를 입력해주세요.'></div>
                    <div class='blankA'> </div> -->
                    <div class='blankA'> </div>
                    <div class='viewHeader' style="text-align:center;">
                        <input type=button value='Submit' onclick="record_modify()" class="Btn_List01A">
                        <input type=button value='Enter next' onclick="Next_input()"  class="kapp_btn_bo02">
                    </div>
                </div>
            </form>
        </div>
</body>

</html>