<?php 


/*****************************************************
编辑文章页面添加侧边小工具选项
*****************************************************/
/*定义自定义box*/
add_action( 'add_meta_boxes', 'add_sidebar_metabox' );
add_action( 'save_post', 'save_sidebar_postdata' );

/*添加一个box到文章侧边栏*/
function add_sidebar_metabox(){
    add_meta_box( 
        'custom_sidebar',
        __( '边栏选项', 'salong' ),
        'custom_sidebar_callback',
        'post', /*在文章中显示 */
        'side'
    );
}
/*输出box内容*/
function custom_sidebar_callback( $post ){
    global $wp_registered_sidebars;

    $custom = get_post_custom($post->ID);

    if(isset($custom['custom_sidebar']))
        $val = $custom['custom_sidebar'][0];
    else
        $val = "default";

    // 使用临时的验证
    wp_nonce_field( plugin_basename( __FILE__ ), 'custom_sidebar_nonce' );

    // 实际的数据输入字段
    $output = '<style>.inside select{width: 100% !important;}</style>';
    $output = '<label for="sidebar" style="display: block;margin-bottom: 8px;">'.__("选择边栏", 'salong' ).'</label>';
    $output .= "<select name='custom_sidebar' style='width:100%'>";

    // 添加默认选项
    $output .= "<option";
    if($val == "default")
        $output .= " selected='selected'";
    $output .= " value='sidebar-0'>".__('默认','salong')."</option>";

    // 获取所有边栏
    foreach($wp_registered_sidebars as $sidebar_id => $sidebar){
        $output .= "<option";
        if($sidebar_id == $val)
            $output .= " selected='selected'";
        $output .= " value='".$sidebar_id."'>".$sidebar['name']."</option>";
    }

    $output .= "</select>";

    echo $output;
}
/* 当文章保存时自动保存box数据 */
function save_sidebar_postdata( $post_id ){
    // 如果这是一个自动保存程序验证
    // 如果表单没有提交，不做任何操作
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // 验证这来自我们的屏幕,通过适当的授权
    // 因为save_post可以在其他时间触发

    if ( !wp_verify_nonce( $_POST['custom_sidebar_nonce'], plugin_basename( __FILE__ ) ) )
      return;

    if ( !current_user_can( 'edit_page', $post_id ) )
        return;

    $data = $_POST['custom_sidebar'];

    update_post_meta($post_id, "custom_sidebar", $data);
}

/*****************************************************
编辑文章页面添加侧边小工具选项end
*****************************************************/



/*****************************************************
文章选项
*****************************************************/

$post_meta_box           = array(
    'id'            => 'post_metabox',
    'title'         => __('文章选项','salong'),
    'page'          => 'post',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields'        => array(
        array(
            'name'  => __('SEO文章描述','salong'),
            'desc'  => __('留空则获取摘要或截取文章第一段一定的字数。','salong'),
            'id'    => 'description',
            'type'  => 'textarea',
            'std'   => ''
        ),
        array(
            'name'  => __('SEO文章关键词','salong'),
            'desc'  => __('自定义文章关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
            'id'    => 'tags',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('缩略图地址','salong'),
            'desc'  => __('建议大小比例：400*225','salong'),
            'id'    => 'thumb',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('设置本文为无边栏','salong'),
            'id'    => 'no_sidebar',
            'type'  => 'checkbox'
        ),
        array(
            'name'  => __('显示文章目录','salong'),
            'id'    => 'catalogue',
            'type'  => 'checkbox'
        ),
        array(
            'name'  => __('文章来源','salong'),
            'desc'  => __('文章来源的相关设置！','salong'),
            'type'  => 'title',
            'std'   => ''
        ),
        array(
            'name'  => __('网站名称','salong'),
            'id'    => 'from_name',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('网站链接','salong'),
            'id'    => 'from_link',
            'type'  => 'text',
            'std'   => ''
        ),
    )
);


add_action('admin_menu', 'salong_add_post_metabox');

// 创建METABOX面板
function salong_add_post_metabox() {
    global $post_meta_box;
    add_meta_box($post_meta_box['id'], $post_meta_box['title'], 'salong_show_post_metabox', $post_meta_box['page'], $post_meta_box['context'], $post_meta_box['priority']);
}

// 回调函数来显示字段
function salong_show_post_metabox() {
    global $post_meta_box, $post;

    echo '<input type="hidden" name="salong_post_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';
    echo '<style type="text/css">.form-table tr.title th,.form-table tr.title td,.form-wrap tr.title label{color:#f00}.form-table tr.title{border-bottom:1px #eee solid}</style>';

    foreach ($post_meta_box['fields'] as $field) {
        // 获取当前META参数
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr';
        if($field['type'] == 'title'){ echo ' class="title"'; }
        echo '><th style="width:16%"><label for="', $field['id'], '">', $field['name'], '</label></th><td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:100%" />', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:100%">', $meta ? $meta : $field['std'], '</textarea>', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
            case 'title':
                echo $field['desc'];
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}


add_action('save_post', 'salong_save_post_metabox');

// 保存META数据
function salong_save_post_metabox($post_id) {
    global $post_meta_box;

    // 临时验证
    if (!wp_verify_nonce($_POST['salong_post_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // 自动保存
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // 权限
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($post_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

/*****************************************************
文章选项end
*****************************************************/



/*****************************************************
页面选项
*****************************************************/

$page_meta_box           = array(
    'id'            => 'page_metabox',
    'title'         => __('页面选项','salong'),
    'page'          => 'page',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields'        => array(
        array(
            'name'  => __('SEO文章描述','salong'),
            'desc'  => __('留空则获取摘要或截取文章第一段一定的字数。','salong'),
            'id'    => 'description',
            'type'  => 'textarea',
            'std'   => ''
        ),
        array(
            'name'  => __('SEO文章关键词','salong'),
            'desc'  => __('自定义文章关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
            'id'    => 'tags',
            'type'  => 'text',
            'std'   => ''
        )
    )
);


add_action('admin_menu', 'salong_add_page_metabox');

// 创建METABOX面板
function salong_add_page_metabox() {
    global $page_meta_box;
    add_meta_box($page_meta_box['id'], $page_meta_box['title'], 'salong_show_page_metabox', $page_meta_box['page'], $page_meta_box['context'], $page_meta_box['priority']);
}

// 回调函数来显示字段
function salong_show_page_metabox() {
    global $page_meta_box, $post;

    echo '<input type="hidden" name="salong_page_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($page_meta_box['fields'] as $field) {
        // 获取当前META参数
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr';
        if($field['type'] == 'title'){ echo ' class="title"'; }
        echo '><th style="width:16%"><label for="', $field['id'], '">', $field['name'], '</label></th><td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:100%" />', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:100%">', $meta ? $meta : $field['std'], '</textarea>', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'title':
                echo $field['desc'];
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}


add_action('save_post', 'salong_save_page_metabox');

// 保存META数据
function salong_save_page_metabox($post_id) {
    global $page_meta_box;

    // 临时验证
    if (!wp_verify_nonce($_POST['salong_page_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // 自动保存
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // 权限
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($page_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

/*****************************************************
页面选项end
*****************************************************/



/*****************************************************
画廊选项
*****************************************************/

$gallery_meta_box           = array(
    'id'            => 'gallery_metabox',
    'title'         => __('画廊选项','salong'),
    'page'          => 'gallery',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields'        => array(
        array(
            'name'  => __('SEO文章描述','salong'),
            'desc'  => __('留空则获取摘要或截取文章第一段一定的字数。','salong'),
            'id'    => 'description',
            'type'  => 'textarea',
            'std'   => ''
        ),
        array(
            'name'  => __('SEO文章关键词','salong'),
            'desc'  => __('自定义文章关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
            'id'    => 'tags',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('缩略图地址','salong'),
            'desc'  => __('建议大小比例：400*225','salong'),
            'id'    => 'thumb',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('幻灯片设置','salong'),
            'desc'  => __('幻灯片的相关设置！','salong'),
            'type'  => 'title',
            'std'   => ''
        ),
        array(
            'name'  => __('图片设置','salong'),
            'desc'  => __('输入图片链接，一行一个，如果需要为图片添加说明，写成：https://salongweb.com/1.jpg|萨龙网络，同样是一行一个。注意：“|”为英文输入法下的竖线。','salong'),
            'id'    => 'slides',
            'type'  => 'textarea',
            'std'   => ''
        ),
        array(
            'name'    => __('幻灯片切换效果','salong'),
            'desc'    => __('不勾选默认是左右切换。','salong'),
            'id'      => 'gallery_effect',
            'type'    => 'select',
            'options' => array(
                array('name' => __('左右','salong'), 'value' => 'around'),
                array('name' => __('渐变','salong'), 'value' => 'gradient')
            ),
            'std'   => 'around'
        ),
        array(
            'name'  => __('禁止幻灯片循环','salong'),
            'desc'  => __('默认是循环播放，勾选则禁止循环播放。','salong'),
            'id'    => 'gallery_loop',
            'type'  => 'checkbox'
        ),
        array(
            'name'  => __('显示说明','salong'),
            'desc'  => __('默认不显示，鼠标经过才显示图片的说明，勾选，将直接显示说明。','salong'),
            'id'    => 'gallery_show',
            'type'  => 'checkbox'
        ),
        array(
            'name'  => __('画廊平铺','salong'),
            'desc'  => __('默认是幻灯片形式，勾选则平铺所有图片，同时不需要幻灯片播放设置。','salong'),
            'id'    => 'gallery_list',
            'type'  => 'checkbox'
        ),
        array(
            'name'  => __('图片大小','salong'),
            'desc'  => __('默认大小为400*225，值的格式为：400|225，注意：“|”为英文输入法下的符号。','salong'),
            'id'    => 'gallery_size',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('画廊来源','salong'),
            'desc'  => __('画廊来源的相关设置！','salong'),
            'type'  => 'title',
            'std'   => ''
        ),
        array(
            'name'  => __('网站名称','salong'),
            'id'    => 'from_name',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('网站链接','salong'),
            'id'    => 'from_link',
            'type'  => 'text',
            'std'   => ''
        ),
    )
);


add_action('admin_menu', 'salong_add_gallery_metabox');

// 创建METABOX面板
function salong_add_gallery_metabox() {
    global $gallery_meta_box;
    add_meta_box($gallery_meta_box['id'], $gallery_meta_box['title'], 'salong_show_gallery_metabox', $gallery_meta_box['page'], $gallery_meta_box['context'], $gallery_meta_box['priority']);
}

// 回调函数来显示字段
function salong_show_gallery_metabox() {
    global $gallery_meta_box, $post;

    echo '<input type="hidden" name="salong_gallery_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';
    echo '<style type="text/css">.form-table tr.title th,.form-table tr.title td,.form-wrap tr.title label{color:#f00}.form-table tr.title{border-bottom:1px #eee solid}</style>';

    foreach ($gallery_meta_box['fields'] as $field) {
        // 获取当前META参数
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr';
        if($field['type'] == 'title'){ echo ' class="title"'; }
        echo '><th style="width:16%"><label for="', $field['id'], '">', $field['name'], '</label></th><td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:100%" />', '<br />', '<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:100%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', '<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option value="', $option['value'], '" ', $meta == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
                }
                echo '</select>';
                break;
//            case 'radio':
//                foreach ($field['options'] as $option) {
//                    echo '<label style="margin-right: 12px"><input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'].'</label>';
//                }
//                echo '<span style="color: #666;font-size: 12px;display: inline-block;vertical-align: middle;">'.$field['desc'].'</span>';
//                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />','<span style="color: #666;font-size: 12px;display: inline-block;vertical-align: middle;">'.$field['desc'].'</span>';
                break;
            case 'title':
                echo $field['desc'];
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}


add_action('save_post', 'salong_save_gallery_metabox');

// 保存META数据
function salong_save_gallery_metabox($post_id) {
    global $gallery_meta_box;

    // 临时验证
    if (!wp_verify_nonce($_POST['salong_gallery_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // 自动保存
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // 权限
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($gallery_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

/*****************************************************
画廊选项end
*****************************************************/



/*****************************************************
视频选项
*****************************************************/

$video_meta_box           = array(
    'id'            => 'video_metabox',
    'title'         => __('视频选项','salong'),
    'page'          => 'video',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields'        => array(
        array(
            'name'  => __('SEO文章描述','salong'),
            'desc'  => __('留空则获取摘要或截取文章第一段一定的字数。','salong'),
            'id'    => 'description',
            'type'  => 'textarea',
            'std'   => ''
        ),
        array(
            'name'  => __('SEO文章关键词','salong'),
            'desc'  => __('自定义文章关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
            'id'    => 'tags',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('缩略图地址','salong'),
            'desc'  => __('建议大小比例：400*225','salong'),
            'id'    => 'thumb',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('Video++视频设置','salong'),
            'desc'  => __('使用Video++播放视频，如果是优酷视频就把视频ID输入到“优酷视频ID”中，这样可以直接获取优酷视频缩略图，其它视频就把链接输入到“视频地址”中。<br>优酷视频链接为：http://v.youku.com/v_show/id_XNDk5MDc0MDU2.html，其中“XNDk5MDc0MDU2”为优酷视频ID，<br>视频地址（http://www.tudou.com/programs/view/tM_vZCQy2uM/）或者资源地址（http://7xi4ig.com2.z0.glb.qiniucdn.com/shapuolang_ts.mp4）直接输入到视频地址中。','salong'),
            'id'    => 'video++',
            'type'  => 'title'
        ),
        array(
            'name'  => __('优酷视频ID','salong'),
            'id'    => 'youku_id',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('视频地址','salong'),
            'id'    => 'video_url',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('视频封面地址','salong'),
            'id'    => 'video_img',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('视频高度','salong'),
            'id'    => 'video_height',
            'desc'  => __('输入数字，不输入默认高度为675px，宽度是100%（默认为1200px），正好可以完全显示优酷视频，所以对于其它不同高度的视频就设置下高度。','salong'),
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('视频来源','salong'),
            'desc'  => __('视频来源的相关设置！','salong'),
            'type'  => 'title',
            'std'   => ''
        ),
        array(
            'name'  => __('网站名称','salong'),
            'id'    => 'from_name',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('网站链接','salong'),
            'id'    => 'from_link',
            'type'  => 'text',
            'std'   => ''
        ),
    )
);


add_action('admin_menu', 'salong_add_video_metabox');

// 创建METABOX面板
function salong_add_video_metabox() {
    global $video_meta_box;
    add_meta_box($video_meta_box['id'], $video_meta_box['title'], 'salong_show_video_metabox', $video_meta_box['page'], $video_meta_box['context'], $video_meta_box['priority']);
}

// 回调函数来显示字段
function salong_show_video_metabox() {
    global $video_meta_box, $post;

    echo '<input type="hidden" name="salong_video_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';
    echo '<style type="text/css">.form-table tr.title th,.form-table tr.title td,.form-wrap tr.title label{color:#f00}.form-table tr.title{border-bottom:1px #eee solid}</style>';

    foreach ($video_meta_box['fields'] as $field) {
        // 获取当前META参数
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr';
        if($field['type'] == 'title'){ echo ' class="title"'; }
        echo '><th style="width:16%"><label for="', $field['id'], '">', $field['name'], '</label></th><td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:100%" />', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:100%">', $meta ? $meta : $field['std'], '</textarea>', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'title':
                echo $field['desc'];
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}


add_action('save_post', 'salong_save_video_metabox');

// 保存META数据
function salong_save_video_metabox($post_id) {
    global $video_meta_box;

    // 临时验证
    if (!wp_verify_nonce($_POST['salong_video_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // 自动保存
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // 权限
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($video_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

/*****************************************************
视频选项end
*****************************************************/



/*****************************************************
产品选项
*****************************************************/

$product_meta_box   = array(
    'id'            => 'product_metabox',
    'title'         => __('产品选项','salong'),
    'page'          => 'product',
    'context'       => 'normal',
    'priority'      => 'high',
    'fields'        => array(
        array(
            'name'  => __('SEO文章描述','salong'),
            'desc'  => __('留空则获取摘要或截取文章第一段一定的字数。','salong'),
            'id'    => 'description',
            'type'  => 'textarea',
            'std'   => ''
        ),
        array(
            'name'  => __('SEO文章关键词','salong'),
            'desc'  => __('自定义文章关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
            'id'    => 'tags',
            'type'  => 'text',
            'std'   => ''
        ),
        array(
            'name'  => __('缩略图地址','salong'),
            'desc'  => __('建议大小比例：400*225','salong'),
            'id'    => 'thumb',
            'type'  => 'text',
            'std'   => ''
        ),
    )
);


add_action('admin_menu', 'salong_add_product_metabox');

// 创建METABOX面板
function salong_add_product_metabox() {
    global $product_meta_box;
    add_meta_box($product_meta_box['id'], $product_meta_box['title'], 'salong_show_product_metabox', $product_meta_box['page'], $product_meta_box['context'], $product_meta_box['priority']);
}

// 回调函数来显示字段
function salong_show_product_metabox() {
    global $product_meta_box, $post;

    echo '<input type="hidden" name="salong_product_metabox_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';
    echo '<style type="text/css">.form-table tr.title th,.form-table tr.title td,.form-wrap tr.title label{color:#f00}.form-table tr.title{border-bottom:1px #eee solid}</style>';

    foreach ($product_meta_box['fields'] as $field) {
        // 获取当前META参数
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr';
        if($field['type'] == 'title'){ echo ' class="title"'; }
        echo '><th style="width:16%"><label for="', $field['id'], '">', $field['name'], '</label></th><td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:100%" />', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:100%">', $meta ? $meta : $field['std'], '</textarea>', '<br />','<span style="color: #666;font-size: 12px;margin-top: 6px;display: inline-block">'.$field['desc'].'</span>';
                break;
            case 'title':
                echo $field['desc'];
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}


add_action('save_post', 'salong_save_product_metabox');

// 保存META数据
function salong_save_product_metabox($post_id) {
    global $product_meta_box;

    // 临时验证
    if (!wp_verify_nonce($_POST['salong_product_metabox_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // 自动保存
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // 权限
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($product_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

/*****************************************************
产品选项end
*****************************************************/


