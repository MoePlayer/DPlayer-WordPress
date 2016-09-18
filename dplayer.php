<?php
/*
* Plugin Name: DPlayer for WordPress
* Description: Wow, such a lovely HTML5 danmaku video player comes to WordPress
* Version: 1.0
* Author: BlueCocoa(WordPress Plugins)
* Author URI: https://blog.0xbbc.com/
*
* Acknowledgement
*  Part of this work is done under Copy and paste programming :)
*  Thanks to https://github.com/volio/DPlayer-for-typecho
*/

/*
The Star And Thank Author License (SATA)

Copyright (c) 2016 DIYgod(i@html.love)

Project Url: https://github.com/DIYgod/DPlayer

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

And wait, the most important, you shall star/+1/like the project(s) in project url
section above first, and then thank the author(s) in Copyright section.

Here are some suggested ways:

 - Email the authors a thank-you letter, and make friends with him/her/them.
 - Report bugs or issues.
 - Tell friends what a wonderful project this is.
 - And, sure, you can just express thanks in your mind without telling the world.

Contributors of this project by forking have the option to add his/her name and
forked project url at copyright and project url sections, but shall not delete
or modify anything else in these two sections.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

class DPlayer {
    static $add_script;
    
    public static function init() {
        add_action( 'wp_head', array( __CLASS__, 'ready') );
        add_action( 'wp_footer', array( __CLASS__, 'add_script' ) );
        add_shortcode( 'dplayer', array( __CLASS__, 'dplayer_load') );
    }
    
    public static function ready() {
?>
<script>var dPlayers = [];var dPlayerOptions = [];</script>;
<?php
    }
    
    public static function dplayer_load($atts = [], $content = null, $tag = '') {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        
        $id = md5($_SERVER['HTTP_HOST'] . $atts['url']);
        $result = array(
            'url' => $atts['url'] ? $atts['url'] : '',
            'pic' => $atts['pic'] ? $atts['pic'] : ''
        );
        if (empty($result)) return;
        
        $theme = $atts['theme'];
        if (!$theme) $theme = '#FADFA3';

        $data = array(
            'id' => $id,
            'autoplay' => false,
            'theme' => $theme
        );

        $data['autoplay'] = ($atts['autoplay'] == 'true') ? true : false;

        $playerCode = '<div id="player'.$id.'" class="dplayer">';
        $playerCode .= "</div>\n";
        $data['video'] = $result;

        $danmaku = array(
            'id' => md5($id),
            'token' => md5(md5($id) . date('YmdH', time())),
            'api' => '//danmaku.daoapp.io/dplayer/danmaku',
        );
        $data['danmaku'] = ($atts['danmu'] != 'false') ? $danmaku : null;

        $js = json_encode($data);
        $playerCode .= <<<EOF
<script>dPlayerOptions.push({$js});</script>
EOF;
        echo $playerCode;
    }
    
    public static function add_script() {
        if (!self::$add_script) {
            wp_enqueue_script( 'dplayer', site_url('/wp-content/plugins/dplayer/js/DPlayer.min.js'), false, '1.0.9', false );
            wp_enqueue_script( 'dplayer-hls', site_url('/wp-content/plugins/dplayer/js/plugins/hls.min.js'), false, '1.0.9', false );
            wp_enqueue_script( 'init-dplayer', site_url('/wp-content/plugins/dplayer/js/init-dplayer.js'), false, '1.0.0', false );
            self::$add_script = true;
        } 
    }
};

DPlayer::init();
