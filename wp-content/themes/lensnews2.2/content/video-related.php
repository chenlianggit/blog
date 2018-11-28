<!-- 相关文章 -->
<?php global $salong; $taxterms = wp_get_object_terms( $post->ID, 'video-cat', array('fields' => 'ids') ); ?>

<section class="vrelated_posts video_list box<?php triangle();wow(); ?>">
    <!--标题-->
    <section class="home_title">
        <h3><?php echo $salong['vrelated_title']; ?></h3>
    </section>
    <!--标题end-->
    <ul class="layout_ul">
        <?php $args=array( 'post_type'=> 'video','posts_per_page' => $salong[ 'vrelated_count'],'orderby'=>'rand','ignore_sticky_posts' => 1,'tax_query' => array( array( 'taxonomy' => 'video-cat', 'field' => 'id', 'terms' => $taxterms ) ));$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $i=1; while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
        <li class="layout_li">
            <?php get_template_part( 'content/list', 'video'); ?>
        </li>
        <?php endwhile;endif; wp_reset_query(); ?>
    </ul>
</section>
<!-- 相关文章end -->