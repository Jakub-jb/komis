<?php
/**
 * Pablo Abschleppdienst Child Theme functions.
 *
 * @package pablo-gp
 */

define( 'PABLO_GP_VERSION', '1.0.0' );

define( 'PABLO_GP_PATH', trailingslashit( get_stylesheet_directory() ) );

define( 'PABLO_GP_URI', trailingslashit( get_stylesheet_directory_uri() ) );

$autoload_files = [
'inc/setup.php',
'inc/schema.php',
'inc/breadcrumbs.php',
'inc/shortcodes.php',
'inc/blocks.php',
'inc/seo.php',
'inc/cpt-vehicles.php',
'inc/taxonomies.php',
'inc/forms.php',
];

foreach ( $autoload_files as $file ) {
require_once PABLO_GP_PATH . $file;
}

/**
 * Enqueue front-end assets.
 */
function pablo_gp_enqueue_assets() {
$deps = [ 'wp-block-library', 'wp-dom-ready', 'wp-a11y' ];

wp_enqueue_style(
'pablo-gp-base',
PABLO_GP_URI . 'assets/css/base.css',
[],
PABLO_GP_VERSION
);

wp_enqueue_style(
'pablo-gp-components',
PABLO_GP_URI . 'assets/css/components.css',
[ 'pablo-gp-base' ],
PABLO_GP_VERSION
);

wp_enqueue_style(
'pablo-gp-utilities',
PABLO_GP_URI . 'assets/css/utilities.css',
[ 'pablo-gp-components' ],
PABLO_GP_VERSION
);

wp_enqueue_script(
'pablo-gp-ui',
PABLO_GP_URI . 'assets/js/ui.js',
$deps,
PABLO_GP_VERSION,
true
);

wp_enqueue_script(
'pablo-gp-menu',
PABLO_GP_URI . 'assets/js/menu.js',
[ 'pablo-gp-ui' ],
PABLO_GP_VERSION,
true
);

wp_enqueue_script(
'pablo-gp-forms',
PABLO_GP_URI . 'assets/js/forms.js',
[ 'pablo-gp-ui' ],
PABLO_GP_VERSION,
true
);

wp_enqueue_script(
'pablo-gp-gtm',
PABLO_GP_URI . 'assets/js/gtm-dataLayer.js',
[],
PABLO_GP_VERSION,
true
);

wp_add_inline_style( 'pablo-gp-base', pablo_gp_get_critical_css() );
}
add_action( 'wp_enqueue_scripts', 'pablo_gp_enqueue_assets', 20 );

/**
 * Editor assets.
 */
function pablo_gp_block_editor_assets() {
wp_enqueue_style(
'pablo-gp-editor',
PABLO_GP_URI . 'assets/css/base.css',
[],
PABLO_GP_VERSION
);
wp_enqueue_style(
'pablo-gp-editor-components',
PABLO_GP_URI . 'assets/css/components.css',
[ 'pablo-gp-editor' ],
PABLO_GP_VERSION
);
}
add_action( 'enqueue_block_editor_assets', 'pablo_gp_block_editor_assets' );

/**
 * Critical CSS for above-the-fold sections (hero/nav).
 *
 * @return string
 */
function pablo_gp_get_critical_css() {
return 'html{scroll-behavior:smooth}body{background:var(--gray-100);color:var(--gray-900);}header.site-header{background:rgba(255,255,255,0.95);backdrop-filter:saturate(1.1) blur(6px);box-shadow:var(--shadow-sm);}a.skip-link{position:absolute;left:-999px;top:auto;width:1px;height:1px;overflow:hidden;}a.skip-link:focus{left:16px;top:16px;width:auto;height:auto;padding:12px 16px;background:var(--brand-navy);color:#fff;border-radius:var(--radius);z-index:10000;}';
}

/**
 * Register menu locations.
 */
function pablo_gp_register_menus() {
register_nav_menus(
[
'primary'   => __( 'Primary Menu', 'pablo-gp' ),
'footer'    => __( 'Footer Menu', 'pablo-gp' ),
'legal'     => __( 'Legal Menu', 'pablo-gp' ),
]
);
}
add_action( 'after_setup_theme', 'pablo_gp_register_menus' );

/**
 * Custom image sizes.
 */
function pablo_gp_image_sizes() {
add_image_size( 'pablo-vehicle-card', 480, 320, true );
add_image_size( 'pablo-service-card', 600, 400, true );
}
add_action( 'after_setup_theme', 'pablo_gp_image_sizes' );

/**
 * Disable comments on attachments by default.
 */
add_filter( 'comments_open', function( $open, $post_id ) {
$post = get_post( $post_id );
if ( $post && 'attachment' === $post->post_type ) {
return false;
}
return $open;
}, 10, 2 );

/**
 * Helper to get theme asset path.
 *
 * @param string $path Relative path.
 *
 * @return string
 */
function pablo_gp_asset( $path ) {
return trailingslashit( PABLO_GP_URI ) . ltrim( $path, '/' );
}
