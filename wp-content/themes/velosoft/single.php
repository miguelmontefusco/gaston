<!-- Archivo de cabecera global de Wordpress -->
<?php get_header(); ?>
<!-- Contenido del post -->
<?php if ( have_posts() ) : the_post(); ?>

  <div class="row">
      <div class="col l10 offset-l1 m12 s12">
        <div class="col l12 m12 s12 titulo-anterior">
          <p><h1><?php the_title(); ?></h1></p>
        </div>
        <div class="col l12 m12 s12 Subtitulo-informacion">
          <div class="col l12 m12 s12">
            <div class="item-content lista-cara">
              <figure-anterior>
                <?php echo get_avatar( $comment, 60 ); ?>
              </figure-anterior>
                <ul>
                  <li>
                    <p class="nomargin text-redes" style="margin-top:20px;">POR: <?php the_author_posts_link() ?> // <time datatime="<?php the_time('Y-m-j'); ?>"><?php the_time('j F, Y'); ?></time></p>
                  </li>
                  <li>
                    <p class="nomargin text-redes"><i class="fa fa-facebook" aria-hidden="true"></i><?php echo ' '  . esc_attr( get_the_author_meta( 'facebook' ) ); ?></p>
                  </li>
                  <li>
                    <p class="nomargin text-redes"><i class="fa fa-instagram" aria-hidden="true"></i><?php echo ' '  . esc_attr( get_the_author_meta( 'instagram' ) ); ?></p>
                  </li>
                  <li>
                    <p class="nomargin text-redes"><i class="fa fa-twitter" aria-hidden="true"></i><?php echo ' '  . esc_attr( get_the_author_meta( 'twitter' ) ); ?></p>
                  </li>
                </ul>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col l10 offset-l1 m12 s12">
        <?php  
          if (has_post_thumbnail()) {
            $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            echo '<li class="img_articulos_bg" style="background: url('. $url.')">';
        }

         ?>
      </div>
    </div>
    <div class="row nomargin">
      <div class="col l10 offset-l1">
        <div class="col l6 m12 s12 tags-compartir">
          <p class="nomargin"><i class="fa fa-share-alt" aria-hidden="true"></i>compartir</p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col l10 offset-l1">
        <div class="col l6">
          <div class="col l12 texto-contenido">
            <p class="margin-30"><?php the_content(); ?>
            </p>
          </div>
          <div class="col l12 m12 s12">
            <form>
             <?php comments_template(); ?>
            </form>
          </div>
      </div>
      <div class="col l6 center texto-tags">
        <p class="nomargin borde-tags">TAGS</p>
          <div class="col l12 m12 s12 pleca-tags">
            <ul class="tags">

              <?php the_tags('<li class="tag"> libros','</li><li class="tag">','</li>'); ?>

            </ul>
          </div>
          <div class="col l12 m12 s12 tags" style="margin-top:50px;">
            <p class="nomargin borde-tags">ARTÍCULOS SUGERIDOS</p>
          </div>
          <div class="col l12 m12 s12 text-imagen">
          <?php wp_related_posts()?>
          </div>
          <div class="col l12 m12 s12 tags-comentario">
            <p>
              25 comentarios
            </p>
          </div>
          <div class="row">
            <div class="col l12 m12 s12 tags-flecha">
              <div class="col l6 m6 s6">
                <p>
                  <i class="material-icons">keyboard_backspace</i> Anterior
                </p>
              </div>
              <div class="col l6 m6 s6">
                <p>
                   Siguiente <i class="material-icons">arrow_forward</i>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--<section> 
    <h1><?php the_title(); ?></h1>
    <time datatime="<?php the_time('Y-m-j'); ?>"><?php the_time('j F, Y'); ?></time>
    <?php the_category (); ?>
    <?php the_content(); ?>
    <?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>  
    <address>Por <?php the_author_posts_link() ?></address> -->
    <!-- Comentarios -->
  
  </section>
<?php else : ?>
  <p><?php _e('Ups!, esta entrada no existe.'); ?></p>
<?php endif; ?>
<!-- Archivo de barra lateral por defecto -->






<?php get_sidebar(); ?>
<!-- Archivo de pié global de Wordpress -->
<?php get_footer(); ?>