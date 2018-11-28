<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $salong;
get_header( 'shop' ); ?>
<section class="container wrapper">
<?php get_template_part( 'content/content', 'crumbs'); ?>
    <section class="content<?php if($salong['switch_product_post_sidebar'] && !wp_is_mobile()) { echo ' content_left'; } ?>">
        <?php
        /** 
        * woocommerce_before_main_content hook. *
        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content) *
        @hooked woocommerce_breadcrumb - 20
        */
        do_action( 'woocommerce_before_main_content' ); ?>

        <?php while ( have_posts() ) : the_post(); ?>

        <?php wc_get_template_part( 'content', 'single-product' ); ?>

        <?php endwhile; // end of the loop. ?>

        <?php
        /** * woocommerce_after_main_content hook. * *
        @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
        */ 
        do_action( 'woocommerce_after_main_content' ); ?>
        <?php if($salong[ 'switch_product_post_sidebar'] && !wp_is_mobile()) { ?>
        <aside class="sidebar">
        <?php if(is_active_sidebar('sidebar-7')) { ?>
            <?php dynamic_sidebar(__( '商城', 'salong')); ?>
            <article class="move">
                <?php dynamic_sidebar(__( '移动', 'salong')); ?>
            </article>
        <?php }else { ?>
        <article class="sidebar_widget widget_salong_init box<?php triangle();wow(); ?>"><div class="sidebar_title"><h3><?php _e('温馨提示','salong'); ?></h3></div><div class="init"><a href="<?php echo get_home_url(); ?>/wp-admin/widgets.php"><?php _e('请到后台外观——小工具中添加小工具到<br><strong>商城</strong>边栏中。','salong'); ?></a></div></article>
        <?php } ?>
        </aside>
        <?php } ?>
    </section>
</section>
<?php get_footer( 'shop' ); ?>