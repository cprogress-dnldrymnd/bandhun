<?php
/**
 *  WeddingDir - Theme Header Template
 *  ----------------------------------
 *  @link - https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *  ---------------------------------------------------------------------------------------
 */
?>
<!DOCTYPE html>

<?php do_action( 'weddingdir_html_before' ); ?>

<html <?php language_attributes(); ?>>

  <head><?php do_action( 'weddingdir_head' ); wp_head(); ?></head>

  <body <?php do_action( 'weddingdir_body' ); ?>>

  <?php wp_body_open(); ?>

  <div id="page" class="site">

      <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'weddingdir' ); ?></a>
      
      <?php

      if( ! is_singular( 'website' ) ){

          /**
           *  WeddingDir - Header Actions
           *  ---------------------------
           */
          do_action( 'weddingdir_header' );

          /**
           *  WeddingDir - Before Content Load Actions
           *  ----------------------------------------
           */
          do_action( 'weddingdir_content_before' );
      }

      ?>
      <main id="content" class="site-content">