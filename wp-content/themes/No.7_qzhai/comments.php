<?php
    if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        return;
    if ( post_password_required() ) { ?>
        <h4><?php echo of_get('diy_comments') ? of_get('diy_comments') : '评论';?></h4>
    	<div class="uk-alert" >
			<p class="nocomments"><?php _e('必须输入密码，才能查看评论！'); ?></p>
		</div>
	<?php
		return;
	}

    if (!empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { 
        // if there's a password
        // and it doesn't match the cookie
    ?>
        <h4><?php echo of_get('diy_comments') ? of_get('diy_comments') : '评论';?></h4>
    	<div class="uk-alert" >
        	<p>请输入密码再查看评论内容.</p>
        </div>

    <?php 
        } else if ( !comments_open() ) {
    ?>
  		<!-- <div class="uk-alert">
        	<p>评论功能已经关闭!</p>
        </div> -->

    <?php 
        } else if ( !have_comments() ) { 
    ?>
        <h4><?php echo of_get('diy_comments') ? of_get('diy_comments') : '评论';?></h4>

    	<div class="qzhai-alert">
        	<p><?php echo of_get('diy_no_comments') ? of_get('diy_no_comments') : '还没有任何评论，你来说两句吧';?></p>
    	</div>
 
    <?php 
        } else {
            echo '<h4>';
            echo of_get('diy_comments') ? of_get('diy_comments') : '评论';
            echo'</h4>';
        	echo '<ul id="comments" class="uk-comment-list">';
                wp_list_comments('type=comment&callback=aurelius_comment');
            echo '</ul>';
	        echo '<ul class="uk-pagination">';
			echo '<li class="uk-pagination-previous">';
			     previous_comments_link();
			echo '</li>';
			echo '<li class="uk-pagination-next">';
			     next_comments_link();
			echo '</li>';
			echo '</ul>';
        }

    ?>
	<?php if ( !comments_open() ) : elseif ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
        <div class="uk-alert" data-uk-alert>
            <a href="" class="uk-alert-close uk-close"></a>
            <p>你必须 <a href="<?php echo wp_login_url( get_permalink() ); ?>">登录</a> 才能发表<?php echo of_get('diy_comments') ? of_get('diy_comments') : '评论';?>.</p>
        </div>
    <?php else  : ?>
    <div id="respond" class="comment_form" role="form">
                <h2 id="reply-title" class="comments-title"><?php comment_form_title( of_get('diy_published_comments') ? of_get('diy_published_comments') : '发表评论', '回复给 %s' ); ?> <small>
                        <?php cancel_comment_reply_link(); ?>
                    </small></h2>
                <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
                    <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
                <?php else : ?>
                    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="uk-form" id="commentform">
                        <?php if ( $user_ID ) : ?>
                            <div class="uk-margin-bottom">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>&nbsp;|&nbsp;<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></div>
                           
                            <div class="textarea_qzhai">
                                <ul class="uk-subnav">
                                    <li id="emojis_a" class="uk-parent" > 
                                        <a href="javascript:;" > <i class="uk-icon-smile-o"></i></a>    
                                    </li>
                                    <li> <a onclick="javascript:grin('<img src=\'输入图片地址\' />')"> <i class="uk-icon-image"></i></a> </li>
                                   
                                </ul>
                                 <div id="emojis_list" class="uk-overflow-container" style="display:none;">
                                    <table>
                                        <tr>
                                            <td><a onclick="javascript:grin(':razz:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f61b.png"></a></td>
                                            <td><a onclick="javascript:grin(':sad:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f612.png"></a></td>
                                            <td><a onclick="javascript:grin(':smile:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f60a.png"></a></td>
                                            <td><a onclick="javascript:grin(':oops:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f633.png"></a></td>
                                            <td><a onclick="javascript:grin(':grin:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f600.png"></a></td>
                                            <td><a onclick="javascript:grin(':eek:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f62e.png"></a></td>
                                            <td><a onclick="javascript:grin(':shock:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f62f.png"></a></td>
                                            <td><a onclick="javascript:grin(':???:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f615.png"></a></td>
                                            <td><a onclick="javascript:grin(':cool:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f60e.png"></a></td>
                                            <td><a onclick="javascript:grin(':lol:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f606.png"></a></td>
                                            <td><a onclick="javascript:grin(':mad:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f621.png"></a></td>
                                            <td><a onclick="javascript:grin(':wink:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f609.png"></a></td>
                                            <td><a onclick="javascript:grin(':cry:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f625.png">  </a></td>
                                            <td><a onclick="javascript:grin(':neutral:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f610.png"></a></td>
                                            <td><a onclick="javascript:grin(':evil:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f47f.png"></a></td>
                                            <td><a onclick="javascript:grin(':twisted:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f608.png"></a></td>
                                            <td><a onclick="javascript:grin(':idea:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f4a1.png"></a></td>
                                        </tr>
                                    </table>
                                </div>
                                <textarea id="comment" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};" placeholder="内容..." tabindex="1" name="comment"></textarea>
                                
                            </div>
                            <div style="">
                                <button name="submit" type="submit" id="submit" class="uk-button uk-width-1-1" tabindex="5"/>回复</button>
                        <p></p>
                            </div>
                            
                        <?php else : ?>
                            <div class="textarea_qzhai">
                                <ul class="uk-subnav">
                                    <li id="emojis_a" class="uk-parent" > 
                                        <a href="javascript:;" > <i class="uk-icon-smile-o"></i></a>    
                                    </li>
                                    <li> <a onclick="javascript:grin('<img src=\'输入图片地址\' />')"> <i class="uk-icon-image"></i></a> </li>
                                   
                                </ul>
                                 <div id="emojis_list" class="uk-overflow-container" style="display:none;">
                                    <table>
                                        <tr>
                                            <td><a onclick="javascript:grin(':razz:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f61b.png"></a></td>
                                            <td><a onclick="javascript:grin(':sad:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f612.png"></a></td>
                                            <td><a onclick="javascript:grin(':smile:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f60a.png"></a></td>
                                            <td><a onclick="javascript:grin(':oops:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f633.png"></a></td>
                                            <td><a onclick="javascript:grin(':grin:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f600.png"></a></td>
                                            <td><a onclick="javascript:grin(':eek:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f62e.png"></a></td>
                                            <td><a onclick="javascript:grin(':shock:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f62f.png"></a></td>
                                            <td><a onclick="javascript:grin(':???:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f615.png"></a></td>
                                            <td><a onclick="javascript:grin(':cool:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f60e.png"></a></td>
                                            <td><a onclick="javascript:grin(':lol:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f606.png"></a></td>
                                            <td><a onclick="javascript:grin(':mad:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f621.png"></a></td>
                                            <td><a onclick="javascript:grin(':wink:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f609.png"></a></td>
                                            <td><a onclick="javascript:grin(':cry:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f625.png">  </a></td>
                                            <td><a onclick="javascript:grin(':neutral:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f610.png"></a></td>
                                            <td><a onclick="javascript:grin(':evil:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f47f.png"></a></td>
                                            <td><a onclick="javascript:grin(':twisted:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f608.png"></a></td>
                                            <td><a onclick="javascript:grin(':idea:')"><img src="<?php echo  get_template_directory_uri() ;?>/img/72x72/1f4a1.png"></a></td>
                                        </tr>
                                    </table>
                                </div>
                                <textarea id="comment" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};" placeholder="<?php echo of_get('diy_default_textarea') ? of_get('diy_default_textarea') : '内容...';?>" tabindex="1" name="comment"></textarea>
                            </div>
                            <div class="text uk-grid uk-grid-small">
                                
                                <div class="uk-width-medium-1-4 uk-form-icon">
                                    <i class="uk-icon-qzhai iconfont icon-iconfuzhi"></i>
                                    <input id="author" type="text" tabindex="2" value="<?php echo $comment_author; ?>" name="author"  placeholder="<?php echo of_get('diy_default_name') ? of_get('diy_default_name') : '昵称*';?>" class="uk-width-1-1">
                                </div>
                                <div class=" uk-width-medium-1-4 uk-form-icon">
                                    <i class="uk-icon-qzhai iconfont icon-youjianxinjian"></i>
                                    <input id="email" type="text" tabindex="3" value="<?php echo $comment_author_email; ?>" name="email" placeholder="<?php echo of_get('diy_default_email') ? of_get('diy_default_email') : '邮箱*';?>" class="uk-width-1-1">
                                </div>
                                <div class="uk-width-medium-1-4 uk-form-icon">
                                    <i class="uk-icon-qzhai iconfont icon-pcduandiannao"></i>
                                    <input id="url" type="text" tabindex="4" value="<?php echo $comment_author_url; ?>" name="url" placeholder="<?php echo of_get('diy_default_url') ? of_get('diy_default_url') : '网址';?>" class="uk-width-1-1">
                                </div>
                                <div class="uk-width-medium-1-4">
                                    <button name="submit" type="submit" id="submit" class="uk-button uk-width-1-1" tabindex="5"/><?php echo of_get('diy_default_reply') ? of_get('diy_default_reply') : '回复';?></button>
                                </div>
                            </div>
                        <?php endif; ?>
                            <div class="uk-margin-small-top"><?php do_action('comment_form_qzhai'); ?></div>
                        <?php comment_id_fields(); ?>
                        <?php do_action('comment_form', $post->ID); ?>
                    </form>
                <?php endif; ?>
            </div>
    </form>
<?php endif; ?>
	<!-- Comment Form -->
