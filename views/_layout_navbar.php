	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
	  	<div class="navbar-header">
  	      <a class="navbar-brand" href="index.php">
  	        <?php echo htmlspecialchars($cfg_SiteName); ?>
  	      </a>
  	    </div>
	    <ul class="nav nav-tabs">
<?php
		foreach($cfg_Routes as $link => $data) {
		  echo "\t\t\t"
		  		.'<li role="presentation"'.(((isset($_GET['p']) && $link==$_GET['p'])||($link=="index"&&empty($_GET['p'])))?' class="active"':'').'>'
		  		.'<a href="'.($link[0]==':'?'http://'.substr($link, 1).'" target="_blank"':('.'.(isset($subz)?$subz:'').'/index.php?p='.$link.'"')).' role="tab">'
		  		.htmlentities($data).'</a></li>'."\n";
		}
?>
		</ul>
	  </div>
	</nav>
	<p>&nbsp;</p>