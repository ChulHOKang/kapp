<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");
	connect_count($host_script, $H_ID, 0, $referer);
	/*  
		kapp_member.php : Manager
	*/
	$day = date("Y-m-d H:i:s");
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';

	if( isset($_POST['mb_no']) ) $mb_no = $_POST['mb_no'];
	else $mb_no = '';

	if( $member['mb_level'] < 8) {
		m_("admin page m");
		echo("<meta http-equiv='refresh' content='0; URL=/'>"); exit;
	} else {
		if( $mode == "Change"){ // 준비.
			$sql = "update {$tkher['tkher_member_table']} set mb_memo='".$_POST['memo']."', mb_nick='".$_POST['nickname']."', mb_hp='".$_POST['phone']."' where mb_no=" . $mb_no;
			$result = sql_query( $sql );
			if( $result ) m_("OK");
			else {
				m_("Error");
				echo "error update"; exit;
			}
		}
	}
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

<style>
table { border-collapse: collapse; }
/*th { background: #cdefff; height: 32px; } */
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }

	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		/*flex-direction: row;*/							/* row, row-reverse, column, column-reverse */
		/*flex-wrap: nowrap;*/							/* nowrap, wrap, wrap-reverse */
		justify-content: space-between;		/* flex-start, flex-end, center, space-between, space-around */
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
		align-items: center;							/* flex-start, flex-end, center, baseline, stretch */
		height:25px;

	}
	.item {
		background-color: gold;
		boarder: 1px solid gray;
	}

</style>

<script src="//code.jquery.com/jquery.min.js"></script>
<script>
$(function () {
  $('table.floating-thead').each(function() {
    if( $(this).css('border-collapse') == 'collapse') {
      $(this).css('border-collapse','separate').css('border-spacing',0);
    }
    $(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
  });

  $(window).scroll(function() {
    var scrollTop = $(window).scrollTop(),
      scrollLeft = $(window).scrollLeft();
    $('table.floating-thead').each(function(i) {
      var thead = $(this).find('thead:last'),
        clone = $(this).find('thead:first'),
        top = $(this).offset().top,
        bottom = top + $(this).height() - thead.height();

      if( scrollTop < top || scrollTop > bottom ) {
        clone.hide();
        return true;
      }
      if( clone.is('visible') ) return true;
      clone.find('th').each(function(i) {
        $(this).width( thead.find('th').eq(i).width() );
      });
      clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
    });
  });
});
</script>

<!-- <link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script> -->

<?php
	if( isset($_POST['sdata']) ) $sdata = $_POST['sdata'];
	else $sdata = '';
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;

?>
<script language='javascript'>
<!--
	function check_enter() { if (event.keyCode == 13) { search_func(); } }
	function search_func() {
		form = document.member_form;
		if(!form.mb_name.value) {
			alert('Enter the name to search and press the search button worm! '); //검색할 명을 입력하시고 검색버턴울 눌러주세요!
			form.mb_name.focus();
			return;
		}
		form.mode.value="search_rtn";
		form.submit();
	}
	function member_set(i, n, id, ph, e, nick) {
		msg = eval( "document.member_form.msg_"+i+".value");
		document.member_form.mb_no.value = n;
		document.member_form.mid.value = id;
		document.member_form.nickname.value = nick;
		document.member_form.phone.value = ph;
		document.member_form.memo.value = msg;
	}
	function update_save(){
		document.member_form.mode.value = "Change";
		document.member_form.action = "kapp_member.php";
		document.member_form.submit();
	}
//-->
</script>

<link rel="stylesheet" type="text/css" href="../include/css/dddropdownpanel.css" />
<script type="text/javascript" src="../include/js/dddropdownpanel.js"></script>
<body><center>
	<form name="member_form" method="post" >
			<input type="hidden" name="mb_no" value="<?=$mb_no?>" >
			<input type="hidden" name="mb_id" value="" >
			<input type="hidden" name="mode" value="">

<div id="mypanel" class="ddpanel">
	<div id="mypanelcontent" class="ddpanelcontent">
	<div>
		<div><span style="color:cyan;">&nbsp;user id &nbsp;&nbsp; :</span> <span><input type='text' name='mid' value='' readonly style="background-color:green;color:white;"></span></div>
		<div><span style="color:cyan;">&nbsp;nick name:</span> <span><input type='text' name='nickname' value='' style="background-color:blue;color:yellow;"></span></div>
		<div><span style="color:cyan;">&nbsp;phone no :</span> <span><input type='text' name='phone' value='' style="background-color:blue;color:yellow;"></span></div>
		<div style="color:cyan">About Me:<br>
		   <textarea id='memo' name='memo' rows='3' cols='60' class='form' style="background-color:blue;color:yellow;"></textarea></div>
		<div><input type='button' value=" Save " onClick="update_save()" style="cursor:hand;background-color:yellow;color:black;" title='Change my infomation.'></div>
	</div>
	</div>
	<div id="mypaneltab" class="ddpaneltab" ><span style="background-color:;color:yellow;"><a href="#" style='height:25px;color:yellow;'>&nbsp; &#9776; ReSet Member Info &nbsp;▼ &nbsp;</a></span></div>
</div>
<?php
		$limite = 10;
		$page_num = 10;
		if($mode == 'search_rtn') {
			$sdata = $sel_num;
		}
		$w = " ";
		$w1= " ";
		$w2 = " ";
		$ls = " SELECT * from {$tkher['tkher_member_table']} ";
		$ls_w = " WHERE name like '%$sdata%' $w ";
		if ( $sdata ) {
			$ls = $ls . $ls_w;
		}
		$result = sql_query( $ls );
		if( $result ) $total = sql_num_rows($result);
		else {
			echo "sql: " . $ls; exit;
		}
		if(!$page) $page=1;
		$total_page = intval(($total-1) / $limite)+1;
		$first = ($page-1)*$limite;
		$last = $limite;
		if($total < $last) $last = $total;
		$limit = " limit $first,$last";
		if ($page == "1")
			$no = $total;
		else {
			$no = $total - ($page - 1) * $limite;
		}
		if( $sdata )  $g_nameX = "Search : " . $sdata;
		else $g_nameX = " page:" . $page . ", [count:" .$total. "]";

		if( $H_ID ) $g_nameX = $g_nameX . ", level:" . $member['mb_level'] . "," .$member['mb_email'];
?>
		<tr>
			<td bgcolor='#f4f4f4'  align='center' colspan=7><font color='black'>&nbsp;<?=$g_nameX?>
			</td>
		</tr>
, *User name: <input type='text' name='mb_name' id='mb_name' > <input type='button' value='Search' id='Search' >
<table class='floating-thead' width='100%'>
<thead  width='100%'>
		<tr style='color:black;' align='center'>
			<TH style='color:white;'>no</TH>
			<TH style='color:white;'>user id</TH>
			<TH style='color:white;'>mb_sn</TH>
			<TH style='color:white;'>name</TH>
			<TH style='color:white;'>pw</TH>
			<TH style='color:white;'>email</TH>
			<TH style='color:white;'>phone</TH>
			<TH style='color:white;'>login date</TH>
			<TH style='color:white;'>certify</TH>
			<TH style='color:white;'>point</TH>
			<TH style='color:white;'>memo</TH>
			<TH>management</TH>
		</tr>

 </thead>
<tbody width='100%'>
<?php
	$w = " order by mb_name ";
	$ls = " SELECT * from {$tkher['tkher_member_table']} $w ";
	$ls_w = " WHERE name like '%$sdata%' $w ";
	if ( $sdata ) {
		$ls = $ls . $ls_w;
		$ls = $ls . " $limit ";
	} else{
		$ls = $ls . " $limit ";
	}
	$result = sql_query(  $ls );
	$aaa = 0;
	$line = 0;
	$i=1;
	while ( $rs = sql_fetch_array( $result ) ) {
		$line=$limite*$page + $i - $limite;
		if($rs['mb_password']) $p='ok';
		else $p='None';
?>
		  <tr>
			<td><?=$line?></td>
			<td><?=$rs['mb_id']?></td>
			<td><?=$rs['mb_sn']?></td>
			<td title="nick name:<?=$rs['mb_nick']?>"><?=$rs['mb_name']?></td>
			<td><?=$p?></td>
			<td><?=$rs['mb_email']?></td>
			<td><?=$rs['mb_hp']?></td>
			<td><?=$rs['mb_today_login']?></td>
			<td><?=$rs['mb_email_certify']?></td>
			<td><?=number_format($rs['mb_point'])?></td>
			<td><textarea name="memoA" cols="30" rows="2"><?=$rs['mb_memo']?></textarea></td>
<?php
	$mid=$rs['mb_id'];$no=$rs['mb_no']; $point=$rs['mb_point'];
	$nickname=$rs['mb_nick'];$phone=$rs['mb_hp'];$email=$rs['mb_email'];
?>
			<td>
				<input type='button' style="cursor:hand;" value="ReSet" onClick="member_set('<?=$aaa?>','<?=$no?>','<?=$mid?>','<?=$phone?>','<?=$email?>','<?=$nickname?>')" title='set:<?=$point?>:<?=$no?>:<?=$rs['mb_id']?> '>
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

<div style="font-size:18;text-align:center;">

<?php
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;
	$prev = $first_page-1;

	if($page > $page_num) echo"[<a href=$PHP_SELF?page=$prev&sdata=$sdata >Prev</a>] ";
	for($i = $first_page; $i <= $last_page; $i++)
	{
		if($page == $i) echo" <b>$i</b> ";
		else echo"[<a href=$PHP_SELF?page=$i&sdata=$sdata style='font-size:18;'>$i</a>]";
	}
	$next = $last_page+1;
	if($next <= $total_page) echo" [<a href=$PHP_SELF?page=$next&sdata=$sdata >Next</a>]";
?>
</div>
</form>

</body>
</html>
