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
  	@Date:   2017-09-20 10:01:41
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-10-05 19:30:42

*/


// 轮播区内容处理

$slide_num = 5;

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
				'slide_group_id' => get_the_ID(),
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
	}else if( is_array( $push_data_format ) ){
		$show_data = $push_data_format;
	}else{
		$show_data = null;
	}

}

?>
<div class="row rw0">
<?php
if( $show_data ){
	$i = 1;
	foreach ($show_data as $key => $value) :

		if( is_numeric( $value['slide_group_img'] ) ) {
			$src = wp_get_attachment_image_src( $value['slide_group_img'], 'full' );
			$src = $src[0];
		} else {
			$src = $value['slide_group_img'];
		}

		if( $i == 1 ){ 
?>
	<div class="item item-left col-xs-12 col-sm-6 col-md-6 pd0">
		<div class="content">
			<div class="image" style="background-image: url(<?php echo $src; ?>);">
			</div>
			
			<div class="title">
				<h2><?php echo $value['slide_group_title']; ?></h2>
				<div class="date hidden-xs">                 
				    <span class="u-categories"><?php echo $value['slide_group_cat']; ?></span>
				    <?php if( isset( $value['slide_group_id'] ) ){ ?>
				    <span class="u-time"><?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s',$value['slide_group_id'])) ); ?></span>
				    <span class="u-comment"><i class="icon icon-bubble"></i> 0</span>
				    <span class="u-like"><i class="icon icon-heart"></i> 58</span>
				    <?php } ?>
				</div>
			</div>
		</div>
		<a href="<?php echo $value['slide_group_link']; ?>" class="permalink"></a>
	</div>
	<?php }else{ ?>
	<div class="item item-right col-xs-6 col-sm-3 col-md-3 pd0">
		<div class="content">
			<div class="image" style="background-image: url(<?php echo $src; ?>);">
			</div>
			
			<div class="title">
				<h2><?php echo $value['slide_group_title']; ?></h2>
				<div class="date hidden-xs hidden-sm">                 
				    <span class="u-categories"><?php echo $value['slide_group_cat']; ?></span>
				    <?php if( isset( $value['slide_group_id'] ) ){ ?>
				    <span class="u-time"> <?php echo timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s',$value['slide_group_id'])) ); ?></span>
				    <span class="u-like"><i class="icon icon-heart"></i> <?php if( get_post_meta($value['slide_group_id'],'suxing_ding',true) ){ echo get_post_meta($value['slide_group_id'],'suxing_ding',true); } else {echo '0';}?></span>
				    <?php } ?>
				</div>
			</div>
		</div>
		<a href="<?php echo $value['slide_group_link']; ?>" class="permalink"></a>
	</div>
	<?php } ?>
	<?php $i++; endforeach; ?>
<?php } ?>  
</div>