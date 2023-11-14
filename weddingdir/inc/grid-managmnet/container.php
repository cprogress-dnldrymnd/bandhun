<?php
/**
 *  WeddingDir - Page Container Managment
 *  -------------------------------------
 */
if( ! class_exists( 'WeddingDir_Container_Managment' ) && class_exists( 'WeddingDir_Grid_Managment' ) ) {

    /**
     *  WeddingDir - Page Container Managment
     *  -------------------------------------
     */
    class WeddingDir_Container_Managment extends WeddingDir_Grid_Managment {

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
             *  Container Header Load
             *  ---------------------
             */
            add_action( 'weddingdir_main_container', [ $this, 'weddingdir_main_container_markup' ] );

            /**
             *  Container End Action
             *  --------------------
             */
            add_action( 'weddingdir_main_container_end', [ $this, 'weddingdir_main_container_end_markup' ] );

            /**
             *  Container Start
             *  ---------------
             */
            add_action( 'weddingdir_container_start', [ $this, 'weddingdir_container_start' ] );

            /**
             *  Container End
             *  -------------
             */
            add_action( 'weddingdir_container_end', [ $this, 'weddingdir_container_end' ] );
        }

        /**
         *   Start Content Wrapper Structure
         *   -------------------------------
         */
        public static function weddingdir_main_container_markup(){

            global $post, $wp_query, $page;

            /**
             *  1. Load Header Version
             *  ----------------------
             */
            get_header();

            /**
             *  2. Page header banner
             *  ---------------------
             */
            do_action( 'weddingdir/page-header-banner' );

            /**
             *  3. Page wrapper 
             *  ---------------
             */
            do_action( 'weddingdir_container_start' );

            /**
             *  4. Main page of content container
             *  ---------------------------------
             */
            printf( '<section id="primary" class="%1$s">',

                    /**
                     *  Have Class ?
                     *  ------------
                     */
                    esc_attr( join( ' ', self:: weddingdir_get_primary_class( '' ) ) )
            );
        }

        /**
         *  Container Width Body Class
         *  --------------------------
         */
        public static function weddingdir_get_primary_class( $class = [] ) {

            /**
             *  array of class names
             *  --------------------
             */
            $classes        =   [];

            /**
             *  default class for content area
             *  ------------------------------
             */
            $classes[]  =   sanitize_html_class( 'content-area' );

            /**
             *  primary base class
             *  ------------------
             */
            $classes[]  =   sanitize_html_class( 'primary' );

            /**
             *  Have Option Tree Plugin
             *  -----------------------
             */
            if( class_exists( 'OT_Loader' ) ){

                /**
                 *  Is Container
                 *  ------------
                 */
                if( parent:: is_container() || parent:: is_container_fluid() ){

                    if ( ! is_active_sidebar( parent:: weddingdir_sidebar() ) || parent:: is_no_sidebar() ){

                        /**
                         *  Full Width Column Grid
                         *  ----------------------
                         */
                        $classes = array_merge( $classes, parent:: get_grid( '1' ) );

                    }else{

                        /**
                         *  Sidebar Column Grid
                         *  -------------------
                         */
                        $classes = array_merge( $classes, parent:: get_grid( '3' ) );
                    }
                }

            }else{

                if ( ! is_active_sidebar( parent:: weddingdir_sidebar() ) ){

                    /**
                     *  Full Width Column Grid
                     *  ----------------------
                     */
                    $classes = array_merge( $classes, parent:: get_grid( '1' ) );


                }else{

                    /**
                     *  Sidebart Column Grid
                     *  --------------------
                     */
                    $classes = array_merge( $classes, parent:: get_grid( '3' ) );
                }
            }

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

            $classes    =   apply_filters( 'weddingdir_get_full_width_container_class', $classes, $class );

            $classes    =   array_map( 'sanitize_html_class', $classes );

            return          array_unique( $classes );
        }

        /**
         *  Container End Action
         *  --------------------
         */
        public static function weddingdir_main_container_end_markup(){

            /**
             *  </section>
             *
             *  section page of content container
             *  ---------------------------------
             */
            ?></section><?php

            /**
             *  page wrapper end
             *  ----------------
             */
            do_action( 'weddingdir_container_end' );

            /**
             *  page footer
             *  -----------
             */
            get_footer();
        }

        /**
         *  Container Start
         *  ---------------
         */
        public static function weddingdir_container_start(){

            /**
             *  Have Option Tree Plugin ?
             *  -------------------------
             */
            if( parent:: page_have_sidebar() ){

                /**
                 *  If ( Option Tree Plugin is activate then we have more page meta option )
                 *  ------------------------------------------------------------------------
                 */
                if(  parent:: is_container()  ){

                    /**
                     *  Page Start
                     *  ----------
                     */
                    self:: page_container_start();

                    /**
                     *  If Have Sidebar
                     *  ---------------
                     */
                    do_action( 'weddingdir_left_sidebar' );
                }

                /**
                 *  If ( Option Tree Plugin is activate then we have more page meta option )
                 *  ------------------------------------------------------------------------
                 */
                if(  parent:: is_container_fluid()  ){

                    /**
                     *  Page Start
                     *  ----------
                     */
                    self:: page_container_fluid_start();

                    /**
                     *  If Have Sidebar
                     *  ---------------
                     */
                    do_action( 'weddingdir_left_sidebar' );
                }

            }else{

                /**
                 *  Page Start
                 *  ----------
                 */
                self:: page_container_start();
            }
        }

        /**
         *  WeddingDir - Page Start Div Structure
         *  -------------------------------------
         */
        public static function page_container_start(){

            ?>
                <div class="main-content content wide-tb-90">

                    <div class="container">

                        <div class="row">
                            
                            <?php
        }

        /**
         *  WeddingDir - Page End Div Structure
         *  -----------------------------------
         */
        public static function page_container_end(){

                            ?>
                            
                        </div>

                    </div>

                </div>

            <?php
        }

        /**
         *  WeddingDir - Page Start Div Structure
         *  -------------------------------------
         */
        public static function page_container_fluid_start(){

            ?>
                <div class="main-content content wide-tb-90">

                    <div class="container-fluid">

                        <div class="row">
                            
                            <?php
        }

        /**
         *  WeddingDir - Page End Div Structure
         *  -----------------------------------
         */
        public static function page_container_fluid_end(){

                            ?>
                            
                        </div>

                    </div>

                </div>

            <?php
        }

        /**
         *  Container End
         *  -------------
         */
        public static function weddingdir_container_end(){

            /**
             *  Have Option Tree Plugin
             *  -----------------------
             */
            if( class_exists( 'OT_Loader' )  ){

                if( parent:: is_container() ){

                    /**
                     *  Have Sidebar ?
                     *  --------------
                     */
                    do_action( 'weddingdir_right_sidebar' );

                    /**
                     *  Page Container End
                     *  ------------------
                     */
                    self:: page_container_end();
                }

                if( parent:: is_container_fluid() ){

                    /**
                     *  Have Sidebar ?
                     *  --------------
                     */
                    do_action( 'weddingdir_right_sidebar' );

                    /**
                     *  Page Container End
                     *  ------------------
                     */
                    self:: page_container_fluid_end();
                }

            }else{

                /**
                 *  Have Sidebar
                 *  ------------
                 */
                do_action( 'weddingdir_right_sidebar' );

                /**
                 *  Page Container End
                 *  ------------------
                 */
                self:: page_container_end();
            }
        }
    }

    /**
     *  WeddingDir - Page Template Helper
     *  ---------------------------------
     */
    WeddingDir_Container_Managment::get_instance();
}