<?php
/*
Template Name: 专题汇总页
*/
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
  	@Date:   2017-09-05 20:44:14
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-10-08 19:21:56

*/
get_header();

while( have_posts() ) : the_post();

$page_extend = get_post_meta(get_the_ID(),'page_extend',true);

$page_extend = wp_parse_args( (array) $page_extend, array( 
		'page_extend' => array(),
		'topic_layout' => 'center'
	) 
);
$topic_ids = $page_extend['topic_ids_group'] ? array_slice($page_extend['topic_ids_group'],0,4) : '';


?>
<section class="l-sticky-topics">
	<?php if( $page_extend['topic_layout'] == 'center' ){ ?>
	<div class="container">
	<?php }else{ ?>
    <div class="container-fluid pd10">
    <?php } ?>
        <div class="row rw10">
            <?php
                $exclude = array();
                if( !empty($topic_ids) )
                foreach ($topic_ids as $key => $value) {
                    $exclude[] = $value['tag_id'];
                    $term = get_term( $value['tag_id'], 'special' );
                    $topic_meta = get_term_meta( $term->term_id ,'_custom_special_options', true);
                    if( empty($topic_meta['special_thum']) ){
                    	$topic_pic = '';
                    }else{
                    	$topic_pic = wp_get_attachment_image_src($topic_meta['special_thum'],'full');
                	}

            ?>

                <div class="col-xs-12 col-sm-3 col-md-3 pd10">
                    <div class="item">
                        <a href="<?php echo get_term_link( $term->term_id ); ?>"  target="_blank" title="<?php echo $term->name; ?>">
                            <div class="image" style="background-image: url(<?php echo $topic_pic[0]; ?>);">
                                <div class="overlay"></div>
                                <div class="content">
                                    <h2 class="title"><?php echo $term->name; ?></h2>
                                    <span class="meta">
                                        <?php echo $term->count; ?>篇文章
                                    </span>
                                </div>
                                <div class="dec">
                                    <p>
                                    <?php echo $term->description; ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</section>
<section class="nt-warp nt-warp-full">
    <div class="container">
        <div class="introduction">
            <h5>
            <i class="icon icon-layers"></i> 全部专题</h5>
        </div>
        <main class="l-main">
            <div class="topics row">
                
                <?php

                    $terms = get_terms( array( 
                        'taxonomy'   => 'special',
                        'hide_empty' => false,
                        'exclude'    => $exclude,
                        'orderby'    => 'ID',
                        'order'      => 'DESC'
                    ) );
                    foreach ($terms as $key => $value) {
                        $topic_meta = get_term_meta( $value->term_id ,'_custom_special_options', true);
                        if( empty($topic_meta['special_thum']) ){
	                    	$topic_pic = '';
	                    }else{
	                    	$topic_pic = wp_get_attachment_image_src($topic_meta['special_thum'],'full');
	                	}
                ?>


                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <article>
                                <a href="<?php echo get_term_link( $value->term_id ); ?>">
                                    <div class="image" style="background-image: url(<?php echo $topic_pic ? $topic_pic[0] : get_stylesheet_directory_uri().'/static/images/default.jpg'; ?>);">
                                        <div class="overlay"></div>
                                        <div class="title">
                                            <h2><?php echo $value->name; ?></h2>
                                            <span class="meta">
                                                <?php echo $value->count; ?>篇文章
                                            </span>
                                        </div>
                                        
                                    </div>
                                    <div class="dec">
                                        <p>
                                        <?php echo $value->description; ?>
                                        </p>
                                    </div>
                                </a>
                            </article>
                        </div>

                <?php } ?>

            </div>

        </main>
    </div>
</section>

<?php
endwhile;
get_footer();
