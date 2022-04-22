<?php

if( !class_exists( 'DOT_Cookie_Consent_Settings' )){

    class DOT_Cookie_Consent_Settings
    {
        public static $options;

        public function __construct()
        {
            self::$options = get_option( 'dot_cookie_consent_options' );
            add_action( 'admin_init', [ $this, 'admin_init'] );
        }

        public function admin_init(){

            register_setting(
                'dot_cookie_consent_group',
                'dot_cookie_consent_options',
                [ $this, 'dot_cookie_consent_validate']
            );

            add_settings_section(
                'dot_cookie_consent_main_section',
                'How does it work?',
                null,
                'dot_cookie_consent_page_1'
            );



            add_settings_field(
                'dot_cookie_consent_description',
                'Cookie Consent Description',
                [ $this, 'dot_cookie_consent_description_callback' ],
                'dot_cookie_consent_page_1',
                'dot_cookie_consent_main_section',
                [
                    'label_for' => 'dot_cookie_consent_description'
                ]
            );

            add_settings_field(
                'dot_cookie_consent_privacy_policy_title',
                'Privacy Policy URL',
                [ $this, 'dot_cookie_consent_privacy_policy_title_callback' ],
                'dot_cookie_consent_page_1',
                'dot_cookie_consent_main_section',
                [
                    'label_for' => 'dot_cookie_consent_privacy_policy_title'
                ]
            );


            add_settings_field(
                'dot_cookie_consent_privacy_policy_url',
                'Privacy Policy URL',
                [ $this, 'dot_cookie_consent_privacy_policy_url_callback' ],
                'dot_cookie_consent_page_1',
                'dot_cookie_consent_main_section',
                [
                    'label_for' => 'dot_cookie_consent_privacy_policy_url'
                ]
                
            );
        }

        public function dot_cookie_consent_description_callback(){
            ?>
            <input type="text"
            name="dot_cookie_consent_options[dot_cookie_consent_description]"
            id="dot_cookie_consent_description"
            value="<?php echo isset( self::$options['dot_cookie_consent_description'] ) ? esc_attr( self::$options['dot_cookie_consent_description']) : '';?>"
            style="width:100%"
            required
            />
            <?php
        }

        public function dot_cookie_consent_privacy_policy_title_callback(){
            ?>
            <input type="text"
            name="dot_cookie_consent_options[dot_cookie_consent_privacy_policy_title]"
            id="dot_cookie_consent_privacy_policy_title"
            value="<?php echo isset( self::$options['dot_cookie_consent_privacy_policy_title'] ) ? esc_attr( self::$options['dot_cookie_consent_privacy_policy_title']) : '';?>"
            style="width:100%"
            required
            />
            <?php
        }

        public function dot_cookie_consent_privacy_policy_url_callback(){
            ?>
            <input type="text"
            name="dot_cookie_consent_options[dot_cookie_consent_privacy_policy_url]"
            id="dot_cookie_consent_privacy_policy_url"
            value="<?php echo isset( self::$options['dot_cookie_consent_privacy_policy_url'] ) ? esc_attr( self::$options['dot_cookie_consent_privacy_policy_url']) : '';?>"
            style="width:100%"
            required
            />
            <?php
        }


        public function dot_cookie_consent_validate(Array $input){
            $new_input = [];

            foreach( $input as $k => $value ){

                switch($k){

                    case 'dot_cookie_consent_privacy_policy_url':
                        $new_input[$k] = esc_url_raw( $value );
                        break;
                    default:
                        $new_input[$k] = sanitize_text_field( $value );
                        break;
                }
                
            }
            return $new_input;
        }

        
    }
}
