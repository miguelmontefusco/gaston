<?php


/**
 * Crear nuestros menús gestionables desde el
 * administrador de Wordpress.
 */

function mis_menus() {
  register_nav_menus(
    array(
      'navegation' => __( 'Menú de navegación' ),
    )
  );
}
add_action( 'init', 'mis_menus' );

/**
 * Crear una zonan de widgets que podremos gestionar
 * fácilmente desde administrador de Wordpress.
 */

function mis_widgets(){
 register_sidebar(
   array(
       'name'          => __( 'Sidebar' ),
       'id'            => 'sidebar',
       'before_widget' => '<div class="widget">',
       'after_widget'  => '</div>',
       'before_title'  => '<h3>',
       'after_title'   => '</h3>',
   )
 );
}
add_action('init','mis_widgets');

/**
 * Filtrar resultados de búsqueda para que solo muestre
 * posts en el listado
 */

function buscar_solo_posts($query) {
 if($query->is_search) {
   $query->set('post_type','post');
 }
 return $query;
}
add_filter('pre_get_posts','buscar_solo_posts');

/** Imagenes destacas **/

if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails' );

function my_new_contactmethods( $contactmethods ) {
// Add Twitter
$contactmethods['twitter'] = 'Twitter';
//add Facebook
$contactmethods['facebook'] = 'Facebook';
// Add Instragram
$contactmethods['instagram'] = 'Instagram';



 
return $contactmethods;
}
add_filter('user_contactmethods','my_new_contactmethods',10,1);

if ( function_exists('register_sidebars') )
    register_sidebars();

add_theme_support( 'post-thumbnails' );