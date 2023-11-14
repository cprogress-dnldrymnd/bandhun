<?php
/**
 *   WeddingDir : Search Page Template
 *   ---------------------------------
 */
global $wp_query, $post, $page;

/** 
 *   Container Start
 *   ---------------
 */
do_action( 'weddingdir_main_container' );

/**
 *  Have Post ?
 *  -----------
 */
if ( have_posts() ){

    /**
     *  One by one load post
     *  --------------------
     */
    while ( have_posts() ) {    the_post();

        /**
         *  Load Article
         *  ------------
         */
        do_action( 'weddingdir_article', array(

            'layout'    =>  absint( '1' ),

            'post_id'   =>  absint( get_the_ID() )

        ) );
    } 

    /**
     *  Reset Query
     *  -----------
     */
    if( isset( $wp_query ) ){

        wp_reset_postdata();
    }

    /**
     *  Create Pagination
     *  -----------------
     */
    print       apply_filters( 'weddingdir/pagination', [

                    'numpages'      =>  absint( $wp_query->max_num_pages ),

                    'paged'         =>  absint( $paged )

                ] );

}else{  

    /**
     *  Not Found Post
     *  --------------
     */
    do_action( 'weddingdir_empty_article' );  
}    

/** 
 *   Container End
 *   -------------
 */
do_action( 'weddingdir_main_container_end' );