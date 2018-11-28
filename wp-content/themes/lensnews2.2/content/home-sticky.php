<?php global $salong;
if($salong['sticky_post']){
    $sticky_post = $salong['sticky_post'];
}else{
    $sticky_post = get_option('sticky_posts');
}
?>
<!--置顶文章-->
<section class="sticky box<?php triangle(); ?>">
    <ul>
        <?php $args=array( 'post_type'=> 'post','post__in'=> $sticky_post,'ignore_sticky_posts' => 1,'posts_per_page' => 4);$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
        <!--文章列表-->
        <li>
            <?php get_template_part( 'content/post', 'list'); ?>
        </li>
        <?php endwhile;endif; ?>
        <?php wp_reset_query(); ?>
    </ul>
    <?php if ($salong[ 'sticky_link']) { ?>
    <a class="more" href="<?php $sticky_link = $salong['sticky_link']; ?><?php echo get_page_link($sticky_link); ?>" title="<?php _e( '查看更多置顶推荐的文章', 'salong' ); ?>"><span><?php _e( '更多置顶推荐的文章', 'salong' ); ?></span><i class="icon-right"></i></a>
    <?php } ?>
</section>