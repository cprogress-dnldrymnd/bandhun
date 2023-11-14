<?php
/**
 *  WeddingDir - Blog
 *  -----------------
 */
if( ! class_exists( 'WeddingDir_Blog' ) && class_exists( 'WeddingDir_Blog_Helper' ) ){

	/**
	 *  WeddingDir - Blog
	 *  -----------------
	 */
	class WeddingDir_Blog extends WeddingDir_Blog_Helper {

	    /**
	     * Member Variable
	     * ---------------
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
	     *  Load File
	     *  ---------
	     */
		public function __construct(){

			/**
			 *  Blog post filter
			 *  ----------------
			 */
			add_filter( 'weddingdir/blog/post', [ $this, 'weddingdir_article_markup' ], absint( '10' ), absint( '1' ) );

			/**
			 *  WeddingDir - Blog Hook
			 *  ----------------------
			 */
			add_action( 'weddingdir_article', 		[ $this, 'weddingdir_article_markup' ], absint( '10' ), absint( '1' )  );

			/**
			 *  WeddingDir - Article Not Found
			 *  ------------------------------
			 */
			add_action( 'weddingdir_empty_article', [ $this, 'weddingdir_empty_article_markup' ]  );

			/**
			 *  WeddingDir - Blog Image Size ?
			 *  ------------------------------
			 */
            add_filter( 'weddingdir/image-size', function( $args = [] ){

                return  array_merge( 

                           	$args,

                            array(

                                esc_attr( 'weddingdir_blog_600x470' )  =>

                                [

                                	'name'		=>	esc_attr__( 'WeddingDir - Blog Layout One', 'weddingdir' ),

                                    'width'     =>  absint( '600' ),

                                    'height'    =>  absint( '470' )
                                ],


                                esc_attr( 'weddingdir_blog_360x480' )  =>

                                [
                                	'name'		=>	esc_attr__( 'WeddingDir - Blog Layout Two', 'weddingdir' ),

                                    'width'     =>  absint( '360' ),

                                    'height'    =>  absint( '480' )
                                ]
                            )
                        );
            } );
		}

		/**
		 *  WeddingDir - Article Layout One
		 *  -------------------------------
		 */
		public static function weddingdir_article_markup( $args = [] ){

			/**
			 *  If Have Args ?
			 *  --------------
			 */
			if(  parent:: _is_array( $args )  ){

				/**
				 *  Extract Args with Default Args Merge
				 *  ------------------------------------
				 */
				extract( wp_parse_args( $args, array(

					'layout'					=> 	absint( '1' ),

					'post_id'					=>	absint( '0' ),

					'print'						=>	true,

					'is_elementor_edit_mode'	=>	parent:: is_elementor_edit_mode()

				) ) );

				/**
				 *  Have Post ?
				 *  -----------
				 */
				if( empty( $post_id ) ){

					return;
				}

				$_post_html 	= 	'';

				/**
				 *  Blog Post Layout 1
				 *  ------------------
				 */
				if( $layout ==  absint( '1' ) ){

					/**
					 *  WeddingDir - Blog Post Layout (1)
					 *  ---------------------------------
					 */
					$_post_html .=

					sprintf(    '<!-- Post Blog -->

								<article itemscope itemtype="http://schema.org/CreativeWork" id="post-%1$s" class="%2$s">

					            	<div class="%9$s">

					            		%4$s <!-- Is Sticy ? -->

					                	<div class="row">

					                		%3$s <!-- Load Page Format <div> start -->

					                			%5$s <!-- Have Post Title ? -->

							                	%6$s <!-- Have Blog Post Meta Section -->

												%7$s <!-- Post Content -->

												%8$s <!-- Have Read More -->

											</div> <!-- Post Format </div> -->

					                	</div>

					           		</div>

								</article>

								<!-- Post Blog -->',

								/**
								 *  1. Post ID
								 *  ----------
								 */
								absint( $post_id ),

								/**
								 *  2. Post Class + WeddingDir - Extra Class Merge
								 *  ----------------------------------------------
								 */
								esc_attr(  	implode(  

									/**
									 *  1. White Space
									 *  --------------
									 */
									' ',

									/**
									 *  Post Class
									 *  ----------
									 */
									get_post_class(

										/**
										 *  WeddingDir - Have Extra Class Merge
										 *  -----------------------------------
										 */
										parent:: weddingdir_post_class( $args ),

										/**
										 *  Post ID
										 *  -------
										 */
										absint( $post_id )
									)

								)  	),

								/**
		                		 *  3. WeddingDir - Have Post Format
		                		 *  --------------------------------
		                		 */
			                	( parent:: post_load_condition( absint( $post_id ) ) )

			                	?	$is_elementor_edit_mode || ! is_single()

			                		?	sprintf(   '<div class="%2$s"> 

			                							%1$s 

			                						</div>

			                						<div class="%3$s">',

				                    		/**
				                    		 *  1. Post Formate
				                    		 *  ---------------
				                    		 */
			                        		parent:: post_formate( array(

												'post_id'		=>		absint( $post_id ),

												'image_size'	=>		esc_attr( 'weddingdir_blog_600x470' )

											) ),

											/**
											 *  Page have sidebar ?
											 *  -------------------
											 */
											WeddingDir_Grid_Managment:: have_sidebar()

											?	sanitize_html_class( 'col-md-6' )

											:	esc_attr( join( ' ', array_map( 'sanitize_html_class',  array( 'col-lg-3', 'col-md-6' ) ) ) ),

											/**
											 *  Page have sidebar ?
											 *  -------------------
											 */
											WeddingDir_Grid_Managment:: have_sidebar()

											?	sanitize_html_class( 'col-md-6' )

											:	esc_attr( join( ' ', array_map( 'sanitize_html_class',  array( 'col-lg-9', 'col-md-6' ) ) ) )
				                    	)

				                    :	sprintf( '<div class="col-12"> %1$s',

				                    		/**
				                    		 *  1. Post Formate
				                    		 *  ---------------
				                    		 */
			                        		parent:: post_formate( array(  

												'post_id'		=>		absint( $post_id ),

												'image_size'	=>		esc_attr( 'full' )

											) )
				                    	)

				                :		'<div class="col-12">',

				                /**
				                 *  4. Is Sticky Post ?
				                 *  -------------------
				                 */
				                parent:: is_sticky_post( absint( $post_id ) ),

				                /**
				                 *  5. Have Post Title ?
				                 *  --------------------
				                 */
				                parent:: have_title( absint( $post_id ) ),

				                /**
				                 *  6. Is Singular Page ?
				                 *  ---------------------
				                 */
				                ( 	$is_elementor_edit_mode || 	! is_single()	)

				                ?	sprintf( '<div class="post-meta">%1$s %2$s</div>',

						                /**
						                 *  1. Post Date Format ?
						                 *  ---------------------
						                 */
						                parent:: date_formate( absint( $post_id ) ),

						                /**
						                 *  2. Post Category ?
						                 *  ------------------
						                 */
						                parent:: post_category( absint( $post_id ) )
				            		)

				                :	'',

				                /**
				                 *  7. Post Content ?
				                 *  -----------------
				                 */
				                parent:: article_content( absint( $post_id ) ),

				                /**
				                 *  8. Have Read More Button ?
				                 *  --------------------------
				                 */
				                ( 	$is_elementor_edit_mode || 	! is_single()	)

				                ?	parent:: read_more( $args )

				                :	'',

				                /**
				                 *  9. Have Post Content ?
				                 *  ----------------------
				                 */
				                is_single()

				                ?	parent:: have_content( absint( $post_id ) )

					                ?	sanitize_html_class( 'post-content' )

					                :	''

				                :	sanitize_html_class( 'post-content' )
					);
				}

				/**
				 *  Blog Post Layout 2
				 *  ------------------
				 */
				if( $layout ==  absint( '2' ) ){

					$_post_html .=

					sprintf(   '<!-- Post Blog -->

								<article itemscope itemtype="http://schema.org/CreativeWork" id="post-%1$s" class="%2$s">

									<div class="blog-wrap-home">

									    <div class="post-content">

									        %3$s <!-- Post Blog Image -->

									        <!-- Post Blog Content -->

									        <div class="home-content">
									            
									            %4$s <!-- meta date -->

									            <div class="mt-auto">

									                %5$s

									                %6$s <!-- post title -->

									                %7$s <!-- description -->
									                
									                %8$s <!-- content -->

									            </div>

									        </div>

									        <!-- Post Blog Content -->

									    </div>

									</div>

								</article>

								<!-- Post Blog -->',

								/**
								 *  1. Post ID
								 *  ----------
								 */
								absint( $post_id ),

								/**
								 *  2. Post Class + WeddingDir - Extra Class Merge
								 *  ----------------------------------------------
								 */
								esc_attr(  	implode(  

									/**
									 *  1. White Space
									 *  --------------
									 */
									' ',

									/**
									 *  Post Class
									 *  ----------
									 */
									get_post_class(

										/**
										 *  WeddingDir - Have Extra Class Merge
										 *  -----------------------------------
										 */
										parent:: weddingdir_post_class( $args ),

										/**
										 *  Post ID
										 *  -------
										 */
										absint( $post_id )
									)

								)  	),

								/**
		                		 *  3. WeddingDir - Have Post Format
		                		 *  --------------------------------
		                		 */
			                	( parent:: post_load_condition( absint( $post_id ) ) )

			                	?	( 	$is_elementor_edit_mode || 	! is_single()	)

			                		?	/**
			                    		 *  1. Post Formate
			                    		 *  ---------------
			                    		 */
		                        		parent:: post_formate( array(

											'post_id'		=>		absint( $post_id ),

											'image_size'	=>		esc_attr( 'weddingdir_blog_360x480' )

										) )

				                    :	sprintf(   '<div class="post-img">

			                							%1$s 

			                						</div>',

				                    		/**
				                    		 *  1. Post Formate
				                    		 *  ---------------
				                    		 */
			                        		parent:: post_formate( array(  

												'post_id'		=>		absint( $post_id ),

												'image_size'	=>		esc_attr( 'full' )

											) )
				                    	)

				                :		'',

				                /**
				                 *  4. Is Singular Page ?
				                 *  ---------------------
				                 */
				                ( 	$is_elementor_edit_mode || 	! is_single()	)

				                ?	sprintf( '<div class="post-meta">%1$s</div>',

						                /**
						                 *  1. Post Date Format ?
						                 *  ---------------------
						                 */
						                parent:: date_formate( absint( $post_id ) )
				            		)

				                :	'',

				                /**
				                 *  5. Post Category ?
				                 *  ------------------
				                 */
				                parent:: post_category( absint( $post_id ) ),

				                /**
				                 *  6. Have Post Title ?
				                 *  --------------------
				                 */
				                parent:: have_title( absint( $post_id ) ),

				                /**
				                 *  7. Post Content ?
				                 *  -----------------
				                 */
				                parent:: expert_content( absint( $post_id ), absint( '10' ) ),

				                /**
				                 *  8. Have Read More Button ?
				                 *  --------------------------
				                 */
				                ( 	$is_elementor_edit_mode || 	! is_single()	)

				                ?	parent:: read_more( $args )

				                :	''
					);
				}

				/**
				 *  Print ?
				 *  -------
				 */
				if( $print ){

					print  apply_filters( 'weddingdir_blog_html', $_post_html );

				}else{

					return $_post_html;
				}
			}
		}
	}

	/**
	 *  WeddingDir - Blog Post Helper
	 *  -----------------------------
	 */
	WeddingDir_Blog::get_instance();
}