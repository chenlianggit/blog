<?php
wp_enqueue_script('jquery');
wp_enqueue_script('bootstrap-script');
wp_enqueue_style('bootstrap-style');
?>
<div class="row">
	<div class="col-lg-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					小蜜蜂-基础版 <a class="label label-success" style="color: #FFF;" href="/wp-admin/admin.php?page=beepress_pro_request">查看专业版</a>
				</h3>
			</div>
			<!--	分类列表	-->
			<?php
			$cats = get_categories(array(
					'hide_empty' => false,
					'order' => 'DESC'
			));
			$types = get_post_types(array(
					'public' => true,
			));

			// 获取自动采集配置
			global $wpdb, $table_prefix;
			global $beepress_cron_table, $beepress_profile_table;
			$beepress_cron_table = $table_prefix.'bp_cron_config';
			$beepress_profile_table = $table_prefix . 'bp_profile';
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			if ($wpdb->get_var("SHOW TABLES LIKE '$beepress_cron_table'") != $beepress_cron_table) {
				$sql = "CREATE TABLE " . $beepress_cron_table . "(
					id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
					token CHAR(200),
					open TINYINT(1) NOT NULL DEFAULT 1,
					PRIMARY KEY(id)
				) COLLATE='utf8_unicode_ci' ENGINE=MyISAM";
				dbDelta($sql);
			}
			$conf = $wpdb->get_row("SELECT * FROM $beepress_cron_table", ARRAY_A);
			$token = '';
			$open = true;
			if ($conf) {
				$token = $conf['token'];
				$open = intval($conf['open']) == 1;
			}


			if ($wpdb->get_var("SHOW TABLES LIKE '$beepress_profile_table'") != $beepress_profile_table) {
				$sql = "CREATE TABLE " . $beepress_profile_table . "(
					id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
					token CHAR(200),
					count SMALLINT(5) NOT NULL DEFAULT 5,
					PRIMARY KEY(id)
				) COLLATE='utf8_unicode_ci' ENGINE=MyISAM";
				dbDelta($sql);
			}
			$profile = $wpdb->get_row("SELECT * FROM $beepress_profile_table", ARRAY_A);
			$count = 0;
			$profileToken = '';
			if ($profile) {
				$count = $profile['count'];
				$profileToken = trim($profile['token']);
			} else {
				$sql = "INSERT INTO " . $beepress_profile_table . " VALUES(1, '', 5)";
				dbDelta($sql);
				$count = 5;
			}

			$secret = 'wiH5voK0FzAl1DVa';
			$homeUrl = home_url();
			$md5Token = md5($secret . $homeUrl);
			?>
			<div class="panel-body">
				<div>
					<ul class="nav nav-tabs">
						<li class="nav-item active" role="presentation" >
							<a class="nav-link active" data-toggle="tab" href="#wechat" role="tab">微信公众号(手动)</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#cron" role="tab">自动同步指定公众号</a>
						</li>
<!--						<li class="nav-item">-->
<!--							<a class="nav-link" data-toggle="tab" href="#history" role="tab">采集所有文章</a>-->
<!--						</li>-->
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#custom" role="tab">插件定制</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#about" role="tab">关于</a>
						</li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="wechat" role="tabpanel">
							<div class="panel panel-default">
								<div class="panel-heading">
									<?php if ($profileToken == $md5Token):?>
										<h4 class="panel-title" style="color: #a94442;">单篇导入｜已授权</h4>
									<?php elseif ($count > 0):?>
										<h4 class="panel-title" style="color: #a94442;">单篇导入｜剩余免费使用次数：<?php echo $count;?></h4>
									<?php else:?>
										<h4 class="panel-title" style="color: #a94442;">单篇导入｜免费使用次数已经用完，请购买永久授权码</h4>
									<?php endif;?>
								</div>
								<div class="panel-body">
									<form method="post">
										如果不知道怎么设置，保留默认就好
										<input type="hidden" name="media" value="wx">
										<div class="form-group">
											<label for="formGroupExampleInput">仅需 29 元，即可获得永久使用授权码，请联系微信:always-bee，注明 授权码</label>
											<input type="text" class="form-control" id="formGroupExampleInput" name="license_code" placeholder="授权码，购买后可永久使用" value="<?php echo $profileToken;?>">
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput">公众号文章地址</label>
											<input type="text" class="form-control" id="formGroupExampleInput" name="post_urls" placeholder="形如 http(s)://mp.weixin.qq.com/s（推荐从搜狗微信中获取链接）">
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">发布时间</label>
											<select class="custom-select" name="change_post_time">
												<option value="false" selected>原文时间</option>
												<option value="true">当前时间</option>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">文章状态</label>
											<select class="custom-select" name="post_status">
												<option value="publish">发布</option>
												<option value="pending">等待复审</option>
												<option value="draft">草稿</option>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">文章分类</label>
											<select class="custom-select" name="post_cate">
												<option value="1" selected>默认分类</option>
												<?php if(count($cats)):?>
													<?php foreach($cats as $cat):?>
														<?php if($cat->cat_ID == 1) continue; ?>
														<option value="<?php echo $cat->cat_ID;?>"><?php echo $cat->cat_name;?></option>
													<?php endforeach;?>
												<?php endif;?>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">文章类型</label>
											<select class="custom-select" name="post_type">
												<?php if(count($types)):?>
													<?php foreach($types as $type):?>
														<option value="<?php echo $type;?>"><?php echo $type;?></option>
													<?php endforeach;?>
												<?php else:?>
													<option value="post" selected>默认类型(post)</option>
												<?php endif;?>
											</select>
										</div>
<!--										<div class="form-group">-->
<!--											<label for="formGroupExampleInput2">图片保存路径</label>-->
<!--											<select class="custom-select" name="image_url_mode">-->
<!--												<option value="default" selected>使用相对路径</option>-->
<!--												<option value="relative">使用绝对路径</option>-->
<!--											</select>-->
<!--										</div>-->
										<div class="form-group">
											<label for="formGroupExampleInput2">保留版权信息</label>
											<select class="custom-select" name="keep_source">
												<option value="keep" selected>保留</option>
												<option value="remove">移除</option>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">保留原文样式</label>
											<select class="custom-select" name="keep_style">
												<option value="keep" selected>保留</option>
												<option value="remove">移除</option>
											</select>
										</div>
<!--										<div class="form-group">-->
<!--											<label for="force">强制导入（正常情况下，标题重复是无法导入的，勾选后将强制导入）</label>-->
<!--											<input name="force" id="force" type="checkbox" value="force">-->
<!--										</div>-->
										<div class="form-group">
											<label for="debug">调试（如果出现出错的情况，勾选可查看调试出错信息）</label>
											<input name="debug" id="debug" type="checkbox" value="debug">
										</div>
										<button type="submit" class="btn btn-primary">确定</button>
									</form>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<?php if ($profileToken == $md5Token):?>
										<h4 class="panel-title" style="color: #a94442;">批量导入(数量不宜过多，最好不超过10条)｜已授权</h4>
									<?php elseif ($count > 0):?>
										<h4 class="panel-title" style="color: #a94442;">批量导入(数量不宜过多，最好不超过10条)｜剩余免费使用次数：<?php echo $count;?></h4>
									<?php else:?>
										<h4 class="panel-title" style="color: #a94442;">批量导入(数量不宜过多，最好不超过10条)｜免费使用次数已用完，请购买授权码</h4>
									<?php endif;?>
								</div>
								<div class="panel-body">
									<form method="post" enctype="multipart/form-data">
										<input type="hidden" name="media" value="wx">
										<div class="form-group">
											<label for="formGroupExampleInput">购买永久授权码，仅需 29 元，请联系微信：always-bee 购买，注明 授权码</label>
											<input type="text" class="form-control" id="formGroupExampleInput" name="license_code" placeholder="授权码，购买后可永久使用" value="<?php echo $profileToken;?>">
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput">从指定URL中导入(默认)</label>
											<textarea class="form-control" name="post_urls" rows="10" placeholder="每行一条文章地址"></textarea>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput">从文件导入(文本形式，每行一条文章地址)</label>
											<input type="file" class="form-control" name="post_file">
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">发布时间</label>
											<select class="custom-select" name="change_post_time">
												<option value="false" selected>原文时间</option>
												<option value="true">当前时间</option>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">文章状态</label>
											<select class="custom-select" name="post_status">
												<option value="publish">发布</option>
												<option value="pending">等待复审</option>
												<option value="draft">草稿</option>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">文章分类</label>
											<select class="custom-select" name="post_cate">
												<option value="1" selected>默认分类</option>
												<?php if(count($cats)):?>
													<?php foreach($cats as $cat):?>
														<?php if($cat->cat_ID == 1) continue; ?>
														<option value="<?php echo $cat->cat_ID;?>"><?php echo $cat->cat_name;?></option>
													<?php endforeach;?>
												<?php endif;?>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">文章类型</label>
											<select class="custom-select" name="post_type">
												<?php if(count($types)):?>
													<?php foreach($types as $type):?>
														<option value="<?php echo $type;?>"><?php echo $type;?></option>
													<?php endforeach;?>
												<?php else:?>
													<option value="post" selected>默认类型(post)</option>
												<?php endif;?>
											</select>
										</div>
<!--										<div class="form-group">-->
<!--											<label for="formGroupExampleInput2">图片保存路径</label>-->
<!--											<select class="custom-select" name="image_url_mode">-->
<!--												<option value="default" selected>使用相对路径</option>-->
<!--												<option value="relative">使用绝对路径</option>-->
<!--											</select>-->
<!--										</div>-->
										<div class="form-group">
											<label for="formGroupExampleInput2">保留版权信息</label>
											<select class="custom-select" name="keep_source">
												<option value="keep" selected>保留</option>
												<option value="remove">移除</option>
											</select>
										</div>
										<div class="form-group">
											<label for="formGroupExampleInput2">保留原文样式</label>
											<select class="custom-select" name="keep_style">
												<option value="keep" selected>保留</option>
												<option value="remove">移除</option>
											</select>
										</div>
<!--										<div class="form-group">-->
<!--											<label for="force">强制导入（正常情况下，标题重复是无法导入的，勾选后将强制导入）</label>-->
<!--											<input hidden name="force" id="force" type="checkbox" value="force">-->
<!--										</div>-->
										<div class="form-group">
											<label for="debug">调试（如果出现出错的情况，勾选可查看调试出错信息）</label>
											<input name="debug" id="debug" type="checkbox" value="debug">
										</div>
										<button type="submit" class="btn btn-primary">确定</button>
									</form>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="cron" role="tabpanel">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title" style="color: #a94442;">自动同步配置，免去你每天需要手动导入的烦恼</h4>
								</div>
								<div class="panel-body">
									<h4 class="panel-title" style="color: #a94442;">注意:基础版和专业版均须额外购买Token，请加微信:always-bee，注明:token</h4>
									<form method="post">
										<input hidden name="setting" value="cron">
										<div class="form-group">
											<label for="formGroupExampleInput">输入Token(密钥，请勿泄漏)</label>
											<input type="text" class="form-control" id="token" name="token" placeholder="请联系微信：always-bee 购买" value="<?php echo $token;?>">
										</div>
										<div class="form-group">
											<label for="debug">是否开启</label>
											<input name="open" id="open" type="checkbox" <?php if($open) echo "checked";else echo "";?>>
										</div>
										<button type="submit" class="btn btn-primary">确定</button>
									</form>
								</div>
								<a href="http://artizen.me/beepress?utm_source=beepress&utm_medium=token" target="_blank">相关说明</a>｜<a href="http://kongbei.io/reading?utm_source=beepress&utm_medium=token" target="_blank">DEMO</a>
							</div>
						</div>
						<div class="tab-pane" id="history" role="tabpanel">
							付费服务：采集指定的公众号的所有历史文章，并且导出为能够使用 小蜜蜂采集插件 批量导入的文本格式
							<h4>如有需要请添加微信：always-bee 注明 历史文章 </h4>
						</div>
						<div class="tab-pane" id="custom" role="tabpanel">
							如果您需要基于 小蜜蜂(BeePress) 进行定制专用插件，可以联系我
							<h4>微信：always-bee 注明 插件定制 </h4>
						</div>
						<div class="tab-pane" id="about" role="tabpanel">
							<h4>使用帮助</h4>
							<ul>
								<li>
									1.批量导入请注意URL条数不宜过多，导致请求超时情况，出现部分文章导入失败
								</li>
								<li>
									2.图片保存到本地，速度会比较慢，请根据自身网络情况选择
								</li>
								<li>
									3.为什么提示导入成功后仍旧看不到文章？可能文章排在后面，按日期排序
								</li>
								<li>
									4.不宜导入过于频繁，避免被微信屏蔽
								</li>
								<li>
									更多问题请访问 <a href="http://xingyue.artizen.me/archives/563">蜜蜂采集(BeePress) FAQs 页面</a>
								</li>
							</ul>
							<h4>免责声明</h4>
							<p>本插件仅负责导入文章的工作，给用户提供方便的途径，请确保您拥有文章的所有权或文章原作者的授权</p>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">Built with ❤️ by Bee｜<a href="http://xingyue.artizen.me/beepresspro?utm_source=<?php echo $homeUrl;?>&utm_medium=footer" target="_blank">小蜜蜂-BeePress 官方网站</a></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-8">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						关注 小蜜蜂(BeePress) 公众号
					</h3>
				</div>
				<div class="panel-body">
					<img width="100%" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAAPoCAYAAABNo9TkAAAgAElEQVR4nOzdbWxl950f9u+5fJwHajSSLEtD27L8JMpPu16bsrfZrG1N7F0kWWjaOts09SAYIGgiFbXQNvWggNoihd7IQFHIKEYo+mKAaFOkgZOONskidnbs7G633hUd767W69CPWtnm2HqWxXkkhzx9ce+593BmNEPOXPIe8n4+gMQ7h+S9/3t4Li+/5/c7/39RlmUZAAAAYKBagx4AAAAAIKADAABAIwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAAwjoAAAA0AACOgAAADSAgA4AAAANIKADAABAA4wOegBbaXFxMUkyPz+/5Y89NTXVvT0zM7Plj19/ztV+uJoDBw50b09PT2/KmK5mbm5uw99T7df6vt5sN3JMzc7O9ns417SwsNC9ferUqWt+/aCP2+023o2+zpLea83r7I15nW0u7w+bw3G7ubbbcev9YXN4nW2u6zlu+6n+nLfyuBo0FXQAAABogKIsy3LQg9gq1dnAI0eObPlj18/SHT9+fMsfv/6c13NW9PDhw93bR48e3ZQxXc373//+DX/P448/niQ5ePBgv4fzhm7kmPryl7+cZGvPjB87duyKt99I/Wzl17/+9U0Z09U8/PDD3dsnT5685tcP+nX2a7/2a93b9bPkV/PQQw+t+bgVqrPgv/zLv7zh763261ZWHqqfff14WK9vfetb/R7ONW30dTbo43aj7w/1Y3Urj9vK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qmBer5FXoXvNden17H9Zlb69tahS+WXd8O07qlre906O5P737k5RFPntZ87mmz9eysWV69rVAOwA9Rx18ODBAY5k+xDQAWAd9k0WmbljNH/zF/bkfQcmkvTq2OmsO15N2taunBcpirIqeKfoVNPr7c/1a8KTNVPItYN6WT1KOwR31z7vLrfW+cwV7q9dNK++txeks+bxamOphfZuUK+deKhOFPRG05ukriyqRynzrtsnMjXRykiryGiryNefvZBhvCxbmzsA10NAB4CruGmyyC+8ZSy/9t5duf/ePZm5c/yysFutJ17/f3eZs+qy86xtg+/Nol4LxpdNHFemrFXQew/QjuG9ann9REF6l7+vKbOnt6xb91L4K1/dvnaMtRJ70TtxUK/OF+mF+PHRMm+5ZSx/96/clL/23l35b//Zy3lmYTmvn1vd8cuwXXotOgBslIC+Dk888cSghwDQOMNyze29d4zmU/fuyv0zu3P3m8ZSrSPea0G/Qn5eU43uNJeXnSBb1JY2K9ZG4qJYW3ktq8cqevd06dJoZZHqf2uWSesF9dr31aebu+Tr0nns9lrr9aBfXDau1J9bd/67oltdL4pkcqy9FNtvfHB3WsXZ/NGzF3Lh4g3+MADYVuo5Sov7+gjoAPAGJkaT+2d25eP37M7dt49nYrQ39Xp3bvUrtTLXZ2jvpNhuK3sVrju328uj1dvj107r3i6Qd65tT9U6X6yphBedIF1via/GUJ1Q6F6jXl2G3vm+aluZ3ri695361/aq5Je25veedqeyX7bveLyz/y5cLPPq2ZU8syChA8DVCOhX8cgjjyRJ5ufnBzwSgGbZ6dXz0VZy654iv/beXXnwEzdnanLk0u7vJFcI551286q9fM3s670rydPtEa/VtauAXO8f74XnXhzuNrfXyu+9K83L7iNUX1zWr0OvTit0g3aZoiwuCfi9Lvqq3t5t6C9619p3/tlN8dW191UFvUr573zzeP7uvtH8R++czN/7xy/mL19e2dGt7vU2d9ehA8OunqOqbPXoo48OajjbwpAtggIA13brniKfePdk/voH9mTvxEinxby6lry6vTZ8tYNw0k6rvQp3u7297Fapy3r6LTpflPpK5b3KfPufZa9tvvN93RB8iXbbfNG9Jr27jnone3fb1tcE7V7w77a611rY62cmiqqSnur+ejukGmNZS/nV856aHMl77pjIfXeP59Y9xdAtwQYA66WCDgCXeN+B8fzND+7JfXfvSlprlzargvnacN65sablvHP1eVG1iZfdanP9evLOPaSa4K2oAnI3+7Yr3Rculjl9fiXLK2WWVspcXElWymR1tf1Io60irU7Vfc94kbGRIuOjRfZMtNI9AVC7hLx7PXr9IvqiPpzu1fOdFv16N0DnyzvXqlct+HVVW3x1d7snWvnEPbvz4uJK/vTHy3nl7E6uowPA9RHQOxYWFpIkX/jCF7rbrH8OcLmd3N4+2kreun8k//Nv3JJ3v3k8k2NvfK15Pa5Ws7j3LiGvl9rTroLXwmpSpKiuP096re2dtvOVleTnZ1fy7ItL+ePnLuSF18s8//rF/OTVpZy5UOb0hTJnl8osr7T/W11Ndo23MtJKWq3kjqmR7JkosneilXfcNp7bbypy577RfOwdu/LmfaMZaV1ege+efKgmskt666lXHzsXpPeWe2s/o7X5vrYUXPf5F2kVZf7jD+3NB6fH8/9883T+15OLO3b5NW3uAJc7ceJEkmRxcbG77fOf/3ySZHp6eiBjaiIBHQDSDqj7dxeZfft43nrLaCbH2v3e3U7zS5YsuzxylbUw3/vStVOq1b+ruOROiixfXM3Pz67kT360lIVXL+Y7P1vK//fs+fzs9dV2IL/YDr2rZe8xqhB8emm1O67nX1/tds/fNLmU26daecvNI3n+9ZXcddtY7tw3kvcdmMjYSKcToEjv5EJ3lrjecNdcv77mJMXaddRTO9GQsvr63umKsdEib7llLL/y7l35x398Ji8u7vyl1wBgI4YqoFdV8qeeeipJMjc31/1c/TYAw2e8lbzjttF88p5d2bd7ZO3a5PWVwqt53JJcNvt6fZmyTvTsxfOicx15OqG1F3pXyzJnL5R55czF/IeFC/nCv30tf/nyas5eWM1yp5X9WurV6JWV3u0XT6/mlTOr+e4LF/P0c0u5bU8rH7t7PA//tVty696R7J5oZWwknep9NdJizfmE+sN32/Wr0VczxHefa20/db67WiquSDI12cq9Byby/jtH8wdnl7JcG+tOoooOcGX1LuXq9uzsbHdbdfuBBx7obhumCvtQBXS4krKBPZb9/EOuic+vX3byc0scB1vt/nsm81/dvy8fettkWkWvTbvoLi5e9pZOK7oxtLetalG/5Hrs7pJq9c93Jm97/exKvv/CUuaePZ9/Onc6z71yMa+fb1fI+2mlbIf2V8+2lzv73ovncuKZU7n71pHce8d4/ouP7c37pydz85729erVLPTd8L2mPb/+7/qa7dV3XtpjcMnV60XypqnR/Def2p879y3mX3/rXF475/jcKk38veLkxfrZV9fWxGMcNkJAB2DojbaSX3/frtx921h2jdcmhKtViMuyt5BZfVK0bvys/x1Xlr1Z0VO7lrv6jrLM2aXVfP0H5/KH3zuX3/0P5/K9F1faretb9JxPny/zFz+9mO+/uJKJ0eS1s2Xee2A8t0+NZGrXSC45z1AL2WVtSbZLJ56rT31XndDoXe9eTX5XFMk9d4zlr713V775k6W8ds766ACQDFlAP3XqVJLk2LFjAx4JwPa0EyeIG2m1rz3/5Mzu3Lp3ZE31pR6ye9dWX5Jci14luR5Qy7IWWruZtT37+unzK/nuz5bzxO+9nu+9sJxXz6yuq429n8okK6vJuaUy/+bb5/Od5y/mV941kU/eszuz79jVbnsvi1qo7l2YXiRrlp4ruiG96FXZa0vB1SevLzrB/eY9o3nPHeP5wPRY/sNPBXSAYXalS4/rbe9a3AFgCLSK5Pa9rfzt2T2ZvmUsrdaVWyO7Ld+1j/WZ1K74XUXZXYe8+oLv/mwpTz97Pv/uO+cy99yF/PjV1X4+netSJnlhcTUvLC5l7rml/OM/OpP/7lM35WPv2JX3HhjP2Girt3Z77Vry7hmIWvt7bV657nXXZf2bOvdTJBkdSd51+3j+4af25//93oW8eHp1x16PDgDr1Rr0AABgUHaNJXffNpKP3D3ZXWasuuawTOffWdt3XqbsfN3aWF6W7cnQqu9tp9peNf3c0mp+55nT+T//4PX8iz8914hwfqnVsj2p3P/x+6/nn829nudeXM5qre++rCZ86yzH1g3q9Y/dm9UlAFUfQfWJzomLsszYSHtW94+9fTx7xl1bCwACOgDrshPb2++4aSSfvGdX3vWmse5kcGsWQiuKFGVtGbGyat2utW9XM5p31gkvO9efF0XZDf3nl1fzZz8+n3/xp2fz7MvNLxP/9PXV/O53zud//3evZfHcaueERFJ1A/Ra2YvLOwu669L17m/t19SCe1FkbKTIL921KzfvbuUNGhi2rfprxmRTAKyHFncAhlKraM/cfuhDU3nn7WOdFu1qpvVqkrjaDO1l0V1z/LJrq5P2xHDVxHKpcmqZP/nR+fyrPzudr37nfL51antca31+Ofnu8yv54Utns2/y1fzGL+zJPXeOZ+9k57z+2ovz185cX7QnxVszZ156y9G1T1x0p9vLyEiRT79/V84ur+T/evpM/nIbnMAAgM2igg7AUBobST72joncvLtVW1KsWBPAe63ZvYp5VRVPqpzaWwe9rH1dkpxfLnPy22fzu/Pn870Xtkc4r7u4kvybb5/Nl765mO8/v9TZWnRniOs0FXRnw+vOa98J6el+1aWXA6QX2JPctnc0771zIrftHdnspwQAjSagAzCUJsda+dDbJjNVVYWr1co7ybK3Xnl6S4nVFvOudyxXob02WXtWVpNnX1zKl799Lj94cSXnljfxyWyi515Zye9990Ke+rPT3fXZy26xvOxOk9db9XxtOC/rn6sq77012VImmZps5a7bxvKu23d2Y582dwCuRUAH4Jp22vXnI63kLTe38uabxjI+ura6W8XJ9nXmtV72+tcUl6wRXvaWWUuSldUyL75+Mb/33XP5zgsXc2756sGsXUUu8v4DI/n4u8cze9dY3n37SPZO9O+i7FaR3HVLKx99+1g+8e7xfODAaN60t8j4NYrWFy4mz71yMV/7zvn84IWl3omLTum83clfdj+2ld3LAbqfqz5dO/FRdJZdG2klt+0dyX1vH7/yjPjb2E577QCwuXb2qWoAuESRZM94kd/8yJ5MjBfdVutL27CTdENmt0JeLSm25nZtgrTOh/lTF/K//e5r+cMfXsiZC28czltF8qapVj5y13j++0/tz817RrJ7vMjF1TLnlsq88PpK/qfffjl/cWo555YvO0+wLrvHi9x962h+/X278puzU5maLDI6UuT8cplXz67kL35yIf/jb7+W186+8Vrs55aTb526mC/8m1fzX/7Vm3LPnRO5afdI7ykXl+y7oldPr83h3q2gd7eVnZBeFHnT1Eh+8yP78r/869fz+rnVbrUeAIbJUAX0qampJL1F7+fm5gY5HAAGYHQkuWmyyLtun0hrzURwbb3wXXavPa/WQa/mQut+Pp3PV9etd9q2//D7Z/MnP17Ky6evvpTa3okiHzwwlt/8yN68d3oioyPpXg+/mjIHbh7N33j/7rx85nR+8upKlq5j/rR33Daa/+QXd+dX79mVd90+VpvLrcid+0Zz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YIl7CVpbW8c87urqqtRwiIiIiIiIfCsWiwHwxlFUGmbQiYiIiIiIiHyAGfQJamlpAcAMOhERERERUT5cUm3ymEEnIiIiIiIi8gEG6EREREREREQ+wBL3Cero6Kj0EIiIiIiIiHyLMdPkMYNORERERERE5APMoJeAd4CIiIiIiIgmxoyjtm3bVsGRTB/MoBMRERERERH5AAN0IiIiIiIiIh9giXsJnnjiiUoPgYiIiIiIaFox46j9+/dXcCTTBwN0mlJCiLIdS0pZtmP5jV+vU7nGVa4x+fE6+XFMQHnH5Td+vOZ+HBPgv8+BH8/Nj2OiqefXf2PM5M+5X6850VRjgF7EU089BYBN4oiIiIiIiCbKjKNUNv3hhx+u1HCmBc5BJyIiIiIiIvIBBuhEREREREREPsASd8fQ0BAA4LHHHtPbDhw4UKnhEBERERERzRiqxL27u1tve+SRRwAAsVisImPyI2bQiYiIiIiIiHygqjLoXV1dAICnn34agPfuzXPPPQfAzaQTERERERFReZlVyioGa29v19taWloAALt379bbWltbp2h0lccMOhEREREREZEPMEAnIiIiIiIi8oGqKnFXJe2qQQERERERERFVhppenK8597Zt2/RjlrgTERERERER0ZRigE5ERERERETkAwzQiYiIiIiIiHyAAToRERERERGRDzBAJyIiIiIiIvIBBuhEREREREREPsAAnYiIiIiIiMgHGKATERERERER+UCo0gOYSrFYDIC70H1XV1clh0NEREREREQGFaup2K3aVFWATpUnpSzbsYQQZTlOOcfkR+W6TkD5rlU5x+Q3M/3z5Mc/wzT1/Pg59+OYysmPf178OKZy8eu5+fFz7scxEU1nLHEnIiIiIiIi8oGqyqC3tbUBAA4ePAgAGBoa0s899dRTnq+5zxMREREREdG1MUvXv/zlL3u+5j5fjZhBJyIiIiIiIvKBqsqg5zLvzjz88MMAvHdv9u7dCwDo7Oyc2oERERERERHNIKqaef/+/XpbtWfL82EGnYiIiIiIiMgHGKATERERERER+UBVl7jnY5ZZqPKLXbt26W1sHEdERERERDS+fLEVy9qLYwadiIiIiIiIyAeYQS9C3d155JFH9LZ9+/ZVajhERERERETThhlHMXNeGmbQiYiIiIiIiHyAAToRERERERGRD7DEvQTt7e36MUvc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">
				</div>
				<div class="panel-footer">
					第一时间获取 小蜜蜂(BeePress) 相关消息
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-primary" style="border-color: #000">
				<div class="panel-heading" style="background-color: #000">
					<h3 class="panel-title">
						星月主题 - 仅售 99 元
					</h3>
				</div>
				<div class="panel-body">
					<a href="http://xingyue.artizen.me?utm_source=beepress" target="_blank">
						<img title="星月主题，点击查看详情" alt="星月主题，点击查看详情" src="data:image/png;base64,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" width="100%">
					</a>
				</div>
				<div class="panel-footer">
					一款简洁、大方、现代的 WordPress 主题，专为自媒体、个人站长等用户群体打造，<a style="color: red;" href="http://xingyue.artizen.me?utm_source=beepress" target="_blank"><strong>了解详情</strong></a>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						BeeStudio｜专注于轻量级网站开发
					</h3>
				</div>
				<div class="panel-body">
					<p>BeeStudio 是我的个人工作室，如果您有网站开发、插件定制、网站维护等需求，欢迎前来咨询</p>
					<p><a style="font-weight: bolder;" href="http://beestudio.artizen.me?utm_source=beepress" target="_blank">BeeStudio 官网</a></p>
				</div>
			</div>
		</div>
	</div
</div>
