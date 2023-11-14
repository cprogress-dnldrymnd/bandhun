<?php
/**
 *  WeddingDir - Body Action / Hooks
 *  --------------------------------
 */
if( ! class_exists( 'WeddingDir_Body' ) && class_exists( 'WeddingDir_Grid_Managment' ) ){

    /**
     *  WeddingDir - Body Action / Hooks
     *  --------------------------------
     */
    class WeddingDir_Body extends WeddingDir_Grid_Managment{

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
             *  1. WeddingDir - body markup included class / style / attributes
             *  ---------------------------------------------------------------
             */
            add_action( 'weddingdir_body', [ $this, 'weddingdir_body_schema_markup' ] );

            /**
             *  2. Load WordPress Body Class
             *  ----------------------------
             */
            add_action( 'weddingdir_body', [ $this, 'weddingdir_load_body_class' ] );

            /**
             *  3. WeddingDir - Add Body Class via Filter
             *  -----------------------------------------
             */
            add_filter( 'body_class', [ $this, 'weddingdir_body_classes' ] );
        }

        /**
         *  1. Body Tag add schema markup
         *  -----------------------------
         */
        public static function weddingdir_body_schema_markup(){

            /**
             *  Set up default itemtype.
             *  ------------------------
             */
            $itemtype       =   esc_attr( 'WebPage' );

            $_condition_1   =   ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() );

            $_condition_2   =   is_search();

            /**
             *  Check Page Markup
             *  -----------------
             */
            if(  $_condition_1  ){

                /**
                 *  Get itemtype for the blog
                 *  -------------------------
                 */
                $itemtype   =   esc_attr(   'Blog'  );


            }elseif(    $_condition_2   ){

                /**
                 *  Get itemtype for search results
                 *  -------------------------------
                 */
                $itemtype   =   esc_attr( 'SearchResultsPage' );
            }

            /**
             *  Return Markup
             *  -------------
             */
            printf( ' itemtype="https://schema.org/%1$s" itemscope="itemscope" ',

                /**
                 *  1. Update Schema Markup Page
                 *  ----------------------------
                 */
                esc_attr(   $itemtype   )
            );
        }

        /**
         *  @credit - https://developer.wordpress.org/reference/functions/body_class/
         *  -------------------------------------------------------------------------
         *  2. Load - WordPress page body class collection
         *  ----------------------------------------------
         */
        public static function weddingdir_load_body_class(){

            /**
             *  Load Body Class
             *  ---------------
             */
            body_class();
        }

        /**
         *  3. Body Class Update in Page
         *  ----------------------------
         */
        public static function weddingdir_body_classes( $classes = [] ){

            /**
             *  Is mobile or desktop
             *  --------------------
             */
            if ( function_exists( 'wp_get_theme' ) ) {

                $classes[] = sanitize_html_class( sanitize_title( wp_get_theme() ) );
            }

            /**
             *  WeddingDir - Use with PHP Version
             *  ---------------------------------
             */
            $classes[] = sanitize_html_class( sprintf( 'php-version-%1$s', phpversion() ) );

            /**
             * Is mobile or desktop
             * --------------------
             */
            if ( wp_is_mobile() ) {

                $classes[] = sanitize_html_class( 'weddingdir-mobile' );

            } else {

                $classes[] = sanitize_html_class( 'weddingdir-desktop' );
            }

            /**
             *  Adds a class of hfeed to non-singular pages
             *  -------------------------------------------
             */
            if ( ! is_singular() ) {

                $classes[]  =   sanitize_html_class( 'hfeed' );
            }

            $_have_sidebar          =   ! is_active_sidebar( 'weddingdir-widget-primary' );

            $_sidebar_is_emtpy      =   parent:: _have_data( parent:: page_sidebar() );

            /**
             *  Have Page ID ? then check they have capabilities for sidebar ?
             *  --------------------------------------------------------------
             */
            if (  $_have_sidebar || $_sidebar_is_emtpy  ) {

                $classes[]  =   sanitize_html_class( esc_attr( parent:: page_sidebar() ) );
                
            }else{

                $classes[]  =   sanitize_html_class( 'no-sidebar' );
            }

            /**
             *  WeddingDir - Product version
             *  ----------------------------
             */
            if( WEDDINGDIR_THEME_VERSION !== '' ){

                $classes[] = esc_attr( 'weddingdir-' . WEDDINGDIR_THEME_VERSION );
            }

            /** 
             *  WeddingDir - Page is RTL ?
             *  --------------------------
             */
            if( is_rtl() ){
            
                $classes[] = sanitize_html_class(   'weddingdir-rtl'    );
            }

            /**
             *  WeddingDir - Debug ON ?
             *  -----------------------
             */
            if( WEDDINGDIR_THEME_DEV == absint( '1' ) ){

                $classes[] = sanitize_html_class(   'weddingdir-debug-on'   );
            }

            /**
             *  Is couple or vendor dashboard to add class
             *  ------------------------------------------
             */
            if(  parent:: is_dashboard()  ){

                $classes[] = sanitize_html_class(   'body-bg'   );

                $classes[] = sanitize_html_class(   'open'   );
            }

            /**
             *  Add Body Class
             *  --------------
             */
            return  $classes;
        }
    }

    /**
     *  WeddingDir - Body Markup Object
     *  -------------------------------
     */
    WeddingDir_Body:: get_instance();
}