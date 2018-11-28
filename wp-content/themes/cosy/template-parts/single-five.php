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
  	@Last Modified time: 2017-11-10 21:03:12

*/

$category = get_the_category( get_the_ID() );
if ( have_posts() ) : 
	while ( have_posts() ) : the_post(); 
?>

<section class="nt-warp nt-warp-full">
    <div class="container">
        <?php if ( cs_get_option('breadcrumbs') && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
        <main class="l-main">
            <div class="m-post">
                <div class="post-title style05">
                    <span class="categories"><?php echo $category[0]->cat_name; ?></span>   
                    <h1><?php the_title(); ?></h1>
                    <div class="post-date">                 
                        <div class="author-name"><a href="<?php echo get_author_posts_url( $post->post_author ); ?>"><?php echo get_avatar( $post->post_author, 30, '', '', null ); ?><?php the_author(); ?></a></div>
                        <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></span>
                        <span class="u-view"><i class="icon icon-eye"></i> <?php post_views('',''); ?></span>
                        <span class="u-comment"><i class="icon icon-bubble"></i> <?php echo $post->comment_count; ?></span>
                        <?php edit_post_link('[编辑]', '<span>', '</span>'); ?>
                    </div>
                </div>         		
				<?php 
					$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );
					$post_extend = wp_parse_args( (array) $post_extend, array( 
							'post_layout_gallery' => false,
							'post_gallery'        => null,
						) 
					);

					if( $post_extend['post_layout_gallery'] && !empty( $post_extend['post_gallery'] ) ){
						$ids = explode( ',', $post_extend['post_gallery'] );
				?>
						<div class="post-slide suxing-post-popup-gallery owl-carousel">
					<?php
						foreach ( $ids as $id ) {
							$attachment = wp_prepare_attachment_for_js( $id );
							$meta = wp_get_attachment_metadata( $id );
							if( is_array( $attachment ) ){
					?>
								<div class="item">
			                        <a class="suxing-post-popup-gallery-item" href="<?php echo $attachment['url']; ?>">
                                        <span class="post-expand-icon">
                                            <i class="fa fa-expand"></i>
                                        </span>
                                        <div  class="image" style="background-image:url(<?php echo $attachment['url']; ?>)"></div>
			                            <img <?php echo is_lazysizes(); ?>src="<?php echo $attachment['url']; ?>" alt="<?php echo $attachment['caption']; ?>">
			                            <div class="overlay"></div>
			                        </a>
			                        <?php //p($meta['image_meta']); ?>
			                    </div>		
					<?php			
							}
						
						}
					?>
				</div>
				<?php
					}		
				?>

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
</section>