<?php
global $salong;
header('Content-type: text/html; charset=utf-8');
load_theme_textdomain('salong', get_template_directory() . '/languages');
if (!class_exists('ReduxFramework') && file_exists(get_template_directory() . '/admin/ReduxCore/framework.php')) {
    require_once (get_template_directory() . '/admin/ReduxCore/framework.php');
}
if (!isset($redux_demo) && file_exists(get_template_directory() . '/admin/config.php')) {
    require_once (get_template_directory() . '/admin/config.php');
}
if ($salong['thumb_mode'] == 'timthumb') {
    require_once get_template_directory() . '/includes/thumb.php';
} else {
    require_once get_template_directory() . '/includes/wpauto.php';
}
if ($salong['switch_post_type']) {
    require_once get_template_directory() . '/includes/post-types.php';
}
require_once get_template_directory() . '/includes/shortcodes/shortcodespanel.php';
require_once get_template_directory() . '/includes/shortcodes/shortcodes.php';
require_once get_template_directory() . '/includes/comment-ajax.php';
require_once get_template_directory() . '/includes/tutorial.php';
require_once get_template_directory() . '/includes/notify.php';
if ($salong['switch_new_metabox']) {
    require get_template_directory() . '/includes/metabox/framework-core.php';
    require get_template_directory() . '/includes/metabox/meta-box.php';
} else {
    require_once get_template_directory() . '/includes/meta-boxes.php';
}
function salong_sanitize_user($xzv_203, $xzv_123, $xzv_124) {
    $xzv_203 = wp_strip_all_tags($xzv_123);
    $xzv_203 = remove_accents($xzv_203);
    $xzv_203 = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $xzv_203);
    $xzv_203 = preg_replace('/&.+?;/', '', $xzv_203);
    if ($xzv_124) {
        $xzv_203 = preg_replace('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $xzv_203);
    }
    $xzv_203 = trim($xzv_203);
    $xzv_203 = preg_replace('|\s+|', ' ', $xzv_203);
    return $xzv_203;
}
add_filter('sanitize_user', 'salong_sanitize_user', 10, 3);
if (class_exists('woocommerce')) {
    require_once get_template_directory() . '/woocommerce/config.php';
}
if (is_singular() || $salong['switch_smartideo']) {
    require_once get_template_directory() . '/includes/smartideo.php';
}
function checking_product_bought($xzv_117) {
    global $woocommerce, $posts;
    $xzv_128 = wp_get_current_user();
    $xzv_43 = $xzv_128->ID;
    $xzv_44 = $xzv_128->email;
    $xzv_134 = get_posts(array('numberposts' => - 1, 'meta_key' => '_customer_user', 'meta_value' => $xzv_43, 'post_type' => wc_get_order_types(), 'post_status' => array_keys(wc_get_order_statuses()),));
    if ($xzv_134) {
        foreach ($xzv_134 as $xzv_130) {
            $xzv_133 = wc_get_order();
            $xzv_46 = $xzv_133->id;
            $xzv_131 = $xzv_133->get_items();
            foreach ($xzv_131 as $xzv_95) {
                $xzv_90 = $xzv_95['product_id'];
                $xzv_222 = $xzv_95['qty'];
                if (wc_customer_bought_product($xzv_44, $xzv_43, $xzv_117)) {
                    echo '<div>for order number: ' . $xzv_46 . ' ,there is ' . $xzv_222 . ' for this product.';
                }
            }
        }
    }
}
require_once get_template_directory() . '/includes/sidebars.php';
require_once get_template_directory() . '/includes/widgets/widget-post.php';
require_once get_template_directory() . '/includes/widgets/widget-bulletin.php';
require_once get_template_directory() . '/includes/widgets/widget-gallery.php';
require_once get_template_directory() . '/includes/widgets/widget-video.php';
require_once get_template_directory() . '/includes/widgets/widget-about.php';
require_once get_template_directory() . '/includes/widgets/widget-user.php';
require_once get_template_directory() . '/includes/widgets/widget-tag.php';
require_once get_template_directory() . '/includes/widgets/widget-slide.php';
require_once get_template_directory() . '/includes/widgets/widget-comments.php';
require_once get_template_directory() . '/includes/widgets/widget-contact.php';
require_once get_template_directory() . '/includes/widgets/widget-word.php';
require_once get_template_directory() . '/includes/widgets/widget-qqqun.php';
function unregister_default_widgets() {
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WC_Widget_Product_Tag_Cloud');
    unregister_widget('WC_Widget_Rating_Filter');
    unregister_widget('WC_Widget_Layered_Nav');
    unregister_widget('WC_Widget_Layered_Nav_Filters');
    unregister_widget('WC_Widget_Product_Search');
}
add_action('widgets_init', 'unregister_default_widgets', 11);
if (salong_is_weixin()) {
    require_once get_template_directory() . '/includes/jssdk.php';
    add_action('wp_ajax_nopriv_wechat_share', 'wechat_share_callback');
    add_action('wp_ajax_wechat_share', 'wechat_share_callback');
    function wechat_share_callback() {
        $xzv_210 = $_POST['postid'];
        $xzv_138 = get_post_meta($xzv_210, 'wechat_share_num', true) ? (get_post_meta($xzv_210, 'wechat_share_num', true) + 1) : 1;
        update_post_meta($xzv_210, 'wechat_share_num', $xzv_138);
        die;
    }
}
register_nav_menus(array('header-menu' => __('导航菜单', 'salong'), 'top-menu' => __('顶部菜单', 'salong'), 'mobile-menu' => __('移动导航菜单', 'salong'), 'user-menu' => __('移动用户菜单', 'salong')));
function Salong_header_nav_fallback() {
    echo '<div class="header-menu"><ul class="empty"><li><a href="' . get_option('home') . '/wp-admin/nav-menus.php?action=locations">' . __('请在 "后台——外观——菜单" 添加导航菜单', 'salong') . '</a></ul></li></div>';
}
function Salong_top_nav_fallback() {
    echo '<div class="top-menu"><ul class="empty"><li><a href="' . get_option('home') . '/wp-admin/nav-menus.php?action=locations">' . __('请在 "后台——外观——菜单" 添加顶部菜单', 'salong') . '</a></ul></li></div>';
}
function Salong_mobile_nav_fallback() {
    echo '<div class="mobile-menu  left"><ul class="empty"><li><a href="' . get_option('home') . '/wp-admin/nav-menus.php?action=locations">' . __('请在 "后台——外观——菜单" 添加移动菜单', 'salong') . '</a></ul></li></div>';
}
function Salong_user_nav_fallback() {
    echo '<div class="mobile-menu  left"><ul class="empty"><li><a href="' . get_option('home') . '/wp-admin/nav-menus.php?action=locations">' . __('请在 "后台——外观——菜单" 添加用户菜单', 'salong') . '</a></ul></li></div>';
}
function salong_theme_title() {
    global $salong, $post;
    $xzv_37 = $salong['title_delimiter'];
    $xzv_48 = get_post_meta($post->ID, 'seo_title', 'true');
    if (is_home()) {
        $xzv_92.= get_bloginfo('name') . $xzv_37 . get_bloginfo('description');
    } else if (is_single() && $xzv_48) {
        $xzv_92.= $xzv_48 . $xzv_37 . get_bloginfo('name');
    } else {
        $xzv_92.= wp_title($xzv_37, true, 'right');
        $xzv_92.= get_bloginfo('name');
    }
    return $xzv_92;
}
function add_logout_to_wp_menu($xzv_98, $xzv_36) {
    if ('user-menu' === $xzv_36->theme_location) {
        global $salong;
        $xzv_98.= '<li class="menu-item">';
        $xzv_98.= '<a href="' . wp_logout_url(home_url()) . '" title="' . __('登出', 'salong') . '">' . __('退出登录', 'salong') . '</a>';
        $xzv_98.= '</li>';
    }
    return $xzv_98;
}
add_filter('wp_nav_menu_items', 'add_logout_to_wp_menu', 10, 2);
function add_search_to_wp_menu($xzv_141, $xzv_39) {
    global $salong;
    if ('header-menu' === $xzv_39->theme_location && $salong['switch_search_menu']) {
        $xzv_141.= '<li class="menu-item menu-item-search">';
        $xzv_141.= '<a href="#search" title="' . __('点击搜索', 'salong') . '"><i class="icon-search-1"></i></a>';
        $xzv_141.= '</li>';
    }
    return $xzv_141;
}
add_filter('wp_nav_menu_items', 'add_search_to_wp_menu', 10, 2);
if (!is_admin()) {
    if (!function_exists('salong')) {
        function salong() {
            global $salong;
            wp_enqueue_style('style', get_stylesheet_uri(), array(), '2017.03.18');
            wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css', false, '1.0', false);
            wp_deregister_script('jquery');
            wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', false, '3.1.1', false);
            if (class_exists('woocommerce')) {
                wp_enqueue_style('woocommerce', get_template_directory_uri() . '/woocommerce/css/woocommerce.css', false, '1.0', false);
            }
            if (!wp_is_mobile()) {
                wp_enqueue_script('wow', get_template_directory_uri() . '/js/wow.min.js', false, '1.0', true);
                wp_enqueue_style('animate', get_template_directory_uri() . '/css/animate.css', false, '1.0', false);
            }
            if (wp_is_mobile()) {
                wp_enqueue_style('response', get_template_directory_uri() . '/css/response.css', false, '1.0', false);
                wp_enqueue_script('snap', get_template_directory_uri() . '/js/snap.js', false, '1.9.3', false);
            }
            wp_enqueue_script('swiper', get_template_directory_uri() . '/js/swiper.jquery.min.js', false, '3.3.1', false);
            wp_enqueue_script('ias', get_template_directory_uri() . '/js/jquery-ias.min.js', false, '2.2.2', true);
            wp_enqueue_script('scrollchaser', get_template_directory_uri() . '/js/jquery.scrollchaser.min.js', false, '0.0.6', true);
            if ($salong['switch_lazyload']) {
                wp_enqueue_script('lazyload', get_template_directory_uri() . '/js/jquery.lazyload.min.js', false, '1.9.3', true);
            }
            if ($salong['switch_header_show_hide']) {
                wp_enqueue_script('headroom', get_template_directory_uri() . '/js/headroom.min.js', false, '0.9.4', false);
            }
            wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox.min.js', false, '3.0.6', true);
            wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/jquery.fancybox.min.css', false, '3.0.6', 'screen');
            if (in_array('gb2big5', $salong['side_metas'])) {
                wp_enqueue_script('gb2big5', get_template_directory_uri() . '/js/gb2big5.js', false, '1.0', true);
            }
            wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', false, '1.0', true);
            global $salong;
            if ($salong['switch_style'] == 'have') {
                $xzv_211 = $salong['style_options'];
                wp_enqueue_style('colorphp', get_template_directory_uri() . '/includes/color.php?main_color=' . $xzv_211 . '.css');
            } else if ($salong['switch_style'] == 'custom') {
                wp_enqueue_style('colorphp', get_template_directory_uri() . '/includes/color.php');
            }
            if (!function_exists('salong_css_code')) {
                function salong_css_code() {
                    global $salong;
                    $xzv_105 = $salong['css_code'];
                    if (!empty($xzv_105)) {
                        $xzv_212 = preg_replace('/\s+/', ' ', $xzv_105);
                        $xzv_209 = '<!-- Dynamic css -->
<style type="text/css">
' . $xzv_212 . '
</style>';
                        echo $xzv_209;
                    }
                }
            }
            add_action('wp_head', 'salong_css_code');
        }
        add_action('init', 'salong');
    }
    if (!function_exists('singular')) {
        function singular() {
            if (is_singular()) {
                global $salong;
                if ($salong['switch_highlight']) {
                    wp_enqueue_style('highlight', get_template_directory_uri() . '/css/highlight.css', false, '3.0.3', 'screen');
                }
            }
        }
        add_action('wp_enqueue_scripts', 'singular');
    }
}
function post_name() {
    $xzv_226 = '';
    if ('video' == get_post_type()) {
        $xzv_226.= __('视频', 'salong');
    } else if ('gallery' == get_post_type()) {
        $xzv_226.= __('画廊', 'salong');
    } else if ('product' == get_post_type()) {
        $xzv_226.= __('产品', 'salong');
    } else {
        $xzv_226.= __('文章', 'salong');
    }
    return $xzv_226;
}
add_action('wp_ajax_avatar_action', 'avatar_upload_action_callback');
add_shortcode('frontend_avatar_upload', 'frontend_avatar_upload_view');
function frontend_avatar_upload_view() {
    $xzv_218 = wp_get_current_user()->ID;
    $xzv_104 = get_user_meta($xzv_218, 'salong_custom_avatar', true);
    wp_register_script('avatarjs', get_template_directory_uri() . '/js/avatar.js', array('jquery'));
    wp_enqueue_script('avatarjs');
    wp_localize_script('avatarjs', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_enqueue_media();
    require_once get_template_directory() . '/includes/avatar-view.php';
}
function avatar_upload_action_callback() {
    update_user_meta(wp_get_current_user()->ID, 'salong_custom_avatar', $_POST['url']);
    wp_die();
}
function salong_avatar_name() {
    global $salong, $wp_query, $comment, $current_user;
    $xzv_224 = $current_user->ID;
    $GLOBALS['comment'] = $comment;
    $xzv_121 = get_user_meta($xzv_224, 'salong_custom_avatar', true);
    $xzv_207 = get_user_meta($xzv_224, '_social_img', true);
    $xzv_204 = get_userdata($xzv_224);
    if (!empty($xzv_204)) {
        $xzv_188 = $xzv_204->user_email;
    } else {
        $xzv_188 = '';
    }
    if (!empty($comment)) {
        $xzv_122 = $comment->comment_author_email;
    } else {
        $xzv_122 = '';
    }
    $xzv_96 = $salong['avatar_loading']['url'];
    if ($xzv_121) {
        $xzv_10 = __('自定义头像', 'salong');
    } else if ($xzv_207) {
        $xzv_10 = __('社交头像', 'salong');
    } else if ($xzv_188 || $xzv_122) {
        $xzv_10 = __('Gravatar头像', 'salong');
    } else {
        $xzv_10 = __('默认头像', 'salong');
    }
    return $xzv_10;
}
function salong_get_avatar($xzv_9, $xzv_102) {
    global $salong, $comment;
    $GLOBALS['comment'] = $comment;
    $xzv_227 = get_user_meta($xzv_9, 'salong_custom_avatar', true);
    $xzv_13 = get_user_meta($xzv_9, '_social_img', true);
    $xzv_187 = get_userdata($xzv_9);
    if (!empty($xzv_187)) {
        $xzv_35 = $xzv_187->user_email;
    } else {
        $xzv_35 = '';
    }
    if (!empty($comment)) {
        $xzv_162 = $comment->comment_author_email;
    } else {
        $xzv_162 = '';
    }
    $xzv_14 = $salong['avatar_loading']['url'];
    if ($xzv_227) {
        $xzv_8 = $xzv_227;
    } else if ($xzv_13) {
        $xzv_8 = $xzv_13;
    } else if ($xzv_35) {
        $xzv_8 = 'https://secure.gravatar.com/avatar/' . md5($xzv_35) . '?s=120';
    } else if ($xzv_162) {
        $xzv_8 = 'https://secure.gravatar.com/avatar/' . md5($xzv_162) . '?s=120';
    } else {
        $xzv_8 = $xzv_14;
    }
    if ($salong['switch_lazyload']) {
        return '<img class="avatar" src="' . $xzv_14 . '" data-original="' . $xzv_8 . '" alt="' . $xzv_102 . '" />';
    } else {
        return '<img class="avatar" src="' . $xzv_8 . '" alt="' . $xzv_102 . '" />';
    }
}
if (is_admin()) {
    function get_ssl_avatar($xzv_142) {

        $xzv_142 = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/', '<img src="https://secure.gravatar.com/avatar/$1?s=32" class="avatar avatar-32" height="32" width="32">', $xzv_142);
        return $xzv_142;
    }
} else {
    function get_ssl_avatar($xzv_225) {
        global $current_user;
        $xzv_166 = $current_user->ID;
        $xzv_2 = $current_user->display_name;
        $xzv_225 = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/', salong_get_avatar($xzv_166, $xzv_2), $xzv_225);
        return $xzv_225;
    }
}
add_filter('get_avatar', 'get_ssl_avatar');
add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');
wp_enqueue_script('like_post', get_template_directory_uri() . '/js/post-like.js', array('jquery'), '1.0', true);
wp_localize_script('like_post', 'ajax_var', array('url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('ajax-nonce')));
function post_like() {
    if (isset($_POST['post_like'])) {
        $xzv_195 = $_SERVER['REMOTE_ADDR'];
        $xzv_221 = $_POST['post_id'];
        $xzv_168 = get_post_meta($xzv_221, 'voted_IP');
        $xzv_147 = $xzv_168[0];
        if (!is_array($xzv_147)) $xzv_147 = array();
        $xzv_99 = get_post_meta($xzv_221, 'votes_count', true);
        if (!hasAlreadyVoted($xzv_221)) {
            $xzv_147[$xzv_195] = time();
            update_post_meta($xzv_221, 'voted_IP', $xzv_147);
            update_post_meta($xzv_221, 'votes_count', ++$xzv_99);
            if (function_exists('woocommerce_points_rewards_my_points')) {
                $xzv_190 = get_option('wc_points_rewards_like_points');
                WC_Points_Rewards_Manager::increase_points(get_current_user_id(), $xzv_190, 'like', $xzv_221);
            }
            echo $xzv_99;
        } else echo 'already';
    }
    die;
}
global $salong;
$timebeforerevote = stripslashes($salong['like_time']);
function hasAlreadyVoted($xzv_146) {
    global $timebeforerevote;
    $xzv_4 = get_post_meta($xzv_146, 'voted_IP', true);
    $xzv_149 = $xzv_4;
    if (!is_array($xzv_149)) $xzv_149 = array();
    $xzv_197 = $_SERVER['REMOTE_ADDR'];
    if (in_array($xzv_197, array_keys($xzv_149))) {
        $xzv_16 = $xzv_149[$xzv_197];
        $xzv_17 = time();
        if (round(($xzv_17 - $xzv_16) / 60) > $timebeforerevote) return false;
        return true;
    }
    return false;
}
function getPostLikeLink($xzv_29) {
    global $salong;
    $xzv_150 = '';
    $xzv_93 = get_post_meta($xzv_29, 'votes_count', true);
    if (hasAlreadyVoted($xzv_29)) {
        $xzv_150.= '<span title="' . __('您已经点赞了！', 'salong') . '" class="like alreadyvoted"><i class="icon-thumbs-up-alt">' . __('已赞', 'salong') . '</i>(<span class="count">';
        if ($xzv_93 == 0) {
            $xzv_150.= '0';
        } else {
            $xzv_150.= $xzv_93;
        }
        $xzv_150.= '</span>)</span>';
    } else {
        $xzv_150.= '<a href="#" data-post_id="' . $xzv_29 . '" title="' . sprintf(__('喜欢该%s，请点赞！', 'salong'), esc_attr(post_name())) . '"><i class="icon-thumbs-up">' . __('赞', 'salong') . '</i>(<span class="count">';
        if ($xzv_93 == 0) {
            $xzv_150.= '0';
        } else {
            $xzv_150.= $xzv_93;
        }
        $xzv_150.= '</span>)</a>';
    }
    return $xzv_150;
}
function getPostLikeLinkList($xzv_94) {
    global $salong;
    $xzv_97 = '';
    $xzv_108 = get_post_meta($xzv_94, 'votes_count', true);
    if (hasAlreadyVoted($xzv_94)) {
        $xzv_97.= '<span title="' . __('您已经点赞了！', 'salong') . '" class="like alreadyvoted">';
        if (is_singular(array('video', 'gallery', 'product'))) {
            $xzv_97.= __('点赞：', 'salong');
        } else {
            $xzv_97.= '<i class="icon-thumbs-up-alt"></i>';
        }
    } else {
        $xzv_97.= '<span  title="' . sprintf(__('请先浏览本%s，再确定是否点赞！', 'salong'), esc_attr(post_name())) . '"class="like">';
        if (is_singular(array('video', 'gallery', 'product'))) {
            $xzv_97.= __('点赞：', 'salong');
        } else {
            $xzv_97.= '<i class="icon-thumbs-up"></i>';
        }
    }
    if ($xzv_108 == 0) {
        $xzv_97.= '0';
    } else {
        $xzv_97.= '<span class="count">' . $xzv_108 . '</span>';
    }
    $xzv_97.= '</span>';
    return $xzv_97;
}
function blog_ad() {
    global $salong;
    if ($salong['ad_blog']) {
        echo '<article class="ad box';
        triangle();
        wow();
        echo '">';
        if (!wp_is_mobile()) {
            echo $salong['ad_blog'];
        } else {
            if ($salong['ad_blog_mobile']) {
                echo $salong['ad_blog_mobile'];
            } else {
                echo $salong['ad_blog'];
            }
        }
        echo '</article>';
    }
}
function ad_cat1() {
    global $salong;
    if ($salong['ad_cat1']) {
        echo '<section class="ad box';
        triangle();
        wow();
        echo '">';
        if (!wp_is_mobile()) {
            echo $salong['ad_cat1'];
        } else {
            if ($salong['ad_cat1_mobile']) {
                echo $salong['ad_cat1_mobile'];
            } else {
                echo $salong['ad_cat1'];
            }
        }
        echo '</section>';
    }
}
function ad_cat2() {
    global $salong;
    if ($salong['ad_cat2']) {
        echo '<section class="ad box';
        triangle();
        wow();
        echo '">';
        if (!wp_is_mobile()) {
            echo $salong['ad_cat2'];
        } else {
            if ($salong['ad_cat2_mobile']) {
                echo $salong['ad_cat2_mobile'];
            } else {
                echo $salong['ad_cat2'];
            }
        }
        echo '</section>';
    }
}
function ad_cat3() {
    global $salong;
    if ($salong['ad_cat3']) {
        echo '<section class="ad box';
        triangle();
        wow();
        echo '">';
        if (!wp_is_mobile()) {
            echo $salong['ad_cat3'];
        } else {
            if ($salong['ad_cat3_mobile']) {
                echo $salong['ad_cat3_mobile'];
            } else {
                echo $salong['ad_cat3'];
            }
        }
        echo '</section>';
    }
}
function ad_single() {
    global $salong, $post;
    if (!get_post_meta($post->ID, 'no_sidebar', true)) {
        if (!wp_is_mobile()) {
            if ($salong['ad_single']) {
                echo '<div class="ad ad-single">' . $salong['ad_single'] . '</div>';
            }
        } else {
            if ($salong['ad_single_mobile']) {
                echo '<div class="ad ad-single">' . $salong['ad_single_mobile'] . '</div>';
            } else {
                echo '<div class="ad ad-single">' . $salong['ad_single'] . '</div>';
            }
        }
    }
}
function ad_related() {
    global $salong, $post;
    if ($salong['ad_related'] && !get_post_meta($post->ID, 'no_sidebar', true)) {
        echo '<section class="ad box';
        triangle();
        wow();
        echo '">';
        if (!wp_is_mobile()) {
            echo $salong['ad_related'];
        } else {
            if ($salong['ad_related_mobile']) {
                echo $salong['ad_related_mobile'];
            } else {
                echo $salong['ad_related'];
            }
        }
        echo '</section>';
    }
}
function wow() {
    global $salong;
    if ($salong['switch_wow'] && !wp_is_mobile()) {
        echo ' wow bounceInUp';
    }
}
function triangle() {
    global $salong;
    if ($salong['switch_triangle']) {
        echo ' triangle';
    }
}
if (!function_exists('salong_favicon')) {
    function salong_favicon() {
        global $salong;
        $xzv_107 = $salong['custom_favicon']['url'];
        $xzv_33 = $salong['custom_ios_favicon']['url'];
        if ($xzv_107) {
            echo '<link rel="shortcut icon" href="' . $xzv_107 . '" />', '
';
        }
        if ($xzv_33) {
            echo '<link rel="apple-touch-icon" sizes="120*120" href="' . $xzv_33 . '" />', '
';
        }
    }
    add_action('wp_head', 'salong_favicon');
}
function get_content_first_image($xzv_156) {
    if ($xzv_156 === false) $xzv_156 = get_the_content();
    preg_match_all("|<img.*?src=['\"](.*?)['\"].*?>|i", $xzv_156, $xzv_26);
    if ($xzv_26) {
        return $xzv_26[1][0];
    } else {
        return false;
    }
}
add_filter('the_content', 'fancybox_replace');
function fancybox_replace($xzv_196) {
    global $post;
    $xzv_113 = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $xzv_110 = '<a$1href=$2$3.$4$5 data-fancybox="group"$6>$7</a>';
    $xzv_196 = preg_replace($xzv_113, $xzv_110, $xzv_196);
    return $xzv_196;
}
if ($salong['switch_post_type_slug']) {
    global $salong;
    $posttypes = array('bulletin' => 'bulletin', 'gallery' => 'gallery', 'video' => 'video', 'product' => 'product');
    add_filter('post_type_link', 'custom_salong_link', 1, 3);
    function custom_salong_link($xzv_245, $xzv_152 = 0) {
        global $posttypes;
        if (in_array($xzv_152->post_type, array_keys($posttypes))) {
            global $salong;
            if ($salong['post_type_slug'] == 'Postname') {
                $xzv_19 = 'post_name';
            } else {
                $xzv_19 = 'ID';
            }
            return home_url($posttypes[$xzv_152->post_type] . '/' . $xzv_152->$xzv_19 . '.html');
        } else {
            return $xzv_245;
        }
    }
    add_action('init', 'custom_salong_rewrites_init');
    function custom_salong_rewrites_init() {
        global $posttypes;
        foreach ($posttypes as $xzv_240 => $xzv_114) {
            global $salong;
            if ($salong['post_type_slug'] == 'Postname'):
                add_rewrite_rule($xzv_114 . '/([一-龥a-zA-Z0-9_-]+)?.html([\s\S]*)?$', 'index.php?post_type=' . $xzv_240 . '&name=$matches[1]', 'top');
            else:
                add_rewrite_rule($xzv_114 . '/([0-9]+)?.html$', 'index.php?post_type=' . $xzv_240 . '&p=$matches[1]', 'top');
            endif;
        }
    }
}
function posts_pagination() {
    echo the_posts_pagination(array('mid_size' => 1, 'prev_text' => __('上一页', 'salong'), 'next_text' => __('下一页', 'salong'),));
}
function salong_link_pages() {
    $xzv_116 = array('before' => '<div class="pagination nav-links"><p>' . __('分页：', 'salong') . '</p>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>', 'next_or_number' => 'number', 'separator' => '', 'nextpagelink' => __('上一页', 'salong'), 'previouspagelink' => __('下一页', 'salong'), 'pagelink' => '%', 'echo' => 1);
    wp_link_pages($xzv_116);
}
function salong_map() {
    require_once get_template_directory() . '/content/contact-map.php';
}
add_shortcode('map', 'salong_map');
function salong_breadcrumbs() {
    global $salong, $post;
    $xzv_170 = '&nbsp;' . $salong['delimiter'] . '&nbsp;';
    $xzv_172 = '<span class="current">';
    $xzv_24 = '</span>';
    if (!is_home() && !is_front_page() || is_paged()) {
        echo '<article class="crumbs">';
        global $post;
        $xzv_109 = home_url();
        echo ' <a itemprop="breadcrumb" href="' . $xzv_109 . '">' . __('首页', 'salong') . '</a>' . $xzv_170 . '';
        if (is_category()) {
            global $wp_query;
            $xzv_159 = $wp_query->get_queried_object();
            $xzv_23 = $xzv_159->term_id;
            $xzv_23 = get_categories(array('include' => $xzv_23, 'taxonomy' => 'any'));
            $xzv_115 = $xzv_23->parent;
            $xzv_198 = get_categories(array('include' => $xzv_115, 'taxonomy' => 'any'));
            $xzv_199 = get_page_id_from_template('template-blog.php');
            echo '<a itemprop="breadcrumb" href="' . get_permalink($xzv_199) . '">' . get_the_title($xzv_199) . '</a>' . $xzv_170;
            if ($xzv_23->parent != 0) {
                $xzv_164 = get_category_parents($xzv_198, true, ' ' . $xzv_170 . ' ');
                echo $xzv_164 = str_replace('<a', '<a itemprop="breadcrumb"', $xzv_164);
            }
            echo $xzv_172 . '' . single_cat_title('', false) . '' . $xzv_24;
        } else if (is_tax()) {
            $xzv_202 = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $xzv_201 = $xzv_202->parent;
            if (is_tax('video-cat') || is_tax('video-tag')) {
                $xzv_199 = get_page_id_from_template('template-video.php');
            } else if (is_tax('gallery-cat') || is_tax('gallery-tag')) {
                $xzv_199 = get_page_id_from_template('template-gallery.php');
            }
            echo '<a itemprop="breadcrumb" href="' . get_permalink($xzv_199) . '">' . get_the_title($xzv_199) . '</a>' . $xzv_170;
            while ($xzv_201):
                $xzv_22[] = $xzv_201;
                $xzv_239 = get_term_by('id', $xzv_201, get_query_var('taxonomy'));
                $xzv_201 = $xzv_239->parent;
            endwhile;
            if (!empty($xzv_22)):
                $xzv_22 = array_reverse($xzv_22);
                foreach ($xzv_22 as $xzv_201):
                    $xzv_21 = get_term_by('id', $xzv_201, get_query_var('taxonomy'));
                    $xzv_200 = get_post_type();
                    $xzv_194 = 'category';
                    $xzv_193 = get_bloginfo('url') . '/' . $xzv_200 . '-' . $xzv_194 . '/' . $xzv_21->slug;
                    echo '<a href="' . $xzv_193 . '">' . $xzv_21->name . '</a>' . $xzv_170;
                endforeach;
            endif;
            echo $xzv_172 . $xzv_202->name . $xzv_24;
        } else if (is_day()) {
            echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $xzv_170 . '';
            echo '<a itemprop="breadcrumb"  href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $xzv_170 . '';
            echo $xzv_172 . get_the_time('d') . $xzv_24;
        } elseif (is_month()) {
            echo '<a itemprop="breadcrumb" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $xzv_170 . '';
            echo $xzv_172 . get_the_time('F') . $xzv_24;
        } elseif (is_year()) {
            echo $xzv_172 . get_the_time('Y') . $xzv_24;
        } elseif (is_single() && !is_attachment()) {
            if (is_singular('video')) {
                global $salong;
                echo '<a itemprop="breadcrumb" href="' . get_page_link(get_page_id_from_template('template-video.php')) . '">' . get_page(get_page_id_from_template('template-video.php'))->post_title . '</a>' . $xzv_170 . '';
                echo the_terms($post->ID, 'video-cat', '') . $xzv_170;
                echo $xzv_172 . get_the_title() . $xzv_24;
            } else if (is_singular('gallery')) {
                global $salong;
                echo '<a itemprop="breadcrumb" href="' . get_page_link(get_page_id_from_template('template-gallery.php')) . '">' . get_page(get_page_id_from_template('template-gallery.php'))->post_title . '</a>' . $xzv_170 . '';
                echo the_terms($post->ID, 'gallery-cat', '') . $xzv_170;
                echo $xzv_172 . get_the_title() . $xzv_24;
            } else if (is_singular('product')) {
                global $salong;
                echo '<a itemprop="breadcrumb" href="' . get_page_link(wc_get_page_id('shop')) . '">' . get_page(wc_get_page_id('shop'))->post_title . '</a>' . $xzv_170 . '';
                echo the_terms($post->ID, 'product_cat', '') . $xzv_170;
                echo $xzv_172 . get_the_title() . $xzv_24;
            } else {
                echo '<a itemprop="breadcrumb" href="' . get_page_link(get_page_id_from_template('template-blog.php')) . '">' . get_page(get_page_id_from_template('template-blog.php'))->post_title . '</a>' . $xzv_170 . '';
                $xzv_148 = get_the_category();
                $xzv_148 = $xzv_148[0];
                $xzv_164 = get_category_parents($xzv_148, true, $xzv_170);
                echo $xzv_164 = str_replace('<a', '<a itemprop="breadcrumb"', $xzv_164);
                echo $xzv_172 . get_the_title() . $xzv_24;
            }
        } elseif (is_attachment()) {
            $xzv_201 = get_post($post->post_parent);
            $xzv_148 = get_the_category($xzv_201->ID);
            $xzv_148 = $xzv_148[0];
            echo '<a itemprop="breadcrumb" href="' . get_permalink($xzv_201) . '">' . $xzv_201->post_title . '</a>' . $xzv_170 . '';
            echo $xzv_172 . get_the_title() . $xzv_24;
        } else if (is_page() && !$post->post_parent) {
            echo $xzv_172 . get_the_title() . $xzv_24;
        } elseif (is_page() && $post->post_parent) {
            $xzv_185 = $post->post_parent;
            $xzv_184 = array();
            while ($xzv_185) {
                $xzv_62 = get_page($xzv_185);
                $xzv_184[] = '<a itemprop="breadcrumb" href="' . get_permalink($xzv_62->ID) . '">' . get_the_title($xzv_62->ID) . '</a>';
                $xzv_185 = $xzv_62->post_parent;
            }
            $xzv_184 = array_reverse($xzv_184);
            foreach ($xzv_184 as $xzv_20) echo $xzv_20 . '' . $xzv_170 . '';
            echo $xzv_172 . get_the_title() . $xzv_24;
        } elseif (is_search()) {
            echo $xzv_172;
            printf(__('%s 的搜索结果', 'salong'), get_search_query());
            echo $xzv_24;
        } elseif (is_tag()) {
            echo $xzv_172;
            printf(__('%s 的标签存档', 'salong'), single_tag_title('', false));
            echo $xzv_24;
        } elseif (is_author()) {
            global $author;
            $xzv_242 = get_userdata($author);
            echo $xzv_172;
            printf(__('%s 的个人中心', 'salong'), $xzv_242->display_name);
            echo $xzv_24;
        } elseif (is_404()) {
            echo $xzv_172;
            __('404公益页面', 'salong');
            echo $xzv_24;
        }
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo sprintf(__('（第%s页）', 'salong'), get_query_var('paged'));
        }
        echo '</article>';
    }
}
function article_index($xzv_57) {
    $xzv_25 = '';
    $xzv_151 = '';
    $xzv_153 = array();
    $xzv_189 = '/<h([2-6]).*?\>(.*?)<\/h[2-6]>/is';
    global $post, $salong;
    if (preg_match_all($xzv_189, $xzv_57, $xzv_153) && get_post_meta($post->ID, 'catalogue', true) && !wp_is_mobile()):
        $xzv_192 = count($xzv_153[0]);
        foreach ($xzv_153[1] as $xzv_31 => $xzv_155) {
            if ($xzv_31 <= 0) {
                $xzv_25 = '<ol class="catalogue_list">';
            } else {
                if ($xzv_155 > $xzv_153[1][$xzv_31 - 1]) {
                    if ($xzv_155 - $xzv_153[1][$xzv_31 - 1] == 1) {
                        $xzv_25.= '<ol>';
                    } elseif ($xzv_155 == $xzv_153[1][$xzv_31 - 1]) {
                    } else {
                        $xzv_25.= __('文章目录层级不合法', 'salong');
                        return false;
                    }
                }
            }
            $xzv_191 = strip_tags($xzv_153[2][$xzv_31]);
            $xzv_57 = str_replace($xzv_153[0][$xzv_31], '<h' . $xzv_155 . ' id="index-' . $xzv_31 . '">' . $xzv_191 . '</h' . $xzv_155 . '>', $xzv_57);
            $xzv_25.= '<li class="h' . $xzv_155 . '"><a rel="contents chapter" href="#index-' . $xzv_31 . '">' . $xzv_191 . '</a></li>';
            if ($xzv_31 < $xzv_192 - 1) {
                if ($xzv_155 > $xzv_153[1][$xzv_31 + 1]) {
                    $xzv_27 = $xzv_155 - $xzv_153[1][$xzv_31 + 1];
                    for ($xzv_28 = 0;$xzv_28 < $xzv_27;$xzv_28++) {
                        $xzv_151.= '</ol>';
                        $xzv_25.= $xzv_151;
                        $xzv_151 = '';
                    }
                }
            } else {
                $xzv_25.= '</ol>';
            }
        }
        $xzv_25 = '<nav class="post_catalogue box" role="navigation"><h3>' . __('文章目录', 'salong') . '</h3>' . $xzv_25 . '</nav>';
        $xzv_57 = $xzv_57 . $xzv_25;
    endif;
    return $xzv_57;
}
add_filter('the_content', 'article_index');
function getSslPage($xzv_243) {
    $xzv_84 = curl_init();
    curl_setopt($xzv_84, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($xzv_84, CURLOPT_HEADER, false);
    curl_setopt($xzv_84, CURLOPT_URL, $xzv_243);
    curl_setopt($xzv_84, CURLOPT_REFERER, $xzv_243);
    curl_setopt($xzv_84, CURLOPT_RETURNTRANSFER, true);
    $xzv_6 = curl_exec($xzv_84);
    curl_close($xzv_84);
    return $xzv_6;
}
function get_youku_video_thumb() {
    global $post;
    global $salong;
    $xzv_144 = $salong['client_id'];
    $xzv_183 = get_post_meta($post->ID, 'youku_id', true);
    if ($salong['switch_update_youku_thumb']) {
        if ($xzv_183) {
            $xzv_143 = "https://api.youku.com/videos/show.json?video_id=$xzv_183&client_id={$xzv_144}";
            $xzv_237 = getSslPage($xzv_143);
            if ($xzv_237) {
                $xzv_217 = json_decode($xzv_237, true);
                $xzv_216 = $xzv_217['data'][0];
                $xzv_0 = $xzv_217['bigThumbnail'];
                if ($xzv_0 != '') {
                    update_post_meta($post->ID, '_youku_thumb', $xzv_0);
                }
            }
        } else {
            global $salong;
            $xzv_0 = $salong['default_thumb']['url'];
        }
    } else {
        if (get_post_meta($post->ID, '_youku_thumb', true)) {
            $xzv_0 = get_post_meta($post->ID, '_youku_thumb', true);
        } else {
            if ($xzv_183) {
                $xzv_143 = "https://api.youku.com/videos/show.json?video_id=$xzv_183&client_id={$xzv_144}";
                $xzv_237 = getSslPage($xzv_143);
                if ($xzv_237) {
                    $xzv_217 = json_decode($xzv_237, true);
                    $xzv_216 = $xzv_217['data'][0];
                    $xzv_0 = $xzv_217['bigThumbnail'];
                    if ($xzv_0 != '') {
                        update_post_meta($post->ID, '_youku_thumb', $xzv_0);
                    }
                }
            } else {
                global $salong;
                $xzv_0 = $salong['default_thumb']['url'];
            }
        }
    }
    return $xzv_0;
}
add_filter('pre_option_link_manager_enabled', '__return_true');
function salong_archive_link($xzv_171 = true) {
    $xzv_75 = false;
    if (is_front_page()) {
        $xzv_75 = home_url('/');
    } else if (is_home() && 'page' == get_option('show_on_front')) {
        $xzv_75 = get_permalink(get_option('page_for_posts'));
    } else if (is_tax() || is_tag() || is_category()) {
        $xzv_78 = get_queried_object();
        $xzv_75 = get_term_link($xzv_78, $xzv_78->taxonomy);
    } else if (is_post_type_archive()) {
        $xzv_75 = get_post_type_archive_link(get_post_type());
    } else if (is_author()) {
        $xzv_75 = get_author_posts_url(get_query_var('author'), get_query_var('author_name'));
    } else if (is_archive()) {
        if (is_date()) {
            if (is_day()) {
                $xzv_75 = get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
            } else if (is_month()) {
                $xzv_75 = get_month_link(get_query_var('year'), get_query_var('monthnum'));
            } else if (is_year()) {
                $xzv_75 = get_year_link(get_query_var('year'));
            }
        }
    }
    if ($xzv_171 && $xzv_75 && get_query_var('paged') > 1) {
        global $wp_rewrite;
        if (!$wp_rewrite->using_permalinks()) {
            $xzv_75 = add_query_arg('paged', get_query_var('paged'), $xzv_75);
        } else {
            $xzv_75 = user_trailingslashit(trailingslashit($xzv_75) . trailingslashit($wp_rewrite->pagination_base) . get_query_var('paged'), 'archive');
        }
    }
    return $xzv_75;
}
add_filter('the_content', 'v13_seo_wl');
function v13_seo_wl($xzv_1) {
    $xzv_215 = '<a\s[^>]*href=("??)([^" >]*?)\1[^>]*>';
    if (preg_match_all("/$xzv_215/siU", $xzv_1, $xzv_165, PREG_SET_ORDER)) {
        if (!empty($xzv_165)) {
            $xzv_83 = get_option('siteurl');
            for ($xzv_160 = 0;$xzv_160 < count($xzv_165);$xzv_160++) {
                $xzv_7 = $xzv_165[$xzv_160][0];
                $xzv_72 = $xzv_165[$xzv_160][0];
                $xzv_219 = $xzv_165[$xzv_160][0];
                $xzv_15 = '';
                $xzv_68 = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
                preg_match($xzv_68, $xzv_72, $xzv_12, PREG_OFFSET_CAPTURE);
                if (count($xzv_12) < 1) $xzv_15.= ' rel="nofollow" ';
                $xzv_11 = strpos($xzv_219, $xzv_83);
                if ($xzv_11 === false) {
                    $xzv_7 = rtrim($xzv_7, '>');
                    $xzv_7.= $xzv_15 . '>';
                    $xzv_1 = str_replace($xzv_72, $xzv_7, $xzv_1);
                }
            }
        }
    }
    $xzv_1 = str_replace(']]>', ']]>', $xzv_1);
    return $xzv_1;
}
function salong_points_rewards() {
    global $wc_points_rewards;
    if (function_exists('woocommerce_points_rewards_my_points')) {
        echo '<section class="my_points">';
        echo woocommerce_points_rewards_my_points();
        echo '</section>';
    } else {
        echo __('请安装WooCommerce Points and Rewards插件', 'salong');
    }
}
add_shortcode('points_rewards', 'salong_points_rewards');
function deletehtml($xzv_87) {
    $xzv_87 = trim($xzv_87);
    $xzv_87 = strip_tags($xzv_87, '');
    return ($xzv_87);
}
add_filter('category_description', 'deletehtml');
function enable_more_buttons($xzv_34) {
    $xzv_34[] = 'hr';
    $xzv_34[] = 'del';
    $xzv_34[] = 'sub';
    $xzv_34[] = 'sup';
    $xzv_34[] = 'fontselect';
    $xzv_34[] = 'fontsizeselect';
    $xzv_34[] = 'cleanup';
    $xzv_34[] = 'styleselect';
    $xzv_34[] = 'wp_page';
    $xzv_34[] = 'anchor';
    $xzv_34[] = 'backcolor';
    return $xzv_34;
}
add_filter('mce_buttons_3', 'enable_more_buttons');
function wp_remove_open_sans_from_wp_core() {
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}
add_action('init', 'wp_remove_open_sans_from_wp_core');
function BYMT_comment_post($xzv_236) {
    $xzv_49 = '/[一-龥]/u';
    $xzv_220 = '/[ぁ-ん]+|[ァ-ヴ]+/u';
    if (!preg_match($xzv_49, $xzv_236['comment_content'])) {
        err('写点汉字吧，博主英文过了四级，但还是不认识英文！Please write some chinese words！');
    }
    if (preg_match($xzv_220, $xzv_236['comment_content'])) {
        err('日文滚粗！Japanese Get out！日本語出て行け！');
    }
    return ($xzv_236);
}
add_filter('preprocess_comment', 'BYMT_comment_post');
function in_comment_post_like($xzv_51, $xzv_231) {
    foreach ($xzv_231 as $xzv_213) {
        if (strstr($xzv_51, $xzv_213)) {
            return true;
        }
    }
    return false;
}
function drop_bad_comments() {
    if (!empty($_POST['comment'])) {
        $xzv_118 = $_POST['comment'];
        $xzv_50 = strtolower($_POST['comment']);
        $xzv_120 = array('www.', '.com', '.cn', '.net', '.html', '.php', 'http:');
        if (in_comment_post_like($xzv_50, $xzv_120)) {
            $xzv_214 = wordwrap(trim($xzv_118), 80, '
  ', true);
            $xzv_206 = fopen('/var/log/httpd/wp_post-logger/nullamatix.com-text-area_dropped.txt', 'a');
            fwrite($xzv_206, '  --------------
  [COMMENT] = ' . $xzv_118 . '
  --------------
');
            fwrite($xzv_206, '  [SOURCE_IP] = ' . $_SERVER['REMOTE_ADDR'] . ' @ ' . date('F j, Y, g:i a') . '
');
            fwrite($xzv_206, '  [USERAGENT] = ' . $_SERVER['HTTP_USER_AGENT'] . '
');
            fwrite($xzv_206, '  [REFERER  ] = ' . $_SERVER['HTTP_REFERER'] . '
');
            fwrite($xzv_206, '  [FILE_NAME] = ' . $_SERVER['SCRIPT_NAME'] . ' - [REQ_URI] = ' . $_SERVER['REQUEST_URI'] . '
');
            fwrite($xzv_206, '--------------**********------------------' . '
');
            header('HTTP/1.1 406 Not Acceptable');
            header('Status: 406 Not Acceptable');
            header('Connection: Close');
            wp_die(__('砰 砰 砰…'));
        }
    }
}
add_action('init', 'drop_bad_comments');
function getPostViews($xzv_230) {
    global $salong;
    $xzv_205 = 'views';
    $xzv_208 = get_post_meta($xzv_230, $xzv_205, true);
    if ($salong['switch_filter_count']) {
        $xzv_38 = salong_format_count($xzv_208);
    } else {
        $xzv_38 = $xzv_208;
    }
    if ($xzv_38 == '') {
        delete_post_meta($xzv_230, $xzv_205);
        add_post_meta($xzv_230, $xzv_205, '0');
        return '0';
    }
    return $xzv_38 . '';
}
function setPostViews($xzv_229) {
    $xzv_80 = 'views';
    $xzv_86 = get_post_meta($xzv_229, $xzv_80, true);
    if ($xzv_86 == '') {
        $xzv_86 = 0;
        delete_post_meta($xzv_229, $xzv_80);
        add_post_meta($xzv_229, $xzv_80, '0');
    } else {
        $xzv_86++;
        update_post_meta($xzv_229, $xzv_80, $xzv_86);
    }
}
function change_footer_admin() {
    return '<a>chen本布衣</a>';
}
add_filter('admin_footer_text', 'change_footer_admin', 9999);
function change_footer_version() {
    return '&nbsp;';
}
add_filter('update_footer', 'change_footer_version', 9999);
global $salong;
if ($salong['switch_smtp']) {
    function mail_smtp($xzv_85) {
        global $salong;
        $xzv_85->IsSMTP();
        $xzv_85->FromName = sanitize_text_field($salong['smtp_name']);
        $xzv_85->From = sanitize_text_field($salong['smtp_username']);
        $xzv_85->Username = sanitize_text_field($salong['smtp_username']);
        $xzv_85->Password = sanitize_text_field($salong['smtp_password']);
        $xzv_85->Host = sanitize_text_field($salong['smtp_host']);
        $xzv_85->Port = intval($salong['smtp_port']);
        $xzv_85->SMTPAuth = true;
        if ($salong['switch_secure']) {
            $xzv_85->SMTPSecure = 'ssl';
        }
    }
    add_action('phpmailer_init', 'mail_smtp');
}
remove_filter('the_content', 'wptexturize');
function salong_is_administrator() {
    $xzv_82 = wp_get_current_user();
    if (!empty($xzv_82->roles) && in_array('administrator', $xzv_82->roles)) return 1;
    else return 0;
}
function salong_is_weixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}
function get_page_id_from_template($xzv_70) {
    global $wpdb;
    $xzv_233 = $wpdb->get_var($wpdb->prepare("SELECT `post_id`
                              FROM `$wpdb->postmeta`, `$wpdb->posts`
                              WHERE `post_id` = `ID`
                                    AND `post_status` = 'publish'
                                    AND `meta_key` = '_wp_page_template'
                                    AND `meta_value` = %s
                                    LIMIT 1;", $xzv_70));
    return $xzv_233;
}
function new_open_link() {
    global $salong;
    $xzv_235 = '';
    if ($salong['switch_new_open_link']) {
        $xzv_235.= ' target="_blank"';
    }
    return $xzv_235;
}
function salong_edit_porfile() {
    global $salong, $wp_query, $current_user;
    $xzv_42 = $current_user->ID;
    $xzv_59 = $current_user->display_name;
    $xzv_132 = $current_user->user_url;
    $xzv_58 = $current_user->user_email;
    $xzv_234 = $current_user->description;
    $xzv_129 = '';
    if (isset($_POST['update']) && wp_verify_nonce(trim($_POST['_wpnonce']), 'check-nonce')) {
        $xzv_129 = __('没有发生变化', 'salong');
        $xzv_61 = sanitize_text_field($_POST['update']);
        if ($xzv_61 == 'info') {
            $xzv_45 = wp_update_user(array('ID' => $xzv_42, 'display_name' => sanitize_text_field($_POST['display_name']), 'user_url' => esc_url($_POST['url']), 'description' => $_POST['description'],));
            if (!is_wp_error($xzv_45)) $xzv_129 = __('<div class="infobox">基本信息已更新', 'salong');
        }
        if ($xzv_61 == 'pass') {
            $xzv_139 = array();
            $xzv_139['ID'] = $xzv_42;
            $xzv_139['user_email'] = sanitize_text_field($_POST['email']);
            if (!empty($_POST['pass1']) && !empty($_POST['pass2']) && $_POST['pass1'] === $_POST['pass2']) $xzv_139['user_pass'] = sanitize_text_field($_POST['pass1']);
            $xzv_42 = wp_update_user($xzv_139);
            if (!is_wp_error($xzv_42)) $xzv_129 = __('<div class="infobox">账号修改已更新', 'salong');
        }
        $xzv_129.= ' <a href="">' . __('[点击刷新]', 'salong') . '</a></div>';
    }
    echo '<section class="form_secton">';
    if ($xzv_129) {
        echo '<p class="hint">' . $xzv_129 . '</p>';
    }
    echo '<form id="info-form" class="contribute_form" role="form" method="POST" action="">';
    echo '<input type="hidden" name="update" value="info">';
    echo '<input type="hidden" name="_wpnonce" value="' . wp_create_nonce('check-nonce') . '">';
    echo '<section class="page-header"><h3>' . __('基本信息', 'salong') . '</h3></section>';
    echo '<p><label for="display_name">' . __('昵称 (必填)', 'salong') . '</label><input type="text" id="display_name" name="display_name" value="' . $xzv_59 . '" required></p>';
    echo '<p><label for="url">' . __('网站', 'salong') . '</label><input type="text" id="url" name="url" value="' . $xzv_132 . '"></p>';
    echo '<p><label for="description">' . __('个人说明', 'salong') . '</label><textarea rows="3" name="description" id="description">' . $xzv_234 . '</textarea></p>';
    echo do_shortcode('[frontend_avatar_upload]');
    echo '<p><input type="submit" value="保存更改" class="submit" /></p>';
    echo '</form><hr>';
    echo '<form id="pass-form" class="contribute_form" role="form" method="post">';
    echo '<input type="hidden" name="update" value="pass">';
    echo '<input type="hidden" name="_wpnonce" value="' . wp_create_nonce('check-nonce') . '">';
    echo '<section class="page-header"><h3 id="pass">' . __('账号修改', 'salong') . '</h3></section>';
    echo '<p><label for="email">' . __('电子邮件 (必填)', 'salong') . '</label><input type="text" id="email" name="email" value="' . $xzv_58 . '" required></p>';
    echo '<p><label for="pass1">' . __('新密码', 'salong') . '</label><input type="password" id="pass1" name="pass1"><span class="help-block">' . __('如果需要修改密码，请输入新的密码，不改则留空。', 'salong') . '</span></p>';
    echo '<p><label for="pass2">' . __('重复新密码', 'salong') . '</label><input type="password" id="pass2" name="pass2"><span class="help-block">' . __('再输入一遍新密码，提示：密码最好至少包含7个字符，为了保证密码强度，使用大小写字母、数字和符号结合。', 'salong') . '</span></p>';
    echo '<p><input type="submit" value="保存更改" class="submit" /></p>';
    echo '</form>';
    echo '</section>';
}
add_shortcode('edit_porfile', 'salong_edit_porfile');
global $salong;
if ($salong['switch_user_media']) {
    function my_upload_media($xzv_136) {
        global $current_user, $pagenow;
        if (!is_a($current_user, 'WP_User')) return;
        if ('admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments') return;
        if (!current_user_can('manage_options') && !current_user_can('manage_media_library')) $xzv_136->set('author', $current_user->ID);
        return;
    }
    add_action('pre_get_posts', 'my_upload_media');
    function my_media_library($xzv_65) {
        if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/upload.php') !== false) {
            if (!current_user_can('manage_options') && !current_user_can('manage_media_library')) {
                global $current_user;
                $xzv_65->set('author', $current_user->id);
            }
        }
    }
    add_filter('parse_query', 'my_media_library');
}
global $salong;
if ($salong['switch_upload_filter']) {
    add_filter('wp_handle_upload_prefilter', 'custom_upload_filter');
    function custom_upload_filter($xzv_119) {
        $xzv_64 = pathinfo($xzv_119['name']);
        $xzv_69 = $xzv_64['extension'];
        $xzv_186 = date('YmdHis') . rand(10, 99);
        $xzv_119['name'] = $xzv_186 . '.' . $xzv_69;
        return $xzv_119;
    }
}
global $salong;
if ($salong['switch_contributor_uploads']) {
    function salong_default_role() {
        if (get_option('default_role') != 'contributor') update_option('default_role', 'contributor');
    }
    add_action('admin_menu', 'salong_default_role');
    function salong_allow_contributor_uploads() {
        if (current_user_can('contributor') && !current_user_can('upload_files')) {
            $xzv_79 = get_role('contributor');
            $xzv_79->add_cap('upload_files');
        }
    }
    add_action('admin_init', 'salong_allow_contributor_uploads');
}
global $salong;
if ($salong['switch_upload_mimes']) {
    add_filter('upload_mimes', 'custom_upload_mimes');
    function custom_upload_mimes($xzv_60 = array()) {
        $xzv_60 = array('jpg|jpeg|jpe' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png',);
        return $xzv_60;
    }
}
global $salong;
if ($salong['switch_tougao_notify']) {
    function tougao_notify($xzv_137) {
        $xzv_41 = get_post_meta($xzv_137->ID, 'salong_tougao_email', true);
        if (!empty($xzv_41)) {
            $xzv_135 = '您在' . get_option('blogname') . '的投稿已发布';
            $xzv_232 = '
            <p><strong>' . get_option('blogname') . '</strong> 提醒您: 您投递的文章 <strong>' . $xzv_137->post_title . '</strong> 已发布</p>

            <p>您可以点击以下链接查看具体内容:<br />
            <a href="' . get_permalink($xzv_137->ID) . '">点此查看完整內容</a></p>
            <p>===================================================================</p>
            <p><strong>感谢您对 <a href="' . get_home_url() . '" target="_blank">' . get_option('blogname') . '</a> 的关注和支持</strong></p>
            <p><strong>该信件由系统自动发出, 请勿回复, 谢谢.</strong></p>';
            add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
            @wp_mail($xzv_41, $xzv_135, $xzv_232);
        }
    }
    add_action('draft_to_publish', 'tougao_notify', 6);
    add_action('pending_to_publish', 'tougao_notify', 6);
}
if ($salong['switch_admin_link']) {
    add_action('login_enqueue_scripts', 'login_protection');
    function login_protection() {
        global $salong;
        if ($_GET['' . $salong['admin_word'] . ''] != '' . $salong['admin_press'] . '') header('Location: ' . get_home_url() . '');
    }
}
if ($salong['switch_incoming_comment']) {
    function salong_usecheck($xzv_180) {
        $xzv_181 = 0;
        global $salong;
        if (trim($xzv_180['comment_author_email']) == '' . $salong['admin_email'] . '') $xzv_181 = 1;
        if (!$xzv_181) return $xzv_180;
        wp_die(__('请勿冒充博主发表评论', 'salong'));
    }
    if (!is_user_logged_in()) add_filter('preprocess_comment', 'salong_usecheck');
}
if ($salong['switch_weihu']) {
    function wp_maintenance_mode() {
        if (!current_user_can('edit_themes') || !is_user_logged_in()) {
            wp_die('' . sprintf(__('%s临时维护中，请稍后访问，给您带来的不便，敬请谅解！', 'salong'), esc_attr(get_option('blogname'))) . '', '' . sprintf(__('%s维护中', 'salong'), esc_attr(get_option('blogname'))) . '', array('response' => '503'));
        }
    }
    add_action('get_header', 'wp_maintenance_mode');
}
function block_admin_access() {
    global $pagenow, $salong;
    if (defined('WP_CLI')) {
        return;
    }
    $xzv_40 = $salong['admin_access'];
    $xzv_77 = array('admin-ajax.php', 'admin-post.php', 'async-upload.php', 'media-upload.php');
    $xzv_74 = get_page_link(get_page_id_from_template('template-center.php'));
    if (!current_user_can($xzv_40) && !in_array($pagenow, $xzv_77)) {
        wp_redirect($xzv_74);
        die;
    }
}
add_action('admin_init', 'block_admin_access');
if ($salong['switch_author_id']) {
    function lxtx_remove_comment_body_author_class($xzv_179) {
        foreach ($xzv_179 as $xzv_88 => $xzv_127) {
            if (strstr($xzv_127, 'comment-author-') || strstr($xzv_127, 'author-')) {
                unset($xzv_179[$xzv_88]);
            }
        }
        return $xzv_179;
    }
    add_filter('comment_class', 'lxtx_remove_comment_body_author_class');
    add_filter('body_class', 'lxtx_remove_comment_body_author_class');
    add_filter('author_link', 'yundanran_author_link', 10, 2);
    function yundanran_author_link($xzv_126, $xzv_53) {
        global $wp_rewrite;
        $xzv_53 = (int)$xzv_53;
        $xzv_126 = $wp_rewrite->get_author_permastruct();
        if (empty($xzv_126)) {
            $xzv_163 = home_url('/');
            $xzv_126 = $xzv_163 . '?author=' . $xzv_53;
        } else {
            $xzv_126 = str_replace('%author%', $xzv_53, $xzv_126);
            $xzv_126 = home_url(user_trailingslashit($xzv_126));
        }
        return $xzv_126;
    }
    add_filter('request', 'yundanran_author_link_request');
    function yundanran_author_link_request($xzv_76) {
        if (array_key_exists('author_name', $xzv_76)) {
            global $wpdb;
            $xzv_71 = $xzv_76['author_name'];
            if ($xzv_71) {
                $xzv_76['author'] = $xzv_71;
                unset($xzv_76['author_name']);
            }
        }
        return $xzv_76;
    }
}
if (wp_is_mobile()) {
    add_filter('show_admin_bar', '__return_false');
} else {
    $access_level = $salong['admin_access'];
    if ($salong['switch_admin_bar']) {
        if (!current_user_can($access_level)) {
            add_filter('show_admin_bar', '__return_false');
        }
    } else {
        add_filter('show_admin_bar', '__return_false');
    }
}
function salong_center_page() {
    global $current_user, $salong, $pagenow;
    $xzv_73 = is_ssl() && !is_admin() ? 'https' : 'http';
    $xzv_174 = $xzv_73 . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $xzv_182 = get_page_link($salong['user_add_email_page']);
    $xzv_81 = get_page_link(get_page_id_from_template('template-center.php'));
    if (is_user_logged_in()) {
        if ($salong['switch_user_add_email'] && !$current_user->user_email && $xzv_174 != $xzv_182) {
            wp_redirect($xzv_182);
            die;
        } else if (is_page_template('template-login.php')) {
            wp_redirect($xzv_81);
            die;
        }
    } else {
        if (is_page_template('template-wpuf.php') || is_page_template('template-center.php')) {
            wp_redirect(home_url());
            die;
        } else if (get_option('users_can_register') == 0 && is_page_template('template-login.php')) {
            wp_redirect(home_url());
            die;
        }
    }
}
add_action('wp', 'salong_center_page', 3);
global $salong;
if ($salong['switch_filter_time']) {
    function salong_filter_time() {
        global $post;
        $xzv_244 = time();
        $xzv_30 = get_the_time('U');
        $xzv_32 = (int)abs($xzv_244 - $xzv_30);
        if ($xzv_32 <= 3600) {
            $xzv_154 = round($xzv_32 / 60);
            if ($xzv_154 <= 1) {
                $xzv_154 = 1;
            }
            $xzv_55 = sprintf(_n('%s 分钟', '%s 分钟', $xzv_154), $xzv_154) . __('前', 'salong');
        } else if (($xzv_32 <= 86400) && ($xzv_32 > 3600)) {
            $xzv_241 = round($xzv_32 / 3600);
            if ($xzv_241 <= 1) {
                $xzv_241 = 1;
            }
            $xzv_55 = sprintf(_n('%s 小时', '%s 小时', $xzv_241), $xzv_241) . __('前', 'salong');
        } elseif ($xzv_32 >= 86400) {
            $xzv_157 = round($xzv_32 / 86400);
            if ($xzv_157 <= 1) {
                $xzv_157 = 1;
                $xzv_55 = sprintf(_n('%s 天', '%s 天', $xzv_157), $xzv_157) . __('前', 'salong');
            } elseif ($xzv_157 > 29) {
                $xzv_55 = get_the_time(get_option('date_format'));
            } else {
                $xzv_55 = sprintf(_n('%s 天', '%s 天', $xzv_157), $xzv_157) . __('前', 'salong');
            }
        }
        return $xzv_55;
    }
    add_filter('the_time', 'salong_filter_time');
}
if ($salong['switch_filter_count']) {
    function salong_format_count($xzv_173) {
        $xzv_228 = 2;
        if ($xzv_173 >= 1000 && $xzv_173 < 10000) {
            $xzv_238 = number_format($xzv_173 / 1000, $xzv_228) . 'K';
        } else if ($xzv_173 >= 10000 && $xzv_173 < 1000000) {
            $xzv_238 = number_format($xzv_173 / 10000, $xzv_228) . 'W';
        } else if ($xzv_173 >= 1000000 && $xzv_173 < 1000000000) {
            $xzv_238 = number_format($xzv_173 / 1000000, $xzv_228) . 'M';
        } else if ($xzv_173 >= 1000000000) {
            $xzv_238 = number_format($xzv_173 / 1000000000, $xzv_228) . 'B';
        } else {
            $xzv_238 = $xzv_173;
        }
        $xzv_238 = str_replace('.00', '', $xzv_238);
        return $xzv_238;
    }
}
if ($salong['switch_useradd_time']) {
    class RRHE {
        public static function registerdate($xzv_158) {
            $xzv_158['registerdate'] = __('注册时间', 'registerdate');
            return $xzv_158;
        }
        public static function registerdate_columns($xzv_169, $xzv_66, $xzv_63) {
            if ('registerdate' != $xzv_66) return $xzv_169;
            $xzv_67 = get_userdata($xzv_63);
            $xzv_56 = get_date_from_gmt($xzv_67->user_registered);
            return $xzv_56;
        }
        public static function registerdate_column_sortable($xzv_89) {
            $xzv_161 = array('registerdate' => 'registered',);
            return wp_parse_args($xzv_161, $xzv_89);
        }
        public static function registerdate_column_orderby($xzv_18) {
            if (isset($xzv_18['orderby']) && 'registerdate' == $xzv_18['orderby']) {
                $xzv_18 = array_merge($xzv_18, array('meta_key' => 'registerdate', 'orderby' => 'meta_value'));
            }
            return $xzv_18;
        }
    }
    add_filter('manage_users_columns', array('RRHE', 'registerdate'));
    add_action('manage_users_custom_column', array('RRHE', 'registerdate_columns'), 15, 3);
    add_filter('manage_users_sortable_columns', array('RRHE', 'registerdate_column_sortable'));
    add_filter('request', array('RRHE', 'registerdate_column_orderby'));
}
global $salong;
if ($salong['switch_link_go']) {
    add_filter('the_content', 'link_to_jump', 999);
    function link_to_jump($xzv_111) {
        preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/', $xzv_111, $xzv_112);
        if ($xzv_112) {
            foreach ($xzv_112[2] as $xzv_5) {
                if (strpos($xzv_5, '://') !== false && strpos($xzv_5, home_url()) === false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i', $xzv_5) && !preg_match('/(ed2k|thunder|Flashget|flashget|qqdl):\/\//i', $xzv_5)) {
                    $xzv_111 = str_replace("href=\"$xzv_5\"", 'href="' . get_home_url() . "/go.php?url=$xzv_5\" ", $xzv_111);
                }
            }
        }
        return $xzv_111;
    }
    function commentauthor($xzv_3 = 0) {
        $xzv_167 = get_comment_author_url($xzv_3);
        $xzv_178 = get_comment_author($xzv_3);
        if (empty($xzv_167) || 'http://' == $xzv_167) echo $xzv_178;
        else echo "<a href='" . get_home_url() . "/go.php?url=$xzv_167' rel='external nofollow' target='_blank' class='url'>$xzv_178</a>";
    }
    function external_link($xzv_103) {
        if (strpos($xzv_103, '://') !== false && strpos($xzv_103, home_url()) === false && !preg_match('/(ed2k|thunder|Flashget|flashget|qqdl):\/\//i', $xzv_103)) {
            $xzv_103 = str_replace($xzv_103, get_home_url() . '/go.php?url=' . $xzv_103, $xzv_103);
        }
        return $xzv_103;
    }
}
if ($salong['switch_upload_path']) {
    if (get_option('upload_path') == 'wp-content/uploads' || get_option('upload_path') == null) {
        update_option('upload_path', WP_CONTENT_DIR . '/uploads');
    }
}
if ($salong['switch_date_default']) {
    date_default_timezone_set('Asia/Shanghai');
}
if ($salong['remove_category_slug']) {
    require_once get_template_directory() . '/includes/no-category.php';
}
if ($salong['switch_feed']) {
    function salong_disable_feed() {
        wp_die(__('<h1>本博客不再提供 Feed，请访问网站<a href="' . get_bloginfo('url') . '">首页</a>！</h1>'));
    }
    add_action('do_feed', 'salong_disable_feed', 1);
    add_action('do_feed_rdf', 'salong_disable_feed', 1);
    add_action('do_feed_rss', 'salong_disable_feed', 1);
    add_action('do_feed_rss2', 'salong_disable_feed', 1);
    add_action('do_feed_atom', 'salong_disable_feed', 1);
}
if ($salong['switch_header_code']) {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('template_redirect', 'wp_shortlink_header', 11, 0);
    remove_action('wp_head', 'wp_resource_hints', 2);
}
if ($salong['switch_capital_P_dangit']) {
    remove_filter('the_content', 'capital_P_dangit');
    remove_filter('the_title', 'capital_P_dangit');
    remove_filter('comment_text', 'capital_P_dangit');
}
if ($salong['switch_shortcode_unautop']) {
    remove_filter('the_content', 'shortcode_unautop');
    add_filter('the_content', 'shortcode_unautop', 13);
}
if ($salong['switch_rest_api']) {
    remove_action('init', 'rest_api_init');
    remove_action('rest_api_init', 'rest_api_default_filters', 10);
    remove_action('parse_request', 'rest_api_loaded');
    add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);
}
if ($salong['switch_wp_oembed']) {
    remove_filter('the_content', array($GLOBALS['wp_embed'], 'run_shortcode'), 8);
    remove_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);
    remove_action('pre_post_update', array($GLOBALS['wp_embed'], 'delete_oembed_caches'));
    remove_action('edit_form_advanced', array($GLOBALS['wp_embed'], 'maybe_run_ajax_cache'));
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
    add_filter('embed_oembed_discover', '__return_false');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_filter('oembed_response_data', 'get_oembed_response_data_rich', 10, 4);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    add_filter('tiny_mce_plugins', 'salong_disable_post_embed_tiny_mce_plugin');
    function salong_disable_post_embed_tiny_mce_plugin($xzv_145) {
        return array_diff($xzv_145, array('wpembed'));
    }
    add_filter('query_vars', 'salong_disable_post_embed_query_var');
    function salong_disable_post_embed_query_var($xzv_101) {
        return array_diff($xzv_101, array('embed'));
    }
}
if ($salong['switch_dashboard_widgets']) {
    add_action('wp_dashboard_setup', 'salong_remove_dashboard_widgets');
    function salong_remove_dashboard_widgets() {
        global $wp_meta_boxes;
        unset($wp_meta_boxes['dashboard']['normal']);
        unset($wp_meta_boxes['dashboard']['side']);
    }
}
if ($salong['switch_staticize_emoji']) {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
if ($salong['switch_wp_cron']) {
    defined('DISABLE_WP_CRON');
    remove_action('init', 'wp_cron');
}
if ($salong['switch_xmlrpc_enabled']) {
    add_filter('xmlrpc_enabled', '__return_false');
}
if ($salong['switch_pingback']) {
    add_filter('xmlrpc_methods', 'salong_xmlrpc_methods');
    function salong_xmlrpc_methods($xzv_100) {
        $xzv_100['pingback.ping'] = '__return_false';
        $xzv_100['pingback.extensions.getPingbacks'] = '__return_false';
        return $xzv_100;
    }
    remove_action('do_pings', 'do_all_pings', 10, 1);
    remove_action('publish_post', '_publish_post_hook', 5, 1);
}
if ($salong['switch_admin_color_schemes']) {
    remove_action('admin_init', 'register_admin_color_schemes', 1);
    remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
}
if ($salong['switch_update_core']) {
    add_filter('pre_site_transient_update_core', '__return_null');
    remove_action('load-update-core.php', 'wp_update_plugins');
    add_filter('pre_site_transient_update_plugins', '__return_null');
    remove_action('load-update-core.php', 'wp_update_themes');
    add_filter('pre_site_transient_update_themes', '__return_null');
}
if ($salong['switch_post_revision']) {
    add_filter('wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2);
    function specs_wp_revisions_to_keep($xzv_223, $xzv_177) {
        return 0;
    }
}
if ($salong['switch_autosave']) {
    add_action('admin_print_scripts', create_function('$a', "wp_deregister_script('autosave');"));
}
if ($salong['switch_browse_happy']) {
    add_action('admin_init', create_function('$a', "remove_action('in_admin_footer', 'browse_happy');"));
}
if ($salong['switch_recently_active_plugins']) {
    add_action('admin_head', 'disable_recently_active_plugins');
    function disable_recently_active_plugins() {
        update_option('recently_activated', array());
    }
}
if ($salong['switch_max_srcset']) {
    add_filter('max_srcset_image_width', create_function('', 'return 1;'));
}
if ($salong['switch_login_errors']) {
    add_filter('login_errors', create_function('$a', 'return null;'));
}
if ($salong['switch_redirect_single_post']) {
    add_action('template_redirect', 'salong_redirect_single_post');
    function salong_redirect_single_post() {
        if (is_search()) {
            global $wp_query;
            if ($wp_query->post_count == 1) {
                wp_redirect(get_permalink($wp_query->posts['0']->ID));
            }
        }
    }
}
if ($salong['switch_search_by_title_only']) {
    function __search_by_title_only($xzv_52, $xzv_176) {
        global $wpdb;
        if (empty($xzv_52)) {
			return $xzv_52; 
			}
        $xzv_175 = $xzv_176->query_vars;
        $xzv_106 = !empty($xzv_175['exact']) ? '' : '%';
        $xzv_52 = $xzv_54 = '';
        foreach ((array)$xzv_175['search_terms'] as $xzv_47) {
            $xzv_47 = esc_sql(like_escape($xzv_47));
            $xzv_52 .= "{$xzv_54}({$wpdb->posts}.post_title LIKE '{$xzv_106}{$xzv_47}{$xzv_106}')";
			$xzv_54 =' AND ';
			}
			if(!empty($xzv_52)){
				$xzv_52 = " AND ({$xzv_52}) ";
            if (!is_user_logged_in()) {
                $xzv_52 .= " AND ({$wpdb->posts}.post_password = '') ";
            }
        }
       	 return $xzv_52;
	}
   		 add_filter('posts_search', '__search_by_title_only', 500, 2);
}
		if($salong['switch_post_id']){
		add_filter('manage_posts_columns','salong_id_manage_posts_columns');
		add_filter('manage_pages_columns','salong_id_manage_posts_columns');
		function salong_id_manage_posts_columns($xzv_125)
		{
			$xzv_125['post_id'] = 'ID';
       	 	return $xzv_125;
    }
    add_action('manage_posts_custom_column','salong_id_manage_posts_custom_column',10,2);
	add_action('manage_pages_custom_column','salong_id_manage_posts_custom_column',10,2);
	function salong_id_manage_posts_custom_column($xzv_91,$xzv_140)
	{
		if($xzv_91=='post_id'){
			echo $xzv_140;
        }
    }
}
if ($salong['switch_remove_logo']) {
    function salong_admin_bar_remove()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    }
    add_action('wp_before_admin_bar_render', 'salong_admin_bar_remove', 0);
}
if ($salong['switch_shortcode_auto'] && is_single()) {
    remove_filter('the_content', 'wpautop');
    add_filter('the_content', 'wpautop', 12);
}
if ($salong['switch_content_auto']) {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
}