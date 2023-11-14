<?php
/**
 *  ----------------------------------
 *  WeddingDir - Theme Footer Template
 *  ----------------------------------
 *  @link - https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *  ---------------------------------------------------------------------------------------
 *  @package weddingdir
 *  -------------------
 */
?></main><!-- #content area end --><?php

    if( ! is_singular( 'website' ) ){

        /**
         *  WeddingDir - After Content Actions
         *  ----------------------------------
         */
        do_action( 'weddingdir_content_after' );

        /**
         *  WeddingDir - Footer Markup
         *  --------------------------
         */
        do_action( 'weddingdir/footer' );
    }

?></div><!-- #page --><?php 

    /**
     *  -----------
     *  Load Footer
     *  -----------
     *  @link - https://developer.wordpress.org/reference/functions/wp_footer/
     *  ----------------------------------------------------------------------
     */

    wp_footer(); 

?></body></html>