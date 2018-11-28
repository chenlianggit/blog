<?php global $salong;
$becount=$salong[ 'be_count'];
?>

<?php $bulletincount=$salong[ 'bulletin_count'];$args=array( 'post_type'=> 'bulletin','posts_per_page' => $bulletincount ); $wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) { ?>
<section class="bulletin wrapper<?php wow(); ?>">
    <!--标题-->
    <section class="bulletin_title">
        <i class="<?php echo $salong[ 'bulletin_icon']; ?>"></i>
        <h3><?php echo $salong[ 'bulletin_title']; ?></h3>
    </section>
    <!--标题end-->
    <div class="swiper-container swiper-bulletin">
        <div class="swiper-wrapper">
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <article class="swiper-slide slide-bulletin">
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                    <?php echo wp_trim_words(get_the_content(),$becount); ?>
                </a>
            </article>
            <?php endwhile; ?>
        </div>
    </div>
    <!-- 按钮 -->
    <div class="swiper-button swiper-bulletin-next icon-angle-right"></div>
    <div class="swiper-button swiper-bulletin-prev icon-angle-left"></div>
</section>
<?php } ?>
<?php wp_reset_query(); ?>