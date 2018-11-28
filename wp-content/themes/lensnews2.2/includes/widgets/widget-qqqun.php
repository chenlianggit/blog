<?php
/*
QQ交流群小工具
*/

class SlongQQqun extends WP_Widget {

/*  构造函数
/* ------------------------------------ */
	function __construct() {
		parent::__construct( false, __('Salong-QQ交流群','salong'), array('description' => __('QQ交流群小工具','salong'), 'classname' => 'widget_salong_qqqun') );;	
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
<div class="qqqun">
    <p><?php echo esc_attr($instance["qqqun_text"]); ?></p>
    <?php if($instance[ 'qqqun_id']) { ?>
    <a class="group" target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=<?php echo esc_attr($instance["qqqun_id"]); ?>"><img border="0" src="<?php echo get_template_directory_uri(); ?>/images/group.png" alt="<?php echo esc_attr($instance["qqqun_name"]); ?>" title="<?php echo esc_attr($instance["qqqun_name"]); ?>"></a>
    <?php } if($instance[ 'qq_number']) { ?>
    <a class="qq" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo esc_attr($instance["qq_number"]); ?>&site=qq&menu=yes"><img border="0" src="<?php echo get_template_directory_uri(); ?>/images/pa.jpg" alt="<?php echo esc_attr($instance["qq_name"]); ?>" title="<?php echo esc_attr($instance["qq_name"]); ?>"/></a>
    <?php } ?>
</div>


<?php
		$output .= ob_get_clean();
		$output .= $after_widget."\n";
		echo $output;
	}
	
/*  更新小工具
/* ------------------------------------ */
	public function update($new,$old) {
		$instance                       = $old;
		$instance['title']              = strip_tags($new['title']);
		$instance['qqqun_text']         = strip_tags($new['qqqun_text']);
		$instance['qqqun_id']           = strip_tags($new['qqqun_id']);
		$instance['qqqun_name']         = strip_tags($new['qqqun_name']);
		$instance['qq_number']          = strip_tags($new['qq_number']);
		$instance['qq_name']            = strip_tags($new['qq_name']);
		return $instance;
	}

/*  小工具表单
/* ------------------------------------ */
	public function form($instance) {
		// 默认设置
		$defaults = array(
			'title'            => __('QQ交流群','salong'),
			'qqqun_text'       => __('<a href="https://salongweb.com">萨龙网络</a>官方交流群：542902899，欢迎大家加入！','salong'),
			'qqqun_id'         => 'fb10ec904051df7fd78e5e5a88abde6717477d71c403e5a982540dfd27cf4c2c',
			'qqqun_name'       => __('萨龙网络官方交流群','salong'),
			'qq_number'        => '66895271',
			'qq_name'          => __('即刻QQ联系我们','salong'),
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
			<label for="<?php echo $this->get_field_id('qqqun_text'); ?>"><?php _e('内容：','salong'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('qqqun_text'); ?>" name="<?php echo $this->get_field_name('qqqun_text'); ?>"><?php echo $instance["qqqun_text"]; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('qqqun_id'); ?>"><?php _e('QQ群ID：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('qqqun_id'); ?>" name="<?php echo $this->get_field_name('qqqun_id'); ?>" type="text" value="<?php echo esc_attr($instance["qqqun_id"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('qqqun_name'); ?>"><?php _e('QQ群名称：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('qqqun_name'); ?>" name="<?php echo $this->get_field_name('qqqun_name'); ?>" type="text" value="<?php echo esc_attr($instance["qqqun_name"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('qq_number'); ?>"><?php _e('QQ号码：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('qq_number'); ?>" name="<?php echo $this->get_field_name('qq_number'); ?>" type="text" value="<?php echo esc_attr($instance["qq_number"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('qq_name'); ?>"><?php _e('QQ号码名称：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('qq_name'); ?>" name="<?php echo $this->get_field_name('qq_name'); ?>" type="text" value="<?php echo esc_attr($instance["qq_name"]); ?>" />
		</p>
<?php

}

}

/*  注册小工具
/* ------------------------------------ */
if ( ! function_exists( 'salong_register_widget_QQqun' ) ) {

	function salong_register_widget_QQqun() { 
		register_widget( 'SlongQQqun' );
	}
	
}
add_action( 'widgets_init', 'salong_register_widget_QQqun' );
