<?php
/**
 * Plugin Name:          Dot Cookie Consent
 * Plugin URI:           https://dotdigital.com.br/
 * Description:          Cookie consent notification
 * Author:               DotDigital
 * Version:              1.0
 * License:              GPLv3 or later
 * Text Domain:          dot-cookie-consent
 * Domain Path:          /languages
 * WC requires at least: 5.5.0
 * WC tested up to:      5.9.3
 */

defined( 'ABSPATH' ) || exit;


if( ! class_exists('DOT_Cookie_Consent') ){
    class DOT_Cookie_Consent {
        function __construct(){
            $this->define_constants();

            add_action( 'admin_menu', [ $this, 'add_menu' ] );

            add_action( 'wp_footer', [ $this, 'dotcc_hook_footer' ] );

            require_once( DOT_COOKIE_CONSENT_PATH . 'class.dot-cookie-consent-settings.php' );
            $DOT_Cookie_Consent_Settings = new DOT_Cookie_Consent_Settings();
        }

        public function define_constants(){
            define( 'DOT_COOKIE_CONSENT_PATH', plugin_dir_path( __FILE__ ) );
            define( 'DOT_COOKIE_CONSENT_URL', plugin_dir_url( __FILE__ ) );
            define( 'DOT_COOKIE_CONSENT_VERSION', '1.0.0' );
        }

        public static function activate(){
            update_option( 'rewrite_rules', '' );

            $dotcc_db_version = get_option( 'dot_cookie_consent_db_version' );

            if( empty($dotcc_db_version) ){
                $dotcc_db_version = DOT_COOKIE_CONSENT_VERSION;
                add_option( 'dot_cookie_consent_db_version', $dotcc_db_version );
            }

            $dotcc_data = get_option( 'dot_cookie_consent_options' );

            if( empty($dotcc_data) ){
                $dotcc_data = [
                    'dot_cookie_consent_description' => 'Este site usa cookies. Ao continuar a usar este site, você concorda com seu uso.',
                    'dot_cookie_consent_privacy_policy_title' => 'Política de privacidade',
                    'dot_cookie_consent_privacy_policy_url' => get_site_url(),
                ];
                add_option( 'dot_cookie_consent_options', $dotcc_data );
            }
        }

        public static function deactivate(){
            flush_rewrite_rules();
        }

        public static function uninstall(){

        }

        function add_menu() {

            add_options_page(
                'Dot Cookie Consent Options',
                'DotCookieConsent',
                'manage_options',
                'dot_cookie_consent_admin',
                [ $this, 'dot_cookie_consent_settings_page' ]
            );
        }

        function dot_cookie_consent_settings_page(){
            if( ! current_user_can( 'manage_options' )){
                return;
            }

            require( DOT_COOKIE_CONSENT_PATH . 'views/settings-page.php' );
        }


        function dotcc_hook_footer() {
        
            require_once( DOT_COOKIE_CONSENT_PATH . '/views/dotcc_code.php' );
        }


        
    }
}

if( class_exists('DOT_Cookie_Consent') ){

    register_activation_hook( __FILE__, [ 'DOT_Cookie_Consent', 'activate' ] );
    register_deactivation_hook( __FILE__, [ 'DOT_Cookie_Consent', 'deactivate' ] );
    register_uninstall_hook( __FILE__, [ 'DOT_Cookie_Consent', 'uninstall' ] );
    $dot_cookie_consent = new DOT_Cookie_Consent();
}
