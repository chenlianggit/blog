<?php
/*
联系我们小工具
*/

class SlongContact extends WP_Widget {

/*  构造函数
/* ------------------------------------ */
	function __construct() {
		parent::__construct( false, __('Salong-联系我们','salong'), array('description' => __('联系我们小工具','salong'), 'classname' => 'widget_salong_contact') );;	
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

	<ul>
		<?php if($instance["contact_man"]) { ?>
		<li>
            <i class="icon-user"><?php echo esc_attr($instance["contact_man"]); ?></i>
		</li>
		<?php } ?>
		<?php if($instance["contact_address"]) { ?>
		<li>
            <i class="icon-location"><?php echo esc_attr($instance["contact_address"]); ?></i>
		</li>
		<?php } ?>
		<?php if($instance["contact_mobile"]) { ?>
		<li>
            <i class="icon-mobile"><?php echo esc_attr($instance["contact_mobile"]); ?></i>
		</li>
		<?php } ?>
		<?php if($instance["contact_tel"]) { ?>
		<li>
            <i class="icon-phone"><?php echo esc_attr($instance["contact_tel"]); ?></i>
		</li>
		<?php } ?>
		<?php if($instance["contact_qq"]) { ?>
		<li>
            <i class="icon-qq"><?php echo esc_attr($instance["contact_qq"]); ?></i>
		</li>
		<?php } ?>
		<?php if($instance["contact_weixin"]) { ?>
		<li>
            <i class="icon-wechat"><?php echo esc_attr($instance["contact_weixin"]); ?></i>
		</li>
		<?php } ?>
		<?php if($instance["contact_email"]) { ?>
		<li>
            <i class="icon-mail-alt"><?php echo esc_attr($instance["contact_email"]); ?></i>
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
		$instance                     = $old;
		$instance['title']            = strip_tags($new['title']);
		$instance['contact_man']      = strip_tags($new['contact_man']);
		$instance['contact_address']  = strip_tags($new['contact_address']);
		$instance['contact_mobile']   = strip_tags($new['contact_mobile']);
		$instance['contact_tel']      = strip_tags($new['contact_tel']);
		$instance['contact_qq']       = strip_tags($new['contact_qq']);
		$instance['contact_weixin']   = strip_tags($new['contact_weixin']);
		$instance['contact_email']    = strip_tags($new['contact_email']);
		return $instance;
	}

/*  小工具表单
/* ------------------------------------ */
	public function form($instance) {
		// 默认设置
		$defaults = array(
			'title'          => __('联系我们','salong'),
			'contact_man'    => __('萨龙龙','salong'),
			'contact_address'=> __('云南省大理州大理市大理镇龙凤村(环海西路旁)','salong'),
			'contact_mobile' => '15911225507',
			'contact_tel'    => '0571-2691375',
			'contact_qq'     => '66895271',
			'contact_weixin' => 'salonglong',
			'contact_email'  => 'admin@salongweb.com',
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
			<label for="<?php echo $this->get_field_id('contact_man'); ?>"><?php _e('联系人：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_man'); ?>" name="<?php echo $this->get_field_name('contact_man'); ?>" type="text" value="<?php echo esc_attr($instance["contact_man"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_address'); ?>"><?php _e('地址：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_address'); ?>" name="<?php echo $this->get_field_name('contact_address'); ?>" type="text" value="<?php echo esc_attr($instance["contact_address"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_mobile'); ?>"><?php _e('手机：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_mobile'); ?>" name="<?php echo $this->get_field_name('contact_mobile'); ?>" type="text" value="<?php echo esc_attr($instance["contact_mobile"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_tel'); ?>"><?php _e('电话：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_tel'); ?>" name="<?php echo $this->get_field_name('contact_tel'); ?>" type="text" value="<?php echo esc_attr($instance["contact_tel"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_qq'); ?>"><?php _e('QQ：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_qq'); ?>" name="<?php echo $this->get_field_name('contact_qq'); ?>" type="text" value="<?php echo esc_attr($instance["contact_qq"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_weixin'); ?>"><?php _e('微信：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_weixin'); ?>" name="<?php echo $this->get_field_name('contact_weixin'); ?>" type="text" value="<?php echo esc_attr($instance["contact_weixin"]); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('contact_email'); ?>"><?php _e('Email：','salong'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('contact_email'); ?>" name="<?php echo $this->get_field_name('contact_email'); ?>" type="text" value="<?php echo esc_attr($instance["contact_email"]); ?>" />
		</p>
<?php

}

}

/*  注册小工具
/* ------------------------------------ */
if ( ! function_exists( 'salong_register_widget_Contact' ) ) {

	function salong_register_widget_Contact() { 
		register_widget( 'SlongContact' );
	}
	
}
add_action( 'widgets_init', 'salong_register_widget_Contact' );
