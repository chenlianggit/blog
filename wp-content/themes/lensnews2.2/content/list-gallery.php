<?php global $salong; ?>
<?php if($salong['switch_gallery_content']==0) { ?>
<article class="gallery_grid<?php wow(); ?>">
    <?php post_thumbnail(); ?>
    <section class="gallery_popup">
        <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a></h2>
        <span>
            <?php _e( '作者：', 'salong' ); ?><?php if(get_post_meta($post->ID, "author", true)){ $author = get_post_custom_values( "author"); echo $author[0]; } else { ?><?php the_author_nickname(); ?><?php } ?>
        </span>
        <a href="<?php if(get_post_meta($post->ID, "thumb", true)){ $thumb = get_post_custom_values( "thumb"); echo $thumb[0]; } else if( has_post_thumbnail() ){ ?><?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); echo $large_image_url[0]; } else { ?><?php echo get_content_first_image(get_the_content()); ?><?php } ?>" class="btn view" data-fancybox="group" title="<?php the_title(); ?>" data-caption="<?php the_title(); ?>"><i class="icon-search-1"></i></a>
        <a href="<?php the_permalink() ?>" class="btn link"<?php echo new_open_link(); ?>><i class="icon-link" title="<?php _e( '查看画廊', 'salong' ); ?>"></i></a>
    </section>
</article>
<?php } else { ?>
<article class="postgrid<?php wow(); ?>">
    <figure>
        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>>
            <?php post_thumbnail(); ?>
        </a>
    </figure>
    <section class="gallery_main">
        <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a></h2>
        <?php get_template_part( 'content/home', 'info'); ?>
    </section>
</article>
<?php } ?>