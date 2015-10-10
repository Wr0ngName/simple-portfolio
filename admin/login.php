<?php
	if(!isset($cur_Route)) header('Location:../index.php?admin');

	require_once('./core/recaptchalib.php');
	$error = null;

	if(isset($_POST['old_pwd']) && isset($_POST['pwd']) && isset($_POST['pwd2'])){
		include('./core/data/login.db.php');
		if($pwd === sha1($_POST['old_pwd']) && $_POST['pwd'] == $_POST['pwd2'])
		{
			file_put_contents('./core/data/login.db.php', "<?php \n\t".'$login = '.var_export($login, true).";\n\t".'$pwd = '.var_export(sha1($_POST['pwd']), true).";\n\t\n?>");
			header('Location:./index.php?admin&refresh');
		}
		else
		{
			header('Location:./index.php?p=error');
		}
	}
	else if(isset($_POST['login']) && isset($_POST['pwd']) && ($cfg_CaptchaPublicKey===""||$cfg_CaptchaPrivateKey===""||isset($_POST["recaptcha_response_field"]))){
		include('./core/data/login.db.php');

		$resp = null;

		if($cfg_CaptchaPublicKey!==""&&$cfg_CaptchaPrivateKey!=="")
		{
			$resp = recaptcha_check_answer ($cfg_CaptchaPrivateKey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
			if($resp->is_valid)
				$ret_captcha = true;
			else
				$ret_captcha = false;
		}
		else
			$ret_captcha = true;

		if($ret_captcha && $login === ($_POST['login']) && $pwd === sha1($_POST['pwd'])) 
		{
			$_SESSION['logged_admin'] = 1;
			header('Location:./index.php?admin');
		}
		else
		{
			header('Location:./index.php?p=error');
		}
	}
	else if (isset($_GET['edit']))
	{
?>
 	<form role="form" method="post" action="index.php?login">
	  <div class="form-group">
	    <label for="old_pwd">Old Password:</label>
	    <input type="password" class="form-control" name="old_pwd">
	  </div>
	  <div class="form-group">
	    <label for="pwd">New Password:</label>
	    <input type="password" class="form-control" name="pwd">
	  </div>
	  <div class="form-group">
	    <label for="pwd2">Confirm Password:</label>
	    <input type="password" class="form-control" name="pwd2">
	  </div>
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
<?php
	}
	else
	{
?>
 	<form role="form" method="post" action="index.php?admin">
	  <div class="form-group">
	    <label for="login">Login:</label>
	    <input type="text" class="form-control" name="login">
	  </div>
	  <div class="form-group">
	    <label for="pwd">Password:</label>
	    <input type="password" class="form-control" name="pwd">
	  </div>
	  <div class="form-group">
	    <?php if($cfg_CaptchaPublicKey!==""&&$cfg_CaptchaPrivateKey!=="") echo recaptcha_get_html($cfg_CaptchaPublicKey, $error); ?>
	  </div>
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
<?php
	}
?>