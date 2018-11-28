<?php
error_reporting(0);
  if(!function_exists(optionsframework_uploader)):function optionsframework_uploader($v_1,$v_2,$v_3="",$v_4="")
{
	$var_102=get_option('optionsframework');
	if(isset($var_102['id']))
	{
		$var_103=$var_102['id'];
	}
	else
	{
		$var_103='options_framework_theme';
	}
	;
	$var_104='';
	$var_105='';
	$var_106='';
	$var_107='';
	$var_108='';
	$var_109='';
	$var_105=strip_tags(strtolower($v_1));
	if($v_2!=''&& $var_108=='')
	{
		$var_108=$v_2;
	}
	if($v_4!='')
	{
		$var_109=$v_4;
	}
	else
	{
		$var_109=$var_103.'['.$var_105.']';
	}
	if($var_108)
	{
		$var_106=' has-file';
	}
	$var_104.= '<input id="'.$var_105.'" class="upload'.$var_106.'" type="text" name="'.$var_109.'" value="'.$var_108.'" placeholder="'.__('未选择文件','options_framework_theme').'" />'."\n";
	if(function_exists('wp_enqueue_media'))
	{
		if(($var_108==''))
		{
			$var_104.= '<input id="upload-'.$var_105.'" class="upload-button button" type="button" value="'.__('上传','options_framework_theme').'" />'."\n";
		}
		else
		{
			$var_104.= '<input id="remove-'.$var_105.'" class="remove-file button" type="button" value="'.__('移除','options_framework_theme').'" />'."\n";
		}
	}
	else
	{
		$var_104.= '<p><i>'.__('Upgrade your version of WordPress for full media support.','options_framework_theme').'</i></p>';
	}
	if($v_3!='')
	{
		$var_104.= '<span class="of-metabox-desc">'.$v_3.'</span>'."\n";
	}
	$var_104.= '<div class="screenshot" id="'.$var_105.'-image">'."\n";
	if($var_108!='')
	{
		$var_110='<a class="remove-image">Remove</a>';
		$var_111=preg_match('/(^.*\\.jpg|jpeg|png|gif|ico*)/i',$var_108);
		if($var_111)
		{
			$var_104.= '<img src="'.$var_108.'" alt="" />'.$var_110.'';
		}
		else
		{
			$var_112=explode('/',$var_108);
			for($var_113=0;$var_113<sizeof($var_112);
			++$var_113)
			{
				$var_114=$var_112[$var_113];
			}
			$var_104.= '';
			$var_114=__('View File','options_framework_theme');
			$var_104.= '<div class="no-image"><span class="file_link"><a href="'.$var_108.'" target="_blank" rel="external">'.$var_114.'</a></span></div>';
		}
	}
	$var_104.= '</div>'."\n";
	return $var_104;
}
endif;
if(!function_exists(optionsframework_media_scripts)):add_action('admin_enqueue_scripts',optionsframework_media_scripts);
function optionsframework_media_scripts($v_5)
{
	$var_116=optionsframework_menu_settings();
	if('appearance_page_'.$var_116['menu_slug']!=$v_5)return;
	if(function_exists('wp_enqueue_media'))wp_enqueue_media();
	wp_register_script('of-media-uploader',OPTIONS_FRAMEWORK_DIRECTORY.'js/media-uploader.js',array('jquery'));
	wp_enqueue_script('of-media-uploader');
	wp_localize_script('of-media-uploader','optionsframework_l10n',array('upload'=>__('上传','options_framework_theme'),'remove'=>__('移除','options_framework_theme')));
}
endif;
?>
