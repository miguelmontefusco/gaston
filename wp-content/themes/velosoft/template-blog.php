<?php
/**
* Template Name: Plantilla Para Art
*/
?>
<!-- Archivo de cabecera gobal de Wordpress -->
<?php get_header(); ?>

  <div class="row" style="padding-top:80px;">
    <div class="col l10 offset-l1 m12 s12">
      <?php 
        unset($posts_array[0]);
      ?>
      <?php 
        foreach ($posts_array as $key => $value) { 
          $src = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'full' );//setoma la imagen con thumbnail_id
          $url = $src[0];
      ?>
      <div class="col l4 m6 s12 size">
        <figure class="effect-bubba">
            <a href="<?php echo get_permalink($value->ID); ?>"><img src="<?php echo $url; ?>" alt="Brick"></a>
          <figcaption>            
          </figcaption>
        </figure>
        <div class="row">
          <div class="col l12 m12 s12  text-images">
          <p style="margin-top: 15px;"><?php echo $value->post_title ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col l6 m6 s12  fecha-images">
            <p>
              <span><?php echo  get_the_date('j F, Y',$value->ID); ?></span>
            </p>
          </div>
          <div class="col l6 m6 s12 text-mexico">
            <a href="<?php echo get_permalink($value->ID); ?>"><p class="ver-mas">
              Leer más <img src="<?php bloginfo("template_url");?>/images/blog/flecha-imagen.png" alt="">
            </p></a>
          </div>
        </div>
      </div>
        <?php   
          }
         ?>       
    </div>
  </div>

  <div class="row" style="padding-top:80px;">
    <div class="col l12 m12 s12">
      <img src="images/linea.png" alt="Gaston Lombardi" width="98%" style="position:absolute; margin-top:-65px;">
      <div class="col l4 m6 s12 size relative">
        <img src="images/1.png" alt="Gaston Lombardi" width="100%">
        <div class="row">
          <div class="col l12 m12 s12 margin-10">
            <div class="col l5 m5 s5 text-titulo nopadding">
              S T A R T U P S
            </div>
            <div class="col l7 m7 s7 text-fecha nopadding">
              30 de Octubre del 2016
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col l12 m12 s12">
            <div class="col l12 m12 s12 text-contenido">
              Emprender sin morir en el intento
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col l12 m12 s12 center">
            <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
              <div class="col l7 m7 s7 nopadding">
                <span style="float:right;">Leer más</span>
              </div>
              <div class="col l5 m5 s5 margin-flecha">
                <i class="material-icons" style="float:left;">arrow_forward</i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col l4 m6 s12 size relative">
        <img src="images/2.png" alt="Gaston Lombardi" width="100%">
        <div class="row" style="background:#fff; margin-top:-10px;">
          <div class="row">
            <div class="col l12 m12 s12 margin-10">
              <div class="col l5 m5 s5 text-titulo nopadding">
                S T A R T U P S
              </div>
              <div class="col l7 m7 s7 text-fecha nopadding">
                30 de Octubre del 2016
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col l12 m12 s12">
              <div class="col l12 m12 s12 text-contenido">
                Emprender sin morir en el intento
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col l12 m12 s12 center">
              <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
                <div class="col l7 m7 s7 nopadding">
                  <span style="float:right;">Leer más</span>
                </div>
                <div class="col l5 m5 s5 margin-flecha">
                  <i class="material-icons" style="float:left;">arrow_forward</i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col l4 m6 offset-m3 s12 size relative">
        <img src="images/3.png" alt="Gaston Lombardi" width="100%">
        <div class="row">
          <div class="col l12 m12 s12 margin-10">
            <div class="col l5 m5 s5 text-titulo nopadding">
              S T A R T  U P S
            </div>
            <div class="col l7 m7 s7 text-fecha nopadding">
              30 de Octubre del 2016
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col l12 m12 s12 center">
            <div class="col l12 m12 s12 text-contenido">
              Emprender sin morir en el intento
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col l12 m12 s12 center">
            <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
              <div class="col l7 m7 s7 nopadding">
                <span style="float:right;">Leer más</span>
              </div>
              <div class="col l5 m5 s5 margin-flecha">
                <i class="material-icons" style="float:left;">arrow_forward</i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <img src="images/20minutos.png" class="relative margin-150" alt="" width="100%">
    </div>
  </div>

?>
