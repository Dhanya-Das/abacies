<?php
/**
 * Plugin Name: Custom Post Types
 * Plugin URI: https://abacies.com
 * Description: Plugins for Custom Post Types.
 * Version: 1.0
 * Author: Abacies
 * Author URI: https://abacies.com
 * License: Abacies
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; 
}
define( 'CUSTOM_POST_TYPES', plugins_url().'/custom-post-types.php'  );
define( 'CUSTOM_POST_TYPES_DIR', plugin_dir_path( __FILE__ ) );

/*
* Custom Post type for Services
*/
function Service_custom_post_type() {
  // Set UI labels for Custom Post Type
      $labels = array(
          'name'                => _x( 'Services', 'Post Type General Name', 'storefront' ),
          'singular_name'       => _x( 'Service', 'Post Type Singular Name', 'storefront' ),
          'menu_name'           => __( 'Services', 'storefront' ),
          'parent_item_colon'   => __( 'Parent Service', 'storefront' ),
          'all_items'           => __( 'All Services', 'storefront' ),
          'view_item'           => __( 'View Service', 'storefront' ),
          'add_new_item'        => __( 'Add New Service', 'storefront' ),
          'add_new'             => __( 'Add New', 'storefront' ),
          'edit_item'           => __( 'Edit Service', 'storefront' ),
          'update_item'         => __( 'Update Service', 'storefront' ),
          'search_items'        => __( 'Search Service', 'storefront' ),
          'not_found'           => __( 'Not Found', 'storefront' ),
          'not_found_in_trash'  => __( 'Not found in Trash', 'storefront' ),
      );
  // Set other options for Custom Post Type
      $args = array(
          'label'               => __( 'services', 'storefront' ),
          'description'         => __( 'Service news and reviews', 'storefront' ),
          'labels'              => $labels,  
          'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),     
          'taxonomies'          => array( 'genres' ),     
          'hierarchical'        => false,
          'public'              => true,
          'show_ui'             => true,
          'show_in_menu'        => true,
          'show_in_nav_menus'   => true,
          'show_in_admin_bar'   => true,
          'menu_position'       => 5,
          'can_export'          => true,
          'has_archive'         => true,
          'exclude_from_search' => false,
          'publicly_queryable'  => true,
          'capability_type'     => 'post',
          'show_in_rest' => true, 
      );
      // Registering your Custom Post Type
      register_post_type( 'services', $args );
  }
  add_action( 'init', 'Service_custom_post_type', 0 );
  
/*
* Custom Post type for Solutions
*/
function Solutions_custom_post_type() {
  // Set UI labels for Custom Post Type
      $labels = array(
          'name'                => _x( 'Solutions', 'Post Type General Name', 'storefront' ),
          'singular_name'       => _x( 'Solution', 'Post Type Singular Name', 'storefront' ),
          'menu_name'           => __( 'Solutions', 'storefront' ),
          'parent_item_colon'   => __( 'Parent Solution', 'storefront' ),
          'all_items'           => __( 'All Solutions', 'storefront' ),
          'view_item'           => __( 'View Solution', 'storefront' ),
          'add_new_item'        => __( 'Add New Solution', 'storefront' ),
          'add_new'             => __( 'Add New', 'storefront' ),
          'edit_item'           => __( 'Edit Solution', 'storefront' ),
          'update_item'         => __( 'Update Solution', 'storefront' ),
          'search_items'        => __( 'Search Solution', 'storefront' ),
          'not_found'           => __( 'Not Found', 'storefront' ),
          'not_found_in_trash'  => __( 'Not found in Trash', 'storefront' ),
      );
  // Set other options for Custom Post Type
      $args = array(
          'label'               => __( 'solutions', 'storefront' ),
          'description'         => __( 'Solution news and reviews', 'storefront' ),
          'labels'              => $labels,  
          'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),     
          'taxonomies'          => array( 'genres' ),     
          'hierarchical'        => false,
          'public'              => true,
          'show_ui'             => true,
          'show_in_menu'        => true,
          'show_in_nav_menus'   => true,
          'show_in_admin_bar'   => true,
          'menu_position'       => 6,
          'can_export'          => true,
          'has_archive'         => true,
          'exclude_from_search' => false,
          'publicly_queryable'  => true,
          'capability_type'     => 'post',
          'show_in_rest' => true, 
      );
      // Registering your Custom Post Type
      register_post_type( 'solutions', $args );
  }
  add_action( 'init', 'Solutions_custom_post_type', 0 );

/*
* Custom Post type for Products
*/
function Products_custom_post_type() {
  // Set UI labels for Custom Post Type
      $labels = array(
          'name'                => _x( 'Products', 'Post Type General Name', 'storefront' ),
          'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'storefront' ),
          'menu_name'           => __( 'Products', 'storefront' ),
          'parent_item_colon'   => __( 'Parent Product', 'storefront' ),
          'all_items'           => __( 'All Products', 'storefront' ),
          'view_item'           => __( 'View Product', 'storefront' ),
          'add_new_item'        => __( 'Add New Product', 'storefront' ),
          'add_new'             => __( 'Add New', 'storefront' ),
          'edit_item'           => __( 'Edit Product', 'storefront' ),
          'update_item'         => __( 'Update Product', 'storefront' ),
          'search_items'        => __( 'Search Product', 'storefront' ),
          'not_found'           => __( 'Not Found', 'storefront' ),
          'not_found_in_trash'  => __( 'Not found in Trash', 'storefront' ),
      );
  // Set other options for Custom Post Type
      $args = array(
          'label'               => __( 'products', 'storefront' ),
          'description'         => __( 'Product news and reviews', 'storefront' ),
          'labels'              => $labels,  
          'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),     
          'taxonomies'          => array( 'genres' ),     
          'hierarchical'        => false,
          'public'              => true,
          'show_ui'             => true,
          'show_in_menu'        => true,
          'show_in_nav_menus'   => true,
          'show_in_admin_bar'   => true,
          'menu_position'       => 7,
          'can_export'          => true,
          'has_archive'         => true,
          'exclude_from_search' => false,
          'publicly_queryable'  => true,
          'capability_type'     => 'post',
          'show_in_rest' => true, 
      );
      // Registering your Custom Post Type
      register_post_type( 'products', $args );
  }
  add_action( 'init', 'Products_custom_post_type', 0 );