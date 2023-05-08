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
function get_all_postType() {
  $pt_ary = array (
    'post_type' => 'page',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC');
    $post_ary = get_posts($pt_ary);
    return $post_ary;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/all-pages', array(
    'methods' => 'GET',
    'callback' => 'get_all_postType',
  ) );
} );
/*
*API for Page Single view
*/
function get_single_page_postType($request) {
  // $id = 14;
  $id =$request['id'];
  $page = get_post($id);
  $page_details = $page->post_content;
  return $page_details;
}
  
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/view-page/(?P<id>\d+)', array(
  'methods' => 'GET',
    'callback' => 'get_single_page_postType',
  ) );
} );


/*
*API for Servies list View
*/
function get_servies_postType() {
  $ser_ary = array (
    'post_type' => 'services',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC');
    $servies_ary = get_posts($ser_ary);
  return $servies_ary;
}
  
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/services', array(
    'methods' => 'GET',
    'callback' => 'get_servies_postType',
  ) );
} );

/*
*API for Solutions list View
*/
function get_solutions_postType() {
  $sol_ary = array (
    'post_type' => 'solutions',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC');
    $solutions_ary = get_posts($sol_ary);
  return $solutions_ary;
}
  
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/solutions', array(
    'methods' => 'GET',
    'callback' => 'get_solutions_postType',
  ) );
} );

/*
*API for Products list View
*/
function get_products_postType() {
  $pdt_ary = array (
    'post_type' => 'products',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC');
    $products_ary = get_posts($pdt_ary);
  return $products_ary;
}
  
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/products', array(
    'methods' => 'GET',
    'callback' => 'get_products_postType',
  ) );
} );

add_action('init', 'init_test');
function init_test(){
  echo "hello";

}

