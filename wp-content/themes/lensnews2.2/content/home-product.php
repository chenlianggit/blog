<?php global $salong; if (class_exists( 'woocommerce' ) && $salong[ 'product_cat']){ ?>

<section class="<?php if($salong['switch_product_width']){echo 'home_product';}else{echo 'home_product_w wrapper';} ?> box<?php triangle();wow(); ?>">
    <!--标题-->
    <section class="home_title">
        <h3 class="left"><i class="<?php echo $salong['product_icon']; ?>"></i><?php echo $salong['product_title']; ?></h3>
        <?php if($salong[ 'product_tag']) { ?>
        <section class="title-tag right">
            <ul>
                <?php $hometagsorderby=$salong[ 'home_tag_orderby']; $hometagsorder=$salong[ 'home_tag_order']; $hometags=implode( ',',$salong[ 'product_tag']); $args=array( 'include'=> $hometags,'orderby'=>$hometagsorderby, 'order'=>$hometagsorder,'taxonomy'=>'product_tag');$tags = get_terms($args);foreach ($tags as $tag) { ?>
                <li>
                    <a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php _e( '查看', 'salong'); ?> <?php echo $tag->name;?> <?php _e( '标签下的产品', 'salong'); ?>">
                        <?php echo $tag->name; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
            <a href="<?php $product_link = $salong['product_link']; ?><?php echo get_page_link($product_link); ?>" class="home_button" title="<?php _e( '查看更多', 'salong' ); ?>"><i class="icon-plus-circled"></i></a>
        </section>
        <?php } ?>
    </section>
    <!--标题end-->
    <section class="product_list">
        <ul class="layout_ul">
            <?php $productcount=$salong[ 'product_count']; $args=array( 'post_type'=> 'product','posts_per_page' => $productcount,'ignore_sticky_posts' => 1,'tax_query' => array(array('taxonomy' => 'product_cat','field'=>'id','terms'=> $salong[ 'product_cat']),),); $wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <?php wc_get_template_part( 'content', 'product' ); ?>
            <?php endwhile;endif; ?>
            <?php wp_reset_query(); ?>
        </ul>
    </section>
</section>
<?php } ?>