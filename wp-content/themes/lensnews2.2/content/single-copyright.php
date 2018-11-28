<?php
global $salong;
global $post;
$author_url = get_author_posts_url(get_the_author_meta('ID'));
$blog_name = get_bloginfo('name');
$from_name = get_post_custom_values( "from_name");
if ($salong['switch_link_go']) {
    $from_link = external_link(get_post_meta($post->ID, 'from_link', true));
} else {
    $from_link0 = get_post_custom_values( "from_link");
    $from_link = $from_link0[0];
}
?>
<section class="post_declare">
   <?php if($salong[ 'switch_copyright']) { ?>
    <p>
       <?php if(get_post_meta($post->ID, "from_name", true) && get_post_meta($post->ID, "from_link", true)){ ?>
        <?php printf( __( '本文由来源 <a href="%s" target="_blank" rel="external nofollow">%s</a>，由 %s 整理编辑！', 'salong' ), esc_attr($from_link), esc_attr($from_name[0]), esc_attr(get_the_author_meta('display_name')) ); ?>
       <?php } else if(get_post_meta($post->ID, "from_name", true)){ ?>
        <?php printf( __( '本文由来源 %s，由 %s 整理编辑！', 'salong' ), esc_attr($from_name[0]), esc_attr(get_the_author_meta('display_name')) ); ?>
        <?php } else if ( user_can( $post->post_author, 'administrator' ) || user_can( $post->post_author, 'editor' ) || user_can( $post->post_author, 'author' ) ) { ?>
        <?php printf( __( '本文由 %s 作者：<a href="%s">%s</a> 发表，转载请注明来源！', 'salong' ), esc_attr($blog_name), esc_attr($author_url), esc_attr(get_the_author_meta('display_name')) ); ?>
        <?php } ?>
    </p>
    <?php } ?>
    <!-- 关键词 -->
    <div class="tags">
        <?php the_tags(__( '关键词：', 'salong'), ', ', ''); ?>
    </div>
</section>