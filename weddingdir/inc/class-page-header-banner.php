<?php
/**
 *  WeddingDir - Page Header Banner
 *  -------------------------------
 */
if( ! class_exists( 'WeddingDir_Page_Header_Banner' ) && class_exists( 'WeddingDir' ) ){

    /**
     *  WeddingDir - Page Header Banner
     *  -------------------------------
     */
    class WeddingDir_Page_Header_Banner extends WeddingDir {

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

        public function __construct(){

            /**
             *  1. Load Page Header Banner
             *  --------------------------
             */
            add_action( 'weddingdir/page-header-banner',  [ $this, 'page_header_banner' ], absint( '10' ) );
        }

        /**
         *  Page Header Banner
         *  ------------------
         */
        public static function page_header_banner(){

            /**
             *  Is Page ?
             *  ---------
             */
            $setting  =     esc_attr( get_post_meta(

                                /**
                                 *  1. Page ID
                                 *  ----------
                                 */
                                absint( get_the_ID() ), 

                                /**
                                 *  2. Meta Key
                                 *  -----------
                                 */
                                sanitize_key( 'page_banner_show_hide' ),

                                /**
                                 *  3. TRUE
                                 *  -------
                                 */
                                true

                            ) );

            /**
             *  Page Header Banner Condition
             *  ----------------------------
             */
            if( $setting !== 'off' && ! ( is_front_page() && is_home() ) ){

                /**
                 *  Is not home page + front page
                 *  -----------------------------
                 */
                if( ! ( is_home() && is_front_page() ) ){

                    /**
                     *  Default Header Banner
                     *  ---------------------
                     */
                    self:: weddingdir_default_page_header();
                }
            }
        }

        /**
         *  Image + Page Header Banner
         *  --------------------------
         */
        public static function weddingdir_default_page_header(){

            /**
             *  Make sure framework is activated
             *  --------------------------------
             */
            $solid_bg       =       true;

            $image_bg       =       false;

            /**
             *  Make sure plugin activated
             *  --------------------------
             */
            if( class_exists( 'OT_Loader' ) ){

                /**
                 *  Is Image BG selected ?
                 *  ----------------------
                 */
                if( weddingdir_option( 'page_header_banner_layout' ) == esc_attr( 'layout-one' ) ){

                    $image_bg       =       true;
                }

                /**
                 *  Default Solid BG
                 *  ----------------
                 */
                else{

                    $solid_bg       =       true;
                }
            }

            /**
             *  Image BG Selected
             *  -----------------
             */
            if( $image_bg ){

                /**
                 *  Page Header Image
                 *  -----------------
                 */
                $page_image     =   esc_url( get_post_meta(

                                        /**
                                         *  1. Page Object ID
                                         *  -----------------
                                         */
                                        absint( parent:: weddingdir_page_id() ), 

                                        /**
                                         *  2. Meta Key
                                         *  -----------
                                         */
                                        sanitize_key( 'page_banner' ), 

                                        /**
                                         *  3. TRUE
                                         *  -------
                                         */
                                        true

                                    ) );

                /**
                 *  Make sure this page have background image
                 *  -----------------------------------------
                 */
                if( ! empty( $page_image ) && weddingdir_option( 'page_banner_show_hide', 'off' ) == 'on' ){

                    /**
                     *  Individual Page Header Banner Image
                     *  -----------------------------------
                     */
                    $_get_image     =   $page_image;
                }

                /**
                 *  Have Filter Image ?
                 *  -------------------
                 */
                elseif( ! empty( apply_filters( 'weddingdir/page-header-banner/image', '' ) ) ){

                    /**
                     *  Filter Image
                     *  ------------
                     */
                    $_get_image     =   apply_filters( 'weddingdir/page-header-banner/image', '' );
                }

                /**
                 *  Theme Option Setting
                 *  --------------------
                 */
                else{

                    /**
                     *  Page Header Banner
                     *  ------------------
                     */
                    $_get_image     =   esc_url( weddingdir_option( 'header_banner', esc_url( WEDDINGDIR_THEME_DIR . 'images/banner-bg.jpg' ) ) );
                }

                ?>
                <section class="breadcrumbs-page" style="<?php printf( 'background:url(%1$s);background-size:cover;', esc_url( $_get_image )  ); ?>">

                    <div class="container">

                        <h1 class="page-title"><?php echo self:: weddingdir_page_header_title(); ?></h1>

                        <?php self:: page_breadcrumbs(); ?>

                    </div>

                </section>
                <?php
            }

            /**
             *  Load Solid BG
             *  -------------
             */
            else{

                /**
                 *  Background Color
                 *  ----------------
                 */
                $bg_color       =       weddingdir_option( 'page_header_banner_background_color', 'rgba(0, 0, 0, 0.4)' );

                ?>
                <section class="breadcrumbs-page" style="<?php printf( 'background: %1$s;', $bg_color ); ?>">

                    <div class="container">

                        <h1 class="page-title"><?php echo self:: weddingdir_page_header_title(); ?></h1>

                        <?php self:: page_breadcrumbs(); ?>

                    </div>

                </section>
                <?php
            }
        }

        /**
         *  WeddingDir - Post / Page Heading Title
         *  --------------------------------------
         */
        public static function weddingdir_page_header_title(){

            global $wp_query, $post;

            /**
             *  Find Page Title
             *  ---------------
             */
            if( is_home() && ! is_front_page() ){

                /**
                 *  Is Blog Post Page ?
                 *  -------------------
                 */
                return  esc_attr(   get_the_title( get_option( 'page_for_posts' ) )  );


            }elseif( is_archive() ) {

                /**
                 *  Is Archive Page ?
                 *  -----------------
                 */
                return  get_the_archive_title();


            }elseif( is_search() ) {

                /**
                 *  Is Search page ?
                 *  ----------------
                 */
                return      sprintf(    esc_attr__( 'Search : %1$s', 'weddingdir' ),

                                        /**
                                         *  1. Search Query
                                         *  ---------------
                                         */
                                        esc_attr(  get_search_query() )
                            );


            }elseif( is_404() ){

                /**
                 *  Is 404 Error Page ?
                 *  -------------------
                 */
                return  esc_attr__( 'Error Page', 'weddingdir'  );


            }else {

                /**
                 *  Default Get Page Title
                 *  ----------------------
                 */
                return  get_the_title();
            }
        }

        /**
         *  Have Breadcrumbs ?
         *  ------------------
         */
        public static function page_breadcrumbs(){

            /**
             *  Page Meta Enable / Disable this setting ?
             *  -----------------------------------------
             */
            $_breadcrumb_meta   =   esc_attr(   get_post_meta( 

                                        /**
                                         *  1. Page Object ID
                                         *  -----------------
                                         */
                                        absint( parent:: weddingdir_page_id() ), 

                                        /**
                                         *  2. Meta Key
                                         *  -----------
                                         */
                                        sanitize_key( 'breadcrumbs_show_hide' ), 

                                        /**
                                         *  3. TRUE
                                         *  -------
                                         */
                                        true 

                                    )   );

            /**
             *  Have Breadcrumbs ?
             *  ------------------
             */
            $_condition_1   =   $_breadcrumb_meta   !=      esc_attr( 'off' );

            $_condition_2   =   $_breadcrumb_meta   ==      esc_attr( 'on' );

            /**
             *   1. Have Breadcrumbs Plugin Activated
             *   ------------------------------------
             *   2. Page Setting Have Breadrumbs show option switch *ON*
             *   -------------------------------------------------------
             */
            if( ( $_condition_1 || $_condition_2 ) && function_exists('bcn_display') ){

                ?>

                <section class="weddingdir-page-breadcrumbs">

                    <ol class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">

                        <?php

                            /**
                             *  @link https://wordpress.org/plugins/breadcrumb-navxt/
                             *  -----------------------------------------------------
                             */

                            bcn_display_list();
                        ?>

                    </ol>

                </section>

                <?php
            }
        }
    }

    /**
     *  WeddingDir - Page Header Banner
     *  -------------------------------
     */
    WeddingDir_Page_Header_Banner::get_instance();
}