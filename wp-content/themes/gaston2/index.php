<?php get_header(); ?>
<div class="row">
  <div class="col l12 m12 s12 bg-lombardi" >
    <div class="col l9 m9 s12 hide-on-small-only">
      <?php echo do_shortcode('[text-blocks id="46"]'); ?>
    </div>
    <div class="col l3 m12 s12 text-bg">
       <?php echo do_shortcode('[text-blocks id="texto-home"]'); ?>
    </div>
  </div>
  <div class="col l12 m12 s12 text-slider" style="padding:0px;">
    <img src="<?php bloginfo('template_url'); ?>/images/manchas.png" class="mancha" alt="Gaston Lombardi">
    <div class="col l4 m12 s12 relative margin-80 separacion-home">
       <?php echo do_shortcode('[text-blocks id="52"]'); ?>
    </div>
    <!--Est video -->
    
<div class="col l8 m12 s12 center video-arriba">          
   <?php $videos2 = get_field("slider_video", 98); ?>
     <div class="col s12 m12 l12 remove-control galeria-vid nopadding">
        <ul class="bxsliderr">
          <?php foreach ($videos2 as $key => $value) {?>
          <li>
            <?php   echo "<iframe class='video' height='554' src='https://www.youtube.com/embed/".$value['url_video']."' frameborder='0' allowfullscreen></iframe>"; }?>
          </li>
        </ul>
     </div>
      <div class="col s12 m12 l12 control-vid tumbs-galeria-vid hide-on-small-only">
      <?php $videos2 = get_field("slider_video", 98);  ?>        
        <div id="bx-pagerr">
          <ul id="slider4">               
        <?php
        $count =0; 
        foreach ($videos2 as $key => $value){ ?>
        <li>
          <?php echo "<a data-slide-index=".$count." href=''><img src='https://img.youtube.com/vi/".$value['url_video']."/default.jpg' class='imagen-video-small'/></a>"; ?>            
        </li>
    <?php 
        $count++; 
        } 
        print_r($count);
        ?>
          </ul>          
        </div>
      </div>
    </div>
    <!--fin -->
  </div>

  
  <!--slider articulos-->
  <div class="col l12 m12 s12 destacados">
    <p class="nomargin">ARTÍCUL<span style="border-bottom: 4px solid #000; padding-bottom:8px;">OS DE</span>STACADOS</p>
  </div>
  <div class="col l12 m12 s12 slider-articulos slider-dos remove-control slider-normal hide-on-small-only" style="padding:0px;">
  <?php $args = array( 'category' => '8', );
          $posts_array = get_posts( $args ) ?>
    <ul  id="slider3">
    <?php foreach ($posts_array as $key => $value) {
    	$src=wp_get_attachment_image_src(get_post_thumbnail_id($value->ID),'full');
    		$url=$src[0];
    	echo "<li>
        <div class='col s12 m12 l12 nopadding nomargin'>
           <img src=".$url." class='img-slider-normal'/>
           <p class='titulo-slider-normal'>".$value->post_title."</p>
           <p class='contenido-slider-normal'>".$value->post_content."</p>
        </div>
     </li>";
    } ?>   
    </ul>
  </div>
  <!--Articulos-->
 <div class="row">
    <div class="col l12 m12 s12 articulos_gaston bgarticulos_home">
	  <?php
	  global $post;
	  $args = array( "posts_per_page" => 3, "offset"=> 0, "category" => 11 );
	  $myposts = get_posts( $args );
	  foreach( $myposts as $post ) : setup_postdata($post); ?>
	  <div class="col l4 m6 s12 size relative bglombardi">
	  <a href="<?php the_permalink($post->ID); ?>">
	  		<div class="imggastonblog">
          <div class="col l5 m5 s5 img_articulos_homepage nopadding">
	  			<?php 
            if (has_post_thumbnail()) {
              $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );                    
              //echo "<img src='". $url."' class='img_articulos_bg' />";
              echo '<li class="img_articulos_bg" style="background: url('. $url.')">';
           }?>
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
	  					<a href="<?php the_permalink($post->ID); ?>">Leer más <i class="material-icons">arrow_forward</i></a>
	  				</div>
	  			</div>
	  		</div></a>
	  	</div>
	  <?php endforeach; ?>
	 </div>
</div>
<!--est-->
  <div class="row fondo-libros-gaston">
      <div class="col s12 m12 l10 offset-l1 nopadding" style="margin-top:6%; ">
       <?php 
        $args = array( 'category' => '7',);
        $posts_array = get_posts( $args ); 

      ?>
        <div class="col s12 m10 l8 remove-control nopadding galeria-libro">
          <ul class="bxslider">       
          <?php foreach ($posts_array as $key => $value) {
        $src = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'full' );
                  $url= $src[0]; ?>
           <li>
            <div class="col s12 m12 l12">
                  <div class="col s12 m6 l5">              
                    <img src="<?php echo $url ?>" class="image-book">
                  </div>
                  <div class="col s12 m6 l7 fondolibros" style='position: relative;'>
                    <p class="description-book">LIBRO RECOMENDADO DEL MES<br><span><?php echo $value->post_title; ?></span></p>
                    <p class="content-book"><?php echo $value->post_content; ?></p>                  
                  </div>
              </div>
          </li>           
          <?php } ?>
          </ul>
        </div>
        <div class="col m2 l2 offset-l1 center-align hide-on-small-only caratural-book">
        <?php 
        $args = array( 'category' => '7',);
        $posts_array = get_posts( $args ); ?>
          <div id="bx-pager">
            <ul id="slider2">
            <?php 
              $cont =0;
            foreach ($posts_array as $key => $value){
             $src = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'full' );
                  $url= $src[0]; ?>
          <li><a data-slide-index="<?php echo $cont; ?>" href=""><img src="<?php echo $url ?>" class="tubms" /></a></li>
               <?php 
                $cont ++;               
               } ?>
            </ul>
          </div>
        </div>
      </div>  
      </div>   
      <!--fin est-->
      
    </div>
	</div>
  <div class="col l12 m12 s12" style="padding:0px;">
    <img src="<?php bloginfo('template_url'); ?>/images/linea2.png" alt="Gaston Lombardi" width="100%" class="absolute" style="margin-top: -100px;">
    <div class="col l12 m12 s12 margin-100">
      <div class="col l12 m12 s12 relative">
        <img src="<?php bloginfo('template_url'); ?>/images/ultimas1.png" alt="Gaston Lombardi" width="100%;">
      </div>      
    </div> 
  </div>

<div class="row">
    <div class="col l12 m12 s12 articulos_gaston bgarticulos_home">
    <?php
    global $post;
    $args = array( "posts_per_page" => 3, "offset"=> 0, "category" => 12 );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ) : setup_postdata($post); ?>
    <div class="col l4 m6 s12 size relative bglombardi">
    <a href="<?php the_permalink($post->ID); ?>">
        <div class="imggastonblog">
          <div class="col l5 m5 s5 img_articulos_homepage nopadding">
          <?php 
            if (has_post_thumbnail()) {
              $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );                    
              //echo "<img src='". $url."' class='img_articulos_bg' />";
              echo '<li class="img_articulos_bg" style="background: url('. $url.')">';
           }?>
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
              <a href="<?php the_permalink($post->ID); ?>">Leer más <i class="material-icons">arrow_forward</i></a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
   </div>
</div>


</section>
  <!-- Fin Botones -->

<?php get_footer(); ?>
