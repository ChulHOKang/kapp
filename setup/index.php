<?php
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');

$reset = false;
include_once ('./kapp_start.php'); // <- kapp_config.php
echo "KAPP_URL_T_: ".KAPP_URL_T_;
$title = KAPP_VERSION_." - System Setup"; //   define('KAPP_VERSION_', 'K-APP V1.0');
include_once ('./setup.inc.php');

//m_("exists_data_dir: " . $exists_data_dir); //exists_data_dir: 1

?>

<?php
if( $exists_data_dir && $write_data_dir) {
    // 필수 모듈 체크
    // require_once('./library.check.php');
?>
	<form action="./kapp_index.php" method="post" onsubmit="return frm_submit(this);">
	<input type='hidden' name='mode' value='Kapp_Setup'>

	<div class="setup_inner">
		<p>
			<strong class="st_strong">Be sure to check the license details.</strong><br><!-- 라이센스(License) 내용을 반드시 확인하십시오. -->
			Installation will only proceed if you agree to the license.<!-- 라이센스에 동의하시는 경우에만 설치가 진행됩니다. -->
		</p>

		<div class="ins_ta ins_license">
			<textarea name="textarea" id="ins_license" readonly><?php echo implode('', file('./LICENSE.txt')); ?></textarea>
		</div>

		<div id="ins_agree">
			<label for="agree">I agree.</label><!-- 동의합니다. -->
			<input type="checkbox" name="agree" value="Agree" id="agree">
		</div>

		<div class="setup_btn">
			<input type="submit" value="Next">
		</div>
	</div>

	</form>

	<script>
	function frm_submit(f)
	{
		if (!f.agree.checked) {
			alert("You must agree to the license terms to install."); // 라이센스 내용에 동의하셔야 설치가 가능합니다.
			return false;
		}
		return true;
	}
	</script>
<?php
} // if
?>

<?php
include_once ('./setup.buttom.php');
?>
