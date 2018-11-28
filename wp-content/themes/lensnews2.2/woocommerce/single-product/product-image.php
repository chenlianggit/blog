<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product,$salong;
?>
<div class="images">
	<?php
    if( $salong['thumb_mode']== 'wpauto'){
		if ( has_post_thumbnail() ) {
			$attachment_count = count( $product->get_gallery_attachment_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			echo apply_filters(
				'woocommerce_single_product_image_html',
				sprintf(
					'<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto%s">%s</a>',
					esc_url( $props['url'] ),
					esc_attr( $props['caption'] ),
					$gallery,
					$image
				),
				$post->ID
			);
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}

    } else { ?>
    <a href="<?php if(get_post_meta($post->ID, "thumb", true)){ $thumb = get_post_custom_values( "thumb"); echo $thumb[0]; } else if( has_post_thumbnail() ){ ?><?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); echo $large_image_url[0]; } else { ?><?php echo get_content_first_image(get_the_content()); ?><?php } ?>" data-caption="<?php the_title(); ?>" title="<?php the_title(); ?>" itemprop="image" data-fancybox="images"><?php $product_cateimg_width = $salong['product_cateimg_width'];$product_cateimg_height = $salong['product_cateimg_height']; post_thumbnail($product_cateimg_width,$product_cateimg_height); ?></a>
    <?php }
		do_action( 'woocommerce_product_thumbnails' );
	?>
</div>
