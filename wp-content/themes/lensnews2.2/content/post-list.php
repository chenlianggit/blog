<?php global $salong; ?>

<article class="postlist">
    <figure><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php if( $salong['thumb_mode']== 'timthumb'){ post_thumbnail(); }else{ widget_post_thumbnail(); } ?></a></figure>
    <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a></h3>
    <?php get_template_part( 'content/home', 'info'); ?>
</article>