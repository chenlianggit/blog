<?php
global $salong;
/*
 * 添加自定义的公告集文章类型
 */
if (in_array( 'bulletin', $salong[ 'switch_post_type'])) {
add_action('init', 'create_redvine_bulletin');
function create_redvine_bulletin(){
    $labels = array(
        'name'                => _x('公告', 'salong'),
        'singular_name'       => _x('公告', 'salong'),
        'add_new'             => _x('添加公告', 'salong'),
        'add_new_item'        => __('添加公告', 'salong'),
        'edit_item'           => __('编辑公告', 'salong'),
        'new_item'            => __('新的公告', 'salong'),
        'view_item'           => __('预览公告', 'salong'),
        'search_items'        => __('搜索公告', 'salong'),
        'not_found'           =>  __('您还没有发布公告', 'salong'),
        'not_found_in_trash'  => __('回收站中没有公告', 'salong'), 
        'parent_item_colon'   => ''
    );
    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'show_ui'           => true, 
        'query_var'         => true,
        'rewrite'           => true,
        'capability_type'   => 'post',
        'hierarchical'      => false,
        'menu_position'     => 5,
        'menu_icon'         => 'dashicons-microphone',
        'supports'          => array('title','editor','author'),
        'show_in_nav_menus'	=> true
    ); 
    register_post_type('bulletin',$args);

}
}
/******************************************************************
自定义画廊文章类型
******************************************************************/
if (in_array( 'gallery', $salong[ 'switch_post_type'])) {
add_action( 'init', 'create_redvine_gallery' );
function create_redvine_gallery() {
    $labels = array( 
        'name'                => __( '画廊', 'salong' ),
        'singular_name'       => __( '画廊', 'salong' ),
        'add_new'             => __( '添加画廊', 'salong' ),
        'add_new_item'        => __( '添加画廊', 'salong' ),
        'edit_item'           => __( '编辑画廊', 'salong' ),
        'new_item'            => __( '新的画廊', 'salong' ),
        'view_item'           => __( '查看画廊', 'salong' ),
        'search_items'        => __( '搜索画廊', 'salong' ),
        'not_found'           => __( '没有找到画廊', 'salong' ),
        'not_found_in_trash'  => __( '在回收站没有找到画廊', 'salong' ),
        'parent_item_colon'   => __( '父级画廊', 'salong' ),
        'menu_name'           => __( '画廊', 'salong' ),
    );

    $args = array( 
        'labels'              => $labels,
        'hierarchical'        => false,
        'supports'            => array('title','editor','author','thumbnail','custom-fields','comments'),
        'taxonomies'          => array( 'gallery-cat','gallery-tag'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 4,
        'menu_icon'           => 'dashicons-camera',
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => true,
        'capability_type'     => 'post'
    );

    register_post_type( 'gallery', $args );
    register_post_status(
        'gallery_status',
        array(
            'label'                     => __('画廊状态', 'salong'),
            'public'                    => false,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => ''
        )
    );
}


//创建分类法

add_action( 'init', 'create_redvine_gallery_taxonomy', 0 );
function create_redvine_gallery_taxonomy() {
    //添加分类分类法
    $labels = array(
        'name'              => __( '画廊分类', 'salong' ),
        'singular_name'     => __( '画廊分类', 'salong' ),
        'search_items'      =>  __( '搜索画廊分类','salong' ),
        'all_items'         => __( '所有画廊分类','salong' ),
        'parent_item'       => __( '父级画廊分类','salong' ),
        'parent_item_colon' => __( '父级画廊分类：','salong' ),
        'edit_item'         => __( '编辑画廊分类','salong' ), 
        'update_item'       => __( '更新画廊分类','salong' ),
        'add_new_item'      => __( '添加画廊分类','salong' ),
        'new_item_name'     => __( '新的画廊分类','salong' ),
        'menu_name'         => __( '画廊分类','salong' ),
    );     

    //注册分类法
    register_taxonomy('gallery-cat',array('gallery'), array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'gallery-category' )
    ));

    //添加标签分类法
    $labels = array(
        'name'              => __( '画廊标签', 'salong' ),
        'singular_name'     => __( '画廊标签', 'salong' ),
        'search_items'      =>  __( '搜索画廊标签','salong' ),
        'all_items'         => __( '所有画廊标签','salong' ),
        'parent_item'       => __( '父有画廊标签','salong' ),
        'parent_item_colon' => __( '父级画廊标签：','salong' ),
        'edit_item'         => __( '编辑画廊标签','salong' ), 
        'update_item'       => __( '更新画廊标签','salong' ),
        'add_new_item'      => __( '添加画廊标签','salong' ),
        'new_item_name'     => __( '新的画廊标签','salong' ),
        'menu_name'         => __( '画廊标签','salong' ),
    );
    register_taxonomy('gallery-tag',array('gallery'), array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'gallery-tag' ),
    ));
}
}

/******************************************************************
自定义视频文章类型
******************************************************************/
if (in_array( 'video', $salong[ 'switch_post_type'])) {
add_action( 'init', 'create_redvine_video' );
function create_redvine_video() {
    $labels = array( 
        'name'                => __( '视频', 'salong' ),
        'singular_name'       => __( '视频', 'salong' ),
        'add_new'             => __( '添加视频', 'salong' ),
        'add_new_item'        => __( '添加视频', 'salong' ),
        'edit_item'           => __( '编辑视频', 'salong' ),
        'new_item'            => __( '新的视频', 'salong' ),
        'view_item'           => __( '查看视频', 'salong' ),
        'search_items'        => __( '搜索视频', 'salong' ),
        'not_found'           => __( '没有找到视频', 'salong' ),
        'not_found_in_trash'  => __( '在回收站没有找到视频', 'salong' ),
        'parent_item_colon'   => __( '父级视频', 'salong' ),
        'menu_name'           => __( '视频', 'salong' ),
    );

    $args = array( 
        'labels'              => $labels,
        'hierarchical'        => false,
        'supports'            => array('title','editor','author','thumbnail','custom-fields','comments'),
        'taxonomies'          => array( 'video-cat','video-tag'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 4,
        'menu_icon'           => 'dashicons-video-alt2',
        'show_in_nav_menus'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => true,
        'capability_type'     => 'post'
    );

    register_post_type( 'video', $args );
    register_post_status(
        'video_status',
        array(
            'label'                     => __('视频状态', 'salong'),
            'public'                    => false,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => ''
        )
    );
}


//创建分类法

add_action( 'init', 'create_redvine_video_taxonomy', 0 );
function create_redvine_video_taxonomy() {
    //添加分类分类法
    $labels = array(
        'name'              => __( '视频分类', 'salong' ),
        'singular_name'     => __( '视频分类', 'salong' ),
        'search_items'      => __( '搜索视频分类','salong' ),
        'all_items'         => __( '所有视频分类','salong' ),
        'parent_item'       => __( '父级视频分类','salong' ),
        'parent_item_colon' => __( '父级视频分类：','salong' ),
        'edit_item'         => __( '编辑视频分类','salong' ), 
        'update_item'       => __( '更新视频分类','salong' ),
        'add_new_item'      => __( '添加视频分类','salong' ),
        'new_item_name'     => __( '新的视频分类','salong' ),
        'menu_name'         => __( '视频分类','salong' ),
    );     

    //注册分类法
    register_taxonomy('video-cat',array('video'), array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'video-category' )
    ));

    //添加标签分类法
    $labels = array(
        'name'              => __( '视频标签', 'salong' ),
        'singular_name'     => __( '视频标签', 'salong' ),
        'search_items'      =>  __( '搜索视频标签','salong' ),
        'all_items'         => __( '所有视频标签','salong' ),
        'parent_item'       => __( '父有视频标签','salong' ),
        'parent_item_colon' => __( '父级视频标签：','salong' ),
        'edit_item'         => __( '编辑视频标签','salong' ), 
        'update_item'       => __( '更新视频标签','salong' ),
        'add_new_item'      => __( '添加视频标签','salong' ),
        'new_item_name'     => __( '新的视频标签','salong' ),
        'menu_name'         => __( '视频标签','salong' ),
    );
    register_taxonomy('video-tag',array('video'), array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'video-tag' ),
    ));
}
}
