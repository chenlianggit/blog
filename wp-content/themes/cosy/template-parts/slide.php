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
  	@Date:   2017-09-02 17:05:40
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-10-14 19:27:59

*/

// 轮播区内容处理

$slide_num = cs_get_option('slide_num');

$priority = cs_get_option('priority');

$set_data = cs_get_option('slide_group');

$push_num = $slide_num - count($set_data);

if( $push_num  >= 1 ){

	$args = array(
		'post_type'           => 'post',
		'showposts'           => $push_num,
		'meta_key'            => 'post_extend',
		'meta_value'          => '"push_slide";b:1;',
		'meta_compare'        => 'LIKE',
		'ignore_sticky_posts' => 1
	);
	$push_data = new WP_Query( $args );

	$push_data_format = array();

	if ( $push_data->have_posts() ) {
		while ( $push_data->have_posts() ) {
			$push_data->the_post();

			$category = get_the_category( get_the_ID() );
			$meta_data = get_post_meta( get_the_ID(), 'post_extend', true );
			$meta_data = wp_parse_args( (array) $meta_data, array( 
					'push_slide_img' => '',
				) 
			);
			$push_data_format[] = array(
				'slide_group_title' => get_the_title(),
				'slide_group_cat' => $category[0]->cat_name,
				'slide_group_link' => get_the_permalink(),
				'slide_group_img' => $meta_data['push_slide_img'] ? $meta_data['push_slide_img'] : post_thumbnail_src(),
			);
		}
		wp_reset_postdata();
	}

}

if( $priority ) {
	if( is_array( $set_data ) && is_array( $push_data_format ) ){
		$show_data = array_merge( $set_data, $push_data_format );
	}else if( is_array( $set_data ) ){
		$show_data = $set_data;
	}else if( is_array( $push_data_format ) ){
		$show_data = $push_data_format;
	}else{
		$show_data = null;
	}	
}else{
	if( is_array( $set_data ) && is_array( $push_data_format ) ){
		$show_data = array_merge( $push_data_format, $set_data );
	}else if( is_array( $set_data ) ){
		$show_data = $set_data;
	}else if( isset( $push_data_format ) && is_array( $push_data_format ) ){
		$show_data = $push_data_format;
	}else{
		$show_data = null;
	}

}

if( $show_data ){
	foreach ($show_data as $key => $value) :

		if( is_numeric( $value['slide_group_img'] ) ) {
			$src = wp_get_attachment_image_src( $value['slide_group_img'], 'full' );
			$src = $src[0];
		} else {
			$src = $value['slide_group_img'];
		} 

	?>
	
	    <div class="item" style="background-image:url(<?php echo $src; ?>)"> 
	        <div class="content">
	            <span class="categories"><?php echo $value['slide_group_cat']; ?></span>
	            <h2 class="title"><?php echo $value['slide_group_title']; ?></h2>
	            
	        </div>
	        <a class="permalink" href="<?php echo $value['slide_group_link']; ?>" title="<?php echo $value['slide_group_title']; ?>"></a>
	    </div>
	<?php endforeach; ?>
<?php } ?>  