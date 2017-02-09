<!DOCTYPE html>
 <html lang="<?php bloginfo('language'); ?>">
   <head>
      <meta charset="<?php bloginfo('charset'); ?>">
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/materialize.css"  media="screen,projection"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/font-awesome.css">     
      <link href="<?php bloginfo('template_url'); ?>/css/video-play.css" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/jquery.bxslider.css"/>
      <link type="text/css" rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css" />
   </head>
   <title>Gaston Lombardi</title>
   <body>
    <nav>
      <div class="nav-wrapper">
        <a href="<?php echo site_url(); ?>" class="brand-logo"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="Gaston"></a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="<?php echo site_url("prensa");?>">Prensa</a></li>
          <li><a href="<?php echo site_url("articulos");?>">Articulos</a></li>
          <li><a href="<?php echo site_url("video");?>">Videos</a></li>
          <li><a href="#contacto">Contacto</a></li>
          <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/buscar.png" alt="Gaston Lombardi" style="width:15px;"></a></li>
          <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/face.png" alt="Gaston Lombardi" width="8px"></a></li>
          <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/instagram.png" alt="Gaston Lombardi" width="13px"></a></li>
          <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/youtube.png" alt="Gaston Lombardi" width="17px"></a></li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li><a href="prensa.php">Prensa</a></li>
          <li><a href="articulos.php">Articulos</a></li>
          <li><a href="video.php">Videos</a></li>
          <li><a href="#contacto">Contacto</a></li>
        </ul>
      </div>
    </nav>
