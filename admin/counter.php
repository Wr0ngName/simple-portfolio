<?php
  if(!isset($cur_Route)) header('Location:../index.php?admin');
  
  $db = new PDO('sqlite:./core/data/counter.db.sqlite');

  $result = $db->query('SELECT * FROM counter WHERE id=1');

  $res_Counter = $result->fetchColumn(1);

  $db = NULL;
?>
