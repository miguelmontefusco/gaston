<?php
/**
* Template Name: Plantilla de Contacto
*/
?>
<!-- Archivo de cabecera gobal de Wordpress -->
<?php get_header(); ?>
<!-- Contenido de página de inicio -->
<?php if ( have_posts() ) : the_post(); ?>
<section>
<!-- <h1><?php the_title(); ?></h1>
   <?php the_content(); ?> -->
<div class="row">
  <div class="col l12 m12 s12 bg-lombardi" >
    <div class="col l9 m9 s12">
      <?php echo do_shortcode('[text-blocks id="46"]'); ?>
    </div>
    <div class="col l3 m12 s12 text-bg">
      <?php echo do_shortcode('[text-blocks id="texto-home"]'); ?>
    </div>
  </div>
  <div class="col l12 m12 s12 text-slider">
    <div class="col l4 m12 s12 margin-80">
      <?php echo do_shortcode('[text-blocks id="52"]'); ?>
    </div>
    <div class="col l8 m12 s12 center gastonvideo">
      <?php echo do_shortcode('[wonderplugin_gallery id="1"]'); ?>
    </div>
  </div>
  <div class="col l12 m12 s12 destacados">
    <p class="nomargin">ARTÍCUL<span style="border-bottom: 4px solid #000; padding-bottom:8px;">OS DE</span>STACADOS</p>
  </div>
  <div class="col l12 m12 s12" style="padding:0px;">
 <!--   <?php 
      $videos = get_field("slider_video", 98);
      foreach ($videos as $key => $value) {
        # code...
        echo '<iframe width="420" height="315"
src="https://www.youtube.com/embed/'.$value['url_video'].'">
</iframe>';
echo "<img src='https://img.youtube.com/vi/".$value["url_video"]."/0.jpg'><br>";
echo "<img src='https://img.youtube.com/vi/".$value["url_video"]."/1.jpg'><br>";
echo "<img src='https://img.youtube.com/vi/".$value["url_video"]."/2.jpg'><br>";
echo "<img src='https://img.youtube.com/vi/".$value["url_video"]."/3.jpg'><br>";
echo "<br>";
echo "<br>";
      }
     ?> -->
    <?php masterslider(1); ?>
  </div>

<div class="row">
    <div class="col l12 m12 s12 articulos_gaston bgarticulos_home">
  <?php
  global $post;
  $args = array( "posts_per_page" => 3, "offset"=> 0, "category" => 1 );
  $myposts = get_posts( $args );
  foreach( $myposts as $post ) : setup_postdata($post); ?>


  <div class="col l4 m6 s12 size relative bglombardi">
    <a href="<?php the_permalink(); ?>">
    <div class="imggastonblog">
    <?php the_post_thumbnail("full"); ?>
    <div class="col l5 m5 s5 text-titulo nopadding">
    <?php the_title(); ?>
    </div>
    <div class="col l7 m7 s7 text-fecha nopadding">
      <?php echo get_the_date( get_option('date_format') ); ?>
    </div>
    <div class="col l12 m12 s12 text-contenido">
      <?php echo get_the_excerpt( get_the_ID() ) ?> 
      
    </div>
              <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
                <div class="col 12 m12 s8 titulo_articulos_home">
                  <a href="<?php the_permalink(); ?>">Leer más 
                    <i class="material-icons">arrow_forward</i></a>
                </div>
              </div>

    </div>
  </div>
  <?php endforeach; ?>
  </div>

</div>
  <div class="col l12 m12 s12">
    <?php echo do_shortcode(' [masterslider id="3"] '); ?>
  </div>
<div class="row">
    <div class="col l12 m12 s12 articulos_gaston bgarticulos_home2">
  <?php
  global $post;
  $args = array( "posts_per_page" => 3, "offset"=> 0, "category" => 3 );
  $myposts = get_posts( $args );
  foreach( $myposts as $post ) : setup_postdata($post); ?>


  <div class="col l4 m6 s12 size relative bglombardi">
    <a href="<?php the_permalink(); ?>">
    <div class="imggastonblog">
    <?php the_post_thumbnail("full"); ?>
    <div class="col l5 m5 s5 text-titulo nopadding">
    <?php the_title(); ?>
    </div>
    <div class="col l7 m7 s7 text-fecha nopadding">
      <?php echo get_the_date( get_option('date_format') ); ?>
    </div>
    <div class="col l12 m12 s12 text-contenido">
      <?php echo get_the_excerpt( get_the_ID() ) ?> 
      
    </div>
              <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
                <div class="col 12 m12 s8 titulo_articulos_home">
                  <a href="<?php the_permalink(); ?>">Leer más 
                    <i class="material-icons">arrow_forward</i></a>
                </div>
              </div>

    </div>
  </div>
  <?php endforeach; ?>
  </div>

</div>


</section>
<?php endif; ?>
<!-- Archivo de barra lateral por defecto -->
<?php get_sidebar(); ?>
<!-- Archivo de pié global de Wordpress -->
<?php get_footer(); ?>