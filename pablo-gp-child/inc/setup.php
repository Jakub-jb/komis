<?php
/**
 * Theme setup.
 *
 * @package pablo-gp
 */

define( 'PABLO_GP_TEXTDOMAIN', 'pablo-gp' );

if ( ! function_exists( 'pablo_gp_setup' ) ) {
/**
 * Setup theme defaults.
 */
function pablo_gp_setup() {
load_child_theme_textdomain( PABLO_GP_TEXTDOMAIN, PABLO_GP_PATH . 'languages' );

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'customize-selective-refresh-widgets' );
add_theme_support( 'editor-styles' );
add_editor_style( [ 'style.css', 'assets/css/base.css', 'assets/css/components.css' ] );
add_theme_support( 'align-wide' );
add_theme_support( 'custom-spacing' );
add_theme_support( 'custom-units' );
add_theme_support( 'wp-block-styles' );
add_theme_support( 'custom-logo', [
'height'      => 120,
'width'       => 320,
'flex-height' => true,
'flex-width'  => true,
'unlink-homepage-logo' => true,
] );

register_sidebar(
[
'name'          => __( 'Haupt Sidebar', PABLO_GP_TEXTDOMAIN ),
'id'            => 'sidebar-1',
'before_widget' => '<section class="widget" aria-labelledby="widget-%1$s">',
'after_widget'  => '</section>',
'before_title'  => '<h2 class="widget__title">',
'after_title'   => '</h2>',
]
);

register_sidebar(
[
'name'          => __( 'Footer Column 1', PABLO_GP_TEXTDOMAIN ),
'id'            => 'footer-1',
'before_widget' => '<section class="footer__widget" aria-labelledby="footer-widget-1">',
'after_widget'  => '</section>',
'before_title'  => '<h2 class="footer__widget-title" id="footer-widget-1">',
'after_title'   => '</h2>',
]
);

register_sidebar(
[
'name'          => __( 'Footer Column 2', PABLO_GP_TEXTDOMAIN ),
'id'            => 'footer-2',
'before_widget' => '<section class="footer__widget" aria-labelledby="footer-widget-2">',
'after_widget'  => '</section>',
'before_title'  => '<h2 class="footer__widget-title" id="footer-widget-2">',
'after_title'   => '</h2>',
]
);
}
}
add_action( 'after_setup_theme', 'pablo_gp_setup', 5 );

/**
 * Register custom image sizes in media modal.
 *
 * @param array $sizes Sizes.
 *
 * @return array
 */
function pablo_gp_custom_sizes( $sizes ) {
return array_merge(
$sizes,
[
'pablo-vehicle-card'  => __( 'Vehicle Card (480x320)', PABLO_GP_TEXTDOMAIN ),
'pablo-service-card'  => __( 'Service Card (600x400)', PABLO_GP_TEXTDOMAIN ),
]
);
}
add_filter( 'image_size_names_choose', 'pablo_gp_custom_sizes' );
