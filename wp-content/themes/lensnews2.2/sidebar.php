<?php
global $salong,$post;
$meta = get_post_meta($post->ID,'custom_sidebar',true);
$no_sidebar = get_post_meta($post->ID,'no_sidebar',true);
?>
<?php if(!wp_is_mobile()) {
    if($meta == 'sidebar-0' || $meta == '') {
        $meta = 'sidebar-6';
    }
wp_reset_query(); ?>
<aside class="sidebar">
    <!--博客-->
    <?php if ( is_archive() || is_search() || is_page_template('template-blog.php') || is_page_template('template-message.php') || is_page_template('template-like.php') || is_page_template('template-hot.php') || is_page_template('template-link.php') || is_page_template('template-sticky.php')){ ?>
    <?php if(is_active_sidebar('sidebar-5')) { ?>
    <?php dynamic_sidebar(__( '博客', 'salong')); ?>
    <article class="move">
        <?php dynamic_sidebar(__( '移动', 'salong')); ?>
    </article>
    <?php }else{ ?>
    <article class="sidebar_widget widget_salong_init box<?php triangle();wow(); ?>"><div class="sidebar_title"><h3><?php _e('温馨提示','salong'); ?></h3></div><div class="init"><a href="<?php echo get_home_url(); ?>/wp-admin/widgets.php"><?php _e('请到后台外观——小工具中添加小工具到<br><strong>博客</strong>边栏中。','salong'); ?></a></div></article>
    <?php } ?>
    <?php } if (is_single() && !$no_sidebar){ ?>
    <?php if (is_active_sidebar('sidebar-6')){ ?>
    <?php dynamic_sidebar($meta); ?>
    <article class="move">
        <?php dynamic_sidebar(__( '移动', 'salong')); ?>
    </article>
    <?php }else{ ?>
    <article class="sidebar_widget widget_salong_init box<?php triangle();wow(); ?>"><div class="sidebar_title"><h3><?php _e('温馨提示','salong'); ?></h3></div><div class="init"><a href="<?php echo get_home_url(); ?>/wp-admin/widgets.php"><?php _e('请到后台外观——小工具中添加小工具到<br><strong>文章</strong>边栏中。','salong'); ?></a></div></article>
    <?php } ?>
    <?php } ?>
</aside>
<?php } ?>