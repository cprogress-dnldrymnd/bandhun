<?php
/**
 *   -------------------------------
 *   WeddingDir - Header Version Two
 *   -------------------------------  
 */
?><header itemtype="https://schema.org/WPHeader" itemscope="itemscope" id="masthead">

    <!-- Main Navigation Start -->
    <div class="header-version-two">
        <nav class="header-anim navbar navbar-expand-lg">
            <div class="container-fluid text-nowrap bdr-nav px-0">

                <?php

                    /**
                     *    Load WeddingDir - Header Data
                     *    -----------------------------
                     */
                    do_action( 'weddingdir_header_version', array(

                        'layout'        =>      absint( '2' )

                    ) );

                ?>

            </div>
        </nav>
    </div>
    <!-- Main Navigation End -->

</header><!-- #masthead -->