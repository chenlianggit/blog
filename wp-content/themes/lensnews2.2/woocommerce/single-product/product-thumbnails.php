<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	?>
	<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop === 0 || $loop % $columns === 0 ) {
				$classes[] = 'first';
			}

			if ( ( $loop + 1 ) % $columns === 0 ) {
				$classes[] = 'last';
			}

			$image_class = implode( ' ', $classes );
			$props       = wc_get_product_attachment_props( $attachment_id, $post );

			if ( ! $props['url'] ) {
				continue;
			}
            global $salong;
            if( $salong['thumb_mode']== 'wpauto'){

			echo apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					'<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>',
					esc_url( $props['url'] ),
					esc_attr( $image_class ),
					esc_attr( $props['caption'] ),
					wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
				),
				$attachment_id,
				$post->ID,
				esc_attr( $image_class )
			);
            } else { ?>
            <a href="<?php echo esc_url( $props['url'] ); ?>" data-fancybox="images" data-caption="<?php echo esc_attr( $props['title'] ); ?>" title="<?php echo esc_attr( $props['title'] ); ?>">
            <?php 
                    $product_gallery_width = $salong['product_gallery_width'];
                    $product_gallery_height = $salong['product_gallery_height'];
                    if( $salong['switch_lazyload']== true ){ ?>
            <img class="thumb" src="<?php echo get_bloginfo("template_url"); ?>/includes/timthumb.php?src=<?php echo $salong['thumb_loading']['url']; ?>&amp;w=280&amp;h=158" data-original="<?php echo get_bloginfo("template_url"); ?>/includes/timthumb.php?src=<?php echo esc_url( $props['url'] ); ?>&amp;w=<?php echo $product_gallery_width; ?>&amp;h=<?php echo $product_gallery_height; ?>" alt="<?php echo esc_attr( $props['alt'] ); ?>">
            <?php } else { ?>
            <img class="thumb" src="<?php echo get_bloginfo("template_url"); ?>/includes/timthumb.php?src=<?php echo esc_url( $props['url'] ); ?>&amp;w=<?php echo $product_gallery_width; ?>&amp;h=<?php echo $product_gallery_height; ?>" alt="<?php echo esc_attr( $props['alt'] ); ?>">
            <?php } ?>
            </a>
            <?php }

			$loop++;
		}

	?></div>
	<?php
}
