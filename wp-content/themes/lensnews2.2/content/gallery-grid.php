<?php global $salong,$post;
$slides = get_post_meta( $post->ID, 'slides', true );
?>
<!--图片大小-->
<?php if (get_post_meta($post->ID, "gallery_size", true)) {
    $gallery_arr=get_post_custom_values( "gallery_size");$gallery_str=isset($gallery_arr[0])? $gallery_arr[0]: "";$gallery_size=explode( "|",$gallery_str);
    $gallery_w = reset($gallery_size);
    $gallery_h = end($gallery_size);
}else{
    $gallery_w = '400';
    $gallery_h = '225';
}
?>
<!--获取图片-->
<section class="gallery_tile <?php if (get_post_meta($post->ID, "gallery_show", true)) { echo 'gallery_show'; } wow(); ?>">
    <?php foreach ($slides as $slide){ ?>
    <figure>
        <a href="<?php echo $slide['img_url']; ?>" data-fancybox="images" title="<?php if($slide['img_title']){ echo $slide['img_title']; }else{ echo get_the_title(); } ?>" data-caption="<?php if($slide['img_title']){ echo $slide['img_title']; }else{ echo get_the_title(); } ?>">
            <?php if( $salong[ 'switch_lazyload']==true ){ ?>
            <img class="thumb" src="<?php echo get_bloginfo("template_url"); ?>/includes/timthumb.php?src=<?php echo $salong['thumb_loading']['url']; ?>&amp;h=<?php echo $gallery_h; ?>&amp;w=<?php echo $gallery_w; ?>" data-original="<?php echo get_bloginfo("template_url"); ?>/includes/timthumb.php?src=<?php echo $slide['img_url']; ?>&amp;h=<?php echo $gallery_h; ?>&amp;w=<?php echo $gallery_w; ?>" alt="<?php if($slide['img_title']){ echo $slide['img_title']; }else{ echo get_the_title(); } ?>">
            <?php }else{ ?>
            <img class="thumb" src="<?php echo get_bloginfo("template_url"); ?>/includes/timthumb.php?src=<?php echo $slide['img_url']; ?>&amp;h=<?php echo $gallery_h; ?>&amp;w=<?php echo $gallery_w; ?>" alt="<?php if($slide['img_title']){ echo $slide['img_title']; }else{ echo get_the_title(); } ?>">
            <?php } ?>
            <?php if($slide['img_title']){ ?><span><?php echo $slide['img_title']; ?></span><?php } ?>
        </a>
    </figure>
    <?php } ?>
</section>