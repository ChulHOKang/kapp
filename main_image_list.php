<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Tkher system for special her. Tkher system is generator program. Made in ChulHo Kang</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<link rel="stylesheet" href="./include/css/common.css" type="text/css" />
<script type="text/javascript" src="./include/js/ui.js"></script>
<script type="text/javascript" src="./include/js/common.js"></script>

<body>
<?php
		/*
		*   album.php : main_image_list.php 메인 이미지 Lsit - 이미지 슬라이드.
		*/
		$mode = $_POST['mode'];
?>
<center>
		<div class="mainProjectX" id="mainProjectX">
			<h2 <?php echo "title='Get and print a database file.'"; ?> >TKHER Main Image List</h2>
		<?php 
		$cur='C';
		include "./menu_run.php"; 
		?>
			<div class="grid">

<?php
				$SQL = " SELECT * from {$tkher['tkher_main_img_table']} order by view_no, no";
				if ( ($result = sql_query( $SQL ) )==false )
				{
				  printf("Invalid query: %s ",  $SQL);
				  exit();
				} else {
					$num=0;
					while( $row = sql_fetch_array($result)  ) {
						$num++;
						$group_name = $row['group_name'];
						$jpg_file = $row['jpg_file'];
						$jpg_name = $row['jpg_name'];
						$jpg_memo = $row['jpg_memo'];

						echo "<div class='element-item $group_name pop_$num pop' data-category='$group_name'>
								<a href=\"javascript:void(0);\"  >
								<span class='img'><img src='./data/main_scroll_image/".$row['jpg_file']."' width='300' height='200' title='$jpg_file'></span>
								<span class='subj'>$jpg_name</span>
								<span class='txt'>$jpg_memo</span>
								</a>
							  </div>";
					}
				}
?>
			</div>
<?php
		include "./view_v.php";
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