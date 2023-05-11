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
    $menu_array[] = array(
      'id' => $menu_item->ID,
      'title' => $menu_item->title,
      'url' => $menu_item->url,
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
        'children' => get_menu_item_children( $menu_items, $menu_item->ID ),
      );
    }
  }
  return $children;
}

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

  $page_data = array(
    'id' => $page->ID,
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
      'title' => $post->post_title,
      'content' => apply_filters( 'the_content', $post->post_content ),
    );
  }

  return new WP_REST_Response( $custom_post_type_data, 200 );
}


// add_action('init', 'init_test');
function init_test(){

}