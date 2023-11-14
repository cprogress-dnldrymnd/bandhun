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
 *  Have Post ?
 *  -----------
 */
if ( have_posts() ){

    /**
     *  Load Post One by One
     *  --------------------
     */
    while ( have_posts() ) {    the_post();

        /**
         *  Have Page Content ?
         *  -------------------
         */
        the_content();

        /**
         *  Have Link ?
         *  -----------
         */
        wp_link_pages( array(

            'before'           =>   '<ul class="pagination justify-content-center">',

            'after'            =>   '</ul>',

            'next_or_number'   =>   esc_attr( 'number' ),

            'nextpagelink'     =>   esc_attr__( 'Next page', 'weddingdir'),

            'previouspagelink' =>   esc_attr__( 'Previous page', 'weddingdir' ),

            'pagelink'         =>   esc_attr( '%' ),

        ) );

        /**
         *  Have Page Comment Open ?
         *  ------------------------
         */
        if ( comments_open() || get_comments_number() ){

            comments_template();
        }
    }

    /**
     *  Reset WP Query
     *  --------------
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