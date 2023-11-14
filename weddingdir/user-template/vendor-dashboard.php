<?php
/**
 *    Template name: Vendor Dashbaord
 *    -------------------------------
 */

global $wp_query, $post;

/**
 *  Is User Login ?  + Is Vendor Too
 *  --------------------------------
 */
if( is_user_logged_in() && class_exists( 'WeddingDir_Config' ) ){

	/**
	 *  Is Vendor ?
	 *  -----------
	 */
	if( WeddingDir_Config:: is_vendor() ){
  
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