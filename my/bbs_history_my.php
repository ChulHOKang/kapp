<?php
/*
	bbs_history_my.php :
		call : bbs_history_myjob.php : 
*/
	if( isset($_POST["mode"])) $mode = $_POST["mode"];
	else $mode = '';

	if( isset($_POST["comment"])) $comment = $_POST["comment"];
	else $comment = '';

	if( isset($_POST["pg_code"])) $pg_code = $_POST["pg_code"];
	else $pg_code = '';
	if( isset($_POST["pg_name"])) $pg_name = $_POST["pg_name"];
	else $pg_name = '';

	if( isset($_POST["no"])) $no = $_POST["no"];
	else $no = '';

	//my_msg( " mode: ". $mode . $comment);
	if( $mode=='update') {
		$build_time = time();
		sql_query( "update {$tkher['bbs_history_table']} set pg_code='$pg_code', pg_name='$pg_name', comment='$comment', cid='$H_ID', ctime=$build_time where no=$no and id='$H_ID' " );
		echo "<script>window.open( 'bbs_history_myjob.php' , '_self',''); </script>";
		exit;
	} else if( $mode=='insert') {
		$build_time = time();
		sql_query( "insert into {$tkher['bbs_history_table']} set id='$H_ID', pg_code='$pg_code', pg_name='$pg_name', build_time='$build_time', comment='$comment'" );
		echo "<script>window.open( 'bbs_history_myjob.php' , '_self',''); </script>";
		//exit;
	} else {
		$result = sql_query( "SELECT * from {$tkher['bbs_history_table']} order by build_time desc");
?>	
<p>
			<font color='maroon'><b>K-App History</b></font><p>
		<form name='history' method='post' action='bbs_history_myjob.php'>
				<input type='hidden' name='no' value=''>
			<table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
				<tr>
					<td bgcolor='#cccc66' height='1' colspan='5'></td>
				</tr>
				<tr>
					<TH>m-d-Y</TH><TH>id</TH><TH>Code</TH><TH>Name</TH><TH>Message</TH><TH>CTL</TH>
				</tr>
				<?php
					$i=0;
				while( $rs=sql_fetch_array($result)) {
					$time = date("m-d-Y",$rs['build_time']);
					$mid = $rs['id'];
					$cid = $rs['cid'];
					if( $rs['ctime']) $ctime = date("m-d-Y", $rs['ctime']);
					else $ctime ='';
				?>
					<tr>
						<td valign='top' bgcolor='#ffffff' width='70'><?=$time?></td>
						<td bgcolor='#ffffff' width='70'><?=$rs['id']?></td>
						<td bgcolor='#ffffff' width='70'><?=$rs['pg_code']?></td>
						<td bgcolor='#ffffff' width='120'><?=$rs['pg_name']?></td>
						<td bgcolor='#ffffff' title='change id:<?=$cid?>, time:<?=$ctime?>'><?=$rs['comment'] ?></td>
						<td bgcolor='#ffffff' style='border:1 black solid;width:50;'>
						<?php 
								$bt=$rs['build_time'];$no=$rs['no']; 
								$pcd=$rs['pg_code']; $pnm=$rs['pg_name'];
								//$mg=$rs['comment']; // error : 메세지내용에 엔터값이 있을때 update버턴이 클릭되지않는다.
								$mg=''; 
						if($H_ID == $rs['id']) {
						?>
							<input type='button' onclick="javascript:his_update('<?=$i?>','<?=$bt?>', '<?=$mg?>','<?=$no?>', '<?=$pcd?>','<?=$pnm?>','<?=$mid?>','<?=$H_ID?>')" value='Update' class='form'>
						<?php
						} else {
						?>
							---
						<?php
						} 
						?>
							<input type='hidden' name='msg_<?=$i?>' value="<?=$rs['comment']?>">
						</td>
					</tr>
				<?php
					$i++;
				}
				?>
<p>
			<!-- ---------------------------------------------------------------------&nbsp; -->
		<div id="mypanel2" class="ddpanel">
			<div id="mypanelcontent2" class="ddpanelcontent">
			<!-- --------------------------------------------------------------------- -->

			<input type='hidden' name='mode' value='insert'>
			<input type='hidden' name='xday' value=''>
			<div><span>&nbsp;pg_code:</span> <span><input type='text' name='pg_code' value='' ></span></div>
			<div><span>&nbsp;pg_name:</span><span><input type='text' name='pg_name' value='' ></span></div>
			<div><span>&nbsp;message:</span>
			<br>&nbsp;<textarea name='comment' rows='3' cols='70' class='form'></textarea></div>
			&nbsp;<input type='submit' onclick="javascript:update_func('insert'); return false;" value='UPDATE' class='form'> 
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			<input type='submit' onclick="javascript:f_ins('insert'); return false;" value='INSERT' class='form' >

			</div>
			<div id="mypaneltab2" class="ddpaneltab">
				<a href="#"><span>▤ -K-App History Insert ▤</span> </a>
			</div>

		</div>

			</form>
<?php
}
?>
&nbsp;<br>
				</table>



<script language='javascript'>
<!--

	function his_update(i, xday, dd, no, cd, nm, mid, hid) {
		if( cd == '' ) return;
			document.history.xday.value = xday;
			//document.history.comment.value = dd; //error
			msg = eval( "document.history.msg_"+i+".value");
			//alert('msg:'+msg);
			document.history.comment.value = msg;
			document.history.no.value = no;
			document.history.pg_code.value = cd;
			document.history.pg_name.value = nm;
			document.history.mode.value="update";
			//document.history.submit();
			return;
	 }
	function update_func(dd) {
			cd = document.history.pg_code.value;
			if( cd == '' ) return;
			else {
				cc = document.history.comment.value;
				document.history.submit();
			}
	 }
	function f_ins(dd) {
			cd = document.history.pg_code.value;
			nm = document.history.pg_name.value;
			cc = document.history.comment.value;
			if( cd == '' || nm == '' || cc == '' ) {
				alert('msg no found');
				return;
			} else {
				document.history.mode.value="insert";
				document.history.submit();
			}
	 }
//-->
</script>
