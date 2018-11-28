<?php

//禁止直接访问
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<input type="hidden" name="ws_meta_box_nonce" value="<?php echo wp_create_nonce( 'wx-custom-share' ) ?>">
<table class="form-table wxcs-metabox">
	<tr>
		<th><label for="ws-title"><?php _e('Title','wx-custom-share') ?></label></th>
		<td>
			<input type="text" name="ws-title" id="ws-title" value="<?php echo $title['meta'] ?>" autocomplete="off" placeholder="<?php echo $title['default'] ?>">
			<p class="description">
				<?php echo $tips[$type]['title'] ?>
			</p>
		</td>
	</tr>
	<tr>
		<th><label for="ws-desc"><?php _e('Description','wx-custom-share') ?></label></th>
		<td>
			<input type="text" name="ws-desc" id="ws-desc" value="<?php echo $desc['meta'] ?>" autocomplete="off" placeholder="<?php echo $desc['default'] ?>">
			<p class="description">
				<?php echo $tips[$type]['desc'] ?>
			</p>
		</td>
	</tr>
	<tr>
		<th><label for="ws-url"><?php _e('Link URL','wx-custom-share') ?></label></th>
		<td>
			<input type="text" name="ws-url" id="ws-url" value="<?php echo esc_url($url['meta']) ?>" autocomplete="off" placeholder="<?php echo $url['default'] ?>">
			<label><input type="checkbox" name="ws-use-actual-url" <?php checked( $use_actual_url ) ?>><?php _e('Actual URL','wx-custom-share') ?></label>
			<p class="description">
				<?php echo $tips[$type]['url'] ?>
			</p>
		</td>
	</tr>
	<tr>
		<th><label for="ws-img"><?php _e('Icon','wx-custom-share') ?></label></th>
		<td>
			<input type="text" name="ws-img" id="ws-img" value="<?php echo esc_url( $img['meta'] ) ?>" autocomplete="off" placeholder="<?php echo $img['default'] ?>">
			<button type="button" id="ws_upload_btn" class="button">
				<span class="ws-media-icon dashicons dashicons-admin-media"></span>
				<?php _e('Media','wx-custom-share') ?>
			</button>
			<p class="description">
				<?php _e('Enter a URL, Upload or choose from media library. The image you selected should be square.','wx-custom-share') ?>
				<br>
				<?php echo $tips[$type]['img'] ?>
			</p>
		</td>
	</tr>
	<tr>
		<th><label><?php _e('Preview','wx-custom-share') ?></label></th>
		<td>
			<div class="ws-preview">
				<p class="description"><?php _e('Timeline','wx-custom-share') ?></p>
				<div class="ws-timeline clearfix">
					<div class="ws-timeline-left">
						<img width="50" height="50">
					</div>
					<div class="ws-timeline-right">
						<div class="ws-timeline-name"></div>
						<div class="ws-timeline-content"></div>
						<a class="ws-url" href="<?php echo $url['display'] ?>" target="_blank">
							<div class="ws-timeline-link"><table><tr>
							<td>
								<div class="ws-attachment">
									<div class="ws-attachment-preview">
										<div class="ws-thumbnail">
											<div class="ws-centered">
												<img class="ws-img" src="<?php echo $img['display'] != '' ? esc_url($img['display']) : $pngdata ?>" alt="<?php _e('cannot get the image','wx-custom-share') ?>">
											</div>
										</div>
									</div>
								</div>
							</td>
							<td><div class="ws-timeline-title-div">
								<span class="ws-title ws-timeline-title"><?php echo $title['display'] ?></span>
							</div></td>
							</tr></table></div>
						</a>
						<div class="ws-timeline-meta clearfix">
							<span class="ws-timeline-time"><?php _e('1 min ago','wx-custom-share') ?></span>
							<div class="ws-comment-btn">
								<div class="ws-comment-triangle-div"><div class="ws-comment-triangle"></div></div>
								<div class="ws-comment-circle"></div>
								<div class="ws-comment-circle"></div>
							</div>
						</div>
					</div>
				</div>
				
				<p class="description"><?php _e('Chat','wx-custom-share') ?></p>
				<div class="ws-chat clearfix">
					<div><img width="50" height="50"></div>
					<a class="ws-url" href="<?php echo $url['display'] ?>" target="_blank">
					<div class="ws-chat-link">
					<div class="ws-chat-triangle-div">
						<div class="ws-chat-triangle"></div>
						<div class="ws-chat-triangle-shade"></div>
					</div>
					<div class="ws-chat-main">
						<p class="ws-title ws-chat-title"><?php echo $title['display'] ?></p>
						<div class="ws-chat-desc-div">
							<div class="ws-chat-desc"><?php echo $desc['display'] ?></div>
							<div class="ws-attachment">
								<div class="ws-attachment-preview">
									<div class="ws-thumbnail">
										<div class="ws-centered">
											<img class="ws-img" src="<?php echo $img['display'] != '' ? esc_url($img['display']) : $pngdata ?>" alt="<?php _e('cannot get the image','wx-custom-share') ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					</div>
					</a>
				</div>
			</div>
		</td>
	</tr>
</table>
<style>
.wxcs-metabox img:not(.ws-img) {
	background-color: #CCC;
}
.wxcs-metabox p.description {
	font-size: 12px;
}
.wxcs-metabox th {
	width: 20%;
}
.wxcs-metabox input[type="text"] {
	width: 80%;
}
span.ws-timeline-time {
	color: #AAAAAA;
	font-size: 12px;
}
@media screen and (min-width: 782px){
	.ws-preview {
		width: 90%;
	}
}
.ws-preview *{
	font-family:Microsoft YaHei;
}
.ws-preview > p.description{
	font-size: inherit;
	font-style: normal;
}
.ws-preview div{
	box-sizing:border-box;
}
.ws-timeline{
	background-color:#F8F8F8;
	margin-bottom:15px;
	padding:10px;
}
.ws-timeline > div{
	float:left;
}
.ws-timeline-left{
	width:50px;
}
.ws-timeline-right{
	padding-left:10px;
	width:calc(100% - 50px);
}
.ws-timeline-right > a{
	display:block;
	text-decoration:none;
}
.ws-timeline-name,
.ws-timeline-content{
	margin:7px 0;
	border-radius:8px;
	height:15px;
}
.ws-timeline-name{
	width:20%;
	background-color:#8599C1;
}
.ws-timeline-content{
	width:100%;
	background-color:#A2A2A2;
}
.ws-timeline td{
	display:table-cell;
	padding:0;
}
.ws-timeline-link{
	margin:7px 0;
	padding:4px;
	background-color:#ECECEC;
}
.ws-timeline-link:hover{
	cursor:pointer;
	background-color:#D0D0D0;
}
.ws-attachment{
	width:50px;
}
.ws-attachment-preview{
	position:relative;
}
.ws-attachment-preview:before {
	content:"";
	display:block;
	padding-top:100%;
}
.ws-thumbnail{
	overflow:hidden;
	position:absolute;
	top:0;
	right:0;
	bottom:0;
	left:0;
}
.ws-centered{
	position:absolute;
	top:0;
	left:0;
	width:100%;
	height:100%;
	-webkit-transform:translate(50%,50%);
	-ms-transform:translate(50%,50%);
	transform:translate(50%,50%);
}
.ws-timeline-link .ws-img,
.ws-chat-main .ws-img{
	position:absolute;
	top:0;
	left:0;
	max-height:100%;
	-webkit-transform:translate(-50%,-50%);
	-ms-transform:translate(-50%,-50%);
	transform:translate(-50%,-50%);
}
.ws-media-icon{
	color:#82878c;
	vertical-align:text-top;
	font:400 18px/1 dashicons;
}
.ws-timeline-title-div{
	height:50px;
	padding-left:8px;
	overflow:hidden;
}
.ws-timeline-title-div .ws-timeline-title{
	color:#000;
	line-height:50px;
	word-break:break-all;
	display:inline-block;
	vertical-align:middle;
	display:-webkit-box;
	-webkit-box-orient:vertical;
	-webkit-line-clamp:1;
}
.ws-timeline-meta{
	margin-top:15px;
}
.ws-timeline-meta .ws-timeline-time{
	display:inline-block;
	float:left;
}
.ws-timeline-meta .ws-comment-btn{
	float:right;
	position:relative;
	width:20px;
	height:16px;
	background-color:#8694B1;
}
.ws-timeline-meta .ws-comment-circle{
	width:4px;
	height:4px;
	border-radius:4px;
	background-color:#FFF;
	float:left;
	margin-top:6px;
	margin-left:4px;
}
.ws-timeline-meta .ws-comment-triangle-div{
	width:6px;
	height:100%;
	position:absolute;
	left:-6px;
	overflow:hidden;
}
.ws-timeline-meta .ws-comment-triangle{
	width:10px;
	height:10px;
	position:absolute;
	top:3px;
	left:4px;
	background-color:#8694B1;
	transform:rotate(45deg);
	-ms-transform:rotate(45deg); 	/* IE 9 */
	-moz-transform:rotate(45deg); 	/* Firefox */
	-webkit-transform:rotate(45deg); /* Safari 和 Chrome */
	-o-transform:rotate(45deg); 
}
.vertical-middle{
	height:100%;
	vertical-align:middle;
	display:inline-block;
}
.clearfix:after{
	content:" ";
	display:block;
	clear:both;
	height:0;
}

.ws-chat{
	padding:10px;
	background-color:#EBEBEB;
}
.ws-chat div{
	float:left;
}
.ws-chat > a{
	display:inline-block;
}
.ws-chat .ws-chat-main{
	background-color:#FFF;
	padding:8px;
	border:1px solid #CECECE;
	border-radius:5px;
}
.ws-chat-main .ws-chat-title{
	width:250px;
	max-height:40px;
	line-height:20px;
	overflow:hidden;
	display:-webkit-box;
	-webkit-box-orient:vertical;
	-webkit-line-clamp:2;
	word-break:break-all;
	margin-top:0;
	font-size:15px;
	color:#353535;
}
.ws-chat-link:hover .ws-chat-triangle-div .ws-chat-triangle-shade,
.ws-chat-link:hover .ws-chat-triangle-div .ws-chat-triangle,
.ws-chat-link:hover .ws-chat-main{
	cursor:pointer;
	background-color:#F7F7F7;
}
.ws-chat-main .ws-chat-desc-div{
	position:relative;
	margin-top:5px;
}
.ws-chat-desc-div .ws-chat-desc{
	width:200px;
	max-height:48px;
	line-height:16px;
	overflow:hidden;
	display:-webkit-box;
	-webkit-box-orient:vertical;
	-webkit-line-clamp:3;
	font-size:12px;
	color:#999999;
	word-break:break-all;
	padding-right:10px;
	float:left;
}
.ws-chat .ws-chat-triangle-div{
	width:10px;
	height:100%;
	position:relative;
	top:20px;
	left:1px;
	overflow:hidden;
}
.ws-chat .ws-chat-triangle-div .ws-chat-triangle{
	width:10px;
	height:10px;
	position:relative;
	top:0;
	left:5px;
	background-color:#FFF;
	border:1px solid #CECECE;
	transform:rotate(45deg);
	-ms-transform:rotate(45deg); 	/* IE 9 */
	-moz-transform:rotate(45deg); 	/* Firefox */
	-webkit-transform:rotate(45deg); /* Safari 和 Chrome */
	-o-transform:rotate(45deg); 
}
.ws-chat .ws-chat-triangle-div .ws-chat-triangle-shade{
	width:1px;
	height:10px;
	background-color:#FFF;
	position:absolute;
	top:0;
	right:0;
}
.ws-chat .ws-attachment{
	float:right;
}
.ws-chat .ws-attachment *{
	float:none;
}
</style>
<script>
var mediaUploader;
jQuery('#ws_upload_btn').click(function(e){
	e.preventDefault();
	if (mediaUploader) {
		mediaUploader.open();
		return;
	}
	mediaUploader = wp.media.frames.file_frame = wp.media({
		title: '<?php _e('Choose Icon','wx-custom-share') ?>',
		button: {
			text: '<?php _e('Insert','wx-custom-share') ?>'
		}, multiple: false });
		
	mediaUploader.on('select', function(){
		var attachment = mediaUploader.state().get('selection').first().toJSON();
		jQuery('.ws-img').attr('src', attachment.url);
		jQuery('#ws-img').val(attachment.url);
	});
	mediaUploader.open();
});

var default_title = '<?php echo $title['default'] ?>',
	default_desc = '<?php echo $desc['default'] ?>';
	default_url = '<?php echo $url['default'] ?>',
	default_img = '<?php echo $img['default'] != '' ? esc_url($img['default']) : $pngdata ?>';

function wxcsBindValue(source, target, type, attr, defaultValue){
	jQuery(source).bind('input propertychange', function(){
		if('' !== jQuery(source).val()){
			if( type == 'text' ){
				jQuery(target).text(jQuery(source).val());
			}else if( type == 'attr' ){
				jQuery(target).attr(attr, jQuery(source).val());
			}
		}else{
			if( type == 'text' ){
				jQuery(target).text(defaultValue);
			}else if( type == 'attr' ){
				jQuery(target).attr(attr, defaultValue);
			}
		}
	});
}
wxcsBindValue('#ws-title', '.ws-title', 'text', '', default_title);
wxcsBindValue('#ws-desc', '.ws-chat-desc', 'text', '', default_desc);
wxcsBindValue('#ws-url', '.ws-url', 'attr', 'href', default_url);
wxcsBindValue('#ws-img', '.ws-img', 'attr', 'src', default_img);
</script>