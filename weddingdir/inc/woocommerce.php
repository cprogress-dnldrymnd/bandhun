<?php
/**
 *  WeddingDir - WooCommerce
 *  ------------------------
 */
if( ! class_exists( 'WeddingDir_WooCommerce' ) && class_exists( 'WeddingDir' ) ){

    /**
     *  WeddingDir - WooCommerce
     *  ------------------------
     */
    class WeddingDir_WooCommerce extends WeddingDir {

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
             *  1. WooCommerce Support Filter
             *  -----------------------------
             */
            add_action( 'after_setup_theme', [ $this, 'woocommerce_support' ] );

            /**
             *  2. Load WooCommerce - Style + Script Here
             *  ----------------------------------------
             */
            add_action( 'wp_enqueue_scripts', [ $this, 'woocommerce_enqueue' ] );

            /**
             *  3. WooCommerce - Shop Title Removed
             *  -----------------------------------
             */
            add_filter( 'woocommerce_show_page_title', '__return_false' );

            /**
             *  4. Product Singular Page - Removed Title
             *  ----------------------------------------
             */
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', absint( '5' ) );

            /**
             *  5. Before Shop Hook Start
             *  -------------------------
             */
            add_action( 'woocommerce_before_shop_loop_item', function(){

                ?><div class="fashion-gallery"><?php

            }, absint( '5' ) );

            /**
             *  6. Before Shop Hook End
             *  -----------------------
             */
            add_action( 'woocommerce_after_shop_loop_item', function(){

                ?></div><?php

            }, absint( '20' ) );

            /**
             *  7. Before Shop Title Hook Start
             *  -------------------------------
             */
            add_action( 'woocommerce_before_shop_loop_item_title', function(){

                ?><div class="img"><?php

            }, absint( '5' ) );
            
            /**
             *  8. Before Shop Title Hook End
             *  -----------------------------
             */
            add_action( 'woocommerce_before_shop_loop_item_title', function(){

                ?></div><?php

            }, absint( '20' ) );

            /**
             *  9. Removed Actions
             *  ------------------
             */
            remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', absint( '10' ) );

            /**
             *  10. Add Product Title Hook Under Another DIV
             *  --------------------------------------------
             */
            add_action( 'woocommerce_after_shop_loop_item_title', function(){

                ?><div class="content-wrap"><div class="content"><?php

                do_action( 'woocommerce_shop_loop_item_title' );

            }, absint( '2' ) );

            /**
             *  11. Product Title Function Call with another Hook Action
             *  --------------------------------------------------------
             */
            add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_title', absint( '4' ) );

            /**
             *  12. Product Singular Page Title Removed
             *  ---------------------------------------
             */
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', absint( '20' ) );

            /**
             *  13. After Shop Look END
             *  -----------------------
             */
            add_action( 'woocommerce_after_shop_loop_item', function(){

                ?></div></div><?php

            }, absint( '20' ) );

            /**
             *  14. Product Column Grid
             *  -----------------------
             */
            add_filter( 'loop_shop_columns', function(){ return absint( '3' ); } );
        }

        /**
         *  1. WooCommerce Support Filter
         *  -----------------------------
         */
        public static function woocommerce_support(){

            /**
             *  WeddingDir Support : WooCommerce
             *  --------------------------------
             */
        	add_theme_support( 'woocommerce' );

            /**
             *  WeddingDir Support LightBox Popup Gallery
             *  -----------------------------------------
             */
        	add_theme_support( 'wc-product-gallery-lightbox' );
        }

        /**
         *  2. Load WooCommerce - Style + Script Here
         *  ----------------------------------------
         */
        public static function woocommerce_enqueue(){

            if(  ! parent:: is_dashboard() && ! is_singular( 'website' ) ){

                /**
                 *  WeddingDir - style.css Loaded
                 *  -----------------------------
                 */
                wp_enqueue_style(

                      /**
                       *  File Name
                       *  ---------
                       */
                      esc_attr(  'weddingdir-woocommerce'  ),

                      /**
                       *  File Path
                       *  ---------
                       */
                      esc_url(    WEDDINGDIR_THEME_DIR . '/assets/css/woocommerce-style.css'   ), 

                      /**
                       *  Load WeddingDir - Style After Bootsrap Library
                       *  ----------------------------------------------
                       */
                      array( 'weddingdir-custom-theme-style' ),

                      /**
                       *  WeddingDir - Theme Version
                       *  --------------------------
                       */
                      esc_attr(     WEDDINGDIR_THEME_VERSION    ), 

                      /**
                       *  Load Media in All
                       *  -----------------
                       */
                      esc_attr(  'all'  )
                );
            }
        }
    }

    /**
     *  WeddingDir - Script Object Call
     *  -------------------------------
     */
    WeddingDir_WooCommerce::get_instance();
}