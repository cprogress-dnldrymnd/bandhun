<?php
/**
 *    Template Name: Listing Location
 *    -------------------------------
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
     *  Have WeddingDir - Plugin Activated ?
     *  ------------------------------------
     */
    if( class_exists( 'WeddingDir_Loader' ) ){

        /**
         *  Create Array
         *  ------------
         */
        $collection             =       [];

        /**
         *  Have Category ?
         *  ---------------
         */
        $parent_collection      =       apply_filters( 'weddingdir_parent_tax_dropdown', [], 'listing-location' );

        /**
         *  Have Data ?
         *  -----------
         */
        if( WeddingDir:: _is_array( $parent_collection ) ){

            ?><div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1"><?php

            /**
             *  In Loop
             *  -------
             */
            foreach( $parent_collection as $key => $value ){

                /**
                 *  Page Builder : Arguments Pass to Print
                 *  --------------------------------------
                 */
                print   do_shortcode(

                            sprintf( '[weddingdir_listing_location style="%1$s" post_ids="%2$s"][/weddingdir_listing_location]',

                                /**
                                 *  1. Style
                                 *  --------
                                 */
                                absint( '1' ),

                                /**
                                 *  2. Category IDs
                                 *  ---------------
                                 */
                                esc_attr( $key ),
                            )
                        );
            }

            ?></div><?php

        }else{

            /**
             *  Article Not Found!
             *  ------------------
             */
            do_action( 'weddingdir_empty_article' );
        }

    }else{

        /**
         *  Article Not Found!
         *  ------------------
         */
        do_action( 'weddingdir_empty_article' );
    }

/**
 *  Container End
 *  -------------
 */
do_action( 'weddingdir_main_container_end' ); ?>