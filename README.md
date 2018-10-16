## DPlayer-WordPress: DPlayer for WordPress

[DPlayer](https://github.com/DIYgod/DPlayer) is such a lovely HTML5 danmaku video player by [DIYGod](https://github.com/DIYgod), and it's used on many platforms (as listed below). 
- [DPlayer-for-typecho](https://github.com/volio/DPlayer-for-typecho)

- [Hexo-tag-dplayer](https://github.com/NextMoe/hexo-tag-dplayer)

- [DPlayer_for_Z-BlogPHP](https://github.com/fghrsh/DPlayer_for_Z-BlogPHP)

- [纸飞机视频区插件(DPlayer for Discuz!)](https://coding.net/u/Click_04/p/video/git)

- [dplayer_py_backend](https://github.com/dixyes/dplayer_py_backend)

- [dplayer_lua_backend](https://github.com/dixyes/dplayer_lua_backend)

Today, DPlayer is coming to WordPress.

### shortcode速查

| 名称                 | shortcode            | 默认值                             | 描述                                                         |
| -------------------- | -------------------- | ---------------------------------- | ------------------------------------------------------------ |
| container            | -                    | document.querySelector('.dplayer') | 播放器容器元素                                               |
| live                 | live                 | false                              | 开启直播模式, [详情](http://dplayer.js.org/#/home?id=live)   |
| autoplay             | autoplay             | false                              | 视频自动播放                                                 |
| theme                | theme                | '#FADFA3'                          | 主题色                                                       |
| loop                 | loop                 | false                              | 视频循环播放                                                 |
| lang                 | lang                 | navigator.language.toLowerCase()   | 可选值: 'en', 'zh-cn', 'zh-tw'                               |
| screenshot           | screenshot           | false                              | 开启截图，如果开启，视频和视频封面需要开启跨域               |
| hotkey               | hotkey               | true                               | 开启热键                                                     |
| preload              | preload              | 'metadata'                         | 预加载，可选值: 'none', 'metadata', 'auto'                   |
| volume               | volume               | 0.7                                | 默认音量，请注意播放器会记忆用户设置，用户手动设置音量后默认音量即失效 |
| logo                 | logo                 | -                                  | 在左上角展示一个 logo，你可以通过 CSS 调整它的大小和位置     |
| apiBackend           | 暂不支持，请自己hack | -                                  | 自定义获取和发送弹幕行为，[详情](http://dplayer.js.org/#/home?id=live) |
| video                |                      | -                                  | 视频信息                                                     |
| video.quality        | 暂不支持，请自己hack | -                                  | [详情](http://dplayer.js.org/#/home?id=quality-switching)    |
| video.defaultQuality | 暂不支持，请自己hack | -                                  | [详情](http://dplayer.js.org/#/home?id=quality-switching)    |
| video.url            | url                  | -                                  | 视频链接                                                     |
| video.pic            | pic                  | -                                  | 视频封面                                                     |
| video.thumbnails     | thumbnails           | -                                  | 视频缩略图，可以使用 [DPlayer-thumbnails](https://github.com/MoePlayer/DPlayer-thumbnails) 生成 |
| video.type           | type                 | 'auto'                             | 可选值: 'auto', 'hls', 'flv', 'dash', 'webtorrent', 'normal' 或其他自定义类型, [详情](http://dplayer.js.org/#/home?id=mse-support) |
| video.customType     | 暂不支持，请自己hack | -                                  | 自定义类型, [详情](http://dplayer.js.org/#/home?id=mse-support) |
| subtitle             |                      | -                                  | 外挂字幕                                                     |
| subtitle.url         | subtitleurl          | `required`                         | 字幕链接                                                     |
| subtitle.type        | subtitletype         | 'webvtt'                           | 字幕类型，可选值: 'webvtt', 'ass'，目前只支持 webvtt         |
| subtitle.fontSize    | subtitlefontsize     | '20px'                             | 字幕字号                                                     |
| subtitle.bottom      | subtitlebottom       | '40px'                             | 字幕距离播放器底部的距离，取值形如: '10px' '10%'             |
| subtitle.color       | subtitlecolor        | '#b7daff'                          | 字幕颜色                                                     |
| danmaku              | danma                | true                               | 显示弹幕                                                     |
| danmaku.id           | id                   | md5($id), 参考line 106             | 弹幕池id，必须唯一                                           |
| danmaku.api          | 插件设置页面         | `required`                         | [详情](http://dplayer.js.org/#/home?id=danmaku-api)          |
| danmaku.token        | 插件设置页面         | -                                  | 弹幕后端验证 token                                           |
| danmaku.maximum      | maximum              | -                                  | 弹幕最大数量                                                 |
| danmaku.addition     | addition             | 使用`-A-`连接多个URL               | 额外外挂弹幕，[详情](http://dplayer.js.org/#/home?id=bilibili-danmaku) |
| danmaku.user         | user                 | 'DIYgod'                           | 弹幕用户名                                                   |
| danmaku.bottom       | bottom               | -                                  | 弹幕距离播放器底部的距离，防止遮挡字幕，取值形如: '10px' '10%' |
| danmaku.unlimited    | unlimited            | false                              | 海量弹幕模式，即使重叠也展示全部弹幕，请注意播放器会记忆用户设置，用户手动设置后即失效 |
| contextmenu          | 暂不支持，请自己hack | []                                 | 自定义右键菜单                                               |
| highlight            | 暂不支持，请自己hack | []                                 | 自定义进度条提示点                                           |
| mutex                | mutex                | true                               | 互斥，阻止多个播放器同时播放，当前播放器播放时暂停其他播放器 |

### Screenshots

1. Write the shortcode manually in your editor
![Screenshot 1](https://raw.githubusercontent.com/MoePlayer/DPlayer-WordPress/master/assets/screenshot-1.png)

2. Save and you’ll get this lovely danmuku video player!
![Screenshot 2](https://raw.githubusercontent.com/MoePlayer/DPlayer-WordPress/master/assets/screenshot-2.png)

3. Now we can edit danmaku API URL and token in settings page
![Screenshot 3](https://raw.githubusercontent.com/MoePlayer/DPlayer-WordPress/master/assets/screenshot-3.png)
