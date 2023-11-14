<?php
/**
 *    Template Name: Vendor Location
 *    ------------------------------
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
        $_html_data             =   [];

        /**
         *  Layout ?
         *  --------
         */
        $layout                 =   absint( '2' );

        /**
         *  Media Size
         *  ----------
         */
        $_media_size            =   absint( $layout ) == absint( '1' )

                                ?   esc_attr( 'weddingdir_listing_location_550x460' )

                                :   esc_attr( 'weddingdir_listing_location_550x610' );
        /**
         *  Placeholder
         *  -----------
         */
        $_default_placeholder   =   absint( $layout ) == absint( '1' )

                                ?   esc_url( WeddingDir_Loader:: placeholder( 'weddingdir-location-1' ) )

                                :   esc_url( WeddingDir_Loader:: placeholder( 'weddingdir-location-5' ) );

        /**
         *  Have Location ?
         *  ---------------
         */
        $_location_list  =  WeddingDir_Taxonomy:: get_taxonomy_option( 'vendor-location', absint('3') );

        /**
         *  Have Data ?
         *  -----------
         */
        if( WeddingDir:: _is_array( $_location_list ) ){

            /**
             *  Listing Location IDs One by one load
             *  ------------------------------------
             */
            foreach( $_location_list as $key => $value ){

                /**
                 *  @credit - https://developer.wordpress.org/reference/functions/get_term_by/#user-contributed-notes
                 *  -------------------------------------------------------------------------------------------------
                 */
                $_get_terms_data    =   get_term_by( 

                                            esc_attr( 'id' ), 

                                            absint( $key ), 

                                            sanitize_key( 'vendor-location' )
                                        );
                /**
                 *  Have Location Image ?
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
                                                sprintf( 'vendor-location_%1$s',

                                                    absint( $_get_terms_data->term_id )
                                                )
                                            );

                /**
                 *  @credit - https://developer.wordpress.org/reference/functions/get_term_by/#user-contributed-notes
                 *  -------------------------------------------------------------------------------------------------
                 */
                $_get_terms_data    =   get_term_by( 

                                            esc_attr( 'id' ), 

                                            absint( $key ),

                                            sanitize_key( 'vendor-location' )
                                        );

                /**
                 *  Layout : 1
                 *  ----------
                 */
                if( $layout == absint( '1' ) && WeddingDir_Loader:: _is_object( $_get_terms_data ) ){

                    /**
                     *  Get layout one
                     *  --------------
                     */
                    $_html_data[] =

                    sprintf(   '<div class="col-lg-4 col-md-6 col-12">

                                    <div class="popular-locations">

                                        <div class="overlay-box">

                                            <h3><a href="%1$s">%2$s <span>%3$s</span></a></h3>

                                            <a href="%1$s" class="iconlink"><i class="fa fa-angle-right"></i></a>

                                        </div>

                                        <img src="%4$s" alt="%5$s" />

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
                                 *  2. Term Name
                                 *  ------------
                                 */
                                esc_attr( $_get_terms_data->name ),

                                /**
                                 *  3. Term Count
                                 *  -------------
                                 */
                                sprintf( esc_attr__( '%1$s Vendors', 'weddingdir' ),
                                  
                                    /**
                                     *  1. Count the term used in post
                                     *  ------------------------------
                                     */
                                    absint( $_get_terms_data->count )
                                ),

                                /**
                                 *  4. Get Image
                                 *  ------------
                                 */
                                esc_url( WeddingDir_Blog_Helper:: weddingdir_media( array(

                                    'media_id'      =>      absint( get_field(

                                                                /**
                                                                 *  1. Term Key
                                                                 *  -----------
                                                                 */
                                                                sanitize_key( 'vendor_location_image' ),

                                                                /**
                                                                 *  2. Term Value Get Via ID
                                                                 *  ------------------------
                                                                 */
                                                                sprintf( 'vendor-location_%1$s',

                                                                    absint( $key )
                                                                )
                                                            ) ),

                                    'image_size'    =>      esc_attr( $_media_size ),

                                    'get_data'      =>      esc_attr( 'url' ),

                                ) ) ),
                                
                                /**
                                 *  5. Blog Info
                                 *  ------------
                                 */
                                esc_attr( get_bloginfo( 'name' ) )
                    );
                }

                /**
                 *  Layout : 2
                 *  ----------
                 */
                if( $layout == absint( '2' ) && WeddingDir_Loader:: _is_object( $_get_terms_data ) ){

                    /**
                     *  Get layout one
                     *  --------------
                     */
                    $_html_data[] =

                    sprintf(   '<div class="col-lg-4 col-md-6 col-12">

                                    <div class="popular-locations-alternate">

                                        <div class="overlay-box">

                                            <div class="mt-auto">

                                                <h3><a href="%1$s">%2$s</a> <span>%3$s</span></h3>

                                            </div>

                                        </div>

                                        <img src="%4$s" alt="%5$s" />

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
                                 *  2. Term Name
                                 *  ------------
                                 */
                                esc_attr( $_get_terms_data->name ),

                                /**
                                 *  3. Term Count
                                 *  -------------
                                 */
                                sprintf( esc_attr__( '%1$s Vendors', 'weddingdir' ),
                                  
                                    /**
                                     *  1. Count the term used in post
                                     *  ------------------------------
                                     */
                                    absint( $_get_terms_data->count )
                                ),

                                /**
                                 *  4. Get Image
                                 *  ------------
                                 */
                                esc_url( WeddingDir_Blog_Helper:: weddingdir_media( array(

                                    'media_id'      =>      absint( get_field(

                                                                /**
                                                                 *  1. Term Key
                                                                 *  -----------
                                                                 */
                                                                sanitize_key( 'vendor_location_image' ),

                                                                /**
                                                                 *  2. Term Value Get Via ID
                                                                 *  ------------------------
                                                                 */
                                                                sprintf( 'vendor-location_%1$s',

                                                                    absint( $key )
                                                                )
                                                            ) ),

                                    'image_size'    =>      esc_attr( $_media_size ),

                                    'get_data'      =>      esc_attr( 'url' ),

                                ) ) ),
                                
                                /**
                                 *  5. Blog Info
                                 *  ------------
                                 */
                                esc_attr( get_bloginfo( 'name' ) )
                    );
                }
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