<?php

  // Get your keys from https://www.google.com/recaptcha/admin/create
  $cfg_CaptchaPublicKey = "";
  $cfg_CaptchaPrivateKey = "";

  $cfg_Routes = array(
  	  //anchor         		     text
  	  'index' 			=> 'Home', 
  	  'anime' 			=> 'Animations',
  	  'portfolio' 			=> 'Portfolio',
  	  ':wordpress.com' 		=> 'Blog',        //external links start with ":" (comment to hide)
  	);

  $cfg_ItemsPerRow 	= 3;

  $cfg_UploadValidFormats = array("jpg","jpeg", "png", "gif", "bmp");
  $cfg_UploadPath = "portfolio/";

  function br2nl( $input ) {
	return preg_replace('/<br(\s+)?\/?>/i', "", $input);
  }

  function searchMuArray($needle, $array, $index, $strict = false, $offset = false){
    $ret = FALSE;
    $i = 0;
    foreach($array as $k => $data)
    {
      if(($strict && $data[$index]===$needle) || (!$strict && $data[$index]==$needle)) {

        if(!$offset) $ret = $k;
        else $ret = $i;

        break;
      }
      $i++;
    }
    return $ret;
  }
?>
