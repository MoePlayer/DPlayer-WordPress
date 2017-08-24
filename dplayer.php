<?php
/*
* Plugin Name: DPlayer for WordPress
* Description: Wow, such a lovely HTML5 danmaku video player comes to WordPress
* Version: 1.2.2
* Author: 0xBBC
* Author URI: https://blog.0xbbc.com/
* License: GPLv3
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
*
* Acknowledgement
*  DPlayer by DIYgod
*    https://github.com/MoePlayer/DPlayer
*
*  And part of this work is done under Copy and paste programming :)
*    Thanks to https://github.com/MoePlayer/DPlayer-Typecho
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
        add_option( 'kblog_danmaku_dplayer_version', '1.6.1' );
        add_option( 'kblog_danmaku_dplayer_version_check', '0' );
    }
    
    public static function dplayer_uninstall() {
        delete_option( 'kblog_danmaku_url' );
        delete_option( 'kblog_danmaku_token' );
        delete_option( 'kblog_danmaku_dplayer_version' );
        delete_option( 'kblog_danmaku_dplayer_version_check' );
    }
    
    public static function dplayer_bilibili_url_handler($bilibili_url) {
        $aid = 0;
        $page = 1;
        $is_bilibili = false;
        if (preg_match('/^[\d]+$/', $bilibili_url)) {
            $aid = $bilibili_url;
            $is_bilibili = true;
        } else {
            $parsed = parse_url($bilibili_url);
            if ($parsed['host'] === 'www.bilibili.com') {
                preg_match('/^\/video\/av([\d]+)(?:\/index_([\d]+)\.html)?/', $parsed['path'], $path_match);
                if ($path_match) {
                    $is_bilibili = true;
                    $aid = $path_match[1];
                    $page = $path_match[2] == null ? 1 : $path_match[2];
                    preg_match('/^page=([\d]+)$/', $parsed['fragment'], $page_match);
                    if ($page_match) $page = $page_match[1];
                }
            }
        }

        if ($is_bilibili) {
            if ($page == 1) {
                $danmaku_url = stripslashes(get_option( 'kblog_danmaku_url', '' ));
                return array('danma' => $danmaku_url.'bilibili?aid='.$aid, 'video' => $danmaku_url.'/video/bilibili?aid='.$aid);
            } else {
                $cid = -1;
                $json_response = @json_decode(gzdecode(file_get_contents('http://www.bilibili.com/widget/getPageList?aid='.$aid)), true);
                if ($json_response) {
                    foreach ($json_response as $page_info) {
                        if ($page_info['page'] == $page) {
                            $cid = $page_info['cid'];
                            break;
                        }
                    }
                }
                
                if ($cid != -1) {
                    return array('danma' => $danmaku_url.'bilibili?cid='.$cid, 'video' => $danmaku_url.'/video/bilibili?cid='.$cid);
                }
            }
        }
        return null;
    }
    
    public static function dplayer_load($atts, $content, $tag) {
        if ($atts == null) $atts = [];
        if ($tag == null) $tag = '';
        
        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        $bilibili_param = $atts['bilibili'] ? $atts['bilibili'] : '';
        $id = md5($_SERVER['HTTP_HOST'] . $atts['url'] . $bilibili_param);
        $result = array(
            'url' => $atts['url'] ? $atts['url'] : '',
            'pic' => $atts['pic'] ? $atts['pic'] : '',
            'type' => $atts['type'] ? $atts['type'] : 'auto', 
        );
        
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

        $danmaku = array(
            'id' => md5($id),
            'token' => get_option( 'kblog_danmaku_token', '' ),
            'api' => get_option( 'kblog_danmaku_url', '' ),
        );
        
        if ($bilibili_param) {
            $bilibili_parsed = DPlayer::dplayer_bilibili_url_handler($bilibili_param);
            $danmaku['addition'] = array($bilibili_parsed['danma']);
            if ($danmaku['addition'] && empty($atts['url'])) {
                $result['url'] = $bilibili_parsed['video'];
            }
        }
        
        $data['video'] = $result;
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
                wp_enqueue_script( '0-dplayer-flv', plugins_url('dplayer/plugin/flv.min.js', __FILE__), false, '1.4.0', false );
            }
            if ( get_option( 'kblog_enable_hls' ) ) {
                wp_enqueue_script( '0-dplayer-hls', plugins_url('dplayer/plugin/hls.min.js', __FILE__), false, '1.4.0', false );
            }
            
            $current_time = time();
            $last_check = (int)get_option( 'kblog_danmaku_dplayer_version_check', '0' );
            $dplayer_version = get_option( 'kblog_danmaku_dplayer_version', '1.6.1' );
            
            if ($current_time - $last_check > 86400 /* 86400 = 60 * 60 * 24 i.e 24hrs */) {
                $response = wp_remote_get( 'https://cdnjs.cat.net/ajax/libs/dplayer/package.json' );
                if ( is_array( $response ) && ! is_wp_error( $response ) ) {
                    $body = $response['body']; // use the content
                    $json_data = @json_decode($body, true);
                    $json_dplayer_version = @$json_data['version'];
                    if (preg_grep('/^[\d\.]+$/', $json_dplayer_version)) {
                        if (strcmp($dplayer_version, $json_dplayer_version) != 0) {
                            update_option( 'kblog_danmaku_dplayer_version', $json_dplayer_version );
                            $dplayer_version = $json_dplayer_version;
                        }
                    }
                }
                update_option( 'kblog_danmaku_dplayer_version_check', $current_time );
            }
            
            wp_enqueue_style( 'dplayer', esc_url("https://cdnjs.cat.net/ajax/libs/dplayer/$dplayer_version/DPlayer.min.css"), false, $dplayer_version, false );
            wp_enqueue_script( 'dplayer', esc_url("https://cdnjs.cat.net/ajax/libs/dplayer/$dplayer_version/DPlayer.min.js"), false, $dplayer_version, false );
            wp_enqueue_script( 'init-dplayer', plugins_url('dplayer/init-dplayer.js', __FILE__), false, '1.0.0', false );
            self::$add_script = true;
        } 
    }
};

DPlayer::init();
