<?php
/**
 *    Template Name: Vendor Category
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
        $_html_data = [];

        /**
         *  Have Category ?
         *  ---------------
         */
        $_category_list  =  WeddingDir_Taxonomy:: get_taxonomy_option( 'vendor-category', absint('1') );

        /**
         *  Have Data ?
         *  -----------
         */
        if( WeddingDir:: _is_array( $_category_list ) ){

            /**
             *  Listing Category IDs One by one load
             *  ------------------------------------
             */
            foreach( $_category_list as $key => $value ){

                /**
                 *  @credit - https://developer.wordpress.org/reference/functions/get_term_by/#user-contributed-notes
                 *  -------------------------------------------------------------------------------------------------
                 */
                $_get_terms_data    =   get_term_by( 

                                            esc_attr( 'id' ), 

                                            absint( $key ), 

                                            sanitize_key( 'vendor-category' )
                                        );
                /**
                 *  Have Category Image ?
                 *  ---------------------
                 */
                $_have_media_id     =       get_field(

                                                /**
                                                 *  1. Term Key
                                                 *  -----------
                                                 */
                                                sanitize_key( 'vendor_category_image' ),

                                                /**
                                                 *  2. Term Value Get Via ID
                                                 *  ------------------------
                                                 */
                                                sprintf( 'vendor-category_%1$s',

                                                    absint( $_get_terms_data->term_id )
                                                )
                                            );
                /**
                 *  Get layout one
                 *  --------------
                 */
                $_html_data[] =

                sprintf( '<div class="col-lg-4 col-md-6 col-12">

                            <div class="popular-categories">

                                <img src="%5$s" alt="%6$s" />

                                <div class="content-wrap">

                                    <div class="content">

                                        <div class="mt-auto d-flex align-items-center w-100 justify-content-between">

                                            <div class="catlinks">

                                                <a href="%1$s"><h3>%3$s</h3></a>

                                                <a href="%1$s"><span class="count-listings">%4$s</span></a>

                                            </div>

                                            <a href="%1$s" class="icon"><i class="%2$s"></i></a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>',

                        /**
                         *  1. Term Name
                         *  ------------
                         */
                        esc_url( 

                            /**
                             *  Term Link
                             *  ---------
                             */
                            get_term_link( 

                                absint( $_get_terms_data->term_id )
                            )
                        ),

                        /**
                         *  2. Term Icon
                         *  ------------
                         */
                        esc_attr( 

                            get_field('vendor_category_icon',

                                sprintf( 'vendor-category_%1$s', absint( $_get_terms_data->term_id ) )
                            )
                        ),

                        /**
                         *  3. Term Name
                         *  ------------
                         */
                        esc_attr( $_get_terms_data->name ),

                        /**
                         *  4. Translation Ready String
                         *  ---------------------------
                         */
                        sprintf( esc_attr__( '%1$s Vendors', 'weddingdir' ), 

                            /**
                             *  1. Count Used Term in Post
                             *  --------------------------
                             */
                            absint( $_get_terms_data->count )
                        ),

                        /**
                         *  5. Get Image
                         *  ------------
                         */
                        WeddingDir:: _have_data( $_have_media_id )

                        ?   esc_url( WeddingDir_Blog_Helper:: weddingdir_media( array(

                                'media_id'      =>      absint( $_have_media_id ),

                                'image_size'    =>      esc_attr( 'weddingdir_listing_category_550x610' ),

                                'get_data'      =>      esc_attr( 'url' ),

                            ) ) )

                        :   esc_url( WeddingDir_Loader:: placeholder( 'weddingdir-location-5' ) ),
                        
                        /**
                         *  6. Blog Info
                         *  ------------
                         */
                        esc_attr( get_bloginfo( 'name' ) )
                );
            }

            /**
             *  Post Per Page
             *  -------------
             */
            $per_page   =   absint( '9' );

            /**
             *  Have Data ?
             *  -----------
             */
            if( WeddingDir:: _is_array( $_html_data ) ){

                if( count( $_html_data ) > $per_page ){

                    /**
                     *  Listing Post Show
                     *  -----------------
                     */
                    printf( '<div class="row">%1$s</div> %2$s <!-- Load Pagination -->',

                        /**
                         *  Listing Data Update with Pagination
                         *  -----------------------------------
                         */
                        weddingdir_listing_pagination( array(

                            'per_page'          =>  absint( $per_page ),

                            'listing_data'      =>  $_html_data,
                        ) ),

                        /**
                         *  Load Pagination
                         *  ---------------
                         */
                        ( absint( $per_page ) < count( $_html_data ) )

                        ?   '<div class="row"><ul class="weddingdir_pagination col-12" id="weddingdir_listing_pagination"></ul></div>'

                        :   ''
                    );

                }else{

                    print '<div class="row">';

                    foreach( $_html_data as $key => $value ){

                        print  apply_filters( 'weddingdir_just_print', $value );
                    }

                    print '</div>';
                }
            }

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