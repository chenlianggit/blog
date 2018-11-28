<!-- 相关文章 -->
<?php global $salong; foreach(get_the_category() as $category) { $cat = $category->cat_ID; }  ?>

<section class="related_posts box<?php triangle();wow(); ?>">
    <!--标题-->
    <section class="home_title">
        <h3><?php echo $salong['related_title']; ?></h3>
    </section>
    <!--标题end-->
    <ul class="layout_ul">
        <?php $args=array( 'post_type'=> 'post','posts_per_page' => $salong[ 'related_count'],'orderby'=>'rand','ignore_sticky_posts' => 1,'cat'=> $cat );$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $i=1; while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
        <li class="layout_li">
            <?php get_template_part( 'content/post', 'grid'); ?>
        </li>
        <?php endwhile;endif; wp_reset_query(); ?>
    </ul>
</section>
<!-- 相关文章end -->