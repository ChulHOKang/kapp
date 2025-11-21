<?php  
    include_once('./tkher_start_necessary.php');
	if( isset($member['mb_id'] )  ) {
		$H_ID	= $member['mb_id'];
		$_LEVEL	= $member['mb_level'];
	} else {
		m_("login please!");
		exit;
	}
	/*
	$menu1TWPer=30;  
	$menu1AWPer=100 - $menu1TWPer;  
	$Xwidth='100%';  
	$Xheight='100%';  */
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

.viewSubjX2 {
    width: 100%;
    height: 35px;
    line-height: 32px;
    border-top: 3px solid #d01c27;
    text-align: center;
    background: #fafafa;
    overflow: hidden;
    font-size: 18px;
    color: #69604f;
    margin-bottom: -2px;
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
    width: auto;
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

.btn_tab {
    width: 30%;
    height: 100%;
    display: inline-block;
    text-align: center;
    color: #fff;
    font-size: 14px;
    background: #d01d27;
}
</style>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
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
</script>
<script>
jQuery(document).ready(function ($) {

	$('#update_server').on('click', function() {		//alert('버튼 클릭됨');
		var admin_level = $("#admin_level").val();
		if( admin_level < 8 ) {
			alert(" admin level! No permission");
			return;
		}
		var server_name = $("#server_name").val();
		alert("server_name: " + server_name);//server_name: https://modumodu.net/biog7/kapp

		var server_sel = $("#server_sel").val();
		var admin_id = $("#admin_id").val();
		var admin_password = $("#admin_password").val();

		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'curl_server_ajax.php',
				data: {
					"mode_update": 'server_update',
					"server_name": server_name,
					"admin_id": admin_id,
					"admin_level": admin_level,
					"admin_password": admin_password,
					"server_url": server_sel,
				},
			success: function(data) {
					//console.log(data);
					alert(data);
					//location.replace( location.href );
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("ERROR - data type, or URL or admin_id confirm. -- curl_server_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
	});

});
</script>

</head>

<?php
	function Server_get(){
		global $H_ID, $H_EMAIL, $tkher;
		global $kapp_mainnet;
		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['server']      = KAPP_URL_T_;
		$tabData['data'][$cnt]['email']       = $H_EMAIL;
		$tabData['data'][$cnt]['user_ip']     = $_SERVER['REMOTE_ADDR'];
		$tabData['data'][$cnt]['up_day']      = date("Y-m-d H:i:s",time());
		//$count = count($tabData['data']);	//m_( "--- count:" . $count ); // 10
		$key = 'appgenerator';
		$iv = "~`!@#$%^&*()-_=+";
		$sendData = encryptA( $tabData , $key, $iv);
		$url_ = $kapp_mainnet . '/_Curl/DB_Server_get.php'; //$url_=$config['kapp_theme'] . '/_Curl/Link_Table_curl_get_ailinkapp.php'; 
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);

		if( $res == false) {
			$_ms = "new Server_get fail : " . curl_error($curl);
			echo 'curl : ' . $_ms;
		} else {
			$_ms = 'new Server_get curl OK : ' . $res;
		}
		curl_close($curl);
		return $res;
	}
		$response = Server_get(); // fation.net 의 curl server data list call
		$server_ = explode('|', $response);

		if( isset($_POST['admin_id']) ) $admin_id = $_POST['admin_id'];
		else $admin_id='';
?>

<body width=100%>
    <center>
        <div class="HeadTitle01AX">
            <P href='#' class='on' title='data shared Server'>Set up a shared remote Server URL</P><!-- 공유 원격 Server URL 설정 -->
        </div>
        <br>
        <div class='boardViewX'>
            <div class='viewHeader'></div>
            <div class='viewSubjX'></div>
            <div class='blankA'> </div>
            <form name='makeform' action='' method='post' enctype='multipart/form-data' onsubmit='return check(this)'>
                <input type='hidden' name='mode' value='' />
                <input type='hidden' id='server_name' name='server_name' value='<?=KAPP_URL_T_?>' />
                <input type='hidden' id='admin_level' name='admin_level' value='<?=$_LEVEL?>' />
                <div class="email_sign">
                    <div class='menu1T' align='center'><span style='width:100%;height:100%;' title='Administrator during installation ID'>Admin Email</span>
                    </div>
                    <div class='menu1A'><input type='CHAR' id='admin_id' name='admin_id' value='<?=$admin_id?>'
                            style='width:100%;height:100%;' placeholder='Please enter the administrator ID during installation..'></div>
                    <div class='blankA'> </div>
                    <div class='menu1T' align='center'><span
                            style='width:100%;height:100%;'>Admin Password</span>
                    </div>
                    <div class='menu1A'><input type='password' id='admin_password' name='admin_password' value=''
                            style='width:100%;height:100%;'
                            placeholder='Use your password safely'>
                    </div>
                    <input type='hidden' name='mb_password_enc' value=''>
                    <div class='blankA'> </div> 
                    <div class='menu1T' align='center'><span style='width:100%;height:100%;'>Serve URL</span>
                    </div>
                    <div class='menu1A'>
						<SELECT  id="server_sel" name="server_sel" style='border-style:;height:100%; text-align: center;'>
                            <option value='' >Select Server</option>
							<option value='' selected>I don't share.</option>
<?php
$kapp_theme = explode(  '^', $config['kapp_theme']);
							for($i=0; isset($server_[$i]) && $server_[$i]!==''; $i++){
								$selected = '';
								if( isset($kapp_theme[0]) && $kapp_theme[0] == $server_[$i] ) $selected = 'selected';
								echo "<option value= '".$server_[$i]."' " . $selected ." >".$server_[$i]."</option>";
							}
?>
                        </SELECT>
                    </div>

                    <div class='blankA'> </div>
                    <div class='blankA'> </div>
                    <div class='viewHeader' style="text-align:center;">
						<input type='button' value='Server-Update' id="update_server" onclick="javascript:update_server();" title="Server Change!" class="Btn_List01A">
                    </div>
                </div>
            </form>
        </div>
</body>
</html>