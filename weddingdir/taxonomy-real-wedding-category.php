<?php

global $post, $wp_query;

/**
 *  Container Start
 *  ---------------
 */
do_action( 'weddingdir_main_container' );

if( class_exists( 'WeddingDir_RealWedding' ) ) :

    /**
     *  Taxonomy Slug
     *  -------------
     */
    $_taxonomy_slug     =   esc_attr( WeddingDir_Taxonomy_Database:: realwedding_category_taxonomy() );

    /**
     *  Load Taxonomy Post
     *  ------------------
     */
    if( class_exists( 'WeddingDir_Loader' ) ){

        $_tax_query     =   $_listing_html_data     =   [];

        $category       =   get_term_by(

                                /**
                                 *  1. Listing Name
                                 *  ---------------
                                 */
                                esc_attr( 'name' ), 

                                /**
                                 *  2. Get Title
                                 *  ------------
                                 */
                                single_cat_title( '', false ), 

                                /**
                                 *  3. Categroy Slug
                                 *  ----------------
                                 */
                                esc_attr( $_taxonomy_slug ) 
                            );

        /**
         *  Have Category Query
         *  -------------------
         */
        if( isset( $category ) && ! empty( $category ) ){

            $_tax_query[ 'tax_query' ]  =   array(

                'relation'  => 'AND',

                array(

                    'taxonomy'  =>  esc_attr( $_taxonomy_slug ) ,

                    'field'     =>  esc_attr( 'id' ),

                    'terms'     =>  absint ( $category->term_id )
                )
            );
        }

        /**
         *  Taxomony Query
         *  --------------
         */
        $args           =   array_merge(

            /**
             *  Default Load the page
             *  ---------------------
             */
            array(

                'post_type'         =>  esc_attr( 'real-wedding' ),

                'post_status'       =>  esc_attr( 'publish' ),

                'posts_per_page'    =>  -1,

                'orderby'           => 'menu_order ID',

                'order'             => 'post_date',
            ),

            /**
             *  2. Have Tax Query
             *  -----------------
             */
            ( WeddingDir_Loader:: _is_array( $_tax_query ) )

            ?   $_tax_query

            :   []
        );

        $item = new WP_Query( $args );

        if( $item->have_posts() ){

            while ( $item->have_posts() ){  $item->the_post();

                $_post_id   =   absint( get_the_ID() );

                if( class_exists( 'WeddingDir_RealWedding' ) ){

                    $_listing_html_data[] =

                    sprintf( '<div class="col-lg-4 col-sm-6 col-12">%1$s</div>',

                        /**
                         *  1. Real Wedding Layout 1
                         *  ------------------------
                         */
                        WeddingDir_RealWedding:: weddingdir_realwedding_layout( array(

                            'layout'    =>  absint( '1' ),

                            'post_id'   =>  absint( $_post_id )

                        ) )
                    );

                }else{

                }
            }

            /**
             *  Have Query ?
             *  ------------
             */
            if( isset( $item ) ){

                wp_reset_postdata();
            }
        }

        $per_page   =   absint( '9' );

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

                'listing_data'      =>  $_listing_html_data,
            ) ),

            /**
             *  Load Pagination
             *  ---------------
             */
            ( absint( $per_page ) < count( $_listing_html_data ) )

            ?   '<div class="row"><ul class="weddingdir_pagination col-12" id="weddingdir_listing_pagination"></ul></div>'

            :   ''
        );


    }

endif;

/**
 *  Container End
 *  -------------
 */
do_action( 'weddingdir_main_container_end' );