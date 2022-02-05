<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit;                                                     }
// xmlrpc
add_filter('xmlrpc_enabled', '__return_false');
add_filter('xmlrpc_methods', '__return_empty_array');

// pingback
add_filter('xmlrpc_methods',function($methods){
	$methods['pingback.ping'] = '__return_false';
	$methods['pingback.extensions.getPingbacks'] = '__return_false';
	return $methods;
});

remove_action( 'do_pings', 'do_all_pings', 10 );

remove_action( 'publish_post','_publish_post_hook',5 );

//title:私密: 加密
function remove_title_prefix($content){                                       return'%s';
	}
add_filter('protected_title_format','remove_title_prefix');
