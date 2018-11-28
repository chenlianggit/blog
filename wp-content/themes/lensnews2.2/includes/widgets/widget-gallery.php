<?php
/*
聚合画廊小工具
*/

class SlongGallery extends WP_Widget {

/*  构造函数
/* ------------------------------------ */
	function __construct() {
		parent::__construct( false, __('Salong-画廊聚合','salong'), array('description' => __('画廊聚合小工具','salong'), 'classname' => 'widget_salong_gallery') );;	
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
        if($instance['posts_orderby'] == 'votes_count') { $meta_key = 'votes_count'; $orderby = 'meta_value_num'; } else { $meta_key = ''; $orderby = $instance['posts_orderby'];}
        if($instance['posts_cat_id'] == 0) {
		$posts = new WP_Query( array(
			'showposts'				=> $instance['posts_num'],
			'cat'					=> $instance['posts_cat_id'],
			'ignore_sticky_posts'	=> true,
            'post_type'             => 'gallery',
            'meta_key'              => $meta_key,
			'orderby'				=> $orderby,
			'order'					=> 'desc',
			'date_query' => array(
				array(
					'after' => $instance['posts_time'],
				),
			),
		) );
        } else {
		$posts = new WP_Query( array(
			'showposts'				=> $instance['posts_num'],
			'ignore_sticky_posts'	=> true,
            'post_type'             => 'gallery',
            'meta_key'              => $meta_key,
			'orderby'				=> $orderby,
			'order'					=> 'desc',
            'tax_query'             => array(
                array(
                    'taxonomy' => 'gallery-cat',
                    'field'    => 'id',
                    'terms'    => $instance['posts_cat_id'],
                )
            ),
			'date_query' => array(
				array(
					'after' => $instance['posts_time'],
				),
			),
		) );
        }
	?>
	<ul class="layout_ul">
		<?php if ( $posts->have_posts() ) : while ( $posts->have_posts() ) : $posts->the_post();
        global $post,$salong;
        $commentcount = get_comments_number();//评论数量
        if(get_post_meta($post->ID, "votes_count", true)){
            $votes_count0 = get_post_custom_values( "votes_count");//点赞数量
            $votes_count = $votes_count0[0];
        }else{
            $votes_count = '0';
        }
        ?>
		<li class="layout_li">
			<figure><a href="<?php the_permalink() ?>" title="<?php the_title(); ?><?php if($instance['posts_orderby'] == 'comment_count') { echo '&nbsp;'; printf( _n( '有(1)条评论', '有(%s)条评论', $commentcount, 'salong' ), $commentcount ); } else { echo '&nbsp;'; printf( __( '有(%s)人点赞', 'salong' ), $votes_count ); } ?>"<?php echo new_open_link(); ?>><span class="title"><?php the_title(); ?></span><?php post_thumbnail(); ?>
                <!--点赞-->
                <?php if($instance['posts_orderby'] == 'comment_count') { ?>
                <span class="comment"><i class="icon-comment"></i><?php echo get_post($post->ID)->comment_count;?></span>
                <?php } else { ?>
                <?php echo getPostLikeLinkList(get_the_ID());?>
                <?php } ?>
			</a></figure>
		</li>
		<?php endwhile; endif; ?>
		<?php wp_reset_query(); ?>
	</ul>

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
			'title' 			=> __('画廊聚合','salong'),
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
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("posts_cat_id"), 'taxonomy' => 'gallery-cat', 'selected' => $instance["posts_cat_id"], 'show_option_all' => __('全部','salong'), 'show_count' => true ) ); ?>
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo $this->get_field_id("posts_orderby"); ?>"><?php _e('排序：','salong'); ?></label>
			<select style="width: 100%;" id="<?php echo $this->get_field_id("posts_orderby"); ?>" name="<?php echo $this->get_field_name("posts_orderby"); ?>">
			  <option value="date"<?php selected( $instance["posts_orderby"], "date" ); ?>><?php _e('日期','salong'); ?></option>
			  <option value="title"<?php selected( $instance["posts_orderby"], "title" ); ?>><?php _e('标题','salong'); ?></option>
			  <option value="comment_count"<?php selected( $instance["posts_orderby"], "comment_count" ); ?>><?php _e('热评','salong'); ?></option>
			  <option value="votes_count"<?php selected( $instance["posts_orderby"], "votes_count" ); ?>><?php _e('点赞','salong'); ?></option>
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
if ( ! function_exists( 'salong_register_widget_Gallery' ) ) {

	function salong_register_widget_Gallery() { 
		register_widget( 'SlongGallery' );
	}
	
}
add_action( 'widgets_init', 'salong_register_widget_Gallery' );
