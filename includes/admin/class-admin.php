<?php
namespace WeDevs\ERP;

/**
 * sdlfkj
 */
class Admin_Page {

    function __construct() {
        add_action( 'admin_footer', array($this, 'site_js_templates' ) );

        add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts' ) );
    }

    /**
     * Load admin scripts and styles
     *
     * @param  string
     *
     * @return void
     */
    public function admin_scripts( $hook ) {
        // var_dump( $hook );

        wp_enqueue_script( 'wp-erp-popup', WPERP_ASSETS . '/js/jquery-popup.js', array( 'jquery', 'backbone', 'underscore' ), date( 'Ymd' ), true );
        wp_enqueue_script( 'wp-erp-script', WPERP_ASSETS . '/js/admin-script.js', array( 'jquery', 'backbone', 'underscore' ), date( 'Ymd' ), true );

        wp_localize_script( 'wp-erp-script', 'wpErp', array(
            'set_logo'    => __( 'Set company logo', 'wp-erp' ),
            'upload_logo' => __( 'Upload company logo', 'wp-erp' ),
            'remove_logo' => __( 'Remove company logo', 'wp-erp' )
        ) );

        // load country/state JSON on new company page
        if ( 'toplevel_page_erp-company' == $hook && isset( $_GET['action'] ) && in_array( $_GET['action'], array( 'new', 'edit' ) ) ) {
            wp_enqueue_script( 'post' );
            wp_enqueue_media();

            $country = \WeDevs\ERP\Countries::instance();
            wp_localize_script( 'wp-erp-script', 'wpErpCountries', $country->load_country_states() );
        }

        wp_enqueue_style( 'wp-erp-styles', WPERP_ASSETS . '/css/admin/admin.css', false, date( 'Ymd' ) );
    }

    public function site_js_templates() {
        include WPERP_INCLUDES . '/admin/views/templates-footer.php';
    }
}

new Admin_Page();