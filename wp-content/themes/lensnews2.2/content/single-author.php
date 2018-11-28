<?php global $salong,$wc_points_rewards;
$user_id      = get_the_author_meta('ID');
$user_name    = get_the_author_meta('display_name');
$post_count   =count_user_posts( $user_id, 'post');
$gallery_count=count_user_posts( $user_id, 'gallery');
$video_count  =count_user_posts( $user_id, 'video');
$product_count=count_user_posts( $user_id, 'product');
?>
<?php if (function_exists( 'woocommerce_points_rewards_my_points' ) ) {
    $points_balance = WC_Points_Rewards_Manager::get_users_points($user_id);
}?>
<section class="post_author box<?php triangle();wow(); ?>">
   
        <?php echo salong_get_avatar($user_id,$user_name); ?>
    <section class="post_count">
    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php echo $user_name; ?>">
        <h3><?php echo $user_name; ?></h3>
    </a>
        <?php if($post_count != 0) { ?><span><?php _e( '文章：', 'salong'); ?><?php echo $post_count; ?></span><?php } ?>
        <?php if($gallery_count != 0) { ?><span><?php _e( '画廊：', 'salong'); ?><?php echo $gallery_count; ?></span><?php } ?>
        <?php if($video_count != 0) { ?><span><?php _e( '视频：', 'salong'); ?><?php echo $video_count; ?></span><?php } ?>
        <?php if($product_count != 0) { ?><span><?php _e( '商品：', 'salong'); ?><?php echo $product_count; ?></span><?php } ?>
        <?php if (function_exists( 'woocommerce_points_rewards_my_points' ) ) { ?><span><?php _e( '积分：', 'salong'); ?><?php echo $points_balance; ?></span><?php } ?>
    </section>
    <p>
        <?php echo the_author_meta('description'); ?>
    </p>
</section>