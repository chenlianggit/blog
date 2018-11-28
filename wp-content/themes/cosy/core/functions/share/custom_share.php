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
  	@Date:   2017-09-16 14:42:56
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 14:16:48

*/

/**
* 自定义分享内容
*/
class MiCustomShare {
	
	function __construct(){

		add_action( 'wp_enqueue_scripts', array( $this, 'mi_add_share_js' ) );

		add_action( 'wp_footer', array( $this, 'mi_add_share_info' ), 2333 );

	}

	function mi_add_share_js(){
		wp_enqueue_script( 'mi-share-js', '//qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js', array(), THEME_VERSION, 'all' );
	}

	function get_signature_url(){
		$protocol = is_ssl() ? 'https://' : 'http://';
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url = explode('#', $url);
		$url = $url[0];
		
		return $url;
	}

	//获取Access Token
	function get_access_token(){

		if( ($access_token = get_option('ws_access_token')) !== false && $access_token != '' && time() < $access_token['expire_time']){
			return $access_token['access_token'];
		}
		
		$api_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='. cs_get_option('share_appid') .'&secret='. cs_get_option( 'share_appsecret' );
		$response = wp_remote_get($api_url);
		if ( is_array( $response ) && ! is_wp_error($response) ){
			$result = json_decode($response['body']);
		} else {
			return false;
		}
		
		$access_token['access_token'] = !$result->errcode ? $result->access_token : '';
		$access_token['expire_time'] = !$result->errcode ? time() + intval( $result->expires_in ) : '';
		update_option( 'ws_access_token', $access_token );
		
		return $access_token['access_token'];
	}

	//获取JSAPI TICKET
	function get_jsapi_ticket(){
		if( ($jsapi_ticket = get_option('wx_jsapi_ticket')) !== false && $jsapi_ticket != '' && time() < $jsapi_ticket['expire_time']){
			return $jsapi_ticket['jsapi_ticket'];
		}
		
		if( ($access_token = $this->get_access_token()) === false ) return false;
		$api_url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='. $access_token .'&type=jsapi';
		$response = wp_remote_get($api_url);
		if ( is_array( $response ) && ! is_wp_error($response) ){
			$result = json_decode($response['body']);
		}
		else{
			return false;
		}
		
		$jsapi_ticket['jsapi_ticket'] = !$result->errcode ? $result->ticket : '';
		$jsapi_ticket['expire_time'] = !$result->errcode ? time() + intval( $result->expires_in ) : '';
		update_option( 'wx_jsapi_ticket', $jsapi_ticket );
		
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

	//生成签名
	function generate_signature($jsapi_ticket, $noncestr, $timestamp, $url){
		$str = 'jsapi_ticket='. $jsapi_ticket .'&noncestr='. $noncestr .'&timestamp='. $timestamp .'&url='. $url;
		return sha1($str);
	}

	function get_wx_config(){

		if( cs_get_option('share_appid') && cs_get_option( 'share_appsecret' ) && ( $jsapi_ticket = $this->get_jsapi_ticket() ) !== false ){
			$noncestr      = $this->generate_noncestr();
			$timestamp     = time();
			$signature_url = $this->get_signature_url();
			$signature     = $this->generate_signature($jsapi_ticket, $noncestr, $timestamp, $signature_url);

			$config = array(
				'noncestr'  => $noncestr,
				'timestamp' => $timestamp,			
				'signature' => $signature,
			);
		}else{
			$config = null;
		}

		return $config;

	}

	function get_share_info(){

		$info = array();

		if( is_single() || is_singular() ){

			$post_thumbnail_src = post_thumbnail_src();

			$pic = strstr( $post_thumbnail_src, 'default.jpg' ) ? timthumb( cs_get_option( 'share_img' ), array( 'w' => '300', 'h' => '300' ) ) : timthumb( $post_thumbnail_src, array( 'w' => '300', 'h' => '300' ) );

			$info = array(
				'title'   => get_the_title(),
				'summary' => get_the_excerpt(),
				'url'     => get_permalink(),
				'pic'     => $pic,
			);

		}else{

			$pngdata = get_template_directory_uri().'/static/images/wxdefault.png';


			$att = wp_get_attachment_image_src( cs_get_option( 'share_img' ), 'full' );
			if( isset( $att ) ){
				$pic = $att[0];
			}else{
				$pic = null;
			}

			$info = array( 
				'title'   => cs_get_option( 'share_title' ) ? cs_get_option( 'share_title' ) : get_bloginfo( 'name' ),
				'summary' => cs_get_option( 'share_summary' ) ? cs_get_option( 'share_summary' ) :get_bloginfo( 'description' ),
				'url'     => $this->get_signature_url(),
				'pic'     => $pic ? $pic : $pngdata,
			);

		}

		return $info;

	}

	function mi_add_share_info(){

		$info = $this->get_share_info();
		$wxconfig = $this->get_wx_config();
		$wxappid = cs_get_option('share_appid');

		if( $wxconfig && $wxappid ){
		$WXconfig = <<<WX
			WXconfig:{
				swapTitleInWX: false,
				appId: '{$wxappid}',
				timestamp: '{$wxconfig['timestamp']}',
				nonceStr: '{$wxconfig['noncestr']}',
				signature: '{$wxconfig['signature']}'
			}
WX;

		}else{
			$WXconfig = '';
		}
	

		$script = <<<SCRIPT

		<script>
	
			setShareInfo({
				title: '{$info['title']}',
				summary: '{$info['summary']}',
				pic: '{$info['pic']}',
				url: '{$info['url']}',
				{$WXconfig}
			});

		</script>
SCRIPT;

		echo $script;

	}


}

new MiCustomShare();
