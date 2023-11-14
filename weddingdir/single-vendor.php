<?php
/**
 *  Vendor Single Page Template
 *  ---------------------------
 */

/**
 *  1. Load Theme Header
 *  --------------------
 */
get_header();

    /**
     *  2. Load Vendor Singular Page
     *  ----------------------------
     */
    do_action( 'weddingdir/singular/vendor' );

/**
 *  3. Load Theme Footer
 *  --------------------
 */
get_footer();