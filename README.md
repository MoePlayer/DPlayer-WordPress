## DPlayer-WordPress: DPlayer for WordPress

[DPlayer](https://github.com/DIYgod/DPlayer) is such a lovely HTML5 danmaku video player by [DIYGod](https://github.com/DIYgod), and it's used on many platforms (as listed below). 
- [DPlayer-for-typecho](https://github.com/volio/DPlayer-for-typecho)

- [Hexo-tag-dplayer](https://github.com/NextMoe/hexo-tag-dplayer)

- [DPlayer_for_Z-BlogPHP](https://github.com/fghrsh/DPlayer_for_Z-BlogPHP)

- [纸飞机视频区插件(DPlayer for Discuz!)](https://coding.net/u/Click_04/p/video/git)

- [dplayer_py_backend](https://github.com/dixyes/dplayer_py_backend)

- [dplayer_lua_backend](https://github.com/dixyes/dplayer_lua_backend)

Today, DPlayer is coming to WordPress.

Usage is rather simple, and here is the template of shortcode we supported.
[dplayer url="http://xxx.xxx.com/xxx.mp4" pic="http://xxx.xxx.com/xxx.png" autoplay="true" danmu="true"/]

Parameter 'url' is the source URL to the video file, you can upload the video to your WordPress library, then use it here.
Parameter 'pic' is the poster of the video. And it's optional.
Parameter 'autoplay', as the name suggests, if it is true, then once the video is prepared, it starts to play . Default false and it's optional also.
Parameter 'danmu', should DPlayer load danmaku. Default false and it's optional.