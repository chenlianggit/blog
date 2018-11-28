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
  	@Date:   2017-09-14 09:08:04
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-10 21:03:14

*/
$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );

$post_extend = wp_parse_args( (array) $post_extend, array( 
		'post_layout'    => 'one',
		'head_img'       => '',
		'post_video_url' => '',
	) 
);

$Share = new MiShare();
$Share->config = array( 'url' => get_permalink(), 'title' => get_the_title(), 'pic' => post_thumbnail_src(), 'des' => get_the_excerpt());

?>
<section class="nt-warp nt-warp-video pt0">
    <div class="l-video">
        <div class="container">
        <?php
            if( !empty( $post_extend['post_video_url'] ) ){ 
                echo apply_filters( 'the_content', $post_extend['post_video_url'] ); 
            }
        ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <main class="l-main col-xs-12 col-sm-8 col-md-9">
                <div class="m-post">
                   
                        <?php if ( cs_get_option('breadcrumbs') && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
                        <?php
                          if ( have_posts() ) : 
                          		while ( have_posts() ) : the_post(); 
                        ?>
                            <div class="post-title"><h1><?php the_title(); ?><?php edit_post_link('[编辑]'); ?></h1></div>
        					<article class="post-content suxing-popup-gallery">
        						<?php the_content(); ?>
        					</article>         
                            <div class="post-footer clearfix">
                                <div class="pull-left">
                                    <div class="post-action video-action">
                                        <span class="u-data"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
                                        <span class="u-data"><i class="icon icon-eye"></i> <?php post_views('',''); ?></span>
                                        <span class="u-data"><i class="icon icon-bubble"></i> <?php echo $post->comment_count; ?></span>
                                        <div class="video-like">
                                            <a class="u-data btn-like" href="javascript:;" id="Addlike" data-action="ding" data-id="<?php the_ID();?>"><i class="icon icon-heart"></i> <span class="count"><?php if( get_post_meta($post->ID,'suxing_ding',true) ){echo get_post_meta($post->ID,'suxing_ding',true);}else{echo 0;}?></span></a>
                                        </div>
                                        <div class="social-share social-share-compact">
                                            <a id="social-share" class="social-share-title" data-target="#" href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon icon-share"></i>
                                            </a>
                                            <ul class="social-share-links" aria-labelledby="social-share">
                                                <li>
                                                    <a class="social-share-link" rel="nofollow" target="_blank" href="<?php echo $Share->qq(); ?>"><i class="fa fa-qq"></i></a>
                                                </li>
                                                <li>
                                                    <a data-suxing="suxing-share-weixin" class="social-share-link" href="javascript:void(0);"><i class="fa fa-weixin"></i></a>

                                                </li>
                                                <li>
                                                    <a class="social-share-link" rel="nofollow" target="_blank" href="<?php echo $Share->weibo(); ?>"><i class="fa fa-weibo"></i></a>
                                                </li>
                                            </ul>
                                            <div class="dialog-suxing">
                                                <div class="dialog-content dialog-wechat-content">
                                                    <p>微信扫一扫,分享到朋友圈</p>
                                                    <img <?php echo is_lazysizes(); ?>src="<?php echo $Share->weixin(); ?>" alt="">
                                                    <div class="btn-close">
                                                        <i class="icon icon-close"></i>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        <?php 
                      		  endwhile;
                      	endif;
                        ?>   
                    
                </div>
                <?php
                    if ( comments_open() || get_comments_number() ) : comments_template();endif;
                ?>
            </main>
                
            <aside class="l-sidebar col-xs-12 col-sm-4 col-md-3 hidden-xs mt10">
                <?php get_sidebar($post_extend['post_layout']); ?>                          
            </aside>
        </div>
    </div>
</section>