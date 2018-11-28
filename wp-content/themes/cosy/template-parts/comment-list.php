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
  	@Date:   2017-09-13 14:35:52
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-09-13 14:37:27

*/
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
    <article id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <div class="comment-avatar vcard">
            <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
        </div><!-- .comment-author -->
        <div class="comment-text">
            <div class="comment-info">
                <h6 class="comment-author">
                	<?php comment_author_link() ?>
                	<?php dami_official( $comment->user_id ); ?>		
                </h6>     
            </div>
            <div class="comment-content">
                <?php 
                	comment_text(); 
                ?>            
                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="tip-comment-check">您的评论正在等待审核中...</p>
	            <?php endif; ?>
            </div><!-- .comment-content -->
            <div class="comment-meta">
                <time class="comment-date"><?php echo timeago(get_gmt_from_date( get_comment_time('Y-m-d H:i:s') ) ) ?></time>
                <a href="javascript:;" data-id="<?php comment_ID(); ?>" data-caction="up" data-action="comment_up_down" class="like comment-action"><i class="icon icon-like" aria-hidden="true"> <?php echo get_comment_up_down( get_comment_ID(), 'up' ); ?></i></a>
                <a href="javascript:;" data-id="<?php comment_ID(); ?>" data-caction="down" data-action="comment_up_down" class="fuck comment-action"><i class="icon icon-dislike" aria-hidden="true"> <?php echo get_comment_up_down( get_comment_ID(), 'down' ); ?></i></a>
                <?php if ($depth == get_option('thread_comments_depth')) : ?>    
				     <a onclick="return addComment.moveForm( 'comment-<?php comment_ID() ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID() ?>#respond" class="comment-reply-link" rel="nofollow"><i class='icon icon-action-undo' aria-hidden='true'></i> 回复</a>
				 <?php else: ?>
				     <a onclick="return addComment.moveForm( 'comment-<?php comment_ID() ?>','<?php comment_ID() ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID() ?>#respond" class="comment-reply-link" rel="nofollow"><i class='icon icon-action-undo' aria-hidden='true'></i> 回复</a>
				 <?php endif; ?>
            </div>
            
        </div><!-- .comment-text -->          
    </article><!-- .comment-body -->