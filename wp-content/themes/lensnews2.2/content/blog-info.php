<?php global $salong;
$user_id = get_the_author_meta('ID');
$user_name = get_the_author_meta('display_name');
?>

<?php if ($salong[ 'blog_metas'] !=0 ) { ?>
<div class="postinfo">
    <div class="left">
        <?php if (in_array( 'author', $salong[ 'blog_metas'])) { ?>
        <!--作者-->
        <span class="author"><?php if(get_post_meta($post->ID, "author", true)){ $author = get_post_custom_values( "author"); echo $author[0]; } else { ?><a href="<?php echo get_author_posts_url($user_id); ?>" title="<?php echo $user_name; ?>"><?php echo salong_get_avatar($user_id,$user_name); ?><?php echo $user_name; ?></a><?php } ?></span>
        <?php } if (in_array( 'category', $salong[ 'blog_metas'])) { ?>
        <!--分类-->
        <span class="category"><?php the_category(', ') ?></span>
        <?php } if (in_array( 'date', $salong[ 'blog_metas'])) { ?>
        <!--时间-->
        <span class="date"><?php the_time('Y-m-d'); ?></span>
        <?php } ?>
    </div>
    <div class="right">
        <?php if (in_array( 'view', $salong[ 'blog_metas'])) { ?>
        <!--浏览量-->
        <span class="view"><i class="icon-eye"></i><?php if(is_single()){ setPostViews(get_the_ID()); } ?><?php echo getPostViews(get_the_ID()); ?></span>
        <?php } if (in_array( 'comment', $salong[ 'blog_metas'])) { ?>
        <!--评论-->
        <span class="comment"><i class="icon-comment"></i><?php if (post_password_required() || 'open'!=$post->comment_status) {echo get_post($post->ID)->comment_count;}else{comments_popup_link('0', '1', '%');} ?></span>
        <?php } if (in_array( 'like', $salong[ 'blog_metas'])) { ?>
        <!--点赞-->
        <?php echo getPostLikeLinkList(get_the_ID());?>
        <?php } ?>
    </div>
</div>
<?php } ?>