<?php
#######################################################################
############################- 加载主题设置 -############################
######################################################################
if (!function_exists('optionsframework_init')) {
    define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/');
    require_once dirname(__FILE__) . '/inc/options-framework.php';
}
#######################################################################
###############################- 加载参数 -#############################
######################################################################
include 'includes/fun.php';
#######################################################################
#########################- 屏蔽 emojis并替换 -##########################
######################################################################

function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    // add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('the_content', 'wp_staticize_emoji');
    add_filter('comment_text', 'wp_staticize_emoji',50); //在转换为表情后再转为静态图片
    smilies_reset();
    add_filter('emoji_url', 'static_emoji_url');
}
add_action('init', 'disable_emojis');
function smilies_reset() {
    global $wpsmiliestrans, $wp_smiliessearch;
    // don't bother setting up smilies if they are disabled
    if (!get_option('use_smilies')) {
        return;
    }
    $wpsmiliestrans_fixed = array(
         // ':mrgreen:' => "\xf0\x9f\x98\xa2",
         ':smile:' => "\xF0\x9F\x98\x8A",
         // ':roll:' => "\xf0\x9f\x98\xa4",
         ':sad:' => "\xF0\x9F\x98\x92",
         // ':arrow:' => "\xf0\x9f\x98\x83",
         ':-(' => "\xF0\x9F\x98\x92",
         ':-)' => "\xF0\x9F\x98\x8A",
         ':(' => "\xF0\x9F\x98\x92",
         ':)' => "\xF0\x9F\x98\x8A",
         // ':?:' => "\xE2\x9D\x93",
         // ':!:' => "\xE2\x9D\x97",
    );
    $wpsmiliestrans = array_merge($wpsmiliestrans, $wpsmiliestrans_fixed);
 }
 //替换cdn路径
 function static_emoji_url() {
    return get_bloginfo('template_directory').'/img/72x72/';
 }
 //输出表情
 function fa_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    foreach($wpsmilies as $alt => $src_path){
    $emoji = str_replace(array('&#x', ';'), '', wp_encode_emoji($src_path));
        $output .= '<a class="add-smily" data-smilies="'.$alt.'"><img class="wp-smiley" src="'.get_bloginfo('template_directory').'/img/72x72/'. $emoji .'png" /></a>';
    }
     return $output;
 }

#######################################################################
############################- 清除谷歌字体 -############################
######################################################################
function coolwp_remove_open_sans_from_wp_core()
{
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}
add_action('init', 'coolwp_remove_open_sans_from_wp_core');

#######################################################################
############################- 图片缩略图 -##############################
######################################################################
add_theme_support('post-thumbnails');
add_image_size('thumbnail_index', 180, 100, true);
add_image_size('thumbnail_loop_img', 668, 240, true);
add_image_size('thumbnail_loop_book', 140, 160, true);
#######################################################################
###############################- 主循环 -################################
######################################################################
function index_loop($is = false){
    $www = Q_is(of_get('key'));
    if($www['state']){
        if(of_get('loop_img') and !$is){
            loop_img();
            return;
        }
    }
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            echo '<article class="article class_';
            the_category_ID();
            echo '" >';
            echo '<h1><a href="';
                    the_permalink();
            echo '" >';
                    the_title();
            echo '</a></h1>';

                echo '<p>';
                    //判断是否有特色图像
                    if (has_post_thumbnail()) {
                        echo '<a href="';
                            the_permalink();
                        echo '">';
                        the_post_thumbnail('thumbnail_index');
                        echo '</a>';
                    } else if(of_get('is_lazy')){ //如果没有调用文章内一张图片
                        if ($images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image'))) {
                            echo '<a href="';
                                the_permalink();
                            echo '">';
                            $image = current($images);
                            $image = wp_get_attachment_image_src($image->ID, array(180, 100));
                            echo '<img src="' . $image[0] . '"  />';
                            echo '</a>';
                        }
                    }
                //截取文章文字     
                $excerpt = get_the_excerpt(); 
                if($excerpt!= ''){
                    $trimmed_content = $excerpt;
                }else{
                    $content = get_the_content();
                    if(of_get('abstract_num') != "" ){
                        $abstract_num = of_get('abstract_num');
                    }else{
                        $abstract_num = 120;
                    }

                    $trimmed_content = wp_trim_words($content,$abstract_num, '...');
                }
                echo $trimmed_content;
                echo '<time><br>';
                        the_time('Y-n-j'); //时间格式
                echo '</time>';
                echo '</p>';
                echo '</article>';

        }
    } else {
        if(of_get('diy_404')){ 
            echo of_get('diy_404');
        }else{
            echo '<p class="_404">没发现什么...</p>';
        }
    }
}
//大图模式
function loop_img(){
   $www = Q_is(of_get('key'));
    if(!$www['state']){
        return;
    }
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            echo '<article class="article loop_img class_';
            the_category_ID();
            echo '" >';
            echo '<h1><a href="';
                    the_permalink();
            echo '" >';
                    the_title();
            echo '</a>';
             echo '<time>';
                        the_time('Y-n-j'); //时间格式
                echo '</time></h1>';
                echo '<a href="';
                    the_permalink();
                echo '" >';
                    if (has_post_thumbnail()) {
                        $thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_loop_img');
                        $bg_url = $thumbnail_image_url[0];
                    } else if(of_get('is_lazy')){ //如果没有调用文章内一张图片
                        if ($images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image'))) {
                            $image = current($images);
                            $image = wp_get_attachment_image_src($image->ID, array(688, 240));
                            $bg_url =  $image[0];
                        }else{
                            $bg_url = '';
                        }
                    }else{
                            $bg_url = '';
                    }
                    if($bg_url){
                       echo '<div class="bg" style="background-image:url('.$bg_url.')">';
                        echo '</div>'; 
                    }
                    echo '</a>';
                //截取文章文字     
                $excerpt = get_the_excerpt(); 
                if($excerpt != ''){
                    $trimmed_content = $excerpt;
                }else{
                     $content = get_the_content();
                    if(of_get('abstract_num') == ""){
                        $abstract_num = of_get('abstract_num');
                    }else{
                        $abstract_num = 120;
                    }
                    $trimmed_content = wp_trim_words($content, of_get('abstract_num'), '...');
                }
                echo '<p>';
                echo $trimmed_content; 
                echo '</p>';
                echo '</article>';

        }
    } else {
        if(of_get('diy_404')){ 
            echo of_get('diy_404');
        }else{
            echo '<p class="_404">没发现什么...</p>';
        }
    } 
}
#######################################################################
############################- 头部副标题 -##############################
######################################################################
function description_qzhai(){
    echo '<span>';
        bloginfo('description');
    echo '</span>';
}
#######################################################################
############################- 版权 -##################################
######################################################################
function copyright($k){
        if($k){
            $is = of_get('is_widget');
        }else {
            $is = !of_get('is_widget');
        }  
     if($is){
        echo  '<div class="ft uk-visible-small">';
            echo  '<p>';
            echo  of_get('footer');
            echo  getfoot('foot');
            echo '</p>';
        echo '</div>';
    }
}

############################################################################################################
###################################################- 代码DIY -##############################################
#- 如果有代码想加入function里请拷贝到 主题目录下 diy_fun.php 文件里 每次更新主题前备份下 就省着每次更新都要再次修改 -#
###########################################################################################################
include 'diy_fun.php';


function enqueue_scripts_styles_init() {
    // wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri().'/js/script.js', array('jquery'), 1.0 );
    wp_localize_script( 'ajax-script', 'WP_API_Settings', array( 'root' => esc_url_raw( rest_url() ), 'nonce' => wp_create_nonce( 'wp_rest' ) ) );
}
add_action('init', 'enqueue_scripts_styles_init');
