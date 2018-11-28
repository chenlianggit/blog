<?php global $salong; if ($salong[ 'video_list_cat']){ $videocount=$salong[ 'video_list_count']; foreach($salong[ 'video_list_cat'] as $videocat) { ?>
<section class="video_list_cat box<?php triangle();wow(); ?>">
    <section class="home_title">
        <h3><a href="<?php echo get_category_link($videocat);?>" title="查看更多 <?php echo get_cat_name($videocat);?> 的文章"><?php echo get_cat_name($videocat);?></a></h3>
    </section>
    <ul class="layout_ul">
        <?php $wp_query=new WP_Query(array( 'post_type'=> 'video', 'posts_per_page' => $videocount, 'tax_query' => array( array( 'taxonomy' => 'video-cat', 'field' => 'id', 'terms' => $videocat ), ), ) );if ($wp_query->have_posts()): while ($wp_query->have_posts()): $wp_query->the_post(); ?>
        <li class="layout_li">
            <?php get_template_part( 'content/list', 'video'); ?>
        </li>
        <?php endwhile;endif; ?>
    </ul>
</section>
<?php } } ?>