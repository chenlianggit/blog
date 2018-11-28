<?php

/*
            /$$            
    /$$    /$$$$            
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$ 
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/ 
================================
        Keep calm and get rich.
                    Is the best.

    @Author: Dami
    @Date:   2017-09-08 12:47:33
    @Last Modified by:   Dami
    @Last Modified time: 2017-09-12 20:46:39

*/


if( isset($_POST['action']) && $_POST['action'] == 'ajax_load_posts' ){
    wp_list_comments('avatar_size=50&type=comment&callback=mi_comment&end-callback=mi_end_comment&max_depth=2');
    die();
}

if ( post_password_required() ) {
    return;
}
?>
<div id="comments" class="m-comments">
    <h4>文章评论 <?php printf('<small>(%s)</small>',get_comments_number()) ?></h4>
    <div id="respond" class="comment-respond">
    <?php if( get_option('comment_registration') && !$user_ID ) : ?> 
        <div class="logged-in-as"><a href="<?php echo get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()); ?>">登录</a>后可参与讨论</div>
    <?php else : ?>       
        <form method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" id="commentform" class="comment-form">
            <div class="comment-avatar hidden-xs">
                <?php
                    if ( $user_ID ) {
                        echo get_avatar( $user_ID, 50 ); 
                    }else if ( $comment_author_email != '' ){
                        echo get_avatar( $comment_author_email, 50 ); 
                    }else{
                        echo get_avatar( '', 50 ); 
                    }
                ?>
            </div>
            <div class="comment-author-from"> 
        <?php if ( $user_ID ) : ?>
            <div class="comment-from-main">
                <div class="logged-in-as">你好，<?php echo $user_identity; ?> ！ <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="退出"><?php echo '退出'; ?></a></div>
            </div>
        <?php elseif ( '' != $comment_author ): ?>
            <div class="comment-from-main">
                <div class="logged-in-as"><?php printf(__('你好，%s，'), $comment_author); ?>
                    <a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info"><i>[ 资料修改 ]</i></a>
                </div>
            </div>
        <?php endif; ?>
        <?php if ( ! $user_ID ): ?>
            <div class="form-comment-info">
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-6 col-md-6 comment-form-author">
                        <input class="form-control" id="author" placeholder="昵称" name="author" type="text" value="<?php echo $comment_author; ?>" required="required">
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 comment-form-email"> 
                        <input id="email" class="form-control" name="email" placeholder="邮箱" type="email" value="<?php echo $comment_author_email; ?>" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-12 col-md-12 comment-form-url">
                        <input class="form-control" placeholder="网址" id="url" name="url" type="url" value="<?php echo $comment_author_url; ?>">
                    </div>
                </div>
            </div>
        <?php endif; ?>
            <div class="form-group comment-form-comment">
                
                <div class="comment-textarea">
                    <?php 
                        $replytoid = isset($_GET['replytocom']) ? (int) $_GET['replytocom'] : 0; 
                        if( $replytoid ){
                            $comment = get_comment($replytoid);
                            $reply_to =  '回复 @'.get_comment_author( $comment );
                        }else{
                            $reply_to = '';
                        }
                    ?>
                    <textarea id="comment" name="comment" placeholder="<?php echo $reply_to; ?>" cols="45" rows="8" maxlength="65525"  aria-required="true" required="required"></textarea>
                    <div class="text-bar">
                        
                        <div class="drop-suxing dropdown-smilies">
                            <button id="drop_Smilies" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="btn"><i class="icon icon-emotsmile" aria-hidden="true"></i></button>
                            <div class="dropdown-suxing" aria-labelledby="drop_Smilies">
                                <?php echo mi_get_wpsmiliestrans(); ?>
                            </div>
                        </div>


                        <button class="btn add_image"><i class="icon icon-picture"></i></button>
                        <button class="btn add_code"><i class="fa fa-code" aria-hidden="true"></i></button>
                    </div>
                </div> 
                
            </div>
            <div class="form-submit  row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                <?php if ( ! $user_ID ): ?> 
                    <div class="form-captcha clearfix">
                        <input class="form-control pull-left" id="captcha" placeholder="验证码" name="captcha" type="text" value="" aria-required="true">
                        <span class="captcha-image"><img src="<?php bloginfo( 'url' ); ?>/?captha=show" alt="验证码">
                        </span>
                    </div>
                <?php endif; ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 text-right">
                    <a rel="nofollow" id="cancel-comment-reply-link" style="display: none" class="btn btn-default" href="javascript:;">再想想</a>
                    <input name="submit" type="submit" id="submit" class="btn btn-primary" value="发表评论">
                    <?php comment_id_fields(); ?>
                </div>
            </div>
            </div>          
        </form>
    <?php endif; ?>
    </div> <!-- #respond -->
    <ul class="comment-list">
        <?php wp_list_comments('avatar_size=50&type=comment&callback=mi_comment&end-callback=mi_end_comment&max_depth=2');  ?>
    </ul>
    <?php if( get_comment_pages_count() > 1 ){ ?>
    <div class="comment-nav text-center">
        <div class="post-loading"><span></span><span></span><span></span><span></span><span></span></div>
        <button 
            data-page="comments" 
            data-query="<?php the_ID(); ?>"
            data-action="ajax_load_posts" 
            data-paged="<?php echo get_next_page_number(); ?>" 
            data-commentcount="<?php echo get_comment_pages_count(); ?>" 
            data-commentspage="<?php echo get_option( 'default_comments_page' ); ?>" 
            data-append="comment-list" 
            class="btn btn-default dm-ajax-load">加载更多</button>
    </div>
    <?php } ?>

    
</div>