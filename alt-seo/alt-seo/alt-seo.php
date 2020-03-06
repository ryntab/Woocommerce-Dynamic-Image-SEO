<?php
/*
Plugin Name: Alt SEO
Description: A lightweight solution for dynamically adding alt & title attributes to woocommerce images.
Version: 1.0.0
Plugin URI: 
Author: Ryan Taber
License: GPLv3
License URI: 
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function Alt_seo_check_for_existing_settings() {
    
    if ( !get_option( 'Alt_seo' ) ) {
        $default_settings = '{"alt":{"enable":0,"force":0,"text":{"1":"[none]","2":"[name]","3":"[none]"}},"title":{"enable":0,"force":0,"text":{"1":"[none]","2":"[name]","3":"[none]"}}}';
        update_option( 'Alt_seo', $default_settings );
    }
    
}

function Alt_seo_add_page() {
	add_submenu_page( 'woocommerce', 'Alt SEO', 'Alt SEO', 'manage_options', 'Alt_seo', 'Alt_seo_page_callback' );
}

function Alt_seo_page_callback() {
	include('settings.php');
}

function Alt_seo_add_settings_link( $links ) {
    array_push( $links, '<a href="admin.php?page=Alt_seo">Settings</a>' );
  	return $links;
}

function Alt_seo_change_image_attributes($imageData, $attachment) {

	if ( get_post_type() === 'product' ) {
	    
	    Alt_seo_check_for_existing_settings();
		
		$settings = json_decode( get_option( 'Alt_seo' ), true );
		
		foreach ( $settings as $settings_key => $settings_value ) {

				if ( $settings_value['enable'] && (!isset($imageData[$settings_key]) || strlen($imageData[$settings_key]) === 0 || $settings_value['force']) ) {
					
					$imageData[$settings_key] = ''; 
					
					foreach ( $settings_value['text'] as $text_key => $text_value ) {
						
						if ( $text_value ) {
							switch ($text_value) {
						
						case '[name]':
							$text_value = get_the_title();
							break;
							
						case '[category]':
							$product_categories = get_the_terms( get_the_ID(), 'product_cat' );
							if ( is_array($product_categories) ) {
								if ( $product_categories[0]->name !== 'Uncategorized' ) {
									$text_value = $product_categories[0]->name;
								}
								else if ( isset($product_categories[1]) ) {
									$text_value = $product_categories[1]->name;
								}
							}
							break;
							
						case '[tag]':
							$product_tags = get_the_terms( get_the_ID(), 'product_tag' );
							if ( is_array($product_tags) ) {
								$text_value = $product_tags[0]->name;
							}
							break;

						case '[yoastKeyword]':
							$text_value = get_post_meta(get_the_ID(), '_yoast_wpseo_focuskw', true);
						break;

						case '[yoastTitle]':
							$text_value = get_post_meta( get_the_ID(), '_yoast_wpseo_title', true );
						break;

						case '[yoastDesc]':
							$text_value = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
						break;

						case '[postAuthor]':
							$text_value = get_the_author_meta('display_name', $author_id);
						break;

						case '[siteUrl]':
							$text_value = get_bloginfo('name');
						break;

						case '[-]':
							$text_value = '-';
						break;

						case '[|]':
							$text_value = '|';
						break;

						default: // if value is not one of the above
							$text_value = null;
							break;
							
							}
							
							if ($text_value) { // if value is not null/0
								$imageData[$settings_key] .= $text_value . ' ';
							}
						}
					}
					$imageData[$settings_key] = trim($imageData[$settings_key]);
				}
			
		}
		
		
	}
	

	return $imageData;
	
}

register_activation_hook( __FILE__, 'Alt_seo_check_for_existing_settings' );
add_action('admin_menu', 'Alt_seo_add_page');
add_filter( "plugin_action_links_".plugin_basename( __FILE__ ), 'Alt_seo_add_settings_link' );
add_filter('wp_get_attachment_image_attributes', 'Alt_seo_change_image_attributes', 20, 2);