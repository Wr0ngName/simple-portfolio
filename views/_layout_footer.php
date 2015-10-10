  </div><p>&nbsp;</p><p>&nbsp;</p>
  <?php if(!isset($subz)) { ?><p class="text-right" style="font-size:0.8em; margin-right:10px;">Website by <a href="http://wr0ng.name" target="_blank">wr0ng.name</a> &nbsp; <?php if(isset($_SESSION['logged_admin'])) { ?><a href="index.php?admin" class="btn btn-default btn-xs">Admin</a> &nbsp; <a href="index.php?login&amp;edit" class="btn btn-default btn-xs">Edit</a> &nbsp; <a href="index.php?logout" class="btn btn-default btn-xs">Logout</a><?php } ?></p><?php } ?>
  <script src=".<?php if(isset($subz)) echo $subz; ?>/assets/js/jquery.min.js"></script>
  <script src=".<?php if(isset($subz)) echo $subz; ?>/assets/js/bootstrap.min.js"></script>
  <script src=".<?php if(isset($subz)) echo $subz; ?>/assets/js/main.js"></script>
</body>
</html>