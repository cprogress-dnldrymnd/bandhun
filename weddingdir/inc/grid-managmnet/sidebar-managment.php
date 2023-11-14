<?php
/**
 *  WeddingDir - Page Tempalte Sidebar Managment
 *  --------------------------------------------
 */
if( ! class_exists( 'WeddingDir_Sidebar_Managment' ) && class_exists( 'WeddingDir_Grid_Managment' ) ) {

    /**
     *  WeddingDir - Page Tempalte Sidebar Managment
     *  --------------------------------------------
     */
    class WeddingDir_Sidebar_Managment extends WeddingDir_Grid_Managment {

        /**
         *  Member Variable
         *  ---------------
         */
        private static $instance;

        /**
         *  Initiator
         *  ---------
         */
        public static function get_instance() {
          
            if ( ! isset( self::$instance ) ) {

                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         *  Construct
         *  ---------
         */
        public function __construct() {

            /**
             *  Sidebar Widget
             *  --------------
             */
            add_action( 'weddingdir_get_sidebar_class', [ $this, 'weddingdir_get_sidebar_class' ] );

            /**
             *  Left Sidebar
             *  ------------
             */
            add_action( 'weddingdir_left_sidebar', [ $this, 'weddingdir_left_sidebar_markup' ] );

            /**
             *  Right Sidebar
             *  ------------
             */
            add_action( 'weddingdir_right_sidebar', [ $this, 'weddingdir_right_sidebar_markup' ] );
        }

        /**
         *  Sidebar (Aside) Section Class
         *  -----------------------------
         */
        public static function weddingdir_get_sidebar_class(){

            /**
             *  Sidebar (Aside) Section Class
             *  -----------------------------
             */
            printf( 'class="%1$s"',

                    /**
                     *  Have Class ?
                     *  ------------
                     */
                    esc_attr( join( ' ', self:: weddingdir_get_secondary_class() ) )
            );
        }

        /**
         *  WeddingDir - Sidebar Class Structure
         *  ------------------------------------
         */
        public static function weddingdir_get_secondary_class( $class = [] ) {

            /**
             *  array of class names
             *  --------------------
             */
            $classes        =   [];

            /**
             *  default class for widget area
             *  -----------------------------
             */
            $classes[]  =   sanitize_html_class( 'widget-area' );

            /**
             *  secondary base class
             *  --------------------
             */
            $classes[]  =   sanitize_html_class( 'secondary' );

            /**
             *  Theme Sidebar class
             *  -------------------
             */
            $classes[]  =   sanitize_html_class( 'theme-sidebar' );

            /**
             *  Sidebar Column Grid
             *  -------------------
             */
            $classes = array_merge( $classes, parent:: get_grid( '2' ) );

            /**
             *  Have extra class arguments ?
             *  ----------------------------
             */
            if ( ! empty( $class ) ) {

                if ( ! is_array( $class ) ) {

                    $class = preg_split( '#\s+#', $class );
                }

                $classes = array_merge( $classes, $class );

            } else {

                /**
                 *  Ensure that we always coerce class to being an array
                 *  ----------------------------------------------------
                 */
                $class = [];
            }

            /**
             *  Filter primary div class names
             *  ------------------------------
             */
            $classes    =   apply_filters( 'weddingdir_sidebar_class', $classes, $class );

            $classes    =   array_map( 'sanitize_html_class', $classes );

            return          array_unique( $classes );
        }

        /**
         *  WeddingDir - Load Left Sidebar
         *  ------------------------------
         */
        public static function weddingdir_left_sidebar_markup(){

            if( parent:: page_have_sidebar() ){

                if( parent:: is_left_sidebar() ){

                    get_sidebar();
                }

            }else{

                get_sidebar();
            }
        }

        /**
         *  WeddingDir - Load Right Sidebar
         *  -------------------------------
         */
        public static function weddingdir_right_sidebar_markup(){

            if( parent:: page_have_sidebar() ){

                if( parent:: is_right_sidebar() ){

                    get_sidebar();
                }

            }else{

                get_sidebar();
            }
        }
	}

    /**
     *  WeddingDir - Page Template Helper
     *  ---------------------------------
     */
    WeddingDir_Sidebar_Managment::get_instance();
}