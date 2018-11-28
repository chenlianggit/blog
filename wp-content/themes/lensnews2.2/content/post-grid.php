<?php global $salong; ?>

<article class="postgrid">
    <figure>
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>>
            <?php post_thumbnail(); ?>
        </a>
    </figure>
    <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a></h2>
    <?php get_template_part( 'content/home', 'info'); ?>
</article>