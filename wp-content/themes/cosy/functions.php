<?php
date_default_timezone_set('PRC');
define('THEME_VERSION', '0.0.1');
require_once get_template_directory() . '/core/framework/cs-framework.php';
if (cs_get_option('site_seo_switch')) {
    include get_template_directory() . '/core/functions/seo.php';
}
if (cs_get_option('breadcrumbs')) {
    include get_template_directory() . '/core/functions/breadcrumbs.php';
}
include get_template_directory() . '/core/functions/rocket.php';
include get_template_directory() . '/core/functions/emoji/emoji.php';
include get_template_directory() . '/core/widgets/index.php';
include get_template_directory() . '/core/functions/ajax-comment/do.php';
include get_template_directory() . '/core/functions/share/share.php';
include get_template_directory() . '/core/functions/share/custom_share.php';
register_nav_menu('head-nav', '头部菜单');
register_nav_menu('mobile-nav', '移动端头部菜单');
register_nav_menu('mobile-warp-nav', '移动端抽屉菜单');
register_nav_menu('footer-nav', '底部菜单');
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}
add_filter('get_avatar', 'custom_avatar', 1, 5);
add_action('wp_head', 'record_visitors');
add_filter('excerpt_length', 'custom_excerpt_length', 999);
add_filter('user_contactmethods', 'add_contact_fields');
add_filter('pre_get_posts', 'search_filter_page');
add_action('wp_ajax_nopriv_suxing_like', 'suxing_like');
add_action('wp_ajax_suxing_like', 'suxing_like');
add_action('wp_ajax_nopriv_ajax_load_posts', 'ajax_load_posts');
add_action('wp_ajax_ajax_load_posts', 'ajax_load_posts');
add_filter('comment_text', 'add_at', 10, 2);
add_action('wp_ajax_nopriv_comment_up_down', 'comment_up_down');
add_action('wp_ajax_comment_up_down', 'comment_up_down');
add_action('send_headers', 'captha_show');
add_action('preprocess_comment', 'Easy_Anti_Spam_Verification');
add_action('comment_post', 'mi_comment_mail_notify', 20, 2);
add_action('wp_set_comment_status', 'mi_comment_mail_notify', 20, 2);
add_filter('comment_text', 'comment_analysis');
add_shortcode('img', 'shortcode_img_handler');
add_shortcode('code', 'shortcode_code_handler');
add_filter('preprocess_comment', 'plc_comment_post', '', 1);
add_filter('comment_text', 'plc_comment_display', '', 1);
add_filter('comment_text_rss', 'plc_comment_display', '', 1);
add_filter('comment_excerpt', 'plc_comment_display', '', 1);
add_action('init', 'my_taxonomies_product', 0);
add_filter('manage_edit-category_columns', 'my_custom_taxonomy_columns');
add_filter('manage_edit-special_columns', 'my_custom_taxonomy_columns');
add_filter('manage_category_custom_column', 'my_custom_taxonomy_columns_content', 10, 3);
add_filter('manage_special_custom_column', 'my_custom_taxonomy_columns_content', 10, 3);
add_action('admin_head', 'smartideo_install_hook');
add_action('wp_ajax_nopriv_create-bigger-image', 'get_bigger_img');
add_action('wp_ajax_create-bigger-image', 'get_bigger_img');
add_filter('pre_get_posts', 'filter_sticky_posts');
add_action('after_setup_theme', 'timthumb_register');
include get_template_directory() . '/functions_cosy.php';
function custom_avatar($avatar, $id_or_email, $size, $default, $alt)
{
    $site_default_comment_img = cs_get_option('site_default_comment_img');
    if (isset($site_default_comment_img) && !empty($site_default_comment_img)) {
        if (empty($id_or_email)) {
            $avatar = timthumb($site_default_comment_img, array('w' => $size, 'h' => $size), 'tim');
            $avatar = '<img alt=\'' . $alt . '\' src=\'' . $avatar . '\' class=\'avatar avatar-' . $size . ' photo\' height=\'' . $size . '\' width=\'' . $size . '\' />';
        } else {
            if (is_numeric($id_or_email)) {
                $id = (int) $xz_data[$xz_k];
                $user = get_user_by('id', $id);
                $email = $user->user_email;
            } else {
                if (is_object($id_or_email) && isset($id_or_email->comment_ID)) {
                    $email = $id_or_email->comment_author_email;
                } else {
                    $email = $id_or_email;
                }
            }
            $hash = md5(strtolower(trim($email)));
            $uri = 'https://cdn.v2ex.com/gravatar/' . $hash . '?d=' . urlencode(timthumb($site_default_comment_img, array('w' => $size, 'h' => $size), 'tim'));
            $avatar = '<img alt=\'' . $alt . '\' src=\'' . $uri . '\' class=\'avatar avatar-' . $size . ' photo\' height=\'' . $size . '\' width=\'' . $size . '\' />';
        }
    }
    return $avatar;
}
function timeago($ptime)
{
    $ptime = strtotime($ptime);
    $etime = time() - 28800 - $ptime;
    if ($etime < 1) {
        return '刚刚';
    }
    date('Y-m-d', $ptime);
    date('m-d', $ptime);
    date('m-d', $ptime);
    $interval = array('12*30*24*60*60' => date('Y-m-d', $ptime), '30*24*60*60' => date('m-d', $ptime), '7*24*60*60' => date('m-d', $ptime), '24*60*60' => '天前', '60*60' => '小时前', '60' => '分钟前', '1' => '秒前');
    foreach ($interval as $str) {
        if ($etime - 00 * 60 * 60 > 0) {
            return $str;
        }
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    }
}
function record_visitors()
{
    if (is_singular()) {
        global $post;
        $post_ID = $post->ID;
        if ($post_ID) {
            get_post_meta($post_ID, 'views', true);
            $post_views = (int) $xz_data[$xz_k];
            if (!update_post_meta($post_ID, 'views', $post_views + 1)) {
                add_post_meta($post_ID, 'views', 1, true);
            }
        }
    }
}
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
    global $post;
    $post_ID = $post->ID;
    get_post_meta($post_ID, 'views', true);
    $views = (int) $xz_data[$xz_k];
    if ($echo) {
        echo $before;
        echo number_format($views);
        echo $after;
    }
    return $views;
}
function custom_excerpt_length($length)
{
    return 300;
}
function print_excerpt($length, $post = null)
{
    global $post;
    $text = $post->post_excerpt;
    if ('' == $text) {
        $text = get_the_content();
        $text = strip_shortcodes($text);
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);
    }
    $text = strip_shortcodes($text);
    $text = strip_tags($text);
    $text = substr_ext($text, 0, $length);
    $excerpt = reverse_strrchr($text, '。', 3);
    if ($excerpt) {
        echo strip_tags(apply_filters('the_excerpt', $excerpt)) . '...';
    } else {
        echo strip_tags(apply_filters('the_excerpt', $text)) . '...';
    }
}
function reverse_strrchr($haystack, $needle, $trail)
{
    $length = strrpos($haystack, $needle) + $trail;
    if (strrpos($haystack, $needle)) {
    } else {
    }
    return substr($haystack, 0, $length);
}
function substr_ext($str, $start = 0, $length, $charset = 'utf-8', $suffix = '')
{
    if (function_exists('mb_substr')) {
        return mb_substr($str, $start, $length, $charset) . $suffix;
    }
    if (function_exists('iconv_substr')) {
        return iconv_substr($str, $start, $length, $charset) . $suffix;
    }
    $re['utf-8'] = '/[-]|[?-?][?-?]|[?-?][?-?]{2}|[?-?][?-?]{3}/';
    $re['gb2312'] = '/[-]|[?-?][?-?]/';
    $re['gbk'] = '/[-]|[?-?][@-?]/';
    $re['big5'] = '/[-]|[?-?]([@-~]|?-?])/';
    preg_match_all($re[$charset], $str, $match);
    $slice = join('', array_slice($match[0], $start, $length));
    return $slice . $suffix;
}
function add_contact_fields($contactmethods)
{
    $contactmethods['qq'] = 'QQ链接';
    $contactmethods['weibo'] = '微博主页';
    $contactmethods['weixin'] = '微信二维码';
    return $contactmethods;
}
function search_filter_page($query)
{
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
function suxing_like()
{
    global $wpdb;
    global $post;
    $id = $_POST['um_id'];
    $action = $_POST['um_action'];
    if ($action == 'ding') {
        $bigfa_raters = get_post_meta($id, 'suxing_ding', true);
        $expire = time() + 99999999;
        $domain = $_SERVER['HTTP_HOST'] != 'localhost' ? $_SERVER['HTTP_HOST'] : false;
        if (!isset($_COOKIE['suxing_ding_' . $id])) {
            setcookie('suxing_ding_' . $id, $id, $expire, '/', $domain, false);
            if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
                update_post_meta($id, 'suxing_ding', 1);
            } else {
                update_post_meta($id, 'suxing_ding', $bigfa_raters + 1);
            }
            echo get_post_meta($id, 'suxing_ding', true);
        } else {
            echo 'false';
        }
    }
    exit(0);
}
function ajax_load_posts()
{
    global $wp_query;
    $page = sanitize_text_field($_POST['page']);
    $paged = sanitize_text_field($_POST['paged']);
    if ($page == 'home') {
        if (isset($_POST['tabcid'])) {
        } else {
        }
        $tabcid = sanitize_text_field($_POST['tabcid']);
        if ($tabcid) {
            $args = array_merge($wp_query->query_vars, array('paged' => $paged, 'cat' => $tabcid, 'ignore_sticky_posts' => 1));
        } else {
            $masking_cats = cs_get_option('masking_cats');
            $args = array_merge($wp_query->query_vars, array('paged' => $paged, 'ignore_sticky_posts' => 1));
            if (is_array($masking_cats)) {
                $args['category__not_in'] = $masking_cats;
            }
        }
        query_posts($args);
        if (have_posts()) {
            $index_single_layout = cs_get_option('index_single_layout');
            $GLOBALS['mii'] = $paged > 1 ? $wp_query->query_vars['posts_per_page'] * $paged - $wp_query->query_vars['posts_per_page'] + 1 : 1;
            if ($index_single_layout == 'card' || $index_single_layout == 'card-4') {
                $GLOBALS['list_hide_item'] = cs_get_option('index_list_hide_item');
                $GLOBALS['list_hide_item'] = $GLOBALS['list_hide_item'] ? $GLOBALS['list_hide_item'] : array('0' => 'none');
                while (have_posts()) {
                    the_post();
                    if (!$tabcid) {
                        get_template_part('template-parts/card-ad-topic');
                    }
                    get_template_part('template-parts/ajax-loop-card');
                }
            } else {
                while (have_posts()) {
                    the_post();
                    if (!$tabcid) {
                        get_template_part('template-parts/full-ad-topic');
                    }
                    get_template_part('template-parts/ajax-loop-full');
                }
            }
        }
    }
    if ($page == 'cat') {
        $q = sanitize_text_field($_POST['query']);
        $args = array_merge($wp_query->query_vars, array('paged' => $paged, 'cat' => $q, 'ignore_sticky_posts' => 1));
        query_posts($args);
        $term_data = get_term_meta($q, '_custom_category_options', true);
        $term_data = wp_parse_args((array) $xz_data[$xz_k], array('cat_layout' => 'card'));
        $layout = $term_data['cat_layout'] == 'full' ? $term_data['cat_layout'] : card;
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/loop', $layout);
            }
        }
    }
    if ($page == 'tag') {
        $q = sanitize_text_field($_POST['query']);
        $args = array_merge($wp_query->query_vars, array('paged' => $paged, 'tag' => $q, 'ignore_sticky_posts' => 1));
        query_posts($args);
        if (cs_get_option('tag_layout')) {
        } else {
        }
        $layout = cs_get_option('tag_layout');
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/loop', $layout);
            }
        }
    }
    if ($page == 'tax') {
        $q = sanitize_text_field($_POST['query']);
        $tax = array('0' => array('taxonomy' => 'special', 'field' => 'name', 'terms' => $q));
        $args = array_merge($wp_query->query_vars, array('paged' => $paged, 'tax_query' => $tax, 'ignore_sticky_posts' => 1));
        query_posts($args);
        if (cs_get_option('tag_layout')) {
        } else {
        }
        $layout = cs_get_option('tag_layout');
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/loop', $layout);
            }
        }
    }
    if ($page == 'search') {
        $q = sanitize_text_field($_POST['query']);
        $args = array_merge($wp_query->query_vars, array('paged' => $paged, 's' => $q, 'ignore_sticky_posts' => 1));
        query_posts($args);
        if (cs_get_option('search_layout')) {
        } else {
        }
        $layout = cs_get_option('search_layout');
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/loop', $layout);
            }
        }
    }
    if ($page == 'author') {
        $q = sanitize_text_field($_POST['query']);
        $args = array_merge($wp_query->query_vars, array('paged' => $paged, 'author_name' => $q, 'ignore_sticky_posts' => 1));
        query_posts($args);
        if (cs_get_option('author_layout')) {
        } else {
        }
        $layout = cs_get_option('author_layout');
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/loop', $layout);
            }
        }
    }
    if ($page == 'comments') {
        $q = sanitize_text_field($_POST['query']);
        if ($paged < 1 || $paged > $_POST['commentcount']) {
            exit(0);
        }
        $wp_query = new WP_Query(array('p' => $q, 'cpage' => $paged));
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                comments_template();
            }
        }
    }
    wp_reset_query();
    exit(0);
}
function dami_official($user_id = null)
{
    if ($user_id != NULL && $user_id == 1) {
        printf('<span>%s</span>', '官方');
    }
}
function mi_comment($comment, $args, $depth)
{
    global $post;
    $commentcountText = '';
    $GLOBALS['comment'] = $comment;
    include 'template-parts/comment-list.php';
}
function mi_end_comment()
{
    echo '</li>';
}
function add_at($comment_text, $comment = null)
{
    if ($comment) {
        if ($comment->comment_parent) {
            $parant_comment = get_comment($comment->comment_parent);
            $p = '<a href="#comment-' . $comment->comment_parent . '">@' . $parant_comment->comment_author . '</a>&nbsp;';
            $comment_text = $p . $comment_text;
            return $comment_text;
        }
    }
    return do_shortcode($comment_text);
}
function get_next_page_number()
{
    $page_number = get_comment_pages_count();
    if (get_option('default_comments_page') == 'newest') {
        $next_page = $page_number - 1;
    } else {
        $next_page = 2;
    }
    return $next_page;
}
function get_comment_up_down($comment_id, $action)
{
    $action = get_comment_meta($comment_id, $action, true);
    if ($action) {
        return $action;
    }
    return 0;
}
function comment_up_down()
{
    $comment_ID = $_POST['id'];
    $action = $_POST['caction'];
    $domain = $_SERVER['HTTP_HOST'] != 'localhost' ? $_SERVER['HTTP_HOST'] : false;
    $expire = time() + 99999999;
    if (!empty($comment_ID) && !empty($action)) {
        if (isset($_COOKIE['mi_comment_' . $action . '_' . $comment_ID])) {
            if ($action == 'up') {
                $msg = array('s' => 404, 'm' => '您已经顶过此条评论了！');
            } else {
                $msg = array('s' => 404, 'm' => '您已经踩过此条评论了！');
            }
        } else {
            setcookie('mi_comment_' . $action . '_' . $comment_ID, $comment_ID, $expire, '/', $domain, false);
            $old_num = get_comment_meta($comment_ID, $action);
            if ($old_num) {
                $db_action = update_comment_meta($comment_ID, $action, $old_num + 1);
                $new_num = $old_num + 1;
            } else {
                $db_action = add_comment_meta($comment_ID, $action, 1);
                $new_num = 1;
            }
            if ($db_action) {
                $msg = array('s' => 200, 'num' => $new_num);
            } else {
                $msg = array('s' => 404, 'm' => '操作失败，请稍后再试！');
            }
        }
        echo json_encode($msg);
    }
    exit(0);
}
function captha_show()
{
    if (isset($_GET['captha']) && $_GET['captha'] == 'show') {
        include get_template_directory() . '/core/functions/captcha.php';
        exit(0);
    }
    return null;
}
function Easy_Anti_Spam_Verification($comment)
{
    if (is_user_logged_in()) {
        return $comment;
    }
    if (!session_id()) {
        session_start();
    }
    $server_captcha = $_SESSION['mi_captcha'];
    $input_captcha = $_POST['captcha'];
    if (isset($server_captcha) && isset($input_captcha)) {
        unset($_SESSION['mi_captcha']);
        return $comment;
    }
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        ajax_comment_err('<p>验证码不正确！</p>');
    } else {
        wp_die('验证码不正确！');
    }
    return null;
}
function mi_comment_mail_notify($comment_id, $comment_status)
{
    if (!$comment_status === 'approve' && !$comment_status === 1) {
    }
    $comment = get_comment($comment_id);
    if (!($comment->comment_parent == '')) {
        $parent_comment = get_comment($comment->comment_parent);
        $to = trim($parent_comment->comment_author_email);
        $subject = '您在[' . get_option('blogname') . ']的留言有了新的回复';
        $message = "\n\t\t\t<p>Hi, " . $parent_comment->comment_author . "</p>\n\t\t\t<p>您之前在《" . get_the_title($comment->comment_post_ID) . '》的留言：<br />' . $parent_comment->comment_content . "</p>\n\t\t\t<p>" . $comment->comment_author . ' 给您回复:<br />' . $comment->comment_content . "<br /><br /></p>\n\t\t\t<p>您可以 <a href=\"" . htmlspecialchars(get_comment_link($comment->comment_parent)) . "\">点此查看回复完整內容</a></p>\n\t\t\t<p>欢迎再度光临 <a href=\"" . home_url() . '">' . get_option('blogname') . "</a></p>\n\t\t\t<p>（此邮件由系统自动发送，请勿回复）</p>";
        $message_headers = 'Content-Type: text/html; charset=' . get_option('blog_charset') . "\n";
        if ($to != '' && $to != get_bloginfo('admin_email')) {
            wp_mail($to, $subject, $message, $message_headers);
            error_reporting(0);
        }
    }
}
function comment_analysis($comment_text)
{
    return do_shortcode($comment_text);
}
function shortcode_img_handler($atts)
{
    $atts = wp_parse_args((array) $xz_data[$xz_k], array('src' => NULL, 'alt' => NULL));
    $is_img = preg_match('/^((http|https):\\/\\/)+.*[.](?:gif|png|jpg|jpeg|webp)$/', $atts['src']);
    if ($is_img) {
        $img = sprintf('<img src="%s" alt="%s">', $atts['src'], $atts['alt']);
        return $img;
    }
}
function shortcode_code_handler($atts, $content = null)
{
    if ($content) {
        $code = sprintf('<pre>%s</pre>', $content);
        return $code;
    }
}
function plc_comment_post($incoming_comment)
{
    $incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);
    $incoming_comment['comment_content'] = str_replace('\'', '&apos;', $incoming_comment['comment_content']);
    return $incoming_comment;
}
function plc_comment_display($comment_to_display)
{
    $comment_to_display = str_replace('&apos;', '\'', $comment_to_display);
    return $comment_to_display;
}
function my_taxonomies_product()
{
    register_taxonomy('special', 'post', array('label' => '专题标签', 'hierarchical' => false));
}
function my_custom_taxonomy_columns($columns)
{
    $columns['my_term_id'] = 'ID编号';
    return $columns;
}
function my_custom_taxonomy_columns_content($content, $column_name, $term_id)
{
    if ('my_term_id' == $column_name) {
        $content = $term_id;
    }
    return $content;
}
function smartideo_install_hook()
{
    echo '<script>';
    echo 'function open_smartideo_install_window() {';
    echo 'var url=\'' . get_bloginfo('url') . '/wp-admin/plugin-install.php?tab=plugin-information&plugin=smartideo\';';
    echo 'var iWidth=772;';
    echo 'var iHeight=671;';
    echo 'var iTop = (window.screen.availHeight - 30 - iHeight) / 2; ';
    echo 'var iLeft = (window.screen.availWidth - 10 - iWidth) / 2 ';
    echo 'window.open(url, \'_blank\', \'height=\' + iHeight + \',innerHeight=\' + iHeight + \',width=\' + iWidth + \',innerWidth=\' + iWidth + \',top=\' + iTop + \',left=\' + iLeft + \',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no\'); ';
    echo '}';
    echo '</script>';
}
function mi_str_encode($string)
{
    $len = strlen($string);
    $buf = '';
    $i = 0;
    while ($i < $len) {
        if (ord($string[$i]) <= 127) {
            $buf .= $string[$i];
        } elseif (ord($string[$i]) < 192) {
            $buf .= '&#xfffd';
        } elseif (ord($string[$i]) < 224) {
            $buf .= sprintf('&#%d;', ord($string[$i + 0]) + ord($string[$i + 1]));
            $i = $i + 1;
            $i += 1;
        } elseif (ord($string[$i]) < 240) {
            ord($string[$i + 2]);
            $buf .= sprintf('&#%d;', ord($string[$i + 0]) + ord($string[$i + 1]) + ord($string[$i + 2]));
            $i = $i + 2;
            $i += 2;
        } else {
            ord($string[$i + 2]);
            ord($string[$i + 3]);
            $buf .= sprintf('&#%d', ord($string[$i + 0]) + ord($string[$i + 1]) + ord($string[$i + 2]) + ord($string[$i + 3]));
            $i = $i + 3;
            $i += 3;
        }
        $i = $i + 1;
    }
    return $buf;
}
function draw_txt_to($card, $pos, $str, $iswrite, $font_file)
{
    $_str_h = $pos['top'];
    $fontsize = $pos['fontsize'];
    $width = $pos['width'];
    $margin_lift = $pos['left'];
    $hang_size = $pos['hang_size'];
    $temp_string = '';
    $tp = 0;
    $font_color = imagecolorallocate($card, $pos['color'][0], $pos['color'][1], $pos['color'][2]);
    $i = 0;
    while ($i < mb_strlen($str)) {
        $box = imagettfbbox($fontsize, 0, $font_file, mi_str_encode($temp_string));
        $_string_length = $box[2] - $box[0];
        $temptext = mb_substr($str, $i, 1);
        $temp = imagettfbbox($fontsize, 0, $font_file, mi_str_encode($temptext));
        if ($_string_length + $temp[2] - $temp[0] < $width) {
            $temp_string .= mb_substr($str, $i, 1);
            if ($i == mb_strlen($str) - 1) {
                $_str_h = $_str_h + $hang_size;
                $_str_h += $hang_size;
                $tp = $tp + 1;
                if ($iswrite) {
                    imagettftext($card, $fontsize, 0, $margin_lift, $_str_h, $font_color, $font_file, mi_str_encode($temp_string));
                }
            }
        } else {
            $texts = mb_substr($str, $i, 1);
            $isfuhao = preg_match('/[\\pP]/u', $texts) ? true : false;
            if ($isfuhao) {
                $temp_string .= $texts;
                $f = mb_substr($str, $i + 1, 1);
                $fh = preg_match('/[\\pP]/u', $f) ? true : false;
                if ($fh) {
                    $temp_string .= $f;
                    $i = $i + 1;
                }
            } else {
                $i = $i + -1;
            }
            $tmp_str_len = mb_strlen($temp_string);
            $s = mb_substr($temp_string, $tmp_str_len - 1, 1);
            if (is_firstfuhao($s)) {
                $temp_string = rtrim($temp_string, $s);
                $i = $i + -1;
            }
            $_str_h = $_str_h + $hang_size;
            $_str_h += $hang_size;
            $tp = $tp + 1;
            if ($iswrite) {
                imagettftext($card, $fontsize, 0, $margin_lift, $_str_h, $font_color, $font_file, mi_str_encode($temp_string));
            }
            $temp_string = '';
        }
        $i = $i + 1;
    }
    return $tp * $hang_size;
}
function is_firstfuhao($str)
{
    $fuhaos = array('0' => '"', '1' => '“', '2' => '\'', '3' => '<', '4' => '《');
    return in_array($str, $fuhaos);
}
function create_bigger_image($post_id, $date, $title, $content, $head_img, $qrcode_img = null)
{
    $im = imagecreatetruecolor(750, 1334);
    $white = imagecolorallocate($im, 255, 255, 255);
    $gray = imagecolorallocate($im, 200, 200, 200);
    $foot_text_color = imagecolorallocate($im, 153, 153, 153);
    $black = imagecolorallocate($im, 0, 0, 0);
    $title_text_color = imagecolorallocate($im, 51, 51, 51);
    $english_font = get_template_directory() . '/core/functions/Montserrat-Regular.ttf';
    $chinese_font = get_template_directory() . '/core/functions/MFShangYa_Regular.otf';
    $chinese_font_2 = get_template_directory() . '/core/functions/hanyixizhongyuan.ttf';
    imagefill($im, 0, 0, $white);
    $head_img = imagecreatefromstring(file_get_contents(timthumb($head_img, array('w' => 750, 'h' => '680'), 'tim')));
    imagecopy($im, $head_img, 0, 0, 0, 0, 750, 680);
    $day = $date['day'];
    $day_width = imagettfbbox(85, 0, $english_font, $day);
    $day_width = abs($day_width[2] - $day_width[0]);
    $year = $date['year'];
    $year_width = imagettfbbox(24, 0, $english_font, $year);
    $year_width = abs($year_width[2] - $year_width[0]);
    $day_left = ($year_width - $day_width) / 2;
    imagettftext($im, 80, 0, 50 + $day_left, 575, $white, $english_font, $day);
    imageline($im, 50, 590, 50 + $year_width, 590, $white);
    imagettftext($im, 24, 0, 50, 625, $white, $english_font, $year);
    $title = mi_str_encode($title);
    $title_width = imagettfbbox(28, 0, $chinese_font, $title);
    $title_width = abs($title_width[2] - $title_width[0]);
    $title_left = 750 - $title_width / 2;
    imagettftext($im, 28, 0, $title_left, 830, $black, $chinese_font, $title);
    $conf = array('color' => array('0' => 99, '1' => 99, '2' => 99), 'fontsize' => 21, 'width' => 610, 'left' => 70, 'top' => 860, 'hang_size' => 43);
    draw_txt_to($im, $conf, $content, true, $chinese_font_2);
    $style = array();
    imagesetstyle($im, $style);
    imageline($im, 0, 1136, 750, 1136, IMG_COLOR_STYLED);
    $foot_text = cs_get_option('bigger_desc');
    $foot_text = $foot_text ? $foot_text : get_bloginfo('description');
    $foot_text = mi_str_encode($foot_text);
    $logo_att = cs_get_option('bigger_logo');
    if ($logo_att) {
        $att = wp_get_attachment_image_src($logo_att, 'full');
        $logo_img = $att[0];
    } else {
        $site_logo = cs_get_option('site_logo');
        if ($site_logo) {
            $att = wp_get_attachment_image_src($site_logo, 'full');
            $logo_img = $att[0];
        } else {
            $logo_img = get_template_directory_uri() . '/static/images/logo.png';
        }
    }
    $logo_img = imagecreatefromstring(file_get_contents(timthumb($logo_img, array('w' => 181, 'h' => 40), 'tim')));
    if ($qrcode_img) {
        imagecopy($im, $logo_img, 50, 1200, 0, 0, 181, 40);
        imagettftext($im, 14, 0, 50, 1275, $foot_text_color, $chinese_font_2, $foot_text);
        $qrcode_str = file_get_contents($qrcode_img);
        $qrcode_size = getimagesizefromstring($qrcode_str);
        $qrcode_img = imagecreatefromstring($qrcode_str);
        imagecopyresized($im, $qrcode_img, 600, 1185, 0, 0, 100, 100, $qrcode_size[0], $qrcode_size[1]);
    } else {
        imagecopy($im, $logo_img, 284, 1200, 0, 0, 181, 40);
        $foot_text_width = imagettfbbox(14, 0, $chinese_font, $foot_text);
        $foot_text_width = abs($foot_text_width[2] - $foot_text_width[0]);
        $foot_text_left = 750 - $foot_text_width / 2;
        imagettftext($im, 14, 0, $foot_text_left, 1275, $foot_text_color, $chinese_font_2, $foot_text);
    }
    $upload_dir = wp_upload_dir();
    $filename = '/bigger-' . uniqid() . '.png';
    $file = $upload_dir['path'] . $filename;
    imagepng($im, $file);
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    $src = media_sideload_image($upload_dir['url'] . $filename, $post_id, NULL, 'src');
    unlink($file);
    error_reporting(0);
    imagedestroy($im);
    if (is_wp_error($src)) {
        return false;
    }
    return $src;
}
function get_bigger_img()
{
    $post_id = sanitize_text_field($_POST['id']);
    if (wp_verify_nonce($_POST['nonce'], 'mi-create-bigger-image-' . $post_id)) {
        get_the_time('d', $post_id);
        get_the_time('Y/m', $post_id);
        $date = array('day' => get_the_time('d', $post_id), 'year' => get_the_time('Y/m', $post_id));
        $post_extend = get_post_meta($post_id, 'post_extend', true);
        $post_extend = wp_parse_args((array) $xz_data[$xz_k], array('bigger_head_img' => '', 'bigger_title' => '', 'bigger_desc' => ''));
        $title = $post_extend['bigger_title'] ? $post_extend['bigger_title'] : get_the_title($post_id);
        $share_title = $post_extend['bigger_title'] ? $post_extend['bigger_title'] : get_the_title($post_id);
        $title = substr_ext($title, 0, 18, 'utf-8', '');
        if ($post_extend['bigger_desc']) {
            $content = $post_extend['bigger_desc'];
        } else {
            $post = get_post($post_id);
            $content = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
        }
        $content = substr_ext(strip_tags(strip_shortcodes($content)), 0, 55, 'utf-8', '...');
        $share_content = '【' . $share_title . '】' . substr_ext(strip_tags(strip_shortcodes($content)), 0, 80, 'utf-8', '');
        $content = str_replace(PHP_EOL, '', strip_tags(apply_filters('the_excerpt', $content)));
        if ($post_extend['bigger_head_img']) {
            $att = wp_get_attachment_image_src($post_extend['bigger_head_img'], 'full');
            $head_img = $att[0];
        } else {
            $head_img = post_thumbnail_src($post ? $post : get_post($post_id));
            $att = wp_get_attachment_image_src($head_img, 'full');
            $head_img = $att[0];
        }
        if (cs_get_option('share_bigger_img_qrcode')) {
            $qrcode_img = get_template_directory_uri() . '/core/functions/share/qrcode.php?data=' . get_the_permalink($post_id);
        } else {
            $qrcode_img = NULL;
        }
        $result = create_bigger_image($post_id, $date, $title, $content, $head_img, $qrcode_img);
        if ($result) {
            $pic = '&pic=' . urlencode($result);
            if (get_post_meta($post_id, 'bigger_cover', true)) {
                update_post_meta($post_id, 'bigger_cover', $result);
            } else {
                add_post_meta($post_id, 'bigger_cover', $result);
            }
            $share_link = sprintf('https://service.weibo.com/share/share.php?url=%s&type=button&language=zh_cn&searchPic=true%s&title=%s', urlencode(get_the_permalink($post_id)), $pic, $share_content);
            if (get_post_meta($post_id, 'bigger_cover_share', true)) {
                update_post_meta($post_id, 'bigger_cover_share', $share_link);
            } else {
                add_post_meta($post_id, 'bigger_cover_share', $share_link);
            }
            $msg = array('s' => 200, 'src' => $result, 'share' => $share_link);
        } else {
            $msg = array('s' => 404, 'm' => 'bigger 封面生成失败，请稍后再试！');
        }
    } else {
        $msg = array('s' => 404, 'm' => '嘿嘿嘿！');
    }
    echo json_encode($msg);
    exit(0);
}
function filter_sticky_posts($query)
{
    if ($query->is_category) {
        $query->set('post__not_in', get_option('sticky_posts'));
    }
    return $query;
}
function timthumb_register()
{
    add_image_size('850-600', 850, 600, true);
    add_image_size('636-400', 636, 400, true);
    add_image_size('480-384.7', 480, 384, true);
    add_image_size('480-358', 480, 358, true);
    add_image_size('280-220', 280, 220, true);
    add_image_size('309-140', 309, 140, true);
    add_image_size('300-300', 300, 300, true);
    add_image_size('70-70', 70, 70, true);
    add_image_size('150-150', 150, 150, true);
}