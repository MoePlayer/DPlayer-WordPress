<?php
/*
* Plugin Name: DPlayer for WordPress
* Description: Wow, such a lovely HTML5 danmaku video player comes to WordPress
* Version: 1.0.4
* Author: 0xBBC
* Author URI: https://blog.0xbbc.com/
* License: GPLv2
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*
* Acknowledgement
*  DPlayer by DIYgod
*    https://github.com/DIYgod/DPlayer
*
*  And part of this work is done under Copy and paste programming :)
*    Thanks to https://github.com/volio/DPlayer-for-typecho
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
<script>var dPlayers = [];var dPlayerOptions = [];</script>
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
            'theme' => $theme,
            'loop' => false,
            'screenshot' => false,
            'hotkey' => true,
            'preload' => 'metadata'
        );

        if ($atts['autoplay']) $data['autoplay'] = ($atts['autoplay'] == 'true') ? true : false;
        if ($atts['loop']) $data['loop'] = ($atts['loop'] == 'true') ? true : false;
        if ($atts['screenshot']) $data['screenshot'] = ($atts['screenshot'] == 'true') ? true : false;
        if ($atts['hotkey']) $data['hotkey'] = ($atts['hotkey'] == 'true') ? true : false;
        if ($atts['preload']) $data['preload'] = (in_array($atts['preload'], array('auto', 'metadata', 'none')) == true) ? $atts['preload'] : 'metadata';

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
        return $playerCode;
    }
    
    public static function add_script() {
        if (!self::$add_script) {
            wp_enqueue_script( 'dplayer', plugins_url('js/DPlayer.min.js', __FILE__), false, '1.0.9', false );
            wp_enqueue_script( 'init-dplayer', plugins_url('js/init-dplayer.js', __FILE__), false, '1.0.0', false );
            self::$add_script = true;
        } 
    }
};

DPlayer::init();
