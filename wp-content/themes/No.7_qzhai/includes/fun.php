<?php

//decode by http://www.yunlu99.com/
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
global $qzhai;
$qzhai['top_num'] = is_admin_bar_showing() ? 97 : 65;
function set_filter_qzhai()
{
	global $qzhai;
	echo $qzhai['html'];
}
function is_pro()
{
	$_var_0 = Q_is(of_get('key'));
	return $_var_0['state'];
}
function encrypt($_var_1, $_var_2 = '', $_var_3 = 0)
{
	$_var_2 = md5(empty($_var_2) ? home_url('/') : $_var_2);
	$_var_1 = base64_encode($_var_1);
	$_var_4 = 0;
	$_var_5 = strlen($_var_1);
	$_var_6 = strlen($_var_2);
	$_var_7 = '';
	for ($_var_8 = 0; $_var_8 < $_var_5; $_var_8++) {
		if ($_var_4 == $_var_6) {
			$_var_4 = 0;
		}
		$_var_7 .= substr($_var_2, $_var_4, 1);
		$_var_4++;
	}
	$_var_9 = sprintf('%010d', $_var_3 ? $_var_3 + time() : 0);
	for ($_var_8 = 0; $_var_8 < $_var_5; $_var_8++) {
		$_var_9 .= chr(ord(substr($_var_1, $_var_8, 1)) + ord(substr($_var_7, $_var_8, 1)) % 256);
	}
	return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($_var_9));
}
function decrypt($_var_10, $_var_11 = '')
{
	$_var_11 = md5(empty($_var_11) ? home_url('/') : $_var_11);
	$_var_10 = str_replace(array('-', '_'), array('+', '/'), $_var_10);
	$_var_12 = strlen($_var_10) % 4;
	if ($_var_12) {
		$_var_10 .= substr('====', $_var_12);
	}
	$_var_10 = base64_decode($_var_10);
	$_var_13 = substr($_var_10, 0, 10);
	$_var_10 = substr($_var_10, 10);
	if ($_var_13 > 0 && $_var_13 < time()) {
		return '';
	}
	$_var_14 = 0;
	$_var_15 = strlen($_var_10);
	$_var_16 = strlen($_var_11);
	$_var_17 = $_var_18 = '';
	for ($_var_19 = 0; $_var_19 < $_var_15; $_var_19++) {
		if ($_var_14 == $_var_16) {
			$_var_14 = 0;
		}
		$_var_17 .= substr($_var_11, $_var_14, 1);
		$_var_14++;
	}
	for ($_var_19 = 0; $_var_19 < $_var_15; $_var_19++) {
		if (ord(substr($_var_10, $_var_19, 1)) < ord(substr($_var_17, $_var_19, 1))) {
			$_var_18 .= chr(ord(substr($_var_10, $_var_19, 1)) + 256 - ord(substr($_var_17, $_var_19, 1)));
		} else {
			$_var_18 .= chr(ord(substr($_var_10, $_var_19, 1)) - ord(substr($_var_17, $_var_19, 1)));
		}
	}
	return base64_decode($_var_18);
}
function get_server_url($_var_20 = 0)
{
	if ($_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
		$_var_21 = 'localhost';
	} else {
		$_var_21 = $_SERVER['SERVER_NAME'];
	}
	$_var_22 = array('com', 'cn', 'net', 'org', 'gov');
	$_var_23 = explode('.', $_var_21);
	$_var_24 = array();
	$_var_24[] = array_pop($_var_23);
	$_var_24[] = array_pop($_var_23);
	if (in_array($_var_24[1], $_var_22)) {
		$_var_25 = array_pop($_var_23);
		$_var_24[1] = $_var_25 . '.' . $_var_24[1];
	}
	if (!$_var_20) {
		return $_var_24;
	} else {
		return $_var_24[1] . '.' . $_var_24[0];
	}
}
function get_info_admin()
{
	if ($_GET['qzhai'] == 'admin') {
		$_var_26 = wp_get_theme();
		echo '<meta name="QSN" content="' . get_server_url(1) . '"/> ';
		echo '<meta name="QSN_S" content="' . $_SERVER['SERVER_NAME'] . '"/> ';
		echo '<meta name="QK" content="' . of_get('key') . '"/> ';
		echo '<meta name="QIS" content=\'' . json_encode(Q_is(of_get('key'))) . '\'/> ';
		echo '<meta name="QTN" content="' . $_var_26->get('Version') . '"/> ';
		echo '<meta name="PHPN" content="' . PHP_VERSION . '"/> ';
	}
}
add_action('wp_head', 'get_info_admin');
function getfoot($_var_27)
{
	if (!is_pro()) {
		global $key;
		if ($_var_27 == 'head') {
			$key['head'] = ture;
		}
		if ($_var_27 == 'foot') {
			$key['foot'] = ture;
		}
		$key['key'] = md5(floor(time() / 100) . 'asdmiasndaifjai');
	}
	if (of_get('footer') && of_get('is_copy') != 3) {
		echo ' - ';
	}
	if (of_get('is_link')) {
		echo '<a href="#my-link" data-uk-modal>友情链接</a> ';
		if (of_get('is_copy') != 3) {
			echo ' - ';
		}
	}
	if (of_get('is_copy') == 1 || !of_get('is_copy')) {
		echo '<a href="http://qzhai.net" target="_black" title="主题制作:衫小寨" data-uk-tooltip="{pos:\'bottom\'}"> 衫小寨</a>';
	} else {
		if (of_get('is_copy') == 2) {
			echo '<a href="http://qzhai.net" target="_black" title="主题制作:衫小寨" data-uk-tooltip="{pos:\'bottom\'}"> <i class="uk-icon-wordpress" style="font-size:14px;"></i></a>';
		} else {
			if (of_get('is_copy') == 3) {
				$_var_28 = Q_is(of_get('key'));
				if (!$_var_28['state']) {
					echo '<a href="http://qzhai.net" target="_black" title="主题制作:衫小寨" data-uk-tooltip="{pos:\'bottom\'}"> 衫小寨</a>';
				}
			} else {
				if (of_get('is_copy') == 4) {
					echo '<a href="http://qzhai.net" target="_black" title="主题制作:衫小寨" data-uk-tooltip="{pos:\'bottom\'}"> Theme by Qzhai</a>';
				}
			}
		}
	}
}
function copy__()
{
	if (of_get('record') || of_get('copyright')) {
		echo '<a href="#" title="' . of_get('record') . '" data-uk-tooltip="{pos:\'bottom\'}"><i class="uk-icon-copyright"> </i> ';
		if (of_get('copyright')) {
			$_var_29 = date('Y', time());
			echo $_var_29 . ' ' . of_get('copyright') . ' ';
		}
		echo '</a>';
	}
}
function mytheme_enqueue_style()
{
	if (of_get('no_shadow')) {
		wp_enqueue_style('qzhai', get_template_directory_uri() . '/css/style.css?qzhai=' . time());
	} else {
		wp_enqueue_style('qzhai', get_template_directory_uri() . '/css/style_o.css?qzhai=' . time());
	}
	if (of_get('is_code')) {
		$_var_30 = 'sunburst';
		if (of_get('code_style') && of_get('code_style') != $_var_30) {
			$_var_30 = of_get('code_style');
		}
		wp_enqueue_style('highlight', get_template_directory_uri() . '/css/code/' . $_var_30 . '.css');
	}
	wp_enqueue_style('qzhai_icont', '//at.alicdn.com/t/font_ph8abo6zeqoxbt9.css');
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_style');
function _set_qzhai_color()
{
	$_var_31 = 0;
	$_var_32 = '<style>';
	if (of_get('qzhai_color_bj') && of_get('qzhai_color_bj') != '#44cef6') {
		$_var_31 = 1;
		$_var_32 .= '
            a:hover,
            .qzhai_a:hover{
                color: ' . of_get('qzhai_color_bj') . ' !important;
            }
            #sidebar #wp-calendar th a:hover, #sidebar #wp-calendar td a:hover, #sidebar #wp-calendar th a:focus, #sidebar #wp-calendar td a:focus,
            .qzhai_bgc,
            .qzhai_bgc_hover:hover,
            .qzhai_bgc_hover:focus,
            #sidebar ul.ul > li > ul li:hover,
            #sidebar ul.ul > li .menu li:hover,
            #head > div > div > .uk-nav > li.uk-active > a,
            .uk-pagination>.uk-active>span,
            .tag a:hover{
                background-color: ' . of_get('qzhai_color_bj') . ' !important;
                color: #fff !important;
            }
        ';
	}
	if (of_get('loop_img_style') == 'A') {
		$_var_31 = 1;
		$_var_32 .= '
        #list img,#list .bg{
        opacity: .7 !important;
        -moz-transition: all 0.2s ease-in;
        -webkit-transition: all 0.2s ease-in;
        -o-transition: all 0.2s ease-in;
        -ms-transition: all 0.2s ease-in;
        transition: all 0.2s ease-in;
      }
      #list img:hover,#list .bg:hover{
        opacity: 1 !important;
      }';
	}
	if (of_get('loop_img_style') == 'B') {
		$_var_31 = 1;
		$_var_32 .= '
        #list img,#list .bg{
        -webkit-filter: grayscale(100%);
        -moz-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        -o-filter: grayscale(100%);

        filter: grayscale(100%);

        filter: gray;
      }';
	}
	$_var_32 .= '</style>';
	if ($_var_31) {
		echo $_var_32;
	}
}
add_action('wp_head', '_set_qzhai_color');
function myfooter()
{
	if (!is_pro()) {
		global $key;
		if (!$key['head'] || !$key['foot']) {
			if (!$key['head']) {
				$_var_33 = '0x01213801';
			} else {
				if (!$key['foot']) {
					$_var_33 = '0x01213802';
				} else {
					$_var_33 = '0x00000000';
				}
			}
			$_var_34 = wp_get_theme();
			$_var_35 = json_encode($key);
			$_var_36 = '
                <script type="text/javascript">
                    $("#main").html("Err!");
                    console.log("主识别码:' . md5(floor(time() / 100) . 'asdmiasndaifjai') . '");
                    console.log("标识码:' . strtoupper(substr(md5($_SERVER['SERVER_NAME'] . 'qzhai'), 10, 15)) . '");
                    console.log("主题版本号:' . $_var_34->get('Version') . '");
                    console.log("PHP版本号:' . PHP_VERSION . '");
                    console.log(' . $_var_35 . ');
                </script>
    			<div class="uk-contrast uk-vertical-align uk-text-center" style="position:fixed;left:0;top:0;width:100%;height:100%;background:#000;display:blick ;">
    				<div class="uk-vertical-align-middle uk-vertical-align-middle" style="width:400px;">
    					<i class="uk-icon-times-circle" style="font-size:10em;"></i>
    			   	 	<h1>您的操作已经越界！</h1>
    			   	 	<span>尊敬的站长：您的操作越界导致触发了主题保护界面，想要恢复请联系作者 <a href="http://qzhai.net/about">点击进入</a></span>
                        <p>Error:' . $_var_33 . '</p>
                        <span>如果并非改动过代码请尝试关闭插件</span>
    			    </div>
    			</div>';
			echo $_var_36;
		} else {
			if ($key['key'] != md5(floor(time() / 100) . 'asdmiasndaifjai')) {
				$_var_36 = '
                <script type="text/javascript">
                    $("#main").html("Err!");
                </script>
                <div class="uk-contrast uk-vertical-align uk-text-center" style="position:fixed;left:0;top:0;width:100%;height:100%;background:#000;display:blick ;">
                    <div class="uk-vertical-align-middle uk-vertical-align-middle" style="width:400px;">
                        <i class="uk-icon-times-circle" style="font-size:10em;"></i>
                        <h1>出了点小问题</h1>
                        <span>尊敬的站长：为了在一个盗版横行的天朝里艰难的活下去，主题不得不安装了版权保护机制，这导致缓存类插件无法使用，当然升级到高级版可以可以去除保护机制  <br><a href="http://qzhai.net/about">点击进入</a></span>
                        <p>Error:0x01213803</p>
                    </div>
                </div>';
				echo $_var_36;
			}
		}
	}
	if (of_get('is_code')) {
		wp_enqueue_script('highlight', get_template_directory_uri() . '/js/highlight.pack.js');
	}
	wp_enqueue_script('qzhai', get_template_directory_uri() . '/js/app.js');
}
add_action('wp_footer', 'myfooter');
function add_scripts()
{
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js');
	wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'add_scripts');
require_once TEMPLATEPATH . '/theme-updates/theme-update-checker.php';
$wpdaxue_update_checker = new ThemeUpdateChecker('No.7_qzhai', 'http://think.qzhai.net/0up/No.7_qzhai/info.json');
include 'pagination.php';
include 'qzhai_menu.class.php';
if (function_exists('register_nav_menus')) {
	register_nav_menus(array('main-menu' => '主菜单', 'link' => '友情链接'));
}
function menu_qzhai($_var_37)
{
	if (has_nav_menu('main-menu')) {
		if ($_var_37 == 'p') {
			wp_nav_menu(array('theme_location' => 'main-menu', 'menu_id' => 'nav-top', 'menu_class' => 'nav uk-nav uk-hidden-small', 'container' => 'ul', 'walker' => new qzhai_menu(), 'depth' => '2'));
		} else {
			wp_nav_menu(array('theme_location' => 'main-menu', 'menu_id' => 'nav-top-s', 'menu_class' => 'uk-nav uk-nav-offcanvas', 'container' => 'ul', 'walker' => new qzhai_menu_s(), 'items_wrap' => '<ul id="%1$s" class="%2$s" data-uk-nav >%3$s</ul>', 'depth' => '2'));
		}
	} else {
		echo '<ul class="nav uk-nav uk-hidden-small"><li><a href="#">请设置菜单</a></li></ul>';
	}
}
function aurelius_comment($_var_38, $_var_39, $_var_40)
{
	$GLOBALS['comment'] = $_var_38;
	echo '<li id="li-comment-';
	comment_ID();
	echo '">';
	echo '<article class="uk-comment">';
	if (function_exists('get_avatar') && get_option('show_avatars')) {
		echo get_avatar($_var_38, 50);
	}
	echo '<h6 class="uk-comment-title uk-clearfix">';
	printf(__('<cite>%s</cite>'), get_comment_author_link());
	echo '<time> ';
	echo get_comment_time('Y-m-d H:i');
	echo '</time>';
	echo '<span class="uk-comment-meta uk-float-right qzhai_bgc">';
	edit_comment_link('修改 ');
	comment_reply_link(array_merge($_var_39, array('reply_text' => '回复 ', 'depth' => $_var_40, 'max_depth' => $_var_39['max_depth'])));
	echo '</span>';
	echo '</h6>';
	if ($_var_38->comment_approved == '0') {
		echo '<div class="uk-alert" data-uk-alert>';
		echo '<a href="" class="uk-alert-close uk-close"></a>';
		echo '你的评论正在审核，稍后会显示出来！';
		echo '</div>';
	} else {
	}
	comment_text();
	echo '</article>';
	echo '</li>';
}
function get_key($_var_41)
{
	$_var_41 = md5(time() . $_var_41);
	return $_var_41;
}
class hacklog_archives
{
	function GetPosts()
	{
		global $wpdb;
		if ($_var_42 = wp_cache_get('posts', 'ihacklog-clean-archives')) {
			return $_var_42;
		}
		$_var_43 = "SELECT DISTINCT ID,post_date,post_date_gmt,comment_count,comment_status,post_password FROM {$wpdb->posts} WHERE post_type='post' AND post_status = 'publish' AND comment_status = 'open'";
		$_var_44 = $wpdb->get_results($_var_43, OBJECT);
		foreach ($_var_44 as $_var_45 => $_var_46) {
			$_var_42[mysql2date('Y.m', $_var_46->post_date)][] = $_var_46;
			$_var_44[$_var_45] = null;
		}
		$_var_44 = null;
		wp_cache_set('posts', $_var_42, 'ihacklog-clean-archives');
		return $_var_42;
	}
	function PostList($_var_47 = array())
	{
		global $wp_locale;
		global $hacklog_clean_archives_config;
		$_var_47 = shortcode_atts(array('usejs' => $hacklog_clean_archives_config['usejs'], 'monthorder' => $hacklog_clean_archives_config['monthorder'], 'postorder' => $hacklog_clean_archives_config['postorder'], 'postcount' => '1', 'commentcount' => '1'), $_var_47);
		$_var_47 = array_merge(array('usejs' => 1, 'monthorder' => 'new', 'postorder' => 'new'), $_var_47);
		$_var_48 = $this->GetPosts();
		'new' == $_var_47['monthorder'] ? krsort($_var_48) : ksort($_var_48);
		foreach ($_var_48 as $_var_49 => $_var_50) {
			$_var_51 = array();
			foreach ($_var_50 as $_var_52) {
				$_var_51[] = $_var_52->post_date_gmt;
			}
			$_var_53 = 'new' == $_var_47['postorder'] ? SORT_DESC : SORT_ASC;
			array_multisort($_var_51, $_var_53, $_var_50);
			$_var_48[$_var_49] = $_var_50;
			unset($_var_50);
		}
		$_var_54 = '<div class="car-container';
		if (1 == $_var_47['usejs']) {
			$_var_54 .= ' car-collapse';
		}
		$_var_54 .= '">' . '
';
		if (1 == $_var_47['usejs']) {
			$_var_54 .= '<a href="#" class="car-toggler">展开所有月份' . '</a>

';
		}
		$_var_54 .= '<ul id="car-list">' . '
';
		$_var_55 = true;
		foreach ($_var_48 as $_var_56 => $_var_48) {
			list($_var_57, $_var_50) = explode('.', $_var_56);
			$_var_58 = true;
			foreach ($_var_48 as $_var_52) {
				if (true == $_var_58) {
					$_var_54 .= '  <li><span class="car-yearmonth" data-uk-sticky="{boundary: true}">+ ' . sprintf(__('%1$s %2$d'), $wp_locale->get_month($_var_50), $_var_57);
					if ('0' != $_var_47['postcount']) {
						$_var_54 .= ' <span title="文章数量">(共' . count($_var_48) . '篇文章)</span>';
					}
					$_var_54 .= '</span>
       <ul class=\'car-monthlisting\'>
';
					$_var_58 = false;
				}
				$_var_54 .= '          <li>' . mysql2date('d', $_var_52->post_date) . '日: <a target="_blank" href="' . get_permalink($_var_52->ID) . '">' . get_the_title($_var_52->ID) . '</a>';
				if ('0' != $_var_47['commentcount'] && (0 != $_var_52->comment_count || 'closed' != $_var_52->comment_status) && empty($_var_52->post_password)) {
					$_var_54 .= ' <span title="评论数量">(' . $_var_52->comment_count . '条评论)</span>';
				}
				$_var_54 .= '</li>
';
			}
			$_var_54 .= '      </ul>
   </li>
';
		}
		$_var_54 .= '</ul>
</div>
';
		return $_var_54;
	}
	function PostCount()
	{
		$_var_59 = wp_count_posts('post');
		return number_format_i18n($_var_59->publish);
	}
}
if (!empty($post->post_content)) {
	$all_config = explode(';', $post->post_content);
	foreach ($all_config as $item) {
		$temp = explode('=', $item);
		$hacklog_clean_archives_config[trim($temp[0])] = htmlspecialchars(strip_tags(trim($temp[1])));
	}
} else {
	$hacklog_clean_archives_config = array('usejs' => 1, 'monthorder' => 'new', 'postorder' => 'new');
}
$hacklog_archives = new hacklog_archives();
function link_qzhai()
{
	echo '<div id="my-link" class="uk-modal">';
	echo '<div class="uk-modal-dialog">';
	echo '<a class="uk-modal-close uk-close"></a>';
	echo '<h2>友情链接</h2>';
	if (has_nav_menu('link')) {
		wp_nav_menu(array('theme_location' => 'link', 'menu_id' => 'link_qzhai', 'menu_class' => ' uk-subnav uk-subnav-line', 'container' => 'ul', 'walker' => new qzhai_menu(), 'depth' => '1'));
	} else {
		echo '<ul class="uk-subnav uk-subnav-line"><li><a href="#">请在后台新建菜单并勾选友情链接</a></li></ul>';
	}
	echo '</div>';
	echo '</div>';
}
if (of_get('is_link')) {
	add_action('footer_qzhai', 'link_qzhai');
}
function set_head()
{
	echo '<div id="head"';
	if (!wp_is_mobile()) {
		echo 'data-uk-sticky="{boundary: true,top:80}"';
	}
	echo '>';
	echo '<div id="op_head">';
	echo '<div class="uk-panel bs" id="op_hed">';
	echo '<div class="tx">';
	if (of_get('is_details')) {
		echo '<a href="#my-head" data-uk-modal>';
	}
	echo '<div class="avatar_">';
	if (of_get('avatar') != '') {
		echo '<img src="';
		echo of_get('avatar');
		echo '" />';
	} else {
		echo '<img src="';
		echo get_template_directory_uri();
		echo '/img/default.jpg" />';
	}
	if (of_get('is_details')) {
		echo '</a>';
	}
	echo '</div>';
	echo '</div>';
	echo '<h1 class="uk-panel-title"><a href="';
	bloginfo('url');
	echo '">';
	bloginfo('name');
	echo '</a></h1>';
	do_action('description_qzhai');
	echo '<div class="my uk-grid-collapse uk-grid uk-grid-width-1-3">';
	echo '<div>';
	echo '<span>';
	$_var_60 = wp_count_posts();
	echo $_var_61 = $_var_60->publish;
	echo '</span>';
	echo '<span><i class="uk-icon-file-text"></i></span>';
	echo '<a href="';
	the_permalink(of_get('page_archive'));
	echo '" title="文章" data-uk-tooltip="{pos:\'bottom\'}"></a>';
	echo '</div>';
	echo '<div>';
	echo '<span>';
	echo $_var_62 = wp_count_terms('category');
	echo '</span>';
	echo '<span><i class="uk-icon-folder"></i></span>';
	echo '<a href="';
	the_permalink(of_get('page_category'));
	echo '" title="分类" data-uk-tooltip="{pos:\'bottom\'}"></a>';
	echo '</div>';
	echo '<div>';
	echo '<span>';
	echo $_var_63 = wp_count_terms('post_tag');
	echo '</span>';
	echo '<span><i class="uk-icon-tags"></i></span>';
	echo '<a href="';
	the_permalink(of_get('page_tag'));
	echo '" title="标签" data-uk-tooltip="{pos:\'bottom\'}"></a>';
	echo '</div>';
	echo '</div>';
	echo '<a href="#s_s" class="s_s uk-navbar-toggle uk-hidden-large" data-uk-offcanvas></a>';
	if (!wp_is_mobile()) {
		menu_qzhai('p');
		echo '<form role="search" class="s uk-form uk-hidden-small" id="searchform" method="get" action="';
		bloginfo('wpurl');
		echo '/">';
		echo '<input class="uk-width-1-1 qzhai_bgc_hover ';
		if (is_search()) {
			echo 'ace';
		}
		echo '" type="text" value="';
		the_search_query();
		echo '" name="s" id="s" placeholder="';
		if (of_get('soso')) {
			echo of_get('soso');
		} else {
			echo '搜索';
		}
		echo '"';
		if (of_get('soso_info')) {
			echo ' title="' . of_get('soso_info') . '" data-uk-tooltip="{pos:\'bottom\'}"';
		}
		echo '/>';
		echo '</form>';
	} else {
		echo '<div id="s_s" class="uk-offcanvas">';
		echo '<div class="uk-offcanvas-bar uk-offcanvas-bar-flip">';
		menu_qzhai('s');
		echo '<form class="uk-form" id="searchform" method="get" action="';
		bloginfo('wpurl');
		echo '">';
		echo '<input class="uk-width-1-1 ';
		if (is_search()) {
			echo 'ace';
		}
		echo '" type="text" value="';
		the_search_query();
		echo '" name="s" id="s" placeholder="';
		if (of_get('soso')) {
			echo of_get('soso');
		} else {
			echo '搜索';
		}
		echo '" />';
		echo '</form>';
		echo '</div>';
		echo '</div>';
	}
	if (of_get('is_music')) {
		echo '<a href="javascript:;" id="op_m" lock="open" class="uk-icon-music"></a>';
	}
	echo '</div>';
	if (of_get('is_music') && !wp_is_mobile()) {
		echo '<div class="op" style="width:80%">';
		echo of_get('music_text');
		echo '</div>';
	}
	echo '</div>';
	echo '<div class="ft uk-hidden-small">';
	echo '<p>';
	copy__();
	echo of_get('footer');
	getfoot('head');
	echo '</p>';
	echo '</div>';
}
add_action('head_qzhai', 'set_head');
function div_head()
{
	$_var_64 = Q_is(of_get('key'));
	if ($_var_64['state']) {
		$_var_65 = of_get('is_widget');
	} else {
		$_var_65 = 0;
	}
	if (!$_var_65) {
		echo '<div class="uk-width-small-1-1 uk-width-medium-1-4 uk-width-large-1-5 posr">';
	} else {
		echo '<div class="uk-width-small-1-1 uk-width-medium-1-4 uk-width-large-1-6 posr">';
	}
}
function div_cotent()
{
	$_var_66 = Q_is(of_get('key'));
	if ($_var_66['state']) {
		$_var_67 = of_get('is_widget');
	} else {
		$_var_67 = 0;
	}
	if ($_var_67) {
		if (wp_is_mobile() && !of_get('is_widget_mobile')) {
			echo '<div id="content" class="uk-width-small-1-1 uk-width-medium-3-4 uk-width-large-4-5 uk-grid uk-grid-collapse">
            <div  class=" uk-width-1-1">';
		} else {
			echo '<div id="content" class="uk-width-small-1-1 uk-width-medium-3-4 uk-width-large-5-6 uk-grid uk-grid-collapse">
            <div class="uk-width-small-1-1 uk-width-medium-3-4 ">';
		}
	} else {
		echo '<div id="content" class="uk-width-small-1-1 uk-width-medium-3-4 uk-width-large-4-5 uk-grid uk-grid-collapse">
            <div  class=" uk-width-1-1">';
	}
}
function wp_max_width()
{
	$_var_68 = Q_is(of_get('key'));
	if ($_var_68['state']) {
		$_var_69 = of_get('is_widget');
	} else {
		$_var_69 = 0;
	}
	if ($_var_69) {
		if (wp_is_mobile() && !of_get('is_widget_mobile')) {
			echo '960px';
		} else {
			echo '1300px';
		}
	} else {
		echo '960px';
	}
}
function info_text()
{
	echo '<script>UIkit.notify("您的激活码即将到期，请及时购买！【此消息仅管理员可见】",{timeout:"50000",status:"danger",pos:"bottom-right"});</script>';
}
function info_()
{
	$_var_70 = Q_is(of_get('key'));
	if ($_var_70['state']) {
		$_var_71 = floor($_var_70['time'] / 86400);
		if ($_var_71 < 3 && current_user_can('manage_options')) {
			add_action('footer_qzhai', 'info_text');
		}
	}
}
info_();
$www = Q_is(of_get('key'));
if (!$www['state']) {
	return;
}
function add_AD()
{
	echo '<div class="uk-alert" data-uk-alert>';
	echo '<p>警告！</p>';
	echo '<p>您目前使用的是旧版本的激活码，请联系卖家更换新版本的激活码！对此造成的不便表示歉意！</p>';
	echo '<p>如果您是通过淘宝购买的请直接联系客服。前期通过转账购买的请在群里（535689380）直接私信群主</p>';
	echo '</div>';
}
$xxx = Q_is(of_get('key'));
if ($xxx['state'] && $xxx['time'] == 'A') {
	add_action('optionsframework_after', 'add_AD');
}
if (of_get('is_widget')) {
	if (function_exists('register_sidebar')) {
		register_sidebar(array('name' => '通用边栏（所有页面）', 'id' => 'widget_home', 'before_widget' => '<li>', 'after_widget' => '</li>', 'before_title' => '<h4>', 'after_title' => '</h4>'));
		register_sidebar(array('name' => '首页边栏下方-固定(随滚动条)', 'id' => 'widget_home_sticky', 'before_widget' => '<li>', 'after_widget' => '</li>', 'before_title' => '<h4>', 'after_title' => '</h4>'));
		register_sidebar(array('name' => '文章页边栏下方-固定(随滚动条)', 'id' => 'widget_single_sticky', 'before_widget' => '<li>', 'after_widget' => '</li>', 'before_title' => '<h4>', 'after_title' => '</h4>'));
		register_sidebar(array('name' => '页面页边栏下方-固定(随滚动条)', 'id' => 'widget_page_sticky', 'before_widget' => '<li>', 'after_widget' => '</li>', 'before_title' => '<h4>', 'after_title' => '</h4>'));
	}
}
include 'widget.php';
function widget_Qzhai($_var_72)
{
	$_var_73 = Q_is(of_get('key'));
	if (!$_var_73['state']) {
		return;
	}
	if (!of_get('is_widget')) {
		return;
	}
	if (wp_is_mobile() && !of_get('is_widget_mobile')) {
		return;
	}
	if (!wp_is_mobile()) {
		$_var_74 = 'ulsid';
	} else {
		$_var_74 = '';
	}
	echo '<div id="sidebar" class="uk-width-small-1-1 uk-width-medium-1-4">';
	if (!(of_get('is_directory') && is_single())) {
		echo '<ul class="ul">';
		if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget_home')) {
		}
		echo '</ul>';
	}
	echo '<ul id="' . $_var_74 . '" class="ul">';
	do_action('widget_qzhai');
	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget_' . $_var_72 . '_sticky')) {
	}
	echo '</ul>';
	echo '</div>';
}
function unregister_rss_widget()
{
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'unregister_rss_widget');
function set_newuser_cookie()
{
	$_var_75 = Q_is(of_get('key'));
	if (!$_var_75['state']) {
		return;
	}
	if (!isset($_COOKIE['sitename_newvisitor'])) {
		setcookie('sitename_newvisitor', 1, time() + 10800, COOKIEPATH, COOKIE_DOMAIN, false);
	}
}
add_action('init', 'set_newuser_cookie');
function notice_qzhai($_var_76, $_var_77 = 'info', $_var_78 = '8000', $_var_79 = 'bottom-right')
{
	if (!isset($_COOKIE['sitename_newvisitor'])) {
		echo '<script>setTimeout(function(){UIkit.notify("' . $_var_76 . '",{timeout:"' . $_var_78 . '",status:"' . $_var_77 . '",pos:"' . $_var_79 . '"});},3000);</script>';
	}
}
function my_head()
{
	$_var_80 = Q_is(of_get('key'));
	if (!$_var_80['state']) {
		return;
	}
	echo '<div id="my-head" class="uk-modal">
        <div class="uk-modal-dialog-blank uk-height-viewport">
            <a class="uk-modal-close uk-close"></a>
            <div class="uk-grid uk-flex-middle" data-uk-grid-margin="">
                <div class="uk-width-medium-1-2 uk-height-viewport uk-cover-background uk-row-first" style="background-image: url(\' ' . of_get('details_bg') . ' \');"></div>
                <div class="uk-width-medium-1-2 p">
                    ' . nl2br(of_get('details')) . '
                </div>
            </div>
        </div>
    </div>';
}
if (of_get('is_details')) {
	add_action('head_qzhai', 'my_head');
}
function loop_book($_var_81 = false)
{
	$_var_82 = Q_is(of_get('key'));
	if (!$_var_82['state'] || wp_is_mobile()) {
		loop_img();
		return;
	}
	if (have_posts()) {
		if ($_var_81) {
			$_var_83 = 'widget';
		}
		echo '<ul class="book uk-grid uk-grid-width-1-3 ' . $_var_83 . '">';
		$_var_84 = 1;
		while (have_posts()) {
			the_post();
			echo '<li class="class_';
			the_category_ID();
			echo '" >';
			echo '<h1 class="uk-text-truncate"><a href="';
			the_permalink();
			echo '" >';
			the_title();
			echo '</a></h1>';
			echo '<time>';
			the_time('Y年n月j日');
			echo '</time><div class="img"><div>';
			if (has_post_thumbnail()) {
				echo '<a href="';
				the_permalink();
				echo '">';
				the_post_thumbnail('thumbnail_loop_book');
				echo '</a>';
			} else {
				if ($_var_85 = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image'))) {
					echo '<a href="';
					the_permalink();
					echo '">';
					$_var_86 = current($_var_85);
					$_var_86 = wp_get_attachment_image_src($_var_86->ID, array(140, 160));
					echo '<img src="' . $_var_86[0] . '"  />';
					echo '</a>';
				} else {
					echo '<img src="http://www.getuikit.net/docs/images/placeholder_200x200.svg"  />';
				}
			}
			echo '</div></div>';
			if ($_var_84 == 1 || ($_var_84 - 1) % 3 == 0) {
				echo '<div class="banlf"><span></span></div>';
				echo '<div class="ban_magin"></div>';
			}
			echo '</li>';
			$_var_84++;
		}
		echo '</ul>';
	} else {
		if (of_get('diy_404')) {
			echo of_get('diy_404');
		} else {
			echo '<p class="_404">没发现什么...</p>';
		}
	}
}
function exclude_category_home($_var_87)
{
	if (of_get('book_list')) {
		$_var_88 = '';
		foreach (of_get('book_list') as $_var_89 => $_var_90) {
			if ($_var_90 == 1) {
				$_var_88 .= '-' . $_var_89 . ',';
			}
		}
		$_var_88 = substr($_var_88, 0, -1);
	}
	if ($_var_87->is_home) {
		$_var_87->set('cat', $_var_88);
	}
	return $_var_87;
}
add_filter('pre_get_posts', 'exclude_category_home');
function custom_excerpt_length($_var_91)
{
	return of_get('abstract_num');
}
add_filter('excerpt_length', 'custom_excerpt_length');
function zanting()
{
	$_var_92 = Q_is(of_get('key'));
	if (!$_var_92['state']) {
		return;
	}
	echo '<script>UIkit.notify("您的网站已开启暂停!",{timeout:"50000",status:"danger",pos:"bottom-right"});</script>';
}
function C_qzhai()
{
	$_var_93 = Q_is(of_get('key'));
	if (!$_var_93['state']) {
		return;
	}
	if (of_get('is_c')) {
		if (current_user_can('manage_options')) {
			add_action('footer_qzhai', 'zanting');
		} else {
			echo '<div class="uk-contrast uk-vertical-align uk-text-center" style="position:fixed;left:0;top:0;width:100%;height:100%;background:#000;display:blick ;">';
			echo '<div class="uk-vertical-align-middle uk-vertical-align-middle" style="width:400px;">';
			echo '<i class="uk-icon-times-circle" style="font-size:10em;"></i>';
			echo '<p>' . nl2br(of_get('act')) . '</p>';
			echo '</div>';
			echo '</div>';
			exit;
		}
	}
}
function reward_qzhai()
{
	$_var_94 = Q_is(of_get('key'));
	if (!$_var_94['state']) {
		return;
	}
	if (of_get('is_reward')) {
		echo '<div class="reward">';
		echo '<a href="#reward" class="rewards uk-button" >赏</a>';
		echo '</div>';
		echo '<div id="reward" class="uk-modal">';
		echo '<div class="uk-modal-dialog">';
		echo '<a class="uk-modal-close uk-close"></a>';
		echo '<div class="uk-modal-header">感谢打赏!</div>';
		if (of_get('wzxn_reward')) {
			echo '<div class="uk-thumbnail">';
			echo '<img src="' . of_get('wzxn_reward') . '" >';
			echo '<div class="uk-thumbnail-caption">微信</div>';
			echo '</div>';
		}
		if (of_get('vifubk_reward')) {
			echo '<div class="uk-thumbnail">';
			echo '<img src="' . of_get('vifubk_reward') . '" >';
			echo '<div class="uk-thumbnail-caption">支付宝</div>';
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}
}
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like()
{
	$_var_95 = Q_is(of_get('key'));
	if (!$_var_95['state']) {
		return;
	}
	global $wpdb, $post;
	$_var_96 = $_POST['um_id'];
	$_var_97 = $_POST['um_action'];
	if ($_var_97 == 'ding') {
		$_var_98 = get_post_meta($_var_96, 'bigfa_ding', true);
		$_var_99 = time() + 99999999;
		$_var_100 = $_SERVER['HTTP_HOST'] != 'localhost' ? $_SERVER['HTTP_HOST'] : false;
		setcookie('bigfa_ding_' . $_var_96, $_var_96, $_var_99, '/', $_var_100, false);
		if (!$_var_98 || !is_numeric($_var_98)) {
			update_post_meta($_var_96, 'bigfa_ding', 1);
		} else {
			update_post_meta($_var_96, 'bigfa_ding', $_var_98 + 1);
		}
		echo get_post_meta($_var_96, 'bigfa_ding', true);
	}
	die;
}
function f_qzhai()
{
	$_var_101 = Q_is(of_get('key'));
	if (!$_var_101['state']) {
		return;
	}
	$_var_102 = get_the_content();
	$_var_103 = wp_trim_words($_var_102, 60, '...');
	$_var_104 = get_the_permalink();
	$_var_105 = get_the_title();
	$_var_106 = wp_get_attachment_image_src(get_post_thumbnail_id($_var_107->ID), 'full');
	if ($_var_106) {
		$_var_108 = '&pic=' . $_var_106[0];
	} else {
		$_var_108 = '';
	}
	echo '<ul class="fen">';
	echo '<li><a href="http://www.jiathis.com/send/?webid=tsina&url=' . $_var_104 . '&title=' . $_var_105 . '&summary=' . $_var_103 . $_var_108 . '" target="_blank" title="分享到新浪微博" data-uk-tooltip><i class="uk-icon-weibo"></i></a></li>';
	echo '<li><a href="http://www.jiathis.com/send/?webid=weixin&url=' . $_var_104 . '&title=' . $_var_105 . '&summary=' . $_var_103 . $_var_108 . '" target="_blank" title="分享到微信" data-uk-tooltip><i class="uk-icon-weixin"></i></a></li>';
	echo '<li><a href="http://www.jiathis.com/send/?webid=renren&url=' . $_var_104 . '&title=' . $_var_105 . '&summary=' . $_var_103 . $_var_108 . '" target="_blank" title="分享到人人网" data-uk-tooltip><i class="uk-icon-renren"></i></a></li>';
	echo '<li><a href="http://www.jiathis.com/send/?webid=tqq&url=' . $_var_104 . '&title=' . $_var_105 . '&summary=' . $_var_103 . $_var_108 . '" target="_blank" title="分享到腾讯微博" data-uk-tooltip><i class="uk-icon-tencent-weibo"></i></a></li>';
	echo '<li><a href="http://www.jiathis.com/send/?webid=fb&url=' . $_var_104 . '&title=' . $_var_105 . '&summary=' . $_var_103 . $_var_108 . '" target="_blank" title="分享到facebook" data-uk-tooltip><i class="uk-icon-facebook-f"></i></a></li>';
	echo '<li><a href="http://www.jiathis.com/send/?webid=twitter&url=' . $_var_104 . '&title=' . $_var_105 . '&summary=' . $_var_103 . $_var_108 . '" target="_blank" title="分享到twitter" data-uk-tooltip><i class="uk-icon-twitter"></i></a></li>';
	if (of_get('is_reward')) {
		echo '<li><a href="#reward" class="rewards" title="打赏作者" data-uk-tooltip><i class="uk-icon-rmb"></i></a></li>';
		echo '<div id="reward" class="uk-modal">';
		echo '<div class="uk-modal-dialog">';
		echo '<a class="uk-modal-close uk-close"></a>';
		echo '<div class="uk-modal-header">感谢打赏!</div>';
		if (of_get('wzxn_reward')) {
			echo '<div class="uk-thumbnail">';
			echo '<img src="' . of_get('wzxn_reward') . '" >';
			echo '<div class="uk-thumbnail-caption">微信</div>';
			echo '</div>';
		}
		if (of_get('vifubk_reward')) {
			echo '<div class="uk-thumbnail">';
			echo '<img src="' . of_get('vifubk_reward') . '" >';
			echo '<div class="uk-thumbnail-caption">支付宝</div>';
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}
	echo '<li><a href="http://www.jiathis.com/send/?webid=ishare&url=' . $_var_104 . '&title=' . $_var_105 . '&summary=' . $_var_103 . $_var_108 . '" target="_blank" title="更多.." data-uk-tooltip><i class="uk-icon-plus"></i></a></li>';
	echo '</ul>';
}
function record_visitors()
{
	if (is_singular()) {
		global $post;
		$_var_109 = $post->ID;
		if ($_var_109) {
			$_var_110 = (int) get_post_meta($_var_109, 'views', true);
			if (!update_post_meta($_var_109, 'views', $_var_110 + 1)) {
				add_post_meta($_var_109, 'views', 1, true);
			}
		}
	}
}
add_action('wp_head', 'record_visitors');
function post_views($_var_111 = '<i class="iconfont icon-faxianxianshimima"></i> ', $_var_112 = '', $_var_113 = 1)
{
	global $post;
	$_var_114 = $post->ID;
	$_var_115 = (int) get_post_meta($_var_114, 'views', true);
	if ($_var_113) {
		echo $_var_111, number_format($_var_115), $_var_112;
	} else {
		return $_var_115;
	}
}
function tiaoshi()
{
	$_var_116 = Q_is(of_get('key'));
	if (!$_var_116['state']) {
		return;
	}
	echo '<script>UIkit.notify("调试模式已开启!结束后请记得关闭！",{timeout:"50000",status:"danger",pos:"bottom-right"});</script>';
}
if (of_get('is_developer')) {
	if (!current_user_can('manage_options') && of_get('is_debugging')) {
		return;
	} else {
		if (current_user_can('manage_options') && of_get('is_debugging')) {
			add_action('footer_qzhai', 'tiaoshi');
		}
	}
	$url = get_theme_root() . '/qzhai_' . of_get('k_folder');
	if (of_get('k_folder') && is_dir($url)) {
		if (file_exists($url . '/style.css')) {
			function add_css()
			{
				$_var_117 = content_url() . '/themes/qzhai_' . of_get('k_folder');
				wp_enqueue_style('k_css', $_var_117 . '/style.css');
			}
			add_action('wp_enqueue_scripts', 'add_css');
		}
		if (file_exists($url . '/app.js')) {
			function add_js()
			{
				$_var_118 = content_url() . '/themes/qzhai_' . of_get('k_folder');
				wp_enqueue_script('k_js', $_var_118 . '/app.js');
			}
			add_action('wp_footer', 'add_js');
		}
		if (file_exists($url . '/diy_fun.php')) {
			include get_theme_root() . '/qzhai_' . of_get('k_folder') . '/diy_fun.php';
		}
	}
}
function comment_mail_notify($_var_119)
{
	$_var_120 = Q_is(of_get('key'));
	if (!$_var_120['state']) {
		return;
	}
	$_var_121 = '1';
	$_var_122 = get_bloginfo('admin_email');
	$_var_123 = get_comment($_var_119);
	$_var_124 = trim($_var_123->comment_author_email);
	$_var_125 = $_var_123->comment_parent ? $_var_123->comment_parent : '';
	global $wpdb;
	if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '') {
		$wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
	}
	if ($_var_124 != $_var_122 && isset($_POST['comment_mail_notify']) || $_var_124 == $_var_122 && $_var_121 == '1') {
		$wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='{$_var_119}'");
	}
	$_var_126 = $_var_125 ? get_comment($_var_125)->comment_mail_notify : '0';
	$_var_127 = $_var_123->comment_approved;
	if ($_var_125 != '' && $_var_127 != 'spam' && $_var_126 == '1') {
		$_var_128 = 'no-reply@' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME']));
		$_var_129 = trim(get_comment($_var_125)->comment_author_email);
		$_var_130 = '您在 [' . get_option('blogname') . '] 的留言有了回复';
		$_var_131 = '
        <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> ' . the_title() . '</title>
        <style type="text/css">
            html{
                background: #f5f5f5;
                font: 14px/20px "Proxima Nova", "Helvetica Neue", Helvetica, Arial, sans-serif;
            }
            a{
                text-decoration: none;
                color: #344449;
            }
            body{
                padding:80px 0;
                color: rgba(0,0,0,.6);
            }
            .wp{
                width: 600px;
                margin-right: auto;
                margin-left: auto;
            }
            #main{
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.02), 0 4px 10px rgba(0, 0, 0, 0.06);
            }
            #main > h4{
                padding: 15px 30px;
                border-bottom: 1px solid #EEEEEE;
                box-shadow: 0 2px 5px -1px rgba(0, 0, 0, 0.05);
                background-image: linear-gradient(rgba(200, 200, 200, 0), rgba(200, 200, 200, 0.12));
                color: rgba(0, 0, 0, 0.4);
                margin: 0;
                font-size: 16px;
                line-height: 25px;
                font-weight: normal;
            }
            #co{
                padding:20px;
            }
            .text-xs{
                text-align: center;
                margin: 0;
                padding: 5px 0;
            }
            .text-xs a{
                font-size: 12px;
            }
            .button{
                    -webkit-appearance: none;
                    margin: 0;
                    border: none;
                    overflow: visible;
                    font: inherit;
                    color: #444;
                    text-transform: none;
                    display: inline-block;
                    box-sizing: border-box;
                    padding: 0 12px;
                    background: #f5f5f5;
                    vertical-align: middle;
                    line-height: 28px;
                    min-height: 30px;
                    font-size: 1rem;
                    text-decoration: none;
                    text-align: center;
                    border: 1px solid rgba(0,0,0,.06);
                    border-radius: 4px;
                    text-shadow: 0 1px 0 #fff;
                    width: 100%;
            }
        </style>
    </head>
    <body>
        <div id="main" class="wp">
            <h4>新的回复</h4>
            <div id="co">
                <p>' . trim(get_comment($_var_125)->comment_author) . ', 您好!</p>
              <p>您曾在《<a href="' . get_permalink($_var_123->comment_post_ID) . '"> ' . get_the_title($_var_123->comment_post_ID) . '</a>》的留言:</p>
              <p>' . trim(get_comment($_var_125)->comment_content) . '</p>
              <p>' . trim($_var_123->comment_author) . '给您的回复:</p>
              <p>' . trim($_var_123->comment_content) . '</p>
              <p>(此邮件由系统自动发送，请勿回复.)</p>
                <p class="text-xs"><a href="' . get_permalink($_var_123->comment_post_ID) . '" class="button">点击查看</a></p>
            </div>

        </div>
        <div class="wp">
            <p class="text-xs"><a href="' . site_url() . '" target="_blank">' . get_option('blogname') . '</a></p></p>
        </div>
    </body>
</html>';
		$_var_132 = 'From: "' . get_option('blogname') . "\" <{$_var_128}>";
		$_var_133 = "{$_var_132}\nContent-Type: text/html; charset=" . get_option('blog_charset') . '
';
		wp_mail($_var_129, $_var_130, $_var_131, $_var_133);
	}
}
if (of_get('is_email')) {
	add_action('comment_post', 'comment_mail_notify');
}
function add_checkbox()
{
	$_var_134 = Q_is(of_get('key'));
	if (!$_var_134['state']) {
		return;
	}
	echo '<div style="margin-top:5px;"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" style="margin-right:5px;" /><label for="comment_mail_notify">';
	echo of_get('diy_default_email_text') ? of_get('diy_default_email_text') : '有人回复时邮件通知我';
	echo '</label></div>';
}
if (of_get('is_email')) {
	add_action('comment_form_qzhai', 'add_checkbox');
}
function article_index($_var_135)
{
	$_var_136 = Q_is(of_get('key'));
	if (!$_var_136['state']) {
		return;
	}
	if (!is_single()) {
		return $_var_135;
	}
	global $qzhai;
	$_var_137 = '';
	$_var_138 = '';
	$_var_139 = array();
	$_var_140 = '/<h([2-6]).*?\\>(.*?)<\\/h[2-6]>/is';
	$_var_141 = preg_match_all($_var_140, $_var_135, $_var_139);
	if ($_var_141) {
		$_var_142 = count($_var_139[0]);
		foreach ($_var_139[1] as $_var_143 => $_var_144) {
			if ($_var_143 <= 0) {
				$_var_137 = '<ul >';
			} else {
				if ($_var_144 > $_var_139[1][$_var_143 - 1]) {
					if ($_var_144 - $_var_139[1][$_var_143 - 1] == 1) {
						$_var_137 .= '<ol>';
					} elseif ($_var_144 == $_var_139[1][$_var_143 - 1]) {
					} else {
					}
				}
			}
			$_var_145 = strip_tags($_var_139[2][$_var_143]);
			$_var_135 = str_replace($_var_139[0][$_var_143], '<h' . $_var_144 . ' id="index-' . $_var_143 . '">' . $_var_145 . '</h' . $_var_144 . '>', $_var_135);
			$_var_137 .= '<li class="h' . $_var_144 . '"><a rel="contents chapter" href="#index-' . $_var_143 . '" data-uk-smooth-scroll="{offset: ' . $qzhai['top_num'] . '}">' . $_var_145 . '</a></li>';
			if ($_var_143 < $_var_142 - 1) {
				if ($_var_144 > $_var_139[1][$_var_143 + 1]) {
					$_var_146 = $_var_144 - $_var_139[1][$_var_143 + 1];
					for ($_var_147 = 0; $_var_147 < $_var_146; $_var_147++) {
						$_var_138 .= '</ol>';
						$_var_137 .= $_var_138;
						$_var_138 = '';
					}
				}
			} else {
				$_var_137 .= '</ol>';
			}
		}
		$_var_137 = '<li> <h4>目录</h4> <nav class="qzhai_directory" >' . $_var_137 . '</nav></li>';
		$qzhai['html'] = $_var_137;
		add_filter('widget_qzhai', 'set_filter_qzhai');
	}
	return $_var_135;
}
if (of_get('is_directory')) {
	add_filter('the_content', 'article_index');
}
function specs_comment_author_link()
{
	$_var_148 = get_comment_author_url();
	$_var_149 = get_comment_author();
	if (empty($_var_148) || 'http://' == $_var_148) {
		return $_var_149;
	} else {
		return "<a target='_blank' href='{$_var_148}' rel='external nofollow' class='url'>{$_var_149}</a>";
	}
}
if (of_get('is_logon_safe')) {
	add_action('login_enqueue_scripts', 'login_protection_qzhai');
}
function login_protection_qzhai()
{
	$_var_150 = Q_is(of_get('key'));
	if (!$_var_150['state']) {
		return;
	}
	$_var_151 = of_get('login_value');
	$_var_152 = array('m', 'd', 'H', 'i');
	$_var_153 = str_split(of_get('login_value_time'));
	$_var_154 = false;
	if (of_get('login_value_time')) {
		foreach ($_var_153 as $_var_155) {
			if (!in_array($_var_155, $_var_152)) {
				$_var_154 = true;
			}
		}
		if ($_var_154) {
			return;
		}
		$_var_151 .= date(of_get('login_value_time'));
	}
	if ($_GET[of_get('login_name')] != $_var_151) {
		header('Location:' . home_url('/'));
		echo '<meta http-equiv="refresh" content="0;url=' . home_url('/') . '">';
	}
}
function myplugin_add_login_fields()
{
	$_var_156 = rand(0, 19);
	$_var_157 = rand(0, 19);
	echo '<p><label for="math" class="small">验证码</label><br /> ' . $_var_156 . ' + ' . $_var_157 . ' = ?
      <input type="text" name="sum" class="input" value="" size="25" tabindex="4">
  <input type="hidden" name="num1" value="' . encrypt($_var_156) . '">
  <input type="hidden" name="num2" value="' . encrypt($_var_157) . '"></p>';
}
function login_val()
{
	$_var_158 = $_POST['sum'];
	switch ($_var_158) {
		case decrypt($_POST['num1']) + decrypt($_POST['num2']):
			break;
		case null:
			wp_die('错误: 请输入验证码.');
			break;
		default:
			wp_die('错误: 验证码错误,请重试.');
	}
}
if (of_get('is_logon_code')) {
	add_action('login_form_login', 'login_val');
	add_action('login_form', 'myplugin_add_login_fields');
}
