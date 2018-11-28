<?php global $salong; ?>
<article class="post_main">
    <figure>
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>>
            <?php post_thumbnail(); ?>
        </a>
    </figure>
    <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a></h2>
    <?php get_template_part( 'content/blog', 'info'); ?>
    <!-- 摘要 -->
    <div class="excerpt">
        <?php if (has_excerpt()) { ?>
        <?php echo wp_trim_words(get_the_excerpt(),116); ?>
        <?php } else{ echo wp_trim_words(get_the_content(),116); } ?>
    </div>
    <!-- 摘要end -->
</article>