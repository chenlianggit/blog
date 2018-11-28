<?php
/*
Template Name: 标签云
*/ 
get_header();
global $salong;
$product_args=array( 'order'=> 'DESC', 'orderby' => 'count', 'taxonomy' => 'product_tag', ); $product_tags = get_terms($product_args);//产品标签
$gallery_args=array( 'order'=> 'DESC', 'orderby' => 'count', 'taxonomy' => 'gallery-tag', ); $gallery_tags = get_terms($gallery_args);//画廊标签
$video_args=array( 'order'=> 'DESC', 'orderby' => 'count', 'taxonomy' => 'video-tag', ); $video_tags = get_terms($video_args);//视频标签
$post_args=array( 'order'=> 'DESC', 'orderby' => 'count', 'taxonomy' => 'post_tag', ); $post_tags = get_terms($post_args);//文章标签
?>
<article class="crumbs_page">
    <h2><?php the_title(); ?></h2>
    <div class="bg"></div>
</article>
<section class="container">
    <section class="wrapper tags">
        <?php if (class_exists( 'woocommerce' ) && $product_tags){ ?>
        <section class="box<?php triangle();wow(); ?>">
            <section class="home_title">
                <h3><?php _e( '产品标签','salong'); ?></h3>
            </section>
            <section class="sltags">
                <?php foreach($product_tags as $product_tag) { ?>
                <a href="<?php echo get_tag_link($product_tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇产品' , 'salong' ), esc_attr($product_tag->name), esc_attr($product_tag->count)); ?>">
                    <?php echo $product_tag->name; ?><span>(<?php echo $product_tag->count; ?>)</span></a>
                <?php } ?>
            </section>
        </section>
        <?php } if (in_array( 'gallery', $salong[ 'switch_post_type']) && $gallery_tags) { ?>
        <section class="box<?php triangle();wow(); ?>">
            <section class="home_title">
                <h3><?php _e( '画廊标签','salong'); ?></h3>
            </section>
            <section class="sltags">
                <?php foreach($gallery_tags as $gallery_tag) { ?>
                <a href="<?php echo get_tag_link($gallery_tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇画廊' , 'salong' ), esc_attr($gallery_tag->name), esc_attr($gallery_tag->count)); ?>">
                    <?php echo $gallery_tag->name; ?><span>(<?php echo $gallery_tag->count; ?>)</span></a>
                <?php } ?>
            </section>
        </section>
        <?php } if (in_array( 'video', $salong[ 'switch_post_type']) && $video_tags) { ?>
        <section class="box<?php triangle();wow(); ?>">
            <section class="home_title">
                <h3><?php _e( '视频标签','salong'); ?></h3>
            </section>
            <section class="sltags">
                <?php foreach($video_tags as $video_tag) { ?>
                <a href="<?php echo get_tag_link($video_tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇视频' , 'salong' ), esc_attr($video_tag->name), esc_attr($video_tag->count)); ?>">
                    <?php echo $video_tag->name; ?><span>(<?php echo $video_tag->count; ?>)</span></a>
                <?php } ?>
            </section>
        </section>
        <?php } ?>
        <section class="box<?php triangle();wow(); ?>">
            <section class="home_title">
                <h3><?php _e( '文章标签','salong'); ?></h3>
            </section>
            <section class="sltags">
                <?php if ($post_tags) { foreach($post_tags as $post_tag) { ?>
                <a href="<?php echo get_tag_link($post_tag); ?>" title="<?php printf( __( '标签 %s 下有 %s 篇文章' , 'salong' ), esc_attr($post_tag->name), esc_attr($post_tag->count)); ?>">
                    <?php echo $post_tag->name; ?><span>(<?php echo $post_tag->count; ?>)</span></a>
                <?php } } ?>
            </section>
        </section>
    </section>
</section>
<?php get_footer(); ?>