<?php global $salong;
$likecount      = $salong[ 'like_count'];//数量
$likecat        = $salong[ 'like_cat'];//分类
$like_post_time = $salong['like_post_time'];//时间
?>
<?php if($likecat) { ?>
<section class="like wrapper box<?php triangle();wow(); ?>">
    <!--标题-->
    <section class="home_title">
        <h3 class="left"><?php echo $salong['like_title']; ?></h3>
        <?php if($salong[ 'like_tag']) { ?>
        <section class="title-tag right">
            <ul>
                <?php $hometagsorderby=$salong[ 'home_tag_orderby']; $hometagsorder=$salong[ 'home_tag_order']; $hometags=implode( ',',$salong[ 'like_tag']); $args=array( 'include'=> $hometags,'orderby'=>$hometagsorderby, 'order'=>$hometagsorder);$tags = get_tags($args);foreach ($tags as $tag) { ?>
                <li>
                    <a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php _e( '查看'); ?> <?php echo $tag->name;?> <?php _e( '标签下的文章'); ?>">
                        <?php echo $tag->name; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
            <?php if ($salong[ 'like_link']) { ?>
            <a href="<?php $like_link = $salong['like_link']; ?><?php echo get_page_link($like_link); ?>" class="home_button" title="<?php _e( '查看更多', 'salong' ); ?>"><i class="icon-plus-circled"></i></a>
            <?php } ?>
        </section>
        <?php } ?>
    </section>
    <!--标题end-->
    <section class="post_list<?php if(!wp_is_mobile()) { echo ' post_bottom'; } ?>">
        <ul class="layout_ul">
            <?php $args=array( 'post_type'=> 'post','posts_per_page' => $likecount,'ignore_sticky_posts' => 1,'cat'=> implode( ',',$likecat),'meta_key'=>'votes_count','orderby'=>'meta_value_num','date_query' => array(array('after' => $like_post_time))); $wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <li class="layout_li">
                <?php get_template_part( 'content/post', 'grid'); ?>
            </li>
            <?php endwhile;endif; ?>
            <?php wp_reset_query(); ?>
        </ul>
    </section>
</section>
<?php } ?>