<?php
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
function optionsframework_tabs()
{
	$_var_0 = 0;
	$_var_1 =& _optionsframework_options();
	$_var_2 = '';
	foreach ($_var_1 as $_var_3) {
		if ($_var_3['type'] == 'heading') {
			$_var_0++;
			$_var_4 = '';
			$_var_4 = !empty($_var_3['id']) ? $_var_3['id'] : $_var_3['name'];
			$_var_4 = preg_replace('/[^a-zA-Z0-9._\\-]/', '', strtolower($_var_4)) . '-tab';
			$_var_2 .= '<li><a id="options-group-' . $_var_0 . '-tab" class="' . $_var_4 . '" title="' . esc_attr($_var_3['name']) . '" href="' . esc_attr('#options-group-' . $_var_0) . '"> <i class="uk-icon-' . esc_html($_var_3['icon']) . '"> </i> ' . esc_html($_var_3['name']) . '</a></li>';
		}
	}
	return $_var_2;
}
function optionsframework_fields()
{
	global $allowedtags;
	$_var_5 = get_option('optionsframework');
	if (isset($_var_5['id'])) {
		$_var_6 = $_var_5['id'];
	} else {
		$_var_6 = 'options_framework_theme';
	}
	$_var_7 = get_option($_var_6);
	$_var_8 =& _optionsframework_options();
	$_var_9 = 0;
	$_var_10 = '';
	foreach ($_var_8 as $_var_11) {
		$_var_12 = '';
		$_var_13 = '';
		$_var_14 = '';
		if ($_var_11['type'] != 'heading' && $_var_11['type'] != 'info') {
			$_var_11['id'] = preg_replace('/[^a-zA-Z0-9._\\-]/', '', strtolower($_var_11['id']));
			$_var_15 = 'section-' . $_var_11['id'];
			$_var_16 = 'section';
			if (isset($_var_11['type'])) {
				$_var_16 .= ' section-' . $_var_11['type'];
			}
			if (isset($_var_11['class'])) {
				$_var_16 .= ' ' . $_var_11['class'];
			}
			$_var_14 .= '<div id="' . esc_attr($_var_15) . '" class="' . esc_attr($_var_16) . '">' . '
';
			if (isset($_var_11['name'])) {
				$_var_14 .= '<h4 class="heading">' . esc_html($_var_11['name']) . '</h4>' . '
';
			}
			if ($_var_11['type'] != 'editor') {
				$_var_14 .= '<div class="option">' . '
' . '<div class="controls">' . '
';
			} else {
				$_var_14 .= '<div class="option">' . '
' . '<div>' . '
';
			}
		}
		if (isset($_var_11['std'])) {
			$_var_12 = $_var_11['std'];
		}
		if ($_var_11['type'] != 'heading' && $_var_11['type'] != 'info') {
			if (isset($_var_7[$_var_11['id']])) {
				$_var_12 = $_var_7[$_var_11['id']];
				if (!is_array($_var_12)) {
					$_var_12 = stripslashes($_var_12);
				}
			}
		}
		$_var_17 = '';
		if (isset($_var_11['desc'])) {
			$_var_17 = $_var_11['desc'];
		}
		switch ($_var_11['type']) {
			case 'text':
				$_var_14 .= '<input id="' . esc_attr($_var_11['id']) . '" class="of-input" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . ']') . '" type="text" value="' . esc_attr($_var_12) . '" />';
				break;
			case 'password':
				$_var_14 .= '<input id="' . esc_attr($_var_11['id']) . '" class="of-input" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . ']') . '" type="password" value="' . esc_attr($_var_12) . '" />';
				break;
			case 'textarea':
				$_var_18 = '8';
				if (isset($_var_11['settings']['rows'])) {
					$_var_19 = $_var_11['settings']['rows'];
					if (is_numeric($_var_19)) {
						$_var_18 = $_var_19;
					}
				}
				$_var_12 = stripslashes($_var_12);
				$_var_14 .= '<textarea id="' . esc_attr($_var_11['id']) . '" class="of-input" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . ']') . '" rows="' . $_var_18 . '">' . esc_textarea($_var_12) . '</textarea>';
				break;
			case 'select':
				$_var_14 .= '<select class="of-input" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . ']') . '" id="' . esc_attr($_var_11['id']) . '">';
				foreach ($_var_11['options'] as $_var_20 => $_var_21) {
					$_var_14 .= '<option' . selected($_var_12, $_var_20, false) . ' value="' . esc_attr($_var_20) . '">' . esc_html($_var_21) . '</option>';
				}
				$_var_14 .= '</select>';
				break;
			case 'radio':
				$_var_22 = $_var_6 . '[' . $_var_11['id'] . ']';
				foreach ($_var_11['options'] as $_var_20 => $_var_21) {
					$_var_15 = $_var_6 . '-' . $_var_11['id'] . '-' . $_var_20;
					$_var_14 .= '<input class="of-input of-radio" type="radio" name="' . esc_attr($_var_22) . '" id="' . esc_attr($_var_15) . '" value="' . esc_attr($_var_20) . '" ' . checked($_var_12, $_var_20, false) . ' /><label for="' . esc_attr($_var_15) . '">' . esc_html($_var_21) . '</label>';
				}
				break;
			case 'images':
				$_var_22 = $_var_6 . '[' . $_var_11['id'] . ']';
				foreach ($_var_11['options'] as $_var_20 => $_var_21) {
					$_var_23 = '';
					if ($_var_12 != '' && $_var_12 == $_var_20) {
						$_var_23 = ' of-radio-img-selected';
					}
					$_var_14 .= '<input type="radio" id="' . esc_attr($_var_11['id'] . '_' . $_var_20) . '" class="of-radio-img-radio" value="' . esc_attr($_var_20) . '" name="' . esc_attr($_var_22) . '" ' . checked($_var_12, $_var_20, false) . ' />';
					$_var_14 .= '<div class="of-radio-img-label">' . esc_html($_var_20) . '</div>';
					$_var_14 .= '<img src="' . esc_url($_var_21) . '" alt="' . $_var_21 . '" class="of-radio-img-img' . $_var_23 . '" onclick="document.getElementById(\'' . esc_attr($_var_11['id'] . '_' . $_var_20) . '\').checked=true;" />';
				}
				break;
			case 'checkbox':
				$_var_14 .= '<input id="' . esc_attr($_var_11['id']) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . ']') . '" ' . checked($_var_12, 1, false) . ' />';
				$_var_14 .= '<label class="explain" for="' . esc_attr($_var_11['id']) . '">' . wp_kses($_var_17, $allowedtags) . '</label>';
				break;
			case 'multicheck':
				foreach ($_var_11['options'] as $_var_20 => $_var_21) {
					$_var_24 = '';
					$_var_25 = $_var_21;
					$_var_21 = preg_replace('/[^a-zA-Z0-9._\\-]/', '', strtolower($_var_20));
					$_var_15 = $_var_6 . '-' . $_var_11['id'] . '-' . $_var_21;
					$_var_22 = $_var_6 . '[' . $_var_11['id'] . '][' . $_var_21 . ']';
					if (isset($_var_12[$_var_21])) {
						$_var_24 = checked($_var_12[$_var_21], 1, false);
					}
					$_var_14 .= '<input id="' . esc_attr($_var_15) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr($_var_22) . '" ' . $_var_24 . ' /><label for="' . esc_attr($_var_15) . '">' . esc_html($_var_25) . '</label>';
				}
				break;
			case 'color':
				$_var_26 = '';
				if (isset($_var_11['std'])) {
					if ($_var_12 != $_var_11['std']) {
						$_var_26 = ' data-default-color="' . $_var_11['std'] . '" ';
					}
				}
				$_var_14 .= '<input name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . ']') . '" id="' . esc_attr($_var_11['id']) . '" class="of-color"  type="text" value="' . esc_attr($_var_12) . '"' . $_var_26 . ' />';
				break;
			case 'upload':
				$_var_14 .= optionsframework_uploader($_var_11['id'], $_var_12, null);
				break;
			case 'typography':
				unset($_var_27, $_var_28, $_var_29, $_var_30);
				$_var_31 = array('size' => '', 'face' => '', 'style' => '', 'color' => '');
				$_var_32 = wp_parse_args($_var_12, $_var_31);
				$_var_33 = array('sizes' => of_recognized_font_sizes(), 'faces' => of_recognized_font_faces(), 'styles' => of_recognized_font_styles(), 'color' => true);
				if (isset($_var_11['options'])) {
					$_var_33 = wp_parse_args($_var_11['options'], $_var_33);
				}
				if ($_var_33['sizes']) {
					$_var_27 = '<select class="of-typography of-typography-size" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . '][size]') . '" id="' . esc_attr($_var_11['id'] . '_size') . '">';
					$_var_34 = $_var_33['sizes'];
					foreach ($_var_34 as $_var_35) {
						$_var_36 = $_var_35 . 'px';
						$_var_27 .= '<option value="' . esc_attr($_var_36) . '" ' . selected($_var_32['size'], $_var_36, false) . '>' . esc_html($_var_36) . '</option>';
					}
					$_var_27 .= '</select>';
				}
				if ($_var_33['faces']) {
					$_var_29 = '<select class="of-typography of-typography-face" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . '][face]') . '" id="' . esc_attr($_var_11['id'] . '_face') . '">';
					$_var_37 = $_var_33['faces'];
					foreach ($_var_37 as $_var_20 => $_var_38) {
						$_var_29 .= '<option value="' . esc_attr($_var_20) . '" ' . selected($_var_32['face'], $_var_20, false) . '>' . esc_html($_var_38) . '</option>';
					}
					$_var_29 .= '</select>';
				}
				if ($_var_33['styles']) {
					$_var_28 = '<select class="of-typography of-typography-style" name="' . $_var_6 . '[' . $_var_11['id'] . '][style]" id="' . $_var_11['id'] . '_style">';
					$_var_39 = $_var_33['styles'];
					foreach ($_var_39 as $_var_20 => $_var_40) {
						$_var_28 .= '<option value="' . esc_attr($_var_20) . '" ' . selected($_var_32['style'], $_var_20, false) . '>' . $_var_40 . '</option>';
					}
					$_var_28 .= '</select>';
				}
				if ($_var_33['color']) {
					$_var_26 = '';
					if (isset($_var_11['std']['color'])) {
						if ($_var_12 != $_var_11['std']['color']) {
							$_var_26 = ' data-default-color="' . $_var_11['std']['color'] . '" ';
						}
					}
					$_var_30 = '<input name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . '][color]') . '" id="' . esc_attr($_var_11['id'] . '_color') . '" class="of-color of-typography-color  type="text" value="' . esc_attr($_var_32['color']) . '"' . $_var_26 . ' />';
				}
				$_var_41 = compact('font_size', 'font_face', 'font_style', 'font_color');
				$_var_41 = apply_filters('of_typography_fields', $_var_41, $_var_32, $_var_6, $_var_11);
				$_var_14 .= implode('', $_var_41);
				break;
			case 'background':
				$_var_42 = $_var_12;
				$_var_26 = '';
				if (isset($_var_11['std']['color'])) {
					if ($_var_12 != $_var_11['std']['color']) {
						$_var_26 = ' data-default-color="' . $_var_11['std']['color'] . '" ';
					}
				}
				$_var_14 .= '<input name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . '][color]') . '" id="' . esc_attr($_var_11['id'] . '_color') . '" class="of-color of-background-color"  type="text" value="' . esc_attr($_var_42['color']) . '"' . $_var_26 . ' />';
				if (!isset($_var_42['image'])) {
					$_var_42['image'] = '';
				}
				$_var_14 .= optionsframework_uploader($_var_11['id'], $_var_42['image'], null, esc_attr($_var_6 . '[' . $_var_11['id'] . '][image]'));
				$_var_16 = 'of-background-properties';
				if ('' == $_var_42['image']) {
					$_var_16 .= ' hide';
				}
				$_var_14 .= '<div class="' . esc_attr($_var_16) . '">';
				$_var_14 .= '<select class="of-background of-background-repeat" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . '][repeat]') . '" id="' . esc_attr($_var_11['id'] . '_repeat') . '">';
				$_var_43 = of_recognized_background_repeat();
				foreach ($_var_43 as $_var_20 => $_var_44) {
					$_var_14 .= '<option value="' . esc_attr($_var_20) . '" ' . selected($_var_42['repeat'], $_var_20, false) . '>' . esc_html($_var_44) . '</option>';
				}
				$_var_14 .= '</select>';
				$_var_14 .= '<select class="of-background of-background-position" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . '][position]') . '" id="' . esc_attr($_var_11['id'] . '_position') . '">';
				$_var_45 = of_recognized_background_position();
				foreach ($_var_45 as $_var_20 => $_var_46) {
					$_var_14 .= '<option value="' . esc_attr($_var_20) . '" ' . selected($_var_42['position'], $_var_20, false) . '>' . esc_html($_var_46) . '</option>';
				}
				$_var_14 .= '</select>';
				$_var_14 .= '<select class="of-background of-background-attachment" name="' . esc_attr($_var_6 . '[' . $_var_11['id'] . '][attachment]') . '" id="' . esc_attr($_var_11['id'] . '_attachment') . '">';
				$_var_47 = of_recognized_background_attachment();
				foreach ($_var_47 as $_var_20 => $_var_48) {
					$_var_14 .= '<option value="' . esc_attr($_var_20) . '" ' . selected($_var_42['attachment'], $_var_20, false) . '>' . esc_html($_var_48) . '</option>';
				}
				$_var_14 .= '</select>';
				$_var_14 .= '</div>';
				break;
			case 'editor':
				$_var_14 .= '<div class="explain">' . wp_kses($_var_17, $allowedtags) . '</div>' . '
';
				echo $_var_14;
				$_var_49 = esc_attr($_var_6 . '[' . $_var_11['id'] . ']');
				$_var_50 = array('textarea_name' => $_var_49, 'media_buttons' => false, 'tinymce' => array('plugins' => 'wordpress'));
				$_var_51 = array();
				if (isset($_var_11['settings'])) {
					$_var_51 = $_var_11['settings'];
				}
				$_var_51 = array_merge($_var_50, $_var_51);
				wp_editor($_var_12, $_var_11['id'], $_var_51);
				$_var_14 = '';
				break;
			case 'info':
				$_var_15 = '';
				$_var_16 = 'section';
				if (isset($_var_11['id'])) {
					$_var_15 = 'id="' . esc_attr($_var_11['id']) . '" ';
				}
				if (isset($_var_11['type'])) {
					$_var_16 .= ' section-' . $_var_11['type'];
				}
				if (isset($_var_11['class'])) {
					$_var_16 .= ' ' . $_var_11['class'];
				}
				$_var_14 .= '<div ' . $_var_15 . 'class="' . esc_attr($_var_16) . '">' . '
';
				if (isset($_var_11['name'])) {
					$_var_14 .= '<h4 class="heading">' . esc_html($_var_11['name']) . '</h4>' . '
';
				}
				if ($_var_11['desc']) {
					$_var_14 .= apply_filters('of_sanitize_info', $_var_11['desc']) . '
';
				}
				$_var_14 .= '</div>' . '
';
				break;
			case 'heading':
				$_var_9++;
				if ($_var_9 >= 2) {
					$_var_14 .= '</div>' . '
';
				}
				$_var_16 = '';
				$_var_16 = !empty($_var_11['id']) ? $_var_11['id'] : $_var_11['name'];
				$_var_16 = preg_replace('/[^a-zA-Z0-9._\\-]/', '', strtolower($_var_16));
				$_var_14 .= '<div id="options-group-' . $_var_9 . '" class="group ' . $_var_16 . '">';
				$_var_14 .= '<h3>' . esc_html($_var_11['name']) . '</h3>' . '
';
				break;
		}
		if ($_var_11['type'] != 'heading' && $_var_11['type'] != 'info') {
			$_var_14 .= '</div>';
			if ($_var_11['type'] != 'checkbox' && $_var_11['type'] != 'editor') {
				$_var_14 .= '<div class="explain">' . wp_kses($_var_17, $allowedtags) . '</div>' . '
';
			}
			$_var_14 .= '</div></div>' . '
';
		}
		echo $_var_14;
	}
	echo '</div>';
}