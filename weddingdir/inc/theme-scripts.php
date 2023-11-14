<?php
/**
 *  WeddingDir - Scripts
 *  --------------------
 */
if( ! class_exists( 'WeddingDir_Theme_Scripts' ) && class_exists( 'WeddingDir' ) ){

    /**
     *  WeddingDir - Scripts
     *  --------------------
     */
    class WeddingDir_Theme_Scripts extends WeddingDir {

        /**
         *  Member Variable
         *  ---------------
         *  @var instance
         *  -------------
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
             *  1. Post Content Wise Script Load
             *  --------------------------------
             */
            add_action( 'wp_enqueue_scripts', [ $this, 'weddingdir_post_script_load' ], absint( '300' ) );

            /**
             *  1. Load WeddingDir - Style + Script Here
             *  ----------------------------------------
             */
            add_action( 'wp_enqueue_scripts', [ $this, 'weddingdir_scripts_markup' ], absint( '999' ) );

            /**
             *  2. WeddingDir - Icon Manager Filter
             *  -----------------------------------
             */
            add_filter( 'weddingdir_icon_library', [ $this, 'add_new_icon_library' ] );
        }

        /**
         *  Have Post Content ?
         *  -------------------
         */
        public static function weddingdir_post_script_load(){

            global $post, $page, $wp_query;

            /**
             *  Is Home or Front
             *  ----------------
             */
            if( is_front_page() ){

                /**
                 *  Load Library Condition
                 *  -----------------------
                 */
                add_filter( 'weddingdir/enable-script/owl-carousel', function( $args = [] ){

                    return  array_merge( $args, [ 'weddingdir-front-page'  =>  true  ] );

                } );
            }

            /**
             *  Is Home or Front
             *  ----------------
             */
            if( is_home() ){

                /**
                 *  Load Library Condition
                 *  -----------------------
                 */
                add_filter( 'weddingdir/enable-script/owl-carousel', function( $args = [] ){

                    return  array_merge( $args, [  'weddingdir-home-page'  =>  true  ] );

                } );                
            }

            /**
             *  Is Post Single Page ?
             *  ---------------------
             */
            if( is_single() && get_post_format( absint( get_the_ID() ) ) == esc_attr( 'gallery' ) ){

                /**
                 *  Load Library Condition
                 *  -----------------------
                 */
                add_filter( 'weddingdir/enable-script/owl-carousel', function( $args = [] ){

                    return  array_merge( $args, [  'weddingdir-gallery-post-single'  =>  true  ] );

                } );
            }

            /**
             *  Is is_category() || is_tag() || is_archive() Page ?
             *  ---------------------------------------------------
             */
            if( is_category() || is_tag() || is_archive() ){

                /**
                 *  Load Library Condition
                 *  -----------------------
                 */
                add_filter( 'weddingdir/enable-script/owl-carousel', function( $args = [] ){

                    return  array_merge( $args, [  'weddingdir-archive-page'  =>  true  ] );

                } );
            }
        }

        /**
         *   Add New Font Library link
         *   -------------------------
         */
        public static function add_new_icon_library( $args = [] ){

            return      array_merge(

                            /**
                             *  Have args ?
                             *  -----------
                             */
                            $args,

                            /**
                             *  Add New font
                             *  ------------
                             */
                            array(

                                'fontawesome'       =>  esc_url(    WEDDINGDIR_THEME_LIBRARY . 'fontawesome-4.7.0/font-awesome.min.css'   ),

                                'weddingdir-icon'   =>  esc_url(    WEDDINGDIR_THEME_LIBRARY . 'weddingdir-icon/style.css'   ),
                            )
                        );
        }

        /**
         *  2. Enqueue scripts and styles
         *  -----------------------------
         */
        public static function weddingdir_scripts_markup(){

            global $wp_styles;

            /**
             *  1. Load Bootstrap Framework ( MINFY + UNMINFY - Both file included in this package )
             *  ------------------------------------------------------------------------------------
             */
            self:: bootstrap();

            /**
             *  2. Load Fontawesome Icon
             *  ------------------------
             */
            self:: fontawesome();

            /**
             *  3. Load WeddingDir Icon
             *  -----------------------
             */
            self:: weddingdir_icon();

            /**
             *  4. Load Owl Carousel Library
             *  ----------------------------
             */
            self:: owl_carousel();

            /**
             *  6. Bootstrap Menu Load
             *  ----------------------
             */
            self:: bootstrap_menu();

            /**
             *  7. Load WeddingDir - Theme Style
             *  --------------------------------
             */
            self:: theme_style();

            /**
             *  8. Load WeddingDir - Theme Script
             *  ---------------------------------
             */
            self:: theme_script();

            /**
             *  9. Load Comment Reply Script Loaded in page
             *  -------------------------------------------
             */
            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

                wp_enqueue_script( 'comment-reply' );
            }

            /**
             *  10. Register Google font in WeddingDir Theme
             *  --------------------------------------------
             */
            $_have_font_family  =   weddingdir_option( 'weddingdir-font-family' );

            if( parent:: _is_array( $_have_font_family ) ){

                if( ! parent:: _is_array( array_filter( array_column( $_have_font_family, 'family' ) ) ) ){

                    self:: weddingdir_font();
                }

            }else{

                self:: weddingdir_font();
            }
        }

        /**
         *  1. Load Bootstrap Framework ( MINFY + UNMINFY - Both File is included in this package )
         *  ---------------------------------------------------------------------------------------
         */
        public static function bootstrap(){

            /**
             *  Load Style
             *  ----------
             */
            wp_enqueue_style( 

                /**
                 *  1. File Name
                 *  ------------
                 */
                esc_attr( 'bootstrap' ),

                /**
                 *  2. File Path
                 *  ------------
                 */
                esc_url(    WEDDINGDIR_THEME_LIBRARY . 'bootstrap-5.0.2/css/bootstrap.min.css'    ),

                /**
                 *  3. Have Dependancy ?
                 *  --------------------
                 */
                parent:: _load_script( 'weddingdir/enable-script/owl-carousel' )

                ?   [ 'owl-carousel' ]

                :   [],

                /**
                 *  4. Bootstrap - Library Version
                 *  ------------------------------
                 */
                esc_attr( parent:: _file_version( 'assets/library/bootstrap-5.0.2/css/bootstrap.min.css' ) ),

                /**
                 *  5. Load All Media
                 *  -----------------
                 */
                esc_attr( 'all' )
            );

            /**
             *  Bootstrap FrameWork JS File ( MIN FILE + UNMINFY FILE IS INCLUDED IN LIBRARY FOLDER )
             *  -------------------------------------------------------------------------------------
             */
              wp_enqueue_script( 

                  /**
                   *  1. File Name
                   *  ------------
                   */
                  esc_attr( 'bootstrap' ), 

                  /**
                   *  2. File Path
                   *  ------------
                   */
                  esc_url(   WEDDINGDIR_THEME_LIBRARY . 'bootstrap-5.0.2/js/bootstrap.bundle.min.js'   ),

                  /**
                   *  3. Load After "JQUERY" Load
                   *  ---------------------------
                   */
                  array( 'jquery' ),

                  /**
                   *  4. Bootstrap - Library Version
                   *  ------------------------------
                   */
                  esc_attr( parent:: _file_version( 'assets/library/bootstrap-5.0.2/js/bootstrap.bundle.min.js' ) ),

                  /**
                   *  5. Load in Footer
                   *  -----------------
                   */
                  true 
            );
        }

        /**
         *  2. Load : Fontawesome 4.7.0 - ICON
         *  ----------------------------------
         */
        public static function fontawesome(){

          /**
           *  Load Fontawesome Icon Library
           *  -----------------------------
           */
          wp_enqueue_style(

                  /**
                   *  1. File Name
                   *  ------------
                   */
                  esc_attr(   'fontawesome'   ),

                  /**
                   *  2. File Path
                   *  ------------
                   */
                  esc_url(    WEDDINGDIR_THEME_LIBRARY . 'fontawesome-4.7.0/font-awesome.min.css'   ), 

                  /**
                   *  3. Dependency ( Load after bootstrap framework )
                   *  ------------------------------------------------
                   */
                  array( 'bootstrap' ), 

                  /**
                   *  4. Fontawesome Library Version
                   *  ------------------------------
                   */
                  esc_attr( parent:: _file_version( 'assets/library/fontawesome-4.7.0/font-awesome.min.css' ) ),

                  /**
                   *  Media ALL
                   *  ---------
                   */
                  esc_attr(   'all'  )
            );
        }

        /**
         *  2. Load WeddingDir Icon
         *  -----------------------
         */
        public static function weddingdir_icon(){

          /**
           *  Load Fontawesome Icon Library
           *  -----------------------------
           */
          wp_enqueue_style(

                  /**
                   *  1. File Name
                   *  ------------
                   */
                  esc_attr(   'weddingdir-icon'   ),

                  /**
                   *  2. File Path
                   *  ------------
                   */
                  esc_url(    WEDDINGDIR_THEME_LIBRARY . 'weddingdir-icon/style.css'   ),

                  /**
                   *  3. Dependency ( Load after bootstrap framework )
                   *  ------------------------------------------------
                   */
                  array( 'bootstrap' ), 

                  /**
                   *  4. Fontawesome Library Version
                   *  ------------------------------
                   */
                  esc_attr( parent:: _file_version( 'assets/library/weddingdir-icon/style.css' ) ),

                  /**
                   *  Media ALL
                   *  ---------
                   */
                  esc_attr(   'all'  )
            );
        }

        /**
         *  3. Bootstrap Menu Load
         *  ----------------------
         */
        public static function bootstrap_menu(){

            /**
             *  Bootstrap Menu File
             *  -------------------
             */
            wp_enqueue_style( 

              /**
               *  File Name
               *  ---------
               */
              esc_attr(   'bootstrap_menu'  ), 

              /**
               *  File Path
               *  ---------
               */
              esc_url(    WEDDINGDIR_THEME_LIBRARY . 'bootstrap-menu/stylesheet.css'   ), 

              /**
               *  Load after bootstrap library load
               *  ---------------------------------
               */
              array( 'bootstrap' ),

              /**
               *  Bootstrap Menu version
               *  ----------------------
               */
              esc_attr( parent:: _file_version( 'assets/library/bootstrap-menu/stylesheet.css' ) ),

              /**
               *  Load in All Media
               *  -----------------
               */
              esc_attr(   'all'  )

            );

            /**
             *  Bootstrap Menu Script
             *  ---------------------
             */
            wp_enqueue_script( 

                /**
                 *  File Name
                 *  ---------
                 */
                esc_attr(   'bootstrap_menu'  ), 

                /**
                 *  File Path
                 *  ---------
                 */
                esc_url(    WEDDINGDIR_THEME_LIBRARY . 'bootstrap-menu/script.js'   ), 

                /**
                 *  Dependency
                 *  ----------
                 */
                array( 'jquery', 'bootstrap' ),

                /**
                 *  Menu Version ?
                 *  --------------
                 */
                esc_attr( parent:: _file_version( 'assets/library/bootstrap-menu/script.js' ) ),

                /**
                 *  Load in Footer ?
                 *  ----------------
                 */
                true 
            );
        }

        /**
         *  3. Load Owl Carousel Library
         *  ----------------------------
         */
        public static function owl_carousel(){

            /**
             *  Owl Carousel Load
             *  -----------------
             */
            if( parent:: _load_script( 'weddingdir/enable-script/owl-carousel' ) ){

               /**
                *  Load Owl Carouse Script
                *  -----------------------
                */
               wp_enqueue_style(

                    /**
                     *  File Name
                     *  ---------
                     */
                    esc_attr(   'owl-carousel'   ),

                    /**
                     *  File path
                     *  ---------
                     */
                    esc_url(    WEDDINGDIR_THEME_LIBRARY . 'owlcarousel/owl.carousel.min.css'   ),

                    /**
                     *  Dependency
                     *  ----------
                     */
                    [],

                    /**
                     *  File Version
                     *  ------------
                     */
                    esc_attr( parent:: _file_version( 'assets/library/owlcarousel/owl.carousel.min.css' ) ),

                    /**
                     *  Load Media in All ?
                     *  -------------------
                     */
                    esc_attr(   'all'    )
                );

                /**
                 *  Load Owl carouse script
                 *  -----------------------
                 */
                wp_enqueue_script( 

                      /**
                       *  File Name
                       *  ---------
                       */
                      esc_attr(   'owl-carousel'   ),

                      /**
                       *  File Path
                       *  ---------
                       */
                      esc_url(    WEDDINGDIR_THEME_LIBRARY . 'owlcarousel/owl.carousel.min.js'   ), 

                      /**
                       *  Dependency
                       *  ----------
                       */
                      array( 'jquery' ),

                      /**
                       *  Owl carouse library version ?
                       *  -----------------------------
                       */
                      esc_attr( parent:: _file_version( 'assets/library/owlcarousel/owl.carousel.min.js' ) ),

                      /**
                       *  Load in Footer ?
                       *  ----------------
                       */
                      true 
                );
            }
        }

        /**
         *  5. Load WeddingDir - Theme Style
         *  --------------------------------
         */
        public static function theme_style(){

            /**
             *  Load WeddingDir - Style
             *  -----------------------
             */
            wp_enqueue_style(

                  /**
                   *  File Name
                   *  ---------
                   */
                  esc_attr(  'weddingdir-global-style'  ),

                  /**
                   *  File Path
                   *  ---------
                   */
                  esc_url( WEDDINGDIR_THEME_DIR . 'assets/css/weddingdir-global.css' ),

                  /**
                   *  Load WeddingDir - Style After Bootsrap Library
                   *  ----------------------------------------------
                   */
                  array( 'bootstrap' ),

                  /**
                   *  WeddingDir - Theme Version
                   *  --------------------------
                   */
                  esc_attr( parent:: _file_version( 'assets/css/weddingdir-global.css' ) ),

                  /**
                   *  Load Media in All
                   *  -----------------
                   */
                  esc_attr(  'all'  )
            );

            /**
             *  Load WeddingDir - Theme Style + Script
             *  --------------------------------------
             */
            if(  ! parent:: is_dashboard() && ! is_singular( 'website' ) ){

                /**
                 *  Load WeddingDir - Style
                 *  -----------------------
                 */
                wp_enqueue_style(

                      /**
                       *  File Name
                       *  ---------
                       */
                      esc_attr(  'weddingdir-custom-theme-style'  ),

                      /**
                       *  File Path
                       *  ---------
                       */
                      esc_url(    WEDDINGDIR_THEME_DIR . 'assets/css/theme-style.css'    ),

                      /**
                       *  Load WeddingDir - Style After Bootsrap Library
                       *  ----------------------------------------------
                       */
                      array( 'weddingdir-global-style' ),

                      /**
                       *  WeddingDir - Theme Version
                       *  --------------------------
                       */
                      esc_attr( parent:: _file_version( 'assets/css/theme-style.css' ) ),

                      /**
                       *  Load Media in All
                       *  -----------------
                       */
                      esc_attr(  'all'  )
                );
            }

            /**
             *  WeddingDir - style.css Loaded
             *  -----------------------------
             */
            wp_enqueue_style(

                  /**
                   *  File Name
                   *  ---------
                   */
                  esc_attr(  'weddingdir-parent-style'  ),

                  /**
                   *  File Path
                   *  ---------
                   */
                  esc_url(    WEDDINGDIR_THEME_DIR . 'style.css'    ),

                  /**
                   *  Load WeddingDir - Style After Bootsrap Library
                   *  ----------------------------------------------
                   */
                  !     parent:: is_dashboard() && ! is_singular( 'website' )

                  ?     [ 'weddingdir-custom-theme-style' ]

                  :     [ 'weddingdir-global-style' ],

                  /**
                   *  WeddingDir - Theme Version
                   *  --------------------------
                   */
                  esc_attr( parent:: _file_version( 'style.css' ) ),

                  /**
                   *  Load Media in All
                   *  -----------------
                   */
                  esc_attr(  'all'  )
            );

            /**
             *  Have inline Data ?
             *  ------------------
             */
            $_have_inline_style     =   implode( '', apply_filters( 'weddingdir/inline-style', [] ) );

            /**
             *  Insert Inline Style
             *  -------------------
             */
            if( parent:: _have_data( $_have_inline_style ) ){

                wp_add_inline_style(

                    /**
                     *  Insert Inline Style
                     *  -------------------
                     */
                    esc_attr(  'weddingdir-parent-style'  ),

                    /**
                     *  Insert Inline Style
                     *  -------------------
                     */
                    preg_replace('/\s+/', ' ', $_have_inline_style )
                );
            }
        }

        /**
         *  6. Load WeddingDir - Theme Script
         *  ---------------------------------
         */
        public static function theme_script(){

            /**
             *  Load WeddingDir Script
             *  ----------------------
             */
            wp_enqueue_script( 

                /**
                 *  1. File Name
                 *  ------------
                 */
                esc_attr(   'weddingdir-theme-script'   ), 

                /** 
                 *  2. File Link
                 *  ------------
                 */
                esc_url(    WEDDINGDIR_THEME_DIR . 'assets/js/theme-script.js'   ), 

                /**
                 *  3. Dependency
                 *  -------------
                 */
                array( 'jquery', 'bootstrap' ),

                /**
                 *  4. WeddingDir - Theme Version
                 *  -----------------------------
                 */
                esc_attr( parent:: _file_version( 'assets/js/theme-script.js' ) ),

                /**
                 *  5. Load in Footer ?
                 *  -------------------
                 */
                true 
            );
        }
            
        /**
         *  7. Register Google font in WeddingDir Theme
         *  -------------------------------------------
         *  @link : https://help.author.envato.com/hc/en-us/articles/360000479946-WordPress-Theme-Requirements-Part-4-Coding#h_8953617582691522300391297
         */
        public static function weddingdir_font(){

            wp_enqueue_style( 'weddingdir-fonts', esc_url_raw( self:: weddingdir_google_fonts() ), '', '1.0.0', 'screen' );
        }

        /**
         *  8. Editor Style
         *  ---------------
         */
        public static function weddingdir_editor_style(){

            /**
             *  WeddingDir - Editor Style
             *  -------------------------
             */
            wp_enqueue_style(

                /**
                *  File Name
                *  ---------
                */
                esc_attr(  'weddingdir-editor-style'  ),

                /**
                *  File Path
                *  ---------
                */
                esc_url(

                    trailingslashit( WEDDINGDIR_THEME_DIR ) . 'assets/css/editor-style.css'
                ),

                /**
                *  Load WeddingDir - Style After Bootsrap Library
                *  ----------------------------------------------
                */
                array( 'bootstrap', 'weddingdir-parent-style' ),

                /**
                *  WeddingDir - Theme Version
                *  --------------------------
                */
                esc_attr( parent:: _file_version( 'assets/css/editor-style.css' ) ),

                /**
                *  Load Media in All
                *  -----------------
                */
                esc_attr(  'all'  )
            );
        }

        /**
         *  WeddingDir - Font Family
         *  ------------------------
         */
        public static function weddingdir_google_fonts() {
        
           /**
            *  Load Font Family
            *  ----------------
            */
            return  esc_url_raw( 'https://fonts.googleapis.com/css?family=Old+Standard+TT:ital,wght@0,400;0,700;1,400|Nunito:wght@300;400;600;700' );
        }
    }

    /**
     *  WeddingDir - Script Object Call
     *  -------------------------------
     */
    WeddingDir_Theme_Scripts::get_instance();
}