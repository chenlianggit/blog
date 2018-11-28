<?php global $salong;?>
<!--用户信息-->
<?php if (!wp_is_mobile()) { ?>
<article class="crumbs_page">
    <h2><?php echo get_the_title(); ?></h2>
    <div class="bg"></div>
</article>
<?php } ?>
<!--用户信息end-->
<!-- 主体内容 -->
<section class="container">
    <section class="wrapper wpuf">
        <?php if(!wp_is_mobile()) { ?>
        <!-- 边栏 -->
        <?php if(is_user_logged_in()) { if(is_active_sidebar( 'sidebar-8')) { dynamic_sidebar(__( '用户中心', 'salong')); }else{ ?>
        <section class="sidebar_widget box widget_salong_init<?php wow(); ?>">
            <div class="init"><a href="<?php echo get_home_url(); ?>/wp-admin/widgets.php"><?php _e('请到后台外观——小工具中添加小工具到<br><strong>用户中心</strong>边栏中。','salong'); ?></a></div>
        </section>
        <?php } } } ?>
        <!-- 边栏end -->