<?php
	/*
		kapp_history_.php -	call : kapp_history.php : 
	*/
	if( isset($_POST["comment"])) $comment = $_POST["comment"];
	else $comment = '';
	if( isset($_POST["mode"])) $mode = $_POST["mode"];
	else $mode = '';
	if( isset($_POST["pg_code"])) $pg_code = $_POST["pg_code"];
	else $pg_code = '';
	if( isset($_POST["pg_name"])) $pg_name = $_POST["pg_name"];
	else $pg_name = '';
	if( isset($_POST["no"])) $no = $_POST["no"];
	else $no = '';
	if( $mode=='update') {
		$build_time = time();
		sql_query( "update {$tkher['bbs_history_table']} set pg_code='$pg_code', pg_name='$pg_name', comment='$comment', cid='$H_ID', ctime='$build_time' where no=$no " );
		echo "<script>window.open( 'kapp_history.php' , '_self',''); </script>";
		exit;
	} else if( $mode=='insert') {
		$build_time = time();
		sql_query( "insert into {$tkher['bbs_history_table']} set id='$H_ID', pg_code='$pg_code', pg_name='$pg_name', build_time='$build_time', comment='$comment'" );
		echo "<script>window.open( 'kapp_history.php' , '_self',''); </script>";
	} else {
?>
<center>
<p style='color:maroon;font-size:25px;'>K-APP History Management<p>
<FORM name='history' method='post' action='kapp_history.php'>
		<input type='hidden' name='no' value=''>
		<input type='hidden' name='mode' value='insert'>
		<input type='hidden' name='xday' value=''>

	<Table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
				<tr>
					<td bgcolor='#cccc66' height='1' colspan='5'></td>
				</tr>
				<tr>
					<TH>Date</TH><TH>user</TH><TH>PG Code</TH><TH>Name</TH><TH>Message</TH><TH>CTL</TH>
				</tr>
<?php
					$i=0;
				$result = sql_query( "SELECT * from {$tkher['bbs_history_table']} order by build_time desc, pg_code ");
				while( $rs=sql_fetch_array($result)) {
					$time = date("m-d-Y",$rs['build_time']);
					$mid = $rs['id'];
					$cid = $rs['cid'];
					if( $rs['ctime']) $ctime = $rs['ctime']; //date("m-d-Y", $rs['ctime']);
					else $ctime ='';
?>
					<tr>
						<td style="background-color:#666666;color:cyan;"><?=$time?></td>
						<td style="background-color:#666666;color:cyan;"><?=$rs['id']?></td>
						<td style="background-color:#666666;color:cyan;"><?=$rs['pg_code']?></td>
						<td style="background-color:#666666;color:cyan;"><?=$rs['pg_name']?></td>
						<td style="background-color:#666666;color:cyan;"><?=$rs['comment'] ?></td>
						<td style='border:1 black solid;width:50;'>
						<?php 
								$bt=$rs['build_time'];$no=$rs['no']; 
								$pcd=$rs['pg_code']; $pnm=$rs['pg_name'];
						?>
						<input type='button' onclick="javascript:his_update('<?=$i?>','<?=$bt?>','<?=$no?>', '<?=$pcd?>','<?=$pnm?>','<?=$mid?>')" value='Update'>
						<input type='hidden' name='msg_<?=$i?>' value="<?=$rs['comment']?>">
						</td>
					</tr>
				<?php
					$i++;
				}
?>
<p>
		<div id="mypanel2" class="ddpanel">
		<div id="mypanelcontent2" class="ddpanelcontent">
		<center>
			<div style="border-style:;background-color:#666666;color:yellow;height:30px;margin-top:3px;">
			<span style="color:white;margin-top:3px;">&nbsp;Program : </span>
			<SELECT id='sel_pg_name' name='sel_pg_name' onchange="change_pgname_func(this.value);" style="background-color:#000000;color:yellow;margin-top:3px;">
				<option value='' style="color:yellow;">Select Program</option>
<?php
				$result = sql_query( "select * from {$tkher['table10_pg_table']} order by pg_name asc" );
				while($rs = sql_fetch_array($result)) {
					if($temp_name != $rs['pg_name']) {
						$temp_name = $rs['pg_name'];
						$com ="";
						$com = sql_historyA( $rs['pg_code'] );
?>
						<option style="color:yellow;" value='<?=$rs['pg_name']?>:<?=$rs['pg_code']?>:<?=$rs['userid']?>:<?=$rs['seqno']?>:<?=$rs['group_name']?>:<?=$com?>' <?php if($rs['pg_name']==$pg_name) echo "selected"; ?>><?=$rs['pg_name']?></option>
<?php
						}
				}
?>
			</SELECT></div>
			<div style="border-style:;background-color:#666666;color:yellow;height:30px;margin-top:3px;">
			<span style="border-style:;background-color:#666666;color:cyan;margin-top:3px;">&nbsp;Project:</span><span>
			<input type='text' id='project' name='project' value='' style="border-style:;background-color:black;color:yellow;height:25;width:250;margin-top:3px;" readonly></span></div>

			<div><span style="border-style:;background-color:#666666;color:cyan;">&nbsp;pg_code:</span><span>
			<input type='text' id='pg_code' name='pg_code' value='' style="border-style:;background-color:black;color:yellow;height:25;width:250;"></span></div>
			<div><span style="border-style:;background-color:#666666;color:cyan;">&nbsp;pg_name:</span><span>
			<input type='text' id='pg_name' name='pg_name' value='' style="border-style:;background-color:black;color:yellow;height:25;width:250;"></span></div>
			<div><span style="border-style:;background-color:#666666;color:cyan;">&nbsp;Contents:</span>
			<br>&nbsp;<textarea name='comment' rows='5' cols='80' style="border-style:;background-color:#666666;color:cyan;"></textarea></div>
			<a id='update_btn' href="javascript:update_func('insert');" style="background-color:blue;color:yellow;height:35;">Save Change</a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			<input type='submit' onclick="javascript:f_ins('insert'); return false;" value='INSERT' >
			</div>
	<div id="mypaneltab2" class="ddpaneltab" ><span style="background-color:;color:yellow;"><a href="#" style='height:25px;color:yellow;'>&nbsp; &#9776; K-APP History Management &nbsp;▼ &nbsp;</a></span></div>

		</div>
	</form>
<?php
}
?>
<br>
	</Table>



<script language='javascript'>
<!--
	function initA(){
		document.getElementById('update_btn').style.visibility = 'hidden'; 
	}
	function change_pgname_func(g_nm) {
		g_name = g_nm;
		var gg = g_nm.split(":");
		pg_name = gg[0];
		pg_code = gg[1];
		userid  = gg[2];
		seqno   = gg[3];
		comment = gg[5];
		document.history.pg_name.value = gg[0]; 
		document.history.pg_code.value = gg[1]; 
		document.history.project.value = gg[4]; 
		document.history.no.value = seqno; 
		document.history.comment.value = comment; 
	}

	function his_update(i, xday, no, pgcd, pgnm, mid) {
		if( no == '' ) return;
			document.getElementById('update_btn').style.visibility = 'visible';
			document.history.xday.value = xday;
			msg = eval( "document.history.msg_"+i+".value");	//alert('msg:'+msg);
			document.history.comment.value = msg;
			document.history.no.value = no;
			document.history.pg_code.value = pgcd;
			document.history.pg_name.value = pgnm;
			
		var selectIndex = document.history.sel_pg_name.selectedIndex;
			//alert("selectIndex: " + selectIndex );	alert("pgnm: " + pgnm);
			//a = document.history.sel_pg_name.options[0].value;
			document.history.sel_pg_name.options[0].text = pgnm;	//alert("a: " + a );
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

<?php
function sql_historyA( $pg_code )
{
	global $tkher;
	$sql = "SELECT comment from {$tkher['bbs_history_table']} where pg_code= '" . $pg_code . "' ";
	$rs = sql_fetch( $sql );
	return $rs['comment'];
}

?>