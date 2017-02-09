<?php
/**
Template Name: articulos
**/
require("functions.php");

get_header();
?>

<body class="bg">
  <div class="row">
    <div class="col l12 m12 s12 nopadding">
      <img src="<?php bloginfo('template_url'); ?>/images/cafe.jpg" class="nopadding" alt="Gaston Lombardi" width="100%">
    </div>
    <div class="col l10 offset-l1 m12 s12 margin-50">
      <div class="col l3 m6 s12">
        <div class="col l12 m12 s12 select-caballo-div nomargin" style="margin-top:5px;">
           <?php wp_dropdown_categories( $args ); ?> 
        </div>
      </div>
      <div class="col l4 m6 s12">
        <div class="col l12 m12 s12 select-caballo-div" style="margin-top:5px;">
           <?php wp_dropdown_users( $args ); ?> 
        </div>
      </div>
      <div class="col l5 m8 offset-m2 s12" style="margin-top:15px;">
        <div class="col l8 m7 s10 offset-s1" style="padding-left:0px; margin-bottom:10px;">
          <input id="Buscar" type="email" class="validate" placeholder="NOMBRE DEL ARTICULO">
        </div>
        <div class="col l4 m5 s4 offset-s4 nopadding" style="margin-bottom:10px;">
          <input class="btn hvr-shutter-in-vertical" type="submit" value="Buscar"></input>
        </div>
      </div>
    </div>
    <div class="row nopadding">
      <div class="col s12 m10 offset-m1 l10 offset-l1 margin-30 nopadding">
        <div class="col s3 m3 l4 div-tam center-align nopadding">
          <div class="linea"></div>
        </div>
        <div class="col s6 m6 l4 div-tam center-align borde-articulos nopadding">
          ÚLTIMAS NOTICIAS
        </div>
        <div class="col s3 m3 l4 div-tam center-align nopadding">
          <div class="linea"></div>
        </div>
      </div>
    </div>
    <div class="col l12 m12 s12 margin-30">
     <?php
    global $post;
    $args = array( "posts_per_page" => 3, "offset"=> 0, "category" => 10 );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) : setup_postdata($post); ?>
    <div class="col l4 m6 s12" style="margin-bottom:20px;">
      <div class="col l12 m12 s12 size relative nopadding">
        <a href="<?php the_permalink(); ?>"></a>
        <div class="imggastonblog">
          <?php  
          if (has_post_thumbnail()) {
            $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            echo '<li class="img_articulos_bg" style="background: url('. $url.')">';}?>          
        </div>
        <div class="col s12 m12 l12 nopadding nomargin">
        	<div class="col l5 m8 s5 text-titulo nopadding">
            <?php echo the_category() ?>
          </div>
          <div class="col l7 m4 s7 text-fecha nopadding">
            <?php echo get_the_date( get_option('date_format') ); ?>
          </div>
        </div>          
          <div class="col l12 m12 s12 text-contenido">
            <?php the_title(); ?>    
          </div>
          <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
            <div class="col 12 m12 s8 titulo_articulos_home">
              <a href="<?php the_permalink(); ?>">Leer más <i class="material-icons">arrow_forward</i></a>
            </div>
          </div>
        </div>      
    </div>
    <?php endforeach; ?>
</div>
<div class="row nopadding">
  <div class="col s12 m12 l10 offset-l1 margin-70 nopadding">
    <div class="col s3 m4 l4 div-tam center-align nopadding">
      <div class="linea"></div>
    </div>
    <div class="col s6 m4 l4 div-tam center-align borde-articulos nopadding">
      MÁS LEÍDAS
    </div>
    <div class="col s3 m4 l4 div-tam center-align nopadding">
      <div class="linea"></div>
    </div>
  </div>
</div>
<div class="row"><!--mas leidas-->
<div class="col l12 m12 s12 articulos_gaston bgarticulos_home slider-articulos size-articulos">
  <div class="slidercinco">
    <?php
    global $post;
    $args = array( "posts_per_page" => 3, "offset"=> 0, "category" => 11 );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) : setup_postdata($post); ?>      
    <div class="slide background-opacity">

      <a href="<?php the_permalink(); ?>"></a>
      <div class="col l12 m12 s12  imggastonblog">
        <?php  
        if (has_post_thumbnail()) {
          $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
          echo '<li class="img_articulos_bg" style="background: url('. $url.')">';
        }
        ?>
      </div> 
      <div class="col l5 m5 s5 text-titulo nopadding">
        <?php echo the_category() ?>
      </div>
      <div class="col l7 m7 s7 text-fecha nopadding">
        <?php echo get_the_date( get_option('date_format') ); ?>
      </div>
      <div class="col l12 m12 s12 text-contenido">
        <?php the_title(); ?>       
      </div>
      <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
        <div class="col 12 m12 s8 titulo_articulos_home">
          <a href="<?php the_permalink(); ?>">Leer más <i class="material-icons ">arrow_forward</i></a>
        </div>
      </div>
    </div>          
  <?php endforeach; ?>      
</div>
</div>
   <!-- Botones
   <div class="col l12 m12 s12 center articulos margin-50 slider-articulos">      
      <p> Más articulos</p>
    </div> Fin Botones -->
</div><!--mas leidas-->
<div class="row nopadding">
  <div class="col s12 m12 l10 offset-l1 margin-30 nopadding">
    <div class="col s3 m4 l4 div-tam center-align nopadding">
      <div class="linea"></div>
    </div>
    <div class="col s6 m4 l4 div-tam center-align borde-articulos nopadding">
      MÁS ARTÍCULOS
    </div>
    <div class="col s3 m4 l4 div-tam center-align nopadding">
      <div class="linea"></div>
    </div>
  </div>
</div>

<div class="col s12 m12 l12 masarticuls">
  <div class="slidermasarticulos ">
    <div class="col s12 m12 l12">
      <?php
      global $post;
      $args = array( "posts_per_page" => 5, "offset"=> 0, "category" => 11 );
      $myposts = get_posts( $args );
      foreach( $myposts as $post ) : setup_postdata($post); ?>     
      <div class="slide">    
        <div class="col l4 m4 s12" style="margin-bottom:20px;">      
          <div class="col l12 m12 s12 size relative fondo-blanco">
            <a href="<?php the_permalink(); ?>">
              <div class="imggastonblog">
                <?php if (has_post_thumbnail()) {
                  $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                  echo '<li class="img_articulos_bg" style="background: url('. $url.')">'; } ?>          
                </div></a>
                <div class="col l5 m7 s5 text-titulo ">
                  <?php echo the_category() ?>
                </div>
                <div class="col l7 m5 s7 text-fecha nopadding">
                  <?php echo get_the_date( get_option('date_format') ); ?>
                </div>
                <div class="col l12 m12 s12 text-contenido">
                  <?php the_title(); ?>    
                </div>
                <div class="col l12 m12 s8 offset-s2 text-boton margin-30">
                  <div class="col 12 m12 s8 titulo_articulos_home">
                    <a href="<?php the_permalink(); ?>">Leer más <i class="material-icons">arrow_forward</i></a>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<!---articulos-->
<!-- Botones -->
<div class="row">
  <div class="col l12 m12 s12 articulos margin-50">
    <div class="col l12 m12 s12 center">
      <p>
        <i class="material-icons">keyboard_backspace</i> Más articulos <i class="material-icons">arrow_forward</i>
      </p>
    </div>
  </div>
</div>
<!-- Fin Botones -->
<div class="row hide-on-small-only">
  <div class="col s12 m12 l10 offset-l1 margin-30">
    <div class="col s4 m4 l4 div-tam center-align">
      <div class="linea"></div>
    </div>
    <div class="col s4 m4 l4 div-tam center-align borde-articulos">
      AUTORES
    </div>
    <div class="col s4 m4 l4 div-tam center-align">
      <div class="linea"></div>
    </div>
  </div>
</div>
<div class="col l10 offset-l1 m12 s12 center margin-50 lista-caras autores-slider hide-on-small-only">
<!-- autores-->
<div class="sliderautoresmin">
  <?php for ($i=0; $i <=15; $i++) { ?>
   <div class="slide">
      <div class="col l12 m12 s12 center-align">
        <div class="col l10 offset-l1">
          <img src="<?php bloginfo('template_url'); ?>/images/articulos/circulo.png" alt="user" width="100" height="100">
        </div>
        <p>lorem ipsum</p>
      </div>
    </div>
  <?php } ?>  
  </div> 
</div>
<!-- Botones -->
<div class="row hide-on-small-only">
  <div class="col l12 m12 s12 articulos margin-50">
    <div class="col l12 m12 s12 center">
      <p>
        <i class="material-icons">keyboard_backspace</i> Más articulos <i class="material-icons">arrow_forward</i>
      </p>
    </div>
  </div>
</div>
<!-- Fin Botones -->
</div>

<?php
get_footer();
?>
