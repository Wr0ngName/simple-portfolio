<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $cfg_SiteName; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta charset="UTF-8">
	<meta name="description" content="<?php echo $cfg_SiteName.', '.$cfg_SiteDesc; ?>">
	<meta name="keywords" content="artist, concept, art, 3d, character, portfolio, animation, graphic, design, 2d, drawing">
	<meta name="author" content="<?php echo $cfg_SiteName; ?>">

	<link href=".<?php if(isset($subz)) echo $subz; ?>/assets/css/normalize.css" rel="stylesheet">
	<link href=".<?php if(isset($subz)) echo $subz; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="data:text/css;charset=utf-8," data-href=".<?php if(isset($subz)) echo $subz; ?>/assets/css/bootstrap-theme.min.css" rel="stylesheet" id="bs-theme-stylesheet">
	<link href=".<?php if(isset($subz)) echo $subz; ?>/assets/css/main.css" rel="stylesheet">

	<?php if(isset($_GET['refresh'])) echo '<meta http-equiv="refresh" content="3; url=./index.php?admin">'; ?>
</head>
<body>
  <div class="container">
    <h2 class="right_title"><?php echo $cfg_SiteDesc; ?></h2>
