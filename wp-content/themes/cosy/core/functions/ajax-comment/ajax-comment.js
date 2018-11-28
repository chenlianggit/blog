jQuery(document).ready(function(jQuery) {
	var $commentform = jQuery('#commentform'),
	$comments = jQuery('#comments-title'),
	$cancel = jQuery('#cancel-comment-reply-link'),
	cancel_text = "再想想";
	jQuery('#comment').after('<div id="comment_message" style="display:none;"></div>');
	jQuery(document).on("submit", "#commentform",
	function() {
		//jQuery('#comment_message').slideDown().html("<p>评论提交中....</p>");
		jQuery('#submit').addClass("disabled").val("发表评论").attr("disabled","disabled");
		jQuery.ajax({
			url: globals.ajax_url,
			data: jQuery(this).serialize() + "&action=ajax_comment",
			type: jQuery(this).attr('method'),
			error: function(request) {
				//jQuery('#comment_message').addClass('comt-error').html(request.responseText);
				mi_prompt('error',request.responseText);
				setTimeout("jQuery('#submit').removeClass('disabled').val('发表评论').attr('disabled',false)", 2000);
				//setTimeout("jQuery('#comment_message').slideUp()", 2000);
				//setTimeout("jQuery('#comment_message').removeClass('comt-error')", 3000);
			},
			success: function(data) {
				jQuery('textarea').each(function() {
					this.value = ''
				});
				var t = addComment,
				cancel = t.I('cancel-comment-reply-link'),
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId),
				post = t.I('comment_post_ID').value,
				parent = t.I('comment_parent').value;
				if (parent != '0') {
					jQuery('#comment-'+parent).append('<ul class="children">' + data + '</ul>');
				} else if ( jQuery('.comment-list').length != '0') {
					if( globals.new_comment_position == 'desc' ){
						jQuery('.comment-list').prepend(data)
					}else{
						jQuery('.comment-list').append(data);
					}			
				} else {
					jQuery('.comment-list').append(data);
				}
				jQuery('#captcha').val('');
				$('.captcha-image img').attr('src',$('.captcha-image img').attr('src')+'&time='+Date.parse(new Date()));
				mi_prompt( 'success', '评论提交成功' );
				setTimeout("jQuery('#submit').removeClass('disabled').val('发表评论').attr('disabled',false)", 2000);
				setTimeout("jQuery('#comment_message').slideUp()", 2000);
				setTimeout("jQuery('#sometips').remove()", 2000);
				cancel.style.display = 'none';
				cancel.onclick = null;
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)					
				}
			}
		});
		return false;
	});
	addComment = {
		moveForm: function(commId, parentId, respondId) {
			var t = this,
			div,
			comm = t.I(commId),
			respond = t.I(respondId),
			cancel = t.I('cancel-comment-reply-link'),
			parent = t.I('comment_parent'),
			post = t.I('comment_post_ID');
			$cancel.text(cancel_text);
			t.respondId = respondId;
			if (!t.I('wp-temp-form-div')) {
				div = document.createElement('div');
				div.id = 'wp-temp-form-div';
				div.style.display = 'none';
				respond.parentNode.insertBefore(div, respond)
			} 
			! comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
			jQuery("body").animate({
				scrollTop: jQuery('#respond').offset().top - 180
			},
			400);
			parent.value = parentId;
			cancel.style.display = '';
			cancel.onclick = function() {
				var t = addComment,
				temp = t.I('wp-temp-form-div'),
				respond = t.I(t.respondId);
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp);
				}
				this.style.display = 'none';
				this.onclick = null;
				return false;
			};
			try {
				t.I('comment').focus();
			}
			 catch(e) {}
			return false;
		},
		I: function(e) {
			return document.getElementById(e);
		}
	};
});
