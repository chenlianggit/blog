<?php global $salong;?>
<section class="post-social">
    <!--文章点赞-->
    <div class="post-like">
        <?php echo getPostLikeLink(get_the_ID());?>
    </div>
    <!--打赏-->
    <div class="rewards">

        <a class="btn" href="#pay" title="<?php printf( __( '觉得%s有用请给作者打赏！' , 'salong' ), esc_attr(post_name())); ?>">
            <?php _e( '赏', 'salong'); ?>
        </a>
    </div>
    <div class="share">
        <span><i class="icon-share"></i><?php _e('分享','salong'); ?></span>
        <div class="share_btn">
            <?php if(!wp_is_mobile()){ ?>
            <a href="#weixin_qr" title="<?php _e('分享到微信','salong'); ?>" class="weixin" rel="nofollow"><i class="icon-wechat"></i></a>
            <?php } ?>
            <a target="_blank" target="_blank" href="https://service.weibo.com/share/share.php?url=<?php the_permalink() ?>&amp;title=【<?php the_title(); ?>】<?php if (has_excerpt()) { ?><?php echo strip_tags(get_the_excerpt()); ?><?php } else{ echo strip_tags(wp_trim_words(get_the_content(),66)); } ?>&nbsp;@<?php bloginfo('name'); ?>&amp;appkey=<?php echo $salong['weibo_key']; ?>&amp;pic=<?php if(get_post_meta($post->ID, " thumb ", true)) { echo $bd_img; }else if( has_post_thumbnail() ){ echo $timthumb[0]; } else if($n > 1){ echo $strResult[1][0]; } else { echo $default_img; } ?>&amp;searchPic=true" title="<?php _e('分享到新浪微博','salong'); ?>" class="weibo" rel="nofollow"><i class="icon-weibo"></i></a>
            <a target="_blank" href="https://connect.qq.com/widget/shareqq/index.html?url=<?php the_permalink() ?>&title=<?php the_title(); ?>&desc=&summary=<?php if (has_excerpt()) { ?><?php echo wp_trim_words(get_the_excerpt(),116); ?><?php } else{ echo wp_trim_words(get_the_content(),116); } ?>&site=<?php echo bloginfo('name'); ?>" title="<?php _e('分享到QQ好友','salong'); ?>" class="qq" rel="nofollow"><i class="icon-qq"></i></a>
            <a target="_blank" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php the_permalink() ?>&title=<?php the_title(); ?>&desc=&summary=<?php if (has_excerpt()) { ?><?php echo wp_trim_words(get_the_excerpt(),116); ?><?php } else{ echo wp_trim_words(get_the_content(),116); } ?>&site=<?php echo bloginfo('name'); ?>" title="<?php _e('分享到QQ空间','salong'); ?>" class="qqzone" rel="nofollow"><i class="icon-qzone"></i></a>
        </div>
    </div>
</section>
