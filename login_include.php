<?php
	if($_REQUEST['run'] == 'logout'){
		?>
		<script>
				location.href="logoutT.php";
		<?php
		m_("logout");
	}
?>
<div class="loginBox">
		<div class="rela">
		<FORM name='loginA' action='./login_checkT.php' method='post' enctype="multipart/form-data" >
			<input type='hidden' name='mode' value=''>
			<a href="javascript:void(0)" class="loginClose"><img src="./include/img/bg/bg_closeBtn.png" /></a>
			<div class="pic"><img src="./include/img/etc/etc_login.png" /></div>
			<div class="form">
				<div class="row">
					<label for="loginid">ID</label>
					<input type="text" id="loginid" name="mb_id" />
				</div>
				<div class="row">
					<label for="loginid">Password</label>
					<input type="password" id="loginid" name="mb_password" />
				</div>
				<!--<a href="javascript:void(0)">LOGIN</a>-->
				<div class="A_Login">
					<a href="javascript:Ologin(0);" title='Login A'>LOGIN</a>
				</div>
			</div>
		</FORM>
		</div>
	</div>

	<div class="lnbArea">
		<a href="javascript:void(0)" class="lnbClose" onclick="common.lnbClose()"><img src="./include/img/btn/btn_close01.png" /></a>
		<ul>
			<li><a href="./">About</a></li> <!-- about.php 를  index.php로 사용.  -->
			<li><a href="./work.php">Works</a></li>
			<li><a href="./customer.php">Customer</a></li>
			<!-- <li><a href="./indexA.php#contactUs">Contactus</a></li>--> <!-- index.php 를  indexA.php로 사용.  -->
		</ul>

		<div class="lnbFooter">
			<?php if( strlen($H_ID) <= 0 ) { //m_("H_ID:" . $H_ID);?>
				<a href="javascript:void(0)" class="lnbIcon01">Login</a>
			<?php } else { ?>
				<a href="javascript:logout_(0)" class="lnbIcon01">LogOut(<?=$H_ID?>)</a>
			<?php } ?>
			<a href="./custom/customer.php#customer" class="lnbIcon02">Maintenance</a>
			<a href="javascript:void(0)" class="lnbIcon03">Project request</a>
			<a href="../pm/indexA.php#contactUs">어데가노 가맹점 등록</a><!-- 앱 생성용 가맹점 정보.  -->
			<a href="../pm/moa/" class="lnbIcon02" target='_top'>요양기관찾기</a>
		</div>
	</div>
</div>
<script>
	function logout_(){
		location.href="./logoutT.php"; //"index.php?run=logout";
	}
</script>

<script>

	$(function() {
		$('.A_Login').on('click', function() {	// login - call.
			var id = document.loginA.mb_id.value;
			var pw = document.loginA.mb_password.value;
			if( id == ''){
				alert('Please enter your ID !!! ');
				document.loginA.mb_id.focus();
				return false;
			}
			if( pw ==''){
				alert('Please enter a password.');
				document.loginA.mb_password.focus();
				return false;
			}
			document.loginA.mode.value = "A_login";
			document.loginA.submit();
		}); 
	});
</script>
