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
  	@Date:   2017-09-02 11:54:43
  	@Last Modified by:   Dami
  	@Last Modified time: 2017-11-13 13:28:12

*/

if ( ! defined( 'ABSPATH' ) ) { die; }

function get_public_ip(){
	$public_ip = false;
	$response = wp_remote_get( 'http://ip.chinaz.com/getip.aspx' );
	if ( is_array( $response ) && ! is_wp_error( $response ) ) {
		$result = str_replace( 'document.write("{ip:\'', '', $response['body'] );
		$arr = explode( '\'', $result );
		$public_ip = $arr[0];
	}
	
	return $public_ip;
}

$settings = array(
	'menu_title'      => '主题设置',
	'menu_type'       => 'menu', // menu, submenu, options, theme, etc.
	'menu_parent'     => 'themes.php',
	'menu_slug'       => 'theme_options',
	'ajax_save'       => false,
	'show_reset_all'  => false,
	'framework_title' => 'Cosy 主题配置 <small>by Dami & Suxing & Nice</small>',
);

// 获取所有分类
$cats = get_categories( 
	array(
	    'hide_empty' => 0
	) 
);
$cats_options = array();
if( is_array( $cats ) ){
	foreach ($cats as $key => $value) {
		$cats_options[$value->cat_ID] = $value->cat_name;
	}
}


$options = array();

$options[] = array(
	'name'  => 'layout',
	'title' => '布局设置',
	'icon'  => 'fa fa-th-large',

  	'fields' => array(

  		array(
			'type'    => 'subheading',
			'content' => '头部布局',
		),
 
   		array(
			'id'    => 'header_layout',
			'type'    => 'radio',
			'title' => '头部宽度',
		    'options' => array(
				'full'   => '全屏',
				'center' => '默认',
		    ),
		    'default'   => 'center',
    	),

    	array(
			'id'    => 'mobile_header_layout',
			'type'  => 'image_select',
			'title' => '移动端头部样式',
		    'options' => array(
				'mobile-style01'   => get_stylesheet_directory_uri() . '/static/images/set/mobile-header01.png',
				'mobile-style02' => get_stylesheet_directory_uri() . '/static/images/set/mobile-header02.png',
		    ),
		    'default'   => 'mobile-style01',
    	),

		array(
			'type'    => 'subheading',
			'content' => '首页布局',
		),

		// array(
		// 	'id'      => 'slide_switch',
		// 	'type'    => 'switcher',
		// 	'title'   => '轮播幻灯片',
		// 	'help'    => '开启后将在首页展示轮播幻灯片',
		// 	'default' => true
		// ),
		
		array(
			'id'      => 'slide_region',
			'type'    => 'radio',
			'title'   => '轮播区域',
			'help'    => '选择首页轮播区域的风格样式',
			'options' => array(
				'off'      => '关闭',
				'magazine' => '杂志风格',
				'silide'   => '幻灯风格'
			),
			'default' => 'magazine'

		),

		
 
   		array(
			'id'    => 'slide_layout',
			'type'  => 'image_select',
			'title' => '轮播区域样式',
		    'options' => array(
				'full'   => get_stylesheet_directory_uri() . '/static/images/set/banner01.png',
				'center' => get_stylesheet_directory_uri() . '/static/images/set/banner02.png',
		    ),
		    'default'   => 'center',
		    'dependency'   => array( 'slide_region_silide', '==', true ),
    	),

    	array(
			'id'         => 'slide_below_card',
			'type'       => 'switcher',
			'title'      => '文章推送区域',
			'desc'    	 => '位于首页轮播下方',
			'default'    => false,
			'dependency' => array( 'slide_region_silide', '==', true ),
		),

    	array(
			'id'    => 'slide_below_card_layout',
			'type'    => 'radio',
			'title' => '推送区域宽度',
		    'options' => array(
				'full'   => '全屏',
				'center' => '默认',
		    ),
		    'default'   => 'center',
		    'desc'    => '文章推送区域（首页轮播下方）的宽度',
		    'dependency' => array( 'slide_below_card', '==', true ),
    	),
    	
		array(
			'id'      => 'slide_below_card_num',
			'type'    => 'number',
			'title'   => '推送文章数',
			'desc'    => '文章推送区域（首页轮播下方）的文章显示数量',
			'default' => '6',
			'dependency' => array( 'slide_below_card', '==', true ),
		),

		

    	array(
			'id'    => 'magazine_layout',
			'type'  => 'image_select',
			'title' => '杂志区域样式',
		    'options' => array(
				'full'   => get_stylesheet_directory_uri() . '/static/images/set/magazine01.png',
				'center' => get_stylesheet_directory_uri() . '/static/images/set/magazine02.png',
		    ),
		    'default'   => 'center',
		    'dependency'   => array( 'slide_region_magazine', '==', true ),
    	),

    	array(
			'id'    => 'index_single_layout',
			'type'  => 'image_select',
			'title' => '文章列表样式',
			'desc'  => '首页文章列表的显示样式',
		    'options' => array(
				'card'   => get_stylesheet_directory_uri() . '/static/images/set/card.png',
				'card-4'   => get_stylesheet_directory_uri() . '/static/images/set/card4.png',
				'full' => get_stylesheet_directory_uri() . '/static/images/set/default.png',
		    ),
		    'default'   => 'full',
		    'attributes'   => array(
				'data-depend-id' => 'index_single_layout',
			),
    	),

    	array(
			'id'         => 'index_list_hide_item',
			'type'       => 'checkbox',
			'title'      => '隐藏选项',
			'options'    => array(
				'none' => '不隐藏',
				'cat'  => '分类信息',
				'des'  => '文章摘要',
				'meta' => '时间、浏览量、评论数、喜欢等数据',
			),
			'default'    => 'none',
			'dependency'  => array( 'index_single_layout', 'any', 'card,card-4' ),
		),

    	array(
    		'id'         => 'index_insert_topic',
    		'type'       => 'switcher',
    		'title'      => '插入专题列表',
    		'default'    => false,
    		'help'		 => '开启之后将在文章列表中插入专题列表',
    	),

    	array(
			'id'         => 'index_insert_topic_height',
			'type'       => 'number',
			'title'      => '专题高度',
			'default'    => 375,
			'help'       => '列表中专题的显示高度',
			'dependency' => array( 'index_insert_topic', '==', 'true' ),
    	),

  		array(
			'id'              => 'index_topic_group',
			'type'            => 'group',
			'title'           => '专题标签',
			'button_title'    => '添加',
			'accordion_title' => '专题标签',
			'fields'          => array(
				array(
					'id'      => 'position',
					'type'    => 'number',
					'title'   => '专题插入位置',
					'desc'    => '设置专题插入的位置，填写数字，例如 3 则插入到第3篇文章之前',
					'default' => '3',
				),
				array(
					'id'    => 'tag_id',
					'type'  => 'text',
					'title' => '标签ID',
					'desc'	=> '填写专题的标签ID，多个用英文逗号隔开，最多显示3个专题'
				),
			),
			'dependency'   => array( 'index_insert_topic', '==', 'true' ),
		),


    	array(
			'id'    => 'index_insert_ad_card',
			'type'    => 'radio',
			'title' => '广告',
		    'options' => array(
				'code'    => '广告代码',
				'image'   => '图片广告',
				'default' => '关闭',
		    ),
		    'default'   => 'default',
		    'help'		 => '开启之后将在文章列表中 1、2 插入广告',
		    'desc'    => '选择在文章中插入广告的方式',
		    'dependency'  => array( 'index_single_layout', 'any', 'card,card-4' ),
    	),

  		array(
  			'id'         => 'index_insert_ad_card_text',
  			'type'       => 'switcher',
  			'title'      => '显示“广告”标识',
  			'default'    => true,
  			'help'		 => '开启之后将在图片上显示广告标识',
  			'dependency'  => array( 'index_insert_ad_card_image|index_single_layout', '==|any', 'true|card,card-4' ),
  		),

  		array(
  			'id'      => 'index_insert_ad_card_position',
  			'type'    => 'number',
  			'title'   => '广告插入位置',
  			'desc'    => '设置广告插入的位置，填写数字，例如 3 则插入到第3篇文章之前',
  			'default' => '3',
  			'dependency'  => array( 'index_insert_ad_card_image|index_single_layout', '==|any', 'true|card,card-4' ),
  		),
  		array(
  			'id'    => 'index_insert_ad_card_url',
  			'type'  => 'text',
  			'title' => '广告链接',
  			'dependency'  => array( 'index_insert_ad_card_image|index_single_layout', '==|any', 'true|card,card-4' ),
  		),

  		array(
			'id'        => 'index_insert_ad_card_img',
			'type'      => 'image',
			'title'     => '广告图片(PC端)',
			'desc'      => '上传广告图片',
			'add_title' => '选择广告图片',
			'dependency'  => array( 'index_insert_ad_card_image|index_single_layout', '==|any', 'true|card,card-4' ),
		),
  		array(
			'id'        => 'index_insert_ad_card_img_mobile',
			'type'      => 'image',
			'title'     => '广告图片(移动端)',
			'desc'      => '上传广告图片',
			'add_title' => '选择广告图片',
			'dependency'  => array( 'index_insert_ad_card_image|index_single_layout', '==|any', 'true|card,card-4' ),
		),
		array(
			'id'    => 'index_insert_ad_card_html_pc',
			'type'  => 'textarea',
			'title' => '广告代码（PC端）',
			'desc'	=> '填写HTML代码',
			'dependency'  => array( 'index_insert_ad_card_code|index_single_layout', '==|any', 'true|card,card-4' ),
		),
		array(
			'id'    => 'index_insert_ad_card_html_mobile',
			'type'  => 'textarea',
			'title' => '广告代码（移动端）',
			'desc'	=> '填写HTML代码',
			'dependency'  => array( 'index_insert_ad_card_code|index_single_layout', '==|any', 'true|card,card-4' ),
		),


  		array(
			'id'    => 'index_insert_ad_full',
			'type'    => 'radio',
			'title' => '广告',
		    'options' => array(
				'code'    => '广告代码',
				'image'   => '图片广告',
				'default' => '关闭',
		    ),
		    'default'   => 'default',
		    'help'		 => '开启之后将在文章列表中 3 插入广告',
		    'desc'    => '选择在文章中插入广告的方式',
		    'dependency'  => array( 'index_single_layout', 'any', 'full' ),
    	),

  		array(
  			'id'         => 'index_insert_ad_full_text',
  			'type'       => 'switcher',
  			'title'      => '显示“广告”标识',
  			'default'    => true,
  			'help'		 => '开启之后将在图片上显示广告标识',
  			'dependency'  => array( 'index_insert_ad_full_image|index_single_layout', '==|any', 'true|full' ),
  		),

  		array(
  			'id'      => 'index_insert_ad_full_position',
  			'type'    => 'number',
  			'title'   => '广告插入位置',
  			'desc'    => '设置广告插入的位置，填写数字，例如 3 则插入到第3篇文章之前',
  			'default' => '3',
  			'dependency'  => array( 'index_insert_ad_full_image|index_single_layout', '==|any', 'true|full' ),
  		),
  		array(
  			'id'    => 'index_insert_ad_full_url',
  			'type'  => 'text',
  			'title' => '广告链接',
  			'dependency'  => array( 'index_insert_ad_full_image|index_single_layout', '==|any', 'true|full' ),
  		),

  		array(
			'id'        => 'index_insert_ad_full_img',
			'type'      => 'image',
			'title'     => '广告图片（PC端）',
			'desc'      => '上传广告图片',
			'add_title' => '选择广告图片',
			'dependency'  => array( 'index_insert_ad_full_image|index_single_layout', '==|any', 'true|full' ),
		),
  		array(
			'id'        => 'index_insert_ad_full_img_mobile',
			'type'      => 'image',
			'title'     => '广告图片（移动端）',
			'desc'      => '上传广告图片',
			'add_title' => '选择广告图片',
			'dependency'  => array( 'index_insert_ad_full_image|index_single_layout', '==|any', 'true|full' ),
		),
  		array(
  			'id'    => 'index_insert_ad_full_html_pc',
  			'type'  => 'textarea',
  			'title' => '广告代码（PC端）',
  			'desc'	=> '填写HTML代码',
  			'dependency'  => array( 'index_insert_ad_full_code|index_single_layout', '==|any', 'true|full' ),
  		),
  		array(
  			'id'    => 'index_insert_ad_full_html_mobile',
  			'type'  => 'textarea',
  			'title' => '广告代码（移动端）',
  			'desc'	=> '填写HTML代码',
  			'dependency'  => array( 'index_insert_ad_full_code|index_single_layout', '==|any', 'true|full' ),
  		),

		array(
			'id'      => 'masking_cats',
			'type'    => 'checkbox',
			'title'   => '最新文章不显示的分类',
			'options' => $cats_options,
			'help'    => '设置此项后，首页最新文章列表内将不显示此处选中的分类下的文章。',
			'default' => '-1'
		),

    	array(
			'type'    => 'subheading',
			'content' => '标签页布局',
		),

		array(
			'id'    => 'tag_layout',
			'type'  => 'image_select',
			'title' => '标签页文章列表样式',
		    'options' => array(
				'card'   => get_stylesheet_directory_uri() . '/static/images/set/card.png',
				'full' => get_stylesheet_directory_uri() . '/static/images/set/default.png',
		    ),
		    'default'   => 'full',
    	),

    	array(
			'type'    => 'subheading',
			'content' => '搜索页布局',
		),

		array(
			'id'    => 'search_layout',
			'type'  => 'image_select',
			'title' => '搜索页文章列表样式',
		    'options' => array(
				'card'   => get_stylesheet_directory_uri() . '/static/images/set/card.png',
				'full' => get_stylesheet_directory_uri() . '/static/images/set/default.png',
		    ),
		    'default'   => 'full',
    	),

    	array(
			'type'    => 'subheading',
			'content' => '作者页布局',
		),

		array(
			'id'    => 'author_layout',
			'type'  => 'image_select',
			'title' => '作者页文章列表样式',
		    'options' => array(
				'card'   => get_stylesheet_directory_uri() . '/static/images/set/card.png',
				'full' => get_stylesheet_directory_uri() . '/static/images/set/default.png',
		    ),
		    'default'   => 'full',
    	),

    	array(
			'type'    => 'subheading',
			'content' => '文章页布局',
		),

    	array(
			'id'    => 'single_insert_ad',
			'type'    => 'radio',
			'title' => '广告',
		    'options' => array(
				'code'    => '广告代码',
				'image'   => '图片广告',
				'default' => '关闭',
		    ),
		    'default'   => 'default',
		    'desc'    => '选择在文章中插入广告的方式',
    	),

  		array(
  			'id'         => 'single_insert_ad_text',
  			'type'       => 'switcher',
  			'title'      => '显示“广告”标识',
  			'default'    => true,
  			'help'		 => '开启之后将在图片上显示广告标识',
  			'dependency'   => array( 'single_insert_ad_image', '==', 'true' ),
  		),

  		array(
  			'id'    => 'single_insert_ad_url',
  			'type'  => 'text',
  			'title' => '广告链接',
  			'dependency'   => array( 'single_insert_ad_image', '==', 'true' ),
  		),

  		array(
			'id'        => 'single_insert_ad_img',
			'type'      => 'image',
			'title'     => '广告图片(PC端)',
			'desc'      => '上传广告图片',
			'add_title' => '选择广告图片',
			'dependency'   => array( 'single_insert_ad_image', '==', 'true' ),
		),
  		array(
			'id'        => 'single_insert_ad_img_mobile',
			'type'      => 'image',
			'title'     => '广告图片(移动端)',
			'desc'      => '上传广告图片',
			'add_title' => '选择广告图片',
			'dependency'   => array( 'single_insert_ad_image', '==', 'true' ),
		),

		array(
			'id'    => 'single_insert_ad_html_pc',
			'type'  => 'textarea',
			'title' => '广告代码（PC端）',
			'desc'	=> '填写HTML代码',
			'dependency'   => array( 'single_insert_ad_code', '==', 'true' ),
		),
		array(
			'id'    => 'single_insert_ad_html_mobile',
			'type'  => 'textarea',
			'title' => '广告代码（移动端）',
			'desc'	=> '填写HTML代码',
			'dependency'   => array( 'single_insert_ad_code', '==', 'true' ),
		),

	),
);

$options[] = array(
	'name'  => 'logo',
	'title' => '标志设置',
	'icon'  => 'fa fa-flag',

  	'fields' => array(

  		array(
			'id'        => 'site_logo',
			'type'      => 'image',
			'title'     => '网站LOGO',
			'desc'      => '上传你网站的LOGO',
			'add_title' => '选择LOGO',
		),

  		array(
			'id'        => 'site_logo_mobile',
			'type'      => 'image',
			'title'     => '网站LOGO',
			'desc'      => '上传你网站的LOGO(移动端)',
			'add_title' => '选择LOGO',
		),

		array(
			'id'        => 'site_favicon',
			'type'      => 'image',
			'title'     => '网站favicon',
			'desc'      => '上传你网站的favicon.ico',
			'add_title' => '选择favicon',
		),

		array(
			'id'        => 'site_default_img',
			'type'      => 'image',
			'title'     => '默认缩略图',
			'desc'      => '上传你网站默认的缩略图',
			'add_title' => '选择图片',
		),

		array(
			'id'        => 'site_default_comment_img',
			'type'      => 'image',
			'title'     => '评论默认头像',
			'desc'      => '上传你网站默认评论头像',
			'add_title' => '选择图片',
			'help'      => '此功能本地测试无效！！！会导致头像无法显示！！！'
		),



	),
);


$options[] = array(
	'name'  => 'slide',
	'title' => '轮播设置',
	'icon'  => 'fa fa-film',

  	'fields' => array(

  		array(
			'id'      => 'slide_num',
			'type'    => 'number',
			'title'   => '轮播数量',
			'desc'    => '设置轮播内容数量',
			'default' => '5',
			'help'    => '当轮播区域为杂志风格时，此处数值无效！'
		),

		array(
			'id'      => 'priority',
			'type'    => 'switcher',
			'title'   => '优先显示',
			'help'    => '开启后将优先显示此处设置的轮播内容，否则优先显示推送内容。',
			'default' => true
		),

  		array(
			'id'              => 'slide_group',
			'type'            => 'group',
			'title'           => '轮播内容',
			'button_title'    => '添加',
			'accordion_title' => '轮播项目',
			'fields'          => array(
				array(
					'id'    => 'slide_group_title',
					'type'  => 'text',
					'title' => '标题',
				),
				array(
					'id'    => 'slide_group_cat',
					'type'  => 'text',
					'title' => '分类',
				),
				array(
					'id'    => 'slide_group_link',
					'type'  => 'text',
					'title' => '链接',
				),
				array(
					'id'    => 'slide_group_img',
					'type'  => 'image',
					'title' => '图片',
				),
			),
		),

		array(
			'type'    => 'notice',
			'class'   => 'info',
			'content' => '<b>逻辑说明:</b> 此处设置的内容将和文章推送的内容合并之后显示。如：轮播数量为 5 ，此处设置轮播内容 3 组，推送若干。在 优先显示 开启的情况下，将先显示此处设置的 3 组内容，余下的显示文章推送的内容。',
		),

	),
);


$options[] = array(
	'name'  => 'ajax_load',
	'title' => '动态加载',
	'icon'  => 'fa fa-spinner',

  	'fields' => array(

  		array(
			'type'    => 'subheading',
			'content' => '首页',
		),

		array(
			'id'      => 'home_ajax_load',
			'type'    => 'switcher',
			'title'   => '首页 AJAX动态 加载',
			'help'    => '开启后首页将使用 ajax 加载文章列表',
			'default' => true
		),

		array(
			'type'       => 'subheading',
			'content'    => '首页显示自定义分类TAB',
			'dependency' => array(
				'home_ajax_load',
				'==',
				'true'
			),
		),

		array(
			'id'              => 'home_tab_cats',
			'type'            => 'group',
			'title'           => '分类列表',
			'button_title'    => '添加分类',
			'accordion_title' => '新分类',
			'dependency'      => array(
				'home_ajax_load',
				'==',
				'true'
			),
			'fields'          => array(
				array(
					'id'      => 'home_tab_cat',
					'type'    => 'select',
					'title'   => '分类',
					'options' => $cats_options,
				),
				array(
					'id'    => 'home_tab_name',
					'type'  => 'text',
					'title' => 'TAB显示名称',
				),
			),
		),

		array(
			'type'    => 'subheading',
			'content' => '其他页面',
		),

		array(
			'id'      => 'other_ajax_load',
			'type'    => 'switcher',
			'title'   => '其他页面 AJAX动态 加载',
			'desc'    => '开启后分类、标签、搜索将使用 ajax 加载文章列表',
			'default' => true
		),

	),
);

$options[] = array(
	'name'  => 'duang',
	'title' => '扩展设置',
	'icon'  => 'fa fa-puzzle-piece',

  	'fields' => array(

  		array(
			'type'    => 'subheading',
			'content' => '图片暗箱',
		),

		array(
			'id'      => 'image_popup',
			'type'    => 'radio',
			'title'   => '暗箱模式',
			'help'    => '开启后，Duang的一下图片就粗来了',
			'options' => array(
				'disable' => '关闭',
				'image'   => '单图模式',
				'gallery' => '相册模式',
			),
			'default' => 'disable'
		),

  		array(
			'type'    => 'subheading',
			'content' => '功能控制',
		),

		array(
			'id'      => 'breadcrumbs',
			'type'    => 'switcher',
			'title'   => '面包屑',
			'help'    => '开启后将在文章样式125以及页面中显示面包屑导航',
			'default' => true
		),

		array(
			'id'      => 'duang_all',
			'type'    => 'switcher',
			'title'   => '加载特效',
			'desc'    => '开启后将在全站显示加载特效小圆点',
			'default' => true
		),

		array(
			'type'    => 'subheading',
			'content' => '微信、QQ内分享信息自定义设置',
		),

		array(
			'id'      => 'share_title', 
			'type'    => 'text',
			'title'   => '标题',
			'default' => get_bloginfo('name'),
		),

		array(
			'id'      => 'share_summary', 
			'type'    => 'text',
			'title'   => '描述',
			'default' => get_bloginfo('description'),
		),

		array(
			'id'    => 'share_img',
			'type'  => 'image',
			'title' => '图片',
		),

		array(
			'type'    => 'notice',
			'class'   => 'warning',
			'content' => '如果你想要在微信中直接分享，请按以下步骤操作：<br> 1、公众号通过微信认证 <br>2、添加域名 '.get_bloginfo('url').' 到 JS安全域名中 <br>3、添加服务器IP <code>'.get_public_ip().'</code> 到 IP白名单中 <br>4、填写 AppID 和 AppSecret <br>否则你只能通过QQ分享链接到微信，或者直接在QQ中分享',
		),

		array(
			'id'      => 'share_appid', 
			'type'    => 'text',
			'title'   => 'AppId',
			'default' => '',
		),

		array(
			'id'      => 'share_appsecret', 
			'type'    => 'text',
			'title'   => 'AppSecret',
			'default' => '',
		),

		array(
			'type'    => 'subheading',
			'content' => '分享 - bigger封面',
		),

		array(
			'id'      => 'share_bigger_img',
			'type'    => 'switcher',
			'title'   => '分享bigger封面',
			'help'    => '开启后将根据文章内容生成bigger封面图，并随用户的分享动作分享至第三方网站',
			'default' => true
		),

		array(
			'id'        => 'bigger_logo',
			'type'      => 'image',
			'title'     => 'LOGO',
			'help'      => '上传一张显示在bigger封面底部的LOGO',
			'add_title' => '选择LOGO',
			'dependency' => array(
				'share_bigger_img',
				'==',
				'true'
			),
		),

		array(
			'id'        => 'bigger_desc',
			'type'      => 'text',
			'title'     => '描述',
			'help'      => '显示在LOGO下方的一句话描述',
			'dependency' => array(
				'share_bigger_img',
				'==',
				'true'
			),
		),

		array(
			'id'      => 'share_bigger_img_qrcode',
			'type'    => 'switcher',
			'title'   => '右下角二维码',
			'help'    => '开启后将再bigger封面图的右下角现在当前文章的二维码',
			'default' => false,
			'dependency' => array(
				'share_bigger_img',
				'==',
				'true'
			),
		),	

	),
);

$options[] = array(
	'name'  => 'speed',
	'title' => 'SEO优化',
	'icon'  => 'fa fa-magic',

  	'fields' => array(

  		array(
			'type'    => 'subheading',
			'content' => 'SEO',
		),

		array(
			'id'      => 'site_seo_switch',
			'type'    => 'switcher',
			'title'   => '主题自带SEO',
			'help'    => '开启后将使用主题自带SEO设置',
			'default' => true
		),

		array(
			'type'    => 'subheading',
			'content' => '全局SEO功能设定',
		),

		array(
			'id'      => 'seo_auto_des',
			'type'    => 'switcher',
			'title'   => '文章页描述',
			'help'    => '开启后将自动截取文章内容作为文章description标签',
			'default' => true
		),

		array(
		  'id'    => 'seo_auto_des_num', // this is must be unique
		  'type'  => 'text',
		  'title' => '自动截取字节数',
		  'default' => '120',
		  'dependency'   => array( 'seo_auto_des', '==', true ),
		),

		array(
			'id'      => 'seo_auto_keywords',
			'type'    => 'switcher',
			'title'   => '文章页关键词',
			'help'    => '开启后将自动截取文章内容作为文章description标签',
			'default' => true
		),

		array(
			'id'      => 'seo_sep', // this is must be unique
			'type'    => 'text',
			'title'   => 'Title后缀分隔符',
			'default' => ' - ',
		),

		array(
			'type'    => 'subheading',
			'content' => '首页SEO设置',
		),

		array(
			'id'    => 'seo_home_title', // this is must be unique
			'type'  => 'text',
			'title' => '首页标题',
			'help'  => '关键词使用英文逗号隔开',
		),

		array(
			'id'    => 'seo_home_keywords', // this is must be unique
			'type'  => 'text',
			'title' => '首页关键词',
		),

		array(
			'id'    => 'seo_home_desc', // this is must be unique
			'type'  => 'textarea',
			'title' => '首页描述',
		),


	),
);

$options[] = array(
	'name'  => 'rocket',
	'title' => '优化加速',
	'icon'  => 'fa fa-rocket',

  	'fields' => array(

  		array(
			'type'    => 'subheading',
			'content' => '清理优化',
		),

		array(
			'id'      => 'display_adminbar',
			'type'    => 'switcher',
			'title'   => '管理工具栏',
			'help'    => '全局移除工具栏（admin bar），所有人包括管理员都看不到，并且个人页面关于工具栏的选项也失效。',
			'default' => false
		),

		array(
			'id'      => 'remove_head_links',
			'type'    => 'switcher',
			'title'   => '移除Head无关紧要代码',
			'help'    => '移除 WordPress Header 中无关紧要的代码，保持整洁，提高安全性。',
			'default' => false
		),

		array(
			'id'      => 'locale',
			'type'    => 'switcher',
			'title'   => '前台不加载语言包',
			'help'    => '前台不加载语言包，可以提高0.1-0.5秒。',
			'default' => false
		),





  		array(
			'type'    => 'subheading',
			'content' => '功能屏蔽',
		),

  		array(
  			'id'      => 'diable_revision',
  			'type'    => 'switcher',
  			'title'   => '屏蔽日志修订功能',
  			'help'    => '屏蔽日志修订功能，提高数据库效率。',
  			'default' => false
  		),

  		array(
  			'id'      => 'disable_trackbacks',
  			'type'    => 'switcher',
  			'title'   => 'Trackbacks',
  			'help'    => '彻底关闭 Trackbacks，和垃圾留言说拜拜。',
  			'default' => false
  		),

  		array(
  			'id'      => 'disable_xml_rpc',
  			'type'    => 'switcher',
  			'title'   => 'XML-RPC',
  			'help'    => '如果你无需通过 APP 客户端发布日志，建议关闭 XML-RPC 功能。',
  			'default' => false
  		),

  		array(
  			'id'      => 'disable_rest_api',
  			'type'    => 'switcher',
  			'title'   => 'REST API',
  			'help'    => '如果你的博客没有客户端，建议屏蔽 REST API 功能。',
  			'default' => false
  		),

  		array(
  			'id'      => 'disable_autoembed',
  			'type'    => 'switcher',
  			'title'   => 'Auto Embeds',
  			'help'    => 'Auto Embeds 基本不支持国内网站，建议禁用 Auto Embeds 功能，加快页面解析速度。开启之后将导致部分插件不可用，例如视频插件smartvideo。',
  			'default' => false
  		),

  		array(
  			'id'      => 'disable_post_embed',
  			'type'    => 'switcher',
  			'title'   => 'Post Embeds',
  			'help'    => '屏蔽文章 Embed 功能。',
  			'default' => false
  		),




  		array(
			'type'    => 'subheading',
			'content' => '功能增强',
		),

		array(
			'id'      => 'icon_cdn',
			'type'    => 'switcher',
			'title'   => '图标第三方加速',
			'help'    => '开启后将使用第三方www.bootcdn.cn来加速网站图标，不消耗自身服务器流量,由又拍云提供全部 CDN 支持。',
			'default' => false
		),

		array(
			'type'    => 'subheading',
			'content' => '图像延迟加载',
		),

		array(
			'id'      => 'images_lazysizes',
			'type'    => 'switcher',
			'title'   => '图像延迟加载',
			'help'    => '开启后将按需加载图像，以达到节省带宽支出的目的。',
			'default' => false
		),

		array(
			'type'    => 'subheading',
			'content' => '缩略图',
		),

		array(
			'id'      => 'thumbnail_handle',
			'type'    => 'radio',
			'title'   => '处理方式',
			'options' => array(
				'timthumb_php' => 'timthumb.php',
				'timthumb_mi'  => '内置裁切',
				'original'     => '输出原图',
			),
			'default' => 'timthumb_php'
		),


	),
);

$options[] = array(
	'name'  => 'footer',
	'title' => '底部设置',
	'icon'  => 'fa fa-caret-square-o-down',

  	'fields' => array(

  		array(
			'type'    => 'subheading',
			'content' => '版权&备案号',
		),

  		array(
			'id'       => 'site_footer_info',
			'type'     => 'wysiwyg',
			'title'    => '底部信息',
			'settings' => array(
				'textarea_rows' => 5,
				'tinymce'       => true,
				'media_buttons' => false,
			)
		),

		array(
			'type'    => 'subheading',
			'content' => '社交信息',
		),

		array(
			'id'              => 'social_group',
			'type'            => 'group',
			'title'           => '社交信息',
			'button_title'    => '添加',
			'accordion_title' => '社交信息',
			'fields'          => array(
				array(
					'id'    => 'social_group_title',
					'type'  => 'text',
					'title' => '标题',
				),
				array(
					'id'      => 'social_group_icon',
					'type'    => 'icon',
					'title'   => '图标',
				),
				array(
					'id'    => 'social_group_type',
					'type'  => 'radio',
					'title' => '类型',
					'options' => array(
						'link'  => '链接',
						'email' => '邮件',
						'image' => '图片',
					),
					'default' => 'link',
				),
				array(
					'id'         => 'social_group_link',
					'type'       => 'text',
					'title'      => '链接地址',
					'dependency' => array( 'social_group_type_link', '==', 'true' ),
				),
				array(
					'id'         => 'social_group_email',
					'type'       => 'text',
					'title'      => '邮箱地址',
					'dependency' => array( 'social_group_type_email', '==', 'true' ),
				),
				array(
					'id'         => 'social_group_img',
					'type'       => 'image',
					'title'      => '图片',
					'dependency' => array( 'social_group_type_image', '==', 'true' ),
				),
			),
		),



	),
);

CSFramework::instance( $settings, $options );