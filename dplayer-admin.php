<?php
/*
 * The contents of this file are subject to the GPL License, Version 3.0.
 *
 * Copyright (C) 2016, 0xBBC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class DPlayer_Admin {

    static $admin_tags = array(
        'input' => array(
            'type' => array(),
            'name' => array(),
            'id' => array(),
            'disabled' => array(),
            'value' => array(),
            'checked' => array(),
        ),
    );

    function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_page_init' ) );
    }

    function admin_page_init() {
        add_options_page( 'DPlayer', 'DPlayer', 'manage_options', 'kblog-dplayer', array( $this, 'plugin_options_menu' ) );
    }

    function plugin_options_menu() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); //xss ok
        }

        $this->table_head();

        // save options if this is a valid post
        if ( isset( $_POST['kblog_dplayer_save_field'] ) && // input var okay
            wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kblog_dplayer_save_field'] ) ), 'kblog_dplayer_save_action' ) // input var okay
        ) {
            echo "<div class='updated settings-error' id='etting-error-settings_updated'><p><strong>Settings saved.</strong></p></div>\n";
            $this->admin_save();
        }

        $danmaku_url          = "value='" . esc_attr( get_option( 'kblog_danmaku_url', '' ) ) . "'";
        $this->admin_table_row( 'Danmaku URL',
            'Danmaku URL, please include https:// or http://',
            "<input type='textbox' name='kblog_danmaku_url' id='kblog_danmaku_url' $danmaku_url>",
            'kblog_danmaku_url'
        );
        
        $danmaku_token        = "value='" . esc_attr( get_option( 'kblog_danmaku_token', '' ) ) . "'";
        $this->admin_table_row( 'Token',
            'Danmaku Token',
            "<input type='textbox' name='kblog_danmaku_token' id='kblog_danmaku_token' $danmaku_token>",
            'kblog_danmaku_token'
        );
        
        $enable_hls = '';
        if ( get_option( 'kblog_enable_hls' ) ) {
            $enable_hls = 'checked="true"';
        }
        $this->admin_table_row( 'Enable hls.js',
            'Live Video (HTTP Live Streaming, M3U8 format) support',
            "<input type='checkbox' name='kblog_enable_hls' id='kblog_enable_hls' value='1' $enable_hls />",
            'kblog_enable_hls'
        );
        
        $enable_flv = '';
        if ( get_option( 'kblog_enable_flv' ) ) {
            $enable_flv = 'checked="true"';
        }
        $this->admin_table_row( 'Enable flv.js',
            'FLV format support',
            "<input type='checkbox' name='kblog_enable_flv' id='kblog_enable_flv' value='1' $enable_flv />",
            'kblog_enable_flv'
        );

        $this->table_foot();
    }

    function admin_save() {
        if ( array_key_exists( 'kblog_danmaku_url', $_POST ) && isset( $_POST['kblog_danmaku_url'] ) ) { // input var okay
            update_option( 'kblog_danmaku_url', esc_url_raw( wp_unslash( $_POST['kblog_danmaku_url'] ) ) ); // input var okay
        }
        
        if ( array_key_exists( 'kblog_danmaku_token', $_POST ) && isset( $_POST['kblog_danmaku_token'] ) ) { // input var okay
            update_option( 'kblog_danmaku_token', wp_unslash( $_POST['kblog_danmaku_token'] ) ); // input var okay
        }
        
        update_option( 'kblog_enable_hls', array_key_exists( 'kblog_enable_hls', $_POST ) ); // input var okay
        update_option( 'kblog_enable_flv', array_key_exists( 'kblog_enable_flv', $_POST ) ); // input var okay
    }

    function table_head() {
        ?>
        <div class='wrap' id='dplayer-options'>
            <h2>DPlayer for WordPress</h2>
            <form id='dplayer-for-wordpress' name='dplayer-for-wordpress' action='' method='POST'>
                <?php wp_nonce_field( 'kblog_dplayer_save_action', 'kblog_dplayer_save_field', true ); ?>
            <table class='form-table'>
            <caption class='screen-reader-text'>DPlayer设置</caption>
        <?php
    }

    function table_foot() {
        ?>
        </table>
        <p class="submit"><input type="submit" class="button button-primary" value="Save Changes"/></p>
        </form>
        </div>
    <?php
    }

    function admin_table_row( $head, $comment, $input, $input_id ) {
        ?>
            <tr valign="top">
                    <th scope="row">
                        <label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $head ); ?></label>
                    </th>
                    <td>
                        <?php echo wp_kses( $input, self::$admin_tags ); ?>
                        <p class="description"><?php echo wp_kses_post( $comment ); ?></p>
                    </td>
                </tr>
<?php
    }
} // class

function dplayer_admin_init() {
    global $dplayer_admin;
    $dplayer_admin = new DPlayer_Admin();
}

if ( is_admin() ) {
    dplayer_admin_init();
}
