<?php

//decode by http://www.yunlu99.com/
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
function optionsframework_option_name()
{
	$_var_0 = wp_get_theme();
	$_var_0 = preg_replace('/\\W/', '_', strtolower($_var_0));
	$_var_1 = get_option('optionsframework');
	$_var_1['id'] = $_var_0;
	update_option('optionsframework', $_var_1);
}
function optionsframework_options()
{
	$_var_2 = get_template_directory_uri() . '/img/';
	$_var_3 = array();
	$_var_4 = get_pages('sort_column=post_parent,menu_order');
	$_var_3[''] = 'Select a page:';
	foreach ($_var_4 as $_var_5) {
		$_var_3[$_var_5->ID] = $_var_5->post_title;
	}
	$_var_6 = array('info' => __('一般', 'options_framework_theme'), 'success' => __('成功', 'options_framework_theme'), 'warning' => __('警告', 'options_framework_theme'), 'danger' => __('危险', 'options_framework_theme'));
	$_var_7 = get_server_url(1);
	if (of_get('key')) {
		$_var_8 = Q_is(of_get('key'));
	} else {
		$_var_8['state'] = false;
		$_var_8['kong'] = true;
	}
	$_var_9 = array();
	$_var_9[] = array('name' => __('基本设置', 'options_framework_theme'), 'icon' => 'gears', 'type' => 'heading');
	$_var_9[] = array('name' => __('头像', 'options_framework_theme'), 'desc' => __('全站头像显示', 'options_framework_theme'), 'id' => 'avatar', 'type' => 'upload');
	$_var_9[] = array('name' => __('选择归档页面', 'options_framework_theme'), 'desc' => __('选择一个通过存档模板添加的归档页', 'options_framework_theme'), 'id' => 'page_archive', 'type' => 'select', 'options' => $_var_3);
	$_var_9[] = array('name' => __('选择分类页面', 'options_framework_theme'), 'desc' => __('选择一个通过存档模板添加的归档页', 'options_framework_theme'), 'id' => 'page_category', 'type' => 'select', 'options' => $_var_3);
	$_var_9[] = array('name' => __('选择标签页面', 'options_framework_theme'), 'desc' => __('选择一个通过存档模板添加的归档页', 'options_framework_theme'), 'id' => 'page_tag', 'type' => 'select', 'options' => $_var_3);
	$_var_9[] = array('name' => __('favicon 图片', 'options_framework_theme'), 'desc' => __('32像素x32像素 favicon 就是在浏览器标题左面显示的图标', 'options_framework_theme'), 'id' => 'favicon', 'type' => 'upload');
	$_var_9[] = array('name' => __('app icon 图片', 'options_framework_theme'), 'desc' => __('144像素x144像素 app - icon 当被用户收藏网站后在收藏夹显示的图标', 'options_framework_theme'), 'id' => 'app_icon', 'type' => 'upload');
	$_var_9[] = array('name' => __('启用AJAX模式', 'options_framework_theme'), 'desc' => __('勾选后全站启用AJAX模式', 'options_framework_theme'), 'id' => 'is_ajax', 'std' => '1', 'type' => 'checkbox');
	$_var_9[] = array('name' => __('不启用-AJAX路径(白名单)', 'options_framework_theme'), 'desc' => __('设置关键字并以逗号分隔，地址栏里出现此关键字则不通过ajax方式访问(每个关键字前需要加入一个空格否则无效)', 'options_framework_theme'), 'id' => 'no_ajax', 'std' => '#, /wp-, .pdf, .zip, .rar, /goto, jiathis.com', 'type' => 'text');
	$_var_9[] = array('name' => __('搜索默认文字', 'options_framework_theme'), 'desc' => __('设置导航搜索文字', 'options_framework_theme'), 'id' => 'soso', 'std' => '搜索', 'type' => 'text');
	$_var_9[] = array('name' => __('搜索提示文字', 'options_framework_theme'), 'desc' => __('列:按回车搜索，为空则不提示', 'options_framework_theme'), 'id' => 'soso_info', 'std' => '', 'type' => 'text');
	$_var_9[] = array('name' => __('网站版权文字', 'options_framework_theme'), 'desc' => __('底部版权', 'options_framework_theme'), 'id' => 'copyright', 'std' => '', 'type' => 'text');
	$_var_9[] = array('name' => __('备案号', 'options_framework_theme'), 'desc' => __('如果是境内网站可在此输入备案号', 'options_framework_theme'), 'id' => 'record', 'std' => '', 'type' => 'text');
	if ($_var_8['state']) {
		$_var_9[] = array('name' => '主题版权显示方式', 'desc' => '', 'id' => 'is_copy', 'std' => '1', 'type' => 'images', 'options' => array('1' => $_var_2 . 'copy01.png', '4' => $_var_2 . 'copy04.png', '2' => $_var_2 . 'copy02.png', '3' => $_var_2 . 'copy03.png'));
		$_var_9[] = array('name' => __('代码高亮', 'options_framework_theme'), 'desc' => __('勾选后启用代码高亮（若使用第三方代码高亮插件，可能不兼容AJAX）', 'options_framework_theme'), 'id' => 'is_code', 'std' => '1', 'type' => 'checkbox');
		$_var_9[] = array('name' => '代码高亮主题', 'desc' => '需启用高亮', 'id' => 'code_style', 'std' => 'sunburst', 'type' => 'images', 'options' => array('ascetic' => $_var_2 . 'ascetic.png', 'color-brewer' => $_var_2 . 'color-brewer.png', 'dark' => $_var_2 . 'dark.png', 'idea' => $_var_2 . 'idea.png', 'ocean' => $_var_2 . 'ocean.png', 'sunburst' => $_var_2 . 'sunburst.png', 'xcode' => $_var_2 . 'xcode.png'));
	} else {
		$_var_9[] = array('name' => '主题版权显示方式', 'desc' => '升级到高级版可扩充选项去除版权显示', 'id' => 'is_copy', 'std' => '1', 'type' => 'images', 'options' => array('1' => $_var_2 . 'copy01.png', '4' => $_var_2 . 'copy04.png'));
	}
	$_var_9[] = array('name' => __('懒人模式', 'options_framework_theme'), 'desc' => __('勾选后不设置特色图片会默认调用一张图片显示', 'options_framework_theme'), 'id' => 'is_lazy', 'std' => '0', 'type' => 'checkbox');
	$_var_9[] = array('name' => __('摘要字数', 'options_framework_theme'), 'desc' => __('在不填写摘要的情况下会默认调用文章的部分，这里是用来设置调用字数的', 'options_framework_theme'), 'id' => 'abstract_num', 'std' => '120', 'type' => 'text');
	$_var_9[] = array('name' => __('页脚文本', 'options_framework_theme'), 'id' => 'footer', 'type' => 'editor', 'settings' => $_var_10);
	$_var_9[] = array('name' => __('SEO设置', 'options_framework_theme'), 'icon' => 'desktop', 'type' => 'heading');
	$_var_9[] = array('name' => __('关键词', 'options_framework_theme'), 'desc' => __('请用英文逗号分隔', 'options_framework_theme'), 'id' => 'keywords', 'std' => '衫小寨', 'type' => 'text');
	$_var_9[] = array('name' => '网站描述', 'desc' => '', 'id' => 'description', 'std' => '衫小寨', 'type' => 'textarea');
	$_var_9[] = array('name' => __('副标题', 'options_framework_theme'), 'desc' => __('是否在title最后面显示副标题', 'options_framework_theme'), 'id' => 'logospanseo', 'std' => '0', 'type' => 'checkbox');
	$_var_9[] = array('name' => __('头部预留', 'options_framework_theme'), 'desc' => __('一般用于存放统计代码 ，此位置在 head 之前 （插入代码需要将编辑器切换到文本模式）', 'options_framework_theme'), 'id' => 'headtext', 'type' => 'editor', 'settings' => $_var_10);
	$_var_9[] = array('name' => __('底部预留', 'options_framework_theme'), 'desc' => __('一般用于插入js代码 ，此位置在 body 之前 ', 'options_framework_theme'), 'id' => 'footertext', 'type' => 'editor', 'settings' => $_var_10);
	$_var_9[] = array('name' => __('启用友情链接', 'options_framework_theme'), 'desc' => '勾选后启用（需在菜单中设置好）', 'id' => 'is_link', 'std' => '0', 'type' => 'checkbox');
	$_var_9[] = array('name' => __('音乐', 'options_framework_theme'), 'icon' => 'music', 'type' => 'heading');
	$_var_9[] = array('name' => __('是否开启音乐', 'options_framework_theme'), 'desc' => '勾选开启音乐', 'id' => 'is_music', 'std' => '0', 'type' => 'checkbox');
	$_var_9[] = array('name' => __('设置介绍', 'options_framework_theme'), 'desc' => __('详细设置 <a href="http://qzhai.net/2016-05-703.html" target="_black">点击查看</a> （请确保开启AJAX，否则切换页面歌曲会从头播放）', 'options_framework_theme'), 'type' => 'info');
	$_var_9[] = array('name' => __('音乐代码', 'options_framework_theme'), 'id' => 'music_text', 'std' => '<iframe frameborder="no" border="0" marginwidth="0" marginheight="0" width=280 height=380 src="http://music.163.com/outchain/player?type=1&id=3154175&auto=0&height=430"></iframe>', 'type' => 'editor', 'settings' => $_var_10);
	$_var_11 = option_s($_var_8['state']);
	$_var_9 = array_merge($_var_9, $_var_11);
	$_var_9[] = array('name' => __('激活', 'options_framework_theme'), 'icon' => 'credit-card', 'type' => 'heading');
	$_var_9[] = array('name' => __('您的根域名', 'options_framework_theme'), 'desc' => $_var_7, 'type' => 'info');
	$_var_9[] = array('name' => __('激活码', 'options_framework_theme'), 'id' => 'key', 'std' => '', 'type' => 'text');
	if ($_var_8['state'] && $_var_8['time'] != 'A') {
		$_var_9[] = array('name' => __('激活成功！（非常感谢您支持正版在这里给您请安了）', 'options_framework_theme'), 'desc' => '剩余时间：' . floor($_var_8['time'] / 86400) . '天', 'type' => 'info');
	} else {
		if ($_var_8['state'] && $_var_8['time'] == 'A') {
			$_var_9[] = array('name' => __('提示', 'options_framework_theme'), 'desc' => '激活系统已经更新，请即使联系卖家更换！，抱歉给您带来了不便！', 'type' => 'info');
		} else {
			if (!$_var_8['state'] && !$_var_8['kong']) {
				$_var_9[] = array('name' => __('错误!', 'options_framework_theme'), 'desc' => $_var_8['err'], 'type' => 'info');
			} else {
				$_var_9[] = array('name' => __('购买正版', 'options_framework_theme'), 'desc' => __('联系 ：<a href="http://qzhai.net/2016-03-546.html" target="_black">点击进入</a> （为了主题的持续开发，请勿使用任何破解版本）', 'options_framework_theme'), 'type' => 'info');
			}
		}
	}
	if (of_get('is_developer')) {
		$_var_9[] = array('name' => __('开发者模式', 'options_framework_theme'), 'icon' => 'code', 'type' => 'heading');
		$_var_9[] = array('name' => __('介绍', 'options_framework_theme'), 'desc' => __('设置子主题文件夹（新建一个与主题文件夹同级目录的文件夹）将要变更的文件放到子主题内，主题将默认调用子主题内的文件。目前子主题只支持 style.css、app.js和diy_fun.php', 'options_framework_theme'), 'type' => 'info');
		$_var_9[] = array('name' => __('子主题文件夹', 'options_framework_theme'), 'desc' => __('文件夹需要用 qzhai_ 开头（如填写test 文件夹就起名为 qzhai_test）', 'options_framework_theme'), 'id' => 'k_folder', 'std' => '', 'class' => 'mini', 'type' => 'text');
		$_var_12 = get_theme_root() . '/qzhai_' . of_get('k_folder');
		if (of_get('k_folder')) {
			if (is_dir($_var_12)) {
				$_var_9[] = array('name' => __('文件夹配置成功！', 'options_framework_theme'), 'desc' => __('文件夹配置正确！', 'options_framework_theme'), 'type' => 'info');
			} else {
				$_var_9[] = array('name' => __('没发现此文件夹！', 'options_framework_theme'), 'desc' => $_var_12, 'type' => 'info');
			}
		}
		$_var_9[] = array('name' => __('调试模式', 'options_framework_theme'), 'desc' => '调试模式', 'id' => 'is_debugging', 'std' => '0', 'type' => 'checkbox');
		$_var_9[] = array('name' => __('兼容ajax初始化函数', 'options_framework_theme'), 'desc' => '如果你发现有js不兼容ajax，可以将代码放到这个初始化函数里', 'id' => 'js_app', 'type' => 'editor', 'settings' => $_var_10);
	}
	return $_var_9;
}