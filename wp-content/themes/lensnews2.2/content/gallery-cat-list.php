<?php global $salong; if ($salong[ 'gallery_list_cat']){ $gallerycount=$salong[ 'gallery_list_count']; foreach($salong[ 'gallery_list_cat'] as $gallerycat) { ?>
<section class="gallery_list_cat box<?php triangle();wow(); ?>">
    <section class="home_title">
        <h3><a href="<?php echo get_category_link($gallerycat);?>" title="查看更多 <?php echo get_cat_name($gallerycat);?> 的文章"><?php echo get_cat_name($gallerycat);?></a></h3>
    </section>
    <ul class="layout_ul">
        <?php $wp_query=new WP_Query(array( 'post_type'=> 'gallery', 'posts_per_page' => $gallerycount, 'tax_query' => array( array( 'taxonomy' => 'gallery-cat', 'field' => 'id', 'terms' => $gallerycat ), ), ) );if ($wp_query->have_posts()): while ($wp_query->have_posts()): $wp_query->the_post(); ?>
        <li class="layout_li">
            <?php get_template_part( 'content/list', 'gallery'); ?>
        </li>
        <?php endwhile;endif; ?>
    </ul>
</section>
<?php } } ?>