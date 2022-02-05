<?php
/**
 * @package Caxtelyn
 * @version 1.6
 */
/*
Plugin Name: Tools of my site
Plugin URI: https://www.caxtelyn.cn
Description: 自建插件
Author: Caxtelyn
Version: 0.1
Author URI: http://www.caxtelyn.cn
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;                                                     }
include './remove-google-font.php';                       

// xmlrpc
add_filter('xmlrpc_enabled', '__return_false');               add_filter('xmlrpc_methods', '__return_empty_array');                                                                       // pingback
add_filter('xmlrpc_methods',function($methods){
$methods['pingback.ping'] = '__return_false';
$methods['pingback.extensions.getPingbacks'] = '__return_false';
return $methods;                                    
	});		
remove_action( 'do_pings', 'do_all_pings', 10 );                                      
remove_action( 'publish_post','_publish_post_hook',5 );
			                                      //title:私密: 加密
function remove_title_prefix($content){     
	return '%s';
}
add_filter('protected_title_format','remove_title_prefix');
add_filter('private_title_format', 'remove_title_prefix');


remove_action('wp_head', 'rest_output_link_wp_head', 10 );
remove_action('template_redirect', 'rest_output_link_header', 11 );

//emojis
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
//去除加载的css和js后面的版本号
function sb_remove_script_version( $src ){
$parts = explode( '?', $src );
return $parts[0];
}
add_filter( 'script_loader_src', 'sb_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'sb_remove_script_version', 15, 1 );

//禁用load script在后台一次性加载过多js
define('CONCATENATE_SCRIPTS', false);

//移除主题更新
remove_action( 'load-themes.php', 'wp_update_themes' );
remove_action( 'load-update.php', 'wp_update_themes' );
remove_action( 'load-update-core.php', 'wp_update_themes' );
remove_action( 'admin_init', '_maybe_update_themes' );

//禁止古登堡加载google fonts
add_action('admin_print_styles', function(){
       	wp_deregister_style('wp-editor-font');
	wp_register_style('wp-editor-font', '');
});

//移除后台帮助
add_action('in_admin_header', function(){
	global $current_screen;
	$current_screen->remove_help_tabs();
});
/*
function loginlogo($url) {
	return ‘’;
}
add_filter( ‘login_header’, ‘loginlogo’ );
*/
add_filter('admin_footer_text', 'left_admin_footer_text'); 
function left_admin_footer_text($text) {
	// 左边信息
	$text = ''; 
	return $text;
}
add_filter('update_footer', 'right_admin_footer_text', 11); 
function right_admin_footer_text($text) {
	// 右边信息
	$text = '';
	return $text;
}
 
