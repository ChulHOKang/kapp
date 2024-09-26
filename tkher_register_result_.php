<?php
	include_once('./tkher_start_necessary.php');
?>

<html>

<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
    <TITLE>KAPP is App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
    <link rel="shortcut icon" href="./logo/logo25a.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="keywords"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
    <meta name="description"
        content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
    <meta name="robots" content="ALL">
    <script type="text/javascript" src="./include/js/common.js"></script>
</head>
<?php
	if( isset($_SESSION['ss_mb_reg']))
		$mb = get_member($_SESSION['ss_mb_reg']);

	if( !$mb['mb_id']){
		goto_url(KAPP_URL_T_);
	}

	$tkher['title'] = 'Sign up is complete.';
?>
<!-- <link rel="stylesheet" href="./tkher_style.css">
    <link rel="stylesheet" href="./tkher_mobile.css"> -->

<div id="logo" align=center style='height:100px;background-color:black;color:white;border:1 solid black'>
    <a href="./"><img src="./logo/logo512-512.png" width=100 title="KAPP"></a>
</div>
<div id="reg_result" class="mbskin">

    <p>
        <strong><?php echo get_text($mb['mb_name']); ?></strong> Congratulations on your membership. <br> 회원가입을 진심으로
        축하합니다.<br>
    </p>

    <?php //if( $config['kapp_use_email_certify']) { ?>
    <!-- <p>
            A verification email has been sent to the email address you entered when registering.<br>
            You can access the site after confirming the authentication e-mail sent and processing the
            authentication.<br>
            <br>
            회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>
            발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.
        </p> -->
    <div id="result_email">
        <span>ID:</span>
        <strong><?php echo $mb['mb_id'] ?></strong><br>
        <span>E-mail:</span>
        <strong><?php echo $mb['mb_email'] ?></strong>
    </div>
    <?php //} ?>

    <div class="btn_confirm">
        <a href="/shop" target='_top'>go Biog</a>
    </div>

</div>

<script>
delete_cookie("mb_level");
</script>