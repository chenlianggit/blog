<?php
// 缩略图，使用WP自带的缩略图功能
global $salong;
add_theme_support( 'post-thumbnails' );
add_image_size('medium', 600, 338, true);
add_image_size('thumbnail', 128, 72, true);
if( $salong['switch_lazyload']== true ){
    // 为图片添加 data-original 属性，延迟加载功能
    add_filter ('the_content', 'lazyload');
    function lazyload($content) {
        global $salong;
        $loadimg = $salong['post_loading']['url'];
        if(!is_feed()||!is_robots) {
            $content=preg_replace('/<img(.+)src=[\'"]([^\'"]+)[\'"](.*)>/i',"<img\$1data-original=\"\$2\" src=\"$loadimg\"\$3>",$content);
        }
        return $content;
    }
    //分类列表缩略图
    function post_thumbnail($width = 600,$height = 338){
        global $post,$salong;
        //自定义域
        $thumb = get_post_meta($post->ID, "thumb", true);
        if($thumb) {
            echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$thumb.'" alt="'.$post->post_title.'" />';
        } else if( has_post_thumbnail() ){
            //缩略图
            if(is_multisite() && function_exists('network_shared_media_init')){
                $xmlobject = simplexml_load_string(get_the_post_thumbnail($post->ID,'medium'));
                $wpauto = $xmlobject->attributes()->src;
            } else {
                $wpauto = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'medium');
            }
            echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$wpauto[0].'" alt="'.$post->post_title.'" />';
        } else if(get_post_meta($post->ID, "youku_id", true)) {
            //获取视频缩略图
            $youku_video_thumb = get_youku_video_thumb();
            echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$youku_video_thumb.'" alt="'.$post->post_title.'" />';
        } else {
            $content = $post->post_content;
            preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
            $n = count($strResult[1]);
            if($n > 0){
                //第一张图片
                echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$strResult[1][0].'" alt="'.$post->post_title.'" />';
            } else {
                //默认图片
                echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$salong['default_thumb']['url'].'" alt="'.$post->post_title.'" />';
            }
        }
    }
    //小工具列表缩略图
    function widget_post_thumbnail($width = 128,$height = 72){
        global $post;
        global $salong;
        //自定义域
        $thumb = get_post_meta($post->ID, "thumb", true);
        if($thumb) {
            echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$thumb.'" alt="'.$post->post_title.'" />';
        } else if( has_post_thumbnail() ){
            //缩略图
            if(is_multisite() && function_exists('network_shared_media_init')){
                $xmlobject = simplexml_load_string(get_the_post_thumbnail($post->ID,'thumbnail'));
                $wpauto = $xmlobject->attributes()->src;
            } else {
                $wpauto = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'thumbnail');
            }
            echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$wpauto[0].'" alt="'.$post->post_title.'" />';
        } else if(get_post_meta($post->ID, "youku_id", true)) {
            //获取视频缩略图
            $youku_video_thumb = get_youku_video_thumb();
            echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$youku_video_thumb.'" alt="'.$post->post_title.'" />';
        } else {
            $content = $post->post_content;
            preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
            $n = count($strResult[1]);
            if($n > 0){
                //第一张图片
                echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$strResult[1][0].'" alt="'.$post->post_title.'" />';
            } else {
                //默认图片
                echo '<img class="thumb" src="'.$salong['thumb_loading']['url'].'" data-original="'.$salong['default_thumb']['url'].'" alt="'.$post->post_title.'" />';
            }
        }
    }
}
else {
    //分类列表缩略图
    function post_thumbnail($width = 600,$height = 338){
        global $post,$salong;
        //自定义域
        $thumb = get_post_meta($post->ID, "thumb", true);
        if($thumb) {
            echo '<img class="thumb" src="'.$thumb.'" alt="'.$post->post_title.'" />';
        } else if( has_post_thumbnail() ){
            //缩略图
            if(is_multisite() && function_exists('network_shared_media_init')){
                $xmlobject = simplexml_load_string(get_the_post_thumbnail($post->ID,'medium'));
                $wpauto = $xmlobject->attributes()->src;
            } else {
                $wpauto = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'medium');
            }
            echo '<img class="thumb" src="'.$wpauto[0].'" alt="'.$post->post_title.'" />';
        } else if(get_post_meta($post->ID, "youku_id", true)) {
            //获取视频缩略图
            $youku_video_thumb = get_youku_video_thumb();
            echo '<img class="thumb" src="'.$youku_video_thumb.'" alt="'.$post->post_title.'" />';
        } else {
            $content = $post->post_content;
            preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
            $n = count($strResult[1]);
            if($n > 0){
                //第一张图片
                echo '<img class="thumb" src="'.$strResult[1][0].'" alt="'.$post->post_title.'" />';
            } else {
                //默认图片
                echo '<img class="thumb" src="'.$salong['default_thumb']['url'].'" alt="'.$post->post_title.'" />';
            }
        }
    }
    //小工具列表缩略图
    function widget_post_thumbnail($width = 128,$height = 72){
        global $post,$salong;
        //自定义域
        $thumb = get_post_meta($post->ID, "thumb", true);
        if($thumb) {
            echo '<img class="thumb" src="'.$thumb.'" alt="'.$post->post_title.'" />';
        } else if( has_post_thumbnail() ){
            //缩略图
            if(is_multisite() && function_exists('network_shared_media_init')){
                $xmlobject = simplexml_load_string(get_the_post_thumbnail($post->ID,'thumbnail'));
                $wpauto = $xmlobject->attributes()->src;
            } else {
                $wpauto = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'thumbnail');
            }
            echo '<img class="thumb" src="'.$wpauto[0].'" alt="'.$post->post_title.'" />';
        } else if(get_post_meta($post->ID, "youku_id", true)) {
            //获取视频缩略图
            $youku_video_thumb = get_youku_video_thumb();
            echo '<img class="thumb" src="'.$youku_video_thumb.'" alt="'.$post->post_title.'" />';
        } else {
            $content = $post->post_content;
            preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
            $n = count($strResult[1]);
            if($n > 0){
                //第一张图片
                echo '<img class="thumb" src="'.$strResult[1][0].'" alt="'.$post->post_title.'" />';
            } else {
                //默认图片
                echo '<img class="thumb" src="'.$salong['default_thumb']['url'].'" alt="'.$post->post_title.'" />';
            }
        }
    }
}

//无图片延迟加载的分类缩略图

//分类列表缩略图
function no_post_thumbnail($width = 600,$height = 338){
    global $post,$salong;
    //自定义域
    $thumb = get_post_meta($post->ID, "thumb", true);
    if($thumb) {
        echo '<img class="thumb" src="'.$thumb.'" alt="'.$post->post_title.'" />';
    } else if( has_post_thumbnail() ){
        //缩略图
        if(is_multisite() && function_exists('network_shared_media_init')){
            $xmlobject = simplexml_load_string(get_the_post_thumbnail($post->ID,'medium'));
            $wpauto = $xmlobject->attributes()->src;
        } else {
            $wpauto = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'medium');
        }
        $post_timthumb = '<img class="thumb" src="'.$wpauto[0].'" alt="'.$post->post_title.'" />';
    } else {
        $content = $post->post_content;
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){
            //第一张图片
            echo '<img class="thumb" src="'.$strResult[1][0].'" alt="'.$post->post_title.'" />';
        } else {
            //默认图片
            echo '<img class="thumb" src="'.$salong['default_thumb']['url'].'" alt="'.$post->post_title.'" />';
        }
    }
}
?>