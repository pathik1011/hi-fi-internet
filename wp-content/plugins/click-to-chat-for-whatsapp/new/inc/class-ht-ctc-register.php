<?php
/**
* three function -  while activate , deactivate , uninstall( while deleting ) 
* as plan to preserve the database options which usefull when reinstall plugin/ update 
*       so that setting wont last
*     and as no custom post types or so.. to flush rewrite rules
*               so deactivate, uninstall not doing any thing here
*
* @package ctc
* @since 2.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Register' ) ) :
    
class HT_CTC_Register {

    // when plugin activate
    public static function activate() {

        
        if( version_compare( get_bloginfo('version'), '3.1.0', '<') )  {
            wp_die( 'please update WordPress' );
        }

        // add default values to options db 
        include_once( HT_CTC_PLUGIN_DIR . '/new/admin/class-ht-ctc-db.php' );
    }
    
    // when plugin deactivate
    public static function deactivate() {
    }

    // when plugin uninstall 
    public static function uninstall() {
        
        $ht_ctc_delete = get_option( 'ht_ctc_delete' );

        // delete plugin settings from db
        if ( isset ( $ht_ctc_delete['delete_options'] ) ) {

            delete_option( 'ht_ctc_main_options' );
            delete_option( 'ht_ctc_chat_options' );
            delete_option( 'ht_ctc_plugin_details' );
            delete_option( 'ht_ctc_group' );
            delete_option( 'ht_ctc_share' );
            delete_option( 'ht_ctc_one_time' );
            delete_option( 'ht_ctc_switch' );
            delete_option( 'ht_ctc_s1' );
            delete_option( 'ht_ctc_s2' );
            delete_option( 'ht_ctc_s3' );
            delete_option( 'ht_ctc_s4' );
            delete_option( 'ht_ctc_s5' );
            delete_option( 'ht_ctc_s6' );
            delete_option( 'ht_ctc_s7' );
            delete_option( 'ht_ctc_s8' );
            delete_option( 'ht_ctc_s99' );

            delete_option( 'ccw_options' );
            delete_option( 'ccw_options_cs' );
            delete_option( 'ht_ccw_ga' );
            delete_option( 'ht_ccw_fb' );
            delete_option( 'ht_ctc_chat_options' );
            
        }

    }

    // for plugin updates - run on plugins_loaded 
    public static function version_check() {
        
        $ht_ctc_plugin_details = get_option('ht_ctc_plugin_details');
    
        if ( HT_CTC_VERSION !== $ht_ctc_plugin_details['version'] ) {
            //  to update the plugin - just like activate plugin
            self::activate();

        }
    }

    // add settings page links in plugins page - at plugin
    public static function plugin_action_links( $links ) {
		$new_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=click-to-chat' ) . '">' . __( 'Settings' , 'click-to-chat-for-whatsapp' ) . '</a>',
		);

		return array_merge( $new_links, $links );
	}

    

}

endif; // END class_exists check