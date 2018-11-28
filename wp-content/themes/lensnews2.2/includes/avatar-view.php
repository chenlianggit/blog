<?php global $current_user;
$user_id = $current_user->ID;
$user_name = $current_user->display_name;
?>
<div id="profile_avatar">
   <label for="avatar"><?php _e('头像','salong'); ?></label>
    <?php if($profile_avatar == ''){?>
    <?php echo get_avatar(get_current_user_id(),100,'','',array('class'=>'img-responsive img-circle'))?>
    <?php }else{?>
    <?php echo salong_get_avatar($user_id,$user_name); ?>
    <?php } ?>

    <a class="avatar_uploader" href="javascript:void(0)">
        <?php _e('点击更换头像','salong'); ?>
    </a>
    <span><?php echo sprintf(__('当前为<strong>%s</strong>，建议大小：120*120。获取头像的顺序为：自定义头像、社交头像、全球通用头像、默认头像','salong'),salong_avatar_name()); ?></span>

</div>
