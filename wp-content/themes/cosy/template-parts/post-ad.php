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
  	@Date:   2017-10-08 19:28:21
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-10 21:03:07

*/
$ad_type = cs_get_option('single_insert_ad');

if(  $ad_type == 'image' ) : 
    $thumpic = wp_get_attachment_image_src(cs_get_option('single_insert_ad_img'),'full');
    $thumpic_moblie = wp_get_attachment_image_src(cs_get_option('single_insert_ad_img_mobile'),'full');
?>
    <div class="suxing-adv post-adv">
        <div class="visible-xs">
            <a href="<?php echo cs_get_option('single_insert_ad_url'); ?>">
                <img <?php echo is_lazysizes(); ?>src="<?php echo $thumpic_moblie[0]; ?>">
            </a>
            <?php
                if( cs_get_option('single_insert_ad_text') ){
                    echo '<span>广告</span>';
                }
            ?>
        </div>
        <div class="visible-sm visible-md visible-lg">
            <a href="<?php echo cs_get_option('single_insert_ad_url'); ?>">
                <img <?php echo is_lazysizes(); ?>src="<?php echo $thumpic[0]; ?>">
            </a>
            <?php
                if( cs_get_option('single_insert_ad_text') ){
                    echo '<span>广告</span>';
                }
            ?>
        </div>
    </div>
<?php endif;

if(  $ad_type == 'code' ) : ?>
    <div class="suxing-adv post-adv">
        <div class="visible-xs">
            <?php echo cs_get_option('single_insert_ad_html_mobile'); ?>
        </div>
        <div class="visible-sm visible-md visible-lg">
            <?php echo cs_get_option('single_insert_ad_html_pc'); ?>
        </div>
    </div>
<?php endif;

