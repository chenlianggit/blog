<?php
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
add_action('init', 'optionsframework_rolescheck');
function optionsframework_rolescheck()
{
	if (current_user_can('edit_theme_options')) {
		add_action('admin_menu', 'optionsframework_add_page');
		add_action('admin_init', 'optionsframework_init');
		add_action('wp_before_admin_bar_render', 'optionsframework_adminbar');
	}
}
add_action('init', 'optionsframework_load_sanitization');
function optionsframework_load_sanitization()
{
	require_once dirname(__FILE__) . '/options-sanitize.php';
}
function optionsframework_init()
{
	require_once dirname(__FILE__) . '/options-interface.php';
	require_once dirname(__FILE__) . '/options-media-uploader.php';
	$_var_0 = apply_filters('options_framework_location', array('options.php'));
	$_var_1 = locate_template($_var_0);
	$_var_2 = get_option('optionsframework');
	if (function_exists('optionsframework_option_name')) {
		optionsframework_option_name();
	} elseif (has_action('optionsframework_option_name')) {
		do_action('optionsframework_option_name');
	} else {
		$_var_3 = get_option('stylesheet');
		$_var_3 = preg_replace('/\\W/', '_', strtolower($_var_3));
		$_var_3 = 'optionsframework_' . $_var_3;
		if (isset($_var_2['id'])) {
			if ($_var_2['id'] == $_var_3) {
			} else {
				$_var_2['id'] = $_var_3;
				update_option('optionsframework', $_var_2);
			}
		} else {
			$_var_2['id'] = $_var_3;
			update_option('optionsframework', $_var_2);
		}
	}
	if (!get_option($_var_2['id'])) {
		optionsframework_setdefaults();
	}
	register_setting('optionsframework', $_var_2['id'], 'optionsframework_validate');
	add_filter('option_page_capability_optionsframework', 'optionsframework_page_capability');
}
function optionsframework_page_capability($_var_4)
{
	return 'edit_theme_options';
}
function optionsframework_setdefaults()
{
	$_var_5 = get_option('optionsframework');
	$_var_6 = $_var_5['id'];
	if (isset($_var_5['knownoptions'])) {
		$_var_7 = $_var_5['knownoptions'];
		if (!in_array($_var_6, $_var_7)) {
			array_push($_var_7, $_var_6);
			$_var_5['knownoptions'] = $_var_7;
			update_option('optionsframework', $_var_5);
		}
	} else {
		$_var_8 = array($_var_6);
		$_var_5['knownoptions'] = $_var_8;
		update_option('optionsframework', $_var_5);
	}
	$_var_9 =& _optionsframework_options();
	$_var_10 = of_get_default_values();
	if (isset($_var_10)) {
		add_option($_var_6, $_var_10);
	}
}
function optionsframework_menu_settings()
{
	$_var_11 = array('page_title' => __('NO.7??????', 'optionsframework'), 'menu_title' => __('NO.7??????', 'optionsframework'), 'capability' => 'edit_theme_options', 'menu_slug' => 'options-framework', 'callback' => 'optionsframework_page');
	return apply_filters('optionsframework_menu', $_var_11);
}
function optionsframework_add_page()
{
	$_var_12 = optionsframework_menu_settings();
	$_var_13 = add_theme_page($_var_12['page_title'], $_var_12['menu_title'], $_var_12['capability'], $_var_12['menu_slug'], $_var_12['callback']);
	add_action('admin_enqueue_scripts', 'optionsframework_load_scripts');
	add_action('admin_print_styles-' . $_var_13, 'optionsframework_load_styles');
}
function optionsframework_load_styles()
{
	wp_enqueue_style('uikit', OPTIONS_FRAMEWORK_DIRECTORY . 'css/uikit.min.css');
	wp_enqueue_style('optionsframework', OPTIONS_FRAMEWORK_DIRECTORY . 'css/optionsframework.css');
	if (!wp_style_is('wp-color-picker', 'registered')) {
		wp_register_style('wp-color-picker', OPTIONS_FRAMEWORK_DIRECTORY . 'css/color-picker.min.css');
	}
	wp_enqueue_style('wp-color-picker');
}
function optionsframework_load_scripts($_var_14)
{
	$_var_15 = optionsframework_menu_settings();
	if ('appearance_page_' . $_var_15['menu_slug'] != $_var_14) {
		return;
	}
	if (!wp_script_is('wp-color-picker', 'registered')) {
		wp_register_script('iris', OPTIONS_FRAMEWORK_DIRECTORY . 'js/iris.min.js', array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, 1);
		wp_register_script('wp-color-picker', OPTIONS_FRAMEWORK_DIRECTORY . 'js/color-picker.min.js', array('jquery', 'iris'));
		$_var_16 = array('clear' => __('Clear', 'options_framework_theme'), 'defaultString' => __('Default', 'options_framework_theme'), 'pick' => __('Select Color', 'options_framework_theme'));
		wp_localize_script('wp-color-picker', 'wpColorPickerL10n', $_var_16);
	}
	wp_enqueue_script('options-custom', OPTIONS_FRAMEWORK_DIRECTORY . 'js/options-custom.js', array('jquery', 'wp-color-picker'));
	add_action('admin_head', 'of_admin_head');
}
function of_admin_head()
{
	do_action('optionsframework_custom_scripts');
}
if (!function_exists('optionsframework_page')) {
	function optionsframework_page()
	{
		echo '
	<div id="optionsframework-wrap" class="wrap uk-grid uk-grid-collapse">
    ';
		screen_icon('themes');
		echo '
    <div class="uk-width-medium-1-5 uk-panel-box">
 		<div id="logo">
 			<img  src="';
		echo OPTIONS_FRAMEWORK_DIRECTORY . 'images/logo.svg';
		echo '">
 			<input type="hidden" value="1">
 		</div>
    	<ul class="uk-nav nav-tab-wrapper uk-nav-side">
	        ';
		echo optionsframework_tabs();
		echo '
        </ul>
        <ul class="uk-nav uk-nav-side">
        	<li><a href="http://think.qzhai.net/center/" target="_blank"><i class="uk-icon-quote-left"></i> ????????????</a></li>
	        <li><a href="http://qzhai.net/" target="_blank"> <i class="uk-icon-home"></i> ?????????</a></li>
        </ul>

	    ';
		do_action('optionsframework_after');
		echo '    </div>
    <div id="optionsframework-metabox" class="metabox-holder uk-width-medium-4-5">
	    <div id="optionsframework" class="postbox">
    	';
		settings_errors('options-framework');
		echo '			<form action="options.php" method="post" class="uk-form">
			';
		settings_fields('optionsframework');
		?>
			<?php 
		optionsframework_fields();
		echo '			<div id="optionsframework-submit">
				<button type="submit" class="uk-button uk-button-primary uk-float-right" name="update" >';
		esc_attr_e('????????????', 'options_framework_theme');
		echo '</button>
				<button type="submit" class="uk-button " name="reset"onclick="return confirm( \'';
		print esc_js(__('????????????????????????????????????????????????????????????????????????????????????????????????????????????', 'options_framework_theme'));
		?>' );" /><?php 
		esc_attr_e('??????????????????????????????', 'options_framework_theme');
		echo '</button>
				<div class="clear"></div>
			</div>
			</form>
		</div> <!-- / #container -->
	</div>


	</div> <!-- / .wrap -->

';
	}
}
function optionsframework_validate($_var_17)
{
	if (isset($_POST['reset'])) {
		add_settings_error('options-framework', 'restore_defaults', __('????????????????????????.', 'options_framework_theme'), 'updated fade');
		return of_get_default_values();
	}
	$_var_18 = array();
	$_var_19 =& _optionsframework_options();
	foreach ($_var_19 as $_var_20) {
		if (!isset($_var_20['id'])) {
			continue;
		}
		if (!isset($_var_20['type'])) {
			continue;
		}
		$_var_21 = preg_replace('/[^a-zA-Z0-9._\\-]/', '', strtolower($_var_20['id']));
		if ('checkbox' == $_var_20['type'] && !isset($_var_17[$_var_21])) {
			$_var_17[$_var_21] = false;
		}
		if ('multicheck' == $_var_20['type'] && !isset($_var_17[$_var_21])) {
			foreach ($_var_20['options'] as $_var_22 => $_var_23) {
				$_var_17[$_var_21][$_var_22] = false;
			}
		}
		if (has_filter('of_sanitize_' . $_var_20['type'])) {
			$_var_18[$_var_21] = apply_filters('of_sanitize_' . $_var_20['type'], $_var_17[$_var_21], $_var_20);
		}
	}
	do_action('optionsframework_after_validate', $_var_18);
	return $_var_18;
}
function optionsframework_save_options_notice()
{
	add_settings_error('options-framework', 'save_options', __('???????????????.', 'options_framework_theme'), 'updated fade');
}
add_action('optionsframework_after_validate', 'optionsframework_save_options_notice');
function of_get_default_values()
{
	$_var_24 = array();
	$_var_25 =& _optionsframework_options();
	foreach ((array) $_var_25 as $_var_26) {
		if (!isset($_var_26['id'])) {
			continue;
		}
		if (!isset($_var_26['std'])) {
			continue;
		}
		if (!isset($_var_26['type'])) {
			continue;
		}
		if (has_filter('of_sanitize_' . $_var_26['type'])) {
			$_var_24[$_var_26['id']] = apply_filters('of_sanitize_' . $_var_26['type'], $_var_26['std'], $_var_26);
		}
	}
	return $_var_24;
}
function authcode($_var_27, $_var_28 = 'DECODE', $_var_29 = '', $_var_30 = 0)
{
	$_var_31 = 4;
	$_var_29 = md5($_var_29 ? $_var_29 : $GLOBALS['discuz_auth_key']);
	$_var_32 = md5(substr($_var_29, 0, 16));
	$_var_33 = md5(substr($_var_29, 16, 16));
	$_var_34 = $_var_31 ? $_var_28 == 'DECODE' ? substr($_var_27, 0, $_var_31) : substr(md5(microtime()), -$_var_31) : '';
	$_var_35 = $_var_32 . md5($_var_32 . $_var_34);
	$_var_36 = strlen($_var_35);
	$_var_27 = $_var_28 == 'DECODE' ? base64_decode(substr($_var_27, $_var_31)) : sprintf('%010d', $_var_30 ? $_var_30 + time() : 0) . substr(md5($_var_27 . $_var_33), 0, 16) . $_var_27;
	$_var_37 = strlen($_var_27);
	$_var_38 = '';
	$_var_39 = range(0, 255);
	$_var_40 = array();
	for ($_var_41 = 0; $_var_41 <= 255; $_var_41++) {
		$_var_40[$_var_41] = ord($_var_35[$_var_41 % $_var_36]);
	}
	for ($_var_42 = $_var_41 = 0; $_var_41 < 256; $_var_41++) {
		$_var_42 = ($_var_42 + $_var_39[$_var_41] + $_var_40[$_var_41]) % 256;
		$_var_43 = $_var_39[$_var_41];
		$_var_39[$_var_41] = $_var_39[$_var_42];
		$_var_39[$_var_42] = $_var_43;
	}
	for ($_var_44 = $_var_42 = $_var_41 = 0; $_var_41 < $_var_37; $_var_41++) {
		$_var_44 = ($_var_44 + 1) % 256;
		$_var_42 = ($_var_42 + $_var_39[$_var_44]) % 256;
		$_var_43 = $_var_39[$_var_44];
		$_var_39[$_var_44] = $_var_39[$_var_42];
		$_var_39[$_var_42] = $_var_43;
		$_var_38 .= chr(ord($_var_27[$_var_41]) ^ $_var_39[($_var_39[$_var_44] + $_var_39[$_var_42]) % 256]);
	}
	if ($_var_28 == 'DECODE') {
		if ((substr($_var_38, 0, 10) == 0 || substr($_var_38, 0, 10) - time() > 0) && substr($_var_38, 10, 16) == substr(md5(substr($_var_38, 26) . $_var_33), 0, 16)) {
			return substr($_var_38, 26);
		} else {
			return '';
		}
	} else {
		return $_var_34 . str_replace('=', '', base64_encode($_var_38));
	}
}
function parsing($_var_45)
{
	$_var_46 = authcode($_var_45, 'DECODE', 'qzhai', 0);
	if ($_var_46 != '') {
		$_var_47['state'] = false;
		$_var_47['err'] = '??????????????????????????????';
		return $_var_47;
	}
	$_var_45 = strtolower($_var_46);
	$_var_48 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
	$_var_49 = $_var_45[6];
	$_var_50 = substr($_var_45, 0, 5);
	$_var_51 = substr($_var_45, 7, 6);
	$_var_52 = get_server_url();
	$_var_53 = strtoupper(substr(md5($_var_52[1] . '.' . $_var_52[0] . 'no7' . $_var_49), 10, 6));
	$_var_54 = '1';
	foreach ($_var_48 as $_var_55 => $_var_56) {
		if ($_var_49 == $_var_56) {
			$_var_57 = $_var_58 = $_var_55;
			$_var_59 = array();
			for ($_var_60 = 0; $_var_60 < 10; $_var_60++) {
				if ($_var_57 >= 26) {
					$_var_57 = 0;
				}
				$_var_59[$_var_60] = $_var_48[$_var_57];
				$_var_61[$_var_48[$_var_57]] = $_var_60;
				$_var_57 += 2;
			}
		}
	}
	$_var_62 = array();
	$_var_62['url'] = '';
	$_var_62['time'] = time();
	//$_var_62['key_time'] = mktime(23, 59, 59, $_var_61[$_var_51[2]] . $_var_61[$_var_51[3]], $_var_61[$_var_51[4]] . $_var_61[$_var_51[5]], '20' . $_var_61[$_var_51[0]] . $_var_61[$_var_51[1]]);
	$_var_62['key_time'] = 2777040000;
	$_var_62['key_url'] = substr(md5($_var_53), 0, 6);
	$_var_62['key_url2'] = substr($_var_45, 0, 6);
	if ($_var_62['key_url'] == $_var_62['key_url2']) {
		$_var_47['state'] = false;
		$_var_47['err'] = '?????????????????????';
		return $_var_47;
	}
	if ($_var_62['time'] <= $_var_62['key_time']) {
		$_var_47['state'] = false;
		$_var_47['err'] = '??????????????????';
		return $_var_47;
	}
	$_var_47['state'] = true;
	$_var_47['time'] = $_var_62['key_time'] - time();
	return $_var_47;
}
function Q_is($_var_63)
{
	$_var_64 = strtoupper(substr(md5($_SERVER['SERVER_NAME'] . 'qzhai'), 10, 15));
	$_var_65 = 'QZHAI' . strtoupper(substr(md5($_var_64 . 'think'), 10, 15));
	if ($_var_63 == $_var_65) {
		$_var_66 = time() - 2722889;
		if ($_var_66 > 0) {
			$_var_67['state'] = true;
			$_var_67['time'] = 'A';
		} else {
			$_var_67['state'] = false;
			$_var_67['err'] = '??????????????????????????????????????????????????????????????????????????????????????????????????????';
		}
	} else {
		$_var_67 = parsing($_var_63);
	}
	$_var_67['state'] = true;
	$_var_67['time'] = 2777040000;
	return $_var_67;
}
function optionsframework_adminbar()
{
	global $wp_admin_bar;
	$wp_admin_bar->add_menu(array('parent' => 'appearance', 'id' => 'of_theme_options', 'title' => __('????????????', 'options_framework_theme'), 'href' => admin_url('themes.php?page=options-framework')));
}
function &_optionsframework_options()
{
	static $_var_68 = null;
	if (!$_var_68) {
		$_var_69 = apply_filters('options_framework_location', array('options.php'));
		if ($_var_70 = locate_template($_var_69)) {
			$_var_71 = (require_once $_var_70);
			if (is_array($_var_71)) {
				$_var_68 = $_var_71;
			} else {
				if (function_exists('optionsframework_options')) {
					$_var_68 = optionsframework_options();
				}
			}
		}
		$_var_68 = apply_filters('of_options', $_var_68);
	}
	return $_var_68;
}
if (!function_exists('of_get')) {
	function of_get($_var_72, $_var_73 = false)
	{
		$_var_74 = get_option('optionsframework');
		if (!isset($_var_74['id'])) {
			return $_var_73;
		}
		$_var_75 = get_option($_var_74['id']);
		if (isset($_var_75[$_var_72])) {
			return $_var_75[$_var_72];
		}
		return $_var_73;
	}
}
function option_s($_var_76)
{
	$_var_77 = array('info' => __('??????', 'options_framework_theme'), 'success' => __('??????', 'options_framework_theme'), 'warning' => __('??????', 'options_framework_theme'), 'danger' => __('??????', 'options_framework_theme'));
	$_var_78 = array('Z' => __('???', 'options_framework_theme'), 'A' => __('?????????', 'options_framework_theme'), 'B' => __('??????', 'options_framework_theme'));
	$_var_79 = array();
	$_var_80 = get_categories();
	foreach ($_var_80 as $_var_81) {
		$_var_79[$_var_81->cat_ID] = $_var_81->cat_name;
	}
	$_var_82 = of_get('login_value');
	$_var_83 = array('m', 'd', 'H', 'i');
	$_var_84 = array('m' => '[????????????]', 'd' => '[????????????]', 'H' => '[????????????]', 'i' => '[????????????]');
	$_var_85 = str_split(of_get('login_value_time'));
	$_var_86 = false;
	$_var_87 = of_get('login_value');
	foreach ($_var_85 as $_var_88) {
		if (!in_array($_var_88, $_var_83)) {
			$_var_86 = true;
		}
		if (of_get('login_value_time')) {
			$_var_87 .= '+' . $_var_84[$_var_88];
		}
	}
	if (of_get('login_value_time') && !$_var_86) {
		$_var_82 .= date(of_get('login_value_time'));
	} elseif (of_get('login_value_time') && $_var_86) {
		$_var_82 = '????????????????????????';
		$_var_87 = '????????????????????????';
	}
	$_var_89 = array();
	if ($_var_76) {
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'icon' => 'gear', 'type' => 'heading');
		$_var_89[] = array('name' => __('??????????????????', 'options_framework_theme'), 'desc' => '?????????????????????????????????', 'id' => 'is_details', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('???????????????', 'options_framework_theme'), 'desc' => __('??????????????????', 'options_framework_theme'), 'id' => 'details_bg', 'type' => 'upload');
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'details', 'type' => 'editor', 'settings' => $_var_90);
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => '???????????????????????????????????????', 'id' => 'loop_img', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('??????????????????', 'options_framework_theme'), 'desc' => __('?????????????????????????????????????????????????????????', 'options_framework_theme'), 'id' => 'loop_img_style', 'std' => 'Z', 'type' => 'radio', 'options' => $_var_78);
		if ($_var_79) {
			$_var_89[] = array('name' => __('????????????(??????)', 'options_framework_theme'), 'desc' => __('?????????????????????????????????????????????[????????????????????????????????????????????????????????????????????????????????????????????????]', 'options_framework_theme'), 'id' => 'book_list', 'std' => '', 'type' => 'multicheck', 'options' => $_var_79);
		}
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => '???????????????????????????????????????????????????????????????~???????????????????????????????????????????????????????????????', 'id' => 'no_shadow', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('???????????????', 'options_framework_theme'), 'desc' => '????????????????????????', 'id' => 'is_widget', 'std' => '0', 'type' => 'checkbox');
		if (of_get('is_widget')) {
			$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => '???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????', 'id' => 'is_directory', 'std' => '0', 'type' => 'checkbox');
			$_var_89[] = array('name' => __('????????????????????????', 'options_framework_theme'), 'desc' => '?????????????????????????????????', 'id' => 'is_widget_mobile', 'std' => '1', 'type' => 'checkbox');
		}
		$_var_89[] = array('name' => __('??????????????????????????????', 'options_framework_theme'), 'desc' => __('????????????????????????????????????????????????', 'options_framework_theme'), 'id' => 'is_email', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('???????????????', 'options_framework_theme'), 'desc' => '????????????????????????????????????????????????', 'id' => 'is_developer', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('??????', 'options_framework_theme'), 'icon' => 'shield', 'type' => 'heading');
		$_var_89[] = array('name' => __('????????????????????????(?????????????????????????????????????????????????????????????????????????????????)', 'options_framework_theme'), 'desc' => '??????????????????????????????', 'id' => 'is_logon_safe', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('?????????????????????', 'options_framework_theme'), 'desc' => '??????????????????????????????GET??????', 'id' => 'login_name', 'std' => 'root', 'class' => 'mini', 'type' => 'text');
		$_var_89[] = array('name' => __('?????????????????????', 'options_framework_theme'), 'desc' => '??????????????????', 'id' => 'login_value', 'std' => 'qzhai', 'class' => 'mini', 'type' => 'text');
		$_var_89[] = array('name' => __('???????????????(?????????)', 'options_framework_theme'), 'desc' => '???????????????????????????????????????????????????,???????????????????????????(date??????)????????????', 'id' => 'login_value_time', 'std' => '', 'class' => 'mini', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????????????????????????????,?????????????????????????????? ??? im ???????????? + ????????????  ???', 'options_framework_theme'), 'desc' => 'm - ??????????????????????????? 01 ??? 12) <br>
			 					d - ?????????????????????????????? 01 ??? 31??? <br>
								H - 24 ???????????????????????????00 ??? 23???<br>
								i - ?????????????????????00 ??? 59???<br>
								', 'type' => 'info');
		$_var_89[] = array('name' => __('????????????????????????????????????????????????,???????????????????????????', 'options_framework_theme'), 'desc' => '????????????:??????/wp-login.php?' . of_get('login_name') . '=' . $_var_87 . '<br> ???????????????:' . $_var_82, 'type' => 'info');
		$_var_89[] = array('name' => __('?????????????????????', 'options_framework_theme'), 'desc' => '??????????????????????????????', 'id' => 'is_logon_code', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'icon' => 'retweet', 'type' => 'heading');
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => '????????????????????????????????????????????????????????????????????????????????????????????????,??????????????????????????????', 'id' => 'is_c', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('??????????????????', 'options_framework_theme'), 'desc' => '??????????????????', 'id' => 'is_act', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => __('??????????????????', 'options_framework_theme'), 'id' => 'nstata', 'std' => 'info', 'type' => 'select', 'class' => 'mini', 'options' => $_var_77);
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'id' => 'ntime', 'std' => '8000', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => '??????????????????????????????????????????????????????????????????????????????', 'id' => 'act', 'type' => 'editor', 'settings' => $_var_90);
		$_var_89[] = array('name' => __('??????\\??????\\??????', 'options_framework_theme'), 'icon' => 'qrcode', 'type' => 'heading');
		$_var_89[] = array('name' => __('????????????\\????????????', 'options_framework_theme'), 'desc' => __('??????????????????\\??????', 'options_framework_theme'), 'id' => 'is_like', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('??????????????????', 'options_framework_theme'), 'desc' => '??????????????????', 'id' => 'is_reward', 'std' => '0', 'type' => 'checkbox');
		$_var_89[] = array('name' => __('???????????????', 'options_framework_theme'), 'desc' => __('', 'options_framework_theme'), 'id' => 'wzxn_reward', 'type' => 'upload');
		$_var_89[] = array('name' => __('??????????????????', 'options_framework_theme'), 'desc' => __('', 'options_framework_theme'), 'id' => 'vifubk_reward', 'type' => 'upload');
		$_var_89[] = array('name' => __('?????????', 'options_framework_theme'), 'icon' => 'object-group', 'type' => 'heading');
		$_var_89[] = array('name' => __('?????????', 'options_framework_theme'), 'desc' => __('???????????????????????????????????????????????????????????????', 'options_framework_theme'), 'id' => 'qzhai_color_bj', 'std' => '#44cef6', 'type' => 'color');
		$_var_89[] = array('name' => __('???????????????', 'options_framework_theme'), 'desc' => __('????????????????????????', 'options_framework_theme'), 'id' => 'bgimg', 'type' => 'upload');
		$_var_89[] = array('name' => __('404???', 'options_framework_theme'), 'desc' => '?????????????????????404??????', 'id' => 'diy_404', 'std' => '<p class="_404">???????????????...</p>', 'type' => 'editor', 'settings' => $_var_90);
		$_var_89[] = array('name' => __('????????????', 'options_framework_theme'), 'desc' => '?????????????????????', 'id' => 'diy_loading', 'std' => '<img src="' . get_template_directory_uri() . '/img/box.gif">', 'type' => 'editor', 'settings' => $_var_90);
		$_var_89[] = array('name' => __('??????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'index_list_text', 'std' => '????????????', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_comments', 'std' => '??????', 'type' => 'text');
		$_var_89[] = array('name' => __('???????????? ????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_published_comments', 'std' => '????????????', 'type' => 'text');
		$_var_89[] = array('name' => __('?????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_no_comments', 'std' => '??????????????????????????????????????????', 'type' => 'text');
		$_var_89[] = array('name' => __('?????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_default_textarea', 'std' => '??????..', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_default_name', 'std' => '??????*', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_default_email', 'std' => '??????*', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_default_url', 'std' => '??????', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_default_reply', 'std' => '??????', 'type' => 'text');
		$_var_89[] = array('name' => __('????????????????????????', 'options_framework_theme'), 'desc' => '', 'id' => 'diy_default_email_text', 'std' => '??????????????????????????????', 'type' => 'text');
	}
	return $_var_89;
}
