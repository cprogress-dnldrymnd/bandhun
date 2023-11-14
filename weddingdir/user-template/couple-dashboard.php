<?php
/**
 *   Template name: Couple Dashbaord
 *   -------------------------------
 */
global $wp_query, $post;

/**
 *  Is User Login ? + Is Couple too
 *  -------------------------------
 */
if( is_user_logged_in() && class_exists( 'WeddingDir_Config' ) ){

	/**
	 *  Is Couple ?
	 *  -----------
	 */
	if( WeddingDir_Config:: is_couple() ){

		/**
		 *  1. Load WeddingDir - Header
		 *  ---------------------------
		 */
        get_header();

	        /**
	         *   Dashboard action
	         *   ----------------
	         */
	        do_action( 'weddingdir/dashboard' );

	    /**
	     *  2. Load WeddingDir - Footer
	     *  ---------------------------
	     */
       	get_footer();
  	}

}else{

	/**
	 *  Redirection on Home Page
	 *  ------------------------
	 */
    die( wp_redirect( home_url() ) );
}