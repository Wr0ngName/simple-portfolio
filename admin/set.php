<?php
  session_start();
  if(!isset($_SESSION['logged_admin'])) { header('Location:../index.php?admin'); }

  $subz = '.';

  require_once('../core/config.php');
  require_once('../core/data/global.db.php');
  require_once('../core/data/albums.db.php');

  foreach($cfg_Routes as $tmp_R => $tmp_D) if($tmp_R[0]!==':') include('../core/data/'.$tmp_R.'.db.php');

  if(!isset($_GET['act']) || !isset($_GET['on']) || !isset($_GET['k']))
  {
  	if(isset($_POST['act']) && isset($_POST['on']) && isset($_POST['k']))
  	{
	  	// actions
	  	if($_POST['act']=='del')
	  	{
	  	  if(isset($_POST['confirm']) && $_POST['confirm'] == 1)
	  	  {
			//select files
			if($_POST['on']=='album')
			{
				$filename = 'albums';
				$array = 'dyn_content_albums';
				$index = array_search(base64_decode($_POST['k']),array_keys($dyn_content_albums));
			}
			else if($_POST['on']=='img')
			{
				$filename = 'portfolio';
				$array = 'dyn_content_img';
				$index = searchMuArray(base64_decode($_POST['k']), $dyn_content_img, 1, false, true);
				unlink('../'.$cfg_UploadPath.$dyn_content_img[$index][1]);
			}
			else if($_POST['on']=='yt')
			{
				$filename = 'anime';
				$array = 'dyn_content_yt';
				$index = array_search(base64_decode($_POST['k']), array_keys($$array), true);
			}
			else
				header('Location:../index.php?p=error');

	  	    array_splice($$array, $index, 1);
	  	    file_put_contents('../core/data/'.$filename.'.db.php', "<?php \n$".$array." = ".var_export($$array, true).";\n?>");
	  	    header('Location:../index.php?admin&refresh');
	  	    exit;
		  }
		  else
		  {
		  	header('Location:set.php?act='.$_POST['act'].'&on='.$_POST['on'].'&k='.$_POST['k']);
		  }
		}
	  	elseif($_POST['act']=='edit')
	  	{
				if($_POST['on']=='img')
				{
					if(isset($_POST['desc']) && isset($_POST['album']))
					{
						$dyn_content_img[searchMuArray(base64_decode($_POST['k']), $dyn_content_img, 1)][0] = $_POST['album'];
						$dyn_content_img[searchMuArray(base64_decode($_POST['k']), $dyn_content_img, 1)][2] = htmlentities($_POST['desc']);
						file_put_contents('../core/data/portfolio.db.php', "<?php \n".'$dyn_content_img = '.var_export($dyn_content_img, true).";\n?>");
						header('Location:../index.php?admin&refresh');
						//echo $_POST['album'];
						exit;
					}
					else header('Location:../index.php?p=error');
				}
				elseif($_POST['on']=='yt')
				{
					if(isset($_POST['title']) && isset($_POST['desc']))
					{
						$dyn_content_yt[base64_decode($_POST['k'])][0] = htmlentities($_POST['title']);
						$dyn_content_yt[base64_decode($_POST['k'])][1] = htmlentities($_POST['desc']);
						file_put_contents('../core/data/anime.db.php', "<?php \n".'$dyn_content_yt = '.var_export($dyn_content_yt, true).";\n?>");
						header('Location:../index.php?admin&refresh');
						exit;
					}
					else header('Location:../index.php?p=error');
				}
				elseif($_POST['on']=='album')
				{
					if(isset($_POST['title']))
					{
						$dyn_content_albums[base64_decode($_POST['k'])] = htmlentities($_POST['title']);
						file_put_contents('../core/data/albums.db.php', "<?php \n".'$dyn_content_albums = '.var_export($dyn_content_albums, true).";\n?>");
						header('Location:../index.php?admin&refresh');
						exit;
					}
					else header('Location:../index.php?p=error');
				}
				else header('Location:../index.php?p=error');
  		}
	  	elseif($_POST['act']=='add')
	  	{
				//select files
				if($_POST['on']=='img')
				{
					$filename = 'portfolio';
					$array = 'dyn_content_img';

					if(isset($_FILES['image']) && isset($_POST['title']) && isset($_POST['album']))
					{
						$name = $_FILES['image']['name'];
						$size = $_FILES['image']['size'];

						if(strlen($name))
					  	{
					    	list($txt, $ext) = explode(".", $name);
							if(in_array($ext,$cfg_UploadValidFormats))
					    	{
								if($size<(2048*2048))
					    		{
					        	$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					        	$tmp = $_FILES['image']['tmp_name'];

									if(move_uploaded_file($tmp, '../'.$cfg_UploadPath.$actual_image_name))
						    		{
						  				array_push($$array, [$_POST['album'], urlencode($actual_image_name), htmlentities($_POST['title'])]);
						    			file_put_contents('../core/data/'.$filename.'.db.php', "<?php \n$".$array." = ".var_export($$array, true).";\n?>");
						    			header('Location:../index.php?admin&refresh'); exit;
						    		}
						    		else
						    			header('Location:../index.php?p=error');
						    	}
						    	else
						    		header('Location:../index.php?p=error');
							}
							else
					      		header('Location:../index.php?p=error');
						}
						else
					    	header('Location:../index.php?p=error');
					}
					else
				    	header('Location:../index.php?p=error');
				}
				elseif($_POST['on']=='yt')
				{
					$filename = 'anime';
					$array = 'dyn_content_yt';
					if(isset($_POST['key']) && isset($_POST['title']) && isset($_POST['desc']))
					{
						$key = $_POST['key'];
						if(strpos($key, "https://www.youtube.com/watch?v=")!==FALSE) $key = str_replace("https://www.youtube.com/watch?v=", "", $key);
						$modif = $$array;
						$modif[$key] = [htmlentities($_POST['title']), htmlentities($_POST['desc'])];
						file_put_contents('../core/data/'.$filename.'.db.php', "<?php \n$".$array." = ".var_export($modif, true).";\n?>");
						header('Location:../index.php?admin&refresh'); exit;
					}
					else
				    header('Location:../index.php?p=error');
				}
				elseif($_POST['on']=='album')
				{
					$filename = 'albums';
					$array = 'dyn_content_albums';
					if(isset($_POST['k']) && isset($_POST['title']))
					{
						$dyn_content_albums[uniqid()] = htmlentities($_POST['title']);
						file_put_contents('../core/data/albums.db.php', "<?php \n".'$dyn_content_albums = '.var_export($dyn_content_albums, true).";\n?>");
						header('Location:../index.php?admin&refresh');
						exit;
					}
					else header('Location:../index.php?p=error');
				}
				else header('Location:../index.php?p=error');
  		}
	  	else header('Location:../index.php?p=error');
  	}
  	else header('Location:../index.php?p=error');
  }

  include('../views/_layout_header.php');
  include('../views/_layout_navbar.php');
?>
	<div class="container">
	  <form action="set.php" method="post" class="row" enctype="multipart/form-data">
	    <div class="control-group">
	  	<?php
	  	  echo '<input type="hidden" name="act" value="'.htmlentities($_GET['act']).'" />';
	  	  echo '<input type="hidden" name="on" value="'.htmlentities($_GET['on']).'" />';
	  	  echo '<input type="hidden" name="k" value="'.htmlentities($_GET['k']).'" />';
	  	  if($_GET['act'] == "edit") {
	  	  	if($_GET['on'] == "img" && searchMuArray(base64_decode($_GET['k']), $dyn_content_img, 1) !== FALSE) {
	  	  	  $data = $dyn_content_img[searchMuArray(base64_decode($_GET['k']), $dyn_content_img, 1)];
	  		  echo "\n\t\t\t".'<div class="row col-xs-4 col-md-4"><a href="../portfolio/'.$data[1].'" class="thumbnail">';
	  	      echo '<img src="../portfolio/'.$data[1].'" alt="'.$data[1].'" />';
	  	      echo '</a></div>'."\n";
			  echo '<div class="col-md-6"><label for="album">Album</label></div><select name="album" class="col-md-4">';
			  foreach($dyn_content_albums as $code => $title)
			  {
			  	if($code == $data[0]) echo "\t\t\t".'<option value="'.$code.'" selected>'.$title.'</option>'."\n";
			  	else echo "\t\t\t".'<option value="'.$code.'">'.$title.'</option>'."\n";
			  }
			  echo '</select>';
	  	  	  echo '<div class="col-md-6"><label for="desc">New description</label></div><input type="text" class="col-md-4" value="'.$dyn_content_img[searchMuArray(base64_decode($_GET['k']), $dyn_content_img, 1)][2].'" name="desc" />';
	  	  	}
	  	  	else if($_GET['on'] == "yt" && isset($dyn_content_yt[base64_decode($_GET['k'])])) {
	  	  	  $data = $dyn_content_yt[base64_decode($_GET['k'])];
	  	  	  echo "\n\t\t\t".'<div class="embed-responsive embed-responsive-16by9">'
	  	  	    	 .'<div class="youtube embed-responsive-item" id="'.base64_decode($_GET['k']).'"></div></div>';
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="title">New title</label></div><div class="col-md-6"><input type="text" value="'.$data[0].'" name="title" /></div></div>';
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="desc">New description</label></div><div class="col-md-6"><input type="text" value="'.$data[1].'" name="desc" /></div></div>';
	  	  	}
	  	  	else if($_GET['on'] == "album" && isset($dyn_content_albums[base64_decode($_GET['k'])])) {
	  	  	  $data = $dyn_content_albums[base64_decode($_GET['k'])];
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="title">New title</label></div><div class="col-md-6"><input type="text" value="'.$data.'" name="title" /></div></div>';
	  	  	}
	  	  }
	  	  else if($_GET['act'] == "del") {
	  	  	if($_GET['on'] == "img" && searchMuArray(base64_decode($_GET['k']), $dyn_content_img, 1) !== FALSE) {
	  	  	  echo '<div class="col-md-6"><label for="desc">Confirm deletion</label></div><div class="col-md-6"><input type="checkbox" value="1" name="confirm" /></div>';
	  	  	}
	  	  	else if($_GET['on'] == "yt" && isset($dyn_content_yt[base64_decode($_GET['k'])])) {
	  	  	  echo '<div class="col-md-6"><label for="desc">Confirm deletion</label></div><div class="col-md-6"><input type="checkbox" value="1" name="confirm" /></div>';
	  	  	}
	  	  	else if($_GET['on'] == "album" && isset($dyn_content_albums[base64_decode($_GET['k'])])) {
	  	  	  echo '<div class="col-md-6"><label for="desc">Confirm deletion</label></div><div class="col-md-6"><input type="checkbox" value="1" name="confirm" /></div>';
	  	  	}
	  	  }
	  	  else if($_GET['act'] == "add") {
	  	  	if($_GET['on'] == "img" && $_GET['k'] == "new") {
	  	  	  echo '<h3>Add new image</h3><br /><div class="row"><div class="col-md-6"><label for="title">Title</label></div><input type="text" name="title" class="col-md-4" /></div><br />';
			  echo '<div class="row"><div class="col-md-6"><label for="album">Album</label></div><select name="album" class="col-md-4">';
			  foreach($dyn_content_albums as $code => $title)
			  {
			  	if($code == $data[0]) echo "\t\t\t".'<option value="'.$code.'" selected>'.$title.'</option>'."\n";
			  	else echo "\t\t\t".'<option value="'.$code.'">'.$title.'</option>'."\n";
			  }
			  echo '</select></div><br />';
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="title">File</label></div><div class="control-group "><div class="controls"><div class="input-prepend"><div class="fileupload fileupload-new" data-provides="fileupload">'
	              	.'<div><input type="hidden" name="MAX_FILE_SIZE" value="20480000" /><input class="col-md-4" type="file" name="image" /></span></div></div></div></div></div></div>';
	  	  	}
	  	  	else if($_GET['on'] == "yt" && $_GET['k'] == "new") {
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="title">Title</label></div><div class="col-md-6"><input type="text" name="title" /></div></div>';
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="desc">Description</label></div><div class="col-md-6"><input type="text" name="desc" /></div></div>';
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="key">Youtube ID</label></div><div class="col-md-6"><input type="text" name="key" /></div></div>';
	  	  	}
	  	  	else if($_GET['on'] == "album" && $_GET['k'] == "new") {
	  	  	  echo '<div class="row"><div class="col-md-6"><label for="title">Title</label></div><div class="col-md-6"><input type="text" name="title" /></div></div>';
	  	  	}
	  	  }
	  	?>
	  	</div>
	  	<div class="row"><div class="col-md-6"><div class="control-group text-center"><div class="controls"><br /><input type="submit" value="Apply Changes" /></div></div></div></div><p>&nbsp;</p>
	  </form>
	</div>
<?php include('../views/_layout_footer.php'); ?>