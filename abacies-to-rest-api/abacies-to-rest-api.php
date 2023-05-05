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
*API for Home View
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
  register_rest_route( 'view/v1', '/all-post', array(
    'methods' => 'GET',
    'callback' => 'get_all_postType',
  ) );
} );

/*
*API for Servies View
*/
function get_servies_postType() {
  $ser_ary = array (
    'post_type' => 'servies',
    'posts_per_page' => -1,
    'post_status' =>'publish',
    'order'=> 'ASC');
    $servies_ary = get_posts($ser_ary);
  return $servies_ary;
}
  
add_action( 'rest_api_init', function () {
  register_rest_route( 'view/v1', '/servies', array(
    'methods' => 'GET',
    'callback' => 'get_servies_postType',
  ) );
} );

/*
*API for Solutions View
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
*API for Products View
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
  register_rest_route( 'view/v1', '/solutions', array(
    'methods' => 'GET',
    'callback' => 'get_products_postType',
  ) );
} );

