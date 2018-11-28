<?php
/*
关于本站小工具
*/

class SlongAbout extends WP_Widget {

/*  构造函数
/* ------------------------------------ */
	function __construct() {
		parent::__construct( false, __('Salong-关于本站','salong'), array('description' => __('关于本站小工具','salong'), 'classname' => 'widget_salong_about') );;	
	}
	
/*  小工具
/* ------------------------------------ */
	public function widget($args, $instance) {
		extract( $args );
		$instance['title']?NULL:$instance['title']='';
		$title = apply_filters('widget_title',$instance['title']);
		$output = $before_widget."\n";
		if($title)
			$output .= $before_title.$title.$after_title;
		ob_start();
	
?>
<section class="about">
    <img src="<?php echo $instance['about_img']; ?>" alt="<?php echo $instance['about_title']; ?>">
    <h3><?php echo $instance['about_title']; ?></h3>
    <span><?php echo $instance['about_desc']; ?></span>
    <div class="excerpt"><?php echo $instance['about_info']; ?></div>
    <?php global $salong;
        $post_count     = wp_count_posts('post')->publish;
        $gallery_count  = wp_count_posts('gallery')->publish;
        $video_count    = wp_count_posts('video')->publish;
        $product_count  = wp_count_posts('product')->publish;
        if($instance[ 'about_statistics']) { //显示统计 ?>
    <ul class="layout_ul">
        <li class="layout_li"><a href="<?php $blog_link = $salong['blog_link']; ?><?php echo get_page_link($blog_link); ?>" title="<?php _e('查看更多文章','salong'); ?>"><span><?php _e('文章','salong'); ?></span><b><?php if($post_count > 0){ echo $post_count; }else{ echo '0'; } ?></b></a></li>
        <li class="layout_li"><a href="<?php $gallery_link = $salong['gallery_link']; ?><?php echo get_page_link($gallery_link); ?>" title="<?php _e('查看更多画廊','salong'); ?>"><span><?php _e('画廊','salong'); ?></span><b><?php if($gallery_count > 0){ echo $gallery_count; }else{ echo '0'; } ?></b></a></li>
        <li class="layout_li"><a href="<?php $video_link = $salong['video_link']; ?><?php echo get_page_link($video_link); ?>" title="<?php _e('查看更多视频','salong'); ?>"><span><?php _e('视频','salong'); ?></span><b><?php if($video_count > 0){ echo $video_count; }else{ echo '0'; } ?></b></a></li>
        <li class="layout_li"><a href="<?php $product_link = $salong['product_link']; ?><?php echo get_page_link($product_link); ?>" title="<?php _e('查看更多产品','salong'); ?>"><span><?php _e('产品','salong'); ?></span><b><?php if($product_count > 0){ echo $product_count; }else{ echo '0'; } ?></b></a></li>
    </ul>
    <?php } ?>
</section>



<?php
		$output .= ob_get_clean();
		$output .= $after_widget."\n";
		echo $output;
	}
	
/*  更新小工具
/* ------------------------------------ */
	public function update($new,$old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
		$instance['about_img'] = esc_url($new['about_img']);
		$instance['about_title'] = strip_tags($new['about_title']);
		$instance['about_desc'] = strip_tags($new['about_desc']);
		$instance['about_info'] = $new['about_info'];
		$instance['about_statistics'] = $new['about_statistics']?1:0;
		return $instance;
	}

/*  小工具表单
/* ------------------------------------ */
	public function form($instance) {
		// 默认设置
		$defaults = array(
			'title' 			=> __('关于本站','salong'),
			'about_img' 		=> get_template_directory_uri(). '/images/about_img.jpg',
			'about_title' 			=> __('萨龙网络','salong'),
			'about_desc' 			=> __('专注高端网站设计与开发！','salong'),
			'about_info' 			=> __('<p>萨龙网络始建于2012年8月，是一家新生的优秀互联网综合服务提供商。</p><p>公司坐落于美丽的大理洱海之滨，专注于高端网站建设、电子商务网站建设、客栈房间预订系统网站建设、移动互联应用、WordPress主题模板、服务器运维与网站托管，为企业客户的互联网应用提供一站式服务。</p>','salong'),
			'about_statistics'	=> 1,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<style>
	.widget .widget-inside .postform { width: 100%; }
	</style>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('小工具标题：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id("about_img"); ?>"><?php _e('图片：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id("about_img"); ?>" name="<?php echo $this->get_field_name("about_img"); ?>" type="text" value="<?php echo esc_url($instance["about_img"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id("about_title"); ?>"><?php _e('标题：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id("about_title"); ?>" name="<?php echo $this->get_field_name("about_title"); ?>" type="text" value="<?php echo $instance["about_title"]; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id("about_desc"); ?>"><?php _e('描述：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id("about_desc"); ?>" name="<?php echo $this->get_field_name("about_desc"); ?>" type="text" value="<?php echo $instance["about_desc"]; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id("about_info"); ?>"><?php _e('说明：','salong'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('about_info'); ?>" name="<?php echo $this->get_field_name('about_info'); ?>"><?php echo $instance["about_info"]; ?></textarea>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('about_statistics'); ?>" name="<?php echo $this->get_field_name('about_statistics'); ?>" <?php checked( (bool) $instance["about_statistics"], true ); ?>>
			<label for="<?php echo $this->get_field_id('about_statistics'); ?>"><?php _e('显示统计','salong'); ?></label>
		</p>

<?php

}

}

/*  注册小工具
/* ------------------------------------ */
if ( ! function_exists( 'salong_register_widget_about' ) ) {

	function salong_register_widget_about() { 
		register_widget( 'SlongAbout' );
	}
	
}
add_action( 'widgets_init', 'salong_register_widget_about' );
