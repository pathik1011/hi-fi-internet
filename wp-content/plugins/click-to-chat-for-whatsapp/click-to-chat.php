<?php
/*
Plugin Name: Click to Chat
Plugin URI:  https://wordpress.org/plugins/click-to-chat-for-whatsapp/
Description: Lets make your Web page visitor contact you through WhatsApp with a single click/tap
Version:     2.3
Author:      HoliThemes
Author URI:  https://holithemes.com/plugins/click-to-chat/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: click-to-chat-for-whatsapp
*/

if ( ! defined( 'WPINC' ) ) {
	die('dont try to call this directly');
}

// new interface - ctc - Version
if ( ! defined( 'HT_CTC_VERSION' ) ) {
	define( 'HT_CTC_VERSION', '2.3' );
}

// for previous interface - define HT_CCW_VERSION
if ( ! defined( 'HT_CCW_VERSION' ) ) {
	define( 'HT_CCW_VERSION', '1.7.4' );
}

// define HT_CTC_PLUGIN_FILE
if ( ! defined( 'HT_CTC_PLUGIN_FILE' ) ) {
	define( 'HT_CTC_PLUGIN_FILE', __FILE__ );
}

// define HT_CTC_PLUGIN_DIR
if ( ! defined( 'HT_CTC_PLUGIN_DIR' ) ) {
	define( 'HT_CTC_PLUGIN_DIR', plugin_dir_path( HT_CTC_PLUGIN_FILE ) );
}

// prev compatibility - define HT_CCW_PLUGIN_FILE
if ( ! defined( 'HT_CCW_PLUGIN_FILE' ) ) {
	define( 'HT_CCW_PLUGIN_FILE', __FILE__ );
}

include_once 'common/class-ht-ctc-switch.php';