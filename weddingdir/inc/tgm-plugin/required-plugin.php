<?php
/**
 *  WeddingDir - Recommended Plugins
 *  --------------------------------
 */
if( ! class_exists( 'WeddingDir_Recommended_Plugins' ) && class_exists( 'WeddingDir' ) ){

	/**
	 *  WeddingDir - Recommended Plugins
	 *  --------------------------------
	 */
    class WeddingDir_Recommended_Plugins extends WeddingDir{

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
        	 *  1. WordPress Responsibilitie to install plugins
        	 *  -----------------------------------------------
        	 */
        	add_filter( 'weddingdir_recommended_plugins', [ $this, 'wordpress_plugin' ] );

        	/**
        	 *  2. Envato : Purchase Product Install on screen plugin
        	 *  -----------------------------------------------------
        	 */
        	add_filter( 'weddingdir_recommended_plugins', [ $this, 'envato_plugin' ] );

        	/**
        	 *  3. Envato : Purchase Product Install on screen plugin
        	 *  -----------------------------------------------------
        	 */
        	add_filter( 'weddingdir_recommended_plugins', [ $this, 'github_plugin' ] );

			/**
			 *  3. WeddingDir - Theme ( RECOMMENDED ) to install this plugins
			 *  -------------------------------------------------------------
			 */
        	add_action( 'tgmpa_register', [ $this, 'plugins_installation' ] );

        	/**
        	 *  4. WeddingDir - Basic Settings Plugin
        	 *  -------------------------------------
        	 */
        	add_filter( 'weddingdir_recommended_plugins', [ $this, 'weddingdir_plugins' ] );

        	/**
        	 *  5. WeddingDir - Premium Plugins
        	 *  -------------------------------
        	 */
        	add_filter( 'weddingdir_recommended_plugins', [ $this, 'weddingdir_premium_plugins' ] );
        }

    	/**
    	 *  1. WordPress Responsibilitie to install plugins
    	 *  -----------------------------------------------
    	 */
        public static function wordpress_plugin( $plugins = [] ){

			$add_new_plugins 	= 	array(

				/**
				 *  ---------------------------------
				 *  Nextend Social Login and Register
				 *  ---------------------------------
				 *  @author : By Nextendweb
				 *  -----------------------
				 *  @link - https://wordpress.org/plugins/nextend-facebook-connect/
				 *  ---------------------------------------------------------------
				 */
				array(
					
				    'name'      => 	esc_attr( 'Nextend Social Login and Register' ),

				    'slug'      => 	sanitize_title( 'nextend-facebook-connect' ),

				    'required'  => 	true,
				),

				/**
				 *  ----------------------
				 *  Advanced Custom Fields
				 *  ----------------------
				 *  @author : By Elliot Condon
				 *  --------------------------
				 *  @link - https://wordpress.org/plugins/advanced-custom-fields/
				 *  -------------------------------------------------------------
				 */
				array(
					
				    'name'      => 	esc_attr( 'Advanced Custom Fields' ),

				    'slug'      => 	sanitize_title( 'Advanced Custom Fields' ),

				    'required'  => 	true,
				),

			    /**
				 *  --------------
				 *  Contact Form 7
				 *  --------------
				 *  @author : By Takayuki Miyoshi
				 *  -----------------------------
				 *  @link - https://wordpress.org/plugins/contact-form-7/
				 *  -----------------------------------------------------
				 */
				array(

				    'name'      => 	esc_attr( 'Contact Form 7' ),

				    'slug'      => 	sanitize_title( 'Contact Form 7' ),

				    'required'  => 	true,
				),

			    /**
				 *  ------------------------------
				 *  MC4WP: Mailchimp for WordPress
				 *  ------------------------------
				 *  @author : By ibericode
				 *  -----------------------------
				 *  @link - https://wordpress.org/plugins/mailchimp-for-wp/
				 *  -------------------------------------------------------
				 */
				array(

				    'name'      => 	esc_attr( 'Mailchimp for wp' ),

				    'slug'      => 	sanitize_title( 'Mailchimp for wp' ),

				    'required'  => 	true,
				),

			    /**
				 *  -------------------------
				 *  Elementor Website Builder
				 *  -------------------------
				 *  @author : By Elementor.com
				 *  --------------------------
				 *  @link - https://wordpress.org/plugins/elementor/
				 *  ------------------------------------------------
				 */
				array(
				    'name'      => 	esc_attr( 'Elementor' ),

				    'slug'      => 	sanitize_title( 'Elementor' ),

				    'required'  => 	true,        	
				),

				/**
				 *  -----------------------------------------------------
				 *  WordPress Importer : Import any XML File to WordPress
				 *  -----------------------------------------------------
				 *  @author : By Xylus Themes
				 *  -------------------------
				 *  @link - https://wordpress.org/plugins/wp-smart-import/
				 *  ------------------------------------------------------
				 */
				array(

				    'name'      => 	esc_attr( 'WordPress Importer' ),

				    'slug'      => 	sanitize_title( 'WordPress Importer' ),

				    'required'  => 	true,
				),

				/**
				 *  ---------------
				 *  Classic Widgets
				 *  ---------------
				 *  @author : By WordPress Contributors
				 *  -----------------------------------
				 *  @link - https://wordpress.org/plugins/classic-widgets/
				 *  ------------------------------------------------------
				 */
				array(

				    'name'      => 	esc_attr( 'Classic Widgets' ),

				    'slug'      => 	sanitize_title( 'Classic Widgets' ),

				    'required'  => 	true,
				),

				/**
				 *  --------------------------
				 *  Widget Importer & Exporter
				 *  --------------------------
				 *  @author : By ChurchThemes.com
				 *  -----------------------------
				 *  @link - https://wordpress.org/plugins/widget-importer-exporter/
				 *  ---------------------------------------------------------------
				 */
				array(

				    'name'      => 	esc_attr( 'Widget Importer & Exporter' ),

				    'slug'      => 	sanitize_title( 'Widget Importer & Exporter' ),

				    'required'  => 	true,
				),

				/**
				 *  -----------
				 *  WooCommerce
				 *  -----------
				 *  @author : By Automattic
				 *  -----------------------
				 *  @link - https://wordpress.org/plugins/woocommerce/
				 *  --------------------------------------------------
				 */
				array(

				    'name'      => 	esc_attr( 'WooCommerce' ),

				    'slug'      => 	sanitize_title( 'WooCommerce' ),

				    'required'  => 	true,
				),

				/**
				 *  ----------------
				 *  Breadcrumb NavXT
				 *  ----------------
				 *  @author : By John Havlik
				 *  ------------------------
				 *  @link - https://wordpress.org/plugins/breadcrumb-navxt/
				 *  -------------------------------------------------------
				 */
				array(

				    'name'      => 	esc_attr( 'Breadcrumb NavXT' ),

				    'slug'      => 	sanitize_title( 'Breadcrumb NavXT' ),

				    'required'  => 	true,
				)
			);

			return  	array_merge( $plugins, $add_new_plugins );
        }

    	/**
    	 *  2. Envato : Purchase Product Install on screen plugin
    	 *  -----------------------------------------------------
    	 */
        public static function envato_plugin( $plugins = [] ){

			$add_new_plugins 	= 	array(

				/**
				 *  -------------------------------------------------------------------------------------------------
				 *  Envato Market Plugin ( They help to install your theme / plugin - you purchase on this platform )
				 *  -------------------------------------------------------------------------------------------------
				 *  @author : Envato Team
				 *  ---------------------
				 *  @link - https://envato.com/market-plugin/
				 *  -----------------------------------------
				 */
				array(

				    'name'      	=> 	esc_attr( 'Envato Market' ),

				    'slug'      	=> 	sanitize_title( 'Envato Market' ),

					'source'       	=> 	esc_url( 'envato.github.io/wp-envato-market/dist/envato-market.zip' ),

					'external_url' 	=>	esc_url( 'envato.github.io/wp-envato-market/dist/envato-market.zip' ),

					'required'     	=> 	true,
				)
			);

			return  	array_merge( $plugins, $add_new_plugins );
        }

    	/**
    	 *  3. Github : ACF Repetable Fields Support Plugin
    	 *  -----------------------------------------------
    	 */
        public static function github_plugin( $plugins = [] ){

			$add_new_plugins 	= 	array(

				/**
				 *  --------------------
				 *  ACF Repetable Plugin
				 *  --------------------
				 *  @author : remcotolsma
				 *  ---------------------
				 *  @link - https://github.com/wp-premium/advanced-custom-fields-pro
				 *  ----------------------------------------------------------------
				 */
				array(

				    'name'      	=> 	esc_attr( 'Advanced Custom Fields Pro' ),

				    'slug'      	=> 	sanitize_title( 'Advanced Custom Fields Pro' ),

					'source'       	=> 	esc_url( 'https://github.com/wp-premium/advanced-custom-fields-pro/archive/refs/heads/master.zip' ),

					'external_url' 	=>	esc_url( 'https://github.com/wp-premium/advanced-custom-fields-pro/archive/refs/heads/master.zip' ),

					'required'     	=> 	true,
				)
			);

			return  	array_merge( $plugins, $add_new_plugins );
        }

		/**
		 *  4. WeddingDir - Theme ( RECOMMENDED ) to install this plugins
		 *  -------------------------------------------------------------
		 */
		public static function plugins_installation() {

			/**
			 *  TGMPA function exists ?
			 *  -----------------------
			 */
			if( function_exists( 'tgmpa' ) ){

				/**
				 * 	--------------------------------------------------------
				 *  1. Install WeddingDir - Required ( RECOMMENDED ) Plugins
				 *  --------------------------------------------------------
				 */
				tgmpa(

					/**
					 *  1. WeddingDir - Recommended Plugins
					 *  -----------------------------------
					 */
					apply_filters( 'weddingdir_recommended_plugins', [] ),

					/**
					 *  2. TGMPA - Core configuration
					 *  -----------------------------
					 */
					array(

						/**
						 *  1. Unique ID for hashing notices for multiple instances of TGMPA
						 *  ----------------------------------------------------------------
						 */
						'id'           => 	esc_attr( 'weddingdir' ),

						/**
						 *  2. Default absolute path to bundled plugins
						 *  -------------------------------------------
						 */
						'default_path' => 	'',

						/**
						 *  3. Menu slug
						 *  ------------
						 */
						'menu'         => 	esc_attr( 'tgmpa-install-plugins' ),

						/**
						 *  4. Show admin notices or not
						 *  ----------------------------
						 */
						'has_notices'  => 	true,

						/**
						 *  5. If false, a user cannot dismiss the nag message
						 *  --------------------------------------------------
						 */
						'dismissable'  => 	true,

						/**
						 *  6. If 'dismissable' is false, this message will be output at top of nag
						 *  -----------------------------------------------------------------------
						 */
						'dismiss_msg'  => '',

						/**
						 *  7. Automatically activate plugins after installation or not
						 *  -----------------------------------------------------------
						 */
						'is_automatic' => 	false,

						/**
						 *  8. Message to output right before the plugins table
						 *  ---------------------------------------------------
						 */
						'message'      => 	'',
					)
				);
			}
		}

    	/**
    	 *  5. WeddingDir - Basic Settings Plugin
    	 *  -------------------------------------
    	 */
        public static function weddingdir_plugins( $plugins = [] ){

			/**
			 *  Domain
			 *  ------
			 */
			$weddingdir_domain 	= 	esc_url( 'weddingdir.net/required-plugins/' );

			/**
			 *  WeddingDir - Custom Plugin
			 *  --------------------------
			 */
			$add_new_plugins 	= 	array(

				/**
				 *  -------------------------------------
				 *  OptionTree ( Theme Option Framework )
				 *  -------------------------------------
				 *  @author : By - By Derek Herman
				 *  ------------------------------
				 *  @link - https://wordpress.org/plugins/option-tree/
				 *  --------------------------------------------------
				 */
				array(

				    'name'      	=> 	esc_attr( 'Option Tree' ),

				    'slug'      	=> 	sanitize_title( 'Option Tree' ),

					'source'       	=> 	esc_url( 'wporganic.com/required-plugins/option-tree.zip' ),

					'required'     	=> 	true,

					'external_url' 	=> 	esc_url( 'wporganic.com/required-plugins/option-tree.zip' ),
				),

				/**
				 *  --------------------------------------
				 *  WeddingDir Core Configuration - Plugin
				 *  --------------------------------------
				 *  @author : By - Hitesh Mahavar ( wporganic )
				 *  -------------------------------------------
				 *  @contact : https://themeforest.net/user/wp-organic#contact
				 *  ----------------------------------------------------------
				 *  @link - https://weddingdir.net/
				 *  -------------------------------
				 */
				array(

				    'name'      	=> 	esc_attr( 'WeddingDir' ),

				    'slug'      	=> 	sanitize_title( 'WeddingDir' ),

					'source'       	=> 	esc_url( $weddingdir_domain  	.	'weddingdir/weddingdir.zip' ),

					'required'     	=> 	true,

					'external_url' 	=> 	esc_url( $weddingdir_domain 	. 	'weddingdir/weddingdir.zip' ),
				)
			);

        	/**
        	 *  Return : Plugins
        	 *  ----------------
        	 */
			return  	array_merge( $plugins, $add_new_plugins );
        }

    	/**
    	 *  6. WeddingDir - Premium Plugins
    	 *  -------------------------------
    	 */
        public static function weddingdir_premium_plugins( $plugins = [] ){

			/**
			 *  Purchase Code to Get Plugins
			 *  ----------------------------
			 */
			$add_new_plugins 	=	[];

			/**
			 *  Make sure have data ?
			 *  ---------------------
			 */
			if( parent:: _have_data( get_option( 'WeddingDir_Theme_Plugins' ) ) ){

				/**
				 *  Get list of plugins
				 *  -------------------
				 */
		        foreach( json_decode( get_option( 'WeddingDir_Theme_Plugins' ), true ) as $key => $value ){

		        	$add_new_plugins[] 	=

					array(

					    'name'      	=> 	esc_attr( ucwords(  str_replace( '-', ' ', $key ) ) ),

					    'slug'      	=> 	sanitize_title( $key ),

						'source'       	=> 	esc_url( $value ),

						'required'     	=> 	true,

						'external_url' 	=> 	esc_url( $value ),
					);
		        }
			}

        	/**
        	 *  Return : Plugins
        	 *  ----------------
        	 */
			return  	array_merge( $plugins, $add_new_plugins );
        }
    }

    /**
     *  License verificaiton object call
     *  --------------------------------
     */
    WeddingDir_Recommended_Plugins::get_instance();
}