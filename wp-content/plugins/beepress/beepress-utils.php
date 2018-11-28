<?php
/**
 * Class BeePressUtils
 * 作者：Bee
 * 邮箱：bsn.huang@gmail.com
 * 版权：本代码所有权归作者所有，未经授权，不得使用
 */

class BeePressUtils
{
	// 过滤空白字符，包括空行
	public function content_filter_blank($content = '')
	{
		$content = preg_replace('/<br[^>|.]*>/', '', $content);
		$content = preg_replace('/<p>[\s]*<\/p>/', '', $content);
		$content = preg_replace('/<section>[\s]*<\/section>/', '', $content);
		$content = preg_replace('/&nbsp;/','', $content);
		return $content;
	}

	// 去除一些无效属性
	public function remove_useless_attrs($content = '')
	{
		$content = preg_replace('/data\-([a-zA-Z0-9\-])+\=\"[^\"]*\"/', '', $content);
		$content = preg_replace('/powered\-by\=\"[^\"]*\"/', '', $content);
		return $content;
	}

	// 过滤链接
	public function remove_link($content = '', $keepText = false)
	{
		if ($keepText) {
			$content = preg_replace('/<a[^>]*>(.*?)<\/a>/i', '$1', $content);
			return $content;
		} else {
			$content = preg_replace('/<a[^>]*>(.*?)<\/a>/i', '', $content);
			return $content;
		}
	}
}
