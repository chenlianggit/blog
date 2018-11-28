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
  	@Date:   2017-09-03 15:32:24
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 14:07:48

*/

$slide_below_card_num = cs_get_option('slide_below_card_num');

$args = array(
	'post_type'           => 'post',
	'showposts'           => $slide_below_card_num,
	'meta_key'            => 'post_extend',
	'meta_value'          => '"push_slide_below";b:1;',
	'meta_compare'        => 'LIKE',
	'ignore_sticky_posts' => 1
);
$slide_below_card_data = new WP_Query( $args );

if ( $slide_below_card_data->have_posts() ) {
	while ( $slide_below_card_data->have_posts() ) {
		$slide_below_card_data->the_post();
		$category = get_the_category( get_the_ID() );
		$meta_data = get_post_meta( get_the_ID(), 'post_extend', true );
		$meta_data = wp_parse_args( (array) $meta_data, array( 
				'push_slide_below_img' => '',
			) 
		);
		$src = $meta_data['push_slide_below_img'] ? $meta_data['push_slide_below_img'] : post_thumbnail_src();
?>

<div class="item" style="background-image:url(<?php echo timthumb( $src, array( 'w' => '850', 'h' => '600' ) ) ?>)"> 
    <div class="content">
        <span class="categories"><?php echo $category[0]->cat_name; ?></span>
        <h2 class="title"><?php the_title(); ?></h2>
    </div>
    <a class="permalink" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
</div>
<?php 
	}
	wp_reset_postdata();
}