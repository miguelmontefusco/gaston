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
      <img src="<?php bloginfo('template_url'); ?>/images/articulos/cafe.png" class="nopadding" alt="Gaston Lombardi" width="100%">
    </div>
    <div class="col l10 offset-l1 m12 s12 margin-50">
      <div class="col l3 m6 s12">
        <div class="col l12 m12 s12 select-caballo-div nomargin" style="margin-top:5px;">
          <select browser-default class="select-wrappe">
            <option value="" disabled selected>TEMAS</option>
            <option value="1">Gaston Lombardi</option>
            <option value="2">Gaston Lombardi</option>
            <option value="3">Gaston Lombardi</option>
          </select>
        </div>
      </div>
      <div class="col l4 m6 s12">
        <div class="col l12 m12 s12 select-caballo-div" style="margin-top:5px;">
          <select browser-default class="select-wrappe">
            <option value="" disabled selected>NOMBRE DEL AUTOR</option>
            <option value="1">Gaston Lombardi</option>
            <option value="2">Gaston Lombardi</option>
            <option value="3">Gaston Lombardi</option>
          </select>
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
    <div class="row">
      <div class="col s12 m10 offset-m1 l10 offset-l1 margin-30">
        <div class="col s4 m4 l4 div-tam center-align">
          <div class="linea"></div>
        </div>
        <div class="col s4 m4 l4 div-tam center-align borde-articulos">
          ÚLTIMAS NOTICIAS
        </div>
        <div class="col s4 m4 l4 div-tam center-align">
          <div class="linea"></div>
        </div>
      </div>
    </div>
    <div class="col l12 m12 s12 margin-30">
     <?php
    global $post;
    $args = array( "posts_per_page" => 1, "offset"=> 0, "category" => 9 );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) : setup_postdata($post); ?>
       <div class="col l4 m6 s12" style="margin-bottom:20px;">
        <div class="col l12 m6 s12 size relative bglombardi">
    <a href="<?php the_permalink(); ?>"></a>
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
              <a href="<?php the_permalink(); ?>">Leer más <i class="material-icons">arrow_forward</i></a>
            </div>
          </div>
        </div>
      </div>
       <?php endforeach; ?>
 </div>
 <div class="col l8 m6 s12">
   <?php
    global $post;
    $args = array( "posts_per_page" => 1, "offset"=> 0, "category" => 3 );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) : setup_postdata($post); ?>
    <div class="col l12 m12 s12 nomargin nopadding">
      <a href="<?php the_permalink(); ?>"></a>
      <div class="col l12 m12 s12 bg-blanco relative imagen-articulo-size">
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
      <div class="col l12 m12 s12 center">
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
<div class="row">
  <div class="col s12 m12 l10 offset-l1 margin-70">
    <div class="col s4 m4 l4 div-tam center-align">
      <div class="linea"></div>
    </div>
    <div class="col s4 m4 l4 div-tam center-align borde-articulos">
      MÁS LEÍDAS
    </div>
    <div class="col s4 m4 l4 div-tam center-align">
      <div class="linea"></div>
    </div>
  </div>
</div>
<div class="row"><!--mas leidas-->
    <div class="col l12 m12 s12 articulos_gaston bgarticulos_home slider-articulos">
      <div class="slidercinco">
      <?php
      global $post;
      $args = array( "posts_per_page" => 5, "offset"=> 0, "category" => 9 );
      $myposts = get_posts( $args );
      foreach( $myposts as $post ) : setup_postdata($post); ?>      
          <div class="slide">
            
              <a href="<?php the_permalink(); ?>"></a>
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
                    <a href="<?php the_permalink(); ?>">Leer más <i class="material-icons ">arrow_forward</i></a>
                  </div>
                </div>
              </div>
            
          </div>
      <?php endforeach; ?>      
      </div>
      
   </div>
   <!-- Botones -->
   <div class="col l12 m12 s12 center articulos margin-50 slider-articulos">      
      <p> Más articulos</p>
    </div><!-- Fin Botones -->
</div><!--mas leidas-->
<div class="row">
  <div class="col s12 m12 l10 offset-l1 margin-30">
    <div class="col s4 m4 l4 div-tam center-align">
      <div class="linea"></div>
    </div>
    <div class="col s4 m4 l4 div-tam center-align borde-articulos">
      MÁS ARTÍCULOS
    </div>
    <div class="col s4 m4 l4 div-tam center-align">
      <div class="linea"></div>
    </div>
  </div>
</div>
<div class="col l12 m12 s12 margin-30">
  <div class="col l8 m6 s12" style="margin-bottom:20px;">
  <?php
    global $post;
    $args = array( "posts_per_page" => 1, "offset"=> 0, "category" => 9 );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) : setup_postdata($post); ?>

    <div class="col l12 m12 s12 nomargin nopadding imagen-articulo-size">
      <a href="<?php the_permalink(); ?>"></a>
      <div class="col l12 m12 s12 bg-blanco relative">
        <div class="row">
         <div class="col l12 m12 s12 margin-10 nopadding">
         <?php the_post_thumbnail("full"); ?>
           <div class="col l5 m5 s5 text-titulo nopadding">
             <?php the_title(); ?>
           </div>
           <div class="col l7 m7 s7 text-fecha nopadding">
            <?php echo get_the_date( get_option('date_format') ); ?>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col l12 m12 s12">
           <div class="col l12 m12 s12 text-contenido">
             <?php echo get_the_excerpt( get_the_ID() ) ?>       
           </div>
         </div>
       </div>
       <div class="col l12 m12 s12 center">
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
 <div class="col l4 m6 s12">
  <?php
    global $post;
    $args = array( "posts_per_page" => 1, "offset"=> 2, "category" => 9 );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) : setup_postdata($post); ?>
      
        <div class="col l12 m12 s12 size relative bglombardi">
    <a href="<?php the_permalink(); ?>"></a>
        <div class="imggastonblog">
          <?php the_post_thumbnail("full"); ?>
          <div class="col l5 m12 s12 text-titulo nopadding">
            <?php the_title(); ?>
          </div>
          <div class="col l7 m12 s12 text-fecha nopadding">
            <?php echo get_the_date( get_option('date_format') ); ?>
          </div>
          <div class="col l12 m12 s12 text-contenido">
            <?php echo get_the_excerpt( get_the_ID() ) ?>       
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
<div class="row">
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
<div class="col l10 offset-l1 m12 s12 center margin-50 lista-caras">
  <ul>
    <li>
      <img src="<?php bloginfo('template_url'); ?>/images/articulos/circulo.png" alt="user" width="100" height="100">
      <p>lorem ipsum</p>
    </li>
    <li>
      <img src="<?php bloginfo('template_url'); ?>/images/articulos/circulo2.png" alt="user" width="100" height="100">
      <p>lorem ipsum</p>
    </li>
    <li>
      <img src="<?php bloginfo('template_url'); ?>/images/articulos/circulo3.png" alt="user" width="100" height="100">
      <p>lorem ipsum</p>
    </li>
    <li>
      <img src="<?php bloginfo('template_url'); ?>/images/articulos/circulo4.png" alt="user" width="100" height="100">
      <p>lorem ipsum</p>
    </li>
    <li>
      <img src="<?php bloginfo('template_url'); ?>/images/articulos/circulo5.png" alt="user" width="100" height="100">
      <p>lorem ipsum</p>
    </li>
  </ul>
</div>
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
</div>

<?php
get_footer();
?>
