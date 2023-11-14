<?php
/**
 *   -------------------------------
 *   WeddingDir - Header Version One
 *   -------------------------------
 */
?><header itemtype="https://schema.org/WPHeader" itemscope="itemscope" id="masthead"><?php

        /**
         *  WeddingDir - Header Version One ( Top Left Sidebar Bar Data )
         *  -------------------------------------------------------------
         */
        $_condition_1   =   WeddingDir_Header:: header_one_have_left_side_data();

        /**
         *  WeddingDir - Header Version One ( Top Right Sidebar Bar Data )
         *  --------------------------------------------------------------
         */
        $_condition_2   =   WeddingDir_Header:: header_one_have_right_side_data();

        /**
         *  Make sure : Setting Option have switch on top navigation
         *  --------------------------------------------------------
         */
        $_condition_3   =   weddingdir_option( 'header_one_top_navigation_condition' ) == esc_attr( 'on' );

        /**
         *  Have Top Bar Data ?
         *  -------------------
         */
        if( ( $_condition_1 || $_condition_2 ) && $_condition_3 ){

            /**
             *  Load Header Version One Top bar Data
             *  ------------------------------------
             */
            printf(    '<div class="top-bar-stripe">

                            <div class="container px-md-0">

                                <div class="row align-items-center">

                                    %1$s <!-- Have Left Side Data ? -->

                                    %2$s <!-- Have Right Side Data ? -->

                                </div>

                            </div>

                        </div>',

                        /**
                         *  1. Have Header Version One Top Left Side Data ?
                         *  -----------------------------------------------
                         */
                        WeddingDir:: _have_data( $_condition_1 )

                        ?   $_condition_1

                        :   '',

                        /**
                         *  2. Have Header Version One Top Right Side Data ?
                         *  ------------------------------------------------
                         */
                        WeddingDir:: _have_data( $_condition_2 )

                        ?   $_condition_2

                        :   ''
            );
        }

    ?>

    <!-- Main Navigation Start -->
    <div class="header-version-one">
        <nav class="header-anim navbar navbar-expand-lg">

            <div class="container text-nowrap bdr-nav px-0">

                <?php

                    /**
                     *    Load WeddingDir - Header Data
                     *    -----------------------------
                     */
                    do_action( 'weddingdir_header_version', array(

                        'layout'        =>      absint( '1' )

                    ) );

                ?>

            </div>

        </nav>
    </div>
    <!-- Main Navigation End -->

</header><!-- #masthead -->