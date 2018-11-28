<div class="container-fluid">
	<div class="page-header">
		<h3>小蜜蜂-专业版 <small id="auth" class=""></small></h3>
		<h5 id="az-license-info">限时优惠：仅需 <span style="color: red">35</span> 元支持我维护 小蜜蜂，即可获得永久使用授权码，请联系微信:always-bee，注明 授权码</h5>
		<a href="<?php echo home_url();?>/wp-admin/admin.php?page=beepress_pro_option">配置(授权码)</a> ｜
		<a target="_blank" href="http://xingyue.artizen.me/beepresspro?m=bpp&s=<?php echo home_url();?>">小蜜蜂官网</a>
	</div>
	<input type="text" hidden id="request_url" value="<?php echo admin_url( 'admin-ajax.php' );?>">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">媒体平台</th>
			<td>
			目前支持微信公众号、知乎专栏文章、简书文章、今日头条文章导入，更多平台陆续增加<br>
			<i style="color: red">*如果不知如何设置，那么保留默认即可，仅需粘贴文章链接点击【开始采集】按钮</i>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">文章链接</th>
			<td>
				<textarea cols="100" rows="10" id="post-urls" name="urls" placeholder="在此处输入文章链接，每行一条链接"></textarea>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">文章状态</th>
			<td>
				<?php
				$bp_post_status = get_option('bp_post_status', 'publish');
				?>
				<input type="radio" <?php if($bp_post_status == 'publish') echo 'checked';?> value="publish" name="post_status"> 直接发布
				<input type="radio" <?php if($bp_post_status == 'pending') echo 'checked';?> value="pending" name="post_status"> 待审核
				<input type="radio" <?php if($bp_post_status == 'draft') echo 'checked';?> value="draft" name="post_status"> 草稿
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">跳过重复的文章</th>
			<td>
				<input type="radio" value="yes" name="skip_duplicate"> 是
				<input type="radio" checked value="no" name="skip_duplicate"> 否
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">自定义图片 Title 和 Alt 属性值</th>
			<td>
			<input style="width:450px" placeholder="默认为文章标题，若填写，则覆盖配置中设置，否则以配置中的为准" type="text" name="image_title_alt" value="<?php echo esc_attr( get_option('bp_image_title_alt') );?>" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">移除文中的链接</th>
			<td>
				<input <?php echo get_option('bp_remove_outerlink', 'no') == 'no' ? 'checked' : '';?> class="form-check-input" type="radio" name="remove_outerlink" value="no" > 否
				<input <?php echo get_option('bp_remove_outerlink', 'no') == 'keepcontent' ? 'checked' : '';?> class="form-check-input" type="radio" name="remove_outerlink" value="keepcontent"> 移除链接，保留内容
				<input <?php echo get_option('bp_remove_outerlink', 'no') == 'all' ? 'checked' : '';?> class="form-check-input" type="radio" name="remove_outerlink" value="all"> 移除链接和内容
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">移除所有图片</th>
			<td>
				<input type="radio" value="yes" name="remove_image"> 移除
				<input type="radio" checked value="no" name="remove_image"> 保留
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">去除指定位置图片</th>
			<td>
				<input type="checkbox" value="1" name="remove_specified_image[]"> 第1
				<input type="checkbox" value="2" name="remove_specified_image[]"> 第2
				<input type="checkbox" value="3" name="remove_specified_image[]"> 第3
				<input type="checkbox" value="4" name="remove_specified_image[]"> 第4<br><br>
				<input type="checkbox" value="-1" name="remove_specified_image[]"> 倒数第1
				<input type="checkbox" value="-2" name="remove_specified_image[]"> 倒数第2
				<input type="checkbox" value="-3" name="remove_specified_image[]"> 倒数第3
				<input type="checkbox" value="-4" name="remove_specified_image[]"> 倒数第4<br>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">移除空白字符(包括空行)</th>
			<td>
				<input type="radio" value="yes" name="remove_blank"> 移除
				<input type="radio" checked value="no" name="remove_blank"> 保留
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">发布类型</th>
			<td>
				<?php
				$types = get_post_types(array(
					'public' => true,
				));
				$typeMap = array(
					'post' => '文章',
					'page' => '页面',
				);
				?>
				<?php foreach ($types as $type):?>
					<?php
						if (in_array($type, array('attachment'))) continue;
						$typeName = isset($typeMap[$type]) ? $typeMap[$type] : $type;
					?>
					<?php if ($type == 'post'):?>
						<input type="radio" name="post_type" value="<?php echo $type;?>" checked><?php echo $typeName;?>&nbsp;&nbsp;
					<?php else: ?>
						<input type="radio" name="post_type" value="<?php echo $type;?>"><?php echo $typeName;?>&nbsp;&nbsp;
					<?php endif;?>
				<?php endforeach;?>
			</td>
		</tr>
<!--		<tr valign="top">-->
<!--			<th scope="row">文章标签</th>-->
<!--			<td>-->
<!--				--><?php
//				$tags = get_tags(array(
//					'hide_empty' => false
//				));
//				?>
<!--				--><?php //foreach ($tags as $tag):?>
<!--					<input type="checkbox" name="post_tag[]" value="--><?php //echo $tag->term_id;?><!--">--><?php //echo $tag->name;?><!--&nbsp;&nbsp;-->
<!--				--><?php //endforeach;?>
<!--			</td>-->
<!--		</tr>-->
		<tr valign="top">
			<th scope="row">文章分类</th>
			<td>
				<?php
				$cats = get_categories(array(
						'hide_empty' => false,
						'order' => 'ASC',
						'orderby' => 'id'
				));
				?>
				<?php foreach ($cats as $cat):?>
					<input type="checkbox" name="post_cate[]" value="<?php echo $cat->cat_ID;?>"><?php echo $cat->cat_name;?>&nbsp;&nbsp;
				<?php endforeach;?>
			</td>
		</tr>
	</table>
	<input type="submit" value="开始采集" class="button button-primary" id="bp-submit"><p></p>
	<div class="progress">
		<div id="progress-status" class="progress-bar active progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" style="width: 0%;">
		</div>
	</div>
	<div class="result">
		<h4>采集结果</h4>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-inverse">
				<tr>
					<th>#</th>
					<th>结果</th>
					<th>操作</th>
					<th>链接</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	<?php if(!get_option('bp_license_code')):?>
		<img src="http://artizen.me/wp-content/uploads/2018/03/stat.jpg?url=<?php echo home_url();?>">
	<?php endif;?>
</div>