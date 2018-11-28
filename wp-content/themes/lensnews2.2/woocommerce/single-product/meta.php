<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product,$salong;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<?php if ($salong[ 'product_metas'] !=0 ) { ?>
<div class="product_meta">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	<!--编码-->
<?php if (in_array( 'author', $salong[ 'product_metas'])) { ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>
	<?php } if (in_array( 'category', $salong[ 'product_metas'])) { ?>
	<!--分类-->
	<?php echo wc_get_product_category_list( $post->ID,', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>
	<?php } if (in_array( 'tag', $salong[ 'product_metas'])) { ?>
	<!--标签-->
	<?php echo wc_get_product_tag_list( $post->ID,', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>
	<?php } if (in_array( 'date', $salong[ 'product_metas'])) { ?>
	<!--日期-->
    <span><?php _e( '日期：','salong'); ?><?php the_time('Y-m-d'); ?></span>
	<?php } if (in_array( 'view', $salong[ 'product_metas'])) { ?>
	<!--浏览量-->
	<span><?php _e( '浏览：', 'salong' ); ?><?php setPostViews(get_the_ID()); ?><?php echo getPostViews(get_the_ID()); ?></span>
	<?php } if (in_array( 'like', $salong[ 'product_metas'])) { ?>
	<!--点赞-->
	<?php echo getPostLikeLinkList(get_the_ID());?>
	<?php } if (in_array( 'comment', $salong[ 'product_metas'])) { ?>
	<!--评论-->
	<span><?php _e( '评论：','salong'); ?><?php comments_popup_link('0', '1', '%'); ?></span>
	<?php } if (in_array( 'total', $salong[ 'product_metas'])) { ?>
	<!--销量-->
	<span><?php _e( '销量：', 'salong' ); ?><?php $total_sales = get_post_custom_values( "total_sales"); echo $total_sales[0]; ?></span>
	<?php } ?>
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
<?php } ?>
