<?php
/**
 *  WeddingDir - Post Page Template ( index.php )
 *  ---------------------------------------------
 */
global $wp_query, $post, $page;

/**
 *  Current Page
 *  ------------
 */
$paged 	= 	get_query_var( 'paged' ) 

		? 	absint( get_query_var( 'paged' ) ) 

		: 	absint( '1' );

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
   	while ( have_posts() ) {  the_post();

   		/**
   		 *  Load Article
   		 *  ------------
   		 */
   		do_action( 'weddingdir_article', array(

			'layout'	=>	absint( '1' ),

			'post_id'	=>	absint( get_the_ID() )

		) );
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