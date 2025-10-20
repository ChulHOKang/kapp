<?php
/*
$path = array();
$path['root'] = $_SERVER['DOCUMENT_ROOT'].'/contents/'; // $_SERVER['DOCUMENT_ROOT'] : /home1/coin24ckr/public_html  
$url = array();
$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
$url['root'] = $http . $_SERVER['HTTP_HOST'] . '/contents/'; // $url['root'] = 'http://'.$_SERVER['HTTP_HOST'].'/contents/'; 
*/

?>
<HTML>
    <HEAD>
        <TITLE>Basic design</TITLE>
        <meta charset="utf-8">
        
        <link href="./css/main.css" rel="stylesheet">
		<link rel="stylesheet" href="./css/editor.css" type="text/css" charset="utf-8"/>
		<script src="./js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>

    </HEAD>
    <BODY>
	<!-- <div class="header">
            <a href="https://<?php echo $_SERVER['HTTP_HOST'];?>/Tboard">홈</a> <a href="https://<?php echo $_SERVER['HTTP_HOST'];?>/contents/menu/list.php?page=<?=$_REQUEST['page']?>" title="page:<?=$_REQUEST['page']?>">글목록</a> <a href="https://<?php echo $_SERVER['HTTP_HOST'];?>/contents/menu/write.php">글쓰기</a><br />
            로그인 상태: 
            <?php if($_SESSION['is_logged']=='YES') {
                echo '로그인 되었습니다. '; 
                echo '<a href="https://'.$_SERVER['HTTP_HOST'].'/contents/member/logout.php">로그아웃</a>'; 
            }
                ?>
	</div> --><!-- .header -->
	<!-- <div class="content"> -->
