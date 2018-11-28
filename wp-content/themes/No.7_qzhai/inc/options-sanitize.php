<?php  add_filter('of_sanitize_text','sanitize_text_field');
error_reporting(0);
function of_sanitize_textarea($v_1)
{
	global$allowedposttags;
	$var_117=wp_kses($v_1,$allowedposttags);
	return $var_117;
}
add_filter(of_sanitize_textarea,of_sanitize_textarea);
add_filter('of_sanitize_select',of_sanitize_enum,10,2);
add_filter('of_sanitize_radio',of_sanitize_enum,10,2);
add_filter('of_sanitize_images',of_sanitize_enum,10,2);
function of_sanitize_checkbox($v_2)
{
	if($v_2)
	{
		$var_118=1;
	}
	else
	{
		$var_118=false;
	}
	return $var_118;
}
add_filter(of_sanitize_checkbox,of_sanitize_checkbox);
function of_sanitize_multicheck($v_3,$v_4)
{
	$var_119=array();
	if(is_array($v_3))
	{
		foreach($v_4['options'] as $var_120=>$var_121)
		{
			$var_119[$var_120]=0;
		}
		foreach($v_3 as $var_120=>$var_121)
		{
			if(array_key_exists($var_120,$v_4['options'])&& $var_121)
			{
				$var_119[$var_120]=1;
			}
		}
	}
	return $var_119;
}
add_filter(of_sanitize_multicheck,of_sanitize_multicheck,10,2);
add_filter('of_sanitize_color',of_sanitize_hex);
function of_sanitize_upload($v_5)
{
	$var_123='';
	$var_1=wp_check_filetype($v_5);
	if($var_1['ext'])
	{
		$var_123=$v_5;
	}
	return $var_123;
}
add_filter(of_sanitize_upload,of_sanitize_upload);
function of_sanitize_editor($v_6)
{
	if(current_user_can('unfiltered_html'))
	{
		$var_125=$v_6;
	}
	else
	{
		global$allowedtags;
		$var_125=wpautop(wp_kses($v_6,$allowedtags));
	}
	return $var_125;
}
add_filter(of_sanitize_editor,of_sanitize_editor);
function of_sanitize_allowedtags($v_7)
{
	global$allowedtags;
	$var_127=wpautop(wp_kses($v_7,$allowedtags));
	return $var_127;
}
function of_sanitize_allowedposttags($v_8)
{
	global$allowedposttags;
	$var_129=wpautop(wp_kses($v_8,$allowedposttags));
	return $var_129;
}
add_filter('of_sanitize_info',of_sanitize_allowedposttags);
function of_sanitize_enum($v_9,$v_10)
{
	$var_131='';
	if(array_key_exists($v_9,$v_10['options']))
	{
		$var_131=$v_9;
	}
	return $var_131;
}
function of_sanitize_background($v_11)
{
	$var_132=wp_parse_args($v_11,array('color'=>'','image'=>'','repeat'=>'repeat','position'=>'top center','attachment'=>'scroll'));
	$var_132['color']=apply_filters(of_sanitize_hex,$v_11['color']);
	$var_132['image']=apply_filters(of_sanitize_upload,$v_11['image']);
	$var_132['repeat']=apply_filters('of_background_repeat',$v_11['repeat']);
	$var_132['position']=apply_filters('of_background_position',$v_11['position']);
	$var_132['attachment']=apply_filters('of_background_attachment',$v_11['attachment']);
	return $var_132;
}
add_filter(of_sanitize_background,of_sanitize_background);
function of_sanitize_background_repeat($v_12)
{
	$var_134=of_recognized_background_repeat();
	if(array_key_exists($v_12,$var_134))
	{
		return $v_12;
	}
	return apply_filters('of_default_background_repeat',current($var_134));
}
add_filter('of_background_repeat',of_sanitize_background_repeat);
function of_sanitize_background_position($v_13)
{
	$var_136=of_recognized_background_position();
	if(array_key_exists($v_13,$var_136))
	{
		return $v_13;
	}
	return apply_filters('of_default_background_position',current($var_136));
}
add_filter('of_background_position',of_sanitize_background_position);
function of_sanitize_background_attachment($v_14)
{
	$var_103=of_recognized_background_attachment();
	if(array_key_exists($v_14,$var_103))
	{
		return $v_14;
	}
	return apply_filters('of_default_background_attachment',current($var_103));
}
add_filter('of_background_attachment',of_sanitize_background_attachment);
function of_sanitize_typography($v_15,$v_16)
{
	$var_139=wp_parse_args($v_15,array('size'=>'','face'=>'','style'=>'','color'=>''));
	if(isset($v_16['options']['faces'])&& isset($v_15['face']))
	{
		if(!(array_key_exists($v_15['face'],$v_16['options']['faces'])))
		{
			$var_139['face']='';
		}
	}
	else
	{
		$var_139['face']=apply_filters('of_font_face',$var_139['face']);
	}
	$var_139['size']=apply_filters('of_font_size',$var_139['size']);
	$var_139['style']=apply_filters('of_font_style',$var_139['style']);
	$var_139['color']=apply_filters('of_sanitize_color',$var_139['color']);
	return $var_139;
}
add_filter(of_sanitize_typography,of_sanitize_typography,10,2);
function of_sanitize_font_size($v_17)
{
	$var_141=of_recognized_font_sizes();
	$var_142=preg_replace('/px/','',$v_17);
	if(in_array((int) $var_142,$var_141))
	{
		return $v_17;
	}
	return apply_filters('of_default_font_size',$var_141);
}
add_filter('of_font_size',of_sanitize_font_size);
function of_sanitize_font_style($v_18)
{
	$var_144=of_recognized_font_styles();
	if(array_key_exists($v_18,$var_144))
	{
		return $v_18;
	}
	return apply_filters('of_default_font_style',current($var_144));
}
add_filter('of_font_style',of_sanitize_font_style);
function of_sanitize_font_face($v_19)
{
	$var_146=of_recognized_font_faces();
	if(array_key_exists($v_19,$var_146))
	{
		return $v_19;
	}
	return apply_filters('of_default_font_face',current($var_146));
}
add_filter('of_font_face',of_sanitize_font_face);
function of_recognized_background_repeat()
{
	$var_148=array('no-repeat'=>'不重复填充','repeat-x'=>'水平重复填充','repeat-y'=>'垂直重复填充','repeat'=>'重复填充');
	return apply_filters(of_recognized_background_repeat,$var_148);
}
function of_recognized_background_position()
{
	$var_150=array('top left'=>'上左对齐','top center'=>'上中对齐','top right'=>'上右对齐','center left'=>'中左对齐','center center'=>'中中对齐','center right'=>'中右对齐','bottom left'=>'下左对齐','bottom center'=>'下中对齐','bottom right'=>'下右对齐');
	return apply_filters(of_recognized_background_position,$var_150);
}
function of_recognized_background_attachment()
{
	$var_152=array('scroll'=>'固定','fixed'=>'滚动');
	return apply_filters(of_recognized_background_attachment,$var_152);
}
function of_sanitize_hex($v_20,$v_21="")
{
	if(of_validate_hex($v_20))
	{
		return $v_20;
	}
	return $v_21;
}
function of_recognized_font_sizes()
{
	$var_154=range(12,24,2);
	$var_154=apply_filters(of_recognized_font_sizes,$var_154);
	$var_154=array_map('absint',$var_154);
	return $var_154;
}
function of_recognized_font_faces()
{
	$var_156=array('arial'=>'Arial','verdana'=>'Verdana, Geneva','trebuchet'=>'Trebuchet','georgia'=>'Georgia','times'=>'Times New Roman','tahoma'=>'Tahoma, Geneva','palatino'=>'Palatino','helvetica'=>'Helvetica*');
	return apply_filters(of_recognized_font_faces,$var_156);
}
function of_recognized_font_styles()
{
	$var_158=array('normal'=>'普通','italic'=>'斜体','bold'=>'粗体','bold italic'=>'斜体+粗体');
	return apply_filters(of_recognized_font_styles,$var_158);
}
function of_validate_hex($v_22)
{
	$v_22=trim($v_22);
	if(0===strpos($v_22,'#'))
	{
		$v_22=substr($v_22,1);
	}
	elseif(0===strpos($v_22,'%23'))
	{
		$v_22=substr($v_22,3);
	}
	if(0===preg_match('/^[0-9a-fA-F]{6}$/',$v_22))
	{
		return false;
	}
	else
	{
		return true;
	}
}
?>
