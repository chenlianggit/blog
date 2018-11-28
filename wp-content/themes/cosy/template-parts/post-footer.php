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
  	@Date:   2017-09-11 11:09:12
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-18 00:17:14

*/

$Share = new MiShare();
$Share->config = array( 'url' => get_permalink(), 'title' => get_the_title(), 'pic' => timthumb( post_thumbnail_src(),null,'original'), 'des' => get_the_excerpt());

?>
<div class="post-footer clearfix">                 
    <div class="pull-left">
        <div class="post-action">
            <a class="btn-action btn-like <?php isset($_COOKIE['suxing_ding_'.get_the_ID()]) ? print('current') : print(''); ?>" href="javascript:;" id="Addlike" data-action="ding" data-id="<?php the_ID();?>"><i class="icon icon-heart"></i>
                <span class="count">
                    <?php 
                        if( get_post_meta($post->ID,'suxing_ding',true) ){                        	
                            echo get_post_meta($post->ID,'suxing_ding',true); 
                        }else{
                        	echo 0;
                        }
                    ?>
                </span>
            </a>
            <?php if( cs_get_option('share_bigger_img') ){ ?>
            <a class="btn-action btn-bigger-cover" data-module="miPopup" data-selector="#bigger-cover" href="javascript:;" ><i class="icons icon-paper-plane"></i> <span>生成封面</></a>
            <div class="dialog-suxing" id="bigger-cover">
                <div class="dialog-content dialog-bigger-cover">
                    <div class="row">
                        <div class="bigger-image col-xs-12 col-sm-6 col-md-6">
						<?php 
							$bigger_cover = get_post_meta( get_the_ID(), 'bigger_cover', true );
							if( $bigger_cover ){
						?>
							<img src="<?php echo $bigger_cover ?>" alt="<?php the_title(); ?> bigger封面">
						<?php }else{ ?>
                            <img class="load_bigger_img" data-nonce="<?php echo wp_create_nonce('mi-create-bigger-image-'.get_the_ID() );?>" data-id="<?php the_ID(); ?>" data-action="create-bigger-image" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?php the_title(); ?> bigger封面">

                            <div class="image-loading"><i></i></div>
						<?php } ?>
                        </div>
                        <div class="bigger-share col-xs-12 col-sm-6 col-md-6">
                            <div class="share-btns">
                                <h3><span>分享本文封面</span></h3>
                                <p class="text-center">
                                    <a href="<?php echo get_post_meta( get_the_ID(), 'bigger_cover_share', true ); ?>" class="btn btn-primary bigger_share"><i class="fa fa-weibo"></i> 分享到微博</a>
                                    <a href="<?php echo $bigger_cover; ?>" download="<?php the_title();?>-Bigger-cover" class="btn btn-primary bigger_down"><i class="icons icon-cloud-download"></i> 下载封面</a></a>
                                </p>
                                
                            </div>
                        </div>
                        <div class="action-share hidden-sm hidden-md hidden-lg">
                            <button class="btn-open-share"><i class="icons icon-share-alt"></i></button>
                            <button class="btn-close-share"><i class="icons icon-close"></i></button>
                        </div>
                    </div>
                    <div class="btn-close">
                        <i class="icons icon-close"></i>
                    </div>
                </div>    
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="pull-right">
        <ul class="social bdsharebuttonbox">
            <li><a class="weibo" rel="nofollow" target="_blank" href="<?php echo $Share->weibo(); ?>"><i class="fa fa-weibo"></i></a></li>
            <li><a data-module="miPopup" data-selector="#post_qrcode" class="weixin" rel="nofollow" href="javascript:;"><i class="fa fa-weixin"></i></a></li>
            <li><a class="qq" rel="nofollow" target="_blank" href="<?php echo $Share->qq(); ?>"><i class="fa fa-qq"></i></a></li>          
        </ul>
        <div class="dialog-suxing" id="post_qrcode">
            <div class="dialog-content dialog-wechat-content">
                  <p>微信扫一扫,分享到朋友圈</p>
                  <img src="<?php echo $Share->weixin(); ?>" alt="">
                  <div class="btn-close">
                      <i class="icon icon-close"></i>
                  </div>
            </div>    
        </div>
    </div>
</div>
