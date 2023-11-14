<?php

global $wp_query, $post, $page;

/**
 *  WeddingDir - Container Start
 *  ----------------------------
 */
do_action( 'weddingdir_main_container' );

/**
 *  Have Post ?
 *  -----------
 */
if ( have_posts() ){

    /**
     *  Load Post One By One
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

        /**
         *  Post Have Tags ?
         *  ----------------
         */
        WeddingDir_Blog_Helper:: weddingdir_blog_tags();

        /**
         *  WeddingDir - Post Singular page - Next & Prev Post
         *  --------------------------------------------------
         */
        WeddingDir_Blog_Helper:: weddingdir_single_post_link();

        /**
         *  If Post Publish Authro have own bio
         *  -----------------------------------
         */
        if ( get_the_author_meta( 'description' ) ){

            /**
             *  Show Author Bio
             *  ---------------
             */
            get_template_part( 'author-bio' );
        }

        /**
         *  Post / Page : Comment is Open
         *  -----------------------------
         */
        if ( comments_open() || get_comments_number() ){

            /**
             *  Load Comment Template
             *  ---------------------
             */
            comments_template();
        }
    }

    /**
     *  Reset Query
     *  -----------
     */
    if( isset( $wp_query ) ){

        wp_reset_postdata();
    }

}else{

    /**
     *  Not Found Post
     *  --------------
     */
    do_action( 'weddingdir_empty_article' );
}

/**
 *  WeddingDir - Container END
 *  --------------------------
 */
do_action( 'weddingdir_main_container_end' ); ?>