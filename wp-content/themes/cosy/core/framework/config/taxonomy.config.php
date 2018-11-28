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
  	@Date:   2017-09-05 19:26:39
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-10-20 12:59:32

*/

if ( ! defined( 'ABSPATH' ) ) { die; }

$options = array();

$options[]   = array(
	'id'       => '_custom_category_options',
	'taxonomy' => 'category',
	'fields'   => array(

		array(
			'id'    => 'cat_layout',
			'type'  => 'image_select',
			'title' => '布局样式',
		    'options' => array(
				'card'   => get_stylesheet_directory_uri() . '/static/images/set/card.png',
				'card-4'   => get_stylesheet_directory_uri() . '/static/images/set/card4.png',
				'full' => get_stylesheet_directory_uri() . '/static/images/set/default.png',
		    ),
		    'default'   => 'card',
		    'attributes'   => array(
				'data-depend-id' => 'cat_layout',
			),
    	),
		array(
    		'id'      => 'cat_name_show',
    		'type'    => 'switcher',
    		'title'   => '分类名称显示',
    		'help'    => '开启后将显示文章所属分类。',
    		'default' => true,
    		'dependency'=> array(
				'cat_layout',
				'any',
				'card,card-4'
			)
    	),
    	array(
    		'id'      => 'cat_excerpt_show',
    		'type'    => 'switcher',
    		'title'   => '摘要显示',
    		'help'    => '开启后将显示文章摘要。',
    		'default' => true,
    		'dependency'=> array(
				'cat_layout',
				'any',
				'card,card-4'
			)
    	),
    	array(
    		'id'      => 'cat_meta_show',
    		'type'    => 'switcher',
    		'title'   => 'META 显示',
    		'help'    => '开启后将显示META 信息。',
    		'default' => true,
    		'dependency'=> array(
				'cat_layout',
				'any',
				'card,card-4'
			)
    	),

	    	array(
				'id'    => 'cat_insert_ad_card',
				'type'    => 'radio',
				'title' => '广告',
			    'options' => array(
					'code'    => '广告代码',
					'image'   => '图片广告',
					'default' => '关闭',
			    ),
			    'default'   => 'default',
			    'help'		=> '开启之后将在文章列表中 1、2 插入广告',
			    'dependency'  => array( 'cat_layout', 'any', 'card' ),
	    	),
	  		array(
	  			'id'         => 'cat_insert_ad_card_text',
	  			'type'       => 'switcher',
	  			'title'      => '显示“广告”标识',
	  			'default'    => true,
	  			'help'		 => '开启之后将在图片上显示广告标识',
	  			'dependency'  => array( 'cat_insert_ad_card_image|cat_layout', '==|any', 'true|card' ),
	  		),

	  		array(
	  			'id'      => 'cat_insert_ad_card_position',
	  			'type'    => 'number',
	  			'title'   => '广告插入位置',
	  			'desc'    => '设置广告插入的位置，填写数字，例如 3 则插入到第3篇文章之前',
	  			'default' => '3',
	  			'dependency'  => array( 'cat_insert_ad_card_image|cat_layout', '==|any', 'true|card' ),
	  		),
	  		array(
	  			'id'    => 'cat_insert_ad_card_url',
	  			'type'  => 'text',
	  			'title' => '广告链接',
	  			'dependency'  => array( 'cat_insert_ad_card_image|cat_layout', '==|any', 'true|card' ),
	  		),

	  		array(
				'id'        => 'cat_insert_ad_card_img',
				'type'      => 'image',
				'title'     => '广告图片(PC端)',
				'desc'      => '上传广告图片',
				'add_title' => '选择广告图片',
				'dependency'  => array( 'cat_insert_ad_card_image|cat_layout', '==|any', 'true|card' ),
			),
	  		array(
				'id'        => 'cat_insert_ad_card_img_mobile',
				'type'      => 'image',
				'title'     => '广告图片(移动端)',
				'desc'      => '上传广告图片',
				'add_title' => '选择广告图片',
				'dependency'  => array( 'cat_insert_ad_card_image|cat_layout', '==|any', 'true|card' ),
			),
	  		array(
	  			'id'    => 'cat_insert_ad_card_html_pc',
	  			'type'  => 'textarea',
	  			'title' => '广告代码（PC端）',
	  			'desc'	=> '填写HTML代码',
	  			'dependency'  => array( 'cat_insert_ad_card_code|cat_layout', '==|any', 'true|card' ),
	  		),
	  		array(
	  			'id'    => 'cat_insert_ad_card_html_mobile',
	  			'type'  => 'textarea',
	  			'title' => '广告代码（移动端）',
	  			'desc'	=> '填写HTML代码',
	  			'dependency'  => array( 'cat_insert_ad_card_code|cat_layout', '==|any', 'true|card' ),
	  		),


	    	array(
				'id'    => 'cat_insert_ad_full',
				'type'    => 'radio',
				'title' => '广告',
			    'options' => array(
					'code'    => '广告代码',
					'image'   => '图片广告',
					'default' => '关闭',
			    ),
			    'default'   => 'default',
			    'help'		=> '开启之后将在文章列表中 3 插入广告',
			    'dependency'  => array( 'cat_layout', 'any', 'full' ),
	    	),

	  		array(
	  			'id'         => 'cat_insert_ad_full_text',
	  			'type'       => 'switcher',
	  			'title'      => '显示“广告”标识',
	  			'default'    => true,
	  			'help'		 => '开启之后将在图片上显示广告标识',
	  			'dependency'  => array( 'cat_insert_ad_full_image|cat_layout', '==|any', 'true|full' ),
	  		),

	  		array(
	  			'id'      => 'cat_insert_ad_full_position',
	  			'type'    => 'number',
	  			'title'   => '广告插入位置',
	  			'desc'    => '设置广告插入的位置，填写数字，例如 3 则插入到第3篇文章之前',
	  			'default' => '3',
	  			'dependency'  => array( 'cat_insert_ad_full_image|cat_layout', '==|any', 'true|full' ),
	  		),
	  		array(
	  			'id'    => 'cat_insert_ad_full_url',
	  			'type'  => 'text',
	  			'title' => '广告链接',
	  			'dependency'  => array( 'cat_insert_ad_full_image|cat_layout', '==|any', 'true|full' ),
	  		),

	  		array(
				'id'        => 'cat_insert_ad_full_img',
				'type'      => 'image',
				'title'     => '广告图片（PC端）',
				'desc'      => '上传广告图片',
				'add_title' => '选择广告图片',
				'dependency'  => array( 'cat_insert_ad_full_image|cat_layout', '==|any', 'true|full' ),
			),
	  		array(
				'id'        => 'cat_insert_ad_full_img_mobile',
				'type'      => 'image',
				'title'     => '广告图片（移动端）',
				'desc'      => '上传广告图片',
				'add_title' => '选择广告图片',
				'dependency'  => array( 'cat_insert_ad_full_image|cat_layout', '==|any', 'true|full' ),
			),
			array(
				'id'    => 'cat_insert_ad_full_html_pc',
				'type'  => 'textarea',
				'title' => '广告代码（PC端）',
				'desc'	=> '填写HTML代码',
				'dependency'  => array( 'cat_insert_ad_full_code|cat_layout', '==|any', 'true|full' ),
			),
			array(
				'id'    => 'cat_insert_ad_full_html_mobile',
				'type'  => 'textarea',
				'title' => '广告代码（移动端）',
				'desc'	=> '填写HTML代码',
				'dependency'  => array( 'cat_insert_ad_full_code|cat_layout', '==|any', 'true|full' ),
			),

    	array(
    		'id'      => 'sticky_posts',
    		'type'    => 'switcher',
    		'title'   => '置顶模块',
    		'help'    => '开启后将显示最多3篇置顶文章在该分类目录。',
    		'default' => false
    	),
		array(
			'id'    => 'sticky_style',
			'type'  => 'image_select',
			'title' => '置顶模块样式',
		    'options' => array(
				'default'   => get_stylesheet_directory_uri() . '/static/images/set/top2.png',
				'full' => get_stylesheet_directory_uri() . '/static/images/set/top1.png',
		    ),
		    'default'   => 'default',
		    'dependency'   => array( 'sticky_posts', '==', true ),
    	),
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
);

$options[]   = array(
	'id'       => '_custom_tag_options',
	'taxonomy' => 'post_tag',
	'fields'   => array(

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
);

$options[]   = array(
	'id'       => '_custom_special_options',
	'taxonomy' => 'special',
	'fields'   => array(
  		array(
			'id'        => 'special_thum',
			'type'      => 'image',
			'title'     => '标签封面',
			'desc'      => '上传当前标签的封面图片',
			'add_title' => '选择图片',
		),
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
);

CSFramework_Taxonomy::instance( $options );