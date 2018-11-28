=== WX Custom Share ===

Contributors: ooqwqoo
Tags: 微信, 微信分享, 微信分享小图标, wechat, wechat share, wechat share info, customize share link info
Donate link: http://www.qwqoffice.com/article-20.html
Requires at least: 3.6
Tested up to: 4.9
Stable tag: 1.5.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

自定义微信分享和QQ分享链接中的信息，包括标题、描述、小图标和分享链接

== Description ==
The plugin allow you customize the information when you share link in Wechat to your friend or timeline or in QQ to your friend or QZone.
Customize description and other meta information has supported in version 1.4.

= Notice =
If you want to share link in Wechat directly, please follow these steps:
1. Verify your account on WeChat Admin Platform.
2. Enter AppID and AppSecret (Development > Basic Configuration).
3. Add your Server IP to IP White List (Development > Basic Configuration > IP whitelist).
4. Add your host to JSAPI Secure Domain (Settings > Account Info > Function setting > JS interface security domain name).
Otherwise you must share link to Wechat via QQ to custom share info, or share in QQ directly.

= Premium Version =
In Premium Verison, you can:
1. Customize share info of taxonomy (Premium Version) (WordPress 4.4 or later).
2. Use all features included in Free Verison.

Only ¥9 for Premium Version:
[https://www.qwqoffice.com/shop.php?mod=product&id=1](https://www.qwqoffice.com/shop.php?mod=product&id=1)

= Update from previous versions of 1.4.1 =
Because the post meta key was changed, you must reset all share information after update.

== Installation ==
Download
Upload to your /wp-contents/plugins/ directory.
Activate the plugin through the 'Plugins' menu in WordPress.

= Configuration =
Go to Setting -> Wechat Share, then check the post type you want to customize the information and save setting. Posts, Pages and Media are default checked post types.

== Frequently Asked Questions ==
= Why I can't find the meta box in other post type? =
Go to Setting > Wechat Share, then check the post type you want to customize the information and save setting.

= Customize the information is not working when I share link in Wechat directly. =
If you want to share link in Wechat directly, please follow these steps:
1. Verify your account on WeChat Admin Platform.
2. Enter AppID and AppSecret (Development > Basic Configuration).
3. Add your Server IP to IP White List (Development > Basic Configuration > IP whitelist).
4. Add your host to JSAPI Secure Domain (Settings > Account Info > Function setting > JS interface security domain name).
Otherwise you must share link to Wechat via QQ to custom share info, or share in QQ directly.

= Home page share information setting is not working. =
Please go to edit page to set the share information if you choose a page as front page.

= How to modify the minimum of first paragraph, which will be showed as the description of post? =
Use the filter `wxcs_first_paragraph_min_length`, example:
```
add_filter( 'wxcs_first_paragraph_min_length', 'change_first_paragraph_min_length' );
function change_first_paragraph_min_length(){
  return 5;
}
```

== Screenshots ==
1. WX Custom Share customize information in post edit page.
2. WX Custom Share setting page.
3. Performance in Wechat.
4. Performance in Wechat timeline.
5. Performance in QQ.
6. Performance in QZone.

== Changelog ==
= 1.5.7 =
* Add: Now you can use the page actual url instead of page permalink.
* Enhance: Support other page share info ( the page which except taxonomy, post type and home page ).
* Enhance: Adjust location of share js file and share script.
* Fixed: PHP Fatal error caused by function is_api_error.

= 1.5.6 =
* Fixed: Share info cannot be saved after click Update button.

= 1.5.5 =
* Fixed: JSTicket outputed to ajax result caused security issue.
* Updated: The tag *Tested up to* in readme.
* Enhance: Debug mode now include the request error.
* Enhance: Use Native JS instead of jQuery for Ajax.
* Enhance: Support customize share info of taxonomy (Premium Version) (WordPress 4.4 or later).

= 1.5.4 =
* Fixed: share info not effective when WeChat JSAPI return a error.

= 1.5.3 =
* Fixed the PHP Fatal error caused by missing argument of function wxcs_is_api_error.

= 1.5.2 =
* Use the WordPress Settings API instead.
* Use Ajax to ensure get the correct share info.
* Add the location of JSAPI Secure Domain and IP White List.

= 1.5.1 =
* Show Public IP in setting page.
* Change language of plugin description to zh_CN.

= 1.5 =
* Add Home Page Share Setting.
* Add Default Icon Setting.
* Use first image as icon from post content when icon and feature image are both not set.
* Use first paragraph that length higher than 10 as description from post content when description not set.

= 1.4.4 =
* Use wp_remote_get instead of file_get_contents.

= 1.4.3 =
* Support WordPress Multisite.
* Update FAQ.

= 1.4.2 =
* Bug fixed:PHP version <= 5.3 not support [] array define.

= 1.4.1 =
* Improved use experience and bug fixed.

= 1.4 =
* Support both Wechat and QQ.
* Support customize title, description and share url.
* Add debug mode, error log will be print to console.

= 1.3.3 =
* Add the notice of wechat share directly.

= 1.3.2 =
* Updated the Text Domain.

= 1.3.1 =
* Bug fixed.

= 1.3 =
* Integrated code into one file.

= 1.2 =
* Add multi language.

= 1.1 =
* Allow select to support other post type.
* Provide a realtime box to show your share link look like.

= 1.0 =
* The first version.

== Upgrade notice ==
= 1.5.7 - Released: Jan 5, 2018 =
* Add: Now you can use the page actual url instead of page permalink.
* Enhance: Support other page share info ( the page which except taxonomy, post type and home page ).
* Enhance: Adjust location of share js file and share script.
* Fixed: PHP Fatal error caused by function is_api_error.

= 1.5.6 - Released: Dec 25, 2017 =
* Fixed: Share info cannot be saved after click Update button.

= 1.5.5 - Released: Dec 19, 2017 =
* Fixed: JSTicket outputed to ajax result caused security issue.
* Updated: The tag *Tested up to* in readme.
* Enhance: Debug mode now include the request error.
* Enhance: Use Native JS instead of jQuery for Ajax.
* Enhance: Support customize share info of taxonomy (Premium Version) (WordPress 4.4 or later).

= 1.5.4 - Released: Dec 12, 2017 =
* Fixed: share info still effective when WeChat JSAPI return a error.

= 1.5.3 - Released: Dec 12, 2017 =
* Fixed the PHP Fatal error caused by missing argument of function wxcs_is_api_error.

= 1.5.2 - Released: Nov 30, 2017 =
* Use the WordPress Settings API instead.
* Use Ajax to ensure get the correct share info.
* Add the location of JSAPI Secure Domain and IP White List.

= 1.5.1 - Released: Sep 12, 2017 =
* Show Public IP in setting page.
* Change language of plugin description to zh_CN.

= 1.5 - Released: Aug 29, 2017 =
* Add Home Share Setting.
* Add Default Icon Setting.
* Use first image as icon from post content when icon and feature image not set.
* Use first paragraph that length higher than 10 as description from post content when description not set.

= 1.4.4 - Released: June 18, 2017 =
* Use wp_remote_get instead of file_get_contents.

= 1.4.3 - Released: May 8, 2017 =
* Support WordPress Multisite.
* Update FAQ.

= 1.4.2 - Released: Apr 17, 2017 =
* Bug fixed: PHP version <= 5.3 not support [] array define.

= 1.4.1 - Released: Apr 15, 2017 =
* Improved use experience and bug fixed.

= 1.4 - Released: Apr 14, 2017 =
* Support both Wechat and QQ.
* Support customize title, description and share url.
* Add debug mode, error log will be print to console.

= 1.3.3 - Released: Apr 12, 2017 =
* Add the notice of wechat share directly.

= 1.3.2 - Released: Apr 9, 2017 =
* Updated the Text Domain.

= 1.3.1 - Released: Mar 30, 2017 =
* Bug fixed.