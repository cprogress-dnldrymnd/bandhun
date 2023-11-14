<?php
/**
 *  ------------------------------------
 *  WeddingDir - 404 Error Page Template
 *  ------------------------------------
 *   
 *  WeddingDir - Header
 *  -------------------
 */
get_header();  ?>

    <!-- Error Page Start -->
    <section class="wide-tb-90">

        <div class="container">

            <div class="row">

                <div class="col-lg-7 mx-auto col-md-8">

                    <div class="text-center">
                    <?php

                        /**
                         *  1. 404 Error Content
                         *  --------------------
                         */
                        do_action( 'weddingdir/404-error/content', [

                            'layout'        =>      absint( '1' )

                        ] );

                    ?>
                    </div>

                </div>

            </div>
            
        </div>

    </section>
    <!-- Error Page End -->

<?php 

/**
 *  WeddingDir - Footer
 *  -------------------
 */
get_footer(); ?>