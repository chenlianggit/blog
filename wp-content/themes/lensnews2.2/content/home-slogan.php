<?php global $salong; ?>

<section class="slogan<?php wow(); ?>" style="background-image: url(<?php echo $salong['slogan_bg']['url']; ?>)">
    <h3><?php echo $salong['slogan_title']; ?></h3>
    <p>
        <?php echo $salong[ 'slogan_text']; ?>
    </p>
    <a href="<?php $slogan_link = $salong['slogan_link']; ?><?php echo get_page_link($slogan_link); ?>">
        <?php _e( '联系我们', 'salong' ); ?>
    </a>
    <div class="bg"></div>
</section>