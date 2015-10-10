<?php
    session_start();
    if(!isset($_SESSION['logged_admin'])) { header('Location:../index.php?admin'); }

	require_once('../core/config.php');
	require_once('../core/data/global.db.php');

	foreach($cfg_Routes as $tmp_R => $tmp_D) if($tmp_R[0]!==':') include('../core/data/'.$tmp_R.'.db.php');

    if(isset($_POST['on']))
    {
    	if($_POST['on']=="index" && isset($_POST['siteIntro']) && isset($_POST['intro_ani']) && isset($_POST['intro_img']))
    	{
    		$ani = array(htmlentities(base64_decode($_POST['intro_ani'])));
    		$file = "<?php\n\t";
    		$file .= '$dyn_intro_content = '. var_export(nl2br($_POST['siteIntro']), true).';'."\n\t";
    		$file .= '$dyn_intro_content_yt = '. var_export($ani, true).';'."\n\t";
    		$file .= '$dyn_intro_content_img =  array(';
    		if(array_search("no", $_POST['intro_img'])===FALSE)
    		{
    			foreach($_POST['intro_img'] as $img) { $file .= "\n\t".var_export(htmlentities(base64_decode($img)), true).','; }
    		}
    		$file .= "\n".');'."\n";
    		$file .= '?>';
    		file_put_contents('../core/data/'.$_POST['on'].'.db.php', $file);
    		header('Location:../index.php?admin&refresh');
    	}
    	elseif($_POST['on']=="global" && isset($_POST['siteName']) && isset($_POST['siteDesc']))
    	{
    		file_put_contents('../core/data/'.$_POST['on'].'.db.php', "<?php \n\t".'$cfg_SiteName = '.var_export(htmlentities($_POST['siteName']), true).";\n\t".'$cfg_SiteDesc = '.var_export(htmlentities($_POST['siteDesc']), true).";\n?>");
    		header('Location:../index.php?admin&refresh');
    	}
    	else
    		print_r($_POST);exit;header('Location:../index.php?p=error');
    }
  	else
  		header('Location:../index.php?p=error');
?>