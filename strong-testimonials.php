<?php
/**
 * Plugin Name: Strong Testimonials
 * Plugin URI: http://www.wpmission.com/plugins/strong-testimonials/
 * Description: A powerful testimonial manager.
 * Author: Chris Dillon
 * Version: 1.11.2
 * Forked From: GC Testimonials version 1.3.2 by Erin Garscadden
 * Author URI: http://www.wpmission.com/contact
 * Text Domain: strong-testimonials
 * Domain Path: /languages
 * Requires: 3.5 or higher
 * License: GPLv3 or later
 *
 * Copyright 2014  Chris Dillon  chris@wpmission.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


/**
 * Setup
 */
define( 'WPMTST_DIR', plugin_dir_url( __FILE__ ) );
define( 'WPMTST_INC', plugin_dir_path( __FILE__ ) . 'includes/' );
define( 'WPMTST_TPL', plugin_dir_path( __FILE__ ) . 'templates/' );


/**
 * Plugin action links
 */
function wpmtst_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$settings_link = '<a href="' . admin_url( 'edit.php?post_type=wpm-testimonial&page=settings' ) . '">' 
				. __( 'Settings', 'strong-testimonials' ) . '</a>';
		array_unshift( $links, $settings_link );
	}
	return $links;
}
add_filter( 'plugin_action_links', 'wpmtst_plugin_action_links', 10, 2 );


/**
 * Text domain
 */
function wpmtst_textdomain() {
	$success = load_plugin_textdomain( 'strong-testimonials', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'wpmtst_textdomain' );


/**
 * Plugin activation
 */
register_activation_hook( __FILE__, 'wpmtst_register_cpt' );
register_activation_hook( __FILE__, 'wpmtst_flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'wpmtst_flush_rewrite_rules' );

function wpmtst_flush_rewrite_rules() {
	flush_rewrite_rules();
}


/**
 * Plugin activation and upgrade.
 */
function wpmtst_default_settings() {
	// placeholders
	$cycle = array();
	
	// -1- DEFAULTS
	$plugin_data = get_plugin_data( __FILE__, false );
	$plugin_version = $plugin_data['Version'];
	include( WPMTST_INC . 'defaults.php' );

	// -2- GET OPTIONS
	$options = get_option( 'wpmtst_options' );
	if ( ! $options ) {
		// -2A- NEW ACTIVATION
		update_option( 'wpmtst_options', $default_options );
	}
	else {
		// -2B- UPDATE
		if ( ! isset( $options['plugin_version'] )
					|| $options['plugin_version'] != $plugin_version 
					|| 'strong.dev' == $_SERVER['SERVER_NAME'] ) {

			// Fixing captcha inconsistency.
			if ( 'none' == $options['captcha'] )
				$options['captcha'] = '';
				
			// Change target parameter in client section
			$options['default_template'] = str_replace( 'target="_blank"', 'new_tab', $options['default_template'] );
				
			// merge in new options
			$options = array_merge( $default_options, $options );
			$options['plugin_version'] = $plugin_version;
			update_option( 'wpmtst_options', $options );
		}
	}
	
	// -3- GET FIELDS
	$fields = get_option( 'wpmtst_fields' );
	if ( ! $fields ) {
		// -3A- NEW ACTIVATION
		update_option( 'wpmtst_fields', $default_fields );
	}
	
	// -4- GET CYCLE
	$cycle = get_option( 'wpmtst_cycle' );
	if ( ! $cycle ) {
		// -4A- NEW ACTIVATION
		update_option( 'wpmtst_cycle', $default_cycle );
	}
	else {
		// -4B- UPDATE
		
		// if updating from 1.5 - 1.6
		if ( isset( $options['cycle-order'] ) ) {
			$cycle = array(
					'order'   => $options['cycle-order'],
					'effect'  => $options['cycle-effect'],
					'speed'   => $options['cycle-speed'],
					'timeout' => $options['cycle-timeout'],
					'pause'   => $options['cycle-pause'],
			);
			unset( 
				$options['cycle-order'],
				$options['cycle-effect'],
				$options['cycle-speed'],
				$options['cycle-timeout'],
				$options['cycle-pause']
			);
			update_option( 'wpmtst_options', $options );
		}
		
		// if updating to 1.11
		// change hyphenated to underscored
		if ( isset( $cycle['char-limit'] ) ) {
			$cycle['char_limit'] = $cycle['char-limit'];
			unset( $cycle['char-limit'] );
		}
		if ( isset( $cycle['more-page'] ) ) {
			$cycle['more_page'] = $cycle['more-page'];
			unset( $cycle['more-page'] );
		}
		
		// if updating from 1.7
		// moving cycle options to separate option
		if ( isset( $options['cycle']['cycle-order'] ) ) {
			$old_cycle = $options['cycle'];
			$cycle = array(
					'order'   => $old_cycle['cycle-order'],
					'effect'  => $old_cycle['cycle-effect'],
					'speed'   => $old_cycle['cycle-speed'],
					'timeout' => $old_cycle['cycle-timeout'],
					'pause'   => $old_cycle['cycle-pause'],
			);
			unset( $options['cycle'] );
			update_option( 'wpmtst_options', $options );
		}
		
		$cycle = array_merge( $default_cycle, $cycle );
		update_option( 'wpmtst_cycle', $cycle );
	}
}


/**
 * Check WordPress version
 */
function wpmtst_version_check() {
	global $wp_version;
	$plugin_info = get_plugin_data( __FILE__, false );
	$require_wp = "3.5";  // minimum Wordpress version
	$plugin = plugin_basename( __FILE__ );

	if ( version_compare( $wp_version, $require_wp, '<' ) ) {
		if ( is_plugin_active( $plugin ) ) {
			deactivate_plugins( $plugin );
			$message = '<h2>' . sprintf( __( 'Unable to load %s', 'strong-testimonials' ), $plugin_info['Name'] ) . '</h2>';
			$message .= '<p>' . sprintf( __( 'This plugin requires <strong>WordPress %s</strong> or higher so it has been deactivated.', 'strong-testimonials' ), $require_wp ) . '<p>';
			$message .= '<p>' . __( 'Please upgrade WordPress and try again.', 'strong-testimonials' ) . '<p>';
			$message .= '<p>' . sprintf( __( 'Back to the WordPress <a href="%s">Plugins page</a>', 'strong-testimonials' ), get_admin_url( null, 'plugins.php' ) ) . '<p>';
			wp_die( $message );
		}
	}
}


/**
 * Register Post Type and Taxonomy
 */
function wpmtst_register_cpt() {

	$testimonial_labels = array(
			'name'                  => _x( 'Testimonials', 'post type general name', 'strong-testimonials' ),
			'singular_name'         => _x( 'Testimonial', 'post type singular name', 'strong-testimonials' ),
			'add_new'               => __( 'Add New', 'strong-testimonials' ),
			'add_new_item'          => __( 'Add New Testimonial', 'strong-testimonials' ),
			'edit_item'             => __( 'Edit Testimonial', 'strong-testimonials' ),
			'new_item'              => __( 'New Testimonial', 'strong-testimonials' ),
			'all_items' 			      => __( 'All Testimonials', 'strong-testimonials' ),
			'view_item'             => __( 'View Testimonial', 'strong-testimonials' ) ,
			'search_items'          => __( 'Search Testimonials', 'strong-testimonials' ),
			'not_found'             => __( 'Nothing Found', 'strong-testimonials' ),
			'not_found_in_trash'    => __( 'Nothing found in Trash', 'strong-testimonials' ),
			'parent_item_colon'     => ''
	);

	$testimonial_args = array(
			'labels'                => $testimonial_labels,
			'singular_label'        => __( 'testimonial', 'strong-testimonials' ),
			'public'                => true,
			'show_ui'               => true,
			'capability_type'       => 'post',
			'hierarchical'          => false,	// 1.8
			// 'rewrite'               => true,
			'rewrite'               => array( 'slug' => __( 'testimonial', 'strong-testimonials' ) ), // 1.8
			'menu_icon'				      => 'dashicons-editor-quote',
			// 'menu_icon'				      => 'dashicons-testimonial',
			'menu_position'			    => 20,
			'exclude_from_search' 	=> true,
			'supports'              => array( 'title', 'excerpt', 'editor', 'thumbnail', 'custom-fields' )
	);

	register_post_type( 'wpm-testimonial', $testimonial_args );

	// Additional permastructure.
	// This will override other CPTs with same slug.
	// $permastruct_args = $testimonial_args['rewrite'];
	// add_permastruct( 'wpm-testimonial', "review/%wpm-testimonial%", array( 'slug' => __( 'review', 'strong-testimonials' ) ) );

	
	$categories_labels = array(
			'name'                  => __( 'Categories', 'strong-testimonials' ),
			'singular_name'         => _x( 'Category', 'strong-testimonials' ),
			'all_items' 			      => __( 'All Categories', 'strong-testimonials' ),
			'add_new_item'          => _x( 'Add New Category', 'strong-testimonials' ),
			'edit_item'             => __( 'Edit Category', 'strong-testimonials' ),
			'new_item'              => __( 'New Category', 'strong-testimonials' ),
			'view_item'             => __( 'View Category', 'strong-testimonials' ),
			'search_items'          => __( 'Search Category', 'strong-testimonials' ),
			'not_found'             => __( 'Nothing Found', 'strong-testimonials' ),
			'not_found_in_trash'    => __( 'Nothing found in Trash', 'strong-testimonials' ),
			'parent_item_colon'     => ''
	);

	register_taxonomy( 'wpm-testimonial-category', array( 'wpm-testimonial' ), array(
			'hierarchical' => true,
			'labels'       => $categories_labels,
			'rewrite'      => array(
					'slug'         => 'view',
					'hierarchical' => true,
					'with_front'   => false
			)
	) );

}
// add_action( 'init', 'wpmtst_register_cpt' );
add_action( 'init', 'wpmtst_register_cpt', 5 );


/**
 * Theme support for this custom post type only.
 */
function wpmtst_theme_support() {
	add_theme_support( 'post-thumbnails', array( 'wpm-testimonial' ) );
}
add_action( 'after_theme_setup', 'wpmtst_theme_support' );


/**
 * Register scripts and styles.
 */
function wpmtst_scripts() {
	global $post;
	$options = get_option( 'wpmtst_options' );

	/*
	 * Widget style and scripts are enqueued when widget is active
	 * to be compatible with Page Builder plugin.
	 *
	 * @since 1.9.0
	 */
	 
	wp_register_style( 'wpmtst-style', WPMTST_DIR . 'css/wpmtst.css' );
	wp_register_style( 'wpmtst-form-style', WPMTST_DIR . 'css/wpmtst-form.css' );

	wp_register_script( 'wpmtst-pager-plugin', WPMTST_DIR . 'js/quickpager.jquery.js', array( 'jquery' ) );
	wp_register_script( 'wpmtst-validation-plugin', WPMTST_DIR . 'js/jquery.validate.min.js', array( 'jquery' ) );

	// Check for shortcodes. Keep these exploded!
	if ( $post ) {

		if ( has_shortcode( $post->post_content, 'wpmtst-all' ) ) {
			if ( $options['load_page_style'] )
				wp_enqueue_style( 'wpmtst-style' );
			wp_enqueue_script( 'wpmtst-pager-plugin' );
			add_action( 'wp_footer', 'wpmtst_pagination_function' );
		}

		if ( has_shortcode( $post->post_content, 'wpmtst-form' ) ) {
			if ( $options['load_form_style'] )
				wp_enqueue_style( 'wpmtst-form-style' );
				
			wp_enqueue_script( 'wpmtst-validation-plugin' );
			add_action( 'wp_footer', 'wpmtst_validation_function' );
			
			if ( $options['honeypot_before'] ) {
				add_action( 'wp_footer', 'wpmtst_honeypot_before_script' );
				add_action( 'wpmtst_honeypot_before', 'wpmtst_honeypot_before' );
			}
			
			if ( $options['honeypot_after'] ) {
				add_action( 'wp_footer', 'wpmtst_honeypot_after_script' );
				add_action( 'wpmtst_honeypot_after', 'wpmtst_honeypot_after' );
			}
		}

		if ( has_shortcode( $post->post_content, 'wpmtst-cycle' ) ) {
			if ( $options['load_page_style'] )
				wp_enqueue_style( 'wpmtst-style' );
		}

		if ( has_shortcode( $post->post_content, 'wpmtst-single' ) ) {
			if ( $options['load_page_style'] )
				wp_enqueue_style( 'wpmtst-style' );
		}

		if ( has_shortcode( $post->post_content, 'wpmtst-random' ) ) {
			if ( $options['load_page_style'] )
				wp_enqueue_style( 'wpmtst-style' );
		}
	
	}
}
add_action( 'wp_enqueue_scripts', 'wpmtst_scripts' );


/**
 * Includes
 */
include( WPMTST_INC . 'functions.php' );
include( WPMTST_INC . 'child-shortcodes.php' );
include( WPMTST_INC . 'shims.php' );
include( WPMTST_INC . 'widget.php' );
if ( is_admin() ) {
	include( WPMTST_INC . 'admin.php' );
	include( WPMTST_INC . 'admin-custom-fields.php' );
	include( WPMTST_INC . 'settings.php' );
	include( WPMTST_INC . 'guide.php' );
}
else {
	include( WPMTST_INC . 'shortcodes.php' );
	include( WPMTST_INC . 'shortcode-form.php' );
	include( WPMTST_INC . 'shortcode-strong.php' );
	include( WPMTST_INC . 'captcha.php' );
}
