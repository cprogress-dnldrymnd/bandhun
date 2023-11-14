<?php
/**
 *  WeddingDir - Header Action / Hooks
 *  ----------------------------------
 */
if( ! class_exists( 'WeddingDir_Header' ) && class_exists( 'WeddingDir' ) ){

    /**
     *  WeddingDir - Header Action / Hooks
     *  ----------------------------------
     */
    class WeddingDir_Header extends WeddingDir {

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
             *  1. WeddingDir - <Head> Tag Section
             *  ----------------------------------
             */ 
            add_action( 'weddingdir_head',  [ $this, 'weddingdir_head_markup'    ] );

            /**
             *  2. WeddingDir - Header Markup
             *  -----------------------------
             */
            add_action( 'weddingdir_header', [$this, 'weddingdir_header_markup' ], absint( '10' ) );

            /**
             *  3. WeddingDir - Header Markup
             *  -----------------------------
             */
            add_action( 'weddingdir_header', [$this, 'weddingdir_loader_markup' ], absint( '20' ) );

            /**
             *  4. WeddingDir - Custom Header
             *  -----------------------------
             */
            add_action( 'after_setup_theme', [$this, 'weddingdir_custom_header_setup' ] );

            /**
             *  5. WeddingDir - Load Header Version One
             *  ---------------------------------------
             */
            add_action( 'weddingdir_header_version', [ $this, 'weddingdir_header_version' ], absint( '10' ), absint( '1' ) );

            /**
             *  6. Add Primary Menu
             *  -------------------
             */
            add_action( 'weddingdir/nav-menus', function( $args = [] ){ 

                /**
                 *  Return the list of Menu
                 *  -----------------------
                 */
                return      array_merge(  

                                /**
                                 *  Have Menu ?
                                 *  -----------
                                 */
                                $args,

                                /**
                                 *  1. Merge New Menu
                                 *  -----------------
                                 */
                                array(

                                    /**
                                     *  Primary Menu - Header Menu Location
                                     *  -----------------------------------
                                     */
                                    'primary-menu'      =>  esc_attr__( 'Primary Menu',     'weddingdir' ), 
                                )
                            );

            }, absint( '10' ) );
        }

        /**
         *  Custom Heade
         *  ------------
         *  @credit - http://codex.wordpress.org/Custom_Headers
         *  ---------------------------------------------------
         */
        public static function weddingdir_custom_header_setup() {

            /**
             *  WeddingDir Supported - Custom Header
             *  ------------------------------------
             */
            add_theme_support( 

                /**
                 *  1. Custom Header ID
                 *  -------------------
                 */
                esc_attr( 'custom-header' ),

                /**
                 *  2. Options
                 *  ----------
                 */
                array(

                    'default-image'          =>  '',

                    'default-text-color'     =>  '',

                    'width'                  =>  absint( '2100' ),

                    'height'                 =>  absint( '300' ),

                    'flex-height'            =>  true,

                    'wp-head-callback'       =>  [ __CLASS__, esc_attr( 'weddingdir_custom_header_style' ) ],

                    'admin-head-callback'    =>  [ __CLASS__, esc_attr( 'weddingdir_admin_header_style' )  ],

                    'admin-preview-callback' =>  [ __CLASS__, esc_attr( 'weddingdir_admin_header_image' )  ],
                )
            );
        }

        /**
         *  Have Custom Header Support ?
         *  ----------------------------
         */
        public static function weddingdir_custom_header_style() {
            
            $header_text_color  =   get_header_textcolor();

            /**
             *  Have Custom Header Support ?
             *  ----------------------------
             */
            if ( add_theme_support( 'custom-header' ) == $header_text_color ) {
                return;
            }

            /**
             *  Inline style
             *  ------------
             */
            ?><style type="text/css"><?php

                if ( 'blank' == $header_text_color ){

                    printf(    '.weddingdir-site-title,  .site-description {
                                    position    : absolute;
                                    clip        : rect(1px, 1px, 1px, 1px);
                                }'
                    );

                }else{

                    printf(    '.weddingdir-site-title a,
                                .site-description {
                                    color: %1$s;
                                }',

                                /**
                                 *  1. Header Text Color
                                 *  --------------------
                                 */
                                sanitize_hex_color( $header_text_color )
                    );
                }

            ?></style><?php
        }

        /**
         *  When user are on customizer ( admin css )
         *  -----------------------------------------
         */
        public static function weddingdir_admin_header_style() {
        ?>
            <style type="text/css">
                .appearance_page_custom-header #headimg {
                    border: none;
                }
                #headimg h1,
                #desc {
                }
                #headimg h1 {
                }
                #headimg h1 a {
                }
                #desc {
                }
                #headimg img {
                }
            </style>
        <?php
        }

        /**
         *  WeddingDir - <Head> Tag Section
         *  -------------------------------
         */
        public static function weddingdir_head_markup(){

            ?>

            <meta charset="<?php bloginfo( 'charset' ); ?>">

            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="profile" href="http://gmpg.org/xfn/11">

            <?php

            if ( is_singular() && pings_open() ) {
                
                printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
            }
        }

        /**
         *  WeddingDir - Header Markup
         *  --------------------------
         */
        public static function weddingdir_header_markup(){

            /**
             *  Is not couple + vendor dashboard page template
             *  ----------------------------------------------
             */
            if(  ! ( parent:: is_dashboard() )  ){

                /**
                 *  WeddingDir Header Image
                 *  -----------------------
                 */
                self:: weddingdir_admin_header_image();

                /**
                 *  Check Header Version to Load on Page
                 *  ------------------------------------
                 */
                self:: load_header_version();
            }
        }

        /**
         *  WeddingDir - Loader Markup
         *  --------------------------
         */
        public static function weddingdir_loader_markup(){

            $_condition_1   =   weddingdir_option( 'weddingdir_have_loader' );

            /**
             *  Have Data ?
             *  -----------
             */
            if(  parent:: _have_data( $_condition_1 ) && $_condition_1 == esc_attr( 'on' )  ) {

                ?>

                <!-- preloader -->

                <div class="preloader">

                    <div class="status">

                        <?php

                            self:: weddingdir_brand( array(

                                'layout'          =>  absint( '3' )

                            ) );

                        ?>

                    </div>

                </div>

                <!-- end preloader -->

                <?php
            }
        }

        /**
         *  Have Header Image ?
         *  -------------------
         */
        public static function weddingdir_admin_header_image(){

            /**
             *  Check Have Header Image to load
             *  -------------------------------
             */
            if ( get_header_image() ){

                /**
                 *  Update Header Image
                 *  -------------------
                 */
                printf( '<img src="%1$s" alt="%2$s" height="%3$s" width="%4$s" />',

                    /**
                     *  1. Load Header Image SRC
                     *  ------------------------
                     */
                    esc_url(    get_header_image()      ),

                    /**
                     *  2. Image Alt text
                     *  -----------------
                     */
                    esc_attr(   get_bloginfo( 'title' )     ),

                    /**
                     *  3. Image Height
                     *  ---------------
                     *  esc_attr( get_custom_header()->height )
                     *  ---------------------------------------
                     */
                    esc_attr( 'auto' ),

                    /**
                     *  4. Image Width
                     *  --------------
                     *  esc_attr( get_custom_header()->width )
                     *  --------------------------------------
                     */
                    esc_attr( '100%' )
                );
            }
        }

        /**
         *  Set Header Version with Meta Option using
         *  -----------------------------------------
         */
        public static function load_header_version(){

            global $wp_query, $post, $page;

            /**
             *  Load Header version
             *  -------------------
             */
            if( ! parent:: is_dashboard() ){

                /**
                 *  Default Args
                 *  ------------
                 */
                $header_option          =   esc_attr( 'on' );

                $header_style           =   esc_attr( 'style-1' );

                /**
                 *  Have Option Tree Plugin ?
                 *  -------------------------
                 */
                $_condition_1           =  class_exists( 'OT_Loader' );

                $_condition_2           =  ! ( is_404() || is_tax() || is_category() || is_archive() );

                $_condition_3           =  is_singular( 'listing' );

                $_condition_4           =  is_singular( 'vendor' );

                $_condition_5           =  is_page_template( 'user-template/search-listing.php' );

                /**
                 *  If Option Tree Framework exists as plugins directory
                 *  ----------------------------------------------------
                 */
                if( $_condition_1  &&  $_condition_2 ){

                    $header_option  =   get_post_meta(

                                            /**
                                             *  1. Page ID
                                             *  ----------
                                             */
                                            absint(     parent:: weddingdir_page_id()    ),

                                            /**
                                             *  2. Meta Key
                                             *  -----------
                                             */
                                            sanitize_key(  'page_header_on_off'     ),

                                            /**
                                             *  3. TRUE
                                             *  -------
                                             */
                                            true
                                        );

                    $header_style   =   get_post_meta( 

                                            /**
                                             *  1. Page ID
                                             *  ----------
                                             */
                                            absint(     parent:: weddingdir_page_id()    ),

                                            /**
                                             *  2. Meta Key
                                             *  -----------
                                             */
                                            sanitize_key(   'header_style'    ),

                                            /**
                                             *  3. TRUE
                                             *  -------
                                             */
                                            true
                                        );
                }

                /**
                 *  If this page is : listing singular / vendor singular ?
                 *  ------------------------------------------------------
                 */
                if(  $_condition_3 || $_condition_4 || $_condition_5  ){

                    /**
                     *  Load Sec Header
                     *  ---------------
                     */
                    get_header( 'secondary' );

                }elseif( $header_option == esc_attr( 'on' ) ){

                    /**
                     *  1. Is Header Style Sec ?
                     *  ------------------------
                     */
                    if(  $header_style ==  esc_attr( 'style-2' )  ){

                        /**
                         *  Load Sec Header
                         *  ---------------
                         */
                        get_header( 'secondary' );

                    } else{

                        /**
                         *  Load Default Header
                         *  -------------------
                         */
                        get_header( 'default' );
                    }
                }else{

                    /**
                     *  Load Default Header
                     *  -------------------
                     */
                    get_header( 'default' );
                }
            }
        }

        /**
         *  Header Version One : Left Side
         *  ------------------------------
         */
        public static function header_one_have_left_side_data(){

            $_have_data     =   '';

            /**
             *  Have Setting Option Set Header Top Bar Data ?
             *  ---------------------------------------------
             */
            if ( parent:: _is_array( weddingdir_option( 'header_one_top_nav' ) ) ) {

                foreach ( weddingdir_option( 'header_one_top_nav' ) as $value ) {
            
                    /**
                     *  Print the Top Left Side Data
                     *  ----------------------------
                     */
                    $_have_data     .=      sprintf(   '<span>

                                                            <i class="fa %1$s"></i> %2$s

                                                        </span>',

                                                        /**
                                                         *  1. Get Icon
                                                         *  -----------
                                                         */
                                                        esc_attr( $value[ 'icon' ] ),

                                                        /**
                                                         *  2. Content - This is Editor value
                                                         *  ---------------------------------
                                                         */
                                                        strtr(

                                                            /**
                                                             *  Content
                                                             *  -------
                                                             */
                                                            $value[ 'content' ],

                                                            /**
                                                             *  Replace Args
                                                             *  ------------
                                                             */
                                                            array(

                                                                '<p>'      =>  '',

                                                                '</p>'     =>  '',
                                                            )
                                                        )
                                            );
                }

                /**
                 *  Have Left Side Data ?
                 *  ---------------------
                 */
                if( parent:: _have_data( $_have_data ) ){

                    return

                    sprintf(    '<div class="col-lg-9 col-sm-12">

                                    <div class="top-icons"> %1$s </div>

                                </div>',

                                /**
                                 *  1. Update Top Left Sidebar Data
                                 *  -------------------------------
                                 */
                                $_have_data
                    );
                }

            }else{

                return       false;
            }
        }

        /**
         *  Header Version One : Right Side
         *  -------------------------------
         */
        public static function header_one_have_right_side_data(){

            $_have_data     =   '';

            /**
             *  Have Setting Option Set Header Top Bar Data ?
             *  ---------------------------------------------
             */
            if ( parent:: _is_array( weddingdir_option( 'header_one_social_media' ) ) ) {

                foreach ( weddingdir_option( 'header_one_social_media' ) as $value ) {
            
                    /**
                     *  Print the Top Left Side Data
                     *  ----------------------------
                     */
                    $_have_data     .=          sprintf(   '<li>

                                                                <a href="%2$s" target="_blank"><i class="fa %1$s"></i></a>

                                                            </li>',

                                                            /**
                                                             *  1. Get Icon
                                                             *  -----------
                                                             */
                                                            esc_attr( $value[ 'icon' ] ), 

                                                            /**
                                                             *  2. Get Link
                                                             *  -----------
                                                             */
                                                            esc_url( $value[ 'link' ] ) 
                                                );
                }

                /**
                 *  Have Left Side Data ?
                 *  ---------------------
                 */
                if( parent:: _have_data( $_have_data ) ){

                    return

                    sprintf(    '<div class="col-lg-3 col-sm-12 col-lg">

                                    <div class="social-icons">

                                        <ul class="list-unstyled"> %1$s </ul>

                                    </div>

                                </div>',

                                /**
                                 *  1. Update Top Left Sidebar Data
                                 *  -------------------------------
                                 */
                                $_have_data
                    );
                }

            }else{

                return       false;
            }
        }

        /**
         *  WeddingDir - Theme Logo / Brand Name
         *  ------------------------------------
         */
        public static function weddingdir_brand( $args = [] ){

            /**
             *  Have Args
             *  ---------
             */
            if( parent:: _is_array( $args ) ){

                /**
                 *  Default args merge
                 *  ------------------
                 */
                $args   =   wp_parse_args(

                                /**
                                 *  1. Get Args
                                 *  -----------
                                 */
                                $args, 

                                /**
                                 *  2. Default Args
                                 *  ---------------
                                 */
                                array(

                                    'default_logo'      =>  esc_url( WEDDINGDIR_THEME_DIR . '/assets/images/logo/logo_dark.svg' ),

                                    'image_class'       =>  sanitize_html_class( 'logo' ),

                                    'text_logo'         =>  esc_attr( 'plain_text_logo' ),

                                    'image_logo'        =>  esc_attr( 'weddingdir_dark_logo' ),

                                    'print'             =>  true,

                                    'layout'            =>  absint( '1' )
                                )
                            );

                /**
                 *  Extract Args
                 *  ------------
                 */
                extract( $args );

                /**
                 *  Is Array ?
                 *  ----------
                 */
                if( parent:: _is_array( $args ) ){

                    /**
                     *  Is Text Logo ?
                     *  --------------
                     */
                    $_is_text_logo      =   weddingdir_option( $text_logo );

                    $_have_text_logo    =   parent:: _have_data( $_is_text_logo ) && $_is_text_logo == esc_attr( 'on' );

                    /**
                     *  If is header version one ? [ Layout = 1 ] 
                     *  -----------------------------------------
                     */
                    $_is_header_version_one             =   weddingdir_option( 'header_version_one_logo' );

                    $_have_header_version_one_logo      =   parent:: _have_data( $_is_header_version_one ) && ! ( $_have_text_logo );

                    /**
                     *  If is header version two ? [ Layout = 2 ] 
                     *  -----------------------------------------
                     */
                    $_is_header_version_two             =   weddingdir_option( 'header_version_two_logo' );

                    $_have_header_version_two_logo      =   parent:: _have_data( $_is_header_version_two ) && ! ( $_have_text_logo );

                    /**
                     *  If is Website Preloader ? [ Layout = 3 ] 
                     *  ----------------------------------------
                     */
                    $_is_website_preloader             =   weddingdir_option( 'weddingdir_loader_image' );

                    $_have_website_preload_logo        =   parent:: _have_data( $_is_website_preloader ) && ! ( $_have_text_logo );

                    /**
                     *  5. Image Alt : Translation Ready String
                     *  ---------------------------------------
                     */
                    $_logo_alt                         =  esc_attr__( 'Brand Site Logo', 'weddingdir' );

                    /**
                     *  Is Plain Logo ?
                     *  ---------------
                     */
                    if( $_have_text_logo ) {

                        $_weddingdir    =   sprintf(   '<h2 class="weddingdir-site-title">

                                                            <a href="%1$s" rel="home">%2$s</a>

                                                        </h2>',

                                                        /**
                                                         *  1. Home Link
                                                         *  -------------
                                                         */
                                                        esc_url( home_url( '/' ) ),  

                                                        /**
                                                         *  2. Blog Info
                                                         *  ------------
                                                         */
                                                        esc_attr( get_bloginfo( 'name' ) )
                                            );

                    }elseif( $layout == absint( '1' ) && $_have_header_version_one_logo ){

                        $_weddingdir    =   sprintf(   '<a class="navbar-brand" href="%1$s" rel="home">

                                                            <img class="%2$s" alt="%3$s %5$s" src="%4$s" />

                                                        </a>',

                                                        /**
                                                         *  1. Home Link
                                                         *  ------------
                                                         */
                                                        esc_url( home_url( '/' ) ),

                                                        /**
                                                         *  2. Have Image Class Sanitize
                                                         *  ----------------------------
                                                         */
                                                        sanitize_html_class( $image_class ),

                                                        /**
                                                         *  3. Blog info name
                                                         *  -----------------
                                                         */
                                                        esc_attr( get_bloginfo( 'name' ) ),

                                                        /**
                                                         *  4. Logo Link
                                                         *  ------------
                                                         */
                                                        esc_url( weddingdir_option( $_is_header_version_one ) ),

                                                        /**
                                                         *  5. Image Alt : Translation Ready String
                                                         *  ---------------------------------------
                                                         */
                                                        esc_attr( $_logo_alt )
                                            );

                    }elseif( $layout == absint( '2' ) && $_have_header_version_two_logo ){

                        $_weddingdir    =   sprintf(   '<a class="navbar-brand" href="%1$s" rel="home">

                                                            <img class="%2$s" alt="%3$s %5$s" src="%4$s" />

                                                        </a>',

                                                        /**
                                                         *  1. Home Link
                                                         *  ------------
                                                         */
                                                        esc_url( home_url( '/' ) ),

                                                        /**
                                                         *  2. Have Image Class Sanitize
                                                         *  ----------------------------
                                                         */
                                                        sanitize_html_class( $image_class ),

                                                        /**
                                                         *  3. Blog info name
                                                         *  -----------------
                                                         */
                                                        esc_attr( get_bloginfo( 'name' ) ),

                                                        /**
                                                         *  4. Logo Link
                                                         *  ------------
                                                         */
                                                        esc_url( weddingdir_option( $_is_header_version_two ) ),

                                                        /**
                                                         *  5. Image Alt : Translation Ready String
                                                         *  ---------------------------------------
                                                         */
                                                        esc_attr( $_logo_alt )
                                            );

                    }elseif( $layout == absint( '3' ) && $_have_website_preload_logo ){

                        $_weddingdir    =   sprintf(   '<a class="navbar-brand" href="%1$s" rel="home">

                                                            <img class="%2$s" alt="%3$s %5$s" src="%4$s" />

                                                        </a>',

                                                        /**
                                                         *  1. Home Link
                                                         *  ------------
                                                         */
                                                        esc_url( home_url( '/' ) ),

                                                        /**
                                                         *  2. Have Image Class Sanitize
                                                         *  ----------------------------
                                                         */
                                                        sanitize_html_class( $image_class ),

                                                        /**
                                                         *  3. Blog info name
                                                         *  -----------------
                                                         */
                                                        esc_attr( get_bloginfo( 'name' ) ),

                                                        /**
                                                         *  4. Logo Link
                                                         *  ------------
                                                         */
                                                        esc_url( weddingdir_option( $_is_website_preloader ) ),

                                                        /**
                                                         *  5. Image Alt : Translation Ready String
                                                         *  ---------------------------------------
                                                         */
                                                        esc_attr( $_logo_alt )
                                            );

                    }elseif( parent:: _have_data( $default_logo ) && ! ( $_have_text_logo ) ){

                        $_weddingdir    =   sprintf(   '<a class="navbar-brand" href="%1$s" rel="home">

                                                            <img class="%2$s" alt="%3$s %5$s" src="%4$s" />

                                                        </a>',

                                                        /**
                                                         *  1. Home Link
                                                         *  ------------
                                                         */
                                                        esc_url( home_url( '/' ) ),

                                                        /**
                                                         *  2. Have Image Class Sanitize
                                                         *  ----------------------------
                                                         */
                                                        sanitize_html_class( $image_class ),

                                                        /**
                                                         *  3. Blog info name
                                                         *  -----------------
                                                         */
                                                        esc_attr( get_bloginfo( 'name' ) ),

                                                        /**
                                                         *  4. Logo Link
                                                         *  ------------
                                                         */
                                                        esc_url( $default_logo ),

                                                        /**
                                                         *  5. Image Alt : Translation Ready String
                                                         *  ---------------------------------------
                                                         */
                                                        esc_attr( $_logo_alt )
                                            );

                    }else{

                        $_weddingdir    =   sprintf(   '<h2 class="weddingdir-site-title">

                                                            <a href="%1$s" rel="home">%2$s</a>

                                                        </h2>',

                                                        /**
                                                         *  1. Home Link
                                                         *  -------------
                                                         */
                                                        esc_url( home_url( '/' ) ),  

                                                        /**
                                                         *  2. Blog Info
                                                         *  ------------
                                                         */
                                                        esc_attr( get_bloginfo( 'name' ) )
                                            );
                    }
                }

                /**
                 *  Print / Return ?
                 *  ----------------
                 */
                if( $print == true ){

                    print   apply_filters( 'weddingdir_brand', $_weddingdir );

                }else{

                    return  apply_filters( 'weddingdir_brand', $_weddingdir );
                }


            }
        }


        /**
         *  WeddingDir - Header Version One Logo
         *  ------------------------------------
         */
        public static function have_brand( $args = [] ){

            /**
             *  Have args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){


                $args   =   wp_parse_args( $args, array(

                                'print'     =>      false

                            ) );

                /**
                 *  Load WeddingDir - Brand ( Logo / Plain Text )
                 *  ---------------------------------------------
                 */
                printf(    '<div class="d-flex %2$s">

                                %1$s 

                            </div>', 

                            /**
                             *  1. WeddingDir - Brand Logo
                             *  --------------------------
                             */
                            WeddingDir_Header:: weddingdir_brand( $args ),

                            /**
                             *  2. Is Dashboard ?
                             *  -----------------
                             */
                            parent:: is_dashboard()

                            ?   esc_attr( join( ' ', array_map(

                                    /**
                                     *  Sanitize Html Class
                                     *  -------------------
                                     */
                                    esc_attr( 'sanitize_html_class' ), 

                                    /**
                                     *  WeddingDir - Custom Class
                                     *  -------------------------
                                     */
                                    array( 

                                        esc_attr( 'align-items-center' ), 

                                        esc_attr( 'mx-auto' )
                                    )

                                ) ) )

                            :  sanitize_html_class( 'me-auto' )
                );
            }
        }

        /**
         *  4. WeddingDir - Load Header Version One
         *  ---------------------------------------
         */
        public static function weddingdir_header_version( $args = [] ){

            /**
             *  Have Args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){

                /**
                 *  Have Args ?
                 *  -----------
                 */
                $args           =       wp_parse_args( 

                                            /**
                                             *  1. Have Args ?
                                             *  --------------
                                             */
                                            $args,

                                            /**
                                             *  2. Default Args
                                             *  ---------------
                                             */
                                            array(

                                                'layout'        =>      absint( '1' )
                                            )
                                        );
                /**
                 *  Extract Values
                 *  --------------
                 */
                extract( $args );

                /**
                 *  Is Layout ONE ?
                 *  ---------------
                 */
                if( $layout     ==      absint( '1' ) ){

                    /**
                     *  1. Load Logo
                     *  ------------
                     */
                    self:: have_brand( $args );

                    /**
                     *  2. Have Login Button ?
                     *  ----------------------
                     */
                    self:: have_user_buttons( $args );

                    /**
                     *  3. Have Menu ?
                     *  --------------
                     */
                    self:: weddingdir_menu();
                }

                /**
                 *  Is Layout Two ?
                 *  ---------------
                 */
                if( $layout     ==      absint( '2' ) ){

                    /**
                     *  1. Load Logo
                     *  ------------
                     */
                    self:: have_brand( $args );

                    /**
                     *  2. Have Login Button ?
                     *  ----------------------
                     */
                    self:: have_user_buttons( $args );

                    /**
                     *  3. Have Menu ?
                     *  --------------
                     */
                    self:: weddingdir_menu();
                }
            }
        }

        /**
         *  2. Update the Buttons for login ( Couple + Vendor )
         *  ---------------------------------------------------
         */
        public static function have_user_buttons( $args = [] ){

            /**
             *  Check the condition to load button
             *  ----------------------------------
             */
            if( ! ( is_user_logged_in() && class_exists( 'WeddingDir_Config' ) ) ){

                /**
                 *  Have Args ?
                 *  -----------
                 */
                if( parent:: _is_array( $args ) ){

                    /**
                     *  Merge Default Args
                     *  ------------------
                     */
                    $args   =   wp_parse_args(  

                                    /**
                                     *  1. Have Args
                                     *  ------------
                                     */
                                    $args,

                                    /**
                                     *  2. Default Args
                                     *  ---------------
                                     */
                                    array(

                                        'layout'        =>      absint( '1' )
                                    )
                                );

                    /**
                     *  Extrac Args
                     *  -----------
                     */
                    extract( $args );

                    /**
                     *  Vendor + Couple Registration / Login Model Popup
                     *  ------------------------------------------------
                     */
                    do_action( 'weddingdir_header_button', $args );
                }
            }
        }

        /**
         *  3. Have Menu ?
         *  --------------
         */
        public static function weddingdir_menu(){

            ?>

            <!-- Toggle Button Start -->
            <button class="navbar-toggler x collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <!-- Toggle Button End -->

            <!-- Topbar Request Quote End -->
            <div class="collapse navbar-collapse" id="navbarCollapse" 

                data-hover="dropdown" data-animations="slideInUp slideInUp slideInUp slideInUp">

                <?php

                    /**
                     *  Have Primary Menu ?
                     *  -------------------
                     */
                    if( has_nav_menu( 'primary-menu' ) ){

                            /**
                             *  Load Menu
                             *  ---------
                             */
                            wp_nav_menu( array(

                                'theme_location'    =>  esc_attr( 'primary-menu' ),

                                'depth'             =>  absint( '4' ),

                                'container'         =>  false,

                                'container_class'   =>  false,

                                'container_id'      =>  false,

                                'menu_class'        =>  esc_attr( join( ' ', array_map(

                                                            /**
                                                             *  Sanitize Html Class
                                                             *  -------------------
                                                             */
                                                            esc_attr( 'sanitize_html_class' ), 

                                                            /**
                                                             *  WeddingDir - Custom Class
                                                             *  -------------------------
                                                             */
                                                            array( 

                                                                esc_attr( 'navbar-nav' ), 

                                                                esc_attr( 'ms-auto' )
                                                            )

                                                        ) ) ),

                                'fallback_cb'       =>  esc_attr( 'WP_Bootstrap_Navwalker::fallback' ),

                                'walker'            =>  new     WP_Bootstrap_Navwalker(),
                          ) );
                    }
                    do_action( 'header_right_side' );
                ?>

            </div><!-- / Topbar Request Quote End -->
            <?php
        }

    }   

    /**
     *  WeddingDir - Header Markup Object
     *  ---------------------------------
     */
    WeddingDir_Header:: get_instance();
}