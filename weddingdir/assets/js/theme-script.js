(function ($) {

    "use strict";

    /**
     *  WeddingDir - Theme Requred Script
     *  ---------------------------------
     */
    var WeddingDir_Theme_Setup = {

        /**
         *  2. Blog Post ( Gallery ) Carousel
         *  ---------------------------------
         */
        blog_post_type_slider : function(){

            /**
             *  Have Class on Document ?
             *  ------------------------
             */
            if( $('.weddingdir-post-slider').length ){

                /**
                 *  Each Class To Load Script
                 *  -------------------------
                 */
                $('.weddingdir-post-slider').map( function(){

                    /**
                     *  Create Owl Carousel Slider
                     *  --------------------------
                     *  Owl Carousel v2.3.4
                     *  --------------------
                     *  Copyright 2013-2018 David Deutsch
                     *  ---------------------------------
                     *  Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
                     *  -----------------------------------------------------------------------------------------------
                     *  @credit - https://owlcarousel2.github.io/OwlCarousel2/
                     *  ------------------------------------------------------
                     */
                    $( this ).owlCarousel({
        
                        loop                :   true,

                        stagePadding        :   0,

                        margin              :   30,

                        slideBy             :   1,

                        items               :   1,

                        autoplay            :   false,

                        autoplayTimeout     :   10000,

                        smartSpeed          :   1000,

                        nav                 :   true,

                        dots                :   true,

                        navText             :   [
                                                    /**
                                                     *   1. Left Side Text
                                                     *   -----------------
                                                     */
                                                    '<i class="fa fa-angle-left"></i>',

                                                    /**
                                                     *   2. Right Side Text
                                                     *   ------------------
                                                     */
                                                    '<i class="fa fa-angle-right"></i>'
                                                ]
                    });

                } );
            }
        },

        /**
         *  3. Sticky Header Version One
         *  ----------------------------
         */
        sticky_header_version_one: function() {

            /**
             *  Document Have Class ?
             *  ---------------------
             */
            if(  $('.header-version-one').length ){

                var admin_bar   =   '0';

                if( $( '#wpadminbar' ).length && $( window ).width() >= 600 ){

                    admin_bar   =   $( '#wpadminbar' ).height();
                }

                /**
                 *  If Document Scroll then load script
                 *  -----------------------------------
                 */
                if( $( 'html' ).height() >= 1100 ){

                    $( window ).scroll( function() {

                        if( $( '#masthead .top-bar-stripe' ).length ){

                            var i   =   $(this).scrollTop() > $( '#masthead .top-bar-stripe' ).height(),

                                j   =   $( window ).width() >= 991.99;

                            if( i && j ) {

                                $('.header-version-one').addClass('fixed-top fixed').attr( 'style', 'top:'+admin_bar+'px;' );

                                $( 'main#content' ).attr( 'style', 'padding-top:'+ $('.header-version-one').height() +'px;' );

                            } else {

                                $('.header-version-one').removeClass('fixed-top fixed').removeAttr( 'style', '' );

                                $( 'main#content' ).removeAttr( 'style', '' );
                            }

                        }else{

                            if( $( window ).width() >= 991.99 ) {

                                $('.header-version-one').addClass('fixed-top fixed').attr( 'style', 'top:'+admin_bar+'px;' );

                                $( 'main#content' ).attr( 'style', 'padding-top:'+ $('.header-version-one').height() +'px;' );

                            } else {

                                $('.header-version-one').removeClass('fixed-top fixed').removeAttr( 'style', '' );

                                $( 'main#content' ).removeAttr( 'style', '' );
                            }
                        }

                    } );
                }
            }
        },

        /**
         *  4. Sticky Header Version Two
         *  ----------------------------
         */
        sticky_header_version_two: function() {

            /**
             *  Document Have Class ?
             *  ---------------------
             */
            if(  $('.header-version-two').length  ){

                var admin_bar   =   '0';

                if( $( '#wpadminbar' ).length && $( window ).width() >= 600 ){

                    admin_bar   =   $( '#wpadminbar' ).height();
                }

                /**
                 *  If Document Scroll then load script
                 *  -----------------------------------
                 */
                if( $( 'html' ).height() >= 1100 ){

                    $( window ).scroll( function() {

                        if( $(this).scrollTop() && $( window ).width() >= 991.99 ) {

                            $('.header-version-two').addClass('fixed-top fixed').attr( 'style', 'top:'+admin_bar+'px;' );

                            $( 'main#content' ).attr( 'style', 'padding-top:'+ $('.header-version-two').height() +'px;' );

                        } else {

                            $('.header-version-two').removeClass('fixed-top fixed').removeAttr( 'style', '' );

                            $( 'main#content' ).removeAttr( 'style', '' );
                        }

                    } );
                }
            }
        },

        /**
         *  5. Back To Top 
         *  --------------
         */
        back_to_top: function () {

            /**
             *  Have id ?
             *  ---------
             */
            if( $( '#back-to-top' ).length) {

                /**
                 *  Document Scroll to check condition
                 *  ----------------------------------
                 */
                $( window ).scroll( function() {

                    if( $(this).scrollTop() > 100 ) {

                        $('#back-to-top').fadeIn();

                    } else {

                        $('#back-to-top').fadeOut();
                    }

                });

                /**
                 *  If "CLICK" on button to Jump on top
                 *  -----------------------------------
                 */
                $('#back-to-top').click( function() {

                    $('body, html').animate(

                                        /**
                                         *  1. Arguments as Object
                                         *  ----------------------
                                         */
                                        { scrollTop: 0 }, 

                                        /**
                                         *  2. Speed
                                         *  --------
                                         */
                                        800
                                    );

                    return false;
                });
            }
        },

        /**
         *  6. Bootstrap Menu
         *  -----------------
         */
        mobile_device_menu: function () {

            /**
             *  Document Have Class ?
             *  ---------------------
             */
            if( $('.dropdown-menu a.dropdown-toggle').length ){

                /**
                 *  Mobile Device Script
                 *  --------------------
                 */
                $('.dropdown-menu a').on( 'click', function (e) {

                    if( !$(this).next().hasClass('show') ){

                        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                    }

                    $(this).next(".dropdown-menu").toggleClass('show');

                    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {

                        $('.dropdown-submenu .show').removeClass("show");

                    });

                    return false;
                });
            }
        },

        /**
         *  Resize Window or reload the frame
         *  ---------------------------------
         */
        weddingdir_resize_video: function (elm) {

            if (elm === undefined) {
                elm = $( 'body' );
            }

            elm.find( 'video' ).each(   function() {
                    
                // If item now invisible
                if ($( this ).hasClass( 'trx_addons_resize' ) || $( this ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
                    return;
                }

                var video     = $( this ).addClass( 'weddingdir_iframe_resize' ).eq( 0 );
                var ratio     = (video.data( 'ratio' ) !== undefined ? video.data( 'ratio' ).split( ':' ) : [16,9]);
                ratio         = ratio.length != 2 || ratio[0] == 0 || ratio[1] == 0 ? 16 / 9 : ratio[0] / ratio[1];
                var mejs_cont = video.parents( '.mejs-video' );
                var w_attr    = video.data( 'width' );
                var h_attr    = video.data( 'height' );
                if ( ! w_attr || ! h_attr) {
                    w_attr = video.attr( 'width' );
                    h_attr = video.attr( 'height' );
                    if ( ! w_attr || ! h_attr) {
                        return;
                    }
                    video.data( {'width': w_attr, 'height': h_attr} );
                }
                var percent = ('' + w_attr).substr( -1 ) == '%';
                w_attr      = parseInt( w_attr, 10 );
                h_attr      = parseInt( h_attr, 10 );
                var w_real  = Math.round(
                    mejs_cont.length > 0
                                ? Math.min( percent ? 10000 : w_attr, mejs_cont.parents( 'div,article' ).width() )
                                : Math.min( percent ? 10000 : w_attr, video.parents( 'div,article' ).width() )
                ),
                h_real      = Math.round( percent ? w_real / ratio : w_real / w_attr * h_attr );
                if (parseInt( video.attr( 'data-last-width' ), 10 ) == w_real) {
                    return;
                }
                if (percent) {
                    video.height( h_real );
                } else if (video.parents( '.wp-video-playlist' ).length > 0) {
                    if (mejs_cont.length === 0) {
                        video.attr( {'width': w_real, 'height': h_real} );
                    }
                } else {
                    video.attr( {'width': w_real, 'height': h_real} ).css( {'width': w_real + 'px', 'height': h_real + 'px'} );
                    if (mejs_cont.length > 0) {
                        gutentype_set_mejs_player_dimensions( video, w_real, h_real );
                    }
                }
                video.attr( 'data-last-width', w_real );

            } );

            elm.find( 'iframe' ).each( function() {

                // If item now invisible
                if ($( this ).hasClass( 'trx_addons_resize' ) || $( this ).addClass( 'weddingdir_iframe_resize' ).parents( 'div:hidden,section:hidden,article:hidden' ).length > 0) {
                    return;
                }
                var iframe = $( this ).eq( 0 );
                if (iframe.length == 0 || iframe.attr( 'src' ) === undefined ) { // || iframe.attr( 'src' ).indexOf( 'soundcloud' ) > 0
                    return;
                }
                var ratio  = (iframe.data( 'ratio' ) !== undefined
                        ? iframe.data( 'ratio' ).split( ':' )
                        : (iframe.parent().data( 'ratio' ) !== undefined
                            ? iframe.parent().data( 'ratio' ).split( ':' )
                            : (iframe.find( '[data-ratio]' ).length > 0
                                ? iframe.find( '[data-ratio]' ).data( 'ratio' ).split( ':' )
                                : [16,9]
                                )
                            )
                        );
                ratio      = ratio.length != 2 || ratio[0] == 0 || ratio[1] == 0 ? 16 / 9 : ratio[0] / ratio[1];
                var w_attr = iframe.attr( 'width' );
                var h_attr = iframe.attr( 'height' );
                if ( ! w_attr || ! h_attr) {
                    return;
                }
                var percent = ('' + w_attr).substr( -1 ) == '%';
                w_attr      = parseInt( w_attr, 10 );
                h_attr      = parseInt( h_attr, 10 );
                var par     = iframe.parents( 'div,section' ),
                pw          = par.width(),
                ph          = par.height(),
                w_real      = pw,
                h_real      = Math.round( percent ? w_real / ratio : w_real / w_attr * h_attr );
                if (par.css( 'position' ) == 'absolute' && h_real > ph) {
                    h_real = ph;
                    w_real = Math.round( percent ? h_real * ratio : h_real * w_attr / h_attr )
                }
                if (parseInt( iframe.attr( 'data-last-width' ), 10 ) == w_real) {
                    return;
                }
                iframe.css( {'width': w_real + 'px', 'height': h_real + 'px'} );
                iframe.attr( 'data-last-width', w_real );

            } );
        },

        /**
         *  Select Option
         *  -------------
         */
         weddingdir_select_option_default: function(){

            $( 'body' ).find( 'select:not(.weddingdir-light-select):not(.weddingdir-dark-select):not([class*="weddingdir-"])' ).each( function() {

                var s = $( this );

                if (s.css( 'display' ) != 'none' && ! s.hasClass( 'select2 form-control select2-hidden-accessible' ) ){

                    s.addClass( 'form-control' );

                    s.wrap( '<div class="select_container"></div>' );
                    // Bubble submit() up for widget "Categories"
                    if ( s.parents( '.widget_categories' ).length > 0 ) {
                        s.parent().get(0).submit = function() {
                            jQuery(this).closest('form').submit();
                        };
                    }
                }

            } );
         },

        /**
         *  9. Multilevel Thread Menu
         *  -------------------------
         */
        weddingdir_multi_level_menu: function(){

            if( $('ul.navbar-nav a.dropdown-toggle, ul.dropdown-menu .dropdown > a').length ){

                $('ul.navbar-nav a.dropdown-toggle, ul.dropdown-menu .dropdown > a').on('click', function(event) {

                    /**
                     *  Avoid following the href location when clicking
                     *  -----------------------------------------------
                     *  Avoid having the menu to close when clicking
                     *  --------------------------------------------
                     */
                    event.preventDefault();

                    event.stopPropagation();
                    
                    /**
                     *  find parent element (<li> tag)
                     *  ------------------------------
                     */
                    $(this).parent().parent().find('li.dropdown').not($(this).parent()).removeClass('show');

                    $(this).parent().toggleClass('show');

                    $(this).next( '.dropdown-menu' ).toggleClass('show');

                } );
            }
        },

        /**
         *  Load Script
         *  -----------
         */
        init: function (){

            /**
             *  2. Blog Post ( Gallery ) Carousel
             *  ---------------------------------
             */
            this.blog_post_type_slider();

            /**
             *  3. Sticky Header Version One
             *  ----------------------------
             */
            this.sticky_header_version_one();

            /**
             *  4. Sticky Header Version Two
             *  ----------------------------
             */
            this.sticky_header_version_two();

            /**
             *  5. Back To Top
             *  --------------
             */
            this.back_to_top();

            /**
             *  6. Bootstrap Menu
             *  -----------------
             */
            this.mobile_device_menu();

            /**
             *  7. iFrame resize
             *  ----------------
             */
            this.weddingdir_resize_video();

            /**
             *  8. Default Select Option
             *  ------------------------
             */
            this.weddingdir_select_option_default();

            /**
             *  9. Multilevel Thread Menu
             *  -------------------------
             */
            this.weddingdir_multi_level_menu();
        }
    }

    /**
     *  Document ready function
     *  -----------------------
     */
    $( document ).ready( function(){

        /**
         *  Read Object File
         *  ----------------
         */
        WeddingDir_Theme_Setup.init();

    } );

    /**
     *  Document Resize handlers
     *  ------------------------
     */
    $( window ).resize( function() {

        /**
         *  3. Sticky Header Version One
         *  ----------------------------
         */
        WeddingDir_Theme_Setup.sticky_header_version_one();

        /**
         *  4. Sticky Header Version Two
         *  ----------------------------
         */
        WeddingDir_Theme_Setup.sticky_header_version_two();

        /**
         *  7. iFrame resize
         *  ----------------
         */
        WeddingDir_Theme_Setup.weddingdir_resize_video();
        
    } );

    /**
     *   Website Loader / Loading...
     *   ---------------------------
     */
    $( window ).on( 'load', function() {

        if( $( '.preloader' ).length ){

            $( '.status' ).fadeOut();

            $( '.preloader' ).delay( 350 ).fadeOut( 'slow' );
        }

    } );

})(jQuery);