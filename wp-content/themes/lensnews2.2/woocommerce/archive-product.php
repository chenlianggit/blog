<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<?php global $salong,$wp_query;
$product_link=$salong[ 'product_link'];//画廊链接
/////////////////////////////////////////产品分类
if($salong['switch_product_hierarchical']){ $product_hierarchical=1; }else{ $product_hierarchical=0; }//子分类形式显示
if($salong['switch_product_show_count']){ $product_show_count=1; }else{ $product_show_count=0; }//子分类形式显示
if($salong['product_exclude_crumbs_cat']){ $product_exclude_crumbs_cat = implode(',',$salong['product_exclude_crumbs_cat']); }//排除分类
$product_cat_orderby = $salong['product_cat_orderby'];
$product_cat_order = $salong['product_cat_order'];
$product_args=array( 'hierarchical'=>$product_hierarchical,'title_li'=>'','taxonomy'=>'product_cat','show_count'=>$product_show_count,'exclude'=>$product_exclude_crumbs_cat,'orderby'=>$product_cat_orderby,'order'=>$product_cat_order);
$shop_url = get_permalink(wc_get_page_id( 'shop' ));
$current_url = home_url(add_query_arg(array(),$wp->request));
?>
<section class="container wrapper">
    <section class="crumbs_wrap box<?php triangle();wow(); ?>">
        <h3><?php woocommerce_page_title(); ?></h3>
       <?php if($salong[ 'switch_product_crumbs']){ ?>
        <?php if(wp_is_mobile()){ ?>
        <?php wp_dropdown_categories('show_option_none='.__('选择分类','salong').'&hide_empty=1&show_count=1&hierarchical=1&taxonomy=product_cat&value_field=slug&selected=value_field'); ?>
        <?php }else{ ?>
        <ul>
            <li<?php if($current_url == $shop_url){ ?> class="current-cat"<?php } ?>>
                <a href="<?php echo get_page_link($product_link); ?>">
                    <?php _e( '全部', 'salong' ); ?>
                    <?php if($salong[ 'switch_product_show_count']){ ?>(
                    <?php echo wp_count_posts( 'product')->publish; ?>)
                    <?php } ?>
                </a>
            </li>
            <?php wp_list_categories($product_args);?>
        </ul>
        <?php } ?>
        <?php }else{ ?>
        <p>
            <?php echo category_description(); ?>
        </p>
        <?php } ?>
        
        <!--移动端显示分类选择 js 代码-->
        <?php if(wp_is_mobile()){ ?>
        <script type="text/javascript">
            <!--
            var dropdown = document.getElementById("cat");
            function onCatChange() {
                if ( dropdown.options[dropdown.selectedIndex].value != '-1' ) {
                    location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?product_cat="+dropdown.options[dropdown.selectedIndex].value;
                }
            }
            dropdown.onchange = onCatChange;
            -->
        </script>
        <?php } ?>
    </section>
    <?php if ( have_posts() ) : ?>
    <section class="content<?php if($salong['switch_product_sidebar'] && !wp_is_mobile()) { echo ' content_left'; } ?>">
        <?php
        /**
        * woocommerce_before_main_content hook. *
        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content) 
        * @hooked woocommerce_breadcrumb - 20
        */
        do_action( 'woocommerce_before_main_content' ); ?>
        <section class="box<?php triangle();wow(); ?>">
            <?php 
            /**
            * woocommerce_before_shop_loop hook. *
            * @hooked woocommerce_result_count - 20 
            * @hooked woocommerce_catalog_ordering - 30 
            */
            do_action( 'woocommerce_before_shop_loop' ); ?>
        </section>
        <?php woocommerce_product_loop_start(); ?>

        <?php woocommerce_product_subcategories(); ?>

        <?php while ( have_posts() ) : the_post(); ?>

        <?php wc_get_template_part( 'content', 'product' ); ?>

        <?php endwhile; // end of the loop. ?>

        <?php woocommerce_product_loop_end(); ?>

        <!-- 分页 -->
        <?php posts_pagination(); ?>


        <?php /**
        * woocommerce_after_main_content hook. *
        * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content) 
        */
        do_action( 'woocommerce_after_main_content' ); ?>
        <?php if($salong[ 'switch_product_sidebar'] && !wp_is_mobile()) { ?>
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
    <?php elseif ( ! woocommerce_product_subcategories( array( 'before'=> woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
    <section class="<?php wow(); ?>">

        <?php wc_get_template( 'loop/no-products-found.php' ); ?>
    </section>

    <?php endif; ?>
</section>
<?php get_footer( 'shop' ); ?>