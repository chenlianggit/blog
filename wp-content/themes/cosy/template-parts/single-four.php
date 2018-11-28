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
  	@Date:   2017-09-05 12:53:53
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 14:31:04

*/
$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
$post_extend = wp_parse_args( (array) $post_extend, array( 
		'head_img'    => '',
	) 
);
$category = get_the_category( get_the_ID() );
if( !empty($post_extend['head_img']) ) {
	$att = wp_get_attachment_image_src( $post_extend['head_img'], 'full' );
	$head_img = $att[0];
}else{
	$post_thumbnail_src = post_thumbnail_src();

	if( is_numeric( $post_thumbnail_src ) ){

		$att = wp_get_attachment_image_src( $post_thumbnail_src, 'full' );
		$head_img = $att[0];
		
	}else{
		$head_img = $post_thumbnail_src;
	}
}

if ( have_posts() ) : 
	while ( have_posts() ) : the_post(); 
?>   
<div class="suxing post-cover">
    <div class="image" style="background-image: url(<?php echo $head_img; ?>);"></div>  
    <div class="content">
        <span class="categories"><a href="<?php echo get_category_link($category[0]->term_id ); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a></span>
		<h1><?php the_title(); ?><?php edit_post_link('[编辑]'); ?></h1>
    </div>
    <div class="post-date">                 
        <div class="author-name"><a href="<?php echo get_author_posts_url( $post->post_author ); ?>"><?php echo get_avatar( $post->post_author, 30, '', '', null ); ?><?php the_author(); ?></a></div>
        <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
        <span class="u-view"><i class="icon icon-eye"></i> <?php post_views('',''); ?></span>
        <span class="u-comment"><i class="icon icon-bubble"></i> <?php echo $post->comment_count; ?></span> 
    </div>
</div>
<section class="nt-warp nt-warp-full">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <main class="l-main">
                    <div class="m-post">
                        <article class="post-content suxing-popup-gallery">
                            <?php the_content(); ?>
                        </article>
                        <div class="post-declare"><p>本文由 @<?php the_author_posts_link(); ?> 原创发布<?php bloginfo( 'name' ); ?>。未经许可，禁止转载。</p></div>
                        <div class="post-tags">
                            <?php the_tags( '#', '#', ''); ?>
                        </div>
                        <?php get_template_part('template-parts/post-footer'); ?>
                        <?php get_template_part('template-parts/post-ad'); ?>

<?php 
	endwhile;
endif;
?>                           
                        <?php get_template_part('template-parts/post-navigation'); ?> 
                        <?php get_template_part('template-parts/post-author-info'); ?>
                    </div>
                    <?php
	                	if ( comments_open() || get_comments_number() ) :
						    comments_template();
						endif;
	                ?>
                </main>
            </div>

        </div>
    </div>
</section>