<?php
/*
Template Name: Archive
*/
  get_header();
?>
<?php get_search_form(); ?>
<div class="row">    
<?php while (have_posts()) : the_post(); ?>
<!--fala los post de la categoria-->
<div class="col l12 m12 s12 historial" style="margin-top:50px;">
<a href="<?php the_permalink(); ?>" style="color:#000;" >
    <div class="col s12 m12 l6 imagenfija">        
            <?php 
        if (has_post_thumbnail()) {
            $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );                                    
            echo "<img src='". $url."' class='' />";
            //echo '<li class="imagenfija" style="background: url('. $url.')">';
     }?>
               
    </div>
    <div class="col s12 m6 l6">
        <div class="col s12 m12 l12">
            <div class="col s12 m12 l12 historial-title">
                <p class="titulo-categorias" id="post-<?php the_ID(); ?>">
                    <a class="a" href="<?php the_permalink() ?>" ><?php the_title(); ?></a>
                </p>
            </div>
            <div class="col l6 m6 s6 text-subtitle">
                <p>
                     <?php echo the_category() ?>
                </p>
            </div>
            <div class="col l6 m6 s6 text-subtitle center nopadding">
                <p>
                    <?php echo get_the_date( get_option('date_format') ); ?>
                </p>
            </div>
            <div class="col l12 m12 s12 text-historial">
                <p>
                     <?php echo get_the_excerpt( get_the_ID() ) ?>
                </p>
            </div>
            <div class="col l6 m6 s6 text-compartir">
                <span class='st_facebook_large' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
                <span class='st_twitter_large' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>         
                <span class='st_plusone_large social' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>

</div>
<?php get_footer(); ?>

