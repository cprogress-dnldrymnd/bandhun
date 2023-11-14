<?php
/**
 *   WeddingDir - The sidebar containing the main widget area
 *   --------------------------------------------------------
 */

$_have_sidebar_id   =   esc_attr( WeddingDir_Grid_Managment:: weddingdir_sidebar() );

/**
 *  Have Data ?
 *  -----------
 */
if( WeddingDir:: _have_data( $_have_sidebar_id ) ){  ?>

    <aside itemtype="https://schema.org/WPSideBar" itemscope="itemscope" <?php do_action( 'weddingdir_get_sidebar_class' ); ?> id="secondary">
        <?php 

            /**
             *  Load Sidebar Widget
             *  -------------------
             */
            dynamic_sidebar( 

                /**
                 *  Widget ID
                 *  ---------
                 */
                esc_attr( $_have_sidebar_id )
            ); 

        ?>
    </aside>
    <?php
}