<?php
/**
 *  WeddingDir - 404 Error Page Template Helper
 *  -------------------------------------------
 */
if( ! class_exists( 'WeddingDir_404' ) && class_exists( 'WeddingDir' ) ){

    /**
     *  WeddingDir - 404 Error Page Template Helper
     *  -------------------------------------------
     */
    class WeddingDir_404 extends WeddingDir{

        private static $instance;

        public static function get_instance() {

            if ( null == self::$instance ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         *  Construct
         *  ---------
         */
        public function __construct() {

            /**
             *  1. 404 Error Page Content Filter
             *  --------------------------------
             */
            add_action( 'weddingdir/404-error/content', [ $this, 'graphics_load' ], absint( '10' ), absint( '1' ) );

            /**
             *  2. 404 Error Page Content Filter
             *  --------------------------------
             */
            add_action( 'weddingdir/404-error/content', [ $this, 'title_load' ], absint( '20' ), absint( '1' ) );

            /**
             *  3. 404 Error Page Content Filter
             *  --------------------------------
             */
            add_action( 'weddingdir/404-error/content', [ $this, 'description_load' ], absint( '30' ), absint( '1' ) );

            /**
             *  4. 404 Error Page Content Filter
             *  --------------------------------
             */
            add_action( 'weddingdir/404-error/content', [ $this, 'buttons_load' ], absint( '40' ), absint( '1' ) );
        }

        /**
         *  1. WeddingDir - 404 Page Have Graphics ?
         *  ----------------------------------------
         */
        public static function graphics_load( $args = [] ){

            /**
             *  Have args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){

                /**
                 *  Extract
                 *  -------
                 */
                extract( wp_parse_args( $args, [

                    'layout'        =>      absint( '1' )

                ] ) );

                /**
                 *  Layout 1
                 *  --------
                 */
                if( $layout == absint( '1' ) ){

                    /**
                     *  1. Error Page Graphics
                     *  ----------------------
                     */
                    if( weddingdir_option( '404_error_image' ) != '' ){

                        /**
                         *  Setting Option to get 404 Error Page Image
                         *  ------------------------------------------
                         */
                        $_404_error_image   =   esc_url( weddingdir_option( '404_error_image' ) );

                    }else{

                        /**
                         *  404 Error Page Default Graphics ( Image Link )
                         *  ----------------------------------------------
                         */
                        $_404_error_image   =   esc_url( WEDDINGDIR_THEME_MEDIA . '/404-error-page/404_error.svg' );
                    }

                    /**
                     *  WeddingDir - 404 Graphics Image
                     *  -------------------------------
                     */
                    printf( '<img src="%1$s" alt="%2$s %3$s" class="mb-5" title="%2$s">',

                        /**
                         *  1. Setting Option to get 404 Error Page Image
                         *  ---------------------------------------------
                         */
                        esc_url( $_404_error_image ),

                        /**
                         *  2. Blog Name
                         *  ------------
                         */
                        esc_attr( get_option( 'blogname' ) ),

                        /**
                         *  3. Translation Ready String
                         *  ---------------------------
                         */
                        esc_attr__( '404 Error Page', 'weddingdir' )
                    );
                }
            }
        }

        /**
         *  2. WeddingDir - 404 Page Have Title
         *  -----------------------------------
         */
        public static function title_load( $args = [] ){

            /**
             *  Have args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){

                /**
                 *  Extract
                 *  -------
                 */
                extract( wp_parse_args( $args, [

                    'layout'        =>      absint( '1' )

                ] ) );

                /**
                 *  Layout 1
                 *  --------
                 */
                if( $layout == absint( '1' ) ){

                    /**
                     *   Have 404 Title ?
                     *   ----------------
                     */
                    if( weddingdir_option( '404_title' ) != '' ){

                        /**
                         *  Have Setting Option to set 404 Error Page Title ?
                         *  -------------------------------------------------
                         */
                        $_404_error_page_title  =   esc_attr(   weddingdir_option( '404_title' )  );

                    }else{

                        /**
                         *  Translation Ready String
                         *  ------------------------
                         */
                        $_404_error_page_title  =   esc_attr__( 'Opps! Looks like the page is gone.', 'weddingdir' );
                    }

                    /**
                     *  2. 404 Error Page Heading
                     *  -------------------------
                     */
                    printf( '<h2>%1$s</h2>', 

                        /**
                         *  1. Have Setting Option to set 404 Error Page Title ?
                         *  ----------------------------------------------------
                         */
                        esc_attr(  $_404_error_page_title  )
                    );
                }
            }
        }

        /**
         *  3. WeddingDir - 404 Page Have Description
         *  -----------------------------------------
         */
        public static function description_load( $args = [] ){

            /**
             *  Have args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){

                /**
                 *  Extract
                 *  -------
                 */
                extract( wp_parse_args( $args, [

                    'layout'        =>      absint( '1' )

                ] ) );

                /**
                 *  Layout 1
                 *  --------
                 */
                if( $layout == absint( '1' ) ){

                    if( weddingdir_option( '404_error_description' ) != '' ){

                        /** 
                         *  Have Setting Option 404 Error Page Description ?
                         *  ------------------------------------------------
                         */
                        $_have_description  =   esc_attr( weddingdir_option( '404_error_description' ) );

                    }else{

                        /**
                         *  1. Translation Ready String
                         *  ---------------------------
                         */
                        $_have_description  =   esc_attr__( 'The link is broken or the page has been moved. Try these pages instead:', 'weddingdir' );
                    }

                    /**
                     *  WeddingDir -404 Error Page Description
                     *  --------------------------------------
                     */
                    printf( '<p>%1$s</p>',

                        /**
                         *  Load Description
                         *  ----------------
                         */
                        esc_attr( $_have_description )
                    );
                }
            }
        }

        /**
         *  4. WeddingDir - 404 Page Have Buttons ?
         *  ---------------------------------------
         */
        public static function buttons_load( $args = [] ){

            /**
             *  Have args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){

                /**
                 *  Extract
                 *  -------
                 */
                extract( wp_parse_args( $args, [

                    'layout'        =>      absint( '1' )

                ] ) );

                /**
                 *  Layout 1
                 *  --------
                 */
                if( $layout == absint( '1' ) ){

                    /**
                     *  Extra Buttons for redirection user on 404 Error Page
                     *  ----------------------------------------------------
                     */
                    if( parent:: _have_data( weddingdir_option( '404_error_page_buttons' ) ) ){

                        ?><div class="tags mt-5"><?php

                            foreach ( weddingdir_option( '404_error_page_buttons' ) as $key => $value ) {
                                
                                printf('<a href="%1$s">%2$s</a>',

                                        /**
                                         *  1. Button Link
                                         *  --------------
                                         */
                                        esc_url( $value[ 'link' ] ),
                                        
                                        /**
                                         *  2. Button Name
                                         *  --------------
                                         */
                                        esc_attr( $value[ 'name' ] )
                                );
                            }

                        ?></div><?php
                    }

                    /**
                     *  Default
                     *  -------
                     */
                    else{

                        printf( '<div class="tags mt-5"><a href="%1$s">%2$s</a></div>', 

                            /**
                             *  1. Button Link
                             *  --------------
                             */
                            esc_url( home_url( '/' ) ),
                            
                            /**
                             *  2. Translation Ready Strings
                             *  ----------------------------
                             */
                            esc_attr__( 'Go To Home page', 'weddingdir' )
                        );
                    }
                }
            }
        }
    }  

    /**
     *  WeddingDir - Body Markup Object
     *  -------------------------------
     */
    WeddingDir_404:: get_instance();
}