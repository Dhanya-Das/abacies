<?php
/**
 * Plugin Name: Abacies APIs
 * Plugin URI: https://abacies.com
 * Description: APIs.
 * Version: 1.0
 * Author: Abacies
 * Author URI: https://abacies.com
 * License: Abacies
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; 
}
define( 'ABACIES_PLUGIN_URL', plugins_url().'/abacies-to-rest-api.php'  );
define( 'ABACIES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

include(ABACIES_PLUGIN_DIR.'/api/listing-api.php');

/*
*API for All list View
http://localhost/abacies/wp-json/view/v1/all-pages
*/

/*
*API for Header Menus
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/header-menu', array(
      'methods' => 'GET',
      'callback' => 'get_header_menus',
  ) );
} );

function get_header_menus() {
  $menu_name = 'header-menu';
  $menu = wp_get_nav_menu_object( $menu_name );
  $menu_items = wp_get_nav_menu_items( $menu->term_id );

  $menu_array = array();
  foreach ( (array) $menu_items as $key => $menu_item ) {
    $postID = $menu_item->ID;
    $slugName = get_post_field( 'post_name', $postID );
    $menu_array[] = array(
      'id' => $menu_item->ID,
      'title' => $menu_item->title,
      'url' => $menu_item->url,
      'menu_item_parent' => $menu_item->menu_item_parent,
      'slug' => $slugName,
      'children' => get_menu_item_children( $menu_items, $menu_item->ID ),
    );
  }
  if( empty($menu_array) ){
    return new WP_Error( 'no_header', __('No post found'), array( 'status' => 404 ) );
  }else {
    return new WP_REST_Response( $menu_array, 200 );
  }
}

function get_menu_item_children( $menu_items, $parent_id ) {
  $children = array();
  foreach ( (array) $menu_items as $menu_item ) {
    if ( $menu_item->menu_item_parent == $parent_id ) {
      $children[] = array(
        'id' => $menu_item->ID,
        'title' => $menu_item->title,
        'url' => $menu_item->url,
        'slug' => get_post_field( 'post_name', $menu_item->ID),
        'children' => get_menu_item_children( $menu_items, $menu_item->ID ),
      );
    }
  }
  return $children;
}

/*
*API for Footer Widget
*/


function register_footer_widget_endpoint() {
  register_rest_route('view/v1', '/footer_widget', array(
      'methods' => 'GET',
      'callback' => 'get_footer_widget_data',
  ));
}

add_action('rest_api_init', 'register_footer_widget_endpoint');


/*
*API for Page Single view
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/view-page/(?P<slug>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_single_page_postType',
  ) );

} );

function get_single_page_postType($request) {
  $params = $request->get_params();
  $slug = $params['slug'];

  $page = get_page_by_path( $slug );
  if ( ! $page ) {
    return new WP_Error( '404', 'Page not found', array( 'status' => 404 ) );
  }
  $post_meta = get_post_meta($page->ID);
  $page_data = array(
    'id' => $page->ID,
    'post_meta' => $post_meta,
    'title' => $page->post_title,
    'content' => apply_filters( 'the_content', $page->post_content ),
  );

  return new WP_REST_Response( $page_data, 200 );
}


/*
*API for All Page view
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/all-pages', array(
    'methods' => 'GET',
    'callback' => 'get_all_postType',
  ) );
} );

function get_all_postType($request) {
  $pages = get_pages();

  if ( empty( $pages ) ) {
    return new WP_Error( '404', 'No pages found', array( 'status' => 404 ) );
  }

  $page_data = array();
  foreach ( $pages as $page ) {
    $page_data[] = array(
      'id' => $page->ID,
      'title' => $page->post_title,
      'content' => apply_filters( 'the_content', $page->post_content ),
    );
  }

  return new WP_REST_Response( $page_data, 200 );
}



/*
*API for Servies list View
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/services', array(
    'methods' => 'GET',
    'callback' => 'get_servies_postType',
  ) );
} );
function get_servies_postType($request) {
  $custom_post_type = get_posts( array(
    'post_type' => 'services',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC'
  ) );
  if ( empty( $custom_post_type ) ) {
    return new WP_Error( '404', 'No custom post type found', array( 'status' => 404 ) );
  }

  $custom_post_type_data = array();
  foreach ( $custom_post_type as $post ) {
    $custom_post_type_data[] = array(
      'id' => $post->ID,
      'post_meta' => get_post_meta($post->ID),
      'title' => $post->post_title,
      'content' => apply_filters( 'the_content', $post->post_content ),
    );
  }

  return new WP_REST_Response( $custom_post_type_data, 200 );

}

/*
*API for counter list View
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/counter', array(
    'methods' => 'GET',
    'callback' => 'get_counter_postType',
  ) );
} );
function get_counter_postType($request) {
  $custom_post_type = get_posts( array(
    'post_type' => 'counter',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC'
  ) );
  if ( empty( $custom_post_type ) ) {
    return new WP_Error( '404', 'No custom post type found', array( 'status' => 404 ) );
  }

  $custom_post_type_data = array();
  foreach ( $custom_post_type as $post ) {
    $custom_post_type_data[] = array(
      'id' => $post->ID,
      'post_meta' => get_post_meta($post->ID),
      'title' => $post->post_title,
      'content' => apply_filters( 'the_content', $post->post_content ),
    );
  }

  return new WP_REST_Response( $custom_post_type_data, 200 );

}
  

/*
*API for Testimonials list View
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/testimonials', array(
    'methods' => 'GET',
    'callback' => 'get_testimonials_postType',
  ) );
} );
function get_testimonials_postType($request) {
  $custom_post_type = get_posts( array(
    'post_type' => 'testimonials',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC'
  ) );
  if ( empty( $custom_post_type ) ) {
    return new WP_Error( '404', 'No custom post type found', array( 'status' => 404 ) );
  }

  $custom_post_type_data = array();
  foreach ( $custom_post_type as $post ) {
    $custom_post_type_data[] = array(
      'id' => $post->ID,
      'post_meta' => get_post_meta($post->ID),
      'title' => $post->post_title,
      'content' => apply_filters( 'the_content', $post->post_content ),
    );
  }

  return new WP_REST_Response( $custom_post_type_data, 200 );

}
  
  

/*
*API for Processcontent list View
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/processcontent', array(
    'methods' => 'GET',
    'callback' => 'get_processcontent_postType',
  ) );
} );
function get_processcontent_postType($request) {
  $custom_post_type = get_posts( array(
    'post_type' => 'processcontent',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC'
  ) );
  if ( empty( $custom_post_type ) ) {
    return new WP_Error( '404', 'No custom post type found', array( 'status' => 404 ) );
  }

  $custom_post_type_data = array();
  foreach ( $custom_post_type as $post ) {
    $custom_post_type_data[] = array(
      'id' => $post->ID,
      'post_meta' => get_post_meta($post->ID),
      'title' => $post->post_title,
      'content' => apply_filters( 'the_content', $post->post_content ),
    );
  }

  return new WP_REST_Response( $custom_post_type_data, 200 );

}
  

/*
*API for Solutions list View
*/
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/solutions', array(
    'methods' => 'GET',
    'callback' => 'get_solutions_postType',
  ) );
} );

function get_solutions_postType($request) {
  $custom_post_type = get_posts( array(
    'post_type' => 'solutions',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC'
  ) );
  if ( empty( $custom_post_type ) ) {
    return new WP_Error( '404', 'No custom post type found', array( 'status' => 404 ) );
  }

  $custom_post_type_data = array();
  foreach ( $custom_post_type as $post ) {
    $custom_post_type_data[] = array(
      'id' => $post->ID,
      'post_meta' => get_post_meta($post->ID),
      'title' => $post->post_title,
      'content' => apply_filters( 'the_content', $post->post_content ),
    );
  }

  return new WP_REST_Response( $custom_post_type_data, 200 );
}
  

/*
*API for Products list View
*/
  
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/products', array(
    'methods' => 'GET',
    'callback' => 'get_products_postType',
  ) );
} );
function get_products_postType($request) {
  
  $custom_post_type = get_posts( array(
    'post_type' => 'products',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC'
  ) );
  if ( empty( $custom_post_type ) ) {
    return new WP_Error( '404', 'No custom post type found', array( 'status' => 404 ) );
  }

  $custom_post_type_data = array();
  foreach ( $custom_post_type as $post ) {
    $custom_post_type_data[] = array(
      'id' => $post->ID,
      'post_meta' => get_post_meta($post->ID),
      'title' => $post->post_title,
      'content' => apply_filters( 'the_content', $post->post_content ),
    );
  }

  return new WP_REST_Response( $custom_post_type_data, 200 );
}


/*
*API for Banner View
*/
  
add_action('rest_api_init', function() {
  register_rest_route('view/v1', '/banner', array(
    'methods' => 'GET',
    'callback' => 'get_banners',
  ));
});

function get_banners($request) {
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'title' => 'banner',
  );
  
  $banner_posts = get_posts($args);
  

  if (empty($banner_posts)) {
    return new WP_Error('no_banners', 'No banners found', array('status' => 404));
  }

  $data = array();

  
  if ($banner_posts) {
    foreach ($banner_posts as $banner_post) {
      
      $data[] =array(
        'id' => $banner_post->ID,
        'post_meta' => get_post_meta($banner_post->ID),
        'title' => $banner_post->post_title,
        'content' => apply_filters( 'the_content', $banner_post->post_content ),
      );
    }
  }

  return new WP_REST_Response( $data, 200 );
}

function get_footer_widget_data() {
  $widgets = wp_get_sidebars_widgets();
    $footer_widgets = $widgets['footer-widget-area']; // Replace 'footer-widget-area' with the actual name of your footer widget area

    $widget_data = array();
    foreach ($footer_widgets as $widget_id) {
        $widget_data[] = get_option('widget_' . $widget_id);
    }

    return $widget_data;
}

// add_action('init', 'init_test');
function init_test(){
  $footer_widget = get_footer_widget_data();
  print_r($footer_widget);
}

 



