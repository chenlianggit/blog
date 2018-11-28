<?php global $salong; ?>
<div id="comments" class="box<?php triangle();wow(); ?>">
    <?php if ( post_password_required() ) : ?>
    <p class="nopassword">
        <?php _e( '这篇文章是密码保护的，输入密码以查看任何评论。', 'salong' ); ?>
    </p>
</div>
<!-- #comments -->
<?php return; endif;?>

<?php if ( have_comments() ) : ?>
<section class="comment_title">
    <h2>
        <?php _e('评论：','salong'); ?>
    </h2>
    <?php if ( 'open'==$post->comment_status) {
        $my_email  = get_bloginfo ( 'admin_email' );
        $str       = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
        $count_t   = $post->comment_count;
        $count_v   = $wpdb->get_var("$str != '$my_email'");
        $count_h   = $wpdb->get_var("$str = '$my_email'");
    ?>
    <span class="hint">
        <?php echo sprintf( __( '%s 条评论，访客：%s 条，博主：%s 条' , 'salong' ), esc_attr($count_t), esc_attr($count_v), esc_attr($count_h) ); ?>
        <?php if($numPingBacks>0) { ?><?php printf( __( '，当前引用：%s 条' , 'salong' ), esc_attr($numPingBacks)); ?><?php } ?>
    </span>
    <?php }else{ ?>
    <p class="hint">
        <?php _e( '评论已关闭，往期评论：', 'salong' ); ?>
    </p>
    <?php } ?>
</section>
<!--评论列表-->
<ol class="commentlist">
    <?php wp_list_comments( array( 'callback' => 'salong_comment' ) ); ?>
</ol>
<!--评论分页-->
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
<div class="pagination nav-links">
    <?php echo paginate_comments_links( 'echo=0'); ?>
</div>
<?php endif; ?>

<?php if ( ! comments_open() && get_comments_number() ) : ?>
<p class="nocomments">
    <?php _e( '评论已关闭！' , 'salong' ); ?>
</p>
<?php endif; ?>

<?php endif; ?>
<?php if ( 'open'==$post->comment_status) { ?>
<?php comment_form(); ?>
<?php } ?>
</div>
