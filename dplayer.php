<?php
/*
* Plugin Name: DPlayer for WordPress
* Description: Wow, such a lovely HTML5 danmaku video player comes to WordPress
* Version: 1.1.3
* Author: 0xBBC
* Author URI: https://blog.0xbbc.com/
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
*
* Acknowledgement
*  DPlayer by DIYgod
*    https://github.com/DIYgod/DPlayer
*
*  And part of this work is done under Copy and paste programming :)
*    Thanks to https://github.com/volio/DPlayer-for-typecho
*/

require_once( dirname( __FILE__ ) . '/dplayer-admin.php' );

class DPlayer {
    static $add_script;
    
    public static function init() {
        register_activation_hook( __FILE__, array( __CLASS__, 'dplayer_install' ) );
        register_deactivation_hook( __FILE__, array( __CLASS__, 'dplayer_uninstall' ) );
        add_action( 'wp_head', array( __CLASS__, 'ready') );
        add_action( 'wp_footer', array( __CLASS__, 'add_script' ) );
        add_shortcode( 'dplayer', array( __CLASS__, 'dplayer_load') );
        add_filter( 'plugin_action_links', array( __CLASS__, 'dplayer_settings_link' ), 9, 2 );
    }
    
    public static function ready() {
?>
<script>var dPlayers = [];var dPlayerOptions = [];</script>
<?php
    }
    
    // registers default options
    public static function dplayer_install() {
        add_option( 'kblog_danmaku_url', '//danmaku.daoapp.io' );
        add_option( 'kblog_danmaku_token', 'tokendemo' );
    }
    
    public static function dplayer_uninstall() {
        delete_option( 'kblog_danmaku_url' );
        delete_option( 'kblog_danmaku_token' );
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
            'token' => get_option( 'kblog_danmaku_token', '' ),
            'api' => get_option( 'kblog_danmaku_url', '' ),
        );
        if ($atts['bilibili']) $danmaku['addition'] = array(get_option( 'kblog_danmaku_url', '' ).'bilibili?aid='.$atts['bilibili']);
        $data['danmaku'] = ($atts['danmu'] != 'false') ? $danmaku : null;

        $js = json_encode($data);
        $playerCode .= <<<EOF
<script>dPlayerOptions.push({$js});</script>
EOF;
        return $playerCode;
    }
    
    public static function dplayer_settings_link( $links, $file ) {
        if ( plugins_url('dplayer-admin.php', __FILE__) === $file && function_exists( 'admin_url' ) ) {
            $settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=kblog-dplayer' ) ) . '">' . esc_html__( 'Settings' ) . '</a>';
            array_unshift( $links, $settings_link );
        }
        return $links;
    }
    
    public static function add_script() {
        if (!self::$add_script) {
            if ( get_option( 'kblog_enable_flv' ) ) {
                wp_enqueue_script( '0-dplayer-flv', plugins_url('js/plugin/flv.min.js', __FILE__), false, '1.1.2', false );
            }
            if ( get_option( 'kblog_enable_hls' ) ) {
                wp_enqueue_script( '0-dplayer-hls', plugins_url('js/plugin/hls.min.js', __FILE__), false, '1.1.2', false );
            }
            wp_enqueue_script( 'dplayer', plugins_url('js/DPlayer.min.js', __FILE__), false, '1.1.2', false );
            wp_enqueue_script( 'init-dplayer', plugins_url('js/init-dplayer.js', __FILE__), false, '1.0.0', false );
            self::$add_script = true;
        } 
    }
};

DPlayer::init();
