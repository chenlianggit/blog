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
  	@Date:   2017-10-06 19:55:07
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-10 21:02:59

*/
$ad_type = cs_get_option('index_insert_ad_card');




if( $ad_type == 'image' && cs_get_option('index_insert_ad_card_position') == $GLOBALS['mii'] ){ 
  $thumpic = wp_get_attachment_image_src(cs_get_option('index_insert_ad_card_img'),'full');
  $thumpic_moblie = wp_get_attachment_image_src(cs_get_option('index_insert_ad_card_img_mobile'),'full');
?>
    <div class="col-grid adv-grid col-xs-12 col-sm-4 col-md-4">
        <article class="post post-grid suxing-adv">

            <div class="visible-xs">
              <a rel="nofollow" href="<?php echo cs_get_option('index_insert_ad_card_url'); ?>">
                  <img <?php echo is_lazysizes(); ?>src="<?php echo $thumpic_moblie[0]; ?>">
              </a>
              <?php
                  if( cs_get_option('index_insert_ad_card_text') ){
                      echo '<span>广告</span>';
                  }
              ?>
            </div>
            <div class="visible-sm visible-md visible-lg">
              <a rel="nofollow" href="<?php echo cs_get_option('index_insert_ad_card_url'); ?>">
                  <img <?php echo is_lazysizes(); ?>src="<?php echo $thumpic[0]; ?>">
              </a>
              <?php
                  if( cs_get_option('index_insert_ad_card_text') ){
                      echo '<span>广告</span>';
                  }
              ?>
            </div>

        </article>
    </div>
<?php }


if(  $ad_type == 'code' ) : ?>
<div class="col-grid adv-grid col-xs-12 col-sm-4 col-md-4">
    <article class="post post-grid suxing-adv">
        <div class="suxing-adv">
            <div class="visible-xs">
              <?php echo cs_get_option('index_insert_ad_card_html_mobile'); ?>
            </div>
            <div class="visible-sm visible-md visible-lg">
              <?php echo cs_get_option('index_insert_ad_card_html_pc'); ?>
            </div>
        </div>
    </article>
</div>
<?php endif;


if( cs_get_option('index_insert_topic')){
    $topic_ids = cs_get_option('index_topic_group');
    //foreach ($topic_ids as $val) {
        if( $GLOBALS['mii'] == $val['position'] ){
?>
			<div class="col-grid col-xs-12 col-sm-4 col-md-4">
				<article class="topic-grid owl-carousel owl-theme">

				<?php
                $ids = explode(',',$val['tag_id'],3);
                for ($j=0; $j < count( $ids ) ; $j++) { 
                    $term = get_term( $ids[$j], 'special' );
                    $topic_meta = get_term_meta( $term->term_id ,'_custom_special_options', true);
					
					if( empty( $topic_meta['special_thum'] ) ){

						$topic_meta['special_thum'] = cs_get_option('site_default_img') ? cs_get_option('site_default_img') : get_template_directory_uri().'/static/images/default.jpg';
					}

					if( is_numeric( $topic_meta['special_thum'] ) ){
						$topic_pic = wp_get_attachment_image_src($topic_meta['special_thum'],'full');
						$topic_pic = $topic_pic[0];
					}else{
						$topic_pic = $topic_meta['special_thum'];
					}
                ?>
						<div class="item">
				            <a href="<?php echo get_term_link( $term->term_id ); ?>" target="_blank" title="<?php echo $term->name; ?>">
				                <div class="image" style="background-image: url(<?php echo $topic_pic; ?>);">
				                    <div class="overlay"></div>
				                    <div class="content">
				                        <div class="title">
				                            <h2><?php echo $term->description; ?></h2>
				                        </div>
				                        <div class="meta">
				                            <span><i class="icon icon-layers"></i> 专题</span>
				                           
				                            <span><?php echo $term->count; ?>篇文章</span>
				                        </div>
				                    </div>
				                </div>
				            </a>
				        </div>

                <?php } ?>

				</article>
			</div>

<?php
        }
    }