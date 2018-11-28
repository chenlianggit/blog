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
  	@Date:   2017-09-05 12:30:46
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-10-12 13:26:07

*/
get_header();


$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
$post_extend = wp_parse_args( (array) $post_extend, array( 
		'post_layout'    => 'one',
	) 
);
if( $post_extend ){
	$template_name = $post_extend['post_layout'];
}else{
	$template_name = 'one';
}

get_template_part( 'template-parts/single', $template_name );

get_footer();