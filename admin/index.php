<?php
  if(!isset($cur_Route)) header('Location:../index.php?admin');

  if($cfg_Count) include('./admin/counter.php');
  
  if(isset($_GET['refresh'])) {
?>
  	<div class="container alert alert-info" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Please wait:</span>
	  The changes are being applied, please be patient...
	</div>
<?php
  } else {
  	if(isset($_GET['done']))
	{
?>
	<p>&nbsp;</p>
	<div class="container alert alert-info" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Info:</span>
	  <b>Installation complete!</b><br />
	  Start now using your website!<br />
	  Note: Changes can take up to 3 seconds to be effective, refresh if you see no change.
	</div>
<?php
	}
	if($cfg_Count)
	{
?>
<div class="row">
	<div class="col-md-12">
	  <h2>Visit counter: <?php echo $res_Counter; ?></h2>
	</div>
</div>
<hr />
<?php
	}
?>
<div class="row">
	<div class="col-md-12">
	  <h2>Global Config</h2>
	  <form action="admin/edit.php" method="post">
	  	<input type="hidden" value="global" name="on" />
	  	<div class="col-md-4"><label for="siteName">Website name:</label> <input type="text" value="<?php echo $cfg_SiteName ?>" name="siteName" /></div>
	  	<div class="col-md-4"><label for="siteDesc">Website description:</label> <input type="text" value="<?php echo $cfg_SiteDesc ?>" name="siteDesc" /></div>
	  	<div class="col-md-4"><input type="submit" value="Apply Changes" /></div>
	  </form>
	</div>
</div>
<hr />
<div class="row">
	<form class="col-md-4" action="admin/edit.php" method="post">
	  <input type="hidden" value="index" name="on"/>
	  <h2>Landing Page</h2>
	  <hr />
	  <h3>Main introduction:</h3>
	  <textarea class="form-control" rows="5" name="siteIntro" style="max-width:100%;" ><?php echo br2nl($dyn_intro_content); ?></textarea><br /><br />
	  <h3>Main animation:</h3>
	  <select name="intro_ani" class="col-md-12">
	    <option value="no"> - Empty - </option>
<?php
		foreach($dyn_content_yt as $k => $data) {
			if(array_search($k, $dyn_intro_content_yt)===FALSE) echo "\t\t\t".'<option value="'.base64_encode($k).'">'.$data[0].'</option>'."\n";
			else echo "\t\t\t".'<option value="'.base64_encode($k).'" selected>'.$data[0].'</option>'."\n";
		}
?>
	  </select><br /><br />
	  <h3>Main images:</h3>
	  <select name="intro_img[]" size="7" multiple class="col-md-12">
	    <option value="no" <?php echo (count($dyn_intro_content_img)>0?'':'selected'); ?>> - Empty - </option>
<?php
		foreach($dyn_content_img as $k => $data) {
			if(array_search($data[1], $dyn_intro_content_img)===FALSE) echo "\t\t\t".'<option value="'.base64_encode($data[1]).'">'.$data[2].'</option>'."\n";
			else echo "\t\t\t".'<option value="'.base64_encode($data[1]).'" selected>'.$data[2].'</option>'."\n";
		}
?>
	  </select><br />
	  <p class="text-center">&nbsp;<br /><input class="col-md-12" type="submit" value="Apply Changes" /></p><br />
	  <hr />

	</form>
	<div class="col-md-4">
	  <h2>Animation</h2>
	  <hr />
<?php
		foreach($dyn_content_yt as $k => $data) {
			echo "\t\t\t".'<div class="row"><div class="col-md-8">'.$data[0].'</div><div class="col-md-2">[<a href="./admin/set.php?act=edit&amp;on=yt&amp;k='.base64_encode($k).'">edit</a>]</div><div class="col-md-2">[<a href="./admin/set.php?act=del&amp;on=yt&amp;k='.base64_encode($k).'">x</a>]</div></div>'."\n";
		}
?>
	  <br />
	  <p class="text-center"><a href="admin/set.php?act=add&amp;on=yt&amp;k=new"><button class="col-md-12">Add New</button></a></p><br />

	  <hr />

	</div>
	<div class="col-md-4">
	  <h2>Portfolio</h2>
	  <hr />
<?php
		foreach($dyn_content_albums as $code => $title)
		{
			echo '<div class="row"><h4 class="col-md-8" style="text-decoration:underline">'.$title.':</h4> <h5 class="col-md-4 text-right" style="text-decoration:underline">[<a href="admin/set.php?act=edit&amp;on=album&amp;k='.base64_encode($code).'">edit</a>][<a href="admin/set.php?act=del&amp;on=album&amp;k='.base64_encode($code).'">x</a>]</h5></div>';
			foreach($dyn_content_img as $k => $data)
			{
				if ($code == $data[0])
				{
					echo "\t\t\t".'<div class="row"><div class="col-md-8"><a href="./portfolio/'.$data[1].'" title="'.$data[1].'">'.$data[2].'</a></div><div class="col-md-4 text-right">[<a href="./admin/set.php?act=edit&amp;on=img&amp;k='.base64_encode($data[1]).'">edit</a>][<a href="./admin/set.php?act=del&amp;on=img&amp;k='.base64_encode($data[1]).'">x</a>]</div></div>'."\n";
				}
			}
		}
		echo '<h4>Not visible:</h4>';
		foreach($dyn_content_img as $k => $data)
		{
			if (!isset($dyn_content_albums[$data[0]]))
			{
				echo "\t\t\t".'<div class="row"><div class="col-md-8"><a href="./portfolio/'.$data[1].'" title="'.$data[1].'">'.$data[2].'</a></div><div class="col-md-2">[<a href="./admin/set.php?act=edit&amp;on=img&amp;k='.base64_encode($data[1]).'">edit</a>]</div><div class="col-md-2">[<a href="./admin/set.php?act=del&amp;on=img&amp;k='.base64_encode($data[1]).'">x</a>]</div></div>'."\n";
			}
		}
?>
	  <br />
	  <p class="text-center"><a href="admin/set.php?act=add&amp;on=album&amp;k=new"><button class="col-md-6">Add New Album</button></a><a href="admin/set.php?act=add&amp;on=img&amp;k=new"><button class="col-md-6">Add New Image</button></a></p><br />

	  <hr /><br />

	</div>
</div>
<?php } ?>
