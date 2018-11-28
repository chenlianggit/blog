<?php     
/*
Plugin Name: 自定义微信分享
Plugin URI: https://www.qwqoffice.com/article-20.html
Description: 自定义微信分享和QQ分享链接中的信息，包括标题、描述、小图标和分享链接
Version: 1.5.7
Author: QwqOffice
Author URI: https://www.qwqoffice.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wx-custom-share
Domain Path: /languages
*/

//禁止直接访问
if ( ! defined( 'ABSPATH' ) ) exit;

class WX_Custom_Share{
	
	function __construct(){
		
		$settings = get_option('ws_settings');
		
		add_action( 'admin_notices',									array( $this, 'api_config_notice' ) );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__),	array( $this, 'add_action_links' ) );
		add_filter( 'plugin_row_meta',									array( $this, 'add_plugin_row_meta' ), 10, 2 );
		if( is_admin() ) add_action( 'admin_menu',						array( $this, 'setting_menu' ) );
		add_action( 'admin_init',										array( $this, 'settings_init' ) );
		if( is_admin() ) add_action( 'add_meta_boxes',					array( $this, 'add_post_metabox' ) );
		add_action( 'save_post',										array( $this, 'save_post_data' ) );
		add_action( 'wp_footer',										array( $this, 'add_share_js' ), 19 );
		add_action( 'wp_footer',										array( $this, 'add_share_info' ), 21 );
		add_action( 'wp_ajax_wxcs_get_share_info',						array( $this, 'ajax_get_share_info' ) );
		add_action( 'wp_ajax_nopriv_wxcs_get_share_info',				array( $this, 'ajax_get_share_info' ) );
		add_action( 'init',												array( $this, 'load_textdomain' ) );
		add_action( 'wpmu_new_blog',									array( $this, 'new_blog' ), 10, 6 );
	}
	
	/*//获取客户端IP
	add_action( 'wp_ajax_nopriv_wxcs_get_ip', 'wxcs_get_client_ip' );
	function wxcs_get_client_ip() {
		if( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		echo $ip;
		wp_die();
	}*/

	//获取服务器公网IP
	function get_public_ip(){
		
		$api_url = 'http://ip.chinaz.com/getip.aspx';
		//$api_url = admin_url('admin-ajax.php') . '?action=wxcs_get_ip';
		$public_ip = '';
		$response = wp_remote_get( $api_url );
		
		if ( is_array( $response ) && ! is_wp_error( $response ) ) {
			
			$result = str_replace( 'document.write("{ip:\'', '', $response['body'] );
			$arr = explode( '\'', $result );
			$public_ip = $arr[0];
			//$public_ip = $response['body'];
		}
		
		return $public_ip;
	}

	//获取标题
	function get_title( $type, $object_id = null ){
		
		$settings = get_option('ws_settings');
		
		$blog_name = get_bloginfo('name');
		
		//首页
		if( $type == 'home' ){
			$home_title = isset( $settings['ws_home_title'] ) && ! empty( $settings['ws_home_title'] ) ? $settings['ws_home_title'] : false;
			$home_title = $home_title ? $home_title : get_option('blogname');
			return array( 'display' => $home_title );
		}
		else if( $type == 'post' ){
			$post = get_post( $object_id );
			$meta_info = get_post_meta( $object_id, 'ws_info', true );
			
			$meta_title = isset( $meta_info['ws_title'] ) ? $meta_info['ws_title'] : '';
			$post_default_title = $post->post_title .' - '. $blog_name;
			
			$info['display'] = $meta_title != '' ? $meta_title : $post_default_title;
			$info['meta'] = $meta_title;
			$info['default'] = $post_default_title;
			return $info;
		}
		else if( $type == 'other' ){
			
			$info['display'] = '';
			return $info;
		}
	}

	//获取描述
	function get_desc( $type, $object_id = null ){
		
		$settings = get_option('ws_settings');
		
		//首页
		if( $type == 'home' ){
			$home_desc = isset( $settings['ws_home_desc'] ) && ! empty( $settings['ws_home_desc'] ) ? $settings['ws_home_desc'] : false;
			$home_desc = $home_desc ? $home_desc : get_option('blogdescription');
			return array( 'display' => $home_desc );
		}
		else if( $type == 'post' ){
			$post = get_post( $object_id );
			$meta_info = get_post_meta( $object_id, 'ws_info', true );
			
			$meta_desc = isset( $meta_info['ws_desc'] ) ? $meta_info['ws_desc'] : '';
			$post_default_desc = get_permalink($post);
			
			$first_p = false;
			preg_match_all( '#<p>(.+?)</p>#i', apply_filters( 'the_content', $post->post_content ), $matched );
			$min_length = apply_filters( 'wxcs_first_paragraph_min_length', 10 );
			foreach( $matched[1] as $text ){
				if( mb_strlen( $text = wp_strip_all_tags( $text ), 'utf-8' ) >= $min_length ){
					//$first_p = mb_substr( wp_strip_all_tags( $text ), 0, 10, 'utf-8' ) . '...';
					$first_p = $text;
					break;
				}
			}
			
			$info['display'] = $meta_desc != '' ? $meta_desc : ( $first_p ? $first_p : $post_default_desc );
			$info['meta'] = $meta_desc;
			$info['default'] = $first_p ? $first_p : $post_default_desc;
			return $info;
		}
		else if( $type == 'other' ){
			
			$info['display'] = '';
			return $info;
		}
	}

	//获取URL
	function get_url( $type, $object_id = null ){
		
		$settings = get_option('ws_settings');
		
		//首页
		if( $type == 'home' ){
			$home_url = isset( $settings['ws_home_url'] ) && ! empty( $settings['ws_home_url'] ) ? $settings['ws_home_url'] : false;
			$home_url = $home_url ? $home_url : get_option('siteurl');
			return array( 'display' => $home_url );
		}
		else if( $type == 'post' ){
			$post = get_post( $object_id );
			$meta_info = get_post_meta( $object_id, 'ws_info', true );
			
			$meta_url = isset( $meta_info['ws_url'] ) ? $meta_info['ws_url'] : '';
			$post_default_url = get_permalink( $post );
			
			$info['display'] = $meta_url != '' ? $meta_url : $post_default_url;
			$info['meta'] = $meta_url;
			$info['default'] = $post_default_url;
			return $info;
		}
		else if( $type == 'other' ){
			
			$info['display'] = '';
			return $info;
		}
	}

	//获取小图标
	function get_img( $type, $object_id = null ){
		
		$settings = get_option('ws_settings');
		
		$default_img = isset( $settings['ws_default_img'] ) && ! empty( $settings['ws_default_img'] ) ? $settings['ws_default_img'] : false;
		
		//首页
		if( $type == 'home' ){
			$home_img = isset( $settings['ws_home_img'] ) && ! empty( $settings['ws_home_img'] ) ? $settings['ws_home_img'] : false;
			$home_img = $home_img ? $home_img : ( $default_img ? $default_img : '' );
			return array( 'display' => $home_img );
		}
		else if( $type == 'post' ){
			$post = get_post( $object_id );
			$meta_info = get_post_meta( $object_id, 'ws_info', true );
			
			$meta_img = isset( $meta_info['ws_img'] ) ? $meta_info['ws_img'] : '';
			$post_default_img = get_the_post_thumbnail_url($post);
			
			$first_img = false;
			$count = preg_match_all( '#<img.+src=[\'"]([^\'"]+)[\'"].*>#i', apply_filters( 'the_content', $post->post_content ), $matched );
			if( $count > 0 ) $first_img = $matched[1][0];
			
			$info['display'] = $meta_img != '' ? $meta_img : ( $post_default_img ? $post_default_img : ( $first_img ? $first_img : ( $default_img ? $default_img : '' ) ) );
			$info['meta'] = $meta_img;
			$info['default'] = $post_default_img ? $post_default_img : ( $first_img ? $first_img : ( $default_img ? $default_img : '' ) );
			return $info;
		}
		else if( $type == 'other' ){
			
			$info['display'] = $default_img;
			return $info;
		}
	}
	
	//获取是否使用当前URL
	function is_use_actual_url( $type, $object_id = null ){
		
		//首页
		if( $type == 'home' ){
			
			$settings = get_option('ws_settings');
			return isset( $settings['ws_home_use_actual_url'] );
		}
		else if( $type == 'post' ){
			
			$meta_info = get_post_meta( $object_id, 'ws_info', true );
			return isset( $meta_info['ws_use_actual_url'] );
		}
		else if( $type == 'category' ){
			
			$meta_info = get_term_meta( $object_id, 'ws_info', true );
			return isset( $meta_info['ws_use_actual_url'] );
		}
		else if( $type == 'other' ){
			
			return true;
		}
	}

	//是否错误
	function is_api_error( $response ){
		
		if( ! is_wp_error( $response ) ){
			
			if( is_array( $response ) && isset( $response['body'] ) ){
				
				$result = json_decode( $response['body'] );
				return isset( $result->errcode ) && $result->errcode != 0;
			}
			else{
				return false;
			}
		}
		else{
			return true;
		}
	}
	
	//获取错误详情
	function get_api_error( $response ){
		
		return is_wp_error( $response ) ? $response->get_error_message() : json_decode( $response['body'] );
	}

	/*//输出错误
	function wxcs_print_error( $result ){
		$settings = get_option('ws_settings');
		if( isset($settings['ws_debug']) ){
			echo "<script>console.error(eval('(' + '". json_encode($result) ."' + ')'))</script>";
		}
	}*/

	//获取Access Token
	function get_access_token(){
		
		if( ($access_token = get_option('ws_access_token')) !== false && $access_token != '' && time() < $access_token['expire_time']){
			return $access_token['access_token'];
		}
		
		$settings = get_option('ws_settings');
		$api_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='. $settings['ws_appid'] .'&secret='. $settings['ws_appsecret'];
		$response = wp_remote_get( $api_url );
		if( $this->is_api_error( $response ) ){
			return $response;
		}
		
		$result = json_decode( $response['body'] );
		$access_token['access_token'] = $result->access_token;
		$access_token['expire_time'] = time() + intval( $result->expires_in );
		update_option( 'ws_access_token', $access_token );
		
		return $access_token['access_token'];
	}

	//获取JSAPI TICKET
	function get_jsapi_ticket(){
		
		if( ($jsapi_ticket = get_option('ws_jsapi_ticket')) !== false && $jsapi_ticket != '' && time() < $jsapi_ticket['expire_time']){
			return $jsapi_ticket['jsapi_ticket'];
		}
		
		$settings = get_option('ws_settings');
		if( $this->is_api_error( $access_token = $this->get_access_token() ) ){
			return $access_token;
		}
		$api_url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='. $access_token .'&type=jsapi';
		$response = wp_remote_get( $api_url );
		if ( $this->is_api_error( $response ) ){
			return $response;
		}
		
		$result = json_decode( $response['body'] );
		$jsapi_ticket['jsapi_ticket'] = $result->ticket;
		$jsapi_ticket['expire_time'] = time() + intval( $result->expires_in );
		update_option( 'ws_jsapi_ticket', $jsapi_ticket );
		
		return $jsapi_ticket['jsapi_ticket'];
	}

	//生成随机字符串
	function generate_noncestr( $length = 16 ){
		
		$noncestr = '';
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		for( $i = 0; $i < $length; $i++ ){
			$noncestr .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		return $noncestr;
	}

	/*//获取#前面的完整URL
	function get_signature_url(){
		$protocol = is_ssl() ? 'https://' : 'http://';
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url = explode('#', $url);
		$url = $url[0];
		
		return $url;
	}*/

	//生成签名
	function generate_signature( $jsapi_ticket, $noncestr, $timestamp, $url ){
		
		$str = 'jsapi_ticket='. $jsapi_ticket .'&noncestr='. $noncestr .'&timestamp='. $timestamp .'&url='. $url;
		return sha1($str);
	}

	//获取所有自定义类型
	function get_all_post_types(){
		
		$args = array( 'public' => true, '_builtin' => false );
		$builtInArgs = array( 'public' => true, '_builtin' => true );
		$output = 'objects';
		$operator = 'and';
		
		$builtin_post_types = get_post_types( $builtInArgs, $output, $operator );
		$custom_post_types = get_post_types( $args, $output, $operator );
		$all_post_type = array_merge( $builtin_post_types, $custom_post_types );
		
		foreach( $all_post_type as $type ){
			$types[ $type->name ] = $type->label;
		}
		return $types;
	}

	//API配置通知
	function api_config_notice(){
		
		$current_screen = get_current_screen();
		
		/*if( ( empty( $settings['ws_appid'] ) || empty( $settings['ws_appsecret'] ) ) &&
			(
			//$current_screen -> base != 'edit' && array_key_exists($current_screen->post_type, $settings['ws_display_types']) ||
			$current_screen -> id == 'settings_page_wxcs-settings'
			) ){*/
		if( $current_screen -> id == 'settings_page_wxcs-settings' ){
			
			$settings = get_option('ws_settings');
			$public_ip = $this->get_public_ip();
	?>
			<div class="notice notice-warning">
				<p class="wxcs-notice">
				<?php
				printf(
				__( 'If you want to share link in Wechat directly, please follow these steps:
				<br>1. Verify your account on WeChat Admin Platform.
				<br>2. Enter AppID and AppSecret (Development > Basic Configuration).
				<br>3. Add your Server IP <code>%s</code> to IP White List (Development > Basic Configuration > IP whitelist).
				<br>4. Add Host <code>%s</code> to JSAPI Secure Domain (Settings > Account Info > Function setting > JS interface security domain name).', 'wx-custom-share' ),
				$public_ip,
				$_SERVER['HTTP_HOST']
				)
				?>
				<br>
				<?php _e( 'Otherwise you must share link to Wechat via QQ to custom share info, or share in QQ directly.', 'wx-custom-share' ) ?>
				</p>
			</div>
			<style>p.wxcs-notice{ line-height: 2 }</style>
	<?php
		}
	}

	//设置按钮
	function add_action_links( $links ) {
		
		$setting_link = array(
			'<a href="' . admin_url('options-general.php?page=wxcs-settings') . '">'. __('Settings','wx-custom-share'). '</a>',
			'<a href="https://www.qwqoffice.com/article-20.html" target="_blank">'. __('Go Premium','wx-custom-share'). '</a>'
		);
		
		return array_merge( $setting_link, $links );
	}
	
	//支持按钮
	function add_plugin_row_meta( $links, $file ){
		
		if ( strpos( $file, 'wx-custom-share.php' ) !== false ) {
			$new_links = array(
				'support' => '<a href="http://wpa.qq.com/msgrd?v=3&uin=514825166&site=qq&menu=yes" target="_blank">'. __('Support','wx-custom-share') .'</a>',
			);
			
			$links = array_merge( $links, $new_links );
		}
		
		return $links;
	}

	//设置菜单
	function setting_menu(){
		
		add_options_page( __('Wechat Share Settings','wx-custom-share'), __('Wechat Share','wx-custom-share'), 'administrator', 'wxcs-settings', array( $this, 'setting_html_page' ) );
	}

	//注册设置项
	function settings_init() {

		add_settings_section( 'wxcs_api_setting', __('WeChat Platform','wx-custom-share'), '', 'wxcs-settings' );
		add_settings_field( 'wxcs_appid', __('Wechat AppID','wx-custom-share'), array( $this, 'appid_setting_cb' ), 'wxcs-settings', 'wxcs_api_setting' );
		add_settings_field( 'wxcs_appsecret', __('Wechat AppSecret','wx-custom-share'), array( $this, 'appsecret_setting_cb' ), 'wxcs-settings', 'wxcs_api_setting' );
		
		add_settings_section( 'wxcs_default_setting', __('Default','wx-custom-share'), '', 'wxcs-settings' );
		add_settings_field( 'wxcs_default_img', __('Default Icon','wx-custom-share'), array( $this, 'default_img_setting_cb' ), 'wxcs-settings', 'wxcs_default_setting' );
		
		add_settings_section( 'wxcs_home_setting', __('Home','wx-custom-share'), array( $this, 'home_setting_section_cb' ), 'wxcs-settings' );
		add_settings_field( 'wxcs_home_title', __('Home Page Title','wx-custom-share'), array( $this, 'home_title_setting_cb' ), 'wxcs-settings', 'wxcs_home_setting' );
		add_settings_field( 'wxcs_home_desc', __('Home Page Description','wx-custom-share'), array( $this, 'home_desc_setting_cb' ), 'wxcs-settings', 'wxcs_home_setting' );
		add_settings_field( 'wxcs_home_url', __('Home Page URL','wx-custom-share'), array( $this, 'home_url_setting_cb' ), 'wxcs-settings', 'wxcs_home_setting' );
		add_settings_field( 'wxcs_home_img', __('Home Page Icon','wx-custom-share'), array( $this, 'home_img_setting_cb' ), 'wxcs-settings', 'wxcs_home_setting' );
		add_settings_field( 'wxcs_home_use_actual_url', __('Use Actual URL','wx-custom-share'), array( $this, 'home_use_actual_url_setting_cb' ), 'wxcs-settings', 'wxcs_home_setting' );
		
		add_settings_section( 'wxcs_advanced_setting', __('Advanced','wx-custom-share'), '', 'wxcs-settings' );
		add_settings_field( 'wxcs_post_types', __('Post types to custom','wx-custom-share'), array( $this, 'post_types_setting_cb' ), 'wxcs-settings', 'wxcs_advanced_setting' );
		add_settings_field( 'wxcs_other', __('Other','wx-custom-share'), array( $this, 'other_setting_cb' ), 'wxcs-settings', 'wxcs_advanced_setting' );
		
		register_setting( 'wxcs-settings', 'ws_settings' );
	}

	function appid_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
	?>
	<input type="text" id="ws_settings[ws_appid]" name="ws_settings[ws_appid]" value="<?php echo isset($settings['ws_appid']) ? $settings['ws_appid'] : '' ?>" class="regular-text" autocomplete="off">
	<?php
	}

	function appsecret_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
	?>
	<input type="text" id="ws_settings[ws_appsecret]" name="ws_settings[ws_appsecret]" value="<?php echo isset($settings['ws_appsecret']) ? $settings['ws_appsecret'] : '' ?>" class="regular-text" autocomplete="off">
	<?php
	}

	function default_img_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
	?>
	<input type="text" id="ws_settings[ws_default_img]" name="ws_settings[ws_default_img]" value="<?php echo isset($settings['ws_default_img']) ? $settings['ws_default_img'] : '' ?>" class="regular-text" autocomplete="off">
	<button type="button" class="button ws-media-btn" data-target="ws_settings[ws_default_img]">
		<span class="ws-media-icon dashicons dashicons-admin-media"></span>
		<?php _e('Media','wx-custom-share') ?>
	</button>
	<?php
	}

	function home_setting_section_cb(){
	?>
	<p class="description"><?php _e('Please go to edit page to set the share information if you choose a page as front page.','wx-custom-share') ?></p>
	<?php
	}

	function home_title_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
		$default_home_title = get_option('blogname');
	?>
	<input type="text" id="ws_settings[ws_home_title]" name="ws_settings[ws_home_title]" value="<?php echo isset($settings['ws_home_title']) ? $settings['ws_home_title'] : '' ?>" placeholder="<?php echo $default_home_title ?>" class="regular-text" autocomplete="off">
	<?php
	}

	function home_desc_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
		$default_home_desc = get_option('blogdescription');
	?>
	<input type="text" id="ws_settings[ws_home_desc]" name="ws_settings[ws_home_desc]" value="<?php echo isset($settings['ws_home_desc']) ? $settings['ws_home_desc'] : '' ?>" placeholder="<?php echo $default_home_desc ?>" class="regular-text" autocomplete="off">
	<?php
	}

	function home_url_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
		$default_home_url = get_option('siteurl');
	?>
	<input type="text" id="ws_settings[ws_home_url]" name="ws_settings[ws_home_url]" value="<?php echo isset($settings['ws_home_url']) ? $settings['ws_home_url'] : '' ?>" placeholder="<?php echo $default_home_url ?>" class="regular-text" autocomplete="off">
	<?php
	}

	function home_img_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
		$default_home_img = isset( $settings['ws_default_img'] ) && ! empty( $settings['ws_default_img'] ) ? $settings['ws_default_img'] : '';
	?>
	<input type="text" id="ws_settings[ws_home_img]" name="ws_settings[ws_home_img]" value="<?php echo isset($settings['ws_home_img']) ? $settings['ws_home_img'] : '' ?>" placeholder="<?php echo $default_home_img ?>" class="regular-text" autocomplete="off">
	<button type="button" class="button ws-media-btn" data-target="ws_settings[ws_home_img]">
		<span class="ws-media-icon dashicons dashicons-admin-media"></span>
		<?php _e('Media','wx-custom-share') ?>
	</button>
	<?php
	}
	
	function home_use_actual_url_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
	?>
	<p>
		<input type="checkbox" id="ws_settings[ws_home_use_actual_url]" name="ws_settings[ws_home_use_actual_url]" <?php checked( isset( $settings['ws_home_use_actual_url'] ) ) ?>>
		<label for="ws_settings[ws_home_use_actual_url]"><?php _e('Use Actual URL Instead','wx-custom-share') ?></label>
	</p>
	<?php
	}

	function post_types_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
	?>
	<?php foreach( $this->get_all_post_types() as $k => $v ): ?>
		<p>
			<input type="checkbox" id="ws_settings[ws_display_types][<?php echo $k ?>]" name="ws_settings[ws_display_types][<?php echo $k ?>]" <?php checked(isset($settings['ws_display_types'][$k])) ?>>
			<label for="ws_settings[ws_display_types][<?php echo $k ?>]"><?php echo $v ?> (<?php echo $k ?>)</label>
		</p>
	<?php endforeach; ?>
	<?php
	}

	function other_setting_cb(){
		
		$settings = get_option( 'ws_settings' );
	?>
	<p>
		<input type="checkbox" id="ws_settings[ws_del_data]" name="ws_settings[ws_del_data]" <?php checked(isset($settings['ws_del_data'])) ?>>
		<label for="ws_settings[ws_del_data]"><?php _e('Clear plugin data when uninstall','wx-custom-share') ?></label>
	</p>
	<p>
		<input type="checkbox" id="ws_settings[ws_debug]" name="ws_settings[ws_debug]" <?php checked(isset($settings['ws_debug'])) ?>>
		<label for="ws_settings[ws_debug]"><?php _e('Debug mode','wx-custom-share') ?></label>
		<p class="description"><?php _e('Error will be print to console','wx-custom-share') ?></p>
	</p>
	<?php
	}

	//后台设置页面
	function setting_html_page(){
		
		wp_enqueue_media();
	?>
	<div class="wrap">
		<h2><?php _e('Wechat Share Settings','wx-custom-share') ?></h2>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'wxcs-settings' ) ?>
			<?php do_settings_sections( 'wxcs-settings' ); ?>
			<?php submit_button(); ?>
		</form>
		<div class="ws-notice">
			<h4><?php _e('Information Setting Override Order','wx-custom-share') ?></h4>
			<h5><?php _e('Title','wx-custom-share') ?></h5>
			<p><?php _e('Front Page: Home Title Setting >> Blog Name','wx-custom-share') ?><br>
			<?php _e('Post: Post Title Setting in Post setting page >> Post title','wx-custom-share') ?></p>
			<h5><?php _e('Description','wx-custom-share') ?></h5>
			<p><?php _e('Front Page: Home Description Setting >> Blog Description','wx-custom-share') ?><br>
			<?php _e('Post: Post Description Setting in Post setting page >> First Paragraph that length higher than 10 of Post Content >> Post Permalink','wx-custom-share') ?></p>
			<h5><?php _e('URL','wx-custom-share') ?></h5>
			<p><?php _e('Front Page: Home URL Setting >> Site URL','wx-custom-share') ?><br>
			<?php _e('Post: Post URL Setting in Post setting page >> Post Permalink','wx-custom-share') ?></p>
			<h5><?php _e('Icon','wx-custom-share') ?></h5>
			<p><?php _e('Front Page: Home Icon Setting >> Default Icon Setting','wx-custom-share') ?><br>
			<?php _e('Post: Post Icon Setting in Post setting page >> Post Featured Image >> First Image of Post Content >> Default Icon Setting','wx-custom-share') ?></p>
		</div>
	</div>
	<style>
	.ws-media-btn {
		vertical-align: top !important;
	}
	.ws-media-icon {
		color: #82878c;
		vertical-align: text-top;
		font: 400 18px/1 dashicons;
	}
	.ws-notice {
		margin: 5px 0 15px !important;
		background: #FFF;
		border-left: 4px solid #FFF;
		-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
		box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
		margin: 5px 15px 2px;
		padding: 1px 12px;
	}
	.ws-notice h5 {
		margin-bottom: 0;
	}
	.ws-notice p {
		margin-top: 5px;
	}
	</style>
	<script>
	var mediaUploader;
	jQuery('.ws-media-btn').click(function(e){
		e.preventDefault();
		
		trigger = jQuery(this);
		
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: '<?php _e('Choose Icon','wx-custom-share') ?>',
			button: {
				text: '<?php _e('Insert','wx-custom-share') ?>'
			},
			multiple: false
		});
			
		mediaUploader.on('select', function(){
			var attachment = mediaUploader.state().get('selection').first().toJSON();
			jQuery('[id="'+ trigger.data('target') +'"]').val(attachment.url);
		});
		mediaUploader.open();
	});
	</script>
	<?php   
	}

	//显示Metabox
	function display_metabox( $type, $title, $desc, $url, $img, $use_actual_url ){
		
		$pngdata = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACVCAYAAAC6lQNMAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwA'.
				   'ADsMAAA7DAcdvqGQAAAXCSURBVHhe7dwNS+NMGIXh/f8/U0SsIloRUUS6e8RANzyT5mNO80xyD1zwrpvWhd5MJunk/XNzc3MCaiMsWBAWLAgLFoQFC8KC'.
				   'BWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWh'.
				   'AULwoIFYV3R/f396fHx8XQ8Hv/z9PR0OhwO4WtaRVhmDw8Pp9fX19PX19dpzHh/f/8J7fb2Nny/VhCWiWanj4+P31ymD4WowKL3bgFhGWiGqjUUmCKNfk'.
				   '9mhFWRTl9LZqnS+P7+bm72IqxKNKtcWkcpEK2hXl5eTs/Pzz8Lef23ZrjPz8/fo8pDr4l+d0aEVYGiUjSloWgUUfTac3d3dz+hDY1WZi7CWmgoKv18ziy'.
				   'jwDSzRUPv2cKai7AWuBTV0gBKFwE65UbHZ0JYM7mj6pTi0ikzOj4LwprhWlF1otOifk/mm6iENdG1oxIFFP3OzFeJhDXBGlF1oqtF3TOLjs2AsEZaMyrR'.
				   'rBWNrKdDwhph7ag60V39MffH1kBYF2SJSqLTYdarQ8IakCkq0V33/iCsxmSLSrS3qz90KyI6dm2EFcgYlURhvb29hceujbB6skYlum/VH5wKG5A5Kom+3'.
				   'iGs5HQ/qLSfKkNUEv37uN2QXGnnZ5aotJUmGtGxGRDWP6UdBFmikij8rFeEsvuwFE40MkUVXQ1qZN5NuvuwopkgU1SlnQ3ZN/vtOqzSTJBlO4qiKj1kkX'.
				   'XR3tl1WNHaSh9kdOy1DUWVebtMZ9dhZb18H4pKP9ffR6/LZLdhRYt2rWWiY8eqsS4biirT2u+S3Yalmak/lly+dzsPllypbSUq2W1YNfc2nW9nmRvAlqI'.
				   'Swjobc64Goz1SU28FbC0qIayzMWfhvvS5vy1GJYR1NuaeCpc89xet9TRajkp2G1Z0CpsblgJSCP0x9tTa/7e0HpXsNqzorrtOSdGxY0Qz4JQbmV1cW4hK'.
				   'NhOWPgytd6K/K4mGtqdEx16iWSsaY06HHcW1hahkE2Hpw+hORVP2gEdro7mnQ4m+0M7+nZ5L82GdR9WNsXFF6yy919xZq+YFQeuaDiuKqhtjTos6TUXfF'.
				   '869A1/zgqB1zYY1FJV+PnatEsWgMXW9Ji099+fWZFi1oupEs9ac5/Vaeu7Prbmwakcl/fecG0NLz/25NRWWI6pOd0pcMsNEX+8QVnKlhbbG0qg6OpVFPx'.
				   '8r68bBNTQTVnSPSKNWVEu19tyfWxNhlXYQZIlKovD3ekUo6cNSONHIFFXpaR+t26Lj9yB9WNFMkCmq0s6GqZv9tiZ1WKWZgOf+8ksdVrS2WrK1paahqKZ'.
				   'sl9mq1GFlvXwfiko/199Hr9uTtGFFi3atZaJjr2koqkxrv7WlDSvaC7725TtRjZc2rGx7m4hqmqbCWutqkKimayqsNRbuRDUPp8IBRDVf2rDW3uZLVMuk'.
				   'DSu6664POjq2NqJaLm1YEo25T9CMRVR1pA6r9nN/lxBVPanDitZZ+oAdsxZR1ZU6LH3Y0feFte/AE1V9qcOSms/9RYjKI31YUnqI4ng8hsePRVQ+TYSlD'.
				   '1gfdDR0WlQg0euG6HZG6T2JarkmwpLSKVFDIWj2GhOYFv6lJ340iKqOZsKS6Enj/lA0ikwhHg6HH3qd1mSlU2o3iKqepsISBVM6hS0ZWmsRVT3NhSUK4N'.
				   'LsM2VolpuzTkNZk2F1dBd+yeylOPf+NI1L02GJZhqtoYYW5P2hK0mdUqP3Qx3Nh3VOkSkYzWSigPR/j+n+zOx0PZsKC3kQFiwICxaEBQvCggVhwYKwYEF'.
				   'YsCAsWBAWLAgLFoQFC8KCBWHBgrBgQViwICxYEBYsCAsWhAULwoIFYcGCsGBBWLAgLFgQFiwICxaEBQvCggVhwYKwYEFYsCAsWBAWLAgLFoQFg5vTX+aG'.
				   'nVDy4FXBAAAAAElFTkSuQmCC';
				   
		$tips = array(
			'post' => array(
				'title' => __('Default is {post title} - {site name}.','wx-custom-share'),
				'desc' => __('Default is the post permalink.','wx-custom-share'),
				'url' => __('Default is first paragraph that length higher than 10 of post content or post permalink. The domain must match the page domain.','wx-custom-share'),
				'img' => __('Default is post featured image or first image of post content.','wx-custom-share')
			)
		);
		
		include( plugin_dir_path( __FILE__ ) . 'templates/metabox.php' );
	}
	
	//保存数据
	function save_share_info( $type, $object_id ){
		
		$info = array();
		$wxcs_url_field = array('ws-url', 'ws-img');
		foreach( $_POST as $post_key => $post_value ){
			if( strpos( $post_key, 'ws-' ) === 0 ){
				$meta_key = str_replace( '-', '_', $post_key );
				
				$info[$meta_key] = sanitize_text_field($_POST[$post_key]);
				if( in_array( $post_key, $wxcs_url_field ) ){
					$info[$meta_key] = esc_url( $info[$meta_key] );
				}
			}
		}
		
		if( $type == 'post' ){
			update_post_meta( $object_id, 'ws_info', $info );
		}
	}

	//添加帖子Metabox
	function add_post_metabox(){
		
		$settings = get_option('ws_settings');
		
		$meta_box = array(
			'id' => 'ws-meta-box',
			'title' => __('Wechat Share','wx-custom-share'),
			'callback' => array( $this, 'show_post_metabox' ),
			'context' => 'normal',
			'priority' => 'low'
		);
		
		if( isset( $settings['ws_display_types'] ) && array_key_exists( get_post_type(), $settings['ws_display_types'] ) ){
			add_meta_box( $meta_box['id'], $meta_box['title'], $meta_box['callback'], get_post_type(), $meta_box['context'], $meta_box['priority'] );
		}
	}
	function show_post_metabox(){
		
		global $post;
		
		$title = $this->get_title( 'post', $post->ID );
		$desc = $this->get_desc( 'post', $post->ID );
		$url = $this->get_url( 'post', $post->ID );
		$img = $this->get_img( 'post', $post->ID );
		$use_actual_url = $this->is_use_actual_url( 'post', $post->ID );

		$this->display_metabox( 'post', $title, $desc, $url, $img, $use_actual_url );
	}

	//帖子数据保存
	function save_post_data( $post_id ){
		
		//验证
		if( ! isset($_POST['ws_meta_box_nonce']) || ! wp_verify_nonce( $_POST['ws_meta_box_nonce'], 'wx-custom-share' ) ){
			return $post_id;
		}

		//自动保存检查
		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		}

		//检查权限
		if( 'page' == $_POST['post_type'] ){
			if (!current_user_can('edit_page', $post_id) ){
				return $post_id;
			}
		}
		elseif( ! current_user_can('edit_post', $post_id) ){
			return $post_id;
		}
		
		$this->save_share_info( 'post', $post_id );
	}
	
	//前端嵌入JS
	function add_share_js(){
		
		wp_enqueue_script( 'wxcs', '//qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js', '', '', true );
	}

	//前端嵌入分享代码
	function add_share_info(){
		
		$settings = get_option('ws_settings');
		
		$object_id = 'null';
		if( is_home() && get_option('show_on_front') == 'posts' ){
			
			$type = 'home';
		}
		else if( is_singular() && '' !== $settings['ws_display_types'] && array_key_exists( get_post_type(), $settings['ws_display_types'] ) ){
			
			global $post;
			$type = 'post';
			$object_id = $post->ID;
		}
		else{
			
			$type = 'other';
		}
		
	?>
	<script id="wxcs-script">
	WX_Custom_Share = function(){
		
		var xhr = null;
		var url = '<?php echo admin_url('admin-ajax.php') ?>';
		var signature_url = window.location.href.split('#')[0];
		var formData = {
			action: 'wxcs_get_share_info',
			type: '<?php echo $type ?>',
			id: <?php echo $object_id ?>,
			signature_url: signature_url
		};
		
		this.init = function(){
			if( window.XMLHttpRequest ){
				xhr = new XMLHttpRequest();
			}
			else if( window.ActiveXObject ){
				xhr = new ActiveXObject('Microsoft.XMLHTTP');
			}
			
			get_share_info();
		}
		
		function formatPostData( obj ){
			
			var arr = new Array();
			for (var attr in obj ){
				arr.push( encodeURIComponent( attr ) + '=' + encodeURIComponent( obj[attr] ) );
			}
			
			return arr.join( '&' );
		}
		
		function get_share_info(){
			
			if( xhr == null ) return;
			
			xhr.onreadystatechange = function(){
				if( xhr.readyState == 4 && xhr.status == 200 ){
					
					var data = eval('(' + xhr.responseText + ')');
					
					if( data == null ){
						return;
					}
					
					var info = {
						title: data.title,
						summary: data.desc,
						pic: data.img,
						url: data.url
					}
					
					if( formData.type == 'other' ){
						info.title = document.title;
						info.summary = location.href;
						info.url = location.href;
					}
					
					if( data.use_actual_url == true ){
						info.url = location.href;
					}

					if( data.error ){
						console.error( '<?php _e('WX Custom Share','wx-custom-share') ?>: ' )
						console.error( data.error );
					}
					else if( data.appid ){
						info.WXconfig = {
							swapTitleInWX: data.swapTitleInWX,
							appId: data.appid,
							timestamp: data.timestamp,
							nonceStr: data.nonceStr,
							signature: data.signature
						}
					}
					
					setShareInfo( info );
				}
			};
			
			xhr.open( 'POST', url, true);
			xhr.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
			xhr.send( formatPostData( formData ) );
		}
		
	}
	
	new WX_Custom_Share().init();
	</script>
	<?php
	}

	//Ajax获取分享信息
	function ajax_get_share_info(){
		
		$settings = get_option('ws_settings');
		
		if( isset( $_REQUEST['id'] ) && isset( $_REQUEST['type'] ) && isset( $_REQUEST['signature_url'] ) ){
			
			$object_id = $_REQUEST['id'];
			$type = $_REQUEST['type'];
			$signature_url = $_REQUEST['signature_url'];
		}else{
			wp_die();
		}
		
		$title = $this->get_title( $type, $object_id );
		$desc = $this->get_desc( $type, $object_id );
		$url = $this->get_url( $type, $object_id );
		$img = $this->get_img( $type, $object_id );
		$is_use_actual_url = $this->is_use_actual_url( $type, $object_id );
		
		$result['title'] = $title['display'];
		$result['desc'] = $desc['display'];
		$result['url'] = $url['display'];
		$result['img'] = $img['display'];
		$result['use_actual_url'] = $is_use_actual_url;
		
		if( $settings['ws_appid'] != '' && $settings['ws_appsecret'] != '' ){
			
			$jsapi_ticket = $this->get_jsapi_ticket();
			if( $this->is_api_error( $jsapi_ticket ) ){
				
				if( isset( $settings['ws_debug'] ) ){
					
					$result['error'] = $this->get_api_error( $jsapi_ticket );
				}
				
				echo json_encode( $result );
				wp_die();
			}
			
			$noncestr = $this->generate_noncestr();
			$timestamp = time();
			//$signature_url = $this->get_signature_url();
			$signature = $this->generate_signature( $jsapi_ticket, $noncestr, $timestamp, $signature_url );
			
			$result['swapTitleInWX'] = apply_filters( 'wxcs_wechat_timeline_swap_title', false );
			$result['appid'] = $settings['ws_appid'];
			$result['nonceStr'] = $noncestr;
			$result['timestamp'] = $timestamp;
			$result['signature'] = $signature;
		}
		
		echo json_encode( $result );
		wp_die();
	}

	//本地化
	function load_textdomain(){
		
		load_plugin_textdomain( 'wx-custom-share', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}


	//多站点兼容

	//创建新博客
	function new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ){
		
		global $wpdb;
		
		if( is_plugin_active_for_network('wx-custom-share/wx-custom-share.php') ){
			
			$old_blog = $wpdb->blogid;
			switch_to_blog( $blog_id );
			_wxcs_plugin_activation();
			switch_to_blog( $old_blog );
		}
	}

}

//激活插件
register_activation_hook( __FILE__, 'wxcs_plugin_activation' );
function wxcs_plugin_activation( $networkwide ){
	
	global $wpdb;
	
	if( function_exists( 'is_multisite' ) && is_multisite() ){
		
		if( $networkwide ){
			
			$old_blog = $wpdb->blogid;
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			
			foreach( $blogids as $blog_id ){
				switch_to_blog( $blog_id );
				_wxcs_plugin_activation();
			}
			
			switch_to_blog( $old_blog );
			return;
		}
	}
	
	_wxcs_plugin_activation();
}
function _wxcs_plugin_activation(){
	
	add_option( 'ws_settings', array(
		'ws_display_types' => array(
			'post' => 'on',
			'page' => 'on',
			'attachment' => 'on'
		)
	) );
}

/*//停用插件
register_deactivation_hook( __FILE__, 'wxcs_plugin_deactivation' ) );
function wxcs_plugin_deactivation(){

}*/

//删除插件
register_uninstall_hook( __FILE__, 'wxcs_plugin_uninstall' );
function wxcs_plugin_uninstall(){
	
	global $wpdb;
	
	if( function_exists( 'is_multisite' ) && is_multisite() ){
		
		$old_blog = $wpdb->blogid;
		$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		
		foreach( $blogids as $blog_id ){
			switch_to_blog($blog_id);
			_wxcs_plugin_uninstall();
		}
		
		switch_to_blog($old_blog);
		return;
	}
	
	_wxcs_plugin_uninstall();
}
function _wxcs_plugin_uninstall(){
	
	$settings = get_option('ws_settings');
	
	if( isset($settings['ws_del_data']) ){
		
		global $wpdb;
		
		$wpdb->query( "delete from $wpdb->postmeta where meta_key = 'ws_info'" );
		
		delete_option( 'ws_settings' );
		delete_option( 'ws_access_token' );
		delete_option( 'ws_jsapi_ticket' );
	}
}

new WX_Custom_Share();
?>