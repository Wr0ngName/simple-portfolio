	<div class="container">
<?php
	  echo "\n\t\t".'<div class="row">';
	  $i = 0;
	  $dyn_content_img = array_reverse($dyn_content_img);
	  
	  if(!isset($_GET['album']) || !isset($dyn_content_albums[$_GET['album']]))
	  {
	  	foreach($dyn_content_albums as $code => $title)
	  	{
	  		if(searchMuArray($code, $dyn_content_img, 0)!==FALSE)
	  		{
		  		$demo = $dyn_content_img[searchMuArray($code, $dyn_content_img, 0)];
		  		if($i > 0 && $i%$cfg_ItemsPerRow == 0) echo '</div>'."\n\t\t".'<div class="row">';
		  		echo "\n\t\t\t"
		  			.'<div class="col-xs-4 col-md-4"><h2>'.$title.'</h2><a href="index.php?p=portfolio&album='.$code.'" class="thumbnail">'
		  	    	.'<img src="./portfolio/'.$demo[1].'" alt="'.$demo[2].'" style="display:block; max-width:100%; max-height:260px; width:auto; height:auto; margin:auto;" /></a>'
		  	    	.'</div>';

			  	$i++;
	  		}
	  	}
	  }
	  else
	  {
	  	echo "\n\t\t".'<div class="row text-center"><h2>'.$dyn_content_albums[$_GET['album']].'</h2>';
		  foreach($dyn_content_img as $data)
		  {
		  	if($data[0]==$_GET['album']) 
		  	{
		  		if($i > 0 && $i%$cfg_ItemsPerRow == 0) echo '</div>'."\n\t\t".'<div class="row">';

		  		echo "\n\t\t\t"
		  			.'<div class="col-xs-4 col-md-4"><a href="#lightbox_no'.$i.'" class="launch-modal thumbnail">'
		  	    	.'<img src="./'.$cfg_UploadPath.$data[1].((isset($data[3])&&$data[3]>0)?'_thumb.jpg':'').'" alt="'.$data[2].'" style="display:block; max-width:100%; max-height:260px; width:auto; height:auto; margin:auto;" /></a></div>'
		  	    	.'<div id="lightbox_no'.$i.'" class="modal bs-example-modal-lg fade" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">'
		  	    	.'<div class="modal-header"><h3>'.$data[2].'</h3></div><div class="modal-body"><img src="./'.$cfg_UploadPath.$data[1].((isset($data[3])&&$data[3]>0)?'_thumb.jpg':'').'" style="display:block; max-width:100%; max-height:80vh !important; width:auto; height:auto; margin:auto;" /></div><div class="modal-footer"><span style="font-weight:normal !important;">Use left and right arrows or the keyborard to navigate  -</span>  <span class="glyphicon glyphicon-chevron-left" onclick="listenButtons(\'prev\');" style="cursor:pointer;"></span> <span style="cursor:pointer;" class="glyphicon glyphicon-chevron-right" onclick="listenButtons(\'next\');"></span>  -  <a href="./'.$cfg_UploadPath.$data[1].'">See fullscreen</a> &nbsp;<button type="button" class="close" data-dismiss="modal">&times;</button></div></div></div></div>'
		  	    	."\n";

			  	$i++;
			}
		  }
	  }
	  echo "\n\t\t".'</div>';
?>
	</div>
	
