<?php
/**
 * Header template.
 *
 * @package pablo-gp
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php esc_html_e( 'Zum Inhalt springen', 'pablo-gp' ); ?></a>
<div class="site">
<header class="site-header" role="banner">
<div class="site-header__inner">
<div class="site-branding">
<?php if ( has_custom_logo() ) : ?>
<?php the_custom_logo(); ?>
<?php else : ?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
<?php endif; ?>
</div>
<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-menu" data-nav-toggle>
<span class="screen-reader-text"><?php esc_html_e( 'Menü öffnen', 'pablo-gp' ); ?></span>
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="18" x2="21" y2="18" /></svg>
</button>
<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Hauptnavigation', 'pablo-gp' ); ?>" data-primary-nav>
<?php
wp_nav_menu(
[
'theme_location' => 'primary',
'menu_id'        => 'primary-menu',
'menu_class'     => 'primary-nav__list',
'container'      => false,
'link_before'    => '<span class="primary-nav__link-text">',
'link_after'     => '</span>',
'fallback_cb'    => false,
]
);
?>
<a class="btn btn--accent" href="tel:+436641261735" data-gtm="nav-call"><?php esc_html_e( 'Jetzt anrufen (24/7)', 'pablo-gp' ); ?></a>
</nav>
</div>
</header>
<a class="mobile-call" href="tel:+436641261735" data-gtm="mobile-call"><?php esc_html_e( 'Jetzt anrufen (24/7)', 'pablo-gp' ); ?></a>
<main id="content" class="site-main" role="main">
