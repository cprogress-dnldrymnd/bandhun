<?php
/**
 *  WeddingDir - Template Helper
 *  ----------------------------
 */
if( ! class_exists( 'WeddingDir_Template_Helper' ) && class_exists( 'WeddingDir' ) ){

    /**
     *  WeddingDir - Template Helper
     *  ----------------------------
     */
    class WeddingDir_Template_Helper extends WeddingDir{

    	/**
    	 *  Var
    	 *  ---
    	 */
        private static $instance;

        /**
         *  Call Self
         *  ---------
         */
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
        	 *  Add Filter
        	 *  ----------
        	 */
        	add_filter( 'weddingdir/pagination', [ $this, 'weddingdir_pagination' ], absint( '10' ), absint( '1' ) );
        }

		/**
		 *   @credit - https://developer.wordpress.org/reference/functions/paginate_links/#user-contributed-notes
		 *   ----------------------------------------------------------------------------------------------------
		 *   WeddingDir - Pagination
		 *   -----------------------
		 */
		public static function weddingdir_pagination( $args = [] ){

			/**
			 *  Have Data ?
			 *  -----------
			 */
			if( parent:: _is_array( $args ) ){

				/**
				 *  Have Args ?
				 *  -----------
				 */
				extract( wp_parse_args( $args, [

					'pagerange'		=>	absint( '2' ),

					'paged'			=>	absint( '1' ),

					'numpages'		=>	absint( '1' ),

				] ) );

				/**
				 *  Total Page
				 *  ----------
				 */
				if(  $numpages >= absint( '2' ) ) {

					global $paged, $wp_query, $post;

					/**
					 *  Big Number
					 *  ----------
					 *  need an unlikely integer
					 *  ------------------------
					 */
					$big = absint( '999999999' );

					/**
					 *  Pagination Query
					 *  ----------------
					 */
					$pages 	= 	paginate_links( array(

						'base'          => 	str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

						'total'         => 	absint( $numpages ),

						'current'       => 	absint( $paged ),

						'mid_size'      => 	absint( $pagerange ),

						'add_args'      => 	false,

						'type'          => 	esc_attr( 'array' ),

						'prev_text'     => 	esc_attr__( '&laquo;', 'weddingdir' ),

						'next_text'     => 	esc_attr__( '&raquo;', 'weddingdir' ),

					) );

					/**
					 *  Is array ?
					 *  ----------
					 */
					if( WeddingDir:: _is_array( $pages ) ) {

						$_get_page_links 	=	'';

						$paged 				= 	( get_query_var('paged') == absint('0') )

											? 	absint( '1' )

											: 	get_query_var( 'paged' );

						/**
						 *  Get One by one page link
						 *  ------------------------
						 */
						foreach ( $pages as $page ){

							$_get_page_links 	.=		sprintf( '<li class="page-item">%1$s</li>', 

															/**
															 *  1. Page
															 *  -------
															 */
															$page
														);
						}

						/**
						 *  Pagination
						 *  ----------
						 */
						return
						
						sprintf(    '<div class="col-12 text-center">

										<div class="theme-pagination mb-xl-0 mb-lg-0">

											<ul class="d-block pagination"> %1$s </ul>

							  			</div>

							  		</div>',

							  		/**
							  		 *  1. Page
							  		 *  -------
							  		 */
							  		$_get_page_links
						);
					}
				}
			}
		}
    }  

    /**
     *  WeddingDir - Body Markup Object
     *  -------------------------------
     */
    WeddingDir_Template_Helper:: get_instance();
}

/**
 *  1. Get Setting Option values
 *  ----------------------------
 */
if( ! function_exists( 'weddingdir_option' ) ){

    function weddingdir_option( $key = '', $default = '' ){

    	/**
    	 *  Get Data From Theme Options
    	 *  ---------------------------
    	 */
        if( function_exists( 'ot_get_option' )  &&  ot_get_option( $key ) != ''  ){

            return 		ot_get_option( $key );
        }

        /**
         *  Default Return
         *  --------------
         */
        else{

        	return  	$default;
        }
    }
}

/**
 *  --------------------
 *  1. wp_body_open hook
 *  --------------------
 *  @credit - https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
 *  -----------------------------------------------------------------------------------------
 */
if( ! function_exists( 'wp_body_open' ) ){

    function wp_body_open( $key = '' ){

      	/**
      	 *  Backwards Compatibility
      	 *  -----------------------
      	 */
		do_action( 'wp_body_open' );
    }
}

?>