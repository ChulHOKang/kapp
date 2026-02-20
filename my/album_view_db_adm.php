<?php
	include_once('../tkher_start_necessary.php');
?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="./icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>

<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/common.js"></script>
<link rel='stylesheet' href='<?=KAPP_URL_T_?>/include/css/kancss.css' type='text/css'>

<body>
<?php
		/*
		*   album_view_db_my.php : my image, : table : tkher_main_img
		    - view_db_my.php
		*/
		$H_ID = get_session("ss_mb_id");  
		if( isset($member['mb_level']) ) $H_LEV	= $member['mb_level'];
		else $H_LEV =''; 

		if( isset($_POST['mode']) ) $mode = $_POST['mode'];
		else $mode ='';
?>
<center>
		<div class="mainProjectX" id="mainProjectX">
			<h2>ALBUM of Admin</h2>
			<div class="grid">
<?php
				$SQL = " SELECT * from {$tkher['tkher_main_img_table']} where group_name!='main' and group_name!='shop' order by userid, view_no, no";
				if ( ($result = sql_query( $SQL ) )==false )
				{
				  printf("Invalid query: %s ",  $SQL);
				  exit();
				} else {
					$num=0;
					while( $row = sql_fetch_array($result)  ) {
						$num++;
						$group_name = $H_ID;
						$userid = $row['userid'];
						$jpg_file = $row['jpg_file'];
						$f_path = KAPP_URL_T_ . "/file/" . $userid . "/" . $row['jpg_file'];
						$jpg_name = $row['jpg_name'];
						$jpg_memo = $row['jpg_memo'];
						echo "<div class='element-item $group_name pop_$num pop' data-category='$group_name'>
								<a href=\"javascript:void(0);\"  >
								<span class='img' ><img title='$userid, db:$f_path' src='$f_path' width='300' height='200' ></span>
								<span class='subj' title='$userid, db:$f_path' >$jpg_name</span>
								<span class='txt'>$jpg_memo</span>
								</a>
							  </div>";
					}
				}
?>
			</div>
<?php
		include "./view_db_all.php";
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