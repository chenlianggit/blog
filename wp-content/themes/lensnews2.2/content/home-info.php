<?php global $salong;?>
<div class="homeinfo">
    <!--分类-->
    <span class="category"><?php if ( 'video' == get_post_type() ){ ?><?php the_terms( $post->ID, 'video-cat','' );?><?php } else if ( 'gallery' == get_post_type() ){ ?><?php the_terms( $post->ID, 'gallery-cat','' );?><?php } else { ?><?php the_category(', ') ?><?php } ?></span>
    <!--时间-->
    <span class="date"><?php the_time('Y-m-d'); ?></span>
    <!--点赞-->
    <?php if($salong[ 'home_meta_btn']=='comment' ){ ?>
    <span class="comment"><i class="icon-comment"></i><?php echo get_post($post->ID)->comment_count; ?></span>
    <?php }else if($salong[ 'home_meta_btn']=='view' ){ ?>
    <span class="view"><i class="icon-eye"></i><?php echo getPostViews(get_the_ID()); ?></span>
    <?php }else{ echo getPostLikeLinkList(get_the_ID());}?>
</div>