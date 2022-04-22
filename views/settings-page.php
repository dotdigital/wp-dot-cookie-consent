<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() );?></h1>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'dot_cookie_consent_group' );
            do_settings_sections( 'dot_cookie_consent_page_1' );
            submit_button( 'Save settings' );
        ?>
    </form>
</div>