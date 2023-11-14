<?php
/**
 * -------------------------
 * Exit if accessed directly
 * -------------------------
 */
defined( 'ABSPATH' ) || exit;

/**
 *  -------------------------------------------
 *  WeddingDir - WordPress Theme Functions File
 *  -------------------------------------------
 *  Load WeddingDir Object
 *  ----------------------
 */
if ( ! class_exists( 'WeddingDir' ) ) {

	/**
     *  ----------------------------
	 *  WeddingDir - WordPress Theme
	 *  ----------------------------
	 *  @package weddingdir
     *  -------------------
	 *  @since 1.0.0
     *  ------------
	 */
    class WeddingDir {

        /**
         *  Member Variable
         *  ---------------
         *  @var instance
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
             *  1. Load Constant
             *  ----------------
             */
            $this->constant();

            /**
             *  2. Required Files
             *  -----------------
             */
            add_action( 'after_setup_theme', [ $this, 'weddingdir_theme_setup' ] );

            /**
             *  Register Sidebar
             *  ----------------
             */
            add_action( 'widgets_init',  [ $this, 'weddingdir_widget_init' ] );

            /**
             *  WeddingDir - Required Files
             *  ---------------------------
             */
            self:: weddingdir_required_files();

            /**
             *  IS SSL Connection ? 
             *  -------------------
             *  @link - https://developer.wordpress.org/reference/hooks/https_ssl_verify/#user-contributed-notes
             *  ------------------------------------------------------------------------------------------------
             */
            if( ! is_ssl() ){

                add_filter( 'https_ssl_verify', '__return_false' );
            }
        }

        /**
         *  WeddingDir - Product Constant
         *  -----------------------------
         */
        public static function constant(){

        	/**
        	 *   @ref : https://codex.wordpress.org/Content_Width
        	 *   ------------------------------------------------
        	 */
			if ( ! isset( $content_width ) ){

				$content_width 		= 	absint( '1400' );
			}

            /**
             *  WeddingDir - Theme DEV MODE IS ON / OFF ?
             *  -----------------------------------------
             */
            if( ! defined( 'WEDDINGDIR_THEME_DEV' ) ){

                define( 'WEDDINGDIR_THEME_DEV',  apply_filters( 'WEDDINGDIR_DEV', false ) );
            }

			/**
			 *  WeddingDir - Theme Version
			 *  --------------------------
			 */
			if( ! defined( 'WEDDINGDIR_THEME_VERSION' ) ){

				define( 'WEDDINGDIR_THEME_VERSION',  esc_attr(  wp_get_theme()->get( 'Version' ) )   );
			}

			/**
			 *  WeddingDir - Theme Directory Path
			 *  ---------------------------------
			 */
			if( ! defined( 'WEDDINGDIR_THEME_DIR' ) ){

				define( 'WEDDINGDIR_THEME_DIR',   trailingslashit( get_template_directory_uri() )  );
			}

            /**
             *  WeddingDir - Theme Path
             *  -----------------------
             */
            if( ! defined( 'WEDDINGDIR_THEME_PATH' ) ){

                define( 'WEDDINGDIR_THEME_PATH',   trailingslashit( get_template_directory() )  );
            }

			/**
			 *  WeddingDir - Theme Library Folder Path
			 *  --------------------------------------
			 */
			if( ! defined( 'WEDDINGDIR_THEME_LIBRARY' ) ){

				define( 'WEDDINGDIR_THEME_LIBRARY',   WEDDINGDIR_THEME_DIR . '/assets/library/'  );
			}

			/**
			 *  WeddingDir - Theme Image Folder Path
			 *  ------------------------------------
			 */
			if( ! defined( 'WEDDINGDIR_THEME_MEDIA' ) ){

				define( 'WEDDINGDIR_THEME_MEDIA',   WEDDINGDIR_THEME_DIR . '/assets/images/'   );
			}

            /**
             *  WeddingDir - PREFIX
             *  -------------------
             */
            if( ! defined( 'WEDDINGDIR_THEME_PREFIX' ) ){

                define( 'WEDDINGDIR_THEME_PREFIX',  esc_attr( sanitize_title(  wp_get_theme()->get( 'Name' ) ) )  );
            }

            /**
             *  WeddingDir - Footer Widget Prefix ID
             *  ------------------------------------
             */
            if( ! defined( 'WEDDINGDIR_FOOTER_WIDGET' ) ){

                define( 'WEDDINGDIR_FOOTER_WIDGET',  esc_attr( WEDDINGDIR_THEME_PREFIX  . '-footer-widget-'  )  );
            }
        }

        /**
         *  Load WeddingDir - Files
         *  -----------------------
         */
        public static function weddingdir_theme_setup(){

            /**
             *  1. Load translation domain
             *  --------------------------
             */
            load_theme_textdomain( 'weddingdir', trailingslashit( get_template_directory() ) . '/language' );

            /**
             *  2. Register Menus
             *  -----------------
             */
            register_nav_menus( apply_filters( 'weddingdir/nav-menus', [] ) );

            /**
             *  3. Add theme support for Automatic Feed Links
             *  ---------------------------------------------
             */
            add_theme_support( 'automatic-feed-links' );    

            /**
             *  4. Add theme support for document Title tag
             *  -------------------------------------------
             */
            add_theme_support( 'title-tag' );

            /**
             *  5. Post Thumbnails Support
             *  --------------------------
             *  @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
             *  ---------------------------------------------------------------------------------------- 
             */
            add_theme_support( 'post-thumbnails' );

            /**
             *  6. Add theme support for HTML5 Semantic Markup
             *  ----------------------------------------------
             */
            add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

            /**
             *  7. Add theme support for Post Formats
             *  -------------------------------------
             */
            add_theme_support( 'post-formats', array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat' ) );

            /**
             *  8. Add theme support for Custom Background
             *  ------------------------------------------
             */
            add_theme_support( 'custom-background', array( 'default-color' => 'ffffff', 'default-image' => '' ) );

            /**
             *  --------------------------------------
             *  9. WeddingDir - Have Image Size Crop ?
             *  --------------------------------------
             *  @credit -  https://developer.wordpress.org/reference/functions/add_image_size/
             *  ------------------------------------------------------------------------------
             */
            if( self:: _is_array( apply_filters( 'weddingdir/image-size', [] ) ) ){

                /**
                 *  Have image size in WeddingDir ?
                 *  -------------------------------
                 */
                foreach( apply_filters( 'weddingdir/image-size', [] ) as $key => $value ){

                    /**
                     *  Extract Args
                     *  ------------
                     */
                    extract( $value );

                    /**
                     *  Create Image Size
                     *  -----------------
                     */
                    add_image_size( esc_attr( $key ), absint( $width ), absint( $height ), true );
                }
            }

            /**
             *  10. WeddingDir - WordPress Media Image Size Update in list
             *  ----------------------------------------------------------
             */
            add_filter( 'image_size_names_choose', function ( $size = [] ) {

                $weddingdir_media_size = [];

                /**
                 *  Have image size in WeddingDir ?
                 *  -------------------------------
                 */
                foreach( apply_filters( 'weddingdir/image-size', [] ) as $key => $value ){

                    /**
                     *  Extract Args
                     *  ------------
                     */
                    extract( $value );

                    /**
                     *  Get List
                     *  --------
                     */
                    $weddingdir_media_size[ $key ]  =  esc_attr( $name );
                }

                return array_merge( $size, $weddingdir_media_size );

            } );

            /**
             *  --------------------------
             *  18. WeddingDir - Menu Load
             *  --------------------------
             *  @credit : https://github.com/wp-bootstrap/wp-bootstrap-navwalker
             *  ----------------------------------------------------------------
             *  Installation as instruction : after_setup_theme
             *  -------------------------------------------------------------------
             *  # https://github.com/wp-bootstrap/wp-bootstrap-navwalker#installation
             *  ---------------------------------------------------------------------
             */
            require_once 'inc/bootstrap-menu.php';
        }

        /**
         *  WeddingDir - Required Files
         *  ---------------------------
         */
        public static function weddingdir_required_files(){

            /**
             *  WeddingDir - Template Helper Load
             *  ---------------------------------
             */
            require_once 'inc/template-helper.php';

            /**
             *  WeddingDir - Used Style + Scripts
             *  ---------------------------------
             */
            require_once 'inc/theme-scripts.php';

            /**
             *  Gutenberg Compatible Theme
             *  --------------------------
             */
            require_once 'inc/gutenberg-support.php';

            /**
             *  WeddingDir - Theme Header Tag Actions
             *  -------------------------------------
             */
            require_once 'inc/theme-header.php';

            /**
             *  WeddingDir - Theme Footer
             *  -------------------------
             */
            require_once 'inc/theme-footer.php';

            /**
             *  WeddingDir - Comment Section Helper
             *  -----------------------------------
             */
            require_once 'inc/comment-template-part.php';

            /**
             *  WeddingDir - Grid Managment
             *  ---------------------------
             */
            self:: grid_managment();

            /**
             *  WeddingDir- Theme Body Markup ( attributes )
             *  --------------------------------------------
             */
            require_once 'inc/theme-body.php';

            /**
             *  WeddingDir - Page Header Banner Object
             *  --------------------------------------
             */
            require_once 'inc/class-page-header-banner.php';

            /**
             *  WeddingDir - Blog Load Helper
             *  -----------------------------
             */
            require_once 'template-parts/content-helper.php';

            /**
             *  WeddingDir - Blog Post
             *  ----------------------
             */
            require_once 'template-parts/weddingdir-blog.php';

            /**
             *  WeddingDir - Blog Load Helper
             *  -----------------------------
             */
            require_once 'template-parts/content-helper.php';

            /**
             *  WeddingDir - Page Grid Managment
             *  --------------------------------
             */
            require_once 'inc/404-error-page.php';

            /**
             *  WeddingDir - Plugins Installation
             *  ---------------------------------
             */
            self:: recommended_plugins();

            /**
             *  WeddingDir - WooCommerce
             *  ------------------------
             */
            if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

                require_once 'inc/woocommerce.php';
            }
        }

        /**
         *  WeddingDir - Required Plugins
         *  -----------------------------
         */
        public static function recommended_plugins(){

            /**
             *  -------------------
             *  Required TGMPA File
             *  -------------------
             *  @package   TGM-Plugin-Activation
             *  @version   2.6.1 for parent theme WeddingDir for publication on ThemeForest
             *  @link      http://tgmpluginactivation.com/
             *  @author    Thomas Griffin, Gary Jones, Juliette Reinders Folmer
             *  @copyright Copyright (c) 2011, Thomas Griffin
             *  @license   GPL-2.0+
             *  ------------------------------------------------
             *  WeddingDir - Required / Recommended Plugin Setup
             *  ------------------------------------------------
             */            
            require_once 'inc/tgm-plugin/class-tgm-plugin-activation.php';

            /**
             *  WeddingDir - Required Plugins
             *  -----------------------------
             */
            require_once 'inc/tgm-plugin/required-plugin.php';
        }

        /**
         *  WeddingDir - Grid Managment
         *  ---------------------------
         */
        public static function grid_managment(){

            /**
             *  WeddingDir - Page Grid Managment
             *  --------------------------------
             */
            require_once 'inc/grid-managmnet/index.php';            

            /**
             *  WeddingDir - Container Managment
             *  --------------------------------
             */
            require_once 'inc/grid-managmnet/container.php';

            /** 
             *  WeddingDir - Sidebar Managment
             *  ------------------------------
             */
            require_once 'inc/grid-managmnet/sidebar-managment.php';
        }

        /**
         * 	Register Widget Area
         * 	--------------------
         * 	@link http://codex.wordpress.org/Function_Reference/register_sidebar
         *  --------------------------------------------------------------------
         */
        public static function weddingdir_widget_init(){

        	/**
        	 *  Register : Primary Menu Sidebar
        	 *  -------------------------------
        	 */
            register_sidebar( array(

                'name'          =>  esc_attr__( 'Primary Widget Area', 'weddingdir' ),

                'id'            =>  esc_attr( 'weddingdir-widget-primary' ),

                'description'   =>  esc_attr__( 'Add widgets here to appear in your sidebar section Primary Sidebar.', 'weddingdir' ),

                'before_widget' =>  '<div id="%1$s" class="weddingdir-sidebar side-widget widget %2$s">',

                'after_widget'  =>  '</div>',

                'before_title'  =>  '<h3 class="widget-title">',

                'after_title'   =>  '</h3>',

            ) );

            /**
             *  Have Setting Option Framework Object Exists ?
             *  ---------------------------------------------
             */
            if( class_exists( 'OT_Loader' ) ){

                /**
                 *  Register - Extra Sidebar 
                 *  ------------------------
                 */
                register_sidebar( array(

                    'name'          =>  esc_attr__( 'Secondary Widget Area', 'weddingdir' ),

                    'id'            =>  esc_attr( 'weddingdir-widget-secondary' ),

                    'description'   =>  esc_attr__( 'Add widgets here to appear in your sidebar section Secondary Sidebar.', 'weddingdir' ),

                    'before_widget' =>  '<div class="col-md-12"><div id="%1$s" class="weddingdir-sidebar side-widget widget %2$s">',

                    'after_widget'  =>  '</div></div>',

                    'before_title'  =>  '<h3 class="widget-title">',

                    'after_title'   =>  '</h3>',
                ) );

                /**
                 *  Register - Footer Sidebar
                 *  -------------------------
                 */
                for( $i = absint('1'); $i <= absint('6'); $i++ ){

                    register_sidebar( array(

                        'name'          =>  sprintf( esc_attr__( 'Footer Column %1$s', 'weddingdir' ),  absint( $i )  ),

                        'id'            =>  esc_attr(  WEDDINGDIR_FOOTER_WIDGET . absint( $i )  ),

                        'description'   =>  sprintf( esc_attr__( 'Footer Widget %1$s Column.', 'weddingdir' ), absint( $i )  ),

                        'before_widget' =>  '<div id="%1$s" class="footer-widget weddingdir-footerbar %2$s">',

                        'before_title'  =>  '<h3 class="widget-title">',

                        'after_title'   =>  '</h3>',

                        'after_widget'  =>  '</div>',

                    ) );
                }
            }
        }

        /**
         *  Test : Array Value
         *  ------------------
         */
        public static function _print_r( $a = [] ){

            /**
             *  If Is Array and have at lest one args ?
             *  ---------------------------------------
             */
            if ( self:: _is_array( $a ) ) {

                print '<pre>';

                    print_r( $a );

                print '</pre>';

            } else {

                return false;
            }
        }

        /**
         *  Check is array or not ?
         *  -----------------------
         */
        public static function _is_array( $a = [] ){

        	/**
        	 *  If Is Array and have at lest one args ?
        	 *  ---------------------------------------
        	 */
            if ( is_array($a) && count($a) >= absint('1') && !empty($a) && $a !== null ) {

                return true;

            } else { 

            	return false; 
            }
        }

        /**
         *  Check Have Variable Value ?
         *  ---------------------------
         */
        public static function _have_data( $a = '0' ){

            /**
             *  If Is Array and have at lest one args ?
             *  ---------------------------------------
             */
            if ( isset( $a ) && ! empty( $a ) && $a !== '' && $a !== NULL ) {

                return true;

            } else { 

                return false; 
            }
        }

        /** 
         *   Return Current Page Object ID
         *   -----------------------------
         */
        public static function weddingdir_page_id(){

            global $wp_query, $post;

            /**
             *  Have page query ?
             *  -----------------
             */
            if( is_object( $wp_query ) ){

                return  absint( $wp_query->queried_object_id );
            }
        }

        /**
         *  Get Page Meta information with current page object id
         *  -----------------------------------------------------
         */
        public static function weddingdir_meta_value( $meta_key = '' ){

            if( empty( $meta_key ) ){

                return;
            }

            /**
             *  Return Meta Value
             *  -----------------
             */
            return      esc_attr(   get_post_meta(

                            /**
                             *  1. Get Page Object ID
                             *  ---------------------
                             */
                            absint( self:: weddingdir_page_id() ),

                            /**
                             *  2. Meta Key
                             *  -----------
                             */
                            sanitize_key( $meta_key ),

                            /**
                             *  3. TRUE
                             *  -------
                             */
                            true

                        )   );
        }

        /**
         *  Is Dashboard Page Template ?
         *  ----------------------------
         */
        public static function is_dashboard(){

            global  $post, $wp_query, $page;

            /**
             *  Is *couple* dashboard - Page Template
             *  -------------------------------------
             */
            $_condition_1   =   is_page_template( 'user-template/couple-dashboard.php' );

            /**
             *  Is *vendor* dashboard - Page Template
             *  -------------------------------------
             */
            $_condition_2   =   is_page_template( 'user-template/vendor-dashboard.php' );

            /**
             *  Is Dashboard Page Template ?
             *  ----------------------------
             */
            return   (  $_condition_1 ||  $_condition_2  );
        }

        /**
         *  Page Show Sidebar Condition
         *  ---------------------------
         */
        public static function page_have_sidebar(){

            /**
             *  1. Make sure is : Home Page + Front Page
             *  ----------------------------------------
             */
            $_condition_1   =   is_front_page() && is_home();

            /**
             *  2. Make sure sidebar have at least one widget activated
             *  -------------------------------------------------------
             */
            $_condition_2   =   is_active_sidebar( esc_attr( 'weddingdir-widget-primary' ) );

            /**
             *  3. Make sure option tree plugin is activated
             *  --------------------------------------------
             */
            $_condition_3   =  class_exists( 'OT_Loader' );

            /**
             *  Make sure is home page + front page
             *  -----------------------------------
             */
            if( $_condition_1 && $_condition_2 ){

                return false;

            }elseif( $_condition_3 && ! $_condition_1 ){

                return true;

            }else{

                return false;
            }
        }

        /**
         *  Check the enable library / script / style request filter available ?
         *  --------------------------------------------------------------------
         */
        public static function _load_script( $hook = '' ){

            /**
             *  Make sure hook not empty
             *  ------------------------
             */
            if( empty( $hook ) ){

                return false;
            }

            /**
             *  Have Collection ?
             *  -----------------
             */
            $_request_collection    =   apply_filters( $hook, [] );

            /**
             *  Have Request ?
             *  --------------
             */
            if( self:: _is_array( $_request_collection ) && in_array( 'true', $_request_collection ) ){

                return  true;

            }else{

                return false;
            }
        }

        /**
         *  File Version
         *  ------------
         */
        public static function _file_version( $file = '' ){

            /**
             *  Is Empty ?
             *  ----------
             */
            if( empty( $file ) ){

                /**
                 *  Get Style Version
                 *  -----------------
                 */

                return  esc_attr( WEDDINGDIR_THEME_VERSION );

            }else{

                /*
                 *  For File Save timestrap version to clear the catch auto
                 *  -------------------------------------------------------
                 *  # https://developer.wordpress.org/reference/functions/wp_enqueue_style/#comment-6386
                 *  ------------------------------------------------------------------------------------
                 */

                return      absint( filemtime(  WEDDINGDIR_THEME_PATH . $file ) );
            }
        }

        /**
         *  Array Conver to Sanitize Class
         *  ------------------------------
         *  @article - https://developer.wordpress.org/reference/functions/sanitize_html_class/
         *  -----------------------------------------------------------------------------------
         */
        public static function _class( $class = [] ){

            /**
             *  Make sure it's array 
             *  --------------------
             */
            if( self:: _is_array( $class ) ){

                /**
                 *  Return Class
                 *  ------------
                 */
                return      esc_attr(  join( ' ', array_map( 'sanitize_html_class', $class ) )  );
            }
        }
    }

    /**
     *  Load WeddingDir Core Plugin Object
     *  ---------------------------------
     */
    WeddingDir::get_instance();
}