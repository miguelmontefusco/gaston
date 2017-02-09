<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>">
     <!--Import Google Icon Font-->
     <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <!--Import materialize.css-->
     <link type="text/css" rel="stylesheet" href="<?php bloginfo("template_url");?>/css/materialize.css"  media="screen,projection"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
     <link rel="stylesheet" href="<?php bloginfo("template_url");?>/css/font-awesome.css">
     <link href="<?php bloginfo("template_url");?>/css/video-play.css" rel="stylesheet">
     <link type="text/css" rel="stylesheet" href="<?php bloginfo("template_url");?>/css/jquery.bxslider.css"/>
     <script type="text/javascript" src="<?php bloginfo("template_url");?>/js/jquery.bxslider.min.js"></script>
     <script type="text/javascript" src="<?php bloginfo("template_url");?>/js/jquery.bxslider.js"></script>
     <script type="text/javascript" src="<?php bloginfo("template_url");?>/js/jquery.easing.1.3.js"></script>
     <script type="text/javascript" src="<?php bloginfo("template_url");?>/js/jquery.fitvids.js"></script>
    <?php wp_head(); ?>
  </head>
  <body>
    <header>
     <!-- <h1><?php bloginfo('name'); ?></h1> -->
    </header>
    <nav class="nav-wrapper">
      <div class="brand-logo"><a href="#"><img src="<?php bloginfo("template_url");?>/images/logo.png" alt="Gaston"></a></div>
      <ul class="right hide-on-med-and-down">
        <?php wp_nav_menu( array( 'theme_location' => 'navegation' ) ); ?>
      </ul>
    </nav>