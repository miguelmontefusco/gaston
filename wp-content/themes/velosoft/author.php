<!-- Archivo de cabecera global de Wordpress -->
<?php get_header(); ?>
<!-- Autor -->
<p>Posts de <strong><?php echo get_the_author(); ?></strong></p>
<?php echo $curauth->twitter; ?>
<!-- Archivo de pié global de Wordpress -->
<?php get_footer(); ?>