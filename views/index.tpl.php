	<div class="container">
	  <div class="col-md-4 text-justify">
	      <?php echo ($dyn_intro_content); ?><br />&nbsp;
	  </div>
	  <div class="col-md-8">
<?php
	  echo "\n\t\t".'<div class="row">';
	  $i = 0;
	  foreach($dyn_intro_content_img as $data)
	  {
	  	if($i > 0 && $i%$cfg_ItemsPerRow == 0) echo '</div>'."\n\t\t".'<div class="row">';

	  	switch (count($dyn_intro_content_img)) {
	  		case 1:
	  			$col = 12;
	  			break;
	  		
	  		case 2:
	  			$col = 6;
	  			break;
	  		
	  		default:
	  			$col = 4;
	  			break;
	  	}

  		echo "\n\t\t\t".'<div class="col-xs-'.$col.' col-md-'.$col.'"><a href="index.php?p=portfolio&amp;album='.$dyn_content_img[searchMuArray($data, $dyn_content_img, 1)][0].'" class="thumbnail">';
  	    echo '<img src="./portfolio/'.$data.'" alt="thumbnail" />';
  	    echo '</a></div>'."\n";

	  	$i++;
	  }
	  echo "\n\t\t".'</div>';

	  foreach($dyn_intro_content_yt as $data)
	  {
	  	if(!empty($data))
	  	{
	  	  	echo "\n\t\t".'<div class="row">';
	  	    echo "\n\t\t\t".'<div class="embed-responsive embed-responsive-16by9">'
	  	    	 .'<div class="youtube embed-responsive-item" id="'.$data.'">'
	  	    	 .'</div></div>';
	  	  	echo "\n\t\t".'</div>';
	  	}
	  }
?>
	  </div>
	</div>