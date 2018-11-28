<?php

require_once( trailingslashit( get_template_directory() ) . 'includes/functions.php' );

//用户文章简码////////////////////////////////////////////////////
function salong_user_posts($atts){
    global $salong,$current_user,$post,$wp_query;
    $user_id = $current_user->ID;//当前用户 ID
    
    extract(
        shortcode_atts(
            array(
                "post_type" => 'post'
            ),
            $atts
        )
    );
    
    $get_trashed = $_GET['trashed'];
    $get_ids = $_GET['ids'];
    $current_url = get_permalink($wp_query->post->ID);//当前页面链接
    
    if($post_type == 'gallery'){
        $post_count = count_user_posts( $user_id, 'gallery');
        $post_name = __('画廊','salong');
        $taxonomy_name = 'gallery-cat';
    }else if($post_type == 'video'){
        $post_count = count_user_posts( $user_id, 'video');
        $post_name = __('视频','salong');
        $taxonomy_name = 'video-cat';
    }else if($post_type == 'product'){
        $post_count = count_user_posts( $user_id, 'product');
        $post_name = __('产品','salong');
        $taxonomy_name = 'product_cat';
    }else{
        $post_count = count_user_posts( $user_id, 'post');
        $post_name = __('文章','salong');
        $taxonomy_name = 'category';
    }
    
    
    echo '<section class="user_post">';
    echo sprintf(__('<p class="infobox">您已发布%s篇%s</p>','salong'),$post_count,$post_name);
    if($get_trashed == 1){
        echo sprintf(__('<p class="warningbox">您已成功删除%s：%s，<a href="%s">点击刷新</a></p>','salong'),$post_name,get_the_title($get_ids),$current_url);
    }
    echo '<ul class="ajaxposts">';
    $paged = $page = intval(get_query_var('paged'));
    $args  = array( 'post_type'=> $post_type,'ignore_sticky_posts' => 1,'paged' => $paged,'author'=>$user_id,'post_status' => array( 'publish', 'pending', 'draft' ));
    query_posts($args);
    if (have_posts() ) : while ( have_posts() ) : the_post();
    
    //文章状态
    $post_status = $post->post_status;
    if($post_status === 'draft'){
        $status = __('草稿','salong');
    }else if($post_status === 'pending'){
        $status = __('审核中','salong');
    }else if($post_status === 'publish'){
        $status = __('已发布','salong');
    }
    
    //自定义文章草稿或审核中文章链接
    if($post_status === 'draft' || $post_status === 'pending'){
        if($post_type == 'gallery' || $post_type == 'video' || $post_type == 'product'){
            $post_url = get_home_url().'/?post_type='.$post_type.'&p='.$post->ID;
        }else{
            $post_url = get_the_permalink();
        }
    }else{
        $post_url = get_the_permalink();
    }
    
    echo '<li class="ajaxpost">';
    echo '<article class="user_post_main">';
    echo '<h2><a href="'.$post_url.'" title="'.get_the_title().'"'.new_open_link().'>'.get_the_title().'</a></h2>';
    echo '<span class="post_status">'.$status.'</span>';
    echo '<div class="postinfo">';
    echo '<span class="category">';
    the_terms( $post->ID, $taxonomy_name,'' );
    echo '</span>';
    echo '<span class="date">'.get_the_date().'</span>';
    echo '<span class="view"><i class="icon-eye"></i>'.getPostViews(get_the_ID()).'</span>';
    $access_level = $salong['admin_access'];
    if(current_user_can($access_level) && $salong['switch_edit_delete_post']){
        echo '<span class="edit"><a href="'.get_edit_post_link().'"'.new_open_link().'><i class="icon-edit-1"></i></a></span>';?>
        <span class="delete"><a onclick="return confirm('<?php echo sprintf(__('确定删除该 %s','salong'),$post_name); ?>')" href="<?php echo get_delete_post_link( $post->ID ) ?>"><i class="icon-trash-empty"></i></a></span>
    <?php }
    echo '</article>';
    echo '</li>';
    endwhile;
    echo posts_pagination();
    else:
    echo '<p>';
    echo __( '非常抱歉，没有相关文章。');
    echo '</p>';
    endif;
    echo '</ul>';
    wp_reset_query();
    echo '</section>';
    
}
add_shortcode('user_posts','salong_user_posts');
//用户文章简码////////////////////////////////////////////////////end

//投稿简码////////////////////////////////////////////////////
function salong_contribute_post($atts){
    global $salong,$current_user,$post,$wp_query,$wpdb;
    $user_id      = $current_user->ID;//当前用户 ID
    $user_name    = $current_user->display_name;
    $user_email   = $current_user->user_email;
    $user_url     = $current_user->user_url;
    $current_url  = get_permalink($wp_query->post->ID);//当前页面链接
    
    extract(
        shortcode_atts(
            array(
                "post_type" => 'post'
            ),
            $atts
        )
    );
    
    if($post_type == 'gallery'){
        $post_name      = __('画廊','salong');
        $taxonomy_name  = 'gallery-cat';
        $tg_max         = $salong['gallery_tg_max'];
        $tg_min         = $salong['gallery_tg_min'];
    }else if($post_type == 'video'){
        $post_name      = __('视频','salong');
        $taxonomy_name  = 'video-cat';
        $tg_max         = $salong['video_tg_max'];
        $tg_min         = $salong['video_tg_min'];
    }else{
        $post_name      = __('文章','salong');
        $taxonomy_name  = 'category';
        $tg_max         = $salong['post_tg_max'];
        $tg_min         = $salong['post_tg_min'];
    } 
    
    // 投稿权限
    $contribute_access = $salong['contribute_access'];
    if (current_user_can( $contribute_access )) {

        if( isset($_POST['tougao_form']) && $_POST['tougao_form'] == 'send') {

            // 表单变量初始化
            $name       = isset( $_POST['tougao_authorname'] ) ? trim(htmlspecialchars($_POST['tougao_authorname'], ENT_QUOTES)) : '';
            $email      = isset( $_POST['tougao_authoremail'] ) ? trim(htmlspecialchars($_POST['tougao_authoremail'], ENT_QUOTES)) : '';
            $blog       = isset( $_POST['tougao_authorblog'] ) ? trim(htmlspecialchars($_POST['tougao_authorblog'], ENT_QUOTES)) : '';
            $from_name  = isset( $_POST['tougao_from_name'] ) ? trim(htmlspecialchars($_POST['tougao_from_name'], ENT_QUOTES)) : '';
            $from_link  = isset( $_POST['tougao_from_link'] ) ? trim(htmlspecialchars($_POST['tougao_from_link'], ENT_QUOTES)) : '';
            if($post_type == 'video'){
                $youku_id  = isset( $_POST['tougao_youku_id'] ) ? trim(htmlspecialchars($_POST['tougao_youku_id'], ENT_QUOTES)) : '';
                $video_url  = isset( $_POST['tougao_video_url'] ) ? trim(htmlspecialchars($_POST['tougao_video_url'], ENT_QUOTES)) : '';
            }
            if($post_type == 'gallery'){
                $slides = isset( $_POST['tougao_slides'] ) ? trim(htmlspecialchars($_POST['tougao_slides'], ENT_QUOTES)) : '';
            }
            $title      = isset( $_POST['tougao_title'] ) ? trim(htmlspecialchars($_POST['tougao_title'], ENT_QUOTES)) : '';
            $category   = isset( $_POST['term_id'] ) ? (int)$_POST['term_id'] : 0;
            $content    = isset( $_POST['tougao_content'] ) ? $_POST['tougao_content'] : '';

            $last_post = $wpdb->get_var("SELECT `post_date` FROM `$wpdb->posts` ORDER BY `post_date` DESC LIMIT 1");

            $post_content = '昵称:'.$name.'<br />Email:'.$email.'<br />博客:'.$blog.'<br />内容:<br />'.$content;

            $tougao = array(
                'post_title'    => $title,
                'post_content'  => $post_content,
                'post_author'   => $user_id,
                'post_type'     => $post_type,
                'ping_status'   => 'closed',
                'post_status'   => 'pending',
                'post_category' => array($category)
            );

            if ( (date_i18n('U') - strtotime($last_post)) < $salong['tg_time'] ) {
                echo '<span class="warningbox">'.__('您投稿也太勤快了吧，先歇会儿！','salong').'</span>';
            }else if ( empty($name) || mb_strlen($name) > 20 ) {
                echo '<span class="warningbox">'.sprintf(__('昵称必须填写，且长度不得超过20字，重新输入或者<a href="%s">点击刷新</a>','salong'),$current_url).'</span>';
            }else if ( empty($email) || strlen($email) > 60 || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
                echo '<span class="warningbox">'.sprintf(__('Email必须填写，且长度不得超过60字，必须符合Email格式，重新输入或者<a href="%s">点击刷新</a>','salong'),$current_url).'</span>';
            }else if ( empty($title) || mb_strlen($title) > 100 ) {
                echo '<span class="warningbox">'.sprintf(__('标题必须填写，且长度不得超过100字，重新输入或者<a href="%s">点击刷新</a>','salong'),$current_url).'</span>';
            }else if ( empty($content)) {
                echo '<span class="warningbox">'.sprintf(__('内容必须填写，重新输入或者<a href="%s">点击刷新</a>','salong'),$current_url).'</span>';
            }else if ( mb_strlen($content) > $tg_max ) {
                echo '<span class="warningbox">'.sprintf(__('内容长度不得超过%s字，重新输入或者<a href="%s">点击刷新</a>','salong'),$tg_max,$current_url).'</span>';
            }else if ( mb_strlen($content) < $tg_min) {
                echo '<span class="warningbox">'.sprintf(__('内容长度不得少于%s字，重新输入或者<a href="%s">点击刷新</a>','salong'),$tg_min,$current_url).'</span>';
            }else if ( $post_type == 'video' && empty($youku_id) && empty($video_url)) {
                echo '<span class="warningbox">'.sprintf(__('优酷视频 ID 或其它视频链接必须输入一个，重新输入或者<a href="%s">点击刷新</a>','salong'),$current_url).'</span>';
            }else if ( $post_type == 'video' && $youku_id && $video_url) {
                echo '<span class="warningbox">'.sprintf(__('优酷视频 ID 或其它视频链接只能输入一个，重新输入或者<a href="%s">点击刷新</a>','salong'),$current_url).'</span>';
            }else if ( $_POST['are_you_human'] == '' ) {
                echo '<span class="warningbox">'.sprintf(__('请输入本站名称：%s','salong'),get_option('blogname')).'</span>';
            }else if ( $_POST['are_you_human'] !== get_bloginfo( 'name' ) ) {
                echo '<span class="warningbox">'.sprintf(__('本站名称输入错误，正确名称为：%s','salong'),get_option('blogname')).'</span>';
            }else if ($tougao != 0) {

                // 将文章插入数据库
                $status = wp_insert_post( $tougao );
                if($post_type == 'video'){
                    if(!empty($youku_id)){
                        add_post_meta($status, 'youku_id', $youku_id, true);
                    }
                    if(!empty($video_url)){
                        add_post_meta($status, 'video_url', $video_url, true);
                    }
                }
                if($post_type == 'gallery'){
                    add_post_meta($status, 'slides', $slides, true);
                }
                if ( !empty($from_name) && !empty($from_link)) {
                    add_post_meta($status, 'from_name', $from_name, true);
                    add_post_meta($status, 'from_link', $from_link, true);
                }
                //添加自定义分类
                wp_set_object_terms( $status, $category, $taxonomy_name);
                // 投稿成功给博主发送邮件
                // somebody#example.com替换博主邮箱
                // My subject替换为邮件标题，content替换为邮件内容
                wp_mail(get_option('admin_email'),get_option('blogname').__('投稿','salong'),get_option('blogname').__('有投稿了，快去看看！','salong'));

                // 其中 salong_tougao_email 是自定义栏目的名称
                add_post_meta($status, 'salong_tougao_email', $email, TRUE);

                echo '<span class="successbox">'.__('投稿成功！感谢投稿！','salong').'</span>';
            }else {
                echo '<span class="errorbox">'.__('投稿失败!','salong').'</span>';
            }
        }

        echo '<form class="contribute_form" method="post" action="'.$current_url.'">';
        echo '<p><label for="tougao_title"><b>*</b>'.__('文章标题','salong').'</label><input type="text" value="" id="tougao_title" name="tougao_title" placeholder="'.__('请输入文章标题','salong').'" required /><span>'.sprintf(__('标题长度不得超过%s字。','salong'),100).'</span></p>';
        echo '<p><label for="tougao_category"><b>*</b>'.__('文章分类','salong').'</label>';
        wp_dropdown_categories('hide_empty=0&id=tougao_category&show_count=1&hierarchical=1&taxonomy='.$taxonomy_name.'&name=term_id&id=term_id');
        echo '</p>';
        echo '<p>'.wp_editor(  wpautop($post_content), 'tougao_content', array('media_buttons'=>true, 'quicktags'=>true, 'editor_class'=>'form-control' ) ).'<span>'.sprintf(__('内容必须填写，且长度不得超过 %s 字，不得少于 %s 字。','salong'),$tg_max,$tg_min).'</span></p><hr>';
        if($post_type == 'gallery'){
            echo '<p><label for="tougao_slides"><b>*</b>'.__('幻灯片图片','salong').'</label><textarea name="tougao_slides" id="tougao_slides" cols="40" rows="6" required tabindex="4"></textarea><span>'.sprintf(__('输入图片链接，一行一个，如果需要为图片添加说明，格式：%s/1.jpg|%s图片说明，同样是一行一个。注意：“|”是图片链接与说明的分隔线，为英文输入法下的竖线。<br>图片可以通过『添加媒体』按钮，上传图片到媒体库，复制图片地址到此就可以。','salong'),get_home_url(),get_bloginfo('name')).'</span></p><hr>';
        }
        if($post_type == 'video'){
            echo '<p class="video_hint"><label for="tougao_slides">'.__('视频说明：','salong').'</label><span>'.__('本站视频支持优酷、土豆等在线视频与本地视频两种，其中优酷视频请直接把视频 ID 输入到『优酷视频 ID』，可直接获取视频缩略图，其它在线视频和本地视频请输入视频链接到『其它视频链接』中，两者选其一。','salong').'</span></p>';
            echo '<p><label for="tougao_youku_id">'.__('优酷视频ID','salong').'</label><input type="text" value="" id="tougao_youku_id" name="tougao_youku_id" placeholder="'.__('请输入优酷视频ID','salong').'" /></p>';
            echo '<p><label for="tougao_video_url">'.__('其它视频链接','salong').'</label><input type="text" value="" id="tougao_video_url" name="tougao_video_url" placeholder="'.__('请输入优酷视频ID','salong').'" /></p><hr>';
        }
        echo '<p><label for="tougao_authorname"><b>*</b>'.__('昵称','salong').'</label><input type="text" value="'.$user_name.'" id="tougao_authorname" name="tougao_authorname" placeholder="'.__('请输入昵称','salong').'" required /></p>';
        echo '<p><label for="tougao_authoremail"><b>*</b>'.__('邮箱','salong').'</label><input type="text" value="'.$user_email.'" id="tougao_authoremail" name="tougao_authoremail" placeholder="'.__('请输入邮箱','salong').'" required /></p>';
        echo '<p><label for="tougao_authorblog">'.__('博客','salong').'</label><input type="text" value="'.$user_url.'" id="tougao_authorblog" name="tougao_authorblog" placeholder="'.__('请输入博客','salong').'" /></p><hr>';
        echo '<p><label for="tougao_from_name">'.__('文章来源网站名称','salong').'</label><input type="text" value="" id="tougao_from_name" name="tougao_from_name" /></p>';
        echo '<p><label for="tougao_from_link">'.__('文章来源网站链接','salong').'</label><input type="text" value="" id="tougao_from_link" name="tougao_from_link" /></p><hr>';
        echo '<p><label for="are_you_human"><b>*</b>'.sprintf(__('本站名称（请输入：%s）','salong'),get_option('blogname')).'<br/><input id="are_you_human" class="input" type="text" value="" name="are_you_human" required /></label></p>';
        echo '<p class="hint">'.$salong['contribute_info'].'</p>';
        echo '<p><input type="hidden" value="send" name="tougao_form" /><input type="submit" value="'.__('提交','salong').'" class="submit" /><input type="reset" value="'.__('重填','salong').'" class="reset" /></p>';
        echo '</form>';
    }else{
        echo $salong['contribute_access_info'];
    }
}
add_shortcode('contribute_post','salong_contribute_post');
