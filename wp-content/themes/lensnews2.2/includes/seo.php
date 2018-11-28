<?php
if (!function_exists('utf8Substr')) {
 function utf8Substr($str, $from, $len)
 {
     return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
          '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
          '$1',$str);
 }
}
if ( is_single() || is_page() ){
    /*自定义域页面描述*/
    global $post;
    if(get_post_meta($post->ID, "description", true)){
        $description = get_post_meta($post->ID, 'description', 'ture');
    } else {
        /*文章摘要或截取一段文字*/
        if ($post->post_excerpt) {
            $description  = $post->post_excerpt;
        } else {
            if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$result)){
                $post_content = $result['1'];
            } else {
                $post_content_r = explode("\n",trim(strip_tags($post->post_content)));
                $post_content = $post_content_r['0'];
            }
            $description = utf8Substr($post_content,0,220);
        }
    }
}
global $post;
if(get_post_meta($post->ID, "tags", true)){
    $tags_name_str = get_post_meta($post->ID, "tags", true);
} else {
    if(is_singular('gallery')){
        //画廊标签
        $posttags = get_the_terms($post->ID, 'gallery-tag' );
    } else if(is_singular('video')){
        //视频标签
        $posttags = get_the_terms($post->ID, 'video-tag' );
    } else if(is_singular('product')){
        //产品标签
        $posttags = get_the_terms($post->ID, 'product_tag' );
    } else {
        //文章标签
        $posttags = get_the_terms($post->ID, 'post_tag' );
    }
    if ($posttags && ! is_wp_error($posttags)){
        $term_names_arr = array();
        foreach ($posttags as $tag) {
            $tag_names_arr[] = $tag->name;
        }
        $tags_name_str = join( ",", $tag_names_arr);
    }
}
echo "\n";?>
<?php global $salong; ?>
<?php if($salong[ 'google_key']){ ?><meta name="google-site-verification" content="<?php echo $salong[ 'google_key']; ?>" /><?php } ?>
<?php if($salong[ 'baidu_key']){ ?><meta name="baidu-site-verification" content="<?php echo $salong[ 'baidu_key']; ?>" /><?php } ?>
<?php if($salong[ '360_key']){ ?><meta name="360-site-verification" content="<?php echo $salong[ '360_key']; ?>" /><?php } ?>
<?php if (is_single()) { ?>
<meta name="description" content="<?php echo strip_tags($description); ?>" />
<meta name="keywords" content="<?php echo $tags_name_str; ?>" />
<link rel="canonical" href="<?php the_permalink(); ?>"/>
<?php }  elseif ( is_page() ) { ?>
<meta name="description" content="<?php echo strip_tags($description); ?>" />
<meta name="keywords" content="<?php if($tags_name_str){echo $tags_name_str;}else{the_title();} ?>" />
<link rel="canonical" href="<?php the_permalink(); ?>"/>
<?php }  elseif ( is_category() ) { ?>
<meta name="description" content="<?php echo category_description(); ?>" />
<meta name="keywords" content="<?php single_cat_title(); ?>" />
<link rel="canonical" href="<?php echo salong_archive_link();?>"/>
<?php }  elseif ( is_tag() ) { ?>
<meta name="description" content="<?php echo single_tag_title(); ?>" />
<meta name="keywords" content="<?php echo single_tag_title(); ?>" />
<link rel="canonical" href="<?php echo salong_archive_link();?>"/>
<?php }  elseif ( is_home() ) { ?>
<meta name="description" content="<?php echo $salong['description']; ?>" />
<meta name="keywords" content="<?php echo $salong['keywords']; ?>" />
<link rel="canonical" href="<?php echo salong_archive_link();?>"/>
<?php } ?>