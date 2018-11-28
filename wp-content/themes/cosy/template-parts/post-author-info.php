<?php

/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-11 11:04:51
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-10 21:03:08

*/
?>
<div class="post-author">
    <div class="author-avatar pull-left">
        <?php echo get_avatar( $post->post_author, 65, '', '', null ); ?>
    </div>
    <div class="author-info">
        <h4><?php the_author(); ?></h4>                        
        <div class="desc">
            <p><?php echo nl2br( get_the_author_meta('description') ); ?></p>
        </div>
        <div class="links">
            <a href="<?php echo get_author_posts_url( $post->post_author ); ?>" target="_blank" class="btn-author-sns fa fa-link"></a>
            <a href="<?php echo get_the_author_meta( 'qq', false ); ?>" target="_blank" class="btn-author-sns fa fa-qq"></a>
            
            <a href="<?php echo get_the_author_meta( 'weibo', false ); ?>" target="_blank" class="btn-author-sns fa fa-weibo"></a>

            <a data-module="miPopup" data-selector="#author_qrcode"  href="#" class="btn-author-sns fa fa-weixin"></a>
            <div class="dialog-suxing" id="author_qrcode">
                <div class="dialog-content dialog-wechat-content">
                    <p>扫码关注</p>
                    <img <?php echo is_lazysizes(); ?>src="<?php echo get_the_author_meta( 'weixin', false ); ?>" alt="">
                    <div class="btn-close">
                      <i class="icon icon-close"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>