<?php
	session_start();
	if(isset($_GET['done']))
	{
?>
	<p>&nbsp;</p>
	<div class="container alert alert-info" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Info:</span>
	  <b>Installation complete!</b><br />
	  Delete the "install.php" file to start using your website!
	</div>
<?php
	}
	else if (isset($_POST['siteDesc'])&&isset($_POST['siteName'])&&isset($_POST['pwd2'])&&isset($_POST['pwd'])&&isset($_POST['login'])&&$_POST['pwd']==$_POST['pwd2'])
	{
		file_put_contents('./core/data/global.db.php', "<?php\n\t".'$cfg_SiteName = '.var_export(htmlentities($_POST['siteName']), true).';'."\n\t".'$cfg_SiteDesc = '.var_export(htmlentities($_POST['siteDesc']), true).';'."\n?>");
		file_put_contents('./core/data/login.db.php', "<?php\n\t".'$login = '.var_export($_POST['login'], true).';'."\n\t".'$pwd = '.var_export(sha1($_POST['pwd']), true).';'."\n?>");
		$_SESSION['admin_logged'] = 1;
		unlink('./install.php');
		header('Location:index.php?admin&done');
	}
	else
	{
	?>
 	<form role="form" method="post" action="index.php?admin">
		<div class="row">
		  <h2>Admin account informations:</h2>
		  <div class="form-group">
		    <label for="login">Login:</label>
		    <input type="text" class="form-control" name="login">
		  </div>
		  <div class="form-group">
		    <label for="pwd">Password:</label>
		    <input type="password" class="form-control" name="pwd">
		  </div>
		  <div class="form-group">
		    <label for="pwd2">Confirm Password:</label>
		    <input type="password" class="form-control" name="pwd2">
		  </div>
	  	</div>
		<hr />
		<div class="row">
			<h2>Website configuration:</h2>
	  		<div class="col-md-4"><label for="siteName">Website name:</label> <input type="text" value="<?php echo $cfg_SiteName ?>" name="siteName" /></div>
	  		<div class="col-md-8"><label for="siteDesc">Short website description:</label> <input type="text" value="<?php echo $cfg_SiteDesc ?>" name="siteDesc" size="35" /></div>
	  	</div>
		<hr />
		<div class="row">
		  	<h2>Server configuration:</h2>
<?php
		  		$path = realpath('./'.$cfg_UploadPath);
	  	  		echo "\t\t\t".'<div class="col-md-8">Upload directory ('.$path.')</div><div class="col-md-4">'.(!is_writable($path)?'<span style="color:red;">Requires writing access</span>':'<span style="color:green;">Has write access</span>').'<br />&nbsp;</div>';

		  		$path = realpath('./core/data');
		  		foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
		  		{
		  			list($txt, $ext) = explode(".", $filename);
	  	  			if(!$filename->isDir() && $ext == "db") echo "\t\t\t".'<div class="col-md-8">'.$filename.'</div><div class="col-md-4">'.(!is_writable($filename)?'<span style="color:red;">Requires writing access</span>':'<span style="color:green;">Has write access</span>').'</div>';
		  		}
?>
	  	</div>
		<hr />
		<div class="row text-center"><button type="submit" class="btn btn-default btn-primary">Submit</button></div>
	</form>
	<?php
	}
?>