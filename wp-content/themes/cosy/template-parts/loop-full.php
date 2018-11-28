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
  	@Date:   2017-09-05 20:10:44
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 14:03:41

*/
if( is_category() && !$paged  ){
  $category = get_the_category( get_the_ID() );
  $queried_object = get_queried_object(); 
  $term_id = $queried_object->term_id;
  $term_data = get_term_meta( $term_id, '_custom_category_options', true );
  $term_data = wp_parse_args( (array) $term_data, array( 
            'cat_layout'                  => 'card',
            'cat_name_show'               => true,
            'cat_excerpt_show'            => true,
            'cat_meta_show'               => true,
            'cat_insert_ad_full'          => 'default',
            'cat_insert_ad_full_text'     => true,
            'cat_insert_ad_full_position' => 3,
            'cat_insert_ad_full_url'      => 'http://www.suxing.me/',
            'cat_insert_ad_full_img'      => '',
            'cat_insert_ad_full_img_mobile' => '',
            'cat_insert_ad_full_html_pc' => '',
            'cat_insert_ad_full_html_mobile'    => '',
    ) 
  );

  $thumpic = wp_get_attachment_image_src($term_data['cat_insert_ad_full_img'],'full');
  $thumpic_moblie = wp_get_attachment_image_src($term_data['cat_insert_ad_full_img_mobile'],'full');
  $ad_type = $term_data['cat_insert_ad_full'];
  if( !$paged ) :
  if( $ad_type == 'image'  && $term_data['cat_insert_ad_full_position'] == $GLOBALS['mii'] ){ ?>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <article class="post post-regular suxing-adv postlist-adv">
          <div class="visible-xs">
              <a rel="nofollow"  href="<?php echo $term_data['cat_insert_ad_full_url']; ?>">
                  <img <?php echo is_lazysizes(); ?>src="<?php echo $thumpic_moblie[0]; ?>">
              </a>
              <?php
                  if( $term_data['cat_insert_ad_full_text'] ){
                      echo '<span>广告</span>';
                  }
              ?>
          </div>
          <div class="visible-sm visible-md visible-lg">
              <a rel="nofollow"  href="<?php echo $term_data['cat_insert_ad_full_url']; ?>">
                  <img <?php echo is_lazysizes(); ?>src="<?php echo $thumpic[0]; ?>">
              </a>
              <?php
                  if( $term_data['cat_insert_ad_full_text'] ){
                      echo '<span>广告</span>';
                  }
              ?>
          </div>
      </article>
    </div>

  <?php }
  if( $ad_type == 'code'  && $term_data['cat_insert_ad_full_position'] == $GLOBALS['mii']  ){ ?>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <article class="suxing-adv postlist-adv">
          <div class="visible-xs">
              <?php echo $term_data['cat_insert_ad_full_html_mobile']; ?>
          </div>
          <div class="visible-sm visible-md visible-lg">
              <?php echo $term_data['cat_insert_ad_full_html_pc']; ?>
          </div>
      </article>
    </div>
  <?php }
endif;
}
?>
<div class="col-xs-12 col-sm-12 col-md-12">
  <article class="post post-regular clearfix">
      <div class="image pull-left">
  		<a href="<?php the_permalink(); ?>">
  			<img src="<?php echo timthumb( post_thumbnail_src(), array( 'w' => '280', 'h' => '220' ) ); ?>" alt="<?php the_title(); ?>">
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
          <?php if( ! is_category() ){ ?>
          <div class="meta"><span class="u-categories"><a href="<?php echo get_category_link($category[0]->term_id ); ?>"><?php echo $category[0]->cat_name; ?></a></span></div>
          <?php } ?>
          <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <div class="dec hidden-xs"><p><?php print_excerpt(70); ?></p></div>
          <div class="data">
              <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
              <span class="u-view hidden-xs"><i class="icon icon-eye"></i><?php post_views('',''); ?></span>
              <span class="u-comment"><i class="icon icon-bubble"></i><?php echo $post->comment_count; ?></span>
              <span class="u-like"><i class="icon icon-heart"></i><?php if( get_post_meta($post->ID,'suxing_ding',true) ){ echo get_post_meta($post->ID,'suxing_ding',true); } else {echo '0';}?></span>
          </div>
      </div>
  </article>
</div> 