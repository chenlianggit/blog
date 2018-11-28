<!-- 相关文章 -->
<?php global $salong; $taxterms = wp_get_object_terms( $post->ID, 'gallery-cat', array('fields' => 'ids') ); ?>

<section class="grelated_posts box<?php triangle();wow();if($salong['switch_gallery_content']){echo ' gallery_content';} ?>">
    <!--标题-->
    <section class="home_title">
        <h3><?php echo $salong['grelated_title']; ?></h3>
    </section>
    <!--标题end-->
    <ul class="layout_ul">
        <?php $args=array( 'post_type'=> 'gallery','posts_per_page' => $salong[ 'grelated_count'],'orderby'=>'rand','ignore_sticky_posts' => 1,'tax_query' => array( array( 'taxonomy' => 'gallery-cat', 'field' => 'id', 'terms' => $taxterms ) ));$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $i=1; while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
        <li class="layout_li">
            <?php get_template_part( 'content/list', 'gallery'); ?>
        </li>
        <?php endwhile;endif; wp_reset_query(); ?>
    </ul>
</section>
<!-- 相关文章end -->