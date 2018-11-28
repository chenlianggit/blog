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
  	@Date:   2017-09-13 13:12:36
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 14:01:05

*/
$category = get_the_category( get_the_ID() );
$post = get_post( get_the_ID() );

?>  
<article class="post post-regular clearfix">
    <div class="image pull-left">
		<a href="<?php the_permalink(); ?>"><img <?php echo is_lazysizes(); ?>src="<?php echo timthumb( post_thumbnail_src(), array( 'w' => '280', 'h' => '220' ) ); ?>" alt="<?php the_title(); ?>">
  		<?php 
          	$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
  			$post_extend = wp_parse_args( (array) $post_extend, array( 
  					'post_layout' => 'one',
  					'head_img'    => '',
  				) 
  			);
  			if( $post_extend['post_layout'] == 'six' ){
  				echo '<div class="view-icon"><span><i class="icon icon-control-play"></i></span></div>';
  			}else if( $post_extend['post_layout'] == 'five' && $post_extend['post_layout_gallery'] ){
  				echo '<div class="view-icon"><span><i class="icon icon-picture"></i></span></div>';
  			}
          ?></a>
    </div>
    <div class="content">
        <div class="meta"><span class="u-categories"><a href="<?php echo get_category_link($category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a></span></div>
        <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="dec hidden-xs"><p><?php print_excerpt(80); ?></p></div>
        <div class="data">
            <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
            <span class="u-view hidden-xs"><i class="icon icon-eye"></i><?php post_views('',''); ?></span>
            <span class="u-comment"><i class="icon icon-bubble"></i><?php echo $post->comment_count; ?></span>
            <span class="u-like"><i class="icon icon-heart"></i><?php if( get_post_meta($post->ID,'suxing_ding',true) ){ echo get_post_meta($post->ID,'suxing_ding',true); } else {echo '0';}?></span>
        </div>
    </div>
</article>
<?php 
unset($post);