<?php
if(!class_exists('simple_html_dom_node')){require_once("simple_html_dom.php");}if(!class_exists('BeePressUtils')){require_once("beepress-utils.php");}if(!function_exists('beepress_pro_request_page')){function beepress_pro_request_page(){require_once 'beepress-pro-request-page.php';}}if(!function_exists('beepress_pro_admin_init')){function beepress_pro_admin_init(){$a=get_option('bp_count');if(!$a){add_option('bp_count',5);}$b=isset($_REQUEST['page'])?$_REQUEST['page']:'';if(in_array($b,array('beepress_pro_request','beepress_pro_option'))){wp_enqueue_style('BOOTSTRAPCSS',plugins_url('/lib/bootstrap.min.css',__FILE__),array(),'3.3.7','screen');wp_enqueue_script('BOOTSTRAPJS',plugins_url('/lib/bootstrap.min.js',__FILE__),array('jquery'),'3.3.7',true);wp_enqueue_style('BEEPRESSCSS',plugins_url('/lib/beepress.css',__FILE__),array(),BEEPRESS_VERSION,'screen');wp_enqueue_script('BEEPRESSJS',plugins_url('/lib/beepress-pro.js',__FILE__),array('jquery'),BEEPRESS_VERSION,true);}}}add_action('admin_init','beepress_pro_admin_init');if(!function_exists('beepress_pro_init')){function beepress_pro_init(){wp_enqueue_script('BEEPRESSJS',plugins_url('/lib/beepress-pro.js',__FILE__),array('jquery'),BEEPRESS_VERSION,true);wp_enqueue_style('BEEPRESSCSS',plugins_url('/lib/beepress.css',__FILE__),array(),BEEPRESS_VERSION,'screen');$c=get_option('bp_image_centered','no')=='yes';if($c){wp_enqueue_style('BEEPRESSIMAGECSS',plugins_url('/lib/beepress-image.css',__FILE__),array(),BEEPRESS_VERSION,'screen');}}}add_action('init','beepress_pro_init');if(!function_exists('beepress_pro_option_menu')){function beepress_pro_option_menu(){add_submenu_page('beepress_pro','BeePress Pro','导入文章','publish_posts','beepress_pro_request','beepress_pro_request_page');add_submenu_page('beepress_pro','BeePress Pro 配置','配置&帮助','publish_posts','beepress_pro_option','beepress_pro_option_page');remove_submenu_page('beepress_pro','beepress_pro');add_action('admin_init','beepress_pro_register_option');}}if(!function_exists('beepress_pro_option_page')){function beepress_pro_option_page(){require_once 'beepress-pro-options-page.php';}}if(!function_exists('beepress_pro_register_option')){function beepress_pro_register_option(){register_setting('beepress-option-group','bp_license_code');register_setting('beepress-option-group','bp_post_time');register_setting('beepress-option-group','bp_post_status');register_setting('beepress-option-group','bp_image_dir');register_setting('beepress-option-group','bp_keep_copyright');register_setting('beepress-option-group','bp_keep_style');register_setting('beepress-option-group','bp_sync_token');register_setting('beepress-option-group','bp_sync_times');register_setting('beepress-option-group','bp_image_centered');register_setting('beepress-option-group','bp_featured_image');register_setting('beepress-option-group','bp_image_name_prefix');register_setting('beepress-option-group','bp_hide_lite_edition');register_setting('beepress-option-group','bp_copyright_position');register_setting('beepress-option-group','bp_image_title_alt');register_setting('beepress-option-group','bp_image_path');register_setting('beepress-option-group','bp_remove_outerlink');}}add_action('wp_ajax_beepress_pro_license_check','beepress_pro_license_check');if(!function_exists('beepress_pro_license_check')){function beepress_pro_license_check(){$d='FXqqh4gVu27Rd696';$e=preg_replace('/(http:\/\/|https:\/\/)/','',home_url());$f=parse_url(home_url(),PHP_URL_HOST);$g=get_option('bp_license_code');$h=md5($e.$d);$i=md5($f.$d);$j=$g&&($g==$h||$g==$i);wp_send_json(array('success'=>$j,'data'=>intval(get_option('bp_count')),));}}add_action('wp_ajax_beepress_pro_process_request','beepress_pro_process_request');if(!function_exists('beepress_pro_process_request')){function beepress_pro_process_request(){if(!is_admin()){wp_send_json(array('success'=>false,'message'=>'您没有权限使用该接口'));}$k=isset($_REQUEST['platform'])?$_REQUEST['platform']:null;$l=isset($_REQUEST['urls'])?$_REQUEST['urls']:'';if(!($l)){wp_send_json(array('success'=>false,'message'=>'没有符合要求的文章链接'));}$m=explode("\n",$l);if(count($m)==0){wp_send_json(array('success'=>false,'message'=>'URL为空'));}$n=null;switch($k){case  'wechat':$n=beepress_pro_for_platform($m,$k);break;case  'zhihu':$n=beepress_pro_for_platform($m,$k);break;case  'jianshu':$n=beepress_pro_for_platform($m,$k);break;case  'toutiao':$n=beepress_pro_for_platform($m,$k);break;default:wp_send_json(array('success'=>false,'message'=>'暂不支持该平台'));break;}if(!is_int($n)){wp_send_json(array('success'=>false,'data'=>$n,'message'=>$n));}else{wp_send_json(array('success'=>true,'data'=>$n,'message'=>'导入成功'));}}}if(!function_exists('beepress_pro_for_platform')){function beepress_pro_for_platform($l,$k){if(count($l)==0){return null;}$o=get_option('bp_keep_style','yes')=='yes';$p=isset($_REQUEST['post_status'])&&in_array($_REQUEST['post_status'],array('publish','pending','draft'))?$_REQUEST['post_status']:'publish';$q=get_option('bp_post_time','original_time')=='original_time';$r=isset($_REQUEST['post_cate'])?$_REQUEST['post_cate']:array();$r=array_map('intval',$r);$s=isset($_REQUEST['post_tags'])?$_REQUEST['post_tags']:array();$s=array_map('intval',$s);$f=parse_url(home_url(),PHP_URL_HOST);$e=preg_replace('/(http:\/\/|https:\/\/)/','',home_url());$t=get_current_user_id();$g=get_option('bp_license_code');$d='FXqqh4gVu27Rd696';$h=md5($e.$d);$i=md5($f.$d);$j=$g&&($g==$i||$g==$h);$u='';foreach($l as $v){switch($k){case  'wechat':$v=str_replace('https','http',$v);if(strpos($v,'http://mp.weixin.qq.com')!==false||strpos($v,'https://mp.weixin.qq.com')!==false){$v=trim($v);if(!$v){$u.='|URL不能为空';continue;}}else{continue;}break;case  'zhihu':if(strpos($v,'https://zhuanlan.zhihu.com')!==false||strpos($v,'http://zhuanlan.zhihu.com')!==false){$v=trim($v);if(!$v){$u.='|URL不能为空';continue;}}else{continue;}break;case  'jianshu':if(strpos($v,'jianshu.com')){$v=trim($v);if(!$v){$u.='|URL不能为空';continue;}}else{continue;}break;case  'toutiao':if(strpos($v,'toutiao.com')!==false){$v=trim($v);if(!$v){$u.='|URL不能为空';continue;}}else{continue;}break;default:continue;}$w='';if(function_exists('file_get_contents')){$w=file_get_contents($v);if($w==''){$x=curl_init();$y=60;curl_setopt($x,CURLOPT_URL,$v);curl_setopt($x,CURLOPT_RETURNTRANSFER,1);curl_setopt($x,CURLOPT_CONNECTTIMEOUT,$y);curl_setopt($x,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');$w=curl_exec($x);curl_close($x);}if(!$w){$u.='|无法获取改链接内容';continue;}}if(!$j){if($a=intval(get_option('bp_count'))){$a--;update_option('bp_count',$a);}else{return '免费试用次数已经用完，请联系开发者购买授权码(微信：always-bee，注明BeePress)';}if($a<=-1){return '免费试用次数已经用完，请联系开发者购买授权码(微信：always-bee，注明BeePress)';}}if(!$o){$w=preg_replace('/style\=\"[^\"]*\"/','',$w);}$z=str_get_html($w);switch($k){case  'wechat':$aa=trim($z->find('#activity-name',0)->plaintext);break;case  'zhihu':$aa=trim($z->find('.PostIndex-title',0)->plaintext);break;case  'jianshu':$aa=trim($z->find('.title',0)->plaintext);break;case  'toutiao':$aa=trim($z->find('.article-title',0)->plaintext);break;default:$aa=null;}if(!$aa){$u.='|无法获取文章标题';continue;}$bb=isset($_REQUEST['skip_duplicate'])&&($_REQUEST['skip_duplicate']=='yes');if($cc=post_exists($aa)&&$bb){continue;}$dd=null;if($k=='wechat'){$ee=$z->find('img');$ff=$z->find('.video_iframe');$gg='http://read.html5.qq.com/image?src=forum&q=4&r=0&imgflag=7&imageUrl=';$hh=esc_html($z->find('#post-user',0)->plaintext);$ii=$z->find('mpvoice');$jj='http://res.wx.qq.com/voice/getvoice?mediaid=';$kk=0;foreach($ii as $ll){$kk++;$mm=$jj.$ll->getAttribute('voice_encode_fileid');$nn=$ll->getAttribute('name');$oo=$ll->parent();$oo->innertext='<div class="aplayer" id="audio-'.$kk.'"></div>'.'<script>var audio'.$kk.' = new BeePlayer({element: document.getElementById("audio-'.$kk.'"),music:{title:  "'.$nn.'", author: "'.$hh.'",pic: "'.plugins_url('/lib/player.png',__FILE__).'", url: "'.$mm.'"}}); audio'.$kk.'.init();'.'</script>';}foreach($ee as $pp){$qq=$pp->getAttribute('data-src');if(!$qq){continue;}$rr=$gg.$qq;$pp->setAttribute('src',$rr);}foreach($ff as $ss){$qq=$ss->getAttribute('data-src');$qq=preg_replace('/(width|height)=([^&]*)/i','',$qq);$qq=str_replace('&&','&',$qq);$ss->setAttribute('src',$qq);}preg_match('/(msg_desc = ")([^\"]+)"/',$w,$tt);if(count($tt)>2){$dd=$tt[2];}}if($k=='jianshu'){$ee=$z->find('.image-view img');foreach($ee as $pp){$qq=$pp->getAttribute('data-original-src');if(!$qq){continue;}$pp->setAttribute('src',$qq);}$uu=$z->find('.image-container');foreach($uu as $vv){$vv->setAttribute('style','');}$ww=$z->find('.image-container-fill');foreach($ww as $xx){$xx->setAttribute('style','');}}$yy=current_time('mysql');if($q){switch($k){case  'wechat':$yy=$z->find('#post-date',0)->plaintext;break;case  'zhihu':$yy=$z->find('.PostIndex-author time',0)->getAttribute('datetime');break;case  'jianshu':$yy=$z->find('.publish-time',0)->innertext;$yy=str_replace('.','-',$yy);break;case  'toutiao':$yy=$z->find('.time',0)->innertext;$yy.=':00';break;}$yy=date('Y-m-d H:i:s',strtotime($yy)+1);}if(count($r)==0){$r=array(1);}$zz=isset($_REQUEST['post_type'])?$_REQUEST['post_type']:'post';$aaa=array('post_title'=>$aa,'post_content'=>$w,'post_status'=>$p,'post_author'=>$t,'post_category'=>$r,'tags_input'=>$s,'post_type'=>$zz);if($dd){$aaa['post_excerpt']=$dd;}if($q){$aaa['post_date']=$yy;}$n=wp_insert_post($aaa);$bbb=get_option('bp_featured_image','yes')=='yes';if($k=='wechat'&&$bbb){preg_match('/(msg_cdn_url = ")([^\"]+)"/',$w,$tt);$gg='http://read.html5.qq.com/image?src=forum&q=4&r=0&imgflag=7&imageUrl=';$ccc=$gg.$tt[2];$ddd=download_url($ccc);if(is_string($ddd)){$eee=get_option('bp_image_name_prefix','beepress-weixin-zhihu-jianshu-plugin');$fff=$eee.'-'.time().'.jpeg';$ggg=array('name'=>$fff,'tmp_name'=>$ddd);$cc=@media_handle_sideload($ggg,$n);if(!is_wp_error($cc)){@set_post_thumbnail($n,$cc);}}}unset($w);$n=beepress_pro_download_image($n,$z,$k);if(count($l)==1){return $n;}}return null;}}if(!function_exists('beepress_pro_download_image')){function beepress_pro_download_image($n,$z,$k){if(!$n||!$z){return null;}if($k!='jianshu'){$hhh=$z->find('img');}else{$hhh=$z->find('.show-content img');}$bbb=get_option('bp_featured_image','yes')=='yes';switch($k){case  'wechat':$aa=trim($z->find('#activity-name',0)->plaintext);break;case  'zhihu':$aa=trim($z->find('.PostIndex-title',0)->plaintext);break;case  'jianshu':$aa=trim($z->find('.title',0)->plaintext);break;case  'toutiao':$aa=trim($z->find('.article-title',0)->plaintext);break;default:$aa='';}$iii=get_option('bp_keep_copyright','yes')=='yes';$jjj=false;$kkk=isset($_REQUEST['remove_image'])?$_REQUEST['remove_image']=='yes':false;$lll=isset($_REQUEST['remove_specified_iamges'])?$_REQUEST['remove_specified_iamges']:array();$lll=array_map('intval',$lll);$c=get_option('bp_image_centered','no')=='yes';$mmm=isset($_REQUEST['image_title_alt'])&&$_REQUEST['image_title_alt']?$_REQUEST['image_title_alt']:get_option('bp_image_title_alt','');if($mmm){$aa=$mmm;}$nnn=0;$ooo=count($hhh);foreach($hhh as $pp){$rr=$pp->getAttribute('src');if(!$rr||strstr($rr,'res.wx.qq.com')||strstr($rr,'wx.qlogo.cn')){$ooo--;}}foreach($hhh as $pp){$ppp=$pp->getAttribute('class');if(strstr($ppp,'logo')){continue;}$rr=$pp->getAttribute('src');if(!$rr||strstr($rr,'res.wx.qq.com')||strstr($rr,'wx.qlogo.cn')){$pp->outertext='';continue;}$nnn++;if($kkk||in_array($nnn,$lll)||in_array($nnn-$ooo-1,$lll)){$pp->outertext='';continue;}switch($k){case  'wechat':break;case  'zhihu':if(strstr($rr,'data:image')){$pp->outertext='';}break;case  'toutiao':break;}$qqq=$pp->getAttribute('class');if($c){$qqq.=' aligncenter';$pp->setAttribute('class',$qqq);}$rrr=$pp->getAttribute('data-type');$rr=preg_replace('/^\/\//','http://',$rr,1);if(!$rrr){$rrr='jpeg';}$ddd=download_url($rr);if(!is_string($ddd)){continue;}$eee=get_option('bp_image_name_prefix','beepress-weixin-zhihu-jianshu-toutiao-plugin');$fff=$eee.'-'.time().'.'.$rrr;$ggg=array('name'=>$fff,'tmp_name'=>$ddd);$cc=@media_handle_sideload($ggg,$n);if(is_wp_error($cc)){continue;}else{$sss=wp_get_attachment_image_src($cc,'full');if(!$sss){continue;}$ttt=$sss[0];if($bbb&&!$jjj){switch($k){case  'zhihu':$qqq=$pp->getAttribute('class');if(strstr($qqq,'TitleImage-imagePure')){@set_post_thumbnail($n,$cc);$jjj=true;}break;case  'toutiao':$ppp=$pp->getAttribute('class');if(strstr($ppp,'logo')){continue;}else{@set_post_thumbnail($n,$cc);$jjj=true;}break;case  'jianshu':@set_post_thumbnail($n,$cc);$jjj=true;break;}}if(get_option('bp_image_path','abs')=='rel'){$uuu=home_url();$ttt=substr_replace($ttt,'',0,strlen($uuu));}$pp->setAttribute('src',$ttt);$pp->setAttribute('alt',$aa);$pp->setAttribute('title',$aa);}}$w='';$hh='';switch($k){case  'wechat':$hh='始发于微信公众号：'.esc_html($z->find('#post-user',0)->plaintext);$w=$z->find('#js_content',0)->innertext;break;case  'zhihu':$hh='始发于知乎专栏：'.esc_html($z->find('.PostIndex-authorName',0)->plaintext);$w=$z->find('.PostIndex-content',0)->innertext;break;case  'jianshu':$hh='始发于简书：'.esc_html($z->find('.name a',0)->plaintext);$w=$z->find('.show-content',0)->innertext;break;case  'toutiao':$hh='始发于今日头条：'.esc_html($z->find('.name a',0)->plaintext);$w=$z->find('.article-content',0)->innertext;break;}if($iii&&$hh){$vvv="<blockquote class='keep-source'>"."<p>{$hh}</p>"."</blockquote>";if(get_option('bp_copyright_position')=='top'){$w=$vvv.$w;}else{$w.=$vvv;}}$w='<div class="bpp-post-content">'.$w.'</div>';$www='<div class="bp-video">
                <div class="player">
                    <iframe class="bp-iframe" width="100%" src="$1" frameborder="0" allowfullscreen="true"></iframe>
                </div>';$www.='</div>';switch($k){case  'wechat':$w=preg_replace('/<iframe\s+.*?\s+src="(.*?)".*?<\/iframe>/',$www,$w);$w=preg_replace('/src=\"(http:\/\/read\.html5\.qq\.com)([^\"])*\"/','',$w);break;case  'zhihu':$w=preg_replace('/<noscript>(.*?)<\/noscript>/',"$1",$w);break;}$xxx=new BeePressUtils();$w=$xxx->remove_useless_attrs($w);$yyy=isset($_REQUEST['remove_outerlink'])?$_REQUEST['remove_outerlink']:'no';if($yyy!='no'){switch($yyy){case  'all':$w=$xxx->remove_link($w,false);break;case  'keepcontent':$w=$xxx->remove_link($w,true);break;}}$zzz=isset($_REQUEST['remove_blank'])?$_REQUEST['remove_blank']=='yes':true;if($zzz){$w=$xxx->content_filter_blank($w);}return@wp_update_post(array('ID'=>$n,'post_content'=>trim($w)));}}