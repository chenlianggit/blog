<?php get_header(); ?>
<?php global $salong; ?>
<section class="container">
    <!-- 置顶文章 -->
    <?php if (in_array( 'bulletin', $salong['switch_post_type'])) { ?>
    <?php get_template_part( 'content/home', 'bulletin'); ?>
    <?php } ?>
    <section class="slides-sticky wrapper<?php wow(); ?>">
        <!-- 幻灯片 -->
        <?php get_template_part( 'content/slides', 'home'); ?>
        <!-- 置顶文章 -->
        <?php get_template_part( 'content/home', 'sticky'); ?>
    </section>
    <?php $indexorg=$salong[ 'home_layout'][ 'enabled'];
    if ($indexorg): foreach ($indexorg as $fallthrume=>$value) {
        switch($fallthrume) {
            case 'home_like'    : get_template_part( 'content/home', 'like'); break;
            case 'home_cat1'    : get_template_part( 'content/home', 'cat1'); break;
            case 'home_gallery' : if (in_array( 'gallery', $salong[ 'switch_post_type'])) { get_template_part( 'content/home', 'gallery'); } break;
            case 'home_cat2'    : get_template_part( 'content/home', 'cat2'); break;
            case 'home_product' : if (class_exists( 'woocommerce' )){ get_template_part( 'content/home', 'product'); } break;
            case 'home_cat3'    : get_template_part( 'content/home', 'cat3'); break;
            case 'home_video'   : if (in_array( 'video', $salong[ 'switch_post_type'])) { get_template_part( 'content/home', 'video'); } break;
            case 'home_new'     : get_template_part( 'content/home', 'new'); break;
        }
    } endif; ?>
    <?php if($salong['switch_slogan']){ get_template_part( 'content/home', 'slogan'); } ?>
</section>
<?php get_footer(); ?>