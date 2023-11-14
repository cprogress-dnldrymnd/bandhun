<?php
/**
 *   Template name: Wedding Website
 *   ------------------------------
 */
global $wp_query, $post;

/**
 *  Is User Login ? + Is Couple too
 *  -------------------------------
 */
if( is_user_logged_in() && class_exists( 'WeddingDir_Config' ) ){

    /**
     *  1. Load WeddingDir - Header
     *  ---------------------------
     */
    get_header();

    esc_attr_e( 'couple wedding website', 'weddingdir' );

    /**
     *  2. Load WeddingDir - Footer
     *  ---------------------------
     */
    get_footer();

}else{

    /**
     *  Redirection on Home Page
     *  ------------------------
     */
    die( wp_redirect( home_url() ) );
}