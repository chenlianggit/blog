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
  	@Date:   2017-09-13 13:12:19
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 13:46:21

*/
$category = get_the_category( get_the_ID() );
$post = get_post( get_the_ID() );
?>
<div class="col-grid col-xs-12 col-sm-4 col-md-4">
    <article class="post post-grid">
        <div class="image">
              <a href="<?php the_permalink(); ?>">
                  <?php if( cs_get_option( 'index_single_layout' ) == 'card-4' ){ ?>
                  <img <?php echo is_lazysizes(); ?>src="<?php echo timthumb( post_thumbnail_src(), array( 'w' => '480', 'h' => '384.7' ) ); ?>" alt="<?php the_title(); ?>">
                  <?php }else{ ?>
                  <img <?php echo is_lazysizes(); ?>src="<?php echo timthumb( post_thumbnail_src(), array( 'w' => '480', 'h' => '358' ) ); ?>" alt="<?php the_title(); ?>">
                  <?php } ?>
                	<?php
                    	$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
    					$post_extend = wp_parse_args( (array) $post_extend, array( 
    							'post_layout'         => 'one',
    							'post_layout_gallery' => false,
    						) 
    					);

    					if( $post_extend['post_layout'] == 'six' ){
    						echo '<div class="view-icon"><span><i class="icon icon-control-play"></i></span></div>';
    					}else if( $post_extend['post_layout'] == 'five' && $post_extend['post_layout_gallery'] ){
    						echo '<div class="view-icon"><span><i class="icon icon-picture"></i></span></div>';

    					}
                  ?>
              </a>
        </div>
        <div class="content">
        <?php if( in_array( 'none', $GLOBALS['list_hide_item'] ) ){ ?>
            <div class="meta hidden-xs"><span class="u-categories"><a href="<?php echo get_category_link($category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a></span></div>
            <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="dec hidden-xs"><p><?php print_excerpt(38); ?></p></div>
            <div class="data clearfix">
                <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
                <span class="u-view"><i class="icon icon-eye"></i><?php post_views('',''); ?></span>
                <span class="u-comment"><i class="icon icon-bubble"></i><?php echo $post->comment_count; ?></span>
                <span class="u-like"><i class="icon icon-heart"></i><?php if( get_post_meta($post->ID,'suxing_ding',true) ){ echo get_post_meta($post->ID,'suxing_ding',true); } else {echo '0';}?></span>
            </div>
        <?php }else{ ?>
        	<?php if( !in_array( 'cat', $GLOBALS['list_hide_item'] ) ){ ?>
        		<div class="meta hidden-xs"><span class="u-categories"><a href="<?php echo get_category_link($category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a></span></div>
        	<?php } ?>
        	<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        	<?php if( !in_array( 'des', $GLOBALS['list_hide_item'] ) ){ ?>
        		<div class="dec hidden-xs"><p><?php print_excerpt(38); ?></p></div>
        	<?php } ?>
        	<?php if( !in_array( 'meta', $GLOBALS['list_hide_item'] ) ){ ?>
        		<div class="data clearfix">
	                <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
	                <span class="u-view"><i class="icon icon-eye"></i><?php post_views('',''); ?></span>
	                <span class="u-comment"><i class="icon icon-bubble"></i><?php echo $post->comment_count; ?></span>
	                <span class="u-like"><i class="icon icon-heart"></i><?php if( get_post_meta($post->ID,'suxing_ding',true) ){ echo get_post_meta($post->ID,'suxing_ding',true); } else {echo '0';}?></span>
	            </div>
        	<?php } ?>
        <?php } ?>
        </div>
    </article>
</div>
<?php 
unset($post);