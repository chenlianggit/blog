<?php if ( is_home() ) { ?><title><?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?><?php $paged = get_query_var('paged'); if ( $paged > 1 ) printf(' - 第 %s 页 ',$paged); ?></title><?php } ?>
<?php if ( is_search() ) { ?><title>搜索结果 - <?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?></title><?php } ?>
<?php if ( is_single() ) { ?><title><?php echo trim(wp_title('',0)); if(trim(wp_title('',0))){?> - <?php } bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?></title><?php } ?>
<?php if ( is_page() ) { ?><title><?php echo trim(wp_title('',0)); if(trim(wp_title('',0))){?> - <?php } bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?></title><?php } ?>
<?php if ( is_category() ) { ?><title><?php single_cat_title(); ?> - <?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?><?php $paged = get_query_var('paged'); if ( $paged > 1 ) printf(' - 第 %s 页 ',$paged); ?></title><?php } ?>
<?php if ( is_year() ) { ?><title><?php the_time('Y年'); ?>日志归档 - <?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?></title><?php } ?>
<?php if ( is_month() ) { ?><title><?php the_time('Y年n月'); ?>日志归档 - <?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?></title><?php } ?>
<?php if ( is_day() ) { ?><title><?php the_time('Y年n月j日'); ?>日志归档 - <?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?></title><?php } ?>
<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><title><?php  single_tag_title("", true); ?> - <?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?><?php $paged = get_query_var('paged'); if ( $paged > 1 ) printf(' - 第 %s 页 ',$paged); ?></title><?php } ?><?php } ?>
<?php if ( is_author() ) {?><title><?php wp_title('');?>发布的所有日志 - <?php bloginfo('name'); ?><?php if(of_get('logospanseo')){echo ' - ';bloginfo('description');}?></title><?php }?>

<?php if ( is_home() ) { ?>
<meta name="keywords" content="<?php echo of_get('keywords'); ?>"/>
<meta name="description" content="<?php echo of_get('description'); ?>"/>
<?php } if ( is_single() ) { $category = get_the_category(); if($category) {foreach($category as $tag) {$q_tags.=$tag->cat_name .","; }}$posttags = get_the_tags();if ($posttags) {foreach($posttags as $tag) {$q_tags.=$tag->name .","; }}?>
<meta name="keywords" content="<?php echo $q_tags ?>"/>
<meta name="description" content="<?php  $excerpt = get_the_excerpt();if($excerpt != ''){$trimmed_content = $excerpt; }else{ $content = get_the_content(); $trimmed_content = wp_trim_words($content, 120, '...');} echo $trimmed_content; ?>"/>
<meta name="author" content="<?php bloginfo('name'); ?>"/>
<meta property="og:type" content="blog"/>
<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
<meta property="og:image" content="<?php if (has_post_thumbnail()) { $array_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array(160,160));echo $array_image_url[0];}else if(of_get('is_lazy')){if ($images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image'))) {$image = current($images);$image = wp_get_attachment_image_src($image->ID, array(160, 160));echo  $image[0];}}?>"/>
<meta property="og:title" content="<?php the_title(); ?>"/>
<meta property="og:description" content="<?php echo $trimmed_content;?>" />
<meta property="og:url" content="<?php the_permalink(); ?>"/>
<meta property="og:author" content="<?php bloginfo('name'); ?>"/>
<meta property="og:release_date" content="<?php the_time('Y-m-d'); ?>"/>
<?php } if ( is_page() ) {?> 
<meta name="keywords" content="<?php echo of_get('keywords'); ?>"/>
<meta name="description" content="<?php  $excerpt = get_the_excerpt(); if($excerpt!= ''){$trimmed_content = $excerpt; }else{ $content = get_the_content(); $trimmed_content = wp_trim_words($content, 120, '...');} echo $trimmed_content;?>"/>
<?php } ?>
<?php if ( is_category() ) { ?>
<meta name="keywords" content="<?php single_cat_title(); ?>"/>
<meta name="description" content="<?php echo of_get('description'); ?>"/>
<?php }  if (function_exists('is_tag')) { if ( is_tag() ) { ?>
<meta name="keywords" content="<?php  single_tag_title("", true); ?>"/>
<meta name="description" content="<?php echo of_get('description'); ?>"/>
<?php } ?>
<?php } ?>

