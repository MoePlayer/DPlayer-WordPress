=== Plugin Name ===
Contributors: 0xbbc
Tags: video, player, shortcode
Requires at least: 3.0.1
Tested up to: 4.8.0
Stable tag: 1.1.9
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

[DPlayer](http://github.com/DIYgod/DPlayer) is such a lovely HTML5 danmaku video player by DIYGod, and it's used on many platforms. 
Today, DPlayer is coming to WordPress.

Usage is rather simple, and here is the template of shortcode we supported.
[dplayer url="https://anotherhome.net/DIYgod-cannot-even-discribe.mp4" pic="https://anotherhome.com/DIYgod-cannot-even-discribe.png" autoplay="true" danmu="true"/]

Parameter 'url' is the source URL to the video file, you can upload the video to your WordPress library, then use it here.
Parameter 'pic' is the poster of the video. And it's optional.
Parameter 'autoplay', as the name suggests, if it is true, then once the video is prepared, it starts to play . Default false and it is optional also.
Parameter 'screenshot', enable screenshot?. Optional and default false.
Parameter 'loop', enable loop?. Optional and default false.
Parameter 'preload', preload mode, 'auto', 'metatdata' or 'none'. Optional and default metadata.
Parameter 'hotkey', enable builtin hotkey? including left, right and Space. Optional and default true.
Parameter 'bilibili', bilibili视频AV号 或者 完整的bilibili视频链接. Additional danmaku from bilibili
Parameter 'danmu', should DPlayer load danmaku. Default false and it's optional.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/dplayer` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. No configuration is needed, enjoy it!

== Screenshots ==

1. Write the shortcode manually in your editor
2. Save and you’ll get this lovely danmuku video player!
3. Config Danmaku API URL and token in settings page

== Changelog ==

= 1.1.8 =
Using the right API to enqueue DPlayer CSS.

= 1.1.7 =
Update DPlayer to release 1.4.0. Please visit https://github.com/DIYgod/DPlayer/releases for details.

= 1.1.6 =
Improve compatibility on old versions of PHP.

= 1.1.5 =
Update DPlayer to release 1.1.3. Please visit https://github.com/DIYgod/DPlayer/releases for details.

= 1.1.4 =
* Extended support for bilibili param, now you can use either
- bilibili='23333'
- bilibili='http://www.bilibili.com/video/av2333333/index_233.html#page=2333'
to load additional danmaku. 

This plugin will give you exactly the danma that you need, which means, 

If you give the original URL to the bilibili video, this plugin will identify the URL format, load the right danmaku. In this example, 'http://www.bilibili.com/video/av2333333/index_23333#page=233' is given. And the plugin knows that aid is 2333333 and your requested page is 2333. (According to bilibili, 'index_233.html#page=2333' means that you starts at page 233 but currently you're watching page 2333)

= 1.1.3 =
* Fixed bilibili danmaku support

= 1.1.2 =
* Update DPlayer to version 1.1.2
* Add support for hls.min.js
* Add support for flv.min.js

= 1.0.9 =
* Update DPlayer to version 1.1.1

= 1.0.8 =
* Add settings page for API URL and token

= 1.0.7 =
* Change to new API URL '//danmaku.daoapp.io/'
* Update DPlayer to 1.0.10

= 1.0.6 =
* Compatibility with PHP 5
	
= 1.0.5 =
* Using preload="metadata" in js/DPlayer.min.js

= 1.0.4 =
* Upgrade to GPLv2 License

= 1.0.3 =
* Fixed a bug when assign default value

= 1.0.2 =
* Conform to the WordPress readme.txt standard
* Add screenshots

= 1.0.1 =
* Returns the generated code instead of echoing it

= 1.0.0 =w
* Initial version

== Upgrade Notice ==

= 1.0.1 =
* Returns the generated code instead of echoing it
