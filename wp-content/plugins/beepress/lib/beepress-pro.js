(function($){
	var count = 0;
	var amount = 0;
	var progressBar = $('#progress-status');
	var urlsArr = [];
	var newUrlsArr = [];
	var resultList = $('.result .table tbody');
	var lineCount = 0;
	var requestURL = $('#request_url').val();
	var licenseCode = $('#license_code').val();
	var removeImage = 'no';
	var imageTitleAlt = '';
	var postType = 'post';
	var removeBlank = 'yes';
	var skipDuplicate = 'yes';
	var postStatus = 'publish';
	var removeOuterlink = 'no';
	var postTags = [];
	$('#bp-submit').on('click', function() {
		count = 0;
		amount = 0;
		urlsArr = [];
		newUrlsArr = [];
		resultList.children().remove();
		lineCount = 0;
		licenseCode = $('#license_code').val();
		removeImage = $('input[name="remove_image"]:checked').val();
		imageTitleAlt = $('input[name="image_title_alt"]').val();
		removeBlank = $('input[name="remove_blank"]:checked').val();
		skipDuplicate = $('input[name="skip_duplicate"]:checked').val();
		postStatus = $('input[name="post_status"]:checked').val();
		removeOuterlink = $('input[name="remove_outerlink"]:checked').val();
		var cates = [], removeSpecifiedImages = [] ;
		$('input[name="post_cate[]"]:checked').each(function() {
			cates.push($(this).val());
		});
		$('input[name="remove_specified_image[]"]:checked').each(function() {
			removeSpecifiedImages.push($(this).val());
		});
		// $('input[name="post_tag[]"]:checked').each(function() {
		// 	postTags.push($(this).val());
		// });
		postType = $('input[name="post_type"]:checked').val();
		var urls = $('#post-urls').val();
		var that = this;
		if (!urls) {
			alert('请输入文章链接');
			return;
		}
		$(this).attr({
			disabled: 'disabled',
			value: '采集中...',
		});
		urlsArr = urls.split('\n');
		urlsArr.forEach(function (url) {
			if (url) {
				newUrlsArr.push(url);
			}
		});
		amount = newUrlsArr.length;
		progressBar.attr({
			'aria-valuemax':  amount,
		});
		progressBar.css({
			'width': '5%'
		});
		if (amount == 0) {
			alert('请输入文章链接');
			return;
		}
		process_request(requestURL, newUrlsArr[count], cates, removeSpecifiedImages, licenseCode, imageTitleAlt, that);
	});

	function process_request(requestURL, urls, cates, removeSpecifiedImages, licenseCode, imageTitleAlt, that) {
		var platform;
		count++;
		// 导入完毕
		if (count > amount) {
			progressBar.css({
				'width': '100%'
			});
			setTimeout(function() {
				alert('导入完毕');
				progressBar.css({
					'width': '0%'
				});
				$(that).attr({
					value: '开始采集'
				});
				$(that).removeAttr('disabled');
			}, 500);
			return;
		}
		if (urls.indexOf('mp.weixin.qq.com') != -1) {
			platform = 'wechat';
		}
		if (urls.indexOf('zhuanlan.zhihu.com') != -1) {
			platform = 'zhihu';
		}
		if (urls.indexOf('www.jianshu.com') != -1) {
			platform = 'jianshu';
		}
		if (urls.indexOf('baijia.baidu.com') != -1) {
			platform = 'baidu';
		}
		if (urls.indexOf('toutiao.com') != -1) {
			platform = 'toutiao';
		}
		$.ajax(requestURL, {
			method: 'POST',
			dataType: 'json',
			data: {
				action: 'beepress_pro_process_request',
				urls: urls,
				platform: platform,
				post_cate: cates,
				license_code: licenseCode,
				remove_image: removeImage,
				image_title_alt: imageTitleAlt,
				remove_specified_iamges: removeSpecifiedImages,
				post_type: postType,
				remove_blank: removeBlank,
				skip_duplicate: skipDuplicate,
				post_status: postStatus,
				remove_outerlink: removeOuterlink,
				post_tags: postTags
			},
			success: function(response) {
				checkAuth();
				var isSuccess = response['success'];
				// 成功导入
				if (isSuccess && response['data']) {
						progressBar.css({
							'width': (count / amount) * 100 + '%'
						});
						lineCount++;
						var line = '<tr class="success">';
						line += '<th scope="row">' + lineCount + '</th>';
						line += '<td>成功</td>';
						line += '<td>';
						line += '<a target="_blank" href="post.php?post=' + response['data'] + '&action=edit" class="btn btn-success">编辑</a>&nbsp;';
						line += '<a target="_blank" href="/?p=' + response['data'] + '" class="btn btn-info">查看</a>';
						line += '</td>';
						line += '<td class="col-md-5"><a target="_blank" href="' + newUrlsArr[count-1] + '">原文</a></td>';
						line += '</tr>';
						resultList.append(line);
						setTimeout(function () {
							process_request(requestURL, newUrlsArr[count], cates, removeSpecifiedImages, licenseCode, imageTitleAlt, that);
						}, 1000);
				} else {
						// 记录失败的记录
						lineCount++;
						var line = '<tr class="warning">';
						line += '<th scope="row">' + lineCount + '</th>';
						line += '<td>失败</td>';
						line += '<td>-</td>';
						line += '<td class="col-md-5"><a target="_blank" href="' + newUrlsArr[count-1] + '">原文</a></td>';
						line += '</tr>';
						resultList.append(line);
						progressBar.css({
							'width': (count / amount) * 100 + '%'
						});
						setTimeout(function () {
							process_request(requestURL, newUrlsArr[count], cates, removeSpecifiedImages, licenseCode, imageTitleAlt, that);
						}, 1000);
				}

			},
			error: function() {
				// 失败
				if (amount == 1) {
					alert('采集失败');
					progressBar.css({
						'width': '0%'
					});
					$(that).attr({
						value: '开始采集'
					});
					$(that).removeAttr('disabled');
					return true;
				} else {
					lineCount++;
					var line = '<tr class="bg-danger">';
					line += '<th scope="row">' + lineCount + '</th>';
					line += '<td>' + newUrlsArr[count-1] + '</td>';
					line += '<td>失败</td>';
					line += '<td>无法请求该链接</td>';
					line += '<td>';
					line += '<button class="btn btn-warning">重新导入</button>';
					line += '</td>';
					line += '</tr>';
					resultList.append(line);
					setTimeout(function () {
						process_request(requestURL, newUrlsArr[count], cates, removeSpecifiedImages, licenseCode, imageTitleAlt, that);
					}, 1000);
				}
			}
		});
	}

	var auth = $('#auth');
	var info = $('#az-license-info');
	checkAuth();
	function checkAuth() {
		$.ajax(requestURL, {
			method: 'POST',
			dataType: 'json',
			data: {
				action: 'beepress_pro_license_check',
				license_code: licenseCode
			},
			success: function(response) {
				var isSuccess = response['success'];
				if (isSuccess) {
					auth.html('已授权');
					auth.addClass('label label-success');
					info.remove();
				} else {
					auth.html('当前为试用版本，剩余免费使用次数：' + response['data']);
					auth.addClass('label label-danger')
				}
			},
			error: function() {
			}
		});
	}
	var bpIframe = $('.bp-iframe');
	bpIframe.each(function() {
		$(this).height($(this).width() / 1.7);
	});
})(jQuery);
function BeePlayer(e){this.option=e}BeePlayer.prototype.init=function(){function e(e){var a=e||window.event,i=(a.clientX-t(l.bar))/s;i=i>0?i:0,i=1>i?i:1,l.updateBar.call(l,"played",i,"width"),l.element.getElementsByClassName("aplayer-ptime")[0].innerHTML=l.secondToTime(i*l.audio.duration)}function a(){document.removeEventListener("mouseup",a),document.removeEventListener("mousemove",e),l.audio.currentTime=parseFloat(l.playedBar.style.width)/100*l.audio.duration,l.playedTime=setInterval(function(){l.updateBar.call(l,"played",l.audio.currentTime/l.audio.duration,"width"),l.element.getElementsByClassName("aplayer-ptime")[0].innerHTML=l.secondToTime(l.audio.currentTime)},100)}function t(e){for(var a,t=e.offsetLeft,i=e.offsetParent;null!==i;)t+=i.offsetLeft,i=i.offsetParent;return a=document.body.scrollLeft+document.documentElement.scrollLeft,t-a}function i(e){for(var a,t=e.offsetTop,i=e.offsetParent;null!==i;)t+=i.offsetTop,i=i.offsetParent;return a=document.body.scrollTop+document.documentElement.scrollTop,t-a}this.element=this.option.element,this.music=this.option.music,this.element.innerHTML='<div class="aplayer-pic"><img src="'+this.music.pic+"\"><div class=\"aplayer-button aplayer-pause aplayer-hide\"><i class=\"demo-icon aplayer-icon-pause\"></i></div><div class=\"aplayer-button aplayer-play\"><i class=\"demo-icon aplayer-icon-play\"></i></div></div><div class=\"aplayer-info\"><div class=\"aplayer-music\"><a href=\"javascript:void((function(s,d,e,r,l,p,t,z,c){var%20f='http://v.t.sina.com.cn/share/share.php?appkey=2992571369',u=z||d.location,p=['&url=',e(u),'&title=',e(t||d.title),'&source=',e(r),'&sourceUrl=',e(l),'&content=',c||'gb2312','&pic=',e(p||'')].join('');function%20a(){if(!window.open([f,p].join(''),'mb',['toolbar=0,status=0,resizable=1,width=440,height=430,left=',(s.width-440)/2,',top=',(s.height-430)/2].join('')))u.href=[f,p].join('');};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();})(screen,document,encodeURIComponent,'','','"+this.music.pic+"','#传送门音乐分享# "+this.music.title+" - "+this.music.author+' \',\'\',\'\'));" title="分享至微博"><i class="demo-icon aplayer-icon-weibo"></i></a><span class="aplayer-title">'+this.music.title+'</span><span class="aplayer-author">音乐资源加载中...</span></div><div class="aplayer-controller"><div class="aplayer-bar-wrap"><div class="aplayer-bar"><div class="aplayer-loaded" style="width: 0"></div><div class="aplayer-played" style="width: 0"><span class="aplayer-thumb"></span></div></div></div><span class="aplayer-time"> - <span class="aplayer-ptime">00:00</span> / <span class="aplayer-dtime">00:00</span><div class="aplayer-volume-wrap"><i class="demo-icon aplayer-icon-volume-down"></i><div class="aplayer-volume-bar-wrap"><div class="aplayer-volume-bar"><div class="aplayer-volume" style="height: 80%"></div></div></div></div></span></div></div>',this.option.narrow&&this.element.classList.add("aplayer-narrow"),this.audio=document.createElement("audio"),this.audio.src=this.music.url,this.audio.loop=!0,this.audio.preload="metadata";var l=this;this.audio.addEventListener("durationchange",function(){l.element.getElementsByClassName("aplayer-dtime")[0].innerHTML=l.secondToTime(l.audio.duration)}),this.audio.addEventListener("canplay",function(){l.element.getElementsByClassName("aplayer-author")[0].innerHTML=" - "+l.music.author,l.loadedTime=setInterval(function(){var e=l.audio.buffered.end(l.audio.buffered.length-1)/l.audio.duration;l.updateBar.call(l,"loaded",e,"width"),1===e&&clearInterval(l.loadedTime)},500)}),this.audio.addEventListener("error",function(){l.element.getElementsByClassName("aplayer-author")[0].innerHTML=" - 加载失败 ╥﹏╥"}),this.playButton=this.element.getElementsByClassName("aplayer-play")[0],this.pauseButton=this.element.getElementsByClassName("aplayer-pause")[0],this.playButton.addEventListener("click",function(){l.play.call(l)}),this.pauseButton.addEventListener("click",function(){l.pause.call(l)}),this.playedBar=this.element.getElementsByClassName("aplayer-played")[0],this.loadedBar=this.element.getElementsByClassName("aplayer-loaded")[0],this.thumb=this.element.getElementsByClassName("aplayer-thumb")[0],this.bar=this.element.getElementsByClassName("aplayer-bar")[0];var s;this.bar.addEventListener("click",function(e){var a=e||window.event;s=l.bar.clientWidth;var i=(a.clientX-t(l.bar))/s;l.updateBar.call(l,"played",i,"width"),l.element.getElementsByClassName("aplayer-ptime")[0].innerHTML=l.secondToTime(i*l.audio.duration),l.audio.currentTime=parseFloat(l.playedBar.style.width)/100*l.audio.duration}),this.thumb.addEventListener("mousedown",function(){s=l.bar.clientWidth,clearInterval(l.playedTime),document.addEventListener("mousemove",e),document.addEventListener("mouseup",a)}),this.audio.volume=.8,this.volumeBar=this.element.getElementsByClassName("aplayer-volume")[0];var n=this.element.getElementsByClassName("aplayer-volume-bar")[0],o=l.element.getElementsByClassName("aplayer-time")[0].getElementsByTagName("i")[0],r=35;this.element.getElementsByClassName("aplayer-volume-bar-wrap")[0].addEventListener("click",function(e){var a=e||window.event,t=(r-a.clientY+i(n))/r;t=t>0?t:0,t=1>t?t:1,l.updateBar.call(l,"volume",t,"height"),l.audio.volume=t,l.audio.muted&&(l.audio.muted=!1),1===t?o.className="demo-icon aplayer-icon-volume-up":o.className="demo-icon aplayer-icon-volume-down"}),o.addEventListener("click",function(){l.audio.muted?(l.audio.muted=!1,o.className=1===l.audio.volume?"demo-icon aplayer-icon-volume-up":"demo-icon aplayer-icon-volume-down",l.updateBar.call(l,"volume",l.audio.volume,"height")):(l.audio.muted=!0,o.className="demo-icon aplayer-icon-volume-off",l.updateBar.call(l,"volume",0,"height"))}),this.option.autoplay&&this.play()},BeePlayer.prototype.play=function(){this.playButton.classList.add("aplayer-hide"),this.pauseButton.classList.remove("aplayer-hide"),this.audio.play();var e=this;this.playedTime=setInterval(function(){e.updateBar.call(e,"played",e.audio.currentTime/e.audio.duration,"width"),e.element.getElementsByClassName("aplayer-ptime")[0].innerHTML=e.secondToTime(e.audio.currentTime)},100)},BeePlayer.prototype.pause=function(){this.pauseButton.classList.add("aplayer-hide"),this.playButton.classList.remove("aplayer-hide"),this.audio.pause(),clearInterval(this.playedTime)},BeePlayer.prototype.updateBar=function(e,a,t){a=a>0?a:0,a=1>a?a:1,this[e+"Bar"].style[t]=100*a+"%"},BeePlayer.prototype.secondToTime=function(e){var a=function(e){return 10>e?"0"+e:""+e},t=parseInt(e/60),i=parseInt(e-60*t);return a(t)+":"+a(i)};
