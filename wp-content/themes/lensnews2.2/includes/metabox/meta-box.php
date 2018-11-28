<?php
/**
*Author: Ashuwp
*Author url: http://www.ashuwp.com
*Version: 5.8
**/


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


/**
*
* 页面类型 SEO 选项
*
**/
/*****Meta Box********/
$seo_meta_conf = array(
    'title'   => __('SEO 选项','salong'),
    'id'      => 'seo_box',
    'page'    => array('page','product'),
    'context' => 'normal',
    'priority'=> 'low'
);

$seo_meta = array();

$seo_meta[] = array(
    'name' => __('标题','salong'),
    'desc' => __('自定义标题。','salong'),
    'id'   => 'seo_title',
    'type' => 'text',
    'std'  => ''
);

$seo_meta[] = array(
    'name' => __('关键词','salong'),
    'desc' => __('自定义关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
    'id'   => 'tags',
    'type' => 'text',
    'std'  => ''
);

$seo_meta[] = array(
    'name' => __('描述','salong'),
    'desc' => __('自定义描述，留空则获取摘要或截取文章第一段一定的字数。','salong'),
    'id'   => 'description',
    'type' => 'textarea',
    'std'  => ''
);

$seo_box = new ashuwp_postmeta_feild($seo_meta, $seo_meta_conf);


/**
*
* 默认文章 TABS
*
**/

$post_tab_conf = array(
    'title'   => __('文章选项','salong'),
    'id'      => 'post_tab_box',
    'page'    => array('post'),
    'context' => 'normal',
    'priority'=> 'low',
    'tab'     => true
);

$post_tab_meta = array();

/**第一个 TABS**/
$post_tab_meta[] = array(
    'name' => __('基础设置','salong'),
    'id'   => 'post_tab_first',
    'type' => 'open'
);

$post_tab_meta[] = array(
    'name'        => __('自定义缩略图','salong'),
    'desc'        => __('建议大小比例：400*225，注：获取缩略图的顺序为自定义缩略图，特色图像、文章第一张图、默认图片。','salong'),
    'button_text' => __('上传','salong'),
    'id'          => 'thumb',
    'type'        => 'upload',
    'std'         => ''
);

$post_tab_meta[] = array(
    'name'        => __('设置本文为无边栏','salong'),
    'desc'        => __('勾选后此文章将没有边栏，宽度和页面一样。','salong'),
    'id'          => 'no_sidebar',
    'type'        => 'checkbox',
    'subtype' => array(
        'on'  => __('启用','salong'),
    ),
    'std'         => ''
);

$post_tab_meta[] = array(
    'name'        => __('显示文章目录','salong'),
    'desc'        => __('勾选后此文章右侧将显示导航。','salong'),
    'id'          => 'catalogue',
    'type'        => 'checkbox',
    'subtype' => array(
        'on'  => __('显示','salong')
    ),
    'std'         => ''
);

$post_tab_meta[] = array(
    'type' => 'close'
);

/**第二个 TABS**/
$post_tab_meta[] = array(
    'name' => __('SEO 选项','salong'),
    'id'   => 'post_tab_second',
    'type' => 'open'
);

$post_tab_meta[] = array(
    'name' => __('标题','salong'),
    'desc' => __('自定义标题。','salong'),
    'id'   => 'seo_title',
    'type' => 'text',
    'std'  => ''
);

$post_tab_meta[] = array(
    'name' => __('关键词','salong'),
    'desc' => __('自定义关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
    'id'   => 'tags',
    'type' => 'text',
    'std'  => ''
);

$post_tab_meta[] = array(
    'name' => __('描述','salong'),
    'desc' => __('自定义描述，留空则获取摘要或截取文章第一段一定的字数。','salong'),
    'id'   => 'description',
    'type' => 'textarea',
    'std'  => ''
);

$post_tab_meta[] = array(
    'type' => 'close'
);


/**第三个 TABS**/
$post_tab_meta[] = array(
    'name' => __('文章来源','salong'),
    'id'   => 'post_tab_third',
    'type' => 'open'
);

$post_tab_meta[] = array(
    'name' => __('网站名称','salong'),
    'desc' => __('输入文章来源的网站名称。','salong'),
    'id'   => 'from_name',
    'type' => 'text',
    'std'  => ''
);

$post_tab_meta[] = array(
    'name' => __('网站链接','salong'),
    'desc' => __('输入文章来源的网站链接。','salong'),
    'id'   => 'from_link',
    'type' => 'text',
    'std'  => ''
);

$post_tab_meta[] = array(
    'type' => 'close'
);

$post_tab_box = new ashuwp_postmeta_feild($post_tab_meta, $post_tab_conf);

/**
*
* 画廊文章 TABS
*
**/

$gallery_tab_conf = array(
    'title'   => __('画廊选项','salong'),
    'id'      => 'gallery_tab_box',
    'page'    => array('gallery'),
    'context' => 'normal',
    'priority'=> 'low',
    'tab'     => true
);

$gallery_tab_meta = array();

/**第一个 TABS**/
$gallery_tab_meta[] = array(
    'name' => __('基础设置','salong'),
    'id'   => 'gallery_tab_first',
    'type' => 'open'
);

$gallery_tab_meta[] = array(
    'name'        => __('自定义缩略图','salong'),
    'desc'        => __('建议大小比例：400*225，注：获取缩略图的顺序为自定义缩略图，特色图像、文章第一张图、默认图片。','salong'),
    'button_text' => __('上传','salong'),
    'id'          => 'thumb',
    'type'        => 'upload',
    'std'         => ''
);

$gallery_tab_meta[] = array(
    'type' => 'close'
);

/**第二个 TABS**/
$gallery_tab_meta[] = array(
    'name' => __('幻灯片图片','salong'),
    'id'   => 'gallery_tab_second',
    'type' => 'open'
);

$gallery_tab_meta[] = array(
    'name' => __('图片设置','salong'),
    'id'   => 'slides',
    'std'  => '',
    'subtype' => array(
        array(
            'name' => __('描述','salong'),
            'desc' => __('输入图片描述，不输入则使用标题做为描述。','salong'),
            'id'   => 'img_title',
            'type' => 'textarea',
            'std'  => ''
        ),
        array(
            'name'        => __('图片','salong'),
            'desc'        => __('图片，也可以直接输入图片地址。注：图片宽度为1200，高度不限但是必须统一。','salong'),
            'id'          => 'img_url',
            'button_text' => __('上传','salong'),
            'type'        => 'upload',
            'std'         => ''
        ),
    ),
    'multiple' => true,
    'type'     => 'group'
);

$gallery_tab_meta[] = array(
    'type' => 'close'
);

/**第三个 TABS**/
$gallery_tab_meta[] = array(
    'name' => __('幻灯片设置','salong'),
    'id'   => 'gallery_tab_third',
    'type' => 'open'
);

$gallery_tab_meta[] = array(
    'name'          => __('幻灯片切换效果','salong'),
    'desc'          => __('默认是左右切换。','salong'),
    'id'            => 'gallery_effect',
    'type'          => 'radio',
    'subtype'       => array(
        'around'    => __('左右','salong'),
        'gradient'  => __('渐变','salong')
    ),
    'std'           => 'around'
);

$gallery_tab_meta[] = array(
    'name'      => __('幻灯片循环','salong'),
    'desc'      => __('默认是循环播放，勾选则禁止循环播放。','salong'),
    'id'        => 'gallery_loop',
    'type'      => 'checkbox',
    'subtype'   => array(
        'off'  => __('禁止','salong')
    ),
    'std'       => ''
);

$gallery_tab_meta[] = array(
    'name'      => __('显示说明','salong'),
    'desc'      => __('默认不显示，鼠标经过才显示图片的说明，勾选，将直接显示说明。','salong'),
    'id'        => 'gallery_show',
    'type'      => 'checkbox',
    'subtype'   => array(
        'show'  => __('显示','salong')
    ),
    'std'       => ''
);

$gallery_tab_meta[] = array(
    'name'      => __('画廊平铺','salong'),
    'desc'      => __('默认是幻灯片形式，勾选则平铺所有图片，同时不需要幻灯片播放设置。','salong'),
    'id'        => 'gallery_list',
    'type'      => 'checkbox',
    'subtype'   => array(
        'show'  => __('平铺','salong')
    ),
    'std'       => ''
);

$gallery_tab_meta[] = array(
    'name'      => __('平铺后图片大小','salong'),
    'desc'      => __('默认大小为400*225，值的格式为：400|225，注意：“|”为英文输入法下的符号。','salong'),
    'id'        => 'gallery_size',
    'type'      => 'text',
    'std'       => ''
);

$gallery_tab_meta[] = array(
    'type' => 'close'
);

/**第四个 TABS**/
$gallery_tab_meta[] = array(
    'name' => __('SEO 选项','salong'),
    'id'   => 'gallery_tab_fourth',
    'type' => 'open'
);

$gallery_tab_meta[] = array(
    'name' => __('标题','salong'),
    'desc' => __('自定义标题。','salong'),
    'id'   => 'seo_title',
    'type' => 'text',
    'std'  => ''
);

$gallery_tab_meta[] = array(
    'name' => __('关键词','salong'),
    'desc' => __('自定义关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
    'id'   => 'tags',
    'type' => 'text',
    'std'  => ''
);

$gallery_tab_meta[] = array(
    'name' => __('描述','salong'),
    'desc' => __('自定义描述，留空则获取摘要或截取文章第一段一定的字数。','salong'),
    'id'   => 'description',
    'type' => 'textarea',
    'std'  => ''
);

$gallery_tab_meta[] = array(
    'type' => 'close'
);

/**第五个 TABS**/
$gallery_tab_meta[] = array(
    'name' => __('文章来源','salong'),
    'id'   => 'gallery_tab_fifth',
    'type' => 'open'
);

$gallery_tab_meta[] = array(
    'name' => __('网站名称','salong'),
    'desc' => __('输入文章来源的网站名称。','salong'),
    'id'   => 'from_name',
    'type' => 'text',
    'std'  => ''
);

$gallery_tab_meta[] = array(
    'name' => __('网站链接','salong'),
    'desc' => __('输入文章来源的网站链接。','salong'),
    'id'   => 'from_link',
    'type' => 'text',
    'std'  => ''
);

$gallery_tab_meta[] = array(
    'type' => 'close'
);

$gallery_tab_box = new ashuwp_postmeta_feild($gallery_tab_meta, $gallery_tab_conf);

/**
*
* 视频文章 TABS
*
**/

$video_tab_conf = array(
    'title'   => __('视频选项','salong'),
    'id'      => 'video_tab_box',
    'page'    => array('video'),
    'context' => 'normal',
    'priority'=> 'low',
    'tab'     => true
);

$video_tab_meta = array();

/**第一个 TABS**/
$video_tab_meta[] = array(
    'name' => __('基础设置','salong'),
    'id'   => 'video_tab_first',
    'type' => 'open'
);

$video_tab_meta[] = array(
    'name'        => __('自定义缩略图','salong'),
    'desc'        => __('建议大小比例：400*225，注：获取缩略图的顺序为自定义缩略图，特色图像、文章第一张图、默认图片。','salong'),
    'button_text' => __('上传','salong'),
    'id'          => 'thumb',
    'type'        => 'upload',
    'std'         => ''
);

$video_tab_meta[] = array(
    'type' => 'close'
);

/**第二个 TABS**/
$video_tab_meta[] = array(
    'name' => __('视频设置','salong'),
    'id'   => 'video_tab_second',
    'type' => 'open'
);

$video_tab_meta[] = array(
    'name'  => __('Video++视频设置','salong'),
    'desc'  => __('使用Video++播放视频，如果是优酷视频就把视频ID输入到“优酷视频ID”中，这样可以直接获取优酷视频缩略图，其它视频就把链接输入到“视频地址”中。<br>优酷视频链接为：http://v.youku.com/v_show/id_XNDk5MDc0MDU2.html，其中“XNDk5MDc0MDU2”为优酷视频ID，<br>视频地址（http://www.tudou.com/programs/view/tM_vZCQy2uM/）或者资源地址（http://7xi4ig.com2.z0.glb.qiniucdn.com/shapuolang_ts.mp4）直接输入到视频地址中。','salong'),
    'id'    => 'video++',
    'type'  => 'title',
    'std'   => ''
);

$video_tab_meta[] = array(
    'name'  => __('优酷视频ID','salong'),
    'id'    => 'youku_id',
    'type'  => 'text',
    'std'   => ''
);

$video_tab_meta[] = array(
    'name'  => __('视频地址','salong'),
    'id'    => 'video_url',
    'type'  => 'text',
    'std'   => ''
);

$video_tab_meta[] = array(
    'name'        => __('视频封面地址','salong'),
    'desc'        => __('建议大小比例：1200*675，注：当『视频地址』为.mp4类似的视频时可以使用。','salong'),
    'button_text' => __('上传','salong'),
    'id'          => 'video_img',
    'type'        => 'upload',
    'std'         => ''
);

$video_tab_meta[] = array(
    'name'  => __('视频高度','salong'),
    'id'    => 'video_height',
    'desc'  => __('输入数字，不输入默认高度为675px，宽度是100%（默认为1200px），正好可以完全显示优酷视频，所以对于其它不同高度的视频就设置下高度。','salong'),
    'type'  => 'text',
    'std'   => ''
);

$video_tab_meta[] = array(
    'type' => 'close'
);

/**第三个 TABS**/
$video_tab_meta[] = array(
    'name' => __('SEO 选项','salong'),
    'id'   => 'video_tab_third',
    'type' => 'open'
);

$video_tab_meta[] = array(
    'name' => __('标题','salong'),
    'desc' => __('自定义标题。','salong'),
    'id'   => 'seo_title',
    'type' => 'text',
    'std'  => ''
);

$video_tab_meta[] = array(
    'name' => __('关键词','salong'),
    'desc' => __('自定义关键词，多个使用英文逗号隔开，不输入则获取标签做为关键词。','salong'),
    'id'   => 'tags',
    'type' => 'text',
    'std'  => ''
);

$video_tab_meta[] = array(
    'name' => __('描述','salong'),
    'desc' => __('自定义描述，留空则获取摘要或截取文章第一段一定的字数。','salong'),
    'id'   => 'description',
    'type' => 'textarea',
    'std'  => ''
);

$video_tab_meta[] = array(
    'type' => 'close'
);

/**第四个 TABS**/
$video_tab_meta[] = array(
    'name' => __('文章来源','salong'),
    'id'   => 'video_tab_fourth',
    'type' => 'open'
);

$video_tab_meta[] = array(
    'name' => __('网站名称','salong'),
    'desc' => __('输入文章来源的网站名称。','salong'),
    'id'   => 'from_name',
    'type' => 'text',
    'std'  => ''
);

$video_tab_meta[] = array(
    'name' => __('网站链接','salong'),
    'desc' => __('输入文章来源的网站链接。','salong'),
    'id'   => 'from_link',
    'type' => 'text',
    'std'  => ''
);

$video_tab_meta[] = array(
    'type' => 'close'
);

$video_tab_box = new ashuwp_postmeta_feild($video_tab_meta, $video_tab_conf);



/**
*
* 分类 META BOX
*
**/
/***** 所有分类字段 ******/

$category_meta = array();
$category_cof = array('gallery-cat');

$category_meta[] = array(
    'name' => __('分类缩略图比例','salong'),
    'desc' => __('输入分类缩略图比例，格式：100|100。','salong'),
    'id'   => 'category_size',
    'type' => 'text',
    'std'  => ''
);

$category_feild = new ashuwp_termmeta_feild($category_meta, $category_cof);