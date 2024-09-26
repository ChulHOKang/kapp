<?php
	include_once('../tkher_start_necessary.php');
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/common.js"></script>

<link rel='stylesheet' href='<?=KAPP_URL_T_?>/include/css/kancss.css' type='text/css'>  <!-- 중요! menu_run.php 막으면 필요함.-->

<body>
<?php
		/*
		*   album_view_db_my.php : my image, : table : tkher_main_img
		    - view_db_my.php
		*/
		$H_ID = get_session("ss_mb_id");  
		if( isset($member['mb_level']) ) $H_LEV	= $member['mb_level'];
		else $H_LEV =''; 

		if( isset($_POST['mode']) ) $mode = $_POST['mode']; //m_("mode: " . $mode);
		else $mode ='';
?>
<center>
		<div class="mainProjectX" id="mainProjectX">
			<h2 <?php echo "title='Get and print a database file'"; ?> >TKHER ALBUM MY</h2><!--  \n 데이터베이스 화일을 가져와 출력한다. -->
<?php 
		$cur='B';
//		include "../menu_run.php"; 
?>
			<div class="grid">
<?php
				$SQL = " SELECT * from {$tkher['tkher_main_img_table']} where userid='$H_ID' order by view_no, no";
				if ( ($result = sql_query( $SQL ) )==false )
				{
				  printf("Invalid query: %s ",  $SQL);
				  exit();
				} else {
					$num=0;
					while( $row = sql_fetch_array($result)  ) {
						$num++;
						$group_name = $H_ID;//$row['group_name'];
						$jpg_file = $row['jpg_file'];
						$f_path = KAPP_URL_T_ . "/file/" . $H_ID . "/" . $row['jpg_file'];
						//$f_path = KAPP_TATH_T_ . "/file/" . $H_ID . "/" . $row['jpg_file'];
						$jpg_name = $row['jpg_name'];
						$jpg_memo = $row['jpg_memo'];
						echo "<div class='element-item $group_name pop_$num pop' data-category='$group_name'>
								<a href=\"javascript:void(0);\"  >
								<span class='img'  title='db:$f_path'><img src='$f_path' width='300' height='200' ></span>
								<span class='subj'>$jpg_name</span>
								<span class='txt'>$jpg_memo</span>
								</a>
							  </div>";
					}
				}
?>
			</div>
<?php
 //https://ailinkapp.com/var/www/html/t/file/dao/bg_proj04.jpg
 //data/main_scroll_image

		include "./view_db_my.php"; //click and run page
?>
 <script type="text/javascript">
	$('.pop').click(function(){
		var index = $('.pop').index();
		var num = $(this).index();
		 $('.workView').eq(num).show();
	})
	$('.whleft').click(function(){
		$('.workView').fadeOut();
	})

	$('.nextwork').click(function(){
		var next = $(this).index()
		$('.workView').fadeOut();
		$(this).parent().parent().parent().next().fadeIn();
	})
</script>

</body>
</html>