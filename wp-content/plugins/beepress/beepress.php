<?php
/*
Plugin Name: 小蜜蜂采集器
Plugin URI: http://xingyue.artizen.me?s=wp
Description: 小蜜蜂(BeePress) 是一款能够帮助你导入微信公众号文章、知乎专栏文章、简书文章、今日头条文章的插件，免费试用，可以实现单篇或者批量导入、自动同步文章、采集指定公众号所有历史文章，支持将图片资源保存到本地。
Version: 4.5.1
Author: 黄碧成（Bee）
Author URI: http://xingyue.artizen.me?source=wp
License: GPL
*/

/**
 * 初始化
 */
define('BEEPRESS_VERSION', '4.5.1');
if(!class_exists('simple_html_dom_node')){
	require_once("simple_html_dom.php");
}

$GLOBALS['errMsg'] = array();
$GLOBALS['done'] = false;

add_action('admin_init', 'beepress_admin_init');
add_action('init', 'beepress_process_request');

global $beepress_cron_table, $beepress_profile_table, $table_prefix;
$beepress_cron_table = $table_prefix.'bp_cron_config';
$beepress_profile_table = $table_prefix . 'bp_profile';

function beepress_admin_init () {
	// 引入样式文件及交互脚本
	wp_register_style('bootstrap-style', plugins_url('/vender/bootstrap/css/bootstrap.min.css', __FILE__));
	wp_register_script('bootstrap-script', plugins_url('/vender/bootstrap/js/bootstrap.min.js', __FILE__));
}

/**
 * 后台入口
 */
if (is_admin()) {
	add_action('admin_menu', 'beepress_pro_admin_menu');
	add_action('admin_menu', 'beepress_pro_option_menu');
	add_action('admin_menu', 'beepress_admin_menu');
}
if (!function_exists('beepress_pro_admin_menu')) {
	function beepress_pro_admin_menu() {
		add_menu_page('BeePress Pro', '小蜜蜂 <span class="update-plugins beepress-pro"><span class="plugin-count">专业版</span></span>', 'publish_posts', 'beepress_pro', 'beepress_pro_request_page', '');
	}
}
// 在文章下面添加子菜单入口
function beepress_admin_menu() {
	if (get_option('bp_hide_lite_edition', 'no') != 'yes') {
		add_menu_page('BeePress，微信公众号文章一键导入插件', '小蜜蜂 <span class="update-plugins beepress-lite"><span class="plugin-count">基础版</span></span>', 'publish_posts', 'beepress', 'beepress_setting_page', '');
	}
}
// BeePress界面
function beepress_setting_page() {
	require_once 'setting-page.php';
}

// 处理请求
function beepress_process_request() {
	if (function_exists('set_time_limit')) {
		set_time_limit(0);//避免超时
	}
	global $wpdb;
	global $beepress_cron_table, $beepress_profile_table;
	// 媒体：wx 公众号, js 简书
	$schedule = isset($_REQUEST['schedule']) ? intval($_REQUEST['schedule']) == 1 : false;
	$plugin   = isset($_REQUEST['plugin']) ? intval($_REQUEST['plugin']) == 1 : false;
	$media    = isset($_REQUEST['media']) ? $_REQUEST['media'] : '';
	$setting  = isset($_REQUEST['setting']) ? $_REQUEST['setting'] : '';
	$licenseCode = isset($_REQUEST['license_code']) ? $_REQUEST['license_code'] : '';

	$conf     = $wpdb->get_row("SELECT * FROM $beepress_cron_table", ARRAY_A);
	if ($setting == 'cron') {
		$token = isset($_REQUEST['token']) ? trim($_REQUEST['token']) : '';
		$open  = isset($_REQUEST['open']) ? $_REQUEST['open'] : '';
		$open  = intval($open == 'on' ? 1 : 0);

		if ($conf) {
			$id = $conf['id'];
			$sql = "UPDATE " . $beepress_cron_table . " SET token='$token', open=$open " . " WHERE id=$id";
		} else {
			$sql = "INSERT INTO " . $beepress_cron_table . " VALUES(1, '$token', $open)";
		}
		$wpdb->query($sql);
		return;
	}
	if ($licenseCode) {
		$profile = $wpdb->get_row("SELECT * FROM $beepress_profile_table", ARRAY_A);
		if ($profile) {
			$id = intval($profile['id']);
			$sql = "UPDATE " . $beepress_profile_table . " SET token='$licenseCode' " . " WHERE id=$id";
			$wpdb->query($sql);
		}
	}

	$postFile = '';
	if ($schedule) {
		// 判断token是否符合
		$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
		if ($conf && ($conf['token'] != $token || !intval($conf['open']) == 1)) {
			exit;
		}
		$postUrls = explode('|', base64_decode(isset($_REQUEST['urls']) ? str_replace(" ","+",$_GET['urls']) : ''));
		$media = 'wx';
	} elseif($plugin) {
		// 判断token是否符合
		$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
		if ($conf && ($conf['token'] != $token || !intval($conf['open']) == 1)) {
			exit;
		}
		$postUrls = isset($_REQUEST['post_urls']) ? $_REQUEST['post_urls'] : '';
		$media = 'wx';
	} else {
		// 文章url
		$postUrls = isset($_REQUEST['post_urls']) ? $_REQUEST['post_urls'] : '';
		$postFile = isset($_FILES['post_file']) ? $_FILES['post_file'] : '';
	}
	$debug    = isset($_REQUEST['debug']) ? $_REQUEST['debug'] : false;
	// 两者都没有，则不进行处理
	if (!($postFile || $postUrls)) {
		return;
	}
	// 如果是文件形式，则处理成URL
	if (isset($postFile['tmp_name']) && $postFile['tmp_name']) {
		$postUrls = file_get_contents($postFile['tmp_name']);
	}
	$finalUrls = $schedule ? $postUrls : explode("\n", $postUrls);
	if (count($finalUrls) == 0) {
		$GLOBALS['errMsg'][] = '没有符合要求的文章地址';
		return;
	}

	$postId = null;
	switch($media) {
		// 微信
		case 'wx':
			$postId = beepress_for_wx_insert_by_url($finalUrls);
			break;
		// 简书 todo
		case 'js':
			break;
		default:
			// do nothing
			break;
	}
	if ($debug == 'debug') {
		var_dump($GLOBALS['errMsg']);
		exit;
	}

	if ($schedule || $plugin) {
		exit;
	}

	if ($postId && count($finalUrls) == 1) {
		$editPostUrl = home_url('wp-admin/post.php?post=' . $postId . '&action=edit');
		wp_redirect($editPostUrl);
		exit;
	}
}

function beepress_for_wx_insert_by_url($urls) {
	global $wpdb;
	global $beepress_profile_table;
	//添加下载图片地址到本地功能
	$schedule       = isset($_REQUEST['schedule']) && intval($_REQUEST['schedule']) == 1;
	$sprindboard    = isset($_REQUEST['springboard']) ?
						$_REQUEST['springboard'] :
						'http://read.html5.qq.com/image?src=forum&q=4&r=0&imgflag=7&imageUrl=';
	// 微信原作者
	$changeAuthor   = false;
	// 改变发布时间
	$changePostTime = isset($_REQUEST['change_post_time']) && $_REQUEST['change_post_time'] == 'true';
	// 默认是直接发布
	$postStatus     = isset($_REQUEST['post_status']) && in_array($_REQUEST['post_status'], array('publish', 'pending', 'draft')) ?
						$_REQUEST['post_status'] : 'publish';
	// 保留文章样式
	$keepStyle      = isset($_REQUEST['keep_style']) && $_REQUEST['keep_style'] == 'keep';
	// 文章分类，默认是未分类（1）
	$postCate       = isset($_REQUEST['post_cate']) ? intval($_REQUEST['post_cate']) : 1;
	$postCate       = array($postCate);
	// 文章类型，默认是post
	$postType       = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : 'post';
//	$debug          = isset($_REQUEST['debug']) ? $_REQUEST['debug'] : false;
	$force          = isset($_REQUEST['force']) ? $_REQUEST['force'] : true;

	$postId         = null;
	$urls           = str_replace('https', 'http', $urls);
	// 手动导入有免费次数限制
	$profile = $wpdb->get_row("SELECT * FROM $beepress_profile_table", ARRAY_A);
	foreach ($urls as $url) {
		if (strpos($url, 'http://mp.weixin.qq.com/s') !== false || strpos($url, 'https://mp.weixin.qq.com/s') !== false) {
			$url =  trim($url);
		}
		if (!$url) {
			continue;
		}
		if (function_exists('file_get_contents')) {
			$html = @file_get_contents($url);
		} else {
			$GLOBALS['errMsg'][] = '不支持file_get_contents';
			break;
		}
		if ($html == '') {
			$ch = curl_init();
			$timeout = 30;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$html = curl_exec($ch);
			curl_close($ch);
		}
		if (!$html) {
			$GLOBALS['errMsg'][] = array(
				'url' => $url,
				'msg' => '无法获取此条URL内容'
			);
			continue;
		}
		// 是否移除原文样式
		if (!$keepStyle) {
			$html = preg_replace('/style\=\"[^\"]*\"/', '', $html);
		}
		$dom  = str_get_html($html);
		// 文章标题
		$title   = $dom->find('#activity-name', 0)->plaintext;
		$title   = trim($title);
		// 确保有标题
		if (!$title) {
			$GLOBALS['errMsg'][] = array(
				'url' => $url,
				'msg' => '此条URL没有文章标题'
			);
			continue;
		}
		// 同步任务检查标题是否重复，若重复则跳过
		if ($id = post_exists($title) && $schedule) {
			$GLOBALS['errMsg'][] = array(
				'url' => $url,
				'msg' => '标题重复'
			);
			continue;
		}
		// 处理图片及视频资源
		$imageDoms = $dom->find('img');
		$videoDoms = $dom->find('.video_iframe');
		foreach ($imageDoms as $imageDom) {
			$dataSrc = $imageDom->getAttribute('data-src');
			if (!$dataSrc) {
				continue;
			}
			$src  = $sprindboard . $dataSrc;
			$imageDom->setAttribute('src', $src);
		}
		foreach ($videoDoms as $videoDom) {
			$dataSrc = $videoDom->getAttribute('data-src');
			// 视频不用跳板
			$videoDom->setAttribute('src', $dataSrc);
		}
		// 发布日期
		if ($changePostTime) {
			$postDate = date('Y-m-d H:i:s', current_time('timestamp'));
		} else {
			$postDate = $dom->find('#post-date', 0)->plaintext;
			$postDate = date('Y-m-d H:i:s', strtotime($postDate));
		}
		// 提取用户信息
		$url      = parse_url($url);
		$query    = isset($url['query']) ? $url['query'] : '';
		$queryArr = explode('&', $query);
		$bizVal   = '';
		$cates = array();
		foreach ($queryArr as $item) {
			if (!$item) {
				continue;
			}
			list($key, $val) = explode('=', $item, 3);
			if ($key == '__biz') {
				//  用户唯一标识
				$bizVal = $val;
			}
			if ($key == 'cates') {
				$cates = explode(',', $val);
			}
		}
		// 如果链接中不含有biz参数，则选择当前的时间戳作为用户名和密码
		if ($bizVal == '') {
			$bizVal = time();
		}

		// 是否改变作者，默认是当前登录作者
		$userName = $dom->find('#post-user', 0)->plaintext;
		$userName = esc_html($userName);
		if ($changeAuthor) {
			// 创建用户
			$userId   = wp_create_user($bizVal, $bizVal);
			// 用户已存在
			if ($userId) {
				if ($userId->get_error_code() == 'existing_user_login') {
					$userData = get_user_by('login', $bizVal);
				} else if(is_integer($userId) > 0) {
					$userData = get_userdata($userId);
				} else {
					// 错误情况
					continue;
				}
				// 默认是投稿者
				$userData->add_role('contributor');
				$userData->remove_role('subscriber');
				$userData->display_name = $userName;
				$userData->nickname     = $userName;
				$userData->first_name   = $userName;
				wp_update_user($userData);
				$userId = $userData->ID;
			} else {
				// 默认博客作者
				$userId = get_current_user_id();
			}
		} else {
			// 默认博客作者
			$userId = get_current_user_id();
		}

		if ($schedule) {
			$userId = 1;
			if ($cates) {
				$cateIds = array();
				foreach ($cates as $cate) {
					$term = get_term_by('name', $cate, 'category');
					if ($term) {
						$cateIds[] = $term->term_id;
					} else {
					}
				}
				$postCate = $cateIds;
			}
		}

		// 过滤不符合规范的URL
		if ($profile) {
			$count = intval($profile['count']);
			$id = intval($profile['id']);
			$profileToken = $profile['token'];
			$secret = 'wiH5voK0FzAl1DVa';
			$homeUrl = home_url();
			$md5Token = md5($secret . $homeUrl);
			// 当剩余使用次数小于等于0且token不正确时，禁止导入
			if ($count <= 0 && $profileToken != $md5Token && !$schedule) {
				continue;
			} else {
				$count -= 1;
				if ($count < 0) {
					$count = 0;
				}
				$sql = "UPDATE " . $beepress_profile_table . " SET count=$count " . " WHERE id=$id";
				$wpdb->query($sql);
			}
		}
		$post = array(
			'post_title'    => $title,
			'post_content'  => "",
			'post_status'   => $postStatus,
			'post_date'     => $postDate,
			'post_modified' => $postDate,
			'post_author'   => $userId,
			'post_category' => $postCate,
			'post_type'	    => $postType
		);
		$postId = @wp_insert_post($post);
		// 公众号设置featured image
		$setFeaturedImage  = get_option('bp_featured_image', 'yes') == 'yes';
		if ($setFeaturedImage) {
			preg_match('/(msg_cdn_url = ")([^\"]+)"/', $html, $matches);
			$redirectUrl = 'http://read.html5.qq.com/image?src=forum&q=4&r=0&imgflag=7&imageUrl=';
			$coverImageSrc = $redirectUrl . $matches[2];
			$tmpFile = download_url($coverImageSrc);
			if (is_string($tmpFile)) {
				$prefixName = get_option('bp_image_name_prefix', 'beepress-weixin-zhihu-jianshu-plugin');
				$fileName = $prefixName . '-' . time() . '.jpeg';
				$fileArr  = array(
					'name'     => $fileName,
					'tmp_name' => $tmpFile
				);
				$id = @media_handle_sideload($fileArr, $postId);
				if (!is_wp_error($id)) {
					@set_post_thumbnail($postId, $id);
				}
			}
		}
		unset($html);
		// 下载图片到本地
		beepress_downloadImage($postId, $dom);
	}
	$GLOBALS['done'] = true;
	return $postId;
}

require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );
require_once( ABSPATH . 'wp-admin/includes/post.php' );

function beepress_downloadImage($postId, $dom) {
	// 提取图片
	$images            = $dom->find('img');
	$schedule          = isset($_REQUEST['schedule']) && intval($_REQUEST['schedule']) == 1;
	$version           = '2-4-2';
	// 文章标题
	$title             = $dom->find('#activity-name', 0)->plaintext;
	$title             = trim($title);
	$centeredImage     = get_option('bp_image_centered', 'no') == 'yes';
	foreach ($images as $image) {
		$src  = $image->getAttribute('src');
		$type = $image->getAttribute('data-type');
		if (!$src) {
			continue;
		}
		if (strstr($src, 'res.wx.qq.com')) {
			continue;
		}
		$class = $image->getAttribute('class');
		if ($centeredImage) {
			$class .= ' aligncenter';
			$image->setAttribute('class', $class);
		}
		$src = preg_replace('/^\/\//', 'http://', $src, 1);
		if (!$type || $type == 'other') {
			$type = 'jpeg';
		}
		$tmpFile = download_url($src);
		if ($schedule) {
			$fileName = 'beepress-schedule-' . $version . '-' . $postId . '-' . time() .'.' . $type;
		} else {
			$fileName = 'beepress-beepress-weixin-zhihu-jianshu-plugin-' . $version . '-' . $postId . '-' . time() .'.' . $type;
		}
		$fileArr = array(
			'name' => $fileName,
			'tmp_name' => $tmpFile
		);

		$id = @media_handle_sideload($fileArr, $postId);
		if (is_wp_error($id)) {
			$GLOBALS['errMsg'][] = array(
				'src'  => $src,
				'file' => $fileArr,
				'msg'  => $id
			);
			@unlink($tmpFile);
			continue;
		} else {
			$imageInfo = wp_get_attachment_image_src($id, 'full');
			$src       = $imageInfo[0];
			$image->setAttribute('src', $src);
			$image->setAttribute('alt', $title);
			$image->setAttribute('title', $title);
		}
	}
	$userName = $dom->find('#post-user', 0)->plaintext;
	$userName = esc_html($userName);
	// 保留来源
	$keepSource     = isset($_REQUEST['keep_source']) && $_REQUEST['keep_source'] == 'keep';
	$content = $dom->find('#js_content', 0)->innertext;
	$content = preg_replace('/data\-([a-zA-Z0-9\-])+\=\"[^\"]*\"/', '', $content);
	$content = preg_replace('/src=\"(http:\/\/read\.html5\.qq\.com)([^\"])*\"/', '', $content);
	$content = preg_replace('/class=\"([^\"])*\"/', '', $content);
	$content = preg_replace('/id=\"([^\"])*\"/', '', $content);
	if ($keepSource) {
		$source =
				"<blockquote class='keep-source'>" .
				"<p>始发于微信公众号：{$userName}</p>" .
				"</blockquote>";
		$content .= $source;
	}
	$content = '<div class="bpp-post-content">'.$content.'</div>';
	// 保留文章样式
	$content = trim($content);
	@wp_update_post(array(
		'ID' => $postId,
		'post_content' =>  $content
	));
}

function beepress_remove_useless_tags($content)
{
	$content = preg_replace("'<\s*[section|strong][^>]*[^/]>'is", '', $content);
	$content = preg_replace("'<\s*/\s*section\s*>'is", '', $content);
	$content = preg_replace("'<\s*/\s*strong\s*>'is", '', $content);
	return $content;
}


function beepress_install() {
	global $wpdb;
	global $beepress_cron_table, $beepress_profile_table;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	if ($wpdb->get_var("SHOW TABLES LIKE '$beepress_cron_table'") != $beepress_cron_table) {
		$sql = "CREATE TABLE " . $beepress_cron_table . "(
				id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
				token CHAR(200),
				open TINYINT(1) NOT NULL DEFAULT 1,
				PRIMARY KEY(id)
		) COLLATE='utf8_unicode_ci' ENGINE=MyISAM";
		dbDelta($sql);
	}

	if ($wpdb->get_var("SHOW TABLES LIKE '$beepress_profile_table'") != $beepress_profile_table) {
		$sql = "CREATE TABLE " . $beepress_profile_table . "(
				id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
				token CHAR(200),
				count SMALLINT(5) NOT NULL DEFAULT 5,
				PRIMARY KEY(id)
		) COLLATE='utf8_unicode_ci' ENGINE=MyISAM";
		dbDelta($sql);
		$sql = "INSERT INTO " . $beepress_profile_table . " VALUES(2, '', 5)";
		dbDelta($sql);
	}
}

function beepress_uninstall() {
}

register_activation_hook(__FILE__, 'beepress_install');

register_uninstall_hook(__FILE__, 'beepress_uninstall');


/**
 * PRO
 */
require_once 'beepress-pro.php';
