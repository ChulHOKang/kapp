<?php
@header('Content-Type: text/html; charset=utf-8');
@header('X-Robots-Tag: noindex');

$reset = false;
include_once ('./kapp_start.php');
echo "KAPP_URL_T_: ".KAPP_URL_T_;
$title = KAPP_VERSION_." - System Setup";
include_once ('./setup.inc.php');
?>

<?php
if( $exists_data_dir && $write_data_dir) {
?>
	<form action="./kapp_index.php" method="post" onsubmit="return frm_submit(this);">
	<input type='hidden' name='mode' value='Kapp_Setup'>

	<div class="setup_inner">
		<p>
			<strong class="st_strong">Be sure to check the license details.</strong><br>
			Installation will only proceed if you agree to the license.
		</p>

		<div class="ins_ta ins_license">
			<textarea name="textarea" id="ins_license" readonly><?php echo implode('', file('./LICENSE.txt')); ?></textarea>
		</div>

		<div id="ins_agree">
			<label for="agree">I agree.</label>
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
			alert("You must agree to the license terms to install.");
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
