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
  	@Date:   2017-09-03 16:45:11
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-10-06 20:19:38

*/
?>

<div class="row">
    <main class="l-main col-xs-12 col-sm-12 col-md-12">
        <div class="m-post-list home-list">
            <?php
            	$masking_cats = cs_get_option('masking_cats');

            	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array(
				    'paged' => $paged,
				    'ignore_sticky_posts' => 1
				);

				if( is_array( $masking_cats ) ){
					$args['category__not_in'] = $masking_cats;
				}

				query_posts( $args );
            	if ( have_posts() ) : 
                    $GLOBALS['mii'] = 1;
            		while ( have_posts() ) : the_post(); 
                    
            			get_template_part('template-parts/full-ad-topic');
            			get_template_part('template-parts/ajax-loop-full');
                        $GLOBALS['mii']++;
            		endwhile;
            	endif;
            ?>


        </div>
        <?php 
	    	if( cs_get_option('home_ajax_load') != 1 ) {
	    		the_posts_pagination( array(
					'prev_text'=>'<i class="fa fa fa-angle-left"></i>',
					'next_text'=>'<i class="fa fa fa-angle-right"></i>',
					'screen_reader_text' =>'',
					'mid_size' => 1,
				) );
	    	}else{
	    ?>
        <div class="m-ajax-load">
	        <div class="post-loading"><span></span><span></span><span></span><span></span><span></span></div>
	        <?php if( $GLOBALS["wp_query"]->max_num_pages > 1 ){ ?>
	        <button data-page="home" data-action="ajax_load_posts" data-paged="2" data-append="home-list" class="btn btn-default dm-ajax-load">加载更多</button>
	        <?php }else{ ?>
	        <button data-page="home" data-action="ajax_load_posts" data-paged="2" data-append="home-list" class="btn btn-default dm-ajax-load loading">没有了</button>
	        <?php } ?>
	    </div>
	    <?php } ?>
    </main>
</div>