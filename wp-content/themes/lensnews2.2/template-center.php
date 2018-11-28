<?php
/*
Template Name: 用户中心首页
*/
get_header();
global $salong,$post,$current_user,$wc_points_rewards,$woocommerce;
$user_id        = $current_user->ID;//登录用户ID
$user_login     = $current_user->user_login;
$first_name     = $current_user->first_name;
$last_name      = $current_user->last_name;
$user_name      = $current_user->display_name;
$user_email     = $current_user->user_email;
$user_url       = $current_user->user_url;
$user_registered= $current_user->user_registered;
$description    = $current_user->description;
$blog_name      = get_bloginfo('name');
$comments_count = get_comments( array('status' => '1', 'user_id'=>$user_id, 'count' => true) );//评论数量
if (function_exists( 'woocommerce_points_rewards_my_points')) {
    $points_balance = WC_Points_Rewards_Manager::get_users_points( get_current_user_id() );//积分
}
//文章统计
$post_count           = count_user_posts( $user_id, 'post');
$args_post            = new Wp_query(array(
    'post_type'       => 'post',
    'posts_per_page'  => -1,
    'author'          => $user_id
));
$post_count_view     = 0;
$post_count_like     = 0;
while( $args_post->have_posts() ) : $args_post->the_post();
$views          = absint(get_post_meta($post->ID, 'views', true));
$votes_count    = absint(get_post_meta($post->ID, 'votes_count', true));
$post_count_view += $views;
$post_count_like += $votes_count;
endwhile; wp_reset_postdata();
if (in_array( 'gallery', $salong[ 'switch_post_type'])) {
//画廊统计
$gallery_count           = count_user_posts( $user_id, 'gallery');
$args_gallery            = new Wp_query(array(
    'post_type'       => 'gallery',
    'posts_per_page'  => -1,
    'author'          => $user_id
));
$gallery_count_view     = 0;
$gallery_count_like     = 0;
while( $args_gallery->have_posts() ) : $args_gallery->the_post();
$views          = absint(get_post_meta($post->ID, 'views', true));
$votes_count    = absint(get_post_meta($post->ID, 'votes_count', true));
$gallery_count_view += $views;
$gallery_count_like += $votes_count;
endwhile; wp_reset_postdata();
}if (in_array( 'gallery', $salong[ 'switch_post_type'])) {
//视频统计
$video_count           = count_user_posts( $user_id, 'video');
$args_video            = new Wp_query(array(
    'post_type'       => 'video',
    'posts_per_page'  => -1,
    'author'          => $user_id
));
$video_count_view     = 0;
$video_count_like     = 0;
while( $args_video->have_posts() ) : $args_video->the_post();
$views          = absint(get_post_meta($post->ID, 'views', true));
$votes_count    = absint(get_post_meta($post->ID, 'votes_count', true));
$video_count_view += $views;
$video_count_like += $votes_count;
endwhile; wp_reset_postdata();
}if (class_exists( 'woocommerce')) {
//商城统计
$product_count           = count_user_posts( $user_id, 'product');
$args_product            = new Wp_query(array(
    'post_type'       => 'product',
    'posts_per_page'  => -1,
    'author'          => $user_id
));
$product_count_view     = 0;
$product_count_like     = 0;
while( $args_product->have_posts() ) : $args_product->the_post();
$views          = absint(get_post_meta($post->ID, 'views', true));
$votes_count    = absint(get_post_meta($post->ID, 'votes_count', true));
$product_count_view += $views;
$product_count_like += $votes_count;
endwhile; wp_reset_postdata();
}
?>
<?php get_template_part( 'content/center', 'header'); ?>
<!-- 内容 -->
<section class="wpuf-wrap box<?php triangle();wow(); ?>">
    <!-- 个人资料 -->
    <a href="<?php if($user_url){ echo $user_url;} ?>" class="avatar" target="_blank" rel="external nofollow" title="<?php _e('访问我的站点！','salong'); ?>">
        <?php echo salong_get_avatar($user_id,$user_name); ?>
    </a>
    <section class="basic_profile">
        <h3><?php _e('基本信息','salong'); ?></h3>
        <p>
            <?php printf( __( '%s 您好，欢迎来到 %s 用户中心！', 'salong' ), esc_attr($user_name), esc_attr($blog_name)); ?>
        </p>
        <ul>
            <li><span><?php _e('ID：','salong'); ?></span>
                <?php echo $user_id; ?>
            </li>
            <li><span><?php _e('帐号：','salong'); ?></span>
                <?php echo $user_login; ?>
            </li>
            <li><span><?php _e('角色：','salong'); ?></span>
                <?php if ( user_can( $user_id, 'administrator' )){echo __('管理员','salong');}else if(user_can( $user_id, 'editor' )){echo __('编辑','salong');}else if(user_can( $user_id, 'author' )){echo __('作者','salong');}else if(user_can( $user_id, 'contributor' )){echo __('投稿者','salong');}else if(user_can( $user_id, 'subscriber' )){echo __('订阅者','salong');}else if(user_can( $user_id, 'shop_manager' )){echo __('产品管理者','salong');}else if(user_can( $user_id, 'bbp_keymaster' )){echo __('Keymaster','salong');}else if(user_can( $user_id, 'customer' )){echo __('顾客','salong');}else if(user_can( $user_id, 'bbp_spectator' )){echo __('观众','salong');}else if(user_can( $user_id, 'bbp_blocked' )){echo __('禁闭','salong');} ?>
            </li>
            <?php if($first_name && $last_name){ ?>
            <li><span><?php _e('姓名：','salong'); ?></span>
                <?php echo $last_name; ?><?php echo $first_name; ?>
            </li>
            <?php } ?>
            <li><span><?php _e('昵称：','salong'); ?></span>
                <?php echo $user_name; ?>
            </li>
            <li><span><?php _e('邮箱：','salong'); ?></span>
                <?php echo $user_email; ?>
            </li>
            <?php if($user_url){ ?>
            <li><span><?php _e('站点：','salong'); ?></span>
                <a href="<?php echo $user_url; ?>" title="<?php _e('访问我的站点！','salong'); ?>">
                    <?php echo $user_url; ?>
                </a>
            </li>
            <?php } ?>
            <li><span><?php _e('注册时间：','salong'); ?></span>
                <?php echo $user_registered; ?>
            </li>
            <?php if($description){ ?>
            <li><span><?php _e('个人说明：','salong'); ?></span>
                <?php echo $description; ?>
            </li>
            <?php } ?>
        </ul>
    </section>
    <!-- 网站统计 -->
    <section class="site_stats">
        <h3><?php _e('我的统计','salong'); ?></h3>
        <ul class="layout_ul">
            <li class="layout_li">
                <article class="stats_main">
                    <h4><?php _e('文章','salong'); ?></h4>
                    <?php $args=array( 'author'=> $user_id,'post_type' => array('post'),'posts_per_page' => 1,'ignore_sticky_posts'=> 1);$newpost_query = new WP_Query($args);if( $newpost_query->have_posts() ) {while ($newpost_query->have_posts()) : $newpost_query->the_post(); ?>
                    <div class="new_post">
                    <?php _e( '最新：', 'salong'); ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                        <?php the_title(); ?>
                    </a>
                    </div>
                    <?php endwhile;}wp_reset_query(); ?>
                    <span><?php _e('文章数量：','salong'); ?><b><?php echo $post_count; ?></b></span>
                    <span><?php _e('浏览数量：','salong'); ?><b><?php echo $post_count_view; ?></b></span>
                    <span><?php _e('点赞数量：','salong'); ?><b><?php echo $post_count_like; ?></b></span>
                </article>
            </li>
            <?php if (in_array( 'gallery', $salong[ 'switch_post_type'])) { ?>
            <li class="layout_li">
                <article class="stats_main">
                    <h4><?php _e('画廊','salong'); ?></h4>
                    <?php $args=array( 'author'=> $user_id,'post_type' => array('gallery'),'posts_per_page' => 1,'ignore_sticky_posts'=> 1);$newgallery_query = new WP_Query($args);if( $newgallery_query->have_posts() ) {while ($newgallery_query->have_posts()) : $newgallery_query->the_post(); ?>
                    <div class="new_post">
                    <?php _e( '最新：', 'salong'); ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                        <?php the_title(); ?>
                    </a>
                    </div>
                    <?php endwhile;}wp_reset_query(); ?>
                    <span><?php _e('画廊数量：','salong'); ?><b><?php echo $gallery_count; ?></b></span>
                    <span><?php _e('浏览数量：','salong'); ?><b><?php echo $gallery_count_view; ?></b></span>
                    <span><?php _e('点赞数量：','salong'); ?><b><?php echo $gallery_count_like; ?></b></span>
                </article>
            </li>
            <?php } if (in_array( 'video', $salong[ 'switch_post_type'])) { ?>
            <li class="layout_li">
                <article class="stats_main">
                    <h4><?php _e('视频','salong'); ?></h4>
                    <?php $args=array( 'author'=> $user_id,'post_type' => array('video'),'posts_per_page' => 1,'ignore_sticky_posts'=> 1);$newvideo_query = new WP_Query($args);if( $newvideo_query->have_posts() ) {while ($newvideo_query->have_posts()) : $newvideo_query->the_post(); ?>
                    <div class="new_post">
                    <?php _e( '最新：', 'salong'); ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                        <?php the_title(); ?>
                    </a>
                    </div>
                    <?php endwhile;}wp_reset_query(); ?>
                    <span><?php _e('视频数量：','salong'); ?><b><?php echo $video_count; ?></b></span>
                    <span><?php _e('浏览数量：','salong'); ?><b><?php echo $video_count_view; ?></b></span>
                    <span><?php _e('点赞数量：','salong'); ?><b><?php echo $video_count_like; ?></b></span>
                </article>
            </li>
            <?php } if (class_exists( 'woocommerce')) { ?>
            <li class="layout_li">
                <article class="stats_main">
                    <h4><?php _e('产品','salong'); ?></h4>
                    <?php $args=array( 'author'=> $user_id,'post_type' => array('product'),'posts_per_page' => 1,'ignore_sticky_posts'=> 1);$newproduct_query = new WP_Query($args);if( $newproduct_query->have_posts() ) {while ($newproduct_query->have_posts()) : $newproduct_query->the_post(); ?>
                    <div class="new_post">
                    <?php _e( '最新：', 'salong'); ?>
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                        <?php the_title(); ?>
                    </a>
                    </div>
                    <?php endwhile;}wp_reset_query(); ?>
                    <span><?php _e('产品数量：','salong'); ?><b><?php echo $product_count; ?></b></span>
                    <span><?php _e('浏览数量：','salong'); ?><b><?php echo $product_count_view; ?></b></span>
                    <span><?php _e('点赞数量：','salong'); ?><b><?php echo $product_count_like; ?></b></span>
                </article>
            </li>
            <?php } if (function_exists( 'woocommerce_points_rewards_my_points')) { ?>
            <li class="layout_li">
                <article class="stats_main">
                    <h4><?php _e('积分','salong'); ?></h4>
                    <span><?php _e('积分数量：','salong'); ?><b><?php echo $points_balance; ?></b></span>
                </article>
            </li>
            <?php } ?>
            <li class="layout_li">
                <article class="stats_main">
                    <h4><?php _e('评论','salong'); ?></h4>
                    <span><?php _e('评论数量：','salong'); ?><b><?php echo $comments_count; ?></b></span>
                </article>
            </li>
        </ul>
    </section>
    <!-- 获取文章 -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!-- 文章内容 -->
    <div class="content-post">
        <?php the_content(); ?>
    </div>
    <?php endwhile; endif; ?>
</section>
<!-- 内容end -->
</section>
</section>
<!-- 主体内容end -->
<?php get_footer(); ?>