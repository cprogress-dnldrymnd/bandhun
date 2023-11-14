<?php
/**
 *  WeddingDir - Page File
 *  ----------------------
 */
global $wp_query, $post, $page;

/**
 *  Current Page
 *  ------------
 */
$paged  =   get_query_var( 'paged' ) 

        ?   absint( get_query_var( 'paged' ) ) 

        :   absint( '1' );

/**
 *  Container Start
 *  ---------------
 */
do_action( 'weddingdir_main_container' );

/**
 *  WooCommerce Content
 *  -------------------
 */
woocommerce_content();

/**
 *  Container End
 *  -------------
 */
do_action( 'weddingdir_main_container_end' ); ?>