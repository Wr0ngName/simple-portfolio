<?php
  session_start();
  
  require_once('core/config.php');
  require_once('core/data/global.db.php');
  require_once('core/data/albums.db.php');
  require_once('core/data/portfolio.db.php');

  require_once('views/_layout_header.php');
  require_once('views/_layout_navbar.php');

  if(is_file('./install.php')) {
    include('./install.php');
  }
  else
  {
    $cur_Route = (isset($_GET['p'])?htmlspecialchars($_GET['p']):'index');

    if(isset($_GET['login'])) {
      require_once('./admin/login.php');
    } else if(isset($_GET['logout'])) {
      session_destroy();
      header('Location:index.php');
    } else if(isset($_GET['admin'])) {
      if(!isset($_SESSION['logged_admin'])) { require_once('./admin/login.php'); exit; }
      foreach($cfg_Routes as $tmp_R => $tmp_D) if($tmp_R[0]!==':') require_once('core/data/'.$tmp_R.'.db.php');
      require_once('admin/index.php');
    } else if (array_key_exists($cur_Route, $cfg_Routes)) {
      require_once('core/data/'.$cur_Route.'.db.php');
      require_once('views/'.$cur_Route.'.tpl.php');
      if($cfg_Count) require_once('core/counter.php');
    } else
    	require_once('views/error.tpl.php');
  }

  require_once('views/_layout_footer.php');
?>
