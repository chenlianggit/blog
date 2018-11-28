<?php global $salong;?>

<?php if ($salong[ 'video_metas'] !=0 ) { ?>
<aside class="custompost_info">
    <h3><?php echo $salong['video_info_title']; ?></h3>
    <?php if (in_array( 'author', $salong[ 'video_metas'])) { ?>
    <!--作者-->
    <span class="author"><?php _e( '作者：','salong'); ?><?php if(get_post_meta($post->ID, "author", true)){ $author = get_post_custom_values( "author"); echo $author[0]; } else { ?><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php the_author_nickname(); ?>"><?php the_author_nickname(); ?></a><?php } ?></span>
    <?php } if (in_array( 'category', $salong[ 'video_metas'])) { ?>
    <!--分类-->
    <span class="category"><?php _e( '分类：','salong'); ?><?php the_terms( $post->ID, 'video-cat','' );?></span>
    <?php } if (in_array( 'tag', $salong[ 'video_metas'])) { ?>
    <!--评论-->
    <span class="tag"><?php _e( '标签：','salong'); ?><?php echo get_the_term_list( $post->ID,'video-tag','',', ',''); ?></span>
    <?php } if (in_array( 'date', $salong[ 'video_metas'])) { ?>
    <!--时间-->
    <span class="date"><?php _e( '日期：','salong'); ?><?php the_time('Y-m-d'); ?></span>
    <?php } if (in_array( 'view', $salong[ 'video_metas'])) { ?>
    <!--浏览量-->
    <span class="view"><?php _e( '浏览：','salong'); ?><?php setPostViews(get_the_ID()); ?><?php echo getPostViews(get_the_ID()); ?></span>
    <?php } if (in_array( 'comment', $salong[ 'video_metas'])) { ?>
    <!--评论-->
    <span class="comment"><?php _e( '评论：','salong'); ?><?php comments_popup_link('0', '1', '%'); ?></span>
    <?php } if (in_array( 'like', $salong[ 'video_metas'])) { ?>
    <!--点赞-->
    <?php echo getPostLikeLinkList(get_the_ID());?>
    <?php } ?>
</aside>
<?php } ?>