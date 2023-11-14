<?php
/**
 *  Archive : Listing Posts
 *  -----------------------
 */
global $wp_query, $post;

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
 *  Have Post ?
 *  -----------
 */
if ( have_posts() && class_exists( 'WeddingDir_Listing' ) ){

    ?><div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1"><?php

    /**
     *  Load Post One by One
     *  --------------------
     */
    while ( have_posts() ) {    the_post();

        /**
         *  Load Article
         *  ------------
         */
        printf( '<div class="col">%1$s</div>', 

            /** 
             *  1. Load Listing Post
             *  --------------------
             */
            apply_filters( 'weddingdir/listing/post', [

                'post_id'   =>  absint( get_the_ID() ),

                'layout'    =>  absint( '1' )

            ] )
        );
    }

    /**
     *  Have Pagination ?
     *  -----------------
     */
    if( absint( $wp_query->max_num_pages ) >= absint( '2' ) ){

        /**
         *  Create Pagination
         *  -----------------
         */
        print       apply_filters( 'weddingdir/pagination', [

                        'numpages'      =>  absint( $wp_query->max_num_pages ),

                        'paged'         =>  absint( $paged )

                    ] );
    }

    ?></div><?php

    /**
     *  Reset WP Query
     *  --------------
     */
    if( isset( $wp_query ) ){

        wp_reset_postdata();    
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