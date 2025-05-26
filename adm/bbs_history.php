<?php
	/*
		bbs_history.php :
			call : bbs_history_admin.php : 
	*/
	if( isset($_POST["pg_code"])) $pg_code = $_POST["pg_code"];
	else $pg_code = '';
	if( isset($_POST["pg_name"])) $pg_name = $_POST["pg_name"];
	else $pg_name = '';
	if( isset($_POST["comment"])) $comment = $_POST["comment"];
	else $comment = '';
	if( isset($_POST["mode"])) $mode = $_POST["mode"];
	else $mode = '';
	if( isset($_POST["no"])) $no = $_POST["no"];
	else $no = '';
	if( $mode=='update' && $H_LEV>7) {
		$build_time = time();
		sql_query( "update {$tkher['bbs_history_table']} set pg_code='$pg_code', pg_name='$pg_name', comment='$comment', cid='$H_ID', ctime=$build_time where no='$no' " );
		echo "<script>window.open( 'bbs_history_admin.php' , '_self',''); </script>";
		exit;
	} else if( $H_LEV>7 && $mode=='insert') {
		$build_time = time();
		$sql = "insert into {$tkher['bbs_history_table']} set id='$H_ID', pg_code='$pg_code', pg_name='$pg_name', build_time='$build_time', comment='$comment'";
		$ret = sql_query( $sql );
		if( $ret ) {
			m_(" OK history ");  //echo "sql: " . $sql; exit; 
		}
		else  {
			m_(" Error history "); //echo "sql: " . $sql; exit;
		}
		echo "<script>window.open( 'bbs_history_admin.php' , '_self',''); </script>";
	} else {
		$result = sql_query( "SELECT * from {$tkher['bbs_history_table']} order by build_time desc");
?>	
<p>
			<font color='maroon'><b>K-App History</b></font><p>
			<form name='history' method='post' action='bbs_history_admin.php'>
				<input type='hidden' name='no' value=''>
				<table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
				<tr>
					<td bgcolor='#cccc66' height='1' colspan='5'></td>
				</tr>
				<tr>
					<TH>m-d-Y</TH><TH>user</TH><TH>Code</TH><TH>Name</TH><TH>Message</TH><TH>CTL</TH>
				</tr>
				<?php
					$i=0;
				while ($rs=sql_fetch_array($result)) {
					$time = date("m-d-Y",$rs['build_time']);

				?>
					<tr>
						<td valign='top' bgcolor='#ffffff' width='70'><?=$time?></td>
						<td bgcolor='#ffffff' width='70'><?=$rs['id']?></td>
						<td bgcolor='#ffffff' width='70'><?=$rs['pg_code']?></td>
						<td bgcolor='#ffffff' width='120'><?=$rs['pg_name']?></td>
						<td bgcolor='#ffffff' title='change id:<?=$cid?>, time:<?=$ctime?>'><?=$rs['comment'] ?></td>
						<td bgcolor='#ffffff' style='border:1 black solid;width:50;'>
						<?php 
								$bt=$rs['build_time']; 
								$mg= '';//$rs['comment']; // : 메세지내용에 엔터값이 있을때 update버턴이 클릭되지않는다. 중요.
								$no=$rs['no']; 
								$pcd=$rs['pg_code']; $pnm=$rs['pg_name'];
						?>
							<input type='button' onclick="javascript:his_update('<?=$i?>','<?=$bt?>', '<?=$mg?>','<?=$no?>', '<?=$pcd?>','<?=$pnm?>')" value='Update' >
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

	<?php if ( $H_ID && $H_LEV > 7 ) { ?> 
			&nbsp;<input type='submit' onclick="javascript:f_his('insert'); return false;" value='UPDATE' class='form'> 
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			<input type='submit' onclick="javascript:f_ins('insert')" value='INSERT' class='form' >
	<?php } ?>

			</div>
			<div id="mypaneltab2" class="ddpaneltab">
				<a href="#"><span>▤ -K-App History Insert ▤</span> </a>
			</div>

		</div>

			</form>
<?php
}
?>
		</table>
<script language='javascript'>
<!--
	function his_update(i, xday, dd, no, cd, nm) {
			document.history.xday.value = xday;
			document.history.no.value = no;
			document.history.pg_code.value = cd;
			document.history.pg_name.value = nm;
			msg = eval( "document.history.msg_"+i+".value");
			document.history.comment.value = msg;
			document.history.mode.value="update";
			return;
	 }
	function f_his(dd) {
			cc = document.history.comment.value;
			document.history.submit();
	 }
	function f_ins(dd) {
			document.history.mode.value="insert";
			document.history.submit();
	 }
//-->
</script>
