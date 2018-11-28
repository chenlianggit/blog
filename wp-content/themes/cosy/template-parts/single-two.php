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
  	@Last Modified time: 2017-11-13 14:05:54

*/

$post_extend = get_post_meta( get_the_ID(), 'post_extend', true );

$post_extend = wp_parse_args( (array) $post_extend, array( 
		'post_layout' => 'two',
		'head_img'    => '',
	) 
);

$category = get_the_category( get_the_ID() );
if( !empty($post_extend['head_img']) ) {
	$head_img = $post_extend['head_img'];
}else{
	$head_img = post_thumbnail_src();
}

?>
<section class="nt-warp  nt-warp-nospace">
    <div class="container">

<?php
if ( have_posts() ) : 
	while ( have_posts() ) : the_post(); 
?>  
        <?php if ( cs_get_option('breadcrumbs') && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
        <div class="row">
            <main class="l-main col-xs-12 col-sm-8 col-md-9">
                <div class="suxing post-cover">
                    <div class="image" style="background-image: url(<?php echo timthumb( $head_img, array( 'w' => '636', 'h' => '400' ) ); ?>);"></div>
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
       
            <aside class="l-sidebar col-xs-12 col-sm-4 col-md-3 hidden-xs">
               	<?php get_sidebar($post_extend['post_layout']); ?>
            </aside>
          
        </div>
    </div>
</section>