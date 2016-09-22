=== Plugin Name ===
Contributors: 0xbbc
Tags: video, player, shortcode
Requires at least: 3.0.1
Tested up to: 4.6.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.

== Description ==

[DPlayer](http://github.com/DIYgod/DPlayer) is such a lovely HTML5 danmaku video player by DIYGod, and it's used on many platforms. 
Today, DPlayer is coming to WordPress.

Usage is rather simple, and here is the template of shortcode we supported.
[dplayer url="http://xxx.xxx.com/xxx.mp4" pic="http://xxx.xxx.com/xxx.png" autoplay="true" danmu="true"/]

Parameter 'url' is the source URL to the video file, you can upload the video to your WordPress library, then use it here.
Parameter 'pic' is the poster of the video. And it's optional.
Parameter 'autoplay', as the name suggests, if it is true, then once the video is prepared, it starts to play . Default false and it is optional also.
Parameter 'screenshot', enable screenshot?. Optional and default false.
Parameter 'loop', enable loop?. Optional and default false.
Parameter 'preload', preload mode, 'auto', 'metatdata' or 'none'. Optional and default metadata.
Parameter 'hotkey', enable builtin hotkey? including left, right and Space. Optional and default true.
Parameter 'danmu', should DPlayer load danmaku. Default false and it's optional.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/dplayer` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. No configuration is needed, enjoy it!

== Screenshots ==

1. Write the shortcode manually in your editor
2. Save and you’ll get this lovely danmuku video player!

== Changelog ==

= 1.0.4=
* Upgrade to GPLv2 License

= 1.0.3=
* Fixed a bug when assign default value

= 1.0.2 =
* Conform to the WordPress readme.txt standard
* Add screenshots

= 1.0.1 =
* Returns the generated code instead of echoing it

= 1.0.0 =
* Initial version

== Upgrade Notice ==

= 1.0.1 =
* Returns the generated code instead of echoing it
