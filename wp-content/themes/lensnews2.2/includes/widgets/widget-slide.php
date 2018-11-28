<?php
/*
文章幻灯片小工具
*/

class SlongSlide extends WP_Widget {

/*  构造函数
/* ------------------------------------ */
	function __construct() {
		parent::__construct( false, __('Salong-文章幻灯片','salong'), array('description' => __('文章幻灯片小工具','salong'), 'classname' => 'widget_salong_slide') );;	
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

	<?php
        global $post,$salong;
        if($instance['posts_orderby'] == 'meta_value_num') { $votes_count = 'votes_count'; } else { $votes_count = '';}
		$posts = new WP_Query( array(
			'showposts'				=> $instance['posts_num'],
			'cat'					=> $instance['posts_cat_id'],
			'ignore_sticky_posts'	=> true,
            'meta_key'              => $votes_count,
			'orderby'				=> $instance['posts_orderby'],
			'order'					=> 'desc',
			'date_query' => array(
				array(
					'after' => $instance['posts_time'],
				),
			),
		) );
	?>
<div class="swiper-container swiper-slidepost">
    <div class="swiper-wrapper">
        <?php if ( $posts->have_posts() ) : while ( $posts->have_posts() ) : $posts->the_post(); ?>
        <article class="swiper-slide">
            <figure>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                    <?php no_post_thumbnail(); ?>
                </a>
            </figure>
            <section class="slidepost_main">
                <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a></h2>
                <?php get_template_part( 'content/home', 'info'); ?>
                <!-- 摘要 -->
                <div class="excerpt">
                    <?php if (has_excerpt()) { ?>
                    <?php echo wp_trim_words(get_the_excerpt(),52); ?>
                    <?php } else{ echo wp_trim_words(get_the_content(),52); } ?>
                </div>
                <!-- 摘要end -->
            </section>
        </article>
		<?php endwhile; endif; ?>
		<?php wp_reset_query(); ?>
    </div>
    <section class="slidepost_btn">
    <!-- 导航 -->
    <div class="swiper-pagination swiper-slidepost-pagination"></div>
    <!-- 按钮 -->
    <div class="swiper-button swiper-slidepost-button-next swiper-button-next icon-right-circled"></div>
    <div class="swiper-button swiper-slidepost-button-prev swiper-button-prev icon-left-circled"></div>
    </section>
</div>
    

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
		$instance['posts_num'] = strip_tags($new['posts_num']);
		$instance['posts_cat_id'] = strip_tags($new['posts_cat_id']);
		$instance['posts_orderby'] = strip_tags($new['posts_orderby']);
		$instance['posts_time'] = strip_tags($new['posts_time']);
		return $instance;
	}

/*  小工具表单
/* ------------------------------------ */
	public function form($instance) {
		// 默认设置
		$defaults = array(
			'title' 			=> __('文章幻灯片','salong'),
			'posts_num' 		=> '4',
			'posts_cat_id' 		=> '0',
			'posts_orderby' 	=> 'date',
			'posts_time' 		=> '0',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<style>
	.widget .widget-inside .postform { width: 100%; }
	</style>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
		</p>

		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_num"); ?>"><?php _e('文章数量：','salong'); ?></label>
			<input style="width:100%;" id="<?php echo $this->get_field_id("posts_num"); ?>" name="<?php echo $this->get_field_name("posts_num"); ?>" type="number" value="<?php echo absint($instance["posts_num"]); ?>" size='3' />
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_cat_id"); ?>"><?php _e('分类：','salong'); ?></label>
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("posts_cat_id"), 'selected' => $instance["posts_cat_id"], 'show_option_all' => __('全部','salong'), 'show_count' => true ) ); ?>
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_orderby"); ?>"><?php _e('排序：','salong'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_orderby"); ?>" name="<?php echo $this->get_field_name("posts_orderby"); ?>">
			  <option value="date"<?php selected( $instance["posts_orderby"], "date" ); ?>><?php _e('日期','salong'); ?></option>
			  <option value="title"<?php selected( $instance["posts_orderby"], "title" ); ?>><?php _e('标题','salong'); ?></option>
			  <option value="comment_count"<?php selected( $instance["posts_orderby"], "comment_count" ); ?>><?php _e('热门','salong'); ?></option>
			  <option value="meta_value_num"<?php selected( $instance["posts_orderby"], "meta_value_num" ); ?>><?php _e('点赞','salong'); ?></option>
			  <option value="rand"<?php selected( $instance["posts_orderby"], "rand" ); ?>><?php _e('随机','salong'); ?></option>
			</select>	
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_time"); ?>"><?php _e('时间：','salong'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_time"); ?>" name="<?php echo $this->get_field_name("posts_time"); ?>">
			  <option value="0"<?php selected( $instance["posts_time"], "0" ); ?>><?php _e('全部','salong'); ?></option>
			  <option value="1 year ago"<?php selected( $instance["posts_time"], "1 year ago" ); ?>><?php _e('一年','salong'); ?></option>
			  <option value="1 month ago"<?php selected( $instance["posts_time"], "1 month ago" ); ?>><?php _e('一月','salong'); ?></option>
			  <option value="1 week ago"<?php selected( $instance["posts_time"], "1 week ago" ); ?>><?php _e('一周','salong'); ?></option>
			  <option value="1 day ago"<?php selected( $instance["posts_time"], "1 day ago" ); ?>><?php _e('一天','salong'); ?></option>
			</select>	
		</p>

<?php

}

}

/*  注册小工具
/* ------------------------------------ */
if ( ! function_exists( 'salong_register_widget_Slide' ) ) {

	function salong_register_widget_Slide() { 
		register_widget( 'SlongSlide' );
	}
	
}
add_action( 'widgets_init', 'salong_register_widget_Slide' );
