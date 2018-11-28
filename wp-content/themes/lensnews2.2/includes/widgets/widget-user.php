<?php
/*
推荐作者小工具
*/

class SlongUser extends WP_Widget {

/*  构造函数
/* ------------------------------------ */
	function __construct() {
		parent::__construct( false, __('Salong-推荐作者','salong'), array('description' => __('推荐作者小工具，请到主题选项中设置选择。','salong'), 'classname' => 'widget_salong_user') );;	
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
<?php global $salong; if($salong[ 'users']){ $users=implode( ',',$salong[ 'users']); } $blog_id = get_current_blog_id(); ?>
<ul>
   <?php $blogusers=get_users( 'blog_id='.$blog_id.'&orderby=post_count&order&DESC&include='.$users.'');foreach ($blogusers as $user) { ?>
    <?php global $wp_query;$user_name = $user->display_name;$user_description = $user->user_description;$user_id=$user->ID; ?>
    <li>
        <a href="<?php echo get_author_posts_url($user_id); ?>" title="<?php echo $user_name; ?><?php if($user_description){ echo '｜';}?><?php echo $user_description; ?>" class="author_name"<?php echo new_open_link(); ?>>
            <!--头像-->
            <?php echo salong_get_avatar($user_id,$user_name); ?>
            <!--名称-->
            <?php echo $user_name; ?></a>
        <!--文章-->
        <?php $args=array('author' => $user_id,'post_type' => array('post','gallery','video'),'post_status' => 'publish','posts_per_page' => 1,'ignore_sticky_posts' => 1);$my_query = null;$my_query = new WP_Query($args);if( $my_query->have_posts() ) {while ($my_query->have_posts()) : $my_query->the_post(); ?><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="new_post"><?php the_title(); ?></a><?php endwhile;}wp_reset_query(); ?>
    </li>
    <?php } ?>
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
		return $instance;
	}

/*  小工具表单
/* ------------------------------------ */
	public function form($instance) {
		// 默认设置
		$defaults = array(
			'title' 			=> __('推荐作者','salong'),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('标题：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
		</p>

<?php

}

}

/*  注册小工具
/* ------------------------------------ */
if ( ! function_exists( 'salong_register_widget_user' ) ) {

	function salong_register_widget_user() { 
		register_widget( 'SlongUser' );
	}
	
}
add_action( 'widgets_init', 'salong_register_widget_user' );
