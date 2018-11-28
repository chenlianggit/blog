<!-- 相关文章 -->
<?php
global $salong;
$taxterms = wp_get_object_terms( $post->ID, 'video-cat', array('fields' => 'ids') );
$vhotlike_count = $salong[ 'vhotlike_count'];
$commentcount = get_comments_number(); ?>

<section class="hotlike_posts addnew box<?php triangle();wow(); ?>">
    <!--热评文章-->
    <section class="new">
        <!--标题-->
        <h3><?php echo $salong['vnew_title']; ?></h3>
        <!--标题end-->
        <ul class="layout_ul">
            <?php $args=array( 'post_type'=> 'video','posts_per_page' => $vhotlike_count,'ignore_sticky_posts' => 1);$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $i=1; while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li class="layout_li">
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><span><?php echo $i;$i++; ?></span><?php the_title(); ?></a>
            </li>
            <?php endwhile;endif; wp_reset_query(); ?>
        </ul>
    </section>
    <!--热评文章-->
    <section class="hot">
        <!--标题-->
        <h3><?php echo $salong['vhot_title']; ?></h3>
        <!--标题end-->
        <ul class="layout_ul">
            <?php $args=array( 'post_type'=> 'video','posts_per_page' => $vhotlike_count,'orderby'=>'comment_count','ignore_sticky_posts' => 1,'tax_query' => array( array( 'taxonomy' => 'video-cat', 'field' => 'id', 'terms' => $taxterms )));$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $i=1; while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
            <li class="layout_li">
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>&nbsp;<?php printf( _n( '有(1)条评论', '有(%s)条评论', $commentcount, 'salong' ), $commentcount );  ?>"><span><?php echo $i;$i++; ?></span><?php the_title(); ?></a>
            </li>
            <?php endwhile;endif; wp_reset_query(); ?>
        </ul>
    </section>
    <!--最赞的文章-->
    <section class="like">
        <!--标题-->
        <h3><?php echo $salong['vlike_title']; ?></h3>
        <!--标题end-->
        <ul class="layout_ul">
            <?php $args=array( 'post_type'=> 'video','posts_per_page' => $vhotlike_count,'orderby'=>'votes_count','meta_key'=>'votes_count','ignore_sticky_posts' => 1,'tax_query' => array( array( 'taxonomy' => 'video-cat', 'field' => 'id', 'terms' => $taxterms )));$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) : $i=1; while ( $wp_query->have_posts() ) : $wp_query->the_post();
            $votes_count=get_post_custom_values( "votes_count");
            ?>
            <li class="layout_li">
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>&nbsp;<?php printf( __( '有(%s)人点赞', 'salong' ), $votes_count[0] ); ?>"><span><?php echo $i;$i++; ?></span><?php the_title(); ?></a>
            </li>
            <?php endwhile;endif; wp_reset_query(); ?>
        </ul>
    </section>
</section>