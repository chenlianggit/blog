<?php
/*
Template Name: 客户留言
*/ 
get_header();
global $salong; ?>
<article class="crumbs_page">
    <h2><?php the_title(); ?></h2>
    <div class="bg"></div>
</article>
<section class="container">
    <section class="wrapper<?php if(!wp_is_mobile()) { echo ' content_left'; } ?>">
        <section class="content-wrap">
            <article class="box<?php triangle();wow(); ?>">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="content-post">
                    <?php the_content(); ?>
                    <!-- 读者墙 -->
                    <?php $excludeemail = $salong['exclude_email']; $messagecount = $salong['message_count'];
                    $query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url,user_id, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND comment_author_email != '$excludeemail' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT $messagecount"; 
                    $wall = $wpdb->get_results($query);
                    $maxNum = $wall[0]->cnt;?>
                    <ul class="readers-list layout_ul">
                    <?php
                    foreach ($wall as $comment){
                        if( $comment->comment_author_url ){
                            if ($salong['switch_link_go']) {
                                $url = external_link($comment->comment_author_url);
                            } else {
                                $url = $comment->comment_author_url;
                            }
                        }else{ $url="#";}
                        $r="rel='external nofollow'";
                        $imgsize="48";//头像的大小，如果修改，CSS样式也得相应地修改。
                        ?>
                        <li class="layout_li"><a target="_blank" href="<?php echo $url; ?>" <?php echo $r; ?> title="<?php _e('查看TA的站点','salong'); ?>">
                        <?php $user_id = $comment->user_id; $user_name = $comment->comment_author; echo salong_get_avatar($user_id,$user_name).$comment->comment_author; ?>&nbsp;+&nbsp;<?php echo $comment->cnt;?>
                        </a></li>
                        <?php } ?>
                    </ul>
                    <!-- 读者墙end -->
                </div>
                <!-- 文章end -->
                <?php endwhile; endif; ?>
            </article>
            <?php comments_template(); ?>
        </section>
        <!-- 博客边栏 -->
        <?php get_sidebar(); ?>
        <!-- 博客边栏end -->
    </section>
</section>
<?php get_footer(); ?>