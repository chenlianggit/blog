<?php global $salong; ?>
<section class="footer-popup">
    <?php if ($salong[ 'switch_side_metas'] ) { ?>
    <?php if (wp_is_mobile()) { ?>
    <!--移动设备上按钮-->
    <a class="side_btn show"><i class="icon-lock"></i></a>
    <?php } ?>
    <?php if (in_array( 'search', $salong[ 'side_metas'])) { ?>
    <!--搜索-->
    <a class="side_btn search" href="#search" title="<?php _e( '点击按钮进行搜索', 'salong' ); ?>"><i class="icon-search-1"></i></a>
    <?php } if (in_array( 'wechat', $salong[ 'side_metas'])) { ?>
    <!--微信公众号-->
    <a class="side_btn wechat" href="#wechat" title="<?php _e( '关注', 'salong' ); ?><?php bloginfo( 'name' ); ?><?php _e( '微信公众号', 'salong' ); ?>"><i class="icon-wechat"></i></a>
    <?php } if (in_array( 'line', $salong[ 'side_metas'])) { ?>
    <!--QQ与微信二维码-->
    <a class="side_btn line" href="#line" title="<?php _e( '点击扫描QQ或微信二维码联系我们', 'salong' ); ?>"><i class="icon-qq"></i></a>
    <?php } if (in_array( 'weibo', $salong[ 'side_metas'])) { ?>
    <!--微博-->
    <a class="side_btn weibo" href="<?php echo $salong['weibo_link']; ?>" title="<?php _e( '新浪微博', 'salong' ); ?>" target="_blank"><i class="icon-weibo"></i></a>
    <?php } if (in_array( 'share', $salong[ 'side_metas'])) { ?>
    <!--分享-->
    <a class="side_btn share" href="#share" title="<?php _e( '百度分享', 'salong' ); ?>"><i class="icon-share"></i></a>
    <?php } if (in_array( 'gb2big5', $salong[ 'side_metas'])) { ?>
    <!--简繁切换-->
    <a name="gb2big5" id="gb2big5" class="side_btn gb2big5" title="<?php _e('简繁切换','salong'); ?>">
        <?php _e( '简', 'salong'); ?>
    </a>
    <?php } if (in_array( 'comment', $salong[ 'side_metas']) && 'open'==$post->comment_status) { ?>
    <!--去评论-->
    <?php if (is_page_template( 'template-link.php') || is_page_template( 'template-message.php')) { ?>
    <a class="side_btn comment" id="back-to-comment" href="#respond"><i class="icon-chat"></i></a>
    <?php } if (is_singular( 'post') && in_array( 'comment', $salong[ 'blog_metas'])) { ?>
    <a class="side_btn comment" id="back-to-comment" href="#respond"><i class="icon-chat"></i></a>
    <?php } if (is_singular( 'gallery') && in_array( 'comment', $salong[ 'gallery_metas'])) { ?>
    <a class="side_btn comment" id="back-to-comment" href="#respond"><i class="icon-chat"></i></a>
    <?php } if (is_singular( 'video') && in_array( 'comment', $salong[ 'video_metas'])) { ?>
    <a class="side_btn comment" id="back-to-comment" href="#respond"><i class="icon-chat"></i></a>
    <?php } ?>
    <?php } if (in_array( 'top', $salong[ 'side_metas'])) { ?>
    <!--回顶部-->
    <a class="side_btn top" id="back-to-top" href="#top" title="<?php _e( '返回顶部', 'salong' ); ?>"><i class="icon-flight"></i></a>
    <?php } if (in_array( 'line', $salong[ 'side_metas'])) { ?>
    <!--二维码弹窗-->
    <a href="#nl" class="overlay" id="line"></a>
    <article class="line popup">
        <h3>
            <?php echo $salong['line_title']; ?>
        </h3>
        <p>
            <?php echo $salong['line_desc']; ?>
        </p>
        <?php if( $salong[ 'qqqr'][ 'url']){ ?><span><img src="<?php echo $salong[ 'qqqr']['url']; ?>" alt="萨龙龙的QQ二维码"><i class="icon-qq">QQ二维码</i></span>
        <?php } ?>
        <?php if( $salong[ 'weixinqr'][ 'url']){ ?><span><img src="<?php echo $salong[ 'weixinqr']['url']; ?>" alt="萨龙龙的微信二维码"><i class="icon-wechat">微信二维码</i></span>
        <?php } ?>
    </article>
    <!--二维码弹窗end-->
    <?php } ?>

    <?php if (in_array( 'wechat', $salong[ 'side_metas'])) { ?>
    <!-- 微信公众号 -->
    <a id="wechat" class="overlay" href="#nl"></a>
    <article class="wechat popup">
        <h3>
            <?php _e( '关注', 'salong' ); ?>
            <?php bloginfo( 'name' ); ?>
            <?php _e( '微信公众号', 'salong' ); ?>
        </h3>
        <img src="<?php echo $salong['wechat']['url']; ?>" alt="<?php bloginfo( 'name' ); ?><?php _e( '微信公众号', 'salong' ); ?>" />
    </article>
    <?php } ?>

    <?php if (in_array( 'search', $salong[ 'side_metas']) || $salong['switch_search_menu']) { ?>
    <!-- 搜索 -->
    <a id="search" class="overlay" href="#nl"></a>
    <article class="search popup">
        <h3><i class="icon-search-1"></i>
            <?php _e( '按文章类型进行搜索', 'salong' ); ?>
        </h3>
        <form method="get" class="search_form" action="<?php echo get_home_url(); ?>">
            <select name="post_type" class="search_type">
                <option value="post">
                    <?php _e( '文章', 'salong' ); ?>
                </option>
                <?php if (in_array( 'gallery', $salong[ 'switch_post_type'])) { ?>
                <option value="gallery">
                    <?php _e( '画廊', 'salong' ); ?>
                </option>
                <?php } if (in_array( 'video', $salong[ 'switch_post_type'])) { ?>
                <option value="video">
                    <?php _e( '视频', 'salong' ); ?>
                </option>
                <?php } if (class_exists( 'woocommerce' )){ ?>
                <option value="product">
                    <?php _e( '产品', 'salong' ); ?>
                </option>
                <?php } ?>
            </select>
            <input class="text_input" type="text" placeholder="<?php _e( '输入关键字…', 'salong' ); ?>" name="s" id="s" />
            <input type="submit" class="search_btn" id="searchsubmit" value="<?php _e( '搜索', 'salong' ); ?>" />
        </form>
    </article>
    <?php } } if(!wp_is_mobile()){ ?>
    <!-- 文章微信二维码 -->
    <a id="weixin_qr" class="overlay" href="#nl"></a>
    <article class="weixin_qr popup">
        <h3>
            <?php _e( '分享到微信朋友圈', 'salong' ); ?>
        </h3>
        <img src="https://pan.baidu.com/share/qrcode?w=258&h=258&url=<?php the_permalink(); ?>" alt="<?php the_title(); ?>" />
        <p>
            <?php _e( '打开微信，点击底部的“发现”<br>使用“扫一扫”即可将网页分享至朋友圈。', 'salong' ); ?>
        </p>
    </article>
    <?php } ?>
    <!--打赏-->
    <a href="#thanks" class="overlay" id="pay"></a>
    <article class="pay popup">
        <h3>
            <?php printf( __( '觉得%s有用请给作者打赏！' , 'salong' ), esc_attr(post_name())); ?>
        </h3>
        <?php if( $salong[ 'alipay'][ 'url']){ ?><span><img src="<?php echo $salong[ 'alipay']['url']; ?>" alt="支付宝收款二维码"><i>支付宝扫一扫打赏</i></span>
        <?php } ?>
        <?php if( $salong[ 'weixinpay'][ 'url']){ ?><span><img src="<?php echo $salong[ 'weixinpay']['url']; ?>" alt="微信收款二维码"><i>微信扫一扫打赏</i></span>
        <?php } ?>
    </article>
    <!--打赏-->
    <a href="#thanks" class="overlay" id="pay"></a>
    <article class="pay popup">
        <h3>
            <?php printf( __( '觉得%s有用请给作者打赏！' , 'salong' ), esc_attr(post_name())); ?>
        </h3>
        <?php if( $salong[ 'alipay'][ 'url']){ ?><span><img src="<?php echo $salong[ 'alipay']['url']; ?>" alt="支付宝收款二维码"><i>支付宝扫一扫打赏</i></span>
        <?php } ?>
        <?php if( $salong[ 'weixinpay'][ 'url']){ ?><span><img src="<?php echo $salong[ 'weixinpay']['url']; ?>" alt="微信收款二维码"><i>微信扫一扫打赏</i></span>
        <?php } ?>
    </article>
</section>
