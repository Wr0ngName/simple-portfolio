<?php
  $db = new PDO('sqlite:./core/data/counter.db.sqlite');

  if (!$_SESSION['counter'] && !isset($_SESSION['logged_admin']))
  {
  	$_SESSION['counter'] = true;
    $db->exec("UPDATE counter SET counter = counter + 1 WHERE id = 1");
  }

  $db = NULL;
?>
