<?php
/**
 *  WeddingDir - Footer Action / Hooks
 *  ----------------------------------
 */
if( ! class_exists( 'WeddingDir_Footer' ) && class_exists( 'WeddingDir' ) ){

    /**
     *  WeddingDir - Footer Action / Hooks
     *  ----------------------------------
     */
    class WeddingDir_Footer extends WeddingDir {

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
             *  1. Footer Markup
             *  ----------------
             */
            add_action( 'weddingdir/footer',         [$this, 'weddingdir_footer_markup'         ],  absint( '10' ) );

            /**
             *  2. Back To Top
             *  --------------
             */
            add_action( 'weddingdir/footer',         [$this, 'weddingdir_footer_back_to_top'    ],  absint( '20' ) );

            /**
             *  3. Footer Section Markup
             *  ------------------------
             */
            add_action( 'weddingdir_footer_content', [$this, 'weddingdir_footer_content_markup' ] );
        }

        /**
         *  Footer Markup
         *  -------------
         */
        public static function weddingdir_footer_markup(){

            if( self:: page_have_footer() == esc_attr( 'on' ) && class_exists('OT_Loader') ){

                if( self:: weddingdir_footer_widgets() ){

                    ?>

                    <footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" class="footer">

                        <?php do_action( 'weddingdir_footer_content_top' ); ?>

                        <?php do_action( 'weddingdir_footer_content' ); ?>

                        <?php do_action( 'weddingdir_footer_content_bottom' ); ?>

                    </footer><!-- #colophon -->

                    <?php
                }
            }

            if( self:: have_tiny_footer() == esc_attr( 'on' ) && class_exists('OT_Loader') ){

                /**
                 *  Have Tiny Footer
                 *  ----------------
                 */
                self:: load_tiny_footer();
            }
        }

        /**
         *  Back To Top Markup
         *  ------------------
         */
        public static function weddingdir_footer_back_to_top(){

            ?>

                <a id="back-to-top" href="javascript:" class="btn btn-outline-primary back-to-top">

                    <i class="fa fa-arrow-up"></i>

                </a>

            <?php
        }

        /**
         *  Have Tiny Footer ?
         *  ------------------
         */
        public static function have_tiny_footer(){

            /**
             *  Have Copy Right Text in Setting Optin ?
             *  ---------------------------------------
             */
            $_have_copyright_text       =   weddingdir_option( 'tiny_footer_one_copyright_text' );

            /**
             *  Have Tiny Footer Menu ?
             *  -----------------------
             */
            $_have_tiny_footer_menu     =   has_nav_menu( 'tiny-footer-menu' );

            /**
             *  Have data ?
             *  -----------
             */
            return  ( parent:: _have_data( $_have_copyright_text ) || has_nav_menu( 'tiny-footer-menu' ) );
        }

        public static function load_tiny_footer(){

            /**
             *  By Default Tiny Footer Switch is *ON*
             *  -------------------------------------
             */
            $tiny_footer_option =  esc_attr( 'on' );

            /**
             *  If Option Tree Plugin is Activated ?
             *  ------------------------------------
             */
            if( class_exists( 'OT_Loader' ) && ! ( is_404() || is_tax() || is_category() || is_archive() ) ){

                /**
                 *  Have Tiny Footer Switch ON ? ( Setting Option )
                 *  -----------------------------------------------
                 */
                $_have_footer     =   esc_attr(   get_post_meta(

                                                /**
                                                 *  Page ID
                                                 *  -------
                                                 */
                                                absint( parent:: weddingdir_page_id() ),

                                                /**
                                                 *  Meta Key
                                                 *  --------
                                                 */
                                                sanitize_key( 'page_tiny_footer_on_off' ),

                                                /**
                                                 *  TRUE
                                                 *  ----
                                                 */
                                                true 

                                            )   );

                if( $_have_footer == esc_attr( 'off' ) ){

                    $tiny_footer_option =  esc_attr( 'off' );
                }

            }else{

                $tiny_footer_option =  esc_attr( 'on' );
            }

            /**
             *  Check the condition
             *  -------------------
             */
            if( $tiny_footer_option !== esc_attr( 'off' ) && self:: have_tiny_footer() ){

                /**
                 *  Show Copyright content
                 *  ----------------------
                 */
                printf('<div class="copyrights">

                            <div class="container">

                                <div class="row justify-content-between"> %1$s %2$s </div>

                            </div>

                        </div>',

                        /**
                         *  WeddingDir Copyrignt Content here
                         *  ---------------------------------
                         */
                        ( parent:: _have_data( weddingdir_option( 'tiny_footer_one_copyright_text' ) ) ) 

                        ?   sprintf( '<div class="col-md-auto col-12">%1$s</div>', 

                                /**
                                 *  1. Copyright Content
                                 *  --------------------
                                 */
                                esc_attr( weddingdir_option( 'tiny_footer_one_copyright_text' ) )
                            )

                        :   '',

                        /**
                         *  Footer Navigation
                         *  -----------------
                         */
                        (   has_nav_menu( 'tiny-footer-menu' ) )

                        ?   sprintf( '<div class="col-md-auto col-12 copyrights-link ml-md-auto">%1$s</div>',

                                wp_nav_menu( array(

                                    'theme_location'    =>  esc_attr( 'tiny-footer-menu' ),

                                    'depth'             =>  absint( '1' ),

                                    'container'         =>  false,

                                    'container_class'   =>  false,

                                    'container_id'      =>  false,

                                    'echo'              =>  false,
                                ) )
                            )

                        :   ''
                );
            }
        }

        /**
         *  Page Have Footer Option ?
         *  -------------------------
         */
        public static function page_have_footer(){

            global $post, $wp_query;

            /**
             *  If plugin activate then get option in page so by default footer switch is *ON*
             *  ------------------------------------------------------------------------------
             */
            if( class_exists( 'OT_Loader' )  && ! ( is_404() || is_tax() || is_category() || is_archive() )  ){

                /**
                 *  Have Footer Switch is ON / OFF ?
                 *  --------------------------------
                 */
                $_have_footer   =       esc_attr(   get_post_meta(

                                            /**
                                             *  1. Page Object ID
                                             *  -----------------
                                             */
                                            absint( parent:: weddingdir_page_id() ),

                                            /**
                                             *  2. Meta Key
                                             *  -----------
                                             */
                                            sanitize_key( 'page_footer_on_off' ),

                                            /**
                                             *  3. TRUE
                                             *  -------
                                             */
                                            true 

                                        )   );


                if( $_have_footer == esc_attr( 'off' ) ){

                    return  esc_attr( 'off' );

                }else{

                    return  esc_attr( 'on' );
                }
            }

            /**
             *  By Default Footer is Show ( ON )
             *  --------------------------------
             */
            return  esc_attr( 'on' );
        }

        /**
         *  Check have any activate footer widget ?
         *  ---------------------------------------
         */
        public static function weddingdir_footer_widgets(){

            if( is_active_sidebar( WEDDINGDIR_FOOTER_WIDGET . '-1' ) ||
                is_active_sidebar( WEDDINGDIR_FOOTER_WIDGET . '-2' ) ||
                is_active_sidebar( WEDDINGDIR_FOOTER_WIDGET . '-3' ) ||
                is_active_sidebar( WEDDINGDIR_FOOTER_WIDGET . '-4' ) ||
                is_active_sidebar( WEDDINGDIR_FOOTER_WIDGET . '-5' ) ||
                is_active_sidebar( WEDDINGDIR_FOOTER_WIDGET . '-6' ) ){

                return      true;

            }else{

                return      false;
            }
        }

        /**
         *  Footer Section Markup
         *  ---------------------
         */
        public static function weddingdir_footer_content_markup(){

            /**
             *  Have Footer Active Sidebar
             *  --------------------------
             */
            if(  self:: weddingdir_footer_widgets()  ){

                /**
                 *  1. Footer Class condition
                 *  -------------------------
                 */
                if(   parent:: is_dashboard()  ){

                    $_footer_class  =   sanitize_html_class( 'footer-inner' );

                }else{

                    $_footer_class  =   sanitize_html_class( 'footer-section' );
                }
                
                /**
                 *  Before Start the Footer
                 *  -----------------------
                 */
                printf( '<div class="%1$s"><div class="container">',

                        /**
                         *  1. Footer Class condition
                         *  -------------------------
                         */
                        sanitize_html_class( $_footer_class )
                );

                    /**
                     *  Load the Widgets
                     *  ----------------
                     */
                    self:: weddingdir_footer_widget_markup();

                /**
                 *  3. Close the Footer
                 *  -------------------
                 */
                ?></div></div><?php
            }
        }

        /**
         *  Load Widget in Footer
         *  ---------------------
         */
        public static function widget_load( $grid = '4' , $widget_id = '' ){

            if( $grid == absint( '12' ) ){

                print '<div class="col-lg-12 col-md-12 col-12 weddingdir-footer-block">';

            }elseif( $grid == absint( '6' ) ){

                print '<div class="col-lg-6 col-md-6 col-12 weddingdir-footer-block">';

            }elseif( $grid == absint( '4' ) ){

                print '<div class="col-lg-4 col-md-4 col-sm-6 col-12 weddingdir-footer-block">';

            }elseif( $grid == absint( '3' ) ){

                print '<div class="col-xl-3 col-lg-4 col-md-6 col-12 weddingdir-footer-block">';

            }elseif( $grid == absint( '2' ) ){

                print '<div class="col-lg-2 col-md-2 col-sm-6 col-12 weddingdir-footer-block">';
            }
            
            /**
             *  Load Widget
             *  -----------
             */
            if( parent:: _have_data( $widget_id ) ){

                self:: load_widget( $widget_id );
            }

            print '</div>';
        }

        /**
         *  Widget ID load
         *  --------------
         */
        public static function load_widget( $widget_id = '' ){

            /**
             *  Load Sidebar Widget
             *  -------------------
             */
            if ( is_active_sidebar( WEDDINGDIR_FOOTER_WIDGET . $widget_id ) ) {

                dynamic_sidebar( WEDDINGDIR_FOOTER_WIDGET . $widget_id );
            }
        }

        /**
         *  Footer Widget Have Grid ?
         *  -------------------------
         */
        public static function weddingdir_footer_widget_markup(){

            /**
             *  Have Footer Column
             *  ------------------
             */
            $_have_footer_column    =   esc_attr( weddingdir_option( 'footer_column' ) );

            /**
             *  Is One Column ?
             *  ---------------
             */
            if(  $_have_footer_column == esc_attr( 'column_1' )  ){

                ?><div class="row"><?php

                    self:: widget_load(  absint( '12' ), absint( '1' )  );

                ?></div><?php
            }

            /**
             *  Is Two Column ?
             *  ---------------
             */
            if( $_have_footer_column == esc_attr( 'column_2' ) ){

                ?><div class="row"><?php

                    foreach( array_map( 'absint', range( absint( '1' ), absint( '2' ) ) ) as $args ){

                        self:: widget_load(  absint( '6' ), absint( $args )  );
                    }

                ?></div><?php
            }

            /**
             *  Is Three Column ?
             *  -----------------
             */
            if( $_have_footer_column == esc_attr( 'column_3' ) ){

                ?><div class="row"><?php

                    foreach(array_map( 'absint', range( absint( '1' ), absint( '3' ) ) ) as $args ){

                        self:: widget_load(  absint( '4' ), absint( $args )  );
                    }

                ?></div><?php
            }

            /**
             *  Is Four Column ?
             *  ----------------
             */
            if( $_have_footer_column == esc_attr( 'column_4' ) ){

                ?><div class="row"><?php

                    foreach( array_map( 'absint', range( absint( '1' ), absint( '4' ) ) ) as $args ){

                        self:: widget_load(  absint( '3' ), absint( $args )  );
                    }

                ?></div><?php
            }

            /**
             *  Is ( 6 / 3 / 3 ) Grid
             *  ---------------------
             */
            if( $_have_footer_column == esc_attr( 'column_5' ) ){

                ?><div class="row"><?php

                    self:: widget_load(  absint( '6' ), absint( '1' )  );

                    self:: widget_load(  absint( '4' ), absint( '2' )  );

                    self:: widget_load(  absint( '4' ), absint( '3' )  );

                ?></div><?php
            }

            /**
             *  Is ( 3 / 3 / 6 ) Grid
             *  ---------------------
             */
            if( $_have_footer_column == esc_attr( 'column_6' ) ){

                ?><div class="row"><?php

                    self:: widget_load(  absint( '4' ), absint( '1' )  );

                    self:: widget_load(  absint( '4' ), absint( '2' )  );

                    self:: widget_load(  absint( '6' ), absint( '3' )  );

                ?></div><?php
            }

            /**
             *  WeddingDir - Custom Grid Here
             *  -----------------------------
             */
            if( $_have_footer_column == esc_attr( 'column_7' ) ){

                ?>
                <div class="row g-0">

                    <!-- col-lg-7 -->
                    <div class="col-lg-7">

                        <div class="row">

                            <div class="col-md-5 weddingdir-footer-block">

                                <?php self:: load_widget( absint( '1' ) );  ?>

                            </div>
                        
                            <div class="col-md weddingdir-footer-block">

                                <?php self:: load_widget( absint( '2' ) );  ?>

                            </div>

                            <div class="col-md weddingdir-footer-block">

                                <?php self:: load_widget( absint( '3' ) );  ?>

                            </div>

                        </div>

                    </div>
                    <!--  / col-lg-7 -->

                    <!-- col-lg-5 -->
                    <div class="col-lg-5 mr-top-footer">

                        <div class="row">

                            <div class="col-md-6 col-12 weddingdir-footer-block">

                                <?php self:: load_widget( absint( '4' ) );  ?>

                            </div>

                            <div class="col-md-6 col-12 weddingdir-footer-block">

                                <?php self:: load_widget( absint( '5' ) );  ?>

                            </div>

                        </div>

                    </div>
                    <!-- col-lg-5 -->

                </div>
                <?php
            }
        }
    }   

    /**
     *  WeddingDir - Footer Object Call
     *  -------------------------------
     */
    WeddingDir_Footer:: get_instance();
}