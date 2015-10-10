	<div class="container">
<?php
	  $i = 0;
	  $dyn_content_yt = array_reverse($dyn_content_yt);
	  foreach($dyn_content_yt as $link => $data)
	  {
	  	if($i%2==0) {
	  	  echo "\n\t\t".'<div class="row"><div class="col-md-4 text-right legend"><h3>'.$data[0].'</h3>'.$data[1].'</div>';
	  	  echo "\n\t\t\t".'<div class="col-md-8"><div class="embed-responsive embed-responsive-16by9">'
	  	    	 .'<div class="youtube embed-responsive-item" id="'.$link.'">'
	  	    	 .'</div></div>'."\n\t\t".'</div></div>';
	  	}
	  	else
	  	{
	  	  echo "\n\t\t".'<div class="row">';
	  	  echo "\n\t\t\t".'<div class="col-md-8"><div class="embed-responsive embed-responsive-16by9">'
	  	    	 .'<div class="youtube embed-responsive-item" id="'.$link.'">'
	  	    	 .'</div></div>'."\n\t\t".'</div><div class="col-md-4 text-left legend"><h3>'.$data[0].'</h3>'.$data[1].'</div></div>';
	  	}

	  	$i++;
	  }
?>
	</div>
	