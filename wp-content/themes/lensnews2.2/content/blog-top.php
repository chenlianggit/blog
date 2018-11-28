<?php global $salong; if(is_category()){ foreach(get_the_category() as $category) { $cat=$category->cat_ID; } } ?>
<?php $args=array( 'post_type'=>
'post','posts_per_page' => 4,'ignore_sticky_posts' => 1,'meta_key'=>'votes_count','orderby'=>$salong['cat_post_orderby'],'order'=>$salong['cat_post_order'],'cat'=> $cat);$wp_query = new WP_Query( $args );if ( $wp_query->have_posts() ) { ?>
<section class="post_list box<?php if(!wp_is_mobile()) { echo ' post_bottom'; } ?><?php triangle();wow(); ?>">
    <ul class="layout_ul">
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
        <li class="layout_li">

            <article class="postgrid">
                <figure>
                    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>>
                        <?php post_thumbnail(); ?>
                    </a>
                </figure>
                <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"<?php echo new_open_link(); ?>><?php the_title(); ?></a></h2>
                <div class="homeinfo">
                    <!--分类-->
                    <span class="category"><?php if ( 'video' == get_post_type() ){ ?><?php the_terms( $post->ID, 'video-cat','' );?><?php } else if ( 'gallery' == get_post_type() ){ ?><?php the_terms( $post->ID, 'gallery-cat','' );?><?php } else { ?><?php the_category(', ') ?><?php } ?></span>
                    <!--时间-->
                    <span class="date"><?php the_time('Y-m-d'); ?></span>
                    <!--点赞-->
                    <?php if($salong[ 'cat_post_orderby']=='comment_count' ){ ?>
                    <span class="comment"><i class="icon-comment"></i><?php echo get_post($post->ID)->comment_count; ?></span>
                    <?php }else{ echo getPostLikeLinkList(get_the_ID());}?>
                </div>
            </article>
        </li>
        <?php endwhile; ?>
    </ul>
</section>
<?php } ?>
<?php wp_reset_query(); ?>