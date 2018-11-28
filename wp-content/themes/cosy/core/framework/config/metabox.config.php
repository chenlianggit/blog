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
  	@Date:   2017-09-02 15:29:13
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-10 12:20:43

*/
if ( ! defined( 'ABSPATH' ) ) { die; } 

$options = array();

$options[]    = array(
	'id'        => 'post_extend',
	'title'     => '文章扩展',
	'post_type' => 'post',
	'context'   => 'normal',
	'priority'  => 'high',
	'sections'  => array(
		array(
			'name'  => 'post_push',
			'title' => '推送设置',
			'icon'  => 'fa fa-plus-square',
     		'fields' => array(
     			array(
					'type'    => 'subheading',
					'content' => '轮播区',
				),
     			array(
					'id'    => 'push_slide',
					'type'  => 'switcher',
					'title' => '推送到轮播区',
				),
				array(
					'id'    => 'push_slide_img',
					'type'  => 'image',
					'title' => '自定义图片',
				),

				array(
					'type'    => 'subheading',
					'content' => '文章推送区',

				),
				array(
					'id'    => 'push_slide_below',
					'type'  => 'switcher',
					'title' => '文章推送',
					'desc'	  => '推送到轮播区下方',
				),
				array(
					'id'    => 'push_slide_below_img',
					'type'  => 'image',
					'title' => '自定义图片',
				),
     		),
    	),
    	array(
			'name'  => 'post_seo',
			'title' => 'SEO 设置',
			'icon'  => 'fa fa-magic',
     		'fields' => array(
     			array(
					'id'    => 'seo_custom_title', // this is must be unique
					'type'  => 'text',
					'title' => '自定义标题',
					'help'  => '留空则调用默认全局SEO设置'
     			),
     			array(
					'id'    => 'seo_custom_keywords', // this is must be unique
					'type'  => 'text',
					'title' => '自定义关键词',
					'help'  => '留空则调用默认全局SEO设置'
     			),
     			array(
					'id'    => 'seo_custom_desc', // this is must be unique
					'type'  => 'textarea',
					'title' => '自定义描述',
					'help'  => '留空则调用默认全局SEO设置'
     			),
     		),
    	),

    	array(
			'name'  => 'post_layout_box',
			'title' => '布局设置',
			'icon'  => 'fa fa-th-large',
     		'fields' => array(
     			array(
					'id'    => 'post_layout',
					'type'  => 'image_select',
					'title' => '文章页样式',
				    'options' => array(
						'one'   => get_stylesheet_directory_uri() . '/static/images/set/post1.png',
						'two'   => get_stylesheet_directory_uri() . '/static/images/set/post2.png',
						'three' => get_stylesheet_directory_uri() . '/static/images/set/post3.png',
						'four'  => get_stylesheet_directory_uri() . '/static/images/set/post4.png',
						'five'  => get_stylesheet_directory_uri() . '/static/images/set/post5.png',
						'six'   => get_stylesheet_directory_uri() . '/static/images/set/post6.png',
				    ),
				    'default'   => 'one',
				    'radio'     => true,
				    'attributes'   => array(
						'data-depend-id' => 'post_layout',
					),
		    	),
		    	array(
					'id'        => 'head_img',
					'type'      => 'image',
					'title'     => '头图设置',
					'desc'      => '上传一张显示在文章顶部的图片',
					'add_title' => '选择头图',
					'dependency'=> array(
						'post_layout',
						'any',
						'one,two,three,four'
					)
				),
				array(
					'id'         => 'post_layout_gallery',
					'type'       => 'switcher',
					'title'      => '相册模式',
					'dependency' => array(
						'post_layout',
						'any',
						'five'
					)
				),

				array(
					'id'          => 'post_gallery',
					'type'        => 'gallery',
					'title'       => '相册',
					'add_title'   => '添加相册',
					'edit_title'  => '编辑相册',
					'clear_title' => '删除相册',
					'dependency'  => array(
						'post_layout_gallery|post_layout',
						'==|any',
						'true|five'
					),
				),

				array(
					'id'        => 'post_video_url',
					'type'      => 'text',
					'title'     => '视频地址',
					'help'      => '视频播放页的完整地址',
					'dependency'=> array(
						'post_layout',
						'any',
						'six'
					)
				),	
				array(
					'type'    => 'notice',
					'class'   => 'warning',
					'content' => '注意: 此功能需配合 <a href="javascript:open_smartideo_install_window();">Smartideo</a> 插件才能生效',
					'dependency'=> array(
						'post_layout',
						'any',
						'six'
					)
				),		
				
     		),
     		
    	),
 

    )

);

if( cs_get_option('share_bigger_img') ){

	$options[0]['sections'][] = array(
		'name'  => 'post_bigger_img_box',
		'title' => 'bigger 封面',
		'icon'  => 'fa fa-th-large',
			'fields' => array(
				array(
					'id'        => 'bigger_head_img',
					'type'      => 'image',
					'title'     => 'bigger封面头图',
					'help'      => '上传一张显示在bigger封面顶部的图片',
					'add_title' => '选择头图'
				),
				array(
					'id'    => 'bigger_title',
					'type'  => 'text',
					'title' => 'bigger封面标题',
					'help'  => '留空则调用默认调用文章标题'
				),
				array(
					'id'    => 'bigger_desc', 
					'type'  => 'textarea',
					'title' => 'bigger封面描述',
					'help'  => '留空则调用默认调用文章摘要'
				),
				
		)
	);
}

$options[]    = array(
	'id'        => 'page_extend',
	'title'     => '页面扩展',
	'post_type' => 'page',
	'context'   => 'normal',
	'priority'  => 'high',
	'sections'  => array(

    	array(
			'name'  => 'page_topic',
			'title' => '专题设置',
			'icon'  => 'fa fa-star',
     		'fields' => array(
			  		array(
						'id'              => 'topic_ids_group',
						'type'            => 'group',
						'title'           => '专题置顶',
						'button_title'    => '添加',
						'accordion_title' => '专题标签',
						'fields'          => array(
							array(
								'id'    => 'tag_id',
								'type'  => 'number',
								'title' => '标签ID',
								'help'	=> '填写一个专题的标签ID'
							),
						),
					),
					array(
					'id'    => 'topic_layout',
					'type'  => 'image_select',
					'title' => '置顶布局',
				    'options' => array(
						'full'   => get_stylesheet_directory_uri() . '/static/images/set/top1.png',
						'center' => get_stylesheet_directory_uri() . '/static/images/set/top2.png',
				    ),
				    'default'   => 'center',
				    'radio'     => true,
		    	),
     		),
    	),
	),

);
CSFramework_Metabox::instance( $options );