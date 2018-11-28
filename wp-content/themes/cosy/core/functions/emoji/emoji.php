<?php

/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-12 13:50:57
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-09-12 16:36:01

*/

function mi_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    unset($wpsmiliestrans[':mrgreen:']);
    $wpsmilies = array_unique($wpsmiliestrans);
    $emoji = '';
    foreach ($wpsmilies as $key => $value) {
    	$emoji .= sprintf('<a href="javascript:;" class="insert_emoji" data-emoji="%s">%s</a>', $key, $value);
    }
    return $emoji;
}

function add_emoji_js(){
	wp_register_script( 'emoji', get_template_directory_uri() . '/core/functions/emoji/emoji.js', array('jQuery'), THEME_VERSION, true ); 
	if( is_single() || is_page() ){
		wp_enqueue_script( 'emoji' ); 
	}
}
add_action('wp_enqueue_scripts', 'add_emoji_js');


